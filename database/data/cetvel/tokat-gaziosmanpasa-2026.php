<?php

/**
 * TOKAT GAZİOSMANPAŞA ÜNİVERSİTESİ — Akademik Atama ve Yükseltme
 * Puanlama Tablosu
 * Kaynak: pdf/17766907611.Tokat Gaziosmanpaşa Üni. Kriter.pdf
 * (25.12.2025 tarihli YÖK Genel Kurul kararıyla değişik; 31.03.2026'dan
 * itibaren geçerli)
 *
 * Madde kodları tablonun kendi numaralarını izliyor (1.1.a, 2.3.b, GS.4 =
 * Güzel Sanatlar tablosunun 4. satırı).
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞEN SATIRLARDA DÜŞÜK OLAN GİRİLDİ (§0) ──
 *   AHCI dergilerinin çeyreği kayıtta bulunmadığı için 1.1'in en düşük
 *       kademesi (Q4, 30 puan) uygulandı.
 *   1.1.f (diğer uluslararası indeksler, 20) ile 1.1.g (diğer ulusal
 *       hakemli dergiler, 15) ayrı etiketlere bağlandı; 1.1.k (hakemsiz
 *       dergiler, 2) sözlükte karşılıksız.
 *   Editörlükte editör yardımcılığı, alan editörlüğü ve kurul üyeliği
 *       (15 ve 10) tek 'Yayın Kurulu Üyeliği' etiketine düşüyor → 10.
 *   Hakemlikte üç kademe (5, 4, 3) tek 'Hakemlik' etiketine düşüyor → 3.
 *   Atıfta kitap atfı (2) ile TR Dizin atfı (2) ve diğer bilimsel yayın
 *       atfı (1) ayrı etiketlerde; h-indeksi satırı girilemedi.
 *   Tez yönetiminde ikinci danışmanlık puanın yarısı olduğundan doktorada
 *       20, yüksek lisansta 10 girildi.
 *   Ödüllerde uluslararası dört kademe (50-20) ile ulusal dört kademe
 *       (40-10) etiket bazında en düşük değerden girildi.
 *   Bilimsel etkinliklerde düzenleme kurulu başkanlığı (25), üyeliği (15),
 *       bilim kurulu üyeliği (5), sekretarya (5) ve oturum başkanlığı (3)
 *       tek 'Diğer' etiketine düşüyor → 3.
 *   Patentte tescil belgesi (120 ve 240) ile lisanslanan belge (240 ve
 *       120) satırları ayrışmadığı için ulusal patentte 120, uluslararası
 *       patentte 240 girildi; BAŞVURU satırları (3.1, 3.2) yazılmadı.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   1.1.k (hakemli olmayan dergilerde yayımlanan çalışmalar, 2 puan).
 *   1.6.a (Web of Science h-indeksi en az 5 → 15 puan) — faaliyet değil
 *       profil ölçütü.
 *   3.1 ve 3.2 patent BAŞVURUSU satırları.
 *   2.3.d ve 2.3.e (üniversitenin Enerji Depolama ihtisas alanı projeleri)
 *       — kayıt projenin ihtisas alanında olduğunu taşımıyor.
 *   6. bölüm (bilimsel nitelikli kazı etkinlikleri) ile 4.4 (Teknoloji
 *       Transfer Ofisinde görev almak) — sözlükte karşılıksız.
 *   5.10 (öğrenci kulübü danışmanlığı) ve 7.3 (radyo-televizyon programı,
 *       köşe yazarlığı) toplumsal katkı etiketlerine bağlandı; 7.1 ve 7.2
 *       ayrışmadığı için en düşük değerden (5) sayılıyor.
 *   Güzel Sanatlar tablosunun 13-16. satırları (dinî mûsıkî bestesi,
 *       konser icracılığı, dijital kayıt, albüm) girildi; 11 ve 12
 *       (jürili etkinlik ödülleri) ödül etiketlerine bağlandı.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   1.4, 1.5 ve 1.6'nın "en fazla n hakemlik / n atıf puanlamaya dâhil
 *       edilebilir" adet sınırları ile 2.1'in "en fazla 10 ders" sınırı:
 *       motor yalnız puan tavanı tanıyor, adet sınırı tanımıyor.
 *   5. bölümün "en az üç ay görev yapmış olma" şartı.
 *
 * Yönerge: yonerge/tokat-gaziosmanpasa.php
 *
 * 06.09.2026: bilimsel toplantı organizasyonu ailesi için altı etiket
 * açıldı (başkanlık · düzenleme/bilim kurulu üyeliği · oturum başkanlığı,
 * her biri uluslararası/ulusal). Yukarıdaki "sözlükte karşılıksız" notları
 * bu satırlar için artık geçerli değil.
 */
