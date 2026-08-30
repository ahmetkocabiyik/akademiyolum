<?php

use App\Services\Scoring\Sart\Kalip;

/**
 * SİİRT ÜNİVERSİTESİ — Akademik Yükseltilme ve Atanma Kriterleri Yönergesi
 * Kaynak: pdf/17634009071.Siirt Üniversitesi Kriter.pdf
 * (06.01.2025 ve 26.02.2025 tarihli Senato kararlarıyla değişik)
 *
 * Cetvel: cetvel/siirt-2025.php
 *
 * ── EŞİKLERİN YAPISI ──
 * Sayısal baraj yalnızca doktor öğretim üyeliğinde (Fen ve Sağlıkta 40,
 * Sosyal ve Eğitimde 30 puan) ve profesörlükte (doçentlik sonrası 150
 * puan, yarısı yayınlardan) var. Doçentlikte (MADDE 7) tek koşul ÜAK
 * doçentlik unvanı. Yeniden atamada yıllık puan ORTALAMASI aranıyor.
 *
 * ── YORUM KARARLARI (§0) ──
 *   MADDE 5/b yalnız iki alan grubu adlandırıyor: "Fen ve Sağlık
 *       Bilimleri" (40 puan) ile "Sosyal ve Eğitim Bilimleri" (30 puan).
 *       Filoloji, İlahiyat, Hukuk, Spor ve Güzel Sanatlar temel alanları
 *       Türkiye'deki yerleşik fen-sosyal ayrımına göre ikinci gruba,
 *       Mimarlık ise birinci gruba bağlandı.
 *   Ek-I'in 1. maddesindeki "bu alandan en az 8 puan almış olmak
 *       zorunludur" dipnotu ayrı bir makale barajı olarak yazıldı.
 *   MADDE 6'nın yeniden atama koşulu YIL BAŞINA ortalama puan istiyor;
 *       araç iki atama arasındaki yıl sayısını bilmediği için koşul
 *       `hesaplanamiyor` düğümünde duruyor. MADDE 6/b'nin "doçent unvanı
 *       alanlar için bu kriterler aranmaz" muafiyeti belgeye değil
 *       doğrudan unvana bağlı olduğu için alternatif kol olarak yazıldı.
 *   MADDE 5/ç'nin Tıp ve Diş Hekimliği fakülteleri için puan şartını
 *       kaldırabilen istisnası yazılmadı.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 5/c'nin deneme dersi komisyonu koşulu beyan olarak eklendi.
 *   MADDE 8/c ve 8/ç'nin jüri raporu ve aday sıralaması hükümleri.
 *   EK-2'nin sanat bölümleri cetvele girilemediği için Güzel Sanatlar
 *       adayının 30 puanlık barajı yalnızca Ek-I kalemlerinden hesaplanıyor.
 */
$FEN = ['fen', 'muhendislik', 'ziraat', 'saglik', 'mimarlik'];
$SOSYAL = ['sosyal', 'egitim', 'filoloji', 'ilahiyat', 'hukuk', 'spor', 'guzel_sanatlar'];

$MAKALE_NOTU = 'Cetvelin makale satırının dipnotu ayrıca "bu alandan en az 8 puan almış olmak '
    .'zorunludur" diyor; yani puanınızın bir bölümü mutlaka makalelerden gelmeli.';

$EK2_NOTU = 'Yönergenin sanat eki (sinema, plastik sanatlar, tasarım, geleneksel Türk sanatları, '
    .'müzik, dans ve halk dansları) araca girilemedi: her bölüm ayrı bir sanat dalına kilitli, '
    .'koşullar "tüm şartlar zorunludur" biçiminde kurgulanmış ve puanlar tek esere değil '
    .'dosyanın tamamına veriliyor. Güzel Sanatlar alanından başvuruyorsanız sanatsal '
    .'etkinlikleriniz burada sayılmıyor.';

$esikler = [];

