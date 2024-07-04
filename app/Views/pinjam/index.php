<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <h1 class="text-center mt-2">Daftar Pinjam Buku</h1>
        <div class="col-6">
            <a href="/pinjam/create" class="btn btn-primary mb-3">+ Daftar Pinjam</a>
            <form action="" method="post">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Cari daftar pinjam..." name="keyword">
                    <button class="btn btn-outline-secondary" type="submit" name="submit">Cari</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <?php if (session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan'); ?>
                </div>
            <?php endif; ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Nim</th>
                        <th scope="col">Jurusan</th>
                        <th scope="col">No Telpon</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Penulis</th>
                        <th scope="col">Penerbit</th>
                        <th scope="col">Tahun</th>
                        <th scope="col">Tanggal Pinjam</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1 + (6 * ($currentPage - 1)); ?>
                    <?php foreach ($pinjam as $p) : ?>
                        <tr>
                            <td scope="row"><?= $i++; ?>.</td>
                            <td><?= $p['nama']; ?></td>
                            <td><?= $p['nim']; ?></td>
                            <td><?= $p['jurusan']; ?></td>
                            <td><?= $p['no_telp']; ?></td>
                            <td><?= $p['judul']; ?></td>
                            <td><?= $p['penulis']; ?></td>
                            <td><?= $p['penerbit']; ?></td>
                            <td><?= $p['tahun']; ?></td>
                            <td><?= $p['tanggal_pinjam']; ?></td>
                            <td>
                                <a href="/pinjam/return/<?= $p['id_pinjam']; ?>" class='btn btn-success'>Return</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?= $pager->links('pinjam', 'pinjam_pagination') ?>

        </div>
    </div>
</div>

<?= $this->endsection(); ?>
