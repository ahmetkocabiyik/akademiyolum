<?php

use App\Services\Scoring\Sart\Kalip;

/**
 * SÜLEYMAN DEMİREL ÜNİVERSİTESİ — Öğretim Üyeliği Kadrolarına Başvurma,
 * Atanma ve Yükseltilme Kriterlerine İlişkin Yönerge
 * Kaynak: pdf/17855054481.Süleyman Demirel Üniversitesi Kriter Değişikliği.pdf
 * (Senato 28.01.2026 tarih ve 658/6 sayılı kararı; 01.01.2027'de yürürlükte)
 *
 * Cetvel: cetvel/suleyman-demirel-2027.php
 *
 * ── EŞİKLERİN YAPISI ──
 * Her kadroda iki katman var: "atanmaya esas puan" barajı (doktor öğretim
 * üyeliğinde 80, doçentlikte 160, profesörlükte doçentlik sonrası 160) ile
 * temel alana göre değişen Tablo 2, 3 ve 4 şartları. Yeniden atamada
 * baraj yıllık ortalama 10 puan.
 *
 * ── YORUM KARARLARI (§0) ──
 *   Ek-1'in 3. maddesi (lisansüstü tezlerden üretilmiş yayınlar) cetvele
 *       girilemedi. Tablo 2'nin "3/a veya 3/b maddelerinden en az bir
 *       makale" koşulu, yönergenin kendi alternatif kolu üzerinden
 *       (01.01.2027'den önce tezini tamamlayanlar için 1/a-1/c'den bir
 *       makale) değerlendiriliyor. Yönergenin "ilk 500'deki bir kurumda
 *       kesintisiz altı ay yurt dışı araştırma" muafiyeti belgeye bağlı
 *       olduğu için yazılmadı.
 *   Fen Bilimleri ve Matematik tablosunda Matematik-İstatistik alanları
 *       için daha düşük eşik (2 makale, 40 puan) var; profilde alt bilim
 *       alanı olmadığından §0 gereği daha AĞIR olan Fen Bilimleri eşiği
 *       (4 makale, 80 puan) uygulandı.
 *   Spor Bilimlerinde doçentlik ve profesörlüğün "Sportif Başarı ve Temsil
 *       kategorisinden en az 10 puan" koşulu cetvele girilemeyen 14.
 *       maddeye bağlı olduğu için `hesaplanamiyor` düğümünde duruyor.
 *   Ek-1'in 9. maddesi (eğitim-öğretim) puanı tek derse değil "dört farklı
 *       yarıyılda ders vermiş olmak" bloğuna verdiği için satır olarak
 *       yazılmadı; maddenin doçentlik ve profesörlükte geçerli olan "en az
 *       2 puan" koşulu ders yarıyılı metriğine çevrildi (dört yarıyıl).
 *       Doktor öğretim üyeliğinde MADDE 10/2-ii uyarınca "en az" ifadeleri
 *       dikkate alınmadığı için bu koşul aranmıyor.
 *   Profesörlükte proje koşulunun (Tablo 4) alternatifleri arasında yer
 *       alan FWCI/CNCI atıf etkisi ve yurt dışı araştırma yolları profil
 *       ölçütü olduğu için yazılmadı; yalnızca "1/a-1/c makalelerinden en
 *       az 10 puan" alternatifi ile projenin kendisi değerlendiriliyor.
 *   Ziraat, Orman ve Su Ürünleri temel alanı Tablo 2, 3 ve 4'te hiç
 *       geçmiyor; bu alanda eşik yazılmadı.
 *   Sağlık Bilimlerinin Tıp ve Diş Hekimliği fakülteleri için puan şartını
 *       kaldırabilen dipnotu yazılmadı.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 9/5'in yabancı dil koşulu (65 puan, temel alanı yabancı dil olan
 *       kadrolarda 85) — araç dil puanını yds düğümüyle 65 üzerinden
 *       değerlendiriyor.
 *   MADDE 12/ii'nin ÜAK doçentlik belgesi koşulu beyan olarak eklendi.
 *   Tablo 3 ve 4'ün "farklı dergilerde yayımlanmış" ve "aynı yayın iki kez
 *       puanlanamaz" kısıtları.
 */
