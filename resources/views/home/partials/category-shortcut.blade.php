   <!-- CATEGORY SHORTCUTS -->
   <div class="cat-shortcuts">
       <div class="cat-shortcuts-inner">
           <div class="cat-sc" onclick="changeCategory('laptop', this)">
               <div class="cat-sc-icon">💻</div>
               <div class="cat-sc-label">Laptop</div>
               <div class="cat-sc-price">Dari Rp 5 Jt</div>
           </div>
           <div class="cat-sc" onclick="changeCategory('monitor',this);scrollToProducts()">
               <div class="cat-sc-icon">🖥️</div>
               <div class="cat-sc-label">Monitor</div>
               <div class="cat-sc-price">Dari Rp 2,1 Jt</div>
           </div>
           <div class="cat-sc" onclick="changeCategory('networking',this);scrollToProducts()">
               <div class="cat-sc-icon">📡</div>
               <div class="cat-sc-label">Networking</div>
               <div class="cat-sc-price">Dari Rp 890 Rb</div>
           </div>
           <div class="cat-sc" onclick="changeCategory('storage',this);scrollToProducts()">
               <div class="cat-sc-icon">💾</div>
               <div class="cat-sc-label">Storage</div>
               <div class="cat-sc-price">Dari Rp 680 Rb</div>
           </div>
           <div class="cat-sc" onclick="changeCategory('aksesoris',this);scrollToProducts()">
               <div class="cat-sc-icon">🖱️</div>
               <div class="cat-sc-label">Aksesoris</div>
               <div class="cat-sc-price">Dari Rp 550 Rb</div>
           </div>
           <div class="cat-sc" onclick="changeCategory('server',this);scrollToProducts()">
               <div class="cat-sc-icon">🗄️</div>
               <div class="cat-sc-label">Server & NAS</div>
               <div class="cat-sc-price">Dari Rp 3,2 Jt</div>
           </div>
           <div class="cat-sc" onclick="changeCategory('security',this);scrollToProducts()">
               <div class="cat-sc-icon">🔐</div>
               <div class="cat-sc-label">Security</div>
               <div class="cat-sc-price">Dari Rp 750 Rb</div>
           </div>
           <div class="cat-sc" onclick="scrollToServices()">
               <div class="cat-sc-icon">🔧</div>
               <div class="cat-sc-label">Jasa IT</div>
               <div class="cat-sc-price">Dari Rp 100 Rb</div>
           </div>
       </div>
   </div>


   @push("scripts")
   <script>
       function setCatActive(search, category) {
           //    document.querySelectorAll('.prod-tab').forEach(t => t.classList.remove('active'));
           //    el.classList.add('active');

           currentCat = category;
           loadProducts(category);
       }
   </script>
   @endpush