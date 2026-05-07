<!-- PRODUK PILIHAN dengan TABS -->
<div class="sec" id="productsSection">
    <div class="sec-inner">
        <div class="sec-header">
            <div class="sec-title">Produk Pilihan</div>

        </div>
        <div class="prod-tabs" id="prodTabs">
            <button class="prod-tab active" onclick="setProdTab(this,'all')">Semua</button>
            <button class="prod-tab" onclick="setProdTab(this,'laptop')">Laptop & PC</button>
            <button class="prod-tab" onclick="setProdTab(this,'networking')">Networking</button>
            <button class="prod-tab" onclick="setProdTab(this,'storage')">Storage</button>
            <button class="prod-tab" onclick="setProdTab(this,'aksesoris')">Aksesoris</button>
            <button class="prod-tab" onclick="setProdTab(this,'monitor')">Monitor</button>
            <button class="prod-tab" onclick="setProdTab(this,'server')">Server</button>
            <button class="prod-tab" onclick="setProdTab(this,'security')">Security</button>
        </div>
        <div class="prod-grid" id="prodGrid"></div>
        <div style="text-align:center;margin-top:1.5rem;display: none;">
            <button class="btn-ed-outline" onclick=""><i class="ti ti-grid-dots"></i>Lihat Semua Produk</button>
        </div>
    </div>
</div>

