@extends('layouts.auth')

@section('content')
<div class="d-flex justify-content-center mt-5">
    <div class="card shadow-sm p-4" style="width: 600px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
           <a href="{{ route('categories.index') }}" class="btn btn-success me-2">Show All Categories</a>
            <div>
                
                <button type="submit" form="categoryForm" class="btn btn-success">Update Category</button>
            </div>
        </div>

        <form id="categoryForm" action="{{ route('categories.update', $category->category_id) }}" method="POST">
            @csrf
            @method('PUT')
            <hr>
            <div class="mb-4">
                <label for="name" class="form-label">Category Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}">
                @error('name')
                <div class="mt-1 text-danger" style="font-size: 0.875em;">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="4">{{ $category->description }}</textarea>
                @error('description')
                <div class="mt-1 text-danger" style="font-size: 0.875em;">{{ $message }}</div>
                @enderror
            </div>
        </form>
    </div>
</div>

<style>
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
