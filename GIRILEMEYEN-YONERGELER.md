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
