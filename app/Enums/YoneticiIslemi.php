<?php

namespace App\Enums;

/**
 * İşlem kaydına yazılan yönetici işlemleri.
 */
enum YoneticiIslemi: string
{
    case AdminYapildi = 'admin_yapildi';
    case AdminligiAlindi = 'adminligi_alindi';
    case AskiyaAldi = 'askiya_aldi';
    case AskidanCikardi = 'askidan_cikardi';
    case KullaniciOlarakGirdi = 'kullanici_olarak_girdi';
    case KullaniciOlarakCikti = 'kullanici_olarak_cikti';
    case KullaniciyiSildi = 'kullaniciyi_sildi';
    case AbonelikEkledi = 'abonelik_ekledi';
    case AbonelikIptalEtti = 'abonelik_iptal_etti';

    public function etiket(): string
    {
        return match ($this) {
            self::AdminYapildi => 'Süper admin yapıldı',
            self::AdminligiAlindi => 'Süper adminliği alındı',
            self::AskiyaAldi => 'Hesabı askıya aldı',
            self::AskidanCikardi => 'Askıyı kaldırdı',
            self::KullaniciOlarakGirdi => 'Kullanıcı olarak girdi',
            self::KullaniciOlarakCikti => 'Kullanıcı görünümünden çıktı',
            self::KullaniciyiSildi => 'Kullanıcıyı sildi',
            self::AbonelikEkledi => 'Abonelik ekledi',
            self::AbonelikIptalEtti => 'Aboneliği iptal etti',
        };
    }

    /** Flux rozet rengi: geri alınamayan ve hassas işlemler göze batsın. */
    public function rozet(): string
    {
        return match ($this) {
            self::KullaniciyiSildi, self::AskiyaAldi => 'red',
            self::KullaniciOlarakGirdi, self::KullaniciOlarakCikti => 'amber',
            self::AbonelikEkledi => 'green',
            self::AbonelikIptalEtti => 'orange',
            default => 'zinc',
        };
    }
}
