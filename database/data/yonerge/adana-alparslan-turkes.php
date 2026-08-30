<?php

/**
 * ADANA ALPARSLAN TÜRKEŞ BİLİM VE TEKNOLOJİ ÜNİVERSİTESİ — Öğretim Üyeliğine
 * Yükseltilme ve Atanma Kriterleri Yönergesi
 * Kaynak: pdf/1785505475250.Adana Alparslan Türkeş Bilim ve Teknoloji
 * Üniversitesi Kriter Değişikliği.pdf (15 sayfa, Senato 15/05/2026, 2026/13-3)
 *
 * ── YAPI: ÜÇ FAKÜLTE GRUBU × DÖRT KADRO ──
 * Madde 7-10 her kadroyu üç fakülte grubuna ayırıyor:
 *   (a) Mühendislik, Bilgisayar ve Bilişim, Havacılık ve Uzay Bilimleri
 *       Fakülteleri + Bilişim Teknolojileri MYO   → alan: mühendislik
 *   (b) İktisadi, İdari ve Sosyal Bilimler Fakültesi + Yabancı Diller YO
 *       (Türk Dili ve Edebiyatı, Mütercim-Tercümanlık, ÜAK Hukuk temel
 *       alanından doçentler de bu grupta anılıyor) → alan: sosyal, filoloji, hukuk
 *   (c) Mimarlık ve Tasarım Fakültesi              → alan: mimarlık
 *
 * Üç grubun parantez içi "Türk Dili ve Edebiyatı/Mütercim-Tercümanlık/ÜAK
 * Hukuk" istisnaları neredeyse aynı sayılarla ama küçük farklarla (madde
 * 9/3'te aynı sayı, madde 10/3'te 2 yayın→1 yayın ve A1-A6→A1-A4 farkı)
 * tekrarlanıyor; alan bilgisiyle bu üç bölümü ayrı işaretlemek mümkün
 * olmadığı için (İİSBF içindeki bir bölüm mü yoksa ayrı mı belli değil) GENEL
 * (daha zor) kural herkese uygulandı — "eksik say" yönünde güvenli bir
 * sadeleştirme.
 *
 * ── YAZAR FORMÜLÜ VE MADDE KODLARI CETVELDE ──
 * Gerekçe, alt kod açıklamaları ve girilmeyen kalemler cetvel dosyasında.
 *
 * ── "BAŞLICA VEYA İKİNCİ YAZAR" DARALTILDI ──
 * Madde 9/3 ve 10/3'ün İİSBF için istediği "başlıca VEYA İKİNCİ yazar olmak"
 * şartı, motorun `adet()` yazar filtresi yalnızca tek/ilk/başlıca birleşimini
 * tanıdığı için (2. yazarı ayrı bir seçenek olarak süzemiyor) `baslica`
 * ile daraltıldı — tek yazarlı, ilk yazarlı veya sorumlu yazarlı eserler
 * sayılıyor, 2. yazarlı olup üç rolden hiçbirine girmeyen eserler
 * sayılmıyor. "Eksik say" yönünde güvenli bir sapma.
 *
 * ── DOÇENTLİK: TÜM ARAŞTIRMA DOKTORA SONRASI ──
 * Madde 9'un giriş cümlesi ("Doktora derecesini aldıktan sonra yapılmış
 * Ek-II'deki tabloda yer alan faaliyetlerden…") yalnızca alt şartları değil
 * TOPLAM barajını da doktora sonrası dönemine bağlıyor — korpustaki çoğu
 * yönergeden farklı olarak burada TOPLAM da dönem kısıtlı.
 *
 * ── PROFESÖRLÜK: "DOÇENTLİK ESER İNCELEME BAŞVURU TARİHİ" ──
 * Madde 10 dönemi "doçentlik unvanı" değil "doçentlik ESER İNCELEME BAŞVURU
 * TARİHİ" olarak tanımlıyor (ÜAK'a başvuru anı, unvanın alındığı tarihten
 * önce olabilir). Motorda böyle bir referans tarihi yok; en yakın karşılık
 * olan `DOCENTLIK_SONRASI` (unvanın alındığı tarih) kullanıldı — aday başvuru
 * ile unvan arasındaki dönemde yayımladığı eserler burada SAYILMAYABİLİR,
 * yani koşul o dar pencerede OLDUĞUNDAN ZOR görünebilir.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Madde 8/3: yeniden atanma koşullarının ve toplam puanın en az yarısını
 *       sağlayan Dr. Öğr. Üyesi'nin Rektör onayıyla bir defaya mahsus
 *       yeniden atanabilmesi — tamamen takdire bağlı, eşik yazılmadı.
 *   Madde 8/4: ÜAK doçent unvanı alan Dr. Öğr. Üyesi için bir defaya mahsus
 *       yeniden atanma kriterlerinin aranmaması — "unvanı yeni aldı" durumu
 *       profilde yok.
 *   Madde 9/4 ve 10/4'ün "yabancı dilde eğitim yapılan bölümlerde en az bir
 *       makalenin eğitim dilinde yayımlanmış olması" şartı (Mimarlık) —
 *       bölümün eğitim dili profilde yok, girilmedi.
 *   Madde 5/3-4: yabancı dil sınavı şartı (YÖKDİL/YDS 65, dil bölümlerinde
 *       95) — birimin %100 yabancı dilde eğitim verip vermediği ve adayın
 *       başvurduğu bölümün "dil bölümü" olup olmadığı profilde yok; genel
 *       bir YDS eşiği yazmak yanlış birimlere yanlış eşik göstermek olurdu,
 *       bu yüzden hiç yazılmadı (aday notunda anlatıldı).
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/adana-alparslan-turkes-2026.php
 */

