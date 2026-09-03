<?php

/**
 * SAĞLIK BİLİMLERİ ÜNİVERSİTESİ — Ek-1 Akademik Yükseltilme ve Atanma
 * Kriterleri
 * Kaynak: pdf/1765867210191.saglik-bilimleri-kriter-16122025.pdf
 * (11 sayfa; son değişiklik YÖK Genel Kurulu 27/11/2025)
 *
 * KAYNAK PDF TARANMIŞ; sayfalar 300 dpi PNG'ye çevrilip
 * `tesseract -l tur` ile okundu (PSM verilmedi).
 *
 * ── EN ÇOK PUAN KAYBETTİREN KARARLAR ──
 *   A.1 (Web of Science h-indeksi) girilmedi: faaliyet değil profil
 *       ölçütü.
 *   PROJE VE PATENT BAŞVURULARI (C.1.a, C.2.a, C.4.a-b; 5-10 puan)
 *       girilmedi; kayıt başvuruyu alınmış projeden/belgeden ayırmıyor.
 *   ATIF TAVANI UYGULANMIYOR. A.13 "bu alandan alınacak puanların
 *       toplamı, başvurulan kadro için gerekli asgari puanın %20'sini
 *       geçemez" diyor; sınır kadroya bağlı olduğu için sabit tavana
 *       çevrilemedi ve atıf puanı OLDUĞUNDAN YÜKSEK çıkıyor. B ve C
 *       bölümlerinin sabit tavanları (50 ve 100) ile D bölümünün 50
 *       puanlık tavanı uygulanıyor.
 *   ÜNİVERSİTENİN KENDİ DERGİLERİ (B.3, 8 ve 5 puan) ile alanı kilitli
 *       satırlar — B.10 kitap ve karar tahlilleri (Tıp Tarihi, Etik,
 *       Sağlık Hukuku), B.11 ve A.4.d hakemsiz dergi yayınları (yalnız
 *       Sosyal Bilimler) — girilmedi.
 *   C.5.b sertifika programı düzenleme kurulu üyeliği (5) girilmedi.
 *   D bölümünün "en fazla bir dönem puanlanır" ve "eş zamanlı görevlerden
 *       yalnız en yükseği sayılır" kuralları uygulanamıyor; birden çok
 *       dönem dekanlık yapmışsanız puanınız YÜKSEK görünür.
 *
 * ── AYNI ETİKETE DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   A.2.b derleme Sosyal Bilimlerde 20, ötekilerde 10; cetvel alana göre
 *       bölünmediği için 10'dan sayılıyor. Aynı durum A.4.b'de (10/5 → 5).
 *   Lisanslanan patent, faydalı model ve endüstriyel tasarım belgeleri
 *       (20) lisanssızlardan ayrılamadığı için tescil satırlarından
 *       (10, 5, 5) sayılıyor.
 *   A.9.c ve A.10.c hakemlik (2) tek "Hakemlik" etiketinde; A.9/A.10
 *       yayın kurulu üyeliği (10 ve 5) tek etikette, 5'ten sayılıyor.
 *
 * ── YAZAR ÇARPANI ──
 * Tek yazar tam puan; iki yazarlıda birinci isim 0,8 ikinci yazar 0,5;
 * birinci isim sorumlu yazar değilse sorumlu yazar 0,5. Üç ve daha fazla
 * yazarlıda birinci isim puanın yarısını (sorumlu yazar değilse 0,3),
 * diğerleri kalan yarıyı eşit paylaşır. Kitap ve bildiride puan daima
 * eşit bölünüyor; motor kategori ayrımı taşımadığı için MAKALE kuralı
 * hepsine uygulandı.
 *
 * Yönerge: yonerge/sbu.php
 *
 * KODLAR BİZE AİT — KAYNAKTA SATIR KODU YOK. Cetvel kodlarının SAYISAL
 * ÇEKİRDEĞİ kaynağın madde/bölüm numarasıdır; baştaki harf tabloyu ya da
 * eki, sondaki harf şıkkı gösterir ve ikisi de bizim eklediğimiz parçadır.
 * Koşullar bu kodlara atıf yaptığı için değiştirilmemeli; kaynakla
 * karşılaştırırken kodun sayısal çekirdeğine bakılmalı.
 */
