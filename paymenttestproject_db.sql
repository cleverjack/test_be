/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.1.30-MariaDB : Database - mrltest
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`mrltest` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `mrltest`;

/*Table structure for table `artist_user` */

DROP TABLE IF EXISTS `artist_user`;

CREATE TABLE `artist_user` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `artist_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

/*Data for the table `artist_user` */

insert  into `artist_user`(`id`,`artist_id`,`user_id`,`type`) values (1,1,1,NULL),(2,2,2,NULL),(3,3,3,NULL),(4,4,9,NULL),(5,5,10,NULL),(6,6,11,NULL),(7,7,12,NULL);

/*Table structure for table `artists` */

DROP TABLE IF EXISTS `artists`;

CREATE TABLE `artists` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `spotify_followers` int(10) unsigned DEFAULT NULL,
  `spotify_popularity` tinyint(3) unsigned DEFAULT NULL,
  `image_small` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_large` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fully_scraped` tinyint(1) NOT NULL DEFAULT '0',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `bio` text COLLATE utf8_unicode_ci,
  `wiki_image_large` mediumtext COLLATE utf8_unicode_ci,
  `wiki_image_small` mediumtext COLLATE utf8_unicode_ci,
  `contact` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `monthly_rate` float DEFAULT NULL,
  `locked` tinyint(1) DEFAULT '1',
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `number` int(255) DEFAULT '0',
  `twitter` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `instagram` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_username` (`username`),
  KEY `artists_spotify_popularity_index` (`spotify_popularity`),
  KEY `artists_fully_scraped_index` (`fully_scraped`)
) ENGINE=MyISAM AUTO_INCREMENT=4175 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `artists` */

insert  into `artists`(`id`,`username`,`name`,`gender`,`spotify_followers`,`spotify_popularity`,`image_small`,`image_large`,`fully_scraped`,`updated_at`,`bio`,`wiki_image_large`,`wiki_image_small`,`contact`,`location`,`payment_address`,`monthly_rate`,`locked`,`website`,`number`,`twitter`,`facebook`,`instagram`) values (1,'nashville','Nashville',NULL,NULL,0,'http://localhost/avatars/5a970f1f73744.png','http://localhost/artistLargeImages/5a3eae04eb8b1.png',0,'2018-03-14 16:50:53','',NULL,NULL,'Nashville Track','KP','luanzhi@yandex.com',20,1,NULL,0,NULL,NULL,NULL),(2,'luanzhi123','Lu Anzhi',NULL,NULL,NULL,'http://localhost/avatars/5a4b283e8c0a1.png','http://localhost/artistLargeImages/5a4b285dee23c.png',0,'2018-03-14 17:55:19',NULL,NULL,NULL,'null','null',NULL,NULL,1,NULL,0,NULL,NULL,NULL),(3,'michaelduff','Michael Duff','null',NULL,NULL,'http://localhost/avatars/5ab163d0bc378.jpg','http://localhost/covers/5ab168256ce28.png',0,'2018-03-28 17:17:46',NULL,NULL,NULL,NULL,'null',NULL,NULL,1,'null',0,'null','null','null'),(4,'minamifuzi','Minami Fuzi',NULL,NULL,NULL,'http://localhost/avatars/5aaff9a7b339b.png','https://i.scdn.co/image/fcb6ff3b92a1412e225c69277744e33105af963f',0,'2018-03-19 17:55:51',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,0,NULL,NULL,NULL),(5,'aerosmith','Aerosmith',NULL,1578353,73,'https://i.scdn.co/image/81442527ebb3ff17f86fde87f75f96fd80a5d97c','https://i.scdn.co/image/fcb6ff3b92a1412e225c69277744e33105af963f',0,'2018-03-14 16:50:53',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL,NULL,NULL),(6,'onerepublic','OneRepublic',NULL,2882441,88,'https://i.scdn.co/image/f74611315f994aa61b1b2c18866ccb1770381e94','https://i.scdn.co/image/0249fd0808ae0176c6a4108821a4f1bc79aae6bb',1,'2018-03-14 16:50:53',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL,NULL,NULL),(7,'jimmyeatworld','Jimmy Eat World',NULL,NULL,32,'https://lastfm-img2.akamaized.net/i/u/586ff431a0f440bfab3630c573220607.png','http://localhost/artistLargeImages/5a3bd474dcbc1.png',0,'2018-03-14 16:50:53',NULL,NULL,NULL,'null','null',NULL,NULL,0,NULL,0,NULL,NULL,NULL),(8,'bonjovi','Bon Jovi',NULL,NULL,NULL,'https://lastfm-img2.akamaized.net/i/u/39f70d59a8aadf6f5197cc0f69e03f16.png','https://i.scdn.co/image/fcb6ff3b92a1412e225c69277744e33105af963f',0,'2018-03-14 16:50:53',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL,NULL,NULL),(9,'thevelvetunderground','The Velvet Underground',NULL,359710,62,'https://i.scdn.co/image/fedcb6f64de6571e2c208a21fc16b9e05e38cf2f','https://i.scdn.co/image/d69c2cf10323bf08443c7d122f3a1824a760ab57',0,'2018-03-14 16:50:53',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL,NULL,NULL),(10,'3doorsdown','3 Doors Down',NULL,766093,70,'https://i.scdn.co/image/942ff2555a081b628f0a66fcd6998a5e73b5a3fb','https://i.scdn.co/image/b6bde9a790ba351ba6304519df301ff909a69550',0,'2018-03-14 16:50:53',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,0,NULL,NULL,NULL);

