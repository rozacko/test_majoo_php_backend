<?php

namespace App\Controllers;
use Codeigniter\API\ResponseTrait;
use App\Models\Model_User;

class User extends BaseController
{
    use ResponseTrait;
    function __construct(){
        $this->model = new Model_User();
    }

    public function index()
    {   
        $data = $this->model->orderBy('name','asc')->findAll();
        return $this->respond($data,200);
    }

    public function show($id = null)                    //method get
    {   
        $data = $this->model
                ->where('id', $id)
                ->orderBy('name','asc')->findAll();
        if($data)
            return $this->respond($data,200);
        else
            return $this->failNotFound("Data tidak ditemukan untuk id $id");
    }

    public function create(){                           //method post
        $data = [
            'name' => $this->request->getVar('name'),
            'user_name' => $this->request->getVar('user_name'),
            'password' => hash('md5', $this->request->getVar('password')),
        ];
        // $data = $this->request->getPost();        
        if(!$this->model->save($data)){
            return $this->fail($this->model->errors());
        }
        $response = [
            'status' => 201,
            'error' => null,
            'message' => [
                'success' => 'Berhasil menambah users'
            ]
        ];
        return $this->respond($response);
    }

    public function update($id = null){                 //method put raw input

        $data = $this->request->getRawInput();
        $data['id'] = 'id';

        $isExists = $this->model->where('id', $id)->findAll();
        if(!$isExists){
            return $this->failNotFound("Data tidak ditemukan untuk id $id");
        }
        if(!$this->model->save($data)){
            // kalau ada eror kalau menyimpan
            return $this->fail($this->model->errors());
        }

        $response = [
            'status' => 200,
            'error' => null,
            'message' => [
                'success' => 'Berhasil merubah data id $id'
            ]
        ];
        return $this->respond($response);
    }

    public function delete($id = null){                         //method delete
        $data = $this->model->where('id', $id)->findAll();
        if($data){
            $this->model->delete($id);
            $response = [
                'status' => 200,
                'error' => null,
                'message' => [
                    'success' => 'Berhasil menghapus data id $id'
                ]
            ];
            return $this->respondDeleted($response);
        }else{
            return $this->failNotFound("Data tidak ditemukan untuk id $id");
        }            
    }
}
