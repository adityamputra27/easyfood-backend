<?php $this->load->view("layouts/v_header"); ?>
<section class="content-header">
  <h1>
    Data Stok Masuk
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-external-link"></i> Stok</a></li>
    <li class="active">Masuk</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header">
          <div class="btn-group">
            <a href="#" class="btn btn-primary" data-toggle="modal" data-mode="tambah" data-target="#stock_inModal"><i class="fa fa-plus-circle"></i> Tambah</a>
          </div>
        </div>
        <div class="box-body">
          <table id="stock_in" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th width="10px" class="text-center">No</th>
                <th>Tanggal</th>
                <th>Barcode</th>
                <th>Nama Produk</th>
                <th>Stok Masuk</th>
                <th>Expired Date</th>
                <th>Keterangan</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
</section>
<div class="modal fade" id="stock_inModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="stock_inForm" method="POST" action="<?= base_url() ?>stocks/in/store">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Tambah Stok Masuk</h4>
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
                <input type="hidden" class="form-control" id="products_id" name="products_id">
                <input type="text" class="form-control" id="barcodeStock" readonly name="barcodeStock">
                <span class="input-group-btn input-group-update">
                  <button type="button" class="btn btn-warning btn-flat" id="btnUpdateStockIn"><i class="fa fa-edit"></i></button>
                </span>
                <span class="input-group-btn input-group-set-update">
                  <button type="button" class="btn btn-success btn-flat" id="btnSetUpdateStockIn"><i class="fa fa-check-circle"></i></button>
                </span>
                <span class="input-group-btn">
                  <button type="button" class="btn btn-info btn-flat btn-search" data-toggle="modal" data-target="#data_product_modal"><i class="fa fa-search"></i></button>
                </span>
              </div>
              <span id="messageUpdate"></span>
            </div>
          </div>

          <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label">Nama Produk</label>
            <div class="col-sm-9">
              <div class="input-group">
                <input type="text" class="form-control" id="products_name" readonly name="products_name">
                <span class="input-group-btn input-group-update-product-name">
                  <button type="button" class="btn btn-warning btn-flat" id="btnUpdateProductName"><i class="fa fa-edit"></i></button>
                </span>
                <span class="input-group-btn input-group-set-update-product-name">
                  <button type="button" class="btn btn-success btn-flat" id="btnSetUpdateProductName"><i class="fa fa-check-circle"></i></button>
                </span>
              </div>
              <span id="messageUpdateProductName"></span>
            </div>
          </div>

          <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label">Harga Modal</label>
            <div class="col-sm-9">
              <div class="input-group">
                <div class="input-group-addon">Rp.</div>
                <input type="text" class="form-control" id="harga_modal" readonly name="harga_modal">
                <span class="input-group-btn input-group-update-capital-price">
                  <button type="button" class="btn btn-warning btn-flat" id="btnUpdateCapitalPrice"><i class="fa fa-edit"></i></button>
                </span>
                <span class="input-group-btn input-group-set-update-capital-price">
                  <button type="button" class="btn btn-success btn-flat" id="btnSetUpdateCapitalPrice"><i class="fa fa-check-circle"></i></button>
                </span>
              </div>
              <span id="messageUpdateCapitalPrice"></span>
            </div>
          </div>

          <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label">Harga Jual</label>
            <div class="col-sm-9">
              <div class="input-group">
                <div class="input-group-addon">Rp.</div>
                <input type="text" class="form-control" id="harga_jual" readonly name="harga_jual">
                <span class="input-group-btn input-group-update-selling-price">
                  <button type="button" class="btn btn-warning btn-flat" id="btnUpdateSellingPrice"><i class="fa fa-edit"></i></button>
                </span>
                <span class="input-group-btn input-group-set-update-selling-price">
                  <button type="button" class="btn btn-success btn-flat" id="btnSetUpdateSellingPrice"><i class="fa fa-check-circle"></i></button>
                </span>
              </div>
              <span id="messageUpdateSellingPrice"></span>
            </div>
          </div>

          <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label">Jumlah (Stok) <span class="text-danger">*</span></label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="total" id="total" placeholder="0" autocomplete="off">
            </div>
          </div>

          <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label">Tanggal Expired <span class="text-danger">*</span></label>
            <div class="col-sm-9">
                <div class="input-group" style="display:flex; gap:1em; align-items:center;">
                  <div>
                    <input type="radio" id="ya" name="is_expired" value="Ya">
                    <label for="ya">Ya</label>
                  </div>
                  <div>
                    <input type="radio" id="tidak" name="is_expired" value="Tidak" checked>
                    <label for="tidak">Tidak</label>
                  </div>
                </div>
                <div class="input-group expired_date">
                  <input type="date" name="expired_date" class="form-control" id="expired_date">
                </div>
            </div>
          </div>

          <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label">Keterangan</label>
            <div class="col-sm-9">
              <select name="description" id="description" class="form-control">
                <option value="Penambahan Stok">Penambahan Stok</option>
                <option value="Lain - Lain">Lain - Lain</option>
              </select>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
          <button type="submit" class="btn btn-primary" id="submitStock_in"><i class="fa fa-check-circle"></i> Simpan</button>
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
              <tr class="text-center">
                  <th>No</th>
                  <th>Barcode</th>
                  <th>Nama</th>
                  <th>Satuan</th>
                  <th>Harga</th>
                  <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>

    </div>
    <!-- /.modal-content -->
  </div>
