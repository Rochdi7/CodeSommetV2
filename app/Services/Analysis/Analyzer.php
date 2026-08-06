<?php

namespace App\Services\Analysis;

use App\Services\HtmlDocument;

/**
 * Contrat commun à tous les analyseurs du pipeline.
 *
 * Chaque analyseur reçoit le jeu de données partagé et le DOM déjà parsé, puis
 * remplit *sa* section. Le DOM est parsé une seule fois pour l'ensemble du
 * pipeline : c'est l'opération la plus coûteuse après le téléchargement.
 */
interface Analyzer
{
    /**
     * Nom de la section alimentée (sert de clé pour les timings et les échecs).
     */
    public function name(): string;

    /**
     * Enrichit le jeu de données. Ne doit rien renvoyer : l'analyseur écrit
     * directement dans $analysis.
     *
     * Un analyseur qui lève une exception est capté par le pipeline et
     * enregistré dans $analysis->failures ; les autres analyseurs poursuivent.
     */
    public function analyze(SiteAnalysis $analysis, HtmlDocument $dom): void;

    /**
     * L'analyseur nécessite-t-il des requêtes réseau supplémentaires ?
     * Le pipeline peut alors les ignorer en mode « léger ».
     */
    public function needsNetwork(): bool;
}
