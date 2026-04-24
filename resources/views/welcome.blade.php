<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TokóMirai — Segera Hadir</title>
    <link rel="stylesheet" href="{{ asset('assets/construction.css') }} ">
</head>

<body>

    <div class="bg-grid"></div>
    <div class="blob"></div>
    <div class="blob blob2"></div>

    <main>
        <!-- Brand -->
        <div class="brand">

            <img style="height:100px;width: auto;" src="{{ asset('assets/images/logo/tokomirai-logo.png') }}">
        </div>

        <!-- Badge -->
        <div class="badge">
            <span class="badge-dot"></span>
            Sedang dalam pengembangan
        </div>

        <p class="subtitle">
            Kami sedang membangun pengalaman belanja terbaik untuk Anda.
        </p>

        <!-- Countdown -->
        <div class="countdown-wrap">
            <div class="count-block">
                <div class="count-num" id="days">00</div>
                <div class="count-label">Hari</div>
            </div>
            <div class="count-sep">:</div>
            <div class="count-block">
                <div class="count-num" id="hours">00</div>
                <div class="count-label">Jam</div>
            </div>
            <div class="count-sep">:</div>
            <div class="count-block">
                <div class="count-num" id="minutes">00</div>
                <div class="count-label">Menit</div>
            </div>
            <div class="count-sep">:</div>
            <div class="count-block">
                <div class="count-num" id="seconds">00</div>
                <div class="count-label">Detik</div>
            </div>
        </div>

        <!-- Email form -->
        <!-- <div class="notify-form" id="form">
            <input type="email" id="email-input" placeholder="emailanda@contoh.com" />
            <button onclick="handleSubscribe()">Beritahu Saya</button>
        </div>
        <p class="success-msg" id="success-msg">✓ Terima kasih! Kami akan menghubungi Anda segera.</p> -->

        <!-- Progress -->
        <div class="progress-area">
            <div class="progress-head">
                <span>Progress pengembangan</span>
                <span>72%</span>
            </div>
            <div class="progress-track">
                <div class="progress-fill"></div>
            </div>
        </div>

        <!-- Features -->
        <div class="features">
            <div class="pill">
                <div class="pill-icon">
                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none">
                        <path d="M2 5l2 2 4-4" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                Pengiriman Cepat
            </div>
            <div class="pill">
                <div class="pill-icon">
                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none">
                        <path d="M2 5l2 2 4-4" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                Pembayaran Aman
            </div>
            <div class="pill">
                <div class="pill-icon">
                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none">
                        <path d="M2 5l2 2 4-4" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                Produk Berkualitas
            </div>
            <div class="pill">
                <div class="pill-icon">
                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none">
                        <path d="M2 5l2 2 4-4" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                Garansi Terjamin
            </div>
        </div>
    </main>

    <footer>
        &copy; 2025 TokóMirai. Semua hak dilindungi. &nbsp;|&nbsp;
        <a href="mailto:marketing@miraisoftnet.com">marketing@miraisoftnet.com</a>
    </footer>

    <script>
        // Countdown: set your launch date here
        const launch = new Date("2026-05-10T00:00:00").getTime();

        function pad(n) {
            return String(n).padStart(2, '0');
        }

        function tick() {
            const diff = launch - Date.now();
            if (diff <= 0) {
                document.getElementById('days').textContent = '00';
                document.getElementById('hours').textContent = '00';
                document.getElementById('minutes').textContent = '00';
                document.getElementById('seconds').textContent = '00';
                return;
            }
            const d = Math.floor(diff / 86400000);
            const h = Math.floor((diff % 86400000) / 3600000);
            const m = Math.floor((diff % 3600000) / 60000);
            const s = Math.floor((diff % 60000) / 1000);
            document.getElementById('days').textContent = pad(d);
            document.getElementById('hours').textContent = pad(h);
            document.getElementById('minutes').textContent = pad(m);
            document.getElementById('seconds').textContent = pad(s);
        }

        tick();
        setInterval(tick, 1000);

        function handleSubscribe() {
            const val = document.getElementById('email-input').value.trim();
            if (!val || !val.includes('@')) {
                document.getElementById('email-input').focus();
                document.getElementById('email-input').style.borderColor = '#e24b4a';
                setTimeout(() => document.getElementById('email-input').style.borderColor = '', 1500);
                return;
            }
            document.getElementById('form').style.display = 'none';
            const msg = document.getElementById('success-msg');
            msg.style.display = 'block';
        }
    </script>
</body>

</html>