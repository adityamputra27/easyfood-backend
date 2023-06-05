<?php $this->load->view("layouts/v_header"); ?>
<section class="content-header">
   <h1>
      Data Stok Masuk - <b><?= $product->name ?></b>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-external-link"></i> Stok</a></li>
      <li class="active">Masuk</li>
   </ol>
</section>
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
                        <th>Stok Masuk</th>
                        <th>Expired Date</th>
                        <th>Keterangan</th>
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
<div class="modal fade" id="stock_inModal">
   <div class="modal-dialog">
      <div class="modal-content">
         <form id="stock_inForm" method="POST" action="<?= base_url() ?>products/stocks/store">
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
               <label for="" class="col-sm-3 col-form-label">Nama Produk <span class="text-danger">*</span></label>
                  <div class="col-sm-9">
                     <input type="hidden" class="form-control" name="products_id" readonly value="<?= $product->id ?>">
                     <input type="text" class="form-control" readonly value="<?= $product->name ?>">
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
                     <div class="input-group date">
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

     $('#stock_inModal').on('keypress', function(e) {
       if (e.which == 13) {
         return false
       }
     })
     function cleanVal() {
       $('#products_id').val('')
       $('#barcodeStock').val('')
       $('#products_name').val('')
       $('input[name=total]').val('')
       $('#description').val('')
       $('#datepicker').val('')
       $('#expired_date').val('')
     }
     $('body').on('click', '.selectStockProduct', function (e) {
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
         "url": "<?= base_url() ?>products/stocks/getStockIn",
         "type": "POST",
         "data": function (data) {
            data.products_id = "<?= $product->id ?>"
         }
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
         expired_date: {
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
         expired_date: {
             required: "Tanggal kadaluarsa harus diisi"
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