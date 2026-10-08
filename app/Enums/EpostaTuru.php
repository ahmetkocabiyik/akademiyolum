<?php

namespace App\Enums;

/**
 * Uygulamanın gönderdiği şablonlu e-postalar.
 *
 * Konu ve gövdenin VARSAYILANI burada; panelden düzenlenen hâli
 * `eposta_sablonlari` tablosunda. Satır yoksa (ya da "varsayılana dön"
 * denmişse) bu metinler kullanılır.
 */
enum EpostaTuru: string
{
    // Hesap
    case KayitKullanici = 'kayit_kullanici';
    case SifreSifirlama = 'sifre_sifirlama';
    case EpostaDogrulama = 'eposta_dogrulama';
    case HesapAskiyaAlindi = 'hesap_askiya_alindi';
    case HesapAskidanCikarildi = 'hesap_askidan_cikarildi';
    case HesapSilindi = 'hesap_silindi';

    // Abonelik (kullanıcıya)
    case AbonelikKullanici = 'abonelik_kullanici';
    case AbonelikBitiyor = 'abonelik_bitiyor';
    case AbonelikBitti = 'abonelik_bitti';
    case AbonelikIptal = 'abonelik_iptal';

    // Yöneticiye
    case KayitYonetici = 'kayit_yonetici';
    case AbonelikYonetici = 'abonelik_yonetici';
    case AbonelikBitiyorYonetici = 'abonelik_bitiyor_yonetici';

    /** Bitişe bu kadar gün kala hatırlatma gider. */
    public const HATIRLATMA_GUN = 7;

    public function etiket(): string
    {
        return match ($this) {
            self::KayitKullanici => 'Hoş geldin',
            self::SifreSifirlama => 'Şifre sıfırlama',
            self::EpostaDogrulama => 'E-posta doğrulama',
            self::HesapAskiyaAlindi => 'Hesap askıya alındı',
            self::HesapAskidanCikarildi => 'Hesap yeniden açıldı',
            self::HesapSilindi => 'Hesap silindi',
            self::AbonelikKullanici => 'Abonelik başladı',
            self::AbonelikBitiyor => 'Abonelik bitiyor (hatırlatma)',
            self::AbonelikBitti => 'Abonelik sona erdi',
            self::AbonelikIptal => 'Abonelik iptal edildi',
            self::KayitYonetici => 'Yeni kayıt bildirimi',
            self::AbonelikYonetici => 'Yeni abonelik bildirimi',
            self::AbonelikBitiyorYonetici => 'Biten abonelikler özeti',
        };
    }

    /** Panelde gruplama. */
    public function grup(): string
    {
        return match ($this) {
            self::KayitKullanici, self::SifreSifirlama, self::EpostaDogrulama,
            self::HesapAskiyaAlindi, self::HesapAskidanCikarildi, self::HesapSilindi => 'Hesap (kullanıcıya)',
            self::AbonelikKullanici, self::AbonelikBitiyor, self::AbonelikBitti, self::AbonelikIptal => 'Abonelik (kullanıcıya)',
            self::KayitYonetici, self::AbonelikYonetici, self::AbonelikBitiyorYonetici => 'Yöneticiye',
        };
    }

