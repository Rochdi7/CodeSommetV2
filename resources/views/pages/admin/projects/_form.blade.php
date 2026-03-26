@php $isEdit = isset($project); @endphp

<div class="grid lg:grid-cols-2 gap-6">
    {{-- Left column --}}
    <div class="space-y-5">
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="text-sm font-semibold">Informations du Projet</h3>
            </div>
            <div class="admin-card-body space-y-4">
                <div>
                    <label class="admin-label">Nom du projet <span class="text-[#00AEEF]">*</span></label>
                    <input type="text" name="name" class="admin-input" value="{{ old('name', $project->name ?? '') }}" required placeholder="Ex: Site E-commerce Premium" />
                    @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="admin-label">Description</label>
                    <textarea name="description" class="admin-input" rows="3" placeholder="D&eacute;crivez le projet, les objectifs...">{{ old('description', $project->description ?? '') }}</textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="admin-label">Type de projet <span class="text-[#00AEEF]">*</span></label>
                        <select name="type" class="admin-input" required>
                            @foreach(['website'=>'Site Web','ecommerce'=>'E-commerce','webapp'=>'Application Web','saas'=>'SaaS','dashboard'=>'Dashboard','mobile_app'=>'App Mobile','landing_page'=>'Landing Page','redesign'=>'Refonte','maintenance'=>'Maintenance','other'=>'Autre'] as $val => $label)
                            <option value="{{ $val }}" {{ old('type', $project->type ?? 'website') === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="admin-label">Priorit&eacute; <span class="text-[#00AEEF]">*</span></label>
                        <select name="priority" class="admin-input" required>
                            @foreach(['low'=>'Basse','medium'=>'Moyenne','high'=>'Haute','urgent'=>'Urgente'] as $val => $label)
                            <option value="{{ $val }}" {{ old('priority', $project->priority ?? 'medium') === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label class="admin-label">Stack technique <span class="text-[10px] font-normal text-[var(--text-tertiary)]">(s&eacute;par&eacute;es par des virgules)</span></label>
                    <input type="text" name="tech_stack" class="admin-input" value="{{ old('tech_stack', is_array($project->tech_stack ?? null) ? implode(', ', $project->tech_stack) : '') }}" placeholder="Laravel, React, Tailwind, MySQL..." />
                </div>
                <div>
                    <label class="admin-label">Statut <span class="text-[#00AEEF]">*</span></label>
                    <select name="status" class="admin-input" required>
                        @foreach(['lead'=>'Lead','proposal'=>'Proposition','negotiation'=>'N&eacute;gociation','contracted'=>'Sous contrat','discovery'=>'D&eacute;couverte','design'=>'Design','development'=>'D&eacute;veloppement','testing'=>'Test & QA','review'=>'Revue client','launched'=>'Lanc&eacute;','maintenance'=>'Maintenance','completed'=>'Termin&eacute;','cancelled'=>'Annul&eacute;','on_hold'=>'En pause'] as $val => $label)
                        <option value="{{ $val }}" {{ old('status', $project->status ?? 'lead') === $val ? 'selected' : '' }}>{!! $label !!}</option>
                        @endforeach
                    </select>
                </div>
                @if($isEdit)
                <div>
                    <label class="admin-label">Progression (%)</label>
                    <input type="number" name="progress" class="admin-input" min="0" max="100" value="{{ old('progress', $project->progress ?? 0) }}" />
                </div>
                @endif
            </div>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="text-sm font-semibold">URLs & Repos</h3>
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
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="text-sm font-semibold">Client</h3>
            </div>
            <div class="admin-card-body space-y-4">
                <div><label class="admin-label">Nom du client <span class="text-[#00AEEF]">*</span></label><input type="text" name="client_name" class="admin-input" value="{{ old('client_name', $project->client_name ?? '') }}" required placeholder="Jean Dupont" /></div>
                <div><label class="admin-label">Email</label><input type="email" name="client_email" class="admin-input" value="{{ old('client_email', $project->client_email ?? '') }}" placeholder="jean@entreprise.com" /></div>
                <div><label class="admin-label">T&eacute;l&eacute;phone</label><input type="tel" name="client_phone" class="admin-input" value="{{ old('client_phone', $project->client_phone ?? '') }}" placeholder="+212 6 00 00 00 00" /></div>
                <div><label class="admin-label">Entreprise</label><input type="text" name="client_company" class="admin-input" value="{{ old('client_company', $project->client_company ?? '') }}" placeholder="Acme Corp" /></div>
            </div>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="text-sm font-semibold">Planification & Budget</h3>
            </div>
            <div class="admin-card-body space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="admin-label">Date de d&eacute;but</label><input type="date" name="start_date" class="admin-input" value="{{ old('start_date', isset($project) && $project->start_date ? $project->start_date->format('Y-m-d') : '') }}" /></div>
                    <div><label class="admin-label">Deadline</label><input type="date" name="deadline" class="admin-input" value="{{ old('deadline', isset($project) && $project->deadline ? $project->deadline->format('Y-m-d') : '') }}" /></div>
                </div>
                @if($isEdit)
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="admin-label">Date de lancement</label><input type="date" name="launched_at" class="admin-input" value="{{ old('launched_at', isset($project) && $project->launched_at ? $project->launched_at->format('Y-m-d') : '') }}" /></div>
                    <div><label class="admin-label">Date de compl&eacute;tion</label><input type="date" name="completed_at" class="admin-input" value="{{ old('completed_at', isset($project) && $project->completed_at ? $project->completed_at->format('Y-m-d') : '') }}" /></div>
                </div>
                @endif
                <div class="grid grid-cols-3 gap-4">
                    <div><label class="admin-label">Prix devis</label><input type="number" name="quoted_price" step="0.01" class="admin-input" value="{{ old('quoted_price', $project->quoted_price ?? '') }}" placeholder="0.00" /></div>
                    <div><label class="admin-label">Prix convenu</label><input type="number" name="agreed_price" step="0.01" class="admin-input" value="{{ old('agreed_price', $project->agreed_price ?? '') }}" placeholder="0.00" /></div>
                    <div><label class="admin-label">Devise</label>
                        <select name="currency" class="admin-input">
                            @foreach(['MAD'=>'MAD','EUR'=>'EUR','USD'=>'USD','GBP'=>'GBP'] as $val => $label)
                            <option value="{{ $val }}" {{ old('currency', $project->currency ?? 'MAD') === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="text-sm font-semibold">Notes</h3>
            </div>
            <div class="admin-card-body">
                <textarea name="notes" class="admin-input" rows="4" placeholder="Notes internes, rappels, sp&eacute;cificit&eacute;s...">{{ old('notes', $project->notes ?? '') }}</textarea>
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
        {{ $isEdit ? 'Mettre &agrave; jour' : 'Cr&eacute;er le projet' }}
    </button>
</div>