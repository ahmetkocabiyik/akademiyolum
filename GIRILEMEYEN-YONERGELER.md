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

## Maltepe Üniversitesi

**Dosya:** `pdf/17537102832.maltepeuniversitesi.pdf` (3 sayfa, 147 satır)

**Yönerge metni eksiksiz ama iki eki de PDF'te yok.** Madde 5 ve 6 koşulları
iki ayrı belgeye devrediyor:

- **Ek-2** "Yükseltilme ve Atanma Asgari Koşulları" — ön değerlendirme bu
  belgeye göre yapılıyor.
- **Ek-3** "Akademik Personel Yükseltilme ve Atanma Puanlama Tablosu" —
  adayın formu bu tabloya göre dolduruluyor.

Dosyada yalnızca süreç maddeleri var (ön değerlendirme komisyonu, başvuru,
jüri). Sayısal tek bir koşul geçmiyor.

**Devam edilirse:** Maltepe Üniversitesi'nin Ek-2 ve Ek-3 belgelerini ayrıca
indirmek gerekiyor. Balıkesir ve Türk Hava Kurumu ile aynı durum.

---

## SANKO Üniversitesi — iki çizelge de eksik (kısmen girildi)

**Dosya:** `pdf/17537103582.sankouniersitesi.pdf` (6 sayfa)

**Puanlama Çizelgesi ve Asgari Koşullar Çizelgesi PDF'te yok.** Yönerge ikisini
de MADDE 4'te tanımlıyor (4/c ve 4/m) ve maddeler boyunca onlara atıf yapıyor,
ama dosyada yalnızca gövde (MADDE 1-18) var.

**Girildi.** Balıkesir, Türk Hava Kurumu ve Maltepe'den farkı şu: SANKO'nun
gövdesi çizelgeye ihtiyaç duymayan somut koşullar taşıyor.

