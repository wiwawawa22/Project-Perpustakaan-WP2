<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col-6">
            <h1 class="mt-2">Daftar Anggota</h1>
            <a href="/anggota/create" class="btn btn-primary mb-3">Tambah Anggota</a>
            <form action="" method="post">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Cari Anggota..." name="keyword">
                    <button class="btn btn-outline-secondary" type="submit" name="submit">Cari</button>
                    <!-- <div class="input-group-append">
                        </div> -->
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <!-- menampilakan pemberitahuan kalau data berhasil ditambahkan -->
            <?php if (session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan'); ?>
                </div>
            <?php endif; ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1 + (6 * ($currentPage - 1)); ?>
                    <?php foreach ($anggota as $a) : ?>
                        <tr>
                            <td scope="row"><?= $i++; ?>.</td>
                            <td><img src="/img/<?= $a['foto']; ?>" alt="" class='foto'></td>
                            <td><?= $a['nama']; ?></td>
                            <td>
                                <a href="/anggota/<?= $a['slug']; ?>" class='btn btn-success'>Detail</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?= $pager->links('komik', 'komik_pagination') ?>

        </div>
    </div>
</div>

<?= $this->endsection(); ?>