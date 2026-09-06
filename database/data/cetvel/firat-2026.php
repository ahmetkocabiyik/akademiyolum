<?php

/**
 * FIRAT ÜNİVERSİTESİ — EK-1 Öğretim Üyeliğine Yükseltilme ve Atanma Puan Tablosu
 * Kaynak: pdf/1775657147400.firat-kriter-07042026.pdf (07/04/2026)
 *
 * TEK ORTAK PUAN TABLOSU, YEDİ BİLİM ALANI İÇİN AYRI EŞİK. EK-1'in 255 ölçütü
 * bütün alanlarda aynı puanı taşır; değişen, hangi kod aralığından ne kadar
 * puan isteneceği (yonerge/firat.php).
 *
 * ÇEYREKLİKLER TEK SATIRDA: A2.1 ve A2.2 puanı "Q1 200 / Q2 160 / Q3 120 /
 * Q4 80" biçiminde veriyor. Kaynak sözlüğü çeyreklikleri ayırabildiği için bu
 * satırlar alt maddelere bölündü (A2.1-Q1, A2.1-Q2…). Eşikler "A2.1-A2.2"
 * biçiminde aralığa atıf yaptığından gruplar bu kodları önekle yakalıyor.
 *
 * TÜBİTAK PROGRAMLARI TEK ETİKETE DÜŞÜYOR. EK-1 programı programa ayırıyor
 * (1001 için 100, 1002-A için 50, 3001/3005 için 80, çağrılı için 150…) ama
 * kaynak sözlüğünde hepsi 'TÜBİTAK'. Aynı etikete düşen ölçütlerde daima EN
 * DÜŞÜK puan tutuldu; aday puanını eksik görür, fazla görmez.
 *
 * İDARİ GÖREVLER (C10) GİRİLMEDİ: puanları "2,0 x ay" gibi süre formülü, sabit
 * değer değil; faaliyet kaydı görev süresini ay olarak tutmuyor.
 *
 * GİRİLMEYEN DİĞER ÖLÇÜTLER: kongre düzenleme ve bilim kurulu üyelikleri,
 * dolaşım programları (Farabi, Mevlana, Erasmus+), sertifika programları,
 * görsel etkinlikler (D), sanat ve tasarım etkinlikleri (F) ile sportif
 * etkinlikler (E) bölümlerinin çoğu — kaynak sözlüğünde karşılıkları yok.
 *
 * ── C6 SATIRI KAYNAKTA DURUYOR AMA YÜRÜRLÜKTE DEĞİL ──
 * Tablodaki "C6 … 100" satırının metni "Yükseköğretim Genel Kurulu'nun
 * 27.11.2025 tarihli toplantısında uygun bulunmayarak TABLODAN
 * ÇIKARILMIŞTIR" diyor; 100 rakamı çıkarılan satırdan kalma. Cetvelde C6
 * YOK ve olmamalı — sayıyı görüp satır açmak 100 puanlık bir fazla sayma
 * üretir. 'C2-C6' kümesi de C6'yı saymıyor.
 *
 * 06.09.2026: bilimsel toplantı organizasyonu ailesi için altı etiket
 * açıldı (başkanlık · düzenleme/bilim kurulu üyeliği · oturum başkanlığı,
 * her biri uluslararası/ulusal). Yukarıdaki "sözlükte karşılıksız" notları
 * bu satırlar için artık geçerli değil.
 */

