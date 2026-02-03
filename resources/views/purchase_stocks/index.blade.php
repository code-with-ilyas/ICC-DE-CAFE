@extends('layouts.auth')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Purchase Stocks</h4>
        <a href="{{ route('purchase-stocks.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Add Purchase
        </a>
    </div>

    {{-- Filter --}}
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
        </div>
        <div class="col-md-4">
            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary w-100">
                <i class="bi bi-filter"></i> Filter
            </button>
        </div>
    </form>

<<<<<<< Updated upstream
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover text-center">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Supplier</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($purchaseStocks as $stock)
                    <tr>
                        <td>{{ $stock->id }}</td>
                        <td>{{ $stock->supplier_name }}</td>
                        <td>{{ $stock->product_name }}</td>
                        <td>{{ $stock->quantity }}</td>
                        <td>{{ number_format($stock->unit_price,2) }}</td>
                        <td>{{ number_format($stock->total_price,2) }}</td>
                        <td>{{ $stock->date->format('d-m-Y') }}</td>
                        <td>
                            <a href="{{ route('purchase-stocks.show',$stock->id) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('purchase-stocks.edit',$stock->id) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">No records found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
=======
        <div class="row">
            {{-- Table Column --}}
            <div class="col-md-12">
                <div class="card-body">
                    <table class="table table-bordered table-striped shadow-glow">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>P.Name</th>
                                <th>Quantity</th>
                                <th>U.Price</th>
                                <th>T.Price</th>
                                <th>Supplier Name</th>
                                <th>Number</th>
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
>>>>>>> Stashed changes

            {{ $purchaseStocks->links() }}
        </div>
    </div>
</div>
@endsection
