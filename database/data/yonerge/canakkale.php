<?php

/**
 * ÇANAKKALE ONSEKİZ MART ÜNİVERSİTESİ — Öğretim Üyesi Kadrolarına Başvuru,
 * Görev Süresi Uzatımı, Atanma ve Yükseltilme Kriterleri Yönergesi
 * Kaynak: pdf/17536992142.canakkaleonsekizmartuniversitesi.pdf (20 sayfa,
 * yürürlük 01.01.2024)
 *
 * ── 2024 VE 2025 DEĞERLERİ: 2025 OLANI ALINDI ──
 * Madde 10 yönergeyi iki basamağa bölüyor. 01.01.2024-31.12.2024 arasında
 * Madde 6/12 (Dr. 500 puan), 8/1 (bir dış kaynaklı proje), 8/14 (doçent 1250)
 * ve 9/15 (profesör 2000) geçerli; 01.01.2025'ten itibaren bunların yerini
 * Madde 6/14 (Dr. 600), 8/2 (İKİ dış kaynaklı proje, yürütücü olarak),
 * 9/5 (iki proje) ve 8/15 ile 9/16 (doçent 1500, profesör 2250) alıyor.
 * Bugün itibarıyla ikinci basamak yürürlükte olduğu için 2025 değerleri
 * girildi; ilk basamağın sayıları dosya başlığında kalsın diye buraya
 * yazıldı.
 *
 * ── ALAN BAZLI YAYIN ŞARTLARI, ORTAK PUAN BARAJI ──
 * Puan barajları alandan bağımsız (Dr. 600 · yeniden 500 · doçent 1500 ·
 * profesör 2250), ama yayın şartı her alan için ayrı fıkrada yazılı ve
 * Tablo-2'nin ALT BENTLERİNE atıf yapıyor ("1(a), 1(d) veya 1(f)
 * maddelerinden toplamda en az dört yayın"). Bu yüzden cetvelde bent
 * kodları birebir korundu.
 *
 * Alan grupları:
 *   saglik                       → Madde 6/2, 8/3, 9/6
 *   muhendislik, fen, ziraat     → Madde 6/3, 8/4, 9/7 (Su ürünleri dâhil)
 *   egitim                       → Madde 6/4, 8/5, 9/8
 *   sosyal, hukuk, ilahiyat      → Madde 6/5, 8/6, 9/9 (Deniz İşletmeciliği
 *                                  de bu grupta anılıyor)
 *   spor                         → Madde 6/6, 8/7, 9/10
 *   guzel_sanatlar (iki birim)   → Madde 6/7-8, 8/8-9, 9/11-12
 *   mimarlik                     → Madde 6/9, 8/10, 9/13
 *
 * ── FİLOLOJİ KAPSAM DIŞI ──
 * Madde 6-9 alanları tek tek sayıyor ve Filoloji hiçbirinde geçmiyor.
 * "Sosyal bilimler" başlığına katmak adaya yönergede yazmayan bir koşul
 * göstermek olurdu (KONVANSIYONLAR: yönergenin anmadığı alana eşik yazma).
 *
 * ── GÜZEL SANATLAR VE KONSERVATUVAR AYRI `birim` ──
 * Madde 6/7 Devlet Konservatuvarı için iki yayın, 6/8 Güzel Sanatlar için
 * iki yayın istiyor ama Güzel Sanatlar'a ayrıca Madde 6/10-11'in kişisel
 * etkinlik ve sempozyum katılımı koşulları ekleniyor; doçentlikte sayılar
 * da ayrışıyor (konservatuvar 3, güzel sanatlar 4). İkisi de
 * `guzel_sanatlar` temel alanına düştüğü için `birim` ile ayrıldı.
 *
 * ── %65 KURALI `Kalip::oran` İLE ──
 * Madde 6/13, 7/9: "Adayın toplam puanının %65'ini Tablo 2'de yer alan 1-5
 * maddeleri arasından almış olması gerekmektedir." Motorun `oran` düğümü
 * tam bunun için: pay 1-5 kümesi, payda cetvelin tamamı. Güzel sanatlar,
 * mimarlık-tasarım ve konservatuvarda küme 10. ve 11. bölümle genişliyor;
 * 11. bölüm cetvele giremediği için yalnızca 10 eklendi (`1-5-10`), yani
 * o alanlarda oran koşulu olduğundan biraz ZOR görünür.
 *
 * ── "İSTENEN PUANIN İKİ KATI" MUAFİYETLERİ ──
 * Madde 6/1, 7/2-3, 8/1-2, 9/3-4-5 proje ve ders/tez koşullarını "adayın
 * istenen puanın iki katını sağlaması hâlinde" kaldırıyor. Bu bir TELAFİ
 * dalı ve motorun `telafi` alanıyla karşılandı: proje düğümünün telafisi
 * "toplam puanın iki katı" olarak yazıldı.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Madde 9/1 ("doçentlikten sonra en az üç yılı yükseköğretim kurumlarında
 *       olmak üzere beş yıl çalışmış olmak") ve 9/2 ("en az dört yarıyıl
 *       ders vermiş olmak") — süre bilgisi profilde yok; 9/1 beyan olarak
 *       eklendi, 9/2 için ders SAYISI koşulu yazılamadı (yarıyıl sayısı
 *       kayıtta yok).
 *   Madde 6/1'in "patent başvurusu yapmış ve araştırma raporunu sunmuş
 *       olmak" alternatifi — başvuru satırı cetvele girmedi (tescilliyle
 *       aynı kayda düşerdi).
 *   Madde 7/10 (puana göre 2-4 yıllık atama süresi) — atama süresi bir
 *       sonuç, koşul değil.
 *   Madde 5'in belge ve künye kuralları (1-32. fıkralar) — kayıt disiplini.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/canakkale-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

$CETVEL = 'canakkale-2024';
$UNIVERSITE = 'Çanakkale Onsekiz Mart Üniversitesi';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

/**
 * Proje koşulu ve onun "istenen puanın iki katı" telafisi.
 *
 * @param  array<string, mixed>|null  $donem
 * @return array<string, mixed>
 */
$projeKosulu = function (int $sayi, int $toplamBaraji, ?array $donem, string $madde, bool $yurutucu = false): array {
    $aciklama = $yurutucu
        ? "BAP dışında en az {$sayi} dış kaynaklı ulusal veya uluslararası projede yürütücü olmalısınız"
        : "BAP dışında en az {$sayi} dış kaynaklı ulusal veya uluslararası projede yürütücü ya da görevli olmalısınız";

    return Kalip::adet($aciklama, ['PROJE-DIS'], $sayi, donem: $donem, madde: $madde) + [
        'telafi' => [
            'tip' => 'puan',
            'aciklama' => 'Bu koşulu sağlayamazsanız: istenen toplam puanın iki katını '
                .'(en az '.($toplamBaraji * 2).' puan) toplamalısınız',
            'madde' => $madde,
            'maddeler' => ['*'],
            'min_puan' => $toplamBaraji * 2,
            'donem' => $donem,
        ],
    ];
};

