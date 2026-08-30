<?php

/**
 * AĞRI İBRAHİM ÇEÇEN ÜNİVERSİTESİ — Öğretim Üyeliği Kadrolarına Başvuru
 * Uygulama Esasları
 * Kaynak: pdf/17536928002.agriibrahimcecenuniversitesi.pdf (01/01/2024 yürürlük)
 *
 * ÜÇ ALAN GRUBU GİRİLDİ, UYGULAMALI SANAT VE MÜZİK ALANLARI GİRİLMEDİ.
 * Yönergenin 5.1.4.2, 5.1.5 ve 7.1.3.2, 7.1.4 bentleri koşullarını 8-37 arası
 * sanatsal etkinlik maddelerine bağlıyor; o maddeler kaynak sözlüğünde
 * karşılıksız olduğu için cetvele girmedi. Karşılıksız maddelere dayanan bir
 * eşik üretmek, adaya hiçbir zaman sağlanamayacak bir koşul göstermek olurdu.
 *
 * DR. ÖĞR. ÜYELİĞİ (Madde 5) — üç grupta da toplam 40 puan, alt baraj değişiyor:
 *   Fen, Matematik, Mühendislik   1 numaralı maddeden en az 20
 *   Sosyal Bilimler               1 numaralı maddeden en az 20
 *   Sağlık Bilimleri              alt baraj YOK, yalnızca toplam 40
 * Sağlık'ın alt barajının olmaması yönergenin kendi tercihi (5.1.3), eksik veri
 * değil.
 *
 * DOÇENTLİKTE PUAN BARAJI YOK (Madde 6): yalnızca ÜAK doçentlik unvanı.
 *
 * PROFESÖRLÜK (Madde 7) iki grupta da genel toplam 200, ama kümeler farklı:
 *   Fen, Sağlık, Matematik, Müh.  1.1'den 20 · 1 numaralı maddeden 50 ·
 *                                 doçentlik sonrası 100 · genel toplam 200
 *   Sosyal                        1.1/1.2/TR Dizin'den 20 · 4 numaralı
 *                                 maddeden (kitap) 30 · 1+4+7'den 100 ·
 *                                 genel toplam 200
 * Sosyal grubun kitaptan ayrı baraj istemesi ayırt edici; fen grubunda kitap
 * koşulu yok.
 *
 * "7. MADDEDEN EN FAZLA 30 PUAN" tavanı cetvelde grup tavanı olarak değil,
 * atıf kaleminin kendisinde duruyor olsaydı bütün koşullara yansırdı; yönerge
 * bu sınırı yalnızca profesörlük hesabına koyduğu için burada aday notunda
 * anıldı.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/agri-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

$P = Kalip::DOCENTLIK_SONRASI;

/** Yönergenin koşullarını bağladığı, cetvele girmiş alanlar. */
$fenGrubu = ['fen', 'muhendislik', 'ziraat'];
$saglikGrubu = ['saglik'];
$sosyalGrubu = ['sosyal', 'egitim', 'filoloji', 'hukuk', 'ilahiyat', 'spor'];
$tumu = [...$fenGrubu, ...$saglikGrubu, ...$sosyalGrubu];

return [
    // ══════════ DR. ÖĞRETİM ÜYESİ ══════════
    [
        'anahtar' => 'agri-dr-fen',
        'aday_notu' => 'Aynı koşullar yeniden atanmada da geçerli.',
        'universite' => 'Ağrı İbrahim Çeçen Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => [...$fenGrubu, ...$sosyalGrubu],
        'cetvel' => 'agri-2024',
        'notlar' => 'Madde 5.1.1 ve 5.1.2: 1 numaralı maddeden en az 20, genel toplamda 40 puan.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Fen, Mühendislik ve Sosyal Bilimler', [
            Kalip::toplam(40),
            Kalip::puanDan('Makale kalemlerinizden en az 20 puan', ['1'], 20, madde: 'Madde 5.1.1'),
        ]),
    ],
    [
        'anahtar' => 'agri-dr-saglik',
        'aday_notu' => 'Sağlık Bilimlerinde makale alt barajı yok; yönerge yalnızca genel toplam '
            .'istiyor. Bu eksik veri değil, yönergenin kendi tercihi.',
        'universite' => 'Ağrı İbrahim Çeçen Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $saglikGrubu,
        'cetvel' => 'agri-2024',
        'notlar' => 'Madde 5.1.3: yalnızca genel toplamda 40 puan; alt baraj yok.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Sağlık Bilimleri', [
            Kalip::toplam(40),
        ]),
    ],

    // ══════════ DOÇENT (puan barajı yok) ══════════
    [
        'anahtar' => 'agri-docent',
        'aday_notu' => 'Ağrı yönergesi doçentlik için puan barajı koymuyor; yalnızca ÜAK '
            .'doçentlik unvanını şart koşuyor. Burada baraj görmüyorsunuz — eksik veri değil, '
            .'yönergede öyle.',
        'universite' => 'Ağrı İbrahim Çeçen Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $tumu,
        'cetvel' => 'agri-2024',
        'notlar' => 'Madde 6: Üniversitelerarası Kurul tarafından verilen doçent unvanı.',
        'sart' => Kalip::ve('Doçent — Ağrı İbrahim Çeçen Üniversitesi', [
            Kalip::beyan('Üniversitelerarası Kurul tarafından verilen doçent unvanını almış olmak', 'Madde 6'),
        ]),
    ],

    // ══════════ PROFESÖR ══════════
    [
        'anahtar' => 'agri-profesor-fen',
        'aday_notu' => 'Atıf kaleminden profesörlük hesabına en fazla 30 puan sayılabiliyor '
            .'; bu sınır burada uygulanmıyor, atıf puanınız yüksekse gerçek '
            .'toplamınız görünenden düşük olabilir. Ayrıca yayınlarınızdan birini başlıca '
            .'araştırma eseri olarak belirtmeniz gerekiyor.',
        'universite' => 'Ağrı İbrahim Çeçen Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => [...$fenGrubu, ...$saglikGrubu],
        'cetvel' => 'agri-2024',
        'notlar' => 'Madde 7.1.1: 1.1\'den 20, 1 numaralı maddeden 50, doçentlik sonrası 100, genel toplam 200.',
        'sart' => Kalip::ve('Profesör — Fen, Sağlık, Matematik ve Mühendislik', [
            Kalip::toplam(200),
            Kalip::toplam(100, $P),
            Kalip::puanDan('SCI, SSCI, SCI-Expanded, ESCI veya AHCI dergilerindeki makalelerinizden en az 20 puan',
                ['1.1*'], 20, $P, madde: 'Madde 7.1.1'),
            Kalip::puanDan('Tüm makale kalemlerinizden en az 50 puan', ['1'], 50, $P, madde: 'Madde 7.1.1'),
            Kalip::beyan('Yayınlarınızdan birini başvuru dosyasında başlıca araştırma eseri olarak '
                .'belirtmek', 'Madde 7.1'),
        ]),
    ],
    [
        'anahtar' => 'agri-profesor-sosyal',
        'aday_notu' => 'Sosyal Bilimlerde fen grubundan farklı olarak KİTAP kaleminden ayrı bir '
            .'baraj var (en az 30 puan). Atıf kaleminden hesaba en fazla 30 puan sayılabiliyor; '
            .'bu sınır burada uygulanmıyor.',
        'universite' => 'Ağrı İbrahim Çeçen Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $sosyalGrubu,
        'cetvel' => 'agri-2024',
        'notlar' => 'Madde 7.1.2: 1.1/1.2/TR Dizin\'den 20, 4 numaralı maddeden 30, 1+4+7\'den 100, genel toplam 200.',
        'sart' => Kalip::ve('Profesör — Sosyal Bilimler', [
            Kalip::toplam(200),
            Kalip::puanDan('SCI, SSCI, ESCI, alan indeksli veya TR Dizin dergilerindeki makalelerinizden en az 20 puan',
                ['1.1*', '1.2', '1.3'], 20, $P, madde: 'Madde 7.1.2'),
            Kalip::puanDan('Kitap ve kitap bölümü çalışmalarınızdan en az 30 puan',
                ['4.1', '4.2', '4.3'], 30, $P, madde: 'Madde 7.1.2'),
            Kalip::puanDan('Makale, kitap ve atıf kalemlerinizden toplam en az 100 puan',
                ['1', '4.1', '4.2', '4.3', '7.1'], 100, $P, madde: 'Madde 7.1.2'),
            Kalip::beyan('Yayınlarınızdan birini başvuru dosyasında başlıca araştırma eseri olarak '
                .'belirtmek', 'Madde 7.1'),
        ]),
    ],
];
