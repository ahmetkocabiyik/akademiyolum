<?php

/**
 * GÜMÜŞHANE ÜNİVERSİTESİ — şart ağaçları.
 *
 * Kaynak: pdf/178176998238.gumushane-kriter-18062026.pdf · EK-2 Asgari Şart ve
 * Puan Cetvelleri. Cetvel: database/data/cetvel/gumushane-2026.php
 *
 * ARKETİP: faaliyet grubu bazlı asgari puan. Her tablo satırı (A. MAKALE,
 * B. BİLDİRİ, ...) ayrı bir `puan` düğümü; tabloda iki farklı toplam var
 * (ASGARİ PUAN = zorunlu grupların toplamı, TOPLAM ASGARİ PUAN = tüm
 * faaliyetler) ve dört dipnot birer `telafi` dalı.
 *
 * Yazılan dilim: EK-2 TABLO-3 (Filoloji / Hukuk / İlahiyat / Sosyal), dört
 * kadro sütunu. TABLO-1 (Eğitim/Spor), TABLO-2 (Fen/Mimarlık/Mühendislik/
 * Sağlık/Ziraat) ve TABLO-4 (Güzel Sanatlar) henüz girilmedi.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · şema: sart-agaci-taslak.php
 */

use App\Services\Scoring\Sart\Kalip;

/** TABLO-3'ün (2) numaralı dipnotu — üç satırda birden geçiyor. */
$dipnot2 = Kalip::veya('Puan yetmezse: 1 indeksli makale ya da 2 TR Dizin makalesi daha', [
    Kalip::adet('İndeksli bir dergide (WoS/Scopus) 1 makale daha', ['A1-A2'], 1, madde: 'EK-1 · A1-A2'),
    Kalip::adet('TR Dizin dergisinde 2 makale daha', ['A3'], 2, madde: 'EK-1 · A3'),
]);

/** TABLO-2 dipnot (1) — "A1 kategorisinden ilave olarak 1 yayın yapmak zorundadır." */
$t2dipnot1 = Kalip::adet('Puan yetmezse: SCIE/SSCI veya AHCI dergisinde 1 makale daha', ['A1'], 1, madde: 'EK-1 · A1');

/** TABLO-2 dipnot (2) — "A1 kategorisinden ilave olarak 2 yayın yapmak zorundadır." */
$t2dipnot2 = Kalip::adet('Puan yetmezse: SCIE/SSCI veya AHCI dergisinde 2 makale daha', ['A1'], 2, madde: 'EK-1 · A1');

/** TABLO-4 dipnot (3) — "A1-A3 kategorilerinden ilave olarak 1 yayın." */
$t4dipnot3 = Kalip::adet('Puan yetmezse: indeksli veya TR Dizin dergisinde 1 makale daha', ['A1-A3'], 1, madde: 'EK-1 · A1-A3');

/** TABLO-4 dipnot (4) — "A1-A3 kategorilerinden ilave olarak 3 yayın." */
$t4dipnot4 = Kalip::adet('Puan yetmezse: indeksli veya TR Dizin dergisinde 3 makale daha', ['A1-A3'], 3, madde: 'EK-1 · A1-A3');

$alanlar = ['filoloji', 'hukuk', 'ilahiyat', 'sosyal'];

