<?php

use App\Services\Scoring\Sart\Kalip;

/**
 * ZONGULDAK BÜLENT ECEVİT ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve
 * Atanma Ölçütleri Yönergesi
 * Kaynak: pdf/17634009071.Zonguldak Bülent Ecevit Üniversitesi Kriter.pdf
 * (24.10.2024 YÖK Genel Kurulu; 01.01.2026'da yürürlüğe giriyor)
 *
 * Cetvel: cetvel/zbeu-2026.php
 *
 * ── EŞİKLERİN YAPISI ──
 * Yönerge üç alan grubu tanımlıyor ve her kadroda iki koşul birden
 * arıyor: belirli indeks kademelerinden asgari YAYIN SAYISI ve Ek-2
 * tablosundan asgari PUAN. Doçentlik ve profesörlükte puan koşulu iki
 * katmanlı: bir dönem puanı (doçentlikte doktora sonrası, profesörlükte
 * doçentlik sonrası) ve bir de kariyer toplamı.
 *
 * ── YORUM KARARLARI (§0) ──
 *   Ek-2'nin 3. maddesi (lisansüstü tezlerden üretilmiş makaleler) 1. madde
 *       ile BİREBİR AYNI puanları verdiği için cetvele yazılmadı. Madde 9
 *       ve 10'un "1(a)'dan bir + 3(a)'dan bir adet" biçimindeki kolu bu
 *       yüzden değerlendirilemiyor; §0 gereği yönergenin diğer kolu
 *       (yalnız 1. maddeden üç yayın) esas alındı. Bir tez yayını ile bir
 *       tez dışı yayını olan aday koşulu sağlıyor olsa da araç bunu
 *       göremez ve sonuç OLDUĞUNDAN KATI çıkar.
 *   Madde 10'un "en az ikinci isim olmak üzere" koşulu araçta yalnız tek
 *       yazar, birinci yazar ve sorumlu yazar rolleriyle sorgulanabiliyor;
 *       §0 gereği dar okuma seçildi. İkinci yazar olduğunuz bir yayınla
 *       koşulu sağlıyorsanız araç bunu göremez.
 *   Doçentlik ölçütlerindeki EBSCO kolu (Filoloji, Güzel Sanatlar,
 *       İlahiyat ve Hukuk için "en az 2 adet EBSCO") sözlükte karşılıksız;
 *       Scopus ve TR Dizin kolları yazıldı.
 *   Madde 9/2'nin "öğretim üyesi temininde güçlük çekilen birimlerde
 *       şartlar aranmayabilir" istisnası yazılmadı.
 *   Madde 11/2 ve 12/3'ün proje koşulu, sağlanamadığında toplam puanın
 *       %10 (doçentlik) ya da %15 (profesörlük) fazlasıyla telafi
 *       ediliyor; iki kol da yazıldı.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Madde 12/1-b'nin "doçent unvanı alındıktan sonra YÖK'ün güncel
 *       doçentlik asgari ölçütlerini yeniden sağlamış olmak" koşulu temel
 *       alana ve döneme göre değiştiği için `hesaplanamiyor` düğümünde.
 *   Madde 5-7'nin ilan, başvuru ve ön değerlendirme komisyonu usulleri.
 */
$FEN = ['fen', 'muhendislik', 'saglik', 'ziraat'];
$SOSYAL = ['egitim', 'mimarlik', 'sosyal', 'spor'];
$FILOLOJI = ['filoloji', 'guzel_sanatlar', 'ilahiyat', 'hukuk'];

$TAVAN_NOTU = 'Puan tablosundaki tavanların çoğu "doçentlik öncesi ve sonrası ayrı ayrı" '
    .'uygulanıyor (25+25, 40+40, 50+50 gibi); araç tek tavan tanıdığı için bu kalemlerde '
    .'puanınız olduğundan düşük çıkar.';

