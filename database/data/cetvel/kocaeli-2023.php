<?php

/**
 * KOCAELİ ÜNİVERSİTESİ — TABLO 3 Puanlama Tablosu
 * Kaynak: pdf/1773235152642.kocaeli-kriter-11032026.pdf (Aralık 2023)
 *
 * MADDE KODLARI yönergenin kendi harflendirmesi + numarası; Tablo 1 (makale
 * sayısı) ve Tablo 2 (asgari puan) doğrudan bunlara atıf yapıyor
 * ("Tablo 3, A.1-A.4 kapsamındaki dergilerde en az iki adet").
 *
 * A BÖLÜMÜ DOKUZ KADEMELİ ve koşullar bu kademeleri farklı derinliklerde
 * çağırıyor — A.1-A.2, A.1-A.4, A.1-A.5, A.1-A.6, A.1-A.8. Bu yüzden her
 * kademe ayrı madde, gruplar da kümülatif tanımlı.
 *
 * GİRİLMEYEN BÖLÜMLER: I (editörlük), J (ödüller), K (idari görevler) ve
 * sanatsal/müzikal üretim blokları. Tablo 2'de yalnızca azami sınırla
 * anılıyorlar (K için 50 puan), asgari koşul üretmiyorlar.
 */

return [
    'kapsam_notu' => 'Çok yazarlı eserlerde puan yönergenin yazar çarpanı tablosuna göre azaltılır; çarpan adayın yayındaki SIRASINA da bağlı olduğu için faaliyetinizde kaçıncı yazar olduğunuzu seçmeniz gerekir. Sırayı belirtmezseniz o yazar sayısındaki en düşük çarpan uygulanır; yazar listesi boşsa çarpan hiç uygulanmaz. Puanlar Kocaeli Üniversitesi TABLO 3\'ten (Aralık 2023). Editörlük, ödül, '
        .'idari görev ve sanatsal üretim blokları girilmedi; yönergede yalnızca azami sınır '
        .'taşıyorlar. Gerçek toplamınız burada görünenden yüksek olabilir, düşük olamaz.',

    // Tablo 1: çarpan hem yazar sayısına hem adayın yayındaki SIRASINA bağlı.
    // Yönergenin tablosu satır satır aktarıldı; "-" olan hücreler o yazar
    // sayısında mümkün olmadığı için kademede yer almıyor.
    //
    //   sıra \ sayı    1     2     3     4     5    >5
    //   1. yazar     1,00  0,90  0,80  0,70  0,60  0,50
    //   2. yazar        -  0,80  0,70  0,60  0,50  0,40
    //   3. yazar        -     -  0,60  0,50  0,40  0,35
    //   4. yazar        -     -     -  0,40  0,35  0,30
    //   5. yazar        -     -     -     -  0,30  0,25
    //   6. ve sonrası   -     -     -     -     -  0,20
    //
    // Sırasını belirtmeyen aday ('ortak') o yazar sayısındaki EN DÜŞÜK satırı
    // alır — sırayı bilmeden yüksek satırı vermek puanı fazla gösterirdi.
    'yazar_katsayisi' => [
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.0]],
            'ilk' => ['kademeler' => [1 => 1.0, 2 => 0.90, 3 => 0.80, 4 => 0.70, 5 => 0.60], 'sonrasi' => 0.50],
            'baslica' => ['kademeler' => [1 => 1.0, 2 => 0.90, 3 => 0.80, 4 => 0.70, 5 => 0.60], 'sonrasi' => 0.50],
            'yazar_2' => ['kademeler' => [2 => 0.80, 3 => 0.70, 4 => 0.60, 5 => 0.50], 'sonrasi' => 0.40],
            'yazar_3' => ['kademeler' => [3 => 0.60, 4 => 0.50, 5 => 0.40], 'sonrasi' => 0.35],
            'yazar_4' => ['kademeler' => [4 => 0.40, 5 => 0.35], 'sonrasi' => 0.30],
            'yazar_5' => ['kademeler' => [5 => 0.30], 'sonrasi' => 0.25],
            'yazar_6' => ['sonrasi' => 0.20],
            'ortak' => ['kademeler' => [1 => 1.0, 2 => 0.80, 3 => 0.60, 4 => 0.40, 5 => 0.30], 'sonrasi' => 0.20],
        ],
    ],

    'maddeler' => [
        // ── A. MAKALELER ── (tam araştırma ve derleme makaleleri)
        'A1' => ['baslik' => 'SCI-E/SSCI/AHCI Q1 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 60],
        'A2' => ['baslik' => 'SCI-E/SSCI/AHCI Q2 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 55],
        'A3' => ['baslik' => 'SCI-E/SSCI/AHCI Q3 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 40],
        'A4' => ['baslik' => 'SCI-E/SSCI/AHCI Q4 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 30],
        'A5' => ['baslik' => 'ESCI taranan dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 25],
        'A7' => ['baslik' => 'Uluslararası diğer indeksli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 15],
        'A8' => ['baslik' => 'ULAKBİM TR Dizin taranan ulusal hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 10],
        'A9' => ['baslik' => 'Diğer ulusal hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 8],

        // A.6 (Scopus, 20 puan) GİRİLMEDİ: sözlükte ESCI ile aynı etikete
        // düşüyor ve A.5 (25) onu zaten kapsıyor. Girilseydi `puan()` en
        // yükseği aldığı için hesabı değiştirmezdi.

        // ── B. BİLİMSEL TOPLANTI ──
        'B1' => ['baslik' => 'Uluslararası toplantıda sözlü, tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 8],
        'B2' => ['baslik' => 'Uluslararası toplantıda sözlü, özet bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 7],
        'B3' => ['baslik' => 'Uluslararası toplantıda poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 6],
        'B4' => ['baslik' => 'Ulusal toplantıda sözlü, tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 7],
        'B6' => ['baslik' => 'Ulusal toplantıda poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 5],

        // ── C. KİTAPLAR ──
        'C1' => ['baslik' => 'Uluslararası yayınevinden özgün kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 60],
        'C2' => ['baslik' => 'Uluslararası yayınevinden kitap bölümü', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 20],
        'C3' => ['baslik' => 'Uluslararası yayımlanan ansiklopedi maddesi', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 5],
        'C4' => ['baslik' => 'Ulusal yayınevinden özgün kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 40],
        'C5' => ['baslik' => 'Ulusal yayınevinden kitap bölümü', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 10],
        'C6' => ['baslik' => 'Tam kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 15],
        'C7' => ['baslik' => 'Kitap bölümü çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 6],

        // ── D. ATIFLAR ── (bölüm tavanı 1500 puan)
        'D1' => ['baslik' => 'SCI-E/SSCI/AHCI dergilerde ve uluslararası kitaplarda atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 4],
        'D4' => ['baslik' => 'Ulusal hakemli dergilerde ve kitaplarda atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer'], 'puan' => 1],
        // D bölümünde PATENT ATFI KALEMİ YOK — bir süre 'D6' => "Patentlerde
        // yapılan atıf, 3 puan" olarak duruyordu; yönergede D.6 güzel
        // sanatlardaki eserlerin ulusal kaynakta yer alması (1 puan).
        // Uydurma kalem kaldırıldı; D.5/D.6 için ayrı kaynak etiketi yok.

        // ── E. EĞİTİM-ÖĞRETİM ── (bölüm tavanı 50 puan)
        'E1' => ['baslik' => 'Önlisans/lisans dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders'], 'puan' => 2],
        'E2' => ['baslik' => 'Önlisans/lisans dersi (yabancı dilde)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Değişim Programı Dersi'], 'puan' => 3],
        'E3' => ['baslik' => 'Lisansüstü dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
        'E4' => ['baslik' => 'Lisansüstü dersi (yabancı dilde)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Yabancı Dilde Ders'], 'puan' => 4],

        // ── F. TEZ YÖNETİCİLİĞİ ──
        'F1' => ['baslik' => 'Tamamlanmış doktora/uzmanlık/sanatta yeterlik tez yönetimi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 40],
        'F2' => ['baslik' => 'Tamamlanmış yüksek lisans tez yönetimi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 15],
        'F3' => ['baslik' => 'Doktora/sanatta yeterlik eş danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 9],
        'F4' => ['baslik' => 'Yüksek lisans eş danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 4],

        // ── H. ARAŞTIRMA PROJELERİ ──
        'H2' => ['baslik' => 'AB çerçeve/NSF/ERC projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 150],
        'H3' => ['baslik' => 'AB çerçeve/NSF/ERC projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 100],
        'H8' => ['baslik' => 'TÜBİTAK ARDEB/TEYDEB veya TÜSEB projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 100],
        'H9' => ['baslik' => 'Diğer TÜBİTAK veya Kalkınma Ajansı projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 50],
        'H10' => ['baslik' => 'Diğer kamu kurumu projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 40],
        'H11' => ['baslik' => 'Sanayi kuruluşu Ar-Ge projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 40],
        'H13' => ['baslik' => 'TÜBİTAK ARDEB/TEYDEB veya TÜSEB projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 50],
        'H14' => ['baslik' => 'Diğer TÜBİTAK veya Kalkınma Ajansı projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 25],
        'H15' => ['baslik' => 'Diğer kamu kurumu projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],
        'H16' => ['baslik' => 'Sanayi kuruluşu projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],
        // Kaynakta BAP projeleri role göre ayrı: yürütücü 18, araştırmacı 6,
        // danışman 3 (madde 23-25). Cetvelde tek 25 puanlık rolsüz satırdı.
        'H23' => ['baslik' => 'Üniversite (BAP) destekli araştırma projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 18],
        'H24' => ['baslik' => 'Üniversite (BAP) destekli araştırma projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 6],
        'H25' => ['baslik' => 'Üniversite (BAP) destekli araştırma projesinde danışman', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['danisman'], 'puan' => 3],
        // Madde 28: TÜBİTAK 2209-A, 2209-B ve 2242 projelerinde danışmanlık 10
        // puan. 'Öğrenci Projesi (2209 vb.)' 01.09.2026'ya kadar 50 puanlık
        // yürütücü (H9) ve 25 puanlık araştırmacı (H14) satırlarındaydı ve
        // yönergenin "H.1-H.17" koşulunu da sahte biçimde sağlıyordu.
        'H28' => ['baslik' => 'TÜBİTAK 2209-A, 2209-B veya 2242 projesinde danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'puan' => 10],

        // ── SANATSAL ETKİNLİK ── (Güzel Sanatlar koşullarının saydığı kalemler)
        'S1' => ['baslik' => 'Kişisel sanat etkinliği (sergi, dinleti, gösterim)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Ulusal)'], 'puan' => 40],
        'S2' => ['baslik' => 'Karma sanat etkinliği (sergi, bienal, festival)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma/Jürili Etkinlik (Ulusal)'], 'puan' => 15],
    ],

    'gruplar' => [
        // Koşulların birebir kullandığı KÜMÜLATİF dergi kademeleri.
        'A.1-A.2' => ['A1', 'A2'],
        'A.1-A.4' => ['A1', 'A2', 'A3', 'A4'],
        'A.1-A.5' => ['A1', 'A2', 'A3', 'A4', 'A5'],
        'A.1-A.6' => ['A1', 'A2', 'A3', 'A4', 'A5'],
        'A.1-A.7' => ['A1', 'A2', 'A3', 'A4', 'A5', 'A7'],
        'A.1-A.8' => ['A1', 'A2', 'A3', 'A4', 'A5', 'A7', 'A8'],
        'D.1-D.6' => ['D*'],
        'E.1-E.4' => ['E*'],
        'F.1-F.2' => ['F1', 'F2'],
        'H.1-H.17' => ['H2', 'H3', 'H8', 'H9', 'H10', 'H11', 'H13', 'H14', 'H15', 'H16'],
        'H.1-H.22' => ['H*'],
        'KISISEL_SANAT' => ['S1'],
        'KARMA_SANAT' => ['S2'],
    ],

    'grup_tavanlari' => [
        // Tablo 2'nin "Azami" sütunundan.
        'D.1-D.6' => 1500,
        'E.1-E.4' => 50,
    ],
];
