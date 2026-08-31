<?php

/**
 * MARMARA ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma Kriterleri
 * Kaynak: pdf/17537003632.marmarauniverstesi.pdf (26 sayfa)
 *
 * BELGE 2018 ÖNCESİ TERMİNOLOJİ KULLANIYOR: "yardımcı doçent" kadrosu
 * 2018'de "Dr. Öğretim Üyesi" olarak yeniden adlandırıldı. Kadro aynı olduğu
 * için MADDE 7'nin koşulları `dr_ogr_uyesi` altına girildi. Yabancı dil
 * koşulunda KPDS/ÜDS anılıyor (2013'te YDS ile değişti); puan eşikleri
 * korunarak `yds` metriğine bağlandı.
 *
 * MARMARA HER TEMEL ALANA AYRI PUANLAMA TABLOSU VERİYOR (Tablo 1-7) ve
 * koşullar o tablonun KENDİ madde numaralarına ARALIK olarak atıf yapıyor:
 * "1-16, 23-26, 32-37, 45, 47-52 numaralı faaliyetlerden en az 42 puan".
 * Bu yüzden her tablo ayrı cetvel dosyası:
 *
 *   Tablo 1  marmara-egitim                  Eğitim Bilimleri
 *   Tablo 2  marmara-fen-saglik              Fen, Matematik, Sağlık
 *   Tablo 3  marmara-ilahiyat-hukuk-filoloji İlahiyat, Hukuk, Filoloji
 *   Tablo 4  marmara-guzel-sanatlar          Güzel Sanatlar
 *   Tablo 5  marmara-muhendislik             Mühendislik
 *   Tablo 6  marmara-sosyal                  Sosyal, Beşeri ve İdari Bilimler
 *   Tablo 7  marmara-spor                    Spor (Tablo 1'e EK olarak verilmiş)
 *
 * DR. ÖĞR. ÜYELİĞİNDE HER ALANIN KENDİ KURALI VAR (md. 7/d, on bir bent) ve
 * bunlar birbirinden gerçekten farklı: Fen SCI-Expanded makale + 42 + 90
 * isterken Hukuk iki hakemli makale + 90, Mühendislik yalnız iki SCI-Expanded
 * makale (puan barajı YOK), Mesleki ve Teknik Eğitim yalnız üç yayın istiyor.
 * ÖNCEKİ SÜRÜM SAĞLIK VE EĞİTİMİ DE FEN KURALINA BAĞLAMIŞTI; düzeltildi.
 *
 * DOÇENT ve PROFESÖR KOŞULLARI ALANDAN BAĞIMSIZ (md. 13/a ve 18/2-a): her
 * temel alanda aynı cümle, yalnız atıf yapılan madde numaraları tablo başına
 * değişiyor. Bu yüzden ikisi de on bir alanın hepsinde tanımlı.
 *
 * MESLEKİ VE TEKNİK EĞİTİM TEMEL ALANI GİRİLEMEDİ: yönergenin 7/d-7 bendi bu
 * alana ayrı kural veriyor ama profildeki temel alan listesinde böyle bir
 * seçenek yok. Mimarlık ve Ziraat temel alanlarına ise yönergenin kendisi
 * ölçüt koymuyor — Marmara'da o fakülteler bulunmuyor.
 *
 * YENİDEN ATANMA (md. 8) GİRİLMEDİ: koşullar "ikişer yıllık süreler" ve
 * "üçüncü yenileme" gibi atama SIRASINA bağlı; kaçıncı yenilemede olduğunuz
 * profilde tutulmuyor. Her alan için ayrı ayrı tanımlı olan bu eşikler aday
 * notunda anlatılıyor.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip
 */

use App\Services\Scoring\Sart\Kalip;

$UNI = 'Marmara Üniversitesi';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;

