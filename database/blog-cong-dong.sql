/*
SQLyog Community v13.3.1 (64 bit)
MySQL - 10.4.32-MariaDB : Database - blog_cong_dong
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`blog_cong_dong` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `blog_cong_dong`;

/*Table structure for table `cache` */

DROP TABLE IF EXISTS `cache`;

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cache` */

/*Table structure for table `cache_locks` */

DROP TABLE IF EXISTS `cache_locks`;

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cache_locks` */

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_name_unique` (`name`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `categories` */

insert  into `categories`(`id`,`name`,`slug`,`created_at`,`updated_at`) values 
(1,'Công nghệ','cong-nghe','2026-11-11 13:13:13','2026-11-11 13:13:13'),
(2,'Đời sống','doi-song','2026-11-11 13:13:13','2026-11-11 13:13:13'),
(3,'Du lịch','du-lich','2026-11-11 13:13:13','2026-11-11 13:13:13'),
(4,'Ẩm thực','am-thuc','2026-11-11 13:13:13','2026-11-11 13:13:13'),
(5,'Học tập','hoc-tap','2026-11-11 13:13:13','2026-11-11 13:13:13');

/*Table structure for table `comments` */

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `body` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_post_id_foreign` (`post_id`),
  KEY `comments_user_id_foreign` (`user_id`),
  CONSTRAINT `comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `comments` */

insert  into `comments`(`id`,`post_id`,`user_id`,`body`,`created_at`,`updated_at`) values 
(2,8,2,'ok','2026-11-11 14:26:10','2026-11-11 14:26:10'),
(3,7,2,'hi','2026-11-11 14:26:30','2026-11-11 14:26:30'),
(4,12,2,'hihi','2026-11-11 14:26:48','2026-11-11 14:26:48'),
(5,13,3,'ok','2026-11-11 14:31:24','2026-11-11 14:31:24'),
(6,11,3,'hay','2026-11-11 14:31:39','2026-11-11 14:31:39'),
(7,15,3,'ok','2026-11-11 14:50:37','2026-11-11 14:50:37'),
(8,28,5,'huhu','2026-11-11 15:11:38','2026-11-11 15:11:38'),
(9,26,5,'bài viết hay quá','2026-11-11 15:12:03','2026-11-11 15:12:03'),
(10,21,5,'thật ý nghĩa','2026-11-11 15:12:26','2026-11-11 15:12:26'),
(11,14,5,'ok','2026-11-11 15:12:52','2026-11-11 15:12:52');

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

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

/*Data for the table `failed_jobs` */

/*Table structure for table `job_batches` */

DROP TABLE IF EXISTS `job_batches`;

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

/*Data for the table `job_batches` */

/*Table structure for table `jobs` */

DROP TABLE IF EXISTS `jobs`;

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `jobs` */

insert  into `jobs`(`id`,`queue`,`payload`,`attempts`,`reserved_at`,`available_at`,`created_at`) values 
(1,'default','{\"uuid\":\"161e3219-db0b-41bf-aa8f-f799197ecf97\",\"displayName\":\"App\\\\Mail\\\\NewCommentMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:23:\\\"App\\\\Mail\\\\NewCommentMail\\\":3:{s:7:\\\"comment\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Comment\\\";s:2:\\\"id\\\";i:2;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";s:18:\\\"Quản trị viên\\\";s:7:\\\"address\\\";s:17:\\\"admin@example.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\",\"batchId\":null},\"createdAt\":1794381971,\"delay\":null}',0,NULL,1794381972,1794381972),
(2,'default','{\"uuid\":\"83f93806-48b2-481c-adc3-f334c8cbd75e\",\"displayName\":\"App\\\\Mail\\\\NewCommentMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:23:\\\"App\\\\Mail\\\\NewCommentMail\\\":3:{s:7:\\\"comment\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Comment\\\";s:2:\\\"id\\\";i:3;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";s:18:\\\"Quản trị viên\\\";s:7:\\\"address\\\";s:17:\\\"admin@example.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\",\"batchId\":null},\"createdAt\":1794381990,\"delay\":null}',0,NULL,1794381990,1794381990),
(3,'default','{\"uuid\":\"ee67ad18-1bea-4f3f-9ae3-53c05de14f8d\",\"displayName\":\"App\\\\Mail\\\\NewCommentMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:23:\\\"App\\\\Mail\\\\NewCommentMail\\\":3:{s:7:\\\"comment\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Comment\\\";s:2:\\\"id\\\";i:5;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";s:20:\\\"Tạ Phương Thảo\\\";s:7:\\\"address\\\";s:14:\\\"thao@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\",\"batchId\":null},\"createdAt\":1794382284,\"delay\":null}',0,NULL,1794382284,1794382284),
(4,'default','{\"uuid\":\"40a9567a-bdb6-4b41-8136-925bd2185e15\",\"displayName\":\"App\\\\Mail\\\\NewCommentMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:23:\\\"App\\\\Mail\\\\NewCommentMail\\\":3:{s:7:\\\"comment\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Comment\\\";s:2:\\\"id\\\";i:6;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";s:20:\\\"Tạ Phương Thảo\\\";s:7:\\\"address\\\";s:14:\\\"thao@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\",\"batchId\":null},\"createdAt\":1794382299,\"delay\":null}',0,NULL,1794382299,1794382299),
(5,'default','{\"uuid\":\"14a9a0f0-6178-413d-864a-195ddc75cc38\",\"displayName\":\"App\\\\Mail\\\\NewCommentMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:23:\\\"App\\\\Mail\\\\NewCommentMail\\\":3:{s:7:\\\"comment\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Comment\\\";s:2:\\\"id\\\";i:10;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";s:11:\\\"Tình Kendy\\\";s:7:\\\"address\\\";s:14:\\\"tinh@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\",\"batchId\":null},\"createdAt\":1794384746,\"delay\":null}',0,NULL,1794384746,1794384746),
(6,'default','{\"uuid\":\"feac42cf-c6ac-4966-880a-0867a09cdfd4\",\"displayName\":\"App\\\\Mail\\\\NewCommentMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:23:\\\"App\\\\Mail\\\\NewCommentMail\\\":3:{s:7:\\\"comment\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Comment\\\";s:2:\\\"id\\\";i:11;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";s:9:\\\"Thu Trang\\\";s:7:\\\"address\\\";s:15:\\\"Trang@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\",\"batchId\":null},\"createdAt\":1794384772,\"delay\":null}',0,NULL,1794384772,1794384772);

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2026_11_07_143509_create_categories_table',1),
(5,'2026_11_07_143524_create_posts_table',1),
(6,'2026_11_07_143536_create_tags_table',1),
(7,'2026_11_07_144541_create_comments_table',1),
(8,'2026_11_07_144554_create_post_tag_table',1);

/*Table structure for table `password_reset_tokens` */

DROP TABLE IF EXISTS `password_reset_tokens`;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_reset_tokens` */

/*Table structure for table `post_tag` */

DROP TABLE IF EXISTS `post_tag`;

CREATE TABLE `post_tag` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL,
  `tag_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `post_tag_post_id_tag_id_unique` (`post_id`,`tag_id`),
  KEY `post_tag_tag_id_foreign` (`tag_id`),
  CONSTRAINT `post_tag_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `post_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `post_tag` */

insert  into `post_tag`(`id`,`post_id`,`tag_id`) values 
(9,4,1),
(8,4,4),
(7,4,5),
(11,5,6),
(10,5,7),
(12,6,5),
(14,6,6),
(13,6,7),
(15,7,7),
(16,7,8),
(18,8,1),
(20,8,2),
(19,8,3),
(17,8,5),
(23,9,4),
(21,9,5),
(22,9,7),
(25,10,6),
(24,10,7),
(26,11,6),
(27,11,8),
(28,12,7),
(29,12,8),
(32,13,1),
(34,13,2),
(33,13,3),
(31,13,4),
(30,13,7),
(37,14,1),
(36,14,4),
(35,14,5),
(39,15,4),
(40,15,6),
(38,15,7),
(41,16,7),
(42,16,8),
(44,17,2),
(43,17,3),
(47,18,2),
(46,18,4),
(45,18,5),
(49,19,4),
(48,19,5),
(50,19,6),
(53,20,4),
(51,20,5),
(52,20,7),
(54,21,4),
(55,22,4),
(56,23,5),
(57,23,7),
(58,24,5),
(59,24,7),
(60,25,5),
(61,25,7),
(62,25,8),
(63,26,8),
(65,27,6),
(64,27,7),
(66,28,5),
(67,28,8);

/*Table structure for table `posts` */

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `category_id` bigint(20) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `body` longtext NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'draft',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `posts_slug_unique` (`slug`),
  KEY `posts_user_id_foreign` (`user_id`),
  KEY `posts_category_id_foreign` (`category_id`),
  CONSTRAINT `posts_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `posts` */

