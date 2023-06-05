<?php $this->load->view('layouts/v_header') ?>
<section class="content-header">
  <h1>
    Laporan Keuntungan
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-external-link"></i> Laporan</a></li>
    <li class="active">Keuntungan</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header">
          <div class="accordion" id="accordionExample">
            <div class="card" style="border-bottom: 2px dashed #dadada;">
              <button style="color: #a0a0a0; text-align: left !important;" class="btn collapsed text-bold btn-block" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                <i class="fa fa-search"></i> Show / Hide Filter
              </button>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample" style="background-color: #f8f8f8;">
                <div class="card-body" style="padding: 10px 10px 5px 10px;">
                  <form action="">
                    <div class="form-group row">
                      <label for="" class="col-sm-1 col-control-label" style="line-height: 2.5;">Tanggal :</label>
                      <div class="col-sm-5">
                        <div class="row">
                          <div class="col-sm-5">
                            <input type="date" class="form-control" name="start_date" id="start_date" autocomplete="off" value="<?= date('Y-m-d') ?>">
                          </div>
                          <div class="col-sm-2" style="text-align: center; line-height: 2.5;">
                            <label for="">s/d</label>
                          </div>
                          <div class="col-sm-5">
                            <input type="date" class="form-control" name="end_date" id="end_date" autocomplete="off" value="<?= date('Y-m-d') ?>">
                          </div>
                        </div>
                      </div>
                      <label for="" class="col-sm-1 col-control-label" style="line-height: 2.5;">Nota :</label>
                      <div class="col-sm-4">
                        <div class="row">
                          <div class="col-sm-12">
                            <input type="text" class="form-control" name="invoice" id="invoice" autocomplete="off" placeholder="0000000000">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-1">
                        <div class="row">
                          <div class="col-sm-12">
                            <button class="btn btn-primary" type="button" id="btn-filter"><i class="fa fa-filter"></i> Filter</button>
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
          <div class="table-responsive">
            <table id="reportProfit" class="table table-bordered table-striped" width="100%">
              <thead>
                <tr>
                  <th rowspan="2" width="1px" class="text-center">#</th>
                  <th colspan="3" class="text-center">INFORMASI PENJUALAN</th>
                  <th colspan="4" class="text-center">TOTAL</th>
                </tr>
                <tr>
                  <th width="70px">Tanggal</th>
                  <th width="10px">Nota</th>
                  <th>Nama Produk</th>
                  <th class="text-right" width="90px">Penjualan</th>
                  <th class="text-right" width="90px">Modal</th>
                  <th class="text-right" width="90px">Diskon</th>
                  <th class="text-right" width="90px">Laba</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>

          <div class="text-right countTotalAll" style="margin-top: 15px;">
            <strong style="font-size: 22px;">Total Penjualan tanpa Diskon : <b id="totalSalesAll"></b></strong><br>
            <strong style="font-size: 22px;">Total Penjualan : <b id="totalSalesDisAll"></b></strong><br>
            <strong style="font-size: 22px;">Total Modal : <b id="totalCapitalAll"></b></strong><br>
            <strong style="font-size: 22px;">Total Diskon : <b id="totalDiscountAll"></b></strong><br>
            <strong style="font-size: 22px;">Total Laba : <b id="totalProfitAll"></b></strong><br>
          </div>

        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
</section>
<?php $this->load->view('layouts/v_footer') ?>
<script>
  $(function() {
    let tableProfit = $('#reportProfit').DataTable({
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
      },
      "processing": true,
      "serverSide": true,
      "order": [],
      "ajax": {
        "url": "<?= base_url() ?>reports/profit/getTransctions",
        "type": "POST",
        "data": function(data) {
          data.start_date = $('#start_date').val();
          data.end_date = $('#end_date').val();
          data.invoice = $('#invoice').val()
        }
      },
      "initComplete": function(settings, json) {
        countTotalAll(json)
      },
      columnDefs: [{
        targets: 0,
        className: 'text-left',
        orderable: false
      }, {
        targets: 1,
        orderable: false
      }, {
        targets: 2,
        orderable: false
      }, {
        targets: 3,
        orderable: false
      }, {
        targets: 4,
        className: 'text-right',
        orderable: false
      }, {
        targets: 5,
        className: 'text-right',
        orderable: false
      }, {
        targets: 6,
        className: 'text-right',
        orderable: false
      }, {
        targets: 7,
        className: 'text-right',
        orderable: false
      }]
    });

    $(document).on('click', '#btn-filter', function() {
      tableProfit.ajax.reload(countTotalAll, false)
    })

    $('#reportProfit').on('page.dt length.dt', function() {
      tableProfit.ajax.reload(countTotalAll, false)
    });

    function countTotalAll(json) {
      $('#totalSalesAll').text('Rp. ' + parseInt(json.totalSalesAll).toLocaleString() + ',-')
      $('#totalSalesDisAll').text('Rp. ' + parseInt(json.totalSalesAll - json.totalDiscountAll).toLocaleString() + ',-')
      $('#totalCapitalAll').text('Rp. ' + parseInt(json.totalCapitalAll).toLocaleString() + ',-')
      $('#totalDiscountAll').text('Rp. ' + parseInt(json.totalDiscountAll).toLocaleString() + ',-')
      $('#totalProfitAll').text('Rp. ' + parseInt((json.totalSalesAll - json.totalCapitalAll) - json.totalDiscountAll).toLocaleString() + ',-')
    }

  })
</script>