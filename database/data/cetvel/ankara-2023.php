<?php

/**
 * ANKARA ÜNİVERSİTESİ — Değerlendirmede Kullanılacak Puanlar
 * Kaynak: pdf/17536929322.ankarauniversitesi.pdf (01.01.2023, KALICI)
 *
 * MADDE KODLARI yönergenin kendi harflendirmesidir; zorunlu koşullar bunlara
 * atıf yapıyor ("(1A-1B) faaliyetlerinden en az 190 puan").
 *
 * MAKALE BÖLÜMÜ ALTI ALT KÜMEYE AYRILIYOR ve koşullar bu kümeleri farklı
 * genişliklerde çağırıyor:
 *   1A özgün araştırma makalesi / derleme     Q1-Q4: 40/35/30/25
 *   1B short / brief communication            Q1-Q4: 35/30/25/20
 *   1C vaka, teknik not, editöre mektup       Q1-Q4: 20/15/10/8
 *   1Ç kongre bildirisi (WoS dergide)         Q1-Q4: 10/8/5/(5-3)
 *   1D kitap değerlendirmesi                  Q1-Q4: 10/8/5/(4-3)
 *   1E WoS All Databases / SCOPUS             22 / 9 / 6 / 5 / 4
 *   1F diğer uluslararası indeks              20 / 8 / 4 / (3-2) / 2
 *   1G TR-Dizin                               15 / 5 / 4 / (3-2)
 *
 * 1A, 1B ve 1C `turler` alanıyla ayrıldı. DİKKAT: Ankara 1A'da özgün makale
 * ile derlemeyi BİRLİKTE puanlıyor (ikisi de 40/35/30/25), Ege ve Gazi ise
 * ayırıyor. Bu yüzden 1A maddeleri iki türü de kabul ediyor.
 *
 * GİRİLMEYEN BÖLÜMLER: 3. Sanatsal Etkinlik (müzik, sahne, sergi — 40'tan
 * fazla kalem, kaynak sözlüğünde çoğunun karşılığı yok), 7. Bilimsel/Sanatsal
 * Toplantı'nın bir kısmı ve idari/ödül kalemleri.
 *
 * TAVAN TARAMASI (01.09.2026): kaynaktaki üç tavan ifadesinin hiçbiri
 * uygulanabilir değil, `grup_tavanlari` bilerek boş:
 *   9. bölüm (dergi editörlüğü) "yıllık en fazla 15 puan" — hem YIL BAŞINA
 *     (motorda karşılığı yok) hem de o bölümün satırları hiç girilmemiş;
 *     cetveldeki iki editörlük satırı KİTAP editörlüğü (2Ad, 2Bd).
 *   8. bölüm (eğitim-öğretim) "en fazla 20 puan" — kadro sütununa bağlı
 *     (Dr. ve doçentte 20, profesör ve yeniden atanmada sınırsız) ve bölümün
 *     satırları cetvelde yok.
 *   12/c yurt dışı ay "en fazla 18 puan" — satırı girilmedi (süre profilde
 *     tutulmuyor).
 */