use App\Services\Scoring\Sart\Kalip;

$CETVEL = 'adana-alparslan-turkes-2026';
$UNIVERSITE = 'Adana Alparslan Türkeş Bilim ve Teknoloji Üniversitesi';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;

$ydsNotu = 'Yönerge %100 yabancı dilde eğitim yapılmayan bölümlerde YÖKDİL veya YDS\'den en az '
    .'65 puan (Yabancı Diller Yüksekokulu ve Mütercim-Tercümanlık bölümüne başvuranlarda en az '
    .'95 puan) istiyor; hangi birimlerin %100 yabancı dilde eğitim verdiği ve hangi bölümün dil '
    .'bölümü sayıldığı profilde tutulmadığı için bu şart eşiğe hiç yazılmadı, başvurmadan önce '
    .'üniversiteye teyit ettirin.';

$esikler = [];

// ══════════════════════════════════════════════════════════════════════════
// (a) MÜHENDİSLİK, BİLGİSAYAR VE BİLİŞİM, HAVACILIK VE UZAY BİLİMLERİ
//     FAKÜLTELERİ + BİLİŞİM TEKNOLOJİLERİ MESLEK YÜKSEKOKULU
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'atu-muhendislik-dr',
    'aday_notu' => 'A1 kategorisinde (SCI-E/SSCI dergisi, herhangi bir çeyreklik) en az 1 '
        .'yayınında başlıca yazar (tek yazar, ilk yazar veya sorumlu yazar) olmalısınız; A1 ve '
        .'A3 kalemlerinden en az 150 puan ve tüm faaliyetlerden toplamda en az 300 puan '
        .'gerekiyor. '.$ydsNotu,
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['muhendislik'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 7/1-a: A1 kategorisinde en az bir yayında başlıca yazar; A1 ve A3\'ten '
        .'en az 150 puan; toplam en az 300 puan.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma', [
        Kalip::beyan('İlgili alanda doktora derecesine sahip olmak', 'Madde 7/1-a'),
        Kalip::adet('A1 kategorisinde en az 1 yayında başlıca yazar olmalısınız', ['A1'], 1, yazar: 'baslica', madde: 'Madde 7/1-a/1'),
        Kalip::puanDan('A1 ve A3 kalemlerinizden en az 150 puan', ['A1-A3'], 150, madde: 'Madde 7/1-a/1'),
        Kalip::toplam(300),
    ]),
];

