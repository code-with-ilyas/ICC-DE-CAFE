<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Display all payments
    public function index()
    {
        $payments = Payment::with('order')->get();
        return view('payments.index', compact('payments'));
    }

    // Show the form for creating a new payment
    public function create(Order $order)
    {
        return view('payments.create', compact('order'));
    }

    // Store a newly created payment
    public function store(Request $request, Order $order)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:Cash,Card,Mobile',
            'payment_date' => 'required|date',
        ]);

        // Create the payment associated with the order
        $order->payments()->create([
            'payment_date' => $request->payment_date,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
        ]);

        // Redirect to the payments index page after successful submission
        return redirect()->route('payments.index')->with('success', 'Payment added successfully.');
    }
}