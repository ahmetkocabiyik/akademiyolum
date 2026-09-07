<?php

use App\Services\Scoring\Sart\Kalip;

/*
 * PİRİ REİS ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma
 * Ölçütlerine İlişkin Senato Esasları
 * Kaynak: pdf/17634009071.Piri Reis Üniversitesi Kriter.pdf (25 sayfa)
 *         Senato 16.04.2025 / 2025-08 · Cetvel: piri-reis-2025
 *
 * DÖRT TEMEL ALAN, ÜÇ KADRO = ON İKİ EŞİK. Kaynak koşulları temel alan
 * başına ayrı yazıyor (MADDE 10 dr, MADDE 11 doçent, MADDE 12 profesör);
 * Mühendislik ile Fen'in CETVELİ aynı ama Dr. Öğr. Üyeliği barajı farklı
 * (20'ye karşı 30 puan), o yüzden eşikler ayrı duruyor.
 *
 * GİRİLEMEYEN KOŞULLAR — hepsi aday kaydının taşımadığı bir nitelik istiyor:
 *
 *   1. "EN AZ ÜÇÜ TEK YAZARLI olmak üzere farklı dergilerde beş yayın"
 *      (doçentlik, Sosyal) ve "en az dördü tek yazarlı, üç farklı dergide
 *      altı yayın" (doçentlik, Hukuk). Motor yazar rolünü tek tek satırda
 *      sınayabiliyor ama "kaçının tek yazarlı olduğu" ve "kaç FARKLI dergi"
 *      koşulunu kuramıyor; yayın sayısı koşulu olarak girildi.
 *   2. "LİSANSÜSTÜ TEZLERDEN ÜRETİLMİŞ / ÜRETİLMEMİŞ olmak" (doçentlik ve
 *      profesörlükte birkaç bent). Faaliyet kaydı yayının tezden üretilip
 *      üretilmediğini taşımıyor.
 *   3. H.1.a "h-indeksi kadar puan" — cetvele satır olarak girilemedi.
 *   4. Bilimsel seminer koşulu (MADDE 6) beyana bağlı.
 */

$UNIVERSITE = 'Piri Reis Üniversitesi';

$ORTAK_NOT = 'Puan tablosunda her çalışma yalnız BİR bölümde puanlanıyor; '
    .'aynı eseri iki kalemde birden gösteremezsiniz. Yayın puanı, makalenin '
    .'yayımlandığı YILA ait Scopus/WoS dergi dilimine göre belirleniyor. '
    .'Yönerge ayrıca son başvuru tarihinden itibaren on beş gün içinde '
    .'bilimsel seminer vermenizi istiyor; bu koşul beyana bağlı, araç '
    .'hesaplamıyor.';

$YAZARLIK_NOTU = ' Tek yazarlı yayında tam puan alıyorsunuz; iki yazarlıda '
    .'başlıca yazar tam puanın %80\'ini, üç ve daha fazla yazarlıda başlıca '
    .'yazar yarısını alıyor, kalan yarısını öteki yazarlar paylaşıyor.';

$esikler = [];

