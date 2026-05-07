@extends("layouts.main")

@section('content')
@include("layouts.carts")

<!-- =============================================================== -->
<!-- PAGE: ORDER LIST -->
<!-- =============================================================== -->
<div class="pg on" id="pgCheckout">

    <!-- BREADCRUMB -->
    <div style="max-width:1280px;margin:0 auto;padding:.75rem 1.5rem;border-bottom:1px solid var(--gray-e);display:flex;align-items:center;gap:.5rem;font-size:12.5px;color:var(--gray-b)">
        <span onclick="goHome()" style="cursor:pointer;color:var(--blue)">
            <i class="ti ti-home" style="font-size:14px"></i>
            Beranda
        </span>

        <i class="ti ti-chevron-right" style="font-size:12px"></i>

        <span style="color:var(--black);font-weight:700">
            Pesanan Saya
        </span>
    </div>

    <div class="co-wrap">

        <!-- TITLE -->
        <h2 style="font-size:1.3rem;font-weight:800;margin-bottom:1.5rem;display:flex;align-items:center;gap:.5rem">
            <i class="ti ti-package" style="color:var(--blue)"></i>
            Pesanan Saya
        </h2>

        <!-- CARD -->
        <div class="co-card">

            <div style="overflow-x:auto">

                <table style="width:100%;border-collapse:collapse">

                    <thead>
                        <tr style="background:#f8fafc;border-bottom:1px solid #e5e7eb">
                            <th style="padding:14px;text-align:left;font-size:13px">Invoice</th>
                            <th style="padding:14px;text-align:left;font-size:13px">Tanggal</th>
                            <th style="padding:14px;text-align:center;font-size:13px">
                                Status
                            </th>
                            <th style="padding:14px;text-align:left;font-size:13px">Produk</th>
                            <th style="padding:14px;text-align:center;font-size:13px">Qty</th>
                            <th style="padding:14px;text-align:right;font-size:13px">Subtotal</th>
                            <th style="padding:14px;text-align:right;font-size:13px">Grand Total</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($transactions as $trx)

                        @php
                        $totalItem = count($trx->details);
                        @endphp

                        @foreach($trx->details as $index => $detail)

                        <tr style="border-bottom:1px solid #f1f5f9">

                            @if($index == 0)

                            <!-- INVOICE -->
                            <td style="padding:14px" rowspan="{{ $totalItem }}">

                                <div style="font-weight:700">
                                    {{ $trx->invoice }}
                                </div>

                                <div style="font-size:12px;color:#64748b;margin-top:3px">
                                    {{ $trx->name }}
                                </div>

                            </td>

                            <!-- TANGGAL -->
                            <td style="padding:14px;font-size:13px;color:#475569"
                                rowspan="{{ $totalItem }}">

                                {{ \Carbon\Carbon::parse($trx->created_at)->format('d M Y H:i') }}

                            </td>
                            @if($index == 0)

                            <!-- STATUS -->
                            <td style="padding:14px;text-align:center"
                                rowspan="{{ $totalItem }}">

                                <?php

                                $bg = "#f1f5f9";
                                $color = '#475569';

                                if ($trx->status == 'PENDING') {
                                    $bg = '#fef3c7';
                                    $color = '#92400e';
                                }

                                if ($trx->status == 'PROCESS') {
                                    $bg = '#dbeafe';
                                    $color = '#1d4ed8';
                                }

                                if ($trx->status == 'PAID') {
                                    $bg = '#dcfce7';
                                    $color = '#166534';
                                }

                                if ($trx->status == 'SHIPPED') {
                                    $bg = '#ede9fe';
                                    $color = '#6d28d9';
                                }

                                if ($trx->status == 'DONE') {
                                    $bg = '#dcfce7';
                                    $color = '#166534';
                                }

                                if ($trx->status == 'CANCEL') {
                                    $bg = '#fee2e2';
                                    $color = '#991b1b';
                                }

                                ?>

                                <span style="
            display:inline-flex;
            align-items:center;
            justify-content:center;
            padding:6px 12px;
            border-radius:999px;
            font-size:11px;
            font-weight:700;
            background:{{ $bg }};
            color:{{ $color }};
        ">
                                    {{ $trx->status }}
                                </span>

                            </td>

                            @endif

                            @endif

                            <!-- PRODUK -->
                            <td style="padding:14px">

                                <div style="font-weight:600">
                                    {{ $detail->name }}
                                </div>

                                <div style="font-size:12px;color:#64748b">
                                    Rp {{ number_format($detail->price,0,',','.') }}
                                </div>

                            </td>

                            <!-- QTY -->
                            <td style="padding:14px;text-align:center">
                                {{ $detail->qty }}
                            </td>

                            <!-- SUBTOTAL -->
                            <td style="padding:14px;text-align:right;font-weight:600">
                                Rp {{ number_format($detail->subtotal,0,',','.') }}
                            </td>

                            @if($index == 0)

                            <!-- TOTAL -->
                            <td style="padding:14px;text-align:right"
                                rowspan="{{ $totalItem }}">

                                <div style="font-size:12px;color:#64748b">
                                    Total Belanja
                                </div>

                                <div style="font-weight:800;color:var(--blue);margin-top:3px">
                                    Rp {{ number_format($trx->grand_total,0,',','.') }}
                                </div>

                                <div style="font-size:11px;color:#64748b;margin-top:8px">
                                    PPN 11%:
                                    Rp {{ number_format($trx->tax,0,',','.') }}
                                </div>

                            </td>

                            @endif

                        </tr>

                        @endforeach

                        @empty

                        <tr>
                            <td colspan="6"
                                style="padding:40px;text-align:center;color:#94a3b8">

                                <i class="ti ti-package-off"
                                    style="font-size:42px;display:block;margin-bottom:10px"></i>

                                Belum ada pesanan

                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>
@endsection