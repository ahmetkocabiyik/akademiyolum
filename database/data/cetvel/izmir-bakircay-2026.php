<?php

/**
 * İZMİR BAKIRÇAY ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma
 * Ölçütleri Puan Tablosu
 * Kaynak: pdf/1774860669632.izmir-bakircay-kriter-30032026.pdf
 *
 * Madde kodları tablonun kendi kod sütunundan alındı (1.a, 4.c, 7.a …).
 *
 * ── LİSANSÜSTÜ TEZDEN ÜRETİLMİŞ YAYIN BÖLÜMÜ (3) GİRİLMEDİ ──
 * Tablo aynı yayın türlerini iki kez veriyor: 1, 2 ve 4. bölümler tezden
 * ÜRETİLMEMİŞ yayınlar, 3. bölüm tezden üretilmiş olanlar (düşük puan).
 * Faaliyet kaydı yayının tez kökenli olup olmadığını taşımıyor; 3. bölümü
 * de yazmak aynı makaleyi iki kez saydırırdı. MADDE 13 ile 14'ün eser
 * sayısı koşulları da ağırlıkla 1, 2 ve 4. bölümlere yazıldığı için o
 * bölümler girildi ve 3. bölüm hiç yazılmadı. Tezinizden ürettiğiniz
 * yayınlar bu yüzden olduğundan YÜKSEK puanlanıyor ve 3. bölümün "en fazla
 * 20 puan" sınırı uygulanmıyor.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   10.d (değerlendirmeye alınmış kişisel patent başvurusu, 2 puan) —
 *       tescilden ayrılamıyor.
 *   13.a (Web of Science ya da Google Scholar h-indeks değeri) ve 13.b
 *       (ilk 300 üniversitede kesintisiz altı ay yurt dışı araştırma,
 *       5 puan) — faaliyet değil profil ve süre ölçütü.
 *   Ders kitapları ve çeviriler — 4. bölümün açıklaması "yalnızca ders
 *       kitabı dışındaki özgün bilimsel kitaplar" diyor, bu yüzden
 *       'Ders / Metot Kitabı', 'Çeviri Kitap' ve 'Çeviri Kitap Bölümü'
 *       etiketlerine hiçbir satır bağlanmadı.
 *   Öğrenci projeleri — 7.a bendi bunları açıkça kapsam dışı bırakıyor.
 *   İDARİ GÖREV, SANATSAL ETKİNLİK ve TOPLUMSAL KATKI kalemlerinin
 *       tamamı — puan tablosunda hiç yok; bu kayıtlarınız toplam puana
 *       katkı vermiyor.
 *   Editörlükte 'Hakemlik', 'Yayın Kurulu Üyeliği', indekssiz dergi
 *       editörlüğü ve kitap editörlüğünün ulusal karşılığı — tabloda
 *       yalnız 12.a-c satırları var.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   6. bölümün "ikinci ya da eş danışman puanın yarısını alır" kuralı:
 *       yarım değerler (2,5 ve 1,5) tam sayıya sığmadığı için asıl
 *       danışman değerleri girildi; eş danışmanlıklarınız olduğundan
 *       yüksek puanlanıyor.
 *   4. bölümün "aynı kitaptaki bölümlerden yalnız biri puanlanır" sınırı
 *       ile 5. bölümün "aynı yayında yapılan birden fazla atıf tek atıf
 *       sayılır" kuralı.
 *   MADDE 14/4'ün "önceki atamalarda kullanılan eser ve faaliyetler
 *       sonraki başvuruda ibraz edilemez" kuralı.
 *
 * Yönerge: yonerge/izmir-bakircay.php
 */
$OZGUN = ['ozgun_makale'];
$KISA = ['derleme', 'kisa_makale'];
$VAKA = ['vaka_teknik_not'];
$WOS_Q = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)'];
$ULUSLARARASI_DERGI = [...$WOS_Q, 'AHCI', 'ESCI / Scopus', 'Diğer Uluslararası İndeks'];

