<?php

/**
 * AĞRI İBRAHİM ÇEÇEN ÜNİVERSİTESİ — Puanlama Listesi
 * Kaynak: pdf/17536928002.agriibrahimcecenuniversitesi.pdf (01/01/2024 yürürlük)
 *
 * TEK ORTAK PUAN LİSTESİ, ALAN GRUBUNA GÖRE AYRI EŞİK. Koşullar listeye
 * ÜST DÜZEY NUMARAYLA atıf yapıyor ("1 numaralı maddeden en az 20 puan",
 * "30, 31, 32, 33 numaralı maddelerden"), o yüzden kodun ilk bileşeni korundu.
 *
 * YAZAR ÇARPANI FORMÜL, TABLO DEĞİL (Madde 4.2):
 *   1. isim   Puan/YazarSayısı + Puan×0,30
 *   2. isim   Puan/YazarSayısı + Puan×0,20
 *   3. isim   Puan/YazarSayısı + Puan×0,10
 *   4. isim   Puan/YazarSayısı + Puan×0,05
 *   5. ve sonrası   Puan/YazarSayısı
 * Tek isimli çalışma tam puan alır (Madde 4.1) — formülle hesaplansa 1,30
 * çıkardı, o yüzden n=1 ayrı kademe. Sorumlu yazar birinci isim sayılıyor,
 * bu yüzden 'baslica' ile 'ilk' aynı satırı kullanıyor.
 *
 * ÇEYREKLİK ÇARPANI MADDE PUANINA GÖMÜLDÜ (Madde 4.3): Q1 ×1,5, Q2 ×1,25,
 * Q3 ×1,125, Q4 ×1. Motorda ayrı bir çeyreklik çarpanı yok; 1.1 satırı dört
 * alt maddeye bölünüp puanı önceden çarpıldı (40 → 60/50/45/40). Çeyrekliği
 * belli olmayan makale yönergeye göre Q4 sayılıyor.
 *
 * GİRİLMEYEN BÖLÜMLER: 8-29 arası sanatsal etkinlik, film, tiyatro, restorasyon
 * ve arkeolojik kazı kalemleri ile 30-37 arası müzik kalemleri — kaynak
 * sözlüğünde karşılıkları yok. Bu bölümlere atıf yapan koşullar (müzik
 * sanatçılığı, uygulamalı sanat alanları) bu yüzden girilmedi.
 */