$WOS = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];
$OZGUN = ['ozgun_makale'];
$DERLEME = ['derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];

$maddeler = [
    // ══ A. ULUSLARARASI YAYIN VE ETKİNLİKLER ══
    'A.2.a' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $OZGUN, 'puan' => 20],
    'A.2.b' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergide derleme', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $DERLEME, 'puan' => 10],
    'A.2.c' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergide editöre mektup, teknik not ya da vaka takdimi', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $KISA, 'puan' => 5],
    'A.4.a' => ['baslik' => 'Diğer uluslararası hakemli dergide yayımlanan araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => $OZGUN, 'puan' => 10],
    'A.4.b' => ['baslik' => 'Diğer uluslararası hakemli dergide yayımlanan derleme', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => $DERLEME, 'puan' => 5],
    'A.4.c' => ['baslik' => 'Diğer uluslararası hakemli dergide editöre mektup, teknik not ya da vaka takdimi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => $KISA, 'puan' => 3],
    'A.3.a' => ['baslik' => 'Lisansüstü ya da uzmanlık tezinizden üretilmiş SCI, SCI-Expanded, SSCI veya AHCI makalesi', 'kategori' => 'tez_yayini', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 10],
    'A.3.b' => ['baslik' => 'Lisansüstü ya da uzmanlık tezinizden üretilmiş, diğer uluslararası hakemli dergide makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['ESCI / Scopus', 'TR Dizin', 'Uluslararası/Ulusal Kitap', 'BKCI / Scopus Kitap', 'BKCI / Scopus Kitap Bölümü', 'Kitap Bölümü'], 'puan' => 5],
    'A.3.c' => ['baslik' => 'Lisansüstü ya da uzmanlık tezinizden üretilmiş, tam metni basılmış sözlü bildiri', 'kategori' => 'tez_yayini', 'kaynaklar' => ['CPCI Bildiri', 'Diğer'], 'puan' => 3],
    'A.5' => ['baslik' => 'Yurt dışında yayımlanmış ISBN numaralı bilimsel kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 10],
    'A.6' => ['baslik' => 'Yurt dışında yayımlanmış ISBN numaralı bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 20],
    'A.7' => ['baslik' => 'Yurt dışında yayımlanmış bilimsel kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 10],
    'A.9.a' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 20],
    'A.10.a' => ['baslik' => 'Diğer uluslararası hakemli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 10],
    'A.10.b' => ['baslik' => 'Uluslararası hakemli dergide yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 5],
    'A.9.c' => ['baslik' => 'Dergi ya da proje hakemliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 2],
    'A.11.a' => ['baslik' => 'Uluslararası bilimsel toplantıda sözlü sunulan, özeti ya da tam metni yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin', 'Davetli Konuşmacı'], 'puan' => 15],
    'A.11.b' => ['baslik' => 'Uluslararası bilimsel toplantıda tam metni ya da özeti yayımlanan poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 8],
    'A.13.a' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergilerde eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 3],
    'A.13.c' => ['baslik' => 'Yurt dışında yayımlanan bilimsel kitap, monografi ya da tezlerde eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap', 'Patent'], 'puan' => 2],

    // ══ B. ULUSAL YAYIN VE ETKİNLİKLER (en fazla 50 puan) ══
    'B.1.a' => ['baslik' => 'TÜBİTAK ULAKBİM ulusal veri tabanlarında taranan yurt içi hakemli dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $OZGUN, 'puan' => 8],
    'B.1.b' => ['baslik' => 'TR Dizin dergisinde derleme, editöre mektup, teknik not ya da vaka takdimi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 5],
    'B.2.a' => ['baslik' => 'Diğer yurt içi hakemli dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $OZGUN, 'puan' => 5],
    'B.2.b' => ['baslik' => 'Diğer yurt içi hakemli dergide derleme, editöre mektup, teknik not ya da vaka takdimi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 3],
    'B.4' => ['baslik' => 'Bilimsel ansiklopedide madde yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 3],
    'B.5.a' => ['baslik' => 'Ulusal ya da uluslararası katılımlı bilimsel toplantıda sözlü sunulan, tam metni ya da özeti yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 5],
    'B.5.b' => ['baslik' => 'Ulusal bilimsel toplantıda tam metni ya da özeti yayımlanan poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 3],
    'B.6' => ['baslik' => 'ISBN numaralı yayımlanmış bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı', 'Tahkik (Tenkitli Metin)'], 'puan' => 15],
    'B.7' => ['baslik' => 'ISBN numaralı yayımlanmış bilimsel kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 8],
    'B.8.a' => ['baslik' => 'Ulusal veri tabanlarında taranan dergi ya da kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi', 'Kitap Editörlüğü'], 'puan' => 5],
    'B.9.a' => ['baslik' => 'ISBN numaralı bilimsel kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 10],
    'B.9.b' => ['baslik' => 'Bilimsel kitapta bölüm çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 5],
    'B.12' => ['baslik' => 'Yurt içinde yayımlanan kitap, monografi, tez ya da TR Dizin dergilerinde eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer'], 'puan' => 1],

    // ══ C. GİRİŞİMCİ VE YENİLİKÇİ ÜNİVERSİTE FAALİYETLERİ (en fazla 100) ══
    'C.1.b' => ['baslik' => 'TÜBİTAK Ar-Ge destek programlarından alınan proje', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'puan' => 15],
    'C.1.c' => ['baslik' => 'Cumhurbaşkanlığı, bağlı kurum ya da bakanlıklardan alınan Ar-Ge projesi', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'puan' => 20],
    'C.1.ç' => ['baslik' => 'Üniversite-sanayi arasında yapılan kontratlı Ar-Ge ya da teknoloji geliştirme bölgesi projesi', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'puan' => 20],
    'C.2.b' => ['baslik' => 'Avrupa Birliği Ar-Ge destek programlarından alınan proje', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'puan' => 40],
    'C.2.c' => ['baslik' => 'Avrupa Birliği dışında uluslararası Ar-Ge programlarından alınan proje', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'puan' => 20],
    'C.3' => ['baslik' => 'Tez projeleri dışında üniversite tarafından desteklenen proje', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'puan' => 5],
    'C.4.c' => ['baslik' => 'Ulusal patent belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 10],
    'C.4.ç' => ['baslik' => 'Uluslararası patent belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 20],
    'C.4.d' => ['baslik' => 'Faydalı model ya da endüstriyel tasarım belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili', 'Ticarileştirme'], 'puan' => 5],
    'C.4.f' => ['baslik' => 'Kullanıma sunulmuş Ar-Ge destekli eğitim ya da sağlık yazılımı', 'kategori' => 'patent', 'kaynaklar' => ['Yazılım'], 'puan' => 10],
    'C.5.a' => ['baslik' => 'Uluslararası bilimsel kuruluşlarca verilen bilim ya da sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 50],
    'C.5.b' => ['baslik' => 'TÜBİTAK, TÜBA ya da YÖK tarafından verilen bilim ödülü (yayın teşvik ödülü hariç)', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü', 'Ulusal Bilim/Sanat Ödülü', 'Burs'], 'puan' => 20],
    'C.7' => ['baslik' => 'Ulusal ya da uluslararası jürili yarışmalara katılmak', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 10],
    'C.6' => ['baslik' => 'Ulusal ya da uluslararası jürili yarışmalarda danışmanlık ya da jüri üyeliği yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 20],

    // ══ D. AKADEMİK VE İDARİ GÖREVLER (en fazla 50 puan) ══
    'D.1' => ['baslik' => 'Rektörlük', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör'], 'puan' => 50],
    'D.2' => ['baslik' => 'Rektör yardımcılığı ya da dekanlık', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü'], 'puan' => 30],
    'D.4' => ['baslik' => 'Dekan yardımcılığı, enstitü ya da yüksekokul müdürlüğü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.', 'Bölüm Başkanı'], 'puan' => 20],
    'D.6' => ['baslik' => 'Enstitü ya da yüksekokul müdür yardımcılığı, başhekimlik', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı'], 'puan' => 10],
    'D.9' => ['baslik' => 'Uygulama ve araştırma merkezi müdürlüğü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Uygulama ve Araştırma Merkezi Müdürü', 'Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 5],
    'D.11' => ['baslik' => 'Eğitim kurullarında ya da etik komisyonlarında üyelik', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği', 'Senato / Üniversite Yönetim Kurulu Üyesi'], 'puan' => 1],

    // ══ TEZ DANIŞMANLIĞI (MADDE 13/6'nın aradığı koşul) ══
    'T.1' => ['baslik' => 'Yönettiğiniz yüksek lisans, doktora ya da uzmanlık tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi', 'Yüksek Lisans Tezi'], 'roller' => ['danisman', 'es_danisman'], 'puan' => 5],
];

$AB = ['A.2.a', 'A.2.b', 'A.2.c', 'A.4.a', 'A.4.b', 'A.4.c', 'A.3.a', 'A.3.b', 'A.3.c',
    'A.5', 'A.6', 'A.7', 'A.9.a', 'A.10.a', 'A.10.b', 'A.9.c', 'A.11.a', 'A.11.b',
    'A.13.a', 'A.13.c', 'B.1.a', 'B.1.b', 'B.2.a', 'B.2.b', 'B.4', 'B.5.a', 'B.5.b',
    'B.6', 'B.7', 'B.8.a', 'B.9.a', 'B.9.b', 'B.12'];

return [
    'kapsam_notu' => 'Puanlar Sağlık Bilimleri Üniversitesi Akademik Yükseltilme ve Atanma '
        .'Kriterlerinin Ek-1 tablosundan. Kaynak PDF taranmış; 300 dpi görüntüden OCR ile '
        .'okundu. Yazar çarpanı: tek yazar tam puan, iki yazarlıda birinci isim 0,8 ikinci '
        .'yazar 0,5; üç ve daha fazla yazarlıda birinci isim puanın yarısını, diğerleri kalan '
        .'yarıyı eşit paylaşır. Yazar listesini boş bırakırsanız çarpan hiç uygulanmaz ve '
        .'puanınız olduğundan YÜKSEK görünür. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: h-indeksi satırı (A.1) profil '
        .'ölçütü olduğu için, proje ve patent BAŞVURULARI (5-10) alınmış proje ve belgeden '
        .'ayrılamadığı için, üniversitenin kendi dergilerindeki yayınlar (B.3, 8 ve 5 puan) ile '
        .'alanı kilitli satırlar (B.10 kitap ve karar tahlilleri, B.11 ve A.4.d hakemsiz dergi '
        .'yayınları) ve C.5.b sertifika programı girilmedi. Derleme Sosyal Bilimlerde 20 '
        .'(ötekilerde 10) ve diğer uluslararası dergide 10 (ötekilerde 5) puan alıyor; cetvel '
        .'alana göre bölünmediği için ikisinde de düşük olan alındı. Lisanslanan patent, faydalı '
        .'model ve endüstriyel tasarım belgeleri (20) lisanssızlardan ayrılamadığı için tescil '
        .'satırlarından sayılıyor. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünebilir: A.13\'ün atıf tavanı '
        .'("başvurulan kadro için gerekli asgari puanın %20\'si") kadroya bağlı olduğu için '
        .'sabit tavana çevrilemedi ve uygulanmıyor. D bölümünün "en fazla bir dönem puanlanır" '
        .'ve "eş zamanlı görevlerden yalnız en yükseği sayılır" kuralları da uygulanamıyor. '
        .'B (50), C (100) ve D (50) bölümlerinin sabit tavanları uygulanıyor.',

    'yazar_katsayisi' => [
        'haric' => ['atif', 'tez_danismanligi', 'egitim_ogretim', 'idari_gorev', 'odul',
            'editorluk', 'toplumsal_katki', 'proje', 'patent', 'sanatsal_etkinlik', 'diger'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.00]],
            'ilk' => ['kademeler' => [1 => 1.00, 2 => 0.80], 'sonrasi' => 0.50],
            'baslica' => ['kademeler' => [1 => 1.00, 2 => 0.50], 'sonrasi' => 0.30],
            'ortak' => ['kademeler' => [1 => 1.00], 'bol' => ['pay' => 0.50, 'eksi' => 1]],
        ],
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        'TUM' => array_keys($maddeler),
        'AB' => $AB,
        'C' => ['C.1.b', 'C.1.c', 'C.1.ç', 'C.2.b', 'C.2.c', 'C.3', 'C.4.c', 'C.4.ç',
            'C.4.d', 'C.4.f', 'C.5.a', 'C.5.b', 'C.6', 'C.7'],
        'B' => ['B.1.a', 'B.1.b', 'B.2.a', 'B.2.b', 'B.4', 'B.5.a', 'B.5.b', 'B.6', 'B.7',
            'B.8.a', 'B.9.a', 'B.9.b', 'B.12'],
        'D' => ['D.1', 'D.2', 'D.4', 'D.6', 'D.9', 'D.11'],
        // MADDE 6, 10 ve 13'ün andığı yayın kümeleri.
        'WOS-MAKALE' => ['A.2.a'],
        'ALAN-INDEKSI' => ['A.4.a'],
        'PROJE-PATENT' => ['C.1.b', 'C.1.c', 'C.1.ç', 'C.2.b', 'C.2.c', 'C.3',
            'C.4.c', 'C.4.ç', 'C.4.d', 'C.4.f'],
        'TEZ' => ['T.1'],
    ],

    'grup_tavanlari' => ['B' => 50, 'C' => 100, 'D' => 50],
];
