<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tokomirai — Solusi IT Terlengkap untuk Bisnis & Personal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.44.0/tabler-icons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}?<?= date('ymdhis') ?>">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

    <!-- LOADING -->
    <div id="ldg" style="display: none; position: fixed; inset: 0; background: rgba(34, 99, 219, 0.45); z-index: 9999; align-items: center; justify-content: center;">
        <div style="width: 44px; height: 44px; border: 3px solid var(--blue-l); border-top-color: var(--blue); border-radius: 50%; animation: spin .7s linear infinite;"></div>
    </div>
    <style>
        @keyframes spin {
            to {
                transform: rotate(360deg)
            }
        }
    </style>

    <!-- PROMO BAR -->
    <div class="promo-bar" id="promoBar">
        <i class="ti ti-discount-2"></i>
        <span>Program Special — <strong>Diskon s/d 5%</strong> untuk Laptop & Aksesoris IT. <a onclick="scrollToProducts()">Belanja Sekarang →</a></span>
        <button class="promo-bar-close" onclick="document.getElementById('promoBar').remove()">×</button>
    </div>

    <!-- UTILITY BAR -->
    <div class="utility-bar">
        <a target="_blank" href="https://www.google.com/maps/dir//Apartemen+Vasanta+Innopark,+Jl.+Kalimantan,+Gandamekar,+Kec.+Cikarang+Bar.,+Kabupaten+Bekasi,+Jawa+Barat+17530/@-6.2849024,107.085824,14z/data=!4m8!4m7!1m0!1m5!1m1!1s0x2e698fe230abdd3d:0xff20c0734390dde7!2m2!1d107.0856176!2d-6.2906623?hl=id-ID&entry=ttu&g_ep=EgoyMDI2MDQyNi4wIKXMDSoASAFQAw%3D%3D"><i class="ti ti-map-pin"></i> Toko Kami</a>
        <span class="sep">|</span>
        <a target="_blank" href="https://wa.me/6285218026895"><i class="ti ti-headset"></i> 62 852-1802-6895</a>
        <span class="sep">|</span>
        <!-- <a><i class="ti ti-truck"></i> Lacak Pesanan</a>
        <span class="sep">|</span> -->
        <!-- <a><i class="ti ti-user"></i> Masuk / Daftar</a>
        <span class="sep">|</span>
        <a><i class="ti ti-help-circle"></i> Dukungan</a> -->
    </div>

    @include("layouts.navbar");

    <!-- MOBILE SEARCH -->
    <div class="mob-srch" id="mobSrch">
        <input type="text" id="mobSearch" placeholder="Cari produk IT..." oninput="doSearch()">
    </div>




    <!-- CONTENT -->
    @yield("content")
    <!-- END CONTENT -->



    <!-- MOBILE BOTTOM NAV -->
    <div class="mob-nav">
        <div class="mob-nav-row">
            <button class="mob-nb on" id="mn-home" onclick="goHome();setMobNav('home')"><i class="ti ti-home"></i>Beranda</button>
            <button class="mob-nb" id="mn-cat" onclick="scrollToProducts();setMobNav('cat')"><i class="ti ti-layout-grid"></i>Produk</button>
            <button class="mob-nb" id="mn-cart" onclick="openCart()">
                <i class="ti ti-shopping-cart"></i>
                <span class="mob-cart-badge" id="cBadgeMob">0</span>
                Keranjang
            </button>
            <button class="mob-nb" id="mn-svc" onclick="scrollToServices();setMobNav('svc')"><i class="ti ti-tools"></i>Jasa</button>
            <!-- <button class="mob-nb" id="mn-acc"><i class="ti ti-user-circle"></i>Akun</button> -->
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/js/tabler.min.js"></script>
    <script>
        /* ── DATA ──────────────────────────────────── */
        const PRODUCTS = [{
            id: 1,
            nm: 'Lenovo ThinkPad X1 Carbon Gen 11',
            sp: 'Intel Core i7-1365U, 16GB LPDDR5, 512GB NVMe, 14" IPS 2.8K',
            pr: 18500000,
            cat: 'laptop',
            ic: '💻',
            badge: 'hot',
            rating: 4.8,
            sold: 342
        }];

        const SERVICES = [{
                ic: 'ti-device-desktop',
                nm: 'Instalasi & Setup PC/Laptop',
                desc: 'Pemasangan OS (Windows/Linux/macOS), driver, software esensial, dan konfigurasi awal perangkat baru maupun lama.',
                pr: 'Mulai Rp 150.000'
            },
            {
                ic: 'ti-router',
                nm: 'Setup Jaringan & WiFi',
                desc: 'Instalasi dan konfigurasi router, switch, access point, serta desain topologi jaringan untuk kantor atau rumah.',
                pr: 'Mulai Rp 300.000'
            },
            {
                ic: 'ti-shield-lock',
                nm: 'Keamanan IT & Antivirus',
                desc: 'Audit keamanan sistem, pemasangan antivirus enterprise, hardening, dan proteksi terhadap ransomware.',
                pr: 'Mulai Rp 500.000'
            },
            {
                ic: 'ti-database-import',
                nm: 'Backup & Recovery Data',
                desc: 'Pemulihan data dari HDD/SSD rusak, sistem terenkripsi ransomware, atau file terhapus tidak sengaja.',
                pr: 'Mulai Rp 350.000'
            },
            {
                ic: 'ti-tools',
                nm: 'Servis & Perbaikan Hardware',
                desc: 'Penggantian LCD, keyboard, baterai, motherboard, thermal paste, dan komponen hardware laptop maupun PC.',
                pr: 'Mulai Rp 100.000'
            },
            {
                ic: 'ti-cloud-upload',
                nm: 'Migrasi Cloud & Server',
                desc: 'Migrasi workload ke cloud AWS/GCP/Azure atau setup dan konfigurasi server on-premise untuk bisnis Anda.',
                pr: 'Mulai Rp 1.000.000'
            },
            {
                ic: 'ti-chart-bar',
                nm: 'IT Consulting & Audit',
                desc: 'Konsultasi infrastruktur IT, audit sistem eksisting, gap analysis, dan rekomendasi solusi teknologi.',
                pr: 'Mulai Rp 750.000'
            },
            {
                ic: 'ti-printer',
                nm: 'Servis Printer & Multifungsi',
                desc: 'Setup printer jaringan, sharing, penggantian cartridge/toner, chip reset, dan perawatan berkala.',
                pr: 'Mulai Rp 100.000'
            },
        ];

        /* ── STATE ─────────────────────────────────── */
        let cart = [];
        var currentCat = 'all';


        /* ── SEARCH ───────────────────────────── */
        function doSearch() {
            const q = (document.getElementById('dskSearch')?.value ||
                document.getElementById('mobSearch')?.value || '').toLowerCase();

            loadProducts(currentCat, q);
        }

        /* ── CHECKOUT ──────────────────────────────── */
        function goCheckout() {
            // if (!cart.length) {
            //     toast('Keranjang kosong!', 'err');
            //     return;
            // }
            // closeCart();
            // showPg('pgCheckout');
            // coStep = 1;
            // renderCoOrder();
            // showCoStep(1);
            // window.scrollTo(0, 0);
            var validated = "{{ Auth::check() ? true : false }}";
            if (!validated) {
                alert('Silakan login terlebih dahulu untuk lanjut checkout.');
                return;
            }
            window.location.href = "{{ route('cart.checkout') }}";
        }



        /* ── NAVIGATION ────────────────────────────── */
        function showPg(id) {
            document.querySelectorAll('.pg').forEach(p => p.classList.remove('on'));
            document.getElementById(id).classList.add('on');
        }

        function goHome() {
            // showPg('pgHome');
            // setMobNav('home');
            // window.scrollTo(0, 0);
            window.location.href = "{{ route('index') }}";
        }

        function scrollToProducts() {
            showPg('pgHome');
            setTimeout(() => document.getElementById('productsSection').scrollIntoView({
                behavior: 'smooth'
            }), 80);
        }

        function scrollToServices() {
            showPg('pgHome');
            setTimeout(() => document.getElementById('servicesSection').scrollIntoView({
                behavior: 'smooth'
            }), 80);
        }

        function orderSvc(nm) {
            toast('📋 Permintaan layanan "' + nm + '" diterima! Tim kami segera menghubungi Anda.');
        }

        function setMobNav(id) {
            document.querySelectorAll('.mob-nb').forEach(b => b.classList.remove('on'));
            const el = document.getElementById('mn-' + id);
            if (el) el.classList.add('on');
        }

        function toggleMobSearch() {
            const s = document.getElementById('mobSrch');
            s.classList.toggle('on');
            if (s.classList.contains('on')) document.getElementById('mobSearch').focus();
        }

        /* ── TOAST ─────────────────────────────────── */
        function toast(msg, type = 'ok') {
            const c = document.getElementById('tw');
            const t = document.createElement('div');
            t.className = 'toast' + (type === 'err' ? ' err' : '');
            t.innerHTML = `<i class="ti ti-${type==='err'?'alert-circle':'circle-check'}" style="color:${type==='err'?'var(--red)':'var(--green)'}"></i>${msg}`;
            c.appendChild(t);
            setTimeout(() => {
                t.style.animation = 'tOut .3s ease forwards';
                setTimeout(() => t.remove(), 300);
            }, 300);
        }


        // CART 
        function updateBadges(qty) {
            // const n = cart.reduce((s, x) => s + x.qty, 0);
            document.getElementById('cBadge').textContent = qty;
            const m = document.getElementById('cBadgeMob');
            if (m) m.textContent = qty;
        }

        async function loadCart() {
            const res = await fetch("{{ route('cart.get') }}");
            const data = await res.json();
            // console.log(data);
            updateBadges(data.total_qty);
        }

        function openCart() {
            document.getElementById('ov').classList.add('on');
            document.getElementById('drw').classList.add('on');
            renderDrawer();
            document.body.style.overflow = 'hidden';
        }



        function closeCart() {
            document.getElementById('ov').classList.remove('on');
            document.getElementById('drw').classList.remove('on');
            document.body.style.overflow = '';
        }

        async function getCart() {
            const res = await fetch("{{ route('cart.get') }}");
            return await res.json();
        }
        async function renderDrawer() {
            const body = document.getElementById('drwBody');
            const ft = document.getElementById('drwFt');

            try {
                const data = await getCart();
                const cart = Object.values(data.cart); // dari session (object → array)

                document.getElementById('drwCount').textContent = data.total_qty;

                if (!cart.length) {
                    body.innerHTML = `
                <div class="drw-empty">
                    <i class="ti ti-shopping-cart-off"></i><br>
                    Keranjang masih kosong<br>
                    <small style="font-size:.78rem">Tambahkan produk untuk mulai belanja</small>
                </div>`;
                    ft.style.display = 'none';
                    return;
                }

                body.innerHTML = cart.map(x => `
            <div class="ci">
                <div class="ci-img">
                    ${x.image 
                        ? `<img src="{{ asset('assets/images/products') }}/${x.image}" style="width:50px">`
                        : '📦'
                    }
                </div>
                <div class="ci-inf">
                    <div class="ci-nm">${x.name}</div>
                    <div class="ci-pr">Rp ${(x.price * x.qty).toLocaleString('id-ID')}</div>
                    <div class="ci-qty">
                        <button class="qb" onclick="chQty(${x.id},-1)">-</button>
                        <span class="qn">${x.qty}</span>
                        <button class="qb" onclick="chQty(${x.id},1)">+</button>
                    </div>
                </div>
                <button class="ci-rm" onclick="rmItem(${x.id})">🗑️</button>
            </div>
        `).join('');

                const sub = cart.reduce((s, x) => s + x.price * x.qty, 0);
                const tax = Math.round(sub * 0.11);
                const tot = sub + tax;

                document.getElementById('drwSub').textContent = 'Rp ' + sub.toLocaleString('id-ID');
                document.getElementById('drwTax').textContent = 'Rp ' + tax.toLocaleString('id-ID');
                document.getElementById('drwTot').textContent = 'Rp ' + tot.toLocaleString('id-ID');

                ft.style.display = 'block';

            } catch (err) {
                console.error("Gagal render drawer:", err);
            }
        }

        async function chQty(id, delta) {
            await fetch("{{ route('cart.update') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    product_id: id,
                    qty: delta
                })
            });

            renderDrawer(); // reload dari server
        }

        async function rmItem(id) {
            await fetch("{{ route('cart.update') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    product_id: id,
                    qty: -999 // hack: hapus
                })
            });
            loadCart()
            renderDrawer();
        }

        loadCart()
        // END
    </script>

    @stack('scripts')
</body>

</html>