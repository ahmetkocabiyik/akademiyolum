<?php

/**
 * TRAKYA ÜNİVERSİTESİ — yedi ekin puanlama sistemi
 * Kaynak: pdf/17537009772.trakyauniverstesi.pdf (78 sayfa; Senato
 * 12 Şubat 2025 tarih ve 02 sayılı toplantı, KARAR 01)
 *
 * YEDİ AYRI CETVEL. Yönergenin EK-1…EK-7 ekleri birbirinden bağımsız
 * puanlama tabloları; aynı satır eklere göre farklı puan alıyor (ESCI
 * makalesi EK-5'te 10, ötekilerde 15; kitap bölümü EK-7'de 15, EK-2'de 3).
 * Bu yüzden tek cetvel değil yedi cetvel var:
 *   trakya-2025-ek1  Sağlık Bilimleri
 *   trakya-2025-ek2  Mühendislik, Fen Bilimleri ve Matematik (Ziraat dâhil)
 *   trakya-2025-ek3  Mimarlık, Planlama ve Tasarım
 *   trakya-2025-ek4  Sosyal ve Beşeri, Eğitim, Filoloji, İlahiyat, Hukuk
 *   trakya-2025-ek5  Devlet Konservatuvarı
 *   trakya-2025-ek6  Güzel Sanatlar
 *   trakya-2025-ek7  Spor Bilimleri
 *
 * Madde kodları yönergenin kendi numaralandırması ("1a-Q1", "6b-y", "12c").
 *
 * ── EN ÇOK PUAN KAYBETTİREN KARARLAR ──
 *   %25 TAVANLARI UYGULANMIYOR. Yönerge atıf, patent, ödül, editörlük,
 *       jüri, idari görev ve "diğer" başlıklarına "atama için gerekli
 *       toplam puanın %25'ini geçemez" sınırı koyuyor. Sınır ATAMA
 *       EŞİĞİNE bağlı; aynı cetvel dört farklı eşikte kullanıldığı için
 *       sabit bir tavana çevrilemedi. Bu kalemlerde puanınız OLDUĞUNDAN
 *       YÜKSEK görünür — yalnız eğitim-öğretim (10) ve EK-4 madde 14 (20)
 *       gibi sabit tavanlar uygulanıyor.
 *   "DİĞER ULUSLARARASI / ULUSAL" ÇİFT DEĞERLERİNİN DÜŞÜĞÜ ALINDI. Kayıt
 *       kitap ve atıfta uluslararası ile ulusalı tek etiket taşıyor;
 *       EK-1'de "diğer uluslararası/ulusal kitap 15/10" satırı 10'dan,
 *       bölümü 5'ten sayılıyor. Uluslararası bir kitabınız varsa puanınız
 *       OLDUĞUNDAN DÜŞÜK görünür.
 *   MATEMATİK ALANI EK-2'DEN AYRILMADI. EK-2'nin eşikleri Matematikte
 *       daha düşük (60 yerine 50, 160 yerine 120, doçentlikte beş makale
 *       yerine iki). Cetvel ve eşik Fen/Mühendislik değerlerini taşıyor;
 *       matematikçi adaya gerekenden fazlası soruluyor.
 *   EK-7'NİN SPORTİF PERFORMANS BÖLÜMÜ (16. madde, 26 satır, sporcu
 *       yetiştirme 40'a kadar) HİÇ GİRİLMEDİ. Kayıtta antrenörlük,
 *       hakemlik, millî takım görevi taşıyan bir kategori yok. Spor
 *       Bilimleri adayının puanı bu yüzden ciddi biçimde eksik çıkar.
 *   h-İNDEKSİ (×5) VE "ALTI AY YURT DIŞI ARAŞTIRMA" (25) satırları yedi
 *       ekte de girilmedi; ikisi de faaliyet değil profil ölçütü.
 *   MESLEK ÖRGÜTÜ YETERLİK BELGESİ (EK-1 madde 17, EK-4 madde 21;
 *       10/5 puan) girilmedi — kayıtta belge kategorisi yok.
 *
 * ── AYNI ETİKETE DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   CPCI'da yayımlanmış ÖZET ve POSTER (5 ve 3) tam metinden ayrılamıyor;
 *       "Uluslararası Özet/Poster" etiketi diğer uluslararası toplantı
 *       satırından (3) sayılıyor.
 *   Kongre sunum/poster ödülleri (EK-1'de 15/10/5) ile jürili yarışma
 *       dereceleri tek "Yarışma Derecesi / Mansiyon" etiketine düşüyor;
 *       her ekte o ekin EN DÜŞÜK ödül satırından sayılıyor. EK-1'in
 *       12.a yarışma satırı (20) bu yüzden hiç girilmedi.
 *   Editörlükte "alan editörlüğü" ile "yayın kurulu üyeliği", hakemlikte
 *       dergi/kitap/kongre ayrımı tek etikete düşüyor; en düşüğü alındı.
 *   Patent BAŞVURUSU (5) tescilliden ayrılamadığı için girilmedi.
 *   Toplumsal katkıda koordinatör (6) / görev alan (4) / eğitmen (2) ve
 *       uluslararası / ulusal ayrımı kayıtta yok; ulusal görev alma (2)
 *       ile ulusal danışmanlık (1) satırlarından sayılıyor.
 *   Atama jürisi üyeliği doktor öğretim üyesi jürisinden (3) sayılıyor;
 *       doçentlik ve profesörlük jürisi (5) ayrılamıyor.
 *   EK-5'in müzik alt tablosu ile EK-4'ün 15-16. maddeleri kayıttaki
 *       sanatsal etkinlik etiketlerine YAKLAŞTIRILARAK eşlendi; birebir
 *       karşılığı olmayan satırlar (konser anlatıcılığı, sınıf konseri
 *       yönetimi, etkinlik yöneticiliği, panel/söyleşi) girilmedi.
 *   EK-7'nin 4.e satırı ("diğer uluslararası/ulusal kitapta bölüm" 15)
 *       aynı ekte kitabın kendisinden (10/5) yüksek; tabloda yazdığı gibi
 *       girildi.
 *   EK-4 16.e "orkestra veya koro konserinde üyelik (yurt içi 0,5)" tam
 *       sayıya yuvarlanamadığı için tek satırda 1 puandan sayılıyor.
 *
 * ── LİSANSÜSTÜ TEZDEN ÜRETİLMİŞ YAYIN ──
 * EK-4, EK-5, EK-6 ve EK-7'de bu ayrı bir bölüm (3. madde) ve 1-2.
 * maddeler açıkça "tezlerden üretilmemiş olmak kaydıyla" diyor; kayıttaki
 * `tez_yayini` kategorisi doğrudan bu bölüme bağlandı. EK-1, EK-2 ve
 * EK-3'te böyle bir ayrım yok — oralarda `tez_yayini` kayıtları, makale
 * bölümünün ÇEYREK BİLGİSİ TAŞIMAYAN karşılığından (SCIE/SSCI için Q4
 * satırı) sayılıyor; Q1 tezli makaleniz varsa puanınız düşük görünür.
 *
 * ── YAZAR ÇARPANINDA BİLİNÇLİ SAPMA ──
 * Yedi ekin hepsi "diğer yayınlarda (bildiri, kitap ve kitap bölümü)
 * toplam puan yazarlar arasında EŞİT bölünür" diyor; makale çarpanı ise
 * sıraya göre kademeli. Motorun yazar tablosu kategori ayrımı taşımadığı
 * için MAKALE KURALI bütün kategorilere uygulandı. Çok yazarlı bir kitapta
 * ilk isimseniz puanınız OLDUĞUNDAN YÜKSEK görünür.
 *
 * Yönerge: yonerge/trakya.php
 */
$SCI = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)'];
$OZGUN = ['ozgun_makale'];
$DERLEME = ['derleme'];
$KISA = ['kisa_makale'];
$VAKA = ['vaka_teknik_not'];
$KISA_HEPSI = ['derleme', 'kisa_makale', 'vaka_teknik_not'];
$DERSLER = ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'];
$DOKTORA = ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'];

/**
 * Atıf bölümü. Yedi ekte de aynı: WoS/Scopus 3, BKCI kitap 2, TR Dizin 2,
 * diğer uluslararası/ulusal 2/1 (etiket ayrılmadığı için 1).
 */
