<?php

/**
 * İZMİR KÂTİP ÇELEBİ ÜNİVERSİTESİ — Akademik Atama ve Yükseltme Kriterleri
 * Kaynak: pdf/17536998122.izmirkatipcelebiuniversitesi.pdf
 * (28 sayfa; 02.02.2023 tarih ve 2023/03-01 sayılı Senato kararı eki)
 *
 * ── YAPI: DÖRT EK, DÖRT AYRI KRİTER SETİ ──
 * Ortak ilkeler (1-3. bölümler) bütün başvurulara dil şartı ve profesörlük
 * için iki tamamlanmış lisansüstü danışmanlık koşulu getiriyor; kadro
 * ölçütleri ve puan tabloları ise alan grubu başına ayrı eklerde:
 *   EK-A Sosyal Bilimler Alanı   → `sosyal`
 *   EK-B Fen Bilimleri Alanı     → `fen`
 *   EK-C Sağlık Bilimleri Alanı  → `saglik`
 *   EK-D Güzel Sanatlar Alanı    → `guzel_sanatlar`
 *
 * ── ALAN KAPSAMI ──
 * Yönerge yalnızca bu dört alan adını anıyor. KONVANSIYONLAR §"Yönergenin
 * anmadığı alanlar" uyarınca mühendislik, mimarlık, eğitim, hukuk,
 * ilahiyat, filoloji, ziraat ve spor için eşik YAZILMADI: bu alanları
 * "Fen Bilimleri" ya da "Sosyal Bilimler" grubuna katmak, adaya yönergede
 * yazmayan bir baraj göstermek olurdu.
 * Yönergenin kendi birim istisnası (Sağlık Bilimleri Fakültesi Sosyal
 * Hizmet Bölümü, EK-A kriterlerine tabi) `saglik` eşiklerinin aday notunda
 * anlatıldı; bölüm bilgisi profilde tutulmadığı için ayrı eşik açılmadı.
 *
 * ── EK-D'DE ÖZEL BAŞVURU ŞARTLARI ALT DİSİPLİNE GÖRE DEĞİŞİYOR ──
 * Güzel Sanatlar adayları hem "genel" hem "özel" başvuru şartlarını
 * sağlamak zorunda; özel şartlar plastik sanatlar ile müzik için ayrı
 * yazılmış. Bu ayrım `birim` ile kuruldu: `guzel_sanatlar` alanında her
 * kadro iki eşik taşıyor.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Dört ekin de Dr. Öğr. Üyesi YENİDEN ATANMA ölçütleri atama süresine
 *       bağlı (EK-A 40/60/80/100, EK-B 40/80/120/160, EK-C 50/60/70/80,
 *       EK-D 30/40/60/80 puan; sırasıyla 1, 2, 3 ve 4 yıllık atama).
 *       Atama süresi profilde yok; herhangi birini sabitlemek yanlış baraj
 *       gösterirdi (KONVANSIYONLAR §"Girilmeyen tipik koşullar"). Yeniden
 *       atanma kadrosu hiçbir alanda açılmadı, tüm basamaklar aday notunda
 *       yazıldı.
 *   EK-A DOÇENTLİK PUAN BARAJI: "kurul tarafından ilan edilen asgari puan
 *       şartının en az %80'i" — asgari puan yönergede sayı olarak YOK,
 *       kadro ilanıyla belirleniyor. `Kalip::hesaplanamiyor` ile
 *       işaretlendi; aynı nedenle o varyantta yüzdeye bağlı tavanlar da
 *       uygulanamadı.
 *   Ortak ilkelerdeki "Profesör kadrosuna başvuranlar yayınlarından birini
 *       başlıca araştırma eseri olarak gösterirler" — `beyan`.
 *   Ortak ilkelerdeki "tamamen yabancı dille eğitim veren birimlerde ders
 *       verebilme şartı" — birimin eğitim dili profilde yok; herkese
 *       65 puanlık dil eşiği uygulandı.
 *   EK-B doçentliğindeki "yükseköğretim kurumları DIŞINDAN yapılacak
 *       atamalarda son beş yılda 9. maddeden en az 8 puan" — adayın nereden
 *       geldiği profilde yok.
 *   EK-D profesörlüğündeki "en az beş yıl çalışmış olmak, bunun üç yılında
 *       yükseköğretim kurumunda tam zamanlı görev, en az iki yıl ders
 *       vermek" ve EK-C profesörlüğündeki "doçentlikten sonra 3 yılı
 *       yükseköğretim kurumunda olmak üzere 5 yıl çalışmak" — `beyan`.
 *   Ön değerlendirme komisyonlarının kuruluşu ve jüri süreçleri.
 *
 * ── KAYNAKTAKİ ÇELİŞKİ OLDUĞU GİBİ BIRAKILMADI (TEK İSTİSNA) ──
 * EK-C doçentlik metni "9. maddedeki eğitim öğretim faaliyetlerinden
 * doktora sonrası olmak koşuluyla en az 25 puan" istiyor; ama aynı
 * tablonun 9. madde dipnotu "Doçentlik atamalarında 8 puan ... Bu madde
 * kapsamında EN FAZLA 15 PUAN alınabilir" diyor. 25 puanlık eşik tavanın
 * üstünde, yani hiçbir aday sağlayamaz. Sağlanamaz bir düğüm eşiği
 * kullanılamaz hâle getireceği için barajın ULAŞILABİLİR EN SIKI hâli
 * (tavanın kendisi, 15) yazıldı ve çelişki `notlar` ile aday notunda
 * açıkça söylendi.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/ikcu-2023.php
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'İzmir Katip Çelebi Üniversitesi';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;

$dil = Kalip::yds(65);

$docentUnvani = Kalip::beyan('Üniversitelerarası Kurul tarafından verilen doçentlik unvanına sahip olmak', 'Kadro ölçütleri');

// Ortak ilkeler: profesörlükte iki tamamlanmış lisansüstü danışmanlık ve
// başlıca araştırma eseri beyanı bütün alanlarda geçerli.
$profesorOrtak = [
    Kalip::beyan(
        'Başvurduğunuz bilim alanında yürüttüğünüz en az iki lisansüstü öğrenci danışmanlığını '
        .'tamamlamış olmak (İKÇÜ\'de lisansüstü eğitim verilmeyen anabilim dallarında aranmaz; '
        .'Tıp ve Diş Hekimliği fakültelerinde eş danışmanlıklar ve uzmanlık tezi danışmanlığı da sayılır)',
        '3. Başvuru ve Değerlendirme',
    ),
    Kalip::beyan('Yayınlarınızdan birini başlıca araştırma eseri olarak göstermek', '3. Başvuru ve Değerlendirme'),
];

$YENIDEN = ' Yeniden atanma (görev uzatma) ölçütleri atama süresine bağlı olduğu ve atama süresi '
    .'profilde tutulmadığı için burada gösterilmiyor.';

$esikler = [];

// ══════════════════════════════════════════════════════════════════════════
// EK-A — SOSYAL BİLİMLER ALANI
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'ikcu-sosyal-dr',
    'aday_notu' => 'Sosyal Bilimler alanında Dr. Öğretim Üyeliği için tablonun 1., 2., 3., 4. ve 7. '
        .'maddelerinden toplam en az 50 puan ve uluslararası makalelerinizin birinde başlıca yazar '
        .'olma koşulu isteniyor. Alan indeksi belirlenmemiş alanlarda 1.2.a (ULAKBİM TR Dizin) '
        .'yayınları da kabul ediliyor.'.$YENIDEN
        .' Yeniden atanmada 1., 2. ve 3. maddelerden en az 20/30/40/50 puan olmak üzere toplam '
        .'40/60/80/100 puan sırasıyla 1, 2, 3 ve 4 yıllık atama sağlıyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['sosyal'],
    'cetvel' => 'ikcu-2023-sosyal-dr',
    'notlar' => 'EK-A/3: 1.1. maddesinin a ve b fıkralarından (alan indeksi belirlenmemiş alanlarda '
        .'1.2.a) en az birinde başlıca yazar olmak koşuluyla 1., 2., 3., 4. ve 7. maddelerden en az '
        .'50 puan. Dil şartı 65 (ortak ilkeler).',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma — Sosyal Bilimler', [
        $dil,
        Kalip::veya('Başlıca yazar olduğunuz bir uluslararası makale koşulu', [
            Kalip::adet('SSCI/SCI/SCI-E/AHCI ya da uluslararası alan endeksli dergide başlıca yazar olduğunuz en az 1 makaleniz olmalı', ['A1.1'], 1, yazar: 'baslica', madde: 'EK-A/3'),
            Kalip::adet('Alan indeksi belirlenmemiş alanlarda ULAKBİM TR Dizin dergisinde başlıca yazar olduğunuz en az 1 makaleniz olmalı', ['A1.2.a'], 1, yazar: 'baslica', madde: 'EK-A/3'),
        ]),
        Kalip::toplam(50, null, ['A-DR-TOPLAM'], 'Tablonun 1., 2., 3., 4. ve 7. maddeleri'),
    ]),
];

$esikler[] = [
    'anahtar' => 'ikcu-sosyal-docentlik',
    'aday_notu' => 'DİKKAT: Sosyal Bilimler alanında doçentlik puan barajı yönergede sayı olarak '
        .'YAZILI DEĞİL — "kurul tarafından ilan edilen asgari puan şartının en az %80\'i" deniyor '
        .'ve bu sayı kadro ilanıyla belirleniyor. Bu yüzden puan barajı burada hesaplanamıyor; '
        .'aşağıdaki ölçüt sayımı ve başlıca yazarlık koşulu sağlansa bile başvurmadan önce ilan '
        .'metnindeki asgari puanı üniversiteye teyit ettirin. Aynı nedenle tablonun yüzdeye bağlı '
        .'tavanları (kitap, atıf, tez danışmanlığı, bilimsel toplantı) da uygulanamıyor, puanınız '
        .'olduğundan yüksek görünebilir.',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => ['sosyal'],
    'cetvel' => 'ikcu-2023-sosyal-docent',
    'notlar' => 'EK-A/2: ÜAK doçentlik unvanı; ilan edilen asgari puan şartının en az %80\'ini 1. '
        .'(en az bir makalede başlıca yazar olmak şartıyla), 3., 6., 7. ve 8. maddelerin en az '
        .'üçünden almak. Asgari puan yönergede sayı olarak verilmiyor.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma — Sosyal Bilimler', [
        $dil,
        $docentUnvani,
        Kalip::adet('Makalelerinizden en az 1\'inde başlıca yazar olmalısınız', ['A1'], 1, yazar: 'baslica', madde: 'EK-A/2'),
        Kalip::kIle('Puanınızın 1., 3., 6., 7. ve 8. maddelerin en az 3\'ünden gelmesi gerekiyor', 3, [
            Kalip::adet('Makale kalemlerinizden en az 1 faaliyet', ['A1'], 1, madde: 'EK-A/2'),
            Kalip::adet('Kitap kalemlerinizden en az 1 faaliyet', ['A3'], 1, madde: 'EK-A/2'),
            Kalip::adet('Bilimsel araştırma projesi kalemlerinizden en az 1 faaliyet', ['A6'], 1, madde: 'EK-A/2'),
            Kalip::adet('Bilimsel toplantı ve faaliyet görevlerinden en az 1 faaliyet', ['A7'], 1, madde: 'EK-A/2'),
            Kalip::adet('Eğitim öğretim faaliyetlerinden en az 1 faaliyet', ['A8'], 1, madde: 'EK-A/2'),
        ]),
        Kalip::hesaplanamiyor(
            'Kadro ilanında duyurulan asgari puanın en az %80\'ini almış olmak — asgari puan '
            .'yönergede sayı olarak verilmediği için hesaplanamıyor',
            'EK-A/2',
        ),
    ]),
];

$esikler[] = [
    'anahtar' => 'ikcu-sosyal-profesorluk',
    'aday_notu' => 'Doçentlik unvanınızı aldığınız başvuru döneminden sonraki çalışmalarınız '
        .'sayılıyor. Sosyal Bilimler alanında profesörlük için toplam en az 200 puan; bunun en az '
        .'100 puanının makale, kitap ve proje maddelerinin en az ikisinden gelmesi ve '
        .'makalelerinizden birinde başlıca yazar olmanız gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['sosyal'],
    'cetvel' => 'ikcu-2023-sosyal-profesor',
    'notlar' => 'EK-A/1: doçentlik unvanı alınan başvuru döneminden sonra, en az 100 puanı 1. (en az '
        .'bir makalede başlıca yazar olmak şartıyla), 3. ve 6. maddelerin en az ikisinden olmak '
        .'üzere asgari 200 puan.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma — Sosyal Bilimler', [
        $dil,
        ...$profesorOrtak,
        Kalip::adet('Makalelerinizden en az 1\'inde başlıca yazar olmalısınız', ['A1'], 1, yazar: 'baslica', donem: $DOCENTLIK, madde: 'EK-A/1'),
        Kalip::puanDan('Makale, kitap ve proje kalemlerinizden en az 100 puan', ['A-1-3-6'], 100, $DOCENTLIK, madde: 'EK-A/1'),
        Kalip::kIle('Bu 100 puanın makale, kitap ve proje maddelerinin en az 2\'sinden gelmesi gerekiyor', 2, [
            Kalip::adet('Makale kalemlerinizden en az 1 faaliyet', ['A1'], 1, donem: $DOCENTLIK, madde: 'EK-A/1'),
            Kalip::adet('Kitap kalemlerinizden en az 1 faaliyet', ['A3'], 1, donem: $DOCENTLIK, madde: 'EK-A/1'),
            Kalip::adet('Bilimsel araştırma projesi kalemlerinizden en az 1 faaliyet', ['A6'], 1, donem: $DOCENTLIK, madde: 'EK-A/1'),
        ]),
        Kalip::toplam(200, $DOCENTLIK),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// EK-B — FEN BİLİMLERİ ALANI
// ══════════════════════════════════════════════════════════════════════════

/** Q1/Q2 şartı ve "her eksik yayın için iki Q3/Q4" telafisi. */
$qKurali = fn (int $q12, string $madde): array => Kalip::veya(
    "SCI/SCI-E, SSCI veya AHCI dergilerinde Q1 ya da Q2 kategorisinde en az {$q12} yayınınız olmalı",
    [Kalip::adet("Q1 ya da Q2 kategorisinde en az {$q12} yayın", ['B1.a-Q1Q2'], $q12, madde: $madde)],
    telafi: Kalip::adet(
        'Q1/Q2 şartını sağlayamıyorsanız her eksik yayın yerine Q3 ya da Q4 kategorisinde 2 yayın (toplam '.($q12 * 2).')',
        ['B1.a-Q3Q4'], $q12 * 2, madde: $madde,
    ),
);

