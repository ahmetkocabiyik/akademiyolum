<?php

namespace App\Enums;

/**
 * Akademik faaliyet kategorileri.
 *
 * Küme, 167 yönergelik korpusta bölüm başlığı olarak geçme sıklığına göre
 * belirlendi (yönergelerin yüzdesi):
 *   Makale 97 · Kitap 96 · Atıf 93 · Proje 93 · Bildiri 92 · Editörlük 89
 *   Ödül 88 · Patent 87 · Sanatsal 83 · Eğitim-öğretim 82 · Tez danışmanlığı 75
 *   İdari görev 47 · Toplumsal katkı 20
 *
 * Ansiklopedi maddesi (%53) ve çeviri (%42) neredeyse her yönergede KİTAP
 * bölümünün alt bendi olduğu için ayrı kategori değil, {@see self::kaynaklar()}
 * içinde alt tür olarak duruyor.
 */
enum Kategori: string
{
    case Makale = 'makale';
    case Bildiri = 'bildiri';
    case Kitap = 'kitap';
    case TezYayini = 'tez_yayini';
    case Atif = 'atif';
    case Proje = 'proje';
    case Patent = 'patent';
    case TezDanismanligi = 'tez_danismanligi';
    case EgitimOgretim = 'egitim_ogretim';
    case Editorluk = 'editorluk';
    case SanatselEtkinlik = 'sanatsal_etkinlik';
    case Odul = 'odul';
    case IdariGorev = 'idari_gorev';
    case ToplumsalKatki = 'toplumsal_katki';
    case Diger = 'diger';

    /**
     * Human-readable Turkish label.
     */
    public function label(): string
    {
        return match ($this) {
            self::Makale => 'Makale',
            self::Bildiri => 'Bildiri',
            self::Kitap => 'Kitap',
            self::TezYayini => 'Tezden Üretilmiş Yayın',
            self::Atif => 'Atıf',
            self::Proje => 'Proje',
            self::Patent => 'Patent / Tasarım',
            self::TezDanismanligi => 'Tez Danışmanlığı',
            self::EgitimOgretim => 'Eğitim-Öğretim',
            self::Editorluk => 'Editörlük / Hakemlik',
            self::SanatselEtkinlik => 'Sanatsal Etkinlik',
            self::Odul => 'Ödül / Burs',
            self::IdariGorev => 'İdari Görev',
            self::ToplumsalKatki => 'Toplumsal Katkı',
            self::Diger => 'Diğer Etkinlik',
        };
    }

    /**
     * Heroicon name used across the dashboard.
     */
    public function ikon(): string
    {
        return match ($this) {
            self::Makale => 'document-text',
            self::Bildiri => 'megaphone',
            self::Kitap => 'book-open',
            self::TezYayini => 'pencil-square',
            self::Atif => 'link',
            self::Proje => 'beaker',
            self::Patent => 'light-bulb',
            self::TezDanismanligi => 'user-group',
            self::EgitimOgretim => 'academic-cap',
            self::Editorluk => 'scissors',
            self::SanatselEtkinlik => 'paint-brush',
            self::Odul => 'trophy',
            self::IdariGorev => 'briefcase',
            self::ToplumsalKatki => 'heart',
            self::Diger => 'star',
        };
    }

    /**
     * Brand colour key used for badges/bars (maps to CSS tokens).
     */
    public function renk(): string
    {
        return match ($this) {
            self::Makale => 'brand',
            self::Bildiri => 'cat-teal',
            self::Kitap => 'cat-purple',
            self::TezYayini => 'gold',
            self::Atif => 'cat-teal',
            self::Proje => 'cat-green',
            self::Patent => 'cat-amber',
            self::TezDanismanligi => 'cat-purple',
            self::EgitimOgretim => 'cat-green',
            self::Editorluk => 'cat-amber',
            self::SanatselEtkinlik => 'cat-red',
            self::Odul => 'gold',
            self::IdariGorev => 'cat-gray',
            self::ToplumsalKatki => 'cat-red',
            self::Diger => 'ink-subtle',
        };
    }

