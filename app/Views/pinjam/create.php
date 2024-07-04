<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col mt-3">
            <h2 class="mb-3">Tambah Daftar Pinjam</h2>
            <form action="/pinjam/save" method="post">
                <?= csrf_field(); ?>
                <div class="row mb-3">
                    <label for="tanggal_pinjam" class="col-sm-2 col-form-label">Tanggal Peminjaman</label><br>
                    <?php date_default_timezone_set('Asia/Jakarta'); ?>
                    <input class="form-control" type="datetime-local" name="tanggal_pinjam" id="tanggal_pinjam" value="<?= date('Y-m-d\TH:i') ?>" required>

                    <label for="anggota" class="mt-3 col-sm-2 col-form-label">Anggota</label>
                    <select name="anggota" class="form-select" aria-label="Default select example" required>
                        <option selected disabled>Pilih Nama Anggota :</option>
                        <?php foreach ($anggota as $a) : ?>
                            <option value="<?= $a['id_anggota']; ?>" data-nama="<?= $a['nama']; ?>" data-nim="<?= $a['nim']; ?>" data-jurusan="<?= $a['jurusan']; ?>" data-no_telp="<?= $a['no_telp']; ?>"><?= $a['nama']; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <label for="judul" class="mt-3 col-sm-2 col-form-label">Judul</label>
                    <select name="judul" class="form-select" aria-label="Default select example" required>
                        <option selected disabled>Pilih Judul Buku :</option>
                        <?php foreach ($buku as $b) : ?>
                            <option value="<?= $b['judul']; ?>" data-penulis="<?= $b['penulis']; ?>" data-penerbit="<?= $b['penerbit']; ?>" data-tahun="<?= $b['tahun']; ?>"><?= $b['judul']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <input type="hidden" name="nama" id="hidden_nama">
                <input type="hidden" name="nim" id="hidden_nim">
                <input type="hidden" name="jurusan" id="hidden_jurusan">
                <input type="hidden" name="no_telp" id="hidden_no_telp">
                <input type="hidden" name="penulis" id="hidden_penulis">
                <input type="hidden" name="penerbit" id="hidden_penerbit">
                <input type="hidden" name="tahun" id="hidden_tahun">
                
                <button type="submit" class="btn btn-success">Tambah Data</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const anggotaSelect = document.querySelector('select[name="anggota"]');
        const judulSelect = document.querySelector('select[name="judul"]');
        
        const hiddenNama = document.getElementById('hidden_nama');
        const hiddenNim = document.getElementById('hidden_nim');
        const hiddenJurusan = document.getElementById('hidden_jurusan');
        const hiddenNoTelp = document.getElementById('hidden_no_telp');
        const hiddenPenulis = document.getElementById('hidden_penulis');
        const hiddenPenerbit = document.getElementById('hidden_penerbit');
        const hiddenTahun = document.getElementById('hidden_tahun');

        anggotaSelect.addEventListener('change', function() {
            const selectedOption = anggotaSelect.options[anggotaSelect.selectedIndex];
            hiddenNama.value = selectedOption.getAttribute('data-nama');
            hiddenNim.value = selectedOption.getAttribute('data-nim');
            hiddenJurusan.value = selectedOption.getAttribute('data-jurusan');
            hiddenNoTelp.value = selectedOption.getAttribute('data-no_telp');
        });

        judulSelect.addEventListener('change', function() {
            const selectedOption = judulSelect.options[judulSelect.selectedIndex];
            hiddenPenulis.value = selectedOption.getAttribute('data-penulis');
            hiddenPenerbit.value = selectedOption.getAttribute('data-penerbit');
            hiddenTahun.value = selectedOption.getAttribute('data-tahun');
        });
    });
</script>
<?= $this->endSection(); ?>
