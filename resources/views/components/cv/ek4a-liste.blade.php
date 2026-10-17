@props(['kayitlar'])

{{-- EK-4A başlığının altındaki numaralı liste; boşsa formdaki gibi yalnız boşluk. --}}
@if ($kayitlar !== [])
    <ol class="ek4a-liste">
        @foreach ($kayitlar as $kayit)
            <li>{{ $kayit }}</li>
        @endforeach
    </ol>
@else
    <div class="ek4a-bos"></div>
@endif
