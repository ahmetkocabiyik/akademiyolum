<?php

use App\Services\Scoring\Sart\Kalip;

/**
 * İSTANBUL AREL ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma
 * Yönergesi ve Ek Atanma Kriterleri
 * Kaynak: pdf/17537098882.istanbulareluniversitesi.pdf (12 sayfa;
 * Senato 18.07.2018)
 *
 * Cetvel: cetvel/istanbul-arel-2018.php
 *
 * ── EŞİKLERİN YAPISI ──
 * "Ek Atanma Kriterleri" sayfası dört alan grubu tanımlıyor: Sosyal
 * Bilimler; Fen, Mühendislik ve Sağlık Bilimleri; Mimarlık; Güzel
 * Sanatlar. Sosyal ile Fen-Mühendislik-Sağlık doktor öğretim üyeliği ve
 * doçentlikte AYNI sayıları taşıyor, ayrışma yalnız profesörlükte
 * (500'e karşı 700 puan ve A1a'dan bir yayına karşı iki yayın).
 *
 *   Doktor öğretim üyesi   Sosyal / Fen-Müh-Sağlık: A veya C grubundan 2
 *                          özgün araştırma makalesi + 100 puan
 *                          Mimarlık: 1 özgün makale + 100 puan
 *                          Güzel Sanatlar: S veya T'den 80 + 100 puan
 *   Doçent                 Sosyal / Fen-Müh-Sağlık: 350 puan
 *                          Mimarlık: 150 puan
 *                          Güzel Sanatlar: S veya T'den 100 + 150 puan
 *   Profesör               Sosyal: son beş yılda A1a'dan 1 yayın ya da
 *                              K1-K4'te bir proje yürütücülüğü + 500 puan
 *                          Fen-Müh-Sağlık: aynı koşul iki yayınla + 700
 *                          Mimarlık: son beş yılda A veya B grubundan 2
 *                              yayın + 150 puan
 *                          Güzel Sanatlar: doçentlik sonrası S veya T'den
 *                              200 + 300 puan
 *
 * ── YORUM KARARLARI (§0) ──
 *   YÖNERGE DÖRT ALAN GRUBU SAYIYOR, kayıt on iki temel alan taşıyor.
 *       Ziraat, Fen-Mühendislik-Sağlık grubuna; Eğitim, İlahiyat, Hukuk,
 *       Filoloji ve Spor Sosyal Bilimler grubuna bağlandı. Ziraat için
 *       §0 uyarınca daha YÜKSEK olan grup seçildi (profesörlükte 700
 *       puan ve iki A1a yayını).
 *   Profesörlükteki "son beş yıl içerisinde" kaydı `Kalip::sonYil(5)`
 *       penceresiyle yazıldı. Toplam puan barajına dönem kısıtı
 *       konmuyor; yönerge yalnız yayın/proje koşulunu beş yılla
 *       sınırlıyor.
 *   Güzel Sanatlar profesörlüğünde "doçent unvanı alındıktan sonra"
 *       kaydı yalnız S/T payına yazılı; 300 puanlık toplam bütün
 *       faaliyetlerden sayılıyor (yönergenin cümle kuruluşu böyle).
 *   Mimarlık profesörlüğünde "A veya B grubundan 2 adet yayın" derken
 *       yayın türü belirtilmediği için A ve B'nin bütün satırları
 *       sayılıyor (kitap bölümü ve çeviri dâhil).
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 5/a (657 sayılı Kanunun 48. maddesindeki genel şartlar) ve
 *       5/b (yurt dışında alınan unvanların YÖK eşdeğerliği).
 *   MADDE 6, 7, 8, 10, 11, 14, 16, 18, 19, 20: aday araştırma, aday
 *       inceleme komitesi, ilan, başvuru ve atama süreçleri.
 *   MADDE 15: doçent kadrolarına sözlü sınav şartı ancak "ek koşullar
 *       arasında yer alması hâlinde" uygulanıyor; koşullu.
 *   MADDE 21: Senatonun ek şart getirebilmesi ve rektörün zorunlu
 *       hâllerde bu şartları aramadan atama yapabilmesi.
 *   MADDE 22 (bir yıllık iş sözleşmesi), MADDE 23 (unvanların kurum
 *       dışında kullanımı), MADDE 24 (jüri görevlendirmeleri).
 *   Yönerge yabancı dil için ayrı bir baraj koymuyor.
 */
$SOSYAL = ['sosyal', 'egitim', 'ilahiyat', 'hukuk', 'filoloji', 'spor'];
$FEN = ['fen', 'muhendislik', 'saglik', 'ziraat'];

