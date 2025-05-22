@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Purchase Stock Records</span>
                    <a href="{{ route('purchase-stocks.create') }}" class="btn btn-primary btn-sm">Add Purchase Stock</a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                    @endif

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Ingredient</th>
                                <th>Initial Quantity</th>
                                <th>Remaining</th>
                                <th>Cost Price</th>
                                <th>Purchase Date</th>
                                <th>Expiry Date</th>
                                <th>Supplier</th>
                                <th width="150">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($purchaseStocks as $stock)
                            <tr>
                                <td>{{ $stock->ingredient->name }}</td>
                                <td>{{ $stock->quantity }} {{ $stock->ingredient->unit }}</td>
                                <td>
                                    {{ $stock->remaining_quantity }} {{ $stock->ingredient->unit }}
                                    @if ($stock->remaining_quantity <= 0)
                                        <span class="badge bg-danger">Out of Stock</span>
                                        @elseif ($stock->remaining_quantity < ($stock->quantity * 0.1))
                                            <span class="badge bg-warning text-dark">Low</span>
                                            @endif
                                </td>
                                <td>${{ number_format($stock->cost_price, 2) }}</td>
                                <td>{{ $stock->purchase_date->format('M d, Y') }}</td>
                                <td>
                                    @if($stock->expiry_date)
                                    {{ $stock->expiry_date->format('M d, Y') }}
                                    @if($stock->expiry_date < now())
                                        <span class="badge bg-danger">Expired</span>
                                        @elseif($stock->expiry_date < now()->addDays(7))
                                            <span class="badge bg-warning text-dark">Expiring Soon</span>
                                            @endif
                                            @else
                                            N/A
                                            @endif
                                </td>
                                <td>{{ $stock->supplier ?? 'N/A' }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('purchase-stocks.show', $stock) }}" class="btn btn-sm btn-primary me-2">Show</a>

                                        <a href="{{ route('purchase-stocks.edit', $stock) }}" class="btn btn-sm btn-warning me-2">Edit</a>

                                        <form action="{{ route('purchase-stocks.destroy', $stock) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </div>

                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">No purchase stock records found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection