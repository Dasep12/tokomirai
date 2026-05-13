<div class="table-responsive">
    <table class="table table-vcenter card-table table-striped">

        <thead>
            <tr>
                <th>Customers</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customers as $customer)
            <tr>
                <td>
                    <div class="d-flex py-1 align-items-center">

                        <div class="flex-fill">
                            <div class="font-weight-medium text-primary">
                                {{ $customer->name }}
                            </div>
                        </div>
                    </div>
                </td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->phone }}</td>
                <td>{{ $customer->created_at }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7"
                    class="text-center text-secondary py-4">
                    Data customer belum tersedia.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="card-footer d-flex align-items-center">
    <p class="m-0 text-secondary">
        Showing
        <span>{{ $customers->firstItem() }}</span>
        to
        <span>{{ $customers->lastItem() }}</span>
        of
        <span>{{ $customers->total() }}</span>
        entries
    </p>
    <div class="ms-auto">
        {{ $customers->links('pagination::bootstrap-5') }}
    </div>
</div>

@push('scripts')
<script>
    function loadCustomers(url = null) {
        let form = document.getElementById('filter-form');
        let formData = new FormData(form);
        let params = new URLSearchParams(formData).toString();
        url = url || `{{ route('admin.customers') }}?${params}`;
        fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.text())
            .then(html => {
                document
                    .getElementById('customerTable')
                    .innerHTML = html;
            });
    }

    // PAGINATION CLICK
    document.addEventListener('click', function(e) {
        let target = e.target;
        if (target.closest('.pagination a')) {
            e.preventDefault();
            let url = target.closest('a').href;
            loadCustomers(url);
        }
    });

    // SHOW ENTRIES
    document.querySelector('[name="show"]')
        .addEventListener('change', function() {
            loadCustomers();
        });

    // SEARCH ENTER
    document.querySelector('[name="search"]')
        .addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                loadCustomers();
            }
        });

    $('#filter-form').on('submit', function(e) {
        e.preventDefault();
        loadCustomers();
    });
</script>
@endpush