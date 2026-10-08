<?php

namespace App\Livewire\Admin;

use App\Enums\EpostaTuru;
use App\Enums\YoneticiIslemi;
use App\Models\EpostaSablonu;
use App\Models\IslemKaydi;
use App\Services\Eposta\EpostaGonderici;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Yönetim paneli — tek e-posta şablonunu düzenleme, canlı önizlemeyle.
 *
 * @property-read string $onizleme
 * @property-read list<string> $bilinmeyenler
 */
#[Layout('layouts.admin')]
#[Title('Yönetim · E-posta Şablonu')]
class EpostaSablonuDuzenle extends Component
{
    public EpostaTuru $tur;

    public string $konu = '';

    public string $govde = '';

    public bool $aktif = true;

    public bool $ozel = false;

    public function mount(EpostaTuru $tur, EpostaGonderici $gonderici): void
    {
        $this->tur = $tur;
        $this->yukle($gonderici);
    }

    /**
     * Önizleme: örnek değerlerle, gerçek mail şablonundan (aynı HTML iskeleti).
     */
    #[Computed]
    public function onizleme(): string
    {
        $mail = app(EpostaGonderici::class)->olustur($this->konu, $this->govde, $this->tur->ornekDegerler());

        return view('mail.sablonlu', ['icerik' => $mail->govdeHtml])->render();
    }

    /**
     * Konu ya da gövdede geçen ama bu şablonda tanımlı olmayan değişkenler.
     *
     * @return list<string>
     */
    #[Computed]
    public function bilinmeyenler(): array
    {
        return app(EpostaGonderici::class)->bilinmeyenDegiskenler($this->tur, $this->konu."\n".$this->govde);
    }

    public function kaydet(): void
    {
        $this->validate([
            'konu' => ['required', 'string', 'max:200'],
            'govde' => ['required', 'string', 'max:10000'],
            'aktif' => ['boolean'],
        ], attributes: ['konu' => 'konu', 'govde' => 'içerik']);

        // Kapatılamayan şablon (şifre sıfırlama) istekle kapatılamaz.
        if (! $this->tur->kapatilabilir()) {
            $this->aktif = true;
        }

        DB::transaction(function (): void {
            EpostaSablonu::query()->updateOrCreate(
                ['tur' => $this->tur->value],
                ['konu' => $this->konu, 'govde' => $this->govde, 'aktif' => $this->aktif, 'guncelleyen_id' => Auth::id()],
            );

            IslemKaydi::yaz(YoneticiIslemi::SablonGuncelledi, Auth::user(), null, [
                'sablon' => $this->tur->etiket(),
                'aktif' => $this->aktif ? 'açık' : 'kapalı',
            ]);
        });

        $this->ozel = true;
        Flux::toast(variant: 'success', text: 'Şablon kaydedildi.');
    }

    /**
     * Panel kaydını siler; şablon koddaki varsayılana döner (açık olarak).
     */
    public function varsayilanaDon(EpostaGonderici $gonderici): void
    {
        DB::transaction(function (): void {
            EpostaSablonu::query()->where('tur', $this->tur->value)->delete();
            IslemKaydi::yaz(YoneticiIslemi::SablonSifirladi, Auth::user(), null, ['sablon' => $this->tur->etiket()]);
        });

        $this->yukle($gonderici);
        $this->resetValidation();
        Flux::toast(text: 'Şablon varsayılana döndü.');
    }

    /**
     * Ekrandaki (kaydedilmemiş olabilir) hâli örnek değerlerle yöneticinin
     * kendi adresine gönderir.
     */
    public function testGonder(EpostaGonderici $gonderici): void
    {
        $this->validate(['konu' => ['required', 'string', 'max:200'], 'govde' => ['required', 'string', 'max:10000']]);

        $gonderici->test($this->tur, $this->konu, $this->govde, Auth::user()->email);

        Flux::toast(variant: 'success', text: 'Test e-postası '.Auth::user()->email.' adresine gönderildi.');
    }

    private function yukle(EpostaGonderici $gonderici): void
    {
        $sablon = $gonderici->sablon($this->tur);

        $this->konu = $sablon['konu'];
        $this->govde = $sablon['govde'];
        $this->aktif = $sablon['aktif'];
        $this->ozel = $sablon['ozel'];
    }

    public function render(): View
    {
        return view('livewire.admin.eposta-sablonu-duzenle');
    }
}
