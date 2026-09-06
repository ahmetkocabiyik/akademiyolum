<?php

/**
 * SELÇUK ÜNİVERSİTESİ — Temel Alan Başvuru Şartları Tabloları
 * Kaynak: pdf/17537007702.selcukuniverstesi.pdf (93 sayfa)
 *
 * ON İKİ TEMEL ALAN, ON İKİ AYRI TAM CETVEL. Çoğu yönerge tek puan tablosu
 * yayımlayıp eşiği alana göre değiştirir; Selçuk tersini yapıyor — Tablo 2'nin
 * asgari puanları bütün alanlarda AYNI, puan tabloları alan başına ayrı. Bu
 * yüzden dosya `cetveller` anahtarıyla on iki cetveli birden döndürüyor.
 *
 * KALEMLER YÖNERGENİN KENDİ KODLARIYLA: bölüm numarası + bent harfi (1a, 7c…).
 * Bölüm numaraları alanlar arasında kayıyor — Mühendislik'te 12. bölüm,
 * Güzel Sanatlar'da 3. bölüm yok — kodlar yalnızca kendi alanı içinde anlamlı.
 * Özel kriterler bölüm ADIYLA atıf yaptığı için (yonerge/selcuk.php) bu kayma
 * orada alan başına açıkça eşleniyor.
 *
 * ÇİFT DEĞERLİ HÜCRELER: Güzel Sanatlar'ın sanatsal etkinlik satırları puanı
 * "20/5" biçiminde veriyor — kişisel etkinlik 20, grup/karma 5. Kaynak sözlüğü
 * bu ikisini ayırabildiği için satır iki ayrı maddeye bölündü (2a-kisisel,
 * 2a-karma gibi).
 *
 * AYNI ETİKETE DÜŞEN KALEMLERDE DÜŞÜK PUAN: motor bir faaliyete uyan maddeler
 * arasından en yükseğini seçtiği için, kaynak sözlüğünün ayıramadığı kalemler
 * (ör. YÖK'ün iki ayrı ödülü tek etikete düşüyor) birleştirilirken daima düşük
 * olan tutuldu. Aday puanını eksik görür, fazla görmez.
 *
 * GİRİLMEYEN KALEMLER: kongre/sempozyum düzenleme kurulu görevleri, h-indeksi
 * ve yurt dışı deneyim koşulları, kişisel patent BAŞVURUSU (tescil değil),
 * sportif başarı ve temsil, yarışma/uygulama/yazılım kalemleri. Kaynak
 * sözlüğünde karşılıkları yok; girilselerdi başka bir faaliyet türüne
 * yazılmaları gerekirdi.
 *
 * Eşikler: yonerge/selcuk.php
 */

