<div class="modal modal-blur fade" id="modal-service" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="transactionForm" enctype="multipart/form-data" action="" method="POST">
                @csrf
                <div id="methodField"></div>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Transaction Baru</h5>
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
    const transactionForm = $('#transactionForm');


    // ==============================
    // RESET FORM
    // ==============================
    function resetForm() {
        transactionForm[0].reset();
    }

    async function loadProvinces(selectedProvince = null) {
        let response = await fetch('/api/provinces');
        let data = await response.json();
        let province = $('#province');
        province.html('<option value="">Pilih Provinsi</option>');
        data.forEach(item => {
            province.append(`
            <option value="${item.id}">
                ${item.name}
            </option>
        `);
        });
        if (selectedProvince) {
            province.val(selectedProvince);
        }
    }

    async function loadCities(provinceId, selectedCity = null) {
        if (!provinceId) return;
        let response = await fetch(`/api/cities/${provinceId}`);
        let data = await response.json();
        let city = $('#city');
        city.html('<option value="">Pilih Kota</option>');

        data.forEach(item => {
            city.append(`
            <option value="${item.id}">
                ${item.name}
            </option>
        `);
        });

        if (selectedCity) {
            city.val(selectedCity);
        }
    }

    // 🔹 PROVINCE → CITY
    $('#province').on('change', async function() {
        let provinceId = this.value;
        await loadCities(provinceId);
        resetSelect('district');
        resetSelect('village');
    });


    // =============================
    // LOAD DISTRICTS
    // =============================
    async function loadDistricts(cityId, selectedDistrict = null) {

        let district = $('#district');

        district.html('<option value="">Loading...</option>');

        resetSelect('village');

        if (!cityId) {
            district.html('<option value="">Pilih Kecamatan</option>');
            return;
        }

        try {

            let response = await fetch(`/api/districts/${cityId}`);

            if (!response.ok) {
                throw new Error('Failed load districts');
            }

            let data = await response.json();

            district.html('<option value="">Pilih Kecamatan</option>');

            data.forEach(item => {
                district.append(`
                <option value="${item.id}">
                    ${item.name}
                </option>
            `);
            });

            // AUTO SELECT
            if (selectedDistrict) {
                district
                    .val(selectedDistrict)
                    .trigger('change');
            }

        } catch (error) {

            console.error(error);

            district.html(`
            <option value="">
                Gagal load kecamatan
            </option>
        `);
        }
    }


    // =============================
    // LOAD VILLAGES
    // =============================
    async function loadVillages(districtId, selectedVillage = null) {
        let village = $('#village');
        village.html('<option value="">Loading...</option>');
        if (!districtId) {
            village.html('<option value="">Pilih Desa</option>');
            return;
        }
        try {
            let response = await fetch(`/api/villages/${districtId}`);
            if (!response.ok) {
                throw new Error('Failed load villages');
            }
            let data = await response.json();
            village.html('<option value="">Pilih Desa</option>');
            data.forEach(item => {
                village.append(`
                <option value="${item.id}">
                    ${item.name}
                </option>
            `);
            });
            // AUTO SELECT
            if (selectedVillage) {
                village
                    .val(selectedVillage)
                    .trigger('change');
            }
        } catch (error) {

            console.error(error);

            village.html(`
            <option value="">
                Gagal load desa
            </option>
        `);
        }
    }


    // =============================
    // CITY CHANGE
    // =============================
    $('#city').on('change', async function() {
        let cityId = this.value;
        await loadDistricts(cityId);
    });


    // =============================
    // DISTRICT CHANGE
    // =============================
    $('#district').on('change', async function() {
        let districtId = this.value;
        await loadVillages(districtId);
    });


    // 🔥 HELPER RESET
    function resetSelect(id) {
        $(`#${id}`).html('<option value="">Pilih</option>');
    }


    // ==============================
    // CRUD MODAL
    // ==============================
    function CrudTransactions(action, id = null) {
        resetForm();
        $('#crud-action').val(action);
        const config = {
            create: {
                title: 'Tambah Transaction Baru',
                buttonClass: 'btn-primary',
                buttonText: 'Simpan Data <i class="ti ti-check"></i>'
            },
            update: {
                title: 'Update Transaction',
                buttonClass: 'btn-primary',
                buttonText: 'Update Data <i class="ti ti-check"></i>'
            },
            delete: {
                title: 'Hapus Transaction',
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
            $('#serviceForm')
                .find('input, textarea')
                .prop('readonly', true);

            $('#serviceForm')
                .find('select')
                .prop('disabled', true);
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

            await loadProvinces(data.transaction.province_id);
            await loadCities(
                data.transaction.province_id,
                data.transaction.city_id
            );

            await loadDistricts(
                data.transaction.city_id,
                data.transaction.district_id
            );

            await loadVillages(
                data.transaction.district_id,
                data.transaction.village_id
            );

            // // City
            // $('#city')
            //     .val(data.transaction.city_id);
            // console.log('City ID : ', data.transaction.city_id);
            // await delay(500);

            // // District
            // $('#district')
            //     .val(data.transaction.district_id)
            //     .trigger('change');

            // await delay(500);

            // // Village
            // $('#village')
            //     .val(data.transaction.village_id)
            //     .trigger('change');

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