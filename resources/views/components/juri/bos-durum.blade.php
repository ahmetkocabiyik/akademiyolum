@props(['kurumVar' => true])

<flux:card class="flex flex-col items-center justify-center gap-4 py-20 text-center">
    <div class="flex size-16 items-center justify-center rounded-full border-2 border-cat-purple/15 bg-cat-purple/5">
        <flux:icon name="scale" class="size-8 text-cat-purple" />
    </div>

    <flux:heading size="lg">YZ Jüri Masası Hazır</flux:heading>

    <flux:text class="max-w-md">
        @if ($kurumVar)
            Soldan hedef kurumu ve jüri şapkasını seçin. YZ dosyanızı on adımda —
            niceliksel ve niteliksel olarak — değerlendirip kararını yazacak.
        @else
            Jüri raporu, yönergesi sisteme girilmiş bir kuruma karşı yazılır. Seçili
            kadro ve temel alanınız için henüz böyle bir kurum yok.
        @endif
    </flux:text>
</flux:card>
