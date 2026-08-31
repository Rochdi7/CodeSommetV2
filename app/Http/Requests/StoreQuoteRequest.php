<?php

namespace App\Http\Requests;

use App\Rules\BusinessEmail;
use App\Rules\Recaptcha;
use App\Support\SpamDetector;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Validator;

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
            'email' => ['required', 'email:rfc', 'max:255', new BusinessEmail(allowNonRoutable: ! app()->isProduction())],
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
            'g-recaptcha-response' => [new Recaptcha('quote')],
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
                Log::info('Quote form submission blocked as spam', [
                    'reason' => $reason,
                    'ip' => $this->ip(),
                ]);

                $validator->errors()->add('description', 'Votre demande a été refusée. Merci de la reformuler sans lien ni code.');
            }
        });
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
