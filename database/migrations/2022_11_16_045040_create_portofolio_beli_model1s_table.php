<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portofolio_beli_model1s', function (Blueprint $table) {
            $table->id();
            $table->string('id_saham');
            $table->string('user_id');
            $table->string('jenis_saham');
            $table->string('volume');
            $table->string('id_saham'); 
            $table->string('tanggal_beli');
            $table->string('harga_beli');
            $table->string('fee_beli_persen');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('portofolio_beli_model1s');
    }
};