/**
 * %65 kuralı. Güzel sanatlar, mimarlık ve konservatuvarda küme genişliyor.
 *
 * @return array<string, mixed>
 */
$oranKurali = fn (bool $sanat, string $madde): array => Kalip::oran(
    $sanat
        ? 'Toplam puanınızın en az %65\'i makale, bildiri, kitap, atıf, proje ve disiplinlere özgü sanat etkinliği kalemlerinizden gelmeli'
        : 'Toplam puanınızın en az %65\'i makale, bildiri, kitap, atıf ve proje kalemlerinizden gelmeli',
    [$sanat ? '1-5-10' : '1-5'], 0.65, ['*'], madde: $madde,
);

$esikler = [];

// ══════════════════════════════════════════════════════════════════════════
// DOKTOR ÖĞRETİM ÜYESİ — İLK ATANMA (Madde 6)
// ══════════════════════════════════════════════════════════════════════════

/**
 * @param  list<string>  $alanlar
 * @param  list<array<string, mixed>>  $yayinSarti
 * @return array<string, mixed>
 */
$dr = function (string $anahtar, array $alanlar, ?string $birim, array $yayinSarti, bool $sanat, string $notlar, string $adayNotu) use ($UNIVERSITE, $CETVEL, $projeKosulu, $oranKurali): array {
    return [
        'anahtar' => "canakkale-{$anahtar}-dr",
        'aday_notu' => $adayNotu,
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => $CETVEL,
        'notlar' => $notlar,
        'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna ilk atanma', array_values(array_merge(
            [
                Kalip::beyan('Doktora ya da tıpta, diş hekimliğinde veya sanatta yeterlik derecesine sahip olmak', 'Madde 6'),
                $projeKosulu(1, 600, null, 'Madde 6/1'),
            ],
            $yayinSarti,
            [
                Kalip::toplam(600),
                $oranKurali($sanat, 'Madde 6/13'),
            ],
        ))),
    ];
};

$esikler[] = $dr('saglik', ['saglik'], null, [
    Kalip::adet('SCI, SCI-Expanded, SSCI veya AHCI dergilerinde en az 1 özgün araştırma makaleniz olmalı', ['1.a'], 1, madde: 'Madde 6/2'),
    Kalip::adet('SCI-AHCI, ESCI-Scopus ya da diğer uluslararası dergilerde toplam en az 4 yayınınız olmalı', ['1.a-1.d-1.f'], 4, madde: 'Madde 6/2'),
    Kalip::adet('Bu yayınlarınızdan en az birinde başlıca yazar olmalısınız', ['1.a-1.d-1.f'], 1, yazar: 'baslica', madde: 'Madde 6/2'),
], false,
    'Madde 6/2 (Sağlık bilimleri): 1(a)\'dan en az 1, 1(a)+1(d)+1(f)\'ten toplam 4 yayın, birinde başlıca yazar; Madde 6/1 proje; 6/14 toplam 600; 6/13 %65 kuralı.',
    'Sağlık bilimleri alanında: SCI, SCI-Expanded, SSCI veya AHCI dergilerinde en az 1 özgün araştırma makaleniz olmalı ve bu indeksler ile ESCI-Scopus ya da diğer uluslararası dergilerdeki yayınlarınız toplam en az 4 olmalı; en az birinde başlıca yazar olmanız gerekiyor. Ayrıca BAP dışında en az bir dış kaynaklı projede görev almış olmalısınız (istenen puanın iki katını toplarsanız bu koşul aranmaz). Toplamda en az 600 puan ve bu puanın en az %65\'inin makale, bildiri, kitap, atıf ve proje kalemlerinden gelmesi şart.');

$esikler[] = $dr('fen-muhendislik', ['muhendislik', 'fen', 'ziraat'], null, [
    Kalip::adet('SCI, SCI-Expanded, SSCI veya AHCI dergilerinde en az 1 özgün araştırma makaleniz olmalı', ['1.a'], 1, madde: 'Madde 6/3'),
    Kalip::adet('SCI-AHCI, ESCI-Scopus ya da diğer uluslararası dergilerde toplam en az 4 yayınınız olmalı', ['1.a-1.d-1.f'], 4, madde: 'Madde 6/3'),
    Kalip::adet('Bu yayınlarınızdan en az birinde başlıca yazar olmalısınız', ['1.a-1.d-1.f'], 1, yazar: 'baslica', madde: 'Madde 6/3'),
], false,
    'Madde 6/3 (Mühendislik, Fen, Ziraat ve Su ürünleri): Sağlık ile aynı yayın şartı; toplam 600; %65 kuralı.',
    'Mühendislik, fen bilimleri, ziraat ve su ürünleri alanlarında: SCI, SCI-Expanded, SSCI veya AHCI dergilerinde en az 1 özgün araştırma makaleniz olmalı ve bu indeksler ile ESCI-Scopus ya da diğer uluslararası dergilerdeki yayınlarınız toplam en az 4 olmalı; en az birinde başlıca yazar olmanız gerekiyor. Ayrıca BAP dışında en az bir dış kaynaklı projede görev almış olmalısınız (istenen puanın iki katını toplarsanız bu koşul aranmaz). Toplamda en az 600 puan ve bu puanın en az %65\'inin makale, bildiri, kitap, atıf ve proje kalemlerinden gelmesi şart.');

$esikler[] = $dr('egitim', ['egitim'], null, [
    Kalip::adet('ESCI veya Scopus dergilerinde en az 2 yayınınız olmalı', ['1.d'], 2, madde: 'Madde 6/4'),
    Kalip::adet('Diğer uluslararası dergilerde en az 2 yayınınız olmalı', ['1.f'], 2, madde: 'Madde 6/4'),
    Kalip::adet('Bu yayınlarınızdan en az birinde başlıca yazar olmalısınız', ['1.a-1.d-1.f'], 1, yazar: 'baslica', madde: 'Madde 6/4'),
], false,
    'Madde 6/4 (Eğitim bilimleri): 1(d)\'den 2 ve 1(f)\'ten 2, toplam 4 yayın; birinde başlıca yazar; toplam 600; %65 kuralı.',
    'Eğitim bilimleri alanında: ESCI veya Scopus dergilerinde en az 2, diğer uluslararası dergilerde en az 2 olmak üzere toplam en az 4 yayınınız olmalı; en az birinde başlıca yazar olmanız gerekiyor. Ayrıca BAP dışında en az bir dış kaynaklı projede görev almış olmalısınız (istenen puanın iki katını toplarsanız bu koşul aranmaz). Toplamda en az 600 puan ve bu puanın en az %65\'inin makale, bildiri, kitap, atıf ve proje kalemlerinden gelmesi şart.');

