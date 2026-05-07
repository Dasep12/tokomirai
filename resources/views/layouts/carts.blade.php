<!-- CART OVERLAY + DRAWER -->
<div class="overlay" id="ov" onclick="closeCart()"></div>
<div class="drawer" id="drw">
    <div class="drw-hd">
        <div class="drw-title"><i class="ti ti-shopping-cart"></i>Keranjang Belanja (<span id="drwCount">0</span> item)</div>
        <button class="drw-cls" onclick="closeCart()"><i class="ti ti-x"></i></button>
    </div>
    <div class="drw-body" id="drwBody"></div>
    <div class="drw-ft" id="drwFt" style="display:none">
        <div class="sum-row"><span>Subtotal</span><span id="drwSub">Rp 0</span></div>
        <div class="sum-row"><span>PPN (11%)</span><span id="drwTax">Rp 0</span></div>
        <div class="sum-row tot"><span>Total</span><span id="drwTot">Rp 0</span></div>
        <button class="btn-co" onclick="goCheckout()"><i class="ti ti-credit-card"></i>Lanjut ke Pembayaran</button>
    </div>
</div>