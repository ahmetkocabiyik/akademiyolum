# Girilemeyen Yönergeler

`pdf/` klasöründeki yönergelerden **veri girişi yapılamamış** olanlar ve
sebepleri. Amaç, aynı PDF'e ikinci kez girişip aynı duvara toslamamak: her
kayıt neyin çözüldüğünü, neyin çözülmediğini ve devam edildiğinde nereden
başlanacağını söylüyor.

Bir üniversite bu listeden ancak `database/data/yonerge/` altına eşiği ve
`database/data/cetvel/` altına cetveli girildiğinde çıkar.

---

## İnönü Üniversitesi

**Dosya:** `pdf/178160788251.inonu-kriter-15042026.pdf` (60 sayfa, 15/04/2026)

**Çözülen:** Koşul tabloları (Tablo 2-5) matris biçiminde ve sütun haritası
tamamen çıkarıldı. On bir alan sütunu, metin içinde sabit karakter
konumlarında duruyor:

| kolon | alan | kolon | alan |
|---|---|---|---|
| 45 | Tıp ve Diş Hekimliği | 150 | Eğitim Bilimleri |
| 68 | Sağlık Bilimleri | 171 | Mimarlık, Planlama ve Tasarım |
| 89 | Fen Bilimleri ve Matematik | 199 | Sosyal, Beşerî ve İdari Bilimler |
| 109 | Mühendislik | 231 | Hukuk |
| 127 | Spor Bilimleri | 242 | Filoloji |
| | | 256 | Güzel Sanatlar |

**Tablo 2 ve 3** (Dr. Öğr. Üyesi ilk ve yeniden atama) bu haritayla eksiksiz
okunuyor. Örnek — ilk atama toplam puan barajı: Tıp 500 · Sağlık 700 ·
Fen 1000 · Mühendislik 800 · Spor 700 · Eğitim/Mimarlık/Sosyal 600 · Hukuk 400.

**Çözülemeyen iki şey:**

1. **EK-1 puanlama tablosunun hizası.** Koşullar `A puanı`, `Proje Puanı
   (K1-K14)`, `L1-L18 Puanı`, `Patent (M1-M5)` gibi kategori kodlarına atıf
   yapıyor. EK-1'de bu kodlardan yalnızca altı satır bulunabildi; tablo
   muhtemelen farklı bir hizada ya da sayfalara bölünmüş. Kategori kodları
   çözülmeden `A puanı ≥ 250` türü barajlar hiçbir maddeye bağlanamıyor.

