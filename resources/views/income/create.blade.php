@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Add New Income</h2>
    <form method="POST" action="{{ route('income.store') }}">
        @csrf
        <div class="mb-3">
            <label for="source" class="form-label">Source</label>
            <input type="text" class="form-control" id="source" name="source" required>
        </div>
        <div class="mb-3">
            <label for="amount" class="form-label">Amount ($)</label>
            <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
        </div>
        <div class="mb-3">
            <label for="received_at" class="form-label">Received At</label>
            <input type="date" class="form-control" id="received_at" name="received_at" required>
        </div>
        <button type="submit" class="btn btn-success">Save Income</button>
        <a href="{{ url('/income') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
