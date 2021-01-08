<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ReviewRequest extends FormRequest
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
            'user_id' => 'required|integer',
            'course_id' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'note' => 'string',
          ];
        }

      case 'PUT': {
          return [
            'user_id' => 'integer',
            'course_id' => 'integer',
            'rating' => 'integer|min:1|max:5',
            'note' => 'string',
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
