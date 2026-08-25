<?php

/**
 * İSTİNYE ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma Ölçütleri Yönergesi
 * Kaynak: pdf/1769428294944.istinye-kriter-30042025gk-26012026.pdf
 * Senato: 05.02.2025 / 07 — YÖK onayından 6 ay sonra yürürlükte
 *
 * PUANLAMAYI TAMAMEN ÜAK'A DEVREDİYOR. Yönergenin kendi puan cetveli yok;
 * Madde 5(3) doğrudan uak.gov.tr'nin doçentlik başvuru şartlarına bağlanıyor
 * ve "ilgili adreste yapılan güncellemeler işbu yönerge kapsamında kullanılan
 * tanımlarda da otomatik olarak güncellenmiş sayılır" diyor. Cetvel bu yüzden
 * `uak-2024-mart-{alan}` — ÜAK her temel alan için ayrı tablo yayımladığı için
 * alan başına çözülüyor.
 *
 * KADRO BARAJLARI (Madde 6):
 *   Dr. Öğr. Üyesi   toplam 25 puan, doktora unvanından sonra
 *   Doçent           toplam 150 puan
 *   Profesör         toplam 250 puan, en az 100'ü doçentlik sonrası
 *
 * ── ÜAK'IN ALT BARAJLARI GİRİLMEDİ, ÇÜNKÜ MOTORDA ZATEN YOK ──
 * Madde 6'nın alt bentlerinin çoğu ÜAK'ın MADDE BAŞINA asgari ve azami puan
 * şartlarını değiştiriyor ("atıf maddesi için azami puanın iki katı", "bilimsel
 * araştırma projesi maddesi için azami puan şartı uygulanmaz", "ulusal makale
 * için asgari ÜAK kriterleri aranmaz"). Motor ÜAK'ın madde başına asgari
 * şartlarını hiç uygulamıyor — cetvel yalnızca puan üretiyor, ÜAK'ın kendi
 * kapıları modellenmiş değil. Bu yüzden o bentlerin çoğu sessizce zaten
 * geçerli; girilecek bir karşılıkları yok.
 *
 * AZAMİ PUAN DEĞİŞİKLİKLERİ İSE UYGULANAMIYOR ve puanı DÜŞÜK gösteriyor:
 *   Dr.        atıf ve bilimsel toplantı tavanı iki katı, proje tavanı yok
 *   Doçent     atıf tavanı iki katı, proje tavanı yok
 *   Profesör   atıf tavanı dört katı, eğitim-öğretim tavanı iki katı,
 *              ödül tavanı iki katı, proje tavanı yok
 * Cetvelin `grup_tavanlari` alanı ÜAK'ın kendi tavanlarını taşıyor ve eşik
 * bazında değiştirilemiyor (tavan cetvele ait, koşula değil). Adayın atıf,
 * proje ve toplantı puanı bu yüzden burada olduğundan düşük toplanır.
 *
 * ── YAZAR BÖLMESİ ÜAK'INKİNDEN FARKLI ──
 * Madde 6(1) ÜAK'ın eşit bölme kuralını yumuşatıyor: 20 yazara kadar eşit
 * bölme, 20-100 yazar arası toplam puanın 1/20'si, 100+ yazarlı makalelerde
 * 1/40'ı. Yani çok kalabalık yayınlarda İstinye ÜAK'tan CÖMERT. Cetvel
 * paylaşıldığı için (uak-2024-mart-{alan}) bu fark uygulanamıyor; yirmiden
 * fazla yazarlı yayını olan adayın puanı burada olduğundan DÜŞÜK görünür.
 * Aday notunda söylendi.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Madde 6(3)-g  Dr. Öğr. Üyesi yeniden atanması: "son atama tarihinden
 *       itibaren" faaliyetler dikkate alınıyor ama YÖNERGE BİR BARAJ
 *       SÖYLEMİYOR, kararı üniversite yönetim kuruluna bırakıyor. Sayısı
 *       olmayan bir koşul eşik olarak yazılamaz.
 *   Madde 6(2)  ÜAK proje maddesinin İstinye'ye özgü genişletmeleri
 *       (bursiyerlik araştırmacılığa eşdeğer, yürüyen projeler tamamlanmış
 *       sayılır, öğrenci projeleri dâhil). Motor zaten projenin bitip
 *       bitmediğine bakmıyor ve bursiyeri araştırmacı koduna bağlıyor; ÜAK
 *       cetvelinde öğrenci projesi kalemi yok, o kadarı DÜŞÜK kalıyor.
 *   Madde 6(6)  "uzmanlık ve mesleki tecrübeler … senato kararı ile
 *       belirlenmiş programlar için göz önünde bulundurulur" — programa özgü
 *       ve senato kararına bağlı.
 *   Yabancı dil şartı yönergede HİÇ YOK; uydurulmadı.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: uak-2024-mart-{alan}
 */

