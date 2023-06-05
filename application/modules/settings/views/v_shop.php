<?php $this->load->view('layouts/v_header') ?>
<section class="content-header">
  <h1>
    Pengaturan Toko
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cog"></i> Setting</a></li>
    <li class="active">Pengaturan Toko</li>
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
            <?php } ?>
          <form action="<?= base_url() ?>settings/shop/store" method="POST" enctype="multipart/form-data">
            <div class="form-group row">
              <label for="" class="col-sm-3 col-form-label" style="line-height: 2.5;">Nama Toko</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="shop_name" value="<?= $settings['shop_name'] ?>">
                <input type="hidden" class="form-control" name="id" value="<?= $settings['id'] ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-3 col-form-label" style="line-height: 2.5;">Alamat</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="address" value="<?= $settings['address'] ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-3 col-form-label" style="line-height: 2.5;">No. Telp</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="phone" value="<?= $settings['phone'] ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-3 col-form-label" style="line-height: 2.5;">Logo</label>
              <div class="col-sm-9">
                <input type="file" class="form-control" name="logo">
                <input type="hidden" class="form-control" name="old_logo" value="<?= base_url().'assets/uploads/'.$settings['logo']; ?>"> 
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-9 pull-right">
                <img src="<?= !empty($settings['logo']) ? base_url().'assets/uploads/'.$settings['logo'] : 'https://upload.wikimedia.org/wikipedia/commons/0/0a/No-image-available.png'; ?>" width="100" alt="">
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-3 col-form-label" style="line-height: 2.5;">Prefix Barcode</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="prefix_barcode" value="<?= $settings['prefix_barcode'] ?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-3 col-form-label" style="line-height: 2.5;">Prefix Nota</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="prefix_invoice" value="<?= $settings['prefix_invoice'] ?>">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-9 pull-right">
                <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i> Simpan</button>
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