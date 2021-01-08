<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonRequest;
use App\Http\Resources\LessonCollection;
use App\Http\Resources\LessonResource;
use App\Models\Chapter;
use App\Models\Lesson;
use Illuminate\Support\Str;

class LessonController extends Controller
{
  public function chapterNotFound()
  {
    return response()->json([
      'status' => 'error',
      'message' => 'chapter not found'
    ], 404);
  }
  public function lessonNotFound()
  {
    return response()->json([
      'status' => 'error',
      'message' => 'lesson not found'
    ], 404);
  }

  public function index()
  {
    $lessons = Lesson::query();

    $q = request()->query('q');
    $chapter_id = request()->query('chapter_id');
    if ($chapter_id) {
      $chapter = Lesson::where('chapter_id', $chapter_id);
      if (count($chapter->get()) === 0) {
        return $this->lessonNotFound();
      }
    }

    $lessons->when($q, function ($query) use ($q) {
      return $query->whereRaw("name LIKE '%" . Str::lower($q) . "%'");
    });
    $lessons->when($chapter_id, function ($query) use ($chapter_id) {
      return $query->where('chapter_id', '=', $chapter_id);
    });

    return new LessonCollection($lessons->get());
  }

  public function store(LessonRequest $request)
  {
    $chapter = Chapter::find($request->chapter_id);
    if (!$chapter) {
      return $this->chapterNotFound();
    }
    return new LessonResource(Lesson::create($request->all()));
  }

  public function show($id)
  {
    $lesson = Lesson::find($id);
    if (!$lesson) {
      return $this->lessonNotFound();
    }
    return new LessonResource($lesson);
  }

  public function update(LessonRequest $request, $id)
  {
    $lesson = Lesson::find($id);
    if (!$lesson) {
      return $this->lessonNotFound();
    }

    $chapter_id = $request->input('chapter_id');
    if ($chapter_id) {
      $chapter = Chapter::find($chapter_id);
      if (!$chapter) {
        return $this->chapterNotFound();
      }
    }
    $lesson->update($request->all());
    return new LessonResource($lesson);
  }

  public function destroy($id)
  {
    $lesson = Lesson::find($id);
    if (!$lesson) {
      return $this->lessonNotFound();
    }

    $lesson->delete();
    return response()->json([
      'status' => 'error',
      'message' => 'lesson was deleted'
    ]);
  }
}