$YDS_NOTU = 'Bütün kadrolarda ÖSYM ya da YÖK tarafından kabul edilen bir yabancı dil sınavından '
    .'en az 65 puan gerekiyor; temel alanı yabancı dille ilgili olan kadrolarda o dilden 85 '
    .'puan aranıyor, araç 65 üzerinden değerlendiriyor.';

$TEZ_NOTU = 'Yönerge, lisansüstü tezinizden üretilmiş en az bir makale istiyor; Ek-1\'in 3. '
    .'maddesi araca girilemediği için bu koşul yönergenin kendi alternatif kolu üzerinden '
    .'(uluslararası makale kategorisinden bir makale) değerlendiriliyor. Yönergenin "ilk '
    .'500\'deki bir kurumda kesintisiz altı ay yurt dışı araştırma" muafiyeti belgeye bağlı '
    .'olduğu için araçta uygulanmıyor.';

$PROJE_NOTU = 'Profesörlükte ayrıca Bilimsel Araştırma Projesi kategorisinden en az 10 puan '
    .'gerekiyor; bu sağlanamazsa uluslararası makale kategorisinden 10 puanla telafi '
    .'edilebiliyor. Yönergenin diğer iki telafi yolu (ilk 500\'de altı ay yurt dışı araştırma ve '
    .'FWCI/CNCI atıf etkisinin en az 1,00 olması) profil ölçütü olduğu için araçta '
    .'uygulanmıyor.';

/**
 * Tablo 2, 3 ve 4'ün temel alana göre değişen şartları.
 *
 * @var list<array{ad: string, anahtar: string, alan: list<string>, dr: array<string, mixed>, doc: array<string, mixed>, sportif: bool, sanat: bool, yarisma: bool}>
 */
