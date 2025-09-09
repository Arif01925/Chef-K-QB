@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Employee</h1>

    <form action="{{ route('employees.update', $employee->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" value="{{ $employee->name }}" required>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <input type="text" name="role" class="form-control" value="{{ $employee->role }}">
        </div>

        <div class="mb-3">
            <label for="department" class="form-label">Department</label>
            <input type="text" name="department" class="form-control" value="{{ $employee->department }}">
        </div>

        <div class="mb-3">
            <label for="hourly_rate" class="form-label">Hourly Rate</label>
            <input type="number" step="0.01" name="hourly_rate" class="form-control" value="{{ $employee->hourly_rate }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('employees.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
