<?php $this->load->view('layouts/v_header') ?>
<section class="content-header">
    <h1>
        Data Menu
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-shopping-bag"></i> Menu</a></li>
        <li class="active">Data Menu</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <div class="btn-group">
                        <a href="#" class="btn btn-success" data-toggle="modal" data-target="#productModal"><i class="fa fa-plus-circle"></i> Tambah</a>
                    </div>
                </div>
                <div class="box-body">
                    <table id="product" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="10px" class="text-center">No</th>
                                <th width="150px">Gambar</th>
                                <th>Menu</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Deskripsi</th>
                                <th width='125px' class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="productModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?= base_url() ?>products/lists/store" id="productForm" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Tambah Menu</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Gambar</label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control" id="imageInput" name="imageInput">
                                    <img alt="" class="d-none" id="imageShow" width="100" style="margin-top: 1em;">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Menu</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="productNameInput" name="productNameInput" autcomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Harga</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-addon">Rp.</div>
                                        <input type="text" class="form-control" name="priceInput" id="priceInput" placeholder="0" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Diskon</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="discountInput" id="discountInput" placeholder="0" autocomplete="off">
                                        <div class="input-group-addon">%</div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Kategori</label>
                                <div class="col-sm-9">
                                    <select name="categoryIdInput" id="categoryIdInput" class="form-control" style="width: 100%;">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Deskripsi</label>
                                <div class="col-sm-9">
                                    <textarea name="descriptionInput" id="descriptionInput" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                    <button type="submit" class="btn btn-primary" id="submitProduct"><i class="fa fa-check-circle"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $this->load->view('layouts/v_footer') ?>
