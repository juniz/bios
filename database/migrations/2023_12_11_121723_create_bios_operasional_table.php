<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bios_operasional', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('tgl_transaksi');
            $table->integer('saldo_akhir');
            $table->integer('kdbank');
            $table->string('unit', 50);
            $table->integer('no_rekening');
            $table->integer('kode')->default(504);
            $table->string('status', 10);
            $table->json('response')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bios_operasional');
    }
};
