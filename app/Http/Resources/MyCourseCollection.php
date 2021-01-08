<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MyCourseCollection extends ResourceCollection
{
  public function toArray($request)
  {
    return parent::toArray($request);
  }
  public function with($request)
  {
    return [
      'status' => 'success'
    ];
  }
}
