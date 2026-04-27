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
        </div>
        <div class="prod-grid" id="prodGrid"></div>
        <div style="text-align:center;margin-top:1.5rem">
            <button class="btn-ed-outline" onclick=""><i class="ti ti-grid-dots"></i>Lihat Semua Produk</button>
        </div>
    </div>
</div>