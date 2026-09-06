<?php

/**
 * KAYNAK METİN TARAYICILARININ FİLTRE KURALLARI.
 *
 * Bu dosya cetvel verisini değil, veriyi DENETLERKEN kullanılan tarama
 * kurallarını koruyor. Denetim turları kaynak metinleri (pdf/ altındaki 179
 * yönerge) düzenli olarak yeniden tarıyor; her tur filtreyi sıfırdan yazarsa
 * aynı gürültüyü baştan ayıklamak gerekiyor. Kurallar burada, kanıtları da
 * korpustan alınmış GERÇEK satırlar olarak duruyor.
 *
 * ── SATIR PARANTEZİ TARAMASI (04.09.2026) ──
 * Amaç: tablo satırlarındaki parantezlerden, adayın BİRİMİNE / TEMEL ALANINA
 * / KADROSUNA kısıt koyanları bulmak. Böyle bir kısıt hiçbir sözlük etiketi
 * tarafından taşınamıyor; satır girilmişse kaynağın vermediği adaya da puan
 * verir (§0). Bulunan tek gerçek hata Ankara Hacı Bayram Veli'nin 15. bölümü
 * oldu ("Mimarlık, Planlama ve Tasarım Temel Alanı İçin", iki varyantta da
 * duruyordu).
 *
 * Ham tarama okunamaz: parantez binlerce satırda geçiyor. Filtre iki
 * aşamalı — önce satırın tablo satırı olması, sonra parantez içinin kısıt
 * deseni taşıması. Kalan 56 işaretin 26'sı üç GÜRÜLTÜ DESENİNDEN geliyordu:
 *
 *   BİRİM TÜRÜ LİSTESİ    "Müdür (Enstitü/Yüksekokul/Konservatuvar/MYO)"
 *       Parantez görevin KAPSAMINI sayıyor, adayı kısıtlamıyor. Tek başına
 *       Kafkas'ta 20 işaret üretiyordu.
 *   TANIM CÜMLESİ         "Doktor Öğretim Üyesi (Dr. Öğr. Üyesi): …"
 *       Parantez kısaltma; ardından iki nokta geliyor ve cümle yönergenin
 *       tanımlar bölümüne ait.
 *   AYNI ESERE ÖZGÜ SINIR "(Aynı kongrede yapılan görevlerden sadece biri)"
 *       Sayı sınırı, uygunluk kısıtı değil; motorun zaten tutamadığı
 *       "aynı esere özgü tavan" sınıfı (KONVANSIYONLAR §1).
 *
 * ── "VE/VEYA" TARAMASI (06.09.2026) ──
 * Amaç: tek bende sığdırılmış İKİ AYRI FAALİYETİ bulmak. İTÜ'nün M.5/M.6'sı
 * ("…etkinliklere tasarımlarıyla katılmak ve/veya … tasarım yarışmalarında
 * derece/mansiyon almak") ilk girişte yalnız birinci koluyla okunmuştu.
 *
 * Korpusta 848 ham "ve/veya" var; okunabilir hâle iki elemeyle geliyor:
 *
 *   NESİR                 Puan sütunu yok. Tanımlar maddesi ("ğ) Kitap
 *       Editörlüğü: … yurtiçi ve/veya yurtdışında…"), eşik nesri ("Kitap
 *       bölümü 'a ve/veya c' bendi kapsamında…"), atama usulü. 708 satır.
 *   NİTELİK AYRIMI        Ayraç iki faaliyeti değil, tek faaliyetin bir
 *       NİTELİĞİNİ ikiye ayırıyor: "bilim ve/veya sanat kurulu tarafından
 *       verilen ödül", "ulusal ve/veya uluslararası", "basılı ve/veya
 *       elektronik", "takımı ve/veya sporcusu". 91 satır.
 *
 * Kalan 49 satır 26 kaynağa dağılıyor ve elle okundu. İkinci kolu ayrı bir
 * karşılık gerektiren dördü `CetvelKaynakTest`'te donduruldu (İTÜ M.6y,
 * Iğdır 26.a.p/26.b.p, İstanbul Aydın B08, İstanbul Atlas 3.1.e). Geri
 * kalanda ikinci kol ya zaten ayrı satırda (Ordu'nun bestecilik/icra
 * ayrımı) ya da SÖZLÜKTE KARŞILIKSIZ: "oturum başkanlığı" ve "düzenleme
 * kurulu üyeliği" hiçbir etikete bağlanmıyor (Düzce 3.3/3.4, Aydın ADÜ
 * D1.1) ve "yurt dışında ders/seminer vermek" de öyle (Dicle F2, KOSTU
 * 18). Bunlar bu turun konusu değil; kendi etiket turlarını bekliyorlar.
 *
 * TARAMANIN KENDİSİNDEN ÇIKAN DERS: tarayıcı FİZİKSEL SATIRDA çalışırsa
 * kendisini doğuran hatayı bulamıyor. pdftotext satırı sarıyor ve İTÜ'de
 * ayracın iki kolu iki ayrı satıra düşüyor — ilk sürüm 19 işaret üretip
 * İTÜ'yü kaçırdı. Blok (±2 satır) üzerinde çalışınca 57 işaret ve İTÜ
 * içlerinde. **Bilinen hatayı bulmayan tarayıcı kalibre değildir.**
 */
