# Girilemeyen Yönergeler

`pdf/` klasöründeki yönergelerden **veri girişi yapılamamış** olanlar ve
sebepleri. Amaç, aynı PDF'e ikinci kez girişip aynı duvara toslamamak: her
kayıt neyin çözüldüğünü, neyin çözülmediğini ve devam edildiğinde nereden
başlanacağını söylüyor.

Bir üniversite bu listeden ancak `database/data/yonerge/` altına eşiği ve
`database/data/cetvel/` altına cetveli girildiğinde çıkar.

## Bugünkü tablo

| Durum | Sayı | Kimler |
|---|---|---|
| **Gerçekten engelli** | 3 | Balıkesir, Türk Hava Kurumu, Maltepe — puanlama tablosu PDF'te YOK, belge dışarıdan gelmeli |
| **Okuma engeli çözüldü, giriş bekliyor** | 0 | — |
| **Kısmen girildi, kalanı korpus içinde hazır** | 0 | — |
| **Kısmen girildi, çizelge dışarıdan gelmeli** | 2 | SANKO, İstanbul Okan |

Yani **dışarıdan belge beklemeden yapılabilecek iş KALMADI**; listedeki beş
üniversite için ilgili üniversiteden puanlama ya da ölçüt tablosunu istemek
gerekiyor.

**Bu tablo 29.08.2026'da iki kez yeniden sayıldı.** İlkinde Karamanoğlu, Sağlık
Bilimleri ve Biruni girilmiş olmalarına rağmen üç hafta "giriş bekliyor"
satırında duruyordu; ikincisinde İstanbul Üniversitesi'nin Tablo 2'si AYNI GÜN
girilmiş olmasına rağmen hâlâ "kalanı korpus içinde hazır" sayılıyordu. Aynı
hata üç kez tekrarlandı: iş yapıldı, kayıt güncellenmedi. **Sayıyı
değiştirmeden önce motora sor**, dosya adına ya da bu tabloya değil:

```bash
php artisan tinker --execute '
$d = app(App\Services\Scoring\Sart\SartDeposu::class);
$e = array_filter($d->esikler(), fn($x) => $x["universite"] === "ÜNİVERSİTE ADI");
$c = []; foreach ($e as $x) { $c[$x["cetvel"] ?? "(yok)"] = true; }
printf("%d esik, cetvel: %s\n", count($e), implode(",", array_keys($c)));'
```

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

**"Metin katmanı yok" artık son söz değil.** Bu dosyanın uzun süre en kalabalık
engeli taranmış PDF'lerdi; makinede `tesseract 5.5` ve Türkçe dil paketi
bulunduğu anlaşılınca on iki dosyanın hepsinin okunabildiği görüldü. Çalışan
tarif ve tuzakları aşağıda "Okuma engeli çözüldü" başlığında. Bir dosyayı
"okunmuyor" diye kaydetmeden önce o tarifi dene.

---

## İstanbul Üniversitesi — Devlet Konservatuvarı alanları

**Dosya:** `pdf/1784016632886.istanbul-universitesi-kriter.pdf` (24 sayfa, 01/06/2026)

**Girildi:** Madde 9-12'nin dört alanı (Sağlık, Fen ve Mühendislik, Sosyal,
Mimarlık) dört kadroyla birlikte; Tablo 1 ve Tablo 4 cetvele çevrildi.

**GİRİLDİ** (29.08.2026, commit 2585197): Madde 13-15 (Müzik ve Sahne
Sanatları, Müzikoloji, Türk Müziği) girildi. Tablo 2'nin 39 satırı cetvele
çevrildi ve üçüncü bir varyant açıldı: `istanbul-2026-konservatuvar` = Tablo 1 +
Tablo 2. Üç bölüm `guzel_sanatlar` temel alanını paylaştığı için `birim` ile
ayrıldı; 12 yeni eşik. Konservatuvarın kadro sütunları ötekilerden farklı:
Dr. Öğr. Üyesi (İlk Atama) yalnız bir yayın koşulu istiyor, puan barajı yok.

Bu kayıt bir gün boyunca bayat kaldı — bkz. yukarıdaki "iki kez yeniden sayıldı"
notu.

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

**GİRİLDİ** (29.08.2026): Madde 2.11 (yedi alt alan) ve 2.12 (beş alt alan) üç
kadroyla girildi, 36 yeni eşik. Engel, Puanlandırma Formunun D bölümünün kaynak
sözlüğünde karşılıksız olmasıydı; `Kategori::SanatselEtkinlik`'e 19 etiket
eklenip (film, animasyon, TV, reklam, müzik teknolojisi, uygulanmış tasarım,
grup sergisi, kamusal alan yapıtı, küratörlük, festival koordinatörlüğü) bölümün
24-41 arası tamamlandı. 38-41 (çalgı, opera, bale, kompozisyon) neredeyse
bütünüyle MEVCUT etiketlerle karşılandı: Mersin TABLO C için açılmış konservatuvar
kümesi DEÜ'nün satırlarına birebir oturdu.

Üç yeni zorunlu puan kümesi açıldı: `ZORUNLU-GS-KURAMSAL` (33 dahil),
`ZORUNLU-GS-UYGULAMALI` (24-34 dahil), `ZORUNLU-KONSERVATUVAR` (38-41 dahil).
Barajlar altı sütunda da aynı (50/80, 120/200, 200/400); değişen tek şey küme.

On iki alt alanın hepsi `guzel_sanatlar` temel alanına düşüyor; ayrım yalnızca
`birim` ile kuruluyor ve program seçilmeden `bul()` null döner.

Yan bulgu: `ZORUNLU-MIMARLIK` yanlıştı. Küme 8.c ve 8.c.a'yı (üniversite-sanayi
projeleri) sayıyordu; Madde 1.10.1/c ile kadro puan çizelgelerinin ikisi de
mimarlık için "8.a, 8.b, 8.f" diyor. 8.c çıkarıldı, 8.f eklendi.

Girilemeyen kalanlar: 35.c.2 festivale eserle katılım ile 35.d atölye
yöneticiliği (etiketleri 24.a.2 ve 38.h'nin, girilseydi yüksek satırdan
sayılırdı), 36 retrospektif katalog, 37 ödüller (bütün satırları 18.a/18.b.1'e
düşüyor; 18 zaten her zorunlu kümede var), 38.d eşlikçilik ve dört alandaki
"öğrencinin ödül alması" satırları. Sözlükteki şeflik etiketlerinin yönergede
karşılık satırı yok.

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

## İstanbul Okan Üniversitesi — ölçüt belgesi ayrı, PDF'te yok (kısmen girildi)

**Dosya:** `pdf/17537100352.istanbulokanuniversitesi.pdf` (14 sayfa, taranmış;
OCR çıktısı `pdf-ocr/17537100352.istanbulokanuniversitesi.txt`)

**Bu bir puan yönergesi değil, PERSONEL yönergesi.** Elimizdeki belge
"Akademik Personel Yönergesi" (YG.OKN.025, Senato Kararı 10 / 17.07.2024);
otuz beş maddesi atama usulü, jüri kurma, izin, ücret ve mesai düzenliyor.
Puan cetveli, puan barajı ya da ölçüt tablosu YOK — üstelik eksik değil,
hiç olmaması gerekiyor: yönerge kendisi ayrı bir belgeye atıf yapıyor.

**Devrettiği belge:** MADDE 7/1/e, 8/1/c ve 9/1/d üç kadroda da aynı cümleyi
tekrarlıyor — "Adayın, **Akademik Yükseltme ve Atama Ölçütlerini** sağlayıp
sağlamadığı … Atama ve Yükseltme Komisyonu tarafından değerlendirilir.
Ölçütleri sağlamadığı tespit edilen adayların başvuruları kabul edilmez."
O belge korpusta yok ve YÖK'ün yönerge sayfasından da bu dosya geliyor.

**Girildi.** Balıkesir, Türk Hava Kurumu ve Maltepe'den farkı, gövdenin somut
bir akademik ölçüt taşıması: kadro başına BİR YAYIN şartı.

- Dr. Öğr. Üyesi (MADDE 7/1/d) ve Profesör (MADDE 9/1/e): ulusal veya
  uluslararası **endekslerde taranan** hakemli dergilerde en az bir yayın.
- Hukuk Fakültesi (MADDE 7/1/f-1, 9/1/f-1): endeks şartı yok, "ulusal veya
  uluslararası **hakemli** dergilerde en az bir (1) yayın" — bu yüzden
  endekssiz hakemli dergi satırı (ÜAK 2b) de sayılıyor.
- Sanat, Tasarım ve Mimarlık (MADDE 7/1/f-2, 9/1/f-2): endeksli dergide yayın
  YA DA uluslararası kişisel/karma etkinlik (sergi, bienal, performans,
  gösterim, festival, film, yarışma). İkinci dal beyan; ÜAK cetvelinde
  sanatsal etkinlik kalemi yok.
- Doçent (MADDE 8): **yayın şartı hiç yok.** Yalnızca ÜAK doçentlik unvanı
  isteniyor. Dr. Öğr. Üyesi ve profesörlükteki bir yayın şartının doçentlik
  karşılığı yönergede YAZMIYOR; uydurulmadı.

Kendi puan tablosu olmadığı için cetvel `uak-2024-mart-{alan}`;
`Kalip::toplam` HİÇ kullanılmadı (yönergede puan barajı yok, yazmak olmayan
bir baraj uydurmak olurdu).

**Devir düğüm olarak yazıldı.** Üç kadronun her eşiğinde ölçüt belgesi
`Kalip::hesaplanamiyor` olarak duruyor, yani hiçbir eşik "sağlandı"ya
düşemiyor. §0 gereği bu şart: yalnız yayın şartını gösterip yeşile boyamak,
adayı hiç görmediğimiz bir ölçüt listesine karşı hazır göstermek olurdu.
`aday_notu` da bunu açıkça söylüyor.

**Girilmeyenler:** MADDE 28'in YDS/YÖKDİL 85 puanı bir atama şartı değil,
yabancı dil TAZMİNATI ödeme ölçütü — atama koşuluna çevrilmedi. Yeniden
atanma da girilmedi: MADDE 11 sözleşme yenilemeyi Rektör önerisi ve Mütevelli
Heyet onayına bağlıyor, sayısal ölçüt vermiyor.

**Devam edilirse:** "Akademik Yükseltme ve Atama Ölçütleri" belgesi İstanbul
Okan Üniversitesinden ayrıca istenmeli. Geldiğinde yapılacak iş, cetveli
üniversitenin kendi tablosuna çevirmek ve `hesaplanamiyor` düğümlerini gerçek
koşullarla değiştirmek.

---

## Okuma engeli çözüldü — on iki dosya, biri hâlâ giriş bekliyor

Bu on iki dosya uzun süre "taranmış", "bozuk font" ya da "kötü OCR" diye
bekliyordu. Engel PDF'lerde değil elimizdeki araçlardaymış: makinede
`tesseract 5.5.3` ve `tur` dil paketi var. **Hepsi okunuyor**, hiçbiri artık
kaynak sorunu değil. On biri (Karamanoğlu, Sağlık Bilimleri, Biruni, İstanbul
Okan, Kırklareli, Bilecik, Tekirdağ NKÜ, Munzur, Çankaya, Piri Reis, Karadeniz
Teknik) girildi; kalan biri veri girişi bekliyor.

