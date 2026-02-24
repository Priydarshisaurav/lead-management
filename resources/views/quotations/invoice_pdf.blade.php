<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 120px;
            margin-bottom: 10px;
        }

        .company-details {
            text-align: center;
            font-size: 11px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
        }

        .right {
            text-align: right;
        }

        .total-row td {
            font-weight: bold;
            background: #f9f9f9;
        }

        .footer {
            margin-top: 30px;
            font-size: 10px;
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">

        <img src="{{ public_path('images/NA_logo.png') }}" class="logo">


        <h2>QUOTATION</h2>
    </div>

    <!-- Company Details -->
    <div class="company-details">
        <strong>Northern Atlantic Private Limited</strong><br>
        Gandhinagar<br>
        GST No: 22AAAAA0000A1Z5<br>
        Phone: +91-1234567890<br>
    </div>

    <hr>

    <!-- Lead Details -->
    <h4>Lead Details</h4>
    <p>
        <strong>Name:</strong> {{ $quotation->lead->name }} <br>
        <strong>Company:</strong> {{ $quotation->lead->company_name }} <br>
        <strong>Email:</strong> {{ $quotation->lead->email }} <br>
        <strong>Date:</strong> {{ date('d-m-Y') }}
    </p>

    <!-- Product Details -->
    <h4>Product Details</h4>

    <table>
        <tr>
            <th>Product</th>
            <th>Qty</th>
            <th>Rate (₹)</th>
            <th>Subtotal (₹)</th>
        </tr>
        <tr>
            <td>{{ $quotation->product_name }}</td>
            <td>{{ $quotation->quantity }}</td>
            <td class="right">{{ number_format($quotation->rate,2) }}</td>
            <td class="right">{{ number_format($quotation->subtotal,2) }}</td>
        </tr>
    </table>

    <!-- GST Breakdown -->
    <h4>GST Breakdown</h4>

    <table>
        <tr>
            <td>GST ({{ $quotation->gst_percentage }}%)</td>
            <td class="right">₹ {{ number_format($quotation->gst_amount,2) }}</td>
        </tr>
        <tr class="total-row">
            <td>Grand Total</td>
            <td class="right">₹ {{ number_format($quotation->total_amount,2) }}</td>
        </tr>
    </table>

    <!-- Validity -->
    <p>
        <strong>Valid Till:</strong>
        {{ \Carbon\Carbon::parse($quotation->valid_till)->format('d-m-Y') }}
    </p>

    <!-- Footer -->
    <div class="footer">
        This is a system generated quotation. <br>
        Thank you for your business!
    </div>

</body>

</html>