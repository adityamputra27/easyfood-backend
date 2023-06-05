<?php $this->load->view('layouts/v_header') ?>
<section class="content-header">
    <h1>
        Transaksi Menu
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-shopping-cart"></i> Transaksi</a></li>
        <li class="active">Menu</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group row">
                                <label for="" class="col-sm-1 col-form-label">Menu</label>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="menu" autocomplete="off" readonly>
                                        <input type="hidden" class="form-control" id="foods_id">
                                        <input type="hidden" class="form-control" id="food_name">
                                        <input type="hidden" class="form-control" id="price">

                                        <span class="input-group-btn">
                                            <button type="button" id="searchProduct" class="btn btn-info btn-flat"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-1 col-form-label">QTY</label>
                                <div class="col-sm-2">
                                    <input type="number" class="form-control text-center" id="quantity" name="quantity" autocomplete="off" placeholder="0" min="0" disabled>
                                </div>
                            </div>
                            <div class="btn-transactions">
                                <button tabindex="3" class="btn btn-success" type="button" id="addTransaction"><i class="fa fa-plus"></i> Tambah</button>&nbsp;
                                <button tabindex="4" class="btn btn-primary" type="button" id="btn_payment"><i class="fa fa-floppy-o"></i> Bayar</button>&nbsp;
                                <button tabindex="5" class="btn btn-info" type="button" onclick="location.reload()"><i class="fa fa-file-o"></i> Transaksi Baru</button>&nbsp;
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div style="display: flex; justify-content: end;">
                                <label for="" style="padding-top: 5px;">Kode :</label>
                                <input type="text" class="text-bold text-right" readonly style="width: 60px; font-size: 17px; background-color: rgba(0,0,0,0) !important; border: 0 !important;" id="code" name="code" value="<?= $code ?>">
                            </div>
                            <p style="font-size: 60px; display: flex; justify-content: end;"><b>Rp. </b><b id="totalPrice"> 0</b></p>
                            <input type="hidden" id="total_bayar">
                        </div>
                    </div>
                    <table id="productTransaction" class="table table-bordered table-striped" style="margin-top: 2em;">
                        <thead class="text-center">
                            <tr>
                                <th width="10px" class="text-center">No</th>
                                <th width="400px;">Nama Menu</th>
                                <th width="170px;">Harga</th>
                                <th width="80px;">Quantity</th>
                                <th width="170px;">Total</th>
                                <th width='50px' class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr align="center">
                                <td colspan="8">Tidak ada item menu!</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="searchProductModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Daftar Menu</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="tableSearchProduct" class="table table-bordered table-striped table-hovered">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Menu</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
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

    <div class="modal fade" id="payModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Transaksi Pembayaran</h4>
                </div>
                <form action="<?= base_url() ?>transactions/create/store" method="POST" id="payForm">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="" class="col-sm-4 col-form-label">Pilih Meja <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <select name="tables_id" id="tables_id" class="form-control" style="width: 100%;">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-4 col-form-label">Tanggal <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <div class="input-group date">
                                            <input type="text" class="form-control datepicker" autocomplete="off" name="date_modal" id="date_modal" data-provide="datepicker" value="   <?= date('Y-m-d  H:i:s') ?>">
                                            <div class="input-group-addon">
                                                <span class="fa fa-calendar"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-4 col-form-label">Kode</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="code" name="code" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-4 col-form-label">Jumlah Bayar <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <div class="input-group-addon">Rp</div>
                                            <input type="text" class="form-control total_cash" name="total_cash" pattern="[0-9]+" placeholder="0" id="totalCash" placeholder="0" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="" class="col-sm-4 col-form-label">Pilih Pelanggan <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <select name="customers_id" id="customers_id" class="form-control" style="width: 100%;">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-4 col-form-label">Total Bayar</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <div class="input-group-addon">Rp</div>
                                            <input type="text" class="form-control" name="total_bayar_modal" id="total_bayar_modal" disabled>
                                            <input type="hidden" id="total_bayar_modal_val">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-4 col-form-label">Keterangan</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="description">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p style="font-size: 25px; justify-content: start; float:left">Kembalian Rp. <b id="kembalian_text" style="font-size: 30px;"> 0</b></p>
                                <input type="hidden" name="total_change">
                            </div>
                            <div class=" col-md-6">
                                <p style="font-size: 25px; justify-content: end; float:right">Grand Total Rp. <b id="total_bayar_modal_text" style="font-size: 30px;"> 0</b></p>
                            </div>
                        </div>
                    </div>
                    <div class=" modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                        <button type="button" class="btn btn-success pull-right" id="Payment"><i class="fa fa-money"></i> Bayar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="successModal">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" id="btn-selesai" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Transaksi Berhasil</h4>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <img src="<?= base_url() ?>assets/gif/success_trans.gif" width="200px" height="150px">
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <div class="btn-group">
                        <a href="#" target="_blank" class="btn btn-default" id="printInvoice"><i class="fa fa-file-pdf-o"></i> Cetak Invoice</a>
                        <button type="button" class="btn btn-primary" id="btn-finish"><i class="fa fa-check-circle"></i> Selesai</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $this->load->view('layouts/v_footer') ?>
