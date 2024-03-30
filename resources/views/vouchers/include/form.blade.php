<form action="" method="POST">
    <div class="row pt-3">
        <div class="col-md-3">
            <div class="form-group">
                <label for="nominal">Jumlah <small><i>*Max 500 Voucher</i></small></label>
                <input type="number" id="jumlah" name="jumlah" class="form-control">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="nominal">Server Hotspot</label>
                <select id="server" name="server" class="form-control">
                    <option value="all">Semua Server</option>
                    <?php foreach ($srvlist as $mydata) { ?>
                        <option value="<?= $mydata['name'] ?>"><?= $mydata['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="nominal">Profile Hotspot</label>
                <select id="profile" name="profile" class="form-control">
                    <?php foreach ($getprofile as $datagua) { ?>
                        <option value="<?= $datagua['name'] ?>"><?= $datagua['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="nominal">Panjang Karakter</label>
                <select id="panjang" name="panjang" class="form-control">
                    <option value="5">5</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="nominal">Mode Voucher</label>
                <select id="voucher" name="voucher" class="form-control">
                    <option value="beda">Username & Password</option>
                    <option value="sama">Username = Password</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="nominal">Prefix Username</label>
                <input type="text" id="prefix" name="prefix" class="form-control">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="nominal">Batas Waktu Voucher</label>
                <div class="row">
                    <div class="col-md-6">
                        <input type="number" id="waktu" name="waktu" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <select id="waktu1" name="waktu1" class="form-control">
                            <option value="s">Detik</option>
                            <option value="m">Menit</option>
                            <option value="h">Jam</option>
                            <option value="d">Hari</option>
                            <option value="w">Minggu</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="nominal">Batas Kuota Voucher</label>
                <div class="row">
                    <div class="col-md-6">
                        <input type="number" id="kuota" name="kuota" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <select id="kuota1" name="kuota1" class="form-control">
                            <option value="k">KB</option>
                            <option value="M">MB</option>
                            <option value="G">GB</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="nominal">Karakter Username</label>
                <select id="karakter" name="karakter" class="form-control">
                    <option value="1">Random abcd</option>
                    <option value="2">Random 1ab2c34d</option>
                    <option value="3">Random ABCD</option>
                    <option value="4">Random 1AB2C34D</option>
                    <option value="5">Random aBcD</option>
                    <option value="6">Random 1aB2c34D</option>
                    <option value="7">Random 1234</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="remark">Komentar Voucher</label>
                <input type="text" name="comment" id="comment" value="vc-7<?= date('s'); ?>-<?= date('d.m.y'); ?>" class="form-control" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="remark">Dibuat Pada</label>
                <input type="text" name="dibuat" id="dibuat" value="<?= date('d-m-Y H:i:s'); ?> WIB" class="form-control" readonly>
            </div>
        </div>
    </div>
</form>