return [

    // ── Dr. Öğr. Üyesi · İLK ATANMA (Asgari 45P · Toplam 55P) ──
    [
        'anahtar' => 'gumushane-dr',
        'aday_notu' => 'Puanlar faaliyet grubu bazında ayrı ayrı sınanıyor: bir gruptaki fazlalık başka gruptaki eksiği kapatmıyor. Yönergenin dipnotları bazı eksikler için ilave yayın telafisi sunuyor.',
        'universite' => 'Gümüşhane Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $alanlar,
        'cetvel' => 'gumushane-2026',
        'notlar' => 'EK-2 TABLO-3, İLK ATANMA sütunu. Dipnot (1): "Makale asgari puanı '
            .'A1-A2 kategorilerinden sağlayanların A3 kategorisinden yayın yapmaları şartı aranmaz."',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi ilk atanma asgari şartları', [
            Kalip::adet('İndeksli bir dergide (WoS/Scopus) en az 1 makale', ['A1-A2'], 1, madde: 'EK-1 · A1-A2'),
            // Dipnot (1): makale asgari puanı A1-A2'den karşılanmışsa A3 şartı düşer.
            Kalip::adet('TR Dizin dergisinde en az 1 makale', ['A3'], 1, madde: 'EK-1 · A3', telafi: Kalip::puanDan(
                'Makale puanının 35\'inin tamamını indeksli dergilerden aldıysanız bu şart aranmaz',
                ['A1-A2'], 35, madde: 'EK-1 · A1-A2',
            )),
            Kalip::puanDan('Makalelerden toplam en az 35 puan', ['A'], 35, madde: 'EK-2 TABLO-3 · A. Makale'),
            Kalip::puanDan('Bildirilerden en az 10 puan', ['B'], 10, madde: 'EK-2 TABLO-3 · B. Bildiri'),
            Kalip::puanDan('Makale ve bildirilerden birlikte en az 45 puan', ['A', 'B'], 45, madde: 'EK-2 TABLO-3 · Asgari Puan'),
            Kalip::toplam(55),
        ]),
    ],

    // ── Dr. Öğr. Üyesi · YENİDEN ATANMA (Asgari 75P · Toplam 90P) ──
    [
        'anahtar' => 'gumushane-dr-yeniden',
        'aday_notu' => 'Puanlar faaliyet grubu bazında ayrı ayrı sınanıyor: bir gruptaki fazlalık başka gruptaki eksiği kapatmıyor. Yönergenin dipnotları bazı eksikler için ilave yayın telafisi sunuyor.',
        'universite' => 'Gümüşhane Üniversitesi',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $alanlar,
        'cetvel' => 'gumushane-2026',
        'notlar' => 'EK-2 TABLO-3, YENİDEN ATANMA / Dr. Öğretim Üyesi sütunu. Dipnot (2): '
            .'"Puan şartlarını sağlayamayanlar, A1-A2 kategorilerinden ilave olarak 1 yayın ya da '
            .'A3 kategorisinden ilave olarak 2 yayın yapmak zorundadır." — "ilave olarak" ifadesi '
            .'telafi yayınının asgari puana sayılıp sayılmayacağını söylemiyor.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi yeniden atanma asgari şartları', [
            Kalip::puanDan('İndeksli ve TR Dizin makalelerinden en az 30 puan', ['A1-A3'], 30, Kalip::SON_ATAMA_SONRASI, madde: 'EK-1 · A1-A3'),
            Kalip::puanDan('Bildirilerden en az 10 puan', ['B'], 10, Kalip::SON_ATAMA_SONRASI, madde: 'EK-2 TABLO-3 · B. Bildiri'),
            Kalip::puanDan('Projelerden en az 15 puan', ['E'], 15, Kalip::SON_ATAMA_SONRASI, madde: 'EK-2 TABLO-3 · E. Proje') + ['telafi' => $dipnot2],
            Kalip::puanDan('Verdiğiniz derslerden en az 20 puan', ['M'], 20, Kalip::SON_ATAMA_SONRASI, madde: 'EK-2 TABLO-3 · M. Öğretim') + ['telafi' => $dipnot2],
            Kalip::puanDan('Makale, bildiri, proje ve derslerden birlikte en az 75 puan', ['A', 'B', 'E', 'M'], 75, Kalip::SON_ATAMA_SONRASI, madde: 'EK-2 TABLO-3 · Asgari Puan'),
            Kalip::toplam(90, Kalip::SON_ATAMA_SONRASI),
        ]),
    ],

    // ── Doçent (Asgari 160P · Toplam 250P) ──
    [
        'anahtar' => 'gumushane-docent',
        'aday_notu' => 'Puanlar faaliyet grubu bazında ayrı ayrı sınanıyor: bir gruptaki fazlalık başka gruptaki eksiği kapatmıyor. Yönergenin dipnotları bazı eksikler için ilave yayın telafisi sunuyor.',
        'universite' => 'Gümüşhane Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $alanlar,
        'cetvel' => 'gumushane-2026',
        'notlar' => 'EK-2 TABLO-3, Doçent sütunu. Dipnot (3): "Puan şartlarını sağlayamayanlar, '
            .'A1-A2 kategorileri ve A3 kategorisinden ilave olarak 1\'er yayın yapmak zorundadır."',
        'sart' => Kalip::ve('Doçent asgari şartları', [
            Kalip::adet('İndeksli bir dergide (WoS/Scopus) en az 1 makale', ['A1-A2'], 1, madde: 'EK-1 · A1-A2'),
            Kalip::puanDan('İndeksli ve TR Dizin makalelerinden en az 70 puan', ['A1-A3'], 70, madde: 'EK-1 · A1-A3'),
            Kalip::puanDan('Bildirilerden en az 15 puan', ['B'], 15, madde: 'EK-2 TABLO-3 · B. Bildiri'),
            Kalip::puanDan('Kitap ve kitap bölümlerinden en az 20 puan', ['C'], 20, madde: 'EK-2 TABLO-3 · C. Kitap'),
            Kalip::puanDan('Yayınlarınıza yapılan atıflardan en az 15 puan', ['D'], 15, madde: 'EK-2 TABLO-3 · D. Atıf'),
            Kalip::ve('Proje koşulu', [
                Kalip::adet('Desteklenmiş en az 1 araştırma projesinde görev almış olmak', ['E1-E7'], 1, madde: 'EK-1 · E1-E7'),
                Kalip::puanDan('Projelerden en az 20 puan', ['E'], 20, madde: 'EK-2 TABLO-3 · E. Proje'),
            ]) + ['telafi' => Kalip::ve('Proje koşulu sağlanmazsa: 1 indeksli + 1 TR Dizin makalesi daha', [
                Kalip::adet('İndeksli bir dergide 1 makale daha', ['A1-A2'], 1, madde: 'EK-1 · A1-A2'),
                Kalip::adet('TR Dizin dergisinde 1 makale daha', ['A3'], 1, madde: 'EK-1 · A3'),
            ])],
            Kalip::ve('Ders verme koşulu', [
                Kalip::puanDan('Lisans/önlisans derslerinden en az 10 puan', ['M3-M4'], 10, madde: 'EK-1 · M3-M4'),
                Kalip::puanDan('Verdiğiniz tüm derslerden en az 20 puan', ['M'], 20, madde: 'EK-2 TABLO-3 · M. Öğretim'),
            ]) + ['telafi' => $dipnot2],
            Kalip::puanDan('Zorunlu faaliyet gruplarından birlikte en az 160 puan', ['A', 'B', 'C', 'D', 'E', 'M'], 160, madde: 'EK-2 TABLO-3 · Asgari Puan'),
            Kalip::toplam(250),
        ]),
    ],

    // ── Profesör (Asgari 210P · Toplam 300P) ──
    [
        'anahtar' => 'gumushane-profesor',
        'aday_notu' => 'Puanlar faaliyet grubu bazında ayrı ayrı sınanıyor: bir gruptaki fazlalık başka gruptaki eksiği kapatmıyor. Yönergenin dipnotları bazı eksikler için ilave yayın telafisi sunuyor.',
        'universite' => 'Gümüşhane Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'cetvel' => 'gumushane-2026',
        'notlar' => 'EK-2 TABLO-3, Profesör sütunu. Dipnot (4): "Puan şartlarını sağlayamayanlar, '
            .'A1-A2 kategorilerinden ilave olarak 1 yayın yapmak zorundadır."',
        'sart' => Kalip::ve('Profesör asgari şartları', [
            Kalip::adet('İndeksli bir dergide (WoS/Scopus) en az 1 makale', ['A1-A2'], 1, donem: Kalip::DOCENTLIK_SONRASI, madde: 'EK-1 · A1-A2'),
            Kalip::puanDan('İndeksli ve TR Dizin makalelerinden en az 80 puan', ['A1-A3'], 80, Kalip::DOCENTLIK_SONRASI, madde: 'EK-1 · A1-A3'),
            Kalip::puanDan('Bildirilerden en az 20 puan', ['B'], 20, Kalip::DOCENTLIK_SONRASI, madde: 'EK-2 TABLO-3 · B. Bildiri'),
            Kalip::puanDan('Kitap ve kitap bölümlerinden en az 20 puan', ['C'], 20, Kalip::DOCENTLIK_SONRASI, madde: 'EK-2 TABLO-3 · C. Kitap'),
            Kalip::puanDan('Yayınlarınıza yapılan atıflardan en az 30 puan', ['D'], 30, Kalip::DOCENTLIK_SONRASI, madde: 'EK-2 TABLO-3 · D. Atıf'),
            Kalip::ve('Proje koşulu', [
                Kalip::adet('Desteklenmiş en az 1 araştırma projesinde görev almış olmak', ['E1-E7'], 1, madde: 'EK-1 · E1-E7'),
                Kalip::puanDan('Projelerden en az 20 puan', ['E'], 20, madde: 'EK-2 TABLO-3 · E. Proje'),
            ]) + ['telafi' => Kalip::ve('Proje koşulu sağlanmazsa: 1 indeksli + 1 TR Dizin makalesi daha', [
                Kalip::adet('İndeksli bir dergide 1 makale daha', ['A1-A2'], 1, madde: 'EK-1 · A1-A2'),
                Kalip::adet('TR Dizin dergisinde 1 makale daha', ['A3'], 1, madde: 'EK-1 · A3'),
            ])],
            Kalip::puanDan('Tamamlanmış tez danışmanlıklarından en az 10 puan', ['İ1-İ2'], 10, madde: 'EK-1 · İ1-İ2')
                + ['telafi' => Kalip::adet('Tez danışmanlığınız yoksa: indeksli dergide 1 makale daha', ['A1-A2'], 1, madde: 'EK-1 · A1-A2')],
            Kalip::ve('Ders verme koşulu', [
                Kalip::puanDan('Lisans/önlisans derslerinden en az 15 puan', ['M3-M4'], 15, madde: 'EK-1 · M3-M4'),
                Kalip::puanDan('Verdiğiniz tüm derslerden en az 30 puan', ['M'], 30, madde: 'EK-2 TABLO-3 · M. Öğretim'),
            ]) + ['telafi' => $dipnot2],
            Kalip::puanDan('Zorunlu faaliyet gruplarından birlikte en az 210 puan', ['A', 'B', 'C', 'D', 'E', 'İ', 'M'], 210, Kalip::DOCENTLIK_SONRASI, madde: 'EK-2 TABLO-3 · Asgari Puan'),
            Kalip::toplam(300, Kalip::DOCENTLIK_SONRASI),
        ]),
    ],

    // ══════════ EK-2 TABLO-1 · Eğitim Bilimleri / Spor Bilimleri ══════════
    // TABLO-3 ile aynı iskelet; farkı makale kategorisi kısıtlarında:
    // doçentte A1-A2 yerine A1, profesörde 1 yerine 2 yayın isteniyor.

    [
        'anahtar' => 'gumushane-dr-egitim-spor',
        'aday_notu' => 'Puanlar faaliyet grubu bazında ayrı ayrı sınanıyor: bir gruptaki fazlalık başka gruptaki eksiği kapatmıyor. Yönergenin dipnotları bazı eksikler için ilave yayın telafisi sunuyor.',
        'universite' => 'Gümüşhane Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['egitim', 'spor'],
        'cetvel' => 'gumushane-2026',
        'notlar' => 'EK-2 TABLO-1, İLK ATANMA sütunu: "A1-A2 kategorilerinden en az 1 yayın olmak '
            .'şartıyla, A grubundan toplamda en az 35P almış olmak." · B grubundan 10P. '
            .'Asgari 45P, toplam 55P.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi ilk atanma asgari şartları', [
            Kalip::adet('İndeksli bir dergide (WoS/Scopus) en az 1 makale', ['A1-A2'], 1, madde: 'EK-1 · A1-A2'),
            Kalip::puanDan('Makalelerden toplam en az 35 puan', ['A'], 35, madde: 'EK-2 TABLO-1 · A. Makale'),
            Kalip::puanDan('Bildirilerden en az 10 puan', ['B'], 10, madde: 'EK-2 TABLO-1 · B. Bildiri'),
            Kalip::puanDan('Makale ve bildirilerden birlikte en az 45 puan', ['A', 'B'], 45, madde: 'EK-2 TABLO-1 · Asgari Puan'),
            Kalip::toplam(55),
        ]),
    ],
    [
        'anahtar' => 'gumushane-dr-yeniden-egitim-spor',
        'aday_notu' => 'Puanlar faaliyet grubu bazında ayrı ayrı sınanıyor: bir gruptaki fazlalık başka gruptaki eksiği kapatmıyor. Yönergenin dipnotları bazı eksikler için ilave yayın telafisi sunuyor.',
        'universite' => 'Gümüşhane Üniversitesi',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => ['egitim', 'spor'],
        'cetvel' => 'gumushane-2026',
        'notlar' => 'EK-2 TABLO-1, YENİDEN ATANMA sütunu: A1-A2\'den en az 1 yayın şartıyla A '
            .'grubundan 30P · B 10P · E 15P · M 20P. Asgari 75P, toplam 90P. Dipnot (1) E ve M '
            .'satırlarına telafi getiriyor.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi yeniden atanma asgari şartları', [
            Kalip::adet('İndeksli bir dergide (WoS/Scopus) en az 1 makale', ['A1-A2'], 1, donem: Kalip::SON_ATAMA_SONRASI, madde: 'EK-1 · A1-A2'),
            Kalip::puanDan('Makalelerden toplam en az 30 puan', ['A'], 30, Kalip::SON_ATAMA_SONRASI, madde: 'EK-2 TABLO-1 · A. Makale'),
            Kalip::puanDan('Bildirilerden en az 10 puan', ['B'], 10, Kalip::SON_ATAMA_SONRASI, madde: 'EK-2 TABLO-1 · B. Bildiri'),
            Kalip::puanDan('Projelerden en az 15 puan', ['E'], 15, Kalip::SON_ATAMA_SONRASI, madde: 'EK-2 TABLO-1 · E. Proje') + ['telafi' => $dipnot2],
            Kalip::puanDan('Verdiğiniz derslerden en az 20 puan', ['M'], 20, Kalip::SON_ATAMA_SONRASI, madde: 'EK-2 TABLO-1 · M. Öğretim') + ['telafi' => $dipnot2],
            Kalip::puanDan('Makale, bildiri, proje ve derslerden birlikte en az 75 puan', ['A', 'B', 'E', 'M'], 75, Kalip::SON_ATAMA_SONRASI, madde: 'EK-2 TABLO-1 · Asgari Puan'),
            Kalip::toplam(90, Kalip::SON_ATAMA_SONRASI),
        ]),
    ],
    [
        'anahtar' => 'gumushane-docent-egitim-spor',
        'aday_notu' => 'Puanlar faaliyet grubu bazında ayrı ayrı sınanıyor: bir gruptaki fazlalık başka gruptaki eksiği kapatmıyor. Yönergenin dipnotları bazı eksikler için ilave yayın telafisi sunuyor.',
        'universite' => 'Gümüşhane Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['egitim', 'spor'],
        'cetvel' => 'gumushane-2026',
        'notlar' => 'EK-2 TABLO-1, Doçent sütunu: "A1 kategorisinden en az 1 yayın olmak şartıyla, '
            .'A1-A3 kategorilerinden toplamda en az 70P." TABLO-3\'ten farkı burada: orada A1-A2 '
            .'yeterken burada A1 şart. · B 15P · C 20P · D 15P · E1-E7 ≥1 + E 20P · M3-M4 10P + M 20P. '
            .'Asgari 160P, toplam 250P.',
        'sart' => Kalip::ve('Doçent asgari şartları', [
            Kalip::adet('SCIE/SSCI veya AHCI dergisinde en az 1 makale', ['A1'], 1, madde: 'EK-1 · A1'),
            Kalip::puanDan('İndeksli ve TR Dizin makalelerinden en az 70 puan', ['A1-A3'], 70, madde: 'EK-1 · A1-A3'),
            Kalip::puanDan('Bildirilerden en az 15 puan', ['B'], 15, madde: 'EK-2 TABLO-1 · B. Bildiri'),
            Kalip::puanDan('Kitap ve kitap bölümlerinden en az 20 puan', ['C'], 20, madde: 'EK-2 TABLO-1 · C. Kitap'),
            Kalip::puanDan('Yayınlarınıza yapılan atıflardan en az 15 puan', ['D'], 15, madde: 'EK-2 TABLO-1 · D. Atıf'),
            Kalip::ve('Proje koşulu', [
                Kalip::adet('Desteklenmiş en az 1 araştırma projesinde görev almış olmak', ['E1-E7'], 1, madde: 'EK-1 · E1-E7'),
                Kalip::puanDan('Projelerden en az 20 puan', ['E'], 20, madde: 'EK-2 TABLO-1 · E. Proje'),
            ]) + ['telafi' => Kalip::ve('Proje koşulu sağlanmazsa: 1 indeksli + 1 TR Dizin makalesi daha', [
                Kalip::adet('İndeksli bir dergide 1 makale daha', ['A1-A2'], 1, madde: 'EK-1 · A1-A2'),
                Kalip::adet('TR Dizin dergisinde 1 makale daha', ['A3'], 1, madde: 'EK-1 · A3'),
            ])],
            Kalip::ve('Ders verme koşulu', [
                Kalip::puanDan('Lisans/önlisans derslerinden en az 10 puan', ['M3-M4'], 10, madde: 'EK-1 · M3-M4'),
                Kalip::puanDan('Verdiğiniz tüm derslerden en az 20 puan', ['M'], 20, madde: 'EK-2 TABLO-1 · M. Öğretim'),
            ]) + ['telafi' => $dipnot2],
            Kalip::puanDan('Zorunlu faaliyet gruplarından birlikte en az 160 puan', ['A', 'B', 'C', 'D', 'E', 'M'], 160, madde: 'EK-2 TABLO-1 · Asgari Puan'),
            Kalip::toplam(250),
        ]),
    ],
    [
        'anahtar' => 'gumushane-profesor-egitim-spor',
        'aday_notu' => 'Puanlar faaliyet grubu bazında ayrı ayrı sınanıyor: bir gruptaki fazlalık başka gruptaki eksiği kapatmıyor. Yönergenin dipnotları bazı eksikler için ilave yayın telafisi sunuyor.',
        'universite' => 'Gümüşhane Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['egitim', 'spor'],
        'cetvel' => 'gumushane-2026',
        'notlar' => 'EK-2 TABLO-1, Profesör sütunu: "A1 kategorisinden en az 2 yayın olmak şartıyla, '
            .'A1-A3 kategorilerinden toplamda en az 80P." · B 20P · C 20P · D 30P · E1-E7 ≥1 + E 20P '
            .'· İ1/İ2 10P · M3-M4 15P + M 30P. Asgari 210P, toplam 300P.',
        'sart' => Kalip::ve('Profesör asgari şartları', [
            Kalip::adet('SCIE/SSCI veya AHCI dergilerinde en az 2 makale', ['A1'], 2, donem: Kalip::DOCENTLIK_SONRASI, madde: 'EK-1 · A1'),
            Kalip::puanDan('İndeksli ve TR Dizin makalelerinden en az 80 puan', ['A1-A3'], 80, Kalip::DOCENTLIK_SONRASI, madde: 'EK-1 · A1-A3'),
            Kalip::puanDan('Bildirilerden en az 20 puan', ['B'], 20, Kalip::DOCENTLIK_SONRASI, madde: 'EK-2 TABLO-1 · B. Bildiri'),
            Kalip::puanDan('Kitap ve kitap bölümlerinden en az 20 puan', ['C'], 20, Kalip::DOCENTLIK_SONRASI, madde: 'EK-2 TABLO-1 · C. Kitap'),
            Kalip::puanDan('Yayınlarınıza yapılan atıflardan en az 30 puan', ['D'], 30, Kalip::DOCENTLIK_SONRASI, madde: 'EK-2 TABLO-1 · D. Atıf'),
            Kalip::ve('Proje koşulu', [
                Kalip::adet('Desteklenmiş en az 1 araştırma projesinde görev almış olmak', ['E1-E7'], 1, madde: 'EK-1 · E1-E7'),
                Kalip::puanDan('Projelerden en az 20 puan', ['E'], 20, madde: 'EK-2 TABLO-1 · E. Proje'),
            ]) + ['telafi' => Kalip::ve('Proje koşulu sağlanmazsa: 1 indeksli + 1 TR Dizin makalesi daha', [
                Kalip::adet('İndeksli bir dergide 1 makale daha', ['A1-A2'], 1, madde: 'EK-1 · A1-A2'),
                Kalip::adet('TR Dizin dergisinde 1 makale daha', ['A3'], 1, madde: 'EK-1 · A3'),
            ])],
            Kalip::puanDan('Tamamlanmış tez danışmanlıklarından en az 10 puan', ['İ1-İ2'], 10, madde: 'EK-1 · İ1-İ2')
                + ['telafi' => Kalip::adet('Tez danışmanlığınız yoksa: indeksli dergide 1 makale daha', ['A1-A2'], 1, madde: 'EK-1 · A1-A2')],
            Kalip::ve('Ders verme koşulu', [
                Kalip::puanDan('Lisans/önlisans derslerinden en az 15 puan', ['M3-M4'], 15, madde: 'EK-1 · M3-M4'),
                Kalip::puanDan('Verdiğiniz tüm derslerden en az 30 puan', ['M'], 30, madde: 'EK-2 TABLO-1 · M. Öğretim'),
            ]) + ['telafi' => $dipnot2],
            Kalip::puanDan('Zorunlu faaliyet gruplarından birlikte en az 210 puan', ['A', 'B', 'C', 'D', 'E', 'İ', 'M'], 210, Kalip::DOCENTLIK_SONRASI, madde: 'EK-2 TABLO-1 · Asgari Puan'),
            Kalip::toplam(300, Kalip::DOCENTLIK_SONRASI),
        ]),
    ],

    // ══════════ EK-2 TABLO-2 · Fen / Mimarlık / Mühendislik / Sağlık / Ziraat ══════════
    // TABLO-1 ve 3'ten farkları: KİTAP satırı YOK, atıf barajı çok daha yüksek
    // (45P/60P), makale kategorisi baştan A1 ile sınırlı ve dipnot telafileri
    // A1'e dayanıyor (A1-A2/A3 değil).

    [
        'anahtar' => 'gumushane-dr-fen',
        'aday_notu' => 'Makale koşulu doğrudan SCIE/SSCI-AHCI (A1) istiyor; TR Dizin yayınları bu şarta sayılmıyor. Puanlar faaliyet grubu bazında ayrı ayrı sınanıyor.',
        'universite' => 'Gümüşhane Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['fen', 'mimarlik', 'muhendislik', 'saglik', 'ziraat'],
        'cetvel' => 'gumushane-2026',
        'notlar' => 'EK-2 TABLO-2, İLK ATANMA: "A1 kategorisinden en az 1 yayın olmak şartıyla, '
            .'A grubundan toplamda en az 35P." · B 10P. Asgari 45P, toplam 55P.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi ilk atanma asgari şartları', [
            Kalip::adet('SCIE/SSCI veya AHCI dergisinde en az 1 makale', ['A1'], 1, madde: 'EK-1 · A1'),
            Kalip::puanDan('Makalelerden toplam en az 35 puan', ['A'], 35, madde: 'EK-2 TABLO-2 · A. Makale'),
            Kalip::puanDan('Bildirilerden en az 10 puan', ['B'], 10, madde: 'EK-2 TABLO-2 · B. Bildiri'),
            Kalip::puanDan('Makale ve bildirilerden birlikte en az 45 puan', ['A', 'B'], 45, madde: 'EK-2 TABLO-2 · Asgari Puan'),
            Kalip::toplam(55),
        ]),
    ],
    [
        'anahtar' => 'gumushane-dr-yeniden-fen',
        'aday_notu' => 'Makale koşulu doğrudan SCIE/SSCI-AHCI (A1) istiyor; TR Dizin yayınları bu şarta sayılmıyor. Puanlar faaliyet grubu bazında ayrı ayrı sınanıyor.',
        'universite' => 'Gümüşhane Üniversitesi',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => ['fen', 'mimarlik', 'muhendislik', 'saglik', 'ziraat'],
        'cetvel' => 'gumushane-2026',
        'notlar' => 'EK-2 TABLO-2, YENİDEN ATANMA: A1\'den ≥1 yayın + A grubundan 35P · B 10P · '
            .'E 15P(1) · M 20P(1). Asgari 80P, toplam 95P.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi yeniden atanma asgari şartları', [
            Kalip::adet('SCIE/SSCI veya AHCI dergisinde en az 1 makale', ['A1'], 1, donem: Kalip::SON_ATAMA_SONRASI, madde: 'EK-1 · A1'),
            Kalip::puanDan('Makalelerden toplam en az 35 puan', ['A'], 35, Kalip::SON_ATAMA_SONRASI, madde: 'EK-2 TABLO-2 · A. Makale'),
            Kalip::puanDan('Bildirilerden en az 10 puan', ['B'], 10, Kalip::SON_ATAMA_SONRASI, madde: 'EK-2 TABLO-2 · B. Bildiri'),
            Kalip::puanDan('Projelerden en az 15 puan', ['E'], 15, Kalip::SON_ATAMA_SONRASI, madde: 'EK-2 TABLO-2 · E. Proje') + ['telafi' => $t2dipnot1],
            Kalip::puanDan('Verdiğiniz derslerden en az 20 puan', ['M'], 20, Kalip::SON_ATAMA_SONRASI, madde: 'EK-2 TABLO-2 · M. Öğretim') + ['telafi' => $t2dipnot1],
            Kalip::puanDan('Makale, bildiri, proje ve derslerden birlikte en az 80 puan', ['A', 'B', 'E', 'M'], 80, Kalip::SON_ATAMA_SONRASI, madde: 'EK-2 TABLO-2 · Asgari Puan'),
            Kalip::toplam(95, Kalip::SON_ATAMA_SONRASI),
        ]),
    ],
    [
        'anahtar' => 'gumushane-docent-fen',
        'aday_notu' => 'Atıf barajı bu alanlarda belirgin biçimde yüksek (45 puan). Makale koşulu SCIE/SSCI-AHCI (A1) istiyor; TR Dizin bu şarta sayılmıyor.',
        'universite' => 'Gümüşhane Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['fen', 'mimarlik', 'muhendislik', 'saglik', 'ziraat'],
        'cetvel' => 'gumushane-2026',
        'notlar' => 'EK-2 TABLO-2, Doçent: "A1 kategorisinden en az 2 yayın olmak şartıyla, A1-A3 '
            .'kategorilerinden toplamda en az 80P." · B 15P · D 45P · E1-E7 ≥1 + E 30P(2) · '
            .'M3-M4 10P + M 20P(1). KİTAP satırı yok. Asgari 190P, toplam 250P.',
        'sart' => Kalip::ve('Doçent asgari şartları', [
            Kalip::adet('SCIE/SSCI veya AHCI dergilerinde en az 2 makale', ['A1'], 2, madde: 'EK-1 · A1'),
            Kalip::puanDan('İndeksli ve TR Dizin makalelerinden en az 80 puan', ['A1-A3'], 80, madde: 'EK-1 · A1-A3'),
            Kalip::puanDan('Bildirilerden en az 15 puan', ['B'], 15, madde: 'EK-2 TABLO-2 · B. Bildiri'),
            Kalip::puanDan('Yayınlarınıza yapılan atıflardan en az 45 puan', ['D'], 45, madde: 'EK-2 TABLO-2 · D. Atıf'),
            Kalip::ve('Proje koşulu', [
                Kalip::adet('Desteklenmiş en az 1 araştırma projesinde görev almış olmak', ['E1-E7'], 1, madde: 'EK-1 · E1-E7'),
                Kalip::puanDan('Projelerden en az 30 puan', ['E'], 30, madde: 'EK-2 TABLO-2 · E. Proje'),
            ]) + ['telafi' => $t2dipnot2],
            Kalip::ve('Ders verme koşulu', [
                Kalip::puanDan('Lisans/önlisans derslerinden en az 10 puan', ['M3-M4'], 10, madde: 'EK-1 · M3-M4'),
                Kalip::puanDan('Verdiğiniz tüm derslerden en az 20 puan', ['M'], 20, madde: 'EK-2 TABLO-2 · M. Öğretim'),
            ]) + ['telafi' => $t2dipnot1],
            Kalip::puanDan('Zorunlu faaliyet gruplarından birlikte en az 190 puan', ['A', 'B', 'D', 'E', 'M'], 190, madde: 'EK-2 TABLO-2 · Asgari Puan'),
            Kalip::toplam(250),
        ]),
    ],
    [
        'anahtar' => 'gumushane-profesor-fen',
        'aday_notu' => 'Atıf barajı bu alanlarda belirgin biçimde yüksek (60 puan). Makale koşulu SCIE/SSCI-AHCI (A1) istiyor; TR Dizin bu şarta sayılmıyor.',
        'universite' => 'Gümüşhane Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['fen', 'mimarlik', 'muhendislik', 'saglik', 'ziraat'],
        'cetvel' => 'gumushane-2026',
        'notlar' => 'EK-2 TABLO-2, Profesör: "A1 kategorisinden en az 2 yayın olmak şartıyla, A1-A3 '
            .'kategorilerinden toplamda en az 100P." · B 20P · D 60P · E1-E7 ≥1 + E 30P(2) · '
            .'İ1/İ2 15P(1) · M3-M4 15P + M 30P(1). Asgari 255P, toplam 300P.',
        'sart' => Kalip::ve('Profesör asgari şartları', [
            Kalip::adet('SCIE/SSCI veya AHCI dergilerinde en az 2 makale', ['A1'], 2, donem: Kalip::DOCENTLIK_SONRASI, madde: 'EK-1 · A1'),
            Kalip::puanDan('İndeksli ve TR Dizin makalelerinden en az 100 puan', ['A1-A3'], 100, Kalip::DOCENTLIK_SONRASI, madde: 'EK-1 · A1-A3'),
            Kalip::puanDan('Bildirilerden en az 20 puan', ['B'], 20, Kalip::DOCENTLIK_SONRASI, madde: 'EK-2 TABLO-2 · B. Bildiri'),
            Kalip::puanDan('Yayınlarınıza yapılan atıflardan en az 60 puan', ['D'], 60, Kalip::DOCENTLIK_SONRASI, madde: 'EK-2 TABLO-2 · D. Atıf'),
            Kalip::ve('Proje koşulu', [
                Kalip::adet('Desteklenmiş en az 1 araştırma projesinde görev almış olmak', ['E1-E7'], 1, madde: 'EK-1 · E1-E7'),
                Kalip::puanDan('Projelerden en az 30 puan', ['E'], 30, madde: 'EK-2 TABLO-2 · E. Proje'),
            ]) + ['telafi' => $t2dipnot2],
            Kalip::puanDan('Tamamlanmış tez danışmanlıklarından en az 15 puan', ['İ1-İ2'], 15, madde: 'EK-1 · İ1-İ2')
                + ['telafi' => $t2dipnot1],
            Kalip::ve('Ders verme koşulu', [
                Kalip::puanDan('Lisans/önlisans derslerinden en az 15 puan', ['M3-M4'], 15, madde: 'EK-1 · M3-M4'),
                Kalip::puanDan('Verdiğiniz tüm derslerden en az 30 puan', ['M'], 30, madde: 'EK-2 TABLO-2 · M. Öğretim'),
            ]) + ['telafi' => $t2dipnot1],
            Kalip::puanDan('Zorunlu faaliyet gruplarından birlikte en az 255 puan', ['A', 'B', 'D', 'E', 'İ', 'M'], 255, Kalip::DOCENTLIK_SONRASI, madde: 'EK-2 TABLO-2 · Asgari Puan'),
            Kalip::toplam(300, Kalip::DOCENTLIK_SONRASI),
        ]),
    ],

    // ══════════ EK-2 TABLO-4 · Güzel Sanatlar ══════════
    // Ayırt edici yanı P. SANATSAL ETKİNLİKLER satırı: dört kadroda da zorunlu
    // (20/20/30/50P) ve kendi dipnot telafisi var (A1-A3'ten 3 ilave yayın).

    [
        'anahtar' => 'gumushane-dr-guzel-sanatlar',
        'aday_notu' => 'Sanatsal etkinlik puanı (P grubu) bu alanda zorunlu ve ayrı sınanıyor; makale puanıyla birbirinin yerine geçmiyor. P grubundan en fazla 60 puan sayılıyor.',
        'universite' => 'Gümüşhane Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'gumushane-2026',
        'notlar' => 'EK-2 TABLO-4, İLK ATANMA: A1-A3\'ten ≥1 yayın + A grubundan 30P · B 10P · '
            .'P 20P(4). Asgari 60P, toplam 70P.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi ilk atanma asgari şartları', [
            Kalip::adet('İndeksli veya TR Dizin dergisinde en az 1 makale', ['A1-A3'], 1, madde: 'EK-1 · A1-A3'),
            Kalip::puanDan('Makalelerden toplam en az 30 puan', ['A'], 30, madde: 'EK-2 TABLO-4 · A. Makale'),
            Kalip::puanDan('Bildirilerden en az 10 puan', ['B'], 10, madde: 'EK-2 TABLO-4 · B. Bildiri'),
            Kalip::puanDan('Sanatsal etkinliklerden en az 20 puan', ['P'], 20, madde: 'EK-2 TABLO-4 · P. Sanatsal')
                + ['telafi' => $t4dipnot4],
            Kalip::puanDan('Zorunlu faaliyet gruplarından birlikte en az 60 puan', ['A', 'B', 'P'], 60, madde: 'EK-2 TABLO-4 · Asgari Puan'),
            Kalip::toplam(70),
        ]),
    ],
    [
        'anahtar' => 'gumushane-dr-yeniden-guzel-sanatlar',
        'aday_notu' => 'Sanatsal etkinlik puanı (P grubu) bu alanda zorunlu ve ayrı sınanıyor; makale puanıyla birbirinin yerine geçmiyor. P grubundan en fazla 60 puan sayılıyor.',
        'universite' => 'Gümüşhane Üniversitesi',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'gumushane-2026',
        'notlar' => 'EK-2 TABLO-4, YENİDEN ATANMA: A1-A3\'ten ≥1 yayın + A 30P · B 10P · E 15P(1) · '
            .'M 20P(1) · P 20P(4). Asgari 95P, toplam 110P.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi yeniden atanma asgari şartları', [
            Kalip::adet('İndeksli veya TR Dizin dergisinde en az 1 makale', ['A1-A3'], 1, donem: Kalip::SON_ATAMA_SONRASI, madde: 'EK-1 · A1-A3'),
            Kalip::puanDan('Makalelerden toplam en az 30 puan', ['A'], 30, Kalip::SON_ATAMA_SONRASI, madde: 'EK-2 TABLO-4 · A. Makale'),
            Kalip::puanDan('Bildirilerden en az 10 puan', ['B'], 10, Kalip::SON_ATAMA_SONRASI, madde: 'EK-2 TABLO-4 · B. Bildiri'),
            Kalip::puanDan('Projelerden en az 15 puan', ['E'], 15, Kalip::SON_ATAMA_SONRASI, madde: 'EK-2 TABLO-4 · E. Proje') + ['telafi' => $dipnot2],
            Kalip::puanDan('Verdiğiniz derslerden en az 20 puan', ['M'], 20, Kalip::SON_ATAMA_SONRASI, madde: 'EK-2 TABLO-4 · M. Öğretim') + ['telafi' => $dipnot2],
            Kalip::puanDan('Sanatsal etkinliklerden en az 20 puan', ['P'], 20, Kalip::SON_ATAMA_SONRASI, madde: 'EK-2 TABLO-4 · P. Sanatsal')
                + ['telafi' => $t4dipnot4],
            Kalip::puanDan('Zorunlu faaliyet gruplarından birlikte en az 95 puan', ['A', 'B', 'E', 'M', 'P'], 95, Kalip::SON_ATAMA_SONRASI, madde: 'EK-2 TABLO-4 · Asgari Puan'),
            Kalip::toplam(110, Kalip::SON_ATAMA_SONRASI),
        ]),
    ],
    [
        'anahtar' => 'gumushane-docent-guzel-sanatlar',
        'aday_notu' => 'Sanatsal etkinlik puanı (P grubu) bu alanda zorunlu ve ayrı sınanıyor; makale puanıyla birbirinin yerine geçmiyor. P grubundan en fazla 60 puan sayılıyor.',
        'universite' => 'Gümüşhane Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'gumushane-2026',
        'notlar' => 'EK-2 TABLO-4, Doçent: A1-A3\'ten 70P · B 15P · C 20P · D 15P · E1-E7 ≥1 + E 20P(2) '
            .'· M3-M4 10P + M 20P(1) · P 30P(4). Asgari 190P, toplam 250P. Makale satırında '
            .'kategori kısıtı YOK (TABLO-1/2/3\'ten farkı).',
        'sart' => Kalip::ve('Doçent asgari şartları', [
            Kalip::puanDan('İndeksli ve TR Dizin makalelerinden en az 70 puan', ['A1-A3'], 70, madde: 'EK-1 · A1-A3'),
            Kalip::puanDan('Bildirilerden en az 15 puan', ['B'], 15, madde: 'EK-2 TABLO-4 · B. Bildiri'),
            Kalip::puanDan('Kitap ve kitap bölümlerinden en az 20 puan', ['C'], 20, madde: 'EK-2 TABLO-4 · C. Kitap'),
            Kalip::puanDan('Yayınlarınıza yapılan atıflardan en az 15 puan', ['D'], 15, madde: 'EK-2 TABLO-4 · D. Atıf'),
            Kalip::ve('Proje koşulu', [
                Kalip::adet('Desteklenmiş en az 1 araştırma projesinde görev almış olmak', ['E1-E7'], 1, madde: 'EK-1 · E1-E7'),
                Kalip::puanDan('Projelerden en az 20 puan', ['E'], 20, madde: 'EK-2 TABLO-4 · E. Proje'),
            ]) + ['telafi' => Kalip::ve('Proje koşulu sağlanmazsa: 1 indeksli + 1 TR Dizin makalesi daha', [
                Kalip::adet('İndeksli bir dergide 1 makale daha', ['A1-A2'], 1, madde: 'EK-1 · A1-A2'),
                Kalip::adet('TR Dizin dergisinde 1 makale daha', ['A3'], 1, madde: 'EK-1 · A3'),
            ])],
            Kalip::ve('Ders verme koşulu', [
                Kalip::puanDan('Lisans/önlisans derslerinden en az 10 puan', ['M3-M4'], 10, madde: 'EK-1 · M3-M4'),
                Kalip::puanDan('Verdiğiniz tüm derslerden en az 20 puan', ['M'], 20, madde: 'EK-2 TABLO-4 · M. Öğretim'),
            ]) + ['telafi' => $dipnot2],
            Kalip::puanDan('Sanatsal etkinliklerden en az 30 puan', ['P'], 30, madde: 'EK-2 TABLO-4 · P. Sanatsal')
                + ['telafi' => $t4dipnot4],
            Kalip::puanDan('Zorunlu faaliyet gruplarından birlikte en az 190 puan', ['A', 'B', 'C', 'D', 'E', 'M', 'P'], 190, madde: 'EK-2 TABLO-4 · Asgari Puan'),
            Kalip::toplam(250),
        ]),
    ],
    [
        'anahtar' => 'gumushane-profesor-guzel-sanatlar',
        'aday_notu' => 'Sanatsal etkinlik puanı (P grubu) bu alanda zorunlu ve ayrı sınanıyor; makale puanıyla birbirinin yerine geçmiyor. P grubundan en fazla 60 puan sayılıyor.',
        'universite' => 'Gümüşhane Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'gumushane-2026',
        'notlar' => 'EK-2 TABLO-4, Profesör: A1-A3\'ten 100P · B 20P · C 20P · D 30P · E1-E7 ≥1 + E 20P(2) '
            .'· İ1/İ2 10P(3) · M3-M4 15P + M 30P(1) · P 50P. Asgari 280P, toplam 320P.',
        'sart' => Kalip::ve('Profesör asgari şartları', [
            Kalip::puanDan('İndeksli ve TR Dizin makalelerinden en az 100 puan', ['A1-A3'], 100, Kalip::DOCENTLIK_SONRASI, madde: 'EK-1 · A1-A3'),
            Kalip::puanDan('Bildirilerden en az 20 puan', ['B'], 20, Kalip::DOCENTLIK_SONRASI, madde: 'EK-2 TABLO-4 · B. Bildiri'),
            Kalip::puanDan('Kitap ve kitap bölümlerinden en az 20 puan', ['C'], 20, Kalip::DOCENTLIK_SONRASI, madde: 'EK-2 TABLO-4 · C. Kitap'),
            Kalip::puanDan('Yayınlarınıza yapılan atıflardan en az 30 puan', ['D'], 30, Kalip::DOCENTLIK_SONRASI, madde: 'EK-2 TABLO-4 · D. Atıf'),
            Kalip::ve('Proje koşulu', [
                Kalip::adet('Desteklenmiş en az 1 araştırma projesinde görev almış olmak', ['E1-E7'], 1, madde: 'EK-1 · E1-E7'),
                Kalip::puanDan('Projelerden en az 20 puan', ['E'], 20, madde: 'EK-2 TABLO-4 · E. Proje'),
            ]) + ['telafi' => Kalip::ve('Proje koşulu sağlanmazsa: 1 indeksli + 1 TR Dizin makalesi daha', [
                Kalip::adet('İndeksli bir dergide 1 makale daha', ['A1-A2'], 1, madde: 'EK-1 · A1-A2'),
                Kalip::adet('TR Dizin dergisinde 1 makale daha', ['A3'], 1, madde: 'EK-1 · A3'),
            ])],
            Kalip::puanDan('Tamamlanmış tez danışmanlıklarından en az 10 puan', ['İ1-İ2'], 10, madde: 'EK-1 · İ1-İ2')
                + ['telafi' => $t4dipnot3],
            Kalip::ve('Ders verme koşulu', [
                Kalip::puanDan('Lisans/önlisans derslerinden en az 15 puan', ['M3-M4'], 15, madde: 'EK-1 · M3-M4'),
                Kalip::puanDan('Verdiğiniz tüm derslerden en az 30 puan', ['M'], 30, madde: 'EK-2 TABLO-4 · M. Öğretim'),
            ]) + ['telafi' => $dipnot2],
            Kalip::puanDan('Sanatsal etkinliklerden en az 50 puan', ['P'], 50, madde: 'EK-2 TABLO-4 · P. Sanatsal'),
            Kalip::puanDan('Zorunlu faaliyet gruplarından birlikte en az 280 puan', ['A', 'B', 'C', 'D', 'E', 'İ', 'M', 'P'], 280, Kalip::DOCENTLIK_SONRASI, madde: 'EK-2 TABLO-4 · Asgari Puan'),
            Kalip::toplam(320, Kalip::DOCENTLIK_SONRASI),
        ]),
    ],
];
