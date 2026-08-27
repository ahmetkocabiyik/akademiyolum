<?php

/**
 * BARTIN ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma Ölçütleri
 * Yönergesi
 * Kaynak: pdf/17536931192.bartinuniverstesi.pdf (22 sayfa, Senato
 * 20.04.2022/2022/07-11, YÖK Genel Kurulu onayı 18.07.2022, yürürlük
 * 18.07.2023)
 *
 * ── YAPI: PUAN DEĞİL ÖLÇÜT SAYIYOR ──
 * Korpusta ilk kez bu ölçekte görülen desen: yönerge hiçbir yerde toplam
 * puan barajı koymuyor. Tablo-1 (Dr. Öğr. Üyesi) yirmi, Tablo-2 (doçent ve
 * profesör) yirmi iki satırlık bir ÖLÇÜT listesi veriyor ve her satırın
 * "temel ölçüt" ile "yardımcı ölçüt" olmak üzere iki dalı var. Madde 8/4 ve
 * 9/3 "aynı satırda belirtilen temel ölçüt veya yardımcı ölçütlerden sadece
 * biri değerlendirilir" dediği için her satır bir `Kalip::veya`, sayım ise
 * `Kalip::kIle` ile kuruldu.
 *
 * Bu yüzden dosyada `Kalip::toplam` HİÇ GEÇMİYOR. Cetvel (Tablo-3) puanlarıyla
 * girildi çünkü aday başvuru formunda o puanı beyan ediyor, ama hiçbir eşik
 * ona bağlı değil.
 *
 * ── KAÇ ÖLÇÜT, HANGİ ARALIKTAN ──
 *   Madde 8/2-a (Fen ve Matematik, Mühendislik, Sağlık, Ziraat-Orman-Su
 *       Ürünleri, Mimarlık-Planlama-Tasarım): Ölçüt 1 veya 1.a ZORUNLU +
 *       1-13 arasından en az 4 ölçüt.
 *   Madde 8/2-b (Eğitim, Filoloji, İlahiyat, Sosyal-Beşeri-İdari, Spor,
 *       Güzel Sanatlar): Ölçüt 2 veya 2.a ZORUNLU + 1-13 arasından en az 4.
 *   Madde 8/3 (yeniden atanma, alan ayrımı YOK): 1 veya 1.a İLE 2 veya 2.a
 *       zorunlu + en az 4'ü 1-13 arasında olmak üzere TOPLAM 6 ölçüt.
 *   Madde 9/2 (doçent, aynı iki alan grubu): Ölçüt 1 veya 1.a / 2 veya 2.a
 *       zorunlu + 1-22 arasından en az 10 ölçüt.
 *   Madde 10/2 (profesör): doçentlik ölçütlerinin AYNISINI doçentlik unvanı
 *       alındıktan sonra bir kez daha sağlamak.
 *
 * Yönergenin metni ölçüt aralığını Tablo-1 için "1 ila 13", Tablo-2 için
 * "1 ila 22" diye veriyor; Tablo-1'in kendisi YİRMİ satır taşıyor. Aradaki
 * fark kaynağın kendi tutarsızlığı (tablo büyümüş, metin güncellenmemiş) ve
 * olduğu gibi bırakıldı: "en az 4" koşulu 1-13'e, yeniden atanmanın "toplam
 * 6" koşulu tabloya bağlandı.
 *
 * ── HUKUK TEMEL ALANI KAPSAM DIŞI ──
 * Madde 8/2 ve 9/2 alanları tek tek sayıyor ve Hukuk hiçbirinde geçmiyor.
 * "Sosyal, Beşeri ve İdari Bilimler" başlığına katmak, adaya yönergede
 * yazmayan bir koşul göstermek olurdu; yazılmadı.
 *
 * ── DEĞERLENDİRİLEMEYEN ÖLÇÜTLER ──
 * Bir satırın iki dalı da faaliyet kaydından okunamıyorsa satır hiç
 * yazılmadı; tek dalı okunamıyorsa yalnızca okunabilen dal yazıldı. İkisi de
 * adayı olduğundan HAZIR göstermeyen yönde sapıyor (bir ölçüt daha az
 * sayılıyor).
 *
 *   Tablo-1'de yazılmayan satırlar:
 *     15 — "kesintisiz 6 ay yurt dışında bulunmuş olmak" / "uluslararası
 *          işbirliğiyle yayın veya proje ya da resmî spor müsabakasında
 *          görev". Yurt dışı süresi, ortak yazarın kurumu ve spor görevi
 *          kayıtta yok.
 *     19 — ders değerlendirme anketi ortalaması; ankette alınan puan kayıtta
 *          yok.
 *     20 — idari görev SÜRESİ (2 ya da 3 yıl); görev süresi kayıtta yok.
 *   Tablo-2'de yazılmayan satır:
 *     16 — milli takım antrenörlüğü / olimpik federasyon kurulları. Sözlükte
 *          spor karşılığı yok.
 *   Tek dalı yazılan satırlar:
 *     Tablo-1/2 (yardımcı dal 2.a): "Senato tarafından onaylanan alan
 *          indeksleri" kuruma özel bir liste, cetvele giremedi.
 *     Tablo-1/12 ve Tablo-2/12 (temel dal): arkeolojik kazı ve yüzey
 *          araştırması; sözlükte karşılıksız. Yardımcı dal duruyor.
 *     Tablo-1/13 ve Tablo-2/17 (temel dal): h-indeksi bir profil özelliği.
 *          "En az 15 / 30 atıf" yardımcı dalı duruyor.
 *     Tablo-1/14 ve Tablo-2/9 (yardımcı dal): patent BAŞVURUSU; cetvelde
 *          tescilliyle aynı kayda düştüğü için girilmedi.
 *     Tablo-2/8 (yardımcı dal): 6 ay yurt dışı.
 *     Tablo-2/21 ve 22: ders anketi ve idari görev süresi dalları düştü,
 *          ikisinin de "uluslararası dergide bir araştırma makalesi" alternatif
 *          dalı duruyor.
 *
 * ── OKUNAMAYAN NİTELİKLER: DAİMA ZOR OLAN DAL SEÇİLDİ ──
 *   Tablo-1 ölçüt 4 "YABANCI DİLDE uluslararası hakemli dergide 1 makale",
 *       yardımcı dalı "Türkçe dahil uluslararası nitelikli hakemli dergide
 *       2 makale" diyor. Yayının dili kayıtta yok; dil koşulu aranmayan
 *       yardımcı dal (2 makale) tek başına yazıldı. Bir makalesi yabancı
 *       dilde olan aday bu ölçütü sağlamıyor görünür.
 *   Ölçüt 7 "en az üçüncüsü düzenlenen" etkinlik diyor; etkinliğin kaçıncı
 *       kez düzenlendiği kayıtta yok, koşul aranmadı (satır olduğundan
 *       KOLAY görünür).
 *   Ölçüt 8 ve Tablo-2 ölçüt 7 TÜBİTAK program numaralarını tek tek sayıyor
 *       (1001, 1003, 2237-A, 3501…); kayıt yalnızca destekleyen kurumu
 *       taşıyor. Ölçüt "TÜBİTAK/TÜSEB/AB projesi" ile, yardımcı dalı
 *       "BAP ve diğer kamu programları" ile yaklaşıklandı.
 *   Tablo-2 ölçüt 4 "TEK YA DA İKİ YAZARLI kitap" diyor; kitabın yazar
 *       sayısı koşula çevrilemedi (motorun `adet` düğümü sıra filtreliyor,
 *       sayı filtrelemiyor). Satır olduğundan KOLAY görünür.
 *   "Yürütüyor olmak" (devam eden tez ve projeler) kayıtta yok; ilgili
 *       dallarda yalnızca TAMAMLANMIŞ olanlar sayıldı.
 *
 * ── DÖNEMLER ──
 *   Dr. ilk atanma: Madde 8/5 "her atamada atama dönemi içindeki ölçütleri
 *       karşılamak zorunludur" diyor; ilk atamanın dönemi doktora sonrası
 *       kabul edilip `DOKTORA_SONRASI` bağlandı. Yönerge bunu açıkça
 *       yazmıyor, dar okuma seçildi.
 *   Dr. yeniden atanma: Madde 8/3 "bir önceki atanmadan sonra" →
 *       `SON_ATAMA_SONRASI`.
 *   Doçent: Madde 9/2 "doktor unvanı aldıktan sonra" → `DOKTORA_SONRASI`.
 *   Profesör: Madde 10/2 "doçent unvanını aldıktan sonra" →
 *       `DOCENTLIK_SONRASI`.
 *   İSTİSNA: Madde 9/2 ve 10/2, "Temel Ölçüt 17 ve Yardımcı Ölçüt 17.a
 *       DIŞINDAKİ tüm faaliyetler" diyor — atıf/h-indeksi ölçütü dönem
 *       kısıtından muaf; o satır dönemsiz yazıldı.
 *
 * ── GİRİLMEYEN DİĞER KOŞULLAR ──
 *   Madde 8/6 ve 9/4: "bilimsel faaliyetlerin tümünde yazar sayısının sekizi
 *       geçmemesi" — motorda yazar SAYISINA bağlı bir eleme düğümü yok.
 *   Madde 8/8-9 (doğum ve hastalık izniyle uzayan atama süresi, bir yıl ek
 *       süre) ve Madde 12 (öğretim üyesi temininde güçlük çekilen alanlarda
 *       koşulların aranmayabilmesi, yabancı uyruklu öğretim üyeleri) —
 *       idari takdire ve kişisel duruma bağlı istisnalar.
 *   Madde 8/1-ç, 9/1-ç, 10/1-d: Yabancı Diller Yüksekokulu, mütercim-
 *       tercümanlık ve hazırlık birimleri için YÖK'ün ayrı dil puanı şartı —
 *       birimin niteliği profilde yok.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/bartin-2022.php
 */

