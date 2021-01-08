<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'user_id' => $this->user_id,
      'course_id' => $this->course_id,
      'course_details' => new CourseResource($this->course),
      'rating' => $this->rating,
      'note' => $this->note,
      'created_at' => $this->created_at->format('y F d H:m:s'),
      'updated_at' => $this->updated_at->format('y F d H:m:s')
    ];
  }

  public function with($request)
  {
    return [
      'status' => 'success'
    ];
  }
}
