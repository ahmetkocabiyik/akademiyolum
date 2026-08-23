<?php

/**
 * MERSİN ÜNİVERSİTESİ — şart ağaçları.
 *
 * Kaynak: pdf/17537003802.mersinuniverstesi.pdf (Senato 07/02/2024, 2024/15)
 * Cetvel: database/data/cetvel/mersin-2024.php (TABLO A)
 *
 * ALAN EŞLEMESİ — yönergenin madde 1.4'ünden birebir alındı, tahmin yok:
 *   Sağlık Bilimleri ......... saglik
 *   Fen ve Mühendislik ....... fen · muhendislik · ziraat
 *   Eğitim Bilimleri ......... egitim
 *   Sosyal Bilimler .......... filoloji · hukuk · ilahiyat · sosyal
 *   Spor Bilimleri ........... spor
 *   Güzel Sanatlar ........... guzel_sanatlar
 *   Mimarlık, Plan., Tasarım . mimarlik
 *
 * DİKKAT: Mersin'in "Sosyal Bilimler" grubu kendi içinde ikiye ayrılıyor —
 * Hukuk'un makale sayısı diğerlerinden farklı (4 ↔ 3), o yüzden iki ayrı kayıt.
 *
 * KAPSAM: Üç kadro da (2.1.1 Dr. Öğr. Üyesi, 2.2 Doçent, 2.3 Profesör) tüm
 * alanlarda girildi.
 *
 * PUAN BARAJI ALANA GÖRE FARKLI LİSTEDEN OKUNUR — yönergenin üç eki var ve
 * hangisinin geçerli olduğu adayın alanına bağlı:
 *
 *   çoğu alan       Liste A            (makale, kitap, proje)
 *   güzel sanatlar  TABLO B + TABLO C  (sanat/tasarım + konservatuvar)
 *   mimarlık        Liste A + TABLO B  ("Liste (A) ve Liste (B)'den", md. 2.2 e-7)
 *
 * Üçü de tek cetvelde (cetvel/mersin-2024.php) `A`/`B`/`C` gruplarıyla duruyor;
 * her eşik barajını `Kalip::toplam()`'a kapsam vererek istiyor. Güzel sanatlar
 * adayının makalesi bu yüzden sanat barajına sayılmaz.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · şema: sart-agaci-taslak.php
 */

use App\Services\Scoring\Sart\Kalip;

/**
 * Yönergenin her alan grubunda tekrarlayan proje koşulu:
 * "5.a-g bentlerinde belirtilen projelerden birinde yürütücü, araştırmacı,
 * danışman, eğitmen, uzman veya bursiyer olarak görev almak. Bu şartın
 * sağlanamaması durumunda 1. fıkraya ek olarak … bir adet araştırma makalesi
 * daha yayınlanmış olmak."
 *
 * @param  list<string>  $telafiMaddeleri  Proje yoksa ilave makalenin geleceği küme
 * @return array<string, mixed>
 */
$projeKosulu = fn (array $telafiMaddeleri): array => Kalip::adet(
    'En az 1 bilimsel araştırma projesinde görev almış olmak',
    ['5.a-g'],
    1,
    telafi: Kalip::adet(
        'Projeniz yoksa: bunun yerine 1 araştırma makalesi daha',
        array_values($telafiMaddeleri),
        1,
    ),
    madde: 'Liste A · 5.a-g',
);

/**
 * Profesörlükte proje koşulu doçentlikten iki noktada ayrılıyor: yalnızca
 * "koordinatör/yürütücü" görevi sayılıyor (araştırmacılık yetmiyor) ve telafi
 * bir değil İKİ ilave makale.
 *
 * @param  list<string>  $telafiMaddeleri
 * @return array<string, mixed>
 */
$profesorProjeKosulu = fn (array $telafiMaddeleri, int $telafiAdet = 2): array => Kalip::adet(
    'En az 1 bilimsel araştırma projesinde yürütücü olarak görev almış olmak',
    // Rol süzgeci cetvel kodunda: '5.a-g-yurutucu' yalnızca yürütücülük
    // maddelerini kapsıyor. Düğüm düzeyinde rol filtresi YOKTUR.
    ['5.a-g-yurutucu'],
    1,
    donem: Kalip::DOCENTLIK_SONRASI,
    telafi: Kalip::adet(
        "Yürütücülüğünüz yoksa: bunun yerine {$telafiAdet} araştırma makalesi daha",
        array_values($telafiMaddeleri),
        $telafiAdet,
        donem: Kalip::DOCENTLIK_SONRASI,
    ),
    madde: 'Liste A · 5.a-g (yürütücü)',
);

/** Madde 1.3.8 — Türkçe öğretim yapan bölümlerde 65; yabancı dille öğretimde ayrı yönetmelik. */
$dil = fn (): array => [
    'tip' => 'metrik',
    'aciklama' => 'Yabancı dil sınavı (YDS/YÖKDİL) asgari puanı',
    'madde' => 'Yönerge md. 1.3.8',
    'metrik' => 'yds',
    'kademeler' => [
        'turkce' => 65,
        'yabanci_dil_30' => 65,
        'yabanci_dil_100' => 85,
        'yabanci_dil_egitimi' => 85,
    ],
];

