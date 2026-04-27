<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechNova.id — Solusi IT Terlengkap untuk Bisnis & Personal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.44.0/tabler-icons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }} ">
</head>

<body>

    <!-- LOADING -->
    <div id="ldg" style="display:none;position:fixed;inset:0;background:rgba(255,255,255,.88);z-index:9999;align-items:center;justify-content:center">
        <div style="width:44px;height:44px;border:3px solid var(--blue-l);border-top-color:var(--blue);border-radius:50%;animation:spin .7s linear infinite"></div>
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
        <span>Program Special Studi — <strong>Diskon s/d 40%</strong> untuk Laptop & Aksesoris IT. <a onclick="scrollToProducts()">Belanja Sekarang →</a></span>
        <button class="promo-bar-close" onclick="document.getElementById('promoBar').remove()">×</button>
    </div>

    <!-- UTILITY BAR -->
    <div class="utility-bar">
        <a><i class="ti ti-map-pin"></i> Toko Kami</a>
        <span class="sep">|</span>
        <a><i class="ti ti-headset"></i> 0800-1234-5678</a>
        <span class="sep">|</span>
        <a><i class="ti ti-truck"></i> Lacak Pesanan</a>
        <span class="sep">|</span>
        <a><i class="ti ti-user"></i> Masuk / Daftar</a>
        <span class="sep">|</span>
        <a><i class="ti ti-help-circle"></i> Dukungan</a>
    </div>

    <!-- MAIN NAVBAR -->
    <nav class="main-nav">
        <div class="nav-inner">
            <button class="hmbg" onclick="toggleMobSearch()"><i class="ti ti-menu-2"></i></button>
            <a class="nav-logo" onclick="goHome()"><i class="ti ti-bolt"></i>TechNova<span class="dot">.</span>id</a>
            <div class="nav-search">
                <i class="ti ti-search si"></i>
                <input type="text" id="dskSearch" placeholder="Cari laptop, router, SSD, dan lainnya..." oninput="doSearch()">
            </div>
            <div class="nav-actions">
                <button class="nav-act-btn" onclick="goHome()"><i class="ti ti-home"></i><span>Beranda</span></button>
                <button class="nav-act-btn"><i class="ti ti-heart"></i><span>Wishlist</span></button>
                <button class="nav-act-btn"><i class="ti ti-user-circle"></i><span>Akun</span></button>
                <button class="nav-act-btn" onclick="openCart()">
                    <i class="ti ti-shopping-cart"></i>
                    <span class="cart-badge" id="cBadge">0</span>
                    <span>Keranjang</span>
                </button>
            </div>
        </div>
    </nav>

    <!-- MOBILE SEARCH -->
    <div class="mob-srch" id="mobSrch">
        <input type="text" id="mobSearch" placeholder="Cari produk IT..." oninput="doSearch()">
    </div>

    <!-- CATEGORY NAV (desktop) -->
    <nav class="cat-nav">
        <div class="cat-nav-inner">
            <div class="cat-nav-item active" onclick="setCatActive(this,'all')"><i class="ti ti-layout-grid"></i>Semua Produk</div>
            <div class="cat-nav-item" onclick="setCatActive(this,'laptop')"><i class="ti ti-device-laptop"></i>Laptop & PC</div>
            <div class="cat-nav-item" onclick="setCatActive(this,'networking')"><i class="ti ti-router"></i>Networking</div>
            <div class="cat-nav-item" onclick="setCatActive(this,'storage')"><i class="ti ti-database"></i>Storage</div>
            <div class="cat-nav-item" onclick="setCatActive(this,'aksesoris')"><i class="ti ti-mouse"></i>Aksesoris</div>
            <div class="cat-nav-item" onclick="setCatActive(this,'monitor')"><i class="ti ti-device-desktop"></i>Monitor</div>
            <div class="cat-nav-item" onclick="setCatActive(this,'server')"><i class="ti ti-server"></i>Server & NAS</div>
            <div class="cat-nav-item" onclick="setCatActive(this,'security')"><i class="ti ti-shield-lock"></i>Security</div>
            <div class="cat-nav-item" onclick="scrollToServices()"><i class="ti ti-tools"></i>Layanan Jasa</div>
        </div>
    </nav>

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
            <button class="mob-nb" id="mn-acc"><i class="ti ti-user-circle"></i>Akun</button>
        </div>
    </div>

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
            },
            {
                id: 2,
                nm: 'HP ProBook 450 G9',
                sp: 'Intel Core i5-1235U, 8GB DDR4, 256GB SSD, 15.6" FHD',
                pr: 9750000,
                cat: 'laptop',
                ic: '💻',
                rating: 4.6,
                sold: 218
            },
            {
                id: 3,
                nm: 'Dell Inspiron 15 3000',
                sp: 'AMD Ryzen 5 5625U, 8GB, 512GB SSD, 15.6" FHD',
                pr: 8200000,
                cat: 'laptop',
                ic: '💻',
                badge: 'sale',
                op: 9500000,
                rating: 4.5,
                sold: 189
            },
            {
                id: 4,
                nm: 'ASUS VivoBook Pro 16X OLED',
                sp: 'Intel Core i7-13700H, 16GB, 1TB NVMe, 16" 3.2K OLED',
                pr: 14900000,
                cat: 'laptop',
                ic: '💻',
                badge: 'new',
                rating: 4.9,
                sold: 96
            },
            {
                id: 5,
                nm: 'Cisco Router RV340',
                sp: 'Dual WAN Gigabit, 4-Port LAN, SSL VPN, Firewall',
                pr: 3200000,
                cat: 'networking',
                ic: '📡',
                rating: 4.7,
                sold: 134
            },
            {
                id: 6,
                nm: 'Ubiquiti UniFi AP AC Pro',
                sp: '802.11ac Wave 2, Dual-Band 5GHz/2.4GHz, PoE+',
                pr: 1850000,
                cat: 'networking',
                ic: '📡',
                badge: 'hot',
                rating: 4.8,
                sold: 412
            },
            {
                id: 7,
                nm: 'TP-Link TL-SG1024 Switch',
                sp: '24-Port Gigabit Desktop Switch, Unmanaged, Plug & Play',
                pr: 1200000,
                cat: 'networking',
                ic: '🔌',
                rating: 4.6,
                sold: 267
            },
            {
                id: 8,
                nm: 'MikroTik hEX S RB760iGS',
                sp: 'Gigabit Router, 1x SFP, RouterOS L4, USB Port',
                pr: 890000,
                cat: 'networking',
                ic: '📡',
                badge: 'new',
                rating: 4.7,
                sold: 178
            },
            {
                id: 9,
                nm: 'WD Blue 4TB HDD Desktop',
                sp: '3.5", 5400 RPM, SATA III 6Gb/s, 256MB Cache',
                pr: 1450000,
                cat: 'storage',
                ic: '💾',
                rating: 4.5,
                sold: 321
            },
            {
                id: 10,
                nm: 'Samsung 970 EVO Plus 1TB',
                sp: 'M.2 NVMe PCIe, 3500MB/s Read, 3300MB/s Write',
                pr: 1750000,
                cat: 'storage',
                ic: '💿',
                badge: 'hot',
                rating: 4.9,
                sold: 509
            },
            {
                id: 11,
                nm: 'Seagate IronWolf NAS 8TB',
                sp: 'NAS-Optimized, 7200 RPM, AgileArray Technology',
                pr: 2900000,
                cat: 'storage',
                ic: '💾',
                rating: 4.7,
                sold: 145
            },
            {
                id: 12,
                nm: 'Kingston A400 SSD 512GB',
                sp: 'SATA III 2.5", 500MB/s Read, 320MB/s Write',
                pr: 680000,
                cat: 'storage',
                ic: '💿',
                badge: 'sale',
                op: 850000,
                rating: 4.6,
                sold: 672
            },
            {
                id: 13,
                nm: 'Logitech MX Master 3S',
                sp: '8000 DPI, Bluetooth + USB-C, Multi-Device, Quiet Click',
                pr: 1350000,
                cat: 'aksesoris',
                ic: '🖱️',
                rating: 4.8,
                sold: 289
            },
            {
                id: 14,
                nm: 'Corsair K70 RGB MK.2',
                sp: 'Cherry MX Red, Per-Key RGB Backlit, Brushed Aluminum',
                pr: 1900000,
                cat: 'aksesoris',
                ic: '⌨️',
                badge: 'hot',
                rating: 4.7,
                sold: 198
            },
            {
                id: 15,
                nm: 'Logitech C920 HD Pro Webcam',
                sp: '1080p/30fps, 720p/60fps, Autofocus, Dual Mic Stereo',
                pr: 985000,
                cat: 'aksesoris',
                ic: '📷',
                rating: 4.7,
                sold: 354
            },
            {
                id: 16,
                nm: 'Baseus 10-in-1 USB-C Hub',
                sp: '4K HDMI, 3x USB 3.0, SD/TF, 100W PD, RJ45 Gigabit',
                pr: 550000,
                cat: 'aksesoris',
                ic: '🔌',
                badge: 'new',
                rating: 4.6,
                sold: 423
            },
            {
                id: 17,
                nm: 'LG 27UK850-W 4K Monitor',
                sp: '27" UHD IPS, 60Hz, USB-C 60W, HDR400, AMD FreeSync',
                pr: 5800000,
                cat: 'monitor',
                ic: '🖥️',
                rating: 4.8,
                sold: 87
            },
            {
                id: 18,
                nm: 'ASUS ProArt PA329CRV 32"',
                sp: '4K OLED, 120Hz, USB-C 90W, Delta E<1, Pantone Validated',
                pr: 12500000,
                cat: 'monitor',
                ic: '🖥️',
                badge: 'new',
                rating: 4.9,
                sold: 34
            },
            {
                id: 19,
                nm: 'BenQ GW2480 24" FHD IPS',
                sp: '1920x1080, 75Hz, IPS, Eye-care, HDMI+VGA+DisplayPort',
                pr: 2100000,
                cat: 'monitor',
                ic: '🖥️',
                rating: 4.6,
                sold: 213
            },
            {
                id: 20,
                nm: 'Dell PowerEdge T40 Server',
                sp: 'Intel Xeon E-2224, 8GB ECC DDR4, 1TB SATA, Windows Server',
                pr: 16500000,
                cat: 'server',
                ic: '🗄️',
                rating: 4.7,
                sold: 28
            },
            {
                id: 21,
                nm: 'Synology NAS DS923+',
                sp: '4-Bay NAS, AMD Ryzen R1600, 4GB ECC DDR4, 2x M.2 NVMe',
                pr: 8900000,
                cat: 'server',
                ic: '🗄️',
                badge: 'hot',
                rating: 4.9,
                sold: 67
            },
            {
                id: 22,
                nm: 'APC Smart-UPS 1500VA LCD',
                sp: '1500VA/1000W, 230V, 8 Outlet, USB, LCD Display, AVR',
                pr: 3200000,
                cat: 'server',
                ic: '🔋',
                rating: 4.8,
                sold: 142
            },
            {
                id: 23,
                nm: 'Hikvision DS-2CD1143G2-I',
                sp: '4MP AcuSense EXIR, H.265+, WDR, IP67, PoE, 2.8mm',
                pr: 750000,
                cat: 'security',
                ic: '📷',
                rating: 4.6,
                sold: 287
            },
            {
                id: 24,
                nm: 'ZKTeco K40 Fingerprint',
                sp: '1000 Users, 100.000 Records, TCP/IP, USB Flash Drive, Wiegand',
                pr: 1200000,
                cat: 'security',
                ic: '🔐',
                badge: 'new',
                rating: 4.7,
                sold: 156
            },
        ];

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
        let currentCat = 'all';
        let coStep = 1;
        let slideIdx = 0;
        let slideTimer;

        /* ── SLIDER ────────────────────────────────── */
        function initSlider() {
            slideTimer = setInterval(() => slideNav(1), 5000);
        }

        function slideNav(d) {
            const slides = document.querySelectorAll('.slide');
            const dots = document.querySelectorAll('.s-dot');
            slides[slideIdx].classList.remove('active');
            dots[slideIdx].classList.remove('active');
            slideIdx = (slideIdx + d + slides.length) % slides.length;
            slides[slideIdx].classList.add('active');
            dots[slideIdx].classList.add('active');
            clearInterval(slideTimer);
            slideTimer = setInterval(() => slideNav(1), 5500);
        }

        function goSlide(i) {
            const slides = document.querySelectorAll('.slide');
            const dots = document.querySelectorAll('.s-dot');
            slides[slideIdx].classList.remove('active');
            dots[slideIdx].classList.remove('active');
            slideIdx = i;
            slides[slideIdx].classList.add('active');
            dots[slideIdx].classList.add('active');
        }



        /* ── CART ──────────────────────────────────── */
        function addById(id) {
            const p = PRODUCTS.find(x => x.id === id);
            if (!p) return;
            const ex = cart.find(x => x.id === id);
            if (ex) ex.qty++;
            else cart.push({
                ...p,
                qty: 1
            });
            updateBadges();
            animateAddBtn(id);
            toast('✅ ' + p.nm + ' ditambahkan ke keranjang!');
        }

        function animateAddBtn(id) {
            const b = document.getElementById('ba' + id);
            if (!b) return;
            b.classList.add('added');
            b.innerHTML = '<i class="ti ti-check"></i> Ditambahkan';
            setTimeout(() => {
                b.classList.remove('added');
                b.innerHTML = '<i class="ti ti-cart-plus"></i> Beli';
            }, 1400);
        }

        function updateBadges() {
            const n = cart.reduce((s, x) => s + x.qty, 0);
            document.getElementById('cBadge').textContent = n;
            const m = document.getElementById('cBadgeMob');
            if (m) m.textContent = n;
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

        function renderDrawer() {
            const body = document.getElementById('drwBody');
            const ft = document.getElementById('drwFt');
            document.getElementById('drwCount').textContent = cart.reduce((s, x) => s + x.qty, 0);
            if (!cart.length) {
                body.innerHTML = '<div class="drw-empty"><i class="ti ti-shopping-cart-off"></i><br>Keranjang masih kosong<br><small style="font-size:.78rem">Tambahkan produk untuk mulai belanja</small></div>';
                ft.style.display = 'none';
                return;
            }
            body.innerHTML = cart.map(x => `
    <div class="ci">
      <div class="ci-img">${x.ic}</div>
      <div class="ci-inf">
        <div class="ci-nm">${x.nm}</div>
        <div class="ci-pr">Rp ${(x.pr*x.qty).toLocaleString('id-ID')}</div>
        <div class="ci-qty">
          <button class="qb" onclick="chQty(${x.id},-1)"><i class="ti ti-minus" style="font-size:.7rem"></i></button>
          <span class="qn">${x.qty}</span>
          <button class="qb" onclick="chQty(${x.id},1)"><i class="ti ti-plus" style="font-size:.7rem"></i></button>
        </div>
      </div>
      <button class="ci-rm" onclick="rmItem(${x.id})"><i class="ti ti-trash"></i></button>
    </div>`).join('');
            const sub = cart.reduce((s, x) => s + x.pr * x.qty, 0);
            const tax = Math.round(sub * .11);
            const tot = sub + 25000 + tax;
            document.getElementById('drwSub').textContent = 'Rp ' + sub.toLocaleString('id-ID');
            document.getElementById('drwTax').textContent = 'Rp ' + tax.toLocaleString('id-ID');
            document.getElementById('drwTot').textContent = 'Rp ' + tot.toLocaleString('id-ID');
            ft.style.display = 'block';
        }

        function chQty(id, d) {
            const item = cart.find(x => x.id === id);
            if (!item) return;
            item.qty += d;
            if (item.qty <= 0) cart = cart.filter(x => x.id !== id);
            updateBadges();
            renderDrawer();
        }

        function rmItem(id) {
            cart = cart.filter(x => x.id !== id);
            updateBadges();
            renderDrawer();
        }

        /* ── CHECKOUT ──────────────────────────────── */
        function goCheckout() {
            if (!cart.length) {
                toast('Keranjang kosong!', 'err');
                return;
            }
            closeCart();
            showPg('pgCheckout');
            coStep = 1;
            renderCoOrder();
            showCoStep(1);
            window.scrollTo(0, 0);
        }

        function renderCoOrder() {
            document.getElementById('coOrderItems').innerHTML = cart.map(x => `
    <div class="oi-row">
      <div class="oi-img">${x.ic}</div>
      <div class="oi-nm">${x.nm} <span style="color:var(--gray-b)">×${x.qty}</span></div>
      <div class="oi-pr">Rp ${(x.pr*x.qty).toLocaleString('id-ID')}</div>
    </div>`).join('');
            const sub = cart.reduce((s, x) => s + x.pr * x.qty, 0);
            const tax = Math.round(sub * .11);
            document.getElementById('coSub').textContent = 'Rp ' + sub.toLocaleString('id-ID');
            document.getElementById('coTax').textContent = 'Rp ' + tax.toLocaleString('id-ID');
            document.getElementById('coTot').textContent = 'Rp ' + (sub + 25000 + tax).toLocaleString('id-ID');
        }

        function showCoStep(n) {
            coStep = n;
            [1, 2, 3].forEach(i => document.getElementById('coStep' + i).style.display = i === n ? 'block' : 'none');
            updateCoProgress(n);
        }

        function updateCoProgress(n) {
            [1, 2, 3].forEach(i => {
                const dot = document.getElementById('sdot' + i);
                const lbl = document.getElementById('slbl' + i);
                if (i < n) {
                    dot.className = 'sp-dot done';
                    dot.innerHTML = '<i class="ti ti-check" style="font-size:.7rem"></i>';
                    lbl.className = 'sp-label active';
                } else if (i === n) {
                    dot.className = 'sp-dot active';
                    dot.textContent = i;
                    lbl.className = 'sp-label active';
                } else {
                    dot.className = 'sp-dot';
                    dot.textContent = i;
                    lbl.className = 'sp-label';
                }
                if (i < 3) {
                    const line = document.getElementById('sline' + i);
                    line.className = 'sp-line' + (i < n ? ' done' : '');
                }
            });
        }

        function coNext() {
            if (coStep === 1 && !validateShipping()) return;
            if (coStep === 2) {
                buildReview();
            }
            showCoStep(coStep + 1);
            window.scrollTo(0, 0);
        }

        function coBack(to) {
            showCoStep(to);
            window.scrollTo(0, 0);
        }

        function validateShipping() {
            const flds = [{
                id: 'fn',
                l: 'Nama Lengkap'
            }, {
                id: 'fp',
                l: 'No. Telepon'
            }, {
                id: 'fe',
                l: 'Email'
            }, {
                id: 'fa',
                l: 'Alamat'
            }, {
                id: 'fc_city',
                l: 'Kota'
            }, {
                id: 'fz',
                l: 'Kode Pos'
            }];
            for (const f of flds) {
                const el = document.getElementById(f.id);
                if (!el || !el.value.trim()) {
                    toast('⚠️ Harap isi ' + f.l, 'err');
                    el.focus();
                    el.style.borderColor = 'var(--red)';
                    setTimeout(() => el.style.borderColor = '', 2000);
                    return false;
                }
            }
            return true;
        }

        function selPay(el) {
            document.querySelectorAll('.pay-opt').forEach(o => o.classList.remove('sel'));
            el.classList.add('sel');
            document.getElementById('ccFields').style.display = el.querySelector('input').value === 'cc' ? 'block' : 'none';
        }

        function buildReview() {
            const pay = document.querySelector('.pay-opt.sel .pay-nm')?.textContent || '-';
            document.getElementById('reviewData').innerHTML = `
    <div style="display:grid;grid-template-columns:auto 1fr;gap:.2rem .9rem">
      <span style="color:var(--gray-b)">Penerima</span><strong>${document.getElementById('fn').value}</strong>
      <span style="color:var(--gray-b)">Telepon</span><span>${document.getElementById('fp').value}</span>
      <span style="color:var(--gray-b)">Email</span><span>${document.getElementById('fe').value}</span>
      <span style="color:var(--gray-b)">Alamat</span><span>${document.getElementById('fa').value}, ${document.getElementById('fc_city').value} ${document.getElementById('fz').value}</span>
      <span style="color:var(--gray-b)">Pengiriman</span><span>${document.getElementById('fship').value}</span>
      <span style="color:var(--gray-b)">Pembayaran</span><strong style="color:var(--blue)">${pay}</strong>
    </div>`;
            document.getElementById('reviewItems').innerHTML = cart.map(x => `
    <div class="oi-row">
      <div class="oi-img">${x.ic}</div>
      <div class="oi-nm">${x.nm} ×${x.qty}</div>
      <div class="oi-pr">Rp ${(x.pr*x.qty).toLocaleString('id-ID')}</div>
    </div>`).join('');
        }

        function placeOrder() {
            const oid = '#TN-' + Math.floor(100000 + Math.random() * 900000);
            document.getElementById('succOid').textContent = oid;
            document.getElementById('succDetail').innerHTML = `
    <div style="display:grid;grid-template-columns:auto 1fr;gap:.15rem .9rem">
      <span style="color:var(--gray-b)">Penerima</span><strong>${document.getElementById('fn').value}</strong>
      <span style="color:var(--gray-b)">Alamat</span><span>${document.getElementById('fa').value}, ${document.getElementById('fc_city').value}</span>
      <span style="color:var(--gray-b)">Pengiriman</span><span>${document.getElementById('fship').value}</span>
      <span style="color:var(--gray-b)">Total</span><strong style="color:var(--blue)">${document.getElementById('coTot').textContent}</strong>
    </div>`;
            const ld = document.getElementById('ldg');
            ld.style.display = 'flex';
            setTimeout(() => {
                ld.style.display = 'none';
                cart = [];
                updateBadges();
                showPg('pgSuccess');
                window.scrollTo(0, 0);
            }, 2000);
        }

        /* ── NAVIGATION ────────────────────────────── */
        function showPg(id) {
            document.querySelectorAll('.pg').forEach(p => p.classList.remove('on'));
            document.getElementById(id).classList.add('on');
        }

        function goHome() {
            showPg('pgHome');
            setMobNav('home');
            window.scrollTo(0, 0);
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
            }, 3200);
        }

        /* ── INIT ──────────────────────────────────── */

        initSlider();
    </script>

    @stack('scripts')
</body>

</html>