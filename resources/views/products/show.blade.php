@extends('layouts.auth')

@section('title', 'Product Details')

@section('content')
<div class="card shadow-sm mt-4" style="max-width: 600px; margin: 0 auto;">
    <div class="card-body py-4 px-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0 text-white"><i class="fas fa-box-open me-2"></i>Product Details</h4>
            <a href="{{ route('products.index') }}" class="btn btn-success"">
                <i class="fas fa-arrow-left me-1 "></i> Back To products List
            </a>
        </div>

        <hr class="my-3">

        <div class="mb-3">
            <p class="mb-1"><strong>Category:</strong></p>
            <p class="text-muted">{{ $product->category->name ?? 'N/A' }}</p>
        </div>

        <div class="mb-3">
            <p class="mb-1"><strong>Name:</strong></p>
            <p class="text-muted">{{ $product->name }}</p>
        </div>

        <div class="mb-3">
            <p class="mb-1"><strong>Description:</strong></p>
            <p class="text-muted">{{ $product->description ?? 'N/A' }}</p>
        </div>

        <div class="mb-2">
            <p class="mb-1"><strong>Price:</strong></p>
            <p class="text-muted">${{ number_format($product->price, 2) }}</p>
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
