<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsetRuangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aset_ruangans', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users')->restrictOnDelete();
            $table->foreignId('data_aset_id');
            $table->foreign('data_aset_id')->references('id')->on('data_asets')->restrictOnDelete();
            $table->foreignId('ruangan_id');
            $table->foreign('ruangan_id')->references('id')->on('ruangans')->restrictOnDelete();
            $table->unique(['data_aset_id', 'ruangan_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aset_ruangans');
    }
}
