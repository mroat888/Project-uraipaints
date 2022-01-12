<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalePlanResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_plan_results', function (Blueprint $table) {
            $table->id();
            $table->integer('sale_plan_id');
            $table->dateTime('sale_plan_checkin_date');
            $table->string('sale_plan_checkin_latitude');
            $table->string('sale_plan_checkin_longitude');
            $table->dateTime('sale_plan_checkout_date');
            $table->string('sale_plan_checkout_latitude');
            $table->string('sale_plan_checkout_longitude');
            $table->string('sale_plan_detail');
            $table->string('sale_plan_status');
            $table->string('created_by');
            $table->string('updated_by');
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
        Schema::dropIfExists('sale_plan_results');
    }
}