insert  into `posts`(`id`,`user_id`,`category_id`,`title`,`slug`,`body`,`image`,`status`,`published_at`,`created_at`,`updated_at`,`deleted_at`) values 
(4,1,1,'Kinh nghiệm xử lý Soft Delete và tự động dọn dẹp Storage trong Laravel 11','kinh-nghiem-xu-ly-soft-delete-va-tu-dong-don-dep-storage-trong-laravel-11','Markdown\r\nChào mọi người, hôm nay mình muốn chia sẻ một chút kinh nghiệm thực tế về cách xử lý **Soft Delete** (xóa mềm) và tự động dọn dẹp file lưu trữ trong Laravel 11 – một vấn đề tưởng chừng đơn giản nhưng lại cực kỳ quan trọng khi xây dựng các ứng dụng web thực tế.\r\n\r\nTrong quá trình phát triển dự án, chắc hẳn anh em nào cũng từng gặp bài toán: Người dùng lỡ tay bấm xóa bài viết, sau đó muốn khôi phục lại. Hoặc khi xóa hẳn một bài viết (Force Delete), file ảnh đính kèm vẫn nằm chễm chệ trong folder `storage/app/public` gây rác hệ thống và lãng phí dung lượng server.\r\n\r\nHôm nay mình xin chia sẻ cách mình xử lý trọn gói vấn đề này trong dự án **Blog Cộng Đồng**.\r\n\r\n---\r\n\r\n## 1. Bật tính năng Soft Delete trong Migration & Model\r\n\r\nĐầu tiên, bạn bổ sung cột `deleted_at` vào bảng `posts` bằng migration:\r\n\r\n```php\r\nSchema::table(\'posts\', function (Blueprint $table) {$table->softDeletes();\r\n});\r\nTrong Model Post, nhớ use SoftDeletes nhé:\r\n\r\nPHP\r\nnamespace App\\Models;\r\n\r\nuse Illuminate\\Database\\Eloquent\\Model;\r\nuse Illuminate\\Database\\Eloquent\\SoftDeletes;\r\n\r\nclass Post extends Model\r\n{\r\n    use SoftDeletes;\r\n}\r\n2. Viết Controller xử lý Thùng rác & Xóa vĩnh viễn\r\nMột điểm cần lưu ý: Khi người dùng thực hiện Xóa vĩnh viễn (forceDelete), hãy luôn nhớ xóa kèm file ảnh đính kèm trong thư mục storage để dọn dẹp dung lượng server.\r\n\r\nDưới đây là đoạn code thực tế mình triển khai trong MyPostController:\r\n\r\nPHP\r\n// 1. Chuyển bài viết vào thùng rác\r\npublic function destroy(Post $post): RedirectResponse\r\n{\r\n    Gate::authorize(\'delete\', $post);\r\n\r\n    $post->delete();\r\n\r\n    return redirect()->route(\'my-posts.index\')\r\n        ->with(\'success\', \'Đã chuyển bài viết vào thùng rác.\');\r\n}\r\n\r\n// 2. Khôi phục bài viết từ thùng rác\r\npublic function restore(Request $request, int$id): RedirectResponse\r\n{\r\n    $post = Post::onlyTrashed()\r\n        ->where(\'user_id\', $request->user()->id)\r\n        ->findOrFail($id);\r\n\r\n    Gate::authorize(\'restore\', $post);\r\n\r\n    $post->restore();\r\n\r\n    return redirect()->route(\'my-posts.trash\')\r\n        ->with(\'success\', \'Đã khôi phục bài viết thành công.\');\r\n}\r\n\r\n// 3. Xóa vĩnh viễn bài viết + Dọn dẹp file ảnh đính kèm\r\npublic function forceDestroy(Request $request, int$id): RedirectResponse\r\n{\r\n    $post = Post::onlyTrashed()\r\n        ->where(\'user_id\', $request->user()->id)\r\n        ->findOrFail($id);\r\n\r\n    Gate::authorize(\'forceDelete\', $post);\r\n\r\n    // Kiểm tra và xóa file ảnh trong ổ đĩa nếu tồn tại\r\n    if ($post->image && Storage::disk(\'public\')->exists($post->image)) {\r\n        Storage::disk(\'public\')->delete($post->image);\r\n    }\r\n\r\n    $post->forceDelete();\r\n\r\n    return redirect()->route(\'my-posts.trash\')\r\n        ->with(\'success\', \'Đã xóa vĩnh viễn bài viết và ảnh đính kèm.\');\r\n}\r\n3. Viết Unit / Feature Test để đảm bảo code không lỗi\r\nLàm ứng dụng lớn mà không viết test thì rất dễ bị \"dội bom\" bug khi nâng cấp. Dưới đây là cách mình viết test cho tính năng thùng rác bằng php artisan test:\r\n\r\nPHP\r\npublic function test_author_can_move_post_to_trash(): void\r\n{\r\n    $user = User::factory()->create();\r\n    $post = Post::factory()->create([\'user_id\' =>$user->id]);\r\n\r\n    $this->actingAs($user)\r\n        ->delete(route(\'my-posts.destroy\', $post))\r\n        ->assertRedirect(route(\'my-posts.index\'));\r\n\r\n    $this->assertSoftDeleted($post);\r\n}\r\nLời kết\r\nViệc kết hợp Soft Delete + Policy phân quyền + Dọn dẹp Storage giúp dự án của bạn không chỉ an toàn hơn về dữ liệu mà còn cực kỳ tối ưu về bộ nhớ lưu trữ.\r\n\r\nHi vọng bài chia sẻ nhỏ này sẽ hữu ích với các bạn đang học và làm việc với Laravel. Nếu có thắc mắc hay cách tối ưu nào hay hơn, hãy cùng bình luận bên dưới để thảo luận nhé!','posts/iPkGjrwyCoKrMT9l7gqsagSq43FaGyvadcEjqeCX.webp','published','2026-11-11 13:52:18','2026-11-11 13:52:18','2026-11-11 13:53:15',NULL),
(5,1,2,'Cách cân bằng giữa công việc lập trình và chăm sóc sức khỏe bản thân','cach-can-bang-giua-cong-viec-lap-trinh-va-cham-soc-suc-khoe-ban-than','Ngồi máy tính nhiều giờ liền, thức khuya chạy deadline là tình trạng chung của nhiều Dân Công Nghệ. Dưới đây là những thói quen nhỏ giúp mình duy trì sức khỏe bền bỉ và tinh thần minh mẫn.\r\n\r\n---\r\n\r\n## 1. Quy tắc 20-20-20 bảo vệ mắt\r\n\r\nMỗi 20 phút làm việc, hãy nhìn ra xa 20 feet (khoảng 6m) trong vòng 20 giây. Thói quen này giúp mắt giảm bớt mệt mỏi đáng kể khi làm việc liên tục trước màn hình.\r\n\r\n---\r\n\r\n## 2. Vận động thể thao hàng ngày\r\n\r\nDành ít nhất 30 phút mỗi ngày để chơi các môn thể thao vận động linh hoạt như **Cầu lông**, chạy bộ hoặc tập workout tại nhà. Vận động giúp giải phóng endorphin, giảm căng thẳng sau những giờ debug mệt mỏi.\r\n\r\n---\r\n\r\n## Lời kết\r\n\r\nSức khỏe chính là tài sản lớn nhất của Dev. Hãy chăm sóc bản thân thật tốt để đi được đường dài với nghề nhé!','posts/CLcMC4rrusLXrEbPZgDsFUrMiMMTWlYqI2qpFfQy.jpg','published','2026-11-11 13:58:06','2026-11-11 13:58:06','2026-11-11 13:58:06',NULL),
(6,1,4,'Bí quyết làm Pate gà rau củ thơm ngon, chuẩn vị tại nhà','bi-quyet-lam-pate-ga-rau-cu-thom-ngon-chuan-vi-tai-nha','Pate là món ăn kèm quen thuộc và rất giàu dinh dưỡng. Hôm nay mình xin chia sẻ công thức làm pate đơn giản từ ức gà và các loại rau củ tự nhiên, vừa thơm ngon vừa đảm bảo an toàn vệ sinh.\r\n\r\n---\r\n\r\n## Nguyên liệu chuẩn bị\r\n\r\n* Ức gà tươi: 500g\r\n* Gan gà: 200g\r\n* Cà rốt & Bí đỏ: 100g (thái hạt lựu)\r\n* Gia vị: Hành khô, tỏi, tiêu, nước mắm, một chút dầu ăn.\r\n\r\n---\r\n\r\n## Hướng dẫn thực hiện\r\n\r\n1. **Sơ chế**: Sơ chế sạch gan và ức gà, ngâm qua sữa tươi không đường để khử mùi hôi.\r\n2. **Xào nhân**: Phi thơm hành tỏi, cho gà, gan và rau củ vào xào chín tới.\r\n3. **Xay & Hấp**: Cho hỗn hợp vào máy xay nhuyễn rồi đem hấp cách thủy trong khoảng 45 - 60 phút.\r\n\r\nThành phẩm pate thơm phức, ngậy nhẹ và rất đưa cơm!','posts/465yBC9LRKiybZmv4w0U0cYBGEMMvV7guNiSy7nG.jpg','published','2026-11-11 13:59:34','2026-11-11 13:59:34','2026-11-11 13:59:34',NULL),
(7,1,3,'Hành trình chinh phục đỉnh Yên Tử - Trải nghiệm trekking đáng nhớ','hanh-trinh-chinh-phuc-dinh-yen-tu-trai-nghiem-trekking-dang-nho','Yên Tử (Quảng Ninh) không chỉ là trung tâm Phật giáo lớn mà còn là điểm đến lý tưởng cho những ai yêu thích leo núi trekking và hòa mình vào thiên nhiên hùng vĩ.\r\n\r\n---\r\n\r\n## Trải nghiệm tuyến đường bộ 6km\r\n\r\nThay vì đi cáp treo, mình chọn thử thách bản thân bằng tuyến đường leo bộ dài 6km qua hàng ngàn bậc đá cổ kính. Cảm giác bước đi dưới bóng mát của những hàng tùng hàng trúc hàng trăm năm tuổi cực kỳ thư thái.\r\n\r\n---\r\n\r\n## Những lưu ý khi đi leo núi Yên Tử\r\n\r\n* **Trang phục**: Chuẩn bị giày thể thao ma sát tốt, quần áo co giãn thoải mái.\r\n* **Đồ dùng**: Mang theo gậy leo núi, nước uống và một ít đồ ăn nhẹ để nạp năng lượng dọc đường.\r\n\r\nChinh phục tới Chùa Đồng trên đỉnh núi ở độ cao 1.068m thực sự là một cảm giác vỡ òa và tuyệt vời!','posts/QUQuq3ijqtmUQG5NNkNWQW3lZ272WKgmNmISEIAo.jpg','published','2026-11-11 14:01:36','2026-11-11 14:01:36','2026-11-11 14:01:36',NULL),
(8,1,1,'Hướng dẫn tạo môi trường Lập trình PHP & MySQL chuẩn với Docker','huong-dan-tao-moi-truong-lap-trinh-php-mysql-chuan-voi-docker','Việc thiết lập môi trường phát triển (Development Environment) đồng nhất giữa các thành viên trong team luôn là bài toán đau đầu. Sử dụng Docker giúp bạn đóng gói PHP, MySQL, Nginx chỉ với một lệnh duy nhất.\r\n\r\n---\r\n\r\n## 1. Cấu hình tệp docker-compose.yml\r\n\r\nTạo file `docker-compose.yml` ở thư mục gốc dự án:\r\n\r\n```yaml\r\nversion: \'3.8\'\r\nservices:\r\n  app:\r\n    build:\r\n      context: .\r\n      dockerfile: Dockerfile\r\n    image: laravel-app\r\n    ports:\r\n      - \"9000:9000\"\r\n    volumes:\r\n      - .:/var/www\r\n\r\n  db:\r\n    image: mysql:8.0\r\n    environment:\r\n      MYSQL_DATABASE: blog_db\r\n      MYSQL_ROOT_PASSWORD: root\r\n    ports:\r\n      - \"3306:3306\"','posts/elepxVyszLF0r96OJwH9UHXOcPcsDutE2zDp0mm8.webp','published','2026-11-11 14:03:54','2026-11-11 14:03:54','2026-11-11 14:03:54',NULL),
(9,2,5,'Kinh nghiệm chuẩn bị và làm bài thi TOFAS Programming đạt điểm cao','kinh-nghiem-chuan-bi-va-lam-bai-thi-tofas-programming-dat-diem-cao','Kỳ thi đánh giá năng lực lập trình quốc tế TOFAS là cơ hội tuyệt vời để sinh viên và lập trình viên rèn luyện tư duy thuật toán cũng như kỹ năng giải quyết vấn đề.\r\n\r\n---\r\n\r\n## 1. Ôn tập kỹ thuật toán và cấu trúc dữ liệu nền tảng\r\n\r\n* Nắm vững các kiểu dữ liệu, vòng lặp và câu lệnh điều kiện.\r\n* Luyện tập kỹ năng xử lý mảng (Array), chuỗi (String) và các bài toán logic toán học cơ bản.\r\n\r\n---\r\n\r\n## 2. Quản lý thời gian làm bài hiệu quả\r\n\r\n* Đọc lướt qua toàn bộ đề thi để làm những bài dễ trước.\r\n* Kiểm tra kỹ các trường hợp biên (Edge Cases) như mảng rỗng, số âm hoặc giá trị `null` để không bị mất điểm đáng tiếc.\r\n\r\n---\r\n\r\n## Lời kết\r\n\r\nBản lĩnh và sự cẩn thận chính là chìa khóa giúp bạn chinh phục chứng chỉ TOFAS thành công!','posts/EEBmTxgRyn1Bhla6lob3nyUcCHc4NM0BKh4k0JHn.jpg','published','2026-11-11 14:07:47','2026-11-11 14:07:47','2026-11-11 14:09:21',NULL),
(10,2,2,'Bí quyết chăm sóc và huấn luyện mèo cưng cho người mới bắt đầu','bi-quyet-cham-soc-va-huan-luyen-meo-cung-cho-nguoi-moi-bat-dau','Nuôi mèo đem lại rất nhiều niềm vui và giúp giảm căng thẳng sau giờ làm việc. Tuy nhiên, chăm sóc mèo đúng cách đòi hỏi sự kiên nhẫn và khoa học.\r\n\r\n---\r\n\r\n## 1. Tự chế biến Pate tươi dinh dưỡng\r\n\r\nThay vì dùng đồ đóng hộp chứa nhiều chất bảo quản, bạn có thể tự làm pate gà kết hợp cà rốt, bí đỏ và gan gà. Món ăn này vừa giàu đạm lại giúp mèo mượt lông hơn.\r\n\r\n---\r\n\r\n## 2. Huấn luyện mèo đi vệ sinh đúng chỗ\r\n\r\n* Đặt khay cát ở nơi yên tĩnh, ít người qua lại.\r\n* Sử dụng loại cát tạo mùi thơm dễ chịu và sử dụng thảm hứng cát ở ngoài khay để giữ nhà cửa luôn sạch sẽ.\r\n\r\n---\r\n\r\n## Lời kết\r\n\r\nHãy dành thời gian chơi đùa và quan sát biểu hiện sức khỏe của bé mèo hàng ngày bạn nhé!','posts/kAgqo9GtrhW2zShtAyQ9O0rj9cFlJrqDcQpfifeH.jpg','published','2026-11-11 14:09:00','2026-11-11 14:09:00','2026-11-11 14:09:00',NULL),
(11,2,4,'Gợi ý thực đơn tăng cân lành mạnh dành cho người gầy','goi-y-thuc-don-tang-can-lanh-manh-danh-cho-nguoi-gay','Tăng cân an toàn không phải là ăn thật nhiều đồ mỡ hay thức ăn nhanh, mà là cung cấp đủ lượng Calo dư thừa (Caloric Surplus) từ các nguồn dinh dưỡng chất lượng.\r\n\r\n---\r\n\r\n## 1. Phân chia 5 - 6 bữa ăn nhỏ trong ngày\r\n\r\nBên cạnh 3 bữa chính, hãy bổ sung thêm 2 - 3 bữa phụ với các thực phẩm giàu năng lượng như: chuối, sữa tươi, bơ đậu phộng và các loại hạt dinh dưỡng.\r\n\r\n---\r\n\r\n## 2. Kết hợp Mass Gainer và vận động thể thao\r\n\r\n* Uống Mass Gainer bổ sung Calo giữa các bữa ăn.\r\n* Kết hợp đi bộ hoặc tập luyện các bài tập bodyweight nhẹ nhàng để kích thích tiêu hóa và xây dựng cơ bắp thay vì tích mỡ.\r\n\r\n---\r\n\r\n## Lời kết\r\n\r\nKiên trì theo đuổi chế độ ăn uống lành mạnh sẽ giúp bạn nhanh chóng đạt được mốc cân nặng mong muốn!','posts/AXr8ACf2zCqhfFF0Xc4EJyFXVzDQ72xXyD4qp6hQ.jpg','published','2026-11-11 14:10:06','2026-11-11 14:10:06','2026-11-11 14:10:06',NULL),
(12,2,3,'Kinh nghiệm phượt xe máy an toàn và bảo dưỡng xe trước chuyến đi xa','kinh-nghiem-phuot-xe-may-an-toan-va-bao-duong-xe-truoc-chuyen-di-xa','Những chuyến đi phượt bằng xe máy mang lại trải nghiệm tự do tuyệt vời. Tuy nhiên, để có một chuyến đi an toàn trọn vẹn, công tác chuẩn bị xe cộ là quan trọng nhất.\r\n\r\n---\r\n\r\n## 1. Bảo dưỡng xe máy trước khi lên đường\r\n\r\n* **Thay nhớt**: Thay nhớt máy và nhớt láp (đối với xe tay ga như Honda Vision) nếu đã đi được trên 1.500km.\r\n* **Lốp & Phanh**: Kiểm tra độ mòn của lốp xe, căn chỉnh áp suất lốp và kiểm tra má phanh trước/sau.\r\n\r\n---\r\n\r\n## 2. Trang bị bảo hộ cá nhân\r\n\r\nĐừng quên chuẩn bị mũ bảo hiểm đạt chuẩn, giáp bảo vệ tay chân, áo mưa bộ và một hộp dụng cụ sửa xe cơ bản phòng trường hợp sự cố giữa đường.\r\n\r\n---\r\n\r\n## Lời kết\r\n\r\nChúc các bạn có những chuyến hành trình an toàn và gặt hái thật nhiều trải nghiệm đẹp!','posts/IafA3AnY8Xu3l2MOHXBPt90QWHbAXqffUk0Yd8zG.jpg','published','2026-11-11 14:13:49','2026-11-11 14:13:49','2026-11-11 14:15:03',NULL),
(13,2,1,'Tối ưu hóa cơ sở dữ liệu MySQL với Indexing trong Laravel','toi-uu-hoa-co-so-du-lieu-mysql-voi-indexing-trong-laravel','Khi cơ sở dữ liệu của bạn phình to lên hàng trăm ngàn bản ghi, các truy vấn như `WHERE`, `ORDER BY` hoặc `JOIN` nếu không được đánh chỉ mục (Index) sẽ dẫn đến tình trạng quét toàn bộ bảng (Full Table Scan), gây nghẽn hệ thống.\r\n\r\n---\r\n\r\n## 1. Thêm Index thông qua Laravel Migration\r\n\r\nBạn có thể dễ dàng thêm Index cho các cột thường xuyên tìm kiếm hoặc làm khóa ngoại:\r\n\r\n```php\r\nSchema::table(\'posts\', function (Blueprint $table) {\r\n    // Đánh index cho cột slug và status\r\n    $table->index(\'slug\');$table->index(\'status\');\r\n    \r\n    // Index kết hợp (Composite Index) cho các truy vấn lọc nhiều điều kiện\r\n    $table->index([\'category_id\', \'status\', \'published_at\']);\r\n});','posts/uF7I6RX1Sh9RgET4eA9aCzBtMo6rXFecOCVhsgTT.jpg','published','2026-11-11 14:28:30','2026-11-11 14:28:31','2026-11-11 14:30:33',NULL),
(14,3,1,'Hướng dẫn tích hợp Tailwind CSS và Vite vào dự án Laravel 11','huong-dan-tich-hop-tailwind-css-va-vite-vao-du-an-laravel-11','Tailwind CSS kết hợp cùng Vite mang lại tốc độ biên dịch asset siêu nhanh và trải nghiệm phát triển tuyệt vời cho các lập trình viên Laravel.\r\n\r\n---\r\n\r\n## 1. Cài đặt Tailwind CSS qua npm\r\n\r\nChạy lệnh cài đặt các gói cần thiết trong Terminal:\r\n\r\n```bash\r\nnpm install -D tailwindcss postcss autoprefixer\r\nnpx tailwindcss init -p\r\n2. Cấu hình tệp tailwind.config.js\r\nKhai báo các đường dẫn chứa giao diện Blade để Tailwind quét class:\r\n\r\nJavaScript\r\nexport default {\r\n  content: [\r\n    \"./resources/**/*.blade.php\",\r\n    \"./resources/**/*.js\",\r\n    \"./resources/**/*.vue\",\r\n  ],\r\n  theme: {\r\n    extend: {},\r\n  },\r\n  plugins: [],\r\n}\r\n3. Khai báo vào Blade Template\r\nThêm directive @vite vào phần <head> của ứng dụng:\r\n\r\nHTML\r\n@vite([\'resources/css/app.css\', \'resources/js/app.js\'])\r\nSau đó chỉ cần chạy npm run dev để bắt đầu xây dựng giao diện!\r\n\r\n\r\n---','posts/0eu5oQXBBiNsKrXuGFnwyemMmMoLmStveot6IxiC.webp','published','2026-11-11 14:35:55','2026-11-11 14:35:55','2026-11-11 14:42:25',NULL),
(15,3,1,'Tối ưu hóa hiệu năng ứng dụng Laravel: Từ Eager Loading đến Caching thực tế','toi-uu-hoa-hieu-nang-ung-dung-laravel-tu-eager-loading-den-caching-thuc-te','Trong quá trình phát triển ứng dụng web với **Laravel**, khi số lượng bài viết và người dùng tăng lên, ứng dụng rất dễ rơi vào tình trạng phản hồi chậm nếu không được tối ưu truy vấn database đúng cách.\r\n\r\nBài viết này mình sẽ tổng hợp 3 kỹ thuật quan trọng nhất giúp ứng dụng Laravel của bạn chạy mượt mà và chịu tải tốt hơn.\r\n\r\n---\r\n\r\n## 1. Giải quyết triệt để vấn đề N+1 Query\r\n\r\nLỗi **N+1 Query** là nguyên nhân hàng đầu làm chậm ứng dụng Laravel. Lỗi này xảy ra khi bạn duyệt một danh sách dữ liệu và truy xuất mối quan hệ (Relationship) inside vòng lặp.\r\n\r\n### Code chưa tối ưu:\r\n```php\r\n// Tạo ra 1 query lấy posts + N query lấy tác giả cho từng bài viết\r\n$posts = Post::latest()->get();\r\n\r\nforeach ($posts as$post) {\r\n    echo $post->user->name; // Gọi query liên tục\r\n}\r\nCách khắc phục với Eager Loading:\r\nPHP\r\n// Chỉ thực thi đúng 2 câu query SQL duy nhất\r\n$posts = Post::with([\'user\', \'category\'])->latest()->paginate(10);\r\n2. Sử dụng Query Scope để tái sử dụng mã nguồn\r\nThay vì viết đi viết lại các điều kiện where ở nhiều Controller khác nhau, hãy đóng gói chúng vào Local Scope trong Model.\r\n\r\nMở Model App\\Models\\Post và bổ sung:\r\n\r\nPHP\r\nnamespace App\\Models;\r\n\r\nuse Illuminate\\Database\\Eloquent\\Builder;\r\nuse Illuminate\\Database\\Eloquent\\Model;\r\n\r\nclass Post extends Model\r\n{\r\n    // Scope lọc các bài viết đã xuất bản\r\n    public function scopePublished(Builder $query): Builder\r\n    {\r\n        return $query->where(\'status\', \'published\')\r\n                     ->where(\'published_at\', \'<=\', now());\r\n    }\r\n\r\n    // Scope tìm kiếm theo từ khóa\r\n    public function scopeSearch(Builder $query, ?string $keyword): Builder\r\n    {\r\n        return $query->when($keyword, function ($q) use ($keyword) {\r\n            $q->where(\'title\', \'like\', \"\\%{$keyword}%\");\r\n        });\r\n    }\r\n}\r\nNhờ đó, tại PostController bạn chỉ cần gọi gọn gàng:\r\n\r\nPHP\r\n$posts = Post::query()\r\n    ->published()\r\n    ->search($request->query(\'search\'))\r\n    ->with([\'user\', \'category\'])\r\n    ->latest()\r\n    ->paginate(12);\r\n3. Tận dụng Caching cho dữ liệu ít biến động\r\nĐối với các dữ liệu như Danh mục (Categories) hay Thẻ (Tags) - vốn ít khi thay đổi nhưng lại được gọi liên tục ở mọi trang, hãy lưu chúng vào bộ nhớ đệm Cache:\r\n\r\nPHP\r\nuse Illuminate\\Support\\Facades\\Cache;\r\n\r\n$categories = Cache::remember(\'categories_list\', 86400, function () {\r\n    return Category::orderBy(\'name\')->get();\r\n});\r\nLời kết\r\nViệc áp dụng kết hợp Eager Loading, Query Scope và Cache sẽ giúp bạn tiết kiệm đáng kể tài nguyên server, giảm thời gian phản hồi trang (Response Time) từ hàng trăm millisecond xuống chỉ còn vài millisecond.\r\n\r\nChúc các bạn áp dụng thành công vào dự án của mình!','posts/4sscRgJvFsG6dsiZl9XE6casHnlTYsiWHDCoh6C1.webp','published','2026-11-11 14:47:36','2026-11-11 14:47:36','2026-11-11 14:47:36',NULL),
(16,3,1,'Laravel là gì? Vì sao nên sử dụng Laravel để phát triển website?','laravel-la-gi-vi-sao-nen-su-dung-laravel-de-phat-trien-website','# Laravel là gì? Vì sao nên sử dụng Laravel để phát triển website?\r\n\r\nLaravel là một framework mã nguồn mở được xây dựng trên ngôn ngữ PHP, giúp lập trình viên phát triển website nhanh chóng, dễ quản lý và có cấu trúc rõ ràng.\r\n\r\n## 1. Laravel là gì?\r\n\r\nLaravel cung cấp nhiều công cụ hỗ trợ lập trình web như định tuyến (Routing), quản lý cơ sở dữ liệu (Database), xác thực người dùng (Authentication) và xử lý biểu mẫu.\r\n\r\nFramework này sử dụng kiến trúc MVC (Model - View - Controller), giúp phân chia rõ ràng giữa dữ liệu, giao diện và logic xử lý.\r\n\r\n## 2. Những ưu điểm nổi bật của Laravel\r\n\r\n- **Dễ sử dụng:** Cấu trúc code rõ ràng, dễ học và dễ bảo trì.\r\n- **Bảo mật tốt:** Hỗ trợ chống SQL Injection, CSRF và nhiều nguy cơ bảo mật khác.\r\n- **Tiết kiệm thời gian:** Có sẵn nhiều thư viện và chức năng hỗ trợ.\r\n- **Quản lý database:** Hỗ trợ Migration, Eloquent ORM và Query Builder.\r\n- **Mở rộng linh hoạt:** Phù hợp với nhiều loại dự án từ nhỏ đến lớn.\r\n\r\n## 3. Laravel phù hợp với những dự án nào?\r\n\r\nLaravel có thể được sử dụng để xây dựng nhiều loại ứng dụng như:\r\n\r\n- Website tin tức và blog cá nhân.\r\n- Website bán hàng trực tuyến.\r\n- Hệ thống quản lý sinh viên.\r\n- Website quản lý nội dung (CMS).\r\n- Các hệ thống quản lý nội bộ doanh nghiệp.\r\n\r\n## 4. Kết luận\r\n\r\nLaravel là một lựa chọn đáng cân nhắc đối với những người muốn phát triển website bằng PHP. Với hệ sinh thái phong phú, khả năng bảo mật và cấu trúc rõ ràng, Laravel giúp quá trình xây dựng và phát triển ứng dụng web trở nên hiệu quả hơn.\r\n\r\nNếu đang học lập trình web, bạn có thể bắt đầu với Laravel thông qua những dự án nhỏ như website blog hoặc hệ thống quản lý thông tin.','posts/V7HaOMu16khOKquMAjxMaxSvA6vG0qFGkAQ5uBGC.webp','published','2026-11-11 14:53:52','2026-11-11 14:53:52','2026-11-11 14:53:52',NULL),
(17,3,1,'MySQL là gì? Những kiến thức cơ bản dành cho người mới bắt đầu','mysql-la-gi-nhung-kien-thuc-co-ban-danh-cho-nguoi-moi-bat-dau','# MySQL là gì? Những kiến thức cơ bản dành cho người mới bắt đầu\r\n\r\nMySQL là một hệ quản trị cơ sở dữ liệu quan hệ (RDBMS) được sử dụng phổ biến trong phát triển website và ứng dụng. Công cụ này giúp lưu trữ, quản lý và truy xuất dữ liệu một cách hiệu quả.\r\n\r\n## 1. MySQL là gì?\r\n\r\nMySQL sử dụng ngôn ngữ SQL (Structured Query Language) để thao tác với dữ liệu. Thông tin được tổ chức thành các bảng gồm hàng và cột, giúp việc quản lý trở nên khoa học và dễ dàng.\r\n\r\nVí dụ, một website bán hàng có thể sử dụng MySQL để lưu trữ:\r\n\r\n- Thông tin khách hàng.\r\n- Danh sách sản phẩm.\r\n- Đơn hàng.\r\n- Thông tin thanh toán.\r\n- Tài khoản người dùng.\r\n\r\n## 2. Những câu lệnh MySQL cơ bản\r\n\r\nDưới đây là một số câu lệnh thường gặp:\r\n\r\n**Tạo cơ sở dữ liệu:**\r\n\r\n```sql\r\nCREATE DATABASE blog_db;\r\n```\r\n\r\n**Tạo bảng người dùng:**\r\n\r\n```sql\r\nCREATE TABLE users (\r\n    id INT AUTO_INCREMENT PRIMARY KEY,\r\n    name VARCHAR(100),\r\n    email VARCHAR(150)\r\n);\r\n```\r\n\r\n**Thêm dữ liệu:**\r\n\r\n```sql\r\nINSERT INTO users (name, email)\r\nVALUES (\'Nguyen Van A\', \'a@gmail.com\');\r\n```\r\n\r\n**Hiển thị dữ liệu:**\r\n\r\n```sql\r\nSELECT * FROM users;\r\n```\r\n\r\n**Cập nhật dữ liệu:**\r\n\r\n```sql\r\nUPDATE users\r\nSET name = \'Tran Van B\'\r\nWHERE id = 1;\r\n```\r\n\r\n## 3. Ưu điểm của MySQL\r\n\r\n- Miễn phí với phiên bản Community.\r\n- Tốc độ truy vấn tốt.\r\n- Dễ dàng tích hợp với PHP và Laravel.\r\n- Có khả năng xử lý lượng dữ liệu lớn.\r\n- Hỗ trợ nhiều công cụ quản lý trực quan như phpMyAdmin.\r\n\r\n## 4. MySQL được sử dụng ở đâu?\r\n\r\nMySQL thường được sử dụng trong các website thương mại điện tử, blog, diễn đàn, hệ thống quản lý và nhiều ứng dụng web khác.\r\n\r\nĐặc biệt, MySQL kết hợp với Laravel giúp lập trình viên xây dựng hệ thống quản lý dữ liệu nhanh chóng và thuận tiện.\r\n\r\n## 5. Kết luận\r\n\r\nMySQL là một công cụ quan trọng mà bất kỳ ai học lập trình web cũng nên tìm hiểu. Việc nắm vững các câu lệnh SQL cơ bản sẽ giúp bạn dễ dàng làm việc với cơ sở dữ liệu và phát triển những ứng dụng thực tế.','posts/OCWg4OquQOlXaQCDgYVHJpQlXvfxnksHs5moP2Gs.jpg','published','2026-11-11 14:55:02','2026-11-11 14:55:02','2026-11-11 14:55:02',NULL),
(18,3,1,'PHP là gì? Tìm hiểu ngôn ngữ lập trình web phổ biến','php-la-gi-tim-hieu-ngon-ngu-lap-trinh-web-pho-bien','# PHP là gì? Tìm hiểu ngôn ngữ lập trình web phổ biến\r\n\r\nPHP là một ngôn ngữ lập trình phía máy chủ (Server-side) được sử dụng rộng rãi trong phát triển website. PHP giúp xử lý dữ liệu, quản lý tài khoản và kết nối với cơ sở dữ liệu để tạo ra những trang web có tính tương tác.\r\n\r\n## 1. PHP là gì?\r\n\r\nPHP (Hypertext Preprocessor) là ngôn ngữ lập trình mã nguồn mở, được thiết kế chuyên biệt cho phát triển ứng dụng web.\r\n\r\nKhác với HTML và CSS chủ yếu dùng để xây dựng giao diện, PHP có thể xử lý các yêu cầu từ người dùng, truy vấn database và trả về nội dung phù hợp.\r\n\r\n## 2. PHP hoạt động như thế nào?\r\n\r\nQuy trình hoạt động cơ bản của PHP gồm:\r\n\r\n1. Người dùng truy cập một trang web.\r\n2. Trình duyệt gửi yêu cầu đến máy chủ.\r\n3. Máy chủ thực thi mã PHP.\r\n4. PHP xử lý dữ liệu hoặc truy vấn cơ sở dữ liệu.\r\n5. Máy chủ trả kết quả HTML về trình duyệt.\r\n\r\nNgười dùng thông thường chỉ nhìn thấy kết quả được hiển thị trên trình duyệt, không nhìn thấy mã PHP phía máy chủ.\r\n\r\n## 3. Ví dụ về một đoạn code PHP\r\n\r\n```php\r\n<?php\r\n$name = \"Tình\";\r\n\r\necho \"Xin chào \" . $name . \"!\";\r\n?>\r\n```\r\n\r\nKết quả hiển thị:\r\n\r\n```text\r\nXin chào Tình!\r\n```\r\n\r\nĐây là ví dụ đơn giản về cách khai báo biến và xuất dữ liệu trong PHP.\r\n\r\n## 4. Ưu điểm của PHP\r\n\r\n- Dễ học đối với người mới bắt đầu.\r\n- Có cộng đồng lập trình viên lớn.\r\n- Hỗ trợ nhiều hệ quản trị cơ sở dữ liệu như MySQL.\r\n- Có nhiều framework hỗ trợ như Laravel.\r\n- Có thể triển khai trên nhiều hệ điều hành và máy chủ khác nhau.\r\n\r\n## 5. PHP được ứng dụng trong thực tế\r\n\r\nPHP được sử dụng để phát triển website tin tức, blog cá nhân, cửa hàng trực tuyến, hệ thống quản lý và nhiều ứng dụng web khác.\r\n\r\nĐặc biệt, khi kết hợp PHP với MySQL và Laravel, lập trình viên có thể xây dựng những hệ thống website có cấu trúc rõ ràng, dễ mở rộng và bảo trì.\r\n\r\n## 6. Kết luận\r\n\r\nPHP vẫn là một ngôn ngữ đáng học trong lĩnh vực phát triển web. Nếu bạn đang bắt đầu học lập trình website, việc nắm vững PHP sẽ tạo nền tảng tốt trước khi tiếp cận các framework hiện đại như Laravel.','posts/JcxrQbQnLrLn2i5jyzw8WOxwvoYBBS3KYRxlxFSg.webp','published','2026-11-11 14:56:25','2026-11-11 14:56:25','2026-11-11 14:56:25',NULL),
(19,4,1,'HTML và CSS là gì? Nền tảng quan trọng khi thiết kế website','html-va-css-la-gi-nen-tang-quan-trong-khi-thiet-ke-website','# HTML và CSS là gì? Nền tảng quan trọng khi thiết kế website\r\n\r\nHTML và CSS là hai công nghệ cơ bản trong lĩnh vực phát triển website. Nếu HTML giúp xây dựng cấu trúc nội dung thì CSS chịu trách nhiệm thiết kế giao diện, màu sắc và bố cục trang web.\r\n\r\n## 1. HTML là gì?\r\n\r\nHTML (HyperText Markup Language) là ngôn ngữ đánh dấu siêu văn bản, được sử dụng để tạo cấu trúc cho trang web.\r\n\r\nHTML giúp xác định các thành phần như:\r\n\r\n- Tiêu đề và đoạn văn.\r\n- Hình ảnh và video.\r\n- Liên kết giữa các trang.\r\n- Bảng dữ liệu.\r\n- Biểu mẫu nhập thông tin.\r\n\r\nVí dụ một đoạn HTML đơn giản:\r\n\r\n```html\r\n<!DOCTYPE html>\r\n<html>\r\n<head>\r\n    <title>Website của tôi</title>\r\n</head>\r\n<body>\r\n    <h1>Xin chào!</h1>\r\n    <p>Đây là website đầu tiên của tôi.</p>\r\n</body>\r\n</html>\r\n```\r\n\r\n## 2. CSS là gì?\r\n\r\nCSS (Cascading Style Sheets) là ngôn ngữ định kiểu được sử dụng để thiết kế giao diện website.\r\n\r\nCSS cho phép thay đổi màu sắc, kích thước chữ, khoảng cách, đường viền và cách sắp xếp các thành phần trên trang web.\r\n\r\nVí dụ:\r\n\r\n```css\r\nbody {\r\n    background-color: #f5f5f5;\r\n    font-family: Arial, sans-serif;\r\n}\r\n\r\nh1 {\r\n    color: blue;\r\n    text-align: center;\r\n}\r\n\r\np {\r\n    font-size: 16px;\r\n    color: #333;\r\n}\r\n```\r\n\r\n## 3. Sự khác nhau giữa HTML và CSS\r\n\r\nHTML và CSS có chức năng khác nhau nhưng luôn phối hợp với nhau trong quá trình xây dựng website.\r\n\r\n- HTML tạo cấu trúc và nội dung.\r\n- CSS quyết định cách hiển thị và trang trí giao diện.\r\n\r\nCó thể hiểu đơn giản: HTML giống như bộ khung của một ngôi nhà, còn CSS giống như phần trang trí nội thất và màu sắc.\r\n\r\n## 4. Vì sao cần học HTML và CSS?\r\n\r\nĐây là hai kiến thức nền tảng mà người học lập trình web cần nắm vững.\r\n\r\nKhi thành thạo HTML và CSS, bạn có thể tự xây dựng giao diện website, thiết kế trang giới thiệu cá nhân hoặc tạo bố cục cho các hệ thống quản lý.\r\n\r\n## 5. Kết luận\r\n\r\nHTML và CSS là bước khởi đầu quan trọng để trở thành lập trình viên Front-end. Kết hợp thêm JavaScript, bạn có thể xây dựng những website có giao diện đẹp mắt và nhiều tính năng tương tác hơn.','posts/7NGlyD85d5xLTGditIJyk0WuLLUkZ7sbnspAg1LV.jpg','published','2026-11-11 14:58:09','2026-11-11 14:58:09','2026-11-11 14:58:09',NULL),
(20,4,1,'JavaScript là gì? Vai trò của JavaScript trong phát triển website','javascript-la-gi-vai-tro-cua-javascript-trong-phat-trien-website','# JavaScript là gì? Vai trò của JavaScript trong phát triển website\r\n\r\nJavaScript là một trong những ngôn ngữ lập trình phổ biến nhất hiện nay, đặc biệt trong lĩnh vực phát triển website. Ngôn ngữ này giúp trang web trở nên sinh động, có khả năng tương tác và xử lý các thao tác của người dùng.\r\n\r\n## 1. JavaScript là gì?\r\n\r\nJavaScript là ngôn ngữ lập trình thường được sử dụng ở phía trình duyệt (Client-side). Nó cho phép lập trình viên xây dựng các chức năng tương tác như kiểm tra biểu mẫu, tạo hiệu ứng, cập nhật nội dung và xử lý sự kiện.\r\n\r\nHiện nay, JavaScript còn có thể chạy phía máy chủ thông qua môi trường Node.js.\r\n\r\n## 2. JavaScript có thể làm được gì?\r\n\r\nMột số ứng dụng phổ biến của JavaScript gồm:\r\n\r\n- Kiểm tra dữ liệu người dùng nhập vào biểu mẫu.\r\n- Tạo menu và hiệu ứng chuyển động.\r\n- Xây dựng chức năng tìm kiếm.\r\n- Cập nhật nội dung mà không cần tải lại trang.\r\n- Xây dựng ứng dụng web tương tác.\r\n\r\n## 3. Ví dụ về JavaScript cơ bản\r\n\r\nĐoạn code dưới đây tạo một nút bấm hiển thị thông báo khi người dùng nhấn vào.\r\n\r\n```html\r\n<!DOCTYPE html>\r\n<html>\r\n<body>\r\n\r\n<button onclick=\"sayHello()\">Nhấn vào đây</button>\r\n\r\n<script>\r\nfunction sayHello() {\r\n    alert(\"Xin chào! Chào mừng bạn đến website.\");\r\n}\r\n</script>\r\n\r\n</body>\r\n</html>\r\n```\r\n\r\nĐây là ví dụ đơn giản cho thấy JavaScript có thể phản hồi trực tiếp với thao tác của người dùng.\r\n\r\n## 4. JavaScript kết hợp với HTML và CSS\r\n\r\nBa công nghệ này thường được sử dụng cùng nhau để xây dựng giao diện website:\r\n\r\n- HTML: Xây dựng cấu trúc nội dung.\r\n- CSS: Thiết kế giao diện và bố cục.\r\n- JavaScript: Xử lý logic và tạo tương tác.\r\n\r\nSự kết hợp này tạo nên nền tảng quan trọng trong phát triển Front-end.\r\n\r\n## 5. Các công nghệ phổ biến sử dụng JavaScript\r\n\r\nJavaScript có hệ sinh thái rất phong phú với nhiều thư viện và framework như:\r\n\r\n- React: Xây dựng giao diện người dùng.\r\n- Vue.js: Phát triển ứng dụng web linh hoạt.\r\n- Angular: Xây dựng ứng dụng web quy mô lớn.\r\n- Node.js: Chạy JavaScript phía máy chủ.\r\n\r\n## 6. Kết luận\r\n\r\nJavaScript là kiến thức quan trọng đối với những người muốn theo đuổi lĩnh vực lập trình web. Việc nắm vững ngôn ngữ này sẽ giúp bạn có thêm nhiều cơ hội tiếp cận các công nghệ phát triển website hiện đại.','posts/0eb0nAp5rllGJpq1OAL4M5fCP7dOxg1vae5ARQaC.jpg','published','2026-11-11 14:59:16','2026-11-11 14:59:16','2026-11-11 14:59:16',NULL),
(21,4,1,'Git và GitHub là gì? Công cụ quản lý mã nguồn dành cho lập trình viên','git-va-github-la-gi-cong-cu-quan-ly-ma-nguon-danh-cho-lap-trinh-vien','# Git và GitHub là gì? Công cụ quản lý mã nguồn dành cho lập trình viên\r\n\r\nTrong quá trình phát triển phần mềm, việc quản lý mã nguồn và theo dõi những thay đổi trong dự án là rất quan trọng. Git và GitHub là hai công cụ phổ biến giúp lập trình viên thực hiện công việc này hiệu quả hơn.\r\n\r\n## 1. Git là gì?\r\n\r\nGit là hệ thống quản lý phiên bản phân tán (Distributed Version Control System). Công cụ này cho phép lập trình viên theo dõi lịch sử chỉnh sửa mã nguồn, khôi phục phiên bản cũ và quản lý nhiều nhánh phát triển khác nhau.\r\n\r\n## 2. GitHub là gì?\r\n\r\nGitHub là nền tảng lưu trữ và quản lý dự án sử dụng Git. Người dùng có thể tải mã nguồn lên Internet, chia sẻ dự án và làm việc cùng nhiều lập trình viên khác.\r\n\r\nGit là công cụ quản lý phiên bản, còn GitHub là nền tảng hỗ trợ lưu trữ và cộng tác trên mã nguồn.\r\n\r\n## 3. Một số câu lệnh Git cơ bản\r\n\r\n**Khởi tạo Git trong dự án:**\r\n\r\n```bash\r\ngit init\r\n```\r\n\r\n**Thêm các tệp vào vùng chờ:**\r\n\r\n```bash\r\ngit add .\r\n```\r\n\r\n**Lưu thay đổi:**\r\n\r\n```bash\r\ngit commit -m \"Initial commit\"\r\n```\r\n\r\n**Kiểm tra trạng thái:**\r\n\r\n```bash\r\ngit status\r\n```\r\n\r\n**Đẩy mã nguồn lên GitHub:**\r\n\r\n```bash\r\ngit push origin main\r\n```\r\n\r\n## 4. Lợi ích khi sử dụng Git và GitHub\r\n\r\n- Theo dõi lịch sử thay đổi của dự án.\r\n- Khôi phục mã nguồn khi xảy ra lỗi.\r\n- Hỗ trợ nhiều người cùng phát triển phần mềm.\r\n- Lưu trữ mã nguồn trực tuyến.\r\n- Dễ dàng chia sẻ và giới thiệu sản phẩm cá nhân.\r\n\r\n## 5. Git và GitHub phù hợp với ai?\r\n\r\nHai công cụ này phù hợp với sinh viên công nghệ thông tin, lập trình viên Front-end, Back-end và các nhóm phát triển phần mềm.\r\n\r\nĐối với sinh viên, GitHub còn là nơi lưu trữ các bài tập lớn, đồ án và dự án cá nhân để xây dựng hồ sơ năng lực (Portfolio).\r\n\r\n## 6. Kết luận\r\n\r\nGit và GitHub là những công cụ gần như không thể thiếu trong quy trình phát triển phần mềm hiện đại. Việc làm quen và sử dụng thành thạo hai công cụ này sẽ giúp lập trình viên quản lý dự án khoa học và làm việc nhóm hiệu quả hơn.','posts/aHi4rnOkpOAgjqTni1qKEOYnUiNaFBC174f0vew9.jpg','published','2026-11-11 15:00:16','2026-11-11 15:00:16','2026-11-11 15:00:16',NULL),
(22,4,1,'API là gì? Tìm hiểu vai trò của API trong phát triển phần mềm','api-la-gi-tim-hieu-vai-tro-cua-api-trong-phat-trien-phan-mem','# API là gì? Tìm hiểu vai trò của API trong phát triển phần mềm\r\n\r\nAPI là một thành phần quan trọng trong quá trình phát triển website và ứng dụng hiện đại. Công nghệ này giúp các hệ thống phần mềm giao tiếp, trao đổi dữ liệu và sử dụng chức năng của nhau một cách thuận tiện.\r\n\r\n## 1. API là gì?\r\n\r\nAPI (Application Programming Interface) là giao diện lập trình ứng dụng, cho phép các phần mềm giao tiếp với nhau thông qua những quy tắc và phương thức được quy định sẵn.\r\n\r\nVí dụ, khi bạn sử dụng ứng dụng thời tiết, ứng dụng có thể gửi yêu cầu đến API của một dịch vụ cung cấp dữ liệu thời tiết để lấy thông tin nhiệt độ và dự báo.\r\n\r\n## 2. API hoạt động như thế nào?\r\n\r\nQuy trình hoạt động cơ bản của API gồm:\r\n\r\n1. Người dùng thực hiện một thao tác trên ứng dụng.\r\n2. Ứng dụng gửi yêu cầu (Request) đến máy chủ.\r\n3. API tiếp nhận và xử lý yêu cầu.\r\n4. Máy chủ truy xuất hoặc cập nhật dữ liệu.\r\n5. API trả kết quả (Response) về ứng dụng.\r\n\r\nDữ liệu thường được trao đổi dưới định dạng JSON.\r\n\r\n## 3. Các phương thức HTTP phổ biến\r\n\r\nMột số phương thức thường được sử dụng khi xây dựng API:\r\n\r\n- **GET:** Lấy dữ liệu từ máy chủ.\r\n- **POST:** Tạo mới dữ liệu.\r\n- **PUT:** Cập nhật toàn bộ tài nguyên.\r\n- **PATCH:** Cập nhật một phần tài nguyên.\r\n- **DELETE:** Xóa dữ liệu.\r\n\r\nVí dụ:\r\n\r\n```http\r\nGET /api/users\r\nPOST /api/users\r\nPUT /api/users/1\r\nDELETE /api/users/1\r\n```\r\n\r\n## 4. API được sử dụng ở đâu?\r\n\r\nAPI xuất hiện trong nhiều ứng dụng thực tế như:\r\n\r\n- Website bán hàng kết nối với hệ thống thanh toán.\r\n- Ứng dụng di động lấy dữ liệu từ máy chủ.\r\n- Website đăng nhập bằng tài khoản Google.\r\n- Hệ thống quản lý dữ liệu giữa nhiều phần mềm.\r\n- Ứng dụng bản đồ lấy thông tin vị trí.\r\n\r\n## 5. Xây dựng API bằng Laravel\r\n\r\nLaravel hỗ trợ xây dựng RESTful API thông qua hệ thống Routing và Controller.\r\n\r\nVí dụ tạo một API đơn giản:\r\n\r\n```php\r\nuse Illuminate\\Support\\Facades\\Route;\r\n\r\nRoute::get(\'/hello\', function () {\r\n    return response()->json([\r\n        \'message\' => \'Hello Laravel API!\'\r\n    ]);\r\n});\r\n```\r\n\r\nKhi truy cập endpoint `/api/hello`, hệ thống sẽ trả về dữ liệu JSON.\r\n\r\n## 6. Kết luận\r\n\r\nAPI đóng vai trò quan trọng trong việc kết nối các hệ thống phần mềm. Việc hiểu và sử dụng API sẽ giúp lập trình viên xây dựng những ứng dụng linh hoạt, dễ mở rộng và có khả năng tích hợp với nhiều nền tảng khác nhau.','posts/kPH72fa3Mj0PZK0rr7S2pKdQbBZvs9J0MKhAfOTR.jpg','published','2026-11-11 15:01:34','2026-11-11 15:01:34','2026-11-11 15:01:34',NULL),
(23,4,1,'Responsive Web Design là gì? Cách thiết kế website tương thích mọi thiết bị','responsive-web-design-la-gi-cach-thiet-ke-website-tuong-thich-moi-thiet-bi','# Responsive Web Design là gì? Cách thiết kế website tương thích mọi thiết bị\r\n\r\nNgày nay, người dùng truy cập website bằng nhiều thiết bị khác nhau như máy tính, điện thoại và máy tính bảng. Vì vậy, thiết kế website tương thích với nhiều kích thước màn hình là yêu cầu quan trọng trong phát triển web.\r\n\r\n## 1. Responsive Web Design là gì?\r\n\r\nResponsive Web Design (RWD) là phương pháp thiết kế website giúp giao diện tự động điều chỉnh theo kích thước màn hình và thiết bị của người dùng.\r\n\r\nThay vì tạo nhiều phiên bản website riêng biệt, lập trình viên có thể sử dụng một giao diện linh hoạt để hiển thị tốt trên nhiều thiết bị.\r\n\r\n## 2. Vì sao cần thiết kế Responsive?\r\n\r\nResponsive mang lại nhiều lợi ích:\r\n\r\n- Cải thiện trải nghiệm người dùng trên điện thoại.\r\n- Giao diện hiển thị phù hợp với nhiều kích thước màn hình.\r\n- Giảm chi phí xây dựng và bảo trì website.\r\n- Hỗ trợ tối ưu hóa công cụ tìm kiếm (SEO).\r\n- Giúp website chuyên nghiệp và dễ sử dụng hơn.\r\n\r\n## 3. Các kỹ thuật Responsive phổ biến\r\n\r\nMột số kỹ thuật thường được sử dụng gồm:\r\n\r\n**Media Queries:** Cho phép áp dụng CSS theo kích thước màn hình.\r\n\r\n```css\r\n.container {\r\n    width: 80%;\r\n    margin: auto;\r\n}\r\n\r\n@media (max-width: 768px) {\r\n    .container {\r\n        width: 95%;\r\n    }\r\n}\r\n```\r\n\r\n**Flexbox:** Giúp sắp xếp các thành phần linh hoạt theo chiều ngang hoặc chiều dọc.\r\n\r\n**CSS Grid:** Hỗ trợ xây dựng bố cục website theo dạng lưới.\r\n\r\n**Đơn vị linh hoạt:** Sử dụng %, rem, em thay vì chỉ sử dụng pixel cố định.\r\n\r\n## 4. Những lưu ý khi thiết kế Responsive\r\n\r\n- Ưu tiên thiết kế giao diện cho điện thoại trước (Mobile First).\r\n- Hình ảnh cần tự động điều chỉnh kích thước.\r\n- Nội dung phải dễ đọc trên màn hình nhỏ.\r\n- Các nút bấm cần có kích thước phù hợp.\r\n- Kiểm tra website trên nhiều thiết bị và trình duyệt.\r\n\r\n## 5. Kết luận\r\n\r\nResponsive Web Design là kỹ thuật cần thiết đối với mọi website hiện đại. Việc áp dụng đúng các nguyên tắc Responsive giúp website hiển thị đẹp mắt, hoạt động ổn định và mang lại trải nghiệm tốt hơn cho người dùng.','posts/apudLGGx1a6xieJbT99mPojnJbf2tjigmQ3JfDTh.jpg','published','2026-11-11 15:02:34','2026-11-11 15:02:34','2026-11-11 15:02:34',NULL),
(24,5,1,'SQL Injection là gì? Cách phòng chống lỗ hổng bảo mật website','sql-injection-la-gi-cach-phong-chong-lo-hong-bao-mat-website','# SQL Injection là gì? Cách phòng chống lỗ hổng bảo mật website\r\n\r\nBảo mật là yếu tố quan trọng trong quá trình xây dựng và vận hành website. Một trong những lỗ hổng bảo mật phổ biến mà lập trình viên cần quan tâm là SQL Injection.\r\n\r\n## 1. SQL Injection là gì?\r\n\r\nSQL Injection là kỹ thuật tấn công bằng cách chèn các đoạn mã SQL độc hại vào dữ liệu đầu vào của ứng dụng.\r\n\r\nNếu website xử lý dữ liệu không an toàn, kẻ tấn công có thể lợi dụng lỗ hổng này để truy cập, chỉnh sửa hoặc xóa dữ liệu trái phép.\r\n\r\n## 2. SQL Injection hoạt động như thế nào?\r\n\r\nLỗi thường xuất hiện khi ứng dụng nối trực tiếp dữ liệu người dùng nhập vào câu lệnh SQL.\r\n\r\nVí dụ không an toàn:\r\n\r\n```php\r\n$sql = \"SELECT * FROM users\r\n        WHERE email = \'$email\'\";\r\n```\r\n\r\nNếu dữ liệu đầu vào không được xử lý đúng cách, câu truy vấn có thể bị thay đổi ngoài ý muốn.\r\n\r\n## 3. Những hậu quả của SQL Injection\r\n\r\nMột cuộc tấn công SQL Injection có thể gây ra nhiều rủi ro:\r\n\r\n- Đánh cắp thông tin tài khoản.\r\n- Truy cập dữ liệu người dùng trái phép.\r\n- Thay đổi hoặc xóa dữ liệu trong database.\r\n- Làm gián đoạn hoạt động của website.\r\n- Gây thiệt hại về uy tín và tài chính.\r\n\r\n## 4. Cách phòng chống SQL Injection\r\n\r\nLập trình viên có thể áp dụng những biện pháp sau:\r\n\r\n- Sử dụng Prepared Statements để tách dữ liệu khỏi câu lệnh SQL.\r\n- Kiểm tra và xác thực dữ liệu đầu vào.\r\n- Không sử dụng quyền quản trị database cho tài khoản ứng dụng thông thường.\r\n- Không hiển thị thông tin lỗi SQL nhạy cảm cho người dùng.\r\n- Thường xuyên cập nhật framework và thư viện.\r\n\r\n## 5. Laravel hỗ trợ bảo mật như thế nào?\r\n\r\nLaravel sử dụng Eloquent ORM và Query Builder với cơ chế binding tham số, giúp hạn chế nguy cơ SQL Injection khi được sử dụng đúng cách.\r\n\r\nVí dụ truy vấn an toàn:\r\n\r\n```php\r\n$users = DB::table(\'users\')\r\n    ->where(\'email\', $email)\r\n    ->get();\r\n```\r\n\r\nThay vì nối trực tiếp dữ liệu vào câu lệnh SQL, Laravel sử dụng cơ chế liên kết tham số để xử lý truy vấn.\r\n\r\n## 6. Kết luận\r\n\r\nSQL Injection là một lỗ hổng bảo mật nghiêm trọng mà mọi lập trình viên web cần hiểu rõ. Việc sử dụng truy vấn tham số hóa, kiểm tra dữ liệu đầu vào và áp dụng các nguyên tắc bảo mật sẽ giúp bảo vệ hệ thống và dữ liệu người dùng tốt hơn.','posts/arjKRuOqtmuX6dsZ4Bwwyzz4zw6ww9ZSuglLWhx0.jpg','published','2026-11-11 15:04:59','2026-11-11 15:04:59','2026-11-11 15:04:59',NULL),
(25,5,1,'Cloud Computing là gì? Xu hướng điện toán đám mây hiện nay','cloud-computing-la-gi-xu-huong-dien-toan-dam-may-hien-nay','# Cloud Computing là gì? Xu hướng điện toán đám mây hiện nay\r\n\r\nCloud Computing (điện toán đám mây) là công nghệ cho phép người dùng lưu trữ dữ liệu, sử dụng phần mềm và khai thác tài nguyên máy tính thông qua Internet mà không cần đầu tư toàn bộ hệ thống máy chủ riêng.\r\n\r\n## 1. Cloud Computing là gì?\r\n\r\nĐiện toán đám mây cung cấp các tài nguyên công nghệ thông tin như máy chủ, bộ nhớ, cơ sở dữ liệu và phần mềm thông qua Internet.\r\n\r\nThay vì lưu trữ toàn bộ dữ liệu trên máy tính cá nhân, người dùng có thể truy cập thông tin từ nhiều thiết bị khác nhau.\r\n\r\n## 2. Các mô hình điện toán đám mây phổ biến\r\n\r\nHiện nay có ba mô hình triển khai chính:\r\n\r\n- **Public Cloud:** Dịch vụ đám mây công cộng được cung cấp cho nhiều khách hàng.\r\n- **Private Cloud:** Hệ thống đám mây riêng dành cho một tổ chức.\r\n- **Hybrid Cloud:** Kết hợp giữa đám mây công cộng và đám mây riêng.\r\n\r\n## 3. Các dịch vụ Cloud Computing\r\n\r\nĐiện toán đám mây thường được chia thành ba mô hình dịch vụ:\r\n\r\n- **IaaS:** Cung cấp hạ tầng như máy chủ, mạng và lưu trữ.\r\n- **PaaS:** Cung cấp nền tảng để phát triển và triển khai ứng dụng.\r\n- **SaaS:** Cung cấp phần mềm trực tiếp qua Internet.\r\n\r\n## 4. Ưu điểm của điện toán đám mây\r\n\r\n- Tiết kiệm chi phí đầu tư phần cứng.\r\n- Truy cập dữ liệu ở nhiều địa điểm.\r\n- Dễ dàng mở rộng tài nguyên khi cần thiết.\r\n- Hỗ trợ sao lưu và phục hồi dữ liệu.\r\n- Tăng khả năng cộng tác và làm việc trực tuyến.\r\n\r\n## 5. Những nền tảng Cloud phổ biến\r\n\r\nMột số nhà cung cấp dịch vụ điện toán đám mây nổi bật hiện nay gồm:\r\n\r\n- Amazon Web Services (AWS).\r\n- Microsoft Azure.\r\n- Google Cloud Platform (GCP).\r\n- IBM Cloud.\r\n\r\nCác nền tảng này cung cấp nhiều giải pháp phục vụ cá nhân, doanh nghiệp và tổ chức phát triển phần mềm.\r\n\r\n## 6. Kết luận\r\n\r\nCloud Computing đang trở thành một phần quan trọng trong quá trình chuyển đổi số. Việc ứng dụng điện toán đám mây giúp cá nhân và doanh nghiệp tối ưu tài nguyên, tiết kiệm chi phí và nâng cao hiệu quả hoạt động trong môi trường số.','posts/sQbWC8xCjODTiNYGq3m1iME4tjY1AzVzyT3LzDBN.jpg','published','2026-11-11 15:07:06','2026-11-11 15:07:06','2026-11-11 15:07:06',NULL),
(26,5,2,'7 thói quen nhỏ giúp bạn sống tích cực và hạnh phúc hơn mỗi ngày','7-thoi-quen-nho-giup-ban-song-tich-cuc-va-hanh-phuc-hon-moi-ngay','# 7 thói quen nhỏ giúp bạn sống tích cực và hạnh phúc hơn mỗi ngày\r\n\r\nMột cuộc sống tích cực không nhất thiết phải bắt đầu từ những thay đổi lớn lao. Đôi khi, chỉ cần điều chỉnh một vài thói quen nhỏ mỗi ngày, bạn đã có thể cải thiện tinh thần, sức khỏe và chất lượng cuộc sống.\r\n\r\n## 1. Bắt đầu ngày mới sớm hơn\r\n\r\nThức dậy sớm giúp bạn có thêm thời gian chuẩn bị cho một ngày mới. Hãy dành vài phút để vận động nhẹ, ăn sáng và lên kế hoạch cho những công việc cần hoàn thành.\r\n\r\n## 2. Uống đủ nước\r\n\r\nNước đóng vai trò quan trọng đối với hoạt động của cơ thể. Hãy duy trì thói quen uống nước đều đặn trong ngày thay vì đợi đến khi cảm thấy khát.\r\n\r\n## 3. Dành thời gian vận động\r\n\r\nĐi bộ, chạy bộ, đạp xe hoặc chơi thể thao đều là những hoạt động tốt cho sức khỏe. Bạn không cần tập luyện quá nặng, chỉ cần duy trì đều đặn.\r\n\r\n## 4. Hạn chế sử dụng điện thoại quá nhiều\r\n\r\nViệc dành quá nhiều thời gian cho mạng xã hội có thể khiến bạn mất tập trung và ảnh hưởng đến thời gian nghỉ ngơi. Hãy thử giảm thời gian sử dụng điện thoại và dành sự chú ý cho những hoạt động thực tế.\r\n\r\n## 5. Đọc sách mỗi ngày\r\n\r\nĐọc sách giúp mở rộng kiến thức, cải thiện khả năng tư duy và mang lại những góc nhìn mới. Bạn có thể bắt đầu với 10–15 phút mỗi ngày.\r\n\r\n## 6. Học cách quản lý chi tiêu\r\n\r\nGhi chép các khoản thu và chi giúp bạn hiểu rõ tiền bạc của mình đang được sử dụng như thế nào. Hãy ưu tiên những khoản cần thiết và dành một phần thu nhập để tiết kiệm.\r\n\r\n## 7. Dành thời gian cho gia đình và bạn bè\r\n\r\nCông việc và học tập rất quan trọng, nhưng những mối quan hệ thân thiết cũng cần được quan tâm. Một cuộc trò chuyện, bữa cơm gia đình hoặc buổi gặp mặt bạn bè có thể giúp tinh thần thoải mái hơn.\r\n\r\n## Kết luận\r\n\r\nSống tích cực không phải là lúc nào cũng vui vẻ hay không gặp khó khăn. Đó là cách chúng ta chăm sóc bản thân, đối diện với vấn đề và trân trọng những điều giản dị trong cuộc sống.\r\n\r\nHãy bắt đầu từ một thói quen nhỏ hôm nay và kiên trì thực hiện mỗi ngày.','posts/zmrXPABndd7F9QrichczFkgvB1FZZoXclEEKK2WI.jpg','published','2026-11-11 15:08:25','2026-11-11 15:08:25','2026-11-11 15:08:25',NULL),
(27,5,3,'10 kinh nghiệm du lịch tự túc dành cho người mới bắt đầu','10-kinh-nghiem-du-lich-tu-tuc-danh-cho-nguoi-moi-bat-dau','# 10 kinh nghiệm du lịch tự túc dành cho người mới bắt đầu\r\n\r\nDu lịch tự túc là lựa chọn được nhiều người yêu thích bởi sự linh hoạt, chủ động về thời gian và có thể tự do khám phá những địa điểm mới. Tuy nhiên, nếu chưa có nhiều kinh nghiệm, bạn nên chuẩn bị kỹ để chuyến đi diễn ra thuận lợi.\r\n\r\n## 1. Lên kế hoạch trước chuyến đi\r\n\r\nHãy xác định địa điểm, thời gian khởi hành, số ngày lưu trú và những nơi muốn tham quan. Một kế hoạch rõ ràng sẽ giúp bạn tiết kiệm thời gian.\r\n\r\n## 2. Tìm hiểu địa điểm du lịch\r\n\r\nTrước khi đi, hãy tìm hiểu về thời tiết, văn hóa, phương tiện di chuyển và các địa điểm nổi bật tại nơi mình đến.\r\n\r\n## 3. Dự trù ngân sách\r\n\r\nHãy chia ngân sách thành các khoản như di chuyển, ăn uống, khách sạn, vé tham quan và chi phí phát sinh. Nên chuẩn bị thêm một khoản dự phòng.\r\n\r\n## 4. Đặt vé và phòng nghỉ sớm\r\n\r\nĐặt vé máy bay, vé tàu hoặc phòng khách sạn trước ngày khởi hành có thể giúp bạn chủ động hơn và có nhiều lựa chọn phù hợp.\r\n\r\n## 5. Chuẩn bị hành lý gọn nhẹ\r\n\r\nChỉ mang theo những vật dụng thực sự cần thiết như quần áo, giấy tờ tùy thân, đồ vệ sinh cá nhân và thuốc thông dụng.\r\n\r\n## 6. Sử dụng bản đồ điện tử\r\n\r\nGoogle Maps và các ứng dụng bản đồ giúp bạn tìm đường, xác định khoảng cách và lựa chọn phương tiện di chuyển thuận tiện.\r\n\r\n## 7. Tìm hiểu ẩm thực địa phương\r\n\r\nThưởng thức những món ăn đặc sản là một phần thú vị của mỗi chuyến du lịch. Bạn có thể tham khảo đánh giá của người dân địa phương và du khách trước khi lựa chọn.\r\n\r\n## 8. Tôn trọng văn hóa địa phương\r\n\r\nMỗi vùng miền đều có phong tục và quy tắc riêng. Hãy tìm hiểu trước để tránh những hành động thiếu phù hợp khi tham quan.\r\n\r\n## 9. Đảm bảo an toàn cá nhân\r\n\r\nLuôn bảo quản tài sản, giữ giấy tờ quan trọng cẩn thận và lưu lại thông tin liên hệ cần thiết. Không nên đến những khu vực nguy hiểm khi chưa tìm hiểu kỹ.\r\n\r\n## 10. Lưu giữ những khoảnh khắc đáng nhớ\r\n\r\nĐừng quên chụp ảnh, quay video và ghi lại những trải nghiệm thú vị. Tuy nhiên, hãy dành thời gian tận hưởng chuyến đi thay vì chỉ tập trung vào điện thoại.\r\n\r\n## Kết luận\r\n\r\nDu lịch tự túc không quá khó nếu bạn có sự chuẩn bị chu đáo. Một kế hoạch hợp lý, ngân sách phù hợp và tinh thần khám phá sẽ giúp chuyến đi trở nên thú vị và đáng nhớ hơn.','posts/84kVA7e0HIqf2zLv3HGtcKv6cufs667dWWhwxoM0.jpg','published','2026-11-11 15:10:15','2026-11-11 15:10:15','2026-11-11 15:10:15',NULL),
(28,5,3,'Top 7 địa điểm du lịch miền Bắc đẹp nhất dành cho chuyến đi cuối tuần','top-7-dia-diem-du-lich-mien-bac-dep-nhat-danh-cho-chuyen-di-cuoi-tuan','# Top 7 địa điểm du lịch miền Bắc đẹp nhất dành cho chuyến đi cuối tuần\r\n\r\nMiền Bắc Việt Nam sở hữu nhiều cảnh đẹp thiên nhiên, từ núi rừng hùng vĩ đến những hồ nước trong xanh và bản làng yên bình. Nếu đang tìm kiếm một chuyến đi ngắn ngày để thư giãn, dưới đây là 7 địa điểm đáng trải nghiệm.\r\n\r\n## 1. Sa Pa – Thành phố trong sương\r\n\r\nSa Pa nổi tiếng với khí hậu mát mẻ, ruộng bậc thang và những dãy núi trùng điệp. Du khách có thể khám phá bản Cát Cát, chinh phục Fansipan hoặc thưởng thức các món ăn đặc sản vùng Tây Bắc.\r\n\r\n## 2. Hà Giang – Vẻ đẹp hùng vĩ của núi rừng\r\n\r\nHà Giang thu hút du khách bởi những cung đường đèo uốn lượn, cao nguyên đá Đồng Văn và cảnh sắc thiên nhiên ấn tượng. Đây là điểm đến phù hợp với những người yêu thích khám phá và trải nghiệm.\r\n\r\n## 3. Ninh Bình – Non nước hữu tình\r\n\r\nNinh Bình sở hữu nhiều danh thắng nổi tiếng như Tràng An, Tam Cốc và Hang Múa. Du khách có thể ngồi thuyền ngắm cảnh sông núi hoặc leo núi để chiêm ngưỡng toàn cảnh thiên nhiên.\r\n\r\n## 4. Hạ Long – Kỳ quan thiên nhiên thế giới\r\n\r\nVịnh Hạ Long nổi bật với hàng nghìn đảo đá vôi lớn nhỏ giữa làn nước xanh. Các hoạt động phổ biến gồm tham quan vịnh bằng tàu, chèo kayak và khám phá các hang động.\r\n\r\n## 5. Mộc Châu – Cao nguyên xanh mát\r\n\r\nMộc Châu hấp dẫn bởi những đồi chè xanh, thung lũng hoa và không khí trong lành. Đây cũng là địa điểm lý tưởng để nghỉ dưỡng, chụp ảnh và thưởng thức đặc sản địa phương.\r\n\r\n## 6. Tam Đảo – Điểm nghỉ dưỡng gần Hà Nội\r\n\r\nTam Đảo có khí hậu mát mẻ, cảnh quan núi rừng và nhiều công trình kiến trúc đẹp. Du khách có thể tham quan nhà thờ đá, quảng trường trung tâm và thưởng thức những món ăn đặc trưng.\r\n\r\n## 7. Ba Vì – Không gian xanh giữa thiên nhiên\r\n\r\nVườn quốc gia Ba Vì là lựa chọn phù hợp cho những chuyến đi trong ngày. Nơi đây có rừng cây xanh mát, không khí trong lành và nhiều địa điểm tham quan hấp dẫn.\r\n\r\n## Kết luận\r\n\r\nMỗi địa điểm du lịch miền Bắc đều mang một nét đẹp riêng. Tùy theo sở thích, thời gian và ngân sách, bạn có thể lựa chọn một hành trình phù hợp để thư giãn, khám phá và lưu giữ những kỷ niệm đáng nhớ.','posts/gVd7nckJYl1qAbDaxVXG7h7iCVL3A86PamYWWpdh.jpg','published','2026-11-11 15:11:21','2026-11-11 15:11:21','2026-11-11 15:11:21',NULL);

/*Table structure for table `sessions` */

DROP TABLE IF EXISTS `sessions`;

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

/*Data for the table `sessions` */

insert  into `sessions`(`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) values 
('EMJazUuc0xJSWESnShAN3nKAjri7EzVaOhkiopd5',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiTlcwS041bm5iY2ZpZ0xGMmRpM3RpNjdneUhLZzFpY2xadTdZYlhzTSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2NDoiZDQ2Y2M1OWY3YTUyNTEyZDE1NGRjNjJlMDBlMzEwMGUyZTZmYTIxNDI2N2I2MGE5ZjRjYTk2YjM3ZWM2OGM0NiI7fQ==',1794384805);

/*Table structure for table `tags` */

DROP TABLE IF EXISTS `tags`;

CREATE TABLE `tags` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tags_name_unique` (`name`),
  UNIQUE KEY `tags_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `tags` */

insert  into `tags`(`id`,`name`,`slug`,`created_at`,`updated_at`) values 
(1,'Laravel','laravel','2026-11-11 13:13:13','2026-11-11 13:13:13'),
(2,'PHP','php','2026-11-11 13:13:13','2026-11-11 13:13:13'),
(3,'MySQL','mysql','2026-11-11 13:13:13','2026-11-11 13:13:13'),
(4,'Lập trình','lap-trinh','2026-11-11 13:13:13','2026-11-11 13:13:13'),
(5,'Hướng dẫn','huong-dan','2026-11-11 13:13:13','2026-11-11 13:13:13'),
(6,'Mẹo vặt','meo-vat','2026-11-11 13:13:13','2026-11-11 13:13:13'),
(7,'Kinh nghiệm','kinh-nghiem','2026-11-11 13:13:13','2026-11-11 13:13:13'),
(8,'Review','review','2026-11-11 13:13:13','2026-11-11 13:13:13');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'member',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`email_verified_at`,`password`,`role`,`remember_token`,`created_at`,`updated_at`) values 
(1,'Quản trị viên','admin@example.com','2026-11-11 13:13:13','$2y$12$O99hwxPtj9eQrW/pXUR2DevAVo9jnSrvp/Kgg4i0Y8V6DXAKC9esi','admin','r6MHyVPBqW8zIcB130Iwlrt5G9VseJVGkKzp4s8gGlpfkKK1qE7Y3CyossoW','2026-11-11 13:13:13','2026-11-11 13:13:13'),
(2,'Tạ Phương Thảo','thao@gmail.com',NULL,'$2y$12$ry/5ECEGI.HVHrFrUSOTROYtjLdh.She6nP2gHo5ncVhmsys//6mC','member',NULL,'2026-11-11 14:05:48','2026-11-11 14:05:48'),
(3,'Thu Trang','Trang@gmail.com',NULL,'$2y$12$6SlPM.uMN6LWNFyNz1/Yn.vhQb0bphlluTEqKNE6mRj07CmSjxrN.','member',NULL,'2026-11-11 14:31:11','2026-11-11 14:31:11'),
(4,'Tình Kendy','tinh@gmail.com',NULL,'$2y$12$xPbZYjYZYkMe1V0VmRLvEe/UmqPXsIL7V34xv2lGq4suq0oiHLuX.','member',NULL,'2026-11-11 14:57:03','2026-11-11 14:57:03'),
(5,'Chinh','chinh@gmail.com',NULL,'$2y$12$fUrL7fU8496u/jpexUde8uPMxVOWKz9QMMKfmFu.Uu1OgPEeMwTHC','member',NULL,'2026-11-11 15:03:56','2026-11-11 15:03:56');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
