<?php

namespace App\Services\Yayin;

use App\Livewire\FaaliyetEkle;

/**
 * Bir kurumsal akademik profil sisteminden faaliyet okuyan servis.
 *
 * NEDEN ARAYÜZ GEREKTİ: "AVESİS" tek sistem sanılıyordu. Değil. Çoğu
 * üniversite gerçekten AVESİS kullanıyor (avesis.ktu.edu.tr/kullaniciadi),
 * ama Mersin kendi yazılımını yazmış: APBS, apbs.mersin.edu.tr/profiles/410660.
 * Aynı işi yapıyorlar — adayın yayınını, projesini, görevini tutuyorlar — ama
 * adres yapısı, bölüm adları ve HTML'i bambaşka; tek okuyucu ikisini
 * karşılayamıyor.
 *
 * ORTAK OLAN ÇIKTI: iki okuyucu da aynı biçimde kayıt döndürüyor. Ekran
 * hangi sistemin okunduğunu bilmek zorunda değil; künyeye yazılan sistem
 * adı dışında {@see FaaliyetEkle} tek bir yol biliyor.
 *
 * @phpstan-type ProfilKaydi array{
 *     id: string,
 *     kategori: string,
 *     baslik: string,
 *     yazarlar: string,
 *     kunye: string,
 *     yil: int|null,
 *     doi: string|null,
 *     kaynak: string|null,
 *     uyari: string|null,
 *     rol?: string|null,
 *     atlandi: bool,
 * }
 */
interface ProfilOkuyucu
{
    /**
     * Künyeye yazılan sistem anahtarı ('avesis', 'apbs').
     *
     * Mükerrer denetimi kayıt izini bununla kuruyor
     * ({@see MukerrerDenetimi::izler}); değiştirilirse eski kayıtların izi
     * kopar.
     */
    public function sistem(): string;

    /** Adayın gördüğü ad ('AVESİS', 'APBS'). */
    public function ad(): string;

    /** Adres tanınmadığında gösterilen örnek. */
    public function ornekAdres(): string;

    /**
     * Profil adresini ayrıştırır; tanımıyorsa null.
     *
     * @return array{taban: string, kullanici: string}|null
     */
    public function adres(string $girdi): ?array;

    /**
     * Profildeki faaliyetler.
     *
     * @param  array{taban: string, kullanici: string}  $adres
     * @return list<ProfilKaydi>
     */
    public function kayitlar(array $adres): array;

    /**
     * Son okumada ULAŞILAMAYAN bölüm sayısı.
     *
     * Liste eksikse aday bunu bilmeli: gördüğü kadarını profilinin tamamı
     * sanıp kalanını elle aramaya kalkmasın ya da hiç aramasın.
     */
    public function eksikBolum(): int;
}
