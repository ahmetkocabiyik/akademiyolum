<?php

/**
 * Akdeniz Üniversitesi — Genel Akademik Faaliyet ve Puan Tablosu
 * Kaynak: pdf/17536928172.akdenizuniversitesi.pdf
 *
 * Madde kodu → (kategori, kaynaklar, roller, puan). Bir faaliyet birden çok
 * maddeye giriyorsa puanı EN YÜKSEK maddeden alınır.
 * Şema ve projeksiyon notları: database/data/sart-agaci-taslak.php
 *
 * ÜST SİMGE DİPNOTU TARAMASI (04.09.2026): eşik tablolarının "En az puan"
 * SÜTUNUNA bağlı üst simge dipnotları okundu. GRUP 3'ün 4 numaralı dipnotu
 * ("Güzel Sanatlar için bu puanın en az %40'ı 1. Bölüm: Bilimsel
 * Makaleler'den") yönergede uygulanıyor; GRUP 4'ün (Devlet Konservatuvarı)
 * 3 numaralı dipnotu 11.4'e işaret ediyor ve o bölümün satırları cetvelde
 * yok — gerekçesi yonerge/akdeniz.php başlığında.
 *
 * DİPNOT TARAMASI (04.09.2026): kaynağın üç ÇARPAN dipnotu — 8. bölümde
 * "puan dersin AKTS'si ile çarpılır", 9. bölümde "öğrenci sayısı ile
 * çarpılır" ve "yurt dışında kalınan ay sayısı ile çarpılır" — motorda
 * karşılıksız. 8. bölüm girildiğinde satırlar bu yüzden TEK BİRİM değeriyle
 * yazıldı (eksik sayma, §0 serbest); 9. bölümün iki çarpanlı satırı ise
 * başka sebeple girilmedi (aşağıda).
 */

/*
 * 11. BÖLÜM: DİSİPLİNE ÖZGÜ ETKİNLİK VE FAALİYETLER (04.09.2026'da girildi)
 *
 * Kaynakta bu bölüm FAKÜLTEYE göre altı ayrı tabloya bölünüyor: 11.1 Spor
 * Bilimleri, 11.2 Mimarlık, 11.3 Edebiyat, 11.4 Güzel Sanatlar + İletişim +
 * Antalya Devlet Konservatuvarı, 11.5 Sağlık Bilimleri, 11.6 İlahiyat.
 * "Her temel bilim alanı KENDİ özel alanından puan alır." Aynı sözlük
 * etiketi tablodan tabloya farklı puan aldığı için (ör. yarışma derecesi
 * sporda 20, mimarlıkta 50, ilahiyatta 50) hepsini tek cetvele koymak
 * `puan()`'ın EN YÜKSEĞİ alması yüzünden herkese en yüksek tabloyu verirdi.
 * Bu yüzden cetvel DİSİPLİNE göre varyantlanıyor; motorun ayırabildiği en
 * ince eksen `alan` olduğu için tablolar temel alana bağlanıyor.
 *
 * 11.5 (Sağlık Bilimleri) 06.09.2026'da girildi. Önce atlanmıştı: iki satırı
 * da "uluslararası/ulusal kuruluşların YÖNETİM KURULLARINDA yer almak" diyor
 * ve sözlükteki tek yakın etiket `Kurul / Komisyon Üyeliği` ÜNİVERSİTE İÇİ
 * kurulları taşıyordu. Korpus taraması aynı kalemin 22 kaynakta puanlandığını
 * gösterince sözlüğe `Dış Kuruluş Kurul Üyeliği` etiketleri eklendi ve bölüm
 * girilebilir oldu.
 */

