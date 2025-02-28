<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNotificationsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email_task_updates' => 'boolean',
            'email_project_updates' => 'boolean',
            'email_mentions' => 'boolean',
        ];
    }
}
