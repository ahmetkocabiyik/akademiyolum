@props(['icerik'])

{{--
    Rapor adımının gövdesi. İçerik YZ'den geldiği için HTML'i STRIP ediliyor:
    model bir <script> ya da onclick üretirse sayfaya girmemeli.

    Markdown tablosu CommonMark'tan düz <table> olarak çıkıyor; sarmalayıcıyı
    burada ekliyoruz, çünkü sığmayan tablo sayfanın tamamını yatay kaydırıyordu.
--}}
@php
    $html = \Illuminate\Support\Str::markdown($icerik, [
        'html_input' => 'strip',
        'allow_unsafe_links' => false,
    ]);

    $html = str_replace(
        ['<table>', '</table>'],
        ['<div class="juri-tablo"><table>', '</table></div>'],
        $html,
    );
@endphp

<div {{ $attributes->class('juri-icerik') }}>{!! $html !!}</div>
