@props(['cv'])

@use('App\Enums\CvBolumu')
@use('App\Models\CvProfili')

{{--
    CANLI ÖNİZLEME — yazdırılan sayfanın ta kendisi.

    Ayrı bir "PDF şablonu" yok: PDF, tarayıcının bu düğümü yazdırmasıyla
    üretiliyor (@media print, app.css). İki ayrı şablon tutulsaydı biri
    güncellenip öteki geride kalır, aday ekranda gördüğünden başka bir çıktı
    alırdı.
--}}
@php
    $acik = fn (CvBolumu $bolum) => (bool) ($cv['bolumler'][$bolum->value] ?? true);
    // Her parça kendi ikonuyla.
    $iletisim = collect([
        ['ikon' => 'envelope', 'metin' => $cv['eposta']],
        ['ikon' => 'phone', 'metin' => $cv['telefon']],
        ['ikon' => 'map-pin', 'metin' => $cv['sehir']],
        ['ikon' => 'identification', 'metin' => $cv['orcid']],
    ])->filter(fn (array $parca) => filled($parca['metin']))->all();

    // Sol sütunun İÇERİĞİ varsa iki sütun. Beceri ve dil girilmemişken (ya da
    // ikisi de kapatılmışken) iki sütun basmak sayfanın solunda avuç içi
    // genişliğinde boş bir şerit bırakıyordu.
    $solSutun = ($acik(CvBolumu::Beceriler) && $cv['beceriler'] !== [])
        || ($acik(CvBolumu::Diller) && $cv['diller'] !== []);
@endphp

