<?php

/**
 * MUNZUR ÜNİVERSİTESİ — EK-1 Öğretim Üyeliğine Yükseltilme ve Atanma Puan
 * Tablosu
 * Kaynak: pdf/17634002431.Munzur Üniversitesi Kriter.pdf (19 sayfa,
 *         Genel Sekreter Vekili onayı 20.06.2025)
 *
 * KAYNAK PDF'İN GÖMÜLÜ METİN KATMANI ÇÖPTÜ; 200 dpi görüntüden
 * `tesseract -l tur` ile yeniden okundu ve puan sütunu sayfa görüntülerinin
 * sağ şeridi kırpılarak GÖZLE DOĞRULANDI. OCR sekiz satırda yanlış okumuştu:
 * A3.4 ve A3.6 (8, "$" okunmuş), B2.4 (12, "2"), B2.5 (8, "5"), C3.3 (180,
 * "150"), C4.3 (200, "209"), E1.6 (15, "5"), F6.4 (100, "10").
 *
 * YEDİ CETVEL VARYANTI ÜRETİYOR. İki eksende ayrışıyorlar:
 *
 *   1. SOSYAL BİLİMLERDE A2.1 PUANLARI 1,5 KATI. Tablonun A2.1 satırı
 *      "Sosyal Bilimler kapsamında yapılan yayınlardan alınacak puanlar 1,50
 *      ile çarpılır" diyor: Q1 225, Q2 180, Q3 120, Q4 90. Munzur'un kendi
 *      tanımıyla (Madde 4/ç) Sosyal Bilimler = İnsani ve Sosyal Bilimler,
 *      İİBF, Edebiyat, Eğitim Bilimleri, İletişim ve Spor Bilimleri.
 *   2. "A1 KAPSAMINDA EN FAZLA N PUAN" TAVANI KADROYA GÖRE DEĞİŞİYOR:
 *      doçentlikte 30 (Güzel Sanatlarda 20), profesörlükte 50 (Güzel
 *      Sanatlarda 30), Dr. Öğr. Üyeliğinde tavan yok.
 *
 *   munzur-2025               · munzur-2025-a1-20 · -a1-30 · -a1-50
 *   munzur-2025-sosyal        · munzur-2025-sosyal-a1-30 · -a1-50
 *
 * Tavan motorda cetvel geneline uygulanıyor, yalnız zorunlu puan hesabına
 * değil; bu, adayın TOPLAM puanını da bir miktar düşürüyor — §0'ın istediği
 * yön.
 *
 * ── UYGULANAMAYAN ÇARPANLAR ──
 * A2.1'in iki çarpanı daha var: TÜBİTAK ya da sanayi iş birliği projesi
 * kapsamında yapılan yayınlar ×1,25 ve uluslararası iş birliğinde yapılan
 * yayınlar ×1,25. İkisi de faaliyet kaydında tutulmayan bir niteliğe bağlı;
 * uygulanmadı, adayın puanı bu yayınlarda DÜŞÜK görünür.
 * C8 (idari görevler) bölümünün "bu bölümden alınacak toplam puan, adayın
 * diğer bölümlerden alacağı toplam puanın %20'sinden fazla olamaz" tavanı
 * başka bir bölümün toplamına bağlı olduğu için motorda ifade edilemiyor;
 * idari görevi çok olan adayın puanı YÜKSEK çıkabilir.
 *
 * ── PROJE ROLLERİ SATIRA GÖMÜLDÜ (Madde 6/2) ──
 * Yönetici/yürütücü %100, araştırmacı ve proje personeli %50, danışman ve
 * uzman %20, eğitmen %50. Motorda role göre çarpan olmadığı için her proje
 * satırı üç koda bölündü (-y yürütücü, -a araştırmacı ve bursiyer, -d
 * danışman); oranlar aşağı yuvarlandı.
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR (§0) ──
 *   Bildiri bölümleri (A3 uluslararası kuruluş, A4 ulusal kuruluş, B3 ulusal
 *       toplantı) aynı etiket kümesini paylaşıyor; kayıt toplantıyı DÜZENLEYEN
 *       kuruluşu tutmadığı için satırlar A3 kodunda ama A4'ün DÜŞÜK
 *       puanlarıyla girildi: yabancı dilde tam metin 20 yerine 10, özet ve
 *       poster 15/8 yerine 2, Türkçe tam metin 10 yerine 5.
 *   A2.6 (uluslararası ansiklopedi maddesi 15) ile B2.5 (ulusal 8) → 8.
 *   A6.2/A6.4/B5.2/B5.4 yayın kurulu üyeliği (20/5/5/2) → 2;
 *       A6.5/A6.6/B5.5/B5.6 hakemlik (5/3/3/2) → 2.
 *   C2.2-C2.6 TÜBİTAK satırları (60'tan 180'e) tek "TÜBİTAK" etiketine
 *       düşüyor → 60; TÜSEB de aynı satırdan.
 *   C2.8/C2.9/C2.13 kamu kurumu projeleri (100/40/20) → 20.
 *   C3.2 (AB Ar-Ge projesi 300) ile C3.4 (AB hibe programı 100) → 100.
 *   C4.7-C4.9 ticarileşen belgeler (300) tek "Ticarileştirme" etiketinde.
 *   D1.1 (sinema filmi yönetmenliği 100) ile D1.3 (belgesel, kısa film 25)
 *       → 25; D2.1 (TV programı yönetmenliği 50) ile D2.2 (görev alma 25)
 *       ve E1.5 (TV etkinliği 25) → 25.
 *   F2.1-F2.3 üretime girmiş tasarım (200/150/100) → 100.
 *   F3.3/F3.4 jüri üyeliği ve küratörlük (30/15) → 15.
 *   F6-F7 sanat ödülleri (200'den 50'ye) tek "Yarışma Derecesi / Mansiyon"
 *       etiketinde → 50.
 *
 * ── GİRİLMEYEN BÖLÜMLER ──
 *   G. SPORTİF ETKİNLİKLERİN TAMAMI (11 satır, 100 puana kadar): olimpiyat,
 *       şampiyona ve millî takım katılımının kayıtta karşılığı yok.
 *   A7 h-indeksi (10 × h), C5 sertifika programları (en fazla 20 puan),
 *       C9 dolaşım programları (en fazla 20 puan), C2.11-C2.12 yurt dışı
 *       araştırma (ay başına 5 ve 7,5 puan), C2.19 TÜBİTAK ARDEB başvurusu.
 *   C4.1-C4.2 patent BAŞVURULARI (5/10), C1.2 ve C1.4 devam eden tez
 *       danışmanlıkları (10/5) — kayıt yalnız tamamlanmışı tutuyor.
 *   B1.6 açıklamalı ve yorumlu kitap çevirisi (25, sadece Sosyal Bilimler),
 *       B2.2 Dergipark makalesi (20), A3.9-A3.10 ve B3.4-B3.5 düzenleme ve
 *       bilim kurulu üyelikleri, D1.2 sinema filminde görev alma (50),
 *       E1.6-E1.8 radyo ve yerel TV etkinlikleri, F2.6-F2.7 afiş ve kapak
 *       tasarımı, F5.7-F5.12 arkeolojik kazı satırlarının tamamı.
 *   Davetli konuşmacılık: tabloda satırı yok.
 *
 * ── YAZAR ÇARPANI (Madde 6/1) ──
 * Yalnız KİTAP, MAKALE VE BİLDİRİLERE uygulanır — maddenin kendi ifadesi.
 * Sanatsal etkinlikler, projeler, atıflar, tezler, editörlük, ödüller, dersler
 * ve idari görevler dışarıda; sanat etkinliklerinin bölünmemesi ekip
 * çalışmalarında puanı YÜKSEK gösterebilir.
 *
 * Yönerge: yonerge/munzur.php
 */
