<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageCourseResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      "id" => $this->id,
      "course_id" => $this->course_id,
      "image" => $this->image,
      "created_at" => $this->created_at->format('d F y H:m:s'),
      "updated_at" => $this->updated_at->format('d F y H:m:s'),
    ];
  }
  public function with($request)
  {
    return [
      'status' => 'success'
    ];
  }
}
