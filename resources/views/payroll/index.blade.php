@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Employee Attendance & Payroll</h1>

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


    <form action="{{ route('payroll.store') }}" method="POST" class="mb-4">
        @csrf

        <div class="mb-3">
            <label for="employee_id" class="form-label">Select Employee</label>
            <select name="employee_id" class="form-control" required>
                <option value="">-- Choose --</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}">
    {{ $employee->name }}
    @php
        $details = [];
        if ($employee->role) $details[] = $employee->role;
        if ($employee->department) $details[] = $employee->department;
    @endphp
    {{ count($details) ? ' (' . implode(', ', $details) . ')' : '' }}
</option>

                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="work_date" class="form-label">Work Date</label>
            <input type="date" name="work_date" class="form-control" required>
        </div>

       <div class="row mb-3">
            <div class="col-md-6">
            <label for="in_time" class="form-label">In Time</label>
            <input type="time" name="in_time" class="form-control"></div>
            <div class="col-md-6">
            <label for="out_time" class="form-label">Out Time</label>
            <input type="time" name="out_time" class="form-control"></div>
        </div>


        <button type="submit" class="btn btn-primary">Save Attendance</button>
    </form>

    <hr class="my-4">

    <h2 class="mb-3">Recent Attendance </h2>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                
                <th>Employee</th>
                <th>Date</th>
                <th>In</th>
                <th>Out</th>
                <th>Hours</th>
                <th>Rate</th>
                <th>Daily Pay</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $index => $entry)
            <tr>
                <td>{{ $entry->employee->name }}</td>
                <td>{{ $entry->work_date }}</td>
                <td>{{ $entry->in_time ? \Carbon\Carbon::parse($entry->in_time)->format('h:i A') : 'N/A' }}</td>
                <td>{{ $entry->out_time ? \Carbon\Carbon::parse($entry->out_time)->format('h:i A') : 'N/A' }}</td>
                <td>{{ $entry->total_hours }}</td>
                <td>${{ $entry->hourly_rate }}</td>
                <td>${{ number_format($entry->total_hours * $entry->hourly_rate, 2) }}</td>
                <td>{{ $entry->status }}</td>
                <td>
                    <a href="{{ route('payroll.edit', $entry->id) }}" class="btn btn-sm btn-info mb-1">Edit</a>
                    <a href="{{ route('payroll.delete', $entry->id) }}" class="btn btn-sm btn-danger mb-1"
                        onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                        
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="text-center">No payroll records found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="d-flex justify-content-center mt-3">
    {{ $attendances->links('pagination::bootstrap-5') }}
    </div>


</div>
@endsection
