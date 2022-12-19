<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id('task_id');
            $table->string('task_name');
            $table->text('task_detail')->nullable();
            $table->date('task_date_start')->nullable();
            $table->date('task_date_end')->nullable();
            $table->integer('task_category_id')->nullable();
            $table->integer('task_tag_id')->nullable();
            $table->integer('task_priority')->nullable();
            $table->integer('task_status')->nullable();
            $table->integer('task_predicted_hours')->nullable();
            $table->integer('task_actual_hours')->nullable();
            $table->integer('task_requester_user_id')->nullable();
            $table->integer('task_requested_user_id')->nullable();
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
        Schema::dropIfExists('tasks');
    }
}
