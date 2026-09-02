<?php

/**
 * ESKİŞEHİR OSMANGAZİ ÜNİVERSİTESİ — Akademik Yükseltilme ve Atanma
 * İlkeleri Puan Tablosu
 * Kaynak: pdf/17536993862.eskisehirosmangaziuniverstesi.pdf (17 sayfa;
 * 17.05.2023-15/6 Senato Kararı ve 15.06.2023 YÖK Genel Kurul Kararı ile
 * değişik)
 *
 * MADDE KODLARI YÖNERGENİN KENDİSİ (1a-1h, 2a-2ç, 3a-3n, 4a-4f, 5a-5d,
 * 6a-6c, 7a-7b, 8a-8ö, 9a-9e, 10a-10b, 11a-11g, 12a-12e, 13a-13e,
 * 14a-14g, 15a-15c, 16a-16h, 17a-17c). Koşullar hem tek bende ("1f, 1g,
 * 3f, 3g maddeleri kapsamında en az 3 yayın") hem madde numarasına
 * ("1, 2, 3, 9 ve 16. madde kapsamında en az 40 puan") atıf yapıyor.
 *
 * ── 1 VE 3 AYNI DERGİLERİ İKİ KEZ FİYATLANDIRIYOR ──
 * Madde 1 "adayın lisansüstü tezlerinden ÜRETİLMEMİŞ olmak kaydıyla",
 * Madde 3 ise "üretilmiş olmak kaydıyla" aynı dergi basamaklarını aynı
 * puanlarla sayıyor. Motorda bu ayrım `makale` ile `tez_yayini`
 * kategorileri arasında zaten var; 1. madde `makale`, 3. madde
 * `tez_yayini` olarak girildi. Böylece bir çalışma yalnızca birinde
 * sayılıyor.
 *
 * ── AYNI KAYNAĞA DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   1d (AHCI 20) ile 1ç (Q4 20): aynı puan, çakışma yok; AHCI kendi
 *       etiketinde kaldı.
 *   1ğ/1h kısa yayınlar (5/3): 1ğ WoS-AHCI, 1h diğer uluslararası;
 *       ESCI-Scopus ve alan indeksi basamakları için ayrı satır yok, bu
 *       yüzden 1h'nin etiket kümesine katıldılar → 3.
 *   2b/2ç ulusal kısa yayınlar (4/2) → 2.
 *   3ğ (tez yayını ulusal hakemli makale 8) tek satır.
 *   4b/4e kitap editörlüğü (uluslararası 15 / ulusal 3) ayrı etiketlerde
 *       kaldı; 4f kitap çevirisi (5) 'Çeviri Kitap' etiketinde.
 *   5c faydalı model, endüstriyel tasarım ve bilimsel tasarım tek satırda
 *       (10).
 *   6a WoS dergi ve uluslararası kitap atıfları (4) tek satırda; 6b diğer
 *       uluslararası (2), 6c ulusal (1).
 *   8 bölümünün on dokuz satırı fon kaynağı × rol ekseninde toplandı;
 *       sözlükte TÜBİTAK'ın ARDEB/BİDEB/BİTO ayrımı olmadığı için TÜBİTAK
 *       satırları rol başına EN DÜŞÜK değerle birleşti (yürütücü 10,
 *       araştırmacı 15 yerine 10).
 *   11e/11f/11g hakemlik (5/3/2) → 2.
 *   13a-13ç etkinlik görevleri (6/4/3/2) → 2; 13d/13e davetli
 *       konuşmacılık (5/2) → 2.
 *   15a-15c idari görevler yıl başına (6/4/2); yıl biriktirmesi motorda
 *       yok, tek yıl değeri girildi.
 *   17a/17b jüri üyelikleri (4/2) → 2.
 *
 * ── GİRİLMEYEN KALEMLER ──
 *   8j (panelde değerlendirilmiş ama kabul edilmemiş proje 5) — desteklenen
 *       projeyle aynı kaynağa düşer, başvuru sahibini destekli gibi sayardı.
 *   5d (teknopark danışmanlığı), 14. maddenin tamamı (eğiticilerin eğitimi,
 *       PDÖ sertifikaları), 18. madde (diğer etkinlikler) — sözlükte
 *       karşılıksız ya da belge sahipliğine bağlı.
 *   3h-3j (tez yayınından üretilmiş bildiriler) — `tez_yayini`
 *       kategorisinin bildiri karşılığı 'CPCI Bildiri' tek etiket; 3h/3ı
 *       sözlü ve 3i/3j poster ayrımı taşınamadığı için en düşük değerle
 *       (2) tek satırda toplandı.
 *   16d-16h (bienal, küratörlük, kamusal alanda daimi sergileme, jürili
 *       ödül) — sözlükteki sanat etiketleri 16a-16ç'de kullanıldı.
 *
 * ── UYGULANAN TAVANLAR ──
 * Madde 6 (atıf) 100 · Madde 9 (bilimsel toplantı) 60 · Madde 10 (ders) 20
 * · Madde 11 (editörlük-hakemlik) 30 · Madde 12 (ödüller) 60 · Madde 13
 * (etkinlik) 40 · Madde 15 (idari görev) 50 · Madde 17 (jüri üyelikleri)
 * 20 — hepsi maddelerin kendi başlıklarından.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   Madde 15 puanı YIL BAŞINA veriliyor ve "aynı anda birden fazla idari
 *       görevi olanlar bir tanesini puanlayabilir" diyor; yıl biriktirmesi
 *       ve tek görev sınırı motorda yok.
 *   Madde 1.8: "Herhangi bir koşulda kullanılan bilimsel çıktı bir başka
 *       koşul sağlamada kullanılamaz" — motor bir faaliyeti birden çok
 *       koşulda sayabiliyor; aday olduğundan HAZIR görünebilir.
 *   Madde 1.5: "Patentler kapsamında alınan puanlar hak sahibi sayısına
 *       bölünür" — patent kategorisi genel yazar matrisine bağlandı,
 *       bölme yaklaşık.
 *   Madde 1.2'nin "ÜAK'ın yağmacı dergi listesindeki yayınlar sayılmaz"
 *       kuralı — dergi listesi kayıtta yok.
 *
 * Yönerge: yonerge/esogu.php
 */

