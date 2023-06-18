<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentChannelModel extends Model
{
    use HasFactory;

    protected $table = 'tb_payment_channel';
    protected $primaryKey = 'payment_id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'payment_name',
    ];

    protected $casts = [
        'payment_id' => 'int',
    ];
}
