# ÜAK Doçentlik Başvuru Şartları cetvelleri — kaynak ve sınırlar

`uak-2024-mart-{alan}.php` dosyalarının tamamı `uak/2024/` klasöründeki 12 PDF'ten
üretildi. Bu dosya `_` ile başladığı için `SartDeposu` onu veri olarak okumaz.

## Dönem doğrulaması

Belgeler **2024 Mart dönemine** aittir: PDF üstverileri 26–27 Şubat 2024, yani
başvuru döneminden hemen önce. Tablo 1 (Eğitim Bilimleri) klasörde yoktu,
uak.gov.tr'den aynı seriden indirildi (`688341526ebc3.pdf`, 26/02/2024 11:08:30 —
Tablo 2'nin 23 saniye öncesi).

Bursa Uludağ kriter metni (18/12/2025) altı ayrı yerde bu dönemi çiviliyor
(md. 4, 6, 20, 25...), dolayısıyla bağlanan cetvel yönergenin dayandığı ölçektir.

### 2025 sürümüyle karşılaştırma

`uak/` kök klasöründe uak.gov.tr'nin canlı (2025 tarihli) tabloları da var.
12 tablo × 13 bölüm karşılaştırıldı: **puan ve tavan değerlerinde hiçbir fark yok.**
Farklı görünen üç tavan, 2024 PDF'lerinde `pdftotext`'in boşluk yutmasından
kaynaklanan ayrıştırma artefaktıydı ("Bu maddedenen fazla 20 puanalınabilir").

Bu yüzden 2025 dosyaları girilmedi — aynı veriyi ikinci kez tutmak anlamsız.
Başka bir yönerge açıkça 2025'e atıf yaparsa `uak/` kökünden üretilir.

> Not: "2024 Mart Q1-Q3'ten 30 puan ister, 2025 40 puan ister" ayrımı **yanlıştır**.
> 30 ↔ 40 farkı dönem farkı değil, **alan** farkıdır: Eğitim Bilimleri 30, diğer
> temel alanlar 40 — her iki sürümde de böyle.

## Girilmeyen bölümler

Bunlar cetvelde **yoktur**, dolayısıyla hesaplanan toplam gerçek ÜAK puanından
**eksik** kalabilir (fazla değil — yönü bilinçli seçildi):

| Bölüm | Neden | Tavan |
|---|---|---|
| 9. Eğitim-Öğretim | "Dört farklı yarıyılda ders vermiş olmak" bir metriktir, faaliyet satırı başına puan değil | 6 |
| 13. Diğer | h-indeksi / yurtdışı araştırma birer metrik; Güzel Sanatlar ve Spor'un sanatsal-sportif bentleri faaliyet satırından doğrulanamaz | 10–20 |
| 1e, 2c | Editöre mektup / araştırma notu — karşılık gelen `kaynak` etiketi yok | — |
| 10d | Patent başvurusu (tescil değil) — `kaynak` etiketi yok | — |

`11. Ödül` yalnızca `TÜBİTAK / TÜBA Ödülü` kaynağına bağlandı: ÜAK'ın listesi
kapalıdır (YÖK Doktora Tezi, YÖK Üstün Başarı, TÜBİTAK Bilim, TÜBİTAK Teşvik,
TÜBA GEBİP, TÜBA TESEP). Diğer ödül türleri 0 puan alır — doğru davranış.

`7. Bilimsel Araştırma Projesi`'nde TÜSEB yoktur; ÜAK yalnızca AB Çerçeve/TÜBİTAK
(7a), uluslararası destekli (7b), kamu/özel Ar-Ge (7c) ve BAP (7d) sayar.

## Grup tavanları

Bölüm tavanları (`grup_tavanlari`) motor tarafından **uygulanır**; tavan dolarken
yüksek puanlı faaliyetler önceliklidir. Alt tavanlar ayrı grup olarak girildi
(ör. `4cd` = "c veya d bentlerinden toplamda en fazla 5 puan").

## Yönergelerin kullandığı gruplar

| Grup | Karşılığı |
|---|---|
| `1` | Uluslararası makale (tüm bentler) |
| `2` | Ulusal makale |
| `1-2a` | Uludağ'ın "1, 2a kapsamındaki dergiler" ifadesi |
| `Q1-Q2`, `Q1-Q3` | SCIE/SSCI çeyreklikleri |
| `AQ1-Q3` | SCIE/SSCI/AHCI Q1-Q3 |
| `7a` | AB Çerçeve/TÜBİTAK projesi (her rol) |
