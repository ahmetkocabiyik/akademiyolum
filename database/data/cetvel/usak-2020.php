<?php

/**
 * UŞAK ÜNİVERSİTESİ — Ek-1 Puanlama Tablosu
 * Kaynak: pdf/1780987731728.usak-kriter-09062026.pdf (12 sayfa; Senato
 * 16.06.2020-2020/13-05, Ek-1 tablosu 13.04.2022-2022/07-14 kararıyla
 * değişik; ayrıca 29.09.2021-2021/16-04 ve 04.03.2026-2026/06-11
 * değişiklikleri.)
 *
 * Madde kodları Ek-1'in kendi bölüm-bent düzeni (1a, 3ç, 8c, 15g …).
 * Yalnız tez danışmanlığındaki eş danışman ayrımı (`-es`), projedeki rol
 * ayrımı (`-yur`, `-ars`) ve kitap editörlüğünün ayrı satıra alınması
 * (`-ed`) bize ait.
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞEN SATIRLARDA DÜŞÜK OLAN GİRİLDİ (§0) ──
 *   1b (SCOPUS makalesi, 13) ile 1c (ESCI makalesi, 10) → tek
 *       'ESCI / Scopus' etiketi; 10 girildi ve 1b satırı açılmadı.
 *       Koşulların (b) bendine yaptığı atıflar bu yüzden (c) bendiyle
 *       karşılanıyor.
 *   4b (tezden üretilmiş SCOPUS makalesi, 8) ile 4c (ESCI, 6) → 6.
 *   8a-8b (TÜBİTAK 1001 yürütücü 20 / araştırmacı 15) ile 8c-8ç (diğer
 *       TÜBİTAK projeleri 10 / 8) → sözlük TÜBİTAK program türünü
 *       ayırmadığı için 10 ve 8 girildi.
 *   14a-14b (düzenleme kurulu başkanlığı 10 / 7) ile 14d-14e (görev
 *       almak 5 / 3) → tek 'Diğer' etiketi; 3 girildi.
 *   14c-14ç (davetli konuşmacı 10 / 5) → 5; 14ğ-14h (yarışma jürisi
 *       10 / 7) → 7; 14ı-14i (burs 10 / 5) → 5.
 *   15. bölümde 'Kurul / Komisyon Üyeliği' etiketi
 *       tabloda sayılmadığı için en düşük idari görev satırıyla (2)
 *       eşleştirildi.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   1d (kitap kritiği yapılmış makale, 5) — sözlükte karşılıksız.
 *   11. bölüm (yurt dışı araştırma çalışmaları, 10-20 puan) — faaliyet
 *       değil süre ölçütü; motorun `yurtdisi_ay` metriği var ama puana
 *       çevrilemiyor. Bu bölümün tavanı 20 puandı.
 *   15c ve 15d (koordinatörlükler, kalite üyelikleri) — sözlükte ayrı
 *       karşılığı yok, komisyon satırından sayılıyor.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   6. bölümün "20 puanın en az 10'u 6a bendinden olmalı" kuralı taban
 *       koşulu; motorda yalnız tavan var, tavan 20 olarak yazıldı.
 *   9. bölümün "aynı toplantıda sunulan en fazla bir bildiri
 *       puanlanır" kuralı.
 *   10. bölümün "yurtiçi veya yurtdışı yükseköğretim kurumlarında en az
 *       2 yıl öğretim elemanı olarak görev yapanlar 2 puan almış
 *       sayılır" kuralı.
 *   15. bölümün "son üç yılda yürütülmüş" ve "en az 1 yıl" koşulları
 *       ile "bu bölümden alınan puan doçentlik kriterini sağlamada
 *       kullanılmaz" kuralı.
 *
 * Yönerge: yonerge/usak.php
 *
 * 06.09.2026: bilimsel toplantı organizasyonu ailesi için altı etiket
 * açıldı (başkanlık · düzenleme/bilim kurulu üyeliği · oturum başkanlığı,
 * her biri uluslararası/ulusal). Yukarıdaki "sözlükte karşılıksız" notları
 * bu satırlar için artık geçerli değil.
 */
