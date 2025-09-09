<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;

class IncomeController extends Controller
{
    public function index()
    {
        $incomes = Income::latest()->get();
        return view('income.index', compact('incomes'));
    }

    public function create()
    {
        return view('income.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'source' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'received_at' => 'required|date',
        ]);

        Income::create($request->all());

        return redirect('/income')->with('success', 'Income added successfully!');
    }
}
