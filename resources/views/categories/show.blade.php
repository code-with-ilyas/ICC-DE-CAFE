@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="card shadow-glow">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h4 class="mb-0 text-white">Category Details</h4>
            <a href="{{ route('categories.index') }}" class="btn btn-success">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
        <hr>

        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="text-info">Category Name:</h5>
                    <p class="text-white">{{ $category->name }}</p>
                </div>
                <div class="col-md-6">
                    <h5 class="text-info">Description:</h5>
                    <p class="text-white">{{ $category->description ?? 'N/A' }}</p>
                </div>
            </div>

          
            @if($category->products->count() > 0)
                <table class="table table-bordered table-striped shadow-glow text-center align-middle">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($category->products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $product->name }}</td>
                            <td>Rs {{ number_format($product->price, 2) }}</td>
                            <td>
                                <span class="badge {{ $product->is_available ? 'bg-success' : 'bg-danger' }}">
                                    {{ $product->is_available ? 'Available' : 'Out of Stock' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                
            @endif
        </div>
    </div>
</div>

<style>
    .card.shadow-glow {
        border: 2px solid #00bcd4 !important;
        border-radius: 10px !important;
        box-shadow: 0 0 15px rgba(0, 188, 212, 0.8) !important;
    }

    .table.shadow-glow {
        border: 2px solid #00bcd4 !important;
        color: white !important;
        box-shadow: 0 0 10px rgba(0, 188, 212, 0.5);
    }

    .table thead th {
        background-color: rgba(0, 188, 212, 0.3) !important;
        border-bottom: 2px solid #00bcd4 !important;
        color: white !important;
        font-weight: 600;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #00bcd4 !important;
        color: white !important;
    }

    hr {
        border: none;
        height: 2px;
        background: linear-gradient(90deg,
                rgba(0, 0, 0, 0) 0%,
                rgba(0, 188, 212, 0.8) 20%, #00bcd4 50%,
                rgba(0, 188, 212, 0.8) 80%,
                rgba(0, 0, 0, 0) 100%);
        margin: 15px 0;
    }

    .text-info {
        color: #00bcd4 !important;
    }

    .badge.bg-success {
        background-color: #198754 !important;
        box-shadow: 0 0 8px rgba(25, 135, 84, 0.6);
    }

    .badge.bg-danger {
        background-color: #dc3545 !important;
        box-shadow: 0 0 8px rgba(220, 53, 69, 0.6);
    }

    .alert-info {
        background-color: rgba(13, 202, 240, 0.2);
        border-color: #0dcaf0;
        color: #0dcaf0;
    }
</style>
@endsection