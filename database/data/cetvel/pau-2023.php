<?php

use App\Enums\Kategori;

/**
 * PAMUKKALE ÜNİVERSİTESİ — Puanlama İlkeleri
 * Kaynak: pdf/17537006202.pamukkaleuniverstesi.pdf (17 sayfa;
 * YÖK Genel Kurulu 28.09.2023)
 *
 * Madde kodları tablonun kendi numaralandırması (A.1a, A.14ç, D.4a …).
 * Koşullar "A.1-A.13 maddeler kapsamında", "A.17 veya A.18 maddesinden"
 * gibi KOD ARALIKLARINA atıf yaptığı için o aralıklar `gruplar` altında
 * tanımlandı.
 *
 * ── SANAT BÖLÜMLERİ SIKIŞTIRILDI ──
 * A.14 (Güzel Sanatlar ve İletişim), A.15 (Müzik), A.16 (Spor
 * Bilimleri), A.17 (Müzik ve Sahne Sanatları) ve A.18 (Türk Müziği)
 * bölümleri onlarca satır ve her satırda ulusal/uluslararası ayrımı
 * taşıyor. Sözlük bu ayrımı ancak etiket düzeyinde verebildiği için her
 * bölüm birkaç temsilci satıra indirildi ve ayrımın okunamadığı yerde
 * ULUSAL değer alındı. Sanat ağırlıklı bir adayın puanı OLDUĞUNDAN
 * DÜŞÜK görünebilir.
 *
 * ── AYNI ETİKETE DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   A.3 (SCI dergi özel sayısında ya da aynı kapsamdaki kongre kitabında
 *       bildiri, 12/6) ile A.9 (diğer kongreler, 7/3/5/2): CPCI etiketi
 *       A.3'ten, kalan bildiri etiketleri A.9'dan.
 *   A.5 uluslararası atıf (2/1) ile A.8 ulusal atıf (1) → WoS 2, kalan 1.
 *   C.1 ve C.2'de editörlük, yayın kurulu üyeliği ve hakemlik ayrı
 *       satırlarda; hakemlik en düşük değerden (2).
 *   D.1'de yerel kuruluş projeleri (8/3) ile BAP (10/5) — BAP tanımlar
 *       bölümünde "değerlendirmeye alınmaz" dense de D.1.e/g'de puanı
 *       var; tablo satırı esas alındı.
 *   E.1 ödüllerde uluslararası (30), ulusal (15) ve üniversite (10).
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   A.12 (adayın adıyla anılan denklem, şema, sendrom; 40 puan),
 *       A.13 (internet ortamında yayın), D.4b-f (Tıp Fakültesine özgü
 *       modül, task ve senaryo görevleri), D.7 (alan dışı doktora),
 *       D.8 (yeterlik/board sınavı) — sözlükte karşılık yok.
 *   D.2'nin "sonuçlandırılmış projelerde puan 2 ile çarpılır" kuralı —
 *       kayıt projenin sonuçlanıp sonuçlanmadığını taşımıyor; §0
 *       uyarınca çarpan uygulanmadı, proje puanınız OLDUĞUNDAN DÜŞÜK.
 *
 * ── MOTORUN KARŞILAYAMADIĞI SINIRLAR ──
 * Madde 5(9): "B, C, D ve E gruplarından alınabilecek puan, A grubundan
 * alınan puanın %20'sini geçemez" — A grubuna bağlı DEĞİŞKEN bir tavan,
 * statik tavana çevrilemedi; toplam puanınız OLDUĞUNDAN YÜKSEK
 * görünebilir. Aynı biçimde "bir makale için en çok 50 atıf puanı"
 * (madde 5-7) ve "aynı çalışma için mükerrer bildiride en yüksek puan"
 * (madde 5-4) kuralları da uygulanmıyor.
 *
 * Yönerge: yonerge/pau.php
 *
 * YÜZDE TAVANI TARAMASI (03.09.2026): 9. maddenin "B, C, D ve E grubundaki
 * bilimsel aktivitelerden alınabilecek maksimum puan, adayın A GRUBUNDAN
 * ALDIĞI PUANIN %20'sini geçemez" sınırı UYGULANAMAZ ve öyle kalmalı.
 * Sebep yüzdenin kendisi değil TABANI: taban kadro başına sabit bir asgari
 * puan değil, ADAYIN KENDİ A grubu puanı. Motorun `grup_tavanlari`'ı sabit
 * sayı alıyor, başka bir grubun toplamına bağlı tavan tanımlamıyor.
 * Kaynağın kendisi de bu sınırı asgari şart değerlendirmesinin dışında
 * tutuyor ("Asgari şartların sağlanması ile ilgili değerlendirmede ise bu
 * kısıtlama söz konusu değildir"), yani barajları etkilemiyor; yalnız
 * listede görünen toplam puan yüksek çıkar.
 */
