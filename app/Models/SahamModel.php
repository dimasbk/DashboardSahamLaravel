<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SahamModel extends Model
{
    public function allData(){
        return DB::table('tb_saham')->get();
    }
}
