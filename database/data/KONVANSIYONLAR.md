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

### İKİ YOLLU DİPNOTTA KOLLARIN DÜŞÜĞÜNÜ YAZ

Dipnotlar sık sık "şu şartı sağlayamayan aday şunu yapar" biçiminde bir
telafi kolu taşıyor. İki kol farklı sayı istiyorsa (Ordu'da Sosyal
tablosunda birinci kol üç, telafi kolu bir tek yazarlı yayın) motorda tek
sayı yazılabiliyorsa **DÜŞÜK olanı** yaz: yüksek olanı yazmak telafi
yolundan gidebilecek adayı haksız yere eler. §0 puanı aşağı çeker, ama
adaya sağlayabileceği bir yolu da kapatmaz.

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
atasını da bu tabloya yaz.

**Her dar etiketin atası YOKTUR.** Sergi küratörlüğü ve festival
koordinatörlüğü tabloya alınmadı: sergi DÜZENLEMEK, karma sergiye eserle
KATILMAKTAN başka bir iş; genel etikete bağlamak hak edilmeyen puan verirdi.
Ata ancak yeni etiket eskisinin gerçekten bir ALT TÜRÜYSE yazılır.

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
| Girildi | 175 üniversite · 6637 eşik · 329 cetvel |
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
