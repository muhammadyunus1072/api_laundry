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
        //
        // Schema::create('user_detail', function (Blueprint $table) {
        //     $table->bigIncrements( 'id' );
        //     $table->string('nama');
        //     $table->string('alamat');
        //     $table->enum('jenis_kelamin',['L','P']);
        //     $table->string('tlp');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
