# Girilemeyen Yönergeler

`pdf/` klasöründeki yönergelerden **veri girişi yapılamamış** olanlar ve
sebepleri. Amaç, aynı PDF'e ikinci kez girişip aynı duvara toslamamak: her
kayıt neyin çözüldüğünü, neyin çözülmediğini ve devam edildiğinde nereden
başlanacağını söylüyor.

Bir üniversite bu listeden ancak `database/data/yonerge/` altına eşiği ve
`database/data/cetvel/` altına cetveli girildiğinde çıkar.

**Önce teşhisi doğrula.** Trabzon, Iğdır, İnönü, İTÜ ve İstanbul Üniversitesi
bu listede "tablo okunmuyor" diye duruyordu; beşinde de tablo aslında
okunuyordu. Dördünde düz `pdftotext -q -layout` yetti; İstanbul'da ise tam
tersi gerekti — `-layout` OLMADAN. Kayıp PDF'ten değil, üstüne yazılan sütun dilimleme
adımından geliyordu. Bir kaydı ele almadan önce ham `-layout` çıktısına bak —
dosya adının da hâlâ doğru olduğunu kontrol et (Iğdır'ınki yanlış yazılmıştı).

Kolon haritası çıkarırken çapayı **en dolu satırdan** al (genelde "Toplam
puan"), tolerans dar tutma: aynı tablonun dört haneli ve tek haneli hücreleri
birkaç karakter kayık hizalanıyor. Aynı belgedeki her tablonun kendi çapası
olabilir.

---

## Karadeniz Teknik Üniversitesi

**Dosya:** `pdf/17536999312.karadenizteknikuniverstesi.pdf` (48 sayfa)

**Engel:** PDF taranmış görüntü. `pdftotext` 48 sayfadan toplam **48 karakter**
metin çıkarıyor, yani metin katmanı yok.

**Devam edilirse:** Sayfa görüntülerini okumak ya da OCR gerekiyor.

---

## İstanbul Üniversitesi — Devlet Konservatuvarı alanları

**Dosya:** `pdf/1784016632886.istanbul-universitesi-kriter.pdf` (24 sayfa, 01/06/2026)

**Girildi:** Madde 9-12'nin dört alanı (Sağlık, Fen ve Mühendislik, Sosyal,
Mimarlık) dört kadroyla birlikte; Tablo 1 ve Tablo 4 cetvele çevrildi.

**Kalan:** Madde 13-15 — Devlet Konservatuvarı'nın Müzik ve Sahne Sanatları,
Müzikoloji ve Türk Müziği bölümleri. Bu üç alanın koşulları neredeyse tamamen
TABLO 2'ye bağlı ("Tablo 1'den en az 20, Tablo 2'den en az 80, ikisinden
toplam 300 puan") ve Tablo 2 konservatuvara özgü seksen satırlık bir müzik,
sahne ve icra tablosu. Cetvele çevrilmeden koşul yazılamaz.

**Devam edilirse:** Tablo 2'yi (raw metnin 730-813. satırları) cetvele çevir,
`istanbul-2026-konservatuvar` adında üçüncü bir varyant üret (Tablo 1 + Tablo 2
maddeleri, `TABLO-1` ve `TABLO-2` grupları), sonra Madde 13-15'i o cetvele
bağla. Koşullar zaten okunmuş durumda ve düz puan barajları.

**NOT — bu PDF `-layout` ile okunmuyor:** alan tabloları dört sütunlu ve
sütunlar arasında tam boş şerit yok, `pdftotext -layout` sütunları birbirine
karıştırıyor. `-layout` OLMADAN çalıştırıldığında pdftotext hücreleri okuma
sırasına göre tek tek döküyor ve sütunlar temiz ayrılıyor.

---

## Dokuz Eylül Üniversitesi — Güzel Sanatlar ve Konservatuvar

**Dosya:** `pdf/17536992732.dokuzeyluluniverstesi.pdf` (46 sayfa)

**Girildi:** Madde 2.1-2.10'un on bir alanı (tıp-sağlık, hemşirelik,
mühendislik, fen, matematik, sosyal, eğitim, spor, filoloji, ilahiyat, hukuk,
mimarlık) üç kadroyla; Puanlandırma Formunun A, B ve C bölümleri cetvele
çevrildi.

