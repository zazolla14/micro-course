<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageCourseRequest;
use App\Http\Resources\ImageCourseResource;
use App\Models\Course;
use App\Models\ImageCourse;
use Illuminate\Http\Request;

class ImageCourseController extends Controller
{
  public function index()
  {
    //
  }

  public function store(ImageCourseRequest $request)
  {
    $course_id = Course::find($request->course_id);
    if (!$course_id) {
      return $this->courseNotFound();
    }
    return new ImageCourseResource(ImageCourse::create($request->all()));
  }

  public function show($id)
  {
    //
  }

  public function update(Request $request, $id)
  {
    //
  }

  public function destroy($id)
  {
    $image = ImageCourse::find($id);
    if (!$image) {
      return $this->courseNotFound();
    }
    $image->delete();
    return response()->json([
      'status' => 'success',
      'message' => 'image wa deleted'
    ]);
  }

  public function courseNotFound()
  {
    return response()->json([
      'status' => 'error',
      'message' => 'image course not found'
    ], 404);
  }
}
