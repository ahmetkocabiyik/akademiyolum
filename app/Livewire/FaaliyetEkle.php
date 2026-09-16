<?php

namespace App\Livewire;

use App\Enums\Kategori;
use App\Enums\TemelAlan;
use App\Models\Faaliyet;
use App\Services\Scoring\Sart\MaddeKatalogu;
use App\Services\Scoring\Sart\SartDeposu;
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
    public ?Faaliyet $faaliyet = null;

    public string $sekme = 'manuel';

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

            return;
        }

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

    private function roluDogrula(): void
    {
        if ($this->rol !== '' && ! array_key_exists($this->rol, $this->rolSecenekleri())) {
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
        $user = Auth::user();

        if ($user->universite === null) {
            return null;
        }

        $depo = app(SartDeposu::class);
        $esik = $depo->bul(
            $user->universite,
            'dr_ogr_uyesi',
            ($user->temel_alan ?? TemelAlan::Sosyal)->value,
            $user->birim,
        );

        return $esik !== null ? $depo->katalog($esik['cetvel']) : null;
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
        ]);

        $kategori = Kategori::from($veri['kategori']);

        $yazarlar = array_values(array_filter(
            array_map('trim', $this->yazarlar),
            fn (string $yazar) => $yazar !== '',
        ));

        $rol = $this->rolBelirle($kategori, $yazarlar);

        $faaliyet = $this->faaliyet ?? new Faaliyet(['durum' => 'onaylandi']);

        $faaliyet->fill([
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
