<?php $this->load->view('layouts/v_header') ?>
<section class="content-header">
    <h1>
        Data Satuan Produk
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-shopping-bag"></i> Produk</a></li>
        <li class="active">Satuan</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <div class="btn-group">
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#unitModal"><i class="fa fa-plus-circle"></i> Tambah</a>
                        <!-- <a href="#" class="btn btn-warning"><i class="fa fa-plus-circle"></i> Export Excel</a>
                        <a href="#" class="btn btn-info"><i class="fa fa-plus-circle"></i> Export PDF</a> -->
                    </div>
                </div>
                <div class="box-body">
                    <table id="unit" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="10px" class="text-center">No</th>
                                <th>Satuan</th>
                                <th width='125px' class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
</section>
<div class="modal fade" id="unitModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url() ?>products/unit/store" id="unitForm" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Tambah Satuan Produk</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Satuan</label>
                        <input type="text" class="form-control" autocomplete="off" name="unitInput" id="unitInput">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                    <button type="submit" class="btn btn-primary" id="submitUnit"><i class="fa fa-check-circle"></i> Simpan</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<?php $this->load->view('layouts/v_footer') ?>
<script>
    $(function () {
        let tableUnit = $('#unit').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            },
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url() ?>products/unit/getUnit",
                "type": "POST"
            },
            "columnDefs": [{
                    "targets": [0],
                    "orderable": false,
                },
                {
                    "targets": [2],
                    "orderable": false,
                },
            ],
        });
        $('#unitModal').on('shown.bs.modal', function (e) {
            let button = $(e.relatedTarget)
            let trParents = button.parents().parents().closest('tr')
            let modal = $(this)
            let mode = button.data('mode')
            let id = button.data('id')
            let unit = trParents.find('td:eq(1)').text()

            modal.find('#unitInput').focus()

            if (mode == 'edit') {
                modal.find('.modal-title').html(`Edit Unit Produk : <b>${unit}</b>`)
                $('#unitForm').attr('action', `<?= base_url() ?>products/unit/edit/${id}`)
                modal.find('#unitInput').val(unit)
                modal.find('#submitUnit').attr('class', 'btn btn-warning')
                modal.find('#submitUnit').html(`<i class="fa fa-edit"></i> Update`)
            } else {
                modal.find('.modal-title').text('Tambah Unit Produk')
                $('#unitForm').attr('action', '<?= base_url() ?>products/unit/store')
                modal.find('#unitInput').val('')
                modal.find('#submitUnit').attr('class', 'btn btn-primary')
                modal.find('#submitUnit').html(`<i class="fa fa-check-circle"></i> Simpan`)

            }
        })

        $('#unitForm').validate({
            rules: {
                unitInput: {
                    required: true
                }
            },
            messages: {
                unitInput: {
                    required: "Satuan harus diisi"
                }
            }
        })

        $(document).on('submit', '#unitForm', function (e) {
            e.preventDefault()
            let action = $(this).attr('action')
            $.ajax({
                url: action,
                type: 'POST',
                data: $('#unitForm').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status == true) {
                        $('#unitModal').modal('hide')
                        setTimeout(() => {
                            swal({
                                title: "Berhasil!",
                                text: response.message,
                                icon: "success",
                            }).then(function () {
                                tableUnit.ajax.reload();
                            });
                        }, 350)
                    }
                }
            })
        })
        $('body').on('click', '.delete-unit', function () {
            let trParents = $(this).parents().parents().closest('tr')
            let dataName = trParents.find('td:eq(1)').text()
            // console.log($(this).parents().parents().closest('tr').find('td:eq(1)').text())
            swal({
                title: "Apakah kamu yakin?",
                text: `Data ${dataName} akan dihapus?`,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((confirmDelete) => {
                    if (confirmDelete) {
                        let id = $(this).attr('data-id')
                        $.ajax({
                            url: `<?= base_url() ?>products/unit/delete/${id}`,
                            type: 'DELETE',
                            dataType: 'json',
                            success: function (response) {
                                if (response.status == true) {
                                    swal({
                                        title: "Berhasil!",
                                        text: response.message,
                                        icon: "success",
                                    }).then(function () {
                                        tableUnit.ajax.reload();
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