$alanlar = [
    ['ad' => 'Eğitim Bilimleri', 'anahtar' => 'egitim', 'alan' => ['egitim'],
        'dr' => ['grup' => '1ABC', 'puan' => 30, 'ulusal' => 2],
        'doc' => ['grup' => '1A-Q123', 'adet' => 2, 'puan' => 40, 'ulusal' => 2],
        'sportif' => false, 'sanat' => false, 'yarisma' => false],
    ['ad' => 'Fen Bilimleri ve Matematik', 'anahtar' => 'fen', 'alan' => ['fen'],
        'dr' => ['grup' => '1A', 'puan' => 30, 'ulusal' => 2],
        'doc' => ['grup' => '1A-Q123', 'adet' => 4, 'puan' => 80, 'ulusal' => 2],
        'sportif' => false, 'sanat' => false, 'yarisma' => false],
    ['ad' => 'Filoloji', 'anahtar' => 'filoloji', 'alan' => ['filoloji'],
        'dr' => ['grup' => '1ABC-2A-4AB', 'puan' => 50, 'baslica' => true],
        'doc' => ['grup' => '1ABC-2A-4AB', 'puan' => 100, 'baslica' => true],
        'sportif' => false, 'sanat' => false, 'yarisma' => false],
    ['ad' => 'Güzel Sanatlar', 'anahtar' => 'guzel-sanatlar', 'alan' => ['guzel_sanatlar'],
        'dr' => ['grup' => '1ABC-2A', 'puan' => 10, 'sanatPuan' => 30],
        'doc' => ['grup' => '1ABC-2A', 'puan' => 15, 'baslica' => true, 'sanatPuan' => 50],
        'sportif' => false, 'sanat' => true, 'yarisma' => false],
    ['ad' => 'Hukuk', 'anahtar' => 'hukuk', 'alan' => ['hukuk'],
        'dr' => ['grup' => '1ABC-2A-4AB', 'puan' => 50],
        'doc' => ['grup' => '1ABC-2A-4AB', 'puan' => 100],
        'sportif' => false, 'sanat' => false, 'yarisma' => false],
    ['ad' => 'İlahiyat', 'anahtar' => 'ilahiyat', 'alan' => ['ilahiyat'],
        'dr' => ['grup' => '1ABC-2A-4AB', 'puan' => 50],
        'doc' => ['grup' => '1ABC-2A-4AB', 'puan' => 100],
        'sportif' => false, 'sanat' => false, 'yarisma' => false],
    ['ad' => 'Mimarlık, Planlama ve Tasarım', 'anahtar' => 'mimarlik', 'alan' => ['mimarlik'],
        'dr' => ['grup' => '1ABC', 'puan' => 20, 'ulusal' => 2, 'yarismaPuan' => 10],
        'doc' => ['grup' => '1ABC', 'adet' => 3, 'puan' => 40, 'ulusal' => 2, 'baslica' => true, 'yarismaPuan' => 15],
        'sportif' => false, 'sanat' => false, 'yarisma' => true],
    ['ad' => 'Mühendislik', 'anahtar' => 'muhendislik', 'alan' => ['muhendislik'],
        'dr' => ['grup' => '1A', 'puan' => 30, 'ulusal' => 2],
        'doc' => ['grup' => '1A-Q123', 'adet' => 4, 'puan' => 80, 'ulusal' => 2],
        'sportif' => false, 'sanat' => false, 'yarisma' => false],
    ['ad' => 'Sağlık Bilimleri', 'anahtar' => 'saglik', 'alan' => ['saglik'],
        'dr' => ['grup' => '1ABC', 'puan' => 30, 'ulusal' => 2],
        'doc' => ['grup' => '1A', 'adet' => 4, 'puan' => 80, 'ulusal' => 2, 'baslicaAdet' => 3],
        'sportif' => false, 'sanat' => false, 'yarisma' => false],
    ['ad' => 'Sosyal, Beşerî ve İdari Bilimler', 'anahtar' => 'sosyal', 'alan' => ['sosyal'],
        'dr' => ['grup' => '1ABC-2A-4AB', 'puan' => 50, 'baslica' => true],
        'doc' => ['grup' => '1ABC-2A-4AB', 'puan' => 100, 'baslica' => true],
        'sportif' => false, 'sanat' => false, 'yarisma' => false],
    ['ad' => 'Spor Bilimleri', 'anahtar' => 'spor', 'alan' => ['spor'],
        'dr' => ['grup' => '1ABC', 'puan' => 30, 'ulusal' => 2],
        'doc' => ['grup' => '1ABC', 'adet' => 4, 'puan' => 50, 'ulusal' => 2, 'baslicaAdet' => 2],
        'sportif' => true, 'sanat' => false, 'yarisma' => false],
];

$GRUP_ADI = [
    '1A' => 'SCIE, SSCI ve AHCI dergilerinden (1/a)',
    '1A-Q123' => 'SCIE, SSCI ve AHCI\'nin Q1, Q2 ve Q3 dergilerinden (1/a)',
    '1ABC' => 'uluslararası makale kategorisinden (1/a, 1/b, 1/c)',
    '1ABC-2A' => 'uluslararası makale (1/a, 1/b, 1/c) ya da TR Dizin (2/a) kategorilerinden',
    '1ABC-2A-4AB' => 'uluslararası makale (1/a, 1/b, 1/c), TR Dizin (2/a) ya da kitap (4/a, 4/b) kategorilerinden',
];

$esikler = [];

