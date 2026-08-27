<?php

/**
 * SANKO ÜNİVERSİTESİ — dergi indeksi türleri (MADDE 4 ve MADDE 10/2)
 * Kaynak: pdf/17537103582.sankouniersitesi.pdf
 *
 * PUANSIZ VE EKSİK CETVEL. SANKO'nun yönergesi puanlamayı iki ayrı belgeye
 * devrediyor ve İKİSİ DE PDF'TE YOK:
 *   "Puanlama Çizelgesi" (Bilimsel ve Diğer Faaliyetler Puanlama Çizelgesi)
 *   "Asgari Koşullar Çizelgesi"
 * Altı sayfalık dosyada yalnızca yönerge gövdesi (MADDE 1-18) var.
 *
 * Bu dosya bir puan cetveli değil: yönergenin GÖVDESİNDE tanımı verilen tek
 * ölçülebilir küme olan dergi indeksi kademelerini tutuyor. MADDE 10/2 doktor
 * öğretim üyeliği için "Üniversitelerarası Kurul Başkanlığınca Doçentlik
 * sınavında kabul edilen indeksler (SSCI, SCI-Exp. veya AHCI) veya diğer
 * uluslararası ve ulusal alan indeksleri tarafından taranan dergilerde en az
 * 2 (iki) bilimsel makale" istiyor; kümenin sınırları MADDE 4/p ve 4/r'de
 * tanımlı (ulusal indeks = TÜBİTAK-ULAKBİM, uluslararası indeks = SCI-Exp,
 * SSCI, AHCI ya da diğer uluslararası alan indeksleri). `puan` anahtarı hiçbir
 * satırda yok.
 *
 * ── KÜMEYE GİRMEYEN TEK MAKALE KAYNAĞI ──
 * 'Diğer Ulusal Hakemli' — indekslenmemiş ulusal dergiler. MADDE 4/p ulusal
 * indeksi yalnızca ULAKBİM olarak tanımlıyor, indekssiz dergi kümeye girmiyor.
 *
 * ── PUANLAMA ÇİZELGESİ BULUNURSA ──
 * Yazar formülü yönergenin gövdesinde YAZILI (MADDE 15) ve motorun `bol`
 * alanıyla birebir ifade edilebiliyor; çizelge bulunduğunda cetvele şu
 * eklenecek:
 *   'tek'                → 1,0
 *   'ilk' ve 'baslica'   → bol: pay 1.6, ek 0.20
 *   'yazar_2'            → bol: pay 1.6, ek 0.15
 *   'yazar_3'            → bol: pay 1.6, ek 0.10
 *   'yazar_4'…'ortak'    → bol: pay 1.6, ek 0.05
 * (Yönerge "yazar sayısı 4 veya daha fazla ise … eşit olarak dağıtılır"
 * diyor, yani dördüncü ve sonraki isimler aynı satırı paylaşıyor.)
 *
 * MADDE 4/d'nin "başlıca yazar" tanımı motorun süzgecinden GENİŞ: tek yazarı,
 * çok yazarlı makalelerde İLK İKİ SIRADAKİ yazarı, sorumlu yazarı ve
 * danışmanlığını yaptığı tezden üretilmiş yayındaki yazarı kapsıyor. Motorun
 * `yazar: 'baslica'` süzgeci ikinci sırayı ve tez türevliliğini tanımıyor.
 *
 * Yönerge: yonerge/sanko.php
 */

return [
    'kapsam_notu' => 'SANKO Üniversitesi\'nin puanlama çizelgesi ve asgari koşullar çizelgesi '
        .'kaynak belgede YER ALMIYOR; burada yalnızca yönerge gövdesinde tanımı verilen '
        .'koşullar gösterilebiliyor. Toplam puan hesabı yapılamıyor, dolayısıyla bu '
        .'üniversitede puan barajı göremezsiniz. Doktor öğretim üyeliğinin makale sayısı '
        .'koşulu ile yabancı dil şartı yönergenin kendi maddelerinde yazılı olduğu için tam '
        .'olarak değerlendirilebiliyor; doçentlik ve profesörlükte çizelgeye dayanan koşullar '
        .'beyana bırakıldı. İndekslenmemiş ulusal dergilerdeki makaleleriniz sayılmaz: '
        .'yönerge ulusal indeksi yalnızca TÜBİTAK-ULAKBİM olarak tanımlıyor.',

    'maddeler' => [
        // MADDE 4/r: uluslararası indeks = ÜAK'ın doçentlik sınavında kabul
        // ettiği indeksler ya da diğer uluslararası alan indeksleri.
        'UI.1' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI taranan dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI']],
        'UI.2' => ['baslik' => 'Diğer uluslararası alan indeksli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks']],

        // MADDE 4/p: ulusal indeks = TÜBİTAK-ULAKBİM ulusal veri tabanı.
        'NI.1' => ['baslik' => 'TÜBİTAK ULAKBİM taranan ulusal dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin']],
    ],

    'gruplar' => [
        // MADDE 10/2'nin andığı küme: ÜAK indeksleri veya diğer uluslararası
        // ve ulusal alan indeksleri.
        'INDEKSLI-DERGI' => ['UI.1', 'UI.2', 'NI.1'],
    ],
];
