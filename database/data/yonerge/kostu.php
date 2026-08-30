<?php

/**
 * KOCAELİ SAĞLIK VE TEKNOLOJİ ÜNİVERSİTESİ (KOSTÜ) — Öğretim Üyeliğine
 * Yükseltilme ve Atama Kriterleri Yönergesi
 * Kaynak: pdf/17537102172.kocaelisaglikveteknolojiuniversitesi.pdf
 *
 * BELGEDE TARİH YOK: MADDE 15 yürürlüğü Senato kabulü ve YÖK onayına bağlıyor
 * ama tarih vermiyor. Cetvel dosyasının adındaki 2023 PDF'in oluşturma
 * tarihinden (05/05/2023).
 *
 * ── SADE YAPI, TEK AYRINTI: HER KADRO KENDİ CETVEL VARYANTINI KULLANIYOR ──
 * Alan ayrımı, birim ayrımı ve yayın sayısı barajı yok; koşullar üç maddeye
 * sığıyor:
 *
 *   Dr. Öğr. Üyesi   toplam  20 puan
 *   Doçent           toplam 120 puan + en az 1 yayında birinci yazar
 *   Profesör         toplam 250 puan + doçentlik sonrası 40 puan
 *                    + doçentlik sonrası en az 1 yayında birinci yazar
 *
 * MADDE 14 bir tavan koyuyor ve tavanı KADRONUN ASGARİ PUANINA bağlıyor:
 * "Lisansüstü tez yönetiminden ve kurum içi projelerinden elde edilecek
 * puanın ilgili kadronun gerektirdiği asgari puanın %50'sini aşan kısmı
 * dikkate alınmaz." Yüzde sabit sayıya çevrilebildiği için (10, 60 ve 125)
 * cetvelin üç varyantı üretildi ve her kadro kendi varyantına bağlandı;
 * gerekçe ve üretim cetvel dosyasında.
 *
 * ── "EK-2A" ATFI KAYNAK HATASI GİBİ, OLDUĞU GİBİ OKUNDU ──
 * MADDE 7/b profesörlük için "EK-2A'da belirtilen faaliyetlerden en az 40
 * puan" diyor. EK-2A profesörlüğün değil DOKTOR ÖĞRETİM ÜYESİ kadrosunun
 * başvuru formu (profesörlüğünki EK-2C); üstelik üç form da aynı yedi
 * etkinlik grubunu (makale, kitap, bildiri, editörlük, atıf, eğitim-araştırma,
 * toplantı düzenleme) taşıyor, yani hangisine bakılırsa bakılsın kapsam
 * çizelgenin tamamı. Atıf düzeltilmedi; koşul "tüm faaliyetlerden doçentlik
 * sonrası 40 puan" olarak girildi ve sonuç her iki okumada da aynı.
 *
 * ── YABANCI DİL EŞİĞİ YAZILMADI ──
 * MADDE 5 yalnızca "Yükseköğretim Kurumlarında Yabancı Dil Öğretimi … Uyulacak
 * Esaslara İlişkin Yönetmelikte belirtilen yabancı dil ile ilgili şartları
 * sağlamak" diyor; asgari puan vermiyor. `Kalip::yds` uydurma bir sayı
 * isterdi, beyan olarak girildi.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 13: "Yeni kurulan fakülte ve bölümlere yapılacak atamalarda … asgari
 *       sayıya ulaşıncaya veya mezun verinceye kadar EK KOŞUL ARANMAZ." Bir
 *       muafiyet yolu ve birimin durumuna bağlı; adayın sağlayacağı bir koşul
 *       değil. Aday notunda anıldı.
 *   MADDE 3, 10-12'nin kadro ilanı, ön değerlendirme kurulu ve atama usulü.
 *   Çizelge sonundaki "diğer faaliyetler" hükmü (dekan teklifi ve rektör
 *       onayıyla yılda 0-18 puan) takdire bağlı.
 *
 * ── ALAN KAPSAMI ──
 * Yönerge hiçbir temel alanı ayırmıyor ve hiçbirini dışlamıyor; on iki alanın
 * hepsine yazıldı. Ne var ki çizelgede SANATSAL ETKİNLİK SATIRI HİÇ YOK
 * (üniversite sağlık ve teknoloji odaklı), o yüzden Güzel Sanatlar adayının
 * toplamı olduğundan düşük çıkar.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/kostu-2023.php
 */

use App\Enums\TemelAlan;
use App\Services\Scoring\Sart\Kalip;

$DOC = Kalip::DOCENTLIK_SONRASI;

/** Yönerge alan ayrımı yapmıyor. */
$tumAlanlar = array_column(TemelAlan::cases(), 'value');

$dilBeyani = Kalip::beyan(
    'Yükseköğretim Kurumlarında Yabancı Dil Öğretimine İlişkin Yönetmelikte aranan yabancı '
    .'dil şartını sağlamak',
    'Madde 5',
);

$tavanNotu = 'Lisansüstü tez danışmanlığı ile üniversite fonlarınca desteklenen '
    .'projelerden gelecek puan, bu kadronun asgari puanının yarısını aşamıyor.';

