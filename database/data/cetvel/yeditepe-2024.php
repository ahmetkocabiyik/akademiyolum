<?php

/**
 * YEDİTEPE ÜNİVERSİTESİ — Faaliyet Türü Kataloğu
 * Kaynak: pdf/17537104532.yeditepeuniversitesi.pdf (11 sayfa; MADDE 11
 * uyarınca YÖK onayıyla yürürlüğe girer ve 1 Haziran 2024 tarihinden
 * itibaren başlatılan atama ve yükseltme işlemlerinde uygulanır.)
 *
 * ── BU YÖNERGEDE PUAN YOK ──
 * Yeditepe yönergesi puan cetveli kullanmıyor; koşullar akademik birim
 * birim "şu kategoride en az N yayın" biçiminde SAYI şartı. Bu dosya
 * bir puan cetveli değil, koşulların bağlanabileceği FAALİYET TÜRÜ
 * kataloğu: satırların puanı yok. Madde kodları bize ait.
 *
 * ── ÇEYREKLİK KÜMELERİ ──
 * Yönerge sürekli "SCI-AHCI-SSCI, SCI*EXPANDED veya Q1, Q2 veya Q3
 * kategorideki dergiler" diyor. Web of Science çekirdek indekslerinde
 * taranan bir dergi çeyrekliğinden bağımsız olarak bu kümeye giriyor;
 * bu yüzden `WOS` kümesi dört çeyreğin tamamını ve AHCI'yi kapsıyor.
 * Çeyrekliğe göre daraltılan koşullar için ayrı kümeler var (`Q1`,
 * `Q1-Q2`, `Q2-Q3`). Kaynak sözlüğü AHCI dergilerine çeyreklik
 * vermediği için AHCI yalnız `WOS` kümesinde yer alıyor; çeyreklik
 * isteyen koşullarda AHCI makaleleri sayılmıyor.
 *
 * Yönerge: yonerge/yeditepe.php
 */
$TAM = ['ozgun_makale', 'derleme'];

