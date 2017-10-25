<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePemasokSubsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemasok_subs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pemasok1_id')->unsigned();
            $table->float('nilai');
            $table->integer('pemasok2_id')->unsigned();
            $table->integer('kriteria_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('pemasok1_id')->references('id')->on('pemasoks');
            $table->foreign('pemasok2_id')->references('id')->on('pemasoks');
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
        Schema::drop('pemasok_subs');
    }
}
