@extends('layouts.app')

@section('content')
    <h2 class="mb-4">Add New Expense</h2>

    <form action="{{ route('expense.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Category</label>
            <input type="text" name="category" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Amount ($)</label>
            <input type="number" step="0.01" name="amount" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Spent At</label>
            <input type="date" name="spent_at" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-danger">Save Expense</button>
        <a href="/dashboard" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
