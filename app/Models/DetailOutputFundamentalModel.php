<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailOutputFundamentalModel extends Model
{
    protected $table = "tb_detail_output";
    protected $fillable = [
        'der',
        'loan_to_depo_ratio',
        'annualized_roe',
        'roe',
        'dividen',
        'dividen_yield',
        'dividen_payout_ratio',
        'pbv',
        'annualized_per',
        'gpm',
        'npm',
        'eer',
        'ear',
        'market_cap',
        'market_cap_asset_ratio',
        'cfo_sales_ratio',
        'capex_cfo_ratio',
        'market_cap_cfo_ratio',
        'peg',
        'harga_saham_sum_dividen',
        'tahun',
         'kuartal'
    ];

    public $timestamps = false;
    protected $primaryKey = 'id_detail_output';
}
