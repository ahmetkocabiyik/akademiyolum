{{-- "Kullanıcı olarak gör" sürerken HER sayfada: yönetici kimin ekranında
     olduğunu unutup onun adına işlem yapmasın. --}}
@if (session()->has(\App\Http\Controllers\TaklitController::OTURUM_ANAHTARI))
    <div class="-mx-6 -mt-6 mb-6 flex flex-wrap items-center justify-between gap-3 bg-cat-amber px-6 py-2.5 text-sm font-medium text-white lg:-mx-8 lg:-mt-8 lg:mb-8 lg:px-8" data-taklit-seridi>
        <span class="flex items-center gap-2">
            <flux:icon name="eye" class="size-4" />
            <strong>{{ auth()->user()->name }}</strong> ({{ auth()->user()->email }}) olarak görüntülüyorsunuz.
        </span>
        <form method="POST" action="{{ route('taklit.bitir') }}">
            @csrf
            <button type="submit" class="rounded-lg bg-white/20 px-3 py-1 text-sm font-semibold transition hover:bg-white/30">Yönetime dön</button>
        </form>
    </div>
@endif
