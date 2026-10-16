<?php

namespace App\Livewire;

use App\Enums\Kategori;
use App\Models\Faaliyet;
use App\Services\Scoring\Sart\MaddeKatalogu;
use App\Services\Yayin\AdEslestirici;
use App\Services\Yayin\AramaException;
use App\Services\Yayin\CrossrefArama;
use App\Services\Yayin\DergiParkArsivi;
use App\Services\Yayin\KaynakOnerici;
use App\Services\Yayin\MukerrerDenetimi;
use App\Services\Yayin\ProfilOkuyuculari;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.focused')]
#[Title('Faaliyet Ekle')]
class FaaliyetEkle extends Component
{
    /** Bir "tara"/"devam" turunda açılacak en çok sayı adedi. */
    private const ARSIV_OBEK = 12;

    public ?Faaliyet $faaliyet = null;

    public string $sekme = 'manuel';

    // Yayın arama sekmesi
    public string $aramaAdi = '';

    public string $aramaOrcid = '';

    /**
     * Arama sonuçları. Livewire durumunda taşındığı için dizi; her satıra
     * "bu zaten ekli mi" bilgisi eklenmiş hâli.
     *
     * @var list<array<string, mixed>>
     */
    public array $bulunanlar = [];

    /** @var list<string> işaretlenen DOI'ler */
    public array $secilenler = [];

    public bool $arandi = false;

    public string $aramaHatasi = '';

    // DOI'si olmayan eski yayınlar: dergi arşivi taraması
    public string $arsivDergi = '';

    public string $arsivYilBas = '';

    public string $arsivYilSon = '';

    /** @var list<array<string, mixed>> */
    public array $arsivBulunanlar = [];

    /** @var list<string> işaretlenen "kısaltma:makaleId" anahtarları */
    public array $arsivSecilenler = [];

    /** @var list<string> henüz açılmamış sayı kimlikleri (Devam et için) */
    public array $arsivKalan = [];

    public string $arsivKisaltma = '';

    public string $arsivAdi = '';

    public int $arsivTaranan = 0;

    public bool $arsivArandi = false;

    public string $arsivHatasi = '';

    // Kurumsal profil (AVESİS ya da Mersin'in APBS'i).
    //
    // Alan adları `avesis*` kalıyor: kullanıcı sütunu (`users.avesis_id`)
    // ve bu ekranın sekmesi o adla doğdu, iki sistem de aynı yoldan
    // geçiyor. Hangi sistemin okunduğu $avesisSistemAdi'nda.
    public string $avesisAdres = '';

    /** Okunan sistemin adayın gördüğü adı ('AVESİS', 'APBS'). */
    public string $avesisSistemAdi = 'AVESİS';

    /** @var list<array<string, mixed>> */
    public array $avesisBulunanlar = [];

    /** @var list<string> işaretlenen AVESİS kimlikleri */
    public array $avesisSecilenler = [];

    public bool $avesisArandi = false;

    public string $avesisHatasi = '';

    /** Sözlükte karşılığı olmadığı için listeye alınmayan kayıt adedi. */
    public int $avesisAtlanan = 0;

    /** Sunucu yanıt vermediği için hiç okunamayan bölüm adedi. */
    public int $avesisEksikBolum = 0;

    /**
     * Dergi indeksi önerisi (yalnız düzenleme ekranında, kaynak boşken).
     *
     * @var array<string, mixed>|null
     */
    public ?array $oneri = null;

    // Form alanları
    public string $kategori = 'makale';

    public string $baslik = '';

    /** @var list<string> */
    public array $yazarlar = [''];

    /** Adayın faaliyetteki rolü; geçerli değerler kategoriye göre değişir. */
    public string $rol = '';

    /**
     * Makalenin yayın türü. Yönergeler aynı dergideki özgün makale ile
     * derlemeyi farklı puanlıyor (Ege Q1: 75 ↔ 60).
     */
    public string $yayinTuru = 'ozgun_makale';

    public string $donem = '';

    public string $kaynak = '';

    /**
     * Faaliyetin gerçekleşme tarihi (Y-m-d).
     *
     * Yıl değil tam tarih alınıyor: dönem koşulları profildeki doktora/doçentlik/
     * son atama tarihleriyle kıyaslanıyor ve yalnızca yıl bilinirse dönüm yılına
     * denk gelen faaliyetler karara bağlanamıyor.
     */
    public string $tarih = '';

    public string $doi = '';

    public string $aciklama = '';

    /**
     * Onay durumu. Yalnız beklemede olmayan kayıtlar puanlamaya, analize ve
     * CV'ye giriyor; içe aktarılanlar beklemede iniyor ve aday buradan onaylıyor.
     */
    public string $durum = 'onaylandi';

