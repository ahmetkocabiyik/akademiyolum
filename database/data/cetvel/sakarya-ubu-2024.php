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
        // KODLAR BİR SATIR KAYMIŞTI. Kaynağın gerçek sırası: 2.1 uluslararası
        // davetli 60 · 2.2 ULUSAL DAVETLİ 50 · 2.3 uluslararası sözlü tam
        // metin 40 · 2.4 ulusal sözlü tam metin 30 · 2.5 uluslararası sözlü
        // özet 30 · 2.6 uluslararası poster 20 · 2.7 ulusal sözlü özet 20 ·
        // 2.8 ulusal poster 10. Cetvelde `Uluslararası Tam Metin` 2.2'nin
        // (ulusal davetli) 50 puanını taşıyordu.
        //
        // SÖZLÜ/POSTER ekseni sözlükte yok: `Özet/Poster` etiketi hem özet
        // hem poster satırlarını taşıdığı için ikisinin en düşüğünü alır
        // (uluslararası 20, ulusal 10). `Davetli Konuşmacı` kapsam
        // taşımadığı için ulusal değeri (50) geçerli.
        '2.1-2.2' => ['baslik' => 'Kongre ya da sempozyumda davetli konuşmacı olarak sunulan tebliğ', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 50],
        '2.3' => ['baslik' => 'Uluslararası kongrede sözlü sunulan ve tam metin yayımlanan tebliğ', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 40],
        '2.5-2.6' => ['baslik' => 'Uluslararası kongrede sözlü sunulup özeti yayımlanan ya da poster olarak sunulan tebliğ', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 20],
        '2.4' => ['baslik' => 'Ulusal kongrede sözlü sunulan ve tam metin yayımlanan tebliğ', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 30],
        '2.7-2.8' => ['baslik' => 'Ulusal kongrede sözlü sunulup özeti yayımlanan ya da poster olarak sunulan tebliğ', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 10],

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
        // Kaynakta 4.4 Kalkınma Bakanlığı (80), 4.5 diğer kamu kuruluşları (80),
        // 4.6 yükseköğretim kurumu/BAP (40), 4.7 özel kuruluş (40) diye AYRI
        // satırlar. Cetvelde dördü tek 80 puanlık satırdaydı: BAP ve özel sektör
        // projeleri hem 40 fazla puan alıyor hem de yönergenin "4.1, 4.2, 4.3,
        // 4.4 proje faaliyetlerinden en az bir proje" koşulunu sahte biçimde
        // sağlıyordu. 'Diğer Kamu Kurumu' 4.5'e alındı: kayıt Kalkınma
        // Bakanlığı'nı öteki kamu kuruluşlarından ayırmıyor ve §0 uyarınca
        // koşulu sağlayan tarafa yazılamaz (01.09.2026).
        '4.5' => ['baslik' => 'Diğer kamu kuruluşlarınca desteklenmiş Ar-Ge projesi', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'puan' => 80],
        '4.6' => ['baslik' => 'Yükseköğretim kurumunca desteklenmiş bilimsel araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'puan' => 40],
        '4.7' => ['baslik' => 'Özel kuruluşların Ar-Ge, yenilik veya özgün tasarım projesi', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'puan' => 40],

        // ── 6. PATENT ──
        '6.1' => ['baslik' => 'Alanında uluslararası tescillenmiş patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 100],
        '6.2' => ['baslik' => 'Alanında ulusal tescillenmiş patent veya faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Faydalı Model', 'Endüstriyel Tasarım'], 'puan' => 80],

        // ── 9. EDİTÖRLÜK ve HAKEMLİK ──
        '9.1' => ['baslik' => 'Uluslararası indeksli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi', 'BKCI Kitap', 'Kitap Editörlüğü'], 'puan' => 100],

        // ── 11. ATIFLAR ──
        '11.1' => ['baslik' => 'Yayınlarınıza yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap', 'TR Dizin', 'Diğer', 'Patent'], 'puan' => 8],

        // ── 13. EĞİTİM-ÖĞRETİM ──
        '13.1' => ['baslik' => 'Verdiğiniz ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 10],
    ],

    'gruplar' => [
        // Atama koşullarının birebir andığı kümeler.
        '1.1-1.2' => ['1.1', '1.2'],
        '3.1-3.4' => ['3.1', '3.2', '3.3', '3.4'],
        // Yönerge koşulu birebir "4.1, 4.2, 4.3, 4.4" diyor; 4.4 (Kalkınma
        // Bakanlığı) kayıttan ayrılamadığı için kümede karşılığı yok.
        '4.1-4.4' => ['4.1', '4.2', '4.3'],
        'PATENT' => ['6.1', '6.2'],
        'MAKALE' => ['1.*'],
    ],

    'grup_tavanlari' => [],
];
