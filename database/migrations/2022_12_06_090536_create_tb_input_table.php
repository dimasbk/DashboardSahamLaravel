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
        Schema::create('tb_input', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id_input', true);
            $table->integer('id_saham')->nullable()->index('id_saham');
            $table->unsignedBigInteger('user_id')->nullable()->index('user_id');
            $table->bigInteger('aset')->nullable();
            $table->bigInteger('simpanan')->nullable();
            $table->bigInteger('pinjaman')->nullable();
            $table->bigInteger('saldo_laba')->nullable();
            $table->bigInteger('ekuitas')->nullable();
            $table->bigInteger('jml_saham_edar')->nullable();
            $table->bigInteger('pendapatan')->nullable();
            $table->bigInteger('laba_kotor')->nullable();
            $table->bigInteger('laba_bersih')->nullable();
            $table->bigInteger('harga_saham')->nullable();
            $table->bigInteger('operating_cash_flow')->nullable();
            $table->bigInteger('investing_cash_flow')->nullable();
            $table->integer('total_dividen')->nullable();
            $table->integer('stock_split')->nullable();
            $table->decimal('eps', 10, 0)->nullable();
            $table->year('tahun')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_input');
    }
};
