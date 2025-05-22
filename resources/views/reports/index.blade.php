@extends('layouts.auth')

@section('content')
<style>
    /* Light Blue Neon Border Effect */
    .neon-border {
        border-color: #00e6ff !important;
        box-shadow: 0 0 10px #00e6ff, 0 0 20px #00e6ff, 0 0 30px #00e6ff;
    }

    /* Table border shine */
    .table-bordered,
    .table-bordered th,
    .table-bordered td {
        border: 1px solid #00e6ff !important;
        box-shadow: inset 0 0 5px #00e6ff;
    }

    /* Table styling */
    .table {
        color: #ffffff;
    }

    .table thead th {
        background-color: rgba(0, 188, 212, 0.2);
        color: rgb(255, 255, 255) !important;
        border-bottom: 2px solid #00e6ff !important;
        box-shadow: 0 0 8px #00e6ff;
    }

    .table tbody tr {
        border-bottom: 1px solid rgba(0, 188, 212, 0.3);
    }

    /* Card styling */
    .card {
        background-color: rgba(102, 81, 81, 0.3);
        backdrop-filter: blur(5px);
        border: 1px solid #00e6ff;
        box-shadow: 0 0 10px #00e6ff;
    }

    .card-title {
        color: #00e6ff !important;
    }

    /* Form control styling */
    .form-control.border-info:focus {
        border-color: #00e6ff;
        box-shadow: 0 0 5px #00e6ff, 0 0 10px #00e6ff;
    }

    .form-control.border-info {
        border: 1px solid #00e6ff !important;
    }

    /* Button styling */
    .btn-info {
        background-color: rgb(10, 151, 64);
        border-color: rgb(10, 151, 64);
        color: #fff;
        box-shadow: 0 0 8px rgba(0, 255, 204, 0.5);
    }

    .btn-info:hover {
        background-color: rgb(10, 151, 64);
        border-color: rgb(10, 151, 64);
        box-shadow: 0 0 12px rgba(0, 255, 204, 0.9);
    }

    /* Text colors */
    .text-white {
        color: #ffffff !important;
    }

    .text-info {
        color: #00e6ff !important;
    }

    /* Background for the page */
    body {
        background: linear-gradient(135deg, rgb(65, 65, 70) 0%, rgb(65, 65, 70) 100%);
    }
</style>

<div class="container py-4">
    <h2 class="mb-4 text-white">📊 Sales Reports</h2>

    <!-- Sales Summary Cards -->
    <div class="row mb-4">
        @foreach (['today' => 'Daily Sale', 'yesterday' => 'Yesterday Sale', 'last_7_days' => 'Last 7 Days', 'this_month' => 'Monthly Sale'] as $key => $label)
            <div class="col-md-3 mb-3">
                <div class="card neon-border h-100">
                    <div class="card-body text-center">
                        <h6 class="card-title text-white">{{ $label }}</h6>
                        <p class="card-text text-white"><strong>Rs {{ number_format($sales[$key], 0) }}</strong></p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Filters -->
    <div class="card neon-border mb-4">
        <div class="card-body">
            <h5 class="card-title text-white">Filters</h5>
            <form method="GET" action="{{ route('reports.index') }}">
                <div class="row align-items-end">
                    <div class="col-md-3 mb-3">
                        <label for="filter" class="text-white">Select Filter</label>
                        <select name="filter" id="filter" class="form-control border-info bg-warning text-dark">
                            <option value="">-- Choose --</option>
                            <option value="today">Today</option>
                            <option value="yesterday">Yesterday</option>
                            <option value="last_7_days">Last 7 Days</option>
                            <option value="this_month">This Month</option>
                            <option value="last_month">Last Month</option>
                            <option value="this_year">This Year</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="start_date" class="text-white">Start Date</label>
                        <input type="date" name="start_date" class="form-control border-info bg-warning text-dark" />
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="end_date" class="text-white">End Date</label>
                        <input type="date" name="end_date" class="form-control border-info bg-warning text-dark" />
                    </div>
                    <div class="col-md-3 mb-3">
                        <button class="btn btn-info w-100">Apply Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card neon-border">
        <div class="card-body">
            <h5 class="card-title text-white">Order Table</h5>
            <div class="table-responsive">
                <table class="table table-bordered neon-border">
                    <thead>
                        <tr>
                            <th class="text-white">ID</th>
                            <th class="text-white">Name</th>
                            <th class="text-white">Table Number</th>
                            <th class="text-white">Products</th>
                            <th class="text-white">Quantity</th>
                            <th class="text-white">Discount</th>
                            <th class="text-white">Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td class="text-white">{{ $order->id }}</td>
                                <td class="text-white">{{ $order->customer_name ?? 'N/A' }}</td>
                                <td class="text-white">{{ $order->table_number ?? 'N/A' }}</td>
                                <td class="text-white">
                                    <ul class="list-unstyled mb-0">
                                        @foreach ($order->items as $item)
                                            <li>{{ $item->product->name }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="text-white">
                                    <ul class="list-unstyled mb-0">
                                        @foreach ($order->items as $item)
                                            <li>{{ $item->quantity }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="text-white">{{ number_format($order->discount, 2) }} PKR</td>
                                <td class="text-white">Rs {{ number_format($order->total_amount, 0) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-white">No orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
