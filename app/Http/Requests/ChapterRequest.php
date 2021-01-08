<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ChapterRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    switch (request()->method()) {
      case 'POST': {
          return [
            'name' => 'required|string',
            'course_id' => 'required|integer'
          ];
        }
      case 'PUT': {
          return [
            'name' => 'string',
            'course_id' => 'integer'
          ];
        }
      default:
        break;
    }
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
