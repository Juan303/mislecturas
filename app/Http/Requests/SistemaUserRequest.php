<?php

namespace App\Http\Requests;

use App\Role;
use Illuminate\Foundation\Http\FormRequest;

class SistemaUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(auth()->user()){
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()){
            case 'GET':
            case 'DELETE':
                return [];
            case 'POST':
                return [
                    'sistema_id' => 'required',
                ];
            case 'PUT':
                return [
                    'sistema_id' => 'required',
                ];
        }
    }
}
