<?php

use App\Enums\Kategori;

/**
 * MUŞ ALPARSLAN ÜNİVERSİTESİ — EK-1 Öğretim Üyeliğine Yükseltilme ve
 * Atama Puan Tablosu
 * Kaynak: pdf/1764679627450.mus-alparslan-kriter-02122025.pdf (15 sayfa)
 *
 * Madde kodları tablonun kendi düzeni (A2.1, C2.13, F5.7 …). Koşullar
 * "A2.1 ve A2.2 numaralı yayımlanmış çalışmalardan en az 60 puan",
 * "C2-C4 kapsamında en az 50 puan" gibi kod aralıklarına atıf yaptığı
 * için o aralıklar `gruplar` altında tanımlandı.
 *
 * ── ETKİ FAKTÖRÜ ÇARPANI UYGULANAMIYOR ──
 * A2.1 "30 + (20 × IF)", A2.2 "20 + (10 × IF)" diyor; IF derginin
 * yayım yılındaki etki faktörü. Kayıt etki faktörünü taşımadığı için
 * §0 uyarınca IF = 0 alındı: A2.1 30, A2.2 20 puandan sayılıyor.
 * SCI/SSCI/AHCI makaleleriniz varsa puanınız OLDUĞUNDAN ÇOK DÜŞÜK
 * görünür — etki faktörü 2 olan bir dergideki makale gerçekte 70 puan.
 * Bu, A2.1/A2.2 barajlarını (Dr. 60, doçent 150, profesör 200) da
 * olduğundan zor gösterir.
 *
 * ── A7 (H-İNDEKSİ × 10) GİRİLMEDİ ──
 * H indeksi faaliyet satırı değil profil ölçütü; toplam puana katkısı
 * hesaplanamıyor. H indeksi 10 olan bir aday 100 puan kaybeder.
 *
 * ── AYNI ETİKETE DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   C2'de TÜBİTAK çağrılı destek (150), 1001 ve eşdeğeri (100) ile
 *       hızlı destek (40) tek 'TÜBİTAK' etiketine düşüyor → 40.
 *   C3'te AB Ar-Ge projesi (200) ile AB hibe projesi (50) → 50.
 *   C2.7 Cumhurbaşkanlığı ve bakanlık projeleri (100) ile C2.8 diğer
 *       kamu projeleri (25) → 25.
 *   A6'da yayın kurulu üyelikleri (20/10/5) ile B5'in ulusal karşılığı
 *       (5/2) → 2.
 *   A2.5 uluslararası ansiklopedi maddesi (15) ile B2.4 ulusal (8) → 8.
 *   A3.3/A3.4 ve B3.4/B3.5 komite ve bilim kurulu üyelikleri (10/2/2/1)
 *       → 1.
 *   F6/F7 sanat ödüllerinde derece sırası (200/150/100 ve 100/75/50)
 *       kayıttan okunamıyor → 50.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   A2.4 (Türkiye'de yayımlanan yabancı dilde uluslararası hakemli
 *       dergi, yalnız sosyal bilimler) ve B1.6 (açıklamalı çeviri) —
 *       etiket ayrımı yok.
 *   A4 (ulusal kuruluşlarca yapılan uluslararası toplantılar) — A3 ile
 *       aynı etiketlere düşüyor.
 *   C1.3-C1.8 (tezden türetilmiş yayınlar) — kayıt bir yayının tezden
 *       üretilip üretilmediğini taşımıyor.
 *   C2.1, C2.10, C2.11 (aylık yurt dışı araştırma), C5 (sertifika
 *       programları), D2.3, D3.2, D4.4, D4.5 (üniversitenin kendi radyo
 *       ve gazetesi), E2 (yönetimsel etkinlikler), G8 (arazi
 *       etkinlikleri) — sözlükte karşılık yok.
 *   C4.1/C4.2 patent BAŞVURULARI (5/10) — belgeden ayrılamıyor.
 *
 * ── MOTORUN KARŞILAYAMADIĞI SINIRLAR ──
 * "A5+B4 toplamı en fazla 200 puan", "en fazla 2 dergi editörlüğü",
 * "eğitime katkı en fazla 20 puan" (tavan olarak yazıldı), "zorunlu
 * puanlamada en fazla iki BAP projesi", "son iki yıl" penceresi ve
 * "yardımcı yürütücüler proje puanının yarısını alır" kuralı (rol
 * satırlarında uygulandı).
 *
 * Yönerge: yonerge/mus-alparslan.php
 *
 * 06.09.2026: bilimsel toplantı organizasyonu ailesi için altı etiket
 * açıldı (başkanlık · düzenleme/bilim kurulu üyeliği · oturum başkanlığı,
 * her biri uluslararası/ulusal). Yukarıdaki "sözlükte karşılıksız" notları
 * bu satırlar için artık geçerli değil.
 */
