<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_visits', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_shop_id');
            $table->dateTime('customer_visit_date'); // วันที่จะเข้าพบ
            $table->string('customer_visit_tags');
            $table->string('customer_visit_objective'); // จุดประสงค์
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
        Schema::dropIfExists('customer_visits');
    }
}
