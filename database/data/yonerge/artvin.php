<?php

/**
 * ARTVİN ÇORUH ÜNİVERSİTESİ — Öğretim Üyeliği Kadrolarına Atanma Yönergesi
 * Kaynak: pdf/17536929712.artvincoruhuniverstesi.pdf
 *
 * DR. ÖĞR. ÜYELİĞİNDE ALAN AYRIMI YOK (Madde 11): bütün alanlarda A1-A2'de en
 * az bir makale, en az bir sözlü bildiri, tablodan toplam 60 puan ve bu
 * puanın en az 35'i lisansüstü tez DIŞINDAN A-E gruplarından.
 *
 * "Lisansüstü tez dışından" koşulu faaliyet kaydından türetilemiyor (bir
 * yayının tezden üretilip üretilmediği tutulmuyor); o yüzden 35 puanlık alt
 * baraj A-E gruplarından ölçülüyor ve tez kısıtı aday notunda anılıyor.
 *
 * DOÇENTLİKTE PUAN BARAJI YOK (Madde 10): yalnızca ÜAK doçentlik unvanı.
 *
 * PROFESÖRLÜKTE DÖRT ALAN GRUBU (Madde 9) ve kümeler belirgin biçimde farklı:
 *   Müh./Ziraat/Sağlık/Fen  A1'de 2 ilk yazar · A1 70 · A 140 · D 10 ·
 *                           E'den 2 ulusal ya da 1 uluslararası proje · toplam 400
 *   Mimarlık/Planlama       A1'de 1 ilk yazar (ya da A1-A2'de 2 ilk yazarlı,
 *                           toplam 5 makale) · A 80 · D 10 · toplam 320
 *   Hukuk/Filoloji/İlahiyat
 *   /Sosyal                 A1-A2'de 3 ilk yazar · A1-A2 110 · A+B+C 220 ·
 *                           D 10 · E projesi · toplam 400
 *   Eğitim Bilimleri        A1'de 1 ilk yazar · A1-A2 85 · A1-A2'de 4 yayın
 *                           (2'si ilk yazar) · A+C 160 · D 10 · toplam ...
 *
 * Mimarlık grubunun proje koşulu YOK, diğer üçünde var; Eğitim ise makale
 * sayısını ayrıca şart koşuyor. Bu farklar alan başına ayrı eşik gerektiriyor.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/artvin-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

$P = Kalip::DOCENTLIK_SONRASI;

$tumu = ['fen', 'muhendislik', 'ziraat', 'saglik', 'mimarlik', 'hukuk', 'filoloji',
    'ilahiyat', 'sosyal', 'egitim'];

return [
    // ══════════ DR. ÖĞRETİM ÜYESİ (alan ayrımı yok) ══════════
    [
        'anahtar' => 'artvin-dr',
        'aday_notu' => '60 puanın en az 35\'inin LİSANSÜSTÜ TEZLERİNİZ DIŞINDAN kazanılmış olması '
            .'gerekiyor. Faaliyet kaydı bir yayının tezden üretilip üretilmediğini tutmadığı için '
            .'bu kısıt burada ölçülemiyor; tezden üretilmiş yayınlarınız varsa gerçek puanınız '
            .'görünenden düşük olabilir.',
        'universite' => 'Artvin Çoruh Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $tumu,
        'cetvel' => 'artvin-2024',
        'notlar' => 'Madde 11: A1-A2\'de en az 1 makale, en az 1 sözlü bildiri, toplam 60 puan, bunun 35\'i A-E gruplarından.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Artvin Çoruh Üniversitesi', [
            Kalip::toplam(60),
            Kalip::adet('SCI, SCI-Expanded, SSCI, AHCI, ESCI veya TR Dizin dergilerinde en az 1 makale',
                ['A1-A2'], 1, madde: 'Madde 11/a'),
            Kalip::adet('Sözlü sunulmuş ve bildiri kitabında yayımlanmış en az 1 bildiri',
                ['B1', 'B2', 'B3', 'B7', 'B8'], 1, madde: 'Madde 11/a'),
            Kalip::puanDan('Makale, bildiri, kitap, atıf ve proje kalemlerinizden en az 35 puan',
                ['A-B-C-D-E'], 35, madde: 'Madde 11/b'),
        ]),
    ],

    // ══════════ DOÇENT (puan barajı yok) ══════════
    [
        'anahtar' => 'artvin-docent',
        'aday_notu' => 'Artvin Çoruh yönergesi doçentlik için puan barajı koymuyor; yalnızca '
            .'ÜAK doçentlik unvanını şart koşuyor. Burada baraj görmüyorsunuz — eksik '
            .'veri değil, yönergede öyle.',
        'universite' => 'Artvin Çoruh Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $tumu,
        'cetvel' => 'artvin-2024',
        'notlar' => 'Madde 10: başvurduğu alanla ilgili doçent unvanını almış olmak.',
        'sart' => Kalip::ve('Doçent — Artvin Çoruh Üniversitesi', [
            Kalip::beyan('Başvurduğunuz alanla ilgili olarak doçent unvanını almış olmak', 'Madde 10'),
        ]),
    ],

    // ══════════ PROFESÖR — MÜHENDİSLİK, ZİRAAT, SAĞLIK, FEN ══════════
    [
        'anahtar' => 'artvin-profesor-fen',
        'aday_notu' => 'Bütün koşullar doçent unvanınızı aldığınız doçentlik döneminin son '
            .'başvuru tarihinden sonraki çalışmalarınızla sağlanmalı.',
        'universite' => 'Artvin Çoruh Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['muhendislik', 'ziraat', 'saglik', 'fen'],
        'cetvel' => 'artvin-2024',
        'notlar' => 'Madde 9/a: A1\'de 2 ilk yazar, A1 70, A 140, D 10, E projesi, toplam 400.',
        'sart' => Kalip::ve('Profesör — Mühendislik, Ziraat, Sağlık ve Fen Bilimleri', [
            Kalip::toplam(400, $P),
            Kalip::adet('SCI, SCI-Expanded, SSCI veya AHCI dergilerinde ilk yazar olduğunuz en az 2 makale',
                ['A1'], 2, 'ilk', $P, madde: 'Madde 9/a-1'),
            Kalip::puanDan('SCI, SCI-Expanded, SSCI veya AHCI dergilerindeki makalelerinizden en az 70 puan',
                ['A1'], 70, $P, madde: 'Madde 9/a-2'),
            Kalip::puanDan('Tüm makale kalemlerinizden en az 140 puan', ['A'], 140, $P, madde: 'Madde 9/a-3'),
            Kalip::puanDan('Atıflarınızdan en az 10 puan', ['D'], 10, $P, madde: 'Madde 9/a-4'),
            Kalip::adet('Tamamlanmış en az bir uluslararası ya da iki ulusal projede görev almak',
                ['E1'], 1, donem: $P, telafi: Kalip::adet('Ya da tamamlanmış en az iki ulusal proje',
                    ['E2', 'E3'], 2, donem: $P), madde: 'Madde 9/a-5'),
        ]),
    ],

    // ══════════ PROFESÖR — MİMARLIK, PLANLAMA VE TASARIM ══════════
    [
        'anahtar' => 'artvin-profesor-mimarlik',
        'aday_notu' => 'Mimarlık grubunda diğer alanlardan farklı olarak PROJE koşulu yok ve '
            .'toplam baraj 400 yerine 320.',
        'universite' => 'Artvin Çoruh Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['mimarlik'],
        'cetvel' => 'artvin-2024',
        'notlar' => 'Madde 9/b: A1\'de 1 ilk yazar (ya da A1-A2\'de 2 ilk yazarlı, toplam 5 makale), A 80, D 10, toplam 320.',
        'sart' => Kalip::ve('Profesör — Mimarlık, Planlama ve Tasarım', [
            Kalip::toplam(320, $P),
            Kalip::adet('SCI, SCI-Expanded, SSCI veya AHCI dergilerinde ilk yazar olduğunuz en az 1 makale',
                ['A1'], 1, 'ilk', $P,
                telafi: Kalip::adet('Ya da A1-A2 dergilerinde ilk yazar olduğunuz en az 2 makale',
                    ['A1-A2'], 2, 'ilk', $P),
                madde: 'Madde 9/b-1'),
            Kalip::puanDan('Tüm makale kalemlerinizden en az 80 puan', ['A'], 80, $P, madde: 'Madde 9/b-2'),
            Kalip::puanDan('Atıflarınızdan en az 10 puan', ['D'], 10, $P, madde: 'Madde 9/b-3'),
        ]),
    ],

    // ══════════ PROFESÖR — HUKUK, FİLOLOJİ, İLAHİYAT, SOSYAL ══════════
    [
        'anahtar' => 'artvin-profesor-sosyal',
        'aday_notu' => 'Bu grupta makale barajı dizinli dergilerden ölçülüyor ve ayrıca makale, '
            .'bildiri ve kitap kalemlerinin toplamından 220 puan isteniyor.',
        'universite' => 'Artvin Çoruh Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['hukuk', 'filoloji', 'ilahiyat', 'sosyal'],
        'cetvel' => 'artvin-2024',
        'notlar' => 'Madde 9/c: A1-A2\'de 3 ilk yazar, A1-A2 110, A+B+C 220, D 10, E projesi, toplam 400.',
        'sart' => Kalip::ve('Profesör — Hukuk, Filoloji, İlahiyat, Sosyal ve Beşeri Bilimler', [
            Kalip::toplam(400, $P),
            Kalip::adet('SCI, SCI-Expanded, SSCI, AHCI ve TR Dizin dergilerinde ilk yazar olduğunuz en az 3 makale',
                ['A1-A2'], 3, 'ilk', $P, madde: 'Madde 9/c-1'),
            Kalip::puanDan('SCI, SCI-Expanded, SSCI, AHCI ve TR Dizin dergilerindeki makalelerinizden en az 110 puan',
                ['A1-A2'], 110, $P, madde: 'Madde 9/c-2'),
            Kalip::puanDan('Makale, bildiri ve kitap kalemlerinizden toplam en az 220 puan',
                ['A-B-C'], 220, $P, madde: 'Madde 9/c-3'),
            Kalip::puanDan('Atıflarınızdan en az 10 puan', ['D'], 10, $P, madde: 'Madde 9/c-4'),
            Kalip::adet('Tamamlanmış en az bir uluslararası ya da iki ulusal projede görev almak',
                ['E1'], 1, donem: $P, telafi: Kalip::adet('Ya da tamamlanmış en az iki ulusal proje',
                    ['E2', 'E3'], 2, donem: $P), madde: 'Madde 9/c-5'),
        ]),
    ],

    // ══════════ PROFESÖR — EĞİTİM BİLİMLERİ ══════════
    [
        'anahtar' => 'artvin-profesor-egitim',
        'aday_notu' => 'Eğitim Bilimlerinde diğer alanlardan farklı olarak makale SAYISI ayrıca '
            .'şart: dizinli dergilerde en az 4 yayın, bunların en az ikisinde ilk yazar.',
        'universite' => 'Artvin Çoruh Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['egitim'],
        'cetvel' => 'artvin-2024',
        'notlar' => 'Madde 9/ç: A1\'de 1 ilk yazar, A1-A2 85, A1-A2\'de 4 yayın (2\'si ilk yazar), A+C 160, D 10.',
        'sart' => Kalip::ve('Profesör — Eğitim Bilimleri', [
            Kalip::toplam(320, $P),
            Kalip::adet('SCI, SCI-Expanded, SSCI veya AHCI dergilerinde ilk yazar olduğunuz en az 1 makale',
                ['A1'], 1, 'ilk', $P, madde: 'Madde 9/ç-1'),
            Kalip::puanDan('SCI, SCI-Expanded, SSCI, AHCI ve TR Dizin dergilerindeki makalelerinizden en az 85 puan',
                ['A1-A2'], 85, $P, madde: 'Madde 9/ç-2'),
            Kalip::adet('SCI, SCI-Expanded, SSCI, AHCI ve TR Dizin dergilerinde en az 4 yayın', ['A1-A2'], 4, donem: $P, madde: 'Madde 9/ç-3'),
            Kalip::adet('Bu yayınların en az ikisinde ilk yazar olmak', ['A1-A2'], 2, 'ilk', $P, madde: 'Madde 9/ç-3'),
            Kalip::puanDan('Makale ve kitap kalemlerinizden toplam en az 160 puan',
                ['A-C'], 160, $P, madde: 'Madde 9/ç-4'),
            Kalip::puanDan('Atıflarınızdan en az 10 puan', ['D'], 10, $P, madde: 'Madde 9/ç-5'),
        ]),
    ],
];
