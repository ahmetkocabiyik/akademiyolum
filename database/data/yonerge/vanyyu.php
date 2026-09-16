<?php

/**
 * VAN YÜZÜNCÜ YIL ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve
 * Atanma Yönergesi
 * Kaynak: pdf/17537010282.vanyuzuncuyiluniverstesi.pdf (15 sayfa;
 * Senato 21/09/2018-2018/27-1, değişiklik 11/03/2019-2019/5-13; YÖK
 * onayıyla yürürlüğe girer.)
 *
 * ── PUAN YOK, SEÇMELİ KRİTER SAYISI VAR ──
 * Yönerge puan cetveli kullanmıyor. Her kadro için birkaç ZORUNLU koşul
 * ve bir SEÇMELİ KRİTER listesi (EK-1, EK-2, EK-3) var; adayın listeden
 * belli sayıda kriteri sağlaması gerekiyor:
 *   doktor öğretim üyeliği ilk atanma   EK-1'den en az 6 kriter
 *   doktor öğretim üyeliği yeniden      EK-1'den son 3 yılda 4 kriter
 *   doçentlik                           EK-2'den en az 15 kriter
 *   profesörlük                         EK-3'ten en az 20 kriter
 *                                       (en az 5'i doçentlik sonrası)
 * Koşullar `k_ile` düğümüyle yazıldı. Kriterlerin bir bölümü faaliyet
 * kaydından sayılabiliyor (`adet`), bir bölümü metriğe çevrildi
 * (h-indeksi, yurt dışı süresi, yabancı dil puanı), geri kalanı BEYAN
 * olarak soruluyor. Beyan düğümleri motorda "belirsiz" döner; aday
 * hangi kriteri sağladığını başvuru dosyasında belgeler.
 *
 * ── EŞİK BÜTÜN TEMEL ALANLARA AYNI ──
 * Yönerge temel alan ayrımı yapmıyor; koşullar bütün alanlarda aynı.
 * Sanat ve spor alanlarına özgü kriterler seçmeli listelerin içinde yer
 * alıyor.
 *
 * ── PROFESÖRLÜKTEKİ "EN AZ 5'İ DOÇENTLİK SONRASI" ──
 * MADDE 7(5)(e) 20 kriterin en az beşinin doçent unvanından sonra
 * gerçekleştirilmiş olmasını istiyor. Aynı altmış kriteri ikinci kez
 * dönem kısıtıyla yazmak yerine bu ek koşul BEYAN olarak soruldu.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 7(2)(e), (3)(d), (4)(e)-(f), (5)(f)-(g): yabancı uyruklu
 *       sözleşmeli öğretim elemanlarına ilişkin usul hükümleri.
 *   MADDE 11: 2547 sayılı Kanunun 50/d maddesi kapsamındaki araştırma
 *       görevlilerinin %20 kotasıyla başvurusunda EK-4'ten ayrıca iki
 *       kriter istenmesi — bu kota ayrı bir kadro türü değil, ilk
 *       atanma koşullarının üstüne binen bir ek; profil adayın kota
 *       durumunu tutmuyor. EK-4 kriterleri aday notunda özetlendi.
 *   MADDE 13: acil öğretim üyesi ihtiyacında Üniversite Yönetim Kurulu
 *       kararıyla zorunlu veya seçmeli koşulların aranmayabilmesi.
 *   MADDE 8: yağmacı dergi ve sempozyum yasağı.
 *   Geçici Madde 1: 2019 yılı sonuna kadar yabancı dil puanının 55
 *       olarak uygulanması (süre dolmuştur).
 *   Açıklamalar 1: "1.1., 2.1. ve 3.1. dışındaki her kriterden en fazla
 *       üç etkinlik sayılır" ve Açıklamalar 2: "bir eser aynı kategoride
 *       yalnız bir kez kullanılır" kuralları.
 *   Açıklamalar 7: profesörlükte "başlıca eser"in alana göre türünün
 *       belirlenmesi.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/vanyyu-2019.php
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Van Yüzüncü Yıl Üniversitesi';
$CETVEL = 'vanyyu-2019';
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_UC_YIL = Kalip::sonYil(3);

$TUM = ['egitim', 'fen', 'filoloji', 'guzel_sanatlar', 'hukuk', 'ilahiyat', 'mimarlik',
    'muhendislik', 'saglik', 'sosyal', 'spor', 'ziraat'];

/**
 * Seçmeli kriter satırını şart düğümüne çevirir.
 *
 * $spec biçimleri:
 *   null                          → beyan
 *   ['g' => [...], 's' => n]      → adet
 *   ['m' => 'h_indeksi', 's' => n] → metrik
 *
 * @param  array<string, mixed>|null  $spec
 * @param  array<string, string|int>|null  $donem
 * @return array<string, mixed>
 */
$kriter = function (string $kod, string $metin, ?array $spec, ?array $donem): array {
    if ($spec === null) {
        return Kalip::beyan($metin, $kod);
    }

    if (isset($spec['m'])) {
        return Kalip::metrik($metin, (string) $spec['m'], (int) $spec['s'], $donem);
    }

    /** @var list<string> $gruplar */
    $gruplar = $spec['g'];

    return Kalip::adet($metin, $gruplar, (int) $spec['s'], donem: $donem, madde: $kod);
};

/**
 * Sanat ve spor alanlarına özgü, kayıt alanlarıyla eşleşmeyen kriterler
 * beyan olarak soruluyor. Ortak kriter gövdesi üç ek için de aynı
 * yazıldı; ekler arasındaki sayısal farklar (atıf sayısı, h-indeksi,
 * hakemlik sayısı, tez sayısı) satır satır işlendi.
 *
 * @return list<array{0: string, 1: string, 2: array<string, mixed>|null}>
 */
