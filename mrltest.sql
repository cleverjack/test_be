-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2018 at 04:14 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 5.6.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mrltest`
--

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `spotify_followers` int(10) UNSIGNED DEFAULT NULL,
  `spotify_popularity` tinyint(3) UNSIGNED DEFAULT NULL,
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
  `stripe_cust_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`id`, `username`, `name`, `gender`, `spotify_followers`, `spotify_popularity`, `image_small`, `image_large`, `fully_scraped`, `updated_at`, `bio`, `wiki_image_large`, `wiki_image_small`, `contact`, `location`, `payment_address`, `monthly_rate`, `locked`, `website`, `number`, `twitter`, `facebook`, `instagram`, `stripe_cust_id`) VALUES
(1, 'nashville', 'Nashville', NULL, NULL, 0, 'http://localhost/avatars/5a970f1f73744.png', 'http://localhost/artistLargeImages/5a3eae04eb8b1.png', 0, '2018-03-14 11:20:53', '', NULL, NULL, 'Nashville Track', 'KP', 'luanzhi@yandex.com', 20, 1, NULL, 0, NULL, NULL, NULL, ''),
(2, 'luanzhi123', 'Lu Anzhi', NULL, NULL, NULL, 'http://localhost/avatars/5a4b283e8c0a1.png', 'http://localhost/artistLargeImages/5a4b285dee23c.png', 0, '2018-03-14 12:25:19', NULL, NULL, NULL, 'null', 'null', NULL, NULL, 1, NULL, 0, NULL, NULL, NULL, ''),
(3, 'michaelduff', 'Michael Duff', 'null', NULL, NULL, 'http://localhost/avatars/5ab163d0bc378.jpg', 'http://localhost/covers/5ab168256ce28.png', 0, '2018-03-28 11:47:46', NULL, NULL, NULL, NULL, 'null', NULL, NULL, 1, 'null', 0, 'null', 'null', 'null', ''),
(4, 'minamifuzi', 'Minami Fuzi', NULL, NULL, NULL, 'http://localhost/avatars/5aaff9a7b339b.png', 'https://i.scdn.co/image/fcb6ff3b92a1412e225c69277744e33105af963f', 0, '2018-04-16 01:40:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, NULL, NULL, 'cus_Cg58dWHu4wu9GX'),
(5, 'aerosmith', 'Aerosmith', NULL, 1578353, 73, 'https://i.scdn.co/image/81442527ebb3ff17f86fde87f75f96fd80a5d97c', 'https://i.scdn.co/image/fcb6ff3b92a1412e225c69277744e33105af963f', 0, '2018-03-14 11:20:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, ''),
(6, 'onerepublic', 'OneRepublic', NULL, 2882441, 88, 'https://i.scdn.co/image/f74611315f994aa61b1b2c18866ccb1770381e94', 'https://i.scdn.co/image/0249fd0808ae0176c6a4108821a4f1bc79aae6bb', 1, '2018-03-14 11:20:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, ''),
(7, 'jimmyeatworld', 'Jimmy Eat World', NULL, NULL, 32, 'https://lastfm-img2.akamaized.net/i/u/586ff431a0f440bfab3630c573220607.png', 'http://localhost/artistLargeImages/5a3bd474dcbc1.png', 0, '2018-03-14 11:20:53', NULL, NULL, NULL, 'null', 'null', NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, ''),
(8, 'bonjovi', 'Bon Jovi', NULL, NULL, NULL, 'https://lastfm-img2.akamaized.net/i/u/39f70d59a8aadf6f5197cc0f69e03f16.png', 'https://i.scdn.co/image/fcb6ff3b92a1412e225c69277744e33105af963f', 0, '2018-03-14 11:20:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, ''),
(9, 'thevelvetunderground', 'The Velvet Underground', NULL, 359710, 62, 'https://i.scdn.co/image/fedcb6f64de6571e2c208a21fc16b9e05e38cf2f', 'https://i.scdn.co/image/d69c2cf10323bf08443c7d122f3a1824a760ab57', 0, '2018-03-14 11:20:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, ''),
(10, '3doorsdown', '3 Doors Down', NULL, 766093, 70, 'https://i.scdn.co/image/942ff2555a081b628f0a66fcd6998a5e73b5a3fb', 'https://i.scdn.co/image/b6bde9a790ba351ba6304519df301ff909a69550', 0, '2018-03-14 11:20:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `artist_payment_details`
--

CREATE TABLE `artist_payment_details` (
  `pay_id` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL,
  `stripe_key` varchar(255) NOT NULL,
  `stipe_publishable_key` varchar(255) NOT NULL,
  `paypal_client_id` varchar(255) NOT NULL,
  `paypal_client_secret` varchar(255) NOT NULL,
  `paypal_username` varchar(255) NOT NULL,
  `paypal_api_password` varchar(255) NOT NULL,
  `paypal_sign` varchar(255) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_ip` varchar(30) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `updated_ip` varchar(30) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `artist_payment_details`
--

INSERT INTO `artist_payment_details` (`pay_id`, `artist_id`, `stripe_key`, `stipe_publishable_key`, `paypal_client_id`, `paypal_client_secret`, `paypal_username`, `paypal_api_password`, `paypal_sign`, `created_by`, `created_ip`, `created_at`, `updated_by`, `updated_ip`, `updated_at`) VALUES
(2, 4, 'sk_test_zCSjOxiIHTNmPJUBdg4hFQAZ', 'pk_test_bVvaPSi39gMYihZgqd7tdFn2', 'ARfSeZBGvkgeDqAXxs5p8HqDTVdXBH3PO1w6YctvyVzTjdcwjdFPBeNjg_cRZoDeBP1EvHHUjDrcqDFX', 'EM-TkljFABYuavJbs89g4XABbCb_ZO85K2ZceFvww7MpumPljnnpHT3-Tllqzn1PTYedSa5Z54mHqF1b', 'anand.chapter247-facilitator_api1.gmail.com', '1394461040', 'AqtZTIqvum3gMXnS3A.RonBHLc74A6X3mQLiuheXLejvCClzGcWSXb9s', 4, '::1', '2018-04-12 07:38:41', 4, '::1', '2018-04-16 00:02:33'),
(3, 5, 'sk_test_zCSjOxiIHTNmPJUBdg4hFQAZ', 'pk_test_bVvaPSi39gMYihZgqd7tdFn2', 'ARfSeZBGvkgeDqAXxs5p8HqDTVdXBH3PO1w6YctvyVzTjdcwjdFPBeNjg_cRZoDeBP1EvHHUjDrcqDFX', 'EM-TkljFABYuavJbs89g4XABbCb_ZO85K2ZceFvww7MpumPljnnpHT3-Tllqzn1PTYedSa5Z54mHqF1b', 'anand.chapter247-facilitator_api1.gmail.com', '1394461040', 'AqtZTIqvum3gMXnS3A.RonBHLc74A6X3mQLiuheXLejvCClzGcWSXb9s', 5, '::1', '2018-04-16 11:37:57', NULL, NULL, '2018-04-16 11:37:57');

-- --------------------------------------------------------

--
-- Table structure for table `artist_user`
--

CREATE TABLE `artist_user` (
  `id` int(255) NOT NULL,
  `artist_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `artist_user`
--

INSERT INTO `artist_user` (`id`, `artist_id`, `user_id`, `type`) VALUES
(1, 1, 1, NULL),
(2, 2, 2, NULL),
(3, 3, 3, NULL),
(4, 4, 9, NULL),
(5, 5, 10, NULL),
(6, 6, 11, NULL),
(7, 7, 12, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `follows`
--

CREATE TABLE `follows` (
  `id` int(10) UNSIGNED NOT NULL,
  `follower_id` int(11) NOT NULL,
  `followed_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_details`
--

CREATE TABLE `payment_details` (
  `pay_id` int(11) NOT NULL,
  `payment_using` enum('paypal','stripe') NOT NULL,
  `payment_data` text NOT NULL,
  `payment_id` varchar(100) NOT NULL,
  `payment_status` enum('completed','initiated','success') NOT NULL DEFAULT 'initiated',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_ip` varchar(30) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_ip` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_details`
--

INSERT INTO `payment_details` (`pay_id`, `payment_using`, `payment_data`, `payment_id`, `payment_status`, `created_at`, `created_ip`, `updated_at`, `updated_ip`) VALUES
(1, 'paypal', '{\"payId\":\"I-3LB7S0PG5HE1\",\"status\":\"succeeded\",\"paymentMethod\":\"Paypal\",\"paymentStatus\":\"active\",\"payerEmail\":\"amit.chapter247@gmail.com\",\"grand_amount\":2}', 'I-3LB7S0PG5HE1', 'completed', '2018-04-14 13:48:07', NULL, '2018-04-16 08:56:45', NULL),
(3, 'paypal', '{\"payId\":\"I-RUV4HE2KU617\",\"status\":\"succeeded\",\"paymentMethod\":\"Paypal\",\"paymentStatus\":\"active\",\"payerEmail\":\"amit.chapter247@gmail.com\",\"grand_amount\":2}', 'I-RUV4HE2KU617', 'initiated', '2018-04-14 13:49:20', NULL, '2018-04-14 13:49:20', NULL),
(5, 'paypal', '{\"payId\":\"I-K4EJ1LPEM1NH\",\"status\":\"succeeded\",\"paymentMethod\":\"Paypal\",\"paymentStatus\":\"active\",\"payerEmail\":\"amit.chapter247@gmail.com\",\"grand_amount\":2}', 'I-K4EJ1LPEM1NH', 'initiated', '2018-04-14 13:52:55', NULL, '2018-04-14 13:52:55', NULL),
(6, 'paypal', '{\"payId\":\"I-LCTXHMA96BWV\",\"status\":\"succeeded\",\"paymentMethod\":\"Paypal\",\"paymentStatus\":\"active\",\"payerEmail\":\"amit.chapter247@gmail.com\",\"grand_amount\":2}', 'I-LCTXHMA96BWV', 'initiated', '2018-04-16 05:15:40', NULL, '2018-04-16 05:15:40', NULL),
(7, 'stripe', '{\"payId\":\"sub_Cgp6Tw6M1NhDQf\",\"status\":\"succeeded\",\"paymentMethod\":\"Stripe\",\"paymentStatus\":\"succeeded\",\"payerEmail\":\"artist1@gmail.com\",\"grand_amount\":5}', 'sub_Cgp6Tw6M1NhDQf', 'initiated', '2018-04-16 07:10:20', NULL, '2018-04-16 07:10:20', NULL),
(8, 'paypal', '{\"payId\":\"I-N8KWSVKNE9NF\",\"status\":\"succeeded\",\"paymentMethod\":\"Paypal\",\"paymentStatus\":\"active\",\"payerEmail\":\"amit.chapter247@gmail.com\",\"grand_amount\":2}', 'I-N8KWSVKNE9NF', 'initiated', '2018-04-16 13:15:10', NULL, '2018-04-16 13:15:10', NULL),
(9, 'paypal', '{\"payId\":\"I-N8KWSVKNE9NF\",\"status\":\"succeeded\",\"paymentMethod\":\"Paypal\",\"paymentStatus\":\"active\",\"payerEmail\":\"amit.chapter247@gmail.com\",\"grand_amount\":2}', 'I-N8KWSVKNE9NF', 'initiated', '2018-04-16 13:19:22', NULL, '2018-04-16 13:19:22', NULL),
(10, 'paypal', '{\"payId\":\"I-N8KWSVKNE9NF\",\"status\":\"succeeded\",\"paymentMethod\":\"Paypal\",\"paymentStatus\":\"active\",\"payerEmail\":\"amit.chapter247@gmail.com\",\"grand_amount\":2}', 'I-N8KWSVKNE9NF', 'initiated', '2018-04-16 13:19:57', NULL, '2018-04-16 13:19:57', NULL),
(11, 'paypal', '{\"payId\":\"I-PLV4KB08NS7S\",\"status\":\"succeeded\",\"paymentMethod\":\"Paypal\",\"paymentStatus\":\"active\",\"payerEmail\":\"amit.chapter247@gmail.com\",\"grand_amount\":2}', 'I-PLV4KB08NS7S', 'initiated', '2018-04-16 13:21:26', NULL, '2018-04-16 13:21:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `plan_master`
--

CREATE TABLE `plan_master` (
  `plan_id` int(11) NOT NULL,
  `plan_owner` int(11) NOT NULL,
  `plan_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `amount` float(10,2) NOT NULL,
  `paypal_id` varchar(100) NOT NULL,
  `stripe_id` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `created_ip` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `updated_ip` varchar(30) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `plan_master`
--

INSERT INTO `plan_master` (`plan_id`, `plan_owner`, `plan_name`, `description`, `amount`, `paypal_id`, `stripe_id`, `is_active`, `created_by`, `created_ip`, `created_at`, `updated_by`, `updated_ip`, `updated_at`) VALUES
(3, 4, 'Test Plan Tet', 'Tets Paldafds', 1.00, 'P-0D123334XC2627818XIFX22Y', '3_15235398', 0, 4, '::1', '2018-04-12 13:30:03', NULL, NULL, '2018-04-13 05:36:29'),
(4, 4, 'New Plan', 'dfasfds', 1.00, 'P-6DR99161DR858203XXIGJECQ', 'plan_CfQL2Xht8qyYPI', 0, 4, '::1', '2018-04-12 13:31:13', NULL, NULL, '2018-04-13 05:36:32'),
(5, 4, 'NNNN', 'asfdsfads', 2.00, 'P-0PN22924G73616429XIICKSI', 'plan_CfQPVfyFyXcm2e', 0, 4, '::1', '2018-04-12 13:35:08', NULL, NULL, '2018-04-13 05:36:36'),
(6, 4, 'Test', 'fasdf', 123.00, 'P-70L57515S69180324XII4UCI', 'plan_CfQRU2oscjbVNB', 0, 4, '::1', '2018-04-12 13:36:56', NULL, NULL, '2018-04-13 05:36:39'),
(7, 4, 'This is plan is for dynamic testing', 'This is plan is for dynamic testing', 2.00, 'P-23T83089XC2724353XIU63YQ', 'plan_CfQrLZR2Ig4VDF', 0, 4, '::1', '2018-04-12 14:03:17', NULL, NULL, '2018-04-13 10:31:18'),
(8, 4, 'My Single Collection', 'If you subscribe to the plan you will able to download my latest single.', 5.00, 'P-6UT79119122697321X2IBVBI', 'plan_Cfkhux2Ch53x0y', 0, 4, '::1', '2018-04-13 10:33:21', NULL, NULL, '2018-04-13 13:23:15'),
(9, 4, 'My Single Collection 1', 'My Single Collection Description', 2.00, 'P-9FY90293J8245432HX4WBB4A', 'plan_CfnSLNyxwPjUYY', 1, 4, '::1', '2018-04-13 13:23:44', NULL, NULL, '2018-04-13 14:21:01'),
(10, 5, '121121213', '12132132132132132132132132', 10.00, 'P-26K72175G5674322DZY7KKLQ', 'plan_CgtQN9COeovIaD', 1, 5, '::1', '2018-04-16 11:38:19', NULL, NULL, '2018-04-16 06:08:31');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'artist', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'listener', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'moderator', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `role_id` int(255) DEFAULT '3',
  `type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`id`, `user_id`, `role_id`, `type`) VALUES
(1, 1, 2, NULL),
(2, 2, 2, NULL),
(3, 3, 2, NULL),
(4, 4, 3, NULL),
(5, 5, 3, NULL),
(6, 6, 3, NULL),
(7, 7, 3, NULL),
(8, 8, 3, NULL),
(9, 9, 2, NULL),
(10, 10, 2, NULL),
(11, 11, 2, NULL),
(12, 12, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `stripe_cust_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paypal_email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `cover_url`, `avatar_url`, `gender`, `permissions`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `confirmed`, `confirmation_code`, `city`, `state`, `location`, `country_code`, `birthday`, `provider`, `provider_id`, `stripe_cust_id`, `paypal_email`, `website`) VALUES
(1, 'Dhung', 'Dhung', 'Bui', 'http://localhost/covers/5ab168f9ec77d.jpg', 'http://localhost/avatars/5a8f051414dc4.jpg', 'male', NULL, 'nashvilletracks@gmail.com', '$2y$10$bNeepbdyaZA5S606W6RIxex/NkxHZfSspLXsl8jo0rGUqBxVdW49W', 'xPE1xTd9IbOiI9AScqSpttdnxMJCRFTQxndyPNfK5lgyJt3gEWVNwjhtbTlO', '2017-01-12 19:58:34', '2018-03-14 10:03:59', 1, NULL, 'sfdsdf', 'sdfsd', 'Albania', NULL, '0000-00-00', NULL, NULL, '', '', NULL),
(2, 'Duff', 'Michael', 'Duff', 'http://localhost/covers/5ab168f9ec77d.jpg', 'http://localhost/covers/5ab168f9ec77d.jpg', 'female', NULL, 'artist5@gmail.com', '$2y$10$bNeepbdyaZA5S606W6RIxex/NkxHZfSspLXsl8jo0rGUqBxVdW49W', 'QNnw1o44qTlS2S0J4IBVV7cCDxDTlR106qwH1k0ujuYl7LEUsOuNwYQaFGCL', '2017-01-12 22:27:26', '2017-12-28 16:19:55', 1, NULL, '', '', '', NULL, '0000-00-00', NULL, NULL, '', '', NULL),
(3, 'Dhung', 'Dhung', 'Bui', 'http://localhost/covers/5ab168f9ec77d.jpg', 'http://localhost/avatars/5a45b43d95fcd.jpg', 'male', NULL, 'artist6@gmail.com', '$2y$10$bNeepbdyaZA5S606W6RIxex/NkxHZfSspLXsl8jo0rGUqBxVdW49W', 'jlyPh95gwAE57BR8VBCV9rrMXgcgguWj2DzaoVjIiZLDIfv8C7toW9OlC8sJ', '2017-01-20 10:38:47', '2017-12-28 21:50:16', 1, NULL, 'sdasdfsdf', 'fsd', 'Albania', NULL, '0000-00-00', NULL, NULL, '', '', NULL),
(4, 'listener1', 'listener10', 'listener', 'http://localhost/covers/5ab168f9ec77d.jpg', 'http://localhost/avatars/5ab16855995c5.jpg', 'male', NULL, 'listener1@gmail.com', '$2y$10$bNeepbdyaZA5S606W6RIxex/NkxHZfSspLXsl8jo0rGUqBxVdW49W', 'tLx64C3KCOVfP86NUYWuTF6xBXhmw8QMnKqnuMlXDArHaTvSqFHP5ksm5HUf', '2017-01-23 01:26:42', '2018-04-13 05:42:34', 1, NULL, '', '', 'Algeria', NULL, '0000-00-00', NULL, NULL, 'cus_CfkLKrP1J6RmLO', '', NULL),
(5, 'listener2', 'listener2', 'listener', 'http://localhost/covers/5ab168f9ec77d.jpg', 'http://localhost/covers/5ab168f9ec77d.jpg', NULL, NULL, 'listener2@gmail.com', '$2y$10$bNeepbdyaZA5S606W6RIxex/NkxHZfSspLXsl8jo0rGUqBxVdW49W', NULL, '2017-01-25 03:42:23', '2017-01-25 03:42:23', 1, NULL, '', '', '', NULL, '0000-00-00', NULL, NULL, '', '', NULL),
(6, 'listener3', 'listener3', 'listener', 'http://localhost/covers/5ab168f9ec77d.jpg', 'http://localhost/covers/5ab168f9ec77d.jpg', NULL, NULL, 'listener3@gmail.com', '$2y$10$bNeepbdyaZA5S606W6RIxex/NkxHZfSspLXsl8jo0rGUqBxVdW49W', NULL, '2017-01-28 19:07:19', '2017-01-28 19:07:19', 1, NULL, '', '', '', NULL, '0000-00-00', NULL, NULL, '', '', NULL),
(7, 'listener4', 'listener4', 'listener', 'http://localhost/covers/5ab168f9ec77d.jpg', 'http://localhost/covers/5ab168f9ec77d.jpg', NULL, NULL, 'listener4@gmail.com', '$2y$10$bNeepbdyaZA5S606W6RIxex/NkxHZfSspLXsl8jo0rGUqBxVdW49W', NULL, '2017-02-02 12:55:02', '2017-02-02 12:55:02', 1, NULL, '', '', '', NULL, '0000-00-00', NULL, NULL, '', '', NULL),
(8, 'listener5', 'listener5', 'listener', 'http://localhost/covers/5ab168f9ec77d.jpg', 'http://localhost/covers/5ab168f9ec77d.jpg', NULL, NULL, 'listener5@gmail.com', '$2y$10$bNeepbdyaZA5S606W6RIxex/NkxHZfSspLXsl8jo0rGUqBxVdW49W', 'vl5thzQ7g4f2iRj3pdWU1Kxt4kmblxVUWVXvkJQSbO7naejQ4TU8lEtI5cFg', '2017-02-02 13:27:53', '2017-02-02 13:27:53', 1, NULL, '', '', '', NULL, '0000-00-00', NULL, NULL, '', '', NULL),
(9, 'artist1', 'artist1', 'artist', 'http://localhost/covers/5ab168f9ec77d.jpg', 'http://localhost/covers/5ab168f9ec77d.jpg', NULL, NULL, 'artist1@gmail.com', '$2y$10$bNeepbdyaZA5S606W6RIxex/NkxHZfSspLXsl8jo0rGUqBxVdW49W', NULL, '2017-02-03 01:36:17', '2018-04-16 00:02:33', 1, NULL, '', '', '', NULL, '0000-00-00', NULL, NULL, '', 'amit.chapter247@gmail.com', NULL),
(10, 'artist2', 'artist2', 'artist', 'http://localhost/covers/5ab168f9ec77d.jpg', 'http://localhost/covers/5ab168f9ec77d.jpg', NULL, NULL, 'artist2@gmail.com', '$2y$10$bNeepbdyaZA5S606W6RIxex/NkxHZfSspLXsl8jo0rGUqBxVdW49W', NULL, '2017-02-07 05:33:36', '2018-04-16 06:07:57', 1, NULL, '', '', '', NULL, '0000-00-00', NULL, NULL, '', 'amit.chapter247-1@gmail.com', NULL),
(11, 'artist3', 'artist3', 'artist', 'http://localhost/covers/5ab168f9ec77d.jpg', 'http://localhost/covers/5ab168f9ec77d.jpg', NULL, NULL, 'artist3@gmail.com', '$2y$10$bNeepbdyaZA5S606W6RIxex/NkxHZfSspLXsl8jo0rGUqBxVdW49W', 'gF27xSy88mCzLFvMmZTK0yuMUWrD3yA5RahJxF0HFdpLxAL2FHzbffxA2qyE', '2017-02-08 01:52:38', '2017-02-08 01:52:38', 1, NULL, '', '', '', NULL, '0000-00-00', NULL, NULL, '', '', NULL),
(12, 'artist4', 'artist4', 'artist', 'http://localhost/covers/5ab168f9ec77d.jpg', 'http://localhost/covers/5ab168f9ec77d.jpg', NULL, NULL, 'artist4@gmail.com', '$2y$10$bNeepbdyaZA5S606W6RIxex/NkxHZfSspLXsl8jo0rGUqBxVdW49W', '4ZglsFevA8f5vsgK9YimbIbanL7Dor40wx0ALB8EXt2ixq7tebUV6SlNtRMA', '2017-02-08 01:54:35', '2017-02-09 06:26:03', 1, NULL, '', '', '', NULL, '0000-00-00', NULL, NULL, '', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_subscriptions`
--

CREATE TABLE `user_subscriptions` (
  `subscription_id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `activation_date` timestamp NULL DEFAULT NULL,
  `next_payment_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_ip` varchar(30) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_ip` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_username` (`username`),
  ADD KEY `artists_spotify_popularity_index` (`spotify_popularity`),
  ADD KEY `artists_fully_scraped_index` (`fully_scraped`);

--
-- Indexes for table `artist_payment_details`
--
ALTER TABLE `artist_payment_details`
  ADD PRIMARY KEY (`pay_id`);

--
-- Indexes for table `artist_user`
--
ALTER TABLE `artist_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `follows_follower_id_followed_id_unique` (`follower_id`,`followed_id`);

--
-- Indexes for table `payment_details`
--
ALTER TABLE `payment_details`
  ADD PRIMARY KEY (`pay_id`);

--
-- Indexes for table `plan_master`
--
ALTER TABLE `plan_master`
  ADD PRIMARY KEY (`plan_id`),
  ADD KEY `plan_owner` (`plan_owner`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_subscriptions`
--
ALTER TABLE `user_subscriptions`
  ADD PRIMARY KEY (`subscription_id`),
  ADD KEY `subscription_pay_id` (`payment_id`),
  ADD KEY `subscription_plan_id` (`plan_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4175;

--
-- AUTO_INCREMENT for table `artist_payment_details`
--
ALTER TABLE `artist_payment_details`
  MODIFY `pay_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `artist_user`
--
ALTER TABLE `artist_user`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `follows`
--
ALTER TABLE `follows`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `payment_details`
--
ALTER TABLE `payment_details`
  MODIFY `pay_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `plan_master`
--
ALTER TABLE `plan_master`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;

--
-- AUTO_INCREMENT for table `user_subscriptions`
--
ALTER TABLE `user_subscriptions`
  MODIFY `subscription_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_subscriptions`
--
ALTER TABLE `user_subscriptions`
  ADD CONSTRAINT `subscription_pay_id` FOREIGN KEY (`payment_id`) REFERENCES `payment_details` (`pay_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `subscription_plan_id` FOREIGN KEY (`plan_id`) REFERENCES `plan_master` (`plan_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
