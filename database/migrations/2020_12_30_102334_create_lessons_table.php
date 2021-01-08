<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsTable extends Migration
{
  public function up()
  {
    Schema::create('lessons', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('video');
      $table->foreignId('chapter_id')->constrained()->onDelete('cascade');
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('lessons');
  }
}
