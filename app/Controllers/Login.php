<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function index()
    {

        $modelMember = new \App\Models\AdminModel();

        $login = $this->request->getPost('login');
        
        if ($login) {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            if ($username == '' or $password == '') {
                $err = "Silahkan masukkan username dan password";
            }

            if (empty($err)) {
                $dataAdmin = $modelMember->where('username', $username)->first();

                if ($dataAdmin['password'] != md5($password)) {
                    $err = "Password tidak sesui!";
                }
            }

            if (empty($err)) {
                $dataSesi = [
                    'id' => $dataAdmin['id'],
                    'username' => $dataAdmin['username'],
                    'password' => $dataAdmin['password']
                ];

                session()->set($dataSesi);

                return redirect()->to('');
            }

            // jika error
            if ($err) {
                // username yang sudah diketik tidak akan hilang walaupun password salah
                session()->setFlashdata('username', $username);
                
                // nampilin error
                session()->setFlashdata('error', $err);
                return redirect()->to('login');
            }

        }

        return view('admin/login'); 
    }

    public function logout() {

        session()->destroy();
        return redirect()->to('login');
    }
}
