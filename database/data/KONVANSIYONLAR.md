# Yönerge girişi konvansiyonları

Bu belge, `database/data/cetvel/` ve `database/data/yonerge/` altındaki dosyaları
yazarken uygulanan kuralları anlatır. Amacı, işi başka birinin (ya da başka bir
oturumun) aynı kararları vererek sürdürebilmesi.

175 üniversite bu kurallarla girildi. Kuralların çoğu bir hatadan sonra yazıldı;
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

### "Okunamadı" demeden önce SAYFA GÖRÜNTÜSÜNE bak

`pdftotext` metin katmanı olan PDF'te bile hücre kaybediyor. İki tipik sebep:

  Satır iki satıra taşıyor ve puan sütunu ikinci satırın hizasında kalıyor
      (İstanbul Arel A.3.c — değer 5 puandı, "boş" sanılmıştı).
  Tavan parantez içinde ve sütun sınırının dışına taşıyor
      (Erzurum Teknik'in doçentlik tavanları — metin çıkarımı bir sayfada tek
      bir 150 gösterirken görüntüde 40 ve 30 da vardı).

Tarif:

```bash
pdftoppm -r 190 -f <sayfa> -l <sayfa> -png kaynak.pdf cikti
magick cikti-<n>.png -crop 100%x40%+0+800 kirpik.png   # gerekiyorsa
```

Sonra görüntüyü doğrudan oku. 170-190 dpi tablo için yeterli; sayfanın
tamamı büyükse dikey kırpma okunabilirliği artırıyor.

Bu, taranmış PDF'ler için zaten kullanılan OCR tarifinin yerine geçmez —
onun tamamlayıcısıdır ve METİN KATMANI OLAN dosyalarda da gerekir. Bir
değeri "okunamıyor" diye kaydetmeden önce mutlaka dene.

### ÖNCE DOSYA ADINI DOĞRULA — "okunamadı"ların çoğu buradan çıktı

01.09.2026'daki taramada dosya başlıklarındaki `Kaynak: pdf/…` adlarının
YİRMİSİ var olmayan dosyalara işaret ediyordu (ön ekteki zaman damgası
farklı; üniversite adı son eki doğru). Kaynağı yoklamak isteyen "dosya yok"
alıyor ve satırı "okunamadı" diye bırakıyordu.

Kayıtlı "puan sütunu ayrıştırılamadı" notlarının DÖRDÜ DE (Bayburt, Kilis,
Hatay MKÜ, Osmaniye) bu listedeydi; dördünde de tablo `pdftotext -q -layout`
ile eksiksiz çıkıyordu. `CetvelKaynakTest` artık her başlıktaki dosyanın
varlığını kontrol ediyor, ama bir değeri okuyamadığında ilk bakılacak yer
yine dosya adı.

### "OKUNAMADI" NOTUNUN İKİ AYRI ANLAMI VAR — KARIŞTIRMA

Korpusta "okunamadı" iki bambaşka şeyi anlatıyor ve yalnızca biri düzeltilebilir:

- **KAYITTAN okunamıyor** — adayın faaliyet kaydı o niteliği taşımıyor
  (sorumlu yazar sırası, bursun süresi, derginin uluslararası mı ulusal mı
  olduğu). Kaynak gayet okunuyor; sorun sözlükte. Bunlar düzeltilemez,
  §0 uyarınca düşük satır girilir ve olduğu gibi kalır.
- **KAYNAKTAN okunamadı** — metin çıkarımı hücreyi düşürmüş. Bunlar
  DÜZELTİLEBİLİR ve düzeltilmelidir.

Tarama yaparken ayrım için şu kalıplara bak: "kayıttan / profilden /
faaliyet kaydından / etiketten okunamıyor" birinci sınıf; "kaynakta /
PDF'te okunamadı", "ayrıştırılamadı", "kesik", "sütunu eksik" ikinci sınıf.

### "AYRIŞTIRILAMADI" NOTU ÇOĞU ZAMAN FAZLA SAYAN BİR SATIR SAKLIYOR

Bir bölüm okunamadığında iki şey oluyor ve İKİNCİSİ daha zararlı:

1. Bölüm hiç girilmiyor — aday o kalemden sıfır alıyor (Hatay MKÜ'de
   patentler, Bayburt ve Kilis'te bütün sanat bölümü).
2. Bölüm TEK SATIRA İNDİRİLİP EN YÜKSEK DEĞERLE giriliyor — aday hak
   etmediği puanı alıyor. İstanbul Ticaret'te bütün editörlük etiketleri
   120 puanlık baş editörlük satırındaydı: bir hakemlik kaydı 120 puan
   ediyordu. Kahramanmaraş İstiklal'de proje satırları rolsüzdü, bursiyer
   yürütücü puanı alıyordu.

Bir "ayrıştırılamadı" notu gördüğünde bölümü yalnızca EKLEME diye değil,
**mevcut satırların değerlerini kaynakla karşılaştırma** işi olarak da ele al.

### TAVAN DEĞERİ SATIR DEĞERİ SANILABİLİR

İstanbul Ticaret'te "Yönetiminde tamamlanan her tez için: (Toplamı 75 puanı
aşamaz) a. Doktora 10 b. Yüksek Lisans 5" satırı cetvele HER TEZ 75 PUAN diye
girilmişti; iki tez yöneten aday 150 puan görüyordu. Aynı hata jüri satırında
da vardı (50).

Parantez içindeki "toplamı … aşamaz" bir SATIR değeri değil `grup_tavanlari`
kaydıdır. Bir satırın puanı bölümün toplam sınırına eşitse dur ve alt
şıklara bak.

### DİPNOT HANGİ SÜTUNA BAĞLI? ÜST SİMGEYE BAK

Ordu'nun tablolarında dipnot numaraları hücrelerin içinde üst simge olarak
duruyor ve metin katmanına düz rakam olarak düşüyor: profesör sütununda
"en az 120 puan⁴", doçent sütununda "en az 100 puan³". Yani "(3) hangi
kadroya bağlı" sorusu tahmin işi değil, okuma işi. Aramak için:

```bash
grep -oE "(puan|zorunludur|alınır|alınabilir)\.?[0-9](,[0-9])?" cikti.txt
```

Bir tablo dipnotunu "hangi bende bağlandığı belirsiz" diye bırakmadan önce
bunu dene.

### FAZLA SAYAN SATIRI KORPUSUN KENDİSİYLE BUL

01.09.2026'da 394 cetvel fazla sayan satır için tarandı. En verimli yöntem
korpusu kendi ölçütü yapmak:

1. Her cetvelde her kategori için etiketlerin ALDIĞI EN YÜKSEK puanı çıkar
   (motor `puan()` içinde max alıyor, aday fiilen onu görür).
2. Kategorinin o cetveldeki en yüksek değerine bölerek etiketin GÖRECE
   KADEMESİNİ (0..1) bul.
3. Korpus genelinde her etiketin MEDYAN kademesini hesapla — bu, "bu iş
   normalde bölümün neresinde durur" sorusunun cevabı.
4. Bir satırda tipik kademesi çok uzak iki etiket varsa VE satırın değeri
   yüksek olanın kademesine yakınsa, düşük olan yukarı taşınmış demektir.

Ham çift sayımı işe yaramıyor: sanatsal etkinlik kategorisinde 134 etiket var
ve kaynaklar onları meşru biçimde tek satırda topluyor. İki kısıt gerekiyor —
yalnız AYNI SATIRDAKİ etiketler ve yalnız kademe değil BAŞKA BİR İŞ olan
çiftler (hakemlik ↔ baş editörlük, bursiyer ↔ yürütücü, burs ↔ bilim ödülü,
kurul üyeliği ↔ rektörlük, 2209 danışmanlığı ↔ AB projesi).

**Çeyreklik birleşmeleri YANLIŞ POZİTİFTİR.** Birçok yönerge SCI dergilerinin
tamamına tek puan veriyor; `SCIE/SSCI (Q4)` ile `(Q1)` aynı satırda olması
kaynağın kendi tercihi. Aynısı uluslararası/ulusal patent için de geçerli.
Detektörü kategori bazında değil, ETİKETİN İŞ TÜRÜ bazında kur.

İkinci detektör daha basit ve çok verimliydi: **proje satırı taşıyıp hiçbir
satırında `roller` alanı olmayan cetveller.** On tane çıktı, dördü gerçekten
rol kademesi taşıyordu; birinde bursiyer yürütücü puanını alıyordu (Amasya,
10 yerine 150).

### ROL AYRIMI ATLANIRSA KOŞUL DA SAHTE SAĞLANIR

Fazla sayan satırın ikinci zararı puanda değil KOŞULDA. Sakarya UBÜ'de BAP ve
özel sektör projeleri kaynağın 4.6-4.7 satırlarına aitken 4.4'e yazılmıştı;
yönergenin "4.1, 4.2, 4.3, 4.4 proje faaliyetlerinden en az bir proje" koşulu
bu yüzden bir BAP projesiyle sağlanıyordu. Kocaeli'de TÜBİTAK 2209
danışmanlığı aynı biçimde "H.1-H.17" koşulunu sağlıyordu.

Bir etiketi satıra yazarken **satırın hangi gruplara girdiğine** de bak: puanı
doğru ama grubu yanlış bir satır, barajı olduğundan kolay gösterir.

### ETİKETİ SİLMEDEN ÖNCE KOŞUL ONA BAĞLI MI DİYE BAK

Fazla sayan bir etiketi satırdan çıkarmak, o etikete dayanan bir KOŞULU da
karşılıksız bırakabilir. Dokuz Eylül'de yarışma ödülü 18.b.1'e bağlıydı ve
konservatuvar koşulu ("yarışma, festival veya bienalden ödül almış olmak")
tam o kodu sayıyordu; etiket silinince koşul hiçbir faaliyetle eşleşmez oldu.
Madde referans testi bunu anında yakaladı, ama doğru çözüm silmek değildi:
kaynağın o kalemi için KENDİ SATIRINI açıp koşulu oraya bağlamaktı.

Sıra şu: (1) etiket hangi satırlarda geçiyor, (2) o satırlar hangi gruplarda,
(3) o gruplara hangi koşullar bağlı. Üçü de temizse sil; değilse doğru
değerde yeni satır aç ve referansı taşı.

### EKSİK SAYAN SATIR TARAMASI: TERS YÖN VERİMSİZ, SEBEBİNİ BİL

Fazla sayan satır detektörünün (yukarıdaki başlık) sapma işareti ters
çevrilerek EKSİK SAYAN satırlar da arandı: bir etiketin, korpustaki tipik
kademesine göre ÇOK DÜŞÜK bir satırda durduğu yerler. 02.09.2026'da 394
cetvel tarandı; 606 ham işaretten yalnız 171'i "bu satır etiketin o
cetveldeki EN YÜKSEĞİ" kısıtından geçti (kısıt şart: etiket başka bir
satırdan yüksek puan alıyorsa motor zaten onu seçiyor, bulgu boş).

**Kalanın hemen tamamı YANLIŞ POZİTİF çıktı ve sebebi yapısal:** ters yön,
kaynağın KABA TABLO tercihiyle gerçek hatayı ayıramıyor. Bir yönerge dergi
editörlüğünün tamamına 1 puan veriyorsa (Işık F.3.a), sanatsal etkinliğin
otuz türünü tek satırda topluyorsa (nevşehir E.5, 96 etiket) ya da ERC
ödülünü "bilimsel araştırma bursu" satırına koyuyorsa (İstanbul Arel M.3.b)
bu KAYNAĞIN KENDİ KARARI, cetvelin hatası değil. İleri yönde aynı belirsizlik
FAZLA saydırdığı için düzeltilmesi zorunluydu; ters yönde §0 zaten hoş
görüyor.

Ters taramanın bir işi var, o da şu: sayısal sapmayı değil, **satır
başlığının etiketle ilgisizliğini** aramak. "BKCI Kitap"ın "diğer hakemli
DERGİDE editörlük" satırında durması (Tarsus 7.d) sayı olarak da anlamsız,
metin olarak da. Ama bu, istatistikle değil okumayla bulunuyor.

Pratik sonuç: **ters yönü tekrar taramaya değmez.** Aynı emek grup tavanı
taramasına harcanırsa (aşağıdaki başlık) doğrudan §0 ihlali bulur.

### GRUP TAVANI TARAMASI: KAYNAKTAKİ "EN FAZLA N PUAN"I CETVELLE KARŞILAŞTIR

02.09.2026'da bütün korpus bu yöntemle tarandı ve **on dört üniversitede
elli beş eksik tavan** bulundu. Tavansız bir bölüm doğrudan fazla saydırır,
yani her bulgu bir §0 ihlali. En verimli tarama bu oldu.

Yöntem:

1. Her cetvel dosyasının docblock'undaki `Kaynak: pdf/…` adından kaynak
   metnini bul, `pdftotext -q -layout` ile aç.
2. Metinde tavan ifadelerini ara. İşe yarayan desen:

   ```
   (en fazla|en çok|azami) …{0,30} N puan
   N puan(ı|ın)? (aşamaz|geçemez|aşmamak|sınırlıdır|aşan kısmı)
   ```

   **"en az" geçen eşleşmeyi ELE**: "toplamda en az 100 puan" baraj, tavan
   değil. Bu filtre olmadan gürültü üç katına çıkıyor.
3. Bulunan değerleri cetvelin `grup_tavanlari`'ndaki değerlerle karşılaştır.
   İki kova ayır: `grup_tavanlari` HİÇ YOK olanlar (en verimli) ve tavanı
   olup bazı değerleri eksik olanlar.
4. Her bulgu için **tavanlı satırın cetvelde karşılığı var mı** diye bak.
   Yoksa bulgu düşer — tavan zaten uygulanamaz.

Tarama üç yanlış pozitif sınıfı üretiyor, üçünü de tanı:

- **ÖLÇEKLİ TAVAN.** Harran bütün tavanlarını 0,7 (A bölümü) ve 0,3 (C)
  ile çarparak yazıyor: kaynakta 30, cetvelde 21. Değer karşılaştıran tarama
  hepsini "eksik" sanıyor; otuz altı işaretin tamamı yanlış pozitifti.
