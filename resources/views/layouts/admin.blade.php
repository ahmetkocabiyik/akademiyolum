{{-- Yönetim paneli şablonu: uygulamayla aynı kenar çubuğu, yönetim menüsüyle. --}}
<x-layouts::app.sidebar :title="$title ?? null" :yonetim="true">
    <flux:main>
        {{ $slot }}
    </flux:main>
</x-layouts::app.sidebar>
