<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->dateTime('assign_work_date');     // วันที่ปฎิบัติงาน
            $table->dateTime('assign_request_date');  // วันที่ขออนุมัติ
            $table->dateTime('assign_approve_date');  // วันที่ได้รับอนุมัติ
            $table->string('assign_title');   // หัวข้องาน
            $table->string('assign_detail');  // รายละเอียดงาน
            $table->string('assign_emp_id');  // พนักงานรับมอบหมายงาน
            $table->string('assign_approve_id');   // ผู้อนุมัติ
            $table->string('assign_is_hot');   // สถานะเรื่องด่วน
            $table->string('assign_status');   // สถานะ อนุมัติ หรือไม่อนุมัติ
            $table->string('assign_result_detail'); // รายละเอียดผลลัพธ์
            $table->string('assign_result_status'); // สถานะผลลัพธ์
            $table->timestamps();
            $table->string('created_by');   // ผู้สั่งงาน
            $table->string('updated_by');
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
        Schema::dropIfExists('assignments');
    }
}
