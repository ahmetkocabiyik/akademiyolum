<?php

/**
 * İSTANBUL MEDİPOL ÜNİVERSİTESİ — Akademik Yükseltme ve Atama Yönergesi
 * Kaynak: pdf/17537099992.istanbulmedipoluniversitesi.pdf
 *
 * KORPUSTAKİ EN KISA YÖNERGE (97 satır). Kendi puan tablosu yok, kendi sayı
 * eşiği de yok: doçentlik ve profesörlük tümüyle ÜAK doçentlik koşullarına
 * devrediliyor, Dr. Öğr. Üyeliğinde ise tek bir makale şartı var.
 *
 * Cetvel olarak ÜAK doçentlik tablosu (`uak-2024-mart-{alan}`) kullanıldı.
 *
 * DR. ÖĞR. ÜYELİĞİ ŞARTI İKİ ALTERNATİFLİ (Madde 6/1-c):
 *   Web of Science veya Scopus dergisinde bir araştırma makalesi
 *   YA DA TR Dizin dergisinde tez dışı bir konuda İLK İSİM makale
 * Yönerge birinci seçenekte "tercihen birinci veya ilk üç sırada yer alınan"
 * diyor; "tercihen" bağlayıcı olmadığı için yazarlık sırası koşula girmedi.
 * İkinci seçenekteki "ilk isim" ise bağlayıcı, o yüzden `ilk` rolüyle girildi.
 *
 * PROFESÖRLÜKTE ÜAK KOŞULLARININ TEKRARI (Madde 8/1-c): "atanacağı tarih
 * itibariyle kendi alanında, doçent olduğu tarih itibariyle doçentlik
 * şartlarını yeniden sağlamış olmak". Hangi dönemin ÜAK şartlarının geçerli
 * olduğu adayın doçentlik tarihine bağlı olduğu için güncel ÜAK toplamı (100)
 * doçentlik sonrası dönemde isteniyor.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: uak-2024-mart-{alan}
 */

use App\Services\Scoring\Sart\Kalip;

$DOC = Kalip::DOCENTLIK_SONRASI;

$tumAlanlar = ['fen', 'muhendislik', 'mimarlik', 'saglik', 'spor', 'hukuk', 'ilahiyat',
    'filoloji', 'sosyal', 'egitim', 'guzel_sanatlar', 'ziraat'];

return [
    // ══════════ DR. ÖĞRETİM ÜYESİ (Madde 6) ══════════
    [
        'anahtar' => 'medipol-dr',
        'aday_notu' => 'İstanbul Medipol PUAN İSTEMİYOR; Dr. Öğr. Üyeliğinde tek bir makale '
            .'şartı var ve iki alternatifi bulunuyor. Yönerge birinci seçenekte "tercihen '
            .'birinci veya ilk üç sırada yer alınan" diyor; "tercihen" bağlayıcı olmadığı için '
            .'burada yazarlık sırası aranmıyor. İkinci seçenekte ise ilk isim olmanız şart.',
        'universite' => 'İstanbul Medipol Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $tumAlanlar,
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 6/1-c: Web of Science veya Scopus dergisinde bir araştırma makalesi '
            .'ya da TR Dizin dergisinde tez dışı bir konuda ilk isim araştırma makalesi.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — İstanbul Medipol Üniversitesi', [
            Kalip::veya('Makale koşulu', [
                Kalip::adet('Web of Science veya Scopus dergilerinde en az 1 araştırma makalesi',
                    ['1a-*', '1b', '1c'], 1, madde: 'Madde 6/1-c'),
                Kalip::adet('TR Dizin dergilerinde tez dışı bir konuda ilk isim olduğunuz en az '
                    .'1 araştırma makalesi', ['2a'], 1, 'ilk', madde: 'Madde 6/1-c'),
            ]),
            Kalip::beyan('Doktora, tıpta veya diş hekimliğinde uzmanlık ya da sanatta yeterlik '
                .'unvanını almış olmak', 'Madde 6/1-b'),
        ]),
    ],

    // ══════════ DOÇENT (Madde 7 — tümüyle ÜAK'a devrediliyor) ══════════
    [
        'anahtar' => 'medipol-docent',
        'aday_notu' => 'İstanbul Medipol doçentlikte kendi koşulunu koymuyor; yönerge doğrudan '
            .'YÖK doçentlik başvuru koşullarına gönderiyor. Aşağıdaki puan ÜAK doçentlik '
            .'cetveline göre hesaplanıyor.',
        'universite' => 'İstanbul Medipol Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $tumAlanlar,
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 7/1-b-c: doçentlik unvanını almış olmak ve YÖK\'ün doçentlik '
            .'başvuruları için uyguladığı asgari koşulları sağlamış olmak.',
        'sart' => Kalip::ve('Doçent — İstanbul Medipol Üniversitesi', [
            Kalip::toplam(100),
            Kalip::beyan('Doçentlik unvanını almış olmak; yurt dışında doçentliğe denk bir '
                .'görevde bulunanların Üniversitelerarası Kurulca denkliğinin kabul edilmiş '
                .'olması', 'Madde 7/1-b'),
        ]),
    ],

    // ══════════ PROFESÖR (Madde 8) ══════════
    [
        'anahtar' => 'medipol-profesor',
        'aday_notu' => 'Doçentliğinizi aldığınız tarihteki ÜAK doçentlik şartlarını, doçentlik '
            .'sonrası çalışmalarınızla bir kez daha sağlamanız isteniyor. Hangi dönemin '
            .'şartlarının geçerli olduğu doçentlik tarihinize bağlı olduğu için burada güncel '
            .'ÜAK toplamı gösteriliyor.',
        'universite' => 'İstanbul Medipol Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $tumAlanlar,
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 8/1-b-c: en az 2 yıl profesörlük kadrosunda ya da doçentlik sonrası '
            .'en az 5 yıl ilgili alanda çalışmış olmak; doçentlik şartlarını yeniden sağlamak.',
        'sart' => Kalip::ve('Profesör — İstanbul Medipol Üniversitesi', [
            Kalip::toplam(100, $DOC),
            Kalip::beyan('Doçentlik unvanını aldıktan sonra en az beş yıl açık bulunan '
                .'profesörlük kadrosuyla ilgili bilim veya sanat alanında çalışmış olmak ya da '
                .'en az iki yıl profesörlük kadrosunda görev yapmış olmak', 'Madde 8/1-b'),
        ]),
    ],
];
