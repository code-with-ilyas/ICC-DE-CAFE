@extends('layouts.auth')

@section('content')
<div class="container" style="overflow: hidden;"> <!-- Disable scrolling -->
    <h2 class="mb-4 text-white">Stock Details</h2>

    <table class="table table-bordered table-striped shadow-glow text-center align-middle">
        <tbody>
            <tr>
                <th style="width: 30%;">Name</th>
                <td>{{ $stock->name }}</td>
            </tr>
            <tr>
                <th>Quantity</th>
                <td>{{ $stock->displayQuantity() }}</td>
            </tr>
            <tr>
                <th>Price per unit</th>
                <td>{{ $stock->price ? number_format($stock->price, 2) : '-' }}</td>
            </tr>
            <tr>
                <th>Description</th>
                <td>{{ $stock->description }}</td>
            </tr>
            <tr>
                <th>Created at</th>
                <td>{{ $stock->created_at }}</td>
            </tr>
            <tr>
                <th>Updated at</th>
                <td>{{ $stock->updated_at }}</td>
            </tr>
        </tbody>
    </table>

    <div class="mt-3">
        <a href="{{ route('stocks.index') }}" class="btn btn-success">Back</a>
    </div>
</div>

{{-- Styling --}}
<style>
    .container {
        padding: 20px;
    }

    table.shadow-glow {
        width: 100%;
        border: 2px solid #00bcd4 !important;
        color: white !important;
        box-shadow: 0 0 10px rgba(0, 188, 212, 0.5);
    }

    table thead th, table tbody th {
        background-color: rgba(0, 188, 212, 0.3);
        border-bottom: 2px solid #00bcd4 !important;
        color: white !important;
        font-weight: 600;
    }

    table tbody td {
        border: 1px solid #00bcd4 !important;
        color: white !important;
    }

    table tbody tr:hover {
        background-color: rgba(0, 188, 212, 0.15) !important;
    }

    .btn-success, .btn-primary {
        box-shadow: 0 0 8px rgba(0, 188, 212, 0.4);
        padding: 6px 12px;
        font-size: 0.9rem;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    html, body {
        overflow: hidden; /* Disable full-page scrolling */
        height: 100%;
        width: 100%;
    }
</style>
@endsection
