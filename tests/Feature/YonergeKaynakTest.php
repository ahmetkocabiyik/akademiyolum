<?php

use App\Models\User;
use App\Services\Scoring\Sart\SartDeposu;

/**
 * ANALİZİN DAYANDIĞI KAYNAK BELGE.
 *
 * Aday detay panelinde bir koşulu sorguladığında, o koşulun TAM OLARAK hangi
 * metinden çıkarıldığını görebilmeli. YÖK'ün sayfasındaki dosya değişmiş
 * olabilir; bizim okuduğumuz kopya `pdf/` altında duruyor ve public/ dışında.
 *
 * Eşleme ayrı bir dosyada tutulmuyor: her yönerge dosyasının başlık
 * docblock'undaki `Kaynak: pdf/…` satırından okunuyor. Buradaki testler o
 * ayrıştırmanın korpusun TAMAMINDA çalıştığını dondurur — bir yönerge
 * eklenip `Kaynak:` satırı yazılmazsa ya da dosya adı değişirse kırılır.
 *
 * `pdf/` .gitignore'da (181 MB kaynak belge, depoda taşınmıyor). Belgenin
 * KENDİSİNE dokunan testler o yüzden koşullu; eşlemeyi doğrulayanlar değil.
 */
function kaynakPdfleriVar(): bool
{
    return (glob(base_path('pdf/*.pdf')) ?: []) !== [];
}
test('doğrulanmış her üniversitenin kaynak PDF eşlemesi var', function () {
    $depo = new SartDeposu;

    $eksik = array_values(array_filter(
        $depo->universiteler(),
        fn (string $ad) => $depo->kaynakPdf($ad) === null,
    ));

    expect($eksik)->toBe([]);
});

test('eşlenen her kaynak PDF diskte duruyor', function () {
    $depo = new SartDeposu;

    $kayip = [];

    foreach ($depo->universiteler() as $ad) {
        $dosya = (string) $depo->kaynakPdf($ad);

        if (! is_file(base_path('pdf/'.$dosya))) {
            $kayip[] = "{$ad} => {$dosya}";
        }
    }

    expect($kayip)->toBe([]);
})->skip(fn () => ! kaynakPdfleriVar(), 'Kaynak PDF klasörü (pdf/) bu ortamda yok.');

test('docblock satırı alt satıra sarılmış olsa da dosya adı bütün okunur', function () {
    // İki yönergede `Kaynak:` satırı 80 sütuna sığmadığı için sarılıyor;
    // ayrıştırıcı satır başlarındaki " * " süsünü atıp metni düzleştiriyor.
    expect((new SartDeposu)->kaynakPdf('Ankara Yıldırım Beyazıt Üniversitesi'))
        ->toBe('1785505464273.Ankara Yıldırım Beyazıt Üniversitesi Kriteri 16.07.2026 GK.pdf');
});

test('kaynak belge misafire kapalı', function () {
    $this->get(route('yonerge-analizi.kaynak', 'Boğaziçi Üniversitesi'))
        ->assertRedirect(route('login'));
});

test('kimliği doğrulanmış aday kaynak belgeyi tarayıcıda açabilir', function () {
    $this->actingAs(User::factory()->onboarded()->create());

    $yanit = $this->get(route('yonerge-analizi.kaynak', 'Boğaziçi Üniversitesi'));

    $yanit->assertOk();
    expect($yanit->headers->get('content-type'))->toBe('application/pdf')
        ->and($yanit->headers->get('content-disposition'))->toStartWith('inline;');
})->skip(fn () => ! kaynakPdfleriVar(), 'Kaynak PDF klasörü (pdf/) bu ortamda yok.');

test('tanınmayan üniversite ve dizin gezinmesi 404 döner', function () {
    $this->actingAs(User::factory()->onboarded()->create());

    // Dosya adı istekten gelmiyor; eşleşmeyen her ad tek bir sonuca çıkar.
    $this->get(route('yonerge-analizi.kaynak', 'Olmayan Üniversitesi'))->assertNotFound();
    $this->get('/yonerge-analizi/kaynak/'.urlencode('../.env'))->assertNotFound();
});
