@extends('layouts.auth')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm p-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0 text-white">Products List</h3>
            <a href="{{ route('products.create') }}" class="btn btn-success">Add Product</a>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Debugging: Check if $products is defined --}}
        @if(!isset($products))
            <div class="alert alert-danger">
                The $products variable is not defined.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-hover text-center align-middle">
                    <thead> <!-- White background -->
                        <tr>
                            <th>ID</th>
                            <th>Category</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Available</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->product_id }}</td>
                            <td>{{ $product->category?->name ?? 'N/A' }}</td>
                            <td>{{ $product->name }}</td>
                            <td class="text-truncate" style="max-width: 200px;">{{ $product->description }}</td>
                            <td>PKR{{ number_format($product->price, 2) }}</td>
                            <td>
                                <span class="badge {{ $product->is_available ? 'bg-success' : 'bg-danger' }}">
                                    {{ $product->is_available ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td>
                                {{-- Edit Button --}}
                                <a href="{{ route('products.edit', $product->product_id) }}" class="btn btn-primary btn-sm">
                                    Edit
                                </a>

                                {{-- Delete Button --}}
                                <form action="{{ route('products.destroy', $product->product_id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
<style>
.dark-theme .card {
    background-color: #2a2a2a !important;
    color: #e0e0e0 !important;
    border: 2px solid #00bcd4 !important; /* Teal Blue Border */
    box-shadow: 0 0 12px rgba(0, 188, 212, 0.5) !important; /* Light glow */
}



.table, .table th, .table td {
    border: 1px solid #00bcd4 !important; /* Light blue outlines */
    color: #ffffff !important;            /* White text in th and td */
}

.table {
    border-collapse: collapse !important;
}




</style>
@endsection