$esikler[] = $dr('sosyal', ['sosyal', 'hukuk', 'ilahiyat'], null, [
    Kalip::adet('SCI-AHCI ya da ESCI-Scopus dergilerinde en az 1 yayınınız olmalı', ['1.a-1.d'], 1, madde: 'Madde 6/5'),
    Kalip::adet('SCI-AHCI, ESCI-Scopus ya da diğer uluslararası dergilerde toplam en az 4 yayınınız olmalı', ['1.a-1.d-1.f'], 4, madde: 'Madde 6/5'),
    Kalip::adet('Bu yayınlarınızdan en az birinde başlıca yazar olmalısınız', ['1.a-1.d-1.f'], 1, yazar: 'baslica', madde: 'Madde 6/5'),
], false,
    'Madde 6/5 (Sosyal bilimler, Deniz İşletmeciliği, İlahiyat, Hukuk): en az biri 1(a) veya 1(d)\'den olmak üzere toplam 4 yayın; toplam 600; %65 kuralı.',
    'Sosyal bilimler, deniz işletmeciliği, ilahiyat ve hukuk alanlarında: SCI-AHCI ya da ESCI-Scopus dergilerinde en az 1 yayınınız olmak kaydıyla bu indeksler ile diğer uluslararası dergilerdeki yayınlarınız toplam en az 4 olmalı; en az birinde başlıca yazar olmanız gerekiyor. Ayrıca BAP dışında en az bir dış kaynaklı projede görev almış olmalısınız (istenen puanın iki katını toplarsanız bu koşul aranmaz). Toplamda en az 600 puan ve bu puanın en az %65\'inin makale, bildiri, kitap, atıf ve proje kalemlerinden gelmesi şart.');

$esikler[] = $dr('spor', ['spor'], null, [
    Kalip::adet('SCI, SCI-Expanded, SSCI veya AHCI dergilerinde en az 1 özgün araştırma makaleniz olmalı', ['1.a'], 1, madde: 'Madde 6/6'),
    Kalip::adet('SCI-AHCI, ESCI-Scopus ya da diğer uluslararası dergilerde toplam en az 4 yayınınız olmalı', ['1.a-1.d-1.f'], 4, madde: 'Madde 6/6'),
    Kalip::adet('Bu yayınlarınızdan en az birinde başlıca yazar olmalısınız', ['1.a-1.d-1.f'], 1, yazar: 'baslica', madde: 'Madde 6/6'),
], false,
    'Madde 6/6 (Spor bilimleri): Sağlık ile aynı yayın şartı; toplam 600; %65 kuralı.',
    'Spor bilimleri alanında: SCI, SCI-Expanded, SSCI veya AHCI dergilerinde en az 1 özgün araştırma makaleniz olmalı ve bu indeksler ile ESCI-Scopus ya da diğer uluslararası dergilerdeki yayınlarınız toplam en az 4 olmalı; en az birinde başlıca yazar olmanız gerekiyor. Ayrıca BAP dışında en az bir dış kaynaklı projede görev almış olmalısınız (istenen puanın iki katını toplarsanız bu koşul aranmaz). Toplamda en az 600 puan ve bu puanın en az %65\'inin makale, bildiri, kitap, atıf ve proje kalemlerinden gelmesi şart.');

$esikler[] = $dr('konservatuvar', ['guzel_sanatlar'], 'Devlet Konservatuvarı', [
    Kalip::adet('Makale ve kitap kalemlerinizden toplam en az 2 yayınınız olmalı', ['1-TUM', '3.a-3.e'], 2, madde: 'Madde 6/7'),
    Kalip::adet('Bu yayınlarınızdan en az birinde başlıca yazar olmalısınız', ['1-TUM', '3.a-3.e'], 1, yazar: 'baslica', madde: 'Madde 6/7'),
], true,
    'Madde 6/7 (Devlet Konservatuvarı): 1(a-h2) ve 3(a-e) bentlerinden en az 2 yayın, birinde başlıca yazar; toplam 600; %65 kuralı (küme 10. bölümle genişliyor).',
    'Devlet Konservatuvarında: makale ve kitap kalemlerinizden toplam en az 2 yayınınız olmalı ve en az birinde başlıca yazar olmanız gerekiyor. Ayrıca BAP dışında en az bir dış kaynaklı projede görev almış olmalısınız (istenen puanın iki katını toplarsanız bu koşul aranmaz). Toplamda en az 600 puan ve bu puanın en az %65\'inin makale, bildiri, kitap, atıf, proje ve sanat etkinliği kalemlerinden gelmesi şart.');

$esikler[] = $dr('guzel-sanatlar', ['guzel_sanatlar'], 'Güzel Sanatlar Fakültesi', [
    Kalip::adet('Makale ve kitap kalemlerinizden toplam en az 2 yayınınız olmalı', ['1-TUM', '3.a-3.e'], 2, madde: 'Madde 6/8'),
    Kalip::adet('Bu yayınlarınızdan en az birinde başlıca yazar olmalısınız', ['1-TUM', '3.a-3.e'], 1, yazar: 'baslica', madde: 'Madde 6/8'),
    Kalip::adet('Özgün sanat eseriniz, tasarımınız ya da yorum çalışmanızla en az 1 kişisel etkinlikte (sergi, bienal, gösteri, dinleti, festival) bulunmuş olmalısınız', ['SANAT-KISISEL'], 1, madde: 'Madde 6/10'),
    Kalip::adet('Sempozyum, festival, çalıştay veya bienal gibi bir etkinliğe eserinizle ya da bildiriyle en az 1 kez katılmış olmalısınız', ['SANAT-ETKINLIK'], 1, madde: 'Madde 6/11'),
], true,
    'Madde 6/8 (Güzel Sanatlar): 2 yayın, birinde başlıca yazar; ayrıca 6/10 kişisel etkinlik ve 6/11 sempozyum katılımı; toplam 600; %65 kuralı (küme 10. bölümle genişliyor).',
    'Güzel sanatlar alanında: makale ve kitap kalemlerinizden toplam en az 2 yayınınız olmalı ve en az birinde başlıca yazar olmanız gerekiyor. Ayrıca en az 1 kişisel sanat etkinliğiniz ve bir sempozyum, festival veya bienale eserinizle ya da bildiriyle katılımınız aranıyor. BAP dışında en az bir dış kaynaklı projede görev almış olmalısınız (istenen puanın iki katını toplarsanız bu koşul aranmaz). Toplamda en az 600 puan ve bu puanın en az %65\'inin makale, bildiri, kitap, atıf, proje ve sanat etkinliği kalemlerinden gelmesi şart.');

