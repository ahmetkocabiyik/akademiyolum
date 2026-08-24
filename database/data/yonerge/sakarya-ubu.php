<?php

/**
 * SAKARYA UYGULAMALI BİLİMLER ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve
 * Atanma Ölçütleri
 * Kaynak: pdf/17537007382.sakaryauygulamalibilimleruniverstesi.pdf
 *
 * Sakarya Üniversitesi'nden AYRI bir üniversite; yönergesi de bağımsız.
 *
 * KOŞULLAR PUAN DEĞİL ADET İSTİYOR ve ALTERNATİFLİ. Korpustaki çoğu yönerge
 * "şu kalemlerden en az N puan" derken bu yönerge her kadro ve alan grubu için
 * beş-altı seçenek sıralayıp "aşağıdaki faaliyetlerden BİRİNİ gerçekleştirmek"
 * diyor. Bu yüzden şart ağacı `veya` dallarından oluşuyor; hiçbir kadroda
 * toplam puan barajı yok.
 *
 * İKİ ALAN GRUBU:
 *   Mühendislik, Fen Bilimleri, Sağlık Bilimleri
 *   Sosyal, Spor, Beşeri ve Eğitim Bilimleri
 *
 * Sosyal grubun seçenekleri aynı yapıda ama eşik kümesi bir kademe geniş:
 * mühendislik grubunda "1.1 faaliyetinden" denen yerde sosyalde "1.1, 1.2
 * faaliyetlerinden" ya da "1.3 kapsamında" deniyor.
 *
 * DÖNEM: doçentlikte doçentlik unvanını almaya hak kazanılan döneme EK olarak,
 * profesörlükte doçentlik unvanı alındıktan sonra. Dr. Öğr. Üyeliğinde dönem
 * kaydı yok.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/sakarya-ubu-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

$D = Kalip::DOKTORA_SONRASI;
$P = Kalip::DOCENTLIK_SONRASI;

/** Mühendislik, Fen ve Sağlık Bilimleri alanları. */
$fenGrubu = ['muhendislik', 'fen', 'saglik', 'ziraat'];

/** Sosyal, Spor, Beşeri ve Eğitim Bilimleri alanları. */
$sosyalGrubu = ['sosyal', 'spor', 'egitim', 'filoloji', 'hukuk', 'ilahiyat', 'mimarlik', 'guzel_sanatlar'];

/**
 * Yönergenin her kadroda tekrarlayan "şu faaliyetlerden birini gerçekleştirmek"
 * yapısı: proje ve patent seçenekleri bütün kadrolarda aynı.
 *
 * @param  array<string, mixed>|null  $donem
 * @return list<array<string, mixed>>
 */
$projeVePatent = function (?array $donem, string $projeRolu, string $madde): array {
    return [
        Kalip::adet('Kitap veya kitap bölümü çalışmalarınızdan en az biri',
            ['3.1-3.4'], 1, donem: $donem, madde: $madde),
        Kalip::adet("Kabul edilmiş bir araştırma projesinde {$projeRolu} olarak görev almak",
            ['4.1-4.4'], 1, donem: $donem, madde: $madde),
        Kalip::adet('En az bir patent sahibi olmak', ['PATENT'], 1, donem: $donem, madde: $madde),
    ];
};