</div>
<?php $this->load->view("layouts/v_footer"); ?>
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

    $(document).on('keyup', '#total', function(e) {
      currencyFormatRupiah(this)
    })
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
      },{
          "targets": [5],
          "className": "text-center"
      }],
    });
    $('#stock_inModal').on('keypress', function(e) {
      // console.log(e.which)
      if (e.which == 13) {
        return false
      }
    })

    $(document).on('keyup', '#harga_jual', function(e) {
        currencyFormatRupiah(this)
    })
    $(document).on('keyup', '#harga_modal', function(e) {
        currencyFormatRupiah(this)
    })

    $('.expired_date').addClass('d-none')
    $('input[name="is_expired"]').change(function () {
      const isExpired = $(this).val()
      if (isExpired == 'Ya') {
        $('.expired_date').removeClass('d-none')
      } else {
        $('.expired_date').addClass('d-none')
      }
    })

    $('.input-group-set-update').hide()
    $('.input-group-set-update-product-name').hide()
    $('.input-group-set-update-capital-price').hide()
    $('.input-group-set-update-selling-price').hide()

    $('#btnUpdateStockIn').on('click', function (e) {
      e.stopPropagation()
      $('#messageUpdate').html('')
      if ($('#barcodeStock').val() == '') {
        $('#messageUpdate').append('<span class="text-danger text-bold"><i class="fa fa-times-circle"></i> Barcode Kosong!</span>')
      } else {
        $('.input-group-update').hide()
        $('.input-group-set-update').show()
        $('#barcodeStock').removeAttr('readonly')
      }
    })
    // timeOutMessage(callback, elem, )
    $('#btnSetUpdateStockIn').on('click', function (e) {
      e.stopPropagation()
      $('#messageUpdate').html('')
      if ($('#barcodeStock').val() == '') {
        $('#messageUpdate').append('<span class="text-danger text-bold" id="messageResponse"><i class="fa fa-times-circle"></i> Barcode Kosong!</span>')
        setTimeout(function () {
          $('#messageResponse').fadeTo(300, 0).slideUp(300, function () {
            $(this).remove()
          })
        }, 3000);
      } else {
        $.ajax({
          url: "<?= base_url() ?>products/lists/updateSingleProduct",
          type: "POST",
          data: {
            products_id: $('#products_id').val(),
            barcode: $('#barcodeStock').val()
          },
          dataType: 'json',
          success:function(response) {
            $('#messageUpdate').append(`<span class="text-success text-bold" id="messageResponse"><i class="fa fa-check-circle"></i> ${response.message}</span>`)
            tableSearchProduct.ajax.reload()
            tableStockIn.ajax.reload()
            $('.input-group-set-update').hide()
            $('.input-group-update').show()
            $('#barcodeStock').attr('readonly', true)
            setTimeout(function () {
              $('#messageResponse').fadeTo(300, 0).slideUp(300, function () {
                $(this).remove()
              })
            }, 3000);
          }
        })
      }
    })
    // 
    $('#btnUpdateProductName').on('click', function (e) {
      e.stopPropagation()
      $('#messageUpdateProductName').html('')
      if ($('#products_name').val() == '') {
        $('#messageUpdateProductName').append('<span class="text-danger text-bold"><i class="fa fa-times-circle"></i> Nama Produk Kosong!</span>')
      } else {
        $('.input-group-update-product-name').hide()
        $('.input-group-set-update-product-name').show()
        $('#products_name').removeAttr('readonly')
      }
    })
    // timeOutMessage(callback, elem, )
    $('#btnSetUpdateProductName').on('click', function (e) {
      e.stopPropagation()
      $('#messageUpdateProductName').html('')
      if ($('#products_name').val() == '') {
        $('#messageUpdateProductName').append('<span class="text-danger text-bold" id="messageResponseProductName"><i class="fa fa-times-circle"></i> Nama Produk Kosong!</span>')
        setTimeout(function () {
          $('#messageResponseProductName').fadeTo(300, 0).slideUp(300, function () {
            $(this).remove()
          })
        }, 3000);
      } else {
        $.ajax({
          url: "<?= base_url() ?>products/lists/updateProductName",
          type: "POST",
          data: {
            products_id: $('#products_id').val(),
            name: $('#products_name').val()
          },
          dataType: 'json',
          success:function(response) {
            $('#messageUpdateProductName').append(`<span class="text-success text-bold" id="messageResponseProductName"><i class="fa fa-check-circle"></i> ${response.message}</span>`)
            tableSearchProduct.ajax.reload()
            tableStockIn.ajax.reload()
            $('.input-group-set-update-product-name').hide()
            $('.input-group-update-product-name').show()
            $('#products_name').attr('readonly', true)
            setTimeout(function () {
              $('#messageResponseProductName').fadeTo(300, 0).slideUp(300, function () {
                $(this).remove()
              })
            }, 3000);
          }
        })
      }
    })
    // 
    $('#btnUpdateCapitalPrice').on('click', function (e) {
      e.stopPropagation()
      $('#messageUpdateCapitalPrice').html('')
      if ($('#harga_modal').val() == '') {
        $('#messageUpdateCapitalPrice').append('<span class="text-danger text-bold"><i class="fa fa-times-circle"></i> Harga Modal Kosong!</span>')
      } else {
        $('.input-group-update-capital-price').hide()
        $('.input-group-set-update-capital-price').show()
        $('#harga_modal').removeAttr('readonly')
      }
    })
    // timeOutMessage(callback, elem, )
    $('#btnSetUpdateCapitalPrice').on('click', function (e) {
      e.stopPropagation()
      $('#messageUpdateCapitalPrice').html('')
      if ($('#harga_modal').val() == '') {
        $('#messageUpdateCapitalPrice').append('<span class="text-danger text-bold" id="messageResponseCapitalPrice"><i class="fa fa-times-circle"></i> Harga Modal Kosong!</span>')
        setTimeout(function () {
          $('#messageResponseCapitalPrice').fadeTo(300, 0).slideUp(300, function () {
            $(this).remove()
          })
        }, 3000);
      } else {
        $.ajax({
          url: "<?= base_url() ?>products/lists/updateCapitalPrice",
          type: "POST",
          data: {
            products_id: $('#products_id').val(),
            capital_price: $('#harga_modal').val()
          },
          dataType: 'json',
          success:function(response) {
            $('#messageUpdateCapitalPrice').append(`<span class="text-success text-bold" id="messageResponseCapitalPrice"><i class="fa fa-check-circle"></i> ${response.message}</span>`)
            tableSearchProduct.ajax.reload()
            tableStockIn.ajax.reload()
            $('.input-group-set-update-capital-price').hide()
            $('.input-group-update-capital-price').show()
            $('#harga_modal').attr('readonly', true)
            // console.log(response)
            setTimeout(function () {
              $('#messageResponseCapitalPrice').fadeTo(300, 0).slideUp(300, function () {
                $(this).remove()
              })
            }, 3000);
          }
        })
      }
    })
    //
    $('#btnUpdateSellingPrice').on('click', function (e) {
      e.stopPropagation()
      $('#messageUpdateSellingPrice').html('')
      if ($('#harga_jual').val() == '') {
        $('#messageUpdateSellingPrice').append('<span class="text-danger text-bold"><i class="fa fa-times-circle"></i> Harga Jual Kosong!</span>')
      } else {
        $('.input-group-update-selling-price').hide()
        $('.input-group-set-update-selling-price').show()
        $('#harga_jual').removeAttr('readonly')
      }
    })
    // timeOutMessage(callback, elem, )
    $('#btnSetUpdateSellingPrice').on('click', function (e) {
      e.stopPropagation()
      $('#messageUpdateSellingPrice').html('')
      if ($('#harga_jual').val() == '') {
        $('#messageUpdateSellingPrice').append('<span class="text-danger text-bold" id="messageResponseSellingPrice"><i class="fa fa-times-circle"></i> Harga Jual Kosong!</span>')
        setTimeout(function () {
          $('#messageResponseSellingPrice').fadeTo(300, 0).slideUp(300, function () {
            $(this).remove()
          })
        }, 3000);
      } else {
        $.ajax({
          url: "<?= base_url() ?>products/lists/updateSellingPrice",
          type: "POST",
          data: {
            products_id: $('#products_id').val(),
            selling_price: $('#harga_jual').val()
          },
          dataType: 'json',
          success:function(response) {
            $('#messageUpdateSellingPrice').append(`<span class="text-success text-bold" id="messageResponseSellingPrice"><i class="fa fa-check-circle"></i> ${response.message}</span>`)
            tableSearchProduct.ajax.reload()
            tableStockIn.ajax.reload()
            $('.input-group-set-update-selling-price').hide()
            $('.input-group-update-selling-price').show()
            $('#harga_jual').attr('readonly', true)
            setTimeout(function () {
              $('#messageResponseSellingPrice').fadeTo(300, 0).slideUp(300, function () {
                $(this).remove()
              })
            }, 3000);
          }
        })
      }
    })
    //  
    function cleanVal() {
      $('#products_id').val('')
      $('#barcodeStock').val('')
      $('#products_name').val('')
      $('input[name=total]').val('')
      $('#description').val('')
      $('#datepicker').val('')
      $('#expired_date').val('')
    }
    $('body').on('click', '.selectProduct', function (e) {
      e.preventDefault();

      let barcode = $(this).closest('tr').find('td:eq(1)').text()
      let nama = $(this).closest('tr').find('td:eq(2)').text()
      let productId = $(this).attr('data-idproduct')
      let capitalPrice = $(this).attr('data-capital')
      let sellingPrice = $(this).attr('data-price')

      $('#products_id').val(productId)
      $('#barcodeStock').val(barcode)
      $('#products_name').val(nama)
      $('#harga_modal').val(generateCurrency(capitalPrice))
      $('#harga_jual').val(generateCurrency(sellingPrice))

      $('#data_product_modal').modal('hide')
    })
    let tableStockIn = $('#stock_in').DataTable({
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
      },
      "processing": true,
      "serverSide": true,
      "order": [],
      "ajax": {
        "url": "<?= base_url() ?>stocks/in/getStock_in",
        "type": "POST"
      },
      "columnDefs": [{
          "targets": [0],
          "orderable": false,
      },],
    });

    let configDatepicker = {
         enableTime: true,
         dateFormat: "d-m-Y H:i"
     }

     let configExpiredDate = {
         dateFormat: "d-m-Y"
     }

     const fpdatepicker = flatpickr("#datepicker", configDatepicker)
     const fpexpireddate = flatpickr("#expired_date", configExpiredDate)

    $('#stock_inModal').on('show.bs.modal', function(e) {

      cleanVal()

      let button = $(e.relatedTarget)
      let modal = $(this)

      modal.find('#submitStock_in').attr('class', 'btn btn-primary')
      modal.find('#submitStock_in').html(`<i class="fa fa-check-circle"></i> Simpan`)
    })

    $('#stock_inForm').validate({
      rules: {
        date: {
            required: true
        },
        total: {
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
        total: {
            required: "Stok harus diisi"
        },
        description: {
            required: "Keterangan harus diisi"
        }
      }
    })

    $(document).on('submit', '#stock_inForm', function(e) {
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
          data: $('#stock_inForm').serialize(),
          dataType: 'json',
          success: function(response) {
            if (response.status == true) {
              $('#stock_inModal').modal('hide')
              swal({
                title: "Berhasil!",
                text: response.message,
                icon: "success",
              }).then(function () {
                tableStockIn.ajax.reload();
                tableSearchProduct.ajax.reload()
              })
            }
          }
        })
      }
    })
  })
</script>