    /** Ne zaman ve kime gittiği — panelde şablonun altında. */
    public function aciklama(): string
    {
        $gun = self::HATIRLATMA_GUN;

        return match ($this) {
            self::KayitKullanici => 'Yeni bir kullanıcı kayıt olduğunda kullanıcının kendisine gider.',
            self::SifreSifirlama => 'Kullanıcı "şifremi unuttum" dediğinde gider. Kapatılamaz: kapalıyken kimse şifresini sıfırlayamazdı.',
            self::EpostaDogrulama => 'Kullanıcı e-posta doğrulama bağlantısı istediğinde gider. Kapatılamaz.',
            self::HesapAskiyaAlindi => 'Yönetici hesabı askıya aldığında kullanıcıya gider; yazılan neden eklenir.',
            self::HesapAskidanCikarildi => 'Yönetici askıyı kaldırdığında kullanıcıya gider.',
            self::HesapSilindi => 'Yönetici hesabı sildiğinde kullanıcıya teyit olarak gider.',
            self::AbonelikKullanici => 'Kullanıcıya abonelik tanımlandığında kullanıcının kendisine gider.',
            self::AbonelikBitiyor => "Aktif aboneliğin bitişine {$gun} gün kala, her gün çalışan zamanlanmış görevle gider. Abonelik yenilenmişse gitmez; bir abonelik için bir kez gider.",
            self::AbonelikBitti => 'Abonelik bitiş gününü geçince gider. Kullanıcının başka aktif aboneliği varsa gitmez.',
            self::AbonelikIptal => 'Yönetici aktif ya da başlamamış bir aboneliği iptal ettiğinde gider.',
            self::KayitYonetici => 'Yeni bir kullanıcı kayıt olduğunda bütün süper adminlere gider.',
            self::AbonelikYonetici => 'Kullanıcıya abonelik tanımlandığında bütün süper adminlere gider.',
            self::AbonelikBitiyorYonetici => 'Zamanlanmış görev o gün hatırlatma gönderdiyse, bitecek aboneliklerin listesi bütün süper adminlere gider.',
        };
    }

    /** Şifre sıfırlama ve doğrulama kapatılamaz: kapalıyken hesaba erişim kaybolur. */
    public function kapatilabilir(): bool
    {
        return ! in_array($this, [self::SifreSifirlama, self::EpostaDogrulama], true);
    }

    /**
     * Gövdede ve konuda kullanılabilen değişkenler: `ad => açıklama`.
     *
     * @return array<string, string>
     */
    public function degiskenler(): array
    {
        $ortak = [
            'ad' => 'Kullanıcının adı soyadı',
            'eposta' => 'Kullanıcının e-postası',
            'uygulama' => 'Uygulamanın adı',
        ];
        $abonelik = [
            'plan' => 'Plan adı',
            'baslangic' => 'Başlangıç tarihi',
            'bitis' => 'Bitiş tarihi ("süresiz" olabilir)',
        ];

        return match ($this) {
            self::KayitKullanici => $ortak + ['giris_adresi' => 'Giriş sayfasının adresi'],
            self::SifreSifirlama => $ortak + [
                'sifirlama_adresi' => 'Şifre sıfırlama bağlantısı',
                'gecerlilik_dakika' => 'Bağlantının geçerlilik süresi (dakika)',
            ],
            self::EpostaDogrulama => $ortak + ['dogrulama_adresi' => 'Doğrulama bağlantısı'],
            self::HesapAskiyaAlindi => $ortak + [
                'neden' => 'Yöneticinin yazdığı neden ("belirtilmedi" olabilir)',
                'destek_eposta' => 'Destek e-posta adresi',
            ],
            self::HesapAskidanCikarildi => $ortak + ['giris_adresi' => 'Giriş sayfasının adresi'],
            self::HesapSilindi => $ortak + ['destek_eposta' => 'Destek e-posta adresi'],
            self::AbonelikKullanici => $ortak + $abonelik + [
                'tutar' => 'Ödenen tutar ("—" olabilir)',
                'panel_adresi' => 'Uygulamanın panel adresi',
            ],
            self::AbonelikBitiyor => $ortak + $abonelik + [
                'kalan_gun' => 'Bitişe kalan gün',
                'destek_eposta' => 'Destek e-posta adresi',
            ],
            self::AbonelikBitti => $ortak + $abonelik + ['destek_eposta' => 'Destek e-posta adresi'],
            self::AbonelikIptal => $ortak + $abonelik + ['destek_eposta' => 'Destek e-posta adresi'],
            self::KayitYonetici => $ortak + [
                'unvan' => 'Kullanıcının unvanı',
                'universite' => 'Kullanıcının üniversitesi',
                'kayit_tarihi' => 'Kayıt tarihi ve saati',
                'kullanici_adresi' => 'Kullanıcının yönetim panelindeki sayfası',
            ],
            self::AbonelikYonetici => $ortak + $abonelik + [
                'tutar' => 'Ödenen tutar ("—" olabilir)',
                'ekleyen' => 'Aboneliği tanımlayan yönetici',
                'kullanici_adresi' => 'Kullanıcının yönetim panelindeki sayfası',
            ],
            self::AbonelikBitiyorYonetici => [
                'uygulama' => 'Uygulamanın adı',
                'adet' => 'Bitecek abonelik sayısı',
                'liste' => 'Kullanıcı, plan ve bitiş tarihlerinin madde listesi',
                'panel_adresi' => 'Yönetim panelindeki abonelikler sayfası',
            ],
        };
    }

