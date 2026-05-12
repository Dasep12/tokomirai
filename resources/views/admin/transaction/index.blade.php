@extends('layouts-admin.main')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    Manajemen Toko Mirai
                </div>
                <h2 class="page-title">
                    Transactions
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Layanan TokoMirai</h3>
                    </div>

                    <div class="card-body border-bottom py-3">
                        <form action="{{ route('admin.services') }}" method="GET" id="filter-form">
                            <div class="d-flex">
                                <div class="text-secondary">
                                    Show
                                    <div class="mx-2 d-inline-block">
                                        <!-- Dropdown lebih baik daripada input text untuk jumlah entries -->
                                        <select name="show" class="form-select form-select-sm">
                                            <option value="5">5</option>
                                            <option selected value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                        </select>
                                    </div>
                                    entries
                                </div>
                                <div class="ms-auto text-secondary">
                                    Search:
                                    <div class="ms-2 d-inline-block">
                                        <input type="text" name="search" class="form-control form-control-sm"
                                            value="{{ request('search') }}" placeholder="Cari produk...">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <div id="transactionTable">
                            @include('admin.transaction.partials.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@include('admin.transaction.partials.crud')