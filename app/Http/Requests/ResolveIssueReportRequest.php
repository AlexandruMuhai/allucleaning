<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResolveIssueReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isPracownik();
    }

    public function rules(): array
    {
        return [
            'resolution_photo' => ['required', 'image', 'max:5120'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
