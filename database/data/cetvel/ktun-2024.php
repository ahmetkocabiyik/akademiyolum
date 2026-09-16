<?php

use App\Enums\Kategori;

/**
 * KONYA TEKNİK ÜNİVERSİTESİ — Tablo 1 Akademik Atama-Yükseltme Ölçütleri
 * Puan Tablosu
 * Kaynak: pdf/17537002512.konyateknikuniverstesi.pdf (24 sayfa)
 *
 * İKİ CETVEL: `ktun-2024` genel; `ktun-2024-mps` Mimarlık, Planlama ve
 * Tasarım ile Sosyal, Beşeri ve İdari Bilimler temel alanları için.
 * Aralarındaki TEK fark A-1g satırı: bu iki alanda "alan indeksleri"
 * (Avery, DAAI, Art Index, ICONDA, Ergo-Abs, Scopus) kapsamındaki makale
 * 50 puan, diğer alanlarda aynı dergiler A-4a'dan 15 puan. Fark cetvelde
 * A-4a satırının puanı değiştirilerek verildi; A-1g'nin Scopus kolu
 * `ESCI / Scopus` etiketinde ESCI ile birleştiği için oradan değil,
 * `Diğer Uluslararası İndeks` etiketinden okunuyor.
 *
 * ── AHCI DERGİLERİ Q4'TEN SAYILIYOR ──
 * Tablo 2 AHCI dergilerinin çeyreğini Scimago'ya bakarak belirliyor;
 * kayıt AHCI için çeyrek taşımadığından §0 uyarınca en düşük çeyrek (Q4)
 * satırlarına eklendi. AHCI'de Q1 makaleniz varsa puanınız OLDUĞUNDAN
 * DÜŞÜK (20 yerine 50).
 *
 * ── AYNI ETİKETE DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   B-1.1 sözlü özet (5), B-2 poster tam metin (6) ve B-2.1 poster özet
 *       (3) tek 'Uluslararası Özet/Poster' etiketine düşüyor → 3. Ulusal
 *       karşılığı (E-1.1 4 / E-2 5 / E-2.1 3) → 3.
 *   L bölümünde uluslararası faydalı model (60) ile ulusal (30) → 30;
 *       uluslararası tasarım (50) ile ulusal (25) → 25; çeşit/ırk/marka
 *       (40/20) → 20; bilgisayar programı (40/20) → 20.
 *   M-1 derece (60/30) ile M-3 mansiyon (40/20) tek 'Yarışma Derecesi /
 *       Mansiyon' etiketine düşüyor → 20.
 *   O bölümünde hakemlik (Q dergi 5 / diğer 2 / ulusal 2) → 2; yayın
 *       kurulu üyeliği (3/1/1) → 1; editörlük satırlarında editör,
 *       editör yardımcısı ve kurul üyesi ayrımı yok → her çeyrek için en
 *       düşük değer (Q1-Q2 12, Q3-Q4 8, diğer 3, ulusal 3).
 *   R-1 periyodik jürili uluslararası ödül (200) ile R-3 uluslararası
 *       ödül (80) → 80; R-2 (150/75) ile R-4 (50) → ulusal 50.
 *   K-1'de koordinatörlük (150) ile yürütücülük (120) ayrımı yok → 120.
 *   J-1 bursta süre kademesi (10/20/40) okunamıyor → 10.
 *   H-2 tez jüri üyeliği (YL 1 / doktora 2) ve H-3 tez izleme komitesi
 *       üyeliği (3) tek etikete düşüyor → 1.
 *
 * ── UYGULANMAYAN AZALTMA: PATENT SÜREÇ ÇARPANI ──
 * Tablo 2'nin L açıklaması patent puanını başvuruda ¼, araştırma/buluş
 * onayında ½, tescilde tam olarak hesaplıyor. Kayıt tescil aşamasını
 * taşımadığı için hepsi TESCİLLİ sayılıyor; henüz başvuru aşamasındaki
 * bir patentte puanınız OLDUĞUNDAN YÜKSEK görünür.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   A-1e / A-2e (Q dergilerde yayımlanan kongre makalesi): Tablo 2 aynı
 *       bildiriyi hem burada hem B bölümünde puanlamayı yasaklıyor;
 *       kayıt hangisinde beyan edildiğini bilmediği için satır girilmedi.
 *   A-5 (alan indekslerine girmeyen uluslararası ve mesleki dergiler, 4)
 *       ile D-3 (mesleki/kurumsal ulusal dergi, 4) — sözlükte karşılık
 *       yok.
 *   K-5 (aylık araştırma faaliyeti), N-1 (aylık danışmanlık),
 *       J-2, M-7, O-3/4/5/9/10/11, P, S-1 — süreye, adede ya da sözlükte
 *       karşılığı olmayan görevlere bağlı.
 *   BAP ve Döner Sermaye projeleri: K-3 bunları AÇIKÇA dışlıyor, bu
 *       yüzden 'BAP (Üniversite)' ve 'Öğrenci Projesi' etiketlerine satır
 *       verilmedi — bu projeler cetvelde 0 puan.
 *
 * ── MOTORUN KARŞILAYAMADIĞI SINIRLAR ──
 *   G bölümünün "atıf puanı kadronun asgari puanının %20'sini geçemez"
 *       kuralı kadroya bağlı; statik tavana çevrilemedi.
 *   "Aynı bilimsel toplantıdan en fazla 3 bildiri", "son 2 yıl içindeki
 *       dersler", "yılda en fazla 10 hakemlik", "O bölümünün tamamından
 *       en fazla 100 puan", "genişletilmiş yeni baskıda yarım puan".
 *
 * Yönerge: yonerge/ktun.php
 */
