<?php

/**
 * YILDIZ TEKNİK ÜNİVERSİTESİ — Akademik Yükseltme ve Atama Ölçütleri Yönergesi
 * Kaynak: pdf/17537010672.yildizteknikuniverstesi.pdf (Rev. 24.03.2021)
 *
 * Yapı diğer yönergelerden sade: tek bir puan tablosu (EK-1) ve temel alana
 * göre asgari puan tablosu (EK-2). Koşullar madde bazlı asgari puanlardan ve
 * bir toplam barajdan ibaret.
 *
 * DÖRT ALAN GRUBU (EK-2 sütunları):
 *   Mühendislik, Fen Bilimleri ve Matematik
 *   Mimarlık, Planlama ve Tasarım
 *   Sosyal Beşeri ve İdari Bilimler, Eğitim Bilimleri ve Filoloji
 *   Hukuk
 *
 * Sanat ve Tasarım temel alanı EK-2'de AYRI bir tabloda; o tablo girilmedi.
 *
 * BÖLÜM ORTALAMASI KOŞULU HESAPLANAMIYOR: yönerge her kadroda "adayın
 * 1(a,b,c) toplam puanının, ilgili bölümde o kadroda bulunan akademisyenlerin
 * atama yıllarındaki puanlarından hesaplanan BÖLÜM ORTALAMASININ üzerinde
 * olması" şartını koyuyor. Bu ortalama her yıl üniversite yönetim kurulunca
 * belirleniyor ve adayın dosyasından türetilemiyor — `beyan` düğümü.
 *
 * 1(a) KÜMESİ Q4'Ü KAPSAMAZ: yönergede Q1-Q3 "a" bendinin alt kırılımları,
 * Q4 ise ESCI ile birlikte ayrı "b" bendi. EK-2'nin "1(a)" ile "1(a,b,c)"
 * satırları arasındaki fark tam olarak budur.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/yildiz-teknik-2022.php
 */

use App\Services\Scoring\Sart\Kalip;

/** EK-2 sütunlarının temel alan karşılıkları. */
$muhFen = ['muhendislik', 'fen'];
$sosyal = ['sosyal', 'egitim', 'filoloji'];

/**
 * Her kadroda tekrarlayan, adayın dosyasından hesaplanamayan koşul.
 *
 * @return array<string, mixed>
 */
$bolumOrtalamasi = fn (string $kadro): array => Kalip::beyan(
    "1(a,b,c) toplam puanınız, bölümünüzdeki {$kadro} kadrosundaki akademisyenlerin "
    .'atama yılı puan ortalamasının üzerinde olmalı',
    'MADDE 9',
);

/**
 * EK-2 madde gruplarının adaya gösterilecek karşılığı. Yönergenin kendi kodu
 * (1(a,b,c) gibi) düğümün `madde` alanında duruyor; aday ekranında ise kümenin
 * neyi kapsadığı yazıyor — kod adayın bilmediği bir iç referans.
 *
 * @var array<string, string>
 */
$grupAdi = [
    '1(a)' => 'SCI-E, SSCI veya AHCI Q1-Q3 dergilerindeki makalelerinizden',
    '1(a,b,c)' => 'SCI-E, SSCI, AHCI Q1-Q3 ile ESCI/Q4 ve senatoca belirlenen uluslararası dergilerdeki makalelerinizden',
    '4(a,b,c)' => 'Yayınlarınıza yapılan atıflardan',
    '5(a,b)' => 'Tamamladığınız doktora ve yüksek lisans tez danışmanlıklarından',
    '6' => 'Tamamlanmış araştırma projelerindeki görevlerinizden',
    '8(a,b,c,d)' => 'Verdiğiniz lisans ve lisansüstü derslerden',
];

/**
 * Bir kadro + alan grubu için EK-2 satırlarını düğüme çevirir.
 *
 * @param  array<string, int>  $asgari  Madde grubu → asgari puan
 * @return list<array<string, mixed>>
 */
