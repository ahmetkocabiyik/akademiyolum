<?php

/**
 * SAKARYA ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma Ölçütleri
 * Kaynak: pdf/1780987685769.sakarya-kriter-09062026.pdf (32 sayfa)
 *
 * FAKÜLTE GRUBU BAŞINA EŞİK, ORTAK PUAN TABLOSU. EK-1'in 231 ölçütü bütün
 * fakültelerde aynı puanı taşıyor (cetvel/sakarya-2026.php); değişen, hangi
 * ölçüt kümesinden ne kadar puan isteneceği.
 *
 * HER GRUPTA DÖRT "BÖLÜM" KÜMESİ, her biri EK-1 kodlarını TEK TEK sayarak
 * tanımlı — bu yüzden kümeler burada kod listesi olarak yazıldı, kısayol
 * (ör. "1.*") kullanılmadı. 3. BÖLÜM'ün Dr. Öğr. Üyesi sütunu "-" taşıyor,
 * yani o kadroda koşul yok.
 *
 * KÜMELER CETVELE GİRMİŞ KODLARLA SINIRLI. EK-1'in 231 ölçütünden 127'si
 * kaynak sözlüğüne eşlenebildi; kümelerde anılan ama cetvelde karşılığı olmayan
 * kodlar (yurt dışı araştırma faaliyeti, tasarım, dernek üyeliği vb.) listeden
 * çıkarıldı. Baraj bu yüzden gerçekte olduğundan zor görünür — aday koşulu
 * sağladığı hâlde sağlamamış gibi görünebilir, tersi olmaz.
 *
 * 2.3 GRUBUNUN BAŞLIĞI İKİ SATIR ve ikinci satırı ilk girişte düşmüştü:
 * "...Tıp Fakültesi, Sağlık Bilimleri Fakültesi ve Diş Hekimliği Fakültesi".
 * Sağlık temel alanı bu yüzden kapsam dışı görünüyordu; düzeltildi. PDF'ten
 * tablo çıkarırken başlığın SATIR SONUNDA BİTMEDİĞİNİ kontrol et.
 *
 * FAKÜLTE → TEMEL ALAN eşlemesi yaklaşık: yönerge fakülteye göre grupluyor,
 * uygulama doçentlik temel alanına göre. 2.3 (Mühendislik ve Fen'in Kimya,
 * Fizik, Biyoloji bölümleri) `muhendislik`, 2.4 (Fen'in Matematik bölümü)
 * `fen` sayıldı; ikisi de "fen" olsaydı aynı alanda iki eşik çakışırdı.
 * Meslek Yüksekokulları grubu (2.9) girilmedi — bir temel alana karşılık
 * gelmiyor.
 *
 * 1. BÖLÜM DİPNOTU `beyan` olarak duruyor: her grup ve kadro için "1.1a
 * kapsamında üç adet yayın YA DA şu proje kodlarından bir adet" biçiminde
 * alternatifli bir ek koşul var. Alternatif kümeler kadro başına değiştiği
 * için düğüm olarak değil, metniyle beyan edildi — atlanması koşulu sessizce
 * gevşetirdi.
 *
 * YÖNERGEDEKİ BİR TUTARSIZLIK: 2.8 ve 2.9 gruplarının 2. BÖLÜM kümesi `4.3c`
 * kodunu sayıyor ama EK-1'de 4.3a ve 4.3b var, 4.3c yok.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip
 */

use App\Services\Scoring\Sart\Kalip;

