<!DOCTYPE html>
<html>
<head>
    <title>Invoice #{{ $sale->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 900px;
            margin: 0 auto;
            padding: 30px;
            font-size: 18px;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 4px solid #333;
            padding-bottom: 30px;
        }
        .header h1 {
            font-size: 42px;
            margin-bottom: 15px;
            font-weight: bold;
        }
        .company-info {
            margin-bottom: 25px;
            font-size: 20px;
        }
        .company-info p {
            margin: 10px 0;
            font-size: 20px;
        }
        .invoice-info {
            margin-bottom: 35px;
            font-size: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            font-size: 20px;
        }
        th, td {
            padding: 15px 12px;
            text-align: left;
            border-bottom: 2px solid #ddd;
        }
        th {
            background-color: #e8e8e8;
            font-weight: bold;
            font-size: 22px;
        }
        .totals {
            float: right;
            width: 400px;
        }
        .totals table {
            width: 100%;
            font-size: 22px;
        }
        .totals td {
            padding: 12px;
        }
        .totals .total-row {
            font-weight: bold;
            font-size: 26px;
            background-color: #f0f0f0;
        }
        .footer {
            margin-top: 60px;
            text-align: center;
            border-top: 4px solid #333;
            padding-top: 30px;
            font-size: 20px;
        }
        strong {
            font-weight: bold;
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

    @if($sale->customer)
        <div style="margin-bottom: 30px; background-color: #f5f5f5; padding: 25px; border-radius: 8px; border: 2px solid #ddd;">
            <h3 style="margin-top: 0; font-size: 26px; font-weight: bold; margin-bottom: 15px;">Customer Information</h3>
            <p style="margin: 10px 0; font-size: 20px;"><strong>Name:</strong> {{ $sale->customer->name }}</p>
            <p style="margin: 10px 0; font-size: 20px;"><strong>Code:</strong> {{ $sale->customer->customer_code }}</p>
            @if($sale->customer->phone)
                <p style="margin: 10px 0; font-size: 20px;"><strong>Phone:</strong> {{ $sale->customer->phone }}</p>
            @endif
            @if($sale->customer->email)
                <p style="margin: 10px 0; font-size: 20px;"><strong>Email:</strong> {{ $sale->customer->email }}</p>
            @endif
        </div>
    @endif

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

    <h3 style="font-size: 28px; margin-bottom: 20px; font-weight: bold;">Items Purchased</h3>
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
            <tr class="total-row">
                <td><strong>TOTAL:</strong></td>
                <td style="text-align: right;"><strong>${{ number_format($sale->total, 2) }}</strong></td>
            </tr>
        </table>
    </div>

    <div style="clear: both;"></div>

    @if($sale->notes)
        <div style="margin-top: 30px; background-color: #fffbf0; padding: 20px; border-radius: 8px; border: 2px solid #f0e68c;">
            <strong style="font-size: 22px;">Notes:</strong>
            <p style="font-size: 20px; margin-top: 10px;">{{ $sale->notes }}</p>
        </div>
    @endif

    <div class="footer">
        {{ $settings['invoice_footer'] }}
    </div>

    <div class="no-print" style="margin-top: 40px; text-align: center;">
        <button onclick="window.print()" style="padding: 18px 40px; font-size: 20px; font-weight: bold; background-color: #4CAF50; color: white; border: none; border-radius: 10px; cursor: pointer; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            🖨️ Print Invoice
        </button>
        <button onclick="window.close()" style="padding: 18px 40px; font-size: 20px; font-weight: bold; background-color: #f44336; color: white; border: none; border-radius: 10px; cursor: pointer; margin-left: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            ✕ Close
        </button>
    </div>
</body>
</html>
