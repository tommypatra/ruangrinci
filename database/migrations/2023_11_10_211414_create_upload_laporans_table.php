<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadLaporansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upload_laporans', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('upload_id');
            $table->foreign('upload_id')->references('id')->on('uploads')->restrictOnDelete();
            $table->foreignId('laporan_id');
            $table->foreign('laporan_id')->references('id')->on('laporans')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('upload_laporans');
    }
}
