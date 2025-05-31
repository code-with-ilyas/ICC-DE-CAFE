@extends('layouts.auth')

@section('content')
<div class="d-flex justify-content-center py-2">
    <form action="{{ route('purchase_stocks.store') }}" method="POST" style="width: 90%; max-height: 85vh; overflow-y: auto;" class="card shadow-sm dark-theme">
        @csrf

        <div class="card-header d-flex justify-content-between align-items-center py-2 px-3">
            <a href="{{ route('purchase_stocks.index') }}" class="btn btn-success text-white btn-sm">Show Purchases List</a>
            <button type="submit" class="btn btn-sm btn-success">
                <i class="fas fa-save me-1"></i> + ADD      
            </button>
        </div>

        <div class="card-body py-2 px-3">
            <!-- Supplier Info -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="supplier_name" class="form-label small">Supplier Name</label>
                    <input type="text" name="supplier_name" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-4">
                    <label for="supplier_number" class="form-label small">Supplier Number</label>
                    <input type="text" name="supplier_number" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-4">
                    <label for="date" class="form-label small">Date</label>
                    <input type="date" name="date" class="form-control form-control-sm" required>
                </div>
            </div>

            <hr>

            <!-- Product Section Header -->
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0 text-white">Products</h6>
                <button type="button" class="btn btn-sm btn-success" id="addProductRow">
                    <i class="fas fa-plus"></i> Add Product
                </button>
            </div>

            <!-- Product Rows -->
            <div id="productRows">
                <div class="row mb-2 product-row">
                    <div class="col-md-3">
                        <input type="text" name="product_name[]" class="form-control form-control-sm" placeholder="Product Name" required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="quantity[]" class="form-control form-control-sm quantity" placeholder="Qty" required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" step="0.01" name="unit_price[]" class="form-control form-control-sm unit_price" placeholder="Unit Price" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" step="0.01" name="total_price[]" class="form-control form-control-sm total_price" placeholder="Total" readonly>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm remove-row">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
            </div>

            <hr>
            <div class="d-flex justify-content-end mt-3">
                <div style="width: 200px;">
                    <label class="form-label small text-white">Grand Total</label>
                    <input type="text" class="form-control form-control-sm text-end text-white bg-" id="grandTotal" readonly>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- JS Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const productRowsContainer = document.getElementById('productRows');
    const addBtn = document.getElementById('addProductRow');
    const grandTotalEl = document.getElementById('grandTotal');

    function calculateTotal(row) {
        const qty = parseFloat(row.querySelector('.quantity').value) || 0;
        const price = parseFloat(row.querySelector('.unit_price').value) || 0;
        const total = (qty * price).toFixed(2);
        row.querySelector('.total_price').value = total;
        updateGrandTotal();
    }

    function updateGrandTotal() {
        let grandTotal = 0;
        document.querySelectorAll('.total_price').forEach(input => {
            grandTotal += parseFloat(input.value) || 0;
        });
        grandTotalEl.value = grandTotal.toFixed(2);
    }

    function bindEvents(row) {
        row.querySelector('.quantity').addEventListener('input', () => calculateTotal(row));
        row.querySelector('.unit_price').addEventListener('input', () => calculateTotal(row));
        row.querySelector('.remove-row').addEventListener('click', () => {
            if (document.querySelectorAll('.product-row').length > 1) {
                row.remove();
                updateGrandTotal();
            } else {
                alert("At least one product is required.");
            }
        });
    }

    addBtn.addEventListener('click', () => {
        const newRow = document.createElement('div');
        newRow.className = 'row mb-2 product-row';
        newRow.innerHTML = `
            <div class="col-md-3">
                <input type="text" name="product_name[]" class="form-control form-control-sm" placeholder="Product Name" required>
            </div>
            <div class="col-md-2">
                <input type="number" name="quantity[]" class="form-control form-control-sm quantity" placeholder="Qty" required>
            </div>
            <div class="col-md-2">
                <input type="number" step="0.01" name="unit_price[]" class="form-control form-control-sm unit_price" placeholder="Unit Price" required>
            </div>
            <div class="col-md-3">
                <input type="number" step="0.01" name="total_price[]" class="form-control form-control-sm total_price" placeholder="Total" readonly>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm remove-row">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </div>
        `;
        productRowsContainer.appendChild(newRow);
        bindEvents(newRow);
    });

    const firstRow = document.querySelector('.product-row');
    if (firstRow) bindEvents(firstRow);
});
</script>

<style>
.card-header {
    border-bottom: 2px solid #00bcd4 !important;
}
.dark-theme .card {
    background-color: #2a2a2a;
    color: #ffffff;
    border: 2px solid #00bcd4;
    box-shadow: 0 0 12px rgba(0, 188, 212, 0.5);
}
hr {
    border: none;
    height: 2px;
    background: linear-gradient(90deg, rgba(0,0,0,0) 0%, rgba(0, 188, 212, 0.8) 20%, #00bcd4 50%, rgba(0, 188, 212, 0.8) 80%, rgba(0,0,0,0) 100%);
    margin: 15px 0;
}
.dark-theme .form-control {
    background-color: #2a2a2a;
    color: #ffffff;
    border: 1px solid #00bcd4;
}
.dark-theme .form-control:focus {
    border-color: #00e5ff;
    box-shadow: 0 0 5px rgba(0, 229, 255, 0.6);
}
.dark-theme label {
    color: #ffffff;
}
.dark-theme input.form-control,
.dark-theme input::placeholder {
    color: #ffffff !important;
}

.dark-theme input::placeholder {
    opacity: 0.8;
}

</style>
@endsection