$asgariPuanlar = function (array $asgari) use ($grupAdi): array {
    $dugumler = [];

    foreach ($asgari as $grup => $puan) {
        $ad = $grupAdi[$grup] ?? "{$grup} kapsamında";
        $dugumler[] = Kalip::puanDan("{$ad} en az {$puan} puan", [$grup], $puan, madde: "EK-2 · {$grup}");
    }

    return $dugumler;
};

return [
    // ══════════════════ DR. ÖĞRETİM ÜYESİ ══════════════════ (toplam 100)
    [
        'anahtar' => 'ytu-dr-muh-fen',
        'aday_notu' => 'Mühendislik ve Fen alanında 1(a) satırı yalnızca Q1-Q3 dergileri sayıyor; Q4 ve ESCI makaleleri 1(a,b,c) satırına giriyor.',
        'universite' => 'Yıldız Teknik Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $muhFen,
        'cetvel' => 'yildiz-teknik-2022',
        'notlar' => 'EK-2 Dr. Öğr. Üyesi, Mühendislik/Fen/Matematik: 1(a) 30, 1(a,b,c) 10, 6 → 5, toplam 100.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Mühendislik / Fen Bilimleri', [
            ...$asgariPuanlar(['1(a)' => 30, '1(a,b,c)' => 10, '6' => 5]),
            Kalip::toplam(100),
            $bolumOrtalamasi('Dr. Öğretim Üyesi'),
        ]),
    ],
    [
        'anahtar' => 'ytu-dr-mimarlik',
        'universite' => 'Yıldız Teknik Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['mimarlik'],
        'cetvel' => 'yildiz-teknik-2022',
        'notlar' => 'EK-2 Dr. Öğr. Üyesi, Mimarlık/Planlama/Tasarım: 1(a,b,c) 40, 6 → 5, toplam 100.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Mimarlık, Planlama ve Tasarım', [
            ...$asgariPuanlar(['1(a,b,c)' => 40, '6' => 5]),
            Kalip::toplam(100),
            $bolumOrtalamasi('Dr. Öğretim Üyesi'),
        ]),
    ],
    [
        'anahtar' => 'ytu-dr-sosyal',
        'universite' => 'Yıldız Teknik Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $sosyal,
        'cetvel' => 'yildiz-teknik-2022',
        'notlar' => 'EK-2 Dr. Öğr. Üyesi, Sosyal/Eğitim/Filoloji: 1(a,b,c) 40, 6 → 5, toplam 100.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Sosyal Bilimler / Eğitim / Filoloji', [
            ...$asgariPuanlar(['1(a,b,c)' => 40, '6' => 5]),
            Kalip::toplam(100),
            $bolumOrtalamasi('Dr. Öğretim Üyesi'),
        ]),
    ],
    [
        'anahtar' => 'ytu-dr-hukuk',
        'universite' => 'Yıldız Teknik Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['hukuk'],
        'cetvel' => 'yildiz-teknik-2022',
        'notlar' => 'EK-2 Dr. Öğr. Üyesi, Hukuk: 1(a,b,c) 40, 6 → 5, toplam 100.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Hukuk', [
            ...$asgariPuanlar(['1(a,b,c)' => 40, '6' => 5]),
            Kalip::toplam(100),
            $bolumOrtalamasi('Dr. Öğretim Üyesi'),
        ]),
    ],

    // ══════════════════ DOÇENT ══════════════════ (toplam 200)
    [
        'anahtar' => 'ytu-docent-muh-fen',
        'aday_notu' => 'Mühendislik ve Fende Q1-Q3 makalelerinden 60 puan isteniyor; diğer alanlarda bu eşik 15.',
        'universite' => 'Yıldız Teknik Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $muhFen,
        'cetvel' => 'yildiz-teknik-2022',
        'notlar' => 'EK-2 Doçent, Mühendislik/Fen: 1(a) 60, 1(a,b,c) 20, 4(a,b,c) 30 (azami 60), 6 → 20, 8(a,b,c,d) 10 (azami 30), toplam 200.',
        'sart' => Kalip::ve('Doçent — Mühendislik / Fen Bilimleri', [
            Kalip::beyan('Üniversitelerarası Kuruldan doçentlik unvanı almış olmak', 'MADDE 9/2'),
            ...$asgariPuanlar(['1(a)' => 60, '1(a,b,c)' => 20, '4(a,b,c)' => 30, '6' => 20, '8(a,b,c,d)' => 10]),
            Kalip::toplam(200),
            $bolumOrtalamasi('Doçent'),
        ]),
    ],
    [
        'anahtar' => 'ytu-docent-mimarlik',
        'universite' => 'Yıldız Teknik Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['mimarlik'],
        'cetvel' => 'yildiz-teknik-2022',
        'notlar' => 'EK-2 Doçent, Mimarlık: 1(a) 15, 1(a,b,c) 65, 4(a,b,c) 10, 6 → 10, 8(a,b,c,d) 10, toplam 200.',
        'sart' => Kalip::ve('Doçent — Mimarlık, Planlama ve Tasarım', [
            Kalip::beyan('Üniversitelerarası Kuruldan doçentlik unvanı almış olmak', 'MADDE 9/2'),
            ...$asgariPuanlar(['1(a)' => 15, '1(a,b,c)' => 65, '4(a,b,c)' => 10, '6' => 10, '8(a,b,c,d)' => 10]),
            Kalip::toplam(200),
            $bolumOrtalamasi('Doçent'),
        ]),
    ],
    [
        'anahtar' => 'ytu-docent-sosyal',
        'universite' => 'Yıldız Teknik Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $sosyal,
        'cetvel' => 'yildiz-teknik-2022',
        'notlar' => 'EK-2 Doçent, Sosyal/Eğitim/Filoloji: 1(a) 15, 1(a,b,c) 65, 4(a,b,c) 10, 6 → 10, 8(a,b,c,d) 10, toplam 200.',
        'sart' => Kalip::ve('Doçent — Sosyal Bilimler / Eğitim / Filoloji', [
            Kalip::beyan('Üniversitelerarası Kuruldan doçentlik unvanı almış olmak', 'MADDE 9/2'),
            ...$asgariPuanlar(['1(a)' => 15, '1(a,b,c)' => 65, '4(a,b,c)' => 10, '6' => 10, '8(a,b,c,d)' => 10]),
            Kalip::toplam(200),
            $bolumOrtalamasi('Doçent'),
        ]),
    ],
    [
        'anahtar' => 'ytu-docent-hukuk',
        'universite' => 'Yıldız Teknik Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['hukuk'],
        'cetvel' => 'yildiz-teknik-2022',
        'notlar' => 'EK-2 Doçent, Hukuk: 1(a) 15, 1(a,b,c) 65, 4(a,b,c) 5, 6 → 10, 8(a,b,c,d) 10, toplam 200.',
        'sart' => Kalip::ve('Doçent — Hukuk', [
            Kalip::beyan('Üniversitelerarası Kuruldan doçentlik unvanı almış olmak', 'MADDE 9/2'),
            ...$asgariPuanlar(['1(a)' => 15, '1(a,b,c)' => 65, '4(a,b,c)' => 5, '6' => 10, '8(a,b,c,d)' => 10]),
            Kalip::toplam(200),
            $bolumOrtalamasi('Doçent'),
        ]),
    ],

    // ══════════════════ PROFESÖR ══════════════════ (toplam 400)
    // "Asgari puanların (5(a,b) hariç) en az %50'si ÜAK doçentlik tarihinden
    // sonraki faaliyetlerle alınmış olmalı."
    [
        'anahtar' => 'ytu-profesor-muh-fen',
        'aday_notu' => 'Toplam 400 puanın en az yarısı doçentlik unvanını aldığınız tarihten sonraki çalışmalardan gelmeli.',
        'universite' => 'Yıldız Teknik Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $muhFen,
        'cetvel' => 'yildiz-teknik-2022',
        'notlar' => 'EK-2 Profesör, Mühendislik/Fen: 1(a) 140, 1(a,b,c) 20, 4(a,b,c) 40, 5(a,b) 6, 6 → 40, 8(a,b,c,d) 10, toplam 400.',
        'sart' => Kalip::ve('Profesör — Mühendislik / Fen Bilimleri', [
            ...$asgariPuanlar(['1(a)' => 140, '1(a,b,c)' => 20, '4(a,b,c)' => 40, '5(a,b)' => 6, '6' => 40, '8(a,b,c,d)' => 10]),
            Kalip::toplam(400),
            Kalip::toplam(200, Kalip::DOCENTLIK_SONRASI),
            $bolumOrtalamasi('Profesör'),
        ]),
    ],
    [
        'anahtar' => 'ytu-profesor-mimarlik',
        'aday_notu' => 'Toplam 400 puanın en az yarısı doçentlik unvanını aldığınız tarihten sonraki çalışmalardan gelmeli.',
        'universite' => 'Yıldız Teknik Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['mimarlik'],
        'cetvel' => 'yildiz-teknik-2022',
        'notlar' => 'EK-2 Profesör, Mimarlık: 1(a) 30, 1(a,b,c) 130, 4(a,b,c) 20, 5(a,b) 4, 6 → 25, 8(a,b,c,d) 10, toplam 400.',
        'sart' => Kalip::ve('Profesör — Mimarlık, Planlama ve Tasarım', [
            ...$asgariPuanlar(['1(a)' => 30, '1(a,b,c)' => 130, '4(a,b,c)' => 20, '5(a,b)' => 4, '6' => 25, '8(a,b,c,d)' => 10]),
            Kalip::toplam(400),
            Kalip::toplam(200, Kalip::DOCENTLIK_SONRASI),
            $bolumOrtalamasi('Profesör'),
        ]),
    ],
    [
        'anahtar' => 'ytu-profesor-sosyal',
        'aday_notu' => 'Toplam 400 puanın en az yarısı doçentlik unvanını aldığınız tarihten sonraki çalışmalardan gelmeli.',
        'universite' => 'Yıldız Teknik Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $sosyal,
        'cetvel' => 'yildiz-teknik-2022',
        'notlar' => 'EK-2 Profesör, Sosyal/Eğitim/Filoloji: 1(a) 30, 1(a,b,c) 130, 4(a,b,c) 20, 5(a,b) 4, 6 → 25, 8(a,b,c,d) 10, toplam 400.',
        'sart' => Kalip::ve('Profesör — Sosyal Bilimler / Eğitim / Filoloji', [
            ...$asgariPuanlar(['1(a)' => 30, '1(a,b,c)' => 130, '4(a,b,c)' => 20, '5(a,b)' => 4, '6' => 25, '8(a,b,c,d)' => 10]),
            Kalip::toplam(400),
            Kalip::toplam(200, Kalip::DOCENTLIK_SONRASI),
            $bolumOrtalamasi('Profesör'),
        ]),
    ],
    [
        'anahtar' => 'ytu-profesor-hukuk',
        'aday_notu' => 'Hukukta tez danışmanlığı asgari puanı aranmıyor; toplam 400 puanın en az yarısı doçentlik sonrası olmalı.',
        'universite' => 'Yıldız Teknik Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['hukuk'],
        'cetvel' => 'yildiz-teknik-2022',
        'notlar' => 'EK-2 Profesör, Hukuk: 1(a) 20, 1(a,b,c) 140, 4(a,b,c) 10, 6 → 25, 8(a,b,c,d) 10, toplam 400. 5(a,b) satırı Hukukta boş.',
        'sart' => Kalip::ve('Profesör — Hukuk', [
            ...$asgariPuanlar(['1(a)' => 20, '1(a,b,c)' => 140, '4(a,b,c)' => 10, '6' => 25, '8(a,b,c,d)' => 10]),
            Kalip::toplam(400),
            Kalip::toplam(200, Kalip::DOCENTLIK_SONRASI),
            $bolumOrtalamasi('Profesör'),
        ]),
    ],
];
