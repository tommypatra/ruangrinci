<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePinjamAsetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pinjam_asets', function (Blueprint $table) {
            $table->id();
            $table->integer('biaya')->default(0);
            $table->text('keterangan')->nullable();
            $table->string('no_hp');
            $table->string('peminjam_nama');
            $table->string('peminjam_lembaga');
            $table->string('file_upload');
            $table->dateTime('waktu_mulai')->nullable();
            $table->dateTime('waktu_selesai')->nullable();
            $table->timestamps();
            $table->string('verifikator')->nullable();
            $table->boolean('is_diterima')->nullable();
            $table->boolean('is_pengajuan')->nullable();
            $table->text('verifikasi_catatan')->nullable();
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users')->restrictOnDelete();
            $table->foreignId('data_aset_id');
            $table->foreign('data_aset_id')->references('id')->on('data_asets')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pinjam_asets');
    }
}
