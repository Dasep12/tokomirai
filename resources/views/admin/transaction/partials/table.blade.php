<style>
    .transaction-tabs {
        display: flex;
        gap: 2px;
        /* flex-wrap: wrap; */
    }

    .transaction-tab {
        min-width: 220px;
        flex: 1;
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 10px;
        border-radius: 3px;
        background: #fff;
        border: 1px solid #e9ecef;
        text-decoration: none;
        transition: all .25s ease;
        position: relative;
        overflow: hidden;
    }

    .transaction-tab:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, .08);
        border-color: #206bc4;
    }

    .transaction-tab.active {
        border: 2px solid #206bc4;
        background: linear-gradient(135deg,
                rgba(32, 107, 196, .08),
                rgba(32, 107, 196, .02));
    }

    .tab-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
    }

    .tab-title {
        font-size: 16px;
        font-weight: 700;
        color: #182433;
        line-height: 1.2;
    }

    .tab-subtitle {
        font-size: 13px;
        color: #667382;
        margin-top: 4px;
    }
</style>

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
            @php
            $statusMap = [
            'PENDING' => 'PROCESS',
            'PROCESS' => 'SHIPPING',
            'SHIPPING' => 'DONE',
            ];

            $nextStatus = $statusMap[$transaction->status]
            ?? $transaction->status;
            @endphp
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
                            <button class="dropdown-item" onclick="CrudTransactions('update','{{ $transaction->id }}')">Detail</button>
                            <button class="dropdown-item" href="#" onclick="CrudTransactionsProcess('{{ $nextStatus }}','{{ $transaction->id }}','{{ $transaction->invoice }}')">Process</button>
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
        let status = document.getElementById('status-filter').value;
        if (status) {
            formData.append('status', status);
        }
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

    document.querySelectorAll('.transaction-tab')
        .forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('.transaction-tab')
                    .forEach(item => item.classList.remove('active'));
                this.classList.add('active');
                let status = this.dataset.status;
                document.getElementById('status-filter').value = status;
                loadTransactions();
            });

        });

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