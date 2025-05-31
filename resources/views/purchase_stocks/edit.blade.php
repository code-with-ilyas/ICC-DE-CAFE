@extends('layouts.auth')

@section('content')
<div class="d-flex justify-content-center py-2">
    <form action="{{ route('purchase_stocks.update', $purchaseStock->id) }}" method="POST" style="width: 90%; max-height: 85vh; overflow-y: auto;" class="card shadow-sm">
        @csrf
        @method('PUT')

        <div class="card-header d-flex justify-content-between align-items-center py-2 px-3">
            <a href="{{ route('purchase_stocks.index') }}" class="btn btn-success btn-sm">Show Purchases List</a>
            <button type="submit" class="btn btn-sm btn-success">
                <i class="fas fa-save me-1"></i>Update Purchases
            </button>
        </div>

        <div class="card-body py-2 px-3">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label small">Product Name</label>
                    <input type="text" name="product_name" class="form-control form-control-sm" value="{{ $purchaseStock->product_name }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label small">Quantity</label>
                    <input type="number" name="quantity" class="form-control form-control-sm" value="{{ $purchaseStock->quantity }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label small">Unit Price</label>
                    <input type="number" step="0.01" name="unit_price" class="form-control form-control-sm" value="{{ $purchaseStock->unit_price }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label small">Supplier Name</label>
                    <input type="text" name="supplier_name" class="form-control form-control-sm" value="{{ $purchaseStock->supplier_name }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label small">Date</label>
                <input type="date" name="date" class="form-control form-control-sm" value="{{ $purchaseStock->date }}" required>
            </div>
        </div>
    </form>
</div>
<style>
       /* Add this to your style section */
.card-header {
    border-bottom: 2px solid #00bcd4 !important;
    /* Optional: Add some padding at the bottom to give more space */
    padding-bottom: 8px !important;
}

/* If you want the same styling in dark theme */
.dark-theme .card-header {
    border-bottom: 2px solid #00bcd4 !important;
}
    .dark-theme .card {
        background-color: #2a2a2a !important;
        color: #e0e0e0 !important;
        border: 2px solid #00bcd4 !important;
        /* Teal Blue Border */
        box-shadow: 0 0 12px rgba(0, 188, 212, 0.5) !important;
        /* Light glow */
    }
/* Bright light blue horizontal rule */
hr {
        border: none;
        height: 2px;
        background: linear-gradient(90deg, 
                   rgba(0,0,0,0) 0%, 
                   rgba(0, 188, 212, 0.8) 20%, 
                   #00bcd4 50%, 
                   rgba(0, 188, 212, 0.8) 80%, 
                   rgba(0,0,0,0) 100%);
        margin: 15px 0;
    }

    /* Dark theme form fields */
    .dark-theme .form-control {
        background-color: #2a2a2a;
        /* Dark background */
        color: #e0e0e0;
        /* Light gray text */
        border: 1px solid #00bcd4;
        /* Light blue border */
    }

    .dark-theme .form-control:focus {
        border-color: #00e5ff;
        /* Brighter light blue on focus */
        box-shadow: 0 0 5px rgba(0, 229, 255, 0.6);
        /* Glow effect on focus */
        outline: none;
        /* Remove default outline */
    }

    /* Dark theme label */
    .dark-theme label {
        color: #ffffff;
        /* White text for labels */
    }

    /* Dark theme for order items section */
    .dark-theme #order-items-container {
        background-color: #2a2a2a;
        /* Dark background for Order Items section */
        padding: 10px;
        border-radius: 8px;
        /* Rounded corners */
    }

    /* Light blue borders for order item fields */
    .dark-theme #order-items-container .order-item .form-control,
    .dark-theme #order-items-container .order-item .form-select {
        background-color: #2a2a2a;
        /* Dark background for fields */
        color: #e0e0e0;
        /* Light gray text */
        border: 1px solid #00bcd4;
        /* Light blue border */
        box-shadow: 0 0 5px rgba(0, 188, 212, 0.5);
        /* Light glow effect */
    }

    /* Focus effect for order item fields */
    .dark-theme #order-items-container .order-item .form-control:focus,
    .dark-theme #order-items-container .order-item .form-select:focus {
        border-color: #00e5ff;
        /* Brighter light blue on focus */
        box-shadow: 0 0 5px rgba(0, 229, 255, 0.6);
        /* Glow effect on focus */
        outline: none;
        /* Remove default outline */
    }

    /* Dark theme table styles */
    .dark-theme table.table-bordered {
        border: 2px solid #00bcd4;
        /* Light blue border for table */
    }

    .dark-theme table.table-bordered th,
    .dark-theme table.table-bordered td {
        border: 1px solid #00bcd4;
        /* Light blue border for table cells */
        color: #e0e0e0;
        /* Light gray text */
        background-color: #2a2a2a;
        /* Dark background for table cells */
    }

    .dark-theme table.table-bordered thead {
        background-color: #1f1f1f;
        /* Darker background for table header */
        color: #00bcd4;
        /* Light blue text for table header */
    }

    /* Dark theme select dropdown styles */
    .dark-theme .form-select {
        background-color: #2a2a2a;
        /* Dark background */
        color: #e0e0e0;
        /* Light gray text */
        border: 1px solid #00bcd4;
        /* Light blue border */
    }

    .dark-theme .form-select:focus {
        border-color: #00e5ff;
        /* Brighter blue on focus */
        box-shadow: 0 0 5px rgba(0, 229, 255, 0.6);
        /* Glow effect */
        outline: none;
        /* Remove default outline */
    }



/* Total container styling */
.bg-total-container {
    background-color: rgb(8, 3, 78); /* Your theme color */
    border: 1px solid #00bcd4 !important; /* Matching your theme border */
    box-shadow: 0 0 5px rgba(0, 188, 212, 0.5) !important; /* Glow effect */
}

/* Dark theme specific styles */
.dark-theme .bg-total-container {
    background-color: rgb(8, 3, 78); /* Dark theme color */
    border: 1px solid #00bcd4 !important;
    box-shadow: 0 0 5px rgba(0, 188, 212, 0.5) !important;
}

/* Ensure text is white in both themes */
.bg-total-container h6,
.bg-total-container #total-amount {
    color: white !important;
}
/* Outline for Total field container */
.bg-total-container,
.dark-theme .bg-total-container {
    border: 2px solid #33eaff !important; /* Brighter light blue outline */
    box-shadow: 0 0 5px rgba(51, 234, 255, 0.6); /* Optional glow */
    border-radius: 6px; /* Smooth corners */
}

/* Outline for Order Items container */
#order-items-container,
.dark-theme #order-items-container {
    border: 2px solid #33eaff; /* Brighter light blue outline */
    box-shadow: 0 0 5px rgba(51, 234, 255, 0.6); /* Optional glow */
    border-radius: 6px; /* Optional: rounded edges */
    padding: 10px;
}

    
</style>
@endsection
