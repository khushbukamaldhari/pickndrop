<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseDownloadUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_download_user', function (Blueprint $table) {
            $table->integer('course_download_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->primary(['course_download_id', 'user_id']);
            $table->foreign('course_download_id')->references('id')->on('course_downloads')->onDelete('cascade');
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
        Schema::dropIfExists('course_download_user');
    }
}
