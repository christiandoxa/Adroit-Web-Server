<div class="col-lg-6">
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
    <form style="padding-bottom: 10%" method="post" action="<?php echo base_url() ?>dashboard/add"
          enctype="multipart/form-data">
        <div class="form-group" style="width: 101%">
            <label>Token</label>
            <input class="form-control" id="token" name="token" value="<?php echo $idAnggota; ?>" readonly>
        </div>
        <div class="form-group" style="width: 70%">
            <label>Nama</label>
            <input class="form-control" id="nama" name="nama" placeholder="Contoh: Christian Doxa Hamasiah" required>
        </div>
        <div class="form-group" style="width: 70%">
            <label>Email</label>
            <input class="form-control" id="email" name="email" placeholder="Contoh: blabla@blabla.com" type="email"
                   required>
        </div>
        <div class="form-group" style="width: 70%">
            <label>Kata Sandi</label>
            <input class="form-control" id="katasandi" name="katasandi" type="password" required>
        </div>
        <div class="form-group" style="width: 70%">
            <label>Konfirmasi Password</label>
            <input class="form-control" id="konfirkatasandi" name="kotaKelahiran" type="password" required>
        </div>
        <br>
        <input type="submit" name="submit" value="Tambah" class="btn btn-success">
        <input type="reset" name="reset" value="Reset" class="btn btn-danger">
    </form>
</div>