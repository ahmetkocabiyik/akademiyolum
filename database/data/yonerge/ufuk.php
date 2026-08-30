<?php

use App\Services\Scoring\Sart\Kalip;

/**
 * UFUK ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma Yönergesi
 * Kaynak: pdf/17634009071.Ufuk Üniversitesi Kriter.pdf
 * (Senato 03.01.2025; YÖK Genel Kurulu 30.04.2025)
 *
 * Cetvel: cetvel/ufuk-2025.php
 *
 * ── EŞİKLERİN YAPISI ──
 * Koşullar temel alandan bağımsız. Doktor öğretim üyeliğinde Ek-2'nin
 * yayın, bildiri ve tez kaynaklı yayın maddelerinden 20 puan; doçentlikte
 * yalnızca ÜAK doçent unvanı; profesörlükte doçentlik sonrası 50 puan ile
 * bir uluslararası ve iki ulusal yayın koşulu.
 *
 * ── YORUM KARARLARI (§0) ──
 *   Yabancı dil eşiği, öğretim dili kısmen ya da tamamen İngilizce olan
 *       programlarda 85, Türkçe ders verecekler için 55 puan. Araç program
 *       dilini bilmediği için 55 üzerinden değerlendiriyor.
 *   Ek-2'nin 4. maddesi (lisansüstü tezlerden üretilen yayınlar) cetvele
 *       girilemediği için doktor öğretim üyeliğinin 20 puanlık barajı
 *       yalnız 1, 2 ve 3. maddelerden hesaplanıyor.
 *   Profesörlükte Ek-1 tablosunun "Çalışma Süresi" sütunu doçentlik
 *       sonrası beş yıl ve en az altı yarıyıl ders verme koşulunu getiriyor;
 *       ders koşulu yarıyıl metriğine çevrildi.
 *   MADDE 9'un Tıp Fakültesi kadroları için puan şartını kaldırabilen
 *       istisnası yazılmadı.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 4/2'nin yabancı dille ders verme koşulları ile MADDE 8'in
 *       başvuru ve atanma usulleri.
 */
$TUM_ALANLAR = ['fen', 'muhendislik', 'saglik', 'ziraat', 'sosyal', 'egitim', 'filoloji',
    'ilahiyat', 'spor', 'hukuk', 'guzel_sanatlar', 'mimarlik'];

$DIL_NOTU = 'Yabancı dil koşulu programın diline bağlı: öğretim dili kısmen ya da tamamen '
    .'İngilizce olan programlarda 85, Türkçe ders verecekler için 55 puan. Araç program dilini '
    .'bilmediği için 55 üzerinden değerlendiriyor.';

$PUAN_NOTU = 'Ek-2\'nin atıf satırları (atıf sayısının 0,5 ve 0,3 katı) ile ders satırları '
    .'(dönemlik ders saatiyle çarpılan katsayılar) ondalıklı olduğu için araca girilemedi; '
    .'atıflarınız ve ders kayıtlarınız toplam puana katkı vermiyor. Lisansüstü tezinizden '
    .'üretilmiş yayınlar için ayrı ve düşük olan 4. madde de girilemediğinden bu yayınlar tam '
    .'satırlardan puanlanıyor.';

