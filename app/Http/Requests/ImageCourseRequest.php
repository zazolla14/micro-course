<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ImageCourseRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'course_id' => 'required|integer',
      'image' => 'required|url'
    ];
  }

  public function failedValidation(Validator $validator)
  {
    $response = [
      'status' => 'error',
      'message' => $validator->errors()
    ];
    throw new HttpResponseException(response()->json($response, 400));
  }
}
