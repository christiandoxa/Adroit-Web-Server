<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Adroit Web Server</title>
    <link rel="icon" href="<?php echo base_url('assets/main/') ?>images/favicon.png">
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url() ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url() ?>assets/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url() ?>assets/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?php echo base_url() ?>assets/vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url() ?>assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet"
          type="text/css">

    <!-- DataTables CSS -->
    <link href="<?php echo base_url() ?>assets/vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="<?php echo base_url() ?>assets/vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo base_url('dashboard') ?>">Adroit Web Server</a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
            <!-- /.dropdown -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="<?php echo base_url('dashboard/logout') ?>"><i class="fa fa-sign-out fa-fw"></i>
                            Keluar</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-home fa-fw"></i> Beranda</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('dashboard/tambah_pengguna') ?>"><i
                                    class="fa fa-user-plus fa-fw"></i> Pengguna</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('dashboard/tambah_perangkat') ?>"><i
                                    class="fa fa-mobile-phone fa-fw"></i> Perangkat</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('dashboard/daftar_pengguna') ?>"><i
                                    class="fa fa-user fa-fw"></i> Daftar Pengguna</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('dashboard/daftar_perangkat') ?>"><i
                                    class="fa fa-cloud fa-fw"></i> Daftar Perangkat</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('dashboard/daftar_pesan') ?>"><i
                                    class="fa fa-comment fa-fw"></i> Daftar Pesan</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('dashboard/daftar_pelanggan') ?>"><i
                                    class="fa fa-users fa-fw"></i> Daftar Pelanggan</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('dashboard/daftar_riwayat_jemur') ?>"><i
                                    class="fa fa-list fa-fw"></i> Daftar Riwayat Jemur</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('dashboard/broadcast_email_pengguna') ?>"><i
                                    class="fa fa-bullhorn fa-fw"></i> Broadcast Email Pengguna</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('dashboard/broadcast_email_pelanggan') ?>"><i
                                    class="fa fa-bullhorn fa-fw"></i> Broadcast Email Pelanggan</a>
                    </li>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <?php
                    if (!empty($judul))
                        echo $judul;
                    ?>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <?php
            if (!empty($main_view)) {
                $this->load->view($main_view);
            }
            ?>
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="<?php echo base_url() ?>assets/vendor/jquery/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="<?php echo base_url() ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="<?php echo base_url() ?>assets/vendor/metisMenu/metisMenu.min.js"></script>

<!-- Morris Charts JavaScript -->
<script src="<?php echo base_url() ?>assets/vendor/raphael/raphael.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendor/morrisjs/morris.min.js"></script>
<script src="<?php echo base_url() ?>assets/data/morris-data.js"></script>

<!-- Custom Theme JavaScript -->
<script src="<?php echo base_url() ?>assets//dist/js/sb-admin-2.js"></script>

<!-- DataTables JavaScript -->
<script src="<?php echo base_url() ?>assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendor/datatables-responsive/dataTables.responsive.js"></script>
<script src="<?php echo base_url() ?>assets/template/table.js"></script>
</body>

</html>