$esikler[] = $dr('mimarlik', ['mimarlik'], null, [
    Kalip::adet('Makale ve kitap kalemlerinizden toplam en az 3 yayınınız olmalı', ['1-TUM', '3.a-3.e'], 3, madde: 'Madde 6/9'),
    Kalip::adet('Bu yayınlarınızdan en az birinde başlıca yazar olmalısınız', ['1-TUM', '3.a-3.e'], 1, yazar: 'baslica', madde: 'Madde 6/9'),
], true,
    'Madde 6/9 (Mimarlık ve Tasarım): 1(a-h2) ve 3(a-e) bentlerinden en az 3 yayın, birinde başlıca yazar; toplam 600; %65 kuralı (küme 10. bölümle genişliyor).',
    'Mimarlık ve tasarım alanında: makale ve kitap kalemlerinizden toplam en az 3 yayınınız olmalı ve en az birinde başlıca yazar olmanız gerekiyor. Ayrıca BAP dışında en az bir dış kaynaklı projede görev almış olmalısınız (istenen puanın iki katını toplarsanız bu koşul aranmaz). Toplamda en az 600 puan ve bu puanın en az %65\'inin makale, bildiri, kitap, atıf, proje ve sanat etkinliği kalemlerinden gelmesi şart.');

// ══════════════════════════════════════════════════════════════════════════
// DOKTOR ÖĞRETİM ÜYESİ — YENİDEN ATANMA (Madde 7, son atamadan sonra)
// ══════════════════════════════════════════════════════════════════════════

/**
 * @param  list<string>  $alanlar
 * @return array<string, mixed>
 */
$drYeniden = function (string $anahtar, array $alanlar, ?string $birim, bool $sanat, string $ad) use ($UNIVERSITE, $CETVEL, $SON_ATAMA, $projeKosulu, $oranKurali): array {
    $kume = $sanat ? ['1-TUM', '3.a-3.f'] : ['1-TUM'];

    return [
        'anahtar' => "canakkale-{$anahtar}-dr-yeniden",
        'aday_notu' => 'Yeniden atanmada bütün koşullar SON ATAMANIZDAN SONRAKİ '
            .'çalışmalarınızdan sağlanmalı. Makale'.($sanat ? ' ve kitap' : '')
            .' kalemlerinizden en az 3 yayınınız olmalı ve en az birinde başlıca yazar '
            .'olmalısınız. Ayrıca en az bir BAP projesinde ve BAP dışında en az bir dış '
            .'kaynaklı projede görev almış olmalısınız (istenen puanın iki katını toplarsanız '
            .'bu iki koşul da aranmaz). Toplamda en az 500 puan ve bu puanın en az %65\'inin '
            .'makale, bildiri, kitap, atıf'.($sanat ? ', proje ve sanat etkinliği' : ' ve proje')
            .' kalemlerinden gelmesi şart.',
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => $CETVEL,
        'notlar' => "Madde 7 ({$ad}): 3 yayın, birinde başlıca yazar; 7/2 BAP projesi; "
            .'7/3 dış kaynaklı proje (ikisinin de telafisi istenen puanın iki katı); '
            .'7/1 toplam 500; 7/9 %65 kuralı.',
        'sart' => Kalip::ve('Doktor Öğretim Üyeliğine yeniden atanma', [
            Kalip::adet('Son atamanızdan sonra en az 3 yayınınız olmalı', $kume, 3, donem: $SON_ATAMA, madde: 'Madde 7'),
            Kalip::adet('Bu yayınlarınızdan en az birinde başlıca yazar olmalısınız', $kume, 1, yazar: 'baslica', donem: $SON_ATAMA, madde: 'Madde 7'),
            Kalip::adet('Son atamanızdan sonra en az 1 BAP projesinde yürütücü ya da görevli olmalısınız', ['PROJE-TUM'], 1, donem: $SON_ATAMA, madde: 'Madde 7/2') + [
                'telafi' => [
                    'tip' => 'puan',
                    'aciklama' => 'Bu koşulu sağlayamazsanız: istenen toplam puanın iki katını (en az 1000 puan) toplamalısınız',
                    'madde' => 'Madde 7/2',
                    'maddeler' => ['*'],
                    'min_puan' => 1000,
                    'donem' => $SON_ATAMA,
                ],
            ],
            $projeKosulu(1, 500, $SON_ATAMA, 'Madde 7/3'),
            Kalip::toplam(500, $SON_ATAMA),
            $oranKurali($sanat, 'Madde 7/9'),
        ]),
    ];
};

$esikler[] = $drYeniden('saglik-fen', ['saglik', 'muhendislik', 'fen', 'ziraat'], null, false, 'Sağlık, Mühendislik, Ziraat, Su ürünleri, Fen bilimleri');
$esikler[] = $drYeniden('sosyal', ['sosyal', 'hukuk', 'ilahiyat', 'egitim'], null, false, 'Sosyal bilimler, Hukuk, Deniz İşletmeciliği, İlahiyat, Eğitim bilimleri');
$esikler[] = $drYeniden('spor', ['spor'], null, false, 'Spor bilimleri');
$esikler[] = $drYeniden('konservatuvar', ['guzel_sanatlar'], 'Devlet Konservatuvarı', true, 'Devlet Konservatuvarı');
$esikler[] = $drYeniden('guzel-sanatlar', ['guzel_sanatlar'], 'Güzel Sanatlar Fakültesi', true, 'Güzel Sanatlar');
$esikler[] = $drYeniden('mimarlik', ['mimarlik'], null, true, 'Mimarlık ve Tasarım');

// ══════════════════════════════════════════════════════════════════════════
// DOÇENT (Madde 8) — doktora sonrası
// ══════════════════════════════════════════════════════════════════════════

/**
 * @param  list<string>  $alanlar
 * @param  list<array<string, mixed>>  $yayinSarti
 * @return array<string, mixed>
 */
$docent = function (string $anahtar, array $alanlar, ?string $birim, array $yayinSarti, bool $sanat, string $notlar, string $adayNotu) use ($UNIVERSITE, $CETVEL, $DOKTORA, $projeKosulu): array {
    return [
        'anahtar' => "canakkale-{$anahtar}-docent",
        'aday_notu' => $adayNotu,
        'universite' => $UNIVERSITE,
        'kadro' => 'docentlik',
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => $CETVEL,
        'notlar' => $notlar,
        'sart' => Kalip::ve('Doçent kadrosuna atanma', array_values(array_merge(
            [
                Kalip::beyan('Üniversitelerarası Kurul tarafından verilen doçentlik unvanına sahip olmak', 'Madde 8'),
                $projeKosulu(2, 1500, null, 'Madde 8/2', yurutucu: true),
            ],
            $yayinSarti,
            [
                Kalip::puanDan('Doktora unvanınızdan sonra makale, bildiri, kitap, atıf ve proje kalemlerinizden en az 1000 puan', [$sanat ? '1-5-10' : '1-5'], 1000, $DOKTORA, madde: 'Madde 8/13'),
                Kalip::toplam(1500),
            ],
        ))),
    ];
};

