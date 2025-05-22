@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Purchase Stock Details</div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Ingredient</th>
                            <td>{{ $purchaseStock->ingredient->name }} ({{ $purchaseStock->ingredient->unit }})</td>
                        </tr>
                        <tr>
                            <th>Quantity</th>
                            <td>{{ $purchaseStock->quantity }}</td>
                        </tr>
                        <tr>
                            <th>Cost Price</th>
                            <td>${{ number_format($purchaseStock->cost_price, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Purchase Date</th>
                            <td>{{ \Carbon\Carbon::parse($purchaseStock->purchase_date)->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th>Expiry Date</th>
                            <td>{{ $purchaseStock->expiry_date ? \Carbon\Carbon::parse($purchaseStock->expiry_date)->format('d M Y') : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Supplier</th>
                            <td>{{ $purchaseStock->supplier ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Batch Number</th>
                            <td>{{ $purchaseStock->batch_number ?? 'N/A' }}</td>
                        </tr>
                    </table>

                    <div class="mt-4 d-flex justify-content-between">
                        <a href="{{ route('purchase-stocks.index') }}" class="btn btn-secondary">Back to List</a>
                        
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
