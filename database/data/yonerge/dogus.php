<?php

use App\Services\Scoring\Sart\Kalip;

/**
 * DOĞUŞ ÜNİVERSİTESİ — Akademik Yükseltme ve Atama Yönergesi
 * Kaynak: pdf/17537098002.dogusuniversitesi.pdf (19.12.2022 tarih ve
 * 2022/28 sayılı Senato, 2022/27 sayılı Mütevelli Heyet kararı)
 *
 * Cetvel: cetvel/dogus-2022.php
 *
 * ── EŞİKLERİN YAPISI ──
 * Yönerge sayısal olarak yalnızca iki baraj koyuyor: doktor öğretim
 * üyeliğinde MADDE 6/1-a'nın 15 puanı, profesörlükte MADDE 10/7-b'nin 40
 * puanı. Doçentlikte (MADDE 8) tek koşul ÜAK doçentlik unvanı; 8/6'daki
 * a-j listesi jürinin değerlendirme başlıkları, sayısal eşik değil.
 *
 * ── ALAN AYRIMI ──
 * Yönerge bilim dallarını dörde ayırıyor: Mühendislik-Fen-Sağlık,
 * hukuk hariç sosyal alanlar, hukuk, sanatla ilgili dallar. Ziraat
 * yönergede hiç geçmiyor (Doğuş'ta böyle bir birim yok); §0 gereği
 * Mühendislik-Fen-Sağlık grubuna, yani daha ağır olan tarafa bağlandı.
 * Mimarlık, Doğuş'ta Sanat ve Tasarım Fakültesi altında yer aldığı için
 * sanat grubuna alındı.
 *
 * ── YORUM KARARLARI (§0) ──
 *   MADDE 10/7 "a) Doçent unvanını aldıktan sonra, b) Ek-1'de tanımlı
 *       etkinliklerden en az 40 puan toplamış olmak" diyor. (a) bendinin
 *       (b)'yi de kapsayıp kapsamadığı, yani 40 puanın doçentlik sonrasına
 *       mı yoksa tüm kariyere mi ait olduğu açık değil; §0 gereği daha zor
 *       olan okuma seçildi ve 40 puan DOÇENTLİK SONRASI dönemine bağlandı.
 *       Tüm kariyer sayılması gerekiyorsa aracın çıkardığı sonuç
 *       olduğundan katı olur.
 *   MADDE 10/7-3'ün "en az iki adet V maddesinde tanımlı YURT DIŞI
 *       etkinlik" koşulunda yalnızca uluslararası olduğu satırdan belli
 *       olan V-1 (uluslararası müze) ve V-3 (uluslararası seçici kurul)
 *       kalemleri sayılıyor. V-5, V-6 ve V-7 satırları yurt içi ve yurt
 *       dışı etkinlikleri aynı kalemde topladığı için sayım dışı;
 *       dolayısıyla yurt dışı sergi ve gösterileriniz eksik sayılabilir.
 *   MADDE 6/6 görev süresi dolan doktor öğretim üyelerinin "tekrar
 *       atanabilecekleri"ni söylüyor ama yeniden atama için ayrı bir ölçüt
 *       koymuyor; yeniden atamaya ilk atamanın koşulları uygulandı.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 9/2'nin "hukuk bilim dalları hariç kendi bilim alanında
 *       uluslararası düzeyde orijinal eserler vermiş olmak" ve "uygulama
 *       alanı bulunan dallarda uygulamaya yönelik çalışmaları bulunmak"
 *       ifadeleri sayısal karşılığı olmayan nitel ölçütler; somut hâlleri
 *       MADDE 10/7'nin 1-3 bentleriyle zaten sayılıyor.
 *   MADDE 5/2'nin yabancı dilde eğitim veren bölümler için istediği dil
 *       belgesi bölüme bağlı olduğundan beyan olarak eklendi.
 *   MADDE 8/6 ile 10/8'in nitel değerlendirme başlıkları (yayın
 *       sürekliliği, hocalık yeteneği, yurt dışı deneyimi vb.).
 */
$FEN = ['muhendislik', 'fen', 'saglik', 'ziraat'];
$SOSYAL = ['sosyal', 'egitim', 'filoloji', 'ilahiyat', 'spor'];
$HUKUK = ['hukuk'];
$SANAT = ['guzel_sanatlar', 'mimarlik'];

/** Doktor öğretim üyeliği: MADDE 6/1-a ile 6/2-b ve 6/2-c. */
// Adaya gösterilen küme adları (KONVANSIYONLAR §2).
$ASGARI_ADI = [
    'ASGARI' => 'Makale, bildiri, kitap ve proje',
    'ASGARI-SANAT' => 'Makale, bildiri, kitap, proje ve sanatsal etkinlik',
    'ASGARI-HUKUK' => 'Makale, bildiri, kitap, proje, atıf ve toplumsal katkı',
];

