<?php

/**
 * MARMARA ÜNİVERSİTESİ — Tablo 4
 * "Güzel Sanatlar Temel Alanı Puanlama Formu"
 * Kaynak: pdf/17537003632.marmarauniverstesi.pdf (s. 18-20)
 *
 * MADDE NUMARALARI yönergenin kendi numaralandırmasıdır. Güzel Sanatlar'ın
 * dr. öğr. üyeliği koşulu (md. 7/d-4) aralık kullanmıyor — "en az 42 puanı
 * kendi lisansüstü tezlerinden üretilmemiş olmak üzere tüm faaliyetlerden 90
 * puan" — ama doçentlik ve profesörlük koşulları aralık kullandığı için
 * numaralar yine birebir korundu.
 *
 * TABLO 4 SANAT SATIRLARINI BİLİM SATIRLARIYLA AYNI NUMARAYA KOYUYOR: 14b
 * karma sergi, 17b müzeye kabul, 18b bireysel sanat etkinliği, 23b jürili
 * sergi/festival/bienal gibi. Numaralar tek olduğu için sanat karşılıkları
 * `b`/`c` sonekiyle ayrıldı.
 *
 * 28 NUMARALI MÜZİK SATIRI ALTI ALT BENDE BÖLÜNÜYOR (eğitim müziği dizini
 * yaratmak/derlemek, yaratı formu çeşitlendirme, şeflik kaydı, özgün eser,
 * orkestra eşlikli kayıt). Kayıt sözlüğünde karşılığı olanlar girildi;
 * "yararlılığı beş uzman tarafından onanmış" koşulu beyana dayandığı için
 * eğitim müziği satırları girilmedi.
 *
 * PATENT (48) YALNIZ TESCİL EDİLMİŞ OLANLAR: "başvurduysa" alt satırı
 * başvuru aşamasını faaliyet olarak tutmadığımız için girilmedi.
 *
 * GİRİLMEYEN SATIRLAR: 27 (akademik organizasyon yöneticiliği ve
 * düzenleme kurulu üyeliği — kaynak sözlüğünde kongre düzenleme etiketi yok;
 * geniş bir "Diğer" kovasına bağlamak §0'a aykırı olurdu, fazla sayardı),
 * 16 (sorumlu yazar çarpanı), 22 (bireysel yarışma
 * derecesi — ulusal temsil görevi alt satırıyla birlikte), 43 (yükseltme
 * jürisi), 51 ve 52 (bilirkişilik, danışmanlık, atölye yöneticiliği).
 * Tablo 8'in idari faaliyetleri de girilmedi.
 *
 * 06.09.2026: bilimsel toplantı organizasyonu ailesi için altı etiket
 * açıldı (başkanlık · düzenleme/bilim kurulu üyeliği · oturum başkanlığı,
 * her biri uluslararası/ulusal). Yukarıdaki "sözlükte karşılıksız" notları
 * bu satırlar için artık geçerli değil.
 */

