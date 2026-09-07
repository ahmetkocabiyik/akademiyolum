<?php

/**
 * İSTANBUL RUMELİ ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma
 * Yönergesi
 * Kaynak: pdf/17537100672.istanbulrumeliuniversitesi.pdf
 *
 * YÖNERGEDE TARİH YOK. MADDE 19 yürürlüğü YÖK onayına bağlıyor ama tarihi
 * yazmıyor; belgede kabul tarihi ya da karar numarası da geçmiyor. Cetvel
 * dosyasının adındaki 2024, PDF'in oluşturma tarihinden (11/07/2024).
 *
 * ── KORPUSUN EN SADE İKİNCİ YAPISI, AMA TEK BİR ÖZELLİKLE AYRILIYOR ──
 * Alan ayrımı yok, birim ayrımı yok, yayın sayısı koşulu neredeyse yok:
 *
 *   Dr. Öğr. Üyesi   PUAN KOŞULU YOK — yalnızca doktora/uzmanlık/sanatta
 *                    yeterlik unvanı (MADDE 6)
 *   Doçent           ÜAK unvanı + tablodan toplam 100 puan (MADDE 10)
 *   Profesör         doçentlik sonrası 1 yayın + doçentlik sonrası 120 puan,
 *                    üstüne 5 yıl doçentlik kıdemi (MADDE 13)
 *
 * DR. ÖĞR. ÜYELİĞİNDE SAYISAL KOŞUL BULUNMAMASI VERİ EKSİĞİ DEĞİL: MADDE 6
 * tek fıkra ve yalnızca unvan istiyor; tablo (Ek 1) MADDE 10 ve 13'te
 * anılıyor, MADDE 6'da anılmıyor. Eşik yine de yazıldı ki aday üniversiteyi
 * kapsam dışı sanmasın ve barajın gerçekten olmadığını görsün.
 *
 * ── BARAJA SAYILAN PUAN TABLONUN TAMAMI DEĞİL ──
 * Bu yönergeyi korpustaki ötekilerden ayıran şey burada: Ek 1'in ara
 * değerlendirme satırı bölüm toplamını açıkça sınırlıyor — "TOPLAM 1 PUANI
 * (1.1;1.2;1.3;1.4;1.6)" — yani editörlük-hakemlik (1.5) ve atıflar (1.7)
 * bölüm toplamının DIŞINDA. Genel değerlendirme tablosu da aynı ayrımı
 * yapıyor: 1-8 bölümleri toplanıp "TOPLAM" yazılıyor, ATIFLAR ve HAKEMLİKLER
 * o satırın altında ayrı ayrı raporlanıyor.
 *
 * 100 ve 120 puanlık barajlar bu yüzden cetvelin tamamına değil `TOPLAM`
 * grubuna bağlandı. İki bağımsız işaret aynı yönü gösteriyor ve bu okuma
 * adayın puanını fazla göstermeyen taraf.
 *
 * ── DÖNEM OKUMALARI ──
 * Doçentlikte dönem kısıtı YOK: MADDE 10/1-c yalnızca "en az toplam 100 puana
 * sahip olmak" diyor, kariyerin tamamı sayılıyor.
 *
 * Profesörlükte "Doçentlik sonrasında" ibaresi cümlenin başında ve HEM yayın
 * koşulunu HEM puan barajını kapsıyor: "Doçentlik sonrasında Ek 1'de yer alan
 * … Tablo'dan 1.1. veya 1.2 veya 1.3'den en az bir (1) yayının olması ve en az
 * toplam 120 puana sahip olmak gereklidir." İki koşul tek cümlede ve tek
 * dönem nitelemesiyle bağlı; ikisine de doçentlik sonrası uygulandı. Yalnızca
 * yayına uygulamak barajı kolaylaştırırdı.
 *
 * ── BEYANA BIRAKILANLAR ──
 *   MADDE 13/1-a: "Doçentlik unvanını aldıktan sonra en az beş yıl … çalışmış
 *       olmak" — görev süresi profilde tutulmuyor.
 *   MADDE 13/1-a'nın "kendi bilim alanında uluslararası düzeyde orijinal
 *       eserler vermiş olmak" ve "uygulama alanı bulunan dallarda uygulamaya
 *       yönelik çalışmalarda bulunmak" hükümleri niteliksel.
 *   MADDE 14/2: "Adaylar, bu başvurularında yayınlarından birini başlıca
 *       araştırma eseri olarak gösterir." Hangi eserin sunulacağı adayın
 *       tercihi; faaliyet kaydından hesaplanmıyor.
 *   MADDE 10/1-a: ÜAK doçentlik unvanı.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 16(7): "Eğitim dili İngilizce olan programlara yapılan
 *       başvurularda … birim başkanı gerekli gördüğü takdirde … İngilizce
 *       seminer ya da deneme dersi vermelerini isteyebilir." Hem programa
 *       hem birim başkanının takdirine bağlı; herkese uygulanan bir koşul
 *       değil. Aday notunda anlatıldı.
 *   MADDE 16(5): ölçütler "tüm akademik birimler için geçerli ortak en düşük
 *       düzeyi belirler", birimler daha üstünü tanımlayabilir. Birimlerin
 *       kendi ölçütleri belgede yok; yazılamaz.
 *   MADDE 9: Dr. Öğr. Üyeliğinde bir-dört yıllık atama ve yeniden atanma
 *       düzenleniyor ama yeniden atanmaya SAYISAL koşul bağlanmıyor —
 *       "ilgili yönetim kurulunun uygun görüşü üzerine" deniyor. Yeniden
 *       atanma kadrosu bu yüzden hiç açılmadı.
 *   MADDE 16(2): "Kabul yazısı gelmiş olan makale/bildiri … değerlendirmeye
 *       alınır" — kaydın kapsamını genişleten bir kural, baraj değil.
 *
 * ── ALAN KAPSAMI ──
 * Yönerge hiçbir temel alanı dışlamıyor, hiçbirine ayrı baraj koymuyor;
 * MADDE 16(5) ölçütlerin "tüm akademik birimler için geçerli" olduğunu
 * söylüyor. On iki temel alanın hepsine yazıldı. Ne var ki cetvelin 6.
 * bölümü (mimarlık ve mühendislik proje etkinlikleri) girilemedi; o iki
 * alanın adayı toplamını olduğundan düşük görür.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/rumeli-2024.php
 */

