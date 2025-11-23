<!DOCTYPE html>
<html>
<head>
    <title>Invoice #{{ $sale->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .company-info {
            margin-bottom: 20px;
        }
        .invoice-info {
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
        .totals {
            float: right;
            width: 300px;
        }
        .totals table {
            width: 100%;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            border-top: 2px solid #333;
            padding-top: 20px;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        @if($settings['invoice_header'])
            <div style="white-space: pre-line;">{{ $settings['invoice_header'] }}</div>
        @else
            <h1>{{ $settings['company_name'] }}</h1>
        @endif

        <div class="company-info">
            @if($settings['company_address'])
                <p>{{ $settings['company_address'] }}</p>
            @endif
            @if($settings['company_phone'])
                <p>Phone: {{ $settings['company_phone'] }}</p>
            @endif
            @if($settings['company_email'])
                <p>Email: {{ $settings['company_email'] }}</p>
            @endif
        </div>
    </div>

    <div class="invoice-info">
        <table style="border: none;">
            <tr>
                <td style="border: none;"><strong>Invoice Number:</strong> {{ $sale->invoice_number }}</td>
                <td style="border: none;"><strong>Date:</strong> {{ $sale->created_at->format('Y-m-d H:i:s') }}</td>
            </tr>
            <tr>
                <td style="border: none;"><strong>Cashier:</strong> {{ $sale->user->name }}</td>
                <td style="border: none;"><strong>Payment Method:</strong> {{ ucfirst($sale->payment_method) }}</td>
            </tr>
        </table>
    </div>

    <h3>Items</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->saleItems as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <table>
            <tr>
                <td><strong>Subtotal:</strong></td>
                <td style="text-align: right;">${{ number_format($sale->subtotal, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Tax:</strong></td>
                <td style="text-align: right;">${{ number_format($sale->tax, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Discount:</strong></td>
                <td style="text-align: right;">-${{ number_format($sale->discount, 2) }}</td>
            </tr>
            <tr style="font-size: 1.2em;">
                <td><strong>Total:</strong></td>
                <td style="text-align: right;"><strong>${{ number_format($sale->total, 2) }}</strong></td>
            </tr>
        </table>
    </div>

    <div style="clear: both;"></div>

    @if($sale->notes)
        <div style="margin-top: 20px;">
            <strong>Notes:</strong>
            <p>{{ $sale->notes }}</p>
        </div>
    @endif

    <div class="footer">
        {{ $settings['invoice_footer'] }}
    </div>

    <div class="no-print" style="margin-top: 30px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;">
            Print Invoice
        </button>
        <button onclick="window.close()" style="padding: 10px 20px; background-color: #f44336; color: white; border: none; border-radius: 5px; cursor: pointer; margin-left: 10px;">
            Close
        </button>
    </div>
</body>
</html>
