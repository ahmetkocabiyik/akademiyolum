<?php

/**
 * MEF ÜNİVERSİTESİ — Dr. Öğr. Üyeliği, Doçentlik ve Profesörlük Yükseltme ve
 * Atama Ölçütleri
 * Kaynak: pdf/17537102972.mefuniversitesi.pdf
 *
 * BELGEDE TARİH YOK; cetvel dosyasının adındaki 2024 PDF'in oluşturma
 * tarihinden (23/12/2024).
 *
 * ── KORPUSUN EN KATMANLI YÖNERGESİ: BEŞ FAKÜLTE, HER BİRİ KENDİ KURALIYLA ──
 * Tek bir puan tablosu var ama fakülteler tablonun üstüne kendi tavanlarını,
 * kendi "başlıca eser" tanımlarını ve kendi alt koşullarını koyuyor. Beş
 * fakülte × üç kadro = 15 eşik, 15 ayrı cetvel varyantı (gerekçe cetvel
 * dosyasında).
 *
 *   Mühendislik Fakültesi                    → muhendislik
 *   Mimarlık Fakültesi                       → mimarlik
 *   Hukuk Fakültesi                          → hukuk
 *   İktisadi, İdari ve Sosyal Bilimler Fak.  → sosyal
 *   Eğitim Fakültesi                         → egitim
 *
 * ANILMAYAN ALANLARA EŞİK YAZILMADI: Fen, Sağlık, İlahiyat, Filoloji, Güzel
 * Sanatlar, Ziraat ve Spor. MEF'in bu fakülteleri yok, yönerge de onları
 * anmıyor.
 *
 * ── PUAN İSKELETİ HER FAKÜLTEDE AYNI ──
 *   Dr. Öğr. Üyesi  puan barajı YOK, yalnızca başlıca eser sayısı
 *   Doçent          en az 100 puan
 *   Profesör        en az 200 puan, 100'ü doçentlik sonrası
 * Fakülteleri ayıran şey barajın kendisi değil, üstüne binen sayı koşulları.
 *
 * ── "BAŞLICA ESER" DÖRT YOLDAN BİRİYLE SAĞLANIYOR, BİRİ ÖLÇÜLEBİLİYOR ──
 * Her fakülte başlıca eseri önce bir KAYNAK KÜMESİYLE tanımlıyor (hangi
 * bölümlerden sayılacağı), sonra dört alternatif nitelikten en az birini
 * istiyor:
 *   (i)   yazar sayısı koşulu (fakülteye göre değişiyor),
 *   (ii)  yayının adayın lisansüstü tezinden türetilmiş olması,
 *   (iii) danışmanlığını yaptığı bir tezden ya da bitirme projesinden
 *         türetilmiş olması,
 *   (iv)  yürütücüsü ya da araştırmacısı olduğu bir projeden türetilmiş olması.
 *
 * Faaliyet kaydı yalnızca (i)'nin bir kısmını taşıyor; (ii)-(iv) hiç
 * tutulmuyor. Fakülteye göre iki farklı yönde saptık ve ikisi de aday notunda
 * söylendi:
 *   Mühendislik ve Mimarlık (i) tek yazarlık (Mimarlık'ta "tek ya da ikinci
 *       yazar") istiyor → `yazar: 'tek'` süzgeci uygulandı. Öteki üç yol
 *       kontrol edilemediği için koşul OLDUĞUNDAN ZOR görünür.
 *   İİSBF ve Eğitim (i) "adaydan başka en fazla iki yazar" istiyor, yani üç
 *       yazara kadar kabul ediyor; motorun `yazar` süzgeci yazar SAYISINA göre
 *       filtreleyemiyor. Süzgeç hiç uygulanmadı, koşul OLDUĞUNDAN KOLAY
 *       görünür.
 *
 * ── EĞİTİM FAKÜLTESİNİN OKUL İŞ BİRLİĞİ KOŞULU HESAPLANAMIYOR ──
 * Doçentlik ve profesörlükte "14. bölüm c bendinden en az 10 puan" isteniyor;
 * o bent okullarda bir dönem psikolojik danışmanlık yapmayı puanlıyor ve
 * kaynak sözlüğünde karşılığı yok. Koşulun TAMAMI girilemeyen bir bölüme
 * dayandığı için `Kalip::hesaplanamiyor` ile girildi: eşiği hiç yazmamak
 * yönergenin gerçek bir şartını gizlerdi, `adet` yazmak ise adaya asla
 * sağlayamayacağı bir hedef gösterirdi.
 *
 * ── HUKUK FAKÜLTESİNİN TELAFİ DALI ──
 * "Ulusal makale asgari koşulunu sağlayamayan adaylar, 1. maddenin a, b veya c
 * bentlerinden, 1 tanesi tek yazarlı olmak üzere en az 2 yayın yapmak ve en az
 * 50 puan almak zorundadır." Doçentlikte de profesörlükte de aynı telafi
 * geçerli; `veya` dalı olarak girildi.
 *
 * ── MİMARLIK FAKÜLTESİNİN 13. BÖLÜM TELAFİSİ ──
 * "Doçent kadrosuna atanabilmek için bu bölümden en az 15 puan alınması
 * zorunludur. Bu maddedeki koşulu yerine getiremeyenlerin 1. maddenin a, b
 * veya c bentlerinden en az 1 yayın yapmaları zorunludur." Aynı biçimde
 * `telafi` dalı.
 *
 * ── GENEL ÖN KOŞULLAR ──
 * İngilizce ders verebilme: YDS ve eşdeğerlerinden en az 85 VEYA ana dili
 * olması VEYA lisans/doktorayı o dilde tamamlamış olmak VEYA o ülkede bir yıl
 * öğretim elemanlığı. `veya` ile girildi; ilk dal ölçülebiliyor.
 *
 * Yurt dışı deneyimi: "sonraki kadro yükseltilmelerinde … en az toplam bir
 * öğretim yılı öğretim veya araştırma yapmış olma koşulu aranır. Bu koşul,
 * Hukuk Fakültesi ve Mimarlık Fakültesi için uygulanmayacaktır." Doçentlik ve
 * profesörlükte beyan olarak, yalnızca üç fakültede.
 *
 * Eğitim Fakültesi mesleki deneyimi (Dr. için iki yıl okul deneyimi, doçent ve
 * profesör için bir dönem uygulama) beyan olarak girildi.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Hukuk doçentliğinin "üçü farklı dergilerde yayımlanmış" kaydı: motor aynı
 *       derginin sayısını izlemiyor, yalnızca toplam sayı ve tek yazarlılık
 *       denetlendi. Koşul olduğundan KOLAY görünür.
 *   Mühendislik ve Eğitim'in "Dr. Öğretim Üyeliğine yükseltme aşamasında
 *       değerlendirmeye alınmamış" kaydı: motor bir eserin başka bir
 *       başvuruda kullanılıp kullanılmadığını izlemiyor.
 *   Profesörlük şartlarındaki (i) proje bendinin "bu projelerden türetilmiş
 *       bir Q1, Q2 veya Q3 yayını olması" kaydı (Mühendislik): yayının
 *       projeden türetilip türetilmediği kayıtta yok.
 *   Yabancı uyruklu ve denklik başvurusu yapan adayların ulusal makale
 *       muafiyeti; Eğitim Fakültesinin yabancı uyruklu Dr. Öğr. Üyesi
 *       istisnası — ikisi de adayın uyruğuna bağlı.
 *   "Yayınlanması kabul edilmiş eserlerden en çok iki tanesi yayınlanmış
 *       kabul edilir" kaydı.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/mef-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

$DR = Kalip::DOKTORA_SONRASI;
$DOC = Kalip::DOCENTLIK_SONRASI;

$ingilizce = Kalip::veya('İngilizce ders verebilme yeterliliği', [
    Kalip::yds(85),
    Kalip::beyan(
        'Öğretim dilinin ana diliniz olması, lisans ya da doktoranızı o dilin ana dil olarak '
        .'konuşulduğu ülkede tamamlamış olmanız veya o dilde eğitim veren bir yükseköğretim '
        .'kurumunda en az bir yıl ders vermiş olmanız',
        'Ön Koşullar 1',
    ),
]);

$yurtdisi = Kalip::beyan(
    'Yurt dışındaki uluslararası eğitim ve araştırma kurumlarında en az toplam bir öğretim '
    .'yılı (iki dönem) öğretim ya da araştırma yapmış olmak',
    'Ön Koşullar 2',
);

$baslicaNotu = 'Yönerge "başlıca eser" için dört alternatif nitelikten birini yeterli '
    .'sayıyor: yazar sayısı koşulu, yayının lisansüstü tezinizden türetilmiş olması, '
    .'danışmanlığını yaptığınız bir tezden türetilmiş olması ya da yürütücüsü olduğunuz bir '
    .'projeden türetilmiş olması. Kaydınız yalnızca yazarlık tarafını taşıyor; öteki üç yol '
    .'burada denetlenemiyor.';

$atifNotu = 'Atıf puanınız olduğundan yüksek çıkabilir: yönerge kendi yayınlarınıza '
    .'yaptığınız atıfları saymıyor ve aynı yayındaki birden çok atfı tek atıf sayıyor, '
    .'kaydınız ikisini de ayırt etmiyor.';

$tavanNotu = 'Bölüm tavanları fakültenize ve bu kadroya göre uygulanır; tablonun her '
    .'bölümünün altında yazılı.';

$esikler = [];

/**
 * Ortak eşik gövdesi.
 *
 * @param  list<string>  $alanlar
 * @param  array<string, mixed>  $sart
 * @return array<string, mixed>
 */
