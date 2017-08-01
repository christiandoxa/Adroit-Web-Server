<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            Daftar Pesan Pengguna Adroit Web Server
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
                    <th class="text-center" style="vertical-align: middle">Email</th>
                    <th class="text-center" style="vertical-align: middle">Nama</th>
                    <th class="text-center" style="vertical-align: middle">Pesan</th>
                    <th class="text-center" style="vertical-align: middle">Tanggal</th>
                    <th class="text-center" style="vertical-align: middle">Status</th>
                    <th class="text-center" style="vertical-align: middle">Edit atau Detail</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($pesan as $data) {
                    $icon = null;
                    if ($data->status == 'belum_dibalas') {
                        $icon = 'fa-minus';
                    } else {
                        $icon = 'fa-check';
                    }
                    echo '
                    <tr>
                    <td class="text-center" style="vertical-align: middle">' . $data->email . '</td>
                    <td class="text-center" style="vertical-align: middle">' . $data->nama_pengirim . '</td>
                    <td class="text-center" style="vertical-align: middle; max-width: 150px; max-height: 50px; overflow: hidden;text-overflow: ellipsis;max-lines: 1">' . $data->pesan . '</td>
                    <td class="text-center" style="vertical-align: middle;">' . $data->tanggal_terkirim . '</td>
                    <td class="text-center" style="vertical-align: middle">' . '<i class="fa ' . $icon . '"></i>' . '</td>
                    <td class="text-center" style="vertical-align: middle">
                        <a href="' . base_url('dashboard/detail_pesan?email=' . $data->email) . '" class="btn btn-info btn-sm">
                            <i class="glyphicon glyphicon-search"></i> Lihat
                        </a>
                        <a href="' . base_url('dashboard/hapus_pesan?email=' . $data->email) . '" class="btn btn-danger btn-sm">
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