$OZGUN = ['ozgun_makale', 'derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];

/**
 * A2.1'in çeyrek puanları; Sosyal Bilimler varyantında 1,5 ile çarpılır.
 *
 * @return array<string, array<string, mixed>>
 */
$makaleSatirlari = function (float $carpan) use ($OZGUN): array {
    $p = fn (int $ham): int => (int) floor($ham * $carpan);

    return [
        'A2.1-Q1' => ['baslik' => 'SCI, SCI-E, SSCI ya da AHCI kapsamında Q1 dilimli dergide özgün araştırma, makale ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $OZGUN, 'puan' => $p(150)],
        'A2.1-Q2' => ['baslik' => 'SCI, SCI-E, SSCI ya da AHCI kapsamında Q2 dilimli dergide özgün araştırma, makale ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $OZGUN, 'puan' => $p(120)],
        'A2.1-Q3' => ['baslik' => 'SCI, SCI-E, SSCI ya da AHCI kapsamında Q3 dilimli dergide özgün araştırma, makale ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $OZGUN, 'puan' => $p(80)],
        'A2.1-Q4' => ['baslik' => 'SCI, SCI-E, SSCI ya da AHCI kapsamında Q4 dilimli dergide özgün araştırma, makale ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => $OZGUN, 'puan' => $p(60)],
    ];
};

$ortakMaddeler = [
    // ══ A1. KİTAP (uluslararası) ══
    'A1.1' => ['baslik' => 'Uluslararası bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 150],
    'A1.2' => ['baslik' => 'Uluslararası bilimsel kitap içinde bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 50],
    'A1.3' => ['baslik' => 'Uluslararası bilimsel kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 50],

    // ══ A2. MAKALELER (uluslararası) — A2.1 varyanta göre üretiliyor ══
    'A2.2-Q1' => ['baslik' => 'SCI, SCI-E, SSCI ya da AHCI kapsamında Q1 dilimli dergide editöre mektup, teknik not ya da vaka takdimi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $KISA, 'puan' => 60],
    'A2.2-Q2' => ['baslik' => 'SCI, SCI-E, SSCI ya da AHCI kapsamında Q2 dilimli dergide editöre mektup, teknik not ya da vaka takdimi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $KISA, 'puan' => 50],
    'A2.2-Q3' => ['baslik' => 'SCI, SCI-E, SSCI ya da AHCI kapsamında Q3 dilimli dergide editöre mektup, teknik not ya da vaka takdimi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $KISA, 'puan' => 40],
    'A2.2-Q4' => ['baslik' => 'SCI, SCI-E, SSCI ya da AHCI kapsamında Q4 dilimli dergide editöre mektup, teknik not ya da vaka takdimi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => $KISA, 'puan' => 30],
    'A2.3' => ['baslik' => 'Uluslararası alan endekslerinde taranan dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $OZGUN, 'puan' => 40],
    'A2.4' => ['baslik' => 'TR Dizin veri tabanlarında taranan hakemli dergide özgün araştırma ve makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $OZGUN, 'puan' => 40],
    'A2.5' => ['baslik' => 'SCI, SCI-E, SSCI ya da AHCI kapsamı dışındaki indekslerde taranan uluslararası hakemli dergide yayın', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $OZGUN, 'puan' => 20],
    'A2.6' => ['baslik' => 'Bilimsel ansiklopedide madde yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 8],
    'A2.7' => ['baslik' => 'SCI, SCI-E, SSCI ya da AHCI kapsamı dışındaki uluslararası hakemli dergide vaka takdimi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'ESCI / Scopus'], 'turler' => $KISA, 'puan' => 10],

    // ══ A3. BİLİMSEL TOPLANTILAR (A4'ün düşük puanlarıyla) ══
    'A3.1' => ['baslik' => 'Yabancı dilde sözlü sunulan, tam metni yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 10],
    'A3.3' => ['baslik' => 'Türkçe sözlü sunulan, tam metni yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 5],
    'A3.6' => ['baslik' => 'Yabancı dilde özeti yayımlanan bildiri ya da poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 2],
    'A3.8' => ['baslik' => 'Türkçe özeti yayımlanan bildiri ya da poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 2],

    // ══ A5-A6 / B4-B5. ATIF, EDİTÖRLÜK VE HAKEMLİK ══
    'A5.1' => ['baslik' => 'SCI, SCI-E, SSCI ya da AHCI dergilerde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 4],
    'B4.1' => ['baslik' => 'TR Dizin veri tabanlarında taranan dergilerde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
    'B4.3' => ['baslik' => 'Bilimsel kitap, monografi ya da tezlerde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap', 'Diğer', 'Patent'], 'puan' => 1],
    'A6.1' => ['baslik' => 'SCI, SCI-E, SSCI ya da AHCI kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 30],
    'A6.3' => ['baslik' => 'SCI, SCI-E, SSCI ya da AHCI kapsamı dışındaki uluslararası hakemli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 10],
    'B5.1' => ['baslik' => 'TR Dizin veri tabanlarında taranan bilimsel yayında editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 15],
    'B5.3' => ['baslik' => 'Diğer ulusal yayınlarda editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 10],
    'B5.4' => ['baslik' => 'Dergi ya da kitapta yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 2],
    'B5.6' => ['baslik' => 'Hakemli dergilerde hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 2],

    // ══ B1. KİTAP (ulusal) ══
    'B1.1' => ['baslik' => 'Ulusal bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Ders / Metot Kitabı'], 'puan' => 100],
    'B1.2' => ['baslik' => 'Ulusal bilimsel kitap içinde bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 25],
    'B1.3' => ['baslik' => 'Ulusal bilimsel kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 30],
    'B1.4' => ['baslik' => 'Bilimsel kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 25],
    'B1.5' => ['baslik' => 'Bilimsel kitap içinde bölüm çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 15],

    // ══ B2. MAKALELER (ulusal) ══
    'B2.3' => ['baslik' => 'TR Dizin veri tabanlarında taranan hakemli dergide derleme, editöre mektup, teknik not ya da vaka takdimi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $KISA, 'puan' => 10],
    'B2.4' => ['baslik' => 'Diğer ulusal hakemli dergilerdeki yayınlar', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'puan' => 12],

    // ══ C1. TEZ DANIŞMANLIĞI ══
    'C1.1' => ['baslik' => 'Tamamlanmış doktora ya da sanatta yeterlik tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 60],
    'C1.3' => ['baslik' => 'Tamamlanmış yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 30],

    // ══ C2-C3. PROJELER (Madde 6/2 rol oranları satıra gömüldü) ══
    'C2.2-y' => ['baslik' => 'TÜBİTAK Ar-Ge destek programı projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 60],
    'C2.2-a' => ['baslik' => 'TÜBİTAK Ar-Ge destek programı projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 30],
    'C2.2-d' => ['baslik' => 'TÜBİTAK Ar-Ge destek programı projesinde danışman', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['danisman'], 'puan' => 12],
    'C2.10-y' => ['baslik' => 'Üniversite-sanayi iş birliği projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 50],
    'C2.10-a' => ['baslik' => 'Üniversite-sanayi iş birliği projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 25],
    'C2.10-d' => ['baslik' => 'Üniversite-sanayi iş birliği projesinde danışman', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['danisman'], 'puan' => 10],
    'C2.13-y' => ['baslik' => 'Kamu kurum ve kuruluşlarından ya da Ulusal Ajanstan alınan projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 20],
    'C2.13-a' => ['baslik' => 'Kamu kurum ve kuruluşlarından ya da Ulusal Ajanstan alınan projede araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 10],
    'C2.13-d' => ['baslik' => 'Kamu kurum ve kuruluşlarından ya da Ulusal Ajanstan alınan projede danışman', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['danisman'], 'puan' => 4],
    'C2.15' => ['baslik' => 'Kurum dışı destekli öğrenci proje programında danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'puan' => 5],
    'C2.17-y' => ['baslik' => 'BAP projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 15],
    'C2.17-a' => ['baslik' => 'BAP projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 7],
    'C2.17-d' => ['baslik' => 'BAP projesinde danışman', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['danisman'], 'puan' => 3],
    'C3.4-y' => ['baslik' => 'Avrupa Birliği programlarından alınan projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 100],
    'C3.4-a' => ['baslik' => 'Avrupa Birliği programlarından alınan projede araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 50],
    'C3.4-d' => ['baslik' => 'Avrupa Birliği programlarından alınan projede danışman', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['danisman'], 'puan' => 20],
    'C3.3-y' => ['baslik' => 'Avrupa Birliği dışındaki uluslararası Ar-Ge programlarından alınan projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 180],
    'C3.3-a' => ['baslik' => 'Avrupa Birliği dışındaki uluslararası Ar-Ge programlarından alınan projede araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 90],
    'C3.3-d' => ['baslik' => 'Avrupa Birliği dışındaki uluslararası Ar-Ge programlarından alınan projede danışman', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['danisman'], 'puan' => 36],

    // ══ C4. PATENT VE TESCİL ══
    'C4.3' => ['baslik' => 'Ulusal patent belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 200],
    'C4.4' => ['baslik' => 'Uluslararası patent belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 300],
    'C4.5' => ['baslik' => 'Faydalı model belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 150],
    'C4.6' => ['baslik' => 'Tasarım belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım', 'Yazılım'], 'puan' => 150],
    'C4.7' => ['baslik' => 'Ticarileşen patent, faydalı model ya da endüstriyel tasarım belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 300],

    // ══ C6. ÖDÜLLER ══
    'C6.1' => ['baslik' => 'Sürekli ve periyodik olarak verilen jürili uluslararası bilim ya da sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 100],
    'C6.2' => ['baslik' => 'YÖK, TÜBİTAK ya da TÜBA tarafından verilen bilim ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü'], 'puan' => 150],
    'C6.3' => ['baslik' => 'Sürekli ve periyodik olarak verilen jürili ulusal bilim ya da sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'Burs'], 'puan' => 50],

    // ══ C7. DERSLER ══
    'C7.1' => ['baslik' => 'Son iki yıl içinde Türkçe verilen ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Değişim Programı Dersi'], 'puan' => 4],
    'C7.2' => ['baslik' => 'Son iki yıl içinde yabancı dilde verilen ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Yabancı Dilde Ders'], 'puan' => 8],

    // ══ C8. İDARİ GÖREVLER ══
    'C8.1' => ['baslik' => 'Rektörlük, rektör yardımcılığı, dekanlık, enstitü, yüksekokul, meslek yüksekokulu ya da merkez müdürlüğü (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 15],
    'C8.2' => ['baslik' => 'Dekan yardımcılığı ya da müdür yardımcılığı (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.'], 'puan' => 10],
    'C8.3' => ['baslik' => 'Rektörlük ya da Senato tarafından görevlendirilen danışmanlık, komisyon, kurul ve koordinatörlükler (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Senato / Üniversite Yönetim Kurulu Üyesi'], 'puan' => 10],
    'C8.4' => ['baslik' => 'Diğer kurul görevleri (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 5],
    'C8.5' => ['baslik' => 'Bölüm başkanlığı (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı'], 'puan' => 10],
    'C8.6' => ['baslik' => 'Bölüm başkan yardımcılığı (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı'], 'puan' => 10],
    'C8.7' => ['baslik' => 'Anabilim dalı başkanlığı ya da bölüm koordinatörlüğü (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 5],

    // ══ D. GÖRSEL ETKİNLİKLER ══
    'D1.3' => ['baslik' => 'Sinema filmi, belgesel, kısa film, reklam filmi ya da müzik videosu yönetmenliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Yönetmenlik (Sahne/Ekran)', 'Belgesel/Kısa Film (Uluslararası)', 'Belgesel/Kısa Film (Ulusal)'], 'puan' => 25],
    'D2.2' => ['baslik' => 'Televizyon, radyo ya da sinema yapıtında görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'], 'puan' => 25],

    // ══ E. GÜZEL SANATLAR ETKİNLİKLERİ ══
    'E1.1' => ['baslik' => 'Sahne yapıtı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera/Bale Kompozisyonu', 'Orkestralı Sahne Eseri', 'Sahne/Ekran Müziği'], 'puan' => 50],
    'E1.2' => ['baslik' => 'Senfonik ya da özgün müzik yapıtı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Küçük Ölçekli Orkestra Eseri', 'Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)', 'Elektronik Müzik Eseri (≥15 dk)', 'Elektronik Müzik Eseri (<15 dk)', 'Eğitim Müziği Albümü', 'Özgün Eser / Beste / Tasarım'], 'puan' => 50],
    'E1.3' => ['baslik' => 'Sanat etkinliğinde bireysel icracı olarak yer almak (solo konser, dinleti, resital)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Solistlik (Uluslararası)', 'Solistlik (Ulusal)', 'Resital (Uluslararası)', 'Resital (Ulusal)', 'Şan Resitali (Uluslararası)', 'Şan Resitali (Ulusal)', 'Opera Birinci Rol (Uluslararası)', 'Opera Birinci Rol (Ulusal)', 'Opera İkinci Rol (Uluslararası)', 'Opera İkinci Rol (Ulusal)', 'Bale Başrol (Uluslararası)', 'Bale Başrol (Ulusal)', 'Bale Solist Rol (Uluslararası)', 'Bale Solist Rol (Ulusal)', 'Oratoryo/Kantat Solistliği (Uluslararası)', 'Oratoryo/Kantat Solistliği (Ulusal)', 'Başkemancılık (Uluslararası)', 'Başkemancılık (Ulusal)', 'Orkestra Şefliği (Uluslararası)', 'Orkestra Şefliği (Ulusal)', 'Koro Şefliği (Uluslararası)', 'Koro Şefliği (Ulusal)', 'Opera Şefliği (Uluslararası)', 'Opera Şefliği (Ulusal)', 'Bale Orkestra Şefliği (Uluslararası)', 'Bale Orkestra Şefliği (Ulusal)'], 'puan' => 30],
    'E1.4' => ['baslik' => 'Sanat etkinliğinde karma ya da eşlikçi icracı olarak yer almak (toplu konser, dinleti)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Uluslararası)', 'Oda Müziği Grup Üyeliği (Ulusal)', 'Orkestra / Koro Üyeliği', 'Corps de Ballet (Uluslararası)', 'Corps de Ballet (Ulusal)', 'Grup Şefliği (Uluslararası)', 'Grup Şefliği (Ulusal)'], 'puan' => 15],
    'E1.9' => ['baslik' => 'CD ya da DVD yapımında solo icracı olarak yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)'], 'puan' => 25],
    'E1.10' => ['baslik' => 'CD ya da DVD yapımında karma veya eşlikçi icracı olarak yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Albüm / CD-DVD Katkısı'], 'puan' => 15],
    'E1.11' => ['baslik' => 'Düzenleme, orkestrasyon ya da transkripsiyon', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestrasyon/Transkripsiyon', 'Eğitim Müziği Düzenlemesi'], 'puan' => 10],
    'E2.1' => ['baslik' => 'Dinleti, eğitici konser programı ya da atölye hazırlamak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eğitici Konser Programı (Uluslararası)', 'Eğitici Konser Programı (Ulusal)', 'Eğitim Amaçlı Sanat Etkinliği', 'Müzikoloji Atölyesi', 'Masterclass (Uluslararası)', 'Masterclass (Ulusal)'], 'puan' => 5],

    // ══ F. SANAT VE TASARIM ETKİNLİKLERİ ══
    'F1.1' => ['baslik' => 'Yurt dışında tanınmış müze, kültür merkezi ya da sanat galerisinde açılan kişisel sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)'], 'puan' => 60],
    'F1.2' => ['baslik' => 'Yurt içinde tanınmış müze, kültür merkezi ya da sanat galerisinde açılan kişisel sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 40],
    'F1.3' => ['baslik' => 'Yurt dışı tanınmış müze veya büyük koleksiyonlarda yapıtınızın yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)'], 'puan' => 60],
    'F1.4' => ['baslik' => 'Yurt içi tanınmış müze veya büyük koleksiyonlarda yapıtınızın yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt İçi)'], 'puan' => 30],
    'F1.6' => ['baslik' => 'Kamusal veya özel alanda sergilenen sanat ya da tasarım ürünü', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Satın Alınması (Yurt İçi)', 'Eserin Haber Olması (Uluslararası)', 'Eserin Haber Olması (Ulusal)'], 'puan' => 10],
    'F1.7' => ['baslik' => 'Sergi, çalıştay, bienal, trienal, defile, festival ya da gösterim türü karma etkinlikte eserinizle yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Elektronik Karma Sergi (Uluslararası)', 'Elektronik Karma Sergi (Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 10],
    'F2.3' => ['baslik' => 'Tasarım alanında üretime girmiş çalışma ya da koleksiyon', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Müellif'], 'puan' => 100],
    'F2.5' => ['baslik' => 'Mimari proje, planlama ya da tasarım çalışmasında yardımcı olarak görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman'], 'puan' => 25],
    'F3.4' => ['baslik' => 'Sergi, bienal, trienal, festival ya da gösterilerde jüri üyeliği veya küratörlük', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 15],
    'F5.1' => ['baslik' => 'Yurt dışında müze, koleksiyon ya da arşiv malzemelerinin restorasyon ve konservasyonu', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koruma-Onarım Uygulaması (Uluslararası)'], 'puan' => 100],
    'F5.4' => ['baslik' => 'Yurt içinde müze, koleksiyon ya da arşiv malzemelerinin restorasyon ve konservasyonu', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koruma-Onarım Uygulaması (Ulusal)'], 'puan' => 50],
    'F7.4' => ['baslik' => 'Jürili sanat yarışmasında derece ya da mansiyon', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 50],

    // ══ H. TİYATRO ETKİNLİKLERİ ══
    'H1.6' => ['baslik' => 'Bir oyunun sahnelenmesinde dramaturg, koreograf, yönetmen ya da oyuncu olarak görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Rejisörlük (Uluslararası)', 'Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)', 'Rejisör Yardımcılığı (Uluslararası)', 'Rejisör Yardımcılığı (Ulusal)', 'Rejisör Yardımcılığı (Konservatuvar)', 'Sahneleme/Repetitörlük — Tüm Perde (Uluslararası)', 'Sahneleme/Repetitörlük — Tüm Perde (Ulusal)', 'Sahneleme/Repetitörlük — Bölüm (Uluslararası)', 'Sahneleme/Repetitörlük — Bölüm (Ulusal)', 'Koreografi', 'Tüm Perde Koreograflığı (Uluslararası)', 'Tüm Perde Koreograflığı (Ulusal)', 'Bölüm Koreograflığı (Uluslararası)', 'Bölüm Koreograflığı (Ulusal)', 'Bale/Dans Koreograflığı (Uluslararası)', 'Bale/Dans Koreograflığı (Ulusal)', 'Dansçı / Performans İcracısı (Uluslararası)', 'Dansçı / Performans İcracısı (Ulusal)'], 'puan' => 25],
    'H1.7' => ['baslik' => 'Bir oyunun sahnelenmesinde dekor, ışık ve kostüm tasarımında görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne Tasarımı (Dekor, Kostüm, Işık)'], 'puan' => 50],
];

$A1 = ['A1.1', 'A1.2', 'A1.3'];
$A2 = ['A2.1-Q1', 'A2.1-Q2', 'A2.1-Q3', 'A2.1-Q4', 'A2.2-Q1', 'A2.2-Q2', 'A2.2-Q3', 'A2.2-Q4',
    'A2.3', 'A2.4', 'A2.5', 'A2.6', 'A2.7'];
$A3 = ['A3.1', 'A3.3', 'A3.6', 'A3.8'];
$B1 = ['B1.1', 'B1.2', 'B1.3', 'B1.4', 'B1.5'];
$B2 = ['B2.3', 'B2.4'];
$C1 = ['C1.1', 'C1.3'];
$C2 = ['C2.2-y', 'C2.2-a', 'C2.2-d', 'C2.10-y', 'C2.10-a', 'C2.10-d', 'C2.13-y', 'C2.13-a',
    'C2.13-d', 'C2.15', 'C2.17-y', 'C2.17-a', 'C2.17-d'];
$C3 = ['C3.4-y', 'C3.4-a', 'C3.4-d', 'C3.3-y', 'C3.3-a', 'C3.3-d'];
$C4 = ['C4.3', 'C4.4', 'C4.5', 'C4.6', 'C4.7'];
$CDIGER = ['C6.1', 'C6.2', 'C6.3', 'C7.1', 'C7.2', 'C8.1', 'C8.2', 'C8.3', 'C8.4', 'C8.5', 'C8.6', 'C8.7'];
$E = ['E1.1', 'E1.2', 'E1.3', 'E1.4', 'E1.9', 'E1.10', 'E1.11', 'E2.1'];
$F = ['F1.1', 'F1.2', 'F1.3', 'F1.4', 'F1.6', 'F1.7', 'F2.3', 'F2.5', 'F3.4', 'F5.1', 'F5.4', 'F7.4'];
$H = ['H1.6', 'H1.7'];

$yazarKatsayisi = [
    'haric' => ['atif', 'proje', 'patent', 'tez_danismanligi', 'egitim_ogretim', 'editorluk',
        'odul', 'idari_gorev', 'sanatsal_etkinlik', 'toplumsal_katki', 'diger'],
    'roller' => [
        'tek' => ['kademeler' => [1 => 1.00]],
        'ilk' => ['kademeler' => [1 => 1.00, 2 => 1.00, 3 => 0.90, 4 => 0.80], 'sonrasi' => 0.70],
        'baslica' => ['kademeler' => [1 => 1.00, 2 => 1.00, 3 => 0.90, 4 => 0.80], 'sonrasi' => 0.70],
        'yazar_2' => ['kademeler' => [2 => 0.90, 3 => 0.80, 4 => 0.70], 'sonrasi' => 0.60],
        'yazar_3' => ['kademeler' => [3 => 0.70, 4 => 0.60], 'sonrasi' => 0.50],
        'yazar_4' => ['kademeler' => [4 => 0.50], 'sonrasi' => 0.40],
        'yazar_5' => ['sonrasi' => 0.40],
        'yazar_6' => ['sonrasi' => 0.40],
        'ortak' => ['kademeler' => [1 => 1.00, 2 => 0.90, 3 => 0.70, 4 => 0.50], 'sonrasi' => 0.40],
    ],
];

$kapsamNotu = 'Puanlar Munzur Üniversitesi Öğretim Üyeliğine Yükseltilme ve Atanma İlkelerinin '
    .'EK-1 Puan Tablosundan. Kaynak PDF\'in gömülü metin katmanı bozuktu; görüntüden OCR ile '
    .'okundu ve puan sütunu gözle doğrulandı. Çok yazarlı KİTAP, MAKALE VE BİLDİRİLERDE puan '
    .'Madde 6\'nın yazar sayısı × sıra matrisine göre bölünüyor (tek yazar %100; iki yazarda '
    .'1. isim %100, 2. isim %90; beş ve üzeri yazarda %70\'ten %40\'a). Sanat etkinlikleri, '
    .'projeler, atıflar ve idari görevler bölünmüyor — yönergenin kendi kapsamı böyle. '
    .'PUANINIZ ŞU KALEMLERDE OLDUĞUNDAN DÜŞÜK GÖRÜNÜR: SPORTİF ETKİNLİKLER bölümünün tamamı '
    .'(11 satır, 100 puana kadar), h-indeksi, sertifika programları, dolaşım programları, '
    .'yurt dışı araştırma süresi, patent BAŞVURULARI, devam eden tez danışmanlıkları, '
    .'arkeolojik kazı satırları ve düzenleme kurulu üyelikleri kayıtta karşılıksız kaldı. '
    .'A2.1\'in iki çarpanı da uygulanamıyor: TÜBİTAK ya da sanayi iş birliği projesi '
    .'kapsamındaki yayınlar ile uluslararası iş birliğiyle yapılan yayınlar için verilen '
    .'1,25 katı, kayıtta böyle bir nitelik olmadığı için işlemiyor. Bildiriler toplantıyı '
    .'düzenleyen kuruluşa göre üç ayrı bölümde puanlanıyor; kayıt bu ayrımı taşımadığı için '
    .'daima EN DÜŞÜK bölümden sayılıyor (yabancı dilde tam metin 20 yerine 10). '
    .'PUANINIZ ŞU KALEMLERDE OLDUĞUNDAN YÜKSEK GÖRÜNEBİLİR: İDARİ GÖREVLER bölümünün '
    .'"diğer bölümlerin toplamının %20\'sini aşamaz" tavanı başka bir bölümün toplamına '
    .'bağlı olduğu için uygulanamıyor; ders ve idari görev puanları da süreyle çarpılmıyor.';

$cetveller = [];

foreach (['' => 1.0, '-sosyal' => 1.5] as $ek => $carpan) {
    $tablo = array_merge($ortakMaddeler, $makaleSatirlari($carpan));
    $gruplar = [
        'TUM' => array_keys($tablo),
        'A1' => $A1,
        // Madde 10-12'nin andığı kümeler.
        'A1A2A3A4B2' => array_merge($A1, $A2, $A3, $B2),
        'A2A3A4B2' => array_merge($A2, $A3, $B2),
        'A1A2A3B1B2' => array_merge($A1, $A2, $A3, $B1, $B2),
        'MIMARLIK' => array_merge($A1, $A2, $A3, $B1, $B2),
        'GS-DR' => array_merge($A1, $A2, $A3, $B1, $B2, $C2, $C3, $C4),
        'GS-DOC' => array_merge($A1, $A2, $A3, $B2, $C2, $C3, $C4),
        'C' => array_merge($C1, $C2, $C3, $C4, $CDIGER),
        'EFH' => array_merge($E, $F, $H),
    ];

    foreach ([null, 20, 30, 50] as $tavan) {
        if ($ek === '-sosyal' && $tavan === 20) {
            continue;
        }

        $anahtar = 'munzur-2025'.$ek.($tavan === null ? '' : "-a1-{$tavan}");

        $cetveller[$anahtar] = [
            'kapsam_notu' => $kapsamNotu
                .($carpan > 1.0 ? ' Sosyal Bilimler kapsamında SCI, SSCI ve AHCI makalelerinin '
                    .'puanı 1,5 katı uygulanıyor (A2.1 satırının kendi kuralı).' : '')
                .($tavan !== null ? " Uluslararası kitap kalemlerinden (A1) en fazla {$tavan} "
                    .'puan sayılıyor; yönerge bu tavanı zorunlu puan hesabı için koyuyor, motor '
                    .'ise cetvel geneline uyguluyor, bu yüzden toplamınız bir miktar düşük '
                    .'çıkabilir.' : ''),
            'yazar_katsayisi' => $yazarKatsayisi,
            'maddeler' => $tablo,
            'gruplar' => $gruplar,
            'grup_tavanlari' => $tavan === null ? [] : ['A1' => $tavan],
        ];
    }
}

return ['cetveller' => $cetveller];
