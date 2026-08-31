<?php

/**
 * TARSUS ÜNİVERSİTESİ — EK 1 / Tablo 2: Faaliyet Puanlama Tablosu
 * Kaynak: pdf/17537009432.tarsusuniverstesi.pdf
 *         (01.06.2023 tarihli ve 06-2023/30 sayılı Senato kararı)
 *
 * PUANLAR FORMÜLLE VERİLMİŞ. Tablo 2'de doğrudan sayı değil çarpım yazıyor:
 *   k · p · 60   (SCI makale)      k = kişi sayısı katsayısı, p = Q katsayısı
 *   r · 200      (H2020 projesi)   r = projedeki rol katsayısı
 *   8 · ay       (yurt dışı araştırma)
 * k ve p cetvele ayrı ayrı işlendi: p çeyrekliğe göre ayrı maddelere bölündü
 * (Q1-Q2 tam, Q3 %80, Q4 %50), r proje madde puanlarına gömüldü, k ise
 * `yazar_katsayisi` olarak duruyor.
 *
 * K KATSAYISI YALNIZCA KİŞİ SAYISINA BAKIYOR, SIRAYA DEĞİL (Tablo 3):
 * 1 kişi 1 · 2 kişi 0,8 · 3 kişi 0,6 · 4 kişi 0,45 · 5 kişi 0,35 · 6 kişi 0,3 ·
 * 7 ve fazlası 0,20. Korpusta bu kadar net biçimde sıradan bağımsız olan az
 * yönerge var; bütün roller aynı kademeleri kullanıyor.
 *
 * ATIF SATIRLARININ ÇOĞU GİRİLEMEDİ: Tablo 2'nin 13. bölümü atıf başına 3;
 * 1,5; 0,75; 0,40; 0,30; 0,15 puan veriyor. Motor madde puanını tam sayı
 * tuttuğu için yalnızca SCI atfı (3 puan) girildi; birden küçük satırlar
 * aşağı yuvarlanınca sıfırlanacaktı. ATIF PUANINIZ OLDUĞUNDAN DÜŞÜK ÇIKAR.
 *
 * ATIF TAVANI DA UYGULANMIYOR: 13. bölümden alınabilecek puan, 3, 4, 5, 6, 8 ve
 * 9. bölümlerden alınan toplamı geçemiyor. Motor "başka bir grubun toplamına
 * bağlı tavan" tanımlamıyor. Girilen tek atıf satırı zaten düşük olduğu için
 * bu sınırın pratikte bağlayıcı olması beklenmez.
 *
 * GİRİLMEYEN KALEMLER: 2. bölüm (doktora sonrası araştırma — puan araştırma
 * süresine bağlı, süre profilde tutulmuyor), 10. bölüm (tasarım — kaynak
 * sözlüğünde karşılıksız), 15. bölümün yarışma dereceleri.
 */

