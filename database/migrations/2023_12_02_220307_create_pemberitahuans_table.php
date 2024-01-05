<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemberitahuansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemberitahuans', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('judul')->nullable();
            $table->string('pengirim')->nullable();
            $table->integer('pk_id');
            $table->string('pesan')->nullable();
            $table->string('link')->nullable();
            $table->boolean('is_dibaca')->default(0);
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pemberitahuans');
    }
}
