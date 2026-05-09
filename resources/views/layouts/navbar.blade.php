    <!-- MAIN NAVBAR -->
    <nav class="main-nav">
        <div class="nav-inner">
            <button class="hmbg" onclick="toggleMobSearch()"><i class="ti ti-menu-2"></i></button>
            <a class="nav-logo" onclick="goHome()">
                <img class="img-logo" src="{{ asset('assets/images/logo/tokomirai-logo.png') }}" alt="">
            </a>
            <!-- IKA DI HOME ATAU DI INDEX MUNCULKAN -->
            @if (request()->routeIs('home') || request()->routeIs('index'))
            @include("layouts.search")
            @endif
            <!-- END -->
            <div class="nav-actions">
                <a class="nav-act-btn" style="text-decoration: none;" href="/"><i class="ti ti-home"></i><span>Beranda</span></a>

                @if (Auth::check())

                @if (Auth::user()->is_admin)
                <a href="{{ route('admin.home') }}" class="nav-act-btn"><i class="ti ti-building-store"></i><span>Kelola Toko Saya</span></a>
                @endif

                <a href="{{ route('cart.list-order') }}" class="nav-act-btn"><i class="ti ti-shopping-bag"></i></i><span>Pesanan Saya</span></a>
                @endif

                <a href="{{ route('auth.login') }}" class="nav-act-btn"><i class="ti ti-user-circle"></i><span>
                        @if (Auth::check())
                        Akun Saya
                        @else
                        Login
                        @endif
                    </span></a>
                <button class="nav-act-btn" onclick="openCart()">
                    <i class="ti ti-shopping-cart-down"></i>
                    <span class="cart-badge" id="cBadge">0</span>
                    <span>Keranjang</span>
                </button>
            </div>
        </div>
    </nav>