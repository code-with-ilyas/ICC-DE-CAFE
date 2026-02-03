@extends('layouts.auth')

@section('content')
<div class="container">
    {{-- Orders Table --}}
    <div class="card shadow-glow">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h4 class="mb-0 text-white">Orders List</h4>
            <a href="{{ route('orders.create') }}" class="btn btn-success">+ ADD Order</a>
        </div>
        <hr>
        <div class="card-body">
            <table class="table table-bordered table-striped shadow-glow">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Table</th>
                        <th>Products</th>
                        <th>Quantity</th>
                        <th>Discount</th>
                        <th>Amount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $index => $order)
                    <tr>
                        <td>{{ $orders->firstItem() + $index }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td>{{ $order->table_number ?? 'N/A' }}</td>
                        <td>
                            <ul class="list-unstyled mb-0">
                                @foreach ($order->items as $item)
                                <li>{{ $item->product->name ?? 'Unknown' }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <ul class="list-unstyled mb-0">
                                @foreach ($order->items as $item)
                                <li>{{ $item->quantity }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ number_format($order->discount, 2) }} PKR</td>
                        <td>{{ number_format($order->total_amount, 2) }} PKR</td>
                        <td>
                            <div class="d-flex flex-wrap gap-1 align-items-center">
                                <!-- <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-success">Show</a> -->
                                <a href="{{ route('orders.edit', $order) }}" class="btn btn-sm btn-success">Edit</a>
                                <a href="{{ route('orders.kitchen.print', $order->id) }}" class="btn btn-sm btn-primary">KP</a>
                                <a href="{{ route('orders.print', $order) }}" class="btn btn-sm btn-warning">Print</a>

                                <form action="{{ route('orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No Orders Found</td>
                    </tr>
                    @endforelse
                    


                </tbody>
            </table>
            <hr>
            {{-- Grand Total Always Shown --}}
                    <div class="d-flex justify-content-end text-white fw-bold fs-5 mb-3">
                        Grand Total: Rs. {{ number_format($orders->sum('total_amount'), 2) }}
                    </div>


            <div class="mt-2">
                {{ $orders->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

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

    .form-control:focus,
    .form-select:focus {
        box-shadow: 0 0 0 0.25rem rgba(0, 188, 212, 0.5) !important;
        border-color: #00bcd4 !important;
    }
</style>
@endsection