<?php

use App\Services\Scoring\Sart\SartDeposu;

/**
 * ADAY METİNLERİNDE YÖNERGE KODU ARAR (KONVANSIYONLAR §2, "Aday metinleri:
 * KOD YASAK").
 *
 * Adaya iki metin gösteriliyor: koşul ağacındaki her düğümün `aciklama`'sı ve
 * eşiğin `aday_notu`'su. Bu metinlerde "MADDE 5/1-b", "Tablo 2", "EK-1",
 * "A.1-A.5" gibi yönerge kodları geçmemeli — aday o kodun ne olduğunu bilmiyor
 * ve motorun onun yerine ne saydığını göremiyor. Kod, düğümün `madde` alanına
 * ve `notlar`a yazılır; ikisi de adaya gösterilmiyor.
 *
 * BORÇ LİSTESİ. Bu test korpusa sonradan eklendi ve 111 üniversite kirliydi.
 * Temizlenenler burada korumaya alınıyor, kalanlar `$BORCLU` listesinde
 * bekliyor. Süpürme ilerledikçe listeden isim SİLİNİR — hiçbir zaman isim
 * EKLENMEZ. Yeni bir üniversite girildiğinde bu test onu doğrudan yakalar.
 */
$KOD_DESENI = '/('
    .'\bMADDE\s'          // MADDE 5/1-b
    .'|\bMadde\s?\d'       // Madde 12(5)
    .'|\bTablo[-\s]?\d'    // Tablo 2, Tablo-3
    .'|\bTABLO[-\s]?\d'
    .'|\bEK[-\s]?\d'       // EK-1, EK 3
    .'|\bEk[-\s]?\d'
    .'|\bÇizelge[-\s]?\d'
    .'|\b[A-Z]\.\d'        // A.1, B.7
    .'|\b[A-Z]\d\.\d'      // A1.1
    .')/u';

/**
 * Henüz süpürülmemiş üniversiteler. BU LİSTE YALNIZCA KISALIR.
 *
 * @var list<string>
 */
$BORCLU = [
    'Adıyaman Üniversitesi',
    'Afyon Kocatepe Üniversitesi',
    'Afyonkarahisar Sağlık Bilimleri Üniversitesi',
    'Aksaray Üniversitesi',
    'Alanya Alaaddin Keykubat Üniversitesi',
    'Alanya Üniversitesi',
    'Amasya Üniversitesi',
    'Ankara Bilim Üniversitesi',
    'Ankara Yıldırım Beyazıt Üniversitesi',
    'Artvin Çoruh Üniversitesi',
    'Ataşehir Adıgüzel Meslek Yüksekokulu',
    'Ağrı İbrahim Çeçen Üniversitesi',
    'Bahçeşehir Üniversitesi',
    'Batman Üniversitesi',
    'Başkent Üniversitesi',
    'Bezmiâlem Vakıf Üniversitesi',
    'Bilecik Şeyh Edebali Üniversitesi',
    'Bingöl Üniversitesi',
    'Biruni Üniversitesi',
    'Bitlis Eren Üniversitesi',
    'Boğaziçi Üniversitesi',
    'Burdur Mehmet Akif Ersoy Üniversitesi',
    'Dicle Üniversitesi',
    'Dokuz Eylül Üniversitesi',
    'Doğuş Üniversitesi',
    'Erzincan Binali Yıldırım Üniversitesi',
    'Eskişehir Osmangazi Üniversitesi',
    'Galatasaray Üniversitesi',
    'Gebze Teknik Üniversitesi',
    'Hakkari Üniversitesi',
    'Harran Üniversitesi',
    'Işık Üniversitesi',
    'KTO Karatay Üniversitesi',
    'Kadir Has Üniversitesi',
    'Kahramanmaraş Sütçü İmam Üniversitesi',
    'Kahramanmaraş İstiklal Üniversitesi',
    'Karabük Üniversitesi',
    'Karadeniz Teknik Üniversitesi',
    'Kastamonu Üniversitesi',
    'Kilis 7 Aralık Üniversitesi',
    'Kocaeli Sağlık ve Teknoloji Üniversitesi',
    'Kocaeli Üniversitesi',
    'Konya Gıda ve Tarım Üniversitesi',
    'Konya Teknik Üniversitesi',
    'Kütahya Dumlupınar Üniversitesi',
    'Kütahya Sağlık Bilimleri Üniversitesi',
    'Kırklareli Üniversitesi',
    'Lokman Hekim Üniversitesi',
    'Malatya Turgut Özal Üniversitesi',
    'Munzur Üniversitesi',
    'Muğla Sıtkı Koçman Üniversitesi',
    'Muş Alparslan Üniversitesi',
    'Niğde Ömer Halisdemir Üniversitesi',
    'Nişantaşı Üniversitesi',
    'Ordu Üniversitesi',
    'Osmaniye Korkut Ata Üniversitesi',
    'Ostim Teknik Üniversitesi',
    'Pamukkale Üniversitesi',
    'Piri Reis Üniversitesi',
    'SANKO Üniversitesi',
    'Siirt Üniversitesi',
    'Sivas Bilim ve Teknoloji Üniversitesi',
    'Sivas Cumhuriyet Üniversitesi',
    'TED Üniversitesi',
    'Tarsus Üniversitesi',
    'Tekirdağ Namık Kemal Üniversitesi',
    'Tokat Gaziosmanpaşa Üniversitesi',
    'Türk-Alman Üniversitesi',
    'Ufuk Üniversitesi',
    'Uşak Üniversitesi',
    'Van Yüzüncü Yıl Üniversitesi',
    'Yeditepe Üniversitesi',
    'Çankaya Üniversitesi',
    'Çankırı Karatekin Üniversitesi',
    'Çağ Üniversitesi',
    'İnönü Üniversitesi',
    'İstanbul 29 Mayıs Üniversitesi',
    'İstanbul Arel Üniversitesi',
    'İstanbul Atlas Üniversitesi',
    'İstanbul Aydın Üniversitesi',
    'İstanbul Beykent Üniversitesi',
    'İstanbul Galata Üniversitesi',
    'İstanbul Gedik Üniversitesi',
    'İstanbul Medeniyet Üniversitesi',
    'İstanbul Medipol Üniversitesi',
    'İstanbul Rumeli Üniversitesi',
    'İstanbul Teknik Üniversitesi',
    'İstanbul Üniversitesi',
    'İzmir Bakırçay Üniversitesi',
    'İzmir Demokrasi Üniversitesi',
    'İzmir Kavram Meslek Yüksekokulu',
    'İzmir Yüksek Teknoloji Enstitüsü',
];