/** Yönergenin on bir bendinin temel alan karşılıkları ve tabloları. */
$ALANLAR = [
    'egitim' => ['cetvel' => 'marmara-egitim', 'ad' => 'Eğitim Bilimleri ve Öğretmen Yetiştirme'],
    'fen' => ['cetvel' => 'marmara-fen-saglik', 'ad' => 'Fen Bilimleri ve Matematik'],
    'filoloji' => ['cetvel' => 'marmara-ilahiyat-hukuk-filoloji', 'ad' => 'Filoloji'],
    'guzel_sanatlar' => ['cetvel' => 'marmara-guzel-sanatlar', 'ad' => 'Güzel Sanatlar'],
    'hukuk' => ['cetvel' => 'marmara-ilahiyat-hukuk-filoloji', 'ad' => 'Hukuk'],
    'ilahiyat' => ['cetvel' => 'marmara-ilahiyat-hukuk-filoloji', 'ad' => 'İlahiyat'],
    'muhendislik' => ['cetvel' => 'marmara-muhendislik', 'ad' => 'Mühendislik'],
    'saglik' => ['cetvel' => 'marmara-fen-saglik', 'ad' => 'Sağlık Bilimleri'],
    'sosyal' => ['cetvel' => 'marmara-sosyal', 'ad' => 'Sosyal, Beşeri ve İdari Bilimler'],
    'spor' => ['cetvel' => 'marmara-spor', 'ad' => 'Spor Bilimleri'],
];

$ESKI_TERIM = 'Yönerge 2018 öncesi "yardımcı doçent" terimini kullanıyor; kadro bugünkü Dr. '
    .'Öğretim Üyesi kadrosudur. Yabancı dil koşulundaki KPDS/ÜDS puanı YDS karşılığıyla '
    .'değerlendiriliyor; yabancı dilde eğitim yapan birimlerde eşik 60 değil 80.';

$YENIDEN = ' Yeniden atanma eşiği girilmedi: yönerge iki yılda bir yapılan yenilemeler için '
    .'ayrı ve daha düşük koşullar koyuyor (çoğu alanda 50 puan), ayrıca ÜÇÜNCÜ yenilemede '
    .'tek yazarlı makale ya da özgün kitap gibi ek bir şart arıyor. Kaçıncı yenilemede '
    .'olduğunuz burada tutulmadığı için bu koşullar hesaba katılmadı.';

$DIL_JURI = Kalip::beyan('Birim yönetim kurulunca seçilen üç kişilik jüri önünde kendi bilim '
    .'alanınızda Türkçeden yabancı dile ve yabancı dilden Türkçeye çeviri sınavında başarılı '
    .'olmak', 'Madde 7/c');

/**
 * Md. 7/d'nin on bir bendi. Her bent kendi alanının ölçütlerini veriyor;
 * ortak olan yalnız yabancı dil (7/b) ve çeviri sınavı (7/c).
 *
 * @var array<string, array{notlar: string, aday: string, cocuklar: list<array<string, mixed>>}>
 */