**ÇIKTILAR ZATEN DEPODAYMIŞ.** Bu başlık yazılırken fark edildi: `pdf-ocr/`
klasörü 8 Ağustos 2026'da bu dosyaların OCR çıktılarıyla doldurulmuş ve
`.gitignore`'a alınmış; bu belge ise üç hafta boyunca "hiçbiri okunamıyor"
demeye devam etmiş. Yeniden üretilen çıktılar eskileriyle BAYT BAYT AYNI
çıktı. Bir kaydı ele almadan önce `pdf-ocr/` altına bak; tarif yalnız orada
karşılığı olmayan dosyalar için gerekiyor.

### Çalışan tarif

```bash
pdftoppm -r 300 -png "pdf/DOSYA.pdf" "$SC/ocr/ad"          # sayfaları 300 dpi PNG
for f in "$SC"/ocr/ad-*.png; do
    tesseract "$f" "${f%.png}" -l tur                      # PSM VERME — varsayılan (3) doğru
done
cat "$SC"/ocr/ad-*.txt > "$SC/ocr/ad.txt"
```

**DÖRDÜNCÜ TUZAK — DİKEY BAŞLIKLI DAR SÜTUN OCR'DA HİÇ ÇIKMAZ.** Kırklareli'nin
EK-I tablosunda A (Makaleler), B (Bildiriler) ve Ç (Çeviriler) bölümlerinin puan
sütunu tesseract çıktısında YOKTU; aynı çalıştırmada C, D ve E bölümlerinin
puanları temiz okundu. Sebep sütunun dar olması ve başlığının DİKEY yazılması
("PUAN"). Bu, "OCR bozuk" değil "bir sütun düştü" durumudur; kırpıp gözle
okumak yetiyor:

```bash
magick pg-07.png -crop 40%x100%+1987+0 +repage -resize 900x pg07-right.png
```

Sağ şeridin satır sırası soldaki gövdeyle birebir eşleşiyor, satır satır
karşılaştırılabiliyor. `sips` kırpma için yetmiyor (offset alamıyor), `magick`
kurulu.

**Üç tuzak, üçü de denendi ve doğrulandı:**

1. **`--psm 6` PUAN SÜTUNUNU YOK EDİYOR.** Biruni'nin Ek-1 tablosunda `--psm 6`
   ile puanlar `|O1ı| 80 |`, `92|) 15 |` gibi çöp çıkıyor; PSM vermeden
   (varsayılan 3) aynı tablo `80 / 60 / 20 / 15 / 10` diye temiz okunuyor.
   Tablolu belgede asla PSM zorlama.
2. **Bazı sayfalar 180° dönük.** Piri Reis'in 13. sayfası ters basılmış;
   ham OCR `IğnLıy dey KA 1970 "njou guLınsere` gibi okunuyor.
   `sips -r 180 sayfa.png --out donuk.png` ile çevirince aynı sayfa
   `EK-1 ÖĞRETİM ÜYELİĞİNE YÜKSELTİLME VE ATANMALARDA KULLANILACAK PUANLAR`
   oluyor. `osd.traineddata` kurulu, `--psm 0` ile yön tespiti de yapılabilir.
3. **`ocrmypdf` bu makinede ÇALIŞMIYOR** (`ImportError: No module named expat`).
   Doğrudan `pdftoppm` + `tesseract` kullan, ocrmypdf'i deneyip zaman kaybetme.

`17537003802.mersinuniverstesi.pdf` de taranmış ama Mersin korpusta zaten var;
başka bir kaynaktan girilmiş, bu listeye dâhil değil.

**OCR sonrası her puan tablosu kaynakla karşılaştırılmalı.** Sayı okuma hatası
puanı sessizce bozar; prova cümlesi olarak tablonun en kalabalık satırını ve
yazar oranları tablosunu seç.

**TEKİRDAĞ BUNUN KANITI.** EK-2 tablosunun OCR çıktısı temiz görünüyordu; puan
sütununu sağ şerit kırpmasıyla karşılaştırınca üç sessiz hata çıktı: TR Dizin
makalesi 3 okunmuş (doğrusu 13), BKCI kitap bölümü 20 (doğrusu 25), TÜBİTAK
büyük projede görev alma 75 (doğrusu 25). Üçü de tek başına makul sayılar
olduğu için gözden kaçardı. Puan sütununu HER ZAMAN görüntüden doğrula.

### Dosyalar

| Üniversite | Dosya | Sayfa | Eski teşhis | Doğrulanan durum |
|---|---|---|---|---|
| Karadeniz Teknik | `17536999312.karadenizteknikuniverstesi.pdf` | 48 | taranmış | OCR temiz ama beş sütunlu koşul tabloları kolonlara bölünüyor; sayılar görüntüden okundu — **GİRİLDİ** |
| Karamanoğlu Mehmetbey | `17536999512.karamanoglumehmetbeyuniverstesi.pdf` | 15 | taranmış | OCR temiz — **GİRİLDİ** |
| Tekirdağ Namık Kemal | `17537009192.tekirdagnamikkemaluniverstesi.pdf` | 19 | taranmış | OCR temiz görünüyordu ama **puan sütununda üç sessiz hata** vardı; gözle doğrulandı — **GİRİLDİ** |
| Kırklareli | `1770040975746.kirklareli-kriter-02022026.pdf` | 18 | taranmış | OCR temiz ama **A, B ve Ç bölümlerinin puan sütunu çıkmadı** — sağ şerit kırpılıp gözle okundu; **GİRİLDİ** |
| Bilecik Şeyh Edebali | `1785927020751.bilecik-seyh-edebali-kriter-16102025.pdf` | 18 | taranmış | OCR temiz — **GİRİLDİ** |
| Sağlık Bilimleri | `1765867210191.saglik-bilimleri-kriter-16122025.pdf` | 11 | taranmış | OCR temiz — **GİRİLDİ** |
| Piri Reis | `17634009071.Piri Reis Üniversitesi Kriter.pdf` | 25 | taranmış | OCR temiz, **EK-1 yan yatık ve 19. sayfa 180° ters**; döndürülüp gözle okundu — **GİRİLDİ** |
| İstanbul Okan | `17537100352.istanbulokanuniversitesi.pdf` | 14 | taranmış | OCR temiz — **GİRİLDİ** (puan tablosu yok, kendi başlığına bakın) |
| Biruni | `17537097592.biruniuniversitesi.pdf` | 6 | taranmış | OCR temiz (PSM tuzağı burada bulundu) — **GİRİLDİ** |
| Munzur | `17634002431.Munzur Üniversitesi Kriter.pdf` | 19 | kötü OCR | **gömülü metin katmanı çöp, görüntüden yeniden OCR tertemiz**; puan sütununda sekiz sessiz hata gözle düzeltildi — **GİRİLDİ** |
| Çankaya | `17537097862.cankayauniversitesi.pdf` | 25 | bozuk font (cmap) | OCR font sorununu tamamen atlıyor — **GİRİLDİ** (puan tablosu yok, kriter sayan yönerge) |
| Burdur Mehmet Akif Ersoy | `17536991522.burdurmehmetakifersoyuniverstesi.pdf` | 13 | "yönerge değil, üst yazı" | **TEŞHİS YANLIŞMIŞ**, 3-13. sayfalar görüntüden okundu — **GİRİLDİ** |

### Burdur: teşhis yanlıştı

Dosya "YÖK'e gönderilen üst yazı, ölçüt metni ve puan tablosu yok" diye
kayıtlıydı. Doğrusu: **1-2. sayfalar** üst yazı (17/02/2016 tarihli yönerge
değişikliği yazısı, metin katmanı var), **3-13. sayfalar** ise yönergenin
kendisi ve TARANMIŞ. Gömülü metin katmanının o sayfalarda 1 bayt olması
"ölçüt yok" diye okunmuş. 7. sayfanın OCR'ı ölçüt metnini net veriyor:

```
l inci, 2 nci, 3 üncü ve 4 üncü maddelerde belirtilen dergilerde yayımlanan teknik
not, editöre mektup, tartışma, vaka ve özet türünden yayınlar: Adı geçen
maddelerde belirtilen puanların yarısı uygulanır.
Bildiriler
```

Ders: bir PDF'in ilk iki sayfasında metin katmanı bulunması, kalanında da
bulunduğu anlamına gelmiyor. Sayfa sayfa `pdftotext -f N -l N ... | wc -c`
çalıştır.

**GİRİLDİ** (29.08.2026): tarama temiz olduğu için sayfalar 150 dpi'da görüntü
olarak okundu ve puan sütununun tamamı böyle doğrulandı. Çizelge 65 madde,
`cetvel/burdur-2016.php`; eşikler `yonerge/burdur.php`, üç kadro × on iki temel
alan = 36 eşik. Yönergenin kendine özgü yanı, barajın İKİ KATMANLI olması
(toplam puanın yanında "1-24. maddelerden" ayrı bir eşik) ve taban puan
tablosunun ALAN AYRIMI YAPMAMASI — tek satır bütün alanları kapsıyor.
Girilemeyenler: 65. maddenin sportif faaliyetlerinin tamamı, uluslararası
başvuru kitaplarındaki atıflar, yeniden atanma eşiği ve çizelgenin yıl/eser
bazlı adet sınırları (motorda böyle bir sınır yok, bu kalemlerde puan yüksek
çıkabilir).

### Çankaya: şifre de çözülmüştü, ama OCR daha kısa yol

Kayıtta "ASCII harfler +29 kaydırmalı, rakamların nasıl kodlandığı bilinmiyor"
yazıyordu. **Rakamlar da aynı kaydırmada:** kural `32 <= ord(c) <= 97` değil,
**3'ten itibaren bütün baytlar +29**. Ham `\x14\x10` → `1-`, `\x03` → boşluk,
`\x15\x18\x17\x1a` → `2547`, `\x19\x12\x14\x14\x12\x14\x1c\x1b\x14` →
`6/11/1981`. Eski betiğin alt sınırı 32 olduğu için rakamlar ve boşluklar
düşüyordu, "bilinmiyor" tanısı oradan gelmiş.

Yine de **OCR yolu tercih edilmeli**: dosyada İKİ ayrı bozuk font var. Gövde
Latin-1 kümesini (`Õ ú | ÷ ø` …) kullanıyor, tablolar ise U+0100-U+03F5
aralığında ikinci bir küme (`Ğ Ă ŝ ů Ŷ ƌ`; rakamlar U+03EC-U+03F5 aralığında
sıralı duruyor). İkinci fontun harf haritası glif sırasına bağlı ve elle
çıkarılması gerekir — 25 sayfayı OCR'lamak daha ucuz ve daha az riskli.

---

# Kısmen girilen yönergeler