$maddeler = [
    // ══ 1. ULUSLARARASI MAKALE ══
    '1.a.q1' => ['baslik' => 'SSCI, SCI veya SCI-Expanded kapsamındaki Q1 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $OZGUN, 'puan' => 30],
    '1.a.q2' => ['baslik' => 'SSCI, SCI veya SCI-Expanded kapsamındaki Q2 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $OZGUN, 'puan' => 20],
    '1.a.q3' => ['baslik' => 'SSCI, SCI veya SCI-Expanded kapsamındaki Q3 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $OZGUN, 'puan' => 15],
    '1.a.q4' => ['baslik' => 'SSCI, SCI veya SCI-Expanded kapsamındaki Q4 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => $OZGUN, 'puan' => 10],
    '1.b' => ['baslik' => 'AHCI kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => $OZGUN, 'puan' => 20],
    '1.c' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $OZGUN, 'puan' => 10],
    '1.d' => ['baslik' => 'Diğer uluslararası hakemli dergilerde yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $OZGUN, 'puan' => 5],
    '1.e' => ['baslik' => 'Uluslararası dergilerde yayımlanmış editöre mektup, araştırma notu, özet, derleme ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => $ULUSLARARASI_DERGI, 'turler' => $KISA, 'puan' => 3],
    '1.f' => ['baslik' => 'SSCI, SCI veya SCI-Expanded kapsamındaki dergide yayımlanmış vaka takdimi', 'kategori' => 'makale', 'kaynaklar' => $WOS_Q, 'turler' => $VAKA, 'puan' => 5],

    // ══ 2. ULUSAL MAKALE ══
    '2.a' => ['baslik' => 'TR Dizin kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $OZGUN, 'puan' => 10],
    '2.b' => ['baslik' => 'Diğer ulusal hakemli dergilerde yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $OZGUN, 'puan' => 4],
    '2.c' => ['baslik' => 'Ulusal hakemli dergide yayımlanmış editöre mektup, araştırma notu, özet, derleme ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => [...$KISA, ...$VAKA], 'puan' => 2],

    // ══ 4. KİTAP ══
    '4.a' => ['baslik' => 'BKCI kapsamındaki kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası Kitap'], 'puan' => 20],
    '4.b' => ['baslik' => 'BKCI kapsamındaki kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Uluslararası Kitap Bölümü'], 'puan' => 10],
    '4.c' => ['baslik' => 'Diğer uluslararası ya da ulusal özgün bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)'], 'puan' => 20],
    '4.d' => ['baslik' => 'Diğer uluslararası ya da ulusal kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 10],

    // ══ 5. ATIF ══
    '5.a' => ['baslik' => 'SCI, SCI-Expanded, SSCI, AHCI veya Scopus kapsamında eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 3],
    '5.b' => ['baslik' => 'BKCI kapsamındaki kitapta eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 2],
    '5.c' => ['baslik' => 'TR Dizin kapsamındaki dergide eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
    '5.d' => ['baslik' => 'Diğer uluslararası ya da ulusal kitap veya dergide eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],

    // ══ 6. LİSANSÜSTÜ TEZ DANIŞMANLIĞI ══
    '6.a' => ['baslik' => 'Tamamlanmış doktora tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 5],
    '6.b' => ['baslik' => 'Tamamlanmış yüksek lisans tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi', 'Tez İzleme / Jüri Üyeliği'], 'puan' => 3],

    // ══ 7. BİLİMSEL ARAŞTIRMA PROJESİ ══
    '7.a.y' => ['baslik' => 'AB, TÜBİTAK ya da TÜSEB bilimsel araştırma projesinde koordinatörlük veya yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 15],
    '7.a.a' => ['baslik' => 'AB, TÜBİTAK ya da TÜSEB bilimsel araştırma projesinde araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 10],
    '7.a.d' => ['baslik' => 'AB, TÜBİTAK ya da TÜSEB bilimsel araştırma projesinde danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK', 'TÜSEB'], 'roller' => ['danisman'], 'puan' => 5],
    '7.b' => ['baslik' => 'Uluslararası destekli bilimsel araştırma projesinde yürütücülük, araştırmacılık ya da danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'puan' => 10],
    '7.c' => ['baslik' => 'Üniversiteler dışındaki kamu kurumu ya da özel kuruluşla yapılan Ar-Ge projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'puan' => 5],
    '7.d' => ['baslik' => 'Üniversitedeki BAP projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 3],

    // ══ 8. BİLİMSEL TOPLANTI FAALİYETİ ══
    '8.a' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan, tam metni ya da özeti yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin', 'Uluslararası Özet/Poster', 'Davetli Konuşmacı'], 'puan' => 5],
    '8.b' => ['baslik' => 'Ulusal bilimsel toplantıda sunulan, tam metni ya da özeti yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin', 'Ulusal Özet/Poster'], 'puan' => 3],

    // ══ 9. EĞİTİM-ÖĞRETİM FAALİYETİ ══
    '9.a' => ['baslik' => 'Bir dönem yüksek lisans ya da doktora dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 1],
    '9.b' => ['baslik' => 'Bir dönem önlisans ya da lisans dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 1],

    // ══ 10. PATENT / FAYDALI MODEL ══
    '10.a' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 20],
    '10.b' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 10],
    '10.c' => ['baslik' => 'Tescil edilmiş faydalı model, endüstriyel tasarım ya da yazılım', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım', 'Ticarileştirme'], 'puan' => 5],

    // ══ 11. ÖDÜL ══
    '11.a' => ['baslik' => 'YÖK yılın doktora tezi ya da üstün başarı ödülü, TÜBİTAK bilim ya da teşvik ödülü, TÜBA GEBİP ya da TESEP ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 25],

    // ══ 12. EDİTÖRLÜK ══
    '12.a' => ['baslik' => 'SSCI, SCI, SCI-Expanded, ESCI, AHCI veya Scopus kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 2],
    '12.b' => ['baslik' => 'BKCI veya Scopus kapsamındaki kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Uluslararası Kitap Editörlüğü'], 'puan' => 1],
    '12.c' => ['baslik' => 'TR Dizin kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 1],
];

$MAKALE_1 = ['1.a.q1', '1.a.q2', '1.a.q3', '1.a.q4', '1.b', '1.c', '1.d'];
$MAKALE_2 = ['2.a', '2.b'];
$KITAP_4 = ['4.a', '4.b', '4.c', '4.d'];

return [
    'kapsam_notu' => 'Puanlar İzmir Bakırçay Üniversitesi Öğretim Üyeliğine Yükseltilme ve '
        .'Atanma Ölçütleri Puan Tablosundan. Tablonun puanlama kuralı basit: tek yazarlı '
        .'eserlerde tam puan, çok yazarlı eserlerde puan yazarlar arasında EŞİT bölünüyor; '
        .'yazar sırasının etkisi yok. Yazar listesini boş bırakırsanız bölme uygulanmaz ve '
        .'puanınız olduğundan yüksek görünür. Kitaptan en fazla 30, atıftan 10, tez '
        .'danışmanlığından 10, projeden 30, bilimsel toplantıdan 10, eğitim-öğretimden 10, '
        .'ödülden 25, editörlükten 4 puan alınabiliyor. Puanınız şu kalemlerde OLDUĞUNDAN '
        .'DÜŞÜK görünür: idari görev, sanatsal etkinlik ve toplumsal katkı kalemleri tabloda '
        .'hiç yok; ders kitabı ve çeviriler yönergece kapsam dışı; öğrenci projeleri sayılmıyor; '
        .'h-indeks, yurt dışı araştırma süresi ve patent BAŞVURUSU satırları girilemedi; '
        .'editörlükte yalnız üç satır var, hakemlik ve yayın kurulu üyeliği puanlanmıyor. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünür: lisansüstü tezinizden '
        .'ürettiğiniz yayınlar için tablonun 3. bölümündeki düşük satırlar ve o bölümün 20 '
        .'puanlık sınırı uygulanamıyor; eş danışmanlıkta puanın yarıya inmesi de '
        .'uygulanamıyor.'
        .' KİTAPTA İNDEKS KOŞULU DENETLENMİYOR: uluslararası yayınevi kitabınız yönergenin BKCI/Scopus taranan kitap satırından sayılıyor. Kitabınız bu kapsamda değilse puanınız olduğundan YÜKSEK görünür; yönerge o kitabı daha düşük bir satırda sayıyor olabilir.',

    // "Tek yazarlı eserlerde yazar tam puan alır, çok yazarlı eserlerde puan
    // yazarlar arasında eşit olarak paylaştırılır." Patent ve faydalı
    // modelde de aynı kural yazılı.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'editorluk', 'proje', 'tez_danismanligi', 'tez_yayini',
            'egitim_ogretim', 'idari_gorev', 'toplumsal_katki', 'odul', 'sanatsal_etkinlik', 'diger'],
        'sonrasi_pay' => 1.0,
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        'TOPLAM' => array_keys($maddeler),
        // MADDE 13/1-a: "en az 1 tanesi 1 (a,b) … bölümünden olmak üzere
        // 1 (a,b,c,d) veya 4 (a,b,c,d) bölümünden en az 3 eser".
        // 3. bölüm (tezden üretilmiş yayınlar) cetvele girilmedi.
        'ESER-A-CEKIRDEK' => ['1.a.q1', '1.a.q2', '1.a.q3', '1.a.q4', '1.b'],
        'ESER-A' => [...$MAKALE_1, ...$KITAP_4],
        // MADDE 13/1-b: "en az 1 tanesi 1 (a,b,c,d) veya 2 (a,b) bölümünden
        // olmak üzere 1, 2 veya 4 bölümünden en az 3 eser".
        'ESER-B-CEKIRDEK' => [...$MAKALE_1, ...$MAKALE_2],
        'ESER-B' => [...$MAKALE_1, ...$MAKALE_2, ...$KITAP_4],
        // MADDE 14/3-a ve 14/3-b: yeniden atamada eser kümeleri.
        'YENIDEN-A' => [...$MAKALE_1, ...$MAKALE_2],
        'YENIDEN-B' => [...$MAKALE_1, ...$MAKALE_2, ...$KITAP_4],
        // MADDE 14/3-c: "7. madde kapsamında en az 1 projede görev almak".
        'PROJE' => ['7.a.y', '7.a.a', '7.a.d', '7.b', '7.c', '7.d'],
        // Tavan grupları.
        'KITAP' => $KITAP_4,
        'ATIF' => ['5.a', '5.b', '5.c', '5.d'],
        'TEZ' => ['6.a', '6.b'],
        'BILDIRI' => ['8.a', '8.b'],
        'DERS' => ['9.a', '9.b'],
        'ODUL' => ['11.a'],
        'EDITORLUK' => ['12.a', '12.b', '12.c'],
    ],

    'grup_tavanlari' => [
        'KITAP' => 30,
        'ATIF' => 10,
        'TEZ' => 10,
        'PROJE' => 30,
        'BILDIRI' => 10,
        'DERS' => 10,
        'ODUL' => 25,
        'EDITORLUK' => 4,
    ],
];
