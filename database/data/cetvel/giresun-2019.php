<?php

/**
 * GİRESUN ÜNİVERSİTESİ — EK-1: Bilimsel Araştırma ve Yayın Faaliyetleri
 * Kaynak: pdf/17536995062.giresununiverstesi.pdf (2019 yönergesi, 2025 değişikliğiyle)
 *
 * TEK ORTAK PUAN TABLOSU, TEMEL ALAN AYRIMI YOK. Koşullar tabloya BÖLÜM HARFİYLE
 * atıf yapıyor ("A, B, C, D, E, F, G, H ve K bölümlerinden"), bu yüzden harf
 * kodları birebir korundu.
 *
 * ÜÇ KADRONUN ALT BARAJ KÜMESİ FARKLI — kolayca gözden kaçacak bir ayrım:
 *   Profesör  A B C D E F G H K      (editörlük I ve J YOK)
 *   Doçent    A B C D E F G H I K    (uluslararası editörlük I VAR, ulusal J yok)
 *   Dr.       A B C D E F G H I K
 * Yani profesörlükte uluslararası dergi editörlüğü alt baraja SAYILMIYOR,
 * doçentlikte sayılıyor.
 *
 * PROJE PUANLARI KORPUSUN EN YÜKSEKLERİ: AB Çerçeve projesi yürütücülüğü 200
 * puan, yurt dışı patent 400 puan. Buna karşılık eşikler düşük (profesörlük
 * 350). Tek bir AB projesi profesörlük barajının yarısından fazlasını
 * karşılıyor.
 *
 * YAZAR ÇARPANI YOK: yönerge çok yazarlı çalışmalar için oran tablosu
 * içermiyor; puanlar yazar sayısından bağımsız veriliyor.
 *
 * KENDİNE ATIF AYRI PUANLANIYOR (G ve H bölümleri "a) kendine atıf hariç",
 * "b) kendine atıf" satırlarını ayrı ayrı puanlıyor). Faaliyet kaydı atfın
 * kendine mi başkasına mı ait olduğunu tutmadığı için yalnızca DÜŞÜK olan
 * "kendine atıf" satırları değil, YÜKSEK olan "kendine atıf hariç" satırları
 * girildi — çünkü kaydın olağan anlamı dışarıdan gelen atıftır. Kendine
 * atıflarınızı da girdiyseniz puanınız olduğundan yüksek çıkar.
 *
 * AYNI KAYNAĞA DÜŞEN KALEMLERDE DÜŞÜK OLAN GİRİLDİ:
 *   'Yayın Kurulu Üyeliği' ve 'Hakemlik' dergi düzeyi taşımıyor → J.2'nin
 *       satırları (4 ve 2).
 *   'Kitap Editörlüğü' uluslararası/ulusal ayırmıyor → I.1 (60) yerine J.3 (20).
 *
 * GİRİLMEYEN BÖLÜMLER: L.1 (ders başına 0,5 puan — motor kesirli puan
 * tutmuyor), M'nin M.18 ve M.19 DIŞINDAKİ maddeleri (ödüller, idari görevler
 * ve diğer hizmetler; M.18 ile M.19 YÖK Genel Kurulunun 30.01.2025 kararıyla
 * eklendi ve sözlükte karşılıkları olduğu için girildi), O (görsel
 * etkinlikler), P (sanatsal etkinlikler) ve R (sanatsal ödüller). M, O, P ve R
 * koşulların alt baraj kümesine girmiyor; yalnızca genel toplamı etkiliyorlar,
 * dolayısıyla GÜZEL SANATLAR ADAYLARININ TOPLAMI OLDUĞUNDAN DÜŞÜK çıkar.
 */