$TAM = ['ozgun_makale', 'derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];
$WOS = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];

$maddeler = [
    // ══ 1.1 MAKALELER ══
    '1.1.a' => ['baslik' => 'SCIE, SSCI ya da AHCI kapsamındaki Q1 dergide araştırma ya da derleme makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $TAM, 'puan' => 90],
    '1.1.b' => ['baslik' => 'SCIE, SSCI ya da AHCI kapsamındaki Q2 dergide araştırma ya da derleme makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $TAM, 'puan' => 60],
    '1.1.c' => ['baslik' => 'SCIE, SSCI ya da AHCI kapsamındaki Q3 dergide araştırma ya da derleme makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $TAM, 'puan' => 45],
    '1.1.ç' => ['baslik' => 'SCIE, SSCI ya da AHCI kapsamındaki Q4 dergide araştırma ya da derleme makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => $TAM, 'puan' => 30],
    '1.1.d' => ['baslik' => 'ESCI ya da Scopus tarafından taranan dergide araştırma ya da derleme makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $TAM, 'puan' => 30],
    '1.1.e' => ['baslik' => 'TR Dizin tarafından taranan dergide araştırma ya da derleme makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $TAM, 'puan' => 25],
    '1.1.f' => ['baslik' => 'Diğer uluslararası indekslerde taranan dergide araştırma ya da derleme makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $TAM, 'puan' => 20],
    '1.1.g' => ['baslik' => 'Diğer ulusal hakemli dergide araştırma ya da derleme makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $TAM, 'puan' => 15],
    '1.1.h' => ['baslik' => 'SCIE, SSCI ya da AHCI kapsamındaki dergide olgu sunumu, editöre mektup, araştırma notu, özet, kitap kritiği, kısa araştırma makalesi ya da teknik not', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $KISA, 'puan' => 10],
    '1.1.ı' => ['baslik' => 'ESCI ya da Scopus tarafından taranan dergide olgu sunumu, editöre mektup, araştırma notu, özet, kitap kritiği, kısa araştırma makalesi ya da teknik not', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $KISA, 'puan' => 8],
    '1.1.i' => ['baslik' => 'Uluslararası hakemli dergiler ile TR Dizin dergilerinde olgu sunumu, editöre mektup, araştırma notu, özet, kitap kritiği ya da teknik not', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Uluslararası İndeks'], 'turler' => $KISA, 'puan' => 5],
    '1.1.j' => ['baslik' => 'Ulusal hakemli dergilerde olgu sunumu, editöre mektup, araştırma notu, özet, kitap kritiği ya da teknik not', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 3],

    // ══ 1.2 BİLDİRİLER ══
    '1.2.a' => ['baslik' => 'Uluslararası ya da ulusal toplantı, kongre ve sempozyumda sözlü bildiri sunumu', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin', 'Ulusal Tam Metin', 'Davetli Konuşmacı'], 'puan' => 10],
    '1.2.b' => ['baslik' => 'Uluslararası ya da ulusal toplantı, kongre ve sempozyumda poster bildiri sunumu', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster', 'Ulusal Özet/Poster'], 'puan' => 5],

    // ══ 1.3 KİTAPLAR ══
    '1.3.a' => ['baslik' => 'Web of Science Book Citation Index\'te taranan yayınevinde yayımlanan kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası Kitap'], 'puan' => 90],
    '1.3.b' => ['baslik' => 'Web of Science Book Citation Index\'te taranan yayınevinde yayımlanan kitap bölümü ya da kitap editörlüğü', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Uluslararası Kitap Bölümü'], 'puan' => 60],
    '1.3.b.e' => ['baslik' => 'Web of Science Book Citation Index\'te taranan kitabın editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Uluslararası Kitap Editörlüğü'], 'puan' => 60],
    '1.3.c' => ['baslik' => 'Diğer yayınevleri tarafından yayımlanan kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Ders / Metot Kitabı'], 'puan' => 40],
    '1.3.ç' => ['baslik' => 'Diğer yayınevleri tarafından yayımlanan kitaplarda bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 25],
    '1.3.d' => ['baslik' => 'Alanında kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 30],
    '1.3.e' => ['baslik' => 'Alanında kitap bölümü çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 10],
    '1.3.f' => ['baslik' => 'Kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 20],
    '1.3.g' => ['baslik' => 'Ansiklopedi madde yazımı', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 5],

    // ══ 1.4 EDİTÖRLÜK ══
    '1.4.a' => ['baslik' => 'SCIE, SSCI ya da AHCI kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 60],
    '1.4.b' => ['baslik' => 'ESCI ya da Scopus tarafından taranan dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 40],
    '1.4.c' => ['baslik' => 'Uluslararası hakemli dergiler ile TR Dizin dergilerinde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 30],
    '1.4.ç' => ['baslik' => 'Diğer ulusal hakemli dergilerde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 25],
    '1.4.e' => ['baslik' => 'Editör yardımcılığı, alan ya da sayı editörlüğü, sekretarya ve dergi kurul üyelikleri', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 10],
    '1.5.c' => ['baslik' => 'Bilimsel dergilerde hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 3],

    // ══ 1.6 ATIFLAR ══
    '1.6.b' => ['baslik' => 'SCIE, SSCI, AHCI, ESCI ya da Scopus dergilerinde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 3],
    '1.6.ç' => ['baslik' => 'Uluslararası hakemli dergiler ile TR Dizin dergilerinde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
    '1.6.d' => ['baslik' => 'Uluslararası ya da ulusal yayınevlerince yayımlanan kitaplarda eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 2],
    '1.6.e' => ['baslik' => 'Diğer bilimsel yayınlarda eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],

    // ══ 2.1-2.2 EĞİTİM ÖĞRETİM VE TEZ YÖNETİMİ ══
    '2.1.a' => ['baslik' => 'Önlisans, lisans ya da lisansüstü düzeyde verilen ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 6],
    '2.1.b' => ['baslik' => 'Ders dışı sunum, seminer, konferans, panel, tanıtım ve hizmet içi eğitim faaliyetleri', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Akreditasyon Faaliyeti'], 'puan' => 4],
    '2.2.a' => ['baslik' => 'Danışmanlığında tamamlanan doktora tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 20],
    '2.2.b' => ['baslik' => 'Danışmanlığında tamamlanan yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi', 'Tez İzleme / Jüri Üyeliği'], 'puan' => 10],

    // ══ 2.3 ARAŞTIRMA PROJELERİ ══
    '2.3.a' => ['baslik' => 'Uluslararası kuruluşlar, COST, AB, TÜBİTAK, TÜBA, TÜSEB, TAGEM ve diğer kamu kuruluşları projelerinde yürütücülük ya da koordinatörlük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon', 'TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 90],
    '2.3.b' => ['baslik' => 'Uluslararası kuruluşlar, COST, AB, TÜBİTAK, TÜBA, TÜSEB, TAGEM ve diğer kamu kuruluşları projelerinde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon', 'TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 45],
    '2.3.c' => ['baslik' => 'Diğer ulusal ya da uluslararası destekli projelerde yürütücülük veya koordinatörlük', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 30],
    '2.3.ç' => ['baslik' => 'Diğer ulusal ya da uluslararası destekli projelerde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 15],
    '4.1' => ['baslik' => 'Üniversite-sanayi iş birliği kapsamındaki projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 60],
    '4.2' => ['baslik' => 'Üniversite-sanayi iş birliği kapsamındaki projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 30],

    // ══ 2.4 BİLİMSEL ETKİNLİKLERDE GÖREV ══
    '2.4.d' => ['baslik' => 'Uluslararası ya da ulusal sempozyum, çalıştay ve kongrelerde düzenleme kurulu, bilim kurulu, sekretarya ya da oturum başkanlığı görevleri', 'kategori' => 'diger', 'kaynaklar' => ['Diğer', 'Oturum Başkanlığı (Uluslararası)', 'Oturum Başkanlığı (Ulusal)'], 'puan' => 3],

    // ══ 2.5 ÖDÜLLER ══
    '2.5.a' => ['baslik' => 'Uluslararası bilim, sanat, proje, teşvik ya da diğer bilimsel ödüller', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 20],
    '2.5.d' => ['baslik' => 'Ulusal bilim, sanat, proje, teşvik ya da diğer bilimsel ödüller', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü', 'Burs'], 'puan' => 10],

    // ══ 3. FİKRİ VE SINAİ MÜLKİYET HAKLARI ══
    '3.4' => ['baslik' => 'Yurt dışı patent belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 240],
    '3.3' => ['baslik' => 'Yurt içi patent belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 120],
    '3.5' => ['baslik' => 'Faydalı model, endüstriyel tasarım belgesi ya da lisanslanan belge', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım'], 'puan' => 120],
    '4.3' => ['baslik' => 'Teknoparkta şirket sahibi ya da ortağı olmak', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 30],

    // ══ 5. İDARİ GÖREVLER ══
    '5.1' => ['baslik' => 'Rektörlük ya da rektör yardımcılığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı'], 'puan' => 100],
    '5.2' => ['baslik' => 'Dekanlık, enstitü, yüksekokul ya da meslek yüksekokulu müdürlüğü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü'], 'puan' => 60],
    '5.3' => ['baslik' => 'Merkez müdürlükleri ve koordinatörlükler', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 50],
    '5.4' => ['baslik' => 'Dekan yardımcılığı, müdür yardımcılığı ve koordinatör yardımcılığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.'], 'puan' => 25],
    '5.5' => ['baslik' => 'Bölüm başkanlığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı'], 'puan' => 25],
    '5.6' => ['baslik' => 'Bölüm başkan yardımcılığı ya da anabilim, ana sanat dalı başkanlığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı', 'Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 20],
    '5.7' => ['baslik' => 'Senato, üniversite yönetim kurulu üyeliği ve rektörlükçe oluşturulan sürekli komisyon ve kurullarda görev alma', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 20],

    // ══ 7. TOPLUMSAL KATKI ══
    '7.2' => ['baslik' => 'Uzmanlık alanı ile ilgili toplumsal katkı faaliyetlerinde görev almak; radyo ve televizyon programlarında yer almak ya da köşe yazarlığı', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın', 'Kamu/STK Danışmanlığı'], 'puan' => 5],

    // ══ GÜZEL SANATLAR ALANINDA DEĞERLENDİRME ══
    'GS.1' => ['baslik' => 'Özgün sanat eserinin uluslararası sanat, eğitim ve kültür kurumlarınca satın alınması ya da yayın organlarında gösterime girmesi; tasarım projesinin dış ülkelerde uygulanması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Haber Olması (Uluslararası)'], 'puan' => 60],
    'GS.5' => ['baslik' => 'Özgün sanat eserinin ulusal sanat, eğitim ve kültür kurumlarınca satın alınması ya da yayın organlarında gösterime girmesi; tasarım projesinin kamu kurumlarınca uygulanması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Satın Alınması (Yurt İçi)', 'Eserin Haber Olması (Ulusal)', 'Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman'], 'puan' => 50],
    'GS.2' => ['baslik' => 'Uluslararası jürili karma sanat ve tasarım etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)'], 'puan' => 45],
    'GS.3' => ['baslik' => 'Uluslararası kişisel etkinliklerde bulunmak (festival, sergi, proje uygulama, gösteri, dinleti, gösterim)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Resital (Uluslararası)', 'Şan Resitali (Uluslararası)', 'Solistlik (Uluslararası)', 'Oratoryo/Kantat Solistliği (Uluslararası)', 'Opera Birinci Rol (Uluslararası)', 'Bale Başrol (Uluslararası)', 'Orkestra Şefliği (Uluslararası)', 'Koro Şefliği (Uluslararası)', 'Opera Şefliği (Uluslararası)', 'Bale Orkestra Şefliği (Uluslararası)', 'Grup Şefliği (Uluslararası)', 'Rejisörlük (Uluslararası)', 'Masterclass (Uluslararası)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)'], 'puan' => 30],
    'GS.4' => ['baslik' => 'Ulusal düzeyde kişisel etkinliklerde bulunmak (festival, sergi, proje uygulama, gösteri, dinleti, gösterim)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Elektronik Kişisel Sergi (Ulusal)', 'Resital (Ulusal)', 'Şan Resitali (Ulusal)', 'Solistlik (Ulusal)', 'Oratoryo/Kantat Solistliği (Ulusal)', 'Opera Birinci Rol (Ulusal)', 'Bale Başrol (Ulusal)', 'Orkestra Şefliği (Ulusal)', 'Koro Şefliği (Ulusal)', 'Opera Şefliği (Ulusal)', 'Bale Orkestra Şefliği (Ulusal)', 'Grup Şefliği (Ulusal)', 'Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)', 'Yönetmenlik (Sahne/Ekran)', 'Masterclass (Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 15],
    'GS.7' => ['baslik' => 'Ulusal düzeyde jürili karma sanat ve tasarım etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)'], 'puan' => 15],
    'GS.9' => ['baslik' => 'Karma ya da grup sanat ve tasarım etkinliklerine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Jürisiz, Ulusal)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Karma Sergi (Uluslararası)', 'Elektronik Karma Sergi (Ulusal)', 'Oda Müziği Grup Üyeliği (Uluslararası)', 'Oda Müziği Grup Üyeliği (Ulusal)', 'Orkestra / Koro Üyeliği', 'Corps de Ballet (Uluslararası)', 'Corps de Ballet (Ulusal)', 'Dansçı / Performans İcracısı (Uluslararası)', 'Dansçı / Performans İcracısı (Ulusal)'], 'puan' => 8],
    'GS.11' => ['baslik' => 'Jürili sanat ve tasarım etkinliklerinde eserleriyle ödül almak', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 30],
    'GS.13' => ['baslik' => 'Sanatsal değeri olan özgün beste sunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Özgün Eser / Beste / Tasarım', 'Opera/Bale Kompozisyonu', 'Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Orkestralı Sahne Eseri', 'Küçük Ölçekli Orkestra Eseri', 'Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)', 'Elektronik Müzik Eseri (≥15 dk)', 'Elektronik Müzik Eseri (<15 dk)', 'Sahne/Ekran Müziği', 'Orkestrasyon/Transkripsiyon', 'Eğitim Müziği Düzenlemesi', 'Koreografi'], 'puan' => 15],
    'GS.16' => ['baslik' => 'Bandrollü ya da dijital yayımlanmış albüm; dijital platformda yayımlanmış en az 30 dakikalık ses veya video kaydı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)', 'Karma Albüm / CD-DVD Katkısı', 'Eğitim Müziği Albümü'], 'puan' => 15],
];

$kodlar = fn (string ...$onekler): array => array_values(array_filter(
    array_keys($maddeler),
    fn (string $kod): bool => array_reduce($onekler, fn (bool $t, string $o): bool => $t || str_starts_with($kod, $o), false)
));

$MAKALE = $kodlar('1.1.');
$BILDIRI = $kodlar('1.2.');
$KITAP = $kodlar('1.3.');
$PROJE = ['2.3.a', '2.3.b', '2.3.c', '2.3.ç', '4.1', '4.2'];

return [
    'kapsam_notu' => 'Puanlar Tokat Gaziosmanpaşa Üniversitesi Öğretim Üyeliği Kadrolarına '
        .'Başvuru Koşulları ve Uygulama İlkelerinin puanlama tablosundan (25.12.2025 tarihli YÖK '
        .'Genel Kurul kararıyla değişik, 31.03.2026\'dan itibaren geçerli). Çok yazarlı '
        .'yayınlarda puan yazar sırasına göre azalıyor: iki yazarlıda %90 ve %85; üç yazarlıda '
        .'%80, %75, %70; dört yazarlıda %70\'ten %55\'e; beş yazarlıda %60\'tan %40\'a; altı ve '
        .'daha fazla yazarlıda %50\'den %25\'e. Sorumlu yazar birinci isimle aynı ağırlıkta '
        .'değerlendiriliyor. Yazar listesini boş bırakırsanız oran uygulanmaz ve puanınız '
        .'olduğundan yüksek görünür. Editörlükten en fazla 100, bilimsel etkinliklerde görev '
        .'almadan 50, toplumsal katkıdan 60 puan alınabiliyor. Puanınız şu kalemlerde OLDUĞUNDAN '
        .'DÜŞÜK görünür: AHCI dergileri çeyrek bilgisi olmadığı için en düşük kademeden (30) '
        .'sayılıyor; hakemlik, editör yardımcılığı, bilimsel etkinlik görevleri ve ödüller aynı '
        .'etikete düştüğü için en düşük değerden sayılıyor; ikinci danışmanlık ayrışmadığı için '
        .'tez yönetimi yarı değerden girildi; h-indeksi, patent BAŞVURUSU, üniversitenin Enerji '
        .'Depolama ihtisas alanı projeleri, bilimsel kazı etkinlikleri ve Teknoloji Transfer '
        .'Ofisi görevleri girilemedi. Yönergenin "en fazla 10 hakemlik", "en fazla 10 atıf" ve '
        .'"en fazla 10 ders" gibi ADET sınırları motorda karşılığı olmadığı için '
        .'uygulanmıyor; bu kalemlerde puanınız olduğundan yüksek çıkabilir.'
        .' KİTAPTA İNDEKS KOŞULU DENETLENMİYOR: uluslararası yayınevi kitabınız yönergenin BKCI/Scopus taranan kitap satırından sayılıyor. Kitabınız bu kapsamda değilse puanınız olduğundan YÜKSEK görünür; yönerge o kitabı daha düşük bir satırda sayıyor olabilir.',

    // "Çok yazarlı yayımlar için puan hesaplama tablosu"; sorumlu yazar
    // birinci isimle aynı ağırlıkta. Yedi ve üzeri yazarlı eserlerde altı
    // isimli puanlama uygulanır, yedinci ve sonraki yazarlar %25 alır.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'editorluk', 'proje', 'tez_danismanligi', 'tez_yayini',
            'egitim_ogretim', 'idari_gorev', 'toplumsal_katki', 'diger'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.00]],
            'ilk' => ['kademeler' => [1 => 1.00, 2 => 0.90, 3 => 0.80, 4 => 0.70, 5 => 0.60], 'sonrasi' => 0.50],
            'baslica' => ['kademeler' => [1 => 1.00, 2 => 0.90, 3 => 0.80, 4 => 0.70, 5 => 0.60], 'sonrasi' => 0.50],
            'yazar_2' => ['kademeler' => [2 => 0.85, 3 => 0.75, 4 => 0.65, 5 => 0.55], 'sonrasi' => 0.45],
            'yazar_3' => ['kademeler' => [3 => 0.70, 4 => 0.60, 5 => 0.50], 'sonrasi' => 0.40],
            'yazar_4' => ['kademeler' => [4 => 0.55, 5 => 0.45], 'sonrasi' => 0.35],
            'yazar_5' => ['kademeler' => [5 => 0.40], 'sonrasi' => 0.30],
            'ortak' => ['sonrasi' => 0.25],
        ],
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        'TOPLAM' => array_keys($maddeler),
        // Doktor öğretim üyeliği Madde 2'nin alan bazlı makale kümeleri.
        'MAKALE' => $MAKALE,
        '1.1.A-D' => ['1.1.a', '1.1.b', '1.1.c', '1.1.ç', '1.1.d'],
        '1.1.A-E' => ['1.1.a', '1.1.b', '1.1.c', '1.1.ç', '1.1.d', '1.1.e'],
        // Profesörlük ve doçentlik Madde 4/d'nin alan bazlı kümeleri.
        '1.1.A-B' => ['1.1.a', '1.1.b'],
        '1.1.A-C' => ['1.1.a', '1.1.b', '1.1.c'],
        // Doçentlik Madde 3 ve profesörlük Madde 3: makale, bildiri, kitap
        // ve projelerden gelmesi gereken pay.
        'YAYIN-PROJE' => [...$MAKALE, ...$BILDIRI, ...$KITAP, ...$PROJE],
        // Madde 4'ün alternatif yolları.
        'BKCI' => ['1.3.a', '1.3.b', '1.3.b.e'],
        'PROJE-YURUTUCU' => ['2.3.a', '2.3.c', '4.1'],
        'PROJE-ARASTIRMACI' => ['2.3.b', '2.3.ç', '4.2'],
        'PATENT' => ['3.3', '3.4', '3.5'],
        // Tavan grupları.
        'EDITORLUK' => $kodlar('1.4.'),
        'ETKINLIK' => ['2.4.d'],
        'TOPLUMSAL' => ['7.2'],
    ],

    'grup_tavanlari' => [
        'EDITORLUK' => 100,
        'ETKINLIK' => 50,
        'TOPLUMSAL' => 60,
        // Yönergenin ADET sınırları puana çevrildi: satır puanı sabit olduğu
        // için "en fazla 10 hakemlik" = 10 × 3 = 30 puan (KONVANSIYONLAR
        // "Adet tavanı puana ÇEVRİLEBİLİR").
        //
        // Kaynak atıf ve hakemlik satırlarını indekse göre AYIRIYOR ve her
        // birine ayrı 10'luk sınır koyuyor; cetvel bunları tek satırda
        // topladığı için tavan da tek uygulanıyor, yani gerçekte izin
        // verilenden DAR. §0 gereği bu yönde sapma serbest.
        '1.5.c' => 30,
        '1.6.b' => 30,
        '1.6.ç' => 20,
        '1.6.d' => 20,
        '1.6.e' => 10,
        '2.1.a' => 60,
        '2.1.b' => 40,
    ],
];
