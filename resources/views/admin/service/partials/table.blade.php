<div class="table-responsive">
    <table class="table table-vcenter card-table table-striped">

        <thead>
            <tr>
                <th>Name</th>
                <th>Harga</th>
                <th>Status</th>
                <th class="w-1">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($services as $service)
            <tr>
                <td>
                    <div class="d-flex py-1 align-items-center">
                        <span class="avatar me-2">
                            <i class="ti {{ $service->icon }}"></i>
                        </span>
                        <div class="flex-fill">
                            <div class="font-weight-medium text-primary">
                                {{ $service->name }}
                            </div>
                            <div class="text-secondary small">
                                {{ Str::limit($service->description, 40) }}
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="fw-bold">
                        Rp{{ number_format($service->price,0,',','.') }}
                    </div>
                </td>
                <td>

                </td>
                <td>
                    <div class="dropdown">
                        <a href="#" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action</a>
                        <div class="dropdown-menu" style="">
                            <button class="dropdown-item" onclick="CrudServices('update','{{ $service->id }}')">Edit</button>
                            <button class="dropdown-item" href="#" onclick="CrudServices('delete','{{ $service->id }}')">Delete</button>
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
        <span>{{ $services->firstItem() }}</span>
        to
        <span>{{ $services->lastItem() }}</span>
        of
        <span>{{ $services->total() }}</span>
        entries
    </p>
    <div class="ms-auto">
        {{ $services->links('pagination::bootstrap-5') }}
    </div>
</div>

@push('scripts')
<script>
    function loadServices(url = null) {
        let form = document.getElementById('filter-form');
        let formData = new FormData(form);
        let params = new URLSearchParams(formData).toString();
        url = url || `{{ route('admin.services') }}?${params}`;
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
            loadServices(url);
        }
    });

    // SHOW ENTRIES
    document.querySelector('[name="show"]')
        .addEventListener('change', function() {
            loadServices();
        });

    // SEARCH ENTER
    document.querySelector('[name="search"]')
        .addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                loadServices();
            }
        });

    $('#filter-form').on('submit', function(e) {
        e.preventDefault();
        loadServices();
    });
</script>
@endpush