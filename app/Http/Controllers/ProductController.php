<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('manager.product', [
            'products' => Product::all()
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

            // delete old image
            if ($product->product_image_url && Storage::disk('public')->exists($product->product_image_url)) {
                Storage::disk('public')->delete($product->product_image_url);

                // upload the new image and save a path
                $imagePath = $request->file('product_image_url')->store('products', 'public');

                $data['product_image_url'] = $imagePath;
            }
        }

        $product->update($data);

        return back()->with('success', "Product {$product->name} edited successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id']
        ]);

        $product = Product::findOrFail($request->product_id);

        // delete image if exists
        if ($product->product_image_url && Storage::disk('public')->exists($product->product_image_url)) {
            Storage::disk('public')->delete($product->product_image_url);
        }

        $productName = $product->name;

        $product->delete();

        return back()->with('success', "Product {$productName} deleted successfully");
    }
}