$SCI = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];
$TAM = ['ozgun_makale', 'derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];

$SANAT_KISISEL_ULUSLARARASI = ['Kişisel Etkinlik (Uluslararası)', 'Elektronik Kişisel Sergi (Uluslararası)',
    'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)',
    'Resital (Uluslararası)', 'Solistlik (Uluslararası)', 'Şan Resitali (Uluslararası)',
    'Opera Birinci Rol (Uluslararası)', 'Bale Başrol (Uluslararası)',
    'Dansçı / Performans İcracısı (Uluslararası)', 'Rejisörlük (Uluslararası)',
    'Orkestra Şefliği (Uluslararası)', 'Koro Şefliği (Uluslararası)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)'];
$SANAT_KISISEL_ULUSAL = ['Kişisel Etkinlik (Ulusal)', 'Elektronik Kişisel Sergi (Ulusal)',
    'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)',
    'Resital (Ulusal)', 'Solistlik (Ulusal)', 'Şan Resitali (Ulusal)', 'Opera Birinci Rol (Ulusal)',
    'Bale Başrol (Ulusal)', 'Dansçı / Performans İcracısı (Ulusal)', 'Rejisörlük (Ulusal)',
    'Rejisörlük (Konservatuvar)', 'Orkestra Şefliği (Ulusal)', 'Koro Şefliği (Ulusal)',
    'Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Özgün Eser / Beste / Tasarım', 'Koreografi'];
$SANAT_KARMA_ULUSLARARASI = ['Karma/Jürili Etkinlik (Uluslararası)', 'Elektronik Karma Sergi (Uluslararası)',
    'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)',
    'Oda Müziği Grup Üyeliği (Uluslararası)', 'Corps de Ballet (Uluslararası)',
    'Opera İkinci Rol (Uluslararası)', 'Bale Solist Rol (Uluslararası)', 'Grup Şefliği (Uluslararası)'];
$SANAT_KARMA_ULUSAL = ['Karma/Jürili Etkinlik (Ulusal)', 'Elektronik Karma Sergi (Ulusal)',
    'Karma Etkinlik (Jürisiz, Ulusal)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)',
    'Oda Müziği Grup Üyeliği (Ulusal)', 'Corps de Ballet (Ulusal)', 'Opera İkinci Rol (Ulusal)',
    'Bale Solist Rol (Ulusal)', 'Grup Şefliği (Ulusal)', 'Orkestra / Koro Üyeliği',
    'Karma Albüm / CD-DVD Katkısı', 'Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)',
    'Eğitici Konser Programı (Uluslararası)', 'Eğitici Konser Programı (Ulusal)'];

return [
    'kapsam_notu' => 'Puanlar Uşak Üniversitesi Öğretim Üyeliğine Yükseltilme ve Atanma '
        .'Yönergesinin Ek-1 Puanlama Tablosundan (Senato 16.06.2020; tablo 13.04.2022 kararıyla '
        .'değişik). Yazar çarpanı tablonun altındaki puanlama notundan: tek yazarlıda tam puan; '
        .'başlıca yazarın belirtildiği iki yazarlı eserlerde başlıca yazar %80, ikinci yazar '
        .'%50; üç ve daha fazla yazarlıda başlıca yazar puanın yarısını alır, diğerleri kalan '
        .'yarıyı eşit paylaşır. Yazar listesini boş bırakırsanız çarpan hiç uygulanmaz ve '
        .'puanınız olduğundan YÜKSEK görünür. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: yurt dışı araştırma çalışmaları '
        .'bölümü (en fazla 20 puan) faaliyet değil süre ölçütü olduğu için hiç sayılmıyor; '
        .'SCOPUS makaleleri ESCI puanıyla (13 yerine 10), TÜBİTAK 1001 projeleri diğer TÜBİTAK '
        .'projelerinin puanıyla (20 yerine 10), uluslararası düzenleme kurulu başkanlığı ulusal '
        .'görev puanıyla (10 yerine 3), uluslararası davetli konuşmacılık ulusal puanıyla (10 '
        .'yerine 5), uluslararası yarışma jüriliği ulusal puanıyla (10 yerine 7) ve uluslararası '
        .'burs ulusal burs puanıyla (10 yerine 5) sayılıyor. Rolü girilmemiş TÜBİTAK projeleri '
        .'0 puan alır. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünür: atıf bölümünün "20 puanın en az '
        .'10\'u SCI kapsamındaki yayınlardan olmalı" kuralı, bilimsel toplantı bölümünün "aynı '
        .'toplantıda en fazla bir bildiri" kuralı ve idari görevlerin "son üç yıl" ile "en az '
        .'bir yıl" koşulları uygulanmıyor. İdari görev puanının doçentlik kriterinde '
        .'kullanılamaması kuralı da işletilmiyor.',

    // Ek-1 puanlama notu: ortak çalışmalarda puan dağılımı.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'proje', 'patent', 'tez_danismanligi', 'egitim_ogretim', 'odul',
            'idari_gorev', 'toplumsal_katki', 'diger', 'editorluk', 'sanatsal_etkinlik'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.00]],
            'ilk' => ['kademeler' => [1 => 1.00, 2 => 0.80], 'sonrasi' => 0.50],
            'baslica' => ['kademeler' => [1 => 1.00, 2 => 0.80], 'sonrasi' => 0.50],
            'yazar_2' => ['kademeler' => [2 => 0.50], 'bol' => ['pay' => 0.5, 'eksi' => 1]],
            'yazar_3' => ['bol' => ['pay' => 0.5, 'eksi' => 1]],
            'yazar_4' => ['bol' => ['pay' => 0.5, 'eksi' => 1]],
            'yazar_5' => ['bol' => ['pay' => 0.5, 'eksi' => 1]],
            'yazar_6' => ['bol' => ['pay' => 0.5, 'eksi' => 1]],
            'ortak' => ['bol' => ['pay' => 0.5, 'eksi' => 1]],
        ],
    ],

    'maddeler' => [
        // ══ 1. ULUSLARARASI MAKALE ══
        '1a' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergide yayımlanmış araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => $SCI, 'turler' => $TAM, 'puan' => 20],
        '1c' => ['baslik' => 'ESCI ya da SCOPUS kapsamındaki dergide yayımlanmış araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $TAM, 'puan' => 10],
        '1ç' => ['baslik' => 'Diğer uluslararası hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $TAM, 'puan' => 5],
        '1e' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergide yayımlanan olgu sunumu', 'kategori' => 'makale', 'kaynaklar' => [...$SCI, 'ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => $KISA, 'puan' => 5],

        // ══ 2. ULUSAL MAKALE ══
        '2a' => ['baslik' => 'ULAKBİM TR Dizin tarafından taranan ulusal hakemli dergide yayımlanmış araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $TAM, 'puan' => 5],
        '2b' => ['baslik' => 'Diğer ulusal hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => [...$TAM, ...$KISA], 'puan' => 4],

        // ══ 3. KİTAP ══
        '3a' => ['baslik' => 'Tanınmış uluslararası yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 15],
        '3b' => ['baslik' => 'Tanınmış uluslararası yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 10],
        '3b-ed' => ['baslik' => 'Tanınmış uluslararası yayınevi tarafından yayımlanmış kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 10],
        '3c' => ['baslik' => 'Tanınmış ulusal yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Ders / Metot Kitabı', 'Çeviri Kitap'], 'puan' => 10],
        '3ç' => ['baslik' => 'Tanınmış ulusal yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi', 'Çeviri Kitap Bölümü'], 'puan' => 5],
        '3ç-ed' => ['baslik' => 'Tanınmış ulusal yayınevi tarafından yayımlanmış kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 5],

        // ══ 4. LİSANSÜSTÜ TEZLERDEN ÜRETİLMİŞ YAYIN ══ (en fazla 10 puan)
        '4a' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 10],
        '4c' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, ESCI ya da SCOPUS kapsamındaki dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 6],
        '4ç' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, diğer uluslararası hakemli dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Diğer (Uluslararası)'], 'puan' => 5],
        '4d' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, TR Dizin kapsamındaki dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['TR Dizin'], 'puan' => 4],
        '4e' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, tanınmış uluslararası yayınevi tarafından yayımlanmış kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 10],
        '4f' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, tanınmış uluslararası yayınevi kitabında bölüm yazarlığı', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 5],
        '4g' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, tanınmış ulusal yayınevi tarafından yayımlanmış kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 5],
        '4ğ' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, tanınmış ulusal yayınevi kitabında bölüm yazarlığı', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 4],
        '4h' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, bilimsel toplantıda sunulmuş ve tam metni basılmış sözlü bildiri', 'kategori' => 'tez_yayini', 'kaynaklar' => ['CPCI Bildiri'], 'puan' => 2],

        // ══ 5. PATENT ══
        '5a' => ['baslik' => 'Uluslararası patent, tasarım tescili, faydalı model ya da telif hakkı', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 20],
        '5b' => ['baslik' => 'Ulusal patent, tasarım tescili, faydalı model ya da telif hakkı', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Faydalı Model', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili', 'Yazılım', 'Ticarileştirme'], 'puan' => 10],

        // ══ 6. ATIFLAR ══ (en fazla 20 puan)
        '6a' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergilerde ve tanınmış uluslararası yayınevi kitaplarında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 3],
        '6b' => ['baslik' => 'Diğer endekslerce taranan dergilerde ve uluslararası kitap bölümlerinde yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Patent'], 'puan' => 2],
        '6c' => ['baslik' => 'Ulusal hakemli dergilerde ve tanınmış ulusal yayınevi kitaplarında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer'], 'puan' => 1],

        // ══ 7. LİSANSÜSTÜ TEZ DANIŞMANLIĞI ══ (en fazla 10 puan)
        '7a' => ['baslik' => 'Danışmanlığınızda tamamlanan doktora ya da uzmanlık tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 4],
        '7a-es' => ['baslik' => 'Eş danışmanlığınızda tamamlanan doktora ya da uzmanlık tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 2],
        '7b' => ['baslik' => 'Danışmanlığınızda tamamlanan yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 2],
        '7b-es' => ['baslik' => 'Eş danışmanlığınızda tamamlanan yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 1],

        // ══ 8. BİLİMSEL ARAŞTIRMA PROJESİ ══ (en fazla 20 puan)
        '8c' => ['baslik' => 'TÜBİTAK tarafından desteklenen araştırma projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 10],
        '8ç' => ['baslik' => 'TÜBİTAK tarafından desteklenen araştırma projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 8],
        '8d' => ['baslik' => 'Üniversiteler ve TÜBİTAK dışındaki kamu kurumları ya da uluslararası kuruluşlarla yapılan bilimsel araştırma projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'puan' => 4],
        '8e' => ['baslik' => 'Üniversite bünyesindeki bilimsel araştırma birimi kaynaklı projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'puan' => 2],

        // ══ 9. BİLİMSEL TOPLANTI FAALİYETİ ══ (en fazla 10 puan)
        '9a' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan, tam metni ya da özeti bildiri kitapçığında yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin', 'Uluslararası Özet/Poster'], 'puan' => 4],
        '9b' => ['baslik' => 'Ulusal bilimsel toplantıda sunulan, tam metni ya da özeti bildiri kitapçığında yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin', 'Ulusal Özet/Poster'], 'puan' => 2],

        // ══ 10. EĞİTİM-ÖĞRETİM FAALİYETİ ══ (en fazla 10 puan)
        '10a' => ['baslik' => 'Bir dönem yüksek lisans ya da doktora dersi vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
        '10b' => ['baslik' => 'Erasmus, Farabi ya da Mevlana programlarına en az bir hafta katılmak', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Değişim Programı Dersi'], 'puan' => 1],
        '10c' => ['baslik' => 'Bir dönem ön lisans ya da lisans dersi vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders'], 'puan' => 2],

        // ══ 12. ÖDÜLLER ══ (en fazla 30 puan)
        '12a' => ['baslik' => 'TÜBA ya da TÜBİTAK ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 30],
        '12b' => ['baslik' => 'Alanınızda uluslararası jürili bir yarışmada ilk üç dereceye giren araştırma, proje, tasarım ya da sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 15],
        '12c' => ['baslik' => 'Alanınızda ulusal jürili bir yarışmada ilk üç dereceye giren araştırma, proje, tasarım ya da sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'YÖK Ödülü', 'Yarışma Derecesi / Mansiyon'], 'puan' => 7],

        // ══ 13. SANAT VE TASARIM ETKİNLİKLERİ ══ (en fazla 40 puan)
        '13a' => ['baslik' => 'Özgün sanat eserlerinizin yurt dışında sanat, eğitim ve kültür kurumlarınca satın alınması ya da yayın araçlarında gösterime girmesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Eserin Müzeye Kabulü (Yurt Dışı)'], 'puan' => 30],
        '13b' => ['baslik' => 'Özgün sanat eserlerinizle uluslararası jürili karma sanat etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $SANAT_KARMA_ULUSLARARASI, 'puan' => 15],
        '13c' => ['baslik' => 'Özgün sanat eserlerinizle yurt dışında kişisel sanat etkinliğinde bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $SANAT_KISISEL_ULUSLARARASI, 'puan' => 10],
        '13ç' => ['baslik' => 'Özgün sanat eserlerinizle yurt içinde kişisel sanat etkinliğinde bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $SANAT_KISISEL_ULUSAL, 'puan' => 5],
        '13d' => ['baslik' => 'Özgün sanat eserlerinizin yurt içinde sanat, eğitim ve kültür kurumlarınca satın alınması ya da yayın araçlarında gösterime girmesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Satın Alınması (Yurt İçi)', 'Eserin Müzeye Kabulü (Yurt İçi)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip'], 'puan' => 10],
        '13e' => ['baslik' => 'Özgün sanat eserlerinizle ulusal jürili karma sanat etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $SANAT_KARMA_ULUSAL, 'puan' => 5],

        // ══ 14. DİĞER AKADEMİK VE BİLİMSEL ETKİNLİKLER ══ (en fazla 10 puan)
        '14e' => ['baslik' => 'Bilimsel ya da sanatsal toplantı, sportif faaliyet ve etkinliklerde düzenleme kurulunda görev almak', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 3],
        '14ç' => ['baslik' => 'Bilimsel ya da sanatsal toplantılarda davetli konuşmacı veya davetli sanatçı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 5],
        '14h' => ['baslik' => 'Sanat ve tasarım yarışma jürilerinde görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 7],
        '14i' => ['baslik' => 'Alanınızla ilgili bilimsel, sanatsal ve tasarıma yönelik araştırmalar için burs almak', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 5],
        '14j' => ['baslik' => 'Kamu kurumlarına ya da topluma yönelik bilimsel danışmanlık, bilim iletişimi ve toplumsal katkı faaliyetleri', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın', 'Kamu/STK Danışmanlığı'], 'puan' => 3],

        // ══ 15. İDARİ GÖREVLER ══ (en fazla 20 puan)
        '15a' => ['baslik' => 'Rektör yardımcısı, dekan, enstitü, yüksekokul ya da meslek yüksekokulu müdürü veya başhekim olarak görev yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü'], 'puan' => 20],
        '15b' => ['baslik' => 'Dekan yardımcısı, müdür yardımcısı ya da başhekim yardımcısı olarak görev yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.'], 'puan' => 15],
        '15ç' => ['baslik' => 'Bölüm başkanlığı ya da uygulama ve araştırma merkezi müdürlüğü yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 8],
        '15e' => ['baslik' => 'Bölüm başkan yardımcılığı, anabilim dalı başkanlığı ya da koordinatörlük yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı', 'Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 6],
        '15g' => ['baslik' => 'Kurul ya da komisyon üyeliği yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 2],
        '15f2' => ['baslik' => 'Bilimsel toplantıda oturum başkanlığı (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Uluslararası)'], 'puan' => 2],
        '15g2' => ['baslik' => 'Bilimsel toplantıda oturum başkanlığı (ulusal)', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Ulusal)'], 'puan' => 1],
    ],

    'gruplar' => [
        // Koşulların atıf yaptığı makale bentleri.
        'ULUS-A' => ['1a'],
        'ULUS-ABC' => ['1a', '1c'],
        'ULUS-HEPSI' => ['1a', '1c', '1ç'],
        'ULUSAL-A' => ['2a'],
        'ULUSAL-AB' => ['2a', '2b'],
        'ULUS-HEPSI-ULUSAL-A' => ['1a', '1c', '1ç', '2a'],
        'ULUS-HEPSI-ULUSAL-AB' => ['1a', '1c', '1ç', '2a', '2b'],
        'ULUSLARARASI-MAKALE' => ['1a', '1c', '1ç', '1e'],
        // MADDE 7(2)'nin "yayın" kümesi: 1, 2, 3 ve 4. bölümler.
        'YAYIN' => ['1a', '1c', '1ç', '1e', '2a', '2b', '3a', '3b', '3b-ed', '3c', '3ç', '3ç-ed',
            '4a', '4c', '4ç', '4d', '4e', '4f', '4g', '4ğ', '4h'],
        'TEZ-YAYINI' => ['4a', '4c', '4ç', '4d', '4e', '4f', '4g', '4ğ', '4h'],
        'ATIF' => ['6a', '6b', '6c'],
        'TEZ-DANISMANLIK' => ['7a', '7a-es', '7b', '7b-es'],
        'PROJE' => ['8c', '8ç', '8d', '8e'],
        'BILDIRI' => ['9a', '9b', '14ç'],
        'BILDIRI-ULUSLARARASI' => ['9a'],
        'EGITIM' => ['10a', '10b', '10c'],
        'ODUL' => ['12a', '12b', '12c', '14i'],
        'SANAT' => ['13a', '13b', '13c', '13ç', '13d', '13e'],
        'SANAT-KISISEL' => ['13c', '13ç'],
        'SANAT-KARMA' => ['13b', '13e'],
        'DIGER' => ['14e', '14h', '14j'],
        'IDARI' => ['15a', '15b', '15ç', '15e', '15g'],
    ],

    'grup_tavanlari' => ['TEZ-YAYINI' => 10, 'ATIF' => 20, 'TEZ-DANISMANLIK' => 10, 'PROJE' => 20,
        'BILDIRI' => 10, 'EGITIM' => 10, 'ODUL' => 30, 'SANAT' => 40, 'DIGER' => 10, 'IDARI' => 20],
];
