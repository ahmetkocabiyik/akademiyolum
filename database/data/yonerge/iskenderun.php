<?php

/**
 * İSKENDERUN TEKNİK ÜNİVERSİTESİ (İSTE) — Öğretim Üyeliğine Atanma Ek Koşulları
 * Kaynak: pdf/17536996692.iskenderunteknikuniverstesi.pdf
 *
 * KENDİ PUAN TABLOSU YOK. Yönerge hiçbir yerde puan istemiyor; koşulların
 * tamamı SAYI ve NİTELİK üzerine kurulu. Bu yüzden cetvel olarak ÜAK doçentlik
 * tablosu (`uak-2024-mart-{alan}`) kullanıldı — koşulların andığı kalemleri
 * (SCI makalesi, ESCI makalesi, TR Dizin makalesi, kitap, patent, proje, tez
 * danışmanlığı) o cetvel zaten tanımlıyor. Korpusta aynı deseni Batman ve
 * Bursa Uludağ da kullanıyor.
 *
 * "EN AZ ÜÇÜNÜN / DÖRDÜNÜN GERÇEKLEŞMİŞ OLMASI" — motorun `k_ile` düğümü tam
 * bunun için. Doçentlikte 17 seçenekten 3'ü, profesörlükte 19 seçenekten 4'ü
 * isteniyor. Korpusta k-of-n yapısını bu ölçekte kullanan ilk yönerge.
 *
 * SEÇENEK LİSTESİNİN ÇOĞU BEYAN. "Son 3 yılda akademik teşvik ödeneğinden
 * yararlanmış olmak", "h-indeksi en az 5 olmak", "en az 2 aylık yurt dışı
 * araştırma tecrübesi", "Teknoparkta start-up kurmuş olmak" gibi maddeler
 * faaliyet kaydından hesaplanamıyor. Hesaplanabilenler (makale, kitap, patent,
 * proje, tez) düğüm olarak; kalanı beyan olarak duruyor. `k_ile` sayımı ikisini
 * birlikte yapıyor, yani aday beyanlarını işaretleyerek eşiği geçebiliyor.
 *
 * PROFESÖRLÜKTE ÜAK KOŞULLARININ TEKRARI: "adayın doçent olduğu tarihte
 * yürürlükte olan doçentlik başvuru asgari koşullarını, doçent unvanını almak
 * için kullandığı eserlerden sonra yaptığı çalışmalarla en az bir kez daha
 * sağlamak". Hangi dönemin ÜAK koşullarının geçerli olduğu adayın doçentlik
 * tarihine bağlı olduğu için güncel ÜAK toplamı (100) doçentlik sonrası
 * dönemde isteniyor.
 *
 * ATIF SAYISI ALANA GÖRE DEĞİŞİYOR ve seçenek listesinin içinde: doçentlikte
 * Mühendislik/Fen için 30, Sosyal/Mimarlık için 10; profesörlükte 70 ve 20.
 * Bu yüzden doçentlik ve profesörlük eşikleri alan grubuna göre ikiye ayrıldı.
 *
 * YENİDEN ATANMA GİRİLMEDİ: koşullar son atama tarihine bağlı.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: uak-2024-mart-{alan}
 */

use App\Services\Scoring\Sart\Kalip;

$DOC = Kalip::DOCENTLIK_SONRASI;

$fenGrubu = ['fen', 'muhendislik', 'ziraat', 'saglik'];
$sosyalGrubu = ['sosyal', 'mimarlik', 'egitim', 'hukuk', 'ilahiyat', 'filoloji', 'spor'];
$tumAlanlar = [...$fenGrubu, ...$sosyalGrubu, 'guzel_sanatlar'];

$yenidenAtamaNotu = 'Yeniden atanma koşulları son atama tarihinize bağlı; o tarih burada '
    .'tutulmadığı için yeniden atanma eşiği girilmedi.';

$seminerKosulu = Kalip::beyan('Başvurduğunuz alanla ilgili olmak üzere üniversite, sanayi, kamu '
    .'veya topluma yönelik bir konferans, seminer ya da sanatsal etkinlik vermiş olmak '
    .'(başvuru sürecinde de yapılabilir)', 'Ek koşullar');

/**
 * Doçentlik ve profesörlükte ortak olan seçenek listesi. Hesaplanabilen
 * maddeler düğüm, hesaplanamayanlar beyan olarak veriliyor.
 *
 * @return list<array<string, mixed>>
 */
