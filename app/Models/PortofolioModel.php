<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PortofolioModel extends Model
{

    protected $table = "tb_portofolio";
    protected $fillable = [
        'id_portofolio',
        'user_id',
        'id_saham',
        'type',
        'tanggal',
        'jenis',
        'volume',
        'harga',
        'fee',
        'comment'
    ];
    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = 'id_portofolio';
   

}