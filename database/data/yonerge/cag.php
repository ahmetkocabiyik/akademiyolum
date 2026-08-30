<?php

use App\Services\Scoring\Sart\Kalip;

/**
 * ÇAĞ ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma Yönergesi
 * Kaynak: pdf/17537097722.caguniversitesi.pdf
 * (Senato 15.05.2023 tarih ve 2023/11 sayılı karar; 01.06.2023'te yürürlükte)
 *
 * Cetvel: cetvel/cag-2023.php
 *
 * ── EŞİKLERİN YAPISI ──
 * Koşullar temel alana göre değişmiyor, üç kadro için de ortak:
 *   Doktor öğretim üyesi (MADDE 6/2): Ek-1'in A-H maddelerinden 8 puan
 *   Doçent (MADDE 8, 10): doçentlik unvanı; PUAN BARAJI YOK, sözlü sınav
 *       da yönergeyle açıkça kaldırılmış
 *   Profesör (MADDE 12/2, 14): Ek-1'den 100 puan, en az 40'ı doçentlik
 *       sonrası; doçentlik sonrası beş yıl çalışmış olmak; yayınlardan
 *       birini başlıca araştırma eseri olarak göstermek
 * Doktor öğretim üyeliğinin 8 puanlık barajı korpustaki en düşük
 * eşiklerden biri: tek bir SCIE makalesi (15) tek başına aşıyor.
 *
 * ── YORUM KARARLARI (§0) ──
 *   YABANCI DİL KOŞULU `beyan` OLARAK YAZILDI. MADDE 3/1-c yalnız
 *       "eğitim dili %100 yabancı dil olan bölümlere atanacaklar" için 85
 *       puan istiyor. Bütün adaylara sayısal bir YDS düğümü yazmak Türkçe
 *       programlara başvuranları haksız yere elerdi; koşulu hiç yazmamak
 *       ise İngilizce programlara başvuranlardan gizlerdi. İkisinin
 *       arasında `beyan` düğümü seçildi: koşul görünür ama otomatik
 *       değerlendirilmiyor.
 *   MADDE 7/1'e göre doktor öğretim üyeleri en az bir en çok dört yıl
 *       süreyle atanıyor ve MADDE 7/2 görev süresi sonunda yeniden atama
 *       öngörüyor, ama YENİDEN ATAMA İÇİN AYRI BİR ÖLÇÜT YOK; o kadro
 *       için ilk atamayla aynı eşik yazıldı.
 *   MADDE 12/1'in "kendi bilim alanında uluslararası düzeyde orijinal
 *       eserler vermiş olmak" ve "uygulama alanı bulunan dallarda
 *       uygulamaya yönelik çalışmalarda bulunmak" koşulları nitel;
 *       `beyan` olarak yazıldı.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 5, 6/1, 6/3-6/6, 9, 11, 13, 14/1, 15: ilan, başvuru, jüri
 *       oluşturma ve atama süreci usulleri.
 *   MADDE 3/1-a (657 sayılı Kanunun 48. maddesindeki genel şartlar) ve
 *       3/1-b (YÖK tarafından onaylanmış ek koşullar) — ikisi de bu
 *       yönergenin dışına atıf yapıyor.
 *   MADDE 16 (unvanların yükseköğretim kurumları dışında kullanımı) ve
 *       MADDE 17 (jürilerde yabancı uyruklu profesörlerin görevlendirilmesi).
 */
$TUM_ALANLAR = ['fen', 'muhendislik', 'saglik', 'ziraat', 'sosyal', 'egitim', 'filoloji',
    'ilahiyat', 'spor', 'hukuk', 'guzel_sanatlar', 'mimarlik'];

$DIL_BEYANI = Kalip::beyan(
    'Eğitim dili %100 yabancı dil olan bir bölüme başvuruyorsanız YÖKDİL, ÜDS, KPDS ya da YDS\'den en az 85 puan almış olmak',
    'MADDE 3/1-c',
);

$PUAN_NOTU = 'Yönergenin kısa bildiri, teknik not ve editöre mektup için tanımladığı %60 kuralı '
    .'uygulanmıyor: kayıt bunları kitap eleştirisinden ayırmadığı için A-5\'in 2 puanlık satırı '
    .'kullanılıyor ve bu yayınlarda puanınız düşük görünür. İdari görev puanları yıl sayısıyla '
    .'çarpılmıyor; "eğitime katkı" (kredi başına 0,5), bilimsel toplantı düzenleme ve lisansüstü '
    .'tezden üretilmiş yayın kalemlerinin cetvelde karşılığı yok.';

$drSart = Kalip::ve('Doktor öğretim üyesi koşulları', [
    $DIL_BEYANI,
    Kalip::beyan('Doktora eğitimini tamamlamış olmak', 'MADDE 4/1'),
    Kalip::toplam(8, maddeler: ['ABCDEFGH'], liste: 'Makale, bildiri, kitap, editörlük ve atıf'),
]);

