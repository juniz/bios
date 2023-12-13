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
        Schema::create('bios_kelolaan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('tgl_transaksi');
            $table->string('saldo_akhir', 50);
            $table->string('kdbank', 5);
            $table->string('no_rekening', 50);
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
        Schema::dropIfExists('bios_kelolaan');
    }
};
