<?php

/*
|--------------------------------------------------------------------------
| Fakülte → Bölüm / Program Eşlemesi
|--------------------------------------------------------------------------
|
| Onboarding'de seçilen fakülteye göre bölüm dropdown'ını doldurmak için.
| Kapsayıcı değil; yaygın bölümler. Listede yoksa kullanıcı boş bırakabilir.
|
*/

return [
    // ── Sosyal ──
    'İlahiyat Fakültesi' => ['Temel İslam Bilimleri', 'Felsefe ve Din Bilimleri', 'İslam Tarihi ve Sanatları'],
    'İslami İlimler Fakültesi' => ['Temel İslam Bilimleri', 'Felsefe ve Din Bilimleri', 'İslam Tarihi ve Sanatları'],
    'İktisadi ve İdari Bilimler Fakültesi' => ['İktisat', 'İşletme', 'Kamu Yönetimi', 'Uluslararası İlişkiler', 'Maliye', 'Ekonometri', 'Çalışma Ekonomisi ve Endüstri İlişkileri'],
    'İşletme Fakültesi' => ['İşletme', 'Muhasebe ve Finans Yönetimi', 'İnsan Kaynakları Yönetimi', 'Uluslararası İşletmecilik'],
    'Siyasal Bilgiler Fakültesi' => ['Siyaset Bilimi ve Kamu Yönetimi', 'Uluslararası İlişkiler', 'İktisat', 'Maliye'],
    'Hukuk Fakültesi' => ['Hukuk'],
    'İletişim Fakültesi' => ['Gazetecilik', 'Halkla İlişkiler ve Tanıtım', 'Radyo Televizyon ve Sinema', 'Reklamcılık'],
    'Edebiyat Fakültesi' => ['Türk Dili ve Edebiyatı', 'Tarih', 'Coğrafya', 'Felsefe', 'Psikoloji', 'Sosyoloji', 'Sanat Tarihi', 'Arkeoloji', 'İngiliz Dili ve Edebiyatı'],
    'Fen-Edebiyat Fakültesi' => ['Türk Dili ve Edebiyatı', 'Tarih', 'Matematik', 'Fizik', 'Kimya', 'Biyoloji', 'Sosyoloji', 'Psikoloji'],
    'İnsan ve Toplum Bilimleri Fakültesi' => ['Sosyoloji', 'Psikoloji', 'Felsefe', 'Tarih', 'Türk Dili ve Edebiyatı'],
    'Dil ve Tarih-Coğrafya Fakültesi' => ['Tarih', 'Coğrafya', 'Türk Dili ve Edebiyatı', 'Felsefe', 'Arkeoloji', 'Dilbilim'],
    'Turizm Fakültesi' => ['Turizm İşletmeciliği', 'Gastronomi ve Mutfak Sanatları', 'Turizm Rehberliği'],

    // ── Fen ──
    'Fen Fakültesi' => ['Matematik', 'Fizik', 'Kimya', 'Biyoloji', 'İstatistik', 'Moleküler Biyoloji ve Genetik'],
    'Ziraat Fakültesi' => ['Tarla Bitkileri', 'Bahçe Bitkileri', 'Bitki Koruma', 'Zootekni', 'Tarım Ekonomisi', 'Toprak Bilimi ve Bitki Besleme'],
    'Orman Fakültesi' => ['Orman Mühendisliği', 'Orman Endüstri Mühendisliği', 'Peyzaj Mimarlığı'],
    'Su Ürünleri Fakültesi' => ['Su Ürünleri Mühendisliği', 'Balıkçılık Teknolojisi Mühendisliği'],

    // ── Mühendislik ──
    'Mühendislik Fakültesi' => ['Bilgisayar Mühendisliği', 'Elektrik-Elektronik Mühendisliği', 'Makine Mühendisliği', 'İnşaat Mühendisliği', 'Endüstri Mühendisliği', 'Kimya Mühendisliği', 'Çevre Mühendisliği', 'Gıda Mühendisliği', 'Yazılım Mühendisliği'],
    'Mühendislik ve Mimarlık Fakültesi' => ['Bilgisayar Mühendisliği', 'Elektrik-Elektronik Mühendisliği', 'Makine Mühendisliği', 'İnşaat Mühendisliği', 'Endüstri Mühendisliği', 'Mimarlık', 'Şehir ve Bölge Planlama'],
    'Mimarlık Fakültesi' => ['Mimarlık', 'Şehir ve Bölge Planlama', 'İç Mimarlık', 'Peyzaj Mimarlığı'],
    'Teknoloji Fakültesi' => ['Yazılım Mühendisliği', 'Elektrik-Elektronik Mühendisliği', 'Makine Mühendisliği', 'Mekatronik Mühendisliği', 'Otomotiv Mühendisliği', 'İnşaat Mühendisliği'],
    'Mimarlık ve Tasarım Fakültesi' => ['Mimarlık', 'İç Mimarlık', 'Endüstriyel Tasarım', 'Şehir ve Bölge Planlama'],

    // ── Sağlık ──
    'Tıp Fakültesi' => ['Temel Tıp Bilimleri', 'Dahili Tıp Bilimleri', 'Cerrahi Tıp Bilimleri'],
    'Diş Hekimliği Fakültesi' => ['Klinik Bilimler', 'Klinik Öncesi Bilimler'],
    'Eczacılık Fakültesi' => ['Eczacılık Meslek Bilimleri', 'Eczacılık Teknolojisi', 'Temel Eczacılık Bilimleri'],
    'Sağlık Bilimleri Fakültesi' => ['Hemşirelik', 'Ebelik', 'Beslenme ve Diyetetik', 'Fizyoterapi ve Rehabilitasyon', 'Sağlık Yönetimi', 'Odyoloji', 'Çocuk Gelişimi'],
    'Hemşirelik Fakültesi' => ['Hemşirelik'],
    'Veteriner Fakültesi' => ['Klinik Bilimler', 'Klinik Öncesi Bilimler', 'Zootekni ve Hayvan Besleme', 'Gıda Hijyeni ve Teknolojisi'],

    // ── Eğitim ──
    'Eğitim Fakültesi' => ['Matematik ve Fen Bilimleri Eğitimi', 'Türkçe ve Sosyal Bilimler Eğitimi', 'Temel Eğitim', 'Özel Eğitim', 'Yabancı Diller Eğitimi', 'Eğitim Bilimleri', 'Bilgisayar ve Öğretim Teknolojileri Eğitimi', 'Güzel Sanatlar Eğitimi'],
    'Eğitim Bilimleri Fakültesi' => ['Eğitim Bilimleri', 'Rehberlik ve Psikolojik Danışmanlık', 'Eğitim Yönetimi'],
    'Spor Bilimleri Fakültesi' => ['Beden Eğitimi ve Spor Öğretmenliği', 'Antrenörlük Eğitimi', 'Spor Yöneticiliği', 'Rekreasyon'],

    // ── Güzel Sanatlar ──
    'Güzel Sanatlar Fakültesi' => ['Resim', 'Heykel', 'Grafik', 'Seramik', 'Müzik', 'Sahne Sanatları', 'Geleneksel Türk Sanatları', 'Fotoğraf'],
    'Güzel Sanatlar, Tasarım ve Mimarlık Fakültesi' => ['Resim', 'Grafik Tasarım', 'İç Mimarlık', 'Endüstriyel Tasarım', 'Mimarlık'],
    'Devlet Konservatuvarı' => ['Müzik', 'Sahne Sanatları', 'Bale', 'Kompozisyon'],
];
