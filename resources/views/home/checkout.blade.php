@extends("layouts.main")

@section('content')
@include("layouts.carts")

<!-- =============================================================== -->
<!-- PAGE: CHECKOUT -->
<!-- =============================================================== -->
<div class="pg on" id="pgCheckout">
    <div style="max-width:1280px;margin:0 auto;padding:.75rem 1.5rem;border-bottom:1px solid var(--gray-e);display:flex;align-items:center;gap:.5rem;font-size:12.5px;color:var(--gray-b)">
        <span onclick="goHome()" style="cursor:pointer;color:var(--blue)"><i class="ti ti-home" style="font-size:14px"></i> Beranda</span>
        <i class="ti ti-chevron-right" style="font-size:12px"></i>
        <span style="color:var(--black);font-weight:700">Checkout</span>
    </div>

    <div class="co-wrap">
        <h2 style="font-size:1.3rem;font-weight:800;margin-bottom:1.5rem;display:flex;align-items:center;gap:.5rem"><i class="ti ti-credit-card" style="color:var(--blue)"></i>Checkout</h2>

        <!-- PROGRESS BAR -->
        <div class="step-prog" id="coProgress">
            <!-- <div class="sp">
                <div class="sp-dot active" id="sdot1">1</div>
                <div class="sp-label active" id="slbl1">Konfirmasi Pesanan</div>
            </div> -->
            <!-- <div class="sp-line" id="sline1"></div>
            <div class="sp">
                <div class="sp-dot" id="sdot2">2</div>
                <div class="sp-label" id="slbl2">Pembayaran</div>
            </div>
            <div class="sp-line" id="sline2"></div>
            <div class="sp">
                <div class="sp-dot" id="sdot3">3</div>
                <div class="sp-label" id="slbl3">Konfirmasi</div>
            </div> -->
        </div>

        <div class="co-grid">
            <!-- LEFT COL -->
            <div>
                <!-- STEP 1 -->
                <div id="coStep1">
                    <div class="co-card">
                        <div class="co-sec-title"><i class="ti ti-map-pin" style="color:var(--blue)"></i>Data Pengiriman</div>
                        <div class="form-row2">
                            <div><label class="fl">Nama Lengkap *</label><input class="fc" id="fn" value="{{ Auth::user()->name ?? '' }}" placeholder="Budi Santoso"></div>
                            <div><label class="fl">No. Telepon *</label><input class="fc" id="fp" value="{{ Auth::user()->phone ?? '' }}" placeholder="08xxxxxxxxxx" type="tel"></div>
                        </div>
                        <div class="form-row1"><label class="fl">Email *</label><input class="fc" id="fe" value="{{ Auth::user()->email ?? '' }}" placeholder="email@contoh.com" type="email"></div>
                        <div class="form-row1"><label class="fl">Alamat Lengkap *</label><textarea class="fc" id="fa" rows="2" placeholder="Jl. Contoh No. 1, RT/RW, Kelurahan...">{{ Auth::user()->address ?? '' }}</textarea></div>
                        <div class="form-row2">
                            <div><label class="fl">Provinsi *</label>
                                <select class="fc" id="fc_province">
                                    <option value="">Pilih Provinsi</option>
                                </select>
                            </div>
                            <div><label class="fl">Kota *</label>
                                <select class="fc" id="fc_city">
                                    <option value="">Pilih Kota</option>
                                </select>
                            </div>
                            <div><label class="fl">District *</label>
                                <select class="fc" id="fc_district">
                                    <option value="">Pilih District</option>
                                </select>
                            </div>
                            <div><label class="fl">Desa *</label>
                                <select class="fc" id="fc_village">
                                    <option value="">Pilih Desa</option>
                                </select>
                            </div>
                            <div>
                                <label class="fl">Kode Pos *</label><input class="fc" id="fz" placeholder="12345" type="text" maxlength="5">
                            </div>
                        </div>
                    </div>
                    <button class="btn-next" onclick="OrderProcess()">Pesan Barang
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                            <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                            <path d="M17 17h-11v-14h-2" />
                            <path d="M6 5l14 1l-1 7h-13" />
                        </svg>
                    </button>
                </div>

                <!-- STEP 2 -->
                <div id="coStep2" style="display:none">
                    <div class="co-card">
                        <div class="co-sec-title"><i class="ti ti-credit-card" style="color:var(--blue)"></i>Metode Pembayaran</div>
                        <div class="pay-opts">
                            <label class="pay-opt sel" onclick="selPay(this)">
                                <input type="radio" name="pay" value="transfer" checked>
                                <div class="pay-ico">🏦</div>
                                <div>
                                    <div class="pay-nm">Transfer Bank</div>
                                    <div class="pay-sub">BCA, Mandiri, BNI, BRI — Konfirmasi otomatis</div>
                                </div>
                            </label>
                            <label class="pay-opt" onclick="selPay(this)">
                                <input type="radio" name="pay" value="qris">
                                <div class="pay-ico">📱</div>
                                <div>
                                    <div class="pay-nm">QRIS</div>
                                    <div class="pay-sub">GoPay, OVO, Dana, ShopeePay, LinkAja, dan semua QRIS</div>
                                </div>
                            </label>
                            <label class="pay-opt" onclick="selPay(this)">
                                <input type="radio" name="pay" value="cc">
                                <div class="pay-ico">💳</div>
                                <div>
                                    <div class="pay-nm">Kartu Kredit / Debit</div>
                                    <div class="pay-sub">Visa, Mastercard, JCB — Cicilan 0% s/d 24 bulan</div>
                                </div>
                            </label>
                            <label class="pay-opt" onclick="selPay(this)">
                                <input type="radio" name="pay" value="cod">
                                <div class="pay-ico">💵</div>
                                <div>
                                    <div class="pay-nm">Bayar di Tempat (COD)</div>
                                    <div class="pay-sub">Tersedia untuk area Jabodetabek & kota besar</div>
                                </div>
                            </label>
                            <label class="pay-opt" onclick="selPay(this)">
                                <input type="radio" name="pay" value="va">
                                <div class="pay-ico">🏧</div>
                                <div>
                                    <div class="pay-nm">Virtual Account</div>
                                    <div class="pay-sub">BCA VA, Mandiri VA, BNI VA — Bayar via ATM/m-Banking</div>
                                </div>
                            </label>
                        </div>
                        <div id="ccFields" style="display:none;margin-top:1.1rem;padding-top:1rem;border-top:1px solid var(--gray-e)">
                            <div class="form-row1"><label class="fl">Nomor Kartu</label><input class="fc" placeholder="0000 0000 0000 0000" maxlength="19"></div>
                            <div class="form-row2">
                                <div><label class="fl">Tanggal Kadaluarsa</label><input class="fc" placeholder="MM/YY" maxlength="5"></div>
                                <div><label class="fl">CVV / CVC</label><input class="fc" placeholder="•••" type="password" maxlength="3"></div>
                            </div>
                            <div class="form-row1"><label class="fl">Nama di Kartu</label><input class="fc" placeholder="BUDI SANTOSO"></div>
                        </div>
                    </div>
                    <div style="display:flex;gap:.75rem">
                        <button class="btn-back" onclick="coBack(1)"><i class="ti ti-arrow-left"></i>Kembali</button>
                        <button class="btn-next" style="flex:1" onclick="coNext()">Konfirmasi Pesanan <i class="ti ti-arrow-right"></i></button>
                    </div>
                </div>

                <!-- STEP 3 -->
                <div id="coStep3" style="display:none">
                    <div class="co-card">
                        <div class="co-sec-title"><i class="ti ti-clipboard-check" style="color:var(--blue)"></i>Review & Konfirmasi Pesanan</div>
                        <div style="background:var(--gray-f8);border-radius:var(--r-lg);padding:1rem 1.1rem;margin-bottom:1rem;font-size:.82rem;line-height:2" id="reviewData"></div>
                        <div id="reviewItems"></div>
                    </div>
                    <div style="background:var(--blue-l);border-radius:var(--r);padding:.75rem 1rem;font-size:.78rem;color:var(--blue);font-weight:700;display:flex;align-items:center;gap:.4rem;margin-bottom:.85rem">
                        <i class="ti ti-shield-lock"></i>Transaksi Anda dilindungi dengan enkripsi SSL 256-bit
                    </div>
                    <div style="display:flex;gap:.75rem">
                        <button class="btn-back" onclick="coBack(2)"><i class="ti ti-arrow-left"></i>Kembali</button>
                        <button class="btn-next" style="flex:1;background:var(--green)" onclick="placeOrder()"><i class="ti ti-check"></i>Pesan Sekarang!</button>
                    </div>
                </div>
            </div>

            <!-- RIGHT: ORDER SUMMARY -->
            <div>
                <div class="co-card" style="position:sticky;top:76px">
                    <div class="co-sec-title"><i class="ti ti-receipt" style="color:var(--blue)"></i>Ringkasan Pesanan</div>
                    <div id="coOrderItems" style="max-height:280px;overflow-y:auto"></div>
                    <div style="margin-top:.9rem;padding-top:.75rem;border-top:1px solid var(--gray-e)">
                        <div class="sum-row"><span>Subtotal</span><span id="coSub">Rp 0</span></div>
                        <!-- <div class="sum-row"><span>Ongkos Kirim</span><span>Rp 25.000</span></div> -->
                        <div class="sum-row"><span>PPN (11%)</span><span id="coTax">Rp 0</span></div>
                        <div class="sum-row tot"><span>Total Pembayaran</span><span id="coTot">Rp 0</span></div>
                    </div>
                    <div style="margin-top:.85rem;display:flex;flex-direction:column;gap:.4rem">
                        <!-- <div style="font-size:.72rem;color:var(--gray-b);display:flex;align-items:center;gap:.3rem"><i class="ti ti-truck-delivery" style="color:var(--green)"></i>Estimasi tiba 2–3 hari kerja</div> -->
                        <div style="font-size:.72rem;color:var(--gray-b);display:flex;align-items:center;gap:.3rem"><i class="ti ti-refresh" style="color:var(--blue)"></i>Retur gratis dalam 30 hari</div>
                        <div style="font-size:.72rem;color:var(--gray-b);display:flex;align-items:center;gap:.3rem"><i class="ti ti-shield-check" style="color:var(--blue)"></i>Garansi resmi semua produk</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push("scripts")
