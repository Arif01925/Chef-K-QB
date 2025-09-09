<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Inventory;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::latest()->get();
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $products = Inventory::all();
        return view('invoices.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'invoice_date' => 'required|date',
            'description' => 'nullable|string',
            'subtotal' => 'required|numeric',
            'tax' => 'nullable|numeric',
            'total' => 'required|numeric',
            'payment_status' => 'required|string',
            'payment_method' => 'nullable|string'
        ]);

        Invoice::create($validated);

        return redirect('/dashboard')->with('success', 'Invoice saved successfully!');
    }

    public function show(Invoice $invoice)
    {
        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $products = Inventory::all();
        return view('invoices.edit', compact('invoice', 'products'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'invoice_date' => 'required|date',
            'description' => 'nullable|string',
            'subtotal' => 'required|numeric',
            'tax' => 'nullable|numeric',
            'total' => 'required|numeric',
            'payment_status' => 'required|string',
            'payment_method' => 'nullable|string'
        ]);

        $invoice->update($validated);

        return redirect('/invoices')->with('success', 'Invoice updated successfully!');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect('/invoices')->with('success', 'Invoice deleted successfully!');
    }
}
