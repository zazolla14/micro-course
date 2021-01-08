<?php

use App\Http\Controllers\ChapterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ImageCourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\MyCourseController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'mentors'], function () {
  Route::get('', [MentorController::class, 'index']);
  Route::get('{id}', [MentorController::class, 'show']);
  Route::post('', [MentorController::class, 'store']);
  Route::put('{id}', [MentorController::class, 'update']);
  Route::delete('{id}', [MentorController::class, 'destroy']);
});

Route::group(['prefix' => 'courses'], function () {
  Route::get('', [CourseController::class, 'index']);
  Route::get('{id}', [CourseController::class, 'show']);
  Route::post('', [CourseController::class, 'store']);
  Route::put('{id}', [CourseController::class, 'update']);
  Route::delete('{id}', [CourseController::class, 'destroy']);
});

Route::group(['prefix' => 'chapters'], function () {
  Route::get('', [ChapterController::class, 'index']);
  Route::get('{id}', [ChapterController::class, 'show']);
  Route::post('', [ChapterController::class, 'store']);
  Route::put('{id}', [ChapterController::class, 'update']);
  Route::delete('{id}', [ChapterController::class, 'destroy']);
});

Route::group(['prefix' => 'lessons'], function () {
  Route::get('', [LessonController::class, 'index']);
  Route::get('{id}', [LessonController::class, 'show']);
  Route::post('', [LessonController::class, 'store']);
  Route::put('{id}', [LessonController::class, 'update']);
  Route::delete('{id}', [LessonController::class, 'destroy']);
});

Route::group(['prefix' => 'image-courses'], function () {
  Route::post('', [ImageCourseController::class, 'store']);
  Route::delete('{id}', [ImageCourseController::class, 'destroy']);
});

Route::group(['prefix' => 'my-courses'], function () {
  Route::get('', [MyCourseController::class, 'index']);
  Route::post('', [MyCourseController::class, 'store']);
  Route::post('/premium', [MyCourseController::class, 'storePremiumClass']);
});

Route::group(['prefix' => 'reviews'], function () {
  Route::post('', [ReviewController::class, 'store']);
  Route::put('{id}', [ReviewController::class, 'update']);
  Route::delete('{id}', [ReviewController::class, 'destroy']);
});
