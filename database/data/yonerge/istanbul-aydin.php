<?php

use App\Services\Scoring\Sart\Kalip;

/**
 * İSTANBUL AYDIN ÜNİVERSİTESİ — Akademik Yükseltme ve Atama Yönergesi
 * Kaynak: pdf/17537099242.istanbulaydinuniversitesi.pdf
 *
 * Cetvel: cetvel/istanbul-aydin-2020.php
 *
 * ── EŞİKLERİN YAPISI ──
 * Yönerge tek bir puan barajı kurgusu kullanıyor ve barajı temel alana
 * göre değiştirmiyor. Doktor öğretim üyeliğinde MADDE 6.1'in saydığı
 * sınırlı yayın satırlarından 30 puan; doçentlik ve profesörlükte Ek-1'in
 * A ve B bölümlerinin tamamından 40 puan. Sanat ve Mimarlık alanlarında
 * MADDE 6.5 gereği Ek-3 listesi de bu toplama giriyor.
 *
 * ── YORUM KARARLARI (§0) ──
 *   MADDE 6.2 doçentlikte iki yol tanıyor: yükseköğretim kurumunda bir
 *       akademik kadroda çalışıyorsanız doçentlik belgesi yeterli;
 *       çalışmıyorsanız ve doçent unvanının üzerinden üç yıldan fazla
 *       geçmişse 40 puan aranıyor. Araç adayın hâlen bir kadroda çalışıp
 *       çalışmadığını bilmediği için iki yol da yazıldı; "kadroda
 *       çalışıyor olmak" beyan düğümü olarak soruluyor.
 *   MADDE 6.3 profesörlüğe yükseltmede "doçentlik şartlarını yeniden
 *       sağlamak" diyor; bu, MADDE 6.2'nin 40 puanlık barajının doçentlik
 *       sonrası dönemde yeniden sağlanması olarak okundu.
 *   Yönerge yeniden atamayı düzenlemiyor; doktor öğretim üyeliğinde ilk
 *       atama koşulları yeniden atamaya da uygulandı.
 *   MADDE 6.1'in saydığı satırlardan A.3 ile B.5'in sözlükte karşılığı
 *       olmadığı için 30 puanlık baraja katkı veremiyorlar.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   "Güzel Sanatlar Fakültesi Özel Puanlama Tablosu"nun ek bazlı yüzde
 *       dağılımı (EK1 %30, EK2 %10-20, EK3 %50-60) — motor toplam puanın
 *       hangi ekten geldiğini oransal olarak sınırlayamıyor; Sanat ve
 *       Mimarlık eşiklerinde yalnızca sayısal baraj uygulanıyor.
 *   MADDE 4 ve 5'in başvuru ve ön değerlendirme usulleri.
 */
$GENEL = ['fen', 'muhendislik', 'saglik', 'ziraat', 'sosyal', 'egitim', 'filoloji',
    'ilahiyat', 'spor', 'hukuk'];
$SANAT = ['guzel_sanatlar', 'mimarlik'];

$SANAT_NOTU = 'Sanat ve Mimarlık alanlarında MADDE 6.5 gereği Ek-3\'ün sanat satırları da bu '
    .'toplama giriyor. Yönergenin Güzel Sanatlar Fakültesi için öngördüğü ek bazlı yüzde '
    .'dağılımı (Ek-1 %30, Ek-2 %10-20, Ek-3 %50-60) araçta uygulanamıyor; yalnızca sayısal '
    .'baraj değerlendiriliyor.';

$DR_NOTU = 'Doktor öğretim üyeliğinin 30 puanlık barajı Ek-1\'in TAMAMINDAN değil, MADDE '
    .'6.1\'in tek tek saydığı satırlardan hesaplanıyor: A1-A5 (uluslararası makale, kitap ve '
    .'kitap bölümü) ile B1-B5, B7 ve B12 (ulusal makale, kitap, kitap bölümü, ders kitabı, '
    .'kitap editörlüğü ve ulusal tam bildiri). Atıf, proje, hakemlik, ödül, patent, tez '
    .'danışmanlığı ve idari görev puanlarınız bu barajın DIŞINDA kalıyor. Bu listedeki A.3 '
    .'(önde gelen ülkelerin hakemli dergileri) ve B.5 (ders notu) satırlarının faaliyet '
    .'kaydında karşılığı olmadığı için onlar da sayılamıyor.';

