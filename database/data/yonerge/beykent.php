<?php

/**
 * İSTANBUL BEYKENT ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltme ve Atama
 * Yönergesi
 * Kaynak: pdf/17537097252.beykentuniversitesi.pdf (Senato 10.01.2025,
 * YÖK onayı 11.02.2025)
 * Cetvel: cetvel/beykent-2025.php (Ek-1 puanlama sistemi)
 *
 * ── DOKTOR ÖĞRETİM ÜYELİĞİNDE PUAN BARAJI YOK ──
 * MADDE 4 doktor öğretim üyesi adaylarının "Ek-1'de verilen etkinliklere
 * ve puanlama sistemine göre akademik performans puanları hesap edilir"
 * demekle yetiniyor; sayısal bir baraj koymuyor. Karar üç profesör ya da
 * doçentin yazılı mütalaasına ve yönetim kurulunun görüşüne bırakılmış.
 * Eşik bu yüzden doktora beyanı ile jüri değerlendirmesi beyanından
 * ibaret.
 *
 * ── YENİDEN ATANMADAKİ 40 PUAN BAŞKA BİR YÖNERGEDEN ──
 * MADDE 4 yeniden atanma için "İstanbul Beykent Üniversitesi Akademik
 * Personel Performans Ölçme-Değerlendirme Yönergesi kapsamındaki A grubu
 * faaliyetlerden yıllık ortalama 40 puan" arıyor. Bu, elimizdeki Ek-1
 * çizelgesinin A bölümü DEĞİL, ayrı bir yönergenin puanlaması; o belge
 * elimizde olmadığı için koşul `hesaplanamiyor` olarak yazıldı.
 *
 * ── BEŞ ALAN GRUBU ──
 * MADDE 5 ve MADDE 6 yayın koşullarını beş bilim dalı grubuna göre
 * veriyor: Mühendislik ve Fen Bilimleri, Sosyal Bilimler, Hukuk, Sanat ve
 * Sağlık. Bizim temel alan listemize şöyle düştü:
 *   Mühendislik ve Fen → Mühendislik, Fen ve MİMARLIK. Mimarlık yönergede
 *       ayrıca sayılmıyor; Beykent'te Mimarlık, Mühendislik-Mimarlık
 *       Fakültesinin içinde olduğu ve bu grubun koşulu (üç uluslararası
 *       yayın) sanat grubununkinden (bir etkinlik) AĞIR olduğu için §0
 *       uyarınca buraya bağlandı.
 *   Sosyal Bilimler → Sosyal, Eğitim, Filoloji ve Spor.
 *   Hukuk → Hukuk. Sanat → Güzel Sanatlar. Sağlık → Sağlık.
 * İlahiyat ve Ziraat yönergede hiç geçmiyor; §0 uyarınca eşik yazılmadı.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 4-6'nın jüri oluşturma, mütalaa isteme ve yönetim kurulu
 *       kararı hükümleri — süreç hükümleri.
 *   MADDE 4'ün "yabancı dilde eğitim veren bölümler için ilgili dil
 *       belgesi" koşulu — sayısal eşik verilmemiş, beyan olarak yazıldı.
 *   MADDE 7 (unvanların korunması) ve 2547 sayılı Kanunun 34. maddesine
 *       yapılan yabancı uyruklu öğretim elemanı atıfları.
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'İstanbul Beykent Üniversitesi';
$CETVEL = 'beykent-2025';
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;

$DOKTORA_BEYANI = Kalip::beyan(
    'Doktora ile tıpta, diş hekimliğinde, eczacılıkta veya veteriner hekimlikte uzmanlık unvanına ya da belirlenen sanat dallarının birinde yeterlik kazanmış olmak',
    'MADDE 4'
);
$DIL = Kalip::beyan(
    'Yabancı dilde eğitim veren bir bölüme başvuruyorsanız ilgili dil belgesini başvuru dilekçesine eklemek',
    'MADDE 4'
);
$UNVAN = Kalip::beyan(
    'Üniversitelerarası Kurulca doçentlik unvanı almış olmak ya da yurt dışında kazanılan unvanın 2547 sayılı Kanunun 27. maddesi uyarınca Türkiye\'de geçerli sayılması',
    'MADDE 5'
);

$NOT_CETVEL = ' Ortak çalışmalarda puan A-F kategorilerinde bölünüyor: iki yazarlıda birinci '
    .'yazar %60, ikinci %40; üç ve daha fazla yazarlıda birinci yazar %40, kalan %60 öbür '
    .'yazarlar arasında eşit paylaşılıyor. Kısa bildiri, teknik not, vaka takdimi ve editöre '
    .'mektup gibi yayınlar ilgili satırın %60\'ı kadar puan alıyor; bu oran cetvele gömüldü. '
    .'Ek-1\'de ders verme puanı ders KREDİSİ başına verildiği için girilemedi; ders '
    .'kayıtlarınız toplam puana katkı vermiyor.';

$esikler = [];

$TUM_ALANLAR = ['muhendislik', 'fen', 'mimarlik', 'sosyal', 'egitim', 'filoloji', 'spor',
    'hukuk', 'guzel_sanatlar', 'saglik'];

// ═══════════════ DOKTOR ÖĞRETİM ÜYESİ — İLK ATAMA ═══════════════
$esikler[] = [
    'anahtar' => 'beykent-dr',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => $TUM_ALANLAR,
    'cetvel' => $CETVEL,
    'notlar' => 'MADDE 4: doktor öğretim üyeliğinde sayısal puan barajı yok; Ek-1 puanı '
        .'hesaplanıp üç profesör ya da doçentin mütalaasıyla değerlendiriliyor.',
    'aday_notu' => 'Doktor öğretim üyesi kadrosuna İLK ATANMA. İstanbul Beykent Üniversitesi '
        .'bu kadro için SAYISAL BİR PUAN BARAJI KOYMUYOR: MADDE 4 yalnız Ek-1 puanlama '
        .'sistemine göre akademik performans puanınızın hesaplanacağını, kararın biri birim '
        .'yöneticisi biri de üniversite dışından olmak üzere üç profesör ya da doçentin yazılı '
        .'mütalaasıyla verileceğini söylüyor. Atama en az bir en çok dört yıl süreyle '
        .'yapılıyor.'.$NOT_CETVEL,
    'sart' => Kalip::ve('Doktor öğretim üyesi kadrosuna ilk atanma', [
        $DOKTORA_BEYANI,
        $DIL,
        Kalip::beyan('Biri birim yöneticisi, biri üniversite dışından olmak üzere üç profesör ya da doçentin yazılı mütalaasının olumlu olması', 'MADDE 4'),
    ]),
];

// ═══════════════ DOKTOR ÖĞRETİM ÜYESİ — YENİDEN ATAMA ═══════════════
$esikler[] = [
    'anahtar' => 'beykent-dr-yeniden',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => $TUM_ALANLAR,
    'cetvel' => $CETVEL,
    'notlar' => 'MADDE 4: yeniden atanma için Akademik Personel Performans Ölçme-Değerlendirme '
        .'Yönergesindeki A grubu faaliyetlerden yıllık ortalama 40 puan. O yönerge elimizde '
        .'olmadığı için koşul hesaplanamıyor.',
    'aday_notu' => 'Doktor öğretim üyesi kadrosuna YENİDEN ATANMA. Yönerge yıllık ortalama 40 '
        .'puanı, elimizdeki Ek-1 çizelgesinden değil, İstanbul Beykent Üniversitesi Akademik '
        .'Personel Performans Ölçme-Değerlendirme Yönergesinin A GRUBU faaliyetlerinden '
        .'istiyor. O belge bu motorda girili olmadığı için koşul HESAPLANAMIYOR olarak '
        .'işaretli; kendiniz kontrol etmelisiniz. Başvuru dosyanızı, bir önceki atama '
        .'tarihinden sonraki bilimsel çalışmalarınızla birlikte süre bitiminden en az iki ay '
        .'önce ilgili birime teslim etmeniz gerekiyor.'.$NOT_CETVEL,
    'sart' => Kalip::ve('Doktor öğretim üyesi kadrosuna yeniden atanma', [
        $DOKTORA_BEYANI,
        Kalip::hesaplanamiyor('Akademik Personel Performans Ölçme-Değerlendirme Yönergesi kapsamındaki A grubu faaliyetlerden yıllık ortalama en az 40 puan almak', 'MADDE 4'),
        Kalip::beyan('Başvuru dosyasını görev süresinin bitiminden en az iki ay önce ilgili birim yönetimine teslim etmek', 'MADDE 4'),
    ]),
];

// ═══════════════ DOÇENT (MADDE 5) ═══════════════
$docKosullari = [
    ['muhfen', ['muhendislik', 'fen', 'mimarlik'], 'Mühendislik ve Fen Bilimleri',
        Kalip::adet('A ya da C maddelerinde tanımlı en az üç uluslararası yayın yapmış olmak', ['A-C'], 3, madde: 'MADDE 5/b')],
    ['sosyal', ['sosyal', 'egitim', 'filoloji', 'spor'], 'Sosyal Bilimler',
        Kalip::adet('A ya da C maddelerinde tanımlı en az bir uluslararası yayın yapmış olmak', ['A-C'], 1, madde: 'MADDE 5/c')],
    ['hukuk', ['hukuk'], 'Hukuk',
        Kalip::adet('A, B, C, D ya da F maddelerinde tanımlı en az bir uluslararası veya ulusal yayın yapmış olmak', ['A-B-C-D-F'], 1, madde: 'MADDE 5/ç')],
    ['sanat', ['guzel_sanatlar'], 'Sanat',
        Kalip::adet('L maddesinde tanımlı en az bir sanat ya da tasarım etkinliğinde yer almak', ['L'], 1, madde: 'MADDE 5/d')],
    ['saglik', ['saglik'], 'Sağlık',
        Kalip::adet('A-1 maddesinde tanımlı en az üç uluslararası yayın yapmış olmak', ['A-1'], 3, madde: 'MADDE 5/e')],
];

foreach ($docKosullari as [$kod, $alanlar, $ad, $kosul]) {
    $esikler[] = [
        'anahtar' => "beykent-{$kod}-docentlik",
        'universite' => $UNIVERSITE,
        'kadro' => 'docentlik',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => $ad.' doçentlik (MADDE 5): Ek-1\'den toplam en az 40 puan ve alana özgü '
            .'yayın koşulu.',
        'aday_notu' => $ad.' alanlarında doçent kadrosuna atanma. İki koşul var: Ek-1\'de '
            .'tanımlı etkinliklerden toplam en az 40 puan ve alanınıza özgü yayın koşulu. '
            .'Yönerge bu koşullar için dönem sınırı koymuyor, bütün akademik geçmişiniz '
            .'sayılıyor.'.$NOT_CETVEL,
        'sart' => Kalip::ve('Doçent kadrosuna atanma — '.$ad, [
            $UNVAN,
            $DIL,
            Kalip::toplam(40),
            $kosul,
        ]),
    ];
}

// ═══════════════ PROFESÖR (MADDE 6) ═══════════════
$MADDE6 = Kalip::beyan(
    'Doçentlik unvanını aldıktan sonra en az beş yıl süreyle açık bulunan profesörlük kadrosuyla ilgili bilim alanında çalışmış olmak',
    'MADDE 6/a'
);
$BASLICA_ESER = Kalip::beyan(
    'Doçentlik unvanını aldıktan sonra yaptığınız yayınlardan birini başlıca araştırma eseri olarak göstermek',
    'MADDE 6/a'
);

$profKosullari = [
    ['muhfen', ['muhendislik', 'fen', 'mimarlik'], 'Mühendislik ve Fen Bilimleri', [
        Kalip::adet('Doçentlik sonrası A-1 maddesinde tanımlı en az bir uluslararası yayın yapmış olmak', ['A-1'], 1, donem: $DOCENTLIK, madde: 'MADDE 6/2-a'),
        Kalip::adet('Doçentlik sonrası A ya da C maddelerinde tanımlı toplam en az üç uluslararası yayın yapmış olmak', ['A-C'], 3, donem: $DOCENTLIK, madde: 'MADDE 6/2-a'),
    ]],
    ['sosyal', ['sosyal', 'egitim', 'filoloji', 'spor'], 'Sosyal Bilimler', [
        Kalip::adet('Doçentlik sonrası A ya da C maddelerinde tanımlı en az bir uluslararası yayın yapmış olmak', ['A-C'], 1, donem: $DOCENTLIK, madde: 'MADDE 6/2-b'),
        Kalip::adet('Doçentlik sonrası toplam en az iki uluslararası yayın yapmış olmak', ['A-B-C-D-E-F'], 2, donem: $DOCENTLIK, madde: 'MADDE 6/2-b'),
    ]],
    ['hukuk', ['hukuk'], 'Hukuk', [
        Kalip::adet('Doçentlik sonrası A, B, C, D ya da F maddelerinde tanımlı en az iki uluslararası veya ulusal yayın yapmış olmak', ['A-B-C-D-F'], 2, donem: $DOCENTLIK, madde: 'MADDE 6/2-c'),
    ]],
    ['sanat', ['guzel_sanatlar'], 'Sanat', [
        Kalip::adet('Doçentlik sonrası L maddesinde tanımlı en az iki sanat ya da tasarım etkinliği gerçekleştirmiş olmak', ['L'], 2, donem: $DOCENTLIK, madde: 'MADDE 6/2-d'),
    ]],
    ['saglik', ['saglik'], 'Sağlık', [
        Kalip::adet('Doçentlik sonrası A, B, C, D, E ya da F maddelerinde tanımlı en az iki uluslararası veya ulusal yayın yapmış olmak', ['A-B-C-D-E-F'], 2, donem: $DOCENTLIK, madde: 'MADDE 6/2-ç'),
    ]],
];

foreach ($profKosullari as [$kod, $alanlar, $ad, $kosullar]) {
    $esikler[] = [
        'anahtar' => "beykent-{$kod}-profesorluk",
        'universite' => $UNIVERSITE,
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => $ad.' profesörlük (MADDE 6): Ek-1\'den en az 100 puan (en az 30\'u '
            .'doçentlik sonrası) ve doçentlik sonrası alana özgü yayın koşulu.',
        'aday_notu' => $ad.' alanlarında profesör kadrosuna atanma. Ek-1\'de tanımlı '
            .'etkinliklerden toplam en az 100 puan gerekiyor ve bunun en az 30\'u DOÇENTLİK '
            .'SONRASI çalışmalardan gelmeli. Alana özgü yayın koşulu da doçentlik sonrası '
            .'çalışmalardan sağlanmalı. Ayrıca doçentlik unvanını aldıktan sonra en az beş yıl '
            .'ilgili bilim alanında çalışmış olmanız ve doçentlik sonrası yayınlarınızdan '
            .'birini başlıca araştırma eseri olarak göstermeniz gerekiyor.'.$NOT_CETVEL,
        'sart' => Kalip::ve('Profesör kadrosuna atanma — '.$ad, [
            $UNVAN,
            $DIL,
            $MADDE6,
            $BASLICA_ESER,
            Kalip::toplam(100),
            Kalip::toplam(30, $DOCENTLIK),
            ...$kosullar,
        ]),
    ];
}

return $esikler;
