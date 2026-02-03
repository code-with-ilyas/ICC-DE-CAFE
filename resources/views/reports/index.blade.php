@extends('layouts.auth')

@section('content')
<style>

      .icon-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #fff;
            margin: 0 auto;
            box-shadow: 0 0 15px rgba(0, 188, 212, 0.7);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        /* Card Hover Effect */
        .hover-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-card:hover {
            transform: translateY(-8px) scale(1.05);
            box-shadow: 0 0 25px rgba(0, 188, 212, 1), 0 0 35px rgba(0, 188, 212, 0.8);
        }

        /* Icon hover glow */
        .hover-card:hover .icon-circle {
            transform: rotate(10deg) scale(1.1);
            box-shadow: 0 0 25px rgba(0, 188, 212, 1);
        }
 

   
        .icon-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #fff;
            margin: 0 auto;
            box-shadow: 0 0 15px rgba(0, 188, 212, 0.7);
        }
   

    .neon-border {
        border-color: #00e6ff !important;
        box-shadow: 0 0 10px rgba(0, 230, 255, 0.3), 0 0 20px rgba(0, 230, 255, 0.2), 0 0 30px rgba(0, 230, 255, 0.1);
        transition: box-shadow 0.3s ease;
    }

    .neon-border:hover {
        box-shadow: 0 0 15px rgba(0, 230, 255, 0.4), 0 0 25px rgba(0, 230, 255, 0.3), 0 0 35px rgba(0, 230, 255, 0.2);
    }

    .summary-card {
        min-height: 120px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .summary-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0 20px rgba(0, 230, 255, 0.4) !important;
    }

    .summary-amount {
        font-size: 1.1rem;
        color: #00ff88 !important;
    }

    .table-bordered,
    .table-bordered th,
    .table-bordered td {
        border: 1px solid #00e6ff !important;
        box-shadow: inset 0 0 5px rgba(0, 230, 255, 0.1);
    }

    .table {
        color: #ffffff;
        margin-bottom: 0;
    }

    .table thead th {
        background-color: rgba(0, 188, 212, 0.2);
        color: rgb(255, 255, 255) !important;
        border-bottom: 2px solid #00e6ff !important;
        box-shadow: 0 0 8px rgba(0, 230, 255, 0.3);
        font-weight: 600;
    }

    .table tbody tr {
        border-bottom: 1px solid rgba(0, 188, 212, 0.3);
        transition: background-color 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: rgba(0, 230, 255, 0.05) !important;
    }

    .table tfoot th {
        background-color: rgba(0, 188, 212, 0.3);
        color: rgb(255, 255, 255) !important;
        border-top: 2px solid #00e6ff !important;
        box-shadow: 0 0 8px rgba(0, 230, 255, 0.3);
    }

    .table-total {
        background-color: rgba(0, 230, 255, 0.1) !important;
    }

    .card {
        background-color: rgba(102, 81, 81, 0.3);
        backdrop-filter: blur(5px);
        border: 1px solid #00e6ff;
        box-shadow: 0 0 10px rgba(0, 230, 255, 0.2);
    }

    .card-title {
        color: #00e6ff !important;
        font-weight: 600;
    }

    .form-control.border-info {
        border: 1px solid #00e6ff !important;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control.border-info:focus {
        border-color: #00e6ff;
        box-shadow: 0 0 5px rgba(0, 230, 255, 0.3), 0 0 10px rgba(0, 230, 255, 0.2);
        background-color: #fff3cd !important;
    }

    .btn-info {
        background-color: rgb(10, 151, 64);
        border-color: rgb(10, 151, 64);
        color: #fff;
        box-shadow: 0 0 8px rgba(0, 255, 204, 0.3);
        transition: all 0.2s ease;
        font-weight: 500;
    }

    .btn-info:hover {
        background-color: rgb(8, 130, 55);
        border-color: rgb(8, 130, 55);
        box-shadow: 0 0 12px rgba(0, 255, 204, 0.5);
        transform: translateY(-1px);
    }

    .btn-outline-light {
        border-color: #00e6ff;
        color: #00e6ff;
        transition: all 0.2s ease;
    }

    .btn-outline-light:hover {
        background-color: #00e6ff;
        border-color: #00e6ff;
        color: #000;
    }

    .text-white {
        color: #ffffff !important;
    }

    .text-info {
        color: #00e6ff !important;
    }

    .text-success {
        color: #00ff88 !important;
    }

    body {
        background: linear-gradient(135deg, rgb(65, 65, 70) 0%, rgb(65, 65, 70) 100%);
        min-height: 100vh;
    }

    .text-right {
        text-align: right !important;
    }

    .alert {
        border-radius: 0.5rem;
        border: 1px solid rgba(0, 230, 255, 0.3);
    }

    .alert-info {
        background-color: rgba(0, 230, 255, 0.1);
        border-color: #00e6ff;
        color: #fff;
    }

    .alert-danger {
        background-color: rgba(255, 0, 0, 0.1);
        border-color: #ff4444;
        color: #ff6666;
    }

    .badge {
        font-size: 0.75rem;
    }

    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .summary-card {
            min-height: 100px;
        }

        .summary-amount {
            font-size: 1rem;
        }

        .table-responsive {
            font-size: 0.9rem;
        }

        .container {
            padding: 1rem;
        }
    }

    /* Loading animation for cards */
    .summary-card {
        animation: fadeInUp 0.6s ease forwards;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

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

    .form-control.bg-warning {
        background-color: rgba(255, 193, 7, 0.2) !important;
        color: white !important;
    }

    .form-control.bg-warning:focus {
        background-color: rgba(255, 193, 7, 0.3) !important;
    }
</style>

<div class="container py-4">
    <h2 class="mb-4 text-white">📊 Sales Reports</h2>
    <!-- Sales Summary Small Cards with Icons & Hover Animation -->
    <div class="row mb-4">
        <!-- Total Sales -->
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card text-center shadow-glow h-100 hover-card">
                <div class="card-body py-4">
                    <div class="icon-circle bg-success mb-3">
                        💰
                    </div>
                    <h6 class="text-white">TOTAL SALE</h6>
                    <h4 class="text-success mt-2">Rs {{ number_format($totalSalesOverall ?? 0, 2) }}</h4>
                </div>
            </div>
        </div>

        <!-- Purchases -->
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card text-center shadow-glow h-100 hover-card">
                <div class="card-body py-4">
                    <div class="icon-circle bg-warning mb-3">
                        📦
                    </div>
                    <h6 class="text-white">PURCHASES</h6>
                    <h4 class="text-warning mt-2">Rs {{ number_format($purchaseTotal ?? 0, 2) }}</h4>
                </div>
            </div>
        </div>

        <!-- Expenses -->
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card text-center shadow-glow h-100 hover-card">
                <div class="card-body py-4">
                    <div class="icon-circle bg-danger mb-3">
                        💸
                    </div>
                    <h6 class="text-white">EXPENSES</h6>
                    <h4 class="text-danger mt-2">Rs {{ number_format($expenseTotal ?? 0, 2) }}</h4>
                </div>
            </div>
        </div>

        <!-- Net Total -->
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card text-center shadow-glow h-100 hover-card">
                <div class="card-body py-4">
                    <div class="icon-circle bg-info mb-3">
                        ✅
                    </div>
                    <h6 class="text-white">NET TOTAL</h6>
                    <h4 class="text-success mt-2">Rs {{ number_format($netTotal ?? 0, 2) }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom CSS for Icon Circles & Hover Animation -->
   
      

    <!-- Summary Cards -->
    @foreach (array_chunk([
    'today' => 'Daily Sale',
    'yesterday' => 'Yesterday Sale',
    'last_7_days' => 'Last 7 Days Sale',
    'this_month' => 'Monthly Sale',
    'last_month' => 'Last Month Sale',
    'this_year' => 'This Year Sale',
    'last_year' => 'Last Year Sale',
    'current_financial_year' => 'Current Financial Year Sale',
    'last_financial_year' => 'Last Financial Year Sale'
    ], 3, true) as $chunk)
    <div class="row mb-4">
        @foreach ($chunk as $key => $label)
        <div class="col-md-4 mb-3">
            <div class="card neon-border h-100">
                <div class="card-body text-center">
                    <h6 class="card-title text-info">{{ $label }}</h6>
                    <p class="card-text text-white">
                        <strong class="summary-amount">Rs {{ number_format($sales[$key] ?? 0, 0) }}</strong>
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endforeach

    <!-- Date Filter Form -->
    <div class="card neon-border mb-4">
        <div class="card-body">
            <h5 class="card-title text-info">Filter by Date Range</h5>
            <form method="GET" action="{{ route('reports.index') }}">
                <div class="row align-items-end">
                    <div class="col-md-4 mb-3">
                        <label class="text-white">Start Date</label>
                        <input type="date" name="start_date" value="{{ old('start_date', $startDate) }}"
                            class="form-control border-info bg-warning text-dark" />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="text-white">End Date</label>
                        <input type="date" name="end_date" value="{{ old('end_date', $endDate) }}"
                            class="form-control border-info bg-warning text-dark" />
                    </div>
                    <div class="col-md-4 mb-3">
                        <button class="btn btn-info w-100">Apply Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- New: Items Sold Summary -->
    @if(isset($itemsSoldToday) && $itemsSoldToday->count())
    <div class="card neon-border mb-4">
        <div class="card-body">
            <h5 class="card-title text-info">🧮 Items Sold {{ $startDate && $endDate ? 'from '. $startDate .' to '. $endDate : 'Today' }}</h5>
            <ul class="list-group">
                @foreach($itemsSoldToday as $name => $qty)
                <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white border-info">
                    {{ $name }}
                    <span class="badge bg-info text-dark">{{ $qty }}</span>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif



    <!-- Orders Table -->
    @if($orders->count())
    <div class="card neon-border mb-4">
        <div class="card-body">
            <h5 class="card-title text-info">Order Table</h5>
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
                        @foreach($orders as $order)
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
                            <td class="text-white">{{ number_format($order->total_amount, 2) }} PKR</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3 px-3">{{ $orders->withQueryString()->links() }}</div>
        </div>
    </div>
    @else
    <div class="alert alert-info text-center">No orders found for the selected filter.</div>
    @endif
</div>
@endsection