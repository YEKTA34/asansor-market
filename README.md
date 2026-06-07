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
* **Hata Toleranslı (Fault Tolerance) API Entegrasyonları:** Open-Meteo ve Exchange Rates API'leri için 3 saniye zaman aşımı korumalı, çökmeyen yedekli yerel veri (Offline Fallback) mimarisi.

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
    Client["📥 Istemci / Tarayici"] <--> Routes["🔀 Laravel Routes"]
    Routes <--> Controller["⚙️ Controllers"]
    Controller <--> View["🎨 Views - Blade Sablonlari"]
    Controller <--> Model["💾 Models - Eloquent ORM"]
    Model <--> DB[("🗄️ XAMPP MySQL Sunucusu")]
    
    style Client fill:#f9f,stroke:#333,stroke-width:2px
    style DB fill:#5bc0de,stroke:#333,stroke-width:2px
    style Controller fill:#5cb85c,stroke:#333,stroke-width:2px

```mermaid

graph TD
    A(["Iptal Butonuna Basildi"]) --> B{"Siparis Durumu 'Pending' mi?"}
    B -- Hayir --> C["⚠️ Hata: Onaylanmis Siparis Iptal Edilemez"]
    B -- Evet --> D["⚙️ DB::beginTransaction Baslat"]
    
    D --> E["1. Siparis Durumunu 'Cancelled' Yap"]
    E --> F["2. Dongu: Urun Stoklarini Geri Yukle"]
    F --> G["3. Iade: Toplam Tutari Kullanici Bakiyesine Ekle"]
    G --> H["4. Log: BalanceTransaction Tablosuna Yaz"]
    
    H --> I{"Tum Adimlar Basarili mi?"}
    I -- Evet --> J["💾 DB::commit - Degisiklikleri Kaydet"]
    I -- Hayir --> K["🚨 DB::rollBack - Tum Islemleri Geri Al"]
    
    J --> L(["🔄 Siparis Basariyla Iptal Edildi"])
    K --> M(["❌ Iptal Basarisiz - Veri Butunlugu Korundu"])
