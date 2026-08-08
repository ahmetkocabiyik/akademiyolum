<?php

use App\Enums\Kategori;
use App\Models\Faaliyet;
use App\Models\User;
use App\Services\Scoring\Sart\ProfilCozucu;

/**
 * Kaydedilmemiş faaliyet.
 */
function pcFaaliyet(Kategori $kategori, ?string $kaynak = null, ?string $rol = null): Faaliyet
{
    return new Faaliyet([
        'kategori' => $kategori,
        'tur' => 'Test',
        'baslik' => 'Test',
        'kaynak' => $kaynak,
        'rol' => $rol,
        'durum' => 'onaylandi',
    ]);
}

function pcKullanici(array $nitelikler = []): User
{
    return new User($nitelikler);
}

test('atıf sayısı Atıf kategorisindeki faaliyetlerden sayılır', function () {
    $profil = (new ProfilCozucu)->coz(pcKullanici(), [
        pcFaaliyet(Kategori::Atif, 'WoS / Scopus'),
        pcFaaliyet(Kategori::Atif, 'TR Dizin'),
        pcFaaliyet(Kategori::Atif, 'Diğer'),
        pcFaaliyet(Kategori::Makale, 'SCIE/SSCI (Q1)'),
    ]);

    expect($profil->atifSayisi)->toBe(3);
});

test('proje sayaçları role göre ayrışır', function () {
    $profil = (new ProfilCozucu)->coz(pcKullanici(), [
        pcFaaliyet(Kategori::Proje, 'TÜBİTAK', 'yurutucu'),
        pcFaaliyet(Kategori::Proje, 'BAP (Üniversite)', 'yurutucu'),
        pcFaaliyet(Kategori::Proje, 'AB Çerçeve / Ufuk', 'arastirmaci'),
        pcFaaliyet(Kategori::Proje, 'TÜBİTAK', 'bursiyer'),
        pcFaaliyet(Kategori::Proje, 'TÜBİTAK', 'danisman'),
    ]);

    expect($profil->projeYurutuculuk)->toBe(2)
        // Bursiyer, yönergelerin çoğunda araştırmacıyla aynı bentte geçiyor.
        ->and($profil->projeArastirmaci)->toBe(2)
        ->and($profil->projeDanisman)->toBe(1);
});

test('tez danışmanlığı sayılırken jüri üyeliği hariç tutulur', function () {
    $profil = (new ProfilCozucu)->coz(pcKullanici(), [
        pcFaaliyet(Kategori::TezDanismanligi, 'Doktora Tezi', 'danisman'),
        pcFaaliyet(Kategori::TezDanismanligi, 'Tıpta/Diş/Sanatta Yeterlik Tezi', 'danisman'),
        pcFaaliyet(Kategori::TezDanismanligi, 'Yüksek Lisans Tezi', 'danisman'),
        pcFaaliyet(Kategori::TezDanismanligi, 'Tez İzleme / Jüri Üyeliği', null),
    ]);

    expect($profil->tezDanismanlik)->toBe(3)
        ->and($profil->doktoraTezDanismanlik)->toBe(2);
});

test('ders yarıyılı Eğitim-Öğretim faaliyetlerinden sayılır', function () {
    $profil = (new ProfilCozucu)->coz(pcKullanici(), [
        pcFaaliyet(Kategori::EgitimOgretim, 'Lisansüstü Ders'),
        pcFaaliyet(Kategori::EgitimOgretim, 'Lisans/Önlisans Ders'),
    ]);

    expect($profil->dersYariyil)->toBe(2);
});

test('kategoride hiç kayıt yoksa null döner, sıfır değil', function () {
    // "0 tane var" kesin olumsuz, "hiç girilmemiş" belirsiz — motor ikisini
    // farklı değerlendiriyor, bu yüzden ayrım korunmalı.
    $bos = (new ProfilCozucu)->coz(pcKullanici(), []);

    expect($bos->atifSayisi)->toBeNull()
        ->and($bos->projeYurutuculuk)->toBeNull()
        ->and($bos->tezDanismanlik)->toBeNull();

    // Kategoride kayıt var ama filtreye uyan yok → 0 (kesin olumsuz).
    $sadeceArastirmaci = (new ProfilCozucu)->coz(pcKullanici(), [
        pcFaaliyet(Kategori::Proje, 'TÜBİTAK', 'arastirmaci'),
    ]);

    expect($sadeceArastirmaci->projeYurutuculuk)->toBe(0)
        ->and($sadeceArastirmaci->projeArastirmaci)->toBe(1);
});

test('faaliyetten türetilmeyen ölçütler profil alanlarından okunur', function () {
    $profil = (new ProfilCozucu)->coz(pcKullanici([
        'yds_puani' => 85,
        'h_indeksi' => 12,
        'yurtdisi_ay' => 8,
        'program_dili' => 'yabanci_dil_100',
    ]), []);

    expect($profil->yds)->toBe(85)
        ->and($profil->hIndeksi)->toBe(12)
        ->and($profil->yurtdisiAy)->toBe(8)
        ->and($profil->programDili)->toBe('yabanci_dil_100');
});
