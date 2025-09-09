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
                        @if($product->photo)
                            <img src="{{ asset('uploads/products/' . $product->photo) }}" width="60" alt="Product Image">
                        @else
                            <span class="text-muted">No image</span>
                        @endif
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
