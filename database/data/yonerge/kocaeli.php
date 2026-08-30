<?php

/**
 * KOCAELİ ÜNİVERSİTESİ — Öğretim Üyeliği Atama ve Yükseltme Yönergesi
 * Kaynak: pdf/1773235152642.kocaeli-kriter-11032026.pdf (Aralık 2023)
 *
 * İKİ TABLO BİRLİKTE ÇALIŞIYOR:
 *   Tablo 1  makale SAYISI ve hangi dergi kademesinden kaçı (madde 11)
 *   Tablo 2  asgari PUAN (dergi kademesi başına) ve toplam puan barajı
 * Her kadroda ikisi de sağlanmak zorunda; bu yüzden hem `adet` hem `puan`
 * düğümleri var.
 *
 * DÖRT ALAN GRUBU:
 *   1) Sağlık, Fen ve Matematik, Mühendislik, Ziraat/Orman/Su Ürünleri
 *   2) Eğitim, Filoloji, Mimarlık/Planlama/Tasarım, Sosyal, Spor
 *   3) Hukuk, İlahiyat
 *   4) Güzel Sanatlar
 *
 * A BÖLÜMÜ KÜMÜLATİF KADEMELİ: koşullar "A.1-A.2'den en az üç, A.1-A.4'ten en
 * az dört" gibi İÇ İÇE kümeler istiyor. Q1-Q2'deki üç makale aynı zamanda
 * A.1-A.4 sayısına da girer; iki düğüm ayrı ayrı sayıldığı için bu doğal
 * olarak çalışıyor.
 *
 * PROJE KOŞULU TELAFİLİ: "H faaliyetleri kapsamında projede görev almış olmak
 * koşulunu sağlayamayan adaylar; patent başvurusu veya A1-A2'de ek bir makale
 * ile de bu koşulu sağlayabilirler."
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/kocaeli-2023.php
 */

use App\Services\Scoring\Sart\Kalip;

$grup1 = ['saglik', 'fen', 'muhendislik', 'ziraat'];
$grup2 = ['egitim', 'filoloji', 'mimarlik', 'sosyal', 'spor'];
$grup3 = ['hukuk', 'ilahiyat'];

/**
 * Doçent ve profesörde tekrarlayan proje koşulu ve telafisi.
 *
 * @return array<string, mixed>
 */
$projeKosulu = fn (): array => Kalip::veya('BAP dışı araştırma projesinde görev almış olmak', [
    Kalip::adet('Desteklenen bir araştırma projesinde yürütücü veya araştırmacı olarak görev almak', ['H2', 'H3', 'H8', 'H9', 'H10', 'H11'], 1),
    Kalip::adet('Ya da desteklenen en az iki projede araştırmacı olarak görev almak', ['H13', 'H14', 'H15', 'H16'], 2),
], telafi: Kalip::adet('Proje yoksa: Q1-Q2 dergide asgari sayıya dahil edilmeyen ek 1 makale', ['A.1-A.2'], 1));

/**
 * Doçent ve profesörde tekrarlayan tez danışmanlığı koşulu.
 *
 * @return array<string, mixed>
 */
$tezKosulu = fn (int $yl, int $doktora): array => Kalip::veya(
    "En az {$yl} tamamlanmış yüksek lisans ya da {$doktora} doktora danışmanlığı",
    [
        Kalip::metrik("Bitmiş en az {$yl} yüksek lisans tez danışmanlığı", 'tez_danismanlik', $yl),
        Kalip::metrik("Bitmiş en az {$doktora} doktora tez danışmanlığı", 'doktora_tez_danismanlik', $doktora),
    ],
);

