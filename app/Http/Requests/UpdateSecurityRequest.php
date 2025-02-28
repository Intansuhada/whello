<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSecurityRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'sometimes|required|email|unique:users,email,' . auth()->id(),
            'current_password' => 'required_with:new_password',
            'new_password' => 'sometimes|required|min:8|confirmed',
        ];
    }
}