$drSarti = fn (): array => Kalip::toplam(30, maddeler: ['DR-30'], liste: 'MADDE 6.1');

$esikler = [];

foreach ([['genel', $GENEL, false], ['sanat', $SANAT, true]] as [$anahtar, $alan, $sanat]) {
    $ortak = ['universite' => 'İstanbul Aydın Üniversitesi', 'alan' => $alan,
        'cetvel' => 'istanbul-aydin-2020'];
    $grup = $sanat ? 'A-B-EK3' : 'A-B';
    $ek = $sanat ? ' '.$SANAT_NOTU : '';

    $esikler[] = array_merge($ortak, [
        'anahtar' => 'istanbul-aydin-'.$anahtar.'-dr',
        'kadro' => 'dr_ogr_uyesi',
        'notlar' => 'MADDE 6.1: A1-A5 ile B1-B5, B7 ve B12 satırlarından toplam en az 30 puan.',
        'aday_notu' => $DR_NOTU.$ek,
        'sart' => $drSarti(),
    ]);

    $esikler[] = array_merge($ortak, [
        'anahtar' => 'istanbul-aydin-'.$anahtar.'-dr-yeniden',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'notlar' => 'Yönerge yeniden atamayı düzenlemiyor; MADDE 6.1\'in ilk atama koşulu '
            .'uygulandı.',
        'aday_notu' => 'Yönergede yeniden atama için ayrı bir ölçüt yok; ilk atamanın 30 '
            .'puanlık koşulu uygulandı. '.$DR_NOTU.$ek,
        'sart' => $drSarti(),
    ]);

    $esikler[] = array_merge($ortak, [
        'anahtar' => 'istanbul-aydin-'.$anahtar.'-docentlik',
        'kadro' => 'docentlik',
        'notlar' => 'MADDE 6.2: yükseköğretim kurumunda akademik kadroda çalışan aday için '
            .'doçentlik belgesi yeterli; çalışmayan ve doçent unvanının üzerinden üç yıldan '
            .'fazla geçmiş aday için A ve B maddelerinden en az 40 puan.',
        'aday_notu' => 'İstanbul Aydın\'da doçent kadrosuna atanmanın koşulu, hâlen bir '
            .'yükseköğretim kurumunda akademik kadroda çalışıp çalışmadığınıza bağlı. '
            .'Çalışıyorsanız doçentlik belgeniz yeterli; çalışmıyorsanız ve doçent unvanınızı '
            .'aldıktan sonra üç yıldan fazla geçmişse Ek-1\'in A ve B bölümlerinden 40 puan '
            .'gerekiyor. Araç hangi durumda olduğunuzu bilmediği için ikisini de gösteriyor.'
            .$ek,
        'sart' => Kalip::ve('Doçentlik koşulları', [
            Kalip::beyan('Üniversitelerarası Kuruldan doçentlik belgesi almış olmak', 'MADDE 6.2'),
            Kalip::veya('Kadro ya da puan koşulu', [
                Kalip::beyan('Bir yükseköğretim kurumunda akademik kadroda çalışıyor olmak (bu durumda puan koşulu aranmaz)', 'MADDE 6.2'),
                Kalip::toplam(40, maddeler: [$grup], liste: 'MADDE 6.2'),
            ]),
        ]),
    ]);

    $esikler[] = array_merge($ortak, [
        'anahtar' => 'istanbul-aydin-'.$anahtar.'-profesorluk',
        'kadro' => 'profesorluk',
        'notlar' => 'MADDE 6.3: doçent olduğu tarihten sonra doçentlik şartlarını yeniden '
            .'sağlamak, yani A ve B maddelerinden 40 puan. MADDE 6.4 dışarıdan atamada da aynı '
            .'40 puanı arıyor.',
        'aday_notu' => 'Profesörlüğe yükseltilerek atanmak için doçent unvanınızı aldıktan '
            .'sonra doçentlik koşullarını yeniden sağlamanız, yani Ek-1\'in A ve B '
            .'bölümlerinden 40 puan toplamanız gerekiyor. Yükseköğretim kurumlarından ayrılıp '
            .'üç yıldan fazla dışarıda kalan profesörlerin yeniden atanmasında da aynı 40 puan '
            .'aranıyor.'.$ek,
        'sart' => Kalip::toplam(40, donem: Kalip::DOCENTLIK_SONRASI, maddeler: [$grup], liste: 'MADDE 6.3'),
    ]);
}

return $esikler;
