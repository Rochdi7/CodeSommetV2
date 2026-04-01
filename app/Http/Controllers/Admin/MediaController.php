<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,webp,gif,svg|max:10240',
        ]);

        $file        = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $uuid        = (string) \Illuminate\Support\Str::uuid();
        $shortUuid   = substr($uuid, 0, 8);
        $storedPath  = $file->storeAs('media', $shortUuid . '_' . $originalName, 'public');

        $medium = Media::create([
            'uuid'          => $uuid,
            'original_name' => $originalName,
            'disk'          => 'public',
            'path'          => $storedPath,
            'mime_type'     => $file->getMimeType(),
            'size'          => $file->getSize(),
        ]);

        return response()->json([
            'success' => true,
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
        Storage::disk($medium->disk)->delete($medium->path);
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
}