    /**
     * Önizleme ve test gönderimi için örnek değerler.
     *
     * @return array<string, string>
     */
    public function ornekDegerler(): array
    {
        $ornek = [
            'ad' => 'Ayşe Yılmaz',
            'eposta' => 'ayse@ornek.edu.tr',
            'uygulama' => (string) config('app.name'),
            'giris_adresi' => route('login'),
            'sifirlama_adresi' => url('/reset-password/ornek-anahtar'),
            'gecerlilik_dakika' => '60',
            'dogrulama_adresi' => url('/email/verify/ornek'),
            'neden' => 'Ödeme itirazı',
            'destek_eposta' => (string) config('mail.from.address'),
            'unvan' => 'Dr. Öğr. Üyesi',
            'universite' => 'Mersin Üniversitesi',
            'kayit_tarihi' => now()->translatedFormat('j F Y H:i'),
            'kullanici_adresi' => url('/admin/kullanicilar/1'),
            'plan' => Plan::Akademisyen->etiket(),
            'baslangic' => now()->translatedFormat('j F Y'),
            'bitis' => now()->addMonth()->subDay()->translatedFormat('j F Y'),
            'tutar' => '299,00 ₺',
            'kalan_gun' => (string) self::HATIRLATMA_GUN,
            'panel_adresi' => $this === self::AbonelikBitiyorYonetici ? url('/admin/abonelikler') : route('dashboard'),
            'ekleyen' => 'Panel Yöneticisi',
            'adet' => '2',
            'liste' => "- Ayşe Yılmaz (ayse@ornek.edu.tr) · Akademisyen · 15 Ekim 2026\n- Mehmet Demir (mehmet@ornek.edu.tr) · Kurumsal · 15 Ekim 2026",
        ];

        return array_intersect_key($ornek, $this->degiskenler());
    }

    public function varsayilanKonu(): string
    {
        return match ($this) {
            self::KayitKullanici => '{uygulama}\'a hoş geldiniz',
            self::SifreSifirlama => '{uygulama} şifre sıfırlama',
            self::EpostaDogrulama => 'E-posta adresinizi doğrulayın',
            self::HesapAskiyaAlindi => '{uygulama} hesabınız askıya alındı',
            self::HesapAskidanCikarildi => '{uygulama} hesabınız yeniden açıldı',
            self::HesapSilindi => '{uygulama} hesabınız silindi',
            self::AbonelikKullanici => '{plan} aboneliğiniz başladı',
            self::AbonelikBitiyor => '{plan} aboneliğiniz {kalan_gun} gün sonra bitiyor',
            self::AbonelikBitti => '{plan} aboneliğiniz sona erdi',
            self::AbonelikIptal => '{plan} aboneliğiniz iptal edildi',
            self::KayitYonetici => 'Yeni kayıt: {ad}',
            self::AbonelikYonetici => 'Yeni abonelik: {ad} · {plan}',
            self::AbonelikBitiyorYonetici => '{adet} abonelik yakında bitiyor',
        };
    }

