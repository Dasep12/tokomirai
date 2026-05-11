 <!-- LAYANAN JASA -->
 <div class="sec" id="servicesSection">
     <div class="sec-inner">
         <div class="sec-header">
             <div class="sec-title">Layanan Jasa IT Profesional</div>
             <a class="sec-more">Lihat Semua <i class="ti ti-arrow-right"></i></a>
         </div>
         <div class="svc-grid" id="svcGrid"></div>
     </div>
 </div>

 @push("scripts")
 <script>
     async function renderSvcs() {
         // 🔥 FORMAT RUPIAH
         function formatRupiah(angka) {
             return new Intl.NumberFormat('id-ID').format(angka);
         }
         try {

             const response = await fetch("{{ route('home.service-json') }}");
             const services = await response.json();

             document.getElementById('svcGrid').innerHTML = services.map(s => `
            <div class="svc-card">
                <div class="svc-ic">
                    <i class="ti ${s.icon}" style="font-size:22px"></i>
                </div>

                <div class="svc-nm">${s.name}</div>

                <div class="svc-desc">
                    ${s.description}
                </div>

                <div class="svc-price">
                    <i class="ti ti-tag" style="font-size:11px"></i>
                    Harga Mulai dari  ${formatRupiah(s.price)}
                </div>

               <button class="btn-svc" onclick="orderSvc('${s.name}')">
                    <i class="ti ti-brand-whatsapp"></i>
                    Pesan Sekarang
                </button>
            </div>
        `).join('');

         } catch (error) {

             console.error(error);

             document.getElementById('svcGrid').innerHTML = `
            <div style="padding:20px;color:red">
                Gagal memuat layanan
            </div>
        `;
         }
     }

     function orderSvc(serviceName) {
         const adminPhone = '6285218026895';
         const templateMessage = `Halo Admin, saya ingin memesan layanan: *${serviceName}*.\nMohon informasi lebih lanjut terkait prosedur dan biayanya. Terima kasih.`;

         // Menggunakan encodeURIComponent untuk menangani karakter khusus, spasi, dan line break
         const encodedMessage = encodeURIComponent(templateMessage);
         const whatsappUrl = `https://wa.me/${adminPhone}?text=${encodedMessage}`;

         // 'noopener,noreferrer' adalah standar keamanan untuk window.open
         window.open(whatsappUrl, '_blank', 'noopener,noreferrer');
     }

     renderSvcs();
 </script>
 @endpush