{{-- Çizgi rengi yalnızca kapalı listedeyse yazılıyor: değer doğrudan style'a gidiyor. --}}
@php
    $cizgi = in_array($cv['cizgiRenk'], CvProfili::CIZGI_RENKLERI, true) ? $cv['cizgiRenk'] : CvProfili::VARSAYILAN_CIZGI_RENGI;
@endphp

<div id="cv-sayfa" class="cv-sayfa cv-{{ $cv['sablon']->value }}"
    style="--cv-renk: {{ $cv['renk'] }}; --cv-font: {{ $cv['yaziTipi']->yigin() }}; --cv-baslik-cizgi: {{ $cizgi }};">

    <div class="cv-ust">
        @if ($acik(CvBolumu::Foto))
            @if ($cv['foto'])
                <img src="{{ $cv['foto'] }}" alt="" class="cv-foto cv-foto-gorsel">
            @else
                <div class="cv-foto">{{ $cv['basHarfler'] }}</div>
            @endif
        @endif
        <div class="min-w-0 flex-1">
            <div class="cv-ad">{{ $cv['ad'] ?: 'Adınız' }}</div>
            <div class="cv-unvan">
                {{ collect([$cv['unvan'], $cv['kurum'], $cv['bolum']])->filter()->implode(' · ') ?: 'Unvan · Kurum · Bölüm' }}
            </div>
            @if ($iletisim !== [])
                <div class="cv-iletisim">
                    @foreach ($iletisim as $parca)
                        <span class="cv-iletisim-parca">
                            <flux:icon :name="$parca['ikon']" variant="micro" class="cv-iletisim-ikon" />
                            {{ $parca['metin'] }}
                        </span>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div @class(['cv-govde', 'cv-govde-tek' => ! $solSutun])>
        {{-- Sol sütun: kısa, tarama amaçlı bilgiler --}}
        @if ($solSutun)
        <div class="cv-sutun">
            @if ($acik(CvBolumu::Beceriler) && $cv['beceriler'] !== [])
                <div>
                    <div class="cv-baslik">Uzmanlık</div>
                    @foreach ($cv['beceriler'] as $beceri)
                        <div class="cv-metin">{{ $beceri }}</div>
                    @endforeach
                </div>
            @endif

            @if ($acik(CvBolumu::Diller) && $cv['diller'] !== [])
                <div>
                    <div class="cv-baslik">Diller</div>
                    @foreach ($cv['diller'] as $dil)
                        <div class="cv-cubuk">
                            <div class="cv-cubuk-ad">
                                <span>{{ $dil['ad'] }}</span>
                                <span>{{ CvProfili::DIL_SEVIYELERI[$dil['seviye']] ?? '' }}</span>
                            </div>
                            <div class="cv-cubuk-yol">
                                <div class="cv-cubuk-dolu" style="width: {{ ($dil['seviye'] / 5) * 100 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        @endif

        {{-- Sağ sütun: anlatı --}}
        <div class="cv-sutun">
            @if ($acik(CvBolumu::Ozet) && $cv['ozet'] !== '')
                <div>
                    <div class="cv-baslik">Hakkımda</div>
                    <div class="cv-metin">{{ $cv['ozet'] }}</div>
                </div>
            @endif

            @if ($acik(CvBolumu::Egitim) && $cv['egitimler'] !== [])
                <div>
                    <div class="cv-baslik">Eğitim</div>
                    @foreach ($cv['egitimler'] as $egitim)
                        <div class="cv-satir">
                            <div class="cv-satir-baslik">
                                {{ collect([$egitim['derece'] ?? null, $egitim['universite'] ?? null])->filter()->implode(' — ') ?: 'Derece — Üniversite' }}
                            </div>
                            <div class="cv-satir-alt">
                                {{ collect([
                                    $egitim['bolum'] ?? null,
                                    collect([$egitim['baslangic'] ?? null, $egitim['bitis'] ?? null])->filter()->implode('–'),
                                ])->filter()->implode(' · ') }}
                            </div>
                            @if (filled($egitim['tez_adi'] ?? null))
                                <div class="cv-satir-alt">
                                    {{ collect(['Tez: '.$egitim['tez_adi'], filled($egitim['danisman'] ?? null) ? 'Danışman: '.$egitim['danisman'] : null])->filter()->implode(' · ') }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            @php $unvanlar = collect($cv['akademikUnvanlar'] ?? [])->filter(fn (array $u) => filled($u['unvan'])); @endphp
            @if ($acik(CvBolumu::AkademikUnvanlar) && $unvanlar->isNotEmpty())
                <div>
                    <div class="cv-baslik">Akademik Unvanlar</div>
                    @foreach ($unvanlar as $u)
                        <div class="cv-satir">
                            <div class="cv-satir-baslik">{{ collect([$u['unvan'], $u['alan']])->filter()->implode(' — ') }}</div>
                            <div class="cv-satir-alt">{{ collect([$u['kurum'], $u['yil']])->filter()->implode(' · ') }}</div>
                        </div>
                    @endforeach
                </div>
            @endif

            @if ($acik(CvBolumu::Deneyim) && $cv['deneyimler'] !== [])
                <div>
                    <div class="cv-baslik">Deneyim</div>
                    @foreach ($cv['deneyimler'] as $deneyim)
                        <div class="cv-satir">
                            <div class="cv-satir-baslik">
                                {{ collect([$deneyim['pozisyon'] ?? null, $deneyim['kurum'] ?? null])->filter()->implode(' — ') ?: 'Pozisyon — Kurum' }}
                            </div>
                            <div class="cv-satir-alt">
                                {{ ($deneyim['baslangic'] ?? '') !== ''
                                    ? $deneyim['baslangic'].' – '.(($deneyim['bitis'] ?? '') !== '' ? $deneyim['bitis'] : 'devam ediyor')
                                    : '' }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            @php $uyelikler = collect($cv['uyelikler'] ?? [])->filter(fn (array $u) => filled($u['kurulus'])); @endphp
            @if ($acik(CvBolumu::Uyelikler) && $uyelikler->isNotEmpty())
                <div>
                    <div class="cv-baslik">Bilimsel Kuruluş Üyelikleri</div>
                    @foreach ($uyelikler as $u)
                        <div class="cv-satir">
                            <div class="cv-satir-baslik">{{ $u['kurulus'] }}</div>
                            <div class="cv-satir-alt">{{ collect([$u['gorev'], $u['yil']])->filter()->implode(' · ') }}</div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Faaliyetler YÖKSİS'in bölümlerine ve sırasına göre (App\Services\Cv\CvDuzeni),
                 her kayıt tam künyesiyle (App\Services\Cv\KunyeYazici). --}}
            @if ($acik(CvBolumu::Yayinlar))
                @foreach ($cv['yoksis'] as $bolum)
                    <div>
                        <div class="cv-baslik">{{ $bolum['baslik'] }}</div>
                        <ol class="cv-kunyeler">
                            @foreach ($bolum['kayitlar'] as $kayit)
                                <li class="cv-kunye">
                                    {{ $kayit['kunye'] }}
                                    @if ($kayit['rozet'])
                                        <span class="cv-rozet">{{ $kayit['rozet'] }}</span>
                                    @endif
                                </li>
                            @endforeach
                        </ol>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
