<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestModel extends Model
{
    protected $table = "tb_request";
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'status',
    ];
    protected $primaryKey = 'id_request';
}