$esikler[] = [
    'anahtar' => 'atu-muhendislik-dr-yeniden',
    'aday_notu' => 'A1, A3 ve A4 kalemlerinden en az 100 puan ve tüm faaliyetlerden toplamda '
        .'en az 250 puan gerekiyor. Bu koşulları sağlayamazsanız yeniden atanma koşullarının ve '
        .'toplam puanın en az yarısını sağlamanız hâlinde Rektör bir defaya mahsus '
        .'atayabiliyor; bu istisna takdire bağlı olduğu için eşiğe yazılmadı.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => ['muhendislik'],
    'cetvel' => $CETVEL,
    'notlar' => "Madde 8/1-a: A1, A3, A4'ten en az 100 puan; toplam en az 250 puan.",
    'sart' => Kalip::ve('Doktor Öğretim Üyeliğine yeniden atanma', [
        Kalip::puanDan('A1, A3 ve A4 kalemlerinizden en az 100 puan', ['A1-A3-A4'], 100, madde: 'Madde 8/1-a'),
        Kalip::toplam(250),
    ]),
];

$esikler[] = [
    'anahtar' => 'atu-muhendislik-docent',
    'aday_notu' => 'Doktora unvanınızdan SONRAKİ çalışmalarınıza bakılıyor: A1 kategorisinde Q1, '
        .'Q2 veya Q3 çeyreklikte en az 1 yayınında başlıca yazar olmalısınız; aynı çeyreklik '
        .'aralığından en az 250 puan, atıf (K) kaleminden en az 10 puan ve doktora sonrası '
        .'faaliyetlerinizin toplamından en az 500 puan gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => ['muhendislik'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 9/2: doktora sonrası A1(Q1-Q3)\'te en az 1 başlıca yazarlı yayın; A1(Q1-'
        .'Q3)\'ten en az 250 puan; K\'dan en az 10 puan; doktora sonrası toplam en az 500 puan.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma', [
        Kalip::beyan('ÜAK doçentlik belgesine sahip olmak', 'Madde 9/1'),
        Kalip::adet(
            'Doktora unvanınızdan sonra A1 kategorisinde Q1, Q2 veya Q3 çeyreklikte en az 1 yayında başlıca yazar olmalısınız',
            ['A1-Q1-Q2-Q3'], 1, yazar: 'baslica', donem: $DOKTORA, madde: 'Madde 9/2-a/1',
        ),
        Kalip::puanDan(
            'Doktora unvanınızdan sonra A1 kategorisinde Q1, Q2 veya Q3 çeyreklikteki yayınlarınızdan en az 250 puan',
            ['A1-Q1-Q2-Q3'], 250, $DOKTORA, madde: 'Madde 9/2-a/2',
        ),
        Kalip::puanDan('Atıf kalemlerinizden en az 10 puan', ['K'], 10, madde: 'Madde 9/2-a/3'),
        Kalip::toplam(500, $DOKTORA),
    ]),
];

