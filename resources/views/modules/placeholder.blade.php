<x-layouts::app :title="$heading">
    <x-topbar :title="$heading" />

    <div class="flex flex-col gap-6">
        @if (! empty($subheading))
            <flux:text>{{ $subheading }}</flux:text>
        @endif

        <flux:card class="flex flex-col items-center justify-center gap-3 py-16 text-center">
            <div class="flex size-12 items-center justify-center rounded-xl bg-brand-light text-brand">
                <flux:icon name="wrench-screwdriver" class="size-6" />
            </div>
            <flux:heading size="lg">Bu modül yakında</flux:heading>
            <flux:text class="max-w-md">
                {{ $heading }} modülü <strong>{{ $phase }}</strong> kapsamında geliştirilecek.
                Şu an tasarım sistemi ve navigasyon iskeleti hazırlanıyor.
            </flux:text>
            <flux:badge color="amber" size="sm">{{ $phase }}</flux:badge>
        </flux:card>
    </div>
</x-layouts::app>
