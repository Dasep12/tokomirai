<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Order Baru</title>
</head>

<body style="font-family:Arial, sans-serif; background:#f5f7fa; padding:20px;">

    <div style="max-width:600px;margin:auto;background:#ffffff;border-radius:10px;overflow:hidden;box-shadow:0 5px 20px rgba(0,0,0,0.08)">

        <!-- HEADER -->
        <div style="background:#2563eb;color:white;padding:20px;text-align:center;">
            <h2 style="margin:0;">🛒 Order Baru Masuk</h2>
            <small>{{ $data['invoice'] }}</small>
        </div>

        <!-- CUSTOMER -->
        <div style="padding:20px;">
            <h3 style="margin-bottom:10px;">Data Customer</h3>
            <p><b>Nama:</b> {{ $data['name'] }}</p>
            <p><b>Telepon:</b> {{ $data['phone'] }}</p>
            <p><b>Email:</b> {{ $data['email'] }}</p>
            <p><b>Alamat:</b><br>
                {{ $data['address'] }}<br>
                {{ $data['village'] }}, {{ $data['district'] }}<br>
                {{ $data['city'] }}, {{ $data['province'] }} - {{ $data['postal_code'] }}
            </p>
        </div>

        <!-- ORDER -->
        <div style="padding:20px;">
            <h3>Detail Pesanan</h3>

            <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse:collapse;">
                <thead>
                    <tr style="background:#f1f5f9;">
                        <th align="left">Produk</th>
                        <th align="center">Qty</th>
                        <th align="right">Harga</th>
                        <th align="right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['items'] as $item)
                    <tr style="border-bottom:1px solid #eee;">
                        <td>{{ $item['name'] }}</td>
                        <td align="center">{{ $item['qty'] }}</td>
                        <td align="right">Rp {{ number_format($item['price']) }}</td>
                        <td align="right">Rp {{ number_format($item['price'] * $item['qty']) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- TOTAL -->
            <div style="text-align:right;margin-top:15px;">
                <p>Subtotal: Rp {{ number_format($data['total']) }}</p>
                <p>PPN 11%: Rp {{ number_format($data['tax']) }}</p>
                <h3>Grand Total: Rp {{ number_format($data['grand_total']) }}</h3>
            </div>
        </div>

        <!-- FOOTER -->
        <div style="background:#f1f5f9;padding:15px;text-align:center;font-size:12px;color:#666;">
            Order ini dibuat otomatis dari sistem 🚀
        </div>

    </div>

</body>

</html>