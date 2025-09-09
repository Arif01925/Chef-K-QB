<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\Expense;
use App\Models\Inventory;

class DashboardController extends Controller
{
    public function index()
    {
        $totalIncome = Income::sum('amount');
        $totalExpense = Expense::sum('amount');
        $netProfit = $totalIncome - $totalExpense;

        $recentIncomes = Income::orderBy('received_at', 'desc')->take(5)->get();
        $recentExpenses = Expense::orderBy('spent_at', 'desc')->take(5)->get();

        $inventories = Inventory::all();

        $monthlyIncome = Income::selectRaw('MONTH(received_at) as month, SUM(amount) as total')
            ->groupBy('month')->pluck('total', 'month')->toArray();

        $monthlyExpense = Expense::selectRaw('MONTH(spent_at) as month, SUM(amount) as total')
            ->groupBy('month')->pluck('total', 'month')->toArray();

        // Fill all 12 months with zero if not present
        $monthlyIncomeData = [];
        $monthlyExpenseData = [];

        for ($i = 1; $i <= 12; $i++) {
            $monthlyIncomeData[] = $monthlyIncome[$i] ?? 0;
            $monthlyExpenseData[] = $monthlyExpense[$i] ?? 0;
        }

        return view('dashboard', compact(
            'totalIncome', 
            'totalExpense', 
            'netProfit',
            'recentIncomes', 
            'recentExpenses', 
            'inventories',
            'monthlyIncomeData', 
            'monthlyExpenseData'
        ));
    }
}
