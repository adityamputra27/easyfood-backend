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

    $('body').on('click', '.delete-transaction', function() {
      let trParents = $(this).parents().parents().closest('tr')
      let invoice = trParents.find('td:eq(2)').text()
      swal({
          title: "Apakah kamu yakin?",
          text: `Transaksi ${invoice} akan dibatalkan?`,
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((confirmDelete) => {
          if (confirmDelete) {
            let id = $(this).attr('data-id')
            console.log(id)
            $.ajax({
              url: `<?= base_url() ?>transactions/input/delete/${id}`,
              type: 'DELETE',
              dataType: 'json',
              success: function(response) {
                if (response.status == true) {
                  swal({
                    title: "Berhasil!",
                    text: response.message,
                    icon: "success",
                  }).then(function() {
                    tableReportSale.ajax.reload();
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


  })
</script>