<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container mt-5">
    <div class="row">
        <div class="col text-center">
            <h1>Selamat Datang di Database Perpustakaan Kelompok 3</h1>
            <p class="lead"></p>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-6 text-center">
            <img src="/img/perpustakaan.jpg" class="img-fluid rounded" alt="">
        </div>
        <div class="col-md-6 text-center">
            <p class="mt-3">Selamat datang di project perpustakaan kami, project ini kami buat untuk memudahkan admin perpustakaan untuk melihat data buku, mencari data buku, menambah data buku, mengubah data buku, menghapus data buku, melihat data anggota, mencari data anggota, menambah anggota, mengubah data anggota, menghapus data angota, membuat data peminjaman buku untuk anggota dan melihat histori transaksi peminjaman buku.</p>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>