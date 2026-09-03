<?php

/**
 * MANİSA CELAL BAYAR ÜNİVERSİTESİ — Öğretim Üyesi Kadrolarına Atama ve
 * Yükseltme Yönergesi (Bölüm III: Başvuru Koşulları)
 * Kaynak: pdf/17537003232.manisacelalbayaruniverstesi.pdf
 *
 * TEMEL ALAN AYRIMI YALNIZCA DR. ÖĞR. ÜYESİ İLK ATAMADA VAR (Madde C/1):
 *   Sağlık, Mühendislik, Fen ve Matematik   SCI/SCI-E/SSCI/AHCI'de 2 makale
 *   Diğer temel alanlar                     üç alternatiften biri
 * Doçentlik ve profesörlükte bütün alanlar aynı puanları sağlıyor.
 *
 * DR. ÖĞR. ÜYESİ İLK ATAMADA PUAN BARAJI YOK: Madde C yalnızca yayın sayısı ve
 * yabancı dil şartı arıyor. AED puanı ilk atamada değil, YENİDEN ATAMADA
 * (en az 150) devreye giriyor. Bu yönergenin kendi tercihi, eksik veri değil.
 *
 * YENİDEN ATANMA GİRİLMEDİ: koşulların üçü de son atama tarihinden sonraki
 * çalışmalara bakıyor ve dördüncü bent "koşulları sağlayamayan adaya bir defaya
 * mahsus 1 yıl ek süre verilebilir" diyor. Sabit bir eşik yazmak bu esnekliği
 * gizlerdi; koşullar aday notunda anıldı.
 *
 * PROFESÖRLÜKTEKİ İLK KOŞUL (A/1) BEYANA BIRAKILDI: "doçent unvanı almaya hak
 * kazandığı başvuru dönemine ait YÖK doçentlik şartlarını bir kez daha
 * sağlamak". Hangi dönemin ÜAK şartlarının geçerli olduğu adayın doçentlik
 * tarihine bağlı; korpustaki ÜAK cetvelleri tek dönemi kapsıyor, bu yüzden
 * koşul beyan olarak duruyor.
 *
 * "28-30. MADDELERDEN EN AZ 50 PUAN" koşulu öğretim faaliyetleri ve tez
 * yönetimini sayıyor — korpusta ders ve tez danışmanlığından AYRI baraj isteyen
 * az sayıdaki yönergeden biri. Doçentlikte aynı koşul 30 puan, ama yalnızca
 * hâlen bir üniversitede çalışan adaylar için; üniversite dışından gelen aday
 * bunun yerine 1-24 maddelerinden 400 değil 500 puan sağlıyor.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/manisa-cbu-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

$DOC = Kalip::DOCENTLIK_SONRASI;

/** Yönerge doçentlik ve profesörlükte alan ayrımı yapmıyor. */
$tumAlanlar = ['fen', 'muhendislik', 'mimarlik', 'saglik', 'spor', 'hukuk', 'ilahiyat',
    'filoloji', 'sosyal', 'egitim', 'guzel_sanatlar', 'ziraat'];

/** Madde C/1-a'nın adıyla saydığı alanlar. */
$fenGrubu = ['saglik', 'muhendislik', 'fen'];
$digerAlanlar = array_values(array_diff($tumAlanlar, $fenGrubu));

$yenidenAtamaNotu = 'Yeniden atanmada (Madde C) son atamadan sonraki çalışmalarınızla AED\'den '
    .'en az 150 puan ve şu seçeneklerden biri isteniyor: SCI-E/SSCI/AHCI/ESCI dergide 1 makale, '
    .'TR-Dizin veya alan endeksinde 2 makale, hakemli dergilerde 3 makale, 1 özgün araştırma '
    .'kitabı, 1 patent ya da desteklenen bir projede yürütücülük. Müzik Bilim Alanı adayları '
    .'ayrıca 150 puanın en az 10\'unu sanatsal etkinlik kalemlerinden almalı. Koşulları '
    .'sağlayamayan adaya bir defaya mahsus 1 yıl ek süre verilebiliyor; bu esneklik nedeniyle '
    .'yeniden atanma eşiği ayrıca girilmedi.';

