<x-layouts::app.sidebar :title="$title ?? null">
    <flux:main>
        @include('partials.taklit-seridi')

        {{ $slot }}
    </flux:main>
</x-layouts::app.sidebar>
