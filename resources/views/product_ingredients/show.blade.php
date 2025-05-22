@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>{{ $product->name }}</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Products
            </a>
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">
                <i class="bi bi-pencil"></i> Edit Product
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <h5>Details</h5>
                    <hr>
                    <p><strong>SKU:</strong> {{ $product->sku }}</p>
                    <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                    <!-- Add other product details here -->
                </div>
                <div class="col-md-8">
                    <h5>Description</h5>
                    <hr>
                    <p>{{ $product->description ?? 'No description available.' }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Ingredients</h5>
            <a href="{{ route('products.ingredients.index', $product->id) }}" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-receipt"></i> Manage Ingredients
            </a>
        </div>
        <div class="card-body">
            @if($product->ingredients->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Ingredient</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($product->ingredients as $ingredient)
                                <tr>
                                    <td>{{ $ingredient->name }}</td>
                                    <td>{{ $ingredient->pivot->quantity }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">
                    No ingredients have been added to this product yet.
                    <a href="{{ route('products.ingredients.create', $product->id) }}" class="alert-link">Add ingredients</a>.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection