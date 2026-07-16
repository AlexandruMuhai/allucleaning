<?php

namespace App\Http\Controllers;

use App\Models\ContactRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'service_type' => 'required|string|in:' . implode(',', array_keys(ContactRequest::serviceTypes())),
            'message' => 'nullable|string|max:5000',
        ]);

        ContactRequest::create($validated);

        return redirect()
            ->route('kontakt')
            ->with('success', 'Dziękujemy za kontakt. Odpowiemy w ciągu 2 godzin!');
    }
}
