<?php

namespace App\Http\Requests;

class LoginRequest extends \Illuminate\Foundation\Http\FormRequest
{
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
          'username' => 'required',
          'password' => 'required',
        ];
    }
}