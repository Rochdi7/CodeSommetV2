<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'company' => ['nullable', 'string', 'max:150'],
            'budget' => ['nullable', Rule::in(['small', 'medium', 'large', 'enterprise', 'not-sure'])],
            'inquiryType' => ['nullable', Rule::in([
                'new-project', 'ai-features', 'dashboard-saas', 'website',
                'partnership', 'general', 'support', 'other',
            ])],
            'message' => ['required', 'string', 'max:5000'],
            // Honeypot: must be empty. Bots fill it.
            'website' => ['nullable', 'size:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom est obligatoire.',
            'email.required' => 'L\'adresse e-mail est obligatoire.',
            'email.email' => 'Veuillez entrer une adresse e-mail valide.',
            'message.required' => 'Le message est obligatoire.',
            'website.size' => 'Requête invalide.',
        ];
    }
}
