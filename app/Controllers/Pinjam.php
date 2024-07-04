<?php

namespace App\Controllers;

use App\Models\PinjamModel;
use App\Models\AnggotaModel;
use App\Models\KomikModel;
use App\Models\TransaksiModel;


class Pinjam extends BaseController
{
    protected $pinjamModel;
    protected $anggotaModel;
    protected $komikModel;
    protected $transaksiModel;

    public function __construct()
    {
        $this->pinjamModel = new PinjamModel();
        $this->anggotaModel = new AnggotaModel();
        $this->komikModel = new KomikModel();
        $this->transaksiModel = new TransaksiModel();
    }


    public function index()
    {
        // tenary / percabangan
        $currentPage = $this->request->getVar('page_pinjam') ? $this->request->getVar('page_pinjam') : 1;

        //  Cari data berdasarkan keyword
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $pinjam = $this->pinjamModel->search($keyword);
        } else {
            $pinjam = $this->pinjamModel;
        }

        $data = [
            'title' => 'Daftar Pinjam Buku',
            'pinjam' => $pinjam->paginate(10, 'pinjam'),
            'pager' => $this->pinjamModel->pager,
            'currentPage' => $currentPage
        ];

        return view('pinjam/index', $data);
    }

    public function detail($id_pinjam)
    {

        $data = [
            'title' => 'Detail Daftar Pinjam',
            'pinjam' => $this->pinjamModel->getPinjam($id_pinjam)

        ];

        // Jika komik tidak ada di table
        if (empty($data['pinjam'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul pinjam ' . $id_pinjam . ' tidak ditemukan!.');
        }

        return view('pinjam/create', $data);
    }


    public function create()
    {
        session();
        $anggota = $this->anggotaModel->findAll(); // Mengambil semua data anggota
        $buku = $this->komikModel->findAll(); // Mengambil semua data anggota


        $data = [
            'title' => 'Tambah Data Pinjam',
            'validation' => session()->getFlashdata('validation') ?? \Config\Services::validation(),
            'anggota' => $anggota, // Mengirim data anggota ke view
            'buku' => $buku
        ];

        return view('pinjam/create', $data);
    }

    public function save()
    {
        // Validasi input
        if (!$this->validate([
            'tanggal_pinjam' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal pinjam harus diisi.'
                ]
            ],
            'anggota' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Anggota harus dipilih.'
                ]
            ],
            'judul' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Judul buku harus dipilih.'
                ]
            ]
        ])) {
            return redirect()->to('/pinjam/create')->withInput();
        }

        // Simpan data ke database
        $this->pinjamModel->save([
            'nama' => $this->request->getVar('nama'),
            'nim' => $this->request->getVar('nim'),
            'jurusan' => $this->request->getVar('jurusan'),
            'no_telp' => $this->request->getVar('no_telp'),
            'judul' => $this->request->getVar('judul'),
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'tahun' => $this->request->getVar('tahun'),
            'tanggal_pinjam' => $this->request->getVar('tanggal_pinjam')
        ]);

        // Set pesan flash
        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');

        // Redirect ke halaman daftar pinjam
        return redirect()->to(base_url() . '/pinjam');
    }

    public function return($id_pinjam)
    {
        // Dapatkan data pinjam berdasarkan ID
        $pinjam = $this->pinjamModel->find($id_pinjam);

        if ($pinjam) {
            // Tambahkan data ke tabel transaksi
            $this->transaksiModel->save([
                'nama' => $pinjam['nama'],
                'nim' => $pinjam['nim'],
                'jurusan' => $pinjam['jurusan'],
                'no_telp' => $pinjam['no_telp'],
                'judul' => $pinjam['judul'],
                'penulis' => $pinjam['penulis'],
                'penerbit' => $pinjam['penerbit'],
                'tahun' => $pinjam['tahun'],
                'tanggal_pinjam' => $pinjam['tanggal_pinjam'],
                'tanggal_return' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')

            ]);

            // Hapus data dari tabel pinjam
            $this->pinjamModel->delete($id_pinjam);

            // Set pesan flash
            session()->setFlashdata('pesan', 'Buku berhasil dikembalikan.');

            // Redirect ke halaman daftar pinjam
            return redirect()->to(base_url() . '/pinjam');
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data pinjam tidak ditemukan.');
        }
    }
}
