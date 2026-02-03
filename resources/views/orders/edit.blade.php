@extends('layouts.auth')

@section('content')
<div class="d-flex justify-content-center py-2">
    <form action="{{ route('orders.update', $order->id) }}" method="POST" style="width: 90%; max-height: 85vh; overflow-y: auto;" class="card shadow-sm">
        @csrf
        @method('PUT')

        <div class="card-header d-flex justify-content-between align-items-center py-2 px-3">
            <a href="{{ route('orders.index') }}" class="btn btn-success btn-sm">Show Orders List</a>
            <button type="submit" class="btn btn-sm btn-success">
                <i class="fas fa-save me-1"></i>Update Order
            </button>
        </div>

        <div class="card-body py-2 px-3">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="customer_name" class="form-label small">Customer Name</label>
                    <input type="text" class="form-control form-control-sm" id="customer_name" name="customer_name" value="{{ old('customer_name', $order->customer_name) }}" required>
                </div>
                <div class="col-md-6">
                    <label for="table_number" class="form-label small">Table Number</label>
                    <input type="text" class="form-control form-control-sm" id="table_number" name="table_number" value="{{ old('table_number', $order->table_number) }}">
                </div>
            </div>

            <div class="mb-3 border rounded p-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0 text-white">Order Items</h6>
                    <button type="button" id="add-item" class="btn btn-sm btn-success">
                        <i class="fas fa-plus"></i> Add Item
                    </button>
                </div>

                <hr>

                <div id="order-items-container">
                    @foreach($order->items as $index => $item)
                    <div class="order-item row g-2 align-items-center mb-2">
                        <div class="col-md-5">
                            <select class="form-select form-select-sm product-select" name="items[{{ $index }}][product_id]" required>
                                <option value="">Select Product</option>
                                @foreach($products as $product)
                                <option value="{{ $product->product_id }}" data-price="{{ $product->price }}"
                                    @if($item->product_id == $product->product_id) selected @endif>
                                    {{ $product->name }} - {{ number_format($product->price, 2) }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="number" class="form-control form-control-sm quantity" name="items[{{ $index }}][quantity]" min="1" value="{{ $item->quantity }}" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control form-control-sm subtotal" readonly value="{{ number_format($item->subtotal, 2) }}PKR">
                            <input type="hidden" class="hidden-subtotal" name="items[{{ $index }}][subtotal]" value="{{ $item->subtotal }}">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-sm btn-danger remove-item w-100 d-flex align-items-center justify-content-center" title="Remove Item" style="height: 31px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

             <div class="row justify-content-end mt-3">
                    <div class="col-md-4">
                        <div class="bg-total-container p-2 rounded">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Grand Total :</h6>
                                <span id="total-amount" class="fw-bold">RS = 0.00</span>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let itemIndex = {{ count($order->items) }};

        document.addEventListener('click', function (e) {
            if (e.target.id === 'add-item' || e.target.closest('#add-item')) {
                const container = document.getElementById('order-items-container');
                const newItem = document.querySelector('.order-item').cloneNode(true);

                // Update select field
                const productSelect = newItem.querySelector('.product-select');
                productSelect.name = `items[${itemIndex}][product_id]`;
                productSelect.selectedIndex = 0;

                // Update quantity
                const quantityInput = newItem.querySelector('.quantity');
                quantityInput.name = `items[${itemIndex}][quantity]`;
                quantityInput.value = 1;

                // Update subtotal display and hidden
                const subtotalField = newItem.querySelector('.subtotal');
                const hiddenSubtotal = newItem.querySelector('.hidden-subtotal');

                subtotalField.value = '0.00PKR';
                hiddenSubtotal.name = `items[${itemIndex}][subtotal]`;
                hiddenSubtotal.value = '0.00';

                itemIndex++;
                container.appendChild(newItem);
            }

            if (e.target.closest('.remove-item')) {
                if (document.querySelectorAll('.order-item').length > 1) {
                    e.target.closest('.order-item').remove();
                    calculateTotal();
                } else {
                    alert('At least one item is required.');
                }
            }
        });

        document.addEventListener('change', function (e) {
            if (e.target.classList.contains('product-select') || e.target.classList.contains('quantity')) {
                const item = e.target.closest('.order-item');
                const price = parseFloat(item.querySelector('.product-select').selectedOptions[0].dataset.price || 0);
                const qty = parseFloat(item.querySelector('.quantity').value || 0);
                const subtotal = price * qty;

                item.querySelector('.subtotal').value = subtotal.toFixed(2) + 'PKR';
                item.querySelector('.hidden-subtotal').value = subtotal.toFixed(2);
                calculateTotal();
            }
        });

        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('.hidden-subtotal').forEach(input => {
                total += parseFloat(input.value || 0);
            });
            document.getElementById('total-amount').textContent = total.toFixed(2) + 'PKR';
        }

        // Initial total calculation
        calculateTotal();
    });
</script>
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


.dark-theme .bg-total-container {
        background-color: rgb(124, 101, 27);
        border: 1px solid rgb(126, 156, 17) !important;
        box-shadow: 0 0 5px rgba(136, 167, 25, 0.5) !important;
    }

.dark-theme .bg-total-container {
        background-color: rgb(124, 101, 27);
        border: 1px solid rgb(126, 156, 17) !important;
        box-shadow: 0 0 5px rgba(136, 167, 25, 0.5) !important;
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
