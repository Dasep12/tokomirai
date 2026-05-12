<div class="modal modal-blur fade" id="modal-service" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="serviceForm" enctype="multipart/form-data" action="" method="POST">
                @csrf
                <div id="methodField"></div>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Service Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Email *</label>
                            <input class="form-control" id="email" type="email">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Kode Pos *</label>
                            <input
                                class="form-control"
                                id="postal_code"
                                placeholder="12345"
                                type="text"
                                maxlength="5">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Alamat Lengkap *</label>
                            <textarea
                                class="form-control"
                                id="address"
                                rows="3"
                                placeholder="Jl. Contoh No. 1, RT/RW, Kelurahan..."></textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Provinsi *</label>
                            <select class="form-control" id="province">
                                <option value="">Pilih Provinsi</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Kota *</label>
                            <select class="form-control" id="city">
                                <option value="">Pilih Kota</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">District *</label>
                            <select class="form-control" id="district">
                                <option value="">Pilih District</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Desa *</label>
                            <select class="form-control" id="village">
                                <option value="">Pilih Desa</option>
                            </select>
                        </div>

                        <div class="col-12 mt-4">
                            <table class="table table-vcenter">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody id="detailTransaction">
                                    <!-- Detail transaksi akan dimuat di sini -->
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <input type="text" hidden id="crud-action" name="crud-action">
                    <div id="ErrInfo"></div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-link-secondary" data-bs-dismiss="modal">Batal <i class="ti ti-x"></i> </a>
                    <button id="btnSubmit" type="submit" class="btn btn-primary ms-auto">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const serviceForm = $('#serviceForm');


    // ==============================
    // RESET FORM
    // ==============================
    function resetForm() {
        serviceForm[0].reset();
    }

    fetch('/api/provinces')
        .then(res => res.json())
        .then(data => {
            let province = document.getElementById('province');
            province.innerHTML = '<option value="">Pilih Provinsi</option>';

            data.forEach(item => {
                province.innerHTML += `<option value="${item.id}">${item.name}</option>`;
            });
        });

    // 🔹 PROVINCE → CITY
    $('#province').on('change', function() {
        let id = this.value;
        console.log('Province ID : ', id);
        fetch(`/api/cities/${id}`)
            .then(res => res.json())
            .then(data => {
                let city = $('#city');
                city.html('<option value="">Pilih Kota</option>');
                data.forEach(item => {
                    city.append(`
                    <option value="${item.id}">
                        ${item.name}
                    </option>
                `);
                });
                resetSelect('district');
                resetSelect('village');
            });
    });


    // 🔹 CITY → DISTRICT
    $('#city').on('change', function() {
        let id = this.value;

        fetch(`/api/districts/${id}`)
            .then(res => res.json())
            .then(data => {
                let district = $('#district');
                district.html('<option value="">Pilih Kecamatan</option>');

                data.forEach(item => {
                    district.append(`
                    <option value="${item.id}">
                        ${item.name}
                    </option>
                `);
                });

                resetSelect('village');
            });
    });


    // 🔹 DISTRICT → VILLAGE
    $('#district').on('change', function() {
        let id = this.value;

        fetch(`/api/villages/${id}`)
            .then(res => res.json())
            .then(data => {
                let village = $('#village');
                village.html('<option value="">Pilih Desa</option>');

                data.forEach(item => {
                    village.append(`
                    <option value="${item.id}">
                        ${item.name}
                    </option>
                `);
                });
            });
    });


    // 🔥 HELPER RESET
    function resetSelect(id) {
        $(`#${id}`).html('<option value="">Pilih</option>');
    }


    // ==============================
    // CRUD MODAL
    // ==============================
    function CrudServices(action, id = null) {
        resetForm();
        $('#crud-action').val(action);
        const config = {
            create: {
                title: 'Tambah Service Baru',
                buttonClass: 'btn-primary',
                buttonText: 'Simpan Data <i class="ti ti-check"></i>'
            },
            update: {
                title: 'Update Service',
                buttonClass: 'btn-primary',
                buttonText: 'Update Data <i class="ti ti-check"></i>'
            },
            delete: {
                title: 'Hapus Service',
                buttonClass: 'btn-danger',
                buttonText: 'Hapus Data <i class="ti ti-x"></i>'
            }
        };
        const current = config[action];
        $('#modalTitle').text(current.title);
        $("#ErrInfo").html('');
        $('#btnSubmit')
            .removeClass('btn-primary btn-danger')
            .addClass(current.buttonClass)
            .html(current.buttonText);
        if (action === 'update' || action === 'delete') {
            getDetail(id);
        }
        $("#modal-service").modal('show');
    }


    // ==============================
    // GET DETAIL
    // ==============================
    function delay(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    async function getDetail(id) {
        try {
            const res = await fetch(`{{ url('admin/transactions/detail') }}?id=${id}`);
            const data = await res.json();
            $('#serviceForm').attr(
                'action',
                `{{ url('admin/transactions') }}/${id}`
            );

            $('#id').val(data.transaction.id);
            $('#email').val(data.transaction.email);
            $('#postal_code').val(data.transaction.postal_code);
            $('#phone').val(data.transaction.phone);
            $('#address').val(data.transaction.address);

            // Province
            $('#province')
                .val(data.transaction.province_id)
                .trigger('change');

            await delay(500);

            // City
            $('#city')
                .val(data.transaction.city_id);
            console.log('City ID : ', data.transaction.city_id);
            await delay(500);

            // District
            $('#district')
                .val(data.transaction.district_id)
                .trigger('change');

            await delay(500);

            // Village
            $('#village')
                .val(data.transaction.village_id)
                .trigger('change');

        } catch (error) {

            console.error(error);

            alert('Gagal mengambil detail transaksi');

        }
    }


    // ==============================
    // SUBMIT FORM AJAX
    // ==============================
    $('#serviceForm').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            url: `{{ route('admin.transactions.crud') }}`,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('#btnSubmit')
                    .prop('disabled', true)
                    .html('Processing...');
            },
            success: function(res) {
                console.log(res);
                $('#modal-service').modal('hide');
                showToast(res.message ?? res, 'success');
                loadServices();
            },
            error: function(xhr) {
                let message = 'Terjadi kesalahan';
                if (xhr.responseJSON) {
                    message = xhr.responseJSON.message ?? xhr.responseJSON;
                }
                console.log(xhr.responseJSON)
                $("#ErrInfo").html(`
                    <div class="alert alert-danger">
                        ${message}
                    </div>
                `);
                // showToast(message, 'error');
            },
            complete: function() {
                let action = $('#crud-action').val();
                let buttonText = 'Simpan Data';
                if (action === 'update') {
                    buttonText = 'Update Data';
                }
                if (action === 'delete') {
                    buttonText = 'Hapus Data';
                }
                $('#btnSubmit')
                    .prop('disabled', false)
                    .html(buttonText);
            }
        });
    });
</script>
@endpush