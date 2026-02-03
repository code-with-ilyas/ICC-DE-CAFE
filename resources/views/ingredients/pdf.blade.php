<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ingredients Report - {{ $year }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        th, td {
            border: 1px solid #444;
            padding: 5px;
            text-align: center;
        }

        th {
            background-color: #6a11cb;
            color: white;
        }

        .card-header {
            background-color: #1e3c72;
            color: white;
            padding: 6px 10px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 10px;
            background-color: #fd7e14;
            color: #212529;
            min-width: 40px;
        }

        /* Size/type indicators */
        .small { background-color: #28a745; color: white; }
        .medium { background-color: #ffc107; color: black; }
        .large { background-color: #17a2b8; color: white; }
        .plate { background-color: #6c757d; color: white; }
        .with_burger { background-color: #343a40; color: white; }

        /* ===== MONTHLY TABLE COMPACT MODE ===== */
        .monthly-table th,
        .monthly-table td {
            font-size: 9px;
            padding: 3px;
        }

        .monthly-table .badge {
            font-size: 9px;
            padding: 2px 6px;
            min-width: 28px;
        }
    </style>
</head>

<body>

<h2 style="text-align:center; margin-bottom:20px;">
    Ingredients Calculation Report - {{ $year }}
</h2>

@php
    $icons = [
        'cheese' => '',
        'fries' => '',
        'chicken' => ''
    ];

    $displayNames = [
        'cheese' => 'Cheese Used In Each Pizza (Grams)',
        'fries' => 'French Fries Used In Orders (Grams)',
        'chicken' => 'Chicken Used In Pizzas (Grams)'
    ];

    $cheeseHeaderSequence = ['small','medium','large'];
    $monthNames = [
        1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'May',6=>'Jun',
        7=>'Jul',8=>'Aug',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dec'
    ];
@endphp

{{-- ================= INGREDIENT TOTAL TABLES ================= --}}
@foreach($ingredients as $ingredient => $data)
    <div class="card">
        <div class="card-header">
            {{ $icons[$ingredient] ?? '' }}
            {{ $displayNames[$ingredient] ?? ucfirst($ingredient) }} - {{ $year }}
        </div>

        <table>
            <thead>
                <tr>
                    @php
                        $subKeys = $ingredient === 'cheese'
                            ? $cheeseHeaderSequence
                            : array_filter(array_keys($data), fn($k) => $k !== 'total');
                    @endphp

                    @foreach($subKeys as $key)
                        <th>{{ ucfirst(str_replace('_',' ',$key)) }}</th>
                    @endforeach
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    @foreach($subKeys as $key)
                        <td>
                            <span class="badge {{ $key }}">
                                {{ $data[$key] ?? 0 }}
                            </span>
                        </td>
                    @endforeach
                    <td>
                        <span class="badge">
                            {{ $data['total'] ?? 0 }}
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endforeach

{{-- ================= MONTHLY SUMMARY TABLES ================= --}}
@foreach(['cheese','fries','chicken'] as $ingredient)
@if(isset($monthlySummary[1][$ingredient]))
    <div class="card">
        <div class="card-header">
            {{ $icons[$ingredient] }}
            Monthly {{ ucfirst($ingredient) }} Usage (Grams) - {{ $year }}
        </div>

        <table class="monthly-table">
            <thead>
                <tr>
                    @foreach($monthNames as $m)
                        <th>{{ $m }}</th>
                    @endforeach
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    @php $total = 0; @endphp
                    @foreach(range(1,12) as $m)
                        @php
                            $val = $monthlySummary[$m][$ingredient]['total'] ?? 0;
                            $total += $val;
                        @endphp
                        <td>
                            <span class="badge">{{ $val }}</span>
                        </td>
                    @endforeach
                    <td>
                        <span class="badge">{{ $total }}</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endif
@endforeach

</body>
</html>
