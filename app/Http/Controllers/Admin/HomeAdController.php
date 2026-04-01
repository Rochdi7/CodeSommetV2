<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeAd;
use Illuminate\Http\Request;

class HomeAdController extends Controller
{
    public function index()
    {
        $ads = [
            1 => HomeAd::forSlot(1),
            2 => HomeAd::forSlot(2),
            3 => HomeAd::forSlot(3),
        ];

        return view('pages.admin.home-ads.index', compact('ads'));
    }

    public function update(Request $request, HomeAd $homeAd)
    {
        $validated = $request->validate([
            'title'     => 'nullable|string|max:255',
            'link_url'  => 'nullable|url|max:500',
            'alt_text'  => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'image'     => 'nullable|image|max:5120',
        ]);

        $data = [
            'title'     => $validated['title'] ?? $homeAd->title,
            'link_url'  => $validated['link_url'] ?? $homeAd->link_url,
            'alt_text'  => $validated['alt_text'] ?? $homeAd->alt_text,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('home-ads', 'public');
        }

        $homeAd->update($data);

        return redirect()->back()->with('success', 'Bannière mise à jour avec succès.');
    }

    public function toggle(HomeAd $homeAd)
    {
        $homeAd->update(['is_active' => ! $homeAd->is_active]);

        return response()->json([
            'success'   => true,
            'is_active' => $homeAd->is_active,
        ]);
    }
}