return [
    'kapsam_notu' => 'Puanlar Giresun Üniversitesi EK-1 tablosundan. Giresun çok yazarlı '
        .'çalışmalar için oran tablosu içermiyor; puan yazar sayısından bağımsız veriliyor. '
        .'Atıf kalemlerinde "kendine atıf hariç" satırları girildi — kendi yayınlarınıza '
        .'yaptığınız atıfları da kaydettiyseniz puanınız olduğundan yüksek çıkar. Ödüller ve '
        .'idari görevler (M), görsel etkinlikler (O), sanatsal etkinlikler (P) ve sanatsal '
        .'ödüller (R) bölümleri girilmedi; bunlar alt barajlara girmiyor ama genel toplamı '
        .'etkiliyor, Güzel Sanatlar adaylarında toplam düşük çıkar.',

    'maddeler' => [
        // ══ A — ULUSLARARASI YAYINLAR ══
        'A.1.a' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 50],
        'A.1.b' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergide derleme, vaka raporu veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['derleme', 'vaka_teknik_not', 'kisa_makale'], 'puan' => 20],
        'A.2.a' => ['baslik' => 'Diğer uluslararası dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale'], 'puan' => 30],
        'A.2.b' => ['baslik' => 'Diğer uluslararası dergide derleme, vaka raporu veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['derleme', 'vaka_teknik_not', 'kisa_makale'], 'puan' => 15],

        // ══ B — ULUSLARARASI BİLDİRİLER ══
        'B.1.a' => ['baslik' => 'Uluslararası kongrede SCI kapsamlı yayında tam metni yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 20],
        'B.2.a' => ['baslik' => 'Uluslararası kongrede tam metni yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin'], 'puan' => 12],
        'B.2.c' => ['baslik' => 'Uluslararası kongrede özeti yayımlanmış sözlü bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 6],

        // ══ C — ULUSLARARASI KİTAP VE KİTAP BÖLÜMÜ ══
        'C.1' => ['baslik' => 'Uluslararası kitap yazarlığı (yurt dışında yayımlanmış, ISBN\'li)', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 120],
        'C.2' => ['baslik' => 'Uluslararası kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 40],

        // ══ D — ULUSAL MAKALELER ══
        'D.1.a' => ['baslik' => 'TÜBİTAK-ULAKBİM taranan yurt içi hakemli dergide özgün veya derleme makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 24],
        'D.1.b' => ['baslik' => 'TR Dizin dergide kitap tanıtımı, editöre mektup veya vaka raporu', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 12],
        'D.2.a' => ['baslik' => 'Diğer yurt içi hakemli dergide özgün veya derleme makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 12],
        'D.2.b' => ['baslik' => 'Diğer yurt içi dergide kitap tanıtımı, editöre mektup veya vaka raporu', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 6],

        // ══ E — ULUSAL BİLDİRİLER ══
        'E.2.a' => ['baslik' => 'Ulusal kongre kitabında tam metni yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 10],
        'E.2.c' => ['baslik' => 'Ulusal kongrede özeti yayımlanmış sözlü bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 5],
        'E.3' => ['baslik' => 'Panel, konferans veya açılış dersinde davetli sunum yapmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 2],

        // ══ F — TÜRKÇE KİTAP VE BÖLÜM YAZARLIĞI ══
        'F.1' => ['baslik' => 'Türkçe kitap yazarlığı (ulusal yayınevi, ISBN\'li)', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı'], 'puan' => 60],
        'F.2' => ['baslik' => 'Türkçe kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 20],
        'F.3.b' => ['baslik' => 'Ulusal ansiklopedide madde yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 5],
        'F.4.a' => ['baslik' => 'Kitap çevirisi (ISBN\'li bilimsel kitap veya nadir eser)', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 30],
        'F.4.b' => ['baslik' => 'Kitap bölümü veya makale çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 10],

        // ══ G — ULUSLARARASI ATIFLAR (kendine atıf hariç satırları) ══
        'G.1.a' => ['baslik' => 'Yurt dışında yayımlanan kitap, monografi veya tezde atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 8],
        'G.2.a' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergisinde atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 8],

        // ══ H — ULUSAL ATIFLAR ══
        'H.1.a' => ['baslik' => 'TÜBİTAK-ULAKBİM taranan dergide atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 4],
        'H.2.a' => ['baslik' => 'Diğer hakemli dergide atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer'], 'puan' => 2],
        // H.3 (yurt içi kitap, monografi ve tezlerdeki atıf, 4 puan) girilmedi:
        // kaynak sözlüğü kitap atfını yurt içi/dışı diye ayırmıyor, tek karşılık
        // olan 'BKCI Kitap' zaten G.1.a'ya (8 puan) bağlı.

        // ══ I — ULUSLARARASI DERGİLERDE HAKEMLİK VE EDİTÖRLÜK ══
        'I.2.a' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 50],
        'I.3.a' => ['baslik' => 'Diğer uluslararası dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 30],

        // ══ J — ULUSAL DERGİLERDE HAKEMLİK VE EDİTÖRLÜK ══
        'J.1.a' => ['baslik' => 'TÜBİTAK-ULAKBİM taranan dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 20],
        'J.2.a' => ['baslik' => 'Diğer ulusal dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 10],
        'J.2.b' => ['baslik' => 'Dergide yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 4],
        'J.2.c' => ['baslik' => 'Dergi hakemliği (her dergi için en fazla 5 hakemlik)', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 2],
        'J.3' => ['baslik' => 'Kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü', 'BKCI Kitap'], 'puan' => 20],

        // ══ K — BİLİMSEL ARAŞTIRMA PROJELERİ ══
        'K.1.a' => ['baslik' => 'AB Çerçeve Programı destekli projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 200],
        'K.1.b' => ['baslik' => 'AB Çerçeve Programı destekli projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 100],
        'K.1.c' => ['baslik' => 'AB Çerçeve Programı destekli projede danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['danisman'], 'puan' => 50],
        'K.2.a' => ['baslik' => 'Diğer uluslararası projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 80],
        'K.2.b' => ['baslik' => 'Diğer uluslararası projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 40],
        'K.2.c' => ['baslik' => 'Diğer uluslararası projede danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['danisman'], 'puan' => 20],
        'K.3.a' => ['baslik' => 'TÜBİTAK, TÜBA veya bakanlık destekli projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 50],
        'K.3.b' => ['baslik' => 'TÜBİTAK, TÜBA veya bakanlık destekli projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 25],
        'K.3.c' => ['baslik' => 'TÜBİTAK, TÜBA veya bakanlık destekli projede danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['danisman'], 'puan' => 10],
        'K.4.a' => ['baslik' => 'BAP veya diğer kuruluşlarca desteklenen projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Özel Sektör / STK', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 20],
        'K.4.b' => ['baslik' => 'BAP veya diğer kuruluşlarca desteklenen projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Özel Sektör / STK', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 10],
        'K.4.c' => ['baslik' => 'BAP veya diğer kuruluşlarca desteklenen projede danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Özel Sektör / STK'], 'roller' => ['danisman'], 'puan' => 5],
        'K.6' => ['baslik' => 'Teknoparkta veya sanayi Ar-Ge biriminde en az üç ay danışmanlık', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı', 'Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın'], 'puan' => 15],

        // ══ L — EĞİTİM-ÖĞRETİM FAALİYETLERİ (bölüm tavanı 25) ══
        'L.2.a' => ['baslik' => 'Tamamlanan yüksek lisans tezinde danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 20],
        'L.2.b' => ['baslik' => 'Tamamlanan doktora, sanatta yeterlik veya tıpta uzmanlık tezinde danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 40],
        'L.3.a' => ['baslik' => 'Yüksek lisans tezinde ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 5],
        'L.3.b' => ['baslik' => 'Doktora veya uzmanlık tezinde ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 10],
        'L.4.a' => ['baslik' => 'Tez izleme komitesi veya tez jürisi üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 1],
        'L.6' => ['baslik' => 'Ders vermek (dönem ve ders başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 1],

        // ══ N — PATENT, FAYDALI MODEL VE ÜRÜN TESCİLİ ══
        // ── M. ÖDÜLLER, İDARİ GÖREVLER VE DİĞER HİZMETLER ──
        // Bölümün tamamı girilmedi (aşağıdaki nota bakınız); yalnız YÖK Genel
        // Kurulunun 30.01.2025 kararıyla EKLENEN iki madde girildi, çünkü
        // ikisinin de sözlükte karşılığı var. M.18'in 7,5 puanı §0 uyarınca
        // aşağı yuvarlandı.
        'M.18' => ['baslik' => 'Ulusal ya da uluslararası düzeyde gerçekleştirilen jürili yarışmaya katılmak', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 7],
        'M.19' => ['baslik' => 'Jürili yarışmada danışmanlık yapmak ya da jüri üyesi olarak görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 15],

        'N.1.a' => ['baslik' => 'Yurt dışı patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 400],
        'N.1.c' => ['baslik' => 'Yurt içi patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 200],
        'N.2.b' => ['baslik' => 'Faydalı model veya ürün tescili', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 50],
        'M.10' => ['baslik' => 'Uluslararası bilimsel ya da mesleki kuruluşun yönetiminde, kurullarında veya komisyonlarında görev', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dış Kuruluş Kurul Üyeliği (Uluslararası)'], 'puan' => 25],
        'M.11' => ['baslik' => 'Bu kuruluşların Türkiye şubelerinin yönetiminde, kurullarında veya komisyonlarında görev', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dış Kuruluş Kurul Üyeliği (Ulusal)'], 'puan' => 20],
        // M.4 uluslararası akademik organizasyon (a yönetici 40 · b düzenleme/
        // bilim kurulu üyeliği 30), M.5 ULUSAL (a 20 · b 10). Cetvelde yalnız
        // M.4.b vardı ve M.5.b'nin 10'unu taşıyordu; başkanlık etiketlerinin
        // ve ulusal kurul etiketinin karşılığı hiç yoktu.
        'M.4.a' => ['baslik' => 'Uluslararası akademik organizasyonda yöneticilik', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)'], 'puan' => 40],
        'M.4.b' => ['baslik' => 'Uluslararası akademik organizasyonda düzenleme ya da bilim kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 30],
        'M.5.a' => ['baslik' => 'Ulusal akademik organizasyonda yöneticilik', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Ulusal)'], 'puan' => 20],
        'M.5.b' => ['baslik' => 'Ulusal akademik organizasyonda düzenleme ya da bilim kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 10],
    ],

    'gruplar' => [
        // Koşulların birebir andığı bölüm kümeleri — üçü de farklı.
        'A-K (profesör)' => ['A.*', 'B.*', 'C.*', 'D.*', 'E.*', 'F.*', 'G.*', 'H.*', 'K.*'],
        'A-K (doçent)' => ['A.*', 'B.*', 'C.*', 'D.*', 'E.*', 'F.*', 'G.*', 'H.*', 'I.*', 'K.*'],
        // Toplam barajın kapsamı: bilimsel araştırma, yayın ve eğitim-öğretim.
        'A-L' => ['A.*', 'B.*', 'C.*', 'D.*', 'E.*', 'F.*', 'G.*', 'H.*', 'I.*', 'J.*', 'K.*', 'L.*'],
        'MAKALE' => ['A.1.a', 'A.2.a', 'D.1.a', 'D.2.a'],
        'BASLICA_ESER' => ['A.1.a', 'A.2.a', 'C.1', 'F.1'],
        'L' => ['L.*'],
    ],

    // L bölümünün başındaki "bu bölümden elde edilecek toplam puan 25'i aşamaz"
    // notu ders satırının hemen altında duruyor; yalnızca dersi mi yoksa bütün
    // L bölümünü mü kapsadığı belirsiz. Tavan bütün bölüme uygulandı — dar
    // okuma adaya olduğundan yüksek puan gösterirdi.
    'grup_tavanlari' => [
        'L' => 25,
    ],
];