$esikler[] = [
    'anahtar' => 'ikcu-fen-dr',
    'aday_notu' => 'Fen Bilimleri alanında Dr. Öğretim Üyeliği için PUAN BARAJI YOK: en az iki '
        .'SCI/SCI-E/SSCI/AHCI makalesi (birinde Q1 veya Q2 ve başlıca yazarlık), Q1/Q2 şartı '
        .'sağlanamıyorsa en az üç Q3/Q4 yayını ve en az bir araştırma projesinde görev isteniyor.'
        .$YENIDEN.' Yeniden atanmada 1.a, 1.b ve 1.c maddelerinden en az 20/40/60/80 puan olmak '
        .'üzere toplam 40/80/120/160 puan sırasıyla 1, 2, 3 ve 4 yıllık atama sağlıyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['fen'],
    'cetvel' => 'ikcu-2023-fen',
    'notlar' => 'EK-B/3: Q1 veya Q2 kategorisine ait en az birinde başlıca yazar olmak koşuluyla en '
        .'az iki SCI/SCI-E/SSCI/AHCI makalesi; Q1/Q2 sağlanamazsa en az üç Q3/Q4 yayını; en az bir '
        .'TÜBİTAK, ulusal ya da uluslararası araştırma projesinde görev. Puan barajı yok.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma — Fen Bilimleri', [
        $dil,
        Kalip::veya('SCI/SCI-E, SSCI veya AHCI yayın koşulu', [
            Kalip::ve('Q1 veya Q2 kategorisinde başlıca yazarlık ve toplam 2 yayın', [
                Kalip::adet('Q1 ya da Q2 kategorisinde başlıca yazar olduğunuz en az 1 yayın', ['B1.a-Q1Q2'], 1, yazar: 'baslica', madde: 'EK-B/3'),
                Kalip::adet('SCI/SCI-E, SSCI veya AHCI dergilerinde toplam en az 2 makale', ['B1.a'], 2, madde: 'EK-B/3'),
            ]),
            Kalip::adet('Ya da Q3/Q4 kategorisinde en az 3 yayınınız olmalı', ['B1.a-Q3Q4'], 3, madde: 'EK-B/3'),
        ]),
        Kalip::adet('En az 1 TÜBİTAK, ulusal ya da uluslararası araştırma projesinde görev almış olmak', ['B7-HERHANGI'], 1, madde: 'EK-B/3'),
    ]),
];

