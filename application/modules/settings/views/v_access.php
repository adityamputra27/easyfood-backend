<?php $this->load->view('layouts/v_header') ?>
<section class="content-header">
  <h1>
    Data Role
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-users active"></i> Role</a></li>
    <li><a href="#">Data Role</a></li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header">
          <div class="btn-group">
            <a href="#" class="btn btn-primary" data-toggle="modal" data-mode="tambah" data-target="#roleModal"><i class="fa fa-plus-circle"></i> Tambah</a>
          </div>
        </div>
        <div class="box-body">
          <table id="role" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th width="10px" class="text-center">No</th>
                <th>Nama Role</th>
                <th width='200px' class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="modal fade" id="roleModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="roleForm" method="POST">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="" class="col-sm-3 col-form-label">Nama</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" autocomplete="off" name="name" id="name">
                </div>
            </div>
            <div id="accessModuleModal"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
          <button type="submit" class="btn btn-primary" id="submitRole"><i class="fa fa-check-circle"></i> Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php $this->load->view('layouts/v_footer') ?>
<script>
  $(function() {
    let tableRoles = $('#role').DataTable({
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
      },
      "processing": true,
      "serverSide": true,
      "order": [],
      "ajax": {
        "url": "<?= base_url() ?>settings/access/getRoles",
        "type": "POST"
      },
      "columnDefs": [
        {
          "targets": [0],
          "orderable": false,
        },
        {
          "targets": [2],
          "orderable": false,
          "className": "text-center"
        },
      ],
    });
    
    $('#roleModal').on('show.bs.modal', function(e) {
      let button = $(e.relatedTarget)
      let modal = $(this)
      let mode = button.data('mode')

      if (mode == 'edit') {
        let id = button.data('id')
        let name = button.data('name')

        modal.find('.modal-title').html(`Edit Role : <b>${name}</b>`)
        modal.find('#roleForm').attr('action', `<?= base_url() ?>settings/access/update/${id}`)

        modal.find('.modal-body #name').val(name)

        modal.find('#submitRole').attr('class', 'btn btn-warning')
        modal.find('#submitRole').html(`<i class="fa fa-edit"></i> Update`)

        $('#accessModuleModal').load(`<?= base_url() ?>settings/access/getAccessModules/${id}`)
      } else {
        modal.find('.modal-title').text('Tambah Role')
        modal.find('#roleForm').attr('action', '<?= base_url() ?>settings/access/store')
        modal.find('#roleForm').trigger('reset')
        modal.find('#submitRole').attr('class', 'btn btn-primary')
        modal.find('#submitRole').html(`<i class="fa fa-check-circle"></i> Simpan`)
        $('#accessModuleModal').load(`<?= base_url() ?>settings/access/getAccessModules`)
      }
    })

    $('#roleForm').validate({
        rules: {
            name: {
                required: true
            },
        },
        messages: {
            name: {
                required: "Nama harus diisi"
            },
        }
    })
    
    $(document).on('submit', '#roleForm', function(e) {
      e.preventDefault()

      let action = $(this).attr('action')
      $.ajax({
        url: action,
        type: 'POST',
        data: $('#roleForm').serialize(),
        dataType: 'json',
        success: function(response) {
          if (response.status == true) {
            $('#roleModal').modal('hide')
            swal({
              title: "Berhasil!",
              text: response.message,
              icon: "success",
            }).then(function() {
              location.reload()
            });
          }
        }
      })
    })

    $('body').on('click', '.delete-roles', function () {
      let trParents = $(this).parents().parents().closest('tr')
      let dataName = trParents.find('td:eq(1)').text()
      swal({
          title: "Apakah kamu yakin?",
          text: `Role ${dataName} akan dihapus?`,
          icon: "warning",
          buttons: true,
          dangerMode: true,
      })
      .then((confirmDelete) => {
          if (confirmDelete) {
              let id = $(this).attr('data-id')
              $.ajax({
                  url: `<?= base_url() ?>settings/access/delete/${id}`,
                  type: 'DELETE',
                  dataType: 'json',
                  success: function (response) {
                      if (response.status == true) {
                          swal({
                              title: "Berhasil!",
                              text: response.message,
                              icon: "success",
                          }).then(function () {
                              tableRoles.ajax.reload();
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