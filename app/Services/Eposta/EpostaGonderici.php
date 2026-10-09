<?php

namespace App\Services\Eposta;

use App\Enums\EpostaTuru;
use App\Mail\SablonluEposta;
use App\Models\Abonelik;
use App\Models\AbonelikTalebi;
use App\Models\EpostaSablonu;
use App\Models\Paket;
use App\Models\User;
use App\Services\Abonelik\PaketKatalogu;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

/**
 * Şablonlu e-postaları üretir ve gönderir.
 *
 * Şablon BLADE DEĞİL: panelden düzenlenen metin Blade olarak derlenseydi,
 * şablonu düzenleyen kişi sunucuda PHP çalıştırabilirdi. Yalnızca {degisken}
 * yer tutucuları değiştiriliyor, sonra Markdown HTML'e çevriliyor.
 *
 * Güvenlik:
 *   - yerleştirilen değerler HTML olarak kaçışlanıyor (kullanıcı adı
 *     "<img onerror=...>" olabilir),
 *   - Markdown'daki ham HTML kaçışlanıyor, güvensiz bağlantılar (javascript:)
 *     atılıyor.
 */
class EpostaGonderici
{
    /**
     * Türün geçerli şablonu: panelde düzenlenmişse o, yoksa varsayılan.
     *
     * @return array{konu: string, govde: string, aktif: bool, ozel: bool}
     */
    public function sablon(EpostaTuru $tur): array
    {
        $kayit = EpostaSablonu::query()->where('tur', $tur->value)->first();

        return [
            'konu' => $kayit !== null ? $kayit->konu : $tur->varsayilanKonu(),
            'govde' => $kayit !== null ? $kayit->govde : $tur->varsayilanGovde(),
            // Kapatılamayan şablon (şifre sıfırlama) her durumda gider.
            'aktif' => $kayit === null || $kayit->aktif || ! $tur->kapatilabilir(),
            'ozel' => $kayit !== null,
        ];
    }

    /**
     * Konu ve gövdeyi değerlerle doldurur, mail nesnesini üretir.
     *
     * @param  array<string, string>  $degerler
     */
    public function olustur(string $konu, string $govde, array $degerler): SablonluEposta
    {
        $markdown = $this->yerlestir($govde, $degerler, html: true);

        return new SablonluEposta(
            konu: $this->yerlestir($konu, $degerler, html: false),
            govdeHtml: (string) Str::markdown($markdown, ['html_input' => 'escape', 'allow_unsafe_links' => false]),
            duzMetin: $this->yerlestir($govde, $degerler, html: false),
        );
    }

    /**
     * Yeni kayıt: kullanıcıya hoş geldin, yöneticilere bildirim.
     */
    public function kayit(User $user): void
    {
        $ortak = $this->kullaniciDegerleri($user);

        $this->gonder(EpostaTuru::KayitKullanici, [$user->email], $ortak + [
            'giris_adresi' => route('login'),
        ]);

        $this->gonder(EpostaTuru::KayitYonetici, $this->yoneticiAdresleri(), $ortak + [
            'unvan' => $user->unvan ?? '—',
            'universite' => $user->universite ?? '—',
            'kayit_tarihi' => ($user->created_at ?? now())->translatedFormat('j F Y H:i'),
            'kullanici_adresi' => route('admin.kullanici', $user),
        ]);
    }

    /**
     * Abonelik tanımlandı: kullanıcıya bilgi, yöneticilere bildirim.
     */
    public function abonelik(Abonelik $abonelik): void
    {
        $user = $abonelik->user;
        $degerler = $this->abonelikDegerleri($abonelik) + [
            'tutar' => $abonelik->tutarMetni() ?? '—',
        ];

        $this->gonder(EpostaTuru::AbonelikKullanici, [$user->email], $degerler + [
            'panel_adresi' => route('dashboard'),
        ]);

        $this->gonder(EpostaTuru::AbonelikYonetici, $this->yoneticiAdresleri(), $degerler + [
            'ekleyen' => $abonelik->olusturan !== null ? $abonelik->olusturan->name : 'Sistem',
            'kullanici_adresi' => route('admin.kullanici', $user),
        ]);
    }

