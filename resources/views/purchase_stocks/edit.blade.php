@extends('layouts.auth')

@section('content')
<div class="container">
    <h4 class="mb-4">Edit Purchase Stock</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('purchase-stocks.update', $purchaseStock->id) }}">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Supplier Name</label>
                        <input type="text" name="supplier_name" class="form-control"
                               value="{{ $purchaseStock->supplier_name }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Supplier Number</label>
                        <input type="text" name="supplier_number" class="form-control"
                               value="{{ $purchaseStock->supplier_number }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="product_name" class="form-control"
                               value="{{ $purchaseStock->product_name }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="text" name="quantity" class="form-control"
                               value="{{ $purchaseStock->quantity }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Unit Price</label>
                        <input type="number" step="0.01" name="unit_price" class="form-control"
                               value="{{ $purchaseStock->unit_price }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Total Price</label>
                        <input type="number" step="0.01" name="total_price" class="form-control"
                               value="{{ $purchaseStock->total_price }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Purchase Date</label>
                        <input type="date" name="date" class="form-control"
                               value="{{ $purchaseStock->date->format('Y-m-d') }}" required>
                    </div>
                </div>

                <div class="mt-3">
                    <button class="btn btn-primary">
                        <i class="bi bi-arrow-repeat"></i> Update Purchase
                    </button>
                    <a href="{{ route('purchase-stocks.index') }}" class="btn btn-secondary">
                        Back
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