$ortakKriterler = function (string $onek): array {
    return [
        ["{$onek}.web", 'Bilimsel ya da mesleki amaçlı bir web sayfası tasarımına sahip olmak', null],
        ["{$onek}.kazi", 'Bilimsel nitelikli bir kazıya katılmak ya da kazı yönetmek', null],
        ["{$onek}.tonmayster", 'Tonmaysterlik ya da ses sistemi projesi ekibinde yer almak', null],
        ["{$onek}.arsiv", 'Kamu kurum veya kuruluşlarında muhafaza edilen eserlerin ya da belgelerin çözümlenmesini ve yayımlanmasını sağlamak', null],
        ["{$onek}.milli", 'Bireysel ya da takım sporlarında milli sporcu olmak', null],
        ["{$onek}.antrenor", 'Milli takımlarda en az 6 ay antrenörlük yapmak', null],
        ["{$onek}.lig", 'Yurt içi ya da yurt dışı liglerde sporcu olmak', null],
        ["{$onek}.hakem", 'Ulusal ya da uluslararası müsabakalarda spor hakemliği yapmak', null],
        ["{$onek}.organizasyon", 'Ulusal ya da uluslararası spor müsabakalarında organizasyon komitesinin yönetim kademesinde görev yapmak', null],
        ["{$onek}.rekreasyon", 'Üniversite, il ya da bölgesel düzeyde kendi branşınızda spor organizasyonu veya rekreasyonel faaliyet düzenlemek', null],
        ["{$onek}.menajer", 'İdari ya da teknik menajerlik yapmak', null],
        ["{$onek}.sporodul", 'Ulusal ya da uluslararası spor yarışma veya müsabakalarında ödül almak', null],
    ];
};

// ══════════════════════════════════════════════════════════════════════════
// EK-1: DOKTOR ÖĞRETİM ÜYESİ SEÇMELİ KRİTERLERİ
// ══════════════════════════════════════════════════════════════════════════