    /**
     * Ücretli paket talebi: kullanıcıya "alındı", yöneticilere bildirim.
     */
    public function talep(AbonelikTalebi $talep): void
    {
        $user = $talep->user;
        $degerler = $this->kullaniciDegerleri($user) + [
            'plan' => $talep->plan->etiket(),
            'donem' => $talep->donemEtiketi(),
            'tutar' => Paket::fiyatMetni(app(PaketKatalogu::class)->onerilenTutar($talep->plan, $talep->ay())),
        ];

        $this->gonder(EpostaTuru::TalepKullanici, [$user->email], $degerler + [
            'destek_eposta' => $this->destekAdresi(),
        ]);

        $this->gonder(EpostaTuru::TalepYonetici, $this->yoneticiAdresleri(), $degerler + [
            'unvan' => $user->unvan ?? '—',
            'universite' => $user->universite ?? '—',
            'talepler_adresi' => route('admin.abonelikler'),
        ]);
    }

    /**
     * Şifre sıfırlama maili. Laravel'in ResetPassword bildirimi bunu döndürüyor
     * (AppServiceProvider): bildirim ve kuralları (bekleme süresi, anahtar)
     * Laravel'de kalıyor, yalnızca metin bizim şablonumuzdan geliyor.
     */
    public function sifreSifirlama(User $user, string $adres): SablonluEposta
    {
        $sablon = $this->sablon(EpostaTuru::SifreSifirlama);

        return $this->olustur($sablon['konu'], $sablon['govde'], $this->kullaniciDegerleri($user) + [
            'sifirlama_adresi' => $adres,
            'gecerlilik_dakika' => (string) config('auth.passwords.users.expire', 60),
        ])->to($user->email);
    }

    /**
     * E-posta doğrulama maili; VerifyEmail bildirimi döndürüyor.
     */
    public function epostaDogrulama(User $user, string $adres): SablonluEposta
    {
        $sablon = $this->sablon(EpostaTuru::EpostaDogrulama);

        return $this->olustur($sablon['konu'], $sablon['govde'], $this->kullaniciDegerleri($user) + [
            'dogrulama_adresi' => $adres,
        ])->to($user->email);
    }

    public function askiyaAlindi(User $user, ?string $neden): void
    {
        $this->gonder(EpostaTuru::HesapAskiyaAlindi, [$user->email], $this->kullaniciDegerleri($user) + [
            'neden' => $neden ?: 'belirtilmedi',
            'destek_eposta' => $this->destekAdresi(),
        ]);
    }

    public function askidanCikarildi(User $user): void
    {
        $this->gonder(EpostaTuru::HesapAskidanCikarildi, [$user->email], $this->kullaniciDegerleri($user) + [
            'giris_adresi' => route('login'),
        ]);
    }

    /**
     * Hesap silindi teyidi. Ad ve e-posta düz metin olarak alınıyor: kullanıcı
     * satırı bu çağrıdan sonra silinecek, mail yine de gitmeli.
     */
    public function hesapSilindi(string $ad, string $eposta): void
    {
        $this->gonder(EpostaTuru::HesapSilindi, [$eposta], [
            'ad' => $ad,
            'eposta' => $eposta,
            'uygulama' => (string) config('app.name'),
            'destek_eposta' => $this->destekAdresi(),
        ]);
    }

    public function abonelikIptal(Abonelik $abonelik): void
    {
        $this->gonder(EpostaTuru::AbonelikIptal, [$abonelik->user->email], $this->abonelikDegerleri($abonelik) + [
            'destek_eposta' => $this->destekAdresi(),
        ]);
    }

    public function abonelikBitiyor(Abonelik $abonelik): void
    {
        $this->gonder(EpostaTuru::AbonelikBitiyor, [$abonelik->user->email], $this->abonelikDegerleri($abonelik) + [
            'kalan_gun' => (string) ($abonelik->kalanGun() ?? 0),
            'destek_eposta' => $this->destekAdresi(),
        ]);
    }

    public function abonelikBitti(Abonelik $abonelik): void
    {
        $this->gonder(EpostaTuru::AbonelikBitti, [$abonelik->user->email], $this->abonelikDegerleri($abonelik) + [
            'destek_eposta' => $this->destekAdresi(),
        ]);
    }

