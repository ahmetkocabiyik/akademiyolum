{{-- Şablonlu e-postanın HTML iskeleti. İçerik EpostaGonderici'de Markdown'dan
     (ham HTML kaçışlanarak) üretiliyor; burada yalnızca marka çerçevesi.
     Stiller satır içi: e-posta istemcileri <style> bloğunu çoğu zaman atıyor. --}}
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="margin:0; padding:0; background:#f4f6fb; font-family:-apple-system, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color:#1f2937;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6fb; padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:560px; background:#ffffff; border:1px solid #e2e8f0; border-radius:12px; overflow:hidden;">
                    <tr>
                        <td style="background:#0a1628; padding:20px 28px; border-bottom:3px solid #c9a84c;">
                            <span style="font-family:Georgia, 'Times New Roman', serif; font-size:20px; font-weight:700; color:#ffffff;">{{ config('app.name') }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="icerik" style="padding:28px; font-size:15px; line-height:1.65;">
                            {!! $icerik !!}
                        </td>
                    </tr>
                </table>
                <p style="margin:16px 0 0; font-size:12px; color:#94a3b8;">© {{ now()->year }} {{ config('app.name') }}</p>
            </td>
        </tr>
    </table>
</body>
</html>
