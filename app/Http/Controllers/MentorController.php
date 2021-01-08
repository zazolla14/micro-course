<?php

namespace App\Http\Controllers;

use App\Http\Requests\MentorRequest;
use App\Http\Resources\MentorResource;
use App\Models\Mentor;

class MentorController extends Controller
{
  public function index()
  {
    $mentors = Mentor::all();
    return MentorResource::collection($mentors);
  }

  public function store(MentorRequest $request)
  {
    $data = $request->all();
    $mentor = Mentor::create($data);
    return new MentorResource($mentor);
  }

  public function show($id)
  {
    $mentor = Mentor::find($id);
    if (!$mentor) {
      return response()->json([
        "status" => "error",
        "message" => "mentor not found"
      ], 404);
    }
    return new MentorResource($mentor);
  }

  public function update(MentorRequest $request, $id)
  {
    $data = $request->all();
    $mentor = Mentor::find($id);
    if (!$mentor) {
      return response()->json([
        'status' => 'error',
        'message' => 'mentor not found'
      ], 404);
    }
    $mentor->update($data);
    return new MentorResource($mentor);
  }

  public function destroy($id)
  {
    $mentor = Mentor::find($id);
    if (!$mentor) {
      return response()->json([
        'status' => 'error',
        'message' => 'mentor not found'
      ], 404);
    }
    $mentor->delete();
    return response()->json([
      'status' => 'error',
      'message' => 'mentor was deleted'
    ]);
  }
}
