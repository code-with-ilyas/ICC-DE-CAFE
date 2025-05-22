@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>{{ $product->name }} - Ingredients</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('products.show', $product->id) }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Product
            </a>
            <a href="{{ route('products.ingredients.create', $product->id) }}" class="btn btn-primary">
                <i class="bi bi-plus"></i> Add Ingredient
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">Ingredients List</h5>
        </div>
        <div class="card-body">
            @if($productIngredients->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Ingredient</th>
                                <th>Quantity</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($productIngredients as $item)
                                <tr>
                                    <td>{{ $item->ingredient->name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td class="text-end">
                                        <div class="btn-group">
                                            <a href="{{ route('products.ingredients.edit', [$product->id, $item->id]) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                            <form action="{{ route('products.ingredients.destroy', [$product->id, $item->id]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to remove this ingredient?')">
                                                    <i class="bi bi-trash"></i> Remove
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">
                    No ingredients have been added to this product yet.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection