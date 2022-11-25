<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PortofolioJualModel extends Model
{

    protected $table = "tb_portofolio_jual";
    protected $fillable = [
        'id_saham', 'user_id', 'jenis_saham', 'volume', 'tanggal_jual', 'harga_jual', 'fee_jual_persen'
    ];
    public $timestamps = false;

    public function allData(){
        return DB::table('tb_portofolio_jual')
        ->join('tb_saham', 'tb_portofolio_jual.id_saham', '=', 'tb_saham.id_saham')
        ->get();
    }

    public function getData($user_id){
        return DB::table('tb_portofolio_jual')
            ->join('tb_saham', 'tb_portofolio_jual.id_saham', '=', 'tb_saham.id_saham')
            ->where('user_id', $user_id)
            ->get();

    }

    public function insertData($data){
        DB::table('tb_portofolio_jual')->insert($data);
    }
}
