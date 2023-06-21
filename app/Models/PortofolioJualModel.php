<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PortofolioJualModel extends Model
{

    protected $table = "tb_portofolio_jual";
    protected $fillable = [
<<<<<<< HEAD
        'id_saham',
        'user_id',
        'jenis_saham',
        'volume',
        'tanggal_jual',
        'harga_jual',
        'id_sekuritas',
        'close_persen'
=======
        'id_saham', 'user_id', 'jenis_saham', 'volume', 'tanggal_jual', 'harga_jual', 'fee_jual_persen', 'close_persen','id_sekuritas'
>>>>>>> b3833b0 (edit sumtin)
    ];
    public $timestamps = false;
    protected $primaryKey = 'id_portofolio_jual';

}