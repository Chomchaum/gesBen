<?php

namespace App\Http\Requests;

class CreateUserRequest extends \Illuminate\Foundation\Http\FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
          'name' => 'required',
          'email' => 'required',
          'password' => 'required',
          ];
    }
}