$esikler[] = $docent('saglik', ['saglik'], null, [
    Kalip::adet('SCI, SCI-Expanded, SSCI veya AHCI dergilerinde en az 2 özgün araştırma makaleniz olmalı', ['1.a'], 2, madde: 'Madde 8/3'),
    Kalip::adet('SCI-AHCI, ESCI-Scopus ya da diğer uluslararası dergilerde toplam en az 5 yayınınız olmalı', ['1.a-1.d-1.f'], 5, madde: 'Madde 8/3'),
    Kalip::adet('Bu yayınlarınızdan en az 2 tanesinde başlıca yazar olmalısınız', ['1.a-1.d-1.f'], 2, yazar: 'baslica', madde: 'Madde 8/3'),
], false,
    'Madde 8/3 (Sağlık bilimleri): 1(a)\'dan en az 2, toplam 5 yayın, ikisinde başlıca yazar; 8/2 iki dış kaynaklı projede yürütücülük; 8/13 doktora sonrası 1000 puan; 8/15 toplam 1500.',
    'Sağlık bilimleri alanında doçentlik: SCI, SCI-Expanded, SSCI veya AHCI dergilerinde en az 2 özgün araştırma makaleniz olmak kaydıyla toplam en az 5 yayınınız olmalı ve en az 2 tanesinde başlıca yazar olmanız gerekiyor. Ayrıca BAP dışında en az iki dış kaynaklı projede yürütücü olmalısınız (istenen puanın iki katını toplarsanız bu koşul aranmaz). Doktora unvanınızdan sonra makale, bildiri, kitap, atıf ve proje kalemlerinizden en az 1000 puan ve toplamda en az 1500 puan gerekiyor.');

$esikler[] = $docent('fen-muhendislik', ['muhendislik', 'fen', 'ziraat'], null, [
    Kalip::adet('SCI, SCI-Expanded, SSCI veya AHCI dergilerinde en az 1 özgün araştırma makaleniz olmalı', ['1.a'], 1, madde: 'Madde 8/4'),
    Kalip::adet('SCI-AHCI, ESCI-Scopus ya da diğer uluslararası dergilerde toplam en az 5 yayınınız olmalı', ['1.a-1.d-1.f'], 5, madde: 'Madde 8/4'),
    Kalip::adet('Bu yayınlarınızdan en az 2 tanesinde başlıca yazar olmalısınız', ['1.a-1.d-1.f'], 2, yazar: 'baslica', madde: 'Madde 8/4'),
], false,
    'Madde 8/4 (Mühendislik, Fen, Ziraat, Su ürünleri): 1(a)\'dan en az 1, toplam 5 yayın, ikisinde başlıca yazar; 8/13 doktora sonrası 1000 puan; toplam 1500.',
    'Mühendislik, fen bilimleri, ziraat ve su ürünleri alanlarında doçentlik: SCI, SCI-Expanded, SSCI veya AHCI dergilerinde en az 1 özgün araştırma makaleniz olmak kaydıyla toplam en az 5 yayınınız olmalı ve en az 2 tanesinde başlıca yazar olmanız gerekiyor. Ayrıca BAP dışında en az iki dış kaynaklı projede yürütücü olmalısınız (istenen puanın iki katını toplarsanız bu koşul aranmaz). Doktora unvanınızdan sonra makale, bildiri, kitap, atıf ve proje kalemlerinizden en az 1000 puan ve toplamda en az 1500 puan gerekiyor.');

$esikler[] = $docent('egitim', ['egitim'], null, [
    Kalip::adet('SCI-AHCI ya da ESCI-Scopus dergilerinde en az 3 yayınınız olmalı', ['1.a-1.d'], 3, madde: 'Madde 8/5'),
    Kalip::adet('SCI, SCI-Expanded, SSCI veya AHCI dergilerinde en az 1 özgün araştırma makaleniz olmalı', ['1.a'], 1, madde: 'Madde 8/5'),
    Kalip::adet('SCI-AHCI, ESCI-Scopus ya da diğer uluslararası dergilerde toplam en az 5 yayınınız olmalı', ['1.a-1.d-1.f'], 5, madde: 'Madde 8/5'),
    Kalip::adet('Bu yayınlarınızdan en az 2 tanesinde başlıca yazar olmalısınız', ['1.a-1.d-1.f'], 2, yazar: 'baslica', madde: 'Madde 8/5'),
], false,
    'Madde 8/5 (Eğitim bilimleri): 1(a)+1(d)\'den 3 yayın (en az biri 1(a)), 1(f)\'ten 2, toplam 5; ikisinde başlıca yazar. Fıkranın "yayınların tamamı 1(a) ve 1(d)\'den de olabilir" istisnası nedeniyle 1(f) alt sayısı ayrı düğüm olarak YAZILMADI; toplam 5 koşulu onu zaten kapsıyor.',
    'Eğitim bilimleri alanında doçentlik: SCI-AHCI ya da ESCI-Scopus dergilerinde en az 3 yayınınız (en az biri SCI-AHCI grubunda) olmak kaydıyla toplam en az 5 yayınınız olmalı ve en az 2 tanesinde başlıca yazar olmanız gerekiyor. Ayrıca BAP dışında en az iki dış kaynaklı projede yürütücü olmalısınız (istenen puanın iki katını toplarsanız bu koşul aranmaz). Doktora unvanınızdan sonra en az 1000 puan ve toplamda en az 1500 puan gerekiyor.');

$esikler[] = $docent('sosyal', ['sosyal', 'hukuk', 'ilahiyat'], null, [
    Kalip::adet('SCI-AHCI ya da ESCI-Scopus dergilerinde en az 1 yayınınız olmalı', ['1.a-1.d'], 1, madde: 'Madde 8/6'),
    Kalip::adet('SCI-AHCI, ESCI-Scopus ya da diğer uluslararası dergilerde toplam en az 5 yayınınız olmalı', ['1.a-1.d-1.f'], 5, madde: 'Madde 8/6'),
    Kalip::adet('Bu yayınlarınızdan en az 2 tanesinde başlıca yazar olmalısınız', ['1.a-1.d-1.f'], 2, yazar: 'baslica', madde: 'Madde 8/6'),
], false,
    'Madde 8/6 (Sosyal bilimler, Deniz İşletmeciliği, İlahiyat, Hukuk): en az biri 1(a) veya 1(d)\'den, toplam 5 yayın, ikisinde başlıca yazar; toplam 1500.',
    'Sosyal bilimler, deniz işletmeciliği, ilahiyat ve hukuk alanlarında doçentlik: SCI-AHCI ya da ESCI-Scopus dergilerinde en az 1 yayınınız olmak kaydıyla toplam en az 5 yayınınız olmalı ve en az 2 tanesinde başlıca yazar olmanız gerekiyor. Ayrıca BAP dışında en az iki dış kaynaklı projede yürütücü olmalısınız (istenen puanın iki katını toplarsanız bu koşul aranmaz). Doktora unvanınızdan sonra en az 1000 puan ve toplamda en az 1500 puan gerekiyor.');

