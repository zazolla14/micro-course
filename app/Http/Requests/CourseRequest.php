<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class CourseRequest extends FormRequest
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
            'certificate' => 'required|boolean',
            'thumbnail' => 'string|url',
            'type' => ['required', Rule::in(['free', 'premium'])],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'price' => 'integer',
            'level' => ['required', Rule::in(['all-level', 'beginner', 'intermediate', 'advance'])],
            'description' => 'required|string',
            'mentor_id' => 'required|integer'
          ];
        }
      case 'PUT': {
          return [
            'name' => 'string',
            'certificate' => 'boolean',
            'thumbnail' => 'string|url',
            'type' => [Rule::in(['free', 'premium'])],
            'status' => [Rule::in(['draft', 'published'])],
            'price' => 'integer',
            'level' => [Rule::in(['all-level', 'beginner', 'intermediate', 'advance'])],
            'description' => 'string',
            'mentor_id' => 'integer'
          ];
        }
      default:
        break;
    }
  }

  protected function failedValidation(Validator $validator)
  {
    $response = [
      'status' => 'error',
      'message' => $validator->errors()
    ];
    throw new HttpResponseException(response()->json($response, 400));
  }
}
