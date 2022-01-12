<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerVisitResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_visit_results', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_visit_id');
            $table->dateTime('cust_visit_checkin_date');
            $table->string('cust_visit_checkin_latitude');
            $table->string('cust_visit_checkin_longitude');
            $table->dateTime('cust_visit_checkout_date');
            $table->string('cust_visit_checkout_latitude');
            $table->string('cust_visit_checkout_longitude');
            $table->string('cust_visit_detail');
            $table->string('cust_visit_status');
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
        Schema::dropIfExists('customer_visit_results');
    }
}
