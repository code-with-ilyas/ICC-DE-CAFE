@extends('layouts.auth')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0 text-white">Categories</h3>
            <a href="{{ route('categories.create') }}" class="btn btn-success">Add New Category</a>
        </div>

        <table class="table table-bordered text-center align-middle">
            <thead style="background-color: white; color: black;"> <!-- White header -->
                <tr>
                    <th style="width: 30%;">Name</th>
                    <th style="width: 40%;">Description</th>
                    <th style="width: 30%;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                <tr style="background-color: #f8f9fa;"> <!-- Light gray row -->
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->description }}</td>
                    <td>
                        <a href="{{ route('categories.edit', $category->category_id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('categories.destroy', $category->category_id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?');">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<style>
    .dark-theme .card {
    background-color: #2a2a2a !important;
    color: #e0e0e0 !important;
    border: 2px solid #00bcd4 !important; /* Teal Blue Border */
    box-shadow: 0 0 12px rgba(0, 188, 212, 0.5) !important; /* Light glow */
}

.dark-theme table.table-bordered {
    border: 2px solid #00bcd4;
}

.dark-theme table.table-bordered th,
.dark-theme table.table-bordered td {
    border: 1px solid #00bcd4;
    color: #e0e0e0;
    background-color: #2a2a2a;
}

.dark-theme table.table-bordered thead {
    background-color: #1f1f1f;
    color: #00bcd4;
}


</style>
@endsection
