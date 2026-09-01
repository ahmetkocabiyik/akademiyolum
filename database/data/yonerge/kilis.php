<?php

/**
 * KİLİS 7 ARALIK ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma
 * Yönergesi
 * Kaynak: pdf/17537001432.kilis7aralikuniverstesi.pdf
 *         (04/12/2018 ve 28/02/2019 senato değişiklikleriyle)
 *
 * DR. ÖĞR. ÜYELİĞİNDE KOŞUL "YA MAKALE SAYISI YA PUAN" BİÇİMİNDE — korpusta
 * ender bir alternatif. Aday ya belirli sayıda makale gösteriyor ya da
 * çizelgeden puan topluyor; ikisi birden aranmıyor:
 *   Fen ve Sağlık      SCI/SCI-E/AHCI'de birinci isim 1 makale
 *                      YA DA aynı gruptan birinci isim olmayan 2 makale
 *                      YA DA 1-6. maddelerden 50 puan
 *   Sosyal ve Spor     uluslararası hakemli dergide birinci isim 1 makale
 *                      YA DA ulusal hakemli dergide birinci isim 2 makale
 *                      YA DA 1-6. maddelerden 50 puan
 *
 * DOÇENTLİKTE PUAN KOŞULU YOK (Madde 9): yönerge yalnızca 2547 sayılı Kanunun
 * 24'üncü maddesindeki şartları arıyor.
 *
 * PROFESÖRLÜKTE ALAN AYRIMI YOK (Madde 12): doçentlik sonrası beş yıl içinde
 * 1-6. maddelerden en az 40 puan almak kaydıyla toplam 100 puan.
 *
 * DENEME DERSİ KOŞULU BEYAN (Madde 7/4): ilk kez atanacak adayın komisyon
 * önünde deneme dersi vermesi ve gözlem formundan en az 75 puan alması
 * gerekiyor. Bu bir sınav sonucu olduğu için beyan olarak duruyor.
 *
 * SANAT VE TASARIM DALLARI 01.09.2026'DA AÇILDI. Koşul (Madde 7/3-c) çizelgenin
 * sanatsal bölümlerini sayıyor; o bölümler "puan sütunu ayrıştırılamadı" diye
 * kayıtlıydı ve alan hiç girilmemişti. Bölümler okunup cetvele girildi.
 *
 * SAYILAN KÜME TABLONUN SANAT KISMININ TAMAMI DEĞİL. Madde 7/3-c "9, 10, 11,
 * 12, 13, 14, 15, 16, 17, 20, 21, 25, 26, 27, 28, 29, 30, 31, 32, 33 ve 34"
 * diye tek tek sayıyor: 18 (festival), 19 (belge çözümlenmesi), 22 (sanatsal
 * ödüller), 23 (yarışma jüri üyeliği) ve 24 (tiyatro çalışmaları) LİSTEDE YOK.
 * Grup birebir bu numaralardan kuruldu; atlanan bölümler yalnız genel toplama
 * giriyor.
 *
 * KOŞULUN İLK ŞIKKI GİRİLMEDİ: 7/3-c "mesleki yayın ve bildirilerden en az 30
 * puan VE sanat ve tasarım yapıtlarından en az 40 puan" alternatifini de
 * tanıyor, ama "mesleki yayın ve bildiri" hangi çizelge bölümleri demek
 * söylenmiyor. Bir `veya` kolunu tahminle yazmak barajı olduğundan KOLAY
 * gösterirdi; §0 uyarınca yalnızca numaralarla tanımlı ikinci şık girildi ve
 * ilki aday notunda anıldı. Yani eşik gerçekte olduğundan zor görünebilir.
 *
 * YENİDEN ATANMA GİRİLMEDİ: koşullar "bir önceki atanma tarihinden sonra"
 * penceresine bağlı; atama tarihi profilde tutulmuyor.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/kilis-2019.php
 */

use App\Services\Scoring\Sart\Kalip;

$DOC = Kalip::DOCENTLIK_SONRASI;

$fenGrubu = ['fen', 'muhendislik', 'mimarlik', 'saglik', 'ziraat'];
$sosyalGrubu = ['sosyal', 'egitim', 'hukuk', 'ilahiyat', 'filoloji', 'spor'];
$tumAlanlar = [...$fenGrubu, ...$sosyalGrubu, 'guzel_sanatlar'];

