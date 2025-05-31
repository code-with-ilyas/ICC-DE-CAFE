@extends('layouts.auth')

@section('content')
<div class="container py-4">
    <div class="card shadow-glow">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0 text-white">Expenses List</h2>
                <a href="{{ route('expenses.create') }}" class="btn btn-success">+ Add Expense</a>
            </div>
            <hr>
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="GET" class="d-flex gap-2 mb-3 align-items-center">
                <select name="month" class="form-select custom-month" style="max-width: 220px;">
                    <option value="">Select Month</option>
                    @foreach(range(1, 12) as $m)
                    <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                    </option>
                    @endforeach
                </select>

                <select name="year" class="form-select custom-month" style="max-width: 160px;">
                    <option value="">Select Year</option>
                    @foreach(range(2025, now()->year + 5) as $y)
                    <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                    @endforeach
                </select>

                <button class="btn btn-warning" type="submit" style="min-width: 120px;">Filter</button>
                <a href="{{ route('expenses.index') }}" class="btn btn-danger" style="min-width: 120px;">Reset</a>
            </form>

            <table class="table table-bordered table-hover shadow-glow">
                <thead class="table-dark">
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenses as $index => $expense)
                    <tr>
                        <td>{{ $expenses->firstItem() + $index }}</td>
                        <td>{{ $expense->name }}</td>
                        <td>{{ $expense->description }}</td>
                        <td>Rs. {{ number_format($expense->amount, 2) }}</td>
                        <td>{{ \Carbon\Carbon::parse($expense->date)->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('expenses.show', $expense) }}" class="btn btn-sm btn-success">Show</a>
                            <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-sm btn-success">Edit</a>
                            <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Delete this expense?')" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No expenses found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <hr>

            <div class="d-flex justify-content-end text-white fw-bold fs-5 mb-3">
                Grand Total: Rs. {{ number_format($total, 2) }}
            </div>

            {{ $expenses->withQueryString()->links() }}
        </div>
    </div>
</div>
<style>
    /* Custom month dropdown */
    .form-select.custom-month {
        background-color: rgba(255, 193, 7, 0.2) !important;
        color: black !important;
        border: 1px solid #ffc107 !important;
        transition: background-color 0.3s ease;
    }

    .form-select.custom-month:focus {
        background-color: rgba(255, 193, 7, 0.3) !important;
        color: white !important;
        outline: none;
        box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.5) !important;
        border-color: #e0a800 !important;
    }

    .form-select.custom-month option {
        background-color: rgba(255, 193, 7, 0.3);
        color: black;
    }

    .form-select.custom-month::-ms-expand {
        filter: invert(1);
    }

    /* Pagination styles */
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
