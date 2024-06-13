<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Home'
        ];
        return view('pages/home', $data);
    }

    public function about()
    {
        $data = [
            'title' => 'About me'
        ];
        return view('pages/about', $data);
    }
    
    public function contact()
    {
        $data = [
            'title' => 'Contact us',
            'alamat' => [
                [
                    'tipe' => 'Rumah',
                    'alamat' => 'Jl. Kebun Jeruk XV dlm',
                    'kota' => 'Jakarta'
                ],
                [
                    'tipe' => 'Kantor',
                    'alamat' => 'Jl. ABC X dlm',
                    'kota' => 'Yogyakarta'
                ]
            ]
        ];
        return view('pages/contact', $data);
    }


}
