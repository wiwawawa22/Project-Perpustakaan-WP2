<?php

namespace App\Controllers;

use App\Models\KomikModel;

class Komik extends BaseController
{
    protected $komikModel;

    public function __construct()
    {

        $this->komikModel = new KomikModel();
    }

    public function index()
    {

        // tenary / percabangan
        $currentPage = $this->request->getVar('page_komik') ? $this->request->getVar('page_komik') : 1 ;

        //  Cari data berdasarkan keyword
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $komik = $this->komikModel->search($keyword);
        } else {
            $komik = $this->komikModel;
        }


        $data = [
            'title' => 'Daftar Buku',
            // 'komik' => $this->komikModel->getKomik(),
            'komik' => $komik->paginate(6, 'komik'),
            'pager' => $this->komikModel->pager,
            'currentPage' => $currentPage

        ];

        return view('komik/index', $data);
    }

    public function detail($slug)
    {

        $data = [
            'title' => 'Detail Buku',
            'komik' => $this->komikModel->getKomik($slug)
        ];

        // Jika komik tidak ada di table
        if (empty($data['komik'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul buku ' . $slug . ' tidak ditemukan!.');
        }

        return view('komik/detail', $data);
    }

    public function create()
    {
        session();
        $data = [
            'title' => 'Tambah Data Komik',
            'validation' => session()->getFlashdata('validation') ?? \Config\Services::validation(),
        ];

        return view('komik/create', $data);
    }

    public function save()
    {
        // Validasi input
        if (!$this->validate([
            'judul' => [
                'rules' => 'required|is_unique[komik.judul]',
                'errors' => [
                    'required' => '{field} komik harus diisi.',
                    'is_unique' => '{field} komik sudah terdaftar.'
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,1024]|is_image[sampul]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar. Maksimum 1MB.',
                    'is_image' => 'File yang dipilih bukan gambar.'
                ]
            ]
        ])) {

            // $validation = \Config\Services::validation();
            // return redirect()->to('/komik/create')->withInput()->with('validatin', $validation);
            return redirect()->to('/komik/create')->withInput();
        }


        // Ambil gambar sampul
        $fileSampul = $this->request->getFile('sampul');

        // apakah tidak ada gambar yang diupload
        if ($fileSampul->getError() == 4) {

            $namaSampul = 'default.jpg';
        } else {
            // Generate nama file acak dengan ekstensi yang sama
            $namaSampul = $fileSampul->getRandomName();

            // Pindahkan file ke folder img
            $fileSampul->move(ROOTPATH . 'public/img', $namaSampul);
        }
        // // Generate nama file acak dengan ekstensi yang sama
        // $namaSampul = $fileSampul->getName();

        // Buat slug
        $slug = url_title($this->request->getVar('judul'), '-', true);

        // Simpan data ke database
        $this->komikModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namaSampul // Simpan nama file sampul ke database
        ]);

        // Set pesan flash
        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');

        // Redirect ke halaman daftar komik
        return redirect()->to(base_url() . '/komik');
    }




    public function delete($id)
    {
        // Dapatkan nama file gambar yang akan dihapus
        $komik = $this->komikModel->find($id);

        // cek jika file gambar nya default.jpg
        if ($komik['sampul'] != 'default.jpg') {

            //  Hapus Gambar
            unlink('img/' . $komik['sampul']);
        }

        // Hapus data dari database
        $this->komikModel->delete($id);

        // Ketika sudah dihapus keluar kata-kata ini
        session()->setFlashdata('pesan', 'Data berhasil dihapus.');

        // Kembali ke halaman komik
        return redirect()->to(base_url() . 'komik');
    }

    public function edit($slug){
        $data = [
            'title' => 'Ubah Data Buku',
            'validation' => session()->getFlashdata('validation') ?? \Config\Services::validation(),
            'komik' => $this->komikModel->getKomik($slug)
        ];

        return view('komik/edit', $data);
    }



    public function update($id)
    {
        // cek judul
        $komikLama = $this->komikModel->getKomik($this->request->getVar('slug'));

        if ($komikLama['judul'] == $this->request->getVar('judul')) {
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[komik.judul]';
        }

        // Validation input
        if (!$this->validate([
            'judul' => [
                'rules' => $rule_judul,
                'errors' => [
                    'required' => '{field} komik harus diisi.',
                    'is_unique' => '{field} komik sudah terdaftar'
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,1024]|is_image[sampul]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar. Maksimum 1MB.',
                    'is_image' => 'File yang dipilih bukan gambar.'
                ]
            ]
        ])) {
            // session()->setFlashdata('validation', \Config\Services::validation());
            // return redirect()->to('/komik/edit/' . $this->request->getVar('slug'))->withInput();
            return redirect()->to('/komik/edit' . $this->request->getVar('slug'))->withInput();

        }

        $fileSampul = $this->request->getFile('sampul');

        //  cek gambar, apakah tetap gambar lama
        if ($fileSampul->getError() == 4) {
            $namaSampul = $this->request->getVar('sampulLama');
        } else {

            // generate nama file random
            $namaSampul = $fileSampul->getRandomName();
            
            // pindahkan gambar
            $fileSampul->move('img', $namaSampul);
            
            // hapus file yang lama
            if ($this->request->getVar('sampulLama') != 'default.jpg') {
                unlink('img/' . $this->request->getVar('sampulLama'));
            }
        }

        // membuat slug baru
        $slug = url_title($this->request->getVar('judul'), '-', true);

        // Mengambil data yang telah dikirim dari form tambahdata/create.php
        // $this->request->getVar();

        $this->komikModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namaSampul
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah.');

        return redirect()->to('/komik');
    }
}
