@extends('layouts-admin.main')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    Manajemen Inventaris
                </div>
                <h2 class="page-title">
                    Master Product
                </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <span class="d-none d-sm-inline">
                        <a href="#" class="btn btn-white">
                            Export Excel
                        </a>
                    </span>
                    <button onclick="CrudProducts('create','*')" type="button" class="btn btn-primary d-none d-sm-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Tambah Produk Baru
                        </a>
                </div>
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
                        <h3 class="card-title">Daftar Produk TokoMirai</h3>
                    </div>

                    <div class="card-body border-bottom py-3">
                        <form action="{{ route('admin.products') }}" method="GET" id="filter-form">
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
                        <div id="productTable">
                            @include('admin.product.partials.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@include('admin.product.partials.crud')