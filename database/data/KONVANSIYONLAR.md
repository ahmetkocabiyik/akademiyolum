# Yönerge girişi konvansiyonları

Bu belge, `database/data/cetvel/` ve `database/data/yonerge/` altındaki dosyaları
yazarken uygulanan kuralları anlatır. Amacı, işi başka birinin (ya da başka bir
oturumun) aynı kararları vererek sürdürebilmesi.

73 üniversite bu kurallarla girildi. Kuralların çoğu bir hatadan sonra yazıldı;
"neden" kısımları o yüzden önemli.

---

## 0. Temel kural: EKSİK SAY, FAZLA SAYMA

Bir belirsizlikle karşılaştığında **adayın puanını düşük gösteren** tarafı seç.

Gerekçe: Bu araç adaya "başvurabilirsin" diyor. Fazla sayarsak aday hazır
olmadığı bir başvuruya girer ve reddedilir. Eksik sayarsak aday gereğinden fazla
çalışır — can sıkıcı ama zararsız.

Pratikte:

- İki cetvel satırı aynı kaynağa düşüyorsa **düşük puanlı** olanı gir.
- Kesirli **puanı** aşağı yuvarla (`intdiv`, `floor`).
- Kesirli **barajı** YUKARI yuvarla (`ceil`). Yön aynı, işlem ters: puanı aşağı,
  eşiği yukarı yuvarlamak ikisi de adayı olduğundan hazır göstermez. (Trabzon'da
  28 × %30 = 8,4 → 9 alındı.)
- Bir kalemin puanını belirleyen nitelik faaliyet kaydında yoksa (çağrılı makale,
  tezden üretilmiş yayın, bireysel/grup patent) **düşük satırı** gir.
- Cetvele girmeyen bir bölüm koşulun kümesindeyse, koşulu yine de gir ama
  dosya başlığında ve `kapsam_notu`'nda "baraj olduğundan zor görünür" diye
  uyar.
