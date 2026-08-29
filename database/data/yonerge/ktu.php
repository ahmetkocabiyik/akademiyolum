<?php

/**
 * KARADENİZ TEKNİK ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma
 * Yönergesi
 * Kaynak: pdf/17536999312.karadenizteknikuniverstesi.pdf (48 sayfa;
 *         26.12.2012 tarihli yönergeyi yürürlükten kaldırıyor, MADDE 9;
 *         17.10.2023 tarih ve 342 sayılı Senato değişiklikleriyle)
 *
 * KORPUSUN EN ÇOK EKLİ YÖNERGESİ: EK-1 bütün kadrolar için ortak zorunlu
 * başvuru koşulları, EK-15 tek puan tablosu, ARADAKİ ON ÜÇ EK ise FAKÜLTE
 * FAKÜLTE özel koşullar. On üç ek normalleştirilip hashlenerek karşılaştırıldı:
 * HİÇBİRİ BİRBİRİNİN AYNI DEĞİL, her biri 4100-5400 karakter. Kastamonu'daki
 * "on altı ek, beş kural" kısayolu burada işlemedi; on üçü tek tek okundu.
 *
 * EŞİKLER TEMEL ALANA DEĞİL FAKÜLTEYE BAĞLI, bu yüzden her kayıt `birim`
 * taşıyor. Dört fakülte (Diş Hekimliği, Eczacılık, Sağlık Bilimleri, Tıp)
 * aynı temel alana düşüyor ve dördünün de koşulları farklı; ayrım yalnız
 * `birim` ile kurulabiliyor.
 *
 *   Diş Hekimliği Fakültesi           → saglik
 *   Eczacılık Fakültesi               → saglik
 *   Edebiyat Fakültesi                → sosyal, filoloji
 *   Fen Fakültesi                     → fen
 *   İktisadi ve İdari Bilimler Fak.   → sosyal
 *   Mimarlık Fakültesi                → mimarlik
 *   Mühendislik Fakültesi             → muhendislik
 *   Of Teknoloji Fakültesi            → muhendislik
 *   Orman Fakültesi                   → ziraat
 *   Sağlık Bilimleri Fakültesi        → saglik
 *   Sürmene Deniz Bilimleri Fakültesi → muhendislik, ziraat
 *   Tıp Fakültesi                     → saglik
 *
 * EĞİTİM, HUKUK, İLAHİYAT, SPOR VE GÜZEL SANATLAR HİÇ ANILMIYOR: yönergenin
 * ek listesinde bu fakültelerin özel koşulları yok. O temel alanlar için eşik
 * yazılmadı; kapsam dışı kalmaları doğrusu.
 *
 * EK-14 (öğretim üyesi tahsisli enstitü, yüksekokul ve meslek yüksekokulu)
 * ayrı bir eşik doğurmuyor: üç kadroda da "adayın bulunduğu bilim alanı ile
 * ilgili fakülte koşulları geçerlidir" diyor. Orman Fakültesinin PEYZAJ
 * MİMARLIĞI bölümü de aynı biçimde Mimarlık Fakültesi koşullarına tabi
 * (EK-10 başlığının kendi notu); aday notunda söyleniyor.
 *
 * ASGARİ BAŞVURU PUANI ON ÜÇ EKTE DE AYNI: profesörlük 420, doçentlik 330,
 * Dr. Öğr. Üyesi 135. Fakülteler arasındaki fark ALT BARAJLARDA ve bölüm
 * TAVANLARINDA; tavanlar cetvel varyantlarına gömüldü (bkz. cetvel/ktu-2023.php).
 *
 * DÖNEM: profesörlükte "doçentlik unvanının alındığı başvuru tarihinden
 * sonraki bilimsel aktiviteler", doçentlikte "doktora/uzmanlık unvanının
 * alındığı tarihten sonraki bilimsel aktiviteler" — sütun başlıklarının kendi
 * ifadesi. Dr. Öğr. Üyeliğinde dönem kısıtı yok.
 *
 * MAKALE KOŞULU ÜÇ KATMANLI: (1) bölümün tamamından asgari puan, (2) o puanın
 * belirli bir kısmının çeyrek dilimli dergilerden gelmesi, (3) belirli sayıda
 * yayında başlıca yazar olmak. Alt küme fakülteye göre değişiyor:
 *   1a-1ç (Q1-Q4)         Diş, Eczacılık, Fen, Mühendislik, Of, Orman, Tıp
 *   1a-1e (+ESCI/Scopus)  Edebiyat, İİBF, Sağlık Bilimleri, Sürmene
 *   1a-1i (tümü)          Mimarlık (alt puan barajı yok, yalnız başlıca yazar)
 *
 * "BAŞLICA YAZAR KOŞULU SAĞLANAMIYORSA EKSİK YAYIN BAŞINA İLAVE 40 PUAN"
 * TELAFİSİ HESAPLANAMIYOR: eksik yayın sayısı koşulun kendi sonucuna bağlı,
 * motor böyle bir geri besleme kuramıyor. Koşul `Kalip::veya` ile yazıldı;
 * ikinci kol `hesaplanamiyor`, yani telafiyi kullanan aday KIRMIZI değil
 * BELİRSİZ görüyor. Aynı yapı tez danışmanlığı ve proje koşullarının
 * telafilerinde de kullanıldı.
 *
 * DR. ÖĞR. ÜYELİĞİNDE 89 GÜNLÜK YURT DIŞI İNDİRİMİ YAZILMADI (§0): lisans
 * sonrası kesintisiz 89 gün yurt dışında bulunan adaya makale barajı 50-80
 * yerine 40 puana iniyor. İndirimi hak edip etmediği profilde tutulmadığı için
 * YÜKSEK baraj gösteriliyor ve aday notunda uyarılıyor.
 *
 * "KTÜ 50/d DOKTORA MEZUNU" SÜTUNU GİRİLMEDİ. EK'lerin dördüncü sütunu
 * KTÜ'nün kendi 50/d kadrosunda doktorasını tamamlayanlara AYRI ve DAHA AĞIR
 * bir baraj koyuyor (makale 50 yerine 80). Adayın doktorasını nerede
 * tamamladığı profilde yok; genel sütun girildi ve istisna aday notunda
 * söylendi. Yüksek olanı herkese göstermek, kuralı adayların çoğu için yanlış
 * anlatırdı.
 *
 * DR. ÖĞR. ÜYESİ YENİDEN ATANMA GİRİLMEDİ: EK'lerin beşinci sütununda makale
 * barajı "uzatma yıl sayısı × 10 puan" biçiminde; uzatma süresi profilde yok.
 *
 * EK-1'İN ORTAK KOŞULLARI BEYAN: profesörlükte doçentlik sonrası en az üç yıl
 * fiilen çalışmış olmak, doçentlik ve profesörlükte ÜAK sözlü sınavında
 * başarılı olmak (WoS h-indeksi 25/20 olanlarda aranmıyor) ve lisans sonrası
 * alanında en az 89 gün yurt dışı gözlem, eğitim veya araştırma. Sonuncusunun
 * iki alternatifi var: AB Çerçeve, COST, ikili işbirliği ya da diğer
 * uluslararası kuruluş projelerinde koordinatörlük; o da yoksa istenen asgari
 * puanın %30 fazlası. Yüzde alternatifi yazılmadı — koşulun kendisi beyan
 * olduğu için hangi kolun geçerli olduğu bilinemiyor.
 *
 * YABANCI DİL: doçentlik ve Dr. Öğr. Üyeliğinde en az 65; "yabancı dille
 * ilgili bölümler ve yabancı dilde eğitim yapan programlar için 85". Bölüm
 * ayrımı `birim` ekseni zaten fakülteye ayrıldığı için kurulamadı; 65
 * yazıldı ve 85 aday notunda uyarı olarak duruyor. Profesörlük sütununda
 * yabancı dil koşulu YOK.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: ktu-2023-*
 */