    public function mount(?Faaliyet $faaliyet = null): void
    {
        if ($faaliyet !== null && $faaliyet->exists) {
            abort_unless($faaliyet->user_id === Auth::id(), 404);

            $this->faaliyet = $faaliyet;
            $this->kategori = $faaliyet->kategori->value;
            $this->baslik = $faaliyet->baslik;
            $this->yazarlar = $faaliyet->yazarlar
                ? array_map('trim', explode(',', $faaliyet->yazarlar))
                : [''];
            $this->rol = $faaliyet->rol ?? '';
            $this->yayinTuru = $faaliyet->yayin_turu ?? 'ozgun_makale';
            $this->donem = $faaliyet->donem ?? '';
            $this->kaynak = $faaliyet->kaynak ?? '';
            $this->tarih = $faaliyet->tarih?->format('Y-m-d') ?? '';
            $this->doi = (string) ($faaliyet->meta['doi'] ?? '');
            $this->aciklama = (string) ($faaliyet->meta['aciklama'] ?? '');
            $this->durum = $faaliyet->durum;

            return;
        }

        // Arama sekmesi profilden doluyor: aday adını ve ORCID'ini zaten bir
        // kez girdi, ikinci kez yazdırmak hem yorucu hem hata kaynağı.
        $this->aramaAdi = (string) Auth::user()->name;
        $this->aramaOrcid = (string) (Auth::user()->orcid ?? '');
        $this->avesisAdres = (string) (Auth::user()->avesis_id ?? '');

        // Dashboard hızlı-ekle bağlantısından gelen kategori ön-seçimi.
        $kategori = request('kategori');
        if (is_string($kategori) && Kategori::tryFrom($kategori) !== null) {
            $this->kategori = $kategori;
        }
    }

    public function updatedKategori(): void
    {
        // Kaynak ve rol sözlüğü kategoriye göre değişiyor.
        $this->kaynak = '';
        $this->rol = '';
        $this->yayinTuru = 'ozgun_makale';

        // Girilmiş yazarlar kategori değişince duruyor; tek yazarsa yeni
        // kategoride de rol kendiliğinden "Tek yazar".
        $this->roluDogrula();

        // Tez ilişkisi yalnızca yayın türlerinde soruluyor; kategori değişince
        // eski değer görünmez biçimde kaydedilmesin.
        if (! $this->tezIliskisiSorulur()) {
            $this->donem = '';
        }
    }

    /**
     * Formda "Tez İlişkisi" alanı gösterilsin mi?
     */
    public function tezIliskisiSorulur(): bool
    {
        $kategori = Kategori::tryFrom($this->kategori);

        return $kategori?->tezdenUretilebilir() ?? false;
    }

    /**
     * Seçili kategoride geçerli roller (yayında yazarlık, projede görev...).
     *
     * Yazarlık rollerinde SIRA seçenekleri girilen yazar sayısıyla sınırlanır:
     * iki yazarlı bir yayında "4. yazar" seçilebilmesi tutarsız veri üretir ve
     * bazı yönergelerde (Kocaeli) doğrudan yanlış puana yol açar. Yazar listesi
     * boşken kısıtlama yapılamaz, hepsi gösterilir.
     *
     * @return array<string, string>
     */
    public function rolSecenekleri(): array
    {
        $roller = Kategori::from($this->kategori)->roller();

        if (! isset($roller['tek'])) {
            return $roller;
        }

        $sayi = $this->yazarSayisi();

        if ($sayi === 0) {
            return $roller;
        }

        return array_filter(
            $roller,
            fn (string $kod) => $this->rolYazarSayisinaUyar($kod, $sayi),
            ARRAY_FILTER_USE_KEY,
        );
    }

    /**
     * Girilen boş olmayan yazar adedi.
     */
    private function yazarSayisi(): int
    {
        return count(array_filter(array_map('trim', $this->yazarlar), fn (string $a) => $a !== ''));
    }

    /**
     * Rol kodu bu yazar sayısında seçilebilir mi?
     */
    private function rolYazarSayisinaUyar(string $kod, int $sayi): bool
    {
        if ($kod === 'tek') {
            return $sayi === 1;
        }

        // Tek yazarlı eserde sıra ya da ortaklık rolü anlamsız.
        if ($sayi === 1) {
            return false;
        }

        if (preg_match('/^yazar_(\d+)$/', $kod, $eslesme) === 1) {
            $sira = (int) $eslesme[1];

            // '6. yazar ve sonrası' altı ve üzeri her yazar sayısında geçerli.
            return $sira === 6 ? $sayi >= 6 : $sira <= $sayi;
        }

        return true;
    }