$SCI = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];
$TAM = ['ozgun_makale', 'derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];

$sanatKisiselU = ['Kişisel Etkinlik (Uluslararası)', 'Elektronik Kişisel Sergi (Uluslararası)',
    'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)',
    'Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Yayında Yer Alması / Satın Alınması'];
$sanatKisiselN = ['Kişisel Etkinlik (Ulusal)', 'Elektronik Kişisel Sergi (Ulusal)',
    'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)',
    'Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Satın Alınması (Yurt İçi)',
    'Eserin Haber Olması (Uluslararası)', 'Eserin Haber Olması (Ulusal)'];
$sanatTasarimY = ['Uygulama Projesi — Müellif', 'Özgün Eser / Beste / Tasarım'];
$sanatTasarimE = ['Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı',
    'Uygulama Projesi — Danışman', 'Sahne Tasarımı (Dekor, Kostüm, Işık)'];
$sanatKarmaU = ['Karma/Jürili Etkinlik (Uluslararası)', 'Elektronik Karma Sergi (Uluslararası)',
    'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)'];
$sanatKarmaN = ['Karma/Jürili Etkinlik (Ulusal)', 'Elektronik Karma Sergi (Ulusal)',
    'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Karma Etkinlik (Jürisiz, Ulusal)',
    'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)'];
$sanatJuri = ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)',
    'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'];
$sanatJuriU = ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)'];
$sanatJuriN = ['Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'];
$sanatRestU = ['Koruma-Onarım Uygulaması (Uluslararası)'];
$sanatRestN = ['Koruma-Onarım Uygulaması (Ulusal)'];
$sanatFilm = ['Yönetmenlik (Sahne/Ekran)', 'Belgesel/Kısa Film (Uluslararası)',
    'Belgesel/Kısa Film (Ulusal)', 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)',
    'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'];
$muzikEser = ['Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Opera/Bale Kompozisyonu',
    'Orkestralı Sahne Eseri', 'Küçük Ölçekli Orkestra Eseri', 'Oda/Koro Müziği Eseri (≥15 dk)',
    'Oda/Koro Müziği Eseri (<15 dk)', 'Elektronik Müzik Eseri (≥15 dk)',
    'Elektronik Müzik Eseri (<15 dk)', 'Sahne/Ekran Müziği'];
$muzikSolo = ['Solistlik (Uluslararası)', 'Solistlik (Ulusal)', 'Resital (Uluslararası)',
    'Resital (Ulusal)', 'Şan Resitali (Uluslararası)', 'Şan Resitali (Ulusal)',
    'Opera Birinci Rol (Uluslararası)', 'Opera Birinci Rol (Ulusal)',
    'Orkestra Şefliği (Uluslararası)', 'Orkestra Şefliği (Ulusal)',
    'Koro Şefliği (Uluslararası)', 'Koro Şefliği (Ulusal)', 'Bale Başrol (Uluslararası)',
    'Bale Başrol (Ulusal)', 'Rejisörlük (Uluslararası)', 'Rejisörlük (Ulusal)'];
$muzikKarma = ['Orkestra / Koro Üyeliği', 'Oda Müziği Grup Üyeliği (Uluslararası)',
    'Oda Müziği Grup Üyeliği (Ulusal)', 'Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)',
    'Karma Albüm / CD-DVD Katkısı', 'Orkestrasyon/Transkripsiyon',
    'Eğitim Müziği Düzenlemesi', 'Eğitim Müziği Albümü'];

