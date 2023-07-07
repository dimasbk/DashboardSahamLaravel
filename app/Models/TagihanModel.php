<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagihanModel extends Model
{
    protected $table = 'tb_tagihan';
    protected $primaryKey = 'id_tagihan';
    public $timestamps = false;

    protected $fillable = [
        'reference',
        'nama_tagihan',
        'jumlah',
        'status',
        'tgl_tagihan',
        'metode_pembayaran',
        'user_id'
    ];

  

}