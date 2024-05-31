<div class="container mt-4">
    <h1 class="text-center mb-4">Profile Diri</h1>
    <div class="row">
        <div class="col-lg-2">
            <label for="profil">Foto Profil</label>
            <img src="" style="max-width: 200px; max-height: 200;" class="img-thumbnail" alt="" name="profile_user"
                id="profile_user">
            <label for="ktp">Foto KTP</label>
            <img src="" style="max-width: 200px; max-height: 200;" class="img-thumbnail" alt="" name="ktp_user"
                id="ktp_user">
        </div>
        <div class="col-lg-6 offset-2">
            <label for="nama">Nama Lengkap</label>
            <input type="hidden" class="form-control" id="id" name="id">
            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama lengkap">
            <small class="text-danger pl-1" id="error-nama"></small><br>

            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Masukkan email">
            <small class="text-danger pl-1" id="error-email"></small><br>

            <label for="telepon">Nomor HP</label>
            <input type="number" class="form-control" id="telepon" name="telepon" placeholder="Masukkan nomor HP">
            <small class="text-danger pl-1" id="error-telepon"></small><br>

            <label for="alamat">Alamat Lengkap</label>
            <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat"></textarea>
            <small class="text-danger pl-1" id="error-alamat"></small><br>

            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username">
            <small class="text-danger pl-1" id="error-username"></small><br>

            <label for="password">Password Hash</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password lama"
                readonly>
            <small class="text-danger pl-1" id="error-password"></small><br>

            <label for="password1">Password Baru</label>
            <input type="password" class="form-control" id="password1" name="password1"
                placeholder="Masukkan password baru">
            <small class="text-danger pl-1" id="error-password1"></small><br>

            <label for="profil">Foto profil</label>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="profil" id="profil"
                        onchange="previewImage(event, 'imageProfil')">
                    <label class="custom-file-label" for="profil">Pilih file</label>
                </div>
            </div>
            <small class="text-danger pl-1" id="error-profil"></small>
            <div id="imageProfil"></div><br>

            <label for="ktp">Foto KTP</label>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="ktp" id="ktp"
                        onchange="previewImage(event, 'imageKTP')">
                    <label class="custom-file-label" for="ktp">Pilih file</label>
                </div>
            </div>
            <small class="text-danger pl-1" id="error-ktp"></small>
            <div id="imageKTP"></div><br>
            <div class="col-lg-3">
                <button type="button" id="btn-tambah" onclick="edit_profil()"
                    class="btn btn-outline-primary btn-block">Edit</button>
            </div>
        </div>
    </div>
</div>

<script>
    var base_url = '<?php echo base_url() ?>';
    var _controller = '<?= $this->router->fetch_class() ?>';
</script>