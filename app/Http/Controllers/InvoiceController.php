<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('order')->get();
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $orders = Order::all();
        return view('invoices.create', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        $invoice = Invoice::create([
            'order_id' => $request->order_id,
            'invoice_number' => 'INV-' . str_pad(Invoice::max('id') + 1, 4, '0', STR_PAD_LEFT),
        ]);

        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('order.items.product');
        return view('invoices.show', compact('invoice'));
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }

    public function print($id)
    {
        $invoice = Invoice::with('order.items.product')->findOrFail($id);
        return view('invoices.print', compact('invoice'));
    }
}
