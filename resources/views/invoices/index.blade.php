@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center fw-bold mb-5">All Invoices</h1>

    <table class="table table-bordered text-center">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Date</th>
                <th>Subtotal</th>
                <th>Tax</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->id }}</td>
                    <td>{{ $invoice->customer_name }}</td>
                    <td>{{ $invoice->invoice_date }}</td>
                    <td>${{ number_format($invoice->subtotal, 2) }}</td>
                    <td>${{ number_format($invoice->tax, 2) }}</td>
                    <td>${{ number_format($invoice->total, 2) }}</td>
                    <td>
                        <a href="{{ url('/invoices/' . $invoice->id) }}" class="btn btn-sm btn-primary mb-1">View</a>
                        <a href="{{ url('/invoices/' . $invoice->id . '/edit') }}" class="btn btn-sm btn-warning mb-1">Edit</a>
                        <form action="{{ url('/invoices/' . $invoice->id) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