return [
    'kapsam_notu' => 'Puanlar Ağrı İbrahim Çeçen Üniversitesi Puanlama Listesinden (01/01/2024). '
        .'Çok yazarlı çalışmalarda puan yazar sayısına ve sıranıza göre azaltılır (Madde 4.2) — '
        .'bu hesap uygulanıyor, ancak YAZAR LİSTESİNİ BOŞ BIRAKTIĞINIZ faaliyetlerde uygulanamaz. '
        .'Sanatsal etkinlik, film, tiyatro ve müzik bölümleri kaynak sözlüğünde karşılıksız '
        .'olduğu için girilmedi; o bölümlere dayanan alanların eşiği de üretilmedi.',

    // Madde 4.2: bölünmüş payın üstüne sıraya göre sabit ilave.
    'yazar_katsayisi' => [
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.0]],
            'ilk' => ['kademeler' => [1 => 1.0], 'bol' => ['pay' => 1.0, 'ek' => 0.30]],
            'baslica' => ['kademeler' => [1 => 1.0], 'bol' => ['pay' => 1.0, 'ek' => 0.30]],
            'yazar_2' => ['bol' => ['pay' => 1.0, 'ek' => 0.20]],
            'yazar_3' => ['bol' => ['pay' => 1.0, 'ek' => 0.10]],
            'yazar_4' => ['bol' => ['pay' => 1.0, 'ek' => 0.05]],
            'yazar_5' => ['bol' => ['pay' => 1.0]],
            'yazar_6' => ['bol' => ['pay' => 1.0]],
            // Sırasını belirtmeyen aday ilavesiz payı alır — en düşük seçenek.
            'ortak' => ['kademeler' => [1 => 1.0], 'bol' => ['pay' => 1.0]],
        ],
    ],

    'maddeler' => [
        // ── 1. MAKALELER ── (çeyreklik çarpanı puana gömülü)
        '1.1-Q1' => ['baslik' => 'SCI, SSCI, SCI-Expanded, ESCI veya AHCI Q1 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 60],
        '1.1-Q2' => ['baslik' => 'SCI, SSCI, SCI-Expanded, ESCI veya AHCI Q2 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 50],
        '1.1-Q3' => ['baslik' => 'SCI, SSCI, SCI-Expanded, ESCI veya AHCI Q3 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 45],
        '1.1-Q4' => ['baslik' => 'SCI, SSCI, SCI-Expanded, ESCI veya AHCI Q4 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI', 'ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 40],
        '1.1.2' => ['baslik' => 'SCI, SSCI, SCI-Expanded, ESCI veya AHCI dergide teknik not, editöre mektup veya vaka takdimi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI', 'ESCI / Scopus'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 18],
        '1.2' => ['baslik' => 'Eğitimle ilgili uluslararası alan indeksli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 30],
        '1.3' => ['baslik' => 'Diğer yurt dışı hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 24],
        '1.4' => ['baslik' => 'Yurt içi hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 20],

        // ── 2. BİLDİRİLER ──
        '2.1.1' => ['baslik' => 'Uluslararası bilimsel toplantıda davetli konuşmacı', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 20],
        '2.1.2' => ['baslik' => 'Uluslararası bilimsel toplantıda tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 15],
        '2.1.3' => ['baslik' => 'Uluslararası bilimsel toplantıda özet veya poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 8],
        '2.2.1' => ['baslik' => 'Ulusal bilimsel toplantıda tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 10],
        '2.2.2' => ['baslik' => 'Ulusal bilimsel toplantıda özet veya poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 5],

        // ── 4. KİTAPLAR ──
        '4.1' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanan kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 80],
        '4.2' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanan kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı'], 'puan' => 40],
        '4.3' => ['baslik' => 'Kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 20],

        // ── 5. ÇEVİRİLER ──
        '5.1' => ['baslik' => 'Kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 40],
        '5.2' => ['baslik' => 'Kitap bölümü veya makale çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 10],

        // ── 6. EDİTÖRLÜKLER VE HAKEMLİKLER ──
        '6.1' => ['baslik' => 'SCI, SSCI, SCI-Expanded veya AHCI dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 30],
        '6.2' => ['baslik' => 'Diğer dergilerde editörlük veya yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi', 'TR Dizin Dergi', 'Diğer Hakemli Dergi', 'Yayın Kurulu Üyeliği'], 'puan' => 15],
        '6.3' => ['baslik' => 'Kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Kitap Editörlüğü'], 'puan' => 20],
        '6.4' => ['baslik' => 'Hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 5],

        // ── 7. ATIFLAR ──
        '7.1' => ['baslik' => 'Yayınlarınıza yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap', 'TR Dizin', 'Diğer', 'Patent'], 'puan' => 6],

        // ── PROJE, PATENT, TEZ ve DERS ──
        'P.1' => ['baslik' => 'Uluslararası destekli araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'puan' => 60],
        'P.2' => ['baslik' => 'TÜBİTAK, TÜSEB veya kamu destekli araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'puan' => 40],
        'P.3' => ['baslik' => 'Üniversite (BAP) destekli araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'puan' => 15],
        'P.4' => ['baslik' => 'Patent, faydalı model veya tasarım tescili', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent', 'Ulusal Patent', 'Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım', 'Islahçı Hakkı / Çeşit Tescili', 'Ticarileştirme'], 'puan' => 30],
        'P.5' => ['baslik' => 'Tamamlanmış lisansüstü tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi', 'Yüksek Lisans Tezi', 'Tez İzleme / Jüri Üyeliği'], 'puan' => 15],
        'P.6' => ['baslik' => 'Verdiğiniz dersler', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi', 'Akreditasyon Faaliyeti'], 'puan' => 5],
    ],

    'gruplar' => [
        // Koşulların birebir andığı üst düzey madde numarası.
        '1' => ['1.*'],
        'MAKALE' => ['1.*'],
    ],

    'grup_tavanlari' => [],
];
