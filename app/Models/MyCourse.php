<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyCourse extends Model
{
  protected $table = 'my_courses';

  use HasFactory;
  protected $fillable = ['course_id', 'user_id'];

  public function course()
  {
    return $this->belongsTo(Course::class);
  }
}