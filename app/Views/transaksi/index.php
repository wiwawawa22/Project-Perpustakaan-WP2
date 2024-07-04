<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>


<div class="container">
    <div class="row">
        <h1 class="text-center mt-2">Daftar History</h1>
        <div class="col-6">
            <form action="" method="post">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Cari transaksi..." name="keyword">
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
                        <th scope="col">Tanggal Kembali</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1 + (6 * ($currentPage - 1)); ?>
                    <?php foreach ($transaksi as $t) : ?>
                        <tr>
                            <td scope="row"><?= $i++; ?>.</td>
                            <td><?= $t['nama']; ?></td>
                            <td><?= $t['nim']; ?></td>
                            <td><?= $t['jurusan']; ?></td>
                            <td><?= $t['no_telp']; ?></td>
                            <td><?= $t['judul']; ?></td>
                            <td><?= $t['penulis']; ?></td>
                            <td><?= $t['penerbit']; ?></td>
                            <td><?= $t['tahun']; ?></td>
                            <td><?= $t['tanggal_pinjam']; ?></td>
                            <td><?= $t['created_at']; ?></td>
                            <td>
                                <a href="/transaksi/delete/<?= $t['id_transaksi']; ?>" class='btn btn-danger'>Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?= $pager->links('transaksi', 'transaksi_pagination') ?>

        </div>
    </div>
</div>

<?= $this->endsection(); ?>
