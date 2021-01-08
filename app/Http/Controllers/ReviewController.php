<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Course;
use App\Models\MyCourse;
use App\Models\Review;

class ReviewController extends Controller
{
  public function index()
  {
    //
  }

  public function store(ReviewRequest $request)
  {
    $user_id = $request->input('user_id');
    $user = getUser($user_id);
    if ($user['status'] === 'error') {
      return response()->json([
        'status' => $user['status'],
        'message' => $user['message'],
      ], $user['http_code']);
    }

    $course_id = $request->input('course_id');
    $course = Course::find($course_id);
    if (!$course) {
      return response()->json([
        'status' => 'error',
        'message' => 'course not found'
      ], 404);
    }

    $checkUserCourse = MyCourse::where('user_id', $user_id)->where('course_id', $course_id)->exists();
    if (!$checkUserCourse) {
      return response()->json([
        'status' => 'error',
        'message' => 'user not take this course'
      ], 404);
    }

    $uniqueReview = Review::where('user_id', $user_id)->where('course_id', $course_id)->exists();
    if ($uniqueReview) {
      return response()->json([
        'status' => 'error',
        'message' => 'user already review this course'
      ], 409);
    }

    $review = Review::create($request->all());
    return new ReviewResource($review);
  }

  public function show($id)
  {
    //
  }

  public function update(ReviewRequest $request, $id)
  {
    $review = Review::find($id);
    if (!$review) {
      return response()->json([
        'status' => 'error',
        'message' => 'review not found'
      ], 404);
    };

    //! tidak perlu mengirimkan user_id dan course_id, karena user hanya perlu mengedit rating dan note
    // $user_id = $request->input('user_id');
    // if ($user_id) {
    //   $user = getUser($user_id);
    //   if ($user['status'] === 'error') {
    //     return response()->json([
    //       'status' => $user['status'],
    //       'message' => $user['message'],
    //     ], $user['http_code']);
    //   }
    // }

    // $course_id = $request->input('course_id');
    // if ($course_id) {
    //   $course = Course::find($course_id);
    //   if (!$course) {
    //     return response()->json([
    //       'status' => 'error',
    //       'message' => 'course not found'
    //     ], 404);
    //   }
    // }

    // if ($user_id && $course_id) {
    //   $checkUserCourse = MyCourse::where('user_id', $user_id)->where('course_id', $course_id)->exists();
    //   if (!$checkUserCourse) {
    //     return response()->json([
    //       'status' => 'error',
    //       'message' => 'user not take this course'
    //     ], 404);
    //   }

    //   $uniqueReview = Review::where('user_id', $user_id)->where('course_id', $course_id)->exists();
    //   if ($uniqueReview) {
    //     return response()->json([
    //       'status' => 'error',
    //       'message' => 'user already review this course'
    //     ], 409);
    //   }

    //   $review->update($request->all());
    //   return new ReviewResource($review);
    // }

    // if ($user_id) {
    //   $checkUserCourse = MyCourse::where('user_id', $user_id)->where('course_id', $review['course_id'])->exists();
    //   if (!$checkUserCourse) {
    //     return response()->json([
    //       'status' => 'error',
    //       'message' => 'user not take this course'
    //     ], 404);
    //   }
    // }

    // if ($course_id) {
    //   $uniqueReview = Review::where('user_id', $review['user_id'])->where('course_id', $course_id)->exists();
    //   if ($uniqueReview) {
    //     return response()->json([
    //       'status' => 'error',
    //       'message' => 'user already review this course'
    //     ], 409);
    //   }
    // }

    $review->update($request->except('user_id', 'course_id'));
    return new ReviewResource($review);
  }

  public function destroy($id)
  {
    $review = Review::find($id);
    if (!$review) {
      return response()->json([
        'status' => 'error',
        'message' => 'review not found'
      ], 404);
    }
    $review->delete();
    return response()->json([
      'status' => 'susccess',
      'message' => 'review was deleted'
    ]);
  }
}
