<?php

/**
 * İSTANBUL ÜNİVERSİTESİ-CERRAHPAŞA — EK-1 Değerlendirmeye Alınacak
 * Faaliyetler ve Puanlamalar (A: Uluslararası bölümü)
 * Kaynak: pdf/17536997582.istanbuluniverstesi-cerrahpasa.pdf (Senato 06.07.2023)
 *
 * KOŞULLAR ADET TABANLI, CETVEL PUANLI. Atanma koşulları makale SAYISI
 * istiyor ("SCIE/SSCI/AHCI — 3 adet") ve EK-1'in madde koduna atıf yapıyor
 * ("İlgili Madde: A4a"). Bu yüzden cetvelin işlevi kalemleri ADLANDIRMAK;
 * puanlar da girildi ama koşulların hiçbiri puan barajı değil.
 *
 * ÇEYREKLİK ÜÇ KADEME: Q1 50, Q2 40, Q3/Q4 BİRLİKTE 30. Yönerge Q3 ile Q4'ü
 * ayırmıyor, o yüzden tek madde.
 *
 * MAKALE TÜRÜ AYRIMI VAR: A4a özgün makale ve derleme, A4b kısa bildiri /
 * çalışma protokolü / vaka takdimi, A4c editöre mektup veya teknik not.
 * `turler` boyutuyla ifade edildi.
 *
 * GİRİLMEYEN: B (ulusal faaliyetler), C (proje ve patent) ve D bölümleri.
 * Koşullar C3b, C4b, C5a gibi kodlara atıf yapıyor ama bunlar "en az birini
 * sağla" biçiminde alternatif koşullar; motor tarafında `beyan` olarak duruyor.
 */

