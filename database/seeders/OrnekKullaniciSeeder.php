<?php

namespace Database\Seeders;

use App\Enums\Kategori;
use App\Models\Faaliyet;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Üç örnek kullanıcı — farklı temel alan, farklı unvan, farklı kariyer aşaması.
 *
 * Amaç yalnızca giriş yapabilmek değil: her biri motorun ayrı bir davranışını
 * tetikliyor, böylece arayüz gerçek verilerle sınanabiliyor.
 *
 *   ars-gor@ornek.test     Arş. Gör. · Fen          → hedef Dr. Öğr. Üyesi
 *   dr-ogr@ornek.test      Dr. Öğr. Üyesi · Müh.    → hedef Doçentlik
 *   docent@ornek.test      Doç. Dr. · Sosyal        → hedef Profesörlük
 *
 * Şifre (üçü de): rty456fgh
 *
 * Faaliyetlerin TARİHİ ve profilin dönüm tarihleri bilinçli olarak dolu:
 * yönergelerin 347 dönem kapsamlı düğümü ancak ikisi birden varsa kesin
 * sonuca bağlanıyor. Bir faaliyet kasten tarihsiz bırakıldı ki "belirsiz"
 * durumu da ekranda görülebilsin.
 */
class OrnekKullaniciSeeder extends Seeder
{
    private const SIFRE = 'rty456fgh';

    public function run(): void
    {
        $this->arastirmaGorevlisi();
        $this->doktorOgretimUyesi();
        $this->docent();
    }

    /**
     * Kariyer başı: doktorasını sürdürüyor, yayın sayısı düşük, atama geçmişi
     * yok. Yönerge analizinde çoğu koşulun "sağlanmadı" göründüğü senaryo.
     * Doktora tarihi olmadığı için "doktora sonrası" koşulları gerekçesiyle
     * birlikte belirsiz kalıyor — motorun o yolu da ekranda görülebiliyor.
     */
    private function arastirmaGorevlisi(): void
    {
        $user = $this->kullanici('argor@ornek.test', [
            'name' => 'Elif Şahin',
            'unvan' => 'Arş. Gör.',
            'universite' => 'Akdeniz Üniversitesi',
            'fakulte' => 'Fen Fakültesi',
            'bolum' => 'Biyoloji',
            'temel_alan' => 'fen',
            'program_dili' => 'turkce',
            'yds_puani' => 72,
            'h_indeksi' => 2,
            'lisans_tarihi' => '2016-06-20',
            // Doktora tarihi KASTEN yok: "Arş. Gör." unvanı doktorayı ima etmez
            // (doktorasını sürdüren de bitirmiş olan da aynı kadroda olabilir).
            // Böylece "dönem referansı girilmemiş" yolu da bir kullanıcıda sınanıyor.
        ]);

        $this->faaliyetler($user, [
            [Kategori::Makale, 'SCIE/SSCI (Q3)', 'ilk', '2024-02-20', 'Kurak Alan Bitkilerinde Su Stresi Yanıtı'],
            [Kategori::Makale, 'TR Dizin', 'tek', '2024-11-05', 'Akdeniz Florasında Endemik Tür Dağılımı'],
            [Kategori::Bildiri, 'Uluslararası Tam Metin (CPCI)', 'ilk', '2025-05-12', 'Tohum Çimlenmesinde Sıcaklık Etkisi'],
            [Kategori::EgitimOgretim, 'Lisans/Önlisans Ders', null, '2025-02-10', 'Genel Biyoloji I'],
        ]);
    }

