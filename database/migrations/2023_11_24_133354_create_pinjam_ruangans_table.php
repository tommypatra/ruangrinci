<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePinjamRuangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pinjam_ruangans', function (Blueprint $table) {
            $table->id();
            $table->integer('biaya')->default(0);
            $table->text('keterangan')->nullable();
            $table->string('peminjam_nama');
            $table->string('peminjam_lembaga');
            $table->string('no_hp');
            $table->string('file_upload');
            $table->string('verifikator')->nullable();
            $table->boolean('is_diterima')->nullable();
            $table->boolean('is_pengajuan')->nullable();

            $table->text('verifikasi_catatan')->nullable();
            $table->dateTime('waktu_mulai')->nullable();
            $table->dateTime('waktu_selesai')->nullable();
            $table->timestamps();
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users')->restrictOnDelete();
            $table->foreignId('ruangan_id');
            $table->foreign('ruangan_id')->references('id')->on('ruangans')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pinjam_ruangans');
    }
}
