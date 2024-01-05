<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadPerawatansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upload_perawatans', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('upload_id');
            $table->foreign('upload_id')->references('id')->on('uploads')->restrictOnDelete();
            $table->foreignId('perawatan_id');
            $table->foreign('perawatan_id')->references('id')->on('perawatans')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('upload_perawatans');
    }
}
