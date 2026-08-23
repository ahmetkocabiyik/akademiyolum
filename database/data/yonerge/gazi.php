<?php

/**
 * GAZİ ÜNİVERSİTESİ — Akademik Yükseltilme ve Atanma Kriterleri Yönergesi
 * Kaynak: pdf/17536994742.gaziuniverstesi.pdf (01.01.2024 kalıcı sürüm)
 *
 * Yönerge iki dönem içeriyor: 01.07.2023-31.12.2023 geçici ve 01.01.2024
 * kalıcı. KALICI sürüm girildi.
 *
 * MADDE 6 alanları DÖRT gruba ayırıyor ve grubu fakülte belirliyor:
 *
 *   A1 Fen ve Mühendislik   Fen, Mühendislik, Teknoloji fakülteleri
 *   A2 Sağlık               Tıp, Diş, Eczacılık, Sağlık Bilimleri, Hemşirelik
 *   A3 Sosyal               Gazi Eğitim Fakültesi, Yabancı Diller YO, Spor Bil.
 *   A4 Mimarlık             Mimarlık Fakültesi
 *
 * DİKKAT — alan eşlemesi sezgisel değil: Gazi Eğitim Fakültesi ve Yabancı
 * Diller Yüksekokulu SOSYAL BİLİMLER kriterlerine tabi, Spor Bilimleri
 * Fakültesi de öyle (Sağlık Bilimleri Enstitüsü anabilim dalları hariç, md. 6
 * ** dipnotu). Bu yüzden `egitim`, `filoloji` ve `spor` alanları A3'e bağlandı.
 *
 * İLAHİYAT, HUKUK, GÜZEL SANATLAR ve ZİRAAT madde 6 tablosunda YOK; bu
 * alanlarda eşik girilmedi.
 *
 * ORTAK YAPI — dört grupta da aynı: her kadroda bir toplam puan barajı, bir
 * makale sayısı/puanı koşulu ve bir proje koşulu var. Proje koşulu her yerde
 * makaleyle telafi edilebiliyor ("Bu kriter sağlanamıyorsa … 30 puan almak"),
 * bu yüzden motorun `telafi` dalıyla kuruldu.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/gazi-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

/**
 * "En az 1 projede yürütücü olarak görev almak. Bu kriter sağlanamıyorsa …
 * MAKALELER etkinliğinden 30 puan almak."
 *
 * @param  list<string>  $telafiKumesi
 * @return array<string, mixed>
 */
$projeKosulu = fn (array $telafiKumesi, string $rolMetni = 'yürütücü'): array => Kalip::adet(
    "En az 1 projede {$rolMetni} olarak görev almak", ['PROJE-e-haric-yurutucu'], 1,
) + ['telafi' => Kalip::puanDan('Proje yoksa: makalelerden ilave 30 puan', array_values($telafiKumesi), 30)];

/** Doçent ve profesörde tekrarlayan, belgeyle teyit edilen kıdem koşulları. */
$docentKidem = fn (): array => Kalip::ve('Kıdem ve ders yükü koşulları', [
    Kalip::beyan('ÜAK tarafından verilen doçent unvanına sahip olmak', 'Kriter 1'),
    Kalip::metrik('Doktora sonrası en az 4 dönem (2 yıl) ders vermiş olmak', 'ders_yariyil', 4, Kalip::DOKTORA_SONRASI),
    Kalip::beyan('Doktora sonrası en az 2 yıl yükseköğretim kurumunda tam zamanlı görev', 'Kriter 2'),
]);

$profesorKidem = fn (): array => Kalip::ve('Kıdem ve ders yükü koşulları', [
    Kalip::metrik('Doçentlik sonrası en az 2 dönem (1 yıl) ders vermiş olmak', 'ders_yariyil', 2, Kalip::DOCENTLIK_SONRASI),
    Kalip::beyan('Doçent unvanı sonrası en az 5 yıl alanında çalışmış olmak (en az 1 yılı yükseköğretim kurumunda)', 'Kriter 1'),
]);

