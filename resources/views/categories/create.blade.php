@extends('layouts.auth')

@section('content')
<div class="d-flex justify-content-center mt-5">
    <div class="card shadow-sm p-4" style="width: 600px;"> <!-- Increased width -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0 text-white">Add New Category</h3>
            <a href="{{ route('categories.index') }}" class="btn btn-success">Show All Categories</a>
        </div>
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Category Name</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Category Name" >
                @error('name')
                <div class="mt-1 text-danger" style="font-size: 0.875em;">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="4" placeholder="Enter Description"></textarea> 
                @error('description')
                <div class="mt-1 text-danger" style="font-size: 0.875em;">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-success w-">Save</button>
        </form>
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
</style>
@endsection