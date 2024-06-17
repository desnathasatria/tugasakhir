<!-- Profile Content Start -->
<div class="container profile-container mt-4">
    <h1 class="text-center mb-4">Profile Diri</h1>
    <div class="row">
        <div class="col-lg-2">
            <label for="profil">Foto Profil</label>
            <img src="" style="max-width: 200px; max-height: 200px;" class="img-thumbnail" alt="" name="profile_user" id="profile_user">
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
            <div class="row">
                <div class="col">
                    <label for="provisi">Provinsi</label>
                    <select class="form-control" style="background-color: transparent;" id="provinsi" name="provinsi">
                        <option value="">Loading...</option>
                    </select>
                    <small class="text-danger pl-1" id="error-provinsi"></small><br>
                </div>
                <div class="col">
                    <label for="kota">Kota</label>
                    <select id="kota" name="kota" class="form-control" style="background-color: transparent;">
                        <option value="">Loading...</option>
                    </select>
                    <small class="text-danger pl-1" id="error-kota"></small><br>
                </div>
            </div>
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username">
            <small class="text-danger pl-1" id="error-username"></small><br>

            <label for="password">Password Hash</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password lama" readonly>
            <small class="text-danger pl-1" id="error-password"></small><br>

            <label for="profil">Foto Profil</label>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="profil" id="profil" onchange="previewImage(event, 'imageProfil')">
                    <label class="custom-file-label" for="profil">Pilih file</label>
                </div>
            </div>
            <small class="text-danger pl-1" id="error-profil"></small>
            <div id="imageProfil"></div><br>
            <div class="col-lg-3">
                <button type="button" id="btn-tambah" onclick="edit_profil()" class="btn btn-outline-primary btn-block">Edit</button>
            </div>
        </div>
    </div>
</div>
<!-- Profile Content End -->
<script>
    var base_url = '<?php echo base_url() ?>';
    var _controller = '<?= $this->router->fetch_class() ?>';
</script>