$PUAN_NOTU = 'Tablo makale puanlarının derginin IMPACT FAKTÖRÜYLE çarpılmasını istiyor; kayıt '
    .'etki faktörünü tutmadığı için puanlar tablo değerinden sayılıyor. Patent başvuruları, '
    .'faydalı model, organizasyon başkanlığı, TÜBİTAK görevlendirmeleri ve lisansüstü tezden '
    .'üretilmiş yayın için tabloda satır yok. Ders puanı haftalık ders SAATİ başına verildiği '
    .'hâlde ders başına tek puan sayılıyor. Tabloda ulusal kitap yazarlığı satırı bulunmadığı '
    .'için Türkçe kitabınız da uluslararası kitap satırından (60) sayılıyor ve puanınız o '
    .'kalemde yüksek görünebilir.';

$drOrtak = fn (int $makale): array => [
    Kalip::beyan('Doktora ya da tıpta, diş hekimliğinde, eczacılıkta veya veteriner hekimlikte uzmanlık unvanını almış olmak', 'MADDE 9'),
    Kalip::adet('Değerlendirme tablosunun A veya C grubundan özgün araştırma makalesi', ['AC-OZGUN'], $makale, madde: 'Ek Atanma Kriterleri — Dr. Öğretim Üyeliği'),
    Kalip::toplam(100, maddeler: ['TUM'], liste: 'Değerlendirme Ölçütleri Puanlama Tablosu'),
];

$profOrtak = [
    Kalip::beyan('Doçentlik unvanını aldıktan sonra en az beş yıl açık bulunan profesörlük kadrosuyla ilgili bilim alanında çalışmış olmak', 'MADDE 17/a'),
    Kalip::beyan('Kendi bilim alanında uluslararası düzeyde orijinal eserler vermiş olmak ve uygulama alanı bulunan dallarda uygulamaya yönelik çalışmalarda bulunmak', 'MADDE 17/a'),
];

$profYayinVeyaProje = fn (int $yayin): array => [
    Kalip::veya('Son beş yılda SCI-Expanded, SSCI ya da AHCI yayını, ya da proje yürütücülüğü', [
        Kalip::adet('Son beş yılda SCI-Expanded, SSCI ya da AHCI dergisinde yayın', ['A1A'], $yayin, donem: Kalip::sonYil(5), madde: 'Ek Atanma Kriterleri — Profesörlük'),
        Kalip::adet('Son beş yılda K1, K2, K3 ya da K4 gruplarından en az bir projede yürütücü olmak', ['K1-4-YURUTUCU'], 1, donem: Kalip::sonYil(5), madde: 'Ek Atanma Kriterleri — Profesörlük'),
    ]),
];

$docentBeyani = Kalip::beyan('Doçentlik unvanını almış olmak ya da yurt dışında alınan doçentlik unvanının Üniversitelerarası Kurul tarafından Türkiye\'de geçerli sayılmış olması', 'MADDE 13');

