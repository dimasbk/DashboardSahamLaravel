<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailInputFundamentalModel extends Model
{
    protected $table = "tb_detail_input";
    protected $fillable = [
        'aset',
        'hutang_obligasi',
        'simpanan',
        'pinjaman',
        'saldo_laba',
        'ekuitas',
        'jml_saham_edar',
        'pendapatan',
        'laba_kotor',
        'laba_bersih',
        'harga_saham',
        'operating_cash_flow',
        'investing_cash_flow',
        'total_dividen',
        'stock_split',
        'eps',
        'tahun',
        'type'
    ];

    public $timestamps = false;
    protected $primaryKey = 'id_detail_input';
}
