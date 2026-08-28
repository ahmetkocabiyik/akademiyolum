<?php

use App\Enums\Kategori;

/**
 * KIRŞEHİR AHİ EVRAN ÜNİVERSİTESİ — Ek-1 puanlama tablosu (+ Güzel
 * Sanatlar için Ek-2)
 * Kaynak: pdf/17682164575.kirsehir-ahi-evran-kriter-09012026.pdf
 * (20 sayfa; YÖK Genel Kurulu 24.10.2024)
 *
 * İKİ CETVEL: `ahi-evran-2024` yalnız Ek-1'i taşır; `ahi-evran-2024-gsf`
 * Ek-1'in üstüne Ek-2'nin (Güzel Sanatlar temel alanı özel başvuru
 * şartları) sanatsal satırlarını ekler. Yönergenin bütün eşikleri "Ek-1
 * ve/veya Ek-2" dediği için ikisi tek listede toplanıyor; Ek-1'e bağlı
 * alt barajlar (`M1A`, `M1ABC`, `M1ABC2A`) Ek-2 satırlarını içermiyor.
 *
 * Madde kodları yönergenin kendi numaralandırması (`1a`, `7c-y`, `E2-a`).
 *
 * ── EN ÇOK PUAN KAYBETTİREN İKİ KARAR ──
 *   TÜBİTAK PROJELERİ 7 PUANDAN SAYILIYOR. 7.a "TÜBİTAK (öğrenci projesi
 *       hariç)" projelerinde yürütücüye 20 puan veriyor, 7.e "bilimsel
 *       etkinlik / bilim ve toplum başlıklı TÜBİTAK" projelerinde ise 7.
 *       Kayıt ikisini ayırmadığı (tek 'TÜBİTAK' etiketi var) ve 7.a'nın
 *       kendi içinde de 1002 kodlu projelere yarım puan verdiği için §0
 *       uyarınca en düşük satır alındı: yürütücü 7, araştırmacı 5,
 *       danışman 3. TÜBİTAK 1001/1005 yürütücülüğünüz varsa puanınız
 *       OLDUĞUNDAN ÇOK DÜŞÜK görünür.
 *   14. MADDE (h-indeksi, altı ay yurt dışı, film jürisi, eğiticilerin
 *       eğitimi) HİÇ GİRİLMEDİ. h-indeksi ve yurt dışı süresi faaliyet
 *       satırı değil profil ölçütü; film ve sertifika satırları belirli
 *       bilim alanlarına kilitli. En çok 15 puan kaybı.
 *
 * ── AYNI ETİKETE DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   1.a'nın "en üst %10'luk dilim" satırı (50) — kayıt yalnızca çeyrek
 *       taşıyor, Q1 satırından (30) sayılıyor.
 *   1.e vaka takdimi (5) ile 1.f araştırma notu (3) tek `vaka_teknik_not`
 *       türüne düştüğü için 3.
 *   4.c "diğer uluslararası/ulusal kitap" Hukuk, İlahiyat ve Filoloji
 *       temel alanlarında 20 puan; cetvel alana göre bölünmediği için
 *       hepsinde 10.
 *   6. maddede ikinci danışmanlık "yarısı" (2,5 ve 1,5) aşağı yuvarlandı.
 *   8.b'de uluslararası tam metin, özet ve ulusal bildiriler tek satır (3).
 *   Ek-2'de albüm (bandrollü 20 / dijital 10), özgün eser (kompozisyon 10
 *       / Türk müziği 5), konser (solo 10 / karma 5) ayrımı etiketten
 *       okunamadığı için hepsi en düşükten.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   Ek-1 madde 3 (kurumsal katkı puanları, en çok 12) — puan yalnızca
 *       ASGARİ SAYININ ÜSTÜNDEKİ faaliyetlere veriliyor; kayıt hangi
 *       faaliyetin asgariyi doldurduğunu bilmediği için satır girilmedi.
 *   13.A (İlahiyat sanatsal icra), 13.B (Mimarlık yarışma/yazılım),
 *       13.C (Spor Bilimleri sportif başarı) — tek temel alana kilitli
 *       tablolar; cetvel alana göre bölünmediği için girilmedi.
 *   10.d patent başvurusu (2) tescilliden ayrılamıyor; 10. maddenin
 *       "ticarileşme halinde %40 artırım" kuralı uygulanmıyor.
 *   Ek-2'de orkestra şefliği (60) portföye bağlı bir ölçüt (dört saatlik
 *       kayıt, üç farklı orkestra); tek etkinlik kaydından hesaplanamaz,
 *       şeflik etiketleri artık satırlara düşüyor (5).
 *   Çeviri kitap, ders kitabı, ansiklopedi maddesi dışındaki ders notu,
 *       hakemlik, yayın kurulu üyeliği, idari görev ve toplumsal katkı
 *       kalemleri Ek-1'de puanlı satır bulmuyor (Tablo 1'in nitel
 *       maddeleri).
 *
 * ── YAZAR ÇARPANINDA BİLİNÇLİ SAPMA ──
 * Yönerge çarpanı esere göre ayırıyor: MAKALEDE başlıca yazar tam / 0,8 /
 * 0,5 alırken MAKALE HARİCİ eserlerde puan daima yazar sayısına eşit
 * bölünüyor. Motorun yazar tablosu kategori ayrımı taşımıyor; makale
 * kuralı bütün kategorilere uygulandı. Çok yazarlı bir kitapta ya da
 * patentte ilk isimseniz puanınız OLDUĞUNDAN YÜKSEK görünür — en çok 25
 * puanlık bir satırda birkaç puan. Ters yönde tutmak makalelerdeki asıl
 * kuralı bozacaktı.
 *
 * Yönerge: yonerge/ahi-evran.php
 */