$seceneklerOrtak = function (int $atifSayisi, string $madde, ?array $donem): array {
    return [
        Kalip::adet('Uluslararası bir projede (AB Çerçeve vb.) yürütücü ya da araştırmacı olmak',
            ['7a*', '7b'], 1, donem: $donem, madde: $madde),
        Kalip::adet('Alanınızla ilgili en az 1 patent başvurusu ya da tescili',
            ['10*'], 1, donem: $donem, madde: $madde),
        Kalip::adet('TÜBİTAK 1001, 1002, 1003, 1005, 3001 veya 3501 gibi tamamlanmış bir projede '
            .'yürütücü ya da araştırmacı olmak', ['7'], 1, donem: $donem, madde: $madde),
        Kalip::adet('ESCI dergilerde en az 1 makale yayımlamış olmak',
            ['1c'], 1, donem: $donem, madde: $madde),
        Kalip::adet('ULAKBİM TR Dizin dergilerde en az 1 makale yayımlamış olmak',
            ['2a'], 1, donem: $donem, madde: $madde),
        Kalip::adet('Tanınmış uluslararası yayınevince yayımlanmış bilimsel kitap, kitap bölümü '
            .'ya da kitap editörlüğü', ['4a', '4b'], 1, donem: $donem, madde: $madde),
        Kalip::beyan('Yayınlarınıza SCI, SCI-E, SSCI veya AHCI dergilerinde başka yazarlarca '
            ."yapılmış en az {$atifSayisi} atıf bulunması", $madde),
        Kalip::beyan('Alanınızla ilgili en az 1 bilimsel etkinlik düzenlemiş olmak', $madde),
        Kalip::beyan('Akademik teşvik ödeneğinden yararlanmış olmak', $madde),
        Kalip::beyan('En az 2 aylık yurt dışı araştırma tecrübesine sahip olmak', $madde),
        Kalip::beyan('En az 2 yıl süreyle senatoda temsil edilen bir birimde idari görevde '
            .'bulunmuş olmak', $madde),
        Kalip::beyan('SANTEZ, TÜBİTAK-TEYDEB veya benzeri bir projenin danışmanlığını yapmış '
            .'olmak', $madde),
        Kalip::beyan('h-indeksinizin en az 5 olması', $madde),
        Kalip::beyan('SCI, SCI-E, SSCI, AHCI, ESCI ya da ULAKBİM taranan bir derginin '
            .'yardımcı veya alan editörü olmak', $madde),
        Kalip::beyan('Teknoloji Transfer Ofisinde ya da teknoparkta kontratlı Ar-Ge projesi '
            .'danışmanlığı yapmış olmak', $madde),
        Kalip::beyan('Teknoparkta en az bir start-up şirket kurmuş olmak', $madde),
        Kalip::beyan('Bir öğrenci topluluğunun akademik danışmanlığını en az 1 akademik yıl '
            .'yapmış olmak ya da en az 1 sosyal sorumluluk projesine danışmanlık etmek', $madde),
        Kalip::beyan('Kabul edilmiş bir TÜBİTAK 2209 projesinde akademik danışman olmak ya da '
            .'2244 Sanayi Doktora Programında öğrenci danışmanlığı yapmak', $madde),
        Kalip::beyan('TEKNOFEST veya TÜBİTAK yarışmalarında finale kalan bir projede akademik '
            .'danışman olmak', $madde),
        Kalip::beyan('İlgili kuruluşlarca düzenlenen bir yarışmada derece veya mansiyon almak',
            $madde),
        Kalip::beyan('Orkestra, koro veya topluluk etkinliklerinde en az 2 kez davetli sanatçı '
            .'olarak yer almış olmak', $madde),
    ];
};

