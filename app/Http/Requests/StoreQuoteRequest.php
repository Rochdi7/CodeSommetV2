<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fullName' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'companyName' => ['nullable', 'string', 'max:150'],
            'referenceWebsite1' => ['nullable', 'string', 'max:255'],
            'referenceWebsite2' => ['nullable', 'string', 'max:255'],
            'projectType' => ['nullable', 'string', 'max:100'],
            'industry' => ['nullable', 'string', 'max:100'],
            'currentWebsite' => ['nullable', 'string', 'max:255'],
            'estimatedPages' => ['nullable', 'string', 'max:50'],
            'keyFeatures' => ['nullable', 'array', 'max:50'],
            'keyFeatures.*' => ['string', 'max:100'],
            'description' => ['nullable', 'string', 'max:5000'],
            'budgetRange' => ['nullable', 'string', 'max:100'],
            'startTimeline' => ['nullable', 'string', 'max:100'],
            'howFoundUs' => ['nullable', 'string', 'max:100'],
            // Honeypot.
            'website' => ['nullable', 'size:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'fullName.required' => 'Le nom complet est obligatoire.',
            'email.required' => 'L\'adresse e-mail est obligatoire.',
            'email.email' => 'Veuillez entrer une adresse e-mail valide.',
        ];
    }
}
