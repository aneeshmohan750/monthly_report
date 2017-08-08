-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2017 at 09:38 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `monthly_report_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `allowed_clients`
--

CREATE TABLE `allowed_clients` (
  `id` mediumint(15) NOT NULL,
  `user_id` mediumint(15) NOT NULL,
  `client_id` mediumint(15) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_data` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` mediumint(15) NOT NULL,
  `name` varchar(400) NOT NULL,
  `api_username` varchar(400) NOT NULL,
  `api_password` varchar(400) NOT NULL,
  `api_list_id` int(15) NOT NULL,
  `ga_account_id` varchar(400) NOT NULL,
  `website` varchar(500) NOT NULL,
  `mail_count` int(30) NOT NULL,
  `visitors_count` int(30) NOT NULL,
  `template_name` varchar(600) NOT NULL,
  `logo` varchar(100) NOT NULL,
  `enable_mail_listing` tinyint(1) NOT NULL,
  `enable_ga_details` tinyint(1) NOT NULL,
  `enable_tablet_feedback` tinyint(1) NOT NULL,
  `last_update` date NOT NULL,
  `type` enum('hotel','non-hotel') NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` mediumint(25) NOT NULL,
  `client_id` mediumint(15) NOT NULL,
  `email` varchar(500) NOT NULL,
  `create_date` date NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `contact_segmentation`
--

