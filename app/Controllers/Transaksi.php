<?php

namespace App\Controllers;

use App\Models\TransaksiModel;


class Transaksi extends BaseController
{

    protected $transaksiModel;

    public function __construct()
    {

        $this->transaksiModel = new TransaksiModel();
    }

    public function index()
    {

        // tenary / percabangan
        $currentPage = $this->request->getVar('page_transaksi') ? $this->request->getVar('page_transaksi') : 1;

        //  Cari data berdasarkan keyword
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $transaksi = $this->transaksiModel->search($keyword);
        } else {
            $transaksi = $this->transaksiModel;
        }


        $data = [
            'title' => 'Daftar Transaksi',
            // 'komik' => $this->komikModel->getKomik(),
            'transaksi' => $transaksi->paginate(6, 'transaksi'),
            'pager' => $this->transaksiModel->pager,
            'currentPage' => $currentPage

        ]; 

        return view('transaksi/index', $data);
    }


    public function delete($id_transaksi)
    {
        // Dapatkan nama file gambar yang akan dihapus
        $transaksi = $this->transaksiModel->find($id_transaksi);


        // Hapus data dari database
        $this->transaksiModel->delete($id_transaksi);

        // Ketika sudah dihapus keluar kata-kata ini
        session()->setFlashdata('pesan', 'Data berhasil dihapus.');

        // Kembali ke halaman komik
        return redirect()->to(base_url() . 'transaksi');
    }
}
