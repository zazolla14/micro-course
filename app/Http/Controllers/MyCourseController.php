<?php

namespace App\Http\Controllers;

use App\Http\Requests\MyCourseRequest;
use App\Http\Resources\MyCourseResource;
use App\Models\Course;
use App\Models\MyCourse;

class MyCourseController extends Controller
{
  public function index()
  {
    $myCourses = MyCourse::query();
    $user_id = request()->query('user_id');
    if ($user_id) {
      $user = MyCourse::where('user_id', $user_id);
      if (count($user->get()) === 0) {
        return response()->json([
          'status' => 'error',
          'message' => 'user not found'
        ], 404);
      }
    }
    $myCourses->when($user_id, function ($query) use ($user_id) {
      return $query->where('user_id', $user_id);
    });

    return MyCourseResource::collection($myCourses->get());
  }

  public function store(MyCourseRequest $request)
  {
    $course_id = $request->input('course_id');
    $course = Course::find($course_id);
    if (!$course) {
      return response()->json([
        'status' => 'error',
        'message' => 'course not found'
      ], 404);
    }

    $user_id = $request->input('user_id');
    $user = getUser($user_id);
    if ($user['status'] === 'error') {
      return response()->json([
        'status' => $user['status'],
        'message' => $user['message']
      ], $user['http_code']);
    }

    // return response()->json([
    //   "course" => $course->toArray(),
    //   'user' => $user['data']
    // ]);

    $uniqueMyCourse = MyCourse::where('course_id', '=', $course_id)
      ->where('user_id', '=', $user_id)->exists();
    if ($uniqueMyCourse) {
      return response()->json([
        'status' => 'error',
        'message' => 'user already taken this course'
      ], 409);
    }

    if ($course->type === 'premium') {
      $order = createOrder([
        "course" =>
        [
          "id" => $course->id,
          "name" => $course->name,
          "thumbnail" => $course->thumbnail,
          "price" => $course->price,
          "level" => $course->level
        ],
        'user' =>
        [
          'id' => $user['data']['id'],
          'name' => $user['data']['name'],
          'email' => $user['data']['email']
        ]
      ]);

      if ($order['status'] === 'error') {
        return response()->json([
          'status' => $order['status'],
          'message' => $order['message']
        ], $order['http_code']);
      }

      return response()->json([
        'status' => 'success',
        'data' => $order['data']
      ]);
    } else {
      $myCourse = MyCourse::create($request->all());
      return new MyCourseResource($myCourse);
    }
  }

  public function storePremiumClass(MyCourseRequest $request)
  {
    $myCourse = MyCourse::create($request->all());
    return new MyCourseResource($myCourse);
  }

  public function show($id)
  {
    //
  }

  public function update(MyCourseRequest $request, $id)
  {
    //
  }

  public function destroy($id)
  {
    //
  }
}
