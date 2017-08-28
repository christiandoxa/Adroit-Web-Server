<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            Daftar Riwayat Jemur Adroit Web Server
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-jemur">
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
                    <th class="text-center" style="vertical-align: middle">ID Jemuran</th>
                    <th class="text-center" style="vertical-align: middle">Device ID</th>
                    <th class="text-center" style="vertical-align: middle">Tanggal Jemur</th>
                    <th class="text-center" style="vertical-align: middle">Estimasi Waktu</th>
                    <th class="text-center" style="vertical-align: middle">Email</th>
                    <th class="text-center" style="vertical-align: middle">Status</th>
                    <th class="text-center" style="vertical-align: middle">Edit atau Detail</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (!empty($jemur)) {
                    foreach ($jemur as $data) {
                        $icon = null;
                        if ($data->status == 'belum_kering') {
                            $icon = 'fa-minus';
                        } else {
                            $icon = 'fa-check';
                        }
                        echo '
                    <tr>
                    <td class="text-center" style="vertical-align: middle">' . $data->id_jemuran . '</td>
                    <td class="text-center" style="vertical-align: middle">' . $data->device_id . '</td>
                    <td class="text-center" style="vertical-align: middle">' . $data->tanggal_jemur . '</td>
                    <td class="text-center" style="vertical-align: middle;">' . $data->estimasi_waktu . '</td>
                    <td class="text-center" style="vertical-align: middle;">' . $data->estimasi_waktu . '</td>
                    <td class="text-center" style="vertical-align: middle">' . '<i class="fa ' . $icon . '"></i>' . '</td>
                    <td class="text-center" style="vertical-align: middle">
                        <a href="' . base_url('dashboard/hapus_riwayat_jemur?id=' . $data->id_jemuran) . '" class="btn btn-danger btn-sm">
                            <i class="glyphicon glyphicon-trash"></i> Hapus
                        </a>
                    </td>
                    </tr>
                    ';
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
        <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
</div>