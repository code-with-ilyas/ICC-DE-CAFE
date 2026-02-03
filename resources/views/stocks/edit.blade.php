@extends('layouts.auth')

@section('content')
<div class="container" style="overflow: hidden;"> <!-- Disable scrolling -->
    <h2 class="mb-4 text-white">Edit Stock</h2>

    <form action="{{ route('stocks.update', $stock->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-3"> <!-- 2 fields per row -->
            <div class="col-md-6">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" name="name" value="{{ $stock->name }}" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" step="0.001" id="quantity" name="quantity" value="{{ $stock->quantity }}" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label for="unit" class="form-label">Unit</label>
                <input type="text" id="unit" name="unit" value="{{ $stock->unit }}" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label for="price" class="form-label">Price per unit</label>
                <input type="number" step="0.01" id="price" name="price" value="{{ $stock->price }}" class="form-control">
            </div>

            <div class="col-12">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" class="form-control">{{ $stock->description }}</textarea>
            </div>
        </div>

        <div class="mt-3 d-flex justify-content-end">
            <a href="{{ route('stocks.index') }}" class="btn btn-success me-2">Back</a>
            <button type="submit" class="btn btn-primary">Update Stock</button>
        </div>
    </form>
</div>

{{-- Optional Styling --}}
<style>
    html, body {
        overflow: hidden; /* Disable full-page scrolling */
        height: 100%;
        width: 100%;
    }

    .form-control, .form-select, textarea {
        background-color: #2a2a2a;
        color: #e0e0e0;
        border: 1px solid #00bcd4;
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

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0069d9;
        border-color: #0062cc;
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }
</style>
@endsection