$atifBlok = function (string $s): array {
    return [
        $s.'a' => ['baslik' => 'SCIE, SSCI, AHCI, ESCI ya da Scopus kapsamında eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 3],
        $s.'b' => ['baslik' => 'BKCI ya da Scopus kapsamındaki kitapta eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 2],
        $s.'c' => ['baslik' => 'TR Dizin kapsamındaki dergide eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
        $s.'d' => ['baslik' => 'Diğer uluslararası ya da ulusal kitap veya dergide eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],
        $s.'d-yk' => ['baslik' => 'Yönetim kurulu üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => [], 'puan' => 1],
    ];
};

/** Lisansüstü tez danışmanlığı. Yedi ekte de 8 / 4, ikinci danışmanlık 4 / 2. */
$tezBlok = function (string $s) use ($DOKTORA): array {
    return [
        $s.'a' => ['baslik' => 'Danışmanlığınızda tamamlanmış doktora ya da sanatta yeterlik tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => $DOKTORA, 'roller' => ['danisman'], 'puan' => 8],
        $s.'b' => ['baslik' => 'Danışmanlığınızda tamamlanmış yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 4],
        $s.'c-d' => ['baslik' => 'İkinci danışman olarak tamamlanmış doktora ya da sanatta yeterlik tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => $DOKTORA, 'roller' => ['es_danisman'], 'puan' => 4],
        $s.'c-y' => ['baslik' => 'İkinci danışman olarak tamamlanmış yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 2],
    ];
};

/** Bilimsel toplantı. EK-2 dışındaki altı ekte 8/5/3 — 6/3/2 — 4/2/1. */
$bildiriBlok = function (string $s): array {
    return [
        $s.'a' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan, tam metni CPCI\'da yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 8],
        $s.'b1-t' => ['baslik' => 'Diğer uluslararası bilimsel toplantıda sunulan, tam metni yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin'], 'puan' => 6],
        $s.'b1-o' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan, özeti ya da posteri yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 3],
        $s.'b2-t' => ['baslik' => 'Ulusal bilimsel toplantıda sunulan, tam metni yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 4],
        $s.'b2-o' => ['baslik' => 'Ulusal bilimsel toplantıda sunulan, özeti ya da posteri yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 2],
        $s.'dav' => ['baslik' => 'Bilimsel kongrede davetli konuşmacı ya da açılış konuşmacısı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 4],
    ];
};

/** Eğitim-öğretim: her ders 2 puan, madde toplamı en çok 10. */
$egitimBlok = function (string $s) use ($DERSLER): array {
    return [
        $s.'a' => ['baslik' => 'Doktora sonrası her yarıyıl verilen ön lisans, lisans ya da lisansüstü ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => $DERSLER, 'puan' => 2],
    ];
};

/** Patent / faydalı model. Başvuru satırı (5) tescilliden ayrılamadığı için yok. */
$patentBlok = function (string $s): array {
    return [
        $s.'a' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 40],
        $s.'b' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 20],
        $s.'c' => ['baslik' => 'Tescil edilmiş faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model'], 'puan' => 10],
        $s.'f' => ['baslik' => 'Endüstriyel model ya da tasarım belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım'], 'puan' => 5],
    ];
};

/** İdari görevler. Yedi ekte de aynı liste. */
$idariBlok = function (string $s): array {
    return [
        $s.'a' => ['baslik' => 'Dekanlık, yüksekokul, enstitü ya da meslek yüksekokulu müdürlüğü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü'], 'puan' => 10],
        $s.'a-y' => ['baslik' => 'Dekan yardımcılığı ya da müdür yardımcılığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.'], 'puan' => 5],
        $s.'c' => ['baslik' => 'Bölüm başkanlığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı'], 'puan' => 5],
        $s.'c-y' => ['baslik' => 'Bölüm başkan yardımcılığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı'], 'puan' => 3],
        $s.'d' => ['baslik' => 'Uygulama ve araştırma merkezi müdürlüğü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 3],
        $s.'d-yk' => ['baslik' => 'Yönetim kurulu üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => [], 'puan' => 1],
        $s.'e' => ['baslik' => 'Anabilim, bilim dalı ya da program başkanlığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 2],
        $s.'f' => ['baslik' => 'Komisyon, kurul ya da etik kurul görevi', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 1],
    ];
};

/** Toplumsal katkı: ulusal projede görev alma (2) ve ulusal danışmanlık (1). */
$toplumsalBlok = function (string $s): array {
    return [
        $s.'a2' => ['baslik' => 'Desteklenen sosyal sorumluluk projesinde görev almak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi'], 'puan' => 2],
        $s.'a3' => ['baslik' => 'Desteklenen sosyal sorumluluk projesinde eğitmenlik, danışmanlık ya da panelistlik yapmak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı'], 'puan' => 1],
    ];
};

/** Atama ve yükseltmelerde jüri üyeliği (rapor yazma koşuluyla). */
$juriBlok = function (string $s): array {
    return [
        $s.'e' => ['baslik' => 'Atama ve yükseltmelerde jüri üyeliği (rapor yazmak koşuluyla)', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 3],
    ];
};

/** EK-1, EK-3, EK-4, EK-5, EK-6 ve EK-7'nin ortak proje tablosu. */
$projeBlok = function (string $s): array {
    return [
        $s.'a-y' => ['baslik' => 'Tamamlanmış AB Çerçeve Programı ya da TÜBİTAK projesinde yürütücü veya koordinatör olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['yurutucu'], 'puan' => 40],
        $s.'a-a' => ['baslik' => 'Tamamlanmış AB Çerçeve Programı ya da TÜBİTAK projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 30],
        $s.'a-d' => ['baslik' => 'Tamamlanmış AB Çerçeve Programı ya da TÜBİTAK projesinde danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['danisman'], 'puan' => 15],
        $s.'b-y' => ['baslik' => 'Tamamlanmış uluslararası destekli bilimsel araştırma projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 40],
        $s.'b-a' => ['baslik' => 'Tamamlanmış uluslararası destekli bilimsel araştırma projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 20],
        $s.'b-d' => ['baslik' => 'Tamamlanmış uluslararası destekli bilimsel araştırma projesinde danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['danisman'], 'puan' => 10],
        $s.'c-y' => ['baslik' => 'Kamu kurumu ya da özel kuruluşla yapılan tamamlanmış Ar-Ge projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'TÜSEB', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 20],
        $s.'c-a' => ['baslik' => 'Kamu kurumu ya da özel kuruluşla yapılan tamamlanmış Ar-Ge projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'TÜSEB', 'Özel Sektör / STK'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 10],
        $s.'c-d' => ['baslik' => 'Kamu kurumu ya da özel kuruluşla yapılan tamamlanmış Ar-Ge projesinde danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'TÜSEB', 'Özel Sektör / STK'], 'roller' => ['danisman'], 'puan' => 6],
        $s.'d-y' => ['baslik' => 'Tamamlanmış üniversite TÜBAP projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 20],
        $s.'d-a' => ['baslik' => 'Tamamlanmış üniversite TÜBAP projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['arastirmaci', 'bursiyer', 'danisman'], 'puan' => 10],
        $s.'f' => ['baslik' => 'Desteklenen bilimsel araştırma projesinde eğitmenlik, danışmanlık, hakemlik ya da panelistlik yapmak', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'roller' => ['danisman', 'yurutucu', 'arastirmaci'], 'puan' => 6],
    ];
};

// ══════════════════════════════════════════════════════════════════════
// EK-1 (Sağlık Bilimleri) ve EK-3 (Mimarlık, Planlama ve Tasarım)
// İki ekin tabloları satır satır aynı puanları taşıyor; tek tablo.
// EK-3'ün 1. maddesinde meta analiz/derleme sütunu yok, EK-1'inkinden
// (Q2'de 20, Q3'te 15, Q4'te 10) sayılıyor.
// ══════════════════════════════════════════════════════════════════════
$ek1 = [
    // ══ 1. ULUSLARARASI MAKALE ══
    '1a-Q1' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q1 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $OZGUN, 'puan' => 60],
    '1a-Q2' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q2 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $OZGUN, 'puan' => 40],
    '1a-Q3' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q3 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $OZGUN, 'puan' => 30],
    '1a-Q4' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q4 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => $OZGUN, 'puan' => 20],
    '1a-Q1-d' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q1 dergide yayımlanmış meta analiz ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $DERLEME, 'puan' => 60],
    '1a-Q2-d' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q2 dergide yayımlanmış meta analiz ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $DERLEME, 'puan' => 20],
    '1a-Q3-d' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q3 dergide yayımlanmış meta analiz ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $DERLEME, 'puan' => 15],
    '1a-Q4-d' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q4 dergide yayımlanmış meta analiz ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => $DERLEME, 'puan' => 10],
    '1b' => ['baslik' => 'AHCI kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 25],
    '1c' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 15],
    '1d' => ['baslik' => 'Diğer uluslararası indekslerde taranan dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 10],
    '1e' => ['baslik' => 'Uluslararası indeksli dergide yayımlanmış editöre mektup, araştırma notu, özet ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => [...$SCI, 'AHCI', 'ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 6],

    // ══ 2. ULUSAL MAKALE ══
    '2a' => ['baslik' => 'TR Dizin kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 15],
    '2b' => ['baslik' => 'Diğer hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 8],
    '2c' => ['baslik' => 'Ulusal hakemli dergide yayımlanmış editöre mektup, araştırma notu, özet ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 4],

    // ══ 3. KİTAP ══
    '3a' => ['baslik' => 'BKCI kapsamındaki kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 40],
    '3b' => ['baslik' => 'BKCI kapsamındaki kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 20],
    '3c' => ['baslik' => 'Diğer uluslararası ya da ulusal kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı', 'Tahkik (Tenkitli Metin)'], 'puan' => 10],
    '3d' => ['baslik' => 'Diğer uluslararası ya da ulusal kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 5],
    '3e' => ['baslik' => 'Uluslararası kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 15],
    '3f' => ['baslik' => 'Uluslararası kitap bölümü çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 10],

    // ══ LİSANSÜSTÜ TEZDEN ÜRETİLMİŞ YAYIN ══
    // EK-1 ve EK-3'te ayrı bir bölüm yok; tez kaynaklı yayınlar makale ve
    // kitap satırlarından sayılıyor. SCIE/SSCI etiketi çeyrek taşımadığı
    // için en düşük çeyrekten (Q4, 20) hesaplanıyor.
    'ty-a' => ['baslik' => 'Lisansüstü tezinizden üretilmiş SCIE, SSCI ya da AHCI makalesi', 'kategori' => 'tez_yayini', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 20],
    'ty-b' => ['baslik' => 'Lisansüstü tezinizden üretilmiş ESCI ya da Scopus makalesi', 'kategori' => 'tez_yayini', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 15],
    'ty-c' => ['baslik' => 'Lisansüstü tezinizden üretilmiş TR Dizin makalesi', 'kategori' => 'tez_yayini', 'kaynaklar' => ['TR Dizin'], 'puan' => 15],
    'ty-d' => ['baslik' => 'Lisansüstü tezinizden üretilmiş BKCI kapsamındaki kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 40],
    'ty-e' => ['baslik' => 'Lisansüstü tezinizden üretilmiş BKCI kapsamındaki kitapta bölüm', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 20],
    'ty-f' => ['baslik' => 'Lisansüstü tezinizden üretilmiş diğer uluslararası ya da ulusal kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 10],
    'ty-g' => ['baslik' => 'Lisansüstü tezinizden üretilmiş diğer uluslararası ya da ulusal kitapta bölüm', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 5],
    'ty-h' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, CPCI\'da yayımlanmış bildiri', 'kategori' => 'tez_yayini', 'kaynaklar' => ['CPCI Bildiri'], 'puan' => 8],
    'ty-i' => ['baslik' => 'Lisansüstü tezinizden üretilmiş diğer yayın', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Diğer'], 'puan' => 2],

    // ══ 10. ÖDÜL ══
    '10a-f' => ['baslik' => 'YÖK Yılın Doktora Tezi, YÖK Üstün Başarı, TÜBİTAK Bilim, TÜBİTAK Teşvik, TÜBA GEBİP ya da TÜBA TESEP ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 30],
    '10g-j' => ['baslik' => 'Kongre sunum ya da poster ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon', 'Uluslararası Bilim/Sanat Ödülü', 'Ulusal Bilim/Sanat Ödülü', 'Burs'], 'puan' => 2],

    // ══ 11. EDİTÖRLÜK, HAKEMLİK, KONGRE GÖREVLERİ ══
    '11a1' => ['baslik' => 'SCIE, SSCI ya da AHCI kapsamındaki dergide baş editörlük veya editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 20],
    '11a1-e' => ['baslik' => 'ESCI ya da Scopus kapsamındaki dergide baş editörlük veya editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 10],
    '11a2' => ['baslik' => 'Diğer dergilerde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 5],
    '11b1' => ['baslik' => 'BKCI ya da Scopus kapsamındaki kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 25],
    '11b2' => ['baslik' => 'Diğer kitaplarda editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 8],
    '11c1' => ['baslik' => 'TR Dizin kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 10],
    '11-alan' => ['baslik' => 'Dergide alan editörlüğü ya da yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 2],
    '11-hak' => ['baslik' => 'Dergi, kitap ya da kongre hakemliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 1],

    // ══ 12. YARIŞMA, PROJE VE YAZILIM ══
    '12c' => ['baslik' => 'Yazılım, proje ve yapım yönetimi, tasarım ya da planlama alanlarında yazılım üreticisi olmak', 'kategori' => 'patent', 'kaynaklar' => ['Yazılım', 'Islahçı Hakkı / Çeşit Tescili', 'Ticarileştirme'], 'puan' => 20],
];

$ek1 = array_merge(
    $ek1,
    $atifBlok('4'),
    $tezBlok('5'),
    $projeBlok('6'),
    $bildiriBlok('7'),
    $egitimBlok('8'),
    $patentBlok('9'),
    $juriBlok('13'),
    $toplumsalBlok('14'),
    $idariBlok('15'),
);

// ══════════════════════════════════════════════════════════════════════
// EK-2 — Mühendislik, Fen Bilimleri ve Matematik (Ziraat de buradan)
// ══════════════════════════════════════════════════════════════════════
$ek2 = [
    // ══ 1. ULUSLARARASI MAKALE ══
    '1a-Q1' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q1 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $OZGUN, 'puan' => 60],
    '1a-Q2' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q2 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $OZGUN, 'puan' => 40],
    '1a-Q3' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q3 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $OZGUN, 'puan' => 30],
    '1a-Q4' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q4 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => $OZGUN, 'puan' => 20],
    '1a-Q1-d' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q1 dergide yayımlanmış meta analiz ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $DERLEME, 'puan' => 60],
    '1a-Q2-d' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q2 dergide yayımlanmış meta analiz ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $DERLEME, 'puan' => 20],
    '1a-Q3-d' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q3 dergide yayımlanmış meta analiz ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $DERLEME, 'puan' => 15],
    '1a-Q4-d' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q4 dergide yayımlanmış meta analiz ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => $DERLEME, 'puan' => 10],
    '1b-Q1' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q1 dergide yayımlanmış kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $KISA, 'puan' => 30],
    '1b-Q2' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q2 dergide yayımlanmış kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $KISA, 'puan' => 20],
    '1b-Q3' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q3 dergide yayımlanmış kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $KISA, 'puan' => 15],
    '1b-Q4' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q4 dergide yayımlanmış kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => $KISA, 'puan' => 10],
    '1c-Q1' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q1 dergide yayımlanmış olgu sunumu, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $VAKA, 'puan' => 15],
    '1c-Q2' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q2 dergide yayımlanmış olgu sunumu, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $VAKA, 'puan' => 10],
    '1c-Q3' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q3 dergide yayımlanmış olgu sunumu, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $VAKA, 'puan' => 8],
    '1c-Q4' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q4 dergide yayımlanmış olgu sunumu, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => $VAKA, 'puan' => 5],
    '1d-1' => ['baslik' => 'AHCI kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => $OZGUN, 'puan' => 25],
    '1d-1d' => ['baslik' => 'AHCI kapsamındaki dergide yayımlanmış meta analiz ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => $DERLEME, 'puan' => 15],
    '1d-2' => ['baslik' => 'AHCI kapsamındaki dergide yayımlanmış kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => $KISA, 'puan' => 10],
    '1d-3' => ['baslik' => 'AHCI kapsamındaki dergide yayımlanmış olgu sunumu, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => $VAKA, 'puan' => 3],
    '1e-1' => ['baslik' => 'ESCI, Scopus ya da PubMed Medline kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $OZGUN, 'puan' => 15],
    '1e-1d' => ['baslik' => 'ESCI, Scopus ya da PubMed Medline kapsamındaki dergide yayımlanmış meta analiz ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $DERLEME, 'puan' => 10],
    '1e-2' => ['baslik' => 'ESCI, Scopus ya da PubMed Medline kapsamındaki dergide yayımlanmış kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $KISA, 'puan' => 8],
    '1e-3' => ['baslik' => 'ESCI, Scopus ya da PubMed Medline kapsamındaki dergide yayımlanmış olgu sunumu, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $VAKA, 'puan' => 4],
    '1f-1' => ['baslik' => 'Diğer uluslararası dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $OZGUN, 'puan' => 10],
    '1f-1d' => ['baslik' => 'Diğer uluslararası dergide yayımlanmış meta analiz ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $DERLEME, 'puan' => 8],
    '1f-2' => ['baslik' => 'Diğer uluslararası dergide yayımlanmış kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $KISA, 'puan' => 5],
    '1f-3' => ['baslik' => 'Diğer uluslararası dergide yayımlanmış olgu sunumu, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $VAKA, 'puan' => 3],

    // ══ 2. ULUSAL MAKALE ══
    '2a-1' => ['baslik' => 'TR Dizin kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $OZGUN, 'puan' => 15],
    '2a-1d' => ['baslik' => 'TR Dizin kapsamındaki dergide yayımlanmış meta analiz ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $DERLEME, 'puan' => 10],
    '2a-2' => ['baslik' => 'TR Dizin kapsamındaki dergide yayımlanmış kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $KISA, 'puan' => 8],
    '2a-3' => ['baslik' => 'TR Dizin kapsamındaki dergide yayımlanmış olgu sunumu, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $VAKA, 'puan' => 6],
    '2b-1' => ['baslik' => 'Diğer ulusal dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $OZGUN, 'puan' => 8],
    '2b-1d' => ['baslik' => 'Diğer ulusal dergide yayımlanmış meta analiz ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $DERLEME, 'puan' => 6],
    '2b-2' => ['baslik' => 'Diğer ulusal dergide yayımlanmış kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 5],
    '2b-3' => ['baslik' => 'Diğer ulusal dergide yayımlanmış olgu sunumu, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $VAKA, 'puan' => 3],

    // ══ 3. KİTAP ══
    '3a-1' => ['baslik' => 'BKCI ya da Scopus Book Series kapsamındaki kitapta yazarlık', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 40],
    '3a-1c' => ['baslik' => 'BKCI ya da Scopus Book Series kapsamındaki kitapta çeviri yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 20],
    '3a-2' => ['baslik' => 'BKCI ya da Scopus Book Series kapsamındaki kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 20],
    '3a-2c' => ['baslik' => 'BKCI ya da Scopus Book Series kapsamındaki kitapta bölüm çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 10],
    '3b-1' => ['baslik' => 'Diğer uluslararası ya da ulusal kitapta yazarlık', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı', 'Tahkik (Tenkitli Metin)'], 'puan' => 5],
    '3b-2' => ['baslik' => 'Diğer uluslararası ya da ulusal kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 3],

    // ══ LİSANSÜSTÜ TEZDEN ÜRETİLMİŞ YAYIN ══
    'ty-a' => ['baslik' => 'Lisansüstü tezinizden üretilmiş SCIE, SSCI ya da AHCI makalesi', 'kategori' => 'tez_yayini', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 20],
    'ty-b' => ['baslik' => 'Lisansüstü tezinizden üretilmiş ESCI ya da Scopus makalesi', 'kategori' => 'tez_yayini', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 15],
    'ty-c' => ['baslik' => 'Lisansüstü tezinizden üretilmiş TR Dizin makalesi', 'kategori' => 'tez_yayini', 'kaynaklar' => ['TR Dizin'], 'puan' => 15],
    'ty-d' => ['baslik' => 'Lisansüstü tezinizden üretilmiş BKCI kapsamındaki kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 40],
    'ty-e' => ['baslik' => 'Lisansüstü tezinizden üretilmiş BKCI kapsamındaki kitapta bölüm', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 20],
    'ty-f' => ['baslik' => 'Lisansüstü tezinizden üretilmiş diğer uluslararası ya da ulusal kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 5],
    'ty-g' => ['baslik' => 'Lisansüstü tezinizden üretilmiş diğer uluslararası ya da ulusal kitapta bölüm', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 3],
    'ty-h' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, CPCI\'da yayımlanmış bildiri', 'kategori' => 'tez_yayini', 'kaynaklar' => ['CPCI Bildiri'], 'puan' => 8],
    'ty-i' => ['baslik' => 'Lisansüstü tezinizden üretilmiş diğer yayın', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Diğer'], 'puan' => 2],

    // ══ 6. BİLİMSEL ARAŞTIRMA PROJESİ ══
    '6a-y' => ['baslik' => 'Tamamlanmış AB Çerçeve Programı ya da uluslararası nitelikli TÜBİTAK projesinde yürütücü veya koordinatör olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 40],
    '6a-a' => ['baslik' => 'Tamamlanmış AB Çerçeve Programı ya da uluslararası nitelikli TÜBİTAK projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 30],
    '6a-d' => ['baslik' => 'Tamamlanmış AB Çerçeve Programı ya da uluslararası nitelikli TÜBİTAK projesinde danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['danisman'], 'puan' => 10],
    '6b-y' => ['baslik' => 'Tamamlanmış TÜBİTAK akademik ya da kamu kurumu Ar-Ge projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'Diğer Kamu Kurumu', 'TÜSEB', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 40],
    '6b-a' => ['baslik' => 'Tamamlanmış TÜBİTAK akademik ya da kamu kurumu Ar-Ge projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'Diğer Kamu Kurumu', 'TÜSEB', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 20],
    '6b-d' => ['baslik' => 'Tamamlanmış TÜBİTAK akademik ya da kamu kurumu Ar-Ge projesinde danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'Diğer Kamu Kurumu', 'TÜSEB', 'Diğer Uluslararası Fon'], 'roller' => ['danisman'], 'puan' => 5],
    '6d-y' => ['baslik' => 'Tamamlanmış BAP araştırma projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 20],
    '6d-a' => ['baslik' => 'Tamamlanmış BAP araştırma projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 10],
    '6d-d' => ['baslik' => 'Tamamlanmış BAP araştırma projesinde danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['danisman'], 'puan' => 2],
    '6f-y' => ['baslik' => 'Tamamlanmış üniversite-sanayi iş birliği projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 20],
    '6f-a' => ['baslik' => 'Tamamlanmış üniversite-sanayi iş birliği projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 10],
    '6f-d' => ['baslik' => 'Tamamlanmış üniversite-sanayi iş birliği projesinde danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['danisman'], 'puan' => 6],
    '6e' => ['baslik' => 'Tamamlanmış BAP lisansüstü tez projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu', 'arastirmaci', 'danisman', 'bursiyer'], 'puan' => 5],

    // ══ 10. ÖDÜL ══
    '10a' => ['baslik' => 'Uluslararası bilim ödülü almak', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 40],
    '10b-h' => ['baslik' => 'YÖK, TÜBİTAK ya da TÜBA ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 30],
    '10i' => ['baslik' => 'Üniversite rektörlüklerince verilen bilim ödülü almak', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'Burs'], 'puan' => 10],
    '10j' => ['baslik' => 'Meslek odaları tarafından düzenlenen yarışmalarda ödül almak', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 5],

    // ══ 11. EDİTÖRLÜK — 12. HAKEMLİK ══
    '11a-Q1' => ['baslik' => 'SCIE, SSCI ya da AHCI kapsamındaki Q1 dergide baş editörlük veya editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)'], 'puan' => 20],
    '11a-Q2' => ['baslik' => 'SCIE, SSCI ya da AHCI kapsamındaki Q2 dergide baş editörlük veya editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q2)'], 'puan' => 16],
    '11a-Q3' => ['baslik' => 'SCIE, SSCI ya da AHCI kapsamındaki Q3 dergide baş editörlük veya editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q3)'], 'puan' => 14],
    '11a-Q4' => ['baslik' => 'SCIE, SSCI ya da AHCI kapsamındaki Q4 dergide baş editörlük veya editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q4)'], 'puan' => 12],
    '11b' => ['baslik' => 'ESCI, Scopus, PubMed Medline ya da TR Dizin kapsamındaki dergide baş editörlük veya editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi', 'TR Dizin Dergi'], 'puan' => 10],
    '11c' => ['baslik' => 'Diğer dergilerde baş editörlük veya editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 5],
    '11-kurul' => ['baslik' => 'Dergide editör yardımcılığı ya da editoryal kurul üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 3],
    '3a-3' => ['baslik' => 'BKCI ya da Scopus Book Series kapsamındaki kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 15],
    '3b-3' => ['baslik' => 'Diğer kitaplarda editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 2],
    '12-hak' => ['baslik' => 'Dergi, kitap ya da kongre hakemliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 1],

    // ══ 15. DİĞER ══
    '15b' => ['baslik' => 'Kamu ve özel sektör kuruluşlarında danışmanlık yapmak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı'], 'puan' => 2],
    '15c' => ['baslik' => 'Toplumsal katkı için düzenlenen konferanslarda konuşmacı olmak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Bilim İletişimi / Popüler Yayın'], 'puan' => 2],
    '6h' => ['baslik' => 'Tamamlanmış sosyal sorumluluk projesi yapmak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi'], 'puan' => 5],
];

$ek2 = array_merge(
    $ek2,
    $atifBlok('4'),
    $tezBlok('5'),
    $bildiriBlok('7'),
    $egitimBlok('8'),
    $patentBlok('9'),
    $juriBlok('13'),
    $idariBlok('14'),
);

// ══════════════════════════════════════════════════════════════════════
// EK-4 — Sosyal ve Beşeri Bilimler, Eğitim Bilimleri, Filoloji, İlahiyat
// ve Öğretmen Yetiştirme. Hukuk temel alanı da bu ekten değerlendiriliyor
// (yönerge yedi ekte hukuku adıyla saymıyor; sosyal ve beşeri bilimler
// eki en yakın karşılık).
// ══════════════════════════════════════════════════════════════════════
$ek4 = [
    // ══ 1-2. MAKALE ══
    '1a-Q1' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q1 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $OZGUN, 'puan' => 60],
    '1a-Q2' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q2 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $OZGUN, 'puan' => 40],
    '1a-Q3' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q3 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $OZGUN, 'puan' => 30],
    '1a-Q4' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q4 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => $OZGUN, 'puan' => 20],
    '1a-Q1-d' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q1 dergide yayımlanmış derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $DERLEME, 'puan' => 60],
    '1a-Q2-d' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q2 dergide yayımlanmış derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $DERLEME, 'puan' => 20],
    '1a-Q3-d' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q3 dergide yayımlanmış derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $DERLEME, 'puan' => 15],
    '1a-Q4-d' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q4 dergide yayımlanmış derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => $DERLEME, 'puan' => 10],
    '1b' => ['baslik' => 'AHCI kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 25],
    '1c' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 15],
    '1d' => ['baslik' => 'Diğer uluslararası indekslerde taranan dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 10],
    '1e' => ['baslik' => 'Uluslararası indeksli dergide yayımlanmış editöre mektup, araştırma notu, özet ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => [...$SCI, 'AHCI', 'ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 6],
    '2a' => ['baslik' => 'TR Dizin kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 15],
    '2b' => ['baslik' => 'Diğer hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 8],
    '2c' => ['baslik' => 'Ulusal hakemli dergide yayımlanmış editöre mektup, araştırma notu, özet ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 4],

    // ══ 3. LİSANSÜSTÜ TEZLERDEN ÜRETİLMİŞ YAYIN ══
    '3a' => ['baslik' => 'Lisansüstü tezinizden üretilmiş SCIE, SSCI ya da AHCI makalesi', 'kategori' => 'tez_yayini', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 40],
    '3b' => ['baslik' => 'Lisansüstü tezinizden üretilmiş ESCI ya da Scopus makalesi', 'kategori' => 'tez_yayini', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 30],
    '3d' => ['baslik' => 'Lisansüstü tezinizden üretilmiş TR Dizin makalesi', 'kategori' => 'tez_yayini', 'kaynaklar' => ['TR Dizin'], 'puan' => 20],
    '3e' => ['baslik' => 'Lisansüstü tezinizden üretilmiş BKCI kapsamındaki kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 40],
    '3f' => ['baslik' => 'Lisansüstü tezinizden üretilmiş BKCI kapsamındaki kitapta bölüm', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 20],
    '3g' => ['baslik' => 'Lisansüstü tezinizden üretilmiş diğer uluslararası ya da ulusal kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 10],
    '3h' => ['baslik' => 'Lisansüstü tezinizden üretilmiş diğer uluslararası ya da ulusal kitapta bölüm', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 6],
    '3i' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, CPCI\'da yayımlanmış bildiri', 'kategori' => 'tez_yayini', 'kaynaklar' => ['CPCI Bildiri'], 'puan' => 6],
    '3j' => ['baslik' => 'Lisansüstü tezinizden üretilmiş diğer yayın', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Diğer'], 'puan' => 3],

    // ══ 4. KİTAP ══
    '4a' => ['baslik' => 'BKCI ya da Scopus kapsamındaki kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 40],
    '4b' => ['baslik' => 'BKCI ya da Scopus kapsamındaki kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 20],
    '4cd' => ['baslik' => 'Diğer uluslararası ya da ulusal kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı'], 'puan' => 10],
    '4ef' => ['baslik' => 'Diğer uluslararası ya da ulusal kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 5],
    '4g' => ['baslik' => 'Uluslararası kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 15],
    '4h' => ['baslik' => 'Uluslararası kitap bölümü çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 10],
    '4i' => ['baslik' => 'Ansiklopedilerde madde yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 5],
    '4j' => ['baslik' => 'Tahkik (tenkitli metin neşri) türünde uluslararası ya da ulusal kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Tahkik (Tenkitli Metin)'], 'puan' => 2],

    // ══ 11. ÖDÜL ══
    '11a-f' => ['baslik' => 'YÖK Yılın Doktora Tezi, YÖK Üstün Başarı, TÜBİTAK Bilim, TÜBİTAK Teşvik, TÜBA GEBİP ya da TÜBA TESEP ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 30],
    '11gh' => ['baslik' => 'Uluslararası kongre, yarışma ya da sanat etkinliğinde ödül veya mansiyon almak', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 15],
    '11ij' => ['baslik' => 'Ulusal kongre, yarışma ya da sanat etkinliğinde ödül veya mansiyon almak', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 10],
    '11k' => ['baslik' => 'Ulusal kuruluş ve derneklerce verilen bilim ya da teşvik ödülü almak', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'Burs'], 'puan' => 7],

    // ══ 12. EDİTÖRLÜK VE HAKEMLİK ══
    '12a' => ['baslik' => 'SCIE, SSCI ya da AHCI kapsamındaki dergide baş editörlük veya editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 20],
    '12b' => ['baslik' => 'ESCI ya da Scopus kapsamındaki dergide baş editörlük veya editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 10],
    '12f' => ['baslik' => 'TR Dizin kapsamındaki dergide baş editörlük veya editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 10],
    '12g' => ['baslik' => 'Diğer dergilerde baş editörlük veya editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 5],
    '12d' => ['baslik' => 'BKCI ya da Scopus kapsamındaki kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 25],
    '12h' => ['baslik' => 'Diğer kitaplarda editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 8],
    '12-alan' => ['baslik' => 'Dergide alan editörlüğü ya da yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 2],
    '12-hak' => ['baslik' => 'Dergi, kitap ya da kongre hakemliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 1],

    // ══ 13-16. SANATSAL UYGULAMA, SANAT-TASARIM VE MÜZİK-SAHNE PERFORMANSI ══
    // Yalnız Güzel Sanatlar Eğitimi ve İlahiyat bölümleri kullanabiliyor.
    '13a' => ['baslik' => 'Özgün eser, beste ya da tasarım sunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Özgün Eser / Beste / Tasarım'], 'puan' => 5],
    '15ab' => ['baslik' => 'Özgün eserinizin sanat, eğitim ya da kültür kurumlarınca satın alınması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Satın Alınması (Yurt İçi)'], 'puan' => 20],
    '15c' => ['baslik' => 'Özgün eserinizin yurt dışında sinema, televizyon ya da radyoda yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)'], 'puan' => 30],
    '15d' => ['baslik' => 'Özgün eserinizin yurt içinde sinema, televizyon ya da radyoda yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'], 'puan' => 20],
    '15e' => ['baslik' => 'Yurt dışında kişisel etkinlik (festival, sergi, proje, gösterim)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)'], 'puan' => 25],
    '15f' => ['baslik' => 'Yurt içinde kişisel etkinlik (festival, sergi, proje, gösterim)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)'], 'puan' => 15],
    '15i' => ['baslik' => 'Uluslararası karma sanat ya da tasarım etkinliğine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)'], 'puan' => 10],
    '15j' => ['baslik' => 'Ulusal karma sanat ya da tasarım etkinliğine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)'], 'puan' => 5],
    '16a-d' => ['baslik' => 'Orkestra eşliğinde konçerto icra etmek (yurt dışı ya da uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Solistlik (Uluslararası)'], 'puan' => 16],
    '16a-i' => ['baslik' => 'Orkestra eşliğinde konçerto icra etmek (yurt içi)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Solistlik (Ulusal)'], 'puan' => 8],
    '16f-d' => ['baslik' => 'Oda müziği konserinde grup üyeliği (yurt dışı ya da uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Uluslararası)'], 'puan' => 8],
    '16f-i' => ['baslik' => 'Oda müziği konserinde grup üyeliği (yurt içi)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Ulusal)'], 'puan' => 4],
    '16g-d' => ['baslik' => 'Resital (yurt dışı ya da uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Resital (Uluslararası)'], 'puan' => 12],
    '16g-i' => ['baslik' => 'Resital (yurt içi)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Resital (Ulusal)'], 'puan' => 6],
    '16c-d' => ['baslik' => 'Orkestra konserinde başkemancılık (yurt dışı ya da uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Başkemancılık (Uluslararası)'], 'puan' => 3],
    '16c-i' => ['baslik' => 'Orkestra konserinde başkemancılık (yurt içi)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Başkemancılık (Ulusal)'], 'puan' => 2],
    '16d-d' => ['baslik' => 'Orkestra konserinde grup şefliği (yurt dışı ya da uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Grup Şefliği (Uluslararası)'], 'puan' => 2],
    '16d-i' => ['baslik' => 'Orkestra konserinde grup şefliği (yurt içi)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Grup Şefliği (Ulusal)'], 'puan' => 1],
    '16e' => ['baslik' => 'Orkestra veya koro konserinde üyelik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra / Koro Üyeliği'], 'puan' => 1],
    '16h' => ['baslik' => 'CD, DVD ve benzeri kayıt ortamlarında performans', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Bandrollü Kayıt (CD/DVD)', 'Albüm / Konser Kaydı', 'Karma Albüm / CD-DVD Katkısı'], 'puan' => 5],
    '16s-d' => ['baslik' => 'Orkestra veya koro şefliği performansı (yurt dışı)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra Şefliği (Uluslararası)', 'Koro Şefliği (Uluslararası)', 'Opera Şefliği (Uluslararası)'], 'puan' => 12],
    '16s-i' => ['baslik' => 'Orkestra veya koro şefliği performansı (yurt içi)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra Şefliği (Ulusal)', 'Koro Şefliği (Ulusal)', 'Opera Şefliği (Ulusal)'], 'puan' => 6],
    '16p-d' => ['baslik' => 'Masterclass ya da workshop\'a aktif katılım (yurt dışı ya da uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Masterclass (Uluslararası)'], 'puan' => 4],
    '16p-i' => ['baslik' => 'Masterclass ya da workshop\'a aktif katılım (yurt içi)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Masterclass (Ulusal)'], 'puan' => 2],
];

$ek4 = array_merge(
    $ek4,
    $atifBlok('5'),
    $tezBlok('6'),
    $projeBlok('7'),
    $bildiriBlok('8'),
    $egitimBlok('9'),
    $patentBlok('10'),
    $juriBlok('17'),
    $toplumsalBlok('18'),
    $idariBlok('19'),
);

// ══════════════════════════════════════════════════════════════════════
// EK-5 (Devlet Konservatuvarı) ve EK-6 (Güzel Sanatlar) ortak gövdesi
// ══════════════════════════════════════════════════════════════════════
$gs = [
    '1a-Q1' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q1 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 60],
    '1a-Q2' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q2 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 40],
    '1a-Q3' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q3 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 30],
    '1a-Q4' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q4 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 20],
    '1b' => ['baslik' => 'AHCI kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 25],
    '1d' => ['baslik' => 'Diğer uluslararası indekslerde taranan dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 10],
    '1e' => ['baslik' => 'Uluslararası indeksli dergide yayımlanmış editöre mektup, araştırma notu, özet ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => [...$SCI, 'AHCI', 'ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 6],
    '2a' => ['baslik' => 'TR Dizin kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 15],
    '2b' => ['baslik' => 'Diğer hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 8],
    '2c' => ['baslik' => 'Ulusal hakemli dergide yayımlanmış araştırma notu ya da kitap incelemesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 4],

    // ══ 3. LİSANSÜSTÜ TEZLERDEN ÜRETİLMİŞ YAYIN ══
    '3a' => ['baslik' => 'Lisansüstü tezinizden üretilmiş SCIE, SSCI ya da AHCI makalesi', 'kategori' => 'tez_yayini', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 40],
    '3b' => ['baslik' => 'Lisansüstü tezinizden üretilmiş ESCI ya da Scopus makalesi', 'kategori' => 'tez_yayini', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 30],
    '3d' => ['baslik' => 'Lisansüstü tezinizden üretilmiş TR Dizin makalesi', 'kategori' => 'tez_yayini', 'kaynaklar' => ['TR Dizin'], 'puan' => 20],
    '3e' => ['baslik' => 'Lisansüstü tezinizden üretilmiş BKCI kapsamındaki kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 40],
    '3f' => ['baslik' => 'Lisansüstü tezinizden üretilmiş BKCI kapsamındaki kitapta bölüm', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 20],
    '3g' => ['baslik' => 'Lisansüstü tezinizden üretilmiş diğer uluslararası ya da ulusal kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 10],
    '3h' => ['baslik' => 'Lisansüstü tezinizden üretilmiş diğer uluslararası ya da ulusal kitapta bölüm', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 6],
    '3j' => ['baslik' => 'Lisansüstü tezinizden üretilmiş diğer yayın', 'kategori' => 'tez_yayini', 'kaynaklar' => ['CPCI Bildiri', 'Diğer'], 'puan' => 3],

    // ══ 4. KİTAP ══
    '4a' => ['baslik' => 'BKCI kapsamındaki kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 40],
    '4b' => ['baslik' => 'BKCI kapsamındaki kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 20],
    '4c' => ['baslik' => 'Diğer uluslararası ya da ulusal kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı', 'Tahkik (Tenkitli Metin)'], 'puan' => 10],
    '4d' => ['baslik' => 'Diğer uluslararası ya da ulusal kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 5],
    '4e' => ['baslik' => 'Uluslararası kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 15],
    '4f' => ['baslik' => 'Uluslararası kitap bölümü çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 10],

    // ══ 11. ÖDÜL ══
    '11a-f' => ['baslik' => 'YÖK Yılın Doktora Tezi, YÖK Üstün Başarı, TÜBİTAK Bilim, TÜBİTAK Teşvik, TÜBA GEBİP ya da TÜBA TESEP ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'Ufuk Avrupa / ERC Ödülü', 'Uluslararası Bilim/Sanat Ödülü'], 'puan' => 30],
    '11g-i' => ['baslik' => 'Alanıyla ilgili jürili yarışmalardan ödül almak', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 20],
    '11j-k' => ['baslik' => 'Ulusal kuruluş, dernek ya da üniversitemizce verilen bilim ve teşvik ödülü almak', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'Burs'], 'puan' => 10],

    // ══ 12. EDİTÖRLÜK VE HAKEMLİK ══
    '12a1' => ['baslik' => 'SCIE, SSCI ya da AHCI kapsamındaki dergide baş editörlük veya editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 20],
    '12a1-e' => ['baslik' => 'ESCI ya da Scopus kapsamındaki dergide baş editörlük veya editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 10],
    '12a2' => ['baslik' => 'Diğer dergilerde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 5],
    '12b1' => ['baslik' => 'BKCI ya da Scopus kapsamındaki kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 25],
    '12b2' => ['baslik' => 'Diğer kitaplarda editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 8],
    '12c1' => ['baslik' => 'TR Dizin kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 10],
    '12-alan' => ['baslik' => 'Dergide alan editörlüğü ya da yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 2],
    '12-hak' => ['baslik' => 'Dergi, kitap ya da kongre hakemliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 1],

    // ══ 14. JÜRİ ÜYELİKLERİ ══
    '14ab-u' => ['baslik' => 'Uluslararası sanat ve tasarım yarışmalarında jüri üyeliği, küratörlük ya da sergi yürütücülüğü', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Uluslararası)'], 'puan' => 5],
    '14ab-n' => ['baslik' => 'Ulusal sanat ve tasarım yarışmalarında jüri üyeliği, küratörlük ya da sergi yürütücülüğü', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Üyeliği (Ulusal)', 'Jüri Başkanlığı (Ulusal)'], 'puan' => 3],
];

$gs = array_merge(
    $gs,
    $atifBlok('5'),
    $tezBlok('6'),
    $projeBlok('7'),
    $bildiriBlok('8'),
    $egitimBlok('9'),
    $patentBlok('10'),
    $idariBlok('13'),
    $juriBlok('14'),
    $toplumsalBlok('15'),
);

// ── EK-5: ESCI/Scopus makalesi 10 puan; müzik bilim/sanat alt tablosu ──
$ek5 = array_merge($gs, [
    '1c' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 10],
    'M1a1-d' => ['baslik' => 'Resital (yurt dışı)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Resital (Uluslararası)'], 'puan' => 20],
    'M1a1-i' => ['baslik' => 'Resital (yurt içi)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Resital (Ulusal)'], 'puan' => 15],
    'M1a2-d' => ['baslik' => 'Orkestra eşliğinde konçerto icra etmek (yurt dışı)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Solistlik (Uluslararası)'], 'puan' => 20],
    'M1a2-i' => ['baslik' => 'Orkestra eşliğinde konçerto icra etmek (yurt içi)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Solistlik (Ulusal)'], 'puan' => 15],
    'M1a5-d' => ['baslik' => 'Orkestra konserinde şeflik (yurt dışı)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra Şefliği (Uluslararası)', 'Koro Şefliği (Uluslararası)', 'Opera Şefliği (Uluslararası)'], 'puan' => 4],
    'M1a5-i' => ['baslik' => 'Orkestra konserinde şeflik (yurt içi)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra Şefliği (Ulusal)', 'Koro Şefliği (Ulusal)', 'Opera Şefliği (Ulusal)'], 'puan' => 3],
    'M1a6-d' => ['baslik' => 'Orkestra konserinde başkemancılık (yurt dışı)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Başkemancılık (Uluslararası)'], 'puan' => 4],
    'M1a6-i' => ['baslik' => 'Orkestra konserinde başkemancılık (yurt içi)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Başkemancılık (Ulusal)'], 'puan' => 3],
    'M1a7-d' => ['baslik' => 'Orkestra konserinde grup şefliği (yurt dışı)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Grup Şefliği (Uluslararası)'], 'puan' => 3],
    'M1a7-i' => ['baslik' => 'Orkestra konserinde grup şefliği (yurt içi)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Grup Şefliği (Ulusal)'], 'puan' => 2],
    'M1a8' => ['baslik' => 'Orkestra konserinde üyelik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra / Koro Üyeliği'], 'puan' => 1],
    'M1b' => ['baslik' => 'CD, DVD ve benzeri kayıt ortamlarında performans', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Bandrollü Kayıt (CD/DVD)', 'Albüm / Konser Kaydı', 'Karma Albüm / CD-DVD Katkısı'], 'puan' => 5],
    'M1e-d' => ['baslik' => 'Oda müziği konserinde icracı olarak bulunmak (uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Uluslararası)'], 'puan' => 10],
    'M1e-i' => ['baslik' => 'Oda müziği konserinde icracı olarak bulunmak (ulusal)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Ulusal)'], 'puan' => 10],
    'M1f3' => ['baslik' => 'Özgün eser sunmak (solo, oda müziği, senfonik ya da elektronik müzik)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Özgün Eser / Beste / Tasarım', 'Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)', 'Elektronik Müzik Eseri (≥15 dk)', 'Elektronik Müzik Eseri (<15 dk)'], 'puan' => 10],
    '9c' => ['baslik' => 'Master Class ya da workshop\'a aktif katılım (yurt dışı)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Masterclass (Uluslararası)'], 'puan' => 4],
    '9d' => ['baslik' => 'Master Class ya da workshop\'a aktif katılım (yurt içi)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Masterclass (Ulusal)'], 'puan' => 2],
]);

// ── EK-6: ESCI/Scopus makalesi 15 puan; 17. madde sanatsal etkinlikler ──
$ek6 = array_merge($gs, [
    '1c' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 15],
    '17ab' => ['baslik' => 'Özgün bireysel (kişisel) etkinlik: sergi, bienal, trienal, festival, gösteri ya da fuar', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 40],
    '17c-d' => ['baslik' => 'Karma, grup ya da toplu etkinlik: sergi, bienal, trienal, festival, gösteri ya da fuar', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Elektronik Karma Sergi (Uluslararası)', 'Elektronik Karma Sergi (Ulusal)'], 'puan' => 10],
    '17e-g' => ['baslik' => 'Sanat ve tasarım sempozyumu ya da çalıştayına katılım', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 10],
    '17i-j' => ['baslik' => 'Eserlerinizin, tasarımlarınızın ya da projelerinizin müzeye kabul edilmesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Müzeye Kabulü (Yurt İçi)'], 'puan' => 10],
    '17k-l' => ['baslik' => 'Eserlerinizin kitap, ansiklopedi, katalog, dergi, televizyon ya da filmde yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Satın Alınması (Yurt İçi)', 'Eserin Haber Olması (Uluslararası)', 'Eserin Haber Olması (Ulusal)'], 'puan' => 5],
    '17m-n' => ['baslik' => 'Alanıyla ilgili etkinliklerde jüri üyeliği (yurt dışı ya da yurt içi uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Uluslararası)'], 'puan' => 10],
    '17o' => ['baslik' => 'Alanıyla ilgili etkinliklerde jüri üyeliği (yurt içi ulusal)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Üyeliği (Ulusal)', 'Jüri Başkanlığı (Ulusal)'], 'puan' => 5],
]);

// ══════════════════════════════════════════════════════════════════════
// EK-7 — Spor Bilimleri
// ══════════════════════════════════════════════════════════════════════
$ek7 = [
    '1a-Q1' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q1 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 60],
    '1a-Q2' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q2 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 40],
    '1a-Q3' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q3 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 30],
    '1a-Q4' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q4 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 20],
    '1b' => ['baslik' => 'AHCI kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 25],
    '1c' => ['baslik' => 'ESCI, Scopus, SPORTDiscus, ERIC, HW Wilson ya da PubMed kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 15],
    '1d' => ['baslik' => 'Diğer uluslararası indekslerde taranan dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 10],
    '1e' => ['baslik' => 'Uluslararası indeksli dergide yayımlanmış editöre mektup, araştırma notu, özet ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => [...$SCI, 'AHCI', 'ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 6],
    '2a' => ['baslik' => 'TR Dizin kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 15],
    '2b' => ['baslik' => 'Diğer hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 10],
    '2c' => ['baslik' => 'Ulusal hakemli dergide yayımlanmış editöre mektup, araştırma notu, özet ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 5],

    // ══ 3. LİSANSÜSTÜ TEZLERDEN ÜRETİLMİŞ YAYIN ══
    '3a' => ['baslik' => 'Lisansüstü tezinizden üretilmiş SCIE, SSCI ya da AHCI makalesi', 'kategori' => 'tez_yayini', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 40],
    '3b' => ['baslik' => 'Lisansüstü tezinizden üretilmiş ESCI, Scopus, SPORTDiscus, ERIC ya da PubMed makalesi', 'kategori' => 'tez_yayini', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 30],
    '3d' => ['baslik' => 'Lisansüstü tezinizden üretilmiş TR Dizin makalesi', 'kategori' => 'tez_yayini', 'kaynaklar' => ['TR Dizin'], 'puan' => 20],
    '3e' => ['baslik' => 'Lisansüstü tezinizden üretilmiş BKCI kapsamındaki kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 40],
    '3f' => ['baslik' => 'Lisansüstü tezinizden üretilmiş BKCI kapsamındaki kitapta bölüm', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 20],
    '3g' => ['baslik' => 'Lisansüstü tezinizden üretilmiş diğer uluslararası ya da ulusal kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 10],
    '3h' => ['baslik' => 'Lisansüstü tezinizden üretilmiş diğer uluslararası ya da ulusal kitapta bölüm', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 6],
    '3i' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, CPCI\'da yayımlanmış bildiri', 'kategori' => 'tez_yayini', 'kaynaklar' => ['CPCI Bildiri'], 'puan' => 6],
    '3j' => ['baslik' => 'Lisansüstü tezinizden üretilmiş diğer bildiri', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Diğer'], 'puan' => 4],

    // ══ 4. KİTAP ══
    '4a' => ['baslik' => 'BKCI kapsamındaki kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 40],
    '4b' => ['baslik' => 'BKCI kapsamındaki kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 20],
    '4d' => ['baslik' => 'Diğer uluslararası ya da ulusal kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı', 'Tahkik (Tenkitli Metin)', 'Çeviri Kitap'], 'puan' => 5],
    '4e' => ['baslik' => 'Diğer uluslararası ya da ulusal kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi', 'Çeviri Kitap Bölümü'], 'puan' => 15],
    '4c' => ['baslik' => 'BKCI kapsamındaki kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 10],
    '4f' => ['baslik' => 'Diğer uluslararası ya da ulusal kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 10],

    // ══ 11. BİLİMSEL ÖDÜL ══
    '11a' => ['baslik' => 'Uluslararası ödül almak', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 50],
    '11bc' => ['baslik' => 'TÜBİTAK ya da TÜBA ulusal bilim veya teşvik ödülü almak', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü'], 'puan' => 30],
    '11d-g' => ['baslik' => 'Kongre, yarışma ya da bilim ve kültür etkinliklerinde ödül veya mansiyon almak', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 10],
    '11hi' => ['baslik' => 'Ulusal kuruluş, dernek ya da üniversitemizce verilen bilim ve teşvik ödülü almak', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'Burs'], 'puan' => 7],

    // ══ 12. EDİTÖRLÜK — 13. HAKEMLİK ══
    '12a' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 20],
    '12b' => ['baslik' => 'Diğer indekslerde taranan uluslararası dergilerde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 10],
    '12c' => ['baslik' => 'ULAKBİM TR Dizin tarafından taranan dergilerde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 10],
    '12d' => ['baslik' => 'Diğer indekslerde taranan ulusal dergilerde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 8],
    '12-kurul' => ['baslik' => 'Dergide editör kurulu ya da yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 3],
    '13-hak' => ['baslik' => 'Dergi, kitap ya da kongre hakemliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 2],

    // ══ 14. JÜRİ ÜYELİKLERİ ══
    '14ab-u' => ['baslik' => 'Uluslararası sanat ve tasarım yarışmalarında jüri üyeliği, küratörlük ya da sergi yürütücülüğü', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Uluslararası)'], 'puan' => 5],
    '14ab-n' => ['baslik' => 'Ulusal sanat ve tasarım yarışmalarında jüri üyeliği, küratörlük ya da sergi yürütücülüğü', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Üyeliği (Ulusal)', 'Jüri Başkanlığı (Ulusal)'], 'puan' => 3],

    // ══ 7.f. SOSYAL SORUMLULUK ══
    '7f-sos' => ['baslik' => 'Sosyal sorumluluk projelerinde görev almak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi'], 'puan' => 6],
    '17k-uluslararasi' => ['baslik' => 'Uluslararası spor federasyonunun kurullarında görev (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Spor Federasyonu Kurul Üyeliği (Uluslararası)'], 'puan' => 10],
    '17k-ulusal' => ['baslik' => 'Ulusal spor federasyonunun kurullarında görev (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Spor Federasyonu Kurul Üyeliği (Ulusal)'], 'puan' => 10],
    '17e-u' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)'], 'puan' => 6],
    '17e-n' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (ulusal)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Ulusal)'], 'puan' => 3],
    '17i-u' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 3],
    '17i-n' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (ulusal)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 2],
    '17j-u' => ['baslik' => 'Bilimsel toplantıda oturum başkanlığı (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Uluslararası)'], 'puan' => 3],
    '17j-n' => ['baslik' => 'Bilimsel toplantıda oturum başkanlığı (ulusal)', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Ulusal)'], 'puan' => 2],
];

$ek7 = array_merge(
    $ek7,
    $atifBlok('5'),
    $tezBlok('6'),
    $projeBlok('7'),
    $bildiriBlok('8'),
    $egitimBlok('9'),
    $patentBlok('10'),
    $juriBlok('14'),
    $idariBlok('15'),
    $toplumsalBlok('17'),
);

// ══════════════════════════════════════════════════════════════════════
// YAZAR ÇARPANLARI
// ══════════════════════════════════════════════════════════════════════
$HARIC = ['atif', 'tez_danismanligi', 'egitim_ogretim', 'idari_gorev', 'odul',
    'editorluk', 'toplumsal_katki', 'proje', 'patent', 'sanatsal_etkinlik', 'diger'];

// EK-1, EK-5, EK-6: tek yazar %100, birinci/başlıca %80, ikinci %50,
// üçüncü %30, dördüncü ve sonrası %20.
$YAZAR_SIRALI = [
    'haric' => $HARIC,
    'roller' => [
        'tek' => ['kademeler' => [1 => 1.00]],
        'ilk' => ['kademeler' => [1 => 1.00], 'sonrasi' => 0.80],
        'baslica' => ['kademeler' => [1 => 1.00], 'sonrasi' => 0.80],
        'yazar_2' => ['kademeler' => [1 => 1.00], 'sonrasi' => 0.50],
        'yazar_3' => ['kademeler' => [1 => 1.00], 'sonrasi' => 0.30],
        'ortak' => ['kademeler' => [1 => 1.00], 'sonrasi' => 0.20],
    ],
];

// EK-2, EK-3, EK-4: tek yazar %100; iki yazarlıda başlıca %80, ikinci %50;
// üç ve daha fazlada başlıca %50, kalan %50 diğer yazarlara eşit bölünür.
$YAZAR_BOLUSEN = [
    'haric' => $HARIC,
    'roller' => [
        'tek' => ['kademeler' => [1 => 1.00]],
        'ilk' => ['kademeler' => [1 => 1.00, 2 => 0.80], 'sonrasi' => 0.50],
        'baslica' => ['kademeler' => [1 => 1.00, 2 => 0.80], 'sonrasi' => 0.50],
        'ortak' => ['kademeler' => [1 => 1.00], 'bol' => ['pay' => 0.50, 'eksi' => 1]],
    ],
];

// EK-7: tek %100; başlıca %80, ikinci %60, üçüncü %40, dördüncü ve
// sonrası %30 (yazar sayısından bağımsız).
$YAZAR_SPOR = [
    'haric' => $HARIC,
    'roller' => [
        'tek' => ['kademeler' => [1 => 1.00]],
        'ilk' => ['kademeler' => [1 => 1.00], 'sonrasi' => 0.80],
        'baslica' => ['kademeler' => [1 => 1.00], 'sonrasi' => 0.80],
        'yazar_2' => ['kademeler' => [1 => 1.00], 'sonrasi' => 0.60],
        'yazar_3' => ['kademeler' => [1 => 1.00], 'sonrasi' => 0.40],
        'ortak' => ['kademeler' => [1 => 1.00], 'sonrasi' => 0.30],
    ],
];

// ══════════════════════════════════════════════════════════════════════
// GRUPLAR
// ══════════════════════════════════════════════════════════════════════
/**
 * Kodun başındaki madde numarasına göre satır seçer ("11a-f" → 11).
 *
 * @param  array<string, array<string, mixed>>  $maddeler
 * @return list<string>
 */
$bolum = function (array $maddeler, string ...$numaralar): array {
    return array_values(array_filter(
        array_keys($maddeler),
        function (string $kod) use ($numaralar): bool {
            return preg_match('/^(\d+)/', $kod, $eslesme) === 1
                && in_array($eslesme[1], $numaralar, true);
        }
    ));
};

/**
 * Verilen öneklerden biriyle başlayan satırlar.
 *
 * @param  array<string, array<string, mixed>>  $maddeler
 * @return list<string>
 */
$onek = function (array $maddeler, string ...$onekler): array {
    return array_values(array_filter(
        array_keys($maddeler),
        function (string $kod) use ($onekler): bool {
            foreach ($onekler as $baslangic) {
                if (str_starts_with($kod, $baslangic)) {
                    return true;
                }
            }

            return false;
        }
    ));
};

$gruplar13 = [
    'TUM' => array_keys($ek1),
    'M1' => $bolum($ek1, '1'),
    'M12' => $bolum($ek1, '1', '2'),
    'M1A' => $onek($ek1, '1a-'),
    'M1ABC' => $onek($ek1, '1a-', '1b', '1c'),
    'M1ABCD2A' => array_merge($onek($ek1, '1a-', '1b', '1c', '1d'), ['2a']),
    'TEZY' => $onek($ek1, 'ty-'),
    'PROJE6' => $bolum($ek1, '6'),
    'DERS' => ['8a'],
    // EK-1'in ek koşulunda adı geçen kalemler: 1, 3a-3d, 4a-4c, 6a-6b, 7a-7b1.
    'OZEL' => array_merge(
        $bolum($ek1, '1'),
        ['3a', '3b', '3c', '3d', '4a', '4b', '4c'],
        ['6a-y', '6a-a', '6a-d', '6b-y', '6b-a', '6b-d'],
        ['7a', '7b1-t', '7b1-o'],
    ),
    'ULUS' => array_merge(
        $bolum($ek1, '1'),
        $onek($ek1, 'ty-'),
        ['3a', '3b', '3e', '3f', '7a', '7b1-t', '7b1-o'],
        ['6a-y', '6a-a', '6a-d', '6b-y', '6b-a', '6b-d'],
    ),
];

$gruplar2 = [
    'TUM' => array_keys($ek2),
    'M1' => $bolum($ek2, '1'),
    'M1A' => $onek($ek2, '1a-'),
    'M-ARS' => array_merge($onek($ek2, '1a-'), ['1e-1', '1e-1d', '1f-1', '1f-1d', '2a-1', '2a-1d']),
    'TEZY' => $onek($ek2, 'ty-'),
    'PROJE6' => $onek($ek2, '6a', '6b', '6d', '6e', '6f'),
    'DERS' => ['8a'],
    'ULUS' => array_merge(
        $bolum($ek2, '1'),
        $onek($ek2, 'ty-'),
        ['3a-1', '3a-1c', '3a-2', '3a-2c', '7a', '7b1-t', '7b1-o'],
        ['6a-y', '6a-a', '6a-d'],
    ),
];

$gruplar4 = [
    'TUM' => array_keys($ek4),
    'M1' => $bolum($ek4, '1'),
    'M1ABC' => $onek($ek4, '1a-', '1b', '1c'),
    'TEZY' => $bolum($ek4, '3'),
    'ATIF' => $bolum($ek4, '5'),
    'PROJE7' => $bolum($ek4, '7'),
    'DERS' => ['9a'],
    'OZEL' => array_merge(
        $onek($ek4, '1a-', '1b', '1c', '1d', '2a', '2b'),
        $bolum($ek4, '4'),
        $bolum($ek4, '8'),
    ),
    'K1248' => $bolum($ek4, '1', '2', '4', '8', '15', '16'),
    // Araştırma enstitüleri için ayrı liste: 1.a-1.d, 4.a-4.c, 4.e, 8.a-8.b.
    'OZELENS' => array_merge(
        $onek($ek4, '1a-', '1b', '1c', '1d'),
        ['4a', '4b', '4cd', '4ef'],
        ['8a', '8b1-t', '8b1-o'],
    ),
    'ULUS' => array_merge(
        $bolum($ek4, '1'),
        $bolum($ek4, '3'),
        ['4a', '4b', '4g', '4h', '8a', '8b1-t', '8b1-o'],
    ),
];

$gruplar5 = [
    'TUM' => array_keys($ek5),
    'M1' => $bolum($ek5, '1'),
    'K1234' => $bolum($ek5, '1', '2', '3', '4'),
    'K12' => $bolum($ek5, '1', '2'),
    'DERS' => ['9a'],
    'ULUS' => array_merge(
        $bolum($ek5, '1'),
        $bolum($ek5, '3'),
        ['4a', '4b', '4e', '4f', '8a', '8b1-t', '8b1-o'],
    ),
];

$gruplar6 = [
    'TUM' => array_keys($ek6),
    'M1' => $bolum($ek6, '1'),
    'ULUS' => array_merge(
        $bolum($ek6, '1'),
        $bolum($ek6, '3'),
        ['4a', '4b', '4e', '4f', '8a', '8b1-t', '8b1-o'],
    ),
    'K12' => $bolum($ek6, '1', '2'),
    'K1-5' => $bolum($ek6, '1', '2', '3', '4', '5'),
    'K1-16' => array_values(array_diff(array_keys($ek6), $onek($ek6, '17'))),
    'DERS' => ['9a'],
];

$gruplar7 = [
    'TUM' => array_keys($ek7),
    'M1' => $bolum($ek7, '1'),
    'K1' => $bolum($ek7, '1'),
    'K2' => $bolum($ek7, '2'),
    'K4' => $bolum($ek7, '4'),
    'K8' => $bolum($ek7, '8'),
    'TEZY' => $bolum($ek7, '3'),
    'K1234816' => $bolum($ek7, '1', '2', '3', '4', '8'),
    'K1234678' => $bolum($ek7, '1', '2', '3', '4', '6', '7', '8'),
    'DERS' => ['9a'],
    'ULUS' => array_merge(
        $bolum($ek7, '1'),
        $bolum($ek7, '3'),
        ['4a', '4b', '4c', '8a', '8b1-t', '8b1-o'],
    ),
];

// ══════════════════════════════════════════════════════════════════════
// KAPSAM NOTLARI
// ══════════════════════════════════════════════════════════════════════
$ORTAK_NOT = 'Yönergenin "atama için gerekli toplam puanın %25\'ini geçemez" sınırları '
    .'UYGULANMIYOR: sınır atama eşiğine bağlı, aynı cetvel dört ayrı eşikte kullanıldığı için '
    .'sabit bir tavana çevrilemedi. Atıf, patent, ödül, editörlük, jüri, idari görev ve "diğer" '
    .'kalemlerinde puanınız OLDUĞUNDAN YÜKSEK görünür; yalnız eğitim-öğretim maddesinin 10 '
    .'puanlık tavanı uygulanıyor. Yazar listesini boş bırakırsanız çarpan hiç uygulanmaz ve '
    .'puanınız yine yüksek görünür. Yönerge "bildiri, kitap ve kitap bölümünde puan yazarlar '
    .'arasında eşit bölünür" diyor; motorun yazar tablosu kategori ayrımı taşımadığı için MAKALE '
    .'kuralı bütün kategorilere uygulandı, çok yazarlı bir kitapta ilk isimseniz birkaç puan '
    .'fazla görünür. '
    .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: "diğer uluslararası/ulusal kitap" ve '
    .'"kitapta bölüm" satırlarının çift değerinden (15/10, 10/5) kayıt ayrımı taşımadığı için '
    .'düşüğü alındı; CPCI\'da yayımlanmış özet ve poster (5 ve 3) tam metinden ayrılamadığı için '
    .'diğer uluslararası toplantı satırından (3) sayılıyor; kongre sunum ve poster ödülleri ile '
    .'jürili yarışma dereceleri tek etikete düştüğü için en düşük ödül satırından sayılıyor; '
    .'editörlükte alan editörlüğü ile yayın kurulu üyeliği, hakemlikte dergi/kitap/kongre ayrımı '
    .'tek etikete düşüyor ve en düşüğü alınıyor; atama jürisi üyeliği doktor öğretim üyesi '
    .'jürisinden (3) sayılıyor; toplumsal katkıda koordinatör/görev/eğitmen ve uluslararası/ulusal '
    .'ayrımı olmadığı için ulusal görev alma (2) ile ulusal danışmanlık (1) satırları kullanılıyor. '
    .'h-indeksi (×5), "ilk 500 üniversitede altı ay yurt dışı araştırma" (25) ve meslek örgütü '
    .'yeterlik belgesi (10/5) satırları faaliyet kaydına çevrilemediği için hiç girilmedi. '
    .'Patent BAŞVURUNUZU (5 puan) kaydetmeyin: tescilliden ayrılamadığı için o satır girilmedi.';

$NOT1 = 'Puanlar Trakya Üniversitesi Öğretim Üyesi Atama ve Yükseltme Kriterlerinin EK-1 '
    .'(Sağlık Bilimleri Temel Alanı) puanlama sisteminden. Yazar çarpanı: tek yazar tam puan, '
    .'birinci ya da başlıca yazar 0,8; ikinci yazar 0,5; üçüncü 0,3; dördüncü ve sonrası 0,2. '
    .'Lisansüstü tezden üretilmiş yayınlar için EK-1\'de ayrı bir bölüm yok; bu kayıtlar makale '
    .'ve kitap satırlarından sayılıyor, SCIE/SSCI etiketi çeyrek taşımadığı için en düşük '
    .'çeyrekten (20 puan) hesaplanıyor. EK-1 madde 12\'nin yarışma (20) ve uygulanmış proje (15) '
    .'satırları kayıt etiketi bulunmadığı için girilmedi; yalnız yazılım üreticiliği (20) var. '
    .$ORTAK_NOT;

$NOT2 = 'Puanlar Trakya Üniversitesi Öğretim Üyesi Atama ve Yükseltme Kriterlerinin EK-2 '
    .'(Mühendislik, Fen Bilimleri ve Matematik Temel Alanları) puanlama sisteminden; Ziraat '
    .'temel alanı da bu cetvelden değerlendiriliyor. Yazar çarpanı: tek yazar tam puan; iki '
    .'yazarlı makalede başlıca yazar 0,8 ikinci yazar 0,5; üç ve daha fazla yazarlıda başlıca '
    .'yazar 0,5, kalan yarım puan diğer yazarlara eşit bölünüyor. MATEMATİK ALANI AYRILMADI: '
    .'yönerge matematikte daha düşük eşik istiyor, eşikler Fen ve Mühendislik değerlerini '
    .'taşıyor. Lisansüstü tezden üretilmiş yayınlar için EK-2\'de ayrı bölüm yok; bu kayıtlar '
    .'makale satırlarından, SCIE/SSCI\'de en düşük çeyrekten (20) sayılıyor. '
    .$ORTAK_NOT;

$NOT3 = 'Puanlar Trakya Üniversitesi Öğretim Üyesi Atama ve Yükseltme Kriterlerinin EK-3 '
    .'(Mimarlık, Planlama ve Tasarım Temel Alanı) puanlama sisteminden. EK-3 tablosu EK-1 ile '
    .'satır satır aynı puanları taşıdığı için tek tablo kullanıldı; EK-3\'ün makale bölümünde '
    .'meta analiz ve derleme için ayrı sütun yok, bu kayıtlar EK-1\'in derleme değerlerinden '
    .'(Q2\'de 20, Q3\'te 15, Q4\'te 10) sayılıyor ve puanınız düşük görünebilir. Yazar çarpanı: '
    .'tek yazar tam puan; iki yazarlı makalede başlıca yazar 0,8 ikinci yazar 0,5; üç ve daha '
    .'fazla yazarlıda başlıca yazar 0,5, kalan yarım puan diğer yazarlara eşit bölünüyor. '
    .$ORTAK_NOT;

$NOT4 = 'Puanlar Trakya Üniversitesi Öğretim Üyesi Atama ve Yükseltme Kriterlerinin EK-4 '
    .'(Sosyal ve Beşeri Bilimler, Eğitim Bilimleri, Filoloji, İlahiyat ve Öğretmen Yetiştirme) '
    .'puanlama sisteminden; hukuk temel alanı da bu cetvelden değerlendiriliyor (yönerge hukuku '
    .'adıyla saymıyor, en yakın karşılık bu ek). Yazar çarpanı: tek yazar tam puan; iki yazarlı '
    .'makalede başlıca yazar 0,8 ikinci yazar 0,5; üç ve daha fazla yazarlıda başlıca yazar 0,5, '
    .'kalan yarım puan diğer yazarlara eşit bölünüyor. EK-4\'ün 15-16. maddelerindeki sanat, '
    .'tasarım ve müzik performansı satırları kayıttaki sanatsal etkinlik etiketlerine '
    .'yaklaştırılarak eşlendi; birebir karşılığı olmayanlar (sınıf konseri, piyano eşliği, '
    .'radyo-televizyon programı, kazı ve yüzey araştırması) girilmedi. Orkestra ya da koro '
    .'üyeliğinin yurt içi değeri 0,5 olduğu için tek satırda 1 puandan sayılıyor. '
    .$ORTAK_NOT;

$NOT5 = 'Puanlar Trakya Üniversitesi Öğretim Üyesi Atama ve Yükseltme Kriterlerinin EK-5 '
    .'(Devlet Konservatuvarı) puanlama sisteminden. Yazar çarpanı: tek yazar tam puan, birinci '
    .'ya da başlıca yazar 0,8; ikinci yazar 0,5; üçüncü 0,3; dördüncü ve sonrası 0,2. EK-5\'in '
    .'müzik bilim/sanat alt tablosu kayıttaki sanatsal etkinlik etiketlerine yaklaştırılarak '
    .'eşlendi; birebir karşılığı olmayan satırlar (sınıf konseri yönetimi, öğrenciye piyano '
    .'eşliği, karma konser icracılığı, konser anlatıcılığı, radyo-televizyon programı) '
    .'girilmedi. Aynı alt tablonun 15 ve 16 puanlık madde tavanları da uygulanmıyor. '
    .'1. maddenin sergi değerlendirme (15/10) ve hakemli araştırma-derleme makalesi (20/15) '
    .'satırları ile 2. maddenin karşılıkları kayıt etiketi bulunmadığı için girilmedi. '
    .$ORTAK_NOT;

$NOT6 = 'Puanlar Trakya Üniversitesi Öğretim Üyesi Atama ve Yükseltme Kriterlerinin EK-6 '
    .'(Güzel Sanatlar Temel Alanı) puanlama sisteminden. Yazar çarpanı: tek yazar tam puan, '
    .'birinci ya da başlıca yazar 0,8; ikinci yazar 0,5; üçüncü 0,3; dördüncü ve sonrası 0,2. '
    .'17. maddenin sanatsal etkinlik satırları kayıttaki etiketlere yaklaştırılarak eşlendi; '
    .'etkinlik yöneticiliği, yapımcılık, küratörlük ve panel-söyleşi satırları karşılığı '
    .'olmadığı için girilmedi. 1. maddenin sergi değerlendirme (15/10) ve hakemli '
    .'araştırma-derleme makalesi (20/15) satırları ile 2. maddenin karşılıkları da girilmedi. '
    .$ORTAK_NOT;

$NOT7 = 'Puanlar Trakya Üniversitesi Öğretim Üyesi Atama ve Yükseltme Kriterlerinin EK-7 '
    .'(Spor Bilimleri Temel Alanı) puanlama sisteminden. Yazar çarpanı: tek yazar tam puan, '
    .'başlıca yazar 0,8; ikinci yazar 0,6; üçüncü 0,4; dördüncü ve sonrası 0,3. '
    .'EK-7\'NİN 16. MADDESİ (SPORTİF PERFORMANS) HİÇ GİRİLMEDİ: sporcu yetiştirme (40 puana '
    .'kadar), millî takım görevi, antrenörlük ve hakemlik belgeleri, federasyon kurul üyeliği '
    .'gibi 26 satırın kayıtta karşılığı yok. Sportif performansınız varsa puanınız GERÇEĞİNDEN '
    .'ÇOK DÜŞÜK çıkar ve eşiklerdeki "16. kategori" payı hiç dolmaz. Yönergenin 4.e satırı '
    .'("diğer uluslararası/ulusal kitapta bölüm" 15) aynı ekte kitabın kendisinden yüksek; '
    .'tabloda yazdığı gibi girildi. '
    .$ORTAK_NOT;

$TAVAN = ['DERS' => 10];

return [
    'cetveller' => [
        'trakya-2025-ek1' => ['kapsam_notu' => $NOT1, 'yazar_katsayisi' => $YAZAR_SIRALI, 'maddeler' => $ek1, 'gruplar' => $gruplar13, 'grup_tavanlari' => $TAVAN],
        'trakya-2025-ek2' => ['kapsam_notu' => $NOT2, 'yazar_katsayisi' => $YAZAR_BOLUSEN, 'maddeler' => $ek2, 'gruplar' => $gruplar2, 'grup_tavanlari' => $TAVAN],
        'trakya-2025-ek3' => ['kapsam_notu' => $NOT3, 'yazar_katsayisi' => $YAZAR_BOLUSEN, 'maddeler' => $ek1, 'gruplar' => $gruplar13, 'grup_tavanlari' => $TAVAN],
        'trakya-2025-ek4' => ['kapsam_notu' => $NOT4, 'yazar_katsayisi' => $YAZAR_BOLUSEN, 'maddeler' => $ek4, 'gruplar' => $gruplar4, 'grup_tavanlari' => $TAVAN],
        'trakya-2025-ek5' => ['kapsam_notu' => $NOT5, 'yazar_katsayisi' => $YAZAR_SIRALI, 'maddeler' => $ek5, 'gruplar' => $gruplar5, 'grup_tavanlari' => $TAVAN],
        'trakya-2025-ek6' => ['kapsam_notu' => $NOT6, 'yazar_katsayisi' => $YAZAR_SIRALI, 'maddeler' => $ek6, 'gruplar' => $gruplar6, 'grup_tavanlari' => $TAVAN],
        'trakya-2025-ek7' => ['kapsam_notu' => $NOT7, 'yazar_katsayisi' => $YAZAR_SPOR, 'maddeler' => $ek7, 'gruplar' => $gruplar7, 'grup_tavanlari' => $TAVAN],
    ],
];
