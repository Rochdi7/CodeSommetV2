@extends('backoffice.layouts.admin')

@section('title', 'Abonnés Newsletter | Admin')
@section('page_title', 'Abonnés Newsletter')

@section('content')

{{-- Header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-[var(--text-primary)]">Abonnés Newsletter</h1>
        <p class="text-xs text-[var(--text-tertiary)] mt-0.5">Gérez les abonnés à la newsletter du site.</p>
    </div>
    <a href="{{ route('admin.newsletter.export') }}" class="admin-btn admin-btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
            <polyline points="7 10 12 15 17 10"/>
            <line x1="12" x2="12" y1="15" y2="3"/>
        </svg>
        Exporter CSV
    </a>
</div>

{{-- Stats --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="admin-stat-card">
        <div class="text-xs font-semibold text-[var(--text-tertiary)] uppercase tracking-wider mb-1">Total abonnés</div>
        <div class="text-2xl font-bold text-[var(--text-primary)]">{{ number_format($stats['total']) }}</div>
    </div>
    <div class="admin-stat-card">
        <div class="text-xs font-semibold text-[var(--text-tertiary)] uppercase tracking-wider mb-1">Actifs</div>
        <div class="text-2xl font-bold text-green-600">{{ number_format($stats['active']) }}</div>
    </div>
    <div class="admin-stat-card">
        <div class="text-xs font-semibold text-[var(--text-tertiary)] uppercase tracking-wider mb-1">Désabonnés</div>
        <div class="text-2xl font-bold text-gray-400">{{ number_format($stats['unsubscribed']) }}</div>
    </div>
</div>

{{-- Filters --}}
<div class="admin-card mb-5">
    <div class="admin-card-body">
        <form method="GET" action="{{ route('admin.newsletter.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <label class="admin-label">Recherche</label>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Email ou nom..."
                    class="admin-input"
                />
            </div>
            <div class="sm:w-48">
                <label class="admin-label">Statut</label>
                <select name="status" class="admin-input">
                    <option value="">Tous</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Actifs</option>
                    <option value="unsubscribed" {{ request('status') === 'unsubscribed' ? 'selected' : '' }}>Désabonnés</option>
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="admin-btn admin-btn-primary">Filtrer</button>
                @if(request('search') || request('status'))
                    <a href="{{ route('admin.newsletter.index') }}" class="admin-btn admin-btn-secondary">Réinitialiser</a>
                @endif
            </div>
        </form>
    </div>
</div>

{{-- Table --}}
<div class="admin-card">
    <div class="admin-card-header">
        <span class="text-sm font-semibold text-[var(--text-primary)]">
            {{ $subscribers->total() }} abonné{{ $subscribers->total() !== 1 ? 's' : '' }}
        </span>
    </div>

    @if($subscribers->isEmpty())
        <div class="admin-card-body text-center py-12">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="mx-auto mb-3 text-gray-300">
                <rect width="20" height="16" x="2" y="4" rx="2"/>
                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
            </svg>
            <p class="text-sm text-[var(--text-tertiary)]">Aucun abonné trouvé.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Nom</th>
                        <th>Source</th>
                        <th>Statut</th>
                        <th>Inscrit le</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subscribers as $subscriber)
                    <tr>
                        <td class="font-medium">{{ $subscriber->email }}</td>
                        <td class="text-[var(--text-secondary)]">{{ $subscriber->name ?: '—' }}</td>
                        <td>
                            @if($subscriber->source)
                                <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded text-xs font-medium">{{ $subscriber->source }}</span>
                            @else
                                <span class="text-[var(--text-tertiary)]">—</span>
                            @endif
                        </td>
                        <td>
                            @if($subscriber->unsubscribed_at)
                                <span class="admin-badge" style="background:#FEF2F2;color:#EF4444;">Désabonné</span>
                            @else
                                <span class="admin-badge" style="background:#F0FDF4;color:#16A34A;">Actif</span>
                            @endif
                        </td>
                        <td class="text-[var(--text-secondary)]">
                            {{ $subscriber->subscribed_at ? $subscriber->subscribed_at->format('d/m/Y H:i') : '—' }}
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.newsletter.destroy', $subscriber) }}" onsubmit="return confirm('Supprimer cet abonné ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 6h18"/>
                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                    </svg>
                                    Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($subscribers->hasPages())
            <div class="px-5 py-4 border-t border-gray-50">
                {{ $subscribers->links() }}
            </div>
        @endif
    @endif
</div>

@endsection