    /**
     * Cetvel satırlarında yaşayan ama ADAYA SORULMAYAN etiketler.
     *
     * Kaynakların bir kısmı kitabı, çeviriyi, editörlüğü ve daveti
     * uluslararası/ulusal diye ayırıyor, bir kısmı ayırmıyor. Ayırmayan
     * kaynağın satırı GENEL etiketi listeler ve iki kaydı da karşılar
     * ({@see MaddeKatalogu::kaynakEsler()}). Aday ise her zaman kapsamlı
     * olanı seçer — "Kitap Bölümü" diye sorulsa ayrım hiç toplanmazdı.
     *
     * Liste KATEGORİ BAŞINA: `Diğer` etiketi `atif` ve `tez_yayini`'nde
     * kapsam çiftine kavuştu ama `diger` kategorisinde ("Diğer Etkinlik")
     * kapsam ayrımı anlamsız ve orada adayın seçebileceği TEK etiket o.
     *
     * @var array<string, list<string>>
     */
    /**
     * Genel etiketin ADAYA SORULMAYA DEVAM ETTİĞİ hâller.
     *
     * Kapsamlı etiketlerin çoğu genel olanın YERİNE geçiyor: "Kitap Bölümü"
     * artık sorulmaz, aday uluslararası ya da ulusal olanı seçer. Ama dilim
     * ekseninde durum başka — "ilk %10'luk dilim" Q1'in ALT KÜMESİ. Q1'de
     * olup ilk %10'a girmeyen dergi de var ve adayın onu seçebilmesi gerek.
     *
     * @var list<string>
     */
    public const DARALTILABILIR_KAYNAKLAR = [
        'SCIE/SSCI (Q1)', 'SCIE/SSCI (İlk %10)', 'Scopus (Q1)',
    ];

    public const GENEL_KAYNAKLAR = [
        'kitap' => [
            'Uluslararası/Ulusal Kitap', 'Kitap Bölümü', 'Çeviri Kitap',
            'Çeviri Kitap Bölümü', 'Ders / Metot Kitabı',
        ],
        // `SCIE/SSCI (Q1)` ile `Scopus (Q1)` HÂLÂ adaya sorulur: ilk %10'luk
        // dilim Q1'in ALT KÜMESİ, Q1'in kendisi değil.
        'makale' => ['ESCI / Scopus', 'Scopus'],
        'bildiri' => ['Davetli Konuşmacı'],
        'editorluk' => ['Kitap Editörlüğü', 'Diğer Hakemli Dergi', 'ESCI / Scopus Dergi'],
        'atif' => ['WoS / Scopus', 'ESCI / Scopus', 'Scopus', 'Patent', 'Diğer'],
        'tez_yayini' => ['Uluslararası/Ulusal Kitap', 'Kitap Bölümü', 'Diğer', 'ESCI / Scopus', 'Scopus'],
    ];

    /**
     * Adayın faaliyet girerken seçebileceği kaynaklar.
     *
     * @return list<string>
     */
    public function adayKaynaklari(): array
    {
        return array_values(array_filter(
            $this->kaynaklar(),
            fn (string $kaynak) => ! in_array($kaynak, self::GENEL_KAYNAKLAR[$this->value] ?? [], true),
        ));
    }

