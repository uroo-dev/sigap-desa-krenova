@php
    $initialAlerts = [];
    foreach (['success', 'error', 'warning', 'info'] as $type) {
        if (session()->has($type)) {
            $initialAlerts[] = [
                'id' => uniqid('alert_', true),
                'type' => $type,
                'message' => (string) session($type),
            ];
        }
    }
@endphp

<div
    x-data="{
        alerts: @js($initialAlerts),
        add(type, message) {
            const id = 'lw_' + Date.now() + '_' + Math.random().toString(36).slice(2, 7);
            this.alerts.push({ id, type, message });
            this.$nextTick(() => window.lucide && window.lucide.createIcons());
            setTimeout(() => this.dismiss(id), 5000);
        },
        dismiss(id) {
            this.alerts = this.alerts.filter((a) => a.id !== id);
        }
    }"
    x-init="
        alerts.forEach((a) => setTimeout(() => dismiss(a.id), 6000));
        $nextTick(() => window.lucide && window.lucide.createIcons());
    "
    x-on:sigap-toast.window="add($event.detail.type || 'info', $event.detail.message || '')"
    class="space-y-3"
>
    {{-- Daftar Alert Success / Error / Warning / Info --}}
    <template x-for="alert in alerts" :key="alert.id">
        <div
            role="alert"
            :class="{
                'border-green-200 bg-green-50 text-[#16A34A]': alert.type === 'success',
                'border-red-200 bg-red-50 text-[#DC2626]': alert.type === 'error',
                'border-amber-200 bg-amber-50 text-[#D97706]': alert.type === 'warning',
                'border-blue-200 bg-blue-50 text-[#2563EB]': alert.type === 'info'
            }"
            class="mb-4 flex items-start gap-3 rounded-xl border px-4 py-3 text-sm"
        >
            <span class="shrink-0 mt-0.5">
                <template x-if="alert.type === 'success'"><i data-lucide="check-circle-2" class="w-5 h-5"></i></template>
                <template x-if="alert.type === 'error'"><i data-lucide="alert-circle" class="w-5 h-5"></i></template>
                <template x-if="alert.type === 'warning'"><i data-lucide="alert-triangle" class="w-5 h-5"></i></template>
                <template x-if="alert.type === 'info'"><i data-lucide="info" class="w-5 h-5"></i></template>
            </span>
            <div class="flex-1 font-medium" x-text="alert.message"></div>
            <button
                type="button"
                @click="dismiss(alert.id)"
                class="shrink-0 opacity-70 hover:opacity-100"
                aria-label="Tutup pemberitahuan"
            >
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
    </template>

    {{-- Validasi Error Form Tradisional --}}
    @if ($errors->any())
        <div role="alert" class="mb-5 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-[#DC2626]">
            <i data-lucide="alert-triangle" class="w-5 h-5 shrink-0 mt-0.5"></i>
            <div class="flex-1">
                <p class="font-semibold">Terdapat kesalahan pada data yang dikirim:</p>
                <ul class="mt-1 list-disc list-inside space-y-0.5 text-xs">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
</div>
