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
    $status = null;
    if ($detail->pre_order == 'belum') {
        $status = 'Belum Pre Order';
    } else {
        $status = 'Sudah Pre Order';
    }
    ?>
    <form style="padding-bottom: 10%" method="post"
          action="<?php echo base_url() ?>dashboard/kirim_pesan_subscriber?email=<?php echo $detail->email ?>"
          enctype="multipart/form-data">
        <div class="form-group">
            <label>Email</label>
            <input class="form-control" id="email" name="email"
                   value="<?php echo $detail->email; ?>" readonly>
        </div>
        <div class="form-group">
            <label>Nama Pengirim</label>
            <input class="form-control" id="nama_pengirim" name="nama_pengirim"
                   value="<?php echo $detail->nama_pelanggan; ?>" readonly>
        </div>
        <div class="form-group">
            <label>Nomor Telepon</label>
            <input class="form-control" id="tanggal_terkirim" name="tanggal_terkirim"
                   value="<?php echo $detail->nomor_telepon ?>"
                   readonly>
        </div>
        <div class="form-group">
            <label>Pre Order Status</label>
            <input class="form-control" id="tanggal_terkirim" name="tanggal_terkirim"
                   value="<?php echo $status ?>"
                   readonly>
        </div>
        <div class="form-group">
            <label>Kirim Email</label>
            <textarea class="form-control" id="balas"
                      name="balas"><?php if (!empty($detail->balasan)) echo $detail->balasan ?></textarea>
        </div>
        <br>
        <input type="submit" name="submit" value="Kirim" class="btn btn-success">
        <input type="reset" name="reset" value="Reset" class="btn btn-danger">
    </form>
</div>