<section class="content-header">
  <h1>
    Data Users
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-users active"></i> Pengguna</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header">
          <div class="btn-group">
            <a href="#" class="btn btn-primary" data-toggle="modal" data-mode="tambah" data-target="#userModal"><i class="fa fa-plus-circle"></i> Tambah</a>
          </div>
        </div>
        <div class="box-body">
          <table id="user" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th width="10px" class="text-center">No</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Posisi</th>
                <th width='120px' class="text-center">Aksi</th>
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
            <label for="" class="col-sm-3 col-form-label">Nama <span class="text-danger">*</span></label>
            <div class="col-sm-9">
              <input type="text" class="form-control" autocomplete="off" name="name" id="name">
            </div>
          </div>

          <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label">Username <span class="text-danger">*</span></label>
            <div class="col-sm-9">
              <input type="text" class="form-control" autocomplete="off" name="username" id="username">
            </div>
          </div>

          <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label">Password <span class="text-danger">*</span></label>
            <div class="col-sm-9">
              <input type="password" class="form-control" autocomplete="off" name="password" id="password">
            </div>
          </div>

          <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label">Posisi <span class="text-danger">*</span></label>
            <div class="col-sm-9">
              <select name="roles_id" id="roles_id" class="form-control" autocomplete="off">
                <option value="" disabled selected hidden>-- Pilih Posisi --</option>
                <?php foreach ($this->sistem_model->_get('roles', 'name-asc') as $row) : ?>
                  <option value="<?= $row['id'] ?>"><?= ucfirst($row['name']); ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
          <button type="button" class="btn btn-primary" id="submitUser"><i class="fa fa-check-circle"></i> Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