    /**
     * Yazar listesi değişince seçili rol geçersiz kalabilir (üç yazar silinip
     * "4. yazar" seçili kalması gibi); o durumda rol temizlenir.
     */
    public function updatedYazarlar(): void
    {
        $this->roluDogrula();
    }

    /**
     * Rolü yazar listesiyle uyumlu tutar. Tek yazar girilmişse geçerli tek
     * seçenek "Tek yazar"; seçtirmek yerine kendisi seçiliyor (kaydederken de
     * zaten öyle yazılıyordu, ekranda başka bir rol görünmesi yanıltıyordu).
     */
    private function roluDogrula(): void
    {
        $secenekler = $this->rolSecenekleri();

        if (array_keys($secenekler) === ['tek']) {
            $this->rol = 'tek';

            return;
        }

        if ($this->rol !== '' && ! array_key_exists($this->rol, $secenekler)) {
            $this->rol = '';
        }
    }

    /**
     * Seçili kategoride geçerli yayın türleri. Boşsa alan gösterilmez —
     * yalnızca makale ve tezden üretilmiş yayın türe göre puanlanıyor.
     *
     * @return array<string, string>
     */
    public function yayinTuruSecenekleri(): array
    {
        return Kategori::from($this->kategori)->yayinTurleri();
    }

    public function yazarEkle(): void
    {
        $this->yazarlar[] = '';
    }

    public function yazarSil(int $index): void
    {
        unset($this->yazarlar[$index]);
        $this->yazarlar = array_values($this->yazarlar);

        if ($this->yazarlar === []) {
            $this->yazarlar = [''];
        }

        // Livewire'ın `updated` kancası metotla yapılan değişikliği görmüyor;
        // yazar silindiğinde rol geçersizleşebildiği için elle doğrulanıyor.
        $this->roluDogrula();
    }

    /**
     * Kullanıcının KENDİ üniversitesinin puan cetveli. Yönergesi girilmemişse
     * null — o zaman puan önizlemesi gösterilmez, tahmini puan uydurulmaz.
     */
    private function katalog(): ?MaddeKatalogu
    {
        return Auth::user()->puanCetveli();
    }

    /**
     * Seçili kategorinin alt türleri.
     *
     * Kaynak, kullanıcının seçtiği yönergeden DEĞİL kategorinin kendi
     * sözlüğünden gelir: form hangi cetvelin yüklü olduğuna bağlı olmamalı.
     * Cetvelde karşılığı olmayan bir alt tür yalnızca 0 puan alır.
     *
     * @return list<string>
     */
    public function kaynakSecenekleri(): array
    {
        return Kategori::from($this->kategori)->adayKaynaklari();
    }

    /**
     * Girilen bilgilere göre canlı puan önizlemesi — kullanıcının kendi
     * üniversitesinin cetveline göre. Cetvel yoksa null döner ve arayüz
     * puan göstermez (uydurma puan üretmemek için).
     */
    public function tahminiPuan(): ?int
    {
        $katalog = $this->katalog();

        if ($katalog === null) {
            return null;
        }

        $gecici = new Faaliyet([
            'kategori' => $this->kategori,
            'kaynak' => $this->kaynak ?: null,
            'rol' => $this->rol ?: null,
            'yayin_turu' => $this->yayinTuru ?: null,
        ]);

        return $katalog->puan($gecici, $katalog->coz(['*']));
    }

    /**
     * Crossref'te adayın yayınlarını arar.
     *
     * Hata mesajı ekranda kalıyor, istisna atılmıyor: dış servisin erişilemez
     * olması adayın formunu çökertmemeli.
     */
    public function yayinAra(): void
    {
        $this->validate([
            'aramaAdi' => ['nullable', 'string', 'max:120', 'required_without:aramaOrcid'],
            'aramaOrcid' => ['nullable', 'string', 'max:64'],
        ], attributes: [
            'aramaAdi' => 'ad soyad',
            'aramaOrcid' => 'ORCID',
        ]);

        $this->aramaHatasi = '';
        $this->secilenler = [];
        $this->arandi = true;

        try {
            $yayinlar = app(CrossrefArama::class)->ara($this->aramaAdi, $this->aramaOrcid ?: null);
        } catch (AramaException $hata) {
            $this->bulunanlar = [];
            $this->aramaHatasi = $hata->getMessage();

            return;
        }

        $harita = $this->mukerrerHaritasi();

        $this->bulunanlar = array_map(function (array $yayin) use ($harita): array {
            $meta = array_filter([
                'doi' => $yayin['doi'],
                'dergi' => $yayin['dergi'] ?: null,
                'kaynak_sistem' => 'crossref',
            ]);

            return [...$yayin, 'meta' => $meta, 'ekli_sebep' => $this->mukerrer($harita, $yayin['kategori'], $yayin['baslik'], $meta)];
        }, $yayinlar);
    }

