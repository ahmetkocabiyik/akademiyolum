<?php

namespace App\Enums;

/**
 * Jüri raporunun on adımı — iskelet SABİT.
 *
 * Adımları YZ'nin kendi başlıklarıyla üretmesine izin verilse rapor her
 * çalıştırmada başka bir sırayla gelir, aday iki raporu karşılaştıramaz ve
 * ekran hangi adımın hangi kutuya gireceğini bilemez. YZ yalnızca her adımın
 * İÇERİĞİNİ ve ağırlığını yazar; başlık, sıra ve o adımda ne isteneceği
 * burada duruyor.
 */
enum JuriAdimi: string
{
    case Kriterler = 'kriterler';
    case Envanter = 'envanter';
    case Eslestirme = 'eslestirme';
    case PuanHesabi = 'puan_hesabi';
    case Bosluklar = 'bosluklar';
    case Elestiri = 'niteliksel_elestiri';
    case Plan = 'plan';
    case Senaryolar = 'senaryolar';
    case Riskler = 'riskler';
    case Karar = 'karar';

    public function baslik(): string
    {
        return match ($this) {
            self::Kriterler => 'Kriterleri Parçala',
            self::Envanter => 'Akademik Profili Sınıflandır',
            self::Eslestirme => 'Kriter — Profil Eşleştirmesi',
            self::PuanHesabi => 'Puan Hesabı',
            self::Bosluklar => 'Derin Boşluk Analizi',
            self::Elestiri => 'Jüri Gözüyle Niteliksel Eleştiri',
            self::Plan => 'Stratejik Tamamlama Planı',
            self::Senaryolar => 'Senaryo Analizi',
            self::Riskler => 'Risk Analizi',
            self::Karar => 'Net Karar',
        };
    }

    public function altBaslik(): string
    {
        return match ($this) {
            self::Kriterler => 'Aşılması gereken duvarlar',
            self::Envanter => 'Dosyadaki cephane, niteliğine göre',
            self::Eslestirme => 'Elinizdeki verinin yönergedeki net karşılığı',
            self::PuanHesabi => 'Jüri masasında hesap makinesi yalan söylemez',
            self::Bosluklar => 'Hangi koşul neden açık kalıyor',
            self::Elestiri => 'Sayıların ötesinde: dosyanın anlattığı akademik kimlik',
            self::Plan => 'Eksikleri kapatmanın en kısa yolu',
            self::Senaryolar => 'Bugün başvurursanız, bir yıl sonra, üç yıl sonra',
            self::Riskler => 'Zaman, nitelik ve yayın mecrası riskleri',
            self::Karar => 'Dosyayı kapatmadan önce son söz',
        };
    }

    /**
     * YZ'den o adımda tam olarak ne istendiği (prompta madde madde girer).
     */
    public function istem(): string
    {
        return match ($this) {
            self::Kriterler => 'Hedef yönergenin adaydan istediği koşulları kendi '
                .'cümlelerinle grupla ve hangisinin gerçek eşik olduğunu söyle.',
            self::Envanter => 'Adayın faaliyetlerini türüne, dönemine (doktora öncesi/sonrası) '
                .'ve niteliğine göre sınıflandır. Markdown tablosu kullan.',
            self::Eslestirme => 'Her koşulun karşısına adayın o koşulu hangi faaliyetle '
                .'karşıladığını ya da neden karşılamadığını yaz. Markdown tablosu kullan.',
            self::PuanHesabi => 'ÖLÇÜM bölümündeki sayıları yorumla: hangi koşul hangi oranda '
                .'dolu, açık nereden kapanır. Yeni sayı UYDURMA, verilenleri kullan.',
            self::Bosluklar => 'Karşılanmayan ve karara bağlanamayan koşulları tek tek ele al; '
                .'her biri için açığın büyüklüğünü ve sebebini yaz.',
            self::Elestiri => 'Jüri üyesi olarak dosyanın bütününe dair niteliksel '
                .'değerlendirmeni yaz: bağımsız akademisyen kimliği, yayın mecralarının '
                .'niteliği, alandaki görünürlük. Bu adım sayı değil yorum içerir.',
            self::Plan => 'Eksikleri kapatacak sıralı eylem planı yaz. Her adımda ne '
                .'yapılacağını ve hangi koşulu kapattığını söyle.',
            self::Senaryolar => 'En az üç senaryo yaz: bugünkü dosyayla başvuru, kısmi '
                .'tamamlama, tam tamamlama. Her senaryonun sonucunu açıkça söyle.',
            self::Riskler => 'Adayın planını tehdit eden riskleri yaz: yayın süreçlerinin '
                .'süresi, şaibeli dergi/yayınevi tuzağı, asgari şartı sağlamakla jüriden '
                .'geçmek arasındaki fark.',
            self::Karar => 'KARAR bölümünde verilen kararı gerekçelendir. Kararı DEĞİŞTİRME, '
                .'adaya jüri üyesi olarak son sözünü söyle.',
        };
    }
}
