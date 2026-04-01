@php $isEdit = isset($project); @endphp

<div class="grid lg:grid-cols-2 gap-6">
    {{-- Left column --}}
    <div class="space-y-5">
        {{-- Project Info --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="text-sm font-semibold">Informations du Projet</h3>
            </div>
            <div class="admin-card-body space-y-4">

                {{-- Name --}}
                <div>
                    <label class="admin-label">Nom du projet <span class="text-[#00AEEF]">*</span></label>
                    <input type="text" name="name" class="admin-input" value="{{ old('name', $project->name ?? '') }}" required placeholder="Ex: Site E-commerce Premium" />
                    @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label class="admin-label">Description <span class="text-[10px] font-normal text-[var(--text-tertiary)]">(optionnel)</span></label>
                    <textarea name="description" class="admin-input" rows="3" placeholder="Décrivez le projet, les objectifs...">{{ old('description', $project->description ?? '') }}</textarea>
                </div>

                {{-- Type + Priority --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="admin-label">Type de projet <span class="text-[#00AEEF]">*</span></label>
                        <select name="type" id="projectType" class="admin-input" required onchange="handleTypeChange(this.value)">
                            @php
                            $types = [
                                'website'      => 'Site Web',
                                'ecommerce'    => 'E-commerce',
                                'webapp'       => 'Application Web',
                                'saas'         => 'SaaS',
                                'dashboard'    => 'Dashboard',
                                'mobile_app'   => 'App Mobile',
                                'landing_page' => 'Landing Page',
                                'redesign'     => 'Refonte',
                                'maintenance'  => 'Maintenance',
                                'seo'          => 'SEO',
                                'other'        => 'Autre',
                            ];
                            @endphp
                            @foreach($types as $val => $label)
                            <option value="{{ $val }}" {{ old('type', $project->type ?? 'website') === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="admin-label">Priorité <span class="text-[#00AEEF]">*</span></label>
                        <select name="priority" class="admin-input" required>
                            @foreach(['low'=>'Basse','medium'=>'Moyenne','high'=>'Haute','urgent'=>'Urgente'] as $val => $label)
                            <option value="{{ $val }}" {{ old('priority', $project->priority ?? 'medium') === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Type Custom (shown when type=other) --}}
                <div id="typeCustomWrap" style="display:none">
                    <label class="admin-label">Précisez le type <span class="text-[#00AEEF]">*</span></label>
                    <input type="text" name="type_custom" id="typeCustomInput" class="admin-input" value="{{ old('type_custom', $project->type_custom ?? '') }}" placeholder="Ex: Plateforme d'annonces, Application SaaS RH..." />
                </div>

                {{-- Billing Type --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="admin-label">Facturation <span class="text-[#00AEEF]">*</span></label>
                        <select name="billing_type" id="billingType" class="admin-input" onchange="handleBillingChange(this.value)">
                            <option value="one_time"  {{ old('billing_type', $project->billing_type ?? 'one_time')  === 'one_time'  ? 'selected' : '' }}>Projet unique</option>
                            <option value="recurring" {{ old('billing_type', $project->billing_type ?? 'one_time')  === 'recurring' ? 'selected' : '' }}>Récurrent</option>
                        </select>
                    </div>
                    <div id="recurringPeriodWrap" style="display:none">
                        <label class="admin-label">Périodicité</label>
                        <select name="recurring_period" class="admin-input">
                            <option value="monthly"   {{ old('recurring_period', $project->recurring_period ?? 'monthly')   === 'monthly'   ? 'selected' : '' }}>Mensuel</option>
                            <option value="quarterly" {{ old('recurring_period', $project->recurring_period ?? 'monthly')   === 'quarterly' ? 'selected' : '' }}>Trimestriel</option>
                            <option value="annually"  {{ old('recurring_period', $project->recurring_period ?? 'monthly')   === 'annually'  ? 'selected' : '' }}>Annuel</option>
                        </select>
                    </div>
                </div>

                {{-- Stack --}}
                <div>
                    <label class="admin-label">Stack technique <span class="text-[10px] font-normal text-[var(--text-tertiary)]">(séparées par virgules — optionnel)</span></label>
                    <input type="text" name="tech_stack" class="admin-input" value="{{ old('tech_stack', is_array($project->tech_stack ?? null) ? implode(', ', $project->tech_stack) : '') }}" placeholder="Laravel, React, Tailwind, MySQL..." />
                </div>

                {{-- Status --}}
                <div>
                    <label class="admin-label">Statut <span class="text-[#00AEEF]">*</span></label>
                    <select name="status" class="admin-input" required>
                        @foreach(['lead'=>'Lead','proposal'=>'Proposition','negotiation'=>'Négociation','contracted'=>'Sous contrat','discovery'=>'Découverte','design'=>'Design','development'=>'Développement','testing'=>'Test & QA','review'=>'Revue client','launched'=>'Lancé','maintenance'=>'Maintenance','completed'=>'Terminé','cancelled'=>'Annulé','on_hold'=>'En pause'] as $val => $label)
                        <option value="{{ $val }}" {{ old('status', $project->status ?? 'lead') === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                @if($isEdit)
                <div>
                    <label class="admin-label">Progression (%)</label>
                    <div class="flex items-center gap-3">
                        <input type="range" id="progressRange" min="0" max="100" value="{{ old('progress', $project->progress ?? 0) }}"
                               oninput="document.getElementById('progressNum').value=this.value"
                               class="flex-1 h-2 rounded-full cursor-pointer" style="accent-color:#00AEEF" />
                        <input type="number" name="progress" id="progressNum" min="0" max="100"
                               value="{{ old('progress', $project->progress ?? 0) }}"
                               oninput="document.getElementById('progressRange').value=this.value"
                               class="admin-input w-20 text-center" />
                        <span class="text-xs text-[var(--text-tertiary)]">%</span>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- URLs & Repos --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="text-sm font-semibold">URLs & Repos <span class="text-[10px] font-normal text-[var(--text-tertiary)] ml-1">(optionnel)</span></h3>
            </div>
            <div class="admin-card-body space-y-4">
                <div><label class="admin-label">Domaine</label><input type="text" name="domain" class="admin-input" value="{{ old('domain', $project->domain ?? '') }}" placeholder="exemple.com" /></div>
                <div><label class="admin-label">URL Staging</label><input type="url" name="staging_url" class="admin-input" value="{{ old('staging_url', $project->staging_url ?? '') }}" placeholder="https://staging.exemple.com" /></div>
                <div><label class="admin-label">URL Production</label><input type="url" name="production_url" class="admin-input" value="{{ old('production_url', $project->production_url ?? '') }}" placeholder="https://exemple.com" /></div>
                <div><label class="admin-label">Repository Git</label><input type="url" name="repo_url" class="admin-input" value="{{ old('repo_url', $project->repo_url ?? '') }}" placeholder="https://github.com/user/repo" /></div>
            </div>
        </div>
    </div>

    {{-- Right column --}}
    <div class="space-y-5">
        {{-- Client --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="text-sm font-semibold">Client</h3>
            </div>
            <div class="admin-card-body space-y-4">
                <div>
                    <label class="admin-label">Nom du client <span class="text-[#00AEEF]">*</span></label>
                    <input type="text" name="client_name" class="admin-input" value="{{ old('client_name', $project->client_name ?? '') }}" required placeholder="Jean Dupont" />
                </div>
                <div><label class="admin-label">Email <span class="text-[10px] font-normal text-[var(--text-tertiary)]">(optionnel)</span></label><input type="email" name="client_email" class="admin-input" value="{{ old('client_email', $project->client_email ?? '') }}" placeholder="jean@entreprise.com" /></div>
                <div><label class="admin-label">Téléphone <span class="text-[10px] font-normal text-[var(--text-tertiary)]">(optionnel)</span></label><input type="tel" name="client_phone" class="admin-input" value="{{ old('client_phone', $project->client_phone ?? '') }}" placeholder="+212 6 00 00 00 00" /></div>
                <div><label class="admin-label">Entreprise <span class="text-[10px] font-normal text-[var(--text-tertiary)]">(optionnel)</span></label><input type="text" name="client_company" class="admin-input" value="{{ old('client_company', $project->client_company ?? '') }}" placeholder="Acme Corp" /></div>
            </div>
        </div>

        {{-- Planning & Budget --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="text-sm font-semibold">Planification & Budget</h3>
            </div>
            <div class="admin-card-body space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="admin-label">Date de début <span class="text-[10px] font-normal text-[var(--text-tertiary)]">(optionnel)</span></label><input type="date" name="start_date" class="admin-input" value="{{ old('start_date', isset($project) && $project->start_date ? $project->start_date->format('Y-m-d') : '') }}" /></div>
                    <div><label class="admin-label">Deadline <span class="text-[10px] font-normal text-[var(--text-tertiary)]">(optionnel)</span></label><input type="date" name="deadline" class="admin-input" value="{{ old('deadline', isset($project) && $project->deadline ? $project->deadline->format('Y-m-d') : '') }}" /></div>
                </div>
                @if($isEdit)
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="admin-label">Date de lancement</label><input type="date" name="launched_at" class="admin-input" value="{{ old('launched_at', isset($project) && $project->launched_at ? $project->launched_at->format('Y-m-d') : '') }}" /></div>
                    <div><label class="admin-label">Date de complétion</label><input type="date" name="completed_at" class="admin-input" value="{{ old('completed_at', isset($project) && $project->completed_at ? $project->completed_at->format('Y-m-d') : '') }}" /></div>
                </div>
                @endif

                {{-- Prices --}}
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="admin-label">Prix devisé <span class="text-[10px] font-normal text-[var(--text-tertiary)]">(optionnel)</span></label>
                        <input type="number" name="quoted_price" step="0.01" class="admin-input" value="{{ old('quoted_price', $project->quoted_price ?? '') }}" placeholder="0.00" />
                    </div>
                    <div>
                        <label class="admin-label">Prix convenu TTC <span class="text-[#00AEEF]">*</span></label>
                        <input type="number" name="agreed_price" id="agreedPrice" step="0.01" class="admin-input" value="{{ old('agreed_price', $project->agreed_price ?? '') }}" placeholder="0.00" oninput="calcTtc()" />
                    </div>
                    <div>
                        <label class="admin-label">Devise</label>
                        <select name="currency" class="admin-input">
                            @foreach(['MAD'=>'MAD','EUR'=>'EUR','USD'=>'USD','GBP'=>'GBP'] as $val => $label)
                            <option value="{{ $val }}" {{ old('currency', $project->currency ?? 'MAD') === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- TVA --}}
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="admin-label">TVA (%)</label>
                        <input type="number" name="tva_percent" id="tvaPercent" step="0.01" min="0" max="100" class="admin-input" value="{{ old('tva_percent', $project->tva_percent ?? 0) }}" placeholder="0" oninput="calcTtc()" />
                    </div>
                    <div>
                        <label class="admin-label">Part TVA</label>
                        <input type="text" id="tvaAmount" class="admin-input bg-gray-50 cursor-default text-[#F59E0B]" readonly placeholder="0.00" />
                    </div>
                    <div>
                        <label class="admin-label">Prix HT (net)</label>
                        <input type="text" id="priceHt" class="admin-input bg-gray-50 cursor-default font-semibold text-[#22C55E]" readonly placeholder="0.00" />
                    </div>
                </div>
            </div>
        </div>

        {{-- Notes --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="text-sm font-semibold">Notes <span class="text-[10px] font-normal text-[var(--text-tertiary)] ml-1">(optionnel)</span></h3>
            </div>
            <div class="admin-card-body">
                <textarea name="notes" class="admin-input" rows="4" placeholder="Notes internes, rappels, spécificités...">{{ old('notes', $project->notes ?? '') }}</textarea>
            </div>
        </div>
    </div>
</div>

{{-- Submit --}}
<div class="flex items-center justify-end gap-3 mt-6">
    <a href="{{ route('admin.projects.index') }}" class="admin-btn admin-btn-secondary">Annuler</a>
    <button type="submit" class="admin-btn admin-btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
            <polyline points="17 21 17 13 7 13 7 21"></polyline>
            <polyline points="7 3 7 8 15 8"></polyline>
        </svg>
        {{ $isEdit ? 'Mettre à jour' : 'Créer le projet' }}
    </button>
</div>

<script>
// ── Type toggle ──────────────────────────────────────────────────────────────
const recurringTypes = ['seo', 'maintenance'];

function handleTypeChange(val) {
    // "Autre" custom input
    const wrap = document.getElementById('typeCustomWrap');
    const inp  = document.getElementById('typeCustomInput');
    if (val === 'other') {
        wrap.style.display = 'block';
        inp.required = true;
    } else {
        wrap.style.display = 'none';
        inp.required = false;
    }

    // Auto billing_type
    const billing = document.getElementById('billingType');
    if (recurringTypes.includes(val)) {
        billing.value = 'recurring';
    } else {
        billing.value = 'one_time';
    }
    handleBillingChange(billing.value);
}

function handleBillingChange(val) {
    const wrap = document.getElementById('recurringPeriodWrap');
    wrap.style.display = val === 'recurring' ? 'block' : 'none';
}

// ── TVA calculator ───────────────────────────────────────────────────────────
// agreed_price = TTC (what client pays). TVA is extracted from it.
// HT = TTC / (1 + tva/100)  — the net amount you keep
// TVA = TTC - HT             — the portion going to the government
function calcTtc() {
    const ttc = parseFloat(document.getElementById('agreedPrice').value) || 0;
    const pct = parseFloat(document.getElementById('tvaPercent').value)  || 0;
    const ht  = pct > 0 ? ttc / (1 + pct / 100) : ttc;
    const tva = ttc - ht;
    document.getElementById('tvaAmount').value = tva.toFixed(2);
    document.getElementById('priceHt').value   = ht.toFixed(2);
}

// ── Init on page load ────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {
    handleTypeChange(document.getElementById('projectType').value);
    handleBillingChange(document.getElementById('billingType').value);
    calcTtc();
});
</script>