    /**
     * Henüz eklenmemiş bütün sonuçları işaretler.
     */
    public function tumunuSec(): void
    {
        $this->secilenler = array_values(array_map(
            fn (array $yayin): string => $yayin['doi'],
            array_filter($this->bulunanlar, fn (array $yayin): bool => $yayin['ekli_sebep'] === null),
        ));
    }

    /**
     * Seçilen yayınları faaliyet olarak ekler.
     *
     * DURUM "beklemede", KAYNAK boş: künyede dergi indeksi yok (Crossref onu
     * bilmiyor) ve indeks puanı belirleyen alan. Beklemedeki kayıt
     * {@see YonergeAnalizi::faaliyetler()} tarafından sayılmıyor, yani aday
     * kademeyi seçene kadar hiçbir yönergeye eksik veriyle girmiyor.
     */
    public function yayinlariEkle(): void
    {
        $secili = array_values(array_filter(
            $this->bulunanlar,
            fn (array $yayin): bool => $yayin['ekli_sebep'] === null && in_array($yayin['doi'], $this->secilenler, true),
        ));

        if ($secili === []) {
            Flux::toast(variant: 'warning', text: 'Eklenecek yayın seçmediniz.');

            return;
        }

        $eklenen = $this->ekle($secili, fn (array $yayin, Kategori $kategori): array => [
            'yazarlar' => $yayin['yazarlar'] ? implode(', ', $yayin['yazarlar']) : null,
            'rol' => $this->rolSiradan($kategori, count($yayin['yazarlar']), $yayin['sira']),
            // Özgün makale mi derleme mi: künyede yok, tahmin edilmiyor.
            'yayin_turu' => null,
            'tarih' => $yayin['tarih'],
            'kaynak' => null,
        ]);

        Flux::toast(
            variant: 'success',
            text: $eklenen.' yayın beklemede eklendi. Dergi indeksini seçip onaylayın.',
        );

        $this->redirectRoute('faaliyetler', navigate: true);
    }

    /**
     * Künyedeki yazar sırasından rol kodu.
     *
     * Sıra bulunamadıysa NULL dönüyor: aday adını künyedekinden farklı yazmış
     * olabilir ve yanlış sıra bazı yönergelerde doğrudan yanlış puan demek.
     * Boş rol, onay ekranında {@see rolBelirle} ile en kapsayıcı değere düşer.
     */
    private function rolSiradan(Kategori $kategori, int $yazarSayisi, ?int $sira): ?string
    {
        $gecerli = $kategori->roller();

        if ($gecerli === []) {
            return null;
        }

        if ($yazarSayisi <= 1) {
            return isset($gecerli['tek']) ? 'tek' : null;
        }

        if ($sira === null) {
            return null;
        }

        $kod = match (true) {
            $sira === 1 => 'ilk',
            $sira >= 6 => 'yazar_6',
            default => "yazar_{$sira}",
        };

        return isset($gecerli[$kod]) ? $kod : null;
    }

    /**
     * Dergi arşivini adaya göre taramaya BAŞLAR.
     *
     * Crossref yalnız DOI'li yayınları görüyor; dergiler DOI'ye sonradan
     * geçtiği için adayın 2014–2019 öncesi yayınları orada yok. Burada
     * derginin kendi arşivi açılıyor.
     *
     * YALNIZ DERGİ MAKALESİ. DergiPark bir dergi platformu; kitap, bildiri
     * ve tez orada yok. Aday buraya yayınevi adı ("Akademisyen Yayınevi")
     * yazıp gelen hatayı sistem arızası sanabiliyor, bu yüzden hata
     * iletileri alanın ne beklediğini ve kitabın nereden girileceğini
     * açıkça söylüyor.
     */
    public function arsivTara(): void
    {
        $this->arsivHatasi = '';
        $this->arsivBulunanlar = [];
        $this->arsivSecilenler = [];
        $this->arsivKalan = [];
        $this->arsivTaranan = 0;
        $this->arsivArandi = true;

        $arsiv = app(DergiParkArsivi::class);
        $kisaltma = $arsiv->kisaltma($this->arsivDergi);

        if ($kisaltma === null) {
            $this->arsivHatasi = 'Buraya bir DERGİ adresi ya da kısaltması yazılır (örnek: dergipark.org.tr/tr/pub/politeknik). '
                .'Kitap, bildiri ve tezler DergiPark arşivinde yok — onları Manuel Ekle sekmesinden girebilirsiniz.';

            return;
        }

        $sayilar = $arsiv->sayilar($kisaltma);

        if ($sayilar === []) {
            $this->arsivHatasi = 'DergiPark\'ta “'.mb_substr($kisaltma, 0, 60).'” adında bir DERGİ yok. '
                .'Buraya makalenizin yayımlandığı derginin adresi yazılır; yayınevi adı, kitap adı ya da yazar adı değil. '
                .'Kitabınızı Manuel Ekle sekmesinden, kategori Kitap seçerek girebilirsiniz.';

            return;
        }

        $this->arsivKisaltma = $kisaltma;
        $this->arsivAdi = (string) ($arsiv->ad($kisaltma) ?? $kisaltma);

        $bas = $this->arsivYilBas === '' ? null : (int) $this->arsivYilBas;
        $son = $this->arsivYilSon === '' ? null : (int) $this->arsivYilSon;

        // Tarihsiz sayı (henüz yayımlanmamış) yıl süzgeci varken atlanıyor:
        // yılını bilmediğimiz bir sayıyı aralığa dâhil saymak aralığı yalan
        // yapar.
        $this->arsivKalan = array_values(array_map(
            fn (array $sayi): string => $sayi['id'],
            array_filter($sayilar, function (array $sayi) use ($bas, $son): bool {
                if ($bas === null && $son === null) {
                    return true;
                }

                return $sayi['yil'] !== null
                    && ($bas === null || $sayi['yil'] >= $bas)
                    && ($son === null || $sayi['yil'] <= $son);
            }),
        ));

        $this->arsivDevam();
    }

