<?php $this->load->view('layouts/v_header') ?>
<section class="content-header">
  <h1>
    Data Pengguna
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-users active"></i> Pengguna</a></li>
    <li><a href="#">Data Pengguna</a></li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header">
          <div class="btn-group">
            <a href="#" class="btn btn-success" data-toggle="modal" data-mode="tambah" data-target="#userModal"><i class="fa fa-plus-circle"></i> Tambah</a>
          </div>
        </div>
        <div class="box-body">
          <table id="user" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th width="10px" class="text-center">No</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Level</th>
                <th width='125px' class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="modal fade" id="userModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="userForm" method="POST">
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

          <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label">Username</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" autocomplete="off" name="username" id="username">
            </div>
          </div>

          <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label">Password</label>
            <div class="col-sm-9">
              <input type="password" class="form-control" autocomplete="off" name="password" id="password">
            </div>
          </div>

          <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label">Posisi</label>
            <div class="col-sm-9">
              <select name="roles_id" id="roles_id" class="form-control" autocomplete="off">
                <option value="" disabled selected hidden>-- Pilih Level --</option>
                <?php foreach ($this->sistem_model->_get('roles', 'name-asc') as $row) : ?>
                  <option value="<?= $row['id'] ?>"><?= ucfirst($row['name']); ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
          <button type="submit" class="btn btn-primary" id="submitUser"><i class="fa fa-check-circle"></i> Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php $this->load->view('layouts/v_footer') ?>
<script>
  $(function() {
    let tableUser = $('#user').DataTable({
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
      },
      "processing": true,
      "serverSide": true,
      "order": [],
      "ajax": {
        "url": "<?= base_url() ?>users/lists/getUser",
        "type": "POST"
      },
      "columnDefs": [
        {
          "targets": [0],
          "orderable": false,
        },
        {
          "targets": [4],
          "orderable": false,
          "className": "text-center"
        },
      ],
    });
    $('#userModal').on('show.bs.modal', function(e) {
      let button = $(e.relatedTarget)
      let modal = $(this)
      let mode = button.data('mode')

      if (mode == 'edit') {
        let id = button.data('id')
        let name = button.data('name')
        let username = button.data('username')
        let password = button.data('password')
        let roles_id = button.data('roles_id')

        modal.find('.modal-title').html(`Edit Pengguna : <b>${name}</b>`)
        modal.find('#userForm').attr('action', `<?= base_url() ?>users/lists/edit/${id}`)

        modal.find('.modal-body #name').val(name)
        modal.find('.modal-body #username').val(username)
        modal.find('.modal-body #roles_id').val(roles_id).trigger('change')
        modal.find('.modal-body #password').val(password).parent().parent().hide()

        modal.find('#submitUser').attr('class', 'btn btn-warning')
        modal.find('#submitUser').html(`<i class="fa fa-edit"></i> Update`)
      } else {
        modal.find('.modal-title').text('Tambah Pengguna')
        modal.find('#userForm').attr('action', '<?= base_url() ?>users/lists/store')
        modal.find('#userForm').trigger('reset')
        modal.find('.modal-body #password').parent().parent().show()
        modal.find('#submitUser').attr('class', 'btn btn-primary')
        modal.find('#submitUser').html(`<i class="fa fa-check-circle"></i> Simpan`)
      }
    })

    $('#userForm').validate({
        rules: {
            name: {
                required: true
            },
            username: {
                required: true
            },
            password: {
                required: true
            },
            roles_id: {
                required: true
            },
        },
        messages: {
            name: {
                required: "Nama harus diisi"
            },
            username: {
                required: "Username harus diisi"
            },
            password: {
                required: "Password harus diisi"
            },
            roles_id: {
                required: "Posisi harus diisi"
            }
        }
    })

    $(document).on('submit', '#userForm', function (e) {
      e.preventDefault()

      let action = $(this).attr('action')
      $.ajax({
        url: action,
        type: 'POST',
        data: $('#userForm').serialize(),
        dataType: 'json',
        success: function(response) {
          if (response.status == true) {
            $('#userModal').modal('hide')
            swal({
              title: "Berhasil!",
              text: response.message,
              icon: "success",
            }).then(function() {
              tableUser.ajax.reload();
            });
          }
        }
      })
    })

    $('body').on('click', '.delete-users', function () {
      let trParents = $(this).parents().parents().closest('tr')
      let dataName = trParents.find('td:eq(1)').text()
      swal({
          title: "Apakah kamu yakin?",
          text: `Pengguna ${dataName} akan dihapus?`,
          icon: "warning",
          buttons: true,
          dangerMode: true,
      })
      .then((confirmDelete) => {
          if (confirmDelete) {
              let id = $(this).attr('data-id')
              $.ajax({
                  url: `<?= base_url() ?>users/lists/delete/${id}`,
                  type: 'DELETE',
                  dataType: 'json',
                  success: function (response) {
                      if (response.status == true) {
                          swal({
                              title: "Berhasil!",
                              text: response.message,
                              icon: "success",
                          }).then(function () {
                              tableUser.ajax.reload();
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