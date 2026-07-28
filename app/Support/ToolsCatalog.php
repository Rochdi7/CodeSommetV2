<?php

namespace App\Support;

use Illuminate\Support\Facades\File;

/**
 * Source de vérité pour le catalogue d'outils.
 *
 * La route `tool` (routes/web.php) rend la vue
 * `frontoffice.pages.tools.{slug}` : l'ensemble des fichiers de ce répertoire
 * définit donc exactement les outils accessibles publiquement. Compter ces
 * fichiers évite les compteurs codés en dur qui dérivent (la page annonçait
 * « 45 outils » alors que 46 pages existaient).
 */
class ToolsCatalog
{
    /** Répertoire des vues d'outils routées. */
    private const VIEW_DIR = 'frontoffice/pages/tools';

    /** @var list<string>|null */
    private static ?array $slugs = null;

    /**
     * Slugs de tous les outils disponibles, triés alphabétiquement.
     *
     * @return list<string>
     */
    public static function slugs(): array
    {
        if (self::$slugs !== null) {
            return self::$slugs;
        }

        $dir = resource_path('views/' . self::VIEW_DIR);

        if (! File::isDirectory($dir)) {
            return self::$slugs = [];
        }

        $slugs = [];
        foreach (File::files($dir) as $file) {
            $name = $file->getFilename();
            if (! str_ends_with($name, '.blade.php')) {
                continue;
            }
            $slugs[] = substr($name, 0, -strlen('.blade.php'));
        }

        sort($slugs);

        return self::$slugs = $slugs;
    }

    /** Nombre d'outils disponibles. */
    public static function count(): int
    {
        return count(self::slugs());
    }

    /** Vrai si le slug correspond à un outil existant. */
    public static function has(string $slug): bool
    {
        return in_array($slug, self::slugs(), true);
    }

    /** Réinitialise le cache mémoire (utile en tests). */
    public static function flush(): void
    {
        self::$slugs = null;
    }
}
