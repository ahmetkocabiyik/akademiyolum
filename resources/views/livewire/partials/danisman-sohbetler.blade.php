{{-- Sohbet listesi — masaüstü panel ve mobil çekmecede ortak kullanılır. --}}
<div class="flex-1 space-y-1 overflow-y-auto p-2">
    @forelse ($this->sohbetler as $sohbet)
        <div wire:key="sohbet-{{ $sohbet->id }}"
            class="group flex items-center gap-1 rounded-lg px-2.5 py-2 text-sm transition {{ $sohbet->id === $aktifSohbetId ? 'bg-brand/10 text-brand' : 'text-ink-muted hover:bg-surface' }}">
            <button type="button" wire:click="sohbetSec({{ $sohbet->id }})" class="flex min-w-0 flex-1 items-center gap-2 text-start">
                <flux:icon name="chat-bubble-left-right" class="size-4 shrink-0 opacity-70" />
                <span class="truncate">{{ $sohbet->baslikMetni() }}</span>
            </button>
            <button type="button" wire:click="sohbetiSil({{ $sohbet->id }})"
                wire:confirm="Bu sohbet silinsin mi?"
                class="shrink-0 rounded p-1 text-ink-subtle opacity-0 transition hover:text-cat-red group-hover:opacity-100 max-lg:opacity-100"
                aria-label="Sohbeti sil">
                <flux:icon name="trash" class="size-4" />
            </button>
        </div>
    @empty
        <div class="px-3 py-6 text-center text-xs text-ink-subtle">
            Henüz sohbet yok.<br>Bir soru sorarak başlayın.
        </div>
    @endforelse
</div>
