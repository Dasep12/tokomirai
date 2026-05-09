<div class="table-responsive">
    <table class="table table-vcenter card-table table-striped">

        <thead>
            <tr>
                <th>Info Produk</th>
                <th>Kategori</th>
                <th>Harga & Diskon</th>
                <th class="d-none d-md-table-cell">Spesifikasi</th>
                <th>Badge</th>
                <th>Rating/Sold</th>
                <th class="w-1">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td>
                    <div class="d-flex py-1 align-items-center">
                        <span class="avatar me-2"
                            style="background-image: url({{ asset('images/' . $product->image) }})">
                        </span>
                        <div class="flex-fill">
                            <div class="font-weight-medium text-primary">
                                {{ $product->name }}
                            </div>
                            <div class="text-secondary small">
                                {{ Str::limit($product->description, 40) }}
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="badge badge-outline text-azure">
                        {{ $product->category_name  ?? 'Uncategorized' }}
                    </span>
                </td>
                <td>
                    <div class="fw-bold">
                        Rp{{ number_format($product->price,0,',','.') }}
                    </div>
                    @if($product->discount > 0)
                    <div class="text-danger small">
                        <span class="badge bg-red-lt">
                            -{{ $product->discount }} %
                        </span>
                    </div>
                    @endif
                </td>
                <td class="d-none d-md-table-cell">
                    @if(is_array($product->spesification))
                    @foreach($product->spesification as $spec)
                    <div class="small text-secondary">
                        • {{ $spec }}
                    </div>
                    @endforeach
                    @endif
                </td>
                <td>
                    @php
                    $badgeColor = match($product->badge) {

                    'Hot' => 'bg-orange-lt',
                    'New' => 'bg-green-lt',
                    'Sale' => 'bg-red-lt',
                    default => 'bg-gray-lt'

                    };
                    @endphp
                    <span class="badge {{ $badgeColor }}">
                        {{ $product->badge ?? 'Reguler' }}
                    </span>
                </td>
                <td>
                    <div class="text-warning font-weight-medium">
                        ⭐ {{ $product->rating ?? '0' }}
                    </div>
                    <div class="text-secondary small">
                        {{ $product->sold ?? 0 }} Terjual
                    </div>
                </td>
                <td>
                    <div class="dropdown">
                        <a href="#" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Download</a>
                        <div class="dropdown-menu" style="">
                            <button class="dropdown-item" onclick="CrudProducts('update','{{ $product->id }}')">Edit</button>
                            <button class="dropdown-item" href="#" onclick="CrudProducts('delete','{{ $product->id }}')">Delete</button>
                        </div>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7"
                    class="text-center text-secondary py-4">
                    Data produk belum tersedia.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="card-footer d-flex align-items-center">
    <p class="m-0 text-secondary">
        Showing
        <span>{{ $products->firstItem() }}</span>
        to
        <span>{{ $products->lastItem() }}</span>
        of
        <span>{{ $products->total() }}</span>
        entries
    </p>
    <div class="ms-auto">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
</div>

@push('scripts')
<script>
    function loadProducts(url = null) {
        let form = document.getElementById('filter-form');
        let formData = new FormData(form);
        let params = new URLSearchParams(formData).toString();
        url = url || `{{ route('admin.products') }}?${params}`;
        fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.text())
            .then(html => {
                document
                    .getElementById('productTable')
                    .innerHTML = html;
            });
    }

    // PAGINATION CLICK
    document.addEventListener('click', function(e) {
        let target = e.target;
        if (target.closest('.pagination a')) {
            e.preventDefault();
            let url = target.closest('a').href;
            loadProducts(url);
        }
    });

    // SHOW ENTRIES
    document.querySelector('[name="show"]')
        .addEventListener('change', function() {
            loadProducts();
        });

    // SEARCH ENTER
    document.querySelector('[name="search"]')
        .addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                loadProducts();
            }
        });

    $('#filter-form').on('submit', function(e) {
        e.preventDefault();
        loadProducts();
    });
</script>
@endpush