<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengadaans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nama_barang_pengadaan');
            $table->unsignedBigInteger('ruangan_id');
            $table->foreign('ruangan_id')->references('id')->on('ruangans')->onDelete('cascade')->onUpdate('cascade');
            $table->string('satuan_pengadaan');
            $table->integer('jumlah_pengadaan');
            $table->double('harga_satuan');
            $table->double('total_harga');
            $table->year('tahun_pengadaan');
            $table->date('tanggal_pengadaan');
            $table->enum('status_pengadaan',['diterima','diproses','barang tiba']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengadaans');
    }
};