$esik = fn (string $anahtar, string $kadro, array $alanlar, string $cetvel, array $sart, string $notlar, string $adayNotu): array => [
    'anahtar' => $anahtar,
    'aday_notu' => $adayNotu,
    'universite' => 'MEF Üniversitesi',
    'kadro' => $kadro,
    'alan' => $alanlar,
    'cetvel' => $cetvel,
    'notlar' => $notlar,
    'sart' => $sart,
];

// ══════════════════════════════════════════════════════════════════════════
// MÜHENDİSLİK FAKÜLTESİ
// ══════════════════════════════════════════════════════════════════════════

$muhBaslica = fn (string $aciklama, int $sayi, ?array $donem = null): array => Kalip::adet(
    $aciklama, ['BASLICA-MUH'], $sayi, 'tek', $donem, madde: 'Mühendislik Fakültesi',
);

$esikler[] = $esik(
    'mef-muhendislik-dr', 'dr_ogr_uyesi', ['muhendislik'], 'mef-2024-muhendislik-dr',
    Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma', [
        $ingilizce,
        $muhBaslica('Uluslararası indeksli dergilerde ya da tezinizden üretilmiş yayınlarda en az 2 başlıca eser', 2),
    ]),
    'Mühendislik Fakültesi, Dr. Öğretim Üyeliği Şartları: "en az iki başlıca eser koşulu '
    .'aranır." Puan barajı yok. Başlıca eser 1. Bölüm a ve b bentleri veya 3. Bölüm a bendi '
    .'kapsamında yayımlanmış uluslararası bilimsel yayın.',
    'Puan barajı YOK; tek koşul iki başlıca eser. Başlıca eser burada Q1-Q4 ya da AHCI '
    .'dergilerindeki makaleler ile tezinizden üretilmiş uluslararası yayınlar arasından '
    .'sayılıyor. '.$baslicaNotu.' Mühendislik Fakültesinde yazarlık koşulu TEK YAZARLIK '
    .'olduğu için burada yalnızca tek yazarlı yayınlarınız sayıldı; öteki üç yolu '
    .'kullanabiliyorsanız koşul olduğundan zor görünür.',
);

