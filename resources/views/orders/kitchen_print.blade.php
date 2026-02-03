<!DOCTYPE html>
<html>

<head>
    <title>ICC DE CAFE - Kitchen Print</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: rgb(86, 90, 95);
            color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 12px;
        }

        th,
        td {
            padding: 5px;
            text-align: left;
            border: 1px solid #000;
        }

        .card {
            border: 1px solid #000;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            background-color: #ffffff;
            color: black;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }

        @media print {
            body {
                margin: 0;
                padding: 10px;
                font-size: 12px;
                background-color: white;
                color: black;
            }

            .container,
            .card {
                width: 100%;
                border: none;
                padding: 0;
                box-shadow: none;
                margin-bottom: 5px;
            }

            table {
                font-size: 11px;
            }

            /* Hide radio inputs in print */
            .order-option-input {
                display: none;
            }

            /* Show selected value in print */
            .order-option-label::after {
                content: attr(data-selected);
                font-weight: bold;
                display: block;
                margin-top: 5px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card" style="text-align: center; padding: 5px;">
            <img class="rounded-circle" src="{{ asset('admin_assets/img/GreenBurger.png') }}" alt="Logo"
                style="width: 100px; height: 100px; margin-bottom: 4px;">

            <h4 style="margin: 0;">ICC 2 Filling Station Basnak Drosh Chitral</h4>
            <br>
            <h4 style="margin: 0;">MOBILE NUMBER: 03250206666</h4>
            <br>
            <h5 style="margin: 5px 0;">Kitchen Copy</h5>
            <br>

            <div style="display: flex; justify-content: center; gap: 20px; margin-top: 10px;">
                <label class="order-option-label" data-selected="" style="display: flex; align-items: center; gap: 5px;">
                    <input class="order-option-input" type="radio" name="order_option" value="Servis"
                        onchange="updateOrderType(this)"> SERVIS
                </label>
                <br>
                <label class="order-option-label" data-selected="" style="display: flex; align-items: center; gap: 5px;">
                    <input class="order-option-input" type="radio" name="order_option" value="Take A Way"
                        onchange="updateOrderType(this)"> TAKE A WAY
                </label>
            </div>

            <br>
            <div class="card">
                <div style="display: flex; justify-content: space-between;">
                    <p><strong>Date:</strong> {{ $order->created_at->format('d-m-Y') }}</p>
                    <p><strong>Time:</strong> <span id="currentTime"></span></p>
                </div>
            </div>

            <div class="card">
                <p><strong>Customer Name:</strong> {{ $order->customer_name }}</p>
                <p><strong>Table Number:</strong> {{ $order->table_number }}</p>
                <p><strong>Order ID:</strong> {{ $order->id }}</p>

                <div class="card" style="overflow-x: auto;">
                    <table>
                        <thead style="background-color:rgb(230, 31, 31);">
                            <tr>
                                <th>S.No</th>
                                <th>Product</th>
                                <th style="text-align: center;">Qty</th>
                                <th style="text-align: right;">Price</th>
                                <th style="text-align: right;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach($order->orderItems as $item)
                            @php
                                $price = $item->product->price ?? 0;
                                $subtotal = $price * $item->quantity;
                                $total += $subtotal;
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->product->name ?? 'Unknown Product' }}</td>
                                <td style="text-align: center;">{{ $item->quantity }}</td>
                                <td style="text-align: right;">{{ number_format($price, 2) }}</td>
                                <td style="text-align: right;">{{ number_format($subtotal, 2) }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="4" style="text-align: right; font-weight:bold;">Total</td>
                                <td style="text-align: right; font-weight:bold;">{{ number_format($total, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script>
            function updateCurrentTime() {
                const now = new Date();
                const timeString = now.toLocaleTimeString('en-US', {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: true
                });
                const currentTimeEl = document.getElementById('currentTime');
                if (currentTimeEl) {
                    currentTimeEl.textContent = timeString;
                }
            }

            function updateOrderType(input) {
                const labels = document.querySelectorAll('.order-option-label');
                labels.forEach(label => {
                    label.setAttribute('data-selected', '');
                });

                if (input.checked) {
                    input.parentElement.setAttribute('data-selected', input.value);
                }
            }

            // Show current time
            updateCurrentTime();

            // On window load
            window.onload = function() {
                updateCurrentTime();

                const selectedInput = document.querySelector('input[name="order_option"]:checked');
                if (selectedInput) {
                    updateOrderType(selectedInput);
                }

                // Auto print
                window.print();

                // Redirect after print
                window.onafterprint = function() {
                    window.location.href = "{{ route('orders.index') }}";
                };

                setTimeout(() => {
                    window.location.href = "{{ route('orders.index') }}";
                }, 3000);
            };
        </script>
</body>
<<<<<<< Updated upstream
</html>
=======
</html>
>>>>>>> Stashed changes
