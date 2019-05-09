<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTugas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('tugas');
        Schema::create('tugas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pertemuan_id')->unsigned();
            $table->string('judul');
            $table->string('deskripsi');
            $table->dateTime('deadline');
            $table->foreign('pertemuan_id')->references('id')->on('pertemuan');
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
        Schema::dropIfExists('tugas');
    }
}