foreach ([
    ['ad' => 'Fen, Sağlık, Mühendislik, Ziraat ve Mimarlık', 'anahtar' => 'fen', 'alan' => $FEN,
        'dr' => 40, 'yil' => 20],
    ['ad' => 'Sosyal, Eğitim, Filoloji, İlahiyat, Hukuk, Spor ve Güzel Sanatlar', 'anahtar' => 'sosyal',
        'alan' => $SOSYAL, 'dr' => 30, 'yil' => 15],
] as $g) {
    $ortak = ['universite' => 'Siirt Üniversitesi', 'alan' => $g['alan'], 'cetvel' => 'siirt-2025'];
    $sanatEk = $g['anahtar'] === 'sosyal' ? ' '.$EK2_NOTU : '';

    $esikler[] = array_merge($ortak, [
        'anahtar' => 'siirt-'.$g['anahtar'].'-dr',
        'kadro' => 'dr_ogr_uyesi',
        'notlar' => 'MADDE 5: doktora, tıpta uzmanlık ya da sanatta yeterlik derecesi; Ek-I ve '
            .'Ek-II\'den en az '.$g['dr'].' puan; deneme dersi komisyonundan olumlu görüş. '
            .'Ek-I 1. madde dipnotu: makalelerden en az 8 puan.',
        'aday_notu' => $g['ad'].' alanlarında doktor öğretim üyeliği için bilimsel ve sanatsal faaliyet '
            .'cetvellerinden '
            .'toplam '.$g['dr'].' puan gerekiyor. '.$MAKALE_NOTU.' Ayrıca başvurduğunuz birimin '
            .'kuracağı üç kişilik komisyona deneme dersi vermeniz ve en az iki jüri üyesinden '
            .'olumlu görüş almanız gerekiyor.'.$sanatEk,
        'sart' => Kalip::ve('Doktor öğretim üyeliği koşulları', [
            Kalip::beyan('Doktora, tıpta uzmanlık ya da sanatta yeterlik derecesi almış veya Üniversitelerarası Kurulca denkliği kabul edilmiş olmak', 'MADDE 5/1-a'),
            Kalip::toplam(8, maddeler: ['MAKALE'], liste: 'Makale'),
            Kalip::toplam($g['dr']),
            Kalip::beyan('Başvurulan birimin kurduğu üç kişilik komisyona sunulan deneme dersinden en az iki jüri üyesinin olumlu görüşünü almak', 'MADDE 5/1-c'),
        ]),
    ]);

    $esikler[] = array_merge($ortak, [
        'anahtar' => 'siirt-'.$g['anahtar'].'-dr-yeniden',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'notlar' => 'MADDE 6/a: iki atama arası sürede yıl başına ortalama en az '.$g['yil']
            .' puan. MADDE 6/b: doçent unvanı alanlarda bu kriterler aranmaz. MADDE 4/2: süre '
            .'hesabında fiili çalışma süresi esas alınır.',
        'aday_notu' => 'Yeniden atamada yönerge, iki atama arasındaki sürede YIL BAŞINA ortalama '
            .'en az '.$g['yil'].' puan istiyor. Araç iki atama arasındaki yıl sayısını '
            .'bilmediği için bu ortalamayı hesaplayamıyor; son atamanızdan bu yana topladığınız '
            .'puanı geçen yıl sayısına bölerek kendiniz kontrol etmeniz gerekiyor. Süre '
            .'hesabında fiili çalışma süreniz esas alınıyor. Doçent unvanını almışsanız bu '
            .'kriterler hiç aranmıyor.',
        'sart' => Kalip::veya('Yeniden atama koşulları', [
            Kalip::beyan('Doçent unvanını almış olmak (bu durumda yeniden atama kriterleri aranmaz)', 'MADDE 6/b'),
            Kalip::hesaplanamiyor('İki atama arası sürede kendi alanınızda yaptığınız faaliyetlerden yıl başına ortalama en az '.$g['yil'].' puan almış olmak', 'MADDE 6/a'),
        ]),
    ]);

    $esikler[] = array_merge($ortak, [
        'anahtar' => 'siirt-'.$g['anahtar'].'-profesorluk',
        'kadro' => 'profesorluk',
        'notlar' => 'MADDE 8/b: doçent unvanı aldıktan sonra en az 150 puanlık akademik etkinlik; '
            .'bu puanın yarısı (75) makale ve kitaptan sağlanmalı.',
        'aday_notu' => 'Profesörlük için doçent unvanınızı aldıktan sonra 150 puan toplamanız ve '
            .'bunun EN AZ YARISINI (75 puan) yayınlardan, yani makale ve kitap kalemlerinden '
            .'sağlamanız gerekiyor. Atıf, proje, tez danışmanlığı, editörlük, bildiri ve idari '
            .'görev puanlarınız 150 puanlık toplama giriyor ama 75 puanlık yayın payına '
            .'sayılmıyor.'.$sanatEk,
        'sart' => Kalip::ve('Profesörlük koşulları', [
            Kalip::toplam(150, donem: Kalip::DOCENTLIK_SONRASI),
            Kalip::toplam(75, donem: Kalip::DOCENTLIK_SONRASI, maddeler: ['YAYIN'], liste: 'Makale, kitap ve editörlük'),
        ]),
    ]);
}

$esikler[] = [
    'anahtar' => 'siirt-docentlik',
    'universite' => 'Siirt Üniversitesi',
    'kadro' => 'docentlik',
    'alan' => [...$FEN, ...$SOSYAL],
    'cetvel' => 'siirt-2025',
    'notlar' => 'MADDE 7: tek koşul, YÖK tarafından doçentlik için belirlenen asgari başvuru '
        .'koşullarını yerine getirmiş ve doçent unvanını almış olmak. Üniversite ayrıca puan '
        .'barajı koymuyor.',
    'aday_notu' => 'Siirt Üniversitesinde doçent kadrosuna atanmak için yönergenin koyduğu tek '
        .'koşul, YÖK tarafından doçentlik için belirlenen asgari başvuru koşullarını yerine '
        .'getirmiş ve doçent unvanını almış olmak. Üniversite bu kadroda ayrı bir puan barajı '
        .'aramıyor.',
    'sart' => Kalip::beyan('Yükseköğretim Kurulu tarafından doçentlik için belirlenen asgari başvuru koşullarını yerine getirmiş ve doçent unvanını almış olmak', 'MADDE 7'),
];

return $esikler;
