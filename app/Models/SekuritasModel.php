<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SekuritasModel extends Model
{
    protected $table = "tb_sekuritas";
    public $timestamps = false;
    protected $primaryKey = 'id_sekuritas';

    protected $fillable = [
        'nama_sekuritas',
        'fee_beli',
        'fee_jual'
    ];

}