return [

    // ══════════ 2.1.1 · DOKTOR ÖĞRETİM ÜYESİ — İLK ATANMA ══════════

    [
        'anahtar' => 'mersin-dr-saglik',
        'aday_notu' => 'Makale sayısını tutturmak yetmiyor: bu makalelerden en az birinde başlıca yazar olmanız gerekiyor. Projeniz yoksa yönerge bunu ilave bir makaleyle telafi etmenize izin veriyor.',
        'universite' => 'Mersin Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['saglik'],
        'cetvel' => 'mersin-2024',
        'notlar' => '2.1.1 c-1) SAĞLIK BİLİMLERİ. "1) Liste (A) 2.a, b, c, ç/h, ı kapsamındaki '
            .'dergilerde en az beş adet tam metinli araştırma makalesi yayınlanmış olmak. '
            .'2) …en az iki adeti (A) 2.a,b,c,ç kapsamındaki dergilerde yayınlanmış olmak. Bu iki '
            .'makaleden en az birinde başlıca yazar olmak. 4) …en az 150 puan almak."',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi ilk atanma — Sağlık Bilimleri', [
            Kalip::adet('SCIE/SSCI, AHCI, ESCI/Scopus veya TR Dizin dergilerinde en az 5 araştırma makalesi', ['2.a-ç/h,ı'], 5, madde: 'Liste A · 2.a-ç/h,ı'),
            Kalip::adet('Bu makalelerden en az 2\'si SCIE/SSCI veya AHCI dergilerinde olmalı', ['2.a-ç'], 2, madde: 'Liste A · 2.a-ç'),
            Kalip::adet('Bu iki makaleden en az birinde başlıca yazar olmalısınız', ['2.a-ç'], 1, 'baslica', madde: 'Liste A · 2.a-ç'),
            $projeKosulu(['2.a-ç']),
            Kalip::toplam(150, null, ['A'], 'Yayın ve proje'),
            $dil(),
        ]),
    ],

    [
        'anahtar' => 'mersin-dr-fen',
        'aday_notu' => 'Makale sayısını tutturmak yetmiyor: bu makalelerden en az birinde başlıca yazar olmanız gerekiyor. Projeniz yoksa yönerge bunu ilave bir makaleyle telafi etmenize izin veriyor.',
        'universite' => 'Mersin Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['fen', 'muhendislik', 'ziraat'],
        'cetvel' => 'mersin-2024',
        'notlar' => '2.1.1 c-2) FEN ve MÜHENDİSLİK BİLİMLERİ. Sağlık ile aynı yapı; madde 1.4 '
            .'uyarınca Ziraat, Orman ve Su Ürünleri Temel Alanı da bu gruba dâhil.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi ilk atanma — Fen ve Mühendislik', [
            Kalip::adet('SCIE/SSCI, AHCI, ESCI/Scopus veya TR Dizin dergilerinde en az 5 araştırma makalesi', ['2.a-ç/h,ı'], 5, madde: 'Liste A · 2.a-ç/h,ı'),
            Kalip::adet('Bu makalelerden en az 2\'si SCIE/SSCI veya AHCI dergilerinde olmalı', ['2.a-ç'], 2, madde: 'Liste A · 2.a-ç'),
            Kalip::adet('Bu iki makaleden en az birinde başlıca yazar olmalısınız', ['2.a-ç'], 1, 'baslica', madde: 'Liste A · 2.a-ç'),
            $projeKosulu(['2.a-ç']),
            Kalip::toplam(150, null, ['A'], 'Yayın ve proje'),
            $dil(),
        ]),
    ],

    [
        'anahtar' => 'mersin-dr-egitim',
        'aday_notu' => 'Makale sayısını tutturmak yetmiyor: bu makalelerden en az birinde başlıca yazar olmanız gerekiyor. Projeniz yoksa yönerge bunu ilave bir makaleyle telafi etmenize izin veriyor.',
        'universite' => 'Mersin Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['egitim'],
        'cetvel' => 'mersin-2024',
        'notlar' => '2.1.1 c-3) EĞİTİM BİLİMLERİ. Fark: başlıca yazarlık BEŞ makalenin tamamı '
            .'içinde aranıyor (dar kümede değil) ve ikinci koşulun kümesi 2.a-ç VEYA 2.h.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi ilk atanma — Eğitim Bilimleri', [
            Kalip::adet('SCIE/SSCI, AHCI, ESCI/Scopus veya TR Dizin dergilerinde en az 5 araştırma makalesi', ['2.a-ç/h,ı'], 5, madde: 'Liste A · 2.a-ç/h,ı'),
            Kalip::adet('Bu makalelerden en az birinde başlıca yazar olmalısınız', ['2.a-ç/h,ı'], 1, 'baslica', madde: 'Liste A · 2.a-ç/h,ı'),
            Kalip::adet('Bu makalelerden en az 2\'si SCIE/SSCI, AHCI veya ESCI/Scopus dergilerinde olmalı', ['2.a-ç/h'], 2, madde: 'Liste A · 2.a-ç veya 2.h'),
            $projeKosulu(['2.a-ç/h,ı']),
            Kalip::toplam(120, null, ['A'], 'Yayın ve proje'),
            $dil(),
        ]),
    ],

    [
        'anahtar' => 'mersin-dr-sosyal',
        'aday_notu' => 'Makale sayısını tutturmak yetmiyor: bu makalelerden en az birinde başlıca yazar olmanız gerekiyor. Projeniz yoksa yönerge bunu ilave bir makaleyle telafi etmenize izin veriyor.',
        'universite' => 'Mersin Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['filoloji', 'ilahiyat', 'sosyal'],
        'cetvel' => 'mersin-2024',
        'notlar' => '2.1.1 c-4/1) Filoloji, İlahiyat ve Sosyal-Beşeri-İdari Bilimler. '
            .'"…en az üç adet tam metinli araştırma makalesi yayınlanmış olmak YA DA 2.a,b,c,ç/h,ı '
            .'kapsamında iki adet tam metinli araştırma makalesi yayınlamış olmak ve 1.a/c '
            .'kapsamında bir adet kitap yazarlığı veya 1.b/ç kapsamında iki adet kitap bölümü '
            .'yazarlığı yapmış olmak." 3) "…makalelerden en az iki adetinde başlıca yazar olmak."',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi ilk atanma — Sosyal Bilimler', [
            Kalip::veya('Üç makale ya da iki makale + kitap', [
                Kalip::adet('SCIE/SSCI, AHCI, ESCI/Scopus veya TR Dizin dergilerinde en az 3 araştırma makalesi', ['2.a-ç/h,ı'], 3, madde: 'Liste A · 2.a-ç/h,ı'),
                Kalip::ve('2 makale + kitap yolu', [
                    Kalip::adet('Bu dergilerde en az 2 araştırma makalesi', ['2.a-ç/h,ı'], 2, madde: 'Liste A · 2.a-ç/h,ı'),
                    Kalip::veya('1 kitap yazarlığı ya da 2 kitap bölümü', [
                        Kalip::adet('Tanınmış bir yayınevinden 1 kitap yazarlığı', ['1.a/c'], 1, madde: 'Liste A · 1.a veya 1.c'),
                        Kalip::adet('Tanınmış bir yayınevinden 2 kitap bölümü yazarlığı', ['1.b/ç'], 2, madde: 'Liste A · 1.b veya 1.ç'),
                    ]),
                ]),
            ]),
            Kalip::adet('Yayınlardan en az 1 tanesi SCIE/SSCI, AHCI veya ESCI/Scopus dergilerinde olmalı', ['2.a-ç/h'], 1, madde: 'Liste A · 2.a-ç/h'),
            Kalip::adet('Bu makalelerden en az 2\'sinde başlıca yazar olmalısınız', ['2.a-ç/h,ı'], 2, 'baslica', madde: 'Liste A · 2.a-ç/h,ı'),
            $projeKosulu(['2.a-ç/h,ı']),
            Kalip::toplam(120, null, ['A'], 'Yayın ve proje'),
            $dil(),
        ]),
    ],

    [
        'anahtar' => 'mersin-dr-hukuk',
        'aday_notu' => 'Makale sayısını tutturmak yetmiyor: bu makalelerden en az birinde başlıca yazar olmanız gerekiyor. Projeniz yoksa yönerge bunu ilave bir makaleyle telafi etmenize izin veriyor.',
        'universite' => 'Mersin Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['hukuk'],
        'cetvel' => 'mersin-2024',
        'notlar' => '2.1.1 c-4/2) Hukuk Temel Alanı — aynı grubun içinde AYRI koşul: '
            .'"…en az dört adet tam metinli araştırma makalesi yayınlanmış olmak ya da 2.a,b,c,ç/h,ı '
            .'kapsamında üç adet tam metinli araştırma makalesi yayınlamış olmak ve 1.a/c kapsamında '
            .'bir adet kitap yazarlığı veya 1.b/ç kapsamında iki adet kitap bölümü yazarlığı."',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi ilk atanma — Hukuk', [
            Kalip::veya('Dört makale ya da üç makale + kitap', [
                Kalip::adet('SCIE/SSCI, AHCI, ESCI/Scopus veya TR Dizin dergilerinde en az 4 araştırma makalesi', ['2.a-ç/h,ı'], 4, madde: 'Liste A · 2.a-ç/h,ı'),
                Kalip::ve('3 makale + kitap yolu', [
                    Kalip::adet('Bu dergilerde en az 3 araştırma makalesi', ['2.a-ç/h,ı'], 3, madde: 'Liste A · 2.a-ç/h,ı'),
                    Kalip::veya('1 kitap yazarlığı ya da 2 kitap bölümü', [
                        Kalip::adet('Tanınmış bir yayınevinden 1 kitap yazarlığı', ['1.a/c'], 1, madde: 'Liste A · 1.a veya 1.c'),
                        Kalip::adet('Tanınmış bir yayınevinden 2 kitap bölümü yazarlığı', ['1.b/ç'], 2, madde: 'Liste A · 1.b veya 1.ç'),
                    ]),
                ]),
            ]),
            Kalip::adet('Bu makalelerden en az 2\'sinde başlıca yazar olmalısınız', ['2.a-ç/h,ı'], 2, 'baslica', madde: 'Liste A · 2.a-ç/h,ı'),
            $projeKosulu(['2.a-ç/h,ı']),
            Kalip::toplam(120, null, ['A'], 'Yayın ve proje'),
            $dil(),
        ]),
    ],

    [
        'anahtar' => 'mersin-dr-spor',
        'aday_notu' => 'Makale sayısını tutturmak yetmiyor: bu makalelerden en az birinde başlıca yazar olmanız gerekiyor. Projeniz yoksa yönerge bunu ilave bir makaleyle telafi etmenize izin veriyor.',
        'universite' => 'Mersin Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['spor'],
        'cetvel' => 'mersin-2024',
        'notlar' => '2.1.1 c-5) SPOR BİLİMLERİ. Fark: ikinci koşul "en az BİR tanesi 2.a-ç '
            .'kapsamında" (Sağlık/Fen\'de iki), telafi makalesi 2.a-ç/h kümesinden.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi ilk atanma — Spor Bilimleri', [
            Kalip::adet('SCIE/SSCI, AHCI, ESCI/Scopus veya TR Dizin dergilerinde en az 5 araştırma makalesi', ['2.a-ç/h,ı'], 5, madde: 'Liste A · 2.a-ç/h,ı'),
            Kalip::adet('Bu makalelerden en az birinde başlıca yazar olmalısınız', ['2.a-ç/h,ı'], 1, 'baslica', madde: 'Liste A · 2.a-ç/h,ı'),
            Kalip::adet('Bu makalelerden en az 1 tanesi SCIE/SSCI veya AHCI dergilerinde olmalı', ['2.a-ç'], 1, madde: 'Liste A · 2.a-ç'),
            $projeKosulu(['2.a-ç/h']),
            Kalip::toplam(120, null, ['A'], 'Yayın ve proje'),
            $dil(),
        ]),
    ],

    [
        'anahtar' => 'mersin-dr-sanat',
        'aday_notu' => 'Puanınız sanat ve tasarım etkinliklerinden (TABLO B) ve konservatuvar etkinliklerinden (TABLO C) birlikte hesaplanıyor. Makale, kitap ve proje kalemleri bu toplama girmez; onlar TABLO A\'ya tabidir.',
        'universite' => 'Mersin Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['guzel_sanatlar', 'mimarlik'],
        'cetvel' => 'mersin-2024',
        'notlar' => '2.1.1 c-6) GÜZEL SANATLAR ve c-7) MİMARLIK, PLANLAMA ve TASARIM. Puan barajı '
            .'TABLO A\'dan değil TABLO B (sanat/tasarım) veya TABLO C (konservatuvar) '
            .'listesinden 120 puan.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi ilk atanma — Güzel Sanatlar / Mimarlık', [
            Kalip::toplam(120, null, ['B', 'C'], 'Sanatsal etkinlik'),
            Kalip::beyan('Alanınıza özgü sanatsal/tasarım etkinlik koşulları', 'Yönerge md. 2.1.1 c-6, c-7'),
            $dil(),
        ]),
    ],

    // ══════════ 2.2 · DOÇENT ══════════ (yalnızca puan barajı; alt koşullar okunmadı)

    [
        'anahtar' => 'mersin-docent-saglik-fen',
        'aday_notu' => 'Makale sayısını tutturmak yetmiyor: bunların bir bölümü SCIE/SSCI-AHCI '
            .'dergilerinde olmalı ve en az ikisinde başlıca yazar olmalısınız. Projeniz yoksa '
            .'yönerge ilave bir makaleyle telafi etmenize izin veriyor.',
        'universite' => 'Mersin Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['saglik', 'fen', 'muhendislik', 'ziraat'],
        'cetvel' => 'mersin-2024',
        'notlar' => '2.2 e-1) SAĞLIK ve e-2) FEN-MÜHENDİSLİK (metinleri birebir aynı). '
            .'"1) …en az yedi adet tam metinli araştırma makalesi. 2) …en az üç adeti 2.a,b,c '
            .'kapsamındaki dergilerde olmak üzere toplam beş adeti 2.a,b,c,ç kapsamında. Bu '
            .'fıkradaki makalelerden en az ikisinde başlıca yazar olmak. 3) 5.a-g projelerinden '
            .'birinde görev almak … sağlanamazsa 2.a,b,c kapsamında bir makale daha. '
            .'4) …en az 250 puan almak."',
        'sart' => Kalip::ve('Doçent — Sağlık / Fen ve Mühendislik', [
            Kalip::adet('SCIE/SSCI, AHCI, ESCI/Scopus veya TR Dizin dergilerinde en az 7 araştırma makalesi',
                ['2.a-ç/h,ı'], 7, donem: Kalip::DOKTORA_SONRASI, madde: 'Liste A · 2.a-ç/h,ı'),
            Kalip::adet('Bu makalelerden en az 3\'ü SCIE/SSCI veya AHCI dergilerinde olmalı',
                ['2.a-c'], 3, donem: Kalip::DOKTORA_SONRASI, madde: 'Liste A · 2.a, b, c'),
            Kalip::adet('Toplam 5\'i SCIE/SSCI, AHCI veya Q4 dergilerinde olmalı',
                ['2.a-ç'], 5, donem: Kalip::DOKTORA_SONRASI, madde: 'Liste A · 2.a-ç'),
            Kalip::adet('Bu makalelerden en az 2\'sinde başlıca yazar olmalısınız',
                ['2.a-ç'], 2, 'baslica', donem: Kalip::DOKTORA_SONRASI, madde: 'Liste A · 2.a-ç'),
            $projeKosulu(['2.a-c']),
            Kalip::toplam(250, Kalip::DOKTORA_SONRASI, ['A'], 'Yayın ve proje'),
            $dil(),
        ]),
    ],
    [
        'anahtar' => 'mersin-docent-egitim',
        'aday_notu' => 'Yedi makalenin üçünde başlıca yazar olmanız gerekiyor; sayıyı tutturmak '
            .'tek başına yetmiyor. Projeniz yoksa ilave bir makaleyle telafi edebilirsiniz.',
        'universite' => 'Mersin Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['egitim'],
        'cetvel' => 'mersin-2024',
        'notlar' => '2.2 e-3) EĞİTİM BİLİMLERİ. "1) …en az yedi adet tam metinli araştırma makalesi. '
            .'Bu makalelerden üç adetinde başlıca yazar olmak. 2) …en az iki adeti 2.a,b,c '
            .'kapsamında olmak üzere toplam üç adeti 2.a,b,c,ç kapsamında. 4) …en az 220 puan."',
        'sart' => Kalip::ve('Doçent — Eğitim Bilimleri', [
            Kalip::adet('SCIE/SSCI, AHCI, ESCI/Scopus veya TR Dizin dergilerinde en az 7 araştırma makalesi',
                ['2.a-ç/h,ı'], 7, donem: Kalip::DOKTORA_SONRASI, madde: 'Liste A · 2.a-ç/h,ı'),
            Kalip::adet('Bu makalelerden en az 3\'ünde başlıca yazar olmalısınız',
                ['2.a-ç/h,ı'], 3, 'baslica', donem: Kalip::DOKTORA_SONRASI, madde: 'Liste A · 2.a-ç/h,ı'),
            Kalip::adet('En az 2\'si SCIE/SSCI veya AHCI dergilerinde olmalı',
                ['2.a-c'], 2, donem: Kalip::DOKTORA_SONRASI, madde: 'Liste A · 2.a, b, c'),
            Kalip::adet('Toplam 3\'ü SCIE/SSCI, AHCI veya Q4 dergilerinde olmalı',
                ['2.a-ç'], 3, donem: Kalip::DOKTORA_SONRASI, madde: 'Liste A · 2.a-ç'),
            $projeKosulu(['2.a-ç']),
            Kalip::toplam(220, Kalip::DOKTORA_SONRASI, ['A'], 'Yayın ve proje'),
            $dil(),
        ]),
    ],
    [
        'anahtar' => 'mersin-docent-sosyal',
        'aday_notu' => 'DİKKAT: Yönerge bu grubu bilim alanına göre ikiye ayırıyor. Burada genel '
            .'kural uygulandı (5 makale). Felsefe, Gazetecilik ve Medya, Görsel İletişim, Halkla '
            .'İlişkiler, İletişim, Reklamcılık, Sanat Tarihi, Sinema ve Türk İslam Sanatı bilim '
            .'alanlarında sayı 6\'ya çıkıyor — bilim alanınızı yönergeden doğrulayın.',
        'universite' => 'Mersin Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['sosyal'],
        'cetvel' => 'mersin-2024',
        'notlar' => '2.2 e-4/1) Filoloji (Çeviribilim, Dünya Dilleri) ve Sosyal-Beşeri-İdari '
            .'(sayılan bilim alanları DIŞINDAKİLER). "…en az beş adet tam metinli araştırma '
            .'makalesi ya da dört adet … ve 1.a/c kapsamında bir kitap veya 1.b/ç kapsamında iki '
            .'kitap bölümü. …en az iki adetinde başlıca yazar olmak. …yayınlardan iki adetinin; en '
            .'az bir adeti 2.a,b,c,ç ve en az bir adeti 2.a,b,c,ç/h kapsamında." PROJEKSİYON: '
            .'TemelAlan enum\'u bilim alanı ayrımını taşımıyor; e-4/2 varyantı (6 makale) '
            .'filoloji ve ilahiyat kayıtlarında kullanıldı.',
        'sart' => Kalip::ve('Doçent — Sosyal, Beşeri ve İdari Bilimler', [
            Kalip::veya('Beş makale ya da dört makale + kitap', [
                Kalip::adet('SCIE/SSCI, AHCI, ESCI/Scopus veya TR Dizin dergilerinde en az 5 araştırma makalesi',
                    ['2.a-ç/h,ı'], 5, donem: Kalip::DOKTORA_SONRASI, madde: 'Liste A · 2.a-ç/h,ı'),
                Kalip::ve('4 makale + kitap yolu', [
                    Kalip::adet('Bu dergilerde en az 4 araştırma makalesi', ['2.a-ç/h,ı'], 4,
                        donem: Kalip::DOKTORA_SONRASI, madde: 'Liste A · 2.a-ç/h,ı'),
                    Kalip::veya('1 kitap yazarlığı ya da 2 kitap bölümü', [
                        Kalip::adet('Tanınmış bir yayınevinden 1 kitap yazarlığı', ['1.a/c'], 1, madde: 'Liste A · 1.a veya 1.c'),
                        Kalip::adet('Tanınmış bir yayınevinden 2 kitap bölümü yazarlığı', ['1.b/ç'], 2, madde: 'Liste A · 1.b veya 1.ç'),
                    ]),
                ]),
            ]),
            Kalip::adet('Bu makalelerden en az 2\'sinde başlıca yazar olmalısınız',
                ['2.a-ç/h,ı'], 2, 'baslica', donem: Kalip::DOKTORA_SONRASI, madde: 'Liste A · 2.a-ç/h,ı'),
            Kalip::adet('En az 1 yayın SCIE/SSCI, AHCI veya Q4 dergisinde olmalı',
                ['2.a-ç'], 1, donem: Kalip::DOKTORA_SONRASI, madde: 'Liste A · 2.a-ç'),
            Kalip::adet('En az 1 yayın SCIE/SSCI, AHCI veya ESCI/Scopus dergisinde olmalı',
                ['2.a-ç/h'], 1, donem: Kalip::DOKTORA_SONRASI, madde: 'Liste A · 2.a-ç/h'),
            $projeKosulu(['2.a-ç/h']),
            Kalip::toplam(220, Kalip::DOKTORA_SONRASI, ['A'], 'Yayın ve proje'),
            $dil(),
        ]),
    ],
    [
        'anahtar' => 'mersin-docent-filoloji-ilahiyat',
        'aday_notu' => 'DİKKAT: Yönerge bu grubu bilim alanına göre ikiye ayırıyor. Burada 6 '
            .'makalelik varyant uygulandı. Çeviribilim ile Dünya Dilleri ve Edebiyatları bilim '
            .'alanlarında sayı 5\'e iniyor — bilim alanınızı yönergeden doğrulayın.',
        'universite' => 'Mersin Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['filoloji', 'ilahiyat'],
        'cetvel' => 'mersin-2024',
        'notlar' => '2.2 e-4/2) Filoloji (Çeviribilim ve Dünya Dilleri DIŞINDAKİLER), İlahiyat ve '
            .'Sosyal-Beşeri-İdari (sayılan bilim alanları). "…en az altı adet tam metinli araştırma '
            .'makalesi ya da beş adet … ve bir kitap/iki kitap bölümü. …en az iki adetinde başlıca '
            .'yazar olmak. …en az iki tanesi 2.a,b,c,ç/h kapsamında."',
        'sart' => Kalip::ve('Doçent — Filoloji / İlahiyat', [
            Kalip::veya('Altı makale ya da beş makale + kitap', [
                Kalip::adet('SCIE/SSCI, AHCI, ESCI/Scopus veya TR Dizin dergilerinde en az 6 araştırma makalesi',
                    ['2.a-ç/h,ı'], 6, donem: Kalip::DOKTORA_SONRASI, madde: 'Liste A · 2.a-ç/h,ı'),
                Kalip::ve('5 makale + kitap yolu', [
                    Kalip::adet('Bu dergilerde en az 5 araştırma makalesi', ['2.a-ç/h,ı'], 5,
                        donem: Kalip::DOKTORA_SONRASI, madde: 'Liste A · 2.a-ç/h,ı'),
                    Kalip::veya('1 kitap yazarlığı ya da 2 kitap bölümü', [
                        Kalip::adet('Tanınmış bir yayınevinden 1 kitap yazarlığı', ['1.a/c'], 1, madde: 'Liste A · 1.a veya 1.c'),
                        Kalip::adet('Tanınmış bir yayınevinden 2 kitap bölümü yazarlığı', ['1.b/ç'], 2, madde: 'Liste A · 1.b veya 1.ç'),
                    ]),
                ]),
            ]),
            Kalip::adet('Bu makalelerden en az 2\'sinde başlıca yazar olmalısınız',
                ['2.a-ç/h,ı'], 2, 'baslica', donem: Kalip::DOKTORA_SONRASI, madde: 'Liste A · 2.a-ç/h,ı'),
            Kalip::adet('En az 2 yayın SCIE/SSCI, AHCI veya ESCI/Scopus dergisinde olmalı',
                ['2.a-ç/h'], 2, donem: Kalip::DOKTORA_SONRASI, madde: 'Liste A · 2.a-ç/h'),
            $projeKosulu(['2.a-ç/h']),
            Kalip::toplam(220, Kalip::DOKTORA_SONRASI, ['A'], 'Yayın ve proje'),
            $dil(),
        ]),
    ],
    [
        'anahtar' => 'mersin-docent-hukuk',
        'aday_notu' => 'Hukuk alanında makale sayısı diğer sosyal alanlardan yüksek ve üçünde '
            .'başlıca yazar olmanız gerekiyor.',
        'universite' => 'Mersin Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['hukuk'],
        'cetvel' => 'mersin-2024',
        'notlar' => '2.2 e-4/3) HUKUK. "…en az yedi adet tam metinli araştırma makalesi ya da altı '
            .'adet … ve bir kitap/iki kitap bölümü. …en az üç adetinde başlıca yazar olmak."',
        'sart' => Kalip::ve('Doçent — Hukuk', [
            Kalip::veya('Yedi makale ya da altı makale + kitap', [
                Kalip::adet('SCIE/SSCI, AHCI, ESCI/Scopus veya TR Dizin dergilerinde en az 7 araştırma makalesi',
                    ['2.a-ç/h,ı'], 7, donem: Kalip::DOKTORA_SONRASI, madde: 'Liste A · 2.a-ç/h,ı'),
                Kalip::ve('6 makale + kitap yolu', [
                    Kalip::adet('Bu dergilerde en az 6 araştırma makalesi', ['2.a-ç/h,ı'], 6,
                        donem: Kalip::DOKTORA_SONRASI, madde: 'Liste A · 2.a-ç/h,ı'),
                    Kalip::veya('1 kitap yazarlığı ya da 2 kitap bölümü', [
                        Kalip::adet('Tanınmış bir yayınevinden 1 kitap yazarlığı', ['1.a/c'], 1, madde: 'Liste A · 1.a veya 1.c'),
                        Kalip::adet('Tanınmış bir yayınevinden 2 kitap bölümü yazarlığı', ['1.b/ç'], 2, madde: 'Liste A · 1.b veya 1.ç'),
                    ]),
                ]),
            ]),
            Kalip::adet('Bu makalelerden en az 3\'ünde başlıca yazar olmalısınız',
                ['2.a-ç/h,ı'], 3, 'baslica', donem: Kalip::DOKTORA_SONRASI, madde: 'Liste A · 2.a-ç/h,ı'),
            $projeKosulu(['2.a-ç/h,ı']),
            Kalip::toplam(220, Kalip::DOKTORA_SONRASI, ['A'], 'Yayın ve proje'),
            $dil(),
        ]),
    ],
    [
        'anahtar' => 'mersin-docent-spor',
        'aday_notu' => 'Yedi makalenin en az üçü SCIE/SSCI, AHCI veya Q4 dergilerinde olmalı ve '
            .'ikisinde başlıca yazar olmalısınız.',
        'universite' => 'Mersin Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['spor'],
        'cetvel' => 'mersin-2024',
        'notlar' => '2.2 e-5) SPOR BİLİMLERİ. "1) …en az yedi adet tam metinli araştırma makalesi. '
            .'Bu makalelerden en az iki adetinde başlıca yazar olmak. 2) …en az üç tanesi 2.a,b,c,ç '
            .'kapsamındaki dergilerde. 4) …en az 220 puan."',
        'sart' => Kalip::ve('Doçent — Spor Bilimleri', [
            Kalip::adet('SCIE/SSCI, AHCI, ESCI/Scopus veya TR Dizin dergilerinde en az 7 araştırma makalesi',
                ['2.a-ç/h,ı'], 7, donem: Kalip::DOKTORA_SONRASI, madde: 'Liste A · 2.a-ç/h,ı'),
            Kalip::adet('Bu makalelerden en az 2\'sinde başlıca yazar olmalısınız',
                ['2.a-ç/h,ı'], 2, 'baslica', donem: Kalip::DOKTORA_SONRASI, madde: 'Liste A · 2.a-ç/h,ı'),
            Kalip::adet('En az 3\'ü SCIE/SSCI, AHCI veya Q4 dergilerinde olmalı',
                ['2.a-ç'], 3, donem: Kalip::DOKTORA_SONRASI, madde: 'Liste A · 2.a-ç'),
            $projeKosulu(['2.a-ç']),
            Kalip::toplam(220, Kalip::DOKTORA_SONRASI, ['A'], 'Yayın ve proje'),
            $dil(),
        ]),
    ],
    [
        'anahtar' => 'mersin-docent-mimarlik',
        'aday_notu' => 'Puan barajı yönerge gereği iki listeden BİRLİKTE hesaplanıyor: Liste A (makale, kitap, proje, atıf) ve TABLO B (sanat ve tasarım etkinlikleri). Projede yalnızca yürütücülük sayılıyor.',
        'universite' => 'Mersin Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['mimarlik'],
        'cetvel' => 'mersin-2024',
        'notlar' => '2.2 e-7) MİMARLIK, PLANLAMA ve TASARIM. "1) …en az beş adet tam metinli '
            .'araştırma makalesi. Bu makalelerden iki adetinde başlıca yazar olmak. 2) …en az iki '
            .'tanesi 2.a,b,c,ç kapsamındaki dergilerde. 4) Liste (A) ve Liste (B)\'den en az 220 puan."',
        'sart' => Kalip::ve('Doçent — Mimarlık, Planlama ve Tasarım', [
            Kalip::adet('SCIE/SSCI, AHCI, ESCI/Scopus veya TR Dizin dergilerinde en az 5 araştırma makalesi',
                ['2.a-ç/h,ı'], 5, donem: Kalip::DOKTORA_SONRASI, madde: 'Liste A · 2.a-ç/h,ı'),
            Kalip::adet('Bu makalelerden en az 2\'sinde başlıca yazar olmalısınız',
                ['2.a-ç/h,ı'], 2, 'baslica', donem: Kalip::DOKTORA_SONRASI, madde: 'Liste A · 2.a-ç/h,ı'),
            Kalip::adet('En az 2\'si SCIE/SSCI, AHCI veya Q4 dergilerinde olmalı',
                ['2.a-ç'], 2, donem: Kalip::DOKTORA_SONRASI, madde: 'Liste A · 2.a-ç'),
            $projeKosulu(['2.a-ç/h']),
            Kalip::toplam(220, Kalip::DOKTORA_SONRASI, ['A', 'B'], 'Yayın, proje ve sanatsal etkinlik'),
            $dil(),
        ]),
    ],
    [
        'anahtar' => 'mersin-docent-sanat',
        'aday_notu' => 'Puanınız sanat ve tasarım etkinliklerinden (TABLO B) ve konservatuvar etkinliklerinden (TABLO C) birlikte hesaplanıyor. Makale, kitap ve proje kalemleri bu toplama girmez; onlar TABLO A\'ya tabidir.',
        'universite' => 'Mersin Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'mersin-2024',
        'notlar' => '2.2 e-6/e-7) TABLO B veya C listesinden en az 220 puan.',
        'sart' => Kalip::ve('Doçent — Güzel Sanatlar / Mimarlık', [
            Kalip::toplam(220, Kalip::DOKTORA_SONRASI, ['B', 'C'], 'Sanatsal etkinlik'),
            $dil(),
        ]),
    ],

    // ══════════ 2.3 · PROFESÖR ══════════

    [
        'anahtar' => 'mersin-profesor-saglik-fen',
        'aday_notu' => 'Beş makalenin tamamı SCIE/SSCI, AHCI veya Q4 dergilerinde olmalı — TR Dizin '
            .'bu koşula sayılmıyor. Ayrıca projede yalnızca YÜRÜTÜCÜLÜK sayılıyor; araştırmacılık '
            .'yetmiyor, yoksa iki ilave makale gerekiyor.',
        'universite' => 'Mersin Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['saglik', 'fen', 'muhendislik', 'ziraat'],
        'cetvel' => 'mersin-2024',
        'notlar' => '2.3 d-1) SAĞLIK ve d-2) FEN-MÜHENDİSLİK (metinleri birebir aynı). "1) …2.a,b,c,ç '
            .'kapsamındaki dergilerde en az beş adet tam metinli araştırma makalesi. 2) …en az üç '
            .'adeti 2.a,b,c kapsamında olmak üzere toplam beş adeti 2.a,b,c,ç kapsamında. 2.a,b,c,ç\'de '
            .'yayımlanmış makalelerden en az ikisinde başlıca yazar olmak. 3) 5.a-g projelerinden '
            .'birinde koordinatör/yürütücü olarak görev almak … sağlanamazsa 2.a,b,c,ç kapsamında iki '
            .'makale daha. 4) …en az 350 puan almak."',
        'sart' => Kalip::ve('Profesör — Sağlık / Fen ve Mühendislik', [
            Kalip::adet('SCIE/SSCI, AHCI veya Q4 dergilerinde en az 5 araştırma makalesi',
                ['2.a-ç'], 5, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Liste A · 2.a-ç'),
            Kalip::adet('Bu makalelerden en az 3\'ü SCIE/SSCI veya AHCI dergilerinde olmalı',
                ['2.a-c'], 3, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Liste A · 2.a, b, c'),
            Kalip::adet('Bu makalelerden en az 2\'sinde başlıca yazar olmalısınız',
                ['2.a-ç'], 2, 'baslica', donem: Kalip::DOCENTLIK_SONRASI, madde: 'Liste A · 2.a-ç'),
            $profesorProjeKosulu(['2.a-ç']),
            Kalip::toplam(350, Kalip::DOCENTLIK_SONRASI, ['A'], 'Yayın ve proje'),
            Kalip::beyan('Doçent unvanını aldıktan sonra en az 3 yıl bir yükseköğretim kurumunda doçent kadrosunda görev yapmış olmak', 'Yönerge md. 2.3 b'),
            $dil(),
        ]),
    ],
    [
        'anahtar' => 'mersin-profesor-egitim',
        'aday_notu' => 'Projede yalnızca yürütücülük sayılıyor; yoksa iki ilave makale gerekiyor.',
        'universite' => 'Mersin Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['egitim'],
        'cetvel' => 'mersin-2024',
        'notlar' => '2.3 d-3) EĞİTİM BİLİMLERİ. "1) …en az altı adet tam metinli araştırma makalesi. '
            .'Bu makalelerden en az iki adetinde başlıca yazar olmak. 2) …en az iki adeti 2.a,b,c '
            .'kapsamında olmak üzere toplam üç adeti 2.a,b,c,ç kapsamında. 4) …en az 320 puan."',
        'sart' => Kalip::ve('Profesör — Eğitim Bilimleri', [
            Kalip::adet('SCIE/SSCI, AHCI, ESCI/Scopus veya TR Dizin dergilerinde en az 6 araştırma makalesi',
                ['2.a-ç/h,ı'], 6, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Liste A · 2.a-ç/h,ı'),
            Kalip::adet('Bu makalelerden en az 2\'sinde başlıca yazar olmalısınız',
                ['2.a-ç/h,ı'], 2, 'baslica', donem: Kalip::DOCENTLIK_SONRASI, madde: 'Liste A · 2.a-ç/h,ı'),
            Kalip::adet('En az 2\'si SCIE/SSCI veya AHCI dergilerinde olmalı',
                ['2.a-c'], 2, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Liste A · 2.a, b, c'),
            Kalip::adet('Toplam 3\'ü SCIE/SSCI, AHCI veya Q4 dergilerinde olmalı',
                ['2.a-ç'], 3, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Liste A · 2.a-ç'),
            $profesorProjeKosulu(['2.a-ç']),
            Kalip::toplam(320, Kalip::DOCENTLIK_SONRASI, ['A'], 'Yayın ve proje'),
            Kalip::beyan('Doçent unvanını aldıktan sonra en az 3 yıl bir yükseköğretim kurumunda doçent kadrosunda görev yapmış olmak', 'Yönerge md. 2.3 b'),
            $dil(),
        ]),
    ],
    [
        'anahtar' => 'mersin-profesor-sosyal',
        'aday_notu' => 'DİKKAT: Yönerge bu grubu bilim alanına göre ikiye ayırıyor. Burada genel '
            .'kural uygulandı (5 makale). Felsefe, Gazetecilik ve Medya, Görsel İletişim, Halkla '
            .'İlişkiler, İletişim, Reklamcılık, Sanat Tarihi, Sinema ve Türk İslam Sanatı bilim '
            .'alanlarında sayı 7\'ye çıkıyor — bilim alanınızı yönergeden doğrulayın.',
        'universite' => 'Mersin Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['sosyal'],
        'cetvel' => 'mersin-2024',
        'notlar' => '2.3 d-4/1) Filoloji (Çeviribilim, Dünya Dilleri) ve Sosyal-Beşeri-İdari (sayılan '
            .'bilim alanları DIŞINDAKİLER). "…en az beş adet … ya da dört adet … ve bir kitap/iki '
            .'kitap bölümü. …en az iki adetinde başlıca yazar. …en az bir adeti 2.a,b,c,ç ve en az '
            .'bir adeti 2.a,b,c,ç/h kapsamında." Proje telafisi burada TEK makale (md. 4).',
        'sart' => Kalip::ve('Profesör — Sosyal, Beşeri ve İdari Bilimler', [
            Kalip::veya('Beş makale ya da dört makale + kitap', [
                Kalip::adet('SCIE/SSCI, AHCI, ESCI/Scopus veya TR Dizin dergilerinde en az 5 araştırma makalesi',
                    ['2.a-ç/h,ı'], 5, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Liste A · 2.a-ç/h,ı'),
                Kalip::ve('4 makale + kitap yolu', [
                    Kalip::adet('Bu dergilerde en az 4 araştırma makalesi', ['2.a-ç/h,ı'], 4,
                        donem: Kalip::DOCENTLIK_SONRASI, madde: 'Liste A · 2.a-ç/h,ı'),
                    Kalip::veya('1 kitap yazarlığı ya da 2 kitap bölümü', [
                        Kalip::adet('Tanınmış bir yayınevinden 1 kitap yazarlığı', ['1.a/c'], 1, madde: 'Liste A · 1.a veya 1.c'),
                        Kalip::adet('Tanınmış bir yayınevinden 2 kitap bölümü yazarlığı', ['1.b/ç'], 2, madde: 'Liste A · 1.b veya 1.ç'),
                    ]),
                ]),
            ]),
            Kalip::adet('Bu makalelerden en az 2\'sinde başlıca yazar olmalısınız',
                ['2.a-ç/h,ı'], 2, 'baslica', donem: Kalip::DOCENTLIK_SONRASI, madde: 'Liste A · 2.a-ç/h,ı'),
            Kalip::adet('En az 1 yayın SCIE/SSCI, AHCI veya Q4 dergisinde olmalı',
                ['2.a-ç'], 1, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Liste A · 2.a-ç'),
            Kalip::adet('En az 1 yayın SCIE/SSCI, AHCI veya ESCI/Scopus dergisinde olmalı',
                ['2.a-ç/h'], 1, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Liste A · 2.a-ç/h'),
            $profesorProjeKosulu(['2.a-ç/h'], 1),
            Kalip::toplam(320, Kalip::DOCENTLIK_SONRASI, ['A'], 'Yayın ve proje'),
            Kalip::beyan('Doçent unvanını aldıktan sonra en az 3 yıl bir yükseköğretim kurumunda doçent kadrosunda görev yapmış olmak', 'Yönerge md. 2.3 b'),
            $dil(),
        ]),
    ],
    [
        'anahtar' => 'mersin-profesor-filoloji-ilahiyat',
        'aday_notu' => 'DİKKAT: Yönerge bu grubu bilim alanına göre ikiye ayırıyor. Burada 7 '
            .'makalelik varyant uygulandı. Çeviribilim ile Dünya Dilleri ve Edebiyatları bilim '
            .'alanlarında sayı 5\'e iniyor — bilim alanınızı yönergeden doğrulayın.',
        'universite' => 'Mersin Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['filoloji', 'ilahiyat'],
        'cetvel' => 'mersin-2024',
        'notlar' => '2.3 d-4/2) Filoloji (Çeviribilim ve Dünya Dilleri DIŞINDAKİLER), İlahiyat ve '
            .'Sosyal-Beşeri-İdari (sayılan bilim alanları). "…en az yedi adet … ya da beş adet … ve '
            .'bir kitap/iki kitap bölümü. …en az iki adetinde başlıca yazar. …en az iki adeti '
            .'2.a,b,c,ç/h kapsamında."',
        'sart' => Kalip::ve('Profesör — Filoloji / İlahiyat', [
            Kalip::veya('Yedi makale ya da beş makale + kitap', [
                Kalip::adet('SCIE/SSCI, AHCI, ESCI/Scopus veya TR Dizin dergilerinde en az 7 araştırma makalesi',
                    ['2.a-ç/h,ı'], 7, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Liste A · 2.a-ç/h,ı'),
                Kalip::ve('5 makale + kitap yolu', [
                    Kalip::adet('Bu dergilerde en az 5 araştırma makalesi', ['2.a-ç/h,ı'], 5,
                        donem: Kalip::DOCENTLIK_SONRASI, madde: 'Liste A · 2.a-ç/h,ı'),
                    Kalip::veya('1 kitap yazarlığı ya da 2 kitap bölümü', [
                        Kalip::adet('Tanınmış bir yayınevinden 1 kitap yazarlığı', ['1.a/c'], 1, madde: 'Liste A · 1.a veya 1.c'),
                        Kalip::adet('Tanınmış bir yayınevinden 2 kitap bölümü yazarlığı', ['1.b/ç'], 2, madde: 'Liste A · 1.b veya 1.ç'),
                    ]),
                ]),
            ]),
            Kalip::adet('Bu makalelerden en az 2\'sinde başlıca yazar olmalısınız',
                ['2.a-ç/h,ı'], 2, 'baslica', donem: Kalip::DOCENTLIK_SONRASI, madde: 'Liste A · 2.a-ç/h,ı'),
            Kalip::adet('En az 2 yayın SCIE/SSCI, AHCI veya ESCI/Scopus dergisinde olmalı',
                ['2.a-ç/h'], 2, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Liste A · 2.a-ç/h'),
            $profesorProjeKosulu(['2.a-ç/h'], 1),
            Kalip::toplam(320, Kalip::DOCENTLIK_SONRASI, ['A'], 'Yayın ve proje'),
            Kalip::beyan('Doçent unvanını aldıktan sonra en az 3 yıl bir yükseköğretim kurumunda doçent kadrosunda görev yapmış olmak', 'Yönerge md. 2.3 b'),
            $dil(),
        ]),
    ],
    [
        'anahtar' => 'mersin-profesor-hukuk',
        'aday_notu' => 'Hukukta makale sayısı en yüksek grup ve dördünde başlıca yazar olmanız '
            .'gerekiyor; sayıyı tutturmak tek başına yetmiyor.',
        'universite' => 'Mersin Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['hukuk'],
        'cetvel' => 'mersin-2024',
        'notlar' => '2.3 d-4/3) HUKUK. "…en az sekiz adet … ya da altı adet … ve bir kitap/iki kitap '
            .'bölümü. …en az dört adetinde başlıca yazar olmak."',
        'sart' => Kalip::ve('Profesör — Hukuk', [
            Kalip::veya('Sekiz makale ya da altı makale + kitap', [
                Kalip::adet('SCIE/SSCI, AHCI, ESCI/Scopus veya TR Dizin dergilerinde en az 8 araştırma makalesi',
                    ['2.a-ç/h,ı'], 8, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Liste A · 2.a-ç/h,ı'),
                Kalip::ve('6 makale + kitap yolu', [
                    Kalip::adet('Bu dergilerde en az 6 araştırma makalesi', ['2.a-ç/h,ı'], 6,
                        donem: Kalip::DOCENTLIK_SONRASI, madde: 'Liste A · 2.a-ç/h,ı'),
                    Kalip::veya('1 kitap yazarlığı ya da 2 kitap bölümü', [
                        Kalip::adet('Tanınmış bir yayınevinden 1 kitap yazarlığı', ['1.a/c'], 1, madde: 'Liste A · 1.a veya 1.c'),
                        Kalip::adet('Tanınmış bir yayınevinden 2 kitap bölümü yazarlığı', ['1.b/ç'], 2, madde: 'Liste A · 1.b veya 1.ç'),
                    ]),
                ]),
            ]),
            Kalip::adet('Bu makalelerden en az 4\'ünde başlıca yazar olmalısınız',
                ['2.a-ç/h,ı'], 4, 'baslica', donem: Kalip::DOCENTLIK_SONRASI, madde: 'Liste A · 2.a-ç/h,ı'),
            $profesorProjeKosulu(['2.a-ç/h'], 1),
            Kalip::toplam(320, Kalip::DOCENTLIK_SONRASI, ['A'], 'Yayın ve proje'),
            Kalip::beyan('Doçent unvanını aldıktan sonra en az 3 yıl bir yükseköğretim kurumunda doçent kadrosunda görev yapmış olmak', 'Yönerge md. 2.3 b'),
            $dil(),
        ]),
    ],
    [
        'anahtar' => 'mersin-profesor-spor',
        'aday_notu' => 'Projede yalnızca yürütücülük sayılıyor; yoksa iki ilave makale gerekiyor.',
        'universite' => 'Mersin Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['spor'],
        'cetvel' => 'mersin-2024',
        'notlar' => '2.3 d-5) SPOR BİLİMLERİ. "1) …en az beş adet tam metinli araştırma makalesi. Bu '
            .'makalelerden en az iki adetinde başlıca yazar olmak. 2) …en az üç adeti 2.a,b,c,ç '
            .'kapsamında. 4) …en az 320 puan."',
        'sart' => Kalip::ve('Profesör — Spor Bilimleri', [
            Kalip::adet('SCIE/SSCI, AHCI, ESCI/Scopus veya TR Dizin dergilerinde en az 5 araştırma makalesi',
                ['2.a-ç/h,ı'], 5, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Liste A · 2.a-ç/h,ı'),
            Kalip::adet('Bu makalelerden en az 2\'sinde başlıca yazar olmalısınız',
                ['2.a-ç/h,ı'], 2, 'baslica', donem: Kalip::DOCENTLIK_SONRASI, madde: 'Liste A · 2.a-ç/h,ı'),
            Kalip::adet('En az 3\'ü SCIE/SSCI, AHCI veya Q4 dergilerinde olmalı',
                ['2.a-ç'], 3, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Liste A · 2.a-ç'),
            $profesorProjeKosulu(['2.a-ç']),
            Kalip::toplam(320, Kalip::DOCENTLIK_SONRASI, ['A'], 'Yayın ve proje'),
            Kalip::beyan('Doçent unvanını aldıktan sonra en az 3 yıl bir yükseköğretim kurumunda doçent kadrosunda görev yapmış olmak', 'Yönerge md. 2.3 b'),
            $dil(),
        ]),
    ],
    [
        'anahtar' => 'mersin-profesor-mimarlik',
        'aday_notu' => 'Puan barajı yönerge gereği iki listeden BİRLİKTE hesaplanıyor: Liste A (makale, kitap, proje, atıf) ve TABLO B (sanat ve tasarım etkinlikleri). Projede yalnızca yürütücülük sayılıyor.',
        'universite' => 'Mersin Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['mimarlik'],
        'cetvel' => 'mersin-2024',
        'notlar' => '2.3 d-7) MİMARLIK, PLANLAMA ve TASARIM. "1) …en az altı adet tam metinli '
            .'araştırma makalesi. Bu makalelerden en az iki adetinde başlıca yazar olmak. 2) …en az '
            .'iki tanesi 2.a,b,c,ç kapsamında. 4) Liste (A) ve Liste (B)\'den en az 320 puan."',
        'sart' => Kalip::ve('Profesör — Mimarlık, Planlama ve Tasarım', [
            Kalip::adet('SCIE/SSCI, AHCI, ESCI/Scopus veya TR Dizin dergilerinde en az 6 araştırma makalesi',
                ['2.a-ç/h,ı'], 6, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Liste A · 2.a-ç/h,ı'),
            Kalip::adet('Bu makalelerden en az 2\'sinde başlıca yazar olmalısınız',
                ['2.a-ç/h,ı'], 2, 'baslica', donem: Kalip::DOCENTLIK_SONRASI, madde: 'Liste A · 2.a-ç/h,ı'),
            Kalip::adet('En az 2\'si SCIE/SSCI, AHCI veya Q4 dergilerinde olmalı',
                ['2.a-ç'], 2, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Liste A · 2.a-ç'),
            $profesorProjeKosulu(['2.a-ç/h']),
            Kalip::toplam(320, Kalip::DOCENTLIK_SONRASI, ['A', 'B'], 'Yayın, proje ve sanatsal etkinlik'),
            Kalip::beyan('Doçent unvanını aldıktan sonra en az 3 yıl bir yükseköğretim kurumunda doçent kadrosunda görev yapmış olmak', 'Yönerge md. 2.3 b'),
            $dil(),
        ]),
    ],
    [
        'anahtar' => 'mersin-profesor-sanat',
        'aday_notu' => 'Puanınız sanat ve tasarım etkinliklerinden (TABLO B) ve konservatuvar etkinliklerinden (TABLO C) birlikte hesaplanıyor. Makale, kitap ve proje kalemleri bu toplama girmez; onlar TABLO A\'ya tabidir.',
        'universite' => 'Mersin Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'mersin-2024',
        'notlar' => '2.3) TABLO B veya C listesinden en az 320 puan.',
        'sart' => Kalip::ve('Profesör — Güzel Sanatlar / Mimarlık', [
            Kalip::toplam(320, Kalip::DOCENTLIK_SONRASI, ['B', 'C'], 'Sanatsal etkinlik'),
            $dil(),
        ]),
    ],
];
