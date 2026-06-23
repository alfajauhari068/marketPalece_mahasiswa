<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice - {{ $order->order_code }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
        }
        .container {
            width: 100%;
            max-width: 210mm;
            margin: 0 auto;
            padding: 20px;
            background: white;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #0d6efd;
        }
        .header-left h1 {
            font-size: 24px;
            color: #0d6efd;
            margin-bottom: 5px;
        }
        .header-left p {
            font-size: 12px;
            color: #666;
        }
        .header-right {
            text-align: right;
        }
        .header-right p {
            font-size: 12px;
            margin-bottom: 5px;
        }
        .header-right .invoice-no {
            font-size: 14px;
            font-weight: bold;
            color: #0d6efd;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .info-section {
            width: 48%;
        }
        .info-section h3 {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 8px;
            text-transform: uppercase;
            color: #0d6efd;
        }
        .info-section p {
            font-size: 11px;
            margin-bottom: 3px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
        }
        .table thead {
            background-color: #f8f9fa;
        }
        .table th {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            font-size: 11px;
            font-weight: bold;
            color: #0d6efd;
        }
        .table td {
            border: 1px solid #ddd;
            padding: 12px;
            font-size: 11px;
        }
        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .service-name {
            font-weight: bold;
            margin-bottom: 3px;
        }
        .service-category {
            font-size: 10px;
            color: #666;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .summary {
            width: 50%;
            margin-left: auto;
            margin-top: 20px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 11px;
            border-bottom: 1px solid #eee;
        }
        .summary-row.total {
            font-weight: bold;
            font-size: 13px;
            color: #0d6efd;
            border-bottom: 2px solid #0d6efd;
            border-top: 2px solid #0d6efd;
            padding: 10px 0;
        }
        .notes {
            margin-top: 20px;
            padding: 12px;
            background-color: #f8f9fa;
            border-left: 4px solid #0d6efd;
            font-size: 10px;
        }
        .payment-info {
            margin-top: 20px;
            padding: 12px;
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 4px;
            font-size: 10px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #ddd;
            font-size: 10px;
            text-align: center;
            color: #666;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-success {
            background-color: #d4edda;
            color: #155724;
        }
        .badge-warning {
            background-color: #fff3cd;
            color: #856404;
        }
        .badge-info {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        .badge-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <h1>INVOICE</h1>
                <p>{{ config('app.name', 'Marketplace Mahasiswa') }}</p>
            </div>
            <div class="header-right">
                <div class="invoice-no">{{ $order->order_code }}</div>
                <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y') }}</p>
                <p><strong>Status:</strong> <span class="badge badge-{{ $order->status === 'pending' ? 'warning' : ($order->status === 'diproses' ? 'info' : ($order->status === 'selesai' ? 'success' : 'danger')) }}">{{ ucfirst($order->status) }}</span></p>
            </div>
        </div>

        <!-- Seller & Buyer Info -->
        <div class="info-row">
            <div class="info-section">
                <h3>Dari (Penjual)</h3>
                <p><strong>{{ $order->seller->name }}</strong></p>
                <p>{{ $order->seller->email }}</p>
                @if($order->seller->profile)
                    <p>Rating: {{ $order->seller->profile->rating_avg ?? 'N/A' }}/5</p>
                @endif
            </div>
            <div class="info-section">
                <h3>Kepada (Pembeli)</h3>
                <p><strong>{{ $order->buyer->name }}</strong></p>
                <p>{{ $order->buyer->email }}</p>
            </div>
        </div>

        <!-- Order Details -->
        <div class="info-row">
            <div class="info-section">
                <h3>Detail Pesanan</h3>
                <p><strong>ID Pesanan:</strong> {{ $order->id }}</p>
                <p><strong>Nomor Invoice:</strong> {{ $order->order_code }}</p>
                <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
            </div>
            <div class="info-section">
                <h3>Status Pembayaran</h3>
                @if($order->payment)
                    <p><strong>Metode:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment->method)) }}</p>
                    <p><strong>Status:</strong> <span class="badge badge-{{ $order->payment->status === 'paid' ? 'success' : ($order->payment->status === 'pending' ? 'warning' : 'danger') }}">{{ ucfirst($order->payment->status) }}</span></p>
                    <p><strong>Nomor Transaksi:</strong> {{ $order->payment->transaction_id }}</p>
                @else
                    <p>Belum ada pembayaran</p>
                @endif
            </div>
        </div>

        <!-- Services Table -->
        <table class="table">
            <thead>
                <tr>
                    <th>Layanan</th>
                    <th class="text-center">Jumlah</th>
                    <th class="text-right">Harga Satuan</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="service-name">{{ $order->service->title }}</div>
                        <div class="service-category">{{ $order->service->category->name ?? 'Kategori' }}</div>
                    </td>
                    <td class="text-center">{{ $order->quantity }}</td>
                    <td class="text-right">Rp {{ number_format($order->service->price, 0, ',', '.') }}</td>
                    <td class="text-right"><strong>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>

        <!-- Summary -->
        <div class="summary">
            <div class="summary-row">
                <span>Subtotal:</span>
                <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span>Biaya Layanan:</span>
                <span>Rp 0</span>
            </div>
            <div class="summary-row total">
                <span>TOTAL:</span>
                <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Notes if any -->
        @if($order->orderDetail && $order->orderDetail->note)
            <div class="notes">
                <strong>Catatan Pesanan:</strong><br>
                {{ $order->orderDetail->note }}
            </div>
        @endif

        <!-- Payment Info -->
        @if($order->payment)
            <div class="payment-info">
                <strong>Informasi Pembayaran:</strong><br>
                Metode: {{ ucfirst(str_replace('_', ' ', $order->payment->method)) }}<br>
                Status: {{ ucfirst($order->payment->status) }}<br>
                @if($order->payment->paid_at)
                    Tanggal Pembayaran: {{ $order->payment->paid_at->format('d M Y H:i') }}<br>
                @endif
                Nomor Transaksi: {{ $order->payment->transaction_id }}
            </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>Invoice ini adalah bukti transaksi resmi dari {{ config('app.name', 'Marketplace Mahasiswa') }}.</p>
            <p>Terima kasih telah menggunakan layanan kami!</p>
            <p>Dihasilkan pada: {{ now()->format('d M Y H:i') }}</p>
        </div>
    </div>
</body>
</html>