return [
    // ══ 2.3 Mühendislik, Bilişim, Fen (Kimya-Fizik-Biyoloji), Tıp, Sağlık Bil., Diş Hek. — Dr. Öğr. Üyesi ══
    [
        'anahtar' => 'sakarya-dr-2_3',
        'aday_notu' => 'Sakarya eşiği fakülte grubuna göre belirlenir; bu eşik Mühendislik, Bilgisayar ve '
            .'Bilişim Bilimleri, Fen (Kimya, Fizik, Biyoloji), Tıp, Sağlık Bilimleri ve Diş '
            .'Hekimliği fakülteleri için geçerlidir. Dört bölüm barajının her biri ayrı ayrı sağlanmalı.',
        'universite' => 'Sakarya Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['muhendislik', 'saglik'],
        'cetvel' => 'sakarya-2026',
        'notlar' => '2.3 Mühendislik, Bilgisayar ve Bilişim Bilimleri, Fen (Kimya, Fizik, Biyoloji), Tıp, Sağlık Bilimleri ve Diş Hekimliği fakülteleri — Dr. Öğr. Üyesi sütunu.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi kadrosuna atanma', [
            Kalip::toplam(1000),
            Kalip::puanDan('Nitelikli yayın ve proje ölçütlerinden en az 350 puan', [
                '1.1a', '1.1b', '1.1c', '1.1d', '1.1e', '2.1a', '2.1b', '2.1d',
                '2.1e', '2.2a', '2.2d', '2.2e', '2.3a', '2.3b', '2.3c', '2.4a',
                '2.4b', '2.5a', '2.5c', '2.11a', '2.12a', '3.1', '4.1a', '4.1b',
                '4.2a', '4.3a',
            ], 350, madde: '2.3 · 1. BÖLÜM'),
            Kalip::puanDan('Yayın, proje, patent ve editörlük ölçütlerinden en az 250 puan', [
                '1.1a', '1.1b', '1.1c', '1.1d', '1.1e', '1.2a', '1.2b', '1.3',
                '2.1a', '2.1b', '2.1c', '2.1d', '2.1e', '2.2a', '2.2b', '2.2c',
                '2.2d', '2.2e', '2.2f', '2.3a', '2.3b', '2.3c', '2.4a', '2.4b',
                '2.4c', '2.4d', '2.5a', '2.5b', '2.5c', '2.5d', '2.11a', '2.11b',
                '2.12a', '2.12b', '2.15', '3.1', '3.3', '4.1a', '4.1b', '4.2a',
                '4.3a', '4.4', '9.1', '10.1a',
            ], 250, madde: '2.3 · 2. BÖLÜM'),
            Kalip::puanDan('Kurumsal ve toplumsal katkı ölçütlerinden en az 40 puan', [
                '14.23', '14.25', '14.34', '14.38', '14.39', '14.40', '14.42', '14.43',
                '14.44', '2.11a', '2.11b', '2.11c', '2.11d', '2.11e',
            ], 40, madde: '2.3 · 4. BÖLÜM'),
            Kalip::beyan('Nitelikli yayın ve proje ölçütleri için ek koşul: SCI-E, SSCI, AHCI veya Scopus dergilerinde bir adet yayın ya da desteklenen araştırma projeleri kapsamında bir adet araştırma projesi', '2.3 dipnot'),
        ]),
    ],
    // ══ 2.3 Mühendislik, Bilişim, Fen (Kimya-Fizik-Biyoloji), Tıp, Sağlık Bil., Diş Hek. — Doçent ══
    [
        'anahtar' => 'sakarya-docent-2_3',
        'aday_notu' => 'Sakarya eşiği fakülte grubuna göre belirlenir; bu eşik Mühendislik, Bilgisayar ve '
            .'Bilişim Bilimleri, Fen (Kimya, Fizik, Biyoloji), Tıp, Sağlık Bilimleri ve Diş '
            .'Hekimliği fakülteleri için geçerlidir. Dört bölüm barajının her biri ayrı ayrı sağlanmalı.',
        'universite' => 'Sakarya Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['muhendislik', 'saglik'],
        'cetvel' => 'sakarya-2026',
        'notlar' => '2.3 Mühendislik, Bilgisayar ve Bilişim Bilimleri, Fen (Kimya, Fizik, Biyoloji), Tıp, Sağlık Bilimleri ve Diş Hekimliği fakülteleri — Doçent sütunu.',
        'sart' => Kalip::ve('Doçent kadrosuna atanma', [
            Kalip::toplam(1600),
            Kalip::puanDan('Nitelikli yayın ve proje ölçütlerinden en az 700 puan', [
                '1.1a', '1.1b', '1.1c', '1.1d', '1.1e', '2.1a', '2.1b', '2.1d',
                '2.1e', '2.2a', '2.2d', '2.2e', '2.3a', '2.3b', '2.3c', '2.4a',
                '2.4b', '2.5a', '2.5c', '2.11a', '2.12a', '3.1', '4.1a', '4.1b',
                '4.2a', '4.3a',
            ], 700, madde: '2.3 · 1. BÖLÜM'),
            Kalip::puanDan('Yayın, proje, patent ve editörlük ölçütlerinden en az 450 puan', [
                '1.1a', '1.1b', '1.1c', '1.1d', '1.1e', '1.2a', '1.2b', '1.3',
                '2.1a', '2.1b', '2.1c', '2.1d', '2.1e', '2.2a', '2.2b', '2.2c',
                '2.2d', '2.2e', '2.2f', '2.3a', '2.3b', '2.3c', '2.4a', '2.4b',
                '2.4c', '2.4d', '2.5a', '2.5b', '2.5c', '2.5d', '2.11a', '2.11b',
                '2.12a', '2.12b', '2.15', '3.1', '3.3', '4.1a', '4.1b', '4.2a',
                '4.3a', '4.4', '9.1', '10.1a',
            ], 450, madde: '2.3 · 2. BÖLÜM'),
            Kalip::puanDan('Tez yönetimi ve eğitim-öğretim ölçütlerinden en az 80 puan', [
                '13.1a', '13.1b', '13.2', '13.3', '2.11a', '2.11b', '2.11c', '2.11d',
                '2.11e', '12.1', '12.2',
            ], 80, madde: '2.3 · 3. BÖLÜM'),
            Kalip::puanDan('Kurumsal ve toplumsal katkı ölçütlerinden en az 80 puan', [
                '14.23', '14.25', '14.34', '14.38', '14.39', '14.40', '14.42', '14.43',
                '14.44', '2.11a', '2.11b', '2.11c', '2.11d', '2.11e',
            ], 80, madde: '2.3 · 4. BÖLÜM'),
            Kalip::beyan('Nitelikli yayın ve proje ölçütleri için ek koşul: SCI-E, SSCI, AHCI veya Scopus dergilerinde iki adet yayın ya da desteklenen araştırma projeleri kapsamında bir adet araştırma projesi', '2.3 dipnot'),
        ]),
    ],
    // ══ 2.3 Mühendislik, Bilişim, Fen (Kimya-Fizik-Biyoloji), Tıp, Sağlık Bil., Diş Hek. — Profesör ══
    [
        'anahtar' => 'sakarya-profesor-2_3',
        'aday_notu' => 'Sakarya eşiği fakülte grubuna göre belirlenir; bu eşik Mühendislik, Bilgisayar ve '
            .'Bilişim Bilimleri, Fen (Kimya, Fizik, Biyoloji), Tıp, Sağlık Bilimleri ve Diş '
            .'Hekimliği fakülteleri için geçerlidir. Dört bölüm barajının her biri ayrı ayrı sağlanmalı.',
        'universite' => 'Sakarya Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['muhendislik', 'saglik'],
        'cetvel' => 'sakarya-2026',
        'notlar' => '2.3 Mühendislik, Bilgisayar ve Bilişim Bilimleri, Fen (Kimya, Fizik, Biyoloji), Tıp, Sağlık Bilimleri ve Diş Hekimliği fakülteleri — Profesör sütunu.',
        'sart' => Kalip::ve('Profesör kadrosuna atanma', [
            Kalip::toplam(1800),
            Kalip::puanDan('Nitelikli yayın ve proje ölçütlerinden en az 750 puan', [
                '1.1a', '1.1b', '1.1c', '1.1d', '1.1e', '2.1a', '2.1b', '2.1d',
                '2.1e', '2.2a', '2.2d', '2.2e', '2.3a', '2.3b', '2.3c', '2.4a',
                '2.4b', '2.5a', '2.5c', '2.11a', '2.12a', '3.1', '4.1a', '4.1b',
                '4.2a', '4.3a',
            ], 750, madde: '2.3 · 1. BÖLÜM'),
            Kalip::puanDan('Yayın, proje, patent ve editörlük ölçütlerinden en az 500 puan', [
                '1.1a', '1.1b', '1.1c', '1.1d', '1.1e', '1.2a', '1.2b', '1.3',
                '2.1a', '2.1b', '2.1c', '2.1d', '2.1e', '2.2a', '2.2b', '2.2c',
                '2.2d', '2.2e', '2.2f', '2.3a', '2.3b', '2.3c', '2.4a', '2.4b',
                '2.4c', '2.4d', '2.5a', '2.5b', '2.5c', '2.5d', '2.11a', '2.11b',
                '2.12a', '2.12b', '2.15', '3.1', '3.3', '4.1a', '4.1b', '4.2a',
                '4.3a', '4.4', '9.1', '10.1a',
            ], 500, madde: '2.3 · 2. BÖLÜM'),
            Kalip::puanDan('Tez yönetimi ve eğitim-öğretim ölçütlerinden en az 120 puan', [
                '13.1a', '13.1b', '13.2', '13.3', '2.11a', '2.11b', '2.11c', '2.11d',
                '2.11e', '12.1', '12.2',
            ], 120, madde: '2.3 · 3. BÖLÜM'),
            Kalip::puanDan('Kurumsal ve toplumsal katkı ölçütlerinden en az 120 puan', [
                '14.23', '14.25', '14.34', '14.38', '14.39', '14.40', '14.42', '14.43',
                '14.44', '2.11a', '2.11b', '2.11c', '2.11d', '2.11e',
            ], 120, madde: '2.3 · 4. BÖLÜM'),
            Kalip::beyan('Nitelikli yayın ve proje ölçütleri için ek koşul: SCI-E, SSCI, AHCI veya Scopus dergilerinde üç adet yayın (en az birinde başlıca yazar olmalı) ya da desteklenen araştırma projeleri kapsamında bir adet araştırma projesi', '2.3 dipnot'),
        ]),
    ],
    // ══ 2.4 Fen Fakültesi (Matematik Bölümü) — Dr. Öğr. Üyesi ══
    [
        'anahtar' => 'sakarya-dr-2_4',
        'aday_notu' => 'Sakarya eşiği fakülte grubuna göre belirlenir; bu eşik Fen Fakültesi (Matematik Bölümü) '
            .'için geçerlidir. Dört bölüm barajının her biri ayrı ayrı sağlanmalı.',
        'universite' => 'Sakarya Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['fen'],
        'cetvel' => 'sakarya-2026',
        'notlar' => '2.4 Fen Fakültesi (Matematik Bölümü) — Dr. Öğr. Üyesi sütunu.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Fen Fakültesi (Matematik Bölümü)', [
            Kalip::toplam(800),
            Kalip::puanDan('Nitelikli yayın ve proje ölçütlerinden en az 250 puan', [
                '1.1a', '1.1b', '1.1c', '1.1d', '1.1e', '2.1a', '2.1b', '2.1d',
                '2.1e', '2.2a', '2.2d', '2.2e', '2.3a', '2.3b', '2.3c', '2.4a',
                '2.5a', '2.5c', '2.11a', '2.12a', '3.1', '4.1a', '4.1b', '4.2a',
                '4.3a',
            ], 250, madde: '2.4 · 1. BÖLÜM'),
            Kalip::puanDan('Yayın, proje, patent ve editörlük ölçütlerinden en az 250 puan', [
                '1.1a', '1.1b', '1.1c', '1.1d', '1.1e', '1.2a', '1.2b', '1.3',
                '2.1a', '2.1b', '2.1c', '2.1d', '2.1e', '2.2a', '2.2b', '2.2c',
                '2.2d', '2.2e', '2.2f', '2.3a', '2.3b', '2.3c', '2.4a', '2.4b',
                '2.4c', '2.5a', '2.5b', '2.5c', '2.5d', '2.11a', '2.11b', '2.12a',
                '2.12b', '2.15', '3.1', '3.3', '4.1a', '4.1b', '4.2a', '4.3a',
                '4.4', '9.1', '10.1a',
            ], 250, madde: '2.4 · 2. BÖLÜM'),
            Kalip::puanDan('Kurumsal ve toplumsal katkı ölçütlerinden en az 40 puan', [
                '14.23', '14.25', '14.34', '14.38', '14.39', '14.40', '14.42', '14.43',
                '14.44', '2.11a', '2.11b', '2.11c', '2.11d',
            ], 40, madde: '2.4 · 4. BÖLÜM'),
            Kalip::beyan('Nitelikli yayın ve proje ölçütleri için ek koşul: SCI-E, SSCI, AHCI veya Scopus dergilerinde bir adet yayın ya da desteklenen araştırma projeleri kapsamında bir adet araştırma projesi', '2.4 dipnot'),
        ]),
    ],
    // ══ 2.4 Fen Fakültesi (Matematik Bölümü) — Doçent ══
    [
        'anahtar' => 'sakarya-docent-2_4',
        'aday_notu' => 'Sakarya eşiği fakülte grubuna göre belirlenir; bu eşik Fen Fakültesi (Matematik Bölümü) '
            .'için geçerlidir. Dört bölüm barajının her biri ayrı ayrı sağlanmalı.',
        'universite' => 'Sakarya Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['fen'],
        'cetvel' => 'sakarya-2026',
        'notlar' => '2.4 Fen Fakültesi (Matematik Bölümü) — Doçent sütunu.',
        'sart' => Kalip::ve('Doçent — Fen Fakültesi (Matematik Bölümü)', [
            Kalip::toplam(1200),
            Kalip::puanDan('Nitelikli yayın ve proje ölçütlerinden en az 450 puan', [
                '1.1a', '1.1b', '1.1c', '1.1d', '1.1e', '2.1a', '2.1b', '2.1d',
                '2.1e', '2.2a', '2.2d', '2.2e', '2.3a', '2.3b', '2.3c', '2.4a',
                '2.5a', '2.5c', '2.11a', '2.12a', '3.1', '4.1a', '4.1b', '4.2a',
                '4.3a',
            ], 450, madde: '2.4 · 1. BÖLÜM'),
            Kalip::puanDan('Yayın, proje, patent ve editörlük ölçütlerinden en az 350 puan', [
                '1.1a', '1.1b', '1.1c', '1.1d', '1.1e', '1.2a', '1.2b', '1.3',
                '2.1a', '2.1b', '2.1c', '2.1d', '2.1e', '2.2a', '2.2b', '2.2c',
                '2.2d', '2.2e', '2.2f', '2.3a', '2.3b', '2.3c', '2.4a', '2.4b',
                '2.4c', '2.5a', '2.5b', '2.5c', '2.5d', '2.11a', '2.11b', '2.12a',
                '2.12b', '2.15', '3.1', '3.3', '4.1a', '4.1b', '4.2a', '4.3a',
                '4.4', '9.1', '10.1a',
            ], 350, madde: '2.4 · 2. BÖLÜM'),
            Kalip::puanDan('Tez yönetimi ve eğitim-öğretim ölçütlerinden en az 80 puan', [
                '13.1a', '13.1b', '13.2', '13.3', '2.11a', '2.11b', '2.11c', '2.11d',
                '2.11e', '12.1', '12.2',
            ], 80, madde: '2.4 · 3. BÖLÜM'),
            Kalip::puanDan('Kurumsal ve toplumsal katkı ölçütlerinden en az 80 puan', [
                '14.23', '14.25', '14.34', '14.38', '14.39', '14.40', '14.42', '14.43',
                '14.44', '2.11a', '2.11b', '2.11c', '2.11d',
            ], 80, madde: '2.4 · 4. BÖLÜM'),
            Kalip::beyan('Nitelikli yayın ve proje ölçütleri için ek koşul: SCI-E, SSCI, AHCI veya Scopus dergilerinde iki adet yayın ya da desteklenen araştırma projeleri kapsamında bir adet araştırma projesi', '2.4 dipnot'),
        ]),
    ],
    // ══ 2.4 Fen Fakültesi (Matematik Bölümü) — Profesör ══
    [
        'anahtar' => 'sakarya-profesor-2_4',
        'aday_notu' => 'Sakarya eşiği fakülte grubuna göre belirlenir; bu eşik Fen Fakültesi (Matematik Bölümü) '
            .'için geçerlidir. Dört bölüm barajının her biri ayrı ayrı sağlanmalı.',
        'universite' => 'Sakarya Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['fen'],
        'cetvel' => 'sakarya-2026',
        'notlar' => '2.4 Fen Fakültesi (Matematik Bölümü) — Profesör sütunu.',
        'sart' => Kalip::ve('Profesör — Fen Fakültesi (Matematik Bölümü)', [
            Kalip::toplam(1500),
            Kalip::puanDan('Nitelikli yayın ve proje ölçütlerinden en az 500 puan', [
                '1.1a', '1.1b', '1.1c', '1.1d', '1.1e', '2.1a', '2.1b', '2.1d',
                '2.1e', '2.2a', '2.2d', '2.2e', '2.3a', '2.3b', '2.3c', '2.4a',
                '2.5a', '2.5c', '2.11a', '2.12a', '3.1', '4.1a', '4.1b', '4.2a',
                '4.3a',
            ], 500, madde: '2.4 · 1. BÖLÜM'),
            Kalip::puanDan('Yayın, proje, patent ve editörlük ölçütlerinden en az 400 puan', [
                '1.1a', '1.1b', '1.1c', '1.1d', '1.1e', '1.2a', '1.2b', '1.3',
                '2.1a', '2.1b', '2.1c', '2.1d', '2.1e', '2.2a', '2.2b', '2.2c',
                '2.2d', '2.2e', '2.2f', '2.3a', '2.3b', '2.3c', '2.4a', '2.4b',
                '2.4c', '2.5a', '2.5b', '2.5c', '2.5d', '2.11a', '2.11b', '2.12a',
                '2.12b', '2.15', '3.1', '3.3', '4.1a', '4.1b', '4.2a', '4.3a',
                '4.4', '9.1', '10.1a',
            ], 400, madde: '2.4 · 2. BÖLÜM'),
            Kalip::puanDan('Tez yönetimi ve eğitim-öğretim ölçütlerinden en az 120 puan', [
                '13.1a', '13.1b', '13.2', '13.3', '2.11a', '2.11b', '2.11c', '2.11d',
                '2.11e', '12.1', '12.2',
            ], 120, madde: '2.4 · 3. BÖLÜM'),
            Kalip::puanDan('Kurumsal ve toplumsal katkı ölçütlerinden en az 120 puan', [
                '14.23', '14.25', '14.34', '14.38', '14.39', '14.40', '14.42', '14.43',
                '14.44', '2.11a', '2.11b', '2.11c', '2.11d',
            ], 120, madde: '2.4 · 4. BÖLÜM'),
            Kalip::beyan('Nitelikli yayın ve proje ölçütleri için ek koşul: SCI-E, SSCI, AHCI veya Scopus dergilerinde iki adet yayın ya da desteklenen araştırma projeleri kapsamında bir adet araştırma projesi', '2.4 dipnot'),
        ]),
    ],
    // ══ 2.5 Eğitim, Siyasal Bilgiler, İşletme, İletişim, İnsan ve Topl — Dr. Öğr. Üyesi ══
    [
        'anahtar' => 'sakarya-dr-2_5',
        'aday_notu' => 'Sakarya eşiği fakülte grubuna göre belirlenir; bu eşik Eğitim, Siyasal Bilgiler, İşletme, İletişim, İnsan ve Toplum Bil '
            .'için geçerlidir. Dört bölüm barajının her biri ayrı ayrı sağlanmalı.',
        'universite' => 'Sakarya Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['egitim', 'sosyal'],
        'cetvel' => 'sakarya-2026',
        'notlar' => '2.5 Eğitim, Siyasal Bilgiler, İşletme, İletişim, İnsan ve Toplum Bilimleri — Dr. Öğr. Üyesi sütunu.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Eğitim, Siyasal Bilgiler, İşletme, İletişim, İnsan ve Toplum Bilimleri', [
            Kalip::toplam(600),
            Kalip::puanDan('Nitelikli yayın ve proje ölçütlerinden en az 200 puan', [
                '1.1a', '1.1b', '1.1c', '1.1d', '1.1e', '1.2a', '1.2b', '2.1a',
                '2.1b', '2.1d', '2.1e', '2.2a', '2.2d', '2.2e', '2.3a', '2.3b',
                '2.3c', '2.3d', '2.3e', '2.3f', '2.4a', '2.4b', '2.4c', '2.5a',
                '2.5c', '2.10a', '2.11a', '2.12a', '3.1', '4.1a', '4.1b', '4.2a',
                '4.3a',
            ], 200, madde: '2.5 · 1. BÖLÜM'),
            Kalip::puanDan('Yayın, proje, patent ve editörlük ölçütlerinden en az 250 puan', [
                '1.1a', '1.1b', '1.1c', '1.1d', '1.1e', '1.2a', '1.2b', '1.3',
                '2.1a', '2.1b', '2.1c', '2.1d', '2.1e', '2.2a', '2.2b', '2.2c',
                '2.2d', '2.2e', '2.2f', '2.3a', '2.3b', '2.3c', '2.3d', '2.3e',
                '2.3f', '2.4a', '2.4b', '2.4c', '2.5a', '2.5b', '2.5c', '2.5d',
                '2.10a', '2.10b', '2.11a', '2.11b', '2.12a', '2.12b', '2.15', '3.1',
                '3.3', '3.7', '4.1a', '4.1b', '4.2a', '4.3a', '4.4', '5.14a',
                '9.1', '10.1a', '10.1b',
            ], 250, madde: '2.5 · 2. BÖLÜM'),
            Kalip::puanDan('Kurumsal ve toplumsal katkı ölçütlerinden en az 100 puan', [
                '14.23', '14.25', '14.34', '14.38', '14.39', '14.40', '14.42', '14.43',
                '14.44', '2.11a', '2.11b', '2.11c', '2.11d',
            ], 100, madde: '2.5 · 4. BÖLÜM'),
            Kalip::beyan('Nitelikli yayın ve proje ölçütleri için ek koşul: SCI-E, SSCI, AHCI veya Scopus dergilerinde bir adet yayın ya da desteklenen araştırma projeleri kapsamında bir adet araştırma projesi', '2.5 dipnot'),
        ]),
    ],
    // ══ 2.5 Eğitim, Siyasal Bilgiler, İşletme, İletişim, İnsan ve Topl — Doçent ══
    [
        'anahtar' => 'sakarya-docent-2_5',
        'aday_notu' => 'Sakarya eşiği fakülte grubuna göre belirlenir; bu eşik Eğitim, Siyasal Bilgiler, İşletme, İletişim, İnsan ve Toplum Bil '
            .'için geçerlidir. Dört bölüm barajının her biri ayrı ayrı sağlanmalı.',
        'universite' => 'Sakarya Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['egitim', 'sosyal'],
        'cetvel' => 'sakarya-2026',
        'notlar' => '2.5 Eğitim, Siyasal Bilgiler, İşletme, İletişim, İnsan ve Toplum Bilimleri — Doçent sütunu.',
        'sart' => Kalip::ve('Doçent — Eğitim, Siyasal Bilgiler, İşletme, İletişim, İnsan ve Toplum Bilimleri', [
            Kalip::toplam(800),
            Kalip::puanDan('Nitelikli yayın ve proje ölçütlerinden en az 300 puan', [
                '1.1a', '1.1b', '1.1c', '1.1d', '1.1e', '1.2a', '1.2b', '2.1a',
                '2.1b', '2.1d', '2.1e', '2.2a', '2.2d', '2.2e', '2.3a', '2.3b',
                '2.3c', '2.3d', '2.3e', '2.3f', '2.4a', '2.4b', '2.4c', '2.5a',
                '2.5c', '2.10a', '2.11a', '2.12a', '3.1', '4.1a', '4.1b', '4.2a',
                '4.3a',
            ], 300, madde: '2.5 · 1. BÖLÜM'),
            Kalip::puanDan('Yayın, proje, patent ve editörlük ölçütlerinden en az 300 puan', [
                '1.1a', '1.1b', '1.1c', '1.1d', '1.1e', '1.2a', '1.2b', '1.3',
                '2.1a', '2.1b', '2.1c', '2.1d', '2.1e', '2.2a', '2.2b', '2.2c',
                '2.2d', '2.2e', '2.2f', '2.3a', '2.3b', '2.3c', '2.3d', '2.3e',
                '2.3f', '2.4a', '2.4b', '2.4c', '2.5a', '2.5b', '2.5c', '2.5d',
                '2.10a', '2.10b', '2.11a', '2.11b', '2.12a', '2.12b', '2.15', '3.1',
                '3.3', '3.7', '4.1a', '4.1b', '4.2a', '4.3a', '4.4', '5.14a',
                '9.1', '10.1a', '10.1b',
            ], 300, madde: '2.5 · 2. BÖLÜM'),
            Kalip::puanDan('Tez yönetimi ve eğitim-öğretim ölçütlerinden en az 80 puan', [
                '13.1a', '13.1b', '13.2', '13.3', '2.11a', '2.11b', '2.11c', '2.11d',
                '2.11e', '12.1', '12.2',
            ], 80, madde: '2.5 · 3. BÖLÜM'),
            Kalip::puanDan('Kurumsal ve toplumsal katkı ölçütlerinden en az 150 puan', [
                '14.23', '14.25', '14.34', '14.38', '14.39', '14.40', '14.42', '14.43',
                '14.44', '2.11a', '2.11b', '2.11c', '2.11d',
            ], 150, madde: '2.5 · 4. BÖLÜM'),
            Kalip::beyan('Nitelikli yayın ve proje ölçütleri için ek koşul: SCI-E, SSCI, AHCI veya Scopus dergilerinde bir adet yayın ya da desteklenen araştırma projeleri kapsamında bir adet araştırma projesi', '2.5 dipnot'),
        ]),
    ],
    // ══ 2.5 Eğitim, Siyasal Bilgiler, İşletme, İletişim, İnsan ve Topl — Profesör ══
    [
        'anahtar' => 'sakarya-profesor-2_5',
        'aday_notu' => 'Sakarya eşiği fakülte grubuna göre belirlenir; bu eşik Eğitim, Siyasal Bilgiler, İşletme, İletişim, İnsan ve Toplum Bil '
            .'için geçerlidir. Dört bölüm barajının her biri ayrı ayrı sağlanmalı.',
        'universite' => 'Sakarya Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['egitim', 'sosyal'],
        'cetvel' => 'sakarya-2026',
        'notlar' => '2.5 Eğitim, Siyasal Bilgiler, İşletme, İletişim, İnsan ve Toplum Bilimleri — Profesör sütunu.',
        'sart' => Kalip::ve('Profesör — Eğitim, Siyasal Bilgiler, İşletme, İletişim, İnsan ve Toplum Bilimleri', [
            Kalip::toplam(1200),
            Kalip::puanDan('Nitelikli yayın ve proje ölçütlerinden en az 300 puan', [
                '1.1a', '1.1b', '1.1c', '1.1d', '1.1e', '1.2a', '1.2b', '2.1a',
                '2.1b', '2.1d', '2.1e', '2.2a', '2.2d', '2.2e', '2.3a', '2.3b',
                '2.3c', '2.3d', '2.3e', '2.3f', '2.4a', '2.4b', '2.4c', '2.5a',
                '2.5c', '2.10a', '2.11a', '2.12a', '3.1', '4.1a', '4.1b', '4.2a',
                '4.3a',
            ], 300, madde: '2.5 · 1. BÖLÜM'),
            Kalip::puanDan('Yayın, proje, patent ve editörlük ölçütlerinden en az 300 puan', [
                '1.1a', '1.1b', '1.1c', '1.1d', '1.1e', '1.2a', '1.2b', '1.3',
                '2.1a', '2.1b', '2.1c', '2.1d', '2.1e', '2.2a', '2.2b', '2.2c',
                '2.2d', '2.2e', '2.2f', '2.3a', '2.3b', '2.3c', '2.3d', '2.3e',
                '2.3f', '2.4a', '2.4b', '2.4c', '2.5a', '2.5b', '2.5c', '2.5d',
                '2.10a', '2.10b', '2.11a', '2.11b', '2.12a', '2.12b', '2.15', '3.1',
                '3.3', '3.7', '4.1a', '4.1b', '4.2a', '4.3a', '4.4', '5.14a',
                '9.1', '10.1a', '10.1b',
            ], 300, madde: '2.5 · 2. BÖLÜM'),
            Kalip::puanDan('Tez yönetimi ve eğitim-öğretim ölçütlerinden en az 120 puan', [
                '13.1a', '13.1b', '13.2', '13.3', '2.11a', '2.11b', '2.11c', '2.11d',
                '2.11e', '12.1', '12.2',
            ], 120, madde: '2.5 · 3. BÖLÜM'),
            Kalip::puanDan('Kurumsal ve toplumsal katkı ölçütlerinden en az 200 puan', [
                '14.23', '14.25', '14.34', '14.38', '14.39', '14.40', '14.42', '14.43',
                '14.44', '2.11a', '2.11b', '2.11c', '2.11d',
            ], 200, madde: '2.5 · 4. BÖLÜM'),
            Kalip::beyan('Nitelikli yayın ve proje ölçütleri için ek koşul: SCI-E, SSCI, AHCI veya Scopus dergilerinde bir adet yayın ya da desteklenen araştırma projeleri kapsamında bir adet araştırma projesi', '2.5 dipnot'),
        ]),
    ],
    // ══ 2.6 İlahiyat ve Hukuk Fakültesi — Dr. Öğr. Üyesi ══
    [
        'anahtar' => 'sakarya-dr-2_6',
        'aday_notu' => 'Sakarya eşiği fakülte grubuna göre belirlenir; bu eşik İlahiyat ve Hukuk Fakültesi '
            .'için geçerlidir. Dört bölüm barajının her biri ayrı ayrı sağlanmalı.',
        'universite' => 'Sakarya Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['ilahiyat', 'hukuk'],
        'cetvel' => 'sakarya-2026',
        'notlar' => '2.6 İlahiyat ve Hukuk Fakültesi — Dr. Öğr. Üyesi sütunu.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — İlahiyat ve Hukuk Fakültesi', [
            Kalip::toplam(600),
            Kalip::puanDan('Nitelikli yayın ve proje ölçütlerinden en az 150 puan', [
                '1.1a', '1.1b', '1.1c', '1.1d', '1.1e', '1.2a', '1.2b', '1.3',
                '2.1a', '2.1b', '2.1d', '2.1e', '2.2a', '2.2d', '2.2e', '2.3a',
                '2.3b', '2.3c', '2.3d', '2.3e', '2.3f', '2.4a', '2.4b', '2.4c',
                '2.5a', '2.5c', '2.11a', '2.12a', '2.15', '3.1', '4.1a', '4.1b',
                '4.2a', '4.3a',
            ], 150, madde: '2.6 · 1. BÖLÜM'),
            Kalip::puanDan('Yayın, proje, patent ve editörlük ölçütlerinden en az 200 puan', [
                '1.1a', '1.1b', '1.1c', '1.1d', '1.1e', '1.2a', '1.2b', '1.3',
                '2.1a', '2.1b', '2.1c', '2.1d', '2.1e', '2.2a', '2.2b', '2.2c',
                '2.2d', '2.2e', '2.2f', '2.3a', '2.3b', '2.3c', '2.3d', '2.3e',
                '2.3f', '2.4a', '2.4b', '2.4c', '2.5a', '2.5b', '2.5c', '2.5d',
                '2.11a', '2.11b', '2.12a', '2.12b', '2.15', '3.1', '3.2', '3.3',
                '3.7', '4.1a', '4.1b', '4.2a', '4.3a', '4.4', '9.1', '10.1a',
                '10.1b',
            ], 200, madde: '2.6 · 2. BÖLÜM'),
            Kalip::puanDan('Kurumsal ve toplumsal katkı ölçütlerinden en az 100 puan', [
                '14.23', '14.25', '14.34', '14.38', '14.39', '14.40', '14.42', '14.43',
                '14.44', '2.11a', '2.11b', '2.11c', '2.11d',
            ], 100, madde: '2.6 · 4. BÖLÜM'),
            Kalip::beyan('Nitelikli yayın ve proje ölçütleri için ek koşul: SCI-E, SSCI, AHCI veya Scopus dergilerinde ya da WoS/Scopus indeksli kitap veya kitap bölümü kapsamında bir adet yayın veya Scopus Q4 veya ESCI dergilerinde 2 adet yayın veya TÜBİTAK 2209 danışmanlığı kapsamında üç adet proje veya desteklenen araştırma projeleri kapsamında bir adet araştırma projesi', '2.6 dipnot'),
        ]),
    ],
    // ══ 2.6 İlahiyat ve Hukuk Fakültesi — Doçent ══
    [
        'anahtar' => 'sakarya-docent-2_6',
        'aday_notu' => 'Sakarya eşiği fakülte grubuna göre belirlenir; bu eşik İlahiyat ve Hukuk Fakültesi '
            .'için geçerlidir. Dört bölüm barajının her biri ayrı ayrı sağlanmalı.',
        'universite' => 'Sakarya Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['ilahiyat', 'hukuk'],
        'cetvel' => 'sakarya-2026',
        'notlar' => '2.6 İlahiyat ve Hukuk Fakültesi — Doçent sütunu.',
        'sart' => Kalip::ve('Doçent — İlahiyat ve Hukuk Fakültesi', [
            Kalip::toplam(800),
            Kalip::puanDan('Nitelikli yayın ve proje ölçütlerinden en az 200 puan', [
                '1.1a', '1.1b', '1.1c', '1.1d', '1.1e', '1.2a', '1.2b', '1.3',
                '2.1a', '2.1b', '2.1d', '2.1e', '2.2a', '2.2d', '2.2e', '2.3a',
                '2.3b', '2.3c', '2.3d', '2.3e', '2.3f', '2.4a', '2.4b', '2.4c',
                '2.5a', '2.5c', '2.11a', '2.12a', '2.15', '3.1', '4.1a', '4.1b',
                '4.2a', '4.3a',
            ], 200, madde: '2.6 · 1. BÖLÜM'),
            Kalip::puanDan('Yayın, proje, patent ve editörlük ölçütlerinden en az 250 puan', [
                '1.1a', '1.1b', '1.1c', '1.1d', '1.1e', '1.2a', '1.2b', '1.3',
                '2.1a', '2.1b', '2.1c', '2.1d', '2.1e', '2.2a', '2.2b', '2.2c',
                '2.2d', '2.2e', '2.2f', '2.3a', '2.3b', '2.3c', '2.3d', '2.3e',
                '2.3f', '2.4a', '2.4b', '2.4c', '2.5a', '2.5b', '2.5c', '2.5d',
                '2.11a', '2.11b', '2.12a', '2.12b', '2.15', '3.1', '3.2', '3.3',
                '3.7', '4.1a', '4.1b', '4.2a', '4.3a', '4.4', '9.1', '10.1a',
                '10.1b',
            ], 250, madde: '2.6 · 2. BÖLÜM'),
            Kalip::puanDan('Tez yönetimi ve eğitim-öğretim ölçütlerinden en az 60 puan', [
                '13.1a', '13.1b', '13.2', '13.3', '2.11a', '2.11b', '2.11c', '2.11d',
                '2.11e', '12.1', '12.2',
            ], 60, madde: '2.6 · 3. BÖLÜM'),
            Kalip::puanDan('Kurumsal ve toplumsal katkı ölçütlerinden en az 150 puan', [
                '14.23', '14.25', '14.34', '14.38', '14.39', '14.40', '14.42', '14.43',
                '14.44', '2.11a', '2.11b', '2.11c', '2.11d',
            ], 150, madde: '2.6 · 4. BÖLÜM'),
            Kalip::beyan('Nitelikli yayın ve proje ölçütleri için ek koşul: SCI-E, SSCI, AHCI veya Scopus dergilerinde ya da WoS/Scopus indeksli kitap veya kitap bölümü kapsamında bir adet yayın veya Scopus Q4 veya ESCI dergilerinde 2 adet yayın veya TÜBİTAK 2209 danışmanlığı kapsamında üç adet proje veya desteklenen araştırma projeleri kapsamında bir adet araştırma projesi', '2.6 dipnot'),
        ]),
    ],
    // ══ 2.6 İlahiyat ve Hukuk Fakültesi — Profesör ══
    [
        'anahtar' => 'sakarya-profesor-2_6',
        'aday_notu' => 'Sakarya eşiği fakülte grubuna göre belirlenir; bu eşik İlahiyat ve Hukuk Fakültesi '
            .'için geçerlidir. Dört bölüm barajının her biri ayrı ayrı sağlanmalı.',
        'universite' => 'Sakarya Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['ilahiyat', 'hukuk'],
        'cetvel' => 'sakarya-2026',
        'notlar' => '2.6 İlahiyat ve Hukuk Fakültesi — Profesör sütunu.',
        'sart' => Kalip::ve('Profesör — İlahiyat ve Hukuk Fakültesi', [
            Kalip::toplam(1200),
            Kalip::puanDan('Nitelikli yayın ve proje ölçütlerinden en az 250 puan', [
                '1.1a', '1.1b', '1.1c', '1.1d', '1.1e', '1.2a', '1.2b', '1.3',
                '2.1a', '2.1b', '2.1d', '2.1e', '2.2a', '2.2d', '2.2e', '2.3a',
                '2.3b', '2.3c', '2.3d', '2.3e', '2.3f', '2.4a', '2.4b', '2.4c',
                '2.5a', '2.5c', '2.11a', '2.12a', '2.15', '3.1', '4.1a', '4.1b',
                '4.2a', '4.3a',
            ], 250, madde: '2.6 · 1. BÖLÜM'),
            Kalip::puanDan('Yayın, proje, patent ve editörlük ölçütlerinden en az 300 puan', [
                '1.1a', '1.1b', '1.1c', '1.1d', '1.1e', '1.2a', '1.2b', '1.3',
                '2.1a', '2.1b', '2.1c', '2.1d', '2.1e', '2.2a', '2.2b', '2.2c',
                '2.2d', '2.2e', '2.2f', '2.3a', '2.3b', '2.3c', '2.3d', '2.3e',
                '2.3f', '2.4a', '2.4b', '2.4c', '2.5a', '2.5b', '2.5c', '2.5d',
                '2.11a', '2.11b', '2.12a', '2.12b', '2.15', '3.1', '3.2', '3.3',
                '3.7', '4.1a', '4.1b', '4.2a', '4.3a', '4.4', '9.1', '10.1a',
                '10.1b',
            ], 300, madde: '2.6 · 2. BÖLÜM'),
            Kalip::puanDan('Tez yönetimi ve eğitim-öğretim ölçütlerinden en az 100 puan', [
                '13.1a', '13.1b', '13.2', '13.3', '2.11a', '2.11b', '2.11c', '2.11d',
                '2.11e', '12.1', '12.2',
            ], 100, madde: '2.6 · 3. BÖLÜM'),
            Kalip::puanDan('Kurumsal ve toplumsal katkı ölçütlerinden en az 200 puan', [
                '14.23', '14.25', '14.34', '14.38', '14.39', '14.40', '14.42', '14.43',
                '14.44', '2.11a', '2.11b', '2.11c', '2.11d',
            ], 200, madde: '2.6 · 4. BÖLÜM'),
            Kalip::beyan('Nitelikli yayın ve proje ölçütleri için ek koşul: SCI-E, SSCI, AHCI veya Scopus dergilerinde ya da WoS/Scopus indeksli kitap veya kitap bölümü kapsamında bir adet yayın veya Scopus Q4 veya ESCI dergilerinde 3 adet yayın veya TÜBİTAK 2209 danışmanlığı kapsamında üç adet proje veya desteklenen araştırma projeleri kapsamında bir adet araştırma projesi', '2.6 dipnot'),
        ]),
    ],
    // ══ 2.7 Sanat Tasarım ve Mimarlık Fakültesi (Mimarlık Alanı) — Dr. Öğr. Üyesi ══
    [
        'anahtar' => 'sakarya-dr-2_7',
        'aday_notu' => 'Sakarya eşiği fakülte grubuna göre belirlenir; bu eşik Sanat Tasarım ve Mimarlık Fakültesi (Mimarlık Alanı) '
            .'için geçerlidir. Dört bölüm barajının her biri ayrı ayrı sağlanmalı.',
        'universite' => 'Sakarya Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['mimarlik'],
        'cetvel' => 'sakarya-2026',
        'notlar' => '2.7 Sanat Tasarım ve Mimarlık Fakültesi (Mimarlık Alanı) — Dr. Öğr. Üyesi sütunu.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Sanat Tasarım ve Mimarlık Fakültesi (Mimarlık Alanı)', [
            Kalip::toplam(600),
            Kalip::puanDan('Nitelikli yayın ve proje ölçütlerinden en az 250 puan', [
                '1.1a', '1.1b', '1.1c', '1.1d', '1.1e', '1.2a', '1.2b', '2.1a',
                '2.1b', '2.1d', '2.1e', '2.2a', '2.2d', '2.2e', '2.3a', '2.3b',
                '2.3c', '2.3d', '2.3e', '2.3f', '2.4a', '2.4b', '2.5a', '2.5c',
                '2.11a', '2.12a', '3.1', '4.1a', '4.1b', '4.2a', '4.3a', '4.4',
                '4.5', '5.5',
            ], 250, madde: '2.7 · 1. BÖLÜM'),
            Kalip::puanDan('Yayın, proje, patent ve editörlük ölçütlerinden en az 225 puan', [
                '1.1a', '1.1b', '1.1c', '1.1d', '1.1e', '1.2a', '1.2b', '1.3',
                '2.1a', '2.1b', '2.1c', '2.1d', '2.1e', '2.2a', '2.2b', '2.2c',
                '2.2d', '2.2e', '2.2f', '2.3a', '2.3b', '2.3c', '2.3d', '2.3e',
                '2.3f', '2.4a', '2.4b', '2.4c', '2.5a', '2.5b', '2.5c', '2.5d',
                '2.11a', '2.11b', '2.12a', '2.12b', '2.15', '3.1', '3.2', '3.3',
                '4.1a', '4.1b', '4.2a', '4.3a', '4.4', '4.5', '5.5', '5.6',
                '5.14a', '9.1', '10.1a', '10.1b',
            ], 225, madde: '2.7 · 2. BÖLÜM'),
            Kalip::puanDan('Kurumsal ve toplumsal katkı ölçütlerinden en az 40 puan', [
                '14.23', '14.25', '14.34', '14.38', '14.39', '14.40', '14.42', '14.43',
                '14.44', '2.11a', '2.11b', '2.11c', '2.11d',
            ], 40, madde: '2.7 · 4. BÖLÜM'),
            Kalip::beyan('Nitelikli yayın ve proje ölçütleri için ek koşul: SCI-E, SSCI, AHCI veya Scopus dergilerinde bir adet yayın veya TÜBİTAK 2209 danışmanlığı kapsamında üç adet proje veya desteklenen araştırma projeleri kapsamında bir adet araştırma projesi', '2.7 dipnot'),
        ]),
    ],
    // ══ 2.7 Sanat Tasarım ve Mimarlık Fakültesi (Mimarlık Alanı) — Doçent ══
    [
        'anahtar' => 'sakarya-docent-2_7',
        'aday_notu' => 'Sakarya eşiği fakülte grubuna göre belirlenir; bu eşik Sanat Tasarım ve Mimarlık Fakültesi (Mimarlık Alanı) '
            .'için geçerlidir. Dört bölüm barajının her biri ayrı ayrı sağlanmalı.',
        'universite' => 'Sakarya Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['mimarlik'],
        'cetvel' => 'sakarya-2026',
        'notlar' => '2.7 Sanat Tasarım ve Mimarlık Fakültesi (Mimarlık Alanı) — Doçent sütunu.',
        'sart' => Kalip::ve('Doçent — Sanat Tasarım ve Mimarlık Fakültesi (Mimarlık Alanı)', [
            Kalip::toplam(1100),
            Kalip::puanDan('Nitelikli yayın ve proje ölçütlerinden en az 400 puan', [
                '1.1a', '1.1b', '1.1c', '1.1d', '1.1e', '1.2a', '1.2b', '2.1a',
                '2.1b', '2.1d', '2.1e', '2.2a', '2.2d', '2.2e', '2.3a', '2.3b',
                '2.3c', '2.3d', '2.3e', '2.3f', '2.4a', '2.4b', '2.5a', '2.5c',
                '2.11a', '2.12a', '3.1', '4.1a', '4.1b', '4.2a', '4.3a', '4.4',
                '4.5', '5.5',
            ], 400, madde: '2.7 · 1. BÖLÜM'),
            Kalip::puanDan('Yayın, proje, patent ve editörlük ölçütlerinden en az 275 puan', [
                '1.1a', '1.1b', '1.1c', '1.1d', '1.1e', '1.2a', '1.2b', '1.3',
                '2.1a', '2.1b', '2.1c', '2.1d', '2.1e', '2.2a', '2.2b', '2.2c',
                '2.2d', '2.2e', '2.2f', '2.3a', '2.3b', '2.3c', '2.3d', '2.3e',
                '2.3f', '2.4a', '2.4b', '2.4c', '2.5a', '2.5b', '2.5c', '2.5d',
                '2.11a', '2.11b', '2.12a', '2.12b', '2.15', '3.1', '3.2', '3.3',
                '4.1a', '4.1b', '4.2a', '4.3a', '4.4', '4.5', '5.5', '5.6',
                '5.14a', '9.1', '10.1a', '10.1b',
            ], 275, madde: '2.7 · 2. BÖLÜM'),
            Kalip::puanDan('Tez yönetimi ve eğitim-öğretim ölçütlerinden en az 40 puan', [
                '13.1a', '13.1b', '13.2', '13.3', '2.11a', '2.11b', '2.11c', '2.11d',
                '2.11e', '12.1', '12.2',
            ], 40, madde: '2.7 · 3. BÖLÜM'),
            Kalip::puanDan('Kurumsal ve toplumsal katkı ölçütlerinden en az 80 puan', [
                '14.23', '14.25', '14.34', '14.38', '14.39', '14.40', '14.42', '14.43',
                '14.44', '2.11a', '2.11b', '2.11c', '2.11d',
            ], 80, madde: '2.7 · 4. BÖLÜM'),
            Kalip::beyan('Nitelikli yayın ve proje ölçütleri için ek koşul: SCI-E, SSCI, AHCI veya Scopus dergilerinde bir adet yayın veya TÜBİTAK 2209 danışmanlığı kapsamında üç adet proje veya desteklenen araştırma projeleri kapsamında bir adet araştırma projesi', '2.7 dipnot'),
        ]),
    ],
    // ══ 2.7 Sanat Tasarım ve Mimarlık Fakültesi (Mimarlık Alanı) — Profesör ══
    [
        'anahtar' => 'sakarya-profesor-2_7',
        'aday_notu' => 'Sakarya eşiği fakülte grubuna göre belirlenir; bu eşik Sanat Tasarım ve Mimarlık Fakültesi (Mimarlık Alanı) '
            .'için geçerlidir. Dört bölüm barajının her biri ayrı ayrı sağlanmalı.',
        'universite' => 'Sakarya Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['mimarlik'],
        'cetvel' => 'sakarya-2026',
        'notlar' => '2.7 Sanat Tasarım ve Mimarlık Fakültesi (Mimarlık Alanı) — Profesör sütunu.',
        'sart' => Kalip::ve('Profesör — Sanat Tasarım ve Mimarlık Fakültesi (Mimarlık Alanı)', [
            Kalip::toplam(1400),
            Kalip::puanDan('Nitelikli yayın ve proje ölçütlerinden en az 450 puan', [
                '1.1a', '1.1b', '1.1c', '1.1d', '1.1e', '1.2a', '1.2b', '2.1a',
                '2.1b', '2.1d', '2.1e', '2.2a', '2.2d', '2.2e', '2.3a', '2.3b',
                '2.3c', '2.3d', '2.3e', '2.3f', '2.4a', '2.4b', '2.5a', '2.5c',
                '2.11a', '2.12a', '3.1', '4.1a', '4.1b', '4.2a', '4.3a', '4.4',
                '4.5', '5.5',
            ], 450, madde: '2.7 · 1. BÖLÜM'),
            Kalip::puanDan('Yayın, proje, patent ve editörlük ölçütlerinden en az 325 puan', [
                '1.1a', '1.1b', '1.1c', '1.1d', '1.1e', '1.2a', '1.2b', '1.3',
                '2.1a', '2.1b', '2.1c', '2.1d', '2.1e', '2.2a', '2.2b', '2.2c',
                '2.2d', '2.2e', '2.2f', '2.3a', '2.3b', '2.3c', '2.3d', '2.3e',
                '2.3f', '2.4a', '2.4b', '2.4c', '2.5a', '2.5b', '2.5c', '2.5d',
                '2.11a', '2.11b', '2.12a', '2.12b', '2.15', '3.1', '3.2', '3.3',
                '4.1a', '4.1b', '4.2a', '4.3a', '4.4', '4.5', '5.5', '5.6',
                '5.14a', '9.1', '10.1a', '10.1b',
            ], 325, madde: '2.7 · 2. BÖLÜM'),
            Kalip::puanDan('Tez yönetimi ve eğitim-öğretim ölçütlerinden en az 60 puan', [
                '13.1a', '13.1b', '13.2', '13.3', '2.11a', '2.11b', '2.11c', '2.11d',
                '2.11e', '12.1', '12.2',
            ], 60, madde: '2.7 · 3. BÖLÜM'),
            Kalip::puanDan('Kurumsal ve toplumsal katkı ölçütlerinden en az 120 puan', [
                '14.23', '14.25', '14.34', '14.38', '14.39', '14.40', '14.42', '14.43',
                '14.44', '2.11a', '2.11b', '2.11c', '2.11d',
            ], 120, madde: '2.7 · 4. BÖLÜM'),
            Kalip::beyan('Nitelikli yayın ve proje ölçütleri için ek koşul: SCI-E, SSCI, AHCI veya Scopus dergilerinde iki adet yayın veya TÜBİTAK 2209 danışmanlığı kapsamında üç adet proje veya desteklenen araştırma projeleri kapsamında bir adet araştırma projesi', '2.7 dipnot'),
        ]),
    ],
    // ══ 2.8 Sanat Tasarım ve Mimarlık Fakültesi (Sanat ve Tasarım), De — Dr. Öğr. Üyesi ══
    [
        'anahtar' => 'sakarya-dr-2_8',
        'aday_notu' => 'Sakarya eşiği fakülte grubuna göre belirlenir; bu eşik Sanat Tasarım ve Mimarlık Fakültesi (Sanat ve Tasarım), Devlet K '
            .'için geçerlidir. Dört bölüm barajının her biri ayrı ayrı sağlanmalı.',
        'universite' => 'Sakarya Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'sakarya-2026',
        'notlar' => '2.8 Sanat Tasarım ve Mimarlık Fakültesi (Sanat ve Tasarım), Devlet Konservatuvarı — Dr. Öğr. Üyesi sütunu.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Sanat Tasarım ve Mimarlık Fakültesi (Sanat ve Tasarım), Devlet Konservatuvarı', [
            Kalip::toplam(500),
            Kalip::puanDan('Nitelikli yayın ve proje ölçütlerinden en az 100 puan', [
                '1.1a', '1.1b', '1.1c', '1.1d', '1.1e', '1.2a', '1.2b', '1.3',
                '2.1a', '2.1b', '2.1d', '2.1e', '2.2a', '2.2b', '2.2c', '2.2d',
                '2.2e', '2.3a', '2.3b', '2.3c', '2.3d', '2.3e', '2.3f', '2.4a',
                '2.4b', '2.4c', '2.5a', '2.5b', '2.10a', '2.11a', '2.11b', '2.12a',
                '2.12b', '2.15', '3.1', '4.1a', '4.1b', '4.2a', '4.3a', '4.4',
                '4.5', '5.5',
            ], 100, madde: '2.8 · 1. BÖLÜM'),
            Kalip::puanDan('Yayın, proje, patent ve editörlük ölçütlerinden en az 120 puan', [
                '1.1a', '1.1b', '1.1c', '1.1d', '1.1e', '1.2a', '1.2b', '1.3',
                '2.1a', '2.1b', '2.1c', '2.1d', '2.1e', '2.2a', '2.2b', '2.2c',
                '2.2d', '2.2e', '2.2f', '2.3a', '2.3b', '2.3c', '2.3d', '2.3e',
                '2.3f', '2.4b', '2.4c', '2.5a', '2.5b', '2.5c', '2.5d', '2.10a',
                '2.10b', '2.11a', '2.11b', '2.12a', '2.12b', '2.15', '3.1', '3.2',
                '3.3', '4.1a', '4.1b', '4.2a', '4.3a', '4.4', '4.5', '5.5',
                '5.14a', '9.1', '10.1a', '10.1b',
            ], 120, madde: '2.8 · 2. BÖLÜM'),
            Kalip::puanDan('Kurumsal ve toplumsal katkı ölçütlerinden en az 100 puan', [
                '14.23', '14.25', '14.34', '14.38', '14.39', '14.40', '14.42', '14.43',
                '14.44', '2.11a', '2.11b', '2.11c', '2.11d',
            ], 100, madde: '2.8 · 4. BÖLÜM'),
            Kalip::beyan('Nitelikli yayın ve proje ölçütleri için ek koşul: SCI-E, SSCI, AHCI veya Scopus dergilerinde ya da WoS/Scopus indeksli kitap veya kitap bölümü kapsamında bir adet yayın; Scopus Q4 veya ESCI dergilerinde 2 adet yayın; TÜBİTAK 2209 danışmanlığı kapsamında 3 adet proje ya da desteklenen araştırma projeleri kapsamında bir adet araştırma projesi', '2.8 dipnot'),
        ]),
    ],
    // ══ 2.8 Sanat Tasarım ve Mimarlık Fakültesi (Sanat ve Tasarım), De — Doçent ══
    [
        'anahtar' => 'sakarya-docent-2_8',
        'aday_notu' => 'Sakarya eşiği fakülte grubuna göre belirlenir; bu eşik Sanat Tasarım ve Mimarlık Fakültesi (Sanat ve Tasarım), Devlet K '
            .'için geçerlidir. Dört bölüm barajının her biri ayrı ayrı sağlanmalı.',
        'universite' => 'Sakarya Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'sakarya-2026',
        'notlar' => '2.8 Sanat Tasarım ve Mimarlık Fakültesi (Sanat ve Tasarım), Devlet Konservatuvarı — Doçent sütunu.',
        'sart' => Kalip::ve('Doçent — Sanat Tasarım ve Mimarlık Fakültesi (Sanat ve Tasarım), Devlet Konservatuvarı', [
            Kalip::toplam(1100),
            Kalip::puanDan('Nitelikli yayın ve proje ölçütlerinden en az 160 puan', [
                '1.1a', '1.1b', '1.1c', '1.1d', '1.1e', '1.2a', '1.2b', '1.3',
                '2.1a', '2.1b', '2.1d', '2.1e', '2.2a', '2.2b', '2.2c', '2.2d',
                '2.2e', '2.3a', '2.3b', '2.3c', '2.3d', '2.3e', '2.3f', '2.4a',
                '2.4b', '2.4c', '2.5a', '2.5b', '2.10a', '2.11a', '2.11b', '2.12a',
                '2.12b', '2.15', '3.1', '4.1a', '4.1b', '4.2a', '4.3a', '4.4',
                '4.5', '5.5',
            ], 160, madde: '2.8 · 1. BÖLÜM'),
            Kalip::puanDan('Yayın, proje, patent ve editörlük ölçütlerinden en az 220 puan', [
                '1.1a', '1.1b', '1.1c', '1.1d', '1.1e', '1.2a', '1.2b', '1.3',
                '2.1a', '2.1b', '2.1c', '2.1d', '2.1e', '2.2a', '2.2b', '2.2c',
                '2.2d', '2.2e', '2.2f', '2.3a', '2.3b', '2.3c', '2.3d', '2.3e',
                '2.3f', '2.4b', '2.4c', '2.5a', '2.5b', '2.5c', '2.5d', '2.10a',
                '2.10b', '2.11a', '2.11b', '2.12a', '2.12b', '2.15', '3.1', '3.2',
                '3.3', '4.1a', '4.1b', '4.2a', '4.3a', '4.4', '4.5', '5.5',
                '5.14a', '9.1', '10.1a', '10.1b',
            ], 220, madde: '2.8 · 2. BÖLÜM'),
            Kalip::puanDan('Tez yönetimi ve eğitim-öğretim ölçütlerinden en az 60 puan', [
                '13.1a', '13.1b', '13.2', '13.3', '2.11a', '2.11b', '2.11c', '2.11d',
                '2.11e', '12.1', '12.2',
            ], 60, madde: '2.8 · 3. BÖLÜM'),
            Kalip::puanDan('Kurumsal ve toplumsal katkı ölçütlerinden en az 150 puan', [
                '14.23', '14.25', '14.34', '14.38', '14.39', '14.40', '14.42', '14.43',
                '14.44', '2.11a', '2.11b', '2.11c', '2.11d',
            ], 150, madde: '2.8 · 4. BÖLÜM'),
            Kalip::beyan('Nitelikli yayın ve proje ölçütleri için ek koşul: SCI-E, SSCI, AHCI veya Scopus dergilerinde ya da WoS/Scopus indeksli kitap veya kitap bölümü kapsamında bir adet yayın; Scopus Q4 veya ESCI dergilerinde 2 adet yayın; TÜBİTAK 2209 danışmanlığı kapsamında üç adet proje ya da desteklenen araştırma projeleri kapsamında bir adet araştırma projesi', '2.8 dipnot'),
        ]),
    ],
    // ══ 2.8 Sanat Tasarım ve Mimarlık Fakültesi (Sanat ve Tasarım), De — Profesör ══
    [
        'anahtar' => 'sakarya-profesor-2_8',
        'aday_notu' => 'Sakarya eşiği fakülte grubuna göre belirlenir; bu eşik Sanat Tasarım ve Mimarlık Fakültesi (Sanat ve Tasarım), Devlet K '
            .'için geçerlidir. Dört bölüm barajının her biri ayrı ayrı sağlanmalı.',
        'universite' => 'Sakarya Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'sakarya-2026',
        'notlar' => '2.8 Sanat Tasarım ve Mimarlık Fakültesi (Sanat ve Tasarım), Devlet Konservatuvarı — Profesör sütunu.',
        'sart' => Kalip::ve('Profesör — Sanat Tasarım ve Mimarlık Fakültesi (Sanat ve Tasarım), Devlet Konservatuvarı', [
            Kalip::toplam(1400),
            Kalip::puanDan('Nitelikli yayın ve proje ölçütlerinden en az 250 puan', [
                '1.1a', '1.1b', '1.1c', '1.1d', '1.1e', '1.2a', '1.2b', '1.3',
                '2.1a', '2.1b', '2.1d', '2.1e', '2.2a', '2.2b', '2.2c', '2.2d',
                '2.2e', '2.3a', '2.3b', '2.3c', '2.3d', '2.3e', '2.3f', '2.4a',
                '2.4b', '2.4c', '2.5a', '2.5b', '2.10a', '2.11a', '2.11b', '2.12a',
                '2.12b', '2.15', '3.1', '4.1a', '4.1b', '4.2a', '4.3a', '4.4',
                '4.5', '5.5',
            ], 250, madde: '2.8 · 1. BÖLÜM'),
            Kalip::puanDan('Yayın, proje, patent ve editörlük ölçütlerinden en az 280 puan', [
                '1.1a', '1.1b', '1.1c', '1.1d', '1.1e', '1.2a', '1.2b', '1.3',
                '2.1a', '2.1b', '2.1c', '2.1d', '2.1e', '2.2a', '2.2b', '2.2c',
                '2.2d', '2.2e', '2.2f', '2.3a', '2.3b', '2.3c', '2.3d', '2.3e',
                '2.3f', '2.4b', '2.4c', '2.5a', '2.5b', '2.5c', '2.5d', '2.10a',
                '2.10b', '2.11a', '2.11b', '2.12a', '2.12b', '2.15', '3.1', '3.2',
                '3.3', '4.1a', '4.1b', '4.2a', '4.3a', '4.4', '4.5', '5.5',
                '5.14a', '9.1', '10.1a', '10.1b',
            ], 280, madde: '2.8 · 2. BÖLÜM'),
            Kalip::puanDan('Tez yönetimi ve eğitim-öğretim ölçütlerinden en az 90 puan', [
                '13.1a', '13.1b', '13.2', '13.3', '2.11a', '2.11b', '2.11c', '2.11d',
                '2.11e', '12.1', '12.2',
            ], 90, madde: '2.8 · 3. BÖLÜM'),
            Kalip::puanDan('Kurumsal ve toplumsal katkı ölçütlerinden en az 200 puan', [
                '14.23', '14.25', '14.34', '14.38', '14.39', '14.40', '14.42', '14.43',
                '14.44', '2.11a', '2.11b', '2.11c', '2.11d',
            ], 200, madde: '2.8 · 4. BÖLÜM'),
            Kalip::beyan('Nitelikli yayın ve proje ölçütleri için ek koşul: SCI-E, SSCI, AHCI veya Scopus dergilerinde ya da WoS/Scopus indeksli kitap veya kitap bölümü kapsamında bir adet yayın; Scopus Q4 veya ESCI dergilerinde 3 adet yayın; TÜBİTAK 2209 danışmanlığı kapsamında üç adet proje ya da desteklenen araştırma projeleri kapsamında bir adet araştırma projesi', '2.8 dipnot'),
        ]),
    ],
];
