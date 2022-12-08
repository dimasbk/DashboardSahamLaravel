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
        Schema::create('tb_output', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id_output', true);
            $table->integer('id_saham')->nullable()->index('id_saham');
            $table->unsignedBigInteger('user_id')->nullable()->index('user_id');
            $table->decimal('loan_to_depo_ratio', 4)->nullable();
            $table->decimal('annualized_roe', 4)->nullable();
            $table->integer('dividen')->nullable();
            $table->decimal('dividen_yield', 4)->nullable();
            $table->decimal('dividen_payout_ratio', 4)->nullable();
            $table->decimal('pbv', 4)->nullable();
            $table->decimal('annualized_per', 4)->nullable();
            $table->decimal('annualized_roa', 4)->nullable();
            $table->decimal('gpm', 4)->nullable();
            $table->decimal('npm', 4)->nullable();
            $table->decimal('eer', 4)->nullable();
            $table->decimal('ear', 4)->nullable();
            $table->bigInteger('market_cap')->nullable();
            $table->decimal('market_cap_asset_ratio', 4)->nullable();
            $table->decimal('cfo_sales_ratio', 4)->nullable();
            $table->decimal('capex_cfo_ratio', 4)->nullable();
            $table->decimal('market_cap_cfo_ratio', 4)->nullable();
            $table->decimal('peg', 4)->nullable();
            $table->bigInteger('harga_saham_sum_dividen')->nullable();
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
        Schema::dropIfExists('tb_output');
    }
};