$esikler[] = $docent('spor', ['spor'], null, [
    Kalip::adet('SCI, SCI-Expanded, SSCI veya AHCI dergilerinde en az 2 özgün araştırma makaleniz olmalı', ['1.a'], 2, madde: 'Madde 8/7'),
    Kalip::adet('ESCI veya Scopus dergilerinde en az 3 yayınınız olmalı', ['1.d'], 3, madde: 'Madde 8/7'),
    Kalip::adet('Bu yayınlarınızdan en az 2 tanesinde başlıca yazar olmalısınız', ['1.a-1.d-1.f'], 2, yazar: 'baslica', madde: 'Madde 8/7'),
], false,
    'Madde 8/7 (Spor bilimleri): 1(a)\'dan 2 ve 1(d)\'den 3, toplam 5 yayın; ikisinde başlıca yazar; toplam 1500.',
    'Spor bilimleri alanında doçentlik: SCI, SCI-Expanded, SSCI veya AHCI dergilerinde en az 2, ESCI veya Scopus dergilerinde en az 3 olmak üzere toplam en az 5 yayınınız olmalı ve en az 2 tanesinde başlıca yazar olmanız gerekiyor. Ayrıca BAP dışında en az iki dış kaynaklı projede yürütücü olmalısınız (istenen puanın iki katını toplarsanız bu koşul aranmaz). Doktora unvanınızdan sonra en az 1000 puan ve toplamda en az 1500 puan gerekiyor.');

$esikler[] = $docent('konservatuvar', ['guzel_sanatlar'], 'Devlet Konservatuvarı', [
    Kalip::adet('Makale ve kitap kalemlerinizden toplam en az 3 yayınınız olmalı', ['1-TUM', '3.a-3.f'], 3, madde: 'Madde 8/8'),
    Kalip::adet('Bu yayınlarınızdan en az birinde başlıca yazar olmalısınız', ['1-TUM', '3.a-3.f'], 1, yazar: 'baslica', madde: 'Madde 8/8'),
], true,
    'Madde 8/8 (Devlet Konservatuvarı): 3 yayın, birinde başlıca yazar; toplam 1500.',
    'Devlet Konservatuvarında doçentlik: makale ve kitap kalemlerinizden toplam en az 3 yayınınız olmalı ve en az birinde başlıca yazar olmanız gerekiyor. Ayrıca BAP dışında en az iki dış kaynaklı projede yürütücü olmalısınız (istenen puanın iki katını toplarsanız bu koşul aranmaz). Doktora unvanınızdan sonra makale, bildiri, kitap, atıf, proje ve sanat etkinliği kalemlerinizden en az 1000 puan ve toplamda en az 1500 puan gerekiyor.');

$esikler[] = $docent('guzel-sanatlar', ['guzel_sanatlar'], 'Güzel Sanatlar Fakültesi', [
    Kalip::adet('Makale ve kitap kalemlerinizden toplam en az 4 yayınınız olmalı', ['1-TUM', '3.a-3.f'], 4, madde: 'Madde 8/9'),
    Kalip::adet('Bu yayınlarınızdan en az birinde başlıca yazar olmalısınız', ['1-TUM', '3.a-3.f'], 1, yazar: 'baslica', madde: 'Madde 8/9'),
    Kalip::adet('Özgün sanat eseriniz, tasarımınız ya da yorum çalışmanızla en az 3 kişisel etkinlikte bulunmuş olmalısınız', ['SANAT-KISISEL'], 3, madde: 'Madde 8/11'),
    Kalip::adet('Sempozyum, festival, çalıştay veya bienal gibi etkinliklere eserinizle ya da bildiriyle en az 3 kez katılmış olmalısınız', ['SANAT-ETKINLIK'], 3, madde: 'Madde 8/12'),
], true,
    'Madde 8/9 (Güzel Sanatlar): 4 yayın, birinde başlıca yazar; 8/11 üç kişisel etkinlik; 8/12 üç sempozyum katılımı; toplam 1500.',
    'Güzel sanatlar alanında doçentlik: makale ve kitap kalemlerinizden toplam en az 4 yayınınız olmalı ve en az birinde başlıca yazar olmanız gerekiyor. Ayrıca en az 3 kişisel sanat etkinliğiniz ve 3 sempozyum/festival katılımınız aranıyor. BAP dışında en az iki dış kaynaklı projede yürütücü olmalısınız (istenen puanın iki katını toplarsanız bu koşul aranmaz). Doktora unvanınızdan sonra en az 1000 puan ve toplamda en az 1500 puan gerekiyor.');

$esikler[] = $docent('mimarlik', ['mimarlik'], null, [
    Kalip::adet('Makale ve kitap kalemlerinizden toplam en az 5 yayınınız olmalı', ['1-TUM', '3.a-3.f'], 5, madde: 'Madde 8/10'),
    Kalip::adet('Bu yayınlarınızdan en az 2 tanesinde başlıca yazar olmalısınız', ['1-TUM', '3.a-3.f'], 2, yazar: 'baslica', madde: 'Madde 8/10'),
], true,
    'Madde 8/10 (Mimarlık ve Tasarım): 5 yayın, ikisinde başlıca yazar; toplam 1500.',
    'Mimarlık ve tasarım alanında doçentlik: makale ve kitap kalemlerinizden toplam en az 5 yayınınız olmalı ve en az 2 tanesinde başlıca yazar olmanız gerekiyor. Ayrıca BAP dışında en az iki dış kaynaklı projede yürütücü olmalısınız (istenen puanın iki katını toplarsanız bu koşul aranmaz). Doktora unvanınızdan sonra en az 1000 puan ve toplamda en az 1500 puan gerekiyor.');

// ══════════════════════════════════════════════════════════════════════════
// PROFESÖR (Madde 9) — doçentlik sonrası
// ══════════════════════════════════════════════════════════════════════════

/**
 * @param  list<string>  $alanlar
 * @param  list<array<string, mixed>>  $yayinSarti
 * @return array<string, mixed>
 */