/**
 * Satır, DİPNOT görünümünde mi?
 *
 * Ayırt edici işaret numaranın NOKTASIZ olması: tablo satırı "1." ile
 * başlar, dipnot "1 " ile. Yıldız ve hançer işaretleri de dipnot sayılır.
 */
function dipnotSatiri(string $satir): bool
{
    return (bool) preg_match('/^\s{0,10}(?:\(\d{1,2}\)|\d{1,2}(?![.)\d])|[*†‡•])\s{0,3}\S/u', $satir);
}

/**
 * "ve/veya" ayracının iki kolu. Blok verilmeli, fiziksel satır değil.
 *
 * @return array{0: string, 1: string}|null
 */
function veVeyaKollari(string $blok): ?array
{
    $parcalar = preg_split('#ve\s*/\s*veya|veya\s*/\s*ve#u', $blok, 2);

    return is_array($parcalar) && count($parcalar) === 2 ? [$parcalar[0], $parcalar[1]] : null;
}

/**
 * Kol bir FAALİYET mi anlatıyor, yoksa yalnız bir NİTELİK mi?
 *
 * Ayırt edici işaret Türkçenin kendi biçimbilimi: yönergeler faaliyeti ya
 * mastarla ("katılmak", "görev almak", "derece almak") ya da `-lık` türevi
 * eylem adıyla ("editörlük", "hakemlik", "başkanlığı", "üyeliği") yazar.
 * Nitelik kolları böyle bir baş taşımaz — "bilim", "Dünya", "çoklu ortam",
 * "karma ses". Sıfat listesi tutmaktan çok daha dayanıklı: liste her yeni
 * kaynakta uzuyordu, bu ek kapalı bir küme.
 */
function eylemBasi(string $kol): bool
{
    return (bool) preg_match(
        '/\w*(?:mak|mek|ması|mesi|lık|lik|luk|lük|lığı|liği|luğu|lüğü)\b/u',
        kucult($kol),
    );
}

/**
 * Bloğun "ve/veya" sınıfı: `nesir`, `nitelik` ya da `iki-kol`.
 *
 * `$puanSutunu`, blokta puan SÜTUNU (satır sonunda ya da en az iki boşlukla
 * ayrılmış sayı) bulunup bulunmadığıdır; puanlama satırı olmayan metin hiç
 * taranmaz — tanımlar maddesi ve eşik nesri ham işaretlerin çoğunu üretiyor.
 */
function veVeyaSinifi(string $blok, bool $puanSutunu): ?string
{
    $kollar = veVeyaKollari($blok);
    if ($kollar === null) {
        return null;
    }

    return match (true) {
        ! $puanSutunu => 'nesir',
        eylemBasi($kollar[0]) && eylemBasi($kollar[1]) => 'iki-kol',
        default => 'nitelik',
    };
}

/** Satır, tablo satırı görünümünde mi? */
function tabloSatiri(string $satir): bool
{
    return (bool) preg_match(
        '/^\s{0,14}(?:\d{1,2}(?:\.\d{1,2}){0,3}|[A-Za-zÇĞİÖŞÜçğıöşü])[.)]\s+\S/u',
        $satir,
    );
}

/**
 * TÜRKÇE KÜÇÜLTME: `İ` küçüldüğünde `i` olmalı, `I` ise `ı`.
 *
 * `preg_match` bayrağı `/i` bunu yapmıyor — `İ`nin Unicode küçüğü noktalı
 * `i̇` (iki kod noktası) ve desendeki `i` ile eşleşmiyor. Hacı Bayram
 * Veli'nin "Temel Alanı İçin" ibaresi bu yüzden ilk denemede filtreden
 * geçmedi; taramayı Türkçe metinde kuran herkesin düşeceği tuzak.
 */
function kucult(string $metin): string
{
    return mb_strtolower(str_replace(['İ', 'I'], ['i', 'ı'], $metin), 'UTF-8');
}