    public function varsayilanGovde(): string
    {
        return match ($this) {
            self::KayitKullanici => <<<'MD'
                Merhaba {ad},

                {uygulama}'a hoş geldiniz! Hesabınız oluşturuldu.

                Faaliyetlerinizi ekleyerek başlayabilir, hedeflediğiniz üniversitelerin yönergelerine göre nerede olduğunuzu görebilirsiniz.

                [Giriş yapın]({giris_adresi})

                İyi çalışmalar,
                {uygulama} ekibi
                MD,
            self::SifreSifirlama => <<<'MD'
                Merhaba {ad},

                Hesabınız için şifre sıfırlama isteği aldık. Yeni şifrenizi belirlemek için aşağıdaki bağlantıya tıklayın:

                [Şifremi sıfırla]({sifirlama_adresi})

                Bağlantı {gecerlilik_dakika} dakika geçerlidir. Bu isteği siz yapmadıysanız bu e-postayı yok sayabilirsiniz; şifreniz değişmez.

                {uygulama} ekibi
                MD,
            self::EpostaDogrulama => <<<'MD'
                Merhaba {ad},

                E-posta adresinizi doğrulamak için aşağıdaki bağlantıya tıklayın:

                [E-postamı doğrula]({dogrulama_adresi})

                Bu isteği siz yapmadıysanız bu e-postayı yok sayabilirsiniz.

                {uygulama} ekibi
                MD,
            self::HesapAskiyaAlindi => <<<'MD'
                Merhaba {ad},

                {uygulama} hesabınız askıya alındı. Askı süresince giriş yapamazsınız; verileriniz silinmedi.

                **Neden:** {neden}

                Bir yanlışlık olduğunu düşünüyorsanız {destek_eposta} adresine yazabilirsiniz.

                {uygulama} ekibi
                MD,
            self::HesapAskidanCikarildi => <<<'MD'
                Merhaba {ad},

                {uygulama} hesabınız yeniden açıldı. Kaldığınız yerden devam edebilirsiniz.

                [Giriş yapın]({giris_adresi})

                {uygulama} ekibi
                MD,
            self::HesapSilindi => <<<'MD'
                Merhaba {ad},

                {uygulama} hesabınız ({eposta}) ve hesabınıza ait veriler (faaliyetler, CV, raporlar, fotoğraflar) kalıcı olarak silindi.

                Bu işlemden haberiniz yoksa {destek_eposta} adresine yazın.

                {uygulama} ekibi
                MD,
            self::AbonelikKullanici => <<<'MD'
                Merhaba {ad},

                **{plan}** aboneliğiniz tanımlandı.

                - **Başlangıç:** {baslangic}
                - **Bitiş:** {bitis}
                - **Tutar:** {tutar}

                [Panele gidin]({panel_adresi})

                Teşekkür ederiz,
                {uygulama} ekibi
                MD,
            self::AbonelikBitiyor => <<<'MD'
                Merhaba {ad},

                **{plan}** aboneliğiniz **{bitis}** tarihinde, yani {kalan_gun} gün sonra bitiyor.

                Kesintisiz devam etmek için aboneliğinizi yenilemeniz yeterli. Yenileme için {destek_eposta} adresine yazabilirsiniz.

                {uygulama} ekibi
                MD,
            self::AbonelikBitti => <<<'MD'
                Merhaba {ad},

                **{plan}** aboneliğiniz {bitis} tarihinde sona erdi; hesabınız ücretsiz plana geçti. Verileriniz yerinde duruyor.

                Aboneliğinizi yenilemek için {destek_eposta} adresine yazabilirsiniz.

                {uygulama} ekibi
                MD,
            self::AbonelikIptal => <<<'MD'
                Merhaba {ad},

                **{plan}** aboneliğiniz ({baslangic} – {bitis}) iptal edildi.

                Bir yanlışlık olduğunu düşünüyorsanız {destek_eposta} adresine yazabilirsiniz.

                {uygulama} ekibi
                MD,
            self::KayitYonetici => <<<'MD'
                Yeni bir kullanıcı kayıt oldu.

                - **Ad:** {ad}
                - **E-posta:** {eposta}
                - **Unvan:** {unvan}
                - **Üniversite:** {universite}
                - **Kayıt:** {kayit_tarihi}

                [Kullanıcıyı panelde aç]({kullanici_adresi})
                MD,
            self::AbonelikYonetici => <<<'MD'
                Bir kullanıcıya abonelik tanımlandı.

                - **Kullanıcı:** {ad} ({eposta})
                - **Plan:** {plan}
                - **Dönem:** {baslangic} – {bitis}
                - **Tutar:** {tutar}
                - **Tanımlayan:** {ekleyen}

                [Kullanıcıyı panelde aç]({kullanici_adresi})
                MD,
            self::AbonelikBitiyorYonetici => <<<'MD'
                Bugün {adet} kullanıcıya abonelik bitiş hatırlatması gönderildi:

                {liste}

                [Abonelikleri panelde aç]({panel_adresi})
                MD,
        };
    }
}
