<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PemasokSubFuzzy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemasok_fuzzy_results', function (Blueprint $table) {
          $table->increments('id');
          $table->longText('data');
          $table->integer('kriteria_id')->unsigned();
          $table->integer('expert_id')->unsigned();
          $table->integer('sub_kriteria_id')->unsigned();

          $table->timestamps();
          $table->softDeletes();
          $table->foreign('kriteria_id')->references('id')->on('kriterias');
          $table->foreign('expert_id')->references('id')->on('experts');
          $table->foreign('sub_kriteria_id')->references('id')->on('sub_kriterias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pemasok_fuzzy_results');
    }
}
