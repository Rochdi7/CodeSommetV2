<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class NewsletterAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = NewsletterSubscriber::query()->latest('subscribed_at');

        // Search by email or name
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($status = $request->input('status')) {
            if ($status === 'active') {
                $query->where('is_confirmed', true)->whereNull('unsubscribed_at');
            } elseif ($status === 'unsubscribed') {
                $query->whereNotNull('unsubscribed_at');
            }
        }

        $subscribers = $query->paginate(20)->withQueryString();

        $stats = [
            'total'        => NewsletterSubscriber::count(),
            'active'       => NewsletterSubscriber::active()->count(),
            'unsubscribed' => NewsletterSubscriber::whereNotNull('unsubscribed_at')->count(),
        ];

        return view('backoffice.pages.newsletter.index', compact('subscribers', 'stats'));
    }

    public function destroy(NewsletterSubscriber $subscriber): RedirectResponse
    {
        $subscriber->delete();

        return redirect()->back()->with('success', 'Abonné supprimé avec succès.');
    }

    public function export(): StreamedResponse
    {
        $subscribers = NewsletterSubscriber::active()->orderBy('subscribed_at')->get();

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="newsletter_subscribers_' . now()->format('Y-m-d') . '.csv"',
        ];

        return response()->stream(function () use ($subscribers) {
            $handle = fopen('php://output', 'w');

            // BOM for Excel UTF-8 compatibility
            fwrite($handle, "\xEF\xBB\xBF");

            // Header row
            fputcsv($handle, ['Email', 'Nom', 'Source', 'Date d\'inscription']);

            foreach ($subscribers as $sub) {
                fputcsv($handle, [
                    $sub->email,
                    $sub->name ?? '',
                    $sub->source ?? '',
                    $sub->subscribed_at ? $sub->subscribed_at->format('d/m/Y H:i') : '',
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }
}
