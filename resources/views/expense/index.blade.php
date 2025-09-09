@extends('layouts.app')

@section('content')
<div class="container">
    <h2>All Expense Entries</h2>

    <a href="{{ url('/expense/create') }}" class="btn btn-danger mb-3">Add New Expense</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center" style="width: 5%;">Sl No.</th>
                <th class="text-center">Purpose</th>
                <th class="text-center" style="width: 15%;">Amount ($)</th>
                <th class="text-center" style="width: 20%;">Spent At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($expenses as $index => $expense)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $expense->purpose }}</td>
                    <td class="text-center">${{ number_format($expense->amount, 2) }}</td>
                    <td class="text-center">{{ $expense->spent_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
