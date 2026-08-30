<?php

/**
 * KADİR HAS ÜNİVERSİTESİ — Akademik Yükseltilme Ölçütleri ile İlgili Esaslar
 * Kaynak: pdf/17537102022.kadirhasuniversitesi.pdf
 *
 * BELGEDE TARİH YOK: kabul tarihi, karar numarası ya da yürürlük maddesi
 * geçmiyor (EK-4 formundaki yıl sütunları "200." diye basılmış, yani metin
 * 2000'lerden). Cetvel dosyası tarihsiz adlandırıldı: `kadir-has-turler`.
 *
 * ── PUAN TABLOSU YOK, ÖLÇÜT FAKÜLTE BAZLI YAYIN SAYISI ──
 * Esasların gövdesi (Madde 1-11) usul ve nitelik; sayısal ölçütlerin TAMAMI
 * EK-3 "Özel Durumlar"da ve dört fakülte grubu için ayrı ayrı yazılmış:
 * Fen ve Mühendislik, Sosyal-Beşeri-İdari, Hukuk, Güzel Sanatlar. Her biri
 * Madde 9/b, 10/c ve 11/b'yi kendi alanı için "şu şekilde anlaşılmalıdır"
 * diye somutlaştırıyor.
 *
 * Bu yüzden korpusun "kendi puan tablosu olmayan" şeridinde ama ÜAK cetveline
 * de devretmiyor: kendi kategori taksonomisi (EK-1) var, yalnızca puanı yok.
 * Cetvel bu taksonomiden türetilen puansız bir tür sözlüğü.
 *
 * ── KADRO ADI ESKİ ──
 * Metin "yardımcı doçentlik" diyor; 2018'de unvan Doktor Öğretim Üyesi oldu.
 * Kadro `dr_ogr_uyesi` olarak girildi, aday notunda karşılığı söylendi.
 *
 * ── "BAŞLICA ESER" MADDE 8'DE TANIMLI ──
 * Aday ya tek yazar ya "corresponding author" olacak, ya da yayın kendi
 * yürüttüğü bir araştırma projesinden üretilmiş olacak. Motorun `yazar`
 * süzgeci en yakın olarak `baslica` değerini tanıyor; o da tek yazar, birinci
 * isim ve sorumlu yazarı birlikte kabul ediyor. BİRİNCİ İSİM YÖNERGENİN
 * TANIMINDA YOK, yani süzgeç yönergeden bir tık geniş ve koşul olduğundan
 * KOLAY görünebilir. Madde 8(b)'nin proje şıkkı ise kayıttan hiç
 * hesaplanamıyor; ikisi de aday notunda söylendi.
 *
 * Bir "başlıca eser" yalnızca bir yükseltilme aşamasında ve bir kişi için
 * kullanılabiliyor (Madde 8); motor eserlerin başka bir başvuruda kullanılıp
 * kullanılmadığını izlemiyor.
 *
 * ── HER KADRODA ORTAK BEYANLAR ──
 * Referans mektupları (yardımcı doçentlikte 3, doçentlikte 4, profesörlükte 5;
 * sırasıyla en az 1, 2 ve 3'ü yurt dışından), İngilizce seminerde başarılı
 * olmak ve yardımcı doçentlikte yabancı dil belgesi. Hiçbiri faaliyet
 * kaydından hesaplanamaz, beyan olarak girildi.
 *
 * YABANCI DİL EŞİĞİ YAZILMADI: Madde 3/b yalnızca "yabancı dil yeterliliğini
 * gösteren belge (KPDS, TOEFL, IELTS)" diyor, asgari puan vermiyor.
 * `Kalip::yds` uydurma bir sayı isterdi.
 *
 * ── ALAN KAPSAMI: DÖRT FAKÜLTE GRUBU ──
 *   Fen ve Mühendislik Bilim Alanları  → fen, muhendislik
 *   Sosyal, Beşeri ve İdari Bilim Alanları → sosyal
 *   Hukuk Fakültesi                    → hukuk
 *   Güzel Sanatlar Fakültesi           → guzel_sanatlar, mimarlik
 *
 * GÜZEL SANATLAR FAKÜLTESİ MİMARLIĞA DA YAZILDI: fakültenin (b1) koşulu
 * "peyzaj tasarımı, iç mimari tasarım, endüstri ürünleri tasarımı ve grafik
 * tasarım düzeyinde … yarışma" diyor, yani Mimarlık-Planlama-Tasarım temel
 * alanının programlarını sayıyor.
 *
 * ANILMAYAN ALANLARA EŞİK YAZILMADI: Sağlık, Eğitim, İlahiyat, Filoloji,
 * Ziraat ve Spor Bilimleri. Filoloji "Sosyal, Beşeri" başlığına katılabilirdi
 * ama ÜAK taksonomisinde ayrı bir temel alan ve EK-3 onu anmıyor; katmak
 * adaya yönergede yazmayan bir koşul göstermek olurdu.
 *
 * ── GÜZEL SANATLAR'IN KURAMSAL İSTİSNASI ──
 * Doçentlik ve profesörlükte uygulama koşulu (b) var; "kuramsal çalışmaların
 * ağırlık kazandığı alanlarda yapılan başvurularda (b) koşulu aranmaz",
 * yerine (a) kümesinden bir yayın daha isteniyor. Bu bir TELAFİ dalı olarak
 * girildi: uygulama koşulu sağlanmazsa devreye giriyor ve bir fazla yayın
 * arıyor. Adayın kuramsal alanda olup olmadığı kayıttan bilinemediği için
 * telafi herkese açık; koşul o yönde biraz KOLAY görünür.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Madde 3'ün dosya ve belge yükümlülükleri, Madde 4-7'nin ön değerlendirme,
 *       hakem ve raportör usulü.
 *   Madde 10/e ve 11/f: "artı değer katmak üzere dikkate alınacak hususlar"
 *       (bildiriler, eğitim-öğretim, proje yürütücülüğü, patent, ödül,
 *       üniversite yönetimine katkı…). Sayı ya da eşik vermiyor, hakemin
 *       takdirine bırakıyor; koşula çevrilemez.
 *   Dipnot: "yurtdışından yapılacak başvurularda yalnızca Madde 1, 2, 5 ve
 *       6'daki koşullar dikkate alınır ve İngilizce seminer istenir." Adayın
 *       nereden başvurduğu profilde tutulmuyor; aday notunda anıldı.
 *   Fen-Mühendislik doçentliğindeki "lisansüstü ve doktora tezinden
 *       üretilmemiş olması" ile Hukuk doçentliğindeki aynı kayıt: faaliyetin
 *       tezden üretilip üretilmediği kayıtta tutulmuyor. Koşul olduğundan
 *       KOLAY görünür; aday notunda söylendi.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/kadir-has-turler.php
 */

