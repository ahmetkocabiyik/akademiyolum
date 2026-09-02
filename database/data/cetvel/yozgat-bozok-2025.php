<?php

/**
 * YOZGAT BOZOK ÜNİVERSİTESİ — Ek-1 Puanlama Tablosu
 * Kaynak: pdf/17639920441000.yozgat-bozok-kriter-24112025.pdf (21 sayfa;
 * Akademik Yükseltilme ve Atanma Yönergesi, YÖK onayıyla yürürlüğe girer.)
 *
 * Madde kodları Ek-1'in kendi numaralandırması (A1.1, A7.2.3, B3.1.4 …).
 * Yalnız projelerdeki rol ayrımı ile eş danışmanlık için açılan alt kodlar
 * ve kitap editörlüğünün ayrı satıra alınması bize ait.
 *
 * ── TABLO-A / TABLO-B AYRIMI KOŞULLARIN TEMELİ ──
 * Yönergenin bütün eşikleri "Tablo-A'dan en az X puan olmak koşuluyla
 * toplamda Y puan" biçiminde. Bu yüzden `TABLO-A` ve `TABLO-B` kümeleri
 * cetvelin en önemli iki grubu; koşullar bunlara bağlanıyor.
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞEN SATIRLARDA DÜŞÜK OLAN GİRİLDİ (§0) ──
 *   A2.3, A3.2 ve A3.4 (Yozgat Bozok bünyesinde yayımlanan dergiler,
 *       9/15/9 puan) — sözlük derginin hangi üniversiteye ait olduğunu
 *       taşımıyor; bu satırlar girilmedi, makaleleriniz A2.2, A3.1 ve
 *       A3.3'ün daha düşük puanlarından sayılıyor.
 *   A5'te AHCI dergilerinde yayımlanan kısa yazılar için çeyreklik satırı
 *       yok; sözlük AHCI'ye çeyreklik vermediği için en düşük çeyrek
 *       satırından (A5.4, 5 puan) sayılıyor.
 *   A11'in uluslararası ve ulusal faydalı model (20 / 10) ile tasarım
 *       tescili (15 / 8) satırları tek 'Faydalı Model' ve 'Endüstriyel
 *       Tasarım' etiketine düşüyor; ulusal değerler girildi. Çeşit tescili
 *       de ulusal patent satırından (18) sayılıyor.
 *   B2'nin tez izleme komitesi üyeliği (3) ile tez jürisi üyeliği (2) tek
 *       etikete düşüyor; 2 girildi.
 *   B3.2'nin yedi kademesi tek 'Yayın Kurulu Üyeliği' etiketine düşüyor;
 *       en düşük değer (2) girildi. B3.3'ün dört kademesi tek 'Hakemlik'
 *       etiketine düşüyor; 1 girildi.
 *   B4.1 bilim ödülü (30) ile B4.2 teşvik ödülü (15) tek 'TÜBİTAK / TÜBA
 *       Ödülü' etiketine düşüyor; 15 girildi. B4.7 ile B4.8 kongre ödülü
 *       (8 / 4) → 4. B6.2 ile B6.3 bilimsel kurul üyeliği (20 / 10) → 10.
 *   B5.1'in dört toplantı satırı (8/4/4/2) tek 'Diğer' etiketine düşüyor;
 *       2 girildi.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   A7.5 (Teknopark firmalarıyla proje, 15) ve A7.6 (yurt dışında en az
 *       altı ay bulunmak, 30) — ilki 'Özel Sektör / STK' etiketini A7.4
 *       ile paylaşırdı, ikincisi faaliyet değil süre ölçütü.
 *   A8.4-A8.9 (Bozok Akademi dersleri, SEM kursu, hizmet içi eğitim,
 *       gözetmenlik, lisans danışmanlığı) — sözlükte karşılıksız.
 *   A9.2 ve A9.4 (DEVAM EDEN tez danışmanlığı, 10 ve 5) — kayıt yalnız
 *       tamamlanmış tezleri taşıyor.
 *   A11'in bütün BAŞVURU ve "olumlu araştırma raporu almış" kademeleri —
 *       tescilliden ayrılamıyor; girilseydi başvuru sahibi tescil sahibi
 *       gibi sayılırdı.
 *   B5.3 (millî takım antrenörlüğü, müsabaka dereceleri) ve B5.4.3-B5.4.6
 *       (proje başvurusu, TÜBİTAK panelistliği) — sözlükte karşılıksız.
 *   B5.4.7 (h-indeksi puanı) — faaliyet değil profil ölçütü.
 *   A4.8 ve A4.9 (ders kitabı editörlüğü ve bölüm yazarlığı, 4) — 'Kitap
 *       Editörlüğü' ve 'Kitap Bölümü' etiketleri A4.5 ile A4.6 tarafından
 *       kullanılıyor.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   Üniversitenin ihtisas alanıyla ilgili çalışmalarda A1-A5, A7 ve A9
 *       puanlarının 1,5 katı alınması — kayıt çalışmanın ihtisas alanıyla
 *       ilgisini taşımıyor, çarpan uygulanmadı.
 *   A8'in "bir yarıyılda en fazla 5 puan" ve B3.3'ün "yıllık en fazla 10
 *       puan" kuralları yıl/yarıyıl başına; B3.3 için mutlak 10 tavanı
 *       yazıldı, A8 için tavan yazılamadı.
 *   A6'nın "aynı toplantıda en fazla 2 bildiri" kuralı.
 *   A10.2 ve A10.3'ün seri üretim ve uygulanmama çarpanları.
 *
 * TAVAN TARAMASI (01.09.2026): kaynağın "Not 2: A8.1, A8.2 ve A8.3'de yer
 * alan faaliyetlerden BİR YARIYILDA en fazla 5 puan alınabilir" sınırı
 * uygulanamıyor — tavan yarıyıl başına ve faaliyet kaydı yarıyıl bilgisi
 * taşımıyor. Ders puanı bu yüzden olduğundan yüksek görünebilir.
 *
 * Yönerge: yonerge/yozgat-bozok.php
 */
