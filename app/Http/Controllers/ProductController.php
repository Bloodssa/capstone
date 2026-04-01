<?php

namespace App\Http\Controllers;

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
    public function store(Request $request)
    {
        $data = $this->validateProduct($request, 'store');

        // store in public storage
        $imagePath = $request->file('product_image_url')->store('products', 'public');
        $data['product_image_url'] = $imagePath;

        $product = Product::create($data);

        return redirect()->to('/products')->with('productAdded', 'Product Created Successfullly');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data = $this->validateProduct($request, 'update');

        $product = Product::findOrFail($data['product_id']);

        if ($request->hasFile('product_image_url')) {

            // delete old image
            if ($product->product_image_url && Storage::disk('public')->exists($product->product_image_url)) {
                Storage::disk('public')->delete($product->product_image_url);
            }

            // upload the new image and save a path
            $imagePath = $request->file('product_image_url')->store('products', 'public');

            $data['product_image_url'] = $imagePath;
        }

        // remove product id to the update payload
        unset($data['product_id']);

        $product->update($data);

        return back()->with('success', 'Product ' . $product->name . ' edited successfully');
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

        return back()->with('success', 'Product ' . $productName ?? '' . ' deleted successfully');
    }

    /**
     * @param Request validate submit request for the product
     * @param string type of the action for the image url
     */
    private function validateProduct(Request $request, string $type): array
    {
        $rules = [
            'name' => ['required', 'string'],
            'category' => ['required', 'string'],
            'brand' => ['required', 'string'],
            'warranty_duration' => ['required', 'integer', 'min:0', 'max:200'],
            'service_center_name' => ['required', 'string'],
            'service_center_address' => ['required', 'string'],
        ];

        if ($type === 'store') {
            $rules['product_image_url'] = ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'];
        }

        if ($type === 'update') {
            $rules['product_id'] = ['required', 'exists:products,id'];
            $rules['product_image_url'] = ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'];
        }

        return $request->validate($rules);
    }
}