return [
    // ── Sosyal Bilimler ──
    [
        'anahtar' => 'istanbul-arel-sosyal-dr',
        'universite' => 'İstanbul Arel Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $SOSYAL,
        'birim' => null,
        'cetvel' => 'istanbul-arel-2018',
        'notlar' => 'Ek Atanma Kriterleri: A veya C grubundan en az 2 özgün araştırma makalesi ve '
            .'toplamda en az 100 puan.',
        'aday_notu' => 'İki özgün araştırma makalesinin A (uluslararası) ya da C (ulusal) '
            .'grubundan olması yeterli; derleme, editöre mektup ve vaka raporu bu sayıya '
            .'girmiyor. '.$PUAN_NOTU,
        'sart' => Kalip::ve('Doktor öğretim üyesi koşulları', $drOrtak(2)),
    ],
    [
        'anahtar' => 'istanbul-arel-sosyal-docentlik',
        'universite' => 'İstanbul Arel Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $SOSYAL,
        'birim' => null,
        'cetvel' => 'istanbul-arel-2018',
        'notlar' => 'Ek Atanma Kriterleri: Değerlendirme Ölçütleri Puanlama Tablosunda toplamda en '
            .'az 350 puan.',
        'aday_notu' => 'Doçentlikte tek sayısal koşul 350 puan; yönerge yayın türü ya da dönem '
            .'kısıtı koymuyor. '.$PUAN_NOTU,
        'sart' => Kalip::ve('Doçent kadrosuna atanma koşulları', [
            $docentBeyani,
            Kalip::toplam(350, maddeler: ['TUM'], liste: 'Değerlendirme Ölçütleri Puanlama Tablosu'),
        ]),
    ],
    [
        'anahtar' => 'istanbul-arel-sosyal-profesorluk',
        'universite' => 'İstanbul Arel Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $SOSYAL,
        'birim' => null,
        'cetvel' => 'istanbul-arel-2018',
        'notlar' => 'Ek Atanma Kriterleri: son beş yıl içinde A1a\'dan en az 1 yayın ya da K1-K4 '
            .'gruplarından en az bir projede yürütücülük; toplamda en az 500 puan.',
        'aday_notu' => 'Yayın ve proje koşulu birbirinin alternatifi; ikisi de son beş yılla '
            .'sınırlı. 500 puanlık toplama dönem kısıtı yok. '.$PUAN_NOTU,
        'sart' => Kalip::ve('Profesör kadrosuna atanma koşulları', [
            ...$profOrtak,
            ...$profYayinVeyaProje(1),
            Kalip::toplam(500, maddeler: ['TUM'], liste: 'Değerlendirme Ölçütleri Puanlama Tablosu'),
        ]),
    ],

    // ── Fen, Mühendislik ve Sağlık Bilimleri ──
    [
        'anahtar' => 'istanbul-arel-fen-dr',
        'universite' => 'İstanbul Arel Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $FEN,
        'birim' => null,
        'cetvel' => 'istanbul-arel-2018',
        'notlar' => 'Ek Atanma Kriterleri: A veya C grubundan en az 2 özgün araştırma makalesi ve '
            .'toplamda en az 100 puan.',
        'aday_notu' => 'Ziraat temel alanı yönergenin dört alan grubunda adıyla geçmiyor; §0 '
            .'uyarınca daha yüksek eşikli Fen-Mühendislik-Sağlık grubuna bağlandı. '.$PUAN_NOTU,
        'sart' => Kalip::ve('Doktor öğretim üyesi koşulları', $drOrtak(2)),
    ],
    [
        'anahtar' => 'istanbul-arel-fen-docentlik',
        'universite' => 'İstanbul Arel Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $FEN,
        'birim' => null,
        'cetvel' => 'istanbul-arel-2018',
        'notlar' => 'Ek Atanma Kriterleri: Değerlendirme Ölçütleri Puanlama Tablosunda toplamda en '
            .'az 350 puan.',
        'aday_notu' => 'Doçentlikte tek sayısal koşul 350 puan. '.$PUAN_NOTU,
        'sart' => Kalip::ve('Doçent kadrosuna atanma koşulları', [
            $docentBeyani,
            Kalip::toplam(350, maddeler: ['TUM'], liste: 'Değerlendirme Ölçütleri Puanlama Tablosu'),
        ]),
    ],
    [
        'anahtar' => 'istanbul-arel-fen-profesorluk',
        'universite' => 'İstanbul Arel Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $FEN,
        'birim' => null,
        'cetvel' => 'istanbul-arel-2018',
        'notlar' => 'Ek Atanma Kriterleri: son beş yıl içinde A1a\'dan en az 2 yayın ya da K1-K4 '
            .'gruplarından en az bir projede yürütücülük; toplamda en az 700 puan.',
        'aday_notu' => 'Korpustaki en yüksek profesörlük barajlarından biri: 700 puan. Yayın '
            .'koşulu Sosyal Bilimlerdekinin iki katı (A1a\'dan iki yayın), proje alternatifi '
            .'aynı. '.$PUAN_NOTU,
        'sart' => Kalip::ve('Profesör kadrosuna atanma koşulları', [
            ...$profOrtak,
            ...$profYayinVeyaProje(2),
            Kalip::toplam(700, maddeler: ['TUM'], liste: 'Değerlendirme Ölçütleri Puanlama Tablosu'),
        ]),
    ],

    // ── Mimarlık ──
    [
        'anahtar' => 'istanbul-arel-mimarlik-dr',
        'universite' => 'İstanbul Arel Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['mimarlik'],
        'birim' => null,
        'cetvel' => 'istanbul-arel-2018',
        'notlar' => 'Ek Atanma Kriterleri: A veya C grubundan 1 adet özgün makale olmak üzere '
            .'toplamda en az 100 puan.',
        'aday_notu' => 'Mimarlıkta makale koşulu bir yayına iniyor, puan barajı öteki alanlarla '
            .'aynı. '.$PUAN_NOTU,
        'sart' => Kalip::ve('Doktor öğretim üyesi koşulları', $drOrtak(1)),
    ],
    [
        'anahtar' => 'istanbul-arel-mimarlik-docentlik',
        'universite' => 'İstanbul Arel Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['mimarlik'],
        'birim' => null,
        'cetvel' => 'istanbul-arel-2018',
        'notlar' => 'Ek Atanma Kriterleri: Değerlendirme Ölçütleri Puanlama Tablosundan toplamda '
            .'en az 150 puan.',
        'aday_notu' => 'Mimarlık doçentliğinde baraj 350 değil 150 puan. '.$PUAN_NOTU,
        'sart' => Kalip::ve('Doçent kadrosuna atanma koşulları', [
            $docentBeyani,
            Kalip::toplam(150, maddeler: ['TUM'], liste: 'Değerlendirme Ölçütleri Puanlama Tablosu'),
        ]),
    ],
    [
        'anahtar' => 'istanbul-arel-mimarlik-profesorluk',
        'universite' => 'İstanbul Arel Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['mimarlik'],
        'birim' => null,
        'cetvel' => 'istanbul-arel-2018',
        'notlar' => 'Ek Atanma Kriterleri: son beş yıl içinde A veya B grubundan 2 adet yayın; '
            .'toplamda en az 150 puan.',
        'aday_notu' => 'Mimarlıkta profesörlük barajı 150 puan; iki yayının A (makale) ya da B '
            .'(kitap) grubundan olması yeterli, yayın türü belirtilmediği için kitap bölümü ve '
            .'çeviri de sayılıyor. '.$PUAN_NOTU,
        'sart' => Kalip::ve('Profesör kadrosuna atanma koşulları', [
            ...$profOrtak,
            Kalip::adet('Son beş yılda A veya B grubundan en az 2 yayın', ['AB'], 2, donem: Kalip::sonYil(5), madde: 'Ek Atanma Kriterleri — Profesörlük'),
            Kalip::toplam(150, maddeler: ['TUM'], liste: 'Değerlendirme Ölçütleri Puanlama Tablosu'),
        ]),
    ],

    // ── Güzel Sanatlar ──
    [
        'anahtar' => 'istanbul-arel-gsf-dr',
        'universite' => 'İstanbul Arel Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['guzel_sanatlar'],
        'birim' => null,
        'cetvel' => 'istanbul-arel-2018',
        'notlar' => 'Ek Atanma Kriterleri: S veya T maddelerinden en az 80 puan olmak üzere '
            .'toplamda en az 100 puan.',
        'aday_notu' => 'Güzel Sanatlarda makale koşulu yok; 100 puanın 80\'i sanat ve tasarım '
            .'etkinlikleri (S) ile sanat-tasarım ödüllerinden (T) gelmeli. '.$PUAN_NOTU,
        'sart' => Kalip::ve('Doktor öğretim üyesi koşulları', [
            Kalip::beyan('Doktora ya da sanatta yeterlik unvanını almış olmak', 'MADDE 9'),
            Kalip::toplam(80, maddeler: ['ST'], liste: 'S ve T maddeleri'),
            Kalip::toplam(100, maddeler: ['TUM'], liste: 'Değerlendirme Ölçütleri Puanlama Tablosu'),
        ]),
    ],
    [
        'anahtar' => 'istanbul-arel-gsf-docentlik',
        'universite' => 'İstanbul Arel Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['guzel_sanatlar'],
        'birim' => null,
        'cetvel' => 'istanbul-arel-2018',
        'notlar' => 'Ek Atanma Kriterleri: S veya T grubundan en az 100 puan olmak üzere toplamda '
            .'en az 150 puan.',
        'aday_notu' => 'Güzel Sanatlar doçentliğinde baraj 350 değil 150 puan, ama üçte ikisinin '
            .'sanat ve tasarım kalemlerinden gelmesi gerekiyor. '.$PUAN_NOTU,
        'sart' => Kalip::ve('Doçent kadrosuna atanma koşulları', [
            $docentBeyani,
            Kalip::toplam(100, maddeler: ['ST'], liste: 'S ve T maddeleri'),
            Kalip::toplam(150, maddeler: ['TUM'], liste: 'Değerlendirme Ölçütleri Puanlama Tablosu'),
        ]),
    ],
    [
        'anahtar' => 'istanbul-arel-gsf-profesorluk',
        'universite' => 'İstanbul Arel Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['guzel_sanatlar'],
        'birim' => null,
        'cetvel' => 'istanbul-arel-2018',
        'notlar' => 'Ek Atanma Kriterleri: doçent unvanı alındıktan sonra S veya T grubundan en az '
            .'200 puan olmak üzere toplamda en az 300 puan.',
        'aday_notu' => 'S ve T payına doçentlik sonrası kısıtı var, 300 puanlık toplama yok; '
            .'yönergenin cümle kuruluşu böyle. '.$PUAN_NOTU,
        'sart' => Kalip::ve('Profesör kadrosuna atanma koşulları', [
            ...$profOrtak,
            Kalip::toplam(200, donem: Kalip::DOCENTLIK_SONRASI, maddeler: ['ST'], liste: 'S ve T maddeleri'),
            Kalip::toplam(300, maddeler: ['TUM'], liste: 'Değerlendirme Ölçütleri Puanlama Tablosu'),
        ]),
    ],
];