- **SATIRI GİRİLMEMİŞ BÖLÜM.** Kaynağın tavanı var ama o bölümün maddeleri
  kaynak sözlüğünde karşılıksız olduğu için hiç girilmemiş (Ankara'nın dergi
  editörlüğü, Atatürk'ün elli beş tavanının tamamı, Ordu'nun F.34-F.59'u).
- **UYGULANAMAZ TAVAN.** Üç biçimi var ve üçü de motorda karşılıksız:
  YIL/YARIYIL başına ("yıllık en fazla 15 puan" — Ankara; "bir yarıyılda en
  fazla 5 puan" — Yozgat Bozok), AYNI ESERE özgü ("bir kitaptan en fazla 40
  puan" — Kahramanmaraş İstiklal; Yalova'nın ISBN kuralıyla aynı sınıf) ve
  MAKALE BAŞINA ("bir makale için en çok 50 puan" — PAÜ).

**KAYNAK ADI EŞLEŞTİRMESİNİ BOŞLUKTA KESME.** İlk turda desen
`Kaynak: pdf/([^\s]+)` idi ve dosya adında BOŞLUK olan yirmi dört cetveli
sessizce taramanın dışında bıraktı ("…Aydın Adnan Menderes Üniversitesi.pdf").
Desen ".pdf" uzantısında bitmeli. Docblock'ta İKİ SATIRA taşan adlar (Adana
ATÜ, AYBÜ) satır bazlı desenle yine bulunmuyor; sayı azsa elle tara.

### AYNI İKİ BÖLÜM BİR KADRODA ORTAK, ÖTEKİNDE AYRI TAVANLI OLABİLİR

Kocaeli'nin Tablo 2'si ders (E) ve idari görev (K) bölümlerini AYRI AYRI 50
ile sınırlıyor; ama Madde 11/b yeniden atanmada ikisini BİRLİKTE sınırlıyor:
"derslerden … ve varsa idari faaliyetlerden … en fazla 50 puan dikkate
alınmak üzere". İki ayrı 50, yeniden atanmada 100'e kadar puan üretir.

Bu fark BÖLÜM GİRİLENE KADAR GÖRÜNMEZ: K bölümünün satırı yokken E'nin tek
başına 50'si ortak tavanı zaten sağlıyordu. Yeni bir bölüm girerken "bu
bölüme atıf yapan başka madde var mı" diye ara; varsa tavanın kapsamı
kadrodan kadroya değişiyor olabilir ve cetvel varyantı gerekir
(`kocaeli-2023-yeniden`).

**VARYANT BAĞLANDIĞINI DA TESTE YAZ.** Cetvelin içeriğini doğrulayan test,
eşiğin o cetvele bağlı olduğunu doğrulamıyor: ilk yazımda yeniden atanma
eşiğini eski cetvele geri bağlamak testi KIRMADI. `bul()` sonucunun `cetvel`
alanını da assert et.

### TAVAN KAPSAMI: ANAHTAR GRUP MU, TEK MADDE Mİ?

`grup_tavanlari` anahtarı `coz()` ile çözülüyor ve bir grup adı, bir madde
kodu ya da bir desen olabilir. Bu esneklik iki sessiz hata üretiyor:

- **ÖLÜ TAVAN**: anahtar hiçbir maddeye düşmüyor, tavan yok sayılıyor.
- **KAPSAMI DAR TAVAN**: anahtar bir GRUP değil TEK MADDE. Tavan yazılmış
  görünür ama yalnız o satırı keser. Ege'de "Bu kategoride en çok 75 puan
  alınır" tavanı `'7a-Q1' => 75` diye duruyordu; Q2, Q3 ve Q4 dergilerdeki
  editörlükler sınırsız sayılıyordu.

`CetvelKaynakTest` ikisini de tarıyor: ölü tavan doğrudan kırıyor, tek
maddeye düşenler bilinen listeye karşı doğrulanıyor. Yeni bir tavan
yazarken sor: **kaynak bu sınırı SATIRA mı KATEGORİYE mi koyuyor?**
Kategoriye koyuyorsa `gruplar` altında kümeyi açıkça tanımla ve tavanı ona
bağla. Tek maddelik bir küme bile olsa grup olarak tanımlamak tercih
edilir: kapsamın bilinçli seçildiğini gösterir.

### TAVAN KADROYA GÖRE DEĞİŞİYORSA VARYANTLA, "YAZILAMADI" DEME

Eskişehir Teknik'in EK-5'i makale puanı hücresinde "1a-f kapsamında X puan
(1f kapsamında en fazla Y puan alınabilir)" diyor ve Y kadroya göre
değişiyor (75 · 45 · 150). Dosya bunu bir tur "motorun `grup_tavanlari`
alanı cetvel geneline uygulandığı için YAZILAMADI" diye kaydetmişti.

Yazılabilir: cetveli kadroya göre varyantla. Gövde bir kapanışa alınır,
tavan parametre olur, `return ['cetveller' => …]` varyantları birden
döndürür ve her eşik kendi varyantına bağlanır. Ordu, Yalova, Acıbadem ve
MEF'te kullanılan yolun aynısı.

Varyantlarken **tavanın hangi alan gruplarına ait olduğuna** da bak:
Eskişehir Teknik'te tavan yalnız makale barajı `1a-f` olan gruplara ait,
`1a-e` kullanan mühendislik ve fen tavansız gövdede kaldı. Tavanı onlara da
uygulamak kaynağın koymadığı bir sınır getirirdi.

### ADET TAVANI PUANA ÇEVRİLİRKEN BİRLEŞİK SATIRA DİKKAT

MSGSÜ ve Ardahan tavanlarını adet olarak veriyor ("en çok üç adet", "* Azami
N puan"). Satır puanı sabitse çeviri düz: adet × puan. Ama cetvel kaynağın
BİRDEN ÇOK SATIRINI tek satırda topladıysa (MSGSÜ 4.1.5 = kaynağın
4.1.5-4.1.7'si; Ardahan 3.11.6 = 3.11.6-3.11.9) kaynak tavanı her alt satıra
AYRI veriyor ve birleşik satırda hangisinin geçerli olduğu bilinemiyor.

Karar: **tek alt satırın tavanını yaz.** Aday o kalemde puanını olduğundan
düşük görebilir; alternatifi (tavansız bırakmak) fazla saydırır ve §0'ı
ihlal eder. Birleşmeyi cetvel dosyasında yaz ki sonraki tur bunu hata
sanmasın.

### KUYRUĞU NEREDE KESMEK GEREKİR

Detektörün kuyruğu uzun ve sonu getirilemez: 686 aday satırın çoğu kaynağın
kendi kaba tablosudur. İki eleme kuralı işe yaradı:

- **Satır başlığı etiketi zaten anıyorsa dokunma.** "Üniversite birimlerinde
  yöneticilik VEYA YÖNETİCİ YARDIMCILIĞI" diyen bir satırda bölüm başkan
  yardımcısının durması doğrudur (Çanakkale). Ölçüt istatistik değil, satırın
  kendi metnidir.
- **5 puanın altındaki sapmaları kovalama — AMA YALNIZ PUAN BARAJLARI İÇİN.**
  Aday toplamları yüzlerce puan mertebesinde; üç puanlık bir yanlış yerleşim
  hiçbir puan barajını çevirmez, doğrulama maliyeti faydasını aşar.

  **Bu gerekçe SAYI SAYAN koşullarda geçersiz.** `SartDegerlendirici::adet()`
  eşleşen faaliyetleri SAYIYOR, puanına hiç bakmıyor: iki puanlık bir satır
  yanlış gruptaysa "en az üç bildiri" koşulunu iki yüz puanlık bir satır kadar
  eksiksiz sağlar. Kuyruğu keserken ölçüt "sapma kaç puan" değil, **satır bir
  `adet` koşulunun kümesinde mi** olmalı.

  02.09.2026'da ölçüldü: kuyruğun 376 satırından 306'sı yalnız puan barajlarına
  giriyor (kesilebilir), 27'si hiçbir koşula girmiyor (yalnız listedeki toplamı
  etkiler), **43'ü bir `adet` koşulunu besliyor**. O 43'ün tekilleştirilmiş 21
  satırı elle okundu; çoğu kaynağın meşru kaba tablosu, tek açık hata Yalova'nın
  "poster hariç" satırlarıydı ve puan büyüklüğüyle değil SATIR BAŞLIĞIYLA
  görülüyordu.

Kalan işaretlerin çoğu özet/poster bildiri ile kurul üyeliğinde toplanıyor ve
bilinçli olarak bırakıldı.

### ETİKET LİSTELERİ KOPYALANIR: "KAYNAK BU KELİMEYİ HİÇ GEÇİRİYOR MU?" DİYE SOR

Bir satırın `kaynaklar` listesi kaynaktan OKUNARAK değil, benzer bir
satırdan KOPYALANARAK da dolabiliyor. Sonuç sessiz: etiket sözlükte var,
satır ölü değil, test kırılmıyor — yalnız o etiketi kaydeden aday hak
etmediği satırdan puan ve daha kötüsü SAYI alıyor.

`Akreditasyon Faaliyeti` korpusun 59 cetvelinde DERS satırlarının etiket
listesindeydi (63 satır). Etiket `egitim_ogretim`in ders DIŞI karşılığı;
ilk kullanımı da öyleydi (Gümüşhane M4, "eğitim-öğretim danışmanlığı").

**Teşhisi tek soru veriyor: kaynak metni o kavramı hiç anıyor mu?** 59
kaynaktan ELLİSİ "akredit" sözcüğünü hiç geçirmiyordu — okunan bir şey
olamayacağının kanıtı. Geçen dokuzun altısı da alakasızdı ("uluslararası
akredite bir kuruluşun (QS, ARWU) sıralaması", "akredite olmuş programda
verilen ders" — orada sıfat PROGRAMI niteliyor, faaliyeti değil).

Tarama ucuz ve genelleştirilebilir:

```bash
# etiketi taşıyan cetvellerin kaynaklarında kavramın kökü geçiyor mu?
grep -l "ETİKET" database/data/cetvel/*.php   # sonra her birinin Kaynak: satırından
                                              # metne git ve kökü ara
```

Zarar PUANDA küçük, SAYIDA tam: `adet()` puana bakmadan faaliyet saydığı
için akreditasyon kaydı olan aday "bir dönem ders vermiş olmak" koşulunu
sağlamış görünüyordu.

**Düzeltirken etiketi silmekle yetinme.** Kaynak o kalemi gerçekten
puanlıyorsa KENDİ SATIRINI aç (Dokuz Eylül dersinin aynısı): OMÜ 14.4 (6),
Yozgat B5.4.2 (3), Işık H.3.c (3) böyle açıldı. Kaynak puanlamıyorsa etiket
o cetvelde karşılıksız kalır ve doğrusu budur — `kapsam_notu`'na uyarı da
gerekmez, çünkü aday hak ettiği bir şeyi kaybetmiyor.

Sızıntıyı `CetvelKaynakTest` artık koruyor: ders etiketlerinden biriyle
`Akreditasyon Faaliyeti` aynı listede olamaz.

### SATIRIN PUANI KAYNAKTA O KODUN YANINDA GEÇİYOR MU?

OMÜ'nün baştan sona denetimi (02.09.2026) yirmi iki fazla, yedi eksik sayan
eşleme çıkardı ve hepsinin ortak sebebi tekti: **kaynak bir kalemi bizim
etiketimizin TAŞIMADIĞI bir eksende kademelendiriyor** — derginin indeksi,
yayınevinin sınıfı, fon kademesi, çeyreklik, tam metin/özet — ve satır o
kademelerin ortasından ya da en üstünden yazılmış.

Mekanik sınaması var: madde kodunu kaynak metninde bul, o kodun çevresindeki
PUAN SÜTUNU sayılarını topla, cetvelin puanı bu kümede mi diye bak. Değilse
ya §0 gereği bilerek düşürülmüştür ya da hatadır; ayrımı **yön** veriyor:

- cetvel puanı kümenin ALTINDA → §0 taban, olağan.
- cetvel puanı kümenin ÜSTÜNDE → §0 ile açıklanamaz, oku.

**Tarayıcı sayıyı sütun olarak tanımalı**, yoksa kod içindeki rakamları
("A1.1" → 1) puan sanır. İşe yarayan kural: sayı ya satır sonunda ya da en
az iki boşlukla ayrılmış bir kolonda; ardında dipnot yıldızı ya da çarpan
eki olabilir (`100*`, `50*sayı`). "20/10" gibi kademe çiftleri parçalanır.

**PRECİSİON DÜŞÜK, TEK BAŞINA KARAR VERDİRMEZ.** 03.09.2026'da korpusa
uygulandığında 164 cetvelde 22 "üstünde" adayı çıktı; elle okununca çoğu
YANLIŞ POZİTİFTİ. Üç sebep:

1. **Cetvelin kodları kaynağın kodları değil.** Ağrı'da 4.3 cetvelde kitap
   bölümü, kaynakta çeyreklik çarpanı kuralı. Kod eşleşmesi anlamsızlaşıyor.
2. **Çok sütunlu kadro tabloları.** Gebze Teknik'te değer kadro sütununda,
   kodun satırında değil.
3. **Aynı numara birden çok tabloda.** Şırnak'ta 2.1.1 hem kitap hem tez
   bölümünde var.

Yani bu tarayıcı ADAY LİSTESİ üretir, karar değil. Listedeki her satır
kaynaktan okunarak doğrulanmalı — Adıyaman'ın gerçek hatası (ulusal bildiri
20 puandaydı, kaynakta özet 15) ancak okuyunca çıktı.

### "BU PUANIN EN AZ YARISI" = ASGARİ PUANIN YARISI, ADAYIN TOPLAMININ DEĞİL

Eşik tablolarının en yaygın dipnotu şu: **"Bu puanın en az yarısı '1. Bölüm:
Bilimsel Makaleler'den karşılanmış olmalıdır."** Üst simge "En az puan"
SÜTUNUNA bağlı, dolayısıyla "bu puan" o sütundaki değerdir — yani ASGARİ
PUAN. Adayın kendi toplamı değil.

Akdeniz ilk girişte oransal düğümle (`min_oran`, payda `['*']`) yazılmıştı;
bu, barajın çok üstünde puanı olan ama makale ağırlığı düşük adaya YANLIŞ
"sağlanmadı" gösteriyordu. Dr. Öğr. Üyeliğinde asgari 100, dolayısıyla koşul
"makaleden en az 50 puan" — 1000 puanı olan adaydan 500 istemek değil.
04.09.2026'da on altı düğüm sabit `puanDan` tabanına çevrildi (50/150/250,
Güzel Sanatlarda 40/120/200).

Ayrım tek soruya iniyor: **cümlenin öznesi SABİT BİR BARAJ mı, adayın kendi
puanı mı?** Türkçede ikisi de "toplam puanın yarısı" diye yazılıyor; ayıran
şey aynı cümlede bir SAYI geçip geçmediği:

    "en az yarısı A, C, F, H'den olmak üzere bütün aktivitelerden
     toplam 125 puan almış olmak"        → 125'in yarısı, SABİT (62)
    "Adayın TOPLAM PUANININ %65'ini Tablo 2'den almış olması"
                                          → adayın kendi puanı, ORAN

**"İLAVETEN … PUAN DAHA" KORPUSTA TARANDI (05.09.2026).** 35 kaynakta 242
satır çıktı; gürültünün çoğu satır içi bonus ("ticarileştirilmesi hâlinde
ilave 10 puan") ve tablo notu. Motorda gerçekten "ilave/daha" düğümü olan
altı üniversite incelendi:

| Üniversite | Kaynak | Durum |
|---|---|---|
| Dicle | "asgari 40 puana ilaveten A1-D2'den 20 puan daha alarak puanlarını 60'a tamamlamak" | **iki yönde de yanlıştı**, düzeltildi |
| Karamanoğlu | "(a) bendindeki puana ilaveten … 100 puan daha" | önceki turda düzeltildi |
| Isparta ÜBÜ | "Madde 6/2-b'deki puana ilaveten Tablo 1'den 20 puan" | DOĞRU — taban zaten Tablo 1'in kendi 40'ı |
| Gaziantep | "1(a) ve/veya 8(a) maddelerinden toplamda en az 90 puan daha" | DOĞRU — ek puan zaten kümeye yazılı |
| Gazi | "proje yoksa makalelerden ilave 30 puan" | DOĞRU |
| Çankırı | telafi puanları | DOĞRU |

**İKİ BENDİN SAYISI BİRBİRİNE KARIŞABİLİR.** Gaziantep'te aynı blokta iki
ayrı "ilaveten" bendi var ve ilk girişte proje bendinin telafisine ÖTEKİ
bendin sayısı (90) ve kümesi ({1a,8a}) yazılmıştı:

    (d) proje  "5 nolu maddeden en az 45 puan. Sağlayamayanların (c)'deki
                puana ilaveten 1(a)'dan en az 45 puan DAHA"      → 1(a) 285
    (e).3      "(c)'deki puana ilaveten 1(a) ve/veya 8(a)'dan
                toplamda en az 90 puan daha"                     → {1a,8a} 330

İki bendi ayırt etmenin işareti KÜMEDİR: proje telafisi yalnız 1(a)'dan,
uluslararası deneyim telafisi 1(a) ve/veya 8(a)'dan. Telafi tutarı da proje
koşulunun tutarıyla aynı (fen 45, sağlık 30) — 90 hiçbirinde proje telafisi
değil.

**GAZİ'DE AYNI KALIP AMA ARİTMETİK YOK.** "Bu kriter sağlanamıyorsa, Kriter 1
için SUNULAN MAKALELER DIŞINDA olmak şartıyla … 30 puan almak" — burada taban
bir puan değil, bir YAYIN SAYISI koşulu (dört yayın) ve ek puanın ayrı
eserlerden gelmesi isteniyor. Motor "aynı eser iki koşulda sayılmasın"
diyemediği için 30 doğru sayı; eksik olan tek şey ayrıklık ve o zaten
"aynı esere özgü sınır" sınıfında.

**KAÇ DÜĞÜM GEREKTİĞİNİ TABAN BELİRLER, KALIP DEĞİL.** Isparta ÜBÜ aynı
kalıbı dört kez kullanıyor ve dördü de eksiksiz; sayı bentten bende
değişiyor:

    6/4-a   "Tablo 1'den en az 40 puan almak şartıyla … toplamda asgari 60"
    6/4-b-5 "6/4-a bendine ilaveten, Tablo 1'den en az 20 puan"
            → TEK DÜĞÜM yeter: T1 ≥ 60. Ek puan (a)'nın kısıtladığı KÜMEDEN
              geliyor, toplam da kendiliğinden 60'ın üstünde kalıyor.

    7/2-a   "Tablo 1 ve Tablo 2'den toplamda en az 100 puan"   (tablo tabanı YOK)
    7/2-b-9 "7/2-a'daki puana ilaveten Tablo 1'den en az 10 ve Tablo 2'den
             en az 10 olacak şekilde toplamda en az 20 puan"
            → ÜÇ DÜĞÜM: T1 ≥ 10, T2 ≥ 10, toplam ≥ 120.

Ayrım şu: **(a) bendinin tabanı, ek puanın geldiği kümeyle AYNI mı?** Aynıysa
tek düğüm (tabanı topla), değilse her kısıt kendi düğümünü ister. Isparta bu
kalıbın korpustaki referans uygulaması ve teste bağlı.

**Dicle iki yönde birden sapmıştı ve bu desen öğreticidir:** Dr. yeniden
atanmada tek düğüm "A1-D2'den 60 puan" diyordu (kaynak toplamı 60'a
tamamlamak, kümeden yalnız 20 istiyor → ÇOK SIKI), doçentlik ve
profesörlükte ise ek puan kümeye yazılıp toplamın yükseldiği atlanmıştı
(→ ÇOK GEVŞEK). Tek düğüm iki koşulu birden taşıyamaz.

**"İLAVETEN … PUAN DAHA" İKİ DÜĞÜM İSTER.** Aynı ailenin ikinci kalıbı:
"(a) bendinde belirtilen PUANA İLAVETEN A, B, C, F, H ve İ türü
aktivitelerden olmak üzere en az 100 puan DAHA almış olmak"
(Karamanoğlu MADDE 8/9). Ek puan hem TOPLAMI hem TÜR KÜMESİNİ yükseltiyor —
doçentlikte toplam 400 ve türlerden 250 (300 + 100 · 150 + 100). Tek düğüme
sığdırıp "tür kümesinden 400" yazmak kaynağın istemediği kadar sıkı olur ve
yalnız bu yoldan gidebilen adayı haksız yere eler.

**TARANMIŞ PDF'TE SAYIYI GÖRÜNTÜDEN DOĞRULA.** Karamanoğlu'nun kaynağı
taranmış; OCR "%" işaretini "90", "96", "©0" ve "“" diye okuyor. Fen
grubunun satırı `Enaz “650'si` çıkıyordu — "%50" mi "%65" mi belli değil ve
ikisi 75 ile 97 puan arasında fark yaratıyor. `pdftoppm -r 200` + kırpma ile
sayfa görüntüsüne bakmak dakikalar sürüyor ve kesin sonuç veriyor. Sayı
belirsizse tahmin etme, GÖRÜNTÜYE BAK.

**KORPUS TARAMASI (05.09.2026).** Motorda oransal düğüm taşıyan üç
üniversite vardı; ikisi yanlış okumaydı:

| Üniversite | Kaynak cümlesi | Karar |
|---|---|---|
| Karamanoğlu | "en az %50'si … olmak üzere toplam 125 puan" | sabite çevrildi (6 düğüm) |
| Trakya | "en az yarısı … koşuluyla toplamda en az 300 puan" | sabite çevrildi (6 düğüm) |
| Çanakkale | "**Adayın toplam puanının** %65'i" | ORAN doğru, kaldı |

Akdeniz'le birlikte 28 düğüm sabit tabana çevrildi; 156 eşiği ilgilendiriyor.
`Kalip::oran` korpusta artık YALNIZ Çanakkale'de ve test bunu koruyor.

Yan etki: sabit taban, §"Yüzde tavanını ASGARİ PUANDAN SABİTE ÇEVİR"
başlığındaki türetmeyi BOZMAZ — zincir `diğer bölümler ≥ makale ≥ oran ×
asgari` olarak kısalır, alt sınır aynı kalır.

### İKİ TARİHLİ SET VE KADEMELİ YÜRÜRLÜK: HANGİSİ BUGÜN GEÇERLİ?

Yönergeler yeni ölçütleri çoğu zaman KADEMELİ yürürlüğe koyuyor ve iki ayrı
biçimde yazıyor:

1. **İKİ TAM SET.** Aynı bölüm baştan sona iki kez yazılır, başlıkları tarih
   taşır: Gazi'de "A. ALANLARA ÖZEL KRİTERLER-(01.07.2023-31.12.2023)" ve
   "A. ALANLARA ÖZEL KRİTERLER-01.01.2024-KALICI". Yürürlükteki set alınır,
   ötekinin varlığı dosya başlığına yazılır (yoksa bir sonraki okuyan hangi
   setin alındığını bilemez).
2. **ORAN TABLOSU / GEÇİCİ MADDE.** Tek set yazılır ama barajlar bir süre
   indirimli uygulanır. Fırat'ın geçici 14. maddesi: 01.06.2026-31.12.2026
   %50, 2027 %75, 01.01.2028'den sonra %100 — "dil puanı hariç" ve "yayın
   sayıları üst tam sayıya yuvarlanır". AYBÜ'nün geçici 1. maddesi bir
   muafiyet oranını 01.09.2027'ye kadar %25, sonra %50 yapıyor.

**ORANI SABİT YAZMA, TARİHTEN TÜRET.** Sabit yazılan oran, geçiş bittiği gün
veriyi sessizce yanlışa düşürür — kimse fark etmez, hiçbir test kırılmaz.
Tarih sınırlarını bir tabloya koy ve `date('Y-m-d')` ile çöz; veri
kendiliğinden bir sonraki kademeye geçer. TESTİ DE ORANA DEĞİL TABLOYA BAĞLA
(beklenen değeri aynı tablodan hesapla), yoksa takvim testi kırar.

**Kaçırılması en kolay yer geçici maddeler.** Korpus taramasında 12 kaynakta
tarih işareti çıktı; Fırat'ın üç kademeli tablosu HİÇ girilmemişti ve bütün
Fırat eşikleri bugün olması gerekenin İKİ KATI baraj istiyordu. Kocaeli'nin
iki geçici maddesi (yeniden atanmada toplam puanın %70'i, bir makale şartının
kaldırılması) 06.09.2026'da girildi; dayanacak kayıt yoktu, çünkü o
üniversitede yeniden atanma kadrosu hiç yazılmamıştı — geçici madde taraması
EKSİK KADRO da ortaya çıkarabiliyor. Süresi DOLMUŞ bir hüküm
(Bursa Uludağ'ın 31.12.2025'te biten 35. maddesi) girilmemişse bugün
doğrudur, ama bunu da not et.

### DİPNOT NUMARASI TABLOYA YERELDİR — "DİPNOT 3" DİYE NOT ALMA

Bir belgede aynı rakam birden çok şey anlatabilir: her tablo kendi dipnot
listesini taşır ve numaralar her tabloda BAŞTAN BAŞLAR. Akdeniz'in beş
değerlendirme grubunda "En az puan" sütununa bağlı üst simge sırasıyla
**3, 5, 3-4, 3, 4**; beşi de aynı kuralı ("bu puanın en az yarısı 1.
Bölüm'den") gösteriyor ama numaraları farklı. GRUP 4'ünki ise bambaşka bir
şey diyor ("en az yarısı 11.4'ten"). Aynı belgede 11.2 tablosunun 1-4
dipnotları da kuruluş listeleri.

**Not alırken dipnotun NUMARASINI değil METNİNİ yaz.** "Dipnot 3 şunu diyor"
biçiminde bir kayıt bu dosyada doğrudan yanıltıcıdır.

04.09.2026'da korpus bu desen için tarandı: aynı rakamın farklı metinlerle
tanımlandığı tek kaynak Akdeniz (Adana ATÜ'deki ikinci işaret satır kayması).
Yani desen nadir ama bulunduğu yerde yoğun. Akdeniz'in beş grubunun oranları
`SartAgaciTest`'te teste bağlandı; yanlış dipnota bakılırsa oran da yanlış
olur ve test kırılır.

**ÜST SİMGE TARAMASI PDF ÇIKARIMINA GÜVENEMEZ.** `pdftotext` üst simgeyi düz
rakam olarak veriyor ve çoğunu büsbütün düşürüyor; "işaret bulunamadı"
demek "kaynakta işaret yok" demek değildir. Bu yüzden "tanımı var ama
işareti yok" taraması işe yaramadı (739 sahte işaret). Verimli olan yön
tersi: SAĞ KALAN işaretlerden birden çok satıra düşenleri incele — korpusta
altı tane çıktı, hepsi ya yerel numaralandırma ya OCR gürültüsüydü.

### ÜST SİMGE DİPNOTUNU SÜTUN BAŞLIĞINDA DA ARA

"DİPNOT HANGİ SÜTUNA BAĞLI? ÜST SİMGEYE BAK" kuralı hücre içindeki dipnotlar
için yazılmıştı (Ordu'nun kadro sütunları). Aynı iz EŞİK TABLOSUNUN SÜTUN
BAŞLIĞINDA da duruyor ve orada daha çok şey söylüyor: "En az puan³" başlığı,
o sütundaki bütün barajlara bir ALT KOŞUL bağlar.

Akdeniz'in eşik tabloları böyle: "Kadro | Asgari yayın sayısı | En az puan³ |
Diğer Kriterler" ve dipnot 3 "Bu puanın en az yarısı … karşılanmış olmalıdır"
diyor. Yani sütun başlığındaki tek rakam, üç kadronun toplam barajını da
ikiye bölüyor.

**AYNI NUMARA FARKLI TABLODA FARKLI ŞEY GÖSTERİR.** Akdeniz'de GRUP 3'ün
4 numaralı dipnotu "%40'ı 1. Bölüm: Bilimsel Makaleler'den", GRUP 4'ün
3 numaralı dipnotu ise "yarısı 11.4 Disipline Özgü Etkinlikler'den" diyor.
Dipnot numaraları TABLO BAŞINA yeniden başlıyor; bir tablodan okunan
dipnotu ötekine taşımak yanlış koşul üretir.

Tarama, "puan"/"zorunludur"/"alınır" gibi kelimelerin hemen ardındaki
rakamı arar; **madde atıflarını elemek şart**, yoksa "en az 30 puanı 1-11
numaralı faaliyetlerden" satırı dipnot sanılır. Ayıklama kuralı: rakamın
ardında `numaralı`, `kodlu`, `ve/veya`, tire ya da başka rakam varsa o bir
KOD ATFIDIR, dipnot değil. Bu filtre olmadan 98 iz çıkıyor, filtreyle 68 —
ve elenen otuzun tamamı yanlış pozitif.

### DİPNOT TARAMASI: TAVANDAN BAŞKA DÖRT KURAL TÜRÜ

"Tablo dipnotları da eşiğin parçası" kuralı sabit tavanlar için ayrı
tarandı; dipnotlar tavandan başka DÖRT kural türü daha taşıyor. Satır
başında işaret (`*`, `**`, `(1)`, üst simge) + kural fiili aranarak taranır:

| tür | desen | ne yapar |
|---|---|---|
| KAPSAM | "yalnızca", "sadece", "… için geçerlidir" | bölümü bir kadroya/alana/birime bağlar |
| ÇARPAN | "yıl ile çarpılarak", "AKTS'si ile", "× ay" | puanı süre ya da adetle çarpar |
| İLAVE | "%N ek puan", "ilave puan verilir" | puanı artırır |
| KESİR | "puanın yarısı", "%N'i alınır" | puanı azaltır |
| ADET | "en fazla N adet/kez/bölüm puanlanır" | sayıyı sınırlar (puana çevrilebilir) |

**EN TEHLİKELİSİ KAPSAM.** Ötekiler puanı kaydırır, kapsam kuralı ise
bölümü HİÇ HAK ETMEYEN adaya açar. SBÜ'nün D başlığı hem tavan hem kadro
kısıtı taşıyordu; tavan alınmış, kısıt atlanmıştı ve Dr. adayı 50 puana
kadar fazla topluyordu. Bilecik'in M bölümü ("Mimarlık ile Güzel Sanatlar
için geçerlidir") aynı sınıf ama doğru ele alınmış: cetvel alan başına
varyantlanıp öteki on alanda M satırları hiç açılmamış.

**BAŞLIK İKİ KURAL TAŞIYABİLİR, İKİSİNİ DE OKU.** Bu turun tekrar eden
dersi: bir tavan görünce yanındaki parantez kolayca atlanıyor.

04.09.2026 taraması: 164 kaynakta 123 dipnot izi; kadro/alan/birim kısıtı
gibi duran 22 tanesi elle okundu. Bilecik ve OMÜ zaten doğruydu; TAÜ'nün
İİBF'ye özgü dar indeks tanımı ile Akdeniz'in üç çarpanı uygulanamaz çıktı
ve gerekçeleriyle dosyalarına yazıldı. **Uygulanamaz olanı da yaz:** not
yoksa sonraki tur aynı dipnotu yeniden bulur ve yeniden araştırır.

### SENATO İZLERİ AYRI KALIPLARLA ARANIR

YÖK izleri taraması senato değişikliklerini tam yakalamıyor; senatolar başka
künye kullanıyor:

```bash
grep -nE "\(.{0,60}(Senato ?Karar|ÜS-|Senatosunun|Senatonun).{0,110}\)" kaynak.txt
```

03.09.2026'da korpusa uygulandı: 14 cetvelde 72 iz çıktı, **hiçbiri hata
değildi.** Uşak (21 iz, 04.03.2026'da bir profesörlük bendi kaldırılmış),
İsparta UBÜ (19 iz), Siirt (puan tablosunun tamamı 26.02.2025'te değişmiş),
Muşku, Bayburt, ESOGÜ ve ötekiler tek tek okundu; hepsinde cetvel yürürlükteki
metni yansıtıyordu.

Sebebi yapısal ve rahatlatıcı: **senato değişiklikleri kaynağın İÇİNE işlenmiş
hâlde geliyor.** PDF yürürlükteki metni gösteriyor, iz yalnızca "burası
değişti" diyor. YÖK kararlarında bu her zaman doğru değildi — Fırat'ın C6'sı
gibi çıkarılan satırların PUANI metinde kalabiliyor.

**İki iz türünü de yine de tara:** bir "(Değişik: … Senato Kararı)" künyesi
o maddenin dikkatle okunması gereken yer olduğunu söylüyor. Bayburt'un
yabancı dil koşulu eksiği tam da böyle bir künyenin yanındaki maddeden çıktı.

### YÖK KARAR İZLERİNİ TARA: SATIR EKLENİR, ÇIKARILIR, KISITLANIR

Kaynak metinler yürürlükteki hâli gösterir ama değişikliğin izini de taşır:
`(Değişik: … tarihli karar)`, `(Mülga: …)`, `(Ek: …)`, "tablodan
çıkarılmıştır", "… eklenmiştir". Bu izler üç ayrı riski işaret ediyor ve
üçü de SESSİZ — kaynağın metni değişir, cetvel eski hâlde kalır, test kırılmaz:

1. **Satır EKLENMİŞ** → cetvelde karşılığı yok, aday hak ettiği puanı
   alamıyor. (YÖK'ün 30.01.2025 kararı jürili yarışma satırlarını ekledi;
   Giresun'da M.18-M.19, Kocaeli'de H29, Çukurova'da iki satır eksikti.)
2. **Satır ÇIKARILMIŞ** → cetvelde duruyorsa fazla saydırır. Tuzak şu:
   çıkarılan satırın PUANI ÇOĞU ZAMAN METİNDE KALIYOR. Fırat'ın C6'sı
   "uygun bulunmayarak tablodan çıkarılmıştır" diyor ama yanında hâlâ 100
   yazıyor; sayıyı görüp satır açmak 100 puanlık bir hata üretir.
3. **Satıra KISIT GETİRİLMİŞ** → en sinsi hâli, çünkü başlık İKİ KURAL
   birden taşır ve biri alınıp öteki atlanır. SBÜ'nün D başlığı hem "en
   fazla 50 puan" hem "(Yalnızca Profesör ve Doçent kadroları için)"
   diyordu; tavan girilmiş, kadro kısıtı atlanmıştı ve Dr. adayı 50 puana
   kadar fazla topluyordu.

Tarama komutu:

```bash
grep -nE "\(Değişik|\(Mülga|\(Ek ?:|tablodan çıkarılmıştır|eklenmiştir" kaynak.txt
```

**Gürültünün büyük kısmı tek kalıptan geliyor:** "Bu Yönergenin yürürlüğe
girmesiyle … yürürlükten kaldırılmıştır" her yönergenin son maddesi. 138
izin 100'ü buydu; madde düzeyinde iz taşıyan yalnız 13 cetvel kaldı ve
hepsi bir oturumda okunabildi.

**İzin yanında duran maddeyi de oku, sadece izi değil.** Bayburt'un en
büyük eksiği izin kendisinden değil, izin BULUNDUĞU maddeden çıktı:
14/02/2024 Senato Kararı MADDE 7'ye bir istisna eklemişti (bizde karşılığı
yoktu, çünkü o kadro girilmemiş) ama maddeyi okuyunca ASIL KOŞULUN —
bütün başvurularda 55 yabancı dil puanı — hiç girilmediği görüldü.

### KODUN KAYNAKLA BAĞI: ÜÇ SINIF, ÜÇÜNÜ DE DOSYA BAŞLIĞINA YAZ

"Yönergenin kendi kodlarını birebir koru" kuralı korpusun her yerinde
uygulanabilir değil, çünkü kaynakların bir kısmında SATIR KODU YOK.
03.09.2026'da 162 cetvel kaynağıyla karşılaştırıldı; üç sınıf çıktı:

1. **Kod birebir kaynağın** — en iyi durum, kod bir ÇAPA: bir satırı
   kaynakla eşlemek için kodu aramak yeterli.
2. **Kodun SAYISAL ÇEKİRDEĞİ kaynağın, gerisi bizim** — en yaygın durum.
   Baştaki harf tabloyu ya da eki (`T1-`, `EK1.`, `A`), sondaki harf şıkkı
   gösteriyor. Çekirdek hâlâ çapa; karşılaştırırken ona bak.
3. **Kod tamamen bizim, kaynakta karşılığı YOK** — puan tablosu satırları
   numarasız, düz metin açıklamalar hâlinde. Çukurova ve Abdullah Gül böyle.
   **Burada kod bir çapa DEĞİL**; bir satırı kaynakla eşlemenin tek yolu
   BAŞLIK METNİDİR.

Üçüncü sınıf denetim için en riskli olan: OMÜ'de bulunan türden bir
mis-mapping (satır kaynağın komşu bendinin değerini almış) kodu okuyarak
yakalanamaz. O dosyalarda satır satır BAŞLIK karşılaştırması gerekir.

**Her cetvel dosyası hangi sınıfta olduğunu söylemeli.** 03.09.2026'da yirmi
dosyada bu not eksikti ve eklendi. Yeni cetvel girerken kodların nereden
geldiğini yazmak, sonraki denetim turunun neye güvenebileceğini söyler.

**ÖLÇÜM GÜRÜLTÜLÜ, SIRALAMA ÜRETMEYE ÇALIŞMA.** "Kaç kod eşleşti" oranı hem
yanlış pozitif hem yanlış negatif veriyor: kodun harfli önekini koruyan
dosyalar sayısal çekirdek testinde düşük, çekirdeği koruyanlar birebir
testinde düşük çıkıyor; taranmış kaynaklarda OCR kodu bozuyor. Oran bir
SINIFLANDIRMA aracıdır (çapa var mı yok mu), bir kalite sıralaması değil.

### KORPUS GENELİ DENETİM BİR KAMPANYA, TEK TUR DEĞİL

OMÜ'nün on altı bölümünün tamamı kaynakla karşılaştırıldı ve yirmi dokuz
eşleme düzeldi. Bu, ÜNİVERSİTE BAŞINA saatler süren bir iş: kaynağın her
bölümünü okumak, her etiketin temsil edebileceği bentleri çıkarmak, en
düşüğünü seçmek.

175 üniversiteye aynı derinlikte uygulamak tek oturumluk bir iş değil.
Pratik yol, ucuz ve kesin detektörleri korpusa uygulayıp derin denetimi
işaret verenlere saklamak:

| Detektör | Kesinlik | Bulduğu |
|---|---|---|
| Grup tavanı (sabit "en fazla N puan") | yüksek | 14 üniversite, 55 tavan |
| Yüzde tavanı (asgari puana bağlı) | yüksek | 3 üniversite |
| Ölü / kapsamı dar tavan (test) | kesin | Ege |
| Satır başlığı olumsuzlaması | yüksek | Yalova |
| Etiket kaynakta hiç geçmiyor mu | yüksek | 59 cetvel (akreditasyon) |
| Satırın puanı kaynakta yok | DÜŞÜK | aday listesi |
| Fazla/eksik sayan satır (korpus medyanı) | orta | 22 üniversite |

Derin denetime önce ŞUNLAR alınmalı: kaynağı kademeli olduğu hâlde cetveli
tek satıra inmiş bölümler, kodları kaynağınkiyle uyuşmayan dosyalar ve
`grup_tavanlari` boş olup kaynağında sınır ifadesi geçen cetveller.

### SATIR BAŞLIĞI BİR ŞEYİ DIŞLIYORSA ETİKET ONU TAŞIMASIN

En ucuz ve en kesin detektör bu: satırın KENDİ METNİ bir şeyi açıkça dışlıyor
ama etiketi onu içeriyor. İstatistik gerekmiyor, iki `preg_match` yetiyor.

Yalova'nın 8a ve 8b satırları "Uluslararası/Ulusal bilimsel toplantıda sunulan
bildiri (POSTER HARİÇ)" diyor ve `Uluslararası Özet/Poster` etiketini
taşıyordu. Kaynak altı tablosunda da aynı parantezi kullanıyor, ayrı poster
satırı yok.

Karar kalıbı: sözlük etiketi **kaynağın saydığı** ile **saymadığı** şeyi tek
etikette birleştiriyorsa (özet + poster) ve ayrılamıyorsa, §0 DIŞLAYAN kolu
seçer. Aday o kalemde puanını ve SAYISINI düşük görür; alternatifi hak
edilmeyen sayıyı vermek olurdu. Yönü ve büyüklüğünü `kapsam_notu`'na yaz.

Korpus taraması sekiz aday satır buldu, altısı yanlış pozitifti: "yayın teşvik
ödülü hariç" diyen satırlarda `TÜBA GEBİP / TWAS Teşvik Ödülü` etiketi duruyor
— GEBİP bir ARAŞTIRMA teşvik ödülü, dışlanan ise yayın başına verilen nakit
teşvik. **Olumsuzlamanın neyi dışladığını oku, kelimeye bakma.**

### ÖLÜ SATIR TARAMASI: ÜÇ ÖLÜM BİÇİMİ, İKİSİ TESTE BAĞLI

`maddeyeUyar()` `isset` ile bakıyor. Anahtarın HİÇ OLMAMASI "bu alanı
filtreleme", BOŞ DİZİ ise "hiçbir değere uyma" demek. `'kaynaklar' => []`
yazan satır bu yüzden **sessizce ölü** — ne test kırılır ne uyarı çıkar.
Tarayıcı yazarken ikisini karıştırma; ilk turda karıştırılınca Akdeniz'in
`tez_yayini` satırı yanlışlıkla "ölü" sanılmıştı.

Ölü satır çoğu zaman KASITLI ve §0'ın gereğidir: kaynak bir kademeyi
sözlüğün taşıyamadığı bir eksende ayırıyorsa etiket ALT kademede bırakılır,
üst satır puanıyla durur ama etiketsiz kalır. Kasıtsız olduğunda ise adayın
hak ettiği puanı sessizce yutar — bu yüzden liste teste bağlandı.

04.09.2026'da korpus üç ölüm biçimi için tarandı:

| Sınıf | Ne | Sonuç |
|---|---|---|
| A | boş `kaynaklar`/`roller`/`turler` | 53 satır, 6 farklı — hepsi kasıtlı |
| B | tavanı 0 olan grubun içindekiler | 15 (cetvel, grup) çifti — hepsi kasıtlı |
| C | hiçbir eşiğin şart ağacında geçmeyen | 33 cetvelde 756 satır — hepsi tasarım |

**C sınıfı da teste bağlandı, ama İKİ AYRI LİSTEYLE** — çünkü iki ayrı sebep
var. BARAJSIZ CETVEL: eşiklerinde hiç `puan` düğümü yok, barajlar `adet` ve
`metrik` üzerinden kurulu (MEF, Manisa CBÜ, Bartın, Kadir Has, Sakarya UBÜ,
Van YYÜ, Yeditepe, Adıyaman'ın doçentliği, İKÇÜ'nün doçentliği); o cetvelin
bütün satırları tanımı gereği dışarıda, sayı vermek anlamsız — yalnız ADLARI
listelenir. BARAJ VAR AMA SATIR DIŞARIDA: `cetvel: dışarıda/toplam` sayısı
yazılır ve baraj kaynağın KENDİ bölüm kümesine bağlıdır — OMÜ'de A grubu
`1-14`, B grubu `1-15`, yalnız güzel sanatlar `1-16`; İTÜ'de her şey
`ESER-PUANI`; Giresun'da `A-L`; İKÇÜ'de "1., 2., 3., 4. ve 7. maddeler";
Yalova'da `1-2-3-4-5-8`; Rumeli'de 1.5 ve 1.7 hariç.

Sayıyı kırdıran iki değişiklik türü var, ikisi de gözden geçirilmeli: bir
grup deseni daraltılmış (satırlar sessizce barajın dışına düşer) ya da yeni
bir bölüm girilip hiçbir gruba eklenmemiş. İkincisi bu kampanyanın en olası
hatası — bölüm girilir, `gruplar` güncellenmez, satır kimseye görünmeden
kapsam dışı kalır.

**Satır listesi yerine SAYI yaz.** Önek sıkıştırması denendi ve işe yaramadı:
bölümlü kod uzaylarında (OMÜ `15.`, `16.`) güzel çalışıyor ama düz kod
uzaylarında (Manisa CBÜ, Yalova, MEF) 363 satıra çıkıyor. Sayı hem kısa hem
de her değişikliği yakalıyor; kırıldığında tarayıcıyı tekrar çalıştırıp hangi
satırın çıktığına bakılır.

`CetvelKaynakTest` üç listeyi de tutuyor; üçü de enjeksiyonla doğrulandı.

### İKİ SATIR AYNI ETİKETE DÜŞÜYORSA YÜKSEK OLANI YAZMA — SİL

Motor `puan()` içinde eşleşen kodların EN YÜKSEĞİNİ alıyor. Yani §0'ın "düşük
olanı gir" kuralı, yüksek satırı da yazıp düşüğüne güvenmekle sağlanmaz:
yüksek satır varsa o kazanır. Düşük değeri geçerli kılmanın tek yolu YÜKSEK
SATIRI HİÇ YAZMAMAK ya da etiketi ondan çıkarmaktır.

**BU KURALI KORPUSA UYGULAYAN TARAMA (04.09.2026).** Her cetvelde aynı
(kategori, kaynak, rol, tür) imzasını paylaşan ama puanı farklı satırları
ara. Ucuz, tam ve kaynak metni okumadan çalışıyor; ilk turda 51 imza çıktı,
altısı gerçek hataydı:

| Cetvel | Çakışma | Etiketin taşıyamadığı ayrım |
|---|---|---|
| yalova-2024 | 1c 8 ↔ 1ç 5 | dipnottaki KAPALI ÜAK alan indeksi listesi |
| sakarya-2026 | 2.3 ailesi 120/30 ↔ 2.4 80/20 | TÜBİTAK PROGRAM KODU |
| kafkas-2025 | YU-c 15 ↔ PT-c 10 | satır bütün sınai hak etiketlerini kopyalamış |
| istanbul-2026 | T4.1.a 100 ↔ 9.i 10 | "meslek başarı ödülü" ≠ bilim/sanat ödülü |
| pau-2023 | A.16a 10 ↔ D.6b 5 | torba `Diğer` etiketi iki satırda |
| akdeniz-2026 | 11.3.13 50 ↔ 11.4.8 40 | iki FAKÜLTE tablosu tek varyantta |

Üç yanlış pozitif sınıfı:

- **ÜÇ TABLO, ÜÇ ADAY GRUBU.** Isparta ÜBÜ'nün yirmi bir çakışmasının hepsi
  böyle: barajlar `T1`/`T2`/`T3` gruplarına bağlı, cetvelin tamamına değil.
  Motor her grubun İÇİNDEKİ en iyi kodu seçtiği için doğru çalışıyor.
- **YÜKSEK SATIR DAHA GENEL OLAN.** Trakya ek6'da "alanıyla ilgili
  etkinliklerde jüri üyeliği" (10) sanat yarışması jüriliğini (5) zaten
  kapsıyor. Yüksekte etiketin taşıyamadığı bir kısıt yoksa fazla sayma yok.
- **İKİSİ DE MEŞRU, KAYNAK ZATEN "EN YÜKSEĞİ AL" DİYOR.** Kafkas'ta patent
  sahibi YU-c'yi de sağlıyor; Akdeniz'in 9. bölüm dipnotu bunu açıkça yazıyor.

Ayrımı yapan soru hep aynı: **yüksek satır, etiketin TAŞIYAMADIĞI bir kısıt
mı taşıyor?** Taşıyorsa etiketi ondan çıkar (satır ölür, kod grupta kalır);
taşımıyorsa çakışma doğrudur. `CetvelKaynakTest` elden geçirilmiş listeyi
tutuyor, yenisi eklenince test kırılıyor.

### KADEME Mİ UYGUNLUK MU? "EN DÜŞÜĞÜNÜ YAZ" YALNIZ KADEMEDE İŞLER

§0'ın kısayolu şudur: etiket kaynağın kademesini taşımıyorsa en düşük
kademeyi yaz. Kısayol **satırlar arasındaki fark bir DERECE farkıysa**
geçerli — uluslararası/ulusal, Q1/Q4, yürütücü/araştırmacı. Fark KİMİN HAK
ETTİĞİ ise işlemez, çünkü en düşük değer de hak etmeyene veriliyor.

Akdeniz 8.1 böyle: "kadrosunun olduğu birimin AKREDİTE OLMUŞ programlarında
eğitim-öğretim faaliyetinde bulunmak", 5 puan × AKTS, bölüm tavanı 100. Kayıt
programın akredite olup olmadığını taşımıyor. Ders etiketlerine bağlansaydı
ders veren HER aday puan alırdı; 5'i 1'e indirmek de bunu düzeltmezdi.
**Uygunluk koşulu taşınamıyorsa satır YAZILMAZ** ve sebebi cetvele yazılır.

Ayrımı yapmak için sor: satırın koşulu **faaliyetin bir NİTELİĞİ mi**
(nerede yayımlandı, hangi rolle) yoksa **adayın/biriminin bir DURUMU mu**
(programı akredite mi, öğrencisi yabancı uyruklu mu)? İkincisi kayıtta yoksa
satır girilmez. Usul koşulları (ders bilgi paketi tamamlanmışlığı gibi,
Akdeniz dipnot 3) bu sınıfa girmez — başvuru öncesi herkesin tamamlaması
beklenen adımlardır, kimin hak ettiğini ayırmazlar.

**SATIR DÜZEYİNDE DE TARA — AMA KISIT DESENİYLE FİLTRELE.** Başlık taraması
bitince aynı desen tablo SATIRLARINA uygulandı: kod benzeri sıralayıcıyla
başlayan satırlarda parantez ara, sonra parantezin İÇİNİ birim/alan/kadro
kısıt desenine sok (fakülte, konservatuvar, "… için geçerlidir", "yalnızca",
"sadece", "… temel alanı için", kadro adları). Filtresiz tarama binlerce
satır verir ve okunamaz; filtre 56'ya indirdi ve içinden tek gerçek bulgu
çıktı: Ankara Hacı Bayram Veli'nin "15. Yarışma, Proje ve Yazılım (Mimarlık,
Planlama ve Tasarım Temel Alanı İçin)" bölümü iki cetvel varyantında da
duruyordu.

Gürültünün büyük kısmı üç desenden geliyor (56 işaretin 26'sı) ve önceden
elenebilir. Üçü de `tests/Feature/KaynakTaramaTest.php` içinde kod olarak
duruyor; kanıtları korpustan alınmış gerçek satırlar ve üçü de enjeksiyonla
doğrulanmış — **filtreyi yeniden yazma, oradan al**:

- **BİRİM TÜRÜ LİSTESİ** — "Müdür (Enstitü/Yüksekokul/Konservatuvar/MYO)".
  Parantez görevin KAPSAMINI sayıyor. Tanıma kuralı: eğik çizgi var, birim
  adı var, kısıt fiili (için/yalnızca/sadece/hariç) YOK. Tek başına Kafkas'ta
  yirmi işaret üretiyordu.
- **TANIM CÜMLESİ** — "Doktor Öğretim Üyesi (Dr. Öğr. Üyesi): …". Parantez
  kısaltma; tanıma kuralı parantezden hemen sonra gelen iki nokta.
- **AYNI ESERE ÖZGÜ SINIR** — "(Aynı kongrede yapılan görevlerden sadece
  biri)", "(Sadece 1 bölüm dikkate alınır)". Sayı sınırı, uygunluk kısıtı
  değil; motorun zaten tutamadığı sınıf.

**DİPNOTLARA DA UYGULA — AYIRT EDİCİ İŞARET NUMARANIN NOKTASIZ OLMASI.**
Tablo satırı "1." ile başlar, dipnot "1 " ile; yıldız ve hançer de dipnot
sayılır. Aynı filtreyle dipnotlar tarandığında beş işaret çıktı ve YENİ HATA
ÇIKMADI: dördü zaten doğru girilmişti (İzmir Kavram'ın "sadece güzel
sanatlar temel alanı için" bölümü yalnız `-gsf` varyantında, Sinop'un dil
muafiyeti `veya` düğümünde, Nişantaşı'nın "40 puanı doçentlik sonrası"
koşulu ayrı düğümde).

Beşincisi DÖRDÜNCÜ BİR GÜRÜLTÜ SINIFI verdi: **BELGE ADI** — "Belgelemek
kaydıyla (Doçentlik unvanı başvuru beyannamesi) …". Parantez bir evrakı
adlandırıyor ama içinde kadro sözcüğü geçtiği için kısıt desenine takılıyor.
Tanıma kuralı: beyanname/belgesi/form/dilekçe/rapor/sertifika/karar geçiyor
ve kısıt fiili yok. O da teste bağlı.

**TÜRKÇE METİNDE `preg_match`'in `/i` BAYRAĞINA GÜVENME.** `İ` harfinin
Unicode küçüğü noktalı `i̇` (iki kod noktası) ve desendeki `i` ile
eşleşmiyor; Hacı Bayram Veli'nin "Temel Alanı İçin" ibaresi bu yüzden ilk
denemede filtreden geçmedi. Önce `İ→i`, `I→ı` çevir, sonra `mb_strtolower`.

Doğru çıkanlar da taramanın işe yaradığının kanıtı: İKÇÜ'nün "sadece İletişim
Bilimleri Alanı için" bölümü zaten yalnız `sosyal` varyantındaydı, "Yalnızca
Doktor Öğretim Üyesi Atamalarında Geçerlidir" bölümünün tavanı doçentlik ve
profesörlükte zaten sıfırdı, Gazi'nin ve SBÜ'nün alan kısıtlı satırları hiç
girilmemişti, Afyon'un "güzel sanatlar temel alanı için" koşulu zaten o
alanın eşiğindeydi.

**PARANTEZ TARAMASI KORPUSA UYGULANDI (04.09.2026).** 179 kaynak metinde
bölüm başlığı deseni (sıralayıcı + BÜYÜK HARFLİ öbek + parantez) arandı: 67
kaynakta 274 başlık. Dört aileye ayrılıyor ve yalnız biri iş çıkardı.

| Aile | Sayı | Sonuç |
|---|---|---|
| Birim/alan kısıtı | 10 | **üç gerçek bulgu** (aşağıda), üçü yanlış pozitif |
| Bölüm tavanı | 41 | hepsi cetvelde vardı — tavan turu bu aileyi kapamış |
| Kadro kısıtı | 0 | başlıkta hiç yok (SBÜ'nünki dipnottaydı) |
| Diğer | 223 | indeks listesi, "… hariç", proje kodu; kısıt değil |

Üç bulgu: OMÜ 15. bölüm (İletişim Fakültesi), İstanbul Sabahattin Zaim V.
bölüm (Güzel Sanatlar Temel Alanında), Muş Alparslan E bölümü (Devlet
Konservatuvarı). Yanlış pozitifler: Fırat ile Kocaeli'nin konservatuvar/güzel
sanatlar bölümleri zaten girilmemiş, MEF'in 13-14. bölümleri zaten
varyantlanmış.

**Muş Alparslan bir sınır durum gösterdi: KISITIN SAHİBİ HİÇ YOKSA SATIR
BÜSBÜTÜN SİLİNİR.** O yönergenin Madde 5'i güzel sanatlar temel alanını hiç
anmıyor, yani konservatuvar adayına eşik de yazılamamış. Bölüm hak edene
ulaşmıyor, yalnız hak etmeyen on temel alana puan veriyordu; varyant açmanın
anlamı yok, etiketler boşaltıldı.

**BAŞLIK PARANTEZİ TAVAN DEĞİL DE ÇARPAN OLABİLİR.** Kocaeli'nin C bölümü
"(Yabancı dildeki kitapların puanları 1.5 ile çarpıldıktan sonra…)" diyor;
kayıt kitabın dilini tutmuyor, motorun çarpan alanı da yok. Uygulanamaz, ama
`kapsam_notu` ya da dosya başlığına yazılır.

**BÖLÜM BAŞLIĞINDAKİ PARANTEZ DE BİR UYGUNLUK KOŞULUDUR.** OMÜ'nün 15.
bölümü "GÖRSEL ETKİNLİKLER (İletişim Fakültesi için geçerlidir)" diye
başlıyor; parantez tabloların içinde değil BAŞLIĞINDA duruyor ve kolayca
atlanıyor. Aynı yönergenin B grubu barajı "1-15 kategorilerinden" dediği için
hukuk, ilahiyat ve spor adayları da o puanı topluyordu. Bölüm başlıklarını
tararken parantezleri ayrıca oku; "… için geçerlidir", "… fakültesi",
"… bölümü", "yalnızca …" kalıpları bir BİRİM kısıtı işaret eder.

Çözüm §"Alan başına ayrı tablo" başlığındaki varyantlama: bölümü, o fakülteyi
içeren temel alanın varyantına koy, ötekilerde satırlarını hiç yazma. Grup
DESENİNİ de düşürmeyi unutma — satırı olmayan `15.*` deseni ölü desendir ve
`CetvelKaynakTest` onu yakalar. Grubun ADI korunur (koşul metni onu anıyor),
yalnız içeriği daralır.

**Aynı tuzağın tersi: DAR koşullu yeni satır GENİŞ eski satırı bastırır.**
Akdeniz 9.9/9.10 "YABANCI UYRUKLU öğrenci" tez danışmanlığına 25/15 veriyor;
cetvelde 5.1/5.3 zaten 15/7 puanla duruyor. Yeni satırlar yazılsaydı etiket
uyruğu taşımadığı için `puan()` en yükseği alır ve HER tez danışmanlığı
yükselirdi. Yeni satır eklerken hep sor: bu satır, koşulunu taşıyamadığı
hâlde eskisini bastırıyor mu?

### İKİ YOLLU DİPNOTTA KOLLARIN DÜŞÜĞÜNÜ YAZ

Dipnotlar sık sık "şu şartı sağlayamayan aday şunu yapar" biçiminde bir
telafi kolu taşıyor. İki kol farklı sayı istiyorsa (Ordu'da Sosyal
tablosunda birinci kol üç, telafi kolu bir tek yazarlı yayın) motorda tek
sayı yazılabiliyorsa **DÜŞÜK olanı** yaz: yüksek olanı yazmak telafi
yolundan gidebilecek adayı haksız yere eler. §0 puanı aşağı çeker, ama
adaya sağlayabileceği bir yolu da kapatmaz.

**AMA YALNIZCA KOLLAR SADECE SAYIYLA AYRILIYORSA.** Telafi kolu FAZLADAN
BİR KOŞUL taşıyorsa düşüğü yazmak o koşulu tamamen düşürür ve adaya sahte
bir "sağlandı" gösterir. Hatay MKÜ'nün dil şartı böyle: "en az 65 puan VEYA
en az 60 puan alıp AYRICA Ar-Ge projesi yürütücülüğü ya da Q1/Q2 yayın".
Burada 60 yazmak, dil puanı 60 olan ama projesi olmayan adayı sağlamış
gösterirdi; o yüzden 65 yazıldı ve alternatif `aday_notu`'nda anlatıldı.

Ayrım tek soruya iniyor: **düşük kol, yüksek kolun İSTEDİĞİNDEN BAŞKA bir
şey de istiyor mu?** İstemiyorsa (Ordu'da üç yayın ↔ bir yayın) düşüğü yaz;
istiyorsa yükseği yaz ve telafi yolunu aday notunda söyle.

### Sözlüğe YENİ ETİKET eklerken eski cetvelleri düşün

Kaynak sözlüğü genişletilebilir, ama yeni ve DAHA ÖZEL bir etiket eklemek eski
cetvelleri geriye dönük eksiltir: onların satırları genel etikete yazılmıştır
ve yeni etiketi tanımaz. Aday kaydını daha doğru etiketlediği için SIFIR alır.

Dokuz Eylül için eklenen on dokuz sanat etiketi tam bunu yaptı: "TV Programı
(Ulusal)" 237 güzel sanatlar cetvelinin yalnız %10'unda puan alıyordu, oysa
genel karşılığı "Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)" %61'inde alıyor.

Çözüm cetvelleri tek tek düzenlemek değil, motorda EŞDEĞER TABLOSU:
`MaddeKatalogu::SANAT_KARSILIKLARI` dar etiketi genel atasına bağlıyor ve
doğrudan eşleşme bulunamadığında devreye giriyor. Yeni etiket eklerken
atasını da bu tabloya yaz. Tablo kategori başına ayrı:
`EGITIM_KARSILIKLARI` 04.09.2026'da `Akreditasyon Kurulu Görevi` için açıldı.

**ETİKET EKLEMEDEN ÖNCE AİLEYİ SAY.** "Bu kaleme etiket yok" diye atlanan bir
satır tek başına etiket açmayı hak etmeyebilir; korpusta kaç kaynağın aynı
kalemi puanladığını say. 06.09.2026'da Kocaeli'nin K.10-K.12'si için bakıldı
ve tek bir kalem değil İKİ AYRI AİLE çıktı: bilimsel/mesleki kuruluş kurulları
22 kaynakta, spor federasyonu kurulları 26 kaynakta. Puanları da bambaşka —
Bitlis Eren bilimsel kuruluş üyeliğine 8, Bartın olimpik spor federasyonu
yöneticiliğine 100 veriyor; tek etikete toplansalardı §0 ikisini birden
en düşük kademeye indirirdi. Dört etiket eklendi (her aile için
uluslararası/ulusal).

**ATASI OLMAYAN ETİKETE EŞDEĞER YAZMA.** `Dış Kuruluş Kurul Üyeliği`
eşdeğer tablosuna GİRMEDİ: kurum dışı bir kurul üyeliği, üniversite komisyonu
üyeliğinin alt türü değil — tam tersine, ikisini ayırmak için açıldı. Eşdeğer
ancak yeni etiket eskisinin gerçek bir ALT TÜRÜYSE yazılır
(`Akreditasyon Kurulu Görevi` → `Akreditasyon Faaliyeti` öyleydi).

**ETİKETİ AÇTIKTAN SONRA KORPUSA YAY.** Sözlüğe etiket eklemek tek başına
işe yaramaz: aday kaydını girer ve sıfır alır. 06.09.2026'da dört etiket 26
cetvele yazıldı (satır bazında 10-23 karşılık). Yayarken iki şeye dikkat:

- **Yanlış pozitifleri ele.** Tarama "meslek odaları, yerel yönetimler,
  bakanlıklar tarafından DÜZENLENEN yarışma" satırlarını da getiriyor; onlar
  `Yarışma Derecesi / Mansiyon`, kurul üyeliği değil. İTÜ, Sivas, AYBÜ ve
  Siirt'te tam bu desen çıktı ve girilmedi.
- **Ekleme yeri, satır biçimi ve girintisi dosyanın kendisinden alınsın.**
  Çapa olarak o cetvelin SON madde satırını bul, girintiyi ondan kopyala;
  varyantlı dosyalarda `maddeler` dizisi genelde bir kez tanımlı olduğu için
  tek ekleme yetiyor (Trakya gibi ek-başına ayrı dizi tutanlarda doğru
  ekin dizisine yaz).

`CetvelKaynakTest` iki şeyi koruyor: etiketler korpusta karşılıksız kalmasın
ve kurum DIŞI etiketiyle üniversite İÇİ `Kurul / Komisyon Üyeliği` aynı
satırda buluşmasın (buluşurlarsa ayrım çökmüş demektir).

**ETİKET AÇMAK ESKİ "GİRİLEMEDİ" NOTLARINI AÇAR.** Yeni etiket eklendiğinde
onun yokluğu yüzünden atlanmış satırları da ara: Akdeniz'in 11.5'i (sağlık
kuruluşları yönetim kurulu 35/20) ve 11.1.7'si (uluslararası spor federasyonu
kurul üyeliği 40) bu turda girilebilir oldu; 11.5 için yeni bir `saglik`
cetvel varyantı açıldı.

**Etiketi ne zaman BÖLMEK gerekir:** aynı etiket altında toplanan kalemler
arasında derece farkından fazlası varsa ve §0 kısayolu ağır kalemi yok
ediyorsa. Akdeniz 8.2 (YÖKAK akreditasyon KURULUNDA görev, 30 × yıl) ile
8.5/8.6 (eğitici eğitimi ve ölçme değerlendirme BELGESİ, 10 ve 5) tek
`Akreditasyon Faaliyeti` etiketindeydi; en düşüğü yazmak 8.2'yi tamamen
düşürürdü. Bölmenin maliyeti bir etiket ve bir eşdeğer satırı, kazancı
korpusun tamamında bozulma OLMAMASI.

**Eşdeğer tablosu `topla()` yolunda aranıyor, `puan()` yolunda değil.**
Testi buna göre yaz: dar etiketin eski cetvelde puan aldığını `topla()` ile
doğrula, `puan()` sıfır döndürür.

**Her dar etiketin atası YOKTUR.** Sergi küratörlüğü ve festival
koordinatörlüğü tabloya alınmadı: sergi DÜZENLEMEK, karma sergiye eserle
KATILMAKTAN başka bir iş; genel etikete bağlamak hak edilmeyen puan verirdi.
Ata ancak yeni etiket eskisinin gerçekten bir ALT TÜRÜYSE yazılır.

### YAYMA BİTTİ SANMA: ETİKETİ TEK TEK TERİMLERLE YENİDEN TARA

Bir aileyi korpusa yaydıktan sonra **ailenin her terimi için taramayı ayrı
ayrı tekrarla.** Toplantı organizasyonu ailesi "oturum başkanlığı" terimiyle
kurulmuştu ve 85 kaynak bulmuştu; ardından "düzenleme kurulu" terimiyle
tarayınca **100 kaynak** çıktı ve 45'i açıktaydı. İkinci dalga 18 cetvele 45
satır daha ekledi — üyelik etiketinin kapsamı 52 üniversiteden 71'e çıktı.

İkinci dalganın kaçırılma sebebi tek bir kural: birinci tarayıcı satırın
**puan sütununu bulamadığı** satırları atlıyordu. Sütun bulunamayan üç kalıp:

- tablo satırı iki-üç fiziksel satıra sarılmış, puan ortadaki satırda
  (Bayburt, Karabük, İstanbul Zaim),
- puan çift değerli ("10/5", "3/2") ve regex tek sayı bekliyor (Trakya),
- puan ayrı bir kolonda, satır metniyle arasında sayfa genişliği kadar
  boşluk var (Uşak, Sakarya).

**Sütunu bulamamak sessiz bir eleme.** Tarayıcı hata vermiyor, satır
listeden düşüyor ve kaynak "aile yok" görünüyor. Terim başına yeniden tarama
bunun tek pratik panzehiri.

### KOD KAYMASI: SATIRIN KODU BİR MADDEYİ, BAŞLIĞI KOMŞUSUNU ANLATIR

Bayburt'ta bulunan sınıf korpusa tarandı. Cetvel satırının kodu kaynakta bir
maddeyi gösterirken başlığı ve etiketi YANINDAKİ maddeyi anlatıyor; sonuç
etiketin komşu maddenin puanını toplaması. Sessiz: kod var, puan kaynakta
gerçekten yazılı, hiçbir test kırılmıyor.

**Karşılaştırma kelimeyle değil KAVRAMLA yapılır.** Cetvel başlığı adaya
yönelik yeniden yazıldığı için birebir örtüşme beklenemez. Ayırt edici
kavramlar ("davetli konuşmacı", "düzenleme kurulu", "atıf", "patent")
karşılaştırılır; genel sözcükler (uluslararası, bilimsel, toplantı) iki
tarafta da olduğu için hiçbir şey ayırmaz.

İki eleme olmadan tarama okunamaz (62 ham işaret → 20):

- **AYNI KOVA.** "Eş danışmanlık" ↔ "ikinci yürütücü", "düzenleme kurulu" ↔
  "bilim kurulu", "sempozyum başkanlığı" ↔ "düzenleme kurulu başkanlığı",
  "tam metin" ↔ "özet" — hepsi üslup farkı, hata değil.
- **KAYMA İMZASI.** Cetvelin kavramı KOMŞU kodda bulunmalı. Bulunmuyorsa
  işaret ya kod çakışmasıdır (aynı numara başka tabloda) ya da pdftotext'in
  satırı bir sonraki bölüm başlığına bağlamasıdır.

Kalan 20 işaretin ikisi gerçek çıktı:

- **Bayburt 8.1.g** — kodu dergi hakemliğinin (5), başlığı ve `BKCI Kitap`
  etiketi kitap editörlüğünün. Doğrusu 2.1.e (30).
- **Ağrı 2.1/2.2** — kaynak bildiriyi BEŞ kademeye ayırıyor (davetli · sözlü
  tam metin · poster tam metin · sözlü özet · poster özet); cetvel üçe
  indirmiş ve her satıra kümesinin EN YÜKSEK kademesini yazmıştı. Sözlük
  sözlü/poster ayrımını taşımadığı için beş değer birden düştü (20→15,
  15→10, 8→6, 10→8, 5→4).

**Ağrı'nın dersi kaymadan büyük: KADEMEYİ BİRLEŞTİREN SATIR EN DÜŞÜĞÜNÜ
ALIR.** Kaynak beş satırı üçe indiriyorsan, üçün her biri kendi kapsadığı
kademelerin EN DÜŞÜĞÜNÜ taşımalı. "Sözlü/poster ayrımı sözlükte yok" demek,
poster kademesinin de o etikete düştüğü anlamına gelir.

Filtre kod olarak `KaynakTaramaTest`'te (`kavramlar`, `kaymaIsareti`).

### AYNI AİLENİN ÜÇÜNCÜ TERİMİ: DOYUM NOKTASI VE TANIM CÜMLESİ GÜRÜLTÜSÜ

"Bilim kurulu" taraması (üçüncü terim) 100 kaynak buldu ama yalnız **üç yeni
kaynak** çıkardı: Ankara MGÜ, Dokuz Eylül, İstanbul Arel. Aile doymuş
demektir; dördüncü terimi taramak zorunlu değil.

Açık kalan 26 kaynağın çoğu **tanım cümlesi** gürültüsü: "Uluslararası
Bilimsel Toplantı: farklı ülkelerden bilim insanlarının BİLİM KURULUNDA
BULUNDUĞU ve sunumların değerlendirildiği toplantı." Cümle toplantıyı
tarif ediyor, bir görevi değil — sekiz kaynakta birebir aynı metin.
Eleme deseni: `kurulu olan|kurulunda bulunduğu|kurulunun … oluş`.

### BİR SATIR EKLERKEN ANAHTAR ÇAKIŞMASINI PHPStan YAKALAR

Bayburt'a eklediğim `'3.1.d'` satırı dosyada zaten VARDI ve eskisini sessizce
ezdi — PHP aynı anahtarı ikinci kez görünce üstüne yazıyor, hata vermiyor.
Testler de geçti, çünkü ezilen satırın etiketi (`Davetli Konuşmacı`) korpusta
başka cetvellerde de var. Yakalayan tek şey **PHPStan'in `duplicateKey`
uyarısı** oldu (17 → 18).

Ders çift: (1) toplu ekleme betiğinde kodun mevcut olup olmadığını ÖNCE
sına, (2) veri dosyası değiştiren her turda PHPStan'i de çalıştır — testler
bu sınıfı görmüyor.

Uyarıyı kovalarken asıl hata çıktı: cetveldeki `3.1.d` "davetli konuşmacı,
70" diyordu, oysa kaynağın 3.1.d'si DÜZENLEME KURULU BAŞKANI (70); davetli
konuşmacı 3.1.ç (25). **Kod bir satır kaymış**, uluslararası davetli konuşma
yapan aday 25 yerine 70 alıyordu. Etiket kapsam taşımadığı için satır §0
uyarınca ulusal kademeye (3.2.ç, 15) çekildi.

### SÜTUN BOŞ ÇIKIYORSA SAYFAYI GÖRÜNTÜ OLARAK OKU

`pdftotext` puan sütununu boş bırakan on kaynak sayfa görüntüsünden okundu
(`pdftoppm -r 150 -f N -l N -png`, sonra Read). Tur ucuz: sayfa numarası
zaten metinden bulunuyor, on kaynağın tamamı on render ile bitti. Sonuç:

- **Beşinde değer okundu ve satır girildi** — RTE (5), Rumeli (30/20/20/10),
  Toros (1), Kırklareli (300/200/100/50/40), Bilecik (10/5).
- **Üçü YANLIŞ POZİTİF çıktı** ve bu ancak sayfayı görünce anlaşıldı:
  Kütahya DPÜ ile Cerrahpaşa'nın eşleşen satırları **etkinliği tarif
  ediyor** ("jürili/küratörlü/düzenleme kurulu OLAN etkinlik", "düzenleme
  kurulunun yarısı yurt dışından olan toplantı"), bir görevi değil. Kadir
  Has'ın O bölümünde ise puan sütunu gerçekten YOK — tablo bir beyan formu.
- **İkisi girilmedi ama sebebi puan değil**: Eskişehir Teknik 12a'nın puanı
  okundu (80/40/20) ama satır "Üniversite Yönetim Kurulu kararıyla
  görevlendirilmiş olmak kaydıyla" diyor — taşınamayan bir UYGUNLUK kısıtı.
  Ahi Evran'ın Tablo 1'i puan değil ölçüt sayıyor.

**Ders: "puan sütunu boş" tek başına bir sınıf değil.** Altında üç ayrı
durum var — değer var ama çıkarılamadı, değer hiç yok, satır zaten aileye
ait değil. Üçünü ayırmanın tek yolu sayfayı görmek.

### EKLEME ÇAPASI TUTMAZSA SATIR SESSİZCE DÜŞER

Toplu satır ekleyen bir betik yazarken çapayı `'maddeler' => [` etiketine
bağlama. Korpusun bir kısmı diziyi DEĞİŞKENDEN kuruyor (`'maddeler' =>
$maddeler`, `'maddeler' => $tabloA + $tabloB`) ve satırlar o etiketin
ÜSTÜNDE tanımlı; etiketten sonrasını arayan betik hiçbir madde satırı
bulamıyor ve **o dosyayı sessizce atlıyor**. 06.09.2026'da on cetvel bu
yüzden boş kaldı; hata ancak ertesi tur "etiket kaç üniversitede puan
alıyor" diye ölçülünce görüldü.

Doğru çapa **dosyanın son madde satırı** (KONVANSIYONLAR'ın ilk tarifi
buydu). Betiği yazdıktan sonra da **eklediğini geri say**: karar tablosundaki
her kodun dosyada gerçekten bulunduğunu doğrula. "N satır eklendi" çıktısı
yetmez; N, atlanan dosyaları saymaz.

### BİLİMSEL TOPLANTI ORGANİZASYONU AİLESİ (06.09.2026)

Korpusun **85 kaynağı** kongre/sempozyum organizasyonunu puanlıyor (551 satır)
ve aile sözlükte tamamen karşılıksızdı: girilebilen otuz kadar cetvel satırı
`Diğer`e yazmış, geri kalanı bölümü hiç girmemişti ("sözlükte kongre düzenleme
kaynağı yok"). Altı etiket açıldı — **üç rol × uluslararası/ulusal**:

| Rol | Korpus medyanı | Etiket |
|---|---|---|
| başkanlık | 10 | `Toplantı Düzenleme Başkanlığı (…)` |
| kurul üyeliği | 5-6 | `Düzenleme/Bilim Kurulu Üyeliği (…)` |
| oturum başkanlığı | 3 | `Oturum Başkanlığı (…)` |

**Rolü bölmenin gerekçesi ölçüldü.** Tek etikete toplansalardı §0 hepsini
oturum başkanlığının kademesine (3) indirirdi ve başkanlık satırları
üçte-bire düşerdi. Sekretarya ve raportörlük üyelikle aynı medyanda olduğu
için AYRI ETİKET AÇILMADI, üyeliğe katıldı.

**Ailenin sınırı, taramanın en pahalı kısmı.** Dört komşu aile dışarıda
bırakıldı, çünkü hepsi aynı kelimelerle yazılıyor:

- **Derginin kurulu** — "yayın kurulu", "danışma kurulu" editörlük ailesi.
- **Kurumun kurulu** — TÜBİTAK/TÜBA/YÖK kurul üyelikleri geçen turun
  `Dış Kuruluş Kurul Üyeliği` etiketi.
- **Bilimsel olmayan etkinliğin düzenlenmesi** — Atatürk sportif faaliyetin
  düzenleme kuruluna 1, bilimsel toplantınınkine 20 veriyor; tek etikete
  girselerdi §0 ikisini de 1'e indirirdi.
- **Ödül satırları** — "bilimsel kuruluşlarca verilen ödül" deseni `kurul`
  köküne takılıyor. Regexte `kurul(?!uş)` şart.

**"En fazla N puan" ifadesi puan sütunu sanılıyor.** Atatürk'ün satırı
"(… en fazla 60 puan alınabilir)" diyor ve tarayıcı 60'ı satırın değeri
sandı; gerçek değer 15'ti, yani taban FAZLA saydıracaktı. Aynı tuzağın öteki
yüzü Karamanoğlu'nun "(en çok 3 adet)"i. Satır içindeki sayıyı sütun sayma:
sütunun önünde en az on harflik metin olmalı ve "en fazla/en çok/adet"
ifadeleri elenmeli.

**Etiketin kategorisi satırın kategorisini belirler.** Altı etiket `diger`
kategorisinde; motor (kategori, kaynak) çiftiyle eşleştiği için etiketler
ancak `diger` satırlara yapışıyor. Korpustaki aile satırlarının bir kısmı
`bildiri`, `idari_gorev`, `toplumsal_katki` ya da `sanatsal_etkinlik`
kategorisindeydi ve o satırlara yazılamazdı — kategorilerini değiştirmek de
olmazdı, çünkü çoğu `Davetli Konuşmacı` gibi başka bir aileyi de taşıyor.
Çözüm **aynı puanda paralel `diger` satırı** (İTÜ M.6y deseni): sekiz cetvelde
uygulandı. `CetvelKaynakTest`'in "kaynaklar kategori sözlüğünde var" testi bu
hatayı kendiliğinden yakalıyor.

**`Diğer`e EŞDEĞER YAZILMADI.** Yeni etiketler eski `['Diğer']` satırlarının
alt türü değil; eşdeğer yazsaydık oturum başkanlığı kaydı, `diger`
kategorisindeki alakasız her satırdan (adıyla anılan formül, h-indeksi) puan
alırdı. Aday `Diğer` yerine doğru etiketi seçtiğinde o rastlantısal puanı
kaybediyor — bu bir gerileme değil, düzeltme.

Yayma sonucu: **48 cetvel dosyası, 106 satır** (98'i yeni, 8'i paralel), her
etiket 19-52 üniversitede puan alıyor. Girilmeyenler ve sebepleri
`GIRILEMEYEN-YONERGELER.md`'de; en pahalısı Akdeniz (9.5/9.6 yalnız
SCI-E/SSCI/AHCI kongreleri için geçerli, dipnot kısıtı taşınamıyor) ve
Trakya (puan sütunları pdftotext'te kesik).

### Tezden üretilmiş yayına ayrı satır AÇMAK ZORUNDA DEĞİLSİN

Kayıt tezden üretilmiş yayını `tez_yayini` kategorisinde ayrı tutuyor ve daha
KABA bir indeks etiketi taşıyor (`SCIE/SSCI/AHCI` — çeyrek yok). Yönergelerin
çoğu bu yayına ayrı satır vermiyor, normal makale gibi puanlıyor.

Motor bunu kendisi çözüyor: `tez_yayini` kaydı cetvelde karşılık bulamazsa
normal makale/kitap/bildiri satırına düşer (`MaddeKatalogu::tezYayiniKarsiligi`).
İki güvenlik kuralıyla:

  1. Cetvelde HİÇ `tez_yayini` satırı yoksa devreye girer. Satır varsa yönerge
     o yayını bilerek başka türlü puanlıyordur ve ona dokunulmaz.
  2. Kaba etiket birden çok satıra uyarsa EN DÜŞÜK puanlı seçilir — hangi
     çeyrek olduğunu bilmiyoruz, Q1 saymak fazla saymak olurdu (§0).

Yani cetvele tez satırı YALNIZCA yönerge farklı puan verdiğinde yazılır:
Marmara Eğitim'in "tezden üretilen yayınlar mevcut puanın yarısı ile
değerlendirilir" dipnotu gibi. Yönerge susuyorsa satır açma, motor halleder.

Yönerge o kadroda tez yayınını hiç saymıyorsa yolu grup tavanını **0** yazmak:
İzmir Kâtip Çelebi sosyal doçentlikte `'A2' => 0`. Tavan hem doğrudan
eşleşmeyi hem karşılık aramasını birlikte keser.

### Kaynak sözlüğü

`kaynaklar` alanındaki değerler `App\Enums\Kategori::kaynaklar()` içinde tanımlı
sabit listeden gelir; yeni kaynak uydurma. Mevcut listeyi görmek için:

```bash
php artisan tinker --execute 'print_r(App\Enums\Kategori::Makale->kaynaklar());'
```

Bir yönerge kalemi sözlükte karşılıksızsa **girme** ve dosya başlığındaki
"GİRİLMEYEN KALEMLER" bölümüne yaz.

**ETİKETİ UYDURMA — SESSİZCE ÖLÜ SATIR ÜRETİR.** Bir cetvel satırı `kategori`
+ `kaynaklar` çiftiyle faaliyet kaydına bağlanır. Etiket o kategorinin
sözlüğünde yoksa satır hiçbir faaliyetle eşleşmez: aday puanı hak ettiği hâlde
sıfır görür ve hiçbir yerde hata çıkmaz. Sinsi olması burada: motor patlamaz,
test kırılmaz, yalnız cevap yanlış olur.

31.08.2026'daki ilk taramada 63 eşleşmeyen etiket bulundu; otuzu satırın TEK
kaynağıydı, yani o satırlar tamamen ölüydü. Üç tipik hata:

    'kategori' => 'kitap',  'kaynaklar' => ['Kitap Editörlüğü']
        → etiket `editorluk`e ait; satırın KATEGORİSİ yanlış
    'kategori' => 'kitap',  'kaynaklar' => ['BKCI Kitap']
        → `kitap` karşılığı 'BKCI / Scopus Kitap'; 'BKCI Kitap' atıf/editörlük
    'kategori' => 'bildiri', 'kaynaklar' => ['Kongre Düzenleme (Uluslararası)']
        → sözlükte hiç yok, uydurulmuş

`tests/Feature/CetvelKaynakTest.php` artık bütün cetvelleri koşulsuz tarıyor;
yeni bir cetvel girildiğinde uydurma etiket doğrudan kırılır.

Karşılığı olmayan bir kaleme rastlarsan sırayla: (1) sözlükte gerçekten yok mu
diye bak, (2) varsa satırın `kategori`sini düzelt, (3) yoksa sözlüğü genişlet,
(4) genişletemiyorsan SATIRI HİÇ YAZMA ve sebebini `kapsam_notu`na yaz.
Geniş bir "Diğer" kovasına bağlamak çözüm DEĞİLDİR — §0'a aykırıdır, fazla
sayar. Marmara'nın 27. satırı (akademik organizasyon yöneticiliği) bu yüzden
girilmedi; Anadolu'nun jüri ve düzenleme kurulu kalemleri de öyle.

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
- **İstisna — hangi kuralın hangi kategoriyi yönettiğine bak.** Düşük olanı
  seçmek, o kural yönergenin BÜTÜN EŞİKLERİNİN yazıldığı kategoriyi
  yönetmiyorsa doğru. Yönetiyorsa sonuç aracı kullanılmaz hâle getirir:
  Acıbadem'de makale dışındaki kural seçilseydi ("yazar sayısına eşit
  bölünür") her eşiğin dayandığı MAKALE puanı iki yazarlı bir yayında %90
  yerine %50'ye düşerdi — adaya gereken makale sayısının neredeyse iki katını
  gösterirdik. Böyle bir durumda **eşiklerin yazıldığı kategoriyi yöneten
  kuralı** yaz, ters yöndeki hatayı `kapsam_notu`'na "şu kalemde puanınız
  olduğundan yüksek görünür" diye açıkça yaz ve hatanın büyüklüğünü söyle.
  Acıbadem ile Ardahan'da bu yol seçildi; ikisinde de sapma yalnız 2-15
  puanlık bildiri ve kitap satırlarında kalıyor.

### Koşulun istediği nitelik cetvelde yoksa AYNA SATIR aç

Bir yönerge "doktora tezinden üretilmiş en az bir yayın" gibi bir koşul koyup
puanlama tablosunda o nitelik için ayrı satır AÇMAYABİLİR (Üsküdar MADDE 13/d):
böyle bir çalışma kendi yayın türünün satırından puan alıyor. Koşul yine de
değerlendirilebilmeli.

Çözüm, `tez_yayini` kategorisinde ayna satırlar açmak: puanları karşılık
geldikleri satırlarla BİREBİR AYNI, tek işlevleri niteliği taşımak. Puanı
değiştirmedikleri için çifte sayım doğurmuyorlar — bir faaliyetin tek
kategorisi var, aday çalışmayı ya makale ya tez yayını olarak kaydeder.
Kodlar bize ait olduğundan yorum satırında belirtilir ve `kapsam_notu` adaya
"bu çalışmayı tez yayını olarak kaydedin" der.

### Koşula bağlı çarpanı cetvele göm

Bir yönerge "şu birimde A grubu faaliyetler 1,3 katsayısı ile çarpılır" diyorsa
çarpanı koşula yazmaya çalışma — motorda `carpanlar` alanı yok. Çarpan aynı
birimde bütün kadrolarda geçerliyse cetvelin İKİ VARYANTINI üret (çarpanlı ve
çarpansız) ve eşikleri birime göre doğru varyanta bağla (Işık). Ham değerleri
float tutup çarpımdan **sonra bir kez** aşağı yuvarla; önce yuvarlayıp sonra
çarpmak farklı sonuç verir.

### Puan BLOĞA veriliyorsa satırı hiç yazma, KOŞULU metriğe çevir

Bir bölümün birimi eser değil BLOK olabilir: Kafkas'ın eğitim-öğretim bölümü
"Dönemlik programlarda DÖRT FARKLI YARIYILDA ders vermiş olmak — 3 puan"
diyor. 3 puan dört yarıyıla bölünemez (0,75 → 0); satırı 3 puanla yazmak tek
yarıyıllık dersi dört katına çıkarır.

Çözüm iki adımlı: (1) cetvele o bölümün satırlarını HİÇ yazma — toplam puan
bölümün tavanı kadar düşük görünür, §0'ın istediği yön; (2) o bölüme bağlı
KOŞULLARI puandan sayıya çevir, `Kalip::metrik` ile. Kafkas'ta "Eğitim-Öğretim
Faaliyeti kapsamında en az 2 puan" → `metrik('ders_yariyil', 4)`, "en az 4
puan" → `metrik('ders_yariyil', 8)` oldu. Çevirinin aritmetiğini `notlar`a yaz.

### Puanı PORTFÖYE bağlı satır girilmez

Güzel sanatlar tablolarında bir satırın puanı çoğu zaman tek bir esere
değil, bir DOSYAYA veriliyor: ISUBÜ Tablo 3'ün "en az 6 eser sunmak … 120
dakikalık kayıt bulunmak" satırı 60 puan, "en az üç saatlik canlı iki
resital ve orkestra eşliğinde bir konser" satırı 75 puan. Kayıt eser
başına tutulduğu için bu puan bölünemez; satırı yazmak tek bir konser
kaydını 75 puanla ödüllendirirdi. Böyle satırları HİÇ YAZMA, "her bir
etkinlik için" diyen satırları yaz ve farkı `kapsam_notu`'nda söyle.

### Aynı faaliyet İKİ TABLODA birden karşılık bulabilir

Bir yönerge alan gruplarına ayrı tablolar veriyorsa (ISUBÜ: Fen/Sosyal
Tablo 1 + Tablo 2, Güzel Sanatlar Tablo 2 + Tablo 3) aynı makale iki
tabloda iki farklı puan taşıyabilir. Satırların ikisini de yaz: motor her
grubun İÇİNDEKİ en iyi kodu seçtiği için Fen adayının makalesi Tablo 1
satırından, Güzel Sanatlar adayının makalesi Tablo 3 satırından
puanlanır. Barajlara `maddeler` grubunu geçmeyi unutma; unutulursa aday
kendi tablosunda olmayan satırlardan puan toplar.

### Adet tavanı puana ÇEVRİLEBİLİR

Motorda "en fazla N faaliyet" düğümü yok, ama satırın puanı sabitse tavan
puana çevrilir: KTO Karatay "her bir jüri üyeliği için (en fazla 6)" diyor ve
satır 5 puan, yani `grup_tavanlari` içinde 30. Çevrilemeyen tek durum tavanın
YIL BAŞINA olması ("her yıl için en fazla 10 ders"); orada puan yüksek çıkar
ve `kapsam_notu`'nda uyarılır.

### Grup tavanları

`grup_tavanlari` yalnızca **sabit** tavan alır (`'ATIF' => 75`). Yüzdeye bağlı
tavan ("toplam puanın %20'sini aşamaz") ya da başka bir grubun toplamına bağlı
tavan motorda yok — uygulanmaz, `kapsam_notu`'nda uyarılır.

**İstisna: yüzde KADRONUN ASGARİ PUANINA bağlıysa çevrilebilir.** KOSTÜ'nün
Madde 14'ü "lisansüstü tez yönetiminden … elde edilecek puanın ilgili kadronun
gerektirdiği asgari puanın %50'sini aşan kısmı dikkate alınmaz" diyor; asgari
puanlar yönergede yazılı olduğu için tavan kadro başına sabit sayıya iniyor
(20/120/250 → 10/60/125). Cetvelin kadro başına bir varyantı üretilir ve her
eşik kendi varyantına bağlanır (Işık'taki çarpanlı/çarpansız üretimin aynısı;
bir dosya `return ['cetveller' => $cetveller]` ile birden çok cetvel döndürebilir).

### Tavan FAKÜLTE × KADRO ise cetveli çarpanla üret

MEF'in tablosunda her bölümün altında fakülte fakülte tavan notu var ve tavan
kadroya göre de değişiyor ("Mühendislik: doçentlikte en fazla 30, profesörlükte
50"). Beş fakülte × üç kadro = 15 varyant; hepsi tek gövdeden döngüyle üretilip
`return ['cetveller' => $cetveller]` ile döndürüldü. Tavan matrisini dosyanın
başında TEK BİR DİZİDE topla — tabloya dağılmış onlarca notu tek yerde görmek,
kadro atlamayı engelleyen tek pratik.

Fakülteye kapalı bölümler ("Diğer Fakülteler: Bu bölümden puan alamaz") için
satırları silmek yerine o varyantta tavanı **0** yaz; gövde tek kalır.

### Yazar payı KATEGORİYE göre değişiyorsa `kategoriler` yaz, `haric` DEĞİL

Yönergelerin çoğu makaleye isim sırasına bağlı bir kademe tablosu uygularken
kitap, proje, editörlük ve ödülde düz "puan / kişi sayısı" diyor (Amasya:
"kitabın toplam puanı yazar SIRALAMASINA BAKILMAKSIZIN yazar sayısına
bölünür"; Bolu AİBÜ ve Bitlis: "çevirmen, raportör, proje yapanlar, editör,
ödül alanlar, patent sahibi veya düzenleyici sayısına eşit olarak
bölünecektir").

Bu kural `yazar_katsayisi.kategoriler` ile yazılır:

    'yazar_katsayisi' => [
        'haric' => ['atif', 'egitim_ogretim'],
        'kategoriler' => [
            'kitap' => ['sonrasi_pay' => 1.0],   // düz 1/n
        ],
        'roller' => [ /* makalenin kademe tablosu */ ],
    ],

**Kategoriyi `haric`e yazmak çözüm DEĞİLDİR**: `haric` çarpanı tamamen
kapatır, yani çok yazarlı esere TAM puan verilir — §0'ın yasakladığı fazla
sayma. `haric` yalnız yönergenin gerçekten bölme yapmadığı yerde doğrudur;
Amasya projede "araştırmacıların HER BİRİNE" sabit puan verdiği için proje
orada haklı olarak `haric`.

Bir kategori hem `kategoriler`de hem `haric`te olursa `haric` kazanır ve
kural sessizce yok sayılır; `CetvelKaynakTest` bu çakışmayı yakalıyor.

### "En sıkı değeri yaz" kısayolu tavanda İŞLEMEYEBİLİR

Kadroya göre değişen bir tavanı cetvel geneline yazmak gerektiğinde ilk akla
gelen, en düşük değeri seçmektir: eksik saymak serbest. AMA TAVAN BARAJIN
ALTINA DÜŞERSE EŞİK SAĞLANAMAZ HÂLE GELİR ve bu, fazla saymaktan da kötüdür —
aday "asla yeterli değilsiniz" cevabı alır.

Erzurum Teknik'te atıf (G) tavanı alt kadrolarda 20-30, profesörlükte ise G
barajının KENDİSİ 50. En sıkı değeri (20) yazınca üç profesörlük eşiği
sağlanamaz oldu; `CetvelKaynakTest`'in tavan-baraj kontrolü yakaladı.

Sıra şu: (1) tavan bütün kadrolarda AYNI mı, öyleyse doğrudan yaz (Erzurum'da
eğitim tavanı her blokta 150). (2) Değişiyorsa cetveli kadroya göre varyantla
(Ordu, Yalova, Acıbadem, MEF). (3) Varyantlayacak kadar güvenilir okuyamıyorsan
tavanı YAZMA ve sebebini yaz — ama en düşük değeri gelişigüzel yazma, önce
her kadronun BARAJININ altına düşmediğini doğrula.

### Yüzde tavanını ASGARİ PUANDAN SABİTE ÇEVİR

Bazı yönergeler tavanı sayıyla değil yüzdeyle veriyor: "Bu madde kapsamında
ibraz edilen puan; başvuru şartlarında istenen asgari puanın %20'sinden
fazlasını karşılayamaz" (Yalova 5. madde). Motorun `grup_tavanlari`'ı sabit
sayı alıyor — ama yüzde UYGULANAMAZ değil: tabanı olan asgari puan kadro
başına bilindiği için sabite çevrilebilir.

Yalova doçentliğinde asgari 150 → atıf tavanı 30, yeniden atanmada asgari 40
→ tavan 8. Cetvel bu yüzden asgari puana göre varyantlanıyor
(`yalova-2024-sosyal-a150`, `-a40`). Acıbadem'in atıf tavanı da aynı yolla
kuruldu (`acibadem-2025-atif6` … `-atif24`).

**Tavanı uygulamamak §0 İHLALİDİR**, çünkü toplamı ŞİŞİRİR: aday barajın
üstünde görünür. Eksik saymak serbest, fazla saymak değil. Bir tavanı
uygulayamıyorsan sebebini yaz ve gerçekten uygulanamaz olduğundan emin ol:

  Uygulanabilir → yüzde tavanı (tabanı kadro başına sabit)
  Uygulanamaz   → AYNI ESERE özgü tavan (Yalova'nın "aynı ISBN'ye sahip
                  eserde ... %30" kuralı: kayıt aynı esere ait kalemleri
                  birbirine bağlamıyor)

Bir de tavansızlığın gerçekten zarar verip vermediğine bak: İTÜ'nün idari
görev tavanı uygulanmıyor ama o satırlar hiçbir grupta olmadığı için hiçbir
koşulu beslemiyor — yalnız listede görünen puanı etkiliyor. Notu buna göre
yaz; "puanınız yüksek görünebilir" demek, baraj etkilenmiyorsa yanıltıcıdır.

**TABAN ADAYIN KENDİ PUANIYSA DA PES ETME: EŞİĞİN ORAN KOŞULUNDAN ALT SINIR
TÜRET.** Akdeniz'in 11. bölüm başlığı "Bu bölümden alınan puan DİĞER
BÖLÜMLERDEN alınan puanın %40'ını geçemez" diyor; taban adayın kendi puanı
olduğu için ilk bakışta PAÜ'nün "makale başına en çok 50 puan"ı gibi
uygulanamaz görünüyor. Ama eşiğin KENDİ koşulları tabana alt sınır koyuyor:
her Akdeniz eşiği hem `toplam ≥ asgari puan` hem `makale ≥ oran × toplam`
istiyor ve makale o bölümün dışında. Buradan

    diğer bölümler ≥ makale ≥ oran × toplam ≥ oran × asgari puan
    kaynağın izin verdiği tavan = %40 × diğer bölümler ≥ %40 × oran × asgari

çıkıyor; sağdaki çarpım kadro başına SABİT. Yazıldığında eşiği sağlayan
hiçbir adayda fazla saymaz, kaynağın cömert davrandığı yerde eksik sayar (§0
serbest). Akdeniz'de asgari 100/300/500 ve oran %50 → tavan 20/60/100; Güzel
Sanatlar'da oran %40 → 16/48/80.

İki kontrolü atlama: (1) o gruptan EN AZ puan isteyen bir baraj var mı — varsa
alt sınır eşiği sağlanamaz kılar ("Sağlanamaz eşik yazma"); (2) `toplam`
düğümü tavanlı puanı mı topluyor — evetse zincirdeki `toplam ≥ asgari` adımı
geçerli.

### `kapsam_notu`

Adayın gördüğü metin. Şunları söylemeli:

1. Puanların kaynağı.
2. Yazar çarpanı nasıl işliyor ve ne zaman uygulanamıyor ("yazar listesini boş
   bırakırsanız").
3. **Hangi yönde saptığı**: "puanınız olduğundan yüksek/düşük görünebilir".
4. Girilemeyen bölümler ve bunun kimi etkilediği.

### "VE/VEYA" TARAMASI: İKİ KOL MU, TEK NİTELİK Mİ

Kaynaklar iki AYRI faaliyeti tek bende sığdırabiliyor ("…etkinliklere
katılmak **ve/veya** … yarışmalarda derece almak"). İlk giriş çoğu zaman
yalnız birinci kolu okuyor. Korpusta 848 ham "ve/veya" var; okunabilir hâle
iki elemeyle geliyor:

| Sınıf | Sayı | Ne |
|---|---|---|
| nesir | 708 | puan sütunu yok — tanımlar maddesi, eşik nesri, atama usulü |
| nitelik | 91 | ayraç faaliyeti değil NİTELİĞİ bölüyor |
| iki-kol | 49 | gerçek aday, elle okunur |

**Nitelik ayrımını sıfat listesiyle ayıklama, BİÇİMBİLİMLE ayıkla.** Sıfat
listesi ("ulusal, uluslararası, basılı, elektronik, bilim, sanat…") her yeni
kaynakta uzuyor ve "Dünya ve/veya Avrupa Şampiyonalarında" gibi bir satırda
yine kaçırıyor. Dayanıklı ölçüt Türkçenin kendi eki: yönergeler faaliyeti ya
mastarla ("katılmak", "görev almak") ya da `-lık` türevi eylem adıyla
("editörlük", "hakemlik", "başkanlığı", "üyeliği") yazar. **İki kol da böyle
bir baş taşıyorsa iki faaliyet vardır**; taşımayan kol ("bilim", "çoklu
ortam", "karma ses") ortak adı niteleyen sıfattır. Filtre kod olarak
`KaynakTaramaTest`'te.

İkinci kolun üç âkıbeti var ve üçü de meşru:

1. **Ayrı satır gerekiyor** — ikinci kol başka kategoride ya da başka
   varyantın kümesinde. İTÜ M.6y, Iğdır'ın `26.a.p`/`26.b.p` patent satırları.
2. **Zaten ayrı satırda** — Ordu'nun bestecilik (`F.23`) / icra (`F.25`,
   `F.28`) ayrımı. Yapacak bir şey yok.
3. **Sözlükte karşılıksız** — "oturum başkanlığı", "düzenleme kurulu
   üyeliği" (Düzce 3.3/3.4, Aydın ADÜ D1.1) ve "yurt dışında ders/seminer
   vermek" (Dicle F2, KOSTU 18) hiçbir etikete bağlanmıyor. Etiket açmak
   ayrı bir tur: 42 kaynak "oturum başkanlığı", 91 kaynak "düzenleme
   kurulu" puanlıyor, yani açılırsa korpusa yayılması gerekir.

### BİLİNEN HATAYI BULMAYAN TARAYICI KALİBRE DEĞİLDİR

Her tarayıcı bir hatadan doğuyor. **Yazdıktan sonra ilk iş, doğuran hatayı
bulup bulmadığına bakmaktır.** "Ve/veya" tarayıcısının ilk sürümü 19 işaret
üretti ve İTÜ M.5 İÇLERİNDE DEĞİLDİ — hâlbuki tarama onun için yazılmıştı.

Sebep pdftotext'in satır sarması: ayracın iki kolu iki ayrı FİZİKSEL SATIRA
düşüyordu ("…katılmak ve/veya uluslararası kuruluşlar tarafından düzenlenen
15" / "tasarım yarışmalarında derece/mansiyon almak"). Satır bazlı tarayıcı
ikinci kolu hiç görmüyor. ±2 satırlık BLOK üzerinde çalışınca 57 işaret ve
İTÜ içlerinde.

Kural: kaynak metinde satır bazlı tarama yapma; blok kur. Aynı tuzak dipnot
ve üst simge taramalarında da vardı (KONVANSIYONLAR §1 "DİPNOT NUMARASI
TABLOYA YERELDİR").

### VARYANTLARIN BARAJ KÜMELERİ AYRIK OLABİLİR — PUAN DOĞRUYKEN KÜME EKSİK

Bir satırın puanı kaynağa birebir uysa bile, satır **o varyantın baraj
kümesinin dışında** duruyorsa aday puanı toplamda alır, barajda alamaz.
Sessizdir: hiçbir tavan aşılmaz, hiçbir test kırılmaz, adayın toplamı doğru
görünür — yalnız eşik sağlanmaz. §0'ın hoş gördüğü eksik sayma değil, **yanlış
FAIL** yönüdür.

İTÜ'de iki varyantın `ESER-PUANI` kümesi birbirinin tersiydi:

| Varyant | Kümede | Kümede değil |
|---|---|---|
| `itu-2022-mf` | `G.7d` (yarışma ödülü) | `M.*` |
| `itu-2022-moda` | `M.*` | `G.7d` |

Yarışma ödülü etiketi yalnız `G.7d`de duruyordu; moda adayının tasarım
yarışması ödülü esere hiç girmiyordu.

Sebep **iki kollu satır**: kaynağın M.5/M.6'sı "…etkinliklere tasarımlarıyla
katılmak **ve/veya** … tasarım yarışmalarında derece/mansiyon almak" diyor.
İki ayrı faaliyet tek bende sığdırılmış; ilk girişte yalnız birinci kol
okunmuş. **"ve/veya" gören satırda iki kolu da ayrı ayrı ara** — ikincisinin
karşılığı çoğu zaman başka bir bölümde zaten vardır ve o zaman soru "puan kaç"
değil, "hangi kümede".

Çözüm, var olan satırın puanını değiştirmek değil, **aynı puanda ikinci bir
satır** açmaktır (`M.6y`, 5 puan = `G.7d`). Eşit puan `puan()`in MAX'ını
değiştirmez, yani hiçbir yerde fazla saydırmaz; yalnız satır artık ikinci
varyantın kümesindedir. Puanı yüksek kolun değerine (M.6'nın 6'sı) çekmek
yanlış olurdu: etiket `G.7`nin dört derece/mansiyon kademesini birden taşıyor
ve §0 en düşüğünü (ulusal mansiyon, 5) seçtiriyor.

Nerede aranır: bir cetvelde birden çok varyant varsa ve varyantların grup
listeleri **farklı bölüm öneklerinden** kuruluysa (`M.*` ile `G.7d` gibi),
aynı kavramın her varyantta bir karşılığı olup olmadığı elle kontrol edilir.

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

**BU KURAL ARTIK TESTLE KORUNUYOR** — `tests/Feature/AdayMetniTest.php`. Test
her eşiğin bütün düğüm `aciklama`'larını ve `aday_notu`'sunu tarıyor; MADDE,
Tablo-N, EK-N, Çizelge-N, A.1, A1.1 desenlerinden biri geçerse kırılıyor ve
hangi üniversitenin hangi eşiğinde ne bulduğunu yazıyor.

Kural korpusa SONRADAN eklendi ve o an 111 üniversite kirliydi; süpürme on
dokuz partide tamamlandı (bkz. "Aday metni süpürmesi N/N" commit'leri) ve
geçici borç listesi kaldırıldı. **Test artık bütün korpusu koşulsuz tarıyor.**
Yeni bir yönerge girildiğinde aday metnine kod sızarsa doğrudan kırılıyor.

Desen dört kod biçimini birden yakalıyor: NOKTALI kodlar (A.1, A1.1), noktasız
ARALIKLAR (A1-A4, C1-C7), TİRELİ harf-rakam (A-1, A-1.1, D-5, F-3) ve
yönergenin madde numarasını SÖZLE anan biçimler ("01-06 numaralı maddeler",
"1/a bendi", "TABLO B"). Dergi çeyrekleri (Q1-Q3) bilinçli olarak dışlandı:
onlar yönergenin kodu değil, adayın tanıdığı bir ad.

Buna Roma rakamlı ve harfli ekler (Ek-I, EK-A, EK-Ç), sıra sayılı madde
atıfları ("20. maddesi", "1., 2. ve 8. maddelerin") ve harfle anılan kümeler
("A grubu", "B tablosu") de dâhil. İki İSTİSNA var, ikisi de testte ayrı ayrı
elenmiş durumda: KANUN madde numaraları ("2547 sayılı Kanun'un 26. maddesi")
adayın zaten tanıdığı atıflar, ve sıra noktası olmayan "3 madde belgelemek"
düz Türkçe.

Desen dört turda bu hâle geldi; her seferinde temiz sanılan dosyalarda yeni
sızıntı çıktı. İki ders:

  1. Yeni bir kod biçimi görürsen deseni genişlet, sonra BÜTÜN korpusu yeniden
     tara — eski dosyalarda da bulunması olağan.
  2. Tarayıcın `preg_match` değil `preg_match_all` kullanmalı. Tek eşleşmeye
     bakan tarayıcı, ilk eşleşme meşru bir kanun atfıysa metnin geri kalanını
     hiç görmüyor; bu yüzden bir tur "sıfır" raporlarken 208 sızıntı duruyordu.

Sızıntının dört yeri var, dördüne de bak:

1. `Kalip::toplam`'ın `liste` argümanı (aşağıdaki paragraf).
2. Düğüm açıklamaları — `adet`, `beyan`, `puanDan`, `hesaplanamiyor`.
3. **Düğüm BAŞLIKLARI** — `Kalip::ve`/`veya`'nın ilk argümanı. Bu koşul
   listesinin en üstünde bir satır olarak görünüyor; Çukurova'da "Dr. Öğr.
   Üyesi — Tablo 1. Eğitim Bilimleri" diye duruyordu.
4. **Ortak not değişkenleri** — bütün eşiklere eklenen bir `$NOT_CETVEL` ya da
   `$BARAJ_NOTU` içindeki tek bir kod onlarca eşiğe yayılıyor.

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

### Puan barajı olmayan, ÖLÇÜT SAYAN yönergeler

Bir yönerge puan tablosu yayımladığı hâlde hiçbir maddesinde puan barajı
koymayabilir. Bartın'ın atama ölçütleri PUAN değil ÖLÇÜT SAYIYOR: yirmi (Dr.
Öğr. Üyesi) ve yirmi iki (doçent, profesör) satırlık listeler veriyor, her
satırın "temel ölçüt" ile "yardımcı ölçüt" olmak üzere iki dalı var ve
yönerge "aynı satırda belirtilenlerden sadece biri değerlendirilir" diyor.

Karşılığı: her satır bir `Kalip::veya`, sayım `Kalip::kIle($aciklama, $k,
$cocuklar)`. `Kalip::toplam` HİÇ KULLANILMAZ — kullanmak, yönergede olmayan
bir baraj uydurmak olur. Cetvel yine de puanlarıyla girilir (aday başvuru
formunda o puanı beyan ediyor) ama `kapsam_notu` adaya toplam puanın atamada
bir eşiği olmadığını AÇIKÇA söylemelidir.

Bu desende asıl karar, değerlendirilemeyen ölçütlerde verilir:

- Satırın **iki dalı da** faaliyet kaydından okunamıyorsa satırı hiç yazma.
- **Tek dalı** okunamıyorsa yalnızca okunabilen dalı yaz.

İkisi de sayımı zorlaştırır (aday bir ölçüt daha az sayar), yani §0'ın
istediği yöndedir. Ama sayının ne kadar daraldığını `notlar` ve `aday_notu`
söylemeli: aday, listelenmeyen bir ölçütü sağlıyorsa gerçek durumunun
ekrandakinden iyi olduğunu bilmeli. Bartın'da Tablo-1'in 20 satırından 3'ü
(yurt dışı süresi, ders anketi, idari görev süresi), Tablo-2'nin 22
satırından 1'i (spor) hiç yazılamadı.

**Ölçüt aralığı ile tablo boyu çelişebilir.** Bartın'ın metni "1 ila 13"
diyor ama tablo 20 satır taşıyor (tablo büyümüş, metin güncellenmemiş).
Kaynağı düzeltme: "en az 4" koşulu metnin dediği aralığa, "toplam 6" koşulu
tablonun tamamına bağlandı.

### `referans` düğümüne dikkat

`referans` hedef eşiğin ŞARTININ TAMAMINI çeker — puan barajları dâhil. Bir
yönerge "doçentliğin YAYIN koşullarını tekrarla" diyor ve profesörlüğün kendi
puan barajları ayrıysa (Dokuz Eylül Madde 1.14.3), `referans` adaya yönergede
yazmayan bir baraj gösterir. Böyle durumlarda koşulları bir kapanışa (closure)
alıp iki kadroda iki farklı dönemle çağır; kapanışa dönem ADINI da geçir, yoksa
aday metni "Doktora sonrası" derken motor doçentlik sonrasını filtreler.

Dönem sabitleri: `DOKTORA_SONRASI`, `DOCENTLIK_SONRASI`, `SON_ATAMA_SONRASI`.

### KAYNAK KENDİYLE ÇELİŞİYORSA ÖZEL KURAL GENELE ÜSTÜN

Akdeniz'in 11. bölüm başlığı "bu bölümden alınan puan diğer bölümlerden
alınan puanın %40'ını geçemez" diyor; GRUP 4 (Devlet Konservatuvarı)
tablosunun dipnotu ise "bu puanın en az YARISI 11.4'ten karşılanmış
olmalıdır". İkisi aynı anda sağlanamaz: %40 kuralı 11. bölümü toplamın en çok
%28,6'sında tutar.

Çözüm sırası: (1) çelişkiyi düzeltme, KAYDET; (2) eşiği sağlanamaz bırakma —
aday "asla yeterli değilsiniz" cevabı alır ve bu fazla saymaktan da kötüdür;
(3) ÖZEL kuralı genel kurala tercih et ve yalnız o varyantta uygula. Akdeniz'de
konservatuvar varyantında 11. bölüm tavansız bırakıldı, öteki varyantlarda
tavan yerinde; çelişki `aday_notu`'nda birebir aktarılıyor ve adaya
"başvurmadan önce üniversiteye teyit ettirin" deniyor.

### Sağlanamaz eşik yazma: TAVANIN ÜSTÜNDEKİ BARAJ

Bir yönergenin gövdesi tablonun kendi tavanından yüksek bir baraj isteyebilir:
İzmir Kâtip Çelebi EK-C doçentlik metni eğitim öğretim faaliyetlerinden "en az
25 puan" derken aynı tablonun dipnotu "bu madde kapsamında en fazla 15 puan
alınabilir" diyor. 25'i yazmak eşiği hiçbir adayın sağlayamayacağı hâle
getirir — kaynağa sadakat burada aracı kullanılamaz kılar.

Çözüm: barajın ULAŞILABİLİR EN SIKI hâlini (tavanın kendisini) yaz, çelişkiyi
`notlar` ve `aday_notu`'nda birebir aktar ve adaya "başvurmadan önce
üniversiteye teyit ettirin" de. Bu, §"Kaynaktaki hatayı DÜZELTME, kaydet"
kuralının sağlanamazlık istisnasıdır.

### `beyan` ne zaman

Koşul faaliyet kaydından **hesaplanamıyorsa**. Örnekler: "başlıca araştırma
eseri olarak sunmak", "5 yıl çalışmış olmak", "deneme dersinden 75 almak",
"2 eserine 30 atıf yapılmış olmak" (kayıt atıf sayısını tutar, atıf alan eser
sayısını değil).

Hesaplanabilir bir koşulu beyana çevirme; beyan, adayın kendi onayına bırakılan
şeydir.

### On altı ek, beş kural: ÖNCE NORMALLEŞTİRİP DİFF'LE

Kastamonu'nun yönergesi on altı akademik birim için ayrı "özel şartlar" eki
taşıyor; her biri dört kadro × dört koşul. Ekleri boşluk, satır kayması ve
"Doçentlik sonrası süreçte sonraki süreçte" gibi kopyala-yapıştır artıkları
normalleştirip karşılaştırınca geriye YALNIZCA BEŞ farklı kural seti kaldı
(yedi ek birebir aynı, dört ek birebir aynı, iki ek yalnızca "1-8" ile
"1-9" farkı taşıyor).

On altı eki tek tek yazmak on altı kez hata yapma fırsatıdır. Ekleri önce
metin olarak hashleyip grupla, sonra grupları diff'le; kalan farkları elle
oku. Aynı yöntem Kafkas'ın on temel alan tablosunda da yürüdü.

### Alan başına ayrı tablo ≠ alan başına ayrı cetvel

Bir yönerge her temel alan için ayrı tablo verse bile tabloların çoğu birebir
aynı olabilir. Önce **tabloları birbirine karşı diff'le**: İstanbul Kültür'ün
dokuz tablosundan yalnızca üçü puan olarak farklıydı (Hukuk ve Dil'de kitap
puanı, Güzel Sanatlar'da ek bölüm), kalan altısı ortak gövdeyi paylaştı. Dokuz
cetvel yazmak yerine bir gövde + üç varyant yeterli oldu; ÜAK dosyasındaki
`farklar` deseninin aynısı.

Ayrım genellikle cetvelde değil KOŞULDA: aynı puan tablosu üstüne her alan
kendi alt kapısını koyuyor.

**Tersi de var: tablolar GERÇEKTEN farklıysa birleştirmek fazla saydırır.**
Akdeniz'in 11. bölümü altı FAKÜLTE tablosuna bölünmüş ("her temel bilim alanı
kendi özel alanından puan alır") ve aynı sözlük etiketi tablodan tabloya
farklı puan alıyor: `Yarışma Derecesi / Mansiyon` sporda 20, mimarlıkta 50,
ilahiyatta 50. Hepsini tek cetvele koymak `puan()` en yükseği aldığı için
HERKESE en cömert tabloyu verir. Motorun ayırabildiği en ince eksen `alan`
olduğundan tablolar temel alana bağlanır; kendi tablosu olmayan alanlar temel
cetvelde kalır.

Eşikleri elle çoğaltma: şart ağacı değişmiyor, yalnız `cetvel` değişiyor.
Eşik listesini `$temel` diye kur, sonunda bir döngüyle kendi tablosu olan
alanları ayrı kayda böl (`akdeniz.php`). **Anahtara alanı EKLEME**:
`SartDeposu::esikler()` `alan` dizisini kayda açarken anahtarın sonuna alanı
zaten ekliyor; elle eklersen `akdeniz-dr-grup2-spor-spor` çıkar ve bölünmemiş
eşiklerin anahtarları da sebepsiz değişir. Bölmenin doğru yapıldığını
anlamanın ucuz yolu: bölmeden önceki ve sonraki anahtar KÜMESİNİ diff'le,
ikisi birebir aynı olmalı.

Bir fakültenin tablosu sözlükte hiç karşılık bulmuyorsa varyantını AÇMA:
Akdeniz 11.5'in iki satırı da "uluslararası/ulusal kuruluşların YÖNETİM
KURULLARINDA yer almak" diyor, sözlükteki tek yakın etiket
(`Kurul / Komisyon Üyeliği`) üniversite İÇİ kurulları taşıyor ve bağlansaydı
fakülte kurulu üyesi olan her sağlık adayı kaynağın vermediği puanı alırdı.

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

**TEK İSTİSNA: BELGE EŞLEMEYİ KENDİSİ DOĞRULUYORSA.** Kuralın amacı uydurma
baraj göstermemek; belgenin kendi içinden okunabilen bir eşleme uydurma
değildir. İstisnaya girebilmek için İKİSİ BİRDEN gerekir:

  1. Grup listesi KAPALI olmalı — anılan gruplar temel alan uzayını tüketmeli,
     yani anılmayan alanın düşebileceği başka bir kova kalmamalı.
  2. Belge, eşlemeyi en az bir yerden AÇIKÇA doğrulamalı — o alanın adını
     anmalı, o fakülteyi bir grubun içinde saymalı ya da o alana özel bir ek
     koşul getirmeli.

Ankara Üniversitesi ikisini de sağlıyor: üç bölüm var (Fen-Mühendislik-Sağlık,
Sosyal Bilimler, Güzel Sanatlar) ve belge IV/b'de "Sosyal Bilimler alanından
başvuru yapabilecek bölümler" listesinde SPOR BİLİMLERİ FAKÜLTESİ'ni sayıyor,
I/ı'da da HUKUK TEMEL ALANI'na ayrı bir monografi koşulu getiriyor. Eğitim,
filoloji, hukuk, ilahiyat ve spor Sosyal'e, ziraat Fen'e bağlandı.

Ege Üniversitesi sağlamıyor: altı grup var ama eğitim, filoloji ve ziraat
belgede HİÇ geçmiyor — doğrulama yok, eşik de yok. Iğdır da öyle: dört grup
sayılıyor, mühendislik ve ziraat hiç anılmıyor; "Fen ve Sağlık" adının kendisi
mühendisliği dışarıda bırakıyor.

Ölçüt tek soruya iniyor: **belge bu alanı bir yerde anıyor mu?** Anıyorsa
eşleme okunabilir, anmıyorsa tahmindir.

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
  Karar **fakülte fakülte** verilir, üniversite geneline değil: Gebze Teknik'te
  Mühendislik/Fen yeniden atanması (MADDE 4) barajı atama süresine bağladığı
  için (1 yıl 24 · 2 yıl 48 · 3 yıl 72 · 4 yıl 96 puan) girilmedi, ama İşletme
  (MADDE 8) ve Mimarlık (MADDE 12) yeniden atanmaları süreye bağlı olmayıp
  "son atama tarihinden sonra şu ölçütlerden en az ikisi/üçü" dediği için
  `SON_ATAMA_SONRASI` dönemiyle girildi.
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

### Kod ÖNEKİYLE aralık eşleştirme A.1'i A.10'a bağlar

"A.1-A.13 maddeler kapsamında" gibi aralıklara `str_starts_with($kod, 'A.1')`
ile grup kurma refleksi, `A.10`, `A.11`, `A.14`, `A.16` ve `A.17` kodlarını da
yakalar. Pamukkale'de bu, `A.1-A.4` grubunu 7 yerine 23 satıra çıkarmış,
`A.1-A.12`, `A.1-A.13`, `A.1-A.15` ve `A.1-A.16` gruplarını da birbirinin aynısı
yapmıştı — dört ayrı baraj tek barajla ölçülür hâle gelmişti. Test yakalamaz;
gruplar boş değil, sadece yanlış.

Kural: NOKTALI ya da ÇOK BASAMAKLI kod uzayında aralık gruplarını AÇIKÇA yaz
(`$A1 = ['A.1a','A.1b','A.1c']` gibi) ve aralıkları bu parçaları birleştirerek
kur. Önek eşleştirmesi yalnız kodun tek karakterlik harf bloğu olduğu
cetvellerde (`A-`, `B-`, `K-1`) güvenlidir. Doğrulama turunda ardışık aralık
gruplarının BOYUTLARI kesin artmalı; ikisi aynı çıkıyorsa önek sızması vardır.

---

### Madde kodu SALT RAKAM olmasın

`'11' => [...]` yazdığında PHP anahtarı `int(11)`'e çevirir. Tek cetvelde sorun
çıkmaz (`isset($maddeler['11'])` tam sayı anahtarı da bulur) ama iki tabloyu
`array_merge` ile birleştiren dosyalarda (Ahi Evran'ın Ek-1 + Ek-2 varyantı)
`array_merge` SAYISAL ANAHTARLARI YENİDEN NUMARALANDIRIR: `'11'` sessizce `0`
olur, o maddeye bağlı grup boşalır, tavanı da boşa düşer. Test yakalamaz —
grup boş olduğu için hiçbir şart patlamaz, yalnızca puan eksik hesaplanır.

Kural: madde kodunda en az bir harf bulunsun (`'11a-f'`, `'M11'`). Doğrulama
turunda `array_filter(array_keys($katalog->maddeler), 'is_int')` boş dönmeli.

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
- **Kısmi font kayması Çankaya'daki gibi tam bozulma değildir — önce kapsamını
  ölç.** Afyonkarahisar Sağlık'ta yalnızca BAŞLIK/kalın metnin fontu bozuktu
  (büyük İ → `Ġ` U+0120, büyük Ş → `Ģ` U+0122); gövde metni ve puan tablosu
  ayrı bir font alt kümesinde, bozulmamış çıktı. `grep -c` ile İ/Ġ ve Ş/Ģ
  sayısını karşılaştırmak bunu bir dakikada ayırt ediyor: ikisi de belgede
  varsa (yalnızca biri değil) kısmi bir kayma var demektir, tabloyu okumaya
  engel değildir — Çankaya'daki gibi haritalamaya girmeden devam et.
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
- **Tablo başlığındaki eşik, bölüm eşiği olmayabilir.** Bursa Teknik'in
  "Aktivite-2 (… en az 20 Puan)" başlığı bölümlerin EN YÜKSEĞİNİ yazıyor;
  gerçek bölüm eşiği proje tablosunun İÇİNDE, dikey ortalanmış bir hücrede
  duruyor (Denizcilik'te 15/20, Orman'da 20/20/15). Başlığa güvenmek bir
  bölümün adayına 15 yerine 20 puanlık baraj gösterirdi. Sütunlu tablolarda
  başlıktaki sayıyı gördükten sonra gövdede aynı birimde başka sayı var mı
  diye bak.
- **İçindekilerdeki harf sırasına güvenme.** Bursa Teknik'in İnsan ve Toplum
  Bilimleri bölümünde tabloların "(devamı)" sayfaları da harf almış: 1.2.e
  doçentliğin devamı, 1.2.g tecrübeli doçentliğin devamı, profesörlük ise
  1.2.h. Diğer fakültelerde a-g gitmesine bakıp 1.2.f'yi profesörlük sanmak,
  doçentliğin hafif varyantını profesörlük eşiği olarak girmek olurdu. Her
  bölüm başlığının KADRO ADINI oku, harfini değil.
- **Metin katmanı SAYFA SAYFA değişir.** Burdur'un dosyası üç hafta "yönerge
  değil, YÖK'e gönderilen üst yazı" diye kayıtlıydı: ilk iki sayfa gerçekten
  üst yazı ve metin katmanı VAR, yönergenin kendisi ise 3-13. sayfalarda ve o
  sayfalar taranmış. Baştan okunan bir kaç yüz bayt dosyanın tamamı sanılmış.
  Bir dosyayı "ölçüt metni yok" diye kapatmadan önce sayfa sayfa ölç:
  `for i in $(seq 1 13); do printf "%s " $i; pdftotext -q -f $i -l $i X.pdf - | wc -c; done`
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
| Girildi | 175 üniversite · 6716 eşik · 445 cetvel |
| Okuma engeli çözüldü, giriş bekliyor | 0 |
| Kaynak sorunuyla bekleyen | 3 (Balıkesir, Türk Hava Kurumu, Maltepe — puan tablosu PDF'te yok) |
| Girilmemiş, engeli bilinmeyen | 0 |

Girildi satırı elle sayılmaz, motordan okunur — 29.08.2026'da bu satır da bayat
çıktı (163/6151/296 yazıyordu, gerçek 167/6343/300):

```bash
php artisan tinker --execute '
$d = app(App\Services\Scoring\Sart\SartDeposu::class);
$e = $d->esikler(); $u = [];
foreach ($e as $x) { $u[$x["universite"]] = true; }
printf("esik=%d universite=%d cetvel=%d\n", count($e), count($u), count($d->cetveller()));'
```

**GRUP TAVANI TURU BİTTİ (02.09.2026).** Bütün korpus kaynak metinlerine
karşı tarandı; on dört üniversitede elli beş eksik tavan girildi, altı
üniversitede tavanın neden uygulanamadığı dosya başlığına yazıldı. Yöntem ve
yanlış pozitif sınıfları §1'in "GRUP TAVANI TARAMASI" başlığında. Kalan
tavanların hepsi ya satırı girilmemiş bölümlere ait ya da motorda karşılığı
olmayan biçimde (yıl/yarıyıl başına, aynı esere özgü, makale başına).

**SIRADAKİ İŞ — KUYRUK BOŞ.** Ne okunamayan ne girilmemiş ne de yarım kalmış
dosya var. Geriye yalnızca DIŞARIDAN BELGE bekleyen beş üniversite kaldı:
Balıkesir, Türk Hava Kurumu ve Maltepe'nin puan tabloları (PDF'lerinde hiç yok),
SANKO ile İstanbul Okan'ın çizelgeleri (ikisi de vekil cetvelle girildi).
Bunların dışındaki iş, yeni bir yönerge PDF'i gelmesini gerektiriyor.

**KAYNAK SÖZLÜĞÜ GENİŞLETİLEBİLİR — "SÖZLÜKTE YOK" KALICI ENGEL DEĞİL.** Dokuz
Eylül'ün güzel sanatlar ve konservatuvar alanları üç hafta "Puanlandırma
Formunun D bölümü sözlükte karşılıksız" diye bekledi. `Kategori`'ye 19 etiket
eklenince bölüm bir oturumda bitti — üstelik 38-41 arası (çalgı, opera, bale,
kompozisyon) hiç yeni etiket istemedi: Mersin için açılmış konservatuvar kümesi
zaten oturuyordu. Yeni etiket açmadan önce MEVCUT listeyi baştan sona oku;
açtıktan sonra da bir etikete birden çok satır düşüyorsa daima DÜŞÜĞÜNÜ gir ve
çakışmayı betikle doğrula:

```bash
php -r '$c = require "database/data/cetvel/X.php";
foreach ($c["maddeler"] as $kod => $m) {
    $a = ($m["kategori"] ?? "?")."|".implode(",", $m["turler"] ?? [])."|".implode(",", $m["roller"] ?? []);
    foreach ($m["kaynaklar"] ?? [] as $k) { $map["$a :: $k"][] = "$kod=".$m["puan"]; } }
foreach ($map as $k => $v) { if (count(array_unique(array_map(fn($x) => explode("=", $x)[1], $v))) > 1) {
    echo "CAKISMA $k -> ".implode(", ", $v)."\n"; } }'
```

**BEŞ SÜTUNLU KOŞUL TABLOSUNDA SATIR ETİKETİ ALTTA OLUR.** KTÜ'nün on üç
fakülte eki "Zorunlu/En Fazla | 200 P /--- | …" satırını, ait olduğu bölümün
ADINDAN ÖNCE yazıyor: sayı satırı üstte, "1. Makale" etiketi altta. OCR bunu
kolonlara böldüğü için sayılar bir bölüm kaymış görünüyor. Bir sayfayı görüntü
olarak açıp tablonun ilk iki satırını görmek ayrımı bir bakışta çözüyor;
çözmeden girilirse makale barajı kitap bölümüne yazılırdı.

**KARADENİZ TEKNİK ÖN TARAMASI YAPILDI, GİRİLMEDİ.** 4398 satırlık OCR
çıktısı şu yapıda: EK-1 bütün kadrolar için ZORUNLU başvuru koşulları
(sözlü sınav, yabancı dil 65 — yabancı dille eğitim yapan bölümlerde 85 —,
lisans sonrası en az 89 gün yurt dışı gözlem/eğitim/araştırma ve bunun proje
alternatifi), EK-15 tek bir puan tablosu, ARADAKİ ON ÜÇ EK ise FAKÜLTE
FAKÜLTE özel koşullar. On üç ek NORMALLEŞTİRİLİP HASH'LENDİ: hiçbiri
birbirinin aynı değil, her biri 4100-5400 karakter. Yani Kastamonu'daki
"on altı ek, beş kural" kısayolu burada İŞLEMİYOR; on üç ek tek tek
okunacak. Fakülteler: Diş Hekimliği, Eczacılık, Edebiyat, Fen, İİBF,
Mimarlık, Mühendislik, Of Teknoloji, Orman, Sağlık Bilimleri, Sürmene Deniz
Bilimleri, Tıp, ve öğretim üyesi tahsisli enstitü/YO/MYO (EK-14 yalnız 8
satır). Eşikler temel alana değil FAKÜLTEYE bağlı olduğu için her kayıt
`birim` taşıyacak — Trabzon ve FSMVÜ'deki gibi. Yurt dışı koşulunun
alternatifi "istenen asgari puanın %30 fazlası" (profesörlükte) ve "%30"
(doçentlikte); OCR bu iki yüzdeyi "430" ve "930" diye okumuş, girmeden önce
görüntüden doğrulanmalı.

**YAN YATIK VE TERS BASILMIŞ SAYFALAR.** Piri Reis'in EK-1 tablosu yan yatık
basılı, 19. sayfası ayrıca 180° ters. `magick ... -rotate 90` ile döndürüp
gözle okumak tek pratik yol; `sips -r 180` ters sayfayı düzeltiyor. OCR bu
sayfalarda tamamen çöp üretiyor, ama sayfayı çevirip GÖRÜNTÜ olarak okumak
dakikalar sürüyor.

**TELAFİ DALLARI İÇİN `donusumler` VAR, KULLAN.** Çankaya'nın her alanında
"makale şartını sağlamayan aday şu faaliyetleri makale yerine saydırabilir,
en fazla iki makale yerine" biçiminde bir telafi var. Motorun `donusumler`
alanı bunu doğrudan karşılıyor (`kaynak`, `kaynak_adet`, `hedef_adet`,
`azami`, `kota_grubu`); bir `adet` düğümüne `+ ['donusumler' => [...]]` ile
takılıyor. Sabancı dosyası uzun örneği taşıyor. Telafi kolunu düşürmek yerine
bunu kullan — kota da korunuyor.

**ÜNİVERSİTE ADI TUTMUYORSA MIGRATION YAZ.** Munzur'un yönergesi kurumu
"Munzur Üniversitesi" diye anıyordu, `universiteler.php` ise eski adıyla
"Tunceli Munzur Üniversitesi". `SartAgaciTest`'in "her eşiğin üniversitesi
universiteler.php'de tanımlıdır" testi bunu yakaladı. Ad değiştirmenin doğru
yolu veri dosyası + migration ikilisi (`2026_08_29_140000_munzur_universite_
adini_duzelt.php`, Bezmiâlem örneğinin aynısı); yalnız veri dosyasını
değiştirmek `UniversiteSeeder`'ın `updateOrCreate`'i yüzünden yeni satır açıp
eskisini öksüz bırakır.

**TARANMIŞ PDF'İN PUAN SÜTUNU HER ZAMAN GÖZLE DOĞRULANMALI.** Tekirdağ'ın
EK-2 tablosunda OCR üç satırı yanlış okumuştu ve üçü de veriyi bozardı:
TR Dizin makalesi 3 (doğrusu 13), BKCI kitap bölümü 20 (doğrusu 25), TÜBİTAK
büyük projede görev alma 75 (doğrusu 25). Çıktı "temiz" görünüyordu — hatalar
tek başına makul sayılardı, ancak sütunu gözle karşılaştırınca çıktı. Kırklareli
için yazılan kırpma tarifi bu işi bir dakikada yapıyor.

**TARANMIŞ TABLONUN PUAN SÜTUNU OCR'DA HİÇ ÇIKMAYABİLİR.** Kırklareli'nin
EK-I tablosunda A, B ve Ç bölümlerinin puanları `tesseract` çıktısında yoktu:
sütun dar ve başlığı DİKEY yazılmış ("PUAN"), tesseract onu satır metnine hiç
katmıyor. Bölümün öteki sayfaları (C, D, E…) aynı çalıştırmada temiz okundu,
yani "OCR bozuk" teşhisi yanlış olurdu. Çözüm bir satır:

```bash
magick pg-07.png -crop 40%x100%+1987+0 +repage -resize 900x pg07-right.png
```

Sayfanın sağ şeridini kırpıp GÖRÜNTÜ OLARAK okumak yetiyor; satır sırası
soldaki gövdeyle birebir eşleşiyor. Bir bölümün puanları eksikse tabloyu
okunamaz ilan etmeden önce bunu dene.

**İstanbul Okan girildi** (29.08.2026): elimizdeki dosya puan yönergesi değil
PERSONEL yönergesiymiş — cetvel yok, baraj yok, üç kadronun başvuru maddesi de
ayrı bir "Akademik Yükseltme ve Atama Ölçütleri" belgesine devrediyor.
Yönergenin verdiği tek akademik ölçüt kadro başına bir yayın şartı; devir
`Kalip::hesaplanamiyor` düğümü olarak her eşiğe yazıldı. Ayrıntı
`GIRILEMEYEN-YONERGELER.md`'de kendi başlığında.

Dokuz Eylül ötekilerden farklı: üniversite korpusta zaten var, eksik olan
Madde 2.11 (yedi alt alan) ile 2.12 (beş alt alan) ve Puanlandırma Formunun
D bölümü (24-41. maddeler). Girilebilmesi için ÖNCE
`App\Enums\Kategori::kaynaklar()`'ın `SanatselEtkinlik` listesine film,
animasyon, oyun, TV, reklam ve müzik teknolojisi etiketleri eklenmeli.

**OCR ÇIKTILARI ZATEN ORADAYMIŞ.** `pdf-ocr/` klasörü 8 Ağustos 2026'da
doldurulmuş; `GIRILEMEYEN-YONERGELER.md` ise üç hafta boyunca "hiçbiri
okunamıyor" demeye devam etmiş. Bu, "47 girilmemiş" sayacıyla aynı hata:
iş yapılmış, kayıt güncellenmemiş. Bir kaydı "engelli" diye okumadan önce
`pdf-ocr/` altına bak.

**TARAMA ENGELİ ARTIK ENGEL DEĞİL.** Makinede `tesseract 5.5.3` ve `tur` dil
paketi var; on iki dosyanın hepsi okunuyor. Çalışan tarif `pdftoppm -r 300
-png` + `tesseract -l tur` (PSM VERME — `--psm 6` puan sütununu yok ediyor);
ters basılmış sayfalar için `sips -r 180`. `ocrmypdf` bu makinede kırık
(`No module named expat`). Ayrıntı ve doğrulanmış örnekler
`GIRILEMEYEN-YONERGELER.md`'nin "Okuma engeli çözüldü" başlığında.

**KUYRUKTA OKUNAMAYAN DA GİRİLMEMİŞ DE DOSYA KALMADI.** Dışarıdan belge
beklemeden yapılacak iş bitti. Sayım dosya
adlarını veri dosyalarındaki kaynak atıflarıyla eşleyerek yapıldı; "47
girilmemiş" satırı uzun süre bayat kalmıştı, son beş üniversite (Çağ,
İstanbul Arel, İstanbul Gedik, İzmir Kavram MYO, İstanbul Atlas) o yüzden
gözden kaçmıştı. **Sayımı bir daha yaparken dosya adı eşlemesine güvenme:**
girilmiş on üç üniversitenin docblock'u kaynak PDF'i adıyla anmıyor, salt
`grep` bunları "açık" gösteriyor. Doğru yordam, adayı `yonerge/` dosya adıyla
da çapraz kontrol etmek.

**Yeni bir PDF eklenirse** listeye alınmadan önce `universiteler.php`'ye de
yazılmalı: son beşinin hiçbiri listede yoktu ve eşikleri hesaplansa bile
adaya görünmezdi. Vakıf meslek yüksekokulları da listeye giriyor (Ataşehir
Adıgüzel ve İzmir Kavram örnekleri).

**Puan tablosu eksikse önce GÖVDEYİ oku.** Çizelgesi PDF'te bulunmayan bir
yönerge otomatik olarak "girilemez" değil: SANKO'nun gövdesi doktor öğretim
üyeliği için makale sayısını ve yabancı dil puanını kendi maddelerinde veriyor,
yalnızca toplam puan barajı çizelgeye bağlı. Balıkesir, Türk Hava Kurumu ve
Maltepe'de ölçüt metni de çizelgeye devrediyordu — fark bu. Gövde sayı
veriyorsa kısmen gir, çizelgeye dayanan koşulu `Kalip::hesaplanamiyor` ile
işaretle ve eksik belgeyi `GIRILEMEYEN-YONERGELER.md`'ye yaz.

**Kendi puan tablosu olmayanlar hızlı şerit**: cetvel çıkarma adımı düşer,
yalnızca koşullar girilir (ÜAK cetveline bağlananlar `uak-2024-mart-{alan}`
kullanır). Bu şeridin İKİ TÜRÜ var: puanlamayı ÜAK'a devredenler ve kendi
kategori taksonomisi olup PUANI OLMAYANLAR. İkincisi yine bir cetvel ister ama
puansızını — `{slug}-turler.php` (Samsun, İzmir Demokrasi, Bursa Uludağ,
Kadir Has). `puan` anahtarı hiç yazılmaz; koşullar `Kalip::adet` ile kurulur,
`Kalip::toplam` hiç kullanılmaz. Bu şeridin girilenleri: İskenderun Teknik, Boğaziçi, Galatasaray,
İstanbul Medipol, İstanbul Galata, İstanbul Topkapı, Bezmiâlem, İstanbul
Ticaret, TED, Atılım. Bekleyenler `GIRILEMEYEN-YONERGELER.md`'de.

Kalanların çoğu kendi puan tablosunu taşıyor; her biri cetvel çıkarma +
koşul girme adımını birlikte istiyor.

**Trakya Üniversitesi girildi** (`cetvel/trakya-2025.php`, yedi cetvel;
`yonerge/trakya.php`, 56 kayıt / 108 eşik). Tek dosyada yedi varyant tutmanın
işe yarayan biçimi: ORTAK BLOK ÜRETİCİLERİ. Atıf, tez danışmanlığı, bildiri,
eğitim-öğretim, patent, idari görev, toplumsal katkı ve jüri satırları yedi
ekte de aynı; her biri madde numarasını parametre alan bir closure
(`$atifBlok('4')`, `$atifBlok('5')`) ve `array_merge` ile üretiliyor. Yalnız
makale, kitap, ödül ve editörlük blokları ek başına elle yazıldı. EK-1 ile
EK-3'ün tabloları satır satır aynı çıktığı için tek `$ek1` dizisi iki cetvele
birden veriliyor — yazar çarpanları farklı olduğu için ayrı cetvel olarak
kaldılar.

Grup listeleri de elle değil iki yardımcıyla kuruldu: `$bolum($maddeler, '1',
'2')` kodun başındaki madde numarasına bakıyor (`preg_match('/^(\d+)/')`, yani
`11a-f` → 11, `1a-Q1` → 1) ve `$onek($maddeler, '1a-', '1b')` önek eşliyor.
Salt önekle çalışmak Kırşehir Ahi Evran ile FSMVÜ'de sessiz hatalar üretmişti;
madde numarası üzerinden eşleşen `$bolum` o sınıf hatayı baştan kapatıyor.

Bu üniversitede §0 uyarınca verilen kararların tamamı `GIRILEMEYEN-YONERGELER.md`
tablosunda; en pahalıları: %25 tavanlarının atama eşiğine bağlı olduğu için
uygulanamaması, Matematik alanının EK-2'den ayrılamaması ve EK-7'nin sportif
performans bölümünün tamamen dışarıda kalması.
