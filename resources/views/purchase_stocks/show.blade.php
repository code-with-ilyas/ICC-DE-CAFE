@extends('layouts.auth')

@section('content')
<div class="container" style="width: 70%; margin: 0 auto;">
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="text-white">Purchase Stock Detail</h3>
                <a href="{{ route('purchase_stocks.index') }}" class="btn btn-success btn-lg">Back To Purchases</a>
            </div>
            <hr class="my-3">

            <!-- Purchase Stock Details -->
            <div class="row text-white" style="font-size: 1.1rem;">
                <div class="col-md-6 mb-3">
                    <p><strong>Product Name:</strong> {{ $purchaseStock->product_name }}</p>
                    <p><strong>Quantity:</strong> {{ $purchaseStock->quantity }}</p>
                    <p><strong>Unit Price:</strong> {{ number_format($purchaseStock->unit_price, 2) }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Supplier Name:</strong> {{ $purchaseStock->supplier_name }}</p>
                    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($purchaseStock->date)->format('Y-m-d') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        background-color: #2a2a2a !important;
        color: #e0e0e0 !important;
        border: 2px solid #00bcd4 !important;
        box-shadow: 0 0 12px rgba(0, 188, 212, 0.5) !important;
        border-radius: 10px;
    }
    hr {
        border: none;
        height: 2px;
        background: linear-gradient(90deg,
            rgba(0,0,0,0) 0%, 
            rgba(0, 188, 212, 0.8) 20%, 
            #00bcd4 50%, 
            rgba(0, 188, 212, 0.8) 80%, 
            rgba(0,0,0,0) 100%);
        margin: 15px 0;
    }
    .text-white {
        color: white !important;
    }
   
    
</style>
@endsection
