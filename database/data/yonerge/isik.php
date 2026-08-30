<?php

/**
 * IŞIK ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma Yönergesi
 * Kaynak: pdf/17537098592.isikuniversitesi.pdf
 * Senato: 18.12.2018 / 301 — yürürlük 31.01.2019
 *
 * DÖRT FAKÜLTE GRUBU (Madde 6-8'in a, b, c, d bentleri):
 *   (a) İİBF'nin tüm bölümleri + Fen-Edebiyat'ın İnsan ve Toplum Bilimleri
 *       ve Psikoloji bölümleri            → sosyal
 *   (b) Mimarlık ve Tasarım Fakültesi      → mimarlik
 *   (c) Mühendislik Fakültesi + Fen-Edebiyat'ın Matematik ve Fizik bölümleri
 *                                          → muhendislik, fen
 *   (d) Güzel Sanatlar Fakültesi           → guzel_sanatlar
 *
 * ── MATEMATİK `birim` İLE AYRILDI ──
 * (c) bendi Mühendislik ile Matematik ve Fizik'i tek satırda topluyor ama
 * parantez içinde "Matematik Bölümü için A.1 ve B grubu faaliyetler 1,3
 * katsayısı ile çarpılarak değerlendirilir" diyor. Yani aynı bentteki üç
 * birimden yalnızca biri çarpan alıyor. Matematik `fen` temel alanına
 * düştüğü ve Fizik de öyle olduğu için ayrım `birim` ile yapıldı: birim
 * seçilmezse çarpansız cetvel gelir, yani puan DÜŞÜK görünür — güvenli taraf.
 *
 * ── GÜZEL SANATLAR: DAHA SIKI OLAN OKUMA GİRİLDİ ──
 * (d) bendi doçentlik ve profesörlükte adayı ÜAK doçentlik unvanını hangi
 * TEMEL ALANDAN aldığına göre ikiye ayırıyor:
 *   Güzel Sanatlar Temel Alanı'ndan   → yalnızca puan koşulu
 *   Mimarlık, Planlama ve Tasarım'dan → puan koşulu + en az 2 makale
 * Adayın doçentlik unvanının hangi temel alandan geldiği profilde tutulmuyor.
 * DAHA SIKI olan (makale sayılı) okuma girildi: doçentliğini Güzel Sanatlar
 * Temel Alanı'ndan almış aday koşulu olduğundan zor görür. Aday notunda
 * muafiyet açıkça söylendi.
 *
 * ── MESLEK YÜKSEKOKULLARI GİRİLMEDİ ──
 * (e) bendi MYO'lar için ayrı koşul veriyor ama MYO bir temel alan değil;
 * hangi temel alana bağlanacağı programa göre değişiyor. Yönerge kendisi de
 * "kadro ilanının yapıldığı programın eğitim verdiği ilgili temel alan"
 * diyor. Fen-Edebiyat'ın Enformasyon Teknolojileri / Yönetim Bilişim
 * Sistemleri programı da aynı sebeple girilmedi: (ç) bendi adayı başvuru
 * alanına göre (a) ya da (c) bendine yönlendiriyor, kendi eşiği yok.
 *
 * ── YABANCI DİL ──
 * Madde 5 yalnızca "İngilizce eğitim-öğretim yapılan programlar için alınacak
 * öğretim üyelerinin YÖK'ün belirlediği şartları sağlaması" diyor; sayısal bir
 * baraj vermiyor, YÖK yönetmeliğine atıf yapıyor. Uydurulmadı.
 * Madde 5(4) + Madde 10: aday bölüm toplantısında seminer ya da deneme dersi
 * veriyor ve başarılı bulunması gerekiyor — beyan olarak girildi.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Madde 17 (Geçici Madde 1): 1 Ocak 2020'ye kadarki başvurularda adayların
 *       eski yönergeyi tercih edebilmesi — süresi dolmuş geçiş hükmü.
 *   Yeniden atanma yönergede ayrı bir eşik olarak yok.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/isik-2019.php
 */

use App\Services\Scoring\Sart\Kalip;

$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;

