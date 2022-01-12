<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_plans', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_shop_id');
            $table->string('sale_plans_title');    
            $table->dateTime('sale_plans_date');   // วันที่จะเข้าพบ
            $table->string('sale_plans_tags');     // รหัสสินค้านำเสนอ
            $table->string('sale_plans_objective');    // จุดประสงค์
            $table->string('sale_plans_approve_id');   // ผู้อนุมัติ
            $table->string('sale_plans_status');   // สถานะ saleplan
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
        Schema::dropIfExists('sale_plans');
    }
}
