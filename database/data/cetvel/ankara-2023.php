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
 * 1A, 1B ve 1C kaynak sözlüğünde AYRILAMIYOR — üçü de 'SCIE/SSCI (Qn)'
 * etiketine düşüyor. Yalnızca 1A girildi; 1B ve 1C girilseydi `puan()` en
 * yükseği aldığı için hesabı değiştirmez, sadece kapsanmış gibi görünürdü.
 * Bunun sonucu: `1A-1B` ve `1A-1C` grupları pratikte `1A` ile aynı kümeye
 * çözülüyor. Aday eksik puan görür, fazla değil.
 *
 * GİRİLMEYEN BÖLÜMLER: 3. Sanatsal Etkinlik (müzik, sahne, sergi — 40'tan
 * fazla kalem, kaynak sözlüğünde çoğunun karşılığı yok), 7. Bilimsel/Sanatsal
 * Toplantı'nın bir kısmı ve idari/ödül kalemleri.
 */

return [
    'kapsam_notu' => 'Puanlar Ankara Üniversitesi 2023 kalıcı çizelgesinden. Short communication '
        .'ve vaka/teknik not türleri kaynak sözlüğünde özgün araştırma makalesinden ayrılamadığı '
        .'için ayrıca girilmedi; sanatsal etkinlik bölümü de henüz girilmedi. Gerçek toplamınız '
        .'burada görünenden yüksek olabilir, düşük olamaz.',

    'maddeler' => [
        // ── 1A · Özgün araştırma makalesi / derleme ──
        '1Aa' => ['baslik' => 'WoS Q1 dergide özgün araştırma makalesi/derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'puan' => 40],
        '1Ab' => ['baslik' => 'WoS Q2 dergide özgün araştırma makalesi/derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'puan' => 35],
        '1Ac' => ['baslik' => 'WoS Q3 dergide özgün araştırma makalesi/derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'puan' => 30],
        '1Aç' => ['baslik' => 'WoS Q4 dergide özgün araştırma makalesi/derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'puan' => 25],

        // ── 1E-1G · çeyrekliksiz indeks kümeleri ──
        '1Ea' => ['baslik' => 'WoS All Databases / SCOPUS dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 22],
        '1Eç' => ['baslik' => 'SCOPUS dergide kongre bildirisi tam metni/özeti', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 5],
        '1Fa' => ['baslik' => 'Diğer uluslararası indeksli dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'puan' => 20],
        '1Ga' => ['baslik' => 'TR-Dizin dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 15],
        '1Gb' => ['baslik' => 'TR-Dizin dergide short/brief communication', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'puan' => 5],

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
        '7a' => ['baslik' => 'Uluslararası toplantıda davetli konuşmacı', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 25],
        '7b' => ['baslik' => 'Uluslararası toplantıda sunulmuş tam metin/özet bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 15],
    ],

    'gruplar' => [
        // Koşulların birebir kullandığı atıflar. 1B ve 1C girilmediği için
        // `1A-1B` ve `1A-1C` pratikte `1A` ile aynı kümeye çözülüyor.
        '1A' => ['1Aa', '1Ab', '1Ac', '1Aç'],
        '1A-1B' => ['1Aa', '1Ab', '1Ac', '1Aç'],
        '1A-1C' => ['1Aa', '1Ab', '1Ac', '1Aç'],
        '1A-1E' => ['1Aa', '1Ab', '1Ac', '1Aç', '1Ea', '1Eç'],
        '1A-1G' => ['1*'],
        'KITAP' => ['2*'],
        'PROJE' => ['5*'],
        'PROJE_YURUTUCU' => ['5a', '5ç', '5f', '5h'],
    ],

    'grup_tavanlari' => [],
];
