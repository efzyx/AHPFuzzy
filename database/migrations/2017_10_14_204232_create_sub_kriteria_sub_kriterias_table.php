<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubKriteriaSubKriteriasTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_kriteria_sub_kriterias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sub_kriteria1_id')->unsigned();
            $table->integer('sub_kriteria2_id')->unsigned();
            $table->integer('expert_id')->unsigned();
            $table->float('nilai');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('sub_kriteria1_id')->references('id')->on('sub_kriterias');
            $table->foreign('sub_kriteria2_id')->references('id')->on('sub_kriterias');
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
        Schema::drop('sub_kriteria_sub_kriterias');
    }
}