return [
    'kapsam_notu' => 'Puanlar Marmara Üniversitesi Tablo 4\'ten (Güzel Sanatlar). Belge 2018 '
        .'öncesi terminoloji kullanıyor; kadro adları güncel karşılıklarına eşlendi. Sorumlu '
        .'yazar çarpanı, bireysel yarışma dereceleri, eğitim müziği dizini satırları, patent '
        .'BAŞVURUSU, jüri görevleri, bilirkişilik ve atölye yöneticiliği ile idari '
        .'faaliyetler (Tablo 8) girilmedi. Gerçek toplamınız burada görünenden yüksek '
        .'olabilir, düşük olamaz.',

    'maddeler' => [
        // ── MAKALE ── (1-15)
        '1' => ['baslik' => 'Birincil indekslerde taranan dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 48],
        '3' => ['baslik' => 'İkincil indekslerde taranan dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale'], 'puan' => 36],
        '4' => ['baslik' => 'Birincil indekslerde taranan dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['derleme'], 'puan' => 30],
        '5' => ['baslik' => 'İkincil indekslerde taranan dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['derleme'], 'puan' => 24],
        '6' => ['baslik' => 'Hakemli ulusal dergide yabancı dilde makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale'], 'puan' => 18],
        '8' => ['baslik' => 'Hakemli ulusal dergide yabancı dilde derleme', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['derleme'], 'puan' => 12],
        '10' => ['baslik' => 'Hakemli ulusal dergide Türkçe makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale'], 'puan' => 18],
        '12' => ['baslik' => 'Hakemli ulusal dergide Türkçe derleme', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['derleme'], 'puan' => 6],
        '15' => ['baslik' => 'Hakemsiz dergide makale veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'puan' => 5],

        // ── KARMA SERGİ ve GÖSTERİLERE KATILIM ── (14b, 15c)
        '14b' => ['baslik' => 'Uluslararası karma sergi, gösteri veya çalıştaya katılım', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)'], 'puan' => 15],
        '15c' => ['baslik' => 'Ulusal karma sergi veya gösteriye katılım', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Jürisiz, Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 10],

        // ── KİTAP ve ÖZGÜN SANAT ÇALIŞMASI ── (17-21)
        '17' => ['baslik' => 'Uzmanlık alanında uluslararası kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 100],
        '17b' => ['baslik' => 'Uluslararası seçici kurullu müzede yer almış özgün sanat veya tasarım çalışması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)'], 'puan' => 80],
        '18' => ['baslik' => 'Uzmanlık alanında uluslararası kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 60],
        '18b' => ['baslik' => 'Özgün uluslararası bireysel sanat veya tasarım etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kamusal Alanda Uygulanmış Yapıt (Yurt Dışı)', 'Elektronik Kişisel Sergi (Uluslararası)'], 'puan' => 50],
        '19' => ['baslik' => 'Uzmanlık alanında ulusal kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı'], 'puan' => 70],
        '19b' => ['baslik' => 'Ulusal seçici kurullu müzede yer almış özgün sanat veya tasarım çalışması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Satın Alınması (Yurt İçi)', 'Eserin Yayında Yer Alması / Satın Alınması'], 'puan' => 50],
        '20' => ['baslik' => 'Uzmanlık alanında ulusal kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 20],
        '20b' => ['baslik' => 'Özgün ulusal bireysel sanat veya tasarım etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Kamusal Alanda Uygulanmış Yapıt (Yurt İçi)', 'Uygulanmış Tasarım / Koleksiyon', 'Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 20],
        '21' => ['baslik' => 'Uzmanlık alanında kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 25],
        '21b' => ['baslik' => 'Uzmanlık alanında makale veya bölüm çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 15],

        // ── BİLDİRİ ve JÜRİLİ SANAT ETKİNLİĞİ ── (23-26)
        '23' => ['baslik' => 'Uluslararası kongrede tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 24],
        '23b' => ['baslik' => 'Uluslararası seçici kurullu sergi, festival veya bienale eserinizin kabul edilmesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)'], 'puan' => 40],
        '24' => ['baslik' => 'Uluslararası kongrede özet bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 18],
        '24b' => ['baslik' => 'Uluslararası karma sergi veya sanat etkinliğine yapıtlarıyla katılma', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Elektronik Karma Sergi (Uluslararası)'], 'puan' => 18],
        '25' => ['baslik' => 'Ulusal kongrede tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 24],
        '25b' => ['baslik' => 'Ulusal seçici kurullu sergi, festival veya bienale eserinizin kabul edilmesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)'], 'puan' => 25],
        '26' => ['baslik' => 'Ulusal kongrede özet bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 12],
        '26b' => ['baslik' => 'Ulusal karma sergi veya sanat etkinliğine yapıtlarıyla katılma', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Elektronik Karma Sergi (Ulusal)'], 'puan' => 12],

        // ── MÜZİK ── (28)
        '28c' => ['baslik' => 'Yaratı formlarını çeşitlendirme ürünü vermek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestrasyon/Transkripsiyon', 'Eğitim Müziği Düzenlemesi'], 'puan' => 10],
        '28d' => ['baslik' => 'Şeflik ettiği seçkin eserlerden oluşan senfonik müzik kaydı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra Şefliği (Uluslararası)', 'Orkestra Şefliği (Ulusal)', 'Opera Şefliği (Uluslararası)', 'Opera Şefliği (Ulusal)'], 'puan' => 15],
        '28d2' => ['baslik' => 'Şeflik ettiği diğer türlerde müzik kaydı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koro Şefliği (Uluslararası)', 'Koro Şefliği (Ulusal)', 'Grup Şefliği (Uluslararası)', 'Grup Şefliği (Ulusal)', 'Bale Orkestra Şefliği (Uluslararası)', 'Bale Orkestra Şefliği (Ulusal)'], 'puan' => 10],
        '28e' => ['baslik' => 'Ses ve enstrüman için çeşitli türlerde özgün eser yaratmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Özgün Eser / Beste / Tasarım', 'Opera/Bale Kompozisyonu', 'Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Küçük Ölçekli Orkestra Eseri', 'Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)', 'Elektronik Müzik Eseri (≥15 dk)', 'Elektronik Müzik Eseri (<15 dk)', 'Sahne/Ekran Müziği', 'Orkestralı Sahne Eseri'], 'puan' => 30],
        '28f' => ['baslik' => 'Seçkin eserlerden oluşan orkestra eşlikli müzik kaydı (yorum veya icra)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)', 'Karma Albüm / CD-DVD Katkısı', 'Eğitim Müziği Albümü'], 'puan' => 10],

        // ── KOREOGRAFİ ve SAHNELEME ── (29-31)
        '29' => ['baslik' => 'Uluslararası düzeyde koreografi eseri meydana getirmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Tüm Perde Koreograflığı (Uluslararası)', 'Bölüm Koreograflığı (Uluslararası)', 'Bale/Dans Koreograflığı (Uluslararası)'], 'puan' => 60],
        '29b' => ['baslik' => 'Ulusal düzeyde koreografi eseri meydana getirmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koreografi', 'Tüm Perde Koreograflığı (Ulusal)', 'Bölüm Koreograflığı (Ulusal)', 'Bale/Dans Koreograflığı (Ulusal)'], 'puan' => 30],
        '30' => ['baslik' => 'Koreografisini yaptığı eseri uluslararası düzeyde sahnelemek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahneleme/Repetitörlük — Tüm Perde (Uluslararası)', 'Sahneleme/Repetitörlük — Bölüm (Uluslararası)'], 'puan' => 35],
        '30b' => ['baslik' => 'Koreografisini yaptığı eseri ulusal düzeyde sahnelemek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahneleme/Repetitörlük — Tüm Perde (Ulusal)', 'Sahneleme/Repetitörlük — Bölüm (Ulusal)'], 'puan' => 20],
        '31' => ['baslik' => 'Sahne, radyo, tiyatro, sinema veya tasarım dalında monografik eser', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Uzun Metrajlı Film / Belgesel (Uluslararası)', 'Uzun Metrajlı Film / Belgesel (Ulusal)', 'Animasyon / Canlandırma Yapımı'], 'puan' => 60],

        // ── DERS ── (32)
        '32' => ['baslik' => 'Verdiği lisansüstü ders (yarıyıl başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Yabancı Dilde Ders'], 'puan' => 4],
        '32b' => ['baslik' => 'Verdiği lisans/önlisans dersi (yarıyıl başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Değişim Programı Dersi'], 'puan' => 2],

        // ── PROJE ── (34-37) · fon kaynağına göre ayrışıyor
        '34' => ['baslik' => 'Tamamlanmış uluslararası projede yöneticilik', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 50],
        '34b' => ['baslik' => 'Tamamlanmış kalkınma ajansı veya bakanlık projesinde yöneticilik', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 40],
        '34c' => ['baslik' => 'Tamamlanmış TÜBİTAK projesinde yöneticilik', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 30],
        '34d' => ['baslik' => 'Tamamlanmış kurumsal projede yöneticilik', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 15],
        '36' => ['baslik' => 'Tamamlanmış uluslararası projede katılımcılık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 30],
        '36b' => ['baslik' => 'Tamamlanmış kalkınma ajansı veya bakanlık projesinde katılımcılık', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],
        '36c' => ['baslik' => 'Tamamlanmış TÜBİTAK projesinde katılımcılık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 15],
        '36d' => ['baslik' => 'Tamamlanmış kurumsal projede katılımcılık', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Özel Sektör / STK', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],

        // ── DAVETLİ KONUŞMACI, JÜRİ ve EDİTÖRLÜK ── (38-42)
        '38-39' => ['baslik' => 'Kongre ya da sempozyumda davetli konuşmacı', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 15],
        '40' => ['baslik' => 'Uluslararası sanat veya tasarım yarışmasında jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)'], 'puan' => 20],
        '40b' => ['baslik' => 'Ulusal sanat veya tasarım yarışmasında jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 10],
        '41' => ['baslik' => 'Uluslararası dergide yayın kurulu üyeliği veya editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi', 'BKCI Kitap'], 'puan' => 10],
        '41b' => ['baslik' => 'Ulusal dergide yayın kurulu üyeliği veya editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi', 'Yayın Kurulu Üyeliği', 'Kitap Editörlüğü'], 'puan' => 5],
        // Yönergenin her alan tablosunda bu satırlar ULUSLARARASI/ULUSAL diye
        // ikiye ayrılıyor; faaliyet kaydı dergi ya da bursun düzeyini taşımadığı
        // için §0 uyarınca ulusal değerden sayılıyor (01.09.2026).
        '42' => ['baslik' => 'Dergilerde hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 5],

        // ── ÖDÜL ve BURS ── (45-46)
        '45' => ['baslik' => 'Uluslararası başarı ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 35],
        '45b' => ['baslik' => 'Ulusal başarı ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'YÖK Ödülü', 'Yarışma Derecesi / Mansiyon'], 'puan' => 20],
        '46' => ['baslik' => 'Araştırma bursu', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 10],

        // ── ATIF ── (47)
        '47' => ['baslik' => 'Uluslararası bilim, sanat veya tasarım dergisi ya da kitabında atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 40],
        '47b' => ['baslik' => 'Ulusal bilim, sanat veya tasarım dergisi ya da kitabında atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer', 'Patent'], 'puan' => 20],

        // ── PATENT ── (48) · yalnız tescil edilmiş olanlar
        '48' => ['baslik' => 'Tescil edilmiş uluslararası patent veya know-how', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 50],
        '48b' => ['baslik' => 'Tescil edilmiş ulusal patent, faydalı model veya tasarım', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım', 'Ticarileştirme', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 25],

        // ── TEZ DANIŞMANLIĞI ── (49)
        '49' => ['baslik' => 'Tamamlanmış doktora veya sanatta yeterlik tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 25],
        '49b' => ['baslik' => 'Tamamlanmış yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 20],
        '49c' => ['baslik' => 'Tez jüri üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 4],
        '31a2' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 20],
        '31b2' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (ulusal)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 15],
    ],

    'gruplar' => [
        // "27, 32-52 numaralı faaliyetler" — doçentlik koşulu (md. 13/a).
        '27,32-52' => ['28c', '28d', '28d2', '28e', '28f', '29', '29b', '30', '30b', '31', '32', '32b', '34', '34b', '34c', '34d', '36', '36b', '36c', '36d', '38', '40', '40b', '41', '41b', '42', '45', '45b', '46', '47', '47b', '48', '48b', '49', '49b', '49c'],
        // "17, 18, 27, 34, 41, 49, 50" — profesörlük koşulu (md. 18/2-a).
        'PROF-CEKIRDEK' => ['17', '17b', '18', '18b', '34', '34b', '34c', '34d', '41', '41b', '49', '49b'],
        // Md. 8/b-4'ün üçüncü yenileme koşulu: özgün kitap ya da hakemli makale.
        'KITAP-MAKALE' => ['17', '19', '1', '3', '6', '10'],
    ],

    'grup_tavanlari' => [],
];