$ortak = [
    // BOŞ ETİKET LİSTESİ = BİLEREK ÖLÜ SATIR. Sözlükte "ilk %10" kademesi
    // yok; en yakın etiket `SCIE/SSCI (Q1)` ve o 1.2'de duruyor. Etiket
    // buraya da yazılsaydı `puan()` en yükseği aldığı için HER Q1 makalesi
    // 300 yerine 450 sayılırdı (§0). Satır kaynağın kademesini belgelemek
    // için duruyor.
    '1.1' => [
        'baslik' => 'SCI-Expanded/SSCI/AHCI ilk %10 dergide makale',
        'kategori' => 'makale',
        'kaynaklar' => [],
        'puan' => 450,
    ],
    '1.2' => [
        'baslik' => 'SCI-Expanded/SSCI/AHCI Q1 dergide makale',
        'kategori' => 'makale',
        'kaynaklar' => ['SCIE/SSCI (Q1)'],
        'puan' => 300,
    ],
    '1.3' => [
        'baslik' => 'SCI-Expanded/SSCI/AHCI Q2 dergide makale',
        'kategori' => 'makale',
        'kaynaklar' => ['SCIE/SSCI (Q2)', 'AHCI'],
        'puan' => 150,
    ],
    '1.4' => [
        'baslik' => 'SCI-Expanded/SSCI/AHCI Q3 dergide makale',
        'kategori' => 'makale',
        'kaynaklar' => ['SCIE/SSCI (Q3)'],
        'puan' => 90,
    ],
    '1.5' => [
        'baslik' => 'SCI-Expanded/SSCI/AHCI Q4 dergide makale',
        'kategori' => 'makale',
        'kaynaklar' => ['SCIE/SSCI (Q4)'],
        'puan' => 75,
    ],
    // Kaynak ESCI (50) ile SCOPUS'u (30) ayırıyor, sözlükte ise tek
    // `ESCI / Scopus` etiketi var. Etiket 1.7'de duruyor; 1.6 bilerek ölü.
    '1.6' => [
        'baslik' => 'ESCI dergide makale',
        'kategori' => 'makale',
        'kaynaklar' => [],
        'puan' => 50,
    ],
    '1.7' => [
        'baslik' => 'SCOPUS dergide makale',
        'kategori' => 'makale',
        'kaynaklar' => ['ESCI / Scopus'],
        'puan' => 30,
    ],
    '1.8' => [
        'baslik' => 'TR-Dizin dergide makale',
        'kategori' => 'makale',
        'kaynaklar' => ['TR Dizin'],
        'puan' => 15,
    ],
    '1.9' => [
        'baslik' => 'SOBIAD/EBSCO/DOAJ/Index Copernicus dergide makale',
        'kategori' => 'makale',
        'kaynaklar' => ['Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli'],
        'puan' => 10,
    ],
    '2.6' => [
        'baslik' => 'Uluslararası yayınevi kitap editörlüğü/yazarlığı',
        'kategori' => 'kitap',
        'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası/Ulusal Kitap'],
        'puan' => 30,
    ],
    '2.6b' => [
        'baslik' => 'Uluslararası yayınevi kitap bölümü (kitabın yarısı)',
        'kategori' => 'kitap',
        'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'],
        'puan' => 15,
    ],
    '2.7' => [
        'baslik' => 'Ulusal yayınevi kitap editörlüğü/yazarlığı',
        'kategori' => 'kitap',
        'kaynaklar' => ['Tahkik (Tenkitli Metin)'],
        'puan' => 20,
    ],
    '2.7b' => [
        'baslik' => 'Ulusal yayınevi kitap bölümü (kitabın yarısı)',
        'kategori' => 'kitap',
        'kaynaklar' => ['Kitap Bölümü'],
        'puan' => 10,
    ],
    '3.1' => [
        'baslik' => 'SCI-Expanded/SSCI/AHCI dergilerde yapılan atıf',
        'kategori' => 'atif',
        'kaynaklar' => ['WoS / Scopus'],
        'puan' => 5,
    ],
    '3.2' => [
        'baslik' => 'SENSE kategorisindeki kitaplarda yapılan atıf',
        'kategori' => 'atif',
        'kaynaklar' => ['BKCI Kitap'],
        'puan' => 4,
    ],
    '3.3' => [
        'baslik' => 'Diğer kitap/hakemli dergilerde yapılan atıf',
        'kategori' => 'atif',
        'kaynaklar' => ['TR Dizin', 'Diğer', 'Patent'],
        'puan' => 2,
    ],
    '4.2' => [
        'baslik' => 'Uluslararası patent tescili',
        'kategori' => 'patent',
        'kaynaklar' => ['Uluslararası Patent'],
        'puan' => 250,
    ],
    '4.6' => [
        'baslik' => 'Çeşit tescili / ıslahçı hakkı',
        'kategori' => 'patent',
        'kaynaklar' => ['Islahçı Hakkı / Çeşit Tescili'],
        'puan' => 200,
    ],
    '4.3' => [
        'baslik' => 'Ulusal patent tescili',
        'kategori' => 'patent',
        'kaynaklar' => ['Ulusal Patent'],
        'puan' => 50,
    ],
    '4.9' => [
        'baslik' => 'Ticarileştirilmiş endüstriyel/sanatsal/mimari tasarım',
        'kategori' => 'patent',
        'kaynaklar' => ['Endüstriyel Tasarım', 'Yazılım', 'Ticarileştirme'],
        'puan' => 30,
    ],
    '4.10' => [
        'baslik' => 'Ticarileştirilmiş faydalı model',
        'kategori' => 'patent',
        'kaynaklar' => ['Faydalı Model'],
        'puan' => 25,
    ],
    '5.1' => [
        'baslik' => 'Doktora tezi danışmanlığı',
        'kategori' => 'tez_danismanligi',
        'kaynaklar' => ['Doktora Tezi'],
        'puan' => 15,
    ],
    '5.2' => [
        'baslik' => 'Tıpta/diş/sanatta yeterlik tezi danışmanlığı',
        'kategori' => 'tez_danismanligi',
        'kaynaklar' => ['Tıpta/Diş/Sanatta Yeterlik Tezi'],
        'puan' => 10,
    ],
    '5.3' => [
        'baslik' => 'Yüksek lisans tezi danışmanlığı',
        'kategori' => 'tez_danismanligi',
        'kaynaklar' => ['Yüksek Lisans Tezi'],
        'puan' => 7,
    ],
    '6.1' => [
        'baslik' => 'Uluslararası fonlu projede yürütücü/koordinatör',
        'kategori' => 'proje',
        'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'],
        'roller' => ['yurutucu'],
        'puan' => 200,
    ],
    '6.2' => [
        'baslik' => 'Uluslararası fonlu projede araştırıcı',
        'kategori' => 'proje',
        'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'],
        'roller' => ['arastirmaci', 'danisman', 'bursiyer'],
        'puan' => 50,
    ],
    '6.3' => [
        'baslik' => 'Ulusal fonlu projede yürütücü/koordinatör',
        'kategori' => 'proje',
        'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'],
        'roller' => ['yurutucu'],
        'puan' => 50,
    ],
    '6.4' => [
        'baslik' => 'Ulusal fonlu projede araştırmacı veya bursiyer',
        'kategori' => 'proje',
        'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'],
        'roller' => ['arastirmaci', 'danisman', 'bursiyer'],
        'puan' => 15,
    ],
    '6.5' => [
        'baslik' => 'BAP projesinde yürütücü',
        'kategori' => 'proje',
        'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'],
        'roller' => ['yurutucu'],
        'puan' => 20,
    ],
    '6.6' => [
        'baslik' => 'BAP projesinde araştırıcı',
        'kategori' => 'proje',
        'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'],
        'roller' => ['arastirmaci', 'danisman', 'bursiyer'],
        'puan' => 5,
    ],
    '7.1' => [
        'baslik' => 'SCI-Expanded/SSCI/AHCI dergide yayımlanan bildiri',
        'kategori' => 'bildiri',
        'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'],
        'puan' => 8,
    ],
    '7.2' => [
        'baslik' => 'Uluslararası kongrede tam metin bildiri',
        'kategori' => 'bildiri',
        'kaynaklar' => ['Uluslararası Tam Metin', 'Davetli Konuşmacı'],
        'puan' => 4,
    ],
    '7.3' => [
        'baslik' => 'Uluslararası kongrede özet bildiri',
        'kategori' => 'bildiri',
        'kaynaklar' => ['Uluslararası Özet/Poster'],
        'puan' => 2,
    ],
    '7.4' => [
        'baslik' => 'Ulusal kongrede tam metin bildiri',
        'kategori' => 'bildiri',
        'kaynaklar' => ['Ulusal Tam Metin'],
        'puan' => 2,
    ],
    '7.5' => [
        'baslik' => 'Ulusal kongrede özet bildiri',
        'kategori' => 'bildiri',
        'kaynaklar' => ['Ulusal Özet/Poster'],
        'puan' => 1,
    ],
    'T.1' => [
        'baslik' => 'Lisansüstü tezden üretilmiş yayın',
        'kategori' => 'tez_yayini',
        'puan' => 15,
    ],

    /*
     * 8. BÖLÜM: EĞİTİM-ÖĞRETİM VE AKREDİTASYON (04.09.2026'da girildi)
     *
     * 8.1 GİRİLMEDİ. Satır "kadrosunun olduğu birimin AKREDİTE OLMUŞ
     * program(lar)ında eğitim-öğretim faaliyetinde bulunmak" diyor; kayıt
     * programın akredite olup olmadığını taşımıyor. Ders etiketlerine
     * bağlansaydı ders veren HER aday 5 puan (bölüm tavanına kadar 100)
     * alırdı — kaynağın adayların çoğuna vermediği puan (§0). Ayrım satırın
     * KADEMESİNDE değil UYGUNLUĞUNDA olduğu için "en düşüğünü yaz" kısayolu
     * da işlemiyor. 8.3 ve 8.4 girildi: onların dipnotları (ders bilgi
     * paketi/TYYÇ tamamlanmışlığı) başvuru öncesi tamamlanması beklenen
     * usul koşulları, kimin hak ettiğini ayıran bir olgu değil.
     *
     * Dipnot 4 "bu maddeden alınan puan dersin AKTS'si ile çarpılır" diyor;
     * motorun çarpan alanı olmadığı için satırlar TEK BİRİM değeriyle duruyor.
     */
    '8.2' => [
        'baslik' => 'YÖKAK kurumsal/program akreditasyon kurul ve komisyonlarında görev (yıl başına)',
        'kategori' => 'egitim_ogretim',
        'kaynaklar' => ['Akreditasyon Kurulu Görevi'],
        'puan' => 30,
    ],
    '8.3' => [
        'baslik' => 'Yabancı dilde ders vermek',
        'kategori' => 'egitim_ogretim',
        'kaynaklar' => ['Yabancı Dilde Ders'],
        'puan' => 5,
    ],
    '8.4' => [
        'baslik' => 'Ortak diploma programında (lisans/lisansüstü) ders vermek',
        'kategori' => 'egitim_ogretim',
        'kaynaklar' => ['Değişim Programı Dersi'],
        'puan' => 5,
    ],
    // 8.5 "Eğitici Eğitimi Belgesi" 10, 8.6 "Ölçme Değerlendirme Belgesi" 5.
    // İkisi de `Akreditasyon Faaliyeti` etiketinin kapsamında; etiket belge
    // türünü taşımadığı için en düşük kademe yazıldı (§0).
    '8.6' => [
        'baslik' => 'Eğitici eğitimi veya ölçme değerlendirme belgesine sahip olmak',
        'kategori' => 'egitim_ogretim',
        'kaynaklar' => ['Akreditasyon Faaliyeti'],
        'puan' => 5,
    ],

    /*
     * 9. BÖLÜM: ULUSLARARASILAŞMA FAALİYETLERİ VE ÖDÜLLER (04.09.2026)
     *
     * Girilmeyenler ve sebepleri:
     *   9.5/9.6  uluslararası kongre başkanlığı (100) ve sekreterliği (20) —
     *            sözlükte karşılığı yok.
     *   9.7/9.8  KA2 projeleri (100/20) — kayıt AB fonlu proje olarak zaten
     *            6.1 (200) ve 6.2 (50) satırlarına düşüyor, `puan()` en
     *            yükseği aldığı için satır yazmak hiçbir şeyi değiştirmezdi.
     *   9.9/9.10 YABANCI UYRUKLU öğrenci tez danışmanlığı (25/15) — etiket
     *            öğrencinin uyruğunu taşımıyor. Yazılsaydı 5.1 (15) ve 5.3
     *            (7) satırlarını bastırıp HER tez danışmanlığını yükseltirdi.
     *   9.11     yurt dışında gözlem/araştırma (5 x ay) — karşılığı yok.
     *
     * Dipnot 1: "Disipline özgü etkinlik ve faaliyetler alanında aynı ödül
     * alınmış ise YÜKSEK PUANI olan kategori dikkate alınır." Motor zaten
     * öyle çalışıyor; 11.2.3'ün 125 puanlık satırı bu yüzden 9.3'ün altında
     * kalıyor ve bu kaynağın istediği sonuç.
     */
    '9.2' => [
        'baslik' => 'TÜBİTAK/TÜBA bilim, teşvik veya sanat ödülü',
        'kategori' => 'odul',
        // 9.1 (TÜBA, 1000) ile 9.2 (TÜBİTAK, 750) tek etiketi paylaşıyor.
        'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü'],
        'puan' => 750,
    ],
    '9.3' => [
        'baslik' => 'Uluslararası bilim/sanat kurumlarınca verilen bilim, teşvik, hizmet veya araştırma ödülü',
        'kategori' => 'odul',
        'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü'],
        'puan' => 500,
    ],
    '9.4' => [
        'baslik' => 'GEBİP Ödülü',
        'kategori' => 'odul',
        'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü'],
        'puan' => 500,
    ],

    /*
     * 10. BÖLÜM: TOPLUMSAL DESTEK FAALİYETLERİ/PROJELERİ (04.09.2026)
     *
     * 10.1 (bütçeli, en az iki ay süreli proje yürütmek) 100, 10.2 (hedefi ve
     * çıktıları olan proje yürütmek) 20 — tek `Topluma Hizmet Projesi`
     * etiketi ikisini de taşıyor ve bütçe/süre eşiğini ayıramıyor; en düşük
     * kademe yazıldı (§0).
     *
     * 10.3 (SEM'de sertifikalı eğitim, 5, kendi tavanı 100) ve 10.4
     * (üniversite-toplum/endüstri iş birliğinde görev almak, 5) girilmedi:
     * ikisinin de sözlükte temiz karşılığı yok. 10.4'ü `Topluma Hizmet
     * Projesi`ne bağlamak o etiketin kademesini 20'den 5'e düşürürdü.
     */
    '10.2' => [
        'baslik' => 'Hedefi ve çıktıları olan toplumsal destek projesi yürütmek',
        'kategori' => 'toplumsal_katki',
        'kaynaklar' => ['Topluma Hizmet Projesi'],
        'puan' => 20,
    ],
];