use App\Services\Scoring\Sart\Kalip;

$UNI = 'Karadeniz Teknik Üniversitesi';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;

$asgari = ['prof' => 420, 'docentlik' => 330, 'dr' => 135];

$telafiNotu = 'Yönerge birçok koşula telafi tanıyor: başlıca yazar koşulu sağlanamıyorsa eksik '
    .'yayın başına çeyrek dilimli dergilerden ilave 40 puan, tez danışmanlığı koşulu '
    .'sağlanamıyorsa doçentlik sonrası ilave iki makale, proje koşulu sağlanamıyorsa ilave bir '
    .'ya da iki makale. Bu telafiler eksik miktara bağlı olduğu için hesaplanamıyor; koşulu '
    .'sağlamayan aday KIRMIZI değil BELİRSİZ görüyor ve telafiyi belgeyle göstermesi gerekiyor.';

$ekBirNotu = 'EK-1\'in bütün kadrolara koyduğu ortak koşullar beyan olarak duruyor: '
    .'profesörlükte doçentlik sonrası en az üç yıl fiilen çalışmış olmak, doçentlik ve '
    .'profesörlükte ÜAK sözlü sınavında başarılı olmak (Web of Science h-indeksiniz 25 ya da 20 '
    .'ise bu şart aranmıyor) ve lisans sonrası alanınızda en az 89 gün yurt dışı gözlem, eğitim '
    .'veya araştırma. Son koşulu sağlayamıyorsanız AB Çerçeve, COST ya da uluslararası ikili '
    .'işbirliği projelerinde koordinatörlük yapmış olmanız yeterli; o da yoksa istenen asgari '
    .'puanın %30 fazlasını sağlamanız gerekiyor.';

