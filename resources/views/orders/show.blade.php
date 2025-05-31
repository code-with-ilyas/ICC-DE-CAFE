@extends('layouts.auth')

@section('content')
<div class="container" style="width: 70%; margin: 0 auto;">
    <!-- Combined Card for Order Details and Order Items -->
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <!-- Order Details Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="text-white">Order Details</h3>
                <a href="{{ route('orders.index') }}" class="btn btn-success btn-lg">Back To Orders List</a>
            </div>
            <hr class="my-3">

            <!-- Order Info -->
            <div class="row text-white">
                <div class="col-md-6">
                    <p><strong>Order ID:</strong> {{ $order->id }}</p>
                    <p><strong>Customer Name:</strong> {{ $order->customer_name }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Table Number:</strong> {{ $order->table_number ?? 'N/A' }}</p>
                    <p><strong>Total Amount:</strong> {{ number_format($order->total_amount, 2) }}</p>
                  
                </div>
            </div>

            <hr class="my-3">

            <!-- Order Items Section -->
            <h3 class="mb-4 text-white">Order Items</h3>
            <hr>
            <table class="table table-bordered" style="width: 100%; background-color: #2a2a2a; border: 2px solid #00bcd4;">
                <thead style="background-color: rgb(48, 51, 51); color: white;">
                    <tr>
                        <th style="color: white;">S.No</th>
                        <th style="color: white;">Product</th>
                        <th style="color: white;">Quantity</th>
                        <th style="color: white;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td style="color: white;">{{ $loop->iteration }}</td>
                        <td style="color: white;">{{ $item->product->name }}</td>
                        <td style="color: white;">{{ $item->quantity }}</td>
                        <td style="color: white;">{{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.dark-theme .card {
    background-color: #2a2a2a !important;
    color: #e0e0e0 !important;
    border: 2px solid #00bcd4 !important;
    box-shadow: 0 0 12px rgba(0, 188, 212, 0.5) !important;
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
</style>
@endsection
