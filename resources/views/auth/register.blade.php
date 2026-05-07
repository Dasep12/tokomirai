@extends("layouts.main")

@section("content")
@include("layouts.carts");
<div class="auth-page">
    <div class="auth-card">
        <!-- LEFT -->
        <div class="auth-left">
            <div class="auth-brand">
                <div class="auth-logo">
                    <i class="ti ti-lock"></i>
                </div>
                <div>
                    <div class="auth-brand-title">
                        Selamat Datang
                    </div>
                    <div class="auth-brand-subtitle">
                        Daftar Akun Baru Anda
                    </div>
                </div>
            </div>

            <!-- ALERT -->

            @if ($errors->any())
            <div class="auth-alert error">
                <ul style="margin:0;padding-left:18px">
                    @foreach ($errors->all() as $error)
                    <li style="margin-bottom:4px">
                        {{ $error }}
                    </li>
                    @endforeach
                </ul>
            </div>

            @endif
            <!-- FORM -->
            <form action="/register-process"
                method="POST"
                class="auth-form">
                @csrf
                <div class="auth-group">
                    <label class="auth-label">
                        Name
                    </label>

                    <div class="auth-input-wrap">
                        <i class="ti ti-user"></i>
                        <input type="text"
                            name="name"
                            class="auth-input"
                            placeholder="Masukkan nama lengkap"
                            required>
                    </div>
                </div>
                <div class="auth-group">
                    <label class="auth-label">
                        Email
                    </label>

                    <div class="auth-input-wrap">
                        <i class="ti ti-mail"></i>
                        <input type="email"
                            name="email"
                            class="auth-input"
                            placeholder="Masukkan email"
                            required>
                    </div>
                </div>
                <div class="auth-group">
                    <label class="auth-label">
                        Password
                    </label>
                    <div class="auth-input-wrap">
                        <i class="ti ti-lock"></i>
                        <input type="password"
                            name="password"
                            class="auth-input"
                            placeholder="Masukkan password"
                            required>
                    </div>

                </div>
                <button type="submit" class="auth-btn">
                    <i class="ti ti-user-plus"></i>
                    Daftar
                </button>
            </form>

            <!-- DIVIDER -->
            <div class="auth-divider">
                <span>atau</span>
            </div>

            <!-- GOOGLE -->
            <a href="/auth/google"
                class="auth-google-btn">
                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg"
                    width="18">
                Login dengan Google
            </a>

            <!-- REGISTER -->
            <div class="auth-footer">
                Sudah punya akun?
                <a href="/login">
                    Login Sekarang
                </a>
            </div>
        </div>

        <!-- RIGHT -->
        <div class="auth-right">
            <div class="auth-right-overlay">
                <div class="auth-right-title">
                    Sistem Belanja Modern
                </div>
                <div class="auth-right-desc">
                    Kelola pesanan, pantau transaksi,
                    dan nikmati pengalaman belanja yang
                    lebih cepat dan aman.
                </div>
            </div>
        </div>
    </div>
</div>

@endsection