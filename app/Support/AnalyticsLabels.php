<?php

namespace App\Support;

/**
 * French labels + tiny formatters shared by the admin analytics views.
 */
final class AnalyticsLabels
{
    public const PERIODS = ['today' => "Aujourd'hui", '7d' => '7 jours', '30d' => '30 jours', '90d' => '90 jours', 'all' => 'Tout'];

    public const SOURCES = [
        'direct' => 'Direct', 'organic' => 'Recherche (SEO)', 'social' => 'Réseaux sociaux', 'ai' => 'Assistants IA',
        'campaign' => 'Campagne (UTM)', 'paid' => 'Publicité payante', 'referral' => 'Site référent',
    ];

    public const SOURCE_COLORS = [
        'direct' => '#6B7280', 'organic' => '#00AEEF', 'social' => '#7D53FF', 'ai' => '#F59E0B',
        'campaign' => '#10B981', 'paid' => '#EF4444', 'referral' => '#0071BC',
    ];

    public const KINDS = [
        'cta' => 'CTA (devis / contact)', 'cal' => 'Prise de RDV (Cal.com)', 'whatsapp' => 'WhatsApp', 'phone' => 'Appel téléphone',
        'email' => 'E-mail', 'outbound' => 'Lien sortant', 'download' => 'Téléchargement', 'nav' => 'Navigation',
        'footer' => 'Pied de page', 'submit' => 'Envoi de formulaire', 'link' => 'Lien', 'button' => 'Bouton', 'tool' => 'Outil SEO',
    ];

    public const TYPES = [
        'pageview' => 'Page vue', 'click' => 'Clic', 'form_submit' => 'Formulaire envoyé', 'scroll' => 'Scroll',
        'leave' => 'Sortie de page', 'lead' => 'LEAD', 'tool_use' => 'Outil utilisé', 'js_error' => 'Erreur JS',
    ];

    public const TYPE_COLORS = [
        'pageview' => '#00AEEF', 'click' => '#7D53FF', 'form_submit' => '#10B981', 'scroll' => '#9CA3AF',
        'leave' => '#6B7280', 'lead' => '#EF4444', 'tool_use' => '#F59E0B', 'js_error' => '#DC2626',
    ];

    public const LEAD_TYPES = ['contact' => 'Message de contact', 'quote' => 'Demande de devis', 'newsletter' => 'Newsletter'];

    public const LEAD_COLORS = ['contact' => '#00AEEF', 'quote' => '#10B981', 'newsletter' => '#7D53FF'];

    public const DEVICES = ['mobile' => 'Mobile', 'tablet' => 'Tablette', 'desktop' => 'Ordinateur'];

    public static function duration(?int $seconds): string
    {
        $seconds = (int) $seconds;
        if ($seconds < 60) {
            return $seconds . ' s';
        }
        if ($seconds < 3600) {
            return intdiv($seconds, 60) . ' min ' . str_pad((string) ($seconds % 60), 2, '0', STR_PAD_LEFT) . ' s';
        }

        return intdiv($seconds, 3600) . ' h ' . str_pad((string) intdiv($seconds % 3600, 60), 2, '0', STR_PAD_LEFT);
    }

    public static function source(?string $key): string
    {
        return self::SOURCES[$key] ?? ($key ?: '—');
    }

    public static function kind(?string $key): string
    {
        return self::KINDS[$key] ?? ($key ?: 'Bouton');
    }

    public static function type(?string $key): string
    {
        return self::TYPES[$key] ?? ($key ?: '—');
    }

    public static function leadType(?string $key): string
    {
        return self::LEAD_TYPES[$key] ?? ($key ?: '—');
    }

    /** Regional-indicator flag emoji for an ISO 3166 alpha-2 code. */
    public static function flag(?string $country): string
    {
        if (! $country || ! preg_match('/^[A-Z]{2}$/', $country)) {
            return '';
        }

        return mb_chr(0x1F1E6 + ord($country[0]) - 65) . mb_chr(0x1F1E6 + ord($country[1]) - 65);
    }
}
