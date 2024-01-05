<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSerahTerimaAsetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serah_terima_asets', function (Blueprint $table) {
            $table->id();
            $table->date('tgl_kembali')->nullable();
            $table->enum('kondisi', ['baik', 'rusak'])->default('baik');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->foreignId('pengguna_aset_id');
            $table->foreign('pengguna_aset_id')->references('id')->on('pengguna_asets')->restrictOnDelete();
            $table->unique(['pengguna_aset_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('serah_terima_asets');
    }
}
