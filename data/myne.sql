SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `myne`
--

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

DROP TABLE IF EXISTS `devices`;
CREATE TABLE IF NOT EXISTS `devices` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `clear_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `type` int(10) NOT NULL,
  `vendor` int(10) NOT NULL,
  `model` int(10) NOT NULL,
  `room` int(10) NOT NULL,
  `gateway` int(10) DEFAULT NULL,
  `masterdip` varchar(255) DEFAULT NULL,
  `slavedip` varchar(255) DEFAULT NULL,
  `tx433version` varchar(255) DEFAULT NULL,
  `rawCodeOn` varchar(255) DEFAULT NULL,
  `rawCodeOff` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `port` int(5) DEFAULT NULL,
  `wol_port` int(5) NOT NULL,
  `mac_address` varchar(255) NOT NULL,
  `user` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `icon` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Table structure for table `device_groups`
--

DROP TABLE IF EXISTS `device_groups`;
CREATE TABLE IF NOT EXISTS `device_groups` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `clear_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Table structure for table `device_group_members`
--

DROP TABLE IF EXISTS `device_group_members`;
CREATE TABLE IF NOT EXISTS `device_group_members` (
  `group_id` int(10) NOT NULL,
  `device_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `device_options`
--

DROP TABLE IF EXISTS `device_options`;
CREATE TABLE IF NOT EXISTS `device_options` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `clear_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `device_options`
--

INSERT INTO `device_options` (`id`, `name`, `clear_name`, `description`) VALUES
(1, 'toggle', 'Schalten', 'An- und Ausschaltbar');

-- --------------------------------------------------------

--
-- Table structure for table `device_revoke_option`
--

DROP TABLE IF EXISTS `device_revoke_option`;
CREATE TABLE IF NOT EXISTS `device_revoke_option` (
  `device_id` int(10) NOT NULL,
  `option_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `device_types`
--

DROP TABLE IF EXISTS `device_types`;
CREATE TABLE IF NOT EXISTS `device_types` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `clear_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `device_types`
--

INSERT INTO `device_types` (`id`, `name`, `clear_name`, `description`, `icon`) VALUES
(1, 'funksteckdose', 'Funksteckdose', 'Funksteckdose', 'd_funksteckdose.png'),
(2, 'xbmc', 'XBMC', 'XBMC', 'd_xbmc.png');

-- --------------------------------------------------------

--
-- Table structure for table `device_type_has_option`
--

DROP TABLE IF EXISTS `device_type_has_option`;
CREATE TABLE IF NOT EXISTS `device_type_has_option` (
  `device_type_id` int(10) NOT NULL,
  `option_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `device_type_has_option`
--

INSERT INTO `device_type_has_option` (`device_type_id`, `option_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `clear_name` varchar(255) NOT NULL,
  `active` int(1) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `clear_name`, `active`, `description`) VALUES
(1, 'timer', 'Timer', 1, 'Timerfunktion');

-- --------------------------------------------------------

--
-- Table structure for table `gateways`
--

DROP TABLE IF EXISTS `gateways`;
CREATE TABLE IF NOT EXISTS `gateways` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `clear_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `type` int(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `port` int(10) NOT NULL,
  `room` int(10) NOT NULL,
  `group` int(10) NOT NULL,
  `icon` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Table structure for table `gateway_groups`
--

DROP TABLE IF EXISTS `gateway_groups`;
CREATE TABLE IF NOT EXISTS `gateway_groups` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gateway_types`
--

DROP TABLE IF EXISTS `gateway_types`;
CREATE TABLE IF NOT EXISTS `gateway_types` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `clear_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `gateway_types`
--

INSERT INTO `gateway_types` (`id`, `name`, `clear_name`, `description`, `icon`) VALUES
(1, 'connair', 'Connair', '433 MHz Gateway', 'connair.png');

-- --------------------------------------------------------

--
-- Table structure for table `group_has_option`
--

DROP TABLE IF EXISTS `group_has_option`;
CREATE TABLE IF NOT EXISTS `group_has_option` (
  `group_id` int(10) NOT NULL,
  `option_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `models`
--

DROP TABLE IF EXISTS `models`;
CREATE TABLE IF NOT EXISTS `models` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `clear_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `vendor_id` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `models`
--

INSERT INTO `models` (`id`, `name`, `clear_name`, `description`, `vendor_id`) VALUES
(1, 'itr1500', 'ITR-1500', 'ITR-1500', 1),
(2, 'xbmc-frodo', 'XBMC Frodo', '', 2),
(3, 'ab440sc', 'AB 440SC', 'AB 440SC Wireless Switch Unit', 3),
(5, '2605', '2605', 'Funksteckdosen-Set 2605', 5);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `active` int(1) NOT NULL,
  `description` varchar(1024) NOT NULL,
  `author` varchar(255) NOT NULL,
  `author_mail` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
CREATE TABLE IF NOT EXISTS `rooms` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `clear_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`) VALUES
(1, 'login', 'false'),
(2, 'api', 'true'),
(3, 'api_key', '12345678');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `clear_name` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` int(1) NOT NULL,
  `description` varchar(1024) NOT NULL,
  `event` int(10) NOT NULL,
  `event_opt` varchar(255) NOT NULL,
  `action` int(10) NOT NULL,
  `action_opt` varchar(255) NOT NULL,
  `target_type` varchar(255) NOT NULL,
  `target_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `timer`
--

DROP TABLE IF EXISTS `timer`;
CREATE TABLE IF NOT EXISTS `timer` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `mon` int(1) NOT NULL,
  `tue` int(1) NOT NULL,
  `wed` int(1) NOT NULL,
  `thu` int(1) NOT NULL,
  `fri` int(1) NOT NULL,
  `sat` int(1) NOT NULL,
  `sun` int(1) NOT NULL,
  `time` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `surename` varchar(255) NOT NULL,
  `givenname` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Table structure for table `vendors`
--

DROP TABLE IF EXISTS `vendors`;
CREATE TABLE IF NOT EXISTS `vendors` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `clear_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `name`, `clear_name`, `description`) VALUES
(1, 'intertechno', 'Intertechno', 'IT'),
(2, 'xbmc', 'XBMC', 'XBMC Software Foundation'),
(3, 'elro', 'Elro', 'Elro'),
(4, 'brennenstuhl', 'Brennenstuhl', 'Brennt im Stuhl'),
(5, 'pollin', 'Pollin', 'Pollin');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_types`
--

DROP TABLE IF EXISTS `vendor_types`;
CREATE TABLE IF NOT EXISTS `vendor_types` (
  `vendor_id` int(10) NOT NULL,
  `type_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vendor_types`
--

INSERT INTO `vendor_types` (`vendor_id`, `type_id`) VALUES
(1, 1),
(3, 1),
(2, 2),
(5, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