return [
    // ══════════ DR. ÖĞRETİM ÜYESİ (ilk atama, Madde C) ══════════
    [
        'anahtar' => 'manisa-cbu-dr-fen',
        'aday_notu' => 'Manisa CBÜ ilk atamada PUAN BARAJI KOYMUYOR; yalnızca yayın sayısı ve '
            .'yabancı dil şartı arıyor. Burada toplam puan görmüyorsunuz — eksik veri değil, '
            .'yönergede öyle. '.$yenidenAtamaNotu,
        'universite' => 'Manisa Celal Bayar Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $fenGrubu,
        'cetvel' => 'manisa-cbu-2024',
        'notlar' => 'Madde C/1-a: SCI, SCI-Expanded, SSCI veya AHCI dergilerde en az 2 makale; '
            .'Madde C/2: merkezî yabancı dil sınavından en az 60.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Sağlık, Mühendislik, Fen Bilimleri ve Matematik', [
            Kalip::yds(60),
            Kalip::adet('SCI, SCI-Expanded, SSCI veya AHCI dergilerde en az 2 makale',
                ['1a', '1b', '1c', '1d'], 2, madde: 'Madde C/1-a'),
        ]),
    ],
    [
        'anahtar' => 'manisa-cbu-dr-diger',
        'aday_notu' => 'Manisa CBÜ ilk atamada PUAN BARAJI KOYMUYOR; yalnızca yayın sayısı ve '
            .'yabancı dil şartı arıyor. Aşağıdaki dört seçenekten herhangi birini sağlamanız '
            .'yeterli. '.$yenidenAtamaNotu,
        'universite' => 'Manisa Celal Bayar Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $digerAlanlar,
        'cetvel' => 'manisa-cbu-2024',
        'notlar' => 'Madde C/1-b: SCI/SCI-E/SSCI/AHCI/ESCI veya alan endeksinde 2 makale ya da '
            .'TR-Dizin\'de 3 makale ya da tümünde toplam 3 makale ya da 1 özgün araştırma kitabı; '
            .'Madde C/2: merkezî yabancı dil sınavından en az 60.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Diğer temel alanlar', [
            Kalip::yds(60),
            Kalip::veya('Aşağıdaki yayın seçeneklerinden birini sağlamak', [
                Kalip::adet('SCI, SCI-Expanded, SSCI, AHCI, ESCI veya alan endeksli dergilerde en az 2 makale',
                    ['1a', '1b', '1c', '1d', '2'], 2, madde: 'Madde C/1-b'),
                Kalip::adet('ULAKBİM TR-Dizin dergilerinde en az 3 makale',
                    ['3'], 3, madde: 'Madde C/1-b'),
                Kalip::adet('Sayılan dergilerin tümünde toplam en az 3 makale',
                    ['1a', '1b', '1c', '1d', '2', '3'], 3, madde: 'Madde C/1-b'),
                Kalip::adet('En az 1 özgün araştırma kitabı (ders kitabı hariç)',
                    ['9a', '9b'], 1, madde: 'Madde C/1-b'),
            ]),
        ]),
    ],

    // ══════════ DOÇENT (Madde B) ══════════
    [
        'anahtar' => 'manisa-cbu-docent',
        'aday_notu' => 'Öğretim ve tez yönetimi barajı (30 puan) yalnızca HÂLEN BİR '
            .'ÜNİVERSİTEDE ÇALIŞAN adaylar için geçerli. Üniversite dışından başvuruyorsanız bu '
            .'koşul yerine makale, kitap, proje ve atıf kalemlerinden 400 değil 500 puan '
            .'sağlamanız isteniyor; burada üniversitede çalışan aday varsayıldı.',
        'universite' => 'Manisa Celal Bayar Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $tumAlanlar,
        'cetvel' => 'manisa-cbu-2024-docent',
        'notlar' => 'Madde B: AED\'den toplam 600, bunun en az 400\'ü 1-24. maddelerden, '
            .'en az 30\'u 28-30. maddelerden; merkezî yabancı dil sınavından en az 65.',
        'sart' => Kalip::ve('Doçent — Manisa Celal Bayar Üniversitesi', [
            Kalip::yds(65),
            Kalip::toplam(600),
            Kalip::puanDan('Makale, bildiri, kitap, proje, patent, ödül ve atıf kalemlerinizden en az 400 puan',
                ['1-24'], 400, madde: 'Madde B/2'),
            Kalip::puanDan('Verdiğiniz dersler ve yönettiğiniz tezlerden en az 30 puan',
                ['28-30'], 30, madde: 'Madde B/3'),
        ]),
    ],

    // ══════════ PROFESÖR (Madde A) ══════════
    [
        'anahtar' => 'manisa-cbu-profesor',
        'aday_notu' => 'Doçentliğinizi aldığınız başvuru dönemine ait ÜAK doçentlik şartlarını '
            .'bir kez daha sağlamanız gerekiyor (Madde A/1); hangi dönemin şartlarının geçerli '
            .'olduğu doçentlik tarihinize bağlı olduğu için bu koşul beyan olarak duruyor. '
            .'Başlıca araştırma eserinde BAŞLICA YAZAR olmanız şart.',
        'universite' => 'Manisa Celal Bayar Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $tumAlanlar,
        'cetvel' => 'manisa-cbu-2024-profesor',
        'notlar' => 'Madde A: AED\'den toplam 1200, en az 300\'ü doçentlik sonrası; 1-24. '
            .'maddelerden en az 800; 28-30. maddelerden en az 50 (en az 25\'i doçentlik sonrası); '
            .'merkezî yabancı dil sınavından en az 65.',
        'sart' => Kalip::ve('Profesör — Manisa Celal Bayar Üniversitesi', [
            Kalip::yds(65),
            Kalip::toplam(1200),
            Kalip::toplam(300, $DOC),
            Kalip::puanDan('Makale, bildiri, kitap, proje, patent, ödül ve atıf kalemlerinizden en az 800 puan',
                ['1-24'], 800, madde: 'Madde A/4'),
            Kalip::puanDan('Verdiğiniz dersler ve yönettiğiniz tezlerden en az 50 puan',
                ['28-30'], 50, madde: 'Madde A/5'),
            Kalip::puanDan('Doçentliğinizden sonraki ders ve tez yönetiminizden en az 25 puan',
                ['28-30'], 25, $DOC, madde: 'Madde A/5'),
            Kalip::adet('Doçentliğinizden sonra başlıca yazar olduğunuz, başlıca araştırma eseri '
                .'olarak sunacağınız en az 1 özgün eser',
                ['1a', '1b', '1c', '1d', '2', '3', '9a', '9b'], 1, 'baslica', $DOC, madde: 'Madde A/6'),
            Kalip::beyan('Doçent unvanı almaya hak kazandığınız başvuru dönemine ait YÖK '
                .'doçentlik şartlarını, doçent unvanını aldıktan sonra bir kez daha sağlamış '
                .'olmak', 'Madde A/1'),
        ]),
    ],
];
