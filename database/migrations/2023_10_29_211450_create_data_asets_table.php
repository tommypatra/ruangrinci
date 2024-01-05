<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataAsetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_asets', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kode_barang', 30)->nullable();
            $table->string('nup', 30)->nullable();
            $table->text('deskripsi')->nullable();
            $table->date('tgl_masuk')->nullable();
            $table->enum('kondisi', ['baik', 'rusak'])->default('baik');
            $table->boolean('is_aset')->default(1);
            $table->boolean('is_aktif')->default(1);
            $table->boolean('status_label')->default(0);
            $table->boolean('bisa_dipinjam')->default(0);
            $table->timestamps();
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users')->restrictOnDelete();
            $table->foreignId('jenis_aset_id');
            $table->foreign('jenis_aset_id')->references('id')->on('jenis_asets')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_asets');
    }
}
