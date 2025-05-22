<!-- resources/views/invoices/print.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Invoice #{{ $invoice->id }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2>Invoice #{{ $invoice->id }}</h2>
    <p><strong>Customer:</strong> {{ $invoice->order->customer_name }}</p>
    <p><strong>Phone:</strong> {{ $invoice->order->customer_phone }}</p>
    <p><strong>Date:</strong> {{ $invoice->created_at->format('d-m-Y') }}</p>

    <hr>

    <h4>Items</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->order->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price, 2) }}</td>
                <td>{{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h5>Total: {{ number_format($invoice->total_amount, 2) }} PKR</h5>

    <button class="btn btn-primary no-print mt-3" onclick="window.print()">Print Invoice</button>
    <a href="{{ route('invoices.index') }}" class="btn btn-secondary no-print mt-3">Back</a>
</div>
</body>
</html>
