<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MyCourseResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'course_id' => $this->course_id,
      'user_id' => $this->user_id,
      'created_at' => $this->created_at->format('y F m H:m:s'),
      'updated_at' => $this->updated_at->format('y F m H:m:s'),
      'course_detail' => new CourseResource($this->course)
    ];
  }
  public function with($request)
  {
    return [
      'status' => 'success'
    ];
  }
}
