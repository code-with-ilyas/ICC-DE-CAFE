@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="card card-shadow p-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="text-white">Product Stock List</h3>
            <a href="{{ route('product-stock.create') }}" class="btn btn-success">Add Product Stock</a>
        </div>

        <table class="table table-bordered table-custom text-center align-middle">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Stock</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($productStocks as $ps)
                <tr>
                    <td>{{ $ps->product->name }}</td>
                    <td>{{ $ps->stock->name }} ({{ $ps->stock->unit }})</td>
                    <td>
                        @if(in_array($ps->stock->unit, ['kg', 'liter']))
                            {{ number_format($ps->quantity, 0) }} g
                        @else
                            {{ number_format($ps->quantity, 0) }} pcs
                        @endif
                    </td>
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('product-stock.edit', $ps->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('product-stock.destroy', $ps->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this stock?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">No product stock assigned yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        @if(method_exists($productStocks, 'links'))
        <div class="mt-2">
            {{ $productStocks->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

{{-- Reusable Styling --}}
<style>
    :root {
        --primary-color: #00bcd4;
        --primary-color-light: rgba(0, 188, 212, 0.3);
        --primary-color-hover: rgba(0, 188, 212, 0.7);
        --primary-shadow: rgba(0, 188, 212, 0.5);
        --primary-shadow-medium: rgba(0, 188, 212, 0.6);
        --primary-shadow-strong: rgba(0, 188, 212, 0.8);
        --primary-shadow-stronger: rgba(0, 188, 212, 0.9);

        --danger-color: #dc3545;
        --danger-hover: #c82333;
        --danger-shadow: rgba(220, 53, 69, 0.6);

        --success-color: #28a745;
        --success-hover: #218838;
        --text-dark: #343a40;
        --text-white: #fff;
    }

    /* Card Glow */
    .card-shadow {
        border: 2px solid var(--primary-color);
        border-radius: 10px;
        box-shadow: 0 0 15px var(--primary-shadow-strong);
    }

    /* Table Styles */
    .table-custom {
        border: 2px solid var(--primary-color);
        color: var(--text-white);
        box-shadow: 0 0 10px var(--primary-shadow);
    }

    .table-custom th {
        background-color: var(--primary-color-light);
        border-bottom: 2px solid var(--primary-color);
        font-weight: 600;
        color: var(--text-white);
    }

    .table-custom td, .table-custom th {
        border: 1px solid var(--primary-color);
    }

    .table-custom tbody tr:hover {
        background-color: rgba(0, 188, 212, 0.15);
    }

  .btn-success {
        background-color: var(--success-color);
        border-color: var(--success-color);
    }
    .btn-success:hover { background-color: var(--success-hover); }
    .btn-danger {
        background-color: var(--danger-color);
        border-color: var(--danger-color);
        color: var(--text-white);
        box-shadow: 0 0 10px var(--danger-shadow);
    }

    .btn-danger:hover {
        background-color: var(--danger-hover);
        border-color: var(--danger-hover);
    }

    /* Pagination */
    .pagination .page-link {
        color: var(--text-white) !important;
        background-color: rgb(27, 45, 56) !important;
        border: 1px solid var(--primary-color) !important;
        margin: 0 2px;
        padding: 6px 12px;
        border-radius: 4px;
        box-shadow: 0 0 10px var(--primary-shadow-medium);
    }

    .pagination .active .page-link {
        background-color: var(--primary-color) !important;
        color: var(--text-dark) !important;
        font-weight: bold;
        border-color: var(--primary-color);
        box-shadow: 0 0 15px var(--primary-shadow-stronger);
    }

    .pagination .page-link:hover {
        background-color: var(--primary-color-hover) !important;
        color: var(--text-dark) !important;
    }

    .container {
        padding: 20px;
    }
</style>
@endsection