return [
    // ══════════════════ A1 · FEN VE MÜHENDİSLİK BİLİMLERİ ══════════════════
    [
        'anahtar' => 'gazi-dr-fen-muh',
        'aday_notu' => 'Doktora tezinden üretilmiş ve ilk isim olduğunuz bir yayın isteniyor; yoksa tez dışı iki yayınla karşılanabiliyor.',
        'universite' => 'Gazi Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['fen', 'muhendislik'],
        'cetvel' => 'gazi-2024',
        'notlar' => 'A1 Dr. Öğr. Üyesi. Kriter 1) 1a-c kapsamında ilk isim olduğu doktora tezinden bir yayın; sağlanamıyorsa tez dışı iki yayın. Kriter 2) 1-5 kapsamında en az 150 puan. Toplam en az 200 puan.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Fen ve Mühendislik', [
            Kalip::adet('WoS Q1-Q3 dergide ilk isim olduğunuz, doktora tezinden üretilmiş 1 yayın', ['1a-c'], 1, 'ilk')
                + ['telafi' => Kalip::adet('Tez yayını yoksa: ilk isim olduğunuz, tez dışı 2 yayın', ['1a-c'], 2, 'ilk')],
            Kalip::puanDan('WoS Q1-Q4 dergilerindeki makale, derleme, kısa makale ve teknik notlarınızdan en az 150 puan', ['1-5'], 150),
            Kalip::toplam(200),
        ]),
    ],
    [
        'anahtar' => 'gazi-docent-fen-muh',
        'aday_notu' => 'Dört yayının WoS Q1-Q3 dergilerinde olması gerekiyor; toplam 200 puanın kaynağı ise 1-5 bloğunun tamamı. Proje koşulu 30 puanlık ilave makaleyle telafi edilebiliyor.',
        'universite' => 'Gazi Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['fen', 'muhendislik'],
        'cetvel' => 'gazi-2024',
        'notlar' => 'A1 Doçent. Kriter 3) 1a-c kapsamında en az dört yayın şartıyla 1-5 kapsamında en az 200 puan. Kriter 4) en az 1 projede yürütücü. Toplam en az 350 puan.',
        'sart' => Kalip::ve('Doçent — Fen ve Mühendislik', [
            Kalip::adet('WoS Q1-Q3 dergilerde en az 4 yayın', ['1a-c'], 4) + ['haric' => ['lisansustu_tezden']],
            Kalip::puanDan('WoS Q1-Q4 dergilerindeki makale, derleme, kısa makale ve teknik notlarınızdan en az 200 puan', ['1-5'], 200),
            $projeKosulu(['1a-c']),
            $docentKidem(),
            Kalip::toplam(350),
        ]),
    ],
    [
        'anahtar' => 'gazi-profesor-fen-muh',
        'aday_notu' => 'Doçentlik unvanını aldığınız tarihten sonraki çalışmalar değerlendiriliyor.',
        'universite' => 'Gazi Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['fen', 'muhendislik'],
        'cetvel' => 'gazi-2024',
        'notlar' => 'A1 Profesör. Kriter 2) 1a-c kapsamında en az beş yayın şartıyla 1-5 kategorisinden en az 270 puan. Toplam en az 400 puan.',
        'sart' => Kalip::ve('Profesör — Fen ve Mühendislik', [
            Kalip::adet('Doçentlik sonrası WoS Q1-Q3 dergilerde en az 5 yayın', ['1a-c'], 5, donem: Kalip::DOCENTLIK_SONRASI),
            Kalip::puanDan('WoS Q1-Q4 dergilerindeki makale, derleme, kısa makale ve teknik notlarınızdan en az 270 puan', ['1-5'], 270, Kalip::DOCENTLIK_SONRASI),
            $projeKosulu(['1a-c']),
            $profesorKidem(),
            Kalip::toplam(400, Kalip::DOCENTLIK_SONRASI),
        ]),
    ],

    // ══════════════════ A2 · SAĞLIK BİLİMLERİ ══════════════════
    [
        'anahtar' => 'gazi-dr-saglik',
        'aday_notu' => 'Sağlıkta puan kümesi 1-4 ve 6a; kongre bildirisi bloğu (5) sayılmıyor.',
        'universite' => 'Gazi Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['saglik'],
        'cetvel' => 'gazi-2024',
        'notlar' => 'A2 Dr. Öğr. Üyesi. Kriter 1) 1a-d kapsamında ilk isim olduğu doktora/uzmanlık tezinden bir yayın. Kriter 2) 1-4 ve 6a kapsamında en az 150 puan. Toplam en az 200 puan.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Sağlık Bilimleri', [
            Kalip::adet('WoS dergide ilk isim olduğunuz, doktora/uzmanlık tezinden üretilmiş 1 yayın', ['1a-d'], 1, 'ilk')
                + ['telafi' => Kalip::adet('Tez yayını yoksa: ilk isim olduğunuz, tez dışı 2 yayın', ['1a-c'], 2, 'ilk')],
            Kalip::puanDan('WoS Q1-Q4 ile WoS All Databases/Scopus dergilerindeki makalelerinizden en az 150 puan', ['1-4 ve 6a'], 150),
            Kalip::toplam(200),
        ]),
    ],
    [
        'anahtar' => 'gazi-docent-saglik',
        'aday_notu' => 'Sağlıkta yayın sayısı düşük (iki) ama bunların Q1-Q2 dergilerde olması gerekiyor.',
        'universite' => 'Gazi Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['saglik'],
        'cetvel' => 'gazi-2024',
        'notlar' => 'A2 Doçent. Kriter 3) 1a-b kapsamında en az iki yayın şartıyla 1-4 ve 6a kapsamında en az 200 puan. Toplam en az 350 puan.',
        'sart' => Kalip::ve('Doçent — Sağlık Bilimleri', [
            Kalip::adet('WoS Q1-Q2 dergilerde en az 2 yayın', ['1a-b'], 2) + ['haric' => ['lisansustu_tezden']],
            Kalip::puanDan('WoS Q1-Q4 ile WoS All Databases/Scopus dergilerindeki makalelerinizden en az 200 puan', ['1-4 ve 6a'], 200),
            $projeKosulu(['1a-c']),
            $docentKidem(),
            Kalip::toplam(350),
        ]),
    ],
    [
        'anahtar' => 'gazi-profesor-saglik',
        'aday_notu' => 'Doçentlik unvanını aldığınız tarihten sonraki çalışmalar değerlendiriliyor.',
        'universite' => 'Gazi Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['saglik'],
        'cetvel' => 'gazi-2024',
        'notlar' => 'A2 Profesör. Kriter 2) 1a-c kapsamında en az dört yayın şartıyla 1-4 ve 6a kapsamında en az 270 puan. Toplam en az 400 puan.',
        'sart' => Kalip::ve('Profesör — Sağlık Bilimleri', [
            Kalip::adet('Doçentlik sonrası WoS Q1-Q3 dergilerde en az 4 yayın', ['1a-c'], 4, donem: Kalip::DOCENTLIK_SONRASI),
            Kalip::puanDan('WoS Q1-Q4 ile WoS All Databases/Scopus dergilerindeki makalelerinizden en az 270 puan', ['1-4 ve 6a'], 270, Kalip::DOCENTLIK_SONRASI),
            $projeKosulu(['1a-c']),
            $profesorKidem(),
            Kalip::toplam(400, Kalip::DOCENTLIK_SONRASI),
        ]),
    ],

    // ══════════════════ A3 · SOSYAL BİLİMLER ══════════════════
    // Gazi Eğitim Fakültesi, Yabancı Diller YO ve Spor Bilimleri Fakültesi
    // bu gruba tabi (md. 6 tablosu ve ** dipnotu).
    [
        'anahtar' => 'gazi-dr-sosyal',
        'aday_notu' => 'Sosyal Bilimlerde puan kümesi en geniş: kitap kalemleri de doçentlik ve profesörlük barajına giriyor.',
        'universite' => 'Gazi Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['sosyal', 'egitim', 'filoloji', 'spor'],
        'cetvel' => 'gazi-2024',
        'notlar' => 'A3 Dr. Öğr. Üyesi. Kriter 2) 1-5, 6a-b, 7a-b ve 8a-b kapsamında en az 120 puan. Toplam en az 180 puan.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Sosyal Bilimler', [
            Kalip::adet('WoS dergide ilk isim olduğunuz, doktora tezinden üretilmiş 1 yayın', ['1a-d'], 1, 'ilk')
                + ['telafi' => Kalip::adet('Tez yayını yoksa: ilk isim olduğunuz, tez dışı 2 yayın', ['1a-d'], 2, 'ilk')],
            Kalip::puanDan('WoS, Scopus, uluslararası alan indeksli ve TR-Dizin dergilerindeki makalelerinizden en az 120 puan', ['1-5, 6a-b, 7a-b, 8a-b'], 120),
            Kalip::toplam(180),
        ]),
    ],
    [
        'anahtar' => 'gazi-docent-sosyal',
        'aday_notu' => 'Puan barajına MAKALELER ile birlikte KİTAP etkinliği de giriyor (kitaptan en fazla 60 puan).',
        'universite' => 'Gazi Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['sosyal', 'egitim', 'filoloji', 'spor'],
        'cetvel' => 'gazi-2024',
        'notlar' => 'A3 Doçent. Kriter 3) 1a-d, 6a-b ve 7a-b kapsamında en az iki yayın şartıyla MAKALELER 1-5, 6a-b, 7a-b, 8a-b ve KİTAP 1a-k kapsamında en az 180 puan. Toplam en az 300 puan.',
        'sart' => Kalip::ve('Doçent — Sosyal Bilimler', [
            Kalip::adet('WoS, SCOPUS veya uluslararası alan indeksli dergilerde en az 2 yayın', ['1a-d, 6a-b, 7a-b'], 2)
                + ['haric' => ['lisansustu_tezden']],
            Kalip::puanDan('Makale ve kitap kalemlerinizden en az 180 puan', ['1-5, 6a-b, 7a-b, 8a-b', 'KITAP 1a-k'], 180),
            $projeKosulu(['1a-d, 6a-b, 7a-b']),
            $docentKidem(),
            Kalip::toplam(300),
        ]),
    ],
    [
        'anahtar' => 'gazi-profesor-sosyal',
        'aday_notu' => 'Doçentlik unvanını aldığınız tarihten sonraki çalışmalar değerlendiriliyor.',
        'universite' => 'Gazi Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['sosyal', 'egitim', 'filoloji', 'spor'],
        'cetvel' => 'gazi-2024',
        'notlar' => 'A3 Profesör. Kriter 2) 1a-d, 6a-b ve 7a-b kapsamında en az iki yayın şartı ile 1a-d, 6a-b, 7a-b, 8a-b ve KİTAP 1a-k kategorilerinden en az 250 puan. Toplam en az 350 puan.',
        'sart' => Kalip::ve('Profesör — Sosyal Bilimler', [
            Kalip::adet('Doçentlik sonrası WoS, SCOPUS veya alan indeksli dergilerde en az 2 yayın',
                ['1a-d, 6a-b, 7a-b'], 2, donem: Kalip::DOCENTLIK_SONRASI),
            Kalip::puanDan('Makale ve kitap kalemlerinizden en az 250 puan',
                ['1-5, 6a-b, 7a-b, 8a-b', 'KITAP 1a-k'], 250, Kalip::DOCENTLIK_SONRASI),
            $projeKosulu(['1a-d, 6a-b, 7a-b']),
            $profesorKidem(),
            Kalip::toplam(350, Kalip::DOCENTLIK_SONRASI),
        ]),
    ],

    // ══════════════════ A4 · MİMARLIK FAKÜLTESİ ══════════════════
    // Sosyal ile aynı eşikler, tek fark: 8a-b (TR-Dizin) bloğu puan kümesinde yok.
    [
        'anahtar' => 'gazi-dr-mimarlik',
        'aday_notu' => 'Mimarlıkta puan kümesi Sosyal Bilimlerle aynı, tek fark TR-Dizin bloğunun sayılmaması.',
        'universite' => 'Gazi Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['mimarlik'],
        'cetvel' => 'gazi-2024',
        'notlar' => 'A4 Dr. Öğr. Üyesi. Kriter 2) 1-5, 6a-b ve 7a-b kapsamında en az 120 puan. Toplam en az 180 puan.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Mimarlık', [
            Kalip::adet('WoS dergide ilk isim olduğunuz, doktora/sanatta yeterlik tezinden üretilmiş 1 yayın', ['1a-d'], 1, 'ilk')
                + ['telafi' => Kalip::adet('Tez yayını yoksa: ilk isim olduğunuz, tez dışı 2 yayın', ['1a-d'], 2, 'ilk')],
            Kalip::puanDan('WoS, Scopus ve uluslararası alan indeksli dergilerindeki makalelerinizden en az 120 puan', ['1-5, 6a-b, 7a-b'], 120),
            Kalip::toplam(180),
        ]),
    ],
    [
        'anahtar' => 'gazi-docent-mimarlik',
        'aday_notu' => 'Puan barajına MAKALELER ile birlikte KİTAP etkinliği de giriyor (kitaptan en fazla 60 puan).',
        'universite' => 'Gazi Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['mimarlik'],
        'cetvel' => 'gazi-2024',
        'notlar' => 'A4 Doçent. Kriter 3) 1a-d, 6a-b ve 7a-b kapsamında en az iki yayın şartıyla MAKALELER 1-5, 6a-b, 7a-b ve KİTAP 1a-k kapsamında en az 180 puan. Toplam en az 300 puan.',
        'sart' => Kalip::ve('Doçent — Mimarlık', [
            Kalip::adet('WoS, SCOPUS veya uluslararası alan indeksli dergilerde en az 2 yayın', ['1a-d, 6a-b, 7a-b'], 2)
                + ['haric' => ['lisansustu_tezden']],
            Kalip::puanDan('Makale ve kitap kalemlerinizden en az 180 puan', ['1-5, 6a-b, 7a-b', 'KITAP 1a-k'], 180),
            $projeKosulu(['1a-d, 6a-b, 7a-b']),
            $docentKidem(),
            Kalip::toplam(300),
        ]),
    ],
    [
        'anahtar' => 'gazi-profesor-mimarlik',
        'aday_notu' => 'Doçentlik unvanını aldığınız tarihten sonraki çalışmalar değerlendiriliyor.',
        'universite' => 'Gazi Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['mimarlik'],
        'cetvel' => 'gazi-2024',
        'notlar' => 'A4 Profesör. Kriter 2) 1a-d, 6a-b ve 7a-b kapsamında en az iki yayın şartıyla 1-5, 6a-b, 7a-b ve KİTAP 1a-k kapsamında en az 250 puan. Toplam en az 350 puan.',
        'sart' => Kalip::ve('Profesör — Mimarlık', [
            Kalip::adet('Doçentlik sonrası WoS, SCOPUS veya alan indeksli dergilerde en az 2 yayın',
                ['1a-d, 6a-b, 7a-b'], 2, donem: Kalip::DOCENTLIK_SONRASI),
            Kalip::puanDan('Makale ve kitap kalemlerinizden en az 250 puan',
                ['1-5, 6a-b, 7a-b', 'KITAP 1a-k'], 250, Kalip::DOCENTLIK_SONRASI),
            $projeKosulu(['1a-d, 6a-b, 7a-b']),
            $profesorKidem(),
            Kalip::toplam(350, Kalip::DOCENTLIK_SONRASI),
        ]),
    ],
];
