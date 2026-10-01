<?php

namespace App\Enums;

/**
 * YZ'nin raporu yazarken taktığı şapka.
 *
 * Şapka yalnızca üslubu değiştirir, ÖLÇÜMÜ değiştirmez: puanlar ve koşul
 * sonuçları şart ağacı motorundan gelir, dört şapkada da aynıdır. Aksi hâlde
 * aday "sert jüri" seçince puanı düşmüş sanırdı.
 */
enum JuriSapkasi: string
{
    case UakUzmani = 'uak_uzmani';
    case AtamaKomisyonu = 'atama_komisyonu';
    case SertJuri = 'sert_juri';
    case Mentor = 'mentor';

    public function etiket(): string
    {
        return match ($this) {
            self::UakUzmani => 'ÜAK Uzmanı',
            self::AtamaKomisyonu => 'Atama Komisyonu',
            self::SertJuri => 'Sert Jüri',
            self::Mentor => 'Mentör Jürisi',
        };
    }

    public function ikon(): string
    {
        return match ($this) {
            self::UakUzmani => 'academic-cap',
            self::AtamaKomisyonu => 'building-library',
            self::SertJuri => 'exclamation-triangle',
            self::Mentor => 'star',
        };
    }

    /**
     * Rozet rengi (CSS değişkeni) — kart seçiliyken ve raporun başlığında.
     */
    public function renk(): string
    {
        return match ($this) {
            self::UakUzmani => 'var(--color-cat-purple)',
            self::AtamaKomisyonu => 'var(--color-navy)',
            self::SertJuri => 'var(--color-cat-red)',
            self::Mentor => 'var(--color-gold)',
        };
    }

    /**
     * Sistem promptuna giren kimlik tanımı.
     */
    public function persona(): string
    {
        return match ($this) {
            self::UakUzmani => 'Sen ÜAK doçentlik jürilerinde yıllardır görev yapan bir asıl '
                .'jüri üyesisin. Asgari şartların lafzını ve ÜAK uygulamasını ezbere bilirsin; '
                .'dosyayı madde madde, kuralın kendisine dayanarak okursun.',
            self::AtamaKomisyonu => 'Sen bir üniversitenin akademik atama ve yükseltme '
                .'komisyonunun deneyimli üyesisin. Kadro için başvuran adayı yalnız ÜAK asgari '
                .'şartlarıyla değil, kurumun kendi yönergesindeki eşiklerle ve kadronun '
                .'ihtiyacıyla birlikte değerlendirirsin.',
            self::SertJuri => 'Sen dosyayı en katı okuyan jüri üyesisin. Her satırda adayın '
                .'lehine yorum yapmayı reddeder, zayıf noktaları çekinmeden söylersin. '
                .'Kabalık etmeden ama hiçbir eksiği yumuşatmadan yazarsın.',
            self::Mentor => 'Sen adayın yanında duran, aynı zamanda jüri deneyimi olan bir '
                .'kıdemli meslektaşsın. Eksikleri saklamazsın ama her eksiği nasıl '
                .'kapatacağını da gösterirsin; üslubun cesaret verici.',
        };
    }
}
