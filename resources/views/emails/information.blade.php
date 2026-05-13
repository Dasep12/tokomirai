<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status Update</title>

    <style>
        /* =========================
           RESET
        ========================== */
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f6fb;
            font-family: Arial, Helvetica, sans-serif;
            color: #111827;
        }

        table {
            border-spacing: 0;
            border-collapse: collapse;
        }

        img {
            border: 0;
            display: block;
        }

        a {
            text-decoration: none;
        }

        /* =========================
           LAYOUT
        ========================== */
        .wrapper {
            width: 100%;
            background: #f4f6fb;
            padding: 40px 15px;
        }

        .container {
            width: 100%;
            max-width: 620px;
            background: #ffffff;
            margin: auto;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.06);
        }

        .content {
            padding: 40px;
        }

        /* =========================
           HEADER
        ========================== */
        .header {
            background: linear-gradient(135deg, #206bc4, #3b82f6);
            padding: 40px 30px;
            text-align: center;
            color: #ffffff;
        }

        .header-title {
            margin: 0;
            font-size: 30px;
            font-weight: 700;
        }

        .header-subtitle {
            margin-top: 12px;
            font-size: 14px;
            opacity: .9;
            line-height: 1.6;
        }

        /* =========================
           TEXT
        ========================== */
        .title {
            margin: 0 0 10px;
            font-size: 18px;
            font-weight: bold;
            color: #111827;
        }

        .paragraph {
            margin: 0;
            font-size: 15px;
            line-height: 1.8;
            color: #6b7280;
        }

        .mb-30 {
            margin-bottom: 30px;
        }

        .mt-35 {
            margin-top: 35px;
        }

        /* =========================
           ORDER CARD
        ========================== */
        .card {
            width: 100%;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            overflow: hidden;
            margin-top: 30px;
        }

        .card-header {
            background: #f9fafb;
            padding: 22px;
            border-bottom: 1px solid #e5e7eb;
        }

        .card-body {
            padding: 22px;
        }

        .invoice-label,
        .detail-label {
            font-size: 13px;
            color: #6b7280;
        }

        .invoice-number {
            margin-top: 6px;
            font-size: 22px;
            font-weight: bold;
            color: #111827;
        }

        .status-badge {
            display: inline-block;
            padding: 10px 18px;
            border-radius: 999px;
            background: #dbeafe;
            color: #1d4ed8;
            font-size: 13px;
            font-weight: bold;
        }

        .detail-value {
            font-size: 15px;
            font-weight: bold;
            color: #111827;
        }

        .detail-row td {
            padding: 10px 0;
        }

        /* =========================
           PROGRESS
        ========================== */
        .progress-title {
            margin: 0 0 24px;
            font-size: 20px;
            font-weight: bold;
            color: #111827;
        }

        .progress-wrapper {
            width: 100%;
        }

        .progress-item {
            text-align: center;
            position: relative;
        }

        .progress-circle {
            width: 46px;
            height: 46px;
            line-height: 46px;
            border-radius: 50%;
            margin: auto;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
        }

        .progress-active {
            background: #206bc4;
            color: #ffffff;
        }

        .progress-inactive {
            background: #e5e7eb;
            color: #9ca3af;
        }

        .progress-label {
            margin-top: 10px;
            font-size: 13px;
            color: #374151;
            font-weight: 600;
        }

        .line {
            height: 4px;
            background: #dbeafe;
            width: 100%;
            margin-top: -24px;
        }

        /* =========================
           BUTTON
        ========================== */
        .button-wrapper {
            margin-top: 40px;
            text-align: center;
        }

        .button {
            display: inline-block;
            padding: 14px 30px;
            background: #206bc4;
            color: #ffffff !important;
            border-radius: 12px;
            font-size: 14px;
            font-weight: bold;
        }

        /* =========================
           FOOTER
        ========================== */
        .footer {
            background: #f9fafb;
            padding: 25px;
            text-align: center;
            font-size: 13px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
        }

        /* =========================
           RESPONSIVE
        ========================== */
        @media only screen and (max-width: 620px) {

            .content {
                padding: 28px 22px;
            }

            .header {
                padding: 32px 24px;
            }

            .header-title {
                font-size: 24px;
            }

            .invoice-number {
                font-size: 18px;
            }

            .button {
                width: 100%;
                box-sizing: border-box;
            }
        }
    </style>
</head>

<body>
    <table width="100%" class="wrapper">
        <tr>
            <td align="center">
                <table class="container" width="620">
                    <!-- =========================
                         HEADER
                    ========================== -->
                    <tr>
                        <td class="header">

                            <img style="width: auto;height:70px;align: center;" src="{{ url('assets/images/logo/tokomirai-logo.png')  }}" alt="Tokomirai Logo">
                        </td>
                    </tr>
                    <!-- =========================
                         CONTENT
                    ========================== -->
                    <tr>
                        <td class="content">
                            <h3 class="title">
                                Halo, {{ $transaction->name }}
                            </h3>

                            <p class="paragraph mb-30">
                                Pesanan Anda telah diperbarui. Berikut detail status terbaru dari transaksi Anda.
                            </p>
                            <!-- =========================
                                 ORDER CARD
                            ========================== -->
                            <table class="card" width="100%">
                                <!-- CARD HEADER -->
                                <tr>
                                    <td class="card-header">
                                        <table width="100%">
                                            <tr>
                                                <td>
                                                    <div class="invoice-label">
                                                        Invoice Number
                                                    </div>
                                                    <div class="invoice-number">
                                                        {{ $transaction->invoice }}
                                                    </div>
                                                </td>
                                                <td align="right">
                                                    <span class="status-badge">
                                                        {{ $transaction->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <!-- CARD BODY -->
                                <tr>
                                    <td class="card-body">
                                        <table width="100%">
                                            <tr class="detail-row">
                                                <td class="detail-label">
                                                    Total Pembelian
                                                </td>
                                                <td align="right" class="detail-value">
                                                    Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                            <tr class="detail-row">
                                                <td class="detail-label">
                                                    Tanggal Order
                                                </td>
                                                <td align="right" class="detail-value">
                                                    {{ \Carbon\Carbon::parse($transaction->created_at)->format('d M Y H:i') }}
                                                </td>

                                            </tr>
                                            <tr class="detail-row">
                                                <td class="detail-label">
                                                    Alamat Pengiriman
                                                </td>
                                                <td align="right" class="detail-value">
                                                    {{ $transaction->address }}
                                                </td>

                                            </tr>

                                        </table>

                                    </td>
                                </tr>

                            </table>

                            <!-- =========================
     PRODUCT DETAIL
========================== -->
                            <table width="100%" style="margin-top:25px;border-collapse:collapse;">
                                <tr>
                                    <td colspan="4"
                                        style="padding-bottom:14px;
                   font-size:16px;
                   font-weight:bold;
                   color:#111827;">
                                        Detail Barang
                                    </td>
                                </tr>

                                <!-- TABLE HEADER -->
                                <tr style="background:#f9fafb;">
                                    <th align="left"
                                        style="padding:12px;
                   border:1px solid #e5e7eb;
                   font-size:13px;
                   color:#374151;">
                                        Nama Barang
                                    </th>

                                    <th align="center"
                                        style="padding:12px;
                   border:1px solid #e5e7eb;
                   font-size:13px;
                   color:#374151;">
                                        QTY
                                    </th>

                                    <th align="right"
                                        style="padding:12px;
                   border:1px solid #e5e7eb;
                   font-size:13px;
                   color:#374151;">
                                        Price
                                    </th>

                                    <th align="right"
                                        style="padding:12px;
                   border:1px solid #e5e7eb;
                   font-size:13px;
                   color:#374151;">
                                        Total
                                    </th>
                                </tr>

                                <!-- PRODUCT ITEM -->
                                @foreach($transaction->details as $item)
                                <tr>
                                    <td style="padding:12px;
                   border:1px solid #e5e7eb;
                   font-size:14px;
                   color:#111827;">
                                        {{ $item->name }}
                                    </td>

                                    <td align="center"
                                        style="padding:12px;
                   border:1px solid #e5e7eb;
                   font-size:14px;
                   color:#111827;">
                                        {{ $item->qty }}
                                    </td>

                                    <td align="right"
                                        style="padding:12px;
                   border:1px solid #e5e7eb;
                   font-size:14px;
                   color:#111827;">
                                        Rp {{ number_format($item->price,0,',','.') }}
                                    </td>

                                    <td align="right"
                                        style="padding:12px;
                   border:1px solid #e5e7eb;
                   font-size:14px;
                   font-weight:bold;
                   color:#111827;">
                                        Rp {{ number_format($item->qty * $item->price,0,',','.') }}
                                    </td>
                                </tr>
                                @endforeach
                            </table>

                            <!-- =========================
                                 PROGRESS
                            ========================== -->
                            <div class="mt-35">
                                <h3 class="progress-title">
                                    Progress Pesanan
                                </h3>
                                <table class="progress-wrapper" width="100%">
                                    <tr>
                                        <!-- PENDING -->
                                        <td class="progress-item">
                                            <div class="progress-circle progress-active">
                                                ✓
                                            </div>
                                            <div class="progress-label">
                                                Pending
                                            </div>
                                        </td>

                                        <!-- PROCESS -->
                                        <td class="progress-item">
                                            <div class="progress-circle 
                                                {{ in_array($transaction->status, ['PROCESS','SHIPPING','DONE']) 
                                                    ? 'progress-active' 
                                                    : 'progress-inactive' }}">
                                                ✓
                                            </div>
                                            <div class="progress-label">
                                                Process
                                            </div>
                                        </td>

                                        <!-- SHIPPING -->
                                        <td class="progress-item">
                                            <div class="progress-circle 
                                                {{ in_array($transaction->status, ['SHIPPING','DONE']) 
                                                    ? 'progress-active' 
                                                    : 'progress-inactive' }}">
                                                ✓
                                            </div>
                                            <div class="progress-label">
                                                Shipping
                                            </div>
                                        </td>
                                        <!-- DONE -->
                                        <td class="progress-item">
                                            <div class="progress-circle 
                                                {{ $transaction->status == 'DONE' 
                                                    ? 'progress-active' 
                                                    : 'progress-inactive' }}">
                                                ✓
                                            </div>
                                            <div class="progress-label">
                                                Done
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- =========================
                                 BUTTON
                            ========================== -->
                            <div class="button-wrapper">
                                <a href="{{ url('list-order') }}"
                                    class="button">
                                    Lihat Detail Pesanan
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- =========================
                         FOOTER
                    ========================== -->
                    <tr>
                        <td class="footer">
                            © {{ date('Y') }} TokoMirai.
                            All rights reserved.

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>