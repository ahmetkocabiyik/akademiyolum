<div class="flex h-[calc(100dvh-6.5rem)] flex-col"
    x-data
    x-on:sohbet-kaydir.window="$nextTick(() => { const el = $refs.akis; if (el) el.scrollTo({ top: el.scrollHeight, behavior: 'smooth' }); })">

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
            @if ($this->mesajlar->isNotEmpty())
                <flux:button wire:click="sohbetiTemizle" wire:confirm="Sohbet geçmişi silinsin mi?" size="sm" variant="subtle" icon="trash">
                    Temizle
                </flux:button>
            @endif
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
</div>
