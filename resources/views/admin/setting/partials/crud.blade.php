<div class="modal modal-blur fade" id="modal-setting" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="settingForm" enctype="multipart/form-data" action="" method="POST">
                @csrf
                <div id="methodField"></div>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Setting Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <input type="text" name="id" id="id" class="form-control" placeholder="ID setting" hidden>
                            <div class="mb-3">
                                <label class="form-label">Key</label>
                                <input type="text" name="key" id="key" class="form-control" placeholder="Input nama setting">
                            </div>

                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Value</label>
                                <input type="text" name="values" id="values" class="form-control" placeholder="Input value setting">
                            </div>
                        </div>

                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="remarks" id="remarks" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Logo</label>
                        <input type="file" name="images" id="images">
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
    const settingForm = $('#settingForm');


    // ==============================
    // RESET FORM
    // ==============================
    function resetForm() {
        settingForm[0].reset();
    }


    // ==============================
    // CRUD MODAL
    // ==============================
    function CrudSettings(action, id = null) {
        resetForm();
        $('#crud-action').val(action);
        const config = {
            create: {
                title: 'Tambah setting Baru',
                buttonClass: 'btn-primary',
                buttonText: 'Simpan Data <i class="ti ti-check"></i>'
            },
            update: {
                title: 'Update setting',
                buttonClass: 'btn-primary',
                buttonText: 'Update Data <i class="ti ti-check"></i>'
            },
            delete: {
                title: 'Hapus setting',
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
        $("#modal-setting").modal('show');
    }


    // ==============================
    // GET DETAIL
    // ==============================
    function getDetail(id) {
        fetch(`{{ url('admin/settings/detail') }}?id=${id}`)
            .then(res => res.json())
            .then(data => {
                $('#settingForm').attr(
                    'action',
                    `{{ url('admin/settings') }}/${id}`
                );
                $('#id').val(data.setting.id);
                $('#key').val(data.setting.key);
                $('#values').val(data.setting.values);
                $('#remarks').val(data.setting.remarks);
            });
    }


    // ==============================
    // SUBMIT FORM AJAX
    // ==============================
    $('#settingForm').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            url: `{{ route('admin.settings.crud') }}`,
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
                $('#modal-setting').modal('hide');
                showToast(res.message ?? res, 'success');
                loadSettings();
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