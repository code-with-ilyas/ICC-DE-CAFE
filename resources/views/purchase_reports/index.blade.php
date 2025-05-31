@extends('layouts.auth')

@section('content')
<style>
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

    .text-white {
        color: #ffffff !important;
    }

    .text-info {
        color: #00e6ff !important;
    }

    .text-success {
        color: #00ff88 !important;
    }

    .custom-date-display {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        background-color: rgba(0, 230, 255, 0.05);
        border: 1px dashed #00e6ff;
        border-radius: 10px;
        color: #ffffff;
        font-weight: 500;
        padding: 15px;
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
    <h2 class="mb-4 text-white">📊 Purchase Stock Reports</h2>

    <!-- Summary Cards -->
    @foreach (array_chunk([
        'today' => 'Daily Purchase',
        'yesterday' => 'Yesterday Purchase',
        'last_7_days' => 'Last 7 Days Purchase',
        'this_month' => 'Monthly Purchase',
        'last_month' => 'Last Month Purchase',
        'this_year' => 'This Year Purchase',
        'last_year' => 'Last Year Purchase',
        'current_financial_year' => 'Current Financial Year Purchase',
        'last_financial_year' => 'Last Financial Year Purchase'
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

    <!-- Custom Date Range Display -->
    @if(request('start_date') && request('end_date'))
        <div class="row mb-4">
            <div class="col-12">
                <div class="custom-date-display">
                    Showing results from <span class="text-info mx-1">{{ request('start_date') }}</span> 
                    to <span class="text-info mx-1">{{ request('end_date') }}</span>
                </div>
            </div>
        </div>
    @endif

    <!-- Filters -->
    <div class="card neon-border mb-4">
        <div class="card-body">
            <h5 class="card-title text-info">Filter by Date Range</h5>
            <form method="GET" action="{{ route('purchase-reports.index') }}">
                <div class="row align-items-end">
                    <div class="col-md-4 mb-3">
                        <label for="start_date" class="text-white">Start Date</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control border-info bg-warning" />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="end_date" class="text-white">End Date</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control border-info bg-warning" />
                    </div>
                    <div class="col-md-4 mb-3">
                        <button class="btn btn-info w-100">Apply Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Purchase Table -->
    <div class="card neon-border">
        <div class="card-header text-white">
            <h5 class="mb-0 text-white">Purchase Stock Report Table</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered text-white mb-0">
                    <thead>
                        <tr>
                            <th>S.NO</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Supplier Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($purchaseStocks as $index => $stock)
                            <tr>
                                <td>{{ $purchaseStocks->firstItem() + $index }}</td>
                                <td>{{ $stock->product_name }}</td>
                                <td>{{ $stock->quantity }}</td>
                                <td>Rs {{ number_format($stock->unit_price, 2) }}</td>
                                <td>{{ $stock->supplier_name }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-danger">No purchase records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            <div class="mt-3 px-3">
                {{ $purchaseStocks->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection