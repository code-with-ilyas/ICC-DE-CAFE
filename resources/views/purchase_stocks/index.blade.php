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

            {{ $purchaseStocks->links() }}
        </div>
    </div>
</div>
@endsection