foreach ($alanlar as $a) {
    $ortak = ['universite' => 'Süleyman Demirel Üniversitesi', 'alan' => $a['alan'],
        'cetvel' => 'suleyman-demirel-2027'];

    // ══ DOKTOR ÖĞRETİM ÜYELİĞİ (MADDE 10, Tablo 2) ══
    $drCocuklar = [
        Kalip::beyan('Doktora, sanatta yeterlik ya da uzmanlık unvanını almış olmak', 'MADDE 10/1'),
        Kalip::yds(65),
        Kalip::toplam(80, liste: 'MADDE 10/2'),
        Kalip::toplam($a['dr']['puan'], maddeler: [$a['dr']['grup']], liste: 'Tablo 2'),
    ];

    if (($a['dr']['baslica'] ?? false) === true) {
        $drCocuklar[] = Kalip::adet('Uluslararası makale kategorisinde en az bir makalede başlıca yazar olmak', ['1ABC'], 1, yazar: 'baslica', madde: 'Tablo 2');
    }

    if (isset($a['dr']['ulusal'])) {
        $drCocuklar[] = Kalip::adet('TR Dizin kapsamındaki dergilerde en az '.$a['dr']['ulusal'].' makale', ['2A'], $a['dr']['ulusal'], madde: 'Tablo 2');
    }

    if (isset($a['dr']['sanatPuan'])) {
        $drCocuklar[] = Kalip::toplam($a['dr']['sanatPuan'], maddeler: ['SANAT'], liste: 'Tablo 2 (Sanat ve Tasarım Faaliyetleri)');
    }

    if (isset($a['dr']['yarismaPuan'])) {
        $drCocuklar[] = Kalip::toplam($a['dr']['yarismaPuan'], maddeler: ['YARISMA'], liste: 'Tablo 2 (Yarışma, Proje ve Yazılım)');
    }

    $drCocuklar[] = Kalip::adet('Lisansüstü tezinizden üretilmiş bir makale yerine, uluslararası makale kategorisinde en az 1 makale', ['1ABC'], 1, madde: 'Tablo 2');

    $esikler[] = array_merge($ortak, [
        'anahtar' => 'suleyman-demirel-'.$a['anahtar'].'-dr',
        'kadro' => 'dr_ogr_uyesi',
        'notlar' => 'MADDE 10: atanmaya esas puan en az 80. Tablo 2/'.$a['ad'].': '
            .$GRUP_ADI[$a['dr']['grup']].' en az '.$a['dr']['puan'].' puan'
            .(isset($a['dr']['ulusal']) ? '; TR Dizin\'den en az '.$a['dr']['ulusal'].' makale' : '')
            .(isset($a['dr']['sanatPuan']) ? '; sanat faaliyetlerinden '.$a['dr']['sanatPuan'].' puan' : '')
            .(isset($a['dr']['yarismaPuan']) ? '; yarışma, proje ve yazılımdan '.$a['dr']['yarismaPuan'].' puan' : '')
            .'; lisansüstü tezden üretilmiş yayın koşulu.',
        'aday_notu' => $a['ad'].' temel alanında doktor öğretim üyeliği için atanmaya esas '
            .'puanınızın en az 80 olması ve Tablo 2\'nin alan şartlarını taşımanız gerekiyor: '
            .$GRUP_ADI[$a['dr']['grup']].' en az '.$a['dr']['puan'].' puan'
            .(isset($a['dr']['ulusal']) ? ', TR Dizin kapsamındaki dergilerde en az '.$a['dr']['ulusal'].' makale' : '')
            .(isset($a['dr']['sanatPuan']) ? ', Sanat ve Tasarım Faaliyetlerinden '.$a['dr']['sanatPuan'].' puan' : '')
            .(isset($a['dr']['yarismaPuan']) ? ', Yarışma-Proje-Yazılım kategorisinden '.$a['dr']['yarismaPuan'].' puan' : '')
            .'. Doktora öncesi ve sonrası bütün çalışmalar puanlamaya dâhil ve Ek-1\'deki "en '
            .'az" ifadeleri bu kadroda dikkate alınmıyor. '.$TEZ_NOTU.' '.$YDS_NOTU,
        'sart' => Kalip::ve('Doktor öğretim üyeliği koşulları', $drCocuklar),
    ]);

    // ══ YENİDEN ATAMA (MADDE 11) ══
    $esikler[] = array_merge($ortak, [
        'anahtar' => 'suleyman-demirel-'.$a['anahtar'].'-dr-yeniden',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'notlar' => 'MADDE 11: atanmaya esas puanın yıllık ortalamasının en az 10 olması; puan '
            .'son görev yenileme ya da atama başlangıç tarihinden sonraki eserlerden hesaplanır.',
        'aday_notu' => 'Yeniden atamada tek koşul, atanmaya esas puanınızın YILLIK '
            .'ORTALAMASININ en az 10 olması. Puan yalnızca son görev yenileme ya da atama '
            .'başlangıç tarihinden sonraki eserlerden hesaplanıyor. Araç iki atama arasındaki '
            .'yıl sayısını bilmediği için bu ortalamayı hesaplayamıyor; son atamanızdan bu yana '
            .'topladığınız puanı geçen yıl sayısına bölerek kendiniz kontrol etmeniz gerekiyor. '
            .'Ücretsiz izin ve sağlık kurulu raporu süreleri hesaplamadan düşülüyor.',
        'sart' => Kalip::hesaplanamiyor('Son görev yenileme ya da atama başlangıç tarihinden sonraki eserlerden hesaplanan atanmaya esas puanın yıllık ortalamasının en az 10 olması', 'MADDE 11/1'),
    ]);

    // ══ DOÇENTLİK (MADDE 12, Tablo 3) ve PROFESÖRLÜK (MADDE 13, Tablo 4) ══
    foreach ([['docentlik', null, 'MADDE 12', 'Tablo 3'], ['profesorluk', Kalip::DOCENTLIK_SONRASI, 'MADDE 13', 'Tablo 4']] as [$kadro, $donem, $madde, $tablo]) {
        $cocuklar = [Kalip::yds(65)];

        if ($kadro === 'docentlik') {
            $cocuklar[] = Kalip::beyan('Üniversitelerarası Kurul tarafından verilen doçentlik belgesine sahip olmak', 'MADDE 12/2-ii');
        }

        $cocuklar[] = Kalip::toplam(160, donem: $donem, liste: $madde);
        $cocuklar[] = Kalip::toplam($a['doc']['puan'], donem: $donem, maddeler: [$a['doc']['grup']], liste: $tablo);

        if (isset($a['doc']['adet'])) {
            $cocuklar[] = Kalip::adet('Belirtilen dergilerde en az '.$a['doc']['adet'].' makale', [$a['doc']['grup']], $a['doc']['adet'], donem: $donem, madde: $tablo);
        }

        if (isset($a['doc']['baslicaAdet'])) {
            $cocuklar[] = Kalip::adet('Bu makalelerden en az '.$a['doc']['baslicaAdet'].' tanesinde başlıca yazar olmak', [$a['doc']['grup']], $a['doc']['baslicaAdet'], yazar: 'baslica', donem: $donem, madde: $tablo);
        } elseif (isset($a['doc']['adet']) || ($a['doc']['baslica'] ?? false) === true) {
            $cocuklar[] = Kalip::adet('Belirtilen dergilerden en az birinde başlıca yazar olmak', [$a['doc']['grup']], 1, yazar: 'baslica', donem: $donem, madde: $tablo);
        }

        if (isset($a['doc']['ulusal'])) {
            $cocuklar[] = Kalip::veya('Ulusal makale koşulu', [
                Kalip::adet('TR Dizin kapsamındaki farklı dergilerde en az '.$a['doc']['ulusal'].' makale', ['2A'], $a['doc']['ulusal'], donem: $donem, madde: $tablo),
                Kalip::adet('Bu şart sağlanamazsa uluslararası makale kategorisinde en az 2 makale', ['1ABC'], 2, donem: $donem, madde: $tablo),
            ]);
        }

        if (isset($a['doc']['sanatPuan'])) {
            $cocuklar[] = Kalip::toplam($a['doc']['sanatPuan'], donem: $donem, maddeler: ['SANAT'], liste: $tablo.' (Sanat ve Tasarım Faaliyetleri)');
        }

        if (isset($a['doc']['yarismaPuan'])) {
            $cocuklar[] = Kalip::toplam($a['doc']['yarismaPuan'], donem: $donem, maddeler: ['YARISMA'], liste: $tablo.' (Yarışma, Proje ve Yazılım)');
        }

        if ($a['sportif']) {
            $cocuklar[] = Kalip::hesaplanamiyor('Sportif Başarı ve Temsil kategorisinden toplamda en az 10 puan almak', $tablo);
        }

        $cocuklar[] = Kalip::metrik('Doktora eğitimini tamamladıktan sonra dört farklı yarıyılda ders vermiş olmak', 'ders_yariyil', 4, Kalip::DOKTORA_SONRASI);

        if ($kadro === 'profesorluk') {
            $cocuklar[] = Kalip::veya('Bilimsel araştırma projesi koşulu', [
                Kalip::toplam(10, donem: $donem, maddeler: ['PROJE'], liste: 'Tablo 4'),
                Kalip::toplam(10, donem: $donem, maddeler: ['1ABC'], liste: 'Tablo 4 (proje koşulunun telafisi)'),
            ]);
        }

        $esikler[] = array_merge($ortak, [
            'anahtar' => 'suleyman-demirel-'.$a['anahtar'].'-'.$kadro,
            'kadro' => $kadro,
            'notlar' => $madde.': atanmaya esas puan en az 160'
                .($kadro === 'profesorluk' ? ' (doçentlik başvuru beyannamesinde yer almayan çalışmalardan)' : '')
                .'. '.$tablo.'/'.$a['ad'].': '.$GRUP_ADI[$a['doc']['grup']].' en az '
                .$a['doc']['puan'].' puan'
                .(isset($a['doc']['adet']) ? ' ve en az '.$a['doc']['adet'].' makale' : '')
                .(isset($a['doc']['ulusal']) ? '; TR Dizin\'den en az '.$a['doc']['ulusal'].' makale (ya da uluslararası kategoriden 2 makale)' : '')
                .(isset($a['doc']['sanatPuan']) ? '; sanat faaliyetlerinden '.$a['doc']['sanatPuan'].' puan' : '')
                .(isset($a['doc']['yarismaPuan']) ? '; yarışma, proje ve yazılımdan '.$a['doc']['yarismaPuan'].' puan' : '')
                .($a['sportif'] ? '; sportif başarı ve temsilden 10 puan' : '')
                .($kadro === 'profesorluk' ? '; bilimsel araştırma projesinden 10 puan.' : '.'),
            'aday_notu' => $a['ad'].' temel alanında '
                .($kadro === 'docentlik' ? 'doçent kadrosu' : 'profesörlük')
                .' için atanmaya esas puanınızın en az 160 olması gerekiyor'
                .($kadro === 'profesorluk'
                    ? '; bu puan yalnızca ÜAK doçentlik başvuru beyannamenizde YER ALMAYAN yayın, faaliyet ve etkinliklerden hesaplanıyor. '
                    : ' ve bu kadroda Ek-1\'deki "en az" ifadeleri de dikkate alınıyor. ')
                .'Alan şartı: '.$GRUP_ADI[$a['doc']['grup']].' en az '.$a['doc']['puan'].' puan'
                .(isset($a['doc']['adet']) ? ' ve en az '.$a['doc']['adet'].' makale' : '')
                .(isset($a['doc']['baslicaAdet']) ? ' (en az '.$a['doc']['baslicaAdet'].' tanesinde başlıca yazar)' : '')
                .(isset($a['doc']['ulusal'])
                    ? '. TR Dizin koşulunu sağlayamazsanız yönerge uluslararası makale kategorisinden iki makaleyle telafi imkânı veriyor'
                    : '')
                .'. Ayrıca doktora sonrası dört farklı yarıyılda ders vermiş olmanız gerekiyor.'
                .($a['sportif'] ? ' Spor Bilimlerinde aranan "Sportif Başarı ve Temsil kategorisinden 10 puan" koşulu, ilgili bölüm faaliyet kaydında karşılıksız olduğu için araç tarafından hesaplanamıyor.' : '')
                .($kadro === 'profesorluk' ? ' '.$PROJE_NOTU : '')
                .' '.$YDS_NOTU,
            'sart' => Kalip::ve(($kadro === 'docentlik' ? 'Doçentlik' : 'Profesörlük').' koşulları', $cocuklar),
        ]);
    }
}

return $esikler;