<script>
    $(function() {
        function generateCurrency(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
        }

        function currencyFormatRupiah(elemValue) {
            return $(elemValue).val(generateCurrency($(elemValue).val(), 'Rp. '))
        }
        $(document).on('keyup', '#priceInput', function(e) {
            currencyFormatRupiah(this)
        })
        $('body').on('click', '.delete-product', function() {
            let trParents = $(this).parents().parents().closest('tr')
            let dataName = trParents.find('td:eq(2)').text()
            swal({
                title: "Apakah kamu yakin?",
                text: `Menu ${dataName} akan dihapus?`,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((confirmDelete) => {
                if (confirmDelete) {
                    let id = $(this).attr('data-id')
                    $.ajax({
                        url: `<?= base_url() ?>products/lists/delete/${id}`,
                        type: 'DELETE',
                        dataType: 'json',
                        success: function(response) {
                            if (response.status == true) {
                                swal({
                                    title: "Berhasil!",
                                    text: response.message,
                                    icon: "success",
                                }).then(function() {
                                    tableProduct.ajax.reload();
                                });
                            } else {
                                swal({
                                    title: "Gagal!",
                                    text: response.message,
                                    icon: "error",
                                })
                            }
                        }
                    })
                }
            });
        })

        function loadCategory() {
            $('#categoryIdInput').select2({
                placeholder: "-- Pilih --",
                allowClear: true
            })
            $.ajax({
                url: '<?= base_url() ?>products/lists/loadCategory',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status == true) {
                        $('#categoryIdInput').prop('disabled', false)
                        response.data.forEach((e, i) => {
                            $('#categoryIdInput').append(`<option value="${e.id}">${e.name}</option>`)
                        })
                    } else {
                        $('#categoryIdInput').prop('disabled', true)
                    }
                }
            })
        }

        let tableProduct = $('#product').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            },
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url() ?>products/lists/getProduct",
                "type": "POST"
            },
            "columnDefs": [{
                    "targets": [0],
                    "orderable": false,
                },
                {
                    "targets": [6],
                    "orderable": false,
                },
            ],
        });

        loadCategory()

        $('#productModal').on('shown.bs.modal', function(e) {
            let button = $(e.relatedTarget)
            let trParents = button.parents().parents().closest('tr')
            let modal = $(this)
            let mode = button.data('mode')
            let barcode = trParents.find('td:eq(1)').text()
            let name = trParents.find('td:eq(2)').text()

            // let h_modal = trParents.find('td:eq(4)').text().split('%')
            let jual = trParents.find('td:eq(4)').text().split('Rp.')
            let id = button.data('id')

            let kategori = $(button).data('categories_id')
            let description = $(button).data('description')
            let image = $(button).data('image')

            modal.find('#productNameInput').focus()

            if (mode == 'edit') {
                modal.find('.modal-title').html(`Edit Menu : <b>${name}</b>`)
                $('#productForm').attr('action', `<?= base_url() ?>products/lists/edit/${id}`)
                modal.find('#productNameInput').val(name)
                modal.find('#priceInput').val(jual[1].trim())

                modal.find('#categoryIdInput').val(kategori).trigger('change')
                modal.find('#descriptionInput').val(description).trigger('change')

                modal.find('#imageShow').removeClass('d-none')
                modal.find('#imageShow').attr('src', image)

                modal.find('#submitProduct').attr('class', 'btn btn-warning')
                modal.find('#submitProduct').html(`<i class="fa fa-edit"></i> Update`)
            } else {
                modal.find('.modal-title').text('Tambah Menu')
                $('#productForm').attr('action', '<?= base_url() ?>products/lists/store')
                modal.find('#barcodeInput').val('')
                modal.find('#productNameInput').val('')
                modal.find('#priceInput').val('')
                modal.find('#categoryIdInput').val('').trigger('change')
                modal.find('#descriptionInput').val('')

                modal.find('#imageShow').addClass('d-none')
                modal.find('#imageShow').attr('src', '')

                modal.find('#submitProduct').attr('class', 'btn btn-primary')
                modal.find('#submitProduct').html(`<i class="fa fa-check-circle"></i> Simpan`)
            }
        })

        $('#productForm').validate({
            rules: {
                imageInput: {
                    required: true
                },
                productNameInput: {
                    required: true
                },
                priceInput: {
                    required: true
                },
                categoryIdInput: {
                    required: true
                },
                unitProductInput: {
                    required: true
                },
                descriptionInput: {
                    required: true
                },
            },
            messages: {
                imageInput: {
                    required: "Gambar harus diisi"
                },
                productNameInput: {
                    required: "Nama harus diisi"
                },
                priceInput: {
                    required: "Harga jual harus diisi"
                },
                categoryIdInput: {
                    required: "Kategori harus diisi"
                },
                descriptionInput: {
                    required: "Deskripsi harus diisi"
                },
            },
            errorPlacement: function (error, element) {
                if (element.parent().hasClass('input-group')) {
                    error.insertAfter(element.parent())
                } else {
                    error.insertAfter(element)
                }
            },
            highlight: function (element, errorClasss) {
                $(element).removeClass(errorClasss)
            },
        })

        function checkPrice(value) {
            if (typeof value == "string") {
                let final = 0;
                for (let i = 0; i < value.length; i++) {
                    if (value[i] != "." && value[i] != ",") {
                        final = (final * 10) + parseInt(value[i]);
                    }
                }
                return final;
            } else {
                return value;
            }
        }
        $('#productForm').on('submit', function (e) {
            e.preventDefault()
            let action = $(this).attr('action')
            $.ajax({
                url: action,    
                type: 'POST',
                enctype: 'multipart/form-data',
                data: new FormData(this),
                processData:false,
                contentType:false,
                cache:false,
                async:false,
                success: function(response) {
                    $response = JSON.parse(response)
                    if ($response.status == true) {
                        $('#productModal').modal('hide')
                        setTimeout(() => {
                            swal({
                                title: "Berhasil!",
                                text: $response.message,
                                icon: "success",
                            }).then(function() {
                                tableProduct.ajax.reload();
                            });
                        }, 350)
                    }
                }
            })
        })
    })
</script>