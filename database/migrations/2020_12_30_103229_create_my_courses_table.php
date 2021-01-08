<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyCoursesTable extends Migration
{
  public function up()
  {
    Schema::create('my_courses', function (Blueprint $table) {
      $table->id();
      $table->foreignId('course_id')->constrained()->onDelete('cascade');
      $table->integer('user_id');
      $table->unique(['course_id', 'user_id']); //* digunakan agar user tidak bisa memiliki lebih dari satu course yang sama
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('my_courses');
  }
}