@include("home.partials.modal-detail-product")
@push("scripts")
<script>
    let PRODUCTS_IT = [];
    // let currentCat = 'all';

    /* ── FETCH DATA ───────────────────────── */
    async function loadProducts(cat = 'all', search = '') {
        try {
            let url = `{{ route('home.product-json') }}?`;

            if (cat && cat !== 'all') url += `category=${cat}&`;
            if (search) url += `search=${search}`;

            const res = await fetch(url);
            const data = await res.json();

            PRODUCTS_IT = data.map(p => ({
                id: p.id,
                nm: p.name,
                sp: p.spesification,
                pr: parseInt(p.price),
                cat: p.category,
                ic: getIconByCategory(p.category),
                badge: p.badge,
                rating: p.rating || 0,
                sold: p.sold || 0,
                img: p.images
            }));

            renderProds(PRODUCTS_IT);

        } catch (err) {
            console.error("Gagal load produk:", err);
        }
    }

    /* ── ICON BY CATEGORY ─────────────────── */
    function getIconByCategory(cat) {
        switch (cat) {
            case 'laptop':
                return '💻';
            case 'networking':
                return '📡';
            case 'storage':
                return '💾';
            case 'aksesoris':
                return '🖱️';
            case 'monitor':
                return '🖥️';
            case 'server':
                return '🗄️';
            case 'security':
                return '🔐';
            default:
                return '📦';
        }
    }

    /* ── RENDER ───────────────────────────── */
    function renderProds(list) {
        const g = document.getElementById('prodGrid');

        if (!list.length) {
            g.innerHTML = '<p style="color:var(--gray-b);grid-column:1/-1;padding:1rem">Tidak ada produk ditemukan.</p>';
            return;
        }

        g.innerHTML = list.map(p => `
        <div class="prod-card" >
            <div class="prod-img-wrap">
                ${p.badge ? `<span class="badge badge-${p.badge}">
                    ${p.badge==='hot'?'🔥 HOT':p.badge==='new'?'✨ NEW':p.badge==='sale'?'💸 SALE':p.badge.toUpperCase()}
                </span>` : ''}

               ${p.img 
                    ? `<img src="{{ asset('assets/images/products') }}/${p.img}" 
                        style="width: 100%; height: 100px; object-fit: contain;">`
                    : p.ic
                }
            </div>

            <div class="prod-body">
                <div class="prod-name">${p.nm}</div>
                <div class="prod-spec">${p.sp ?? ''}</div>

                <div class="prod-rating">
                    <span class="stars">
                        ${'★'.repeat(Math.floor(p.rating))}${'☆'.repeat(5-Math.floor(p.rating))}
                    </span>
                    <span>${p.rating} (${p.sold} terjual)</span>
                </div>

                <div class="prod-price">Rp ${p.pr.toLocaleString('id-ID')}</div>

                <div class="prod-footer">
                    <div class="status">
                        <i class="ti ti-circle-check" style="font-size:12px"></i> Stok Tersedia
                    </div>

                    <a class="btn-view" style="text-decoration:none" onclick="event.stopPropagation();showDetail(${p.id})" >
                        <i class="ti ti-eye"></i> Lihat
                    </a>
                    <button class="btn-add" id="ba${p.id}" onclick="event.stopPropagation();addById(${p.id})">
                        <i class="ti ti-shopping-cart"></i> Beli
                    </button>
                </div>
            </div>
        </div>
        `).join('');
    }

    /* ── TAB FILTER ───────────────────────── */
    function setProdTab(el, cat) {
        document.querySelectorAll('.prod-tab').forEach(t => t.classList.remove('active'));
        el.classList.add('active');

        currentCat = cat;
        loadProducts(cat);
    }



    /* ── INIT ─────────────────────────────── */
    document.addEventListener("DOMContentLoaded", function() {
        loadProducts();
    });

    function changeCategory(cat, el = null) {
        currentCat = cat;

        // load data
        loadProducts(cat);

        // sync tab
        document.querySelectorAll('.prod-tab').forEach(t => {
            const tabCat = t.dataset.cat || (t.getAttribute('onclick') || '');
            const match = tabCat.includes(cat);
            t.classList.toggle('active', match);
        });

        // sync shortcut (optional)
        document.querySelectorAll('.cat-sc').forEach(c => c.classList.remove('active'));
        if (el) el.classList.add('active');

        // sync shortcut (optional)
        document.querySelectorAll('.cat-nav-item').forEach(c => c.classList.remove('active'));
        if (el) el.classList.add('active');

        // scroll ke produk
        scrollToProducts();
    }

    /* ── CART ──────────────────────────────────── */
    // function addById(id) {
    //     const p = PRODUCTS.find(x => x.id === id);
    //     if (!p) return;
    //     const ex = cart.find(x => x.id === id);
    //     if (ex) ex.qty++;
    //     else cart.push({
    //         ...p,
    //         qty: 1
    //     });
    //     updateBadges();
    //     animateAddBtn(id);
    //     toast('✅ ' + p.nm + ' ditambahkan ke keranjang!');
    // }

    async function addById(id) {
        const p = PRODUCTS_IT.find(x => x.id === id);
        if (!p) return;

        try {
            const res = await fetch("{{ route('cart.add') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    product_id: id,
                    qty: 1
                })
            });

            const result = await res.json();

            if (result.success) {
                updateBadges(result.total_qty); // ambil dari backend
                animateAddBtn(id);
                toast('✅ ' + p.nm + ' ditambahkan ke keranjang!');
            }

        } catch (err) {
            console.error("Gagal tambah ke cart:", err);
        }
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


    // function renderDrawer() {
    //     const body = document.getElementById('drwBody');
    //     const ft = document.getElementById('drwFt');
    //     document.getElementById('drwCount').textContent = cart.reduce((s, x) => s + x.qty, 0);
    //     if (!cart.length) {
    //         body.innerHTML = '<div class="drw-empty"><i class="ti ti-shopping-cart-off"></i><br>Keranjang masih kosong<br><small style="font-size:.78rem">Tambahkan produk untuk mulai belanja</small></div>';
    //         ft.style.display = 'none';
    //         return;
    //     }
    //     body.innerHTML = cart.map(x => `
    //         <div class="ci">
    //         <div class="ci-img">${x.ic}</div>
    //         <div class="ci-inf">
    //             <div class="ci-nm">${x.nm}</div>
    //             <div class="ci-pr">Rp ${(x.pr*x.qty).toLocaleString('id-ID')}</div>
    //             <div class="ci-qty">
    //             <button class="qb" onclick="chQty(${x.id},-1)"><i class="ti ti-minus" style="font-size:.7rem"></i></button>
    //             <span class="qn">${x.qty}</span>
    //             <button class="qb" onclick="chQty(${x.id},1)"><i class="ti ti-plus" style="font-size:.7rem"></i></button>
    //             </div>
    //         </div>
    //         <button class="ci-rm" onclick="rmItem(${x.id})"><i class="ti ti-trash"></i></button>
    //         </div>`).join('');
    //     const sub = cart.reduce((s, x) => s + x.pr * x.qty, 0);
    //     const tax = Math.round(sub * .11);
    //     const tot = sub + 25000 + tax;
    //     document.getElementById('drwSub').textContent = 'Rp ' + sub.toLocaleString('id-ID');
    //     document.getElementById('drwTax').textContent = 'Rp ' + tax.toLocaleString('id-ID');
    //     document.getElementById('drwTot').textContent = 'Rp ' + tot.toLocaleString('id-ID');
    //     ft.style.display = 'block';
    // }

    // function chQty(id, d) {
    //     const item = cart.find(x => x.id === id);
    //     if (!item) return;
    //     item.qty += d;
    //     if (item.qty <= 0) cart = cart.filter(x => x.id !== id);
    //     updateBadges();
    //     renderDrawer();
    // }



    // function rmItem(id) {
    //     cart = cart.filter(x => x.id !== id);
    //     updateBadges();
    //     renderDrawer();
    // }

    function showDetail(id) {
        $("#modal-product").modal("show")
        $.ajax({
            url: "{{ route('home.product-json-detail') }}",
            method: "GET",
            data: {
                id: id
            },
            success: function(res) {
                var product = res.product;
                var images = res.images;
                // =========================
                // 🔥 HANDLE IMAGES
                // =========================
                let images_list = '';
                if (images && images.length > 0) {
                    $.each(images, function(index, item) {
                        $("#main-product-img").attr("src", `{{ asset('assets/images/products/') }}/${images[0].name}`)
                        images_list += `
                        <div class="col-4">
                            <div class="img-thumbnail-wrapper cursor-pointer ${index === 0 ? 'active' : ''}" 
                                onclick="changeImage(this, '/assets/images/products/${item.name}')">
                                <img src="/assets/images/products/${item.name}" class="img-fluid rounded">
                            </div>
                        </div>`;
                    });
                    $("#product_images_slider").html(images_list);
                } else {
                    $("#main-product-img").attr("src", `{{ asset('assets/images/products/') }}/no-image-available.png`)
                    $("#product_images_slider").html(`<div class="text-muted text-center"></div>`);
                }

                // =========================
                // 🔥 HANDLE PRODUCT
                // =========================
                if (product) {
                    let item = product;
                    // 🔥 SPEC (SUDAH ARRAY DARI BACKEND)
                    let spec = item.spesification || [];
                    let spec_html = '';
                    spec.forEach(s => {
                        spec_html += `<li class="d-flex align-items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon text-success" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M5 12l5 5l10 -10" />
                                </svg>
                                ${s}
                            </li>`;
                    });
                    $("#product-spec").html(spec_html);
                    let discount = item.discount ?? 0;
                    let price = item.price || 0;
                    let finalPrice = price;
                    if (discount > 0) {
                        finalPrice = price - (price * discount / 100);
                    }
                    // 🔥 FORMAT RUPIAH
                    function formatRupiah(angka) {
                        return new Intl.NumberFormat('id-ID').format(angka);
                    }
                    $("#product-title").html(`<small class="text-muted text-uppercase">${item.category}</small><h1 class="h1 fw-bold mt-1">${item.name}</h1>`);
                    $("#product-price").html(`Rp ${formatRupiah(price)}`);
                    $("#product-deskripsi").html(item.description);
                    if (discount > 0) {
                        $("#product-discount").html(`-${discount}%`);
                        $("#product-price-discount").html(`Rp ${formatRupiah(finalPrice)}`);
                    } else {
                        $("#product-discount").html("");
                        $("#product-price-discount").html(`Rp ${formatRupiah(price)}`);
                    }
                } else {
                    $("#product-title").html(`<h1>Produk tidak ditemukan</h1>`);
                    $("#product-price").html("Rp 0");
                    $("#product-deskripsi").html("-");
                    $("#product-discount").html("");
                    $("#product-price-discount").html("");
                    $("#product-spec").html("");
                }
            }
        })
    }

    // loadCart()
</script>
@endpush