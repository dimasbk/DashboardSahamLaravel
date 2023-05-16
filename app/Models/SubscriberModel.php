<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriberModel extends Model
{
    protected $table = "tb_subscription";
    public $timestamps = false;
    protected $fillable = [
        'id_subscriber',
        'id_analyst',
        'status',
    ];
    protected $primaryKey = 'id_subscription';
}