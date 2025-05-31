@extends('layouts.auth')

@section('title', 'Create Product')

@section('content')
<div class="card mx-auto my-5 py-4" style="max-width: 700px;">
    <div class="card-header d-flex justify-content-between align-items-center">
      <a href="{{ route('products.index') }}" class="btn btn-success me-2">Show Products List</a>
        <div>
            <button type="submit" form="product-form" class="btn btn-success">+ ADD</button>
        </div>
    </div>
    <div class="card-body">
        <form id="product-form" action="{{ route('products.store') }}" method="POST">
            @csrf

           
            <hr>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="category_id" class="form-label">Category</label>
                    <select class="form-select" id="category_id" name="category_id" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->category_id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" class="form-control" id="name" name="name" required maxlength="100" value="{{ old('name') }}">
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" required value="{{ old('price') }}">
                    @error('price')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <h5 class="text- mb-3 mt-4 text-white">Availability</h5>
            <hr>

            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="is_available" name="is_available" value="1" {{ old('is_available') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_available">
                      (YES) OR (NO)
                    </label>
                </div>
            </div>
        </form>
    </div>
</div>


<style>
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

    .dark-theme .card {
        background-color: #2a2a2a !important;
        color: #e0e0e0 !important;
        border: 2px solid #00bcd4 !important;
        box-shadow: 0 0 12px rgba(0, 188, 212, 0.5) !important;
    }

    .dark-theme .form-control {
        background-color: #2a2a2a;
        color: #e0e0e0;
        border: 1px solid #00bcd4;
    }

    .dark-theme .form-control:focus {
        border-color: #00e5ff;
        box-shadow: 0 0 5px rgba(0, 229, 255, 0.6);
        outline: none;
    }

    .dark-theme label {
        color: #ffffff;
    }
      /* Dark theme for all form controls including placeholders */
    .dark-theme .form-control,
    .dark-theme .form-select,
    .dark-theme .form-control::placeholder,
    .dark-theme .form-select:invalid {
        background-color: #2a2a2a !important;
        color: #e0e0e0 !important;
        border: 1px solid #00bcd4 !important;
    }

    /* Specific styling for select dropdown placeholder */
    .dark-theme select.form-select:required:invalid {
        color: #e0e0e0 !important;
    }
    
    /* Style the options within the select dropdown */
    .dark-theme select.form-select option {
        background-color: #2a2a2a;
        color: #e0e0e0;
    }
    
    /* Style the dropdown menu */
    .dark-theme select.form-select option:checked {
        background-color: #00bcd4;
        color: #000;
    }

    /* For browsers that support ::placeholder */
    .dark-theme ::placeholder {
        color: #e0e0e0 !important;
        opacity: 1 !important;
    }

    /* For older browsers */
    .dark-theme :-ms-input-placeholder {
        color: #e0e0e0 !important;
    }

    .dark-theme ::-ms-input-placeholder {
        color: #e0e0e0 !important;
    }
</style>
@endsection