$spor = [
    // Kaynak on bir satır sayıyor (11.1.1 Olimpiyat ilk üç 200 → 11.1.11
    // hakemlik 15) ama neredeyse hepsi milli takım antrenörlüğü, federasyon
    // kurul üyeliği ve müsabaka hakemliği — sözlükte karşılığı yok. Yazılan
    // tek satır yarışma derecesi; etiket organizasyonun düzeyini taşımadığı
    // için kademenin EN DÜŞÜĞÜ (11.1.10, Türkiye şampiyonası) alındı (§0).
    // 11.1.7: sözlüğe `Spor Federasyonu Kurul Üyeliği` eklenene kadar
    // karşılıksızdı (06.09.2026).
    '11.1.7' => [
        'baslik' => 'Uluslararası spor federasyonlarında kurul üyeliği',
        'kategori' => 'idari_gorev',
        'kaynaklar' => ['Spor Federasyonu Kurul Üyeliği (Uluslararası)'],
        'puan' => 40,
    ],
    '11.1.10' => [
        'baslik' => 'Antrenörü olduğu sporcunun/takımın Türkiye Şampiyonasında ilk üçe girmesi',
        'kategori' => 'odul',
        'kaynaklar' => ['Yarışma Derecesi / Mansiyon'],
        'puan' => 20,
    ],
];

