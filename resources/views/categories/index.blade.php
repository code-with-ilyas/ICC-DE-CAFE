@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="card shadow-glow">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h4 class="mb-0 text-white">Categories List</h4>
            <a href="{{ route('categories.create') }}" class="btn btn-success">+ Add Category</a>
        </div>
        <hr>

        <div class="row">
            <div class="col-md-12">
                <div class="card-body">
                    <table class="table table-bordered table-striped shadow-glow text-center align-middle">
                        <thead>
                            <tr>
                                <th style="width: 10%;">S.NO</th>
                                <th style="width: 30%;">Name</th>
                                <th style="width: 40%;">Description</th>
                                <th style="width: 30%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->description }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('categories.show', $category->category_id) }}" class="btn btn-sm btn-success">Show</a>
                                        <a href="{{ route('categories.edit', $category->category_id) }}" class="btn btn-sm btn-success">Edit</a>

                                        <form action="{{ route('categories.destroy', $category->category_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">No Categories Found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    @if(method_exists($categories, 'links'))
                    <div class="mt-2">
                        {{ $categories->appends(request()->query())->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Styling --}}
<style>
    .pagination .page-link {
        color: #fff !important;
        background-color: rgb(27, 45, 56) !important;
        border: 1px solid #00bcd4 !important;
        margin: 0 2px;
        padding: 6px 12px;
        border-radius: 4px;
        box-shadow: 0 0 10px rgba(0, 188, 212, 0.6);
    }

    .pagination .active .page-link {
        background-color: #00bcd4 !important;
        color: #000 !important;
        font-weight: bold;
        border-color: #00bcd4;
        box-shadow: 0 0 15px rgba(0, 188, 212, 0.9);
    }

    .pagination .page-link:hover {
        background-color: rgba(0, 188, 212, 0.7) !important;
        color: #000 !important;
    }

    .container {
        padding: 20px;
    }

    .card.shadow-glow {
        border: 2px solid #00bcd4 !important;
        border-radius: 10px !important;
        box-shadow: 0 0 15px rgba(0, 188, 212, 0.8) !important;
        margin-bottom: 20px;
    }

    .card-body {
        padding: 15px !important;
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

    .table tbody tr:hover {
        background-color: rgba(0, 188, 212, 0.15) !important;
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

    .btn-danger {
        background-color: #dc3545 !important;
        border-color: #dc3545 !important;
        box-shadow: 0 0 10px rgba(220, 53, 69, 0.6);
    }

    .btn-danger:hover {
        background-color: #c82333 !important;
        border-color: #bd2130 !important;
    }

    .btn-success,
    .btn-primary {
        box-shadow: 0 0 8px rgba(0, 188, 212, 0.4);
    }

    .form-control:focus,
    .form-select:focus {
        box-shadow: 0 0 0 0.25rem rgba(0, 188, 212, 0.5) !important;
        border-color: #00bcd4 !important;
    }
</style>
@endsection
