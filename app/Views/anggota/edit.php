<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col mt-3">
            <h2>Ubah Data Anggota</h2>
            <form action="/anggota/update/<?= $anggota['id_anggota']; ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <input type="hidden" name="slug" value="<?= $anggota['slug']; ?>">
                <input type="hidden" name="fotoLama" value="<?= $anggota['foto']; ?>">
                <div class="row mb-3">
                    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control  <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" autofocus value="<?= $anggota['nama']; ?>">
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            <?= $validation->getError('nama'); ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="nim" class="col-sm-2 col-form-label">Nim</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nim" name="nim" value="<?= $anggota['nim']; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="jurusan" class="col-sm-2 col-form-label">Jurusan</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="jurusan" name="jurusan" value="<?= $anggota['jurusan']; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="no_telp" class="col-sm-2 col-form-label">No Telpon</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?= $anggota['no_telp']; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="foto" class="col-sm-2 col-form-label">Foto</label>
                    <div class="col-sm-2">
                        <img src="/img/<?= $anggota['foto']; ?>" class="img-thumbnail img-preview">
                    </div>
                    <div class="col-sm-8">
                        <div class="mb-3">
                            
                            <input type="file" class="form-control <?= ($validation->hasError('foto')) ? 'is-invalid' : ''; ?> " aria-label="file example" id="foto" name="foto" onchange="previewFoto()"> 
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                <?= $validation->getError('foto'); ?>
                            </div>
                            <label for="Foto" class="custom-file-label"><?= $anggota['foto']; ?></label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Ubah Data</button>
            </form>


        </div>
    </div>
</div>
<?= $this->endSection(); ?>