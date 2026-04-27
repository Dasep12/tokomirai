   <!-- =============================================================== -->
   <!-- PAGE: CHECKOUT -->
   <!-- =============================================================== -->
   <div class="pg" id="pgCheckout">
       <div style="max-width:1280px;margin:0 auto;padding:.75rem 1.5rem;border-bottom:1px solid var(--gray-e);display:flex;align-items:center;gap:.5rem;font-size:12.5px;color:var(--gray-b)">
           <span onclick="goHome()" style="cursor:pointer;color:var(--blue)"><i class="ti ti-home" style="font-size:14px"></i> Beranda</span>
           <i class="ti ti-chevron-right" style="font-size:12px"></i>
           <span style="color:var(--black);font-weight:700">Checkout</span>
       </div>

       <div class="co-wrap">
           <h2 style="font-size:1.3rem;font-weight:800;margin-bottom:1.5rem;display:flex;align-items:center;gap:.5rem"><i class="ti ti-credit-card" style="color:var(--blue)"></i>Checkout</h2>

           <!-- PROGRESS BAR -->
           <div class="step-prog" id="coProgress">
               <div class="sp">
                   <div class="sp-dot active" id="sdot1">1</div>
                   <div class="sp-label active" id="slbl1">Pengiriman</div>
               </div>
               <div class="sp-line" id="sline1"></div>
               <div class="sp">
                   <div class="sp-dot" id="sdot2">2</div>
                   <div class="sp-label" id="slbl2">Pembayaran</div>
               </div>
               <div class="sp-line" id="sline2"></div>
               <div class="sp">
                   <div class="sp-dot" id="sdot3">3</div>
                   <div class="sp-label" id="slbl3">Konfirmasi</div>
               </div>
           </div>

           <div class="co-grid">
               <!-- LEFT COL -->
               <div>
                   <!-- STEP 1 -->
                   <div id="coStep1">
                       <div class="co-card">
                           <div class="co-sec-title"><i class="ti ti-map-pin" style="color:var(--blue)"></i>Data Pengiriman</div>
                           <div class="form-row2">
                               <div><label class="fl">Nama Lengkap *</label><input class="fc" id="fn" placeholder="Budi Santoso"></div>
                               <div><label class="fl">No. Telepon *</label><input class="fc" id="fp" placeholder="08xxxxxxxxxx" type="tel"></div>
                           </div>
                           <div class="form-row1"><label class="fl">Email *</label><input class="fc" id="fe" placeholder="email@contoh.com" type="email"></div>
                           <div class="form-row1"><label class="fl">Alamat Lengkap *</label><textarea class="fc" id="fa" rows="2" placeholder="Jl. Contoh No. 1, RT/RW, Kelurahan..."></textarea></div>
                           <div class="form-row2">
                               <div><label class="fl">Kota *</label>
                                   <select class="fc" id="fc_city">
                                       <option value="">Pilih Kota</option>
                                       <option>Jakarta Pusat</option>
                                       <option>Jakarta Selatan</option>
                                       <option>Jakarta Utara</option>
                                       <option>Jakarta Barat</option>
                                       <option>Bandung</option>
                                       <option>Surabaya</option>
                                       <option>Yogyakarta</option>
                                       <option>Medan</option>
                                       <option>Makassar</option>
                                       <option>Semarang</option>
                                       <option>Depok</option>
                                       <option>Tangerang</option>
                                       <option>Bekasi</option>
                                   </select>
                               </div>
                               <div><label class="fl">Kode Pos *</label><input class="fc" id="fz" placeholder="12345" type="text" maxlength="5"></div>
                           </div>
                           <div class="form-row1">
                               <label class="fl">Ekspedisi Pengiriman</label>
                               <select class="fc" id="fship">
                                   <option>JNE REG — Rp 25.000 (2–3 Hari Kerja)</option>
                                   <option>JNE YES — Rp 45.000 (1 Hari Kerja)</option>
                                   <option>SiCepat BEST — Rp 28.000 (2–3 Hari Kerja)</option>
                                   <option>GoSend Same Day — Rp 60.000 (Hari Ini)</option>
                                   <option>Ambil di Toko — GRATIS (Ready Stock)</option>
                               </select>
                           </div>
                       </div>
                       <button class="btn-next" onclick="coNext()">Lanjut ke Pembayaran <i class="ti ti-arrow-right"></i></button>
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
                           <div class="sum-row"><span>Ongkos Kirim</span><span>Rp 25.000</span></div>
                           <div class="sum-row"><span>PPN (11%)</span><span id="coTax">Rp 0</span></div>
                           <div class="sum-row tot"><span>Total Pembayaran</span><span id="coTot">Rp 0</span></div>
                       </div>
                       <div style="margin-top:.85rem;display:flex;flex-direction:column;gap:.4rem">
                           <div style="font-size:.72rem;color:var(--gray-b);display:flex;align-items:center;gap:.3rem"><i class="ti ti-truck-delivery" style="color:var(--green)"></i>Estimasi tiba 2–3 hari kerja</div>
                           <div style="font-size:.72rem;color:var(--gray-b);display:flex;align-items:center;gap:.3rem"><i class="ti ti-refresh" style="color:var(--blue)"></i>Retur gratis dalam 30 hari</div>
                           <div style="font-size:.72rem;color:var(--gray-b);display:flex;align-items:center;gap:.3rem"><i class="ti ti-shield-check" style="color:var(--blue)"></i>Garansi resmi semua produk</div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>

   <!-- =============================================================== -->
   <!-- PAGE: SUCCESS -->
   <!-- =============================================================== -->
   <div class="pg" id="pgSuccess">
       <div class="succ-wrap">
           <div class="succ-card">
               <div class="succ-icon">✅</div>
               <div class="succ-title">Pesanan Berhasil!</div>
               <div class="succ-sub">Terima kasih telah berbelanja di TechNova.id. Kami segera memproses pesanan Anda.</div>
               <div class="succ-oid">Nomor Pesanan: <span id="succOid">#TN-000000</span></div>
               <div class="track-steps">
                   <div class="ts">
                       <div class="ts-dot"><i class="ti ti-check" style="font-size:.75rem"></i></div>
                       <div class="ts-label blue">Pesanan<br>Diterima</div>
                   </div>
                   <div class="ts-line blue"></div>
                   <div class="ts">
                       <div class="ts-dot"><i class="ti ti-package" style="font-size:.75rem"></i></div>
                       <div class="ts-label blue">Dikemas</div>
                   </div>
                   <div class="ts-line"></div>
                   <div class="ts">
                       <div class="ts-dot grey"><i class="ti ti-truck" style="font-size:.75rem"></i></div>
                       <div class="ts-label">Dikirim</div>
                   </div>
                   <div class="ts-line"></div>
                   <div class="ts">
                       <div class="ts-dot grey"><i class="ti ti-home" style="font-size:.75rem"></i></div>
                       <div class="ts-label">Tiba</div>
                   </div>
               </div>
               <div style="background:var(--gray-f8);border-radius:var(--r-lg);padding:1rem;margin-bottom:1.25rem;font-size:.82rem;line-height:1.9;text-align:left" id="succDetail"></div>
               <button class="btn-next" onclick="goHome()" style="background:var(--blue)"><i class="ti ti-arrow-left"></i>Lanjut Belanja</button>
           </div>
       </div>
   </div>