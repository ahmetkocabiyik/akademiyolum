<?php

/**
 * BURSA ULUDAĞ ÜNİVERSİTESİ — şart ağaçları.
 *
 * Kaynak: pdf/1766060294419.bursa-uludag-kriter-18122025.pdf
 * Cetvel: uak-2024-mart-{alan} — yönergenin kendi puan tablosu yok, MADDE 6
 * doğrudan ÜAK 2024 Mart puan sistemine gönderiyor.
 *
 * ARKETİP: puanlamayı dış cetvele devreden yönerge. Tablo-1 ve Tablo-2 birer
 * eşik tablosu; sütunları doğrudan ağaç düğümü oluyor ([A] ve [B] birer çocuk,
 * [C] sütunu ilgili koşulun `telafi` dalı).
 *
 * ── PUANLAMA KAYNAĞI ────────────────────────────────────────────────────────
 * Değerlendirme Esasları madde 6: "...Üniversitelerarası Kurul tarafından kabul
 * edilen 2024 Mart Doçentlik Başvuru Şartlarında belirlenen puan sistemi esas
 * alınır." Puan koşulları bu cetvele bağlı:
 *   'cetvel' => 'uak-2024-mart-{alan}'  (ÜAK her temel alan için ayrı tablo yayımlar)
 *
 * Yönergenin atıf yaptığı dönemin ta kendisi kullanılıyor; ayrıntı ve kapsam
 * sınırları için database/data/cetvel/_uak-NOTLAR.md.
 *
 * Yıldızlı dipnotlar (Tablo-1 ve Tablo-2 altı):
 *   *  "Aday bu kapsamdaki en az bir yayında birinci isim veya başlıca yazar olmalıdır."
 *   ** "Aday bu kapsamdaki en az bir projede yürütücü/koordinatör olmalıdır."
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · şema: sart-agaci-taslak.php
 */

use App\Services\Scoring\Sart\Kalip;

/**
 * Değerlendirme Esasları madde 5 — birimin öğretim diline göre kademeli.
 * Madde 5'in revize hâli 01/04/2027'de yürürlüğe girecek (Dr. Öğr. Üyesi için
 * %30 yabancı dilde eğitim veren birimlerde 65 → 85); burada yürürlükteki
 * değerler kayıtlı.
 *
 * @return array<string, mixed>
 */
$dil = fn (): array => [
    'tip' => 'metrik',
    'aciklama' => 'Yabancı dil sınavı (YDS/YÖKDİL) asgari puanı — biriminizin öğretim diline göre değişir',
    'madde' => 'Değerlendirme Esasları md. 5',
    'metrik' => 'yds',
    'kademeler' => [
        'turkce' => 65,
        'yabanci_dil_30' => 65,
        'yabanci_dil_100' => 85,
        'yabanci_dil_egitimi' => 90,
    ],
];

/**
 * Tablo-1/Tablo-2'nin tekrar eden kalıbı: "en az N puanı şu kaynaklardan olmak
 * üzere diğer faaliyetlerle birlikte en az 90 puan."
 *
 * @param  list<string>  $maddeler  Payı oluşturan ÜAK madde grupları
 * @return array<string, mixed>
 */
$puanKosulu = fn (string $aciklama, array $maddeler, int $enAz, string $madde): array => Kalip::ve(
    $aciklama,
    [
        Kalip::puanDan("Bu kaynaklardan en az {$enAz} puan", array_values($maddeler), $enAz, madde: $madde),
        Kalip::toplam(90),
    ],
);

