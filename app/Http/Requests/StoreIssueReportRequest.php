<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreIssueReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // publiczny formularz gościa
    }

    public function rules(): array
    {
        return [
            'reporter_name' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:3', 'max:2000'],
            'photo' => ['nullable', 'image', 'max:5120'],
        ];
    }
}
