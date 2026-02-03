@extends('layouts.auth')

@section('content')
<div class="container mt-4">

    <h2 class="mb-2 text-white fw-bold">📊 Sales Dashboard</h2>

    {{-- YEAR / MONTH FILTER --}}
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-3">
            <select name="year" class="form-select">
                <option value="">All Years</option>
                @for($y = now()->year; $y >= now()->year - 5; $y--)
                    <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endfor
            </select>
        </div>

        <div class="col-md-3">
            <select name="month" class="form-select">
                <option value="">All Months</option>
                @for($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                        {{ date('F', mktime(0,0,0,$m,1)) }}
                    </option>
                @endfor
            </select>
        </div>

        <div class="col-md-2">
            <button class="btn btn-info w-100">Apply</button>
        </div>
    </form>

    {{-- TABS --}}
    <ul class="nav nav-tabs mb-3" id="dashboardTabs">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#gridView">Grid</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#circleView">Categories</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tableView">Table</button>
        </li>
    </ul>

    <div class="tab-content">

        {{-- GRID --}}
        <div class="tab-pane fade show active" id="gridView">
            <div class="row g-3">
                @foreach($overallProductSales as $item)
                @php
                    $todayQty = $todayProductSales->firstWhere('product_id', $item->product_id)->total_quantity ?? 0;
                    $yesterdayQty = $yesterdayProductSales->firstWhere('product_id', $item->product_id)->total_quantity ?? 0;
                    $monthlyQty = $monthlyProductSales->firstWhere('product_id', $item->product_id)->total_quantity ?? 0;
                @endphp
                <div class="col-md-3">
                    <div class="pro-card p-3 text-center shadow-glow">
                        <h6 class="text-white">{{ $item->product->name ?? 'N/A' }}</h6>
                        <span class="text-success">Today: {{ $todayQty }}</span><br>
                        <span class="text-warning">Yesterday: {{ $yesterdayQty }}</span><br>
                        <span class="text-info">Selected: {{ $monthlyQty }}</span><br>
                        <span class="text-primary fw-bold">Total: {{ $item->total_quantity }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- CATEGORY --}}
        <div class="tab-pane fade" id="circleView">
            <div class="row g-3">
                @foreach($overallCategorySales as $cat => $qty)
                <div class="col-md-3 text-center">
                    <div class="circle-card p-4 shadow-glow">
                        <div class="circle">{{ $qty }}</div>
                        <h6 class="text-white">{{ $cat }}</h6>
                        <small class="text-success">Today: {{ $todayCategorySales[$cat] ?? 0 }}</small><br>
                        <small class="text-warning">Yesterday: {{ $yesterdayCategorySales[$cat] ?? 0 }}</small><br>
                        <small class="text-info">Selected: {{ $monthlyCategorySales[$cat] ?? 0 }}</small>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- TABLE --}}
        <div class="tab-pane fade" id="tableView">
            @foreach($overallCategorySales as $cat => $qty)
            <div class="card mb-3 shadow-glow">
                <div class="card-body">
                    <h5 class="text-warning">{{ $cat }}</h5>
                    <table class="table table-dark table-sm text-center">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Today</th>
                                <th>Yesterday</th>
                                <th>Selected</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($overallProductSales->filter(fn($i) =>
                                ($i->product->category->name ?? 'Uncategorized') === $cat
                            ) as $item)
                            @php
                                $todayQty = $todayProductSales->firstWhere('product_id', $item->product_id)->total_quantity ?? 0;
                                $yesterdayQty = $yesterdayProductSales->firstWhere('product_id', $item->product_id)->total_quantity ?? 0;
                                $monthlyQty = $monthlyProductSales->firstWhere('product_id', $item->product_id)->total_quantity ?? 0;
                            @endphp
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $todayQty }}</td>
                                <td>{{ $yesterdayQty }}</td>
                                <td>{{ $monthlyQty }}</td>
                                <td class="fw-bold">{{ $item->total_quantity }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</div>
@endsection