return [
    'cetveller' => [
        'selcuk-2024-egitim' => [
            'kapsam_notu' => 'Çok yazarlı eserlerde puan yönergenin yazar çarpanı tablosuna göre azaltılır; çarpan adayın yazar SIRASINA da bağlı olduğu için faaliyetinizde rolü ("tek / ilk / başlıca / ortak") işaretlemeniz gerekir. Rol veya yazar listesi boşsa en düşük çarpan uygulanır ya da hiç uygulanmaz. Atıflarda çarpan uygulanmaz. Puanlar Selçuk Üniversitesi Eğitim Bilimleri Temel Alanı Başvuru Şartları '
                .'Tablosundan. Kongre düzenleme kurulu görevleri, h-indeksi ve yurt dışı deneyim '
                .'koşulları, patent başvurusu ve sportif başarı kalemleri kaynak sözlüğünde '
                .'karşılıksız olduğu için girilmedi. Gerçek toplamınız burada görünenden yüksek '
                .'olabilir, düşük olamaz.',
            // Yönerge: başlıca yazar puanın yarısını alır, diğer yazarlar kalan yarıyı
            // eşit paylaşır (0,5/(n-1)). Başlıca yazar belirtilmemişse ve bildiri/kitap
            // gibi diğer yayınlarda puan yazarlar arasında eşit bölünür. ATIFLARDA
            // yazar sayısına bakılmaksızın tüm yazarlar tam puan alır.
            //
            // "Lisansüstü tez ve projelerden yapılan makalelerde azaltma katsayısı
            // uygulanmaz" istisnası girilemedi: faaliyet kaydı bir makalenin tezden
            // üretilip üretilmediğini tutmuyor. O makalelerde puan olduğundan DÜŞÜK
            // görünür.
            'yazar_katsayisi' => [
                'haric' => ['atif'],
                'roller' => [
                    'tek' => ['kademeler' => [1 => 1.0]],
                    'ilk' => ['kademeler' => [1 => 1.0], 'sonrasi' => 0.5],
                    'baslica' => ['kademeler' => [1 => 1.0], 'sonrasi' => 0.5],
                    'ortak' => ['kademeler' => [1 => 1.0], 'bol' => ['pay' => 0.5, 'eksi' => 1]],
                ],
            ],

            'maddeler' => [
                '1a' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 20],
                '1b' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 15],
                '1c' => ['baslik' => 'Diğer uluslararası indeksli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'puan' => 10],
                '1d' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI kapsamındaki dergide derleme, editöre mektup, teknik not veya kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 5],
                '2a' => ['baslik' => 'TR Dizin kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 10],
                '2b' => ['baslik' => 'Diğer ulusal hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'puan' => 5],
                '3a' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 25],
                '3b' => ['baslik' => 'Uluslararası yayınevi kitabında editörlük veya bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 10],
                '3c' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 25],
                '4a' => ['baslik' => 'SCI, SCIE, SSCI, AHCI, ESCI veya Scopus kapsamında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 3],
                '4b' => ['baslik' => 'Uluslararası yayınevi kitabında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 2],
                '4c' => ['baslik' => 'TR Dizin kapsamındaki dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
                '4d' => ['baslik' => 'Diğer uluslararası/ulusal kitap veya dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],
                '5a' => ['baslik' => 'Doktora veya eşdeğer uzmanlık tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 5],
                '5b' => ['baslik' => 'Yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 3],
                '6a' => ['baslik' => 'AB Çerçeve programı veya TÜBİTAK projesinde koordinatör/yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['yurutucu'], 'puan' => 15],
                '6b' => ['baslik' => 'AB Çerçeve programı veya TÜBİTAK projesinde araştırmacı veya danışman', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
                '6c' => ['baslik' => 'Kamu kurumu veya özel kuruluşla yapılan AR-GE/ÜR-GE projesi', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'puan' => 6],
                '6d' => ['baslik' => 'Üniversite dışı kamu kurumlarıyla yapılan araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'puan' => 4],
                '6e' => ['baslik' => 'Üniversite tarafından desteklenen araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'puan' => 4],
                '7a' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulmuş bildiri (poster hariç)', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 3],
                '7b' => ['baslik' => 'Ulusal bilimsel toplantıda sunulmuş bildiri (poster hariç)', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 2],
                '8a' => ['baslik' => 'Bir dönem yüksek lisans veya doktora dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
                '8b' => ['baslik' => 'Bir dönem önlisans veya lisans dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders'], 'puan' => 2],
                '9a' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 20],
                '9b' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 10],
                '9c' => ['baslik' => 'Tescil edilmiş faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım'], 'puan' => 5],
                '10a' => ['baslik' => 'YÖK ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü'], 'puan' => 25],
                '10d' => ['baslik' => 'TÜBİTAK Bilim veya Teşvik Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü'], 'puan' => 15],
                '10e' => ['baslik' => 'TÜBA GEBİP Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 5],
                '10f' => ['baslik' => 'TÜBA TESEP Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 3],
                '11a' => ['baslik' => 'SCI, SCIE, SSCI, AHCI, ESCI veya Scopus kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 2],
                '11b' => ['baslik' => 'BKCI veya Scopus kapsamındaki kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Kitap Editörlüğü'], 'puan' => 1],
                '11c' => ['baslik' => 'TR Dizin kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 1],
                '12a' => ['baslik' => 'Dekan, Başhekim, Enstitü/Konservatuvar/Yüksekokul/MYO Müdürü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 25],
                '12b' => ['baslik' => 'Dekan, Başhekim, Enstitü/Konservatuvar/Yüksekokul/MYO Müdür Yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.'], 'puan' => 15],
                '12c' => ['baslik' => 'Bölüm Başkanı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı'], 'puan' => 10],
                '12d' => ['baslik' => 'Bölüm Başkan Yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı'], 'puan' => 5],
                '12e' => ['baslik' => 'Rektörlüğe bağlı ofis/koordinatörlükte koordinatör', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 15],
                '12f' => ['baslik' => 'Rektörlüğe bağlı ofis/koordinatörlükte koordinatör yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 5],
                '12i' => ['baslik' => 'Rektörlüğe bağlı komisyon veya üniversite/fakülte kurulu üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Senato / Üniversite Yönetim Kurulu Üyesi'], 'puan' => 4],
                'KONGRE-BSK' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)'], 'puan' => 15],
                'KONGRE-UYE' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 5],
            ],
            'gruplar' => [
                '1' => ['1*'],
                '2' => ['2*'],
                '3' => ['3*'],
                '4' => ['4*'],
                '5' => ['5*'],
                '6' => ['6*'],
                '7' => ['7*'],
                '8' => ['8*'],
                '9' => ['9*'],
                '10' => ['10*'],
                '11' => ['11*'],
                '12' => ['12*'],
            ],
            'grup_tavanlari' => [
                '3' => 25,
                '5' => 10,
                '6' => 20,
                '7' => 10,
                '8' => 4,
                '10' => 10,
                '11' => 4,
                '12' => 25,
            ],
        ],
        'selcuk-2024-fen' => [
            'kapsam_notu' => 'Çok yazarlı eserlerde puan yönergenin yazar çarpanı tablosuna göre azaltılır; çarpan adayın yazar SIRASINA da bağlı olduğu için faaliyetinizde rolü ("tek / ilk / başlıca / ortak") işaretlemeniz gerekir. Rol veya yazar listesi boşsa en düşük çarpan uygulanır ya da hiç uygulanmaz. Atıflarda çarpan uygulanmaz. Puanlar Selçuk Üniversitesi Fen Bilimleri ve Matematik Temel Alanı Başvuru Şartları '
                .'Tablosundan. Kongre düzenleme kurulu görevleri, h-indeksi ve yurt dışı deneyim '
                .'koşulları, patent başvurusu ve sportif başarı kalemleri kaynak sözlüğünde '
                .'karşılıksız olduğu için girilmedi. Gerçek toplamınız burada görünenden yüksek '
                .'olabilir, düşük olamaz.',
            // Yönerge: başlıca yazar puanın yarısını alır, diğer yazarlar kalan yarıyı
            // eşit paylaşır (0,5/(n-1)). Başlıca yazar belirtilmemişse ve bildiri/kitap
            // gibi diğer yayınlarda puan yazarlar arasında eşit bölünür. ATIFLARDA
            // yazar sayısına bakılmaksızın tüm yazarlar tam puan alır.
            //
            // "Lisansüstü tez ve projelerden yapılan makalelerde azaltma katsayısı
            // uygulanmaz" istisnası girilemedi: faaliyet kaydı bir makalenin tezden
            // üretilip üretilmediğini tutmuyor. O makalelerde puan olduğundan DÜŞÜK
            // görünür.
            'yazar_katsayisi' => [
                'haric' => ['atif'],
                'roller' => [
                    'tek' => ['kademeler' => [1 => 1.0]],
                    'ilk' => ['kademeler' => [1 => 1.0], 'sonrasi' => 0.5],
                    'baslica' => ['kademeler' => [1 => 1.0], 'sonrasi' => 0.5],
                    'ortak' => ['kademeler' => [1 => 1.0], 'bol' => ['pay' => 0.5, 'eksi' => 1]],
                ],
            ],

            'maddeler' => [
                '1a' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 20],
                '1b' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 15],
                '1c' => ['baslik' => 'TR Dizin kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 10],
                '1d' => ['baslik' => 'Diğer uluslararası indeksli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'puan' => 8],
                '1e' => ['baslik' => 'Diğer ulusal hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'puan' => 4],
                '1f' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI kapsamındaki dergide derleme, editöre mektup, teknik not veya kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 5],
                '2a' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 20],
                '2c' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 15],
                '2d' => ['baslik' => 'Uluslararası yayınevi kitabında editörlük veya bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 8],
                '3a' => ['baslik' => 'SCI, SCIE, SSCI, AHCI, ESCI veya Scopus kapsamında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 3],
                '3b' => ['baslik' => 'Uluslararası yayınevi kitabında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 2],
                '3c' => ['baslik' => 'TR Dizin kapsamındaki dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
                '3d' => ['baslik' => 'Diğer uluslararası/ulusal kitap veya dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],
                '4a' => ['baslik' => 'Doktora veya eşdeğer uzmanlık tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 5],
                '4b' => ['baslik' => 'Yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 3],
                '5a' => ['baslik' => 'AB Çerçeve programı veya TÜBİTAK projesinde koordinatör/yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['yurutucu'], 'puan' => 15],
                '5b' => ['baslik' => 'AB Çerçeve programı veya TÜBİTAK projesinde araştırmacı veya danışman', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
                '5c' => ['baslik' => 'Kamu kurumu veya özel kuruluşla yapılan AR-GE/ÜR-GE projesi', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'puan' => 6],
                '5d' => ['baslik' => 'Üniversite dışı kamu kurumlarıyla yapılan araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'puan' => 4],
                '5e' => ['baslik' => 'Üniversite tarafından desteklenen araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'puan' => 4],
                '6a' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulmuş bildiri (poster hariç)', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 3],
                '6b' => ['baslik' => 'Ulusal bilimsel toplantıda sunulmuş bildiri (poster hariç)', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 2],
                '7a' => ['baslik' => 'Bir dönem yüksek lisans veya doktora dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
                '7b' => ['baslik' => 'Bir dönem önlisans veya lisans dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders'], 'puan' => 2],
                '8a' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 20],
                '8b' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 10],
                '8c' => ['baslik' => 'Tescil edilmiş faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım'], 'puan' => 5],
                '9a' => ['baslik' => 'YÖK ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü'], 'puan' => 25],
                '9d' => ['baslik' => 'TÜBİTAK Bilim veya Teşvik Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü'], 'puan' => 15],
                '9e' => ['baslik' => 'TÜBA GEBİP Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 5],
                '9f' => ['baslik' => 'TÜBA TESEP Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 3],
                '10a' => ['baslik' => 'SCI, SCIE, SSCI, AHCI, ESCI veya Scopus kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 2],
                '10b' => ['baslik' => 'BKCI veya Scopus kapsamındaki kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Kitap Editörlüğü'], 'puan' => 1],
                '10c' => ['baslik' => 'TR Dizin kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 1],
                '11a' => ['baslik' => 'Dekan, Başhekim, Enstitü/Konservatuvar/Yüksekokul/MYO Müdürü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 25],
                '11b' => ['baslik' => 'Dekan, Başhekim, Enstitü/Konservatuvar/Yüksekokul/MYO Müdür Yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.'], 'puan' => 15],
                '11c' => ['baslik' => 'Bölüm Başkanı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı'], 'puan' => 10],
                '11d' => ['baslik' => 'Bölüm Başkan Yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı'], 'puan' => 5],
                '11e' => ['baslik' => 'Rektörlüğe bağlı ofis/koordinatörlükte koordinatör', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 15],
                '11f' => ['baslik' => 'Rektörlüğe bağlı ofis/koordinatörlükte koordinatör yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 10],
                '11i' => ['baslik' => 'Rektörlüğe bağlı komisyon veya üniversite/fakülte kurulu üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Senato / Üniversite Yönetim Kurulu Üyesi'], 'puan' => 4],
                'KONGRE-BSK' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)'], 'puan' => 15],
                'KONGRE-UYE' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 5],
            ],
            'gruplar' => [
                '1' => ['1*'],
                '2' => ['2*'],
                '3' => ['3*'],
                '4' => ['4*'],
                '5' => ['5*'],
                '6' => ['6*'],
                '7' => ['7*'],
                '8' => ['8*'],
                '9' => ['9*'],
                '10' => ['10*'],
                '11' => ['11*'],
            ],
            'grup_tavanlari' => [
                '2' => 25,
                '4' => 10,
                '5' => 20,
                '6' => 10,
                '7' => 4,
                '9' => 25,
                '10' => 4,
                '11' => 25,
            ],
        ],
        'selcuk-2024-filoloji' => [
            'kapsam_notu' => 'Çok yazarlı eserlerde puan yönergenin yazar çarpanı tablosuna göre azaltılır; çarpan adayın yazar SIRASINA da bağlı olduğu için faaliyetinizde rolü ("tek / ilk / başlıca / ortak") işaretlemeniz gerekir. Rol veya yazar listesi boşsa en düşük çarpan uygulanır ya da hiç uygulanmaz. Atıflarda çarpan uygulanmaz. Puanlar Selçuk Üniversitesi Filoloji Temel Alanı Başvuru Şartları '
                .'Tablosundan. Kongre düzenleme kurulu görevleri, h-indeksi ve yurt dışı deneyim '
                .'koşulları, patent başvurusu ve sportif başarı kalemleri kaynak sözlüğünde '
                .'karşılıksız olduğu için girilmedi. Gerçek toplamınız burada görünenden yüksek '
                .'olabilir, düşük olamaz.',
            // Yönerge: başlıca yazar puanın yarısını alır, diğer yazarlar kalan yarıyı
            // eşit paylaşır (0,5/(n-1)). Başlıca yazar belirtilmemişse ve bildiri/kitap
            // gibi diğer yayınlarda puan yazarlar arasında eşit bölünür. ATIFLARDA
            // yazar sayısına bakılmaksızın tüm yazarlar tam puan alır.
            //
            // "Lisansüstü tez ve projelerden yapılan makalelerde azaltma katsayısı
            // uygulanmaz" istisnası girilemedi: faaliyet kaydı bir makalenin tezden
            // üretilip üretilmediğini tutmuyor. O makalelerde puan olduğundan DÜŞÜK
            // görünür.
            'yazar_katsayisi' => [
                'haric' => ['atif'],
                'roller' => [
                    'tek' => ['kademeler' => [1 => 1.0]],
                    'ilk' => ['kademeler' => [1 => 1.0], 'sonrasi' => 0.5],
                    'baslica' => ['kademeler' => [1 => 1.0], 'sonrasi' => 0.5],
                    'ortak' => ['kademeler' => [1 => 1.0], 'bol' => ['pay' => 0.5, 'eksi' => 1]],
                ],
            ],

            'maddeler' => [
                '1a' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 20],
                '1b' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 15],
                '1c' => ['baslik' => 'Diğer uluslararası indeksli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'puan' => 10],
                '1d' => ['baslik' => 'TR Dizin kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 10],
                '1e' => ['baslik' => 'Diğer ulusal hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'puan' => 4],
                '1f' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI kapsamındaki dergide derleme, editöre mektup, teknik not veya kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 5],
                '2a' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 20],
                '2c' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 15],
                '2d' => ['baslik' => 'Uluslararası yayınevi kitabında editörlük veya bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 8],
                '3a' => ['baslik' => 'SCI, SCIE, SSCI, AHCI, ESCI veya Scopus kapsamında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 3],
                '3b' => ['baslik' => 'Uluslararası yayınevi kitabında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 2],
                '3c' => ['baslik' => 'TR Dizin kapsamındaki dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
                '3d' => ['baslik' => 'Diğer uluslararası/ulusal kitap veya dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],
                '4a' => ['baslik' => 'Doktora veya eşdeğer uzmanlık tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 5],
                '4b' => ['baslik' => 'Yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 3],
                '5a' => ['baslik' => 'AB Çerçeve programı veya TÜBİTAK projesinde koordinatör/yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['yurutucu'], 'puan' => 15],
                '5b' => ['baslik' => 'AB Çerçeve programı veya TÜBİTAK projesinde araştırmacı veya danışman', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
                '5c' => ['baslik' => 'Kamu kurumu veya özel kuruluşla yapılan AR-GE/ÜR-GE projesi', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'puan' => 6],
                '5d' => ['baslik' => 'Üniversite dışı kamu kurumlarıyla yapılan araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'puan' => 4],
                '5e' => ['baslik' => 'Üniversite tarafından desteklenen araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'puan' => 4],
                '6a' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulmuş bildiri (poster hariç)', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 3],
                '6b' => ['baslik' => 'Ulusal bilimsel toplantıda sunulmuş bildiri (poster hariç)', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 2],
                '7a' => ['baslik' => 'Bir dönem yüksek lisans veya doktora dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
                '7b' => ['baslik' => 'Bir dönem önlisans veya lisans dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders'], 'puan' => 2],
                '8a' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 20],
                '8b' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 10],
                '8c' => ['baslik' => 'Tescil edilmiş faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım'], 'puan' => 5],
                '9a' => ['baslik' => 'YÖK ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü'], 'puan' => 25],
                '9d' => ['baslik' => 'TÜBİTAK Bilim veya Teşvik Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü'], 'puan' => 15],
                '9e' => ['baslik' => 'TÜBA GEBİP Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 5],
                '9f' => ['baslik' => 'TÜBA TESEP Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 3],
                '10a' => ['baslik' => 'SCI, SCIE, SSCI, AHCI, ESCI veya Scopus kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 2],
                '10b' => ['baslik' => 'BKCI veya Scopus kapsamındaki kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Kitap Editörlüğü'], 'puan' => 1],
                '10c' => ['baslik' => 'TR Dizin kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 1],
                '11a' => ['baslik' => 'Dekan, Başhekim, Enstitü/Konservatuvar/Yüksekokul/MYO Müdürü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 25],
                '11b' => ['baslik' => 'Dekan, Başhekim, Enstitü/Konservatuvar/Yüksekokul/MYO Müdür Yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.'], 'puan' => 15],
                '11c' => ['baslik' => 'Bölüm Başkanı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı'], 'puan' => 10],
                '11d' => ['baslik' => 'Bölüm Başkan Yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı'], 'puan' => 5],
                '11e' => ['baslik' => 'Rektörlüğe bağlı ofis/koordinatörlükte koordinatör', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 15],
                '11f' => ['baslik' => 'Rektörlüğe bağlı ofis/koordinatörlükte koordinatör yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 10],
                '11i' => ['baslik' => 'Rektörlüğe bağlı komisyon veya üniversite/fakülte kurulu üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Senato / Üniversite Yönetim Kurulu Üyesi'], 'puan' => 4],
                'KONGRE-BSK' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)'], 'puan' => 15],
                'KONGRE-UYE' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 5],
            ],
            'gruplar' => [
                '1' => ['1*'],
                '2' => ['2*'],
                '3' => ['3*'],
                '4' => ['4*'],
                '5' => ['5*'],
                '6' => ['6*'],
                '7' => ['7*'],
                '8' => ['8*'],
                '9' => ['9*'],
                '10' => ['10*'],
                '11' => ['11*'],
            ],
            'grup_tavanlari' => [
                '2' => 25,
                '3' => 30,
                '4' => 10,
                '5' => 20,
                '6' => 10,
                '7' => 4,
                '9' => 25,
                '10' => 4,
                '11' => 25,
            ],
        ],
        'selcuk-2024-guzel_sanatlar' => [
            'kapsam_notu' => 'Çok yazarlı eserlerde puan yönergenin yazar çarpanı tablosuna göre azaltılır; çarpan adayın yazar SIRASINA da bağlı olduğu için faaliyetinizde rolü ("tek / ilk / başlıca / ortak") işaretlemeniz gerekir. Rol veya yazar listesi boşsa en düşük çarpan uygulanır ya da hiç uygulanmaz. Atıflarda çarpan uygulanmaz. Puanlar Selçuk Üniversitesi Güzel Sanatlar Temel Alanı Başvuru Şartları '
                .'Tablosundan. Kongre düzenleme kurulu görevleri, h-indeksi ve yurt dışı deneyim '
                .'koşulları, patent başvurusu ve sportif başarı kalemleri kaynak sözlüğünde '
                .'karşılıksız olduğu için girilmedi. Gerçek toplamınız burada görünenden yüksek '
                .'olabilir, düşük olamaz.',
            // Yönerge: başlıca yazar puanın yarısını alır, diğer yazarlar kalan yarıyı
            // eşit paylaşır (0,5/(n-1)). Başlıca yazar belirtilmemişse ve bildiri/kitap
            // gibi diğer yayınlarda puan yazarlar arasında eşit bölünür. ATIFLARDA
            // yazar sayısına bakılmaksızın tüm yazarlar tam puan alır.
            //
            // "Lisansüstü tez ve projelerden yapılan makalelerde azaltma katsayısı
            // uygulanmaz" istisnası girilemedi: faaliyet kaydı bir makalenin tezden
            // üretilip üretilmediğini tutmuyor. O makalelerde puan olduğundan DÜŞÜK
            // görünür.
            'yazar_katsayisi' => [
                'haric' => ['atif'],
                'roller' => [
                    'tek' => ['kademeler' => [1 => 1.0]],
                    'ilk' => ['kademeler' => [1 => 1.0], 'sonrasi' => 0.5],
                    'baslica' => ['kademeler' => [1 => 1.0], 'sonrasi' => 0.5],
                    'ortak' => ['kademeler' => [1 => 1.0], 'bol' => ['pay' => 0.5, 'eksi' => 1]],
                ],
            ],

            'maddeler' => [
                '1a' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 20],
                '1b' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 15],
                '1c' => ['baslik' => 'TR Dizin kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 10],
                '1d' => ['baslik' => 'Diğer uluslararası indeksli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'puan' => 5],
                '1e' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI kapsamındaki dergide derleme, editöre mektup, teknik not veya kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 5],
                '2a-karma' => ['baslik' => 'Uluslararası grup/karma sanat etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)'], 'puan' => 5],
                '2a-kisisel' => ['baslik' => 'Uluslararası kişisel sanat etkinliği (sergi, konser, gösteri, dinleti, festival)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)'], 'puan' => 20],
                '2b-karma' => ['baslik' => 'Ulusal grup/karma sanat etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)'], 'puan' => 3],
                '2b-kisisel' => ['baslik' => 'Ulusal kişisel sanat etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)'], 'puan' => 15],
                '2e-karma' => ['baslik' => 'Bandrollü CD, plak, kaset, VCD veya DVD yayınında grup/karma yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Albüm / CD-DVD Katkısı'], 'puan' => 3],
                '2e-kisisel' => ['baslik' => 'Bandrollü CD, plak, kaset, VCD veya DVD yayınında kişisel yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Albüm / Konser Kaydı'], 'puan' => 15],
                '2g' => ['baslik' => 'Uluslararası yayınlanmış görsel-işitsel program, belgesel, film veya oyun', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Yönetmenlik (Sahne/Ekran)'], 'puan' => 10],
                '2h' => ['baslik' => 'Ulusal yayınlanmış görsel-işitsel program, belgesel, film veya oyun', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'], 'puan' => 5],
                '4a' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulmuş bildiri (poster hariç)', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 5],
                '4b' => ['baslik' => 'Ulusal bilimsel toplantıda sunulmuş bildiri (poster hariç)', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 3],
                '5a' => ['baslik' => 'SCI, SCIE, SSCI, AHCI, ESCI veya Scopus kapsamında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 3],
                '5b' => ['baslik' => 'Uluslararası yayınevi kitabında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 2],
                '5c' => ['baslik' => 'TR Dizin kapsamındaki dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
                '5d' => ['baslik' => 'Diğer uluslararası/ulusal kitap veya dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],
                '6a' => ['baslik' => 'AB Çerçeve programı veya TÜBİTAK projesinde koordinatör/yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['yurutucu'], 'puan' => 15],
                '6b' => ['baslik' => 'AB Çerçeve programı veya TÜBİTAK projesinde araştırmacı veya danışman', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
                '6c' => ['baslik' => 'Kamu kurumu veya özel kuruluşla yapılan AR-GE/ÜR-GE projesi', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'puan' => 6],
                '6d' => ['baslik' => 'Üniversite dışı kamu kurumlarıyla yapılan araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'puan' => 4],
                '6e' => ['baslik' => 'Üniversite tarafından desteklenen araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'puan' => 4],
                '7a' => ['baslik' => 'Doktora veya eşdeğer uzmanlık tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 5],
                '7b' => ['baslik' => 'Yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 3],
                '8a' => ['baslik' => 'Bir dönem yüksek lisans veya doktora dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
                '8b' => ['baslik' => 'Bir dönem önlisans veya lisans dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders'], 'puan' => 2],
                '9a' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 20],
                '9b' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 10],
                '9c' => ['baslik' => 'Tescil edilmiş faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım'], 'puan' => 5],
                '10a' => ['baslik' => 'YÖK ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü'], 'puan' => 25],
                '10d' => ['baslik' => 'TÜBİTAK Bilim veya Teşvik Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü'], 'puan' => 15],
                '10e' => ['baslik' => 'TÜBA GEBİP Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 5],
                '10f' => ['baslik' => 'TÜBA TESEP Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 3],
                '11a' => ['baslik' => 'SCI, SCIE, SSCI, AHCI, ESCI veya Scopus kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 2],
                '11b' => ['baslik' => 'BKCI veya Scopus kapsamındaki kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Kitap Editörlüğü'], 'puan' => 1],
                '11c' => ['baslik' => 'TR Dizin kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 1],
                '12a' => ['baslik' => 'Dekan, Başhekim, Enstitü/Konservatuvar/Yüksekokul/MYO Müdürü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 25],
                '12b' => ['baslik' => 'Dekan, Başhekim, Enstitü/Konservatuvar/Yüksekokul/MYO Müdür Yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.'], 'puan' => 15],
                '12c' => ['baslik' => 'Bölüm Başkanı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı'], 'puan' => 10],
                '12d' => ['baslik' => 'Bölüm Başkan Yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı'], 'puan' => 5],
                '12e' => ['baslik' => 'Rektörlüğe bağlı ofis/koordinatörlükte koordinatör', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 15],
                '12f' => ['baslik' => 'Rektörlüğe bağlı ofis/koordinatörlükte koordinatör yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 5],
                '12i' => ['baslik' => 'Rektörlüğe bağlı komisyon veya üniversite/fakülte kurulu üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Senato / Üniversite Yönetim Kurulu Üyesi'], 'puan' => 4],
                'KONGRE-BSK' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)'], 'puan' => 15],
                'KONGRE-UYE' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 5],
            ],
            'gruplar' => [
                '1' => ['1*'],
                '2' => ['2*'],
                '4' => ['4*'],
                '5' => ['5*'],
                '6' => ['6*'],
                '7' => ['7*'],
                '8' => ['8*'],
                '9' => ['9*'],
                '10' => ['10*'],
                '11' => ['11*'],
                '12' => ['12*'],
            ],
            'grup_tavanlari' => [
                '4' => 10,
                '6' => 20,
                '7' => 10,
                '8' => 4,
                '10' => 25,
                '11' => 4,
                '12' => 25,
            ],
        ],
        'selcuk-2024-hukuk' => [
            'kapsam_notu' => 'Çok yazarlı eserlerde puan yönergenin yazar çarpanı tablosuna göre azaltılır; çarpan adayın yazar SIRASINA da bağlı olduğu için faaliyetinizde rolü ("tek / ilk / başlıca / ortak") işaretlemeniz gerekir. Rol veya yazar listesi boşsa en düşük çarpan uygulanır ya da hiç uygulanmaz. Atıflarda çarpan uygulanmaz. Puanlar Selçuk Üniversitesi Hukuk Temel Alanı Başvuru Şartları '
                .'Tablosundan. Kongre düzenleme kurulu görevleri, h-indeksi ve yurt dışı deneyim '
                .'koşulları, patent başvurusu ve sportif başarı kalemleri kaynak sözlüğünde '
                .'karşılıksız olduğu için girilmedi. Gerçek toplamınız burada görünenden yüksek '
                .'olabilir, düşük olamaz.',
            // Yönerge: başlıca yazar puanın yarısını alır, diğer yazarlar kalan yarıyı
            // eşit paylaşır (0,5/(n-1)). Başlıca yazar belirtilmemişse ve bildiri/kitap
            // gibi diğer yayınlarda puan yazarlar arasında eşit bölünür. ATIFLARDA
            // yazar sayısına bakılmaksızın tüm yazarlar tam puan alır.
            //
            // "Lisansüstü tez ve projelerden yapılan makalelerde azaltma katsayısı
            // uygulanmaz" istisnası girilemedi: faaliyet kaydı bir makalenin tezden
            // üretilip üretilmediğini tutmuyor. O makalelerde puan olduğundan DÜŞÜK
            // görünür.
            'yazar_katsayisi' => [
                'haric' => ['atif'],
                'roller' => [
                    'tek' => ['kademeler' => [1 => 1.0]],
                    'ilk' => ['kademeler' => [1 => 1.0], 'sonrasi' => 0.5],
                    'baslica' => ['kademeler' => [1 => 1.0], 'sonrasi' => 0.5],
                    'ortak' => ['kademeler' => [1 => 1.0], 'bol' => ['pay' => 0.5, 'eksi' => 1]],
                ],
            ],

            'maddeler' => [
                '1a' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 20],
                '1b' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 15],
                '1c' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI kapsamındaki dergide derleme, editöre mektup, teknik not veya kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 5],
                '2a' => ['baslik' => 'TR Dizin kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 10],
                '2b' => ['baslik' => 'Diğer ulusal hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'puan' => 5],
                '3a' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 25],
                '3b' => ['baslik' => 'Ulusal yayınevi kitabında editörlük veya bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 10],
                '3d' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 15],
                '4a' => ['baslik' => 'SCI, SCIE, SSCI, AHCI, ESCI veya Scopus kapsamında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 3],
                '4b' => ['baslik' => 'Uluslararası yayınevi kitabında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 2],
                '4c' => ['baslik' => 'TR Dizin kapsamındaki dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
                '4d' => ['baslik' => 'Diğer uluslararası/ulusal kitap veya dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],
                '5a' => ['baslik' => 'Doktora veya eşdeğer uzmanlık tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 5],
                '5b' => ['baslik' => 'Yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 3],
                '6a' => ['baslik' => 'AB Çerçeve programı veya TÜBİTAK projesinde koordinatör/yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['yurutucu'], 'puan' => 15],
                '6b' => ['baslik' => 'AB Çerçeve programı veya TÜBİTAK projesinde araştırmacı veya danışman', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
                '6c' => ['baslik' => 'Kamu kurumu veya özel kuruluşla yapılan AR-GE/ÜR-GE projesi', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'puan' => 6],
                '6d' => ['baslik' => 'Üniversite dışı kamu kurumlarıyla yapılan araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'puan' => 4],
                '6e' => ['baslik' => 'Üniversite tarafından desteklenen araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'puan' => 4],
                '7a' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulmuş bildiri (poster hariç)', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 3],
                '7b' => ['baslik' => 'Ulusal bilimsel toplantıda sunulmuş bildiri (poster hariç)', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 2],
                '8a' => ['baslik' => 'Bir dönem yüksek lisans veya doktora dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
                '8b' => ['baslik' => 'Bir dönem önlisans veya lisans dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders'], 'puan' => 2],
                '9a' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 20],
                '9b' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 10],
                '9c' => ['baslik' => 'Tescil edilmiş faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım'], 'puan' => 5],
                '10a' => ['baslik' => 'YÖK ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü'], 'puan' => 25],
                '10d' => ['baslik' => 'TÜBİTAK Bilim veya Teşvik Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü'], 'puan' => 15],
                '10e' => ['baslik' => 'TÜBA GEBİP Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 5],
                '10f' => ['baslik' => 'TÜBA TESEP Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 3],
                '11a' => ['baslik' => 'SCI, SCIE, SSCI, AHCI, ESCI veya Scopus kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 2],
                '11b' => ['baslik' => 'BKCI veya Scopus kapsamındaki kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Kitap Editörlüğü'], 'puan' => 1],
                '11c' => ['baslik' => 'TR Dizin kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 1],
                '12a' => ['baslik' => 'Dekan, Başhekim, Enstitü/Konservatuvar/Yüksekokul/MYO Müdürü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 25],
                '12b' => ['baslik' => 'Dekan, Başhekim, Enstitü/Konservatuvar/Yüksekokul/MYO Müdür Yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.'], 'puan' => 15],
                '12c' => ['baslik' => 'Bölüm Başkanı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı'], 'puan' => 10],
                '12d' => ['baslik' => 'Bölüm Başkan Yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı'], 'puan' => 5],
                '12e' => ['baslik' => 'Rektörlüğe bağlı ofis/koordinatörlükte koordinatör', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 15],
                '12f' => ['baslik' => 'Rektörlüğe bağlı ofis/koordinatörlükte koordinatör yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 5],
                '12i' => ['baslik' => 'Rektörlüğe bağlı komisyon veya üniversite/fakülte kurulu üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Senato / Üniversite Yönetim Kurulu Üyesi'], 'puan' => 4],
                'KONGRE-BSK' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)'], 'puan' => 15],
                'KONGRE-UYE' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 5],
            ],
            'gruplar' => [
                '1' => ['1*'],
                '2' => ['2*'],
                '3' => ['3*'],
                '4' => ['4*'],
                '5' => ['5*'],
                '6' => ['6*'],
                '7' => ['7*'],
                '8' => ['8*'],
                '9' => ['9*'],
                '10' => ['10*'],
                '11' => ['11*'],
                '12' => ['12*'],
            ],
            'grup_tavanlari' => [
                '3' => 25,
                '5' => 10,
                '6' => 20,
                '7' => 10,
                '8' => 4,
                '10' => 25,
                '11' => 4,
                '12' => 25,
            ],
        ],
        'selcuk-2024-ilahiyat' => [
            'kapsam_notu' => 'Çok yazarlı eserlerde puan yönergenin yazar çarpanı tablosuna göre azaltılır; çarpan adayın yazar SIRASINA da bağlı olduğu için faaliyetinizde rolü ("tek / ilk / başlıca / ortak") işaretlemeniz gerekir. Rol veya yazar listesi boşsa en düşük çarpan uygulanır ya da hiç uygulanmaz. Atıflarda çarpan uygulanmaz. Puanlar Selçuk Üniversitesi İlahiyat Temel Alanı Başvuru Şartları '
                .'Tablosundan. Kongre düzenleme kurulu görevleri, h-indeksi ve yurt dışı deneyim '
                .'koşulları, patent başvurusu ve sportif başarı kalemleri kaynak sözlüğünde '
                .'karşılıksız olduğu için girilmedi. Gerçek toplamınız burada görünenden yüksek '
                .'olabilir, düşük olamaz.',
            // Yönerge: başlıca yazar puanın yarısını alır, diğer yazarlar kalan yarıyı
            // eşit paylaşır (0,5/(n-1)). Başlıca yazar belirtilmemişse ve bildiri/kitap
            // gibi diğer yayınlarda puan yazarlar arasında eşit bölünür. ATIFLARDA
            // yazar sayısına bakılmaksızın tüm yazarlar tam puan alır.
            //
            // "Lisansüstü tez ve projelerden yapılan makalelerde azaltma katsayısı
            // uygulanmaz" istisnası girilemedi: faaliyet kaydı bir makalenin tezden
            // üretilip üretilmediğini tutmuyor. O makalelerde puan olduğundan DÜŞÜK
            // görünür.
            'yazar_katsayisi' => [
                'haric' => ['atif'],
                'roller' => [
                    'tek' => ['kademeler' => [1 => 1.0]],
                    'ilk' => ['kademeler' => [1 => 1.0], 'sonrasi' => 0.5],
                    'baslica' => ['kademeler' => [1 => 1.0], 'sonrasi' => 0.5],
                    'ortak' => ['kademeler' => [1 => 1.0], 'bol' => ['pay' => 0.5, 'eksi' => 1]],
                ],
            ],

            'maddeler' => [
                '1a' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 20],
                '1b' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 15],
                '1c' => ['baslik' => 'TR Dizin kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 10],
                '1e' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI kapsamındaki dergide derleme, editöre mektup, teknik not veya kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 5],
                '1f' => ['baslik' => 'Diğer ulusal hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'puan' => 4],
                '2a' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 20],
                '2b' => ['baslik' => 'Kitap bölümü çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 10],
                '2c' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 15],
                '2e' => ['baslik' => 'Ulusal yayınevi kitabında editörlük veya bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 5],
                '3a' => ['baslik' => 'SCI, SCIE, SSCI, AHCI, ESCI veya Scopus kapsamında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 3],
                '3b' => ['baslik' => 'Uluslararası yayınevi kitabında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 2],
                '3c' => ['baslik' => 'TR Dizin kapsamındaki dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
                '3d' => ['baslik' => 'Diğer uluslararası/ulusal kitap veya dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],
                '4a' => ['baslik' => 'Doktora veya eşdeğer uzmanlık tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 5],
                '4b' => ['baslik' => 'Yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 3],
                '5a' => ['baslik' => 'AB Çerçeve programı veya TÜBİTAK projesinde koordinatör/yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['yurutucu'], 'puan' => 15],
                '5b' => ['baslik' => 'AB Çerçeve programı veya TÜBİTAK projesinde araştırmacı veya danışman', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
                '5c' => ['baslik' => 'Kamu kurumu veya özel kuruluşla yapılan AR-GE/ÜR-GE projesi', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'puan' => 6],
                '5d' => ['baslik' => 'Üniversite dışı kamu kurumlarıyla yapılan araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'puan' => 4],
                '5e' => ['baslik' => 'Üniversite tarafından desteklenen araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'puan' => 4],
                '6a' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulmuş bildiri (poster hariç)', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 3],
                '6b' => ['baslik' => 'Ulusal bilimsel toplantıda sunulmuş bildiri (poster hariç)', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 2],
                '7a' => ['baslik' => 'Bir dönem yüksek lisans veya doktora dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
                '7b' => ['baslik' => 'Bir dönem önlisans veya lisans dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders'], 'puan' => 2],
                '8a' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 20],
                '8b' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 10],
                '8c' => ['baslik' => 'Tescil edilmiş faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım'], 'puan' => 5],
                '9a' => ['baslik' => 'YÖK ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü'], 'puan' => 25],
                '9d' => ['baslik' => 'TÜBİTAK Bilim veya Teşvik Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü'], 'puan' => 15],
                '9e' => ['baslik' => 'TÜBA GEBİP Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 5],
                '9f' => ['baslik' => 'TÜBA TESEP Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 3],
                '10a' => ['baslik' => 'SCI, SCIE, SSCI, AHCI, ESCI veya Scopus kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 2],
                '10b' => ['baslik' => 'BKCI veya Scopus kapsamındaki kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Kitap Editörlüğü'], 'puan' => 1],
                '10c' => ['baslik' => 'TR Dizin kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 1],
                '11a' => ['baslik' => 'Dekan, Başhekim, Enstitü/Konservatuvar/Yüksekokul/MYO Müdürü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 25],
                '11b' => ['baslik' => 'Dekan, Başhekim, Enstitü/Konservatuvar/Yüksekokul/MYO Müdür Yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.'], 'puan' => 15],
                '11c' => ['baslik' => 'Bölüm Başkanı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı'], 'puan' => 10],
                '11d' => ['baslik' => 'Bölüm Başkan Yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı'], 'puan' => 5],
                '11e' => ['baslik' => 'Rektörlüğe bağlı ofis/koordinatörlükte koordinatör', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 15],
                '11f' => ['baslik' => 'Rektörlüğe bağlı ofis/koordinatörlükte koordinatör yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 10],
                '11i' => ['baslik' => 'Rektörlüğe bağlı komisyon veya üniversite/fakülte kurulu üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Senato / Üniversite Yönetim Kurulu Üyesi'], 'puan' => 4],
                'KONGRE-BSK' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)'], 'puan' => 15],
                'KONGRE-UYE' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 5],
            ],
            'gruplar' => [
                '1' => ['1*'],
                '2' => ['2*'],
                '3' => ['3*'],
                '4' => ['4*'],
                '5' => ['5*'],
                '6' => ['6*'],
                '7' => ['7*'],
                '8' => ['8*'],
                '9' => ['9*'],
                '10' => ['10*'],
                '11' => ['11*'],
            ],
            'grup_tavanlari' => [
                '2' => 25,
                '4' => 10,
                '5' => 20,
                '6' => 10,
                '7' => 4,
                '9' => 25,
                '10' => 4,
                '11' => 25,
            ],
        ],
        'selcuk-2024-mimarlik' => [
            'kapsam_notu' => 'Çok yazarlı eserlerde puan yönergenin yazar çarpanı tablosuna göre azaltılır; çarpan adayın yazar SIRASINA da bağlı olduğu için faaliyetinizde rolü ("tek / ilk / başlıca / ortak") işaretlemeniz gerekir. Rol veya yazar listesi boşsa en düşük çarpan uygulanır ya da hiç uygulanmaz. Atıflarda çarpan uygulanmaz. Puanlar Selçuk Üniversitesi Mimarlık ve Tasarım Temel Alanı Başvuru Şartları '
                .'Tablosundan. Kongre düzenleme kurulu görevleri, h-indeksi ve yurt dışı deneyim '
                .'koşulları, patent başvurusu ve sportif başarı kalemleri kaynak sözlüğünde '
                .'karşılıksız olduğu için girilmedi. Gerçek toplamınız burada görünenden yüksek '
                .'olabilir, düşük olamaz.',
            // Yönerge: başlıca yazar puanın yarısını alır, diğer yazarlar kalan yarıyı
            // eşit paylaşır (0,5/(n-1)). Başlıca yazar belirtilmemişse ve bildiri/kitap
            // gibi diğer yayınlarda puan yazarlar arasında eşit bölünür. ATIFLARDA
            // yazar sayısına bakılmaksızın tüm yazarlar tam puan alır.
            //
            // "Lisansüstü tez ve projelerden yapılan makalelerde azaltma katsayısı
            // uygulanmaz" istisnası girilemedi: faaliyet kaydı bir makalenin tezden
            // üretilip üretilmediğini tutmuyor. O makalelerde puan olduğundan DÜŞÜK
            // görünür.
            'yazar_katsayisi' => [
                'haric' => ['atif'],
                'roller' => [
                    'tek' => ['kademeler' => [1 => 1.0]],
                    'ilk' => ['kademeler' => [1 => 1.0], 'sonrasi' => 0.5],
                    'baslica' => ['kademeler' => [1 => 1.0], 'sonrasi' => 0.5],
                    'ortak' => ['kademeler' => [1 => 1.0], 'bol' => ['pay' => 0.5, 'eksi' => 1]],
                ],
            ],

            'maddeler' => [
                '1a' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 20],
                '1b' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 15],
                '1c' => ['baslik' => 'TR Dizin kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 10],
                '1d' => ['baslik' => 'Diğer uluslararası indeksli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'puan' => 8],
                '1e' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI kapsamındaki dergide derleme, editöre mektup, teknik not veya kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 5],
                '2a' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 20],
                '2c' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 15],
                '2d' => ['baslik' => 'Uluslararası yayınevi kitabında editörlük veya bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 8],
                '4a' => ['baslik' => 'SCI, SCIE, SSCI, AHCI, ESCI veya Scopus kapsamında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 3],
                '4b' => ['baslik' => 'Uluslararası yayınevi kitabında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 2],
                '4c' => ['baslik' => 'TR Dizin kapsamındaki dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
                '4d' => ['baslik' => 'Diğer uluslararası/ulusal kitap veya dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],
                '5a' => ['baslik' => 'Doktora veya eşdeğer uzmanlık tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 5],
                '5b' => ['baslik' => 'Yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 3],
                '6a' => ['baslik' => 'AB Çerçeve programı veya TÜBİTAK projesinde koordinatör/yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['yurutucu'], 'puan' => 15],
                '6b' => ['baslik' => 'AB Çerçeve programı veya TÜBİTAK projesinde araştırmacı veya danışman', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
                '6c' => ['baslik' => 'Kamu kurumu veya özel kuruluşla yapılan AR-GE/ÜR-GE projesi', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'puan' => 6],
                '6d' => ['baslik' => 'Üniversite dışı kamu kurumlarıyla yapılan araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'puan' => 4],
                '6e' => ['baslik' => 'Üniversite tarafından desteklenen araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'puan' => 4],
                '7a' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulmuş bildiri (poster hariç)', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 3],
                '7b' => ['baslik' => 'Ulusal bilimsel toplantıda sunulmuş bildiri (poster hariç)', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 2],
                '8a' => ['baslik' => 'Bir dönem yüksek lisans veya doktora dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
                '8b' => ['baslik' => 'Bir dönem önlisans veya lisans dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders'], 'puan' => 2],
                '9a' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 20],
                '9b' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 10],
                '9c' => ['baslik' => 'Tescil edilmiş faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım'], 'puan' => 5],
                '10a' => ['baslik' => 'YÖK ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü'], 'puan' => 25],
                '10d' => ['baslik' => 'TÜBİTAK Bilim veya Teşvik Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü'], 'puan' => 15],
                '10e' => ['baslik' => 'TÜBA GEBİP Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 5],
                '10f' => ['baslik' => 'TÜBA TESEP Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 3],
                '11a' => ['baslik' => 'SCI, SCIE, SSCI, AHCI, ESCI veya Scopus kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 2],
                '11b' => ['baslik' => 'BKCI veya Scopus kapsamındaki kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Kitap Editörlüğü'], 'puan' => 1],
                '11c' => ['baslik' => 'TR Dizin kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 1],
                'KONGRE-BSK' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)'], 'puan' => 15],
                'KONGRE-UYE' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 5],
            ],
            'gruplar' => [
                '1' => ['1*'],
                '2' => ['2*'],
                '4' => ['4*'],
                '5' => ['5*'],
                '6' => ['6*'],
                '7' => ['7*'],
                '8' => ['8*'],
                '9' => ['9*'],
                '10' => ['10*'],
                '11' => ['11*'],
            ],
            'grup_tavanlari' => [
                '2' => 25,
                '5' => 10,
                '6' => 20,
                '7' => 10,
                '8' => 4,
                '10' => 25,
                '11' => 4,
            ],
        ],
        'selcuk-2024-muhendislik' => [
            'kapsam_notu' => 'Çok yazarlı eserlerde puan yönergenin yazar çarpanı tablosuna göre azaltılır; çarpan adayın yazar SIRASINA da bağlı olduğu için faaliyetinizde rolü ("tek / ilk / başlıca / ortak") işaretlemeniz gerekir. Rol veya yazar listesi boşsa en düşük çarpan uygulanır ya da hiç uygulanmaz. Atıflarda çarpan uygulanmaz. Puanlar Selçuk Üniversitesi Mühendislik Temel Alanı Başvuru Şartları '
                .'Tablosundan. Kongre düzenleme kurulu görevleri, h-indeksi ve yurt dışı deneyim '
                .'koşulları, patent başvurusu ve sportif başarı kalemleri kaynak sözlüğünde '
                .'karşılıksız olduğu için girilmedi. Gerçek toplamınız burada görünenden yüksek '
                .'olabilir, düşük olamaz.',
            // Yönerge: başlıca yazar puanın yarısını alır, diğer yazarlar kalan yarıyı
            // eşit paylaşır (0,5/(n-1)). Başlıca yazar belirtilmemişse ve bildiri/kitap
            // gibi diğer yayınlarda puan yazarlar arasında eşit bölünür. ATIFLARDA
            // yazar sayısına bakılmaksızın tüm yazarlar tam puan alır.
            //
            // "Lisansüstü tez ve projelerden yapılan makalelerde azaltma katsayısı
            // uygulanmaz" istisnası girilemedi: faaliyet kaydı bir makalenin tezden
            // üretilip üretilmediğini tutmuyor. O makalelerde puan olduğundan DÜŞÜK
            // görünür.
            'yazar_katsayisi' => [
                'haric' => ['atif'],
                'roller' => [
                    'tek' => ['kademeler' => [1 => 1.0]],
                    'ilk' => ['kademeler' => [1 => 1.0], 'sonrasi' => 0.5],
                    'baslica' => ['kademeler' => [1 => 1.0], 'sonrasi' => 0.5],
                    'ortak' => ['kademeler' => [1 => 1.0], 'bol' => ['pay' => 0.5, 'eksi' => 1]],
                ],
            ],

            'maddeler' => [
                '1a' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 20],
                '1b' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 15],
                '1c' => ['baslik' => 'TR Dizin kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 10],
                '1d' => ['baslik' => 'Diğer uluslararası indeksli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'puan' => 8],
                '1e' => ['baslik' => 'Diğer ulusal hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'puan' => 5],
                '1f' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI kapsamındaki dergide derleme, editöre mektup, teknik not veya kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 5],
                '2a' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 20],
                '2c' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 15],
                '2d' => ['baslik' => 'Uluslararası yayınevi kitabında editörlük veya bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 8],
                '3a' => ['baslik' => 'SCI, SCIE, SSCI, AHCI, ESCI veya Scopus kapsamında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 3],
                '3b' => ['baslik' => 'Uluslararası yayınevi kitabında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 2],
                '3c' => ['baslik' => 'TR Dizin kapsamındaki dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
                '3d' => ['baslik' => 'Diğer uluslararası/ulusal kitap veya dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],
                '4a' => ['baslik' => 'Doktora veya eşdeğer uzmanlık tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 5],
                '4b' => ['baslik' => 'Yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 3],
                '5a' => ['baslik' => 'AB Çerçeve programı veya TÜBİTAK projesinde koordinatör/yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['yurutucu'], 'puan' => 15],
                '5b' => ['baslik' => 'AB Çerçeve programı veya TÜBİTAK projesinde araştırmacı veya danışman', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
                '5c' => ['baslik' => 'Kamu kurumu veya özel kuruluşla yapılan AR-GE/ÜR-GE projesi', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'puan' => 6],
                '5d' => ['baslik' => 'Üniversite dışı kamu kurumlarıyla yapılan araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'puan' => 4],
                '5e' => ['baslik' => 'Üniversite tarafından desteklenen araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'puan' => 4],
                '6a' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulmuş bildiri (poster hariç)', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 3],
                '6b' => ['baslik' => 'Ulusal bilimsel toplantıda sunulmuş bildiri (poster hariç)', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 2],
                '7a' => ['baslik' => 'Bir dönem yüksek lisans veya doktora dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
                '7b' => ['baslik' => 'Bir dönem önlisans veya lisans dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders'], 'puan' => 2],
                '8a' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 20],
                '8b' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 10],
                '8c' => ['baslik' => 'Tescil edilmiş faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım'], 'puan' => 5],
                '9a' => ['baslik' => 'YÖK ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü'], 'puan' => 25],
                '9d' => ['baslik' => 'TÜBİTAK Bilim veya Teşvik Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü'], 'puan' => 15],
                '9e' => ['baslik' => 'TÜBA GEBİP Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 5],
                '9f' => ['baslik' => 'TÜBA TESEP Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 3],
                '10a' => ['baslik' => 'SCI, SCIE, SSCI, AHCI, ESCI veya Scopus kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 2],
                '10b' => ['baslik' => 'BKCI veya Scopus kapsamındaki kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Kitap Editörlüğü'], 'puan' => 1],
                '10c' => ['baslik' => 'TR Dizin kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 1],
                '11a' => ['baslik' => 'Dekan, Başhekim, Enstitü/Konservatuvar/Yüksekokul/MYO Müdürü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 25],
                '11b' => ['baslik' => 'Dekan, Başhekim, Enstitü/Konservatuvar/Yüksekokul/MYO Müdür Yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.'], 'puan' => 15],
                '11c' => ['baslik' => 'Bölüm Başkanı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı'], 'puan' => 10],
                '11d' => ['baslik' => 'Bölüm Başkan Yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı'], 'puan' => 5],
                '11e' => ['baslik' => 'Rektörlüğe bağlı ofis/koordinatörlükte koordinatör', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 15],
                '11f' => ['baslik' => 'Rektörlüğe bağlı ofis/koordinatörlükte koordinatör yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 10],
                '11i' => ['baslik' => 'Rektörlüğe bağlı komisyon veya üniversite/fakülte kurulu üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Senato / Üniversite Yönetim Kurulu Üyesi'], 'puan' => 4],
                'KONGRE-BSK' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)'], 'puan' => 15],
                'KONGRE-UYE' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 5],
            ],
            'gruplar' => [
                '1' => ['1*'],
                '2' => ['2*'],
                '3' => ['3*'],
                '4' => ['4*'],
                '5' => ['5*'],
                '6' => ['6*'],
                '7' => ['7*'],
                '8' => ['8*'],
                '9' => ['9*'],
                '10' => ['10*'],
                '11' => ['11*'],
            ],
            'grup_tavanlari' => [
                '2' => 25,
                '4' => 10,
                '5' => 20,
                '6' => 10,
                '7' => 4,
                '9' => 25,
                '10' => 4,
                '11' => 25,
            ],
        ],
        'selcuk-2024-saglik' => [
            'kapsam_notu' => 'Çok yazarlı eserlerde puan yönergenin yazar çarpanı tablosuna göre azaltılır; çarpan adayın yazar SIRASINA da bağlı olduğu için faaliyetinizde rolü ("tek / ilk / başlıca / ortak") işaretlemeniz gerekir. Rol veya yazar listesi boşsa en düşük çarpan uygulanır ya da hiç uygulanmaz. Atıflarda çarpan uygulanmaz. Puanlar Selçuk Üniversitesi Sağlık Bilimleri Temel Alanı Başvuru Şartları '
                .'Tablosundan. Kongre düzenleme kurulu görevleri, h-indeksi ve yurt dışı deneyim '
                .'koşulları, patent başvurusu ve sportif başarı kalemleri kaynak sözlüğünde '
                .'karşılıksız olduğu için girilmedi. Gerçek toplamınız burada görünenden yüksek '
                .'olabilir, düşük olamaz.',
            // Yönerge: başlıca yazar puanın yarısını alır, diğer yazarlar kalan yarıyı
            // eşit paylaşır (0,5/(n-1)). Başlıca yazar belirtilmemişse ve bildiri/kitap
            // gibi diğer yayınlarda puan yazarlar arasında eşit bölünür. ATIFLARDA
            // yazar sayısına bakılmaksızın tüm yazarlar tam puan alır.
            //
            // "Lisansüstü tez ve projelerden yapılan makalelerde azaltma katsayısı
            // uygulanmaz" istisnası girilemedi: faaliyet kaydı bir makalenin tezden
            // üretilip üretilmediğini tutmuyor. O makalelerde puan olduğundan DÜŞÜK
            // görünür.
            'yazar_katsayisi' => [
                'haric' => ['atif'],
                'roller' => [
                    'tek' => ['kademeler' => [1 => 1.0]],
                    'ilk' => ['kademeler' => [1 => 1.0], 'sonrasi' => 0.5],
                    'baslica' => ['kademeler' => [1 => 1.0], 'sonrasi' => 0.5],
                    'ortak' => ['kademeler' => [1 => 1.0], 'bol' => ['pay' => 0.5, 'eksi' => 1]],
                ],
            ],

            'maddeler' => [
                '1a' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 20],
                '1b' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 15],
                '1c' => ['baslik' => 'TR Dizin kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 10],
                '1d' => ['baslik' => 'Diğer uluslararası indeksli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'puan' => 8],
                '1e' => ['baslik' => 'Diğer ulusal hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'puan' => 4],
                '1f' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI kapsamındaki dergide derleme, editöre mektup, teknik not veya kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 5],
                '2a' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 20],
                '2c' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 15],
                '2d' => ['baslik' => 'Uluslararası yayınevi kitabında editörlük veya bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 8],
                '3a' => ['baslik' => 'SCI, SCIE, SSCI, AHCI, ESCI veya Scopus kapsamında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 3],
                '3b' => ['baslik' => 'Uluslararası yayınevi kitabında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 2],
                '3c' => ['baslik' => 'TR Dizin kapsamındaki dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
                '3d' => ['baslik' => 'Diğer uluslararası/ulusal kitap veya dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],
                '4a' => ['baslik' => 'Doktora veya eşdeğer uzmanlık tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 5],
                '4b' => ['baslik' => 'Yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 3],
                '5a' => ['baslik' => 'AB Çerçeve programı veya TÜBİTAK projesinde koordinatör/yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['yurutucu'], 'puan' => 15],
                '5b' => ['baslik' => 'AB Çerçeve programı veya TÜBİTAK projesinde araştırmacı veya danışman', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
                '5c' => ['baslik' => 'Kamu kurumu veya özel kuruluşla yapılan AR-GE/ÜR-GE projesi', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'puan' => 6],
                '5d' => ['baslik' => 'Üniversite dışı kamu kurumlarıyla yapılan araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'puan' => 4],
                '5e' => ['baslik' => 'Üniversite tarafından desteklenen araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'puan' => 4],
                '6a' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulmuş bildiri (poster hariç)', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 3],
                '6b' => ['baslik' => 'Ulusal bilimsel toplantıda sunulmuş bildiri (poster hariç)', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 2],
                '7a' => ['baslik' => 'Bir dönem yüksek lisans veya doktora dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
                '7b' => ['baslik' => 'Bir dönem önlisans veya lisans dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders'], 'puan' => 2],
                '8a' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 20],
                '8b' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 10],
                '8c' => ['baslik' => 'Tescil edilmiş faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım'], 'puan' => 5],
                '9a' => ['baslik' => 'YÖK ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü'], 'puan' => 25],
                '9d' => ['baslik' => 'TÜBİTAK Bilim veya Teşvik Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü'], 'puan' => 15],
                '9e' => ['baslik' => 'TÜBA GEBİP Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 5],
                '9f' => ['baslik' => 'TÜBA TESEP Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 3],
                '10a' => ['baslik' => 'SCI, SCIE, SSCI, AHCI, ESCI veya Scopus kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 2],
                '10b' => ['baslik' => 'BKCI veya Scopus kapsamındaki kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Kitap Editörlüğü'], 'puan' => 1],
                '10c' => ['baslik' => 'TR Dizin kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 1],
                '11a' => ['baslik' => 'Dekan, Başhekim, Enstitü/Konservatuvar/Yüksekokul/MYO Müdürü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 25],
                '11b' => ['baslik' => 'Dekan, Başhekim, Enstitü/Konservatuvar/Yüksekokul/MYO Müdür Yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.'], 'puan' => 15],
                '11c' => ['baslik' => 'Bölüm Başkanı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı'], 'puan' => 10],
                '11d' => ['baslik' => 'Bölüm Başkan Yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı'], 'puan' => 5],
                '11e' => ['baslik' => 'Rektörlüğe bağlı ofis/koordinatörlükte koordinatör', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 15],
                '11f' => ['baslik' => 'Rektörlüğe bağlı ofis/koordinatörlükte koordinatör yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 10],
                '11i' => ['baslik' => 'Rektörlüğe bağlı komisyon veya üniversite/fakülte kurulu üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Senato / Üniversite Yönetim Kurulu Üyesi'], 'puan' => 4],
                'KONGRE-BSK' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)'], 'puan' => 15],
                'KONGRE-UYE' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 5],
            ],
            'gruplar' => [
                '1' => ['1*'],
                '2' => ['2*'],
                '3' => ['3*'],
                '4' => ['4*'],
                '5' => ['5*'],
                '6' => ['6*'],
                '7' => ['7*'],
                '8' => ['8*'],
                '9' => ['9*'],
                '10' => ['10*'],
                '11' => ['11*'],
            ],
            'grup_tavanlari' => [
                '2' => 25,
                '4' => 10,
                '5' => 20,
                '6' => 10,
                '7' => 4,
                '9' => 25,
                '10' => 4,
                '11' => 25,
            ],
        ],
        'selcuk-2024-sosyal' => [
            'kapsam_notu' => 'Çok yazarlı eserlerde puan yönergenin yazar çarpanı tablosuna göre azaltılır; çarpan adayın yazar SIRASINA da bağlı olduğu için faaliyetinizde rolü ("tek / ilk / başlıca / ortak") işaretlemeniz gerekir. Rol veya yazar listesi boşsa en düşük çarpan uygulanır ya da hiç uygulanmaz. Atıflarda çarpan uygulanmaz. Puanlar Selçuk Üniversitesi Sosyal, Beşerî ve İdari Bilimler Temel Alanı Başvuru Şartları '
                .'Tablosundan. Kongre düzenleme kurulu görevleri, h-indeksi ve yurt dışı deneyim '
                .'koşulları, patent başvurusu ve sportif başarı kalemleri kaynak sözlüğünde '
                .'karşılıksız olduğu için girilmedi. Gerçek toplamınız burada görünenden yüksek '
                .'olabilir, düşük olamaz.',
            // Yönerge: başlıca yazar puanın yarısını alır, diğer yazarlar kalan yarıyı
            // eşit paylaşır (0,5/(n-1)). Başlıca yazar belirtilmemişse ve bildiri/kitap
            // gibi diğer yayınlarda puan yazarlar arasında eşit bölünür. ATIFLARDA
            // yazar sayısına bakılmaksızın tüm yazarlar tam puan alır.
            //
            // "Lisansüstü tez ve projelerden yapılan makalelerde azaltma katsayısı
            // uygulanmaz" istisnası girilemedi: faaliyet kaydı bir makalenin tezden
            // üretilip üretilmediğini tutmuyor. O makalelerde puan olduğundan DÜŞÜK
            // görünür.
            'yazar_katsayisi' => [
                'haric' => ['atif'],
                'roller' => [
                    'tek' => ['kademeler' => [1 => 1.0]],
                    'ilk' => ['kademeler' => [1 => 1.0], 'sonrasi' => 0.5],
                    'baslica' => ['kademeler' => [1 => 1.0], 'sonrasi' => 0.5],
                    'ortak' => ['kademeler' => [1 => 1.0], 'bol' => ['pay' => 0.5, 'eksi' => 1]],
                ],
            ],

            'maddeler' => [
                '1a' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 20],
                '1b' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 15],
                '1c' => ['baslik' => 'TR Dizin kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 10],
                '1d' => ['baslik' => 'Diğer uluslararası indeksli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'puan' => 8],
                '1e' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI kapsamındaki dergide derleme, editöre mektup, teknik not veya kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 5],
                '2a' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 20],
                '2c' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 15],
                '2d' => ['baslik' => 'Uluslararası yayınevi kitabında editörlük veya bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 8],
                '3a' => ['baslik' => 'SCI, SCIE, SSCI, AHCI, ESCI veya Scopus kapsamında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 3],
                '3b' => ['baslik' => 'Uluslararası yayınevi kitabında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 2],
                '3c' => ['baslik' => 'TR Dizin kapsamındaki dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
                '3d' => ['baslik' => 'Diğer uluslararası/ulusal kitap veya dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],
                '4a' => ['baslik' => 'Doktora veya eşdeğer uzmanlık tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 5],
                '4b' => ['baslik' => 'Yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 3],
                '5a' => ['baslik' => 'AB Çerçeve programı veya TÜBİTAK projesinde koordinatör/yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['yurutucu'], 'puan' => 15],
                '5b' => ['baslik' => 'AB Çerçeve programı veya TÜBİTAK projesinde araştırmacı veya danışman', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
                '5c' => ['baslik' => 'Kamu kurumu veya özel kuruluşla yapılan AR-GE/ÜR-GE projesi', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'puan' => 6],
                '5d' => ['baslik' => 'Üniversite dışı kamu kurumlarıyla yapılan araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'puan' => 4],
                '5e' => ['baslik' => 'Üniversite tarafından desteklenen araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'puan' => 4],
                '6a' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulmuş bildiri (poster hariç)', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 3],
                '6b' => ['baslik' => 'Ulusal bilimsel toplantıda sunulmuş bildiri (poster hariç)', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 2],
                '7a' => ['baslik' => 'Bir dönem yüksek lisans veya doktora dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
                '7b' => ['baslik' => 'Bir dönem önlisans veya lisans dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders'], 'puan' => 2],
                '8a' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 20],
                '8b' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 10],
                '8c' => ['baslik' => 'Tescil edilmiş faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım'], 'puan' => 5],
                '9a' => ['baslik' => 'YÖK ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü'], 'puan' => 25],
                '9d' => ['baslik' => 'TÜBİTAK Bilim veya Teşvik Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü'], 'puan' => 15],
                '9e' => ['baslik' => 'TÜBA GEBİP Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 5],
                '9f' => ['baslik' => 'TÜBA TESEP Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 3],
                '10a' => ['baslik' => 'SCI, SCIE, SSCI, AHCI, ESCI veya Scopus kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 2],
                '10b' => ['baslik' => 'BKCI veya Scopus kapsamındaki kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Kitap Editörlüğü'], 'puan' => 1],
                '10c' => ['baslik' => 'TR Dizin kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 1],
                '11a' => ['baslik' => 'Dekan, Başhekim, Enstitü/Konservatuvar/Yüksekokul/MYO Müdürü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 25],
                '11b' => ['baslik' => 'Dekan, Başhekim, Enstitü/Konservatuvar/Yüksekokul/MYO Müdür Yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.'], 'puan' => 15],
                '11c' => ['baslik' => 'Bölüm Başkanı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı'], 'puan' => 10],
                '11d' => ['baslik' => 'Bölüm Başkan Yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı'], 'puan' => 5],
                '11e' => ['baslik' => 'Rektörlüğe bağlı ofis/koordinatörlükte koordinatör', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 15],
                '11f' => ['baslik' => 'Rektörlüğe bağlı ofis/koordinatörlükte koordinatör yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 10],
                '11i' => ['baslik' => 'Rektörlüğe bağlı komisyon veya üniversite/fakülte kurulu üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Senato / Üniversite Yönetim Kurulu Üyesi'], 'puan' => 4],
                'KONGRE-BSK' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)'], 'puan' => 15],
                'KONGRE-UYE' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 5],
            ],
            'gruplar' => [
                '1' => ['1*'],
                '2' => ['2*'],
                '3' => ['3*'],
                '4' => ['4*'],
                '5' => ['5*'],
                '6' => ['6*'],
                '7' => ['7*'],
                '8' => ['8*'],
                '9' => ['9*'],
                '10' => ['10*'],
                '11' => ['11*'],
            ],
            'grup_tavanlari' => [
                '2' => 25,
                '4' => 10,
                '5' => 20,
                '6' => 10,
                '7' => 4,
                '9' => 25,
                '10' => 4,
                '11' => 25,
            ],
        ],
        'selcuk-2024-spor' => [
            'kapsam_notu' => 'Çok yazarlı eserlerde puan yönergenin yazar çarpanı tablosuna göre azaltılır; çarpan adayın yazar SIRASINA da bağlı olduğu için faaliyetinizde rolü ("tek / ilk / başlıca / ortak") işaretlemeniz gerekir. Rol veya yazar listesi boşsa en düşük çarpan uygulanır ya da hiç uygulanmaz. Atıflarda çarpan uygulanmaz. Puanlar Selçuk Üniversitesi Spor Bilimleri Temel Alanı Başvuru Şartları '
                .'Tablosundan. Kongre düzenleme kurulu görevleri, h-indeksi ve yurt dışı deneyim '
                .'koşulları, patent başvurusu ve sportif başarı kalemleri kaynak sözlüğünde '
                .'karşılıksız olduğu için girilmedi. Gerçek toplamınız burada görünenden yüksek '
                .'olabilir, düşük olamaz.',
            // Yönerge: başlıca yazar puanın yarısını alır, diğer yazarlar kalan yarıyı
            // eşit paylaşır (0,5/(n-1)). Başlıca yazar belirtilmemişse ve bildiri/kitap
            // gibi diğer yayınlarda puan yazarlar arasında eşit bölünür. ATIFLARDA
            // yazar sayısına bakılmaksızın tüm yazarlar tam puan alır.
            //
            // "Lisansüstü tez ve projelerden yapılan makalelerde azaltma katsayısı
            // uygulanmaz" istisnası girilemedi: faaliyet kaydı bir makalenin tezden
            // üretilip üretilmediğini tutmuyor. O makalelerde puan olduğundan DÜŞÜK
            // görünür.
            'yazar_katsayisi' => [
                'haric' => ['atif'],
                'roller' => [
                    'tek' => ['kademeler' => [1 => 1.0]],
                    'ilk' => ['kademeler' => [1 => 1.0], 'sonrasi' => 0.5],
                    'baslica' => ['kademeler' => [1 => 1.0], 'sonrasi' => 0.5],
                    'ortak' => ['kademeler' => [1 => 1.0], 'bol' => ['pay' => 0.5, 'eksi' => 1]],
                ],
            ],

            'maddeler' => [
                '1a' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 20],
                '1b' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 15],
                '1c' => ['baslik' => 'Diğer uluslararası indeksli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'puan' => 6],
                '1d' => ['baslik' => 'TR Dizin kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 8],
                '1e' => ['baslik' => 'Diğer ulusal hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'puan' => 4],
                '1f' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI kapsamındaki dergide derleme, editöre mektup, teknik not veya kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 5],
                '2a' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 20],
                '2b' => ['baslik' => 'Uluslararası yayınevi kitabında editörlük veya bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 10],
                '2c' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 15],
                '2d' => ['baslik' => 'Ulusal yayınevi kitabında editörlük veya bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 8],
                '2e' => ['baslik' => 'Kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 6],
                '2f' => ['baslik' => 'Kitap bölümü çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 4],
                '3a' => ['baslik' => 'SCI, SCIE, SSCI, AHCI, ESCI veya Scopus kapsamında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 3],
                '3b' => ['baslik' => 'Uluslararası yayınevi kitabında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 2],
                '3c' => ['baslik' => 'TR Dizin kapsamındaki dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
                '3d' => ['baslik' => 'Diğer uluslararası/ulusal kitap veya dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],
                '4a' => ['baslik' => 'Doktora veya eşdeğer uzmanlık tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 5],
                '4b' => ['baslik' => 'Yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 3],
                '5a' => ['baslik' => 'AB Çerçeve programı veya TÜBİTAK projesinde koordinatör/yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['yurutucu'], 'puan' => 15],
                '5b' => ['baslik' => 'AB Çerçeve programı veya TÜBİTAK projesinde araştırmacı veya danışman', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
                '5c' => ['baslik' => 'Kamu kurumu veya özel kuruluşla yapılan AR-GE/ÜR-GE projesi', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'puan' => 8],
                '5d' => ['baslik' => 'Diğer TÜBİTAK programı veya uluslararası destekli araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon', 'TÜSEB'], 'puan' => 6],
                '5f' => ['baslik' => 'Üniversite dışı kamu kurumlarıyla yapılan araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'puan' => 4],
                '5g' => ['baslik' => 'Üniversite tarafından desteklenen araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'puan' => 4],
                '6a' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulmuş bildiri (poster hariç)', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 3],
                '6b' => ['baslik' => 'Ulusal bilimsel toplantıda sunulmuş bildiri (poster hariç)', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 2],
                '7a' => ['baslik' => 'Bir dönem yüksek lisans veya doktora dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
                '7b' => ['baslik' => 'Bir dönem önlisans veya lisans dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders'], 'puan' => 2],
                '9a' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 20],
                '9b' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 10],
                '9c' => ['baslik' => 'Tescil edilmiş faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım'], 'puan' => 5],
                '10a' => ['baslik' => 'YÖK ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü'], 'puan' => 25],
                '10d' => ['baslik' => 'TÜBİTAK Bilim veya Teşvik Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü'], 'puan' => 15],
                '10e' => ['baslik' => 'TÜBA GEBİP Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 5],
                '10f' => ['baslik' => 'TÜBA TESEP Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 3],
                '11a' => ['baslik' => 'SCI, SCIE, SSCI, AHCI, ESCI veya Scopus kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 2],
                '11b' => ['baslik' => 'BKCI veya Scopus kapsamındaki kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Kitap Editörlüğü'], 'puan' => 1],
                '11c' => ['baslik' => 'TR Dizin kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 1],
                '12a' => ['baslik' => 'Dekan, Başhekim, Enstitü/Konservatuvar/Yüksekokul/MYO Müdürü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 25],
                '12b' => ['baslik' => 'Dekan, Başhekim, Enstitü/Konservatuvar/Yüksekokul/MYO Müdür Yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.'], 'puan' => 15],
                '12c' => ['baslik' => 'Bölüm Başkanı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı'], 'puan' => 10],
                '12d' => ['baslik' => 'Bölüm Başkan Yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı'], 'puan' => 5],
                '12e' => ['baslik' => 'Rektörlüğe bağlı ofis/koordinatörlükte koordinatör', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 15],
                '12f' => ['baslik' => 'Rektörlüğe bağlı ofis/koordinatörlükte koordinatör yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 5],
                '12i' => ['baslik' => 'Rektörlüğe bağlı komisyon veya üniversite/fakülte kurulu üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Senato / Üniversite Yönetim Kurulu Üyesi'], 'puan' => 4],
                'KONGRE-BSK' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)'], 'puan' => 15],
                'KONGRE-UYE' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 5],
            ],
            'gruplar' => [
                '1' => ['1*'],
                '2' => ['2*'],
                '3' => ['3*'],
                '4' => ['4*'],
                '5' => ['5*'],
                '6' => ['6*'],
                '7' => ['7*'],
                '9' => ['9*'],
                '10' => ['10*'],
                '11' => ['11*'],
                '12' => ['12*'],
            ],
            'grup_tavanlari' => [
                '2' => 25,
                '4' => 10,
                '5' => 20,
                '6' => 10,
                '7' => 4,
                '10' => 25,
                '11' => 4,
                '12' => 25,
            ],
        ],
        'selcuk-2024-ziraat' => [
            'kapsam_notu' => 'Çok yazarlı eserlerde puan yönergenin yazar çarpanı tablosuna göre azaltılır; çarpan adayın yazar SIRASINA da bağlı olduğu için faaliyetinizde rolü ("tek / ilk / başlıca / ortak") işaretlemeniz gerekir. Rol veya yazar listesi boşsa en düşük çarpan uygulanır ya da hiç uygulanmaz. Atıflarda çarpan uygulanmaz. Puanlar Selçuk Üniversitesi Ziraat Temel Alanı Başvuru Şartları '
                .'Tablosundan. Kongre düzenleme kurulu görevleri, h-indeksi ve yurt dışı deneyim '
                .'koşulları, patent başvurusu ve sportif başarı kalemleri kaynak sözlüğünde '
                .'karşılıksız olduğu için girilmedi. Gerçek toplamınız burada görünenden yüksek '
                .'olabilir, düşük olamaz.',
            // Yönerge: başlıca yazar puanın yarısını alır, diğer yazarlar kalan yarıyı
            // eşit paylaşır (0,5/(n-1)). Başlıca yazar belirtilmemişse ve bildiri/kitap
            // gibi diğer yayınlarda puan yazarlar arasında eşit bölünür. ATIFLARDA
            // yazar sayısına bakılmaksızın tüm yazarlar tam puan alır.
            //
            // "Lisansüstü tez ve projelerden yapılan makalelerde azaltma katsayısı
            // uygulanmaz" istisnası girilemedi: faaliyet kaydı bir makalenin tezden
            // üretilip üretilmediğini tutmuyor. O makalelerde puan olduğundan DÜŞÜK
            // görünür.
            'yazar_katsayisi' => [
                'haric' => ['atif'],
                'roller' => [
                    'tek' => ['kademeler' => [1 => 1.0]],
                    'ilk' => ['kademeler' => [1 => 1.0], 'sonrasi' => 0.5],
                    'baslica' => ['kademeler' => [1 => 1.0], 'sonrasi' => 0.5],
                    'ortak' => ['kademeler' => [1 => 1.0], 'bol' => ['pay' => 0.5, 'eksi' => 1]],
                ],
            ],

            'maddeler' => [
                '1a' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 20],
                '1b' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 15],
                '1c' => ['baslik' => 'TR Dizin kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 10],
                '1d' => ['baslik' => 'Diğer uluslararası indeksli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'puan' => 8],
                '1e' => ['baslik' => 'Diğer ulusal hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'puan' => 4],
                '1f' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI kapsamındaki dergide derleme, editöre mektup, teknik not veya kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 5],
                '2a' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 20],
                '2c' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 15],
                '2d' => ['baslik' => 'Uluslararası yayınevi kitabında editörlük veya bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 8],
                '3a' => ['baslik' => 'SCI, SCIE, SSCI, AHCI, ESCI veya Scopus kapsamında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 3],
                '3b' => ['baslik' => 'Uluslararası yayınevi kitabında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 2],
                '3c' => ['baslik' => 'TR Dizin kapsamındaki dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
                '3d' => ['baslik' => 'Diğer uluslararası/ulusal kitap veya dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],
                '4a' => ['baslik' => 'Doktora veya eşdeğer uzmanlık tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 5],
                '4b' => ['baslik' => 'Yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 3],
                '5a' => ['baslik' => 'AB Çerçeve programı veya TÜBİTAK projesinde koordinatör/yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['yurutucu'], 'puan' => 15],
                '5b' => ['baslik' => 'AB Çerçeve programı veya TÜBİTAK projesinde araştırmacı veya danışman', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
                '5c' => ['baslik' => 'Kamu kurumu veya özel kuruluşla yapılan AR-GE/ÜR-GE projesi', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'puan' => 6],
                '5d' => ['baslik' => 'Üniversite dışı kamu kurumlarıyla yapılan araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'puan' => 4],
                '5e' => ['baslik' => 'Üniversite tarafından desteklenen araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'puan' => 4],
                '6a' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulmuş bildiri (poster hariç)', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 3],
                '6b' => ['baslik' => 'Ulusal bilimsel toplantıda sunulmuş bildiri (poster hariç)', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 2],
                '7a' => ['baslik' => 'Bir dönem yüksek lisans veya doktora dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
                '7b' => ['baslik' => 'Bir dönem önlisans veya lisans dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders'], 'puan' => 2],
                '8a' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 20],
                '8b' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 10],
                '8c' => ['baslik' => 'Tescil edilmiş faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım'], 'puan' => 5],
                '9a' => ['baslik' => 'YÖK ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü'], 'puan' => 25],
                '9d' => ['baslik' => 'TÜBİTAK Bilim veya Teşvik Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü'], 'puan' => 15],
                '9e' => ['baslik' => 'TÜBA GEBİP Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 5],
                '9f' => ['baslik' => 'TÜBA TESEP Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 3],
                '10a' => ['baslik' => 'SCI, SCIE, SSCI, AHCI, ESCI veya Scopus kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 2],
                '10b' => ['baslik' => 'BKCI veya Scopus kapsamındaki kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Kitap Editörlüğü'], 'puan' => 1],
                '10c' => ['baslik' => 'TR Dizin kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 1],
                '11a' => ['baslik' => 'Dekan, Başhekim, Enstitü/Konservatuvar/Yüksekokul/MYO Müdürü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 25],
                '11b' => ['baslik' => 'Dekan, Başhekim, Enstitü/Konservatuvar/Yüksekokul/MYO Müdür Yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.'], 'puan' => 15],
                '11c' => ['baslik' => 'Bölüm Başkanı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı'], 'puan' => 10],
                '11d' => ['baslik' => 'Bölüm Başkan Yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı'], 'puan' => 5],
                '11e' => ['baslik' => 'Rektörlüğe bağlı ofis/koordinatörlükte koordinatör', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 15],
                '11f' => ['baslik' => 'Rektörlüğe bağlı ofis/koordinatörlükte koordinatör yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 10],
                '11i' => ['baslik' => 'Rektörlüğe bağlı komisyon veya üniversite/fakülte kurulu üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Senato / Üniversite Yönetim Kurulu Üyesi'], 'puan' => 4],
                'KONGRE-BSK' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)'], 'puan' => 15],
                'KONGRE-UYE' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 5],
            ],
            'gruplar' => [
                '1' => ['1*'],
                '2' => ['2*'],
                '3' => ['3*'],
                '4' => ['4*'],
                '5' => ['5*'],
                '6' => ['6*'],
                '7' => ['7*'],
                '8' => ['8*'],
                '9' => ['9*'],
                '10' => ['10*'],
                '11' => ['11*'],
            ],
            'grup_tavanlari' => [
                '2' => 25,
                '4' => 10,
                '5' => 20,
                '6' => 10,
                '7' => 4,
                '9' => 25,
                '10' => 4,
                '11' => 25,
            ],
        ],
    ],
];