return [
    // ══════════ DR. ÖĞRETİM ÜYESİ (ilk atama) ══════════
    [
        'anahtar' => 'iskenderun-dr-fen',
        'aday_notu' => 'İSTE hiçbir kadroda PUAN İSTEMİYOR; bütün koşullar yayın sayısı ve '
            .'nitelik üzerine kurulu. Lisansüstü çalışmalarınızdan üretilen yayınlarda diğer '
            .'yazarlar danışmanlarınızsa birinci isim sayılıyorsunuz. '.$yenidenAtamaNotu,
        'universite' => 'İskenderun Teknik Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['fen', 'muhendislik', 'ziraat'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Dr. Öğr. Üyesi ilk atanma: SSCI/SCI/SCI-E/AHCI dergide ilk isim ya da '
            .'başlıca yazar olarak 1 özgün araştırma makalesi ve 1 sözlü sunum.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Fen Bilimleri ve Mühendislik', [
            Kalip::adet('SCI, SCI-Expanded, SSCI veya AHCI dergide ilk isim ya da başlıca yazar '
                .'olarak en az 1 özgün araştırma makalesi', ['1a-*', '1b'], 1, 'ilk',
                madde: 'Dr. ilk atanma'),
            Kalip::adet('Ulusal ya da uluslararası bir bilimsel toplantıda en az 1 sözlü sunum',
                ['8*'], 1, madde: 'Dr. ilk atanma'),
            $seminerKosulu,
        ]),
    ],
    [
        'anahtar' => 'iskenderun-dr-sosyal',
        'aday_notu' => 'İSTE hiçbir kadroda PUAN İSTEMİYOR; bütün koşullar yayın sayısı ve '
            .'nitelik üzerine kurulu. Makale koşulunun kitap alternatifi var: 2 makale yerine '
            .'tanınmış uluslararası yayınevinden 1 kitap da yeterli. '.$yenidenAtamaNotu,
        'universite' => 'İskenderun Teknik Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => [...$sosyalGrubu, 'guzel_sanatlar'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Dr. Öğr. Üyesi ilk atanma: indeksli dergilerde ilk isim ya da başlıca yazar '
            .'olarak 2 özgün araştırma makalesi veya 1 uluslararası kitap, ayrıca 1 sözlü sunum.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Sosyal, Mimarlık, Güzel Sanatlar ve diğer alanlar', [
            Kalip::veya('Yayın koşulu', [
                Kalip::adet('İndeksli dergilerde ilk isim ya da başlıca yazar olarak en az '
                    .'2 özgün araştırma makalesi', ['1a-*', '1b', '1c', '1d', '2a'], 2, 'ilk',
                    madde: 'Dr. ilk atanma'),
                Kalip::adet('Tanınmış uluslararası yayınevince yayımlanmış en az 1 bilimsel '
                    .'kitap, kitap bölümü ya da kitap editörlüğü', ['4a', '4b'], 1,
                    madde: 'Dr. ilk atanma'),
            ]),
            Kalip::adet('Ulusal ya da uluslararası bir bilimsel toplantıda en az 1 sözlü sunum',
                ['8*'], 1, madde: 'Dr. ilk atanma'),
            $seminerKosulu,
        ]),
    ],

    // ══════════ DOÇENT (17 seçenekten en az 3'ü) ══════════
    [
        'anahtar' => 'iskenderun-docent-fen',
        'aday_notu' => 'Doçentlikte puan yerine SEÇENEK SAYISI isteniyor: aşağıdaki listeden en '
            .'az ÜÇÜNÜ sağlamanız yeterli. Listenin bir kısmı faaliyet kaydınızdan otomatik '
            .'hesaplanıyor, geri kalanını kendiniz onaylıyorsunuz.',
        'universite' => 'İskenderun Teknik Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $fenGrubu,
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Doçent ek koşulları: doçentlik unvanı, konferans/seminer verme ve listedeki '
            .'seçeneklerden en az üçü. Atıf seçeneği Mühendislik ve Fen için 30.',
        'sart' => Kalip::ve('Doçent — Fen Bilimleri, Mühendislik ve Sağlık', [
            Kalip::beyan('Üniversitelerarası Kurul tarafından verilen doçentlik unvanına sahip '
                .'olmak', 'Doçent ek koşulları'),
            $seminerKosulu,
            Kalip::kIle('Aşağıdaki seçeneklerden en az üçünü sağlamak', 3,
                $seceneklerOrtak(30, 'Doçent ek koşulları', null)),
        ]),
    ],
    [
        'anahtar' => 'iskenderun-docent-sosyal',
        'aday_notu' => 'Doçentlikte puan yerine SEÇENEK SAYISI isteniyor: aşağıdaki listeden en '
            .'az ÜÇÜNÜ sağlamanız yeterli. Atıf seçeneğinin eşiği bu alanlarda 10 (fen '
            .'grubunda 30).',
        'universite' => 'İskenderun Teknik Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => [...$sosyalGrubu, 'guzel_sanatlar'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Doçent ek koşulları: doçentlik unvanı, konferans/seminer verme ve listedeki '
            .'seçeneklerden en az üçü. Atıf seçeneği Sosyal ve Mimarlık için 10.',
        'sart' => Kalip::ve('Doçent — Sosyal, Mimarlık, Güzel Sanatlar ve diğer alanlar', [
            Kalip::beyan('Üniversitelerarası Kurul tarafından verilen doçentlik unvanına sahip '
                .'olmak', 'Doçent ek koşulları'),
            $seminerKosulu,
            Kalip::kIle('Aşağıdaki seçeneklerden en az üçünü sağlamak', 3,
                $seceneklerOrtak(10, 'Doçent ek koşulları', null)),
        ]),
    ],

    // ══════════ PROFESÖR (ÜAK tekrarı + 19 seçenekten en az 4'ü) ══════════
    [
        'anahtar' => 'iskenderun-profesor-fen',
        'aday_notu' => 'İki katmanlı: önce doçentliğinizi aldığınız dönemin ÜAK doçentlik '
            .'koşullarını (lisansüstü tez yayınları hariç) doçentlik sonrası çalışmalarınızla '
            .'BİR KEZ DAHA sağlamanız, sonra listeden en az DÖRT seçeneği doçentlik sonrasında '
            .'gerçekleştirmiş olmanız gerekiyor. Hangi dönemin ÜAK koşullarının geçerli olduğu '
            .'doçentlik tarihinize bağlı olduğu için burada güncel ÜAK toplamı gösteriliyor.',
        'universite' => 'İskenderun Teknik Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $fenGrubu,
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Profesör ek koşulları: ÜAK doçentlik asgari koşullarının doçentlik sonrası '
            .'tekrarı ve listedeki seçeneklerden en az dördü. Atıf seçeneği Mühendislik ve Fen '
            .'için 70.',
        'sart' => Kalip::ve('Profesör — Fen Bilimleri, Mühendislik ve Sağlık', [
            Kalip::toplam(100, $DOC),
            Kalip::beyan('Doçent olduğunuz tarihte yürürlükte olan ÜAK doçentlik başvuru asgari '
                .'koşullarını (lisansüstü tezlerden üretilmiş yayınlar hariç), doçentlik için '
                .'kullandığınız eserlerden sonraki çalışmalarınızla bir kez daha sağlamış olmak',
                'Profesör ek koşulları'),
            Kalip::kIle('Doçentliğinizden sonra aşağıdaki seçeneklerden en az dördünü sağlamak', 4,
                $seceneklerOrtak(70, 'Profesör ek koşulları', $DOC)),
        ]),
    ],
    [
        'anahtar' => 'iskenderun-profesor-sosyal',
        'aday_notu' => 'İki katmanlı: önce doçentliğinizi aldığınız dönemin ÜAK doçentlik '
            .'koşullarını (lisansüstü tez yayınları hariç) doçentlik sonrası çalışmalarınızla '
            .'BİR KEZ DAHA sağlamanız, sonra listeden en az DÖRT seçeneği doçentlik sonrasında '
            .'gerçekleştirmiş olmanız gerekiyor. Atıf seçeneğinin eşiği bu alanlarda 20 (fen '
            .'grubunda 70).',
        'universite' => 'İskenderun Teknik Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => [...$sosyalGrubu, 'guzel_sanatlar'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Profesör ek koşulları: ÜAK doçentlik asgari koşullarının doçentlik sonrası '
            .'tekrarı ve listedeki seçeneklerden en az dördü. Atıf seçeneği Sosyal ve Mimarlık '
            .'için 20.',
        'sart' => Kalip::ve('Profesör — Sosyal, Mimarlık, Güzel Sanatlar ve diğer alanlar', [
            Kalip::toplam(100, $DOC),
            Kalip::beyan('Doçent olduğunuz tarihte yürürlükte olan ÜAK doçentlik başvuru asgari '
                .'koşullarını (lisansüstü tezlerden üretilmiş yayınlar hariç), doçentlik için '
                .'kullandığınız eserlerden sonraki çalışmalarınızla bir kez daha sağlamış olmak',
                'Profesör ek koşulları'),
            Kalip::kIle('Doçentliğinizden sonra aşağıdaki seçeneklerden en az dördünü sağlamak', 4,
                $seceneklerOrtak(20, 'Profesör ek koşulları', $DOC)),
        ]),
    ],
];
