<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TechnicalModel extends Model
{

    protected $table = "tb_technical";
    protected $fillable = [
        'jenis_trend'
    ];


}
