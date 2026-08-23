<?php

/**
 * GAZİANTEP ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma Kriterleri
 * Yönergesi
 * Kaynak: pdf/1768888754547.gaziantep-kriter-19012026.pdf (19/01/2026)
 *
 * DÖRT BİLİM ALANI, ORTAK PUAN TABLOSU (MADDE 9):
 *   Sağlık Bilimleri              Tıp, Diş Hekimliği, Sağlık Bilimleri
 *   Fen ve Mühendislik            Fen ve mühendislik bölümleri
 *   Sosyal Bilimler               İİBF, ilahiyat, eğitim, iletişim, spor, hukuk, turizm
 *   Mimarlık ve Güzel Sanatlar    Mimarlık, konservatuvar, güzel sanatlar
 *
 * Koşullar puan tablosuna madde numarasıyla atıf yapıyor: 1(a) WoS makalesi,
 * 1(c) ESCI/Scopus, 1(e) TR Dizin, 4 bildiriler, 5 projeler ve patentler,
 * 8(a) tez danışmanlığı.
 *
 * ALANLAR BARAJI FARKLI KURUYOR: Fen/Mühendislik ve Sağlık yalnızca 1(a)'dan
 * puan isterken, Sosyal "1(a) ve/veya 1(c)'den 75 VEYA 1 nolu maddenin
 * tamamından 90" diyor; Mimarlık/Güzel Sanatlar ise 1(a), 1(c), 1(e) ve 1(g)'yi
 * birlikte sayıp daha düşük bir baraj koyuyor ve üstüne sanatsal etkinlik
 * barajı ekliyor.
 *
 * TELAFİLİ KOŞULLAR `veya` DALI OLARAK GİRİLDİ, çünkü Gaziantep'te telafi
 * kümeleri açık: "5 nolu maddeden 45 puan; sağlayamayan adayların 1(a) ve/veya
 * 8(a) nolu maddelerden 90 puan daha alması gerekir" gibi. Fırat'takinin
 * aksine burada telafi kümesi ve puanı belirli, doğrulanabiliyor.
 *
 * PROFESÖRLÜKTE ÜÇ SEÇENEKLİ EK KOŞUL: yurt dışında üç ay araştırma, h-indeksi
 * en az 12, ya da 1(a)/8(a)'dan 90 puan daha. İlk ikisi faaliyet kaydından
 * türetilemediği için beyan; üçüncüsü puan düğümü.
 *
 * GİRİLMEYEN: Mimarlık/Güzel Sanatlar'ın sanatsal etkinlik barajları (tablonun
 * 15-34. maddeleri) — o kalemler kaynak sözlüğünde karşılıksız olduğu için
 * cetvele girmedi, koşul beyan olarak duruyor.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/gaziantep-2026.php
 */

use App\Services\Scoring\Sart\Kalip;

$D = Kalip::DOKTORA_SONRASI;
$P = Kalip::DOCENTLIK_SONRASI;

/**
 * Doçent ve profesörde tekrarlayan "5 nolu maddeden N puan, sağlanamazsa
 * 1(a) ve/veya 8(a)'dan M puan daha" koşulu.
 *
 * @return array<string, mixed>
 */
$projeVeyaTelafi = function (int $proje, int $telafi, array $donem, string $madde): array {
    return Kalip::veya('Proje ve patent koşulu (iki seçenekten biri)', [
        Kalip::puanDan("Proje ve patent kalemlerinizden en az {$proje} puan (BAP hariç)",
            ['5-BAP-haric'], $proje, $donem, madde: $madde),
        Kalip::puanDan("Ya da WoS makaleleriniz ve tez danışmanlıklarınızdan en az {$telafi} puan daha",
            ['1a', '8a'], $telafi, $donem, madde: $madde),
    ]);
};

