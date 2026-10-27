<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Support\TrackingIntegrations;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Admin "Intégrations & tags": connect Google Analytics 4, Tag Manager,
 * Search Console / Bing verification, Meta Pixel and Microsoft Clarity
 * without touching code. Values are validated, stored in site_settings and
 * rendered by frontoffice/partials/tracking-{head,tags}.
 */
class IntegrationsController extends Controller
{
    public function index()
    {
        return view('backoffice.pages.integrations.index', [
            'values' => TrackingIntegrations::formValues(),
            'config' => TrackingIntegrations::config(),
            'ids' => TrackingIntegrations::IDS,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate(array_fill_keys(array_keys(TrackingIntegrations::IDS), ['nullable', 'string', 'max:2000']));

        $values = [];
        $errors = [];

        foreach (array_keys(TrackingIntegrations::IDS) as $key) {
            $normalized = TrackingIntegrations::normalize($key, $request->input($key));
            if ($normalized !== null && ! TrackingIntegrations::valid($key, $normalized)) {
                $errors[$key] = 'Format invalide — attendu : '.TrackingIntegrations::IDS[$key]['example'].'.';

                continue;
            }
            $values[$key] = $normalized;
        }

        if ($errors !== []) {
            return back()->withErrors($errors)->withInput();
        }

        foreach (array_keys(TrackingIntegrations::SWITCHES) as $key) {
            $values[$key] = $request->boolean($key) ? '1' : '0';
        }

        SiteSetting::putMany($values);

        return redirect()->route('admin.integrations.index')->with('success', 'Intégrations enregistrées. Les tags sont actifs sur le site public.');
    }
}
