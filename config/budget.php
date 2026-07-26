<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Budget PIN (hashed)
    |--------------------------------------------------------------------------
    |
    | The personal-budget module is gated behind a PIN. Store a *hashed* PIN in
    | the BUDGET_PIN_HASH environment variable — never a plaintext PIN.
    |
    | Generate a hash with:
    |   php artisan tinker
    |   >>> Hash::make('your-pin');
    |
    | If BUDGET_PIN_HASH is empty, a bcrypt hash of the legacy default '1234'
    | is used so existing installs keep working — set a real hash in production.
    |
    */
    'pin_hash' => env('BUDGET_PIN_HASH', '$2y$12$q1PXe85WmF6fxJkL0U.nMuVvFCLwOz.1ciWE0VBHagVWhgUecSunS'),

    /*
    | Minutes the budget stays unlocked after a correct PIN before re-locking.
    */
    'unlock_ttl' => (int) env('BUDGET_UNLOCK_TTL', 15),

];
