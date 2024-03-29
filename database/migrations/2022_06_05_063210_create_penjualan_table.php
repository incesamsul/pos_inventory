<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->increments('id_penjualan');
            $table->unsignedBigInteger('id_kasir');
            $table->string('kode_barang', 50);
            $table->date('tgl_penjualan');
            $table->integer('harga_jual');
            $table->integer('qty');
            $table->integer('rpdisc');
            $table->integer('bayar');
            $table->integer('jumlah');
            $table->string('segment');
            $table->timestamps();
            $table->foreign('kode_barang')->references('kode_barang')->on('barang')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_kasir')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penjualan');
    }
}
