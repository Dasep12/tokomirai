@extends("layouts.main")

@section('content')

@include("layouts.category-navbar");

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
    <div class="sum-row"><span>Ongkos Kirim</span><span>Rp 25.000</span></div>
    <div class="sum-row"><span>PPN (11%)</span><span id="drwTax">Rp 0</span></div>
    <div class="sum-row tot"><span>Total</span><span id="drwTot">Rp 0</span></div>
    <button class="btn-co" onclick="goCheckout()"><i class="ti ti-credit-card"></i>Lanjut ke Pembayaran</button>
  </div>
</div>

<!-- TOAST -->
<div class="toast-wrap" id="tw"></div>


<!-- =============================================================== -->
<!-- PAGE: HOME -->
<!-- =============================================================== -->
<div class="pg on" id="pgHome">

  @include("home.partials.hero-slider")
  @include("home.partials.category-shortcut")
  @include("home.partials.promo")
  @include("home.partials.trust-bar")
  @include("home.partials.product-section")
  @include("home.partials.news-features")
  @include("home.partials.services-section")
  @include("home.partials.buy-segment-section")
  @include("home.partials.partner-section")


  @include("../layouts/footer")




</div><!-- /pgHome -->
@endsection

@push("scripts")
<script>
  function renderSvcs() {
    document.getElementById('svcGrid').innerHTML = SERVICES.map(s => `
    <div class="svc-card">
      <div class="svc-ic"><i class="ti ${s.ic}" style="font-size:22px"></i></div>
      <div class="svc-nm">${s.nm}</div>
      <div class="svc-desc">${s.desc}</div>
      <div class="svc-price"><i class="ti ti-tag" style="font-size:11px"></i> ${s.pr}</div>
      <button class="btn-svc" onclick="orderSvc('${s.nm}')"><i class="ti ti-calendar-plus"></i> Pesan Sekarang</button>
    </div>`).join('');
  }


  renderSvcs();
</script>
@endpush