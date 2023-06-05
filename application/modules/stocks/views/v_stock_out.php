<?php $this->load->view('layouts/v_header') ?>
<section class="content-header">
    <h1>
        Data Stok Keluar
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-external-link"></i> Stok</a></li>
        <li class="active">Keluar</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <div class="btn-group">
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-mode="tambah" data-target="#stock_outModal"><i class="fa fa-plus-circle"></i> Tambah</a>
                    </div>
                </div>
                <div class="box-body">
                    <table id="stock_out" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="10px" class="text-center">No</th>
                                <th>Tanggal</th>
                                <th>Barcode</th>
                                <th>Nama Produk</th>
                                <th>Stok Keluar</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="stock_outModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="stock_outForm" method="POST" action="<?= base_url() ?>stocks/out/store">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Tambah Stok Keluar</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Tanggal <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <div class="input-group date">
                                <input type="datetime-local" name="date" class="form-control" id="datepicker">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Barcode <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="hidden" class="form-control" id="stock_ins_id" name="stock_ins_id">
                                <input type="hidden" class="form-control" id="products_id" name="products_id">
                                <input type="text" class="form-control" id="barcodeStock" readonly name="barcodeStock">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-info btn-flat btn-search" data-toggle="modal" data-target="#data_product_modal"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Nama Produk</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="products_name" readonly name="products_name">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Jumlah (Stok) <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" class="form-control" name="total" id="total" placeholder="0" autocomplete="off">
                                <span class="input-group-btn input-group-max-stock">
                                    <button type="button" class="btn btn-default max-stock" style="pointer-events: none;">Maks stok</button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Keterangan</label>
                        <div class="col-sm-9">
                            <select name="description" id="description" class="form-control">
                                <option value="Hilang">Hilang</option>
                                <option value="Rusak">Rusak</option>
                                <option value="Kadaluarsa">Kadaluarsa</option>
                                <option value="Lain Lain">Lain Lain</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                    <button type="submit" class="btn btn-primary" id="stock_outIncome"><i class="fa fa-check-circle"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="data_product_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pilih Produk</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="product_modal" class="table table-bordered table-striped" width="100%">
                        <thead>
                            <tr>
                                <th width="10px" class="text-center">No</th>
                                <th>Barcode</th>
                                <th>Nama</th>
                                <th>Satuan</th>
                                <th>Harga</th>
                                <th width='120px'>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="stockProductModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Daftar Stok Produk <span class="stockProductName"></span></h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="tableStockProduct" class="table table-bordered table-striped table-hovered" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Stok</th>
                                <th>Expired Date</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
            </div>
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

        function sweetalert(title, text, icon) {
            swal({
                title: title,
                text: text,
                icon: icon,
            })
        }

        function currencyFormatRupiah(elemValue) {
            return $(elemValue).val(generateCurrency($(elemValue).val(), 'Rp. '))
        }
        
        let globalProductId = 0

        let tableSearchProduct = $('#product_modal').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            },
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url() ?>products/lists/getSearchProduct",
                "type": "POST"
            },
            "columnDefs": [{
                "targets": [0],
                "orderable": false,
            },
            {
                "targets": [5],
                "className": "text-center"
            }],
        });

        let tableStockProduct = $('#tableStockProduct').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            },
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url() ?>products/lists/getStockProduct",
                "type": "POST",
                "data": function (data) {
                    data.products_id = globalProductId
                }

            },
            "columnDefs": [{
                "targets": [0],
                "orderable": false,
            },
            {
                "targets": [6],
                "className": "text-center"
            }],
        });

        $('#stock_outModal').on('keypress', function(e) {
            if (e.which == 13) {
                return false
            }
        })
        let tableStock_out = $('#stock_out').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            },
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url() ?>stocks/out/getStock_out",
                "type": "POST"
            },
            "columnDefs": [{
                "targets": [0],
                "orderable": false,
            },],
        });
        $(document).on('keyup', '#total', function(e) {
            currencyFormatRupiah(this)
        })

        function cleanVal() {
            $('#datepicker').val('')
            $('#stock_ins_id').val('')
            $('#products_id').val('')
            $('#barcodeStock').val('')
            $('#products_name').val('')
            $('#products_name').val('')
            $('input[name=total]').val('')
            $('#description').val('')
            $('.stockProductName')
            $('.input-group-max-stock').addClass('d-none')
        }

        function checkQtyMax(elemenValue, max) {
            if (parseFloat($(elemenValue).val()) > parseFloat(max)) {
                sweetalert("Maaf!", 'Maaf anda melebihi batas stok', "error")
                return $(elemenValue).val(max)
            } else {
                return false
            }
        }

        $('.input-group-max-stock').addClass('d-none')

        $('body').on('click', '.selectProduct', function(e) {
            e.preventDefault();

            let productId = $(this).data('idproduct')
            let nama = $(this).data('name')

            globalProductId = productId
            tableStockProduct.draw()
            $('.stockProductName').html(`<b> - ${nama}</b>`)
            $('#data_product_modal').modal('hide')
            $('#stockProductModal').modal('show')
        })

        $('body').on('click', '.selectStockProduct', function (e) {
            let productId = $(this).data('idproduct')
            let id = $(this).data('id')
            let barcode = $(this).data('barcode')
            let name = $(this).data('name')
            let capital = $(this).data('capital')
            let selling = $(this).data('selling')
            let total = $(this).data('total')
            let unit = $(this).data('unit')

            if (total == 0) {
                sweetalert("Maaf!", 'Maaf stok habis!', "error")
            } else {
                $('#stock_ins_id').val(id)
                $('#products_id').val(productId)
                $('#barcodeStock').val(barcode)
                $('#products_name').val(name)
                $('#total').attr('max', total)
    
                $('.input-group-max-stock').removeClass('d-none')
                $('.max-stock').html(`<b>Maks stok : ${total} (${unit})</b>`)
                $('#stockProductModal').modal('hide')
            }
        })

        $('#total').on('keyup change', function(e) {
            e.preventDefault()
            checkQtyMax(this, $(this).attr('max'))
        })

        let config = {
            enableTime: true,
            dateFormat: "d-m-Y H:i"
        }
        const fp = flatpickr("#datepicker", config)

        $('#stock_outModal').on('show.bs.modal', function(e) {

            cleanVal()
            let button = $(e.relatedTarget)
            let modal = $(this)

            modal.find('#stock_outIncome').attr('class', 'btn btn-primary')
            modal.find('#stock_outIncome').html(`<i class="fa fa-check-circle"></i> Simpan`)
        })

        $('#stock_outForm').validate({
            rules: {
                date: {
                    required: true
                },
                products_name: {
                    required: true
                },
                description: {
                    required: true
                },
            },
            messages: {
                date: {
                    required: "Tanggal harus diisi"
                },
                products_name: {
                    required: "Nama produk harus diisi"
                },
                description: {
                    required: "Keterangan harus diisi"
                }
            }
        })

        $(document).on('submit', '#stock_outForm', function(e) {
            e.preventDefault()

            let action = $(this).attr('action')
            if ($('#products_id').val() == '') {
                swal({
                    title: "Maaf!",
                    text: "Item Produk Belum Diisi!",
                    icon: "error",
                })
            } else {
                $.ajax({
                    url: action,
                    type: 'POST',
                    data: $('#stock_outForm').serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == true) {
                            $('#stock_outModal').modal('hide')
                            swal({
                                title: "Berhasil!",
                                text: response.message,
                                icon: "success",
                            }).then(function() {
                                tableStock_out.ajax.reload();
                                tableSearchProduct.ajax.reload()
                            });
                        }
                    }
                })
            }
        })
    })
</script>