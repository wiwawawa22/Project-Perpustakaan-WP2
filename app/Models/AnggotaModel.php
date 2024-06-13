<?php

namespace App\Models;

use CodeIgniter\Model;

class AnggotaModel extends Model
{
    protected $table = 'anggota';
    protected $primaryKey = 'id_anggota';
    protected $useTimestamps = true;
    protected $allowedFields = ['nama', 'slug', 'nim', 'jurusan', 'no_telp', 'foto'];

    public function getAnggota($slug = false)
    {
        if ($slug == false) {
            return $this->findAll();
        }

        return $this->where(['slug' => $slug])->first();
    }

    public function search($keyword) {
        
        // $builder = $this->table('komik');
        // $builder->like('judul', $keyword );
        // return $builder; 

        // sama aja sama yang diatas yang bawah di chaining
        return $this->table('anggota')->like('nama', $keyword)->orLike('slug', $keyword)->orLike('nim', $keyword)->orLike('jurusan', $keyword)->orLike('no_telp',$keyword);

    }
}
?>