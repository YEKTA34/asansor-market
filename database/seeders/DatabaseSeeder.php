<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * TBL304 Ders İsterlerine Göre Örnek Verilerin Yüklenmesi
     */
    public function run(): void
    {
        // 1. Admin Kullanıcısı Oluşturma (1 adet)
        User::create([
            'name' => 'Yönetici Cengiz',
            'email' => 'admin@asansormarket.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'balance' => 0.00,
            'address' => 'Kocaeli Üniversitesi Bilişim Sistemleri Mühendisliği Laboratuvarı, İzmit/Kocaeli',
            'phone' => '05321112233',
            'is_active' => true,
        ]);

        // 2. Standart Kullanıcılar (5 adet)
        $users = [
            [
                'name' => 'Ahmet Yılmaz',
                'email' => 'ahmet@gmail.com',
                'password' => Hash::make('ahmet123'),
                'role' => 'user',
                'balance' => 250.00, // Ahmet'e hediye bakiye tanımlayalım (Bakiye kullanımını denemek için!)
                'address' => 'Yeni Mahalle Atatürk Caddesi No:12 Daire:4, İzmit/Kocaeli',
                'phone' => '05423334455',
                'is_active' => true,
            ],
            [
                'name' => 'Mehmet Kaya',
                'email' => 'mehmet@gmail.com',
                'password' => Hash::make('mehmet123'),
                'role' => 'user',
                'balance' => 0.00,
                'address' => 'Cumhuriyet Mahallesi Hürriyet Sokak No:5, Kartepe/Kocaeli',
                'phone' => '05554445566',
                'is_active' => true,
            ],
            [
                'name' => 'Ayşe Demir',
                'email' => 'ayse@gmail.com',
                'password' => Hash::make('ayse123'),
                'role' => 'user',
                'balance' => 0.00,
                'address' => 'Gültepe Mahallesi Çiçek Sokak No:2 D:6, Başiskele/Kocaeli',
                'phone' => '05334445577',
                'is_active' => true,
            ],
            [
                'name' => 'Fatma Çelik',
                'email' => 'fatma@gmail.com',
                'password' => Hash::make('fatma123'),
                'role' => 'user',
                'balance' => 0.00,
                'address' => 'Fatih Mahallesi Kuyu Sokak No:22, Derince/Kocaeli',
                'phone' => '05051112233',
                'is_active' => true,
            ],
            [
                'name' => 'Ali Öztürk',
                'email' => 'ali@gmail.com',
                'password' => Hash::make('ali123'),
                'role' => 'user',
                'balance' => 0.00,
                'address' => 'Karabaş Mahallesi Leyla Atakan Caddesi No:45, İzmit/Kocaeli',
                'phone' => '05319998877',
                'is_active' => true,
            ]
        ];

        foreach ($users as $u) {
            User::create($u);
        }

        // 3. Asansör Teknik Parça ve Ekipmanları (20 adet)
        $products = [
            [
                'name' => 'Asansör Motoru 5.5 kW Dişlisiz (Gearless)',
                'description' => '5.5 kW gücünde, yüksek verimli dişlisiz asansör motoru. VVVF sürücü uyumlu, sessiz çalışma ve yüksek enerji tasarrufu sağlar. Max taşıma kapasitesi 800 kg, 1.0 m/s hız.',
                'price' => 45000.00,
                'stock' => 5,
                'image_path' => null,
                'is_on_sale' => true,
                'category' => 'Motor ve Tahrik Grubu',
            ],
            [
                'name' => 'VVVF Entegre Asansör Kumanda Panosu',
                'description' => 'Arkel A-Code veya muadili VVVF motor sürücülü, 16 kata kadar çalışabilen entegre asansör kumanda kartı ve panosu. Acil kurtarma ünitesi (UPS) entegreli.',
                'price' => 32000.00,
                'stock' => 8,
                'image_path' => null,
                'is_on_sale' => true,
                'category' => 'Kumanda Sistemleri',
            ],
            [
                'name' => 'Asansör Çelik Halat 10mm (100 Metre Rulo)',
                'description' => '8x19 standardında, asansörler için özel üretilmiş yüksek mukavemetli çelik taşıyıcı halat. Lif özlü, kendinden yağlamalı.',
                'price' => 7500.00,
                'stock' => 15,
                'image_path' => null,
                'is_on_sale' => true,
                'category' => 'Halat ve Askı Grubu',
            ],
            [
                'name' => 'Lüks Paslanmaz Kat Buton Paneli (Kat COP)',
                'description' => 'Mavi LCD göstergeli, kabartma yazılı (Braille alfabeli), 304 kalite paslanmaz çelik yüzeyli asansör dış çağrı kat butonu.',
                'price' => 1200.00,
                'stock' => 50,
                'image_path' => null,
                'is_on_sale' => true,
                'category' => 'Butonlar ve Göstergeler',
            ],
            [
                'name' => 'Kabin Boy Buton Paneli (COP - Boy Kaset)',
                'description' => '2 Metre boyunda, dokunmatik tuş takımlı, 7 inç TFT LCD ekranlı, interkom ve acil aydınlatma entegreli lüks kabin içi kaset panel.',
                'price' => 4800.00,
                'stock' => 20,
                'image_path' => null,
                'is_on_sale' => true,
                'category' => 'Butonlar ve Göstergeler',
            ],
            [
                'name' => 'Asansör Hız Regülatörü (Çift Yönlü)',
                'description' => '1.0 m/s anma hızlı asansörler için çift yönlü emniyet hız sınırlayıcı regülatör. Aşırı hızlanmada mekanik freni tetikler.',
                'price' => 6500.00,
                'stock' => 12,
                'image_path' => null,
                'is_on_sale' => true,
                'category' => 'Güvenlik Ekipmanları',
            ],
            [
                'name' => 'Mekanik Kayma Fren Blokları (Paraşüt Fren)',
                'description' => 'T90 ray uyumlu, çift yönlü mekanik paraşüt fren tertibatı. Halat kopması veya aşırı hızda kabini raya kilitleyerek emniyete alır.',
                'price' => 8900.00,
                'stock' => 10,
                'image_path' => null,
                'is_on_sale' => true,
                'category' => 'Güvenlik Ekipmanları',
            ],
            [
                'name' => 'Hidrolik Asansör Tamponu (Yaylı/Yağlı Tip)',
                'description' => 'Kuyu dibi darbe emici hidrolik asansör tamponu. 1.6 m/s hıza kadar uyumlu, TS EN 81-20/50 standartlarında.',
                'price' => 3200.00,
                'stock' => 25,
                'image_path' => null,
                'is_on_sale' => true,
                'category' => 'Güvenlik Ekipmanları',
            ],
            [
                'name' => 'Otomatik Kabin Kapısı Kilidi',
                'description' => 'Kabin kapısı için elektromekanik emniyet kilidi. Kapı tam kapanmadan asansörün hareket etmesini engeller.',
                'price' => 1800.00,
                'stock' => 40,
                'image_path' => null,
                'is_on_sale' => true,
                'category' => 'Kapı Mekanizmaları',
            ],
            [
                'name' => 'Teleskopik Otomatik Kat Kapısı Mekanizması',
                'description' => '2 panelli, teleskopik açılır otomatik asansör kat kapısı mekanizması. Paslanmaz çelik kaplamalı paneller dahil.',
                'price' => 9500.00,
                'stock' => 8,
                'image_path' => null,
                'is_on_sale' => true,
                'category' => 'Kapı Mekanizmaları',
            ],
            [
                'name' => 'Asansör Rayı Kılavuz (T90/B - 5 Metre)',
                'description' => 'Asansör kabini için soğuk çekme kılavuz ray. T90/B ebatlarında, 5 metre uzunluğunda, pürüzsüz yüzey.',
                'price' => 2900.00,
                'stock' => 100,
                'image_path' => null,
                'is_on_sale' => true,
                'category' => 'Kılavuz Ray Grubu',
            ],
            [
                'name' => 'Asansör Karşı Ağırlık Rayı (T50/A - 5 Metre)',
                'description' => 'Karşı ağırlık şasisi için kılavuz ray. T50/A ebatlarında, 5 metre uzunluğunda, soğuk çekme imalat.',
                'price' => 1400.00,
                'stock' => 120,
                'image_path' => null,
                'is_on_sale' => true,
                'category' => 'Kılavuz Ray Grubu',
            ],
            [
                'name' => 'Ray Konsolu Sacı (Ayarlanabilir Tip)',
                'description' => 'Kuyu duvarına ray montajı için kullanılan, cıvatalı, ayarlanabilir ağır hizmet ray tespit konsolu sacı.',
                'price' => 350.00,
                'stock' => 300,
                'image_path' => null,
                'is_on_sale' => true,
                'category' => 'Kılavuz Ray Grubu',
            ],
            [
                'name' => 'Asansör Kabin Pateni (Poliamid 100mm)',
                'description' => 'Kabin şasisi için 100mm çapında, aşınmaya dayanıklı poliamid malzemeden üretilmiş kılavuz paten. Yağlama kabı dahildir.',
                'price' => 150.00,
                'stock' => 500,
                'image_path' => null,
                'is_on_sale' => true,
                'category' => 'Kabin Aksesuarları',
            ],
            [
                'name' => 'Asansör Aşırı Yük Sensörü (Yük Hücresi)',
                'description' => 'Kabin altı montajlı aşırı yük algılama sistemi. Dijital ekranlı kontrol ünitesi dahil, kabin aşırı yüklendiğinde buzzer ile uyarır.',
                'price' => 2400.00,
                'stock' => 35,
                'image_path' => null,
                'is_on_sale' => true,
                'category' => 'Sensörler ve Elektronik',
            ],
            [
                'name' => 'Manyetik Şalter (Kuyu Sınır Okuyucu)',
                'description' => 'Kat hizalaması ve şerit mıknatısları okumak için kullanılan bi-stabil manyetik kuyu sınır algılayıcı switch sensör.',
                'price' => 850.00,
                'stock' => 80,
                'image_path' => null,
                'is_on_sale' => true,
                'category' => 'Sensörler ve Elektronik',
            ],
            [
                'name' => 'Lüks Kabin Aydınlatma LED Tavan Paneli',
                'description' => 'Asansör kabini için 60x60cm ölçülerinde lüks desenli, homojen ışık dağılımlı, enerji tasarruflu LED aydınlatma armatürü.',
                'price' => 1400.00,
                'stock' => 30,
                'image_path' => null,
                'is_on_sale' => true,
                'category' => 'Kabin Aksesuarları',
            ],
            [
                'name' => 'Kabin Havalandırma Fanı (Salyangoz Fan)',
                'description' => '220V ile çalışan, sessiz, yüksek emiş gücüne sahip asansör kabin tavan tipi salyangoz havalandırma fanı.',
                'price' => 1900.00,
                'stock' => 18,
                'image_path' => null,
                'is_on_sale' => true,
                'category' => 'Kabin Aksesuarları',
            ],
            [
                'name' => 'Dikey Boy Fotosel Seti (Boy Fotosel)',
                'description' => 'Kabin kapısı arasına giren cisimleri algılayarak sıkışmayı önleyen dikey boy kızılötesi fotosel sensör seti (bariyer).',
                'price' => 3800.00,
                'stock' => 22,
                'image_path' => null,
                'is_on_sale' => true,
                'category' => 'Güvenlik Ekipmanları',
            ],
            [
                'name' => 'Kurtarma Akü Grubu ve UPS Sistemi',
                'description' => 'Elektrik kesintisinde asansör kumanda panosunu besleyerek kabinin en yakın kata güvenli tahliyesini sağlayan akülü acil kurtarma cihazı.',
                'price' => 11500.00,
                'stock' => 15,
                'image_path' => null,
                'is_on_sale' => true,
                'category' => 'Güvenlik Ekipmanları',
            ]
        ];

        foreach ($products as $p) {
            Product::create($p);
        }
    }
}
