<?php

namespace App\Http\Requests;

use App\Rules\BusinessEmail;
use App\Rules\Recaptcha;
use App\Support\SpamDetector;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

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
            // Reserved domains (example.com) stay usable outside production so
            // the test suite and local smoke-testing are not blocked.
            'email' => ['required', 'email:rfc', 'max:255', new BusinessEmail(allowNonRoutable: ! app()->isProduction())],
            'phone' => ['nullable', 'string', 'max:50'],
            'company' => ['nullable', 'string', 'max:150'],
            'budget' => ['nullable', Rule::in(['small', 'medium', 'large', 'enterprise', 'not-sure'])],
            'inquiryType' => ['nullable', Rule::in([
                'new-project', 'ai-features', 'dashboard-saas', 'website',
                'partnership', 'general', 'support', 'other',
            ])],
            'message' => ['required', 'string', 'min:20', 'max:5000'],
            // Honeypot: must be empty. Bots fill it.
            'website' => ['nullable', 'size:0'],
            'g-recaptcha-response' => [new Recaptcha('contact')],
        ];
    }

    /**
     * Heuristic spam rejection, applied after the field rules pass. Bots that
     * defeat the honeypot and reCAPTCHA still get stopped here.
     */
    public function withValidator(ValidatorContract $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            $reason = SpamDetector::check($validator->getData());

            if ($reason !== null) {
                Log::info('Contact form submission blocked as spam', [
                    'reason' => $reason,
                    'ip' => $this->ip(),
                ]);

                // Deliberately vague: never tell a bot which filter caught it.
                $validator->errors()->add('message', 'Votre message a été refusé. Merci de reformuler votre demande sans lien ni code.');
            }
        });
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom est obligatoire.',
            'email.required' => 'L\'adresse e-mail est obligatoire.',
            'email.email' => 'Veuillez entrer une adresse e-mail valide.',
            'message.required' => 'Le message est obligatoire.',
            'message.min' => 'Merci de détailler votre demande (20 caractères minimum).',
            'website.size' => 'Requête invalide.',
        ];
    }
}
