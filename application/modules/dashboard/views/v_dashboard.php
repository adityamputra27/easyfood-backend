<?php 
    $this->load->view('layouts/v_header'); 
    $this->load->helper('time_helper');
?>
<section class="content-header">
    <h1>
    Dashboard
    </h1>
    <ol class="breadcrumb">
    <li><a href="#" class="active"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3><?= $totalProduct ?></h3>
                    <p>Total Menu</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3><?= $totalTransaction ?></h3>
                    <p>Total Seluruh Transaksi</p>
                </div>
                <div class="icon">
                    <i class="fa fa-shopping-cart"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3><?= $totalTransactionToday; ?></h3>
                    <p>Total Transaksi Hari Ini</p>
                </div>
                <div class="icon">
                    <i class="fa fa-arrow-circle-down"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3><?= $incomeTransactionToday; ?></h3>
                    <p>Total Pendapatan Hari Ini</p>
                </div>
                <div class="icon">
                    <i class="fa fa-area-chart"></i>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $this->load->view('layouts/v_footer') ?>
