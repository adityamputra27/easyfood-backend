<?php $this->load->view('layouts/v_header') ?>
<section class="content-header">
  <h1>
    Edit Profile
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cog"></i> Setting</a></li>
    <li class="active">Edit Profile</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-6">
      <div class="box">
        <div class="box-body">
            <?php if($this->session->flashdata('success')) { ?>
            <div class="alert alert-success" role="alert" id="flash">
                <i class="fa fa-check-circle"></i> <?= $this->session->flashdata('success') ?>
            </div>
            <?php } elseif($this->session->flashdata('error')) {?>
            <div class="alert alert-danger" role="alert" id="flash">
                <i class="fa fa-exclamation-triangle"></i> <?= $this->session->flashdata('error') ?>
            </div>
            <?php } ?>
          <form action="<?= base_url() ?>auth/profile/store" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
              <label for="" class="col-sm-4 col-form-label" style="line-height: 2.5;">Nama Lengkap</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="name" value="<?= $profile['name'] ?>">
                <input type="hidden" class="form-control" name="id" value="<?= $profile['id'] ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-4 col-form-label" style="line-height: 2.5;">Username</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="username" value="<?= $profile['username'] ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-4 col-form-label" style="line-height: 2.5;">Avatar</label>
              <div class="col-sm-8">
                <input type="file" class="form-control" name="avatar">
                <input type="hidden" class="form-control" name="old_avatar" value="<?= base_url().'assets/uploads/'.$profile['avatar']; ?>"> 
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-8 pull-right">
                <img src="<?= !empty($profile['avatar']) ? base_url().'assets/uploads/'.$profile['avatar'] : base_url().'assets/uploads/default.png'; ?>" width="100" alt="">
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-4 col-form-label" style="line-height: 2.5;">Password Baru</label>
              <div class="col-sm-8">
                <input type="password" class="form-control" name="new_password">
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-4 col-form-label" style="line-height: 2.5;">Konfirmasi Password</label>
              <div class="col-sm-8">
                <input type="password" class="form-control" name="confirm_password">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-8 pull-right">
                <button type="submit" class="btn btn-warning"><i class="fa fa-check-circle"></i> Update</button>
              </div>
            </div>
          </form>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
</section>
<?php $this->load->view('layouts/v_footer') ?>
<script>
  $(function () {
    setTimeout(function () {
      $('#flash').fadeTo(300, 0).slideUp(300, function () {
        $(this).remove()
      })
    }, 3000);
  })
</script>