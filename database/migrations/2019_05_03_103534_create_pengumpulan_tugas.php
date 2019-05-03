<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengumpulanTugas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('pengumpulan_tugas');
        Schema::create('pengumpulan_tugas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tugas_id')->unsigned();
            $table->integer('mhs_id')->unsigned();
            $table->string('filename');
            $table->integer('nilai');
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
        Schema::dropIfExists('pengumpulan_tugas');
    }
}