$EK1 = [
    ['1.1', 'Uluslararası atıf indeksleri ya da ulusal/uluslararası alan indeksleri kapsamındaki dergilerde tam metinli araştırma makalesi yayımlamış olmak veya tanınmış sanat merkezlerinde özgün sanatsal etkinlik yapmış olmak', ['g' => ['INDEKSLI-MAKALE', 'SANAT-ETKINLIK'], 's' => 1]],
    ['1.2', 'Doktora, sanatta yeterlik ya da uzmanlık tezinizden üretilmiş bir makaleyi birinci isim veya sorumlu yazar olarak yayımlamış olmak', ['g' => ['TEZ-YAYINI'], 's' => 1, 'y' => 'baslica']],
    ['1.3', 'Bilimsel çalışmalarınıza, kendi atıflarınız dışında en az 5 atıf yapılmış olmak', ['g' => ['ATIF'], 's' => 5]],
    ['1.4', 'Merkezi yabancı dil sınavından en az 80 puan almış olmak', ['m' => 'yds', 's' => 80]],
    ['1.5', 'En az bir araştırma veya uygulama projesinde yürütücü olarak görev yapmış olmak', ['g' => ['PROJE-YURUTUCU'], 's' => 1]],
    ['1.6', 'Üniversite dışından kaynak sağlanarak yürütülen bir araştırma projesinde görev almış olmak', ['g' => ['PROJE-DIS'], 's' => 1]],
    ['1.7', 'Bilimsel etkinlikler için yurt dışındaki bir araştırma merkezine ziyaret amacıyla en az bir ay süreli burs kazanmış olmak', ['g' => ['BURS'], 's' => 1]],
    ['1.8', 'Ulusal ya da uluslararası süreli hakemli dergilerde özgün makaleye sahip olmak veya sanat alanında özgün sanat eseri üretmiş olmak', ['g' => ['HAKEMLI-MAKALE', 'SANAT-ESER'], 's' => 1]],
    ['1.9', 'Bilimsel kitaplarda bölüm yazarlığı ya da kitap editörlüğü yapmış olmak', ['g' => ['KITAP-BOLUM', 'EDITOR-KITAP'], 's' => 1]],
    ['1.10', 'Ulusal ya da uluslararası bilimsel toplantılarda sözlü veya poster sunum yapmış olmak', ['g' => ['BILDIRI'], 's' => 1]],
    ['1.11', 'Ulusal ya da uluslararası bilim, bilim teşvik, proje teşvik veya araştırma ödülü almış olmak', ['g' => ['ODUL'], 's' => 1]],
    ['1.12', 'Ulusal ya da uluslararası öğretim elemanı değişim programlarına katılmış olmak', ['g' => ['DEGISIM'], 's' => 1]],
    ['1.13', 'Bir sözlük çalışmasında görev almış ya da ansiklopedilerde madde yazarlığı yapmış olmak', ['g' => ['ANSIKLOPEDI'], 's' => 1]],
    ['1.14', 'Üniversitenin web sayfası üzerinden erişilen ders materyali ya da uzaktan eğitim materyali geliştirmiş olmak', null],
    ['1.15', 'Kurum ve kuruluşlar için bilimsel yöntemlerle hazırlanmış, geniş ve yenilikçi bir mesleki rapor yazmış olmak', null],
    ['1.16', 'Bir proje kapsamında ilgili bakanlıklar ya da uluslararası meslek örgütleri için yapılan çalışmalara katılmış olmak', null],
    ['1.17', 'Bir bilimsel etkinliğin düzenleme veya bilimsel değerlendirme komitesinde yer almış olmak ya da bildiriler kitabının editörlüğünü yapmış olmak', ['g' => ['ETKINLIK-KOMITE'], 's' => 1]],
    ['1.18', 'Yurt dışındaki bir üniversite ya da enstitüde en az üç ay davetli misafir öğretim elemanı veya araştırmacı olarak bulunmuş olmak', ['m' => 'yurtdisi_ay', 's' => 3]],
    ['1.19', 'Ulusal ya da uluslararası bilimsel toplantılarda sunum ödüllerinden birini almış olmak', null],
    ['1.20', 'Bilimsel bir kitabı ya da kitap bölümünü çevirip yayımlamış olmak', ['g' => ['CEVIRI'], 's' => 1]],
    ['1.21', 'Popüler bilim, sanat ya da eğitim dergilerinde en az iki telif veya çeviri yazı yayımlamış olmak', ['g' => ['TOPLUMSAL'], 's' => 2]],
    ['1.22', 'Yabancı dilde eğitim yapılan programlarda ders veriyor olmak', ['g' => ['YABANCI-DILDE-DERS'], 's' => 1]],
    ['1.23', 'Üniversite Senatosunca verilen bilim, teşvik veya sanat ödülü almış olmak', null],
    ['1.24', 'Ulusal ya da uluslararası bir patent almış olmak', ['g' => ['PATENT'], 's' => 1]],
    ['1.25', 'Bilimsel dergilerde yayımlanan en az iki makalede hakemlik yapmış olmak', ['g' => ['HAKEMLIK'], 's' => 2]],
    ['1.26', 'Üniversite tarafından düzenlenen sertifikalı eğitim programlarında eğitici olarak görev almış olmak', null],
    ['1.27', 'Kültür, sanat, sosyal ya da bilimsel yarışmalara katılan topluluklara akademik danışmanlık yapmış olmak', null],
    ['1.28', 'Ayrımcılıkla mücadele, çevre duyarlılığı, insan hakları ve sosyal adalet gibi konularda topluma yönelik sosyal sorumluluk çalışması ya da projesinde yer almak', ['g' => ['TOPLUMSAL'], 's' => 1]],
    ['1.29', 'Hakemli bir bilimsel derginin editörlüğünü, editör yardımcılığını veya bölüm editörlüğünü yapmış olmak ya da yayın kurulunda bulunmak', ['g' => ['EDITOR', 'YAYIN-KURULU'], 's' => 1]],
    ['1.30', 'Ulusal ya da uluslararası nitelikli sanatsal etkinliklere en az bir katılımınız olmak', ['g' => ['SANAT-ETKINLIK'], 's' => 1]],
    ['1.31', 'Ulusal ya da uluslararası nitelikli en az bir proje veya sanatsal etkinlik jürisinde görev almak', ['g' => ['SANAT-JURI'], 's' => 1]],
    ['1.32', 'Ulusal ya da uluslararası tasarım alanında üretime girmiş çalışma veya koleksiyon sahibi olmak', ['g' => ['SANAT-TASARIM'], 's' => 1]],
    ['1.33', 'Televizyon programları, dizi, bilim kurgu ya da belgesellerde yönetmen, görüntü yönetmeni, kameraman, metin yazarı veya senaryo yazarı olarak yer almak', ['g' => ['EKRAN'], 's' => 1]],
    ['1.34', 'Bilimsel toplantı düzenlemek, sempozyum başkanlığı ya da sekretarya görevini yürütmek', ['g' => ['ETKINLIK-KOMITE'], 's' => 1]],
    ['1.35', 'Alanınızla ilgili panel, konferans, seminer, kurs, açık oturum ve söyleşi gibi etkinliklerde davetli konuşmacı ya da panelist olarak görev almak', ['g' => ['DAVETLI'], 's' => 1]],
    ['1.36', 'Ulusal ya da uluslararası bir değerlendirme kurulunda veya ödül jürisinde yer almak', null],
    ['1.37', 'Ulusal ya da uluslararası nitelikli görsel, sanatsal veya işitsel eserlerin oluşum ya da sunum kadrolarında yer almak', ['g' => ['SANAT'], 's' => 1]],
    ['1.38', 'Kamusal veya özel alanlarda daimî olarak sergilenen ya da başkaları tarafından satın alınan özgün sanat eserlerine sahip olmak', ['g' => ['SANAT-SATIN'], 's' => 1]],
    ['1.39', 'Yurt içi ya da yurt dışı tarihî eserlerin restorasyon veya konservasyon çalışmalarını üstlenmek ya da çalışma ekibinde yer almak', ['g' => ['SANAT-KORUMA'], 's' => 1]],
];

// ══════════════════════════════════════════════════════════════════════════
// EK-2: DOÇENTLİK SEÇMELİ KRİTERLERİ
// ══════════════════════════════════════════════════════════════════════════

