<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenggunaAsetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengguna_asets', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tgl_masuk')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users')->restrictOnDelete();
            $table->foreignId('data_aset_id');
            $table->foreign('data_aset_id')->references('id')->on('data_asets')->restrictOnDelete();
            $table->unique(['data_aset_id', 'user_id', 'tgl_masuk']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengguna_asets');
    }
}
