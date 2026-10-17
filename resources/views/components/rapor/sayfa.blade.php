@props(['rapor', 'sablon', 'baslik', 'bolumler', 'aralik'])

@use('App\Services\Cikti\RaporDerleyici')
@use('App\Services\Scoring\Sart\Durum')

{{--
    RAPOR SAYFASI — yazdırılan belgenin ta kendisi.

    Ayrı bir PDF şablonu yok: PDF tarayıcının bu düğümü yazdırmasıyla çıkıyor
    (@media print, app.css). Uzun rapor A4'lere tarayıcı tarafından bölünür;
    tablo satırları ve bölüm başlıkları sayfa sonunda ikiye kesilmez.
--}}
@php
    $kullanici = auth()->user();
    $acik = fn (string $bolum) => (bool) ($bolumler[$bolum] ?? false);
    $hedef = $rapor['hedef'];
    $ozet = $rapor['ozet'];
    $puanVar = $hedef !== null;
    $enYuksek = max(1, ...array_map(fn (array $d) => $puanVar ? $d['puan'] : $d['adet'], $rapor['dagilim'] ?: [['puan' => 1, 'adet' => 1]]));

    $durumEtiketi = fn (Durum $durum) => match ($durum) {
        Durum::Saglandi => ['Uygun', 'yesil'],
        Durum::Belirsiz => ['Belirsiz', 'mor'],
        Durum::Saglanmadi => ['Yetersiz', 'kirmizi'],
    };
@endphp

