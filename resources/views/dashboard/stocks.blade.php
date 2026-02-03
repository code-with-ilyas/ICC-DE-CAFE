@extends('layouts.auth')

@section('content')
<div class="container py-4">

{{-- Quick Stats --}}
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card card-shadow text-center">
            <i class="bi bi-box-seam" style="font-size: 2.5rem; color: #00bcd4;"></i>
            <h5 class="text-white mt-2">Total Stocks</h5>
            <h3 class="text-white">{{ $stocks->count() }}</h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-shadow text-center">
            <i class="bi bi-exclamation-triangle-fill" style="font-size: 2.5rem; color: #ff4d4f;"></i>
            <h5 class="text-white mt-2">Low Stocks</h5>
            <h3 class="text-white">{{ $lowStocks->count() }}</h3>
        </div>
    </div>
</div>



    {{-- Low Stock Alerts --}}
    <div class="card card-shadow mb-4">
        <div class="card-header bg-danger text-white">
            Low Stock Alerts
        </div>
        <div class="card-body p-0">
            @if($lowStocks->isEmpty())
                <div class="p-3">All stocks are sufficient.</div>
            @else
                <table class="table table-bordered table-striped table-custom text-center mb-0">
                    <thead>
                        <tr>
                            <th>Stock</th>
                            <th>Remaining Qty</th>
                            <th>Unit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lowStocks as $stock)
                        <tr>
                            <td>{{ $stock->name }}</td>
                            <td>{{ $stock->displayQuantity() }}</td>
                            <td>{{ $stock->unit }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    {{-- Top 5 Used Ingredients Chart --}}
    <div class="card card-shadow mb-4">
        <div class="card-header bg-info text-white">
            Top 5 Used Ingredients (Last 30 Days)
        </div>
        <div class="card-body">
            <canvas id="topUsedChart"></canvas>
        </div>
    </div>

    {{-- All Stocks Table --}}
    <div class="card card-shadow">
        <div class="card-header bg-secondary text-white">
            All Stocks
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered table-striped table-custom text-center mb-0">
                <thead>
                    <tr>
                        <th>S.NO</th>
                        <th>Name</th>
                        <th>Available Quantity</th>
                        <th>Unit</th>
                        <th>Price per Unit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stocks as $stock)
                    <tr @if($lowStocks->contains($stock)) class="table-danger" @endif>
                        <td>{{ $stock->id }}</td>
                        <td>{{ $stock->name }}</td>
                        <td>{{ $stock->displayQuantity() }}</td>
                        <td>{{ $stock->unit }}</td>
                        <td>{{ $stock->price ? number_format($stock->price, 2) : '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Styling --}}
<style>
    .card-shadow {
        border: 2px solid #00bcd4;
        border-radius: 12px;
        box-shadow: 0 0 20px rgba(0,188,212,0.7);
        padding: 20px;
        margin-bottom: 20px;
        color: #fff;
        background-color: #1c1f26;
        transition: all 0.3s ease;
    }

    .card-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 0 25px rgba(0,188,212,0.9);
    }

    .table-custom {
        width: 100%;
        border: 2px solid #00bcd4;
        color: #fff;
        box-shadow: 0 0 10px rgba(0, 188, 212, 0.5);
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-custom th {
        background-color: rgba(0, 188, 212, 0.3);
        color: #fff;
        font-weight: 600;
        border: 1px solid #00bcd4;
        padding: 10px;
    }

    .table-custom td {
        border: 1px solid #00bcd4;
        color: #fff !important;
        padding: 8px;
    }

    .table-custom tbody tr:nth-child(odd) {
        background-color: rgba(0,188,212,0.05);
    }

    .table-custom tbody tr:hover {
        background-color: rgba(0, 188, 212, 0.2);
    }

    .table-danger {
        background-color: rgba(220,53,69,0.5) !important;
        color: #fff;
    }

    canvas {
        max-height: 400px;
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@php
    $topUsedJson = $topUsed->map(fn($d) => [
        'label' => $d->stock->name,
        'used' => $d->used
    ])->toJson();
@endphp
<script>
const topUsedData = JSON.parse('{!! $topUsedJson !!}');
const labels = topUsedData.map(i => i.label);
const data = topUsedData.map(i => i.used);

const ctx = document.getElementById('topUsedChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Used Quantity (g)',
            data: data,
            backgroundColor: 'rgba(54, 162, 235, 0.7)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1,
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: { mode: 'index', intersect: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                title: { display: true, text: 'Quantity (g)' },
                grid: { color: 'rgba(255,255,255,0.1)' }
            },
            x: {
                grid: { color: 'rgba(255,255,255,0.1)' }
            }
        }
    }
});
</script>
@endsection