- Dr. Öğr. Üyesi: MADDE 10/2 makale sayısını (en az 2) ve dergi kümesini
  (MADDE 4/p ve 4/r'de tanımlı indeksler) gövdede veriyor; MADDE 10/3 yabancı
  dil için 55 puan diyor. Eşik TAM değerlendirilebiliyor.
- Doçent: MADDE 11 yalnızca ÜAK doçentlik unvanı ve YÖK'ün doçentlik asgari
  koşullarını istiyor; ikisi de beyan.
- Profesör: MADDE 12/1-2 kıdem koşullarını veriyor (5 yıl doçentlik, 2 yıl
  doçent kadrosu). MADDE 12/4'ün "Puanlama Çizelgesi B1 kapsamındaki
  yayınlarından biri" koşulu ise B1'in kapsamı bilinmediği için
  `Kalip::hesaplanamiyor` olarak duruyor.

**Devam edilirse — YAZAR FORMÜLÜ ZATEN ELİMİZDE.** MADDE 15 formülü gövdede
yazıyor ve motorun `bol` alanıyla birebir ifade edilebiliyor. Çizelge
bulunduğunda cetvele eklenecek:

```php
'tek'                 => ['kademeler' => [1 => 1.0]],
'ilk', 'baslica'      => ['bol' => ['pay' => 1.6, 'ek' => 0.20]],
'yazar_2'             => ['bol' => ['pay' => 1.6, 'ek' => 0.15]],
'yazar_3'             => ['bol' => ['pay' => 1.6, 'ek' => 0.10]],
'yazar_4'…'ortak'     => ['bol' => ['pay' => 1.6, 'ek' => 0.05]],
```

Yönerge "yazar sayısı 4 veya daha fazla ise … eşit olarak dağıtılır" diyor,
yani dördüncü ve sonraki isimler aynı satırı paylaşıyor. MADDE 4/d'nin
"başlıca yazar" tanımı motorun süzgecinden geniş: tek yazarı, çok yazarlı
makalede İLK İKİ SIRADAKİ yazarı, sorumlu yazarı ve danışmanlığını yaptığı
tezden üretilmiş yayındaki yazarı kapsıyor.

Eksik olan yalnızca iki çizelge; SANKO Üniversitesinden ayrıca istenmeli.

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

## Trakya Üniversitesi — yedi ek, yedi ayrı puanlama sistemi

**Dosya:** `pdf/17537009772.trakyauniverstesi.pdf` (78 sayfa)

**Engel yok, tek başına bir parti büyüklüğünde.** Metin temiz, tablolar
`pdftotext -q -layout` ile okunuyor. Sorun hacim ve çeşitlilik: yönergenin
YEDİ eki var ve her biri KENDİ puanlama sistemini taşıyor.

| Ek | Temel alan | Şekli |
|---|---|---|
| EK-1 | Sağlık Bilimleri | 17 kategori, makale/meta analiz/derleme üçlüsü |
| EK-2 | Mühendislik, Fen Bilimleri ve Matematik | makaleyi çeyreklik × tür matrisine açıyor; ayrı hakemlik bölümü |
| EK-3 | Mimarlık, Planlama ve Tasarım | EK-1 ile aynı şekil, kitap ve atıf puanları farklı |
| EK-4 | Sosyal, Eğitim, Filoloji, İlahiyat, Öğretmen Yetiştirme | 21 kategori; müzik performansında kesirli puan (0,5) |
| EK-5 | Devlet Konservatuvarı | bilimsel tablo + ayrı "Müzik Bilim/Sanat Alanı" performans tablosu |
| EK-6 | Güzel Sanatlar | performans tablosu |
| EK-7 | Spor Bilimleri | ayrı "Sportif Performans" bölümü (16), iki h-indeksi seçeneği |

Normalleştirilip hash'lendi, yedisi de farklı: `dbc98ef`, `156aa32`, `95a1f60`,
`8721ca9`, `fb38d3a`, `6ea7472`, `adef9ad`. Toplam yaklaşık **1300 puanlı
satır**.

**Neden bekletildi:** EK-5'in "Müzik Bilim/Sanat Alanı" ve EK-6'nın performans
satırlarının çoğu PORTFÖYE bağlı ve yıl başına tavanlı ("En çok 15 puan ile
sınırlandırılmıştır", "orkestra konserinde üyelik 0,5"); §0 uyarınca büyük
bölümü zaten girilemeyecek. Kalan beş tablo tek tek çıkarılmayı istiyor.
Aceleye getirilirse Ahi Evran ve Pamukkale'de yaşanan türden sessiz hatalar
(salt rakam madde kodu, önekle aralık eşleşmesi) burada yedi kat maliyetli.

**Devam edilirse:** EK-1, EK-3 ve EK-7 tek gövdeden üretilebilir; EK-2, EK-4,
EK-5 ve EK-6 ayrı gövde ister. Ek koşullar da eklere göre ayrışıyor ve
fakülte / yüksekokul / meslek yüksekokulu için ayrı ayrı yazılmış, yani `birim`
ayrımı gerekecek. Genel ilkelerden (MADDE 4) çıkanlar: yabancı dil doktor
öğretim üyeliğinde 55, doçentlik ve profesörlükte 65 (tamamen yabancı dilde
eğitim yapan birimlerde 85); MADDE 4(2) doktor öğretim üyeliği puanlarının DÖRT
YILLIK atama için olduğunu, MADDE 5(3) daha kısa süreler için x/4 oranı
kurulduğunu söylüyor. Ek yapısı ve hash'ler `KONVANSIYONLAR.md` §6'da da
duruyor.

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
| **Yalova** | Mimarlık ve Güzel Sanatlar'ın 14. bölümü (Mesleki ve Diğer Araştırma Geliştirme Etkinlikleri: düzenleme kurulu, küratörlük, oturum başkanlığı, danışmanlık); Güzel Sanatlar'ın 13.3 (kamusal alanda sergilenen ürün) alt tablosu; bütün alanların "12. Diğer" (h-indeksi, yurt dışı araştırma) ve "İdari Görev" bölümleri | Sanat alanlarında toplam düşük çıkar; 13. bölüm barajı (Güzel Sanatlar Dr 35, Doçent 80) yalnızca girilebilen alt tablolardan hesaplanıyor |
| **Nişantaşı** | Ek1-D Sportif Performans bölümünün on altı satırının tamamı (antrenörlük, hakemlik, milli takım, federasyon kurulu) | Spor Bilimleri adayının toplamı düşük çıkar; yönergenin "spor alanında çalışanlar asgari puanı Ek1-D'den tamamlayabilir" alternatifi fiilen kapalı |
| **İstanbul Rumeli** | 6. bölümün tamamı (mimarlık ve mühendislik proje etkinlikleri: üniversitenin kendi Ar-Ge birimindeki mimari projeler, öğrenci yarışması danışmanlıkları, ulusal ve uluslararası yarışma dereceleri — 19 satır) | Mimarlık ve Mühendislik adayının toplamı düşük çıkar |
| **İstanbul Sabahattin Zaim** | Uluslararası kitaplar bölümünün tamamı (C.1-C.4: yurt dışı kitap, bölüm, editörlük, rapor — hepsi "tanınmış yabancı yayınevi" koşuluna bağlı); indekslenmemiş uluslararası hakemli dergiler (A.3, A.6, A.7); bilimsel toplantı düzenleme ve oturum başkanlığı (U.1-U.8) | Uluslararası kitaplar ulusal kitap satırına düşüyor, genel toplama girip "A-C" alt kapısına girmiyor; kitap ağırlıklı alanlarda doçentlik ve profesörlük alt kapısı olduğundan zor görünür |
| **İstanbul Yeni Yüzyıl** | 4.D Sportif Kariyer bölümünün tamamı (milli sporcu ve antrenör belgeleri); 5.E'nin kongre organizasyonu, kurum dergisi ve sahne sanatları performans blokları; 6.F'nin tez danışmanlığı dışındaki tamamı (klinik ve saha eğitimi, sertifikalı kurs, öğrenci kulübü danışmanlığı); 2.B'nin grafik tasarım kalemleri | Spor Bilimleri adayının puanı düşük çıkar; ders vermek için puan satırı zaten yönergede yok |
| **Kadir Has** | A-3 (indekslenmemiş uluslararası hakemli dergiler), C-1 ve C-2 (adayın adıyla anılan formül ve şekiller), O-1 ve O-2 (bilimsel toplantı düzenleme kurulu); L bölümü yalnızca yürütücülüğü sayıyor, araştırmacı ve danışmanlık hiç girmiyor | Kategoriler puansız olduğu için toplam etkilenmiyor; yalnızca A-3 kaynaksız kaldığından "A kategorisi" kümesi indeksli dergilerle sınırlı |
| **Kocaeli Sağlık ve Teknoloji** | Satır 50 (idari görevde bulunmak — kaynakta puan sütununda soru işareti var); sanatsal etkinlik satırının tamamı (çizelgede hiç yok); ESCI kapsamındaki dergilerde görev (hakemlik satırı yok); yardımcı tez danışmanlığı, el-cep kitabı, kongre başkanlığı, üniversite ödülleri | İdari görev puanı hiç hesaplanmıyor; Güzel Sanatlar adayının toplamı düşük çıkar |
| **KTO Karatay** | C bölümünün sanat ve tasarım satırlarının çoğu (uzun ve kısa metraj film, multimedya CD, web tasarımı, afiş ve fotoğraf baskısı, reklam kampanyası, fotoğraf ve grafik sergisi, kurumsal kimlik); çalıştay ve kongre başkanlığı ile oturum başkanlığı (C.35-C.38); adayın adıyla anılan formül ve tasarımlar (B.1, B.3, B.5); üniversite destekli BAP projeleri (yönerge ulusal proje satırında bunları açıkça dışarıda bırakıyor) | Güzel Sanatlar adayının toplamı düşük çıkar; hukuk, ilahiyat, filoloji, mimarlık ve ziraat alanları yönergede hiç anılmadığı için kapsam dışı |
| **MEF** | 14. bölümün tamamı (Eğitim Fakültesinin okullarla iş birliği kalemleri: öğretmenlik, psikolojik danışmanlık, aday öğretmen denetimi); 15. bölüm (h-indeksi, yurt dışı araştırma); bitirme projesi danışmanlığı, patent başvurusu, dergi hakemliği | Eğitim Fakültesi adayının toplamı düşük çıkar; doçentlik ve profesörlüğün okul iş birliği koşulu `hesaplanamiyor` olarak duruyor, koşul belgeyle sağlanmalı |
| **SANKO** | Puanlama Çizelgesi ve Asgari Koşullar Çizelgesi (ikisi de PDF'te yok) | Toplam puan barajı hiç gösterilemiyor; doçentlik eşiği yalnızca beyanlardan, profesörlüğün başlıca eser koşulu `hesaplanamiyor` düğümünden ibaret. Dr. Öğr. Üyesi eşiği tam |
| **Üsküdar** | Bilimsel toplantı düzenleme bölümünün tamamı (başkanlık, düzenleme ve bilim kurulu üyelikleri); sanat etkinliklerine davetli katılım satırları; tezsiz yüksek lisans proje danışmanlığı; yönetim görevlerinde rektör yardımcılığı ve bölüm başkan yardımcılığı (tabloda satırı yok) | Toplantı düzenleyen adayın toplamı düşük çıkar; yönetim görevlerinde asgari süre koşulu (3-4 yıl) uygulanamadığı için o kalemde puan tersine yüksek görünür |
| **Ankara Bilim** | İndeks kapsamı dışındaki uluslararası hakemli dergiler (1.2.3); ansiklopedi konu ve madde yazarlığının üst satırları (1.5.1-1.5.3); tasarım alanında üretime girmiş çalışma/koleksiyon (2.4); film yaratıcı kadrosunun üst satırları (2.5.5-2.5.6, 2.5.8-2.5.9); restorasyon ekibi ve düzenleme kurulu satırları (2.8.2-2.8.3, 2.8.5-2.8.6); arkeolojik kazı kalemleri (6.1.9-6.1.14); laboratuvar çalışması (6.2.3-6.2.4); bilimsel ve sanatsal toplantı düzenleme bölümünün tamamı (6.4.1-6.4.18: seçici kurul, düzenleme kurulu, küratörlük, sergi organizasyonu, oturum başkanlığı); yurtdışı idari görev (6.5.4); 0,5 puanlık satırlar (atıf 1.7.3, oturum başkanlığı 6.4.18) | Sanat ve tasarım alanında çalışan adayın toplamı düşük çıkar; toplantı düzenleyen adayın toplamı düşük çıkar. Toplam barajlar (20/30/50) korpusun en düşükleri arasında olduğu için eksik bölümler eşiği fiilen kapatmıyor |
| **Abdullah Gül** | Dergi editörlüğü/yardımcı editörlük/editör kurulu üyeliği/özel sayı editörlüğünün tamamı (kaynak sözlüğü çeyrekliğe göre TEK grup etiketi taşıyor, ana editörlüğü kurul üyeliğinden ayıramıyor); toplumsal katkının çoğu (STK görevleri, bilirkişi raportörlüğü, teknik rapor, şirket kurma, teknopark projeleri, AGÜ Akademi); bilimsel alana/mesleğe katkının çoğu (kongre düzenleme kurulu, akademik yükseltme jüri üyeliği, yarışma jüri üyeliği, yayımlanmış proje/fikir projesi, uluslararası kuruluş komisyon üyeliği, sergi küratörlüğü, seçici kurul üyeliği); B grubu proje ve çok ortaklı/sanayi ortaklı proje kademeleri; kitap hakemliği; post-doc danışmanlığı, eğitim ödülleri, ders yükü/öğrenci değerlendirmesi/yaz-kış okulu satırları; Mimarlık biriminin "Yayımlanmış Proje/Uygulama/Fikir Projesi" alt tabanı (dayandığı madde girilemediği için); uluslararası ortaklı yayın bonusu (+%20); atıfın 0,5 ve 0,3 puanlık alt satırları | Editörlük yapan, toplumsal katkısı geniş ve disiplinler arası/sanayi ortaklı çalışan adayın toplamı düşük çıkar; Mimarlık biriminde KATKI'nın kendi alt tabanı hiç uygulanmıyor ama TOPLAM barajı geçerliliğini koruyor |
| **Adana Alparslan Türkeş** | Dergi editörlüğünün üst kademeleri (baş editör, yardımcı editör — kaynak sözlüğü çeyrekliğe göre TEK grup etiketi taşıyor); toplumsal katkı bölümünün tamamı (basılmış bilimsel/sanatsal rapor, sanat/sergi katalog yazarlığı, etkinlik düzenleme, TÜBİTAK öğrenci proje danışmanlığı/jüri üyeliği); üniversite-sanayi protokollü tez danışmanlığı (normal danışmanlıkla aynı kaynağa düşüyor, yüksek satır fazla sayardı); uluslararası/ulusal iş birlikli yayın bonusları (+%50/eşitleme); yurt dışı araştırma tecrübesi (30 puan, metrik puana çevrilemediği için); kitap ve kitap bölümü çevirisi dışındaki E3 (çeviri makale); ek baskı (D7) | Editörlük yapan, sanayi iş birlikli çalışan ve yurt dışı ortaklı yayını olan adayın toplamı düşük çıkar |
| **Afyonkarahisar Sağlık Bilimleri** | Web of Science h-faktörü × 20 (formül tabanlı puan); dört patent aşamasının (rüçhanlı/rüçhansız, incelemeli/incelemesiz) ayrı puanları tek satırda birleşti; SCI ile SCI-Expanded dergi/editörlük ayrımı tek etikette birleşti; kongre başkanlığı/görev alma, adayın çalışmaları hakkında yayın yapılmış olması, bilimsel toplantıya yalnızca katılmak, hizmet içi eğitime katılmak, Erasmus/Farabi/Mevlana koordinatörlüğü, soruşturma-inceleme görevi, uluslararası/ulusal meslek kuruluşu yönetim kurulu üyeliği/üyelik (L.5-L.6, L.9, L.11-L.14) | Editörlük yapan, yönetim kurulu üyeliği olan ve idari görevi çok yıllık olan adayın toplamı düşük çıkar |
| **Recep Tayyip Erdoğan** | 11. madde (sportif başarı ve temsil); 13.a (en az 15 özgün eser barındıran kişisel sergi — puan tek esere değil dosyaya veriliyor); 13.e h-indeksi ve 13.f-g yurt dışı araştırma süresi; 13.n eğiticilerin eğitimi; 5.f (AKDTYK projesi); ansiklopedi maddelerinin "üç madde bir kitap bölümü sayılır" kuralı | Sportif ve sanatsal kalemleri olan adayın toplamı düşük çıkar. Projelerde rol puanı bölündüğü için (yürütücü 1/1, araştırmacı 1/3, danışman 1/4) ROLÜ GİRİLMEMİŞ proje 0 puan alır |
| **Sinop** | Güzel Sanatlar temel alanının TAMAMI: Tablo GS2'nin satırları tek esere değil dosyaya puan veriyor ("a veya b bentlerinden en az 50 puan") ve bu alanın her kadrosunda GS2 barajı zorunlu — §0 istisnası uygulandı. Ayrıca Sinop'ta yapılan toplantı (4) ve Sinop dergilerinde editörlük (5) satırları; İlahiyat'ın 11. (sanatsal uygulama) ve Spor'un 12. (sportif faaliyet) maddeleri; patent başvurusu, h-indeksi, yurt dışı araştırma, öğrenci kulübü danışmanlığı, SEM dersi | Güzel Sanatlar alanında hiç eşik yok; diğer on bir alanda toplam düşük çıkar |
| **Sivas Bilim ve Teknoloji** | B1.9-B1.11 ders satırları (puan ders SAATİ başına, kayıt ders başına tutuluyor; bölümün tavanı 40 puandı); B1.12 laboratuvar altyapısı; A1.18 hakemsiz dergi, A2.7 ders notu, A4.12 reddedilen proje başvurusu, C1.3 ve C1.18 kongre kitabı editörlüğü, C1.14 ve C1.24 proje hakemliği, C1.26 TÜBA/TÜBİTAK üyeliği, B3.4 ve B3.10 sergi küratörlüğü | Ders veren adayın 40 puana kadar eksiği olur. Buna karşılık §0'dan İKİ YERDE sapıldı: `TÜBİTAK` etiketi A4.3 değerleriyle (yürütücü 100) girildi, Hızlı Destek (50) ve bilim-toplum projeleri (30) YÜKSEK puanlanıyor; `ESCI / Scopus` etiketi A1.2 ile (60) girildi, yalnız Scopus'ta taranan dergi aslında A1.6 (25) satırına girer |
| **Sivas Cumhuriyet** | K bölümünün tamamı (kazı ruhsatı, yüzey araştırması, kazı projesinde görev); A8 (Üniversiteye bağlı hakemli dergilerde makale) — MADDE 12(b)'nin "A8 kapsamında en az 2 makale" seçeneği de bu yüzden girilemedi; E5-E9 proje ve sanat etkinliği hakemliği; F4-F5 firma sahipliği; G7 teknopark danışmanlığı | Kazı çalışması olan adayın toplamı düşük çıkar; profesörlükte 12(b)'nin yalnız A1/A3/A4 seçeneği uygulanıyor |
| **Şırnak** | 4.3 (H indeksi × 5 — faaliyet değil ölçüt); 10. bölüm (koleksiyon) ve 11. bölüm (müzik teknolojisi); 7. bölümün başkanlık ve sekreterlik satırları; II.4 (sağlık eğitimi hizmetleri); 1.2.4 makale çevirisi, 5.6 yurt dışı proje ay puanı, 5.8 proje başvurusu, 8.2 ve 8.5 toplantı kitabı editörlüğü; Güzel Sanatların UYGULAMALI ve müzik alanlarına tanınan düşük eşikler (30 puan + toplam 50) | Dersler haftalık ders saati başına 1 puan olduğu hâlde ders başına sayılıyor (tavan 30); uygulamalı sanat ve müzik alanından başvuran aday koşulları olduğundan AĞIR görür |
| **Türk-Alman** | E türünün özet bildirileri — yönerge "poster hariç" diyor, kaynak sözlüğü ise sözlü özet bildiriyi posterden ayırmıyor, §0 uyarınca hiçbiri sayılmadı; G türüne girmeyen üniversite BAP projeleri; atıf, tez danışmanlığı, ders, editörlük ve idari görev (EK-1'de karşılığı yok) | Özet bildirisi olan adayın yeniden atanma puanı düşük çıkar |
| **Uşak** | 11. bölüm (yurt dışı araştırma çalışmaları, en fazla 20 puan — faaliyet değil süre ölçütü); 1b (SCOPUS makalesi, 13 puan) ve 1d (kitap kritiği yapılmış makale); 15c-15d koordinatörlükler ve kalite üyelikleri | SCOPUS makaleleri ESCI puanıyla (10) sayılıyor; yurt dışı araştırması olan adayın toplamı 20 puana kadar düşük çıkar. MADDE 6(1)(f)'nin bazı birimlerde puanın %60'ının aranması ve idari görev puanının doçentlik kriterinde kullanılamaması kuralları uygulanmıyor |
| **Van Yüzüncü Yıl** | MADDE 11'in %20 kotası için EK-4 ek kriterleri; EK-1, EK-2 ve EK-3 seçmeli kriter listelerinin yaklaşık üçte biri (sportif kariyer, bilimsel kazı, tonmaysterlik, web sayfası tasarımı, ders materyali geliştirme, mesleki rapor, sertifika programı eğiticiliği, sunum ödülü, etki faktörü, standart hazırlama, laboratuvar kılavuzu çevirisi) | Bu kriterler `beyan` düğümü olarak soruluyor ve motorda "belirsiz" dönüyor; adayın hangi kriteri sağladığını başvuru dosyasında belgelemesi gerekiyor. "1.1., 2.1. ve 3.1. dışındaki her kriterden en fazla üç etkinlik sayılır" ve "bir eser aynı kategoride bir kez kullanılır" kuralları uygulanmıyor, sağlanan kriter sayısı YÜKSEK görünebilir |
| **Yeditepe** | Bölüm ve program düzeyindeki ayrımların tamamı: Fen-Edebiyat'ın yedi bölümü (Çeviribilimi, Fizik, İngiliz Dili ve Edebiyatı, Matematik, Psikoloji, Rus Dili ve Edebiyatı, Türk Dili ve Edebiyatı), Güzel Sanatlar'ın özel yetenek sınavıyla ve merkezi yerleştirme puanıyla öğrenci alan programları, İletişim'in Görsel İletişim Tasarımı bölümü | `birim` ayrımı FAKÜLTE düzeyinde tutuldu; bu bölümlerden başvuran aday kendi bölümünün değil fakültenin genel koşulunu görür. Farklar aday notunda anlatılıyor ama DOĞRUSU bölüm bölüm girmek: Madde 7-(2), 8-(2) ve 9-(2)'deki bölüm listeleri sırayla `birim` olarak açılmalı. Çeyreklik isteyen koşullarda AHCI makaleleri de sayılmıyor (sözlük AHCI'ye çeyreklik vermiyor) |

## Motorun karşılayamadığı kurallar

Bunlar PDF sorunu değil; motorun bugünkü yapısıyla ifade edilemeyen kurallar.
Hepsi ilgili cetvelin `kapsam_notu` alanında adaya da söyleniyor.

- **Puan sütunu boş bırakılmış satır** — KOSTÜ'nün 50. satırı ("son beş yılda
  üniversite eğitim biriminde idari görevde bulunmak") puan yerine soru işareti
  taşıyor. Kaynakta sayı olmadığı için idari görev puanı hiç girilemedi; puan
  DÜŞÜK görünür.
- **Yüzdeye bağlı tavan** — Düzce (eğitim-öğretim %20, burs %10, idari görev
  %10), Manisa CBÜ (atıf %20), Karabük (E bölümü %10), Yalova (Sosyal ve
  Mimarlık'ta kitap %30, atıf %20, tez danışmanlığı %10 — hepsi "başvuru
  şartında istenen asgari puanın" yüzdesi, yani kadroya göre değişiyor). Motor yalnızca sabit
  grup tavanı tanıyor; bu kalemlerde puan **yüksek** görünür.
- **Çeyrekliğe bağlı çarpan** — Bandırma (Q1:2, Q2:1,5, Q3:1,25, Q4:1). En düşük
  çarpan alındı; Q1 makalesi olan adayın puanı **düşük** görünür.
- **Kategoriye göre farklı yazar formülü** — Bayburt (makalede kademeli, kitap ve
  bildiride 1/n) ve Yalova (MADDE 10/4: makalede başlıca yazara 0,8 / 0,5
  ayrıcalığı, "diğer yayınlarda (bildiri, kitap)" eşit bölüşme). Cetvel başına
  tek matris tanımlanabiliyor. Yalova'da her rolde İKİ KURALIN DÜŞÜĞÜ yazıldı;
  başlıca yazar olunan iki yazarlı makalede puan **düşük** görünür.
  **Bayburt'ta tersi yapılmış** — makale kuralı uygulanmış, çok yazarlı kitapta
  puan **yüksek** görünüyor. Bu, "eksik say, fazla sayma" kuralına aykırı;
  Bayburt cetveli Yalova'daki gibi düşük kurala çevrilmeli.
- **Tavanlı bonus çarpanı** — Yalova MADDE 10/3: "Makale yayımlandığı tarihte
  yayınlanan derginin Q1 veya Q2 indeksinde olması halinde puan hesaplanmasında
  %50 daha fazla puan verilir. Bu ek puan kapsamında en fazla 2 yayın
  değerlendirmeye alınır." Motor "en çok N faaliyete uygulanan çarpan"
  tanımıyor; ek puan hiç verilmedi, Q1/Q2 makalesi olan adayın puanı **düşük**
  görünür.
- **Kişi sayısına bölme** — Kilis (yardımcı araştırıcı puanı araştırıcı sayısına
  bölünüyor), Bitlis ve Bolu (çevirmen, editör, patent sahibi sayısına
  bölünüyor), Ankara Bilim (6.1.6, 6.1.8, 6.2.1 ve 6.2.2: "kişi sayısına
  bölünecektir"). Kilis'te araştırmacı satırları hiç girilmedi; diğerlerinde
  çarpan o kalemlerde uygulanmıyor ve puan YÜKSEK görünür.
- **Yıl ortalaması / görev süresi** — Hatay MKÜ, Bandırma, Bingöl, Bolu, Düzce,
  Karabük, Manisa CBÜ ve Iğdır'ın yeniden atanma koşulları. Atama dönemi
  uzunluğu profilde tutulmadığı için bu eşikler girilmedi.
- **Puanın görev yılıyla ÇARPILMASI** — Ankara Bilim EK1'in 6.5 ve 6.7.1
  satırları ("Yıl ile çarpılacaktır"): yöneticilik 3, yardımcılık 2, kurul
  üyeliği 1 puan × görev yılı. Motorun `puan` alanı sabit; her görev bir yıl
  sayılıyor ve yönetim puanı DÜŞÜK görünür. Bölmenin tersi bir sorun: aynı
  cetvelde 6.1 ve 6.2 kalemleri bölünemediği için puan yüksek, 6.5 kalemleri
  çarpılamadığı için düşük çıkıyor.
- **Cetvel satırının kendi kayan penceresi** — Ankara Bilim EK1'de editörlük
  "her yıl için (son 3 yıl)", tez ve jüri kalemleri "son 5 yılda", ders
  kalemleri "son iki yılda" diyor ama bu kadroların toplam puan barajında
  dönem kısıtı yok. Dönem yalnızca KOŞUL düğümünde tutulabiliyor, cetvel
  satırında değil; bu kalemlerde puan YÜKSEK görünür.
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
- **Tam sayıya inince kaybolan satır** — motorun `puan` alanı tam sayı tutuyor.
  Nişantaşı'nın "orkestra konserinde üyelik (yurt içi) 0,5 puan" satırı aşağı
  yuvarlanınca 0 ettiği için hiç girilmedi; o kalemde puan DÜŞÜK görünür.
- **Puan üreten formüller** — İTÜ Tablo 1'in D.1 ((h-indeksi − sınır) × 25),
  D.2 ((FWCI − 1) × yayın sayısı) ve K.1 (ders kredileri toplamı) kalemleri.
  Motorun `puan` alanı sabit sayı tutuyor. İTÜ'nün TOPLAM PUAN barajı bu
  yüzden hiç yazılmadı; eser puanı barajı etkilenmiyor çünkü ona yalnızca
  yayın türleri giriyor. Nişantaşı'nın G.4 "H-index × 5" satırı da aynı
  sebeple girilmedi.
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
- **Bir eseri iki koşulda birden saymak** — motor koşulları bağımsız
  değerlendiriyor, bir kaynak eserin başka bir koşulda kullanılıp
  kullanılmadığını izlemiyor (`donusumler`in kota takibi bunun tek istisnası).
  İzmir Demokrasi'nin tez ve proje telafileri ikisi de "N adet DAHA yayın"
  istiyor; tek yayını olan aday burada ikisini birden karşılamış görünür.
  Koşulu olduğundan KOLAY gösteren ender sapmalardan; ilgili eşiğin aday
  notunda söyleniyor.
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
- **Adet koşulu ile puan tabanının BİRLEŞİK telafisi** — Abdullah Gül'ün
  Mühendislik/Sosyal/Mimarlık/Ortak Dersler birimlerinde "en az 1 proje
  yürütücülüğü OLMASI ve puan tabanının sağlanması; ikisi de eksikse açığın
  N katı Q1/Q2 makaleden telafi edilir" diyor — tek cümlede bir ADET şartıyla
  bir PUAN şartını aynı telafiye bağlıyor. Motorun `telafi_carpani` alanı
  yalnızca `puan` düğümlerinde çalışıyor; adet şartı bu yüzden telafiden
  BAĞIMSIZ, her durumda arandı. Hiç proje yürütücülüğü olmayıp açığı yalnızca
  makaleyle kapatan (kaynaktaki telafi yolunu kullanan) küçük bir aday grubu
  için koşul olduğundan ZOR görünüyor; "eksik say" yönünde bir sapma.
- **Yıl biriktirme formülü (kümülatif toplam)** — Ankara Bilim'in aksine
  (orada tek satır sabit çarpandı), Abdullah Gül'ün idari görev dipnotu
  birikimli bir toplam istiyor: "ilk yıldan sonraki her yıl için (puan/n)
  kümülatif olarak ana puana eklenir" (n: o yıla kadar geçen yıl sayısı).
  Motorun `puan` alanı tek bir sabit sayı tutuyor, seri toplamı hesaplayamıyor;
  yalnızca ilk yıl değeri girildi, çok yıllık idari görevlerde puan DÜŞÜK
  görünür.
- **Eser bazlı tavan ("bir eserde en fazla N")** — Adana Alparslan Türkeş'in
  D2/E2 satırları ("bir eserde en fazla 2 bölüm puanlanabilir"): motorun
  `grup_tavanlari` yalnızca KATEGORİ/GRUP bazlı toplam tavanı tanıyor, TEK BİR
  ESERİN kendi içindeki tekrarları sınırlayan bir mekanizma yok. Aynı
  kitaptan üç veya daha fazla bölümü olan bir adayın puanı YÜKSEK görünür.
- **Grup tavanı KADRO/FAKÜLTEYE göre değişiyor ama cetvel tek tavan tutuyor**
  — Adana Alparslan Türkeş'in bildiri (B/C) grubu tavanı İİSBF'de sabit 100,
  Mimarlık'ta kadroya göre değişiyor (doçentlik 150, profesörlük 250).
  MEF/Işık'taki "cetvel varyantı" çözümü burada uygulanmadı (üç farklı tavan
  için üç varyant yerine); en düşük ortak değer (100) evrensel uygulandı —
  Mimarlık adayının B/C katkısı TOPLAM'a olduğundan az yansır, "eksik say"
  yönünde güvenli ama kaba bir sadeleştirme.
