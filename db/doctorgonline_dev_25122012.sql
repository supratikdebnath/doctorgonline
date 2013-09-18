-- phpMyAdmin SQL Dump
-- version 3.4.11.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 25, 2012 at 07:54 PM
-- Server version: 5.1.66
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `thinkdmn_doctorgonline_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `dgo_admin_menu_category`
--

DROP TABLE IF EXISTS `dgo_admin_menu_category`;
CREATE TABLE IF NOT EXISTS `dgo_admin_menu_category` (
  `menuCategoryId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Menu Category Id Primary Key',
  `menuCategoryName` varchar(255) NOT NULL COMMENT 'Menu Category Name',
  `menuCategoryOrder` varchar(11) NOT NULL COMMENT 'Menu Category Ordering',
  `menuCategoryStatus` enum('0','1') NOT NULL COMMENT 'Menu Status 0-DeActive, 1-Active',
  `createDt` varchar(255) NOT NULL COMMENT 'Menu Create Date',
  `modifyDt` varchar(255) NOT NULL COMMENT 'Menu Modify Date',
  PRIMARY KEY (`menuCategoryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `dgo_admin_menu_category`
--

INSERT INTO `dgo_admin_menu_category` (`menuCategoryId`, `menuCategoryName`, `menuCategoryOrder`, `menuCategoryStatus`, `createDt`, `modifyDt`) VALUES
(1, 'Account Settings', '', '1', '1347114551', '1347114551'),
(2, 'Product Management', '', '1', '1347114551', '1347114551');

-- --------------------------------------------------------

--
-- Table structure for table `dgo_admin_menu_pages`
--

DROP TABLE IF EXISTS `dgo_admin_menu_pages`;
CREATE TABLE IF NOT EXISTS `dgo_admin_menu_pages` (
  `menuPageId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Menu Page Id Primary Key ',
  `menuCategoryId` varchar(11) NOT NULL COMMENT 'Menu Category Id from Admin Menu Category Table',
  `menuPageName` varchar(255) NOT NULL COMMENT 'Page Name (PHP Page Name without .php and with space)',
  `menuPageStatus` enum('0','1') NOT NULL COMMENT 'Menu Page Status 0-DeActive 1-Active',
  `createDt` varchar(255) NOT NULL COMMENT 'Create Date',
  `modifyDt` varchar(255) NOT NULL COMMENT 'Modify Date',
  PRIMARY KEY (`menuPageId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dgo_admin_session`
--

DROP TABLE IF EXISTS `dgo_admin_session`;
CREATE TABLE IF NOT EXISTS `dgo_admin_session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminId` int(11) NOT NULL COMMENT 'Admin User Id From Admin Users Table',
  `loginTime` varchar(255) NOT NULL COMMENT 'Login Time',
  `LastActivityTime` varchar(255) NOT NULL COMMENT 'Last activity time after login in',
  `LoginStatus` enum('0','1') NOT NULL COMMENT '0 - InActive, 1 - Active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=64 ;

--
-- Dumping data for table `dgo_admin_session`
--

INSERT INTO `dgo_admin_session` (`id`, `adminId`, `loginTime`, `LastActivityTime`, `LoginStatus`) VALUES
(54, 1, '1356243269', '1356243269', '1'),
(55, 1, '1356293277', '1356293317', '0'),
(56, 1, '1356293350', '1356293446', '0'),
(57, 1, '1356293477', '1356293501', '0'),
(58, 6, '1356293506', '1356293512', '0'),
(59, 6, '1356293623', '1356293630', '0'),
(60, 6, '1356325286', '1356325286', '1'),
(61, 6, '1356326079', '1356326079', '1'),
(62, 6, '1356457076', '1356457267', '0'),
(63, 6, '1356464753', '1356464753', '1');

-- --------------------------------------------------------

--
-- Table structure for table `dgo_admin_users`
--

DROP TABLE IF EXISTS `dgo_admin_users`;
CREATE TABLE IF NOT EXISTS `dgo_admin_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'UserId',
  `username` varchar(255) NOT NULL COMMENT 'Username',
  `email` varchar(255) NOT NULL COMMENT 'Admin Email Address',
  `fullname` varchar(255) NOT NULL COMMENT 'Full Name of the Admin User',
  `password` varchar(255) NOT NULL COMMENT 'Password',
  `privilege` varchar(11) NOT NULL COMMENT 'Privilege of Admin User',
  `status` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Status 0,1 0-De-Active 1-Active',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `dgo_admin_users`
--

INSERT INTO `dgo_admin_users` (`id`, `username`, `email`, `fullname`, `password`, `privilege`, `status`) VALUES
(1, 'administrator', 'administrator@doctorgonline.in', 'Web Administrator', '21232f297a57a5a743894a0e4a801fc3', '0', '1'),
(6, 'doctorgonline', 'samannoy.chatterjee@doctorgonline.in', 'Doctor G Online Admin', 'e2b0f2085df997cf2f3f2ddb82ddd68b', '0', '1'),
(7, 'Piyali_Basu', 'piyali.basu@thinkb.in', 'Piyali Basu', '', '0', '1');

-- --------------------------------------------------------

--
-- Table structure for table `dgo_admin_user_privs_master`
--

DROP TABLE IF EXISTS `dgo_admin_user_privs_master`;
CREATE TABLE IF NOT EXISTS `dgo_admin_user_privs_master` (
  `id` int(11) NOT NULL COMMENT 'Privilege ID',
  `privilegeName` varchar(255) NOT NULL COMMENT 'Privilege Name',
  `privilegeStatus` enum('0','1') NOT NULL COMMENT 'Privilege Status 0-DeActive , 1-Active',
  `createDt` varchar(255) NOT NULL COMMENT 'Create Date',
  `modifyDt` varchar(255) NOT NULL COMMENT 'Last Modified Date',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dgo_admin_user_privs_master`
--

INSERT INTO `dgo_admin_user_privs_master` (`id`, `privilegeName`, `privilegeStatus`, `createDt`, `modifyDt`) VALUES
(0, 'Super Admin', '1', '1347114551', '1347114551'),
(1, 'Deputy Admin', '1', '1347114551', '1347114551'),
(2, 'Normal Admin', '1', '1347114551', '1347114551');

-- --------------------------------------------------------

--
-- Table structure for table `dgo_areas`
--

DROP TABLE IF EXISTS `dgo_areas`;
CREATE TABLE IF NOT EXISTS `dgo_areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Area Id',
  `areaName` varchar(255) NOT NULL COMMENT 'Area Name',
  `sid` varchar(11) NOT NULL COMMENT 'State Id',
  `zid` varchar(11) NOT NULL COMMENT 'Zone Id',
  `createDt` varchar(255) NOT NULL COMMENT 'Create Date',
  `modifyDt` varchar(255) NOT NULL COMMENT 'Modified Date',
  `status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0=Inactive,1=Active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `dgo_areas`
--

INSERT INTO `dgo_areas` (`id`, `areaName`, `sid`, `zid`, `createDt`, `modifyDt`, `status`) VALUES
(1, 'Ghola', '1', '1', '1355941506', '1355942002', '1'),
(2, 'Sodepur', '1', '1', '1356243583', '1356243583', '1'),
(3, 'Kestopur', '1', '1', '1356243613', '1356243613', '1'),
(4, 'Baguihati', '1', '1', '1356243623', '1356243623', '1'),
(5, 'Ultadanga', '1', '1', '1356243641', '1356243641', '1');

-- --------------------------------------------------------

--
-- Table structure for table `dgo_city`
--

DROP TABLE IF EXISTS `dgo_city`;
CREATE TABLE IF NOT EXISTS `dgo_city` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'City ID',
  `sid` varchar(255) NOT NULL COMMENT 'State ID',
  `zid` varchar(255) NOT NULL COMMENT 'Zone ID',
  `cityName` varchar(255) NOT NULL COMMENT 'City Name',
  `createDt` varchar(255) NOT NULL COMMENT 'Create Date',
  `modifyDt` varchar(255) NOT NULL COMMENT 'Modify Date',
  `status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0=InActive,1=Active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `dgo_city`
--

INSERT INTO `dgo_city` (`id`, `sid`, `zid`, `cityName`, `createDt`, `modifyDt`, `status`) VALUES
(1, '1', '4', 'Kolkata', '1355341681', '1356244397', '1'),
(2, '3', '1', 'New Delhi', '1356463169', '1356463169', '1');

-- --------------------------------------------------------

--
-- Table structure for table `dgo_countries`
--

DROP TABLE IF EXISTS `dgo_countries`;
CREATE TABLE IF NOT EXISTS `dgo_countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Country Id',
  `countryName` varchar(255) NOT NULL COMMENT 'Country Name',
  `countryCode` varchar(255) NOT NULL COMMENT 'Country Code',
  `createDt` varchar(255) NOT NULL COMMENT 'Create Date',
  `modifyDt` varchar(255) NOT NULL COMMENT 'Modified Date',
  `status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0=Inactive,1=Active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `dgo_countries`
--

INSERT INTO `dgo_countries` (`id`, `countryName`, `countryCode`, `createDt`, `modifyDt`, `status`) VALUES
(1, 'India', 'IN', '1354735547', '1354735859', '1'),
(2, 'Bangladesh', 'BAN', '1355079221', '1355079221', '1'),
(3, 'Pakistan', 'PAK', '1355341828', '1355341828', '1'),
(4, 'Australia', 'AUS', '1355341839', '1355341839', '1'),
(5, 'New Zealand', 'NZ', '1356243363', '1356243363', '1');

-- --------------------------------------------------------

--
-- Table structure for table `dgo_latest_news`
--

DROP TABLE IF EXISTS `dgo_latest_news`;
CREATE TABLE IF NOT EXISTS `dgo_latest_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Latest News Id',
  `topicName` varchar(255) NOT NULL COMMENT 'Latest News Topic Name',
  `topicBody` text NOT NULL COMMENT 'Lastest News Topic Body',
  `postedBy` varchar(255) NOT NULL COMMENT 'UserId of the User Posted',
  `createDt` varchar(255) NOT NULL COMMENT 'Create Date',
  `modifyDt` varchar(255) NOT NULL COMMENT 'Modified Date',
  `status` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Latest News Status 0=InActive, 1=Active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `dgo_latest_news`
--

INSERT INTO `dgo_latest_news` (`id`, `topicName`, `topicBody`, `postedBy`, `createDt`, `modifyDt`, `status`) VALUES
(1, 'This is demo 2', '<p>\r\n	This is demo 2This is demo 2This is demo 2This is demo 2This is demo 2This is demo 2This is demo 2This is demo 2This is demo 2This is demo 2This is demo 2This is demo 2This is demo 2This is demo 2This is demo 2This is demo 2</p>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	This is demo 2This is demo 2This is demo 2This is demo 2This is demo 2This is demo 2This is demo 2This is demo 2This is demo 2This is demo 2This is demo 2This is demo 2This is demo 2This is demo 2This is demo 2This is demo 2This is demo 2</p>\r\n', 'Web Administrator', '1354335226', '1354357868', '1'),
(2, 'This is demo 1', '<p>\r\n	This is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demo</p>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	This is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demo</p>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	This is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demo</p>\r\n<p>\r\n	This is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demoThis is demo</p>\r\n', 'Web Administrator', '1354353952', '1354470150', '1');

-- --------------------------------------------------------

--
-- Table structure for table `dgo_qualification`
--

DROP TABLE IF EXISTS `dgo_qualification`;
CREATE TABLE IF NOT EXISTS `dgo_qualification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qualificationName` varchar(255) NOT NULL COMMENT 'Qualification Name',
  `qualificationDegree` enum('B','M') NOT NULL DEFAULT 'B' COMMENT 'Degree Type',
  `createDt` varchar(255) NOT NULL COMMENT 'Create Date',
  `modifyDt` varchar(255) NOT NULL COMMENT 'Modify Date',
  `status` enum('1','0') NOT NULL DEFAULT '0' COMMENT '1=Active,0=Inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=154 ;

--
-- Dumping data for table `dgo_qualification`
--

INSERT INTO `dgo_qualification` (`id`, `qualificationName`, `qualificationDegree`, `createDt`, `modifyDt`, `status`) VALUES
(1, 'BAMS', 'B', '1354735547', '1354735859', '1'),
(2, 'BDS', 'B', '1354735547', '1354735859', '1'),
(3, 'BEMS', 'B', '1354735547', '1354735859', '1'),
(4, 'BHLS', 'B', '1354735547', '1354735859', '1'),
(5, 'BHMS', 'B', '1354735547', '1354735859', '1'),
(6, 'BIMS', 'B', '1354735547', '1354735859', '1'),
(7, 'BNYS', 'B', '1354735547', '1354735859', '1'),
(8, 'BSAM', 'B', '1354735547', '1354735859', '1'),
(9, 'BSMS', 'B', '1354735547', '1354735859', '1'),
(10, 'BUMS', 'B', '1354735547', '1354735859', '1'),
(11, 'BVS', 'B', '1354735547', '1354735859', '1'),
(12, 'DAYM', 'B', '1354735547', '1354735859', '1'),
(13, 'DHMS', 'B', '1354735547', '1354735859', '1'),
(14, 'GAMS', 'B', '1354735547', '1354735859', '1'),
(15, 'GFAM', 'B', '1354735547', '1354735859', '1'),
(16, 'LECH', 'B', '1354735547', '1354735859', '1'),
(17, 'MBBS', 'B', '1354735547', '1354735859', '1'),
(18, 'RDS', 'B', '1354735547', '1354735859', '1'),
(19, 'RMP', 'B', '1354735547', '1354735859', '1'),
(20, 'DNB Anatomy MBBS', 'M', '1354735547', '1354735859', '1'),
(21, 'DNB Anesthesiology MBBS', 'M', '1354735547', '1354735859', '1'),
(22, 'DNB Biochemistry MBBS', 'M', '1354735547', '1354735859', '1'),
(23, 'DNB Dermatology &amp;  Venereology MBBS', 'M', '1354735547', '1354735859', '1'),
(24, 'DNB Family Medicine* (Old Rules) MBBS', 'M', '1354735547', '1354735859', '1'),
(25, 'DNB Forensic Medicine MBBS', 'M', '1354735547', '1354735859', '1'),
(26, 'DNB General Medicine MBBS', 'M', '1354735547', '1354735859', '1'),
(27, 'DNB General Surgery MBBS', 'M', '1354735547', '1354735859', '1'),
(28, 'DNB Health Administration including MBBS', 'M', '1354735547', '1354735859', '1'),
(29, 'DNB Microbiology MBBS', 'M', '1354735547', '1354735859', '1'),
(30, 'DNB Nuclear Medicine MBBS', 'M', '1354735547', '1354735859', '1'),
(31, 'DNB Obstetrics &amp; Gynaecology MBBS', 'M', '1354735547', '1354735859', '1'),
(32, 'DNB Ophthalmology MBBS', 'M', '1354735547', '1354735859', '1'),
(33, 'DNB Otorhinoaryngology MBBS', 'M', '1354735547', '1354735859', '1'),
(34, 'DNB Paediatrics MBBS', 'M', '1354735547', '1354735859', '1'),
(35, 'DNB Pathology MBBS', 'M', '1354735547', '1354735859', '1'),
(36, 'DNB Pharmacology MBBS', 'M', '1354735547', '1354735859', '1'),
(37, 'DNB Physical Medicine &amp; Rehabilitation MBBS', 'M', '1354735547', '1354735859', '1'),
(38, 'DNB Physiology MBBS', 'M', '1354735547', '1354735859', '1'),
(39, 'DNB Psychiatry MBBS', 'M', '1354735547', '1354735859', '1'),
(40, 'DNB Radio Diagnosis MBBS', 'M', '1354735547', '1354735859', '1'),
(41, 'DNB Radio Therapy MBBS', 'M', '1354735547', '1354735859', '1'),
(42, 'DNB Respiratory Diseases MBBS', 'M', '1354735547', '1354735859', '1'),
(43, 'DNB Social Preventive Medicine MBBS', 'M', '1354735547', '1354735859', '1'),
(44, 'Hospital Administration', 'M', '1354735547', '1354735859', '1'),
(45, 'MD Acupuncture', 'M', '1354735547', '1354735859', '1'),
(46, 'MD Alternate Medicine', 'M', '1354735547', '1354735859', '1'),
(47, 'MD Alternative Medicine', 'M', '1354735547', '1354735859', '1'),
(48, 'MD Ayurveda', 'M', '1354735547', '1354735859', '1'),
(49, 'MD Homeopathy', 'M', '1354735547', '1354735859', '1'),
(50, 'MD Siddha', 'M', '1354735547', '1354735859', '1'),
(51, 'MD Unani', 'M', '1354735547', '1354735859', '1'),
(52, 'MD(Anaesthesiology)', 'M', '1354735547', '1354735859', '1'),
(53, 'MD(Anatomy)', 'M', '1354735547', '1354735859', '1'),
(54, 'MD(Aviation Medicine)', 'M', '1354735547', '1354735859', '1'),
(55, 'MD(Bio-Chemistry)', 'M', '1354735547', '1354735859', '1'),
(56, 'MD(Bio-Physics)', 'M', '1354735547', '1354735859', '1'),
(57, 'MD(Community Health Administration)', 'M', '1354735547', '1354735859', '1'),
(58, 'MD(Community Medicine)', 'M', '1354735547', '1354735859', '1'),
(59, 'MD(Dermatology and Venerology)', 'M', '1354735547', '1354735859', '1'),
(60, 'MD(Dermatology)', 'M', '1354735547', '1354735859', '1'),
(61, 'MD(Forensic Medicine)', 'M', '1354735547', '1354735859', '1'),
(62, 'MD(General Medicine)', 'M', '1354735547', '1354735859', '1'),
(63, 'MD(General Surgery)', 'M', '1354735547', '1354735859', '1'),
(64, 'MD(Geriatrics)', 'M', '1354735547', '1354735859', '1'),
(65, 'MD(Health Administration)', 'M', '1354735547', '1354735859', '1'),
(66, 'MD(Hospital Administration)', 'M', '1354735547', '1354735859', '1'),
(67, 'MD(Internal Medicine)', 'M', '1354735547', '1354735859', '1'),
(68, 'MD(Lab Medicine)', 'M', '1354735547', '1354735859', '1'),
(69, 'MD(Microbiology)', 'M', '1354735547', '1354735859', '1'),
(70, 'MD(Nuclear Medicine)', 'M', '1354735547', '1354735859', '1'),
(71, 'MD(Obstetrics &amp; Gynaecology)', 'M', '1354735547', '1354735859', '1'),
(72, 'MD(Ophthalmology)', 'M', '1354735547', '1354735859', '1'),
(73, 'MD(Paediatrics)', 'M', '1354735547', '1354735859', '1'),
(74, 'MD(Pathology)', 'M', '1354735547', '1354735859', '1'),
(75, 'MD(Pharmacology)', 'M', '1354735547', '1354735859', '1'),
(76, 'MD(Physical Medicine &amp; Rehabilitation)', 'M', '1354735547', '1354735859', '1'),
(77, 'MD(Physiology)', 'M', '1354735547', '1354735859', '1'),
(78, 'MD(Psychiatry)', 'M', '1354735547', '1354735859', '1'),
(79, 'MD(R &amp; D)', 'M', '1354735547', '1354735859', '1'),
(80, 'MD(Radio Diagnosis)', 'M', '1354735547', '1354735859', '1'),
(81, 'MD(Radio Therapy)', 'M', '1354735547', '1354735859', '1'),
(82, 'MD(Radiology)', 'M', '1354735547', '1354735859', '1'),
(83, 'MD(Social &amp; Preventive Medicine/Comm. Medicine)', 'M', '1354735547', '1354735859', '1'),
(84, 'MD(Tuberculosis &amp; Respiratory Diseases)', 'M', '1354735547', '1354735859', '1'),
(85, 'MD(Venerology)', 'M', '1354735547', '1354735859', '1'),
(86, 'MD/DNB General Medicine or Paediatrics(Cardiology)', 'M', '1354735547', '1354735859', '1'),
(87, 'MD/DNB in General Medicine or Paediatrics(Endocrinology)', 'M', '1354735547', '1354735859', '1'),
(88, 'MD/DNB in General Medicine or Paediatrics(Gastroenterology)', 'M', '1354735547', '1354735859', '1'),
(89, 'MD/DNB in General Medicine or Paediatrics(Medical Oncology)', 'M', '1354735547', '1354735859', '1'),
(90, 'MD/DNB in General Medicine or Paediatrics(Nephrology)', 'M', '1354735547', '1354735859', '1'),
(91, 'MD/DNB in General Medicine or Paediatrics(Neurology)', 'M', '1354735547', '1354735859', '1'),
(92, 'MD/DNB(Anaesthesia)', 'M', '1354735547', '1354735859', '1'),
(93, 'MD/DNB(Biochemistry)', 'M', '1354735547', '1354735859', '1'),
(94, 'MD/DNB(Community Medicine)', 'M', '1354735547', '1354735859', '1'),
(95, 'MD/DNB(Dermatology)', 'M', '1354735547', '1354735859', '1'),
(96, 'MD/DNB(Family Medicine)', 'M', '1354735547', '1354735859', '1'),
(97, 'MD/DNB(General Medicine)', 'M', '1354735547', '1354735859', '1'),
(98, 'MD/DNB(Microbiology)', 'M', '1354735547', '1354735859', '1'),
(99, 'MD/DNB(Obs &amp; Gynaecology)', 'M', '1354735547', '1354735859', '1'),
(100, 'MD/DNB(Paediatrics)', 'M', '1354735547', '1354735859', '1'),
(101, 'MD/DNB(Pathology)', 'M', '1354735547', '1354735859', '1'),
(102, 'MD/DNB(Pharmacology)', 'M', '1354735547', '1354735859', '1'),
(103, 'MD/DNB(Physiology)', 'M', '1354735547', '1354735859', '1'),
(104, 'MD/DNB(Psychiatry)', 'M', '1354735547', '1354735859', '1'),
(105, 'MD/DNB(Pulmonology)', 'M', '1354735547', '1354735859', '1'),
(106, 'MD/DNB(Radiodiagnosis)', 'M', '1354735547', '1354735859', '1'),
(107, 'MD/DNB(Radiotherapy)', 'M', '1354735547', '1354735859', '1'),
(108, 'MDS (Community Dentistry)', 'M', '1354735547', '1354735859', '1'),
(109, 'MDS (Community Dentistry)', 'M', '1354735547', '1354735859', '1'),
(110, 'MDS (Conservative Dentistry)', 'M', '1354735547', '1354735859', '1'),
(111, 'MDS (Operative Dentistry Surgery)', 'M', '1354735547', '1354735859', '1'),
(112, 'MDS (Oral &amp; Maxillofacial Surgery)', 'M', '1354735547', '1354735859', '1'),
(113, 'MDS (Oral Diagnosis and Dental)', 'M', '1354735547', '1354735859', '1'),
(114, 'MDS (Oral Medicine &amp; Radiology)', 'M', '1354735547', '1354735859', '1'),
(115, 'MDS (Oral Medicine)', 'M', '1354735547', '1354735859', '1'),
(116, 'MDS (Oral Surgery)', 'M', '1354735547', '1354735859', '1'),
(117, 'MDS (Orthodontia)', 'M', '1354735547', '1354735859', '1'),
(118, 'MDS (Periodontics)', 'M', '1354735547', '1354735859', '1'),
(119, 'MDS(Oral Pathology &amp; Microbiology)', 'M', '1354735547', '1354735859', '1'),
(120, 'MDS(Oral Pathology)', 'M', '1354735547', '1354735859', '1'),
(121, 'MDS(Orthodontics)', 'M', '1354735547', '1354735859', '1'),
(122, 'MDS(Pedodontia &amp; Preventive Dentistry)', 'M', '1354735547', '1354735859', '1'),
(123, 'MDS(Pedodontia &amp; Preventive Dentistry)', 'M', '1354735547', '1354735859', '1'),
(124, 'MDS(Pedodontics &amp; Preventive Dentistry)', 'M', '1354735547', '1354735859', '1'),
(125, 'MDS(Pedodontics)', 'M', '1354735547', '1354735859', '1'),
(126, 'MDS(Prosthetic Dentistry)', 'M', '1354735547', '1354735859', '1'),
(127, 'MDS(Prosthodontics &amp; Crown Bridge)', 'M', '1354735547', '1354735859', '1'),
(128, 'MDS(Prosthodontics)', 'M', '1354735547', '1354735859', '1'),
(129, 'MDS(Public Health Dentistry)', 'M', '1354735547', '1354735859', '1'),
(130, 'MS Ayurveda', 'M', '1354735547', '1354735859', '1'),
(131, 'MS Siddha', 'M', '1354735547', '1354735859', '1'),
(132, 'MS Unani', 'M', '1354735547', '1354735859', '1'),
(133, 'MS(Anatomy)', 'M', '1354735547', '1354735859', '1'),
(134, 'MS(ENT)', 'M', '1354735547', '1354735859', '1'),
(135, 'MS(General Surgery)', 'M', '1354735547', '1354735859', '1'),
(136, 'MS(Obstetrics &amp; Gynaecology)', 'M', '1354735547', '1354735859', '1'),
(137, 'MS(Ophthalmology)', 'M', '1354735547', '1354735859', '1'),
(138, 'MS(Orthopaedics)', 'M', '1354735547', '1354735859', '1'),
(139, 'MS/DNB in General Surgery(Cardio Thoracic Surgery)', 'M', '1354735547', '1354735859', '1'),
(140, 'MS/DNB in General Surgery(Genito Urinary Surgery (Urology))', 'M', '1354735547', '1354735859', '1'),
(141, 'MS/DNB in General Surgery(Neurosurgery)', 'M', '1354735547', '1354735859', '1'),
(142, 'MS/DNB in General Surgery(Paediatrics Surgery)', 'M', '1354735547', '1354735859', '1'),
(143, 'MS/DNB in General Surgery(Plastic Sugery)', 'M', '1354735547', '1354735859', '1'),
(144, 'MS/DNB in General Surgery(Surgical Gastroenterology)', 'M', '1354735547', '1354735859', '1'),
(145, 'MS/DNB in General Surgery(Surgical Oncology)', 'M', '1354735547', '1354735859', '1'),
(146, 'MS/DNB in Paediatrics(Neonatology)', 'M', '1354735547', '1354735859', '1'),
(147, 'MS/DNB in Pharmacology(Clinical Pharmacology)', 'M', '1354735547', '1354735859', '1'),
(148, 'MS/DNB(Anatomy)', 'M', '1354735547', '1354735859', '1'),
(149, 'MS/DNB(ENT)', 'M', '1354735547', '1354735859', '1'),
(150, 'MS/DNB(Forensic Medicine)', 'M', '1354735547', '1354735859', '1'),
(151, 'MS/DNB(General Surgery)', 'M', '1354735547', '1354735859', '1'),
(152, 'MS/DNB(Ophthalmology)', 'M', '1354735547', '1354735859', '1'),
(153, 'MS/DNB(Orthopaedics)', 'M', '1354735547', '1354735859', '1');

-- --------------------------------------------------------

--
-- Table structure for table `dgo_specialization`
--

DROP TABLE IF EXISTS `dgo_specialization`;
CREATE TABLE IF NOT EXISTS `dgo_specialization` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Specialization Id',
  `specName` varchar(255) NOT NULL COMMENT 'Specialization Name',
  `createDt` varchar(255) NOT NULL COMMENT 'Create Date',
  `modifyDt` varchar(255) NOT NULL COMMENT 'Modify Date',
  `status` enum('0','1') NOT NULL COMMENT '1=Active,0=Inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=192 ;

--
-- Dumping data for table `dgo_specialization`
--

INSERT INTO `dgo_specialization` (`id`, `specName`, `createDt`, `modifyDt`, `status`) VALUES
(1, 'Aesthetic Dentistry', '1354735547', '1354735547', '1'),
(2, 'Algology', '1354735547', '1354735547', '1'),
(3, 'Alternative Medicine', '1354735547', '1354735547', '1'),
(4, 'Anaesthesia', '1354735547', '1354735547', '1'),
(5, 'Anatomy', '1354735547', '1354735547', '1'),
(6, 'Andrology', '1354735547', '1354735547', '1'),
(7, 'Anesthesia', '1354735547', '1354735547', '1'),
(8, 'Audiology', '1354735547', '1354735547', '1'),
(9, 'Aviation Medicine', '1354735547', '1354735547', '1'),
(10, 'Ayurveda', '1354735547', '1354735547', '1'),
(11, 'Ayurvedic Therapy', '1354735547', '1354735547', '1'),
(12, 'Bacteriology', '1354735547', '1354735547', '1'),
(13, 'Bariatric Surgery', '1354735547', '1354735547', '1'),
(14, 'Behavioural Medicine', '1354735547', '1354735547', '1'),
(15, 'Bio Physics', '1354735547', '1354735547', '1'),
(16, 'Biochemistry', '1354735547', '1354735547', '1'),
(17, 'Blood Bank', '1354735547', '1354735547', '1'),
(18, 'Bone &amp; Joints', '1354735547', '1354735547', '1'),
(19, 'Cardiac Anaesthesia', '1354735547', '1354735547', '1'),
(20, 'Cardiac Surgery', '1354735547', '1354735547', '1'),
(21, 'Cardio Thoracic Surgery', '1354735547', '1354735547', '1'),
(22, 'Cardio Vascular Surgery', '1354735547', '1354735547', '1'),
(23, 'Cardiology', '1354735547', '1354735547', '1'),
(24, 'Cataract', '1354735547', '1354735547', '1'),
(25, 'Chest Physician', '1354735547', '1354735547', '1'),
(26, 'Chromo Therapy', '1354735547', '1354735547', '1'),
(27, 'Clinical Haematology', '1354735547', '1354735547', '1'),
(28, 'Clinical Neurophysiology', '1354735547', '1354735547', '1'),
(29, 'Clinical Pathology', '1354735547', '1354735547', '1'),
(30, 'Clinical Pharmacology', '1354735547', '1354735547', '1'),
(31, 'Clinical Psychologist', '1354735547', '1354735547', '1'),
(32, 'Colorectal Surgery', '1354735547', '1354735547', '1'),
(33, 'Community Dentistry', '1354735547', '1354735547', '1'),
(34, 'Community Medicine', '1354735547', '1354735547', '1'),
(35, 'Conservative Dentistry', '1354735547', '1354735547', '1'),
(36, 'Cornea', '1354735547', '1354735547', '1'),
(37, 'Cosmetic Dental Surgery', '1354735547', '1354735547', '1'),
(38, 'Cosmetic Surgeon', '1354735547', '1354735547', '1'),
(39, 'Cosmetic Surgery', '1354735547', '1354735547', '1'),
(40, 'Critical Care', '1354735547', '1354735547', '1'),
(41, 'Critical Care &amp; Pulmonology', '1354735547', '1354735547', '1'),
(42, 'Cryo Surgery', '1354735547', '1354735547', '1'),
(43, 'CTVS', '1354735547', '1354735547', '1'),
(44, 'Dermatology', '1354735547', '1354735547', '1'),
(45, 'Dermatology and Venereology', '1354735547', '1354735547', '1'),
(46, 'Dermatology and Venereology', '1354735547', '1354735547', '1'),
(47, 'Diabetes', '1354735547', '1354735547', '1'),
(48, 'Dietetics', '1354735547', '1354735547', '1'),
(49, 'Doctor Acupressure', '1354735547', '1354735547', '1'),
(50, 'Doctor Acupunture', '1354735547', '1354735547', '1'),
(51, 'Doctor Ayurvedic', '1354735547', '1354735547', '1'),
(52, 'Doctor Homeopathy', '1354735547', '1354735547', '1'),
(53, 'Doctor Siddha', '1354735547', '1354735547', '1'),
(54, 'Doctor Unani', '1354735547', '1354735547', '1'),
(55, 'Doctor Yoga', '1354735547', '1354735547', '1'),
(56, 'Emergency Medicine', '1354735547', '1354735547', '1'),
(57, 'Endocrine Surgery', '1354735547', '1354735547', '1'),
(58, 'Endocrinology', '1354735547', '1354735547', '1'),
(59, 'Endodontics', '1354735547', '1354735547', '1'),
(60, 'ENT', '1354735547', '1354735547', '1'),
(61, 'Family Medicine', '1354735547', '1354735547', '1'),
(62, 'Fertility', '1354735547', '1354735547', '1'),
(63, 'Forensic Medicine', '1354735547', '1354735547', '1'),
(64, 'Fortis City Center', '1354735547', '1354735547', '1'),
(65, 'G.I. Surgeon &amp; Endoscopist', '1354735547', '1354735547', '1'),
(66, 'Gastroenterology', '1354735547', '1354735547', '1'),
(67, 'Gastrointestinal Surgery', '1354735547', '1354735547', '1'),
(68, 'General Anaesthesia', '1354735547', '1354735547', '1'),
(69, 'General Dentist', '1354735547', '1354735547', '1'),
(70, 'General Medicine', '1354735547', '1354735547', '1'),
(71, 'General Physician', '1354735547', '1354735547', '1'),
(72, 'General Practitioner', '1354735547', '1354735547', '1'),
(73, 'General Surgery', '1354735547', '1354735547', '1'),
(74, 'Genetics', '1354735547', '1354735547', '1'),
(75, 'Geriatrics', '1354735547', '1354735547', '1'),
(76, 'GI Surgery', '1354735547', '1354735547', '1'),
(77, 'Glaucoma', '1354735547', '1354735547', '1'),
(78, 'Gynecology &amp; Obstetrics', '1354735547', '1354735547', '1'),
(79, 'Hematology', '1354735547', '1354735547', '1'),
(80, 'Hepatology', '1354735547', '1354735547', '1'),
(81, 'HIV Medicine', '1354735547', '1354735547', '1'),
(82, 'Homeopathy', '1354735547', '1354735547', '1'),
(83, 'Hydro Therapy', '1354735547', '1354735547', '1'),
(84, 'Immunology', '1354735547', '1354735547', '1'),
(85, 'Implantologist', '1354735547', '1354735547', '1'),
(86, 'Infectious Diseases', '1354735547', '1354735547', '1'),
(87, 'Intensive Care', '1354735547', '1354735547', '1'),
(88, 'Internal Medicine', '1354735547', '1354735547', '1'),
(89, 'Interventional Cardiologist', '1354735547', '1354735547', '1'),
(90, 'IVF and Reproductive Medicine', '1354735547', '1354735547', '1'),
(91, 'Joint Reconstruction', '1354735547', '1354735547', '1'),
(92, 'Laparoscopic Surgery', '1354735547', '1354735547', '1'),
(93, 'Laproscopic Surgery', '1354735547', '1354735547', '1'),
(94, 'Liver Transplant', '1354735547', '1354735547', '1'),
(95, 'Magnetic therapy', '1354735547', '1354735547', '1'),
(96, 'Massage Therapy', '1354735547', '1354735547', '1'),
(97, 'Medical Administration', '1354735547', '1354735547', '1'),
(98, 'Medical Services', '1354735547', '1354735547', '1'),
(99, 'Medical Virology', '1354735547', '1354735547', '1'),
(100, 'Microbiology', '1354735547', '1354735547', '1'),
(101, 'Mud Therapy', '1354735547', '1354735547', '1'),
(102, 'Multi Speciality', '1354735547', '1354735547', '1'),
(103, 'Naturopathy', '1354735547', '1354735547', '1'),
(104, 'Neonatology', '1354735547', '1354735547', '1'),
(105, 'Nephrology', '1354735547', '1354735547', '1'),
(106, 'Neuro Surgery', '1354735547', '1354735547', '1'),
(107, 'Neuro Anaesthesia', '1354735547', '1354735547', '1'),
(108, 'Neuro Radiology', '1354735547', '1354735547', '1'),
(109, 'Neuro Surgery', '1354735547', '1354735547', '1'),
(110, 'Neurology', '1354735547', '1354735547', '1'),
(111, 'Non Invasive Cardiology', '1354735547', '1354735547', '1'),
(112, 'Nuclear Medicine', '1354735547', '1354735547', '1'),
(113, 'Nutritionist', '1354735547', '1354735547', '1'),
(114, 'Obstetrics &amp; Gynaecology', '1354735547', '1354735547', '1'),
(115, 'Obstetrics and Gynaecology', '1354735547', '1354735547', '1'),
(116, 'Occupational Health', '1354735547', '1354735547', '1'),
(117, 'Oculoplast', '1354735547', '1354735547', '1'),
(118, 'Oncology', '1354735547', '1354735547', '1'),
(119, 'Ophthalmology', '1354735547', '1354735547', '1'),
(120, 'Optometry', '1354735547', '1354735547', '1'),
(121, 'Optometry/Vision Therapy', '1354735547', '1354735547', '1'),
(122, 'Oral &amp; Maxillofacial Surgery', '1354735547', '1354735547', '1'),
(123, 'Oral Medicine', '1354735547', '1354735547', '1'),
(124, 'Oral Pathology', '1354735547', '1354735547', '1'),
(125, 'Oral Pathology &amp; Microbiology', '1354735547', '1354735547', '1'),
(126, 'Oral Surgery', '1354735547', '1354735547', '1'),
(127, 'Orthodontics', '1354735547', '1354735547', '1'),
(128, 'Orthopaedics', '1354735547', '1354735547', '1'),
(129, 'Paediatric Cardiology', '1354735547', '1354735547', '1'),
(130, 'Paediatric Neurology', '1354735547', '1354735547', '1'),
(131, 'Paediatric Pulmonology', '1354735547', '1354735547', '1'),
(132, 'Paediatric Surgery', '1354735547', '1354735547', '1'),
(133, 'Paediatrics', '1354735547', '1354735547', '1'),
(134, 'Paediatrics &amp; NICU Incharge', '1354735547', '1354735547', '1'),
(135, 'Paediatrics Surgery', '1354735547', '1354735547', '1'),
(136, 'Pain Clinic', '1354735547', '1354735547', '1'),
(137, 'Panchkarma Therapy', '1354735547', '1354735547', '1'),
(138, 'Pathology', '1354735547', '1354735547', '1'),
(139, 'Pediactric Cardiac Surgery', '1354735547', '1354735547', '1'),
(140, 'Pediatric Hepatologist &amp; Gastroenterologist', '1354735547', '1354735547', '1'),
(141, 'Pediatric surgery', '1354735547', '1354735547', '1'),
(142, 'Pediatrics and Neonatology', '1354735547', '1354735547', '1'),
(143, 'Pediatrics Neurology', '1354735547', '1354735547', '1'),
(144, 'Pedodontics', '1354735547', '1354735547', '1'),
(145, 'Pedodontics &amp; Preventive Dentistry', '1354735547', '1354735547', '1'),
(146, 'Peridontics', '1354735547', '1354735547', '1'),
(147, 'Periodontics', '1354735547', '1354735547', '1'),
(148, 'Pharmacology', '1354735547', '1354735547', '1'),
(149, 'PHC &amp; NIC', '1354735547', '1354735547', '1'),
(150, 'Physical Medicine &amp; Rehabilitation', '1354735547', '1354735547', '1'),
(151, 'Physical Medicine Rehabilitation', '1354735547', '1354735547', '1'),
(152, 'Physiology', '1354735547', '1354735547', '1'),
(153, 'Physiotheraphy', '1354735547', '1354735547', '1'),
(154, 'Physiotherapy and Rehabilitation', '1354735547', '1354735547', '1'),
(155, 'Plastic Surgery', '1354735547', '1354735547', '1'),
(156, 'Podiatric Surgery', '1354735547', '1354735547', '1'),
(157, 'Prosthodontics', '1354735547', '1354735547', '1'),
(158, 'Psychiatry', '1354735547', '1354735547', '1'),
(159, 'Psychologist', '1354735547', '1354735547', '1'),
(160, 'Psychology', '1354735547', '1354735547', '1'),
(161, 'Public Health Dentistry', '1354735547', '1354735547', '1'),
(162, 'Pulmonology', '1354735547', '1354735547', '1'),
(163, 'Radio Diagnosis', '1354735547', '1354735547', '1'),
(164, 'Radio Therapy', '1354735547', '1354735547', '1'),
(165, 'Radiology', '1354735547', '1354735547', '1'),
(166, 'Refractive Surgery', '1354735547', '1354735547', '1'),
(167, 'Renal Transplant &amp; Urology', '1354735547', '1354735547', '1'),
(168, 'Retina', '1354735547', '1354735547', '1'),
(169, 'Rheumatology', '1354735547', '1354735547', '1'),
(170, 'Sexology', '1354735547', '1354735547', '1'),
(171, 'Skin and VD', '1354735547', '1354735547', '1'),
(172, 'Social &amp; Preventive Medicine', '1354735547', '1354735547', '1'),
(173, 'Speech Therapy', '1354735547', '1354735547', '1'),
(174, 'Spine Surgeon', '1354735547', '1354735547', '1'),
(175, 'Sports Medicine', '1354735547', '1354735547', '1'),
(176, 'Squint', '1354735547', '1354735547', '1'),
(177, 'Surgical Gastroenterology', '1354735547', '1354735547', '1'),
(178, 'Surgical Oncology', '1354735547', '1354735547', '1'),
(179, 'Thoracic Surgery', '1354735547', '1354735547', '1'),
(180, 'Transfusion Medicine', '1354735547', '1354735547', '1'),
(181, 'Transplant Surgery', '1354735547', '1354735547', '1'),
(182, 'Trauma Surgery', '1354735547', '1354735547', '1'),
(183, 'Tropical Medicine', '1354735547', '1354735547', '1'),
(184, 'Ultrasonologist', '1354735547', '1354735547', '1'),
(185, 'Ultrasonology', '1354735547', '1354735547', '1'),
(186, 'Urology', '1354735547', '1354735547', '1'),
(187, 'Uvea', '1354735547', '1354735547', '1'),
(188, 'Vascular Surgery', '1354735547', '1354735547', '1'),
(189, 'Venereology', '1354735547', '1354735547', '1'),
(190, 'Veterinary', '1354735547', '1354735547', '1'),
(191, 'Weight Loss Consultant', '1354735547', '1354735547', '1');

-- --------------------------------------------------------

--
-- Table structure for table `dgo_states`
--

DROP TABLE IF EXISTS `dgo_states`;
CREATE TABLE IF NOT EXISTS `dgo_states` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'State Id',
  `cid` varchar(11) NOT NULL COMMENT 'Country Id',
  `stateName` varchar(255) NOT NULL COMMENT 'State Name',
  `createDt` varchar(255) NOT NULL COMMENT 'Create Date',
  `modifyDt` varchar(255) NOT NULL COMMENT 'Modified Date',
  `status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0=InActive,1=Active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `dgo_states`
--

INSERT INTO `dgo_states` (`id`, `cid`, `stateName`, `createDt`, `modifyDt`, `status`) VALUES
(1, '1', 'West Bengal', '1355078535', '1355079429', '1'),
(2, '1', 'Assam', '1355341780', '1356244385', '1'),
(3, '1', 'Delhi', '1355341792', '1355341792', '1'),
(4, '1', 'Maharastra', '1355341803', '1355341803', '1'),
(5, '1', 'Bihar', '1355341811', '1355341811', '1');

-- --------------------------------------------------------

--
-- Table structure for table `dgo_users`
--

DROP TABLE IF EXISTS `dgo_users`;
CREATE TABLE IF NOT EXISTS `dgo_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'User ID',
  `email` varchar(255) NOT NULL COMMENT 'Email Address',
  `password` varchar(255) NOT NULL COMMENT 'Encrypted Password',
  `status` enum('1','0','-1') NOT NULL DEFAULT '0' COMMENT 'Status 1=Active,0=Inactive,-1=Deleted',
  `verify_code` varchar(255) NOT NULL COMMENT 'Verify Code sent to user email',
  `verify_status` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Verify Status 0=not verified, 1=Verified',
  `tid` varchar(11) NOT NULL COMMENT 'User Type Id',
  `createDt` varchar(255) NOT NULL COMMENT 'Create Date',
  `modifyDt` varchar(255) NOT NULL COMMENT 'Modify Date',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dgo_users_types`
--

DROP TABLE IF EXISTS `dgo_users_types`;
CREATE TABLE IF NOT EXISTS `dgo_users_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Type Id',
  `utypeName` varchar(255) NOT NULL COMMENT 'User Type Name',
  `createDt` varchar(255) NOT NULL COMMENT 'Create Date',
  `modifyDt` varchar(255) NOT NULL COMMENT 'Modify Date',
  `status` enum('1','0') NOT NULL DEFAULT '0' COMMENT '1=Active,0=Inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `dgo_users_types`
--

INSERT INTO `dgo_users_types` (`id`, `utypeName`, `createDt`, `modifyDt`, `status`) VALUES
(1, 'Normal Site User', '1355941506', '1355941506', '1'),
(2, 'Doctor', '1355941506', '1355941506', '1'),
(3, 'Hospital', '1355941506', '1355941506', '1'),
(4, 'Blood Donor', '1355941506', '1355941506', '1'),
(5, 'Ambulance', '1355941506', '1355941506', '1'),
(6, 'Ayah / Nursing Centre', '1355941506', '1355941506', '1'),
(7, 'Pathological Center', '1355941506', '1355941506', '1');

-- --------------------------------------------------------

--
-- Table structure for table `dgo_user_doctor_clinics`
--

DROP TABLE IF EXISTS `dgo_user_doctor_clinics`;
CREATE TABLE IF NOT EXISTS `dgo_user_doctor_clinics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `did` varchar(11) NOT NULL COMMENT 'Id from Doctor Details Table',
  `clinicName` varchar(255) NOT NULL COMMENT 'Clinic Name',
  `clinicAddress` text NOT NULL COMMENT 'Clinic Address',
  `clinicPhoneNumber` varchar(255) NOT NULL COMMENT 'Clinic Phone Number',
  `clinicCharges` decimal(7,2) NOT NULL DEFAULT '0.00' COMMENT 'Charges',
  `xray` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT 'X-Ray',
  `creditCardAccept` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT 'Credit Card Acceptable',
  `Emergency` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT 'Emergency',
  `ownUnit` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT 'Own Unit',
  `homeUnit` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT 'Home Visit',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `dgo_user_doctor_clinics`
--

INSERT INTO `dgo_user_doctor_clinics` (`id`, `did`, `clinicName`, `clinicAddress`, `clinicPhoneNumber`, `clinicCharges`, `xray`, `creditCardAccept`, `Emergency`, `ownUnit`, `homeUnit`) VALUES
(1, '1', 'Das Medical', '211, Prasanna Chatterje Road, Ghola, Sodepur, Kolkata - 700112\r\n\r\nNear Ghola High School', '+913325697896', '150.00', 'Y', 'Y', 'Y', 'Y', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `dgo_user_doctor_clinics_timings`
--

DROP TABLE IF EXISTS `dgo_user_doctor_clinics_timings`;
CREATE TABLE IF NOT EXISTS `dgo_user_doctor_clinics_timings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clnid` varchar(255) NOT NULL COMMENT 'Clinic ID from Doctor Clinics Table',
  `daySun` varchar(255) NOT NULL COMMENT 'Sunday',
  `dayMon` varchar(255) NOT NULL COMMENT 'Monday',
  `dayTue` varchar(255) NOT NULL COMMENT 'Tuesday',
  `dayWed` varchar(255) NOT NULL COMMENT 'Wednusday',
  `dayThur` varchar(255) NOT NULL COMMENT 'Thursday',
  `dayFri` varchar(255) NOT NULL COMMENT 'Friday',
  `daySat` varchar(255) NOT NULL COMMENT 'Saturday',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `dgo_user_doctor_clinics_timings`
--

INSERT INTO `dgo_user_doctor_clinics_timings` (`id`, `clnid`, `daySun`, `dayMon`, `dayTue`, `dayWed`, `dayThur`, `dayFri`, `daySat`) VALUES
(1, '1', '11.00AM - 02.00PM & 03.00PM-04.00PM', '06.00PM-08.00PM', '06.00PM-08.00PM', '06.00PM-08.00PM', '06.00PM-08.00PM', '06.00PM-08.00PM', '');

-- --------------------------------------------------------

--
-- Table structure for table `dgo_user_doctor_details`
--

DROP TABLE IF EXISTS `dgo_user_doctor_details`;
CREATE TABLE IF NOT EXISTS `dgo_user_doctor_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `did` varchar(11) NOT NULL COMMENT 'Doctor ID from User Table',
  `firstName` varchar(255) NOT NULL COMMENT 'First Name',
  `lastName` varchar(255) NOT NULL COMMENT 'Last Name',
  `middleName` varchar(255) NOT NULL COMMENT 'Middle Name',
  `gender` enum('M','F') NOT NULL DEFAULT 'M' COMMENT 'M=Male,F=Female',
  `dateOfBirth` date NOT NULL DEFAULT '1970-01-01' COMMENT 'Data of Birth YYYY-MM-DD format',
  `address` text NOT NULL COMMENT 'Address',
  `cid` varchar(11) NOT NULL COMMENT 'City Id from City Table',
  `sid` varchar(11) NOT NULL COMMENT 'State Id From States Table',
  `zid` varchar(11) NOT NULL COMMENT 'Zone Id from Zones Table',
  `aid` varchar(11) NOT NULL COMMENT 'Area Id from Areas Table',
  `pincode` varchar(255) NOT NULL COMMENT 'Pincode',
  `emailAlternate` varchar(255) NOT NULL COMMENT 'Alternate Email',
  `website` varchar(255) NOT NULL COMMENT 'Website',
  `mobileNo` varchar(255) NOT NULL COMMENT 'Mobile Number',
  `phoneNo` varchar(255) NOT NULL COMMENT 'LandLine/Phone Number',
  `phoneNoAlternate` varchar(255) NOT NULL COMMENT 'Alternate Phone Number',
  `fax` varchar(255) NOT NULL COMMENT 'Fax Number',
  `creditCardAccept` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT 'Y=Yes,N=No',
  `specid` varchar(11) NOT NULL COMMENT 'Specialization Id from Specilization Table',
  `available24Hrs` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT 'Y=Yes,N=No',
  `about` text NOT NULL COMMENT 'About Doctor',
  `yearsOfExp` varchar(11) NOT NULL COMMENT 'Years of Experience',
  `registrationNo` varchar(255) NOT NULL COMMENT 'Registration Number',
  `designation` varchar(255) NOT NULL COMMENT 'Designation',
  `consultancyFees` decimal(7,2) NOT NULL DEFAULT '0.00' COMMENT 'Consultancy Fees',
  `status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0=InActive,1=Active',
  `createDt` varchar(255) NOT NULL COMMENT 'Create Date',
  `modifyDt` varchar(255) NOT NULL COMMENT 'Modify Date',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `dgo_user_doctor_details`
--

INSERT INTO `dgo_user_doctor_details` (`id`, `did`, `firstName`, `lastName`, `middleName`, `gender`, `dateOfBirth`, `address`, `cid`, `sid`, `zid`, `aid`, `pincode`, `emailAlternate`, `website`, `mobileNo`, `phoneNo`, `phoneNoAlternate`, `fax`, `creditCardAccept`, `specid`, `available24Hrs`, `about`, `yearsOfExp`, `registrationNo`, `designation`, `consultancyFees`, `status`, `createDt`, `modifyDt`) VALUES
(1, '', 'Arindam', 'Chatterjee', 'Kumar', 'M', '1970-01-01', '207, S.N.K Road, Baguihati, Kolkata-700071', '1', '1', '1', '1', '700071', 'achatterjee@gmail.com', 'http://www.facebook.com/achatterjeedoc', '9830090428', '03325937896', '03378963214', '03378963214', 'Y', '2', 'Y', 'I am doctor, specialized in Cardiac Surgery. I have working in this field for about 10Years.', '10', 'WB/012/45697', 'Cosultant', '200.00', '1', '1356243641', '1356463210'),
(3, '', 'Samannoy', 'Mukherjee', 'Roy', 'M', '1970-01-01', '207,Prafulla Kanan(East), Kestopur, Kolkata-700123.', '1', '1', '1', '3', '700123', 'samannoy.chatterjee@thinkb.in', 'http://thinkb.in', '9830098300', '03321237896', '03396321478', '03325896321', 'Y', '11', 'Y', 'I am expert in Ayurvedic Theraph.', '5', 'WB/21/021/ABC', 'Therapy Expert', '150.00', '1', '1356463720', '1356463720');

-- --------------------------------------------------------

--
-- Table structure for table `dgo_user_doctor_qualifications`
--

DROP TABLE IF EXISTS `dgo_user_doctor_qualifications`;
CREATE TABLE IF NOT EXISTS `dgo_user_doctor_qualifications` (
  `did` varchar(11) NOT NULL COMMENT 'Id from Doctor Details Table ',
  `qid` varchar(11) NOT NULL COMMENT 'Qualification Id from Qualification Table',
  `yearOfCompletion` varchar(11) NOT NULL COMMENT 'Year of Qualification',
  `instituteName` varchar(255) NOT NULL COMMENT 'Institute/University Name'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dgo_user_normal_details`
--

DROP TABLE IF EXISTS `dgo_user_normal_details`;
CREATE TABLE IF NOT EXISTS `dgo_user_normal_details` (
  `id` varchar(11) NOT NULL COMMENT 'User ID From User Table',
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `alternate_email` varchar(255) NOT NULL,
  `dateOfBirth` date NOT NULL DEFAULT '1970-01-01',
  `addressLine1` text NOT NULL,
  `addressLine2` text NOT NULL,
  `phoneNumber` varchar(255) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dgo_zones`
--

DROP TABLE IF EXISTS `dgo_zones`;
CREATE TABLE IF NOT EXISTS `dgo_zones` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Zone id',
  `zoneName` varchar(255) NOT NULL COMMENT 'Zone Name',
  `createDt` varchar(255) NOT NULL COMMENT 'Create Date',
  `modifyDt` varchar(255) NOT NULL COMMENT 'Modified Date',
  `status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0=InActive,1=Active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `dgo_zones`
--

INSERT INTO `dgo_zones` (`id`, `zoneName`, `createDt`, `modifyDt`, `status`) VALUES
(1, 'North', '1355078535', '1355078535', '1'),
(2, 'South', '1355078535', '1355078535', '1'),
(3, 'East', '1355078535', '1355078535', '1'),
(4, 'West', '1355078535', '1355078535', '1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
