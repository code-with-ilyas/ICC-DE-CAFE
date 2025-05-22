@extends('layouts.auth')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header text-white" style=" border-bottom: 2px solid #00bcd4;">
            <h5 class="mb-0 text-start text-white">Edit Product</h5>
        </div>
        <div class="card-body">

            <form action="{{ route('products.update', $product->product_id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    {{-- Category --}}
                    <div class="col-md-6">
                        <label for="category_id" class="form-label small">Category</label>
                        <select name="category_id" id="category_id" class="form-control form-control-sm" required>
                            <option value="">Select a Category</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->category_id }}"
                                {{ $category->category_id == optional($product->category)->category_id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Name --}}
                    <div class="col-md-6">
                        <label for="name" class="form-label small"> Name</label>
                        <input type="text" name="name" id="name" class="form-control form-control-sm" value="{{ $product->name }}">
                        @error('name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="col-md-12">
                        <label for="description" class="form-label small">Description</label>
                        <textarea name="description" id="description" class="form-control form-control-sm" rows="2">{{ $product->description }}</textarea>
                        @error('description')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Price --}}
                    <div class="col-md-6">
                        <label for="price" class="form-label small">Price</label>
                        <input type="number" name="price" id="price" class="form-control form-control-sm" value="{{ $product->price }}" step="0.01">
                        @error('price')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Availability --}}
                    <div class="col-md-6 d-flex align-items-center">
                        <input type="checkbox" name="is_available" id="is_available" value="1" class="form-check-input me-2"
                            {{ $product->is_available ? 'checked' : '' }}>
                        <label for="is_available" class="form-check-label small">Available</label>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="mt-3 text-end">
                    <button type="submit" class="btn btn-success btn-sm">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
    .dark-theme .card {
        background-color: #2a2a2a !important;
        color: #e0e0e0 !important;
        border: 2px solid #00bcd4 !important;
        /* Teal Blue Border */
        box-shadow: 0 0 12px rgba(0, 188, 212, 0.5) !important;
        /* Light glow */
    }



    .dark-theme .form-control {
        background-color: #2a2a2a;
        color: #e0e0e0;
        border: 1px solid #00bcd4;
        /* Light Blue Border */
    }

    .dark-theme .form-control:focus {
        border-color: #00e5ff;
        /* Brighter Light Blue */
        box-shadow: 0 0 5px rgba(0, 229, 255, 0.6);
        outline: none;
    }

    .dark-theme label {
        color: #ffffff;
    }

    .dark-theme table.table-bordered {
        border: 2px solid #00bcd4;
    }

    .dark-theme table.table-bordered th,
    .dark-theme table.table-bordered td {
        border: 1px solid #00bcd4;
        color: #e0e0e0;
        background-color: #2a2a2a;
    }

    .dark-theme table.table-bordered thead {
        background-color: #1f1f1f;
        color: #00bcd4;
    }

    .dark-theme .form-select {
        background-color: #2a2a2a;
        color: #e0e0e0;
        border: 1px solid #00bcd4;
        /* Light blue border */
    }

    .dark-theme .form-select:focus {
        border-color: #00e5ff;
        /* Brighter blue on focus */
        box-shadow: 0 0 5px rgba(0, 229, 255, 0.6);
        /* Glow effect */
        outline: none;
    }

    .dark-theme label {
        color: #ffffff;
    }
</style>
@endsection