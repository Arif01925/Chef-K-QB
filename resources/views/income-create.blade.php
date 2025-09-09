@extends('layouts.app')

@section('content')
    <h2 class="mb-4">Add New Income</h2>

    <form action="{{ route('income.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Source</label>
            <input type="text" name="source" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Amount ($)</label>
            <input type="number" step="0.01" name="amount" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Received At</label>
            <input type="date" name="received_at" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Save Income</button>
        <a href="/dashboard" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
