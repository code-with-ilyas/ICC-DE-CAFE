<!DOCTYPE html>
<html>

<head>
    <title>ICC DE CAFE</title>
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

        .no-print {
            margin-top: 20px;
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

        .discount-input {
            margin: 10px 0;
            padding: 5px;
            width: 100px;
        }

        .apply-discount-btn {
            padding: 5px 10px;
           
            color: black;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

        @media print {

            .no-print,
            .discount-controls {
                display: none;
            }

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
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card" style="text-align: center; padding: 5px;">
            <img class="rounded-circle" src="{{ asset('admin_assets/img/GreenBurger.png') }}" alt="Logo" style="width: 100px; height: 100px; margin-bottom: 4px;">
            <h4 style="margin: 0;">ICC 2 Filling Station Basnak Drosh Chitral</h4>
            <br>
            <h4 style="margin: 0;">MOBILE NUMBER: 03250206666</h4>
            <h5 style="margin: 5px 0;">Customer Copy</h5>
        </div>

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

            {{-- Discount Form --}}
            <form method="POST" action="{{ route('orders.applyDiscount', $order->id) }}" class="discount-controls no-print" style="margin-bottom: 10px;">
                @csrf
                <label for="discountAmount" style="font-weight: bold;">Discount:</label>
                <input type="number" id="discountAmount" name="discount" class="discount-input" placeholder="Amount" min="0" step="0.01">
                <button type="submit" class="apply-discount-btn">Apply</button>
            </form>

            @if(session('success'))
            <p style="color: green; font-weight: bold;">{{ session('success') }}</p>
            @endif

            @if(session('error'))
            <p style="color: red; font-weight: bold;">{{ session('error') }}</p>
            @endif




            @php
            $subtotal_sum = $order->orderItems->sum(fn($item) => $item->price * $item->quantity);
            $discount = $order->discount ?? 0;
            $grand_total = $subtotal_sum - $discount;
            @endphp

            <div class="card" style="overflow-x: auto;">
                <table>
                    <thead style="background-color:rgb(230, 31, 31);">
                        <tr>
                            <th>S.No</th>
                            <th>Product</th>
                            <th style="text-align: center;">Qty</th>
                            <th style="text-align: center;">U Price</th>
                            <th style="text-align: center;">Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                        @php $subtotal = $item->price * $item->quantity; @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->product->name ?? 'Unknown Product' }}</td>
                            <td style="text-align: center;">{{ $item->quantity }}</td>
                            <td style="text-align: center;">{{ number_format($item->price, 2) }}</td>
                            <td style="text-align: center;">{{ number_format($subtotal, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>

                        @if($discount > 0)
                        <tr>
                            <td colspan="4" style="text-align: left; font-weight: bold;">Special Discount:</td>
                            <td style="text-align: center; color: red;">-{{ number_format($discount, 2) }}</td>
                        </tr>
                        @endif

                        <tr>
                            <td colspan="4" style="text-align: left; font-weight: bold;">Total Amount:</td>
                            <td style="font-weight: bold; text-align: center;">{{ number_format($grand_total, 2) }}</td>
                        </tr>
                    </tfoot>

                </table>
            </div>

            <div class="no-print" style="text-align: center; margin-top: 20px;">
                <button onclick="printAndRedirect()" style="padding: 10px 370px; background-color: rgb(241, 16, 16); color: black; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">Print</button>
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
                document.getElementById('currentTime').textContent = timeString;
            }

            updateCurrentTime();
            setInterval(updateCurrentTime, 60000);

            function printAndRedirect() {
                updateCurrentTime();
                window.print();
                setTimeout(() => window.location.href = '/orders', 500);
                window.onafterprint = () => window.location.href = '/orders';
            }
        </script>
</body>

</html>