<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageCoursesTable extends Migration
{
  public function up()
  {
    Schema::create('image_courses', function (Blueprint $table) {
      $table->id();
      $table->foreignId('course_id')->constrained()->onDelete('cascade');
      $table->string('image');
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('image_courses');
  }
}
