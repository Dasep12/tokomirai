    <!-- MAIN NAVBAR -->
    <nav class="main-nav">
        <div class="nav-inner">
            <button class="hmbg" onclick="toggleMobSearch()"><i class="ti ti-menu-2"></i></button>
            <a class="nav-logo" onclick="goHome()">
                <img class="img-logo" src="{{ asset('assets/images/logo/tokomirai-logo.png') }}" alt="">
            </a>
            <div class="nav-search">
                <i class="ti ti-search si"></i>
                <input type="text" id="dskSearch" placeholder="Cari laptop, router, SSD, dan lainnya..." oninput="doSearch()">
            </div>
            <div class="nav-actions">
                <a class="nav-act-btn" style="text-decoration: none;" href="/"><i class="ti ti-home"></i><span>Beranda</span></a>
                <!-- <button class="nav-act-btn"><i class="ti ti-heart"></i><span>Wishlist</span></button> -->
                <!-- <button class="nav-act-btn"><i class="ti ti-user-circle"></i><span>Akun</span></button> -->
                <button class="nav-act-btn" onclick="openCart()">
                    <i class="ti ti-shopping-cart"></i>
                    <span class="cart-badge" id="cBadge">0</span>
                    <span>Keranjang</span>
                </button>
            </div>
        </div>
    </nav>