    /**
     * Orta kariyer: doçentliğe hazırlanıyor, proje ve tez danışmanlığı var.
     * Eşdeğerlik (Sabancı) ve dönem koşulları bu profilde devreye giriyor.
     */
    private function doktorOgretimUyesi(): void
    {
        $user = $this->kullanici('dr@ornek.test', [
            'name' => 'Murat Doğan',
            'unvan' => 'Dr. Öğr. Üyesi',
            'universite' => 'Bursa Uludağ Üniversitesi',
            'fakulte' => 'Mühendislik Fakültesi',
            'bolum' => 'Makine Mühendisliği',
            'temel_alan' => 'muhendislik',
            'program_dili' => 'yabanci_dil_30',
            'yds_puani' => 78,
            'h_indeksi' => 7,
            'yurtdisi_ay' => 8,
            'lisans_tarihi' => '2010-06-25',
            'doktora_tarihi' => '2018-06-30',
            'son_atama_tarihi' => '2021-09-01',
        ]);

        $this->faaliyetler($user, [
            [Kategori::Makale, 'SCIE/SSCI (Q1)', 'baslica', '2022-04-18', 'Kompozit Malzemelerde Yorulma Ömrü Tahmini'],
            [Kategori::Makale, 'SCIE/SSCI (Q2)', 'ilk', '2023-01-30', 'Katmanlı İmalatta Isıl Gerilme Analizi'],
            [Kategori::Makale, 'SCIE/SSCI (Q2)', 'ortak', '2024-07-09', 'Termoplastik Matrisli Yapılarda Delaminasyon'],
            [Kategori::Makale, 'ESCI / Scopus', 'tek', '2025-03-22', 'Yenilenebilir Enerji Sistemlerinde Verim Optimizasyonu'],
            [Kategori::Kitap, 'BKCI / Scopus Kitap Bölümü', 'tek', '2024-10-01', 'Additive Manufacturing of Polymers (Bölüm 7)'],
            [Kategori::Proje, 'TÜBİTAK', 'yurutucu', '2023-03-01', '1001 — Hafif Yapı Elemanlarının Geliştirilmesi'],
            [Kategori::Proje, 'AB Çerçeve / Ufuk', 'arastirmaci', '2022-09-15', 'Horizon Europe — Sürdürülebilir Üretim'],
            [Kategori::TezDanismanligi, 'Yüksek Lisans Tezi', 'danisman', '2024-06-20', 'Kompozit Panellerde Darbe Davranışı'],
            [Kategori::Atif, 'WoS / Scopus', null, '2025-01-15', 'Yorulma Ömrü Makalesine Atıf'],
            [Kategori::EgitimOgretim, 'Lisansüstü Ders', null, '2024-09-20', 'İleri Malzeme Mekaniği'],
        ]);
    }

