<?php $this->load->view('layouts/v_header') ?>
<section class="content-header">
  <h1>
    Laporan Kas
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-external-link"></i> Laporan</a></li>
    <li class="active">Kas</li>
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
              <button style="color: #a0a0a0; text-align: left !important;" class="btn collapsed text-bold btn-block" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
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
                      <label for="" class="col-sm-1 col-control-label" style="line-height: 2.5;">Pengguna :</label>
                      <div class="col-sm-4">
                        <div class="row">
                          <div class="col-sm-12">
                            <select name="user" id="user" class="form-control" autocomplete="off">
                              <option value="" disabled selected hidden>-- Pilih Pengguna --</option>
                              <?php foreach ($this->sistem_model->_get('users', 'name-asc') as $row) : ?>
                                <option value="<?= $row['id'] ?>"><?= ucfirst($row['name']); ?></option>
                              <?php endforeach; ?>
                            </select>
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
            <table id="reportCash" class="table table-bordered table-striped" width="100%">
              <thead>
                <tr>
                  <th class="text-center" width="10px">#</th>
                  <th class="text-center" width="50px">Nota</th>
                  <th class="text-center">Transaksi</th>
                  <th class="text-center">Uraian</th>
                  <th class="text-center">Masuk/Debet</th>
                  <th class="text-center">Keluar/Kredit</th>
                  <th class="text-center">Saldo</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>

          <div class="text-right countTotalSaldo" style="margin-top: 15px">
            <strong style="font-size: 20px">Saldo Akhir : <b style="font-size: 30px" id="SaldoAkhir">Rp. 0</b></strong><br>
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
    let tableCash = $('#reportCash').DataTable({
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
      },
      "processing": true,
      "serverSide": true,
      "order": [],
      "paginate": false,
      "searching": false,
      "ajax": {
        "url": "<?= base_url() ?>reports/cash/getCash",
        "type": "POST",
        "data": function(data) {
          data.start_date = $('#start_date').val();
          data.end_date = $('#end_date').val();
          data.user = $('#user').val()
        }
      },
      "initComplete": function(settings, json) {
        countSaldoAkhir(json)
      },
      columnDefs: [
      {
        targets: 0,
        className: 'text-center',
        orderable: false,
      },
      {
        targets: 1,
        className: 'text-right',
        orderable: false,
      }, 
      {
        targets: 2,
        className: 'text-right',
        orderable: false,
      },
      {
        targets: 3,
        className: 'text-right',
        orderable: false,
      },
      {
        targets: 4,
        className: 'text-right',
        orderable: false,
      }, 
      {
        targets: 5,
        className: 'text-right',
        orderable: false,
      },
      {
        targets: 6,
        className: 'text-right',
        orderable: false,
      },]
    });

    let datepicker = $.fn.datepicker.noConflict();
    $.fn.bootstrapDP = datepicker;
    $(".datepicker").bootstrapDP({
      autoclose: true,
      language: 'id',
      format: "   yyyy-mm-dd"
    });

    $(document).on('click', '#btn-filter', function() {
      tableCash.ajax.reload(countSaldoAkhir, false)
    })

    function countSaldoAkhir(json) {
      $('#SaldoAkhir').text('Rp. ' + parseInt(json.totalSaldoAkhir).toLocaleString() + ',-')
    }


  })
</script>