use App\Services\Scoring\Sart\Kalip;

$CETVEL = 'bartin-2022';
$UNIVERSITE = 'Bartın Üniversitesi';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

/** Madde 8/2-a ve 9/2-a: Ölçüt 1 zorunlu olan temel alanlar. */
$SAYISAL_ALANLAR = ['fen', 'muhendislik', 'saglik', 'ziraat', 'mimarlik'];

/** Madde 8/2-b ve 9/2-b: Ölçüt 2 zorunlu olan temel alanlar. */
$SOZEL_ALANLAR = ['egitim', 'filoloji', 'ilahiyat', 'sosyal', 'spor', 'guzel_sanatlar'];

/**
 * Tablo-1'in değerlendirilebilen ölçüt satırları, satır numarasına göre.
 * Her satır kaynaktaki gibi "temel ölçüt VEYA yardımcı ölçüt" (Madde 8/4).
 *
 * @param  array<string, mixed>|null  $donem
 * @return array<int, array<string, mixed>>
 */
$tablo1 = function (?array $donem): array {
    $m = fn (int $no): string => "Tablo-1 Ölçüt {$no}";

    return [
        1 => Kalip::veya('Q dergilerinde araştırma makalesi', [
            Kalip::adet('Q1 kategorisindeki bir dergide en az 1 araştırma makaleniz olmalı', ['Q1-ARASTIRMA'], 1, donem: $donem, madde: $m(1)),
            Kalip::ve('En az biri Q2 olmak üzere iki araştırma makalesi (Q4 sayılmaz)', [
                Kalip::adet('Q2 kategorisindeki bir dergide en az 1 araştırma makaleniz olmalı', ['Q2-ARASTIRMA'], 1, donem: $donem, madde: $m(1)),
                Kalip::adet('Q1, Q2 veya Q3 dergilerinde toplam en az 2 araştırma makaleniz olmalı', ['Q1-Q3-ARASTIRMA'], 2, donem: $donem, madde: $m(1)),
            ]),
        ]),
        2 => Kalip::adet('SCI, SCI-Expanded, SSCI, AHCI veya Scopus dergilerinde en az 1 araştırma ya da derleme makaleniz olmalı', ['WOS-SCOPUS-MAKALE'], 1, donem: $donem, madde: $m(2)),
        3 => Kalip::veya('Birinci veya ikinci ölçütü iki kez sağlamak', [
            Kalip::adet('Q1 kategorisindeki dergilerde en az 2 araştırma makaleniz olmalı', ['Q1-ARASTIRMA'], 2, donem: $donem, madde: $m(3)),
            Kalip::adet('SCI, SCI-Expanded, SSCI, AHCI veya Scopus dergilerinde en az 2 araştırma ya da derleme makaleniz olmalı', ['WOS-SCOPUS-MAKALE'], 2, donem: $donem, madde: $m(3)),
            Kalip::ve('En az ikisi Q2 olmak üzere dört araştırma makalesi (Q4 sayılmaz)', [
                Kalip::adet('Q2 kategorisindeki dergilerde en az 2 araştırma makaleniz olmalı', ['Q2-ARASTIRMA'], 2, donem: $donem, madde: $m(3)),
                Kalip::adet('Q1, Q2 veya Q3 dergilerinde toplam en az 4 araştırma makaleniz olmalı', ['Q1-Q3-ARASTIRMA'], 4, donem: $donem, madde: $m(3)),
            ]),
        ]),
        4 => Kalip::adet('Uluslararası hakemli dergilerde en az 2 araştırma ya da derleme makaleniz olmalı', ['ULUSLARARASI-HAKEMLI'], 2, donem: $donem, madde: $m(4)),
        5 => Kalip::veya('TR Dizin makalesi ya da derleme, eleştiri veya çeviri', [
            Kalip::adet('ULAKBİM TR Dizin dergilerinde en az 1 araştırma makaleniz olmalı', ['TR-DIZIN-ARASTIRMA'], 1, donem: $donem, madde: $m(5)),
            Kalip::adet('Uzmanlık alanınızda en az 2 derleme, mektup, eleştiri, katalog yazısı, kitap değerlendirme veya biyografiniz olmalı', ['DERLEME-ELESTIRI'], 2, donem: $donem, madde: $m(5)),
            Kalip::adet('En az 2 kitap bölümü veya makale çeviriniz olmalı', ['CEVIRI-BOLUM'], 2, donem: $donem, madde: $m(5)),
            Kalip::adet('En az 1 tam kitap çeviriniz olmalı', ['CEVIRI-KITAP'], 1, donem: $donem, madde: $m(5)),
        ]),
        6 => Kalip::veya('Kitap, kitap bölümü veya kitap editörlüğü', [
            Kalip::adet('Tanınmış uluslararası yayınevinde en az 1 bilimsel kitabınız olmalı', ['ULUSLARARASI-KITAP'], 1, donem: $donem, madde: $m(6)),
            Kalip::adet('Tanınmış uluslararası yayınevinde en az 2 kitap bölümünüz olmalı', ['ULUSLARARASI-BOLUM'], 2, donem: $donem, madde: $m(6)),
            Kalip::adet('Tanınmış uluslararası yayınevinde en az 1 kitap editörlüğünüz olmalı', ['ULUSLARARASI-EDITORLUK'], 1, donem: $donem, madde: $m(6)),
            Kalip::adet('Tanınmış ulusal yayınevinde en az 1 bilimsel kitabınız olmalı', ['ULUSAL-KITAP'], 1, donem: $donem, madde: $m(6)),
            Kalip::adet('Tanınmış ulusal yayınevinde en az 2 kitap bölümünüz olmalı', ['ULUSAL-BOLUM'], 2, donem: $donem, madde: $m(6)),
            Kalip::ve('Bir kitap bölümü ve üç ansiklopedi maddesi', [
                Kalip::adet('Ulusal kitapta en az 1 bölüm yazarlığınız olmalı', ['ULUSAL-BOLUM'], 1, donem: $donem, madde: $m(6)),
                Kalip::adet('En az 3 ansiklopedi madde yazarlığınız olmalı', ['ANSIKLOPEDI'], 3, donem: $donem, madde: $m(6)),
            ]),
        ]),
        7 => Kalip::veya('Bilimsel etkinlikte tam metin bildiri', [
            Kalip::adet('Uluslararası bilimsel etkinlikte tam metin basılmış en az 1 bildiriniz olmalı', ['I.1'], 1, donem: $donem, madde: $m(7)),
            Kalip::adet('Ulusal bilimsel etkinliklerde tam metin basılmış en az 3 bildiriniz olmalı', ['I.6'], 3, donem: $donem, madde: $m(7)),
        ]),
        8 => Kalip::veya('Üniversite dışından kaynak sağlayan projede görev', [
            Kalip::adet('TÜBİTAK, TÜSEB veya Avrupa Birliği destekli bir projede yürütücü, araştırmacı ya da bursiyer olarak görev almış olmalısınız', ['BUYUK-PROJE'], 1, donem: $donem, madde: $m(8)),
            Kalip::adet('BAP ya da diğer ulusal kamu kurumu destekli bir projede görev almış olmalısınız', ['KUCUK-PROJE'], 1, donem: $donem, madde: $m(8)),
        ]),
        9 => Kalip::veya('Dördüncü ile sekizinci ölçütlerden birini iki kez sağlamak', [
            Kalip::adet('Uluslararası hakemli dergilerde en az 4 araştırma ya da derleme makaleniz olmalı', ['ULUSLARARASI-HAKEMLI'], 4, donem: $donem, madde: $m(9)),
            Kalip::adet('ULAKBİM TR Dizin dergilerinde en az 2 araştırma makaleniz olmalı', ['TR-DIZIN-ARASTIRMA'], 2, donem: $donem, madde: $m(9)),
            Kalip::adet('Tanınmış yayınevlerinde en az 2 bilimsel kitabınız olmalı', ['ULUSLARARASI-KITAP', 'ULUSAL-KITAP'], 2, donem: $donem, madde: $m(9)),
            Kalip::adet('Tanınmış yayınevlerinde en az 4 kitap bölümünüz olmalı', ['KITAP-BOLUM-TUM'], 4, donem: $donem, madde: $m(9)),
            Kalip::adet('Uluslararası bilimsel etkinliklerde tam metin basılmış en az 2 bildiriniz olmalı', ['I.1'], 2, donem: $donem, madde: $m(9)),
            Kalip::adet('TÜBİTAK, TÜSEB veya Avrupa Birliği destekli en az 2 projede görev almış olmalısınız', ['BUYUK-PROJE'], 2, donem: $donem, madde: $m(9)),
            Kalip::adet('BAP ya da diğer kamu kurumu destekli en az 2 projede görev almış olmalısınız', ['KUCUK-PROJE'], 2, donem: $donem, madde: $m(9)),
        ]),
        10 => Kalip::adet('Mimarlık, planlama ve tasarım alanında ürettiğiniz bir uygulama projesi hakkında yayımlanmış makale, kitap ya da kitap bölümü olmalı', ['MIMARLIK-UYGULAMA'], 1, donem: $donem, madde: $m(10)),
        11 => Kalip::veya('Özgün sanat eseri, tasarım veya yorum çalışmasıyla etkinlik', [
            Kalip::adet('Uluslararası jürili karma bir etkinlikte yer almış olmalısınız', ['SANAT-ULUSLARARASI-KARMA'], 1, donem: $donem, madde: $m(11)),
            Kalip::adet('Yurt dışında kamusal alanda kişisel sergi düzenlemiş olmalısınız', ['SANAT-KISISEL-YURTDISI'], 1, donem: $donem, madde: $m(11)),
            Kalip::adet('Ulusal jürili en az 2 karma etkinlikte yer almış olmalısınız', ['SANAT-ULUSAL-KARMA'], 2, donem: $donem, madde: $m(11)),
            Kalip::adet('Yurt içinde kamusal alanda kişisel sergi düzenlemiş olmalısınız', ['SANAT-KISISEL-YURTICI'], 1, donem: $donem, madde: $m(11)),
        ]),
        // Temel dal (arkeolojik kazı) cetvele giremedi; yalnızca yardımcı dal.
        12 => Kalip::veya('Beşinci ölçütü ya da altıncı ölçütün yardımcı dalını tekrar sağlamak', [
            Kalip::adet('ULAKBİM TR Dizin dergilerinde en az 2 araştırma makaleniz olmalı', ['TR-DIZIN-ARASTIRMA'], 2, donem: $donem, madde: $m(12)),
            Kalip::adet('Tanınmış ulusal yayınevinde en az 2 bilimsel kitabınız olmalı', ['ULUSAL-KITAP'], 2, donem: $donem, madde: $m(12)),
            Kalip::adet('Tanınmış ulusal yayınevinde en az 4 kitap bölümünüz olmalı', ['ULUSAL-BOLUM'], 4, donem: $donem, madde: $m(12)),
        ]),
        // Temel dal (h-indeksi ≥ 2) profil özelliği; yalnızca yardımcı dal.
        13 => Kalip::adet('Bilimsel yayınlarınıza en az 15 atıf yapılmış olmalı', ['ATIF-TUM'], 15, madde: $m(13)),
        // Yardımcı dal (başvuru aşamasındaki patent) cetvele giremedi.
        14 => Kalip::adet('Tescillenmiş en az 1 patentiniz, faydalı modeliniz veya endüstriyel tasarımınız olmalı', ['PATENT-TESCIL'], 1, donem: $donem, madde: $m(14)),
        16 => Kalip::veya('Bilimsel çalışmalar nedeniyle alınan ödül', [
            Kalip::adet('TÜBA, TÜBİTAK veya TÜSEB\'den en az 1 ödül almış olmalısınız', ['ODUL-ULUSLARARASI-KURUM'], 1, donem: $donem, madde: $m(16)),
            Kalip::adet('Saygın bir ulusal kurum ya da kuruluştan en az 1 ödül almış olmalısınız', ['ODUL-ULUSAL'], 1, donem: $donem, madde: $m(16)),
        ]),
        17 => Kalip::adet('Lisansüstü tez danışmanı, ikinci danışman ya da eş danışman olarak en az 2 tamamlanmış teziniz olmalı', ['TEZ-DANISMANLIK'], 2, donem: $donem, madde: $m(17)),
        18 => Kalip::veya('Ders yürütmek ya da BAP projesinde görev almak', [
            Kalip::adet('En az 1 lisans ya da ön lisans dersi yürütmüş olmalısınız', ['LISANS-DERS'], 1, donem: $donem, madde: $m(18)),
            Kalip::adet('BAP projesinde görev almış olmalısınız', ['BAP'], 1, donem: $donem, madde: $m(18)),
        ]),
    ];
};

