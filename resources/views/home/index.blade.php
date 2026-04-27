@extends("layouts.main")

@section('content')
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
    /* ── RENDER PRODUCTS ───────────────────────── */
    function renderProds(list) {
        const g = document.getElementById('prodGrid');
        if (!list.length) {
            g.innerHTML = '<p style="color:var(--gray-b);grid-column:1/-1;padding:1rem">Tidak ada produk ditemukan.</p>';
            return;
        }
        g.innerHTML = list.map(p => `
    <div class="prod-card" onclick="addById(${p.id})">
      <div class="prod-img-wrap">
        ${p.badge?`<span class="badge badge-${p.badge}">${p.badge==='hot'?'🔥 HOT':p.badge==='new'?'✨ NEW':p.badge==='sale'?'💸 SALE':p.badge.toUpperCase()}</span>`:''}
        ${p.ic}
      </div>
      <div class="prod-body">
        <div class="prod-name">${p.nm}</div>
        <div class="prod-spec">${p.sp}</div>
        <div class="prod-rating">
          <span class="stars">${'★'.repeat(Math.floor(p.rating))}${'☆'.repeat(5-Math.floor(p.rating))}</span>
          <span>${p.rating} (${p.sold} terjual)</span>
        </div>
        ${p.op?`<div class="prod-price-old">Rp ${p.op.toLocaleString('id-ID')}</div>`:''}
        <div class="prod-price">Rp ${p.pr.toLocaleString('id-ID')}</div>
        ${p.op?`<span class="prod-price-save">Hemat Rp ${(p.op-p.pr).toLocaleString('id-ID')}</span>`:''}
        <div class="prod-footer">
          <div class="status"><i class="ti ti-circle-check" style="font-size:12px"></i> Stok Tersedia</div>
          <button class="btn-add" id="ba${p.id}" onclick="event.stopPropagation();addById(${p.id})"><i class="ti ti-cart-plus"></i> Beli</button>
        </div>
      </div>
    </div>`).join('');
    }

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

    function setProdTab(el, cat) {
        document.querySelectorAll('.prod-tab').forEach(t => t.classList.remove('active'));
        el.classList.add('active');
        currentCat = cat;
        const list = cat === 'all' ? PRODUCTS : PRODUCTS.filter(p => p.cat === cat);
        renderProds(list);
    }

    function setCatActive(el, cat) {
        document.querySelectorAll('.cat-nav-item').forEach(i => i.classList.remove('active'));
        if (el) el.classList.add('active');
        currentCat = cat;
        const list = cat === 'all' ? PRODUCTS : PRODUCTS.filter(p => p.cat === cat);
        renderProds(list);
        // sync tab
        document.querySelectorAll('.prod-tab').forEach(t => {
            if (t.getAttribute('onclick') && t.getAttribute('onclick').includes(`'${cat}'`)) t.classList.add('active');
            else t.classList.remove('active');
        });
    }

    function doSearch() {
        const q = (document.getElementById('dskSearch').value || document.getElementById('mobSearch').value).toLowerCase();
        let list = currentCat === 'all' ? PRODUCTS : PRODUCTS.filter(p => p.cat === currentCat);
        if (q) list = PRODUCTS.filter(p => p.nm.toLowerCase().includes(q) || p.sp.toLowerCase().includes(q));
        renderProds(list);
    }
    renderProds(PRODUCTS);
    renderSvcs();
</script>
@endpush