$SCI = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI',
    'ESCI / Scopus'];
$TAM = ['ozgun_makale', 'derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];

$sanatKisisel = ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Ulusal)',
    'Elektronik Kişisel Sergi (Uluslararası)', 'Elektronik Kişisel Sergi (Ulusal)',
    'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)',
    'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)'];
$sanatKarma = ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma/Jürili Etkinlik (Ulusal)',
    'Elektronik Karma Sergi (Uluslararası)', 'Elektronik Karma Sergi (Ulusal)',
    'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Karma Etkinlik (Jürisiz, Ulusal)',
    'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)',
    'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)'];
$sanatSatin = ['Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Satın Alınması (Yurt İçi)',
    'Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Müzeye Kabulü (Yurt İçi)',
    'Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip',
    'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman'];
$sanatYayin = ['Eserin Haber Olması (Uluslararası)', 'Eserin Haber Olması (Ulusal)'];
$sanatJuri = ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)',
    'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'];
$sanatFilm = ['Yönetmenlik (Sahne/Ekran)', 'Belgesel/Kısa Film (Uluslararası)',
    'Belgesel/Kısa Film (Ulusal)', 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)',
    'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'];
$muzikSolist = ['Solistlik (Uluslararası)', 'Solistlik (Ulusal)', 'Resital (Uluslararası)',
    'Resital (Ulusal)', 'Şan Resitali (Uluslararası)', 'Şan Resitali (Ulusal)',
    'Opera Birinci Rol (Uluslararası)', 'Opera Birinci Rol (Ulusal)',
    'Bale Başrol (Uluslararası)', 'Bale Başrol (Ulusal)', 'Orkestra Şefliği (Uluslararası)',
    'Orkestra Şefliği (Ulusal)', 'Koro Şefliği (Uluslararası)', 'Koro Şefliği (Ulusal)',
    'Opera Şefliği (Uluslararası)', 'Opera Şefliği (Ulusal)', 'Grup Şefliği (Uluslararası)',
    'Grup Şefliği (Ulusal)', 'Rejisörlük (Uluslararası)', 'Rejisörlük (Ulusal)',
    'Rejisörlük (Konservatuvar)', 'Koreografi', 'Sahne Tasarımı (Dekor, Kostüm, Işık)',
    'Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Opera/Bale Kompozisyonu',
    'Orkestralı Sahne Eseri', 'Özgün Eser / Beste / Tasarım'];
$muzikEslikci = ['Orkestra / Koro Üyeliği', 'Oda Müziği Grup Üyeliği (Uluslararası)',
    'Oda Müziği Grup Üyeliği (Ulusal)', 'Corps de Ballet (Uluslararası)',
    'Corps de Ballet (Ulusal)', 'Opera İkinci Rol (Uluslararası)', 'Opera İkinci Rol (Ulusal)',
    'Bale Solist Rol (Uluslararası)', 'Bale Solist Rol (Ulusal)', 'Başkemancılık (Uluslararası)',
    'Başkemancılık (Ulusal)', 'Dansçı / Performans İcracısı (Uluslararası)',
    'Dansçı / Performans İcracısı (Ulusal)', 'Oratoryo/Kantat Solistliği (Uluslararası)',
    'Oratoryo/Kantat Solistliği (Ulusal)'];
$muzikKayit = ['Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)', 'Karma Albüm / CD-DVD Katkısı',
    'Masterclass (Uluslararası)', 'Masterclass (Ulusal)', 'Müzikoloji Atölyesi',
    'Eğitici Konser Programı (Uluslararası)', 'Eğitici Konser Programı (Ulusal)'];

