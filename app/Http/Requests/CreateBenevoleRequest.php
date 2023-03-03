<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBenevoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'user_id' => 'required',
          'lastname' => 'required',
          'firstname' => 'required',
          'birthdate' => 'required',
          'isUnderage' => 'required',
          'phone' => 'sometimes',
          'size' => 'sometimes',
        ];
    }
}
