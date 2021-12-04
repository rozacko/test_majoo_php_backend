<?php

namespace App\Controllers;
use Codeigniter\API\ResponseTrait;
use App\Models\Model_Otentikasi;

class Otentikasi extends BaseController
{
    use ResponseTrait;
    public function index()
    {   
        $validation = \Config\Services::validation();
        $aturan = [
            'user_name' => [
                'rules' => 'required',
                'errors' =>[
                    'required' => 'Silahkan masukkan username'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' =>[
                    'required' => 'Silahkan masukkan password'
                ]
            ]
        ];
        $validation->setRules($aturan);
        if(!$validation->withRequest($this->request)->run()){
            return $this->fail($validation->getErrors());
        }

        $model = new Model_Otentikasi();
        $user_name = $this->request->getVar('user_name');
        $password = $this->request->getVar('password');

        $data = $model->getUser_name($user_name);
        if($data['password'] != md5($password)){
            return $this->fail("Password tidak sesuai");
        }

        helper('jwt');
        $response = [
            'message' => 'Otentikasi berhasil',
            'data' => $data,
            'access_token' => createJWT($data['id'], $user_name)
        ];
        return $this->respond($response);
        // $data = $this->model->orderBy('name','asc')->findAll();
        // return $this->respond($data,200);
    }    
}