Aşağıdaki üniversiteler korpusa girdi, ama bir bölümü cetvele giremedi. Üç
sebepten biri: (1) yönergenin o parçası kaynak PDF'ten çıkarılamadı, (2) kalem
`Kategori::kaynaklar()` sözlüğünde karşılıksız ya da komşu bir satırla aynı
etikete düşüyor, (3) yönerge o kalemi zaten hiç saymıyor. Üçü de adayın gördüğü
puanı etkilediği için burada; hangisi olduğu satırın kendisinde yazıyor. Her
kayıt ilgili cetvel dosyasının başlığında ve `kapsam_notu` alanında da
anlatılıyor — ayrıntı orada, bu tablo yalnızca dizin.

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
| **Karadeniz Teknik** | 1g-1i kongre bildirisinin dergide yayımlanması (20 puana kadar); TR Dizin dışındaki ulusal hakemli dergilerdeki makaleler (tabloda satırı yok); 2b, 2ç, 2d, 2e çeviri editörlüğü kademeleri; 3d-3f ondalıklı kitap ve patent atıfları; 4a TÜBİTAK 2244 ve YÖK 100/2000 tez danışmanlığı; COST öneren ve kamu-üniversite-sanayi proje satırları; 10/A-d laboratuvar kurma, 10/A-e teknokent şirketi, 10/A-h radyo-TV söyleşisi, 10/B kazı başkanlığı ve resmi görevlendirmeler, 10/C-n üniversite eğitim projeleri | REKTÖRLÜK, DEKANLIK VE MÜDÜRLÜĞÜN TABLODA SATIRI YOK; bu görevlerden puan alınmıyor. PROJE BÖLÜMÜNÜN TAMAMI "devam eden" değerlerinden sayılıyor (tamamlanmış projeye iki katı veriliyor ama kayıt bunu ayırmıyor); kamu ve özel sektör projelerinde bütçe basamakları bilinmediği için en düşükten. Başlıca yazar, tez danışmanlığı ve proje koşullarının "eksik başına ilave makale" telafileri eksik miktara bağlı olduğu için `hesaplanamiyor`. Dr. Öğr. Üyeliğinin 89 günlük yurt dışı indirimi ile "KTÜ 50/d doktora mezunu" sütunu girilmedi; yeniden atanma da (uzatma yılı × 10 puan) girilmedi. Eğitim, hukuk, ilahiyat, spor ve güzel sanatlar yönergenin ek listesinde hiç yok, kapsam dışı |
| **Piri Reis** | N. EĞİTİME KATKI bölümünün tamamı (puan derse değil BLOĞA veriliyor: "dört farklı yarıyılda ders vermiş olmak, 2 puan"); H h-indeksi; B.2 Piri Reis Üniversitesi dergileri (6); L.1.d patent BAŞVURUSU; R.1.a yurt dışı araştırma (5); R.1.b-R.1.e toplantı düzenleme ve bilim kurulu üyelikleri (5/4/3/2) | Ödül bölümü YALNIZCA YÖK, TÜBİTAK ve TÜBA ödüllerini sayıyor; başka bilim ya da sanat ödülünün tabloda satırı yok. "Lisansüstü tezlerden üretilmiş yayın" koşulları `hesaplanamiyor` (tabloda tez yayını satırı yok). Hukuk ve Sosyal doçentliğinin "yayınların üçü FARKLI DERGİDE" koşulu dergi adı tutulmadığı için değerlendirilemiyor. MADDE 4/2 ile MADDE 9'un yazar kuralları çatışıyor; daha özel olan MADDE 9 uygulandı. Sağlık, eğitim, ilahiyat, filoloji, spor, ziraat, mimarlık ve güzel sanatlar yönergede hiç anılmıyor, kapsam dışı |
| **Çankaya** | Özel kriterlerin kayıttan okunamayan yarısı: h-indeksi, "bir eserine N atıf" kırılımları, davetli konuşmacılık ve panelistlik, hakemlik sayısı, özel sayı konuk editörlüğü, kitap çevirisi, kişisel/karma sanat etkinliği, proje yarışması ödülü, tasarım atölyesi ürünleri ve atölye düzenleme; doçentlik sözlü sınav belgesi olmayanın 2 makalelik ek şartı; "tezlerden üretilmemiş olmak" filtresi | PUAN TABLOSU YOK, kriter sayan yönerge; ÜAK doçentlik cetveline bağlandı ve `Kalip::toplam` hiç kullanılmadı. Sayılamayan özel kriterler `beyan` olduğu için `Kalip::kIle` sayımı belirsiz kalıyor; aday kaç kriteri belgeyle sağladığını kendisi görüyor. Sağlık, Eğitim, İlahiyat, Spor, Ziraat ve Güzel Sanatlar yönergede hiç anılmıyor, kapsam dışı. Dr. Öğr. Üyesi yeniden atanması (30 aylık dönem) girilmedi |
| **Munzur** | G. SPORTİF ETKİNLİKLER bölümünün tamamı (11 satır, 100 puana kadar); A7 h-indeksi; C5 sertifika programları; C9 dolaşım programları; C2.11-C2.12 yurt dışı araştırma (ay başına puan); C2.19 TÜBİTAK ARDEB başvurusu; C4.1-C4.2 patent BAŞVURULARI; C1.2 ve C1.4 devam eden tez danışmanlıkları; B1.6, B2.2, A3.9-A3.10, B3.4-B3.5, D1.2, E1.6-E1.8, F2.6-F2.7, F5.7-F5.12 | A2.1'in TÜBİTAK-sanayi ve uluslararası iş birliği için verdiği 1,25 katı çarpanlar kayıtta karşılığı olmadığı için uygulanmıyor. Bildiriler toplantıyı düzenleyen kuruluşa göre üç bölümde puanlanıyor; ayrım kayıtta olmadığı için daima EN DÜŞÜK bölümden sayılıyor. C8 idari görev bölümünün "diğer bölümlerin toplamının %20'sini aşamaz" tavanı motorda ifade edilemiyor, idari görevi çok olan adayın puanı yüksek çıkar. Doçentlik ve profesörlüğün "lisansüstü tezleri kapsamı dışında" filtresi uygulanamıyor. Hukuk ve İlahiyat yönergede hiç anılmıyor, kapsam dışı |
| **Tekirdağ Namık Kemal** | 10. SPORTİF ETKİNLİKLER bölümünün tamamı (17 satır, 25 puana kadar); 13. ÇALIŞTAY-KONGRE-SEMPOZYUM bölümünün tamamı (12 satır); 15. KAZI ÇALIŞMALARININ tamamı (7 satır); 7.1-7.5 panelistlik ve panel yöneticiliği; 5.9 h-indeks, 5.10-5.11 adayın adıyla anılan formül ve şekiller; 16.1 yurt dışı deneyimi; 19.1 yabancı dil puanı; 1.7, 3.11-3.14, 8.1-8.3, 8.24-8.25, 9.24-9.26, 12.7-12.8, 18.6-18.10 | Spor Bilimleri adayının toplamı belirgin biçimde düşük çıkar. BESTECİLİK KALEMLERİ HİÇ PUAN ALMIYOR: yönergenin sanat bölümü icrayı sayıyor ama eser bestelemeye satır ayırmamış — eksik olan eşleme değil, tablonun kendisi. Hakemliğin on bir kademesi tek etikete düştüğü için en düşükten (5 yerine 1) sayılıyor. Dr. Öğr. Üyesi yeniden atanması (üç, iki ve bir yıllık üç sütun) girilmedi |
| **Bilecik Şeyh Edebali** | EĞİTİM-ÖĞRETİM bölümünün ders satırı (H.1; puan haftalık ders SAATİ başına 0,1, on saat bir puan); J bölümünün tamamı (kurum dışı araştırma, üç ay ve üzeri yurt dışı bulunma, 20/15/10/5); L.1 h-indeksi, L.2 düzenleme kurulu başkanlığı, L.4 etkinlikte görev alma, L.8 probleme dayalı öğrenim, L.9 hastane poliklinik faaliyeti; K.4-K.5 kongre bilim/sanat kurulu ödülleri; F.5 lisanslanan faydalı model; M.12 ve M.13 | Doçentlik ve profesörlüğün "H maddesinden en az 4/6 puan" koşulu ile Sağlık Bilimlerinin L.9 kolu `hesaplanamiyor` düğümü olarak duruyor. Yazar matrisi kitap ve bildiride EŞİT bölünmesi gerekirken makale kuralıyla hesaplandığı için çok yazarlı kitapta başlıca yazarın puanı yüksek çıkar. Dr. Öğr. Üyesi yeniden atanması (Tablo 2) hiç girilmedi |
| **İstanbul Okan** | Üniversitenin "Akademik Yükseltme ve Atama Ölçütleri" belgesi (yönergenin MADDE 7/1/e, 8/1/c ve 9/1/d'de devrettiği ayrı belge; PDF'te yok). Elimizdeki dosya puan cetveli DEĞİL, personel yönergesi | Puan barajı hiç gösterilemiyor — yönergede de yok. Her eşikte ölçüt belgesi `hesaplanamiyor` düğümü olarak duruyor, bu yüzden hiçbir kadro "sağlandı"ya düşmüyor; hesaplanan tek şey kadro başına bir yayın şartı. Doçentlikte yayın şartı yönergede hiç yok |
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
| **Aksaray** | E.8 (h-indeksi ≥5'e sabit 8 puan); F.7 (uygulanmış tasarım projesi hakkında yazı), F.8-F.9 (spor ve sağlık ihtisaslaşma projeleri), F.13-F.19 (arkeolojik kazı, restorasyon, yüzey araştırması); I.5 patent başvurusu | Kazı, restorasyon ve ihtisaslaşma projesi olan adayın toplamı düşük çıkar |
| **Alanya** | A.3 (adayın adıyla anılan denklem, şema, tablo); C.3 TÜBİTAK proje hakemliği (dergi hakemliği satırından sayılıyor); F.3 merkez eğitimlerinde görev; J üye olunan mesleki kuruluşlar; K'nın "yürütücü olarak BAŞVURU yapmak" satırları | Proje önerisi ve mesleki üyelikleri olan adayın toplamı düşük çıkar |
| **Bartın** | H bölümünün TAMAMI (h-indeksi kademeleri); E.3, F.2, F.4 patent/faydalı model/tasarım başvurusu; B.15-B.18 | h-indeksi yüksek adayın toplamı düşük çıkar; Tablo-1 ölçüt 14.a ile Tablo-2 ölçüt 9.a'nın yardımcı dalı da kapanıyor |
| **Bursa Teknik** | E bölümünün TAMAMI (atıf ve h-endeksi): E.1 puanı "atıf katsayısı × 2" biçiminde bir ORTALAMA, faaliyet başına puan değil; B.7 ders notu, B.8 laboratuvar kılavuzu | Atıf kaydı olan adayın puanı olduğundan DÜŞÜK görünür |
| **Çanakkale Onsekiz Mart** | 11. ve 12. bölümün (Devlet Konservatuvarı ve Güzel Sanatlar etkinlikleri) çoğu bendi; ULAKBİM dışı ulusal hakemli dergiler (Tablo-2 fiyatlandırmıyor) | Konservatuvar ve Güzel Sanatlar adayının toplamı düşük çıkar |
| **Dicle** | L2 (SCI dışı dergi ve tezlerde atıf, 0,5 puan — tam sayıya yuvarlanınca sıfırlanıyordu, L3'ün 1 puanlık satırına bağlandı); D1c/D2c proje başvurusu; F1/F4 panel yöneticiliği ve oturum başkanlığı, F7 bilim kurulu üyeliği | Toplantı görevleri olan adayın toplamı düşük çıkar |
| **Erzurum Teknik** | C4 konferans kitabı/özel sayı editörlüğü (20); E6 TEYDEB danışmanlığı (40); H8-H11 çalıştay yürütücülüğü, bölüm içi seminer, yarışma danışmanlığı; M3 girişimcilik; L1/L2 patent başvurusu, E8 desteklenmeyen proje önerisi | Editörlük ve çalıştay görevleri olan adayın toplamı düşük çıkar |
| **Eskişehir Osmangazi** | 14. maddenin TAMAMI (eğiticilerin eğitimi, PDÖ sertifikaları); 18. madde (diğer etkinlikler); 5d teknopark danışmanlığı; 3h-3j tez yayınından üretilmiş bildiriler; 8j panelde değerlendirilmiş ama kabul edilmemiş proje | Sertifika ve teknopark kalemleri olan adayın toplamı düşük çıkar |
| **Eskişehir Teknik** | 7b (uygulanmış tasarım projesi hakkında yazı) ve 7c (yazılım üreticiliği) — 7ç ile aynı etiket ailesine düşüyorlardı; 12b eğitim sertifika programı, 12d öğrenci takımı danışmanlığı | Tasarım projesi ve yazılım üreten adayın toplamı düşük çıkar |
| **Gebze Teknik** | 11.1 küratörlük (yalnız Mimarlık sütununda 15/8); 9.3 yardımcı öğretim elemanlığı; 4.6 GTÜ "Yılın Bilim İnsanı" ödülü; faydalı model, ıslahçı hakkı, ansiklopedi maddesi ve akreditasyon faaliyeti etiketleri | Mimarlık adayının küratörlük puanı hiç sayılmıyor |
| **Iğdır** | 5 hakemsiz dergi/gazete yazısı; 13.b, 14.b ve editör YARDIMCILIĞI (sözlükte editörlükten ayrılamıyor); 18.c, 19.a atıf kaynak ayrımı; 21.c tezsiz yüksek lisans; 24.a, 25.a sempozyum başkanlığı | Editör yardımcılığı ve toplantı başkanlığı olan adayın toplamı düşük çıkar |
| **Isparta Uygulamalı Bilimler** | Tablo 1: hakemsiz dergi yayını, TTO buluş bildirimi; Tablo 2: öğrenci proje yarışması ve kulüp danışmanlığı; Tablo 3'ün puanı PORTFÖYE bağlı satırı | Öğrenci danışmanlığı ve buluş bildirimi olan adayın toplamı düşük çıkar |
| **Işık** | A.4 g-m (bestecilik, sanat sözlüğünde yer alma, hakkında kitap/tez yazılması); A.2.2 hakemsiz dergi, A.2.1c ve A.2.5 çeviriler; C.6-C.8 mimari eser sınıfları; E.2-E.4 yarışma dereceleri (tek 'Yarışma Derecesi / Mansiyon' satırına indi), koleksiyon ve müze seçimleri; F.1-F.6 editörlük ve hakemlik | Sanat, mimarlık ve editörlük kalemleri olan adayın toplamı düşük çıkar |
| **İbn Haldun** | 1.1.8.1/1.2.8.1 tarihî eserlerin latinizasyonu (300 sayfa başına); 1.1.9/1.2.9 makale ve kitap bölümü çevirileri; 1.1.11/1.2.11 başkalarının çalışmaları hakkında kritik; 1.1.7/1.2.7 dergi özel sayısı ve konferans kitapçığı editörlüğü; 1.1.1.6 editöre mektup ve vaka analizi | Latinizasyon ve çeviri çalışması olan adayın toplamı düşük çıkar |
| **Kafkas** | Bilimsel toplantı bölümünde ÖZET ve POSTER bildirilerin tamamı — yönerge "poster hariç" diyor, kaynak sözlüğü özet ile posteri tek etikette taşıyor, §0 uyarınca yalnız tam metin girildi; patent başvurusu; kurumsal katkıda rektörlük ve dekanlık (yönergenin listesinde yok) | Yalnız özet bildirisi olan adayın bildiri puanı sıfır görünür |
| **Kahramanmaraş Sütçü İmam** | Tablo 3/5 h-indeksi; Tablo 1/8 yurt dışı çalışma (10); Tablo 3/11 spor branşlarında görev, 3/12 öğrenci danışmanlığı, 3/9 soruşturma; Tablo 1/3-k makale çevirisi; Tablo 1/7-d ulusal poster (0,5 — yuvarlanınca sıfırlanıyordu); patent başvuru satırları | h-indeksi, yurt dışı çalışması ve spor görevi olan adayın toplamı düşük çıkar |
| **Kastamonu** | 9. bölümün antrenörlük, spor hakemliği, halkla ilişkiler ve reklam satırları; 10. bölümün marka tescili, TTO buluş bildirimi, teknopark ortaklığı ve laboratuvar satırları; Kastamonu Üniversitesi Yayınevi (3/k, 3/l, 4/d, 4/e) ve KÜ dergileri (13/d, 13/e); patent ve proje başvuru satırları | Spor, girişimcilik ve kurum yayını kalemleri olan adayın toplamı düşük çıkar |
| **Kayseri** | Hakemsiz dergi yayını, indeksli dergide özet, kitap eleştirisi, makale çevirisi, spor branşlarında görev, soruşturma, lisans ve kulüp danışmanlığı; Tablo 2'nin "adayın adı ile anılan formül, şema, grafik, tablo ve resim" satırı; patent/faydalı model başvurusu ve TTO buluş bildirimi | Spor ve öğrenci danışmanlığı kalemleri olan adayın toplamı düşük çıkar |
| **Kırıkkale** | 4.4.6 basılmış ders notu; 4.7.8 sanat/sergi katalog yazarlığı; 4.13.3-4.13.4 Bologna etkinlikleri ve öğrenci değerlendirmesi; 4.15'in laboratuvar, kamp, yarışma düzenleme, kurs ve teknopark satırları; 4.6'nın spor hakemliği ve antrenörlük satırları; 4.9.2 patent başvurusu (100) | Spor ve etkinlik düzenleme kalemleri olan adayın toplamı düşük çıkar |
| **Kırşehir Ahi Evran** | 13.A (İlahiyat sanatsal icra), 13.B (Mimarlık yarışma ve yazılım), 13.C (Spor Bilimleri sportif başarı) — tek temel alana kilitli tablolar, cetvel alana göre bölünmediği için girilmedi; Ek-1 madde 3 (kurumsal katkı, en çok 12 puan — yalnız asgari sayının ÜSTÜNDEKİ faaliyetlere veriliyor); 10.d patent başvurusu | İlahiyat, Mimarlık ve Spor adaylarının alana özgü kalemleri hiç sayılmıyor |
| **Konya Gıda ve Tarım** | Bölüm Ç'nin TAMAMI (Atıflar ve Etki Değerleri): Ç.1-4 puanı h faktörüne veriyor (10/30/60/90), Ç.5'in puan sütunu kaynakta BOŞ; G.3 üniversite bilim ödülü; endüstriyel tasarım, yazılım, ıslahçı hakkı, ticarileştirme; ders verme, idari görev, toplumsal katkı ve sanatsal etkinlik (yönergenin tablosunda hiç yok) | Bölüm Ç "Tüm Faaliyetler" barajına dahil olduğu için TOPLAM puan düşük çıkar — h faktörü 10 ve üzeri bir adayda 90 puanlık fark |
| **Konya Teknik** | A-1e/A-2e (Q dergilerde yayımlanan kongre makalesi — Tablo 2 aynı bildiriyi iki bölümden puanlamayı yasaklıyor, kayıt hangisinde beyan edildiğini bilmiyor); A-5 ve D-3 mesleki/kurumsal dergiler; K-5 aylık araştırma, N-1 aylık danışmanlık, J-2, M-7, O-3/4/5/9/10/11 ve P, S bölümleri | Aylık süreye bağlı kalemleri ve mesleki dergi yayını olan adayın toplamı düşük çıkar |
| **Kütahya Dumlupınar** | R bölümü (Spor Bilimleri uygulamalı faaliyetleri: millî takım antrenörlüğü, madalya, federasyon kurul üyeliği — en çok 20 puan); L bölümü (sergi küratörlüğü 20/10); S satırı (doçentlik belgesini sözlü sınavla alan adaya 25 puan — faaliyet değil); G112, G114, G122, G124 patent başvuruları | Spor Bilimleri ve sanat adayının toplamı düşük çıkar |
| **Kütahya Sağlık Bilimleri** | İdari görevler ve sanatsal etkinlikler — yönergenin tablosunda hiç yok, bu kayıtlar 0 puan; D.2 çeviri kitap editörlüğü (20); K'nın F.2 satırı (ulusal indeksli dergi editörlüğü, 20 — uluslararası karşılığından ayrılamıyor); endüstriyel tasarım, yazılım, ıslahçı hakkı, ticarileştirme | İdari görevi ve sanatsal etkinliği olan adayın bu kalemleri hiç sayılmıyor |
| **Lokman Hekim** | Hakemsiz dergi yayını ve indeksli dergide özet; "uluslararası ders kitabında adayın adıyla anılan formül, şema, grafik, tablo ve resim" (40) ve kitap eleştirisi; spor branşlarında görev (millî takım 20, üniversite takımı 10); soruşturma, lisans danışmanlığı ve öğrenci proje yarışmaları | Spor görevi olan adayın toplamı düşük çıkar |
| **Malatya Turgut Özal** | D1 ve D2 (adayın adıyla anılan formül, şema, şekil, buluş — 250 ve 120 puan); M bölümü (sertifikalar, 5-30); O bölümü (sportif etkinlikler: antrenörlük, hakemlik, millî takım — 10-40); N2 küratörlük, N4 müzik teknolojisi, N12 belge çözümleme, N14 arkeoloji; I1.1/I2.1 patent başvurusu (200/100) | Sportif ve sanatsal kalemleri olan adayın toplamı belirgin biçimde düşük çıkar |
| **Mimar Sinan Güzel Sanatlar** | 1.7.1, 1.7.2, 1.7.4, 1.7.5 (basında mesleki yazı, katalog metni); 1.5.3, 4.2.2, 4.2.5-4.2.8, 6.2.3-6.2.4, 6.6.3-6.6.10; 6.4'ün YİRMİ İKİ satırı (toplantı düzenleme, küratörlük, oturum başkanlığı) tek 'Diğer' etiketine düşüp en düşük değerden (2) tek satıra indi; 4.1.8 jüri üyeliği | Toplantı düzenleyen ve küratörlük yapan adayın toplamı düşük çıkar; 6.5.1 idari görev (10 puan × yıl) tek satırda toplandı |
| **Muğla Sıtkı Koçman** | EK-1'de idari görev, ders verme ve toplumsal katkı HİÇ YOK — bu kayıtlar 0 puan; EK-3'ün 12 (eğitim müziği dizini), 16 (tiyatro çalışmaları), 19 (atölye), 20 (küratörlük), 21 (sanat danışmanlığı) satırlarının bir kısmı | Ders veren ve idari görevi olan adayın bu kalemleri hiç sayılmıyor |
| **Muş Alparslan** | A2.4 (Türkiye'de yabancı dilde yayımlanan uluslararası dergi) ve B1.6 açıklamalı çeviri; A4 (ulusal kuruluşların uluslararası toplantıları — A3 ile aynı etiketlere düşüyor); C1.3-C1.8 tezden türetilmiş yayınlar; C2.1, C2.10, C2.11 aylık yurt dışı araştırma; C5 sertifika programları | Tezden üretilmiş yayını ve yurt dışı süresi olan adayın toplamı düşük çıkar |
| **Nevşehir Hacı Bektaş Veli** | E.16-E.21 (spor branşlarında sporcu yetiştirme, millî takım antrenörlüğü — 5-30 puan); D.5 h-indeksi; A.25 kişiye özgü denklem/şema; C.3 talep edilen bilimsel rapor; D.6 "Doğal ve Kültürel Miras Turizmi" ihtisaslaşma görevi; D.8 üniversite tanıtım etkinliği; D.2.4 patent başvurusu | Spor Bilimleri adayının toplamı düşük çıkar |
| **Niğde Ömer Halisdemir** | 3. maddenin TAMAMI (lisansüstü tezlerden üretilmiş yayınlar — tezden üretilmiş/üretilmemiş ayrımı kayıtta yok, §0 uyarınca yüksek satırlar kullanıldı); 5. madde (Mimarlığa özgü yarışma, uygulama projesi, yazılım) kısmen; 12.j-l (konser kaydı, şeflik, müzik teknolojisi); 13. maddenin bazı idari görevleri | Tezinden üretilmiş yayını olan adayın puanı tersine YÜKSEK görünür; Mimarlık ve müzik kalemleri düşük |
| **Ordu** | C.7 (adayın adıyla anılan denklem, şema, sendrom, tablo — 40 puan); I.2 ve I.4 DEVAM EDEN tez yönetimi (15 ve 5 — kayıt yalnız tamamlanmış tezleri taşıyor); L bölümünün film, video ve radyo-TV satırları kısmen | Devam eden tezi ve görsel-işitsel üretimi olan adayın toplamı düşük çıkar |
| **Pamukkale** | A.12 (adayın adıyla anılan denklem, şema, sendrom — 40 puan); A.13 internet ortamında yayın; D.4b-f (Tıp Fakültesine özgü modül, task ve senaryo görevleri); D.7 alan dışı doktora; D.8 yeterlik/board sınavı; D.2'nin "sonuçlandırılmış projelerde puan 2 ile çarpılır" kuralı | Tıp Fakültesi adayının eğitim görevleri hiç sayılmıyor; proje puanı çarpansız kaldığı için düşük çıkar |
| **Trabzon** | 2.3.1-2.3.3 EĞİTİM-UYGULAMA PROJESİ bölümünün TAMAMI; 1.2.1.3 ve 1.2.2.3 hakemsiz bildiri; 1.3.3.1 makale çevirisi; 2.1.1.3 ve 2.1.2.3 "çalışma üzerine başkalarının yazdığı makale"; 2.2.1.2 reddedilen proje önerisi | Eğitim-uygulama projesi olan adayın toplamı düşük çıkar |
| **İzmir Katip Çelebi** | EK-A 3.g (İKÇÜ Yayın Komisyonu onaylı kitap) ve EK-A 10 (arazi çalışmaları) — komşu satırla aynı kayda düşüyor; EK-A 5.c tezsiz yüksek lisans proje danışmanlığı ve tez izleme komitesi; EK-B 9.d "en iyi öğretici" ödülü; EK-C 12.c/12.d üniversite onaylı sosyal sorumluluk projeleri; EK-D'nin portföye bağlı özel başvuru şartları | Yönergenin kendi dipnotu ders kitaplarını dışladığı için 'Ders / Metot Kitabı' etiketine hiçbir satır bağlanmadı: ders kitabı bu üniversitede puansız |
| **İzmir Yüksek Teknoloji Enstitüsü** | Yönergenin KENDİSİ saymıyor: derleme, editöre mektup, teknik not ve kitap kritiği (1. madde açıkça dışlıyor); ULAKBİM dışı ulusal hakemli dergiler; AB dışındaki uluslararası ve kamu projelerinde araştırmacılık ile BAP projelerinin tamamı; poster, özet ve davetli konuşmacılık; editörlük, hakemlik, idari görev, ödül, toplumsal katkı ve sanatsal etkinliğin tamamı (üç ekin hiçbirinde satır yok) | Derlemesi, posteri, editörlüğü ya da idari görevi olan adayın bu kayıtları 0 puan; eksiklik motorda değil yönergede |
| **Toros** | F.3 tezsiz yüksek lisans danışmanlığı — sözlükte "tezsiz" karşılığı yok | J bölümünün "son iki yılda" penceresi uygulanmadığı için ders puanı tersine YÜKSEK görünür |

| **Yozgat Bozok** | A2.3, A3.2 ve A3.4 (Yozgat Bozok bünyesinde yayımlanan dergiler, 9/15/9 puan — sözlük derginin hangi üniversiteye ait olduğunu taşımıyor); A7.5 Teknopark projesi ve A7.6 yurt dışında altı ay; A8.4-A8.9 (Bozok Akademi, SEM kursu, gözetmenlik, lisans danışmanlığı); A9.2 ve A9.4 devam eden tez danışmanlığı; B5.3 millî takım ve müsabaka dereceleri; B5.4.3-B5.4.6 proje başvurusu ve TÜBİTAK panelistliği; B5.4.7 h-indeksi | Kendi üniversitesinin dergilerinde yayın yapan adayın puanı düşük çıkar; "üniversitenin ihtisas alanıyla ilgili çalışmalara 1,5 kat" çarpanı da uygulanamıyor |
| **Acıbadem** | 1.E (SCI dergisinde yayımlanmış kongre bildirisi, 20 puana kadar — bildiri kaydı derginin çeyreğini taşımıyor); 1.F, 2.F, 3.F kitap değerlendirmesi; 'Diğer Uluslararası İndeks' ve 'Diğer Ulusal Hakemli' dergiler (yönerge yalnız WoS/SCOPUS ve TR Dizin sayıyor); özel kurumlarla yapılan projelerde YÜRÜTÜCÜLÜK (yönergede yalnız araştırmacı ve danışman satırı var); faydalı model, tasarım, yazılım ve ticarileştirme; hakemlik, tez izleme, idari görev, ödül ve topluma hizmet | Q4 satırları SIFIR puan olduğu için Q4 ve AHCI yayınları puana katkı vermiyor; atıfta yarım puanlar sıfırlandığından pratikte yalnız kitap atıfları sayılıyor |
| **Altınbaş** | ATIFLARIN TAMAMI (uluslararası 0,5 · ulusal 0,3 puan — tam sayıya yuvarlanınca sıfırlanıyor, satırlar hiç girilmedi); DERS YÜKÜNÜN TAMAMI (AKTS başına 0,5 puan, kayıt AKTS taşımıyor); C türü dergiler; basılmamış bildiri; kritikler; konferans kitapçığı editörlüğü; bilirkişi raporu; kitap hakemliği; yüksek lisans projesi; ders ve program geliştirme; sürekli eğitim semineri; makale/proje hakemliği (1 ve 0,5 → 0) | "Atıflardan 15/30 puan" ve "verilen derslerden 25/30 puan" koşulları eşiklerde HESAPLANAMIYOR olarak duruyor; ders kayıtları toplam puana hiç katkı vermiyor |
| **Antalya Bilim** | Madde 44 (yurt dışında kesintisiz en az üç ay görev, 20 puan); ESCI, Scopus, TR Dizin ve diğer hakemli dergilerde EDİTÖRLÜK; tez danışmanlığı, ders verme ve idari görev (çizelgede hiç yok) | Çizelge yalnız araştırma çıktısını puanlıyor; tez, ders ve idari görev kayıtları 0 puan |
| **Ardahan** | 1.2 (yurt dışı/yurt içi hareketlilik), 3.5 (burslar), 3.18 (arkeolojik kazı), 2.2 (deney föyü, antrenör-hakem eğitimi), 3.16-3.17 (toplantı düzenleme kurulları), 4.4, 4.7, 4.8, 4.12 (spor ve sosyal organizasyon), 4.13 (bilirkişilik), 4.14 (girişimcilik); 3.12'nin yirmi tasarım kademesinin çoğu; patent BAŞVURUSU satırları; 3.11.1 h-indeksi × 2 | Hareketlilik, burs, kazı, spor ve girişimcilik kalemleri olan adayın toplamı düşük çıkar |
| **Ataşehir Adıgüzel** | Madde 5 (ulusal diğer bilimsel dergiler, gazete ve dergiler, 20 puan); tez izleme ve jüri üyeliği, idari görev, topluma katkı (tabloda hiç yok) | Yayın kurulu üyeliği, hakemlik, editörlük, atıf, etkinlik düzenleme ve burs kalemlerinin yüksek kademeleri sözlükte ayrılamadığı için en düşük değerden sayılıyor |
| **Aydın Adnan Menderes** | C2 DERS VERME bölümünün TAMAMI (puanlar ders SAATİ başına, 0,25 ve 0,5 puan/saat); C3 öğrenci danışmanlıkları; B1.3-B1.4 ve B2.7-B2.8 arkeolojik kazı; D8 yurt dışı deneyimi; F3 sportif etkinlikler; A1.3 ve A1.5 (indekssiz ve diğer ulusal dergiler); sanat dergilerinde katalog yazısı; A5.1.4/A5.2.4 adayın adıyla anılan formül ve şema | Ek 3'ün "C2'den 20-60 puan" koşulları HESAPLANAMIYOR; Spor Bilimlerinin F3 koşulu da öyle. A1'in "etki faktörüyle çarpma" kuralı uygulanamadığı için yüksek etkili dergilerdeki makaleler taban puandan sayılıyor |
| **Bahçeşehir** | A-4.2 (Scopus h-indeksi × 10 puan); A-4.3-A-4.5 mahkeme kararlarında atıf; C-7 kanun şerhlerinde yazarlık; E-2 patent başvurusu; Q4 Scopus dergilerinde ve diğer hakemli dergilerde editörlük; hakemlik, ders verme ve burs (esaslarda hiç yok) | h-indeksi puanı esasların en yüksek tek kalemlerinden; girilemediği için toplam belirgin biçimde düşük çıkar |
| **Başkent** | SCI, SCI-Expanded, SSCI ve AHCI dergilerindeki vaka takdimi, editöre mektup, özet ve kitap kritikleri (1 ve 2. maddeler açıkça dışlıyor); 39. madde yurt dışında üç ay görev; ESCI, Scopus, TR Dizin ve diğer hakemli dergilerde editörlük; hakemlik; tez danışmanlığı, ders verme ve idari görev (çizelgede hiç yok); 55. madde sanat eserlerine atıf | Yurt dışı ortak yazar (%50), proje türü (%30-50) ve WoS-Scopus kitap (%50) primleri kayıtta karşılığı olmadığı için uygulanamıyor |
| **İstanbul Beykent** | P-1 EĞİTİME KATKI (ders KREDİSİ başına 0,5 puan, kayıt krediyi taşımıyor); A-4 ve D-3 kitap eleştirisi; D-4 yargısal karar tahlili; K bölümünün televizyon, radyo, gazete ve öğrenci uygulama satırları; 'Ticarileştirme' | Yeniden atanmadaki "A grubu faaliyetlerden yıllık ortalama 40 puan" AYRI BİR YÖNERGENİN (Akademik Personel Performans Ölçme-Değerlendirme Yönergesi) puanlaması; o belge elimizde olmadığı için koşul HESAPLANAMIYOR |
| **Ankara Hacı Bayram Veli** | Madde 13/a h-indeksi ve 13/b yurt dışı araştırma; 13/h iki yıl kesintisiz idari görev (kayıt görev süresini taşımıyor, idari görev kayıtları puan getirmiyor); 13/ı-i yabancı dil sınav puanları; 10/d patent başvurusu; SANATSAL ve SPORTİF FAALİYETLER tablolarının TAMAMI (ikisi de bilim/sanat dalına kilitli); madde 14 İlahiyat dînî mûsikî | Güzel Sanatlar ile Spor Bilimlerinin bu tablolara bağlı koşulları `hesaplanamiyor` olarak duruyor; yazar payı temel alana göre değiştiği için cetvel iki varyantla üretildi |
| **Ankara Sosyal Bilimler** | D.11 proje BAŞVURUSU; G.1 doktora sonrası ilk 500 üniversitede iki dönem; C.8-C.9 konferans kitabı editörlüğü ve H.1 makale çevirisi; PATENT, SANATSAL ETKİNLİK ve TOPLUMSAL KATKI kalemlerinin tamamı (tabloda hiç yok) | Ders kitapları ve özgün olmayan derleme kitaplar yönergenin dipnotuyla AÇIKÇA dışlandığı için 'Ders / Metot Kitabı' etiketi puansız; ödül satırları üçüncülük değeriyle girildi |
| **Ankara Yıldırım Beyazıt** | "Diğer Etkinlikler" başlığının h-indeksi bendi; Alanlara Özgü Etkinliğin spor bentleri (olimpiyat ve üniversite oyunlarında madalya), hizmet içi eğitim sertifikaları, yurt dışı ziyaret ve üniversite-sanayi danışmanlığı; standart hazırlama, firma sahipliği, TEKNOFEST danışmanlığı, millî takım görevi, bilirkişilik ve arabuluculuk bentleri | "Eşik üzeri puanla ret alan projelerde puanların %50'si" kuralı uygulanamıyor; alanlara özgü etkinlik tavanı değiştiği için cetvel iki varyantla üretildi |
| **Çankırı Karatekin** | 7.14-7.15 ihtisaslaşma alanı projeleri; 13 bilimsel kazı etkinlikleri; 14 ÇAKÜ Açık Erişim kayıtları; 11.16-11.22 (mobil arayüz, web, afiş, kurumsal kimlik tasarımı) ile 11.25-11.40'ın stüdyo kaydı ve tonmaysterlik kademelerinin çoğu; 10.5 tescil edilmiş marka | Devam eden proje ve tezlere yönergenin verdiği üçte bir puan §0 gereği satıra gömüldü |
| **Doğuş** | U maddesi EĞİTİME KATKI (ders KREDİSİ başına 0,5 puan, kayıt krediyi taşımıyor — ders kayıtları toplam puana katkı vermiyor); A-3 indekssiz uluslararası hakemli dergiler; A-4 ve D'nin kitap eleştirisi ile yargısal karar tahlili satırları; V bölümünün gazete, televizyon ve radyo programı satırları | Hakemlik, yayın kurulu üyeliği, yarışma derecesi ve toplantı düzenlemenin yüksek kademeleri düşük kademelerinden ayrılamadığı için en düşük değerden sayılıyor |
| **Erzincan Binali Yıldırım** | Ondalıklı satırlar (A.1.1 önlisans/lisans danışmanlığı 0,05; A.2 sınav gözetmenliği 0,1; atıf tablosunun TR-Dizin 0,8 ve diğer ulusal dergi 0,5 satırları); lisans tez danışmanlığı, tezsiz yüksek lisans ve öğrenci kulübü danışmanlığı; derleme kitap yazarlığı; çeviri makale; C.3 SPOR ETKİNLİKLERİ bölümünün TAMAMI; sanat bölümünde küratörlük, festival, el sanatları belge çözümlemesi ve arkeolojik kazı | "Her bir yıl için ortalama en az 15 puan" koşulu `hesaplanamiyor` olarak duruyor; yarım puanlı kalemler (yardımcılıklar, tekrar baskı, devam eden proje) uygulanamadığı için o satırlarda puan YÜKSEK görünür |
| **Fatih Sultan Mehmet Vakıf** | A1.4 (uluslararası indekslere girmeyen hakemli dergiler) ve A2.3 (hakemsiz ulusal dergiler); çok ciltli kitap ve çeviri satırları (A1.6.b, A1.7.b, A1.7.f, A2.5.b); A1.7.h makale çevirisi; A9.2.c tezsiz yüksek lisans projesi; A8.4 proje BAŞVURULARI; A10'un sergileme satırları (A5'te zaten puanlanıyor) | A8.1-A8.2'nin "her bir eğitim-öğretim yılı için" kuralı uygulanamıyor, çok yıllı projeler bir kez sayılıyor; eşikler temel alana değil FAKÜLTEYE bağlı olduğu için her kayıt `birim` taşıyor |
| **Haliç** | EK-4 Beden Eğitimi ve Spor Bilimleri formunun TAMAMI; EK-3/A-1 ("en az iki kişisel etkinlikte yer almak", 24 puan — dosyaya veriliyor); ondalıklı satırlar (TR Dizin atfı 0,5; kurul üyeliği 0,5/yıl); EK-2/3 yüksek lisans proje danışmanlığı; EK-3'ün C/1, D/4, E/3, E/4, F/3 ve G/2 satırları | BAP projeleri yönergede açıkça kapsam dışı; Scopus çeyrekleri kayıttaki WoS çeyrek etiketleriyle eşleştirildi, çeyreği belli olmayan ESCI-Scopus ve AHCI dergileri en düşük kademeden sayılıyor |
| **Harran** | A11 SPORTİF BAŞARI VE TEMSİL bölümünün TAMAMI; lisansüstü tezden üretilmiş makale satırları (A1/ı-k); Harran dergilerine özgü ve hakemsiz dergi satırları; A3 (çağrılı derleme, teknik not); patent ve faydalı model BAŞVURULARI, marka tescili, TTO buluş bildirimi; A5'in arkeolojik kazı satırları; A8/d h-indeksi; A14, A15'in ödül satırları, A22-A25, A31, A32, A36, A38-A40; A17'nin "en az 15 özgün eser barındıran kişisel sergi" satırları; B4 dil puanı | Bölüm katsayıları (A ×0,7; B ×0,3; C ×0,3) satır puanlarına gömüldüğü için HAM PUANI 1 OLAN SATIRLAR SIFIRA DÜŞTÜ: ders, jüri ve kurul faaliyetleri toplama hiç katkı vermiyor, eğitim-öğretim bölümünden yalnız doktora tez danışmanlığı sayılıyor. Patent, ödül ve ekip çalışmalarında yönergenin istediği EŞİT paylaşım yerine yazar sırası tablosu uygulanıyor |
| **Hitit** | Çeviri eserler (Tablo-7 açıkça dışlıyor); lisansüstü tezden ÜRETİLMİŞ yayın satırları (A.6, A.7, B.3, B.5, B.9, B.10) ile A.1-A.3'ün "tezden üretilene yarım puan" kuralı; ondalıklı satırlar (D.5 atıf 0,5; F.2 ve F.4 hakemlik 1,5 ve 0,5; N bölümünün 0,75 ve 0,5 puanlı satırları); L kazı ve M spor bölümlerinin TAMAMI; N bölümünün Hitit'e özgü satırları (MİTAM, HÜBTUAM, TTO, Proje Ofisi, Hitit FM, üniversite dergileri) | SCOPUS çeyrekleri ESCI'den ayrılamadığı için Scopus makaleleri 10 puandan sayılıyor; TÜBİTAK etiketi 1004'ten 4004'e bütün programları kapsadığı için en düşük değerden ve devam eden proje oranından hesaplanıyor (yürütücülük 2 puan); ödüller mansiyon değerinden. Madde 5/2'nin üç yeniden atanma koşulu da `hesaplanamiyor` |
| **İstanbul 29 Mayıs** | MADDE 8/1'in 3. satırı (indekssiz uluslararası hakemli dergi, 25); MADDE 8/2'nin 1-8. satırları (lisansüstü tezden üretilmiş kitap, bölüm ve makaleler); 69-71 (Erasmus görevi, yurt dışı yarıyıl, YÖK-TÜBİTAK kurul üyeliği) | Eşiklerin alt barajı doğrudan MADDE 8/1'e yazıldığı için §1 istisnası uygulandı ve YÜKSEK satırlar girildi; tezden üretilmiş yayınlar olduğundan yüksek puanlanıyor. "Her yıl için" verilen idari görev puanları görev süresiyle çarpılamıyor. Doçentlik ve profesörlük yalnız üç temel alan için düzenlenmiş; diğer dokuz alanda bu iki kadroda eşik yok |
| **İstanbul Aydın** | A.3 (önde gelen ülkelerin hakemli dergileri, 20) ve B.6 (hakemsiz ulusal dergi, 5); B.5 ders notu; B.11 hakemsiz dergide tercüme; EK-2'nin 6. satırı (ders puanı KREDİ SAAT başına); BAP ve özel sektör projeleri (C bölümü yalnız yurt dışı kaynaklı ve TÜBİTAK-TÜBA-DPT projelerini sayıyor); Ek-3'ün küratörlük (15-16) ve arşiv tasnifi (19-20) satırları | Güzel Sanatlar Fakültesi Özel Puanlama Tablosunun ek bazlı yüzde dağılımı (EK1 %30, EK2 %10-20, EK3 %50-60) motorda uygulanamıyor; Sanat ve Mimarlık eşiklerinde yalnız sayısal baraj işliyor |
| **İzmir Bakırçay** | Puan Tablosunun 3. MADDESİNİN TAMAMI (lisansüstü tezden üretilmiş yayınlar) — kayıt tez kökenini taşımadığı için aynı makale iki kez sayılırdı; 10.d patent başvurusu; 13.a h-indeks; 13.b yurt dışı araştırma süresi; ders kitabı ve çeviriler (4. bölüm açıkça dışlıyor); öğrenci projeleri (7.a hariç tutuyor) | İDARİ GÖREV, SANATSAL ETKİNLİK ve TOPLUMSAL KATKI kalemleri puan tablosunda hiç yok, bu kayıtlar 0 puan; editörlükte yalnız üç satır var, hakemlik ve yayın kurulu üyeliği puanlanmıyor. MADDE 13'ün 3. bölüme bakan kolları yönergenin kendi alternatifiyle değerlendiriliyor |
| **Necmettin Erbakan** | A5, I5 ve K5 (üniversitenin kendi dergileri); K16 h-indeksi; patent ve marka BAŞVURU satırları; H12-H16 girişimcilik ve TGB-TTO danışmanlığı; F19-F26 (çalgı yapımı, sportif faaliyetler); G14-G15; M3-M5, M7, M10; O7-O9, O11-O12, O15, O17; P10-P14 kalite ve akreditasyon | A1'in dört Q1 kademesi (200/175/150/100) tek etikete düştüğü için 100'den sayılıyor; SCOPUS dergileri ESCI ile aynı etikette olduğundan A2 değerinden (50) sayılıyor ve A1 barajına katkı vermiyor; projelerde iki sütundan düşük olanı (bir yıldan kısa) ve "devam eden projede yarı puan" birlikte uygulandığı için uluslararası yürütücülük 400 yerine 100 puan |
| **Ostim Teknik** | 5.b/1 (ders puanı AKTS başına 2); TR Dizin dışındaki ulusal hakemli dergiler (ölçütlerde satır yok); çeviriler; SANATSAL ETKİNLİK ve TOPLUMSAL KATKI kalemlerinin tamamı | Ölçütlerin 1.a bendi Scopus'un yalnız Q1 dilimini kapsıyor; kayıtta Scopus ile ESCI aynı etikette olduğundan bu makaleler 1.b/4'ün 5 puanından sayılıyor. "Üniversite-iş dünyası iş birliği" için verilen 5'er puanlık ekler uygulanamıyor. "İlk üç ismin içinde olmak" koşulu yalnız birinci isim üzerinden değerlendirilebiliyor |
| **Siirt** | Ek-I'in 2. MADDESİNİN TAMAMI (lisansüstü tezden üretilmiş yayınlar); 13.d (kurum içi/dışı bilimsel ödül); EK-2'NİN TAMAMI (sinema, plastik sanatlar, tasarım, geleneksel Türk sanatları, müzik-kompozisyon, yorumculuk, Türk müziği, dans-koreografi, halk dansları) — her bölüm ayrı sanat dalına kilitli, "tüm şartlar zorunludur" kurgusu ve puanlar dosyaya veriliyor | Güzel Sanatlar adayının sanatsal etkinlikleri hiç sayılmıyor; MADDE 6'nın yıl başına ortalama puan koşulu `hesaplanamiyor`. Patentte "puan kişi sayısına bölünür" kuralı yerine MADDE 11'in yazar oranları işliyor |
| **Süleyman Demirel** | Ek-1'in 3. MADDESİNİN TAMAMI (lisansüstü tezden üretilmiş yayınlar); 9. madde (eğitim-öğretim; puan "dört farklı yarıyılda ders vermiş olmak" bloğuna veriliyor); 10/d patent başvurusu; 14. MADDE SPORTİF BAŞARI VE TEMSİL bölümünün TAMAMI; 15.1/a (en az 15 özgün eser barındıran kişisel sergi); 15.2'nin orkestra şefliği, dans ve halk oyunları alt bölümleri | SCOPUS makaleleri ESCI ile aynı etikette olduğu için çeyreğine bakılmaksızın 20 puandan sayılıyor; yurt dışı ortak yazarlık için verilen 1,25 kat ek puan uygulanamıyor. Spor Bilimlerinin "Sportif Başarı ve Temsil'den 10 puan" koşulu ile yeniden atamanın yıllık ortalama barajı `hesaplanamiyor`. Ziraat, Orman ve Su Ürünleri temel alanı tablolarda hiç geçmiyor |
| **Tokat Gaziosmanpaşa** | 1.1.k hakemsiz dergi; 1.6.a h-indeksi; 3.1-3.2 patent BAŞVURUSU; 2.3.d-e (üniversitenin Enerji Depolama ihtisas alanı projeleri); 6. bölüm bilimsel nitelikli kazı etkinlikleri; 4.4 Teknoloji Transfer Ofisinde görev almak | Yönergenin "en fazla 10 hakemlik", "en fazla 10 atıf" ve "en fazla 10 ders" gibi ADET sınırları motorda karşılığı olmadığı için uygulanmıyor; bu kalemlerde puan YÜKSEK çıkabilir. Görev süresi uzatımının puanı istenen süreye bağlı olduğundan (1 yıl 40 … 4 yıl 150) eşiğe en düşük basamak yazıldı |
| **Trakya** | EK-7'NİN 16. MADDESİNİN TAMAMI (sportif performans: sporcu yetiştirme 40'a kadar, millî takım görevi, antrenörlük ve hakemlik belgeleri, federasyon kurul üyeliği — 26 satır); h-indeksi (×5) ve "ilk 500 üniversitede altı ay yurt dışı araştırma" (25) satırları yedi ekte de; meslek örgütü YETERLİK BELGESİ (EK-1 madde 17, EK-4 madde 21); patent BAŞVURUSU; EK-1 madde 12'nin yarışma (20) ve uygulanmış proje (15) satırları; EK-5'in müzik alt tablosunda sınıf konseri yönetimi, öğrenciye piyano eşliği ve konser anlatıcılığı; EK-6'nın 17. maddesinde etkinlik yöneticiliği ve panel-söyleşi; EK-4 madde 14 (bilimsel kazı ve yüzey araştırması); EK-5 ile EK-6'nın sergi değerlendirme (15/10) ve hakemli araştırma-derleme makalesi (20/15) satırları | Yönergenin "atama için gerekli toplam puanın %25'ini geçemez" tavanları ATAMA EŞİĞİNE bağlı; aynı cetvel dört ayrı eşikte kullanıldığı için sabit tavana çevrilemedi ve atıf, ödül, editörlük, jüri, idari görev kalemlerinde puan YÜKSEK çıkıyor. MATEMATİK alanı EK-2'den ayrılamadı (eşik 60/160 yerine 50/120 olmalıydı); ziraat EK-2'ye, hukuk EK-4'e bağlandı — yönerge ikisini de saymıyor. EK-2'nin ilk atamadaki üç kollu ek yayın merdiveni tez yayınının ÇEYREĞİNE bağlı olduğu için en sıkı kol yazıldı. EK-4 doçentliğinde aranan "ÜAK doçentlik puanının %20 fazlası" `hesaplanamiyor`. "Diğer uluslararası/ulusal kitap" çift değerlerinin (15/10, 10/5) düşüğü alındı |
| **Ufuk** | 7. MADDENİN TAMAMI (atıflar; puan atıf sayısının 0,5 ve 0,3 katı) ve 11/a-f (ders puanı dönemlik ders SAATİ ile çarpılan 0,025-0,15 katsayıları) — ikisi de ondalıklı; 4. MADDENİN TAMAMI (lisansüstü tezden üretilen yayınlar); h-indeksi eklentisi (h × 0,1); 14/a yabancı dil sınav başarısı, 14/c etki faktörü, 14/e-f yeterlilik sertifikaları, 14/g yeni birim kurma, 14/m yurt dışı üç ay, 14/o atama jürisi üyeliği | ATIFLAR VE DERSLER TOPLAM PUANA HİÇ KATKI VERMİYOR. Kitaplarda Sense Ranking A-E kategorileri kayıtta olmadığı için en düşük kategoriden sayılıyor. Yayın ve kitap için iki ayrı ortak yazar kuralı var; motor kategori bazlı çarpan tanımlayamadığından düşük olan yayın kuralı ikisine de uygulandı |
| **Çağ** | Kısa bildiri, teknik not, tartışma ve editöre mektup için tanımlanan %60 KURALI (SCIE'de 9 puan) — kayıt bunları A-5'in kitap eleştirisinden ayırmadığı için 2 puanlık satır kullanılıyor; U bölümünün "eğitime katkı" satırı (kredi başına 0,5, hem ondalık hem kredi bazlı); T bölümünün TAMAMI (bilimsel toplantı düzenleme 20/5/10/2, seçici ve bilim kurulu üyeliği 5/2); lisansüstü tezden üretilmiş yayın | İdari görev puanları YIL SAYISIYLA ÇARPILMIYOR (10/5/3 × yıl); beş yıllık dekanlık 50 değil 10 puan. Uluslararası dergi hakemliği (3), uluslararası yayın kurulu üyeliği (15) ve yarışma dereceleri (10'a kadar) ulusal karşılıklarından ayrılamadığı için en düşükten. MADDE 3/1-c'nin dil koşulu yalnız %100 yabancı dille eğitim veren bölümler için geçerli olduğundan sayısal YDS düğümü yerine `beyan` yazıldı. PDF'in başlık fontundaki sistematik harf ikamesi (İ→Ġ, Ş→Ģ) çıkarma sırasında düzeltildi |
| **İstanbul Gedik** | Üniversitenin kendi BAP projeleri (G bölümü yalnız uluslararası ve üniversite DIŞI kaynaklı projeleri puanlıyor); lisansüstü tezden üretilmiş yayın; idari görev; toplumsal katkı; yarışma dışındaki ödüller; eş danışmanlık ve tezsiz yüksek lisans danışmanlığı (1) | J bölümünün "son iki yılda alınan dersler" kaydı satır bazlı zaman penceresi olmadığı için uygulanmıyor, eski dersler de sayılıyor. "Tanınmış uluslararası" ile "tanınmış ulusal yayınevi" ayrımı kayıtta olmadığından BKCI/Scopus kitapları uluslararası (20/10), öteki kitaplar ulusal (10/5) satırından. MADDE 6.3'ün "uygulama projesi yayımlamış olmak" seçeneği ve MADDE 10'un yabancı dille öğretim yapan bölümlere özgü dil koşulu girilmedi |
| **İzmir Kavram MYO** | 13. madde (bilimsel ve sanatsal etkinlik düzenlemelerinde yer almak, 5/3); 18. madde (Web of Science h-indeksi, 5); 19. madde (yabancı dil sınavından 85 ve üzeri, 5); dergi editörlüğü (cetvelde satır yok, editörlük kayıtları yayın kurulu üyeliğinden sayılıyor); 16.b (uygulama projesi yayımlamış olmak, 15); lisansüstü tezden üretilmiş yayın; idari görev; toplumsal katkı | KAYNAK PDF TARANMIŞ VE OCR'LANMIŞ; "ı", "ş", "ğ", "İ" harflerinin bir bölümü düşmüş. Puanlar ve madde başlıkları okunduğu için girilebildi, iki satır daraltıcı okundu (2.c-2.d BKCI dışındaki uluslararası kitap 15 ve bölümü 10; 17. madde ders başına 2 puan, tavan 6). E-SCI (20), uluslararası faydalı model (20), uluslararası hakemlik (3) ve davetli konuşmacılık (10) ulusal karşılıklarından ayrılamadığı için düşükten. Ek-1'in 15 ve 16. maddeleri tek temel alana kilitli olduğu için üç ayrı cetvel yazıldı |
| **İstanbul Arel** | A.3.c satırı (puanı kaynak PDF'te okunamıyor); patent BAŞVURULARI (yurt dışı 50, yurt içi 25), faydalı model ve endüstriyel tasarım; O bölümünün organizasyon başkanlığı (150/100), düzenleme ve bilim kurulu üyeliği (20) ile O.6 TÜBİTAK görevlendirmeleri (50); P.3 rektör danışmanlığı (30); P.8 öğrenci danışmanlığı (10); lisansüstü tezden üretilmiş yayın | IMPACT FAKTÖRÜ ÇARPANI UYGULANMIYOR: tablo makale puanlarının derginin etki faktörüyle çarpılmasını istiyor, kayıt etki faktörünü tutmuyor. "Senior isim" (alanında en az on uluslararası yayını olan son yazar) tam puan alıyor ama kayıtta böyle bir rol yok. Ders puanı haftalık ders SAATİ başına verildiği hâlde ders başına tek puan. TABLODA ULUSAL KİTAP YAZARLIĞI SATIRI YOK; Türkçe kitap da uluslararası kitap satırından (60) sayılıyor ve puan YÜKSEK çıkıyor — satırı hiç girmemek uluslararası kitapların tamamını sıfırlardı |
| **İstanbul Atlas** | 1.4.a Scopus ATIFLARI (atıf başına 0,5; ondalık olduğu için atıf bölümü neredeyse boş kaldı, yalnız patent atfı girildi); 1.5 bilimsel toplantı düzenleme (10/5/2/1); dergi hakemliği ve yayın kurulu üyeliği (tabloda satır yok); 1.2.n üniversitenin kendi dergilerindeki yayın (15); 2.4.a Scopus h-indeksi (değer başına 2); patent BAŞVURULARI (30/20); lisansüstü tezden üretilmiş yayın; idari görev; toplumsal katkı | TÜBİTAK PROJELERİ 10 PUANDAN: tablo ARDEB, TEYDEB ve Kamu Ar-Ge yürütücülüğüne 60, TÜBİTAK 1002 ve Bilim-Toplum'a 10 veriyor, kayıt ikisini ayırmıyor. AHCI'nin tabloda satırı yok (tablo Scopus merkezli), "diğer uluslararası hakemli dergi"den (7) sayılıyor. Ders puanı haftalık ders saati başına verildiği hâlde ders başına tek puan; "son bir yıl" kısıtı satır bazlı olduğu için uygulanmıyor. Tablo kitap, bildiri ve sanatsal etkinlikte puanı eşit bölüyor, makalede kademeli; motor makale kuralını hepsine uyguluyor |

## Motorun karşılayamadığı kurallar

Bunlar PDF sorunu değil; motorun bugünkü yapısıyla ifade edilemeyen kurallar.
Hepsi ilgili cetvelin `kapsam_notu` alanında adaya da söyleniyor.

- **Patent, faydalı model ve proje BAŞVURUSU satırları** — Aksaray, Alanya,
  Bartın, Dicle, Erzurum Teknik, Eskişehir Osmangazi, Kafkas, Kahramanmaraş
  Sütçü İmam, Kastamonu, Kayseri, Kırıkkale, Kırşehir Ahi Evran, Kütahya
  Dumlupınar, Malatya Turgut Özal, Nevşehir, Trabzon, Yozgat Bozok,
  Acıbadem, Ardahan, Antalya Bilim, Bahçeşehir, Başkent, Ankara Hacı Bayram
  Veli, Ankara Sosyal Bilimler, Harran, İzmir Bakırçay, Süleyman Demirel,
  Tokat Gaziosmanpaşa, Trakya, İstanbul Arel ve İstanbul Atlas'ta tescil edilmiş
  patentin yanında BAŞVURU için de ayrı ve düşük puanlı satır var. Kayıt
  başvuruyu tescilden ayırmadığı için başvuru satırları hiç girilmedi:
  girilseydi motor en yükseği seçer ve BAŞVURU sahibini TESCİL sahibi gibi
  sayardı. Yalnız başvurusu olan adayın puanı bu kalemde sıfır görünür.
- **Ders puanını SAAT, AKTS ya da KREDİ başına veren satırlar** — Altınbaş
  (4.0.2.1.1, AKTS başına 0,5), Aydın Adnan Menderes (C2, ders saati başına
  0,25 ve 0,5), İstanbul Beykent (P-1, kredi başına 0,5), Doğuş (U maddesi,
  kredi başına 0,5), Ostim Teknik (5.b/1, AKTS başına 2), İstanbul Aydın (EK-2/6,
  kredi saat başına 1), Ufuk (11/a-f, dönemlik ders saatiyle çarpılan
  0,025-0,15 katsayıları), Çağ (U bölümü, kredi başına 0,5), İstanbul Arel
  (N.1-N.2, haftalık ders saati) ve İstanbul Atlas (4.1, güz ve bahar toplam
  haftalık ders saati) ders puanını
  faaliyet başına değil süre birimi başına veriyor. Faaliyet kaydı yalnız
  yarıyıl sayısını taşıdığı için bu satırlar hiç girilemedi; ders kayıtları
  bu on üniversitede toplam puana katkı vermiyor ve yönergelerin "derslerden
  şu kadar puan" koşulları eşiklerde `hesaplanamiyor` olarak duruyor.
- **h-indeksi ve atıf ortalaması satırları** — Aksaray (E.8), Bartın (H
  bölümü), Bursa Teknik (E bölümü), Konya Gıda ve Tarım (Ç.1-4),
  Kahramanmaraş Sütçü İmam (Tablo 3/5), Nevşehir (D.5), Afyonkarahisar
  Sağlık Bilimleri (h × 20), Şırnak (4.3, h × 5), Yozgat Bozok (B5.4.7),
  Ardahan (3.11.1, h × 2), Bahçeşehir (A-4.2, h × 10), Ankara Hacı Bayram Veli
  (13/a), Ankara Yıldırım Beyazıt (Diğer Etkinlikler), Harran (A8/d), İzmir
  Bakırçay (13.a), Necmettin Erbakan (K16, h × 10), Tokat Gaziosmanpaşa (1.6.a),
  Ufuk (h × 0,1), Trakya (yedi ekte de h × 5), İzmir Kavram MYO (18. madde, 5)
  ve İstanbul Atlas (2.4.a, değer başına 2) puanı h faktörüne ya da
  "toplam atıf / atıf alan yayın sayısı" ortalamasına bağlıyor. İkisi de
  faaliyet başına puan değil, PROFİL ölçütü; motor puanı yalnız
  faaliyetlerden topladığı için bu satırlar hiç girilemedi. h-indeksi yüksek
  adayın toplamı DÜŞÜK görünür (Konya Gıda ve Tarım'da 90 puana kadar).
- **Kayan zaman penceresi** — Toros'un J bölümü ("son iki yılda verilen
  dersler"), Sivas Cumhuriyet'in İ bölümü ("son 4 yılda her yarıyıl en fazla
  4 ders") ve Recep Tayyip Erdoğan'ın 9. maddesi ("son üç yılda verilen
  dersler, yarıyıl başına en fazla 3 ders"). Motorda ders için kayan pencere
  yok; bütün dersler sayılıyor ve ders puanı YÜKSEK görünür.
- **Puan sütunu boş bırakılmış satır** — KOSTÜ'nün 50. satırı ("son beş yılda
  üniversite eğitim biriminde idari görevde bulunmak") puan yerine soru işareti
  taşıyor. Kaynakta sayı olmadığı için idari görev puanı hiç girilemedi; puan
  DÜŞÜK görünür.
- **Yüzdeye bağlı tavan** — Düzce (eğitim-öğretim %20, burs %10, idari görev
  %10), Manisa CBÜ (atıf %20), Karabük (E bölümü %10), Yalova (Sosyal ve
  Mimarlık'ta kitap %30, atıf %20, tez danışmanlığı %10 — hepsi "başvuru
  şartında istenen asgari puanın" yüzdesi, yani kadroya göre değişiyor) ve
  Trakya (yedi ekin hepsinde atıf, patent, ödül, editörlük, jüri, idari görev ve
  "diğer" başlıklarına "atama için gerekli toplam puanın %25'i" sınırı; aynı
  cetvel doktor öğretim üyeliğinden profesörlüğe dört ayrı eşikte
  kullanıldığı için sabit bir sayıya çevrilemedi). Motor yalnızca sabit
  grup tavanı tanıyor; bu kalemlerde puan **yüksek** görünür.

- **Sportif performans bölümleri** — İnönü (P), Nişantaşı (Ek1-D, on altı satır),
  İstanbul Yeni Yüzyıl (4.D), Recep Tayyip Erdoğan (11. madde), Kırşehir Ahi
  Evran (13.C), Süleyman Demirel (14. madde) ve Trakya (EK-7 madde 16, yirmi
  altı satır) sporcu yetiştirmeyi, millî takım görevini, antrenörlük ve
  hakemlik belgelerini, federasyon kurul üyeliğini puanlıyor — Trakya'da tek
  sporcu için 40 puana kadar. `Kategori` sözlüğünde bu faaliyetlerin karşılığı
  yok; hiçbirinde satır girilemedi. Spor Bilimleri adayının puanı bu yüzden
  sistematik olarak DÜŞÜK çıkıyor ve Trakya'da eşiklerin adıyla andığı
  "16. kategori" payı hiç dolmuyor.
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
- **Derginin ETKİ FAKTÖRÜYLE çarpılan puan** — İstanbul Arel'in puanlama
  tablosu "birden fazla ismin yer aldığı yayınlar için yazılan puanı hak ediş
  oranları, derginin IMPACT FAKTÖRÜ İLE ÇARPILDIKTAN SONRA aşağıdaki oranlara
  göre hesaplanır" diyor. Motorun `puan` alanı sabit bir sayı; kayıt da
  derginin etki faktörünü tutmuyor. Bütün makale puanları çarpansız, yani
  tablo değerinden sayılıyor. Yüksek etki faktörlü dergilerde yayın yapan
  adayın puanı **düşük**, düşük etki faktörlü dergilerde yayın yapanın puanı
  **yüksek** görünür — sapmanın yönü adaydan adaya değişiyor.
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
  dönem kısıtı yok. Aynı sorun İstanbul Gedik'in J bölümünde ("son iki yılda
  alınan dersler"), İstanbul Arel'in N bölümünde ("son iki yılda haftalık ders
  yükü") ve İstanbul Atlas'ın 4. bölümünde ("son 1 yıl içerisinde
  gerçekleştirdiği faaliyetler") var. Dönem yalnızca KOŞUL düğümünde
  tutulabiliyor, cetvel satırında değil; bu kalemlerde puan YÜKSEK görünür.
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
- **Bölüm katsayısı satır puanlarına gömülünce KÜÇÜK SATIRLAR SIFIRLANIYOR** —
  Harran'ın "TOPLAM PUAN HESAPLAMA" tablosu bölüm toplamlarını çarpıyor
  (Akademik ×0,7; Eğitim-Öğretim ×0,3; İdari ×0,3). Motorda bölüm katsayısı
  alanı olmadığı için çarpan her satıra gömüldü ve çarpımdan sonra bir kez
  aşağı yuvarlandı (KONVANSIYONLAR'ın "Koşula bağlı çarpanı cetvele göm"
  kuralı). Ham puanı 1 olan satırlar (ders kredisi, jüri üyelikleri, kurul
  üyelikleri, seminer, hakemlik) çarpımdan sonra sıfıra düştüğü için hiç
  yazılamadı: eğitim-öğretim bölümünden yalnızca doktora tez danışmanlığı puan
  üretiyor. Yön §0'ın istediği yön ama kayıp büyük; bir gün motora bölüm
  katsayısı eklenirse ilk düzeltilecek cetvel bu.
- **Yıl ortalamasına bağlı YENİDEN ATAMA barajı** — Erzincan Binali Yıldırım'ın
  Madde 6'sı ve Güzel Sanatlar alanının sanat etkinliği koşulu "her bir yıl
  için ortalama en az 15 puan" istiyor; Beykent'in yeniden atanma koşulu da
  "yıllık ortalama 40 puan"; Siirt'in MADDE 6'sı (Fen ve Sağlıkta 20, Sosyalde
  15 puan/yıl), Süleyman Demirel'in MADDE 11'i (yıllık ortalama 10) ve Hitit'in
  MADDE 5/2'si (yıl bazında 10 puan) aynı kalıbı kullanıyor. İki atama
  arasındaki yıl sayısı profilde tutulmadığı için bu koşullar `hesaplanamiyor`
  düğümü olarak duruyor ve yeniden atama sonucu "belirsiz" dönüyor. Hitit'te
  koşulun diğer iki ayağı ("en az iki farklı ana kategoriden" ve "toplamın en az
  yarısı şu kategorilerden") de motorun ifade edemediği türden.
- **Puanı ONDALIK olan satırların bir bölümü değil TAMAMI düşebiliyor** —
  motorun `puan` alanı tam sayı taşıyor. Çoğu yönergede bu, tek tük satırın
  düşmesi demek; Ufuk'ta ise iki bütün bölüm birden gidiyor: 7. madde
  (atıflar, atıf sayısının 0,5 ve 0,3 katı) ve 11. maddenin a-f bentleri (ders
  puanı dönemlik ders saatiyle çarpılan 0,025-0,15 katsayıları). Ufuk adayının
  ATIFLARI VE DERSLERİ toplam puana hiç katkı vermiyor. Yuvarlama yönü §0'a
  uygun ama kayıp burada bir istisna değil, kuralın kendisi.