    /**
     * Sıradaki sayı öbeğini açar.
     *
     * Öbek öbek gidiliyor: 105 sayılık bir arşiv tek istekte 105 sayfa
     * indirmek demek — hem adayı bekletir hem DergiPark'a kabalık olur.
     */
    public function arsivDevam(): void
    {
        $arsiv = app(DergiParkArsivi::class);
        $adlar = app(AdEslestirici::class);
        $ad = (string) Auth::user()->name;

        $sayiTarihleri = collect($arsiv->sayilar($this->arsivKisaltma))->keyBy('id');
        $harita = $this->mukerrerHaritasi();

        $obek = array_splice($this->arsivKalan, 0, self::ARSIV_OBEK);

        foreach ($obek as $sayiId) {
            $this->arsivTaranan++;

            foreach ($arsiv->makaleler($this->arsivKisaltma, $sayiId) as $makale) {
                $esleme = $adlar->esles($makale['yazarlar'], $ad);

                if (! $esleme['yakin']) {
                    continue;
                }

                $anahtar = "{$this->arsivKisaltma}:{$makale['id']}";

                $meta = array_filter([
                    'dergi' => $this->arsivAdi ?: null,
                    'dergipark' => $this->arsivKisaltma,
                    'dergipark_makale' => $makale['id'],
                    'kaynak_sistem' => 'dergipark',
                ]);

                $this->arsivBulunanlar[] = [
                    'anahtar' => $anahtar,
                    'makale_id' => $makale['id'],
                    'baslik' => $makale['baslik'],
                    'yazarlar' => $makale['yazarlar'],
                    'sira' => $esleme['sira'],
                    'sayi' => (string) ($sayiTarihleri[$sayiId]['etiket'] ?? ''),
                    'tarih' => $sayiTarihleri[$sayiId]['tarih'] ?? null,
                    'yil' => $sayiTarihleri[$sayiId]['yil'] ?? null,
                    'meta' => $meta,
                    'ekli_sebep' => $this->mukerrer($harita, 'makale', $makale['baslik'], $meta),
                ];
            }
        }
    }

    /**
     * Arşivden seçilenleri faaliyet olarak ekler.
     *
     * Crossref'ten gelenlerle aynı kural: kaynak boş, durum beklemede.
     * Künyeye dergi kısaltması da yazılıyor; {@see KaynakOnerici} DOI
     * olmadan da derginin dizinlerini bulabilsin diye.
     */
    public function arsivdenEkle(): void
    {
        $secili = array_values(array_filter(
            $this->arsivBulunanlar,
            fn (array $yayin): bool => $yayin['ekli_sebep'] === null && in_array($yayin['anahtar'], $this->arsivSecilenler, true),
        ));

        if ($secili === []) {
            Flux::toast(variant: 'warning', text: 'Eklenecek yayın seçmediniz.');

            return;
        }

        $eklenen = $this->ekle($secili, fn (array $yayin, Kategori $kategori): array => [
            'yazarlar' => $yayin['yazarlar'] ? implode(', ', $yayin['yazarlar']) : null,
            'rol' => $this->rolSiradan($kategori, count($yayin['yazarlar']), $yayin['sira']),
            'yayin_turu' => null,
            'tarih' => $yayin['tarih'],
            'kaynak' => null,
        ], 'makale');

        Flux::toast(
            variant: 'success',
            text: $eklenen.' yayın beklemede eklendi. Dergi indeksini seçip onaylayın.',
        );

        $this->redirectRoute('faaliyetler', navigate: true);
    }

