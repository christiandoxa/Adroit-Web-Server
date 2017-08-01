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
          action="<?php echo base_url() ?>dashboard/kirim_pesan?token=<?php echo $detail->email ?>"
          enctype="multipart/form-data">
        <div class="form-group">
            <label>Email</label>
            <input class="form-control" id="email" name="email"
                   value="<?php echo $detail->email; ?>" readonly>
        </div>
        <div class="form-group">
            <label>Nama Pengirim</label>
            <input class="form-control" id="nama_pengirim" name="nama_pengirim"
                   value="<?php echo $detail->nama_pengirim; ?>" readonly>
        </div>
        <div class="form-group">
            <label>Tanggal Pesan</label>
            <input class="form-control" id="tanggal_terkirim" name="tanggal_terkirim"
                   value="<?php echo $detail->tanggal_terkirim ?>"
                   readonly>
        </div>
        <div class="form-group">
            <label>Pesan</label>
            <textarea class="form-control" readonly><?php echo $detail->pesan ?></textarea>
        </div>
        <div class="form-group">
            <label>Balas</label>
            <textarea class="form-control" id="balas" name="balas"></textarea>
        </div>
        <br>
        <input type="submit" name="submit" value="Kirim" class="btn btn-success">
        <input type="reset" name="reset" value="Reset" class="btn btn-danger">
    </form>
</div>