<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateExpertKriteriaComparison extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('expert_kriteria_comparisons', function($table) {
          // $table->dropForeign('expert_kriteria_comparisons_kriteria_id_foreign');
          // $table->dropIndex('expert_kriteria_comparisons_kriteria_id_foreign');
          $table->dropColumn('kriteria_id');
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
