@php
    use App\Support\AnalyticsLabels as L;
    $isDefault = ! $filters['kind'] && ! $filters['source'] && ! $filters['country'] && ! $filters['device'] && ! $filters['converted'] && ! $filters['q'] && $filters['period'] === '30d';
@endphp
<div class="admin-card mb-5">
    <div class="admin-card-body">
        <form method="GET" action="{{ $action }}" class="flex flex-col lg:flex-row gap-3 flex-wrap">
            <div class="lg:w-36">
                <label class="admin-label">P&eacute;riode</label>
                <select name="period" class="admin-input">
                    @foreach($periods as $p)
                        <option value="{{ $p }}" {{ $filters['period'] === $p ? 'selected' : '' }}>{{ L::PERIODS[$p] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="lg:w-44">
                <label class="admin-label">Source</label>
                <select name="source" class="admin-input">
                    <option value="">Toutes</option>
                    @foreach(L::SOURCES as $key => $label)
                        <option value="{{ $key }}" {{ $filters['source'] === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="lg:w-36">
                <label class="admin-label">Appareil</label>
                <select name="device" class="admin-input">
                    <option value="">Tous</option>
                    @foreach(L::DEVICES as $key => $label)
                        <option value="{{ $key }}" {{ $filters['device'] === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="lg:w-28">
                <label class="admin-label">Pays</label>
                <input type="text" name="country" value="{{ $filters['country'] }}" placeholder="MA, FR…" maxlength="2" class="admin-input uppercase" />
            </div>
            <div class="lg:w-36">
                <label class="admin-label">Type</label>
                <select name="kind" class="admin-input">
                    <option value="">Humains</option>
                    <option value="bot" {{ $filters['kind'] === 'bot' ? 'selected' : '' }}>Bots</option>
                    <option value="all" {{ $filters['kind'] === 'all' ? 'selected' : '' }}>Humains + bots</option>
                </select>
            </div>
            <div class="flex-1 min-w-[180px]">
                <label class="admin-label">Recherche</label>
                <input type="text" name="q" value="{{ $filters['q'] }}" placeholder="IP, page, referer, campagne, id visiteur…" class="admin-input" />
            </div>
            <div class="flex items-end gap-2 pb-0.5">
                <label class="inline-flex items-center gap-1.5 text-xs text-[var(--text-secondary)] h-[38px] whitespace-nowrap">
                    <input type="checkbox" name="converted" value="1" {{ $filters['converted'] ? 'checked' : '' }} /> Leads uniquement
                </label>
                <button type="submit" class="admin-btn admin-btn-primary">Filtrer</button>
                @unless($isDefault)
                    <a href="{{ $action }}" class="admin-btn admin-btn-secondary">R&eacute;initialiser</a>
                @endunless
            </div>
        </form>
    </div>
</div>
