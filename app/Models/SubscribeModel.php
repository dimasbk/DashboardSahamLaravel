<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SubscribeModel extends Model
{

    protected $table = "tb_subscribe";
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_analyst',
        'id_user',
        'subscribe_date',
        'subscribe_fee',
        'unsubscribe_date'
    ];

}