$dilNotu = 'Yabancı dil barajı 65; yabancı dille ilgili bölümlerde ve yabancı dilde eğitim '
    .'yapan programlarda 85. Bölüm ayrımı burada kurulamadığı için 65 gösteriliyor.';

$drNotu = 'Lisans öğreniminizi tamamladıktan sonra kesintisiz en az 89 gün yurt dışında '
    .'alanınızla ilgili gözlem, eğitim veya araştırma yaptıysanız makale barajınız düşüyor; '
    .'bu indirim burada uygulanmadı, YÜKSEK baraj gösteriliyor. Doktoranızı KTÜ\'nün kendi 50/d '
    .'kadrosunda tamamladıysanız yönerge size AYRI VE DAHA AĞIR bir baraj uyguluyor (makale '
    .'50-70 yerine 80 puan); o sütun da girilmedi. Doçent unvanına sahip doktor öğretim '
    .'üyelerinde yeniden atanmada asgari koşul aranmıyor.';

$profBeyanlari = [
    Kalip::beyan('Doçentlik unvanını aldıktan sonra, profesörlüğe atanabilmek için gerekli yasal '
        .'sürenin en az üç yılını üniversitelerde ya da alanınızla ilgili bir bilimsel araştırma '
        .'kuruluşunda fiilen çalışarak geçirmiş olmak', 'EK-1/a'),
    Kalip::beyan('Üniversitelerarası Kurul tarafından oluşturulan jüri tarafından yapılan sözlü '
        .'sınavda başarılı olmak (Web of Science h-indeksi 25 olanlarda aranmaz)', 'EK-1/b'),
    Kalip::beyan('Lisans eğitimini takip eden yıllarda alanınızda en az 89 gün yurt dışı gözlem, '
        .'eğitim veya araştırma faaliyetinde bulunmak; sağlanamıyorsa AB Çerçeve, COST ya da '
        .'uluslararası işbirliği projelerinde koordinatörlük veya istenen asgari puanın %30 '
        .'fazlası', 'EK-1/c'),
];