$DR_KURALI = [
    'egitim' => [
        'notlar' => 'MADDE 7/d-1: "en az 50 puanı 1-11 numaralı faaliyetlerinden olmak üzere '
            .'17-27, 34-37, 49-50 faaliyetlerden toplam 70 puan". Lisansüstü tezden üretilen '
            .'yayınlar yarım puanla değerlendirilir.',
        'aday' => 'Eğitim Bilimleri barajı İKİ KATMANLI ve ikisi de dar: makalelerden en az 50 '
            .'puan, buna ek olarak kitap, bildiri, akademik organizasyon, proje ve tez '
            .'danışmanlığı kalemlerinden toplam 70 puan. Yönerge toplam puan barajı koymuyor. '
            .'Lisansüstü tezinizden üretilen yayınlar YARIM puanla sayılıyor; faaliyeti '
            .'"tez yayını" olarak kaydettiyseniz bu indirim uygulanıyor.',
        'cocuklar' => [
            Kalip::puanDan('Makale kalemlerinizden en az 50 puan', ['1-11'], 50, madde: 'Madde 7/d-1'),
            Kalip::puanDan('Kitap, bildiri, akademik organizasyon, proje ve tez danışmanlığı '
                .'kalemlerinizden en az 70 puan', ['17-27', '34-37', '49-50'], 70, madde: 'Madde 7/d-1'),
        ],
    ],
    'fen' => [
        'notlar' => 'MADDE 7/d-2: "SCI-Expanded kapsamındaki dergilerde alanı ile ilgili en az '
            .'bir makalesinin olması ve 1-16, 23-26, 32-37, 45, 47-52 numaralı faaliyetlerden '
            .'en az 42 puan olmak üzere, tüm faaliyetlerden 90 puan."',
        'aday' => 'Fen Bilimleri ve Matematik için üç koşul birden aranıyor: SCI-Expanded '
            .'kapsamındaki bir dergide en az bir makale, belirtilen kalemlerden 42 puan ve '
            .'bütün faaliyetlerden 90 puan.',
        'cocuklar' => [
            Kalip::adet('SCI-Expanded kapsamındaki bir dergide en az 1 makale', ['BIRINCIL'], 1, madde: 'Madde 7/d-2'),
            Kalip::puanDan('Makale, bildiri, ders, proje, ödül, atıf, tez danışmanlığı ve patent '
                .'kalemlerinizden en az 42 puan',
                ['1-16', '23-26', '32-37', '45', '47-52'], 42, madde: 'Madde 7/d-2'),
            Kalip::toplam(90),
        ],
    ],
    'filoloji' => [
        'notlar' => 'MADDE 7/d-3: "indekslerce taranan bir makalesinin olması, lisansüstü '
            .'tezlerinden üretilmemiş 3-21 numaralı faaliyetlerden en az 42 puan ve 3-21, 23, '
            .'24, 32, 36, 37, 47, 49 numaralı faaliyetlerden 90 puan."',
        'aday' => 'Filolojide üç koşul birden aranıyor: indekslerce taranan bir dergide en az '
            .'bir makale, makale ve kitap kalemlerinden 42 puan, bunlara bildiri, ders, proje, '
            .'atıf ve tez danışmanlığı eklenerek 90 puan. 42 puanlık katmanın lisansüstü '
            .'tezinizden ÜRETİLMEMİŞ çalışmalardan gelmesi gerekiyor; tezden üretilme bilgisi '
            .'burada tutulmadığı için bu kısıt uygulanmadı.',
        'cocuklar' => [
            Kalip::adet('İndekslerce taranan bir dergide en az 1 makale', ['INDEKSLI-MAKALE'], 1, madde: 'Madde 7/d-3'),
            Kalip::puanDan('Makale ve kitap kalemlerinizden en az 42 puan', ['3-21'], 42, madde: 'Madde 7/d-3'),
            Kalip::puanDan('Makale, kitap, bildiri, ders, proje, atıf ve tez danışmanlığı '
                .'kalemlerinizden en az 90 puan', ['FILOLOJI-TOPLAM'], 90, madde: 'Madde 7/d-3'),
        ],
    ],
    'guzel_sanatlar' => [
        'notlar' => 'MADDE 7/d-4: "en az 42 puanı kendi lisansüstü tezlerinden üretilmemiş '
            .'olmak üzere tüm faaliyetlerden 90 puan."',
        'aday' => 'Güzel Sanatlarda tek sayısal koşul var: bütün faaliyetlerden 90 puan. '
            .'Yönerge bunun en az 42 puanının lisansüstü tezinizden ÜRETİLMEMİŞ çalışmalardan '
            .'gelmesini istiyor; tezden üretilme bilgisi burada tutulmadığı için o alt katman '
            .'ayrıca sınanmadı.',
        'cocuklar' => [Kalip::toplam(90)],
    ],
    'hukuk' => [
        'notlar' => 'MADDE 7/d-5: "en az biri yaptığı lisansüstü tezlerinden üretilmemiş olmak '
            .'üzere hakemli dergilerde iki makalesinin olması ve tüm faaliyetlerden 90 puan."',
        'aday' => 'Hukukta iki koşul aranıyor: hakemli dergilerde iki makale ve bütün '
            .'faaliyetlerden 90 puan. Yönerge makalelerden en az birinin lisansüstü tezinizden '
            .'ÜRETİLMEMİŞ olmasını istiyor; tezden üretilme bilgisi burada tutulmadığı için bu '
            .'kısıt uygulanmadı.',
        'cocuklar' => [
            Kalip::adet('Hakemli dergilerde en az 2 makale', ['HAKEMLI-MAKALE'], 2, madde: 'Madde 7/d-5'),
            Kalip::toplam(90),
        ],
    ],
    'ilahiyat' => [
        'notlar' => 'MADDE 7/d-6: "en az biri yaptığı lisansüstü tezlerinden üretilmemiş olmak '
            .'üzere hakemli dergilerde iki makalesinin olması ve tüm faaliyetlerden 90 puan."',
        'aday' => 'İlahiyatta iki koşul aranıyor: hakemli dergilerde iki makale ve bütün '
            .'faaliyetlerden 90 puan. Yönerge makalelerden en az birinin lisansüstü tezinizden '
            .'ÜRETİLMEMİŞ olmasını istiyor; tezden üretilme bilgisi burada tutulmadığı için bu '
            .'kısıt uygulanmadı.',
        'cocuklar' => [
            Kalip::adet('Hakemli dergilerde en az 2 makale', ['HAKEMLI-MAKALE'], 2, madde: 'Madde 7/d-6'),
            Kalip::toplam(90),
        ],
    ],
    'muhendislik' => [
        'notlar' => 'MADDE 7/d-8: "en az bir tanesi lisansüstü tezlerinden üretilmiş olmak '
            .'kaydıyla en az iki makalesinin SCI-Expanded kapsamındaki dergilerde yayımlanmış '
            .'olması." Puan barajı yok.',
        'aday' => 'Mühendislikte PUAN BARAJI YOK: tek koşul SCI-Expanded kapsamındaki '
            .'dergilerde iki makale. Yönerge bunlardan en az birinin lisansüstü tezinizden '
            .'ÜRETİLMİŞ olmasını istiyor; tezden üretilme bilgisi burada tutulmadığı için bu '
            .'kısıt uygulanmadı.',
        'cocuklar' => [
            Kalip::adet('SCI-Expanded kapsamındaki dergilerde en az 2 makale', ['BIRINCIL'], 2, madde: 'Madde 7/d-8'),
        ],
    ],
    'saglik' => [
        'notlar' => 'MADDE 7/d-9: "bir tanesi doktora tezinden olmak üzere hakemli dergilerde '
            .'en az iki makalesinin olması ve tüm faaliyetlerden en az 90 puan."',
        'aday' => 'Sağlık Bilimlerinde iki koşul aranıyor: hakemli dergilerde iki makale ve '
            .'bütün faaliyetlerden 90 puan. Yönerge makalelerden birinin DOKTORA TEZİNİZDEN '
            .'üretilmiş olmasını istiyor; tezden üretilme bilgisi burada tutulmadığı için bu '
            .'kısıt uygulanmadı.',
        'cocuklar' => [
            Kalip::adet('Hakemli dergilerde en az 2 makale', ['1-16'], 2, madde: 'Madde 7/d-9'),
            Kalip::toplam(90),
        ],
    ],
    'sosyal' => [
        'notlar' => 'MADDE 7/d-10: "yaptığı lisansüstü tezlerinden üretilmemiş bir makalesinin '
            .'ve en az 42 puanı 1–11, 17-21 ve 23-26 numaralı faaliyetlerden olmak üzere, tüm '
            .'faaliyetlerden en az 90 puan."',
        'aday' => 'Sosyal, Beşeri ve İdari Bilimlerde üç koşul birden aranıyor: en az bir '
            .'makale, makale-kitap-bildiri kalemlerinden 42 puan ve bütün faaliyetlerden 90 '
            .'puan. Yönerge makalenin lisansüstü tezinizden ÜRETİLMEMİŞ olmasını istiyor; '
            .'tezden üretilme bilgisi burada tutulmadığı için bu kısıt uygulanmadı.',
        'cocuklar' => [
            Kalip::adet('En az 1 makale', ['1-11'], 1, madde: 'Madde 7/d-10'),
            Kalip::puanDan('Makale, kitap ve bildiri kalemlerinizden en az 42 puan',
                ['1-11', '17-21', '23-26'], 42, madde: 'Madde 7/d-10'),
            Kalip::toplam(90),
        ],
    ],
    'spor' => [
        'notlar' => 'MADDE 7/d-11: "iki makalesinin hakemli dergilerde yayımlanmış olması ve '
            .'tüm faaliyetlerden en az 100 puan." Tablo 6, Tablo 7 ve Tablo 8 birlikte.',
        'aday' => 'Spor Bilimlerinde iki koşul aranıyor: hakemli dergilerde iki makale ve '
            .'bütün faaliyetlerden 100 puan — korpusta bu alanın en yüksek dr. öğr. üyeliği '
            .'barajlarından biri. Spor teşkilatı kurul üyeliği ile hakemlik ve antrenörlük '
            .'satırları faaliyet kaydına çevrilemediği için toplam puanınız burada '
            .'gerçeğinden düşük görünebilir.',
        'cocuklar' => [
            Kalip::adet('Hakemli dergilerde en az 2 makale', ['1-11'], 2, madde: 'Madde 7/d-11'),
            Kalip::toplam(100),
        ],
    ],
];

