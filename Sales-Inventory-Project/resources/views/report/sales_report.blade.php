<html>

<head>
    <style>
        .customers tr:hover {
            background-color: #ddd;
        }

        .customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            padding-left: 6px;
            text-align: left;
            background-color: #27ae60;
            color: white;
            font-weight: bold;
        }

        .customers td {
            padding: 8px 6px;
        }

        .customers {
            width: 100%;
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <h3>Summary</h3>
    <table class="customers">
        <thead>
            <tr>
                <th>Report</th>
                <th>Date</th>
                <th>Total</th>
                <th>Discount</th>
                <th>Vat</th>
                <th>Payable</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Sales Report</td>
                <td>{{ $from_date }} to {{ $to_date }}</td>
                <td>{{ $total }}</td>
                <td>{{ $discount }}</td>
                <td>{{ $vat }}</td>
                <td>{{ $payable }}</td>
            </tr>
        </tbody>
    </table>

    <h3>Details</h3>
    <table class="customers">
        <thead>
            <tr>
                <th>Customer</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Total</th>
                <th>Discount</th>
                <th>Vat</th>
                <th>Payable</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @if ($is_empty)
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px;">No invoices found for the selected date
                        range.</td>
                </tr>
            @else
                @foreach ($list as $item)
                    <tr>
                        <td>{{ $item->customer->name ?? 'N/A' }}</td>
                        <td>{{ $item->customer->mobile ?? 'N/A' }}</td>
                        <td>{{ $item->customer->email ?? 'N/A' }}</td>
                        <td>{{ $item->total }}</td>
                        <td>{{ $item->discount }}</td>
                        <td>{{ $item->vat }}</td>
                        <td>{{ $item->payable }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</body>

</html>
