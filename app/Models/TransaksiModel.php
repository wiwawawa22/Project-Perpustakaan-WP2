<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    protected $useTimestamps = true;
    protected $allowedFields = ['nama', 'nim', 'jurusan', 'no_telp', 'judul', 'penulis', 'penerbit', 'tahun', 'tanggal_pinjam'];


    public function search($keyword) {
        
        // Mencari kata2 sesuai keyword
        return $this->table('transaksi')->like('nama', $keyword)->orLike('nim', $keyword)->orLike('jurusan', $keyword)->orLike('no_telp', $keyword)->orLike('judul',$keyword)->orLike('penulis', $keyword)->orLike('penerbit', $keyword)->orLike('tahun', $keyword);

    }

}
?>
