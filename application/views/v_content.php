<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>POS | Toko Cahaya Lampu</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">

  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/skins/_all-skins.min.css">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Pace style -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/pace/pace.min.css">
  <!-- Select2 css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
  <style>
    .table {
      display: table;
    }

    .table-row {
      display: table-row;
    }

    .table-cell {
      display: table-cell;
    }

    .table-cell h5 {
      text-align: left;
    }

    .select2-container .select2-selection--single {
      box-sizing: border-box;
      cursor: pointer;
      display: block;
      height: 35px;
      user-select: none;
      -webkit-user-select: none;
    }
  </style>
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->

<body class="hold-transition skin-blue layout-top-nav">
  <div class="wrapper">
    <header class="logo-header" style="background-color: #2c7cab; padding: 15px 0 10px 0;">
      <!-- 2c7cab -->
      <!-- 3c8dbc -->
      <div class="container-fluid" style="padding: 0 40px !important;">
        <img src="http://cl-owner.my.id/application/azkasir/daddy/assets/images/logo.png" class="mt-2" width="70" alt="">
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
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
            <ul class="nav navbar-nav">
              <li class=""><a class="nav-link" href="<?= base_url() ?>dashboard"><i class="fa fa-home"></i> DASHBOARD</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-shopping-bag"></i> PRODUK</a>
                <ul class="dropdown-menu" role="menu">
                  <li><a class="nav-link" href="<?= base_url() ?>products/category">KATEGORI PRODUK</a></li>
                  <li><a class="nav-link" href="<?= base_url() ?>products/unit">SATUAN PRODUK</a></li>
                  <li><a class="nav-link" href="<?= base_url() ?>products/lists">DATA PRODUK</a></li>
                </ul>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-external-link"></i> STOK</a>
                <ul class="dropdown-menu" role="menu">
                  <li><a class="nav-link" href="<?= base_url() ?>stocks/stock_in">STOK MASUK</a></li>
                  <li><a class="nav-link" href="<?= base_url() ?>stocks/stock_out">STOK KELUAR</a></li>
                </ul>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-shopping-cart"></i> TRANSAKSI</a>
                <ul class="dropdown-menu" role="menu">
                  <li><a class="nav-link" href="#">TRANSAKSI PENJUALAN</a></li>
                  <li><a class="nav-link" href="<?= base_url() ?>transactions/income">PEMASUKKAN</a></li>
                  <li><a class="nav-link" href="<?= base_url() ?>transactions/expenditure">PENGELUARAN</a></li>
                </ul>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bar-chart"></i> LAPORAN</a>
                <ul class="dropdown-menu" role="menu">
                  <li><a class="nav-link" href="#">LAPORAN PENJUALAN</a></li>
                  <li><a class="nav-link" href="#">LAPORAN KEUNTUNGAN</a></li>
                  <li><a class="nav-link" href="#">LAPORAN STOK MASUK</a></li>
                  <li><a class="nav-link" href="#">LAPORAN STOK KELUAR</a></li>
                  <li><a class="nav-link" href="#">LAPORAN KAS</a></li>
                </ul>
              </li>
              <li class=""><a class="nav-link" href="#"><i class="fa fa-cog"></i> SETTING</a></li>
              <li class=""><a class="nav-link" href="<?= base_url() ?>users/user"><i class="fa fa-users"></i> PENGGUNA</a></li>
            </ul>
          </div>
          <!-- /.navbar-collapse -->
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Notifications Menu -->
              <li class="dropdown notifications-menu">
                <!-- Menu toggle button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-warning">10</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have 10 notifications</li>
                  <li>
                    <!-- Inner Menu: contains the notifications -->
                    <ul class="menu">
                      <li>
                        <!-- start notification -->
                        <a href="#">
                          <i class="fa fa-users text-aqua"></i> 5 new members joined today
                        </a>
                      </li>
                      <!-- end notification -->
                    </ul>
                  </li>
                  <li class="footer"><a href="#">View all</a></li>
                </ul>
              </li>
              <!-- User Account Menu -->
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <!-- The user image in the navbar-->
                  <img src="<?= base_url() ?>assets/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
                  <span class="hidden-xs">Alexander Pierce</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- The user image in the menu -->
                  <li class="user-header">
                    <img src="<?= base_url() ?>assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                    <p>
                      Alexander Pierce - Web Developer
                      <small>Member since Nov. 2012</small>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="#" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="#" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
          <!-- /.navbar-custom-menu -->
        </div>
        <!-- /.container-fluid -->
      </nav>
    </header>
    <div class="content-wrapper">
      <div class="container-fluid content-page">
        <section class="content-header">
          <h1>
            Dashboard
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Tables</a></li>
            <li class="active">Simple</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header">

                </div>
                <div class="box-body">

                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
        </section>
      </div>
    </div>
    <footer class="main-footer">
      <div class="container-fluid">
        <strong>Copyright &copy; <?= date('Y') ?> Toko Cahaya Lampu Supported By <a href="https://madtive.com" target="_blank">Madtive Studio </a>.</strong> All rights
        reserved.
      </div>
      <!-- /.container -->
    </footer>
  </div>
  <!-- ./wrapper -->
  <!-- jQuery 3 -->
  <script src="<?= base_url() ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="<?= base_url() ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- SlimScroll -->
  <script src="<?= base_url() ?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>

  <!-- date-range-picker -->
  <script src="<?= base_url() ?>assets/bower_components/moment/min/moment.min.js"></script>
  <script src="<?= base_url() ?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- bootstrap datepicker -->
  <script src="<?= base_url() ?>assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <!-- bootstrap time picker -->
  <script src="<?= base_url() ?>assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
  <!-- PACE -->
  <script src="<?= base_url() ?>assets/bower_components/PACE/pace.min.js"></script>
  <!-- FastClick -->
  <script src="<?= base_url() ?>assets/bower_components/fastclick/lib/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url() ?>assets/dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="<?= base_url() ?>assets/dist/js/demo.js"></script>
  <!-- DataTables -->
  <script src="<?= base_url() ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="<?= base_url() ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
  <script>
    $(document).ajaxStart(function() {
      Pace.restart();
    })

    function loadCategory() {
      $('#categoryIdInput').select2()
      $.ajax({
        url: '<?= base_url() ?>products/lists/loadCategory',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
          if (response.status == true) {
            $('#categoryIdInput').prop('disabled', false)
            // $('#categoryIdInput').append(`<option>${response.data[0].category_name}</option>`)
            response.data.forEach((e, i) => {
              $('#categoryIdInput').append(`<option value="${e.id}">${e.category_name}</option>`)
              // console.log(e, i)
            })
          } else {
            $('#categoryIdInput').prop('disabled', true)
          }
        }
      })
    }

    function loadUnit() {
      $('#unitProductInput').select2()
      $.ajax({
        url: '<?= base_url() ?>products/lists/loadUnit',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
          if (response.status == true) {
            $('#unitProductInput').prop('disabled', false)
            response.data.forEach((e, i) => {
              $('#unitProductInput').append(`<option value="${e.id}">${e.unit_name}</option>`)
            })
          } else {
            $('#unitProductInput').prop('disabled', true)
          }
        }
      })
    }

    function generateCurrency(angka, prefix) {
      var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

      if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
      }

      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
      return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
    }

    function currencyFormatRupiah(elemValue) {
      return $(elemValue).val(generateCurrency($(elemValue).val(), 'Rp. '))
    }

    function generateProductBarcode() {
      $.ajax({
        url: '<?= base_url() ?>products/lists/generateBarcode',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
          if (response.status == true) {
            $('#barcodeInput').val(response.barcode)
          }
        }
      })
    }


    $(function() {
      $('.nav-link').click(function(e) {
        e.preventDefault();
        let link = $(this).attr('href')
        $.ajax({
          url: link,
          type: 'GET',
          dataType: 'text',
          success: function(response) {
            $('.content-page').html(response)

            // Datatable
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
              }, ],
            });

            let tableUnit = $('#unit').DataTable({
              "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
              },
              "processing": true,
              "serverSide": true,
              "order": [],
              "ajax": {
                "url": "<?= base_url() ?>products/unit/getUnit",
                "type": "POST"
              },
              "columnDefs": [{
                "targets": [0],
                "orderable": false,
              }, ],
            });

            let tableProduct = $('#product').DataTable({
              "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
              },
              "processing": true,
              "serverSide": true,
              "order": [],
              "ajax": {
                "url": "<?= base_url() ?>products/lists/getProduct",
                "type": "POST"
              },
              "columnDefs": [{
                "targets": [0],
                "orderable": false,
              }, ],
            });

            //ieu teu anyar-anyar teuing
            let tableIncome = $('#income').DataTable({
              "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
              },
              "processing": true,
              "serverSide": true,
              "order": [],
              "ajax": {
                "url": "<?= base_url() ?>transactions/income/getIncome",
                "type": "POST"
              }
            });

            //ieu teu anyar-anyar teuing
            let tableExpenditure = $('#expenditure').DataTable({
              "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
              },
              "processing": true,
              "serverSide": true,
              "order": [],
              "ajax": {
                "url": "<?= base_url() ?>transactions/expenditure/getExpenditure",
                "type": "POST"
              }
            });

            //anyar elq
            let tableUser = $('#user').DataTable({
              "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
              },
              "processing": true,
              "serverSide": true,
              "order": [],
              "ajax": {
                "url": "<?= base_url() ?>users/user/getUser",
                "type": "POST"
              }
            });

            //anyar elq
            let tableStock_in = $('#stock_in').DataTable({
              "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
              },
              "processing": true,
              "serverSide": true,
              "order": [],
              "ajax": {
                "url": "<?= base_url() ?>stocks/stock_in/getStock_in",
                "type": "POST"
              }
            });

            //anyar elq
            let tableLoadProductModal = $('#product_modal').DataTable({
              "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
              },
              "processing": true,
              "serverSide": true,
              // "lengthChange": false,
              // "searching": false,
              "order": [],
              "ajax": {
                "url": "<?= base_url() ?>products/lists/loadProduct",
                "type": "POST"
              },
              "columnDefs": [{
                "targets": [0],
                "orderable": false,
              }, ],
            });

            //anyar elq
            let tableStock_out = $('#stock_out').DataTable({
              "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
              },
              "processing": true,
              "serverSide": true,
              "order": [],
              "ajax": {
                "url": "<?= base_url() ?>stocks/stock_out/getStock_out",
                "type": "POST"
              }
            });

            //anyar elq
            $(document).on('keyup', '#capitalPriceInput', function(e) {
              currencyFormatRupiah(this)
            })

            //anyar elq
            $(document).on('click', '#generateBarcode', function(e) {
              generateProductBarcode()
            })

            //Date picker //anyar elq
            let datepicker = $.fn.datepicker.noConflict();
            $.fn.bootstrapDP = datepicker;
            $(".datepicker").bootstrapDP({
              autoclose: true,
              language: 'id',
              format: "dd-mm-yyyy  <?= date('H:i:s') ?>"
            });

            // Crud
            // Insert / Update
            $('#productModal').on('show.bs.modal', function(e) {
              loadCategory()
              loadUnit()
            })

            $('#modalForm').on('show.bs.modal', function(e) {
              let button = $(e.relatedTarget)
              let trParents = button.parents().parents().closest('tr')
              let modal = $(this)
              let mode = button.data('mode')
              let id = button.data('id')
              let category = trParents.find('td:eq(1)').text()

              if (mode == 'edit') {
                modal.find('.modal-title').html(`Edit Kategori Produk : <b>${category}</b>`)
                $('#categoryForm').attr('action', `<?= base_url() ?>products/category/edit/${id}`)
                modal.find('#categoryInput').val(category)
                modal.find('#submitCategory').attr('class', 'btn btn-warning')
                modal.find('#submitCategory').html(`<i class="fa fa-edit"></i> Update`)

                $('body').on('click', '#submitCategory', function() {
                  let action = $(this).parents().parents().attr('action')
                  $.ajax({
                    url: action,
                    type: 'POST',
                    data: $('#categoryForm').serialize(),
                    dataType: 'json',
                    success: function(response) {
                      if (response.status == true) {
                        $('#modalForm').modal('hide')
                        swal({
                          title: "Berhasil!",
                          text: response.message,
                          icon: "success",
                        }).then(function() {
                          tableCategory.ajax.reload();
                        });
                      }
                    }
                  })
                })

              } else {
                modal.find('.modal-title').text('Tambah Kategori Produk')
                $('#categoryForm').attr('action', '<?= base_url() ?>products/category/store')
                modal.find('#categoryInput').val('')
                modal.find('#submitCategory').attr('class', 'btn btn-primary')
                modal.find('#submitCategory').removeAttr('disabled')
                modal.find('#submitCategory').html(`<i class="fa fa-check-circle"></i> Simpan`)

                $('#submitCategory').on('click', function() {
                  $(this).prop('disabled', true)
                  let action = $(this).parents().parents().attr('action')
                  $.ajax({
                    url: action,
                    type: 'POST',
                    data: $('#categoryForm').serialize(),
                    dataType: 'json',
                    cache: false,
                    success: function(response) {
                      if (response.status == true) {
                        $('#modalForm').modal('hide')
                        swal({
                          title: "Berhasil!",
                          text: response.message,
                          icon: "success",
                        }).then(function() {
                          tableCategory.ajax.reload();
                        });
                      }
                    }
                  })
                })
              }
            })

            $('#unitModal').on('show.bs.modal', function(e) {
              let button = $(e.relatedTarget)
              let trParents = button.parents().parents().closest('tr')
              let modal = $(this)
              let mode = button.data('mode')
              let id = button.data('id')
              let unit = trParents.find('td:eq(1)').text()

              if (mode == 'edit') {
                modal.find('.modal-title').html(`Edit Unit Produk : <b>${unit}</b>`)
                $('#unitForm').attr('action', `<?= base_url() ?>products/unit/edit/${id}`)
                modal.find('#unitInput').val(unit)
                modal.find('#submitUnit').attr('class', 'btn btn-warning')
                modal.find('#submitUnit').html(`<i class="fa fa-edit"></i> Update`)

                $('body').on('click', '#submitUnit', function() {
                  let action = $(this).parents().parents().attr('action')
                  $.ajax({
                    url: action,
                    type: 'POST',
                    data: $('#unitForm').serialize(),
                    dataType: 'json',
                    success: function(response) {
                      if (response.status == true) {
                        $('#unitModal').modal('hide')
                        swal({
                          title: "Berhasil!",
                          text: response.message,
                          icon: "success",
                        }).then(function() {
                          tableUnit.ajax.reload();
                        });
                      }
                    }
                  })
                })
              } else {
                modal.find('.modal-title').text('Tambah Unit Produk')
                $('#unitForm').attr('action', '<?= base_url() ?>products/unit/store')
                modal.find('#unitInput').val('')
                modal.find('#submitUnit').attr('class', 'btn btn-primary')
                modal.find('#submitUnit').html(`<i class="fa fa-check-circle"></i> Simpan`)

                $('body').on('click', '#submitUnit', function(e) {
                  e.preventDefault()
                  let action = $(this).parents().parents().attr('action')
                  $.ajax({
                    url: action,
                    type: 'POST',
                    data: $('#unitForm').serialize(),
                    dataType: 'json',
                    success: function(response) {
                      if (response.status == true) {
                        $('#unitModal').modal('hide')
                        swal({
                          title: "Berhasil!",
                          text: response.message,
                          icon: "success",
                        }).then(function() {
                          tableUnit.ajax.reload();
                        });
                      }
                    }
                  })
                })
              }
            })

            $('#productModal').on('show.bs.modal', function(e) {
              generateProductBarcode()
              let button = $(e.relatedTarget)
              let trParents = button.parents().parents().closest('tr')
              let modal = $(this)
              let mode = button.data('mode')
              let id = button.data('id')
              let barcode = trParents.find('td:eq(1)').text()
              let name = trParents.find('td:eq(2)').text()
              let satuan = trParents.find('td:eq(3)').text()
              let kategori = trParents.find('td:eq(4)').text()
              let h_modal = trParents.find('td:eq(5)').text()
              let jual = trParents.find('td:eq(6)').text()
              let stok = trParents.find('td:eq(7)').text()

              if (mode == 'edit') {
                modal.find('.modal-title').html(`Edit Produk : <b>${name}</b>`)
                $('#productForm').attr('action', `<?= base_url() ?>products/lists/edit/${id}`)
                modal.find('#barcodeInput').val(barcode)
                modal.find('#productNameInput').val(name)
                modal.find('#capitalPriceInput').val(h_modal)
                modal.find('#sellingPriceInput').val(jual)
                modal.find('#categoryIdInput').val(kategori)
                modal.find('#unitProductInput').val(satuan)
                modal.find('#stockInput').val(stok)
                modal.find('#submitProduct').attr('class', 'btn btn-warning')
                modal.find('#submitProduct').html(`<i class="fa fa-edit"></i> Update`)

                $('body').on('click', '#submitProduct', function() {
                  let action = $(this).parents().parents().attr('action')
                  $.ajax({
                    url: action,
                    type: 'POST',
                    data: $('#unitForm').serialize(),
                    dataType: 'json',
                    success: function(response) {
                      if (response.status == true) {
                        $('#productModal').modal('hide')
                        swal({
                          title: "Berhasil!",
                          text: response.message,
                          icon: "success",
                        }).then(function() {
                          tableProduct.ajax.reload();
                        });
                      }
                    }
                  })
                })
              } else {
                modal.find('.modal-title').text('Tambah Produk')
                $('#productForm').attr('action', '<?= base_url() ?>products/lists/store')
                modal.find('#barcodeInput').val('')
                modal.find('#productNameInput').val('')
                modal.find('#capitalPriceInput').val('')
                modal.find('#sellingPriceInput').val('')
                modal.find('#categoryIdInput').val('')
                modal.find('#unitProductInput').val('')
                modal.find('#stockInput').val('')
                modal.find('#informationInput').val('')
                modal.find('#submitProduct').attr('class', 'btn btn-primary')
                modal.find('#submitProduct').html(`<i class="fa fa-check-circle"></i> Simpan`)

                $('body').on('click', '#submitProduct', function(e) {
                  e.preventDefault()
                  let action = $(this).parents().parents().attr('action')
                  $.ajax({
                    url: action,
                    type: 'POST',
                    data: $('#productForm').serialize(),
                    dataType: 'json',
                    success: function(response) {
                      if (response.status == true) {
                        $('#productModal').modal('hide')
                        swal({
                          title: "Berhasil!",
                          text: response.message,
                          icon: "success",
                        }).then(function() {
                          tableProduct.ajax.reload();
                        });
                      }
                    }
                  })
                })
              }
            })

            //anyar elq
            $('#incomeModal').on('show.bs.modal', function(e) {
              let button = $(e.relatedTarget)
              let modal = $(this)

              modal.find('#incomeForm').trigger('reset')
              modal.find('#submitIncome').attr('class', 'btn btn-primary')
              modal.find('#submitIncome').html(`<i class="fa fa-check-circle"></i> Simpan`)

              $('body').off().on('click', '#submitIncome', function() {
                let action = $(this).parents().parents().attr('action')
                $.ajax({
                  url: action,
                  type: 'POST',
                  data: $('#incomeForm').serialize(),
                  dataType: 'json',
                  success: function(response) {
                    if (response.status == true) {
                      $('#incomeModal').modal('hide')
                      swal({
                        title: "Berhasil!",
                        text: response.message,
                        icon: "success",
                      }).then(function() {
                        tableIncome.ajax.reload();
                      });
                    }
                  }
                })
              })
            })

            //anyar elq
            $('#expenditureModal').on('show.bs.modal', function(e) {
              let button = $(e.relatedTarget)
              let modal = $(this)
              let mode = button.data('mode')

              if (mode == 'edit') {
                let id = button.data('id')
                let date = button.data('date')
                let total = button.data('total')
                let description = button.data('description')

                modal.find('.modal-title').text(`Edit Pengeluaran`)
                modal.find('#expenditureForm').attr('action', `<?= base_url() ?>transactions/expenditure/edit/${id}`)

                modal.find('.modal-body #date').val(date)
                modal.find('.modal-body #total').val(total)
                modal.find('.modal-body #description').text(description)

                modal.find('#submitExpenditure').attr('class', 'btn btn-warning')
                modal.find('#submitExpenditure').html(`<i class="fa fa-edit"></i> Update`)

                $('body').on('click', '#submitExpenditure', function() {
                  let action = $(this).parents().parents().attr('action')
                  $.ajax({
                    url: action,
                    type: 'POST',
                    data: $('#expenditureForm').serialize(),
                    dataType: 'json',
                    success: function(response) {
                      if (response.status == true) {
                        $('#expenditureModal').modal('hide')
                        swal({
                          title: "Berhasil!",
                          text: response.message,
                          icon: "success",
                        }).then(function() {
                          tableExpenditure.ajax.reload();
                        });
                      }
                    }
                  })
                })
              } else {
                modal.find('.modal-title').text('Tambah Pengeluaran')
                modal.find('#expenditureForm').attr('action', '<?= base_url() ?>transactions/expenditure/store')
                modal.find('#expenditureForm').trigger('reset')
                modal.find('.modal-body #description').text('')
                modal.find('#submitExpenditure').attr('class', 'btn btn-primary')
                modal.find('#submitExpenditure').html(`<i class="fa fa-check-circle"></i> Simpan`)

                $('body').off().on('click', '#submitExpenditure', function() {
                  let action = $(this).parents().parents().attr('action')
                  $.ajax({
                    url: action,
                    type: 'POST',
                    data: $('#expenditureForm').serialize(),
                    dataType: 'json',
                    success: function(response) {
                      if (response.status == true) {
                        $('#expenditureModal').modal('hide')
                        swal({
                          title: "Berhasil!",
                          text: response.message,
                          icon: "success",
                        }).then(function() {
                          tableExpenditure.ajax.reload();
                        });
                      }
                    }
                  })
                })
              }
            })

            //anyar elq
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

                modal.find('.modal-title').text(`Edit User : ${name}`)
                modal.find('#userForm').attr('action', `<?= base_url() ?>users/user/edit/${id}`)

                modal.find('.modal-body #name').val(name)
                modal.find('.modal-body #username').val(username)
                modal.find('.modal-body #roles_id').val(roles_id).trigger('change')
                modal.find('.modal-body #password').val(password).parent().parent().hide()

                modal.find('#submitUser').attr('class', 'btn btn-warning')
                modal.find('#submitUser').html(`<i class="fa fa-edit"></i> Update`)

                $('body').on('click', '#submitUser', function() {
                  let action = $(this).parents().parents().attr('action')
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
              } else {
                modal.find('.modal-title').text('Tambah User')
                modal.find('#userForm').attr('action', '<?= base_url() ?>users/user/store')
                modal.find('#userForm').trigger('reset')
                modal.find('.modal-body #password').parent().parent().show()
                modal.find('#submitUser').attr('class', 'btn btn-primary')
                modal.find('#submitUser').html(`<i class="fa fa-check-circle"></i> Simpan`)

                $('body').off().on('click', '#submitUser', function() {
                  let action = $(this).parents().parents().attr('action')
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
              }
            })

            //anyar elq
            $('#stock_inModal').on('show.bs.modal', function(e) {
              let button = $(e.relatedTarget)
              let modal = $(this)

              modal.find('#stock_inForm').trigger('reset')
              modal.find('#submitStock_in').attr('class', 'btn btn-primary')
              modal.find('#submitStock_in').html(`<i class="fa fa-check-circle"></i> Simpan`)

              $('body').off().on('click', '#submitStock_in', function() {
                let action = $(this).parents().parents().attr('action')
                $.ajax({
                  url: action,
                  type: 'POST',
                  data: $('#stock_inForm').serialize(),
                  dataType: 'json',
                  success: function(response) {
                    if (response.status == true) {
                      $('#stock_inModal').modal('hide')
                      swal({
                        title: "Berhasil!",
                        text: response.message,
                        icon: "success",
                      }).then(function() {
                        tableStock_in.ajax.reload();
                      });
                    }
                  }
                })
              })
            })

            //anyar elq
            $('#stock_outModal').on('show.bs.modal', function(e) {
              let button = $(e.relatedTarget)
              let modal = $(this)

              modal.find('#stock_outForm').trigger('reset')
              modal.find('#stock_outIncome').attr('class', 'btn btn-primary')
              modal.find('#stock_outIncome').html(`<i class="fa fa-check-circle"></i> Simpan`)

              $('body').off().on('click', '#stock_outIncome', function() {
                let action = $(this).parents().parents().attr('action')
                $.ajax({
                  url: action,
                  type: 'POST',
                  data: $('#stock_outForm').serialize(),
                  dataType: 'json',
                  success: function(response) {
                    if (response.status == true) {
                      $('#stock_outModal').modal('hide')
                      swal({
                        title: "Berhasil!",
                        text: response.message,
                        icon: "success",
                      }).then(function() {
                        tableStock_in.ajax.reload();
                      });
                    }
                  }
                })
              })
            })

            // Delete
            $(document).on('click', '.delete-category', function() {
              let trParents = $(this).parents().parents().closest('tr')
              let dataName = trParents.find('td:eq(1)').text()
              swal({
                  title: "Apakah kamu yakin?",
                  text: `Data ${dataName} akan dihapus?`,
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

            $(document).on('click', '.delete-unit', function() {
              let trParents = $(this).parents().parents().closest('tr')
              let dataName = trParents.find('td:eq(1)').text()
              swal({
                  title: "Apakah kamu yakin?",
                  text: `Data ${dataName} akan dihapus?`,
                  icon: "warning",
                  buttons: true,
                  dangerMode: true,
                })
                .then((confirmDelete) => {
                  if (confirmDelete) {
                    let id = $(this).attr('data-id')
                    $.ajax({
                      url: `<?= base_url() ?>products/unit/delete/${id}`,
                      type: 'DELETE',
                      dataType: 'json',
                      success: function(response) {
                        if (response.status == true) {
                          swal({
                            title: "Berhasil!",
                            text: response.message,
                            icon: "success",
                          }).then(function() {
                            tableUnit.ajax.reload();
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

            $(document).on('click', '.delete-product', function() {
              let trParents = $(this).parents().parents().closest('tr')
              let dataName = trParents.find('td:eq(2)').text()
              swal({
                  title: "Apakah kamu yakin?",
                  text: `Data ${dataName} akan dihapus?`,
                  icon: "warning",
                  buttons: true,
                  dangerMode: true,
                })
                .then((confirmDelete) => {
                  if (confirmDelete) {
                    let id = $(this).attr('data-id')
                    $.ajax({
                      url: `<?= base_url() ?>products/lists/delete/${id}`,
                      type: 'DELETE',
                      dataType: 'json',
                      success: function(response) {
                        if (response.status == true) {
                          swal({
                            title: "Berhasil!",
                            text: response.message,
                            icon: "success",
                          }).then(function() {
                            tableProduct.ajax.reload();
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
            //anyar elq
            $(document).on('click', '.delete-expenditure', function() {
              swal({
                  title: "Apakah kamu yakin?",
                  text: `Data pengeluaran akan dihapus?`,
                  icon: "warning",
                  buttons: true,
                  dangerMode: true,
                })
                .then((confirmDelete) => {
                  if (confirmDelete) {
                    let id = $(this).data('id')
                    $.ajax({
                      url: `<?= base_url() ?>transactions/expenditure/delete/${id}`,
                      type: 'DELETE',
                      dataType: 'json',
                      success: function(response) {
                        if (response.status == true) {
                          swal({
                            title: "Berhasil!",
                            text: response.message,
                            icon: "success",
                          }).then(function() {
                            tableExpenditure.ajax.reload();
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
            //anyar elq
            $(document).on('click', '.delete-user', function() {
              let trParents = $(this).parents().parents().closest('tr')
              let dataName = trParents.find('td:eq(1)').text()
              swal({
                  title: "Apakah kamu yakin?",
                  text: `Data ${dataName} akan dihapus?`,
                  icon: "warning",
                  buttons: true,
                  dangerMode: true,
                })
                .then((confirmDelete) => {
                  if (confirmDelete) {
                    let id = $(this).data('id')
                    $.ajax({
                      url: `<?= base_url() ?>users/user/delete/${id}`,
                      type: 'DELETE',
                      dataType: 'json',
                      success: function(response) {
                        if (response.status == true) {
                          swal({
                            title: "Berhasil!",
                            text: response.message,
                            icon: "success",
                          }).then(function() {
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

          }
        })
      })
    })
  </script>
</body>

</html>