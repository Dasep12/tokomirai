<div class="table-responsive">
    <table class="table table-vcenter card-table table-striped">

        <thead>
            <tr>
                <th>Invoice</th>
                <th>Customers</th>
                <th>Total</th>
                <th>Tax</th>
                <th>Grand Total</th>
                <th>Status</th>
                <th class="w-1">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $transaction)
            <tr>
                <td>{{ $transaction->invoice }}</td>
                <td>
                    <div class="d-flex py-1 align-items-center">

                        <div class="flex-fill">
                            <div class="font-weight-medium text-primary">
                                {{ $transaction->name }}
                            </div>
                            <div class="text-secondary small">
                                {{ $transaction->email }}

                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="fw-bold">
                        Rp{{ number_format($transaction->total,0,',','.') }}
                    </div>
                </td>
                <td>
                    <div class="fw-bold">
                        Rp{{ number_format($transaction->tax,0,',','.') }}
                    </div>
                </td>
                <td>
                    <div class="fw-bold">
                        Rp{{ number_format($transaction->grand_total,0,',','.') }}
                    </div>
                </td>
                <td>
                    <span class="badge bg-primary text-white">{{ $transaction->status }}</span>
                </td>
                <td>
                    <div class="dropdown">
                        <a href="#" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action</a>
                        <div class="dropdown-menu" style="">
                            <button class="dropdown-item" onclick="CrudServices('update','{{ $transaction->id }}')">Edit</button>
                            <button class="dropdown-item" href="#" onclick="CrudServices('delete','{{ $transaction->id }}')">Delete</button>
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
        <span>{{ $transactions->firstItem() }}</span>
        to
        <span>{{ $transactions->lastItem() }}</span>
        of
        <span>{{ $transactions->total() }}</span>
        entries
    </p>
    <div class="ms-auto">
        {{ $transactions->links('pagination::bootstrap-5') }}
    </div>
</div>

@push('scripts')
<script>
    function loadTransactions(url = null) {
        let form = document.getElementById('filter-form');
        let formData = new FormData(form);
        let params = new URLSearchParams(formData).toString();
        url = url || `{{ route('admin.transactions') }}?${params}`;
        fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.text())
            .then(html => {
                document
                    .getElementById('transactionTable')
                    .innerHTML = html;
            });
    }

    // PAGINATION CLICK
    document.addEventListener('click', function(e) {
        let target = e.target;
        if (target.closest('.pagination a')) {
            e.preventDefault();
            let url = target.closest('a').href;
            loadTransactions(url);
        }
    });

    // SHOW ENTRIES
    document.querySelector('[name="show"]')
        .addEventListener('change', function() {
            loadTransactions();
        });

    // SEARCH ENTER
    document.querySelector('[name="search"]')
        .addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                loadTransactions();
            }
        });

    $('#filter-form').on('submit', function(e) {
        e.preventDefault();
        loadTransactions();
    });
</script>
@endpush