return [
    // ══════════════════ DR. ÖĞRETİM ÜYESİ ══════════════════
    [
        'anahtar' => 'kocaeli-dr-g1',
        'aday_notu' => 'Dört makalenin dağılımı kademeli: en az biri Q1-Q2, en az ikisi Q1-Q4, en az biri ESCI dâhil kümede olmalı. Ayrıca puan barajları da sağlanmalı.',
        'universite' => 'Kocaeli Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $grup1,
        'cetvel' => 'kocaeli-2023',
        'notlar' => 'Madde 11/a-1. Tablo 1: 4 makale (A.1-A.2\'den ≥1, A.1-A.4\'ten ≥2, A.1-A.5\'ten ≥1), birinde başlıca yazar. Tablo 2: A.1-A.4 ≥45, A.1-A.5 ≥5, toplam ≥100.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Sağlık / Fen / Mühendislik / Ziraat', [
            Kalip::adet('En az 4 makale', ['A.1-A.8'], 4),
            Kalip::adet('Bunların en az 1\'i Q1-Q2 dergide', ['A.1-A.2'], 1),
            Kalip::adet('En az 2\'si Q1-Q4 dergide', ['A.1-A.4'], 2),
            Kalip::adet('En az 1\'i ESCI dâhil kademede', ['A.1-A.5'], 1),
            Kalip::adet('Dört makaleden en az 1\'inde başlıca yazar olmalısınız', ['A.1-A.8'], 1, 'baslica'),
            Kalip::puanDan('SCI-E, SSCI veya AHCI dergilerindeki (Q1-Q4) makalelerinizden en az 45 puan', ['A.1-A.4'], 45),
            Kalip::puanDan('SCI-E, SSCI, AHCI veya ESCI dergilerindeki makalelerinizden en az 5 puan', ['A.1-A.5'], 5),
            Kalip::toplam(100),
        ]),
    ],
    [
        'anahtar' => 'kocaeli-dr-g2',
        'aday_notu' => 'Bu alanlarda çeyreklik şartı daha esnek: dört makalenin biri Q1-Q4, üçü ESCI dâhil kümede yeterli.',
        'universite' => 'Kocaeli Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $grup2,
        'cetvel' => 'kocaeli-2023',
        'notlar' => 'Madde 11/a-2. Tablo 1: 4 makale (A.1-A.4\'ten ≥1, A.1-A.6\'dan ≥3), birinde başlıca yazar. Tablo 2: A.1-A.4 ≥20, A.1-A.6 ≥40, toplam ≥100.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Eğitim / Filoloji / Mimarlık / Sosyal / Spor', [
            Kalip::adet('En az 4 makale', ['A.1-A.8'], 4),
            Kalip::adet('Bunların en az 1\'i Q1-Q4 dergide', ['A.1-A.4'], 1),
            Kalip::adet('En az 3\'ü ESCI dâhil kademede', ['A.1-A.6'], 3),
            Kalip::adet('Dört makaleden en az 1\'inde başlıca yazar olmalısınız', ['A.1-A.8'], 1, 'baslica'),
            Kalip::puanDan('SCI-E, SSCI veya AHCI dergilerindeki (Q1-Q4) makalelerinizden en az 20 puan', ['A.1-A.4'], 20),
            Kalip::puanDan('SCI-E, SSCI, AHCI veya ESCI dergilerindeki makalelerinizden en az 40 puan', ['A.1-A.6'], 40),
            Kalip::toplam(100),
        ]),
    ],
    [
        'anahtar' => 'kocaeli-dr-g3',
        'aday_notu' => 'Hukuk ve İlahiyatta çeyreklik şartı yok; dört makalenin tamamı ESCI dâhil kademede olabilir.',
        'universite' => 'Kocaeli Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $grup3,
        'cetvel' => 'kocaeli-2023',
        'notlar' => 'Madde 11/a-3. Tablo 1: 4 makale (A.1-A.6\'dan ≥4), birinde başlıca yazar. Tablo 2: A.1-A.6 ≥50, toplam ≥100.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Hukuk / İlahiyat', [
            Kalip::adet('SCI-E, SSCI, AHCI veya ESCI dergilerinde en az 4 makale', ['A.1-A.6'], 4),
            Kalip::adet('Bunların en az 1\'inde başlıca yazar olmalısınız', ['A.1-A.6'], 1, 'baslica'),
            Kalip::puanDan('SCI-E, SSCI, AHCI veya ESCI dergilerindeki makalelerinizden en az 50 puan', ['A.1-A.6'], 50),
            Kalip::toplam(100),
        ]),
    ],
    [
        'anahtar' => 'kocaeli-dr-g4',
        'aday_notu' => 'Güzel Sanatlarda sanatsal etkinlik zorunlu: 2 kişisel ve 8 karma etkinlik. Sağlanamıyorsa dizinli dergide ek bir makaleyle karşılanabiliyor.',
        'universite' => 'Kocaeli Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'kocaeli-2023',
        'notlar' => 'Madde 11/a-4. Tablo 1: 2 kişisel + 8 karma etkinlik, A.1-A.8\'de başlıca yazar 1 makale. Tablo 2: A.1-A.8 ≥10, toplam ≥200.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Güzel Sanatlar', [
            Kalip::ve('Sanatsal etkinlik koşulu', [
                Kalip::adet('En az 2 kişisel sanat etkinliği', ['KISISEL_SANAT'], 2),
                Kalip::adet('En az 8 karma sanat etkinliği', ['KARMA_SANAT'], 8),
            ]) + ['telafi' => Kalip::adet('Sanatsal etkinlik yoksa: A1-A7 kapsamında ek 1 makale', ['A.1-A.7'], 1)],
            Kalip::adet('Uluslararası indeksli veya TR Dizin dergilerinde başlıca yazar olduğunuz en az 1 makale', ['A.1-A.8'], 1, 'baslica'),
            Kalip::puanDan('Uluslararası indeksli ve TR Dizin dergilerindeki makalelerinizden en az 10 puan', ['A.1-A.8'], 10),
            Kalip::toplam(200),
        ]),
    ],

    // ══════════════════ DOÇENT ══════════════════
    // Doktora/uzmanlık ünvanı sonrası ve lisansüstü tezden ÜRETİLMEMİŞ yayınlar.
    [
        'anahtar' => 'kocaeli-docent-g1',
        'aday_notu' => 'Yedi makalenin üçü Q1-Q2, dördü Q1-Q4 dergide olmalı ve ikisinde başlıca yazar olmalısınız. Proje koşulu patent ya da ek makaleyle telafi edilebiliyor.',
        'universite' => 'Kocaeli Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $grup1,
        'cetvel' => 'kocaeli-2023',
        'notlar' => 'Madde 11/c-1. Tablo 1: 7 makale (A.1-A.2\'den ≥3, A.1-A.4\'ten ≥4), ikisinde başlıca yazar; 1 tez danışmanlığı; BAP dışı proje. Tablo 2: A.1-A.4 ≥125, F ≥15, H ≥20, toplam ≥250.',
        'sart' => Kalip::ve('Doçent — Sağlık / Fen / Mühendislik / Ziraat', [
            Kalip::beyan('Üniversitelerarası Kuruldan doçentlik unvanı almış olmak', 'Madde 11/c'),
            Kalip::adet('Doktora sonrası en az 7 makale', ['A.1-A.8'], 7, donem: Kalip::DOKTORA_SONRASI)
                + ['haric' => ['lisansustu_tezden']],
            Kalip::adet('Bunların en az 3\'ü Q1-Q2 dergide', ['A.1-A.2'], 3, donem: Kalip::DOKTORA_SONRASI),
            Kalip::adet('En az 4\'ü Q1-Q4 dergide', ['A.1-A.4'], 4, donem: Kalip::DOKTORA_SONRASI),
            Kalip::adet('Yedi makaleden en az 2\'sinde başlıca yazar olmalısınız', ['A.1-A.8'], 2, 'baslica', donem: Kalip::DOKTORA_SONRASI),
            $tezKosulu(1, 1),
            $projeKosulu(),
            Kalip::puanDan('SCI-E, SSCI veya AHCI dergilerindeki (Q1-Q4) makalelerinizden en az 125 puan', ['A.1-A.4'], 125),
            Kalip::puanDan('Tez yöneticiliğinden en az 15 puan', ['F.1-F.2'], 15),
            Kalip::puanDan('Araştırma projelerinden en az 20 puan', ['H.1-H.17'], 20),
            Kalip::toplam(250),
        ]),
    ],
    [
        'anahtar' => 'kocaeli-docent-g2',
        'aday_notu' => 'Altı makalenin ikisi Q1-Q4, dördü ESCI dâhil kademede olmalı; ikisinde başlıca yazar.',
        'universite' => 'Kocaeli Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $grup2,
        'cetvel' => 'kocaeli-2023',
        'notlar' => 'Madde 11/c-2. Tablo 1: 6 makale (A.1-A.4\'ten ≥2, A.1-A.6\'dan ≥4), ikisinde başlıca yazar. Tablo 2: A.1-A.4 ≥50, A.1-A.6 ≥75, F ≥15, H ≥20, toplam ≥250.',
        'sart' => Kalip::ve('Doçent — Eğitim / Filoloji / Mimarlık / Sosyal / Spor', [
            Kalip::beyan('Üniversitelerarası Kuruldan doçentlik unvanı almış olmak', 'Madde 11/c'),
            Kalip::adet('Doktora sonrası en az 6 makale', ['A.1-A.8'], 6, donem: Kalip::DOKTORA_SONRASI)
                + ['haric' => ['lisansustu_tezden']],
            Kalip::adet('Bunların en az 2\'si Q1-Q4 dergide', ['A.1-A.4'], 2, donem: Kalip::DOKTORA_SONRASI),
            Kalip::adet('En az 4\'ü ESCI dâhil kademede', ['A.1-A.6'], 4, donem: Kalip::DOKTORA_SONRASI),
            Kalip::adet('Altı makaleden en az 2\'sinde başlıca yazar olmalısınız', ['A.1-A.8'], 2, 'baslica', donem: Kalip::DOKTORA_SONRASI),
            $tezKosulu(1, 1),
            $projeKosulu(),
            Kalip::puanDan('SCI-E, SSCI veya AHCI dergilerindeki (Q1-Q4) makalelerinizden en az 50 puan', ['A.1-A.4'], 50),
            Kalip::puanDan('SCI-E, SSCI, AHCI veya ESCI dergilerindeki makalelerinizden en az 75 puan', ['A.1-A.6'], 75),
            Kalip::puanDan('Tez yöneticiliğinden en az 15 puan', ['F.1-F.2'], 15),
            Kalip::puanDan('Araştırma projelerinden en az 20 puan', ['H.1-H.17'], 20),
            Kalip::toplam(250),
        ]),
    ],
    [
        'anahtar' => 'kocaeli-docent-g3',
        'universite' => 'Kocaeli Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $grup3,
        'cetvel' => 'kocaeli-2023',
        'notlar' => 'Madde 11/c-3. Tablo 1: 6 makale. Tablo 2: A.1-A.4 ≥15, A.1-A.5 ≥15, A.1-A.6 ≥60, F ≥15, H ≥10, toplam ≥250.',
        'sart' => Kalip::ve('Doçent — Hukuk / İlahiyat', [
            Kalip::beyan('Üniversitelerarası Kuruldan doçentlik unvanı almış olmak', 'Madde 11/c'),
            Kalip::adet('Doktora sonrası en az 6 makale', ['A.1-A.8'], 6, donem: Kalip::DOKTORA_SONRASI)
                + ['haric' => ['lisansustu_tezden']],
            Kalip::adet('Altı makaleden en az 2\'sinde başlıca yazar olmalısınız', ['A.1-A.8'], 2, 'baslica', donem: Kalip::DOKTORA_SONRASI),
            $tezKosulu(1, 1),
            Kalip::puanDan('SCI-E, SSCI, AHCI veya ESCI dergilerindeki makalelerinizden en az 60 puan', ['A.1-A.6'], 60),
            Kalip::puanDan('Tez yöneticiliğinden en az 15 puan', ['F.1-F.2'], 15),
            Kalip::toplam(250),
        ]),
    ],
    [
        'anahtar' => 'kocaeli-docent-g4',
        'aday_notu' => 'Güzel Sanatlarda toplam puan barajı diğer alanlardan yüksek (350).',
        'universite' => 'Kocaeli Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'kocaeli-2023',
        'notlar' => 'Madde 11/c-4. Tablo 2: A.1-A.6 ≥20, A.1-A.8 ≥20, F ≥15, H ≥10, toplam ≥350.',
        'sart' => Kalip::ve('Doçent — Güzel Sanatlar', [
            Kalip::beyan('Üniversitelerarası Kuruldan doçentlik unvanı almış olmak', 'Madde 11/c'),
            Kalip::ve('Sanatsal etkinlik koşulu', [
                Kalip::adet('En az 3 kişisel sanat etkinliği', ['KISISEL_SANAT'], 3),
            ]),
            Kalip::adet('Makalelerinizden en az biri SCI-E, SSCI, AHCI veya ESCI dergisinde olmalı', ['A.1-A.6'], 1),
            $tezKosulu(1, 1),
            Kalip::puanDan('Uluslararası indeksli ve TR Dizin dergilerindeki makalelerinizden en az 20 puan', ['A.1-A.8'], 20),
            Kalip::puanDan('Tez yöneticiliğinden en az 15 puan', ['F.1-F.2'], 15),
            Kalip::toplam(350),
        ]),
    ],

    // ══════════════════ PROFESÖR ══════════════════ (doçentlik sonrası)
    [
        'anahtar' => 'kocaeli-profesor-g1',
        'aday_notu' => 'Koşulların tamamı doçent unvanını aldığınız tarihten sonraki çalışmalarla sağlanmalı; başlıca yazarlık eşiği doçentliktekinden bir fazla (üç).',
        'universite' => 'Kocaeli Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $grup1,
        'cetvel' => 'kocaeli-2023',
        'notlar' => 'Madde 11/d-1. Doçentlik sonrası 7 makale (A.1-A.2\'den ≥3, A.1-A.4\'ten ≥4), üçünde başlıca yazar; 2 YL veya 1 doktora danışmanlığı; BAP dışı proje. Tablo 2 doçentle aynı.',
        'sart' => Kalip::ve('Profesör — Sağlık / Fen / Mühendislik / Ziraat', [
            Kalip::adet('Doçentlik sonrası en az 7 makale', ['A.1-A.8'], 7, donem: Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('Bunların en az 3\'ü Q1-Q2 dergide', ['A.1-A.2'], 3, donem: Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('En az 4\'ü Q1-Q4 dergide', ['A.1-A.4'], 4, donem: Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('Yedi makaleden en az 3\'ünde başlıca yazar olmalısınız', ['A.1-A.8'], 3, 'baslica', donem: Kalip::DOCENTLIK_SONRASI),
            $tezKosulu(2, 1),
            $projeKosulu(),
            Kalip::puanDan('SCI-E, SSCI veya AHCI dergilerindeki (Q1-Q4) makalelerinizden en az 125 puan', ['A.1-A.4'], 125),
            Kalip::puanDan('Tez yöneticiliğinden en az 15 puan', ['F.1-F.2'], 15),
            Kalip::puanDan('Araştırma projelerinden en az 20 puan', ['H.1-H.17'], 20),
            Kalip::toplam(250),
        ]),
    ],
    [
        'anahtar' => 'kocaeli-profesor-g2',
        'aday_notu' => 'Koşulların tamamı doçent unvanını aldığınız tarihten sonraki çalışmalarla sağlanmalı.',
        'universite' => 'Kocaeli Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $grup2,
        'cetvel' => 'kocaeli-2023',
        'notlar' => 'Madde 11/d-2. Doçentlik sonrası 6 makale (A.1-A.4\'ten ≥2, A.1-A.6\'dan ≥4). Tablo 2 doçentle aynı.',
        'sart' => Kalip::ve('Profesör — Eğitim / Filoloji / Mimarlık / Sosyal / Spor', [
            Kalip::adet('Doçentlik sonrası en az 6 makale', ['A.1-A.8'], 6, donem: Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('Bunların en az 2\'si Q1-Q4 dergide', ['A.1-A.4'], 2, donem: Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('En az 4\'ü ESCI dâhil kademede', ['A.1-A.6'], 4, donem: Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('Altı makaleden en az 3\'ünde başlıca yazar olmalısınız', ['A.1-A.8'], 3, 'baslica', donem: Kalip::DOCENTLIK_SONRASI),
            $tezKosulu(2, 1),
            $projeKosulu(),
            Kalip::puanDan('SCI-E, SSCI veya AHCI dergilerindeki (Q1-Q4) makalelerinizden en az 50 puan', ['A.1-A.4'], 50),
            Kalip::puanDan('SCI-E, SSCI, AHCI veya ESCI dergilerindeki makalelerinizden en az 75 puan', ['A.1-A.6'], 75),
            Kalip::puanDan('Tez yöneticiliğinden en az 15 puan', ['F.1-F.2'], 15),
            Kalip::toplam(250),
        ]),
    ],
    [
        'anahtar' => 'kocaeli-profesor-g3',
        'universite' => 'Kocaeli Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $grup3,
        'cetvel' => 'kocaeli-2023',
        'notlar' => 'Madde 11/d-3. Doçentlik sonrası 6 makale, 2 tamamlanmış yüksek lisans danışmanlığı. Tablo 2 doçentle aynı.',
        'sart' => Kalip::ve('Profesör — Hukuk / İlahiyat', [
            Kalip::adet('Doçentlik sonrası en az 6 makale', ['A.1-A.8'], 6, donem: Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('Altı makaleden en az 3\'ünde başlıca yazar olmalısınız', ['A.1-A.8'], 3, 'baslica', donem: Kalip::DOCENTLIK_SONRASI),
            $tezKosulu(2, 1),
            Kalip::puanDan('SCI-E, SSCI, AHCI veya ESCI dergilerindeki makalelerinizden en az 60 puan', ['A.1-A.6'], 60),
            Kalip::puanDan('Tez yöneticiliğinden en az 15 puan', ['F.1-F.2'], 15),
            Kalip::toplam(250),
        ]),
    ],
    [
        'anahtar' => 'kocaeli-profesor-g4',
        'aday_notu' => 'Güzel Sanatlarda toplam puan barajı 350.',
        'universite' => 'Kocaeli Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'kocaeli-2023',
        'notlar' => 'Madde 11/d-4. Tablo 2: A.1-A.8 ≥20, F ≥15, toplam ≥350.',
        'sart' => Kalip::ve('Profesör — Güzel Sanatlar', [
            Kalip::adet('Doçentlik sonrası en az 3 kişisel sanat etkinliği', ['KISISEL_SANAT'], 3, donem: Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('Uluslararası indeksli veya TR Dizin dergilerinde başlıca yazar olduğunuz en az 1 makale', ['A.1-A.8'], 1, 'baslica', donem: Kalip::DOCENTLIK_SONRASI),
            $tezKosulu(2, 1),
            Kalip::puanDan('Uluslararası indeksli ve TR Dizin dergilerindeki makalelerinizden en az 20 puan', ['A.1-A.8'], 20),
            Kalip::puanDan('Tez yöneticiliğinden en az 15 puan', ['F.1-F.2'], 15),
            Kalip::toplam(350),
        ]),
    ],
];