$esikler[] = $esik(
    'mef-muhendislik-docent', 'docentlik', ['muhendislik'], 'mef-2024-muhendislik-docent',
    Kalip::ve('Doçent kadrosuna atanma', [
        $ingilizce,
        $yurtdisi,
        Kalip::toplam(100),
        $muhBaslica('Uluslararası makale ve tez yayınlarınızdan en az 5 yayın', 5),
        $muhBaslica('Bunların en az 2 tanesinin doktoranızdan sonra yayımlanmış olması', 2, $DR),
        Kalip::puanDan(
            'Doktoranızdan sonra Q1, Q2 veya Q3 dergilerdeki makalelerinizden en az 40 puan',
            ['1.a-Q123'], 40, $DR, madde: '1. Bölüm · Mühendislik',
        ),
        Kalip::puanDan(
            'Doktoranızdan sonra TR Dizin dergilerindeki makalelerinizden en az 10 puan',
            ['2.a'], 10, $DR, madde: '2. Bölüm · Mühendislik',
        ),
        Kalip::adet(
            'Tezinizden üretilmiş en az 1 yayın',
            ['3.a-h'], 1, madde: '3. Bölüm · Mühendislik',
        ),
        Kalip::puanDan(
            'Doktoranızdan sonraki yayınlarınıza yapılan atıflardan en az 5 puan',
            ['5'], 5, $DR, madde: '5. Bölüm · Mühendislik',
        ),
        Kalip::puanDan(
            'Doktoranızdan sonra bilimsel toplantı çalışmalarınızdan en az 5 puan',
            ['8'], 5, $DR, madde: '8. Bölüm',
        ),
        Kalip::puanDan('Ders verme kaleminizden en az 2 puan', ['9'], 2, madde: '9. Bölüm'),
        Kalip::veya('Proje ya da tez danışmanlığı koşulu', [
            Kalip::adet(
                'Araştırma kuruluşu destekli en az 1 projede yürütücülük ya da araştırmacılık',
                ['7.a.1', '7.a.2', '7.b', '7.c'], 1, madde: 'Mühendislik Fakültesi · (i)',
            ),
            Kalip::adet(
                'En az 1 lisansüstü tez danışmanlığı',
                ['6'], 1, madde: 'Mühendislik Fakültesi · (ii)',
            ),
        ]),
    ]),
    'Mühendislik Fakültesi, Doçentlik Şartları: en az 100 puan; en az ikisi doktor unvanından '
    .'sonra yayımlanmış ve başlıca eser niteliğinde olmak üzere 1. Bölüm a/b ile 3. Bölüm a '
    .'kapsamında en az beş makale; ayrıca (i) proje ya da (ii) lisansüstü tez danışmanlığı. '
    .'Tablo notlarındaki bölüm alt kapıları da eklendi (1. Bölüm 40, 2. Bölüm 10, 3. Bölüm '
    .'1 yayın, 5. Bölüm 5, 8. Bölüm 5, 9. Bölüm 2 puan).',
    'Toplam 100 puan ve beş başlıca eser isteniyor; ikisi doktoranızdan sonra olmalı. '
    .'Üstüne tablonun bölüm notlarından gelen altı alt kapı var: Q1-Q3 dergilerden 40, TR '
    .'Dizin\'den 10, tez yayınlarından 1 adet, atıftan 5, bilimsel toplantıdan 5 ve ders '
    .'verme kaleminden 2 puan. '.$baslicaNotu.' '.$tavanNotu.' '.$atifNotu,
);

$esikler[] = $esik(
    'mef-muhendislik-profesor', 'profesorluk', ['muhendislik'], 'mef-2024-muhendislik-profesor',
    Kalip::ve('Profesör kadrosuna atanma', [
        $ingilizce,
        $yurtdisi,
        Kalip::toplam(200),
        Kalip::toplam(100, $DOC),
        $muhBaslica('Uluslararası makale ve tez yayınlarınızdan en az 8 yayın', 8),
        $muhBaslica('Bunların en az 3 tanesinin doçentliğinizden sonra yayımlanmış olması', 3, $DOC),
        Kalip::veya('Proje ya da tez danışmanlığı koşulu', [
            Kalip::adet(
                'Başarıyla tamamlanmış en az 1 projede yürütücülük',
                ['7.a.1', '7.d'], 1, madde: 'Mühendislik Fakültesi · (i)',
            ),
            Kalip::adet(
                'En az 2 yüksek lisans tezi danışmanlığı',
                ['6.b'], 2, madde: 'Mühendislik Fakültesi · (ii)',
            ),
            Kalip::adet(
                'En az 1 doktora tezi danışmanlığı',
                ['6.a'], 1, madde: 'Mühendislik Fakültesi · (iii)',
            ),
        ]),
    ]),
    'Mühendislik Fakültesi, Profesörlük Şartları: en az 200 puan, 100\'ü doçentlik sonrası; '
    .'en az üçü doçentlik sonrası ve başlıca eser olmak üzere en az sekiz makale; ayrıca (i) '
    .'proje, (ii) iki yüksek lisans ya da (iii) bir doktora tezi danışmanlığı.',
    'Toplam 200 puan (100\'ü doçentliğinizden sonra) ve sekiz başlıca eser; üçü doçentlik '
    .'sonrası olmalı. Ayrıca proje yürütücülüğü ya da tez danışmanlığı koşullarından birini '
    .'sağlamanız gerekiyor. '.$baslicaNotu.' '.$tavanNotu.' '.$atifNotu,
);

// ══════════════════════════════════════════════════════════════════════════
// MİMARLIK FAKÜLTESİ
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = $esik(
    'mef-mimarlik-dr', 'dr_ogr_uyesi', ['mimarlik'], 'mef-2024-mimarlik-dr',
    Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma', [
        $ingilizce,
        Kalip::adet(
            'Makale, kitap, tez yayını ve patent kalemlerinizden en az 2 başlıca eser',
            ['BASLICA-MIM'], 2, 'tek', madde: 'Mimarlık Fakültesi',
        ),
        Kalip::adet(
            'Bunların en az 1 tanesinin makale ya da tez yayını olması',
            ['BASLICA-MIM-CEKIRDEK'], 1, 'tek', madde: 'Mimarlık Fakültesi',
        ),
    ]),
    'Mimarlık Fakültesi, Dr. Öğretim Üyeliği Şartları: "en az bir adeti 1. Bölüm a, b, c, d; '
    .'2. Bölüm a, 3. Bölüm a, b, c, e, f, g, h bentlerinden alınmak koşuluyla asgari iki '
    .'başlıca eser." Puan barajı yok. Başlıca eser kümesi bu fakültede en geniş: makale, '
    .'kitap, tez yayını ve patent bentlerini kapsıyor.',
    'Puan barajı YOK; tek koşul iki başlıca eser, en az biri makale ya da tez yayını '
    .'olmak kaydıyla. '.$baslicaNotu.' Mimarlık Fakültesinde yazarlık koşulu "tek ya da '
    .'ikinci yazar"; motor ikinci yazarlığı süzemediği için burada yalnızca tek yazarlı '
    .'yayınlarınız sayıldı, koşul olduğundan zor görünür.',
);