$TEZ_NOTU = 'Yönerge lisansüstü tezlerden üretilmiş makaleleri ayrı bir satırda ama aynı '
    .'puanlarla sayıyor; kayıt bir yayının tez kökenli olup olmadığını tutmadığı için bu satır '
    .'cetvele yazılmadı. Yönergenin "biri tezden, biri tez dışından" kolu bu yüzden '
    .'değerlendirilemiyor; araç yalnızca diğer kolu (yayınların tamamı tez dışı sayılarak) '
    .'uyguluyor. '
    .'Bir tez yayınınız ve bir tez dışı yayınınız varsa koşulu sağlıyor olsanız da burada '
    .'sağlanmamış görünür.';

/** Madde 11/2 ve 12/3'ün proje koşulu ve puanla telafisi. */
$projeKosulu = fn (bool $profesor, int $telafiDonem, int $telafiToplam, ?array $donem, string $madde): array => Kalip::veya('Proje koşulu', array_values(array_filter([
    Kalip::adet('TÜBİTAK, TÜBA, AB, kalkınma ajansı ya da bakanlık destekli en az 1 projede yürütücü olmak', ['PROJE-YURUTUCU'], 1, donem: $donem, madde: $madde),
    $profesor ? null : Kalip::adet('Aynı kurumların desteklediği en az 2 projede araştırmacı olmak', ['PROJE-ARASTIRMACI'], 2, donem: $donem, madde: $madde),
    Kalip::ve('Proje koşulu sağlanmıyorsa toplam puan koşulunun artırılmış hâli', [
        Kalip::toplam($telafiDonem, donem: $donem),
        Kalip::toplam($telafiToplam),
    ]),
])));

$esikler = [];

