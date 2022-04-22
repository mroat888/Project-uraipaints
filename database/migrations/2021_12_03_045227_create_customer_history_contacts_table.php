<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerHistoryContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_history_contacts', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_shop_id');
            $table->integer('employee_id');
            $table->string('cust_history_detail');
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();
            $table->string('deleted_by');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_history_contacts');
    }
}
