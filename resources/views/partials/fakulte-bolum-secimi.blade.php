{{--
    Fakülte ve bölüm (bkz. App\Concerns\FakulteBolumSecimi). Seçenekler
    üniversiteye göre geliyor; listede olmayan yazılabilir.

    wire:key listeye bağlı: üniversite ya da fakülte değişip liste yenilenince
    kutu baştan kurulur. Aynı anahtar kalsaydı Alpine ilk çizimdeki listeyi
    tutmaya devam ederdi.
--}}
<x-combobox model="fakulte" :secenekler="$fakulteler" gonder
    wire:key="fakulte-{{ md5(implode('|', $fakulteler)) }}"
    label="Fakülte / Yüksekokul (opsiyonel)" placeholder="Fakülte adı yazın..."
    bos="Listede yok; yazdığınız gibi kaydedilir." />

@if ($fakulte !== '')
    <x-combobox model="bolum" :secenekler="$bolumler"
        wire:key="bolum-{{ md5(implode('|', $bolumler)) }}"
        label="Bölüm / Program (opsiyonel)" placeholder="Bölüm adı yazın..."
        bos="Listede yok; yazdığınız gibi kaydedilir." />
@endif
