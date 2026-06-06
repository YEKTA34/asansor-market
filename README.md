# 🛗 LiftMarket - Asansör Teknik Parça & Ekipmanları E-Ticaret Portalı

Bu çalışma, **Kocaeli Üniversitesi Teknoloji Fakültesi Bilişim Sistemleri Mühendisliği Bölümü TBL304 Web Programlama** dersi kapsamında geliştirilen bir e-ticaret portalıdır. 

Proje; modern yazılım mühendisliği standartlarına uygun olarak **Laravel 11 (PHP MVC)** framework'ü üzerinde inşa edilmiş, **XAMPP MySQL** ilişkisel veritabanı sunucusu ile entegre edilmiştir. Arayüz tasarımında **Bootstrap 5** ve modern HSL tabanlı CSS bileşenleri kullanılarak tamamen responsive ve kullanıcı dostu bir deneyim sağlanmıştır.

---

## 🚀 Öne Çıkan Özellikler

* **Rol Tabanlı Yetkilendirme:** Gelişmiş `Admin` ve `User` rol yönetimi ile güvenli yetki sınırları.
* **Dinamik Sepet & Stok Kontrolü:** Envanter sınırlarını aşmayı engelleyen anlık stok doğrulamalı sepet yönetimi.
* **Bakiye Bölüşümlü Mock Ödeme:** Kullanıcının mevcut hediye bakiyesi ile kredi kartı ödemesini hibrit olarak paylaştıran akıllı algoritma.
* **İşlemsel (Transactional) Sipariş Yönetimi:** Sipariş iptali ve bakiye iade süreçlerinde veri kaybını önleyen `DB::transaction` yapısı.
* **Güvenlik Çemberi:** Hesabı dondurulan (`is_active = false`) kullanıcıların sisteme erişimini engelleyen fonksiyon.
* **Hata Toleranslı (Fault Tolerance) API Entegrasyonları:** Open-Meteo ve Exchange Rates API'leri için 3 saniye zaman aşımı korumalı, çökmeyi önleyen yedekli yerel veri (Offline Fallback) mimarisi.

---

## 🛠️ Sistem Mimarisi ve Teknolojiler

LiftMarket projesi, katmanlı yazılım mimarisi prensiplerine uygun olarak tasarlanmıştır.

### 🔌 Sunucu ve Veritabanı Altyapısı
Sistem, geliştirme ve yerel test aşamalarında taşınabilir **PHP 8.2** ortamında çalışacak şekilde yapılandırılmıştır. Dönem projesi isterlerine tam uyumluluk amacıyla, yerel veritabanı olarak **XAMPP MySQL** ilişkisel veritabanı sunucusu (`127.0.0.1:3306`) entegre edilmiştir. Kurulum kolaylığı açısından varsayılan kimlik bilgileri (`root` kullanıcı adı ve şifresiz erişim) tercih edilmiştir.

### 📐 MVC Tasarım Deseni
Projede Laravel 11'in sunduğu modern Model-View-Controller (MVC) mimari deseni uygulanmıştır:

* **Model:** Veritabanındaki tabloları temsil eden Eloquent sınıflarıdır (`User`, `Product`, `Cart`, `Order`, `OrderItem`, `BalanceTransaction`).
* **View:** Kullanıcıya sunulan arayüzleri oluşturan Türkçe Blade şablonlarıdır.
* **Controller:** İstekleri karşılayan, iş mantığını ve algoritmaları işleyen denetleyici sınıflarıdır (`AuthController`, `ProductController`, `CartController`, `OrderController`, `AdminController`).
Dondurmais_active = false olan üyelerin giriş denemelerinin engellenmesi ve ekrana uyarı verilmesi.BAŞARILI📝 Sonuç
Bu projede, endüstriyel asansör yedek parça tedarik sektörüne yönelik, modern web standartlarında zengin arayüzlü bir e-ticaret portalı tasarlanmış ve başarıyla uygulanmıştır. PHP ve XAMPP MySQL entegrasyonu sayesinde taşınabilirliği en üst düzeyde tutulmuştur. Laravel framework'ünün sağladığı MVC yapısı kod okunabilirliğini ve bakım kolaylığını artırmıştır. Geliştirilen bakiye bölüşüm ve işlemsel sipariş iptal algoritmaları, web programlama dersi isterlerinin tamamını akademik ve teknik açılardan kusursuz şekilde karşılamıştır.## 🧪 Doğrulama ve Test Edilebilirlik

Sistemin kararlılığı ve gereksinimleri tam karşılaması için yerel ortamda kapsamlı doğrulama testleri yürütülmüştür:

| # | Test Senaryosu | Beklenen Davranış | Sonuç |
| :---: | :--- | :--- | :---: |
| **1** | MySQL Veri Entegrasyonu | `migrate:fresh --seed` komutu ile tüm tabloların hatasız oluşması ve test verilerinin yüklenmesi. | **🟢 BAŞARILI** |
| **2** | Rol Yetki Sınırları | `User` rolündeki bir üyenin `/admin/*` url'lerine eriştiğinde `unauthorized` hatası alıp ana sayfaya yönlendirilmesi. | **🟢 BAŞARILI** |
| **3** | Stok Kısıt Doğrulaması | Envanter stok sınırını aşan sepet güncellemelerinin engellenmesi ve Türkçe hata bildirimi basılması. | **🟢 BAŞARILI** |
| **4** | Hesap Dondurma | `is_active = false` olan üyelerin giriş denemelerinin engellenmesi ve ekrana uyarı verilmesi. | **🟢 BAŞARILI** |