    /**
     * Kurumsal profildeki faaliyetleri getirir.
     *
     * HANGİ SİSTEM OLDUĞUNU ADRES SÖYLÜYOR: çoğu üniversitede AVESİS,
     * Mersin'de APBS. Aday sistemin adını bilmek zorunda değil, adresini
     * yapıştırıyor; {@see ProfilOkuyuculari} sunucu adından okuyucuyu
     * seçiyor.
     *
     * Adres profile kaydediliyor: aday bir daha yazmasın. `avesis_id`
     * sütunu zaten bu iş için duruyordu.
     */
    public function avesisGetir(): void
    {
        $this->avesisHatasi = '';
        $this->avesisBulunanlar = [];
        $this->avesisSecilenler = [];
        $this->avesisAtlanan = 0;
        $this->avesisEksikBolum = 0;
        $this->avesisArandi = true;

        $okuyucular = app(ProfilOkuyuculari::class);
        $cozum = $okuyucular->coz($this->avesisAdres);

        if ($cozum === null) {
            $this->avesisHatasi = 'Adresi tanıyamadım. Kurumsal profil adresinizi olduğu gibi yapıştırın, örnek: '
                .implode(' ya da ', $okuyucular->ornekAdresler());

            return;
        }

        $servis = $cozum['okuyucu'];
        $this->avesisSistemAdi = $servis->ad();

        try {
            $kayitlar = $servis->kayitlar($cozum['adres']);
        } catch (AramaException $hata) {
            // Sunucu yanıt vermedi. "Kayıt bulunamadı" demek adayı
            // profilinin boş olduğuna inandırırdı.
            $this->avesisHatasi = $hata->getMessage();

            return;
        }

        if ($kayitlar === []) {
            $this->avesisHatasi = 'Bu profilde okunabilir kayıt bulunamadı.';

            return;
        }

        $this->avesisEksikBolum = $servis->eksikBolum();

        $kullanici = Auth::user();

        if ($kullanici->avesis_id !== $this->avesisAdres) {
            $kullanici->forceFill(['avesis_id' => $this->avesisAdres])->save();
        }

        $harita = $this->mukerrerHaritasi();
        $gecerli = [];

        foreach ($kayitlar as $kayit) {
            $kategori = Kategori::tryFrom($kayit['kategori']);

            // Sözlükte karşılığı olmayan kayıt (personel sınavı jürisi,
            // akademik ünvan geçmişi…) listeye alınmıyor; sayısı ekranda
            // yazıyor ki aday "eksik geldi" sanmasın.
            if ($kayit['atlandi'] || $kategori === null) {
                $this->avesisAtlanan++;

                continue;
            }

            // Okunan kademe bu kategorinin sözlüğünde yoksa yazılmıyor:
            // cetvelde karşılığı olmayan bir etiket faaliyeti sessizce
            // puansız bırakır.
            $kaynak = $kayit['kaynak'] !== null && in_array($kayit['kaynak'], $kategori->adayKaynaklari(), true)
                ? $kayit['kaynak']
                : null;

            $meta = array_filter([
                // Kayıt izi sistemin kendi adıyla saklanıyor
                // ({@see MukerrerDenetimi::izler}): iki sistemin kimlik
                // uzayları ayrı.
                $servis->sistem().'_id' => $kayit['id'],
                'doi' => $kayit['doi'],
                'kunye' => $kayit['kunye'] ?: null,
                'kaynak_sistem' => $servis->sistem(),
            ]);

            $gecerli[] = [
                ...$kayit,
                'kaynak' => $kaynak,
                'meta' => $meta,
                'ekli_sebep' => $this->mukerrer($harita, $kayit['kategori'], $kayit['baslik'], $meta, $kayit['yil']),
            ];
        }

        $this->avesisBulunanlar = $gecerli;
    }

    public function avesisTumunuSec(): void
    {
        $this->avesisSecilenler = array_values(array_map(
            fn (array $kayit): string => $kayit['id'],
            array_filter($this->avesisBulunanlar, fn (array $kayit): bool => $kayit['ekli_sebep'] === null),
        ));
    }

