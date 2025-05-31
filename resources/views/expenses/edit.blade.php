@extends('layouts.auth')

@section('content')
<div class="container py-4 d-flex justify-content-center">
    <div class="card shadow-glow p-4 w-100" style="max-width: 70%;">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <a href="{{ route('expenses.index') }}" class="btn btn-success">Expenses List</a>
            <div>
                <button type="submit" form="expenseForm" class="btn btn-success me-2">Update Expenses</button>
                
            </div>
        </div>
        <hr>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="expenseForm" action="{{ route('expenses.update', $expense->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="name">Expense Name</label>
                    <input type="text" name="name" class="form-control" required value="{{ old('name', $expense->name) }}">
                </div>
                <div class="mb-3 col-md-6">
                    <label for="amount">Amount</label>
                    <input type="number" name="amount" step="0.01" class="form-control" required value="{{ old('amount', $expense->amount) }}">
                </div>
            </div>

            <div class="mb-3">
                <label for="date">Date</label>
                <input type="date" name="date" class="form-control" required value="{{ old('date', $expense->date) }}">
            </div>

            <div class="mb-3">
                <label for="description">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $expense->description) }}</textarea>
            </div>
        </form>
    </div>
</div>

{{-- Retain all custom styles --}}
<style>
    /* All your existing styles remain unchanged */
    .card-header {
        border-bottom: 2px solid #00bcd4 !important;
        padding-bottom: 8px !important;
    }

    .dark-theme .card-header {
        border-bottom: 2px solid #00bcd4 !important;
    }

    .dark-theme .card {
        background-color: #2a2a2a !important;
        color: #e0e0e0 !important;
        border: 2px solid #00bcd4 !important;
        box-shadow: 0 0 12px rgba(0, 188, 212, 0.5) !important;
    }

    hr {
        border: none;
        height: 2px;
        background: linear-gradient(90deg, rgba(0,0,0,0) 0%, rgba(0, 188, 212, 0.8) 20%, #00bcd4 50%, rgba(0, 188, 212, 0.8) 80%, rgba(0,0,0,0) 100%);
        margin: 15px 0;
    }

    .dark-theme .form-control {
        background-color: #2a2a2a;
        color: #e0e0e0;
        border: 1px solid #00bcd4;
    }

    .dark-theme .form-control:focus {
        border-color: #00e5ff;
        box-shadow: 0 0 5px rgba(0, 229, 255, 0.6);
        outline: none;
    }

    .dark-theme label {
        color: #ffffff;
    }

    .dark-theme #order-items-container {
        background-color: #2a2a2a;
        padding: 10px;
        border-radius: 8px;
    }

    .dark-theme #order-items-container .order-item .form-control,
    .dark-theme #order-items-container .order-item .form-select {
        background-color: #2a2a2a;
        color: #e0e0e0;
        border: 1px solid #00bcd4;
        box-shadow: 0 0 5px rgba(0, 188, 212, 0.5);
    }

    .dark-theme #order-items-container .order-item .form-control:focus,
    .dark-theme #order-items-container .order-item .form-select:focus {
        border-color: #00e5ff;
        box-shadow: 0 0 5px rgba(0, 229, 255, 0.6);
        outline: none;
    }

    .dark-theme table.table-bordered {
        border: 2px solid #00bcd4;
    }

    .dark-theme table.table-bordered th,
    .dark-theme table.table-bordered td {
        border: 1px solid #00bcd4;
        color: #e0e0e0;
        background-color: #2a2a2a;
    }

    .dark-theme table.table-bordered thead {
        background-color: #1f1f1f;
        color: #00bcd4;
    }

    .dark-theme .form-select {
        background-color: #2a2a2a;
        color: #e0e0e0;
        border: 1px solid #00bcd4;
    }

    .dark-theme .form-select:focus {
        border-color: #00e5ff;
        box-shadow: 0 0 5px rgba(0, 229, 255, 0.6);
        outline: none;
    }

    .bg-total-container {
        background-color: rgb(8, 3, 78);
        border: 1px solid #00bcd4 !important;
        box-shadow: 0 0 5px rgba(0, 188, 212, 0.5) !important;
    }

    .dark-theme .bg-total-container {
        background-color: rgb(8, 3, 78);
        border: 1px solid #00bcd4 !important;
        box-shadow: 0 0 5px rgba(0, 188, 212, 0.5) !important;
    }

    .bg-total-container h6,
    .bg-total-container #total-amount {
        color: white !important;
    }

    .bg-total-container,
    .dark-theme .bg-total-container {
        border: 2px solid #33eaff !important;
        box-shadow: 0 0 5px rgba(51, 234, 255, 0.6);
        border-radius: 6px;
    }

    #order-items-container,
    .dark-theme #order-items-container {
        border: 2px solid #33eaff;
        box-shadow: 0 0 5px rgba(51, 234, 255, 0.6);
        border-radius: 6px;
        padding: 10px;
    }
</style>
@endsection
