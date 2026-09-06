<?php

/**
 * HAKKARİ ÜNİVERSİTESİ — EK-1: Öğretim Üyeliğine Atama ve Yükseltme Etkinlik
 * Puanları
 * Kaynak: pdf/17536995622.hakkariuniverstesi.pdf
 *
 * KORPUSTAKİ EN SADE KOŞUL YAPISI: yönerge alt baraj, kategori aralığı ya da
 * dönem kırılımı istemiyor. Tek bir cümle — "Ek-1'de belirtilen puanlama
 * tablosundaki faaliyetlerden toplam en az N puan" — ve N kadroya göre değişiyor
 * (Dr. 30, profesör 150). Doçentlikte hiç puan koşulu yok.
 *
 * BARAJLAR KORPUSUN EN DÜŞÜKLERİ: Dr. Öğr. Üyeliği için 30 puan, tek bir SCI
 * makalesinin (40) altında. Bu, üniversitenin öğretim üyesi teminindeki
 * güçlüğü kabul eden Madde 6 ile tutarlı; o madde puan şartının Yönetim Kurulu
 * kararıyla hiç aranmayabileceğini de söylüyor.
 *
 * YAZAR ÇARPANI ÜÇ KADEMELİ (Yayınlarda Puanlama): ilk üç isim %100, dördüncü
 * isim %70, beşinci ve sonrası %50. Yazar sayısı rol oynamıyor.
 *
 * AYNI KAYNAĞA DÜŞEN KALEMLERDE DÜŞÜK OLAN GİRİLDİ:
 *   'Kitap Editörlüğü' uluslararası/ulusal ayırmıyor → E1.1 (50) yerine
 *       E2.1 (20).
 *   'Hakemlik' dergi düzeyi taşımıyor → E2.5 (3).
 *   'Davetli Konuşmacı' ulusal/uluslararası ayırmıyor → C2.1 (15).
 *   'Burs' kaynağı ödül kalemlerinde karşılıksız → girilmedi.
 *
 * GİRİLMEYEN KALEMLER: A4 (ansiklopedi ve mesleki dergi yazıları), B4
 * (ders notu, broşür), C1.5/C2.5 (oturum başkanlığı), I bölümünün sergi
 * düzenleyiciliği ve yarışma jüriliği kalemleri, J2 (koordinatörlükler).
 *
 * 06.09.2026: bilimsel toplantı organizasyonu ailesi için altı etiket
 * açıldı (başkanlık · düzenleme/bilim kurulu üyeliği · oturum başkanlığı,
 * her biri uluslararası/ulusal). Yukarıdaki "sözlükte karşılıksız" notları
 * bu satırlar için artık geçerli değil.
 */