$esikler[] = $esik(
    'mef-mimarlik-docent', 'docentlik', ['mimarlik'], 'mef-2024-mimarlik-docent',
    Kalip::ve('Doçent kadrosuna atanma', [
        $ingilizce,
        Kalip::toplam(100),
        Kalip::adet(
            'Makale, kitap, tez yayını ve patent kalemlerinizden en az 5 başlıca eser',
            ['BASLICA-MIM'], 5, 'tek', madde: 'Mimarlık Fakültesi',
        ),
        Kalip::adet(
            'Bunların en az 1 tanesinin doktoranızdan sonra ve uluslararası indeksli bir '
            .'dergide yayımlanmış olması',
            ['1.abc'], 1, 'tek', $DR, madde: 'Mimarlık Fakültesi',
        ),
        Kalip::puanDan(
            'Doktoranızdan sonra uluslararası indeksli dergilerdeki makalelerinizden en az 20 puan',
            ['1.abc'], 20, $DR, madde: '1. Bölüm · Mimarlık',
        ),
        Kalip::puanDan(
            'Doktoranızdan sonra TR Dizin dergilerindeki makalelerinizden en az 10 puan',
            ['2.a'], 10, $DR, madde: '2. Bölüm · Mimarlık',
        ),
        Kalip::puanDan(
            'Doktoranızdan sonraki yayınlarınıza yapılan atıflardan en az 5 puan',
            ['5'], 5, $DR, madde: '5. Bölüm · Mimarlık',
        ),
        Kalip::puanDan(
            'Doktoranızdan sonra bilimsel toplantı çalışmalarınızdan en az 5 puan',
            ['8'], 5, $DR, madde: '8. Bölüm',
        ),
        Kalip::puanDan('Ders verme kaleminizden en az 2 puan', ['9'], 2, madde: '9. Bölüm'),
        Kalip::puanDan(
            'Yarışma, uygulama projesi ve yazılım kalemlerinizden en az 15 puan',
            ['13'], 15, madde: '13. Bölüm · Mimarlık',
            // "Bu maddedeki koşulu yerine getiremeyenlerin 1. maddenin a, b
            // veya c bentlerinden en az 1 yayın yapmaları zorunludur."
        ) + ['telafi' => Kalip::adet(
            'Bu koşulu sağlayamıyorsanız uluslararası indeksli bir dergide en az 1 yayın',
            ['1.abc'], 1, madde: '13. Bölüm · Mimarlık telafisi',
        )],
    ]),
    'Mimarlık Fakültesi, Doçentlik Şartları: en az 100 puan; en az biri doktor unvanından '
    .'sonra ve 1. Bölüm a, b veya c bentlerinden olmak koşuluyla asgari beş başlıca eser. '
    .'Tablo notlarındaki alt kapılar eklendi (1. Bölüm 20, 2. Bölüm 10, 5. Bölüm 5, 8. Bölüm '
    .'5, 9. Bölüm 2, 13. Bölüm 15 puan). 13. Bölümün telafisi yönergede açıkça yazılı.',
    'Toplam 100 puan ve beş başlıca eser; en az biri doktoranızdan sonra ve uluslararası '
    .'indeksli bir dergide olmalı. Mimarlık Fakültesine özgü 13. bölüm (yarışma, uygulama '
    .'projesi, yazılım) koşulu da var: oradan 15 puan alamıyorsanız uluslararası indeksli '
    .'bir dergide bir yayın yapmanız gerekiyor. '.$baslicaNotu.' '.$tavanNotu.' '.$atifNotu,
);

$esikler[] = $esik(
    'mef-mimarlik-profesor', 'profesorluk', ['mimarlik'], 'mef-2024-mimarlik-profesor',
    Kalip::ve('Profesör kadrosuna atanma', [
        $ingilizce,
        Kalip::toplam(200),
        Kalip::toplam(100, $DOC),
        Kalip::adet(
            'Makale, kitap, tez yayını ve patent kalemlerinizden en az 8 başlıca eser',
            ['BASLICA-MIM'], 8, 'tek', madde: 'Mimarlık Fakültesi',
        ),
        Kalip::adet(
            'Bunların en az 1 tanesinin doçentliğinizden sonra ve uluslararası indeksli bir '
            .'dergide yayımlanmış olması',
            ['1.abc'], 1, 'tek', $DOC, madde: 'Mimarlık Fakültesi',
        ),
    ]),
    'Mimarlık Fakültesi, Profesörlük Şartları: en az 200 puan, 100\'ü doçentlik sonrası; en '
    .'az biri doçent unvanından sonra ve 1. Bölüm a, b veya c bentlerinden olmak koşuluyla '
    .'asgari sekiz başlıca eser.',
    'Toplam 200 puan (100\'ü doçentliğinizden sonra) ve sekiz başlıca eser; en az biri '
    .'doçentliğinizden sonra ve uluslararası indeksli bir dergide olmalı. '
    .$baslicaNotu.' '.$tavanNotu.' '.$atifNotu,
);

// ══════════════════════════════════════════════════════════════════════════
// HUKUK FAKÜLTESİ
// ══════════════════════════════════════════════════════════════════════════

/** Ulusal makale koşulunu sağlayamayanlar için yönergenin kendi telafisi. */
$hukukTelafi = Kalip::ve('Ulusal makale koşulu yerine uluslararası yayın', [
    Kalip::adet(
        'Uluslararası indeksli dergilerde en az 2 yayın, en az 1\'i tek yazarlı',
        ['1.abc'], 2, madde: 'Hukuk Fakültesi telafisi',
    ),
    Kalip::adet(
        'Bu yayınlardan en az 1\'inin tek yazarlı olması',
        ['1.abc'], 1, 'tek', madde: 'Hukuk Fakültesi telafisi',
    ),
    Kalip::puanDan(
        'Uluslararası indeksli dergilerdeki makalelerinizden en az 50 puan',
        ['1.abc'], 50, madde: 'Hukuk Fakültesi telafisi',
    ),
]);

