<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MentorResource extends JsonResource
{
  public function with($request)
  {
    return ['status' => 'success'];
  }

  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'profile' => $this->profile,
      'profession' => $this->profession,
      'email' => $this->email,
      'created_at' => $this->created_at->format('d F y H:m:s'),
      'updated_at' => $this->updated_at->format('d F y H:m:s')
    ];
  }
}