$mimarlik = [
    // 11.2.1 (uluslararası bilim/proje ödülü) 200 puan ama aynı etiketi
    // 11.2.3 (uluslararası tez ödülü) 125 ile paylaşıyor; en düşüğü yazıldı.
    '11.2.3' => [
        'baslik' => 'Uluslararası kurum/dernek tarafından verilen lisansüstü tez ödülü',
        'kategori' => 'odul',
        'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü'],
        'puan' => 125,
    ],
    '11.2.4' => [
        'baslik' => 'Ulusal kurum/dernek tarafından verilen lisansüstü tez ödülü',
        'kategori' => 'odul',
        'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'],
        'puan' => 75,
    ],
    // Yarışma ödülü üç kademe: uluslararası mesleki örgüt 160, ulusal kamu
    // 100, dernek/özel teşebbüs 50. Etiket düzenleyeni taşımıyor → en düşük.
    '11.2.11' => [
        'baslik' => 'Dernek/birlik yarışmasında ilk üç ödül, mansiyon veya satın alma',
        'kategori' => 'odul',
        'kaynaklar' => ['Yarışma Derecesi / Mansiyon'],
        'puan' => 50,
    ],
    '11.2.6' => [
        'baslik' => 'Uluslararası yarışmada sergilenmeye değer bulunan projede görev almak',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)'],
        'puan' => 80,
    ],
    '11.2.9' => [
        'baslik' => 'Ulusal yarışmada sergilenmeye değer bulunan projede görev almak',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)'],
        'puan' => 60,
    ],
    '11.2.7' => [
        'baslik' => 'Uluslararası yarışmada jüri üyeliği/raportörlük veya bienalde küratörlük',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Jüri Üyeliği (Uluslararası)', 'Sergi Küratörlüğü (Uluslararası)'],
        'puan' => 80,
    ],
    '11.2.12' => [
        'baslik' => 'Dernek/birlik yarışmasında jüri üyeliği veya sergide küratörlük',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Jüri Üyeliği (Ulusal)', 'Sergi Küratörlüğü (Ulusal)'],
        'puan' => 30,
    ],
    '11.2.16' => [
        'baslik' => 'Mimari proje, planlama, tasarım çalışmasında yürütücülük/müelliflik',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Uygulama Projesi — Müellif'],
        'puan' => 80,
    ],
    '11.2.17' => [
        'baslik' => 'Mimari proje, planlama, tasarım çalışmasında ekip üyeliği',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Uygulama Projesi — Ekip'],
        'puan' => 50,
    ],
    '11.2.18' => [
        'baslik' => 'Mimarlık/planlama/tasarım alanında mütalaa, uzman görüşü, bilirkişilik',
        'kategori' => 'toplumsal_katki',
        'kaynaklar' => ['Kamu/STK Danışmanlığı'],
        'puan' => 25,
    ],
    '11.2.19' => [
        'baslik' => 'Uluslararası bienal/trienal sergisinde özgün eserin sergilenmesi',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)'],
        'puan' => 50,
    ],
];