use App\Services\Scoring\Sart\Kalip;

$DOC = Kalip::DOCENTLIK_SONRASI;

$baslicaNotu = '"Başlıca eser" yönergede tek yazar olduğunuz, tek yazar değilseniz sorumlu '
    .'yazar (corresponding author) olduğunuz ya da yürütücüsü olduğunuz bir araştırma '
    .'projesinden üretilmiş yayın olarak tanımlı. Burada yalnızca yazarlık '
    .'tarafı denetlenebiliyor ve birinci isim olduğunuz yayınlar da kabul ediliyor; '
    .'proje şıkkı hiç hesaplanamıyor. Koşul bu yüzden olduğundan kolay görünebilir. Aynı '
    .'eser yalnızca bir yükseltilme aşamasında ve bir kişi için kullanılabilir.';

$ortakNotu = 'Yönerge ayrıca İngilizce seminerde başarılı olmayı ve referans mektuplarını '
    .'şart koşuyor; ikisi de belgeyle sağlanıyor, faaliyet kaydından hesaplanamıyor. '
    .'Yurt dışından başvuruyorsanız yalnızca genel ilkeler ve değerlendirme maddeleri '
    .'uygulanıyor, alana özgü sayısal koşullar aranmıyor (esasların dipnotu).';

$tezdenNotu = 'Yönerge bu yayınların lisansüstü tezinizden üretilmemiş olmasını istiyor; '
    .'kaydınız yayının tezden üretilip üretilmediğini tutmadığı için koşul olduğundan '
    .'kolay görünür.';

