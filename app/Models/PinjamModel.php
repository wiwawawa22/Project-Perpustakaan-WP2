<?php

namespace App\Models;

use CodeIgniter\Model;

class PinjamModel extends Model
{
    protected $table = 'pinjam';
    protected $primaryKey = 'id_pinjam';
    protected $useTimestamps = false;
    protected $allowedFields = ['nama', 'nim', 'jurusan', 'no_telp', 'judul', 'penulis', 'penerbit', 'tahun', 'tanggal_pinjam'];

    public function getPinjam($id_pinjam = false)
    {
        if ($id_pinjam == false) {
            return $this->findAll();
        }

        return $this->where(['id_pinjam' => $id_pinjam])->first();
    }

    public function search($keyword) {
        
        // Mencari kata2 sesuai keyword
        return $this->table('pinjam')->like('nama', $keyword)->orLike('nim', $keyword)->orLike('jurusan', $keyword)->orLike('no_telp', $keyword)->orLike('judul',$keyword)->orLike('penulis', $keyword)->orLike('penerbit', $keyword)->orLike('tahun', $keyword);

    }
}
?>