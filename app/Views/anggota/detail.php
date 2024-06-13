<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h1 class='mt-2'>Detail Anggota</h1>
            <div class="card mb-3" style="max-width: 640px;">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="/img/<?= $anggota['foto']; ?>" class="img-fluid rounded-start" alt="..." style="padding: 25px 5px 25px 25px;">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><b><?= $anggota['nama']; ?></b></h5>
                            <p class="card-text"><small class="text-body-secondary"><b>Nim : </b><?= $anggota['nim']; ?></small></p>
                            <p class="card-text"><small class="text-body-secondary"><b>Jurusan : </b> <?= $anggota['jurusan']; ?></small></p>
                            <p class="card-text"><small class="text-body-secondary"><b>No Telpon : </b> <?= $anggota['no_telp']; ?></small></p>

                            <!-- Button Edit dan Hapus -->
                            <br><br>

                            <!-- Edit -->
                            <a href="/anggota/edit/<?= $anggota['slug']; ?>" class="btn btn-warning">Edit</a>

                            <!-- Hapus, dengan cara menipu web -->
                            <form action="/anggota/delete/<?= $anggota['id_anggota']; ?>" method="post" class="d-inline">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?');">Delete</button>
                            </form>

                            <br><br>
                            <a class="link-kembali" href="/komik">Kembali ke daftar anggota</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>