/**
 * Tablo-2'nin değerlendirilebilen ölçüt satırları (doçent ve profesör).
 *
 * @param  array<string, mixed>|null  $donem
 * @return array<int, array<string, mixed>>
 */
$tablo2 = function (?array $donem): array {
    $m = fn (int $no): string => "Tablo-2 Ölçüt {$no}";

    return [
        1 => Kalip::veya('Q dergilerinde araştırma makaleleri', [
            Kalip::ve('En az biri Q1 olmak üzere iki araştırma makalesi (Q4 sayılmaz)', [
                Kalip::adet('Q1 kategorisindeki bir dergide en az 1 araştırma makaleniz olmalı', ['Q1-ARASTIRMA'], 1, donem: $donem, madde: $m(1)),
                Kalip::adet('Q1, Q2 veya Q3 dergilerinde toplam en az 2 araştırma makaleniz olmalı', ['Q1-Q3-ARASTIRMA'], 2, donem: $donem, madde: $m(1)),
            ]),
            Kalip::ve('En az ikisi Q2 olmak üzere dört araştırma makalesi (Q4 sayılmaz)', [
                Kalip::adet('Q2 kategorisindeki dergilerde en az 2 araştırma makaleniz olmalı', ['Q2-ARASTIRMA'], 2, donem: $donem, madde: $m(1)),
                Kalip::adet('Q1, Q2 veya Q3 dergilerinde toplam en az 4 araştırma makaleniz olmalı', ['Q1-Q3-ARASTIRMA'], 4, donem: $donem, madde: $m(1)),
            ]),
        ]),
        2 => Kalip::veya('İndeksli dergilerde araştırma makalesi', [
            Kalip::adet('SCI, SCI-Expanded, SSCI, AHCI veya Scopus dergilerinde en az 2 araştırma makaleniz olmalı', ['WOS-SCOPUS-ARASTIRMA'], 2, donem: $donem, madde: $m(2)),
            Kalip::adet('ESCI veya Scopus kapsamındaki dergilerde en az 2 araştırma makaleniz olmalı', ['ESCI-ARASTIRMA'], 2, donem: $donem, madde: $m(2)),
        ]),
        3 => Kalip::veya('Birinci veya ikinci ölçütü iki kez sağlamak', [
            Kalip::ve('En az ikisi Q1 olmak üzere dört araştırma makalesi', [
                Kalip::adet('Q1 kategorisindeki dergilerde en az 2 araştırma makaleniz olmalı', ['Q1-ARASTIRMA'], 2, donem: $donem, madde: $m(3)),
                Kalip::adet('Q1, Q2 veya Q3 dergilerinde toplam en az 4 araştırma makaleniz olmalı', ['Q1-Q3-ARASTIRMA'], 4, donem: $donem, madde: $m(3)),
            ]),
            Kalip::adet('SCI, SCI-Expanded, SSCI, AHCI veya Scopus dergilerinde en az 4 araştırma makaleniz olmalı', ['WOS-SCOPUS-ARASTIRMA'], 4, donem: $donem, madde: $m(3)),
            Kalip::adet('ESCI veya Scopus kapsamındaki dergilerde en az 4 araştırma makaleniz olmalı', ['ESCI-ARASTIRMA'], 4, donem: $donem, madde: $m(3)),
        ]),
        4 => Kalip::veya('Uzmanlık alanında kitap veya kitap editörlüğü', [
            Kalip::adet('Tanınmış uluslararası yayınevinde en az 1 kitabınız olmalı', ['ULUSLARARASI-KITAP'], 1, donem: $donem, madde: $m(4)),
            Kalip::adet('Tanınmış uluslararası yayınevinde en az 1 kitap editörlüğünüz olmalı', ['ULUSLARARASI-EDITORLUK'], 1, donem: $donem, madde: $m(4)),
            Kalip::adet('Tanınmış ulusal yayınevinde en az 2 kitabınız olmalı', ['ULUSAL-KITAP'], 2, donem: $donem, madde: $m(4)),
            Kalip::adet('Tanınmış ulusal yayınevinde en az 1 kitap editörlüğünüz olmalı', ['ULUSAL-EDITORLUK'], 1, donem: $donem, madde: $m(4)),
        ]),
        5 => Kalip::veya('Kitap bölümü yazarlığı', [
            Kalip::adet('Tanınmış yayınevlerince yayımlanmış kitaplarda en az 4 bölüm yazarlığınız olmalı', ['KITAP-BOLUM-TUM'], 4, donem: $donem, madde: $m(5)),
            Kalip::ve('Üç kitap bölümü ve üç ansiklopedi maddesi', [
                Kalip::adet('Tanınmış ulusal yayınevinde en az 3 kitap bölümünüz olmalı', ['ULUSAL-BOLUM'], 3, donem: $donem, madde: $m(5)),
                Kalip::adet('En az 3 ansiklopedi madde yazarlığınız olmalı', ['ANSIKLOPEDI'], 3, donem: $donem, madde: $m(5)),
            ]),
        ]),
        6 => Kalip::veya('Derleme, eleştiri ya da TR Dizin makalesi', [
            Kalip::adet('Uzmanlık alanınızda en az 5 derleme, mektup, eleştiri, katalog yazısı, kitap değerlendirme veya biyografiniz olmalı', ['DERLEME-ELESTIRI'], 5, donem: $donem, madde: $m(6)),
            Kalip::adet('ULAKBİM TR Dizin dergilerinde en az 2 araştırma makaleniz olmalı', ['TR-DIZIN-ARASTIRMA'], 2, donem: $donem, madde: $m(6)),
        ]),
        7 => Kalip::veya('Üniversite dışından kaynak sağlayan projede görev', [
            Kalip::adet('TÜBİTAK veya TÜSEB destekli bir projede yürütücü ya da araştırmacı olarak görev almış olmalısınız', ['BUYUK-PROJE'], 1, donem: $donem, madde: $m(7)),
            Kalip::adet('BAP ya da diğer ulusal kamu kurumu destekli bir projede görev almış olmalısınız', ['KUCUK-PROJE'], 1, donem: $donem, madde: $m(7)),
        ]),
        // Yardımcı dal (6 ay yurt dışı) kayıtta yok.
        8 => Kalip::adet('Avrupa Birliği ya da Erasmus+ projesinde yürütücü veya araştırmacı olarak görev almış olmalısınız', ['AB-PROJE'], 1, donem: $donem, madde: $m(8)),
        // Yardımcı dal (başvuru aşamasındaki patent) cetvele giremedi.
        9 => Kalip::adet('Tescillenmiş en az 1 patentiniz, faydalı modeliniz veya endüstriyel tasarımınız olmalı', ['PATENT-TESCIL'], 1, donem: $donem, madde: $m(9)),
        10 => Kalip::adet('Mimarlık, planlama ve tasarım alanında ürettiğiniz bir uygulama projesi hakkında yayımlanmış makale, kitap ya da kitap bölümü olmalı', ['MIMARLIK-UYGULAMA'], 1, donem: $donem, madde: $m(10)),
        11 => Kalip::veya('Özgün sanat eseri, tasarım veya yorum çalışmasıyla etkinlik', [
            Kalip::adet('Uluslararası jürili karma bir etkinlikte yer almış olmalısınız', ['SANAT-ULUSLARARASI-KARMA'], 1, donem: $donem, madde: $m(11)),
            Kalip::adet('Yurt dışında kamusal alanda kişisel sergi düzenlemiş olmalısınız', ['SANAT-KISISEL-YURTDISI'], 1, donem: $donem, madde: $m(11)),
            Kalip::adet('Ulusal jürili en az 2 karma etkinlikte yer almış olmalısınız', ['SANAT-ULUSAL-KARMA'], 2, donem: $donem, madde: $m(11)),
            Kalip::adet('Yurt içinde kamusal alanda kişisel sergi düzenlemiş olmalısınız', ['SANAT-KISISEL-YURTICI'], 1, donem: $donem, madde: $m(11)),
        ]),
        // Temel dal (arkeolojik kazı) cetvele giremedi; yardımcı dal "ikinci
        // ölçütün yardımcı dalını tekrar sağlamak" = dört ESCI makalesi.
        12 => Kalip::adet('ESCI veya Scopus kapsamındaki dergilerde en az 4 araştırma makaleniz olmalı', ['ESCI-ARASTIRMA'], 4, donem: $donem, madde: $m(12)),
        13 => Kalip::veya('Birinci ile on ikinci ölçütlerden birini iki kez sağlamak', [
            Kalip::adet('SCI, SCI-Expanded, SSCI, AHCI veya Scopus dergilerinde en az 4 araştırma makaleniz olmalı', ['WOS-SCOPUS-ARASTIRMA'], 4, donem: $donem, madde: $m(13)),
            Kalip::adet('ULAKBİM TR Dizin dergilerinde en az 4 araştırma makaleniz olmalı', ['TR-DIZIN-ARASTIRMA'], 4, donem: $donem, madde: $m(13)),
            Kalip::adet('Tanınmış yayınevlerince yayımlanmış kitaplarda en az 8 bölüm yazarlığınız olmalı', ['KITAP-BOLUM-TUM'], 8, donem: $donem, madde: $m(13)),
            Kalip::adet('TÜBİTAK veya TÜSEB destekli en az 2 projede görev almış olmalısınız', ['BUYUK-PROJE'], 2, donem: $donem, madde: $m(13)),
            Kalip::adet('BAP ya da diğer kamu kurumu destekli en az 2 projede görev almış olmalısınız', ['KUCUK-PROJE'], 2, donem: $donem, madde: $m(13)),
            Kalip::adet('Tescillenmiş en az 2 patentiniz, faydalı modeliniz veya endüstriyel tasarımınız olmalı', ['PATENT-TESCIL'], 2, donem: $donem, madde: $m(13)),
        ]),
        14 => Kalip::veya('Bilimsel etkinlikte bildiri', [
            Kalip::adet('Bildiri kitapçığı Web of Science ya da Scopus\'ta taranan bir uluslararası etkinlikte en az 1 bildiriniz olmalı', ['ULUSLARARASI-BILDIRI'], 1, donem: $donem, madde: $m(14)),
            Kalip::adet('Ulusal ya da uluslararası bilimsel etkinliklerde tam metin basılmış en az 3 sözlü bildiriniz olmalı', ['TAM-METIN-BILDIRI'], 3, donem: $donem, madde: $m(14)),
        ]),
        15 => Kalip::veya('Dergi editörlüğü, alan editörlüğü ya da hakemlik', [
            Kalip::adet('SCI, SCI-Expanded, SSCI veya AHCI kapsamındaki bir dergide editörlük ya da yayın kurulu üyeliğiniz olmalı', ['WOS-EDITORLUK'], 1, donem: $donem, madde: $m(15)),
            Kalip::adet('ESCI kapsamındaki dergilerde en az 2 alan editörlüğünüz olmalı', ['ESCI-EDITORLUK'], 2, donem: $donem, madde: $m(15)),
            Kalip::adet('En az 5 farklı makaleye hakemlik yapmış olmalısınız', ['HAKEMLIK'], 5, donem: $donem, madde: $m(15)),
            Kalip::adet('Ulusal bir kitapta editörlük ya da yardımcı editörlük yapmış olmalısınız', ['ULUSAL-EDITORLUK'], 1, donem: $donem, madde: $m(15)),
            Kalip::adet('ULAKBİM TR Dizin ya da diğer uluslararası dergilerde editörlük yapmış olmalısınız', ['DIGER-EDITORLUK'], 1, donem: $donem, madde: $m(15)),
        ]),
        // Temel dal (h-indeksi ≥ 3) profil özelliği. Madde 9/2 ve 10/2 bu
        // satırı dönem kısıtından muaf tutuyor: atıflar kariyerin tamamından.
        17 => Kalip::adet('Bilimsel yayınlarınıza en az 30 atıf yapılmış olmalı', ['ATIF-TUM'], 30, madde: $m(17)),
        18 => Kalip::adet('Lisansüstü tez danışmanı, ikinci danışman ya da eş danışman olarak en az 2 tamamlanmış teziniz olmalı', ['TEZ-DANISMANLIK'], 2, donem: $donem, madde: $m(18)),
        19 => Kalip::veya('Bilimsel çalışmalar nedeniyle alınan ödül', [
            Kalip::adet('TÜBA, TÜBİTAK veya TÜSEB\'den en az 1 ödül almış olmalısınız', ['ODUL-ULUSLARARASI-KURUM'], 1, donem: $donem, madde: $m(19)),
            Kalip::adet('Saygın bir ulusal kurum ya da kuruluştan en az 1 ödül almış olmalısınız', ['ODUL-ULUSAL'], 1, donem: $donem, madde: $m(19)),
        ]),
        20 => Kalip::veya('Ders vermek ya da BAP projesi yürütmek', [
            Kalip::adet('Ön lisans, lisans veya lisansüstü seviyede en az 6 ders vermiş olmalısınız', ['TUM-DERS'], 6, donem: $donem, madde: $m(20)),
            Kalip::adet('BAP projesinde yürütücü olarak görev almış olmalısınız', ['BAP-YURUTUCU'], 1, donem: $donem, madde: $m(20)),
        ]),
        // 21 ve 22'nin ders anketi ile idari görev süresi dalları kayıtta yok;
        // ikisinin de "uluslararası dergide bir araştırma makalesi" dalı kaldı.
        21 => Kalip::adet('Uluslararası dergilerde yayımlanmış en az 1 araştırma makaleniz olmalı', ['ULUSLARARASI-ARASTIRMA'], 1, donem: $donem, madde: $m(21)),
        22 => Kalip::adet('Uluslararası dergilerde yayımlanmış en az 1 araştırma makaleniz olmalı (kurum dışından gelen adaylar için idari görev şartının alternatifi)', ['ULUSLARARASI-ARASTIRMA'], 1, donem: $donem, madde: $m(22)),
    ];
};