**Kalan:** Madde 2.11 (Güzel Sanatlar, yedi alt alan) ve 2.12 (Konservatuvar,
beş alt alan). İki sebeple bekliyor:

1. Koşulları Puanlandırma Formunun **D bölümüne** (24-41 arası maddeler)
   dayanıyor: müzik teknolojisi, uzun metrajlı film, TV dizisi, kısa film,
   animasyon, reklam filmi, tiyatro, sahne tasarımı blokları. Bu blokların
   kalemleri kaynak sözlüğünde (`App\Enums\Kategori::kaynaklar()`) karşılıksız;
   yalnızca sergiler (24) ve tiyatro yazarlığının (33) bir kısmı girilebildi.
2. Bu alanların **zorunlu puan kümesi** de aynı maddeleri içeriyor
   (Madde 1.10.1/c: "ilaveten 24-25-26-27-28-29-30-31-32-33-34 no'lu
   maddeler"). Eksik kümeyle zorunlu puan barajı yazmak, adaya asla
   sağlayamayacağı bir hedef gösterirdi.

**Devam edilirse:** Önce sözlüğe film, animasyon ve müzik teknolojisi
etiketleri eklenmeli (Kategori::SanatselEtkinlik altına); sonra D bölümünün
24-41 arası maddeleri cetvele girilip `ZORUNLU-GS-UYGULAMALI` ve
`ZORUNLU-KONSERVATUVAR` kümeleri açılmalı. Alan koşulları zaten okunmuş
durumda ve düz sayı/puan şartları.

**Ziraat, orman ve su ürünleri** alanları yönergede hiç anılmıyor; kapsam dışı
kalması doğrudur.

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

## Türk Hava Kurumu Üniversitesi

**Dosya:** `pdf/17634009071.Türk Hava Kurumu Üniversitesi Kriter.pdf` (193 satır)

**Koşullar eksiksiz, iki tablo birden eksik.** Akademik puan barajları net
(Dr. 100, doçent 750, profesör 1500 — 1000'i doçentlik sonrası) ve alan
başına yayın sayıları dört fakülte grubu için tablo hâlinde veriliyor.

Ama iki dayanak PDF'te YOK:

1. **EK-1** — Madde 6 "A, B, C, D, E, F ve G faaliyet türleri puanları"
   diyor; o tablo dosyada değil. Puan barajları hesaplanamaz.
2. **A1-A4 dergi grupları** — bütün yayın sayısı koşulları bu gruplara atıf
   yapıyor ("A1 grubundan en az 2 yayın") ama grupların hangi indekslere
   karşılık geldiği tanımlı değil.

Madde 13 üstelik puanı üçüncü bir belgeye bağlıyor: "performans için
hazırlanan tablo esas alınır."

**Devam edilirse:** THK Üniversitesi'nin EK-1 puanlama tablosunu ve A1-A4
grup tanımlarını ayrıca indirmek gerekiyor; koşul tarafı hazır. Balıkesir'le
aynı durum.

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
| **İnönü** | L bölümü (girişimcilik, TGB, TTO), P bölümü (sportif faaliyetler), H (kongre düzenleme), S (iletişim bilimleri) | "L1-L18 Puanı" koşulu hiç yazılmadı; Spor Bilimleri adayının toplamı düşük çıkar |
| **İTÜ** | Hukuk Temel Alanı (Tablo 4'te sınır değeri yok), atıf puanı, ders kredisi, program koordinatörlüğü, toplumsal katkı | Toplam puan barajı hiç yazılmadı; hukuk alanı kapsam dışı |
| **Dokuz Eylül** | Puanlandırma Formunun D bölümü (film, animasyon, müzik teknolojisi, TV, reklam blokları); teknopark, meslek odası ve girişimcilik dersi kalemleri | Güzel Sanatlar ve Konservatuvar alanları hiç girilmedi |

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
  Karabük, Manisa CBÜ ve Iğdır'ın yeniden atanma koşulları. Atama dönemi
  uzunluğu profilde tutulmadığı için bu eşikler girilmedi.
- **Yarıyıl başına adet sınırı** — Iğdır 20. madde ("son beş yılda, her
  yarıyılda verilen en fazla dört ders"). Hem kayan pencere hem yarıyıl başına
  sayı gerekiyor; motor ikisini birlikte tutamıyor, ders puanı YÜKSEK görünür.
- **FWCI / CNCI ve iş birliği nitelikleri** — İnönü'nün doçent ve profesörlük
  "ek koşullardan biri" bloğu. Profil FWCI değerini tutmuyor, faaliyet kaydı da
  yayının uluslararası ya da üniversite-üniversite iş birliğiyle üretilip
  üretilmediğini tutmuyor. Üçü de beyan olarak girildi; blok `veya` olduğu için
  koşul kesin ret vermiyor, belirsiz kalıyor.
- **Ortak çalışma çarpanları** — İnönü Madde 5(4) (QS ilk 100 ortağı ×2, ilk
  500 ×1,6, uluslararası ortaklı ×1,4, ulusal ortaklı ×1,2) ve Madde 7(2)
  (Incites/SciVal %1'lik dilim ×3, %10'luk ×1,5). Faaliyet kaydı ortağın
  kurumunu ve derginin dilim bilgisini tutmuyor; puan DÜŞÜK görünür.
- **Puan üreten formüller** — İTÜ Tablo 1'in D.1 ((h-indeksi − sınır) × 25),
  D.2 ((FWCI − 1) × yayın sayısı) ve K.1 (ders kredileri toplamı) kalemleri.
  Motorun `puan` alanı sabit sayı tutuyor. İTÜ'nün TOPLAM PUAN barajı bu
  yüzden hiç yazılmadı; eser puanı barajı etkilenmiyor çünkü ona yalnızca
  yayın türleri giriyor.
- **Çok kademeli eşdeğerlik** — Dokuz Eylül mühendislik doçentliği "en az iki
  yayın … her bir yayına eşdeğer 15 puanlık etkinlik" diyor, yani iki yayının
  ikisi birden 30 puanla değiştirilebilir. Motorun `telafi` dalı tek kademe
  tanıyor; yalnızca "1 yayın + 15 puan" okuması girildi, koşul o alanda
  olduğundan ZOR görünür.
- **`referans` düğümü hedefin TAMAMINI çeker** — Dokuz Eylül profesörlüğü
  "doçent kadrosunun asgari YAYIN koşullarını tekrarlamak" istiyor ama
  `referans` doçentliğin puan barajlarını da taşırdı; profesörlüğün kendi
  barajları ayrı olduğu için aday yönergede yazmayan bir baraj görürdü. Aynı
  koşul kapanışını ikinci dönemle çağırmak doğru çözüm oldu.
- **"En fazla N'i şu türden"** — üst sınırlı adet koşulları. Motorda "en
  fazla" düğümü yok. Çoğu satırda üst sınır alt sınırdan türüyor (2 eserin en
  az 1'i A ise en fazla 1'i C olabilir); türemediği yerlerde (İTÜ Mimarlık
  Fakültesi doçent ve profesör satırları) uygulanmıyor ve koşul olduğundan
  KOLAY görünüyor.
- **İlk yazarın payına bağlı formül** — Iğdır'ın altı ve daha fazla yazarlı
  yayınlarda diğer yazarlara verdiği pay: (Puan − ilk ismin puanı) / diğer
  yazar sayısı. Motorun `bol` alanı yalnızca `pay / (n − eksi) + ek` biçimini
  tanıyor; 0,8/(n−1) yazıldı, altı yazarlıda birebir aynı, daha kalabalık
  yayınlarda puan bir tık DÜŞÜK çıkıyor.
- **"Çağrılı makale", "tezden üretilmiş yayın", "atıf alan eser sayısı"** —
  Düzce, Bandırma ve Karabük'te puanı değiştiren ama faaliyet kaydında karşılığı
  olmayan nitelikler. Her birinde kural gereği düşük olan satır seçildi.
