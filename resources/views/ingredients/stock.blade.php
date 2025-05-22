@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Ingredient Stock Levels</span>
                    <a href="{{ route('purchase-stocks.create') }}" class="btn btn-primary btn-sm">Add Purchase Stock</a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Ingredient</th>
                                <th>Unit</th>
                                <th>Current Stock</th>
                                <th width="150">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ingredients as $ingredient)
                                <tr>
                                    <td>{{ $ingredient->name }}</td>
                                    <td>{{ $ingredient->unit }}</td>
                                    <td>
                                        {{ $ingredient->current_stock }} {{ $ingredient->unit }}
                                        @if ($ingredient->current_stock < 10)
                                            <span class="badge bg-danger">Low Stock</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('stock-movements.ingredient', $ingredient) }}" class="btn btn-sm btn-info">View Movements</a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No ingredients found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection