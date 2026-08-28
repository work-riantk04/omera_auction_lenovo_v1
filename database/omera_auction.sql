-- --------------------------------------------------------
-- Omera Auction Database Schema & Data
-- Generated from live database state
-- --------------------------------------------------------

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- --------------------------------------------------------
-- Table: users
-- --------------------------------------------------------

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text,
  `role` enum('admin','titipers','bidders') NOT NULL DEFAULT 'bidders',
  `avatar` varchar(255) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `address`, `role`, `avatar`, `reset_token`, `reset_expires`, `is_active`, `created_at`, `updated_at`) VALUES
  ('1', 'Admin', 'admin@omera.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, 'admin', NULL, NULL, NULL, '1', '2026-08-26 11:03:51', '2026-08-26 11:03:51'),
  ('2', 'Rian', 'titipers1@mail.com', '$2y$12$xV/Gnav55HzUaSRWtXT/m.NCtAsPGNwJLyaB6urHP5qJb1VfbQfCu', '088219904488', '', 'titipers', 'e833c4621da532b110ea0596ea9d90f7.png', NULL, NULL, '1', '2026-08-27 04:00:38', '2026-08-27 10:42:05'),
  ('3', 'bidders1', 'bidders1@mail.com', '$2y$12$LURW8bsHZJ8G30k2BPa/5uYuFxYPRGTv7sUzlJgq1rQY0crKGHO8u', '088219904488', 'Alamat saya', 'bidders', NULL, NULL, NULL, '1', '2026-08-27 04:59:04', '2026-08-28 04:04:29'),
  ('4', 'bidders2', 'bidders2@mail.com', '$2y$12$LRb/I0C11SDgwkLI6odEMu5mxQg3tAFxbCf/wz0YaxkXuwo2jWDPa', '088219904488', 'alamat1', 'bidders', NULL, NULL, NULL, '1', '2026-08-28 07:44:22', '2026-08-28 07:44:22');

-- --------------------------------------------------------
-- Table: events
-- --------------------------------------------------------

DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `description` text,
  `banner_image` varchar(255) DEFAULT NULL,
  `item_collection_deadline` datetime DEFAULT NULL,
  `auction_start` datetime DEFAULT NULL,
  `auction_end` datetime DEFAULT NULL,
  `status` enum('upcoming','collecting','verifying','active','completed','cancelled') NOT NULL DEFAULT 'upcoming',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `events` (`id`, `name`, `description`, `banner_image`, `item_collection_deadline`, `auction_start`, `auction_end`, `status`, `created_at`, `updated_at`) VALUES
  ('1', 'Coba Event 1', 'Coba Event 1', 'event_1.svg', '2026-08-26 00:00:00', '2026-08-27 00:00:00', '2026-08-29 21:00:00', 'completed', '2026-08-27 04:18:34', '2026-08-28 07:46:53'),
  ('2', 'Lelang Elektronik Bulanan Agustus', 'Lelang berbagai barang elektronik mulai dari smartphone, laptop, hingga aksesoris gadget.', 'event_2.svg', '2026-09-05 23:59:59', '2026-09-10 09:00:00', '2026-09-15 21:00:00', 'collecting', '2026-08-27 06:53:59', '2026-08-27 07:01:10'),
  ('3', 'Koleksi Sneakers Limited Edition', 'Sneakers langka dari brand ternama Nike, Adidas, dan Jordan. Edisi terbatas!', 'event_3.svg', '2026-08-20 23:59:59', '2026-08-22 10:00:00', '2026-08-28 20:00:00', 'active', '2026-08-27 06:53:59', '2026-08-27 07:01:11'),
  ('4', 'Antik & Vintage Fair 2026', 'Barang-barang antik dan vintage dari berbagai era. Koleksi langka untuk para pecinta barang kuno.', 'event_4.svg', '2026-10-01 23:59:59', '2026-10-05 08:00:00', '2026-10-10 18:00:00', 'upcoming', '2026-08-27 06:53:59', '2026-08-27 07:01:11'),
  ('5', 'Lelang Perhiasan Emas & Berlian', 'Perhiasan emas putih, kuning, dan berlian certified. Harga mulai dari Rp 500.000.', 'event_5.svg', '2026-09-10 23:59:59', '2026-09-14 10:00:00', '2026-09-18 22:00:00', 'collecting', '2026-08-27 06:53:59', '2026-08-27 07:01:11'),
  ('6', 'Furniture Minimalis Modern', 'Sofa, meja, kursi, dan rak dengan desain minimalis modern. Cocok untuk hunian masa kini.', 'event_6.svg', '2026-07-10 23:59:59', '2026-07-15 09:00:00', '2026-07-20 21:00:00', 'completed', '2026-08-27 06:53:59', '2026-08-27 07:01:11'),
  ('7', 'Kamera & Fotografi Pro', 'Kamera DSLR, mirrorless, lensa, dan aksesoris fotografi profesional.', 'event_7.svg', '2026-08-18 23:59:59', '2026-08-20 09:00:00', '2026-08-26 20:00:00', 'active', '2026-08-27 06:53:59', '2026-08-27 07:01:11'),
  ('8', 'Mainan & action Figure Collector', 'Action figure, model kit, dan mainan koleksi dari anime, Marvel, DC, dan Star Wars.', 'event_8.svg', '2026-09-15 23:59:59', '2026-09-19 10:00:00', '2026-09-24 21:00:00', 'collecting', '2026-08-27 06:53:59', '2026-08-27 07:01:11'),
  ('9', 'Tas branded Original', 'Tas original dari Louis Vuitton, Gucci, Chanel, dan Hermes. Semua authenticated.', 'event_9.svg', '2026-10-10 23:59:59', '2026-10-14 09:00:00', '2026-10-19 20:00:00', 'upcoming', '2026-08-27 06:53:59', '2026-08-27 07:01:11'),
  ('10', 'Lelang Sepeda & Outdoor', 'Sepeda road bike, MTB, dan perlengkapan outdoor camping & hiking.', 'event_10.svg', '2026-08-15 23:59:59', '2026-08-18 08:00:00', '2026-08-24 19:00:00', 'active', '2026-08-27 06:53:59', '2026-08-27 07:01:11'),
  ('11', 'Jam Tangan Mewah', 'Rolex, Omega, TAG Heuer, dan Casio G-Shock. Jam tangan untuk segala kondisi.', 'event_11.svg', '2026-09-20 23:59:59', '2026-09-24 10:00:00', '2026-09-29 21:00:00', 'collecting', '2026-08-27 06:53:59', '2026-08-27 07:01:11'),
  ('12', 'Musik & Instrumen', 'Gitar, keyboard, drum, dan berbagai instrumen musik untuk pemula hingga profesional.', 'event_12.svg', '2026-07-01 23:59:59', '2026-07-05 09:00:00', '2026-07-10 20:00:00', 'completed', '2026-08-27 06:53:59', '2026-08-27 07:01:11'),
  ('13', 'Buku & Komik Langka', 'Buku first edition, komik vintage, novel langka, dan majalah antik.', 'event_13.svg', '2026-10-20 23:59:59', '2026-10-24 09:00:00', '2026-10-29 18:00:00', 'upcoming', '2026-08-27 06:53:59', '2026-08-27 07:01:11'),
  ('14', 'Otomotif Parts & Accessories', 'Sparepart mobil, aksesoris motor, velg, ban, dan perlengkapan otomotif lainnya.', 'event_14.svg', '2026-09-08 23:59:59', '2026-09-12 08:00:00', '2026-09-17 20:00:00', 'collecting', '2026-08-27 06:53:59', '2026-08-27 07:01:11'),
  ('15', 'Kuliner & Snack Box', 'Paket makanan ringan, kue kering, dan snack box dari berbagai UMKM lokal.', 'event_15.svg', '2026-08-20 23:59:59', '2026-08-21 07:00:00', '2026-08-25 22:00:00', 'active', '2026-08-27 06:53:59', '2026-08-27 07:01:11'),
  ('16', 'Cosplay & Anime Merchandise', 'Kostum cosplay, poster, manga, dan merchandise anime original Jepang.', 'event_16.svg', '2026-11-01 23:59:59', '2026-11-05 10:00:00', '2026-11-10 21:00:00', 'upcoming', '2026-08-27 06:53:59', '2026-08-27 07:01:11'),
  ('17', 'Lelang Tanah & Properti', 'Tanah, rumah, dan ruko di berbagai lokasi strategis di Indonesia.', 'event_17.svg', '2026-08-25 23:59:59', '2026-08-28 09:00:00', '2026-09-02 18:00:00', 'verifying', '2026-08-27 06:53:59', '2026-08-27 07:01:11'),
  ('18', 'Wine & Spirit Collection', 'Koleksi wine, whisky, dan spirit import. Edisi terbatas dan vintage.', 'event_18.svg', '2026-09-25 23:59:59', '2026-09-29 18:00:00', '2026-10-03 22:00:00', 'collecting', '2026-08-27 06:53:59', '2026-08-27 07:01:12'),
  ('19', 'Baby & Kids Essentials', 'Peralatan bayi, mainan edukasi, stroller, car seat, dan kebutuhan anak.', 'event_19.svg', '2026-06-15 23:59:59', '2026-06-18 09:00:00', '2026-06-23 20:00:00', 'completed', '2026-08-27 06:53:59', '2026-08-27 07:01:12'),
  ('20', 'Seni & Lukisan Karya Seniman', 'Lukisan original karya seniman Indonesia dan mancanegara. Berbagai gaya dan era.', '21e0c18e88a489819c446ebc704fefa5.png', '2026-08-22 23:59:00', '2026-08-24 10:00:00', '2026-08-30 21:00:00', 'active', '2026-08-27 06:53:59', '2026-08-27 07:29:42'),
  ('21', 'Gadget & Smart Device', 'Smartwatch, earbuds, tablet, drone, dan gadget pintar lainnya.', 'event_21.svg', '2026-09-12 23:59:59', '2026-09-16 09:00:00', '2026-09-21 20:00:00', 'collecting', '2026-08-27 06:53:59', '2026-08-27 07:01:12');

-- --------------------------------------------------------
-- Table: items
-- --------------------------------------------------------

DROP TABLE IF EXISTS `items`;
CREATE TABLE `items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `event_id` int DEFAULT NULL,
  `titipers_id` int NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text,
  `category` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `starting_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `min_increment` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status` enum('available','submitted','approved','rejected','sold') NOT NULL DEFAULT 'available',
  `admin_note` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_items_event` (`event_id`),
  KEY `idx_items_titipers` (`titipers_id`),
  CONSTRAINT `fk_items_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_items_titipers` FOREIGN KEY (`titipers_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `items` (`id`, `event_id`, `titipers_id`, `name`, `description`, `category`, `image`, `starting_price`, `min_increment`, `status`, `admin_note`, `created_at`, `updated_at`) VALUES
  ('1', '1', '2', 'Coba barang 1', 'oke gambar sudah berubah', 'other', '6d4bd48a7315100043a2d0110edb078f.png', '5000.00', '0.00', 'approved', '', '2026-08-27 04:48:39', '2026-08-28 03:40:05');

-- --------------------------------------------------------
-- Table: item_images
-- --------------------------------------------------------

DROP TABLE IF EXISTS `item_images`;
CREATE TABLE `item_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `item_id` int NOT NULL,
  `image` varchar(255) NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_item_images_item` (`item_id`),
  CONSTRAINT `fk_item_images_item` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `item_images` (`id`, `item_id`, `image`, `is_primary`, `sort_order`, `created_at`) VALUES
  ('1', '1', '6d4bd48a7315100043a2d0110edb078f.png', '1', '0', '2026-08-27 04:48:39');

-- --------------------------------------------------------
-- Table: bids
-- --------------------------------------------------------

DROP TABLE IF EXISTS `bids`;
CREATE TABLE `bids` (
  `id` int NOT NULL AUTO_INCREMENT,
  `event_id` int NOT NULL,
  `item_id` int NOT NULL,
  `bidder_id` int NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_bids_event` (`event_id`),
  KEY `idx_bids_item` (`item_id`),
  KEY `idx_bids_bidder` (`bidder_id`),
  CONSTRAINT `fk_bids_bidder` FOREIGN KEY (`bidder_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_bids_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_bids_item` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `bids` (`id`, `event_id`, `item_id`, `bidder_id`, `amount`, `created_at`) VALUES
  ('4', '1', '1', '3', '5000.00', '2026-08-28 04:12:36'),
  ('5', '1', '1', '3', '5001.00', '2026-08-28 04:13:04'),
  ('6', '1', '1', '3', '6001.00', '2026-08-28 04:38:01'),
  ('7', '1', '1', '4', '7005.00', '2026-08-28 07:44:46');

-- --------------------------------------------------------
-- Table: invoices
-- --------------------------------------------------------

DROP TABLE IF EXISTS `invoices`;
CREATE TABLE `invoices` (
  `id` int NOT NULL AUTO_INCREMENT,
  `event_id` int NOT NULL,
  `item_id` int NOT NULL,
  `bidder_id` int NOT NULL,
  `win_amount` decimal(12,2) NOT NULL,
  `payment_proof` varchar(255) DEFAULT NULL,
  `payment_status` enum('unpaid','paid','verified') NOT NULL DEFAULT 'unpaid',
  `paid_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_invoices_event` (`event_id`),
  KEY `idx_invoices_item` (`item_id`),
  KEY `idx_invoices_bidder` (`bidder_id`),
  CONSTRAINT `fk_invoices_bidder` FOREIGN KEY (`bidder_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_invoices_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_invoices_item` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------
-- Table: shipping
-- --------------------------------------------------------

DROP TABLE IF EXISTS `shipping`;
CREATE TABLE `shipping` (
  `id` int NOT NULL AUTO_INCREMENT,
  `invoice_id` int NOT NULL,
  `titipers_id` int NOT NULL,
  `shipping_proof` varchar(255) DEFAULT NULL,
  `status` enum('pending','shipping','delivered','verified') NOT NULL DEFAULT 'pending',
  `shipped_at` datetime DEFAULT NULL,
  `delivered_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_shipping_invoice` (`invoice_id`),
  KEY `idx_shipping_titipers` (`titipers_id`),
  CONSTRAINT `fk_shipping_invoice` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_shipping_titipers` FOREIGN KEY (`titipers_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------
-- Table: disbursements
-- --------------------------------------------------------

DROP TABLE IF EXISTS `disbursements`;
CREATE TABLE `disbursements` (
  `id` int NOT NULL AUTO_INCREMENT,
  `shipping_id` int NOT NULL,
  `titipers_id` int NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `status` enum('pending','processed','completed') NOT NULL DEFAULT 'pending',
  `processed_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_disbursements_shipping` (`shipping_id`),
  KEY `idx_disbursements_titipers` (`titipers_id`),
  CONSTRAINT `fk_disbursements_shipping` FOREIGN KEY (`shipping_id`) REFERENCES `shipping` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_disbursements_titipers` FOREIGN KEY (`titipers_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------
-- Table: notifications
-- --------------------------------------------------------

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `title` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `link` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_notifications_user` (`user_id`),
  CONSTRAINT `fk_notifications_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `is_read`, `link`, `created_at`) VALUES
  ('1', '2', 'Item Rejected', 'Your item \"Coba barang 1\" has been rejected.', '0', 'admin/items', '2026-08-27 05:11:16'),
  ('2', '2', 'Item Approved', 'Your item \"Coba barang 1\" has been approved.', '0', 'admin/items', '2026-08-28 03:40:05');

-- --------------------------------------------------------
-- Table: settings
-- --------------------------------------------------------

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text,
  `setting_group` varchar(50) NOT NULL DEFAULT 'general',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_setting_key` (`setting_key`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `setting_group`, `updated_at`) VALUES
  ('1', 'home_hero_title_accent', 'Temukan', 'home', '2026-08-28 07:15:24'),
  ('2', 'home_hero_title', 'Barang Langka Terbaik di', 'home', '2026-08-28 07:15:24'),
  ('3', 'home_hero_highlight', 'Omera Auction', 'home', '2026-08-28 07:15:24'),
  ('4', 'home_hero_subtitle', 'Platform lelang online terpercaya yang menghubungkan Titipers (penjual) dengan Bidders (pembeli). Temukan barang unik dan langka dengan harga terbaik melalui sistem lelang yang transparan dan aman.', 'home', '2026-08-28 07:15:24'),
  ('5', 'home_hero_btn_primary', 'Mulai Lelang', 'home', '2026-08-28 07:15:24'),
  ('6', 'home_hero_btn_secondary', 'Pelajari Lebih Lanjut', 'home', '2026-08-28 07:15:24'),
  ('7', 'home_stat_event_label', 'Event Aktif', 'home', '2026-08-28 07:15:24'),
  ('8', 'home_stat_item_label', 'Total Barang', 'home', '2026-08-28 07:15:24'),
  ('9', 'home_stat_bidder_label', 'Bidders', 'home', '2026-08-28 07:15:24'),
  ('10', 'home_carousel_title', 'Event Terbaru', 'home', '2026-08-28 07:15:24'),
  ('11', 'home_carousel_subtitle', 'Jangan lewatkan event lelang menarik dari kami', 'home', '2026-08-28 07:15:24'),
  ('12', 'home_active_title', 'Lelang Aktif', 'home', '2026-08-28 07:15:24'),
  ('13', 'home_active_subtitle', 'Barang-barang yang sedang dilelang secara langsung', 'home', '2026-08-28 07:15:24'),
  ('14', 'home_empty_title', 'Event Lelang Belum Tersedia', 'home', '2026-08-28 07:15:24'),
  ('15', 'home_empty_message', 'Saat ini belum ada event lelang yang sedang berlangsung. Silakan cek kembali nanti atau lihat event yang akan datang.', 'home', '2026-08-28 07:15:24'),
  ('16', 'home_empty_btn', 'Lihat Semua Event', 'home', '2026-08-28 07:15:25'),
  ('17', 'about_hero_title', 'About Us', 'about', '2026-08-28 07:15:25'),
  ('18', 'about_hero_subtitle', 'Mengenal lebih dekat platform lelang Omera Auction', 'about', '2026-08-28 07:21:17'),
  ('19', 'about_apa_title', 'Apa itu Omera Auction?', 'about', '2026-08-28 07:15:25'),
  ('20', 'about_apa_brand', 'Omera Auction', 'about', '2026-08-28 07:15:25'),
  ('21', 'about_desc1', 'Omera Auction adalah platform lelang online yang menghubungkan Titipers (penjual) dengan Bidders (pembeli) dalam suasana lelang yang transparan, mudah, dan terpercaya. Kami menyediakan wadah bagi siapa saja yang ingin menjual atau membeli barang langka dan unik melalui sistem lelang digital yang profesional.', 'about', '2026-08-28 07:15:25'),
  ('22', 'about_desc2', 'Dengan dukungan Admin yang mengelola setiap proses lelang, mulai dari verifikasi barang, pengelolaan event, hingga pemrosesan pembayaran dan pengiriman, Omera Auction memastikan setiap transaksi berjalan aman dan fair untuk semua pihak.', 'about', '2026-08-28 07:15:25'),
  ('23', 'about_features_title', 'Mengapa Memilih Omera Auction?', 'about', '2026-08-28 07:15:25'),
  ('24', 'about_features_subtitle', 'Keunggulan yang kami tawarkan', 'about', '2026-08-28 07:15:25'),
  ('25', 'about_feature1_title', 'Lelang Transparan', 'about', '2026-08-28 07:15:25'),
  ('26', 'about_feature1_desc', 'Setiap proses lelang dapat dipantau secara real-time. Harga bid, jumlah peserta, dan status lelang ditampilkan secara terbuka sehingga semua peserta mendapat informasi yang adil.', 'about', '2026-08-28 07:15:25'),
  ('27', 'about_feature2_title', 'Proses Mudah', 'about', '2026-08-28 07:15:25'),
  ('28', 'about_feature2_desc', 'Mendaftar, mengajukan barang, hingga melakukan penawaran semuanya dapat dilakukan dengan mudah melalui platform kami. Antarmuka yang intuitif membuat pengalaman lelang menyenangkan.', 'about', '2026-08-28 07:15:25'),
  ('29', 'about_feature3_title', 'Aman & Terpercaya', 'about', '2026-08-28 07:15:25'),
  ('30', 'about_feature3_desc', 'Transaksi diproses melalui sistem yang aman. Pembayaran, verifikasi, pengiriman, hingga pencairan dana dikelola oleh admin untuk menjamin keamanan setiap transaksi.', 'about', '2026-08-28 07:15:25'),
  ('31', 'about_workflow_title', 'Bagaimana Cara Kerjanya?', 'about', '2026-08-28 07:15:25'),
  ('32', 'about_workflow_subtitle', 'Alur proses lelang di Omera Auction', 'about', '2026-08-28 07:15:25'),
  ('33', 'about_workflow1_title', 'Daftar Akun', 'about', '2026-08-28 07:15:25'),
  ('34', 'about_workflow1_desc', 'Daftar sebagai Titipers (penjual) atau Bidders (pembeli) dan lengkapi profil Anda.', 'about', '2026-08-28 07:15:25'),
  ('35', 'about_workflow2_title', 'Ajukan Barang', 'about', '2026-08-28 07:15:25'),
  ('36', 'about_workflow2_desc', 'Titipers mengajukan barang ke event lelang yang tersedia. Admin akan memverifikasi setiap barang.', 'about', '2026-08-28 07:15:25'),
  ('37', 'about_workflow3_title', 'Lelang Dimulai', 'about', '2026-08-28 07:15:25'),
  ('38', 'about_workflow3_desc', 'Bidders memberikan penawaran (bid) secara real-time saat event lelang aktif berlangsung.', 'about', '2026-08-28 07:15:25'),
  ('39', 'about_workflow4_title', 'Menang & Bayar', 'about', '2026-08-28 07:15:25'),
  ('40', 'about_workflow4_desc', 'Bidder tertinggi memenangkan lelang, melakukan pembayaran, dan barang dikirim oleh Titipers.', 'about', '2026-08-28 07:15:25'),
  ('41', 'about_roles_title', 'Peran Pengguna', 'about', '2026-08-28 07:15:25'),
  ('42', 'about_roles_subtitle', 'Tiga peran utama dalam ekosistem Omera Auction', 'about', '2026-08-28 07:15:25'),
  ('43', 'about_role1_title', 'Titipers', 'about', '2026-08-28 07:15:25'),
  ('44', 'about_role1_desc', 'Penjual yang mengajukan barang untuk dilelang. Barang yang diajukan akan diverifikasi oleh admin sebelum masuk ke event lelang.', 'about', '2026-08-28 07:15:25'),
  ('45', 'about_role1_feat1', 'Ajukan barang ke event', 'about', '2026-08-28 07:15:25'),
  ('46', 'about_role1_feat2', 'Pantau status barang', 'about', '2026-08-28 07:15:25'),
  ('47', 'about_role1_feat3', 'Proses pengiriman', 'about', '2026-08-28 07:15:25'),
  ('48', 'about_role2_title', 'Bidders', 'about', '2026-08-28 07:15:25'),
  ('49', 'about_role2_desc', 'Pembeli yang berpartisipasi dalam lelang dengan memberikan penawaran harga untuk barang yang diinginkan.', 'about', '2026-08-28 07:15:25'),
  ('50', 'about_role2_feat1', 'Ikut lelang barang', 'about', '2026-08-28 07:15:25'),
  ('51', 'about_role2_feat2', 'Bid secara real-time', 'about', '2026-08-28 07:15:25'),
  ('52', 'about_role2_feat3', 'Bayar & terima barang', 'about', '2026-08-28 07:15:25'),
  ('53', 'about_role3_title', 'Admin', 'about', '2026-08-28 07:15:25'),
  ('54', 'about_role3_desc', 'Pengelola platform yang mengawasi seluruh proses lelang dari awal hingga akhir.', 'about', '2026-08-28 07:15:25'),
  ('55', 'about_role3_feat1', 'Kelola event & barang', 'about', '2026-08-28 07:15:25'),
  ('56', 'about_role3_feat2', 'Verifikasi pembayaran', 'about', '2026-08-28 07:15:25'),
  ('57', 'about_role3_feat3', 'Proses pencairan dana', 'about', '2026-08-28 07:15:25'),
  ('58', 'contact_hero_title', 'Contact Us', 'contact', '2026-08-28 07:15:25'),
  ('59', 'contact_hero_subtitle', 'Hubungi kami untuk pertanyaan, saran, atau kerja sama', 'contact', '2026-08-28 07:15:25'),
  ('60', 'contact_form_title', 'Kirim Pesan', 'contact', '2026-08-28 07:15:25'),
  ('61', 'contact_form_name_label', 'Nama Lengkap', 'contact', '2026-08-28 07:15:25'),
  ('62', 'contact_form_name_placeholder', 'Masukkan nama lengkap', 'contact', '2026-08-28 07:15:25'),
  ('63', 'contact_form_email_label', 'Email', 'contact', '2026-08-28 07:15:25'),
  ('64', 'contact_form_email_placeholder', 'Masukkan email', 'contact', '2026-08-28 07:15:25'),
  ('65', 'contact_form_subject_label', 'Subjek', 'contact', '2026-08-28 07:15:25'),
  ('66', 'contact_form_subject_placeholder', 'Masukkan subjek', 'contact', '2026-08-28 07:15:25'),
  ('67', 'contact_form_message_label', 'Pesan', 'contact', '2026-08-28 07:15:25'),
  ('68', 'contact_form_message_placeholder', 'Tuliskan pesan Anda...', 'contact', '2026-08-28 07:15:25'),
  ('69', 'contact_form_submit', 'Kirim Pesan', 'contact', '2026-08-28 07:15:25'),
  ('70', 'contact_info_title', 'Informasi Kontak', 'contact', '2026-08-28 07:15:25'),
  ('71', 'contact_address_title', 'Alamat', 'contact', '2026-08-28 07:15:25'),
  ('72', 'contact_address', 'Jl. Contoh No. 123\nJakarta, Indonesia', 'contact', '2026-08-28 07:21:32'),
  ('73', 'contact_email_title', 'Email', 'contact', '2026-08-28 07:15:25'),
  ('74', 'contact_email', 'info@omera-auction.com', 'contact', '2026-08-28 07:15:25'),
  ('75', 'contact_phone_title', 'Telepon', 'contact', '2026-08-28 07:15:25'),
  ('76', 'contact_phone', '+62 xxx xxxx xxxx', 'contact', '2026-08-28 07:15:25'),
  ('77', 'contact_social_title', 'Ikuti Kami', 'contact', '2026-08-28 07:15:25'),
  ('78', 'contact_footer_text', '', 'contact', '2026-08-28 07:15:25');

-- --------------------------------------------------------
-- Table: contact_messages
-- --------------------------------------------------------

DROP TABLE IF EXISTS `contact_messages`;
CREATE TABLE `contact_messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

SET FOREIGN_KEY_CHECKS = 1;