    /**
     * Bu kategorinin alt türleri — puan cetvellerinin anahtarı ve formdaki
     * seçenek listesi. Yönergeler puanı daima bu ayrıma göre veriyor
     * (ör. proje: fon kaynağına göre; tez danışmanlığı: tez düzeyine göre).
     *
     * @return list<string>
     */
    public function kaynaklar(): array
    {
        return match ($this) {
            self::Makale => [
                'SCIE/SSCI (İlk %5)', 'SCIE/SSCI (İlk %10)',
                'SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)',
                'AHCI', 'ESCI',
                'Scopus (İlk %10)',
                'Scopus (Q1)', 'Scopus (Q2)', 'Scopus (Q3)', 'Scopus (Q4)', 'Scopus',
                'ESCI / Scopus', 'TR Dizin',
                'Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli',
            ],
            self::Bildiri => [
                'Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin',
                'Uluslararası Özet/Poster', 'Ulusal Tam Metin', 'Ulusal Özet/Poster',
                'Davetli Konuşmacı (Uluslararası)', 'Davetli Konuşmacı (Ulusal)',
                'Davetli Konuşmacı',
            ],
            self::Kitap => [
                'BKCI / Scopus Kitap',
                'Uluslararası Kitap', 'Ulusal Kitap', 'Uluslararası/Ulusal Kitap',
                'Tahkik (Tenkitli Metin)',
                'BKCI / Scopus Kitap Bölümü',
                'Uluslararası Kitap Bölümü', 'Ulusal Kitap Bölümü', 'Kitap Bölümü',
                'Ansiklopedi Maddesi',
                'Uluslararası Çeviri Kitap', 'Ulusal Çeviri Kitap', 'Çeviri Kitap',
                'Uluslararası Çeviri Kitap Bölümü', 'Ulusal Çeviri Kitap Bölümü',
                'Çeviri Kitap Bölümü',
                // Ege 3(ı)/3(i) ve 10.4(k,l), Gazi K1c: ders ve metot kitapları
                // ayrı puanlı ve güzel sanatlar koşullarında ADIYLA anılıyor.
                'Uluslararası Ders / Metot Kitabı', 'Ulusal Ders / Metot Kitabı',
                'Ders / Metot Kitabı',
            ],
            self::TezYayini => [
                'SCIE/SSCI/AHCI', 'ESCI',
                'Scopus (İlk %10)',
                'Scopus (Q1)', 'Scopus (Q2)', 'Scopus (Q3)', 'Scopus (Q4)', 'Scopus',
                'ESCI / Scopus', 'TR Dizin',
                'BKCI / Scopus Kitap', 'BKCI / Scopus Kitap Bölümü',
                'Uluslararası Kitap', 'Ulusal Kitap', 'Uluslararası/Ulusal Kitap',
                'Uluslararası Kitap Bölümü', 'Ulusal Kitap Bölümü', 'Kitap Bölümü',
                'CPCI Bildiri',
                'Diğer (Uluslararası)', 'Diğer (Ulusal)', 'Diğer',
            ],
            self::Atif => [
                // Kaynakların bir kısmı atıfta çekirdek indeksle ESCI'yi ayrı
                // puanlıyor (Cerrahpaşa A/11: SCIE-SSCI-AHCI 10, ESCI 7);
                // `WoS / Scopus` ikisini birden karşılayan GENEL etiket.
                'SCIE/SSCI/AHCI', 'ESCI',
                'Scopus (Q1)', 'Scopus (Q2)', 'Scopus (Q3)', 'Scopus (Q4)', 'Scopus',
                'ESCI / Scopus', 'WoS / Scopus',
                'BKCI Kitap', 'TR Dizin',
                'Patent (Uluslararası)', 'Patent (Ulusal)', 'Patent',
                'Diğer (Uluslararası)', 'Diğer (Ulusal)', 'Diğer',
            ],
            self::Proje => [
                'AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon', 'TÜBİTAK', 'TÜSEB',
                'Diğer Kamu Kurumu', 'Özel Sektör / STK', 'BAP (Üniversite)',
                'Öğrenci Projesi (2209 vb.)',
            ],
            self::Patent => [
                'Uluslararası Patent', 'Ulusal Patent', 'Faydalı Model',
                'Endüstriyel Tasarım', 'Yazılım', 'Islahçı Hakkı / Çeşit Tescili',
                'Ticarileştirme',
            ],
            self::TezDanismanligi => [
                'Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi', 'Yüksek Lisans Tezi',
                'Tez İzleme / Jüri Üyeliği',
            ],
            // `Akreditasyon Faaliyeti` bu kategorinin ders DIŞI etiketi:
            // eğitici eğitimi belgesi, ölçme-değerlendirme belgesi, eğitim
            // öğretim danışmanlığı. Akdeniz 8.2 bunlardan çok daha ağır bir
            // kalemi (YÖKAK kurumsal akreditasyon KURULUNDA görev, 30 x yıl)
            // aynı ailede sayıyor; tek etikete toplansaydı §0 uyarınca en
            // düşük kademe (belge, 5 puan) yazılmak zorunda kalınırdı.
            self::EgitimOgretim => [
                'Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders',
                'Değişim Programı Dersi', 'Akreditasyon Kurulu Görevi',
                'Akreditasyon Faaliyeti',
            ],
            // Editörlükte ÇEYREKLİK ayrımı var: Afyon 7.1 aynı işi Q1'de 100,
            // Q4'te 60 puanlıyor. Tek "WoS / Scopus Dergi" etiketiyle bu
            // kademe ifade edilemiyordu. Çeyreklik gözetmeyen yönergeler
            // dördünü birden listeler (makale tarafındaki desenin aynısı).
            self::Editorluk => [
                'WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)',
                'ESCI Dergi', 'Scopus Dergi', 'ESCI / Scopus Dergi', 'TR Dizin Dergi', 'Diğer Hakemli Dergi',
                'BKCI Kitap',
                'Uluslararası Kitap Editörlüğü', 'Ulusal Kitap Editörlüğü', 'Kitap Editörlüğü',
                'Diğer Hakemli Dergi (Uluslararası)', 'Diğer Hakemli Dergi (Ulusal)',
                'Yayın Kurulu Üyeliği', 'Hakemlik',
            ],
            self::SanatselEtkinlik => [
                'Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Ulusal)',
                'Karma/Jürili Etkinlik (Uluslararası)', 'Karma/Jürili Etkinlik (Ulusal)',
                'Özgün Eser / Beste / Tasarım', 'Albüm / Konser Kaydı',
                // Ankara 3. bölümün sahne/ekran ve uygulama kalemleri. Mersin
                // ile Gümüşhane bunları hiç puanlamıyor; ortak çekirdeğe değil
                // bu üniversitenin gerektirdiği ayrıma karşılık geliyorlar.
                'Orkestra / Koro Üyeliği',
                'Karma Albüm / CD-DVD Katkısı',
                'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)',
                'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)',
                'Dansçı / Performans İcracısı (Uluslararası)',
                'Dansçı / Performans İcracısı (Ulusal)',
                'Koreografi',
                'Yönetmenlik (Sahne/Ekran)',
                'Sahne Tasarımı (Dekor, Kostüm, Işık)',
                'Koruma-Onarım Uygulaması (Uluslararası)',
                'Koruma-Onarım Uygulaması (Ulusal)',
                'Eserin Yayında Yer Alması / Satın Alınması',
                // Mersin TABLO B'nin ayrı puanladığı kalemler. Her biri farklı
                // puan aldığı için tek etikete toplanamıyor.
                'Eserin Satın Alınması (Yurt İçi)',
                'Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip',
                'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman',
                'Karma Etkinlik (Jürisiz, Ulusal)',
                // Gümüşhane EK-1 P bölümü yer × jüri düzeyi × kişisel/karma
                // ekseninde daha ince ayırıyor.
                'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)',
                'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)',
                'Kişisel Etkinlik (Yurt Dışı, Jürisiz)',
                'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)',
                'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)',
                'Karma Etkinlik (Yurt Dışı, Jürisiz)',
                'Kişisel Etkinlik (Yurt İçi, Jürisiz)',
                'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)',
                'Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)',
                'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)',
                'Belgesel/Kısa Film (Uluslararası)', 'Belgesel/Kısa Film (Ulusal)',
                'Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Müzeye Kabulü (Yurt İçi)',
                'Eserin Haber Olması (Uluslararası)', 'Eserin Haber Olması (Ulusal)',
                'Elektronik Kişisel Sergi (Uluslararası)', 'Elektronik Kişisel Sergi (Ulusal)',
                'Elektronik Karma Sergi (Uluslararası)', 'Elektronik Karma Sergi (Ulusal)',
                // Mersin TABLO C — konservatuvar (müzik, sahne sanatları, müzikoloji).
                'Solistlik (Uluslararası)', 'Solistlik (Ulusal)', 'Resital (Uluslararası)',
                'Resital (Ulusal)', 'Oda Müziği Grup Üyeliği (Uluslararası)',
                'Oda Müziği Grup Üyeliği (Ulusal)', 'Başkemancılık (Uluslararası)',
                'Başkemancılık (Ulusal)', 'Grup Şefliği (Uluslararası)', 'Grup Şefliği (Ulusal)',
                'Bandrollü Kayıt (CD/DVD)', 'Masterclass (Uluslararası)', 'Masterclass (Ulusal)',
                'Eğitim Amaçlı Sanat Etkinliği', 'Opera/Bale Kompozisyonu',
                'Orkestralı Sahne Eseri', 'Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir',
                'Küçük Ölçekli Orkestra Eseri', 'Oda/Koro Müziği Eseri (≥15 dk)',
                'Oda/Koro Müziği Eseri (<15 dk)', 'Elektronik Müzik Eseri (≥15 dk)',
                'Elektronik Müzik Eseri (<15 dk)', 'Sahne/Ekran Müziği', 'Eğitim Müziği Albümü',
                'Orkestrasyon/Transkripsiyon', 'Eğitim Müziği Düzenlemesi',
                'Opera Şefliği (Uluslararası)', 'Opera Şefliği (Ulusal)',
                'Orkestra Şefliği (Uluslararası)', 'Orkestra Şefliği (Ulusal)',
                'Bale Orkestra Şefliği (Uluslararası)', 'Bale Orkestra Şefliği (Ulusal)',
                'Koro Şefliği (Uluslararası)', 'Koro Şefliği (Ulusal)',
                'Opera Birinci Rol (Uluslararası)', 'Opera Birinci Rol (Ulusal)',
                'Şan Resitali (Uluslararası)', 'Şan Resitali (Ulusal)',
                'Opera İkinci Rol (Uluslararası)', 'Opera İkinci Rol (Ulusal)',
                'Oratoryo/Kantat Solistliği (Uluslararası)',
                'Oratoryo/Kantat Solistliği (Ulusal)', 'Rejisörlük (Uluslararası)',
                'Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)',
                'Rejisör Yardımcılığı (Uluslararası)', 'Rejisör Yardımcılığı (Ulusal)',
                'Rejisör Yardımcılığı (Konservatuvar)', 'Bale Başrol (Uluslararası)',
                'Bale Başrol (Ulusal)', 'Bale Solist Rol (Uluslararası)',
                'Bale Solist Rol (Ulusal)', 'Corps de Ballet (Uluslararası)',
                'Corps de Ballet (Ulusal)', 'Tüm Perde Koreograflığı (Uluslararası)',
                'Tüm Perde Koreograflığı (Ulusal)', 'Bölüm Koreograflığı (Uluslararası)',
                'Bölüm Koreograflığı (Ulusal)', 'Bale/Dans Koreograflığı (Uluslararası)',
                'Bale/Dans Koreograflığı (Ulusal)',
                'Sahneleme/Repetitörlük — Tüm Perde (Uluslararası)',
                'Sahneleme/Repetitörlük — Tüm Perde (Ulusal)',
                'Sahneleme/Repetitörlük — Bölüm (Uluslararası)',
                'Sahneleme/Repetitörlük — Bölüm (Ulusal)', 'Müzikoloji Atölyesi',
                'Eğitici Konser Programı (Uluslararası)', 'Eğitici Konser Programı (Ulusal)',
                // Dokuz Eylül Puanlandırma Formunun D bölümü (24-35). Korpusta
                // ilk kez bir yönerge film, animasyon, TV ve müzik teknolojisi
                // yapımlarını ayrı ayrı puanlıyor; mevcut sahne/ekran etiketleri
                // bunları taşımıyordu. Grup sergisi karma sergiden ayrı satır
                // (10/8 ↔ 5/3), kamusal alan yapıtı da öyle (15/10).
                'Grup Etkinliği (Uluslararası)', 'Grup Etkinliği (Ulusal)',
                'Kamusal Alanda Uygulanmış Yapıt (Yurt Dışı)',
                'Kamusal Alanda Uygulanmış Yapıt (Yurt İçi)',
                'Uygulanmış Tasarım / Koleksiyon',
                'Müzik Teknolojisi Uygulaması',
                'Uzun Metrajlı Film / Belgesel (Uluslararası)',
                'Uzun Metrajlı Film / Belgesel (Ulusal)',
                'Animasyon / Canlandırma Yapımı',
                'TV Filmi / Dizisi (Uluslararası)', 'TV Filmi / Dizisi (Ulusal)',
                'TV Programı (Uluslararası)', 'TV Programı (Ulusal)',
                'Reklam / Tanıtım Filmi (Uluslararası)', 'Reklam / Tanıtım Filmi (Ulusal)',
                'Sergi Küratörlüğü (Uluslararası)', 'Sergi Küratörlüğü (Ulusal)',
                'Festival Koordinatörlüğü (Uluslararası)', 'Festival Koordinatörlüğü (Ulusal)',
            ],
            // Yönergeler belirli ödülleri ADIYLA ve ayrı puanla anıyor:
            // Atatürk 07.02.02 YÖK Doktora Tezi Ödülü 30, 07.02.04 GEBİP/TWAS
            // 30, 07.02.05 ERC 30; genel "TÜBİTAK/TÜBA ödülü" ise 40. Bunlar
            // tek etikete toplanırsa `puan()` en yükseği aldığı için her ödül
            // 40 sayılırdı.
            self::Odul => [
                'Uluslararası Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü',
                'TÜBA GEBİP / TWAS Teşvik Ödülü', 'Ufuk Avrupa / ERC Ödülü',
                'YÖK Ödülü', 'Ulusal Bilim/Sanat Ödülü',
                'Yarışma Derecesi / Mansiyon', 'Burs',
            ],
            // Yönergeler idari görevleri tek tek puanlıyor (Atatürk 00.01.01-12):
            // rektör ile rektör yardımcısı ayrı satır, ayrı puan. Birleşik
            // etiketler bu ayrımı taşıyamıyordu.
            // `Kurul / Komisyon Üyeliği` ÜNİVERSİTE İÇİ kurulları taşıyor.
            // Yönergelerin çoğu bunun yanında KURUM DIŞI görevleri de ayrı
            // ve çok farklı puanlarla sayıyor; tek etikete toplansalardı §0
            // uyarınca en düşük kademe yazılmak zorunda kalınır, ikisi
            // birden yok olurdu. Korpus taraması (06.09.2026) iki ayrı aile
            // gösterdi: bilimsel/mesleki kuruluş kurulları 22 kaynakta,
            // spor federasyonu kurulları 26 kaynakta. Puanları da bambaşka —
            // Bitlis Eren bilimsel kuruluş üyeliğine 8, Bartın olimpik spor
            // federasyonu yöneticiliğine 100 veriyor.
            self::IdariGorev => [
                'Rektör', 'Rektör Yardımcısı',
                'Dekan / Enstitü-YO Müdürü', 'Dekan Yrd. / Müdür Yrd.',
                'Uygulama ve Araştırma Merkezi Müdürü',
                'Bölüm Başkanı', 'Bölüm Başkan Yardımcısı',
                'Anabilim Dalı Başkanı / Koordinatörlük', 'Kurul / Komisyon Üyeliği',
                'Dış Kuruluş Kurul Üyeliği (Uluslararası)',
                'Dış Kuruluş Kurul Üyeliği (Ulusal)',
                'Spor Federasyonu Kurul Üyeliği (Uluslararası)',
                'Spor Federasyonu Kurul Üyeliği (Ulusal)',
            ],
            self::ToplumsalKatki => [
                'Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın',
                'Kamu/STK Danışmanlığı',
            ],
            // BİLİMSEL TOPLANTI ORGANİZASYONU (06.09.2026). Korpusun 85
            // kaynağı bu aileyi puanlıyor (551 satır) ve tamamı sözlükte
            // karşılıksızdı; girilebilen cetveller satırı `Diğer`e yazmış,
            // otuz kadarı bölümü hiç girmemişti. Rol kademeleri gerçek:
            // medyan başkanlık 10, kurul üyeliği 5-6, oturum başkanlığı 3 —
            // tek etikete toplansalardı §0 başkanlığı 3'e indirirdi.
            self::Diger => [
                'Toplantı Düzenleme Başkanlığı (Uluslararası)',
                'Toplantı Düzenleme Başkanlığı (Ulusal)',
                'Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)',
                'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)',
                'Oturum Başkanlığı (Uluslararası)',
                'Oturum Başkanlığı (Ulusal)',
                'Diğer',
            ],
        };
    }