$esikler[] = [
    'anahtar' => 'atu-muhendislik-profesor',
    'aday_notu' => 'Doçentlik unvanınızdan SONRAKİ çalışmalarınıza bakılıyor: A1 kategorisinde '
        .'Q1, Q2 veya Q3 çeyreklikte en az 1 yayınında başlıca yazar olmalısınız; aynı '
        .'çeyreklik aralığından en az 300 puan, atıf (K) kaleminden en az 20 puan ve doçentlik '
        .'sonrası faaliyetlerinizin toplamından en az 600 puan gerekiyor. Yönerge dönemi '
        .'"doçentlik eser inceleme başvuru tarihi" olarak tanımlıyor; motorda en yakın karşılık '
        .'doçentlik unvanınızın alındığı tarih, o yüzden başvuru ile unvan arasındaki '
        .'çalışmalarınız burada sayılmayabilir.',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['muhendislik'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 10/2: doçentlik eser inceleme başvurusu sonrası A1(Q1-Q3)\'te en az 1 '
        .'başlıca yazarlı yayın; A1(Q1-Q3)\'ten en az 300 puan; K\'dan en az 20 puan; '
        .'doçentlik sonrası toplam en az 600 puan.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma', [
        Kalip::beyan('Doçentlik unvanına sahip olmak ve 2547 sayılı Kanun\'un 26. maddesindeki koşulları sağlamak', 'Madde 10/1'),
        Kalip::adet(
            'Doçentlik unvanınızdan sonra A1 kategorisinde Q1, Q2 veya Q3 çeyreklikte en az 1 yayında başlıca yazar olmalısınız',
            ['A1-Q1-Q2-Q3'], 1, yazar: 'baslica', donem: $DOCENTLIK, madde: 'Madde 10/2-a/1',
        ),
        Kalip::puanDan(
            'Doçentlik unvanınızdan sonra A1 kategorisinde Q1, Q2 veya Q3 çeyreklikteki yayınlarınızdan en az 300 puan',
            ['A1-Q1-Q2-Q3'], 300, $DOCENTLIK, madde: 'Madde 10/2-a/2',
        ),
        Kalip::puanDan('Atıf kalemlerinizden en az 20 puan', ['K'], 20, madde: 'Madde 10/2-a/3'),
        Kalip::toplam(600, $DOCENTLIK),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// (b) İKTİSADİ, İDARİ VE SOSYAL BİLİMLER FAKÜLTESİ + YABANCI DİLLER
//     YÜKSEKOKULU
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'atu-iisbf-dr',
    'aday_notu' => 'A1, A2, A3 veya A4 kategorilerinden en az 1 yayınında başlıca yazar '
        .'olmalısınız; aynı kategorilerden en az 120 puan ve tüm faaliyetlerden toplamda en '
        .'az 240 puan gerekiyor. '.$ydsNotu,
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['sosyal', 'filoloji', 'hukuk'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 7/1-b: A1-A4\'ten en az bir yayında başlıca yazar; A1-A4\'ten en az '
        .'120 puan; toplam en az 240 puan.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma', [
        Kalip::beyan('İlgili alanda doktora derecesine sahip olmak', 'Madde 7/1-b'),
        Kalip::adet('SCI-Expanded, SSCI, AHCI, ESCI, Scopus ve TR Dizin dergilerindeki yayınlarınızdan en az 1 tanesinde başlıca yazar olmalısınız', ['A1-A2-A3-A4'], 1, yazar: 'baslica', madde: 'Madde 7/1-b/1'),
        Kalip::puanDan('SCI-Expanded, SSCI, AHCI, ESCI, Scopus ve TR Dizin dergilerindeki yayınlarınızdan en az 120 puan', ['A1-A2-A3-A4'], 120, madde: 'Madde 7/1-b/1'),
        Kalip::toplam(240),
    ]),
];

$esikler[] = [
    'anahtar' => 'atu-iisbf-dr-yeniden',
    'aday_notu' => 'SCI-Expanded, SSCI, AHCI, ESCI, Scopus ve TR Dizin dergilerindeki yayınlarınızdan en az 60 puan ve tüm '
        .'faaliyetlerden toplamda en az '
        .'160 puan gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => ['sosyal', 'filoloji', 'hukuk'],
    'cetvel' => $CETVEL,
    'notlar' => "Madde 8/1-b: A1-A4'ten en az 60 puan; toplam en az 160 puan.",
    'sart' => Kalip::ve('Doktor Öğretim Üyeliğine yeniden atanma', [
        Kalip::puanDan('SCI-Expanded, SSCI, AHCI, ESCI, Scopus ve TR Dizin dergilerindeki yayınlarınızdan en az 60 puan', ['A1-A2-A3-A4'], 60, madde: 'Madde 8/1-b'),
        Kalip::toplam(160),
    ]),
];

$esikler[] = [
    'anahtar' => 'atu-iisbf-docent',
    'aday_notu' => 'Doktora unvanınızdan SONRAKİ çalışmalarınıza bakılıyor: dizinli '
        .'dergilerdeki yayınlarınızdan en az 2 tanesinde başlıca yazar olmalısınız; makale '
        .'kalemlerinizden en az 200 puan; kitap kalemlerinizden en az 1 yayınınız olmalı (bu '
        .'kalemden en fazla 150 puan sayılıyor); bildirilerinizden en az 50 puan (en fazla 100 '
        .'puan sayılıyor); atıf kalemlerinizden en az 10 puan ve doktora sonrası toplamdan en '
        .'az 450 '
        .'puan gerekiyor. Türk Dili ve Edebiyatı, Mütercim-Tercümanlık ve ÜAK Hukuk temel '
        .'alanından doçentlik alanlar için yönerge biraz daha dar bir küme tanımlıyor; bu eşik '
        .'genel (daha geniş) kümeyi kullanıyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => ['sosyal', 'filoloji', 'hukuk'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 9/3: doktora sonrası A1-A3\'ten en az 2 (adet(1) ile daraltıldı, gerekçe '
        .'dosya başlığında) başlıca yazarlı yayın; A1-A6\'dan en az 200 puan; D1-D4\'ten en az '
        .'1 yayın (D grubu tavanı 150); B veya C\'den en az 50 puan (tavan 100); K\'dan en az '
        .'10 puan; doktora sonrası toplam en az 450 puan.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma', [
        Kalip::beyan('ÜAK doçentlik belgesine sahip olmak', 'Madde 9/1'),
        Kalip::adet(
            'Doktora unvanınızdan sonra A1, A2 veya A3 kategorisinde en az 1 yayında başlıca yazar olmalısınız',
            ['A1-A2-A3'], 1, yazar: 'baslica', donem: $DOKTORA, madde: 'Madde 9/3-a/1',
        ),
        Kalip::puanDan(
            'Doktora unvanınızdan sonra sci-expanded, ssci, ahci, esci, scopus ve tr dizin dergilerindeki yayınlarınızdan en az 200 puan',
            ['A1-A2-A3-A4-A5-A6'], 200, $DOKTORA, madde: 'Madde 9/3-a/2',
        ),
        Kalip::adet(
            'Doktora unvanınızdan sonra kitap kalemlerinizden en az 1 yayınınız olmalı',
            ['D1-D2-D3-D4'], 1, donem: $DOKTORA, madde: 'Madde 9/3-a/3',
        ),
        Kalip::puanDan(
            'Doktora unvanınızdan sonra bildiri (uluslararası veya ulusal) kalemlerinizden en az 50 puan',
            ['B-C'], 50, $DOKTORA, madde: 'Madde 9/3-a/4',
        ),
        Kalip::puanDan('Atıf kalemlerinizden en az 10 puan', ['K'], 10, madde: 'Madde 9/3-a/5'),
        Kalip::toplam(450, $DOKTORA),
    ]),
];

$esikler[] = [
    'anahtar' => 'atu-iisbf-profesor',
    'aday_notu' => 'Doçentlik unvanınızdan SONRAKİ çalışmalarınıza bakılıyor: en az biri '
        .'SCI-Expanded, SSCI ya da AHCI dergisinde olmak üzere, dizinli dergilerdeki '
        .'yayınlarınızdan en az 2 tanesinde başlıca yazar olmalısınız; makale kalemlerinizden '
        .'en az 250 puan; bildirilerinizden en az 50 puan (en fazla 100 puan sayılıyor); atıf '
        .'kalemlerinizden en az 20 puan ve doçentlik sonrası '
        .'toplamdan en az 600 puan gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['sosyal', 'filoloji', 'hukuk'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 10/3: doçentlik sonrası A1-A3\'ten en az 2 başlıca yazarlı yayın (adet(1) '
        .'ile daraltıldı), bunlardan en az biri A1 veya A2\'den; A1-A6\'dan en az 250 puan; B '
        .'veya C\'den en az 50 puan (tavan 100); K\'dan en az 20 puan; doçentlik sonrası toplam '
        .'en az 600 puan.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma', [
        Kalip::beyan('Doçentlik unvanına sahip olmak ve 2547 sayılı Kanun\'un 26. maddesindeki koşulları sağlamak', 'Madde 10/1'),
        Kalip::adet(
            'Doçentlik unvanınızdan sonra A1, A2 veya A3 kategorisinde en az 1 yayında başlıca yazar olmalısınız',
            ['A1-A2-A3'], 1, yazar: 'baslica', donem: $DOCENTLIK, madde: 'Madde 10/3-a/1',
        ),
        Kalip::adet(
            'Bu yayınlardan en az biri A1 veya A2 kategorisinden olmalı',
            ['A1-A2'], 1, yazar: 'baslica', donem: $DOCENTLIK, madde: 'Madde 10/3-a/1',
        ),
        Kalip::puanDan(
            'Doçentlik unvanınızdan sonra sci-expanded, ssci, ahci, esci, scopus ve tr dizin dergilerindeki yayınlarınızdan en az 250 puan',
            ['A1-A2-A3-A4-A5-A6'], 250, $DOCENTLIK, madde: 'Madde 10/3-a/2',
        ),
        Kalip::puanDan(
            'Doçentlik unvanınızdan sonra bildiri (uluslararası veya ulusal) kalemlerinizden en az 50 puan',
            ['B-C'], 50, $DOCENTLIK, madde: 'Madde 10/3-a/3',
        ),
        Kalip::puanDan('Atıf kalemlerinizden en az 20 puan', ['K'], 20, madde: 'Madde 10/3-a/4'),
        Kalip::toplam(600, $DOCENTLIK),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// (c) MİMARLIK VE TASARIM FAKÜLTESİ
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'atu-mimarlik-dr',
    'aday_notu' => 'A1, A2, A3 veya A4 kategorilerinden en az 1 yayınında başlıca yazar '
        .'olmalısınız; aynı kategorilerden en az 120 puan ve tüm faaliyetlerden toplamda en '
        .'az 240 puan gerekiyor. '.$ydsNotu,
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['mimarlik'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 7/1-c: A1-A4\'ten en az bir yayında başlıca yazar; A1-A4\'ten en az '
        .'120 puan; toplam en az 240 puan.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma', [
        Kalip::beyan('İlgili alanda doktora derecesine sahip olmak', 'Madde 7/1-c'),
        Kalip::adet('SCI-Expanded, SSCI, AHCI, ESCI, Scopus ve TR Dizin dergilerindeki yayınlarınızdan en az 1 tanesinde başlıca yazar olmalısınız', ['A1-A2-A3-A4'], 1, yazar: 'baslica', madde: 'Madde 7/1-c/1'),
        Kalip::puanDan('SCI-Expanded, SSCI, AHCI, ESCI, Scopus ve TR Dizin dergilerindeki yayınlarınızdan en az 120 puan', ['A1-A2-A3-A4'], 120, madde: 'Madde 7/1-c/1'),
        Kalip::toplam(240),
    ]),
];

$esikler[] = [
    'anahtar' => 'atu-mimarlik-dr-yeniden',
    'aday_notu' => 'sci-expanded, ssci, ahci, esci, scopus ve tr dizin dergilerindeki yayınlarınızdan en az 100 puan ve tüm faaliyetlerden toplamda en az '
        .'200 puan gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => ['mimarlik'],
    'cetvel' => $CETVEL,
    'notlar' => "Madde 8/1-c: A1-A5'ten en az 100 puan; toplam en az 200 puan.",
    'sart' => Kalip::ve('Doktor Öğretim Üyeliğine yeniden atanma', [
        Kalip::puanDan('SCI-Expanded, SSCI, AHCI, ESCI, Scopus ve TR Dizin dergilerindeki yayınlarınızdan en az 100 puan', ['A1-A2-A3-A4-A5'], 100, madde: 'Madde 8/1-c'),
        Kalip::toplam(200),
    ]),
];

$esikler[] = [
    'anahtar' => 'atu-mimarlik-docent',
    'aday_notu' => 'Doktora unvanınızdan SONRAKİ çalışmalarınıza bakılıyor: en az biri '
        .'dizinli dergide olmak üzere sci-expanded, ssci, ahci, esci, scopus ve tr dizin dergilerindeki '
        .'yayınlarınızdan en az 200 puan; bildirilerinizden en az 70 puan; atıf '
        .'kalemlerinizden en az 10 puan ve doktora sonrası '
        .'toplamdan en az 450 puan gerekiyor. Yabancı dilde eğitim yapılan bölümlerde ayrıca en '
        .'az bir makalenizin eğitim diliyle yayımlanmış olması aranıyor; bu koşul (bölümün '
        .'eğitim dili profilde tutulmadığı için) eşiğe yazılmadı, başvurmadan önce üniversiteye '
        .'teyit ettirin.',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => ['mimarlik'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 9/4: doktora sonrası A1-A4\'ten en az 200 puan (en az 1 yayın A1 veya '
        .'A2\'den); B veya C\'den en az 70 puan (tavan 100, kaynakta 150); K\'dan en az 10 '
        .'puan; doktora sonrası toplam en az 450 puan.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma', [
        Kalip::beyan('ÜAK doçentlik belgesine sahip olmak', 'Madde 9/1'),
        Kalip::adet(
            'Doktora unvanınızdan sonra A1 veya A2 kategorisinde en az 1 yayınınız olmalı',
            ['A1-A2'], 1, donem: $DOKTORA, madde: 'Madde 9/4-a/1',
        ),
        Kalip::puanDan(
            'Doktora unvanınızdan sonra sci-expanded, ssci, ahci, esci, scopus ve tr dizin dergilerindeki yayınlarınızdan en az 200 puan',
            ['A1-A2-A3-A4'], 200, $DOKTORA, madde: 'Madde 9/4-a/1',
        ),
        Kalip::puanDan(
            'Doktora unvanınızdan sonra bildiri (uluslararası veya ulusal) kalemlerinizden en az 70 puan',
            ['B-C'], 70, $DOKTORA, madde: 'Madde 9/4-a/3',
        ),
        Kalip::puanDan('Atıf kalemlerinizden en az 10 puan', ['K'], 10, madde: 'Madde 9/4-a/4'),
        Kalip::toplam(450, $DOKTORA),
    ]),
];

$esikler[] = [
    'anahtar' => 'atu-mimarlik-profesor',
    'aday_notu' => 'Doçentlik unvanınızdan SONRAKİ çalışmalarınıza bakılıyor: A1 veya A2\'den '
        .'en az biri başlıca yazarlı olmak üzere bu iki kategoriden toplam en az 2 yayınınız '
        .'olmalı; sci-expanded, ssci, ahci, esci, scopus ve tr dizin dergilerindeki yayınlarınızdan en az 300 puan; bildiri (B veya C) kalemlerinizden en '
        .'az 100 puan; atıf (K) kaleminizden en az 20 puan ve doçentlik sonrası toplamdan en '
        .'az 600 puan gerekiyor. Yabancı dilde eğitim yapılan bölümlerde ayrıca en az bir '
        .'makalenizin eğitim diliyle yayımlanmış olması aranıyor; bu koşul eşiğe yazılmadı.',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['mimarlik'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 10/4: doçentlik sonrası A1,A2\'den toplam en az 2 yayın, en az biri '
        .'başlıca yazarlı; A1-A4\'ten en az 300 puan; B veya C\'den en az 100 puan (tavan 100, '
        .'kaynakta 250); K\'dan en az 20 puan; doçentlik sonrası toplam en az 600 puan.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma', [
        Kalip::beyan('Doçentlik unvanına sahip olmak ve 2547 sayılı Kanun\'un 26. maddesindeki koşulları sağlamak', 'Madde 10/1'),
        Kalip::adet(
            'Doçentlik unvanınızdan sonra A1 veya A2 kategorisinden toplam en az 2 yayınınız olmalı',
            ['A1-A2'], 2, donem: $DOCENTLIK, madde: 'Madde 10/4-a/1',
        ),
        Kalip::adet(
            'Bu yayınlardan en az biri başlıca yazarlı olmalı',
            ['A1-A2'], 1, yazar: 'baslica', donem: $DOCENTLIK, madde: 'Madde 10/4-a/1',
        ),
        Kalip::puanDan(
            'Doçentlik unvanınızdan sonra sci-expanded, ssci, ahci, esci, scopus ve tr dizin dergilerindeki yayınlarınızdan en az 300 puan',
            ['A1-A2-A3-A4'], 300, $DOCENTLIK, madde: 'Madde 10/4-a/2',
        ),
        Kalip::puanDan(
            'Doçentlik unvanınızdan sonra bildiri (uluslararası veya ulusal) kalemlerinizden en az 100 puan',
            ['B-C'], 100, $DOCENTLIK, madde: 'Madde 10/4-a/4',
        ),
        Kalip::puanDan('Atıf kalemlerinizden en az 20 puan', ['K'], 20, madde: 'Madde 10/4-a/5'),
        Kalip::toplam(600, $DOCENTLIK),
    ]),
];

return $esikler;
