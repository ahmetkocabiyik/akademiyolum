<?php

use App\Enums\Kategori;

/**
 * MUĞLA SITKI KOÇMAN ÜNİVERSİTESİ — EK-1 Yayınların Değerlendirilmesi
 * (+ Güzel Sanatlar için EK-3 Sanatsal Etkinlikler)
 * Kaynak: pdf/17537004412.muglasitkikocmanuniverstesi.pdf
 * (24 sayfa; yürürlük 01.01.2013, değişiklikler 15.01.2014-488/15 ve
 * 15.04.2015-506/1 Senato kararları)
 *
 * ── DÖRT SÜTUN, DÖRT CETVEL ──
 * EK-1'in puan sütunu dört alan grubuna ayrılıyor:
 *   `musku-2013-fen`     Temel Bilimler, Mühendislik, Su Ürünleri ve
 *                        Teknoloji Fakültesi
 *   `musku-2013-saglik`  Sağlık Bilimleri ve Tıp
 *   `musku-2013-gsf`     Güzel Sanatlar (EK-3 yalnız burada)
 *   `musku-2013-sosyal`  Sosyal Bilimler ve Eğitim Bilimleri
 * Sütunlar yalnız A ve B bölümlerinde (makale ve bildiri) farklılaşıyor;
 * C'den İ'ye kadarki bütün satırlar dört sütunda aynı.
 *
 * ── EK-3 YALNIZ GÜZEL SANATLAR CETVELİNDE ──
 * Madde 7 EK-3'ü yalnız Güzel Sanatlar Fakültesi ve güzel sanatlar
 * eğitimi bölümlerine bağlıyor; diğer üç cetvelde sanatsal etkinlik
 * kaydınız 0 puandır.
 *
 * ── AYNI ETİKETE DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   D bölümünde baş editörlük (150/100/50), yardımcı editörlük ile yayın
 *       kurulu üyeliği (75/50) ve hakemlik (50/25/15) — etiket ayrımı
 *       kısmen var; yayın kurulu üyeliği 50, hakemlik 15 puandan.
 *   İ-1/İ-2 sanat jürileri (70/35) → 35; İ-3 ile İ-6 arası toplantı
 *       görevleri (30/15/15/10) → 10; İ-7/İ-8 davetli konuşmacılık
 *       (20/10) → 10.
 *   H-1 uluslararası ödül (200) ile H-2 ulusal ödül (100) — etiket
 *       ayrımı var.
 *   EK-3'te ulusal ve uluslararası sütunlar ayrı; etiket ikisini
 *       ayırabildiği yerde ayrıldı, ayıramadığı yerde ULUSAL değerden.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   EK-1'de yok: idari görevler, ders verme, toplumsal katkı. Bu
 *       kayıtlarınız 0 puandır (yönergenin kendi tablosu bunları
 *       saymıyor).
 *   EK-3'te 12 (eğitim müziği dizini), 16 (tiyatro çalışmaları),
 *       19 (atölye çalışmaları), 20 (küratörlük) ve 21 (sanat
 *       danışmanlığı) satırlarının bir kısmı sözlükte karşılıksız.
 *
 * ── UYGULANMAYAN BÖLÜŞÜM VE İNDİRİMLER ──
 *   Madde 2(9)-(10): kitap ve çeviri puanlarının YAZAR SAYISINA
 *       bölünmesi, çeviri kitabın yarısından azını çevirene puanın
 *       yarısı.
 *   Madde 5(15): yarışmalarda ikincilik ödülüne puanın %50'si,
 *       üçüncülüğe %25'i.
 *   Madde 5(17): projelerde araştırmacı puanının ARAŞTIRMACI SAYISINA
 *       bölünmesi — cetvelde G-2, G-4 ve G-6 satırları tam puandan.
 *   Madde 5(14): editörlükte en az bir yıl hizmet koşulu.
 *   Bu dördü de puanınızı OLDUĞUNDAN YÜKSEK gösterir.
 *
 * Yönerge: yonerge/musku.php
 */
