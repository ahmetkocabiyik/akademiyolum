<?php

/**
 * BANDIRMA ONYEDİ EYLÜL ÜNİVERSİTESİ — Öğretim Üyeliğine Atanma ve Yükseltme
 * Yönergesi (Madde 7-9)
 * Kaynak: pdf/17536931052.bandirmaonyedieyluluniverstesi.pdf
 *
 * İKİ ALAN GRUBU, ÜÇ KADRO. Puan barajları iki grupta AYNI (Dr. yeniden atama
 * 100, doçent 200, profesör 300) ama ALT BARAJ FARKLI KÜMEDEN sayılıyor:
 *   Sağlık, Mühendislik, Fen        yalnızca A1-A13 (uluslararası yayınlar)
 *   Sosyal, Spor, Mimarlık, Tasarım A1-A14 + B1-B6 + B8c + C1-C7
 * Fen grubunda TR Dizin makalesi ya da ulusal kitap alt baraja hiç sayılmıyor;
 * sosyal grupta projeler ve patentler de sayılıyor.
 *
 * DR. ÖĞR. ÜYESİ İLK ATAMADA PUAN BARAJI YOK (Madde 7/1-b-1, c-1): yönerge
 * yalnızca makale SAYISI istiyor. Puan barajı yeniden atamada devreye giriyor.
 *
 * PROJE ŞARTI VE TELAFİSİ HER KADRODA VAR: aday en az 1 dış kaynaklı projede
 * görev almış ya da patent/faydalı model/marka başvurusu yapmış olmalı; bunu
 * sağlayamayan aday istenen makale sayısına 1 ekleyerek şartı sağlıyor. Bu
 * `veya` yapısıyla girildi — korpusta telafinin bu kadar açık yazıldığı ender
 * yönergelerden biri.
 *
 * YENİDEN ATANMA GİRİLMEDİ: koşul "her atama döneminde" biçiminde; atanma
 * dönemi uzunluğu profilde tutulmuyor. Dr. Öğr. Üyeliğinde bu, ilk atamada
 * puan barajı görünmemesi anlamına geliyor — yönergenin kendi tercihi.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/bandirma-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

$DOC = Kalip::DOCENTLIK_SONRASI;

$fenGrubu = ['saglik', 'muhendislik', 'fen', 'ziraat'];
$sosyalGrubu = ['sosyal', 'egitim', 'hukuk', 'ilahiyat', 'filoloji', 'spor', 'mimarlik',
    'guzel_sanatlar'];

$fenKume = 'A1-A13';
$sosyalKume = 'A1-A14 B1-B6 B8c C1-C7';
$fenKumeAd = 'Uluslararası yayın ve etkinlik kalemlerinizden';
$sosyalKumeAd = 'Yayın, bildiri, kitap, proje ve patent kalemlerinizden';

$projeNotu = 'Proje şartının telafisi var: en az 1 dış kaynaklı projede görev almadıysanız ya '
    .'da patent/faydalı model/marka başvurusu yapmadıysanız, istenen makale sayısına 1 makale '
    .'ekleyerek şartı sağlamış sayılıyorsunuz.';

$yenidenAtamaNotu = 'Yeniden atanmada her atama döneminde alt kümeden 50, toplamda 100 puan ve '
    .'proje şartı isteniyor. Atanma dönemi uzunluğu burada tutulmadığı için yeniden atanma '
    .'eşiği girilmedi.';

/**
 * Proje şartı ve makale sayısı telafisi: proje varsa N makale, yoksa N+1.
 *
 * @param  list<string>  $maddeler
 * @return array<string, mixed>
 */
$projeliMakale = function (string $aciklama, array $maddeler, int $sayi, string $madde,
    ?array $donem = null): array {
    $maddeler = array_values($maddeler);

    return Kalip::veya("{$aciklama} ve dış kaynaklı proje şartı", [
        Kalip::ve('Proje veya patent şartını sağlayarak', [
            Kalip::adet($aciklama, $maddeler, $sayi, donem: $donem, madde: $madde),
            Kalip::adet('En az 1 ulusal veya uluslararası dış kaynaklı projede görev almak ya da '
                .'patent, faydalı model veya marka başvurusunda bulunmak',
                ['PROJE_PATENT'], 1, madde: $madde),
        ]),
        Kalip::adet("{$aciklama} — proje şartını sağlamayanlar için bir fazlası",
            $maddeler, $sayi + 1, donem: $donem, madde: $madde),
    ]);
};

