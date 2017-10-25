<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExpertKriteriaComparison extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('expert_kriteria_comparisons', function (Blueprint $table) {
          $table->increments('id');
          $table->longText('data');
          $table->integer('kriteria_id')->unsigned();

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
        //
    }
}
