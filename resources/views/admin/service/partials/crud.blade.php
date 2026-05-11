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
                    <div class="row">
                        <div class="col-lg-6">
                            <input type="text" name="id" id="id" class="form-control" placeholder="ID Service" hidden>
                            <div class="mb-3">
                                <label class="form-label">Nama Service</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Input nama service">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Ikon</label>
                                <select name="icon" id="icon" class="form-control">
                                    <option value="">Pilih Ikon</option>
                                </select>
                                <div class="mt-2">
                                    Preview:
                                    <i id="iconPreview" class="ti ti-home"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Harga (Rp)</label>
                                <input type="number" name="price" id="price" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="is_active" id="is_active" class="form-control">
                                    <option value="">Pilih Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" id="description" class="form-control" rows="3"></textarea>
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
    // LIST ICONS
    // ==============================
    const icons = [
        "ti-home", "ti-user", "ti-settings", "ti-shopping-cart",
        "ti-package", "ti-building-store", "ti-truck", "ti-credit-card",
        "ti-wallet", "ti-cup", "ti-gift", "ti-camera", "ti-device-desktop", "ti-device-mobile", "ti-headphones", "ti-light-bulb", "ti-palette",
        "ti-shield-lock", "ti-database-import", "ti-tools", "ti-cloud-upload", "ti-chart-bar", "ti-printer"
    ];
    const select = document.getElementById('icon');
    select.innerHTML = icons.map(icon => `
        <option value="${icon}">
            ${icon}
        </option>
    `).join('');
    const preview = document.getElementById('iconPreview');
    select.addEventListener('change', function() {
        preview.className = 'ti ' + this.value;
    });


    // ==============================
    // RESET FORM
    // ==============================
    function resetForm() {
        serviceForm[0].reset();
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
    function getDetail(id) {
        fetch(`{{ url('admin/services/detail') }}?id=${id}`)
            .then(res => res.json())
            .then(data => {
                $('#serviceForm').attr(
                    'action',
                    `{{ url('admin/services') }}/${id}`
                );
                $('#id').val(data.service.id);
                $('#name').val(data.service.name);
                $('#price').val(data.service.price);
                $('#icon').val(data.service.icon).trigger('change');
                $('#is_active')
                    .val(data.service.is_active ? '1' : '0')
                    .trigger('change');
                $('#description').val(data.service.description);
            });
    }


    // ==============================
    // SUBMIT FORM AJAX
    // ==============================
    $('#serviceForm').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            url: `{{ route('admin.services.crud') }}`,
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