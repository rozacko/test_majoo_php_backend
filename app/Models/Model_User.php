<?php
namespace App\Models;
use CodeIgniter\Model;

use Exception;

class Model_User extends Model{

    protected $table = 'users';
    protected $primary_key = 'id';
    protected $allowedFields = ['name','user_name','password'];

    protected $validationRules = [
        'name'=>'required',
        'user_name'=>'required',
        'password'=>'required',
    ];

    protected $validationMessages = [
        'nama' => [
            'required' => 'Silahkan masukkan nama'
        ],
        'user_name' => [
            'required' => 'Silahkan masukkan user name'
        ],
        'password' => [
            'required' => 'Silahkan masukkan password'
        ],
    ];    
}