$SCI = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];
$TAM = ['ozgun_makale', 'derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];

$sanatKisiselU = ['Kişisel Etkinlik (Uluslararası)', 'Elektronik Kişisel Sergi (Uluslararası)',
    'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)'];
$sanatKisiselN = ['Kişisel Etkinlik (Ulusal)', 'Elektronik Kişisel Sergi (Ulusal)',
    'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)'];
$sanatKarmaU = ['Karma/Jürili Etkinlik (Uluslararası)', 'Elektronik Karma Sergi (Uluslararası)',
    'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)'];
$sanatKarmaN = ['Karma/Jürili Etkinlik (Ulusal)', 'Elektronik Karma Sergi (Ulusal)',
    'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Karma Etkinlik (Jürisiz, Ulusal)',
    'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)'];
$sanatSatinU = ['Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Müzeye Kabulü (Yurt Dışı)'];
$sanatSatinN = ['Eserin Satın Alınması (Yurt İçi)', 'Eserin Müzeye Kabulü (Yurt İçi)'];
$sanatYayin = ['Eserin Haber Olması (Uluslararası)', 'Eserin Haber Olması (Ulusal)',
    'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)',
    'Belgesel/Kısa Film (Uluslararası)', 'Belgesel/Kısa Film (Ulusal)'];
$sanatJuri = ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)',
    'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'];
$sanatSeflik = ['Orkestra Şefliği (Uluslararası)', 'Orkestra Şefliği (Ulusal)',
    'Koro Şefliği (Uluslararası)', 'Koro Şefliği (Ulusal)', 'Grup Şefliği (Uluslararası)',
    'Grup Şefliği (Ulusal)', 'Opera Şefliği (Uluslararası)', 'Opera Şefliği (Ulusal)',
    'Bale Orkestra Şefliği (Uluslararası)', 'Bale Orkestra Şefliği (Ulusal)'];
$sanatIcra = ['Orkestra / Koro Üyeliği', 'Oda Müziği Grup Üyeliği (Uluslararası)',
    'Oda Müziği Grup Üyeliği (Ulusal)', 'Başkemancılık (Uluslararası)', 'Başkemancılık (Ulusal)',
    'Solistlik (Uluslararası)', 'Solistlik (Ulusal)', 'Resital (Uluslararası)', 'Resital (Ulusal)',
    'Şan Resitali (Uluslararası)', 'Şan Resitali (Ulusal)', 'Corps de Ballet (Uluslararası)',
    'Corps de Ballet (Ulusal)'];
$sanatBeste = ['Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Opera/Bale Kompozisyonu',
    'Orkestralı Sahne Eseri', 'Küçük Ölçekli Orkestra Eseri', 'Oda/Koro Müziği Eseri (≥15 dk)',
    'Oda/Koro Müziği Eseri (<15 dk)', 'Elektronik Müzik Eseri (≥15 dk)',
    'Elektronik Müzik Eseri (<15 dk)', 'Sahne/Ekran Müziği', 'Özgün Eser / Beste / Tasarım',
    'Orkestrasyon/Transkripsiyon'];
$sanatBurs = ['Eğitim Amaçlı Sanat Etkinliği', 'Eğitim Müziği Albümü',
    'Eğitim Müziği Düzenlemesi', 'Masterclass (Uluslararası)', 'Masterclass (Ulusal)',
    'Müzikoloji Atölyesi', 'Eğitici Konser Programı (Uluslararası)',
    'Eğitici Konser Programı (Ulusal)'];

$sanatKullanilan = array_merge($sanatKisiselU, $sanatKisiselN, $sanatKarmaU, $sanatKarmaN,
    $sanatSatinU, $sanatSatinN, $sanatYayin, $sanatJuri, $sanatSeflik, $sanatIcra,
    $sanatBeste, $sanatBurs);
$sanatKalan = array_values(array_diff(Kategori::SanatselEtkinlik->kaynaklar(), $sanatKullanilan));