$EK2 = [
    ['2.1', 'Uluslararası atıf indeksleri ya da ulusal/uluslararası alan indeksleri kapsamındaki dergilerde tam metinli araştırma makalesi yayımlamış olmak veya tanınmış sanat merkezlerinde özgün sanatsal etkinlik yapmış olmak', ['g' => ['INDEKSLI-MAKALE', 'SANAT-ETKINLIK'], 's' => 1]],
    ['2.2', 'Ulusal ya da uluslararası süreli hakemli dergilerde özgün makaleye sahip olmak veya sanat alanında özgün sanat eseri üretmiş olmak', ['g' => ['HAKEMLI-MAKALE', 'SANAT-ESER'], 's' => 1]],
    ['2.3', 'Merkezi yabancı dil sınavından en az 80 puan almış olmak', ['m' => 'yds', 's' => 80]],
    ['2.4', 'Ulusal ya da uluslararası yayınevlerince yayımlanmış kitap veya kitap bölümü yazmış olmak', ['g' => ['KITAP'], 's' => 1]],
    ['2.5', 'Hakemli dergilerde en az iki olgu sunumu, teknik not, özet, mektup, eleştiri veya yorum türü yazı yayımlamış olmak', null],
    ['2.6', 'Ulusal ya da uluslararası bir bilimsel toplantıda iki sözlü veya poster sunum yapmış olmak', ['g' => ['BILDIRI'], 's' => 2]],
    ['2.7', 'Bir araştırma ya da uygulama projesinde yürütücü olarak yer almış olmak', ['g' => ['PROJE-YURUTUCU'], 's' => 1]],
    ['2.8', 'Kendi atıflarınız dışında çalışmalarınıza en az 10 atıf yapılmış olmak', ['g' => ['ATIF'], 's' => 10]],
    ['2.9', 'Web of Science ya da Scopus veri tabanına göre h indeksinizin en az 4 olması', ['m' => 'h_indeksi', 's' => 4]],
    ['2.10', 'Yurt dışındaki bir yükseköğretim kurumu ya da araştırma merkezinde bir defada en az üç ay çalışmış olmak', ['m' => 'yurtdisi_ay', 's' => 3]],
    ['2.11', 'Bilimsel bir kitabı ya da kitap bölümünü çevirip yayımlamış olmak', ['g' => ['CEVIRI'], 's' => 1]],
    ['2.12', 'Bilimsel bir laboratuvar uygulama kılavuzunu Türkçeye çevirerek yayımlamış olmak', null],
    ['2.13', 'Hakemli bir derginin editörlüğünü, bölüm editörlüğünü, editör yardımcılığını ya da misafir editörlüğünü yapmış olmak', ['g' => ['EDITOR'], 's' => 1]],
    ['2.14', 'Ulusal ya da uluslararası hakemli bir derginin yayın kurulunda bulunmak', ['g' => ['YAYIN-KURULU'], 's' => 1]],
    ['2.15', 'Ulusal ya da uluslararası hakemli dergilerde en az beş hakemlik yapmış olmak', ['g' => ['HAKEMLIK'], 's' => 5]],
    ['2.16', 'Ulusal ya da uluslararası yayınevlerince yayımlanmış bilimsel bir kitapta editörlük yapmış olmak', ['g' => ['EDITOR-KITAP'], 's' => 1]],
    ['2.17', 'Ulusal ya da uluslararası bilim, bilim teşvik, proje teşvik veya araştırma ödülü almış olmak', ['g' => ['ODUL'], 's' => 1]],
    ['2.18', 'Bilimsel etkinlikler için en az üç ay süreli yurt dışı bursu kazanmış olmak', ['g' => ['BURS'], 's' => 1]],
    ['2.19', 'Ulusal ya da uluslararası öğretim elemanı değişim programlarına katılmış olmak', ['g' => ['DEGISIM'], 's' => 1]],
    ['2.20', 'Ulusal ya da uluslararası nitelikte bilimsel etkinliklerde en az bir kez davetli konuşmacı olarak yer almak', ['g' => ['DAVETLI'], 's' => 1]],
    ['2.21', 'Eş danışmanlıklar dâhil en az bir doktora, sanatta yeterlik ya da tıpta uzmanlık tezini yönetmiş olmak', ['g' => ['TEZ-DOKTORA'], 's' => 1]],
    ['2.22', 'En az iki tezli yüksek lisans çalışması yönetmiş olmak', ['g' => ['TEZ-YL'], 's' => 2]],
    ['2.23', 'Bir bilimsel etkinliğin düzenleme ya da bilimsel değerlendirme komitesinde yer almış olmak veya bildiriler kitabının editörlüğünü yapmış olmak', ['g' => ['ETKINLIK-KOMITE'], 's' => 1]],
    ['2.24', 'Yeni bir dersi ya da laboratuvar dersini ön lisans, lisans veya lisansüstü düzeyde eğitime kazandırmak', null],
    ['2.25', 'Türkçe programlara ilave olarak yabancı dilde gerçekleştirilen programlarda da ders vermek', ['g' => ['YABANCI-DILDE-DERS'], 's' => 1]],
    ['2.26', 'Yayının yapıldığı yılda etki faktörü en az 2 olan bir dergide yayın yapmış olmak', null],
    ['2.27', 'Uluslararası yayınevlerince yayımlanmış bilimsel kitaplarda yayınlarınıza atıf yapılmış olmak', ['g' => ['ATIF-KITAP'], 's' => 1]],
    ['2.28', 'Tescil edilmiş bilimsel bir faydalı model ya da patente sahip olmak', ['g' => ['PATENT'], 's' => 1]],
    ['2.29', 'Ulusal ya da uluslararası bir standardın hazırlanmasında görev almış olmak', null],
    ['2.30', 'Tek ya da çok dilli basılmış bir sözlük veya ansiklopedi çalışmasında görev almış olmak', ['g' => ['ANSIKLOPEDI'], 's' => 1]],
    ['2.31', 'Üniversitenin web sayfası üzerinden erişilen ders materyali ya da uzaktan eğitim materyali geliştirmiş olmak', null],
    ['2.32', 'Üç doktora tez izleme komitesinde görev almış olmak', ['g' => ['TEZ-JURI'], 's' => 3]],
    ['2.33', 'Tez izleme komitesi dışında üç lisansüstü ya da uzmanlık tezi jürisinde görev almış olmak', ['g' => ['TEZ-JURI'], 's' => 3]],
    ['2.34', 'Ulusal ya da uluslararası bilimsel toplantılarda sunum ödüllerinden birini almış olmak', null],
    ['2.35', 'Ulusal ya da uluslararası bir sertifikalı eğitim kursuna eğitici olarak katılmış olmak', null],
    ['2.36', 'Bir proje kapsamında ilgili bakanlıklar ya da uluslararası meslek örgütleri için yapılan taramalara veya poliklinik çalışmalarına katılmış olmak', null],
    ['2.37', 'Ayrımcılıkla mücadele, çevre duyarlılığı, insan hakları ve sosyal adalet gibi konularda topluma yönelik sosyal sorumluluk çalışması ya da projesinde yer almak', ['g' => ['TOPLUMSAL'], 's' => 1]],
    ['2.38', 'Ulusal ya da uluslararası nitelikli sanatsal etkinliklere en az bir katılımda bulunmak', ['g' => ['SANAT-ETKINLIK'], 's' => 1]],
    ['2.39', 'Ulusal ya da uluslararası nitelikli en az bir proje veya sanatsal etkinlik jürisinde görev almak', ['g' => ['SANAT-JURI'], 's' => 1]],
    ['2.40', 'Ulusal ya da uluslararası sanat ve tasarım ödülü almak', ['g' => ['ODUL'], 's' => 1]],
    ['2.41', 'Ulusal ya da uluslararası tasarım alanında üretime girmiş çalışma veya koleksiyon sahibi olmak', ['g' => ['SANAT-TASARIM'], 's' => 1]],
    ['2.42', 'Televizyon programları, dizi, bilim kurgu ya da belgesellerde yönetmen, görüntü yönetmeni, kameraman, metin yazarı veya senaryo yazarı olarak yer almak', ['g' => ['EKRAN'], 's' => 1]],
    ['2.43', 'Alanınızla ilgili konferans vermek', ['g' => ['DAVETLI'], 's' => 1]],
    ['2.44', 'Alanınızla ilgili panel, konferans, seminer, kurs, açık oturum ve söyleşi gibi etkinliklerde davetli konuşmacı ya da panelist olarak görev almak', ['g' => ['DAVETLI'], 's' => 1]],
    ['2.45', 'Ulusal ya da uluslararası bir değerlendirme kurulunda veya ödül jürisinde yer almak', null],
    ['2.46', 'Ulusal ya da uluslararası nitelikli görsel, sanatsal veya işitsel eserlerin oluşum ya da sunum kadrolarında yer almak', ['g' => ['SANAT'], 's' => 1]],
    ['2.47', 'Kamusal veya özel alanlarda daimî olarak sergilenen ya da başkaları tarafından satın alınan özgün sanat eserlerine sahip olmak', ['g' => ['SANAT-SATIN'], 's' => 1]],
    ['2.48', 'Yurt içi ya da yurt dışı tarihî eserlerin restorasyon veya konservasyon çalışmalarını üstlenmek ya da çalışma ekibinde yer almak', ['g' => ['SANAT-KORUMA'], 's' => 1]],
];