$sanatNotu = 'Sanat ve Tasarım Dallarındaysanız aşağıdaki Güzel Sanatlar eşiğine bakın; '
    .'o alanın koşulu çizelgenin sanatsal bölümlerini sayıyor.';

$sanatSecenegi = 'KOŞULUN İKİ ŞIKKINDAN BİRİ BURADA GÖRÜNMÜYOR: yönerge "mesleki yayın ve '
    .'bildirilerden en az 30 puan VE sanat ve tasarım yapıtlarından en az 40 puan" '
    .'alternatifini de tanıyor, ama "mesleki yayın ve bildiri" ile hangi çizelge '
    .'bölümlerinin kastedildiğini söylemiyor. Tahmine dayalı bir kol barajı olduğundan '
    .'kolay gösterirdi; bu yüzden yalnızca numaralarla tanımlı şık yazıldı. Eşiği '
    .'sağlayamıyor görünüyorsanız bu alternatifi kendiniz kontrol edin.';

$yenidenAtamaNotu = 'Yeniden atanmada koşullar bir önceki atanma tarihinden sonraki '
    .'çalışmalara bakıyor (makale, kitap, bildiri, atıf, proje yürütücülüğü ve konferans kalemlerinden 40 puan ya '
    .'da belirli sayıda makale). Atama '
    .'tarihi burada tutulmadığı için yeniden atanma eşiği girilmedi.';

