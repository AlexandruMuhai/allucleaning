<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQrPassportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdministrator();
    }

    public function rules(): array
    {
        return [
            'location_id' => ['required', 'exists:locations,id'],
            'zone_name' => ['required', 'string', 'max:255'],
            'next_scheduled_clean' => ['nullable', 'date'],
        ];
    }
}
