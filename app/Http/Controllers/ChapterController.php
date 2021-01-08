<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChapterRequest;
use App\Http\Resources\ChapterResource;
use App\Models\Chapter;
use App\Models\Course;

class ChapterController extends Controller
{
  protected function courseNotFound()
  {
    return response()->json([
      "status" => "error",
      "message" => "course not found"
    ], 404);
  }
  protected function chapterNotFound()
  {
    return response()->json([
      "status" => "error",
      "message" => "chapter not found"
    ], 404);
  }

  public function index()
  {
    $chapters = Chapter::query();
    $courseId = request()->query('course_id');
    $chapters->when($courseId, function ($query) use ($courseId) {
      return $query->where('course_id', '=', $courseId);
    });
    return ChapterResource::collection($chapters->get());
  }

  public function store(ChapterRequest $request)
  {
    $course = Course::find($request->course_id);
    if (!$course) {
      return $this->courseNotFound();
    }
    $chapter = Chapter::create($request->all());
    return new ChapterResource($chapter);
  }

  public function show($id)
  {
    $chapter = Chapter::find($id);
    if (!$chapter) {
      return $this->chapterNotFound();
    }
    return new ChapterResource($chapter);
  }

  public function update(ChapterRequest $request, $id)
  {
    $chapter = Chapter::find($id);
    if (!$chapter) {
      return $this->chapterNotFound();
    }
    $courseId = $request->input('course_id');
    if ($courseId) {
      $course = Course::find($courseId);
      if (!$course) {
        return $this->courseNotFound();
      }
    }

    $chapter->update($request->all());
    return new ChapterResource($chapter);
  }

  public function destroy($id)
  {
    $chapter = Chapter::find($id);
    if (!$chapter) {
      return $this->chapterNotFound();
    }
    $chapter->delete();
    return response()->json([
      'status' => 'success',
      'message' => 'Chapter was deleted'
    ]);
  }
}