/** Parantez içi, adayın durumuna kısıt koyuyor gibi mi görünüyor? */
function kisitDeseni(string $parantez): bool
{
    return (bool) preg_match(
        '/fakülte|konservatuvar|yüksekokul|meslek yüksek|enstitü'
        .'|için geçerli|yalnızca|sadece|dışındaki(?:ler)? için'
        .'|temel alan[ıi]? için|alanlar[ıi] için|bölümü için|programı için'
        .'|profesör|doçent|dr\.? ?öğr|kadrosu için/u',
        kucult($parantez),
    );
}

/**
 * Kısıt deseni tutan bir parantez GÜRÜLTÜ mü? Değilse null döner.
 */
function parantezGurultusu(string $satir, string $parantez): ?string
{
    $p = kucult($parantez);

    $kisitFiili = '/için|yalnız|sadece|hariç|geçerli|kayd[ıi]yla|dışında/u';
    $birimTuru = '/enstitü|yüksekokul|konservatuvar|meslek yüksek|fakülte|bölüm|myo|program/u';

    // a) Birim TÜRÜ listesi: eğik çizgiyle ayrılmış birim adları, kısıt fiili yok.
    if (str_contains($parantez, '/') && preg_match($birimTuru, $p) && ! preg_match($kisitFiili, $p)) {
        return 'birim-turu-listesi';
    }

    // b) Tanım cümlesi: parantezden hemen sonra iki nokta geliyor.
    if (preg_match('/'.preg_quote('('.$parantez.')', '/').'\s*:/u', $satir)) {
        return 'tanim-cumlesi';
    }

    // c) Aynı esere özgü SAYI sınırı; uygunluk kısıtı değil.
    if (preg_match('/(aynı|her bir|başına).*(sadece|yalnız)|(sadece|yalnız)\s*\d*\s*(biri|bölüm|adet|tane)/u', $p)) {
        return 'ayni-esere-sinir';
    }

    // d) BELGE ADI: parantez bir evrakı adlandırıyor, adayı kısıtlamıyor.
    //    Dipnot taramasında ortaya çıktı ("Belgelemek kaydıyla (Doçentlik
    //    unvanı başvuru beyannamesi) …"): içinde kadro sözcüğü geçtiği için
    //    kısıt desenine takılıyor.
    if (preg_match('/beyanname|belgesi|belgeleri|\bform\b|dilekçe|raporu|sertifika|karar[ıi]/u', $p)
        && ! preg_match($kisitFiili, $p)) {
        return 'belge-adi';
    }

    return null;
}

/**
 * @return list<string> Kısıt taşıyan parantezler (gürültü elenmiş hâliyle)
 */
function satirdanKisitlar(string $satir): array
{
    if (! tabloSatiri($satir) && ! dipnotSatiri($satir)) {
        return [];
    }

    preg_match_all('/\(([^()]{4,160})\)/u', $satir, $eslesme);

    return array_values(array_filter(
        $eslesme[1],
        fn (string $p): bool => kisitDeseni($p) && parantezGurultusu($satir, $p) === null,
    ));
}

test('birim TÜRÜ listesi kısıt sayılmıyor', function (string $satir) {
    expect(satirdanKisitlar($satir))->toBe([]);
})->with([
    // Kafkas: aynı satır dokuz kadro tablosunda tekrarlanıyor, tek başına
    // yirmi işaret üretiyordu. Parantez müdürlüğün KAPSAMINI sayıyor.
    'a) Müdür (Enstitü/Yüksekokul/Konservatuvar/Meslek Yüksekokulu)                    15',
    'b) Dekan veya Müdür (Enstitü/Fakülte/Yüksekokul/Konservatuvar/Meslek Yüksekokulu) Yardımcısı   10',
    // Uşak: değişim programı koordinatörlüğünün yapılabileceği birimler.
    'd) ERASMUS, Mevlana ve Farabi, Bologna birim (fakülte/ enstitü/ yüksekokul/ MYO/ Bölüm)   6',
]);

test('tanım cümlesindeki kısaltma kısıt sayılmıyor', function (string $satir) {
    expect(satirdanKisitlar($satir))->toBe([]);
})->with([
    // Sivas Cumhuriyet, yönergenin "Tanımlar" maddesi.
    'd) Doktor Öğretim Üyesi (Dr. Öğr. Üyesi): Doktora çalışmalarını başarı ile tamamlamış; tıpta, diş',
]);

