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
                'SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)',
                'AHCI', 'ESCI / Scopus', 'TR Dizin',
                'Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli',
            ],
            self::Bildiri => [
                'Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin',
                'Uluslararası Özet/Poster', 'Ulusal Tam Metin', 'Ulusal Özet/Poster',
                'Davetli Konuşmacı',
            ],
            self::Kitap => [
                'BKCI / Scopus Kitap', 'Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)',
                'BKCI / Scopus Kitap Bölümü', 'Kitap Bölümü',
                'Ansiklopedi Maddesi', 'Çeviri Kitap', 'Çeviri Kitap Bölümü',
            ],
            self::TezYayini => [
                'SCIE/SSCI/AHCI', 'ESCI / Scopus', 'TR Dizin',
                'BKCI / Scopus Kitap', 'BKCI / Scopus Kitap Bölümü',
                'Uluslararası/Ulusal Kitap', 'Kitap Bölümü',
                'CPCI Bildiri', 'Diğer',
            ],
            self::Atif => ['WoS / Scopus', 'BKCI Kitap', 'TR Dizin', 'Patent', 'Diğer'],
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
            self::EgitimOgretim => [
                'Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders',
                'Değişim Programı Dersi', 'Akreditasyon Faaliyeti',
            ],
            // Editörlükte ÇEYREKLİK ayrımı var: Afyon 7.1 aynı işi Q1'de 100,
            // Q4'te 60 puanlıyor. Tek "WoS / Scopus Dergi" etiketiyle bu
            // kademe ifade edilemiyordu. Çeyreklik gözetmeyen yönergeler
            // dördünü birden listeler (makale tarafındaki desenin aynısı).
            self::Editorluk => [
                'WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)',
                'ESCI / Scopus Dergi', 'TR Dizin Dergi', 'Diğer Hakemli Dergi',
                'BKCI Kitap', 'Kitap Editörlüğü',
                'Yayın Kurulu Üyeliği', 'Hakemlik',
            ],
            self::SanatselEtkinlik => [
                'Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Ulusal)',
                'Karma/Jürili Etkinlik (Uluslararası)', 'Karma/Jürili Etkinlik (Ulusal)',
                'Özgün Eser / Beste / Tasarım', 'Albüm / Konser Kaydı',
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
            self::IdariGorev => [
                'Rektör', 'Rektör Yardımcısı',
                'Senato / Üniversite Yönetim Kurulu Üyesi',
                'Dekan / Enstitü-YO Müdürü', 'Dekan Yrd. / Müdür Yrd.',
                'Uygulama ve Araştırma Merkezi Müdürü',
                'Bölüm Başkanı', 'Bölüm Başkan Yardımcısı',
                'Anabilim Dalı Başkanı / Koordinatörlük', 'Kurul / Komisyon Üyeliği',
            ],
            self::ToplumsalKatki => [
                'Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın',
                'Kamu/STK Danışmanlığı',
            ],
            self::Diger => ['Diğer'],
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
            self::Makale, self::Bildiri, self::Kitap, self::TezYayini, self::SanatselEtkinlik => [
                'tek' => 'Tek yazar',
                'ilk' => 'İlk yazar',
                'baslica' => 'Başlıca / sorumlu yazar',
                'ortak' => 'Ortak yazar',
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