return [

    // ══ Tablo-1 · DOKTOR ÖĞRETİM ÜYELİĞİ ══

    // [A] saf adet koşulu → hesaplanıyor. [C] yedeği puana bağlı → beyan.
    [
        'anahtar' => 'uludag-dr-adet',
        'aday_notu' => 'Puanlar üniversitenin kendi cetveline göre değil, ÜAK 2024 Mart Doçentlik Başvuru Şartları ölçeğine göre hesaplanıyor.',
        'universite' => 'Bursa Uludağ Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['filoloji', 'guzel_sanatlar', 'hukuk', 'ilahiyat'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Tablo-1, [A]: "SCIE/SSCI/AHCI Q1, Q2 veya Q3 dergilerinde* en az 1 makale." '
            .'[C]: "[A] koşulunun sağlanamaması durumunda YÖK-2024 Mart Dönemi Doçentlik Başvuru '
            .'Şartlarına göre en az 50 puanı 1, 2a kapsamındaki dergilerden ve/veya 7a\'dan olmak '
            .'üzere diğer faaliyetlerle birlikte en az 90 puan." (Güzel Sanatlar\'da [C] yalnızca '
            .'"en az 90 puan" der, madde kısıtı yoktur.)',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi atanma koşulları', [
            Kalip::adet(
                'SCIE/SSCI veya AHCI Q1-Q3 dergilerinde en az 1 makale (birinci isim ya da başlıca yazar olarak)',
                ['AQ1-Q3'], 1, 'baslica', madde: 'Tablo-1 · [A]',
                telafi: $puanKosulu('Makale şartını sağlayamazsanız: puanla karşılama yolu', ['1-2a', '7a'], 50, 'Tablo-1 · [C]'),
            ),
            $dil(),
        ]),
    ],
    [
        'anahtar' => 'uludag-dr-adet-sosyal',
        'aday_notu' => 'Puanlar üniversitenin kendi cetveline göre değil, ÜAK 2024 Mart Doçentlik Başvuru Şartları ölçeğine göre hesaplanıyor.',
        'universite' => 'Bursa Uludağ Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['sosyal'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Tablo-1, Sosyal-Beşeri-İdari Bilimler. [A] AHCI\'yi KAPSAMAZ: '
            .'"SCIE/SSCI Q1, Q2 veya Q3 dergilerinde* en az 1 makale."',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi atanma koşulları', [
            Kalip::adet(
                'SCIE/SSCI Q1-Q3 dergilerinde en az 1 makale (birinci isim ya da başlıca yazar olarak)',
                ['Q1-Q3'], 1, 'baslica', madde: 'Tablo-1 · [A]',
                telafi: $puanKosulu('Makale şartını sağlayamazsanız: puanla karşılama yolu', ['1-2a', '7a'], 50, 'Tablo-1 · [C]'),
            ),
            $dil(),
        ]),
    ],

    // [A] tamamen puana bağlı → beyan. Yıldızlı dipnotlar hesaplanabildiği için ayrı düğüm.
    [
        'anahtar' => 'uludag-dr-puan-q12',
        'aday_notu' => 'Puanlar üniversitenin kendi cetveline göre değil, ÜAK 2024 Mart Doçentlik Başvuru Şartları ölçeğine göre hesaplanıyor.',
        'universite' => 'Bursa Uludağ Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['fen', 'muhendislik', 'ziraat'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Tablo-1: "YÖK-2024 Mart Dönemi Doçentlik Başvuru Şartlarına göre en az 50 puanı '
            .'SCIE/SSCI Q1 veya Q2 dergilerinden* veya 7a\'dan** olmak üzere diğer faaliyetlerle '
            .'birlikte en az 90 puan." Bu alanlarda [C] sütunu boş.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi atanma koşulları', [
            $puanKosulu('SCIE/SSCI Q1-Q2 dergilerinden veya proje yürütücülüğünden 50, toplam 90 puan', ['Q1-Q2', '7a'], 50, 'Tablo-1 · [A]'),
            Kalip::veya('Puanı hangi yoldan topladığınıza göre ek şart', [
                Kalip::adet('Q1/Q2 yayınlarınızdan en az birinde birinci isim ya da başlıca yazar olmalısınız', ['Q1-Q2'], 1, 'baslica', madde: 'Tablo-1 dipnot *'),
                Kalip::metrik('En az bir araştırma projesinde yürütücü veya koordinatör olmak', 'proje_yurutuculuk', 1),
            ]),
            $dil(),
        ]),
    ],
    [
        'anahtar' => 'uludag-dr-puan-q13',
        'aday_notu' => 'Puanlar üniversitenin kendi cetveline göre değil, ÜAK 2024 Mart Doçentlik Başvuru Şartları ölçeğine göre hesaplanıyor.',
        'universite' => 'Bursa Uludağ Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['egitim', 'saglik', 'spor'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Tablo-1: "...en az 50 puanı SCIE/SSCI Q1, Q2 veya Q3 dergilerinden* veya '
            .'7a\'dan** olmak üzere diğer faaliyetlerle birlikte en az 90 puan."',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi atanma koşulları', [
            $puanKosulu('SCIE/SSCI Q1-Q3 dergilerinden veya proje yürütücülüğünden 50, toplam 90 puan', ['Q1-Q3', '7a'], 50, 'Tablo-1 · [A]'),
            Kalip::veya('Puanı hangi yoldan topladığınıza göre ek şart', [
                Kalip::adet('Q1-Q3 yayınlarınızdan en az birinde birinci isim ya da başlıca yazar olmalısınız', ['Q1-Q3'], 1, 'baslica', madde: 'Tablo-1 dipnot *'),
                Kalip::metrik('En az bir araştırma projesinde yürütücü veya koordinatör olmak', 'proje_yurutuculuk', 1),
            ]),
            $dil(),
        ]),
    ],
    [
        'anahtar' => 'uludag-dr-puan-mimarlik',
        'aday_notu' => 'Puanlar üniversitenin kendi cetveline göre değil, ÜAK 2024 Mart Doçentlik Başvuru Şartları ölçeğine göre hesaplanıyor.',
        'universite' => 'Bursa Uludağ Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['mimarlik'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Tablo-1, Mimarlık: "...en az 50 puanı SCIE/SSCI/AHCI Q1, Q2 veya Q3 kapsamındaki '
            .'(en az bir makalenin SCIE/SSCI Q1, Q2 veya Q3\'de taranan dergilerde yayınlanması '
            .'zorunludur) dergilerinden* veya 7a\'dan** olmak üzere diğer faaliyetlerle birlikte '
            .'en az 90 puan."',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi atanma koşulları', [
            $puanKosulu('SCIE/SSCI Q1-Q3 dergilerinden veya proje yürütücülüğünden 50, toplam 90 puan', ['Q1-Q3', '7a'], 50, 'Tablo-1 · [A]'),
            Kalip::adet('En az bir makaleniz SCIE/SSCI Q1-Q3 dergisinde olmalı (AHCI bu şarta sayılmaz)', ['Q1-Q3'], 1),
            Kalip::veya('Puanı hangi yoldan topladığınıza göre ek şart', [
                Kalip::adet('Q1-Q3 yayınlardan en az birinde birinci isim veya başlıca yazar', ['AQ1-Q3'], 1, 'baslica'),
                Kalip::metrik('En az bir araştırma projesinde yürütücü veya koordinatör olmak', 'proje_yurutuculuk', 1),
            ]),
            $dil(),
        ]),
    ],

    // ══ Tablo-2 · DOÇENTLİK ══ (her alanda [A] + [B])

    [
        'anahtar' => 'uludag-docent-adet',
        'aday_notu' => 'Puanlar üniversitenin kendi cetveline göre değil, ÜAK 2024 Mart Doçentlik Başvuru Şartları ölçeğine göre hesaplanıyor.',
        'universite' => 'Bursa Uludağ Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['filoloji', 'guzel_sanatlar', 'hukuk', 'ilahiyat'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Tablo-2, "Atanma Koşulu" sütunu birebir "[A] + [B]". '
            .'[A]: "YÖK-2024 Mart Dönemi Doçentlik Başvuru Şartlarına göre en az 100 puan." '
            .'[B]: "SCIE/SSCI/AHCI Q1, Q2 veya Q3 dergilerinde en az 1 makale* veya 7a\'dan en az '
            .'1 koordinatörlük-yürütücülük." [C]: "[B] koşulunun sağlanamaması durumunda ... en az '
            .'60 puanı 1, 2a kapsamındaki dergilerden ve/veya 7a\'dan karşılanmak üzere diğer '
            .'faaliyetlerle birlikte en az 90 puan."',
        'sart' => Kalip::ve('Doçentlik kadrosu atanma koşulları', [
            Kalip::toplam(100),
            Kalip::veya('Q1-Q3 dergide makale ya da proje yürütücülüğü', [
                Kalip::adet('SCIE/SSCI veya AHCI Q1-Q3 dergilerinde en az 1 makale (birinci isim ya da başlıca yazar olarak)', ['AQ1-Q3'], 1, 'baslica', madde: 'Tablo-2 · [B]'),
                Kalip::metrik('En az bir araştırma projesinde yürütücü veya koordinatör olmak', 'proje_yurutuculuk', 1),
            ], telafi: $puanKosulu('Bu şartı sağlayamazsanız: puanla karşılama yolu', ['1-2a', '7a'], 60, 'Tablo-2 · [C]')),
            $dil(),
        ]),
    ],
    [
        'anahtar' => 'uludag-docent-adet-sosyal',
        'aday_notu' => 'Puanlar üniversitenin kendi cetveline göre değil, ÜAK 2024 Mart Doçentlik Başvuru Şartları ölçeğine göre hesaplanıyor.',
        'universite' => 'Bursa Uludağ Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['sosyal'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Tablo-2, Sosyal-Beşeri-İdari Bilimler. [B] AHCI\'yi kapsamaz: "SCIE/SSCI Q1, Q2 '
            .'veya Q3 dergilerinde en az 1 makale* veya 7a\'dan en az 1 koordinatörlük-yürütücülük."',
        'sart' => Kalip::ve('Doçentlik kadrosu atanma koşulları', [
            Kalip::toplam(100),
            Kalip::veya('Q1-Q3 dergide makale ya da proje yürütücülüğü', [
                Kalip::adet('SCIE/SSCI Q1-Q3 dergilerinde en az 1 makale (birinci isim ya da başlıca yazar olarak)', ['Q1-Q3'], 1, 'baslica', madde: 'Tablo-2 · [B]'),
                Kalip::metrik('En az bir araştırma projesinde yürütücü veya koordinatör olmak', 'proje_yurutuculuk', 1),
            ], telafi: $puanKosulu('Bu şartı sağlayamazsanız: puanla karşılama yolu', ['1-2a', '7a'], 60, 'Tablo-2 · [C]')),
            $dil(),
        ]),
    ],
    [
        'anahtar' => 'uludag-docent-puan',
        'aday_notu' => 'Puanlar üniversitenin kendi cetveline göre değil, ÜAK 2024 Mart Doçentlik Başvuru Şartları ölçeğine göre hesaplanıyor.',
        'universite' => 'Bursa Uludağ Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['egitim', 'fen', 'mimarlik', 'muhendislik', 'saglik', 'ziraat', 'spor'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Tablo-2: [A] + [B], ikisi de puana bağlı. [B] alana göre "en az 60 puanı '
            .'SCIE/SSCI Q1-Q2 (veya Q1-Q3) dergilerinden* veya 7a\'dan** olmak üzere diğer '
            .'faaliyetlerle birlikte en az 90 puan." Bu alanlarda [C] sütunu boş.',
        'sart' => Kalip::ve('Doçentlik kadrosu atanma koşulları', [
            Kalip::toplam(100),
            $puanKosulu('SCIE/SSCI Q1-Q3 dergilerinden veya proje yürütücülüğünden 60, toplam 90 puan', ['Q1-Q3', '7a'], 60, 'Tablo-2 · [B]'),
            Kalip::veya('Puanı hangi yoldan topladığınıza göre ek şart', [
                Kalip::adet('Bu yayınlarınızdan en az birinde birinci isim ya da başlıca yazar olmalısınız', ['AQ1-Q3'], 1, 'baslica', madde: 'Tablo-2 dipnot *'),
                Kalip::metrik('En az bir araştırma projesinde yürütücü veya koordinatör olmak', 'proje_yurutuculuk', 1),
            ]),
            $dil(),
        ]),
    ],

    // ══ PROFESÖRLÜK ══ — doçentlik koşullarının doçentlik sonrası tekrarı

    [
        'anahtar' => 'uludag-profesor',
        'aday_notu' => 'Puanlar üniversitenin kendi cetveline göre değil, ÜAK 2024 Mart Doçentlik Başvuru Şartları ölçeğine göre hesaplanıyor.',
        'universite' => 'Bursa Uludağ Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['filoloji', 'guzel_sanatlar', 'hukuk', 'ilahiyat'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => '(C)/2: "Profesörlüğe yükseltilme ve atanmada; ... (B) başlığında ve Tablo-2\'de '
            .'belirtilen Bursa Uludağ Üniversitesi doçentliğe atanma asgari koşullarını, lisansüstü '
            .'tezlerde yayın yapma şartı hariç olmak üzere, doçent unvanı alındıktan sonra bir defa '
            .'daha sağlaması gerekir."',
        'sart' => [
            'tip' => 'referans',
            'aciklama' => 'Doçentliğe atanma koşullarını doçentlik sonrası bir kez daha sağlamak',
            'esik' => 'uludag-docent-adet-{alan}',
            'donem' => Kalip::DOCENTLIK_SONRASI,
            'haric' => ['lisansustu_tezden'],
        ],
    ],
    [
        'anahtar' => 'uludag-profesor-sosyal',
        'aday_notu' => 'Puanlar üniversitenin kendi cetveline göre değil, ÜAK 2024 Mart Doçentlik Başvuru Şartları ölçeğine göre hesaplanıyor.',
        'universite' => 'Bursa Uludağ Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['sosyal'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => '(C)/2: Tablo-2\'deki doçentlik koşulları, lisansüstü tez yayını şartı hariç, '
            .'doçentlik sonrası bir kez daha sağlanmalı.',
        'sart' => [
            'tip' => 'referans',
            'aciklama' => 'Doçentliğe atanma koşullarını doçentlik sonrası bir kez daha sağlamak',
            'esik' => 'uludag-docent-adet-sosyal-{alan}',
            'donem' => Kalip::DOCENTLIK_SONRASI,
            'haric' => ['lisansustu_tezden'],
        ],
    ],
    [
        'anahtar' => 'uludag-profesor-puan',
        'aday_notu' => 'Puanlar üniversitenin kendi cetveline göre değil, ÜAK 2024 Mart Doçentlik Başvuru Şartları ölçeğine göre hesaplanıyor.',
        'universite' => 'Bursa Uludağ Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['egitim', 'fen', 'mimarlik', 'muhendislik', 'saglik', 'ziraat', 'spor'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => '(C)/2: Tablo-2\'deki doçentlik koşulları, lisansüstü tez yayını şartı hariç, '
            .'doçentlik sonrası bir kez daha sağlanmalı.',
        'sart' => [
            'tip' => 'referans',
            'aciklama' => 'Doçentliğe atanma koşullarını doçentlik sonrası bir kez daha sağlamak',
            'esik' => 'uludag-docent-puan-{alan}',
            'donem' => Kalip::DOCENTLIK_SONRASI,
            'haric' => ['lisansustu_tezden'],
        ],
    ],
];
