<?php

/**
 * MARMARA ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma Kriterleri
 * Kaynak: pdf/17537003632.marmarauniverstesi.pdf
 *
 * BELGE 2018 ÖNCESİ TERMİNOLOJİ KULLANIYOR: "yardımcı doçent" kadrosu
 * 2018'de "Dr. Öğretim Üyesi" olarak yeniden adlandırıldı. Kadro aynı olduğu
 * için MADDE 7'nin koşulları `dr_ogr_uyesi` altına girildi. Yabancı dil
 * koşulunda KPDS/ÜDS anılıyor (2013'te YDS ile değişti); puan eşikleri
 * korunarak `yds` metriğine bağlandı.
 *
 * MARMARA HER TEMEL ALANA AYRI PUANLAMA TABLOSU VERİYOR (Tablo 1-7) ve
 * koşullar o tablonun KENDİ madde numaralarına ARALIK olarak atıf yapıyor:
 * "1-16, 23-26, 32-37, 45, 47-52 numaralı faaliyetlerden en az 42 puan".
 *
 * ŞU AN YALNIZCA TABLO 2 GİRİLDİ (Sağlık, Fen, Matematik, Mesleki ve Teknik
 * Eğitim). Diğer tablolar — Eğitim (1), İlahiyat/Hukuk/Filoloji (3), Güzel
 * Sanatlar (4), Mühendislik (5), Sosyal (6), Spor (7) — henüz girilmedi ve o
 * alanlarda eşik üretilmiyor. Her tablonun madde numaralandırması farklı
 * olduğu için ortak bir cetvele indirgenemiyorlar.
 *
 * DOÇENT ve PROFESÖR koşulları alandan bağımsız (md. 13/a ve 18/2-a) ama
 * atıf yaptıkları madde numaraları yine tablo başına değiştiği için bu
 * eşikler de yalnızca Tablo 2 alanlarında tanımlı.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/marmara-fen-saglik.php
 */

use App\Services\Scoring\Sart\Kalip;

/** Tablo 2'ye tabi temel alanlar (yönerge md. 6 tablo başlığı). */
$tablo2 = ['saglik', 'fen', 'egitim'];

return [
    [
        'anahtar' => 'marmara-dr-fen-saglik',
        'aday_notu' => 'Yönerge 2018 öncesi "yardımcı doçent" terimini kullanıyor; kadro bugünkü Dr. Öğretim Üyesi kadrosudur. Yabancı dil koşulundaki KPDS/ÜDS puanı YDS karşılığıyla değerlendiriliyor.',
        'universite' => 'Marmara Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $tablo2,
        'cetvel' => 'marmara-fen-saglik',
        'notlar' => 'MADDE 7/d-2. "SCI-Expanded kapsamındaki dergilerde alanı ile ilgili en az bir makalesinin olması ve 1-16, 23-26, 32-37, 45, 47-52 numaralı faaliyetlerden en az 42 puan olmak üzere, tüm faaliyetlerden 90 puan." MADDE 7/b: KPDS/ÜDS en az 60.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Sağlık / Fen / Matematik', [
            Kalip::adet('Birincil indeksli dergide en az 1 makale', ['BIRINCIL'], 1),
            Kalip::puanDan('Belirtilen faaliyet aralıklarından en az 42 puan',
                ['1-16', '23-26', '32-37', '45', '47-52'], 42, madde: 'Madde 7/d-2'),
            Kalip::toplam(90),
            Kalip::yds(60),
            Kalip::beyan('Birim yönetim kurulunca seçilen üç kişilik jüri önünde yabancı dil çeviri sınavında başarılı olmak', 'Madde 7/c'),
        ]),
    ],
    [
        'anahtar' => 'marmara-docent-fen-saglik',
        'aday_notu' => 'Doçentlikte yalnızca doktora sonrası dönem ve belirli faaliyet kalemleri sayılıyor: ders, proje, editörlük, ödül, atıf ve tez danışmanlığı.',
        'universite' => 'Marmara Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $tablo2,
        'cetvel' => 'marmara-fen-saglik',
        'notlar' => 'MADDE 13/a. "Doktora sonrası döneme ait başvurduğu alan ile ilgili 27, 32-52 numaralı faaliyetlerden toplam en az 100 puana ulaşması gerekir."',
        'sart' => Kalip::ve('Doçent — Sağlık / Fen / Matematik', [
            Kalip::beyan('Üniversitelerarası Kurulca yapılan doçentlik sınavında başarılı olmak', 'Madde 13'),
            Kalip::puanDan('Doktora sonrası ders, proje, editörlük, tez danışmanlığı ve benzeri faaliyetlerden en az 100 puan',
                ['27,32-52'], 100, Kalip::DOKTORA_SONRASI, madde: 'Madde 13/a'),
        ]),
    ],
    [
        'anahtar' => 'marmara-profesor-fen-saglik',
        'aday_notu' => 'İki ayrı baraj var: çekirdek kalemlerden (kitap, proje, editörlük, tez danışmanlığı) 120 puan ve önceki yükseltmenizden sonraki tüm faaliyetlerden 275 puan.',
        'universite' => 'Marmara Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $tablo2,
        'cetvel' => 'marmara-fen-saglik',
        'notlar' => 'MADDE 18. "Doçentlik unvanını aldıktan sonra en az beş yıl çalışma" + md. 18/2-a: "17, 18, 27, 34, 41, 49, 50 numaralı faaliyetlerden toplam en az 120 puan almak koşuluyla önceki yükseltilmesinden sonraki tüm faaliyetlerinden toplam 275 puana ulaşması."',
        'sart' => Kalip::ve('Profesör — Sağlık / Fen / Matematik', [
            Kalip::beyan('Doçentlik unvanını aldıktan sonra alanında en az beş yıl çalışmış olmak', 'Madde 18/1-a'),
            Kalip::beyan('Doçentlik unvanını almaya hak kazandığı döneme ait ÜAK asgari başvuru koşullarını yeniden karşılamak', 'Madde 18/2-a'),
            Kalip::puanDan('Kitap, proje, editörlük ve tez danışmanlığı kalemlerinden en az 120 puan',
                ['PROF-CEKIRDEK'], 120, Kalip::DOCENTLIK_SONRASI, madde: 'Madde 18/2-a'),
            Kalip::toplam(275, Kalip::DOCENTLIK_SONRASI),
        ]),
    ],
];