$esikler[] = $esik(
    'mef-hukuk-dr', 'dr_ogr_uyesi', ['hukuk'], 'mef-2024-hukuk-dr',
    Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma', [
        $ingilizce,
        Kalip::beyan(
            'Doktora tezinizin tez yayını kalemleri kapsamında ya da Yükseköğretim Kurumunun '
            .'veya MEF Üniversitesinin sağlayacağı elektronik ortamda yayımlanmış olması',
            'Hukuk Fakültesi',
        ),
        Kalip::adet(
            'Hakemli dergilerde toplam en az 2 özgün yayın',
            ['2.ab'], 2, madde: 'Hukuk Fakültesi',
        ),
        Kalip::adet(
            'Bunların en az 1 tanesinin doktoranızdan sonra yayımlanmış olması',
            ['2.ab'], 1, donem: $DR, madde: 'Hukuk Fakültesi',
        ),
    ]),
    'Hukuk Fakültesi, Dr. Öğretim Üyeliği Şartları: doktora tezinin 3. Bölüm kapsamında ya da '
    .'elektronik ortamda yayımlanmış olması; ayrıca 2. Bölümün a veya b bendinde doktora '
    .'unvanından sonra en az 1, toplamda en az 2 özgün yayın. Puan barajı yok.',
    'Puan barajı YOK. Hakemli dergilerde toplam iki özgün yayın isteniyor, en az biri '
    .'doktoranızdan sonra. Doktora tezinizin yayımlanmış olması ayrıca belgeyle beyan '
    .'ediliyor. Hukuk Fakültesinde çok yazarlı yayınlarda puan yazarlar arasında EŞİT '
    .'bölünüyor (öteki fakültelerde kademeli bir formül var).',
);

$esikler[] = $esik(
    'mef-hukuk-docent', 'docentlik', ['hukuk'], 'mef-2024-hukuk-docent',
    Kalip::ve('Doçent kadrosuna atanma', [
        $ingilizce,
        Kalip::toplam(100),
        Kalip::veya('Ulusal makale koşulu', [
            Kalip::ve('TR Dizin dergilerinde yayın koşulu', [
                Kalip::adet(
                    'Doktoranızdan sonra TR Dizin dergilerinde en az 6 yayın',
                    ['2.a'], 6, donem: $DR, madde: 'Hukuk Fakültesi · (i)',
                ),
                Kalip::adet(
                    'Bunların en az 4 tanesinin tek yazarlı olması',
                    ['2.a'], 4, 'tek', $DR, madde: 'Hukuk Fakültesi · (i)',
                ),
                Kalip::puanDan(
                    'TR Dizin dergilerindeki makalelerinizden en az 50 puan',
                    ['2.a'], 50, $DR, madde: '2. Bölüm · Hukuk',
                ),
            ]),
            $hukukTelafi,
        ]),
        Kalip::adet(
            'Doktoranızdan sonra en az 1 kitap ya da kitap bölümü',
            ['4.ac'], 1, donem: $DR, madde: 'Hukuk Fakültesi · (ii)',
        ),
    ]),
    'Hukuk Fakültesi, Doçentlik Şartları: en az 100 puan; (i) doktor unvanından sonra 2. '
    .'Bölüm a bendinden dördü tek yazarlı olmak üzere, üçü farklı dergilerde yayımlanmış en '
    .'az altı yayın ve en az 50 puan; (ii) doktor unvanından sonra 4. Bölüm a veya c '
    .'bendinden en az 1 yayın. Telafi dalı yönergede açıkça yazılı. "Üçü farklı dergilerde" '
    .'kaydı motor dergi adını izlemediği için uygulanamadı.',
    'Toplam 100 puan. TR Dizin dergilerinde doktoranızdan sonra altı yayın (dördü tek '
    .'yazarlı) ve o yayınlardan 50 puan isteniyor; bunu sağlayamıyorsanız uluslararası '
    .'indeksli dergilerde iki yayın (biri tek yazarlı) ve 50 puan yeterli. Ayrıca '
    .'doktoranızdan sonra bir kitap ya da kitap bölümü gerekiyor. Yönergenin "üçü farklı '
    .'dergilerde yayımlanmış" kaydı burada denetlenemiyor, koşul olduğundan kolay görünür. '
    .$tavanNotu.' '.$atifNotu,
);

$esikler[] = $esik(
    'mef-hukuk-profesor', 'profesorluk', ['hukuk'], 'mef-2024-hukuk-profesor',
    Kalip::ve('Profesör kadrosuna atanma', [
        $ingilizce,
        Kalip::toplam(200),
        Kalip::toplam(100, $DOC),
        Kalip::veya('Ulusal makale koşulu', [
            Kalip::adet(
                'Doçentliğinizden sonra TR Dizin dergilerinde en az 4 özgün yayın',
                ['2.a'], 4, donem: $DOC, madde: 'Hukuk Fakültesi · (i)',
            ),
            $hukukTelafi,
        ]),
        Kalip::adet(
            'Doçentliğinizden sonra tek yazarlı en az 1 kitap',
            ['4'], 1, 'tek', $DOC, madde: 'Hukuk Fakültesi · (ii)',
        ),
        Kalip::veya('Ders verme ya da tez yönetme koşulu', [
            Kalip::adet(
                'Lisansüstü programlarda ders vermiş olmak',
                ['9'], 1, madde: 'Hukuk Fakültesi · (iii)',
            ),
            Kalip::adet(
                'En az 1 yüksek lisans ya da doktora tezi yönetmiş olmak',
                ['6'], 1, madde: 'Hukuk Fakültesi · (iii)',
            ),
        ]),
    ]),
    'Hukuk Fakültesi, Profesörlük Şartları: en az 200 puan, 100\'ü doçentlik sonrası; (i) '
    .'doçent unvanından sonra 2. Bölüm a bendinden en az 4 özgün yayın (aynı telafi dalı), '
    .'(ii) doçentlik sonrası 4. Bölüm kapsamında tek yazarlı bir kitap, (iii) lisansüstü '
    .'programlarda en az 2 dönem ders vermek ya da en az 1 tez yönetmek.',
    'Toplam 200 puan (100\'ü doçentliğinizden sonra). Doçentliğinizden sonra TR Dizin '
    .'dergilerinde dört özgün yayın (sağlayamıyorsanız uluslararası indeksli dergilerde iki '
    .'yayın ve 50 puan), tek yazarlı bir kitap ve ders verme ya da tez yönetme koşulu. '
    .'Yönerge "en az 2 dönem ders" diyor; ders kalemi burada dönem sayısını tutmadığı için '
    .'bir kayıt yeterli sayıldı, koşul olduğundan kolay görünür. '.$tavanNotu.' '.$atifNotu,
);

