@props(['satirlar', 'puanVar'])

{{-- Raporun faaliyet tablosu. Puan sütunu yalnızca hedef seçiliyken: puan
     daima bir cetvele göredir, hedefsiz basılan sayı neye göre olduğu belirsiz
     bir puan olurdu. --}}
<table class="rapor-tablo">
    <thead>
        <tr>
            <th>Başlık</th>
            <th class="sag">Yıl</th>
            @if ($puanVar)
                <th class="sag">Puan</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($satirlar as $satir)
            <tr>
                <td>
                    <div class="rapor-tablo-baslik">{{ $satir['baslik'] }}</div>
                    <div class="rapor-tablo-alt">
                        {{ collect([$satir['yazarlar'], $satir['tur'], $satir['kaynak']])->filter()->implode(' · ') }}
                    </div>
                </td>
                <td class="sag">{{ $satir['yil'] ?: '—' }}</td>
                @if ($puanVar)
                    <td class="sag">{{ $satir['puan'] ?? '—' }}</td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