$esikler = [];

// ══════════════════════════════════════════════════════════════════════════
// DOKTOR ÖĞRETİM ÜYESİ — İLK ATANMA (Madde 8/2)
// ══════════════════════════════════════════════════════════════════════════

$drOlcutler = $tablo1($DOKTORA);
$drOnUcluk = array_values(array_intersect_key($drOlcutler, array_flip(range(1, 13))));

/**
 * Dr. Öğr. Üyesi ilk atanma eşiği; iki alan grubu yalnızca ZORUNLU ölçütte
 * ayrışıyor (1 veya 1.a ↔ 2 veya 2.a).
 *
 * @param  list<string>  $alanlar
 * @return array<string, mixed>
 */
$drIlk = function (string $anahtar, array $alanlar, int $zorunlu, string $grupAdi, string $bent) use ($UNIVERSITE, $CETVEL, $drOlcutler, $drOnUcluk): array {
    return [
        'anahtar' => "bartin-dr-{$anahtar}",
        'aday_notu' => 'Bartın atamayı puana değil ÖLÇÜT SAYISINA bağlıyor. İlk atanmada '
            .($zorunlu === 1
                ? 'Q dergilerindeki araştırma makalesi ölçütü ZORUNLU'
                : 'indeksli dergilerdeki makale ölçütü ZORUNLU')
            .' ve bunun yanı sıra ilk on üç ölçütten en az dördünü sağlamış olmanız gerekiyor. '
            .'Merkezi yabancı dil sınavından en az 60 puan şart. Ölçütlerin doktora unvanınızdan '
            .'sonraki çalışmalarınızdan sağlanması aranıyor. '
            .'DİKKAT: yurt dışı araştırma süresi, ders değerlendirme anketi ve idari görev '
            .'süresi ölçütleri faaliyet kaydından hesaplanamadığı için burada hiç '
            .'listelenmiyor; o üç ölçütü sağlıyorsanız gerçek durumunuz buradakinden iyidir.',
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => "Madde 8/2-{$bent} ({$grupAdi}): Ölçüt {$zorunlu} veya {$zorunlu}.a zorunlu, "
            .'ayrıca 1-13 arasından en az 4 ölçüt. Puan barajı yok. Madde 8/1-c: YDS 60. '
            .'Değerlendirilemeyen ölçütler: 15, 19, 20.',
        'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna ilk atanma', [
            Kalip::yds(60),
            Kalip::beyan('Doktora ya da tıpta, diş hekimliğinde, eczacılıkta veya veteriner hekimlikte uzmanlık unvanına ya da bir sanat dalında yeterliğe sahip olmak', 'Madde 8/1-b'),
            $drOlcutler[$zorunlu],
            Kalip::kIle('İlk on üç ölçütten en az 4\'ünü sağlamalısınız', 4, $drOnUcluk),
        ]),
    ];
};

