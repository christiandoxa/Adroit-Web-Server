<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            Daftar Pelanggan Baru Adroit Web Server
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-pelanggan-baru">
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
                    <th class="text-center" style="vertical-align: middle">Telepon</th>
                    <th class="text-center" style="vertical-align: middle">Pre Order</th>
                    <th class="text-center" style="vertical-align: middle">Edit atau Detail</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($pelanggan_baru as $data) {
                    $icon = null;
                    if ($data->pre_order == 'belum') {
                        $icon = 'fa-minus';
                    } else {
                        $icon = 'fa-check';
                    }
                    echo '
                    <tr>
                    <td class="text-center" style="vertical-align: middle">' . $data->nama_pelanggan . '</td>
                    <td class="text-center" style="vertical-align: middle">' . $data->email . '</td>
                    <td class="text-center" style="vertical-align: middle; max-width: 150px; overflow: hidden;text-overflow: ellipsis">' . $data->nomor_telepon . '</td>
                    <td class="text-center" style="vertical-align: middle;">' . '<i class="fa ' . $icon . '"></i>' . '</td>
                    <td class="text-center" style="vertical-align: middle">
                        <a href="' . base_url('dashboard/detail_pelanggan_baru?email=' . $data->email) . '" class="btn btn-info btn-sm">
                            <i class="glyphicon glyphicon-search"></i> Lihat
                        </a>
                        <a href="' . base_url('dashboard/hapus_pelanggan_baru?email=' . $data->email) . '" class="btn btn-danger btn-sm">
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