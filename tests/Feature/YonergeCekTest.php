<?php

use App\Models\Universite;
use Illuminate\Support\Facades\Http;

function ornekYokHtml(): string
{
    return <<<'HTML'
    <table><tbody>
        <tr>
            <td><h1>Sıra</h1></td>
            <td><h1>DEVLET ÜNİVERSİTESİ</h1></td>
            <td><h1>VAKIF ÜNİVERSİTESİ</h1></td>
        </tr>
        <tr>
            <td><h3>1</h3></td>
            <td><h3><a href="https://personel.yok.gov.tr/documentFiles/1.mersin.pdf">MERSİN ÜNİVERSİTESİ</a></h3></td>
            <td><h3><a href="https://personel.yok.gov.tr/tr/document/99">KOÇ ÜNİVERSİTESİ</a></h3></td>
        </tr>
    </tbody></table>
    HTML;
}

test('mevcut üniversitenin yönerge linki güncellenir', function () {
    Http::fake(['personel.yok.gov.tr/*' => Http::response(ornekYokHtml())]);

    $mersin = Universite::factory()->create(['ad' => 'Mersin Üniversitesi', 'tur' => 'devlet']);

    $this->artisan('yonerge:cek')->assertSuccessful();

    expect($mersin->refresh()->yonerge_url)->toBe('https://personel.yok.gov.tr/documentFiles/1.mersin.pdf');
});

test('listede olmayan üniversite tür ve link ile eklenir', function () {
    Http::fake(['personel.yok.gov.tr/*' => Http::response(ornekYokHtml())]);

    $this->artisan('yonerge:cek')->assertSuccessful();

    $koc = Universite::query()->where('ad', 'Koç Üniversitesi')->first();

    expect($koc)->not->toBeNull()
        ->and($koc->tur)->toBe('vakif')
        ->and($koc->yonerge_url)->toBe('https://personel.yok.gov.tr/tr/document/99')
        ->and($koc->yonergeler()->count())->toBe(1); // placeholder yönerge oluşturuldu
});

test('sayfa çekilemezse hata döner', function () {
    Http::fake(['personel.yok.gov.tr/*' => Http::response('', 500)]);

    $this->artisan('yonerge:cek')->assertFailed();
});
