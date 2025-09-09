@extends('layouts.app')

@section('content')
<div class="container">
    <h2>All Income Entries</h2>

    <a href="{{ url('/income/create') }}" class="btn btn-success mb-3">Add New Income</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center" style="width: 5%;">Sl No.</th>
                <th class="text-center">Source</th>
                <th class="text-center" style="width: 15%;">Amount ($)</th>
                <th class="text-center" style="width: 20%;">Received At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($incomes as $index => $income)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td title="{{ $income->source }}">{{ Str::limit($income->source, 40) }}</td>
                    <td class="text-center">${{ number_format($income->amount, 2) }}</td>
                    <td class="text-center">{{ $income->received_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
