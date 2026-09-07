<?php

/**
 * AKSARAY ÜNİVERSİTESİ — TABLO-1: Akademik Değerlendirme Puan Tablosu
 * Kaynak: pdf/17634002431.Aksaray Üniversitesi Kriter.pdf (18 sayfa,
 * Senato 06.11.2024/2024-30-03, YÖK onayı 21.11.2024; Tablo-2'nin Spor
 * Bilimleri "a" bendi 24.09.2025/2025-25-01 ile değiştirildi)
 *
 * MADDE KODLARI YÖNERGENİN KENDİSİ: A-N bölüm harfleri + sıra numarası.
 *
 * ── A.2/A.3 ÇAKIŞMASI: SCOPUS İLE ESCI AYRI PUANLI ──
 * A.2 (yalnızca Scopus, 20 puan) ile A.3 (yalnızca ESCI, 18 puan) ayrı
 * satırlar ama kaynak sözlüğünün 'ESCI / Scopus' etiketi ikisini birden
 * kapsıyor, ayıramıyor. Motor aynı kaynağa düşen maddelerden en yükseğini
 * seçeceği için tek maddede, düşük olan puanla (18) birleştirildi.
 *
 * ── PATENT DE YAZAR FORMÜLÜNE TABİ ──
 * "Patentlerde puan kişi sayısına bölünür" (I bölümü notu) — bu yönergede
 * patent, korpustaki çoğu yönergeden farklı olarak yazar formülünün
 * DIŞINDA TUTULMADI (`haric` listesinde yok).
 *
 * ── I.1 (ULUSLARARASI PATENT) TAVANSIZ, GRUP TAVANI YAZILMADI ──
 * "Tescil edilmiş uluslararası patentte üst sınır aranmaz" notu I grubunun
 * kendi 35 puanlık tavanının İSTİSNASI. Motorun `grup_tavanlari` tüm gruba
 * eşit uygulanıyor, "şu kalem hariç" ayrımı yapamıyor; I grubuna tavan
 * yazmak I.1'i de 35'e keserdi (kaynakla çelişirdi). Bu yüzden I grubuna
 * HİÇ tavan yazılmadı — I.2-I.4 toplamı 35'i aşarsa TOPLAM'a fazladan
 * katkı sağlar, küçük bir YÜKSEK sapma.
 *
 * ── AYNI KAYNAĞA DÜŞEN DİĞER SATIRLARDA DAİMA DÜŞÜĞÜ GİRİLDİ ──
 *   B.2/B.4 bildiri özeti (CPCI 4 / bildiri kitabı 2): tek 'Uluslararası
 *       Özet/Poster' etiketi → 2.
 *   E.1/E.2 atıf (SCI/SSCI/AHCI 5 / Scopus-ESCI 4): tek 'WoS / Scopus'
 *       etiketi → 4.
 *   E.3/E.5/E.7 atıf (diğer uluslararası indeks 2 / diğer uluslararası veya
 *       ulusal kitap 1 / diğer ulusal hakemli 1): tek 'Diğer' etiketi → 1.
 *   J.3/J.4 ödül (TÜBİTAK Bilim Ödülü 35 / TÜBİTAK Teşvik Ödülü 25): tek
 *       'TÜBİTAK / TÜBA Ödülü' etiketi → 25.
 *   J.5/J.6 ödül (TÜBA-GEBİP 20 / TÜBA-TESEP 15): tek 'TÜBA GEBİP / TWAS
 *       Teşvik Ödülü' etiketi → 15.
 *   K.8/K.9 sahne sanatları yönetmenliği (yurt dışı 13 / yurt içi 10): tek
 *       'Yönetmenlik (Sahne/Ekran)' etiketi → 10.
 *   M.3/M.7 editörlük (diğer uluslararası indeks 2 / diğer ulusal hakemli
 *       dergi 1): tek 'Diğer Hakemli Dergi' etiketi → 1.
 *
 * ── GİRİLMEYEN KALEMLER ──
 *   E.8 (h-indeksi ≥5 olan adaya sabit 8 puan) — h-indeksi bir PROFİL
 *       özelliği, faaliyet kaydı değil; motor puanı yalnızca faaliyetlerden
 *       topluyor, cetvele giremiyor.
 *   F.7 (üretilmiş tasarım/planlama/koruma projesi hakkında yazı yazılmış
 *       olması), F.8/F.9 (spor/sağlık ihtisaslaşma projeleri), F.13-F.19
 *       (arkeolojik kazı, restorasyon ve yüzey araştırması projeleri) —
 *       sözlükte karşılıksız.
 *   I.5 (patent BAŞVURUSU, henüz tescilsiz) — tescilli patentle (I.1-I.4)
 *       aynı kaynağa düşerdi ve motor en yükseği seçeceği için başvuru
 *       sahiplerini tescilli gibi sayardı (fazla sayma riski); girilmedi.
 *   K.6 (sanatsal etkinlik projelendirme, sergi/basın koordinasyonu, atölye
 *       yönetimi), K.12 mimarlık yarışması ödülü zaten `odul` kategorisinde
 *       ayrı girildi (bkz. K.12 satırı).
 *   Tüm L bölümü (Spor Etkinlikleri — olimpiyat madalyaları, antrenörlük
 *       belgesi, milli sporculuk) — hiçbir alan tablosunda (Spor Bilimleri
 *       dahil) alt şart olarak talep edilmiyor, yalnızca TOPLAM'a serbest
 *       katkı sağlıyor; `Kategori` enumunda spor madalyası/antrenörlük için
 *       karşılık olmadığından hiç girilmedi.
 *   M.8-M.9, M.11 (kongre/toplantı düzenleme kurulu başkanlığı/üyeliği,
 *       STK/kamu programlarında konuşmacılık) — sözlükte karşılıksız;
 *       M.10/M.11'in "davetli konuşmacı/panelist" ortak kısmı tek maddede
 *       birleştirildi.
 *   N.10 (Rektörlüğe bağlı koordinatörlük) — N.11'in kullandığı
 *       'Anabilim Dalı Başkanı / Koordinatörlük' etiketiyle aynı puanı
 *       (1) paylaşıyor, ayrıca girilmedi.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   H.1/H.2 "iki farklı yarıyılda" veya "bir yılda" ders vermiş olmak —
 *       bu bir DÖNEM SÜREKLİLİĞİ şartı, adet koşulu değil; tek bir ders
 *       faaliyeti kaydı bu şartı temsil edemez, sabit 2 puanlık tek satırla
 *       yaklaşıklandı (gerçekte iki farklı yarıyıl/bir yıl boyunca ders
 *       vermiş olma şartı motor tarafından doğrulanmıyor).
 *   C.2/C.4 "aynı kitapta en fazla bir bölüm" — eser bazlı tavan, motorda
 *       yok; aynı kitaptan 2+ bölümü olan adayın puanı YÜKSEK görünebilir.
 *   M.9/M.10/M.12 "en çok 5 (veya 3) faaliyet için puanlama" — faaliyet
 *       sayısı tavanı motorda yok (yalnızca puan tavanı var); girilen tek
 *       kalem (M.10/M.11 birleşik) için bu sınır uygulanamadı, puan YÜKSEK
 *       görünebilir.
 *   N bölümünün TAMAMI "her yıl için" diyor; motorun `puan` alanı sabit,
 *       yalnızca 1 yıllık taban değeri girildi, çok yıllık idari görevlerde
 *       puan DÜŞÜK görünür.
 *
 * Yönerge: yonerge/aksaray.php
 *
 * 06.09.2026: bilimsel toplantı organizasyonu ailesi için altı etiket
 * açıldı (başkanlık · düzenleme/bilim kurulu üyeliği · oturum başkanlığı,
 * her biri uluslararası/ulusal). Yukarıdaki "sözlükte karşılıksız" notları
 * bu satırlar için artık geçerli değil.
 */

