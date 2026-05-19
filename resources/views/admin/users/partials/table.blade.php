<div class="table-responsive">
    <table class="table table-vcenter card-table table-striped">

        <thead>
            <tr>
                <th>Name</th>
                <th>Provider</th>
                <th>Verified At</th>
                <th>Last Login</th>
                <th class="w-1">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>
                    <div class="d-flex py-1 align-items-center">
                        <span class="avatar me-2"
                            style="background-image: url('{{ $user->avatar }}')">
                        </span>
                        <div class="flex-fill">
                            <div class="font-weight-medium text-primary">
                                {{ $user->name }}
                            </div>
                            <div class="text-secondary small">
                                {{ Str::limit($user->email, 40) }}
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="badge badge-outline text-azure">
                        {{ $user->provider  ?? 'Uncategorized' }}
                    </span>
                </td>
                <td>
                    {{ $user->email_verified_at }}
                </td>
                <td>
                    {{ $user->last_login_at }}
                </td>

                <td>
                    <div class="dropdown">
                        <a href="#" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action</a>
                        <div class="dropdown-menu" style="">
                            <button class="dropdown-item" onclick="CrudUsers('update','{{ $user->id }}')">Edit</button>
                            <button class="dropdown-item" href="#" onclick="CrudUsers('updated_pwd','{{ $user->id }}')">Change Password</button>
                            <button class="dropdown-item" href="#" onclick="CrudUsers('delete','{{ $user->id }}')">Delete</button>
                        </div>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7"
                    class="text-center text-secondary py-4">
                    Data belum tersedia.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="card-footer d-flex align-items-center">
    <p class="m-0 text-secondary">
        Showing
        <span>{{ $users->firstItem() }}</span>
        to
        <span>{{ $users->lastItem() }}</span>
        of
        <span>{{ $users->total() }}</span>
        entries
    </p>
    <div class="ms-auto">
        {{ $users->links('pagination::bootstrap-5') }}
    </div>
</div>

@push('scripts')
<script>
    function loadUsers(url = null) {
        let form = document.getElementById('filter-form');
        let formData = new FormData(form);
        let params = new URLSearchParams(formData).toString();
        url = url || `{{ route('admin.users') }}?${params}`;
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