/**
 * Adaya gösterilen bütün metinleri toplar: düğüm açıklamaları ve aday notu.
 *
 * @param  array<string, mixed>  $dugum
 * @return list<string>
 */
function adayMetinleri(array $dugum): array
{
    $metinler = [];

    if (isset($dugum['aciklama'])) {
        $metinler[] = $dugum['aciklama'];
    }

    foreach ($dugum['cocuklar'] ?? [] as $cocuk) {
        $metinler = [...$metinler, ...adayMetinleri($cocuk)];
    }

    return $metinler;
}

test('temizlenmiş üniversitelerin aday metinlerinde yönerge kodu yok', function () use ($KOD_DESENI, $BORCLU) {
    $depo = app(SartDeposu::class);
    $sizinti = [];

    foreach ($depo->esikler() as $esik) {
        if (in_array($esik['universite'], $BORCLU, true)) {
            continue;
        }

        $metinler = adayMetinleri($esik['sart']);

        if ($esik['aday_notu'] !== null) {
            $metinler[] = $esik['aday_notu'];
        }

        foreach ($metinler as $metin) {
            if (preg_match($KOD_DESENI, $metin, $eslesme)) {
                $sizinti[] = "{$esik['universite']} ({$esik['anahtar']}): \"{$eslesme[1]}\" — ".mb_substr($metin, 0, 110);
            }
        }
    }

    expect(array_values(array_unique($sizinti)))->toBe([]);
});

test('borç listesindeki her üniversite hâlâ korpusta ve hâlâ kirli', function () use ($KOD_DESENI, $BORCLU) {
    $depo = app(SartDeposu::class);
    $kirli = [];

    foreach ($depo->esikler() as $esik) {
        $metinler = adayMetinleri($esik['sart']);

        if ($esik['aday_notu'] !== null) {
            $metinler[] = $esik['aday_notu'];
        }

        foreach ($metinler as $metin) {
            if (preg_match($KOD_DESENI, $metin)) {
                $kirli[$esik['universite']] = true;
            }
        }
    }

    // Temizlenen bir üniversite listede kalırsa süpürme ilerlemesi görünmez
    // olur; listeden silinmesi gerekir.
    $bosunaBekleyen = array_values(array_diff($BORCLU, array_keys($kirli)));

    expect($bosunaBekleyen)->toBe([], 'Bu üniversiteler temizlenmiş: borç listesinden silin.');
});