$TAM = ['ozgun_makale', 'derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];
$PROJE_ULUSLARARASI = ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'];
$PROJE_KAMU = ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'];

$maddeler = [
    // ══ A1. SCI, SCI-Expanded, SSCI, AHCI DERGİLERİ ══
    'A1.1' => ['baslik' => 'SCI, SCI-Expanded ya da SSCI kapsamındaki Q1 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $TAM, 'puan' => 30],
    'A1.2' => ['baslik' => 'SCI, SCI-Expanded ya da SSCI kapsamındaki Q2 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $TAM, 'puan' => 20],
    'A1.3' => ['baslik' => 'SCI, SCI-Expanded ya da SSCI kapsamındaki Q3 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $TAM, 'puan' => 15],
    'A1.4' => ['baslik' => 'SCI, SCI-Expanded ya da SSCI kapsamındaki Q4 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => $TAM, 'puan' => 10],
    'A1.5' => ['baslik' => 'AHCI kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => $TAM, 'puan' => 20],

    // ══ A2. DİĞER ULUSLARARASI ALAN İNDEKSLERİ ══
    'A2.1' => ['baslik' => 'ESCI, SCOPUS ya da SPORTDiscus tarafından taranan dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $TAM, 'puan' => 10],
    'A2.2' => ['baslik' => 'Diğer uluslararası indekslerde taranan dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $TAM, 'puan' => 6],

    // ══ A3. ULUSAL DERGİLER ══
    'A3.1' => ['baslik' => 'TR Dizin kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $TAM, 'puan' => 10],
    'A3.3' => ['baslik' => 'Diğer ulusal hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $TAM, 'puan' => 6],

    // ══ A4. KİTAP ══
    'A4.1' => ['baslik' => 'BKCI kapsamındaki yayınevinde kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 30],
    'A4.2' => ['baslik' => 'BKCI kapsamındaki yayınevinde kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 15],
    'A4.3' => ['baslik' => 'BKCI kapsamındaki yayınevinde bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 20],
    'A4.4' => ['baslik' => 'Alanında tanınırlığı olan bir yayınevi tarafından yayımlanan bilimsel ya da mesleki kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 20],
    'A4.5' => ['baslik' => 'Alanında tanınırlığı olan bir yayınevi tarafından yayımlanan bilimsel ya da mesleki kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 10],
    'A4.6' => ['baslik' => 'Alanında tanınırlığı olan bir yayınevi tarafından yayımlanan bilimsel ya da mesleki kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 5],
    'A4.7' => ['baslik' => 'Alanında tanınırlığı olan bir yayınevi tarafından yayımlanan ders kitabı yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı'], 'puan' => 8],
    'A4.10' => ['baslik' => 'Tahkik (tenkitli metin neşri) türünde uluslararası ya da ulusal kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Tahkik (Tenkitli Metin)'], 'puan' => 10],
    'A4.11' => ['baslik' => 'Uluslararası tanınırlığı olan bir yayınevi tarafından yayımlanan kitabın çevirmenliği', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 10],
    'A4.12' => ['baslik' => 'Uluslararası tanınırlığı olan bir yayınevi tarafından yayımlanan kitap bölümünün çevirmenliği', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 5],

    // ══ A5. KISA YAZILAR ══
    'A5.1' => ['baslik' => 'Q1 kategorisindeki dergide yayımlanmış kısa makale, teknik not, vaka takdimi, editöre mektup ya da benzeri yazı', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $KISA, 'puan' => 10],
    'A5.2' => ['baslik' => 'Q2 kategorisindeki dergide yayımlanmış kısa makale, teknik not, vaka takdimi, editöre mektup ya da benzeri yazı', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $KISA, 'puan' => 8],
    'A5.3' => ['baslik' => 'Q3 kategorisindeki dergide yayımlanmış kısa makale, teknik not, vaka takdimi, editöre mektup ya da benzeri yazı', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $KISA, 'puan' => 6],
    'A5.4' => ['baslik' => 'Q4 kategorisindeki ya da AHCI kapsamındaki dergide yayımlanmış kısa makale, teknik not, vaka takdimi, editöre mektup ya da benzeri yazı', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => $KISA, 'puan' => 5],
    'A5.5' => ['baslik' => 'ESCI, SCOPUS ya da SPORTDiscus tarafından taranan dergide yayımlanmış kısa makale, teknik not, vaka takdimi ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $KISA, 'puan' => 4],
    'A5.6' => ['baslik' => 'ULAKBİM TR Dizin dergilerinde yayımlanmış teknik not, vaka takdimi, editöre mektup ya da benzeri yazı', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 3],
    'A5.7' => ['baslik' => 'Diğer uluslararası indekslerdeki dergilerde yayımlanmış kısa yazı', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $KISA, 'puan' => 2],

    // ══ A6. BİLİMSEL TOPLANTI ══
    'A6.1' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan, tam metni ya da özeti CPCI\'da yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 5],
    'A6.2' => ['baslik' => 'Diğer uluslararası ya da ulusal bilimsel toplantıda sunulan, tam metni veya özeti yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Uluslararası Özet/Poster', 'Ulusal Tam Metin', 'Ulusal Özet/Poster', 'Davetli Konuşmacı'], 'puan' => 3],

    // ══ A7. BİLİMSEL ARAŞTIRMA PROJELERİ ══
    'A7.1.1' => ['baslik' => 'Uluslararası kuruluşlarca (NATO, NSF, AB Çerçeve Programı vb.) desteklenen araştırma projesinde koordinatör ya da yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => $PROJE_ULUSLARARASI, 'roller' => ['yurutucu'], 'puan' => 40],
    'A7.1.2' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen araştırma projesinde araştırmacı ya da doktora sonrası araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => $PROJE_ULUSLARARASI, 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 20],
    'A7.1.3' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen araştırma projesinde danışman olmak', 'kategori' => 'proje', 'kaynaklar' => $PROJE_ULUSLARARASI, 'roller' => ['danisman'], 'puan' => 15],
    'A7.2.1' => ['baslik' => 'TÜBİTAK, TÜBA, Bakanlık ya da eş değer kurumlarca desteklenen araştırma projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => $PROJE_KAMU, 'roller' => ['yurutucu'], 'puan' => 30],
    'A7.2.2' => ['baslik' => 'TÜBİTAK, TÜBA, Bakanlık ya da eş değer kurumlarca desteklenen araştırma projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => $PROJE_KAMU, 'roller' => ['arastirmaci'], 'puan' => 20],
    'A7.2.3' => ['baslik' => 'TÜBİTAK, TÜBA, Bakanlık ya da eş değer kurumlarca desteklenen araştırma projesinde danışman olmak', 'kategori' => 'proje', 'kaynaklar' => $PROJE_KAMU, 'roller' => ['danisman'], 'puan' => 12],
    'A7.2.4' => ['baslik' => 'TÜBİTAK, TÜBA, Bakanlık ya da eş değer kurumlarca desteklenen araştırma projesinde bursiyer olmak', 'kategori' => 'proje', 'kaynaklar' => $PROJE_KAMU, 'roller' => ['bursiyer'], 'puan' => 10],
    'A7.2.5' => ['baslik' => 'TÜBİTAK 2209 projelerinde danışmanlık yapmak', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'puan' => 5],
    'A7.3.1' => ['baslik' => 'Üniversitenin BAP birimince desteklenen araştırma projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 10],
    'A7.3.2' => ['baslik' => 'Üniversitenin BAP birimince desteklenen araştırma projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['arastirmaci', 'danisman'], 'puan' => 8],
    'A7.3.3' => ['baslik' => 'Üniversitenin BAP birimince desteklenen araştırma projesinde bursiyer olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['bursiyer'], 'puan' => 6],
    'A7.4.1' => ['baslik' => 'Üniversiteler dışındaki özel kurum ve kuruluşlarca desteklenen araştırma veya uygulama projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 5],
    'A7.4.2' => ['baslik' => 'Üniversiteler dışındaki özel kurum ve kuruluşlarca desteklenen araştırma veya uygulama projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 3],

    // ══ A8. EĞİTİM-ÖĞRETİM FAALİYETLERİ ══
    'A8.1' => ['baslik' => 'Lisansüstü ders vermek (her bir ders için dönemlik)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 2],
    'A8.2' => ['baslik' => 'Ön lisans ya da lisans düzeyinde ders vermek (her bir ders için dönemlik)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Değişim Programı Dersi'], 'puan' => 1],
    'A8.3' => ['baslik' => 'Kısmen yabancı dilde yürütülen programlarda yabancı dilde ders vermek (her bir ders için dönemlik)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Yabancı Dilde Ders'], 'puan' => 3],

    // ══ A9. LİSANSÜSTÜ TEZ DANIŞMANLIĞI ══
    'A9.1' => ['baslik' => 'Tamamlanmış doktora ya da sanatta yeterlik tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 20],
    'A9.3' => ['baslik' => 'Tamamlanmış doktora ya da sanatta yeterlik ikinci tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 10],
    'A9.5' => ['baslik' => 'Tamamlanmış tezli yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 10],
    'A9.6' => ['baslik' => 'Tamamlanmış tezli yüksek lisans ikinci tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 5],

    // ══ A10. TASARIM VE SANAT ETKİNLİKLERİ ══
    'A10.1' => ['baslik' => 'Alanınızda özgün eser, ürün, proje ya da koleksiyonla kişisel tasarım ve sanat etkinliğinde bulunmak (ulusal)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Elektronik Kişisel Sergi (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Resital (Ulusal)', 'Solistlik (Ulusal)'], 'puan' => 13],
    'A10.2' => ['baslik' => 'Alanınızda özgün eser, ürün, proje ya da koleksiyonla kişisel tasarım ve sanat etkinliğinde bulunmak (uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Resital (Uluslararası)', 'Solistlik (Uluslararası)'], 'puan' => 20],
    'A10.3' => ['baslik' => 'Ürettiğiniz bir uygulama projesi hakkında makale, kitap bölümü veya kitap yazılmış olmak ya da proje ve yapım yönetimi, tasarım veya planlama alanlarında yazılım üreticisi olmak', 'kategori' => 'patent', 'kaynaklar' => ['Yazılım'], 'puan' => 20],
    'A10.4' => ['baslik' => 'Özgün proje, tasarım ve sanat eserlerinizin kamu ya da özel kuruluşlarca satın alınması, yayın organlarında yer alması veya uygulanmış olması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Satın Alınması (Yurt İçi)', 'Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Müzeye Kabulü (Yurt İçi)', 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip'], 'puan' => 15],
    'A10.7' => ['baslik' => 'Planlama, tasarım ve sanat alanındaki yarışmalarda derece ya da mansiyon almak', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 8],
    'A10.9' => ['baslik' => 'Tasarım ve sanat etkinliklerinde gösteri, çalıştay, defile ya da organizasyonların düzenleme komitelerinde yer almak (ulusal)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Eğitici Konser Programı (Ulusal)', 'Müzikoloji Atölyesi', 'Masterclass (Ulusal)'], 'puan' => 8],
    'A10.10' => ['baslik' => 'Tasarım ve sanat etkinliklerinde gösteri, çalıştay, defile ya da organizasyonların düzenleme komitelerinde yer almak (uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Eğitici Konser Programı (Uluslararası)', 'Masterclass (Uluslararası)'], 'puan' => 13],
    'A10.13' => ['baslik' => 'Özgün eser, proje ya da tasarımlarınızla karma ve grup sergilerine katılmak (ulusal)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Elektronik Karma Sergi (Ulusal)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Oda Müziği Grup Üyeliği (Ulusal)', 'Orkestra / Koro Üyeliği', 'Corps de Ballet (Ulusal)', 'Opera İkinci Rol (Ulusal)', 'Bale Solist Rol (Ulusal)', 'Grup Şefliği (Ulusal)'], 'puan' => 5],
    'A10.14' => ['baslik' => 'Özgün eser, proje ya da tasarımlarınızla karma ve grup sergilerine katılmak (uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Elektronik Karma Sergi (Uluslararası)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Oda Müziği Grup Üyeliği (Uluslararası)', 'Corps de Ballet (Uluslararası)', 'Opera İkinci Rol (Uluslararası)', 'Bale Solist Rol (Uluslararası)', 'Grup Şefliği (Uluslararası)'], 'puan' => 8],
    'A10.17' => ['baslik' => 'Sanatsal değeri olan beste, solo ya da toplu konserde icracılık veya bandrollü ses-görüntü kaydı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Özgün Eser / Beste / Tasarım', 'Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)', 'Karma Albüm / CD-DVD Katkısı', 'Eğitim Müziği Albümü', 'Opera/Bale Kompozisyonu', 'Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)', 'Elektronik Müzik Eseri (≥15 dk)', 'Elektronik Müzik Eseri (<15 dk)', 'Sahne/Ekran Müziği', 'Orkestrasyon/Transkripsiyon', 'Eğitim Müziği Düzenlemesi', 'Küçük Ölçekli Orkestra Eseri', 'Orkestralı Sahne Eseri'], 'puan' => 5],

    // ══ A11. FİKRİ HAKLAR ══
    'A11.1' => ['baslik' => 'Alanınızda tescillenmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 40],
    'A11.7' => ['baslik' => 'Alanınızda tescillenmiş ulusal patent ya da çeşit tescili', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 18],
    'A11.13' => ['baslik' => 'Alanınızda tescillenmiş faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model'], 'puan' => 10],
    'A11.16' => ['baslik' => 'Alanınızda tescillenmiş tasarım', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım'], 'puan' => 8],

    // ══ A12. GÖRSEL ETKİNLİKLER ══
    'A12.1' => ['baslik' => 'Uluslararası yarışmalara katılan sinema ya da belgesel filminde yönetmenlik, yapımcılık, kurgu veya senaryo yazarlığı yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Belgesel/Kısa Film (Uluslararası)', 'Rejisörlük (Uluslararası)', 'Tüm Perde Koreograflığı (Uluslararası)'], 'puan' => 10],
    'A12.2' => ['baslik' => 'Ulusal yarışmalara katılan sinema ya da belgesel filminde yönetmenlik, yapımcılık, kurgu veya senaryo yazarlığı yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Belgesel/Kısa Film (Ulusal)', 'Yönetmenlik (Sahne/Ekran)', 'Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)', 'Sahne Tasarımı (Dekor, Kostüm, Işık)', 'Koreografi', 'Tüm Perde Koreograflığı (Ulusal)'], 'puan' => 8],

    // ══ B1. ATIFLAR ══ (en fazla 40 puan)
    'B1.1' => ['baslik' => 'SCI, SSCI, AHCI, ESCI, SPORTDiscus ya da Scopus kapsamında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 3],
    'B1.2' => ['baslik' => 'BKCI kapsamındaki kitapta yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 2],
    'B1.3' => ['baslik' => 'TR Dizin kapsamındaki dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
    'B1.4' => ['baslik' => 'Diğer uluslararası ya da ulusal kitap veya dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],

    // ══ B2. TEZ JÜRİ ÜYELİĞİ ══
    'B2.2' => ['baslik' => 'Lisansüstü tez izleme komitesi ya da tez jürisi üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 2],

    // ══ B3. HAKEMLİK VE EDİTÖRLÜK ══
    'B3.1.1' => ['baslik' => 'Q1 kategorisindeki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)'], 'puan' => 20],
    'B3.1.2' => ['baslik' => 'Q2 kategorisindeki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q2)'], 'puan' => 15],
    'B3.1.3' => ['baslik' => 'Q3 kategorisindeki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q3)'], 'puan' => 10],
    'B3.1.4' => ['baslik' => 'Q4 kategorisindeki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q4)'], 'puan' => 5],
    'B3.1.5' => ['baslik' => 'ESCI, SCOPUS ya da SPORTDiscus kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 5],
    'B3.1.6' => ['baslik' => 'TR Dizin ya da diğer hakemli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 4],
    'B3.2' => ['baslik' => 'Dergide editör yardımcılığı ya da yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 2],
    'B3.3' => ['baslik' => 'Dergilerde hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 1],
    'B3.4.2' => ['baslik' => 'Mimarlık, planlama, sanat ve tasarım etkinliklerinde jüri üyeliği (uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)'], 'puan' => 5],
    'B3.4.3' => ['baslik' => 'Mimarlık, planlama, sanat ve tasarım etkinliklerinde jüri üyeliği (ulusal)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 3],

    // ══ B4. ÖDÜLLER ══
    'B4.2' => ['baslik' => 'YÖK, TÜBA ya da TÜBİTAK\'tan alınan bilim veya teşvik ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'YÖK Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 15],
    'B4.3' => ['baslik' => 'Sürekli ve periyodik olarak verilen jürili uluslararası bilim, teknoloji, sanat ya da araştırma ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 20],
    'B4.4' => ['baslik' => 'Sürekli ve periyodik olarak verilen jürili ulusal bilim, teknoloji, sanat ya da araştırma ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 10],
    'B4.5' => ['baslik' => 'TÜBİTAK ya da YÖK tarafından desteklenerek lisansüstü burs almak', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 8],

    // ══ B5. DİĞER AKADEMİK VE İDARİ FAALİYETLER ══
    'B5.1.4' => ['baslik' => 'Kongre, sempozyum, panel ya da çalıştay gibi bilimsel veya sanatsal toplantılarda görev almak', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 2],
    'B5.1.5' => ['baslik' => 'Dekan, müdür ya da merkez müdürü olarak idari görev yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 12],
    'B5.1.6' => ['baslik' => 'Dekan yardımcısı, müdür yardımcısı, bölüm başkanı ya da Rektörlüğe bağlı koordinatör olarak görev yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.', 'Bölüm Başkanı'], 'puan' => 8],
    'B5.1.7' => ['baslik' => 'Bölüm başkan yardımcılığı ya da Rektörlüğe bağlı komisyonlarda üyelik yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı'], 'puan' => 6],
    'B5.2.1' => ['baslik' => 'Koordinatörlük, kurul veya komisyon başkanlığı ya da anabilim dalı başkanlığı yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 5],
    'B5.2.2' => ['baslik' => 'Kurul ya da komisyon üyeliği, birim temsilciliği yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği', 'Senato / Üniversite Yönetim Kurulu Üyesi'], 'puan' => 4],
    'B5.4.1' => ['baslik' => 'Bakanlık, YÖK, TÜBİTAK gibi kamu kurumları ile meslek kuruluşlarının komisyon, danışmanlık, panel ve kurul üyeliklerinde görev almak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı'], 'puan' => 4],

    // Kaynağın B5.4 bölümünün 2. satırı. Akreditasyon kurulu görevi DERS
    // DEĞİL; etiket bir tur B ve C tablolarının ders satırlarında duruyordu.
    'B5.4.2' => ['baslik' => 'Akredite olmuş alt birimin akreditasyon kurulunda görev yapmak (akreditasyon dönemi başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Akreditasyon Faaliyeti'], 'puan' => 3],

    // ══ B6. TOPLUMA HİZMET ÇALIŞMALARI ══
    'B6.1' => ['baslik' => 'Teknopark ve benzeri alanlarda şirket kurmuş olmak', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 15],
    'B6.3' => ['baslik' => 'Bilimsel ya da sanat kurulu üyeliği', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın'], 'puan' => 10],
];

$TABLO_A = ['A1.1', 'A1.2', 'A1.3', 'A1.4', 'A1.5', 'A2.1', 'A2.2', 'A3.1', 'A3.3',
    'A4.1', 'A4.2', 'A4.3', 'A4.4', 'A4.5', 'A4.6', 'A4.7', 'A4.10', 'A4.11', 'A4.12',
    'A5.1', 'A5.2', 'A5.3', 'A5.4', 'A5.5', 'A5.6', 'A5.7', 'A6.1', 'A6.2',
    'A7.1.1', 'A7.1.2', 'A7.1.3', 'A7.2.1', 'A7.2.2', 'A7.2.3', 'A7.2.4', 'A7.2.5',
    'A7.3.1', 'A7.3.2', 'A7.3.3', 'A7.4.1', 'A7.4.2', 'A8.1', 'A8.2', 'A8.3',
    'A9.1', 'A9.3', 'A9.5', 'A9.6', 'A10.1', 'A10.2', 'A10.3', 'A10.4', 'A10.7',
    'A10.9', 'A10.10', 'A10.13', 'A10.14', 'A10.17', 'A11.1', 'A11.7', 'A11.13',
    'A11.16', 'A12.1', 'A12.2'];

$TABLO_B = ['B1.1', 'B1.2', 'B1.3', 'B1.4', 'B2.2', 'B3.1.1', 'B3.1.2', 'B3.1.3',
    'B3.1.4', 'B3.1.5', 'B3.1.6', 'B3.2', 'B3.3', 'B3.4.2', 'B3.4.3', 'B4.2', 'B4.3',
    'B4.4', 'B4.5', 'B5.1.4', 'B5.1.5', 'B5.1.6', 'B5.1.7', 'B5.2.1', 'B5.2.2',
    'B5.4.1', 'B5.4.2', 'B6.1', 'B6.3'];

return [
    'kapsam_notu' => 'Puanlar Yozgat Bozok Üniversitesi Akademik Yükseltilme ve Atanma '
        .'Yönergesinin Ek-1 Puanlama Tablosundan. Yönergenin bütün eşikleri "Tablo-A\'dan en az '
        .'X puan olmak koşuluyla toplamda Y puan" biçiminde; Tablo-A yayın, kitap, bildiri, '
        .'proje, ders, tez danışmanlığı, sanat ve fikri hak kalemlerini, Tablo-B ise atıf, '
        .'jüri üyeliği, editörlük, ödül ve idari görev kalemlerini kapsıyor. Yazar çarpanı Ek-2 '
        .'Genel İlkeler 6. maddesinden ve yalnız A1-A6 kalemlerine uygulanıyor: birinci isim tek '
        .'yazarlıda tam puan, iki yazarlıda %95, üç yazarlıda %85, dört yazarlıda %75, beşten '
        .'fazlada %65; ikinci isim %85\'ten %55\'e, üçüncü isim %65\'ten %45\'e iner. Sorumlu '
        .'yazara %5 ekleniyor. Yazar listesini boş bırakırsanız çarpan hiç uygulanmaz ve '
        .'puanınız olduğundan YÜKSEK görünür. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: Yozgat Bozok bünyesinde yayımlanan '
        .'dergilerdeki makaleler (9, 15 ve 9 puanlık satırlar) sözlükte ayrılamadığı için normal '
        .'dergi puanlarından sayılıyor; üniversitenin ihtisas alanıyla ilgili çalışmalara verilen '
        .'1,5 kat çarpan uygulanmıyor; A7.6 (yurt dışında en az altı ay bulunmak, 30 puan), '
        .'A7.5 (Teknopark projesi, 15), Bozok Akademi ve Sürekli Eğitim Merkezi dersleri, devam '
        .'eden tez danışmanlıkları, millî takım görevleri ve h-indeksi puanı girilmedi. Fikri '
        .'haklarda yalnız TESCİLLİ satırlar var; başvuru ve olumlu araştırma raporu kademeleri '
        .'tescilliden ayrılamadığı için girilmedi. Uluslararası faydalı model ve tasarım tescili '
        .'ulusal karşılıklarının puanıyla sayılıyor. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünür: A8\'in "bir yarıyılda en fazla 5 '
        .'puan" sınırı ve A6\'nın "aynı toplantıda en fazla 2 bildiri" kuralı uygulanmıyor; '
        .'idari görevler yıl başına değil kayıt başına puanlanıyor.',

    // Ek-2 Genel İlkeler 6: ortak çalışmalarda puan çarpanı (yalnız A1-A6).
    'yazar_katsayisi' => [
        'haric' => ['atif', 'proje', 'patent', 'tez_danismanligi', 'egitim_ogretim', 'odul',
            'idari_gorev', 'toplumsal_katki', 'diger', 'editorluk', 'sanatsal_etkinlik'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.00]],
            'ilk' => ['kademeler' => [1 => 1.00, 2 => 0.95, 3 => 0.85, 4 => 0.75], 'sonrasi' => 0.65],
            'baslica' => ['kademeler' => [1 => 1.00, 2 => 1.00, 3 => 0.89, 4 => 0.79], 'sonrasi' => 0.68],
            'yazar_2' => ['kademeler' => [2 => 0.85, 3 => 0.75, 4 => 0.65], 'sonrasi' => 0.55],
            'yazar_3' => ['kademeler' => [3 => 0.65, 4 => 0.55], 'sonrasi' => 0.45],
            'yazar_4' => ['kademeler' => [4 => 0.45], 'sonrasi' => 0.35],
            'yazar_5' => ['sonrasi' => 0.30],
            'yazar_6' => ['sonrasi' => 0.30],
            'ortak' => ['sonrasi' => 0.30],
        ],
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        'TABLO-A' => $TABLO_A,
        'TABLO-B' => $TABLO_B,
        // Koşulların atıf yaptığı dergi kümeleri.
        'A1' => ['A1.1', 'A1.2', 'A1.3', 'A1.4', 'A1.5'],
        'A1.1-A1.2' => ['A1.1', 'A1.2'],
        'A1.3-A1.4' => ['A1.3', 'A1.4'],
        'A1.3-A1.4-A2.1' => ['A1.3', 'A1.4', 'A2.1'],
        'A2.1' => ['A2.1'],
        'A2' => ['A2.1', 'A2.2'],
        'A3.1' => ['A3.1'],
        // "A1.3, A1.4, A2, A3.1 veya A3.2" ve "A2, A3.1 veya A3.2" kümeleri.
        'A1.3-A3' => ['A1.3', 'A1.4', 'A2.1', 'A2.2', 'A3.1', 'A3.3'],
        'A2-A3' => ['A2.1', 'A2.2', 'A3.1', 'A3.3'],
        'A2.1-A2.2-A3.1' => ['A2.1', 'A2.2', 'A3.1'],
        'A2.2-A3' => ['A2.2', 'A3.1', 'A3.3'],
        'A2.1-A3' => ['A2.1', 'A3.1', 'A3.3'],
        // Doçentlik ve yeniden atanmanın kitap seçeneği.
        'A4-KITAP' => ['A4.1', 'A4.2', 'A4.3', 'A4.4'],
        'PROJE' => ['A7.1.1', 'A7.1.2', 'A7.1.3', 'A7.2.1', 'A7.2.2', 'A7.2.3', 'A7.2.4',
            'A7.3.1', 'A7.3.2', 'A7.3.3', 'A7.4.1', 'A7.4.2'],
        // Ön şart olarak sayılan proje kümesi: uluslararası kuruluşlar ile
        // TÜBİTAK, TÜBA, Bakanlık ve eş değer üniversite dışı kurumlar.
        'PROJE-ONSART' => ['A7.1.1', 'A7.1.2', 'A7.1.3', 'A7.2.1', 'A7.2.2', 'A7.2.3', 'A7.2.4'],
        // Tavan grupları.
        'A4.6-BOLUM' => ['A4.6'],
        'ATIF' => ['B1.1', 'B1.2', 'B1.3', 'B1.4'],
        'HAKEMLIK' => ['B3.3'],
    ],

    // A4.6 "en fazla 4 bölüm yazarlığı" (4 × 5); B1 "en fazla 40 puan";
    // B3.3 "yıllık en fazla 10 puan" — yıl başına tavan motorda yok,
    // mutlak 10 olarak yazıldı (§0).
    'grup_tavanlari' => ['A4.6-BOLUM' => 20, 'ATIF' => 40, 'HAKEMLIK' => 10],
];