$profesor = function (string $anahtar, array $alanlar, ?string $birim, array $yayinSarti, bool $sanat, string $notlar, string $adayNotu) use ($UNIVERSITE, $CETVEL, $DOCENTLIK, $projeKosulu): array {
    return [
        'anahtar' => "canakkale-{$anahtar}-profesor",
        'aday_notu' => $adayNotu,
        'universite' => $UNIVERSITE,
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => $CETVEL,
        'notlar' => $notlar,
        'sart' => Kalip::ve('Profesör kadrosuna atanma', array_values(array_merge(
            [
                Kalip::beyan('Doçentlik unvanını aldıktan sonra en az üçü yükseköğretim kurumlarında olmak üzere alanınızda beş yıl çalışmış olmak', 'Madde 9/1'),
                Kalip::beyan('Başvurduğunuz alanda en az dört yarıyıl (iki yıl) ders vermiş ya da veriyor olmak', 'Madde 9/2'),
                Kalip::adet('Biri tamamlanmış olmak üzere en az 2 lisansüstü tez yönetmiş ya da yönetiyor olmalısınız', ['TEZ'], 2, madde: 'Madde 9/3'),
                $projeKosulu(2, 2250, null, 'Madde 9/5', yurutucu: true),
            ],
            $yayinSarti,
            [
                Kalip::puanDan('Doçentlik unvanınızdan sonra makale, bildiri, kitap, atıf ve proje kalemlerinizden en az 1500 puan', [$sanat ? '1-5-10' : '1-5'], 1500, $DOCENTLIK, madde: 'Madde 9/14'),
                Kalip::toplam(2250),
            ],
        ))),
    ];
};

$esikler[] = $profesor('saglik', ['saglik'], null, [
    Kalip::adet('SCI, SCI-Expanded, SSCI veya AHCI dergilerinde en az 3 özgün araştırma makaleniz olmalı', ['1.a'], 3, madde: 'Madde 9/6'),
    Kalip::adet('ESCI-Scopus ya da diğer uluslararası dergilerde en az 4 yayınınız olmalı', ['1.d', '1.f'], 4, madde: 'Madde 9/6'),
    Kalip::adet('Bu yayınlarınızdan en az 2 tanesinde başlıca yazar olmalısınız', ['1.a-1.d-1.f'], 2, yazar: 'baslica', madde: 'Madde 9/6'),
], false,
    'Madde 9/6 (Sağlık bilimleri): 1(a)\'dan 3, 1(d)+1(f)\'ten 4, toplam 7 yayın; ikisinde başlıca yazar; 9/14 doçentlik sonrası 1500 puan; 9/16 toplam 2250.',
    'Sağlık bilimleri alanında profesörlük: SCI, SCI-Expanded, SSCI veya AHCI dergilerinde en az 3, ESCI-Scopus ya da diğer uluslararası dergilerde en az 4 olmak üzere toplam en az 7 yayınınız olmalı ve en az 2 tanesinde başlıca yazar olmanız gerekiyor. Doçentlik unvanınızı aldıktan sonra beş yıl çalışmış, dört yarıyıl ders vermiş ve en az 2 lisansüstü tez yönetmiş olmalısınız. BAP dışında en az iki dış kaynaklı projede yürütücü olmalısınız (istenen puanın iki katını toplarsanız bu koşullar aranmaz). Doçentlik sonrası en az 1500 puan ve toplamda en az 2250 puan gerekiyor.');

$esikler[] = $profesor('fen-muhendislik', ['muhendislik', 'fen', 'ziraat'], null, [
    Kalip::adet('SCI, SCI-Expanded, SSCI veya AHCI dergilerinde en az 3 özgün araştırma makaleniz olmalı', ['1.a'], 3, madde: 'Madde 9/7'),
    Kalip::adet('ESCI-Scopus ya da diğer uluslararası dergilerde en az 4 yayınınız olmalı', ['1.d', '1.f'], 4, madde: 'Madde 9/7'),
    Kalip::adet('Bu yayınlarınızdan en az 2 tanesinde başlıca yazar olmalısınız', ['1.a-1.d-1.f'], 2, yazar: 'baslica', madde: 'Madde 9/7'),
], false,
    'Madde 9/7 (Mühendislik, Fen, Ziraat, Su ürünleri): Sağlık ile aynı yayın şartı; toplam 2250.',
    'Mühendislik, fen bilimleri, ziraat ve su ürünleri alanlarında profesörlük: SCI, SCI-Expanded, SSCI veya AHCI dergilerinde en az 3, ESCI-Scopus ya da diğer uluslararası dergilerde en az 4 olmak üzere toplam en az 7 yayınınız olmalı ve en az 2 tanesinde başlıca yazar olmanız gerekiyor. Doçentlik unvanınızı aldıktan sonra beş yıl çalışmış, dört yarıyıl ders vermiş ve en az 2 lisansüstü tez yönetmiş olmalısınız. BAP dışında en az iki dış kaynaklı projede yürütücü olmalısınız (istenen puanın iki katını toplarsanız bu koşullar aranmaz). Doçentlik sonrası en az 1500 puan ve toplamda en az 2250 puan gerekiyor.');

$esikler[] = $profesor('egitim', ['egitim'], null, [
    Kalip::adet('SCI, SCI-Expanded, SSCI veya AHCI dergilerinde en az 2 özgün araştırma makaleniz olmalı', ['1.a'], 2, madde: 'Madde 9/8'),
    Kalip::adet('ESCI veya Scopus dergilerinde en az 2 yayınınız olmalı', ['1.d'], 2, madde: 'Madde 9/8'),
    Kalip::adet('Diğer uluslararası dergilerde en az 3 yayınınız olmalı', ['1.f'], 3, madde: 'Madde 9/8'),
    Kalip::adet('Bu yayınlarınızdan en az 2 tanesinde başlıca yazar olmalısınız', ['1.a-1.d-1.f'], 2, yazar: 'baslica', madde: 'Madde 9/8'),
], false,
    'Madde 9/8 (Eğitim bilimleri): 1(a)\'dan 2, 1(d)\'den 2, 1(f)\'ten 3, toplam 7 yayın; ikisinde başlıca yazar; toplam 2250.',
    'Eğitim bilimleri alanında profesörlük: SCI, SCI-Expanded, SSCI veya AHCI dergilerinde en az 2, ESCI veya Scopus dergilerinde en az 2, diğer uluslararası dergilerde en az 3 olmak üzere toplam en az 7 yayınınız olmalı ve en az 2 tanesinde başlıca yazar olmanız gerekiyor. Doçentlik unvanınızı aldıktan sonra beş yıl çalışmış, dört yarıyıl ders vermiş ve en az 2 lisansüstü tez yönetmiş olmalısınız. BAP dışında en az iki dış kaynaklı projede yürütücü olmalısınız (istenen puanın iki katını toplarsanız bu koşullar aranmaz). Doçentlik sonrası en az 1500 puan ve toplamda en az 2250 puan gerekiyor.');

$esikler[] = $profesor('sosyal', ['sosyal', 'hukuk', 'ilahiyat'], null, [
    Kalip::adet('SCI-AHCI ya da ESCI-Scopus dergilerinde en az 2 yayınınız olmalı', ['1.a-1.d'], 2, madde: 'Madde 9/9'),
    Kalip::adet('SCI-AHCI, ESCI-Scopus ya da diğer uluslararası dergilerde toplam en az 7 yayınınız olmalı', ['1.a-1.d-1.f'], 7, madde: 'Madde 9/9'),
    Kalip::adet('Bu yayınlarınızdan en az 2 tanesinde başlıca yazar olmalısınız', ['1.a-1.d-1.f'], 2, yazar: 'baslica', madde: 'Madde 9/9'),
], false,
    'Madde 9/9 (Sosyal bilimler, Deniz İşletmeciliği, İlahiyat, Hukuk): en az ikisi 1(a) veya 1(d)\'den, toplam 7 yayın; ikisinde başlıca yazar; toplam 2250.',
    'Sosyal bilimler, deniz işletmeciliği, ilahiyat ve hukuk alanlarında profesörlük: SCI-AHCI ya da ESCI-Scopus dergilerinde en az 2 yayınınız olmak kaydıyla toplam en az 7 yayınınız olmalı ve en az 2 tanesinde başlıca yazar olmanız gerekiyor. Doçentlik unvanınızı aldıktan sonra beş yıl çalışmış, dört yarıyıl ders vermiş ve en az 2 lisansüstü tez yönetmiş olmalısınız. BAP dışında en az iki dış kaynaklı projede yürütücü olmalısınız (istenen puanın iki katını toplarsanız bu koşullar aranmaz). Doçentlik sonrası en az 1500 puan ve toplamda en az 2250 puan gerekiyor.');

$esikler[] = $profesor('spor', ['spor'], null, [
    Kalip::adet('SCI, SCI-Expanded, SSCI veya AHCI dergilerinde en az 3 özgün araştırma makaleniz olmalı', ['1.a'], 3, madde: 'Madde 9/10'),
    Kalip::adet('ESCI veya Scopus dergilerinde en az 4 yayınınız olmalı', ['1.d'], 4, madde: 'Madde 9/10'),
    Kalip::adet('Bu yayınlarınızdan en az 2 tanesinde başlıca yazar olmalısınız', ['1.a-1.d-1.f'], 2, yazar: 'baslica', madde: 'Madde 9/10'),
], false,
    'Madde 9/10 (Spor bilimleri): 1(a)\'dan 3, 1(d)\'den 4, toplam 7 makale; ikisinde başlıca yazar; toplam 2250.',
    'Spor bilimleri alanında profesörlük: SCI, SCI-Expanded, SSCI veya AHCI dergilerinde en az 3, ESCI veya Scopus dergilerinde en az 4 olmak üzere toplam en az 7 makaleniz olmalı ve en az 2 tanesinde başlıca yazar olmanız gerekiyor. Doçentlik unvanınızı aldıktan sonra beş yıl çalışmış, dört yarıyıl ders vermiş ve en az 2 lisansüstü tez yönetmiş olmalısınız. BAP dışında en az iki dış kaynaklı projede yürütücü olmalısınız (istenen puanın iki katını toplarsanız bu koşullar aranmaz). Doçentlik sonrası en az 1500 puan ve toplamda en az 2250 puan gerekiyor.');

$esikler[] = $profesor('konservatuvar', ['guzel_sanatlar'], 'Devlet Konservatuvarı', [
    Kalip::adet('Makale ve kitap kalemlerinizden toplam en az 5 yayınınız olmalı', ['1-TUM', '3.a-3.f'], 5, madde: 'Madde 9/11'),
    Kalip::adet('Bu yayınlarınızdan en az birinde başlıca yazar olmalısınız', ['1-TUM', '3.a-3.f'], 1, yazar: 'baslica', madde: 'Madde 9/11'),
], true,
    'Madde 9/11 (Devlet Konservatuvarı): 5 yayın, birinde başlıca yazar; toplam 2250.',
    'Devlet Konservatuvarında profesörlük: makale ve kitap kalemlerinizden toplam en az 5 yayınınız olmalı ve en az birinde başlıca yazar olmanız gerekiyor. Doçentlik unvanınızı aldıktan sonra beş yıl çalışmış, dört yarıyıl ders vermiş ve en az 2 lisansüstü tez yönetmiş olmalısınız. BAP dışında en az iki dış kaynaklı projede yürütücü olmalısınız (istenen puanın iki katını toplarsanız bu koşullar aranmaz). Doçentlik sonrası makale, bildiri, kitap, atıf, proje ve sanat etkinliği kalemlerinizden en az 1500 puan ve toplamda en az 2250 puan gerekiyor.');

$esikler[] = $profesor('guzel-sanatlar', ['guzel_sanatlar'], 'Güzel Sanatlar Fakültesi', [
    Kalip::adet('Makale ve kitap kalemlerinizden toplam en az 5 yayınınız olmalı', ['1-TUM', '3.a-3.f'], 5, madde: 'Madde 9/12'),
    Kalip::adet('Bu yayınlarınızdan en az birinde başlıca yazar olmalısınız', ['1-TUM', '3.a-3.f'], 1, yazar: 'baslica', madde: 'Madde 9/12'),
], true,
    'Madde 9/12 (Güzel Sanatlar): 5 yayın, birinde başlıca yazar; toplam 2250.',
    'Güzel sanatlar alanında profesörlük: makale ve kitap kalemlerinizden toplam en az 5 yayınınız olmalı ve en az birinde başlıca yazar olmanız gerekiyor. Doçentlik unvanınızı aldıktan sonra beş yıl çalışmış, dört yarıyıl ders vermiş ve en az 2 lisansüstü tez yönetmiş olmalısınız. BAP dışında en az iki dış kaynaklı projede yürütücü olmalısınız (istenen puanın iki katını toplarsanız bu koşullar aranmaz). Doçentlik sonrası en az 1500 puan ve toplamda en az 2250 puan gerekiyor.');

$esikler[] = $profesor('mimarlik', ['mimarlik'], null, [
    Kalip::adet('Makale ve kitap kalemlerinizden toplam en az 7 yayınınız olmalı', ['1-TUM', '3.a-3.f'], 7, madde: 'Madde 9/13'),
    Kalip::adet('Bu yayınlarınızdan en az 2 tanesinde başlıca yazar olmalısınız', ['1-TUM', '3.a-3.f'], 2, yazar: 'baslica', madde: 'Madde 9/13'),
], true,
    'Madde 9/13 (Mimarlık ve Tasarım): 7 yayın, ikisinde başlıca yazar; toplam 2250.',
    'Mimarlık ve tasarım alanında profesörlük: makale ve kitap kalemlerinizden toplam en az 7 yayınınız olmalı ve en az 2 tanesinde başlıca yazar olmanız gerekiyor. Doçentlik unvanınızı aldıktan sonra beş yıl çalışmış, dört yarıyıl ders vermiş ve en az 2 lisansüstü tez yönetmiş olmalısınız. BAP dışında en az iki dış kaynaklı projede yürütücü olmalısınız (istenen puanın iki katını toplarsanız bu koşullar aranmaz). Doçentlik sonrası en az 1500 puan ve toplamda en az 2250 puan gerekiyor.');

return $esikler;
