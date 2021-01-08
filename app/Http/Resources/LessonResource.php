<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'video' => $this->video,
      'chapter_id' => $this->chapter_id,
      'created_at' => $this->created_at->format('y F d H:m:s'),
      'updated_at' => $this->updated_at->format('y F d H:m:s'),
    ];
  }

  public function with($request)
  {
    return [
      'status' => 'success'
    ];
  }
}
