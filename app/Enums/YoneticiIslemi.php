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
    case SablonGuncelledi = 'sablon_guncelledi';
    case SablonSifirladi = 'sablon_sifirladi';
    case PaketGuncelledi = 'paket_guncelledi';
    case YonergeGizledi = 'yonerge_gizledi';
    case YonergeYayinaAldi = 'yonerge_yayina_aldi';
    case UniversiteGuncelledi = 'universite_guncelledi';

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
            self::SablonGuncelledi => 'E-posta şablonunu güncelledi',
            self::SablonSifirladi => 'E-posta şablonunu varsayılana döndürdü',
            self::PaketGuncelledi => 'Paketi güncelledi',
            self::YonergeGizledi => 'Yönergeyi yayından kaldırdı',
            self::YonergeYayinaAldi => 'Yönergeyi yeniden yayına aldı',
            self::UniversiteGuncelledi => 'Üniversite künyesini güncelledi',
        };
    }

    /** Flux rozet rengi: geri alınamayan ve hassas işlemler göze batsın. */
    public function rozet(): string
    {
        return match ($this) {
            self::KullaniciyiSildi, self::AskiyaAldi, self::YonergeGizledi => 'red',
            self::KullaniciOlarakGirdi, self::KullaniciOlarakCikti => 'amber',
            self::AbonelikEkledi => 'green',
            self::AbonelikIptalEtti => 'orange',
            default => 'zinc',
        };
    }
}
