<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = \App\Models\Expense::orderBy('id')->get();
        return view('expense.index', compact('expenses'));
    }

    public function create()
    {
        return view('expense.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'purpose' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'spent_at' => 'required|date',
        ]);

        Expense::create($request->all());

        return redirect()->route('expense.index')->with('success', 'Expense added successfully!');
    }
}
