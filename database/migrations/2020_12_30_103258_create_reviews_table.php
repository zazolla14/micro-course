<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
  public function up()
  {
    Schema::create('reviews', function (Blueprint $table) {
      $table->id();
      $table->integer('user_id');
      $table->foreignId('course_id')->constrained()->onDelete('cascade');
      $table->unique(['course_id', 'user_id']); //* digunakan agar user yang sama hanya dapat mengirim satu review pada setiap course
      $table->integer('rating')->default(1);
      $table->longText('note')->nullable();
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('reviews');
  }
}
