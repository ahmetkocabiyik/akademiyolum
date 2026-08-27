<?php

/**
 * SANKO ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma Yönergesi
 * Kaynak: pdf/17537103582.sankouniersitesi.pdf
 *
 * BELGEDE TARİH YOK: MADDE 17 yürürlüğü YÖK onayına bağlıyor ama tarih
 * vermiyor. PDF 04/10/2023'te üretilmiş.
 *
 * ── KISMEN GİRİLDİ: İKİ ÇİZELGE DE PDF'TE YOK ──
 * Yönerge puanlamayı iki ayrı belgeye devrediyor — "Puanlama Çizelgesi"
 * (MADDE 4/m) ve "Asgari Koşullar Çizelgesi" (MADDE 4/c) — ve altı sayfalık
 * dosyada ikisi de yok; yalnızca gövde (MADDE 1-18) var. Bu yüzden bu
 * üniversitede TOPLAM PUAN BARAJI GÖSTERİLEMİYOR.
 *
 * Yine de gövdenin kendisi üç kadro için somut koşullar taşıyor ve bunlar
 * çizelgeye ihtiyaç duymadan girilebildi. Balıkesir, Türk Hava Kurumu ve
 * Maltepe'den farkı bu: onlarda ölçüt metni de çizelgeye devrediyordu, burada
 * gövdenin kendisi sayı ve sınav puanı veriyor.
 *
 *   Dr. Öğr. Üyesi  indeksli dergilerde en az 2 makale + yabancı dil 55
 *   Doçent          ÜAK doçentlik unvanı + YÖK doçentlik asgari koşulları
 *   Profesör        5 yıl doçentlik kıdemi + 2 yıl doçent kadrosu +
 *                   doçentlik sonrası bir başlıca araştırma eseri
 *
 * ── DOKTOR ÖĞRETİM ÜYELİĞİ TAM DEĞERLENDİRİLEBİLİYOR ──
 * MADDE 10/2 makale sayısını ve dergi kümesini gövdede tanımlıyor
 * ("Üniversitelerarası Kurul Başkanlığınca Doçentlik sınavında kabul edilen
 * indeksler (SSCI, SCI-Exp. veya AHCI) veya diğer uluslararası ve ulusal alan
 * indeksleri tarafından taranan dergilerde en az 2 (iki) bilimsel makale");
 * kümenin sınırları MADDE 4/p ve 4/r'de yazılı. MADDE 10/3 yabancı dil için
 * sayı veriyor: en az 55.
 *
 * Maddenin "Asgari Koşullar Çizelgesinde belirtilen şekilde" ibaresi çizelgeye
 * bir atıf ama sayı ve kapsam cümlenin kendisinde; koşul olduğu gibi girildi
 * ve çizelgenin daraltma ihtimali aday notunda söylendi.
 *
 * MADDE 10/2 ayrıca "Bu koşul akademik programların özelliğine göre Senato
 * tarafından farklı belirlenebilir" diyor — programa göre değişebilen bir
 * kapı; hangi programda kaça çıktığı belgede yok, aday notunda anıldı.
 *
 * ── DOÇENTLİK GÖVDEDE SAYISAL KOŞUL TAŞIMIYOR ──
 * MADDE 11 yalnızca ÜAK doçentlik unvanını ve "Üniversitelerarası Kurulun
 * görüşü üzerine Yükseköğretim Kurulunun doçentlik başvuruları için
 * uygulamaya koyduğu asgari koşulları" istiyor. İkincisi ÜAK'ın alan başına
 * değişen kendi cetveline bağlı; beyan olarak duruyor. Puanlama Çizelgesi
 * bulunduğunda buraya bir puan barajı eklenmesi gerekebilir.
 *
 * ── PROFESÖRLÜKTE "B1" KODU ÇÖZÜLEMİYOR ──
 * MADDE 12/4 "Doçentlik unvanını aldıktan sonra Puanlama Çizelgesi B1
 * kapsamındaki yayınlarından birini başlıca araştırma eseri olarak
 * göstermelidir" diyor. B1'in hangi yayın türü olduğu yalnızca Puanlama
 * Çizelgesinde yazılı ve o çizelge elimizde yok. Koşulun TAMAMI eksik bir
 * belgeye dayandığı için `Kalip::hesaplanamiyor` ile girildi: `adet` yazmak
 * kapsamı uydurmak, hiç yazmamak ise yönergenin gerçek bir şartını gizlemek
 * olurdu.
 *
 * ── "BAŞLICA YAZAR" TANIMI MOTORUN SÜZGECİNDEN GENİŞ ──
 * MADDE 4/d başlıca yazarı dört yoldan tanımlıyor: tek yazar, çok yazarlı
 * makalede İLK İKİ SIRADAKİ yazar, sorumlu yazar, ya da danışmanlığını
 * yaptığı tezden üretilmiş yayındaki yazar. Motorun `yazar` süzgeci ikinci
 * sırayı ve tez türevliliğini tanımıyor. Profesörlükteki başlıca eser koşulu
 * zaten `hesaplanamiyor` olduğu için bu fark sonucu etkilemiyor; çizelge
 * bulunduğunda hesaba katılmalı.
 *
 * ── ALAN KAPSAMI ──
 * MADDE 5/1 ölçütlerin "SANKO Üniversitesinin TÜM öğretim üyesi kadroları
 * için" geçerli olduğunu söylüyor; alan ayrımı yok, on iki temel alanın
 * hepsine yazıldı.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 13'ün değerlendirme kayıtları (aynı başlıklı çalışmalarda en yüksek
 *       puanlının sayılması, aynı dergide editörlük ve hakemliğin
 *       birleştirilmesi, adayın kendi atıflarının sayılmaması): hepsi
 *       Puanlama Çizelgesi üzerinde işleyen kurallar, çizelge olmadan
 *       uygulanacak bir yer yok.
 *   MADDE 10/4, 11/3 ve 12/5'in "birden fazla aday başvurduğunda yüksekten
 *       düşüğe puanlama yapılır" hükmü bir sıralama kuralı, eşik değil.
 *   MADDE 6-9'un kadro ilanı, başvuru, ABPİK ve jüri usulü.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/sanko-turler.php
 */