foreach ([
    ['ad' => 'Mühendislik', 'anahtar' => 'muhendislik', 'alan' => ['muhendislik'], 'cetvel' => 'muhfen', 'drPuan' => 20],
    ['ad' => 'Fen Bilimleri ve Matematik', 'anahtar' => 'fen', 'alan' => ['fen'], 'cetvel' => 'muhfen', 'drPuan' => 30],
    ['ad' => 'Sosyal, Beşeri ve İdari Bilimler', 'anahtar' => 'sosyal', 'alan' => ['sosyal', 'egitim', 'filoloji', 'ilahiyat', 'spor'], 'cetvel' => 'sosyal', 'drPuan' => 20],
    ['ad' => 'Hukuk', 'anahtar' => 'hukuk', 'alan' => ['hukuk'], 'cetvel' => 'hukuk', 'drPuan' => 20],
] as $g) {
    $sosyalTip = in_array($g['anahtar'], ['sosyal', 'hukuk'], true);
    $ortak = ['universite' => $UNIVERSITE, 'alan' => $g['alan']];

    // ── DOKTOR ÖĞRETİM ÜYESİ (MADDE 10/2) ──
    $drKollar = [];
    if ($sosyalTip) {
        $drKollar[] = Kalip::adet('Uluslararası ya da ulusal hakemli dergide en az '.($g['anahtar'] === 'hukuk' ? 1 : 2).' makale',
            ['A-B'], $g['anahtar'] === 'hukuk' ? 1 : 2, madde: 'MADDE 10/2');
        $drKollar[] = Kalip::adet('Bilimsel toplantıda en az 1 bildiri', ['BILDIRI'], 1, madde: 'MADDE 10/2');
        $drKollar[] = Kalip::adet('Kitap ya da kitap bölümü türünden en az 1 yayın', ['KITAP'], 1, madde: 'MADDE 10/2');
    } else {
        $drKollar[] = Kalip::adet('Scopus ya da WoS dilimli dergide en az 1 makale', ['A1'], 1, madde: 'MADDE 10/2');
        $drKollar[] = Kalip::adet('Bilimsel toplantıda en az 1 bildiri', ['BILDIRI'], 1, madde: 'MADDE 10/2');
    }
    $drKollar[] = Kalip::toplam($g['drPuan']);

    $esikler[] = array_merge($ortak, [
        'anahtar' => 'piri-reis-'.$g['anahtar'].'-dr',
        'kadro' => 'dr_ogr_uyesi',
        'cetvel' => 'piri-reis-2025-'.$g['cetvel'].'-dr',
        'notlar' => 'MADDE 10/2-'.($g['anahtar'] === 'muhendislik' ? 'a' : ($g['anahtar'] === 'sosyal' ? 'b' : ($g['anahtar'] === 'hukuk' ? 'c' : 'd')))
            .': '.$g['ad'].' temel alanı, toplam '.$g['drPuan'].' puan.',
        'aday_notu' => $g['ad'].' temel alanında doktor öğretim üyeliği için kriter '
            .'tablosundan toplam en az '.$g['drPuan'].' puan gerekiyor. '
            .($sosyalTip
                ? 'Ayrıca makale, bildiri ve kitap kalemlerinin her birinden en az bir esere ihtiyacınız var.'
                : 'Ayrıca Scopus ya da Web of Science dilimli bir dergide en az bir makaleniz ve en az bir bildiriniz olmalı.')
            .' '.$ORTAK_NOT.$YAZARLIK_NOTU,
        'sart' => Kalip::ve('Doktor öğretim üyeliğine atanma koşulları', $drKollar),
    ]);

    // ── DOÇENT (MADDE 11/2) ──
    $docKollar = [];
    if ($g['anahtar'] === 'hukuk') {
        $docKollar[] = Kalip::adet('Uluslararası ya da ulusal hakemli dergide en az 6 makale', ['A-B'], 6, donem: Kalip::DOKTORA_SONRASI, madde: 'MADDE 11/2-c');
        $docKollar[] = Kalip::puanDan('Bilimsel toplantı bildirilerinden en az 5 puan', ['BILDIRI'], 5, Kalip::DOKTORA_SONRASI, madde: 'MADDE 11/2-c');
        $docKollar[] = Kalip::adet('Kitap ya da kitap bölümü türünden en az 2 yayın', ['KITAP'], 2, donem: Kalip::DOKTORA_SONRASI, madde: 'MADDE 11/2-c');
        $docKollar[] = Kalip::adet('Son iki yılda iki dönem ders vermek', ['EGITIM'], 2, madde: 'MADDE 11/2-c');
        $docKollar[] = Kalip::adet('Araştırma projesi ya da diğer akademik faaliyetlerden en az 1 çalışma', ['PROJE-DIGER'], 1, madde: 'MADDE 11/2-c');
    } elseif ($g['anahtar'] === 'sosyal') {
        $docKollar[] = Kalip::puanDan('Uluslararası makalelerden en az 10 puan', ['A'], 10, Kalip::DOKTORA_SONRASI, madde: 'MADDE 11/2-b');
        $docKollar[] = Kalip::adet('TR Dizin kapsamındaki dergilerde en az 5 makale', ['B'], 5, donem: Kalip::DOKTORA_SONRASI, madde: 'MADDE 11/2-b');
        $docKollar[] = Kalip::puanDan('Bilimsel toplantı bildirilerinden en az 5 puan', ['BILDIRI'], 5, Kalip::DOKTORA_SONRASI, madde: 'MADDE 11/2-b');
        $docKollar[] = Kalip::adet('Kitap ya da kitap bölümü türünden en az 1 yayın', ['KITAP'], 1, donem: Kalip::DOKTORA_SONRASI, madde: 'MADDE 11/2-b');
        $docKollar[] = Kalip::adet('Tamamlanmış en az 1 araştırma projesinde görev', ['PROJE'], 1, madde: 'MADDE 11/2-b');
    } else {
        $docKollar[] = Kalip::puanDan('Scopus ya da WoS dilimli dergilerdeki makalelerden en az 40 puan', ['A1'], 40, Kalip::DOKTORA_SONRASI, madde: 'MADDE 11/2');
        $docKollar[] = Kalip::puanDan('Ulusal hakemli dergilerdeki makalelerden en az 10 puan', ['B'], 10, Kalip::DOKTORA_SONRASI, madde: 'MADDE 11/2');
        $docKollar[] = Kalip::puanDan('Bilimsel toplantı bildirilerinden en az 5 puan', ['BILDIRI'], 5, Kalip::DOKTORA_SONRASI, madde: 'MADDE 11/2');
        $docKollar[] = Kalip::adet('Tamamlanmış en az 1 araştırma projesinde görev', ['PROJE'], 1, madde: 'MADDE 11/2');
    }
    $docKollar[] = Kalip::toplam(100);
    $docKollar[] = Kalip::toplam(90, donem: Kalip::DOKTORA_SONRASI);

    $esikler[] = array_merge($ortak, [
        'anahtar' => 'piri-reis-'.$g['anahtar'].'-docent',
        'kadro' => 'docent',
        'cetvel' => 'piri-reis-2025-'.$g['cetvel'].'-docent',
        'notlar' => 'MADDE 11/2: '.$g['ad'].' temel alanı, toplam 100 puan (en az 90\'ı doktora sonrası).',
        'aday_notu' => $g['ad'].' temel alanında doçentlik için toplam 100 puan '
            .'gerekiyor ve bunun en az 90 puanı doktora unvanınızı aldıktan sonraki '
            .'çalışmalardan gelmeli. '
            .'Yönerge ayrıca bazı bentlerde yayının LİSANSÜSTÜ TEZDEN ÜRETİLMEMİŞ '
            .'olmasını, Sosyal ve Hukuk alanlarında da makalelerin bir bölümünün TEK '
            .'YAZARLI ve farklı dergilerde olmasını istiyor; faaliyet kaydı bu '
            .'nitelikleri taşımadığı için araç yalnız sayıyı ve puanı denetliyor, '
            .'koşulu sağlıyor görünseniz de bu ayrıntıları kendiniz doğrulayın. '
            .$ORTAK_NOT.$YAZARLIK_NOTU,
        'sart' => Kalip::ve('Doçent kadrosuna atanma koşulları', $docKollar),
    ]);

    // ── PROFESÖR (MADDE 12) ──
    $profKollar = [];
    if ($g['anahtar'] === 'hukuk') {
        $profKollar[] = Kalip::puanDan('Doçentlik sonrası makalelerden en az 50 puan', ['A-B'], 50, Kalip::DOCENTLIK_SONRASI, madde: 'MADDE 12/c');
        $profKollar[] = Kalip::adet('Doçentlik sonrası en az 3 bildiri', ['BILDIRI'], 3, donem: Kalip::DOCENTLIK_SONRASI, madde: 'MADDE 12/c');
        $profKollar[] = Kalip::adet('Kitap kaleminden en az 2 yayın', ['KITAP'], 2, madde: 'MADDE 12/c');
        $profKollar[] = Kalip::adet('En az 2 lisansüstü tez danışmanlığı ya da tez izleme jürisi üyeliği', ['TEZ'], 2, madde: 'MADDE 12/c');
        $profKollar[] = Kalip::adet('Son beş yılda dört dönem ders vermek', ['EGITIM'], 4, madde: 'MADDE 12/c');
        $profKollar[] = Kalip::adet('Araştırma projesi ya da diğer akademik faaliyetlerden en az 2 çalışma', ['PROJE-DIGER'], 2, madde: 'MADDE 12/c');
    } elseif ($g['anahtar'] === 'sosyal') {
        $profKollar[] = Kalip::adet('Doçentlik sonrası Q1-Q3 dergilerde en az 2 makale', ['A1'], 2, donem: Kalip::DOCENTLIK_SONRASI, madde: 'MADDE 12/b');
        $profKollar[] = Kalip::adet('En az 5 bildiri', ['BILDIRI'], 5, madde: 'MADDE 12/b');
        $profKollar[] = Kalip::adet('Kitap kaleminden en az 2 yayın', ['KITAP'], 2, madde: 'MADDE 12/b');
        $profKollar[] = Kalip::adet('En az 2 lisansüstü tez danışmanlığı ya da tez izleme jürisi üyeliği', ['TEZ'], 2, madde: 'MADDE 12/b');
        $profKollar[] = Kalip::adet('Son beş yılda dört dönem ders vermek', ['EGITIM'], 4, madde: 'MADDE 12/b');
        $profKollar[] = Kalip::adet('Tamamlanmış en az 2 araştırma projesinde görev', ['PROJE'], 2, madde: 'MADDE 12/b');
    } else {
        $profKollar[] = Kalip::puanDan('Doçentlik sonrası Q1-Q3 dergilerdeki makalelerden en az 40 puan', ['A1'], 40, Kalip::DOCENTLIK_SONRASI, madde: 'MADDE 12');
        $profKollar[] = Kalip::adet('En az 5 bildiri', ['BILDIRI'], 5, madde: 'MADDE 12');
        $profKollar[] = Kalip::adet('En az 2 lisansüstü tez danışmanlığı ya da tez izleme jürisi üyeliği', ['TEZ'], 2, madde: 'MADDE 12');
        $profKollar[] = Kalip::adet('Son beş yılda dört dönem ders vermek', ['EGITIM'], 4, madde: 'MADDE 12');
        $profKollar[] = Kalip::adet('Tamamlanmış en az 2 araştırma projesinde görev', ['PROJE'], 2, madde: 'MADDE 12');
    }
    $profKollar[] = Kalip::toplam(200);
    $profKollar[] = Kalip::toplam(100, donem: Kalip::DOCENTLIK_SONRASI);

    $esikler[] = array_merge($ortak, [
        'anahtar' => 'piri-reis-'.$g['anahtar'].'-profesorluk',
        'kadro' => 'profesorluk',
        'cetvel' => 'piri-reis-2025-'.$g['cetvel'].'-profesor',
        'notlar' => 'MADDE 12: '.$g['ad'].' temel alanı, toplam 200 puan (en az 100\'ü doçentlik sonrası).',
        'aday_notu' => $g['ad'].' temel alanında profesörlük için toplam 200 puan '
            .'gerekiyor ve bunun en az 100 puanı doçentlik unvanınızı aldıktan sonraki '
            .'çalışmalardan gelmeli. Yayınlarınızdan birini başlıca araştırma eseri '
            .'olarak göstermeniz de isteniyor; bu beyana bağlı, araç denetlemiyor. '
            .'Bildiri koşulunda kaynağın "en az üçü doçentlik sonrası" ayrıntısı '
            .'araca girilemedi; sayı denetleniyor, dönem dağılımını kendiniz '
            .'doğrulayın. '.$ORTAK_NOT.$YAZARLIK_NOTU,
        'sart' => Kalip::ve('Profesör kadrosuna atanma koşulları', $profKollar),
    ]);
}

return $esikler;
