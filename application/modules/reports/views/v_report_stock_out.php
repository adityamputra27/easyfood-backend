<?php $this->load->view('layouts/v_header') ?>
<section class="content-header">
    <h1>
        Laporan Stok Keluar
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-external-link"></i> Laporan</a></li>
        <li class="active">Stok Keluar</li>
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
                                            <label for="" class="col-sm-1 col-control-label" style="line-height: 2.5;">Tanggal</label>
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
                                            <label for="" class="col-sm-1 col-control-label" style="line-height: 2.5;">Barcode</label>
                                            <div class="col-sm-4">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control" name="barcode" id="barcode" autocomplete="off" placeholder="000000">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-1 col-control-label" style="line-height: 2.5;">Keterangan</label>
                                            <div class="col-sm-5">
                                                <div class="row">
                                                    <div class="col-sm-5">
                                                        <select name="description" id="description" class="form-control">
                                                            <option value="">Semua</option>
                                                            <option value="Hilang">Hilang</option>
                                                            <option value="Rusak">Rusak</option>
                                                            <option value="Kadaluarsa">Kadaluarsa</option>
                                                            <option value="Lain Lain">Lain Lain</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-2" style="text-align: center; line-height: 2.5;">
                                                        <label for="">Produk</label>
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <input type="text" class="form-control" name="name" id="name" autocomplete="off">
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
                        <table id="reportStockOut" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                <th width="10px" class="text-center">No</th>
                                <th>Tanggal</th>
                                <th>Barcode</th>
                                <th>Nama Produk</th>
                                <th>Stok Keluar</th>
                                <th>Expired Date</th>
                                <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
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
        let tablereportStockOut = $('#reportStockOut').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            },
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url() ?>reports/stock_out/getStockOutReport",
                "type": "POST",
                "data": function(data) {
                    data.start_date = $('#start_date').val();
                    data.end_date = $('#end_date').val();
                    data.barcode = $('#barcode').val();
                    data.description = $('#description').val();
                    data.name = $('#name').val();
                }
            },
            columnDefs: [{
                targets: 0,
                orderable: false
            }]
        });
        $(document).on('click', '#btn-filter', function(e) {
            tablereportStockOut.ajax.reload()
        })
    })
</script>