$esikler[] = [
    'anahtar' => 'ikcu-fen-docentlik',
    'aday_notu' => 'Fen Bilimleri alanında doçentlik için PUAN BARAJI YOK: en az bir Q1/Q2 yayını '
        .'(sağlanamıyorsa iki Q3/Q4 yayını), bir TÜBİTAK ya da uluslararası proje görevi, iki '
        .'ulusal proje yürütücülüğü ve eğitim öğretim faaliyetlerinden 12 puan isteniyor. '
        .'Yükseköğretim kurumları dışından başvuruyorsanız yönerge ayrıca son beş yılda eğitim '
        .'öğretim faaliyetlerinden en az 8 puan istiyor; nereden başvurduğunuz profilden '
        .'okunamadığı için bu koşul burada uygulanmıyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => ['fen'],
    'cetvel' => 'ikcu-2023-fen',
    'notlar' => 'EK-B/2: ÜAK doçentlik unvanı; en az bir Q1/Q2 yayını (yoksa iki Q3/Q4); en az bir '
        .'TÜBİTAK ya da uluslararası projede görev ve en az iki diğer ulusal projede yürütücülük; '
        .'9. madde dipnotu doçentlik atamalarında 12 puanlık eğitim öğretim şartı koyuyor.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma — Fen Bilimleri', [
        $dil,
        $docentUnvani,
        $qKurali(1, 'EK-B/2'),
        Kalip::adet('En az 1 TÜBİTAK ya da uluslararası araştırma projesinde görev almış olmak', ['B7-TUBITAK-ULUSLARARASI'], 1, madde: 'EK-B/2'),
        Kalip::adet('En az 2 diğer ulusal araştırma projesinde (BAP, kamu kurumu) yürütücülük yapmış olmak', ['B7-ULUSAL-YURUTUCU'], 2, madde: 'EK-B/2'),
        Kalip::puanDan('Eğitim öğretim faaliyetlerinizden en az 12 puan', ['B9'], 12, madde: 'EK-B tablo 9. madde dipnotu'),
    ]),
];

