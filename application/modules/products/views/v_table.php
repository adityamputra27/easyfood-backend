<?php $this->load->view('layouts/v_header') ?>
<section class="content-header">
    <h1>
        Data Meja
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-shopping-bag"></i> Menu</a></li>
        <li class="active">Meja</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <div class="btn-group">
                        <a href="#" class="btn btn-success" data-toggle="modal" data-target="#modalForm"><i class="fa fa-plus-circle"></i> Tambah</a>
                    </div>
                </div>
                <div class="box-body">
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="10px" class="text-center">No</th>
                                <th>Nama</th>
                                <th>Keterangan</th>
                                <th width='125px' class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</section>
<div class="modal fade" id="modalForm">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url() ?>products/table/store" id="tableForm" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Tambah Meja</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nama</label>
                        <input type="text" class="form-control" autocomplete="off" name="tableInput" id="tableInput">
                    </div>
                    <div class="form-group">
                        <label for="">Keterangan</label>
                        <input type="text" class="form-control" autocomplete="off" name="descriptionInput" id="descriptionInput">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                    <button type="submit" class="btn btn-primary" id="submitTable"><i class="fa fa-check-circle"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $this->load->view('layouts/v_footer') ?>
<script>
    $(function() {
        let tableTable = $('#table').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            },
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url() ?>products/table/getTable",
                "type": "POST"
            },
            "columnDefs": [{
                "targets": [0],
                "orderable": false,
            },
            {
                "targets": [3],
                "orderable": false,
            }],
        });
        
        $('#modalForm').on('shown.bs.modal', function(e) {
            let button = $(e.relatedTarget)
            let trParents = button.parents().parents().closest('tr')
            let modal = $(this)
            let mode = button.data('mode')
            let id = button.data('id')
            let table = trParents.find('td:eq(1)').text()
            let description = trParents.find('td:eq(2)').text()

            modal.find('#tableInput').focus()

            if (mode == 'edit') {
                modal.find('.modal-title').html(`Edit Meja : <b>${table}</b>`)
                $('#tableForm').attr('action', `<?= base_url() ?>products/table/edit/${id}`)
                modal.find('#tableInput').val(table)
                modal.find('#descriptionInput').val(description)
                modal.find('#submitTable').attr('class', 'btn btn-warning')
                modal.find('#submitTable').html(`<i class="fa fa-edit"></i> Update`)
            } else {
                modal.find('.modal-title').text('Tambah Meja')
                $('#tableForm').attr('action', '<?= base_url() ?>products/table/store')
                modal.find('#tableInput').val('')
                modal.find('#descriptionInput').val('')
                modal.find('#submitTable').attr('class', 'btn btn-primary')
                modal.find('#submitTable').removeAttr('disabled')
                modal.find('#submitTable').html(`<i class="fa fa-check-circle"></i> Simpan`)

            }
        })

        $('#tableForm').validate({
            rules: {
                tableInput: {
                    required: true
                },
            },
            messages: {
                tableInput: {
                    required: "Kategori harus diisi"
                }
            }
        })
        
        $(document).on('submit', '#tableForm', function(e) {
            let action = $(this).attr('action')
            e.preventDefault()
            $.ajax({
                url: action,
                method: 'POST',
                data: $('#tableForm').serialize(),
                dataType: 'json',
                cache: false,
                success: function(response) {
                    if (response.status == true) {
                        $('#modalForm').modal('hide')
                        setTimeout(() => {
                            swal({
                                title: "Berhasil!",
                                text: response.message,
                                icon: "success",
                            }).then(function() {
                                tableTable.ajax.reload();
                            });
                        }, 350);
                    }
                }
            })
        })
        $('body').on('click', '.delete-table', function() {
            let trParents = $(this).parents().parents().closest('tr')
            let dataName = trParents.find('td:eq(1)').text()
            swal({
                    title: "Apakah kamu yakin?",
                    text: `Kategori ${dataName} akan dihapus?`,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((confirmDelete) => {
                    if (confirmDelete) {
                        let id = $(this).attr('data-id')
                        $.ajax({
                            url: `<?= base_url() ?>products/table/delete/${id}`,
                            type: 'DELETE',
                            dataType: 'json',
                            success: function(response) {
                                if (response.status == true) {
                                    swal({
                                        title: "Berhasil!",
                                        text: response.message,
                                        icon: "success",
                                    }).then(function() {
                                        tableTable.ajax.reload();
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