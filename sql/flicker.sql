

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";



-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE IF NOT EXISTS `photos` (
  `photo_id` int(11) NOT NULL,
  `publish_time` int(11) DEFAULT NULL,
  `flickr_photo_id` varchar(45) DEFAULT NULL,
  `flickr_tags` varchar(250) DEFAULT NULL,
  `flickr_groups` text,
  `status` tinyint(4) DEFAULT '-1',
  `auth_token` varchar(45) DEFAULT NULL,
  `auth_secret` varchar(200) NOT NULL DEFAULT '',
  `url` varchar(250) DEFAULT NULL,
  `ctime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL,
  `flickr_user_id` int(11) NOT NULL,
  `ctime` int(11) NOT NULL,
  `total_views` int(11) NOT NULL DEFAULT '0',
  `total_favs` int(11) DEFAULT '0',
  `total_comments` int(11) DEFAULT '0',
  `auth_token` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`photo_id`),
  ADD UNIQUE KEY `flickr_photo_id_UNIQUE` (`flickr_photo_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `flickr_user_id` (`flickr_user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `photo_id` int(11) NOT NULL AUTO_INCREMENT;