return [
    [
        'anahtar' => 'ufuk-dr',
        'universite' => 'Ufuk Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $TUM_ALANLAR,
        'cetvel' => 'ufuk-2025',
        'notlar' => 'MADDE 5 ve Ek-1: uluslararası yayınlar, ulusal yayınlar, kongre bildirileri '
            .'ve lisansüstü tezlerden üretilen yayınlar kalemlerinden en az toplam 20 puan.',
        'aday_notu' => 'Doktor öğretim üyeliği için Ek-2\'nin yayın ve bildiri maddelerinden 20 '
            .'puan yeterli. Baraj yalnız bu kalemlerden hesaplanıyor; kitap, patent, proje, tez '
            .'danışmanlığı, editörlük, ödül ve idari görev puanlarınız 20 puanlık barajın '
            .'DIŞINDA kalıyor. '.$PUAN_NOTU.' '.$DIL_NOTU,
        'sart' => Kalip::ve('Doktor öğretim üyeliği koşulları', [
            Kalip::yds(55),
            Kalip::toplam(20, maddeler: ['DR-KRITER'], liste: 'MADDE 5 / Ek-1'),
        ]),
    ],
    [
        'anahtar' => 'ufuk-dr-yeniden',
        'universite' => 'Ufuk Üniversitesi',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $TUM_ALANLAR,
        'cetvel' => 'ufuk-2025',
        'notlar' => 'Yönerge yeniden atamayı ayrıca düzenlemiyor; MADDE 5\'in ilk atama koşulu '
            .'uygulandı.',
        'aday_notu' => 'Yönergede yeniden atama için ayrı bir ölçüt yok; ilk atamanın 20 puanlık '
            .'koşulu uygulandı. Ek-2\'nin 8. maddesi yalnızca "yeniden atamalar için devam eden '
            .'tez danışmanlıkları bir kez puanlanır" diyor. '.$PUAN_NOTU,
        'sart' => Kalip::toplam(20, maddeler: ['DR-KRITER'], liste: 'MADDE 5 / Ek-1'),
    ],
    [
        'anahtar' => 'ufuk-docentlik',
        'universite' => 'Ufuk Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $TUM_ALANLAR,
        'cetvel' => 'ufuk-2025',
        'notlar' => 'MADDE 6 ve Ek-1: doçent kadrosunda ek puan koşulu yok; ÜAK tarafından ilgili '
            .'alanda doçent unvanını almış olmak yeterli.',
        'aday_notu' => 'Ufuk Üniversitesinde doçent kadrosuna atanmak için yönergenin koyduğu ek '
            .'bir puan koşulu yok. Yönerge doğrudan 2547 sayılı Kanun ile Öğretim Üyeliğine '
            .'Yükseltilme ve Atanma Yönetmeliğine atıf yapıyor; Ek-1 tablosu da yalnızca '
            .'Üniversitelerarası Kurul tarafından ilgili alanda doçent unvanının alınmış olmasını '
            .'arıyor. '.$DIL_NOTU,
        'sart' => Kalip::ve('Doçentlik koşulları', [
            Kalip::beyan('Üniversitelerarası Kurul tarafından ilgili alanda doçent unvanını almış olmak', 'MADDE 6 / Ek-1'),
            Kalip::yds(55),
        ]),
    ],
    [
        'anahtar' => 'ufuk-profesorluk',
        'universite' => 'Ufuk Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $TUM_ALANLAR,
        'cetvel' => 'ufuk-2025',
        'notlar' => 'MADDE 7 ve Ek-1: doçentlik sonrası akademik faaliyetlerden en az 50 puan; '
            .'uluslararası yayın maddelerinden en az 1, ulusal yayın maddelerinden en az 2 yayın '
            .'(lisansüstü tezlerden üretilmemiş olmak kaydıyla); doçentlik sonrası beş yıl ve en '
            .'az altı yarıyıl ders vermiş olmak.',
        'aday_notu' => 'Profesörlük için doçent unvanınızı aldıktan sonraki akademik '
            .'faaliyetlerden 50 puan gerekiyor. Bunun yanında uluslararası yayın maddelerinden '
            .'en az bir, ulusal yayın maddelerinden en az iki yayınınız olmalı ve bu yayınlar '
            .'lisansüstü tezlerinizden üretilmemiş olmalı; araç yayının tez kökenli olup '
            .'olmadığını ayırt edemiyor. Ayrıca doçentlik unvanını aldığınız tarihten sonra en '
            .'az altı yarıyıl alanınızda ve bir yükseköğretim kurumunda ders vermiş olmanız '
            .'gerekiyor. '.$PUAN_NOTU.' '.$DIL_NOTU,
        'sart' => Kalip::ve('Profesörlük koşulları', [
            Kalip::yds(55),
            Kalip::beyan('Doçentlik unvanını aldıktan sonra en az beş yıl geçmiş olmak', 'Ek-1 (Çalışma Süresi)'),
            Kalip::metrik('Doçentlik unvanını aldığı tarihten sonra en az altı yarıyıl alanında ve bir yükseköğretim kurumunda ders vermiş olmak', 'ders_yariyil', 6, Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('Uluslararası yayın maddelerinden en az 1 yayın', ['ULUSLARARASI-YAYIN'], 1, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Ek-1 (Kriterler 1)'),
            Kalip::adet('Ulusal yayın maddelerinden en az 2 yayın', ['ULUSAL-YAYIN'], 2, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Ek-1 (Kriterler 2)'),
            Kalip::toplam(50, donem: Kalip::DOCENTLIK_SONRASI, liste: 'MADDE 7 / Ek-1'),
        ]),
    ],
];
