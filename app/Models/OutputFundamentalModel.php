<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutputFundamentalModel extends Model
{
    protected $table = "tb_output";
    protected $fillable = [
        'id_detail_output',
        'id_saham',
        'id_input',
        'user_id'
    ];

    public $timestamps = false;
    protected $primaryKey = 'id_output';
}