// ══════════════════════════════════════════════════════════════════════════
// EK-3: PROFESÖRLÜK SEÇMELİ KRİTERLERİ
// ══════════════════════════════════════════════════════════════════════════

$EK3 = [
    ['3.1', 'Uluslararası atıf indeksleri ya da ulusal/uluslararası alan indeksleri kapsamındaki dergilerde tam metinli araştırma makalesi yayımlamış olmak veya tanınmış sanat merkezlerinde özgün sanatsal etkinlik yapmış olmak', ['g' => ['INDEKSLI-MAKALE', 'SANAT-ETKINLIK'], 's' => 1]],
    ['3.2', 'Merkezi yabancı dil sınavından en az 85 puan almış olmak', ['m' => 'yds', 's' => 85]],
    ['3.3', 'Ulusal ya da uluslararası yayınevlerince yayımlanmış kitap veya kitap bölümü yazmış olmak', ['g' => ['KITAP'], 's' => 1]],
    ['3.4', 'Hakemli dergilerde en az iki olgu sunumu, teknik not, özet, mektup, eleştiri veya yorum türü yazı yayımlamış olmak', null],
    ['3.5', 'Zorunlu koşula ek olarak en az iki ulusal ya da uluslararası bilimsel toplantıda sözlü veya poster sunum yapmış olmak', ['g' => ['BILDIRI'], 's' => 2]],
    ['3.6', 'En az bir araştırma veya uygulama projesinde yürütücü olarak yer almış olmak', ['g' => ['PROJE-YURUTUCU'], 's' => 1]],
    ['3.7', 'En az iki araştırma veya uygulama projesinde yardımcı araştırmacı olarak yer almış olmak', ['g' => ['PROJE-ARASTIRMACI'], 's' => 2]],
    ['3.8', 'Kendi atıflarınız dışında çalışmalarınıza toplam 30 atıf yapılmış olmak', ['g' => ['ATIF'], 's' => 30]],
    ['3.9', 'Web of Science ya da Scopus veri tabanına göre h indeksinizin en az 5 olması', ['m' => 'h_indeksi', 's' => 5]],
    ['3.10', 'Türkçeye çevirdiğiniz bilimsel bir kitap, kitap bölümü ya da laboratuvar uygulama kılavuzu yayımlamış olmak', ['g' => ['CEVIRI'], 's' => 1]],
    ['3.11', 'Hakemli bir derginin editörlüğünü, editör yardımcılığını ya da misafir editörlüğünü yapmış olmak', ['g' => ['EDITOR'], 's' => 1]],
    ['3.12', 'Ulusal ya da uluslararası hakemli bir derginin yayın kurulunda bulunmak', ['g' => ['YAYIN-KURULU'], 's' => 1]],
    ['3.13', 'Uluslararası hakemli dergilerde en az iki kez hakemlik yapmış olmak', ['g' => ['HAKEMLIK'], 's' => 2]],
    ['3.14', 'Ulusal hakemli dergilerde en az dört kez hakemlik yapmış olmak', ['g' => ['HAKEMLIK'], 's' => 4]],
    ['3.15', 'Ulusal ya da uluslararası yayınevlerince yayımlanmış bilimsel bir kitapta editörlük yapmış olmak', ['g' => ['EDITOR-KITAP'], 's' => 1]],
    ['3.16', 'Ulusal ya da uluslararası bilim, bilim teşvik, proje teşvik veya araştırma ödülü almış olmak', ['g' => ['ODUL'], 's' => 1]],
    ['3.17', 'Bilimsel etkinlikler için en az üç ay süreli burs kazanmış olmak', ['g' => ['BURS'], 's' => 1]],
    ['3.18', 'Ulusal ya da uluslararası öğretim elemanı değişim programlarına katılmış olmak', ['g' => ['DEGISIM'], 's' => 1]],
    ['3.19', 'Ulusal ya da uluslararası bir sertifikalı eğitim kursuna eğitici olarak katılmış olmak', null],
    ['3.20', 'En az bir kez uluslararası nitelikteki bilimsel etkinliklere davetli konuşmacı olarak katılmış olmak', ['g' => ['DAVETLI'], 's' => 1]],
    ['3.21', 'Eş danışmanlıklar dâhil en az bir doktora ya da tıpta uzmanlık tezi yönetmiş olmak', ['g' => ['TEZ-DOKTORA'], 's' => 1]],
    ['3.22', 'Yurt dışındaki bir yükseköğretim kurumu ya da araştırma merkezinde bir defada en az üç ay çalışmış olmak', ['m' => 'yurtdisi_ay', 's' => 3]],
    ['3.23', 'İki yüksek lisans tezi yönetmiş olmak', ['g' => ['TEZ-YL'], 's' => 2]],
    ['3.24', 'Bir bilimsel etkinliğin düzenleme ya da bilimsel değerlendirme komitesinde yer almış olmak veya bildiriler kitabının editörlüğünü yapmış olmak', ['g' => ['ETKINLIK-KOMITE'], 's' => 1]],
    ['3.25', 'Yeni bir dersi ya da laboratuvar uygulamasını ön lisans, lisans veya lisansüstü düzeyde eğitime kazandırmış olmak', null],
    ['3.26', 'Türkçe programlara ilave olarak yabancı dilde gerçekleştirilen programlarda ders vermek', ['g' => ['YABANCI-DILDE-DERS'], 's' => 1]],
    ['3.27', 'Üç doktora tez izleme komitesinde görev almış olmak', ['g' => ['TEZ-JURI'], 's' => 3]],
    ['3.28', 'Tez izleme komitesi dışında üç lisansüstü ya da uzmanlık tezi jürisinde görev almış olmak', ['g' => ['TEZ-JURI'], 's' => 3]],
    ['3.29', 'Yayının yapıldığı yıla ait etki faktörü 2 ve üzeri olan dergilerde yayın yapmış olmak', null],
    ['3.30', 'Uluslararası bilimsel kitaplarda atıf almış olmak', ['g' => ['ATIF-KITAP'], 's' => 1]],
    ['3.31', 'Tescil edilmiş bilimsel bir faydalı model ya da patente sahip olmak', ['g' => ['PATENT'], 's' => 1]],
    ['3.32', 'Ulusal ya da uluslararası bir standardın hazırlanmasında görev almış olmak', null],
    ['3.33', 'Tek veya çok dilli bir sözlük ya da ansiklopedi çalışmasında görev almış olmak', ['g' => ['ANSIKLOPEDI'], 's' => 1]],
    ['3.34', 'Bir proje kapsamında ilgili bakanlıklar ya da uluslararası meslek örgütleri için yapılan taramalara veya poliklinik çalışmalarına katılmış olmak', null],
    ['3.35', 'Ulusal ya da uluslararası nitelikli sanatsal etkinliklere en az bir katılımda bulunmak', ['g' => ['SANAT-ETKINLIK'], 's' => 1]],
    ['3.36', 'Ulusal ya da uluslararası nitelikli en az bir proje veya sanatsal etkinlik jürisinde görev almak', ['g' => ['SANAT-JURI'], 's' => 1]],
    ['3.37', 'Ayrımcılıkla mücadele, çevre duyarlılığı, insan hakları ve sosyal adalet gibi konularda topluma yönelik sosyal sorumluluk çalışması ya da projesinde yer almak', ['g' => ['TOPLUMSAL'], 's' => 1]],
    ['3.38', 'Ulusal ya da uluslararası sanat ve tasarım ödülü almak', ['g' => ['ODUL'], 's' => 1]],
    ['3.39', 'Ulusal ya da uluslararası tasarım alanında üretime girmiş çalışma veya koleksiyon sahibi olmak', ['g' => ['SANAT-TASARIM'], 's' => 1]],
    ['3.40', 'Televizyon programları, dizi, bilim kurgu ya da belgesellerde yönetmen, görüntü yönetmeni, kameraman, metin yazarı veya senaryo yazarı olarak yer almak', ['g' => ['EKRAN'], 's' => 1]],
    ['3.44', 'Ulusal ya da uluslararası bir değerlendirme kurulunda veya ödül jürisinde yer almak', null],
    ['3.45', 'Alanınızla ilgili konferanslar vermek', ['g' => ['DAVETLI'], 's' => 1]],
    ['3.47', 'Ulusal ya da uluslararası nitelikli görsel, sanatsal veya işitsel eserlerin oluşum ya da sunum kadrolarında yer almak', ['g' => ['SANAT'], 's' => 1]],
    ['3.48', 'Kamusal veya özel alanlarda daimî olarak sergilenen ya da başkaları tarafından satın alınan özgün sanat eserlerine sahip olmak', ['g' => ['SANAT-SATIN'], 's' => 1]],
    ['3.49', 'Yurt içi ya da yurt dışı tarihî eserlerin restorasyon veya konservasyon çalışmalarını üstlenmek ya da çalışma ekibinde yer almak', ['g' => ['SANAT-KORUMA'], 's' => 1]],
    ['3.60', 'En az iki yıl 60 puan ve üstü YÖK akademik teşvik puanı almış olmak', null],
];