return [
    'kapsam_notu' => 'Puanlar Tarsus Üniversitesi Tablo 2\'den. Puan KİŞİ SAYISINA göre '
        .'azaltılır (Tablo 3: 2 kişi 0,8 · 4 kişi 0,45 · 7 ve fazlası 0,20); sıranız fark '
        .'etmiyor. SCI makalelerinde çeyreklik katsayısı (Q1-Q2 tam, Q3 %80, Q4 %50) '
        .'uygulanıyor. ATIF PUANINIZ DÜŞÜK ÇIKAR: yönergenin atıf satırlarının çoğu birden '
        .'küçük (0,75 · 0,40 · 0,30 · 0,15) ve motor madde puanını tam sayı tuttuğu için '
        .'yalnızca SCI atfı girilebildi. Doktora sonrası araştırma (süreye bağlı) ve tasarım '
        .'kalemleri girilemedi.',

    // Tablo 3 — k katsayısı; yalnızca kişi sayısına bağlı.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'editorluk', 'odul', 'egitim_ogretim', 'idari_gorev',
            'toplumsal_katki', 'sanatsal_etkinlik'],
        'roller' => (function (): array {
            $kademeler = ['kademeler' => [1 => 1.0, 2 => 0.80, 3 => 0.60, 4 => 0.45,
                5 => 0.35, 6 => 0.30], 'sonrasi' => 0.20];

            return [
                'tek' => ['kademeler' => [1 => 1.0]],
                'ilk' => $kademeler,
                'baslica' => $kademeler,
                'yazar_2' => $kademeler,
                'yazar_3' => $kademeler,
                'yazar_4' => $kademeler,
                'yazar_5' => $kademeler,
                'yazar_6' => $kademeler,
                'ortak' => $kademeler,
            ];
        })(),
    ],

    'maddeler' => [
        // ══ 1. PROJE (r: yürütücü 1 · araştırmacı ve bursiyer 0,5 · danışman 0,2) ══
        '1.a' => ['baslik' => 'H2020 veya ERA-Net projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 200],
        '1.a2' => ['baslik' => 'H2020 veya ERA-Net projesinde araştırmacı ya da bursiyer olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 100],
        '1.a3' => ['baslik' => 'H2020 veya ERA-Net projesinde danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['danisman'], 'puan' => 40],
        '1.b' => ['baslik' => 'TÜBİTAK 1001-1007, COST veya ikili işbirliği projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 100],
        '1.b2' => ['baslik' => 'TÜBİTAK 1001-1007, COST veya ikili işbirliği projesinde araştırmacı ya da bursiyer olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 50],
        '1.b3' => ['baslik' => 'TÜBİTAK 1001-1007, COST veya ikili işbirliği projesinde danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['danisman'], 'puan' => 20],
        '1.c' => ['baslik' => 'Diğer uluslararası kurumca desteklenmiş Ar-Ge projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 50],
        '1.c2' => ['baslik' => 'Diğer uluslararası kurumca desteklenmiş Ar-Ge projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 25],
        '1.d' => ['baslik' => 'Diğer kamu veya özel kurumca desteklenmiş Ar-Ge projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK', 'BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 30],
        '1.d2' => ['baslik' => 'Diğer kamu veya özel kurumca desteklenmiş Ar-Ge projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK', 'BAP (Üniversite)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 15],
        '1.e' => ['baslik' => 'TÜBİTAK 2209-A veya 2209-B projesinde danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'puan' => 10],

        // ══ 3. SCI, SCI-EXPANDED, SSCI VE AHCI MAKALELERİ (p çeyrekliğe göre) ══
        '3.a1' => ['baslik' => 'SCI, SSCI veya AHCI Q1-Q2 dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 60],
        '3.a2' => ['baslik' => 'SCI, SSCI veya AHCI Q3 dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['ozgun_makale'], 'puan' => 48],
        '3.a3' => ['baslik' => 'SCI, SSCI veya AHCI Q4 dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => ['ozgun_makale'], 'puan' => 30],
        '3.b1' => ['baslik' => 'SCI, SSCI veya AHCI Q1-Q2 dergide derleme ya da kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'AHCI'], 'turler' => ['derleme', 'vaka_teknik_not', 'kisa_makale'], 'puan' => 30],
        '3.b2' => ['baslik' => 'SCI, SSCI veya AHCI Q3 dergide derleme ya da kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['derleme', 'vaka_teknik_not', 'kisa_makale'], 'puan' => 24],
        '3.b3' => ['baslik' => 'SCI, SSCI veya AHCI Q4 dergide derleme ya da kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => ['derleme', 'vaka_teknik_not', 'kisa_makale'], 'puan' => 15],

        // ══ 4. ALAN ENDEKSİ VEYA ESCI/SCOPUS MAKALELERİ ══
        '4.a' => ['baslik' => 'ESCI, Scopus veya alan endeksli dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale'], 'puan' => 20],
        '4.b' => ['baslik' => 'ESCI, Scopus veya alan endeksli dergide derleme ya da kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['derleme', 'vaka_teknik_not', 'kisa_makale'], 'puan' => 10],

        // ══ 5. ULAKBİM TR DİZİN MAKALELERİ ══
        '5.a' => ['baslik' => 'ULAKBİM TR Dizin dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale'], 'puan' => 15],
        '5.b' => ['baslik' => 'ULAKBİM TR Dizin dergide derleme ya da kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['derleme', 'vaka_teknik_not', 'kisa_makale'], 'puan' => 8],

        // ══ 6. DİĞER MAKALE ══
        '6.a' => ['baslik' => 'Diğer uluslararası hakemli dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale'], 'puan' => 8],
        '6.b' => ['baslik' => 'Diğer uluslararası hakemli dergide derleme ya da kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['derleme', 'vaka_teknik_not', 'kisa_makale'], 'puan' => 4],
        '6.c' => ['baslik' => 'Diğer ulusal hakemli dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale'], 'puan' => 6],
        '6.d' => ['baslik' => 'Diğer ulusal hakemli dergide derleme ya da kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['derleme', 'vaka_teknik_not', 'kisa_makale'], 'puan' => 3],

        // ══ 7. EDİTÖRLÜK VEYA EDİTÖR KURULU ÜYELİĞİ ══
        '7.a' => ['baslik' => 'SCI, SSCI veya AHCI dergide editörlük ya da editör kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 25],
        '7.b' => ['baslik' => 'ESCI, Scopus veya alan endeksli dergide editörlük ya da editör kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 15],
        '7.c' => ['baslik' => 'ULAKBİM TR Dizin dergide editörlük ya da editör kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 8],
        '7.d' => ['baslik' => 'Diğer hakemli dergide editörlük, yayın kurulu üyeliği ya da hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi', 'Yayın Kurulu Üyeliği', 'Hakemlik', 'Kitap Editörlüğü', 'BKCI Kitap'], 'puan' => 3],

        // ══ 8. KİTAP VE KİTAP BÖLÜMÜ ══
        '8.a' => ['baslik' => 'Tanınmış uluslararası yayınevince yayımlanmış özgün bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 20],
        '8.c' => ['baslik' => 'Tanınmış uluslararası yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 6],
        '8.d' => ['baslik' => 'Tanınmış ulusal yayınevince yayımlanmış özgün bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı'], 'puan' => 10],
        '8.f' => ['baslik' => 'Tanınmış ulusal yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 3],
        '8.g' => ['baslik' => 'Kitap çevirisi (ders notu hariç)', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 5],
        '8.h' => ['baslik' => 'Kitap içinde bölüm çevirisi (ders notu hariç)', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 2],

        // ══ 9. SES VE GÖRÜNTÜ KAYDI ══
        '9.a' => ['baslik' => 'Uluslararası boyutta yayımlanmış kişisel ses veya görüntü kaydı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)', 'Eğitim Müziği Albümü'], 'puan' => 20],
        '9.b' => ['baslik' => 'Karma ses veya görüntü kaydında yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Albüm / CD-DVD Katkısı'], 'puan' => 10],

        // ══ 11. SERGİ VE SANATSAL ETKİNLİK ══
        '11.a' => ['baslik' => 'Özgün yurt dışı bireysel etkinlik (sergi, bienal, dinleti, festival)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Resital (Uluslararası)', 'Şan Resitali (Uluslararası)', 'Solistlik (Uluslararası)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Masterclass (Uluslararası)'], 'puan' => 30],
        '11.b' => ['baslik' => 'Özgün yurt içi bireysel etkinlik (sergi, bienal, dinleti, festival)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Resital (Ulusal)', 'Şan Resitali (Ulusal)', 'Solistlik (Ulusal)', 'Elektronik Kişisel Sergi (Ulusal)', 'Masterclass (Ulusal)'], 'puan' => 15],
        '11.c' => ['baslik' => 'Özgün yurt dışı grup, karma ya da toplu etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Oda Müziği Grup Üyeliği (Uluslararası)', 'Elektronik Karma Sergi (Uluslararası)'], 'puan' => 15],
        '11.d' => ['baslik' => 'Özgün yurt içi grup, karma ya da toplu etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Oda Müziği Grup Üyeliği (Ulusal)', 'Orkestra / Koro Üyeliği', 'Elektronik Karma Sergi (Ulusal)', 'Özgün Eser / Beste / Tasarım'], 'puan' => 8],

        // ══ 12. PATENT ══
        '12.a' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 120],
        '12.b' => ['baslik' => 'Ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 60],
        '12.c' => ['baslik' => 'Faydalı model veya endüstriyel tasarım', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 20],

        // ══ 13. ATIF (yalnızca SCI satırı; diğerleri birden küçük) ══
        '13.a' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergisindeki makalede atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 3],

        // ══ 14. TEBLİĞ (BİLDİRİ) ══
        '14.a' => ['baslik' => 'Uluslararası bilimsel etkinlikte tam metni yayımlanmış sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Uluslararası Tam Metin (CPCI)'], 'puan' => 6],
        '14.b' => ['baslik' => 'Uluslararası bilimsel etkinlikte özeti yayımlanmış bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster', 'Davetli Konuşmacı'], 'puan' => 3],
        '14.c' => ['baslik' => 'Ulusal bilimsel etkinlikte tam metni yayımlanmış sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 3],
        '14.d' => ['baslik' => 'Ulusal bilimsel etkinlikte özeti yayımlanmış bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 2],

        // ══ 15. ÖDÜL ══
        '15.a' => ['baslik' => 'TÜBİTAK Bilim Ödülü veya TÜBA Akademi Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü'], 'puan' => 200],
        '15.b' => ['baslik' => 'YÖK Yılın Doktora Tezi Ödülü, TÜBA GEBİP veya TÜBİTAK-TWAS Teşvik Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 100],
        '15.c' => ['baslik' => 'Yurt dışı kurum veya kuruluştan alınan bilim ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü'], 'puan' => 80],
        '15.d' => ['baslik' => 'Yurt içi kurum veya kuruluştan alınan bilim ödülü ya da yarışma derecesi', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'Yarışma Derecesi / Mansiyon', 'Burs'], 'puan' => 40],

        // ══ 16. TEZ DANIŞMANLIĞI (tamamlanmış tezler) ══
        '16.a' => ['baslik' => 'Tamamlanmış doktora tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 15],
        '16.a2' => ['baslik' => 'Doktora tezinde ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 7],
        '16.b' => ['baslik' => 'Tamamlanmış yüksek lisans tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 5],
        '16.b2' => ['baslik' => 'Yüksek lisans tezinde ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi', 'Tez İzleme / Jüri Üyeliği'], 'roller' => ['es_danisman'], 'puan' => 2],
    ],

    'gruplar' => [
        // Tablo 1'in dipnotlarındaki üç makale kümesi:
        //   a → yalnızca 3. bölüm · b → 3+4 · c → 3+4+5
        'MAKALE_a' => ['3.*'],
        'MAKALE_b' => ['3.*', '4.*'],
        'MAKALE_c' => ['3.*', '4.*', '5.*'],
    ],

    // 13. bölümün tavanı "3, 4, 5, 6, 8 ve 9. bölümlerden alınan toplam" —
    // başka bir grubun toplamına bağlı tavan motorda tanımlanamıyor.
    'grup_tavanlari' => [],
];
