<div class="modal modal-blur fade" id="modal-users" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="usersForm" enctype="multipart/form-data" action="" method="POST">
                <div id="methodField"></div>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Users Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <input type="text" name="id" id="id" class="form-control" placeholder="ID Service" hidden>
                            <div class="mb-3">
                                <label class="form-label">User Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Input username">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="text" name="email" id="email" class="form-control" placeholder="Input email">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="number" name="phone" id="phone" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">Pilih Status</option>
                                    <option value="ACTIVE">Active</option>
                                    <option value="INACTIVE">Inactive</option>
                                    <option value="BLOCKED">Blocked</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="mb-3 password-label">

                    </div>

                    <div class="mb-3">
                        <label class="form-label">As Admin</label>
                        <input type="checkbox" name="is_admin" id="is_admin">
                    </div>


                    <input type="text" id="crud-action" hidden name="crud-action">
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
    const usersForm = $('#usersForm');



    // ==============================
    // RESET FORM
    // ==============================
    function resetForm() {
        usersForm[0].reset();
    }


    // ==============================
    // CRUD MODAL
    // ==============================
    function CrudUsers(action, id = null) {
        resetForm();
        $('#crud-action').val(action);
        const config = {
            create: {
                title: 'Tambah User Baru',
                buttonClass: 'btn-primary',
                buttonText: 'Simpan Data <i class="ti ti-check"></i>'
            },
            update: {
                title: 'Update User',
                buttonClass: 'btn-primary',
                buttonText: 'Update Data <i class="ti ti-check"></i>'
            },
            delete: {
                title: 'Hapus User',
                buttonClass: 'btn-danger',
                buttonText: 'Hapus Data <i class="ti ti-x"></i>'
            },
            updated_pwd: {
                title: 'Update Password',
                buttonClass: 'btn-warning',
                buttonText: 'Update Password <i class="ti ti-check"></i>'
            }
        };
        const current = config[action];
        $('#modalTitle').text(current.title);
        $("#ErrInfo").html('');
        $('#btnSubmit')
            .removeClass('btn-primary btn-danger btn-warning')
            .addClass(current.buttonClass)
            .html(current.buttonText);
        if (action === 'update' || action === 'delete' || action === "updated_pwd") {
            getDetail(id);
            if (action === "updated_pwd") {
                // disable semua input di dalam form
                usersForm.find('select').prop('disabled', true);
                usersForm.find('input, textarea').prop('readonly', true);
                $(".password-label").html(`<label class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Input password">`);
            } else {
                // enable semua input di dalam form
                usersForm.find('select').prop('disabled', false);
                usersForm.find('input,  textarea').prop('readonly', false);
                $(".password-label").html(``);
            }
        } else if (action === "create") {
            $(".password-label").html(`<label class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Input password">`);
        }


        $("#modal-users").modal('show');
    }


    // ==============================
    // GET DETAIL
    // ==============================
    function getDetail(id) {
        fetch(`{{ url('admin/users/detail') }}?id=${id}`)
            .then(res => res.json())
            .then(data => {
                $('#usersForm').attr(
                    'action',
                    `{{ url('admin/users') }}/${id}`
                );
                $('#id').val(data.user.id);
                $('#name').val(data.user.name);
                $('#email').val(data.user.email);
                $('#phone').val(data.user.phone);
                $('#status').val(data.user.status);
                $("#is_admin").prop('checked', data.user.is_admin);
            });
    }


    // ==============================
    // SUBMIT FORM AJAX
    // ==============================
    $('#usersForm').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        console.log(formData);
        $.ajax({
            url: `{{ route('admin.users.crud') }}`,
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
                $('#modal-users').modal('hide');
                showToast(res.message ?? res, 'success');
                loadUsers();
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