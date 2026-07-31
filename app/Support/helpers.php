<?php

if (! function_exists('asset_v')) {
    /**
     * asset() with a content-version query string (?v=<filemtime>) so static
     * CSS/JS can be served with "Cache-Control: immutable" (see public/.htaccess):
     * editing the file changes the URL and busts every cache instantly.
     */
    function asset_v(string $path): string
    {
        $full = public_path($path);
        $version = is_file($full) ? filemtime($full) : null;

        return asset($path).($version ? '?v='.$version : '');
    }
}