return [
    'kapsam_notu' => 'Yeditepe Üniversitesi Öğretim Üyeliğine Yükseltilme ve Atanma Yönergesi '
        .'PUAN CETVELİ KULLANMIYOR. Koşullar akademik birim birim "şu kategoride en az N yayın" '
        .'biçiminde sayı şartı; bu yüzden burada puan görmezsiniz. Editöre mektup, özet ve kitap '
        .'kritiği türü yazılar yayın sayısına katılmıyor. Kaynak sözlüğü AHCI dergilerine '
        .'çeyreklik vermediği için çeyreklik isteyen koşullarda (Q1, Q1-Q2, Q2-Q3) AHCI '
        .'makaleleriniz sayılmaz; bu koşullarda puanınız olduğundan düşük görünebilir.',

    'maddeler' => [
        'W-Q1' => ['baslik' => 'SCI, SCI-Expanded ya da SSCI kapsamındaki Q1 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $TAM],
        'W-Q2' => ['baslik' => 'SCI, SCI-Expanded ya da SSCI kapsamındaki Q2 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $TAM],
        'W-Q3' => ['baslik' => 'SCI, SCI-Expanded ya da SSCI kapsamındaki Q3 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $TAM],
        'W-Q4' => ['baslik' => 'SCI, SCI-Expanded ya da SSCI kapsamındaki Q4 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => $TAM],
        'W-AHCI' => ['baslik' => 'AHCI kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => $TAM],
        'ALAN' => ['baslik' => 'Uluslararası alan indeksi, ESCI, Scopus ya da benzeri indekslerce taranan dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => $TAM],
        'TR' => ['baslik' => 'ULAKBİM TR Dizin tarafından taranan ulusal hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $TAM],
        'ULUSAL' => ['baslik' => 'Diğer ulusal hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $TAM],

        'TY' => ['baslik' => 'Doktora ya da sanatta yeterlik tezinizden üretilmiş yayın', 'kategori' => 'tez_yayini', 'kaynaklar' => ['SCIE/SSCI/AHCI', 'ESCI / Scopus', 'TR Dizin', 'BKCI / Scopus Kitap', 'BKCI / Scopus Kitap Bölümü', 'Uluslararası/Ulusal Kitap', 'Kitap Bölümü', 'CPCI Bildiri', 'Diğer']],
        'TY-WOS' => ['baslik' => 'Doktora tezinizden üretilmiş, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['SCIE/SSCI/AHCI']],

        'K' => ['baslik' => 'Ulusal ya da uluslararası yayınevi tarafından yayımlanmış kitap veya kitap bölümü', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Ders / Metot Kitabı', 'BKCI / Scopus Kitap Bölümü', 'Kitap Bölümü', 'Çeviri Kitap', 'Çeviri Kitap Bölümü']],
        'K-KITAP' => ['baslik' => 'Ulusal ya da uluslararası yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Ders / Metot Kitabı']],

        'B-SOZLU' => ['baslik' => 'Ulusal ya da uluslararası bir kongrede sözlü sunum yapmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin', 'Ulusal Tam Metin', 'Davetli Konuşmacı']],
        'B-ULUSLARARASI' => ['baslik' => 'Uluslararası bir kongrede sözlü sunum yapmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin', 'Davetli Konuşmacı']],

        'P-YUR' => ['baslik' => 'Ulusal ya da uluslararası kurumlarca desteklenen projede yürütücü olarak görev yapmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon', 'TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK', 'BAP (Üniversite)'], 'roller' => ['yurutucu']],
        'P-ARS' => ['baslik' => 'Ulusal ya da uluslararası kurumlarca desteklenen projede araştırmacı olarak görev yapmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon', 'TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK', 'BAP (Üniversite)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer']],

        'TD' => ['baslik' => 'Yönetiminizde tamamlanan lisansüstü tez', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi', 'Yüksek Lisans Tezi']],

        'D-LISANSUSTU' => ['baslik' => 'Lisansüstü ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders']],
        'D-DERS' => ['baslik' => 'Ön lisans, lisans ya da lisansüstü ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi']],

        'S-KISISEL' => ['baslik' => 'Kataloglanmış kişisel sanat etkinliği (sergi, bienal, festival, gösterim)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Ulusal)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Elektronik Kişisel Sergi (Ulusal)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Resital (Uluslararası)', 'Resital (Ulusal)', 'Solistlik (Uluslararası)', 'Solistlik (Ulusal)']],
        'S-JURILI' => ['baslik' => 'Uluslararası jürili ya da seçici kurullu bir sergide eserinizin yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Elektronik Karma Sergi (Uluslararası)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)']],
    ],

    'gruplar' => [
        // "SCI-AHCI-SSCI, SCI*EXPANDED veya Q1, Q2 veya Q3 kategorideki dergiler"
        'WOS' => ['W-Q1', 'W-Q2', 'W-Q3', 'W-Q4', 'W-AHCI'],
        'Q1' => ['W-Q1'],
        'Q1-Q2' => ['W-Q1', 'W-Q2'],
        'Q2-Q3' => ['W-Q2', 'W-Q3'],
        'Q1-Q3' => ['W-Q1', 'W-Q2', 'W-Q3'],
        'ALAN-INDEKS' => ['ALAN'],
        'TR-DIZIN' => ['TR'],
        'WOS-ALAN' => ['W-Q1', 'W-Q2', 'W-Q3', 'W-Q4', 'W-AHCI', 'ALAN'],
        'HAKEMLI' => ['W-Q1', 'W-Q2', 'W-Q3', 'W-Q4', 'W-AHCI', 'ALAN', 'TR', 'ULUSAL'],
        'TEZ-YAYINI' => ['TY'],
        'TEZ-YAYINI-WOS' => ['TY-WOS'],
        'KITAP' => ['K'],
        'KITAP-TEK' => ['K-KITAP'],
        'BILDIRI-SOZLU' => ['B-SOZLU'],
        'BILDIRI-ULUSLARARASI' => ['B-ULUSLARARASI'],
        'PROJE-YURUTUCU' => ['P-YUR'],
        'PROJE-ARASTIRMACI' => ['P-ARS'],
        'PROJE' => ['P-YUR', 'P-ARS'],
        'TEZ-DANISMANLIK' => ['TD'],
        'LISANSUSTU-DERS' => ['D-LISANSUSTU'],
        'DERS' => ['D-DERS'],
        'SANAT-KISISEL' => ['S-KISISEL'],
        'SANAT-JURILI' => ['S-JURILI'],
    ],
];