/** Yardımcı doçentlik (bugünkü Dr. Öğr. Üyesi) her alanda aynı beyanları taşıyor. */
$drBeyanlari = [
    Kalip::beyan('En az biri yurt dışından olmak üzere üç adet referans mektubu', 'Madde 9/a'),
    Kalip::beyan('Yabancı dil sınavı koşulunu yerine getirmek (KPDS, TOEFL ya da IELTS belgesi)', 'Madde 9/d'),
    Kalip::beyan('İngilizce verilecek seminerde başarılı olmak', 'Madde 9/e'),
];

$docentBeyanlari = [
    Kalip::beyan('YÖK doçentlik unvanına sahip olmak', 'Madde 10/a'),
    Kalip::beyan('En az ikisi yurt dışından olmak üzere dört adet referans mektubu', 'Madde 10/b'),
    Kalip::beyan('İngilizce verilecek seminerde başarılı olmak', 'Madde 10/d'),
];

/**
 * Profesörlüğün alandan bağımsız koşulları: referans mektupları, lisansüstü
 * tez yürütücülüğü, İngilizce seminer ve atıf almış olmak.
 *
 * @return list<array<string, mixed>>
 */
$profesorOrtak = fn (): array => [
    Kalip::beyan('En az üçü yurt dışından olmak üzere beş adet referans mektubu', 'Madde 11/a'),
    Kalip::adet(
        'Yönettiğiniz ve sonuçlanmış en az 1 lisansüstü tez',
        ['K'], 1, madde: 'Madde 11/c',
    ),
    Kalip::beyan('İngilizce verilecek seminerde başarılı olmak', 'Madde 11/d'),
    Kalip::adet(
        'Çalışmalarınızın en az 1 atıf almış olması',
        ['B'], 1, madde: 'Madde 11/e',
    ),
];