return [
    'kapsam_notu' => 'Puanlar İÜ-Cerrahpaşa EK-1 A bölümünden (uluslararası faaliyetler). Ulusal '
        .'faaliyetler, proje ve patent bölümleri girilmedi; atanma koşulları zaten makale '
        .'sayısına dayanıyor, puan barajı yok.',

    'maddeler' => [
        // ── A1-A3 · KİTAP ──
        'A1a' => ['baslik' => 'WoS/SCOPUS indeksli uluslararası bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 100],
        'A1b' => ['baslik' => 'Diğer uluslararası bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 60],
        'A2a' => ['baslik' => 'WoS/SCOPUS indeksli kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 35],
        'A2b' => ['baslik' => 'Diğer uluslararası kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası Kitap Bölümü'], 'puan' => 25],
        'A3a' => ['baslik' => 'WoS/SCOPUS indeksli kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 50],
        'A3b' => ['baslik' => 'Diğer uluslararası kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Uluslararası Kitap Editörlüğü'], 'puan' => 25],

        // ── A4 · SCIE/SSCI/AHCI MAKALE ── (koşulların çekirdeği)
        'A4a-Q1' => ['baslik' => 'SCIE/SSCI/AHCI Q1 dergide özgün makale veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 50],
        'A4a-Q2' => ['baslik' => 'SCIE/SSCI/AHCI Q2 dergide özgün makale veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 40],
        'A4a-Q34' => ['baslik' => 'SCIE/SSCI/AHCI Q3-Q4 dergide özgün makale veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 30],
        'A4b' => ['baslik' => 'SCIE/SSCI/AHCI dergide kısa makale, çalışma protokolü veya vaka takdimi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['kisa_makale'], 'puan' => 20],
        'A4c' => ['baslik' => 'SCIE/SSCI/AHCI dergide editöre mektup veya teknik not', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['vaka_teknik_not'], 'puan' => 15],

        // ── A6 · ESCI MAKALE ──
        'A6a' => ['baslik' => 'ESCI dergide özgün makale veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 25],
        'A6c' => ['baslik' => 'ESCI dergide editöre mektup veya teknik not', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 10],

        // ── A8 · DİĞER ULUSLARARASI HAKEMLİ DERGİ ──
        'A8a' => ['baslik' => 'Alan indeksli uluslararası hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 20],
        'A8b' => ['baslik' => 'Alan indeksinde taranmayan uluslararası hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 10],

        // ── A5, A7, A9 · EDİTÖRLÜK ve HAKEMLİK ──
        'A5a' => ['baslik' => 'SCIE/SSCI/AHCI dergide baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 75],
        'A5c' => ['baslik' => 'SCIE/SSCI/AHCI dergide yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 25],
        'A5d' => ['baslik' => 'SCIE/SSCI/AHCI dergide hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 5],
        'A7a' => ['baslik' => 'ESCI dergide baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 25],
        'A9a' => ['baslik' => 'Diğer uluslararası hakemli dergide baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi (Uluslararası)', 'TR Dizin Dergi'], 'puan' => 15],

        // ── A10 · BİLİMSEL TOPLANTI ──
        'A10a' => ['baslik' => 'Uluslararası toplantıda sözlü sunum', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 15],
        'A10b' => ['baslik' => 'Uluslararası toplantıda poster sunum', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 8],
        'A10c-B8c' => ['baslik' => 'Uluslararası toplantıda davetli konuşmacı', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı (Uluslararası)'], 'puan' => 3],
        // B bölümünün (ULUSAL FAALİYETLER) 8. maddesi hiç girilmemişti:
        // sözlü sunum 6, poster sunum 4, davetli konuşmacı 3. Ulusal bildiri
        // etiketlerinin karşılığı yoktu; `Davetli Konuşmacı` da kapsam
        // taşımadığı için A/10-c'nin 5'i yerine B/8-c'nin 3'ünü alır.
        'B8a' => ['baslik' => 'Ulusal bilimsel toplantıda sözlü sunum', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 6],
        'B8b' => ['baslik' => 'Ulusal bilimsel toplantıda poster sunum', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 4],

        // ── A11 · ULUSLARARASI ATIF ──
        // A11/a (SCIE/SSCI/AHCI, 10) SATIR OLARAK YOK. Sözlükte atıf tarafında
        // ESCI'yi SCIE/SSCI/AHCI'den ayıran etiket yok — ikisi de
        // `WoS / Scopus`. §0 uyarınca etiket DÜŞÜK satıra, yani A11/b'ye (7)
        // bağlandı; yüksek satırı da yazmak MAX yüzünden her atfa 10 verirdi.
        // WoS kapsamında atfı olan aday 10 yerine 7 puan görür.
        'A11b' => ['baslik' => 'ESCI ya da üstü uluslararası indekste yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 7],
        // `Patent` BURADAN ÇIKARILDI: patentte alınan atıf "uluslararası hakemli
        // DERGİDE atıf" değil. Kaynağın A11'inde patent satırı yok; aşağıdaki
        // B9/b ("Diğer", 1 puan) kaynağın kendi toplayıcısı, oraya bağlandı.
        'A11c' => ['baslik' => 'Diğer uluslararası hakemli dergilerde yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer (Uluslararası)'], 'puan' => 5],
        'A11ç' => ['baslik' => 'Yurt dışı kitap, monografi veya tezlerde yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 4],

        // ── B9 · ULUSAL ATIF ──
        // Bölüm tamamen girilmemişti; `TR Dizin` etiketi bu yüzden A11/b'nin
        // (ESCI, 7 puan) üstünde duruyordu ve bir TR Dizin atfı 2 yerine 7
        // puan alıyordu.
        'B9a' => ['baslik' => 'TÜBİTAK-ULAKBİM tarafından taranan yurt içi hakemli dergilerde yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
        // Kaynağın kendi toplayıcı satırı. Patentte alınan atıf kaynakta hiç
        // anılmıyor; §0 uyarınca EN DÜŞÜK toplayıcıya bağlandı.
        'B9b' => ['baslik' => 'Diğer kaynaklarda yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer (Ulusal)', 'Patent (Uluslararası)', 'Patent (Ulusal)'], 'puan' => 1],
    ],

    'gruplar' => [
        // Koşul tablolarının "İlgili Madde" sütununda anılan kodlar.
        'A4a' => ['A4a-Q1', 'A4a-Q2', 'A4a-Q34'],
        // "SCIE/SSCI/AHCI" koşulu makale türünü ayırmıyor; A4b ve A4c de sayılır.
        'SCIE-TUM' => ['A4a-Q1', 'A4a-Q2', 'A4a-Q34', 'A4b', 'A4c'],
        // "Uluslararası hakemli" koşulu: A4a, A6a, A8a, A8b.
        'ULUSLARARASI-HAKEMLI' => ['A4a-Q1', 'A4a-Q2', 'A4a-Q34', 'A6a', 'A8a', 'A8b'],
        // Sosyal Bilimlerde kitap bölümü 1 makale yerine sayılabiliyor.
        'KITAP-BOLUM' => ['A2a', 'A2b'],
        'MAKALE' => ['A4*', 'A6*', 'A8*'],
    ],

    'grup_tavanlari' => [],
];
