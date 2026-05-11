<div class="modal modal-blur fade" id="modal-product" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="productForm" enctype="multipart/form-data" action="" method="POST">
                @csrf
                <div id="methodField"></div>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Produk Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <input type="text" name="id" id="id" class="form-control" placeholder="ID Produk" hidden>
                            <div class="mb-3">
                                <label class="form-label">Nama Produk</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Input nama produk">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <select name="category" id="category" class="form-select">
                                    <option value="Laptop">Laptop</option>
                                    <option value="Aksesoris">Aksesoris</option>
                                    <option value="Software">Software</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Harga (Rp)</label>
                                <input type="number" name="price" id="price" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Discount</label>
                                <input type="number" name="discount" id="discount" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Cover Image </label>
                                <input type="file" name="cover_image" id="cover_image" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Badge</label>
                                <select name="badge" id="badge" class="form-select">
                                    <option value="">Normal</option>
                                    <option value="Hot">Hot</option>
                                    <option value="New">New</option>
                                    <option value="Sale">Sale</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Spesifikasi (Array)</label>
                        <button type="button" class="btn btn-sm mb-1 btn-secondary add-spec">Tambah Spesifikasi</button>
                        <div id="spec-wrapper">
                            <div class="input-group mb-2">
                                <input type="text" name="spesification[]" class="form-control" placeholder="Contoh: RAM 16GB">
                                <button type="button" class="btn btn-danger remove-spec">-</button>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="upload-wrapper" id="preview-container">
                            <!-- tombol upload -->
                            <label class="upload-box" id="uploadButton">
                                <input type="file" name="images[]" id="imageUpload" multiple accept="image/*">
                                <span class="upload-placeholder">+</span>
                            </label>
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
    const productForm = $('#productForm');
    const specWrapper = $('#spec-wrapper');
    const modalProduct = $('#modal-product');


    // ==============================
    // SPECIFICATION
    // ==============================
    function createSpecInput(value = '') {
        return `<div class="input-group mb-2">
            <input type="text" name="spesification[]" class="form-control"
                value="${value}"> <button  type="button"  class="btn btn-danger remove-spec"
            > - </button></div>`;
    }

    function resetSpec() {
        specWrapper.html(createSpecInput());
    }

    function loadSpecifications(specifications = []) {
        specWrapper.html('');
        specifications.forEach(spec => {
            specWrapper.append(createSpecInput(spec));
        });
        // jika kosong
        if (specifications.length === 0) {
            resetSpec();
        }
    }

    // ==============================
    // LOAD CATEGORIES
    // ==============================
    function loadCategories() {
        fetch(`{{ route('admin.products.loadcategory') }}`)
            .then(res => res.json())
            .then(categories => {
                $('#category').html('');
                categories.forEach(category => {
                    $('#category').append(`
                        <option value="${category.id}">
                            ${category.name_category}
                        </option>
                    `);
                });
            });
    }

    loadCategories()

    // ==============================
    // EVENT SPEC
    // ==============================
    $(document).on('click', '.add-spec', function() {
        specWrapper.append(createSpecInput());
    });

    $(document).on('click', '.remove-spec', function() {
        $(this).closest('.input-group').remove();
    });

    // ==============================
    // GLOBAL FILE STORAGE
    // ==============================

    let selectedFiles = [];


    // ==============================
    // IMAGE UPLOAD PREVIEW
    // ==============================
    $('#imageUpload').on('change', function(e) {
        let files = Array.from(e.target.files);
        files.forEach(file => {
            // simpan ke array global
            selectedFiles.push(file);
            let reader = new FileReader();
            reader.onload = function(event) {
                let index = selectedFiles.length - 1;
                $('#uploadButton').before(`
                <div class="preview-item" data-index="${index}">
                    <img src="${event.target.result}">
                    <button 
                        type="button" 
                        class="remove-image"
                    >
                        &times;
                    </button>
                </div>
            `);
            };
            reader.readAsDataURL(file);
        });

        // reset input supaya bisa pilih file lagi
        $(this).val('');
    });

    $(document).on('click', '.remove-image', function() {
        let preview = $(this).closest('.preview-item');
        let index = preview.data('index');
        // hapus dari array
        selectedFiles[index] = null;
        preview.remove();
    });


    // ==============================
    // RESET FORM
    // ==============================
    function resetForm() {
        productForm[0].reset();
        $('#methodField').html('');
        resetSpec();
        $('.preview-item').remove();
    }


    // ==============================
    // CRUD MODAL
    // ==============================
    function CrudProducts(action, id = null) {
        resetForm();
        $('#crud-action').val(action);
        const config = {
            create: {
                title: 'Tambah Produk Baru',
                buttonClass: 'btn-primary',
                buttonText: 'Simpan Data <i class="ti ti-check"></i>'
            },
            update: {
                title: 'Update Produk',
                buttonClass: 'btn-primary',
                buttonText: 'Update Data <i class="ti ti-check"></i>'
            },
            delete: {
                title: 'Hapus Produk',
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
        modalProduct.modal('show');
    }


    // ==============================
    // GET DETAIL
    // ==============================
    function getDetail(id) {
        fetch(`{{ url('admin/products/detail') }}?id=${id}`)
            .then(res => res.json())
            .then(data => {
                $('#productForm').attr(
                    'action',
                    `{{ url('admin/products') }}/${id}`
                );
                $.each(data.images, function(_, image) {
                    $('#uploadButton').before(`
                    <div class="preview-item">
                        <img src="{{ url('') }}/${image.path}">
                        <input 
                            type="text" 
                            name="old_images[]"
                            value="${image.id}"
                        >
                        <button type="button" class="remove-image">
                            &times;
                        </button>
                    </div>`);
                });

                $('#id').val(data.product.id);
                $('#name').val(data.product.name);
                $('#category').val(data.product.category);
                $('#price').val(data.product.price);
                $('#discount').val(data.product.discount);
                $('#badge').val(data.product.badge);
                $('#description').val(data.product.description);
                loadSpecifications(data.product.spesification);
            });
    }


    // ==============================
    // SUBMIT FORM AJAX
    // ==============================
    $('#productForm').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        // append semua image manual
        selectedFiles.forEach(file => {
            if (file !== null) {
                formData.append('images[]', file);
            }
        });
        $.ajax({
            url: `{{ route('admin.products.crud') }}`,
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
                $('#modal-product').modal('hide');
                selectedFiles = [];
                // showToast(res.message ?? res, 'success');
                loadProducts();
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