return [
    // ══ Fen ve Mühendislik Bilim Alanları ══
    [
        'anahtar' => 'kadir-has-fen-dr',
        'aday_notu' => 'Yönerge "yardımcı doçentlik" diyor; unvan 2018\'de Doktor Öğretim '
            .'Üyesi oldu. Puan barajı yok: tek sayısal koşul SCI kapsamındaki bir dergide '
            .'başlıca eser niteliğinde bir makale. '.$baslicaNotu.' '.$ortakNotu,
        'universite' => 'Kadir Has Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['fen', 'muhendislik'],
        'cetvel' => 'kadir-has-turler',
        'notlar' => 'EK-3, Fen ve Mühendislik Bilim Alanları: "Madde 9b, SCI\'de taranan '
            .'dergilerde yayınlanmış, Başlıca Eser olan en az bir adet A-1 türü yayını olmak '
            .'şeklinde anlaşılmalıdır."',
        'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma', [
            ...$drBeyanlari,
            Kalip::adet(
                'SCI, SSCI ya da AHCI kapsamındaki dergilerde başlıca eser niteliğinde en az 1 makale',
                ['A-1'], 1, 'baslica', madde: 'Madde 9/b',
            ),
        ]),
    ],
    [
        'anahtar' => 'kadir-has-fen-docent',
        'aday_notu' => 'Puan barajı yok. SCI kapsamındaki dergilerde üç makale isteniyor; '
            .'biri başlıca eser olmalı. '.$tezdenNotu.' '.$baslicaNotu.' '.$ortakNotu,
        'universite' => 'Kadir Has Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['fen', 'muhendislik'],
        'cetvel' => 'kadir-has-turler',
        'notlar' => 'EK-3, Fen ve Mühendislik: "Madde 10c, kendisinin lisansüstü ve doktora '
            .'tezinden üretilmemiş olması kaydıyla ve biri Başlıca Eser olmak üzere, en az üç '
            .'adet SCI\'de taranan dergilerde yayınlanmış A-1 türü makale sahibi olmak." '
            .'Tezden üretilmeme kaydı faaliyet kaydında tutulmuyor.',
        'sart' => Kalip::ve('Doçent kadrosuna atanma', [
            ...$docentBeyanlari,
            Kalip::adet(
                'SCI, SSCI ya da AHCI kapsamındaki dergilerde en az 3 makale',
                ['A-1'], 3, madde: 'Madde 10/c',
            ),
            Kalip::adet(
                'Bu makalelerden en az 1 tanesinin başlıca eser niteliğinde olması',
                ['A-1'], 1, 'baslica', madde: 'Madde 10/c',
            ),
        ]),
    ],
    [
        'anahtar' => 'kadir-has-fen-profesor',
        'aday_notu' => 'Puan barajı yok. İki ayrı yayın kümesi isteniyor: SCI kapsamındaki '
            .'dergilerde doçentlik sonrası iki başlıca eser ve diğer uluslararası '
            .'dergilerde en az dört makale. Ayrıca lisansüstü tez yürütücülüğü ve '
            .'çalışmalarınızın atıf almış olması aranıyor. '.$baslicaNotu.' '.$ortakNotu,
        'universite' => 'Kadir Has Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['fen', 'muhendislik'],
        'cetvel' => 'kadir-has-turler',
        'notlar' => 'EK-3, Fen ve Mühendislik: "Madde 11b, iki tanesi doçentlik sonrası '
            .'çalışmalardan ve Başlıca Eser olmak üzere, SCI\'de taranan dergilerde '
            .'yayınlanmış A-1 türü makale ve en az dört tanesi de diğer A kategorisinde '
            .'yeralan kaynaklarda yayınlanmış makale sahibi olmak."',
        'sart' => Kalip::ve('Profesör kadrosuna yükseltilme', [
            ...$profesorOrtak(),
            Kalip::adet(
                'Doçentliğinizden sonra SCI, SSCI ya da AHCI kapsamındaki dergilerde başlıca '
                .'eser niteliğinde en az 2 makale',
                ['A-1'], 2, 'baslica', $DOC, madde: 'Madde 11/b',
            ),
            Kalip::adet(
                'Diğer uluslararası indekslerce taranan dergilerde en az 4 makale',
                ['A-2'], 4, madde: 'Madde 11/b',
            ),
        ]),
    ],

    // ══ Sosyal, Beşeri ve İdari Bilim Alanları ══
    [
        'anahtar' => 'kadir-has-sosyal-dr',
        'aday_notu' => 'Yönerge "yardımcı doçentlik" diyor; unvan 2018\'de Doktor Öğretim '
            .'Üyesi oldu. Puan barajı yok: SSCI kapsamındaki bir dergide makale YA DA '
            .'yabancı dilde yayımlanmış bir kitap veya kitap bölümü yeterli, başlıca eser '
            .'niteliğinde olmak kaydıyla. Kitaplarda yalnızca BKCI ya da Scopus taranan '
            .'olanlar yabancı dil satırına yazıldı; başka bir yabancı dil kitabınız varsa '
            .'koşul olduğundan zor görünür. '.$baslicaNotu.' '.$ortakNotu,
        'universite' => 'Kadir Has Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['sosyal'],
        'cetvel' => 'kadir-has-turler',
        'notlar' => 'EK-3, Sosyal, Beşeri ve İdari Bilim Alanları: "Madde 9b, kendi konusu '
            .'ile ilgili SSCI\'de taranan dergilerde yayınlanmış A-1 türü Başlıca Eser olan '
            .'makale ve/veya D1, D3 türü yabancı dilde yayınlanmış kitap veya kitapta bölümü '
            .'sahibi olmak."',
        'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma', [
            ...$drBeyanlari,
            Kalip::adet(
                'SSCI kapsamındaki dergilerde makale ya da yabancı dilde kitap veya kitap '
                .'bölümü olarak başlıca eser niteliğinde en az 1 yayın',
                ['A-1+D1-D3'], 1, 'baslica', madde: 'Madde 9/b',
            ),
        ]),
    ],
    [
        'anahtar' => 'kadir-has-sosyal-docent',
        'aday_notu' => 'Puan barajı yok. Toplam üç uluslararası yayın isteniyor; bunların '
            .'ikisi SSCI makalesi ya da yabancı dilde kitap veya kitap bölümü olmalı, biri '
            .'de başlıca eser. '.$tezdenNotu.' '.$baslicaNotu.' '.$ortakNotu,
        'universite' => 'Kadir Has Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['sosyal'],
        'cetvel' => 'kadir-has-turler',
        'notlar' => 'EK-3, Sosyal Bilimler: "Madde 10c, bir tanesi adayın yapmış olduğu '
            .'lisansüstü tezlerinden üretilmemiş Başlıca Eser olmak üzere, iki tanesi '
            .'SSCI\'de taranan dergilerde yayınlanmış A-1 türü makale ve/veya D1, D3 türü '
            .'yabancı dilde yayınlanmış kitap veya kitapta bölüm olmak üzere en az üç adet '
            .'uluslararası yayına sahip olmak."',
        'sart' => Kalip::ve('Doçent kadrosuna atanma', [
            ...$docentBeyanlari,
            Kalip::adet(
                'Uluslararası makale, kitap ve kitap bölümlerinizden en az 3 yayın',
                ['A+D1-D3'], 3, madde: 'Madde 10/c',
            ),
            Kalip::adet(
                'Bunların en az 2 tanesinin SSCI makalesi ya da yabancı dilde kitap veya '
                .'kitap bölümü olması',
                ['A-1+D1-D3'], 2, madde: 'Madde 10/c',
            ),
            Kalip::adet(
                'Bunlardan en az 1 tanesinin başlıca eser niteliğinde olması',
                ['A-1+D1-D3'], 1, 'baslica', madde: 'Madde 10/c',
            ),
        ]),
    ],
    [
        'anahtar' => 'kadir-has-sosyal-profesor',
        'aday_notu' => 'Puan barajı yok. En az altı uluslararası yayın (SSCI makalesi ya da '
            .'yabancı dilde kitap veya kitap bölümü) isteniyor; ikisi doçentlik sonrası ve '
            .'başlıca eser olmalı. Yönerge bu koşula bir alternatif de tanıyor: kitap '
            .'editörlüğü. '.$baslicaNotu.' '.$ortakNotu,
        'universite' => 'Kadir Has Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['sosyal'],
        'cetvel' => 'kadir-has-turler',
        'notlar' => 'EK-3, Sosyal Bilimler: "Madde 11b, iki tanesi doçentlik sonrası '
            .'çalışmalarından ve Başlıca Eser olmak üzere, SSCI\'de taranan dergilerde '
            .'yayınlanmış A-1 türü makale ve/veya D1, D3 türü yabancı dilde yayınlanmış kitap '
            .'veya kitapta bölüm olmak üzere en az altı adet uluslararası yayına sahip olmak '
            .'VEYA E kategorisinde editörlük." Sondaki alternatif ayrı bir `veya` dalı.',
        'sart' => Kalip::ve('Profesör kadrosuna yükseltilme', [
            ...$profesorOrtak(),
            Kalip::veya('Yayın koşulu ya da kitap editörlüğü', [
                Kalip::ve('Uluslararası yayın koşulu', [
                    Kalip::adet(
                        'SSCI makaleleriniz ile yabancı dilde kitap ve kitap bölümlerinizden '
                        .'en az 6 yayın',
                        ['A-1+D1-D3'], 6, madde: 'Madde 11/b',
                    ),
                    Kalip::adet(
                        'Bunların en az 2 tanesinin doçentliğinizden sonra yapılmış ve başlıca '
                        .'eser niteliğinde olması',
                        ['A-1+D1-D3'], 2, 'baslica', $DOC, madde: 'Madde 11/b',
                    ),
                ]),
                Kalip::adet('En az 1 kitap editörlüğü', ['E'], 1, madde: 'Madde 11/b'),
            ]),
        ]),
    ],

    // ══ Hukuk Fakültesi ══
    [
        'anahtar' => 'kadir-has-hukuk-dr',
        'aday_notu' => 'Yönerge "yardımcı doçentlik" diyor; unvan 2018\'de Doktor Öğretim '
            .'Üyesi oldu. Puan barajı yok: uluslararası makale kategorilerinden iki yayın '
            .'yeterli. Hukuk Fakültesi koşulları başlıca eser niteliği aramıyor. '.$ortakNotu,
        'universite' => 'Kadir Has Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['hukuk'],
        'cetvel' => 'kadir-has-turler',
        'notlar' => 'EK-3, Hukuk Fakültesi: "Madde 9b, kendi konusu ile ilgili en az iki adet '
            .'A kategorisinde yeralan kaynaklarda yayınlanmış makaleye sahip olmak."',
        'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma', [
            ...$drBeyanlari,
            Kalip::adet(
                'Uluslararası hakemli dergilerde en az 2 makale',
                ['A'], 2, madde: 'Madde 9/b',
            ),
        ]),
    ],
    [
        'anahtar' => 'kadir-has-hukuk-docent',
        'aday_notu' => 'Puan barajı yok. Uluslararası makale kategorilerinden dört yayın '
            .'isteniyor. '.$tezdenNotu.' '.$ortakNotu,
        'universite' => 'Kadir Has Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['hukuk'],
        'cetvel' => 'kadir-has-turler',
        'notlar' => 'EK-3, Hukuk Fakültesi: "Madde 10c, adayın yapmış olduğu lisansüstü '
            .'tezlerden üretilmemiş A kategorisinde yeralan kaynaklarda yayınlanmış en az dört '
            .'makale sahibi olmak."',
        'sart' => Kalip::ve('Doçent kadrosuna atanma', [
            ...$docentBeyanlari,
            Kalip::adet(
                'Uluslararası hakemli dergilerde en az 4 makale',
                ['A'], 4, madde: 'Madde 10/c',
            ),
        ]),
    ],
    [
        'anahtar' => 'kadir-has-hukuk-profesor',
        'aday_notu' => 'Puan barajı yok. Doçentlik sonrası özgün bir bilimsel kitap, toplam '
            .'altı makale ve bunların üçünün doçentlik sonrası uluslararası dergilerde '
            .'yayımlanmış olması isteniyor. '.$ortakNotu,
        'universite' => 'Kadir Has Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['hukuk'],
        'cetvel' => 'kadir-has-turler',
        'notlar' => 'EK-3, Hukuk Fakültesi: "Madde 11b, başvurulan profesörlük bilim alanı '
            .'ile ilgili doçentlik sonrası özgün bir bilimsel kitap yayınlamış olmak, '
            .'doçentlik sonrası çalışmalardan kaynaklanan üç tanesi A kategorisinde yeralan '
            .'kaynaklarda yayınlanmış olmak üzere en az altı adet makale sahibi olmak."',
        'sart' => Kalip::ve('Profesör kadrosuna yükseltilme', [
            ...$profesorOrtak(),
            Kalip::adet(
                'Doçentliğinizden sonra yayımlanmış en az 1 özgün bilimsel kitap',
                ['KITAP'], 1, donem: $DOC, madde: 'Madde 11/b',
            ),
            Kalip::adet(
                'Uluslararası ve yurt içi dergilerdeki makalelerinizden en az 6 yayın',
                ['A', 'I-1', 'I-2'], 6, madde: 'Madde 11/b',
            ),
            Kalip::adet(
                'Bunların en az 3 tanesinin doçentliğinizden sonra uluslararası hakemli '
                .'dergilerde yayımlanmış olması',
                ['A'], 3, donem: $DOC, madde: 'Madde 11/b',
            ),
        ]),
    ],

    // ══ Güzel Sanatlar Fakültesi ══
    [
        'anahtar' => 'kadir-has-guzel-sanatlar-dr',
        'aday_notu' => 'Yönerge "yardımcı doçentlik" diyor; unvan 2018\'de Doktor Öğretim '
            .'Üyesi oldu. Puan barajı yok: uluslararası bir makale ya da yabancı dilde bir '
            .'kitap veya kitap bölümü yeterli, başlıca eser niteliğinde olmak kaydıyla. '
            .$baslicaNotu.' '.$ortakNotu,
        'universite' => 'Kadir Has Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['guzel_sanatlar', 'mimarlik'],
        'cetvel' => 'kadir-has-turler',
        'notlar' => 'EK-3, Güzel Sanatlar Fakültesi: "Madde 9b, kendi konusu ile ilgili en az '
            .'bir adet Başlıca Eser olan A kategorisinde yeralan kaynaklarda yayınlanmış '
            .'makale ve/veya D1, D3 türü yabancı dilde yayınlanmış kitap veya kitapta '
            .'bölümünde yeralan bir çalışmaya sahip olmak." Fakültenin uygulama koşulları '
            .'yardımcı doçentlikte aranmıyor.',
        'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma', [
            ...$drBeyanlari,
            Kalip::adet(
                'Uluslararası makale ya da yabancı dilde kitap veya kitap bölümü olarak '
                .'başlıca eser niteliğinde en az 1 yayın',
                ['A+D1-D3'], 1, 'baslica', madde: 'Madde 9/b',
            ),
        ]),
    ],
    [
        'anahtar' => 'kadir-has-guzel-sanatlar-docent',
        'aday_notu' => 'Puan barajı yok. İki uluslararası yayın (biri doktora sonrası başlıca '
            .'eser) ve ayrıca uygulama alanında bir çalışma isteniyor: bir yarışmada derece '
            .'ya da mansiyon almak veya bir uygulama projesi yayımlamak. Kuramsal '
            .'çalışmaların ağırlıklı olduğu alanlarda uygulama koşulu aranmıyor, yerine bir '
            .'yayın daha isteniyor; alanınızın kuramsal sayılıp sayılmadığı burada '
            .'bilinemediği için bu telafi herkese açık gösteriliyor. '.$baslicaNotu.' '
            .$ortakNotu,
        'universite' => 'Kadir Has Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['guzel_sanatlar', 'mimarlik'],
        'cetvel' => 'kadir-has-turler',
        'notlar' => 'EK-3, Güzel Sanatlar Fakültesi doçentlik: "(a) … en az 2 uluslararası '
            .'yayın sahibi olmak ve (b) uygulama alanında … en az birini gerçekleştirmiş '
            .'olmak; b1 yarışmada derece/mansiyon, b2 uygulama projesi yayımlamak. Ancak '
            .'kuramsal çalışmaların ağırlık kazandığı alanlarda (b) koşulu aranmaz … ek '
            .'olarak bir yayın koşulu aranır." Kuramsal istisna `telafi` dalı olarak girildi.',
        'sart' => Kalip::ve('Doçent kadrosuna atanma', [
            ...$docentBeyanlari,
            Kalip::adet(
                'Uluslararası makale, kitap ve kitap bölümlerinizden en az 2 yayın',
                ['A+D1-D3'], 2, madde: 'Madde 10/c',
            ),
            Kalip::adet(
                'Bunlardan en az 1 tanesinin doktora sonrası ve başlıca eser niteliğinde olması',
                ['A+D1-D3'], 1, 'baslica', Kalip::DOKTORA_SONRASI, madde: 'Madde 10/c',
            ),
            Kalip::veya(
                'Uygulama alanında en az 1 çalışma',
                [
                    Kalip::adet(
                        'Ulusal ya da uluslararası bir yarışmada en az 1 derece veya mansiyon',
                        ['N-3'], 1, madde: 'EK-3 · b1',
                    ),
                    Kalip::adet(
                        'Yayımlanmış en az 1 uygulama projesi',
                        ['R-UYGULAMA'], 1, madde: 'EK-3 · b2',
                    ),
                ],
                telafi: Kalip::adet(
                    'Kuramsal alanlarda uygulama koşulu yerine: uluslararası makale, kitap ve '
                    .'kitap bölümlerinizden 1 yayın daha (toplam 3)',
                    ['A+D1-D3'], 3, madde: 'EK-3 · kuramsal istisna',
                ),
            ),
        ]),
    ],
    [
        'anahtar' => 'kadir-has-guzel-sanatlar-profesor',
        'aday_notu' => 'Puan barajı yok. Beş uluslararası yayın (en az biri doçentlik sonrası '
            .'başlıca eser) ve uygulama alanında iki çalışma isteniyor; ikinci koşulda en az '
            .'bir çalışma doçentlik sonrası olmalı. Kuramsal çalışmaların ağırlıklı olduğu '
            .'alanlarda uygulama koşulu aranmıyor, yerine bir yayın daha isteniyor. '
            .$baslicaNotu.' '.$ortakNotu,
        'universite' => 'Kadir Has Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['guzel_sanatlar', 'mimarlik'],
        'cetvel' => 'kadir-has-turler',
        'notlar' => 'EK-3, Güzel Sanatlar Fakültesi profesörlük: "(a) … en az beş yayını '
            .'olmak, (b) uygulama alanında … en az biri doçentliğe yükseltildikten sonraki '
            .'çalışmalardan olmak üzere en az iki çalışma gerçekleştirmiş olmak." Kuramsal '
            .'istisna `telafi` dalı olarak girildi.',
        'sart' => Kalip::ve('Profesör kadrosuna yükseltilme', [
            ...$profesorOrtak(),
            Kalip::adet(
                'Uluslararası makale, kitap ve kitap bölümlerinizden en az 5 yayın',
                ['A+D1-D3'], 5, madde: 'Madde 11/b',
            ),
            Kalip::adet(
                'Bunlardan en az 1 tanesinin doçentliğinizden sonra ve başlıca eser '
                .'niteliğinde olması',
                ['A+D1-D3'], 1, 'baslica', $DOC, madde: 'Madde 11/b',
            ),
            Kalip::veya(
                'Uygulama alanında en az 2 çalışma, en az 1\'i doçentliğinizden sonra',
                [
                    Kalip::ve('Yarışma dereceleri ve uygulama projeleri', [
                        Kalip::adet(
                            'Yarışma derecesi, mansiyon ve uygulama projelerinizden en az 2 çalışma',
                            ['N-3', 'R-UYGULAMA'], 2, madde: 'EK-3 · b',
                        ),
                        Kalip::adet(
                            'Bunlardan en az 1 tanesinin doçentliğinizden sonra olması',
                            ['N-3', 'R-UYGULAMA'], 1, donem: $DOC, madde: 'EK-3 · b',
                        ),
                    ]),
                ],
                telafi: Kalip::adet(
                    'Kuramsal alanlarda uygulama koşulu yerine: uluslararası makale, kitap ve '
                    .'kitap bölümlerinizden 1 yayın daha (toplam 6)',
                    ['A+D1-D3'], 6, madde: 'EK-3 · kuramsal istisna',
                ),
            ),
        ]),
    ],
];
