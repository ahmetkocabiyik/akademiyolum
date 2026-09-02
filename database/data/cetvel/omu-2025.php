<?php

/**
 * ONDOKUZ MAYIS ÜNİVERSİTESİ — Yükseltilme ve Atanmalarda Uygulanacak
 * Puan Cetveli
 * Kaynak: pdf/17634002431.Ondokuz Mayıs Üniversitesi Kriter.pdf (Mayıs 2025)
 *
 * TEK ORTAK CETVEL, ÜÇ TEMEL ALAN GRUBU İÇİN AYRI EŞİK. Koşullar cetvele
 * KATEGORİ ARALIĞIYLA atıf yapıyor ("1-10 kategorilerinden en az 360 puan",
 * "1-14 kategorilerinden en az 750") ve aralığın ÜST SINIRI alan grubuna göre
 * değişiyor: A 1-14, B 1-15, C 1-16. Bu yüzden gruplar üç ayrı aralık olarak
 * tanımlandı.
 *
 * ÇEYREKLİKLER TEK SATIRDA: 1. bölümün satırları puanı "80/70/60/50" biçiminde
 * Q1'den Q4'e veriyor. Kaynak sözlüğü çeyrekliği ayırdığı için satırlar alt
 * maddelere bölündü (1.1-Q1 … 1.1-Q4); kategori aralıkları önek eşleşmesiyle
 * bunları da yakalıyor.
 *
 * GİRİLMEYEN: 14 ve 15. bölümler (görsel etkinlikler — İletişim Fakültesi'ne
 * özgü), 16. bölüm sanatsal etkinliklerin alt kırılımları ve 13. bölümün ödül
 * dışı hizmet kalemleri. Kaynak sözlüğünde karşılıkları yok.
 */