    /**
     * Profesörlüğe hazırlanıyor: doçentlik sonrası üretimi ayrı sınanıyor.
     * Bir faaliyet KASTEN tarihsiz — "belirsiz" durumu ekranda görülebilsin.
     */
    private function docent(): void
    {
        $user = $this->kullanici('docent@ornek.test', [
            'name' => 'Ayşe Kurt',
            'unvan' => 'Doç. Dr.',
            'universite' => 'Samsun Üniversitesi',
            'fakulte' => 'İktisadi ve İdari Bilimler Fakültesi',
            'bolum' => 'İşletme',
            'temel_alan' => 'sosyal',
            'program_dili' => 'turkce',
            'yds_puani' => 85,
            'h_indeksi' => 11,
            'lisans_tarihi' => '2006-06-15',
            'doktora_tarihi' => '2014-02-10',
            'docentlik_tarihi' => '2020-03-15',
            'son_atama_tarihi' => '2020-09-01',
        ]);

        $this->faaliyetler($user, [
            [Kategori::Makale, 'SCIE/SSCI (Q1)', 'baslica', '2021-05-14', 'Kurumsal Yönetişimin Firma Değerine Etkisi'],
            [Kategori::Makale, 'SCIE/SSCI (Q2)', 'baslica', '2022-08-03', 'Tedarik Zincirinde Dijitalleşme ve Dayanıklılık'],
            [Kategori::Makale, 'AHCI', 'ilk', '2023-11-27', 'Aile İşletmelerinde Kuşak Devri'],
            [Kategori::Makale, 'ESCI / Scopus', 'ortak', '2024-04-16', 'KOBİ\'lerde Finansal Okuryazarlık'],
            [Kategori::Makale, 'TR Dizin', 'tek', '2025-02-08', 'Girişimcilik Ekosisteminde Kamu Desteklerinin Rolü'],
            // Tarihi kasten yok: dönem koşulları bunu "belirsiz" bırakmalı.
            [Kategori::Makale, 'TR Dizin', 'tek', null, 'Örgütsel Bağlılık Üzerine Bir Alan Araştırması'],
            [Kategori::Kitap, 'Uluslararası/Ulusal Kitap', 'tek', '2022-12-01', 'Stratejik Yönetim: Kuram ve Uygulama'],
            [Kategori::Bildiri, 'Uluslararası Tam Metin', 'ilk', '2023-06-11', 'Dijital Dönüşümde Örgütsel Direnç'],
            [Kategori::Proje, 'TÜBİTAK', 'yurutucu', '2021-10-01', '1001 — Bölgesel Kalkınmada Kümelenme'],
            [Kategori::Proje, 'BAP (Üniversite)', 'yurutucu', '2023-02-15', 'BAP — Kurumsal İtibar Ölçeği Geliştirme'],
            [Kategori::TezDanismanligi, 'Doktora Tezi', 'danisman', '2023-09-08', 'Kurumsal Sürdürülebilirlik Raporlaması'],
            [Kategori::TezDanismanligi, 'Yüksek Lisans Tezi', 'danisman', '2022-06-24', 'Marka Sadakati ve Müşteri Deneyimi'],
            [Kategori::Atif, 'WoS / Scopus', null, '2024-01-20', 'Kurumsal Yönetişim Makalesine Atıf'],
            [Kategori::EgitimOgretim, 'Lisansüstü Ders', null, '2023-09-25', 'Araştırma Yöntemleri'],
            [Kategori::EgitimOgretim, 'Lisans/Önlisans Ders', null, '2024-02-12', 'İşletme Yönetimi'],
        ]);
    }

    /**
     * Opsiyonel profil alanları. Hepsi açıkça null'a çekiliyor: `updateOrCreate`
     * yalnızca verilen anahtarları yazdığı için, bir alan seeder'dan çıkarılınca
     * eski değeri veritabanında kalıyordu. Böylece seeder her çalıştığında
     * kullanıcıyı aynı hâle getiriyor.
     *
     * @var array<string, null>
     */
    private const BOS_PROFIL = [
        'lisans_tarihi' => null,
        'doktora_tarihi' => null,
        'docentlik_tarihi' => null,
        'son_atama_tarihi' => null,
        'program_dili' => null,
        'yds_puani' => null,
        'h_indeksi' => null,
        'yurtdisi_ay' => null,
    ];

    /**
     * @param  array<string, mixed>  $nitelikler
     */
    private function kullanici(string $eposta, array $nitelikler): User
    {
        /** @var User $user */
        $user = User::query()->updateOrCreate(['email' => $eposta], $nitelikler + self::BOS_PROFIL + [
            'password' => Hash::make(self::SIFRE),
            'email_verified_at' => now(),
            'onboarded_at' => now(),
        ]);

        // Tekrar çalıştırıldığında faaliyetler ikiye katlanmasın.
        $user->faaliyetler()->delete();

        return $user;
    }

    /**
     * @param  list<array{0: Kategori, 1: string, 2: ?string, 3: ?string, 4: string}>  $satirlar
     */
    private function faaliyetler(User $user, array $satirlar): void
    {
        foreach ($satirlar as [$kategori, $kaynak, $rol, $tarih, $baslik]) {
            $user->faaliyetler()->save(new Faaliyet([
                'kategori' => $kategori,
                'tur' => $kategori->label(),
                'baslik' => $baslik,
                'kaynak' => $kaynak,
                'rol' => $rol,
                'tarih' => $tarih,
                'donem' => $kategori->tezdenUretilebilir() ? 'tez_disi' : null,
                'durum' => 'onaylandi',
            ]));
        }
    }
}
