<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            DataTables Advanced Tables
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                <?php
                if (!empty($notif)) {
                    echo '<div class="alert alert-danger alert-dismissable">';
                    echo '<button class="close" data-dismiss="alert">&times;</button>';
                    echo $notif;
                    echo '</div>';
                } else if (!empty($notifs)) {
                    echo '<div class="alert alert-success alert-dismissable">';
                    echo '<button class="close" data-dismiss="alert">&times;</button>';
                    echo $notifs;
                    echo '</div>';
                }
                ?>
                <thead>
                <tr>
                    <th class="text-center" style="vertical-align: middle">Nama</th>
                    <th class="text-center" style="vertical-align: middle">Email</th>
                    <th class="text-center" style="vertical-align: middle">Token</th>
                    <th class="text-center" style="vertical-align: middle">Edit atau Detail</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($pengguna as $data) {
                    echo '
                    <tr>
                    <td class="text-center" style="vertical-align: middle">' . $data->nama . '</td>
                    <td class="text-center" style="vertical-align: middle">' . $data->email . '</td>
                    <td class="text-center" style="vertical-align: middle; max-width: 150px; overflow: hidden;text-overflow: ellipsis";>' . $data->token . '</td>
                    <td class="text-center" style="vertical-align: middle">
                        <a href="' . base_url('dashboard/detail_pengguna?token=' . $data->token) . '" class="btn btn-info btn-sm">
                            <i class="glyphicon glyphicon-search"></i> Lihat
                        </a>
                        <a href="' . base_url('dashboard/hapus_pengguna?token=' . $data->token) . '" class="btn btn-danger btn-sm">
                            <i class="glyphicon glyphicon-trash"></i> Hapus
                        </a>
                    </td>
                    </tr>
                    ';
                }
                ?>
                </tbody>
            </table>
        </div>
        <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
</div>