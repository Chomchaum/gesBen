<?php

namespace App\Http\Requests;

class GetUserRequest extends \Illuminate\Foundation\Http\FormRequest
{
    public function authorize()
    {
        return auth()->user() !== null;
    }

    public function rules() {
        return [];
    }
}