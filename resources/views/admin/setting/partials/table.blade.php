<div class="table-responsive">
    <table class="table table-vcenter card-table table-striped">

        <thead>
            <tr>
                <th>Key</th>
                <th>Value</th>
                <th>Remarks</th>
                <th>Images</th>
                <th>Created At</th>
                <th class="w-1">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($settings as $setting)
            <tr>
                <td>
                    <div class="fw-bold">
                        {{ $setting->key }}
                    </div>
                </td>
                <td>
                    {{ $setting->values }}
                </td>
                <td>
                    {{ $setting->remarks }}
                </td>
                <td>
                    <span class="avatar avatar-sm" style="background-image: url({{ asset('assets/images/logo/'.$setting->images) }})"> </span>
                </td>
                <td>
                    {{ $setting->created_at }}
                </td>
                <td>
                    <div class="dropdown">
                        <a href="#" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action</a>
                        <div class="dropdown-menu" style="">
                            <button class="dropdown-item" onclick="CrudSettings('update','{{ $setting->id }}')">Edit</button>
                            <!-- <button class="dropdown-item" href="#" onclick="CrudSettings('delete','{{ $setting->id }}')">Delete</button> -->
                        </div>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center text-secondary py-4">
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
        <span>{{ $settings->firstItem() }}</span>
        to
        <span>{{ $settings->lastItem() }}</span>
        of
        <span>{{ $settings->total() }}</span>
        entries
    </p>
    <div class="ms-auto">
        {{ $settings->links('pagination::bootstrap-5') }}
    </div>
</div>

@push('scripts')
<script>
    function loadSettings(url = null) {
        let form = document.getElementById('filter-form');
        let formData = new FormData(form);
        let params = new URLSearchParams(formData).toString();
        url = url || `{{ route('admin.settings') }}?${params}`;
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
            loadSettings(url);
        }
    });

    // SHOW ENTRIES
    document.querySelector('[name="show"]')
        .addEventListener('change', function() {
            loadSettings();
        });

    // SEARCH ENTER
    document.querySelector('[name="search"]')
        .addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                loadSettings();
            }
        });

    $('#filter-form').on('submit', function(e) {
        e.preventDefault();
        loadSettings();
    });
</script>
@endpush