2. **Tablo 4 ve 5'in (doçent, profesör) satır etiketleri.** Etiketler birden
   çok satıra sarmalanıyor ("Başlıca araştırma eseri: SCI-E, SSCI / …indeksli
   özgün makale (%50'sinde…)") ve bazı değerler etiket sütununa taşıyor, bu
   yüzden satır → sütun eşlemesi güvenilir değil. Yönergenin en zengin
   ölçütleri (h-indeksi, FWCI/CNCI, patent sayısı, yurt dışı araştırma
   deneyimi) tam bu iki tabloda.

**Neden yarısı girilmedi:** Yalnızca Dr. tabloları girilebilirdi ama EK-1
olmadan onların da puan barajları (`A puanı`, `Toplam puan`) modellenemiyor;
geriye yalnızca makale sayıları kalırdı ki bu yönergenin ayırt edici tarafı
değil.

**Devam edilirse:** EK-1'in hizasını çöz (muhtemelen sayfa görüntüsünden
okumak gerekiyor), sonra Tablo 4-5'in sarmalanmış etiketlerini ayır. Sütun
haritası yukarıda hazır.

---

## Karadeniz Teknik Üniversitesi

**Dosya:** `pdf/17536999312.karadenizteknikuniverstesi.pdf` (48 sayfa)

**Engel:** PDF taranmış görüntü. `pdftotext` 48 sayfadan toplam **48 karakter**
metin çıkarıyor, yani metin katmanı yok.

**Devam edilirse:** Sayfa görüntülerini okumak ya da OCR gerekiyor.

---

## İstanbul Üniversitesi

**Engel:** Koşul matrisinin sütunları satır satır kayıyor; ayrıca yapı hem adet
hem puan barajını iç içe kullanıyor. Sabit sütun konumu varsayımı burada
tutmuyor.

**Devam edilirse:** Sayfa görüntüsünden okumak gerekiyor.

---

## İstanbul Teknik Üniversitesi

**Dosya:** `pdf/17536997252.istanbulteknikuniverstesi.pdf` (17 sayfa)

**Çözülen:** TABLO 1'in 82 kalemi ve kodları çıkarıldı. Kısaltmalar belgede
tanımlı: H = Hukuk Temel Alanı, S = Sosyoloji Bölümü, MF = Mimarlık Fakültesi,
TMDK = Türk Musikisi Devlet Konservatuvarı.

**Engel:** Sütun düzeni **bölümden bölüme değişiyor** — tek bir kolon haritası
yok:

| bölüm | sütunlar |
|---|---|
| A (Makaleler) | 3 sütun: Tüm Birimler (H, S, MF, TMDK hariç) / H, S, MF / TMDK |
| B (Bildiriler) | 1 sütun: bütün birimler için tek değer |
| C (Kitap) | 2 sütun: Tüm Birimler (H, S, TMDK hariç) / H, S, TMDK |
| Eğitim-öğretim | 2 sütun: Tüm Birimler (H, S hariç) / H, S |

Ayrıca bazı satırlar değer yerine formül taşıyor:
`(h-indeksi − Sınır Değer) × 25`, `(FWCI − 1) × Yayın Sayısı`. Bunlar motorun
`puan` alanına sığmıyor; `metrik` düğümü ya da beyan olarak modellenmeleri
gerekir.

**Devam edilirse:** Her bölümün kendi başlığını ayrıştıran bir okuma yaz; tek
kolon haritasıyla okumak yanlış birimin puanını atar (B ve C bölümlerinde bu
oldu).

---

## Dokuz Eylül Üniversitesi

**Dosya:** `pdf/17536992732.dokuzeyluluniverstesi.pdf` (46 sayfa)

**Engel yok, sadece büyük.** Ölçütler tablo değil düzyazı: 25 alan bloğu (Güzel
Sanatlar 7, Konservatuvar 5 alt alana bölünmüş), her biri Dr/Doçent/Profesör
için ayrı paragraf. Üstüne üç ayrı "Puan Çizelgesi" matrisi var (6 alan grubu ×
zorunlu madde listesi) ve ayrı bir Puanlandırma Formu.

**Devam edilirse:** Selçuk ölçeğinde bir iş; birkaç tura yayılması gerekiyor.

---

## Balıkesir Üniversitesi

**Dosya:** `pdf/17536971662.balikesiruniversitesi.pdf` (131 satır)

**Puan tablosu PDF'te yok.** Ölçüt metni eksiksiz — profesör 300 puan (200'ü
EK-2'nin 1-9 maddelerinden, 100'ü …), doçent 225 (150 + 75), güzel sanatlar /
sahne sanatları 150 (100 + …) — ama koşulların tamamı **EK-2'ye** atıf yapıyor
ve EK-2 bu dosyada yer almıyor. Cetvel olmadan eşik yazmak, adaya hiçbir zaman
hesaplanamayacak bir baraj göstermek olurdu.

**Devam edilirse:** Balıkesir Üniversitesi'nin EK-2 puanlama tablosunu ayrıca
indirmek gerekiyor; ölçüt tarafı hazır, yalnızca cetvel eksik.

---

## Iğdır Üniversitesi

**Dosya:** `pdf/17536999612.igdiruniverstesi.pdf`

