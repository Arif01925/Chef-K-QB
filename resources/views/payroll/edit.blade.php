@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Payroll Entry</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('payroll.update', $entry->id) }}" method="POST">
        @method('PUT')
        @csrf

        <div class="mb-3">
            <label for="employee_id" class="form-label">Select Employee</label>
            <select name="employee_id" class="form-control" required>
                <option value="">-- Choose --</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}" {{ $entry->employee_id == $employee->id ? 'selected' : '' }}>
                        {{ $employee->name }} ({{ $employee->role }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="work_date" class="form-label">Work Date</label>
            <input type="date" name="work_date" class="form-control" value="{{ $entry->work_date }}" required>
        </div>


        <div class="mb-3">
            <label for="in_time" class="form-label">In Time</label>
            <input type="time" name="in_time" class="form-control" value="{{ $entry->in_time ? \Carbon\Carbon::parse($entry->in_time)->format('H:i') : '' }}">
        </div>

        <div class="mb-3">
            <label for="out_time" class="form-label">Out Time</label>
            <input type="time" name="out_time" class="form-control" value="{{ $entry->out_time ? \Carbon\Carbon::parse($entry->out_time)->format('H:i') : '' }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Attendance</button>
        <a href="{{ route('payroll.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
