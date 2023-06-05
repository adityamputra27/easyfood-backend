<?php $this->load->view('layouts/v_header') ?>
<section class="content-header">
    <h1>
        Data Pelanggan
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-shopping-bag"></i> Menu</a></li>
        <li class="active">Pelanggan</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="10px" class="text-center">No</th>
                                <th>Nama</th>
                                <th>Nomor Telepon</th>
                                <th>Alamat</th>
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
            <form action="<?= base_url() ?>customers/store" id="customersForm" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Tambah Pelanggan</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nama</label>
                        <input type="text" class="form-control" autocomplete="off" name="fullname" id="fullname">
                    </div>
                    <div class="form-group">
                        <label for="">Nomor Telepon</label>
                        <input type="text" class="form-control" autocomplete="off" name="phone" id="phone">
                    </div>
                    <div class="form-group">
                        <label for="">Alamat</label>
                        <input type="text" class="form-control" autocomplete="off" name="address" id="address">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
                    <button type="submit" class="btn btn-primary" id="submit"><i class="fa fa-check-circle"></i> Simpan</button>
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
                "url": "<?= base_url() ?>customers/getCustomers",
                "type": "POST"
            },
            "columnDefs": [{
                "targets": [0],
                "orderable": false,
            },
            {
                "targets": [4],
                "orderable": false,
            }],
        });
        
        $('#modalForm').on('shown.bs.modal', function(e) {
            let button = $(e.relatedTarget)
            let trParents = button.parents().parents().closest('tr')
            let modal = $(this)
            let mode = button.data('mode')
            let id = button.data('id')
            let fullname = trParents.find('td:eq(1)').text()
            let phone = trParents.find('td:eq(2)').text()
            let address = trParents.find('td:eq(3)').text()

            modal.find('#fullname').focus()

            if (mode == 'edit') {
                modal.find('.modal-title').html(`Edit Pelanggan : <b>${fullname}</b>`)
                $('#customersForm').attr('action', `<?= base_url() ?>customers/edit/${id}`)
                modal.find('#fullname').val(fullname)
                modal.find('#phone').val(phone)
                modal.find('#address').val(address)
                modal.find('#submit').attr('class', 'btn btn-warning')
                modal.find('#submit').html(`<i class="fa fa-edit"></i> Update`)
            } else {
                modal.find('.modal-title').text('Tambah Pelanggan')
                $('#customersForm').attr('action', '<?= base_url() ?>customers/store')
                modal.find('#fullname').val('')
                modal.find('#phone').val('')
                modal.find('#address').val('')
                modal.find('#submit').attr('class', 'btn btn-primary')
                modal.find('#submit').removeAttr('disabled')
                modal.find('#submit').html(`<i class="fa fa-check-circle"></i> Simpan`)

            }
        })

        $('#customersForm').validate({
            rules: {
                fullname: {
                    required: true
                },
                phone: {
                    required: true
                },
            },
            messages: {
                fullname: {
                    required: "Nama harus diisi"
                },
                fullname: {
                    required: "Nompr telepon harus diisi"
                }
            }
        })
        
        $(document).on('submit', '#customersForm', function(e) {
            let action = $(this).attr('action')
            e.preventDefault()
            $.ajax({
                url: action,
                method: 'POST',
                data: $('#customersForm').serialize(),
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
        $('body').on('click', '.delete-customers', function() {
            let trParents = $(this).parents().parents().closest('tr')
            let dataName = trParents.find('td:eq(1)').text()
            swal({
                    title: "Apakah kamu yakin?",
                    text: `Pelanggan ${dataName} akan dihapus?`,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((confirmDelete) => {
                    if (confirmDelete) {
                        let id = $(this).attr('data-id')
                        $.ajax({
                            url: `<?= base_url() ?>customers/delete/${id}`,
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