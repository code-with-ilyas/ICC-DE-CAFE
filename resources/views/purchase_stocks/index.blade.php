@extends('layouts.auth')

@section('content')
<div class="container">
    {{-- Purchase Stock Table --}}
    <div class="card shadow-glow">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h4 class="mb-0 text-white">Purchases Stock List</h4>
            <a href="{{ route('purchase_stocks.create') }}" class="btn btn-success">+ Add Stock</a>
        </div>
        <hr>

        <div class="row">
            {{-- Table Column --}}
            <div class="col-md-12">
                <div class="card-body">
                    <table class="table table-bordered table-striped shadow-glow">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total Price</th>
                                <th>Supplier Name</th>
                                <th>Supplier Number</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $grandTotal = 0; @endphp
                            @forelse($purchaseStocks as $stock)
                            @php $grandTotal += $stock->total_price; @endphp
                            <tr>
                                <td>{{ $purchaseStocks->firstItem() + $loop->index }}</td>
                                <td>{{ $stock->product_name }}</td>
                                <td>{{ $stock->quantity }}</td>
                                <td>{{ number_format($stock->unit_price, 2) }}</td>
                                <td>{{ number_format($stock->total_price, 2) }}</td>
                                <td>{{ $stock->supplier_name }}</td>
                                <td>{{ $stock->supplier_number ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($stock->date)->format('d-F-Y') }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('purchase_stocks.show', $stock->id) }}" class="btn btn-sm btn-success">Show</a>
                                        <a href="{{ route('purchase_stocks.edit', $stock->id) }}" class="btn btn-sm btn-success">Edit</a>
                                        <form action="{{ route('purchase_stocks.destroy', $stock->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">No Purchase Stocks Found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{-- Grand Total Below Table --}}
                    <hr>
                    <div class="text-end">
                        <h5 class="text-white">Grand Total: <span class="text-success">{{ number_format($grandTotal, 2) }}</span></h5>
                    </div>
                    <hr>


                    {{-- Pagination --}}
                    @if(method_exists($purchaseStocks, 'links'))
                    <div class="mt-2">
                        {{ $purchaseStocks->appends(request()->query())->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Your existing style remains unchanged --}}
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