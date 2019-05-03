<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePertemuan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('pertemuan');
        Schema::create('pertemuan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('agenda_id');
            $table->integer('no_pertemuan')->unsigned();
            $table->foreign('agenda_id')->references('idAgenda')->on('agenda');
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
        Schema::dropIfExists('pertemuan');
    }
}
