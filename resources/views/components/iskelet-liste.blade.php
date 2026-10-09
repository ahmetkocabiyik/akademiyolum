@props(['satir' => 4])

{{-- Liste yüklenirken yerinde duran iskelet: onay kutusu, başlık, alt satır. --}}
<div {{ $attributes->class('flex-col overflow-hidden rounded-xl border border-line bg-surface') }} aria-hidden="true">
    @for ($i = 0; $i < $satir; $i++)
        <div class="flex items-start gap-3 border-b border-line px-4 py-3.5 last:border-0">
            <div class="iskelet size-4 shrink-0"></div>
            <div class="flex flex-1 flex-col gap-2">
                <div class="iskelet h-3.5" style="width: {{ [82, 64, 74, 58][$i % 4] }}%"></div>
                <div class="iskelet h-2.5" style="width: {{ [46, 38, 52, 30][$i % 4] }}%"></div>
            </div>
        </div>
    @endfor
</div>
