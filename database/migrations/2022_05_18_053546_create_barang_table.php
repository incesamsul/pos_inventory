<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->string('kode_barang', 50)->primary();
            $table->date('tgl_masuk');
            $table->string('nama_barang', 255);
            $table->string('barcode', 50);
            $table->string('kode_satuan', 50);
            $table->integer('stok_minimal');
            $table->integer('profit');
            $table->integer('modal');
            $table->integer('harga_jual_1');
            $table->integer('harga_jual_2');
            $table->integer('batas_volume_harga_jual_2');
            $table->integer('harga_jual_3');
            $table->integer('batas_volume_harga_jual_3');
            $table->integer('harga_jual_4');
            $table->integer('batas_volume_harga_jual_4');
            $table->integer('harga_jual_5');
            $table->integer('batas_volume_harga_jual_5');
            $table->integer('stok_akhir');
            $table->integer('hpp');
            $table->timestamps();

            $table->foreign('kode_satuan')->references('kode_satuan')->on('satuan')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang');
    }
}
