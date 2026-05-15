<?php

use Illuminate\Support\Facades\DB;

$category = DB::table('mst_category')->where('type', 'barang')->get();
?>

<!-- CATEGORY NAV (desktop) -->
<nav class="cat-nav">
    <div class="cat-nav-inner">
        <div class="cat-nav-item active" onclick="changeCategory('all',this)"><i class="ti ti-layout-grid"></i>Semua Produk</div>
        @foreach($category as $categ)
        <div class="cat-nav-item" onclick="changeCategory('laptop',this)"><?= $categ->icon ?> {{ $categ->name_category }}</div>
        <!-- <div class="cat-nav-item" onclick="changeCategory('networking',this)"><i class="ti ti-router"></i>Networking</div>
        <div class="cat-nav-item" onclick="changeCategory('storage',this)"><i class="ti ti-database"></i>Storage</div>
        <div class="cat-nav-item" onclick="changeCategory('aksesoris',this)"><i class="ti ti-mouse"></i>Aksesoris</div>
        <div class="cat-nav-item" onclick="changeCategory('monitor',this)"><i class="ti ti-device-desktop"></i>Monitor</div>
        <div class="cat-nav-item" onclick="changeCategory('server',this)"><i class="ti ti-server"></i>Server & NAS</div>
        <div class="cat-nav-item" onclick="changeCategory('security',this)"><i class="ti ti-shield-lock"></i>Security</div> -->
        @endforeach
        <div class="cat-nav-item" onclick="scrollToServices()"><i class="ti ti-tools"></i>Layanan Jasa</div>
    </div>
</nav>