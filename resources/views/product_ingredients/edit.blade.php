@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Edit Ingredient for {{ $product->name }}</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('products.ingredients.index', $product->id) }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Ingredients
            </a>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">Edit Ingredient</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('products.ingredients.update', [$product->id, $productIngredient->id]) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="ingredient_id" class="form-label">Ingredient</label>
                    <select name="ingredient_id" id="ingredient_id" class="form-select @error('ingredient_id') is-invalid @enderror" required>
                        <option value="">Select an ingredient</option>
                        @foreach($ingredients as $ingredient)
                            <option value="{{ $ingredient->id }}" {{ (old('ingredient_id') == $ingredient->id || $productIngredient->ingredient_id == $ingredient->id) ? 'selected' : '' }}>
                                {{ $ingredient->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('ingredient_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" 
                           value="{{ old('quantity', $productIngredient->quantity) }}" step="0.01" min="0.01" required>
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Update Ingredient
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection