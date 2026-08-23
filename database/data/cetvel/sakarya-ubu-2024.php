<?php

/**
 * SAKARYA UYGULAMALI BİLİMLER ÜNİVERSİTESİ — Ek 1. Puanlama Sistemi
 * Kaynak: pdf/17537007382.sakaryauygulamalibilimleruniverstesi.pdf
 *
 * Sakarya Üniversitesi'nden AYRI bir üniversite; yönergesi de bağımsız
 * (cetvel/sakarya-2026.php ile karıştırılmamalı).
 *
 * KOŞULLAR PUAN DEĞİL ADET İSTİYOR. Yönergenin atama koşulları "1.1
 * faaliyetinden en az iki yayın", "3.1-3.4 faaliyetlerinden birini
 * gerçekleştirmek" biçiminde; hiçbir kadroda toplam puan barajı yok. Cetvelin
 * işlevi bu yüzden kalemleri ADLANDIRMAK ve koda bağlamak — puanlar da girildi
 * ama koşulların hiçbiri puana bakmıyor.
 *
 * GİRİLEN BÖLÜMLER: 1 makaleler, 2 bildiriler, 3 kitaplar, 4 projeler,
 * 6 patent, 9 editörlük, 11 atıflar, 13 eğitim-öğretim. Koşulların atıf yaptığı
 * kümeler (1.1, 1.2, 1.3, 3.1-3.4, 4.1-4.4) tamamen kapsanıyor.
 *
 * GİRİLMEYEN: 5 araştırma, 7 sanat etkinlikleri, 8 tasarım, 10 ödül,
 * 12, 14 idari görevler, 15 bilimsel/sanatsal/sportif etkinlikler — kaynak
 * sözlüğünde karşılıkları yok ve koşullar bu bölümlere atıf yapmıyor.
 */

return [
    'kapsam_notu' => 'Puanlar Sakarya Uygulamalı Bilimler Üniversitesi Ek 1 Puanlama Sisteminden. '
        .'Bu yönergede atama koşulları puan barajı değil yayın SAYISI istiyor, o yüzden eksik '
        .'girilen bölümler koşulların sonucunu etkilemiyor. Sanat, tasarım, ödül ve idari görev '
        .'bölümleri kaynak sözlüğünde karşılıksız olduğu için girilmedi.',

    'maddeler' => [
        // ── 1. MAKALELER ──
        '1.1' => ['baslik' => 'SCI, SSCI, SCI-Expanded veya AHCI kapsamındaki dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 100],
        '1.2' => ['baslik' => 'ESCI kapsamındaki dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 80],
        '1.3' => ['baslik' => 'Uluslararası alan endeksli veya TR Dizin kapsamındaki dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'TR Dizin'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 60],
        '1.4' => ['baslik' => 'Diğer hakemli ulusal veya uluslararası dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 40],
        '1.6' => ['baslik' => 'SCI, SSCI, SCI-Expanded veya AHCI dergide teknik not, kısa makale, vaka takdimi veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 40],
        '1.7' => ['baslik' => 'ESCI dergide teknik not, kısa makale, vaka takdimi veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 30],

        // ── 2. BİLDİRİLER ──
        '2.1' => ['baslik' => 'Uluslararası kongrede davetli konuşmacı olarak sunulan tebliğ', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 60],
        '2.2' => ['baslik' => 'Uluslararası kongrede sözlü sunulan ve tam metin yayımlanan tebliğ', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 50],
        '2.4' => ['baslik' => 'Uluslararası kongrede sözlü sunulan ve özet yayımlanan tebliğ', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 30],
        '2.5' => ['baslik' => 'Ulusal kongrede sözlü sunulan ve tam metin yayımlanan tebliğ', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 30],
        '2.7' => ['baslik' => 'Ulusal kongrede sözlü sunulan ve özet yayımlanan tebliğ', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 20],

        // ── 3. KİTAPLAR ──
        '3.1' => ['baslik' => 'Alanında uluslararası yayımlanan bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 100],
        '3.2' => ['baslik' => 'Alanında uluslararası yayımlanan ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı'], 'puan' => 80],
        '3.3' => ['baslik' => 'Alanında ulusal yayımlanan bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 80],
        '3.4' => ['baslik' => 'Alanında yayımlanmış tam kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 80],
        '3.5' => ['baslik' => 'Alanında uluslararası yayımlanan kitap bölümü', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 60],
        '3.7' => ['baslik' => 'Alanında ulusal yayımlanan kitap bölümü', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 40],
        '3.8' => ['baslik' => 'Alanında yayımlanmış kitap bölümü çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 40],
        '3.9' => ['baslik' => 'Alanında ulusal veya uluslararası yayımlanan ansiklopedi maddesi', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 20],

        // ── 4. PROJELER ──
        '4.1' => ['baslik' => 'Dünya Bankası, Avrupa Birliği veya Avrupa Konseyi destekli Ar-Ge projesi', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'puan' => 100],
        '4.2' => ['baslik' => 'Diğer uluslararası kurum veya kuruluş destekli Ar-Ge projesi', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'puan' => 80],
        '4.3' => ['baslik' => 'TÜBA veya TÜBİTAK destekli Ar-Ge projesi', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'puan' => 80],
        '4.4' => ['baslik' => 'Kamu kurumu, özel kuruluş veya üniversite destekli Ar-Ge projesi', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK', 'BAP (Üniversite)'], 'puan' => 80],

        // ── 6. PATENT ──
        '6.1' => ['baslik' => 'Alanında uluslararası tescillenmiş patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 100],
        '6.2' => ['baslik' => 'Alanında ulusal tescillenmiş patent veya faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Faydalı Model', 'Endüstriyel Tasarım'], 'puan' => 80],

        // ── 9. EDİTÖRLÜK ve HAKEMLİK ──
        '9.1' => ['baslik' => 'Uluslararası indeksli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi', 'BKCI Kitap', 'Kitap Editörlüğü'], 'puan' => 100],

        // ── 11. ATIFLAR ──
        '11.1' => ['baslik' => 'Yayınlarınıza yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap', 'TR Dizin', 'Diğer', 'Patent'], 'puan' => 8],

        // ── 13. EĞİTİM-ÖĞRETİM ──
        '13.1' => ['baslik' => 'Verdiğiniz ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi', 'Akreditasyon Faaliyeti'], 'puan' => 10],
    ],

    'gruplar' => [
        // Atama koşullarının birebir andığı kümeler.
        '1.1-1.2' => ['1.1', '1.2'],
        '3.1-3.4' => ['3.1', '3.2', '3.3', '3.4'],
        '4.1-4.4' => ['4.1', '4.2', '4.3', '4.4'],
        'PATENT' => ['6.1', '6.2'],
        'MAKALE' => ['1.*'],
    ],

    'grup_tavanlari' => [],
];
