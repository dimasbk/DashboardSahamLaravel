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

}