$docBeyanlari = [
    Kalip::beyan('Üniversitelerarası Kurulca oluşturulan jüri tarafından yapılan sözlü sınavda '
        .'başarılı olmak ve doçentlik unvanını atanacağınız ilgili temel alanda almış olmak',
        'EK-1/a'),
    Kalip::beyan('Lisans eğitimini takip eden yıllarda alanınızda en az 89 gün yurt dışı gözlem, '
        .'eğitim veya araştırma faaliyetinde bulunmak; sağlanamıyorsa uluslararası proje '
        .'koordinatörlüğü veya istenen asgari puanın %30 fazlası', 'EK-1/d'),
];

$drBeyani = Kalip::beyan('Doktora ya da uzmanlık unvanını almış veya belli sanat dallarının '
    .'birinde yeterlik kazanmış olmak', 'EK-1/a');

/**
 * Fakülte özel koşulları. `altKume` null ise makale bölümünün alt puan barajı yoktur.
 *
 * @var list<array<string, mixed>>
 */
$fakulteler = [
    [
        'birim' => 'Diş Hekimliği Fakültesi', 'alan' => ['saglik'], 'profil' => 'fen',
        'ek' => 'EK-2', 'altKume' => '1a-1ç', 'altMin' => [120, 80, 30],
        'makaleMin' => [200, 160, 50], 'baslicaKume' => '1a-1ç', 'baslicaAdet' => [3, 2],
        'drYazar' => 'ilk', 'atifMin' => [100, 80], 'projeMin' => [25, 20],
        'bildiriMin' => [25, 20, 15], 'bildiriUlusMin' => [10, 10, 5],
    ],
    [
        'birim' => 'Eczacılık Fakültesi', 'alan' => ['saglik'], 'profil' => 'fen',
        'ek' => 'EK-3', 'altKume' => '1a-1ç', 'altMin' => [120, 80, 40],
        'makaleMin' => [200, 160, 70], 'baslicaKume' => '1a-1ç', 'baslicaAdet' => [3, 2],
        'drYazar' => 'ilk', 'atifMin' => [100, 80], 'projeMin' => [25, 20],
        'bildiriMin' => [25, 20, 15], 'bildiriUlusMin' => [10, 10, 5],
    ],
    [
        'birim' => 'Edebiyat Fakültesi', 'alan' => ['sosyal', 'filoloji'], 'profil' => 'sosyal',
        'ek' => 'EK-4', 'altKume' => '1a-1e', 'altMin' => [120, 80, 40],
        'makaleMin' => [200, 160, 70], 'baslicaKume' => '1a-1e', 'baslicaAdet' => [1, 1],
        'drYazar' => 'ilk', 'atifMin' => [60, 40], 'projeMin' => [15, 10],
        'bildiriMin' => [20, 15, 10], 'bildiriUlusMin' => [10, 10, 5],
    ],
    [
        'birim' => 'Fen Fakültesi', 'alan' => ['fen'], 'profil' => 'fen',
        'ek' => 'EK-5', 'altKume' => '1a-1ç', 'altMin' => [120, 80, 40],
        'makaleMin' => [200, 160, 70], 'baslicaKume' => '1a-1ç', 'baslicaAdet' => [3, 2],
        'drYazar' => 'ilk', 'atifMin' => [100, 80], 'projeMin' => [25, 20],
        'bildiriMin' => [25, 20, 15], 'bildiriUlusMin' => [10, 10, 5],
    ],
    [
        'birim' => 'İktisadi ve İdari Bilimler Fakültesi', 'alan' => ['sosyal'], 'profil' => 'sosyal',
        'ek' => 'EK-6', 'altKume' => '1a-1e', 'altMin' => [120, 80, 40],
        'makaleMin' => [200, 160, 70], 'baslicaKume' => '1a-1e', 'baslicaAdet' => [1, 1],
        'drYazar' => 'ilk', 'atifMin' => [60, 40], 'projeMin' => [15, 10],
        'bildiriMin' => [20, 15, 10], 'bildiriUlusMin' => [10, 10, 5],
    ],
    [
        'birim' => 'Mimarlık Fakültesi (Orman Fakültesi Peyzaj Mimarlığı Bölümü dâhil)',
        'alan' => ['mimarlik'], 'profil' => 'mimarlik',
        'ek' => 'EK-7', 'altKume' => null, 'altMin' => [0, 0, 0],
        'makaleMin' => [200, 160, 70], 'baslicaKume' => '1a-1i', 'baslicaAdet' => [3, 3],
        'drYazar' => 'baslica', 'atifMin' => [10, 5], 'projeMin' => [15, 10],
        'bildiriMin' => [30, 15, 10], 'bildiriUlusMin' => [10, 10, 5],
    ],
    [
        'birim' => 'Mühendislik Fakültesi', 'alan' => ['muhendislik'], 'profil' => 'fen',
        'ek' => 'EK-8', 'altKume' => '1a-1ç', 'altMin' => [120, 80, 40],
        'makaleMin' => [200, 160, 70], 'baslicaKume' => '1a-1ç', 'baslicaAdet' => [3, 2],
        'drYazar' => 'ilk', 'atifMin' => [100, 80], 'projeMin' => [25, 20],
        'bildiriMin' => [25, 20, 15], 'bildiriUlusMin' => [10, 10, 5],
    ],
    [
        'birim' => 'Of Teknoloji Fakültesi', 'alan' => ['muhendislik'], 'profil' => 'fen',
        'ek' => 'EK-9', 'altKume' => '1a-1ç', 'altMin' => [120, 80, 40],
        'makaleMin' => [200, 160, 70], 'baslicaKume' => '1a-1ç', 'baslicaAdet' => [3, 2],
        'drYazar' => 'ilk', 'atifMin' => [100, 80], 'projeMin' => [25, 20],
        'bildiriMin' => [25, 20, 15], 'bildiriUlusMin' => [10, 10, 5],
    ],
    [
        'birim' => 'Orman Fakültesi', 'alan' => ['ziraat'], 'profil' => 'fen',
        'ek' => 'EK-10', 'altKume' => '1a-1ç', 'altMin' => [120, 80, 40],
        'makaleMin' => [200, 160, 70], 'baslicaKume' => '1a-1ç', 'baslicaAdet' => [3, 2],
        'drYazar' => 'ilk', 'atifMin' => [100, 80], 'projeMin' => [25, 20],
        'bildiriMin' => [25, 20, 15], 'bildiriUlusMin' => [10, 10, 5],
    ],
    [
        'birim' => 'Sağlık Bilimleri Fakültesi', 'alan' => ['saglik'], 'profil' => 'fen',
        'ek' => 'EK-11', 'altKume' => '1a-1e', 'altMin' => [120, 80, 40],
        'makaleMin' => [200, 160, 70], 'baslicaKume' => '1a-1e', 'baslicaAdet' => [3, 2],
        'drYazar' => 'baslica', 'atifMin' => [100, 80], 'projeMin' => [25, 20],
        'bildiriMin' => [25, 20, 15], 'bildiriUlusMin' => [10, 10, 5],
    ],
    [
        'birim' => 'Sürmene Deniz Bilimleri Fakültesi', 'alan' => ['muhendislik', 'ziraat'],
        'profil' => 'fen',
        'ek' => 'EK-12', 'altKume' => '1a-1e', 'altMin' => [120, 80, 40],
        'makaleMin' => [200, 160, 80], 'baslicaKume' => '1a-1ç', 'baslicaAdet' => [3, 2],
        'drYazar' => 'ilk', 'atifMin' => [100, 80], 'projeMin' => [25, 20],
        'bildiriMin' => [25, 20, 15], 'bildiriUlusMin' => [10, 10, 5],
    ],
    [
        'birim' => 'Tıp Fakültesi', 'alan' => ['saglik'], 'profil' => 'fen',
        'ek' => 'EK-13', 'altKume' => '1a-1ç', 'altMin' => [120, 80, 30],
        'makaleMin' => [200, 160, 50], 'baslicaKume' => '1a-1ç', 'baslicaAdet' => [3, 2],
        'drYazar' => 'ilk', 'atifMin' => [100, 80], 'projeMin' => [25, 20],
        'bildiriMin' => [25, 20, 5], 'bildiriUlusMin' => [10, 10, 5],
    ],
];

