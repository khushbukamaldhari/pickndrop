<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionUserPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_question_user', function (Blueprint $table) {
            $table->integer('course_answer_id')->unsigned()->index();
            $table->integer('course_question_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->primary(['course_answer_id', 'course_question_id', 'user_id'], 'answer_id_question_id_user_id_primary');
            $table->foreign('course_answer_id')->references('id')->on('course_answers')->onDelete('cascade');
            $table->foreign('course_question_id')->references('id')->on('course_questions')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_user');
    }
}