$esikler[] = [
    'anahtar' => 'ikcu-fen-profesorluk',
    'aday_notu' => 'Doçentlik unvanınızı aldığınız başvuru döneminden sonraki çalışmalarınız '
        .'sayılıyor. Fen Bilimleri alanında profesörlük için toplam en az 200 puan, 1.a maddesinden '
        .'(SCI/SCI-E/SSCI/AHCI tam araştırma makalesi) en az 50 puan, en az iki Q1/Q2 yayını ve '
        .'tablonun 2., 3., 4. ve 10. maddeleri dışındaki her maddeden en az bir etkinlik '
        .'isteniyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['fen'],
    'cetvel' => 'ikcu-2023-fen',
    'notlar' => 'EK-B/1: doçentlik unvanı alınan başvuru döneminden sonra 2., 3., 4. ve 10. maddeler '
        .'hariç her maddeden en az bir etkinlik; en az iki Q1/Q2 yayını (yoksa her eksik yayın için '
        .'iki Q3/Q4); 1.a\'dan en az 50 puan ve bu gruptaki makalelerden en az birinde başlıca '
        .'yazarlık; toplam en az 200 puan; doçentlik sonrası en az bir TÜBİTAK ya da uluslararası '
        .'proje ve en az bir diğer ulusal projede yürütücülük. Tablo dipnotları: bilimsel toplantı '
        .'5 puan, eğitim öğretim 12 puan.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma — Fen Bilimleri', [
        $dil,
        ...$profesorOrtak,
        $qKurali(2, 'EK-B/1'),
        Kalip::adet('1.a kapsamındaki makalelerinizden en az 1\'inde başlıca yazar olmalısınız', ['B1.a'], 1, yazar: 'baslica', donem: $DOCENTLIK, madde: 'EK-B/1'),
        Kalip::puanDan('SCI/SCI-E, SSCI veya AHCI tam araştırma makalelerinizden en az 50 puan', ['B1.a'], 50, $DOCENTLIK, madde: 'EK-B/1'),
        Kalip::ve('Tablonun 2., 3., 4. ve 10. maddeleri dışındaki her maddeden en az bir etkinlik', [
            Kalip::adet('Makale kalemlerinizden en az 1 faaliyet', ['B1'], 1, donem: $DOCENTLIK, madde: 'EK-B/1'),
            Kalip::adet('Atıf kalemlerinizden en az 1 faaliyet', ['B5'], 1, donem: $DOCENTLIK, madde: 'EK-B/1'),
            Kalip::adet('Lisansüstü tez danışmanlığı kalemlerinizden en az 1 faaliyet', ['B6'], 1, donem: $DOCENTLIK, madde: 'EK-B/1'),
            Kalip::adet('Bilimsel araştırma projesi kalemlerinizden en az 1 faaliyet', ['B7'], 1, donem: $DOCENTLIK, madde: 'EK-B/1'),
            Kalip::adet('Bilimsel toplantı kalemlerinizden en az 1 faaliyet', ['B8'], 1, donem: $DOCENTLIK, madde: 'EK-B/1'),
            Kalip::adet('Eğitim öğretim kalemlerinizden en az 1 faaliyet', ['B9'], 1, donem: $DOCENTLIK, madde: 'EK-B/1'),
        ]),
        Kalip::adet('Doçentlik sonrası en az 1 TÜBİTAK ya da uluslararası araştırma projesinde görev almış olmak', ['B7-TUBITAK-ULUSLARARASI'], 1, donem: $DOCENTLIK, madde: 'EK-B/1'),
        Kalip::adet('Doçentlik sonrası en az 1 diğer ulusal araştırma projesinde yürütücülük yapmış olmak', ['B7-ULUSAL-YURUTUCU'], 1, donem: $DOCENTLIK, madde: 'EK-B/1'),
        Kalip::puanDan('Bilimsel toplantı kalemlerinizden en az 5 puan', ['B8'], 5, $DOCENTLIK, madde: 'EK-B tablo 8. madde dipnotu'),
        Kalip::puanDan('Eğitim öğretim faaliyetlerinizden en az 12 puan', ['B9'], 12, madde: 'EK-B tablo 9. madde dipnotu'),
        Kalip::toplam(200, $DOCENTLIK),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// EK-C — SAĞLIK BİLİMLERİ ALANI
// ══════════════════════════════════════════════════════════════════════════

$sosyalHizmetNotu = ' Sağlık Bilimleri Fakültesi Sosyal Hizmet Bölümü adaylarına yönerge '
    .'"Sosyal Bilimler Alanı" (EK-A) kriterlerini uyguluyor; bölüm bilgisi profilde tutulmadığı '
    .'için burada EK-C kriterleri gösteriliyor.';

/** EK-C'nin "1., 2., 5., 8. ve 9. maddelerin her birinden en az bir faaliyet" koşulu. */
$cFaaliyetler = fn (?array $donem, string $madde): array => Kalip::ve(
    '1., 2., 5., 8. ve 9. maddelerin her birinden en az bir faaliyet',
    [
        Kalip::adet('Uluslararası makale kalemlerinizden en az 1 faaliyet', ['C1'], 1, donem: $donem, madde: $madde),
        Kalip::adet('Ulusal makale kalemlerinizden en az 1 faaliyet', ['C2'], 1, donem: $donem, madde: $madde),
        Kalip::adet('Atıf kalemlerinizden en az 1 faaliyet', ['C5'], 1, donem: $donem, madde: $madde),
        Kalip::adet('Bilimsel toplantı kalemlerinizden en az 1 faaliyet', ['C8'], 1, donem: $donem, madde: $madde),
        Kalip::adet('Eğitim öğretim kalemlerinizden en az 1 faaliyet', ['C9'], 1, donem: $donem, madde: $madde),
    ],
);

$esikler[] = [
    'anahtar' => 'ikcu-saglik-dr',
    'aday_notu' => 'Sağlık Bilimleri alanında Dr. Öğretim Üyeliği için 1.a, 1.b ya da 3.a kapsamında '
        .'en az bir yayın ve toplamda en az 60 puan isteniyor.'.$sosyalHizmetNotu.$YENIDEN
        .' Yeniden atanmada 1.a veya 1.b kapsamında en az 20/30/40/50 puan olmak üzere toplam '
        .'50/60/70/80 puan sırasıyla 1, 2, 3 ve 4 yıllık atama sağlıyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['saglik'],
    'cetvel' => 'ikcu-2023-saglik',
    'notlar' => 'EK-C/3: 1.a, 1.b ve 3.a maddeleri kapsamında en az bir faaliyet; toplamda asgari '
        .'60 puan.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma — Sağlık Bilimleri', [
        $dil,
        Kalip::adet(
            'SCI/SCI-E/SSCI/AHCI ya da diğer uluslararası indeksli dergide özgün araştırma '
            .'makaleniz veya tezinizden üretilmiş bir SCI makaleniz olmalı',
            ['C1.a', 'C1.b', 'C3.a'], 1, madde: 'EK-C/3',
        ),
        Kalip::toplam(60),
    ]),
];

$esikler[] = [
    'anahtar' => 'ikcu-saglik-docentlik',
    'aday_notu' => 'Sağlık Bilimleri alanında doçentlik için toplam en az 150 puan, uluslararası ve '
        .'ulusal makale maddelerinin toplamından en az 100 puan, 1.a kapsamında başlıca yazarlık ve '
        .'1., 2., 5., 8., 9. maddelerin her birinden en az bir faaliyet isteniyor. DİKKAT: yönerge '
        .'metni eğitim öğretim faaliyetlerinden "en az 25 puan" derken aynı tablonun 9. madde '
        .'dipnotu bu maddeden EN FAZLA 15 puan alınabileceğini söylüyor; 25 puanlık eşik '
        .'sağlanamayacağı için burada ulaşılabilir en sıkı değer olan 15 puan uygulanıyor. '
        .'Başvurmadan önce üniversiteye teyit ettirin.'.$sosyalHizmetNotu,
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => ['saglik'],
    'cetvel' => 'ikcu-2023-saglik',
    'notlar' => 'EK-C/2: ÜAK doçentlik belgesi; doktora/uzmanlık sonrası 1., 2., 5., 8. ve 9. '
        .'maddelerin her birinden en az bir faaliyet; 1.a kapsamında en az bir makalede başlıca '
        .'yazarlık; 1. ve 2. maddelerin toplamından en az 100 puan; 9. maddeden (doktora sonrası) '
        .'en az 25 puan — ancak aynı maddenin tavanı 15 olduğu için 15 yazıldı; toplamda en az 150 '
        .'puan.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma — Sağlık Bilimleri', [
        $dil,
        $docentUnvani,
        $cFaaliyetler($DOKTORA, 'EK-C/2'),
        Kalip::adet('1.a kapsamındaki makalelerinizden en az 1\'inde başlıca yazar olmalısınız', ['C1.a'], 1, yazar: 'baslica', madde: 'EK-C/2'),
        Kalip::puanDan('Uluslararası ve ulusal makale kalemlerinizden en az 100 puan', ['C1-C2'], 100, madde: 'EK-C/2'),
        Kalip::puanDan('Doktora sonrası eğitim öğretim faaliyetlerinizden en az 15 puan', ['C9'], 15, $DOKTORA, madde: 'EK-C/2'),
        Kalip::toplam(150),
    ]),
];

