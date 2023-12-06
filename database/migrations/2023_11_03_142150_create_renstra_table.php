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
        Schema::create('renstra', function (Blueprint $table) {
            $table->id();
            $table->string('indikator', 120);
            $table->double('target', 5);
            $table->double('realisasi', 5);
            $table->double('bobot', 5);
            $table->double('individu', 5);
            $table->double('capaian', 5);
            $table->enum('jenis', ['Dokpol', 'Pelayanan', 'SDM']);
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
        Schema::dropIfExists('renstra');
    }
};
