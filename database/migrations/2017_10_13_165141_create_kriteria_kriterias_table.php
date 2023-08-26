<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateKriteriaKriteriasTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kriteria_kriterias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('kriteria1_id')->unsigned();
            $table->integer('kriteria2_id')->unsigned();
            $table->integer('expert_id')->unsigned();
            $table->double('nilai');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('kriteria1_id')->references('id')->on('kriterias');
            $table->foreign('kriteria2_id')->references('id')->on('kriterias');
            $table->foreign('expert_id')->references('id')->on('experts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('kriteria_kriterias');
    }
}