use App\Enums\TemelAlan;
use App\Services\Scoring\Sart\Kalip;

$DOC = Kalip::DOCENTLIK_SONRASI;

/** MADDE 5/1: ölçütler tüm öğretim üyesi kadroları için geçerli. */
$tumAlanlar = array_column(TemelAlan::cases(), 'value');

$cizelgeNotu = 'ÖNEMLİ: SANKO\'nun Puanlama Çizelgesi ve Asgari Koşullar Çizelgesi kaynak '
    .'belgede yer almıyor, bu yüzden burada toplam puan barajı gösterilemiyor. Gördüğünüz '
    .'koşullar yönergenin kendi maddelerinde yazılı olanlar; çizelgeler ek koşul getiriyor '
    .'olabilir, başvurmadan önce üniversiteden isteyin.';

$onkosulNotu = 'Yönerge bu ölçütleri bir ÖN KOŞUL sayıyor (MADDE 5/2): sağlamak tek başına '
    .'atanmaya yetmiyor, asıl değerlendirmeyi jüri yapıyor.';

return [
    [
        'anahtar' => 'sanko-dr',
        'aday_notu' => 'İki somut koşul var ve ikisi de yönergenin kendi maddelerinde yazılı: '
            .'uluslararası ya da ulusal alan indeksli dergilerde en az iki bilimsel makale ve '
            .'yabancı dil sınavından en az 55 puan. İndekslenmemiş ulusal dergilerdeki '
            .'makaleleriniz bu sayıya girmez; yönerge ulusal indeksi yalnızca '
            .'TÜBİTAK-ULAKBİM olarak tanımlıyor. Yönerge ayrıca bu makale sayısının '
            .'"akademik programların özelliğine göre Senato tarafından farklı '
            .'belirlenebileceğini" söylüyor; programınıza özgü bir sayı olup olmadığını teyit '
            .'edin. '.$cizelgeNotu.' '.$onkosulNotu,
        'universite' => 'SANKO Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $tumAlanlar,
        'cetvel' => 'sanko-turler',
        'notlar' => 'MADDE 10/2: "Üniversitelerarası Kurul Başkanlığınca Doçentlik sınavında '
            .'kabul edilen indeksler (SSCI, SCI-Exp. veya AHCI) veya diğer uluslararası ve '
            .'ulusal alan indeksleri tarafından taranan dergilerde en az 2 (iki) bilimsel '
            .'makale yayımlamış olması gerekir." MADDE 10/3 yabancı dil sınavından en az 55 '
            .'puan istiyor. Puan barajı gövdede yok; Puanlama Çizelgesi belgede bulunmuyor.',
        'sart' => Kalip::ve('Doktor Öğretim Üyeliğine yükseltilme ve atanma', [
            Kalip::beyan(
                'Doktora, tıpta ya da diş hekimliğinde uzmanlık veya sanatta yeterlik '
                .'unvanını almış olmak',
                'Madde 10/1',
            ),
            Kalip::yds(55),
            Kalip::adet(
                'Uluslararası ya da ulusal alan indeksli dergilerde en az 2 bilimsel makale',
                ['INDEKSLI-DERGI'], 2, madde: 'Madde 10/2',
            ),
        ]),
    ],
    [
        'anahtar' => 'sanko-docent',
        'aday_notu' => 'Yönergenin gövdesi doçentlik için SAYISAL BİR KOŞUL VERMİYOR: ÜAK '
            .'doçentlik unvanı ve YÖK\'ün doçentlik başvuruları için koyduğu asgari koşullar '
            .'yeterli sayılıyor. İkincisi ÜAK\'ın alanınıza göre değişen kendi cetveline bağlı, '
            .'burada hesaplanamıyor. '.$cizelgeNotu.' '.$onkosulNotu,
        'universite' => 'SANKO Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $tumAlanlar,
        'cetvel' => 'sanko-turler',
        'notlar' => 'MADDE 11/1: 2547 sayılı Kanunun 24. maddesi uyarınca doçentlik unvanı. '
            .'MADDE 11/2: "Üniversitelerarası Kurulun görüşü üzerine Yükseköğretim Kurulunun '
            .'doçentlik başvuruları için uygulamaya koyduğu asgari koşulları sağlamış '
            .'olmalıdır." Gövdede puan ya da sayı koşulu yok; Puanlama Çizelgesi belgede '
            .'bulunmuyor.',
        'sart' => Kalip::ve('Doçentliğe yükseltilme ve atanma', [
            Kalip::beyan(
                'Üniversitelerarası Kurul tarafından verilen doçentlik unvanına sahip olmak; '
                .'yurt dışında doçentliğe denk bir görevde bulunanlarda denklik belgesi',
                'Madde 11/1-2',
            ),
            Kalip::beyan(
                'Yükseköğretim Kurulunun doçentlik başvuruları için uygulamaya koyduğu ve '
                .'alanınıza göre değişen asgari koşulları sağlamış olmak',
                'Madde 11/2',
            ),
        ]),
    ],
    [
        'anahtar' => 'sanko-profesor',
        'aday_notu' => 'Üç koşul yönergenin gövdesinde yazılı: doçentlik unvanınızdan sonra '
            .'en az beş yıl ilgili alanda çalışmış olmak, en az iki yıl bir yükseköğretim '
            .'kurumunda doçent kadrosunda görev yapmış olmak ve doçentliğinizden sonraki '
            .'yayınlarınızdan birini başlıca araştırma eseri olarak göstermek. Son koşulun '
            .'hangi yayın türünü kapsadığı yalnızca Puanlama Çizelgesinde ("B1") yazılı ve o '
            .'çizelge elimizde yok; bu yüzden burada hesaplanamıyor, başvurunuzda belgeyle '
            .'göstermeniz gerekiyor. '.$cizelgeNotu.' '.$onkosulNotu,
        'universite' => 'SANKO Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $tumAlanlar,
        'cetvel' => 'sanko-turler',
        'notlar' => 'MADDE 12/1: doçentlik unvanından sonra en az 5 yıl ilgili bilim alanında '
            .'çalışmış olmak. MADDE 12/2: en az 2 yıl bir yükseköğretim kurumunda doçent '
            .'kadrosunda görev. MADDE 12/4: "Doçentlik unvanını aldıktan sonra Puanlama '
            .'Çizelgesi B1 kapsamındaki yayınlarından birini başlıca araştırma eseri olarak '
            .'göstermelidir." B1\'in kapsamı yalnızca Puanlama Çizelgesinde tanımlı; çizelge '
            .'belgede yok, koşul `hesaplanamiyor` olarak girildi.',
        'sart' => Kalip::ve('Profesörlüğe yükseltilme ve atanma', [
            Kalip::beyan(
                'Doçentlik unvanını aldıktan sonra en az beş yıl açık bulunan profesörlük '
                .'kadrosuyla ilgili bilim ya da sanat alanında çalışmış olmak',
                'Madde 12/1',
            ),
            Kalip::beyan(
                'En az iki yıl bir yükseköğretim kurumunda doçent kadrosunda görev yapmış olmak',
                'Madde 12/2',
            ),
            Kalip::hesaplanamiyor(
                'Doçentliğinizden sonraki yayınlarınızdan birini başlıca araştırma eseri '
                .'olarak göstermek (yönerge bu yayının Puanlama Çizelgesinin B1 kapsamında '
                .'olmasını istiyor; çizelge kaynak belgede bulunmadığı için kapsam '
                .'çözülemiyor)',
                'Madde 12/4',
            ),
            Kalip::beyan(
                'Doçentlik eser aşamasını geçtikten sonra yapılan yayın ve çalışmaları '
                .'başvuru dosyasında ayrı başlık altında göstermek',
                'Madde 12/3',
            ),
        ]),
    ],
];
