<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseDownloadsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_downloads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->nullable();
            $table->string('vimeo_video_id')->nullable();
            $table->integer('course_id')->unsigned();
            $table->string('title')->nullable();
            $table->boolean('is_paid')->default(0);
            $table->string('type')->default('video');
            $table->string('file')->nullable();
            $table->smallInteger('duration')->default(0);
            $table->timestamps();

            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_downloads');
    }

}
