@extends('layouts.auth')

@section('content')
<div class="container">
    <h4 class="mb-3">Purchase Details</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            <p><strong>Supplier:</strong> {{ $purchaseStock->supplier_name }}</p>
            <p><strong>Supplier Number:</strong> {{ $purchaseStock->supplier_number ?? '-' }}</p>
            <p><strong>Product:</strong> {{ $purchaseStock->product_name }}</p>
            <p><strong>Quantity:</strong> {{ $purchaseStock->quantity }}</p>
            <p><strong>Unit Price:</strong> {{ number_format($purchaseStock->unit_price,2) }}</p>
            <p><strong>Total Price:</strong> {{ number_format($purchaseStock->total_price,2) }}</p>
            <p><strong>Date:</strong> {{ $purchaseStock->date->format('d-m-Y') }}</p>
        </div>
    </div>
</div>
@endsection
