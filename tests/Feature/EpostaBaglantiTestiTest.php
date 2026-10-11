<?php

use App\Livewire\Admin\EpostaSablonlari;
use App\Mail\SablonluEposta;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    actingAs(User::factory()->onboarded()->create(['email' => 'admin@ornek.test', 'super_admin' => true]));
});

test('gönderim başarılıysa e-posta kuyruğa atılmadan anında gider', function () {
    // "array" taşıyıcılı ama adı gönderen sürücü gibi olan bir mailer.
    config(['mail.default' => 'deneme', 'mail.mailers.deneme' => ['transport' => 'array']]);

    Livewire::test(EpostaSablonlari::class)
        ->assertSet('testAdresi', 'admin@ornek.test')
        ->set('testAdresi', 'alici@ornek.test')
        ->call('baglantiTesti')
        ->assertSet('testSonucu.tur', 'success')
        ->assertSee('alici@ornek.test adresine gönderildi');

    $mesajlar = Mail::mailer('deneme')->getSymfonyTransport()->messages();

    expect($mesajlar)->toHaveCount(1)
        ->and($mesajlar[0]->getOriginalMessage()->getTo()[0]->getAddress())->toBe('alici@ornek.test');
});

test('sağlayıcı hatası ekranda gösterilir', function () {
    config(['mail.default' => 'smtp', 'mail.mailers.smtp.host' => '127.0.0.1', 'mail.mailers.smtp.port' => 1]);

    Livewire::test(EpostaSablonlari::class)
        ->call('baglantiTesti')
        ->assertSet('testSonucu.tur', 'danger')
        ->assertSee('Connection could not be established');
});

test('log sürücüsünde gönderilmediği uyarılır', function () {
    config(['mail.default' => 'log']);

    Livewire::test(EpostaSablonlari::class)
        ->assertSee('Sürücü: log')
        ->call('baglantiTesti')
        ->assertSet('testSonucu.tur', 'warning')
        ->assertSee('yalnızca log dosyasına yazıldı');
});

test('geçersiz adres reddedilir, sık deneme sınırlanır', function () {
    config(['mail.default' => 'array']);

    Livewire::test(EpostaSablonlari::class)
        ->set('testAdresi', 'adres-degil')
        ->call('baglantiTesti')
        ->assertHasErrors('testAdresi')
        ->assertSet('testSonucu', null);

    $bilesen = Livewire::test(EpostaSablonlari::class);

    foreach (range(1, 5) as $deneme) {
        $bilesen->call('baglantiTesti');
    }

    $bilesen->call('baglantiTesti')->assertSet('testSonucu.tur', 'danger')->assertSee('Çok sık deneme');
});

test('şablonlu e-postada başlık logosu gömülü görsel olarak gider', function () {
    (new SablonluEposta('Konu', '<p>Gövde</p>', 'Gövde'))->to('alici@ornek.test')->send(Mail::mailer('array'));

    $eposta = Mail::mailer('array')->getSymfonyTransport()->messages()[0]->getOriginalMessage();
    $gomulu = collect($eposta->getAttachments())->filter(fn ($ek) => $ek->getDisposition() === 'inline');

    expect($gomulu)->toHaveCount(1)
        ->and($gomulu->first()->getMediaType().'/'.$gomulu->first()->getMediaSubtype())->toBe('image/png')
        ->and($eposta->getHtmlBody())->toMatch('/<img src="cid:[^"]+"/');
});
