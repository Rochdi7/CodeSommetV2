<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

/**
 * Sitemap XML dynamique.
 *
 * N'inclut que des URL canoniques, publiques et indexables (statut 200) :
 * pages cœur, légales, services, villes, outils, études de cas et articles
 * de blog publiés. Exclut l'admin, la preview du blog et l'API.
 */
class SitemapController extends Controller
{
    public function index(): Response
    {
        $base = rtrim(config('app.url'), '/');
        $sitemap = Sitemap::create();

        foreach ($this->staticPaths() as $path) {
            $sitemap->add(Url::create($base.$path));
        }

        // Articles publiés — lastmod réel (date de dernière modification).
        foreach (BlogPost::published()->orderByDesc('published_at')->get(['slug', 'updated_at']) as $post) {
            $sitemap->add(
                Url::create($base.'/blog/'.$post->slug)
                    ->setLastModificationDate($post->updated_at ?? now())
            );
        }

        return response($sitemap->render(), 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }

    /**
     * @return list<string>
     */
    private function staticPaths(): array
    {
        $paths = ['', '/about', '/contact', '/get-quote', '/our-work', '/industries', '/locations', '/tools', '/blog'];

        foreach (config('pages.legal', []) as $slug) {
            $paths[] = "/legal/{$slug}";
        }

        foreach (config('pages.services', []) as $slug) {
            $paths[] = "/services/{$slug}";
        }

        foreach (config('pages.cities', []) as $city) {
            $paths[] = "/web-development-company/{$city}";
        }

        // Outils et études de cas : l'existence de la vue Blade fait office de whitelist.
        foreach (File::glob(resource_path('views/frontoffice/pages/tools/*.blade.php')) as $file) {
            $paths[] = '/tools/'.basename($file, '.blade.php');
        }

        $noindexedCaseStudies = config('pages.noindexed_case_studies', []);
        foreach (File::glob(resource_path('views/frontoffice/pages/our-work/*.blade.php')) as $file) {
            $slug = basename($file, '.blade.php');
            if (in_array($slug, $noindexedCaseStudies, true)) {
                continue;
            }
            $paths[] = '/our-work/'.$slug;
        }

        return $paths;
    }
}
