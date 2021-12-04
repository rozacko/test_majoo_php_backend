<?php
namespace App\Models;
use CodeIgniter\Model;

use Exception;

class Model_Laporan extends Model{

    public function get_data_1($id)
    {
        $query = $this->db->table('transactions')
                ->select('merchants.merchant_name,SUM(transactions.bill_total) as bill_total,transactions.created_at')
                ->join('merchants','transactions.merchant_id = merchants.id')
                ->where('MONTH ( transactions.created_at ) = 11')
                ->where('merchants.user_id', $id)
                ->groupBy('DAY ( transactions.created_at ) , merchants.merchant_name')
            ->get();            
        return $query; 
    }

    public function get_data_2($id)
    {
        $query = $this->db->table('transactions')
                ->select('merchants.merchant_name, outlets.outlet_name,SUM(transactions.bill_total) as bill_total,transactions.created_at')
                ->join('merchants','transactions.merchant_id = merchants.id')
                ->join('outlets','merchants.id = outlets.merchant_id')
                ->where('MONTH ( transactions.created_at ) = 11')
                ->where('merchants.user_id', $id)
                ->groupBy('DAY ( transactions.created_at ) , merchants.merchant_name, outlets.outlet_name')
            ->get();        
        return $query; 
    }
}