/*Table structure for table `follows` */

DROP TABLE IF EXISTS `follows`;

CREATE TABLE `follows` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `follower_id` int(11) NOT NULL,
  `followed_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `follows_follower_id_followed_id_unique` (`follower_id`,`followed_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `follows` */

/*Table structure for table `role_user` */

DROP TABLE IF EXISTS `role_user`;

CREATE TABLE `role_user` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `user_id` int(255) NOT NULL,
  `role_id` int(255) DEFAULT '3',
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;

/*Data for the table `role_user` */

insert  into `role_user`(`id`,`user_id`,`role_id`,`type`) values (1,1,2,NULL),(2,2,2,NULL),(3,3,2,NULL),(4,4,3,NULL),(5,5,3,NULL),(6,6,3,NULL),(7,7,3,NULL),(8,8,3,NULL),(9,9,2,NULL),(10,10,2,NULL),(11,11,2,NULL),(12,12,2,NULL);

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `roles` */

insert  into `roles`(`id`,`name`,`created_at`,`updated_at`) values (1,'admin','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,'artist','0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,'listener','0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,'moderator','0000-00-00 00:00:00','0000-00-00 00:00:00');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cover_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `confirmed` tinyint(1) NOT NULL DEFAULT '1',
  `confirmation_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT '0000-00-00',
  `provider` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `provider_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=174 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`first_name`,`last_name`,`cover_url`,`avatar_url`,`gender`,`permissions`,`email`,`password`,`remember_token`,`created_at`,`updated_at`,`confirmed`,`confirmation_code`,`city`,`state`,`location`,`country_code`,`birthday`,`provider`,`provider_id`,`website`) values (1,'Dhung','Dhung','Bui','http://localhost/covers/5ab168f9ec77d.jpg','http://localhost/avatars/5a8f051414dc4.jpg','male',NULL,'nashvilletracks@gmail.com','$2y$10$bNeepbdyaZA5S606W6RIxex/NkxHZfSspLXsl8jo0rGUqBxVdW49W','xPE1xTd9IbOiI9AScqSpttdnxMJCRFTQxndyPNfK5lgyJt3gEWVNwjhtbTlO','2017-01-13 01:28:34','2018-03-14 15:33:59',1,NULL,'sfdsdf','sdfsd','Albania',NULL,'0000-00-00',NULL,NULL,NULL),(2,'Duff','Michael','Duff','http://localhost/covers/5ab168f9ec77d.jpg','http://localhost/covers/5ab168f9ec77d.jpg','female',NULL,'artist5@gmail.com','$2y$10$bNeepbdyaZA5S606W6RIxex/NkxHZfSspLXsl8jo0rGUqBxVdW49W','QNnw1o44qTlS2S0J4IBVV7cCDxDTlR106qwH1k0ujuYl7LEUsOuNwYQaFGCL','2017-01-13 03:57:26','2017-12-28 21:49:55',1,NULL,'','','',NULL,'0000-00-00',NULL,NULL,NULL),(3,'Dhung','Dhung','Bui','http://localhost/covers/5ab168f9ec77d.jpg','http://localhost/avatars/5a45b43d95fcd.jpg','male',NULL,'artist6@gmail.com','$2y$10$bNeepbdyaZA5S606W6RIxex/NkxHZfSspLXsl8jo0rGUqBxVdW49W','jlyPh95gwAE57BR8VBCV9rrMXgcgguWj2DzaoVjIiZLDIfv8C7toW9OlC8sJ','2017-01-20 16:08:47','2017-12-29 03:20:16',1,NULL,'sdasdfsdf','fsd','Albania',NULL,'0000-00-00',NULL,NULL,NULL),(4,'listener1','listener10','listener','http://localhost/covers/5ab168f9ec77d.jpg','http://localhost/avatars/5ab16855995c5.jpg','male',NULL,'listener1@gmail.com','$2y$10$bNeepbdyaZA5S606W6RIxex/NkxHZfSspLXsl8jo0rGUqBxVdW49W','tLx64C3KCOVfP86NUYWuTF6xBXhmw8QMnKqnuMlXDArHaTvSqFHP5ksm5HUf','2017-01-23 06:56:42','2018-03-20 20:03:06',1,NULL,'','','Algeria',NULL,'0000-00-00',NULL,NULL,NULL),(5,'listener2','listener2','listener','http://localhost/covers/5ab168f9ec77d.jpg','http://localhost/covers/5ab168f9ec77d.jpg',NULL,NULL,'listener2@gmail.com','$2y$10$bNeepbdyaZA5S606W6RIxex/NkxHZfSspLXsl8jo0rGUqBxVdW49W',NULL,'2017-01-25 09:12:23','2017-01-25 09:12:23',1,NULL,'','','',NULL,'0000-00-00',NULL,NULL,NULL),(6,'listener3','listener3','listener','http://localhost/covers/5ab168f9ec77d.jpg','http://localhost/covers/5ab168f9ec77d.jpg',NULL,NULL,'listener3@gmail.com','$2y$10$bNeepbdyaZA5S606W6RIxex/NkxHZfSspLXsl8jo0rGUqBxVdW49W',NULL,'2017-01-29 00:37:19','2017-01-29 00:37:19',1,NULL,'','','',NULL,'0000-00-00',NULL,NULL,NULL),(7,'listener4','listener4','listener','http://localhost/covers/5ab168f9ec77d.jpg','http://localhost/covers/5ab168f9ec77d.jpg',NULL,NULL,'listener4@gmail.com','$2y$10$bNeepbdyaZA5S606W6RIxex/NkxHZfSspLXsl8jo0rGUqBxVdW49W',NULL,'2017-02-02 18:25:02','2017-02-02 18:25:02',1,NULL,'','','',NULL,'0000-00-00',NULL,NULL,NULL),(8,'listener5','listener5','listener','http://localhost/covers/5ab168f9ec77d.jpg','http://localhost/covers/5ab168f9ec77d.jpg',NULL,NULL,'listener5@gmail.com','$2y$10$bNeepbdyaZA5S606W6RIxex/NkxHZfSspLXsl8jo0rGUqBxVdW49W','vl5thzQ7g4f2iRj3pdWU1Kxt4kmblxVUWVXvkJQSbO7naejQ4TU8lEtI5cFg','2017-02-02 18:57:53','2017-02-02 18:57:53',1,NULL,'','','',NULL,'0000-00-00',NULL,NULL,NULL),(9,'artist1','artist1','artist','http://localhost/covers/5ab168f9ec77d.jpg','http://localhost/covers/5ab168f9ec77d.jpg',NULL,NULL,'artist1@gmail.com','$2y$10$bNeepbdyaZA5S606W6RIxex/NkxHZfSspLXsl8jo0rGUqBxVdW49W',NULL,'2017-02-03 07:06:17','2017-02-03 07:06:17',1,NULL,'','','',NULL,'0000-00-00',NULL,NULL,NULL),(10,'artist2','artist2','artist','http://localhost/covers/5ab168f9ec77d.jpg','http://localhost/covers/5ab168f9ec77d.jpg',NULL,NULL,'artist2@gmail.com','$2y$10$bNeepbdyaZA5S606W6RIxex/NkxHZfSspLXsl8jo0rGUqBxVdW49W',NULL,'2017-02-07 11:03:36','2017-02-07 11:03:36',1,NULL,'','','',NULL,'0000-00-00',NULL,NULL,NULL),(11,'artist3','artist3','artist','http://localhost/covers/5ab168f9ec77d.jpg','http://localhost/covers/5ab168f9ec77d.jpg',NULL,NULL,'artist3@gmail.com','$2y$10$bNeepbdyaZA5S606W6RIxex/NkxHZfSspLXsl8jo0rGUqBxVdW49W','gF27xSy88mCzLFvMmZTK0yuMUWrD3yA5RahJxF0HFdpLxAL2FHzbffxA2qyE','2017-02-08 07:22:38','2017-02-08 07:22:38',1,NULL,'','','',NULL,'0000-00-00',NULL,NULL,NULL),(12,'artist4','artist4','artist','http://localhost/covers/5ab168f9ec77d.jpg','http://localhost/covers/5ab168f9ec77d.jpg',NULL,NULL,'artist4@gmail.com','$2y$10$bNeepbdyaZA5S606W6RIxex/NkxHZfSspLXsl8jo0rGUqBxVdW49W','4ZglsFevA8f5vsgK9YimbIbanL7Dor40wx0ALB8EXt2ixq7tebUV6SlNtRMA','2017-02-08 07:24:35','2017-02-09 11:56:03',1,NULL,'','','',NULL,'0000-00-00',NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