return [
    'kapsam_notu' => 'Puanlar Fırat Üniversitesi EK-1 tablosundan (07/04/2026). EK-1\'in 255 '
        .'ölçütünden bir bölümü girildi; idari görevler süre formülü taşıdığı, dolaşım '
        .'programları, sertifikalar, görsel ve sanatsal etkinlikler ile sportif etkinliklerin '
        .'ise kaynak sözlüğünde karşılığı olmadığı için girilmedi. TÜBİTAK programları tek '
        .'etikete düştüğü için en düşük program puanı kullanıldı. Gerçek toplamınız burada '
        .'görünenden yüksek olabilir, düşük olamaz.',

    'maddeler' => [
        'A1.1' => ['baslik' => 'Web of Science Book Citation Index (BKCI) kapsamında bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 300],
        'A1.2' => ['baslik' => 'A1.1 dışındaki diğer bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 150],
        'A1.3' => ['baslik' => 'Web of Science Book Citation Index (BKCI) kapsamındaki bilimsel kitap içinde bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 100],
        'A1.4' => ['baslik' => 'A1.3 dışındaki diğer bilimsel kitap içinde bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 40],
        'A1.6' => ['baslik' => 'A1.5 dışındaki diğer bilimsel kitaplarda editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü', 'BKCI Kitap'], 'puan' => 40],
        'A2.1-Q1' => ['baslik' => 'SCI, SCI-E, SSCI, AHCI kapsamındaki dergilerde yayımlanmış özgün araştırma makalesi veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 200],
        'A2.1-Q2' => ['baslik' => 'SCI, SCI-E, SSCI, AHCI kapsamındaki dergilerde yayımlanmış özgün araştırma makalesi veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 160],
        'A2.1-Q3' => ['baslik' => 'SCI, SCI-E, SSCI, AHCI kapsamındaki dergilerde yayımlanmış özgün araştırma makalesi veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 120],
        'A2.1-Q4' => ['baslik' => 'SCI, SCI-E, SSCI, AHCI kapsamındaki dergilerde yayımlanmış özgün araştırma makalesi veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 80],
        'A2.2-Q1' => ['baslik' => 'SCI, SCI-E, SSCI, AHCI kapsamındaki dergilerde yayımlanmış editöre mektup, kitap eleştirisi, teknik not ', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 60],
        'A2.2-Q2' => ['baslik' => 'SCI, SCI-E, SSCI, AHCI kapsamındaki dergilerde yayımlanmış editöre mektup, kitap eleştirisi, teknik not ', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 50],
        'A2.2-Q3' => ['baslik' => 'SCI, SCI-E, SSCI, AHCI kapsamındaki dergilerde yayımlanmış editöre mektup, kitap eleştirisi, teknik not ', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 40],
        'A2.2-Q4' => ['baslik' => 'SCI, SCI-E, SSCI, AHCI kapsamındaki dergilerde yayımlanmış editöre mektup, kitap eleştirisi, teknik not ', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 30],
        'A2.3' => ['baslik' => 'E-SCI veya SCOPUS kapsamındaki dergilerde yayımlanmış özgün araştırma, makale, derleme', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 80],
        'A2.4' => ['baslik' => 'TR Dizin veri tabanlarında taranan uluslararası hakemli dergilerde yayımlanmış özgün araştırma ve makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 80],
        'A2.5' => ['baslik' => 'Uluslararası alan indekslerinde taranan dergilerde editöre mektup, özet veya kitap kritiği hariç olmak ü', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 30],
        'A2.6' => ['baslik' => 'SCI, SCI-E, SSCI, AHCI, E-SCI, SCOPUS kapsamı dışındaki indekslerde taranan uluslararası hakemli dergile', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 30],
        'A2.7' => ['baslik' => 'Uluslararası bilimsel ansiklopedilerde madde yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 5],
        'A3.1' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan, özet veya tam metni Web of Science Conference Proceedings Cita', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 50],
        'A3.2' => ['baslik' => 'A.3.1. dışındaki diğer bilimsel toplantılarda yabancı dilde sözlü sunulan özet veya tam metni yayımlanan', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin'], 'puan' => 20],
        'A3.3' => ['baslik' => 'Yurt dışında düzenlenen uluslararası bilimsel etkinliklerde çağrılı konuşmacı (yabancı dilde sunuş)', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 30],
        'A3.5' => ['baslik' => 'Yabancı dilde tam metni veya özeti yayımlanan poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 20],
        'A4.2' => ['baslik' => 'Türkçe sözlü sunulan özet veya tam metni yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 5],
        'A4.4' => ['baslik' => 'Türkçe tam metni veya özeti yayımlanan poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 2],
        'A5.1' => ['baslik' => 'SCI, SCI-E, SSCI, AHCI indeksli dergilerde yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 5],
        'A5.3' => ['baslik' => 'SCI-E, SSCI, AHCI, E-SCI ve SCOPUS kapsamı dışındaki uluslararası hakemli dergilerde yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer'], 'puan' => 2],
        'A5.4' => ['baslik' => 'Yurt dışında yayımlanan bilimsel kitap, monografi, yüksek lisans ve doktora tezlerinde yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 2],
        'A6.1' => ['baslik' => 'SCI, SCI-E, SSCI, AHCI kapsamındaki dergilerde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 30],
        'A6.2' => ['baslik' => 'SCI, SCI-E, SSCI, AHCI kapsamındaki dergilerde yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 20],
        'A6.3' => ['baslik' => 'SCI, SCI-E, SSCI, AHCI kapsamı dışındaki uluslararası hakemli dergilerde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi', 'Diğer Hakemli Dergi'], 'puan' => 10],
        'A6.6' => ['baslik' => 'SCI, SCI-E, SSCI, AHCI kapsamı dışındaki uluslararası hakemli dergilerde hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 3],
        'B1.1' => ['baslik' => 'Bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı'], 'puan' => 50],
        'B1.4' => ['baslik' => 'Bilimsel kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 20],
        'B1.5' => ['baslik' => 'Bilimsel kitap içinde bölüm çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 5],
        'B2.4' => ['baslik' => 'Diğer ulusal hakemli dergilerdeki yayınlar', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'puan' => 12],
        'B4.2' => ['baslik' => 'Diğer ulusal hakemli dergilerde yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 1],
        'B5.3' => ['baslik' => 'Diğer ulusal yayınlarda (dergi/kitap) editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 10],
        'C1.1' => ['baslik' => 'Tamamlanmış tıpta/diş hekimliğinde uzmanlık, doktora ya da sanatta yeterlilik tez danışmanlığı (Sanayi i', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 80],
        'C1.3' => ['baslik' => 'Tamamlanmış yüksek lisans tez danışmanlığı (Sanayi iş birliği projesi kapsamında tamamlanan veya yabancı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 20],
        'C1.7' => ['baslik' => 'Doktora, tıpta/diş hekimliğinde uzmanlık ya da sanatta yeterlik tezlerinden türetilmiş yayınlar (Ulusal ', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 5],
        'C2.6' => ['baslik' => 'TÜBİTAK TEYDEB bünyesindeki Ar-Ge destekli projeler', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 50],
        'C2.10' => ['baslik' => 'Üniversite-sanayi iş birliği projesi (Fırat Üniversitesine veya Fırat Teknokent’e, en az TÜBİTAK Hızlı D', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 50],
        'C2.12' => ['baslik' => 'Kamu kurum ve kuruluşlarından alınan projeler veya Ulusal Ajans destekli projeler (Üniversite veya Tekno', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 20],
        'C2.16' => ['baslik' => 'BAP projesi (zorunlu puanlamada en fazla 10 puan)', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 5],
        'C2.17' => ['baslik' => 'Kurum dışı destekli projelerde bursiyer', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK', 'BAP (Üniversite)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
        'C3.3' => ['baslik' => 'Avrupa Birliği destek programlarından alınan proje (Üniversiteye aktarılan bütçenin en az TÜBİTAK Hızlı ', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 100],
        'C4.3' => ['baslik' => 'Ulusal patent belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 100],
        'C4.4' => ['baslik' => 'Uluslararası patent belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 150],
        'C4.5' => ['baslik' => 'Faydalı model belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model'], 'puan' => 50],
        'C4.6' => ['baslik' => 'Tasarım belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım'], 'puan' => 20],
        'C4.7' => ['baslik' => 'Ticarileşen ulusal patent belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 150],
        'C8.1' => ['baslik' => 'Sürekli ve periyodik olarak verilen jürili uluslararası bilim ve sanat ödülleri', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 100],
        'C8.2' => ['baslik' => 'YÖK, TÜBİTAK, TÜBA ve TÜSEB tarafından verilen bilim ödülleri (yayın teşvik ödülü hariç)', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 100],
        'C8.3' => ['baslik' => 'Sürekli ve periyodik olarak verilen jürili ulusal bilim ve sanat ödülleri (Başarılı tez ödülü birinciliğ', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'Yarışma Derecesi / Mansiyon'], 'puan' => 50],
        'C9.1' => ['baslik' => 'Son 5 (beş) yıl içinde Türkçe verilen dersler (dönem/kurul başına her ders için çarpan 1\'dir.)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders'], 'puan' => 8],
        'C9.2' => ['baslik' => 'Son 5 (beş) yıl içinde yabancı dilde verilen dersler (dönem/kurul başına her ders için çarpan 1\'dir.)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 16],
        'A4.6' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 1],
    ],

    'gruplar' => [
        // Kadro koşullarının birebir andığı kod aralıkları.
        'A2.1' => ['A2.1-*'],
        'A2.1-A2.2' => ['A2.1-*', 'A2.2-*'],
        'A2.1-A2.3' => ['A2.1-*', 'A2.2-*', 'A2.3'],
        'A2.1-A2.4' => ['A2.1-*', 'A2.2-*', 'A2.3', 'A2.4'],
        'A1-A4' => ['A1.*', 'A2.*', 'A3.*', 'A4.*'],
        // B3 (ULUSAL BİLİMSEL TOPLANTILAR) için satır yok: kaynak sözlüğü
        // "ulusal kuruluşça düzenlenen uluslararası toplantıda Türkçe bildiri"
        // (A4.2) ile "ulusal toplantıda bildiri" (B3.1) arasını ayıramıyor.
        // §0 gereği DÜŞÜK puanlı A4 satırlarına bağlandı; faaliyet yine bu
        // eşiğe giriyor çünkü A1-A4 de aynı koşulun içinde.
        'B1-B3' => ['B1.*', 'B2.*'],
        'C2-C6' => ['C2.*', 'C3.*', 'C4.*'],
        'C1' => ['C1.*'],
        'MAKALE' => ['A2.*', 'B2.*'],

        // Tablo başlıklarındaki tavanlar bölümleri ÇAPRAZ bağlıyor: A ve B
        // tablolarının karşılık gelen bölümleri ortak bir tavanı paylaşıyor.
        // B3'ün satırı yok (yukarıdaki nota bakınız), B4 ve B5'in var.
        'A3-A4-B3' => ['A3.*', 'A4.*'],
        'A5-B4' => ['A5.*', 'B4.*'],
        'A6-B5' => ['A6.*', 'B5.*'],
        'C2.16-BAP' => ['C2.16'],
    ],

    /*
     * Tablo başlıklarındaki tavanlar. Dördü de 01.09.2026'ya kadar
     * girilmemişti; tavansız bölüm doğrudan fazla saydırır (§0).
     *
     * "zorunlu puanlamada en fazla N puan" notunu taşıyan maddelerden yalnız
     * C2.16 (BAP) cetvelde var. Kaynak bu tavanı yalnızca asgari zorunlu
     * puan koşullarına ("C2-C6 kapsamında toplamda en az 30 puan") bağlıyor;
     * motorun tavanı toplamda da geçerli, yani girdiğimiz hâli kaynaktan
     * SIKI. Yön §0'a uygun ve asıl kazanç koşulda: tavansızken altı BAP
     * projesi 30 puan edip "C2-C6" barajını tek başına sağlıyordu.
     */
    'grup_tavanlari' => [
        'A3-A4-B3' => 300,   // "A3+A4+B3 toplamı en fazla 300 puan kabul edilir."
        'A5-B4' => 300,      // "A5+B4 toplamı en fazla 300 puan kabul edilir."
        'A6-B5' => 50,       // "A6+B5 toplamı en fazla 50 puan"
        'C2.16-BAP' => 10,   // "BAP projesi (zorunlu puanlamada en fazla 10 puan)"
    ],
];
