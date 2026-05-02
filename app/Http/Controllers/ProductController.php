<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::with('category')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('brand', 'like', "%{$search}%");
                });
            })
            ->when($request->category, function ($query, $slug) {
                $query->whereHas('category', function ($q) use ($slug) {
                    $q->where('slug', $slug);
                });
            })
            ->latest()
            ->paginate(10);

        $categories = Category::query()
            ->when($request->category_search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10, ['*'], 'categories_page');

        $categoriesForFilter = Category::pluck('name', 'slug');
        $categoriesForForm = Category::pluck('name', 'id');

        return view('manager.product', [
            'products' => $products,
            'categories' => $categories,
            'categoriesForForm' => $categoriesForForm,
            'categoriesForFilter' => $categoriesForFilter
        ]);
    }

    /** 
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        // validate with the StoreProductRequestClass
        $data = $request->validated();

        // store in public storage
        $imagePath = $request->file('product_image_url')->store('products', 'public');
        $data['product_image_url'] = $imagePath;

        Product::create($data);

        return redirect()->to('/products')->with('success', 'Product Created Successfullly');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, int $id)
    {
        $data = $request->validated();

        $product = Product::findOrFail($id);

        if ($request->hasFile('product_image_url')) {
            if ($product->product_image_url && Storage::disk('public')->exists($product->product_image_url)) {
                Storage::disk('public')->delete($product->product_image_url);
            }
            $imagePath = $request->file('product_image_url')->store('products', 'public');
            $data['product_image_url'] = $imagePath;
        }

        $product->update($data);

        return back()->with('success', "Product {$product->name} edited successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $product = Product::withCount('warranties')
            ->findOrFail($id);

        if ($product->warranties_count > 0) {
            return back()->with('error', "Cannot delete {$product->name}. It has active warranty records.");
        }

        // delete image if exists
        if ($product->product_image_url && Storage::disk('public')->exists($product->product_image_url)) {
            Storage::disk('public')->delete($product->product_image_url);
        }

        $productName = $product->name;

        $product->delete();

        return back()->with('success', "Product {$productName} deleted successfully");
    }

    public function storeCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255']
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator, 'category')
                ->withInput();
        }

        $data = $validator->validated();
        // create a slug
        $data['slug'] = Str::slug($data['name']);
        $category = Category::create($data);

        return back()->with('success', 'Category ' . $category['name'] . ' created');
    }

    public function updateCategory(Request $request, int $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255']
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->save();

        return redirect()
            ->back()
            ->with('success', 'Category updated successfully.');
    }

    public function destroyCategory(int $id)
    {
        $category = Category::findOrFail($id);

        if ($category->product()->count() > 0) {
            return back()->with('error', 'Cannot delete category with existing products.');
        }

        // delete if passed validation
        $category->delete();

        return redirect()
            ->back()
            ->with('success', 'Category deleted successfully.');
    }
}
