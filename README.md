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

#### Şekil 1: LiftMarket Katmanlı MVC ve Sunucu Mimarisi Şeması
```mermaid
graph TD
    Client[📥 İstemci / Tarayıcı] <--> Routes[🔀 Laravel Routes]
    Routes <--> Controller[⚙️ Controllers]
    Controller <--> View[🎨 Views - Blade Şablonları]
    Controller <--> Model[💾 Models - Eloquent ORM]
    Model <--> DB[(🗄️ XAMPP MySQL Sunucusu)]
    
    style Client fill:#f9f,stroke:#333,stroke-width:2px
    style DB fill:#5bc0de,stroke:#333,stroke-width:2px
    style Controller fill:#5cb85c,stroke:#333,stroke-width:2pxerDiagram
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
$user->save();graph TD
    A([İptal Butonuna Basıldı]) --> B{Sipariş Durumu 'Pending' mi?}
    B -- Hayır --> C[⚠️ Hata: Onaylanmış Sipariş İptal Edilemez]
    B -- Yes --> D[⚙️ DB::beginTransaction Başlat]
    
    D --> E[1. Sipariş Durumunu 'Cancelled' Yap]
    E --> F[2. Döngü: Ürün Stoklarını Geri Yükle]
    F --> G[3. İade: Toplam Tutarı Kullanıcı Bakiyesine Ekle]
    G --> H[4. Log: BalanceTransaction Tablosuna Yaz]
    
    H --> I{Tüm Adımlar Başarılı mı?}
    I -- Evet --> J[💾 DB::commit - Değişiklikleri Kaydet]
    I -- Hayır --> K[🚨 DB::rollBack - Tüm İşlemleri Geri Al]
    
    J --> L([🔄 Sipariş Başarıyla İptal Edildi])
    K --> M([❌ İptal Başarısız - Veri Bütünlüğü Korundu])graph TD
    Start([⚙️ Admin Paneli Yükleniyor]) --> Request[📥 Harici API İstekleri Gönderildi]
    Request --> Timer{Geçen Süre > 3 Saniye?}
    
    Timer -- Evet --> Timeout[🕒 TimeoutException Tetikle]
    Timer -- Hayır --> Fetch{Bağlantı Başarılı mı?}
    
    Fetch -- Hayır --> Fallback[⚠️ Fault Tolerance Devreye Al]
    Fetch -- Evet --> Display[📊 Canlı API Verilerini Göster]
    
    Timeout --> Fallback
    Fallback --> LoadLocal[🗄️ Yerel Cache/Yedek Veriyi Yükle]
    LoadLocal --> Alert[💡 Çevrimdışı Mod Uyarısını Göster]
    
    Display --> End([🏁 Panel Başarıyla Yüklendi])
    Alert --> End
