<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InputFundamentalModel extends Model
{
    protected $table = "tb_input";
    protected $fillable = [
        'id_detail_input',
        'id_saham',
        'id_jenis_fundamental_saham',
        'user_id'
    ];

    public $timestamps = false;
    protected $primaryKey = 'id_input';
}