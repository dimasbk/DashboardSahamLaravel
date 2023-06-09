<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SahamModel extends Model
{

    protected $table = "tb_saham";
    public $timestamps = false;
    protected $primaryKey = 'id_saham';

    protected $fillable = [
        'nama_saham',
        'nama_perusahaan',
        'pic'
    ];
}