@extends('layouts.auth')

@section('content')
<div class="container mt-4">

@php
    $year = request()->filled('start_date')
        ? \Carbon\Carbon::parse(request('start_date'))->year
        : now()->year;

    $icons = [
        'cheese'  => '🧀',
        'chicken' => '🍗',
        'fries'   => '🍟'
    ];

    $displayNames = [
        'cheese'  => 'Cheese Used In Each Pizza (Grams)',
        'chicken' => 'Chicken Used In Each Pizza (Grams)',
        'fries'   => 'French Fries Used In Orders (Grams)'
    ];

    $cheeseHeaderSequence = ['small','medium','large'];

    $monthNames = [
        1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'May',6=>'Jun',
        7=>'Jul',8=>'Aug',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dec'
    ];
@endphp

<h2 class="mb-4 text-white fw-bold">
    Ingredients Calculation Report - {{ $year }}
</h2>

<div class="mb-3 d-flex justify-content-end">
    <a href="{{ route('ingredients.pdf', request()->only(['start_date','end_date'])) }}"
       class="btn btn-danger">
        <i class="fas fa-file-pdf me-2"></i> Download PDF
    </a>
</div>

<form method="GET" action="{{ route('ingredients.index') }}" class="row g-3 mb-4">
    <div class="col-md-3">
        <label class="form-label text-white">From Date</label>
        <input type="date" name="start_date" class="form-control"
               value="{{ request('start_date') }}">
    </div>

    <div class="col-md-3">
        <label class="form-label text-white">To Date</label>
        <input type="date" name="end_date" class="form-control"
               value="{{ request('end_date') }}">
    </div>

    <div class="col-md-3 align-self-end">
        <button type="submit" class="btn btn-primary w-100">Filter</button>
    </div>
</form>

{{-- INGREDIENT TOTAL TABLES --}}
@foreach($ingredients as $ingredient => $data)
<div class="card mb-4 shadow-sm border-0 rounded-4">
    <div class="card-header text-white fw-bold"
         style="background: linear-gradient(90deg,#1e3c72,#2a5298);">
        {{ $icons[$ingredient] }}
        {{ $displayNames[$ingredient] }} - {{ $year }}
    </div>

    <div class="card-body p-0">
        <table class="table table-hover text-center compact-table mb-0">
            <thead class="text-white"
                   style="background: linear-gradient(90deg,#6a11cb,#2575fc);">
            <tr>
                @php
                    $subKeys = in_array($ingredient,['cheese','chicken'])
                        ? $cheeseHeaderSequence
                        : array_filter(array_keys($data), fn($k)=>$k!=='total');
                @endphp
                @foreach($subKeys as $key)
                    <th>{{ ucfirst(str_replace('_',' ',$key)) }}</th>
                @endforeach
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                @foreach($subKeys as $key)
                    <td><span class="badge value-badge">{{ $data[$key] ?? 0 }}</span></td>
                @endforeach
                <td><span class="badge value-badge fw-bold">{{ $data['total'] ?? 0 }}</span></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
@endforeach

{{-- ✨ NEW STYLED MONTHLY REPORT TABLES --}}
@foreach(['cheese','chicken','fries'] as $ingredient)
<div class="card mb-4 shadow-lg border-0 rounded-4 monthly-card">

    <div class="card-header text-white fw-bold d-flex align-items-center justify-content-between"
         style="background: linear-gradient(90deg,#1e3c72,#2a5298);">
        <span>{{ $icons[$ingredient] }} Monthly {{ ucfirst($ingredient) }} Usage</span>
        <span class="year-chip">{{ $year }}</span>
    </div>

    <div class="table-responsive">
        <table class="table monthly-table text-center mb-0">
            <thead class="text-white"
                   style="background: linear-gradient(90deg,#6a11cb,#2575fc);">
            <tr>
                @foreach($monthNames as $m)
                    <th class="month-head">{{ $m }}</th>
                @endforeach
                <th class="total-head">Total</th>
            </tr>
            </thead>

            <tbody>
            <tr>
                @php $grandTotal = 0; @endphp

                @foreach(range(1,12) as $m)
                    @php
                        $val = $monthlySummary[$m][$ingredient]['total'] ?? 0;
                        $grandTotal += $val;
                    @endphp
                    <td>
                        <div class="month-pill">
                            {{ $val }}
                        </div>
                    </td>
                @endforeach

                <td>
                    <div class="month-pill total-pill">
                        {{ $grandTotal }}
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
@endforeach

</div>

<style>
/* ===== EXISTING ===== */
.value-badge{
    background:#fd7e14;
    color:#212529;
    min-width:45px;
    font-size:.85rem;
}
.compact-table th,.compact-table td{
    padding:.35rem;
    font-size:.8rem;
}

/* ===== NEW MONTHLY STYLE ===== */
.monthly-card{
    overflow:hidden;
}

.monthly-table th,
.monthly-table td{
    padding: .75rem;
}

.month-head{
    font-size:.8rem;
    letter-spacing:.5px;
}

.month-pill{
    background:#fd7e14;
    color:#212529;
    border-radius:20px;
    padding:.45rem .6rem;
    font-size:.8rem;
    font-weight:600;
    transition: all .25s ease;
}

.month-pill:hover{
    transform: translateY(-3px);
    box-shadow: 0 6px 15px rgba(0,0,0,.25);
}

.total-pill{
    background:#ffc107;
    font-weight:700;
}

.total-head{
    font-weight:700;
}

.year-chip{
    background:rgba(255,255,255,.15);
    padding:.25rem .6rem;
    border-radius:12px;
    font-size:.75rem;
}
</style>
@endsection