use App\Enums\TemelAlan;
use App\Services\Scoring\Sart\Kalip;

$DOC = Kalip::DOCENTLIK_SONRASI;

/** Yönerge alan ayrımı yapmıyor; MADDE 16(5) "tüm akademik birimler" diyor. */
$tumAlanlar = array_column(TemelAlan::cases(), 'value');

/** Barajın saydığı kümenin adaya gösterilecek adı. */
$toplamListesi = 'Yayın, araştırma, sanat, ödül, eğitim ve yönetim';

$kapsamNotu = 'Hakemlik, editörlük ve atıf puanınız hesaplanıp gösterilir ama bu baraja '
    .'GİRMEZ: yönergenin değerlendirme tablosu bölüm toplamını makale, kitap ve bildiri '
    .'diye sınırlıyor ve atıf ile hakemlik puanını genel toplamın altında ayrı raporluyor.';

$sanayiNotu = 'Mimarlık ve mühendislik proje etkinlikleri bölümünün on dokuz satırı '
    .'(üniversitenin kendi Ar-Ge birimindeki mimari projeler, öğrenci yarışması '
    .'danışmanlıkları, ulusal ve uluslararası yarışma dereceleri) faaliyet kaydında '
    .'karşılık bulmadığı için puanlanamıyor; Mimarlık ya da Mühendislik adayıysanız '
    .'toplamınız olduğundan düşük görünür.';

$ingilizceNotu = 'Eğitim dili İngilizce olan bir programa başvuruyorsanız birim başkanı '
    .'sizden İngilizce seminer ya da deneme dersi isteyebilir; takdire bağlı '
    .'olduğu için koşul olarak yazılmadı.';

