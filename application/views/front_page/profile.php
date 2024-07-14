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
            <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat" readonly></textarea><br>
            <div class="row">
                <div class="col">
                    <label for="provisi">Provinsi</label>
                    <input type="text" class="form-control" name="province" id="province" readonly><br>
                </div>
                <div class="col">
                    <label for="kota">Kota</label>
                    <input type="text" class="form-control" name="city" id="city" readonly><br>
                </div>
            </div>

            <div class="accordion" id="accordionExample">
                <button class="btn btn-primary collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Ubah Alamat
                </button>
                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="row" id="data_alamat">

                        </div>
                        <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalAlamat" onclick="submit_address('tambah')">Tambah alamat baru</button>
                    </div>
                </div>
            </div><br>

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

<!-- modal untuk insert dan edit data -->
<div class="modal fade" id="modalAlamat">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Alamat Baru</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <div class="row">
                                <label for="nama" class="col-lg-2 col-form-label">Alamat</label>
                                <div class="col-lg-10">
                                    <input type="hidden" name="id_alamat" class="form-control">
                                    <input type="text" name="alamat1" id="alamat1" class="form-control" placeholder="Masukkan alamat">
                                    <small class="text-danger pl-1" id="error-alamat1"></small><br>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label for="provinsi" class="col-lg-2 col-form-label">Provinsi</label>
                                <div class="col-lg-10">
                                    <select class="form-control" style="background-color: transparent;" id="provinsi" name="provinsi">
                                        <option value="">Loading...</option>
                                    </select>
                                    <small class="text-danger pl-1" id="error-provinsi"></small><br>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label for="kota" class="col-lg-2 col-form-label">Kota</label>
                                <div class="col-lg-10">
                                    <select id="kota" name="kota" class="form-control" style="background-color: transparent;">
                                        <option value="">Loading...</option>
                                    </select>
                                    <small class="text-danger pl-1" id="error-kota"></small><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-start">
                <div class="col-lg-2">
                    <button type="button" id="btn-tambah1" onclick="insert_address()" class="btn btn-outline-primary btn-block">Tambah</button>
                </div>
                <div class="col-lg-2">
                    <button type="button" id="btn-ubah" onclick="edit_address()" class="btn btn-outline-primary btn-block">Edit</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Profile Content End -->
<script>
    var base_url = '<?php echo base_url() ?>';
    var _controller = '<?= $this->router->fetch_class() ?>';
</script>