$seminer = Kalip::beyan(
    'Bölüm toplantısında dersi hangi dilde vereceksiniz o dilde seminer ya da deneme dersi '
    .'verip başarılı bulunmak',
    'Madde 5(4)',
);

$docentUnvani = Kalip::beyan(
    'Üniversitelerarası Kurul\'dan doçentlik unvanını kazanmış olmak',
    'Madde 7(1)',
);

$profesorSuresi = Kalip::beyan(
    'Doçentlik unvanını aldıktan sonra en az beş yıl, başvurduğunuz bilim veya sanat alanında '
    .'çalışmış olmak',
    'Madde 8(1)',
);

$carpanNotu = 'Biriminizde yönergenin "uluslararası yayın ve proje faaliyetleri 1,3 katsayısı '
    .'ile çarpılarak değerlendirilir" kuralı geçerli; bu puanlarınız o çarpanla '
    .'hesaplandı.';

return [
    // ══════════════════ DR. ÖĞRETİM ÜYESİ (Madde 6) ══════════════════
    [
        'anahtar' => 'isik-dr-sosyal',
        'aday_notu' => 'İki koşul birlikte: uluslararası yayın kalemlerinizde (indeksli dergi ya da '
            .'uluslararası yayınevi kitabı) en az bir yayın ve toplam 15 puan. '.$carpanNotu,
        'universite' => 'Işık Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['sosyal'],
        'cetvel' => 'isik-2019-carpanli',
        'notlar' => 'Madde 6(2)-a (İİBF tüm bölümleri + Fen-Edebiyat İnsan ve Toplum Bilimleri '
            .'ve Psikoloji): "En az bir adet uluslararası yayın kalemlerinizde yayımlanmış veya yayına kabul '
            .'edilmiş makale ve en az 15 puan."',
        'sart' => Kalip::ve('Dr. Öğr. Üyeliğine atanma — İktisadi ve İdari Bilimler, İnsan ve Toplum Bilimleri', [
            $seminer,
            Kalip::adet('Uluslararası yayın kalemlerinizden en az 1 çalışma', ['A.1'], 1, madde: 'Madde 6(2)-a'),
            Kalip::toplam(15),
        ]),
    ],
    [
        'anahtar' => 'isik-dr-mimarlik',
        'aday_notu' => 'İki koşul birlikte: uluslararası yayın kalemlerinizde en az bir yayın ve toplam 15 puan. '
            .$carpanNotu,
        'universite' => 'Işık Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['mimarlik'],
        'cetvel' => 'isik-2019-carpanli',
        'notlar' => 'Madde 6(2)-b (Mimarlık ve Tasarım Fakültesi): aynı koşul, aynı çarpan.',
        'sart' => Kalip::ve('Dr. Öğr. Üyeliğine atanma — Mimarlık ve Tasarım', [
            $seminer,
            Kalip::adet('Uluslararası yayın kalemlerinizden en az 1 çalışma', ['A.1'], 1, madde: 'Madde 6(2)-b'),
            Kalip::toplam(15),
        ]),
    ],
    [
        'anahtar' => 'isik-dr-muhendislik',
        'aday_notu' => 'Mühendislik ve Fizik\'te yayın koşulu daha dar: SSCI, AHCI veya '
            .'SCI-Expanded) kapsamında en az bir makale gerekiyor, ESCI ya da alan indeksi '
            .'yetmiyor. Bu birimlerde 1,3 çarpanı da UYGULANMIYOR.',
        'universite' => 'Işık Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['muhendislik', 'fen'],
        'cetvel' => 'isik-2019',
        'notlar' => 'Madde 6(2)-c (Mühendislik Fakültesi + Fen-Edebiyat Matematik ve Fizik): '
            .'"En az bir adet A.1.1 kapsamında makale ve en az 15 puan." Çarpan yalnızca '
            .'Matematik Bölümü için tanınıyor, o yüzden bu eşik çarpansız cetveli kullanıyor.',
        'sart' => Kalip::ve('Dr. Öğr. Üyeliğine atanma — Mühendislik ve Fizik', [
            $seminer,
            Kalip::adet('SSCI, AHCI veya SCI-Expanded kapsamındaki dergilerde en az 1 makale', ['A.1.1'], 1, madde: 'Madde 6(2)-c'),
            Kalip::toplam(15),
        ]),
    ],
    [
        'anahtar' => 'isik-dr-matematik',
        'aday_notu' => 'Matematik Bölümü, Mühendislik ile aynı yayın koşuluna tabi ama 1,3 '
            .'çarpanını alıyor. Biriminizi seçmezseniz çarpansız hesap yapılır ve puanınız '
            .'olduğundan düşük görünür.',
        'universite' => 'Işık Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['fen'],
        'birim' => 'Matematik Bölümü',
        'cetvel' => 'isik-2019-carpanli',
        'notlar' => 'Madde 6(2)-c parantezi: "(Matematik Bölümü için A.1 ve B grubu faaliyetler '
            .'1,3 katsayısı ile çarpılarak değerlendirilir.)" Koşul Mühendislik ile aynı, '
            .'yalnızca cetvel farklı.',
        'sart' => Kalip::ve('Dr. Öğr. Üyeliğine atanma — Matematik Bölümü', [
            $seminer,
            Kalip::adet('SSCI, AHCI veya SCI-Expanded kapsamındaki dergilerde en az 1 makale', ['A.1.1'], 1, madde: 'Madde 6(2)-c'),
            Kalip::toplam(15),
        ]),
    ],
    [
        'anahtar' => 'isik-dr-guzel-sanatlar',
        'aday_notu' => 'Güzel Sanatlarda yayın koşulu en geniş: uluslararası ya da ulusal yayın kalemlerinizde '
            .'(ulusal) kapsamında bir yayın yeterli. '.$carpanNotu,
        'universite' => 'Işık Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'isik-2019-carpanli',
        'notlar' => 'Madde 6(2)-d (Güzel Sanatlar Fakültesi): "En az bir adet A.1 veya A.2 '
            .'kapsamında makale ve en az 15 puan."',
        'sart' => Kalip::ve('Dr. Öğr. Üyeliğine atanma — Güzel Sanatlar', [
            $seminer,
            Kalip::adet('Uluslararası ya da ulusal yayın kalemlerinizden en az 1 çalışma', ['A.1-A.2'], 1, madde: 'Madde 6(2)-d'),
            Kalip::toplam(15),
        ]),
    ],

    // ══════════════════ DOÇENT (Madde 7) ══════════════════
    [
        'anahtar' => 'isik-docent-sosyal',
        'aday_notu' => 'Üç koşul birlikte: ssci, ahci ve sci-expanded dergilerindeki makalelerinizden en az bir makale, uluslararası yayın kalemlerinizden '
            .'30 puan ve toplam 100 puan. '.$carpanNotu,
        'universite' => 'Işık Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['sosyal'],
        'cetvel' => 'isik-2019-carpanli',
        'notlar' => 'Madde 7(2)-a: "En az bir adet ssci, ahci ve sci-expanded dergilerindeki makalesi ve uluslararası yayın kalemlerinizden en '
            .'az 30 puan; toplamda ise en az 100 puan."',
        'sart' => Kalip::ve('Doçent kadrosuna atanma — İktisadi ve İdari Bilimler, İnsan ve Toplum Bilimleri', [
            $docentUnvani,
            Kalip::adet('SSCI, AHCI veya SCI-Expanded kapsamındaki dergilerde en az 1 makale', ['A.1.1'], 1, madde: 'Madde 7(2)-a'),
            Kalip::puanDan('Uluslararası yayın kalemlerinizden en az 30 puan', ['A.1'], 30, madde: 'Madde 7(2)-a'),
            Kalip::toplam(100),
        ]),
    ],
    [
        'anahtar' => 'isik-docent-mimarlik',
        'aday_notu' => 'Mimarlık ve Tasarımda makale sayısı iki ve dergi kümesi daha geniş: '
            .'SSCI, AHCI, SCI-Expanded ve diğer uluslararası indeksli dergiler sayılıyor. Otuz '
            .'puanlık alt baraj uluslararası yayınlara ek '
            .'olarak ulusal hakemli dergiden de toplanabiliyor. '.$carpanNotu,
        'universite' => 'Işık Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['mimarlik'],
        'cetvel' => 'isik-2019-carpanli',
        'notlar' => 'Madde 7(2)-b: "En az iki adet A.1.1, A.1.2 veya A.1.3 kapsamında makale ve '
            .'A.1, A.2.1 bölümlerinden en az 30 puan; toplamda ise 100 puan."',
        'sart' => Kalip::ve('Doçent kadrosuna atanma — Mimarlık ve Tasarım', [
            $docentUnvani,
            Kalip::adet('Uluslararası indeksli dergilerde en az 2 makale', ['A.1.1-3'], 2, madde: 'Madde 7(2)-b'),
            Kalip::puanDan('Uluslararası yayınlar ve ulusal hakemli dergi makalelerinizden en az 30 puan', ['A.1-A.2.1'], 30, madde: 'Madde 7(2)-b'),
            Kalip::toplam(100),
        ]),
    ],
    [
        'anahtar' => 'isik-docent-muhendislik',
        'aday_notu' => 'Mühendislik ve Fizik\'te makale SAYISI aranmıyor; onun yerine '
            .'SSCI, AHCI ve SCI-Expanded dergilerindeki makalelerinizden 45 puanlık bir alt baraj var. Bu birimlerde 1,3 çarpanı '
            .'uygulanmıyor.',
        'universite' => 'Işık Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['muhendislik', 'fen'],
        'cetvel' => 'isik-2019',
        'notlar' => 'Madde 7(2)-c: "En az 45 puanı ssci, ahci ve sci-expanded dergilerindeki makalelerinizden olmak '
            .'üzere toplam en az 100 puan."',
        'sart' => Kalip::ve('Doçent kadrosuna atanma — Mühendislik ve Fizik', [
            $docentUnvani,
            Kalip::puanDan('SSCI, AHCI veya SCI-Expanded yayınlarınızdan en az 45 puan', ['A.1.1'], 45, madde: 'Madde 7(2)-c'),
            Kalip::toplam(100),
        ]),
    ],
    [
        'anahtar' => 'isik-docent-matematik',
        'aday_notu' => 'Matematik Bölümü Mühendislik ile aynı koşula tabi ama 1,3 çarpanını '
            .'alıyor. Biriminizi seçmezseniz çarpansız hesap yapılır.',
        'universite' => 'Işık Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['fen'],
        'birim' => 'Matematik Bölümü',
        'cetvel' => 'isik-2019-carpanli',
        'notlar' => 'Madde 7(2)-c parantezi: Matematik Bölümü için A.1 ve B grubu 1,3 ile '
            .'çarpılıyor.',
        'sart' => Kalip::ve('Doçent kadrosuna atanma — Matematik Bölümü', [
            $docentUnvani,
            Kalip::puanDan('SSCI, AHCI veya SCI-Expanded yayınlarınızdan en az 45 puan', ['A.1.1'], 45, madde: 'Madde 7(2)-c'),
            Kalip::toplam(100),
        ]),
    ],
    [
        'anahtar' => 'isik-docent-guzel-sanatlar',
        'aday_notu' => 'Yönerge burada adayı doçentlik unvanını hangi ÜAK temel alanından '
            .'aldığına göre ikiye ayırıyor. Profilde o bilgi tutulmadığı için DAHA SIKI olan '
            .'okuma gösteriliyor: iki uluslararası makale koşulu. Doçentliğinizi GÜZEL '
            .'SANATLAR temel alanından aldıysanız bu makale koşulu sizden aranmıyor, yalnızca '
            .'30 ve 100 puanlık barajlar geçerli. '.$carpanNotu,
        'universite' => 'Işık Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'isik-2019-carpanli',
        'notlar' => 'Madde 7(2)-d iki okuma veriyor: Güzel Sanatlar Temel Alanı\'ndan doçent '
            .'olanlar için yalnızca "en az 30 puanı A.1 ve A.2 grubu faaliyetlerden … toplamda '
            .'en az 100 puan"; Mimarlık, Planlama ve Tasarım temel alanından doçent olanlar '
            .'için ayrıca "en az iki adet A.1.1, A.1.2 veya A.1.3 makale". Adayın doçentlik '
            .'temel alanı profilde yok; sıkı okuma girildi.',
        'sart' => Kalip::ve('Doçent kadrosuna atanma — Güzel Sanatlar', [
            $docentUnvani,
            Kalip::adet('Uluslararası indeksli dergilerde en az 2 makale', ['A.1.1-3'], 2, madde: 'Madde 7(2)-d'),
            Kalip::puanDan('Uluslararası ve ulusal yayın kalemlerinizden en az 30 puan', ['A.1-A.2.1'], 30, madde: 'Madde 7(2)-d'),
            Kalip::toplam(100),
        ]),
    ],

    // ══════════════════ PROFESÖR (Madde 8) ══════════════════
    [
        'anahtar' => 'isik-profesor-sosyal',
        'aday_notu' => 'İki ssci, ahci ve sci-expanded dergilerindeki makalesinin en az biri doçentlik unvanınızdan sonra üretilmiş '
            .'olmalı. Ayrıca uluslararası yayın kalemlerinizden 45 ve toplamda 200 puan aranıyor. '.$carpanNotu,
        'universite' => 'Işık Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['sosyal'],
        'cetvel' => 'isik-2019-carpanli',
        'notlar' => 'Madde 8(2)-a: "Biri doçentlik unvanını aldıktan sonraki faaliyetlerden '
            .'olmak üzere en az iki adet ssci, ahci ve sci-expanded dergilerindeki makalesi ve uluslararası yayın kalemlerinizden en az 45 '
            .'puan, toplamda ise en az 200 puan."',
        'sart' => Kalip::ve('Profesör kadrosuna atanma — İktisadi ve İdari Bilimler, İnsan ve Toplum Bilimleri', [
            $profesorSuresi,
            Kalip::adet('SSCI, AHCI veya SCI-Expanded kapsamındaki dergilerde en az 2 makale', ['A.1.1'], 2, madde: 'Madde 8(2)-a'),
            Kalip::adet('Bunların en az 1\'i doçentlik unvanınızdan sonra olmalı', ['A.1.1'], 1, donem: $DOCENTLIK, madde: 'Madde 8(2)-a'),
            Kalip::puanDan('Uluslararası yayın kalemlerinizden en az 45 puan', ['A.1'], 45, madde: 'Madde 8(2)-a'),
            Kalip::toplam(200),
        ]),
    ],
    [
        'anahtar' => 'isik-profesor-mimarlik',
        'aday_notu' => 'Mimarlık ve Tasarımda makale sayısı aranmıyor; uluslararası yayın '
            .'kalemlerinizden 60 '
            .'puan isteniyor ve bunun en az 30\'u doçentlik sonrası olmalı. '.$carpanNotu,
        'universite' => 'Işık Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['mimarlik'],
        'cetvel' => 'isik-2019-carpanli',
        'notlar' => 'Madde 8(2)-b: "En az 30 puanı doçentlik unvanını aldıktan sonraki '
            .'faaliyetlerden olmak üzere uluslararası yayın kalemlerinizden en az 60 puan ve toplamda 200 '
            .'puan."',
        'sart' => Kalip::ve('Profesör kadrosuna atanma — Mimarlık ve Tasarım', [
            $profesorSuresi,
            Kalip::puanDan('Uluslararası yayın kalemlerinizden en az 60 puan', ['A.1'], 60, madde: 'Madde 8(2)-b'),
            Kalip::puanDan('Bunun en az 30 puanı doçentlik unvanınızdan sonra olmalı', ['A.1'], 30, $DOCENTLIK, madde: 'Madde 8(2)-b'),
            Kalip::toplam(200),
        ]),
    ],
    [
        'anahtar' => 'isik-profesor-muhendislik',
        'aday_notu' => 'Mühendislik ve Fizik\'te üç baraj birlikte: SSCI, AHCI ve SCI-Expanded dergilerindeki makalelerinizden 80 puan '
            .'(en az 35\'i doçentlik sonrası) ve toplam 200 puan (en az 80\'i doçentlik '
            .'sonrası). Bu birimlerde 1,3 çarpanı uygulanmıyor.',
        'universite' => 'Işık Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['muhendislik', 'fen'],
        'cetvel' => 'isik-2019',
        'notlar' => 'Madde 8(2)-c: "En az 35 puanı doçentlik unvanını aldıktan sonra olmak '
            .'üzere ssci, ahci ve sci-expanded dergilerindeki makalelerinizden en az 80 puan ve en az 80 puanı doçentlik sonrası '
            .'faaliyetlerden olmak üzere toplamda en az 200 puan."',
        'sart' => Kalip::ve('Profesör kadrosuna atanma — Mühendislik ve Fizik', [
            $profesorSuresi,
            Kalip::puanDan('SSCI, AHCI veya SCI-Expanded yayınlarınızdan en az 80 puan', ['A.1.1'], 80, madde: 'Madde 8(2)-c'),
            Kalip::puanDan('Bunun en az 35 puanı doçentlik unvanınızdan sonra olmalı', ['A.1.1'], 35, $DOCENTLIK, madde: 'Madde 8(2)-c'),
            Kalip::toplam(200),
            Kalip::toplam(80, $DOCENTLIK),
        ]),
    ],
    [
        'anahtar' => 'isik-profesor-matematik',
        'aday_notu' => 'Matematik Bölümü Mühendislik ile aynı koşula tabi ama 1,3 çarpanını '
            .'alıyor. Biriminizi seçmezseniz çarpansız hesap yapılır.',
        'universite' => 'Işık Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['fen'],
        'birim' => 'Matematik Bölümü',
        'cetvel' => 'isik-2019-carpanli',
        'notlar' => 'Madde 8(2)-c parantezi: Matematik Bölümü için A.1 ve B grubu 1,3 ile '
            .'çarpılıyor.',
        'sart' => Kalip::ve('Profesör kadrosuna atanma — Matematik Bölümü', [
            $profesorSuresi,
            Kalip::puanDan('SSCI, AHCI veya SCI-Expanded yayınlarınızdan en az 80 puan', ['A.1.1'], 80, madde: 'Madde 8(2)-c'),
            Kalip::puanDan('Bunun en az 35 puanı doçentlik unvanınızdan sonra olmalı', ['A.1.1'], 35, $DOCENTLIK, madde: 'Madde 8(2)-c'),
            Kalip::toplam(200),
            Kalip::toplam(80, $DOCENTLIK),
        ]),
    ],
    [
        'anahtar' => 'isik-profesor-guzel-sanatlar',
        'aday_notu' => 'Güzel Sanatlarda profesörlük koşulu iki okumada da aynı: uluslararası '
            .'(Güzel Sanatlar temel alanından doçent olanlar için uluslararası ve ulusal) '
            .'yayın kalemlerinizden 60 '
            .'puan, en az 30\'u doçentlik sonrası, toplamda 200 puan. Doçentlikten farklı '
            .'olarak burada makale SAYISI aranmıyor. '.$carpanNotu,
        'universite' => 'Işık Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'isik-2019-carpanli',
        'notlar' => 'Madde 8(2)-d iki okuma veriyor ama ikisi de aynı sayılara varıyor; fark '
            .'yalnızca puanın hangi kümeden toplanacağında (A.1+A.2 ↔ A.1). Geniş küme '
            .'girildi: Güzel Sanatlar temel alanından doçent olan aday ulusal yayınlarını da '
            .'sayabiliyor.',
        'sart' => Kalip::ve('Profesör kadrosuna atanma — Güzel Sanatlar', [
            $profesorSuresi,
            Kalip::puanDan('Uluslararası ve ulusal yayın kalemlerinizden en az 60 puan', ['A.1-A.2'], 60, madde: 'Madde 8(2)-d'),
            Kalip::puanDan('Bunun en az 30 puanı doçentlik unvanınızdan sonra olmalı', ['A.1-A.2'], 30, $DOCENTLIK, madde: 'Madde 8(2)-d'),
            Kalip::toplam(200),
        ]),
    ],
];