<div id="rapor-sayfa" class="rapor-sayfa rapor-{{ $sablon }}">

    <header class="rapor-ust">
        <div class="rapor-ust-satir">
            <span>{{ RaporDerleyici::ARALIKLAR[$aralik] ?? '' }}</span>
            <span>{{ now()->translatedFormat('j F Y') }}</span>
        </div>
        <h1 class="rapor-baslik">{{ $baslik !== '' ? $baslik : 'Akademik Faaliyet Raporu' }}</h1>
        <div class="rapor-kimlik">
            {{ $kullanici->unvanliAd() }}
            <span>·</span>
            {{ collect([$kullanici->universite, $kullanici->bolum])->filter()->implode(' · ') }}
        </div>
        @if ($hedef !== null)
            <div class="rapor-hedef">Hedef: {{ $hedef['universite'] }} · {{ $hedef['kadro'] }}</div>
        @endif
    </header>

    <div class="rapor-govde">

        {{-- ÖZET --}}
        @if ($acik('ozet'))
            <section class="rapor-bolum">
                <h2 class="rapor-bolum-baslik">Özet</h2>
                <div class="rapor-istatistikler">
                    <div class="rapor-istatistik">
                        <div class="rapor-sayi">{{ $ozet['faaliyet'] }}</div>
                        <div class="rapor-etiket">Onaylı faaliyet</div>
                    </div>
                    <div class="rapor-istatistik">
                        <div class="rapor-sayi">{{ $ozet['toplam'] ?? '—' }}</div>
                        <div class="rapor-etiket">Toplam puan{{ $ozet['baraj'] !== null ? ' / '.$ozet['baraj'] : '' }}</div>
                    </div>
                    <div class="rapor-istatistik">
                        <div class="rapor-sayi">{{ $puanVar ? '%'.$ozet['oran'] : '—' }}</div>
                        <div class="rapor-etiket">Hedefe ilerleme</div>
                    </div>
                    <div class="rapor-istatistik">
                        <div class="rapor-sayi">{{ $ozet['uygunKurum'] }}<small> / {{ $ozet['kurum'] }}</small></div>
                        <div class="rapor-etiket">Uygun olunan kurum</div>
                    </div>
                </div>

                @if ($rapor['dagilim'] !== [])
                    <h3 class="rapor-alt-baslik">Kategori dağılımı</h3>
                    @foreach ($rapor['dagilim'] as $satir)
                        @php $deger = $puanVar ? $satir['puan'] : $satir['adet']; @endphp
                        <div class="rapor-cubuk">
                            <div class="rapor-cubuk-ust">
                                <span>{{ $satir['kategori'] }}</span>
                                <span>{{ $puanVar ? $satir['puan'].' puan · ' : '' }}{{ $satir['adet'] }} kayıt</span>
                            </div>
                            <div class="rapor-cubuk-yol"><div class="rapor-cubuk-dolu" style="width: {{ round($deger / $enYuksek * 100) }}%"></div></div>
                        </div>
                    @endforeach
                    @if ($puanVar)
                        <p class="rapor-dipnot">Kategori puanları {{ $hedef['universite'] }} cetveline göre, bölüm tavanları uygulanmadan; toplam puan tavanlarla hesaplanır.</p>
                    @endif
                @endif
            </section>
        @endif

        {{-- HEDEF ANALİZİ --}}
        @if ($acik('hedef'))
            <section class="rapor-bolum">
                <h2 class="rapor-bolum-baslik">Hedef Analizi</h2>

                @if ($hedef !== null)
                    <div class="rapor-hedef-satir">
                        <span>{{ $hedef['universite'] }} · {{ $hedef['kadro'] }}</span>
                        @if ($ozet['durum'] !== null)
                            @php [$etiket, $renk] = $durumEtiketi($ozet['durum']); @endphp
                            <span class="rapor-etiket-rozet rapor-{{ $renk }}">{{ $etiket }}</span>
                        @endif
                    </div>

                    @foreach ($rapor['kosullar'] as $kosul)
                        @php [$etiket, $renk] = $durumEtiketi($kosul['durum']); @endphp
                        <div class="rapor-cubuk">
                            <div class="rapor-cubuk-ust">
                                <span>{{ $kosul['aciklama'] }}</span>
                                <span>
                                    @if ($kosul['not'] !== null)
                                        {{ $kosul['not'] }} ·
                                    @elseif ($kosul['gerekli'] !== null)
                                        {{ $kosul['mevcut'] ?? 0 }} / {{ $kosul['gerekli'] }} ·
                                    @endif
                                    <span class="rapor-{{ $renk }}-yazi">{{ $etiket }}</span>
                                </span>
                            </div>
                            @if ($kosul['gerekli'] !== null && $kosul['not'] === null)
                                <div class="rapor-cubuk-yol"><div class="rapor-cubuk-dolu rapor-{{ $renk }}" style="width: {{ $kosul['oran'] }}%"></div></div>
                            @endif
                        </div>
                    @endforeach
                @endif

                @if ($rapor['universiteler'] !== [])
                    <h3 class="rapor-alt-baslik">Başvurulabilir üniversiteler</h3>
                    <table class="rapor-tablo">
                        <thead>
                            <tr><th>Üniversite</th><th class="sag">Puan / Baraj</th><th class="sag">Durum</th></tr>
                        </thead>
                        <tbody>
                            @foreach ($rapor['universiteler'] as $universite)
                                @php [$etiket, $renk] = $durumEtiketi($universite['durum']); @endphp
                                <tr>
                                    <td>{{ $universite['ad'] }}</td>
                                    <td class="sag">{{ $universite['baraj'] !== null ? ($universite['toplam'] ?? 0).' / '.$universite['baraj'] : 'Puansız yönerge' }}</td>
                                    <td class="sag"><span class="rapor-etiket-rozet rapor-{{ $renk }}">{{ $etiket }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if ($rapor['universiteFazlasi'] > 0)
                        <p class="rapor-dipnot">… ve {{ $rapor['universiteFazlasi'] }} kurum daha. Tam liste Yönerge Analizi ekranında.</p>
                    @endif
                @else
                    <p class="rapor-bos">Bu kadro ve temel alan için yönergesi girilmiş kurum yok.</p>
                @endif
            </section>
        @endif

        {{-- FAALİYET LİSTESİ --}}
        @if ($acik('faaliyetler'))
            <section class="rapor-bolum">
                <h2 class="rapor-bolum-baslik">Yayın ve Faaliyet Listesi</h2>
                @forelse ($rapor['faaliyetler'] as $kategori => $satirlar)
                    <h3 class="rapor-alt-baslik">{{ $kategori }} <small>{{ count($satirlar) }}</small></h3>
                    <x-rapor.faaliyet-tablosu :satirlar="$satirlar" :puan-var="$puanVar" />
                @empty
                    <p class="rapor-bos">Bu aralıkta onaylı faaliyet yok.</p>
                @endforelse
            </section>
        @endif

        {{-- TEZ DANIŞMANLIĞI --}}
        @if ($acik('tez'))
            <section class="rapor-bolum">
                <h2 class="rapor-bolum-baslik">Tez Danışmanlığı</h2>
                @if ($rapor['tezDanismanligi'] !== [])
                    <x-rapor.faaliyet-tablosu :satirlar="$rapor['tezDanismanligi']" :puan-var="$puanVar" />
                @else
                    <p class="rapor-bos">Bu aralıkta onaylı tez danışmanlığı kaydı yok.</p>
                @endif
            </section>
        @endif

        {{-- TOPLUMSAL KATKI --}}
        @if ($acik('katki'))
            <section class="rapor-bolum">
                <h2 class="rapor-bolum-baslik">Toplumsal Katkı</h2>
                @if ($rapor['toplumsalKatki'] !== [])
                    <x-rapor.faaliyet-tablosu :satirlar="$rapor['toplumsalKatki']" :puan-var="$puanVar" />
                @else
                    <p class="rapor-bos">Bu aralıkta onaylı toplumsal katkı kaydı yok.</p>
                @endif
            </section>
        @endif

        {{-- YZ JÜRİ ÖZETİ — yalnızca rapor varsa; boş bir başlık basılmaz. --}}
        @if ($acik('juri') && $rapor['juri'] !== null)
            <section class="rapor-bolum">
                <h2 class="rapor-bolum-baslik">YZ Jüri Özeti</h2>
                <div class="rapor-hedef-satir">
                    <span>Jüri kararı: <strong>{{ $rapor['juri']['karar'] }}</strong></span>
                    <span class="rapor-dipnot rapor-dipnot-satir">{{ $rapor['juri']['tarih'] }}</span>
                </div>
                @if ($rapor['juri']['ozet'] !== '')
                    <p class="rapor-metin">{{ $rapor['juri']['ozet'] }}</p>
                @endif
                @if ($rapor['juri']['plan'] !== null)
                    <h3 class="rapor-alt-baslik">Stratejik tamamlama planı</h3>
                    <x-juri.markdown :icerik="$rapor['juri']['plan']" class="rapor-metin" />
                @endif
                <p class="rapor-dipnot">Yapay zekâ yorumudur; puan ve koşul sonuçları yukarıdaki motor hesabına dayanır.</p>
            </section>
        @endif
    </div>
</div>
