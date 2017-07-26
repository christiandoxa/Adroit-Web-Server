<div class="col-lg-5">
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
    <form style="padding-bottom: 10%" method="post"
          action="<?php echo base_url() ?>dashboard/update_pengguna?token=<?php echo $detail->token ?>"
          enctype="multipart/form-data">
        <div class="form-group">
            <label>Token</label>
            <input class="form-control" id="token" name="token"
                   value="<?php echo $detail->token; ?>" required readonly>
        </div>
        <div class="form-group">
            <label>Nama</label>
            <input class="form-control" id="nama" name="nama" placeholder="Contoh: Christian Doxa Hamasiah"
                   value="<?php echo $detail->nama; ?>" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input class="form-control" id="email" name="email" placeholder="Contoh: blabla@blabla.com" type="email"
                   value="<?php echo $detail->email ?>"
                   required>
        </div>
        <div class="form-group">
            <label>Kata Sandi</label>
            <input class="form-control" id="katasandi" name="katasandi" value="<?php echo $detail->kata_sandi ?>"
                   required>
        </div>
        <br>
        <input type="submit" name="submit" value="Update" class="btn btn-success">
        <input type="reset" name="reset" value="Reset" class="btn btn-danger">
    </form>
</div>
<div class="col-lg-7">
    <div class="panel panel-default">
        <div class="panel-heading">
            Daftar Perangkat <?php echo $detail->nama ?>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-device">
                <thead>
                <tr>
                    <th class="text-center" style="vertical-align: middle">Device ID</th>
                    <th class="text-center" style="vertical-align: middle">Edit atau Detail</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if ($perangkat != null) {
                    foreach ($perangkat as $data) {
                        echo '
                    <tr>
                    <td class="text-center" style="vertical-align: middle">' . $data->device_id . '</td>
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
                } else {
                    echo '
                    <tr>
                    <td>Tidak ada perangkat yang terkoneksi dengan pengguna ini.</td>
                    <td style="vertical-align: middle" class="text-center">
                        <a href="' . base_url('dashboard/tambah_perangkat/') . '" class="btn btn-info btn-sm">
                            <i class="glyphicon glyphicon-cloud"></i> Tambah Device
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