return [
    [
        'anahtar' => 'cag-dr',
        'universite' => 'Çağ Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $TUM_ALANLAR,
        'birim' => null,
        'cetvel' => 'cag-2023',
        'notlar' => 'MADDE 6/2: Ek-1 puanlama sisteminin A, B, C, D, E, F, G ve H maddelerinde '
            .'tanımlanmış etkinliklerden toplam en az 8 puan.',
        'aday_notu' => 'Baraj korpustaki en düşük eşiklerden biri: tek bir SCI-Expanded makalesi '
            .'(15 puan) tek başına aşıyor. Puanın A-H maddelerinden gelmesi gerekiyor, yani '
            .'hakemlik, editörlük, tez danışmanlığı, patent, ödül, proje ve idari görev '
            .'kalemleriniz bu 8 puana sayılmıyor. '.$PUAN_NOTU,
        'sart' => $drSart,
    ],
    [
        'anahtar' => 'cag-dr-yeniden',
        'universite' => 'Çağ Üniversitesi',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $TUM_ALANLAR,
        'birim' => null,
        'cetvel' => 'cag-2023',
        'notlar' => 'MADDE 7/2: görev süresi sona erenler yönetim kurulunun uygun görüşü üzerine '
            .'yeniden atanabilir. Yönerge yeniden atama için ayrı bir ölçüt tanımlamıyor; ilk '
            .'atamanın koşulları uygulandı.',
        'aday_notu' => 'Yönerge yeniden atamaya ayrı bir baraj koymuyor, karar yönetim kurulunun '
            .'uygun görüşüne bırakılmış; araç ilk atamanın 8 puanlık eşiğini arıyor. Atama süreniz '
            .'yönerge uyarınca en az bir en çok dört yıl. '.$PUAN_NOTU,
        'sart' => $drSart,
    ],
    [
        'anahtar' => 'cag-docentlik',
        'universite' => 'Çağ Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $TUM_ALANLAR,
        'birim' => null,
        'cetvel' => 'cag-2023',
        'notlar' => 'MADDE 8: doçentlik unvanını almış olmak (yurt dışında alınan unvanın ÜAK '
            .'tarafından Türkiye\'de geçerli sayılmış olması dâhil). MADDE 10: üniversite ayrıca '
            .'sözlü sınav şartı öngörmüyor. Puan barajı yok.',
        'aday_notu' => 'Çağ Üniversitesi doçent kadrosu için ayrı bir puan barajı '
            .'koymuyor; tek koşul doçentlik unvanı. Sözlü sınav şartı da yönergeyle açıkça '
            .'kaldırılmış. '.$PUAN_NOTU,
        'sart' => Kalip::ve('Doçent kadrosuna atanma koşulları', [
            $DIL_BEYANI,
            Kalip::beyan('Doçentlik unvanını almış olmak ya da yurt dışında alınan doçentlik unvanının Üniversitelerarası Kurul tarafından Türkiye\'de geçerli sayılmış olması', 'MADDE 8/1'),
        ]),
    ],
    [
        'anahtar' => 'cag-profesorluk',
        'universite' => 'Çağ Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $TUM_ALANLAR,
        'birim' => null,
        'cetvel' => 'cag-2023',
        'notlar' => 'MADDE 12/1: doçentlik unvanından sonra en az beş yıl ilgili bilim alanında '
            .'çalışmış olmak. MADDE 12/2: Ek-1\'de tanımlı etkinliklerden en az 100 puan, en az '
            .'40 puanı doçentlik sonrası çalışmalardan. MADDE 14: yayınlardan biri başlıca '
            .'araştırma eseri olarak gösterilir.',
        'aday_notu' => 'Profesörlükte 100 puanın 40\'ı doçentlik sonrasına ait olmalı. Doçentlik '
            .'unvanı yurt dışında alınmışsa yönerge uyarınca hizmet süresi o tarihten '
            .'başlıyor. '.$PUAN_NOTU,
        'sart' => Kalip::ve('Profesör kadrosuna atanma koşulları', [
            $DIL_BEYANI,
            Kalip::beyan('Doçentlik unvanını aldıktan sonra en az beş yıl açık bulunan profesörlük kadrosuyla ilgili bilim alanında çalışmış olmak', 'MADDE 12/1'),
            Kalip::beyan('Kendi bilim alanında uluslararası düzeyde orijinal eserler vermiş olmak ve uygulama alanı bulunan dallarda uygulamaya yönelik çalışmalarda bulunmak', 'MADDE 12/1'),
            Kalip::beyan('Yayınlarınızdan birini başlıca araştırma eseri olarak göstermiş olmak', 'MADDE 14/1'),
            Kalip::toplam(100, maddeler: ['TUM']),
            Kalip::toplam(40, donem: Kalip::DOCENTLIK_SONRASI, maddeler: ['TUM']),
        ]),
    ],
];
