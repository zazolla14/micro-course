<?php

namespace App\Http\Requests;

use App\Models\Mentor;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class MentorRequest extends FormRequest
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
            'profile' => 'required|string',
            'profession' => 'required|string',
            'email' => 'required|email|unique:mentors,email',
          ];
        }
      case 'PUT': {
          //! digunakan agar saat update email tidak harus diganti
          $emailRule = Rule::unique((new Mentor)->getTable())->ignore($this->route('id'));
          return [
            'name' => 'string',
            'profile' => 'string',
            'profession' => 'string',
            'email' => ['email', $emailRule],
          ];
        }
      default:
        break;
    }
  }
  protected function failedValidation(Validator $validator)
  {
    $response = [
      //! 'message' => $validator, =>> for debugging
      'status' => 'error',
      'message' => $validator->errors()
    ];
    throw new HttpResponseException(response()->json($response, 400));
  }
}