// ══════════════════════════════════════════════════════════════════════════
// İKTİSADİ, İDARİ VE SOSYAL BİLİMLER FAKÜLTESİ
// ══════════════════════════════════════════════════════════════════════════

$sosBaslicaNotu = $baslicaNotu.' Bu fakültede yazarlık koşulu "adaydan başka en fazla iki '
    .'yazar", yani üç yazara kadar kabul ediliyor; motor yazar SAYISINA göre süzemediği için '
    .'burada yazar süzgeci hiç uygulanmadı ve koşul olduğundan kolay görünür.';

$esikler[] = $esik(
    'mef-sosyal-dr', 'dr_ogr_uyesi', ['sosyal'], 'mef-2024-sosyal-dr',
    Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma', [
        $ingilizce,
        Kalip::adet(
            'Q1-Q4 ya da AHCI dergilerindeki makalelerinizden en az 2 başlıca eser',
            ['1.ab'], 2, madde: 'İİSBF',
        ),
        Kalip::adet(
            'Bunların en az 1 tanesinin Q1-Q4 dergilerde yayımlanmış olması',
            ['1.a'], 1, madde: 'İİSBF',
        ),
    ]),
    'İktisadi, İdari ve Sosyal Bilimler Fakültesi, Dr. Öğretim Üyeliği Şartları: "en az bir '
    .'tanesi 1. Bölümün a bendinden olmak üzere a ve b bentlerinden en az iki başlıca esere '
    .'sahip olunması zorunludur." Puan barajı yok.',
    'Puan barajı YOK; tek koşul iki başlıca eser, en az biri Q1-Q4 dergilerde olmak '
    .'kaydıyla. '.$sosBaslicaNotu,
);

$esikler[] = $esik(
    'mef-sosyal-docent', 'docentlik', ['sosyal'], 'mef-2024-sosyal-docent',
    Kalip::ve('Doçent kadrosuna atanma', [
        $ingilizce,
        $yurtdisi,
        Kalip::toplam(100),
        Kalip::adet(
            'Q1-Q4 ya da AHCI dergilerindeki makalelerinizden en az 4 başlıca eser',
            ['1.ab'], 4, madde: 'İİSBF',
        ),
        Kalip::adet(
            'Bunların en az 2 tanesinin Q1-Q4 dergilerde yayımlanmış olması',
            ['1.a'], 2, madde: 'İİSBF',
        ),
        Kalip::puanDan(
            'Doktoranızdan sonra uluslararası dergilerdeki makalelerinizden en az 10 puan',
            ['1.abcd'], 10, $DR, madde: '1. Bölüm · İİSBF',
        ),
        Kalip::veya('Ulusal makale koşulu', [
            Kalip::ve('TR Dizin dergilerinde yayın koşulu', [
                Kalip::adet(
                    'Doktoranızdan sonra TR Dizin dergilerinde en az 5 yayın',
                    ['2.a'], 5, donem: $DR, madde: '2. Bölüm · İİSBF',
                ),
                Kalip::adet(
                    'Bunların en az 3 tanesinin tek yazarlı olması',
                    ['2.a'], 3, 'tek', $DR, madde: '2. Bölüm · İİSBF',
                ),
            ]),
            Kalip::ve('Uluslararası yayın telafisi', [
                Kalip::adet(
                    'Q1-Q4 ya da AHCI dergilerinde en az 3 yayın',
                    ['1.ab'], 3, madde: '2. Bölüm · İİSBF telafisi',
                ),
                Kalip::adet(
                    'Bunların en az 1 tanesinin tek yazarlı olması',
                    ['1.ab'], 1, 'tek', madde: '2. Bölüm · İİSBF telafisi',
                ),
            ]),
        ]),
        Kalip::adet(
            'Doktoranızdan sonra en az 1 kitap ya da 2 kitap bölümü',
            ['4'], 1, donem: $DR, madde: '4. Bölüm · İİSBF',
        ),
        Kalip::puanDan(
            'Doktoranızdan sonraki yayınlarınıza yapılan atıflardan en az 5 puan',
            ['5'], 5, $DR, madde: '5. Bölüm · İİSBF',
        ),
        Kalip::puanDan(
            'Doktoranızdan sonra bilimsel toplantı çalışmalarınızdan en az 5 puan',
            ['8'], 5, $DR, madde: '8. Bölüm',
        ),
        Kalip::puanDan('Ders verme kaleminizden en az 2 puan', ['9'], 2, madde: '9. Bölüm'),
        Kalip::veya('Proje ya da tez danışmanlığı koşulu', [
            Kalip::adet(
                'Araştırma kuruluşu destekli en az 1 projede yürütücülük ya da araştırmacılık',
                ['7.a.1', '7.a.2', '7.b', '7.c'], 1, madde: 'İİSBF · (i)',
            ),
            Kalip::adet('En az 1 lisansüstü tez danışmanlığı', ['6'], 1, madde: 'İİSBF · (ii)'),
        ]),
    ]),
    'İİSBF, Doçentlik Şartları: en az 100 puan; en az ikisi 1. Bölümün a bendinden olmak '
    .'üzere a veya b bentlerinden en az dört başlıca eser; ayrıca (i) proje ya da (ii) '
    .'lisansüstü tez danışmanlığı. Tablo notlarındaki alt kapılar eklendi (1. Bölüm 10 puan, '
    .'2. Bölüm 5 yayın + telafi, 4. Bölüm 1 kitap, 5. Bölüm 5, 8. Bölüm 5, 9. Bölüm 2 puan). '
    .'"En az bir kitap veya iki kitap bölümü" kaydı tek adet koşuluna indirildi.',
    'Toplam 100 puan ve dört başlıca eser; ikisi Q1-Q4 dergilerde olmalı. Üstüne TR Dizin '
    .'dergilerinde beş yayın (üçü tek yazarlı) ya da onun yerine Q1-Q4/AHCI dergilerinde üç '
    .'yayın; ayrıca kitap, atıf, bilimsel toplantı ve ders alt kapıları var. '
    .$sosBaslicaNotu.' '.$tavanNotu.' '.$atifNotu,
);