return [
    'kapsam_notu' => 'Puanlar Ondokuz Mayıs Üniversitesi Puan Cetvelinden (Mayıs 2025). Görsel '
        .'etkinlikler ve sanatsal etkinliklerin alt kırılımları kaynak sözlüğünde karşılıksız '
        .'olduğu için girilmedi; güzel sanatlar alanında 16. kategori barajı bu yüzden beyan '
        .'olarak duruyor. Gerçek toplamınız burada görünenden yüksek olabilir, düşük olamaz.',

    'maddeler' => [
        // ── 1. SCI, SCIE, SSCI veya AHCI ── (çeyrekliğe göre 80/70/60/50)
        '1.1-Q1' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI Q1 dergide özgün araştırma makalesi veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 80],
        '1.1-Q2' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI Q2 dergide özgün araştırma makalesi veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 70],
        '1.1-Q3' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI Q3 dergide özgün araştırma makalesi veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 60],
        '1.1-Q4' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI Q4 dergide özgün araştırma makalesi veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 50],
        '1.2-Q1' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI Q1 dergide vaka takdimi, teknik not veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 20],
        '1.2-Q4' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI Q2-Q4 dergide vaka takdimi, teknik not veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 14],
        '1.3' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 40],
        '1.4' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI dergide alan editörlüğü veya yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 21],
        '1.5' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI dergide hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 15],

        // ── 2. ESCI, SCOPUS ve SPORTDiscus ──
        '2.1' => ['baslik' => 'ESCI veya Scopus dergide özgün araştırma makalesi veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 40],
        '2.2' => ['baslik' => 'ESCI veya Scopus dergide vaka takdimi, teknik not veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 10],
        '2.3' => ['baslik' => 'ESCI veya Scopus dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 35],

        // ── 3. TR DİZİN ──
        '3.1' => ['baslik' => 'TR Dizin hakemli dergide özgün araştırma makalesi veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 30],
        '3.2' => ['baslik' => 'TR Dizin hakemli dergide vaka takdimi, teknik not veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 20],
        '3.4' => ['baslik' => 'TR Dizin hakemli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 25],

        // ── 4. DİĞER HAKEMLİ DERGİLER ──
        '4.1' => ['baslik' => 'Diğer ulusal veya uluslararası hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 20],
        '4.4' => ['baslik' => 'Diğer hakemli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 15],

        // ── 5. BİLİMSEL TOPLANTILAR ── (uluslararası/ulusal ikili değer)
        '5.1' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 24],
        '5.2' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan özet veya poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster', 'Davetli Konuşmacı'], 'puan' => 20],
        '5.4' => ['baslik' => 'Ulusal bilimsel toplantıda sunulan tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 12],
        '5.5' => ['baslik' => 'Ulusal bilimsel toplantıda sunulan özet veya poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 10],

        // ── 6. ULUSLARARASI YAYINEVLERİ ──
        '6.1' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 120],
        '6.2' => ['baslik' => 'Uluslararası yayınevi kitabında bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 50],
        '6.3' => ['baslik' => 'Uluslararası yayınevi kitabında editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 60],
        '6.5' => ['baslik' => 'Uluslararası kitap veya kitap bölümü çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap', 'Çeviri Kitap Bölümü'], 'puan' => 20],

        // ── 7. ULUSAL / DİĞER ULUSLARARASI YAYINEVLERİ ──
        '7.1' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı'], 'puan' => 40],
        '7.2' => ['baslik' => 'Ulusal yayınevi kitabında bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 15],
        '7.3' => ['baslik' => 'Ulusal yayınevi kitabında editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 20],

        // ── 8. TAMAMLANMIŞ PROJELER ──
        '8.1' => ['baslik' => 'Uluslararası destekli tamamlanmış projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 100],
        '8.2' => ['baslik' => 'Uluslararası destekli tamamlanmış projede araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 50],
        '8.3' => ['baslik' => 'TÜBİTAK, TÜSEB veya kamu destekli tamamlanmış projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 70],
        '8.4' => ['baslik' => 'TÜBİTAK, TÜSEB veya kamu destekli tamamlanmış projede araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 35],
        '8.5' => ['baslik' => 'Üniversite (BAP) destekli tamamlanmış proje', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'puan' => 20],

        // ── 9. PATENT, FAYDALI MODEL, TESCİL ──
        '9.1' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 100],
        '9.2' => ['baslik' => 'Ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 60],
        '9.3' => ['baslik' => 'Faydalı model, tasarım veya çeşit tescili', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili', 'Yazılım', 'Ticarileştirme'], 'puan' => 30],

        // ── 10. TAMAMLANMIŞ TEZ DANIŞMANLIĞI ──
        '10.1' => ['baslik' => 'Tamamlanmış doktora veya uzmanlık tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 40],
        '10.2' => ['baslik' => 'Tamamlanmış yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi', 'Tez İzleme / Jüri Üyeliği'], 'puan' => 20],

        // ── 11. ATIFLAR ──
        '11.1' => ['baslik' => 'SCI, SCIE, SSCI, AHCI veya Scopus kapsamında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 5],
        '11.2' => ['baslik' => 'Diğer kaynaklarda yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap', 'TR Dizin', 'Diğer', 'Patent'], 'puan' => 2],

        // ── 12. EĞİTİM-ÖĞRETİM ──
        '12.1' => ['baslik' => 'Verilen ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 10],

        // ── 13. ÖDÜLLER ──
        '13.1' => ['baslik' => 'Uluslararası bilim veya sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 60],
        '13.2' => ['baslik' => 'Ulusal bilim veya sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'YÖK Ödülü', 'Ulusal Bilim/Sanat Ödülü', 'Yarışma Derecesi / Mansiyon'], 'puan' => 30],

        // ── 16. SANATSAL ETKİNLİK ──
        '16.1' => ['baslik' => 'Uluslararası jürili kişisel sanatsal etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)'], 'puan' => 60],
        '16.2' => ['baslik' => 'Ulusal jürili kişisel sanatsal etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)'], 'puan' => 40],
        '16.3' => ['baslik' => 'Karma veya grup sanatsal etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma/Jürili Etkinlik (Ulusal)'], 'puan' => 20],
    ],

    'gruplar' => [
        // Koşulların birebir andığı KATEGORİ ARALIKLARI. Üst sınır alan grubuna
        // göre değişiyor: A 1-14, B 1-15, C 1-16.
        '1-10' => ['1.*', '2.*', '3.*', '4.*', '5.*', '6.*', '7.*', '8.*', '9.*', '10.*'],
        '1-14' => ['1.*', '2.*', '3.*', '4.*', '5.*', '6.*', '7.*', '8.*', '9.*', '10.*', '11.*', '12.*', '13.*'],
        '1-15' => ['1.*', '2.*', '3.*', '4.*', '5.*', '6.*', '7.*', '8.*', '9.*', '10.*', '11.*', '12.*', '13.*'],
        '1-16' => ['*'],
        '16' => ['16.*'],
        // Makale adet koşullarının andığı kategoriler.
        '1.1' => ['1.1-*'],
        '1.1-2.1-3.1' => ['1.1-*', '2.1', '3.1'],
        'MAKALE' => ['1.1-*', '2.1', '3.1', '4.1'],
    ],

    'grup_tavanlari' => [],
];
