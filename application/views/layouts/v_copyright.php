                    </section>
                </div>
            </div>
            <footer class="main-footer">
                <div class="container-fluid">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 2.4.13
                </div>
                <strong>Copyright &copy; <?= date('Y') ?> <a href="https://madtive.com" target="_blank">Madtive Studio  </a>.</strong> All rights
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
        <!-- FastClick -->
        <script src="<?= base_url() ?>assets/bower_components/fastclick/lib/fastclick.js"></script>
        <!-- AdminLTE App -->
        <script src="<?= base_url() ?>assets/dist/js/adminlte.min.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="<?= base_url() ?>assets/dist/js/demo.js"></script>
        <!-- DataTables -->
        <script src="<?= base_url() ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="<?= base_url() ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
        <script>
            $(function () {
                $('.nav-link').on('click', function (e) {
                    e.preventDefault();
                    let pageLink = $(this).attr('href')
                    callPage(pageLink)
                    // alert(pageLink)
                })

                function callPage(pageLinkInput) {
                    $.ajax({
                        url: pageLinkInput,
                        type: "GET",
                        dataType: "text",
                        success:function(response) {
                            $('.content-page').html(response)
                        }
                    })
                }
            })
        </script>