$doktorSarti = fn (string $grup, string $madde): array => Kalip::ve('Doktor öğretim üyeliği koşulları', [
    Kalip::beyan('Doktora, tıpta/diş hekimliğinde/eczacılıkta/veteriner hekimlikte uzmanlık ya da sanatta yeterlik unvanına sahip olmak; yabancı dilde eğitim veren bölümlerde ilgili dil belgesini sunmak', 'MADDE 5/2'),
    Kalip::toplam(15, maddeler: [$grup], liste: $ASGARI_ADI[$grup]),
]);

/** Profesörlükte her alanda ortak koşullar: MADDE 9/2, 9/3 ve 10/7-b. */
$profesorOrtak = [
    Kalip::beyan('Doçentlik unvanını aldıktan sonra en az beş yıl, başvurulan profesörlük kadrosuyla ilgili bilim alanında çalışmış olmak', 'MADDE 9/2'),
    Kalip::beyan('Yayınlarınızdan birini başlıca araştırma eseri olarak göstermek', 'MADDE 9/3'),
    Kalip::toplam(40, donem: Kalip::DOCENTLIK_SONRASI),
];

return [
    // ══════════ DOKTOR ÖĞRETİM ÜYELİĞİ ══════════
    [
        'anahtar' => 'dogus-genel-dr',
        'universite' => 'Doğuş Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => [...$FEN, ...$SOSYAL],
        'cetvel' => 'dogus-2022',
        'notlar' => 'MADDE 6/1-a: Ek-1 puanlama sisteminin A, B, C, D, E, F ve S maddelerinde '
            .'tanımlanmış etkinliklerden asgari 15 puan.',
        'aday_notu' => 'Doktor öğretim üyeliği için tek sayısal koşul, uluslararası ve ulusal '
            .'makale, bildiri, kitap ile araştırma projesi kalemlerinizden toplam 15 '
            .'puan. Atıf, hakemlik, editörlük, patent ve ödül puanlarınız bu barajın DIŞINDA '
            .'kalıyor. Puanların Mühendislik, Fen ve Sağlık alanlarında uluslararası '
            .'makalelerden gelmesi '
            .'yönergeye göre "tercih sebebi"; zorunluluk olmadığı için ayrı bir koşul olarak '
            .'aranmıyor. Atamalar en fazla dört yıllık yapılıyor.',
        'sart' => $doktorSarti('ASGARI', 'MADDE 6/1-a'),
    ],
    [
        'anahtar' => 'dogus-genel-dr-yeniden',
        'universite' => 'Doğuş Üniversitesi',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => [...$FEN, ...$SOSYAL],
        'cetvel' => 'dogus-2022',
        'notlar' => 'MADDE 6/6 görev süresi sona erenlerin tekrar atanabileceğini söylüyor, ayrı '
            .'bir ölçüt koymuyor; ilk atama koşulları uygulandı.',
        'aday_notu' => 'Yönerge yeniden atama için ayrı bir ölçüt tanımlamıyor; yalnızca '
            .'"görev süresi sona erenler tekrar atanabilirler" diyor. Bu yüzden ilk atamanın 15 '
            .'puanlık koşulu uygulandı. Biriminizin ayrıca bir yeniden atama beklentisi olabilir.',
        'sart' => $doktorSarti('ASGARI', 'MADDE 6/1-a'),
    ],
    [
        'anahtar' => 'dogus-sanat-dr',
        'universite' => 'Doğuş Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $SANAT,
        'cetvel' => 'dogus-2022',
        'notlar' => 'MADDE 6/2-b: sanatla ilgili bilim dallarında asgari puan hesabına V '
            .'maddesindeki etkinlikler de dahil edilir.',
        'aday_notu' => 'Sanatla ilgili dallarda 15 puanlık barajın kaynağına, A-F ve S '
            .'maddelerinin yanında V maddesindeki sanatsal etkinlikler de ekleniyor.',
        'sart' => $doktorSarti('ASGARI-SANAT', 'MADDE 6/1-a, 6/2-b'),
    ],
    [
        'anahtar' => 'dogus-sanat-dr-yeniden',
        'universite' => 'Doğuş Üniversitesi',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $SANAT,
        'cetvel' => 'dogus-2022',
        'notlar' => 'MADDE 6/6 için ayrı ölçüt yok; ilk atama koşulları uygulandı.',
        'aday_notu' => 'Yönerge yeniden atama için ayrı ölçüt tanımlamadığından ilk atamanın '
            .'koşulları uygulandı: A-F, S ve V maddelerinden 15 puan.',
        'sart' => $doktorSarti('ASGARI-SANAT', 'MADDE 6/1-a, 6/2-b'),
    ],
    [
        'anahtar' => 'dogus-hukuk-dr',
        'universite' => 'Doğuş Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $HUKUK,
        'cetvel' => 'dogus-2022',
        'notlar' => 'MADDE 6/2-c: hukuk bilim dallarında asgari puan hesabına G, H, J, L ve N '
            .'maddeleri de dahil edilir.',
        'aday_notu' => 'Hukuk dallarında 15 puanlık barajın kaynağına, A-F ve S maddelerinin '
            .'yanında G (basılmış bilimsel rapor), H (atıflar), J (hakemlik), L (yayın kurulu '
            .'üyeliği) ve N (ulusal dergi editörlüğü) de ekleniyor.',
        'sart' => $doktorSarti('ASGARI-HUKUK', 'MADDE 6/1-a, 6/2-c'),
    ],
    [
        'anahtar' => 'dogus-hukuk-dr-yeniden',
        'universite' => 'Doğuş Üniversitesi',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $HUKUK,
        'cetvel' => 'dogus-2022',
        'notlar' => 'MADDE 6/6 için ayrı ölçüt yok; ilk atama koşulları uygulandı.',
        'aday_notu' => 'Yönerge yeniden atama için ayrı ölçüt tanımlamadığından ilk atamanın '
            .'koşulları uygulandı: A-F, S ile G, H, J, L ve N maddelerinden 15 puan.',
        'sart' => $doktorSarti('ASGARI-HUKUK', 'MADDE 6/1-a, 6/2-c'),
    ],

    // ══════════ DOÇENTLİK ══════════
    [
        'anahtar' => 'dogus-docentlik',
        'universite' => 'Doğuş Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => [...$FEN, ...$SOSYAL, ...$HUKUK, ...$SANAT],
        'cetvel' => 'dogus-2022',
        'notlar' => 'MADDE 8/1: tek koşul ÜAK tarafından verilen doçentlik unvanı. MADDE 8/6\'daki '
            .'a-j listesi jürinin değerlendirme başlıkları, sayısal eşik değil.',
        'aday_notu' => 'Doğuş\'ta doçent kadrosuna atanmak için yönergenin koyduğu tek koşul, '
            .'Üniversitelerarası Kurulun verdiği doçentlik unvanına sahip olmak (ya da yurt dışında '
            .'kazanılan unvanın ÜAK kararıyla Türkiye\'de geçerli sayılması). Yönerge ayrıca bir '
            .'puan barajı koymuyor; yönergede sayılan yayın sürekliliği, atıflar, hocalık '
            .'yeteneği, tez danışmanlıkları, ödüller ve yurt dışı deneyimi gibi başlıklar üç '
            .'profesörden oluşan jürinin nitel değerlendirme ölçütleri.',
        'sart' => Kalip::beyan('Üniversitelerarası Kurul tarafından verilen doçentlik unvanına sahip olmak ya da yurt dışında kazanılan doçentlik unvanının ÜAK kararıyla Türkiye\'de geçerli sayılması', 'MADDE 8/1'),
    ],

    // ══════════ PROFESÖRLÜK ══════════
    [
        'anahtar' => 'dogus-fen-profesorluk',
        'universite' => 'Doğuş Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $FEN,
        'cetvel' => 'dogus-2022',
        'notlar' => 'MADDE 10/7-b ve 10/7-1: 40 puan ile biri başlıca yazar olmak üzere en az üç '
            .'adet A maddesinde tanımlı uluslararası yayın.',
        'aday_notu' => 'Mühendislik, Fen ve Sağlık dallarında profesörlük için tüm faaliyetlerinizden 40 puan '
            .'ile A maddesinde tanımlı (SCI-Expanded, SSCI, AHCI ya da diğer uluslararası indeksli '
            .'dergilerde) en az üç uluslararası yayın gerekiyor; bunlardan birinde ÜAK doçentlik '
            .'ölçütlerine göre başlıca yazar olmalısınız. Yönerge 40 puanın hangi döneme ait '
            .'olduğunu açıkça yazmadığı için daha zor olan okuma seçildi ve puan doçentlik '
            .'sonrasından sayıldı; tüm kariyeriniz sayılıyorsa buradaki sonuç olduğundan katıdır. '
            .'Ziraat alanı yönergede geçmediği için bu gruba bağlandı.',
        'sart' => Kalip::ve('Profesörlük koşulları', [
            ...$profesorOrtak,
            Kalip::adet('A maddesinde tanımlı en az üç uluslararası yayın', ['A'], 3, donem: Kalip::DOCENTLIK_SONRASI, madde: 'MADDE 10/7-1'),
            Kalip::adet('Bu yayınlardan en az birinde ÜAK doçentlik ölçütlerine göre başlıca yazar olmak', ['A'], 1, yazar: 'baslica', donem: Kalip::DOCENTLIK_SONRASI, madde: 'MADDE 10/7-1'),
        ]),
    ],
    [
        'anahtar' => 'dogus-sosyal-profesorluk',
        'universite' => 'Doğuş Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $SOSYAL,
        'cetvel' => 'dogus-2022',
        'notlar' => 'MADDE 10/7-b ve 10/7-2: 40 puan ile en az biri A, B veya C maddesinde tanımlı '
            .'olmak üzere toplam bir adet uluslararası yayın.',
        'aday_notu' => 'Hukuk dışındaki sosyal bilim alanlarında profesörlük için tüm faaliyetlerinizden 40 puan '
            .'ile A (uluslararası makale), B (uluslararası bildiri) veya C (uluslararası kitap) '
            .'maddesinde tanımlı en az bir uluslararası yayın gerekiyor. Yönerge 40 puanın hangi '
            .'döneme ait olduğunu açıkça yazmadığı için puan doçentlik sonrasından sayıldı.',
        'sart' => Kalip::ve('Profesörlük koşulları', [
            ...$profesorOrtak,
            Kalip::adet('A, B veya C maddesinde tanımlı en az bir uluslararası yayın', ['A-B-C'], 1, donem: Kalip::DOCENTLIK_SONRASI, madde: 'MADDE 10/7-2'),
        ]),
    ],
    [
        'anahtar' => 'dogus-hukuk-profesorluk',
        'universite' => 'Doğuş Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $HUKUK,
        'cetvel' => 'dogus-2022',
        'notlar' => 'MADDE 10/7-b. 10/7\'nin 1, 2 ve 3 numaralı bentleri hukuk dallarını kapsam '
            .'dışında bırakıyor; hukukta yalnızca 40 puan koşulu var.',
        'aday_notu' => 'Hukuk dallarında profesörlük için tüm faaliyetlerinizden 40 puan tek sayısal koşul. '
            .'Yönergenin uluslararası yayın sayısı isteyen bentleri hukuku kapsamıyor; başlıca '
            .'eser maddesi de "hukuk bilim dalları hariç" diyerek uluslararası orijinal eser '
            .'koşulunu hukuk '
            .'dışında bırakıyor. Yönerge 40 puanın hangi döneme ait olduğunu açıkça yazmadığı için '
            .'puan doçentlik sonrasından sayıldı.',
        'sart' => Kalip::ve('Profesörlük koşulları', $profesorOrtak),
    ],
    [
        'anahtar' => 'dogus-sanat-profesorluk',
        'universite' => 'Doğuş Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $SANAT,
        'cetvel' => 'dogus-2022',
        'notlar' => 'MADDE 10/7-b ve 10/7-3: 40 puan ile en az iki adet V maddesinde tanımlı yurt '
            .'dışı etkinlik. Yurt dışı ayrımı yalnızca V-1 ve V-3 satırlarında kesin olduğundan '
            .'sayım bu iki kalemle sınırlı tutuldu.',
        'aday_notu' => 'Sanatla ilgili dallarda profesörlük için tüm faaliyetlerinizden 40 puan ile V '
            .'maddesinde tanımlı en az iki YURT DIŞI etkinlik gerekiyor. Yönergenin V bölümündeki '
            .'kişisel sergi, karma sergi ve sinema satırları yurt içi ile yurt dışı etkinlikleri '
            .'aynı kalemde topladığı için sayıma yalnızca uluslararası olduğu satırdan belli olan '
            .'iki kalem giriyor: eserin uluslararası müzelerde yer alması ve uluslararası seçici '
            .'kurullu etkinliklere kabul edilmesi. Yurt dışındaki kişisel serginiz ya da '
            .'gösteriniz varsa bu koşulu araç göründüğünden daha zor sayar.',
        'sart' => Kalip::ve('Profesörlük koşulları', [
            ...$profesorOrtak,
            Kalip::adet('V maddesinde tanımlı en az iki yurt dışı etkinlik', ['V-YURTDISI'], 2, donem: Kalip::DOCENTLIK_SONRASI, madde: 'MADDE 10/7-3'),
        ]),
    ],
];
