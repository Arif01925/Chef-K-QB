@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 fw-bold text-center">Create Invoice</h2>

    <form action="{{ route('invoices.store') }}" method="POST" id="invoiceForm">
        @csrf

        <!-- Customer Details -->
        <div class="mb-3">
            <label for="customer_name" class="form-label">Customer Name</label>
            <input type="text" class="form-control" name="customer_name" required>
        </div>

        <div class="mb-3">
            <label for="invoice_date" class="form-label">Invoice Date</label>
            <input type="date" class="form-control" name="invoice_date" value="{{ date('Y-m-d') }}" required>
        </div>

        <!-- Product Table -->
        <table class="table table-bordered" id="productsTable">
            <thead>
                <tr>
                    <th>Sl No</th>
                    <th>Product</th>
                    <th>Unit Price ($)</th>
                    <th>Quantity</th>
                    <th>Total ($)</th>
                    <th><button type="button" class="btn btn-sm btn-success" onclick="addRow()">+</button></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="slno">1</td>
                    <td>
                        <select name="products[]" class="form-control" onchange="setPrice(this)">
                            <option value="">Select</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->unit_price }}">{{ $product->product_name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" step="0.01" name="unit_price[]" class="form-control unit-price" readonly></td>
                    <td><input type="number" name="quantity[]" class="form-control quantity" oninput="calculateRow(this)"></td>
                    <td><input type="number" step="0.01" name="line_total[]" class="form-control line-total" readonly></td>
                    <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">×</button></td>
                </tr>
            </tbody>
        </table>

        <!-- Totals -->
        <div class="row mb-3">
            <div class="col-md-4 offset-md-8">
                <label>Subtotal:</label>
                <input type="text" class="form-control" name="subtotal" id="subtotal" readonly>

                <label>Tax (10%):</label>
                <input type="text" class="form-control" name="tax" id="tax" readonly>

                <label>Total:</label>
                <input type="text" class="form-control" name="total" id="total" readonly>
            </div>
        </div>

        <!-- Payment Section -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label>Payment Status:</label>
                <select name="payment_status" class="form-control" onchange="toggleMethod(this)">
                    <option value="unpaid" selected>Unpaid</option>
                    <option value="paid">Paid</option>
                </select>
            </div>
            <div class="col-md-4" id="paymentMethodDiv" style="display: none;">
                <label>Payment Method:</label>
                <select name="payment_method" class="form-control">
                    <option value="bank_transfer">Bank Transfer</option>
                    <option value="cheque">Cheque</option>
                    <option value="online_payment">Online Payment</option>
                </select>
            </div>
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label>Description (optional)</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100">Save Invoice</button>
    </form>
</div>

<!-- Scripts -->
<script>
function setPrice(select) {
    const price = select.options[select.selectedIndex].getAttribute('data-price');
    const row = select.closest('tr');
    row.querySelector('.unit-price').value = price;
    row.querySelector('.quantity').value = 1;
    calculateRow(row.querySelector('.quantity'));
}

function calculateRow(input) {
    const row = input.closest('tr');
    const price = parseFloat(row.querySelector('.unit-price').value || 0);
    const qty = parseFloat(row.querySelector('.quantity').value || 0);
    const total = price * qty;
    row.querySelector('.line-total').value = total.toFixed(2);
    calculateTotals();
}

function calculateTotals() {
    let subtotal = 0;
    document.querySelectorAll('.line-total').forEach(el => {
        subtotal += parseFloat(el.value || 0);
    });
    const tax = subtotal * 0.1;
    const total = subtotal + tax;

    document.getElementById('subtotal').value = subtotal.toFixed(2);
    document.getElementById('tax').value = tax.toFixed(2);
    document.getElementById('total').value = total.toFixed(2);
}

function toggleMethod(select) {
    document.getElementById('paymentMethodDiv').style.display = (select.value === 'paid') ? 'block' : 'none';
}

function addRow() {
    const table = document.getElementById('productsTable').querySelector('tbody');
    const newRow = table.rows[0].cloneNode(true);
    table.appendChild(newRow);

    // Reset fields
    newRow.querySelectorAll('input, select').forEach(el => el.value = '');
    updateSlNo();
}

function removeRow(button) {
    const row = button.closest('tr');
    if (row.parentNode.rows.length > 1) {
        row.remove();
        updateSlNo();
        calculateTotals();
    }
}

function updateSlNo() {
    document.querySelectorAll('#productsTable .slno').forEach((td, i) => {
        td.textContent = i + 1;
    });
}
</script>
@endsection
