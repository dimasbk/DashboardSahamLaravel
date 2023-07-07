<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    protected $table = "tb_roles";
    protected $fillable = [
        'id_roles',
        'roles',
      
    ];
    protected $primaryKey = 'id_roles';

}