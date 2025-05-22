@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Ingredient</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('ingredients.update', $ingredient) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $ingredient->name) }}" required autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="unit" class="col-md-4 col-form-label text-md-right">Unit</label>
                            <div class="col-md-6">
                                <select id="unit" class="form-control @error('unit') is-invalid @enderror" name="unit" required>
                                    <option value="g" {{ old('unit', $ingredient->unit) == 'g' ? 'selected' : '' }}>Grams (g)</option>
                                    <option value="kg" {{ old('unit', $ingredient->unit) == 'kg' ? 'selected' : '' }}>Kilograms (kg)</option>
                                    <option value="ml" {{ old('unit', $ingredient->unit) == 'ml' ? 'selected' : '' }}>Milliliters (ml)</option>
                                    <option value="l" {{ old('unit', $ingredient->unit) == 'l' ? 'selected' : '' }}>Liters (l)</option>
                                    <option value="pcs" {{ old('unit', $ingredient->unit) == 'pcs' ? 'selected' : '' }}>Pieces (pcs)</option>
                                </select>
                                @error('unit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Description</label>
                            <div class="col-md-6">
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description', $ingredient->description) }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                                <a href="{{ route('ingredients.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