$sanatNotu = 'Çizelgede sanatsal etkinlik satırı hiç yok; sergi, konser, tasarım ve sahne '
    .'çalışmalarınız puan almıyor. Güzel Sanatlar adayıysanız toplamınız olduğundan düşük '
    .'görünür.';

$yeniBirimNotu = 'Yeni kurulan bir fakülte ya da bölüme başvuruyorsanız, birim YÖK\'ün '
    .'öğrenci alımı için aradığı asgari öğretim üyesi sayısına ulaşana ya da mezun verene '
    .'kadar bu ek koşullar aranmıyor (Madde 13); bu muafiyet burada hesaplanamıyor.';

return [
    [
        'anahtar' => 'kostu-dr',
        'aday_notu' => 'Tek sayısal koşul çizelgeden toplam 20 puan — korpusun en düşük '
            .'barajlarından. Tek bir SCI, SSCI ya da AHCI makalesi (30 puan) tek başına '
            .'yetiyor. Yönerge dönem kısıtı koymuyor, doktoradan önceki çalışmalarınız da '
            .'sayılıyor. '.$tavanNotu.' '.$sanatNotu.' '.$yeniBirimNotu,
        'universite' => 'Kocaeli Sağlık ve Teknoloji Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $tumAlanlar,
        'cetvel' => 'kostu-2023-dr',
        'notlar' => 'Madde 9/1-a: "EK-1\'de belirtilen faaliyetlerden toplam en az 20 puan '
            .'almak." Başka sayısal koşul yok; alan ayrımı ve dönem kısıtı da yok. '
            .'Madde 14\'ün tavanı bu kadroda 10 puan (20\'nin yarısı).',
        'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma', [
            $dilBeyani,
            Kalip::toplam(20),
        ]),
    ],
    [
        'anahtar' => 'kostu-docent',
        'aday_notu' => 'İki koşul: çizelgeden toplam 120 puan ve yayınlarınızdan en az '
            .'birinde birinci yazar olmak. Yönerge dönem kısıtı koymuyor. '
            .$tavanNotu.' '.$sanatNotu.' '.$yeniBirimNotu,
        'universite' => 'Kocaeli Sağlık ve Teknoloji Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $tumAlanlar,
        'cetvel' => 'kostu-2023-docent',
        'notlar' => 'Madde 8/1: "a) EK-1\'de belirtilen faaliyetlerden toplam en az 120 puan '
            .'almak, b) EK-1\'de yer alan yayınlardan en az 1 (bir) yayında birinci yazar '
            .'olmak." Dönem kısıtı yok. Madde 14\'ün tavanı bu kadroda 60 puan.',
        'sart' => Kalip::ve('Doçent kadrosuna atanma', [
            Kalip::beyan(
                'Üniversitelerarası Kurul tarafından verilen doçentlik unvanına sahip olmak',
                '2547 sayılı Kanun md. 24',
            ),
            $dilBeyani,
            Kalip::toplam(120),
            Kalip::adet(
                'Makale, bildiri ve kitap kalemlerinizden en az 1\'inde birinci yazar olmak',
                ['YAYIN'], 1, 'ilk', madde: 'Madde 8/1-b',
            ),
        ]),
    ],
    [
        'anahtar' => 'kostu-profesor',
        'aday_notu' => 'Üç koşul: çizelgeden toplam 250 puan, bunun dışında doçentliğinizden '
            .'sonraki faaliyetlerden 40 puan ve yine doçentlik sonrası yayınlarınızdan en az '
            .'birinde birinci yazar olmak. 250 puanlık toplam kariyerin tamamından, 40 puan '
            .'ise yalnızca doçentlik sonrasından sayılıyor. '
            .$tavanNotu.' '.$sanatNotu.' '.$yeniBirimNotu,
        'universite' => 'Kocaeli Sağlık ve Teknoloji Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $tumAlanlar,
        'cetvel' => 'kostu-2023-profesor',
        'notlar' => 'Madde 7/1: "a) EK-1\'de belirtilen faaliyetlerden toplam en az 250 puan '
            .'almak, b) Doçentlik unvanı alındıktan sonraki bir tarihte gerçekleşen EK-2A\'da '
            .'belirtilen faaliyetlerden en az 40 puan almak, c) EK-1\'de yer alan yayınlardan '
            .'doçentlik unvanı alındıktan sonraki bir tarihte gerçekleşen en az 1 (bir) '
            .'yayında birinci yazar olmak." (b) bendindeki EK-2A atfı doktor öğretim üyesi '
            .'formunu gösteriyor (kaynak hatası); üç form da aynı etkinlik gruplarını '
            .'taşıdığı için kapsam çizelgenin tamamı olarak okundu. Madde 14\'ün tavanı bu '
            .'kadroda 125 puan.',
        'sart' => Kalip::ve('Profesör kadrosuna yükseltilme ve atanma', [
            $dilBeyani,
            Kalip::toplam(250),
            Kalip::toplam(40, $DOC),
            Kalip::adet(
                'Doçentliğinizden sonra makale, bildiri ve kitap kalemlerinizden en az '
                .'1\'inde birinci yazar olmak',
                ['YAYIN'], 1, 'ilk', $DOC, madde: 'Madde 7/1-c',
            ),
        ]),
    ],
];