/** EK-3: yalnız Güzel Sanatlar cetvelinde. */
$ek3 = [
    'E3-1u' => ['baslik' => 'Özgün yapıt, proje ya da tasarımlarla uluslararası kişisel etkinlikte bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKisiselU, 'puan' => 200],
    'E3-1n' => ['baslik' => 'Özgün yapıt, proje ya da tasarımlarla ulusal kişisel etkinlikte bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKisiselN, 'puan' => 150],
    'E3-2u' => ['baslik' => 'Uluslararası karma sanat etkinliğine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKarmaU, 'puan' => 75],
    'E3-2n' => ['baslik' => 'Ulusal karma sanat etkinliğine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => [...$sanatKarmaN, ...$sanatKalan], 'puan' => 40],
    'E3-5u' => ['baslik' => 'Çalışmalarınızın uluslararası kurum, kuruluş ya da sanat müzelerince satın alınması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatSatinU, 'puan' => 300],
    'E3-5n' => ['baslik' => 'Çalışmalarınızın ulusal kurum, kuruluş ya da sanat müzelerince satın alınması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatSatinN, 'puan' => 200],
    'E3-6' => ['baslik' => 'Yapıtlarınızın, projelerinizin ya da tasarımlarınızın yayınlarda yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatYayin, 'puan' => 50],
    'E3-8' => ['baslik' => 'Yarışma seçici kurullarında görev yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatJuri, 'puan' => 50],
    'E3-9' => ['baslik' => 'Müzik topluluğu (koro, orkestra ve benzeri) yönetmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatSeflik, 'puan' => 25],
    'E3-10' => ['baslik' => 'Müzik topluluğunda çalmak ya da söylemek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatIcra, 'puan' => 25],
    'E3-13' => ['baslik' => 'Ses ve enstrüman toplulukları için çeşitli türlerde özgün eser yaratmış olmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatBeste, 'puan' => 250],
    'E3-19' => ['baslik' => 'Sanat ve tasarım atölye çalışmaları ile eğitim amaçlı sanat etkinlikleri', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatBurs, 'puan' => 25],
    // EK-3'ün 18. satırı: "Alanında sanatsal ve tasarıma yönelik araştırma ve
    // çalışmalar için alınan burslar" (ulusal 50 / uluslararası 75). Ana
    // tabloda burs satırı YOK; 'Burs' etiketi 01.09.2026'ya kadar 100 puanlık
    // ulusal ödül satırındaydı. §0 uyarınca ulusal değerden.
    'E3-18' => ['baslik' => 'Sanatsal ve tasarıma yönelik araştırma bursu', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 50],
];

/**
 * @param  array{a1: int, a2: int, a3: int, a5: int, a6: int, b1: int, b2: int, b3: int, b4: int, b5: int, b6: int}  $s
 * @return array<string, array<string, mixed>>
 */
$govde = fn (array $s): array => [
    // ══ A. MAKALELER ══
    'A-1' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI tarafından taranan dergide yayımlanan tam makale', 'kategori' => 'makale', 'kaynaklar' => $SCI, 'turler' => $TAM, 'puan' => $s['a1']],
    'A-2' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI dergisinde teknik not, editöre mektup, tartışma, vaka takdimi veya özet', 'kategori' => 'makale', 'kaynaklar' => $SCI, 'turler' => $KISA, 'puan' => $s['a2']],
    'A-3' => ['baslik' => 'Diğer uluslararası indeksler tarafından taranan dergide yayımlanan tam makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => $TAM, 'puan' => $s['a3']],
    'A-4' => ['baslik' => 'Diğer uluslararası indeksli dergide teknik not, editöre mektup, tartışma, vaka takdimi veya özet', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => $KISA, 'puan' => 50],
    'A-5' => ['baslik' => 'Ulusal hakemli dergide yayımlanmış tam makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => $TAM, 'puan' => $s['a5']],
    'A-6' => ['baslik' => 'Ulusal hakemli dergide teknik not, editöre mektup, tartışma, vaka takdimi veya özet', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => $s['a6']],

    // ══ B. BİLDİRİLER ══
    'B-1' => ['baslik' => 'Uluslararası bilimsel toplantıda sözlü sunulan ve tam metin olarak yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => $s['b1']],
    'B-3' => ['baslik' => 'Uluslararası bilimsel toplantıda özet metin olarak yayımlanan ya da poster olarak sergilenen bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => $s['b3']],
    'B-4' => ['baslik' => 'Ulusal bilimsel toplantıda sözlü sunulan ve tam metin olarak yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => $s['b4']],
    'B-6' => ['baslik' => 'Ulusal bilimsel toplantıda özet metin olarak yayımlanan ya da poster olarak sergilenen bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => $s['b6']],

    // ══ C. KİTAPLAR ══
    'C-1' => ['baslik' => 'Alanında tanınmış uluslararası yayınevlerince yayımlanan kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 300],
    'C-2' => ['baslik' => 'Alanında tanınmış ulusal yayınevince yayımlanan kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Ders / Metot Kitabı'], 'puan' => 200],
    'C-3' => ['baslik' => 'Alanında tanınmış uluslararası yayınevlerince yayımlanan kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 125],
    'C-4' => ['baslik' => 'Alanında tanınmış ulusal yayınevince yayımlanan kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 70],

    // ══ Ç. ÇEVİRİLER ══
    'C-5' => ['baslik' => 'Alanında kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 70],
    'C-6' => ['baslik' => 'Alanında makale, kitap bölümü ya da karar tahlili çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 20],

    // ══ D. EDİTÖRLÜK VE HAKEMLİKLER ══
    'D-1' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI dergilerinde baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 150],
    'D-2' => ['baslik' => 'Diğer uluslararası indeksli dergilerde baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 100],
    'D-3' => ['baslik' => 'Diğer bilimsel, sanatsal ya da mesleki hakemli dergilerde baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 50],
    'D-5' => ['baslik' => 'Dergilerde yardımcı editörlük ya da yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 50],
    'D-6' => ['baslik' => 'Alanında yurt dışında yayımlanan kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 100],
    'D-7' => ['baslik' => 'Alanında yurt içinde yayımlanan kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 70],
    'D-10' => ['baslik' => 'Bilimsel, sanatsal ya da mesleki hakemli dergilerde hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 15],

    // ══ E. ATIFLAR ══
    'E-1' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI dergilerinde ve yurt dışında yayımlanan kitaplarda eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 20],
    'E-2' => ['baslik' => 'Diğer uluslararası indeksli dergilerde ve yurt içinde yayımlanan kitaplarda eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Patent'], 'puan' => 10],
    'E-3' => ['baslik' => 'Ulusal hakemli dergilerde eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer'], 'puan' => 5],

    // ══ F. TEZ YÖNETİMİ ══
    'F-1' => ['baslik' => 'Yönetiminizde tamamlanmış doktora, tıpta uzmanlık ya da sanatta yeterlik tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman', 'es_danisman'], 'puan' => 40],
    'F-2' => ['baslik' => 'Yönetiminizde tamamlanmış yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi', 'Tez İzleme / Jüri Üyeliği'], 'roller' => ['danisman', 'es_danisman'], 'puan' => 20],

    // ══ G. ARAŞTIRMA PROJELERİ ══
    'G-1' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen ve tamamlanmış projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 175],
    'G-2' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen ve tamamlanmış projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 85],
    'G-3' => ['baslik' => 'TÜBİTAK, TÜBA, bakanlıklar ve benzeri kamu kurumları ya da özel kuruluşlarca desteklenen ve tamamlanmış projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 130],
    'G-4' => ['baslik' => 'TÜBİTAK, TÜBA, bakanlıklar ve benzeri kurumlarca desteklenen ve tamamlanmış projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 70],
    'G-5' => ['baslik' => 'Bilimsel Araştırma Projelerinde (BAP) yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 100],
    'G-6' => ['baslik' => 'Bilimsel Araştırma Projelerinde (BAP) görev almak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 70],

    // ══ H. ÖDÜLLER ══
    'H-1' => ['baslik' => 'Alanında uluslararası bilimsel nitelikli ödül almak', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 200],
    'H-2' => ['baslik' => 'Alanında ulusal bilimsel nitelikli ödül almak', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü'], 'puan' => 100],
    // Esasların 15. fıkrası yarışma derecelerini tablo puanına ORANLIYOR:
    // birincilik tam, ikincilik %50, üçüncülük %25. Faaliyet kaydı dereceyi
    // taşımadığı için §0 uyarınca en düşük derece (ulusal ödülün %25'i)
    // uygulandı; 'Yarışma Derecesi / Mansiyon' 01.09.2026'da H-2'den alındı.
    'H-2-yarisma' => ['baslik' => 'Ulusal veya uluslararası yarışmada derece', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 25],

    // ══ I. PATENT ══
    'I-1' => ['baslik' => 'Yurt dışında patentlenmiş buluş', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 700],
    'I-2' => ['baslik' => 'Yurt içinde patentlenmiş buluş', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım', 'Islahçı Hakkı / Çeşit Tescili', 'Ticarileştirme'], 'puan' => 350],

    // ══ İ. DİĞER ETKİNLİKLER ══
    'J-6' => ['baslik' => 'Bilimsel, sanatsal ve tasarıma yönelik etkinliklerde başkanlık ya da görev almak', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 10],
    'J-8' => ['baslik' => 'Alanınızla ilgili panel, konferans, seminer, kurs ya da açık oturumda davetli konuşmacı veya panelist olarak görev almak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 10],
];

$KAPSAM = 'Puanlar Muğla Sıtkı Koçman Üniversitesi Akademik Yükseltilme ve Atama Kriterlerine '
    .'İlişkin Yayınların Değerlendirilmesi tablosundan (EK-1). Yönerge genel bir yazar çarpanı '
    .'KOYMUYOR; yalnız kitap, çeviri ve proje satırlarında "puan/yazar sayısı" ya da '
    .'"araştırmacı sayısına bölünerek" diyor. Bu bölüşümler kayıttan hesaplanamadığı için '
    .'uygulanmıyor ve çok yazarlı kitap, çeviri ve projelerde puanınız OLDUĞUNDAN YÜKSEK '
    .'görünür. Aynı biçimde yarışmalarda ikincilik (%50) ve üçüncülük (%25) indirimi, çeviri '
    .'kitabın yarısından azını çevirene verilen yarım puan ve editörlükte "en az bir yıl hizmet" '
    .'koşulu da uygulanmıyor. '
    .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: uluslararası özet bildiri ile poster tek '
    .'satıra düşüyor (poster değerinden), ulusal özet ile poster de öyle. Yardımcı editörlük ve '
    .'yayın kurulu üyeliği 50, hakemlikler 15, sanat jürileri 35, toplantı görevleri ve davetli '
    .'konuşmacılık 10 puandan sayılıyor. EK-1 idari görev, ders verme ve toplumsal katkı '
    .'satırları içermiyor; bu kayıtlarınız 0 puandır — yönergenin kendi tablosu bunları saymıyor.';

$sutunlar = [
    'musku-2013-fen' => ['a1' => 125, 'a2' => 85, 'a3' => 85, 'a5' => 70, 'a6' => 25, 'b1' => 50, 'b2' => 35, 'b3' => 30, 'b4' => 30, 'b5' => 15, 'b6' => 15],
    'musku-2013-saglik' => ['a1' => 125, 'a2' => 85, 'a3' => 85, 'a5' => 70, 'a6' => 25, 'b1' => 50, 'b2' => 35, 'b3' => 30, 'b4' => 45, 'b5' => 30, 'b6' => 20],
    'musku-2013-gsf' => ['a1' => 225, 'a2' => 75, 'a3' => 100, 'a5' => 75, 'a6' => 15, 'b1' => 70, 'b2' => 30, 'b3' => 30, 'b4' => 40, 'b5' => 20, 'b6' => 10],
    'musku-2013-sosyal' => ['a1' => 225, 'a2' => 75, 'a3' => 100, 'a5' => 75, 'a6' => 15, 'b1' => 70, 'b2' => 30, 'b3' => 20, 'b4' => 40, 'b5' => 20, 'b6' => 10],
];

$cetveller = [];

foreach ($sutunlar as $anahtar => $sutun) {
    $gsf = $anahtar === 'musku-2013-gsf';
    $maddeler = $gsf ? array_merge($govde($sutun), $ek3) : $govde($sutun);

    $cetveller[$anahtar] = [
        'kapsam_notu' => $KAPSAM.($gsf
            ? ' Güzel Sanatlar için EK-3 sanatsal etkinlikler tablosu da sayılıyor; EK-3\'ün '
                .'ulusal ve uluslararası sütunları etiketin ayırabildiği yerde ayrıldı, '
                .'ayıramadığı yerde ULUSAL değerden sayılıyor. Tiyatro çalışmaları, eğitim '
                .'müziği dizini, küratörlük ve sanat danışmanlığı satırları sözlükte '
                .'karşılıksız olduğu için girilemedi.'
            : ' EK-3 sanatsal etkinlikler tablosu yönergede yalnız Güzel Sanatlar Fakültesi ve '
                .'güzel sanatlar eğitimi bölümlerine verildiği için bu cetvelde yok; sanatsal '
                .'etkinlik kaydınız 0 puandır.'),
        'maddeler' => $maddeler,
        'gruplar' => [
            'A' => ['A-1', 'A-2', 'A-3', 'A-4', 'A-5', 'A-6'],
            'B' => ['B-1', 'B-3', 'B-4', 'B-6'],
            'C' => ['C-1', 'C-2', 'C-3', 'C-4', 'C-5', 'C-6'],
            'ABC' => ['A-1', 'A-2', 'A-3', 'A-4', 'A-5', 'A-6', 'B-1', 'B-3', 'B-4', 'B-6',
                'C-1', 'C-2', 'C-3', 'C-4', 'C-5', 'C-6'],
            // Madde 6(1)-a: SCI/SSCI/AHCI makalesi ya da ulusal/uluslararası hakemli makale.
            'MAKALE-SCI' => ['A-1'],
            'MAKALE-HAKEMLI' => ['A-1', 'A-3', 'A-5'],
        ] + ($gsf ? ['EK3' => array_keys($ek3)] : []),
        'grup_tavanlari' => [],
    ];
}

return ['cetveller' => $cetveller];