$esikler[] = $esik(
    'mef-sosyal-profesor', 'profesorluk', ['sosyal'], 'mef-2024-sosyal-profesor',
    Kalip::ve('Profesör kadrosuna atanma', [
        $ingilizce,
        $yurtdisi,
        Kalip::toplam(200),
        Kalip::toplam(100, $DOC),
        Kalip::adet(
            'Doçentliğinizden sonra Q1-Q4 ya da AHCI dergilerinde en az 4 başlıca eser',
            ['1.ab'], 4, donem: $DOC, madde: 'İİSBF',
        ),
        Kalip::adet(
            'Bunların en az 2 tanesinin Q1-Q4 dergilerde yayımlanmış olması',
            ['1.a'], 2, donem: $DOC, madde: 'İİSBF',
        ),
        Kalip::adet(
            'Doçentliğinizden sonra toplam en az 8 yayın',
            ['1', '2', '3', '4'], 8, donem: $DOC, madde: 'İİSBF',
        ),
        Kalip::veya('Proje ya da tez danışmanlığı koşulu', [
            Kalip::adet(
                'Başarıyla tamamlanmış en az 1 projede yürütücülük',
                ['7.a.1', '7.d'], 1, madde: 'İİSBF · (i)',
            ),
            Kalip::adet('En az 2 yüksek lisans tezi danışmanlığı', ['6.b'], 2, madde: 'İİSBF · (ii)'),
            Kalip::adet('En az 1 doktora tezi danışmanlığı', ['6.a'], 1, madde: 'İİSBF · (iii)'),
        ]),
    ]),
    'İİSBF, Profesörlük Şartları: en az 200 puan, 100\'ü doçentlik sonrası; doçentlik '
    .'sonrası en az ikisi 1. Bölümün a bendinden olmak üzere a veya b bentlerinden en az '
    .'dört başlıca eser ve toplam en az sekiz yayın; ayrıca (i) proje, (ii) iki yüksek '
    .'lisans ya da (iii) bir doktora tezi danışmanlığı.',
    'Toplam 200 puan (100\'ü doçentliğinizden sonra). Doçentliğinizden sonra dört başlıca '
    .'eser (ikisi Q1-Q4 dergilerde) ve toplam sekiz yayın isteniyor; ayrıca proje ya da tez '
    .'danışmanlığı koşullarından biri. '.$sosBaslicaNotu.' '.$tavanNotu.' '.$atifNotu,
);

// ══════════════════════════════════════════════════════════════════════════
// EĞİTİM FAKÜLTESİ
// ══════════════════════════════════════════════════════════════════════════

$egitimDeneyim = fn (string $aciklama): array => Kalip::beyan($aciklama, 'Eğitim Fakültesi · Mesleki Deneyim');

/** 14. bölüm cetvele girilemedi; koşul beyana değil, veri açığına düşüyor. */
$okulIsbirligi = fn (string $ek): array => Kalip::hesaplanamiyor(
    'Okullarla iş birliği çerçevesinde bir okulda bir dönem psikolojik danışmanlık yapmak'
    .$ek.' (yönerge bu kalemden en az 10 puan istiyor; okul iş birliği bölümü faaliyet '
    .'kaydında karşılık bulmadığı için hesaplanamıyor)',
    'Eğitim Fakültesi · 14. Bölüm',
);

$esikler[] = $esik(
    'mef-egitim-dr', 'dr_ogr_uyesi', ['egitim'], 'mef-2024-egitim-dr',
    Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma', [
        $ingilizce,
        $egitimDeneyim(
            'Okullarda, psikolojik danışma merkezlerinde ya da öğrenci başarısını artırmaya '
            .'yönelik kurumlarda en az toplam iki yıl çalışmış olmak',
        ),
        Kalip::adet(
            'Q1-Q4 ya da AHCI dergilerindeki makaleleriniz ile tez yayınlarınızdan en az 2 başlıca eser',
            ['BASLICA-MUH'], 2, madde: 'Eğitim Fakültesi',
        ),
    ]),
    'Eğitim Fakültesi, Dr. Öğretim Üyeliği Şartları: "en az iki başlıca esere sahip olunması '
    .'zorunludur." Puan barajı yok. Ayrıca fakültenin mesleki deneyim ön koşulu (en az iki '
    .'yıl okul deneyimi) beyan olarak duruyor.',
    'Puan barajı YOK; tek yayın koşulu iki başlıca eser. Ayrıca Eğitim Fakültesinin mesleki '
    .'deneyim ön koşulu var: okullarda ya da psikolojik danışma merkezlerinde en az iki yıl '
    .'çalışmış olmak. '.$sosBaslicaNotu,
);

