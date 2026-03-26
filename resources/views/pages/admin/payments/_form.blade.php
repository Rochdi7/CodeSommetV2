@php $isEdit = isset($payment); @endphp

<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="text-sm font-semibold">{{ $isEdit ? 'Modifier le paiement' : 'Nouveau paiement' }}</h3>
    </div>
    <div class="admin-card-body space-y-4">
        <div>
            <label class="admin-label">Projet <span class="text-[#00AEEF]">*</span></label>
            <select name="project_id" class="admin-input" required>
                <option value="">S&eacute;lectionner un projet</option>
                @foreach($projects as $p)
                <option value="{{ $p->id }}" {{ old('project_id', $payment->project_id ?? ($selectedProject ?? '')) == $p->id ? 'selected' : '' }}>{{ $p->name }} ({{ $p->client_name }})</option>
                @endforeach
            </select>
            @error('project_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="admin-label">Montant <span class="text-[#00AEEF]">*</span></label>
                <input type="number" step="0.01" name="amount" class="admin-input" value="{{ old('amount', $payment->amount ?? '') }}" required placeholder="0.00" />
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
            <div>
                <label class="admin-label">Type <span class="text-[#00AEEF]">*</span></label>
                <select name="type" class="admin-input" required>
                    @foreach(['deposit'=>'Acompte','milestone'=>'Jalon','final'=>'Solde final','maintenance'=>'Maintenance','extra'=>'Extra','refund'=>'Remboursement'] as $val => $label)
                    <option value="{{ $val }}" {{ old('type', $payment->type ?? 'milestone') === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="admin-label">M&eacute;thode <span class="text-[#00AEEF]">*</span></label>
                <select name="method" class="admin-input" required>
                    @foreach(['bank_transfer'=>'Virement bancaire','paypal'=>'PayPal','stripe'=>'Stripe','cash'=>'Esp&egrave;ces','wise'=>'Wise','crypto'=>'Crypto','other'=>'Autre'] as $val => $label)
                    <option value="{{ $val }}" {{ old('method', $payment->method ?? 'bank_transfer') === $val ? 'selected' : '' }}>{!! $label !!}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="admin-label">Statut <span class="text-[#00AEEF]">*</span></label>
                <select name="status" class="admin-input" required>
                    @foreach(['pending'=>'En attente','paid'=>'Pay&eacute;','overdue'=>'En retard','cancelled'=>'Annul&eacute;','refunded'=>'Rembours&eacute;'] as $val => $label)
                    <option value="{{ $val }}" {{ old('status', $payment->status ?? 'pending') === $val ? 'selected' : '' }}>{!! $label !!}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="admin-label">&Eacute;ch&eacute;ance</label>
                <input type="date" name="due_date" class="admin-input" value="{{ old('due_date', isset($payment) && $payment->due_date ? $payment->due_date->format('Y-m-d') : '') }}" />
            </div>
            <div>
                <label class="admin-label">Pay&eacute; le</label>
                <input type="date" name="paid_at" class="admin-input" value="{{ old('paid_at', isset($payment) && $payment->paid_at ? $payment->paid_at->format('Y-m-d') : '') }}" />
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="admin-label">N&deg; Facture</label>
                <input type="text" name="invoice_number" class="admin-input" value="{{ old('invoice_number', $payment->invoice_number ?? '') }}" placeholder="INV-2026-001" />
            </div>
            <div>
                <label class="admin-label">R&eacute;f&eacute;rence transaction</label>
                <input type="text" name="reference" class="admin-input" value="{{ old('reference', $payment->reference ?? '') }}" placeholder="TXN-..." />
            </div>
        </div>

        <div>
            <label class="admin-label">Notes</label>
            <textarea name="notes" class="admin-input" rows="3" placeholder="Notes sur ce paiement...">{{ old('notes', $payment->notes ?? '') }}</textarea>
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
        {{ $isEdit ? 'Mettre &agrave; jour' : 'Enregistrer' }}
    </button>
</div>