$sanatKullanilan = array_merge($sanatKisisel, $sanatKarma, $sanatSatin, $sanatYayin,
    $sanatJuri, $sanatFilm, $muzikSolist, $muzikEslikci, $muzikKayit);
$sanatKalan = array_values(array_diff(Kategori::SanatselEtkinlik->kaynaklar(), $sanatKullanilan));

$maddeler = [
    // ══ A.1-A.4 ULUSLARARASI YAYINLAR ══
    'A.1a' => ['baslik' => 'SCI, SCI-Expanded, SSCI, AHCI ya da ESCI kapsamındaki dergide yayımlanan makale (derleme dâhil)', 'kategori' => 'makale', 'kaynaklar' => $SCI, 'turler' => $TAM, 'puan' => 40],
    'A.1b' => ['baslik' => 'Uluslararası yabancı dilde yayımlanmış uluslararası nitelikte kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 75],
    'A.1c' => ['baslik' => 'Uluslararası yabancı dilde yayımlanmış kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 30],
    'A.2a' => ['baslik' => 'SCI, SCI-Expanded, SSCI, AHCI ya da ESCI dergisinde vaka takdimi, teknik not, editöre mektup ve benzeri yazı', 'kategori' => 'makale', 'kaynaklar' => $SCI, 'turler' => $KISA, 'puan' => 20],
    'A.2b' => ['baslik' => 'Diğer uluslararası hakemli dergilerde yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $KISA, 'puan' => 10],
    'A.3a' => ['baslik' => 'Uluslararası kongrede sunulan ve SCI kapsamındaki dergi özel sayısında ya da kongre kitabında yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 12],
    'A.4a' => ['baslik' => 'SCI kapsamı dışındaki uluslararası indekslere giren dergilerde yayımlanan tam metin araştırma', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $TAM, 'puan' => 20],

    // ══ A.5-A.8 ATIFLAR VE ULUSAL YAYINLAR ══
    'A.5a' => ['baslik' => 'SCI, SCI-Expanded, SSCI, AHCI ya da ESCI dergilerinde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 2],
    'A.6' => ['baslik' => 'Yabancı dilde ders kitabı ya da referans kitaplarda eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 5],
    'A.8' => ['baslik' => 'Ulusal dergilerde, kitaplarda ve diğer yayınlarda eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer', 'Patent'], 'puan' => 1],
    'A.7a' => ['baslik' => 'ULAKBİM tarafından taranan ulusal hakemli dergide yayımlanan makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $TAM, 'puan' => 15],
    'A.7b' => ['baslik' => 'Diğer ulusal hakemli dergilerde yayımlanan tam metin araştırma', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $TAM, 'puan' => 10],
    'A.7c' => ['baslik' => 'Ulusal hakemli dergilerde yayımlanan derleme, vaka takdimi, editöre mektup ya da teknik not', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 5],

    // ══ A.9 DİĞER KONGRELER ══
    'A.9a' => ['baslik' => 'Uluslararası kongrede sunulan ve tam metni yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin'], 'puan' => 7],
    'A.9b' => ['baslik' => 'Uluslararası kongrede sunulan özet ya da poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 3],
    'A.9c' => ['baslik' => 'Ulusal kongrede sunulan ve tam metni yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 5],
    'A.9d' => ['baslik' => 'Ulusal kongrede sunulan özet ya da poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 2],

    // ══ A.10-A.11 ULUSAL KİTAP VE ÇEVİRİ ══
    'A.10a' => ['baslik' => 'Türkçe kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)'], 'puan' => 35],
    'A.10b' => ['baslik' => 'Kitap bölümü yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 15],
    'A.10c' => ['baslik' => 'Ansiklopedide bölüm ya da madde tanımlaması', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 5],
    'A.10d' => ['baslik' => 'Kendi alanınızla ilgili yayımlanmış ders notu', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı'], 'puan' => 10],
    'A.11a' => ['baslik' => 'Kitap çevirmenliği', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 15],
    'A.11b' => ['baslik' => 'Kitap bölümü çevirmenliği', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 5],

    // ══ A.14 SANATSAL VE KİTLE İLETİŞİM ETKİNLİKLERİ ══
    'A.14a' => ['baslik' => 'Özgün yapıt, proje ya da tasarımlarla kişisel sanat etkinliğinde bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKisisel, 'puan' => 20],
    'A.14b' => ['baslik' => 'Karma sanat etkinliklerine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => [...$sanatKarma, ...$sanatKalan], 'puan' => 10],
    'A.14d' => ['baslik' => 'Çalışmalarınızın resmî ve özel kurum, kuruluş ya da sanat müzelerince satın alınması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatSatin, 'puan' => 15],
    'A.14e' => ['baslik' => 'Çalışmalarınızın yayınlarda yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatYayin, 'puan' => 10],
    'A.14f' => ['baslik' => 'Çeşitli kültür ve sanat etkinliklerinde jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatJuri, 'puan' => 5],
    'A.14g' => ['baslik' => 'Sinema, belgesel, televizyon ya da radyo yapımında yönetmenlik veya görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatFilm, 'puan' => 20],

    // ══ A.15 / A.17 / A.18 MÜZİK VE SAHNE SANATLARI ══
    'A.15a' => ['baslik' => 'Sanatsal etkinliklerde solist, başrol, besteci, şef, koreograf, sahne tasarımcısı ya da rejisör olarak görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $muzikSolist, 'puan' => 20],
    'A.15b' => ['baslik' => 'Sanatsal etkinliklerde eşlikçi, orkestra, koro ya da oda müziği topluluğu üyesi olarak görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $muzikEslikci, 'puan' => 10],
    'A.15c' => ['baslik' => 'Kayıt, yayın, atölye (workshop) ya da ustalık sınıfı (masterclass) etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $muzikKayit, 'puan' => 15],

    // ══ A.16 SPOR BİLİMLERİ UYGULAMA ══
    'A.16a' => ['baslik' => 'Millî takımlarda görev almak ya da antrenör ve hakem eğitim kurslarında eğitici olarak görev almak', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 10],

    // ══ B. KONGRELER ══
    'B.2' => ['baslik' => 'Kongre ve sempozyumlarda davetli konuşmacı ya da panelist olmak, kurs eğitmeni olarak katılmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 7],

    // ══ C. HAKEMLİK VE EDİTÖRLÜK ══
    'C.1a' => ['baslik' => 'SCI, SCI-Expanded, SSCI ve AHCI kapsamındaki dergilerde yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 10],
    'C.1b' => ['baslik' => 'SCI, SCI-Expanded, SSCI ve AHCI kapsamındaki dergilerde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 50],
    'C.2a' => ['baslik' => 'Diğer uluslararası ve ulusal hakemli dergilerde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi', 'TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 20],
    'C.2c' => ['baslik' => 'Dergilerde hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 2],
    'C.3' => ['baslik' => 'Yabancı dilde yazılmış uluslararası kitaplarda editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 40],
    'C.4' => ['baslik' => 'Türkiye\'de yayımlanmış kitaplarda editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 20],
    'C.5a' => ['baslik' => 'Lisansüstü tez jürisinde bulunmak', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 3],

    // ══ D. EĞİTİM VE ARAŞTIRMA ══
    'D.1a' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen proje yürütücülüğü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 60],
    'D.1b' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
    'D.1c' => ['baslik' => 'TÜBİTAK ve bakanlıklarca desteklenen proje yürütücülüğü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 30],
    'D.1d' => ['baslik' => 'TÜBİTAK ve bakanlıklarca desteklenen projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 5],
    'D.1e' => ['baslik' => 'Üniversite bilimsel araştırma projesi (BAP) ya da yerel kuruluş projesi yürütücülüğü', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 8],
    'D.1g' => ['baslik' => 'Üniversite bilimsel araştırma projesi (BAP) ya da yerel kuruluş projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)', 'Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 3],
    'D.3a' => ['baslik' => 'Sonuçlandırılmış yüksek lisans tez yönetimi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman', 'es_danisman'], 'puan' => 10],
    'D.3c' => ['baslik' => 'Sonuçlandırılmış doktora ya da tıpta uzmanlık tez yönetimi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman', 'es_danisman'], 'puan' => 25],
    'D.4a' => ['baslik' => 'Ön lisans, lisans ya da lisansüstü düzeyde ders vermek (dönem başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 5],
    'D.5' => ['baslik' => 'Bir kurum ya da kuruluş tarafından talep edilen bilimsel rapor', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı', 'Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın'], 'puan' => 3],
    'D.6b' => ['baslik' => 'Sempozyum, kongre ya da çalıştay gibi etkinliklerde başkanlık veya organizasyonda görev almak', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 5],
    'D.6c' => ['baslik' => 'Üniversite yönetiminde idari görev almak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı', 'Senato / Üniversite Yönetim Kurulu Üyesi', 'Dekan / Enstitü-YO Müdürü', 'Dekan Yrd. / Müdür Yrd.', 'Uygulama ve Araştırma Merkezi Müdürü', 'Bölüm Başkanı', 'Bölüm Başkan Yardımcısı', 'Anabilim Dalı Başkanı / Koordinatörlük', 'Kurul / Komisyon Üyeliği'], 'puan' => 5],

    // ══ E. ÖDÜLLER VE PATENTLER ══
    'E.1a' => ['baslik' => 'Uluslararası ödül', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 30],
    'E.1b' => ['baslik' => 'Ulusal ödül', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü', 'Yarışma Derecesi / Mansiyon'], 'puan' => 15],
    'E.2a' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 50],
    'E.2b' => ['baslik' => 'Ulusal patent, faydalı model, endüstriyel tasarım ya da yazılım tescili', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım', 'Islahçı Hakkı / Çeşit Tescili', 'Ticarileştirme'], 'puan' => 25],
    'E.3' => ['baslik' => 'Uluslararası burs', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 10],
];

// Koşulların atıf yaptığı kod aralıkları. Kod önekiyle eşleştirme
// yapılamaz (A.1 öneki A.10, A.11, A.14 ve A.16'yı da yakalar), bu
// yüzden aralıklar açıkça yazıldı. A.15 (Müzik), A.17 (Müzik ve Sahne
// Sanatları) ve A.18 (Türk Müziği) aynı sözlük etiketlerine düştüğü için
// tek satır kümesini paylaşıyor.
$A1 = ['A.1a', 'A.1b', 'A.1c'];
$A2A4 = ['A.2a', 'A.2b', 'A.3a', 'A.4a'];
$A5A10 = ['A.5a', 'A.6', 'A.8', 'A.7a', 'A.7b', 'A.7c',
    'A.9a', 'A.9b', 'A.9c', 'A.9d', 'A.10a', 'A.10b', 'A.10c', 'A.10d'];
$A11 = ['A.11a', 'A.11b'];
$A14 = ['A.14a', 'A.14b', 'A.14d', 'A.14e', 'A.14f', 'A.14g'];
$A15 = ['A.15a', 'A.15b', 'A.15c'];
$A16 = ['A.16a'];

$a1a4 = array_merge($A1, $A2A4);
$a1a10 = array_merge($a1a4, $A5A10);
$a1a12 = array_merge($a1a10, $A11);
$a1a13 = $a1a12;
$a1a15 = array_merge($a1a13, $A14, $A15);
$a1a16 = array_merge($a1a15, $A16);

return [
    'kapsam_notu' => 'Puanlar Pamukkale Üniversitesi Akademik Değerlendirme Yönergesinin '
        .'Puanlama İlkeleri tablosundan. Yazar çarpanı madde 6\'nın tablosundan: iki yazarlıda '
        .'ilk isim %100, ikinci %90; üç yazarlıda %90/%80/%70; beş yazarlıda '
        .'%80/%70/%60/%50/%20; on dört ve üzerinde ilk isim %35, altıncıdan sonrası %10. '
        .'Sorumlu yazar birinci isimle aynı ölçütlerde değerlendiriliyor. Atıf puanı yazar '
        .'sayısına bölünmüyor. Yazar listesini boş bırakırsanız çarpan hiç uygulanmaz ve '
        .'puanınız olduğundan YÜKSEK görünür. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: D.2\'nin "sonuçlandırılmış '
        .'projelerde puan 2 ile çarpılır" kuralı, kayıt projenin sonuçlanıp sonuçlanmadığını '
        .'taşımadığı için uygulanmıyor — tamamlanmış projelerinizde puan yarı yarıya düşük. '
        .'A.14, A.15, A.17 ve A.18 sanat bölümleri onlarca satır ve her satırda '
        .'ulusal/uluslararası ayrımı taşıyor; sözlük bu ayrımı veremediği için her bölüm birkaç '
        .'temsilci satıra indirildi ve ULUSAL değerden sayılıyor. A.12 (adayınızın adıyla '
        .'anılan denklem, şema, sendrom; 40 puan), A.13 (internet ortamında yayın), D.4b-f (Tıp '
        .'Fakültesine özgü modül ve task görevleri), D.7 ve D.8 sözlükte karşılıksız. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünebilir: madde 5(9) "B, C, D ve E '
        .'gruplarından alınabilecek puan, A grubundan alınan puanın %20\'sini geçemez" diyor; '
        .'bu, A grubuna bağlı DEĞİŞKEN bir tavan olduğu için uygulanamıyor. Aynı biçimde "bir '
        .'makale için en çok 50 atıf puanı" ve "mükerrer bildiride yalnız en yüksek puan" '
        .'kuralları da uygulanmıyor.',

    // Madde 6: ortak çalışmalarda puan dağılımı (yazar sayısı × isim sırası).
    // "Sorumlu yazar 1. isim ile aynı ölçütlerde değerlendirilir."
    // Madde 5(7): "Atıf puanı yazar sayısına bölünmez."
    'yazar_katsayisi' => [
        'haric' => ['atif', 'proje', 'patent', 'editorluk', 'tez_danismanligi', 'egitim_ogretim',
            'odul', 'idari_gorev', 'toplumsal_katki', 'diger'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.00]],
            'ilk' => ['kademeler' => [1 => 1.00, 2 => 1.00, 3 => 0.90, 4 => 0.85, 5 => 0.80,
                6 => 0.75, 7 => 0.70, 8 => 0.65, 9 => 0.60, 10 => 0.55], 'sonrasi' => 0.35],
            'baslica' => ['kademeler' => [1 => 1.00, 2 => 1.00, 3 => 0.90, 4 => 0.85, 5 => 0.80,
                6 => 0.75, 7 => 0.70, 8 => 0.65, 9 => 0.60, 10 => 0.55], 'sonrasi' => 0.35],
            'yazar_2' => ['kademeler' => [2 => 0.90, 3 => 0.80, 4 => 0.75, 5 => 0.70, 6 => 0.65,
                7 => 0.60, 8 => 0.55, 9 => 0.50, 10 => 0.45], 'sonrasi' => 0.25],
            'yazar_3' => ['kademeler' => [3 => 0.70, 4 => 0.65, 5 => 0.60, 6 => 0.55, 7 => 0.50,
                8 => 0.45, 9 => 0.40, 10 => 0.35], 'sonrasi' => 0.25],
            'yazar_4' => ['kademeler' => [4 => 0.55, 5 => 0.50, 6 => 0.45, 7 => 0.40, 8 => 0.35,
                9 => 0.30, 10 => 0.25], 'sonrasi' => 0.25],
            'yazar_5' => ['sonrasi' => 0.20],
            'yazar_6' => ['sonrasi' => 0.10],
            'ortak' => ['kademeler' => [1 => 1.00, 2 => 0.90, 3 => 0.70, 4 => 0.55, 5 => 0.20],
                'sonrasi' => 0.10],
        ],
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        // Koşulların atıf yaptığı kod aralıkları.
        'A.1' => $A1,
        'A.1-A.4' => $a1a4,
        'A.1-A.10' => $a1a10,
        'A.1-A.12' => $a1a12,
        'A.1-A.13' => $a1a13,
        'A.1-A.15' => $a1a15,
        'A.1-A.16' => $a1a16,
        'A.17-A.18' => $A15,
        'D.4' => ['D.4a'],
        // "En az bir yayın yapmış olmak" — bütün yayın satırları.
        'YAYIN' => $a1a16,
    ],

    'grup_tavanlari' => [],
];
