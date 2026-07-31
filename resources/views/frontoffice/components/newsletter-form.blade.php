<div class="newsletter-form-wrapper" id="newsletter-wrap-{{ $id ?? 'default' }}">
    <div id="newsletter-success-{{ $id ?? 'default' }}" class="hidden text-center py-4">
        <div class="text-green-600 font-semibold text-sm">✓ Merci pour votre inscription !</div>
        <p class="text-xs text-gray-500 mt-1">Vous recevrez nos prochains articles et actualités.</p>
    </div>
    <form id="newsletter-form-{{ $id ?? 'default' }}" class="flex flex-col sm:flex-row gap-3" onsubmit="submitNewsletter(event, '{{ $id ?? 'default' }}')">
        @csrf
        <input type="hidden" name="source" value="{{ $source ?? 'website' }}" />
        <input type="email" name="email" placeholder="{{ $placeholder ?? 'Votre adresse email' }}" required
            class="flex-1 px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#00AEEF]/30 focus:border-[#00AEEF] bg-white {{ $inputClass ?? '' }}" />
        <button type="submit" class="px-6 py-3 bg-[#00AEEF] text-white rounded-xl text-sm font-semibold hover:bg-[#0099d4] transition-colors whitespace-nowrap {{ $btnClass ?? '' }}">
            {{ $btnText ?? "S'inscrire" }}
        </button>
    </form>
</div>
<script>
function submitNewsletter(e, formId) {
    e.preventDefault();
    const form = document.getElementById('newsletter-form-' + formId);
    const success = document.getElementById('newsletter-success-' + formId);
    const btn = form.querySelector('button[type="submit"]');
    const originalBtnText = btn.textContent;
    btn.disabled = true; btn.textContent = '...';
    const data = new FormData(form);
    fetch('{{ route("newsletter.subscribe") }}', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' },
        body: data
    }).then(r => r.json()).then(res => {
        if (res.success && res.already) {
            toastr.info('Cette adresse est déjà inscrite à la newsletter.', 'Déjà inscrit');
            btn.disabled = false; btn.textContent = originalBtnText;
        } else if (res.success) {
            form.classList.add('hidden');
            success.classList.remove('hidden');
            toastr.success('Vous recevrez nos prochains articles et actualités.', 'Inscription confirmée !');
        } else {
            toastr.error(res.message || 'Une erreur est survenue.', 'Erreur');
            btn.disabled = false; btn.textContent = originalBtnText;
        }
    }).catch(() => {
        toastr.error('Erreur réseau. Veuillez réessayer.', 'Erreur');
        btn.disabled = false; btn.textContent = originalBtnText;
    });
}
</script>