/*
 * 11.3'ün on yedi satırının dokuzu (11.3.1-11.3.5, 11.3.8-11.3.10) kazı ve
 * yüzey araştırması ruhsatı/ekip üyeliği ve hepsi "puan/YIL" — motorun çarpan
 * alanı yok. Ayrıca sözlükte kazı karşılığı da yok; `proje` etiketlerine
 * bağlamak 6. bölümün satırlarıyla çakışıp her kamu projesi araştırıcısına
 * 50 puan verirdi. 11.3.11 (bilim kurulu başkanlığı) da karşılıksız: sözlükte
 * `Kurul / Komisyon Üyeliği` üniversite içi görevleri taşıyor.
 */
$edebiyat = [
    '11.3.6' => [
        'baslik' => 'Uluslararası mesleki organizasyon sergisinde küratörlük',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Sergi Küratörlüğü (Uluslararası)'],
        'puan' => 50,
    ],
    '11.3.7' => [
        'baslik' => 'Ulusal kurum/kamu sergisinde küratörlük',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Sergi Küratörlüğü (Ulusal)'],
        'puan' => 30,
    ],
    '11.3.12' => [
        'baslik' => 'Bilim alanı ile ilgili mütalaa, uzman görüşü ve bilirkişilik',
        'kategori' => 'toplumsal_katki',
        'kaynaklar' => ['Kamu/STK Danışmanlığı'],
        'puan' => 25,
    ],
    // Kaynak ulusal/uluslararası ayırmıyor; iki etiket de aynı puanı alıyor.
    '11.3.13' => [
        'baslik' => 'Bilim alanı ile ilgili belgesel, film, kısa film yazarlığı',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Belgesel/Kısa Film (Uluslararası)', 'Belgesel/Kısa Film (Ulusal)'],
        'puan' => 50,
    ],
    // 11.3.14-11.3.17 dört kademe (çevirili edisyon 75 → çeviri 25). Sözlükte
    // yalnız `Çeviri Kitap` var, edisyon/tenkitli metin ayrımı yok — en düşük
    // kademe yazıldı. `Tahkik (Tenkitli Metin)` bilerek kullanılmadı: o etiket
    // cetvelin 2.7 satırında zaten duruyor ve buraya da yazılsaydı `puan()`
    // en yükseği aldığı için ulusal kitabın puanını 20'den 50'ye çıkarırdı.
    '11.3.17' => [
        'baslik' => 'Antik edebi eser çevirisi',
        'kategori' => 'kitap',
        'kaynaklar' => ['Çeviri Kitap'],
        'puan' => 25,
    ],
];

/*
 * 11.4'ün dipnotu: "Faaliyetlerin ulusal olması durumunda uluslararası puanın
 * %50'si kadar puan alır." Sözlükte ulusal/uluslararası çifti olan etiketlerde
 * iki satır açıldı; çifti OLMAYAN etikette (ör. `Orkestra / Koro Üyeliği`,
 * `Uygulanmış Tasarım / Koleksiyon`) etiket düzeyi taşımadığı için tek satır
 * ULUSAL değerle yazıldı (§0).
 *
 * Girilmeyenler: 11.4.11 ve 11.4.13 (danışmanlığındaki ÖĞRENCİNİN etkinliği —
 * sözlük adayın kendi faaliyetini tutuyor) ve 11.4.15 (gazete/dergi reklamı,
 * 6 puan; tek karşılık adayı 11.4.7'nin 40 puanlık satırıyla çakışacaktı).
 */
$guzelSanatlar = [
    '11.4.1' => [
        'baslik' => 'Eserin yurt dışı koleksiyon/sahnede daimî olarak yer alması',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)'],
        'puan' => 150,
    ],
    '11.4.1u' => [
        'baslik' => 'Eserin yurt içi koleksiyon/sahnede daimî olarak yer alması',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt İçi)'],
        'puan' => 75,
    ],
    '11.4.2' => [
        'baslik' => 'Yurt dışında kişisel etkinlik (sergi, konser, defile, solistlik, sahne performansı)',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)'],
        'puan' => 75,
    ],
    '11.4.2u' => [
        'baslik' => 'Yurt içinde kişisel etkinlik',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Kişisel Etkinlik (Ulusal)'],
        'puan' => 37,
    ],
    '11.4.3' => [
        'baslik' => 'Yurt dışında gösterilen sinema/tiyatro yönetmenliği veya oyun yazarlığı',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Rejisörlük (Uluslararası)'],
        'puan' => 75,
    ],
    '11.4.3u' => [
        'baslik' => 'Yurt içinde gösterilen sinema/tiyatro yönetmenliği veya oyun yazarlığı',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)', 'Yönetmenlik (Sahne/Ekran)'],
        'puan' => 37,
    ],
    '11.4.4' => [
        'baslik' => 'Uluslararası atölye/ustalık sınıfında eğitmenlik veya sergide küratörlük',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Masterclass (Uluslararası)', 'Sergi Küratörlüğü (Uluslararası)'],
        'puan' => 50,
    ],
    '11.4.4u' => [
        'baslik' => 'Ulusal atölye/ustalık sınıfında eğitmenlik veya sergide küratörlük',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Masterclass (Ulusal)', 'Sergi Küratörlüğü (Ulusal)'],
        'puan' => 25,
    ],
    '11.4.5' => [
        'baslik' => 'Eserin satın alınması veya yayın organında/sahnede gösterime girmesi',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Satın Alınması (Yurt İçi)'],
        'puan' => 25,
    ],
    '11.4.6' => [
        'baslik' => 'Yurt dışında grup etkinliğine katılmak (en fazla beş kişilik)',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Grup Etkinliği (Uluslararası)'],
        'puan' => 40,
    ],
    '11.4.6u' => [
        'baslik' => 'Yurt içinde grup etkinliğine katılmak',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Grup Etkinliği (Ulusal)'],
        'puan' => 20,
    ],
    '11.4.7' => [
        'baslik' => 'Uluslararası kampanyada sanatsal tasarım, reklam yazarlığı, yürütücülük',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Reklam / Tanıtım Filmi (Uluslararası)'],
        'puan' => 40,
    ],
    '11.4.7u' => [
        'baslik' => 'Ulusal kampanyada sanatsal tasarım, reklam yazarlığı, yürütücülük',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Reklam / Tanıtım Filmi (Ulusal)'],
        'puan' => 20,
    ],
    '11.4.8' => [
        'baslik' => 'Yurt dışında gösterilen belgesel/kısa filmde yaratıcı kadroda görev',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Belgesel/Kısa Film (Uluslararası)'],
        'puan' => 40,
    ],
    '11.4.8u' => [
        'baslik' => 'Yurt içinde gösterilen belgesel/kısa filmde yaratıcı kadroda görev',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Belgesel/Kısa Film (Ulusal)'],
        'puan' => 20,
    ],
    '11.4.9' => [
        'baslik' => 'Uluslararası yarışmada jüri üyeliği',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Jüri Üyeliği (Uluslararası)'],
        'puan' => 35,
    ],
    '11.4.9u' => [
        'baslik' => 'Ulusal yarışmada jüri üyeliği',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Jüri Üyeliği (Ulusal)'],
        'puan' => 17,
    ],
    '11.4.10' => [
        'baslik' => 'Uluslararası karma/toplu etkinliğe eseriyle katılmak',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)'],
        'puan' => 35,
    ],
    '11.4.10u' => [
        'baslik' => 'Ulusal karma/toplu etkinliğe eseriyle katılmak',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)'],
        'puan' => 17,
    ],
    // 11.4.10 ile 11.4.19 aynı etikete düşüyor (orkestra/koro üyeliği 35 ve
    // müzik topluluğunda icra 40); etiket ulusal/uluslararası taşımadığı için
    // en düşük kademenin ulusal karşılığı yazıldı.
    '11.4.10o' => [
        'baslik' => 'Orkestra/koro/müzik topluluğunda icracı olarak yer almak',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Orkestra / Koro Üyeliği'],
        'puan' => 17,
    ],
    // 11.4.12 (multimedya/kapak tasarımı, 40) ve 11.4.14 (afiş/katalog görsel
    // tasarımı, 20) tek etiket paylaşıyor; ulusal indirimiyle birlikte 10.
    '11.4.14' => [
        'baslik' => 'Basılmış/yayımlanmış afiş, katalog, broşür görsel tasarımı',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Uygulanmış Tasarım / Koleksiyon'],
        'puan' => 10,
    ],
    '11.4.16' => [
        'baslik' => 'Alanıyla ilgili eğitim metodu / ders kitabı yazarlığı (en az 100 sayfa)',
        'kategori' => 'kitap',
        'kaynaklar' => ['Ders / Metot Kitabı'],
        'puan' => 75,
    ],
    '11.4.17' => [
        'baslik' => 'Yurt dışında eserin icra edilmesi/sahnelenmesi (tam konser/tiyatro gösterimi)',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Resital (Uluslararası)'],
        'puan' => 75,
    ],
    '11.4.17u' => [
        'baslik' => 'Yurt içinde eserin icra edilmesi/sahnelenmesi',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Resital (Ulusal)'],
        'puan' => 37,
    ],
    '11.4.18' => [
        'baslik' => 'Özgün orkestrasyon/düzenleme/eğitim müziği nota kitabı, reji defteri',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Orkestrasyon/Transkripsiyon', 'Eğitim Müziği Düzenlemesi', 'Eğitim Müziği Albümü'],
        'puan' => 25,
    ],
    '11.4.20' => [
        'baslik' => 'Özgün müzik kompozisyonu (en az 15 dakikalık kayıt)',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Özgün Eser / Beste / Tasarım', 'Oda/Koro Müziği Eseri (≥15 dk)', 'Elektronik Müzik Eseri (≥15 dk)'],
        'puan' => 25,
    ],
];

/*
 * 11.6'nın dipnotu 11.4'ünkiyle aynı: ulusal faaliyet uluslararası puanın
 * %50'sini alır (11.6.2, 11.6.3 ve 11.6.5'te). 11.6.1'in kendi tavanı var:
 * "Bu etkinlikten en fazla 50 puan alınabilir."
 */
/*
 * 11.5 SAĞLIK BİLİMLERİ FAKÜLTESİ — iki satır, ikisi de kurum DIŞI kurul
 * görevi. Dipnotu yok; uluslararası 35, ulusal 20.
 */
$saglik = [
    '11.5.1' => [
        'baslik' => 'Sağlık hizmetleriyle ilgili uluslararası kuruluşun yönetim kurulunda yer almak',
        'kategori' => 'idari_gorev',
        'kaynaklar' => ['Dış Kuruluş Kurul Üyeliği (Uluslararası)'],
        'puan' => 35,
    ],
    '11.5.2' => [
        'baslik' => 'Sağlık hizmetleriyle ilgili ulusal kuruluşun yönetim kurulunda yer almak',
        'kategori' => 'idari_gorev',
        'kaynaklar' => ['Dış Kuruluş Kurul Üyeliği (Ulusal)'],
        'puan' => 20,
    ],
];

