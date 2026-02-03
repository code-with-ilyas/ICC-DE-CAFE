@extends('layouts.auth')

@section('content')
<div class="d-flex justify-content-center mt-5">
    <div class="card shadow-sm p-4" style="width: 700px;">
        <h3 class="mb-4 text-white">Add New Stock</h3>

        {{-- Back Button --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('stocks.index') }}" class="btn btn-success">Back</a>
        </div>

        <form action="{{ route('stocks.store') }}" method="POST">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" step="0.001" name="quantity" id="quantity" class="form-control" required>
                    <small class="text-muted">Enter quantity in base unit (kg / pcs / liter)</small>
                </div>

                <div class="col-md-6">
                    <label for="unit" class="form-label">Unit</label>
                    <input type="text" name="unit" id="unit" class="form-control" placeholder="e.g. kg, pcs, liters" required>
                </div>

                <div class="col-md-6">
                    <label for="price" class="form-label">Price per Unit</label>
                    <input type="number" step="0.01" name="price" id="price" class="form-control">
                </div>

                <div class="col-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control"></textarea>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-3">
                <button type="submit" class="btn btn-success">Create Stock</button>
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

    .form-control, .form-select, textarea {
        background-color: #2a2a2a;
        color: #e0e0e0;
        border: 1px solid #00bcd4;
        padding: 6px 10px;
    }

    .form-control:focus, .form-select:focus, textarea:focus {
        border-color: #00e5ff;
        box-shadow: 0 0 5px rgba(0, 229, 255, 0.6);
        outline: none;
    }

    label {
        color: #ffffff;
        font-weight: 500;
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
    html, body {
    overflow: hidden;
    height: 100%;
    width: 100%;
}
</style>
@endsection