    /**
     * Adayın bu kategorideki faaliyetteki rolü. Yayın türlerinde yazarlık,
     * projede görev, tez danışmanlığında danışmanlık türü.
     *
     * Boş dizi: bu kategoride rol ayrımı yok.
     *
     * @return array<string, string>
     */
    /**
     * Makalenin yayın türü.
     *
     * Yönergeler aynı dergideki iki çalışmayı türüne göre farklı puanlıyor:
     * Ege 1(a) Q1 özgün makale 75 puan, 1(b) Q1 derleme 60, 1(c) Q1 editöre
     * mektup 25. `kaynak` yalnızca dergiyi taşıdığı için bu ayrım oradan
     * okunamıyor; cetvel maddeleri `turler` ile sınırlanabiliyor.
     *
     * VARSAYILAN 'ozgun_makale' — hem formun ön seçimi hem de türü
     * girilmemiş kayıtların sayıldığı tür. Derleme veya editöre mektup
     * kaydeden adayın bunu açıkça seçmesi gerekir.
     *
     * @return array<string, string>
     */
    public function yayinTurleri(): array
    {
        return match ($this) {
            self::Makale, self::TezYayini => [
                'ozgun_makale' => 'Özgün araştırma makalesi',
                'derleme' => 'Derleme',
                'kisa_makale' => 'Kısa makale (short/brief communication)',
                'vaka_teknik_not' => 'Vaka sunumu, teknik not, editöre mektup',
            ],
            default => [],
        };
    }

