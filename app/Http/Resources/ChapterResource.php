<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChapterResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'course_id' => $this->course_id,
      'created_at' => $this->created_at->format('d F y H:m:s'),
      'updated_at' => $this->updated_at->format('d F y H:m:s'),
      'lessons' => LessonResource::collection($this->whenLoaded('lessons')) //? dipanggil di model Course pada relationships  Chapters. Karena agar chapter dapat menampilkan child nya (lessons) pada API get chapters
    ];
  }
  public function with($request)
  {
    return [
      'status' => 'success'
    ];
  }
}
