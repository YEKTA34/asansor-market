
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `balance_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `balance_transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `type` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `balance_transactions_user_id_foreign` (`user_id`),
  CONSTRAINT `balance_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `balance_transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `balance_transactions` ENABLE KEYS */;
DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
DROP TABLE IF EXISTS `carts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `carts_user_id_foreign` (`user_id`),
  KEY `carts_product_id_foreign` (`product_id`),
  CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_05_21_000000_create_asansor_tables',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `shipping_address` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `balance_used` decimal(10,2) NOT NULL DEFAULT 0.00,
  `card_paid_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`),
  KEY `orders_user_id_foreign` (`user_id`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `is_on_sale` tinyint(1) NOT NULL DEFAULT 1,
  `category` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Asansör Motoru 5.5 kW Dişlisiz (Gearless)','5.5 kW gücünde, yüksek verimli dişlisiz asansör motoru. VVVF sürücü uyumlu, sessiz çalışma ve yüksek enerji tasarrufu sağlar. Max taşıma kapasitesi 800 kg, 1.0 m/s hız.',45000.00,5,NULL,1,'Motor ve Tahrik Grubu','2026-05-24 18:30:39','2026-05-24 18:30:39'),(2,'VVVF Entegre Asansör Kumanda Panosu','Arkel A-Code veya muadili VVVF motor sürücülü, 16 kata kadar çalışabilen entegre asansör kumanda kartı ve panosu. Acil kurtarma ünitesi (UPS) entegreli.',32000.00,8,NULL,1,'Kumanda Sistemleri','2026-05-24 18:30:39','2026-05-24 18:30:39'),(3,'Asansör Çelik Halat 10mm (100 Metre Rulo)','8x19 standardında, asansörler için özel üretilmiş yüksek mukavemetli çelik taşıyıcı halat. Lif özlü, kendinden yağlamalı.',7500.00,15,NULL,1,'Halat ve Askı Grubu','2026-05-24 18:30:39','2026-05-24 18:30:39'),(4,'Lüks Paslanmaz Kat Buton Paneli (Kat COP)','Mavi LCD göstergeli, kabartma yazılı (Braille alfabeli), 304 kalite paslanmaz çelik yüzeyli asansör dış çağrı kat butonu.',1200.00,50,NULL,1,'Butonlar ve Göstergeler','2026-05-24 18:30:39','2026-05-24 18:30:39'),(5,'Kabin Boy Buton Paneli (COP - Boy Kaset)','2 Metre boyunda, dokunmatik tuş takımlı, 7 inç TFT LCD ekranlı, interkom ve acil aydınlatma entegreli lüks kabin içi kaset panel.',4800.00,20,NULL,1,'Butonlar ve Göstergeler','2026-05-24 18:30:39','2026-05-24 18:30:39'),(6,'Asansör Hız Regülatörü (Çift Yönlü)','1.0 m/s anma hızlı asansörler için çift yönlü emniyet hız sınırlayıcı regülatör. Aşırı hızlanmada mekanik freni tetikler.',6500.00,12,NULL,1,'Güvenlik Ekipmanları','2026-05-24 18:30:39','2026-05-24 18:30:39'),(7,'Mekanik Kayma Fren Blokları (Paraşüt Fren)','T90 ray uyumlu, çift yönlü mekanik paraşüt fren tertibatı. Halat kopması veya aşırı hızda kabini raya kilitleyerek emniyete alır.',8900.00,10,NULL,1,'Güvenlik Ekipmanları','2026-05-24 18:30:39','2026-05-24 18:30:39'),(8,'Hidrolik Asansör Tamponu (Yaylı/Yağlı Tip)','Kuyu dibi darbe emici hidrolik asansör tamponu. 1.6 m/s hıza kadar uyumlu, TS EN 81-20/50 standartlarında.',3200.00,25,NULL,1,'Güvenlik Ekipmanları','2026-05-24 18:30:39','2026-05-24 18:30:39'),(9,'Otomatik Kabin Kapısı Kilidi','Kabin kapısı için elektromekanik emniyet kilidi. Kapı tam kapanmadan asansörün hareket etmesini engeller.',1800.00,40,NULL,1,'Kapı Mekanizmaları','2026-05-24 18:30:39','2026-05-24 18:30:39'),(10,'Teleskopik Otomatik Kat Kapısı Mekanizması','2 panelli, teleskopik açılır otomatik asansör kat kapısı mekanizması. Paslanmaz çelik kaplamalı paneller dahil.',9500.00,8,NULL,1,'Kapı Mekanizmaları','2026-05-24 18:30:39','2026-05-24 18:30:39'),(11,'Asansör Rayı Kılavuz (T90/B - 5 Metre)','Asansör kabini için soğuk çekme kılavuz ray. T90/B ebatlarında, 5 metre uzunluğunda, pürüzsüz yüzey.',2900.00,100,NULL,1,'Kılavuz Ray Grubu','2026-05-24 18:30:39','2026-05-24 18:30:39'),(12,'Asansör Karşı Ağırlık Rayı (T50/A - 5 Metre)','Karşı ağırlık şasisi için kılavuz ray. T50/A ebatlarında, 5 metre uzunluğunda, soğuk çekme imalat.',1400.00,120,NULL,1,'Kılavuz Ray Grubu','2026-05-24 18:30:39','2026-05-24 18:30:39'),(13,'Ray Konsolu Sacı (Ayarlanabilir Tip)','Kuyu duvarına ray montajı için kullanılan, cıvatalı, ayarlanabilir ağır hizmet ray tespit konsolu sacı.',350.00,300,NULL,1,'Kılavuz Ray Grubu','2026-05-24 18:30:39','2026-05-24 18:30:39'),(14,'Asansör Kabin Pateni (Poliamid 100mm)','Kabin şasisi için 100mm çapında, aşınmaya dayanıklı poliamid malzemeden üretilmiş kılavuz paten. Yağlama kabı dahildir.',150.00,500,NULL,1,'Kabin Aksesuarları','2026-05-24 18:30:39','2026-05-24 18:30:39'),(15,'Asansör Aşırı Yük Sensörü (Yük Hücresi)','Kabin altı montajlı aşırı yük algılama sistemi. Dijital ekranlı kontrol ünitesi dahil, kabin aşırı yüklendiğinde buzzer ile uyarır.',2400.00,35,NULL,1,'Sensörler ve Elektronik','2026-05-24 18:30:39','2026-05-24 18:30:39'),(16,'Manyetik Şalter (Kuyu Sınır Okuyucu)','Kat hizalaması ve şerit mıknatısları okumak için kullanılan bi-stabil manyetik kuyu sınır algılayıcı switch sensör.',850.00,80,NULL,1,'Sensörler ve Elektronik','2026-05-24 18:30:39','2026-05-24 18:30:39'),(17,'Lüks Kabin Aydınlatma LED Tavan Paneli','Asansör kabini için 60x60cm ölçülerinde lüks desenli, homojen ışık dağılımlı, enerji tasarruflu LED aydınlatma armatürü.',1400.00,30,NULL,1,'Kabin Aksesuarları','2026-05-24 18:30:39','2026-05-24 18:30:39'),(18,'Kabin Havalandırma Fanı (Salyangoz Fan)','220V ile çalışan, sessiz, yüksek emiş gücüne sahip asansör kabin tavan tipi salyangoz havalandırma fanı.',1900.00,18,NULL,1,'Kabin Aksesuarları','2026-05-24 18:30:39','2026-05-24 18:30:39'),(19,'Dikey Boy Fotosel Seti (Boy Fotosel)','Kabin kapısı arasına giren cisimleri algılayarak sıkışmayı önleyen dikey boy kızılötesi fotosel sensör seti (bariyer).',3800.00,22,NULL,1,'Güvenlik Ekipmanları','2026-05-24 18:30:39','2026-05-24 18:30:39'),(20,'Kurtarma Akü Grubu ve UPS Sistemi','Elektrik kesintisinde asansör kumanda panosunu besleyerek kabinin en yakın kata güvenli tahliyesini sağlayan akülü acil kurtarma cihazı.',11500.00,15,NULL,1,'Güvenlik Ekipmanları','2026-05-24 18:30:39','2026-05-24 18:30:39');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `address` text DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Yönetici Cengiz','admin@asansormarket.com',NULL,'$2y$12$KUYKT7RaXXIYxCKSfYiCFu4ZOetOTT3Bsy.fiRYC7wU8Y7W7yj9xC','admin',0.00,'Kocaeli Üniversitesi Bilişim Sistemleri Mühendisliği Laboratuvarı, İzmit/Kocaeli','05321112233',1,NULL,'2026-05-24 18:30:38','2026-05-24 18:30:38'),(2,'Ahmet Yılmaz','ahmet@gmail.com',NULL,'$2y$12$mUQUmqcT66EieauAP2P2F.RV7Sgf7ffN.qWgbtuQPjK.xG1/OisG2','user',250.00,'Yeni Mahalle Atatürk Caddesi No:12 Daire:4, İzmit/Kocaeli','05423334455',1,NULL,'2026-05-24 18:30:39','2026-05-24 18:30:39'),(3,'Mehmet Kaya','mehmet@gmail.com',NULL,'$2y$12$A1ndCthj1FFBWKrd7zC0iOGSXVq8IfKT8LCGqBNKASA00W5XYT0DK','user',0.00,'Cumhuriyet Mahallesi Hürriyet Sokak No:5, Kartepe/Kocaeli','05554445566',1,NULL,'2026-05-24 18:30:39','2026-05-24 18:30:39'),(4,'Ayşe Demir','ayse@gmail.com',NULL,'$2y$12$YrHQnLPPhYP/7UP3O27/m.2HOKszwsr5J2A5FCMpMJ.2qRDTrp8fy','user',0.00,'Gültepe Mahallesi Çiçek Sokak No:2 D:6, Başiskele/Kocaeli','05334445577',1,NULL,'2026-05-24 18:30:39','2026-05-24 18:30:39'),(5,'Fatma Çelik','fatma@gmail.com',NULL,'$2y$12$bzkpkmklcnut2uCuCOynD.EsNFFNwBDitqxzS7b/SBDY80ZH6/OLC','user',0.00,'Fatih Mahallesi Kuyu Sokak No:22, Derince/Kocaeli','05051112233',1,NULL,'2026-05-24 18:30:39','2026-05-24 18:30:39'),(6,'Ali Öztürk','ali@gmail.com',NULL,'$2y$12$teoyYjrugzPwvnLSCRzWy.eixyVlHIMALibkIvXpeFDP4ULmbLP/K','user',0.00,'Karabaş Mahallesi Leyla Atakan Caddesi No:45, İzmit/Kocaeli','05319998877',1,NULL,'2026-05-24 18:30:39','2026-05-24 18:30:39');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

