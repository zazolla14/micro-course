<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageCourse extends Model
{
  protected $table = 'image_courses';

  use HasFactory;
  protected $fillable = ['course_id', 'image'];
}
