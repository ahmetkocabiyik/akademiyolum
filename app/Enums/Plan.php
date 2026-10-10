<?php

namespace App\Enums;

use App\Services\Abonelik\PaketKatalogu;

/**
 * Abonelik planlarının KİMLİĞİ.
 *
 * Ad, fiyat, açıklama ve özellikler panelden düzenleniyor (`paketler`
 * tablosu, {@see PaketKatalogu}); burada yalnızca kimlik, rozet rengi ve
 * tablo boşken kullanılan varsayılanlar var. Paket eklenip silinmiyor:
 * plan kısıtlamaları (faaliyet sınırı, YZ kilidi) geldiğinde bu kimliklere
 * bağlanacak.
 */
enum Plan: string
{
    case Ucretsiz = 'ucretsiz';
    case Akademisyen = 'akademisyen';
    case Kurumsal = 'kurumsal';

    /** Panelde düzenlenen ad (ör. "Akademisyen"). */
    public function etiket(): string
    {
        return app(PaketKatalogu::class)->bilgi($this)->ad;
    }

    /** Flux rozet rengi. */
    public function rozet(): string
    {
        return match ($this) {
            self::Ucretsiz => 'zinc',
            self::Akademisyen => 'blue',
            self::Kurumsal => 'amber',
        };
    }

    /**
     * Tablo boşken paketin ilk hâli — tanıtım sayfasındaki ilk fiyatlandırma.
     *
     * @return array{ad: string, aciklama: string, aylik_fiyat_kurus: int, yillik_fiyat_kurus: int|null, ozellikler: list<string>, buton_metni: string, one_cikan: bool}
     */
    public function varsayilan(): array
    {
        return match ($this) {
            self::Ucretsiz => [
                'ad' => 'Ücretsiz',
                'aciklama' => 'Başlamak için mükemmel.',
                'aylik_fiyat_kurus' => 0,
                'yillik_fiyat_kurus' => null,
                'ozellikler' => ['10 faaliyete kadar', 'Temel puan hesaplama', '1 yönerge analizi'],
                'buton_metni' => 'Ücretsiz Başla',
                'one_cikan' => false,
            ],
            self::Akademisyen => [
                'ad' => 'Akademisyen',
                'aciklama' => 'Aktif kariyer yönetimi için.',
                'aylik_fiyat_kurus' => 29900,
                'yillik_fiyat_kurus' => null,
                'ozellikler' => ['Sınırsız faaliyet', 'YZ Danışman', 'Tüm yönerge analizleri', 'Kurum profilinden aktarım', 'YZ Jüri Analizi', 'PDF/Word çıktı'],
                'buton_metni' => 'Planı Seç',
                'one_cikan' => true,
            ],
            self::Kurumsal => [
                'ad' => 'Kurumsal',
                'aciklama' => 'Üniversiteler için kurumsal çözüm.',
                'aylik_fiyat_kurus' => 99900,
                'yillik_fiyat_kurus' => null,
                'ozellikler' => ['50 kullanıcıya kadar', 'Özel yönerge yükleme', 'Kurum panosu', 'API erişimi'],
                'buton_metni' => 'İletişime Geç',
                'one_cikan' => false,
            ],
        };
    }

    /**
     * Abonelikle atanabilen planlar; ücretsiz plan aboneliksiz durumun adı,
     * satır olarak yazılmıyor.
     *
     * @return list<self>
     */
    public static function ucretliler(): array
    {
        return [self::Akademisyen, self::Kurumsal];
    }
}
