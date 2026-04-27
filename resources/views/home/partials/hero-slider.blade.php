  <!-- HERO SLIDER -->
  <div class="hero-slider" id="heroSlider">
      <button class="slider-arrow prev" onclick="slideNav(-1)"><i class="ti ti-chevron-left"></i></button>
      <button class="slider-arrow next" onclick="slideNav(1)"><i class="ti ti-chevron-right"></i></button>

      <div class="slide active" style="background:linear-gradient(135deg,#0a1f5c 0%,#0453c4 60%,#1a6fd4 100%)">
          <div class="slide-content">
              <div class="slide-text">
                  <div class="slide-eyebrow">🔥 Promo Eksklusif Bulan Ini</div>
                  <h1 class="slide-title">Laptop Terbaik<br><em>untuk Produktivitas Anda</em></h1>
                  <p class="slide-sub">Temukan laptop Intel & AMD terkini dengan harga spesial. Cicilan 0% hingga 24 bulan tersedia.</p>
                  <div class="slide-btns">
                      <button class="btn-slide-primary" onclick="setCatActive(null,'laptop');scrollToProducts()">Lihat Laptop</button>
                      <button class="btn-slide-outline" onclick="scrollToProducts()">Promo Lainnya</button>
                  </div>
              </div>
              <div class="slide-visual">💻</div>
          </div>
      </div>

      <div class="slide" style="background:linear-gradient(135deg,#062a6e 0%,#0b4db8 50%,#0e6b8a 100%)">
          <div class="slide-content">
              <div class="slide-text">
                  <div class="slide-eyebrow">🌐 Infrastruktur IT Andal</div>
                  <h1 class="slide-title">Bangun Jaringan<br><em>Kantor yang Kencang</em></h1>
                  <p class="slide-sub">Router, switch, access point Cisco & Ubiquiti. Solusi lengkap untuk jaringan bisnis Anda.</p>
                  <div class="slide-btns">
                      <button class="btn-slide-primary" onclick="setCatActive(null,'networking');scrollToProducts()">Lihat Networking</button>
                      <button class="btn-slide-outline" onclick="scrollToServices()">Jasa Instalasi</button>
                  </div>
              </div>
              <div class="slide-visual">📡</div>
          </div>
      </div>

      <div class="slide" style="background:linear-gradient(135deg,#05285c 0%,#0453c4 40%,#7c3aed 100%)">
          <div class="slide-content">
              <div class="slide-text">
                  <div class="slide-eyebrow">💾 Storage Solusi</div>
                  <h1 class="slide-title">Simpan Data<br><em>Lebih Aman & Cepat</em></h1>
                  <p class="slide-sub">SSD NVMe, HDD NAS, hingga enterprise storage. Performa tinggi, harga terjangkau.</p>
                  <div class="slide-btns">
                      <button class="btn-slide-primary" onclick="setCatActive(null,'storage');scrollToProducts()">Lihat Storage</button>
                      <button class="btn-slide-outline" onclick="scrollToServices()">Konsultasi IT</button>
                  </div>
              </div>
              <div class="slide-visual">🗄️</div>
          </div>
      </div>

      <div class="slider-dots" id="sliderDots">
          <button class="s-dot active" onclick="goSlide(0)"></button>
          <button class="s-dot" onclick="goSlide(1)"></button>
          <button class="s-dot" onclick="goSlide(2)"></button>
      </div>
  </div>