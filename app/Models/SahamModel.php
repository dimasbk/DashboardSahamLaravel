<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SahamModel extends Model
{

    protected $table = "tb_saham";

    protected $fillable = [
        'nama_saham'
    ];

    public function portobeli()
    {
        return $this->belongsTo('PortofolioBeliModel');
    }
    public function allData(){
        return DB::table('tb_saham')->get();
    }
}