$esikler[] = $esik(
    'mef-egitim-docent', 'docentlik', ['egitim'], 'mef-2024-egitim-docent',
    Kalip::ve('Doçent kadrosuna atanma', [
        $ingilizce,
        $yurtdisi,
        $egitimDeneyim(
            'Fakülte yönetiminin uygun gördüğü bir okulda ya da rehberlik ve psikolojik '
            .'danışma merkezinde en az bir dönem uygulama deneyimi (haftada en az bir gün '
            .'ya da toplam beş saat)',
        ),
        Kalip::toplam(100),
        Kalip::adet(
            'Doktoranızdan sonra en az 5 yayın',
            ['1', '2', '3', '4'], 5, donem: $DR, madde: 'Eğitim Fakültesi',
        ),
        Kalip::adet(
            'Bunların en az 3 tanesinin başlıca eser niteliğinde olması',
            ['BASLICA-MUH'], 3, donem: $DR, madde: 'Eğitim Fakültesi',
        ),
        Kalip::adet(
            'Başlıca eserlerden en az 1 tanesinin Q1-Q4 dergilerde yayımlanmış olması',
            ['1.a'], 1, donem: $DR, madde: 'Eğitim Fakültesi',
        ),
        Kalip::puanDan(
            'Doktoranızdan sonra Q1, Q2 veya Q3 dergilerdeki makalelerinizden en az 30 puan',
            ['1.a-Q123'], 30, $DR, madde: '1. Bölüm · Eğitim',
        ),
        Kalip::adet(
            'Doktoranızdan sonra ulusal dergilerde en az 2 yayın, en az 1\'i TR Dizin\'de',
            ['2.ab'], 2, donem: $DR, madde: '2. Bölüm · Eğitim',
        ),
        Kalip::adet(
            'Bunların en az 1 tanesinin TR Dizin dergisinde olması',
            ['2.a'], 1, donem: $DR, madde: '2. Bölüm · Eğitim',
        ),
        Kalip::puanDan(
            'Doktoranızdan sonraki yayınlarınıza yapılan atıflardan en az 5 puan',
            ['5'], 5, $DR, madde: '5. Bölüm · Eğitim',
        ),
        Kalip::puanDan(
            'Doktoranızdan sonra bilimsel toplantı çalışmalarınızdan en az 5 puan',
            ['8'], 5, $DR, madde: '8. Bölüm',
        ),
        Kalip::puanDan('Ders verme kaleminizden en az 2 puan', ['9'], 2, madde: '9. Bölüm'),
        $okulIsbirligi(''),
        Kalip::veya('Proje ya da tez danışmanlığı koşulu', [
            Kalip::adet(
                'Araştırma kuruluşu destekli en az 1 projede yürütücülük ya da araştırmacılık',
                ['7.a.1', '7.a.2', '7.b', '7.c'], 1, madde: 'Eğitim Fakültesi · (i)',
            ),
            Kalip::adet('En az 1 lisansüstü tez danışmanlığı', ['6'], 1, madde: 'Eğitim Fakültesi · (ii)'),
        ]),
    ]),
    'Eğitim Fakültesi, Doçentlik Şartları: en az 100 puan; doktor unvanından sonra en az üçü '
    .'başlıca eser olmak üzere en az beş yayın, başlıca eserlerden biri 1. Bölümün a '
    .'bendinden; ayrıca (i) proje ya da (ii) lisansüstü tez danışmanlığı. Tablo notlarındaki '
    .'alt kapılar eklendi (1. Bölüm 30, 2. Bölüm 2 yayın, 5. Bölüm 5, 8. Bölüm 5, 9. Bölüm 2 '
    .'puan, 14. Bölüm c bendinden 10 puan). 14. Bölüm cetvele girilemediği için o koşul '
    .'`hesaplanamiyor` olarak duruyor.',
    'Toplam 100 puan; doktoranızdan sonra beş yayın, üçü başlıca eser ve biri Q1-Q4 '
    .'dergilerde. Q1-Q3\'ten 30 puan, ulusal dergilerde iki yayın, atıf, bilimsel toplantı '
    .'ve ders alt kapıları da var. OKULLARLA İŞ BİRLİĞİ KOŞULU BURADA HESAPLANAMIYOR: '
    .'yönerge bir dönem psikolojik danışmanlık yapmayı şart koşuyor ama bu kalem faaliyet '
    .'kaydında tutulmuyor; belgeyle sağlamanız gerekiyor. Ayrıca fakültenin mesleki deneyim '
    .'ön koşulu var. '.$sosBaslicaNotu.' '.$tavanNotu.' '.$atifNotu,
);

$esikler[] = $esik(
    'mef-egitim-profesor', 'profesorluk', ['egitim'], 'mef-2024-egitim-profesor',
    Kalip::ve('Profesör kadrosuna atanma', [
        $ingilizce,
        $yurtdisi,
        $egitimDeneyim(
            'Fakülte yönetiminin uygun gördüğü bir okulda ya da rehberlik ve psikolojik '
            .'danışma merkezinde en az bir dönem deneyim (haftada en az bir gün ya da '
            .'toplam beş saat)',
        ),
        Kalip::toplam(200),
        Kalip::toplam(100, $DOC),
        Kalip::adet(
            'Q1-Q4 ya da AHCI dergilerindeki makaleleriniz ile tez yayınlarınızdan en az 8 yayın',
            ['BASLICA-MUH'], 8, madde: 'Eğitim Fakültesi',
        ),
        Kalip::adet(
            'Bunların en az 3 tanesinin doçentliğinizden sonra ve başlıca eser niteliğinde olması',
            ['BASLICA-MUH'], 3, donem: $DOC, madde: 'Eğitim Fakültesi',
        ),
        $okulIsbirligi(' (doçentliğinizden sonra)'),
        Kalip::veya('Proje ya da tez danışmanlığı koşulu', [
            Kalip::adet(
                'Başarıyla tamamlanmış en az 1 projede yürütücülük',
                ['7.a.1', '7.d'], 1, madde: 'Eğitim Fakültesi · (i)',
            ),
            Kalip::adet('En az 2 yüksek lisans tezi danışmanlığı', ['6.b'], 2, madde: 'Eğitim Fakültesi · (ii)'),
            Kalip::adet('En az 1 doktora tezi danışmanlığı', ['6.a'], 1, madde: 'Eğitim Fakültesi · (iii)'),
        ]),
    ]),
    'Eğitim Fakültesi, Profesörlük Şartları: en az 200 puan, 100\'ü doçentlik sonrası; en az '
    .'üçü doçent unvanından sonra ve başlıca eser olmak üzere en az sekiz makale; ayrıca (i) '
    .'proje, (ii) iki yüksek lisans ya da (iii) bir doktora tezi danışmanlığı; ve doçentlik '
    .'sonrası 14. Bölüm c bendinden en az 10 puan (cetvele girilemedi).',
    'Toplam 200 puan (100\'ü doçentliğinizden sonra) ve sekiz yayın; üçü doçentlik sonrası '
    .'ve başlıca eser olmalı. Okullarla iş birliği koşulu burada hesaplanamıyor, belgeyle '
    .'sağlanıyor. Fakültenin mesleki deneyim ön koşulu da geçerli. '
    .$sosBaslicaNotu.' '.$tavanNotu.' '.$atifNotu,
);

return $esikler;