    /**
     * Adayın bu kategorideki faaliyetteki rolü. Yayın türlerinde yazarlık,
     * projede görev, tez danışmanlığında danışmanlık düzeyi.
     *
     * @return array<string, string>
     */
    public function roller(): array
    {
        return match ($this) {
            // Bazı yönergeler (Kocaeli) çarpanı yalnızca yazar sayısına değil
            // adayın yayındaki SIRASINA göre de değiştiriyor. Sıra seçenekleri
            // bu yüzden ayrı ayrı duruyor; 'ortak' sırasını belirtmek
            // istemeyen aday için kalıyor ve daima en düşük çarpanı alıyor.
            self::Makale, self::Bildiri, self::Kitap, self::TezYayini, self::SanatselEtkinlik => [
                'tek' => 'Tek yazar',
                'ilk' => 'İlk yazar (1. sıra)',
                'baslica' => 'Başlıca / sorumlu yazar',
                'yazar_2' => '2. yazar',
                'yazar_3' => '3. yazar',
                'yazar_4' => '4. yazar',
                'yazar_5' => '5. yazar',
                'yazar_6' => '6. yazar veya sonrası',
                'ortak' => 'Ortak yazar (sıra belirtmiyorum)',
            ],
            self::Proje => [
                'yurutucu' => 'Yürütücü / koordinatör',
                'arastirmaci' => 'Araştırmacı',
                'danisman' => 'Danışman',
                'bursiyer' => 'Bursiyer',
            ],
            self::TezDanismanligi => [
                'danisman' => 'Danışman',
                'es_danisman' => 'Eş danışman',
            ],
            default => [],
        };
    }