$OZGUN = ['ozgun_makale'];
$DERLEME = ['derleme'];
$KISA = ['kisa_makale'];
$VAKA = ['vaka_teknik_not'];
$TUM_KISA = ['derleme', 'kisa_makale', 'vaka_teknik_not'];
$Q4 = ['SCIE/SSCI (Q4)', 'AHCI'];

$sanatUlus = ['Kişisel Etkinlik (Uluslararası)', 'Elektronik Kişisel Sergi (Uluslararası)',
    'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)'];
$sanatUlusal = ['Kişisel Etkinlik (Ulusal)', 'Elektronik Kişisel Sergi (Ulusal)',
    'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)'];
$sanatKarmaU = ['Karma/Jürili Etkinlik (Uluslararası)', 'Elektronik Karma Sergi (Uluslararası)',
    'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)',
    'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Özgün Eser / Beste / Tasarım',
    'Uygulama Projesi — Müellif', 'Koruma-Onarım Uygulaması (Uluslararası)'];
$sanatJuri = ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)',
    'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'];
$sanatJuriU = ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)'];
$sanatJuriN = ['Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'];
$sanatSatin = ['Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Satın Alınması (Yurt İçi)',
    'Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Müzeye Kabulü (Yurt İçi)'];
$sanatKullanilan = array_merge($sanatUlus, $sanatUlusal, $sanatKarmaU, $sanatJuri, $sanatSatin);
$sanatKalan = array_values(array_diff(Kategori::SanatselEtkinlik->kaynaklar(), $sanatKullanilan));

/**
 * @return array<string, array<string, mixed>>
 */