return [
    [
        'anahtar' => 'rumeli-dr',
        'aday_notu' => 'Rumeli, Dr. Öğr. Üyeliği için PUAN BARAJI KOYMUYOR. Yönerge tek '
            .'fıkra ve yalnızca doktora, uzmanlık ya da sanatta yeterlik unvanı istiyor; '
            .'değerlendirme ölçütleri tablosu yalnızca doçentlik ve profesörlük maddelerinde '
            .'anılıyor. Atama bir ilâ dört yıl süreyle yapılıyor ve süre sonunda görev '
            .'kendiliğinden sona eriyor; yeniden atanma yönetim kurulunun uygun görüşüne '
            .'bağlı, sayısal bir koşula değil. '.$ingilizceNotu,
        'universite' => 'İstanbul Rumeli Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $tumAlanlar,
        'cetvel' => 'rumeli-2024',
        'notlar' => 'MADDE 6/1: "Doktor öğretim üyesi kadrolarına başvurabilmek için doktora '
            .'veya tıpta, diş hekimliğinde, eczacılıkta ve veteriner hekimlikte uzmanlık ya '
            .'da sanatta yeterlik eğitimini tamamlamış olmak gereklidir." Puan koşulu yok; '
            .'Ek 1 tablosu bu maddede anılmıyor.',
        'sart' => Kalip::beyan(
            'Doktora, tıpta, diş hekimliğinde, eczacılıkta ya da veteriner hekimlikte '
            .'uzmanlık veya sanatta yeterlik eğitimini tamamlamış olmak',
            'Madde 6/1',
        ),
    ],
    [
        'anahtar' => 'rumeli-docent',
        'aday_notu' => 'Tek sayısal koşul değerlendirme ölçütleri tablosundan 100 puan. '
            .'Yönerge dönem kısıtı koymuyor; doktoradan önceki çalışmalarınız da sayılıyor. '
            .$kapsamNotu.' '.$sanayiNotu,
        'universite' => 'İstanbul Rumeli Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $tumAlanlar,
        'cetvel' => 'rumeli-2024',
        'notlar' => 'MADDE 10/1-c: "Ek 1\'de yer alan Değerlendirme Ölçütleri Puanlama '
            .'Tablosu\'ndan en az toplam 100 puana sahip olmak gereklidir." Dönem kısıtı yok. '
            .'Baraj `TOPLAM` grubuna bağlı: tablonun ara değerlendirme satırı bölüm '
            .'toplamını "1.1;1.2;1.3;1.4;1.6" diye sınırlıyor, hakemlik (1.5) ve atıf (1.7) '
            .'genel toplamın altında ayrı raporlanıyor.',
        'sart' => Kalip::ve('Doçent kadrosuna yükseltilip atanma', [
            Kalip::beyan(
                'Üniversitelerarası Kurul tarafından verilen doçentlik unvanını almış olmak; '
                .'yurt dışında alınmışsa Türkiye\'de geçerli sayılmış olmak',
                'Madde 10/1-a',
            ),
            Kalip::toplam(100, null, ['TOPLAM'], $toplamListesi),
        ]),
    ],
    [
        'anahtar' => 'rumeli-profesor',
        'aday_notu' => 'İki sayısal koşul da DOÇENTLİK SONRASINA bakıyor: makale, bildiri '
            .'ya da kitap kalemlerinizden en az bir yayın ve toplam 120 puan. Yönergenin '
            .'cümlesi "Doçentlik sonrasında … en az bir (1) yayının olması VE en az toplam '
            .'120 puana sahip olmak" diyerek iki koşulu tek dönem nitelemesine bağlıyor. '
            .'Ayrıca doçentlik unvanınızdan sonra en az beş yıl ilgili bilim alanında '
            .'çalışmış olmanız ve yayınlarınızdan birini başlıca araştırma eseri olarak '
            .'göstermeniz gerekiyor; ikisi de belgeyle beyan edilir. '
            .$kapsamNotu.' '.$sanayiNotu,
        'universite' => 'İstanbul Rumeli Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $tumAlanlar,
        'cetvel' => 'rumeli-2024',
        'notlar' => 'MADDE 13/1-c: "Doçentlik sonrasında Ek 1\'de yer alan Değerlendirme '
            .'Ölçütleri Puanlama Tablosu\'ndan 1.1. veya 1.2 veya 1.3\'den en az bir (1) '
            .'yayının olması ve en az toplam 120 puana sahip olmak gereklidir." Dönem '
            .'nitelemesi cümlenin başında ve iki koşulu da kapsıyor. MADDE 13/1-a beş yıl '
            .'doçentlik kıdemi, MADDE 14/2 başlıca araştırma eseri gösterme yükümlülüğü.',
        'sart' => Kalip::ve('Profesör kadrosuna yükseltilip atanma', [
            Kalip::beyan(
                'Doçentlik unvanını aldıktan sonra en az beş yıl açık bulunan profesörlük '
                .'kadrosuyla ilgili bilim alanında çalışmış olmak, kendi bilim alanında '
                .'uluslararası düzeyde orijinal eserler vermiş olmak',
                'Madde 13/1-a',
            ),
            Kalip::adet(
                'Doçentliğinizden sonra makale, bildiri ya da kitap kalemlerinizden en az bir yayın',
                ['1.1-1.2-1.3'], 1, donem: $DOC, madde: 'Madde 13/1-c',
            ),
            Kalip::toplam(120, $DOC, ['TOPLAM'], $toplamListesi),
            Kalip::beyan(
                'Başvuruda yayınlarınızdan birini başlıca araştırma eseri olarak göstermek',
                'Madde 14/2',
            ),
        ]),
    ],
];
