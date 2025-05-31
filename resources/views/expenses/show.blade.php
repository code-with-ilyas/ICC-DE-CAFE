@extends('layouts.auth')

@section('content')
<div class="container py-4">
    <div class="card shadow-glow p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-white mb-0">Expenses Details</h2>
            <a href="{{ route('expenses.index') }}" class="btn btn-success">Back to Expenses</a>
        </div>

        <hr>

        <div class="row mb-3">
            <div class="col-md-6">
                <p><strong class="text-info">Name:</strong> {{ $expense->name }}</p>
            </div>
            <div class="col-md-6">
                <p><strong class="text-info">Amount:</strong> {{ number_format($expense->amount, 2) }}</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <p><strong class="text-info">Date:</strong> {{ $expense->date }}</p>
            </div>
            <div class="col-md-6">
                <p><strong class="text-info">Description:</strong> {{ $expense->description }}</p>
            </div>
        </div>
    </div>
</div>

<style>
    .shadow-glow {
        background-color: #2a2a2a !important;
        color: #e0e0e0 !important;
        border: 2px solid #00bcd4 !important;
        box-shadow: 0 0 15px rgba(0, 188, 212, 0.6) !important;
        border-radius: 10px;
    }

    .text-info {
        color: #00bcd4 !important;
    }

    hr {
        border: none;
        height: 2px;
        background: linear-gradient(90deg,
            rgba(0, 188, 212, 0) 0%,
            rgba(0, 188, 212, 0.8) 25%,
            #00bcd4 50%,
            rgba(0, 188, 212, 0.8) 75%,
            rgba(0, 188, 212, 0) 100%);
        margin-bottom: 30px;
    }

    h2 {
        margin-bottom: 0;
    }
</style>
@endsection
