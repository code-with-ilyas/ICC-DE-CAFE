@extends('layouts.auth')

@section('content')
<div class="container mt-4">
    <a href="{{ route('invoices.index') }}" class="btn btn-secondary mb-3">← Back to Invoices</a>
    <button onclick="window.print()" class="btn btn-primary mb-3 float-end">🖨️ Print</button>

    <div class="card shadow" id="print-area">
        <div class="card-header">
            <h5>Invoice #{{ $invoice->invoice_number }}</h5>
        </div>
        <div class="card-body">
            <p><strong>Customer:</strong> {{ $invoice->order->customer_name }}</p>
            <p><strong>Phone:</strong> {{ $invoice->order->customer_phone }}</p>
            <p><strong>Total:</strong> {{ number_format($invoice->order->total_amount, 2) }} PKR</p>

            <h6 class="mt-4">Items:</h6>
            <ul>
                @foreach($invoice->order->items as $item)
                    <li>{{ $item->product->name }} × {{ $item->quantity }} = {{ $item->subtotal }} PKR</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

{{-- Optional: CSS to hide unnecessary elements when printing --}}
<style>
@media print {
    body * {
        visibility: hidden;
    }
    #print-area, #print-area * {
        visibility: visible;
    }
    #print-area {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }

    .btn, a.btn {
        display: none !important;
    }
}
</style>
@endsection
