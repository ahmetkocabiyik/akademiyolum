<?php

use App\Rules\GecerliOrcid;
use Illuminate\Support\Facades\Validator;

function orcidGecer(mixed $deger): bool
{
    return ! Validator::make(['orcid' => $deger], ['orcid' => ['nullable', new GecerliOrcid]])->fails();
}

test('kontrol hanesi doğru orcid kimlikleri kabul edilir', function (string $kimlik) {
    expect(orcidGecer($kimlik))->toBeTrue();
})->with([
    'orcid örneği' => '0000-0002-1825-0097',
    'X ile biten' => '0000-0002-1694-233X',
    'küçük x' => '0000-0002-1694-233x',
    'başka bir örnek' => '0000-0001-5109-3700',
]);

test('biçimi bozuk, kontrol hanesi yanlış ya da orcid olmayan değer reddedilir', function (string $deger) {
    expect(orcidGecer($deger))->toBeFalse();
})->with([
    'son hane yanlış' => '0000-0002-1825-0098',
    'iki hane yer değiştirmiş' => '0000-0002-1852-0097',
    'eksik' => '0000-0002-1825',
    'tiresiz' => '0000000218250097',
    'X ortada' => '0000-000X-1825-0097',
    'web adresi' => 'https://ahmet.example.edu',
]);

test('boş değer nullable kuralına kalır', function (mixed $deger) {
    expect(orcidGecer($deger))->toBeTrue();
})->with(['boş' => '', 'null' => null]);

test('kimlik herhangi bir yazımı çıplak ve büyük harfli kimliğe indirir', function (?string $deger, ?string $beklenen) {
    expect(GecerliOrcid::kimlik($deger))->toBe($beklenen);
})->with([
    'çıplak' => ['0000-0002-1825-0097', '0000-0002-1825-0097'],
    'küçük x' => ['0000-0002-1694-233x', '0000-0002-1694-233X'],
    'https adres' => ['https://orcid.org/0000-0001-5109-3700', '0000-0001-5109-3700'],
    'şemasız adres' => ['orcid.org/0000-0001-5109-3700', '0000-0001-5109-3700'],
    'yanlış hane' => ['0000-0002-1825-0098', null],
    'web' => ['https://ahmet.example.edu', null],
    'null' => [null, null],
]);