CREATE TABLE `contact_segmentation` (
  `id` mediumint(15) NOT NULL,
  `client_id` mediumint(15) NOT NULL,
  `segment_id` mediumint(15) NOT NULL,
  `email_count` int(15) NOT NULL,
  `month` date NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `contact_segment_map`
--

CREATE TABLE `contact_segment_map` (
  `id` mediumint(20) NOT NULL,
  `contact_id` mediumint(15) NOT NULL,
  `segment_id` mediumint(15) NOT NULL,
  `value` varchar(600) NOT NULL,
  `create_date` date NOT NULL,
  `update_date` date NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `contact_temp`
--

CREATE TABLE `contact_temp` (
  `id` mediumint(15) NOT NULL,
  `client_id` mediumint(15) NOT NULL,
  `segment_id` mediumint(15) NOT NULL,
  `value` varchar(600) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `email_count_log`
--

CREATE TABLE `email_count_log` (
  `log_id` int(11) NOT NULL,
  `client_id` int(10) NOT NULL,
  `month` date NOT NULL,
  `emails` int(10) NOT NULL,
  `log_created` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `feedback_form_api_field_map`
--

CREATE TABLE `feedback_form_api_field_map` (
  `id` mediumint(15) NOT NULL,
  `client_id` mediumint(15) NOT NULL,
  `api_attr_id` mediumint(15) NOT NULL,
  `field_name` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `feedback_form_field_client_rel`
--

CREATE TABLE `feedback_form_field_client_rel` (
  `id` mediumint(15) NOT NULL,
  `field_id` mediumint(15) NOT NULL,
  `client_id` mediumint(15) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `feedback_form_field_set`
--

CREATE TABLE `feedback_form_field_set` (
  `id` mediumint(15) NOT NULL,
  `title` varchar(400) NOT NULL,
  `api_field_name` varchar(500) NOT NULL,
  `field_name` varchar(400) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ga_events`
--

CREATE TABLE `ga_events` (
  `id` mediumint(15) NOT NULL,
  `name` varchar(300) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ga_site_visitors`
--

CREATE TABLE `ga_site_visitors` (
  `id` mediumint(15) NOT NULL,
  `client_id` mediumint(15) NOT NULL,
  `ga_event_id` mediumint(15) NOT NULL,
  `ga_event_entity_name` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `visitors_count` int(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mail_frequency_rate`
--

CREATE TABLE `mail_frequency_rate` (
  `id` mediumint(15) NOT NULL,
  `client_id` mediumint(15) NOT NULL,
  `mail_frequency` varchar(50) NOT NULL,
  `read_rate` varchar(50) NOT NULL,
  `open_rate` varchar(50) NOT NULL,
  `ctor` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `message_activity`
--

CREATE TABLE `message_activity` (
  `id` mediumint(15) NOT NULL,
  `client_id` mediumint(15) NOT NULL,
  `Subject` text NOT NULL,
  `SendDate` date NOT NULL,
  `DeliverCount` varchar(50) NOT NULL,
  `Sent` varchar(50) NOT NULL,
  `BounceCount` varchar(50) NOT NULL,
  `BouncePercent` varchar(50) NOT NULL,
  `RemoveCount` varchar(50) NOT NULL,
  `RemovePercent` varchar(50) NOT NULL,
  `OpenCount` varchar(50) NOT NULL,
  `OpenPercent` varchar(50) NOT NULL,
  `ReadCount` varchar(50) NOT NULL,
  `ReadPercent` varchar(50) NOT NULL,
  `ClickCount` varchar(50) NOT NULL,
  `ClickerCount` varchar(50) NOT NULL,
  `ClickerPercent` varchar(50) NOT NULL,
  `Ctor` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `segments`
--

CREATE TABLE `segments` (
  `id` mediumint(15) NOT NULL,
  `client_id` mediumint(15) NOT NULL,
  `name` varchar(400) NOT NULL,
  `segment_type` enum('Normal','Restaurant','Source') NOT NULL,
  `listing` tinyint(1) NOT NULL,
  `primary_segment` tinyint(1) NOT NULL,
  `non_hotel_segment` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `site_page_name_map`
--

CREATE TABLE `site_page_name_map` (
  `id` mediumint(9) NOT NULL,
  `client_id` mediumint(15) NOT NULL,
  `page_name` varchar(600) NOT NULL,
  `page_url` varchar(700) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tablet_feedback_details`
--

CREATE TABLE `tablet_feedback_details` (
  `id` mediumint(15) NOT NULL,
  `client_id` mediumint(15) NOT NULL,
  `first_name` varchar(400) DEFAULT NULL,
  `last_name` varchar(400) DEFAULT NULL,
  `email` varchar(400) DEFAULT NULL,
  `contact_number` varchar(400) DEFAULT NULL,
  `about` text,
  `quality` text,
  `service` text,
  `comments` text,
  `received_date` date DEFAULT NULL,
  `from_ip` varchar(400) DEFAULT NULL,
  `residence_country` varchar(400) DEFAULT NULL,
  `barcode` varchar(400) DEFAULT NULL,
  `agegroup` varchar(400) DEFAULT NULL,
  `cuisine` varchar(400) DEFAULT NULL,
  `ambiance` varchar(400) DEFAULT NULL,
  `service_quality` varchar(400) DEFAULT NULL,
  `food` varchar(400) DEFAULT NULL,
  `interests` varchar(400) DEFAULT NULL,
  `locality` varchar(400) DEFAULT NULL,
  `area` varchar(400) DEFAULT NULL,
  `reason_visit` varchar(400) DEFAULT NULL,
  `staying_hotel` varchar(500) DEFAULT NULL,
  `visit_frequency` varchar(500) DEFAULT NULL,
  `reception_area` varchar(500) DEFAULT NULL,
  `fitness_center` varchar(500) DEFAULT NULL,
  `pool_area` varchar(500) DEFAULT NULL,
  `treatment_rooms` varchar(500) DEFAULT NULL,
  `treatment_variety` varchar(500) DEFAULT NULL,
  `product_quality` varchar(500) DEFAULT NULL,
  `inhouse_guest` varchar(500) DEFAULT NULL,
  `walkin_guest` varchar(500) DEFAULT NULL,
  `all_details` varchar(500) DEFAULT NULL,
  `relaxation` varchar(500) DEFAULT NULL,
  `food_specials` varchar(500) DEFAULT NULL,
  `happenings` varchar(500) DEFAULT NULL,
  `room_specials` varchar(500) DEFAULT NULL,
  `beverage_specials` varchar(500) DEFAULT NULL,
  `nationality` varchar(500) DEFAULT NULL,
  `emirates` varchar(500) DEFAULT NULL,
  `gender` varchar(500) DEFAULT NULL,
  `locker_area` varchar(500) DEFAULT NULL,
  `welcoming` varchar(500) DEFAULT NULL,
  `reception_associates` varchar(500) DEFAULT NULL,
  `pool_associates` varchar(500) DEFAULT NULL,
  `spa_therapists` varchar(500) DEFAULT NULL,
  `spa` varchar(100) NOT NULL,
  `promotions` varchar(100) NOT NULL,
  `treatment_quality` varchar(500) DEFAULT NULL,
  `residence_city` varchar(500) DEFAULT NULL,
  `restaurant` varchar(400) DEFAULT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` mediumint(15) NOT NULL,
  `first_name` varchar(300) NOT NULL,
  `last_name` varchar(300) NOT NULL,
  `username` varchar(400) NOT NULL,
  `password` varchar(400) NOT NULL,
  `salt` varchar(100) NOT NULL,
  `email` varchar(300) NOT NULL,
  `contact_number` varchar(200) NOT NULL,
  `client_id` mediumint(15) NOT NULL,
  `role_id` int(15) NOT NULL,
  `designation` varchar(200) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `is_group_admin` tinyint(1) NOT NULL,
  `multi_access` tinyint(1) NOT NULL,
  `created_date` datetime NOT NULL,
  `last_login_date` datetime NOT NULL,
  `logged_out` datetime NOT NULL,
  `login_status` tinyint(1) NOT NULL,
  `remember_token` varchar(500) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='This table stores the details of application users';

-- --------------------------------------------------------

--
-- Table structure for table `user_logs`
--

CREATE TABLE `user_logs` (
  `id` mediumint(15) NOT NULL,
  `username` varchar(500) NOT NULL,
  `ip_address` varchar(400) NOT NULL,
  `log_date` datetime NOT NULL,
  `attempt` enum('success','failure') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allowed_clients`
--
ALTER TABLE `allowed_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `contact_segmentation`
--
ALTER TABLE `contact_segmentation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_segment_map`
--
ALTER TABLE `contact_segment_map`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contact_id` (`contact_id`),
  ADD KEY `Segment` (`segment_id`);

--
-- Indexes for table `contact_temp`
--
ALTER TABLE `contact_temp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_count_log`
--
ALTER TABLE `email_count_log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `feedback_form_api_field_map`
--
ALTER TABLE `feedback_form_api_field_map`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback_form_field_client_rel`
--
ALTER TABLE `feedback_form_field_client_rel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback_form_field_set`
--
ALTER TABLE `feedback_form_field_set`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ga_events`
--
ALTER TABLE `ga_events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ga_site_visitors`
--
ALTER TABLE `ga_site_visitors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mail_frequency_rate`
--
ALTER TABLE `mail_frequency_rate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message_activity`
--
ALTER TABLE `message_activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `segments`
--
ALTER TABLE `segments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_page_name_map`
--
ALTER TABLE `site_page_name_map`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tablet_feedback_details`
--
ALTER TABLE `tablet_feedback_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_logs`
--
ALTER TABLE `user_logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `allowed_clients`
--
ALTER TABLE `allowed_clients`
  MODIFY `id` mediumint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;
--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` mediumint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` mediumint(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126195;
--
-- AUTO_INCREMENT for table `contact_segmentation`
--
ALTER TABLE `contact_segmentation`
  MODIFY `id` mediumint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=527;
--
-- AUTO_INCREMENT for table `contact_segment_map`
--
ALTER TABLE `contact_segment_map`
  MODIFY `id` mediumint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3402525;
--
-- AUTO_INCREMENT for table `contact_temp`
--
ALTER TABLE `contact_temp`
  MODIFY `id` mediumint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=243758;
--
-- AUTO_INCREMENT for table `email_count_log`
--
ALTER TABLE `email_count_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=521;
--
-- AUTO_INCREMENT for table `feedback_form_api_field_map`
--
ALTER TABLE `feedback_form_api_field_map`
  MODIFY `id` mediumint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;
--
-- AUTO_INCREMENT for table `feedback_form_field_client_rel`
--
ALTER TABLE `feedback_form_field_client_rel`
  MODIFY `id` mediumint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=339;
--
-- AUTO_INCREMENT for table `feedback_form_field_set`
--
ALTER TABLE `feedback_form_field_set`
  MODIFY `id` mediumint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT for table `ga_events`
--
ALTER TABLE `ga_events`
  MODIFY `id` mediumint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `ga_site_visitors`
--
ALTER TABLE `ga_site_visitors`
  MODIFY `id` mediumint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62037;
--
-- AUTO_INCREMENT for table `mail_frequency_rate`
--
ALTER TABLE `mail_frequency_rate`
  MODIFY `id` mediumint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `message_activity`
--
ALTER TABLE `message_activity`
  MODIFY `id` mediumint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `segments`
--
ALTER TABLE `segments`
  MODIFY `id` mediumint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=785;
--
-- AUTO_INCREMENT for table `site_page_name_map`
--
ALTER TABLE `site_page_name_map`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1109;
--
-- AUTO_INCREMENT for table `tablet_feedback_details`
--
ALTER TABLE `tablet_feedback_details`
  MODIFY `id` mediumint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23327;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` mediumint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;
--
-- AUTO_INCREMENT for table `user_logs`
--
ALTER TABLE `user_logs`
  MODIFY `id` mediumint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1568;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
