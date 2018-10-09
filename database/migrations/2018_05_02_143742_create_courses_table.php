<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->nullable();
            $table->string('vimeo_album_id')->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->string('title')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('image')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('is_featured')->default(0);
            $table->boolean('certificate')->default(0);
            $table->enum('level', ['Beginner', 'Intermediate', 'Advanced'])->default('Beginner');
            $table->smallInteger('duration')->default(0);
            $table->boolean('is_paid')->default(0);
            $table->string('price')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }

}