$ilahiyat = [
    '11.6.1' => [
        'baslik' => 'Alanıyla ilgili TV ve radyo programlarında konuşmacı olarak görev yapmak',
        'kategori' => 'toplumsal_katki',
        'kaynaklar' => ['Bilim İletişimi / Popüler Yayın'],
        'puan' => 10,
    ],
    '11.6.2' => [
        'baslik' => 'Uluslararası Kur\'an-ı Kerim okuma ve hafızlık yarışmasında jüri üyeliği',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Jüri Üyeliği (Uluslararası)'],
        'puan' => 60,
    ],
    '11.6.2u' => [
        'baslik' => 'Ulusal Kur\'an-ı Kerim okuma ve hafızlık yarışmasında jüri üyeliği',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Jüri Üyeliği (Ulusal)'],
        'puan' => 30,
    ],
    // Uluslararası 100; etiket düzeyi taşımadığı için ulusal karşılığı yazıldı.
    '11.6.3' => [
        'baslik' => 'Kur\'an-ı Kerim okuma ve hafızlık yarışmasında ilk üç derece',
        'kategori' => 'odul',
        'kaynaklar' => ['Yarışma Derecesi / Mansiyon'],
        'puan' => 50,
    ],
    '11.6.4' => [
        'baslik' => 'Türk Din Musikisi alanında özgün kompozisyon nota kitabı veya büyük ölçekli eser',
        'kategori' => 'sanatsal_etkinlik',
        'kaynaklar' => ['Özgün Eser / Beste / Tasarım'],
        'puan' => 50,
    ],
    '11.6.5' => [
        'baslik' => 'Alanıyla ilgili eğitim metodu / ders kitabı veya bölüm yazarlığı (en az 100 sayfa)',
        'kategori' => 'kitap',
        'kaynaklar' => ['Ders / Metot Kitabı'],
        'puan' => 15,
    ],
];

$onbir = [
    'spor' => $spor,
    'mimarlik' => $mimarlik,
    'edebiyat' => $edebiyat,
    // Edebiyat ve İletişim fakültelerinin ikisi de kaynakta GRUP 2'de ve
    // ikisi de `sosyal` temel alanına düşüyor; İletişim Fakültesi 11.4
    // tablosunu Güzel Sanatlar ve Konservatuvarla paylaşıyor.
    //
    // İki tablo tek varyantta birleşince ÜÇ ETİKET ÇAKIŞIYOR ve 11.3 tarafı
    // yüksek kalıyor; `puan()` en yükseği aldığı için İletişim adayı kaynağın
    // vermediği puanı alırdı. Çakışan iki satır bu varyanttan çıkarıldı (§0):
    //   Belgesel/Kısa Film       11.3.13 50 ↔ 11.4.8 40 · 11.4.8u 20
    //   Sergi Küratörlüğü (Ulusal) 11.3.7 30 ↔ 11.4.4u 25
    // İkisi de `edebiyat` varyantında (filoloji) olduğu gibi duruyor; orada
    // 11.4 tablosu yok, dolayısıyla çakışma da yok.
    'sosyal' => [
        ...array_diff_key($edebiyat, array_flip(['11.3.7', '11.3.13'])),
        ...$guzelSanatlar,
    ],
    'guzel-sanatlar' => $guzelSanatlar,
    'ilahiyat' => $ilahiyat,
    'saglik' => $saglik,
];

/**
 * @param  string  $disiplin  '' ise 11. bölüm yok
 * @return array<string, mixed>
 */
$govde = function (string $disiplin, int $onbirTavan) use ($ortak, $onbir): array {
    $maddeler = $ortak;
    $gruplar = [
        'BOLUM_1_MAKALE' => ['1.*'],
        'BOLUM_2_KITAP' => ['2.*'],
        'BOLUM_3_ATIF' => ['3.*'],
        'BOLUM_4_PATENT' => ['4.*'],
        'BOLUM_5_TEZ' => ['5.*'],
        'BOLUM_6_PROJE' => ['6.*'],
        'BOLUM_7_BILDIRI' => ['7.*'],
        'BOLUM_8_EGITIM' => ['8.*'],
        'BOLUM_9_ULUSLARARASI' => ['9.*'],
        'BOLUM_10_TOPLUMSAL' => ['10.*'],
        'YAYIN' => ['1.*', '2.*', 'T.1'],

        // 3. bölümün dipnot 1'i iki ayrı tavan koyuyor; alt tavan yalnız
        // 3.2 ve 3.3'e ait, 3.1 (WoS atfı) onun dışında.
        'ATIF_KITAP_DIGER' => ['3.2', '3.3'],
    ];

    /*
     * Tablo dipnotlarındaki bölüm tavanları. Dördü de 01.09.2026'ya kadar
     * girilmemişti (dosyada `grup_tavanlari` anahtarı hiç yoktu); tavansız
     * bölüm doğrudan fazla saydırır (§0).
     *
     * 9. ve 10. bölümlerin bölüm geneli tavanı YOK (kaynak koymuyor);
     * 10.3'ün kendi 100'lük tavanı o satır girilmediği için karşılıksız.
     * h-indeksi tavanı (200) da öyle: 3.5 maddesi girilmedi. Proje bütçesi
     * ek puanının 150'lik tavanı ek puanın kendisi modellenmediği için
     * uygulanmıyor.
     */
    $tavanlar = [
        // "3.2 ve 3.3 kategorilerinden en fazla 120 puan ve toplam atıf
        // puanından h-indeksi hariç en fazla 250 puan alınabilir."
        'ATIF_KITAP_DIGER' => 120,
        'BOLUM_3_ATIF' => 250,

        // 4. bölüm başlığının taşıdığı dipnot 2: "Bu alandan en fazla 200
        // puan alınır." Dipnot hem başlıkta hem 4.10-4.11'de anılıyor; iki
        // satırlık okuma (25 puanlık maddelere 200 tavanı) anlamsız kalacağı
        // için bölüm geneli alındı — aynı zamanda sıkı olan okuma (§0).
        'BOLUM_4_PATENT' => 200,

        // 7. bölüm dipnot 1: "bu kategorideki eserlerden en fazla 20 puan".
        'BOLUM_7_BILDIRI' => 20,

        // 8. bölüm dipnot 1: "Bu kategoriden en fazla 100 puan alınır."
        // Üst simge yalnız 8.1'de duruyor ama "kategori" bölümün kendisi;
        // bölüm geneline yazmak aynı zamanda sıkı olan okuma (§0).
        'BOLUM_8_EGITIM' => 100,
    ];

    if ($disiplin !== '') {
        $maddeler = [...$maddeler, ...$onbir[$disiplin]];
        $gruplar['BOLUM_11_DISIPLIN'] = ['11.*'];

        // GRUP 4'ün (Devlet Konservatuvarı) barajı doğrudan 11.4'ü anıyor.
        if ($disiplin === 'guzel-sanatlar') {
            $gruplar['BOLUM_11_4'] = ['11.4.*'];
        }

        // Tavan 0 verilirse bölüm tavansız kalıyor; yalnız konservatuvar
        // varyantı böyle (gerekçesi aşağıda).
        if ($onbirTavan > 0) {
            $tavanlar['BOLUM_11_DISIPLIN'] = $onbirTavan;
        }

        if ($disiplin === 'ilahiyat') {
            // 11.6.1: "Bu etkinlikten en fazla 50 puan alınabilir."
            $gruplar['BOLUM_11_MEDYA'] = ['11.6.1'];
            $tavanlar['BOLUM_11_MEDYA'] = 50;
        }
    }

    return [
        'maddeler' => $maddeler,
        'gruplar' => $gruplar,
        'grup_tavanlari' => $tavanlar,
    ];
};

