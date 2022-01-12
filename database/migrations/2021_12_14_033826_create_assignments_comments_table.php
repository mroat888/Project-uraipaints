<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments_comments', function (Blueprint $table) {
            $table->id();
            $table->integer('assign_id');
            $table->string('assign_comment_detail');  // รายละเอียด
            $table->string('created_by'); // พนักงานที่คอมเม้นต์
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
        Schema::dropIfExists('assignments_comments');
    }
}