$govde = function (bool $mps) use ($OZGUN, $DERLEME, $KISA, $VAKA, $TUM_KISA, $Q4,
    $sanatUlus, $sanatUlusal, $sanatKarmaU, $sanatJuriU, $sanatJuriN, $sanatSatin, $sanatKalan): array {
    return [
        // ══ A. ULUSLARARASI ÇALIŞMALAR ══
        'A-1a' => ['baslik' => 'Q1 kategorisindeki dergide yayımlanmış özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $OZGUN, 'puan' => 50],
        'A-1b' => ['baslik' => 'Q2 kategorisindeki dergide yayımlanmış özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $OZGUN, 'puan' => 40],
        'A-1c-Q1' => ['baslik' => 'Q1 kategorisindeki dergide yayımlanmış derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $DERLEME, 'puan' => 50],
        'A-1c-Q2' => ['baslik' => 'Q2 kategorisindeki dergide yayımlanmış derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $DERLEME, 'puan' => 40],
        'A-1d-Q1' => ['baslik' => 'Q1 kategorisindeki dergide yayımlanmış kısa makale (short/brief communication)', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $KISA, 'puan' => 35],
        'A-1d-Q2' => ['baslik' => 'Q2 kategorisindeki dergide yayımlanmış kısa makale (short/brief communication)', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $KISA, 'puan' => 30],
        'A-1f-Q1' => ['baslik' => 'Q1 kategorisindeki dergide yayımlanmış vaka raporu, teknik not, editöre mektup, kitap ya da makale tahlili', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $VAKA, 'puan' => 25],
        'A-1f-Q2' => ['baslik' => 'Q2 kategorisindeki dergide yayımlanmış vaka raporu, teknik not, editöre mektup, kitap ya da makale tahlili', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $VAKA, 'puan' => 20],
        'A-2a' => ['baslik' => 'Q3 kategorisindeki dergide yayımlanmış özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $OZGUN, 'puan' => 30],
        'A-2b' => ['baslik' => 'Q4 kategorisindeki dergide yayımlanmış özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => $Q4, 'turler' => $OZGUN, 'puan' => 20],
        'A-2c-Q3' => ['baslik' => 'Q3 kategorisindeki dergide yayımlanmış derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $DERLEME, 'puan' => 30],
        'A-2c-Q4' => ['baslik' => 'Q4 kategorisindeki dergide yayımlanmış derleme', 'kategori' => 'makale', 'kaynaklar' => $Q4, 'turler' => $DERLEME, 'puan' => 20],
        'A-2d-Q3' => ['baslik' => 'Q3 kategorisindeki dergide yayımlanmış kısa makale (short/brief communication)', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $KISA, 'puan' => 20],
        'A-2d-Q4' => ['baslik' => 'Q4 kategorisindeki dergide yayımlanmış kısa makale (short/brief communication)', 'kategori' => 'makale', 'kaynaklar' => $Q4, 'turler' => $KISA, 'puan' => 15],
        'A-2f-Q3' => ['baslik' => 'Q3 kategorisindeki dergide yayımlanmış vaka raporu, teknik not, editöre mektup, kitap ya da makale tahlili', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $VAKA, 'puan' => 15],
        'A-2f-Q4' => ['baslik' => 'Q4 kategorisindeki dergide yayımlanmış vaka raporu, teknik not, editöre mektup, kitap ya da makale tahlili', 'kategori' => 'makale', 'kaynaklar' => $Q4, 'turler' => $VAKA, 'puan' => 10],
        'A-3a' => ['baslik' => 'ESCI kategorisindeki dergide yayımlanmış özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $OZGUN, 'puan' => 20],
        'A-3b' => ['baslik' => 'ESCI kategorisindeki dergide yayımlanmış derleme, kısa makale, vaka raporu, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $TUM_KISA, 'puan' => 10],
        'A-4a' => [
            'baslik' => $mps
                ? 'Alan indeksleri (Avery, DAAI, Art Index, ICONDA, Ergo-Abs, Scopus) kapsamındaki dergide yayımlanmış makale'
                : 'Diğer uluslararası alan indeksleri kapsamındaki dergide yayımlanmış özgün araştırma makalesi',
            'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $OZGUN,
            'puan' => $mps ? 50 : 15,
        ],
        'A-4b' => ['baslik' => 'Diğer uluslararası alan indeksleri kapsamındaki dergide yayımlanmış derleme, kısa makale, vaka raporu ya da teknik not', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $TUM_KISA, 'puan' => 7],
        'A-6' => ['baslik' => 'Uluslararası özgün tasarım çalışması ya da sanat eseriyle jürili fuar, festival, çalıştay, gösteri, bienal veya trienale katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKarmaU, 'puan' => 15],

        // ══ B. ULUSLARARASI BİLDİRİLER ══
        'B-1' => ['baslik' => 'Uluslararası toplantıda sözlü sunulan ve tam metni yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 13],
        'B-1-davetli' => ['baslik' => 'Uluslararası toplantıda davetli konuşmacı bildirisi', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı (Uluslararası)'], 'puan' => 15],
        'B-2.1' => ['baslik' => 'Uluslararası toplantıda yabancı dilde sunulan ve özeti ya da posteri yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 3],

        // ══ C. ULUSLARARASI KİTAP ══
        'C-1' => ['baslik' => 'Uluslararası saygınlığı olan yayınevince basılmış kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 100],
        'C-2' => ['baslik' => 'Uluslararası saygınlığı olan yayınevince basılmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 30],
        'C-3' => ['baslik' => 'Uluslararası kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 50],

        // ══ D. ULUSAL ÇALIŞMALAR ══
        'D-1' => ['baslik' => 'TR Dizin kapsamındaki dergide yayımlanmış araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $OZGUN, 'puan' => 18],
        'D-1.1' => ['baslik' => 'TR Dizin kapsamındaki dergide yayımlanmış derleme, vaka takdimi, teknik not, kısa makale ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $TUM_KISA, 'puan' => 8],
        'D-2' => ['baslik' => 'Ulusal hakemli dergide yayımlanmış araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $OZGUN, 'puan' => 10],
        'D-2.1' => ['baslik' => 'Ulusal hakemli dergide yayımlanmış derleme, vaka takdimi, teknik not, kısa makale ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $TUM_KISA, 'puan' => 5],
        'D-4' => ['baslik' => 'Ulusal özgün tasarım çalışması ya da sanat eseriyle jürili fuar, festival, çalıştay, gösteri, bienal veya trienale katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => [...$sanatKalan, ...$sanatSatin], 'puan' => 8],

        // ══ E. ULUSAL BİLDİRİLER ══
        'E-1' => ['baslik' => 'Ulusal toplantıda sözlü sunulan ve tam metni yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 10],
        'E-2.1' => ['baslik' => 'Ulusal toplantıda sunulan ve özeti ya da posteri yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 3],

        // ══ F. ULUSAL KİTAP ══
        'F-1' => ['baslik' => 'Ulusal saygınlığı olan yayınevince basılmış kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Ders / Metot Kitabı'], 'puan' => 50],
        'F-2' => ['baslik' => 'Ulusal kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 20],
        'F-3' => ['baslik' => 'Ulusal kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 20],
        'F-4' => ['baslik' => 'Çeviri kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 25],
        'F-4.2' => ['baslik' => 'Kitap bölümü çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 5],

        // ══ G. ATIFLAR ══
        'G-1' => ['baslik' => 'Q kategorisindeki dergilerde ya da uluslararası bilimsel kitaplarda eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 3],
        'G-3' => ['baslik' => 'Diğer yurt dışı ya da yurt içi dergi, kitap ve bildiri kitaplarında eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer'], 'puan' => 1],
        'G-4' => ['baslik' => 'Patentlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Patent'], 'puan' => 4],

        // ══ H. ÖNLİSANS, LİSANS VE LİSANSÜSTÜ EĞİTİM-ÖĞRETİM ══
        'H-1' => ['baslik' => 'Eğitim-öğretim faaliyeti kapsamında verilen her bir ders (yarıyıl başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders'], 'puan' => 1],
        'H-2' => ['baslik' => 'Tez savunma jüri üyeliği ya da doktora tez izleme komitesi üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 1],
        'H-4' => ['baslik' => 'Uluslararası değişim programı kapsamında yabancı dilde ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 5],

        // ══ I. BİLİM İNSANI YETİŞTİRMEYE YÖNELİK ÇABALAR ══
        'I-1' => ['baslik' => 'Danışmanlığınızda tamamlanmış her bir yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 5],
        'I-1-es' => ['baslik' => 'İkinci danışman olarak tamamlanmış her bir yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 2],
        'I-2' => ['baslik' => 'Danışmanlığınızda tamamlanmış her bir doktora tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 10],
        'I-2-es' => ['baslik' => 'İkinci danışman olarak tamamlanmış her bir doktora tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 5],

        // ══ J. BURSLAR ══
        'J-1' => ['baslik' => 'Üniversite dışı kaynaklardan alınmış uluslararası burs', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 10],

        // ══ K. AR-GE PROJELERİ ══
        'K-1-y' => ['baslik' => 'AB Çerçeve Programı, NIH, NSF ya da ERC araştırma projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 120],
        'K-1-a' => ['baslik' => 'AB Çerçeve Programı, NIH, NSF ya da ERC araştırma projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci'], 'puan' => 60],
        'K-1-b' => ['baslik' => 'AB Çerçeve Programı, NIH, NSF ya da ERC araştırma projesinde bursiyer olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['bursiyer'], 'puan' => 30],
        'K-2-y' => ['baslik' => 'Diğer uluslararası destekli ya da ortaklı araştırma projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 80],
        'K-2-a' => ['baslik' => 'Diğer uluslararası destekli ya da ortaklı araştırma projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci'], 'puan' => 40],
        'K-2-b' => ['baslik' => 'Diğer uluslararası destekli ya da ortaklı araştırma projesinde bursiyer olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['bursiyer'], 'puan' => 20],
        'K-3-y' => ['baslik' => 'Ulusal destekli ya da ortaklı araştırma-geliştirme projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 60],
        'K-3-a' => ['baslik' => 'Ulusal destekli ya da ortaklı araştırma-geliştirme projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['arastirmaci'], 'puan' => 30],
        'K-3-b' => ['baslik' => 'Ulusal destekli ya da ortaklı araştırma-geliştirme projesinde bursiyer olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['bursiyer'], 'puan' => 15],
        'K-4' => ['baslik' => 'Uluslararası ya da ulusal Ar-Ge projesinde danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon', 'TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['danisman'], 'puan' => 20],

        // ══ L. PATENTLER VE TESCİLLER ══
        'L-1' => ['baslik' => 'Alanınızda uluslararası tescillenmiş patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 160],
        'L-2' => ['baslik' => 'Alanınızda ulusal tescillenmiş patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 80],
        'L-2f' => ['baslik' => 'Alanınızda tescillenmiş faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model'], 'puan' => 30],
        'L-2t' => ['baslik' => 'Alanınızda tescillenmiş tasarım', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım'], 'puan' => 25],
        'L-3' => ['baslik' => 'Alanınızda tescillenmiş çeşit, ırk ya da marka', 'kategori' => 'patent', 'kaynaklar' => ['Islahçı Hakkı / Çeşit Tescili'], 'puan' => 20],
        'L-4' => ['baslik' => 'Başvurduğunuz bilim alanında tescil edilmiş orijinal bilgisayar programı yazarlığı', 'kategori' => 'patent', 'kaynaklar' => ['Yazılım'], 'puan' => 20],

        // ══ M. YARIŞMALAR, SERGİLEME ══
        'M-3' => ['baslik' => 'Yarışmada derece ya da mansiyon almak', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 20],
        // Kaynak O-1.3 (ULUSLARARASI sanat ve tasarım etkinliklerinde hakemlik veya jüri üyeliği) 5, O-7.2 (ULUSAL) 2 diyor; iki kapsam tek satırda 2 puanla birleşmişti.
        'O-1.3' => ['baslik' => 'Uluslararası başvurduğunuz bilim alanıyla ilgili yarışmalarda jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatJuriU, 'puan' => 5],
        'M-6' => ['baslik' => 'Ulusal başvurduğunuz bilim alanıyla ilgili yarışmalarda jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatJuriN, 'puan' => 2],
        'M-8-u' => ['baslik' => 'Uluslararası kişisel tasarım ya da sanat etkinliğinde bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatUlus, 'puan' => 20],
        'M-8-n' => ['baslik' => 'Ulusal kişisel tasarım ya da sanat etkinliğinde bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatUlusal, 'puan' => 10],

        // ══ N. DANIŞMANLIK VE ÜNİVERSİTE-SANAYİ İŞBİRLİĞİ ══
        'N-2' => ['baslik' => 'Teknopark ve benzeri alanlarda şirket kurucusu ya da ortağı olmak', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 20],
        'N-3' => ['baslik' => 'Üniversite-sanayi ya da kamu kurumu işbirliği kapsamında tamamlanmış proje tasarım faaliyeti', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı', 'Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın'], 'puan' => 5],
        'N-4' => ['baslik' => 'Bilirkişilik faaliyeti', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 2],

        // ══ O. BİLİMSEL VE SANATSAL FAALİYETLERE KATKI ══
        'O-1' => ['baslik' => 'Bilimsel dergilerde hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 2],
        'O-2' => ['baslik' => 'Dergilerde yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 1],
        'O-6.1' => ['baslik' => 'Q1 ve Q2 kategorisindeki dergilerde editörlük, editör yardımcılığı ya da editör kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)'], 'puan' => 12],
        'O-6.2' => ['baslik' => 'Q3 ve Q4 kategorisindeki dergilerde editörlük, editör yardımcılığı ya da editör kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 8],
        'O-6.3' => ['baslik' => 'Q kategorisi dışındaki dergilerde editörlük, editör yardımcılığı ya da editör kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 3],
        'O-12' => ['baslik' => 'Ulusal dergilerde editörlük, editör yardımcılığı ya da editör kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 3],

        // ══ R. ÖDÜLLER ══
        'R-3' => ['baslik' => 'Uluslararası bilim ya da sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 80],
        'R-4' => ['baslik' => 'Ulusal bilim ya da sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü'], 'puan' => 50],

        // ══ S. ÜNİVERSİTE YÖNETİMİNE VE İŞLEYİŞİNE KATKILAR ══
        'S-2' => ['baslik' => 'Rektör, rektör yardımcısı, dekan, enstitü ya da yüksekokul müdürü olarak görev yapmak (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü'], 'puan' => 6],
        'S-3' => ['baslik' => 'Dekan yardımcısı ya da müdür yardımcısı olarak görev yapmak (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.'], 'puan' => 5],
        'S-4' => ['baslik' => 'Bölüm başkanı, anabilim dalı başkanı ya da uygulama ve araştırma merkezi müdürü olarak görev yapmak (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı', 'Anabilim Dalı Başkanı / Koordinatörlük', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 4],
        'S-7' => ['baslik' => 'Bölüm ya da birim işleyişiyle ilgili komisyon üyeliği ve koordinatörlük (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği', 'Bölüm Başkan Yardımcısı'], 'puan' => 1],
        'O-5k' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı ya da kurul üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)', 'Toplantı Düzenleme Başkanlığı (Ulusal)', 'Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 2],
    ];
};

/**
 * @param  array<string, array<string, mixed>>  $maddeler
 * @return list<string>
 */
$onek = function (array $maddeler, string ...$onekler): array {
    return array_values(array_filter(array_keys($maddeler), function (string $kod) use ($onekler) {
        foreach ($onekler as $o) {
            if (str_starts_with($kod, $o)) {
                return true;
            }
        }

        return false;
    }));
};

/**
 * @param  array<string, array<string, mixed>>  $maddeler
 * @return array<string, list<string>>
 */
$gruplariKur = function (array $maddeler, bool $mps) use ($onek): array {
    $a = $onek($maddeler, 'A-');
    $b = $onek($maddeler, 'B-');
    $c = $onek($maddeler, 'C-');
    $d = $onek($maddeler, 'D-');
    $e = $onek($maddeler, 'E-');
    $f = $onek($maddeler, 'F-');
    $g = $onek($maddeler, 'G-');
    $k = $onek($maddeler, 'K-');
    $l = $onek($maddeler, 'L-');
    $m = $onek($maddeler, 'M-');
    $o = $onek($maddeler, 'O-');

    // 8b: A-1a / A-1b / A-2a / A-2b türü yayınlar.
    $aQ = ['A-1a', 'A-1b', 'A-2a', 'A-2b'];
    // 9b (MPS): A-1a / A-1b / A-1g / A-2a / A-2b / A-3a / A-4a / B / C-1 / C-2.
    $aMps = ['A-1a', 'A-1b', 'A-4a', 'A-2a', 'A-2b', 'A-3a'];

    return [
        'A' => $a, 'B' => $b, 'C' => $c, 'D' => $d, 'E' => $e, 'F' => $f, 'G' => $g,
        'K' => $k, 'L' => $l, 'M' => $m,

        // Tavanı olan iki küme. Hiçbir koşul bunları saymıyor (koşullar
        // yalnız A-G, K, L, M kullanıyor), yani tavanlar barajları değil
        // listede görünen toplam puanı düzeltiyor.
        'O' => $o,
        'H-DERS' => ['H-1'],

        'AG-KLM' => array_merge($a, $b, $c, $d, $e, $f, $g, $k, $l, $m),
        'BCDEF' => array_merge($b, $c, $d, $e, $f),
        'KLM' => array_merge($k, $l, $m),
        'K123LM' => array_merge($onek($maddeler, 'K-1', 'K-2', 'K-3'), $l, $m),

        'A-Q' => $aQ,
        'A-Q-MPS' => $aMps,
        'DR-8b' => $mps ? array_merge($aMps, $b, ['C-1', 'C-2']) : $aQ,
        'DR-8e-telafi' => $mps ? array_merge($aMps, $b, ['C-1', 'C-2']) : array_merge($aQ, ['A-3a']),

        // Başlıca eser kümeleri (madde 6).
        'BASLICA-DR' => $mps
            ? array_merge($aMps, ['C-1', 'C-2'])
            : array_merge($aQ, ['C-1', 'C-2']),
        'BASLICA-DOC' => $mps
            ? array_merge($aMps, ['C-1', 'C-2'])
            : ['A-1a', 'A-1b', 'A-2a', 'C-1'],

        // 10b / 11b: doktora sonrası en az 1 faaliyet.
        'DOC-10b' => $mps
            ? array_merge($aMps, ['C-1', 'C-2'])
            : ['A-1a', 'A-1b', 'A-2a', 'C-1'],
        // 10c / 11c: en az 80 puan.
        'DOC-10c' => $mps
            ? array_merge($aMps, ['D-1'], $b, ['C-1', 'C-2'])
            : ['A-1a', 'A-1b', 'A-2a', 'A-2b', 'A-3a', 'C-1', 'C-2'],
        // 12b / 13b: doçentlik sonrası en az 2 faaliyet.
        'PROF-12b' => $mps
            ? array_merge($aMps, ['C-1', 'C-2'])
            : ['A-1a', 'A-1b', 'A-2a', 'A-2b', 'C-1', 'C-2'],

        // 8c: D-1 / D-2 makaleler ve B-1 / E-1 bildiriler.
        'D1' => ['D-1'],
        'D12' => ['D-1', 'D-2'],
        'B1E1' => ['B-1', 'B-1-davetli', 'E-1'],
        // 9c (MPS): B-1, B-2, D veya E-1.
        'DR-9c' => array_merge($b, $d, ['E-1']),

        // 10f / 11f: tez danışmanlığı (eş danışman sayılmaz).
        'TEZ-DANISMAN' => ['I-1', 'I-2'],
    ];
};

$KAPSAM = 'Puanlar Konya Teknik Üniversitesi Akademik Atama-Yükseltme Ölçütleri Puan '
    .'Tablosundan (Tablo 1). Yazar çarpanı yalnızca A, B, D ve E kategorilerine uygulanıyor '
    .'(Ek-1): ilk isim iki yazarlıda 0,95; üç yazarlıda 0,72; on yazarlıda 0,39 — diğer yazarlar '
    .'sırasıyla 0,70; 0,47; 0,14. On yazardan fazlasında ilk isme (Tablo 1 puanı × 4) / yazar '
    .'sayısı, diğerlerine (Tablo 1 puanı × 1,4) / yazar sayısı düşüyor. Uluslararası ve ulusal '
    .'kitap puanları da (C ve F) Tablo 2 uyarınca yazar sayısına bölünüyor. Yazar listesini boş '
    .'bırakırsanız çarpan hiç uygulanmaz ve puanınız olduğundan YÜKSEK görünür. '
    .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: AHCI dergileri çeyrek taşımadığı için Q4 '
    .'satırından sayılıyor (özgün makalede 20; Scimago\'da Q1 bir AHCI dergisinde 50 olmalıydı). '
    .'Özet ve poster bildiriler tek satıra düştüğü için 3 puandan, hakemlikler 2 puandan, yayın '
    .'kurulu üyelikleri 1 puandan sayılıyor. Ödüllerde periyodik ve jürili olma ayrımı '
    .'okunamadığı için uluslararası 80, ulusal 50 puandan sayılıyor. Bursta süre kademesi '
    .'(1-3 ay 10, 3-6 ay 20, 6 aydan uzun 40) okunamadığı için hepsi 10 puandan. K-1\'de '
    .'koordinatörlük (150) yürütücülükten (120) ayrılamıyor. BAP ve döner sermaye projeleri '
    .'K-3\'ün kapsamı dışında bırakıldığı için cetvelde 0 puan — yönergenin kendi kuralı. '
    .'A-1e ve A-2e (Q dergilerde yayımlanan kongre makalesi) satırları, Tablo 2 aynı bildiriyi '
    .'iki kategoride puanlamayı yasakladığı ve kayıt hangisinde beyan edildiğini bilmediği için '
    .'girilmedi. '
    .'Puanınız şu kalemde OLDUĞUNDAN YÜKSEK görünebilir: patentlerde Tablo 2 başvuru aşamasına '
    .'puanın dörtte birini, araştırma onayına yarısını veriyor; kayıt aşamayı taşımadığı için '
    .'hepsi TESCİLLİ sayılıyor. Ayrıca "aynı toplantıdan en fazla 3 bildiri", "son 2 yıl '
    .'içindeki dersler" ve "yılda en fazla 10 hakemlik" sınırları ile atıf puanının '
    .'asgari puana bağlı %20 sınırı uygulanmıyor. Buna karşılık "O bölümünden en fazla '
    .'100 puan" ile ders satırının 20 puanlık tavanı UYGULANIYOR.';

// Ek-1 Tablo 3: ortak çalışmalar için çarpanlar (A, B, D, E kategorileri).
// On yazardan fazlasında ilk isim (puan × 4) / n, diğerleri (puan × 1,4) / n.
// Tablo 2'nin C ve F açıklamaları kitap puanlarının da yazar sayısına
// bölünmesini istiyor; `kitap` bu yüzden `haric` listesinde değil ve
// ortak yazar dalından 1/n alıyor.
$YAZAR = [
    'haric' => ['atif', 'proje', 'patent', 'tez_danismanligi', 'egitim_ogretim', 'editorluk',
        'sanatsal_etkinlik', 'odul', 'idari_gorev', 'toplumsal_katki', 'diger'],
    'roller' => [
        'tek' => ['kademeler' => [1 => 1.00]],
        'ilk' => ['kademeler' => [1 => 1.00, 2 => 0.95, 3 => 0.72, 4 => 0.60, 5 => 0.53,
            6 => 0.48, 7 => 0.45, 8 => 0.43, 9 => 0.41, 10 => 0.39], 'bol' => ['pay' => 4.0]],
        'baslica' => ['kademeler' => [1 => 1.00, 2 => 0.95, 3 => 0.72, 4 => 0.60, 5 => 0.53,
            6 => 0.48, 7 => 0.45, 8 => 0.43, 9 => 0.41, 10 => 0.39], 'bol' => ['pay' => 4.0]],
        'ortak' => ['kademeler' => [1 => 1.00, 2 => 0.70, 3 => 0.47, 4 => 0.35, 5 => 0.28,
            6 => 0.23, 7 => 0.20, 8 => 0.18, 9 => 0.16, 10 => 0.14], 'bol' => ['pay' => 1.4]],
    ],
];

$genel = $govde(false);
$mps = $govde(true);

/*
 * Tablo 2'nin iki tavanı. İkisi de 01.09.2026'ya kadar uygulanmıyordu ve
 * `kapsam_notu` bunu "uygulanmıyor" diye sayıyordu; oysa ikisi de sabit sayı,
 * yani `grup_tavanlari`'na birebir giriyor. Tavansız bölüm fazla saydırır (§0).
 *
 *   O bölümü başlığı: "(O bölümünün tamamından en fazla 100 puan kullanılabilir)"
 *   H-1 dipnotu: "… bu faaliyet kapsamında aday en fazla 20 puan alabilir."
 *
 * Kaynağın öteki sınırları hâlâ uygulanamıyor ve notta sayılıyor: "aynı
 * toplantıdan en fazla 3 bildiri" ile "yılda en fazla 10 hakemlik" adet
 * tavanları, "atıf puanı asgari puanın %20'sini geçemez" ise başka bir
 * toplama bağlı olduğu için.
 */
$TAVANLAR = [
    'O' => 100,
    'H-DERS' => 20,
];

return [
    'cetveller' => [
        'ktun-2024' => [
            'kapsam_notu' => $KAPSAM,
            'yazar_katsayisi' => $YAZAR,
            'maddeler' => $genel,
            'gruplar' => $gruplariKur($genel, false),
            'grup_tavanlari' => $TAVANLAR,
        ],
        'ktun-2024-mps' => [
            'kapsam_notu' => $KAPSAM.' Mimarlık, Planlama ve Tasarım ile Sosyal, Beşeri ve İdari '
                .'Bilimler temel alanlarında alan indeksleri (Avery, DAAI, Art Index, ICONDA, '
                .'Ergo-Abs, Scopus) kapsamındaki makale A-1g\'den 50 puan alıyor. Bu satır '
                .'"Diğer Uluslararası İndeks" etiketinden okunuyor; Scopus kolu sözlükte ESCI '
                .'ile birleştiği için Scopus makaleniz ESCI satırından (20) sayılır ve puanınız '
                .'OLDUĞUNDAN DÜŞÜK görünür.',
            'yazar_katsayisi' => $YAZAR,
            'maddeler' => $mps,
            'gruplar' => $gruplariKur($mps, true),
            'grup_tavanlari' => $TAVANLAR,
        ],
    ],
];
