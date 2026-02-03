@extends('layouts.auth')

@section('content')
<div class="d-flex justify-content-center mt-5">
    <div class="card shadow-sm p-4" style="width: 600px;">
        <h3 class="mb-4 text-white">Assign Stock to Product</h3>

        {{-- Back and Save Buttons --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('product-stock.index') }}" class="btn btn-success">Back</a>
        </div>

        <form action="{{ route('product-stock.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="product_id" class="form-label">Product</label>
                <select name="product_id" id="product_id" class="form-select" required>
                    <option value="">Select Product</option>
                    @foreach($products as $product)
                    <option value="{{ $product->product_id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
                @error('product_id')
                <div class="mt-1 text-danger" style="font-size: 0.875em;">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="stock_id" class="form-label">Stock</label>
                <select name="stock_id" id="stock_id" class="form-select" required>
                    <option value="">Select Stock</option>
                    @foreach($stocks as $stock)
                    <option value="{{ $stock->id }}">{{ $stock->name }} ({{ $stock->unit }})</option>
                    @endforeach
                </select>
                @error('stock_id')
                <div class="mt-1 text-danger" style="font-size: 0.875em;">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" step="0.01" name="quantity" id="quantity" class="form-control" required>
                @error('quantity')
                <div class="mt-1 text-danger" style="font-size: 0.875em;">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </form>
    </div>
</div>

{{-- Styling --}}
<style>
    .card {
        background-color: #2a2a2a;
        color: #e0e0e0;
        border: 2px solid #00bcd4;
        border-radius: 10px;
        box-shadow: 0 0 12px rgba(0, 188, 212, 0.5);
    }

    .form-control, .form-select {
        background-color: #2a2a2a;
        color: #e0e0e0;
        border: 1px solid #00bcd4;
        padding: 6px 10px;
    }

    .form-control:focus, .form-select:focus {
        border-color: #00e5ff;
        box-shadow: 0 0 5px rgba(0, 229, 255, 0.6);
        outline: none;
    }

    label {
        color: #ffffff;
        font-weight: 500;
    }

    hr {
        border: none;
        height: 2px;
        background: linear-gradient(90deg,
            rgba(0, 0, 0, 0) 0%,
            rgba(0, 188, 212, 0.8) 20%,
            #00bcd4 50%,
            rgba(0, 188, 212, 0.8) 80%,
            rgba(0, 0, 0, 0) 100%);
        margin: 15px 0;
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
        color: #fff;
        box-shadow: 0 0 8px rgba(0, 188, 212, 0.4);
        padding: 6px 12px;
        font-size: 0.9rem;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #218838;
    }
</style>
@endsection
