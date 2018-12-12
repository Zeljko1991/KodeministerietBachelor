<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCasestatusesToProjectCases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_cases', function (Blueprint $table) {
            $table->unsignedInteger('case_status_id')->default(1);
            $table->foreign('case_status_id')->references('id')->on('case_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_cases', function (Blueprint $table) {
            //
        });
    }
}