return [
    'kapsam_notu' => 'Puanlar Hakkari Üniversitesi EK-1 tablosundan. Puan yazar SIRANIZA göre '
        .'azaltılır (ilk üç isim %100, dördüncü %70, beşinci ve sonrası %50); yazar sayısı rol '
        .'oynamıyor. Hakkari yönergesi Madde 6\'da, öğretim üyesi temininde güçlük çekilen '
        .'kadrolarda puan şartının Yönetim Kurulu kararıyla hiç aranmayabileceğini söylüyor.',

    // Yayınlarda Puanlama — çarpan yalnızca sıraya bağlı.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'proje', 'patent', 'editorluk', 'egitim_ogretim',
            'tez_danismanligi', 'idari_gorev', 'toplumsal_katki'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.0]],
            'ilk' => ['sonrasi' => 1.0],
            'baslica' => ['sonrasi' => 1.0],
            'yazar_2' => ['sonrasi' => 1.0],
            'yazar_3' => ['sonrasi' => 1.0],
            'yazar_4' => ['sonrasi' => 0.70],
            'yazar_5' => ['sonrasi' => 0.50],
            'yazar_6' => ['sonrasi' => 0.50],
            'ortak' => ['kademeler' => [1 => 1.0, 2 => 1.0, 3 => 1.0, 4 => 0.70], 'sonrasi' => 0.50],
        ],
    ],

    'maddeler' => [
        // ══ A — MAKALELER ══
        'A1.1' => ['baslik' => 'SCI, SCI-Expanded, ESCI, SSCI veya AHCI dergide derleme ya da araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI', 'ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 40],
        'A1.2' => ['baslik' => 'Diğer uluslararası indeksli dergide derleme ya da özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 25],
        'A1.3' => ['baslik' => 'SCI, ESCI, SSCI veya AHCI dergide teknik not, vaka takdimi ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI', 'ESCI / Scopus'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 15],
        'A1.4' => ['baslik' => 'Diğer uluslararası dergide teknik not, vaka takdimi ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 8],
        'A2.1' => ['baslik' => 'Ulusal hakemli dergide yayımlanan araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale'], 'puan' => 20],
        'A2.2' => ['baslik' => 'Ulusal hakemli dergide yayımlanan vaka takdimi veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['derleme', 'vaka_teknik_not', 'kisa_makale'], 'puan' => 8],
        'A3' => ['baslik' => 'Diğer dergilerde yayımlanan makale, çeviri veya vaka takdimi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme', 'vaka_teknik_not', 'kisa_makale'], 'puan' => 5],

        // ══ B — KİTAPLAR VE ÇEVİRİLER ══
        'B1.1' => ['baslik' => 'Alanında uluslararası kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 60],
        'B1.2' => ['baslik' => 'Alanında uluslararası kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 30],
        'B2.1' => ['baslik' => 'Alanında ulusal kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı'], 'puan' => 40],
        'B2.2' => ['baslik' => 'Alanında ulusal kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 20],
        'B2.3' => ['baslik' => 'Ansiklopedide madde yazarlığı (en fazla üç madde)', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 5],
        'B3.1' => ['baslik' => 'Alanında kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 40],
        'B3.2' => ['baslik' => 'Alanında kitapta bölüm çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 20],

        // ══ C — BİLİMSEL TOPLANTILAR ══
        'C1.2' => ['baslik' => 'Uluslararası toplantıda sözlü sunulan ve tam metni yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Uluslararası Tam Metin (CPCI)'], 'puan' => 15],
        'C1.3' => ['baslik' => 'Uluslararası toplantıda özeti yayımlanan bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 10],
        'C2.1' => ['baslik' => 'Bilimsel toplantıda davetli konuşmacı veya panelist olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 15],
        'C2.2' => ['baslik' => 'Ulusal toplantıda sözlü sunulan ve tam metni yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 10],
        'C2.3' => ['baslik' => 'Ulusal toplantıda özeti yayımlanan bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 8],

        // ══ D — PROJELER VE PATENTLER ══
        'D1.1' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 70],
        'D1.2' => ['baslik' => 'Uluslararası faydalı model veya ürün tescili', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 50],
        'D1.3' => ['baslik' => 'Uluslararası kuruluşlarca desteklenmiş projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 50],
        'D1.4' => ['baslik' => 'Uluslararası kuruluşlarca desteklenmiş projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 30],
        'D2.1' => ['baslik' => 'Ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 50],
        'D2.3' => ['baslik' => 'Ulusal kuruluşlarca desteklenmiş projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 40],
        'D2.4' => ['baslik' => 'Ulusal kuruluşlarca desteklenmiş projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 25],
        'D2.5' => ['baslik' => 'Üniversite araştırma projesinde (BAP) yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 25],
        'D2.6' => ['baslik' => 'Üniversite araştırma projesinde (BAP) araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 15],

        // ══ E — EDİTÖRLÜK, YAYIN KURULU, HAKEMLİK ══
        'E1.2' => ['baslik' => 'SCI, SCI-Expanded, ESCI, SSCI veya AHCI dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 30],
        'E1.3' => ['baslik' => 'Diğer indeksli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 20],
        'E2.1' => ['baslik' => 'Alanında bilimsel kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü', 'BKCI Kitap'], 'puan' => 20],
        'E2.2' => ['baslik' => 'Ulusal hakemli dergide editörlük veya yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Yayın Kurulu Üyeliği'], 'puan' => 15],
        'E2.5' => ['baslik' => 'Dergi hakemliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 3],

        // ══ F — BİLİMSEL ATIFLAR (kendine atıf hariç) ══
        'F1.1' => ['baslik' => 'SCI, SCI-Expanded, ESCI, SSCI veya AHCI dergisinde atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 5],
        'F1.3' => ['baslik' => 'Bilimsel kitapta atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 3],
        'F2.1' => ['baslik' => 'Ulusal hakemli dergide atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 3],
        'F2.3' => ['baslik' => 'Diğer bilimsel veya mesleki dergide atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer'], 'puan' => 2],

        // ══ G — ÖDÜLLER ══
        'G1.1' => ['baslik' => 'Alanında uluslararası kuruluşlarca verilen bilim ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 30],
        'G1.2' => ['baslik' => 'Alanında uluslararası kuruluşlarca verilen proje ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 25],
        'G2.1' => ['baslik' => 'Alanında yurt içi kurum ve kuruluşlarca verilen bilim ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü'], 'puan' => 20],

        // ══ H — EĞİTİM-ÖĞRETİM FAALİYETLERİ ══
        'H1.1' => ['baslik' => 'Tamamlanmış doktora, tıpta uzmanlık veya sanatta yeterlik tezi yönetmek', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 30],
        'H1.3' => ['baslik' => 'Tamamlanmış yüksek lisans tezi yönetmek', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 15],
        // H1.5: ikinci danışmanlık için puanların yarısı.
        'H1.5a' => ['baslik' => 'Doktora tezinde ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 15],
        'H1.5b' => ['baslik' => 'Yüksek lisans tezinde ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 7],
        'H2.4' => ['baslik' => 'Tez, yeterlik veya atama jürisinde görev almak', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 2],
        'H4.1' => ['baslik' => 'Lisansüstü seviyede verilen ders (dönem ve ders başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 2],
        'H4.2' => ['baslik' => 'Lisans veya ön lisans seviyesinde verilen ders (dönem ve ders başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 1],

        // ══ I — SERGİ VE SANATSAL FAALİYETLER ══
        'I1.5' => ['baslik' => 'Uluslararası düzeyde seçimli veya davetli sergi, gösteri ya da uygulama', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma/Jürili Etkinlik (Uluslararası)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Resital (Uluslararası)', 'Solistlik (Uluslararası)', 'Elektronik Kişisel Sergi (Uluslararası)'], 'puan' => 30],
        'I1.6' => ['baslik' => 'Ulusal düzeyde seçimli veya davetli sergi, gösteri ya da uygulama', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Karma/Jürili Etkinlik (Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Resital (Ulusal)', 'Solistlik (Ulusal)', 'Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 15],
        'I1.7' => ['baslik' => 'Yurt dışı grup veya karma sergiye eseriyle katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Elektronik Karma Sergi (Uluslararası)'], 'puan' => 20],
        'I1.8' => ['baslik' => 'Yurt içi grup veya karma sergiye eseriyle katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Jürisiz, Ulusal)', 'Elektronik Karma Sergi (Ulusal)'], 'puan' => 10],

        // ══ J — ÜNİVERSİTE YÖNETİMİNE KATKILAR ══
        'J1.1' => ['baslik' => 'Dekanlık, yüksekokul veya enstitü müdürlüğü (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü', 'Rektör', 'Rektör Yardımcısı'], 'puan' => 3],
        'J1.2' => ['baslik' => 'Dekan yardımcılığı, bölüm başkanlığı veya müdür yardımcılığı (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.', 'Bölüm Başkanı', 'Bölüm Başkan Yardımcısı', 'Uygulama ve Araştırma Merkezi Müdürü', 'Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 2],
        'J2.1' => ['baslik' => 'Senato, kurul veya komisyon üyeliği (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği', 'Senato / Üniversite Yönetim Kurulu Üyesi'], 'puan' => 1],
        'E2.3' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)', 'Toplantı Düzenleme Başkanlığı (Ulusal)'], 'puan' => 15],
        'E2.4' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 5],
        'C2.5' => ['baslik' => 'Bilimsel toplantıda oturum başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Uluslararası)', 'Oturum Başkanlığı (Ulusal)'], 'puan' => 3],
    ],

    // Koşullar tablonun tamamını sayıyor; alt küme tanımlamaya gerek yok.
    'gruplar' => [],

    'grup_tavanlari' => [],
];
