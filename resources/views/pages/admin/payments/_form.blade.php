@php $isEdit = isset($payment); @endphp

<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="text-sm font-semibold">{{ $isEdit ? 'Modifier le paiement' : 'Nouveau paiement' }}</h3>
    </div>
    <div class="admin-card-body space-y-4">

        {{-- Project --}}
        <div>
            <label class="admin-label">Projet <span class="text-[#00AEEF]">*</span></label>
            <select name="project_id" id="projectSelect" class="admin-input" required onchange="fillAmountFromProject(this.value)">
                <option value="">Sélectionner un projet</option>
                @foreach($projects as $p)
                <option value="{{ $p->id }}" {{ old('project_id', $payment->project_id ?? ($selectedProject ?? '')) == $p->id ? 'selected' : '' }}>
                    {{ $p->name }} ({{ $p->client_name }})
                </option>
                @endforeach
            </select>
            @error('project_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Amount + Currency --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="admin-label">Montant total dû <span class="text-[#00AEEF]">*</span></label>
                <input type="number" step="0.01" name="amount" id="pmtAmount" class="admin-input"
                       value="{{ old('amount', $payment->amount ?? '') }}"
                       required placeholder="0.00"
                       oninput="calcReste()" />
                @error('amount') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="admin-label">Devise</label>
                <select name="currency" class="admin-input">
                    @foreach(['MAD'=>'MAD','EUR'=>'EUR','USD'=>'USD','GBP'=>'GBP'] as $val => $label)
                    <option value="{{ $val }}" {{ old('currency', $payment->currency ?? 'MAD') === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>


        {{-- Partial / Full toggle --}}
        <div>
            <label class="admin-label">Mode de règlement <span class="text-[#00AEEF]">*</span></label>
            <div class="grid grid-cols-2 gap-3">
                <label class="cursor-pointer" onclick="selectRadioCard(this, 'payment_mode', 'selected-green'); handleModeChange('full')">
                    <input type="radio" name="payment_mode" value="full" id="modeFull" class="sr-only"
                           {{ old('payment_mode', $payment->payment_mode ?? 'full') === 'full' ? 'checked' : '' }} required />
                    <div class="radio-card {{ old('payment_mode', $payment->payment_mode ?? 'full') === 'full' ? 'selected-green' : '' }}" style="padding:12px">
                        <div style="font-size:1.25rem;margin-bottom:4px">💯</div>
                        <div style="font-size:14px;font-weight:600;color:var(--text-primary)">Paiement complet</div>
                        <div style="font-size:10px;color:var(--text-tertiary);margin-top:2px">Le montant total est réglé</div>
                    </div>
                </label>
                <label class="cursor-pointer" onclick="selectRadioCard(this, 'payment_mode', 'selected-amber'); handleModeChange('partial')">
                    <input type="radio" name="payment_mode" value="partial" id="modePartial" class="sr-only"
                           {{ old('payment_mode', $payment->payment_mode ?? 'full') === 'partial' ? 'checked' : '' }} />
                    <div class="radio-card {{ old('payment_mode', $payment->payment_mode ?? 'full') === 'partial' ? 'selected-amber' : '' }}" style="padding:12px">
                        <div style="font-size:1.25rem;margin-bottom:4px">🔢</div>
                        <div style="font-size:14px;font-weight:600;color:var(--text-primary)">Paiement partiel</div>
                        <div style="font-size:10px;color:var(--text-tertiary);margin-top:2px">Une partie seulement versée</div>
                    </div>
                </label>
            </div>
        </div>

        {{-- Période (recurring projects only) --}}
        <div id="periodBlock" style="display:none">
            <div class="bg-[#7D53FF]/5 border border-[#7D53FF]/20 rounded-xl p-4 space-y-3">
                <div class="flex items-center gap-2 mb-1">
                    <div class="w-2 h-2 rounded-full" style="background:#7D53FF"></div>
                    <span style="font-size:12px;font-weight:600;color:#7D53FF">Projet récurrent — Période couverte</span>
                </div>
                <input type="hidden" name="billing_period" id="billingPeriodFinal"
                       value="{{ old('billing_period', $payment->billing_period ?? '') }}" />
                <div id="periodMonthlyWrap" style="display:none">
                    <label class="admin-label">Mois <span class="text-[#00AEEF]">*</span></label>
                    <input type="month" id="periodMonthInput" class="admin-input"
                           oninput="document.getElementById('billingPeriodFinal').value=this.value" />
                </div>
                <div id="periodQuarterlyWrap" style="display:none">
                    <label class="admin-label">Trimestre <span class="text-[#00AEEF]">*</span></label>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                        <select id="periodQtr" class="admin-input" onchange="syncQtr()">
                            <option value="Q1">T1 (Jan–Mar)</option>
                            <option value="Q2">T2 (Avr–Jun)</option>
                            <option value="Q3">T3 (Jul–Sep)</option>
                            <option value="Q4">T4 (Oct–Déc)</option>
                        </select>
                        <input type="number" id="periodQtrYear" class="admin-input"
                               value="{{ now()->year }}" min="2020" max="2099" oninput="syncQtr()" />
                    </div>
                </div>
                <div id="periodAnnuallyWrap" style="display:none">
                    <label class="admin-label">Année <span class="text-[#00AEEF]">*</span></label>
                    <input type="number" id="periodYearInput" class="admin-input"
                           value="{{ now()->year }}" min="2020" max="2099"
                           oninput="document.getElementById('billingPeriodFinal').value=this.value" />
                </div>
                <p style="font-size:10px;color:var(--text-tertiary)">La facture générée inclura automatiquement cette période.</p>
            </div>
        </div>

        {{-- Partial amount + reste (shown only in partial mode) --}}
        <div id="partialBlock" style="display:none">
            <div class="bg-[#F59E0B]/5 border border-[#F59E0B]/30 rounded-xl p-4 space-y-3">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="admin-label">Montant versé <span class="text-[#00AEEF]">*</span></label>
                        <input type="number" step="0.01" name="partial_amount" id="partialAmount" class="admin-input"
                               value="{{ old('partial_amount', $payment->partial_amount ?? '') }}"
                               placeholder="0.00" min="0"
                               oninput="calcReste()" />
                    </div>
                    <div>
                        <label class="admin-label">Reste à payer</label>
                        <div class="admin-input bg-gray-50 flex items-center gap-2 cursor-default">
                            <span id="resteDisplay" class="font-bold text-[#EF4444]">—</span>
                            <span id="resteCurrency" class="text-xs text-[var(--text-tertiary)]">MAD</span>
                        </div>
                    </div>
                </div>
                <div id="resteWarning" class="hidden text-xs text-[#EF4444] font-medium">
                    ⚠️ Le montant versé dépasse le montant total.
                </div>
                <div id="restePaidInfo" class="hidden text-xs text-[#22C55E] font-medium">
                    ✅ Montant intégralement couvert — sera marqué comme Payé.
                </div>
            </div>
        </div>

        {{-- Method --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="admin-label">Méthode <span class="text-[#00AEEF]">*</span></label>
                <select name="method" id="paymentMethod" class="admin-input" required onchange="toggleMethodCustom(this.value)">
                    <option value="cash"          {{ old('method', $payment->method ?? '') === 'cash'          ? 'selected' : '' }}>Espèces</option>
                    <option value="bank_transfer"  {{ old('method', $payment->method ?? 'bank_transfer') === 'bank_transfer'  ? 'selected' : '' }}>Virement bancaire</option>
                    <option value="cheque"         {{ old('method', $payment->method ?? '') === 'cheque'        ? 'selected' : '' }}>Chèque</option>
                    <option value="paypal"         {{ old('method', $payment->method ?? '') === 'paypal'        ? 'selected' : '' }}>PayPal</option>
                    <option value="stripe"         {{ old('method', $payment->method ?? '') === 'stripe'        ? 'selected' : '' }}>Stripe</option>
                    <option value="wise"           {{ old('method', $payment->method ?? '') === 'wise'          ? 'selected' : '' }}>Wise</option>
                    <option value="crypto"         {{ old('method', $payment->method ?? '') === 'crypto'        ? 'selected' : '' }}>Crypto</option>
                    <option value="other"          {{ old('method', $payment->method ?? '') === 'other'         ? 'selected' : '' }}>Autre</option>
                </select>
            </div>
            <div>
                <label class="admin-label">Échéance <span class="text-[10px] font-normal text-[var(--text-tertiary)]">(optionnel)</span></label>
                <input type="date" name="due_date" class="admin-input" value="{{ old('due_date', isset($payment) && $payment->due_date ? $payment->due_date->format('Y-m-d') : '') }}" />
            </div>
        </div>

        {{-- Method custom --}}
        <div id="methodCustomWrap" style="display:none">
            <label class="admin-label">Précisez la méthode <span class="text-[#00AEEF]">*</span></label>
            <input type="text" name="method_custom" id="methodCustomInput" class="admin-input"
                   value="{{ old('method_custom', $payment->method_custom ?? '') }}"
                   placeholder="Ex: Western Union, Virement Maroc..." />
        </div>

        {{-- Invoice / Reference --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="admin-label">N° Facture <span class="text-[10px] font-normal text-[var(--text-tertiary)]">(auto si vide)</span></label>
                <input type="text" name="invoice_number" class="admin-input" value="{{ old('invoice_number', $payment->invoice_number ?? '') }}" placeholder="INV-2026-001" />
            </div>
            <div>
                <label class="admin-label">Réf. transaction <span class="text-[10px] font-normal text-[var(--text-tertiary)]">(optionnel)</span></label>
                <input type="text" name="reference" class="admin-input" value="{{ old('reference', $payment->reference ?? '') }}" placeholder="TXN-..." />
            </div>
        </div>

        {{-- Notes --}}
        <div>
            <label class="admin-label">Notes <span class="text-[10px] font-normal text-[var(--text-tertiary)]">(optionnel)</span></label>
            <textarea name="notes" class="admin-input" rows="2" placeholder="Notes sur ce paiement...">{{ old('notes', $payment->notes ?? '') }}</textarea>
        </div>
    </div>
</div>

<div class="flex items-center justify-end gap-3 mt-6">
    <a href="{{ route('admin.payments.index') }}" class="admin-btn admin-btn-secondary">Annuler</a>
    <button type="submit" class="admin-btn admin-btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
            <polyline points="17 21 17 13 7 13 7 21"></polyline>
            <polyline points="7 3 7 8 15 8"></polyline>
        </svg>
        {{ $isEdit ? 'Mettre à jour' : 'Enregistrer' }}
    </button>
</div>

<script>
@php
$projectDataMap = $projects->keyBy('id')->map(function($p) {
    return [
        'agreed_price'     => (float) ($p->agreed_price ?? 0),
        'billing_type'     => $p->billing_type ?? 'one_time',
        'recurring_period' => $p->recurring_period,
    ];
});
@endphp
const projectData = @json($projectDataMap);

function selectRadioCard(clickedLabel, radioName, activeClass) {
    document.querySelectorAll('[name="' + radioName + '"]').forEach(function(input) {
        const card = input.closest('label')?.querySelector('.radio-card');
        if (card) card.classList.remove('selected-blue', 'selected-green', 'selected-amber');
    });
    const card = clickedLabel?.querySelector('.radio-card');
    if (card) card.classList.add(activeClass);
}

function fillAmountFromProject(projectId) {
    const data = projectId ? projectData[projectId] : null;

    if (data) {
        const amountInput = document.getElementById('pmtAmount');
        if (!amountInput.value || amountInput.dataset.autoFilled === '1') {
            amountInput.value = data.agreed_price.toFixed(2);
            amountInput.dataset.autoFilled = '1';
            calcReste();
        }
    }

    const periodBlock = document.getElementById('periodBlock');
    if (data && data.billing_type === 'recurring' && data.recurring_period) {
        periodBlock.style.display = 'block';
        document.getElementById('billingPeriodFinal').value = '';
        showPeriodPicker(data.recurring_period);
        setTypeCard('mensualite');
    } else {
        periodBlock.style.display = 'none';
        document.getElementById('billingPeriodFinal').value = '';
    }
}

function showPeriodPicker(recurringPeriod) {
    document.getElementById('periodMonthlyWrap').style.display   = 'none';
    document.getElementById('periodQuarterlyWrap').style.display = 'none';
    document.getElementById('periodAnnuallyWrap').style.display  = 'none';
    const now   = new Date();
    const final = document.getElementById('billingPeriodFinal');

    if (recurringPeriod === 'monthly') {
        document.getElementById('periodMonthlyWrap').style.display = 'block';
        const el  = document.getElementById('periodMonthInput');
        const val = final.value;
        if (val && /^\d{4}-\d{2}$/.test(val)) {
            el.value = val;
        } else {
            const y = now.getFullYear();
            const m = String(now.getMonth() + 1).padStart(2, '0');
            el.value    = y + '-' + m;
            final.value = el.value;
        }
    } else if (recurringPeriod === 'quarterly') {
        document.getElementById('periodQuarterlyWrap').style.display = 'block';
        const val = final.value;
        if (val && /^\d{4}-Q\d$/.test(val)) {
            const parts = val.split('-');
            document.getElementById('periodQtrYear').value = parts[0];
            document.getElementById('periodQtr').value     = parts[1];
        } else {
            const q = Math.ceil((now.getMonth() + 1) / 3);
            document.getElementById('periodQtr').value     = 'Q' + q;
            document.getElementById('periodQtrYear').value = now.getFullYear();
            syncQtr();
        }
    } else if (recurringPeriod === 'annually') {
        document.getElementById('periodAnnuallyWrap').style.display = 'block';
        const el  = document.getElementById('periodYearInput');
        const val = final.value;
        el.value    = (val && /^\d{4}$/.test(val)) ? val : now.getFullYear();
        final.value = String(el.value);
    }
}

function syncQtr() {
    const q = document.getElementById('periodQtr').value;
    const y = document.getElementById('periodQtrYear').value;
    document.getElementById('billingPeriodFinal').value = y + '-' + q;
}

function setTypeCard(val) {
    document.querySelectorAll('[name="type"]').forEach(function(input) {
        const card = input.closest('label')?.querySelector('.radio-card');
        if (card) card.classList.remove('selected-blue', 'selected-green', 'selected-amber');
    });
    const target = document.querySelector('[name="type"][value="' + val + '"]');
    if (target) {
        target.checked = true;
        const card = target.closest('label')?.querySelector('.radio-card');
        if (card) card.classList.add('selected-blue');
    }
}

function handleModeChange(mode) {
    const block = document.getElementById('partialBlock');
    const inp   = document.getElementById('partialAmount');
    if (mode === 'partial') {
        block.style.display = 'block';
        inp.required = true;
    } else {
        block.style.display = 'none';
        inp.required = false;
    }
    calcReste();
}

function calcReste() {
    const total     = parseFloat(document.getElementById('pmtAmount').value) || 0;
    const given     = parseFloat(document.getElementById('partialAmount')?.value) || 0;
    const reste     = total - given;
    const display   = document.getElementById('resteDisplay');
    const warning   = document.getElementById('resteWarning');
    const paidInfo  = document.getElementById('restePaidInfo');

    if (!display) return;

    if (given > total) {
        display.textContent = '0.00';
        display.className   = 'font-bold text-[#22C55E]';
        warning.classList.remove('hidden');
        paidInfo.classList.add('hidden');
    } else if (given > 0 && given === total) {
        display.textContent = '0.00';
        display.className   = 'font-bold text-[#22C55E]';
        warning.classList.add('hidden');
        paidInfo.classList.remove('hidden');
    } else {
        display.textContent = reste.toFixed(2);
        display.className   = reste > 0 ? 'font-bold text-[#EF4444]' : 'font-bold text-[#22C55E]';
        warning.classList.add('hidden');
        paidInfo.classList.add('hidden');
    }
}

function toggleMethodCustom(val) {
    const wrap = document.getElementById('methodCustomWrap');
    const inp  = document.getElementById('methodCustomInput');
    wrap.style.display = val === 'other' ? 'block' : 'none';
    inp.required = val === 'other';
}

document.addEventListener('DOMContentLoaded', function () {
    const mode = document.querySelector('[name="payment_mode"]:checked')?.value || 'full';
    handleModeChange(mode);
    toggleMethodCustom(document.getElementById('paymentMethod').value);

    // On create: auto-fill amount if a project is pre-selected and amount is empty
    const sel = document.getElementById('projectSelect');
    const amt = document.getElementById('pmtAmount');
    if (sel?.value && !amt?.value) {
        fillAmountFromProject(sel.value);
    }

    // On edit: restore period block if project is recurring
    if (sel?.value) {
        const data = projectData[sel.value];
        if (data && data.billing_type === 'recurring' && data.recurring_period) {
            document.getElementById('periodBlock').style.display = 'block';
            showPeriodPicker(data.recurring_period);
        }
    }
});
</script>