$esikler[] = $drIlk('ilk-sayisal', $SAYISAL_ALANLAR, 1,
    'Fen ve Matematik, Mühendislik, Sağlık, Ziraat-Orman-Su Ürünleri, Mimarlık-Planlama-Tasarım', 'a');
$esikler[] = $drIlk('ilk-sozel', $SOZEL_ALANLAR, 2,
    'Eğitim, Filoloji, İlahiyat, Sosyal-Beşeri-İdari, Spor, Güzel Sanatlar', 'b');

// ══════════════════════════════════════════════════════════════════════════
// DOKTOR ÖĞRETİM ÜYESİ — YENİDEN ATANMA (Madde 8/3, alan ayrımı yok)
// ══════════════════════════════════════════════════════════════════════════

$drYeniden = $tablo1($SON_ATAMA);
$drYenidenOnUcluk = array_values(array_intersect_key($drYeniden, array_flip(range(1, 13))));

$esikler[] = [
    'anahtar' => 'bartin-dr-yeniden',
    'aday_notu' => 'Yeniden atanmada bütün ölçütlerin SON ATAMANIZDAN SONRAKİ çalışmalarınızdan '
        .'sağlanması gerekiyor ve yabancı dil şartı aranmıyor. Hem Q dergilerindeki araştırma '
        .'makalesi hem de indeksli dergilerdeki makale ölçütü ZORUNLU; ayrıca en az dördü ilk '
        .'on üç ölçütten olmak üzere toplam altı ölçüt sağlanmalı. '
        .'DİKKAT: yurt dışı araştırma süresi, ders değerlendirme anketi ve idari görev süresi '
        .'ölçütleri faaliyet kaydından hesaplanamadığı için toplam altılık sayıma girmiyor; '
        .'o ölçütleri sağlıyorsanız gerçek durumunuz buradakinden iyidir.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => array_merge($SAYISAL_ALANLAR, $SOZEL_ALANLAR),
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 8/3: Ölçüt 1 veya 1.a İLE 2 veya 2.a zorunlu; en az 4\'ü 1-13 arasında '
        .'olmak üzere toplam 6 ölçüt. Alan ayrımı yok. Madde 8/1-c dil şartı yalnızca ilk '
        .'atamada. Değerlendirilemeyen ölçütler: 15, 19, 20 (toplam 6 sayımı 17 satır '
        .'üzerinden yapılıyor).',
    'sart' => Kalip::ve('Doktor Öğretim Üyeliğine yeniden atanma', [
        $drYeniden[1],
        $drYeniden[2],
        Kalip::kIle('İlk on üç ölçütten en az 4\'ünü sağlamalısınız', 4, $drYenidenOnUcluk),
        Kalip::kIle('Tüm ölçütlerden toplam en az 6\'sını sağlamalısınız', 6, array_values($drYeniden)),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// DOÇENT (Madde 9/2) ve PROFESÖR (Madde 10/2)
// ══════════════════════════════════════════════════════════════════════════

/**
 * Doçent ve profesör eşikleri; ikisi de Tablo-2'nin aynı ölçüt listesini
 * kullanıyor, yalnızca dönem ve profesörlüğün iki ek koşulu farklı.
 *
 * @param  list<string>  $alanlar
 * @param  list<array<string, mixed>>  $ekKosullar
 * @return array<string, mixed>
 */
$ustKadro = function (string $anahtar, string $kadro, array $alanlar, int $zorunlu,
    string $grupAdi, string $bent, ?array $donem, string $madde, array $ekKosullar,
    string $adayNotu, string $notlar,
) use ($UNIVERSITE, $CETVEL, $tablo2): array {
    $olcutler = $tablo2($donem);

    return [
        'anahtar' => "bartin-{$anahtar}",
        'aday_notu' => $adayNotu,
        'universite' => $UNIVERSITE,
        'kadro' => $kadro,
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => $notlar,
        'sart' => Kalip::ve($grupAdi, array_values(array_merge(
            [
                Kalip::yds(65),
                Kalip::beyan('Üniversitelerarası Kurul tarafından verilen doçentlik unvanına sahip olmak (yurt dışından alınan unvanda ÜAK denkliği)', $madde),
            ],
            $ekKosullar,
            [
                $olcutler[$zorunlu],
                Kalip::kIle('Tüm ölçütlerden en az 10\'unu sağlamalısınız', 10, array_values($olcutler)),
            ],
        ))),
    ];
};

$docentAdayNotu = fn (int $zorunlu): string => 'Bartın atamayı puana değil ÖLÇÜT SAYISINA '
    .'bağlıyor. Doçentlikte '
    .($zorunlu === 1 ? 'Q dergilerindeki araştırma makalesi ölçütü ZORUNLU' : 'indeksli dergilerdeki makale ölçütü ZORUNLU')
    .' ve bunun yanı sıra yirmi iki ölçütten en az onunu sağlamış olmanız gerekiyor. '
    .'Atıf ölçütü dışındaki bütün faaliyetlerin doktora unvanınızdan sonra yapılmış olması '
    .'aranıyor. Merkezi yabancı dil sınavından en az 65 puan şart. '
    .'DİKKAT: milli takım antrenörlüğü ve olimpik federasyon görevleri ölçütü faaliyet '
    .'kaydından hesaplanamadığı için sayıma girmiyor.';

$profesorAdayNotu = fn (int $zorunlu): string => 'Profesörlükte doçentlik ölçütlerinin AYNISI, '
    .'DOÇENTLİK UNVANINIZDAN SONRA bir kez daha sağlanmalı: '
    .($zorunlu === 1 ? 'Q dergilerindeki araştırma makalesi ölçütü ZORUNLU' : 'indeksli dergilerdeki makale ölçütü ZORUNLU')
    .' ve yirmi iki ölçütten en az onu. Ayrıca doçentlik unvanınızı aldıktan sonra en az beş '
    .'yıl ilgili bilim alanında çalışmış olmanız ve doçentlik sonrası bir BAŞLICA ESER '
    .'(Web of Science ya da Scopus dergisinde araştırma makalesi veya tanınmış uluslararası '
    .'yayınevinde kitap) sunmanız gerekiyor. Atıf ölçütü dönem kısıtından muaf. Merkezi '
    .'yabancı dil sınavından en az 65 puan şart. '
    .'DİKKAT: milli takım antrenörlüğü ve olimpik federasyon görevleri ölçütü faaliyet '
    .'kaydından hesaplanamadığı için sayıma girmiyor.';

foreach ([
    ['sayisal', $SAYISAL_ALANLAR, 1, 'Fen ve Matematik, Mühendislik, Sağlık, Ziraat-Orman-Su Ürünleri, Mimarlık-Planlama-Tasarım', 'a'],
    ['sozel', $SOZEL_ALANLAR, 2, 'Eğitim, Filoloji, İlahiyat, Sosyal-Beşeri-İdari, Spor, Güzel Sanatlar', 'b'],
] as [$ek, $alanlar, $zorunlu, $grupAdi, $bent]) {
    $esikler[] = $ustKadro(
        "docent-{$ek}", 'docentlik', $alanlar, $zorunlu,
        'Doçent kadrosuna atanma', $bent, $DOKTORA, 'Madde 9/1-b', [],
        $docentAdayNotu($zorunlu),
        "Madde 9/2-{$bent} ({$grupAdi}): Ölçüt {$zorunlu} veya {$zorunlu}.a zorunlu, ayrıca "
            .'1-22 arasından en az 10 ölçüt. Puan barajı yok. Madde 9/1-c: YDS 65. Ölçüt 17 '
            .'(atıf) dışındaki faaliyetler doktora sonrası. Değerlendirilemeyen ölçüt: 16.',
    );

    $esikler[] = $ustKadro(
        "profesor-{$ek}", 'profesorluk', $alanlar, $zorunlu,
        'Profesör kadrosuna yükseltilme', $bent, $DOCENTLIK, 'Madde 10/1-b',
        [
            Kalip::beyan('Doçentlik unvanını aldıktan sonra en az beş yıl süreyle açık bulunan profesörlük kadrosuyla ilgili bilim alanında çalışmış olmak', 'Madde 10/1-c'),
            Kalip::adet('Doçentlik unvanınızdan sonra en az 1 başlıca eseriniz (Web of Science ya da Scopus dergisinde araştırma makalesi veya tanınmış uluslararası yayınevinde kitap) olmalı', ['WOS-SCOPUS-ARASTIRMA', 'ULUSLARARASI-KITAP'], 1, donem: $DOCENTLIK, madde: 'Madde 10/1-e'),
        ],
        $profesorAdayNotu($zorunlu),
        "Madde 10/2 ({$grupAdi}): Tablo-2'nin doçentlik ölçütleri doçentlik unvanı sonrasında "
            .'bir kez daha; Ölçüt 17 (atıf) dönem kısıtından muaf. Madde 10/1-c: 5 yıl doçentlik. '
            .'Madde 10/1-e: doçentlik sonrası 1 başlıca eser. Madde 10/1-ç: YDS 65. '
            .'Değerlendirilemeyen ölçüt: 16.',
    );
}

return $esikler;
