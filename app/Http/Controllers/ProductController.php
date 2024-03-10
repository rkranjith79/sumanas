<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('id', 'Desc')->get();
        return view('product.index', compact('products'));
    }

    public function listing()
    {
        $products = Product::orderBy('name', 'Asc')->get();
        return view('product.listing', compact('products'));
    }
    
    public function create()
    {
        return view('product.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:150',
            'price' => 'required|numeric|min:0.01|max:1000',
            'description' => 'nullable|string|max:500',
        ]);

        $product = Product::create($validatedData)->syncWithStripe();
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

   
    public function edit(Product $product)
    {
        return view('product.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:150', Rule::unique('products')->ignore($product->id)],
            'price' => 'required|numeric|min:0.01|max:1000',
            'description' => 'nullable|string|max:500',
        ]);

        $product->update($validatedData);
        $product->syncWithStripe();
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');

    }

    public function destroy(Product $product)
    {
        // Delete the product from the database
    }

}