$esikler = [];

foreach ($ALANLAR as $alan => $t) {
    $kural = $DR_KURALI[$alan];

    // ── DR. ÖĞRETİM ÜYESİ (md. 7) — alana göre değişen tek kadro ──
    $esikler[] = [
        'anahtar' => "marmara-dr-{$alan}",
        'aday_notu' => $kural['aday'].' '.$ESKI_TERIM.$YENIDEN,
        'universite' => $UNI,
        'kadro' => 'dr_ogr_uyesi',
        'alan' => [$alan],
        'cetvel' => $t['cetvel'],
        'notlar' => $kural['notlar'].' MADDE 7/a: doktora, tıpta uzmanlık ya da sanatta '
            .'yeterlik. MADDE 7/b: KPDS/ÜDS en az 60 (yabancı dilde eğitim yapan birimlerde '
            .'80). MADDE 7/c: üç kişilik jüri önünde çeviri sınavı.',
        'sart' => Kalip::ve("Dr. Öğr. Üyesi kadrosuna atanma — {$t['ad']}", [
            Kalip::beyan('Doktora yapmış, tıpta uzmanlık unvanını almış ya da bir sanat dalında '
                .'yeterlik kazanmış olmak', 'Madde 7/a'),
            ...$kural['cocuklar'],
            Kalip::yds(60),
            $DIL_JURI,
        ]),
    ];

    // ── DOÇENT (md. 13) — koşul alandan bağımsız ──
    $esikler[] = [
        'anahtar' => "marmara-docentlik-{$alan}",
        'aday_notu' => 'Doçentlikte yalnızca DOKTORA SONRASI dönem ve belirli faaliyet kalemleri '
            .'sayılıyor: akademik organizasyon, ders, proje, davetli konuşmacılık, editörlük, '
            .'hakemlik, ödül, burs, atıf, tez danışmanlığı ve patent. Makale, kitap ve bildiri '
            .'bu 100 puana GİRMİYOR — doçentlik unvanı için gereken yayınları ÜAK zaten '
            .'sınadığı için Marmara burada yayın dışı üretimi ölçüyor.'.$ESKI_TERIM,
        'universite' => $UNI,
        'kadro' => 'docentlik',
        'alan' => [$alan],
        'cetvel' => $t['cetvel'],
        'notlar' => 'MADDE 13/a: "Doktora sonrası döneme ait başvurduğu alan ile ilgili 27, '
            .'32-52 numaralı faaliyetlerden toplam en az 100 puana ulaşması gerekir." MADDE '
            .'13/b: yabancı dilde eğitim yapan birimlerde KPDS/ÜDS en az 80. Koşul on bir '
            .'temel alanda aynı; yalnız madde numaralarının karşılığı tablo başına değişiyor.',
        'sart' => Kalip::ve("Doçent kadrosuna atanma — {$t['ad']}", [
            Kalip::beyan('Üniversitelerarası Kurulca yapılan doçentlik sınavında başarı '
                .'göstererek doçentlik unvanını almış olmak', 'Madde 13'),
            Kalip::puanDan('Doktora sonrası akademik organizasyon, ders, proje, editörlük, '
                .'hakemlik, ödül, atıf, tez danışmanlığı ve patent kalemlerinizden en az 100 puan',
                ['27,32-52'], 100, $DOKTORA, madde: 'Madde 13/a'),
        ]),
    ];

    // ── PROFESÖR (md. 18) — koşul alandan bağımsız ──
    $esikler[] = [
        'anahtar' => "marmara-profesorluk-{$alan}",
        'aday_notu' => 'Profesörlükte iki ayrı puan barajı var, ikisi de DOÇENTLİK SONRASI '
            .'dönemi ölçüyor: kitap, akademik organizasyon, proje, editörlük ve tez '
            .'danışmanlığı kalemlerinden 120 puan ve bütün faaliyetlerden 275 puan. Bunlara ek '
            .'olarak doçentlik unvanını aldıktan sonra alanınızda en az beş yıl çalışmış '
            .'olmanız ve ÜAK\'ın o dönemki doçentlik asgari koşullarını YENİDEN karşılamanız '
            .'isteniyor. Zaten profesör unvanı taşıyan adayların yalnız son beş yılı '
            .'değerlendiriliyor.'.$ESKI_TERIM,
        'universite' => $UNI,
        'kadro' => 'profesorluk',
        'alan' => [$alan],
        'cetvel' => $t['cetvel'],
        'notlar' => 'MADDE 18/1-a: doçentlik unvanından sonra en az beş yıl çalışma. MADDE '
            .'18/2-a: "doçentlik asgari başvuru koşullarını yeniden karşılamış olması, buna '
            .'ilave olarak 17, 18, 27, 34, 41, 49, 50 numaralı faaliyetlerden toplam en az 120 '
            .'puan almak koşuluyla önceki yükseltilmesinden sonraki tüm faaliyetlerinden '
            .'toplam 275 puana ulaşması." MADDE 18/2-c: yabancı dilde eğitim yapan birimlerde '
            .'KPDS/ÜDS en az 80.',
        'sart' => Kalip::ve("Profesör kadrosuna atanma — {$t['ad']}", [
            Kalip::beyan('Doçentlik unvanını aldıktan sonra kadronun ilgili alanında en az beş '
                .'yıl çalışmış olmak', 'Madde 18/1-a'),
            Kalip::beyan('Doçentlik unvanını almaya hak kazandığınız döneme ait ÜAK asgari '
                .'başvuru koşullarını yeniden karşılamak', 'Madde 18/2-a'),
            Kalip::puanDan('Doçentliğinizden sonra kitap, akademik organizasyon, proje, '
                .'editörlük ve tez danışmanlığı kalemlerinizden en az 120 puan',
                ['PROF-CEKIRDEK'], 120, $DOCENTLIK, madde: 'Madde 18/2-a'),
            Kalip::toplam(275, $DOCENTLIK),
        ]),
    ];
}

return $esikler;
