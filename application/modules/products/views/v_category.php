<?php $this->load->view('layouts/v_header') ?>
<section class="content-header">
    <h1>
        Data Kategori Menu
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-shopping-bag"></i> Menu</a></li>
        <li class="active">Kategori Menu</li>
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
                    <table id="category" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="10px" class="text-center">No</th>
                                <th>Nama</th>
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
            <form action="<?= base_url() ?>products/category/store" id="categoryForm" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Tambah Kategori Menu</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nama</label>
                        <input type="text" class="form-control" autocomplete="off" name="categoryInput" id="categoryInput">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                    <button type="submit" class="btn btn-primary" id="submitCategory"><i class="fa fa-check-circle"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $this->load->view('layouts/v_footer') ?>
<script>
    $(function() {
        let tableCategory = $('#category').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            },
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url() ?>products/category/getCategory",
                "type": "POST"
            },
            "columnDefs": [{
                "targets": [0],
                "orderable": false,
            },
            {
                "targets": [2],
                "orderable": false,
            }],
        });
        
        $('#modalForm').on('shown.bs.modal', function(e) {
            let button = $(e.relatedTarget)
            let trParents = button.parents().parents().closest('tr')
            let modal = $(this)
            let mode = button.data('mode')
            let id = button.data('id')
            let category = trParents.find('td:eq(1)').text()

            modal.find('#categoryInput').focus()

            if (mode == 'edit') {
                modal.find('.modal-title').html(`Edit Kategori Menu : <b>${category}</b>`)
                $('#categoryForm').attr('action', `<?= base_url() ?>products/category/edit/${id}`)
                modal.find('#categoryInput').val(category)
                modal.find('#submitCategory').attr('class', 'btn btn-warning')
                modal.find('#submitCategory').html(`<i class="fa fa-edit"></i> Update`)
            } else {
                modal.find('.modal-title').text('Tambah Kategori Menu')
                $('#categoryForm').attr('action', '<?= base_url() ?>products/category/store')
                modal.find('#categoryInput').val('')
                modal.find('#submitCategory').attr('class', 'btn btn-primary')
                modal.find('#submitCategory').removeAttr('disabled')
                modal.find('#submitCategory').html(`<i class="fa fa-check-circle"></i> Simpan`)

            }
        })

        $('#categoryForm').validate({
            rules: {
                categoryInput: {
                    required: true
                }
            },
            messages: {
                categoryInput: {
                    required: "Kategori harus diisi"
                }
            }
        })
        
        $(document).on('submit', '#categoryForm', function(e) {
            let action = $(this).attr('action')
            e.preventDefault()
            $.ajax({
                url: action,
                method: 'POST',
                data: $('#categoryForm').serialize(),
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
                                tableCategory.ajax.reload();
                            });
                        }, 350);
                    }
                }
            })
        })
        $('body').on('click', '.delete-category', function() {
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
                            url: `<?= base_url() ?>products/category/delete/${id}`,
                            type: 'DELETE',
                            dataType: 'json',
                            success: function(response) {
                                if (response.status == true) {
                                    swal({
                                        title: "Berhasil!",
                                        text: response.message,
                                        icon: "success",
                                    }).then(function() {
                                        tableCategory.ajax.reload();
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