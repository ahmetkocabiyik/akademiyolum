@props(['cv'])

@use('App\Services\Cv\CvDuzeni')

{{--
    YÖK EK-4A ÖZGEÇMİŞ — atama başvurusunda istenen resmî format.

    Başlıklar, numaraları ve sırası formdakiyle birebir; renk, yazı tipi ve
    bölüm seçimi uygulanmıyor (CvSablonu::resmi). İçerik tasarımlı
    şablonlarla aynı veriden: künye bilgileri CV'den, yayınlar ve görevler
    faaliyetlerden (dağıtım: App\Services\Cv\CvDuzeni::ek4a). Boş başlık da
    basılıyor; formda her başlık yer alıyor.
--}}
@php
    $ek = $cv['ek4a'];

    // Öğrenim tablosu formdaki sırayla: Lisans, Yüksek Lisans, Doktora, sonra diğerleri.
    $derecSirasi = function (array $e): int {
        $d = mb_strtolower((string) ($e['derece'] ?? ''), 'UTF-8');

        return match (true) {
            str_contains($d, 'doktora') || str_contains($d, 'yeterlik') => 2,
            str_contains($d, 'yüksek') => 1,
            str_contains($d, 'lisans') => 0,
            default => 3,
        };
    };
    $ogrenim = collect($cv['egitimler'])
        ->filter(fn (array $e) => filled($e['derece'] ?? null) || filled($e['universite'] ?? null))
        ->sortBy($derecSirasi)->values();

    $unvanlar = collect($cv['akademikUnvanlar'] ?? [])->filter(fn (array $u) => filled($u['unvan']));
    $uyelikler = collect($cv['uyelikler'] ?? [])->filter(fn (array $u) => filled($u['kurulus']));
    $dogum = filled($cv['dogumTarihi'] ?? null) ? \Illuminate\Support\Carbon::parse($cv['dogumTarihi'])->format('d.m.Y') : '';
@endphp

<div id="cv-sayfa" class="cv-sayfa cv-ek4a" data-ek4a>
    <div class="ek4a-ek">EK - 4A</div>
    <div class="ek4a-baslik">ÖZGEÇMİŞ</div>

    <table class="ek4a-kunye">
        <tr><th>1. Adı Soyadı</th><td>: {{ $cv['ad'] }}</td></tr>
        <tr><th colspan="2" class="ek4a-alt-baslik">İletişim Bilgileri</th></tr>
        <tr><th>Adres</th><td>: {{ $cv['sehir'] }}</td></tr>
        <tr><th>Telefon</th><td>: {{ $cv['telefon'] }}</td></tr>
        <tr><th>Mail</th><td>: {{ $cv['eposta'] }}</td></tr>
        <tr><th>2. Doğum Tarihi</th><td>: {{ $dogum }}</td></tr>
        <tr><th>3. Unvanı</th><td>: {{ $cv['unvan'] }}</td></tr>
    </table>

    <div class="ek4a-madde">4. Öğrenim Durumu</div>
    <table class="ek4a-tablo">
        <thead><tr><th>Derece</th><th>Alan</th><th>Üniversite</th><th>Yıl</th></tr></thead>
        <tbody>
            @forelse ($ogrenim as $e)
                <tr>
                    <td>{{ $e['derece'] }}</td>
                    <td>{{ $e['bolum'] }}</td>
                    <td>{{ $e['universite'] }}</td>
                    <td>{{ $e['bitis'] }}</td>
                </tr>
            @empty
                @foreach (['Lisans', 'Yüksek Lisans', 'Doktora'] as $derece)
                    <tr><td>{{ $derece }}</td><td></td><td></td><td></td></tr>
                @endforeach
            @endforelse
        </tbody>
    </table>

    <div class="ek4a-madde">5. Akademik Unvanlar</div>
    @if ($unvanlar->isNotEmpty())
        <table class="ek4a-kunye">
            @foreach ($unvanlar as $u)
                <tr>
                    {{-- Formdaki gibi "Doçentlik Tarihi", "Profesörlük Tarihi". --}}
                    <th>{{ ['Doçent' => 'Doçentlik', 'Profesör' => 'Profesörlük', 'Yardımcı Doçent' => 'Yardımcı Doçentlik'][$u['unvan']] ?? $u['unvan'] }} Tarihi</th>
                    <td>: {{ collect([$u['yil'], collect([$u['kurum'], $u['alan']])->filter()->implode(', ')])->filter()->implode(' — ') }}</td>
                </tr>
            @endforeach
        </table>
    @endif

    <div class="ek4a-madde">6. Yönetilen Yüksek Lisans ve Doktora Tezleri</div>
    <div class="ek4a-alt-madde">6.1. Yüksek Lisans Tezleri</div>
    <x-cv.ek4a-liste :kayitlar="$ek['tezler']['yuksek_lisans']" />
    <div class="ek4a-alt-madde">6.2. Doktora Tezleri</div>
    <x-cv.ek4a-liste :kayitlar="$ek['tezler']['doktora']" />

    <div class="ek4a-madde">7. Yayınlar</div>
    @foreach (CvDuzeni::yayinBasliklari() as $no => $baslik)
        <div class="ek4a-alt-madde">{{ $no }}. {{ $baslik }}</div>
        <x-cv.ek4a-liste :kayitlar="$ek['yayinlar'][$no]" />
    @endforeach

    <div class="ek4a-madde">8. Projeler</div>
    <x-cv.ek4a-liste :kayitlar="$ek['projeler']" />

    <div class="ek4a-madde">9. İdari Görevler</div>
    <x-cv.ek4a-liste :kayitlar="$ek['idari']" />

    <div class="ek4a-madde">10. Bilimsel Kuruluşlara Üyelikleri</div>
    <x-cv.ek4a-liste :kayitlar="$uyelikler->map(fn (array $u) => collect([$u['kurulus'], $u['gorev'], $u['yil']])->filter()->implode(', '))->values()->all()" />

    <div class="ek4a-madde">11. Ödüller</div>
    <x-cv.ek4a-liste :kayitlar="$ek['oduller']" />

    <div class="ek4a-madde">12. Son iki yılda verdiği lisans ve lisansüstü düzeyindeki dersler</div>
    <table class="ek4a-tablo ek4a-dersler">
        <thead>
            <tr>
                <th rowspan="2">Akademik Yıl</th>
                <th rowspan="2">Dönem</th>
                <th rowspan="2">Dersin Adı</th>
                <th colspan="2">Haftalık Saati</th>
                <th rowspan="2">Öğrenci Sayısı</th>
            </tr>
            <tr><th>Teorik</th><th>Uygulama</th></tr>
        </thead>
        <tbody>
            @forelse ($ek['dersler'] as $ders)
                <tr>
                    <td>{{ $ders['akademik_yil'] }}</td>
                    <td>{{ $ders['donem'] }}</td>
                    <td class="ek4a-sol">{{ $ders['ad'] }}{{ $ders['lisansustu'] ? ' *' : '' }}</td>
                    <td>{{ $ders['teorik'] }}</td>
                    <td>{{ $ders['uygulama'] }}</td>
                    <td>{{ $ders['ogrenci'] }}</td>
                </tr>
            @empty
                <tr><td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="ek4a-dipnot">* İşaretli dersler, yüksek lisans dersleridir.</div>
</div>