<script>
    $(function() {

        let productId = 0

        let tableSearchProduct = $('#tableSearchProduct').DataTable({
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
            }, ],
        });

        let datepicker = $.fn.datepicker.noConflict();
        $.fn.bootstrapDP = datepicker;
        $(".datepicker").bootstrapDP({
            autoclose: true,
            language: 'id',
            format: "   yyyy-mm-dd  <?= date('H:i:s') ?>"
        });

        function sweetalert(title, text, icon) {
            swal({
                title: title,
                text: text,
                icon: icon,
            })
        }

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

        function loadTables() {
            $('#tables_id').select2({
                placeholder: "-- Pilih --",
                allowClear: true
            })
            $('#tables_id').empty()
            $.ajax({
                url: '<?= base_url() ?>transactions/create/loadTables',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status == true) {
                        $('#tables_id').prop('disabled', false)
                        response.data.forEach((e, i) => {
                            $('#tables_id').append(`<option value="${e.id}">${e.name}</option>`)
                        })
                    } else {
                        $('#tables_id').prop('disabled', true)
                    }
                }
            })
        }

        function loadCustomers() {
            $('#customers_id').select2({
                placeholder: "-- Pilih --",
                allowClear: true
            })
            $('#customers_id').empty()
            $.ajax({
                url: '<?= base_url() ?>transactions/create/loadCustomers',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status == true) {
                        $('#customers_id').prop('disabled', false)
                        response.data.forEach((e, i) => {
                            $('#customers_id').append(`<option value="${e.id}">${e.fullname} - ${e.phone}</option>`)
                        })
                    } else {
                        $('#customers_id').prop('disabled', true)
                    }
                }
            })
        }

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

        function checkQtyMax(elemenValue, max) {
            if (parseFloat($(elemenValue).val()) > parseFloat(max)) {
                sweetalert("Maaf!", 'Maaf anda melebihi batas stok', "error")
                return $(elemenValue).val(max)
            } else {
                return false
            }
        }

        function calcSubtotal(e) {
            let column = e.closest('tr').find('td')
            let price = column.find('#priceChange').val()
            let qty = e.val()
            column.find('#subtotal').val(parseInt(price) * parseFloat(qty))
            column.find('.subtotal_text').text('Rp. ' + parseInt(parseInt(price) * parseFloat(qty)).toLocaleString())

            calcDiscount(column.find('#discount'))
            calcTotalPrice()
        }

        function calcDiscount(e) {
            let column = $(e).closest('tr').find('td')
            let discount = checkPrice($(e).val())
            let price = column.find('#priceChange').val()
            let qty = column.find('#qtyChange').val()

            let calcDis = (price * qty) - discount;

            column.find('#discount').val(discount)
            column.find('#subtotal').val(calcDis)
            column.find('.subtotal_text').text('Rp. ' + parseInt(calcDis).toLocaleString())
            currencyFormatRupiah(e)
            calcTotalPrice()
        }

        function calcTotalPrice() {
            let totalPrice = 0
            $('input[name="subtotal[]"]').each(function() {
                totalPrice += parseInt($(this).val())
            })
            $('input[name="discount[]"]').each(function() {
                totalPrice -= parseInt(checkPrice($(this).val()))
            })
            $('#totalPrice').text(parseInt(totalPrice).toLocaleString())
            $('#total_bayar').val(totalPrice)
        }

        function setFocusQuantity() {
            $('input[name="qty[]"]').each(function() {
                $(this).focus()
            })
        }

        function appendRow(foods_id, product_name, price, qty, subtotal, discount = 0) {
            record = `<tr>
            <td>#<span class="id-product-field" hidden>${foods_id}</span></td>
            <td>${product_name}</td>
            <td>Rp. ${ parseInt(price).toLocaleString() }</td>
            <td><input type="number" class="form-control form-control-sm" id="qtyChange" autocomplete="off" placeholder="0" name="qty[]" value="${qty}" min="1"></td>
            <td><span class="subtotal_text">Rp. ${ parseInt(subtotal - (discount)).toLocaleString() }</span></td>
            <td><button type="button" id="removeProductCart" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button>

            <input type="hidden" name="foods_id[]" value="${foods_id}">
            <input type="hidden" name="price[]" id="priceChange" value="${price}">
            <input type="hidden" name="discount[]" id="discount" value="${discount * qty}">
            <input type="hidden" name="subtotal[]" id="subtotal" value="${subtotal}"></td>
            </tr>`;
            $('#productTransaction tbody').append(record)
        }

        $('#quantity').on('keyup change', function(e) {
            e.preventDefault()
            checkQtyMax(this, $(this).attr('max'))
            if (e.keyCode == 13) {
                $('#addTransaction').trigger('click')
            }
        })

        $('.total_cash').on('keyup change', function (e) {
            e.preventDefault()
            if (e.keyCode == 13) {
                $('#Payment').trigger('click')
            }
        })

        $(document).on('keyup change', '#discountChange', function(e) {
            e.preventDefault()
            calcDiscount(this)
        })

        $(document).on('keyup change', '#qtyChange', function(e) {
            e.preventDefault()
            calcSubtotal($(this))
        })

        $(document).on('keyup', '#totalCash', function(e) {
            currencyFormatRupiah(this)
        })

        $('#searchProduct').on('click', function(e) {
            e.preventDefault()
            $('#searchProductModal').modal('show')
        })

        $('body').on('click', '#selectProduct', function() {
            let check = $('.id-product-field:contains(' + $(this).data('foods_id') + ')').length;
            if (check == 1) {
                $('#searchProductModal').modal('hide')
                sweetalert("Maaf!", 'Produk yang anda pilih sudah ada dalam list!', "error")
            } else {
                $('#menu').val($(this).data('name'))
                $('#food_name').val($(this).data('name'))
                $('#foods_id').val($(this).data('foods_id'))
                $('#price').val($(this).data('price'))

                $('#quantity').val('')
                $('#quantity').attr('disabled', false)
                $('#quantity').focus()

                $('#searchProductModal').modal('hide')
            }
        })

        $('#addTransaction').on('click', function() {
            $('#quantity').attr('disabled', true)
            if ($('#menu').val().length == '') {
                sweetalert("Maaf!", 'Mohon cari menu terlebih dahulu!', "error")
            } else if ($('#quantity').val().length == '') {
                $('#quantity').attr('disabled', false)
                sweetalert("Maaf!", 'Mohon input quantity terlebih dahulu!', "error")
            } else {
                let productName = $('#food_name').val()
                let productsId = $('#foods_id').val()
                let price = $('#price').val()
                let quantity = $('#quantity').val()
                let subtotal = (parseInt(price) * parseFloat(quantity))

                let tbody = $('#productTransaction tbody tr td').text();
                if (tbody == 'Tidak ada item menu!') {
                    $('#productTransaction tbody tr').remove();
                }

                appendRow(productsId, productName, price, quantity, subtotal)
                calcTotalPrice()
                setFocusQuantity()

                $('#menu, #food_name, #foods_id, #price, #quantity, #discountFirst').val('')
            }
        })

        $('body').on('click', '#removeProductCart', function(e) {
            $(this).closest('tr').remove()
            calcTotalPrice()
            if ($('#productTransaction tbody tr').length == 0) {
                $('#productTransaction tbody').append('<tr align="center"><td colspan="8">Tidak ada item menu!</td></tr>');
            }
        })

        $('body').on('click', '#btn_payment', function(e) {
            e.preventDefault()
            if ($('#productTransaction tbody tr td').text() == 'Tidak ada item menu!') {
                sweetalert("Maaf!", 'Pilih setidaknya 1 item terlebih dahulu', "error")
            } else {
                $('#payModal').modal('show')
            }
        })

        $('#payModal').on('show.bs.modal', function() {
            let code = $('#code').val()
            let total_bayar = $('#total_bayar').val()
            let modal = $(this)
            
            loadTables()
            loadCustomers()
            calcDiscountAll()

            modal.find('.modal-body #total_bayar_modal').val(parseInt(total_bayar).toLocaleString())
            modal.find('.modal-body #total_bayar_modal_text').text(parseInt(total_bayar).toLocaleString())
            modal.find('.modal-body #total_bayar_modal_val').val(total_bayar)
            modal.find('.modal-body #code').val(code)
            $('#totalCash').focus()
        })

        function calcDiscountAll() {
            let total = 0;
            $('input[name="discount[]"]').each(function() {
                total += parseInt(checkPrice($(this).val()))
            })
            $('#payModal #diskon_modal').val(parseInt(total).toLocaleString());
        }

        function calcKembalian() {
            let jumlah_bayar = checkPrice($('input[name="total_cash"]').val())
            let total_bayar = $('#total_bayar_modal_val').val()

            let kembalian = parseInt(jumlah_bayar) - parseInt(total_bayar)
            $('#kembalian_text').text(parseInt(kembalian).toLocaleString())
            $('input[name="total_change"]').val(kembalian)
        }

        $('input[name="total_cash"]').on('keyup', function(e) {
            e.preventDefault()
            calcKembalian()
        })

        function pushArray(elemen, variable) {
            $(elemen).each(function() {
                variable.push($(this).val())
            })
        }

        $('#Payment').on('click', function(e) {
            let code = $('#code').val()
            let customers_id = $('#customers_id').val()
            let tables_id = $('#tables_id').val()
            let datetime = $('#date_modal').val()
            let total = $('#total_bayar_modal_val').val()
            let discountAll = checkPrice($('input[name="diskon_modal"]').val())
            let pay = checkPrice($('input[name="total_cash"]').val())
            let totalChange = $('input[name="total_change"]').val()
            let totalCash = $('input[name="total_cash"]').val();
            let description = $('input[name="description"]').val()

            if (parseInt(pay) < parseInt(total)) {
                sweetalert('Maaf', 'Jumlah nominal pembayaran kurang!', 'error')
            } else {
                //data array
                let foods_id = [];
                let qty = [];
                let price = [];
                let discountEach = [];
                let subtotal = [];

                //pushData
                pushArray($('input[name="foods_id[]"]'), foods_id)
                pushArray($('input[name="qty[]"]'), qty)
                pushArray($('input[name="price[]"]'), price)
                pushArray($('input[name="discount[]"]'), discountEach)
                pushArray($('input[name="subtotal[]"]'), subtotal)

                console.log(price)

                //makeBunddle
                let finalData = {
                    code: code,
                    customers_id: customers_id,
                    tables_id: tables_id,
                    datetime: datetime,
                    total: total,
                    discountAll: discountAll,
                    foods_id: foods_id,
                    qty: qty,
                    price: price,
                    discountEach: discountEach,
                    subtotal: subtotal,
                    totalChange: totalChange,
                    totalCash: pay,
                    description: description
                };

                //insert
                $(this).attr('disabled', true)
                let action = $('#payModal #payForm').attr('action')
                $.ajax({
                    url: action,
                    method: 'POST',
                    data: finalData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == true) {
                            $(this).attr('disabled', false)
                            $('#payModal').modal('hide')
                            swal({
                                title: "Transaksi Berhasil!",
                                icon: "success",
                                buttons: true,
                            })
                            .then((confirm) => {
                                if (confirm) {
                                    window.location.href = "<?= base_url() ?>transactions"
                                }
                            });
                        }
                    }
                })
            }
        })
    })
</script>