/**
 * Kriter listesini şart düğümlerine çevirir.
 *
 * @param  list<array{0: string, 1: string, 2: array<string, mixed>|null}>  $liste
 * @param  array<string, string|int>|null  $donem
 * @return list<array<string, mixed>>
 */
$dugumler = function (array $liste, ?array $donem) use ($kriter): array {
    return array_values(array_map(
        fn (array $satir): array => $kriter($satir[0], $satir[1], $satir[2], $donem),
        $liste,
    ));
};

$EK1_TAM = [...$EK1, ...$ortakKriterler('1')];
$EK2_TAM = [...$EK2, ...$ortakKriterler('2')];
$EK3_TAM = [...$EK3, ...$ortakKriterler('3')];

$NOT_SECMELI = ' Seçmeli kriterlerin bir bölümü kayıt alanlarıyla eşleşmediği için "beyan" '
    .'olarak soruluyor; bunları belgeleyip başvuru dosyanızda hangi kriteri sağladığınızı '
    .'belirtmeniz gerekiyor. Yönergenin "makale, atıf ve kitap dışındaki her kriterden en fazla üç '
    .'etkinlik sayılır" ve "bir eser aynı kategoride yalnız bir kez kullanılır" kuralları motorda '
    .'yok; sağladığınız kriter sayısı burada olduğundan fazla görünebilir.';

