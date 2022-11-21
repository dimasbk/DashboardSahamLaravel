<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PortofolioJualModel extends Model
{
    public function allData(){
        return DB::table('tb_portofolio_jual')
        ->join('tb_saham', 'tb_portofolio_jual.id_saham', '=', 'tb_saham.id_saham')
        ->get();
    }
}