foreach ([
    [
        'ad' => 'Fen Bilimleri ve Matematik, Mühendislik, Sağlık Bilimleri ile Ziraat, Orman ve Su Ürünleri',
        'anahtar' => 'fen', 'alan' => $FEN,
        'drGrup' => '1.A', 'drAdet' => 3, 'drPuan' => 350,
        'drAd' => 'SCIE ve SSCI dergilerinden (1/a)',
        'yenidenGrup' => '1.A-B', 'yenidenAdet' => 2,
        'docGrup' => '1.A-Q123', 'docAdet' => 2, 'docDonem' => 400, 'docToplam' => 750,
        'docAd' => 'SCIE veya SSCI kapsamındaki Q1, Q2 ya da Q3 dergilerde',
        'profAdet' => 3, 'profDonem' => 450, 'profToplam' => 1200,
    ],
    [
        'ad' => 'Eğitim Bilimleri, Mimarlık-Planlama-Tasarım, Sosyal-Beşerî-İdari Bilimler ve Spor Bilimleri',
        'anahtar' => 'sosyal', 'alan' => $SOSYAL,
        'drGrup' => '1.A-Ç', 'drAdet' => 3, 'drPuan' => 275,
        'drAd' => 'uluslararası makale kategorisinden (1/a, 1/b, 1/c, 1/ç)',
        'yenidenGrup' => '1.A-Ç', 'yenidenAdet' => 2,
        'docGrup' => '1.A-Q123-AHCI', 'docAdet' => 1, 'docDonem' => 325, 'docToplam' => 600,
        'docAd' => 'SCIE-SSCI\'nin Q1, Q2, Q3 dergilerinde ya da AHCI kapsamında',
        'profAdet' => 2, 'profDonem' => 350, 'profToplam' => 950,
    ],
    [
        'ad' => 'Filoloji, Güzel Sanatlar, İlahiyat ve Hukuk',
        'anahtar' => 'filoloji', 'alan' => $FILOLOJI,
        'drGrup' => '2.A-1.A-Ç', 'drAdet' => 2, 'drPuan' => 200,
        'drAd' => 'TR Dizin (2/a) ya da uluslararası makale (1/a-1/ç) kategorilerinden',
        'yenidenGrup' => '2.A-1.A-Ç', 'yenidenAdet' => 2,
        'docGrup' => 'SCOPUS', 'docAdet' => 1, 'docDonem' => 250, 'docToplam' => 450,
        'docAd' => 'Scopus kapsamında (TR Dizin kolu da geçerli)',
        'profAdet' => 2, 'profDonem' => 300, 'profToplam' => 750,
    ],
] as $g) {
    $ortak = ['universite' => 'Zonguldak Bülent Ecevit Üniversitesi', 'alan' => $g['alan'],
        'cetvel' => 'zbeu-2026'];
    $filoloji = $g['anahtar'] === 'filoloji';

    // ══ DOKTOR ÖĞRETİM ÜYELİĞİNE İLK ATANMA (MADDE 8-9) ══
    $esikler[] = array_merge($ortak, [
        'anahtar' => 'zbeu-'.$g['anahtar'].'-dr',
        'kadro' => 'dr_ogr_uyesi',
        'notlar' => 'Madde 8: doktora ya da uzmanlık, YDS/YÖKDİL\'den 60 puan. Madde 9/1: '
            .$g['drAd'].' en az '.$g['drAdet'].' yayın (birinde birinci isim) ve Ek-2\'den en az '
            .$g['drPuan'].' puan.',
        'aday_notu' => $g['ad'].' temel alanlarında doktor öğretim üyeliği için '.$g['drAd'].' en '
            .'az '.$g['drAdet'].' yayın (en az birinde birinci isim olmak üzere) ve tüm '
            .'faaliyetlerinizden '.$g['drPuan'].' puan gerekiyor. Atamalar dört yıllık yapılıyor. '
            .'Yabancı dil eşiği YDS ya da YÖKDİL\'den 60 puan; bilim alanı bir yabancı dille '
            .'ilgili olanlarda 85 puana çıkıyor, araç 60 üzerinden değerlendiriyor. '
            .$TEZ_NOTU.' '.$TAVAN_NOTU,
        'sart' => Kalip::ve('Doktor öğretim üyeliğine ilk atanma koşulları', [
            Kalip::beyan('Doktora ya da tıpta, diş hekimliğinde, eczacılıkta, veteriner hekimlikte uzmanlık veya sanatta yeterlik eğitimini tamamlamış olmak', 'Madde 8/1-b'),
            Kalip::yds(60),
            Kalip::adet($g['drAd'].' en az '.$g['drAdet'].' yayın', [$g['drGrup']], $g['drAdet'], madde: 'Madde 9/1'),
            Kalip::veya('Bu yayınlardan en az birinde birinci isim olmak', [
                Kalip::adet('Tek yazarlı en az 1 yayın', [$g['drGrup']], 1, yazar: 'tek', madde: 'Madde 9/1'),
                Kalip::adet('Birinci isim olduğunuz en az 1 yayın', [$g['drGrup']], 1, yazar: 'ilk', madde: 'Madde 9/1'),
                Kalip::adet('Sorumlu yazar olduğunuz en az 1 yayın', [$g['drGrup']], 1, yazar: 'baslica', madde: 'Madde 9/1'),
            ]),
            Kalip::toplam($g['drPuan']),
        ]),
    ]);

    // ══ YENİDEN ATANMA (MADDE 10) ══
    $esikler[] = array_merge($ortak, [
        'anahtar' => 'zbeu-'.$g['anahtar'].'-dr-yeniden',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'notlar' => 'Madde 10: bir önceki atama tarihinden sonra en az '.$g['yenidenAdet']
            .' yayın (birinde en az ikinci isim) ve Ek-2\'den en az 100 puan.',
        'aday_notu' => 'Yeniden atamada yalnızca BİR ÖNCEKİ ATAMA TARİHİNDEN SONRAKİ '
            .'faaliyetler sayılıyor: en az '.$g['yenidenAdet'].' yayın ve tüm '
            .'faaliyetlerinizden 100 puan. '
            .'Yönerge yayınların en az birinde "en az ikinci isim" olmanızı istiyor; araç bu '
            .'koşulu yalnız tek yazar, birinci yazar ve sorumlu yazar rolleriyle '
            .'sorgulayabildiği için ikinci yazar olduğunuz bir yayınla koşulu sağlıyorsanız '
            .'burada görünmez. Ölçütlerin uygulanması her adayın ilk dört yıllık atamasının '
            .'sonunda başlıyor. '.$TAVAN_NOTU,
        'sart' => Kalip::ve('Yeniden atanma koşulları', [
            Kalip::adet('Belirtilen kategorilerde en az '.$g['yenidenAdet'].' yayın', [$g['yenidenGrup']], $g['yenidenAdet'], donem: Kalip::SON_ATAMA_SONRASI, madde: 'Madde 10/1'),
            Kalip::veya('Bu yayınlardan en az birinde en az ikinci isim olmak', [
                Kalip::adet('Tek yazarlı en az 1 yayın', [$g['yenidenGrup']], 1, yazar: 'tek', donem: Kalip::SON_ATAMA_SONRASI, madde: 'Madde 10/1'),
                Kalip::adet('Birinci isim olduğunuz en az 1 yayın', [$g['yenidenGrup']], 1, yazar: 'ilk', donem: Kalip::SON_ATAMA_SONRASI, madde: 'Madde 10/1'),
                Kalip::adet('Sorumlu yazar olduğunuz en az 1 yayın', [$g['yenidenGrup']], 1, yazar: 'baslica', donem: Kalip::SON_ATAMA_SONRASI, madde: 'Madde 10/1'),
            ]),
            Kalip::toplam(100, donem: Kalip::SON_ATAMA_SONRASI),
        ]),
    ]);

    // ══ DOÇENTLİK (MADDE 11) ══
    $docMakale = $filoloji
        ? Kalip::veya('Makale koşulu', [
            Kalip::adet('Scopus kapsamındaki dergilerde en az 1 makale', ['SCOPUS'], 1, donem: Kalip::DOKTORA_SONRASI, madde: 'Madde 11/1-c'),
            Kalip::adet('TR Dizin kapsamındaki dergilerde en az 3 makale', ['2.A'], 3, donem: Kalip::DOKTORA_SONRASI, madde: 'Madde 11/1-c'),
            Kalip::adet('SCIE, SSCI, AHCI ya da ESCI kapsamındaki dergilerde en az 1 makale', ['1.A-B'], 1, donem: Kalip::DOKTORA_SONRASI, madde: 'Madde 11/1-c'),
        ])
        : Kalip::adet($g['docAd'].' en az '.$g['docAdet'].' makale', [$g['docGrup']], $g['docAdet'], donem: Kalip::DOKTORA_SONRASI, madde: 'Madde 11/1');

    $esikler[] = array_merge($ortak, [
        'anahtar' => 'zbeu-'.$g['anahtar'].'-docentlik',
        'kadro' => 'docentlik',
        'notlar' => 'Madde 11/1: doktora sonrası çalışmalardan '.$g['docAd'].' en az '
            .$g['docAdet'].' makale, asgari '.$g['docDonem'].' puan ve toplamda en az '
            .$g['docToplam'].' puan. Madde 11/2: en az 1 projede yürütücü ya da 2 projede '
            .'araştırmacı olmak; sağlanmazsa toplam puan koşulu %10 fazlasıyla aranır.',
        'aday_notu' => $g['ad'].' temel alanlarında doçent kadrosu için üç koşul birden var: '
            .$g['docAd'].' en az '.$g['docAdet'].' makale, DOKTORA SONRASI çalışmalardan '
            .$g['docDonem'].' puan ve kariyer toplamında '.$g['docToplam'].' puan. Ayrıca '
            .'TÜBİTAK, TÜBA, AB, kalkınma ajansı ya da bakanlık destekli en az bir projede '
            .'yürütücü veya iki projede araştırmacı olmanız gerekiyor; bu koşulu '
            .'sağlayamıyorsanız puan barajları %10 fazlasıyla ('.(int) round($g['docDonem'] * 1.1)
            .' ve '.(int) round($g['docToplam'] * 1.1).' puan) aranıyor. Doktor öğretim üyeliği '
            .'başvurusunda değerlendirilen bir proje doçentlik başvurusunda sayılmıyor.'
            .($filoloji ? ' Yönergenin EBSCO kolu (en az 2 EBSCO makalesi) faaliyet kaydında karşılıksız olduğu için araçta değerlendirilmiyor.' : '')
            .' '.$TAVAN_NOTU,
        'sart' => Kalip::ve('Doçentlik koşulları', [
            $docMakale,
            Kalip::toplam($g['docDonem'], donem: Kalip::DOKTORA_SONRASI),
            Kalip::toplam($g['docToplam']),
            $projeKosulu(false, (int) round($g['docDonem'] * 1.1), (int) round($g['docToplam'] * 1.1), Kalip::DOKTORA_SONRASI, 'Madde 11/2'),
        ]),
    ]);

    // ══ PROFESÖRLÜK (MADDE 12) ══
    $profMakale = $filoloji
        ? Kalip::veya('Makale koşulu', [
            Kalip::adet('Scopus kapsamındaki dergilerde en az 2 makale', ['SCOPUS'], 2, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Madde 12/2-c'),
            Kalip::adet('TR Dizin kapsamındaki dergilerde en az 4 makale', ['2.A'], 4, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Madde 12/2-c'),
            Kalip::adet('SCIE, SSCI, AHCI ya da ESCI kapsamındaki dergilerde en az 2 makale', ['1.A-B'], 2, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Madde 12/2-c'),
        ])
        : Kalip::adet($g['docAd'].' en az '.$g['profAdet'].' makale', [$g['docGrup']], $g['profAdet'], donem: Kalip::DOCENTLIK_SONRASI, madde: 'Madde 12/2');

    $esikler[] = array_merge($ortak, [
        'anahtar' => 'zbeu-'.$g['anahtar'].'-profesorluk',
        'kadro' => 'profesorluk',
        'notlar' => 'Madde 12/1: doçentlik sonrası beş yıl ve YÖK\'ün güncel doçentlik asgari '
            .'ölçütlerini yeniden sağlamak. Madde 12/2: doçentlik sonrası '.$g['docAd'].' en az '
            .$g['profAdet'].' makale, asgari '.$g['profDonem'].' puan ve toplamda en az '
            .$g['profToplam'].' puan. Madde 12/3: doçentlik sonrası en az 1 projede yürütücü '
            .'olmak; sağlanmazsa toplam puan koşulu %15 fazlasıyla aranır.',
        'aday_notu' => $g['ad'].' temel alanlarında profesörlük için doçent unvanınızı '
            .'aldıktan sonra '.$g['docAd'].' en az '.$g['profAdet'].' makale, doçentlik sonrası '
            .$g['profDonem'].' puan ve kariyer toplamında '.$g['profToplam'].' puan gerekiyor. '
            .'Doçentlikten farklı olarak proje koşulunda ARAŞTIRMACILIK yeterli değil: en az bir '
            .'projede YÜRÜTÜCÜ olmalısınız; olamıyorsanız puan barajları %15 fazlasıyla ('
            .(int) round($g['profDonem'] * 1.15).' ve '.(int) round($g['profToplam'] * 1.15)
            .' puan) aranıyor. Ayrıca doçent unvanını aldıktan sonra YÖK\'ün güncel doçentlik '
            .'asgari ölçütlerini yeniden sağlamanız gerekiyor; bu ölçütler temel alana ve '
            .'döneme göre değiştiğinden araç hesaplayamıyor. '.$TAVAN_NOTU,
        'sart' => Kalip::ve('Profesörlük koşulları', [
            Kalip::beyan('Doçent unvanının alındığı tarihten sonra en az beş yıl süreyle açık bulunan profesörlük kadrosuyla ilgili bilim ya da sanat alanında çalışmış olmak', 'Madde 12/1-a'),
            Kalip::hesaplanamiyor('Doçent unvanı alındıktan sonra YÖK tarafından belirlenen kendi alanınızla ilgili güncel doçentlik asgari ölçütlerini yeniden sağlamış olmak', 'Madde 12/1-b'),
            $profMakale,
            Kalip::toplam($g['profDonem'], donem: Kalip::DOCENTLIK_SONRASI),
            Kalip::toplam($g['profToplam']),
            $projeKosulu(true, (int) round($g['profDonem'] * 1.15), (int) round($g['profToplam'] * 1.15), Kalip::DOCENTLIK_SONRASI, 'Madde 12/3'),
        ]),
    ]);
}

return $esikler;
