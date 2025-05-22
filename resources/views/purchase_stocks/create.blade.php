@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add New Purchase Stock</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('purchase-stocks.store') }}">
                        @csrf

                        <div class="form-group row mb-3">
                            <label for="ingredient_id" class="col-md-4 col-form-label text-md-right">Ingredient</label>
                            <div class="col-md-6">
                                <select id="ingredient_id" class="form-control @error('ingredient_id') is-invalid @enderror" name="ingredient_id" required>
                                    <option value="">Select Ingredient</option>
                                    @foreach($ingredients as $ingredient)
                                        <option value="{{ $ingredient->id }}" {{ old('ingredient_id') == $ingredient->id ? 'selected' : '' }}>
                                            {{ $ingredient->name }} ({{ $ingredient->unit }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('ingredient_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="quantity" class="col-md-4 col-form-label text-md-right">Quantity</label>
                            <div class="col-md-6">
                                <input id="quantity" type="number" step="0.01" min="0.01" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity') }}" required>
                                @error('quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="cost_price" class="col-md-4 col-form-label text-md-right">Cost Price</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input id="cost_price" type="number" step="0.01" min="0.01" class="form-control @error('cost_price') is-invalid @enderror" name="cost_price" value="{{ old('cost_price') }}" required>
                                </div>
                                @error('cost_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="purchase_date" class="col-md-4 col-form-label text-md-right">Purchase Date</label>
                            <div class="col-md-6">
                                <input id="purchase_date" type="date" class="form-control @error('purchase_date') is-invalid @enderror" name="purchase_date" value="{{ old('purchase_date', date('Y-m-d')) }}" required>
                                @error('purchase_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="expiry_date" class="col-md-4 col-form-label text-md-right">Expiry Date</label>
                            <div class="col-md-6">
                                <input id="expiry_date" type="date" class="form-control @error('expiry_date') is-invalid @enderror" name="expiry_date" value="{{ old('expiry_date') }}">
                                @error('expiry_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="supplier" class="col-md-4 col-form-label text-md-right">Supplier</label>
                            <div class="col-md-6">
                                <input id="supplier" type="text" class="form-control @error('supplier') is-invalid @enderror" name="supplier" value="{{ old('supplier') }}">
                                @error('supplier')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="batch_number" class="col-md-4 col-form-label text-md-right">Batch Number</label>
                            <div class="col-md-6">
                                <input id="batch_number" type="text" class="form-control @error('batch_number') is-invalid @enderror" name="batch_number" value="{{ old('batch_number') }}">
                                @error('batch_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                                <a href="{{ route('purchase-stocks.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection