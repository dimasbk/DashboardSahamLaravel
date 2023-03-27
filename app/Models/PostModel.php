<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostModel extends Model
{
    protected $table = "tb_post";
    protected $fillable = [
        'title',
        'content',
        'picture',
        'id_user',
        'tag',
        "created_at",
        "updated_at"
    ];
    protected $primaryKey = 'id_post';

}