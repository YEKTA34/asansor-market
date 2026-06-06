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
erDiagram
    USER ||--o{ ORDER : "hasMany (1-n)"
    USER ||--o{ BALANCE_TRANSACTION : "hasMany (1-n)"
    ORDER ||--|{ ORDER_ITEM : "hasMany (1-n)"
    ORDER_ITEM }|--|| PRODUCT : "belongsTo (n-1)"
    
    USER {
        int id PK
        string name
        string email
        decimal balance
        boolean is_active
    }
    PRODUCT {
        int id PK
        string title
        int stock
        decimal price
    }
    ORDER {
        int id PK
        int user_id FK
        decimal total_price
        string status
    }
    ORDER_ITEM {
        int id PK
        int order_id FK
        int product_id FK
        int quantity
        decimal price
    }
    BALANCE_TRANSACTION {
        int id PK
        int user_id FK
        decimal amount
        string type
    }graph TD
    Start([🏁 Ödeme İsteği Başladı]) --> CheckBalance{Kullanıcı Bakiyesi >= Toplam Tutar?}
    CheckBalance -- Evet --> PayWithBalance[Hediye Bakiyesi Kullanılır]
    PayWithBalance --> SetCardZero[Kredi Kartı Ödemesi = 0]
    PayWithBalance --> DeductBalance[Kullanıcı Bakiyesinden Düşülür]
    
    CheckBalance -- Hayır --> SplitPay[Tüm Mevcut Bakiye Kullanılır]
    SplitPay --> CalcCard[Kredi Kartı Ödemesi = Toplam Tutar - Mevcut Bakiye]
    SplitPay --> SetBalanceZero[Kullanıcı Bakiyesi = 0]
    
    DeductBalance --> SaveUser[💾 Kullanıcı Verisi Kaydedilir]
    SetBalanceZero --> SaveUser
    SaveUser --> End([🏁 Ödeme Tamamlandı])// Fiyat ve Bakiye Karşılaştırma Mantığı
if ($user->balance >= $totalPrice) {
    $balanceUsed = $totalPrice;
    $cardPaid = 0;
    $user->balance -= $totalPrice;
} else {
    $balanceUsed = $user->balance;
    $cardPaid = $totalPrice - $user->balance;
    $user->balance = 0;
}
$user->save();#Test SenaryosuBeklenen DavranışSonuç1MySQL Veri Entegrasyonumigrate:fresh --seed komutu ile tüm tabloların hatasız oluşması ve test verilerinin yüklenmesi.BAŞARILI2Rol Yetki SınırlarıUser rolündeki bir üyenin /admin/* url'lerine eriştiğinde unauthorized hatası alıp ana sayfaya yönlendirilmesi.BAŞARILI3Stok Kısıt DoğrulamasıEnvanter stok sınırını aşan sepet güncellemelerinin engellenmesi ve Türkçe hata bildirimi basılması.BAŞARILI4Hesap Dondurmais_active = false olan üyelerin giriş denemelerinin engellenmesi ve ekrana uyarı verilmesi.BAŞARILI📝 Sonuç
Bu projede, endüstriyel asansör yedek parça tedarik sektörüne yönelik, modern web standartlarında zengin arayüzlü bir e-ticaret portalı tasarlanmış ve başarıyla uygulanmıştır. PHP ve XAMPP MySQL entegrasyonu sayesinde taşınabilirliği en üst düzeyde tutulmuştur. Laravel framework'ünün sağladığı MVC yapısı kod okunabilirliğini ve bakım kolaylığını artırmıştır. Geliştirilen bakiye bölüşüm ve işlemsel sipariş iptal algoritmaları, web programlama dersi isterlerinin tamamını akademik ve teknik açılardan kusursuz şekilde karşılamıştır.
