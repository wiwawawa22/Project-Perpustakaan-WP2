<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <h1 class="text-center mt-2">Daftar Buku</h1>
        <div class="col-6">
            <a href="/komik/create" class="btn btn-primary mb-3">+ Daftar Buku</a>
            <form action="" method="post">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Cari buku..." name="keyword">
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
                        <th scope="col">Sampul</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1 + (6 * ($currentPage - 1)); ?>
                    <?php foreach ($komik as $k) : ?>
                        <tr>
                            <td scope="row"><?= $i++; ?>.</td>
                            <td><img src="/img/<?= $k['sampul']; ?>" alt="" class='sampul'></td>
                            <td><?= $k['judul']; ?></td>
                            <td>
                                <a href="/komik/<?= $k['slug']; ?>" class='btn btn-success'>Detail</a>
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