    /**
     * Seçilen AVESİS kayıtlarını faaliyet olarak ekler.
     *
     * Diğer iki yoldan FARKI: kademe boş inmiyor. AVESİS yayının dergi
     * indeksini ("esci", "trdizin") ve projenin fon programını yazıyor;
     * sözlükte karşılığı olan kademe doğrudan doldurulur. Çeyrekli
     * kademeler (SCIE/SSCI, Scopus) yine boş kalıyor — çeyreklik burada da
     * yazmıyor ve uydurulmuyor.
     *
     * Durum yine "beklemede": okunan kademe adayın onayından geçmeli.
     */
    public function avesistenEkle(): void
    {
        $secili = array_values(array_filter(
            $this->avesisBulunanlar,
            fn (array $kayit): bool => $kayit['ekli_sebep'] === null && in_array($kayit['id'], $this->avesisSecilenler, true),
        ));

        if ($secili === []) {
            Flux::toast(variant: 'warning', text: 'Eklenecek kayıt seçmediniz.');

            return;
        }

        $eklenen = $this->ekle($secili, fn (array $kayit): array => [
            'yazarlar' => $kayit['yazarlar'] ?: null,
            // Rol yalnız künyede AÇIKÇA yazıyorsa iniyor: APBS projede
            // görevi ("Yürütücü") ayrı bir rozette veriyor, AVESİS hiç
            // vermiyor. Yazmadığı yerde uydurulmuyor.
            'rol' => $kayit['rol'] ?? null,
            'yayin_turu' => null,
            // AVESİS yalnız YIL veriyor. 1 Ocak, dönem koşullarında
            // ("doçentlikten sonra", "son beş yıl") en muhafazakâr tarih:
            // aynı yıl içinde kayıt lehe değil aleyhe düşer.
            'tarih' => $kayit['yil'] === null ? null : sprintf('%04d-01-01', $kayit['yil']),
            'kaynak' => $kayit['kaynak'],
        ]);

        Flux::toast(
            variant: 'success',
            text: $eklenen.' kayıt beklemede eklendi. Kademeleri kontrol edip onaylayın.',
        );

        $this->redirectRoute('faaliyetler', navigate: true);
    }

    /**
     * Adayın listesindeki kayıtların izleri — mükerrer denetimi için.
     *
     * @return array<string, string>
     */
    private function mukerrerHaritasi(): array
    {
        return app(MukerrerDenetimi::class)->harita(Auth::user());
    }

    /**
     * @param  array<string, string>  $harita
     * @param  array<string, mixed>  $meta
     */
    private function mukerrer(array $harita, string $kategori, string $baslik, array $meta, ?int $yil = null): ?string
    {
        return app(MukerrerDenetimi::class)->eslesme($harita, $kategori, $baslik, $meta, $yil);
    }

    /**
     * Seçilen kayıtları faaliyet olarak yazar; üç içe aktarma yolu da
     * buradan geçiyor.
     *
     * Harita HER KAYITTAN SONRA tazeleniyor: tek bir partinin içinde de
     * mükerrer olabiliyor (AVESİS'te aynı yayının hem düzgün hem künyesi
     * başlığa yapışmış hâli listelenebiliyor).
     *
     * @param  list<array<string, mixed>>  $secili
     * @param  callable(array<string, mixed>, Kategori): array<string, mixed>  $alanlar
     */
    private function ekle(array $secili, callable $alanlar, ?string $kategoriZorla = null): int
    {
        $denetim = app(MukerrerDenetimi::class);
        $kullanici = Auth::user();
        $harita = $denetim->harita($kullanici);
        $eklenenler = [];

        foreach ($secili as $kayit) {
            $kategori = Kategori::from($kategoriZorla ?? $kayit['kategori']);
            $baslik = mb_substr($kayit['baslik'], 0, 255);
            $meta = $kayit['meta'];

            $yil = $kayit['yil'] ?? null;

            if ($denetim->eslesme($harita, $kategori->value, $baslik, $meta, $yil) !== null) {
                continue;
            }

            $eklenenler[] = $kullanici->faaliyetler()->create([
                'kategori' => $kategori->value,
                'tur' => $kategori->label(),
                'baslik' => $baslik,
                'durum' => 'beklemede',
                'meta' => $meta,
                ...$alanlar($kayit, $kategori),
            ])->id;

            // Harita yeniden sorgulanmıyor, yazılan kaydın izleri üstüne
            // ekleniyor: 400 kayıtlık bir partide her ekleme için listenin
            // tamamını okumak boşuna.
            $harita = [...$harita, ...$denetim->izler($kategori->value, $baslik, $meta, $yil)];
        }

        session()->flash(Faaliyetler::VURGULANAN, $eklenenler);

        return count($eklenenler);
    }