$esikler = [];

$esikler[] = [
    'anahtar' => 'vanyyu-dr',
    'aday_notu' => 'Doktor öğretim üyesi kadrosuna İLK ATANMA koşulları. Atamalar üç yıl süreyle '
        .'yapılıyor. Zorunlu koşullara ek olarak yönergenin seçmeli kriter listesinden en az 6 kriteri '
        .'sağlamanız gerekiyor. 2547 sayılı Kanunun 50/d maddesi kapsamında araştırma görevlisi '
        .'olarak çalışıp %20 kotasıyla başvuruyorsanız yönergenin ek listesinden ayrıca iki '
        .'kriter daha '
        .'isteniyor (indeksli dergide bir makale; hakemli dergide bir makale ve iki bildiri; '
        .'üniversite dışı bir projede görev; iki BAP projesi; patent; WOS h-indeksi 2; dergi '
        .'editörlüğü; sanat alanında sergi veya bildiri).'.$NOT_SECMELI,
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => $TUM,
    'cetvel' => $CETVEL,
    'notlar' => 'MADDE 7(2): (a) beş seçenekten biri, (b) bildiri sayısı, (c) yabancı dil 60, '
        .'(d) EK-1\'den en az 6 kriter.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna ilk atanma', [
        Kalip::yds(60),
        Kalip::veya('Yayın koşullarından en az biri', [
            Kalip::adet(
                'SCI, SCI-Expanded, SSCI, AHCI ya da ESCI indeksleri tarafından taranan '
                .'dergilerde en az 1 tam metinli araştırma makalesi yayımlamış olmak',
                ['SCI-MAKALE'], 1, madde: '7-2-a-1',
            ),
            Kalip::adet(
                'Tanınmış sanat merkezlerinde gerçekleştirilmiş en az 1 özgün sanatsal etkinlik '
                .'yapmış olmak',
                ['SANAT-ETKINLIK'], 1, madde: '7-2-a-2',
            ),
            Kalip::adet(
                'Alan indeksleri tarafından taranan dergilerde en az 2 tam metinli araştırma '
                .'makalesi yayımlamış olmak',
                ['ALAN-INDEKS'], 2, madde: '7-2-a-3',
            ),
            Kalip::adet(
                'Sanat alanında en az 2 özgün sanat eseri üretiminde bulunmuş olmak',
                ['SANAT-ESER'], 2, madde: '7-2-a-4',
            ),
            Kalip::adet(
                'Ulusal ya da uluslararası süreli hakemli dergilerde yayımlanmış en az 3 özgün '
                .'araştırma makalesine sahip olmak',
                ['HAKEMLI-MAKALE'], 3, madde: '7-2-a-5',
            ),
        ]),
        Kalip::veya('Bildiri koşullarından en az biri', [
            Kalip::adet(
                'En az iki farklı bilimsel kongrede toplam 3 sözlü bildiri sunmuş olmak',
                ['BILDIRI-SOZLU'], 3, madde: '7-2-b',
            ),
            Kalip::adet(
                'En az iki farklı bilimsel kongrede toplam 5 poster bildiri sunmuş olmak',
                ['BILDIRI-POSTER'], 5, madde: '7-2-b',
            ),
        ]),
        Kalip::kIle('Yönergenin seçmeli kriterlerinden en az 6 tanesini sağlamak', 6,
            $dugumler($EK1_TAM, null)),
    ]),
];

