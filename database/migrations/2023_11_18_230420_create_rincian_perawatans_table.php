<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRincianPerawatansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rincian_perawatans', function (Blueprint $table) {
            $table->id();
            $table->integer('biaya')->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->foreignId('perawatan_id');
            $table->foreign('perawatan_id')->references('id')->on('perawatans')->restrictOnDelete();
            $table->foreignId('data_aset_id');
            $table->foreign('data_aset_id')->references('id')->on('data_asets')->restrictOnDelete();
            $table->unique(['perawatan_id', 'data_aset_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rincian_perawatans');
    }
}