$SCI = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)'];
$OZGUN = ['ozgun_makale'];
$KISA = ['derleme', 'kisa_makale', 'vaka_teknik_not'];

$ek1 = [
    // ══ 1. ULUSLARARASI MAKALE ══
    '1a-Q1' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q1 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $OZGUN, 'puan' => 30],
    '1a-Q2' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q2 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $OZGUN, 'puan' => 20],
    '1a-Q3' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q3 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $OZGUN, 'puan' => 15],
    '1a-Q4' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q4 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => $OZGUN, 'puan' => 12],
    '1b' => ['baslik' => 'AHCI kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => $OZGUN, 'puan' => 20],
    '1c' => ['baslik' => 'ESCI, Scopus veya SPORTDiscus kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $OZGUN, 'puan' => 12],
    '1d' => ['baslik' => 'Diğer uluslararası indekslerde taranan dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $OZGUN, 'puan' => 5],
    '1f' => ['baslik' => 'Uluslararası indeksli dergide yayımlanmış vaka takdimi, editöre mektup, araştırma notu, özet ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => [...$SCI, 'AHCI', 'ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => $KISA, 'puan' => 3],

    // ══ 2. ULUSAL MAKALE ══
    '2a' => ['baslik' => 'TR Dizin kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $OZGUN, 'puan' => 10],
    '2b' => ['baslik' => 'Diğer hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $OZGUN, 'puan' => 4],
    '2c' => ['baslik' => 'Ulusal hakemli dergide yayımlanmış editöre mektup, araştırma notu, özet ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 2],

    // ══ 4. KİTAP ══
    '4a' => ['baslik' => 'BKCI kapsamındaki kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 20],
    '4b' => ['baslik' => 'BKCI kapsamındaki kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 10],
    '4c' => ['baslik' => 'Diğer uluslararası ya da ulusal kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 10],
    '4d' => ['baslik' => 'Diğer uluslararası ya da ulusal kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 5],
    '4e' => ['baslik' => 'Tahkik (tenkitli metin neşri) türünde uluslararası ya da ulusal kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Tahkik (Tenkitli Metin)'], 'puan' => 10],

    // ══ 5. ATIF ══
    '5a' => ['baslik' => 'SCIE, SSCI, AHCI, ESCI, SPORTDiscus ya da Scopus kapsamındaki dergilerde eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 3],
    '5b' => ['baslik' => 'BKCI kapsamındaki kitaplarda eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 2],
    '5c' => ['baslik' => 'TR Dizin kapsamındaki dergilerde eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
    '5d' => ['baslik' => 'Diğer uluslararası ya da ulusal kitap veya dergilerde eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],

    // ══ 6. LİSANSÜSTÜ TEZ DANIŞMANLIĞI ══
    '6a' => ['baslik' => 'Danışmanlığınızda tamamlanmış doktora tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 5],
    '6a-es' => ['baslik' => 'İkinci danışman olarak tamamlanmış doktora tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 2],
    '6b' => ['baslik' => 'Danışmanlığınızda tamamlanmış yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 3],
    '6b-es' => ['baslik' => 'İkinci danışman olarak tamamlanmış yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 1],

    // ══ 7. BİLİMSEL ARAŞTIRMA PROJESİ ══
    '7a-y' => ['baslik' => 'Başarıyla tamamlanmış AB Çerçeve Programı projesinde koordinatör ya da yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 20],
    '7a-a' => ['baslik' => 'Başarıyla tamamlanmış AB Çerçeve Programı projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci'], 'puan' => 10],
    '7a-d' => ['baslik' => 'Başarıyla tamamlanmış AB Çerçeve Programı projesinde danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['danisman'], 'puan' => 6],
    '7b-y' => ['baslik' => 'Başarıyla tamamlanmış uluslararası destekli bilimsel araştırma projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 16],
    '7b-a' => ['baslik' => 'Başarıyla tamamlanmış uluslararası destekli bilimsel araştırma projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci'], 'puan' => 8],
    '7b-d' => ['baslik' => 'Başarıyla tamamlanmış uluslararası destekli bilimsel araştırma projesinde danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['danisman'], 'puan' => 5],
    '7c-y' => ['baslik' => 'Kamu kurumu ya da özel kuruluşla yapılan başarıyla tamamlanmış Ar-Ge projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'TÜSEB', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 12],
    '7c-a' => ['baslik' => 'Kamu kurumu ya da özel kuruluşla yapılan başarıyla tamamlanmış Ar-Ge projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'TÜSEB', 'Özel Sektör / STK'], 'roller' => ['arastirmaci'], 'puan' => 6],
    '7c-d' => ['baslik' => 'Kamu kurumu ya da özel kuruluşla yapılan başarıyla tamamlanmış Ar-Ge projesinde danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'TÜSEB', 'Özel Sektör / STK'], 'roller' => ['danisman'], 'puan' => 4],
    '7d' => ['baslik' => 'Başarıyla tamamlanmış üniversite BAP projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 3],
    '7e-y' => ['baslik' => 'Başarıyla tamamlanmış TÜBİTAK projesinde koordinatör ya da yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['yurutucu'], 'puan' => 7],
    '7e-a' => ['baslik' => 'Başarıyla tamamlanmış TÜBİTAK projesinde araştırmacı ya da uzman olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['arastirmaci'], 'puan' => 5],
    '7e-d' => ['baslik' => 'Başarıyla tamamlanmış TÜBİTAK projesinde danışman ya da eğitmen olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['danisman'], 'puan' => 3],
    '7f' => ['baslik' => 'Başarıyla tamamlanmış TÜBİTAK öğrenci projesinde (2209-A, 2209-B) danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'roller' => ['danisman', 'yurutucu'], 'puan' => 4],

    // ══ 8. BİLİMSEL TOPLANTI ══
    '8a' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan, tam metni ya da özeti CPCI\'da yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 5],
    '8b' => ['baslik' => 'Diğer uluslararası ya da ulusal bilimsel toplantıda sunulan, tam metni ya da özeti yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Uluslararası Özet/Poster', 'Ulusal Tam Metin', 'Ulusal Özet/Poster'], 'puan' => 3],

    // ══ 9. EĞİTİM-ÖĞRETİM ══
    '9a' => ['baslik' => 'Ön lisans, lisans ya da lisansüstü düzeyinde verilen her bir ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 2],

    // ══ 10. PATENT / FAYDALI MODEL ══
    '10a' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 25],
    '10b' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 15],
    '10c' => ['baslik' => 'Tescil edilmiş faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model'], 'puan' => 10],

    // ══ 11. ÖDÜL ══
    '11a-f' => ['baslik' => 'YÖK Yılın Doktora Tezi, YÖK Üstün Başarı, TÜBİTAK Bilim, TÜBİTAK Teşvik, TÜBA GEBİP ya da TÜBA TESEP ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 25],

    // ══ 12. EDİTÖRLÜK ══
    '12a' => ['baslik' => 'SCIE, SSCI, AHCI, ESCI ya da Scopus kapsamındaki dergilerde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 2],
    '12b' => ['baslik' => 'BKCI ya da Scopus kapsamındaki kitaplarda editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 1],
    '12c' => ['baslik' => 'TR Dizin kapsamındaki dergilerde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 1],
];

// ══ EK-2: GÜZEL SANATLAR TEMEL ALANI ══
$e2Kisisel = ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Ulusal)',
    'Elektronik Kişisel Sergi (Uluslararası)', 'Elektronik Kişisel Sergi (Ulusal)',
    'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)',
    'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)'];
$e2Film = ['Yönetmenlik (Sahne/Ekran)', 'Belgesel/Kısa Film (Uluslararası)',
    'Belgesel/Kısa Film (Ulusal)'];
$e2Karma = ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma/Jürili Etkinlik (Ulusal)',
    'Elektronik Karma Sergi (Uluslararası)', 'Elektronik Karma Sergi (Ulusal)',
    'Karma Etkinlik (Jürisiz, Ulusal)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)',
    'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)',
    'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)'];
$e2Kamusal = ['Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Satın Alınması (Yurt İçi)',
    'Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Müzeye Kabulü (Yurt İçi)',
    'Eserin Haber Olması (Uluslararası)', 'Eserin Haber Olması (Ulusal)'];
$e2Tasarim = ['Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip',
    'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman',
    'Koruma-Onarım Uygulaması (Uluslararası)', 'Koruma-Onarım Uygulaması (Ulusal)'];
$e2Reklam = ['Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)',
    'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'];
$e2Ozgun = ['Özgün Eser / Beste / Tasarım', 'Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir',
    'Opera/Bale Kompozisyonu', 'Orkestralı Sahne Eseri', 'Küçük Ölçekli Orkestra Eseri',
    'Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)',
    'Elektronik Müzik Eseri (≥15 dk)', 'Elektronik Müzik Eseri (<15 dk)', 'Sahne/Ekran Müziği',
    'Orkestrasyon/Transkripsiyon', 'Eğitim Müziği Albümü', 'Eğitim Müziği Düzenlemesi'];
$e2Solo = ['Resital (Uluslararası)', 'Resital (Ulusal)', 'Solistlik (Uluslararası)',
    'Solistlik (Ulusal)', 'Şan Resitali (Uluslararası)', 'Şan Resitali (Ulusal)'];
$e2Karma2 = ['Orkestra / Koro Üyeliği', 'Oda Müziği Grup Üyeliği (Uluslararası)',
    'Oda Müziği Grup Üyeliği (Ulusal)', 'Başkemancılık (Uluslararası)', 'Başkemancılık (Ulusal)'];
$e2Album = ['Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)'];
$e2Atolye = ['Masterclass (Uluslararası)', 'Masterclass (Ulusal)', 'Müzikoloji Atölyesi',
    'Eğitici Konser Programı (Uluslararası)', 'Eğitici Konser Programı (Ulusal)',
    'Eğitim Amaçlı Sanat Etkinliği'];
$e2Rol = ['Opera İkinci Rol (Uluslararası)', 'Opera İkinci Rol (Ulusal)',
    'Oratoryo/Kantat Solistliği (Uluslararası)', 'Oratoryo/Kantat Solistliği (Ulusal)',
    'Dansçı / Performans İcracısı (Uluslararası)', 'Dansçı / Performans İcracısı (Ulusal)'];
$e2Reji = ['Rejisörlük (Uluslararası)', 'Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)',
    'Opera Birinci Rol (Uluslararası)', 'Opera Birinci Rol (Ulusal)'];
$e2Bale = ['Bale Başrol (Uluslararası)', 'Bale Başrol (Ulusal)', 'Bale Solist Rol (Uluslararası)',
    'Bale Solist Rol (Ulusal)', 'Sahneleme/Repetitörlük — Tüm Perde (Uluslararası)',
    'Sahneleme/Repetitörlük — Tüm Perde (Ulusal)'];

$e2Kullanilan = array_merge($e2Kisisel, $e2Film, $e2Karma, $e2Kamusal, $e2Tasarim, $e2Reklam,
    $e2Ozgun, $e2Solo, $e2Karma2, $e2Album, $e2Atolye, $e2Rol, $e2Reji, $e2Bale,
    ['Sahne Tasarımı (Dekor, Kostüm, Işık)']);
$e2Kalan = array_values(array_diff(Kategori::SanatselEtkinlik->kaynaklar(), $e2Kullanilan));

$ek2 = [
    'E2-a' => ['baslik' => 'İçeriğinde en az 15 özgün sanat eseri, tasarım ya da yorum çalışması bulunan kişisel sergi açmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $e2Kisisel, 'puan' => 20],
    'E2-b' => ['baslik' => 'Film festivaline seçilen ya da davetli özel gösterimi yapılan filmin yönetmenliğini yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $e2Film, 'puan' => 20],
    'E2-d' => ['baslik' => 'Uluslararası ya da ulusal karma etkinliklerde (sergi, çalıştay, bienal, defile, festival) eserlerinizle yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $e2Karma, 'puan' => 5],
    'E2-f' => ['baslik' => 'Eserinizin kamusal alanda sürekli olarak sergilenmesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $e2Kamusal, 'puan' => 5],
    'E2-g' => ['baslik' => 'Kamu kurumları ya da özel tüzel kişiler bünyesinde uygulanan tasarımınız olmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $e2Tasarim, 'puan' => 5],
    'E2-h' => ['baslik' => 'Reklam, tanıtım filmi ya da müzik klibi yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $e2Reklam, 'puan' => 5],
    'E2-m1' => ['baslik' => 'Özgün eser (beste, kompozisyon, düzenleme) sunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $e2Ozgun, 'puan' => 5],
    'E2-m2' => ['baslik' => 'Solo konser ya da resital vermek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $e2Solo, 'puan' => 10],
    'E2-m3' => ['baslik' => 'Karma, koro ya da oda müziği konserinde icracı olarak bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $e2Karma2, 'puan' => 5],
    'E2-m4' => ['baslik' => 'Bandrollü ya da dijital yayımlanmış solo albüm', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $e2Album, 'puan' => 10],
    'E2-m5' => ['baslik' => 'Karma albüme icracı olarak katkı vermek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Albüm / CD-DVD Katkısı'], 'puan' => 5],
    'E2-m6' => ['baslik' => 'Atölye çalışması (workshop) yapmak ya da dijital platformda en az 30 dakikalık ses/video kaydı yayımlamak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $e2Atolye, 'puan' => 5],
    'E2-s1' => ['baslik' => 'Ödenekli ya da ulusal tiyatro, opera veya balede rol almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $e2Rol, 'puan' => 10],
    'E2-s2' => ['baslik' => 'Ödenekli ya da ulusal tiyatroda oyun sahnelemek, opera eserinde solist icracı ya da rejisör olmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $e2Reji, 'puan' => 25],
    'E2-s3' => ['baslik' => 'Sahnelenmiş eserde solist olarak rol almak ya da eser sahnelemek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $e2Bale, 'puan' => 15],
    'E2-s4' => ['baslik' => 'Sahnelenmiş oyunda ya da platoda uygulanmış özgün sahne, dekor, kostüm veya ışık tasarımı yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne Tasarımı (Dekor, Kostüm, Işık)'], 'puan' => 10],
    'E2-s5' => ['baslik' => 'Diğer sanatsal etkinlikler (koreografi, şeflik, rejisör yardımcılığı, jüri üyeliği, corps de ballet ve benzeri)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $e2Kalan, 'puan' => 5],
];

$KAPSAM = 'Puanlar Kırşehir Ahi Evran Üniversitesi Öğretim Üyeliğine Yükseltilme ve Atanma '
    .'Yönergesinin Ek-1 puanlama tablosundan. Yazar çarpanı: tek yazarlı makalede tam puan, '
    .'başlıca yazar olduğunuz iki yazarlı makalede 0,8; üç ve daha fazla yazarlıda 0,5; başlıca '
    .'yazar değilseniz puan yazar sayısına eşit bölünür. Yazar listesini boş bırakırsanız çarpan '
    .'hiç uygulanmaz ve puanınız olduğundan YÜKSEK görünür. '
    .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: TÜBİTAK projeleri 7 puandan sayılıyor — '
    .'yönerge 7.a\'da araştırma projelerine 20, 7.e\'de bilim ve toplum projelerine 7 puan '
    .'veriyor, kayıt ikisini ayıramadığı için düşük olan alındı; TÜBİTAK 1001 gibi bir '
    .'yürütücülüğünüz varsa gerçek puanınız çok daha yüksektir. En üst %10\'luk dilim makaleleri '
    .'(50) Q1 satırından (30) sayılıyor. 14. madde (h-indeksi 5-10 puan, altı ay yurt dışı '
    .'araştırma 5 puan, film jürisi, eğiticilerin eğitimi — en çok 15 puan) faaliyet satırına '
    .'çevrilemediği için hiç girilmedi. Ek-1 madde 3\'ün kurumsal katkı puanları (en çok 12) '
    .'yalnızca asgari faaliyet sayısının ÜSTÜNDEKİ faaliyetlere verildiği için girilmedi. '
    .'13.A (İlahiyat sanatsal icra), 13.B (Mimarlık yarışma ve yazılım) ve 13.C (Spor Bilimleri '
    .'sportif başarı) tabloları tek temel alana kilitli olduğu için girilmedi. Hukuk, İlahiyat ve '
    .'Filoloji temel alanlarında 4.c kitap satırı 20 puan; cetvel alana göre bölünmediği için '
    .'hepsinde 10 puandan sayılıyor. Vaka takdimi (5) araştırma notundan ayrılamadığı için 3 '
    .'puandan, ikinci danışmanlıklar aşağı yuvarlanarak sayılıyor. Patent BAŞVURUNUZU (2 puan) '
    .'kaydetmeyin: tescilliden ayrılamadığı için o satır girilmedi ve tescilli sayılır. '
    .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünebilir: yönerge makale harici eserlerde '
    .'puanı daima yazar sayısına eşit bölüyor; motor makale kuralını (başlıca yazara 0,8 ve 0,5) '
    .'bütün kategorilere uyguluyor, çok yazarlı bir kitapta ya da patentte ilk isimseniz birkaç '
    .'puan fazla görünür. "Aynı kitaptan en fazla iki bölüm", "aynı toplantıdan en fazla iki '
    .'bildiri", "bir eserin aynı yayındaki atıfları tek sayılır" gibi eser bazlı sınırlar '
    .'uygulanmıyor.';

// Ek-1'in başında: "Tek yazarlı makalelerde yazar tam puan alır. Adayın
// başlıca yazar olduğu iki yazarlı makalelerde tam puanın 0,8'i, üç veya
// daha fazla yazarlıda yarısı. Başlıca yazar olmadığı durumlarda ve makale
// harici eserlerde toplam puan yazarlar arasında eşit bölünür."
$YAZAR = [
    'haric' => ['atif', 'tez_danismanligi', 'egitim_ogretim', 'idari_gorev', 'odul',
        'editorluk', 'toplumsal_katki', 'proje', 'diger'],
    'roller' => [
        'tek' => ['kademeler' => [1 => 1.00]],
        'ilk' => ['kademeler' => [1 => 1.00, 2 => 0.80], 'sonrasi' => 0.50],
        'baslica' => ['kademeler' => [1 => 1.00, 2 => 0.80], 'sonrasi' => 0.50],
        'ortak' => ['bol' => ['pay' => 1.0]],
    ],
];

$GRUPLAR = [
    // Koşulların atıf yaptığı Ek-1 satırları.
    'M1A' => ['1a-Q1', '1a-Q2', '1a-Q3', '1a-Q4'],
    'M1ABC' => ['1a-Q1', '1a-Q2', '1a-Q3', '1a-Q4', '1b', '1c'],
    'M1ABC2A' => ['1a-Q1', '1a-Q2', '1a-Q3', '1a-Q4', '1b', '1c', '2a'],
    'EK1' => array_keys($ek1),

    // 12. madde (5): Ek-1'in bilimsel araştırma projesi başlığı.
    'B7' => ['7a-y', '7a-a', '7a-d', '7b-y', '7b-a', '7b-d', '7c-y', '7c-a', '7c-d',
        '7d', '7e-y', '7e-a', '7e-d', '7f'],
    'P7AB-Y' => ['7a-y', '7b-y'],
    'P7C-Y' => ['7c-y'],

    // Tavan grupları.
    'K-CD' => ['4c', '4d'],
    'ATIF' => ['5a', '5b', '5c', '5d'],
    'TEZ' => ['6a', '6a-es', '6b', '6b-es'],
    'BAP' => ['7d'],
    'P-OGRENCI' => ['7f'],
    'P-BILIMTOPLUM' => ['7e-y', '7e-a', '7e-d'],
    'BILDIRI' => ['8a', '8b'],
    'DERS' => ['9a'],
    'ODUL' => ['11a-f'],
    'ED-C' => ['12c'],
    'ED' => ['12a', '12b', '12c'],
];

$TAVANLAR = [
    'K-CD' => 20,      // 4. madde: c veya d bentlerinden toplamda en fazla 20
    'ATIF' => 15,      // 5. madde: en fazla 15
    'TEZ' => 15,       // 6. madde: en fazla 15
    'BAP' => 6,        // 7.d: en fazla 6
    'P-OGRENCI' => 12, // 7.f: en fazla 12
    'P-BILIMTOPLUM' => 12, // 7.e: en fazla 12
    'BILDIRI' => 10,   // 8. madde: en fazla 10
    'DERS' => 10,      // 9. madde: en fazla 10
    'ODUL' => 25,      // 11. madde: en fazla 25
    'ED-C' => 4,       // 12.c: en fazla 4
    'ED' => 10,        // 12. madde: toplamda en fazla 10
];

return [
    'cetveller' => [
        'ahi-evran-2024' => [
            'kapsam_notu' => $KAPSAM,
            'yazar_katsayisi' => $YAZAR,
            'maddeler' => $ek1,
            'gruplar' => $GRUPLAR,
            'grup_tavanlari' => $TAVANLAR,
        ],
        'ahi-evran-2024-gsf' => [
            'kapsam_notu' => $KAPSAM.' Güzel Sanatlar temel alanında Ek-2 tablosunun sanatsal '
                .'satırları da sayılıyor; Ek-2\'de albüm (bandrollü 20, dijital 10), özgün eser '
                .'(kompozisyon 10, Türk müziği 5) ve konser (solo 10, karma 5) ayrımı kayıttan '
                .'okunamadığı için hepsi en düşük değerden. Orkestra şefliğinin 60 puanlık '
                .'satırı dört saatlik kayıt ve üç farklı orkestra istediği için tek etkinlik '
                .'kaydından hesaplanamıyor; şeflik kayıtları diğer sanatsal etkinlikler '
                .'satırından (5) sayılıyor.',
            'yazar_katsayisi' => $YAZAR,
            'maddeler' => array_merge($ek1, $ek2),
            'gruplar' => $GRUPLAR,
            'grup_tavanlari' => $TAVANLAR,
        ],
    ],
];
