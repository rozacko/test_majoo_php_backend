<?php

namespace App\Controllers;
use Codeigniter\API\ResponseTrait;
use App\Models\Model_Laporan;
use Firebase\JWT\JWT;

class Laporan extends BaseController
{
    use ResponseTrait;
    function __construct(){
        $this->model = new Model_Laporan();
    }
    public function index(){

    }
    public function laporan_1()
    {   
        $validation = \Config\Services::validation();
        $aturan = [
            'token' => [
                'rules' => 'required',
                'errors' =>[
                    'required' => 'Silahkan masukkan token'
                ]
            ]            
        ];
        $validation->setRules($aturan);
        if(!$validation->withRequest($this->request)->run()){
            return $this->fail($validation->getErrors());
        }
                
        $token = $this->request->getVar('token');
        $page = $this->request->getVar('page');
        $jum_data = 10;
        $ind_end = $jum_data*$page;
        $ind_start = $ind_end-$jum_data;

        $key = getenv('JWT_SECRET_KEY');
        $decodedToken = JWT::decode($token, $key, ['HS256']);
        $id = $decodedToken->id;
        // print_r($decodedToken);die;

        $data = $this->model->get_data_1($id)->getResultArray(); 
        $tahun = date('Y'); //Mengambil tahun saat ini
        // $bulan = date('m'); //Mengambil bulan saat ini
        $bulan = 11; //Mengambil bulan november
        $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        $ind = 0;
        $data_final = array();
        for ($i=1; $i < $tanggal+1; $i++) { 
            //2021-12-04
            if($i <= 9)
                $tanggal_fill = $tahun.'-'.$bulan.'-0'.$i;
            else
                $tanggal_fill = $tahun.'-'.$bulan.'-'.$i;

            $data_final[$ind]['merchant_name'] = '';
            $data_final[$ind]['outlet_name'] = '';
            $data_final[$ind]['bill_total'] = 0;
            $data_final[$ind]['created_at'] = $tanggal_fill;
            foreach ($data as $key => $value) {                
                if(substr($value['created_at'],0,10) == $tanggal_fill){                    
                    $data_final[$ind] = $value;
                    $data_final[$ind]['created_at'] = $tanggal_fill;
                    $ind++;
                }           
            }
            $ind++;
        }
        //sort
        $ind = 0;
        foreach ($data_final as $key => $value) {
            $dt_final[$ind] = $value;
            $ind++;
        }

        //pagination
        $aa = 0;
        $data_ = array();
        for ($i=$ind_start; $i < $ind_end; $i++) { 
            if(isset($dt_final[$i]))
                $data_[$aa] = $dt_final[$i];
            else
                break;
            $aa++;
        }
        return $this->respond($data_,200);
    }

    public function laporan_2()
    {   
        $validation = \Config\Services::validation();
        $aturan = [
            'token' => [
                'rules' => 'required',
                'errors' =>[
                    'required' => 'Silahkan masukkan token'
                ]
            ],'page' => [
                'rules' => 'required',
                'errors' =>[
                    'required' => 'Silahkan masukkan Page'
                ]
            ]            
        ];
        $validation->setRules($aturan);
        if(!$validation->withRequest($this->request)->run()){
            return $this->fail($validation->getErrors());
        }
        
        $token = $this->request->getVar('token');
        $page = $this->request->getVar('page');
        $jum_data = 10;
        $ind_end = $jum_data*$page;
        $ind_start = $ind_end-$jum_data;
        

        $key = getenv('JWT_SECRET_KEY');
        $decodedToken = JWT::decode($token, $key, ['HS256']);
        $id = $decodedToken->id;

        $data = $this->model->get_data_2($id)->getResultArray(); 
        $tahun = date('Y'); //Mengambil tahun saat ini
        // $bulan = date('m'); //Mengambil bulan saat ini
        $bulan = 11; //Mengambil bulan november
        $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        $ind = 0;
        $data_final = array();
        for ($i=1; $i < $tanggal+1; $i++) { 
            //2021-12-04
            if($i <= 9)
                $tanggal_fill = $tahun.'-'.$bulan.'-0'.$i;
            else
                $tanggal_fill = $tahun.'-'.$bulan.'-'.$i;

            $data_final[$ind]['merchant_name'] = '';
            $data_final[$ind]['outlet_name'] = '';
            $data_final[$ind]['bill_total'] = 0;
            $data_final[$ind]['created_at'] = $tanggal_fill;
            foreach ($data as $key => $value) {                
                if(substr($value['created_at'],0,10) == $tanggal_fill){                    
                    $data_final[$ind] = $value;
                    $data_final[$ind]['created_at'] = $tanggal_fill;
                    $ind++;
                }           
            }
            $ind++;
        }
        //sort
        $ind = 0;
        foreach ($data_final as $key => $value) {
            $dt_final[$ind] = $value;
            $ind++;
        }

        //pagination
        $aa = 0;
        $data_ = array();
        for ($i=$ind_start; $i < $ind_end; $i++) { 
            if(isset($dt_final[$i]))
                $data_[$aa] = $dt_final[$i];
            else
                break;
            $aa++;
        }
        return $this->respond($data_,200);
    }
}
