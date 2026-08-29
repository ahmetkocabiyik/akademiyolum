<?php

use App\Services\Scoring\Sart\Kalip;

/**
 * İZMİR KAVRAM MESLEK YÜKSEKOKULU — Yükseltme ve Atama Yönergesi
 * Kaynak: pdf/1766066729695.izmir-kavram-myo-kriter-18122025.pdf (7 sayfa)
 *
 * Cetvel: cetvel/izmir-kavram-2025.php (üç varyant)
 *
 * ── EŞİKLERİN YAPISI ──
 * Yönerge yalnız puan barajı koyuyor; yayın sayısı ya da tür koşulu yok.
 *   Doktor öğretim üyesi ilk atama (MADDE 4/1): Ek-1 ve Ek-2'ye göre 90
 *   Yeniden atama (MADDE 4/2): ulusal ya da uluslararası bir projede
 *       YÜRÜTÜCÜ olmak, YA DA iki yıllık görev süresi içinde Fen ve
 *       Sağlık alanları için 30, Sosyal alanlar için 20 puan
 *   Doçent (MADDE 5): doçent unvanı + Ek-1'den 120
 *   Profesör (MADDE 6): Ek-1'den 150
 *
 * ── YORUM KARARLARI (§0) ──
 *   KAYNAK PDF TARANMIŞ; metinde harf kaybı var. Puanlar ve madde
 *       başlıkları okunuyor, bağlaç metni yer yer eksik. Cetvelde iki
 *       satır daraltıcı okundu (docblock'unda yazılı); eşiklerin sayıları
 *       (90, 30, 20, 120, 150) net okunuyor.
 *   YÖNERGE İKİ ALAN GRUBU SAYIYOR ("Fen ve Sağlık" / "Sosyal"), kayıt on
 *       iki temel alan taşıyor. Mühendislik, Fen, Sağlık ve Ziraat 30
 *       puanlık gruba; Sosyal, Eğitim, İlahiyat, Hukuk, Filoloji, Spor ve
 *       Güzel Sanatlar 20 puanlık gruba bağlandı. MİMARLIK ikisinde de
 *       adıyla geçmiyor; §0 uyarınca daha YÜKSEK olan 30 puanlık gruba
 *       yazıldı, yani mimarlık adayına gerekenden fazlası soruluyor.
 *   Yeniden atamadaki "iki yıllık görev süresi içinde" kaydı
 *       `Kalip::sonYil(2)` penceresiyle yazıldı.
 *   Ek-1'in 15. maddesi yalnız güzel sanatlar, 16. maddesi yalnız
 *       mimarlık-planlama-tasarım temel alanına açık olduğu için üç ayrı
 *       cetvel kullanılıyor; eşikler alanına göre doğru varyantı seçiyor.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 4/2'nin "önceki yeniden atamalarda kullanılan puanlar tekrar
 *       sayılmaz" kaydı; kayıt bir eserin hangi atamada kullanıldığını
 *       tutmuyor.
 *   MADDE 7 (iş güvencesi) ve MADDE 8-9 (yürürlük, yürütme).
 *   Yönerge yabancı dil için ayrı bir baraj koymuyor; Ek-1'in 19.
 *       maddesi dil sınavından 85 ve üzeri almayı PUANLI bir satır olarak
 *       tanımlıyor (5 puan), koşul olarak değil. O satır da profil
 *       ölçütü olduğu için cetvele girmedi.
 */
$FEN_SAGLIK = ['muhendislik', 'fen', 'saglik', 'ziraat'];
$SOSYAL = ['sosyal', 'egitim', 'ilahiyat', 'hukuk', 'filoloji', 'spor'];

$PUAN_NOTU = 'Kaynak PDF taranmış ve OCR\'lanmış; cetvelin iki satırı eksik metinden daraltıcı '
    .'okundu. 13. madde (etkinlik düzenlemelerinde yer almak), 18. madde (h-indeksi) ve 19. madde '
    .'(yabancı dil sınavından 85 ve üzeri) faaliyet kaydına çevrilemediği için girilmedi; dergi '
    .'editörlüğü, lisansüstü tezden üretilmiş yayın, idari görev ve toplumsal katkı için cetvelde '
    .'satır yok.';

/**
 * Aynı kadro koşulu üç cetvel varyantı için de yazılıyor; yalnız `cetvel`
 * ve `alan` değişiyor.
 *
 * @return list<array<string, mixed>>
 */