return [
    // ══════════ DR. ÖĞRETİM ÜYESİ ══════════
    [
        'anahtar' => 'sakarya-ubu-dr-fen',
        'aday_notu' => 'Yönerge altı seçenek sunuyor; birini sağlamanız yeterli. Aşağıdaki dalların '
            .'herhangi biri yeşilse koşul sağlanmış demektir.',
        'universite' => 'Sakarya Uygulamalı Bilimler Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $fenGrubu,
        'cetvel' => 'sakarya-ubu-2024',
        'notlar' => 'MADDE 7/1-c: Mühendislik, Fen ve Sağlık Bilimleri — altı seçenekten biri.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Mühendislik, Fen ve Sağlık Bilimleri', [
            Kalip::beyan('Doktora, tıpta uzmanlık veya sanatta yeterlik unvanına sahip olmak', 'MADDE 7/1-b'),
            Kalip::veya('Aşağıdaki seçeneklerden birini sağlamak', [
                Kalip::adet('SCI, SSCI, SCI-Expanded veya AHCI dergilerinde en az 2 yayın', ['1.1'], 2, madde: 'MADDE 7/1-c.i'),
                Kalip::ve('Bir WoS yayını ve iki ESCI yayını', [
                    Kalip::adet('SCI, SSCI, SCI-Expanded veya AHCI dergilerinde en az 1 yayın', ['1.1'], 1),
                    Kalip::adet('ESCI dergilerinde en az 2 yayın', ['1.2'], 2),
                ]),
                Kalip::ve('Bir WoS yayını ve üç alan endeksli/TR Dizin yayını', [
                    Kalip::adet('SCI, SSCI, SCI-Expanded veya AHCI dergilerinde en az 1 yayın', ['1.1'], 1),
                    Kalip::adet('Uluslararası alan endeksli veya TR Dizin dergilerinde en az 3 yayın', ['1.3'], 3),
                ]),
                ...array_map(
                    fn (array $ek) => Kalip::ve('Bir WoS yayını ve ek bir faaliyet', [
                        Kalip::adet('SCI, SSCI, SCI-Expanded veya AHCI dergilerinde en az 1 yayın', ['1.1'], 1),
                        $ek,
                    ]),
                    $projeVePatent(null, 'yürütücü veya araştırmacı', 'MADDE 7/1-c'),
                ),
            ]),
        ]),
    ],
    [
        'anahtar' => 'sakarya-ubu-dr-sosyal',
        'aday_notu' => 'Yönerge altı seçenek sunuyor; birini sağlamanız yeterli.',
        'universite' => 'Sakarya Uygulamalı Bilimler Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $sosyalGrubu,
        'cetvel' => 'sakarya-ubu-2024',
        'notlar' => 'MADDE 7/1: Sosyal, Spor, Beşeri ve Eğitim Bilimleri — altı seçenekten biri.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Sosyal, Spor, Beşeri ve Eğitim Bilimleri', [
            Kalip::beyan('Doktora, tıpta uzmanlık veya sanatta yeterlik unvanına sahip olmak', 'MADDE 7/1-b'),
            Kalip::veya('Aşağıdaki seçeneklerden birini sağlamak', [
                Kalip::adet('SCI, SSCI, SCI-Expanded veya AHCI dergilerinde en az 1 yayın', ['1.1'], 1, madde: 'MADDE 7/1.i'),
                Kalip::adet('ESCI dergilerinde en az 2 yayın', ['1.2'], 2, madde: 'MADDE 7/1.ii'),
                Kalip::ve('Bir ESCI yayını ve iki alan endeksli/TR Dizin yayını', [
                    Kalip::adet('ESCI dergilerinde en az 1 yayın', ['1.2'], 1),
                    Kalip::adet('Uluslararası alan endeksli veya TR Dizin dergilerinde en az 2 yayın', ['1.3'], 2),
                ]),
                ...array_map(
                    fn (array $ek) => Kalip::ve('Bir alan endeksli/TR Dizin yayını ve ek bir faaliyet', [
                        Kalip::adet('Uluslararası alan endeksli veya TR Dizin dergilerinde en az 1 yayın', ['1.3'], 1),
                        $ek,
                    ]),
                    $projeVePatent(null, 'yürütücü veya araştırmacı', 'MADDE 7/1'),
                ),
            ]),
        ]),
    ],

    // ══════════ DOÇENT ══════════
    [
        'anahtar' => 'sakarya-ubu-docent-fen',
        'aday_notu' => 'Bu koşullar doçentlik unvanını almaya hak kazandığınız dönemin asgari '
            .'şartlarına EK olarak aranıyor.',
        'universite' => 'Sakarya Uygulamalı Bilimler Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $fenGrubu,
        'cetvel' => 'sakarya-ubu-2024',
        'notlar' => 'MADDE 6/1-ç: Mühendislik, Fen ve Sağlık Bilimleri — beş seçenekten biri.',
        'sart' => Kalip::ve('Doçent — Mühendislik, Fen ve Sağlık Bilimleri', [
            Kalip::beyan('Doçentlik unvanını almış olmak', 'MADDE 6/1-b'),
            Kalip::veya('Aşağıdaki seçeneklerden birini sağlamak', [
                Kalip::adet('SCI, SSCI, SCI-Expanded veya AHCI dergilerinde en az 1 yayın', ['1.1'], 1, donem: $D, madde: 'MADDE 6/1-ç.i'),
                Kalip::adet('ESCI dergilerinde en az 2 yayın', ['1.2'], 2, donem: $D, madde: 'MADDE 6/1-ç.ii'),
                Kalip::ve('Bir ESCI yayını ve iki alan endeksli/TR Dizin yayını', [
                    Kalip::adet('ESCI dergilerinde en az 1 yayın', ['1.2'], 1, donem: $D),
                    Kalip::adet('Uluslararası alan endeksli veya TR Dizin dergilerinde en az 2 yayın', ['1.3'], 2, donem: $D),
                ]),
                ...array_map(
                    fn (array $ek) => Kalip::ve('Bir ESCI yayını ve ek bir faaliyet', [
                        Kalip::adet('ESCI dergilerinde en az 1 yayın', ['1.2'], 1, donem: $D),
                        $ek,
                    ]),
                    $projeVePatent($D, 'araştırmacı', 'MADDE 6/1-ç'),
                ),
            ]),
        ]),
    ],
    [
        'anahtar' => 'sakarya-ubu-docent-sosyal',
        'aday_notu' => 'Bu koşullar doçentlik unvanını almaya hak kazandığınız dönemin asgari '
            .'şartlarına EK olarak aranıyor.',
        'universite' => 'Sakarya Uygulamalı Bilimler Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $sosyalGrubu,
        'cetvel' => 'sakarya-ubu-2024',
        'notlar' => 'MADDE 6/1-ç: Sosyal, Spor, Beşeri ve Eğitim Bilimleri — altı seçenekten biri.',
        'sart' => Kalip::ve('Doçent — Sosyal, Spor, Beşeri ve Eğitim Bilimleri', [
            Kalip::beyan('Doçentlik unvanını almış olmak', 'MADDE 6/1-b'),
            Kalip::veya('Aşağıdaki seçeneklerden birini sağlamak', [
                Kalip::adet('SCI, SSCI, SCI-Expanded veya AHCI dergilerinde en az 1 yayın', ['1.1'], 1, donem: $D, madde: 'MADDE 6/1-ç.i'),
                Kalip::adet('ESCI dergilerinde en az 2 yayın', ['1.2'], 2, donem: $D, madde: 'MADDE 6/1-ç.ii'),
                Kalip::ve('Bir ESCI yayını ve iki alan endeksli/TR Dizin yayını', [
                    Kalip::adet('ESCI dergilerinde en az 1 yayın', ['1.2'], 1, donem: $D),
                    Kalip::adet('Uluslararası alan endeksli veya TR Dizin dergilerinde en az 2 yayın', ['1.3'], 2, donem: $D),
                ]),
                ...array_map(
                    fn (array $ek) => Kalip::ve('Bir ESCI yayını ve ek bir faaliyet', [
                        Kalip::adet('ESCI dergilerinde en az 1 yayın', ['1.2'], 1, donem: $D),
                        $ek,
                    ]),
                    $projeVePatent($D, 'araştırmacı', 'MADDE 6/1-ç'),
                ),
                Kalip::adet('Kabul edilmiş araştırma projelerinden en az birinde görev almak',
                    ['4.1-4.4'], 1, donem: $D, madde: 'MADDE 6/1-ç.vi'),
            ]),
        ]),
    ],

    // ══════════ PROFESÖR ══════════
    [
        'anahtar' => 'sakarya-ubu-profesor-fen',
        'aday_notu' => 'Bütün koşullar doçent unvanınızı aldıktan sonraki çalışmalarınızla sağlanmalı. '
            .'Yayınlarınızın en az birinde başlıca yazar olmanız gerekiyor.',
        'universite' => 'Sakarya Uygulamalı Bilimler Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $fenGrubu,
        'cetvel' => 'sakarya-ubu-2024',
        'notlar' => 'MADDE 5/1-d: Mühendislik, Fen ve Sağlık Bilimleri — beş seçenekten biri.',
        'sart' => Kalip::ve('Profesör — Mühendislik, Fen ve Sağlık Bilimleri', [
            Kalip::beyan('Doçent unvanını aldıktan sonra en az beş yıl ilgili bilim alanında '
                .'çalışmış olmak', 'MADDE 5/1-b'),
            Kalip::adet('SCI, SSCI, SCI-Expanded veya AHCI dergilerinde başlıca yazar olduğunuz en az 1 yayın',
                ['1.1'], 1, 'baslica', $P, madde: 'MADDE 5/1-d'),
            Kalip::veya('Aşağıdaki seçeneklerden birini sağlamak', [
                Kalip::adet('SCI, SSCI, SCI-Expanded veya AHCI dergilerinde en az 4 yayın', ['1.1'], 4, donem: $P, madde: 'MADDE 5/1-d.i'),
                Kalip::ve('İki WoS yayını ve dört ESCI/alan endeksli yayın', [
                    Kalip::adet('SCI, SSCI, SCI-Expanded veya AHCI dergilerinde en az 2 yayın', ['1.1'], 2, donem: $P),
                    Kalip::adet('ESCI, uluslararası alan endeksli veya TR Dizin dergilerinde en az 4 yayın', ['1.2', '1.3'], 4, donem: $P),
                ]),
                ...array_map(
                    fn (array $ek) => Kalip::ve('İki WoS yayını ve ek bir faaliyet', [
                        Kalip::adet('SCI, SSCI, SCI-Expanded veya AHCI dergilerinde en az 2 yayın', ['1.1'], 2, donem: $P),
                        $ek,
                    ]),
                    $projeVePatent($P, 'yürütücü', 'MADDE 5/1-d'),
                ),
            ]),
        ]),
    ],
    [
        'anahtar' => 'sakarya-ubu-profesor-sosyal',
        'aday_notu' => 'Bütün koşullar doçent unvanınızı aldıktan sonraki çalışmalarınızla sağlanmalı. '
            .'Yayınlarınızın en az birinde başlıca yazar olmanız gerekiyor.',
        'universite' => 'Sakarya Uygulamalı Bilimler Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $sosyalGrubu,
        'cetvel' => 'sakarya-ubu-2024',
        'notlar' => 'MADDE 5/1-d: Sosyal, Spor, Beşeri ve Eğitim Bilimleri — dört seçenekten biri.',
        'sart' => Kalip::ve('Profesör — Sosyal, Spor, Beşeri ve Eğitim Bilimleri', [
            Kalip::beyan('Doçent unvanını aldıktan sonra en az beş yıl ilgili bilim alanında '
                .'çalışmış olmak', 'MADDE 5/1-b'),
            Kalip::adet('WoS veya ESCI dergilerinde başlıca yazar olduğunuz en az 1 yayın',
                ['1.1-1.2'], 1, 'baslica', $P, madde: 'MADDE 5/1-d'),
            Kalip::veya('Aşağıdaki seçeneklerden birini sağlamak', [
                Kalip::adet('WoS veya ESCI dergilerinde en az 4 yayın', ['1.1-1.2'], 4, donem: $P, madde: 'MADDE 5/1-d.i'),
                Kalip::ve('Bir WoS/ESCI yayını ve altı alan endeksli/TR Dizin yayını', [
                    Kalip::adet('WoS veya ESCI dergilerinde en az 1 yayın', ['1.1-1.2'], 1, donem: $P),
                    Kalip::adet('Uluslararası alan endeksli veya TR Dizin dergilerinde en az 6 yayın', ['1.3'], 6, donem: $P),
                ]),
                ...array_map(
                    fn (array $ek) => Kalip::ve('İki WoS/ESCI yayını ve ek bir faaliyet', [
                        Kalip::adet('WoS veya ESCI dergilerinde en az 2 yayın', ['1.1-1.2'], 2, donem: $P),
                        $ek,
                    ]),
                    $projeVePatent($P, 'yürütücü', 'MADDE 5/1-d'),
                ),
            ]),
        ]),
    ],
];
