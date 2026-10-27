<?php

namespace App\Services\ToolsV2;

use Illuminate\Http\Request;

/**
 * Un outil de la seconde génération : une classe par slug, résolue par le
 * conteneur, qui renvoie le tableau sérialisé en JSON pour le navigateur.
 *
 * Les erreurs utilisateur (saisie invalide) se signalent en levant
 * InvalidInputException ; les URL dangereuses lèvent UnsafeUrlException via
 * SafeHttpFetcher ; tout le reste est une erreur serveur.
 */
interface ToolHandler
{
    /** @return array<string, mixed> */
    public function handle(Request $request): array;
}