test('aynı esere özgü sayı sınırı kısıt sayılmıyor', function (string $satir) {
    expect(satirdanKisitlar($satir))->toBe([]);
})->with([
    // Trakya ve Iğdır: ikisi de ADET sınırı. Motor bunları zaten tutamıyor
    // ("aynı esere özgü tavan"), uygunlukla ilgileri yok.
    'd. Kongre Görevleri (Aynı kongrede yapılan görevlerden sadece biri puanlamaya dâhil edilir)',
    'b) Alanında yazılmış bir bölüm yazarlığı (Sadece 1 bölüm dikkate alınır)                       100',
]);

test('gerçek uygunluk kısıtları filtreden geçiyor', function (string $satir, string $beklenen) {
    expect(satirdanKisitlar($satir))->toContain($beklenen);
})->with([
    // Bu turun tek gerçek hatası; düzeltmesi hbv-2026-mimarlik varyantı.
    ['15. Yarışma, Proje ve Yazılım (Mimarlık, Planlama ve Tasarım Temel Alanı İçin)',
        'Mimarlık, Planlama ve Tasarım Temel Alanı İçin'],
    // Bir önceki turda düzeltilen OMÜ 15. bölümü.
    ['15. GÖRSEL ETKİNLİKLER (İletişim Fakültesi için geçerlidir)                       PUAN',
        'İletişim Fakültesi için geçerlidir'],
    // Zaten doğru girilmiş olanlar; filtre bunları da yakalayabilmeli.
    ['12. Yayın, Yapım, Tasarım ve Eserlere Yönelik Faaliyetler (sadece İletişim Bilimleri Alanı için)',
        'sadece İletişim Bilimleri Alanı için'],
    ['2. Lisansüstü Tezlerden Üretilmiş Yayın (Yalnızca Doktor Öğretim Üyesi Atamalarında Geçerlidir)',
        'Yalnızca Doktor Öğretim Üyesi Atamalarında Geçerlidir'],
    ['ç) Makale Çevirisi (Sadece Sosyal Bilimler için geçerlidir) 5',
        'Sadece Sosyal Bilimler için geçerlidir'],
    ['h. Uluslararası atölye çalışmaları ve çalıştay düzenlemek. (Güzel sanat dalları ve Mimarlık Fakültesi kriterleri için geçerlidir.)   30',
        'Güzel sanat dalları ve Mimarlık Fakültesi kriterleri için geçerlidir.'],
]);

test('belge adı kısıt sayılmıyor', function (string $satir) {
    expect(satirdanKisitlar($satir))->toBe([]);
})->with([
    // Selçuk ve Kafkas'ın aynı dipnotu: parantez bir EVRAKI adlandırıyor,
    // "Doçentlik" sözcüğü yüzünden kısıt desenine takılıyordu.
    '* Belgelemek kaydıyla (Doçentlik unvanı başvuru beyannamesi) Üniversitelerarası Kurula yapılan başvuru',
]);

/**
 * DİPNOT TARAMASI (04.09.2026).
 *
 * Aynı filtre dipnotlara uygulandı: numarası NOKTASIZ olan ya da yıldız/
 * hançer taşıyan satırlar. Beş işaret çıktı ve YENİ HATA ÇIKMADI — dördü
 * zaten doğru girilmişti (İzmir Kavram'ın 15. bölümü yalnız `-gsf`
 * varyantında, Sinop'un dil muafiyeti `veya` düğümünde, Nişantaşı'nın
 * "40 puanı doçentlik sonrası" koşulu ayrı düğümde), biri de yeni bir
 * gürültü sınıfıydı (belge adı).
 */
test('dipnot satırı da taranıyor', function () {
    // Tablo satırı değil ama dipnot: numara noktasız.
    expect(satirdanKisitlar('15- Sanat ve tasarım etkinlikleri (sadece güzel sanatlar temel alanı için)'))
        ->toContain('sadece güzel sanatlar temel alanı için');

    expect(satirdanKisitlar('(2) Tüm atamalar için (Dr. Öğretim Üyesi yeniden atamaları hariç) yabancı dil şartı'))
        ->toContain('Dr. Öğretim Üyesi yeniden atamaları hariç');
});

test('tablo satırı olmayan metin taranmıyor', function () {
    // Yönerge gövdesindeki düz cümleler ve tablo başlıkları sıralayıcıyla
    // başlamadığı için taramaya girmiyor; girseydi yüzlerce yanlış pozitif
    // üretirlerdi.
    expect(satirdanKisitlar('Bu yönerge, Güzel Sanatlar Fakültesi için ayrı ölçüt belirlemez.'))->toBe([])
        ->and(satirdanKisitlar('     (Sadece Devlet Konservatuvarı için geçerlidir)'))->toBe([]);
});

