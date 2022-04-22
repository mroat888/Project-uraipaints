<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_shops', function (Blueprint $table) {
            $table->id();
            $table->string('shop_name');
            $table->string('shop_address');
            $table->integer('shop_province_id');
            $table->integer('shop_amphur_id');
            $table->integer('shop_district_id');
            $table->integer('shop_zipcode');
            $table->string('shop_profile_image');
            $table->string('shop_fileupload');
            $table->string('shop_status');
            $table->integer('employee_id');
            $table->string('shop_latitude');
            $table->string('shop_longitude');
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
        Schema::dropIfExists('customer_shops');
    }
}