    /**
     * Yöneticilere o gün hatırlatma giden aboneliklerin listesi.
     *
     * @param  iterable<Abonelik>  $abonelikler
     */
    public function bitiyorOzeti(iterable $abonelikler): void
    {
        $satirlar = [];

        foreach ($abonelikler as $abonelik) {
            $satirlar[] = sprintf('- %s (%s) · %s · %s',
                $abonelik->user->name,
                $abonelik->user->email,
                $abonelik->plan->etiket(),
                $abonelik->bitis?->translatedFormat('j F Y') ?? 'süresiz',
            );
        }

        if ($satirlar === []) {
            return;
        }

        $this->gonder(EpostaTuru::AbonelikBitiyorYonetici, $this->yoneticiAdresleri(), [
            'uygulama' => (string) config('app.name'),
            'adet' => (string) count($satirlar),
            'liste' => implode("\n", $satirlar),
            'panel_adresi' => route('admin.abonelikler', ['durum' => 'yaklasan']),
        ]);
    }

    /**
     * Şablonu örnek değerlerle tek bir adrese gönderir (panelde "test gönder").
     */
    public function test(EpostaTuru $tur, string $konu, string $govde, string $adres): void
    {
        Mail::to($adres)->queue($this->olustur('[Test] '.$konu, $govde, $tur->ornekDegerler()));
    }

    /**
     * Şablonda kullanılmış ama bu türde tanımlı olmayan değişkenler —
     * panel yazım hatalarını ({adi} gibi) buradan uyarıyor.
     *
     * @return list<string>
     */
    public function bilinmeyenDegiskenler(EpostaTuru $tur, string $metin): array
    {
        preg_match_all('/\{([a-z_]+)\}/', $metin, $eslesmeler);

        return array_values(array_unique(array_diff($eslesmeler[1], array_keys($tur->degiskenler()))));
    }

    /**
     * @param  list<string>  $adresler
     * @param  array<string, string>  $degerler
     */
    private function gonder(EpostaTuru $tur, array $adresler, array $degerler): void
    {
        $sablon = $this->sablon($tur);

        if (! $sablon['aktif'] || $adresler === []) {
            return;
        }

        // Her alıcıya ayrı mail: yöneticiler birbirinin adresini görmesin.
        foreach ($adresler as $adres) {
            Mail::to($adres)->queue($this->olustur($sablon['konu'], $sablon['govde'], $degerler));
        }
    }

    /**
     * @return array<string, string>
     */
    private function kullaniciDegerleri(User $user): array
    {
        return [
            'ad' => $user->name,
            'eposta' => $user->email,
            'uygulama' => (string) config('app.name'),
        ];
    }

    /**
     * @return array<string, string>
     */
    private function abonelikDegerleri(Abonelik $abonelik): array
    {
        return $this->kullaniciDegerleri($abonelik->user) + [
            'plan' => $abonelik->plan->etiket(),
            'baslangic' => $abonelik->baslangic->translatedFormat('j F Y'),
            'bitis' => $abonelik->bitis?->translatedFormat('j F Y') ?? 'süresiz',
        ];
    }

    private function destekAdresi(): string
    {
        return (string) config('mail.from.address');
    }

    /**
     * Bildirim alacak yöneticiler: askıda olmayan süper adminler.
     *
     * @return list<string>
     */
    private function yoneticiAdresleri(): array
    {
        return array_values(User::query()
            ->where('super_admin', true)
            ->whereNull('askiya_alindi_at')
            ->get()
            ->map(fn (User $user): string => $user->email)
            ->all());
    }

    /**
     * {degisken} yer tutucularını doldurur. Tanımsız olanlar olduğu gibi kalır
     * (panel onları uyarı olarak gösteriyor).
     *
     * @param  array<string, string>  $degerler
     */
    private function yerlestir(string $metin, array $degerler, bool $html): string
    {
        return (string) preg_replace_callback('/\{([a-z_]+)\}/', function (array $eslesme) use ($degerler, $html): string {
            if (! array_key_exists($eslesme[1], $degerler)) {
                return $eslesme[0];
            }

            return $html ? e($degerler[$eslesme[1]]) : $degerler[$eslesme[1]];
        }, $metin);
    }
}
