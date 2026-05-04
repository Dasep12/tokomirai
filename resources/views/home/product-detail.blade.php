@extends("layouts.main")

@section('content')
<!-- Right: Details -->
<div class="col-12 col-md-7">
    <div class="d-flex align-items-start justify-content-between">
        <h1 class="product-title">HP Pavillion 2026</h1>
        <button class="wishlist-btn ms-3" id="wishBtn" onclick="toggleWish()">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
            </svg>
        </button>
    </div>

    <!-- Price -->
    <div class="d-flex align-items-center gap-3 mb-3 flex-wrap">
        <span class="price-main">Rp 12.999.000</span>
        <div class="d-flex align-items-center gap-2">
            <span class="badge-discount">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                    <polyline points="17 6 23 6 23 12"></polyline>
                </svg>
                10%
            </span>
            <span class="price-original">Rp 13.699.000</span>
        </div>
    </div>

    <div class="divider"></div>

    <!-- Specs -->
    <div class="mb-3">
        <div class="section-label">Spesifikasi:</div>
        <ul class="spec-list">
            <li>Intel Core i7-1260P (12th Gen, 3.4GHz Turbo)</li>
            <li>RAM 16GB DDR4 3200MHz</li>
            <li>SSD NVMe 512GB PCIe Gen 4</li>
            <li>Layar 15.6" FHD IPS Anti-glare 250 nits</li>
            <li>NVIDIA GeForce RTX 3050 4GB GDDR6</li>
            <li>Windows 11 Home</li>
            <li>Baterai 3-cell 41Wh + Charger 65W</li>
        </ul>
    </div>

    <div class="divider"></div>

    <!-- Description -->
    <div class="mb-4">
        <div class="section-label">Deskripsi:</div>
        <p class="desc-text">
            HP Pavilion 2026 hadir dengan desain tipis dan elegan yang cocok untuk produktivitas sehari-hari maupun hiburan. Didukung prosesor generasi terbaru dan kartu grafis diskret, laptop ini mampu menangani multitasking berat, editing foto/video ringan, serta gaming casual dengan mulus. Layar FHD IPS-nya menawarkan reproduksi warna yang akurat dan sudut pandang lebar.
        </p>
    </div>

    <!-- CTA -->
    <button class="btn-order" onclick="orderNow()">Pesan Sekarang</button>
</div>

@include("../layouts/footer")
@endsection