**Engel yok, ama tablo satır satır dağılmış.** Koşullar net ve zengin: profesör
3000 puan (20-23. maddelerden 500), doçent 2000 (22-23'ten 200), Dr. ilk atama
fen/sağlıkta 500, diğerlerinde 300; Güzel Sanatlar ve Spor için ayrı kümeler
(6-7. maddeler). Sorun EK-1'de: madde numarası, açıklama metni ve puan ÜÇ AYRI
SATIRA dağılmış ve numara sütunu 10. maddeden sonra kayıyor. 1-9 arası
maddeler temiz çıktı, 10-23 arası çıkmadı.

**Neden bekletildi:** koşullar tam olarak 10-23 arası maddeleri (editörlük,
projeler, ödüller, burslar) sayıyor. Eksik puanlarla eşik yazmak, adaya
sağlayamayacağı bir baraj göstermek olurdu.

**Devam edilirse:** numarayı, metni ve puanı ayrı ayrı toplayıp madde
sınırlarını "yeni numara göründüğünde kapat" kuralıyla birleştiren bir okuma
gerekiyor; tek satırlık kolon dilimlemesi bu tabloda yetmiyor.

---

## Taranmış (metin katmanı olmayan) PDF'ler

Aşağıdaki dosyalar görüntü olarak taranmış: `pdftotext` sıfır bayt metin
döndürüyor. Hiçbiri okunamıyor, dolayısıyla hiçbiri girilemiyor. Karadeniz
Teknik zaten yukarıda ayrı başlıkta anılıyordu; taramayla gelen sorun tek
değilmiş.

| Üniversite | Dosya | Sayfa |
|---|---|---|
| Karadeniz Teknik | `17536999312.karadenizteknikuniverstesi.pdf` | — |
| Karamanoğlu Mehmetbey | `17536999512.karamanoglumehmetbeyuniverstesi.pdf` | 15 |
| Tekirdağ Namık Kemal | `17537009192.tekirdagnamikkemaluniverstesi.pdf` | 19 |
| Kırklareli | `1770040975746.kirklareli-kriter-02022026.pdf` | 18 |
| Bilecik Şeyh Edebali | `1785927020751.bilecik-seyh-edebali-kriter-16102025.pdf` | 18 |
| Sağlık Bilimleri | `1765867210191.saglik-bilimleri-kriter-16122025.pdf` | 11 |
| Piri Reis | `17634009071.Piri Reis Üniversitesi Kriter.pdf` | 25 |
| İstanbul Okan | `17537100352.istanbulokanuniversitesi.pdf` | 14 |
| Biruni | `17537097592.biruniuniversitesi.pdf` | 6 |

Ayrıca `17537003802.mersinuniverstesi.pdf` de taranmış; Mersin korpusta zaten
var, demek ki başka bir kaynaktan girilmiş.

**Devam edilirse:** Bu dosyalar için ya OCR (ör. `ocrmypdf`) gerekiyor ya da
yönergelerin metin sürümünü üniversitelerin kendi sitelerinden indirmek. OCR
çıktısı puan tablolarında güvenilmez olabilir; sayı okuma hatası puanı sessizce
bozar, o yüzden OCR sonrası her tablo kaynakla karşılaştırılmalı.

---

## Yönerge değil, üst yazı

- **Burdur Mehmet Akif Ersoy** (`17536991522.burdurmehmetakifersoyuniverstesi.pdf`,
  87 satır): dosya yönergenin kendisi değil, YÖK'e gönderilen 17/02/2016 tarihli
  yönerge değişikliği üst yazısı. Ölçüt metni ve puan tablosu yok.

---

## Yeditepe Üniversitesi

**Dosya:** `pdf/17537104532.yeditepeuniversitesi.pdf` (432 satır)

**Engel yok, ama BÖLÜM düzeyinde ayrıntılı.** Kendi puan tablosu yok, koşullar
sayı şartı — buraya kadar hızlı şeride uygun. Sorun granülerlik: Madde 7'de
yalnızca Dr. Öğr. Üyeliği için **45 ayrı fakülte/bölüm başlığı** var ve her biri
kendi yayın kuralını taşıyor. Örnekler:

- Fen-Edebiyat / Çeviribilimi: Q1-Q4, MLA, ERIC, ESJI, ESCI, Scopus, CEEOL'de
  1 yayın **ya da** ULAKBİM TR Dizin'de 2 yayın
- Fen-Edebiyat / Rus Dili ve Edebiyatı: hakemli dergide 1 araştırma makalesi
  **ve** doktora çalışması kapsamında Rusça 1 makale
- Fen-Edebiyat / Matematik: Q1-Q3'te 1 yayın **ya da** editör kurulunda alandan
  bir uzman bulunan dergilerde 1 yayın

Doçentlik ve profesörlük için de benzer ayrım sürüyor. Bu, `birim` alanıyla
girilebilir ama tek başına 30-40 eşik demek.

**Neden bekletildi:** Fakülte düzeyinde toplamak bölümler arasındaki gerçek
farkı siler; adaya kendi bölümünün koşulu yerine komşu bölümünkini gösterir.
Doğrusu bölüm bölüm girmek, o da ayrı bir oturumluk iş.

**Devam edilirse:** Madde 7-(2), 8-(2) ve 9-(2)'deki bölüm listeleri sırayla
`birim` olarak açılmalı. `KONVANSIYONLAR.md`'deki `birim` kuralı aynen geçerli.

---

## Çankaya Üniversitesi — bozuk font kodlaması

**Dosya:** `pdf/17537097862.cankayauniversitesi.pdf`

PDF taranmış değil, metin katmanı var — ama gömülü fontun karakter haritası
(cmap) bozuk. `pdftotext` çıktısı okunmuyor:

```
0$''(  %X<|QHUJHQLQDPDFÕdDQND\DhQLYHUVLWHVL
```

**Kısmen çözüldü.** ASCII harfler **+29 kaydırmalı**: `0$''(` → `MADDE`,
`dDQND\D` → `Çankaya`. Kaydırmayı uygulayan bir satır:

```python
''.join(chr(ord(c)+29) if 32 <= ord(c) <= 97 else c for c in metin)
```

Kaydırma sonrası ASCII sınırını aşan karakterler Türkçe harflere karşılık
geliyor ve bunların haritası elle çıkarılmalı. Şimdiye kadar doğrulananlar:

| Ham | Gerçek | Ham | Gerçek |
|---|---|---|---|
| `d` | Ç | `o` | ç |
| `g` | Ö | `\|` | ö |
| `h` | Ü | `ø` | İ / i |
| `Õ` | ı | `÷` | ğ |
| `ú` | ş | | |

**Neden bekletildi:** Harita eksik ve rakamların nasıl kodlandığı henüz
bilinmiyor. Bir kriter belgesinde rakamı yanlış okumak puanı sessizce bozar;
haritayı tamamlayıp bilinen bir cümleyle doğrulamadan girmek doğru olmaz.

**Devam edilirse:** Haritayı tamamla, çıktıyı yönergenin PDF'teki görünümüyle
karşılaştırarak doğrula, sonra normal akışa gir. Bu tek dosya için geçerli;
korpustaki 179 PDF tarandı, aynı bozukluk başka dosyada yok.

---

## Munzur Üniversitesi — kötü OCR

**Dosya:** `pdf/17634002431.Munzur Üniversitesi Kriter.pdf` (1243 satır)

Dosya OCR'dan geçirilmiş ama çıktı kullanılamaz durumda. 4030 kelimenin
yalnızca 35'i (%0) tanınabiliyor:

```
MtIı.{ZuR rn ıivpnsff nsi
oĞnnrişı r_ryşıİĞİNE yuı<sprrilME vE ATANMa nrgıgnİ
"eııdirıneleriıi", "yapıiabilııesi", "diizenleyen", "öğretiın", "iiyelerine"
```

Türkçe karakterler ve `n/ıı/ıv`, `m/ııı`, `ü/ii` ayrımları tutarsız biçimde
bozulmuş; düzeltilebilir bir kural yok.

**Devam edilirse:** Yönergenin metin sürümünü Munzur Üniversitesi'nin kendi
sitesinden indirmek ya da PDF'i yeniden OCR'lamak gerekiyor (`ocrmypdf --force-ocr
-l tur`). Mevcut çıktı üzerinden giriş yapılamaz.

---

# Kısmen girilen yönergeler

Aşağıdaki üniversiteler korpusa girdi, ama yönergenin bir parçası kaynak
PDF'ten çıkarılamadığı için o parçaya bağlı eşikler eksik kaldı. Her biri ilgili
dosyanın başlığında da anlatılıyor.

| Üniversite | Eksik kalan | Sonuç |
|---|---|---|
| **Bayburt** | 11(2) Sanat ve Tasarım Etkinlikleri bölümünün puan sütunu | Güzel Sanatlar alanı hiç girilmedi; diğer alanlar tam |
| **Kilis 7 Aralık** | Çizelgenin 9-34 numaralı bölümleri (sergi, koleksiyon, müzik, film, tiyatro, mimarlık) | Sanat ve Tasarım Dalları hiç girilmedi |
| **Bitlis Eren** | "I" (sanat çalışmaları) bölümü kaynak sözlüğünde karşılıksız | Güzel Sanatlar hiç girilmedi |
| **Bingöl** | 52 numaralı ihtisaslaşma kalemi (Tarım ve Havza Bazlı Kalkınma) | Fen ve sosyal alanların zorunlu barajı olduğundan zor görünür |
| **Hatay MKÜ** | G bölümü (sanat tarihi, arkeoloji, antropoloji kazı çalışmaları) | Sosyal ve Güzel Sanatlar barajı olduğundan zor görünür |
| **Giresun** | M, O, P, R bölümleri (ödüller, görsel ve sanatsal etkinlikler) | Alt barajlara girmiyor; Güzel Sanatlar adayının genel toplamı düşük çıkar |
| **Manisa CBÜ** | I (32-51), J (52-53) ve K (54-68) bölümleri | Güzel Sanatlar ve Konservatuvar toplamı düşük çıkar |
| **Karabük** | Spor kalemleri 4.6.14-4.6.21 | Spor Bilimleri adayında 4.1-4.6 barajı zor görünür |

## Motorun karşılayamadığı kurallar

Bunlar PDF sorunu değil; motorun bugünkü yapısıyla ifade edilemeyen kurallar.
Hepsi ilgili cetvelin `kapsam_notu` alanında adaya da söyleniyor.

- **Yüzdeye bağlı tavan** — Düzce (eğitim-öğretim %20, burs %10, idari görev
  %10), Manisa CBÜ (atıf %20), Karabük (E bölümü %10). Motor yalnızca sabit
  grup tavanı tanıyor; bu kalemlerde puan **yüksek** görünür.
- **Çeyrekliğe bağlı çarpan** — Bandırma (Q1:2, Q2:1,5, Q3:1,25, Q4:1). En düşük
  çarpan alındı; Q1 makalesi olan adayın puanı **düşük** görünür.
- **Kategoriye göre farklı yazar formülü** — Bayburt (makalede kademeli, kitap ve
  bildiride 1/n). Cetvel başına tek matris tanımlanabildiği için makale kuralı
  uygulandı; çok yazarlı kitapta puan **yüksek** görünür.
- **Kişi sayısına bölme** — Kilis (yardımcı araştırıcı puanı araştırıcı sayısına
  bölünüyor), Bitlis ve Bolu (çevirmen, editör, patent sahibi sayısına
  bölünüyor). Kilis'te araştırmacı satırları hiç girilmedi; diğerlerinde çarpan
  o kalemlerde uygulanmıyor.
- **Yıl ortalaması / görev süresi** — Hatay MKÜ, Bandırma, Bingöl, Bolu, Düzce,
  Karabük ve Manisa CBÜ'nün yeniden atanma koşulları. Atama dönemi uzunluğu
  profilde tutulmadığı için bu eşikler girilmedi.
- **"Çağrılı makale", "tezden üretilmiş yayın", "atıf alan eser sayısı"** —
  Düzce, Bandırma ve Karabük'te puanı değiştiren ama faaliyet kaydında karşılığı
  olmayan nitelikler. Her birinde kural gereği düşük olan satır seçildi.
