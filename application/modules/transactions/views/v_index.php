<?php $this->load->view('layouts/v_header') ?>
<section class="content-header">
  <h1>
    Daftar Transaksi
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-external-link"></i> Dashboard</a></li>
    <li class="active">Daftar Transaksi</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header">
        <a href="<?= base_url() ?>transactions/create" class="btn btn-success" style="margin-bottom: 1em;"><i class="fa fa-plus-circle"></i> Tambah Transaksi</a>
          <div class="accordion" id="accordionExample">
            <div class="card" style="border-bottom: 2px dashed #dadada;">
              <button style="color: #a0a0a0; text-align: left !important;" class="btn collapsed text-bold btn-block collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fa fa-search"></i> Show / Hide Filter
              </button>
              <div id="collapseTwo" class="collapse in" aria-labelledby="headingTwo" data-parent="#accordionExample" style="background-color: #f8f8f8;">
                <div class="card-body" style="padding: 10px 10px 5px 10px;">
                  <form action="">
                    <div class="form-group row">
                      <label for="" class="col-sm-1 col-control-label" style="line-height: 2.5;">Tanggal :</label>
                      <div class="col-sm-4">
                        <div class="row">
                          <div class="col-sm-5">
                            <input type="date" class="form-control" name="start_date" id="start_date" autocomplete="off" value="<?= date('Y-m-d') ?>">
                          </div>
                          <div class="col-sm-1" style="text-align: center; line-height: 2.5;">
                            <label for="">s/d</label>
                          </div>
                          <div class="col-sm-5">
                            <input type="date" class="form-control" name="end_date" id="end_date" autocomplete="off" value="<?= date('Y-m-d') ?>">
                          </div>
                        </div>
                      </div>
                      <label for="" class="col-sm-1 col-control-label" style="line-height: 2.5;">Kode :</label>
                      <div class="col-sm-2">
                        <input type="text" class="form-control" name="code" id="code" autocomplete="off" placeholder="2xj129x">
                      </div>
                      <label for="" class="col-sm-1 col-control-label" style="line-height: 2.5;">Pelanggan :</label>
                      <div class="col-sm-2">
                        <input type="text" class="form-control" name="customers" id="customers" autocomplete="off">
                      </div>
                      <div class="col-sm-1">
                        <div class="row">
                          <div class="col-sm-2">
                            <button class="btn btn-success" type="button" id="btn-filter"><i class="fa fa-filter"></i> Filter</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="box-body">
            <table id="reportSale" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th width="10px" rowspan="2" class="text-center">#</th>
                  <th colspan="4" class="text-center">INFORMASI PEMESANAN</th>
                  <th colspan="3" class="text-center">TOTAL</th>
                  <th colspan="2">&nbsp;</th>
                </tr>
                <tr>
                  <th width="80px">Tanggal</th>
                  <th width="20px">Kode</th>
                  <th width="50px">Meja</th>
                  <th width="100px">Nama Pelanggan</th>
                  <th width="250px">Daftar Pesanan</th>
                  <th class="text-center" width="80px">Total</th>
                  <th class="text-center" width="80px">Kasir</th>
                  <th width="30px">Status</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
        </div>
      </div>
      <!-- /.box -->
    </div>
</section>
<div class="modal fade" id="payModal">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Transaksi Pembayaran</h4>
          </div>
          <form action="<?= base_url() ?>transactions/update/" method="POST" id="payForm">
              <div class="modal-body">
                  <div class="row">
                      <div class="col-md-6">
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
                                  <input type="text" class="form-control" id="codeCurr" name="codeCurr">
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
<?php $this->load->view('layouts/v_footer') ?>
<script>
  $(function() {
    let tableReportSale = $('#reportSale').DataTable({
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
      },
      "processing": true,
      "serverSide": true,
      "order": [],
      "ajax": {
        "url": "<?= base_url() ?>transactions/getTransactions",
        "type": "POST",
        "data": function(data) {
          data.start_date = $('#start_date').val()
          data.end_date = $('#end_date').val()
          data.code = $('#code').val()
          data.customers = $('#customers').val()
        }
      },
      columnDefs: [
        {
          targets: 0,
          orderable: false,
        },
        {
          targets: 1,
          orderable: false,
        }, 
        {
          targets: 2,
          orderable: false,
        }, 
        {
          targets: 3,
          orderable: false,
        }, 
        {
          targets: 4,
          orderable: false,
        }, 
        {
          targets: 5,
          orderable: false,
        },
        {
          targets: 6,
          className: 'text-center',
          orderable: false,
        },
        {
          targets: 7,
          orderable: false,
          className: 'text-center',
        },
        {
          targets: 8,
          orderable: false,
          className: 'text-center',
        },
      ]
    })

    $(document).on('click', '#btn-filter', function() {
      tableReportSale.ajax.reload()
    })

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

    function calcKembalian() {
        let jumlah_bayar = checkPrice($('input[name="total_cash"]').val())
        let total_bayar = $('#total_bayar_modal_val').val()

        let kembalian = parseInt(jumlah_bayar) - parseInt(total_bayar)
        $('#kembalian_text').text(parseInt(kembalian).toLocaleString())
        $('input[name="total_change"]').val(kembalian)
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

    function sweetalert(title, text, icon) {
        swal({
            title: title,
            text: text,
            icon: icon,
        })
    }

    $('input[name="total_cash"]').on('keyup', function(e) {
        e.preventDefault()
        calcKembalian()
    })

    $(document).on('keyup', '#totalCash', function(e) {
        currencyFormatRupiah(this)
    })

    $('.total_cash').on('keyup change', function (e) {
        e.preventDefault()
        if (e.keyCode == 13) {
            $('#Payment').trigger('click')
        }
    })

    $('#payModal').on('show.bs.modal', function(e) {
        let button = $(e.relatedTarget)
        let id = button.data('id')
        let code = button.data('code')
        let total_bayar = button.data('total')
        let modal = $(this)
        
        loadTables()
        loadCustomers()

        $('#payForm').attr('action', `<?= base_url() ?>transactions/edit/${id}`)
        modal.find('.modal-body #total_bayar_modal').val(parseInt(total_bayar).toLocaleString())
        modal.find('.modal-body #total_bayar_modal_text').text(parseInt(total_bayar).toLocaleString())
        modal.find('.modal-body #total_bayar_modal_val').val(total_bayar)
        modal.find('.modal-body #codeCurr').val(code)
        $('#totalCash').focus()
    })

    $('#Payment').on('click', function(e) {
        let code = $('#codeCurr').val()
        let totalChange = $('input[name="total_change"]').val()
        let totalCash = $('input[name="total_cash"]').val();
        let description = $('input[name="description"]').val()
        let pay = checkPrice($('input[name="total_cash"]').val())
        let total = $('#total_bayar_modal_val').val()

        if (parseInt(pay) < parseInt(total)) {
            sweetalert('Maaf', 'Jumlah nominal pembayaran kurang!', 'error')
        } else {
            let finalData = {
                code: code,
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
                            title: "Transaksi Pembayaran Berhasil!",
                            icon: "success",
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