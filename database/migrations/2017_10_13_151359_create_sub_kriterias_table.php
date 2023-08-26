<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubKriteriasTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_kriterias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('kriteria_id')->unsigned();
            $table->string('nama_sub_kriteria');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('kriteria_id')->references('id')->on('kriterias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sub_kriterias');
    }
}
