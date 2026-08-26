<?php

/**
 * İZMİR DEMOKRASİ ÜNİVERSİTESİ — çalışma türü cetveli
 * Kaynak: pdf/17666694591.İzmir Demokrasi Üniversitesi Kriter.pdf
 *
 * PUANSIZ CETVEL. Yönergenin kendi puan tablosu yok; koşulların tamamı "en az
 * N adet şu türden çalışma" biçiminde. Bu dosya bir puan cetveli değil, tür
 * sözlüğü: `puan` anahtarı bilinçli olarak yok (motor 0 sayar, zaten hiçbir
 * koşul puana bakmıyor).
 *
 * Madde kodları bize ait — yönerge kalemlere kod vermiyor, kümeleri düzyazıyla
 * tarif ediyor ("SSCI, SCI / SCI-E / AHCI / ESCI veya YÖK tarafından belirlenen
 * sair uluslararası endekslerde taranan dergiler").
 *
 * ── "BİRİNCİ VEYA İKİNCİ YAZAR" İFADE EDİLEMİYOR ──
 * Yönergenin birkaç koşulu "birinci veya ikinci yazar olmak" diyor. Motorun
 * yazar süzgeci üç kademe tanıyor (tek · ilk · başlıca) ve "ikinci yazar da
 * olur" diye bir kademe yok. Koşullar `ilk` ile girildi: ikinci yazar olduğunuz
 * yayınlar bu koşullara SAYILMAZ, yani koşul olduğundan ZOR görünür — adayı
 * fazla hazır göstermeyen taraf.
 *
 * ── PROFESÖRLÜKTE ÜAK'A DEVİR ──
 * Profesörlük koşulu "YÖK'ün başvurulan alan için belirlediği doçentlik asgari
 * koşullarının doçentlik sonrası çalışmalarla yeniden yerine getirilmesi"
 * diyor. Bu ÜAK'ın kendi tablosuna bakan bir koşul; İzmir Demokrasi'nin
 * cetvelinden hesaplanamaz, beyan olarak girildi.
 *
 * Yönerge: yonerge/izmir-demokrasi.php
 */

return [
    'kapsam_notu' => 'İzmir Demokrasi Üniversitesi\'nin yönergesinde puan tablosu yok; bütün '
        .'koşullar "en az N adet şu türden çalışma" biçiminde. Bu yüzden burada bir toplam '
        .'puan göremezsiniz, yalnızca koşulların tek tek karşılanıp karşılanmadığını görürsünüz. '
        .'Yönergenin "birinci veya ikinci yazar" dediği koşullar BİRİNCİ YAZAR olarak girildi: '
        .'ikinci yazar olduğunuz yayınlar o koşullara sayılmaz, yani koşul olduğundan zor '
        .'görünür. Profesörlükte ayrıca ÜAK doçentlik koşullarının doçentlik sonrası yeniden '
        .'sağlanması isteniyor; o koşul ÜAK\'ın kendi tablosuna baktığı için burada beyan '
        .'olarak duruyor.',

    'maddeler' => [
        // ── Uluslararası indeksli dergiler ──
        // "SSCI, SCI / SCI-E / AHCI / ESCI veya YÖK tarafından belirlenen sair
        // uluslararası endekslerde taranan dergiler"
        'U1' => ['baslik' => 'SSCI, SCI, SCI-E veya AHCI kapsamındaki dergide özgün, derleme ya da araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI']],
        'U2' => ['baslik' => 'ESCI veya diğer uluslararası indeksli dergide özgün, derleme ya da araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks']],

        // ── TR Dizin ──
        'T1' => ['baslik' => 'TR Dizinde taranan dergide özgün, derleme ya da araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin']],

        // ── Kitap ──
        // "kendi alanında özgün bir konuda kitap" (lisansüstü tezlerden
        // üretilmemiş olmak koşuluyla).
        'K1' => ['baslik' => 'Kendi alanında özgün bir konuda kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Ders / Metot Kitabı']],
        'K2' => ['baslik' => 'Kitap içinde bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Kitap Bölümü', 'Ansiklopedi Maddesi']],

        // ── Tez danışmanlığı ──
        // "birinci veya tek danışman olarak yönetmiş veya yönetiyor olmak" —
        // eş danışmanlık sayılmaz.
        'TZ' => ['baslik' => 'Birinci veya tek danışman olarak yönetilen lisansüstü tez', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi', 'Yüksek Lisans Tezi'], 'roller' => ['danisman']],

        // ── Bilimsel araştırma projesi ──
        // "BAP, Ar-Ge, TÜBİTAK, Avrupa Birliği projeleri, ulusal veya
        // uluslararası kamu kurumları nezdinde veya tüm bunlara eş değer
        // nitelikte sair proje" — yürütücü VEYA araştırmacı.
        'PR' => ['baslik' => 'Yürütücü veya araştırmacı olarak sürdürülen bilimsel araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon', 'TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK', 'BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu', 'arastirmaci']],
    ],

    'gruplar' => [
        // Dr. ilk atanma b.2 ve yeniden atanma c.1: "kitap VEYA uluslararası
        // indeksli dergide makale".
        'KITAP-VEYA-ULUSLARARASI' => ['K1', 'U1', 'U2'],
        'ULUSLARARASI' => ['U1', 'U2'],
        // b.3 ve c.2: "TR Dizinde makale VEYA eksik sayı kadar kitap bölümü".
        'TR-VEYA-BOLUM' => ['T1', 'K2'],
        'TR' => ['T1'],
        'TEZ' => ['TZ'],
        'PROJE' => ['PR'],
    ],
];
