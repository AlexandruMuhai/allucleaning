<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCleanLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isPracownik();
    }

    public function rules(): array
    {
        return [
            'qr_passport_id' => ['required', 'exists:qr_passports,id'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'photo' => ['nullable', 'image', 'max:5120'],
        ];
    }
}
