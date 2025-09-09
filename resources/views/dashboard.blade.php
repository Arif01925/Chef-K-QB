@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Page Title -->
    <h1 class="mb-5 text-center fw-bold "> Chef K Accounting Dashboard </h1>
    
    <!-- Summary Cards + Action Buttons (even layout) -->
    <div class="row text-center mb-5 gx-4">
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-success">
                <div class="card-body">
                    <h5 class="card-title text-success">Total Income</h5>
                    <p class="display-6">${{ number_format($totalIncome, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-danger">
                <div class="card-body">
                    <h5 class="card-title text-danger">Total Expenses</h5>
                    <p class="display-6">${{ number_format($totalExpense, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-primary">
                <div class="card-body">
                    <h5 class="card-title text-primary">Net Profit</h5>
                    <p class="display-6">${{ number_format($netProfit, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="d-flex flex-column gap-2">
                <a href="/invoices/create" class="btn fw-bold w-100 text-white" style="background: linear-gradient(to right, #434343, #000000);">Create Invoice</a>
                <a href="/income/create" class="btn fw-bold w-100 text-white" style="background: linear-gradient(to right, #28a745, #218838);">New Income</a>
                <a href="/expense/create" class="btn fw-bold w-100 text-white" style="background: linear-gradient(to right, #dc3545, #c82333);">New Expenses</a>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="row mb-5">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Recent Incomes</h5>
                    <ul class="list-group">
                        @foreach($recentIncomes as $income)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $income->source }}
                                <span>${{ number_format($income->amount, 2) }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Recent Expenses</h5>
                    <ul class="list-group">
                        @foreach($recentExpenses as $expense)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $expense->category }}
                                <span>${{ number_format($expense->amount, 2) }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Inventory Summary -->
    <div class="card mb-5 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Inventory</h5>
            <table class="table table-bordered table-striped mb-0">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Value ($)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inventories as $item)
                        <tr>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ $item->stock_quantity }}</td>
                            <td>${{ number_format($item->stock_quantity * $item->unit_price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