use App\Enums\TemelAlan;
use App\Services\Scoring\Sart\Kalip;

$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;

/** Yönerge alan ayrımı yapmıyor; ÜAK'ın on iki temel alanının hepsi geçerli. */
$tumAlanlar = array_column(TemelAlan::cases(), 'value');

$tavanNotu = 'Yönerge ÜAK\'ın madde başına AZAMİ puan sınırlarını bu kadro için gevşetiyor '
    .'(atıf ve proje kalemlerinde tavan yükseliyor ya da kalkıyor). Tavanlar ÜAK cetveline '
    .'ait olduğu için burada uygulanamıyor; atıf, proje ve toplantı puanınız olduğundan '
    .'düşük toplanır. Ayrıca yirmiden fazla yazarlı yayınlarda yönerge ÜAK\'tan cömert '
    .'davranıyor (1/20, 1/40 payları), o yayınlarınız da burada düşük görünür.';

return [
    // ══════════════════ DR. ÖĞRETİM ÜYESİ ══════════════════
    [
        'anahtar' => 'istinye-dr',
        'aday_notu' => 'Baraj korpusun en düşüklerinden: ÜAK tablosundan 25 puan, tamamı '
            .'doktora unvanınızdan sonra üretilmiş olmak kaydıyla. Tek bir Q1 makale '
            .'(30 puan) tek başına yetiyor. '.$tavanNotu,
        'universite' => 'İstinye Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $tumAlanlar,
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 6(3)-f: "toplam asgari 25 puan şartını sağlaması gerekir." '
            .'Madde 6(3)-a çalışmaların doktora unvanından sonra yapılmış olmasını şart '
            .'koşuyor. Yabancı dil şartı yönergede yok.',
        'sart' => Kalip::toplam(25, $DOKTORA),
    ],

    // ══════════════════ DOÇENT ══════════════════
    [
        'anahtar' => 'istinye-docent',
        'aday_notu' => 'Doçentlikte tek sayısal koşul ÜAK tablosundan 150 puan; yönerge '
            .'dönem kısıtı koymuyor, doktoradan önceki çalışmalarınız da sayılıyor. '
            .$tavanNotu,
        'universite' => 'İstinye Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $tumAlanlar,
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 6(4)-d: "toplam asgari 150 puan şartını sağlaması gerekir." '
            .'Dönem kısıtı belirtilmemiş, bu yüzden yazılmadı.',
        'sart' => Kalip::ve('Doçent kadrosuna atanma', [
            Kalip::beyan('Üniversitelerarası Kurul\'dan doçentlik unvanını almış olmak', 'Madde 4'),
            Kalip::toplam(150),
        ]),
    ],

    // ══════════════════ PROFESÖR ══════════════════
    [
        'anahtar' => 'istinye-profesor',
        'aday_notu' => 'Profesörlükte iki baraj birlikte: ÜAK tablosundan toplam 250 puan ve '
            .'bunun en az 100\'ü doçentlik unvanınızdan sonra üretilmiş olmalı. '.$tavanNotu,
        'universite' => 'İstinye Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $tumAlanlar,
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 6(5)-g: "en az 100 puanının Doçent ünvanının alınmasından sonraki '
            .'döneme ait olması koşuluyla toplam asgari 250 puan." Madde 6(5)-b uluslararası '
            .'makale maddesinin ÜAK ASGARİ puanını iki katına çıkarıyor; motor ÜAK\'ın madde '
            .'başına asgari şartlarını hiç uygulamadığı için karşılığı yok.',
        'sart' => Kalip::ve('Profesör kadrosuna atanma', [
            Kalip::beyan('Doçentlik unvanına sahip olmak', 'Madde 4'),
            Kalip::toplam(250),
            Kalip::toplam(100, $DOCENTLIK),
        ]),
    ],
];