    /**
     * Derginin indeks bilgisini getirir.
     *
     * `wire:init` ile çağrılıyor: form önce çiziliyor, dış servis sonra
     * yoklanıyor. Aksi hâlde DergiPark yavaşsa düzenleme ekranı açılmıyordu.
     */
    public function kaynakOner(): void
    {
        if ($this->faaliyet === null) {
            return;
        }

        $this->oneri = app(KaynakOnerici::class)->oner($this->faaliyet);
    }

    /**
     * Öneriyi forma yazar. Seçeneklerde yoksa yazmıyor: kategori değişmiş
     * olabilir ve sözlükte olmayan bir kademe cetvelde hiçbir satıra denk
     * gelmez, faaliyet sessizce puansız kalırdı.
     */
    public function oneriyiUygula(): void
    {
        $kaynak = $this->oneri['kaynak'] ?? null;

        if (is_string($kaynak) && in_array($kaynak, $this->kaynakSecenekleri(), true)) {
            $this->kaynak = $kaynak;
        }
    }

    public function kaydet(): void
    {
        $veri = $this->validate([
            'kategori' => ['required', Rule::enum(Kategori::class)],
            'baslik' => ['required', 'string', 'max:255'],
            'yazarlar' => ['array'],
            'yazarlar.*' => ['nullable', 'string', 'max:255'],
            'rol' => ['nullable', 'string', 'max:32'],
            'yayinTuru' => ['nullable', 'string', 'max:32'],
            // 'tezden' düzeyi belirsiz eski değer; yeni kayıtta seçilemez ama
            // mevcut kayıt düzenlenirken geri yazılabilmeli.
            'donem' => ['nullable', Rule::in([...array_keys(Faaliyet::tezIliskileri()), 'tezden'])],
            'kaynak' => ['nullable', 'string', 'max:255'],
            'tarih' => ['nullable', 'date', 'before_or_equal:today'],
            'doi' => ['nullable', 'string', 'max:255'],
            'aciklama' => ['nullable', 'string', 'max:1000'],
            'durum' => ['required', Rule::in(array_keys(Faaliyet::durumlar()))],
        ]);

        $kategori = Kategori::from($veri['kategori']);

        $yazarlar = array_values(array_filter(
            array_map('trim', $this->yazarlar),
            fn (string $yazar) => $yazar !== '',
        ));

        $rol = $this->rolBelirle($kategori, $yazarlar);

        $faaliyet = $this->faaliyet ?? new Faaliyet;

        $faaliyet->fill([
            'durum' => $veri['durum'],
            'kategori' => $kategori->value,
            'tur' => $kategori->label(),
            'baslik' => $veri['baslik'],
            'yazarlar' => $yazarlar ? implode(', ', $yazarlar) : null,
            'rol' => $rol,
            'yayin_turu' => $this->yayinTuruSecenekleri() === [] ? null : ($this->yayinTuru ?: null),
            'donem' => $this->tezIliskisiSorulur() ? ($veri['donem'] ?: null) : null,
            'tarih' => $veri['tarih'] ?: null,
            'kaynak' => $veri['kaynak'] ?: null,
            'meta' => array_filter([
                'doi' => $veri['doi'] ?: null,
                'aciklama' => $veri['aciklama'] ?: null,
            ]),
        ]);

        // Puan SAKLANMAZ: her yönerge kendi cetveliyle puanlıyor, tek bir
        // "doğru" puan yok. Motor daima cetvelden hesaplar.
        Auth::user()->faaliyetler()->save($faaliyet);

        // Listede bir an parlasın: aday neyin değiştiğini aramasın.
        session()->flash(Faaliyetler::VURGULANAN, [$faaliyet->id]);

        Flux::toast(variant: 'success', text: $this->faaliyet !== null ? 'Faaliyet güncellendi.' : 'Faaliyet eklendi.');

        $this->redirectRoute('faaliyetler', navigate: true);
    }

    /**
     * Rolü belirler. Yayın türlerinde tek yazarlık otomatik çıkarılır; diğer
     * kategorilerde (proje, tez danışmanlığı) kullanıcının seçimi esastır.
     *
     * @param  list<string>  $yazarlar
     */
    private function rolBelirle(Kategori $kategori, array $yazarlar): ?string
    {
        $gecerli = $kategori->roller();

        if ($gecerli === []) {
            return null;
        }

        if (isset($gecerli['tek']) && count($yazarlar) <= 1) {
            return 'tek';
        }

        if (isset($gecerli[$this->rol])) {
            return $this->rol;
        }

        // Çok yazarlı ama rol seçilmemişse en kapsayıcı varsayılan.
        return isset($gecerli['ortak']) ? 'ortak' : array_key_first($gecerli);
    }

    public function render()
    {
        return view('livewire.faaliyet-ekle', [
            'kategoriler' => Kategori::cases(),
        ]);
    }
}
