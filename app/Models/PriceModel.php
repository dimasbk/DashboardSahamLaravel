<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceModel extends Model
{
    protected $table = "tb_analyst_price";
    protected $fillable = [
        'id_analyst',
        'price',
        'month'
    ];
    public $timestamps = false;
    protected $primaryKey = 'id_price';
}