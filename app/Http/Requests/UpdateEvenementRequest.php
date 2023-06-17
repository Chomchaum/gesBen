<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEvenementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->owned_events()->find($this->request->get('id')) !== null ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required',
            'nom' => 'sometimes',
            'organisation' => 'sometimes',
            'description' => 'sometimes',
            'site_web' => 'sometimes',
            'reseaux_sociaux' => 'sometimes',
            'private' => 'sometimes',
        ];
    }

}
