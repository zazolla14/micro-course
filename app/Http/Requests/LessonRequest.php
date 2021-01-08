<?php

namespace App\Http\Requests;

use App\Models\Lesson;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class LessonRequest extends FormRequest
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
            'name' => 'required|string|unique:lessons,name',
            'video' => 'required|url|unique:lessons,video',
            'chapter_id' => 'required|integer'
          ];
        }
      case 'PUT': {
          $nameRule = Rule::unique((new Lesson)->getTable())->ignore($this->route('id'));
          $videoRule = Rule::unique((new Lesson)->getTable())->ignore($this->route('id'));
          return [
            'name' => ['string', $nameRule],
            'video' => ['url', $videoRule],
            'chapter_id' => 'integer'
          ];
        }

      default:
        break;
    }
  }

  public function failedValidation(Validator $validator)
  {
    $response = [
      'status' => 'success',
      'message' => $validator->errors()
    ];
    throw new HttpResponseException(response()->json($response), 400);
  }
}
