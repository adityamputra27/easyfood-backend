
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Point Of Sales | Login</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/iCheck/square/blue.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <b>Easyfood Panel | Login</b>
  </div>
  <div class="login-box-body">
    <p class="login-box-msg">Silahkan login untuk memulai aktifitas anda.</p>

    <form action="<?= base_url() ?>auth/login/validate" method="POST" id="formLogin">
      <div class="form-group has-feedback">
        <input type="username" class="form-control" name="username" placeholder="Username">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <button type="submit" class="btn btn-success btn-block btn-flat"><i class="fa fa-sign-in"></i> Login</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script src="<?= base_url() ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?= base_url() ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/iCheck/icheck.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
    $('#formLogin').on('submit', function (e) {
        e.preventDefault()
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success:function(response) {
              $('#formLogin').trigger('reset')
              if (response.keterangan == 'yes') {
                  swal({
                      title: response.description,
                      icon: "success",
                  }).then(function () {
                      window.location.href = '<?= base_url() ?>dashboard'
                  })
              } else {
                  swal({
                      title: response.description,
                      icon: "error",
                  })
              }
            }
        })
    })
  });
</script>
</body>
</html>