$esikler[] = [
    'anahtar' => 'ikcu-saglik-profesorluk',
    'aday_notu' => 'Doçentlik başvurunuzu yaptığınız tarihten sonraki çalışmalarınız sayılıyor. '
        .'Sağlık Bilimleri alanında profesörlük için toplam en az 250 puan, 1.a kapsamında '
        .'doçentlik sonrası başlıca yazarlık ve 1., 2., 5., 8., 9. maddelerin her birinden en az '
        .'bir faaliyet isteniyor.'.$sosyalHizmetNotu,
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['saglik'],
    'cetvel' => 'ikcu-2023-saglik',
    'notlar' => 'EK-C/1: doçent unvanından sonra en az 3 yılı yükseköğretim kurumlarında olmak üzere '
        .'alanında 5 yıl çalışmak; 1., 2., 5., 8. ve 9. maddelerin her birinden en az bir faaliyet; '
        .'doçentlik sonrası 1.a kapsamında en az bir makalede başlıca yazarlık; doçentlik başvurusu '
        .'tarihinden sonra toplamda en az 250 puan. Tablo 9. madde dipnotu profesörlükte 12 puan '
        .'eğitim öğretim şartı koyuyor.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma — Sağlık Bilimleri', [
        $dil,
        ...$profesorOrtak,
        Kalip::beyan(
            'Doçent unvanını aldıktan sonra en az 3 yılı yükseköğretim kurumlarında olmak üzere '
            .'alanınızda 5 yıl çalışmış olmak',
            'EK-C/1',
        ),
        $cFaaliyetler($DOCENTLIK, 'EK-C/1'),
        Kalip::adet('Doçentlik sonrası 1.a kapsamındaki makalelerinizden en az 1\'inde başlıca yazar olmalısınız', ['C1.a'], 1, yazar: 'baslica', donem: $DOCENTLIK, madde: 'EK-C/1'),
        Kalip::puanDan('Eğitim öğretim faaliyetlerinizden en az 12 puan', ['C9'], 12, madde: 'EK-C tablo 9. madde dipnotu'),
        Kalip::toplam(250, $DOCENTLIK),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// EK-D — GÜZEL SANATLAR ALANI (özel şartlar alt disipline göre)
// ══════════════════════════════════════════════════════════════════════════

$PLASTIK = 'Geleneksel Türk Sanatları, Plastik Sanatlar, Tasarım, Sinema';
$MUZIK = 'Müzik';

/** EK-D'nin "1, 2, 4, 5, 6, 8 ve 9'uncu maddelerin her birinden en az bir faaliyet" koşulu. */
$dFaaliyetler = fn (?array $donem, string $madde): array => Kalip::ve(
    'Genel başvuru şartlarının 1., 2., 4., 5., 6., 8. ve 9. maddelerinin her birinden en az bir faaliyet',
    [
        Kalip::adet('Uluslararası makale kalemlerinizden en az 1 faaliyet', ['D-G1'], 1, donem: $donem, madde: $madde),
        Kalip::adet('Ulusal makale kalemlerinizden en az 1 faaliyet', ['D-G2'], 1, donem: $donem, madde: $madde),
        Kalip::adet('Kitap kalemlerinizden en az 1 faaliyet', ['D-G4'], 1, donem: $donem, madde: $madde),
        Kalip::adet('Atıf kalemlerinizden en az 1 faaliyet', ['D-G5'], 1, donem: $donem, madde: $madde),
        Kalip::adet('Lisansüstü tez danışmanlığı kalemlerinizden en az 1 faaliyet', ['D-G6'], 1, donem: $donem, madde: $madde),
        Kalip::adet('Bilimsel toplantı kalemlerinizden en az 1 faaliyet', ['D-G8'], 1, donem: $donem, madde: $madde),
        Kalip::adet('Eğitim öğretim kalemlerinizden en az 1 faaliyet', ['D-G9'], 1, donem: $donem, madde: $madde),
    ],
);

/**
 * Müzik alanının özel şartı: 2.a, 3.a, 4.a, 5.a, 6.a, 7.a ve 9.a bentlerinin
 * en az birinden iki etkinlik. Cetvelde bu bentler eser türüne göre
 * birleştirildiği için beş satır sayılıyor.
 *
 * @return array<string, mixed>
 */
$muzikIkiEtkinlik = fn (string $madde): array => Kalip::veya(
    'Müzik alanında 2.a, 3.a, 4.a, 5.a, 6.a, 7.a ve 9.a bentlerinin en az birinden 2 etkinlik',
    [
        Kalip::adet('Özgün eser üretiminden en az 2 etkinlik', ['D-O2.a'], 2, madde: $madde),
        Kalip::adet('Albüm yayımlamaktan en az 2 etkinlik', ['D-O3.b'], 2, madde: $madde),
        Kalip::adet('Şeflikten en az 2 etkinlik', ['D-O6.a'], 2, madde: $madde),
        Kalip::adet('Opera solistliğinden en az 2 etkinlik', ['D-O9.a'], 2, madde: $madde),
        Kalip::adet('Opera rejisörlüğünden en az 2 etkinlik', ['D-O9.b'], 2, madde: $madde),
    ],
);

$dNotu = 'DİKKAT: EK-D\'nin özel başvuru şartlarında puanı bir PORTFÖYE bağlı satırlar (en az on '
    .'eserlik kişisel sergi, dört saatlik şeflik kaydı, iki opera eseri gibi) eser başına '
    .'bölünemediği için etkinlik başına en düşük okunabilir değerden sayılıyor; alt disiplin '
    .'kayıtta tutulmadığı için solo ve karma konser icracılığı da en düşük değerden (5 puan) '
    .'sayılıyor. Sanatsal puanınız bu yüzden olduğundan DÜŞÜK görünebilir.';

foreach ([
    ['plastik', $PLASTIK, 'plastik'],
    ['muzik', $MUZIK, 'muzik'],
] as [$anahtar, $birim, $tip]) {
    $ozelDr = $tip === 'plastik'
        ? [
            Kalip::adet('Plastik sanatlarda 1. madde kapsamında en az 3 etkinlik', ['D-O1'], 3, madde: 'EK-D/3-b'),
            Kalip::puanDan('Plastik sanatlarda 1. madde kapsamında en az 50 puan', ['D-O1'], 50, madde: 'EK-D/3-b'),
        ]
        : [
            $muzikIkiEtkinlik('EK-D/3-b'),
            Kalip::puanDan('Müzik alanında özel başvuru şartlarından en az 50 puan', ['D-MUZIK'], 50, madde: 'EK-D/3-b'),
        ];

    $ozelDocent = $tip === 'plastik'
        ? [Kalip::puanDan('Plastik sanatlarda 1. madde kapsamında en az 60 puan', ['D-O1'], 60, madde: 'EK-D/2-c')]
        : [
            $muzikIkiEtkinlik('EK-D/2-c'),
            Kalip::puanDan('Müzik alanında özel başvuru şartlarından en az 60 puan', ['D-MUZIK'], 60, madde: 'EK-D/2-c'),
        ];

    $ozelProfesor = $tip === 'plastik'
        ? [
            Kalip::adet('Plastik sanatlarda kişisel sergi türünden en az 2 etkinlik', ['D-O1.a'], 2, madde: 'EK-D/1-c'),
            Kalip::puanDan('Plastik sanatlarda 1. madde toplamında en az 100 puan', ['D-O1'], 100, madde: 'EK-D/1-c'),
        ]
        : [
            $muzikIkiEtkinlik('EK-D/1-c'),
            Kalip::puanDan('Müzik alanında özel başvuru şartlarından en az 100 puan', ['D-MUZIK'], 100, madde: 'EK-D/1-c'),
        ];

    $esikler[] = [
        'anahtar' => "ikcu-gsf-{$anahtar}-dr",
        'aday_notu' => "Güzel Sanatlar alanında ({$birim}) Dr. Öğretim Üyeliği için genel başvuru "
            .'şartlarının 1., 2. ve 8. maddelerinin her birinden en az bir faaliyet, 1. ve 2. '
            .'maddelerin toplamından en az 40 puan ve özel başvuru şartlarından en az 50 puan '
            .'isteniyor. '.$dNotu.$YENIDEN.' Yeniden atanmada genel ve özel şartların her birinden '
            .'en az 15/20/30/40 puan olmak üzere toplam 30/40/60/80 puan sırasıyla 1, 2, 3 ve 4 '
            .'yıllık atama sağlıyor.',
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['guzel_sanatlar'],
        'birim' => $birim,
        'cetvel' => 'ikcu-2023-gsf',
        'notlar' => "EK-D/3 ({$birim}): genel başvuru şartlarından 1., 2. ve 8. maddelerin her "
            .'birinden en az bir faaliyet ve 1. ile 2. maddelerin toplamından en az 40 puan; özel '
            .'başvuru şartlarından en az 50 puan.',
        'sart' => Kalip::ve("Doktor Öğretim Üyesi kadrosuna atanma — Güzel Sanatlar ({$birim})", [
            $dil,
            Kalip::ve('Genel başvuru şartlarının 1., 2. ve 8. maddelerinin her birinden en az bir faaliyet', [
                Kalip::adet('Uluslararası makale kalemlerinizden en az 1 faaliyet', ['D-G1'], 1, madde: 'EK-D/3-a'),
                Kalip::adet('Ulusal makale kalemlerinizden en az 1 faaliyet', ['D-G2'], 1, madde: 'EK-D/3-a'),
                Kalip::adet('Bilimsel toplantı kalemlerinizden en az 1 faaliyet', ['D-G8'], 1, madde: 'EK-D/3-a'),
            ]),
            Kalip::puanDan('Uluslararası ve ulusal makale kalemlerinizden en az 40 puan', ['D-G1-G2'], 40, madde: 'EK-D/3-a'),
            ...$ozelDr,
        ]),
    ];

    $esikler[] = [
        'anahtar' => "ikcu-gsf-{$anahtar}-docentlik",
        'aday_notu' => 'Doktora ya da sanatta yeterlilik unvanınızı aldıktan sonraki çalışmalarınız '
            ."sayılıyor. Güzel Sanatlar alanında ({$birim}) doçentlik için genel başvuru "
            .'şartlarından en az 70 puan, yedi maddenin her birinden en az bir faaliyet ve özel '
            .'başvuru şartlarından en az 60 puan isteniyor. '.$dNotu,
        'universite' => $UNIVERSITE,
        'kadro' => 'docentlik',
        'alan' => ['guzel_sanatlar'],
        'birim' => $birim,
        'cetvel' => 'ikcu-2023-gsf',
        'notlar' => "EK-D/2 ({$birim}): ÜAK doçentlik unvanı; doktora/sanatta yeterlilik sonrası 1. "
            .'maddenin a ya da b fıkrasından en az bir veya c fıkrasından en az iki yayın, 2.a\'dan '
            .'en az bir yayın, 4. madde kapsamında en az bir yayın; 1, 2, 4, 5, 6, 8 ve 9. '
            .'maddelerin her birinden en az bir faaliyet; genel şartlardan toplam en az 70 puan; '
            .'özel şartlardan en az 60 puan.',
        'sart' => Kalip::ve("Doçent kadrosuna atanma — Güzel Sanatlar ({$birim})", [
            $dil,
            $docentUnvani,
            Kalip::veya('Uluslararası makale koşulu', [
                Kalip::adet('SCI/SCIE/SSCI/AHCI ya da ESCI/Scopus/ERIC dergilerinde en az 1 makale', ['D-G1.ab'], 1, donem: $DOKTORA, madde: 'EK-D/2-b'),
                Kalip::adet('Ya da diğer uluslararası indeksli dergilerde en az 2 makale', ['D-G1.c'], 2, donem: $DOKTORA, madde: 'EK-D/2-b'),
            ]),
            Kalip::adet('ULAKBİM TR Dizin kapsamındaki dergilerde en az 1 makale', ['D-G2.a'], 1, donem: $DOKTORA, madde: 'EK-D/2-b'),
            Kalip::adet('Kitap kalemlerinden en az 1 yayında yazar olmak', ['D-G4'], 1, donem: $DOKTORA, madde: 'EK-D/2-b'),
            $dFaaliyetler($DOKTORA, 'EK-D/2-b'),
            Kalip::toplam(70, $DOKTORA, ['D-GENEL'], 'Genel başvuru şartları'),
            ...$ozelDocent,
        ]),
    ];

    $esikler[] = [
        'anahtar' => "ikcu-gsf-{$anahtar}-profesorluk",
        'aday_notu' => 'Doçentlik başvurunuzu yaptığınız tarihten sonraki çalışmalarınız sayılıyor. '
            ."Güzel Sanatlar alanında ({$birim}) profesörlük için genel başvuru şartlarından en az "
            .'140 puan, yedi maddenin her birinden en az bir faaliyet ve özel başvuru şartlarından '
            .'en az 100 puan isteniyor. '.$dNotu,
        'universite' => $UNIVERSITE,
        'kadro' => 'profesorluk',
        'alan' => ['guzel_sanatlar'],
        'birim' => $birim,
        'cetvel' => 'ikcu-2023-gsf',
        'notlar' => "EK-D/1 ({$birim}): doçent unvanından sonra alanında en az beş yıl, bunun en az "
            .'üç yılında yükseköğretim kurumunda tam zamanlı görev ve en az iki yıl ders vermek; '
            .'doçentlik başvurusundan sonra 1.a veya 1.b\'den en az iki ya da 1.c\'den en az dört, '
            .'2.a\'dan en az iki, 4.a\'dan en az bir ya da 4.c\'den en az iki yayında başlıca '
            .'yazarlık; 1, 2, 4, 5, 6, 8 ve 9. maddelerin her birinden en az bir faaliyet; genel '
            .'şartlardan en az 140 puan; özel şartlardan en az 100 puan.',
        'sart' => Kalip::ve("Profesör kadrosuna atanma — Güzel Sanatlar ({$birim})", [
            $dil,
            ...$profesorOrtak,
            Kalip::beyan(
                'Doçent unvanını aldıktan sonra alanınızda en az beş yıl çalışmış olmak; bu sürenin '
                .'en az üç yılında yükseköğretim kurumunda tam zamanlı görev yapmış ve en az iki '
                .'yıl teorik ya da uygulamalı ders vermiş olmak',
                'EK-D/1-a',
            ),
            Kalip::veya('Başlıca yazar olduğunuz uluslararası makale koşulu', [
                Kalip::adet('SCI/SCIE/SSCI/AHCI ya da ESCI/Scopus/ERIC dergilerinde başlıca yazar olduğunuz en az 2 makale', ['D-G1.ab'], 2, yazar: 'baslica', donem: $DOCENTLIK, madde: 'EK-D/1-b'),
                Kalip::adet('Ya da diğer uluslararası indeksli dergilerde başlıca yazar olduğunuz en az 4 makale', ['D-G1.c'], 4, yazar: 'baslica', donem: $DOCENTLIK, madde: 'EK-D/1-b'),
            ]),
            Kalip::adet('ULAKBİM TR Dizin dergilerinde başlıca yazar olduğunuz en az 2 makale', ['D-G2.a'], 2, yazar: 'baslica', donem: $DOCENTLIK, madde: 'EK-D/1-b'),
            Kalip::veya('Başlıca yazar olduğunuz kitap koşulu', [
                Kalip::adet('Uluslararası yayınevi kitabınızda başlıca yazar olmak', ['D-G4.a'], 1, yazar: 'baslica', donem: $DOCENTLIK, madde: 'EK-D/1-b'),
                Kalip::adet('Ya da uluslararası yayınevi kitaplarında başlıca yazar olduğunuz en az 2 bölüm', ['D-G4.c'], 2, yazar: 'baslica', donem: $DOCENTLIK, madde: 'EK-D/1-b'),
            ]),
            $dFaaliyetler($DOCENTLIK, 'EK-D/1-b'),
            Kalip::toplam(140, $DOCENTLIK, ['D-GENEL'], 'Genel başvuru şartları'),
            ...$ozelProfesor,
        ]),
    ];
}

return $esikler;