    /**
     * Yayın sayılan kategoriler — yönergelerin "yayın" dediği küme.
     *
     * @return list<self>
     */
    public static function yayinlar(): array
    {
        return [self::Makale, self::Bildiri, self::Kitap, self::TezYayini];
    }

    /**
     * Faaliyet bir tezden üretilmiş olabilir mi?
     *
     * Yalnızca yayın türlerinde anlamlı: bir makale doktora tezinden üretilmiş
     * olabilir, bir tez danışmanlığı olamaz — orada tezin düzeyi zaten alt tür
     * alanında (Doktora Tezi / Yüksek Lisans Tezi) sorulmuştur.
     *
     * TezYayini hariç tutuldu: o kategorinin tanımı zaten "lisansüstü tezden
     * üretilmiş yayın", ayrıca sormak "tezden bağımsız" gibi çelişkili bir
     * seçenek üretirdi.
     */
    public function tezdenUretilebilir(): bool
    {
        return in_array($this, [self::Makale, self::Bildiri, self::Kitap], true);
    }

    /**
     * All cases as value => label, handy for select inputs.
     *
     * @return array<string, string>
     */
    public static function secenekler(): array
    {
        return array_reduce(
            self::cases(),
            fn (array $carry, self $kategori) => $carry + [$kategori->value => $kategori->label()],
            [],
        );
    }
}