return [
    // ══════════ FEN VE MÜHENDİSLİK BİLİMLERİ (MADDE 12) ══════════
    [
        'anahtar' => 'gaziantep-dr-fen',
        'aday_notu' => 'Lisansüstü çalışmalarda tez danışmanınızla yaptığınız yayınlardan tam puan alırsınız.',
        'universite' => 'Gaziantep Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['fen', 'muhendislik', 'ziraat'],
        'cetvel' => 'gaziantep-2026',
        'notlar' => 'MADDE 12/1: 1(a) kapsamında en az 120, 4 numaralı maddeden en az 12, genel toplamda en az 240 puan.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Fen ve Mühendislik Bilimleri', [
            Kalip::toplam(240),
            Kalip::puanDan('SCIE, SSCI veya AHCI dergilerindeki makalelerinizden en az 120 puan',
                ['1a'], 120, madde: 'MADDE 12/1'),
            Kalip::puanDan('Bildirilerinizden en az 12 puan', ['4'], 12, madde: 'MADDE 12/1'),
        ]),
    ],
    [
        'anahtar' => 'gaziantep-docent-fen',
        'aday_notu' => 'Bütün koşullar doktora unvanınızı aldıktan sonraki çalışmalarınızla sağlanmalı.',
        'universite' => 'Gaziantep Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['fen', 'muhendislik', 'ziraat'],
        'cetvel' => 'gaziantep-2026',
        'notlar' => 'MADDE 12/2: 1(a)\'dan 5 yayın (3\'ü başlıca), 1(a) 240, madde 4 12, toplam 500, madde 5 (BAP hariç) 45.',
        'sart' => Kalip::ve('Doçent — Fen ve Mühendislik Bilimleri', [
            Kalip::beyan('Doçentlik eser aşamasında Üniversitelerarası Kurul jürisinden başarılı olmak', 'MADDE 12/2-a'),
            Kalip::toplam(500, $D),
            Kalip::adet('SCIE, SSCI veya AHCI dergilerinde en az 5 yayın', ['1a'], 5, donem: $D, madde: 'MADDE 12/2-b'),
            Kalip::adet('Bu yayınların en az 3\'ünde başlıca yazar olmalısınız', ['1a'], 3, 'baslica', $D, madde: 'MADDE 12/2-b'),
            Kalip::puanDan('SCIE, SSCI veya AHCI dergilerindeki makalelerinizden en az 240 puan',
                ['1a'], 240, $D, madde: 'MADDE 12/2-c'),
            Kalip::puanDan('Bildirilerinizden en az 12 puan', ['4'], 12, $D, madde: 'MADDE 12/2-c'),
            $projeVeyaTelafi(45, 90, $D, 'MADDE 12/2-d'),
        ]),
    ],
    [
        'anahtar' => 'gaziantep-profesor-fen',
        'aday_notu' => 'Bütün koşullar doçent unvanınızı aldıktan sonraki çalışmalarınızla sağlanmalı.',
        'universite' => 'Gaziantep Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['fen', 'muhendislik', 'ziraat'],
        'cetvel' => 'gaziantep-2026',
        'notlar' => 'MADDE 12/3: 1(a)\'dan 5 yayın (3\'ü başlıca), 1(a) 240, madde 4 12, toplam 500, madde 5 45, 8(a-1) 60.',
        'sart' => Kalip::ve('Profesör — Fen ve Mühendislik Bilimleri', [
            Kalip::toplam(500, $P),
            Kalip::adet('SCIE, SSCI veya AHCI dergilerinde en az 5 yayın', ['1a'], 5, donem: $P, madde: 'MADDE 12/3-a'),
            Kalip::adet('Bu yayınların en az 3\'ünde başlıca yazar olmalısınız', ['1a'], 3, 'baslica', $P, madde: 'MADDE 12/3-a'),
            Kalip::puanDan('SCIE, SSCI veya AHCI dergilerindeki makalelerinizden en az 240 puan',
                ['1a'], 240, $P, madde: 'MADDE 12/3-b'),
            Kalip::puanDan('Bildirilerinizden en az 12 puan', ['4'], 12, $P, madde: 'MADDE 12/3-b'),
            $projeVeyaTelafi(45, 90, $P, 'MADDE 12/3-c'),
            Kalip::veya('Uluslararası deneyim veya etki koşulu (üç seçenekten biri)', [
                Kalip::beyan('THE, ARWU veya QS sıralamasında ilk 700\'de yer alan bir yurt dışı kurumda '
                    .'en az üç ay bilimsel amaçlı çalışmış olmak', 'MADDE 12/3-d.1'),
                Kalip::metrik('Web of Science veya Scopus h-indeksiniz en az 12 olmalı', 'h_indeksi', 12),
                Kalip::puanDan('Ya da WoS makaleleriniz ve tez danışmanlıklarınızdan en az 90 puan daha',
                    ['1a', '8a'], 90, $P, madde: 'MADDE 12/3-d.3'),
            ]),
            Kalip::puanDan('Tamamlanmış doktora veya uzmanlık tez danışmanlıklarınızdan en az 60 puan',
                ['8a'], 60, $P, madde: 'MADDE 12/3-e'),
        ]),
    ],

    // ══════════ SAĞLIK BİLİMLERİ (MADDE 13) ══════════
    [
        'anahtar' => 'gaziantep-dr-saglik',
        'aday_notu' => 'Lisansüstü çalışmalarda tez danışmanınızla yaptığınız yayınlardan tam puan alırsınız.',
        'universite' => 'Gaziantep Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['saglik'],
        'cetvel' => 'gaziantep-2026',
        'notlar' => 'MADDE 13/1: 1(a) kapsamında en az 60, 4 numaralı maddeden en az 12, genel toplamda en az 120 puan.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Sağlık Bilimleri', [
            Kalip::toplam(120),
            Kalip::puanDan('SCIE, SSCI veya AHCI dergilerindeki makalelerinizden en az 60 puan',
                ['1a'], 60, madde: 'MADDE 13/1'),
            Kalip::puanDan('Bildirilerinizden en az 12 puan', ['4'], 12, madde: 'MADDE 13/1'),
        ]),
    ],
    [
        'anahtar' => 'gaziantep-docent-saglik',
        'aday_notu' => 'Bütün koşullar doktora veya uzmanlık unvanınızı aldıktan sonraki çalışmalarınızla sağlanmalı.',
        'universite' => 'Gaziantep Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['saglik'],
        'cetvel' => 'gaziantep-2026',
        'notlar' => 'MADDE 13/2: 1(a) 180, madde 4 12, toplam 400, madde 5 (BAP hariç) 30.',
        'sart' => Kalip::ve('Doçent — Sağlık Bilimleri', [
            Kalip::beyan('Doçentlik eser aşamasında Üniversitelerarası Kurul jürisinden başarılı olmak', 'MADDE 13/2-a'),
            Kalip::toplam(400, $D),
            Kalip::puanDan('SCIE, SSCI veya AHCI dergilerindeki makalelerinizden en az 180 puan',
                ['1a'], 180, $D, madde: 'MADDE 13/2-c'),
            Kalip::puanDan('Bildirilerinizden en az 12 puan', ['4'], 12, $D, madde: 'MADDE 13/2-c'),
            $projeVeyaTelafi(30, 90, $D, 'MADDE 13/2-d'),
        ]),
    ],
    [
        'anahtar' => 'gaziantep-profesor-saglik',
        'aday_notu' => 'Bütün koşullar doçent unvanınızı aldıktan sonraki çalışmalarınızla sağlanmalı.',
        'universite' => 'Gaziantep Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['saglik'],
        'cetvel' => 'gaziantep-2026',
        'notlar' => 'MADDE 13/3: 1(a) 150, madde 4 20, toplam 300, madde 5 30, 8(a-1) 60.',
        'sart' => Kalip::ve('Profesör — Sağlık Bilimleri', [
            Kalip::toplam(300, $P),
            Kalip::puanDan('SCIE, SSCI veya AHCI dergilerindeki makalelerinizden en az 150 puan',
                ['1a'], 150, $P, madde: 'MADDE 13/3-b'),
            Kalip::puanDan('Bildirilerinizden en az 20 puan', ['4'], 20, $P, madde: 'MADDE 13/3-b'),
            $projeVeyaTelafi(30, 90, $P, 'MADDE 13/3-c'),
            Kalip::veya('Uluslararası deneyim veya etki koşulu (üç seçenekten biri)', [
                Kalip::beyan('THE, ARWU veya QS sıralamasında ilk 700\'de yer alan bir yurt dışı kurumda '
                    .'en az üç ay bilimsel amaçlı çalışmış olmak', 'MADDE 13/3-d.1'),
                Kalip::metrik('Web of Science veya Scopus h-indeksiniz en az 12 olmalı', 'h_indeksi', 12),
                Kalip::puanDan('Ya da WoS makaleleriniz ve tez danışmanlıklarınızdan en az 90 puan daha',
                    ['1a', '8a'], 90, $P, madde: 'MADDE 13/3-d.3'),
            ]),
            Kalip::puanDan('Tamamlanmış doktora veya uzmanlık tez danışmanlıklarınızdan en az 60 puan',
                ['8a'], 60, $P, madde: 'MADDE 13/3-e'),
        ]),
    ],

    // ══════════ SOSYAL BİLİMLER (MADDE 14) ══════════
    // Makale barajı iki seçenekli: dar kümeden (1a+1c) 75 ya da tüm makale
    // bölümünden 90.
    [
        'anahtar' => 'gaziantep-dr-sosyal',
        'aday_notu' => 'Daha önce öğrenci almamış bölümlerde bu şartlar yerine 1(a), 1(c) veya 1(e) '
            .'kapsamında en az bir yayın koşulu aranır.',
        'universite' => 'Gaziantep Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['sosyal', 'egitim', 'filoloji', 'hukuk', 'ilahiyat', 'spor'],
        'cetvel' => 'gaziantep-2026',
        'notlar' => 'MADDE 14/1: 1(a) ve/veya 1(c)\'den 75 veya 1 nolu maddeden 90; genel toplam 150; madde 4\'ten 6.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Sosyal Bilimler', [
            Kalip::toplam(150),
            Kalip::veya('Makale koşulu (iki seçenekten biri)', [
                Kalip::puanDan('WoS ve ESCI/Scopus dergilerindeki makalelerinizden en az 75 puan',
                    ['1a', '1c'], 75, madde: 'MADDE 14/1-a'),
                Kalip::puanDan('Ya da tüm makale kalemlerinizden en az 90 puan',
                    ['MAKALE'], 90, madde: 'MADDE 14/1-a'),
            ]),
            Kalip::puanDan('Bildirilerinizden en az 6 puan', ['4'], 6, madde: 'MADDE 14/1-b'),
        ]),
    ],
    [
        'anahtar' => 'gaziantep-docent-sosyal',
        'aday_notu' => 'Bütün koşullar doktora unvanınızı aldıktan sonraki çalışmalarınızla sağlanmalı.',
        'universite' => 'Gaziantep Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['sosyal', 'egitim', 'filoloji', 'hukuk', 'ilahiyat', 'spor'],
        'cetvel' => 'gaziantep-2026',
        'notlar' => 'MADDE 14/2: 1(a) ve/veya 1(c)\'den 140 veya 1 nolu maddeden 180; genel toplam 400; madde 5 30.',
        'sart' => Kalip::ve('Doçent — Sosyal Bilimler', [
            Kalip::beyan('Doçentlik eser aşamasında Üniversitelerarası Kurul jürisinden başarılı olmak', 'MADDE 14/2-a'),
            Kalip::toplam(400, $D),
            Kalip::veya('Makale koşulu (iki seçenekten biri)', [
                Kalip::puanDan('WoS ve ESCI/Scopus dergilerindeki makalelerinizden en az 140 puan',
                    ['1a', '1c'], 140, $D, madde: 'MADDE 14/2-b'),
                Kalip::puanDan('Ya da tüm makale kalemlerinizden en az 180 puan',
                    ['MAKALE'], 180, $D, madde: 'MADDE 14/2-b'),
            ]),
            $projeVeyaTelafi(30, 90, $D, 'MADDE 14/2-c'),
            Kalip::puanDan('Bildirilerinizden en az 7 puan', ['4'], 7, $D, madde: 'MADDE 14/2-d'),
        ]),
    ],
    [
        'anahtar' => 'gaziantep-profesor-sosyal',
        'aday_notu' => 'Bütün koşullar doçent unvanınızı aldıktan sonraki çalışmalarınızla sağlanmalı.',
        'universite' => 'Gaziantep Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['sosyal', 'egitim', 'filoloji', 'hukuk', 'ilahiyat', 'spor'],
        'cetvel' => 'gaziantep-2026',
        'notlar' => 'MADDE 14/3: 1(a) ve/veya 1(c)\'den 140 veya 1 nolu maddeden 200; genel toplam 400; madde 5 30.',
        'sart' => Kalip::ve('Profesör — Sosyal Bilimler', [
            Kalip::toplam(400, $P),
            Kalip::veya('Makale koşulu (iki seçenekten biri)', [
                Kalip::puanDan('WoS ve ESCI/Scopus dergilerindeki makalelerinizden en az 140 puan',
                    ['1a', '1c'], 140, $P, madde: 'MADDE 14/3-a'),
                Kalip::puanDan('Ya da tüm makale kalemlerinizden en az 200 puan',
                    ['MAKALE'], 200, $P, madde: 'MADDE 14/3-a'),
            ]),
            $projeVeyaTelafi(30, 90, $P, 'MADDE 14/3-b'),
            Kalip::puanDan('Bildirilerinizden en az 10 puan', ['4'], 10, $P, madde: 'MADDE 14/3-c'),
            Kalip::puanDan('Tamamlanmış tez danışmanlıklarınızdan en az 25 puan',
                ['8a'], 25, $P, madde: 'MADDE 14/3-d'),
        ]),
    ],

    // ══════════ MİMARLIK VE GÜZEL SANATLAR (MADDE 15) ══════════
    // Makale barajı en geniş kümeden (1a, 1c, 1e, 1g) ve en düşük; buna karşılık
    // sanatsal etkinlik barajı var.
    [
        'anahtar' => 'gaziantep-dr-mimarlik',
        'aday_notu' => 'Güzel sanatlar ve konservatuvarın UYGULAMALI alanlarında ayrıca puanlama '
            .'tablosunun 15-34. maddelerinden, en az ikisi kişisel etkinlik olmak üzere 45 puan '
            .'gerekiyor. O kalemler kaynak sözlüğünde karşılıksız olduğu için burada beyan olarak duruyor.',
        'universite' => 'Gaziantep Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['mimarlik', 'guzel_sanatlar'],
        'cetvel' => 'gaziantep-2026',
        'notlar' => 'MADDE 15/1: 1(a), 1(c), 1(e) ve/veya 1(g)\'den en az 45; madde 4\'ten en az 6; alan koşulundan 30.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Mimarlık ve Güzel Sanatlar', [
            Kalip::puanDan('WoS, ESCI/Scopus, TR Dizin ve diğer uluslararası dergilerdeki makalelerinizden en az 45 puan',
                ['1a', '1c', '1e', '1g'], 45, madde: 'MADDE 15/1-a'),
            Kalip::puanDan('Bildirilerinizden en az 6 puan', ['4'], 6, madde: 'MADDE 15/1-b'),
            Kalip::beyan('Başvurunuza uygun alandan en az 30 puan almış olmak; güzel sanatlar ve '
                .'konservatuvarın uygulamalı alanlarında puanlama tablosunun 15-34. maddelerinden, '
                .'en az ikisi kişisel etkinlik olmak üzere toplam 45 puan', 'MADDE 15/1-c'),
        ]),
    ],
    [
        'anahtar' => 'gaziantep-docent-mimarlik',
        'aday_notu' => 'Bütün koşullar doktora unvanınızı aldıktan sonraki çalışmalarınızla sağlanmalı. '
            .'Sanatsal etkinlik barajı kaynak sözlüğünde karşılıksız olduğu için beyan olarak duruyor.',
        'universite' => 'Gaziantep Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['mimarlik', 'guzel_sanatlar'],
        'cetvel' => 'gaziantep-2026',
        'notlar' => 'MADDE 15/2: makale ve bildiri barajları ile alan koşulu; genel toplam 450.',
        'sart' => Kalip::ve('Doçent — Mimarlık ve Güzel Sanatlar', [
            Kalip::beyan('Doçentlik eser aşamasında Üniversitelerarası Kurul jürisinden başarılı olmak', 'MADDE 15/2-a'),
            Kalip::toplam(450, $D),
            Kalip::puanDan('WoS, ESCI/Scopus, TR Dizin ve diğer uluslararası dergilerdeki makalelerinizden en az 90 puan',
                ['1a', '1c', '1e', '1g'], 90, $D, madde: 'MADDE 15/2-b'),
            Kalip::puanDan('Bildirilerinizden en az 25 puan', ['4'], 25, $D, madde: 'MADDE 15/2-c'),
            Kalip::beyan('Başvurunuza uygun alandan (sanatsal etkinlik, uygulama veya kuramsal '
                .'çalışma) yönergede belirtilen puanı almış olmak', 'MADDE 15/2-d'),
        ]),
    ],
    [
        'anahtar' => 'gaziantep-profesor-mimarlik',
        'aday_notu' => 'Bütün koşullar doçent unvanınızı aldıktan sonraki çalışmalarınızla sağlanmalı. '
            .'Sanatsal etkinlik barajı kaynak sözlüğünde karşılıksız olduğu için beyan olarak duruyor.',
        'universite' => 'Gaziantep Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['mimarlik', 'guzel_sanatlar'],
        'cetvel' => 'gaziantep-2026',
        'notlar' => 'MADDE 15/3: makale ve bildiri barajları ile alan koşulu; genel toplam 450.',
        'sart' => Kalip::ve('Profesör — Mimarlık ve Güzel Sanatlar', [
            Kalip::toplam(450, $P),
            Kalip::puanDan('WoS, ESCI/Scopus, TR Dizin ve diğer uluslararası dergilerdeki makalelerinizden en az 90 puan',
                ['1a', '1c', '1e', '1g'], 90, $P, madde: 'MADDE 15/3-a'),
            Kalip::puanDan('Bildirilerinizden en az 25 puan', ['4'], 25, $P, madde: 'MADDE 15/3-b'),
            Kalip::puanDan('Tamamlanmış tez danışmanlıklarınızdan en az 45 puan',
                ['8a'], 45, $P, madde: 'MADDE 15/3-c'),
            Kalip::beyan('Başvurunuza uygun alandan (sanatsal etkinlik, uygulama veya kuramsal '
                .'çalışma) yönergede belirtilen puanı almış olmak', 'MADDE 15/3-d'),
        ]),
    ],
];