return [
    'kapsam_notu' => 'Puanlar Ankara Üniversitesi 2023 kalıcı çizelgesinden. Sanatsal etkinlik '
        .'bölümü henüz girilmedi. Gerçek toplamınız burada görünenden yüksek olabilir, '
        .'düşük olamaz.',

    'maddeler' => [
        // ── 1A · Özgün araştırma makalesi / derleme ──
        '1Aa' => ['baslik' => 'WoS Q1 dergide özgün araştırma makalesi/derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 40],
        '1Ab' => ['baslik' => 'WoS Q2 dergide özgün araştırma makalesi/derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 35],
        '1Ac' => ['baslik' => 'WoS Q3 dergide özgün araştırma makalesi/derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 30],
        '1Aç' => ['baslik' => 'WoS Q4 dergide özgün araştırma makalesi/derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 25],

        // ── 1B, 1C · aynı dergiler, farklı yayın türü ──
        // Ankara 1A'da özgün makale ile derlemeyi BİRLİKTE puanlıyor;
        // Ege ve Gazi ayırıyor. Bu yüzden 1A iki türü de kabul ediyor.
        '1Ba' => ['baslik' => 'WoS Q1 dergide short/brief communication', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['kisa_makale'], 'puan' => 35],
        '1Bb' => ['baslik' => 'WoS Q2 dergide short/brief communication', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['kisa_makale'], 'puan' => 30],
        '1Bc' => ['baslik' => 'WoS Q3 dergide short/brief communication', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['kisa_makale'], 'puan' => 25],
        '1Bç' => ['baslik' => 'WoS Q4 dergide short/brief communication', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => ['kisa_makale'], 'puan' => 20],
        '1Ca' => ['baslik' => 'WoS Q1 dergide vaka, teknik not, editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['vaka_teknik_not'], 'puan' => 20],
        '1Cb' => ['baslik' => 'WoS Q2 dergide vaka, teknik not, editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['vaka_teknik_not'], 'puan' => 15],
        '1Cc' => ['baslik' => 'WoS Q3 dergide vaka, teknik not, editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['vaka_teknik_not'], 'puan' => 10],
        '1Cç' => ['baslik' => 'WoS Q4 dergide vaka, teknik not, editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => ['vaka_teknik_not'], 'puan' => 8],

        // ── 1E-1G · çeyrekliksiz indeks kümeleri ──
        // E, F ve G bölümlerinin de A-C'deki gibi tam merdiveni var (özgün
        // makale/derleme · short communication · vaka-teknik not-editöre
        // mektup); yalnız "a" satırı girilmiş ve tür kısıtı olmadığı için
        // editöre mektup kaydeden aday SCOPUS'ta 6 yerine 22 puan alıyordu
        // (§0 ihlali).
        '1Ea' => ['baslik' => 'WoS All Databases / SCOPUS dergide özgün araştırma makalesi ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 22],
        '1Eb' => ['baslik' => 'WoS All Databases / SCOPUS dergide short/brief communication', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['kisa_makale'], 'puan' => 9],
        '1Ec' => ['baslik' => 'WoS All Databases / SCOPUS dergide vaka, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['vaka_teknik_not'], 'puan' => 6],
        '1Eç' => ['baslik' => 'SCOPUS dergide kongre bildirisi tam metni/özeti', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 5],
        '1Fa' => ['baslik' => 'Diğer uluslararası indeksli dergide özgün araştırma makalesi ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 20],
        '1Fb' => ['baslik' => 'Diğer uluslararası indeksli dergide short/brief communication', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['kisa_makale'], 'puan' => 8],
        '1Fc' => ['baslik' => 'Diğer uluslararası indeksli dergide vaka, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['vaka_teknik_not'], 'puan' => 4],
        '1Ga' => ['baslik' => 'TR-Dizin dergide özgün araştırma makalesi ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 15],
        // 1Gb'nin başlığı TR-Dizin diyordu ama etiketi `Diğer Ulusal Hakemli`
        // taşıyordu (yerleştirme hatası). Kaynakta TR-Dizin dışı ulusal
        // hakemli dergi için satır YOK; etiket bu cetvelde karşılıksız kalıyor
        // ve doğrusu budur.
        '1Gb' => ['baslik' => 'TR-Dizin dergide short/brief communication', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['kisa_makale'], 'puan' => 5],
        '1Gc' => ['baslik' => 'TR-Dizin dergide vaka, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['vaka_teknik_not'], 'puan' => 4],

        // ── 2A · Uluslararası yayınevi kitapları ──
        '2Aa' => ['baslik' => 'Yabancı dilde kitap/monografi yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 60],
        '2Ab' => ['baslik' => 'Uluslararası yayınevinden kitap çevirmenliği', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 50],
        '2Ac' => ['baslik' => 'Yabancı dilde kitap bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 30],
        '2Aç' => ['baslik' => 'Kitabın Türkçe kitap bölüm çevirmenliği', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 20],
        '2Ad' => ['baslik' => 'Yabancı dilde yazılmış kitabın editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 40],

        // ── 2B · Ulusal yayınevi kitapları ──
        '2Ba' => ['baslik' => 'Ulusal yayınevinden kitap/monografi yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 40],
        '2Bc' => ['baslik' => 'Ulusal yayınevinden kitap bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 15],
        '2Bd' => ['baslik' => 'Ulusal yayınevinden kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 20],
        '2Bf' => ['baslik' => 'Tahkik / neşir / araştırma notu / detaylı kitap kritiği', 'kategori' => 'kitap', 'kaynaklar' => ['Tahkik (Tenkitli Metin)'], 'puan' => 5],

        // ── 3 · SANATSAL ETKİNLİK ──
        // Güzel Sanatlar barajı bu bölümü de sayıyor; girilmediği sürece o
        // alandaki aday puanını eksik görüyordu.
        //
        // YAKLAŞIK EŞLEME: Ankara c) "orkestra eşliğinde solist, orkestra
        // yönetmek, operada solist, bireysel dinleti, oda müziği" kalemlerini
        // TEK satırda topluyor; sözlükteki etiketler (Mersin TABLO C'den gelen)
        // bunları ayrı tutuyor. Satır, kapsadığı etiketlerin tümüyle bağlandı —
        // aday hangisini kaydetmişse o satırdan puan alır.
        '3c' => ['baslik' => 'Uluslararası etkinlikte solist konser, orkestra yönetimi, resital veya oda müziği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Solistlik (Uluslararası)', 'Resital (Uluslararası)', 'Orkestra Şefliği (Uluslararası)'], 'puan' => 40],
        '3ç' => ['baslik' => 'Ulusal etkinlikte solist konser, orkestra yönetimi, resital veya oda müziği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Solistlik (Ulusal)', 'Resital (Ulusal)', 'Orkestra Şefliği (Ulusal)'], 'puan' => 20],
        '3d' => ['baslik' => 'Uluslararası karma etkinlikte solist, oda müziği grup üyesi veya piyano eşlikçisi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Uluslararası)'], 'puan' => 20],
        '3e' => ['baslik' => 'Ulusal karma etkinlikte solist, oda müziği grup üyesi veya piyano eşlikçisi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Ulusal)'], 'puan' => 10],
        '3f' => ['baslik' => 'Uluslararası/ulusal etkinlikte orkestra veya koro üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra / Koro Üyeliği'], 'puan' => 10],
        '3g' => ['baslik' => 'Uluslararası etkinlikte icra edilmiş veya yayımlanmış özgün beste', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Özgün Eser / Beste / Tasarım'], 'puan' => 40],
        '3j' => ['baslik' => 'Performansı veya özgün besteleriyle yayınlanmış CD/DVD', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Albüm / Konser Kaydı'], 'puan' => 40],
        '3k' => ['baslik' => 'Yayınlanmış karma CD/DVD\'de performans veya özgün beste', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Albüm / CD-DVD Katkısı'], 'puan' => 20],
        '3l' => ['baslik' => 'Sahne, TV, radyo veya sinemada uluslararası mecrada yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)'], 'puan' => 40],
        '3m' => ['baslik' => 'Sahne, TV, radyo veya sinemada ulusal mecrada yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'], 'puan' => 20],
        '3n' => ['baslik' => 'Dansçı veya performans icracısı olarak uluslararası etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Dansçı / Performans İcracısı (Uluslararası)'], 'puan' => 40],
        '3o' => ['baslik' => 'Dansçı veya performans icracısı olarak ulusal etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Dansçı / Performans İcracısı (Ulusal)'], 'puan' => 20],
        '3ö' => ['baslik' => 'Koreograf olarak sahnelenen yapıt', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koreografi'], 'puan' => 15],
        '3p' => ['baslik' => 'Sahne, TV, radyo veya sinemada yönetmenlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Yönetmenlik (Sahne/Ekran)'], 'puan' => 30],
        '3r' => ['baslik' => 'Sahne tasarımı (dekor, kostüm, ışık)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne Tasarımı (Dekor, Kostüm, Işık)'], 'puan' => 15],
        '3s' => ['baslik' => 'Uluslararası koruma-onarım uygulaması veya kişisel sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koruma-Onarım Uygulaması (Uluslararası)', 'Kişisel Etkinlik (Uluslararası)'], 'puan' => 40],
        '3ş' => ['baslik' => 'Ulusal koruma-onarım uygulaması veya kişisel sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koruma-Onarım Uygulaması (Ulusal)', 'Kişisel Etkinlik (Ulusal)'], 'puan' => 30],
        '3t' => ['baslik' => 'Uluslararası ortak/karma/grup sergisine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)'], 'puan' => 15],
        '3u' => ['baslik' => 'Ulusal ortak/karma/grup sergisine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)'], 'puan' => 10],
        '3ü' => ['baslik' => 'Kurum web adresinde yayımlanan özgün eser (elektronik kişisel sergi)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Elektronik Kişisel Sergi (Uluslararası)', 'Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 10],
        '3v' => ['baslik' => 'Kurum web adresinde yayımlanan karma sergi katılımı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Elektronik Karma Sergi (Uluslararası)', 'Elektronik Karma Sergi (Ulusal)'], 'puan' => 5],

        // ── 4 · Atıf ──
        '4a' => ['baslik' => 'WoS/Scopus dergilerde adayın yazar olmadığı yayınlarda atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 5],
        '4b' => ['baslik' => 'Uluslararası yayınevi kitaplarında atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 4],
        '4ç' => ['baslik' => 'Diğer uluslararası indeksli dergilerde atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer'], 'puan' => 3],
        '4d' => ['baslik' => 'TR-Dizin dergilerde atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 3],
        '4j' => ['baslik' => 'Yargı kararlarında bilimsel çalışmalara yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Patent'], 'puan' => 2],

        // ── 5 · Bilimsel araştırma projesi ──
        '5a' => ['baslik' => 'Horizon/Marie Curie/NIH/NSF/ERC projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 70],
        '5b' => ['baslik' => 'Horizon/Marie Curie/NIH/NSF/ERC projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 50],
        '5ç' => ['baslik' => 'Diğer uluslararası destekli projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 40],
        '5d' => ['baslik' => 'Diğer uluslararası destekli projede araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 30],
        '5f' => ['baslik' => 'TÜBİTAK/ulusal kaynaklı projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 30],
        '5g' => ['baslik' => 'TÜBİTAK/ulusal kaynaklı projede araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 15],
        '5h' => ['baslik' => 'Özel kurumlarla yapılan araştırma projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK', 'BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 10],
        '5ı' => ['baslik' => 'Özel kurumlarla yapılan araştırma projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK', 'BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 5],

        // ── 6 · Tez danışmanlığı ──
        '6a' => ['baslik' => 'Tamamlanmış doktora/uzmanlık/sanatta yeterlik tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 15],
        '6c' => ['baslik' => 'Tamamlanmış yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 8],
        '6d' => ['baslik' => 'Doktora tez izleme komitesi üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 3],

        // ── 7 · Bilimsel/sanatsal toplantı ──
        '7a-7ç' => ['baslik' => 'Bilimsel toplantıda davetli konuşmacı', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 12],
        // 7b/7c'nin TAM METİN kolu ile 7d/7e'nin tamamı (ulusal bildiriler)
        // hiç girilmemişti: `Uluslararası Tam Metin` yalnız 1Eç'den (SCOPUS
        // dergide yayımlanmış kongre bildirisi, 5 puan) besleniyordu, ulusal
        // bildiri etiketlerinin ise hiç karşılığı yoktu.
        //
        // Etiket SÖZLÜ ile POSTER'i ayırmıyor, bu yüzden her kolda §0 uyarınca
        // düşük olan poster değeri yazıldı: uluslararası tam 20/15 → 15,
        // özet 15/10 → 10; ulusal tam 12/6 → 6, özet 8/4 → 4.
        '7b-7c-tam' => ['baslik' => 'Uluslararası toplantıda sunulmuş, tam metni basılmış sözlü bildiri ya da poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 15],
        '7b-7c' => ['baslik' => 'Uluslararası toplantıda sunulmuş özet bildiri ya da poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 10],
        '7d-7e-tam' => ['baslik' => 'Ulusal toplantıda sunulmuş, tam metni basılmış sözlü bildiri ya da poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 6],
        '7d-7e' => ['baslik' => 'Ulusal toplantıda sunulmuş özet bildiri ya da poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 4],
        '7k' => ['baslik' => 'Kamu kurum ve kuruluşlarında uzmanlığınızla ilgili komisyonlarda görev (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dış Kuruluş Kurul Üyeliği (Ulusal)'], 'puan' => 2],
        '6g' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (ulusal)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 3],
        '6f' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 5],
    ],

    'gruplar' => [
        // Koşulların birebir kullandığı atıflar.
        '1A' => ['1A*'],
        // Md. I/ı: Hukuk temel alanının monografi koşulunun telafisi "Q1, Q2
        // kapsamındaki dergilerde iki adet tek yazarlı özgün makale".
        '1A-Q1-Q2' => ['1Aa', '1Ab'],
        '1A-1B' => ['1A*', '1B*'],
        '1A-1C' => ['1A*', '1B*', '1C*'],
        '1A-1E' => ['1A*', '1B*', '1C*', '1Ea', '1Eç'],
        '1A-1G' => ['1*'],
        'KITAP' => ['2*'],
        // Md. I/ı "monografik çalışma" diyor: kitap bölümü ve çeviri değil,
        // yalnız kitap/monografi YAZARLIĞI satırları.
        'MONOGRAFI' => ['2Aa', '2Ba'],
        'SANATSAL' => ['3*'],
        'PROJE' => ['5*'],
        'PROJE_YURUTUCU' => ['5a', '5ç', '5f', '5h'],
    ],

    'grup_tavanlari' => [],
];
