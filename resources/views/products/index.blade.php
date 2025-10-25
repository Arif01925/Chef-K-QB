@extends('layouts.app')

@section('content')
<div class="container">
    <h2>All Products</h2>
    <a href="{{ url('/products/create') }}" class="btn btn-success mb-3">Add New Product</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: 5%;">Sl No.</th>
                <th>Name</th>
                <th>SKU</th>
                <th>Photo</th>
                <th style="width: 10%;">Price</th>
                <th style="width: 10%;">Unit</th>
                <th class="text-center" style="width: 15%;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $index => $product)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>
                        @php
                            $path = $product->photo;
                            // normalize: remove any leading "public/" and leading slash
                            $normalized = $path ? ltrim(preg_replace('#^public/#','', $path), '/') : null;
                            $src = $normalized ? asset($normalized) : asset('images/default-product.png');
                        @endphp
                        <img src="{{ $src }}" alt="Product Image" width="60" height="60" style="object-fit:cover;border-radius:6px;">
                    </td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->unit }}</td>
                    <td class="text-center">
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure to delete this product?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
