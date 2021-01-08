<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'certificate' => $this->certificate,
      'thumbnail' => $this->thumbnail,
      'type' => $this->type,
      'status' => $this->status,
      'price' => $this->price,
      'level' => $this->level,
      'description' => $this->description,
      'mentor_id' => $this->mentor_id,
      'created_at' => $this->created_at->format('d F y H:m:s'),
      'updated_at' => $this->updated_at->format('d F y H:m:s'),
      $this->mergeWhen($this->total_students !== null, [
        'total_students' => $this->total_students,
        'total_videos' => $this->total_videos,
        'reviews' => $this->reviews,
      ]),
      'mentor' => new MentorResource($this->whenLoaded('mentor')),
      'chapters' => ChapterResource::collection($this->whenLoaded('chapters')),
      'images' => ImageCourseResource::collection($this->whenLoaded('images'))
    ];
  }

  public function with($request)
  {
    return [
      'status' => 'success'
    ];
  }
}
