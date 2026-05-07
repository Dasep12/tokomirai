<style>
    /* Menyelaraskan teks pemisah (hr-text) agar lebih rapi */
    .hr-text-left {
        margin: 1.5rem 0 1rem 0;
        color: var(--tblr-primary);
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    /* Efek hover pada gambar */
    .bg-light:hover img {
        transform: scale(1.05);
        transition: transform 0.3s ease;
    }

    .img-thumbnail-wrapper {
        border: 2px solid transparent;
        border-radius: 6px;
        padding: 2px;
        transition: all 0.2s;
        background: white;
    }

    .img-thumbnail-wrapper:hover {
        border-color: var(--tblr-primary-lighten);
    }

    .img-thumbnail-wrapper.active {
        border-color: var(--tblr-primary);
    }

    .cursor-pointer {
        cursor: pointer;
    }

    #main-product-img.fade-effect {
        opacity: 0.5;
        transform: scale(0.95);
    }
</style>
<div class="modal modal-blur fade" id="modal-product" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-full-width  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Detail Product</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <!-- Sisi Kiri: Gambar Product -->
                    <div class="col-md-5">
                        <div class="card shadow-none border-0 bg-light p-3 text-center rounded-3">
                            <!-- Gambar Utama -->
                            <div class="mb-3 overflow-hidden" style="height: 300px; display: flex; align-items: center; justify-content: center;">
                                <img id="main-product-img" src="{{ asset('assets/images/products/no-image-available.png') }}"
                                    class="img-fluid rounded-3" alt="Product Image" style="transition: all 0.3s ease;">
                            </div>

                            <!-- Thumbnail Slider (Variations) -->
                            <div class="row g-2 mt-2" id="product_images_slider">
                                <!-- <div class="col-4">
                                    <div class="img-thumbnail-wrapper cursor-pointer active" onclick="changeImage(this, 'https://www.footstepfootwear.com/wp-content/uploads/2024/07/classic-bw-4-1024x1024.jpeg')">
                                        <img src="https://www.footstepfootwear.com/wp-content/uploads/2024/07/classic-bw-4-1024x1024.jpeg" class="img-fluid rounded">
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>

                    <!-- Sisi Kanan: Detail -->
                    <div class="col-md-7">
                        <div class="d-flex align-items-start justify-content-between mb-2">
                            <div id="product-title">
                                <small class="text-muted text-uppercase tracking-wider">Electronics / Laptop</small>
                                <h1 class="h1 fw-bold mt-1">HP Pavillion 2026</h1>
                            </div>
                            <!-- <button class="btn btn-icon btn-ghost-danger rounded-circle" id="wishBtn" onclick="toggleWish()">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-heart" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" />
                                </svg>
                            </button> -->
                        </div>

                        <!-- Price Section -->
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span id="product-price" class="h2 text-primary fw-bold mb-0"></span>
                            <span id="product-discount" class="badge bg-danger-lt text-danger fw-bold"> </span>
                            <span id="product-price-discount" class="text-muted text-decoration-line-through"></span>
                        </div>

                        <div class="hr-text hr-text-left">Spesifikasi</div>

                        <ul class="list-unstyled space-y-1 mb-3" id="product-spec">

                        </ul>

                        <div class="hr-text hr-text-left">Deskripsi</div>
                        <p class="text-muted small mb-4" id="product-deskripsi">

                        </p>

                        <!-- CTA -->
                        <div class="row g-2">
                            <div class="col">
                                <button class="btn btn-primary w-100 py-2" onclick="orderNow()">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M17 17h-11v-14h-2" />
                                        <path d="M6 5l14 1l-1 7h-13" />
                                    </svg>
                                    Pesan Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push("scripts")
<script>
    function changeImage(element, src) {
        const mainImg = document.getElementById('main-product-img');

        // 1. Tambahkan efek transisi (fade out)
        mainImg.classList.add('fade-effect');

        // 2. Hapus class 'active' dari semua thumbnail
        document.querySelectorAll('.img-thumbnail-wrapper').forEach(el => {
            el.classList.remove('active');
        });

        // 3. Set thumbnail yang diklik menjadi active
        element.classList.add('active');

        // 4. Ganti gambar setelah delay kecil agar animasi halus
        setTimeout(() => {
            mainImg.src = src;
            mainImg.classList.remove('fade-effect');
        }, 150);
    }

    function toggleWish() {
        const btn = document.getElementById('wishBtn');
        btn.classList.toggle('text-danger');
        btn.classList.toggle('btn-ghost-danger');
        btn.classList.toggle('btn-danger'); // Opsional: ganti warna penuh
    }
</script>
@endpush