<script>
    const CART = @json($cart)

    document.addEventListener("DOMContentLoaded", function() {

        let coStep = 1;
        let coNext = 0;
        // =========================
        // RENDER ORDER (FIX)
        // =========================
        function renderCoOrder() {
            const el = document.getElementById('coOrderItems');
            if (!el) return;

            const cart = Object.values(CART);

            if (!cart.length) {
                el.innerHTML = '<p>Keranjang kosong</p>';
                return;
            }

            el.innerHTML = cart.map(x => `
            <div class="oi-row">
                <div class="oi-img">📦</div>
                <div class="oi-nm">${x.name} ×${x.qty}</div>
                <div class="oi-pr">Rp ${(x.price * x.qty).toLocaleString('id-ID')}</div>
            </div>
        `).join('');

            const sub = cart.reduce((s, x) => s + x.price * x.qty, 0);
            const tax = Math.round(sub * 0.11);
            const total = sub + tax;

            document.getElementById('coSub').textContent = 'Rp ' + sub.toLocaleString('id-ID');
            document.getElementById('coTax').textContent = 'Rp ' + tax.toLocaleString('id-ID');
            document.getElementById('coTot').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        // =========================
        // STEP CONTROL
        // =========================
        window.coNext = function() {
            if (coStep === 1 && !validateShipping()) return;

            if (coStep === 2) {
                buildReview();
            }

            showCoStep(coStep + 1);
            window.scrollTo(0, 0);
        };

        function showCoStep(n) {
            coStep = n;

            [1, 2, 3].forEach(i => {
                const el = document.getElementById('coStep' + i);
                if (el) el.style.display = (i === n ? 'block' : 'none');
            });

            updateCoProgress(n);
        }

        window.coBack = function(to) {
            showCoStep(to);
            window.scrollTo(0, 0);
        };

        // =========================
        // VALIDASI
        // =========================
        function validateShipping() {
            const fields = ['fn', 'fp', 'fe', 'fa', 'fc_city', 'fz'];

            for (let id of fields) {
                const el = document.getElementById(id);
                if (!el || !el.value.trim()) {
                    toast('⚠️ Harap isi semua data', 'err');
                    el.focus();
                    return false;
                }
            }
            return true;
        }

        // =========================
        // PAYMENT SELECT
        // =========================
        window.selPay = function(el) {
            document.querySelectorAll('.pay-opt').forEach(o => o.classList.remove('sel'));
            el.classList.add('sel');

            const cc = document.getElementById('ccFields');
            if (cc) {
                cc.style.display = el.querySelector('input').value === 'cc' ? 'block' : 'none';
            }
        };

        // =========================
        // BUILD REVIEW (FIX)
        // =========================
        function buildReview() {
            const cart = Object.values(CART);

            const reviewItems = document.getElementById('reviewItems');
            if (!reviewItems) return;

            reviewItems.innerHTML = cart.map(x => `
            <div class="oi-row">
                <div class="oi-img">📦</div>
                <div class="oi-nm">${x.name} ×${x.qty}</div>
                <div class="oi-pr">Rp ${(x.price * x.qty).toLocaleString('id-ID')}</div>
            </div>
        `).join('');

            const pay = document.querySelector('.pay-opt.sel .pay-nm')?.textContent || '-';

            document.getElementById('reviewData').innerHTML = `
            <div>
                <b>${document.getElementById('fn').value}</b><br>
                ${document.getElementById('fa').value}<br>
                ${document.getElementById('fc_city').value}<br>
                Pembayaran: <b>${pay}</b>
            </div>
        `;
        }

        // =========================
        // PLACE ORDER (SIMULASI)
        // =========================
        window.placeOrder = function() {
            alert("Order berhasil! (next: simpan ke DB + Midtrans)");
        };

        // =========================
        // PROGRESS UI
        // =========================
        function updateCoProgress(n) {
            [1, 2, 3].forEach(i => {
                const dot = document.getElementById('sdot' + i);
                const lbl = document.getElementById('slbl' + i);

                if (!dot || !lbl) return;

                if (i < n) {
                    dot.className = 'sp-dot done';
                    dot.innerHTML = '✔';
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
            });
        }

        // INIT
        renderCoOrder();
        showCoStep(1);

    });


    fetch('/api/provinces')
        .then(res => res.json())
        .then(data => {
            let province = document.getElementById('fc_province');
            province.innerHTML = '<option value="">Pilih Provinsi</option>';

            data.forEach(item => {
                province.innerHTML += `<option value="${item.id}">${item.name}</option>`;
            });
        });

    // 🔹 PROVINCE → CITY
    document.getElementById('fc_province').addEventListener('change', function() {
        let id = this.value;

        fetch(`/api/cities/${id}`)
            .then(res => res.json())
            .then(data => {
                let city = document.getElementById('fc_city');
                city.innerHTML = '<option value="">Pilih Kota</option>';

                data.forEach(item => {
                    city.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                });

                // reset bawahnya
                resetSelect('fc_district');
                resetSelect('fc_village');
            });
    });


    // 🔹 CITY → DISTRICT
    document.getElementById('fc_city').addEventListener('change', function() {
        let id = this.value;

        fetch(`/api/districts/${id}`)
            .then(res => res.json())
            .then(data => {
                let district = document.getElementById('fc_district');
                district.innerHTML = '<option value="">Pilih Kecamatan</option>';

                data.forEach(item => {
                    district.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                });

                resetSelect('fc_village');
            });
    });


    // 🔹 DISTRICT → VILLAGE
    document.getElementById('fc_district').addEventListener('change', function() {
        let id = this.value;

        fetch(`/api/villages/${id}`)
            .then(res => res.json())
            .then(data => {
                let village = document.getElementById('fc_village');
                village.innerHTML = '<option value="">Pilih Desa</option>';

                data.forEach(item => {
                    village.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                });
            });
    });


    // 🔥 HELPER RESET
    function resetSelect(id) {
        document.getElementById(id).innerHTML = '<option value="">Pilih</option>';
    }

    function OrderProcess() {

        let data = {
            name: document.getElementById('fn').value.trim(),
            phone: document.getElementById('fp').value.trim(),
            email: document.getElementById('fe').value.trim(),
            address: document.getElementById('fa').value.trim(),
            province: document.getElementById('fc_province').selectedOptions[0].text,
            city: document.getElementById('fc_city').selectedOptions[0].text,
            district: document.getElementById('fc_district').selectedOptions[0].text,
            village: document.getElementById('fc_village').selectedOptions[0].text,
            province_id: document.getElementById('fc_province').value,
            city_id: document.getElementById('fc_city').value,
            district_id: document.getElementById('fc_district').value,
            village_id: document.getElementById('fc_village').value,
            postal_code: document.getElementById('fz').value.trim(),
        };

        // 🔥 VALIDASI
        if (!data.name) return alert('Nama wajib diisi');
        if (!data.phone) return alert('No. Telepon wajib diisi');
        if (!/^08[0-9]{8,11}$/.test(data.phone)) return alert('Format nomor tidak valid');

        if (!data.email) return alert('Email wajib diisi');
        if (!/^\S+@\S+\.\S+$/.test(data.email)) return alert('Email tidak valid');

        if (!data.address) return alert('Alamat wajib diisi');
        if (!data.province) return alert('Pilih provinsi');
        if (!data.city) return alert('Pilih kota');
        if (!data.district) return alert('Pilih kecamatan');
        if (!data.village) return alert('Pilih desa');

        if (!data.postal_code) return alert('Kode pos wajib diisi');
        if (!/^[0-9]{5}$/.test(data.postal_code)) return alert('Kode pos harus 5 digit');

        // 🔹 disable button biar gak double klik
        let btn = document.querySelector('.btn-next');
        btn.disabled = true;
        btn.innerText = 'Processing...';

        fetch('/order', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(res => {
                btn.disabled = false;
                btn.innerText = 'Pesan Barang';

                if (res.success) {
                    alert('Order berhasil: ' + res.invoice);
                    location.reload();
                } else {
                    alert(res.message);
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerText = 'Pesan Barang';

                console.error(err); // 🔥 penting buat debug

                alert('Error: ' + err.message);
            });
    }
</script>

@endpush