$sanatKullanilan = array_merge($sanatKisiselU, $sanatKisiselN, $sanatTasarimY, $sanatTasarimE,
    $sanatKarmaU, $sanatKarmaN, $sanatJuri, $sanatRestU, $sanatRestN, $sanatFilm,
    $muzikEser, $muzikSolo, $muzikKarma);
$sanatKalan = array_values(array_diff(Kategori::SanatselEtkinlik->kaynaklar(), $sanatKullanilan));

/** C2/C3 dipnotu: "Yardımcı yürütücüler proje puanının yarısını alırlar." */
$proje = fn (string $kod, string $ad, array $kaynaklar, int $p): array => [
    "{$kod}-y" => ['baslik' => "{$ad} — yürütücü", 'kategori' => 'proje', 'kaynaklar' => $kaynaklar, 'roller' => ['yurutucu'], 'puan' => $p],
    "{$kod}-a" => ['baslik' => "{$ad} — yardımcı yürütücü, araştırmacı ya da danışman", 'kategori' => 'proje', 'kaynaklar' => $kaynaklar, 'roller' => ['arastirmaci', 'danisman'], 'puan' => (int) ($p / 2)],
    "{$kod}-b" => ['baslik' => "{$ad} — bursiyer", 'kategori' => 'proje', 'kaynaklar' => $kaynaklar, 'roller' => ['bursiyer'], 'puan' => 5],
];

