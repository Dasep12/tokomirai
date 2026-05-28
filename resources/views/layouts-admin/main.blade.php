<?php

use Illuminate\Support\Facades\Auth;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - TokoMirai</title>
    <!-- Tabler Core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/style-admin.css') }}">
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
            --sidebar-width: 260px;
            --sidebar-bg: #1a1a2e;
            --sidebar-border: rgba(255,255,255,0.07);
            --topbar-height: 56px;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }

        /* =============================================
           MOBILE TOPBAR
        ============================================= */
        .mobile-topbar {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--topbar-height);
            background: var(--sidebar-bg);
            z-index: 1040;
            align-items: center;
            padding: 0 1rem;
            gap: 0.75rem;
            box-shadow: 0 2px 12px rgba(0,0,0,0.3);
        }

        .mobile-topbar .brand-logo {
            height: 32px;
            width: auto;
        }

        .mobile-topbar .brand-name {
            color: #fff;
            font-weight: 700;
            font-size: 1.1rem;
            flex: 1;
            letter-spacing: 0.3px;
        }

        .btn-hamburger {
            background: none;
            border: none;
            color: #fff;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.25rem 0.5rem;
            border-radius: 8px;
            transition: background 0.2s;
            display: flex;
            align-items: center;
        }

        .btn-hamburger:hover {
            background: rgba(255,255,255,0.1);
        }

        .mobile-user-btn {
            background: none;
            border: none;
            color: #fff;
            cursor: pointer;
            padding: 0.25rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            transition: background 0.2s;
        }

        .mobile-user-btn:hover {
            background: rgba(255,255,255,0.1);
        }

        /* =============================================
           SIDEBAR OVERLAY (mobile)
        ============================================= */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.55);
            z-index: 1045;
            backdrop-filter: blur(2px);
            opacity: 0;
            transition: opacity 0.25s ease;
        }

        .sidebar-overlay.active {
            opacity: 1;
        }

        /* =============================================
           SIDEBAR
        ============================================= */
        aside.navbar-vertical {
            transition: transform 0.28s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* =============================================
           PAGE BODY OFFSET ON MOBILE
        ============================================= */
        @media (max-width: 991.98px) {
            .mobile-topbar {
                display: flex;
            }

            /* Push page content below the topbar */
            .page {
                padding-top: var(--topbar-height);
            }

            /* Sidebar becomes a slide-in drawer */
            aside.navbar-vertical {
                position: fixed !important;
                top: 0;
                left: 0;
                height: 100vh;
                width: var(--sidebar-width) !important;
                z-index: 1050;
                transform: translateX(-100%);
                overflow-y: auto;
                border-right: 1px solid var(--sidebar-border);
            }

            aside.navbar-vertical.sidebar-open {
                transform: translateX(0);
            }

            .sidebar-overlay.active {
                display: block;
            }

            /* Adjust page-wrapper so it starts after topbar */
            .page-wrapper {
                margin-left: 0 !important;
            }

            /* Hide desktop-only header */
            .desktop-header {
                display: none !important;
            }
        }

        @media (min-width: 992px) {
            .mobile-topbar {
                display: none !important;
            }

            .sidebar-overlay {
                display: none !important;
            }

            /* Show desktop header */
            .desktop-header {
                display: flex !important;
            }
        }
    </style>
</head>

<body>
    <!-- =============================================
         MOBILE TOP NAVBAR
    ============================================= -->
    <div class="mobile-topbar" id="mobileTopbar">
        <button class="btn-hamburger" id="btnToggleSidebar" aria-label="Toggle Menu">
            <i class="ti ti-menu-2"></i>
        </button>
        <img src="{{ asset('assets/images/logo/tokomirai-white-logo.png') }}" alt="TokoMirai Logo" class="brand-logo">
        <span class="brand-name">TokoMirai</span>

        <!-- Mobile User Dropdown -->
        <div class="nav-item dropdown">
            <button class="mobile-user-btn" data-bs-toggle="dropdown" aria-label="User Menu">
                <span class="avatar avatar-sm" style="background: rgba(255,255,255,0.15);">
                    <i class="ti ti-user" style="color:#fff;"></i>
                </span>
            </button>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <div class="dropdown-header">
                    <strong>{{ Auth::user()->name }}</strong><br>
                    <small class="text-muted">Admin TokoMirai</small>
                </div>
                <div class="dropdown-divider"></div>
                <a href="/logout" class="dropdown-item text-danger">
                    <i class="ti ti-logout me-2"></i> Logout
                </a>
            </div>
        </div>
    </div>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="page">
        <!-- =============================================
             SIDEBAR
        ============================================= -->
        <aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark" id="mainSidebar">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
                    aria-controls="sidebar-menu" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h1 class="navbar-brand navbar-brand-autodark">
                    <a href="{{ route('admin.home') }}">
                        <img src="{{ asset('assets/images/logo/tokomirai-white-logo.png') }}" alt="TokoMirai Logo"
                            class="navbar-brand-image" width="32" height="32">
                    </a>
                </h1>
                <div class="collapse navbar-collapse" id="sidebar-menu">
                    <ul class="navbar-nav pt-lg-3">

                        <!-- Dashboard -->
                        <li class="nav-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('admin.home') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                        <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                        <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">Dashboard</span>
                            </a>
                        </li>

                        <!-- Produk & Layanan (Dropdown) -->
                        <li class="nav-item dropdown {{ Request::routeIs('admin.products*') || Request::routeIs('admin.services*') ? 'active' : '' }}">
                            <a class="nav-link dropdown-toggle {{ Request::routeIs('admin.products*') || Request::routeIs('admin.services*') ? 'show' : '' }}"
                                href="#navbar-base"
                                data-bs-toggle="dropdown"
                                data-bs-auto-close="false"
                                role="button"
                                aria-expanded="{{ Request::routeIs('admin.products*') || Request::routeIs('admin.services*') ? 'true' : 'false' }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5" />
                                        <path d="M12 12l8 -4.5" />
                                        <path d="M12 12l0 9" />
                                        <path d="M12 12l-8 -4.5" />
                                        <path d="M16 5.25l-8 4.5" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">Produk & Layanan</span>
                            </a>
                            <div class="dropdown-menu {{ Request::routeIs('admin.products*') || Request::routeIs('admin.services*') ? 'show' : '' }}">
                                <a class="dropdown-item {{ Request::routeIs('admin.products*') ? 'active' : '' }}" href="{{ route('admin.products') }}">Daftar Product</a>
                                <a class="dropdown-item {{ Request::routeIs('admin.services*') ? 'active' : '' }}" href="{{ route('admin.services') }}">Daftar Layanan</a>
                            </div>
                        </li>

                        <!-- Transaksi -->
                        <li class="nav-item {{ Request::routeIs('admin.transactions*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('admin.transactions') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                        <path d="M9 5a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2" />
                                        <path d="M14 11h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5" />
                                        <path d="M12 17v1m0 -8v1" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">Transaksi</span>
                            </a>
                        </li>

                        <!-- Customer -->
                        <li class="nav-item {{ Request::routeIs('admin.customers*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('admin.customers') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M13 18l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v4.5" />
                                        <path d="M17 17a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M22 22a2 2 0 0 0 -2 -2h-2a2 2 0 0 0 -2 2" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">Customer</span>
                            </a>
                        </li>

                        <!-- Users -->
                        <li class="nav-item {{ Request::routeIs('admin.users*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('admin.users') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M5 7a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">Users</span>
                            </a>
                        </li>

                        <!-- Settings -->
                        <li class="nav-item {{ Request::routeIs('admin.settings*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('admin.settings') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065" />
                                        <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">Settings</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </aside>

        <div class="page-wrapper">
            <!-- =============================================
                 DESKTOP HEADER (hidden on mobile)
            ============================================= -->
            <header class="navbar navbar-expand-md desktop-header d-print-none">
                <div class="container-xl">
                    <div class="navbar-nav flex-row order-md-last">
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown">
                                <span class="avatar avatar-sm"><i class="ti ti-users"></i></span>
                                <div class="d-none d-xl-block ps-2">
                                    <div>Admin TokoMirai</div>
                                    <div class="mt-1 small text-secondary">{{ Auth::user()->name }}</div>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <a href="/logout" class="dropdown-item">Logout</a>
                            </div>
                        </div>
                    </div>
                    <div class="collapse navbar-collapse" id="navbar-menu">
                        <!-- Opsional: Form Pencarian -->
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <div class="page-body">
                <div class="container-xl">
                    @yield('content')
                </div>
            </div>

            <!-- Footer -->
            <footer class="footer footer-transparent d-print-none">
                <div class="container-xl">
                    <div class="row text-center align-items-center flex-row-reverse">
                        <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item">
                                    Copyright &copy; {{ date('Y') }} TokoMirai. All rights reserved.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index:9999">
        <div id="liveToast" class="toast align-items-center border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body" id="toastMessage">
                    Success
                </div>

                <button
                    type="button"
                    class="btn-close btn-close-white me-2 m-auto"
                    data-bs-dismiss="toast">
                </button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>

    <script>
        /* =============================================
           MOBILE SIDEBAR TOGGLE
        ============================================= */
        (function () {
            const btnToggle   = document.getElementById('btnToggleSidebar');
            const sidebar     = document.getElementById('mainSidebar');
            const overlay     = document.getElementById('sidebarOverlay');

            function openSidebar() {
                sidebar.classList.add('sidebar-open');
                overlay.style.display = 'block';
                // Force reflow before adding active for CSS transition
                requestAnimationFrame(() => overlay.classList.add('active'));
                document.body.style.overflow = 'hidden';
            }

            function closeSidebar() {
                sidebar.classList.remove('sidebar-open');
                overlay.classList.remove('active');
                document.body.style.overflow = '';
                // Hide overlay after transition
                setTimeout(() => {
                    if (!overlay.classList.contains('active')) {
                        overlay.style.display = 'none';
                    }
                }, 280);
            }

            if (btnToggle) {
                btnToggle.addEventListener('click', function () {
                    if (sidebar.classList.contains('sidebar-open')) {
                        closeSidebar();
                    } else {
                        openSidebar();
                    }
                });
            }

            if (overlay) {
                overlay.addEventListener('click', closeSidebar);
            }

            // Close sidebar when a nav-link is clicked on mobile
            if (sidebar) {
                sidebar.querySelectorAll('.nav-link:not(.dropdown-toggle)').forEach(function (link) {
                    link.addEventListener('click', function () {
                        if (window.innerWidth < 992) {
                            closeSidebar();
                        }
                    });
                });
            }

            // Close sidebar when resizing to desktop
            window.addEventListener('resize', function () {
                if (window.innerWidth >= 992) {
                    closeSidebar();
                    document.body.style.overflow = '';
                }
            });
        })();

        /* =============================================
           TOAST HELPER
        ============================================= */
        function showToast(message, type = 'success') {
            const toastEl = document.getElementById('liveToast');
            if (!toastEl) return;

            $(toastEl).removeClass('bg-success bg-danger bg-warning text-white');
            if (type === 'success') $(toastEl).addClass('bg-success text-white');
            else if (type === 'error') $(toastEl).addClass('bg-danger text-white');
            else if (type === 'warning') $(toastEl).addClass('bg-warning');

            $('#toastMessage').html(message);

            const bootstrapInstance = window.bootstrap || (window.tabler ? window.tabler.bootstrap : null);

            if (bootstrapInstance) {
                const toast = new bootstrapInstance.Toast(toastEl);
                toast.show();
            } else {
                $(toastEl).addClass('show');
                setTimeout(() => $(toastEl).removeClass('show'), 3000);
            }
        }
    </script>
    @stack('scripts')
</body>

</html>