<div class="flex h-[calc(100dvh-6.5rem)] gap-4"
    x-data="{ panelAcik: false }"
    x-on:sohbet-kaydir.window="panelAcik = false; $nextTick(() => { const el = $refs.akis; if (el) el.scrollTo({ top: el.scrollHeight, behavior: 'smooth' }); })">

    {{-- Sohbet alanı --}}
    <flux:card class="flex flex-1 flex-col overflow-hidden !p-0">

        {{-- Başlık --}}
        <div class="flex items-center justify-between gap-4 border-b border-line px-5 py-4">
            <div class="flex items-center gap-3">
                <div class="flex size-10 items-center justify-center rounded-xl bg-navy text-gold">
                    <flux:icon name="sparkles" variant="solid" class="size-5" />
                </div>
                <div>
                    <flux:heading size="lg">YZ Akademik Danışman</flux:heading>
                    <div class="mt-0.5 flex items-center gap-1.5 text-xs text-ink-subtle">
                        <span class="size-1.5 rounded-full bg-cat-green"></span>
                        {{ auth()->user()->yonerge ?? 'Yönerge seçili değil' }}
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <flux:button wire:click="yeniSohbet" size="sm" variant="subtle" icon="plus-circle">
                    Yeni sohbet
                </flux:button>
                {{-- Mobilde sohbet listesini açar --}}
                <flux:button x-on:click="panelAcik = true" size="sm" variant="subtle" icon="chat-bubble-left-right" class="lg:hidden" aria-label="Sohbetler" />
            </div>
        </div>

        {{-- Mesaj akışı --}}
        <div x-ref="akis" class="flex-1 space-y-4 overflow-y-auto px-5 py-5">
            @forelse ($this->mesajlar as $m)
                @if ($m->rol === 'user')
                    <div class="flex justify-end">
                        <div class="max-w-[80%] rounded-2xl rounded-br-sm bg-brand px-4 py-2.5 text-sm text-white">
                            {{ $m->icerik }}
                        </div>
                    </div>
                @else
                    <div class="flex gap-3">
                        <div class="flex size-8 shrink-0 items-center justify-center rounded-lg bg-navy text-gold">
                            <flux:icon name="sparkles" variant="solid" class="size-4" />
                        </div>
                        <div class="mesaj-icerik max-w-[80%] rounded-2xl rounded-tl-sm border border-line bg-surface px-4 py-3 text-sm text-ink">
                            {!! \Illuminate\Support\Str::markdown($m->icerik) !!}
                        </div>
                    </div>
                @endif
            @empty
                <div class="flex h-full flex-col items-center justify-center gap-3 text-center">
                    <div class="flex size-14 items-center justify-center rounded-2xl bg-navy text-gold">
                        <flux:icon name="sparkles" variant="solid" class="size-7" />
                    </div>
                    <flux:heading size="lg">Size nasıl yardımcı olabilirim?</flux:heading>
                    <flux:text class="max-w-md">
                        Profilinize ve puan durumunuza göre kişiselleştirilmiş öneriler sunarım.
                        Aşağıdaki sorulardan biriyle başlayabilirsiniz.
                    </flux:text>
                    <div class="mt-2 flex flex-wrap justify-center gap-2">
                        @foreach ($oneriler as $oneri)
                            <button type="button" wire:click="oneriGonder(@js($oneri))"
                                class="rounded-full border border-line px-3.5 py-1.5 text-xs font-medium text-ink-muted transition hover:border-brand hover:text-brand">
                                {{ $oneri }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @endforelse

            {{-- Yazıyor göstergesi --}}
            @if ($bekleniyor)
                <div class="flex gap-3" wire:key="yaziyor">
                    <div class="flex size-8 shrink-0 items-center justify-center rounded-lg bg-navy text-gold">
                        <flux:icon name="sparkles" variant="solid" class="size-4" />
                    </div>
                    <div class="flex items-center gap-1 rounded-2xl rounded-tl-sm border border-line bg-surface px-4 py-3">
                        <span class="size-1.5 animate-bounce rounded-full bg-ink-subtle [animation-delay:-0.3s]"></span>
                        <span class="size-1.5 animate-bounce rounded-full bg-ink-subtle [animation-delay:-0.15s]"></span>
                        <span class="size-1.5 animate-bounce rounded-full bg-ink-subtle"></span>
                    </div>
                </div>
            @endif
        </div>

        {{-- Giriş --}}
        <div class="border-t border-line p-4">
            @if ($hata)
                <div class="mb-2 flex items-start gap-2 rounded-xl border px-3.5 py-2.5 text-sm"
                    style="border-color: color-mix(in srgb, var(--color-cat-red) 35%, transparent); background: var(--color-cat-red-light); color: var(--color-cat-red);">
                    <flux:icon name="exclamation-triangle" class="mt-0.5 size-4 shrink-0" />
                    <span>{{ $hata }}</span>
                </div>
            @endif
            @if ($this->mesajlar->isNotEmpty())
                <div class="mb-2 flex flex-wrap gap-1.5">
                    @foreach ($oneriler as $oneri)
                        <button type="button" wire:click="oneriGonder(@js($oneri))" @disabled($bekleniyor)
                            class="rounded-full border border-line px-3 py-1 text-[11px] font-medium text-ink-subtle transition hover:border-brand hover:text-brand disabled:opacity-50">
                            {{ $oneri }}
                        </button>
                    @endforeach
                </div>
            @endif
            <form wire:submit="gonder" class="flex items-end gap-2">
                <flux:input wire:model="mesaj" placeholder="Danışmanınıza bir soru sorun..." class="flex-1" :disabled="$bekleniyor" autocomplete="off" />
                <flux:button type="submit" variant="primary" icon="paper-airplane" :disabled="$bekleniyor" aria-label="Gönder" />
            </form>
        </div>
    </flux:card>

    {{-- Sohbet geçmişi — masaüstü panel --}}
    <flux:card class="hidden w-80 shrink-0 flex-col overflow-hidden !p-0 lg:flex">
        <div class="flex items-center justify-between gap-2 border-b border-line px-4 py-4">
            <flux:heading size="sm">Sohbetler</flux:heading>
            <flux:button wire:click="yeniSohbet" size="xs" variant="subtle" icon="plus" aria-label="Yeni sohbet" />
        </div>

        @include('livewire.partials.danisman-sohbetler')
    </flux:card>

    {{-- Sohbet geçmişi — mobil çekmece --}}
    <div x-cloak x-show="panelAcik" class="fixed inset-0 z-50 lg:hidden" x-on:keydown.escape.window="panelAcik = false">
        <div class="absolute inset-0 bg-black/40" x-show="panelAcik" x-transition.opacity x-on:click="panelAcik = false"></div>
        <div class="absolute inset-y-0 end-0 flex w-80 max-w-[85%] flex-col bg-surface shadow-xl"
            x-show="panelAcik"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full">
            <div class="flex items-center justify-between gap-2 border-b border-line px-4 py-4">
                <flux:heading size="sm">Sohbetler</flux:heading>
                <div class="flex items-center gap-1">
                    <flux:button wire:click="yeniSohbet" x-on:click="panelAcik = false" size="xs" variant="subtle" icon="plus" aria-label="Yeni sohbet" />
                    <flux:button x-on:click="panelAcik = false" size="xs" variant="subtle" icon="x-mark" aria-label="Kapat" />
                </div>
            </div>

            @include('livewire.partials.danisman-sohbetler')
        </div>
    </div>
</div>
