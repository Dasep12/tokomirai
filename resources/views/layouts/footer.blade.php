<!-- FOOTER -->
<footer>
    <div class="footer-top">
        <div>
            <div class="footer-brand">
                @if($global_settings['logo_footer']->values)
                <img class="img-logo" src="{{ asset('assets/images/logo/' . $global_settings['logo_footer']->values) }}" alt="">
                @else
                <img class="img-logo" src="{{ asset('assets/images/logo/tokomirai-white-logo.png') }}" alt="">
                @endif
            </div>
            <div class="footer-desc">Distributor produk IT terpercaya sejak 2024. Melayani kebutuhan hardware, software, dan jasa IT untuk bisnis dan personal di seluruh Indonesia.</div>
            <div class="footer-contact">
                📞 {{ $global_settings['contact_marketing']->values ?? '-' }}<br>
                📧 {{ $global_settings['email_marketing']->values ?? '-' }}<br>
                📍 Vasanta Innopark, Kabupaten Bekasi, Jawa Barat 17530<br>
                🕐 Senin–Jumat, 07:15–16:00 WIB
            </div>
        </div>
        <div>
            <div class="footer-h">Berbelanja Produk</div>
            <ul class="footer-ul">
                <li><a>Laptop & PC</a></li>
                <li><a>Networking</a></li>
                <li><a>Storage</a></li>
                <li><a>Monitor</a></li>
                <li><a>Server & NAS</a></li>
                <li><a>Security</a></li>
                <li><a>Aksesoris</a></li>
            </ul>
        </div>
        <div>
            <div class="footer-h">Layanan Pelanggan</div>
            <ul class="footer-ul">
                <li><a>Lacak Pesanan</a></li>
                <li><a>Dukungan Teknis</a></li>
                <li><a>Retur & Pengembalian</a></li>
                <li><a>FAQs</a></li>
                <li><a>Hubungi Kami</a></li>
                <li><a>Garansi Produk</a></li>
            </ul>
        </div>
        <div>
            <div class="footer-h">Tentang Tokomirai</div>
            <ul class="footer-ul">
                <li><a>Tentang Kami</a></li>
                <li><a>Karir</a></li>
                <li><a>Berita & Blog</a></li>
                <li><a>Kebijakan Privasi</a></li>
                <li><a>Syarat & Ketentuan</a></li>
                <li><a>Peta Situs</a></li>
            </ul>
        </div>
        <div>
            <div class="footer-h">Tokomirai</div>
            <ul class="footer-ul">
                <li><a>Jakarta Pusat</a></li>
                <li><a>Jakarta Selatan</a></li>
                <li><a>Bandung</a></li>
                <li><a>Surabaya</a></li>
                <li><a>Yogyakarta</a></li>
                <li><a>Medan</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-mid">
        <div style="font-size:12px;color:rgba(255,255,255,.5)">Metode Pembayaran & Pengiriman yang Diterima:</div>
        <div class="payment-logos">
            <span class="pay-logo">VISA</span><span class="pay-logo">MASTERCARD</span>
            <span class="pay-logo">BCA</span><span class="pay-logo">MANDIRI</span>
            <span class="pay-logo">QRIS</span><span class="pay-logo">OVO</span>
            <span class="pay-logo">GOPAY</span><span class="pay-logo">DANA</span>
            <span class="pay-logo">JNE</span><span class="pay-logo">SICEPAT</span>
        </div>
    </div>
    <div class="footer-bot">
        <span>© 2025 Tokomirai — PT Mirai Softnet Technology</span>
        <div style="display:flex;gap:1rem;flex-wrap:wrap;justify-content:center">
            <a>Kebijakan Privasi</a><a>Syarat & Ketentuan</a><a>Aksesibilitas</a><a>Pengungkapan Situs</a>
        </div>
    </div>
</footer>