{{-- Panel tıklamayla anında açılır; detay sunucudan gelene kadar bu iskelet
     duruyor. Ölçüleri gerçek içeriğin ölçüleri: panel dolunca zıplamasın. --}}
<div class="flex items-start gap-3 pr-8">
    <div class="size-12 shrink-0 animate-pulse rounded-xl bg-line"></div>
    <div class="flex-1 space-y-2 pt-1">
        <div class="h-4 w-2/3 animate-pulse rounded bg-line"></div>
        <div class="h-3 w-1/2 animate-pulse rounded bg-line"></div>
    </div>
</div>
<div class="h-16 animate-pulse rounded-xl bg-line"></div>
<div class="space-y-2">
    <div class="h-3 w-1/3 animate-pulse rounded bg-line"></div>
    <div class="h-2 animate-pulse rounded-full bg-line"></div>
</div>
<div class="space-y-3">
    @foreach (range(1, 4) as $i)
        <div class="space-y-1.5">
            <div class="h-3 w-1/2 animate-pulse rounded bg-line"></div>
            <div class="h-1 animate-pulse rounded-full bg-line"></div>
        </div>
    @endforeach
</div>