return [
    // ══════════ DR. ÖĞRETİM ÜYESİ (ilk atama, Madde 7/3) ══════════
    [
        'anahtar' => 'kilis-dr-fen',
        'aday_notu' => 'Koşul "YA makale sayısı YA puan" biçiminde: aşağıdaki üç seçenekten '
            .'herhangi birini sağlamanız yeterli, üçünü birden sağlamanız gerekmiyor. '
            .$yenidenAtamaNotu.' '.$sanatNotu,
        'universite' => 'Kilis 7 Aralık Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $fenGrubu,
        'cetvel' => 'kilis-2019',
        'notlar' => 'Madde 7/3-a: SCI, SCI-Expanded veya AHCI dergide birinci isim 1 makale ya '
            .'da aynı gruptan 2 makale ya da çizelgenin makale, kitap, bildiri, atıf, proje yürütücülüğü ve konferans kalemlerinden '
            .'en az 50 puan.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Fen ve Sağlık Bilimleri', [
            Kalip::veya('Aşağıdaki seçeneklerden birini sağlamak', [
                Kalip::adet('SCI, SCI-Expanded veya AHCI dergide birinci isim olarak en az 1 makale',
                    ['SCI_MAKALE'], 1, 'ilk', madde: 'Madde 7/3-a'),
                Kalip::adet('SCI, SCI-Expanded veya AHCI dergide en az 2 makale',
                    ['SCI_MAKALE'], 2, madde: 'Madde 7/3-a'),
                Kalip::puanDan('Makale, kitap, bildiri, atıf, proje ve konferans kalemlerinizden '
                    .'en az 50 puan', ['1-6'], 50, madde: 'Madde 7/3-a'),
            ]),
            Kalip::beyan('Deneme dersi değerlendirme komisyonu önünde deneme dersi vermek ve '
                .'gözlem formundan en az 75 puan almak', 'Madde 7/4'),
        ]),
    ],
    [
        'anahtar' => 'kilis-dr-sosyal',
        'aday_notu' => 'Koşul "YA makale sayısı YA puan" biçiminde: aşağıdaki üç seçenekten '
            .'herhangi birini sağlamanız yeterli. '.$yenidenAtamaNotu.' '.$sanatNotu,
        'universite' => 'Kilis 7 Aralık Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $sosyalGrubu,
        'cetvel' => 'kilis-2019',
        'notlar' => 'Madde 7/3-b: uluslararası hakemli dergide birinci isim 1 makale ya da '
            .'ulusal hakemli dergide birinci isim 2 makale ya da çizelgenin '
            .'makale, kitap, bildiri, atıf, proje yürütücülüğü ve konferans '
            .'kalemlerinden en az 50 puan.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Sosyal Bilimler, Beden Eğitimi ve Spor', [
            Kalip::veya('Aşağıdaki seçeneklerden birini sağlamak', [
                Kalip::adet('Uluslararası hakemli dergide birinci isim olarak en az 1 makale',
                    ['ULUSLARARASI_MAKALE'], 1, 'ilk', madde: 'Madde 7/3-b'),
                Kalip::adet('Ulusal hakemli dergide birinci isim olarak en az 2 makale',
                    ['ULUSAL_MAKALE'], 2, 'ilk', madde: 'Madde 7/3-b'),
                Kalip::puanDan('Makale, kitap, bildiri, atıf, proje ve konferans kalemlerinizden '
                    .'en az 50 puan', ['1-6'], 50, madde: 'Madde 7/3-b'),
            ]),
            Kalip::beyan('Deneme dersi değerlendirme komisyonu önünde deneme dersi vermek ve '
                .'gözlem formundan en az 75 puan almak', 'Madde 7/4'),
        ]),
    ],

    [
        'anahtar' => 'kilis-dr-sanat',
        'aday_notu' => 'Sanat ve Tasarım Dallarında baraj öteki alanlardan FARKLI bir kümeyi '
            .'sayıyor: sergi, koleksiyon, müzik, film, tasarım, mimarlık yarışmaları ve '
            .'ödül-patent bölümleri. Makale ve bildiri puanınız bu barajı doldurmuyor. '
            .$sanatSecenegi.' '.$yenidenAtamaNotu,
        'universite' => 'Kilis 7 Aralık Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'kilis-2019',
        'notlar' => 'Madde 7/3-c: çizelgenin 9, 10, 11, 12, 13, 14, 15, 16, 17, 20, 21, 25, 26, '
            .'27, 28, 29, 30, 31, 32, 33 ve 34 numaralı maddelerinden en az 50 puan.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Sanat ve Tasarım Dalları', [
            Kalip::puanDan('Sergi, koleksiyon, müzik, film, sahne ve tasarım kalemlerinizden '
                .'en az 50 puan', ['9-34'], 50, madde: 'Madde 7/3-c'),
            Kalip::beyan('Deneme dersi değerlendirme komisyonu önünde deneme dersi vermek ve '
                .'gözlem formundan en az 75 puan almak', 'Madde 7/4'),
        ]),
    ],

    // ══════════ DOÇENT (Madde 9 — puan koşulu yok) ══════════
    [
        'anahtar' => 'kilis-docent',
        'aday_notu' => 'Kilis 7 Aralık yönergesi doçentlik için puan koşulu koymuyor; yalnızca '
            .'yalnızca 2547 sayılı Kanunun 24\'üncü maddesindeki şartları arıyor. Burada baraj '
            .'görmüyorsunuz — eksik veri değil, yönergede öyle.',
        'universite' => 'Kilis 7 Aralık Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $tumAlanlar,
        'cetvel' => 'kilis-2019',
        'notlar' => 'Madde 9: 2547 sayılı Kanunun 24\'üncü maddesindeki şartlara sahip olmak.',
        'sart' => Kalip::ve('Doçent — Kilis 7 Aralık Üniversitesi', [
            Kalip::beyan('2547 sayılı Kanunun 24\'üncü maddesindeki şartları taşımak ve doçentlik '
                .'unvanını almış olmak', 'Madde 9'),
        ]),
    ],

    // ══════════ PROFESÖR (Madde 12) ══════════
    [
        'anahtar' => 'kilis-profesor',
        'aday_notu' => 'Puanların tamamı doçentlik unvanınızı aldıktan sonraki beş yıl içindeki '
            .'çalışmalarınızdan gelmeli. '.$sanatNotu,
        'universite' => 'Kilis 7 Aralık Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $tumAlanlar,
        'cetvel' => 'kilis-2019',
        'notlar' => 'Madde 12: doçentlik sonrası çizelgenin 1-6. maddelerinden en az 40 puan '
            .'almak kaydıyla toplam en az 100 puan.',
        'sart' => Kalip::ve('Profesör — Kilis 7 Aralık Üniversitesi', [
            Kalip::toplam(100, $DOC),
            Kalip::puanDan('Makale, kitap, bildiri, atıf, proje ve konferans kalemlerinizden '
                .'en az 40 puan', ['1-6'], 40, $DOC, madde: 'Madde 12'),
            Kalip::beyan('Doçentlik unvanını aldıktan sonra en az beş yıl açık bulunan '
                .'profesörlük kadrosuyla ilgili bilim alanında çalışmış olmak', 'Madde 12'),
        ]),
    ],
];
