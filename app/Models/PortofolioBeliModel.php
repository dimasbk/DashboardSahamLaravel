<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PortofolioBeliModel extends Model
{

    protected $table = "tb_portofolio_beli";
    protected $fillable = [
        'id_portofolio_beli', 'id_saham', 'user_id', 'jenis_saham', 'volume', 'tanggal_beli', 'harga_beli', 'fee_beli_persen'
    ];
    protected $primaryKey = 'id_portofolio_beli';
    public function emiten()
    {
        return $this->hasMany('SahamModel');
    }
    public function jenis_saham()
    {
        return $this->hasMany('JenisSahamModel');
    }

}
