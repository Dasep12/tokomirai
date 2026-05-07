@extends("layouts.main")

@section("content")
@include("layouts.carts");

<div class="account-page">
    <div class="account-wrap">
        <!-- SIDEBAR -->
        <div class="account-sidebar">
            <div class="account-profile">
                <img
                    src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}"
                    class="account-avatar">
                <div class="account-name">
                    {{ Auth::user()->name }}
                </div>
                <div class="account-email">
                    {{ Auth::user()->email }}
                </div>
                <div class="account-status-wrap">
                    <span class="account-status">
                        {{ Auth::user()->status }}
                    </span>
                </div>
            </div>

            <!-- MENU -->
            <div class="account-menu">
                <a href="/account" class="account-menu-item active">
                    <i class="ti ti-user"></i>
                    Akun Saya
                </a>
                <a href="{{ route('cart.list-order') }}" class="account-menu-item">
                    <i class="ti ti-package"></i>
                    Pesanan Saya
                </a>
                <a href="/logout" class="account-menu-item logout">
                    <i class="ti ti-logout"></i>
                    Logout
                </a>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="account-content">
            <div class="account-card">
                <div class="account-card-header">
                    <div>
                        <div class="account-title">
                            Informasi Akun
                        </div>
                        <div class="account-subtitle">
                            Kelola informasi akun Anda
                        </div>
                    </div>
                    <button class="btn-add">
                        <i class="ti ti-edit"></i>
                        Edit Profile
                    </button>
                </div>

                <!-- GRID -->
                <div class="account-grid">
                    <div class="account-field">
                        <div class="account-label">
                            Nama Lengkap
                        </div>
                        <div class="account-value">
                            {{ Auth::user()->name }}
                        </div>
                    </div>

                    <div class="account-field">
                        <div class="account-label">
                            Email
                        </div>
                        <div class="account-value">
                            {{ Auth::user()->email }}
                        </div>
                    </div>

                    <div class="account-field">
                        <div class="account-label">
                            Nomor HP
                        </div>
                        <div class="account-value">
                            {{ Auth::user()->phone ?? '-' }}
                        </div>
                    </div>
                    <div class="account-field">
                        <div class="account-label">
                            Provider Login
                        </div>
                        <div class="account-value">
                            {{ Auth::user()->provider ?? 'LOCAL' }}
                        </div>
                    </div>
                    <div class="account-field">
                        <div class="account-label">
                            Bergabung Sejak
                        </div>
                        <div class="account-value">
                            {{ \Carbon\Carbon::parse(Auth::user()->created_at)->format('d M Y') }}
                        </div>
                    </div>
                    <div class="account-field">
                        <div class="account-label">
                            Login Terakhir
                        </div>
                        <div class="account-value">
                            {{ Auth::user()->last_login_at
                                ? \Carbon\Carbon::parse(Auth::user()->last_login_at)->format('d M Y H:i')
                                : '-' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection