<?php

/**
 * ÇANKIRI KARATEKİN ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve
 * Atanma Yönergesi
 * Kaynak: pdf/1764310250467.cankiri-karatekin-kriter-26112025.pdf
 * (YÖK onayı 30.10.2025)
 * Cetvel: cetvel/cankiri-2025.php (Tablo 1)
 *
 * ── İKİ ALAN GRUBU, DOKTOR ÖĞRETİM ÜYELİĞİNDE ÜÇ ──
 * Puan eşikleri iki gruba ayrılıyor:
 *   (1) Fen ve Matematik; Mimarlık, Planlama ve Tasarım; Mühendislik;
 *       Sağlık; Ziraat, Orman ve Su Ürünleri
 *   (2) Eğitim; Filoloji; Hukuk; İlahiyat; Sosyal, Beşeri ve İdari
 *       Bilimler; Spor; Güzel Sanatlar
 * Doktor öğretim üyeliğinde (MADDE 8 ve 9) Güzel Sanatlar ikinci gruptan
 * ayrılıp kendi düşük eşiklerini alıyor; doçentlik ve profesörlükte
 * ikinci grubun içinde. On iki temel alanın hepsi kapsanıyor.
 *
 * ── PUAN TELAFİ YOLLARI ──
 * Doçentlik ve profesörlükte asgari puan üç kademeli: temel eşik, TÜBİTAK
 * ya da uluslararası bir projede yürütücülük yapanlar için düşük eşik,
 * tescilli patenti ya da faydalı modeli olanlar için daha da düşük eşik.
 * Üçü de "veya" olarak yazıldı ve proje ile patent koşulları cetvelden
 * hesaplanıyor.
 *
 * ── 2209 DANIŞMANLIĞI VE SEÇENEKLİ ETKİNLİK LİSTESİ ──
 * Bütün kadrolarda iki koşul daha var:
 *   TÜBİTAK 2209-A/B projelerinde akademik danışmanlık (BAŞVURU sürecini
 *       tamamlamak) ya da belli sayıda lisansüstü tez yönetmek. Başvuru
 *       süreci kayıtta taşınmadığı için bu dal beyan; tez dalı cetvelden
 *       hesaplanıyor. Karşılanamazsa Tablo 1'in 1-6 kategorilerinden
 *       ilave puan isteniyor, o da hesaplanıyor.
 *   Tablo 2 "Seçenekli Etkinlik Listesi"nden belli sayıda madde. Otuz
 *       yedi maddenin çoğu (proje destek ofisinde görev, teknokent şirketi,
 *       öğrenci topluluğu danışmanlığı, dernek üyeliği, açık erişim
 *       üyeliği …) faaliyet kaydında karşılıksız; bu dal
 *       `hesaplanamiyor` olarak duruyor ve alternatifi olan ilave puan
 *       koşulu hesaplanıyor.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 6/1-h ve 7/1-f: özel sektör ya da kamu kurumlarıyla belli
 *       sayıda etkinlikte jüri, konuşmacı veya düzenleyici olarak görev
 *       almak — kayıt bu tür görevleri ayrı tutmuyor, beyan olarak
 *       yazıldı.
 *   MADDE 9(1)/e: yeniden atanmada iki TÜBİTAK 2209 danışmanlığı — bu şart
 *       yönergenin yürürlüğe girdiği 30.10.2025'ten itibaren BİR YIL
 *       içindeki atanmalarda uygulanmıyor; beyan olarak yazıldı ve muafiyet
 *       penceresi aday notunda anlatıldı.
 *   MADDE 9(2): önceki atanmalarda puanlanmış yayınların yeniden
 *       atanmada kullanılamaması ve Geçici Madde 2'nin 2023-2025 istisnası.
 *   MADDE 9(5): mazeret, aylıksız izin ve hastalık sürelerinin yeniden
 *       atama süresine eklenmesi.
 *   MADDE 11: Diş Hekimliği Fakültesinde koşulları sağlayan aday
 *       bulunmaması hâlindeki istisna — muafiyet.
 *   Doçentlik ve profesörlükte yabancı dil için sayısal eşik yok;
 *       yalnız doktor öğretim üyeliğine ilk atamada 55 puan aranıyor.
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Çankırı Karatekin Üniversitesi';
$CETVEL = 'cankiri-2025';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

$G1 = ['fen', 'mimarlik', 'muhendislik', 'saglik', 'ziraat'];
$G2 = ['egitim', 'filoloji', 'hukuk', 'ilahiyat', 'sosyal', 'spor'];
$G2_TAM = [...$G2, 'guzel_sanatlar'];

$UNVAN = Kalip::beyan(
    'ÜAK tarafından verilen doçentlik unvanına sahip olmak ya da yurt dışında alınan unvanın 2547 sayılı Kanunun 27. maddesi uyarınca Türkiye\'de geçerli sayıldığını belgelemek',
    'MADDE 7/1-b'
);

$NOT_CETVEL = ' Çok yazarlı yayınlarda puan, yazar sayısı × isim sırası matrisine göre '
    .'bölünüyor. Proje ve tez satırlarına "devam eden" değerleri (tam puanın üçte biri) '
    .'uygulandı, çünkü kayıt tamamlanma durumunu taşımıyor; tamamlanmış bir TÜBİTAK proje '
    .'yürütücülüğü 100 yerine 33 puandan sayılıyor. Hakemlikten en fazla 50, atıflardan 100, '
    .'derslerden 30, idari görevlerden 100 puan alınabiliyor.';

$NOT_TABLO2 = ' Yönergenin "Seçenekli Etkinlik Listesi" koşulu HESAPLANAMIYOR olarak işaretli: '
    .'otuz yedi maddenin çoğu (proje destek ofisinde görev, teknokent şirketi, öğrenci '
    .'topluluğu danışmanlığı, dernek üyeliği, açık erişim üyeliği gibi) faaliyet olarak '
    .'kaydedilemiyor. Bu koşulu sağlayamıyorsanız yönerge alternatif olarak ilave '
    .'puan istiyor; motor o alternatifi hesaplıyor.';

/**
 * Doçentlik ve profesörlükteki üç kademeli puan eşiği.
 *
 * @param  array{int, int}  $temel  [alt küme puanı, toplam]
 * @param  array{int, int}  $proje  proje yürütücülüğü olanlar için
 * @param  array{int, int}  $patent  tescilli patenti olanlar için
 */
$puanEsigi = function (string $grup, string $grupAdi, array $temel, array $proje,
    array $patent, ?array $donem): array {
    $dal = fn (array $degerler): array => Kalip::ve(
        $grupAdi.' kaleminden '.$degerler[0].' ve toplamda '.$degerler[1].' puan',
        [
            Kalip::puanDan($grupAdi.' kaleminden en az '.$degerler[0].' puan almak', [$grup], $degerler[0], $donem, madde: 'Asgari koşullar'),
            Kalip::toplam($degerler[1], $donem),
        ]
    );

    return Kalip::veya('Asgari puan koşullarından birini sağlamak', [
        $dal($temel),
        Kalip::ve('Proje yürütücülüğü olan adaylar için indirimli eşik', [
            Kalip::adet('TÜBİTAK ya da uluslararası kuruluşlarca desteklenen en az bir projede yürütücü olarak görev yapmış olmak', ['PROJE-YURUTUCU'], 1, donem: $donem, madde: 'Asgari koşullar'),
            $dal($proje),
        ]),
        Kalip::ve('Tescilli patenti ya da faydalı modeli olan adaylar için indirimli eşik', [
            Kalip::adet('Ulusal ya da uluslararası tescillenmiş patente veya faydalı modele sahip olmak', ['PATENT-TESCIL'], 1, donem: $donem, madde: 'Asgari koşullar'),
            $dal($patent),
        ]),
    ]);
};

/** 2209 danışmanlığı ya da lisansüstü tez koşulu ve ilave puan telafisi. */
$tez2209 = fn (int $proje2209, int $tez, int $ilave, ?array $donem): array => Kalip::veya(
    'TÜBİTAK 2209 danışmanlığı, lisansüstü tez yönetimi ya da ilave puan koşulunu sağlamak', [
        Kalip::beyan('Akademik danışman olarak yer aldığınız en az '.$proje2209.' TÜBİTAK 2209-A veya 2209-B projesinin başvuru sürecini tamamlamış olmak', 'Asgari koşullar'),
        Kalip::adet('Danışmanlığını yaptığınız en az '.$tez.' lisansüstü tez çalışmasını tamamlamış olmak', ['7.2', '7.3'], $tez, donem: $donem, madde: 'Asgari koşullar'),
        Kalip::puanDan('Bu koşulları sağlayamayanlar için makale, bildiri, kitap, editörlük ve atıf kalemlerinden ilave '.$ilave.' puan almak', ['KATEGORI-1-6'], $ilave, $donem, madde: 'Asgari koşullar'),
    ]
);

/** Tablo 2 seçenekli etkinlik listesi koşulu ve ilave puan telafisi. */
$tablo2 = fn (int $madde, int $ilave, ?array $donem): array => Kalip::veya(
    'Seçenekli etkinlik listesi ya da ilave puan koşulunu sağlamak', [
        Kalip::hesaplanamiyor('Yönergenin "Seçenekli Etkinlik Listesi"nden en az '.$madde.' maddeyi belgelendirerek karşılamak', 'Asgari koşullar'),
        Kalip::toplam($ilave, $donem),
    ]
);

$esikler = [];

// ═══════════════ DOKTOR ÖĞRETİM ÜYESİ — İLK ATAMA ═══════════════
$drTablosu = [
    ['g1', $G1, 'Fen ve Matematik, Mimarlık, Mühendislik, Sağlık ile Ziraat',
        '1.1-1.2', 'SCIE-SSCI-AHCI ve SCOPUS-ESCI makaleleri', 300, 400],
    ['g2', $G2, 'Eğitim, Filoloji, Hukuk, İlahiyat, Sosyal ve Spor Bilimleri',
        '1.1-1.2-1.6', 'SCIE-SSCI-AHCI, SCOPUS-ESCI ve TR Dizin makaleleri', 150, 250],
    ['gs', ['guzel_sanatlar'], 'Güzel Sanatlar',
        '1.1-1.2-1.6', 'SCIE-SSCI-AHCI, SCOPUS-ESCI ve TR Dizin makaleleri', 100, 200],
];

foreach ($drTablosu as [$kod, $alanlar, $ad, $grup, $grupAdi, $altPuan, $toplam]) {
    $esikler[] = [
        'anahtar' => "cankiri-{$kod}-dr",
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => $ad.' doktor öğretim üyeliği ilk atama (MADDE 8): '.$grupAdi.' kaleminden '
            .$altPuan.' ve Tablo 1\'den toplam '.$toplam.' puan.',
        'aday_notu' => $ad.' alanlarında doktor öğretim üyesi kadrosuna İLK ATANMA. Yönerge ilk '
            .'atamada dönem sınırı koymuyor, bütün akademik geçmişiniz sayılıyor. Bilim jürisi '
            .'raporlarından sonra üç öğretim üyesinden oluşan komisyon önünde deneme dersi '
            .'vermeniz gerekiyor.'.$NOT_TABLO2.$NOT_CETVEL,
        'sart' => Kalip::ve('Doktor öğretim üyesi kadrosuna ilk atanma — '.$ad, [
            Kalip::beyan('Doktora ile tıpta, diş hekimliğinde, eczacılıkta veya veteriner hekimlikte uzmanlık ya da sanatta yeterlik eğitimini tamamlamış olmak', 'MADDE 8/1-b'),
            Kalip::yds(55),
            Kalip::beyan('Doçent ve/veya profesör unvanına sahip üç öğretim üyesinden oluşan komisyon önünde, öğretim elemanları ve öğrencilere açık bir deneme dersini başarıyla tamamlamak', 'MADDE 8/3'),
            Kalip::puanDan($grupAdi.' kaleminden en az '.$altPuan.' puan almak', [$grup], $altPuan, madde: 'MADDE 8'),
            Kalip::toplam($toplam),
            $tez2209(2, 2, 50, null),
            $tablo2(3, 50, null),
        ]),
    ];
}

// ═══════════════ DOKTOR ÖĞRETİM ÜYESİ — YENİDEN ATANMA ═══════════════
$yenidenTablosu = [
    ['g1', $G1, 'Fen ve Matematik, Mimarlık, Mühendislik, Sağlık ile Ziraat',
        Kalip::veya('Makale koşulunu sağlamak', [
            Kalip::adet('SCIE, SSCI ya da AHCI kapsamındaki dergilerde en az bir makale yayımlamış olmak', ['1.1'], 1, donem: $SON_ATAMA, madde: 'MADDE 9/1-a'),
            Kalip::adet('SCOPUS ya da ESCI kapsamındaki dergilerde en az iki makale yayımlamış olmak', ['1.2'], 2, donem: $SON_ATAMA, madde: 'MADDE 9/1-a'),
        ])],
    ['g2', $G2, 'Eğitim, Filoloji, Hukuk, İlahiyat, Sosyal ve Spor Bilimleri',
        Kalip::veya('Makale koşulunu sağlamak', [
            Kalip::adet('SCIE, SSCI, AHCI, SCOPUS ya da ESCI kapsamındaki dergilerde en az bir makale yayımlamış olmak', ['1.1-1.2'], 1, donem: $SON_ATAMA, madde: 'MADDE 9/1-b'),
            Kalip::adet('TR Dizin kapsamındaki dergilerde en az iki makale yayımlamış olmak', ['1.6'], 2, donem: $SON_ATAMA, madde: 'MADDE 9/1-b'),
        ])],
    ['gs', ['guzel_sanatlar'], 'Güzel Sanatlar',
        Kalip::adet('SCIE, SSCI, AHCI, SCOPUS, ESCI ya da TR Dizin kapsamındaki dergilerde en az bir makale yayımlamış olmak', ['1.1-1.2-1.6'], 1, donem: $SON_ATAMA, madde: 'MADDE 9/1-c')],
];

foreach ($yenidenTablosu as [$kod, $alanlar, $ad, $makale]) {
    $esikler[] = [
        'anahtar' => "cankiri-{$kod}-dr-yeniden",
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => $ad.' doktor öğretim üyeliği yeniden atanma (MADDE 9): son atanma başvuru '
            .'tarihinden sonra makale koşulu ve Tablo 1\'den toplam 300 puan.',
        'aday_notu' => $ad.' alanlarında doktor öğretim üyesi kadrosuna YENİDEN ATANMA. Yalnız '
            .'SON ATANMA İÇİN YAPILAN BAŞVURU TARİHİNDEN SONRAKİ yayın ve faaliyetler (atıflar '
            .'dâhil) sayılıyor; önceki atanmalarda puanlanmış çalışmalar kullanılamıyor. Son '
            .'atanma süresi BİR YIL olan adaylarda makale koşulu yerine makale '
            .'kalemlerinizden 60 ve toplamda 120 puan yetiyor; motor tam (üç yıllık) değerleri '
            .'uyguluyor, bir yıllık atama süreniz varsa koşul burada olduğundan ağır görünür. '
            .'Yönergenin iki TÜBİTAK 2209 danışmanlığı şartı, yürürlüğe '
            .'girdiği 30.10.2025\'ten itibaren bir yıl içindeki atanmalarda uygulanmıyor.'
            .$NOT_CETVEL,
        'sart' => Kalip::ve('Doktor öğretim üyesi kadrosuna yeniden atanma — '.$ad, [
            $makale,
            Kalip::toplam(300, $SON_ATAMA),
            Kalip::beyan('Son atanma başvurusundan sonra özel sektörle ve/veya kamu kurumlarıyla alanınızla ilgili en az iki etkinlikte jüri, konuşmacı, düzenleyen veya düzenleme kurulu başkanı olarak görev yapmış olmak', 'MADDE 9/1-d'),
            Kalip::beyan('Son atanma başvurusundan sonra akademik danışman olarak yer aldığınız en az iki TÜBİTAK 2209-A veya 2209-B projesinin başvuru sürecini tamamlamış olmak (bu şart 30.10.2026\'ya kadar aranmıyor)', 'MADDE 9/1-e'),
        ]),
    ];
}

// ═══════════════ DOÇENT ═══════════════
$docTablosu = [
    ['g1', $G1, 'Fen ve Matematik, Mimarlık, Mühendislik, Sağlık ile Ziraat',
        '1.1', 'SCIE, SSCI ve AHCI makaleleri', [600, 1000], [500, 950], [400, 900]],
    ['g2', $G2_TAM, 'Eğitim, Filoloji, Hukuk, İlahiyat, Sosyal, Spor ve Güzel Sanatlar',
        '1.1-1.2-1.6', 'SCIE-SSCI-AHCI, SCOPUS-ESCI ve TR Dizin makaleleri',
        [300, 600], [200, 550], [150, 500]],
];

foreach ($docTablosu as [$kod, $alanlar, $ad, $grup, $grupAdi, $temel, $proje, $patent]) {
    $esikler[] = [
        'anahtar' => "cankiri-{$kod}-docentlik",
        'universite' => $UNIVERSITE,
        'kadro' => 'docentlik',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => $ad.' doçentlik (MADDE 7): '.$grupAdi.' kaleminden '.$temel[0].' ve Tablo '
            .'1\'den toplam '.$temel[1].' puan; proje yürütücülüğü ya da tescilli patenti '
            .'olanlar için indirimli eşikler.',
        'aday_notu' => $ad.' alanlarında doçent kadrosuna atanma. Alınması gereken puanların '
            .'TAMAMI doktora, uzmanlık ya da sanatta yeterlik mezuniyetinden SONRAKİ '
            .'çalışmalara ait olmalı. TÜBİTAK ya da uluslararası bir projede yürütücülük '
            .'yaptıysanız veya tescilli bir patentiniz varsa puan eşikleri düşüyor.'
            .$NOT_TABLO2.$NOT_CETVEL,
        'sart' => Kalip::ve('Doçent kadrosuna atanma — '.$ad, [
            $UNVAN,
            $puanEsigi($grup, $grupAdi, $temel, $proje, $patent, $DOKTORA),
            $tez2209(4, 3, 100, $DOKTORA),
            Kalip::beyan('Doktora, uzmanlık ya da sanatta yeterlik mezuniyetinden sonra özel sektörle ve/veya kamu kurumlarıyla alanınızla ilgili en az üç etkinlikte jüri, konuşmacı, düzenleyen veya düzenleme kurulu başkanı olarak görev yapmış olmak', 'MADDE 7/1-f'),
            $tablo2(5, 100, $DOKTORA),
        ]),
    ];
}

// ═══════════════ PROFESÖR ═══════════════
$profTablosu = [
    ['g1', $G1, 'Fen ve Matematik, Mimarlık, Mühendislik, Sağlık ile Ziraat',
        '1.1', 'SCIE, SSCI ve AHCI makaleleri', [600, 1300], [500, 1250], [400, 1200]],
    ['g2', $G2_TAM, 'Eğitim, Filoloji, Hukuk, İlahiyat, Sosyal, Spor ve Güzel Sanatlar',
        '1.1-1.2-1.6', 'SCIE-SSCI-AHCI, SCOPUS-ESCI ve TR Dizin makaleleri',
        [300, 750], [200, 700], [150, 650]],
];

foreach ($profTablosu as [$kod, $alanlar, $ad, $grup, $grupAdi, $temel, $proje, $patent]) {
    $esikler[] = [
        'anahtar' => "cankiri-{$kod}-profesorluk",
        'universite' => $UNIVERSITE,
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => $ad.' profesörlük (MADDE 6): '.$grupAdi.' kaleminden '.$temel[0].' ve Tablo '
            .'1\'den toplam '.$temel[1].' puan; proje yürütücülüğü ya da tescilli patenti '
            .'olanlar için indirimli eşikler.',
        'aday_notu' => $ad.' alanlarında profesör kadrosuna atanma. Alınması gereken puanların '
            .'TAMAMI doçentlik unvanını aldığınız ÜAK başvuru döneminden SONRAKİ çalışmalara '
            .'ait olmalı. Doçentlik sonrası en az iki yıl akademik kadroda görev yapmış ve '
            .'toplam beş yıl ilgili bilim alanında çalışmış olmanız, ayrıca bir çalışmanızı '
            .'başlıca araştırma eseri olarak göstermeniz gerekiyor. TÜBİTAK ya da uluslararası '
            .'bir projede yürütücülük yaptıysanız veya tescilli bir patentiniz varsa puan '
            .'eşikleri düşüyor.'.$NOT_TABLO2.$NOT_CETVEL,
        'sart' => Kalip::ve('Profesör kadrosuna atanma — '.$ad, [
            $UNVAN,
            Kalip::beyan('Doçentlik unvanını aldıktan sonra en az iki yıl bir yükseköğretim kurumunda akademik kadroda görev yapmış olmak şartıyla en az beş yıl ilan edilen profesörlük kadrosuyla ilgili bilim alanında çalışmış olmak', 'MADDE 6/1-b'),
            Kalip::beyan('Doçentlik unvanını aldığı ÜAK başvuru döneminden sonra kendi bilim alanında özgün eserler vermiş ve uygulama alanı bulunan dallarda uygulamaya yönelik çalışmalarda bulunmuş olmak', 'MADDE 6/1-c'),
            Kalip::beyan('Doçentlik unvanını aldığı ÜAK başvuru döneminden sonraki yayınlarınızdan birini başlıca araştırma eseri olarak belirtmiş olmak', 'MADDE 6/1-f'),
            $puanEsigi($grup, $grupAdi, $temel, $proje, $patent, $DOCENTLIK),
            $tez2209(5, 4, 150, $DOCENTLIK),
            Kalip::beyan('Doçentlik unvanını aldığı ÜAK başvuru döneminden sonra özel sektörle ve/veya kamu kurumlarıyla alanınızla ilgili en az beş etkinlikte jüri, konuşmacı, düzenleyen veya düzenleme kurulu başkanı olarak görev yapmış olmak', 'MADDE 6/1-h'),
            $tablo2(6, 150, $DOCENTLIK),
        ]),
    ];
}

return $esikler;
