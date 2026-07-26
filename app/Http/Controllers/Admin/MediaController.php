<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    /**
     * Display the media library index page or return JSON list.
     */
    public function index(Request $request)
    {
        $media = Media::images()
            ->orderByDesc('created_at')
            ->paginate(20);

        if ($request->wantsJson()) {
            return response()->json($media);
        }

        return view('backoffice.pages.media.index', compact('media'));
    }

    /**
     * Upload a new file to the media library.
     */
    public function upload(Request $request)
    {
        // Raster images only. SVG is intentionally excluded (executable XML).
        // `image` verifies the file actually decodes as an image; `mimes`
        // whitelists formats by content-derived extension; `dimensions` caps
        // pixel size to prevent decompression bombs.
        $request->validate([
            'file' => [
                'required', 'file', 'image',
                'mimes:jpg,jpeg,png,webp,gif',
                'max:10240',
                'dimensions:max_width=6000,max_height=6000',
            ],
        ]);

        $file = $request->file('file');

        // Derive the extension from the server-detected MIME, NOT the client name.
        $extension = $this->extensionForMime($file->getMimeType());
        if ($extension === null) {
            return response()->json(['error' => 'Unsupported image type.'], 422);
        }

        $uuid       = (string) Str::uuid();
        $shortUuid  = substr($uuid, 0, 8);
        // Server-generated filename: no attacker-controlled path component.
        $filename   = $shortUuid . '.' . $extension;
        $storedPath = 'media/' . $filename;

        // Re-encode the image to strip EXIF/metadata and neutralize any
        // appended payloads (polyglots), then store the sanitized bytes.
        $sanitized = $this->reencodeImage($file->getRealPath(), $extension);
        if ($sanitized === null) {
            return response()->json(['error' => 'The image could not be processed.'], 422);
        }

        Storage::disk('public')->put($storedPath, $sanitized);

        $medium = Media::create([
            'uuid'          => $uuid,
            // Original name kept for display only; sanitized and length-limited.
            'original_name' => $this->safeOriginalName($file->getClientOriginalName(), $extension),
            'disk'          => 'public',
            'path'          => $storedPath,
            'mime_type'     => $file->getMimeType(),
            'size'          => strlen($sanitized),
        ]);

        return response()->json([
            'success' => true,
            // Top-level "url" is what CKEditor 5's SimpleUploadAdapter reads when
            // an image is dropped or pasted into the post content.
            'url'     => $medium->url,
            'media'   => [
                'id'            => $medium->id,
                'uuid'          => $medium->uuid,
                'short_uuid'    => $medium->short_uuid,
                'url'           => $medium->url,
                'original_name' => $medium->original_name,
                'alt'           => $medium->alt,
                'mime_type'     => $medium->mime_type,
                'size'          => $medium->size,
            ],
        ]);
    }

    /**
     * Delete a media item and its stored file.
     */
    public function destroy(Media $medium)
    {
        // Block deletion if the file is referenced by a blog post, so we do not
        // silently break published articles.
        $references = $this->countBlogReferences($medium);
        if ($references > 0) {
            return response()->json([
                'success' => false,
                'error' => "Ce média est utilisé par {$references} article(s) et ne peut pas être supprimé.",
            ], 409);
        }

        // Only allow deletion on the known 'public' disk with a media/ path.
        if ($medium->disk === 'public' && str_starts_with((string) $medium->path, 'media/')) {
            Storage::disk('public')->delete($medium->path);
        }
        $medium->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Update alt text and title of a media item.
     */
    public function update(Request $request, Media $medium)
    {
        $request->validate([
            'alt'   => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
        ]);

        $medium->update($request->only(['alt', 'title']));

        return response()->json(['success' => true]);
    }

    /**
     * Return 24 latest images for the media picker modal (JSON).
     */
    public function picker()
    {
        $media = Media::images()
            ->orderByDesc('created_at')
            ->limit(24)
            ->get()
            ->map(fn (Media $m) => [
                'id'            => $m->id,
                'uuid'          => $m->uuid,
                'short_uuid'    => $m->short_uuid,
                'url'           => $m->url,
                'original_name' => $m->original_name,
                'alt'           => $m->alt,
                'path'          => $m->path,
            ]);

        return response()->json(['media' => $media]);
    }

    // ─── Helpers ──────────────────────────────────────────────────────

    /**
     * Map a server-detected MIME type to a safe file extension.
     */
    private function extensionForMime(?string $mime): ?string
    {
        return match ($mime) {
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            'image/gif' => 'gif',
            default => null,
        };
    }

    /**
     * Sanitize the client-supplied original name for display/storage as
     * metadata only. Never used in a filesystem path.
     */
    private function safeOriginalName(string $clientName, string $extension): string
    {
        $base = pathinfo($clientName, PATHINFO_FILENAME);
        $base = Str::of($base)->ascii()->replaceMatches('/[^A-Za-z0-9 _-]/', '')->trim();
        $base = $base->isEmpty() ? 'image' : (string) $base->limit(100, '');

        return $base . '.' . $extension;
    }

    /**
     * Re-encode an image via GD to strip metadata (EXIF) and neutralize any
     * appended/embedded payloads. Returns the sanitized bytes, or null on
     * failure. GIF is passed through validated (GD flattens animation), the
     * rest are decoded and re-emitted.
     */
    private function reencodeImage(string $path, string $extension): ?string
    {
        if (! function_exists('imagecreatefromstring')) {
            // GD unavailable: fall back to the validated original bytes.
            $bytes = @file_get_contents($path);

            return $bytes === false ? null : $bytes;
        }

        $data = @file_get_contents($path);
        if ($data === false) {
            return null;
        }

        $image = @imagecreatefromstring($data);
        if ($image === false) {
            return null;
        }

        // Preserve transparency for PNG/WebP/GIF.
        imagesavealpha($image, true);
        imagealphablending($image, false);

        ob_start();
        $ok = match ($extension) {
            'jpg' => imagejpeg($image, null, 85),
            'png' => imagepng($image),
            'webp' => function_exists('imagewebp') ? imagewebp($image, null, 85) : imagepng($image),
            'gif' => imagegif($image),
            default => false,
        };
        $out = ob_get_clean();
        imagedestroy($image);

        return $ok ? $out : null;
    }

    /**
     * Count blog posts that reference this media item (by featured image path
     * or inline in content HTML).
     */
    private function countBlogReferences(Media $medium): int
    {
        $path = $medium->path;
        $url = $medium->url;
        $filename = basename((string) $path);

        return BlogPost::query()
            ->where(function ($q) use ($path, $url, $filename) {
                $q->where('featured_image', 'like', '%' . $path . '%')
                    ->orWhere('featured_image', 'like', '%' . $filename . '%')
                    ->orWhere('content', 'like', '%' . $filename . '%')
                    ->orWhere('content', 'like', '%' . $url . '%');
            })
            ->count();
    }
}