$kayitlar = function (string $ekAdi, string $cetvel, array $alanlar, int $yenidenPuan) use ($PUAN_NOTU): array {
    $ortakNot = ' '.$PUAN_NOTU;

    return [
        [
            'anahtar' => "izmir-kavram-{$ekAdi}-dr",
            'universite' => 'İzmir Kavram Meslek Yüksekokulu',
            'kadro' => 'dr_ogr_uyesi',
            'alan' => $alanlar,
            'birim' => null,
            'cetvel' => $cetvel,
            'notlar' => 'MADDE 4/1: Ek-1 ve Ek-2\'de verilen puanlama sistemine göre en az 90 puan.',
            'aday_notu' => 'Yönerge ilk atamada yalnız puan barajı koyuyor; yayın sayısı ya da tür '
                .'koşulu yok. Ek-2 yazar sayısı × sıra tablosu olduğu için çok yazarlı '
                .'yayınlarınızda sıranızı girmeniz puanı doğrudan etkiliyor.'.$ortakNot,
            'sart' => Kalip::ve('Doktor öğretim üyesi ilk atama koşulları', [
                Kalip::toplam(90, maddeler: ['TUM'], liste: 'Ek-1'),
            ]),
        ],
        [
            'anahtar' => "izmir-kavram-{$ekAdi}-dr-yeniden",
            'universite' => 'İzmir Kavram Meslek Yüksekokulu',
            'kadro' => 'dr_ogr_uyesi_yeniden',
            'alan' => $alanlar,
            'birim' => null,
            'cetvel' => $cetvel,
            'notlar' => 'MADDE 4/2: ulusal ya da uluslararası bir projede yürütücü olarak yer almış '
                .'olmak; ya da iki yıllık görev süresi içinde toplam '.$yenidenPuan.' puan.',
            'aday_notu' => 'Yeniden atamada iki alternatif var: bir projede YÜRÜTÜCÜ olmak tek başına '
                .'yetiyor, yoksa son iki yılda '.$yenidenPuan.' puan gerekiyor. Yönerge "Fen ve '
                .'Sağlık" ile "Sosyal" diye iki grup sayıyor; Mimarlık ikisinde de adıyla geçmediği '
                .'için daha yüksek olan 30 puanlık gruba yazıldı. "Önceki yeniden atamalarda '
                .'kullanılan puanlar tekrar sayılmaz" kaydı uygulanmıyor.'.$ortakNot,
            'sart' => Kalip::veya('Doktor öğretim üyesi yeniden atama koşulları', [
                Kalip::adet('Ulusal ya da uluslararası bir projede yürütücü olarak yer almış olmak', ['PROJE-YURUTUCU'], 1, madde: 'MADDE 4/2'),
                Kalip::toplam($yenidenPuan, donem: Kalip::sonYil(2), maddeler: ['TUM'], liste: 'Ek-1'),
            ]),
        ],
        [
            'anahtar' => "izmir-kavram-{$ekAdi}-docentlik",
            'universite' => 'İzmir Kavram Meslek Yüksekokulu',
            'kadro' => 'docentlik',
            'alan' => $alanlar,
            'birim' => null,
            'cetvel' => $cetvel,
            'notlar' => 'MADDE 5: doçent unvanına sahip olmak ve Ek-1\'deki akademik etkinliklerden '
                .'en az 120 puan almış olmak.',
            'aday_notu' => 'Doçentlikte tek sayısal koşul 120 puan; yönerge dönem kısıtı koymuyor, '
                .'yani doktora öncesi faaliyetleriniz de toplama giriyor.'.$ortakNot,
            'sart' => Kalip::ve('Doçent kadrosuna atanma koşulları', [
                Kalip::beyan('Üniversitelerarası Kuruldan doçent unvanını almış olmak', 'MADDE 5/a'),
                Kalip::toplam(120, maddeler: ['TUM'], liste: 'Ek-1'),
            ]),
        ],
        [
            'anahtar' => "izmir-kavram-{$ekAdi}-profesorluk",
            'universite' => 'İzmir Kavram Meslek Yüksekokulu',
            'kadro' => 'profesorluk',
            'alan' => $alanlar,
            'birim' => null,
            'cetvel' => $cetvel,
            'notlar' => 'MADDE 6: Ek-1\'deki akademik etkinliklerden en az 150 puan almış olmak.',
            'aday_notu' => 'Profesörlükte de tek sayısal koşul puan: 150. Yönerge doçentlik sonrası '
                .'için ayrı bir pay ayırmıyor, bütün faaliyetleriniz sayılıyor.'.$ortakNot,
            'sart' => Kalip::ve('Profesör kadrosuna atanma koşulları', [
                Kalip::toplam(150, maddeler: ['TUM'], liste: 'Ek-1'),
            ]),
        ],
    ];
};

return [
    ...$kayitlar('fen', 'izmir-kavram-2025', $FEN_SAGLIK, 30),
    ...$kayitlar('sosyal', 'izmir-kavram-2025', $SOSYAL, 20),
    ...$kayitlar('gsf', 'izmir-kavram-2025-gsf', ['guzel_sanatlar'], 20),
    ...$kayitlar('mim', 'izmir-kavram-2025-mim', ['mimarlik'], 30),
];
