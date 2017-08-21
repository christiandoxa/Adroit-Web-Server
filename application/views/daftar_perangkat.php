<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            Daftar Perangkat Adroit Web Server
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-daftarPerangkat">
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
                    <th class="text-center" style="vertical-align: middle">Device ID</th>
                    <th class="text-center" style="vertical-align: middle">Status</th>
                    <th class="text-center" style="vertical-align: middle">Cahaya</th>
                    <th class="text-center" style="vertical-align: middle">Hujan</th>
                    <th class="text-center" style="vertical-align: middle">Servo</th>
                    <th class="text-center" style="vertical-align: middle">Mode</th>
                    <th class="text-center" style="vertical-align: middle">Edit atau Detail</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($perangkat as $data) {
                    echo '
                    <tr>
                    <td class="text-center" style="vertical-align: middle">' . $data->nama . '</td>
                    <td class="text-center" style="vertical-align: middle">' . $data->device_id . '</td>
                    <td class="text-center" style="vertical-align: middle">' . $data->status . '</td>
                    <td class="text-center" style="vertical-align: middle">' . $data->cahaya . '</td>
                    <td class="text-center" style="vertical-align: middle">' . $data->hujan . '</td>
                    <td class="text-center" style="vertical-align: middle">' . $data->servo . '</td>
                    <td class="text-center" style="vertical-align: middle">' . $data->auto . '</td>
                    <td class="text-center" style="vertical-align: middle">
                        <a href="' . base_url('dashboard/detail_perangkat?deviceid=' . $data->device_id) . '" class="btn btn-info btn-sm">
                            <i class="glyphicon glyphicon-search"></i> Lihat
                        </a>
                        <a href="' . base_url('dashboard/hapus_perangkat?deviceid=' . $data->device_id) . '" class="btn btn-danger btn-sm">
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