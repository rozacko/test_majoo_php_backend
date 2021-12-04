<?php
namespace App\Models;
use CodeIgniter\Model;
use Exception;

class Model_Otentikasi extends Model{

    protected $table = 'users';
    protected $primary_key = 'id';
    protected $allowedFields = ['name','user_name','password'];   

    function getUser_name($user_name){
        $builder = $this->table('users');
        $data = $builder->where('user_name', $user_name)->first();
        if(!$data){
            throw new Exception("Data otentikasi tidak ditemukan");            
        }else{
            return $data;
        }
    }

}