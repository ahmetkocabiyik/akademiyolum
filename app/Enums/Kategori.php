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
                'SCIE/SSCI/AHCI', 'BKCI / Scopus Kitap', 'ESCI / Scopus',
                'Kitap Bölümü', 'TR Dizin', 'CPCI Bildiri', 'Diğer',
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
            self::Editorluk => [
                'WoS / Scopus Dergi', 'TR Dizin Dergi', 'BKCI Kitap',
                'Yayın Kurulu Üyeliği', 'Hakemlik',
            ],
            self::SanatselEtkinlik => [
                'Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Ulusal)',
                'Karma/Jürili Etkinlik (Uluslararası)', 'Karma/Jürili Etkinlik (Ulusal)',
                'Özgün Eser / Beste / Tasarım', 'Albüm / Konser Kaydı',
                'Eserin Yayında Yer Alması / Satın Alınması',
            ],
            self::Odul => [
                'Uluslararası Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü',
                'Ulusal Bilim/Sanat Ödülü', 'Yarışma Derecesi / Mansiyon', 'Burs',
            ],
            self::IdariGorev => [
                'Rektör / Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü',
                'Dekan Yrd. / Müdür Yrd.', 'Bölüm Başkanı',
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