return [
    'kapsam_notu' => 'Puanlar Aksaray Üniversitesi Tablo-1 Akademik Değerlendirme Puan '
        .'Tablosundan. Yazar çarpanı Tablo-3\'teki sıra × yazar-sayısı matrisine göre işliyor '
        .'(sorumlu yazar 1. isim gibi sayılır); bu çarpan PATENT dahil neredeyse tüm kalemlere '
        .'uygulanıyor. Yazar listesini boş bırakırsanız çarpan hiç uygulanmaz ve puanınız '
        .'olduğundan YÜKSEK görünür. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: Scopus ile ESCI dergisi aynı '
        .'satırdan (düşük olan ESCI değeriyle) sayılıyor; birkaç ödül ve atıf kalemi de benzer '
        .'şekilde tek satıra düştü; h-indeksi puanı (profil özelliği olduğu için), spor '
        .'madalyaları/antrenörlük belgesi, kongre düzenleme kurulu üyeliği ve arkeolojik kazı '
        .'kalemleri hiç girilemedi; idari görevlerin yıl biriktirmesi uygulanmıyor. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünebilir: uluslararası patent (I.1) '
        .'tavansız olduğu için I grubuna hiç tavan yazılmadı; aynı kitaptan birden fazla '
        .'bölümünüz varsa hepsi sayılır; "en çok 5 faaliyet" sınırlı davetli konuşmacılık/jüri '
        .'kalemlerinde faaliyet sayısı tavanı uygulanmıyor.',

    // Tablo-3: sorumlu yazar 1. isim sayılır. 1 kişi 100; 2 kişi 90/80;
    // 3 kişi 80/70/60; 4 kişi 70/60/50/40; 5 kişi 60/50/40/30/20; 6-9 kişi
    // 50/40/30/20/10(.../10 tekrarlı); 9 ve üzeri (10. isim dahil) hep 10.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'tez_danismanligi', 'egitim_ogretim', 'idari_gorev',
            'odul', 'editorluk', 'toplumsal_katki'],
        'roller' => (function (): array {
            $ilk = ['kademeler' => [1 => 1.00, 2 => 0.90, 3 => 0.80, 4 => 0.70, 5 => 0.60], 'sonrasi' => 0.50];
            $yazar2 = ['kademeler' => [2 => 0.80, 3 => 0.70, 4 => 0.60, 5 => 0.50], 'sonrasi' => 0.40];
            $yazar3 = ['kademeler' => [3 => 0.60, 4 => 0.50, 5 => 0.40], 'sonrasi' => 0.30];
            $yazar4 = ['kademeler' => [4 => 0.40, 5 => 0.30], 'sonrasi' => 0.20];
            $yazar5 = ['kademeler' => [5 => 0.20], 'sonrasi' => 0.10];
            // 6. ve sonraki sıradaki her yazar (9. isme kadar ve 10. isim
            // dahil "≥10" satırı) hep %10.
            $yazar6 = ['sonrasi' => 0.10];
            $ortak = ['kademeler' => [1 => 1.00, 2 => 0.80, 3 => 0.60, 4 => 0.40, 5 => 0.20], 'sonrasi' => 0.10];

            return [
                'tek' => ['kademeler' => [1 => 1.0]],
                'ilk' => $ilk,
                'baslica' => $ilk,
                'yazar_2' => $yazar2,
                'yazar_3' => $yazar3,
                'yazar_4' => $yazar4,
                'yazar_5' => $yazar5,
                'yazar_6' => $yazar6,
                'ortak' => $ortak,
            ];
        })(),
    ],

    'maddeler' => [
        // ══ A. MAKALELER ══
        'A.1-Q1' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI Q1 dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale'], 'puan' => 60],
        'A.1-Q2' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI Q2 dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale'], 'puan' => 50],
        'A.1-Q3' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI Q3 dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['ozgun_makale'], 'puan' => 40],
        'A.1-Q4' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI Q4 dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => ['ozgun_makale'], 'puan' => 30],
        'A.1' => ['baslik' => "SCI-Expanded, SSCI veya AHCI'de taranan dergide AHCI ile taranan özgün araştırma makalesi", 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 60],
        'A.2-A.3' => ['baslik' => 'Scopus veya ESCI tarafından indekslenmiş dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale'], 'puan' => 18],
        'A.4' => ['baslik' => 'ULAKBİM TR-Dizin tarafından indekslenmiş dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale'], 'puan' => 14],
        'A.5' => ['baslik' => 'A1-A3 dışındaki diğer uluslararası indekslerde taranan dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale'], 'puan' => 10],
        'A.6' => ['baslik' => 'Diğer ulusal hakemli dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale'], 'puan' => 7],
        'A.7' => ['baslik' => 'A1-A4 kategorisindeki dergide teknik not, editöre mektup, derleme veya benzeri', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI', 'ESCI / Scopus', 'TR Dizin'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 5],
        'A.8' => ['baslik' => 'A5-A6 kategorisindeki dergide teknik not, editöre mektup, derleme veya benzeri', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 3],

        // ══ B. BİLİMSEL TOPLANTILAR ══
        'B.1' => ['baslik' => 'Uluslararası bilimsel toplantıda CPCI\'de tam metin yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 7],
        'B.3' => ['baslik' => 'Uluslararası bilimsel toplantıda bildiriler kitabında tam metin yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin'], 'puan' => 4],
        'B.2-B.4' => ['baslik' => 'Uluslararası bilimsel toplantıda özet metin yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 2],
        'B.5' => ['baslik' => 'Ulusal bilimsel toplantıda tam metin yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 2],
        'B.6' => ['baslik' => 'Ulusal bilimsel toplantıda özet metin yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 1],

        // ══ C. KİTAPLAR ══
        'C.1' => ['baslik' => 'BKCI kapsamında yayımlanmış kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 30],
        'C.2' => ['baslik' => 'BKCI kapsamında yayımlanmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 20],
        'C.3' => ['baslik' => 'Diğer uluslararası veya ulusal yayınevi kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 20],
        'C.4' => ['baslik' => 'Diğer uluslararası veya ulusal yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 10],
        'C.5' => ['baslik' => 'Tahkik (tenkitli metin neşri) türünde kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Tahkik (Tenkitli Metin)'], 'puan' => 12],
        'C.6' => ['baslik' => 'Ansiklopedi bölümü veya maddesi yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 3],

        // ══ D. ÇEVİRİLER ══
        'D.1' => ['baslik' => 'Bilimsel kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 5],
        'D.2-D.3' => ['baslik' => 'Bilimsel kitap bölümü veya A1-A4 kategorisindeki dergide makale çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 2],

        // ══ E. ATIFLAR (H-indeksi hariç) ══
        'E.1-E.2' => ['baslik' => 'SCI-Expanded/SSCI/AHCI veya Scopus/ESCI dergide, yazar olmadığınız yayında atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 4],
        'E.3-E.5-E.7' => ['baslik' => 'Diğer uluslararası indeksli dergide veya uluslararası/ulusal kitapta, yazar olmadığınız yayında atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer'], 'puan' => 1],
        'E.4' => ['baslik' => 'BKCI kapsamında, yazar olmadığınız kitapta atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 3],
        'E.6' => ['baslik' => "ULAKBİM TR-Dizin'de, yazar olmadığınız yayında atıf", 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 3],

        // ══ F. PROJELER ══
        'F.1' => ['baslik' => 'Uluslararası kuruluşça desteklenen sonuçlandırılmış projede koordinatör/yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 35],
        'F.2' => ['baslik' => 'Uluslararası kuruluşça desteklenen sonuçlandırılmış projede araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci'], 'puan' => 20],
        'F.3' => ['baslik' => 'Uluslararası kuruluşça desteklenen sonuçlandırılmış projede danışman', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['danisman'], 'puan' => 10],
        'F.4' => ['baslik' => 'Ulusal kuruluşça (TÜBİTAK, KOSGEB, bakanlık vb., üniversite hariç) desteklenen sonuçlandırılmış projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 15],
        'F.5' => ['baslik' => 'Ulusal kuruluşça desteklenen sonuçlandırılmış projede araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci'], 'puan' => 10],
        'F.6' => ['baslik' => 'Ulusal kuruluşça desteklenen sonuçlandırılmış projede danışman', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'Diğer Kamu Kurumu'], 'roller' => ['danisman'], 'puan' => 7],
        'F.10' => ['baslik' => 'Üniversitede tez/uzmanlık projeleri dışında tamamlanan BAP projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 4],
        'F.11' => ['baslik' => 'Üniversitede tez/uzmanlık projeleri dışında tamamlanan BAP projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['arastirmaci'], 'puan' => 2],
        'F.12' => ['baslik' => 'TÜBİTAK öğrenci projesinde akademik danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'roller' => ['danisman'], 'puan' => 2],

        // ══ G. LİSANSÜSTÜ TEZ YÖNETİMİ ══
        'G.1' => ['baslik' => 'Danışmanlığını yürüttüğü tamamlanmış doktora, uzmanlık veya sanatta yeterlik tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 8],
        'G.2' => ['baslik' => 'Danışmanlığını yürüttüğü tamamlanmış yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 5],
        'G.3-doktora' => ['baslik' => 'Doktora, uzmanlık veya sanatta yeterlik tezinde ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 4],
        'G.3-yl' => ['baslik' => 'Yüksek lisans tezinde ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 2],

        // ══ H. EĞİTİM-ÖĞRETİM FAALİYETLERİ ══
        'H-DERS' => ['baslik' => 'Ön lisans, lisans veya lisansüstü ders vermiş olmak', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Lisansüstü Ders', 'Yabancı Dilde Ders'], 'puan' => 2],

        // ══ I. PATENT / FAYDALI MODEL (I.1 tavansız, grup tavanı yazılmadı) ══
        'I.1' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 100],
        'I.2' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 15],
        'I.3' => ['baslik' => 'Tescil edilmiş endüstriyel tasarım', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım'], 'puan' => 10],
        'I.4' => ['baslik' => 'Tescil edilmiş faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model'], 'puan' => 8],

        // ══ J. ÖDÜL ══
        'J.1-J.2' => ['baslik' => 'YÖK Yılın Doktora Tezi Ödülü veya YÖK Üstün Başarı Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü'], 'puan' => 35],
        'J.3-J.4' => ['baslik' => 'TÜBİTAK Bilim Ödülü veya TÜBİTAK Teşvik Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü'], 'puan' => 25],
        'J.5-J.6' => ['baslik' => 'TÜBA Üstün Başarılı Genç Bilim İnsanı Ödülü veya TÜBA Bilimsel Telif Eser Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 15],

        // ══ K. SANAT, MİMARLIK VE TASARIM ALANI ETKİNLİKLERİ ══
        'K.1' => ['baslik' => 'Özgün sanat eserinin satın alınması, yayımlanması veya uygulanması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Müzeye Kabulü (Yurt İçi)'], 'puan' => 20],
        'K.2' => ['baslik' => 'Özgün sanat eseriyle kişisel etkinlikte bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Ulusal)'], 'puan' => 25],
        'K.3' => ['baslik' => 'Özgün sanat eseriyle karma veya grup etkinlikte bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma/Jürili Etkinlik (Ulusal)'], 'puan' => 12],
        'K.4' => ['baslik' => 'Sergi, çalıştay, bienal, festival gibi karma etkinliğe eserle iştirak etmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 10],
        'K.5' => ['baslik' => 'Gösterimi yapılmış filmin ekibinde yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Belgesel/Kısa Film (Uluslararası)', 'Belgesel/Kısa Film (Ulusal)'], 'puan' => 7],
        'K.7' => ['baslik' => 'Müze, tarihi eser veya koleksiyon restorasyon/konservasyon çalışması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koruma-Onarım Uygulaması (Uluslararası)', 'Koruma-Onarım Uygulaması (Ulusal)'], 'puan' => 10],
        'K.8-K.9' => ['baslik' => 'Sahne veya görsel sanatlarda yönetmen, sanat yönetmeni, eğitmen, koreograf veya performans sanatçısı olarak etkinlikte bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Yönetmenlik (Sahne/Ekran)'], 'puan' => 10],
        'K.10' => ['baslik' => 'Bireysel ses/görüntü yayımı (albüm)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Albüm / Konser Kaydı'], 'puan' => 15],
        'K.11' => ['baslik' => 'Karma ses/görüntü yayımı (albüm)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Albüm / CD-DVD Katkısı'], 'puan' => 10],
        'K.12' => ['baslik' => 'Mimarlık, planlama veya tasarım yarışmasında ödül/mansiyon alan ekip yürütücüsü/üyesi', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 20],
        'K.13' => ['baslik' => 'Proje, yapım yönetimi, tasarım veya planlama alanında yazılım üreticisi olmak', 'kategori' => 'patent', 'kaynaklar' => ['Yazılım'], 'puan' => 20],

        // ══ M. AKADEMİK GÖREVLER ══
        'M.1' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 4],
        'M.2' => ['baslik' => 'Scopus veya ESCI dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 3],
        'M.3-M.7' => ['baslik' => 'Diğer uluslararası indeksli veya diğer ulusal hakemli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 1],
        'M.4' => ['baslik' => 'BKCI kapsamında yayımlanmış kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 3],
        'M.5' => ['baslik' => 'Diğer uluslararası veya ulusal yayınevi kitabında editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 2],
        'M.6' => ['baslik' => "ULAKBİM TR-Dizin'de indekslenmiş dergide editörlük", 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 2],
        'M.10-M.11' => ['baslik' => 'Bilimsel toplantı veya kamu/STK programında davetli konuşmacı, panelist ya da oturum başkanı', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 1],
        'M.10-M.11k' => ['baslik' => 'Bilimsel toplantıda oturum başkanlığı yapmak', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Uluslararası)', 'Oturum Başkanlığı (Ulusal)'], 'puan' => 1],
        'M.12' => ['baslik' => 'Mesleki kuruluşça organize edilen proje/tasarım/sergi yarışmasında jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 1],

        // ══ N. İDARİ GÖREVLER (yalnızca 1 yıllık taban değeri) ══
        'N.1' => ['baslik' => 'Rektörlük', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör'], 'puan' => 4],
        'N.2' => ['baslik' => 'Rektör yardımcılığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör Yardımcısı'], 'puan' => 3],
        'N.3' => ['baslik' => 'Dekanlık, başhekimlik, enstitü, yüksekokul veya meslek yüksekokulu müdürlüğü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü'], 'puan' => 2],
        'N.4' => ['baslik' => 'Rektör danışmanlığı veya bölüm başkanlığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı'], 'puan' => 1],
        'N.5' => ['baslik' => 'Dekan, enstitü, yüksekokul veya meslek yüksekokulu müdür yardımcılığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.'], 'puan' => 1],
        'N.6' => ['baslik' => 'Uygulama ve araştırma merkezi müdürlüğü veya senato üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 1],
        'N.7-N.8-N.9' => ['baslik' => 'Kalite kurulu, etik kurul veya BAP bilimsel komisyon üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 1],
        'N.11' => ['baslik' => 'Anabilim dalı başkanlığı, bölüm başkan yardımcılığı veya fakülte yönetim kurulu üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük', 'Bölüm Başkan Yardımcısı'], 'puan' => 1],
    ],

    'gruplar' => [
        'A-TUM' => ['A.*'],
        'A.1-TUM' => ['A.1-Q1', 'A.1-Q2', 'A.1-Q3', 'A.1-Q4', 'A.1'],
        'A.1-A.3' => ['A.1-Q1', 'A.1-Q2', 'A.1-Q3', 'A.1-Q4', 'A.1', 'A.2-A.3'],
        'A.1-A.4' => ['A.1-Q1', 'A.1-Q2', 'A.1-Q3', 'A.1-Q4', 'A.1', 'A.2-A.3', 'A.4'],
        'B-TUM' => ['B.*'],
        'C-TUM' => ['C.*'],
        'D-TUM' => ['D.*'],
        'E-TUM' => ['E.*'],
        'F-TUM' => ['F.*'],
        'G-TUM' => ['G.*'],
        'J-TUM' => ['J.*'],
        'K-TUM' => ['K.*'],
        'M-TUM' => ['M.*'],
        'N-TUM' => ['N.*'],
    ],

    // Her bölümün kendi "en fazla N puan alınabilir" notu. I bölümüne
    // KASITLI OLARAK tavan yazılmadı (I.1 tavansız, bkz. dosya başlığı).
    'grup_tavanlari' => [
        'B-TUM' => 20,
        'C-TUM' => 50,
        'D-TUM' => 10,
        'E-TUM' => 20,
        'F-TUM' => 35,
        'G-TUM' => 15,
        'H-DERS' => 10,
        'J-TUM' => 35,
        'K-TUM' => 55,
        'M-TUM' => 15,
        'N-TUM' => 15,
    ],
];
