<?php

namespace App\Controllers;

use App\Models\AnggotaModel;


class Anggota extends BaseController
{
    protected $anggotaModel;

    

    public function __construct()
    {

        $this->anggotaModel = new AnggotaModel();
    }


    public function index()
    {
        
        // tenary / percabangan
        $currentPage = $this->request->getVar('page_anggota') ? $this->request->getVar('page_anggota') : 1 ;

        //  Cari data berdasarkan keyword
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $anggota = $this->anggotaModel->search($keyword);
        } else {
            $anggota = $this->anggotaModel;
        }

        $data = [
            'title' => 'Anggota',
            'anggota' => $anggota->paginate(10, 'anggota'),
            'pager' => $this->anggotaModel->pager,
            'currentPage' => $currentPage

        ];

        return view('anggota/index', $data);
    }

    public function detail($slug)
    {

        $data = [
            'title' => 'Detail Anggota',
            'anggota' => $this->anggotaModel->getAnggota($slug)
        ];

        // Jika komik tidak ada di table
        if (empty($data['anggota'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Anggota ' . $slug . ' tidak ditemukan!.');
        }

        return view('anggota/detail', $data);
    }

    public function create()
    {
        session();
        $data = [
            'title' => 'Tambah Data Anggota',
            'validation' => session()->getFlashdata('validation') ?? \Config\Services::validation(),
        ];

        return view('anggota/create', $data);
    }

    public function save()
    {
        // Validasi input
        if (!$this->validate([
            'nama' => [
                'rules' => 'required|is_unique[anggota.nama]',
                'errors' => [
                    'required' => '{field} nama harus diisi.',
                    'is_unique' => '{field} nama sudah terdaftar.'
                ]
            ],
            'foto' => [
                'rules' => 'max_size[foto,1024]|is_image[foto]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar. Maksimum 1MB.',
                    'is_image' => 'File yang dipilih bukan gambar.'
                ]
            ]
        ])) {

            // $validation = \Config\Services::validation();
            // return redirect()->to('/komik/create')->withInput()->with('validatin', $validation);
            return redirect()->to('/anggota/create')->withInput();
        }


        // Ambil gambar foto
        $fileFoto = $this->request->getFile('foto');

        // apakah tidak ada gambar yang diupload
        if ($fileFoto->getError() == 4) {

            $namaFoto = 'defaultFoto.png';
        } else {
            // Generate nama file acak dengan ekstensi yang sama
            $namaFoto = $fileFoto->getRandomName();

            // Pindahkan file ke folder img
            $fileFoto->move(ROOTPATH . 'public/img', $namaFoto);
        }
        // // Generate nama file acak dengan ekstensi yang sama
        // $namaSampul = $fileSampul->getName();

        // Buat slug
        $slug = url_title($this->request->getVar('nama'), '-', true);

        // Simpan data ke database
        $this->anggotaModel->save([
            'nama' => $this->request->getVar('nama'),
            'slug' => $slug,
            'nim' => $this->request->getVar('nim'),
            'jurusan' => $this->request->getVar('jurusan'),
            'no_telp' => $this->request->getVar('no_telp'),
            'foto' => $namaFoto // Simpan nama file foto ke database
        ]);

        // Set pesan flash
        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');

        // Redirect ke halaman daftar komik
        return redirect()->to(base_url() . '/anggota');
    }


    public function delete($id_anggota)
    {
        // Dapatkan nama file gambar yang akan dihapus
        $anggota = $this->anggotaModel->find($id_anggota);

        // cek jika file gambar nya default.jpg
        if ($anggota['foto'] != 'defaultFoto.png') {

            //  Hapus Gambar
            unlink('img/' . $anggota['foto']);
        }

        // Hapus data dari database
        $this->anggotaModel->delete($id_anggota);

        // Ketika sudah dihapus keluar kata-kata ini
        session()->setFlashdata('pesan', 'Data berhasil dihapus.');

        // Kembali ke halaman komik
        return redirect()->to(base_url() . 'anggota');
    }

    public function edit($slug){
        $data = [
            'title' => 'Ubah Data Anggota',
            'validation' => session()->getFlashdata('validation') ?? \Config\Services::validation(),
            'anggota' => $this->anggotaModel->getAnggota($slug)
        ];

        return view('anggota/edit', $data);
    }



    public function update($id_anggota)
    {
        // cek judul
        $anggotaLama = $this->anggotaModel->getAnggota($this->request->getVar('slug'));

        if ($anggotaLama['nama'] == $this->request->getVar('nama')) {
            $rule_nama = 'required';
        } else {
            $rule_nama = 'required|is_unique[anggota.nama]';
        }

        // Validation input
        if (!$this->validate([
            'nama' => [
                'rules' => $rule_nama,
                'errors' => [
                    'required' => '{field} nama harus diisi.',
                    'is_unique' => '{field} nama sudah terdaftar'
                ]
            ],
            'foto' => [
                'rules' => 'max_size[foto,1024]|is_image[foto]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar. Maksimum 1MB.',
                    'is_image' => 'File yang dipilih bukan gambar.'
                ]
            ]
        ])) {

            return redirect()->to('/nama/edit' . $this->request->getVar('slug'))->withInput();

        }

        $fileFoto = $this->request->getFile('foto');

        //  cek gambar, apakah tetap gambar lama
        if ($fileFoto->getError() == 4) {
            $namaFoto = $this->request->getVar('fotoLama');
        } else {

            // generate nama file random
            $namaFoto = $fileFoto->getRandomName();
            
            // pindahkan gambar
            $fileFoto->move('img', $namaFoto);
            
            // hapus file yang lama
            if ($this->request->getVar('FotoLama') != 'defaultFoto.png') {
                unlink('img/' . $this->request->getVar('fotoLama'));
            }
        }

        // membuat slug baru
        $slug = url_title($this->request->getVar('nama'), '-', true);

        // Mengambil data yang telah dikirim dari form tambah data/create.php
        // $this->request->getVar();

        $this->anggotaModel->save([
            'id_anggota' => $id_anggota,
            'nama' => $this->request->getVar('nama'),
            'slug' => $slug,
            'nim' => $this->request->getVar('nim'),
            'jurusan' => $this->request->getVar('jurusan'),
            'no_telp' => $this->request->getVar('no_telp'),
            'foto' => $namaFoto
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah.');

        return redirect()->to('/anggota');
    }
}


