@extends('layouts.auth')

@section('content')
<div class="container" style="overflow: hidden;"> <!-- Disable scrolling -->
    <div class="card card-shadow p-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-white mb-0">Stock List</h2>
            <a href="{{ route('stocks.create') }}" class="btn btn-success">+ Add New Stock</a>
        </div>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-striped table-custom text-center align-middle">
            <thead>
                <tr>
                    <th>S.NO</th>
                    <th>Name</th>
                    <th>Available Quantity</th>
                    <th>Unit</th>
                    <th>Price per Unit</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stocks as $stock)
                <tr>
                    <td>{{ $stock->id }}</td>
                    <td>{{ $stock->name }}</td>

                    {{-- Display Quantity with proper formatting --}}
                    <td>{{ $stock->displayQuantity() }}</td>

                    {{-- Unit --}}
                    <td>{{ $stock->unit }}</td>

                    {{-- Price --}}
                    <td>{{ $stock->price ? number_format($stock->price, 2) : '-' }}</td>

                    {{-- Description --}}
                    <td>{{ $stock->description ?? '-' }}</td>

                    {{-- Actions --}}
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('stocks.show', $stock->id) }}" class="btn btn-sm btn-success">View</a>
                            <a href="{{ route('stocks.edit', $stock->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete stock?')">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">No stock found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        @if(method_exists($stocks, 'links'))
        <div class="mt-2">
            {{ $stocks->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

{{-- Styling --}}
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
        padding: 20px;
        margin-bottom: 20px;
    }

    /* Table Styles */
    .table-custom {
        border: 2px solid var(--primary-color);
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
        color: var(--text-white) !important; /* Force white text */
    }

    .table-custom tbody tr:hover {
        background-color: rgba(0, 188, 212, 0.15);
    }

    /* Buttons */
    .btn-success, .btn-primary, .btn-danger {
        box-shadow: 0 0 8px var(--primary-shadow-medium);
        color: var(--text-white);
        font-size: 0.85rem;
        padding: 4px 10px;
    }

    .btn-success { background-color: var(--success-color); border-color: var(--success-color); }
    .btn-success:hover { background-color: var(--success-hover); }

    .btn-primary { background-color: var(--primary-color); border-color: var(--primary-color); }
    .btn-primary:hover { background-color: var(--primary-color-hover); }

    .btn-danger { background-color: var(--danger-color); border-color: var(--danger-color); box-shadow: 0 0 10px var(--danger-shadow); }
    .btn-danger:hover { background-color: var(--danger-hover); }

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

    html, body {
        overflow: hidden; /* Disable full-page scrolling */
    }
</style>
@endsection
