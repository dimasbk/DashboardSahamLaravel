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
        Schema::create('tb_portofolio_jual', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id_portofolio_jual', true);
            $table->integer('id_saham')->nullable()->index('id_saham');
            $table->unsignedBigInteger('user_id')->nullable()->index('user_id');
            $table->integer('jenis_saham')->nullable()->index('jenis_saham');
            $table->integer('volume')->nullable();
            $table->date('tanggal_jual')->nullable();
            $table->bigInteger('harga_jual')->nullable();
            $table->integer('fee_jual_persen')->nullable();
            $table->bigInteger('close_persen')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_portofolio_jual');
    }
};
