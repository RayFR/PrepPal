-- =============================================================================
-- PrepPal — full MySQL export (schema + data)
-- Generated from the local `preppal` database via mysqldump (matches current
-- schema including all applied Laravel migrations).
--
-- Restore: create an empty database on the host, set .env DB_* to match,
-- then import, for example:
--   mysql -h HOST -u USER -p YOUR_DATABASE_NAME < preppal_schema_and_data.sql
-- =============================================================================
--
-- MySQL dump 10.13  Distrib 9.5.0, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: preppal
-- ------------------------------------------------------
-- Server version	9.5.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `blog_posts`
--

DROP TABLE IF EXISTS `blog_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blog_posts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `section` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'nutrition',
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Advice',
  `excerpt` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `views` int unsigned NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_posts_slug_unique` (`slug`),
  KEY `blog_posts_published_published_at_index` (`published`,`published_at`),
  KEY `blog_posts_category_index` (`category`),
  KEY `blog_posts_section_index` (`section`),
  KEY `blog_posts_is_featured_index` (`is_featured`),
  KEY `blog_posts_views_index` (`views`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_posts`
--

LOCK TABLES `blog_posts` WRITE;
/*!40000 ALTER TABLE `blog_posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `blog_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contacts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacts`
--

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2026_02_10_172233_create_contacts_table',1),(2,'2026_02_11_201613_create_reviews_table',1),(3,'2026_02_17_102843_create_newsletter_subscribers_table',1),(4,'2026_02_17_112503_create_blog_posts_table',1),(5,'2026_02_17_120114_add_advice_fields_to_blog_posts_table',1),(6,'2026_02_26_165401_add_is_admin_to_users_table',1),(7,'2026_02_27_154208_add_force_password_reset_to_users_table',1),(8,'2026_03_11_233508_add_status_fields_to_orders_table',2),(9,'2026_03_13_220844_add_stock_fields_to_products_table',3),(10,'2026_03_20_225557_add_return_status_to_orders_table',4),(11,'2026_03_22_120000_add_avatar_path_to_users_table',5),(12,'2026_03_22_140000_create_password_reset_tokens_table',6);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `newsletter_subscribers`
--

DROP TABLE IF EXISTS `newsletter_subscribers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `newsletter_subscribers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `newsletter_subscribers_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newsletter_subscribers`
--

LOCK TABLES `newsletter_subscribers` WRITE;
/*!40000 ALTER TABLE `newsletter_subscribers` DISABLE KEYS */;
INSERT INTO `newsletter_subscribers` VALUES (1,'fred@gmail.com','2026-03-22 21:23:16','2026-03-22 21:23:16');
/*!40000 ALTER TABLE `newsletter_subscribers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `price` decimal(8,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_index` (`order_id`),
  KEY `order_items_product_id_index` (`product_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (30,20,1,1,49.99),(31,20,2,1,59.99),(32,20,3,1,54.99),(33,21,1,1,49.99),(34,21,2,1,59.99),(35,21,3,1,54.99),(36,22,1,1,49.99),(37,23,1,1,49.99),(38,24,3,1,54.99),(39,25,3,1,54.99),(40,26,3,1,54.99),(41,27,3,1,54.99);
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `postcode` varchar(20) NOT NULL,
  `delivery_notes` text,
  `total_price` decimal(8,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `return_status` varchar(255) DEFAULT NULL,
  `processed_at` timestamp NULL DEFAULT NULL,
  `shipped_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_user_id_index` (`user_id`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,NULL,'f','freddierayc@gmail.com','22 ff','ddd','dddddd','ddd',114.98,'pending',NULL,NULL,NULL,'2026-02-08 14:23:03','2026-02-08 14:23:03'),(2,2,'fred','freddierayc@gmail.com','222 ffff','London','LDDD DD','Gated door',102.98,'pending',NULL,NULL,NULL,'2026-02-08 14:29:19','2026-02-08 14:29:19'),(3,2,'ff','dddd@gmail.com','dddd','ddd','dddd','ddd',104.98,'pending',NULL,NULL,NULL,'2026-02-08 16:25:10','2026-02-08 16:25:10'),(4,NULL,'fred','freddierayc@gmail.com','33','dddd','ddd','ddd',46.97,'pending',NULL,NULL,NULL,'2026-02-08 16:30:25','2026-02-08 16:30:25'),(5,NULL,'test','freddierayc@gmail.com','rest','test','test','test',114.98,'pending',NULL,NULL,NULL,'2026-02-08 16:31:12','2026-02-08 16:31:12'),(6,NULL,'test','freddierayc@gmail.com','test','test','test',NULL,59.97,'shipped',NULL,NULL,'2026-03-11 23:46:07','2026-02-08 16:32:26','2026-03-11 23:46:07'),(7,2,'Fred','fred@gmail.com','22 close','birmingham','b45 437','Nope',164.97,'pending',NULL,NULL,NULL,'2026-03-13 23:46:29','2026-03-13 23:46:29'),(8,2,'Fred','fred@gmail.com','22 close','birmingham','b45 437','Nope',164.97,'pending',NULL,NULL,NULL,'2026-03-13 23:46:29','2026-03-13 23:46:29'),(9,2,'fred','fff@gmail.com','ff 22','fff','ffff','ffff',119.98,'pending',NULL,NULL,NULL,'2026-03-13 23:47:59','2026-03-13 23:47:59'),(10,2,'fred','fff@gmail.com','ff 22','fff','ffff','ffff',119.98,'pending',NULL,NULL,NULL,'2026-03-13 23:47:59','2026-03-13 23:47:59'),(11,2,'fred','fred@gmail.com','22 fff','ffff','ffffff','fff',164.97,'pending',NULL,NULL,NULL,'2026-03-13 23:51:16','2026-03-13 23:51:16'),(12,2,'fred','fred@gmail.com','22 fff','ffff','ffffff','fff',164.97,'pending',NULL,NULL,NULL,'2026-03-13 23:51:16','2026-03-13 23:51:16'),(13,4,'fredc','freddierayc@gmail.com','333322 dddd','Birmingham','B33 444','FFFF',54.99,'pending',NULL,NULL,NULL,'2026-03-16 15:09:51','2026-03-16 15:09:51'),(14,4,'fredc','freddierayc@gmail.com','333322 dddd','Birmingham','B33 444','FFFF',54.99,'pending',NULL,NULL,NULL,'2026-03-16 15:09:51','2026-03-16 15:09:51'),(15,4,'freed','freddierayc@gmail.com','322 fff','fff','fffffffff','fffff',59.99,'pending',NULL,NULL,NULL,'2026-03-16 15:10:55','2026-03-16 15:10:55'),(16,4,'freed','freddierayc@gmail.com','322 fff','fff','fffffffff','fffff',59.99,'pending',NULL,NULL,NULL,'2026-03-16 15:10:55','2026-03-16 15:10:55'),(17,4,'ff','freddierayc@gmail.com','333ffff','ddd','ddd','ddd',99.98,'pending',NULL,NULL,NULL,'2026-03-16 15:11:50','2026-03-16 15:11:50'),(18,4,'ff','freddierayc@gmail.com','333ffff','ddd','ddd','ddd',99.98,'completed',NULL,NULL,NULL,'2026-03-16 15:11:50','2026-03-16 17:23:15'),(19,4,'fred','freddierayc@gmail.com','wwww','wwww','wwww','www',52.99,'cancelled',NULL,NULL,NULL,'2026-03-16 15:17:06','2026-03-16 17:22:55'),(20,2,'fred','freddierayc@gmail.com','22 Merrions Close','Birmingham','B43 7AT','NOPPPP',164.97,'pending','requested',NULL,NULL,'2026-03-20 22:32:37','2026-03-20 23:45:50'),(21,2,'fred','freddierayc@gmail.com','22 Merrions Close','Birmingham','B43 7AT','NOPPPP',164.97,'completed','requested','2026-03-20 23:46:11',NULL,'2026-03-20 22:32:37','2026-03-22 20:11:33'),(22,2,'fred','f@gmail.com','fdfff','ddd','B444','ddd',49.99,'pending',NULL,NULL,NULL,'2026-03-22 20:15:47','2026-03-22 20:15:47'),(23,2,'fred','f@gmail.com','fdfff','ddd','B444','ddd',49.99,'pending',NULL,NULL,NULL,'2026-03-22 20:15:47','2026-03-22 20:15:47'),(24,2,'Freddie','fred@gmail.com','22 Close','Bi','B43 7AT','DDDD',54.99,'pending',NULL,NULL,NULL,'2026-03-22 20:48:16','2026-03-22 20:48:16'),(25,2,'Freddie','fred@gmail.com','22 Close','Bi','B43 7AT','DDDD',54.99,'pending',NULL,NULL,NULL,'2026-03-22 20:48:16','2026-03-22 20:48:16'),(26,2,'fred','fred@gmail.com','ddddd','bvbbbbb','SW1A 1DD','ffefsef',54.99,'pending',NULL,NULL,NULL,'2026-03-22 20:53:08','2026-03-22 20:53:08'),(27,2,'fred','fred@gmail.com','ddddd','bvbbbbb','SW1A 1DD','ffefsef',54.99,'completed','requested','2026-03-22 21:34:29','2026-03-22 21:34:31','2026-03-22 20:53:08','2026-03-22 21:53:58');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
INSERT INTO `password_reset_tokens` VALUES ('testing@gmail.com','$2y$12$DL6SQzf2MckU/1JB50F5N.IKEz5BWNVBRKKeIFNblBEckzkgdzKQ6','2026-03-22 21:51:54');
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `low_stock_threshold` int NOT NULL DEFAULT '5',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Fat Loss Meal Prep Plan','A structured fat-loss programme designed for sustainable weight reduction.',49.99,'images/fat_loss_plan.png','meal',21,5,NULL,'2026-03-22 20:15:47'),(2,'Lean Muscle Meal Prep Plan','A performance-focused meal plan built to maximise muscle growth.',59.99,'images/lean_muscle_plan.jpg','meal',18,5,NULL,'2026-03-20 22:32:37'),(3,'Maintenance Meal Prep Plan','A balanced programme tailored for individuals who want to maintain weight.',54.99,'images/maintainance_plan.jpg','meal',12,5,NULL,'2026-03-22 20:53:08'),(4,'High Fibre Meal Prep Plan','A plant-forward nutrition plan centered around gut-healthy ingredients.',52.99,'images/high_fibre_plan.jpg','meal',15,5,NULL,NULL),(5,'Whey Protein 1kg','A smooth whey protein powder formulated to support lean muscle growth.',24.99,'images/whey_protein.png','supplement',50,10,NULL,NULL),(6,'Creatine Monohydrate 300g','A premium-grade creatine monohydrate supplement.',20.00,'images/creatine_monohydrate.jpg','supplement',40,40,NULL,'2026-03-22 21:33:57'),(7,'BCAA Powder 250g','A fast-absorbing blend of essential branched-chain amino acids.',19.99,'images/bcaa_powder.jpg','supplement',0,8,NULL,'2026-03-22 21:33:41'),(8,'Daily Multivitamin 60 tablets','A comprehensive daily multivitamin. ddd',11.99,'images/multivitimins.jpg','supplement',10005,8,NULL,'2026-03-22 21:52:43');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `rating` tinyint NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reviews_user_id_product_id_unique` (`user_id`,`product_id`),
  KEY `reviews_product_id_foreign` (`product_id`),
  CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (2,2,1,4,NULL,'2026-03-22 21:07:54','2026-03-22 21:07:54'),(3,2,3,3,'test','2026-03-22 21:27:49','2026-03-22 21:27:49');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  CONSTRAINT `sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('rejHLIjMWPqGEC3cqe9v8UZbjme1KBtWDxIL5naF',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiR2N6U2ZVM3BPclVpTkdHbGdUbzVGSEVzeFpsanNrdjJQbFE4MlNCTSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fX0=',1774217820);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `force_password_reset` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `avatar_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'testing','testing@gmail.com',NULL,'$2y$12$exvrMxBKz4cHByqV5HvcOuWsDrRgUvhYyGUq4EvqHuyMF646xrUzW',1,0,NULL,'2026-02-03 16:58:52','2026-03-22 22:12:29',NULL),(4,'testy','tester@gmail.com',NULL,'$2y$12$8tHO5a7msvQFKjPk/9qc5.8GzyB4PSwhVao2GX4Pg.VYQu0CcIS9q',0,0,NULL,'2026-02-13 17:27:59','2026-02-13 21:21:03',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'preppal'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-03-22 22:44:11