$maddeler = array_merge([
    // ══ A1. ULUSLARARASI KİTAP ══
    'A1.1' => ['baslik' => 'Uluslararası bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 120],
    'A1.2' => ['baslik' => 'Uluslararası bilimsel kitap içinde bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 40],
    'A1.3' => ['baslik' => 'Uluslararası bilimsel kitaplarda editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 40],

    // ══ A2. ULUSLARARASI MAKALELER ══
    'A2.1' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergide yayımlanmış özgün araştırma makalesi veya derleme', 'kategori' => 'makale', 'kaynaklar' => $SCI, 'turler' => $TAM, 'puan' => 30],
    'A2.2' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergide yayımlanmış editöre mektup, teknik not veya vaka takdimi', 'kategori' => 'makale', 'kaynaklar' => $SCI, 'turler' => $KISA, 'puan' => 20],
    'A2.3' => ['baslik' => 'Diğer indekslerde taranan uluslararası hakemli dergilerdeki yayınlar', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => $TAM, 'puan' => 25],
    'A2.5' => ['baslik' => 'Bilimsel ansiklopedilerde madde yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 8],
    'A2.6' => ['baslik' => 'Diğer uluslararası hakemli dergilerdeki vaka takdimi, kısa makale ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => $KISA, 'puan' => 10],

    // ══ A3. ULUSLARARASI BİLİMSEL TOPLANTILAR ══
    'A3.1' => ['baslik' => 'Uluslararası toplantıda sözlü sunulan, özeti ya da tam metni yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin', 'Davetli Konuşmacı'], 'puan' => 20],
    'A3.2' => ['baslik' => 'Uluslararası toplantıda özeti ya da tam metni yayımlanan poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 10],
    'A3.4' => ['baslik' => 'Bilimsel toplantı düzenleme, organizasyon ya da bilim kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Diğer', 'Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 1],

    // ══ A5. ATIFLAR ══
    'A5.1' => ['baslik' => 'SCI, SCIE, SSCI ya da AHCI dergilerinde eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 5],
    'A5.2' => ['baslik' => 'Diğer uluslararası hakemli dergilerde ve yurt dışında yayımlanan bilimsel kitap ile tezlerde eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap', 'ESCI', 'Scopus'], 'puan' => 2],

    // ══ A6. ULUSLARARASI EDİTÖRLÜK ══
    'A6.1' => ['baslik' => 'SCI, SSCI ya da AHCI kapsamındaki dergilerde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 30],
    'A6.5' => ['baslik' => 'Diğer uluslararası hakemli dergilerde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 10],
    'A6.6' => ['baslik' => 'Dergilerde yayın kurulu üyeliği ya da hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği', 'Hakemlik'], 'puan' => 2],

    // ══ B1. ULUSAL KİTAP ══
    'B1.1' => ['baslik' => 'Ulusal bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Ders / Metot Kitabı'], 'puan' => 80],
    'B1.2' => ['baslik' => 'Ulusal bilimsel kitap içinde bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 25],
    'B1.3' => ['baslik' => 'Ulusal bilimsel kitaplarda editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 25],
    'B1.4' => ['baslik' => 'Bilimsel kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 25],
    'B1.5' => ['baslik' => 'Bilimsel kitap içinde bölüm çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 15],

    // ══ B2. ULUSAL MAKALELER ══
    'B2.1' => ['baslik' => 'TÜBİTAK ULAKBİM ulusal veri tabanlarında taranan yurt içi hakemli dergide yayımlanmış özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale'], 'puan' => 20],
    'B2.2' => ['baslik' => 'TÜBİTAK ULAKBİM veri tabanlarında taranan dergide yayımlanmış derleme, editöre mektup, teknik not ya da vaka takdimi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 10],
    'B2.3' => ['baslik' => 'Diğer ulusal hakemli dergilerdeki yayınlar', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'puan' => 12],

    // ══ B3. ULUSAL BİLİMSEL TOPLANTILAR ══
    'B3.1' => ['baslik' => 'Ulusal toplantıda Türkçe sözlü sunulan, tam metni ya da özeti yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 10],
    'B3.3' => ['baslik' => 'Ulusal toplantıda tam metni ya da özeti yayımlanan poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 5],

    // ══ B4. ULUSAL ATIFLAR ══
    'B4.1' => ['baslik' => 'TÜBİTAK ULAKBİM veri tabanlarında taranan yurt içi hakemli dergilerde eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
    'B4.2' => ['baslik' => 'Diğer ulusal hakemli dergilerde, kitaplarda ve tezlerde eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],

    // ══ B5. ULUSAL EDİTÖRLÜK ══
    'B5.1' => ['baslik' => 'TÜBİTAK ULAKBİM veri tabanlarında taranan bilimsel yayınlarda editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 15],
    'B5.3' => ['baslik' => 'Diğer ulusal yayınlarda editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 10],

    // ══ C1. TEZ DANIŞMANLIĞI ══
    'C1.1' => ['baslik' => 'Tamamlanmış tıpta uzmanlık, doktora ya da sanatta yeterlik tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman', 'es_danisman'], 'puan' => 15],
    'C1.2' => ['baslik' => 'Tamamlanmış yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi', 'Tez İzleme / Jüri Üyeliği'], 'roller' => ['danisman', 'es_danisman'], 'puan' => 10],
],
    $proje('C2.2', 'TÜBİTAK Ar-Ge destek programlarından alınan proje', ['TÜBİTAK'], 40),
    $proje('C2.8', 'Bakanlıklar ve diğer kamu kurumlarından alınan proje ya da Ulusal Ajans destekli proje', ['Diğer Kamu Kurumu', 'TÜSEB'], 25),
    $proje('C2.9', 'Üniversite-sanayi iş birliği projesi', ['Özel Sektör / STK'], 50),
    $proje('C2.12', 'TÜBİTAK Bilim ve Toplum ya da lisansüstü/lisans tez projesi', ['Öğrenci Projesi (2209 vb.)'], 10),
    $proje('C2.13', 'Üniversite BAP projesi', ['BAP (Üniversite)'], 5),
    $proje('C3.4', 'Avrupa Birliği Ar-Ge ya da hibe programından alınan proje', ['AB Çerçeve / Ufuk'], 50),
    $proje('C3.3', 'Avrupa Birliği dışında uluslararası Ar-Ge programından alınan proje', ['Diğer Uluslararası Fon'], 100),
    [
        // ══ C4. FİKRİ VE SINAİ MÜLKİYET ══
        'C4.3' => ['baslik' => 'Ulusal patent belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 75],
        'C4.4' => ['baslik' => 'Uluslararası patent belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 150],
        'C4.5' => ['baslik' => 'Faydalı model, endüstriyel tasarım ya da yazılım belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 75],
        'C4.7' => ['baslik' => 'Ticarileşen patent, faydalı model ya da endüstriyel tasarım belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 100],

        // ══ C6. BİLİMSEL ÖDÜLLER ══
        'C6.1' => ['baslik' => 'Sürekli ve periyodik olarak verilen, jürili uluslararası bilim ve sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 100],
        'C6.2' => ['baslik' => 'TÜBİTAK, TÜBA ya da YÖK tarafından verilen bilim ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'YÖK Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 100],
        'C6.3' => ['baslik' => 'Sürekli ve periyodik olarak verilen, jürili ulusal bilim ve sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'Yarışma Derecesi / Mansiyon', 'Burs'], 'puan' => 50],

        // ══ C7. EĞİTİME KATKI ══
        'C7.1' => ['baslik' => 'Son iki yıl içinde Türkçe verilen ders (dönem başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Değişim Programı Dersi'], 'puan' => 2],
        'C7.2' => ['baslik' => 'Son iki yıl içinde yabancı dilde verilen ders (dönem başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Yabancı Dilde Ders'], 'puan' => 4],

        // ══ C8. İDARİ GÖREVLER ══
        'C8.1' => ['baslik' => 'Enstitü, yüksekokul, meslek yüksekokulu, konservatuvar ya da merkez müdürlüğü, başhekimlik (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 15],
        'C8.2' => ['baslik' => 'Dekan yardımcılığı ya da müdür yardımcılığı (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.'], 'puan' => 10],
        'C8.3' => ['baslik' => 'Komisyon ya da kurul başkanlığı, koordinatörlük görevi, senato üyeliği (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı'], 'puan' => 10],
        'C8.4' => ['baslik' => 'Diğer kurul görevleri ile bölüm komisyon üyelikleri (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği', 'Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 5],
        'C8.5' => ['baslik' => 'Bölüm başkanlığı ya da bölüm başkan yardımcılığı (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı', 'Bölüm Başkan Yardımcısı'], 'puan' => 10],

        // ══ D. GÖRSEL ETKİNLİKLER ══
        'D1.3' => ['baslik' => 'Sinema filmi, belgesel, kısa metrajlı film, reklam filmi ya da televizyon programı yönetmenliği veya ekibinde görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatFilm, 'puan' => 25],

        // ══ E. KONSERVATUVAR ETKİNLİKLERİ ══
        /*
         * E BÖLÜMÜ SADECE DEVLET KONSERVATUVARI İÇİN (04.09.2026).
         *
         * Kaynağın bölüm başlığı: "E- KONSERVATUAR ETKİNLİKLERİ (Sadece Devlet
         * Konservatuarı için geçerlidir)". Kısıt adayın BİRİMİNE ait, hiçbir sözlük
         * etiketi taşıyamıyor. Üstelik bu yönergenin Madde 5'i güzel sanatlar temel
         * alanını hiç anmıyor, yani konservatuvar adayına eşik de yazılamadı:
         * satırlar HAK EDENE ulaşmıyor, yalnız hak etmeyen on temel alana puan
         * veriyordu (eşiklerin toplam barajı `*` üzerinden geçiyor). Etiketler bu
         * yüzden boşaltıldı; satırlar kaynağı belgelemek için duruyor. F bölümü
         * (SANAT VE TASARIM ETKİNLİKLERİ) kısıtsız, ona dokunulmadı.
         */
        'E1.1' => ['baslik' => 'Sahne yapıtı ya da senfonik yapıt', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => [], 'puan' => 50],
        'E1.3' => ['baslik' => 'Sanat etkinliklerinde bireysel icracı olarak yer almak (solo konser, dinleti, resital)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => [], 'puan' => 30],
        'E1.4' => ['baslik' => 'Sanat etkinliklerinde karma ya da eşlikçi olarak yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => [], 'puan' => 15],

        // ══ F. SANAT VE TASARIM ETKİNLİKLERİ ══
        'F1.1' => ['baslik' => 'Yurt dışında tanınmış müze, kültür merkezi ya da sanat galerisinde kişisel sergi, koleksiyonda veya kamusal alanda eserinizin yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKisiselU, 'puan' => 60],
        'F1.2' => ['baslik' => 'Yurt içinde tanınmış müze, kültür merkezi ya da sanat galerisinde kişisel sergi, koleksiyonda veya kamusal alanda eserinizin yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKisiselN, 'puan' => 30],
        'F2.4' => ['baslik' => 'Mimari proje, planlama ya da tasarım çalışmalarında yürütücülük', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatTasarimY, 'puan' => 50],
        'F2.5' => ['baslik' => 'Mimari proje, planlama ya da tasarım çalışmalarında yardımcılık', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatTasarimE, 'puan' => 25],
        'F3.1' => ['baslik' => 'Uluslararası sergi, bienal, trienal, festival ya da gösteride çağrılı sanatsal gösteri', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKarmaU, 'puan' => 50],
        'F3.2' => ['baslik' => 'Ulusal sergi, bienal, trienal, festival ya da gösteride çağrılı sanatsal gösteri', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKarmaN, 'puan' => 30],
        // Kaynak F3.3 (ULUSLARARASI sergi, bienal, trienal, festival ve gösterilerde jüri üyeliği) 30, F3.4 (ULUSAL) 15 diyor; iki kapsam tek satırda 15 puanla birleşmişti.
        'F3.3' => ['baslik' => 'Uluslararası sergi, bienal, trienal, festival ve gösterilerde jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatJuriU, 'puan' => 30],
        'F3.4' => ['baslik' => 'Ulusal sergi, bienal, trienal, festival ve gösterilerde jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatJuriN, 'puan' => 15],
        'F5.1' => ['baslik' => 'Yurt dışında müze, kazı buluntusu, koleksiyon ve film arşivi restorasyon ve konservasyon çalışmasını yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatRestU, 'puan' => 100],
        'F5.4' => ['baslik' => 'Ulusal müze, kazı buluntusu, koleksiyon ve film arşivi restorasyon ve konservasyon çalışmasını yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatRestN, 'puan' => 50],

        // ══ TOPLUMSAL KATKI ══
        'G8.1' => ['baslik' => 'Bitkisel ve hayvansal üretim konusunda kurs yürütmek, seminer ya da tarla günleri düzenlemek', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın', 'Kamu/STK Danışmanlığı'], 'puan' => 20],
    ]);

/** @param list<string> $onekler */
$onek = fn (array $onekler): array => array_values(array_filter(
    array_keys($maddeler),
    function (string $kod) use ($onekler) {
        foreach ($onekler as $o) {
            if (str_starts_with($kod, $o)) {
                return true;
            }
        }

        return false;
    },
));

$a1 = $onek(['A1.']);
$a2 = $onek(['A2.']);
$b1 = $onek(['B1.']);
$b2 = $onek(['B2.']);
$c1c7 = $onek(['C1.', 'C2.', 'C3.', 'C4.', 'C5.', 'C6.', 'C7.']);
$c2c4 = $onek(['C2.', 'C3.', 'C4.']);

return [
    'kapsam_notu' => 'Puanlar Muş Alparslan Üniversitesi Öğretim Üyeliğine Yükseltilme ve Atama '
        .'Puan Tablosundan (EK-1). Yazar çarpanı madde 8\'in tablosundan: tek yazarda %100; iki '
        .'yazarda birinci %100, ikinci %90; üç yazarda %90/%80/%70; dört yazarda birinci %70, '
        .'diğerleri %50; beş ve üzerinde birinci %60, diğerleri %40. Yazar listesini boş '
        .'bırakırsanız çarpan hiç uygulanmaz ve puanınız olduğundan YÜKSEK görünür. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN ÇOK DÜŞÜK görünür: A2.1 satırı "30 + (20 × etki '
        .'faktörü)", A2.2 satırı "20 + (10 × etki faktörü)" diyor; kayıt derginin etki faktörünü '
        .'taşımadığı için etki faktörü sıfır kabul edildi. Etki faktörü 2 olan bir dergideki '
        .'makaleniz gerçekte 70 puanken burada 30 puandan sayılıyor; bu, A2.1/A2.2 barajlarını '
        .'(doktor öğretim üyeliğinde 60, doçentlikte 150, profesörlükte 200 puan) da olduğundan '
        .'zor gösterir. A7 satırı (h-indeksi × 10) faaliyet kaydına çevrilemediği için hiç '
        .'girilmedi; h-indeksi 10 olan bir aday 100 puan kaybeder. '
        .'Ayrıca TÜBİTAK projeleri 40, bakanlık projeleri 25, AB projeleri 50 puandan (çağrılı '
        .'destek 150, 1001 100, AB Ar-Ge 200 puanlık satırlar kayıttan ayrılamıyor); yayın '
        .'kurulu üyelikleri ve hakemlikler 2, ansiklopedi maddeleri 8, toplantı kurul üyelikleri '
        .'1, sanat ödülleri 50 puandan sayılıyor. Tezden türetilmiş yayınlar (C1.3-C1.8), '
        .'sertifika programları, aylık yurt dışı araştırma satırları ve üniversitenin kendi '
        .'radyo-gazete faaliyetleri sözlükte karşılıksız olduğu için girilemedi. Patent '
        .'BAŞVURUNUZU kaydetmeyin: yönerge ona 5-10 puan veriyor ama kayıt türü belgeden '
        .'ayrılamadığı için o satırlar girilmedi. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünebilir: "A5+B4 atıf toplamı en fazla 200 '
        .'puan", "en fazla iki dergi editörlüğü", "zorunlu puanlamada en fazla iki BAP projesi" '
        .'ve "son iki yıl" penceresi uygulanmıyor.',

    // Madde 8'in yazar oranı tablosu.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'proje', 'patent', 'editorluk', 'tez_danismanligi', 'egitim_ogretim',
            'odul', 'idari_gorev', 'toplumsal_katki', 'diger', 'sanatsal_etkinlik'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.00]],
            'ilk' => ['kademeler' => [1 => 1.00, 2 => 1.00, 3 => 0.90, 4 => 0.70], 'sonrasi' => 0.60],
            'baslica' => ['kademeler' => [1 => 1.00, 2 => 1.00, 3 => 0.90, 4 => 0.70], 'sonrasi' => 0.60],
            'yazar_2' => ['kademeler' => [2 => 0.90, 3 => 0.80, 4 => 0.50], 'sonrasi' => 0.40],
            'yazar_3' => ['kademeler' => [3 => 0.70, 4 => 0.50], 'sonrasi' => 0.40],
            'yazar_4' => ['kademeler' => [4 => 0.50], 'sonrasi' => 0.40],
            'yazar_5' => ['sonrasi' => 0.40],
            'yazar_6' => ['sonrasi' => 0.40],
            'ortak' => ['kademeler' => [1 => 1.00, 2 => 0.90, 3 => 0.70, 4 => 0.50], 'sonrasi' => 0.40],
        ],
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        'A1' => $a1,
        'A2' => $a2,
        // "A2.1 ve A2.2 numaralı yayımlanmış çalışmalar".
        'A2.1-2' => ['A2.1', 'A2.2'],
        'B1' => $b1,
        'B2' => $b2,
        // Telafi kümesi: "eksik puanlarını A1 ve B1-B2'den tamamlamalıdır".
        'A1-B1-B2' => array_merge($a1, $b1, $b2),
        'A2-A1-B1-B2' => array_merge(['A2.1', 'A2.2'], $a1, $b1, $b2),
        // "C1-C7 kapsamında" ve "C2-C4 kapsamında".
        'C1-C7' => $c1c7,
        'C2-C4' => $c2c4,
        // "D1-D4 kapsamında" (İletişim Fakülteleri).
        'D1-D4' => $onek(['D']),
        // Başlıca araştırma eseri: Web of Science makalesi.
        'WOS' => ['A2.1'],
        // Tavan grubu.
        'DERS' => ['C7.1', 'C7.2'],
    ],

    // C7 başlığı: "EĞİTİME KATKI (En fazla 20 puan)".
    'grup_tavanlari' => ['DERS' => 20],
];
