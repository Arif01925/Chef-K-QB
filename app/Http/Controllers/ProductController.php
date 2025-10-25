<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:products',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png',
            'price' => 'required|numeric',
            'unit' => 'required|string|max:50',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            $dir = public_path('images/products');
            if (!is_dir($dir)) { mkdir($dir, 0755, true); }
            $ext = $request->file('photo')->getClientOriginalExtension();
            $base = Str::slug($request->input('name', 'product'));
            $filename = $base . '.' . $ext;
            $request->file('photo')->move($dir, $filename);
            $data['photo'] = 'images/products/' . $filename;
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'sku' => 'required',
            'price' => 'required|numeric',
            'unit' => 'required'
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            $dir = public_path('images/products');
            if (!is_dir($dir)) { mkdir($dir, 0755, true); }
            $ext = $request->file('photo')->getClientOriginalExtension();
            $base = Str::slug($request->input('name', 'product'));
            $filename = $base . '.' . $ext;
            // delete old file if present
            if (!empty($product->photo) && file_exists(public_path(ltrim(preg_replace('#^public/#','',$product->photo), '/')))) {
                @unlink(public_path(ltrim(preg_replace('#^public/#','',$product->photo), '/')));
            }
            $request->file('photo')->move($dir, $filename);
            $data['photo'] = 'images/products/' . $filename;
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}