$kume = fn (string $k): string => match ($k) {
    '1a-1ç' => 'Q1-Q4 dilimli dergilerdeki makalelerinizden',
    '1a-1e' => 'Q dilimli, ESCI ve Scopus dergilerindeki makalelerinizden',
    '1a-1i' => 'Makale kalemlerinizden',
    default => 'Makale kalemlerinizden',
};

$telafili = fn (string $baslik, array $ana, string $aciklama, string $madde) => Kalip::veya(
    $baslik, [$ana, Kalip::hesaplanamiyor($aciklama, $madde)]);

$esikler = [];

foreach ($fakulteler as $f) {
    $ek = $f['ek'];

    foreach ([
        ['prof', 'profesorluk', 'Profesör', 0, $DOCENTLIK],
        ['docentlik', 'docentlik', 'Doçent', 1, $DOKTORA],
        ['dr', 'dr_ogr_uyesi', 'Dr. Öğr. Üyesi', 2, null],
    ] as [$kadroEk, $kadro, $kadroAd, $i, $donem]) {
        $cocuklar = [Kalip::toplam($asgari[$kadroEk], $donem)];

        $cocuklar[] = Kalip::puanDan('Makale kalemlerinizden en az '.$f['makaleMin'][$i].' puan',
            ['MAKALE'], $f['makaleMin'][$i], $donem, madde: "{$ek} — 1. Makale");

        if ($f['altKume'] !== null) {
            $cocuklar[] = Kalip::puanDan(
                $kume($f['altKume']).' en az '.$f['altMin'][$i].' puan',
                [$f['altKume']], $f['altMin'][$i], $donem, madde: "{$ek} — 1. Makale");
        }

        if ($i === 2) {
            $cocuklar[] = Kalip::adet(
                $f['drYazar'] === 'baslica'
                    ? 'Makalelerinizin en az birinde başlıca yazar olmak'
                    : 'Makalelerinizin en az birinde birinci yazar olmak',
                [$f['baslicaKume']], 1, yazar: $f['drYazar'], madde: "{$ek} — 1. Makale");
        } else {
            $adet = $f['baslicaAdet'][$i];
            $cocuklar[] = $telafili(
                'Başlıca yazarlık koşulu ya da telafisi',
                Kalip::adet("Bu makalelerin en az {$adet} tanesinde başlıca yazar olmak",
                    [$f['baslicaKume']], $adet, yazar: 'baslica', donem: $donem,
                    madde: "{$ek} — 1. Makale"),
                'Başlıca yazar koşulunu sağlayamıyorsanız eksik yayın başına makale '
                .'kalemlerinizden ilave en az 40 puan almış olmak', "{$ek} — 1. Makale");

            $cocuklar[] = Kalip::puanDan('Atıf kalemlerinizden en az '.$f['atifMin'][$i].' puan',
                ['ATIF'], $f['atifMin'][$i], $donem, madde: "{$ek} — 3. Atıf");
        }

        if ($i === 0) {
            $cocuklar[] = Kalip::puanDan('Lisansüstü tez danışmanlığı kalemlerinizden en az 20 puan',
                ['TEZ'], 20, $donem, madde: "{$ek} — 4. Tez Danışmanlığı");
            $cocuklar[] = $telafili(
                'Tez danışmanlığı koşulu ya da telafisi',
                Kalip::veya('Tez danışmanlığı koşulu', [
                    Kalip::adet('Danışmanlığınızda tamamlanmış en az 1 doktora, uzmanlık ya da '
                        .'sanatta yeterlik tezi', ['TEZ-DOKTORA'], 1, madde: "{$ek} — 4/c"),
                    Kalip::adet('Danışmanlığınızda tamamlanmış en az 2 yüksek lisans tezi',
                        ['TEZ-YL'], 2, madde: "{$ek} — 4/c"),
                ]),
                'Tez danışmanlığı koşulunu sağlayamıyorsanız doçentlik başvurunuzdan sonra '
                .'yayımlanmış, başlıca yazar olduğunuz ilave iki makaleye sahip olmak',
                "{$ek} — 4/c");
        }

        if ($i !== 2) {
            $cocuklar[] = $telafili(
                'Proje koşulu ya da telafisi',
                Kalip::puanDan('Bilimsel araştırma projesi kalemlerinizden en az '
                    .$f['projeMin'][$i].' puan', ['PROJE'], $f['projeMin'][$i], $donem,
                    madde: "{$ek} — 5. Proje"),
                'Proje puan şartını sağlayamıyorsanız makale kalemlerinizden, zorunlu puanda '
                .'sayılmayan ve başlıca yazar olduğunuz ilave makalelere sahip olmak',
                "{$ek} — 5. Proje");
        }

        $cocuklar[] = Kalip::puanDan('Bildiri kalemlerinizden en az '.$f['bildiriMin'][$i].' puan',
            ['BILDIRI'], $f['bildiriMin'][$i], $donem, madde: "{$ek} — 6. Bilimsel Toplantı");
        $cocuklar[] = Kalip::puanDan('Bunların en az '.$f['bildiriUlusMin'][$i]
            .' puanı uluslararası bilimsel toplantı bildirilerinden',
            ['BILDIRI-ULUS'], $f['bildiriUlusMin'][$i], $donem,
            madde: "{$ek} — 6. Bilimsel Toplantı");

        if ($i === 0) {
            $cocuklar = [...$cocuklar, ...$profBeyanlari];
        } elseif ($i === 1) {
            $cocuklar = [...$cocuklar, ...$docBeyanlari, Kalip::yds(65)];
        } else {
            $cocuklar[] = $drBeyani;
            $cocuklar[] = Kalip::yds(65);
        }

        $notu = $ekBirNotu.' '.$telafiNotu.($i === 2 ? ' '.$drNotu : '')
            .($i === 0 ? '' : ' '.$dilNotu)
            .($f['profil'] === 'mimarlik'
                ? ' Orman Fakültesinin Peyzaj Mimarlığı Bölümü de bu koşullara tabidir.'
                : '');

        $esikler[] = [
            'anahtar' => 'ktu-'.$kadroEk.'-'.$f['ek'],
            'aday_notu' => $notu,
            'universite' => $UNI,
            'kadro' => $kadro,
            'alan' => $f['alan'],
            'birim' => $f['birim'],
            'cetvel' => 'ktu-2023-'.$f['profil'].'-'.$kadroEk,
            'notlar' => $ek.' — asgari başvuru puanı '.$asgari[$kadroEk].'; makale bölümünden '
                .$f['makaleMin'][$i].' puan'
                .($f['altKume'] !== null
                    ? ' (en az '.$f['altMin'][$i].'\'i '.$f['altKume'].' kapsamında)'
                    : '')
                .'; bildiri bölümünden '.$f['bildiriMin'][$i].' puan.',
            'sart' => Kalip::ve($kadroAd.' — '.$f['birim'], $cocuklar),
        ];
    }
}

return $esikler;
