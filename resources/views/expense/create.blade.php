from pathlib import Path

# Expense form HTML blade template content
expense_create_blade = """
@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Add New Expense</h2>
    <form action="{{ route('expense.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="purpose" class="form-label">Purpose</label>
            <input type="text" name="purpose" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="amount" class="form-label">Amount ($)</label>
            <input type="number" step="0.01" name="amount" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="spent_at" class="form-label">Spent At</label>
            <input type="date" name="spent_at" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-danger">Save Expense</button>
        <a href="{{ route('expense.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
"""

# Save to file
file_path = "/mnt/data/create_expense_blade.php"
Path(file_path).write_text(expense_create_blade.strip())

file_path
