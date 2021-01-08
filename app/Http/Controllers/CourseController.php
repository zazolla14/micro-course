<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Chapter;
use Illuminate\Support\Str;
use App\Models\Course;
use App\Models\Mentor;
use App\Models\MyCourse;
use App\Models\Review;

class CourseController extends Controller
{
  protected function courseNotFound()
  {
    return response()->json([
      "status" => "error",
      "message" => "course not found"
    ], 404);
  }
  protected function mentorNotFound()
  {
    return response()->json([
      "status" => "error",
      "message" => "mentor not found"
    ], 404);
  }

  public function index()
  {
    $courses = Course::query();
    $q = request()->query('q');
    $type = request()->query('type');
    $status = request()->query('status');

    //* SELECT * FROM courses WHERE name LIKE %q%
    $courses->when($q, function ($query) use ($q) {
      return $query->whereRaw("name LIKE '%" . Str::lower($q) . "%'");
    });
    $courses->when($type, function ($query) use ($type) {
      return $query->where('type', '=', $type);
    });
    $courses->when($status, function ($query) use ($status) {
      return $query->where('status', '=', $status);
    });
    return CourseResource::collection($courses->paginate(10));
  }

  public function store(CourseRequest $request)
  {
    $mentor = Mentor::find($request->mentor_id);
    if (!$mentor) {
      return $this->mentorNotFound();
    }
    $course = Course::create($request->all());
    return new CourseResource($course);
  }

  public function show($id)
  {
    $course = Course::with(['mentor', 'chapters.lessons', 'images'])->find($id);
    if (!$course) {
      return $this->courseNotFound();
    }
    $total_students = MyCourse::where('course_id', $id)->count();
    $total_video = Chapter::where('course_id', $id)->withCount('lessons')->get()->toArray();
    $total_videos = array_sum(array_column($total_video, 'lessons_count'));
    $reviews = Review::where('course_id', $id)->get()->toArray();

    if (count($reviews) > 0) {
      $user_ids = array_column($reviews, 'user_id');
      $users = getUserByIds($user_ids);
      if ($users['status'] === 'error') {
        $reviews = 'service user not available';
      }
      foreach ($reviews as $key => $review) {
        $user_index = array_search($review['user_id'], array_column($users['data'], 'id'));
        $reviews[$key]['user'] = $users['data'][$user_index];
      }
    }
    $course['total_students'] = $total_students;
    $course['total_videos'] = $total_videos;
    $course['reviews'] = $reviews;

    return new CourseResource($course);
  }

  public function update(CourseRequest $request, $id)
  {
    $course = Course::find($id);
    if (!$course) {
      return $this->courseNotFound();
    }
    $mentorId = request()->input('mentor_id');
    if ($mentorId) {
      $mentor = Mentor::find($mentorId);
      if (!$mentor) {
        return $this->mentorNotFound();
      }
    }

    $course->update($request->all());
    return new CourseResource($course);
  }

  public function destroy($id)
  {
    $course = Course::find($id);
    if (!$course) {
      return $this->courseNotFound();
    }
    $course->delete();
    return response()->json([
      'status' => 'success',
      'message' => 'course deleted'
    ]);
  }
}