$esikler[] = [
    'anahtar' => 'vanyyu-dr-yeniden',
    'aday_notu' => 'Doktor öğretim üyesi kadrosuna YENİDEN ATANMA koşulları. Bütün koşullar son '
        .'atanma tarihinizden sonraki çalışmalardan sağlanmalı; seçmeli kriterlerde ise son 3 '
        .'yıl esas alınıyor. Yeniden atamalar da üç yıl süreyle yapılıyor.'.$NOT_SECMELI,
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => $TUM,
    'cetvel' => $CETVEL,
    'notlar' => 'MADDE 7(3): (a) biri birinci isim olmak üzere 2 özgün araştırma makalesi ya da '
        .'2 özgün sanat eseri, (b) her atanma döneminde 2 sözlü veya poster sunum, (c) EK-1\'den '
        .'son 3 yılda en az 4 kriter.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna yeniden atanma', [
        Kalip::veya('Yayın koşullarından en az biri', [
            Kalip::ve('Makale seçeneği', [
                Kalip::adet(
                    'Son atanma tarihinizden sonra kendi bilim alanınızda en az 2 özgün araştırma '
                    .'makalesine sahip olmak',
                    ['HAKEMLI-MAKALE'], 2, donem: $SON_ATAMA, madde: '7-3-a',
                ),
                Kalip::adet(
                    'Bu makalelerden en az birinde birinci isim olmak',
                    ['HAKEMLI-MAKALE'], 1, 'ilk', $SON_ATAMA, madde: '7-3-a',
                ),
            ]),
            Kalip::adet(
                'Son atanma tarihinizden sonra özgün sanat alanında 2 özgün sanat eseri '
                .'üretiminde bulunmuş olmak',
                ['SANAT-ESER'], 2, donem: $SON_ATAMA, madde: '7-3-a',
            ),
        ]),
        Kalip::adet(
            'Son atanma tarihinizden sonra ulusal ya da uluslararası bir bilimsel toplantıda en '
            .'az 2 sözlü veya poster sunum yapmış olmak',
            ['BILDIRI'], 2, donem: $SON_ATAMA, madde: '7-3-b',
        ),
        Kalip::kIle('Yönergenin seçmeli kriterlerinden son üç yıl içinde en az 4 tanesini sağlamak', 4,
            $dugumler($EK1_TAM, $SON_UC_YIL)),
    ]),
];

$esikler[] = [
    'anahtar' => 'vanyyu-docentlik',
    'aday_notu' => 'Doçent kadrosuna atanma koşulları: ÜAK doçentlik belgesi, merkezi yabancı '
        .'dil sınavından en az 65 puan, devlet yükseköğretim kurumlarında en az iki yıl tam '
        .'zamanlı öğretim üyeliği ve yönergenin seçmeli kriter listesinden en az 15 kriter. Bilim '
        .'alanınız bir yabancı dille ilgiliyse dil puanınızı ikinci bir yabancı dilden almanız '
        .'gerekiyor.'.$NOT_SECMELI,
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => $TUM,
    'cetvel' => $CETVEL,
    'notlar' => 'MADDE 7(4): doçentlik belgesi, yabancı dil 65, en az 2 yıl kadrolu öğretim '
        .'üyeliği, EK-2\'den en az 15 kriter.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma', [
        Kalip::beyan(
            'Üniversitelerarası Kurul tarafından verilen ya da denkliği kabul edilen doçentlik '
            .'belgesine sahip olmak',
            '7-4-a',
        ),
        Kalip::yds(65),
        Kalip::beyan(
            'Devlet yükseköğretim kurumlarında en az iki yıl tam zamanlı (kadrolu) öğretim üyesi '
            .'olarak çalışmış olmak',
            '7-4-c',
        ),
        Kalip::kIle('Yönergenin seçmeli kriterlerinden en az 15 tanesini sağlamak', 15,
            $dugumler($EK2_TAM, null)),
    ]),
];

$esikler[] = [
    'anahtar' => 'vanyyu-profesorluk',
    'aday_notu' => 'Profesör kadrosuna atanma koşulları: doçent unvanını aldıktan sonraki '
        .'dönemde, doçent olduğunuz dönemde yürürlükte olan ÜAK doçentlik asgari kriterlerini '
        .'yeniden sağlamak (bu koşul ÜAK\'ın kendi ölçütlerine bağlı olduğu için motor '
        .'hesaplayamıyor), devlet üniversitelerinde en az beş yıl tam zamanlı öğretim üyeliği, '
        .'merkezi yabancı dil sınavından en az 65 puan, doçentlikten sonra en az iki farklı '
        .'toplantıda toplam 5 sunum ve yönergenin seçmeli kriter listesinden en az 20 kriter. Bu 20 '
        .'kriterin en az beşini doçent unvanını aldıktan sonra gerçekleştirmiş olmanız '
        .'gerekiyor; motor bu ek koşulu ayrı bir beyan olarak soruyor.'.$NOT_SECMELI,
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => $TUM,
    'cetvel' => $CETVEL,
    'notlar' => 'MADDE 7(5): (a) ÜAK doçentlik kriterlerinin tekrar sağlanması '
        .'(hesaplanamıyor), (b) 5 yıl kadrolu öğretim üyeliği, (c) yabancı dil 65, (d) '
        .'doçentlik sonrası 5 sunum, (e) EK-3\'ten en az 20 kriter (en az 5\'i doçentlik '
        .'sonrası — beyan).',
    'sart' => Kalip::ve('Profesör kadrosuna atanma', [
        Kalip::hesaplanamiyor(
            'Doçent unvanını aldıktan sonraki dönemde, doçent olduğunuz dönemde yürürlükte olan '
            .'ÜAK doçentliğe yükseltilme asgari kriterlerini yeniden sağlamış olmak',
            '7-5-a',
        ),
        Kalip::beyan(
            'Devlet üniversitelerinde en az beş yıl tam zamanlı (kadrolu) öğretim üyesi olarak '
            .'çalışmış olmak',
            '7-5-b',
        ),
        Kalip::yds(65),
        Kalip::adet(
            'Doçent unvanını aldıktan sonra en az iki farklı bilimsel toplantıda toplam 5 poster '
            .'ya da sözlü sunum yapmış olmak',
            ['BILDIRI'], 5, donem: $DOCENTLIK, madde: '7-5-d',
        ),
        Kalip::kIle('Yönergenin seçmeli kriterlerinden en az 20 tanesini sağlamak', 20,
            $dugumler($EK3_TAM, null)),
        Kalip::beyan(
            'Sağladığınız seçmeli kriterlerden en az beşini doçent unvanını aldıktan sonra '
            .'gerçekleştirmiş olmak',
            '7-5-e',
        ),
    ]),
];

return $esikler;
