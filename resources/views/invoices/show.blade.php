@extends('layouts.app')

@section('content')
<div class="container my-5 bg-white p-4 rounded shadow">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary">Chef K, Inc.</h2>
            <p class="mb-0">accounting.chefkproduct.com</p>
        </div>
        <div class="text-end">
            <h4 class="text-uppercase text-warning">INVOICE</h4>
            <p class="mb-0">INV - {{ $invoice->id }}</p>
        </div>
    </div>

    <!-- Customer Info -->
    <div class="mb-4">
        <h5>Invoice To:</h5>
        <p class="mb-0 fw-bold">{{ $invoice->customer_name }}</p>
        @if($invoice->customer_email)<p class="mb-0">{{ $invoice->customer_email }}</p>@endif
        @if($invoice->customer_address)<p>{{ $invoice->customer_address }}</p>@endif
    </div>

    <!-- Table -->
    <table class="table table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>Sl No</th>
                <th>Description</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    <strong>{{ $item->name }}</strong><br>
                    <small>{{ $item->description }}</small>
                </td>
                <td>${{ number_format($item->price, 2) }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totals -->
    <div class="row">
        <div class="col-md-6">
            <h5 class="mb-3">Payment Method & Status</h5>
            <p>
                <strong>Status:</strong>
                @if($invoice->status === 'Paid')
                    <span class="badge bg-success">Paid</span>
                    <br>
                    <strong>Method:</strong> {{ $invoice->payment_method }}
                @else
                    <span class="badge bg-danger">Unpaid</span>
                @endif
            </p>
        </div>
        <div class="col-md-6 text-end">
            <table class="table">
                <tr>
                    <th>Subtotal:</th>
                    <td>${{ number_format($invoice->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <th>Tax:</th>
                    <td>${{ number_format($invoice->tax, 2) }}</td>
                </tr>
                <tr>
                    <th class="text-primary fs-5">Total Due:</th>
                    <td class="fs-5 text-primary">${{ number_format($invoice->total, 2) }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <div class="text-center mt-5">
        <p class="fw-bold fs-4">Thank you!</p>
        <small>Chef K, Inc. — “Just the way we brew it.”</small>
    </div>
</div>
@endsection
