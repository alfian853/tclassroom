<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBahanAjar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('bahan_ajar');
        Schema::create('bahan_ajar', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pertemuan_id')->unsigned();
            $table->string('filename');
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
        Schema::dropIfExists('bahan_ajar');
    }
}
