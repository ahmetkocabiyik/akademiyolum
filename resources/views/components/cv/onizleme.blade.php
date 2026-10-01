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
    $iletisim = collect([$cv['eposta'], $cv['telefon'], $cv['sehir'], $cv['web']])->filter()->all();

    // Sol sütunun İÇERİĞİ varsa iki sütun. Beceri ve dil girilmemişken (ya da
    // ikisi de kapatılmışken) iki sütun basmak sayfanın solunda avuç içi
    // genişliğinde boş bir şerit bırakıyordu.
    $solSutun = ($acik(CvBolumu::Beceriler) && $cv['beceriler'] !== [])
        || ($acik(CvBolumu::Diller) && $cv['diller'] !== []);
@endphp

<div id="cv-sayfa" class="cv-sayfa cv-{{ $cv['sablon']->value }}"
    style="--cv-renk: {{ $cv['renk'] }}; --cv-font: {{ $cv['yaziTipi']->yigin() }}">

    <div class="cv-ust">
        @if ($acik(CvBolumu::Foto))
            <div class="cv-foto">{{ $cv['basHarfler'] }}</div>
        @endif
        <div class="min-w-0 flex-1">
            <div class="cv-ad">{{ $cv['ad'] ?: 'Adınız' }}</div>
            <div class="cv-unvan">
                {{ collect([$cv['unvan'], $cv['kurum'], $cv['bolum']])->filter()->implode(' · ') ?: 'Unvan · Kurum · Bölüm' }}
            </div>
            @if ($iletisim !== [])
                <div class="cv-iletisim">
                    @foreach ($iletisim as $parca)
                        <span>{{ $parca }}</span>
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

            {{-- Faaliyetler kategorisine göre ayrı başlıklar altında: düz bir
                 "Yayınlar" listesi derslerle ödülleri de yayın gibi gösteriyordu. --}}
            @if ($acik(CvBolumu::Yayinlar))
                @foreach ($cv['gruplu'] as $kategori => $kayitlar)
                    <div>
                        <div class="cv-baslik">{{ $kategori }}</div>
                        @foreach ($kayitlar as $kayit)
                            <div class="cv-satir">
                                <div class="cv-satir-baslik">
                                    {{ $kayit->baslik }}
                                    @if ($kayit->kaynak)
                                        <span class="cv-rozet">{{ $kayit->kaynak }}</span>
                                    @endif
                                </div>
                                <div class="cv-satir-alt">
                                    {{ collect([
                                        $kayit->yazarlar,
                                        $kayit->tur,
                                        $kayit->tarih?->format('Y'),
                                    ])->filter()->implode(' · ') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <div class="cv-alt">
        <span>Akademiyolum ile oluşturuldu</span>
        <span>{{ now()->translatedFormat('F Y') }}</span>
    </div>
</div>
