<div class="modal modal-blur fade"
    id="modal-process-transaction"
    tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form id="processTransactionForm"
                enctype="multipart/form-data"
                action=""
                method="POST">

                @csrf

                <div class="modal-header">

                    <div class="d-flex align-items-center gap-3">

                        <div id="processIcon"
                            class="avatar avatar-lg bg-primary-lt">
                            <i class="ti ti-package fs-2"></i>
                        </div>

                        <div>
                            <h3 class="modal-title mb-0" id="modalTitle">
                                Process Transaction
                            </h3>

                            <div class="text-secondary small">
                                Update status transaksi pesanan
                            </div>
                        </div>

                    </div>

                    <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <input type="hidden"
                        name="transaction_process_id"
                        id="transaction_process_id">

                    <input type="hidden"
                        id="crud-process-action"
                        name="crud-process-action">

                    <div id="ErrInfoProcess"></div>

                    <!-- Info Box -->
                    <div id="processInfo"
                        class="alert alert-info">

                        <div class="d-flex">

                            <div>
                                <i class="ti ti-info-circle me-2"></i>
                            </div>

                            <div id="processDescription">
                                Pastikan transaksi sudah siap diproses.
                            </div>

                        </div>
                    </div>

                    <!-- Optional -->
                    <div class="card bg-light border-0">
                        <div class="card-body py-3">

                            <div class="row">

                                <div class="col">
                                    <div class="text-secondary small">
                                        Transaction ID
                                    </div>
                                    <div class="fw-bold"
                                        id="transactionLabel">
                                        -
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <span id="statusBadge"
                                        class="badge bg-primary text-white">
                                        PROCESS
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button"
                        class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">
                        <i class="ti ti-x me-1"></i>
                        Cancel
                    </button>
                    <button id="btnSubmit"
                        type="submit"
                        class="btn btn-primary">
                        <i class="ti ti-check me-1"></i>
                        Submit
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>

@push('scripts')
<script>
    const processTransactionForm = $('#processTransactionForm');


    // ==============================
    // RESET FORM
    // ==============================
    function resetFormProcess() {
        processTransactionForm[0].reset();
    }
    // ==============================
    // CRUD MODAL
    // ==============================
    function CrudTransactionsProcess(action, id = null, inv) {
        resetFormProcess();
        $('#crud-process-action').val(action);
        $("#transaction_process_id").val(id);
        const config = {
            PROCESS: {
                title: 'Process Transaction',
                buttonClass: 'btn-primary',
                buttonText: 'Proces Order<i class="ti ti-check"></i>'
            },
            SHIPPING: {
                title: 'Shipping Transaction',
                buttonClass: 'btn-primary',
                buttonText: 'Send Order<i class="ti ti-check"></i>'
            },
            DONE: {
                title: 'Done Transaction',
                buttonClass: 'btn-primary',
                buttonText: 'Close Order<i class="ti ti-check"></i>'
            },

        };
        const current = config[action];
        $("#statusBadge").text(action);
        $("#transactionLabel").text(inv);
        $('#modalTitle').text(current.title);
        $("#ErrInfoProcess").html('');
        $('#btnSubmit')
            .removeClass('btn-primary btn-danger')
            .addClass(current.buttonClass)
            .html(current.buttonText);
        $("#modal-process-transaction").modal('show');
    }

    // ==============================
    // SUBMIT FORM AJAX
    // ==============================
    $('#processTransactionForm').on('submit', function(e) {
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
                $('#modal-process-transaction').modal('hide');
                showToast(res.message ?? res, 'success');
                loadTransactions();
            },
            error: function(xhr) {
                let message = 'Terjadi kesalahan';
                if (xhr.responseJSON) {
                    message = xhr.responseJSON.message ?? xhr.responseJSON;
                }
                console.log(xhr.responseJSON)
                $("#ErrInfoProcess").html(`
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