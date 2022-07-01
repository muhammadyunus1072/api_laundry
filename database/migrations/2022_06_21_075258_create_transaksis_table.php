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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->bigIncrements( 'id' );
            $table->string('kode_invoice');
            $table->date('tgl');
            $table->date('tgl_bayar')->nullable();
            $table->float('total');
            $table->float('tunai')->nullable();
            $table->float('kembalian')->nullable();
            $table->integer('statusOrder_id');
            $table->enum('statusBayar',['dibayar','belum_dibayar']);
            $table->integer('user_id');
            $table->integer('outlet_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksis');
    }
};
