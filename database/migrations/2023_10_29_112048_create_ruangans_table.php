<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRuangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ruangans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('luas')->default(0);
            $table->smallInteger('lantai')->default(1);
            $table->text('deskripsi')->nullable();
            $table->smallInteger('kapasitas')->default(0);
            $table->boolean('is_aktif')->default(1);
            $table->timestamps();
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users')->restrictOnDelete();
            $table->foreignId('gedung_id');
            $table->foreign('gedung_id')->references('id')->on('gedungs')->restrictOnDelete();
            $table->unique(['nama', 'gedung_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ruangans');
    }
}