return [
    'kapsam_notu' => 'Puanlar Eskişehir Osmangazi Üniversitesi Akademik Yükseltilme ve Atanma '
        .'İlkeleri Puan Tablosundan. Yazar çarpanı Madde 1.4\'e göre işliyor: tek yazarlı '
        .'eserde tam puan, iki yazarlıda %80, üç ve daha fazla yazarlıda 1,8 × puan / yazar '
        .'sayısı. Yazar listesini boş bırakırsanız çarpan hiç uygulanmaz ve puanınız '
        .'olduğundan YÜKSEK görünür. '
        .'ÖNEMLİ: yönerge 1. maddeyi "tezlerinizden ÜRETİLMEMİŞ", 3. maddeyi "üretilmiş" '
        .'yayınlar için ayırıyor. Tezinizden ürettiğiniz yayınları faaliyet kaydında '
        .'"Tezden Üretilmiş Yayın" olarak işaretleyin; makale olarak kaydederseniz yanlış '
        .'maddeden sayılır. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: TÜBİTAK\'ın ARDEB, BİDEB ve BİTO '
        .'program ayrımı kayıtta olmadığı için proje satırları rol başına en düşük değerle '
        .'birleşti; hakemlik, etkinlik görevleri ve jüri üyelikleri de düşük olan değerden '
        .'sayılıyor; tez yayınından üretilmiş bildiriler tek satırda toplandı; teknopark '
        .'danışmanlığı, eğiticilerin eğitimi ve PDÖ kalemleri girilemedi; idari görevlerin yıl '
        .'biriktirmesi uygulanmıyor. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünebilir: Madde 1.8\'in "bir koşulda '
        .'kullanılan çıktı başka koşulda kullanılamaz" kuralı uygulanamıyor, aynı yayınınız '
        .'birden fazla koşulu birden karşılıyor görünebilir.',

    // Madde 1.4: tek yazar tam puan, iki yazar 0,8; üç ve üzeri 1,8/n.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'tez_danismanligi', 'egitim_ogretim', 'idari_gorev',
            'odul', 'editorluk', 'toplumsal_katki'],
        'roller' => (function (): array {
            $ortak = ['kademeler' => [1 => 1.00, 2 => 0.80], 'bol' => ['pay' => 1.8]];

            return [
                'tek' => ['kademeler' => [1 => 1.0]],
                'ilk' => $ortak,
                'baslica' => $ortak,
                'yazar_2' => $ortak,
                'yazar_3' => $ortak,
                'yazar_4' => $ortak,
                'yazar_5' => $ortak,
                'yazar_6' => $ortak,
                'ortak' => $ortak,
            ];
        })(),
    ],

    'maddeler' => [
        // ══ 1. ULUSLARARASI MAKALE (tezden üretilmemiş) ══
        '1a' => ['baslik' => 'Web of Science Q1 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale'], 'puan' => 35],
        '1b' => ['baslik' => 'Web of Science Q2 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale'], 'puan' => 30],
        '1c' => ['baslik' => 'Web of Science Q3 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['ozgun_makale'], 'puan' => 25],
        '1ç' => ['baslik' => 'Web of Science Q4 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => ['ozgun_makale'], 'puan' => 20],
        '1d' => ['baslik' => 'AHCI kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 20],
        '1e' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale'], 'puan' => 20],
        '1f' => ['baslik' => 'Uluslararası alan indeksleri kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale'], 'puan' => 15],
        '1g' => ['baslik' => 'Diğer uluslararası hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale'], 'puan' => 12],
        '1ğ' => ['baslik' => 'SSCI, SCI, SCI-Expanded veya AHCI dergisinde yayımlanmış olgu sunumu, derleme, editöre mektup, teknik not veya kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 5],
        '1h' => ['baslik' => 'Diğer uluslararası hakemli dergide yayımlanmış olgu sunumu, derleme, editöre mektup, teknik not veya kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 3],

        // ══ 2. ULUSAL MAKALE ══
        '2a' => ['baslik' => 'ULAKBİM tarafından taranan ulusal hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale'], 'puan' => 12],
        '2b-2ç' => ['baslik' => 'Ulusal hakemli dergide yayımlanmış olgu sunumu, derleme, editöre mektup, teknik not veya kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 2],

        // ══ 3. TEZLERDEN ÜRETİLMİŞ YAYINLAR ══
        '3a' => ['baslik' => 'Tezinizden üretilmiş, Web of Science Q1 dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 35],
        '3e' => ['baslik' => 'Tezinizden üretilmiş, ESCI veya Scopus kapsamındaki dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale'], 'puan' => 20],
        '3f-3g' => ['baslik' => 'Tezinizden üretilmiş, uluslararası alan indeksli ya da diğer uluslararası hakemli dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Diğer'], 'turler' => ['ozgun_makale'], 'puan' => 12],
        '3ğ' => ['baslik' => 'Tezinizden üretilmiş, ulusal hakemli dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale'], 'puan' => 8],
        '3h-3j' => ['baslik' => 'Tezinizden üretilmiş bildiri', 'kategori' => 'tez_yayini', 'kaynaklar' => ['CPCI Bildiri'], 'puan' => 2],
        '3k' => ['baslik' => 'Tezinizden üretilmiş, tanınmış uluslararası yayınevince yayımlanmış kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 12],
        '3l' => ['baslik' => 'Tezinizden üretilmiş, tanınmış uluslararası yayınevince yayımlanmış kitap bölümü', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 8],
        '3m' => ['baslik' => 'Tezinizden üretilmiş, tanınmış ulusal yayınevince yayımlanmış kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 6],
        '3n' => ['baslik' => 'Tezinizden üretilmiş, tanınmış ulusal yayınevince yayımlanmış kitap bölümü', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 4],

        // ══ 4. KİTAP ══
        '4a' => ['baslik' => 'Tanınmış uluslararası yayınevince yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 30],
        '4b' => ['baslik' => 'Tanınmış uluslararası yayınevince yayımlanmış kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 15],
        '4c' => ['baslik' => 'Tanınmış uluslararası yayınevince yayımlanmış kitap bölümü', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 10],
        '4ç' => ['baslik' => 'Tanınmış ulusal yayınevince yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Ders / Metot Kitabı'], 'puan' => 15],
        '4d' => ['baslik' => 'Tanınmış ulusal yayınevince yayımlanmış kitap bölümü', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 8],
        '4e' => ['baslik' => 'Tanınmış ulusal yayınevince yayımlanmış kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 3],
        '4f' => ['baslik' => 'Tanınmış ulusal yayınevince yayımlanmış bir kitabın çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap', 'Çeviri Kitap Bölümü'], 'puan' => 5],

        // ══ 5. GİRİŞİMCİLİK VE YENİLİKÇİLİK ══
        '5a' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 40],
        '5b' => ['baslik' => 'Ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 30],
        '5c' => ['baslik' => 'Faydalı model, endüstriyel tasarım veya bilimsel tasarım', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili', 'Yazılım'], 'puan' => 10],
        '5ç' => ['baslik' => 'Teknoloji geliştirme bölgesinde firma sahibi ya da ortağı olmak', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 20],

        // ══ 6. ATIF (grup tavanı 100) ══
        '6a' => ['baslik' => 'SSCI, SCI, SCI-Expanded veya AHCI dergilerinde ya da tanınmış uluslararası yayınevi kitaplarında atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 4],
        '6b' => ['baslik' => 'Uluslararası diğer hakemli dergilerdeki atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 2],
        '6c' => ['baslik' => 'Ulusal hakemli dergilerde veya tanınmış ulusal yayınevi kitaplarında atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 1],

        // ══ 7. TAMAMLANMIŞ LİSANSÜSTÜ TEZLERDE DANIŞMANLIK ══
        '7a' => ['baslik' => 'Tamamlanmış doktora, uzmanlık veya sanatta yeterlik tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 10],
        '7a-es' => ['baslik' => 'Tamamlanmış doktora, uzmanlık veya sanatta yeterlik tezinde eş danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 5],
        '7b' => ['baslik' => 'Tamamlanmış yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 6],
        '7b-es' => ['baslik' => 'Tamamlanmış yüksek lisans tezinde eş danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 3],

        // ══ 8. PROJELER ══
        '8a' => ['baslik' => 'AB Çerçeve Programı araştırma projesinde koordinatör, yürütücü veya baş araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 50],
        '8b' => ['baslik' => 'AB Çerçeve Programı araştırma projesinde ortak araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 40],
        '8c' => ['baslik' => 'AB Çerçeve Programı dışındaki uluslararası destekli projede yürütücü, koordinatör veya baş araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 30],
        '8ç' => ['baslik' => 'AB Çerçeve Programı dışındaki uluslararası destekli projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],
        '8d-8ı' => ['baslik' => 'TÜBİTAK veya TÜSEB projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 10],
        '8e-8i' => ['baslik' => 'TÜBİTAK veya TÜSEB projesinde araştırmacı, uzman ya da danışman', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 5],
        '8k' => ['baslik' => 'Üniversite dışındaki kamu kurumlarıyla yapılan araştırma projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 8],
        '8l' => ['baslik' => 'Üniversite dışındaki kamu kurumlarıyla yapılan araştırma projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 6],
        '8m' => ['baslik' => 'Üniversite BAP birimince desteklenen araştırma projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 8],
        '8n' => ['baslik' => 'Üniversite BAP birimince desteklenen araştırma projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 4],

        // ══ 9. BİLİMSEL TOPLANTI (grup tavanı 60) ══
        '9a' => ['baslik' => 'Uluslararası bilimsel toplantıda sözlü sunulan ve tam metin yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 6],
        '9b-9d' => ['baslik' => 'Uluslararası bilimsel toplantıda özet yayımlanan ya da poster olarak sunulan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 4],
        '9c' => ['baslik' => 'Ulusal bilimsel toplantıda sözlü sunulan ve tam metin yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 4],
        '9ç-9e' => ['baslik' => 'Ulusal bilimsel toplantıda özet yayımlanan ya da poster olarak sunulan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 2],

        // ══ 10. EĞİTİM-ÖĞRETİM (grup tavanı 20) ══
        '10a' => ['baslik' => 'Bir dönem lisansüstü ders vermiş olmak', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
        '10b' => ['baslik' => 'Bir dönem ön lisans veya lisans dersi vermiş olmak', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 1],

        // ══ 11. EDİTÖRLÜK VE HAKEMLİK (grup tavanı 30) ══
        '11a' => ['baslik' => 'SSCI, SCI, SCI-Expanded veya AHCI dergisinde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 14],
        '11c' => ['baslik' => 'Uluslararası indeksli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi', 'Diğer Hakemli Dergi'], 'puan' => 10],
        '11d' => ['baslik' => 'Ulusal hakemli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 6],
        '11b-11ç' => ['baslik' => 'Dergi editöryal kurulu veya yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 8],
        '11e-11g' => ['baslik' => 'Dergi hakemliği ya da makale editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 2],

        // ══ 12. ÖDÜLLER (grup tavanı 60) ══
        '12a' => ['baslik' => 'Yurt dışı kurum veya kuruluşlardan alınan bilim ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 40],
        '12b' => ['baslik' => 'TÜBA veya TÜBİTAK Bilim/Hizmet Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü'], 'puan' => 30],
        '12c' => ['baslik' => 'TÜBA veya TÜBİTAK Bilim Teşvik Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 20],
        '12ç' => ['baslik' => 'YÖK Ödülleri', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü'], 'puan' => 20],
        '12d-12e' => ['baslik' => 'Bilim, sanat ve estetik (BSE) ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'Yarışma Derecesi / Mansiyon', 'Burs'], 'puan' => 10],

        // ══ 13. BİLİMSEL, SANATSAL VE TASARIMA YÖNELİK ETKİNLİK (tavan 40) ══
        '13a-13ç' => ['baslik' => 'Bilimsel etkinlikte başkanlık, yarışma jürisi üyeliği ya da düzenleme, yürütme veya bilim kurulunda görev', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 2],
        '13d-13e' => ['baslik' => 'Bilimsel etkinlikte davetli konuşmacı ya da panelist olarak görev almak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 2],

        // ══ 15. İDARİ GÖREVLER (grup tavanı 50, yıl çarpanı uygulanamadı) ══
        '15a' => ['baslik' => 'Senato veya üniversite yönetim kurulu üyeliği, enstitü, yüksekokul ya da merkez müdürlüğü, başhekimlik, bölüm başkanlığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı', 'Senato / Üniversite Yönetim Kurulu Üyesi', 'Dekan / Enstitü-YO Müdürü', 'Uygulama ve Araştırma Merkezi Müdürü', 'Bölüm Başkanı'], 'puan' => 6],
        '15b' => ['baslik' => 'Dekan yardımcılığı, müdür yardımcılığı ya da bölüm başkan yardımcılığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.', 'Bölüm Başkan Yardımcısı', 'Kurul / Komisyon Üyeliği'], 'puan' => 4],
        '15c' => ['baslik' => 'Anabilim veya bilim dalı başkanlığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 2],

        // ══ 16. SANAT VE TASARIM ETKİNLİKLERİ ══
        '16a' => ['baslik' => 'Özgün sanat eseri, tasarım ya da yorum çalışmasıyla yurt dışında kişisel etkinliğe katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Eserin Müzeye Kabulü (Yurt Dışı)'], 'puan' => 20],
        '16b' => ['baslik' => 'Özgün sanat eseri, tasarım ya da yorum çalışmasıyla yurt içinde kişisel etkinliğe katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Ulusal)', 'Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Satın Alınması (Yurt İçi)', 'Eserin Yayında Yer Alması / Satın Alınması', 'Özgün Eser / Beste / Tasarım'], 'puan' => 15],
        '16ç' => ['baslik' => 'Özgün sanat eseri, tasarım ya da yorum çalışmasıyla uluslararası karma veya ortak etkinliğe katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Karma Sergi (Uluslararası)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)'], 'puan' => 8],
        '16c' => ['baslik' => 'Özgün sanat eseri, tasarım ya da yorum çalışmasıyla ulusal karma veya ortak etkinliğe katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Elektronik Karma Sergi (Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 5],

        // ══ 17. JÜRİ ÜYELİKLERİ (grup tavanı 20) ══
        '17a-17b' => ['baslik' => 'Lisansüstü tez savunma, tez izleme veya yeterlik jürisi üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 2],
        '17c' => ['baslik' => 'TÜBİTAK, AB ve benzeri projelerde panelist ya da uzman olarak görev yapmak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı', 'Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın'], 'puan' => 2],
    ],

    'gruplar' => [
        // Madde 2.2: "en az 1 tanesi 1a-1ç veya 3a-3ç kapsamında".
        '2.2-UST' => ['1a', '1b', '1c', '1ç', '3a'],
        // Madde 2.2: "1a, 1b, 1c, 1ç, 1f, 1g, 3a, 3b, 3c, 3ç, 3f, 3g kapsamında".
        '2.2-KUME' => ['1a', '1b', '1c', '1ç', '1f', '1g', '3a', '3f-3g'],
        // Madde 2.3: "1f, 1g, 3f, 3g kapsamında en az 3 yayın".
        '2.3-KUME' => ['1f', '1g', '3f-3g'],
        // Madde 2.4: "1, 2, 3, 9 ve 16. madde kapsamında".
        '1-2-3-9-16' => ['1*', '2*', '3*', '9*', '16*'],
        // Madde 3.1: "1, 2, 9, 16 madde kapsamında".
        '1-2-9-16' => ['1*', '2*', '9*', '16*'],
        'KITAP' => ['4*', '3k', '3l', '3m', '3n'],
        'PATENT' => ['5a', '5b', '5c'],
        'ATIF' => ['6*'],
        'TEZ' => ['7a', '7a-es', '7b', '7b-es'],
        'TEZ-DOKTORA' => ['7a'],
        'TEZ-YL' => ['7b'],
        'PROJE' => ['8*'],
        'PROJE-YURUTUCU' => ['8a', '8c', '8d-8ı', '8k', '8m'],
        'TOPLANTI' => ['9*'],
        'DERS' => ['10*'],
        'EDITORLUK' => ['11*'],
        'ODUL' => ['12*'],
        'ETKINLIK' => ['13*'],
        'IDARI' => ['15*'],
        'SANAT' => ['16*'],
        'SANAT-KISISEL' => ['16a', '16b'],
        'JURI' => ['17a-17b', '17c'],
        'TEKNOPARK' => ['5ç'],
    ],

    'grup_tavanlari' => [
        'ATIF' => 100,
        'TOPLANTI' => 60,
        'DERS' => 20,
        'EDITORLUK' => 30,
        'ODUL' => 60,
        'ETKINLIK' => 40,
        'IDARI' => 50,
        'JURI' => 20,
    ],
];
