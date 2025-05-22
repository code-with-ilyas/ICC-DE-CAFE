@extends('layouts.auth')

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header">
            <h5>Create Invoice</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('invoices.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="order_id" class="form-label">Select Order</label>
                    <select name="order_id" class="form-control" required>
                        <option value="">-- Select Order --</option>
                        @foreach($orders as $order)
                            <option value="{{ $order->id }}">
                                Order #{{ $order->id }} - {{ $order->customer_name }} ({{ $order->total_amount }} PKR)
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Generate Invoice</button>
                <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
