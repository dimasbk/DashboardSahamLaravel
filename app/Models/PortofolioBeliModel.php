<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PortofolioBeliModel extends Model
{

    protected $table = "tb_portofolio_beli";
    protected $fillable = [
        'id_saham', 'user_id', 'jenis_saham', 'volume', 'tanggal_beli', 'harga_beli', 'fee_beli_persen'
    ];
    public function emiten()
    {
        return $this->hasMany('SahamModel');
    }
    public function jenis_saham()
    {
        return $this->hasMany('JenisSahamModel');
    }
    
    public function allData(){
        return DB::table('tb_portofolio_beli')
            ->join('tb_saham', 'tb_portofolio_beli.id_saham', '=', 'tb_saham.id_saham')
            ->get();
    }

    public function getData($user_id){
        return DB::table('tb_portofolio_beli')
            ->join('tb_saham', 'tb_portofolio_beli.id_saham', '=', 'tb_saham.id_saham')
            ->where('user_id', $user_id)
            ->get();

    }

    public function insertData($data){
        DB::table('tb_portofolio_beli')->insert($data);
    }
}
