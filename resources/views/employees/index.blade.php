@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Employee List</h1>


    @if (session('success'))
        <div id="flash-message" class="alert alert-success position-fixed top-0 end-0 m-4 shadow" style="z-index: 9999; min-width: 250px;">
            <strong>{{ session('success') }}</strong>
            <div class="progress mt-2" style="height: 4px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: 100%; animation: progressOut 3s linear;"></div>
            </div>
        </div>
        <style>
            @keyframes progressOut {
                from { width: 100%; }
                to { width: 0%; }
            }
        </style>
        <script>
            setTimeout(() => {
                const flash = document.getElementById('flash-message');
                if (flash) {
                    flash.style.transition = "opacity 0.5s ease";
                    flash.style.opacity = "0";
                    setTimeout(() => flash.remove(), 500);
                }
            }, 3000);
        </script>
    @endif

    <a href="{{ route('employees.create') }}" class="btn btn-primary mb-3">Add New Employee</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Role</th>
                <th>Department</th>
                <th>Hourly Rate</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($employees as $index => $employee)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->role }}</td>
                    <td>{{ $employee->department }}</td>
                    <td>${{ number_format($employee->hourly_rate, 2) }}</td>
                    <td>
                        <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-sm btn-info">Edit</a>
                        <a href="{{ route('employees.delete', $employee->id) }}" class="btn btn-sm btn-danger"
                           onclick="return confirm('Are you sure you want to delete this employee?')">Delete</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No employees found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