/*
 * 11. BÖLÜMÜN TAVANI: "diğer bölümlerden alınan puanın %40'ı" — YÜZDE TAVANI
 * ASGARİ PUANDAN SABİTE ÇEVRİLDİ.
 *
 * Bölüm başlığı "Bu bölümden alınan puan diğer bölümlerden alınan puanın
 * %40'ını geçemez" diyor. Taban adayın KENDİ puanı olduğu için motorun sabit
 * `grup_tavanlari`'ına doğrudan yazılamaz. Ama her Akdeniz eşiği makaleden
 * SABİT bir taban istiyor: "En az puan" sütununun dipnotu "bu puanın en az
 * yarısı 1. Bölüm'den" diyor ve "bu puan" sütundaki ASGARİ PUAN (Güzel
 * Sanatlarda %40). Makale 11. bölümün dışında olduğuna göre, eşiği sağlayan
 * her adayda
 *
 *     diğer bölümler ≥ makale ≥ oran × asgari puan
 *
 * ve dolayısıyla kaynağın izin verdiği tavan ≥ %40 × oran × asgari puan.
 * Bu ALT SINIR sabit; yazıldığında hiçbir adayda fazla saymaz, kaynağın daha
 * cömert davrandığı yerde eksik sayar (§0 serbest). 11. bölümden en az puan
 * isteyen bir baraj olmadığı için tavan hiçbir eşiği sağlanamaz kılmıyor.
 *
 *   Dr. Öğr. Üyesi 100 · Doçent 300 · Profesör 500 asgari puan
 *   oran %50 → tavan 20 · 60 · 100      oran %40 (Güzel Sanatlar) → 16 · 48 · 80
 */
$KADRO = ['dr' => 100, 'docent' => 300, 'profesor' => 500];

$cetveller = ['akdeniz-2026' => $govde('', 0)];

foreach (['spor', 'mimarlik', 'edebiyat', 'sosyal', 'ilahiyat', 'saglik'] as $disiplin) {
    foreach ($KADRO as $kadro => $asgari) {
        $cetveller["akdeniz-2026-{$disiplin}-{$kadro}"] = $govde($disiplin, (int) (0.4 * 0.5 * $asgari));
    }
}

foreach ($KADRO as $kadro => $asgari) {
    $cetveller["akdeniz-2026-guzel-sanatlar-{$kadro}"] = $govde('guzel-sanatlar', (int) (0.4 * 0.4 * $asgari));
}

/*
 * KONSERVATUVAR VARYANTI: 11. BÖLÜM TAVANSIZ (04.09.2026).
 *
 * GRUP 4 (Devlet Konservatuvarı) tablosunun "En az puan" dipnotu şöyle: "Bu
 * puanın en az yarısı 11.4 Disipline Özgü Etkinlik ve Faaliyetler'den
 * karşılanmış olmalıdır." 11. bölüm başlığı ise "Bu bölümden alınan puan
 * diğer bölümlerden alınan puanın %40'ını geçemez" diyor. İKİSİ AYNI ANDA
 * SAĞLANAMAZ: %40 kuralı 11. bölümü toplamın en çok %28,6'sında tutar, GRUP
 * 4 ise en az %50'sini ister.
 *
 * KAYNAKTAKİ ÇELİŞKİ DÜZELTİLMİYOR, KAYDEDİLİYOR — ama eşiği sağlanamaz
 * bırakmak fazla saymaktan da kötü ("Sağlanamaz eşik yazma" istisnası). Bu
 * varyantta ÖZEL kural (GRUP 4 dipnotu) genel kurala (bölüm başlığı) tercih
 * edildi ve 11. bölüm tavansız bırakıldı; öteki varyantlarda tavan yerinde
 * duruyor. Aday notunda çelişki birebir aktarılıyor.
 */
foreach ($KADRO as $kadro => $asgari) {
    $cetveller["akdeniz-2026-konservatuvar-{$kadro}"] = $govde('guzel-sanatlar', 0);
}

return ['cetveller' => $cetveller];
