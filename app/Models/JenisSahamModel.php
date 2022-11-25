<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class JenisSahamModel extends Model
{

    protected $table = "tb_jenis_saham";
    protected $fillable = [
        'jenis_saham'
    ];

    public function allData(){
        return DB::table('tb_jenis_saham')->get();
    }

    
}