- **İstisna:** koşulun tamamı girilemeyen bir bölüme dayanıyorsa o eşiği HİÇ
  yazma. Yarısı eksik bir baraj, adaya asla sağlayamayacağı bir hedef gösterir.
  (Bitlis ve Bayburt'ta Güzel Sanatlar böyle bırakıldı.)

---

## 1. Cetvel dosyası (`database/data/cetvel/`)

### Dosya adı

`{universite-kisa}-{yil}.php` — yıl, yönergenin yürürlük ya da kabul yılı.
Örnek: `tarsus-2023.php`, `bandirma-2024.php`.

### Madde kodları

**Yönergenin kendi kodlarını birebir koru.** Koşullar tabloya kodla atıf yapıyor
("A.1-A.8 kategorilerinden", "1, 2, 6, 10 numaralı maddelerden"); kod
değiştirilirse koşulla cetvel arasındaki bağ kopar ve `SartAgaciTest` bunu
yakalayamaz.

Bir madde alt şıklara bölünüyorsa nokta veya harf ekle: `A.1.1`, `1.a`, `4.1.b`.
Kendi uydurduğun alt kod varsa (ör. çeyrekliğe göre böldüğün satırlar) yorum
satırında belirt: `// Kodlar (a-d) bize ait.`

### Grup deseninde NOKTA ZORUNLU

```php
// YANLIŞ — 'A.1*' deseni 'A.10.1' atıf kalemini de yakalar
'A.1-A.8' => ['A.1*', 'A.2*', ...],

// DOĞRU
'A.1-A.8' => ['A.1.*', 'A.2.*', ...],
```

Aynı tuzak tek haneli numaralarda daha da sinsi: `'1*'` deseni 10-19 arasını da
yakalar. Karabük, Manisa CBÜ, Bingöl, Bayburt ve Kilis'te bu yüzden bütün
gruplarda `'1.*'` biçimi kullanıldı. Numaralar tek haneli ve alt kodu yoksa
kümeyi **tek tek say** (Manisa CBÜ'de 46 kod elle yazıldı).

### Harf aralığı KODA DEĞİL, SIRAYA bakar

Bir yönerge kümeyi harf aralığıyla veriyorsa ("A-C kategorilerinden", "A-U
kategorileri arasından") aralığı `'A..U'` diye yazma: motorun `..` deseni
cetveldeki DİZİ SIRASINA bakıyor, harf sırasına değil. Bölümleri `gruplar`
altında tek tek say.

Türkçe alfabe ayrıca iki tuzak taşıyor: `A-J` aralığı I ile J arasındaki **İ**
bölümünü de kapsar, `A-U` ise **Ü**'den sonra gelen V ve Y'yi dışarıda bırakır
(İstanbul Sabahattin Zaim'in üç katmanlı barajı bu ayrımın üstüne kurulu).
Kümeler iç içeyse tanımladıktan sonra kapsamayı doğrula:

```bash
php artisan tinker --execute '
$k = app(App\Services\Scoring\Sart\SartDeposu::class)->katalog("YENI-CETVEL");
echo implode(", ", array_diff($k->coz(["*"]), $k->coz(["DIS_GRUP"])));'
```

### Kaynak sözlüğü

`kaynaklar` alanındaki değerler `App\Enums\Kategori::kaynaklar()` içinde tanımlı
sabit listeden gelir; yeni kaynak uydurma. Mevcut listeyi görmek için:

```bash
php artisan tinker --execute 'print_r(App\Enums\Kategori::Makale->kaynaklar());'
```

Bir yönerge kalemi sözlükte karşılıksızsa **girme** ve dosya başlığındaki
"GİRİLMEYEN KALEMLER" bölümüne yaz.

### Yazar katsayısı

`yazar_katsayisi.roller` altında her rol için `kademeler` (yazar sayısı → çarpan),
`sonrasi` (kademelerin dışı), `bol` (`pay / (n − eksi) + ek`) ya da `sonrasi_pay`
kullanılabilir. Çarpan hiçbir zaman 1.0'ı aşamaz (motor `min(1.0, …)` uyguluyor).

- Çarpan **yalnızca sıraya** bağlıysa (Karabük, Bingöl, Hakkari) bütün roller
  `sonrasi` kullanır, `kademeler` boş kalır.
- Çarpan **yalnızca kişi sayısına** bağlıysa (Tarsus) bütün roller aynı
  `kademeler`i paylaşır.
- `ortak` rolü (aday sırasını belirtmemiş) o yazar sayısındaki **en düşük**
  satırı almalı.
- Yönerge "birinci yazar" diyorsa `baslica` da en düşük satırı alır: sorumlu
  yazarlığa ayrıcalık tanımayan bir kuralda sırayı bilmeden yüksek satırı
  vermek puanı fazla gösterir (Alanya, ÜAK).
- Bölmenin **neyi** böldüğüne dikkat: yönergelerin çoğu tek bir tam puanı
  yazarlara pay ediyor, ama Alanya "birinci yazar tam puan alır VE tam puan
  diğer yazarlar arasında pay edilir" diyor — birinci yazarınki hiç bölünmüyor,
  ikinci bir tam puan kalanlara dağılıyor (`bol` + `eksi: 1`).
- `baslica`, yönerge "sorumlu yazar 1. isim gibi sayılır" diyorsa `ilk` ile aynı
  satırı alır.
- `haric` alanına, yönergenin kendi paylaşım kuralını yazdığı kategorileri koy
  (proje, patent, editörlük, ödül genelde böyledir) ve nedenini başlıkta yaz.
- Yönerge **kategoriye göre iki ayrı pay kuralı** veriyorsa (Yalova MADDE 10/4:
  makalede başlıca yazara ayrıcalık, "diğer yayınlarda (bildiri, kitap)" eşit
  bölüşme), cetvel başına tek matris tanımlanabildiği için her rolde **iki
  kuralın DÜŞÜK olanını** yaz. Yalova'da bu, `baslica` rolünün her yazar
  sayısında `sonrasi_pay: 1.0` (yani 1/n) almasına indi. Yüksek olanı seçmek
  çok yazarlı kitabın puanını fazla gösterir.

### Koşula bağlı çarpanı cetvele göm

Bir yönerge "şu birimde A grubu faaliyetler 1,3 katsayısı ile çarpılır" diyorsa
çarpanı koşula yazmaya çalışma — motorda `carpanlar` alanı yok. Çarpan aynı
birimde bütün kadrolarda geçerliyse cetvelin İKİ VARYANTINI üret (çarpanlı ve
çarpansız) ve eşikleri birime göre doğru varyanta bağla (Işık). Ham değerleri
float tutup çarpımdan **sonra bir kez** aşağı yuvarla; önce yuvarlayıp sonra
çarpmak farklı sonuç verir.

### Grup tavanları

`grup_tavanlari` yalnızca **sabit** tavan alır (`'ATIF' => 75`). Yüzdeye bağlı
tavan ("toplam puanın %20'sini aşamaz") ya da başka bir grubun toplamına bağlı
tavan motorda yok — uygulanmaz, `kapsam_notu`'nda uyarılır.

### `kapsam_notu`

Adayın gördüğü metin. Şunları söylemeli:

1. Puanların kaynağı.
2. Yazar çarpanı nasıl işliyor ve ne zaman uygulanamıyor ("yazar listesini boş
   bırakırsanız").
3. **Hangi yönde saptığı**: "puanınız olduğundan yüksek/düşük görünebilir".
4. Girilemeyen bölümler ve bunun kimi etkilediği.

---

## 2. Yönerge dosyası (`database/data/yonerge/`)

### Dosya başlığı

Docblock, dosyanın en değerli parçası. Şunları içermeli:

- Kaynak PDF ve yönergenin tarihi/karar numarası.
- Alan gruplarının nasıl ayrıldığı.
- **Bu yönergeyi diğerlerinden ayıran şey** (üç katmanlı baraj, ders barajı,
  ÜAK'a devretme, kayan pencere…).
- Girilmeyen her şey ve **nedeni**.
- Yorum gerektiren her karar ("yüzde sabit puana çevrildi", "kesirli değer aşağı
  yuvarlandı", "yüksek olan yazıldı çünkü…").

### Aday metinleri: KOD YASAK

`aciklama` alanları adaya gösteriliyor. Yönergenin kodlarını oraya yazma.

```php
// YANLIŞ
'1(a,b,c) kapsamında en az 40 puan'
'A.1-A.4 kapsamında en az 20 puan'
'EK-1 kalemlerinden toplam en az 1000 puan'

// DOĞRU
'SCI, SSCI veya AHCI dergilerindeki makalelerinizden en az 40 puan'
'Makale ve kitap kalemlerinizden en az 20 puan'
'Tüm faaliyetlerden toplam en az 1000 puan'
```

Kod, düğümün `madde` alanına yazılır (`madde: 'Madde 8.1/e'`); testler de oraya
bakar, böylece metin değişince test kırılmaz.

`Kalip::toplam` dönem verildiğinde dönemi metne kendisi ekliyor ("… en az 100
puan (doçentlik unvanınızdan sonra)"). Aynı kadroda iki toplam barajı olan
yönergelerde (GİBTÜ, OMÜ, İstinye) bu şart: yoksa aday iki satırda da aynı
cümleyi görüp farkı anlayamıyor.

`Kalip::toplam`'ın `liste` argümanı yalnızca **kapsam daraldığında** ve düz
Türkçe verilir. Kapsam cetvelin tamamıysa hiç verme.

`Kalip::puanDan` dönemi metne EKLEMİYOR — bunu yalnızca `toplam` yapıyor. Alt
baraj bir döneme bağlıysa dönemi `aciklama`ya elle yaz ("… doçentlik
unvanınızdan sonra en az 40 puan"). Yazılmazsa aday, yeniden atanma satırında
ilk atamanınkiyle birebir aynı cümleyi görüp neden puanının sayılmadığını
anlayamıyor (Nişantaşı'nda bu yüzden eklendi).

### Kalıplar

| Kalıp | Ne zaman |
|---|---|
| `Kalip::toplam($puan, $donem, $maddeler, $liste)` | genel puan barajı |
| `Kalip::puanDan($aciklama, $maddeler, $puan, $donem, madde:)` | alt baraj |
| `Kalip::adet($aciklama, $maddeler, $sayi, $yazar, $donem, telafi:, madde:)` | sayı koşulu |
| `Kalip::beyan($aciklama, $madde)` | kayıttan hesaplanamayan koşul |
| `Kalip::yds($puan)` | yabancı dil |
| `Kalip::ve` / `Kalip::veya` | birleştirici |
| `Kalip::sonYil($yil, $baslangic)` | kayan pencere (Düzce, Akdeniz) |

### `referans` düğümüne dikkat

`referans` hedef eşiğin ŞARTININ TAMAMINI çeker — puan barajları dâhil. Bir
yönerge "doçentliğin YAYIN koşullarını tekrarla" diyor ve profesörlüğün kendi
puan barajları ayrıysa (Dokuz Eylül Madde 1.14.3), `referans` adaya yönergede
yazmayan bir baraj gösterir. Böyle durumlarda koşulları bir kapanışa (closure)
alıp iki kadroda iki farklı dönemle çağır; kapanışa dönem ADINI da geçir, yoksa
aday metni "Doktora sonrası" derken motor doçentlik sonrasını filtreler.

Dönem sabitleri: `DOKTORA_SONRASI`, `DOCENTLIK_SONRASI`, `SON_ATAMA_SONRASI`.

### `beyan` ne zaman

Koşul faaliyet kaydından **hesaplanamıyorsa**. Örnekler: "başlıca araştırma
eseri olarak sunmak", "5 yıl çalışmış olmak", "deneme dersinden 75 almak",
"2 eserine 30 atıf yapılmış olmak" (kayıt atıf sayısını tutar, atıf alan eser
sayısını değil).

Hesaplanabilir bir koşulu beyana çevirme; beyan, adayın kendi onayına bırakılan
şeydir.

### Alan başına ayrı tablo ≠ alan başına ayrı cetvel

Bir yönerge her temel alan için ayrı tablo verse bile tabloların çoğu birebir
aynı olabilir. Önce **tabloları birbirine karşı diff'le**: İstanbul Kültür'ün
dokuz tablosundan yalnızca üçü puan olarak farklıydı (Hukuk ve Dil'de kitap
puanı, Güzel Sanatlar'da ek bölüm), kalan altısı ortak gövdeyi paylaştı. Dokuz
cetvel yazmak yerine bir gövde + üç varyant yeterli oldu; ÜAK dosyasındaki
`farklar` deseninin aynısı.

Ayrım genellikle cetvelde değil KOŞULDA: aynı puan tablosu üstüne her alan
kendi alt kapısını koyuyor.

### `birim` ne zaman

Aynı (üniversite, kadro, temel alan) üçlüsü için **birden fazla eşik** varsa.
Motor `bul()` içinde birden fazla aday bulursa `birim` ile ayırır; birim boşsa
`null` döner ve üniversite o alanda kapsam dışı görünür.

Kullanıldığı yerler: Sabancı (program bazlı), Karabük (tıp/diş/eczacılık
fakülteleri), Bingöl (Güzel Sanatlar ve Müzik alt alanları), Tarsus (Matematik ve
İstatistik), Trabzon (Güzel Sanatlar Fakültesi ↔ Devlet Konservatuvarı).

Eşiği temel alana değil FAKÜLTEYE bağlayan yönergelerde (Trabzon Tablo 1) fakülte
→ temel alan eşlemesi yapılır; iki fakülte aynı temel alana düşüp farklı baraj
veriyorsa ayrım yalnızca `birim` ile kurulabilir.

### Alan grupları KADRO BAŞINA değişebilir

Bir yönerge aynı alanları her kadroda aynı gruplamayabilir. Toros'ta sosyal
bilimler Dr. ve profesörlükte ayrı satırda (25 / 150) ama doçentlikte
mühendislik ve sağlıkla aynı satırda (120). Alan gruplarını dosyanın başında
bir kez tanımlayıp üç kadroda da kullanmak burada yanlış baraj üretirdi;
gruplar kadro başına ayrı yazıldı.

### Yönergenin anmadığı alanlar

Bir yönerge yalnızca "Fen, Mühendislik, Sağlık / Sosyal, Eğitim, Güzel Sanatlar"
diyorsa hukuk, ilahiyat, filoloji, spor, ziraat için eşik **yazma**. O alanları
bir gruba katmak, adaya yönergede yazmayan bir baraj göstermek olur. Kapsam dışı
kalması doğrusudur; Yönerge Analizi sayfası zaten bunu listeliyor.

### Barajın saydığı küme tablonun tamamı olmayabilir

Bir yönerge "tablodan toplam N puan" dese bile tablonun kendi ara toplam
satırları kapsamı daraltıyor olabilir. İstanbul Rumeli'nin ara değerlendirme
satırı "TOPLAM 1 PUANI (1.1;1.2;1.3;1.4;1.6)" diyor — editörlük-hakemlik (1.5)
ve atıflar (1.7) bölüm toplamının dışında; genel değerlendirme tablosu da bu
ikisini "TOPLAM" satırının ALTINDA ayrı raporluyor. Baraj cetvelin tamamına
bağlansaydı aday hakemlik ve atıf puanıyla barajı sahte biçimde aşardı.

Tabloyu çıkarırken ARA TOPLAM ve GENEL DEĞERLENDİRME satırlarını da oku:
hangi bölümlerin toplandığını, hangilerinin ayrı raporlandığını söylerler.
Daralma varsa `Kalip::toplam`'a `maddeler` grubu ve düz Türkçe bir `liste` adı
geç; satırlar cetvelde kalsın (aday puanını görsün) ama gruba girmesin.

### Tablo dipnotları da eşiğin parçası

Sayısal ölçütler yalnızca "BAŞVURU ESASLARI" paragrafında olmayabilir. Yalova
EK-C'de puan tablosunun bölüm altlarına dört zorunluluk daha serpiştirilmiş
("Bu maddenin a bendi kapsamında en az 10 puan alınmalıdır", "Bu madde
kapsamında en az 1 yayın zorunludur"). Bunlar kadro paragrafı kadar bağlayıcı;
tabloyu çıkarırken satır aralarındaki notları da oku ve koşula çevir. Dipnot
hangi kadroları bağladığını söylemiyorsa hepsine uygula, söylüyorsa (Yalova'nın
1. bölüm dipnotu yalnızca doçent ve profesöre) yalnızca onlara.

### Tek harflik fark koşulu değiştirir

Aynı kategori aralıklarını sayan iki paragraf farklı çekim eki taşıyabiliyor.
İstanbul Yeni Yüzyıl'da Sosyal-Hukuk paragrafı "1.A1-21, 1.A25-27 ve 1.A31
kategorilerinin **birinde** en az iki yayın" derken Sanat paragrafı aynı üç
aralık için "kategorilerin**de** en az iki yayın" diyor. Birincisi üç kümeden
BİRİNDE iki yayın (`Kalip::veya` ile üç ayrı `adet`), ikincisi üçünün
birleşiminde iki yayın (tek `adet`, üç desen). Aradaki fark bir harf ama biri
ötekinden zor. Aralıkları kopyalarken eki de oku.

### Kaynaktaki hatayı DÜZELTME, kaydet

Yönergelerde kopyala-yapıştır hataları çıkıyor: Yalova EK-D'nin "PROFESÖR
KADROSUNA BAŞVURU" paragrafı doçentlik paragrafının kelimesi kelimesine
aynısı ve "Doçentlik kadrosuna atama için…" diye başlıyor; Toros'un proje
satırlarında araştırıcı (8) yürütücüden (6) fazla puan alıyor; Yalova EK-A'nın
11c bendi ödül bölümünde "Tescil edilmiş faydalı model" yazıyor. Üçü de
olduğu gibi girildi. Gerekçe: aday jüriye bu metinle gidiyor, bizim
"düzeltilmiş" okumamızla değil. İki istisna:

- Hata puanı **fazla** gösterecekse satırı hiç yazma (Yalova 11c: faydalı model
  zaten 10c'de 5 puan alıyor, ödül bölümünde 25 puan daha vermek çifte sayım
  olurdu).
- Her hâlde dosya başlığına ve `aday_notu`'na yaz; Yalova profesörlüğünde aday
  notu "başvurmadan önce üniversiteye teyit ettirin" diyor.

### Girilmeyen tipik koşullar

- **Yeniden atanma**: koşullar genelde "her yıl için N puan" ya da "son atama
  tarihinden sonra" biçiminde; atama tarihi ve dönem uzunluğu profilde yok.
  Aday notunda anlat, eşik yazma.
- **Yüzdeye bağlı hesap**: sabit puana çevrilebiliyorsa çevir (toplam biliniyorsa
  "%50'si" → sayı). Çevrilemiyorsa girme.
- **Kurum/süre bilgisi gerektiren koşullar**: "üniversite dışından geliyorsa",
  "3 aydan uzun yurt dışı araştırma".

---

### Üniversite adı `universiteler.php`'de OLMALI

`yonerge/*.php`'deki `universite` alanı serbest metin, hiçbir şeye bağlı değil.
Yönerge Analizi ekranı ise `Universite` tablosunu gezip her satırın adıyla
`SartDeposu::bul()` çağırıyor — yani adı `database/data/universiteler.php`
içinde geçmeyen bir üniversitenin eşikleri hesaplanır, testleri geçer ve
adaya HİÇ GÖRÜNMEZ. Yeni üniversite girerken listede olup olmadığını kontrol
et, yoksa ekle; adı birebir aynı yazılmalı.

`SartAgaciTest` bunu artık test ediyor ("her eşiğin üniversitesi
universiteler.php'de tanımlıdır"), ama adı listeye eklerken **veritabanındaki
satırı da düşün**: `UniversiteSeeder` `ad` alanına göre `updateOrCreate`
yapıyor, yani veri dosyasındaki bir adı DEĞİŞTİRMEK yeni satır açıp eskisini
öksüz bırakır — aynı üniversite listede iki kez, biri eşiksiz görünür.
Yeni ad ekleme sorunsuz; ad değiştirmek migration ister (örnek:
`2026_08_26_112754_bezmialem_universite_adini_duzelt.php`).

---

## 3. Doğrulama sırası

Her üniversiteden sonra, bu sırayla:

```bash
php -l database/data/cetvel/YENI.php && php -l database/data/yonerge/YENI.php
vendor/bin/pint --dirty --format agent          # --dirty ŞART, yoksa ilgisiz dosyaları biçimler
php artisan test --compact                       # 318 test; madde referans testi asıl ağ
vendor/bin/phpstan analyse --no-progress         # 14 hata baseline; artmamalı
```

Sonra grupların gerçekten çözüldüğünü gör:

```bash
php artisan tinker --execute '
$d = app(App\Services\Scoring\Sart\SartDeposu::class);
$k = $d->katalog("YENI-CETVEL");
foreach (["GRUP_ADI"] as $g) printf("%-20s %d\n", $g, count($k->coz([$g])));'
```

**`SartAgaciTest` içindeki madde referans testi** korpusun ana güvenlik ağı:
koşulun andığı her madde deseninin cetvelde karşılığı olduğunu doğrular. Yanlış
kod yazılırsa koşul hata vermez, sessizce hiçbir faaliyeti saymaz — bu test dört
sessiz hatayı yakaladı.

---

## 4. PDF'ten tablo çıkarma

`pdftotext -q -layout` ile başla. Sonra sütun konumunu bul:

```bash
python3 -c "
import re, io, collections
L = io.open('cikti.txt', encoding='utf-8').read().split('\n')
c = collections.Counter()
for t in L:
    for m in re.finditer(r'(?<=\s)\d{1,4}(?=\s*\$)', t): c[m.start()] += 1
print(c.most_common(6))"
```

En sık görülen konum puan sütunudur; gövdeyi `t[:konum]`, puanı `t[konum:]`
diye böl.

### Tekrar eden tuzaklar

- **Sayfa numarası puan sütununa karışıyor.** Sütun konumuyla ayır; sayfa
  numarası genelde farklı kolonda.
- **Madde numarası, metin ve puan üç ayrı satırda.** Numara göründüğünde önceki
  maddeyi kapatan bir birikim mantığı gerekir. Ama önce ham `-layout` çıktısına
  bak: Iğdır bu teşhisle bir tur bekletilmişti, oysa tablo zaten okunuyordu.
- **Çok değerli hücre** (`20/5`, `Q1 200 / Q2 160`): ayrı maddelere böl.
- **Olumsuzlama devam satırında** ("… hariç olmak üzere"): puan ilk satırdaysa
  madde erken kapanır ve olumsuzlama kaybolur. Çukurova'da bir kalem bu yüzden
  tamamen düşmüştü.
- **Python `İ`.lower()** birleşik nokta üretir; `İ`→`i` elle değiştir. Ama
  `I`→`ı` yapma, ASCII kısaltmaları bozar (SCI→scı).
- **Sütun dilimlemesi tabloyu düşürebilir, PDF suçsuz olabilir.** Trabzon'un
  Tablo 2'si, Iğdır'ın EK-1'i, İnönü'nün EK-1'i ve İTÜ'nün beş tablosu birer
  tur "tablo okunmuyor" diye bekletildi; DÖRDÜNDE DE düz `pdftotext -q -layout` çıktısı
  tabloyu eksiksiz veriyordu. Kayıp PDF'ten değil, üstüne yazılan sütun
  dilimleme adımından geliyordu. Bir tabloyu okunamaz ilan etmeden önce HAM
  `-layout` çıktısına bak: satır etiketi kayıyor gibi görünen tablolarda puan
  çoğu zaman kodun ya da açıklamanın bir ÜSTÜNDEKİ satırda duruyor,
  kaybolmuyor. Şıkların puanları hemen her zaman azalan sırada (a > b > c);
  hizayı çözerken bu iyi bir çapraz kontrol.
- **`-layout` sütunları karıştırıyorsa `-layout`'SUZ dene.** Sütunlar arasında
  tam boş şerit olmayan tablolarda (İstanbul Üniversitesi'nin dört kadro
  sütunu) `pdftotext -layout` hücreleri yan yana eziyor. `-layout` OLMADAN
  çalıştırıldığında pdftotext hücreleri okuma sırasına göre tek tek döküyor ve
  sütunlar kendiliğinden ayrılıyor. İki modu da dene: biri tablo, diğeri düz
  metin için daha iyi.
- **Kolon çapasını en dolu satırdan al.** Alan sütunlu koşul tablolarında
  (İnönü'nün on bir sütunu) seyrek satırlar yanlış sütuna düşer. Bütün
  hücreleri dolu bir satır bul ("Toplam puan" genelde öyledir), konumlarını
  çapa yap, kalan satırların sayılarını en yakın çapaya ata. Toleransı 10-12
  karakter tut: dört haneli ve tek haneli hücreler aynı sütunda birkaç
  karakter kayık hizalanıyor. Aynı belgedeki her tablonun KENDİ çapası olur.

---

## 5. Commit

Üniversite başına bir commit. Mesaj gövdesi şunları saymalı:

- Ne girildi, korpusun yeni sayısı.
- Bu yönergeyi ayıran yapısal özellik.
- Verilen her yorum kararı ve **hangi yönde saptığı**.
- Girilmeyenler ve nedeni.

Girilemeyen yönergeler `GIRILEMEYEN-YONERGELER.md`'ye yazılır: tam engeller,
kısmen girilenler tablosu, motorun karşılayamadığı kurallar.

---

## 6. Kuyruğun bugünkü hâli

179 PDF içinde:

| Durum | Sayı |
|---|---|
| Girildi | 73 üniversite · 2408 eşik · 100 cetvel |
| Taranmış (metin yok) | 10 |
| Bozuk font / kötü OCR | 2 (Çankaya, Munzur) |
| Yönerge değil (üst yazı) | 1 |
| Kaynak sorunuyla bekleyen | 3 (Balıkesir, Türk Hava Kurumu, Maltepe — puan tablosu PDF'te yok) |
| Girilmemiş, engeli bilinmeyen | 100 (metni okunur; liste için PDF taraması yapıldı) |

**Kendi puan tablosu olmayanlar hızlı şerit**: cetvel çıkarma adımı düşer,
yalnızca koşullar girilir (ÜAK cetveline bağlananlar `uak-2024-mart-{alan}`
kullanır). Bu şeridin girilenleri: İskenderun Teknik, Boğaziçi, Galatasaray,
İstanbul Medipol, İstanbul Galata, İstanbul Topkapı, Bezmiâlem, İstanbul
Ticaret, TED, Atılım. Bekleyenler `GIRILEMEYEN-YONERGELER.md`'de.

Kalanların çoğu kendi puan tablosunu taşıyor; her biri cetvel çıkarma +
koşul girme adımını birlikte istiyor.