test('nitelik ayrımı iki kol sayılmıyor', function (string $blok) {
    expect(veVeyaSinifi($blok, puanSutunu: true))->toBe('nitelik');
})->with([
    // Ağrı 36.7.4 — ayraç ödülü VEREN kurulu niteliyor, ödülü ikiye bölmüyor.
    ['36.7.4. Uluslararası kongre, kurultay, sempozyum, konferans ve festival gibi etkinliklerin bilim ve/veya sanat kurulu tarafından verilen ödül   30'],
    // Bayburt 11.1.ı — "takımı ve/veya sporcusu": tek faaliyet, iki özne.
    ['11.1.ı) Üniversitelerarası Dünya ve/veya Avrupa Şampiyonalarında takımı ve/veya sporcusu ilk üç dereceye girmiş olmak   30'],
    // Atatürk 01.02.01 — dersin niteliği.
    ['Web tabanlı erişime açık çoklu ortam ve/veya etkileşimli açık ders hazırlama   5'],
    // Sakarya UBÜ 7.8 — kaydın türü.
    ['Ulusal boyutta performansa dayalı yayımlanmış karma ses ve/veya görüntü kaydı bulunmak   50'],
]);

test('puan sütunu olmayan metin taranmıyor', function (string $blok) {
    expect(veVeyaSinifi($blok, puanSutunu: false))->toBe('nesir');
})->with([
    // FSMVÜ ğ) — tanımlar maddesi; "yurtiçi ve/veya yurtdışında" zaten nitelik
    // ama sütun eleği tek başına da yetiyor.
    ['ğ) Kitap Editörlüğü: ISBN numarası almış, kitapların içinde yer alan metinleri seçen, hakemler ve/veya yayınevinin ilgili editörü ile birlikte çalışan kişiyi,'],
    // Selçuk — eşik nesri; "a ve/veya c" BENT kodu, faaliyet değil.
    ['b) Başvuru Şartları Tablosu’nda yer alan “Kitap” bölümü “a ve/veya c” bendi kapsamında tek yazarlı olmak koşulu ile en az 25 puan almış olmak,'],
    // Dokuz Eylül 1.13.4 — atama usulü.
    ['1.13.4 Rektör, bilimsel ve/veya sanatsal değerlendirme jüri üyelerinin görüşlerine dayanarak, Üniversite Yönetim Kurulu’nun görüşünü de aldıktan sonra atamayı yapar.'],
]);

test('iki ayrı faaliyet taşıyan satır filtreden geçiyor', function (string $blok) {
    expect(veVeyaSinifi($blok, puanSutunu: true))->toBe('iki-kol');
})->with([
    // İTÜ M.5 — taramayı doğuran satır: katılım + yarışma derecesi.
    ['M.5 Uluslararası sempozyum, festival, çalıştay, bienal, gibi etkinliklere tasarımlarıyla katılmak ve/veya uluslararası kuruluşlar tarafından düzenlenen   15   tasarım yarışmalarında derece/mansiyon almak.'],
    // Düzce e) — düzenlemede görev + oturum başkanlığı.
    ['e. Uluslararası kurs ve yaz okulu düzenlenmesinde görev almak ve/veya oturum   5   başkanlığı yapmak'],
    // Dicle F2 — davetli konuşmacılık + yurt dışında ders verme.
    ['F 2 davetli konuşmacı olmak ve/veya yurt dışında ders, seminer,   15   konferans vermek'],
]);

/**
 * TARAYICI KENDİ HATASINI BULABİLİYOR MU: pdftotext İTÜ'nün M.5 satırını
 * ayracın ortasından sarıyor ve ikinci kol ("tasarım yarışmalarında
 * derece/mansiyon almak") bir sonraki fiziksel satıra düşüyor. Satır
 * bazlı tarayıcı bu yüzden kendi gerekçesini kaçırıyordu.
 */
test('kollar satır sarmasıyla ayrılmışsa blok gerekiyor', function () {
    $satirlar = [
        'M.5 Uluslararası sempozyum, festival, çalıştay, bienal, gibi etkinliklere',
        'tasarımlarıyla katılmak ve/veya uluslararası kuruluşlar tarafından düzenlenen               15',
        'tasarım yarışmalarında derece/mansiyon almak.',
    ];

    // Ayracın bulunduğu FİZİKSEL satırda ikinci kol yok: yarışma sözcüğü yok.
    expect(veVeyaKollari($satirlar[1])[1])->not->toContain('yarışma');

    // ±1 satırlık blokta iki kol da görünüyor.
    expect(veVeyaKollari(implode(' ', $satirlar))[1])->toContain('yarışma');
});
