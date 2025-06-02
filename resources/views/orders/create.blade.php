@extends('layouts.auth')

@section('content')
<div class="d-flex justify-content-center py-2">
    <form action="{{ route('orders.store') }}" method="POST" style="width: 90%; max-height: 85vh; overflow-y: auto;" class="card shadow-sm">
        @csrf

        <div class="card-header d-flex justify-content-between align-items-center py-2 px-3" style="border-bottom: 2px solid #00bcd4;">
            <a href="{{ route('orders.index') }}" class="btn btn-success text-white btn-sm">Show Orders</a>
            <button type="submit" class="btn btn-sm btn-success">
                <i class="fas fa-save me-1"></i>Create Order
            </button>
        </div>

        <div class="card-body py-2 px-3">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="customer_name" class="form-label small">Customer Name</label>
                    <input type="text" class="form-control form-control-sm" id="customer_name" name="customer_name" required>
                </div>
                <div class="col-md-6">
                    <label for="table_number" class="form-label small">Table Number</label>
                    <input type="text" class="form-control form-control-sm" id="table_number" name="table_number">
                </div>
            </div>

            <div class="mb-3 border rounded p-3" style="border: 1px solid #00bcd4 !important;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0 text-white">Order Items</h6>
                    <button type="button" id="add-item" class="btn btn-sm btn-success">
                        <i class="fas fa-plus"></i> Add Item
                    </button>
                </div>

                <hr>

                <div id="order-items-container">
                    <div class="order-item row g-2 align-items-center mb-2">
                        <div class="col-md-5 position-relative">
                            <input type="text" class="form-control form-control-sm product-search" placeholder="Search products..." autocomplete="off">
                            <select class="form-select form-select-sm product-select d-none" name="items[0][product_id]" required>
                                <option value="">Select Product</option>
                                @foreach($products as $product)
                                <option value="{{ $product->product_id }}" data-price="{{ $product->price }}">
                                    {{ $product->name }} - Rs{{ number_format($product->price, 2) }}
                                </option>
                                @endforeach
                            </select>
                            <div class="product-search-results position-absolute w-100 bg-white shadow-sm rounded mt-1" style="z-index: 1000; display: none; max-height: 200px; overflow-y: auto;"></div>
                            <input type="hidden" name="items[0][product_name]" class="product-name">
                            <input type="hidden" name="items[0][price]" class="product-price">
                        </div>

                        <div class="col-md-2">
                            <input type="number" class="form-control form-control-sm quantity" name="items[0][quantity]" min="1" value="1" required>
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control form-control-sm price" readonly>
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control form-control-sm subtotal" name="items[0][subtotal]" readonly value="0.00">
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
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let itemIndex = 1;

        // Add new item
        document.getElementById('add-item').addEventListener('click', function() {
            const container = document.getElementById('order-items-container');
            const newItem = document.querySelector('.order-item').cloneNode(true);

            // Update names with new index
            newItem.querySelector('.product-select').name = `items[${itemIndex}][product_id]`;
            newItem.querySelector('.quantity').name = `items[${itemIndex}][quantity]`;
            newItem.querySelector('.product-name').name = `items[${itemIndex}][product_name]`;
            newItem.querySelector('.product-price').name = `items[${itemIndex}][price]`;
            newItem.querySelector('.subtotal').name = `items[${itemIndex}][subtotal]`;

            // Reset values
            newItem.querySelector('.quantity').value = 1;
            newItem.querySelector('.price').value = '';
            newItem.querySelector('.subtotal').value = '0.00';
            newItem.querySelector('.product-select').selectedIndex = 0;
            newItem.querySelector('.product-search').value = '';
            newItem.querySelector('.product-name').value = '';
            newItem.querySelector('.product-price').value = '';

            itemIndex++;
            container.appendChild(newItem);
        });

        // Remove item
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-item')) {
                if (document.querySelectorAll('.order-item').length > 1) {
                    e.target.closest('.order-item').remove();
                    calculateTotal();
                } else {
                    alert('At least one item is required.');
                }
            }
        });

        // Product search functionality
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('product-search')) {
                const input = e.target;
                const container = input.closest('.order-item');
                const searchTerm = input.value.toLowerCase();
                const selectElement = container.querySelector('.product-select');
                const resultsContainer = container.querySelector('.product-search-results');

                if (searchTerm.length === 0) {
                    resultsContainer.style.display = 'none';
                    return;
                }

                // Filter options
                const filteredOptions = Array.from(selectElement.options).filter(option => {
                    return option.textContent.toLowerCase().includes(searchTerm) && option.value !== '';
                });

                // Display results
                resultsContainer.innerHTML = '';
                if (filteredOptions.length > 0) {
                    filteredOptions.forEach(option => {
                        const div = document.createElement('div');
                        div.className = 'search-result-item p-2 border-bottom';
                        div.textContent = option.textContent;
                        div.style.cursor = 'pointer';
                        div.addEventListener('click', function() {
                            selectElement.value = option.value;
                            selectElement.dispatchEvent(new Event('change'));
                            input.value = option.textContent.split(' - ')[0]; // Show just the name
                            resultsContainer.style.display = 'none';

                            // Set the price and calculate subtotal
                            const price = option.getAttribute('data-price');
                            container.querySelector('.price').value = 'Rs = ' + parseFloat(price).toFixed(2);
                            container.querySelector('.product-price').value = price;
                            container.querySelector('.product-name').value = option.textContent.split(' - ')[0];

                            const quantity = container.querySelector('.quantity').value;
                            const subtotal = price * quantity;
                            container.querySelector('.subtotal').value = subtotal.toFixed(2);

                            calculateTotal();
                        });
                        resultsContainer.appendChild(div);
                    });
                    resultsContainer.style.display = 'block';
                } else {
                    resultsContainer.innerHTML = '<div class="p-2 text-muted">No products found</div>';
                    resultsContainer.style.display = 'block';
                }
            }
        });

        // Quantity change
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('quantity')) {
                const container = e.target.closest('.order-item');
                const price = container.querySelector('.product-price').value;
                const quantity = e.target.value;

                if (price && quantity) {
                    const subtotal = parseFloat(price) * parseInt(quantity);
                    container.querySelector('.subtotal').value = subtotal.toFixed(2);
                    calculateTotal();
                }
            }
        });

        // Close search results when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.classList.contains('product-search') &&
                !e.target.classList.contains('search-result-item')) {
                document.querySelectorAll('.product-search-results').forEach(el => {
                    el.style.display = 'none';
                });
            }
        });

        // Calculate total amount
        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('.subtotal').forEach(subtotal => {
                total += parseFloat(subtotal.value) || 0;
            });
            document.getElementById('total-amount').textContent = 'RS = ' + total.toFixed(2);
        }
    });
</script>

<style>
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
        background: linear-gradient(90deg,
                rgba(0, 0, 0, 0) 0%,
                rgba(0, 188, 212, 0.8) 20%,
                #00bcd4 50%,
                rgba(0, 188, 212, 0.8) 80%,
                rgba(0, 0, 0, 0) 100%);
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
        background-color: rgb(124, 101, 27);
        border: 1px solid rgb(126, 156, 17) !important;
        box-shadow: 0 0 5px rgba(136, 167, 25, 0.5) !important;
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

    .search-result-item:hover {
        background-color: #f0f0f0;
    }

    .dark-theme .search-result-item:hover {
        background-color: #333;
    }

    .order-item {
        position: relative;
    }

    .product-search-results {
        border: 1px solid rgb(34, 35, 36);
    }

    .dark-theme .product-search-results {
        background-color: #2a2a2a;
        border-color: #00bcd4;
        color: rgb(27, 26, 26);
    }
</style>
@endsection