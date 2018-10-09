<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('course_question_id')->unsigned();
            $table->string('type', 15)->default('text');
            $table->string('answer')->nullable();
            $table->boolean('is_correct')->default(0);
            $table->timestamps();
            $table->foreign('course_question_id')->references('id')->on('course_questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_answers');
    }
}
