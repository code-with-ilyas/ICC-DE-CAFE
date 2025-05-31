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
            <br>
            <h5 style="margin: 5px 0;">Kitchen Copy</h5>
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

            <div class="card" style="overflow-x: auto;">
                <table>
                    <thead style="background-color:rgb(230, 31, 31);">
                        <tr>
                            <th>S.No</th>
                            <th>Product</th>
                            <th style="text-align: center;">Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->product->name ?? 'Unknown Product' }}</td>
                            <td style="text-align: center;">{{ $item->quantity }}</td>
                        </tr>
                        @endforeach
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

    // Show current time
    updateCurrentTime();

    // Print & redirect
    window.onload = function () {
        updateCurrentTime();

        // Automatically open the print dialog
        window.print();

        // After print finishes, go back to index page
        window.onafterprint = function () {
            window.location.href = "{{ route('orders.index') }}";
        };

        // Fallback redirect if onafterprint doesn't fire (e.g., in some browsers)
        setTimeout(() => {
            window.location.href = "{{ route('orders.index') }}";
        }, 3000); // Redirect after 3 seconds just in case
    };
</script>

</body>

</html>
