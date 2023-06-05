<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Easyfood | Panel</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/pace/pace.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <style>
    #myChartPie {
      height: 359px !important;
    }

    .select2-container .select2-selection--single {
      box-sizing: border-box;
      cursor: pointer;
      display: block;
      height: 35px;
      user-select: none;
      -webkit-user-select: none;
    }

    .display-table {
      display: table;
    }

    .w-100 {
      width: 100%;
    }

    .display-table-cell {
      display: table-cell;
    }

    .va-middle {
      vertical-align: middle;
    }

    .logo {
      display: inline-block;
    }

    .title {
      font-size: 26px;
      font-weight: bold;
      padding-left: 10px;
      display: inline-block;
      vertical-align: middle;
      line-height: 24px;
      color: #FFFFFF;
    }

    .address {
      font-size: 16px;
    }

    #tableSearchProduct {
      width: 100% !important;
    }

    .switch {
      position: relative;
      display: inline-block;
      width: 35px;
      height: 20px;
    }

    .switch input { 
      opacity: 0;
      width: 0;
      height: 0;
    }

    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 15px;
      width: 15px;
      left: 1px;
      bottom: 3px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
    }

    input:checked + .slider {
      background-color: #2196F3;
    }

    input:focus + .slider {
      box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
      -webkit-transform: translateX(17px);
      -ms-transform: translateX(17px);
      transform: translateX(17px);
    }

    /* Rounded sliders */
    .slider.round {
      border-radius: 34px;
    }

    .slider.round:before {
      border-radius: 50%;
    }

    label.error {
      color: red;
    }

    .d-none {
      display: none;
    }
  </style>
</head>

<body class="hold-transition skin-green layout-top-nav">
  <div class="wrapper">
    <header class="logo-header" style="background-color: #009556; padding: 15px 0 10px 0;">
      <div class="container-fluid" style="padding: 0 30px 5px 30px !important;">
        <div class="display-table w-100">
          <div class="display-table-cell va-middle">
            <?php
            $this->db->select('settings.*');
            $this->db->limit(1);
            $this->db->from('settings');
            $settings = $this->db->get()->row_array();
            ?>
            <div class="logo">
              <a href="<?= base_url() ?>dashboard">
                <img src="<?= !empty($settings['logo']) ? base_url() . 'assets/uploads/' . $settings['logo'] : 'https://upload.wikimedia.org/wikipedia/commons/0/0a/No-image-available.png'; ?>" width="70" alt="Logo">
              </a>
            </div>
            <div class="title">
              <?= !empty($settings['shop_name']) ? $settings['shop_name'] : 'Toko CAHAYA LAMPU' ?>
              <div class="address"><?= !empty($settings['address']) ? $settings['address'] : 'Jl. Raya CIRANJANG Tlp: 0852 3333 4145' ?></div>
            </div>
          </div>
        </div>
      </div>
  </div>
  </header>
  <header class="main-header">
    <nav class="navbar navbar-static-top" style="padding: 0 1em !important;">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul class="nav navbar-nav">
            <li class=""><a class="nav-link" href="<?= base_url() ?>dashboard"><i class="fa fa-home"></i> DASHBOARD</a></li>
            <li class=""><a class="nav-link" href="<?= base_url() ?>products/lists"><i class="fa fa-shopping-basket"></i> MENU</a></li>
            <li class=""><a class="nav-link" href="<?= base_url() ?>customers"><i class="fa fa-users"></i> PELANGGAN</a></li>
            <li class=""><a class="nav-link" href="<?= base_url() ?>products/category"><i class="fa fa-bars"></i> KATEGORI</a></li>
            <li class=""><a class="nav-link" href="<?= base_url() ?>products/table"><i class="fa fa-table  "></i> MEJA</a></li>
            <li class=""><a class="nav-link" href="<?= base_url() ?>transactions"><i class="fa fa-shopping-cart"></i> TRANSAKSI</a></li>
            <li class=""><a class="nav-link" href="<?= base_url() ?>users/lists"><i class="fa fa-users"></i> PENGGUNA</a></li>
          </ul>
        </div>
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="assets/dist/img/avatar5.png" class="user-image" alt="User Image">
                <span class="hidden-xs"><?= $this->session->userdata('name') ?></span>
              </a>
              <ul class="dropdown-menu">
                <li class="user-header">
                  <img src="assets/dist/img/avatar5.png" class="img-circle" alt="User Image">
                  <p>
                    <?= $this->session->userdata('name') ?>
                    <br>
                    Posisi : <?= !empty($this->session->userdata('roles')) ? strtoupper($this->session->userdata('roles')) : '<span class="label label-danger">belum set role</span>' ?>
                  </p>
                </li>
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="<?= base_url() ?>auth/profile/edit/<?= $this->session->userdata('users_id'); ?>" class="btn btn-warning btn-flat"><i class="fa fa-edit"></i> Edit Profile</a>
                  </div>
                  <div class="pull-right">
                    <a href="<?= base_url() ?>auth/login/logout" class="btn btn-primary btn-flat"><i class="fa fa-sign-out"></i> Logout</a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  <div class="content-wrapper">
    <div class="container-fluid content-page">