return [
    // ══════════ DR. ÖĞRETİM ÜYESİ (ilk atama, Madde 7) ══════════
    [
        'anahtar' => 'bandirma-dr-fen',
        'aday_notu' => 'Bandırma ilk atamada PUAN BARAJI KOYMUYOR; yalnızca makale sayısı '
            .'arıyor. Puan barajı yeniden atamada devreye giriyor. '.$yenidenAtamaNotu,
        'universite' => 'Bandırma Onyedi Eylül Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $fenGrubu,
        'cetvel' => 'bandirma-2024',
        'notlar' => 'Madde 7/1-b-1: en az biri SCI/SCIE/SSCI/AHCI/ESCI dergide olmak üzere '
            .'uluslararası alan indeksli dergilerde en az 2 makale.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Sağlık, Mühendislik ve Fen Bilimleri', [
            Kalip::adet('Uluslararası alan indeksli dergilerde en az 2 makale',
                ['A3.a', 'A4.a', 'A8.b'], 2, madde: 'Madde 7/1-b-1'),
            Kalip::adet('Bu makalelerden en az 1\'i SCI, SCIE, SSCI, AHCI veya ESCI dergide',
                ['SCI_ESCI_MAKALE'], 1, madde: 'Madde 7/1-b-1'),
            Kalip::beyan('Doktora, sanatta yeterlik veya tıpta uzmanlık unvanının alınmış olması',
                'Madde 7/1-a'),
        ]),
    ],
    [
        'anahtar' => 'bandirma-dr-sosyal',
        'aday_notu' => 'Bandırma ilk atamada PUAN BARAJI KOYMUYOR; yalnızca makale ya da kitap '
            .'sayısı arıyor. Puan barajı yeniden atamada devreye giriyor. '.$yenidenAtamaNotu,
        'universite' => 'Bandırma Onyedi Eylül Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $sosyalGrubu,
        'cetvel' => 'bandirma-2024',
        'notlar' => 'Madde 7/1-c-1: indeksli veya ulusal hakemli dergilerde en az 2 özgün '
            .'araştırma makalesi ya da ulusal/uluslararası bilimsel kitap veya kitap bölümü.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Sosyal, Spor, Mimarlık ve Tasarım Bilimleri', [
            Kalip::adet('İndeksli ya da ulusal hakemli dergilerde en az 2 özgün araştırma '
                .'makalesi veya bilimsel kitap ya da kitap bölümü',
                ['ULUSAL_MAKALE_KITAP'], 2, madde: 'Madde 7/1-c-1'),
            Kalip::beyan('Doktora, sanatta yeterlik veya tıpta uzmanlık unvanının alınmış olması',
                'Madde 7/1-a'),
        ]),
    ],

    // ══════════ DOÇENT (Madde 8) ══════════
    [
        'anahtar' => 'bandirma-docent-fen',
        'aday_notu' => 'Alt baraj YALNIZCA uluslararası yayın kalemlerinden sayılıyor; TR Dizin '
            .'makaleleriniz ve ulusal kitaplarınız yalnızca genel toplama giriyor. '.$projeNotu,
        'universite' => 'Bandırma Onyedi Eylül Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $fenGrubu,
        'cetvel' => 'bandirma-2024',
        'notlar' => 'Madde 8/1-b: SCI/SCIE/SSCI/AHCI/ESCI dergilerde en az 3 makale; '
            .'A1-A13\'ten en az 100, tüm maddelerden toplam 200 puan.',
        'sart' => Kalip::ve('Doçent — Sağlık, Mühendislik ve Fen Bilimleri', [
            Kalip::toplam(200),
            Kalip::puanDan("{$fenKumeAd} en az 100 puan", [$fenKume], 100, madde: 'Madde 8/1-b-3'),
            $projeliMakale('SCI, SCIE, SSCI, AHCI veya ESCI dergilerde en az 3 makale',
                ['SCI_ESCI_MAKALE'], 3, 'Madde 8/1-b'),
            Kalip::beyan('Doçent unvanının alınmış olması', 'Madde 8/1-a'),
        ]),
    ],
    [
        'anahtar' => 'bandirma-docent-sosyal',
        'aday_notu' => 'Yayın şartının iki alternatifi var: indeksli dergilerde 2 makale ya da '
            .'kitap, veya en az 5 yıldır yayımlanan alan indeksli dergilerde 4 makale ya da '
            .'kitap. '.$projeNotu,
        'universite' => 'Bandırma Onyedi Eylül Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $sosyalGrubu,
        'cetvel' => 'bandirma-2024',
        'notlar' => 'Madde 8/1-c: indeksli dergilerde 2 makale/kitap ya da alan indeksli '
            .'dergilerde 4 makale/kitap; A1-A14, B1-B6, B8c ve C1-C7\'den en az 100, tüm '
            .'maddelerden toplam 200 puan.',
        'sart' => Kalip::ve('Doçent — Sosyal, Spor, Mimarlık ve Tasarım Bilimleri', [
            Kalip::toplam(200),
            Kalip::puanDan("{$sosyalKumeAd} en az 100 puan", [$sosyalKume], 100, madde: 'Madde 8/1-c-3'),
            Kalip::veya('Yayın ve proje şartı', [
                $projeliMakale('SCI, SCIE, SSCI, AHCI, ESCI veya Scopus dergilerde ya da '
                    .'uluslararası kitap olarak en az 2 eser', ['SCI_ESCI_KITAP'], 2, 'Madde 8/1-c'),
                $projeliMakale('Uluslararası alan indeksli dergilerde en az 4 makale ya da kitap',
                    ['ALAN_INDEKS', 'A1', 'A2'], 4, 'Madde 8/1-c'),
            ]),
            Kalip::beyan('Doçent unvanının alınmış olması', 'Madde 8/1-a'),
        ]),
    ],

    // ══════════ PROFESÖR (Madde 9) ══════════
    [
        'anahtar' => 'bandirma-profesor-fen',
        'aday_notu' => 'Beş makalenin en az biri doçentliğinizden SONRA olmalı. Alt baraj '
            .'yalnızca uluslararası yayın kalemlerinden sayılıyor. '.$projeNotu,
        'universite' => 'Bandırma Onyedi Eylül Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $fenGrubu,
        'cetvel' => 'bandirma-2024',
        'notlar' => 'Madde 9/1-c: en az biri doçentlik sonrası olmak üzere SCI/SCIE/SSCI/AHCI '
            .'dergilerde en az 5 makale; A1-A13\'ten en az 150, tüm maddelerden toplam 300 puan.',
        'sart' => Kalip::ve('Profesör — Sağlık, Mühendislik ve Fen Bilimleri', [
            Kalip::toplam(300),
            Kalip::puanDan("{$fenKumeAd} en az 150 puan", [$fenKume], 150, madde: 'Madde 9/1-c-3'),
            $projeliMakale('SCI, SCIE, SSCI veya AHCI dergilerde en az 5 makale',
                ['SCI_MAKALE'], 5, 'Madde 9/1-c'),
            Kalip::adet('Bu makalelerden en az 1\'i doçentlik unvanınızı aldıktan sonra',
                ['SCI_MAKALE'], 1, donem: $DOC, madde: 'Madde 9/1-c-1'),
            Kalip::beyan('Doçent unvanı alındıktan sonra kadroyla ilgili bilim alanında en az '
                .'5 yıl çalışmış olmak ve doçentlik sonrası yayınlarından birini başlıca '
                .'araştırma eseri olarak göstermek', 'Madde 9/1-a-b'),
        ]),
    ],
    [
        'anahtar' => 'bandirma-profesor-sosyal',
        'aday_notu' => 'Yayın şartının iki alternatifi var ve her ikisinde de eserlerden en az '
            .'biri doçentliğinizden SONRA olmalı. '.$projeNotu,
        'universite' => 'Bandırma Onyedi Eylül Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $sosyalGrubu,
        'cetvel' => 'bandirma-2024',
        'notlar' => 'Madde 9/1-ç: indeksli dergilerde 3 makale/kitap ya da alan indeksli '
            .'dergilerde 6 makale/kitap; A1-A14, B1-B6, B8c ve C1-C7\'den en az 150, tüm '
            .'maddelerden toplam 300 puan.',
        'sart' => Kalip::ve('Profesör — Sosyal, Spor, Mimarlık ve Tasarım Bilimleri', [
            Kalip::toplam(300),
            Kalip::puanDan("{$sosyalKumeAd} en az 150 puan", [$sosyalKume], 150, madde: 'Madde 9/1-ç-3'),
            Kalip::veya('Yayın ve proje şartı', [
                $projeliMakale('SCI, SCIE, SSCI, AHCI, ESCI veya Scopus dergilerde ya da '
                    .'uluslararası kitap olarak en az 3 eser', ['SCI_ESCI_KITAP'], 3, 'Madde 9/1-ç'),
                $projeliMakale('Uluslararası alan indeksli dergilerde en az 6 makale ya da kitap',
                    ['ALAN_INDEKS', 'A1', 'A2'], 6, 'Madde 9/1-ç'),
            ]),
            Kalip::adet('Bu eserlerden en az 1\'i doçentlik unvanınızı aldıktan sonra',
                ['SCI_ESCI_KITAP', 'ALAN_INDEKS'], 1, donem: $DOC, madde: 'Madde 9/1-ç-1'),
            Kalip::beyan('Doçent unvanı alındıktan sonra kadroyla ilgili bilim alanında en az '
                .'5 yıl çalışmış olmak ve doçentlik sonrası yayınlarından birini başlıca '
                .'araştırma eseri olarak göstermek', 'Madde 9/1-a-b'),
        ]),
    ],
];
