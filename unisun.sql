-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- 主機: 127.0.0.1
-- 產生日期: 2013 年 07 月 31 日 15:14
-- 伺服器版本: 5.5.27
-- PHP 版本: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 資料庫: `unisun`
--

-- --------------------------------------------------------

--
-- 表的結構 `captcha`
--

CREATE TABLE IF NOT EXISTS `captcha` (
  `captcha_id` bigint(13) unsigned NOT NULL AUTO_INCREMENT,
  `captcha_time` int(10) unsigned NOT NULL,
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `word` varchar(20) NOT NULL,
  PRIMARY KEY (`captcha_id`),
  KEY `word` (`word`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=452 ;

--
-- 轉存資料表中的資料 `captcha`
--

INSERT INTO `captcha` (`captcha_id`, `captcha_time`, `ip_address`, `word`) VALUES
(448, 1375248242, '127.0.0.1', 'm3yx42bwb'),
(449, 1375254736, '127.0.0.1', '2oumkk6lu'),
(450, 1375254756, '127.0.0.1', '1bwgqx8kb'),
(451, 1375254773, '127.0.0.1', 'rkd3irek6');

-- --------------------------------------------------------

--
-- 表的結構 `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 轉存資料表中的資料 `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('6911bab865c917a2d096f2c2bd69fe9e', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.72 Safari/537.36', 1375254786, 'a:11:{s:9:"user_data";s:0:"";s:8:"username";s:9:" Davin So";s:7:"account";s:7:"sodavin";s:7:"groupID";s:1:"6";s:10:"employeeID";s:2:"13";s:4:"lang";s:5:"en_US";s:7:"logined";b:1;s:9:"loginTime";i:1375254786;s:12:"languageType";a:2:{s:5:"en_US";s:7:"English";s:5:"zh_TW";s:19:"Chinese Traditional";}s:8:"menuType";a:5:{i:0;a:3:{s:4:"name";s:16:"Admin Management";s:2:"id";s:2:"46";s:8:"menulist";a:3:{i:0;a:3:{s:4:"name";s:16:"Admin Management";s:4:"link";s:15:"adminManagement";s:2:"id";s:2:"20";}i:1;a:3:{s:4:"name";s:16:"IT Data C ontrol";s:4:"link";s:0:"";s:2:"id";s:1:"7";}i:2;a:3:{s:4:"name";s:15:"Task Management";s:4:"link";s:7:"taskMan";s:2:"id";s:1:"8";}}}i:1;a:3:{s:4:"name";s:25:"Human Resource Management";s:2:"id";s:2:"34";s:8:"menulist";a:3:{i:0;a:3:{s:4:"name";s:25:"Human Resource Management";s:4:"link";s:9:"humanMain";s:2:"id";s:2:"18";}i:1;a:3:{s:4:"name";s:13:"Employee List";s:4:"link";s:8:"employee";s:2:"id";s:2:"10";}i:2;a:3:{s:4:"name";s:17:"Attendance Record";s:4:"link";s:9:"attRecord";s:2:"id";s:2:"11";}}}i:2;a:3:{s:4:"name";s:19:"Purchase Management";s:2:"id";s:2:"44";s:8:"menulist";a:4:{i:0;a:3:{s:4:"name";s:20:"InforMation Registry";s:4:"link";s:15:"pruInfoRegistry";s:2:"id";s:1:"3";}i:1;a:3:{s:4:"name";s:16:"Purchase Request";s:4:"link";s:15:"purchaseRequest";s:2:"id";s:1:"4";}i:2;a:3:{s:4:"name";s:14:"Purchase Order";s:4:"link";s:13:"purchaseOrder";s:2:"id";s:1:"5";}i:3;a:3:{s:4:"name";s:13:"Report Center";s:4:"link";s:14:"purchaseReport";s:2:"id";s:1:"6";}}}i:3;a:3:{s:4:"name";s:20:"Inventory Management";s:2:"id";s:2:"45";s:8:"menulist";a:4:{i:0;a:3:{s:4:"name";s:20:"Information Registry";s:4:"link";s:15:"invInfoRegistry";s:2:"id";s:2:"12";}i:1;a:3:{s:4:"name";s:25:"Material Request & Return";s:4:"link";s:10:"materialRR";s:2:"id";s:2:"13";}i:2;a:3:{s:4:"name";s:28:"Tools & Equipment Management";s:4:"link";s:9:"teManager";s:2:"id";s:2:"14";}i:3;a:3:{s:4:"name";s:13:"Report Center";s:4:"link";s:15:"inventoryReport";s:2:"id";s:2:"15";}}}i:5;a:3:{s:4:"name";s:12:"Project List";s:2:"id";s:2:"19";s:8:"menulist";a:1:{i:0;a:3:{s:4:"name";s:12:"Project List";s:4:"link";s:4:"proj";s:2:"id";s:2:"16";}}}}s:11:"engMenuType";a:7:{i:0;s:15:"is English Name";i:46;s:16:"Admin Management";i:34;s:25:"Human Resource Management";i:44;s:19:"Purchase Management";i:45;s:20:"Inventory Management";i:47;s:18:"Drawing Management";i:19;s:12:"Project List";}}');

-- --------------------------------------------------------

--
-- 表的結構 `drawing`
--

CREATE TABLE IF NOT EXISTS `drawing` (
  `drawingID` int(11) NOT NULL AUTO_INCREMENT,
  `drawingNo` varchar(20) NOT NULL,
  `projectID` int(11) NOT NULL,
  `version` int(11) NOT NULL,
  `description` varchar(500) NOT NULL,
  `draw` int(11) NOT NULL,
  `check` int(11) NOT NULL,
  `approved` int(11) NOT NULL,
  `autocadLink` varchar(255) NOT NULL,
  `pdfLink` varchar(255) NOT NULL,
  `cDate` date NOT NULL,
  `managerID` int(11) NOT NULL,
  `toGM` int(11) NOT NULL,
  `toDGM` int(11) NOT NULL,
  `toPM` int(11) NOT NULL,
  `toSubcontractor` int(11) NOT NULL,
  `toClient` int(11) NOT NULL,
  `revision` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `uDate` date NOT NULL,
  PRIMARY KEY (`drawingID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 轉存資料表中的資料 `drawing`
--

INSERT INTO `drawing` (`drawingID`, `drawingNo`, `projectID`, `version`, `description`, `draw`, `check`, `approved`, `autocadLink`, `pdfLink`, `cDate`, `managerID`, `toGM`, `toDGM`, `toPM`, `toSubcontractor`, `toClient`, `revision`, `status`, `uDate`) VALUES
(5, 'draw00004', 5, 1, 'abc', 1, 1, 2, '', '', '2013-05-17', 1, 0, 0, 0, 0, 0, 0, 1, '2013-05-30'),
(6, 'draw00003', 4, 1, '5566', 2, 1, 2, '', '', '2013-05-17', 1, 0, 0, 0, 0, 0, 0, 0, '2013-05-30'),
(7, 'draw00002', 1, 1, '', 2, 2, 1, '', '', '2013-05-17', 1, 0, 0, 0, 0, 0, 0, 0, '2013-05-30'),
(8, 'draw00001', 5, 2, '', 1, 1, 2, '', '', '2013-05-17', 1, 0, 1, 0, 1, 0, 1, 3, '2013-05-17'),
(9, 'Draw00010', 4, 1, '123', 8, 0, 0, '', '', '2013-06-25', 8, 0, 0, 0, 0, 0, 1, 1, '0000-00-00');

-- --------------------------------------------------------

--
-- 表的結構 `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `employeeID` int(11) NOT NULL AUTO_INCREMENT,
  `emplyoeeNo` varchar(50) NOT NULL COMMENT '員工編號',
  `nameFirst` varchar(255) NOT NULL COMMENT '名',
  `nameLast` varchar(255) NOT NULL COMMENT '姓',
  `Gender` int(11) NOT NULL COMMENT '性別',
  `birthday` date NOT NULL COMMENT '生日',
  `UID` varchar(50) NOT NULL COMMENT '身份證/護照號碼',
  `starDate` date NOT NULL COMMENT '到職日',
  `endDate` date NOT NULL COMMENT '離職日',
  `phone` varchar(100) NOT NULL COMMENT '家用電話',
  `cellPhone` varchar(100) NOT NULL COMMENT '手機',
  `status` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL COMMENT '級職',
  `construction` varchar(255) NOT NULL,
  `interior` varchar(255) NOT NULL,
  `MEP` varchar(255) NOT NULL,
  `contactNo` varchar(50) NOT NULL,
  `type` int(11) NOT NULL COMMENT '類別',
  `account` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `groupID` int(11) NOT NULL COMMENT '群組id',
  `enable` int(11) NOT NULL,
  `skype` varchar(100) NOT NULL,
  `compMobile` varchar(20) NOT NULL,
  `personalMobile` varchar(20) NOT NULL,
  `ext` int(11) NOT NULL COMMENT '公司電話分機',
  `employmentDate` date NOT NULL,
  `eMail` varchar(50) NOT NULL,
  `location` int(11) NOT NULL COMMENT 'Head Office or Site',
  `age` int(11) NOT NULL,
  `cDate` date NOT NULL,
  `uDate` date NOT NULL,
  `managerID` int(11) NOT NULL,
  PRIMARY KEY (`employeeID`),
  KEY `emplyoeeNo` (`emplyoeeNo`),
  KEY `account` (`account`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- 轉存資料表中的資料 `employee`
--

INSERT INTO `employee` (`employeeID`, `emplyoeeNo`, `nameFirst`, `nameLast`, `Gender`, `birthday`, `UID`, `starDate`, `endDate`, `phone`, `cellPhone`, `status`, `position`, `construction`, `interior`, `MEP`, `contactNo`, `type`, `account`, `password`, `groupID`, `enable`, `skype`, `compMobile`, `personalMobile`, `ext`, `employmentDate`, `eMail`, `location`, `age`, `cDate`, `uDate`, `managerID`) VALUES
(1, '', 'ad', '', 1, '0000-00-00', '', '0000-00-00', '0000-00-00', '', '', '', ' engineer', '', '', '', '', 0, 'ad', '369a1204683aac5e396e327b26c05207', 14, 1, '', '', '', 0, '0000-00-00', '', 1, 29, '2013-06-21', '2013-06-24', 1),
(8, 'engin000001', 'maple', 'redwing', 1, '2008-07-31', 'a123470555', '0000-00-00', '0000-00-00', '', '', 'Regular', ' engineer', '', '', '', '', 0, 'redmaplewing', '84d0952c08a8db4d89232467a1f574f2', 13, 1, '', '0933123223', '0900111222', 26, '2013-06-28', '', 1, 29, '2013-06-21', '2013-06-25', 1),
(12, ' ', ' Xi', 'Hui', 0, '0000-00-00', ' ', '0000-00-00', '0000-00-00', '', '', 'Regular', ' ', '', '', '', '', 0, 'huixi', '48fad49671378e9f808ad19eaba7f734', 4, 1, '', ' ', ' ', 0, '0000-00-00', '', 1, 0, '2013-07-31', '2013-07-31', 1),
(13, ' ', ' Davin', 'So', 0, '0000-00-00', ' ', '0000-00-00', '0000-00-00', '', '', '', ' ', '', '', '', '', 0, 'sodavin', '4e0ef908aba3c01ef1e0b05a733bbbeb', 6, 1, '', ' ', ' ', 0, '0000-00-00', '', 1, 0, '2013-07-31', '2013-07-31', 1);

-- --------------------------------------------------------

--
-- 表的結構 `employeeAttendance`
--

CREATE TABLE IF NOT EXISTS `employeeAttendance` (
  `employeeAttendanceID` int(11) NOT NULL AUTO_INCREMENT,
  `employeeID` int(11) NOT NULL,
  `cDate` date NOT NULL,
  `uDate` date NOT NULL,
  `managerID` int(11) NOT NULL,
  `startDay` datetime NOT NULL COMMENT '休假起始日',
  `workingDay` int(11) NOT NULL COMMENT '本月總工時',
  `dayWorked` int(11) NOT NULL COMMENT '本月實際工時(扣除休假後)',
  `holiday` int(11) NOT NULL COMMENT '例假',
  `other` varchar(200) NOT NULL COMMENT '其它(summary用)',
  `off` int(11) NOT NULL COMMENT '月休',
  `annual` int(11) NOT NULL COMMENT '支薪',
  `type` int(11) NOT NULL COMMENT '1==>Attendance Summary,2==>LeaveLevel',
  `checked` int(11) NOT NULL,
  `approved` int(11) NOT NULL,
  `signCheck` int(11) NOT NULL,
  `hrDeptCheck` int(11) NOT NULL,
  `endDay` datetime NOT NULL COMMENT '休假結束日',
  `leaveType` int(11) NOT NULL COMMENT '1.事假，2.病假，3.公出，4.產假，5.婚假，6.喪假，7.休假，8.其它',
  PRIMARY KEY (`employeeAttendanceID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 轉存資料表中的資料 `employeeAttendance`
--

INSERT INTO `employeeAttendance` (`employeeAttendanceID`, `employeeID`, `cDate`, `uDate`, `managerID`, `startDay`, `workingDay`, `dayWorked`, `holiday`, `other`, `off`, `annual`, `type`, `checked`, `approved`, `signCheck`, `hrDeptCheck`, `endDay`, `leaveType`) VALUES
(1, 8, '2013-07-10', '2013-07-11', 1, '2013-07-10 17:46:00', 0, 0, 0, '0', 0, 0, 0, 1, 1, 1, 1, '2013-07-10 19:00:00', 2),
(2, 8, '2013-07-11', '2013-07-19', 1, '2013-07-11 15:00:00', 0, 0, 0, '0', 0, 0, 0, 0, 0, 0, 0, '2013-07-11 18:00:00', 4),
(3, 8, '2013-07-24', '0000-00-00', 1, '2013-07-24 14:57:00', 0, 0, 0, ' testing', 0, 0, 0, 0, 0, 0, 0, '2013-07-24 18:00:00', 8);

-- --------------------------------------------------------

--
-- 表的結構 `goodReturn`
--

CREATE TABLE IF NOT EXISTS `goodReturn` (
  `goodReturnID` int(11) NOT NULL AUTO_INCREMENT,
  `from` int(11) NOT NULL COMMENT 'warhouseID',
  `to` int(11) NOT NULL COMMENT 'supplierID',
  `cDate` date NOT NULL,
  `uDate` date NOT NULL,
  `managerID` int(11) NOT NULL,
  `returnDate` date NOT NULL,
  `reason` varchar(255) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `approved` int(11) NOT NULL,
  `inspected` varchar(100) NOT NULL,
  `securityCode` varchar(100) NOT NULL,
  `goodReturnNo` varchar(20) NOT NULL,
  PRIMARY KEY (`goodReturnID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 轉存資料表中的資料 `goodReturn`
--

INSERT INTO `goodReturn` (`goodReturnID`, `from`, `to`, `cDate`, `uDate`, `managerID`, `returnDate`, `reason`, `remark`, `approved`, `inspected`, `securityCode`, `goodReturnNo`) VALUES
(2, 2, 4, '2013-06-13', '0000-00-00', 1, '2013-06-29', '123', '456', 0, 'try', 'ZF684AGI371371147406283', 'GR000001');

-- --------------------------------------------------------

--
-- 表的結構 `groupPermission`
--

CREATE TABLE IF NOT EXISTS `groupPermission` (
  `groupPermissionID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `cDate` date NOT NULL,
  `uDate` date NOT NULL,
  `managerID` int(11) NOT NULL,
  `internalMemo` int(11) NOT NULL,
  `procedures` int(11) NOT NULL,
  `logSheetData` int(11) NOT NULL,
  `createBackFile` int(11) NOT NULL,
  `adjustData` int(11) NOT NULL,
  `taskManagement` int(11) NOT NULL,
  `organizationalChart` int(11) NOT NULL,
  `addressbook` int(11) NOT NULL,
  `companyCalendar` int(11) NOT NULL,
  `empGeneralInformation` int(11) NOT NULL,
  `empTask` int(11) NOT NULL,
  `empJobDescription` int(11) NOT NULL,
  `empAppraisal` int(11) NOT NULL,
  `recruitmentDatabase` int(11) NOT NULL,
  `shortlistApplicants` int(11) NOT NULL,
  `employeeList` int(11) NOT NULL,
  `attandanceRecord` int(11) NOT NULL,
  `purInformationRegistry` int(11) NOT NULL,
  `purPurchaseRequest` int(11) NOT NULL,
  `purPurchaseOrderLocal` int(11) NOT NULL,
  `purPurchaseOrderOverseas` int(11) NOT NULL,
  `purReportCenter` int(11) NOT NULL,
  `invInformationRegistry` int(11) NOT NULL,
  `invMaterialRequestReturn` int(11) NOT NULL,
  `invToolEqupmentManagement` int(11) NOT NULL,
  `invReportCenter` int(11) NOT NULL,
  `drawList` int(11) NOT NULL,
  `drawDistribution` int(11) NOT NULL,
  `projectList` int(11) NOT NULL,
  `enable` int(11) NOT NULL,
  PRIMARY KEY (`groupPermissionID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- 轉存資料表中的資料 `groupPermission`
--

INSERT INTO `groupPermission` (`groupPermissionID`, `name`, `cDate`, `uDate`, `managerID`, `internalMemo`, `procedures`, `logSheetData`, `createBackFile`, `adjustData`, `taskManagement`, `organizationalChart`, `addressbook`, `companyCalendar`, `empGeneralInformation`, `empTask`, `empJobDescription`, `empAppraisal`, `recruitmentDatabase`, `shortlistApplicants`, `employeeList`, `attandanceRecord`, `purInformationRegistry`, `purPurchaseRequest`, `purPurchaseOrderLocal`, `purPurchaseOrderOverseas`, `purReportCenter`, `invInformationRegistry`, `invMaterialRequestReturn`, `invToolEqupmentManagement`, `invReportCenter`, `drawList`, `drawDistribution`, `projectList`, `enable`) VALUES
(1, ' IT', '2013-06-24', '0000-00-00', 1, 1, 1, 2, 2, 1, 1, 1, 1, 1, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(2, ' Admin', '2013-06-24', '0000-00-00', 1, 2, 2, 0, 0, 0, 2, 1, 1, 2, 0, 2, 1, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1),
(3, ' HR', '2013-06-24', '2013-06-25', 1, 1, 1, 1, 0, 0, 1, 2, 2, 1, 2, 1, 2, 0, 2, 2, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(4, ' Manager - Admin/HR', '2013-06-24', '2013-06-24', 1, 1, 2, 1, 0, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 0, 2, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(5, ' Purchase', '2013-06-24', '2013-06-25', 1, 1, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 1, 0, 0, 0, 1, 1, 2, 1, 2, 1, 1, 1, 1, 1, 1, 0, 0, 1, 1),
(6, ' Manager - Purchase', '2013-06-24', '0000-00-00', 1, 1, 1, 0, 0, 2, 2, 1, 1, 1, 0, 2, 1, 0, 0, 0, 1, 1, 2, 1, 2, 1, 1, 1, 1, 1, 1, 0, 0, 1, 1),
(7, ' Inventory', '2013-06-24', '0000-00-00', 1, 1, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 1, 0, 0, 0, 1, 1, 1, 0, 1, 1, 0, 2, 2, 2, 1, 0, 0, 0, 1),
(8, ' Senior - Inventory', '2013-06-24', '0000-00-00', 1, 1, 1, 0, 0, 2, 2, 1, 1, 1, 0, 2, 1, 0, 0, 0, 1, 1, 1, 0, 1, 1, 0, 2, 2, 2, 1, 0, 0, 0, 1),
(9, ' Site Management', '2013-06-24', '2013-06-25', 1, 1, 1, 1, 0, 2, 2, 1, 1, 1, 0, 2, 1, 0, 2, 2, 1, 1, 1, 2, 1, 1, 0, 1, 2, 1, 1, 1, 1, 2, 1),
(10, 'Acctg/ Finance', '2013-06-24', '0000-00-00', 1, 1, 1, 1, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1, 1),
(11, ' Manager - Accounting', '2013-06-24', '0000-00-00', 1, 1, 1, 1, 0, 2, 2, 1, 1, 1, 1, 2, 1, 0, 0, 0, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1, 1),
(12, ' Design', '2013-06-24', '0000-00-00', 1, 1, 1, 0, 0, 0, 1, 1, 1, 1, 0, 1, 1, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 2, 1, 1, 1),
(13, ' Manager - Design', '2013-06-24', '0000-00-00', 1, 1, 1, 0, 0, 2, 2, 1, 1, 1, 0, 2, 1, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 2, 2, 1, 1),
(14, ' Management', '2013-06-24', '0000-00-00', 1, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 1, 2, 2, 2, 1, 2, 2, 2, 1);

-- --------------------------------------------------------

--
-- 表的結構 `handleDetail`
--

CREATE TABLE IF NOT EXISTS `handleDetail` (
  `handleDetailID` int(11) NOT NULL AUTO_INCREMENT,
  `itemID` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `cDate` date NOT NULL,
  `uDate` date NOT NULL,
  `managerID` int(11) NOT NULL,
  `receivedDate` date NOT NULL,
  `itemHandleID` int(11) NOT NULL,
  `securityCode` varchar(100) NOT NULL,
  `inventoryPost` int(11) NOT NULL,
  `note` varchar(100) NOT NULL,
  `amtSpent` varchar(50) NOT NULL,
  `purchaseOrderID` int(11) NOT NULL,
  `cabliResult` varchar(200) NOT NULL,
  `reason` varchar(200) NOT NULL,
  PRIMARY KEY (`handleDetailID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- 轉存資料表中的資料 `handleDetail`
--

INSERT INTO `handleDetail` (`handleDetailID`, `itemID`, `qty`, `cDate`, `uDate`, `managerID`, `receivedDate`, `itemHandleID`, `securityCode`, `inventoryPost`, `note`, `amtSpent`, `purchaseOrderID`, `cabliResult`, `reason`) VALUES
(1, 10, 1, '2013-06-14', '2013-06-14', 1, '2013-06-14', 1, 'R89RPXBNDS1371175073348', 0, ' 123', '123', 5, '', ''),
(2, 10, 1, '2013-06-14', '2013-06-14', 1, '0000-00-00', 2, 'NPJXXENK741371177994116', 0, ' asdf', ' 123', 0, ' 123124', ''),
(3, 15, 0, '2013-06-14', '2013-06-14', 1, '0000-00-00', 3, 'PYAET17ADG1371178438292', 0, '', '', 0, '', ''),
(4, 13, 1, '2013-06-14', '2013-06-14', 1, '2013-06-14', 2, 'NPJXXENK741371177994116', 1, ' 123', ' 12', 0, ' 1234', ''),
(5, 1, 1, '2013-06-14', '2013-06-14', 1, '0000-00-00', 2, 'NPJXXENK741371177994116', 0, ' 123', ' 12', 0, ' 1234', ''),
(6, 13, 1, '2013-06-14', '2013-06-14', 1, '2013-06-14', 1, 'R89RPXBNDS1371175073348', 0, ' 123', ' 12', 4, '', ' 1234'),
(7, 26, 1, '2013-06-14', '2013-06-14', 1, '2013-06-14', 2, 'NPJXXENK741371177994116', 1, ' 123', ' 12', 3, ' 1234', ' 12345'),
(8, 26, 0, '2013-06-14', '2013-06-14', 1, '0000-00-00', 3, 'PYAET17ADG1371178438292', 0, '', '', 0, '', ' 12321'),
(9, 26, 0, '2013-06-14', '2013-06-14', 1, '0000-00-00', 3, 'PYAET17ADG1371178438292', 0, '', '', 0, '', ' 6666'),
(10, 1, 66, '2013-06-14', '2013-06-14', 1, '0000-00-00', 1, 'R89RPXBNDS1371175073348', 0, ' 123', '1212', 5, '', ' 1234'),
(11, 26, 12345, '2013-06-14', '2013-06-14', 1, '2013-06-14', 1, 'R89RPXBNDS1371175073348', 1, ' 44', ' 123', 4, '', ' 1234');

-- --------------------------------------------------------

--
-- 表的結構 `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `itemID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '項目名稱',
  `code` varchar(50) NOT NULL COMMENT '項目編號',
  `type` int(11) NOT NULL COMMENT '項目類別(product/service/equiment/toole)',
  `unitCost` double NOT NULL COMMENT '單位成本',
  `disposalMethod` text NOT NULL COMMENT '處理方式',
  `warrantyPeriod` varchar(500) NOT NULL COMMENT '保養周期',
  `calibrationPeriod` varchar(500) NOT NULL COMMENT '校準周期',
  `attachment` varchar(200) NOT NULL COMMENT '項目資訊(圖片或影片連結)',
  `usefulLife` varchar(200) NOT NULL COMMENT '有效期限',
  `location` int(11) NOT NULL COMMENT '項目所在地(local/overseas)',
  `description` text NOT NULL COMMENT '項目描述(規格)',
  `cDate` datetime NOT NULL COMMENT '建立日期',
  `uDate` datetime NOT NULL COMMENT '修改日期',
  `managerID` int(11) NOT NULL COMMENT '建立者id',
  `cotegory` varchar(20) NOT NULL COMMENT '項目類別(水泥、木板等)',
  `supplier` int(100) NOT NULL COMMENT '供應商編號',
  `minimumLevel` int(11) NOT NULL COMMENT '基本庫存量',
  `defaultQty` int(11) NOT NULL COMMENT '基本訂量',
  `UoM` varchar(20) NOT NULL,
  `approved` int(11) NOT NULL,
  `disposalDate` date NOT NULL,
  `disposedBy` int(11) NOT NULL,
  `lost` int(11) NOT NULL,
  `warehouseID` int(11) NOT NULL,
  `usage` varchar(100) NOT NULL,
  `purchasedDate` date NOT NULL,
  PRIMARY KEY (`itemID`),
  KEY `code` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- 轉存資料表中的資料 `item`
--

INSERT INTO `item` (`itemID`, `name`, `code`, `type`, `unitCost`, `disposalMethod`, `warrantyPeriod`, `calibrationPeriod`, `attachment`, `usefulLife`, `location`, `description`, `cDate`, `uDate`, `managerID`, `cotegory`, `supplier`, `minimumLevel`, `defaultQty`, `UoM`, `approved`, `disposalDate`, `disposedBy`, `lost`, `warehouseID`, `usage`, `purchasedDate`) VALUES
(1, 'jquery web', 'web000001', 1, 1.32, '', '', '', 'ijkl', '', 1, 'abcd1234', '2013-04-29 06:29:29', '2013-05-20 05:35:10', 1, 'web', 2, 13, 19, 'page', 0, '0000-00-00', 0, 0, 0, '', '0000-00-00'),
(10, 'web1234', 'web000005', 1, 1.7, '', '', '', '1', '', 1, '1', '2013-04-30 06:04:25', '2013-05-27 11:13:51', 1, 'web', 2, 10, 24, 'page', 0, '0000-00-00', 0, 0, 0, '', '0000-00-00'),
(13, 'web', 'web000004', 1, 4.62, '', '', '', 'def', '', 1, 'abc', '2013-04-30 06:33:33', '2013-06-12 11:30:41', 4, 'web', 4, 20, 25, 'page', 0, '0000-00-00', 0, 0, 0, '', '0000-00-00'),
(14, 'more UI page', 'web000003', 1, 0.66, '', '', '', '1212', '', 0, '5656', '2013-05-01 11:09:58', '2013-05-27 11:13:39', 1, 'web', 4, 10, 16, 'page', 0, '0000-00-00', 0, 0, 0, '', '0000-00-00'),
(15, 'web build', 'webb000001', 2, 6.4, '', '', '', '', '', 1, 'web page build', '2013-05-02 09:23:05', '2013-05-21 03:00:03', 1, 'web', 2, 0, 0, 'page', 2, '0000-00-00', 0, 0, 0, '', '0000-00-00'),
(26, 'engineer', 't000001', 3, 22, 'no use', 'forever', 'none', 'd802aac635c3fee04de67e6bd042c000.jpg', 'forever', 0, '56789', '2013-06-12 08:29:34', '2013-06-12 09:21:09', 1, '', 0, 0, 0, '', 1, '2013-06-29', 1, 0, 1, 'forever', '2013-06-29'),
(27, 'pageMaker', 't000002', 3, 22, 'no use', 'forever', 'none', '', 'forever', 0, '1234', '2013-06-12 09:16:37', '2013-06-12 09:18:43', 1, '', 0, 0, 0, '', 1, '2013-06-29', 1, 0, 2, 'forever', '2013-06-29'),
(28, '', '', 0, 0, '', '', '', '', '', 0, '', '2013-06-26 05:24:48', '0000-00-00 00:00:00', 1, '', 0, 0, 0, '', 0, '0000-00-00', 0, 0, 0, '', '0000-00-00'),
(29, '', '', 0, 0, '', '', '', '', '', 0, '', '2013-06-26 05:25:03', '0000-00-00 00:00:00', 1, '', 0, 0, 0, '', 0, '0000-00-00', 0, 0, 0, '', '0000-00-00'),
(30, '', '', 0, 0, '', '', '', '', '', 0, '', '2013-06-26 05:26:02', '0000-00-00 00:00:00', 1, '', 0, 0, 0, '', 0, '0000-00-00', 0, 0, 0, '', '0000-00-00');

-- --------------------------------------------------------

--
-- 表的結構 `itemHandle`
--

CREATE TABLE IF NOT EXISTS `itemHandle` (
  `itemHandleID` int(11) NOT NULL AUTO_INCREMENT,
  `projectID` int(11) NOT NULL,
  `purpose` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `cDate` date NOT NULL,
  `uDate` date NOT NULL,
  `managerID` int(11) NOT NULL,
  `eDate` date NOT NULL,
  `submitDate` date NOT NULL,
  `remark` varchar(200) NOT NULL,
  `checked` int(11) NOT NULL,
  `approved` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1:repair,2:calibration,3:disposal',
  `itemHandleNo` varchar(20) NOT NULL,
  `securityCode` varchar(100) NOT NULL,
  PRIMARY KEY (`itemHandleID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- 轉存資料表中的資料 `itemHandle`
--

INSERT INTO `itemHandle` (`itemHandleID`, `projectID`, `purpose`, `status`, `cDate`, `uDate`, `managerID`, `eDate`, `submitDate`, `remark`, `checked`, `approved`, `type`, `itemHandleNo`, `securityCode`) VALUES
(1, 5, '123', 0, '2013-06-14', '2013-06-14', 1, '2013-06-29', '2013-06-14', '', 1, 1, 1, 'RR000001', 'R89RPXBNDS1371175073348'),
(2, 5, ' 123', 0, '2013-06-14', '0000-00-00', 1, '2013-06-28', '0000-00-00', '', 0, 0, 2, 'CR000001', 'NPJXXENK741371177994116'),
(3, 5, ' abcde', 0, '2013-06-14', '0000-00-00', 1, '2013-06-25', '0000-00-00', '', 0, 0, 3, ' DR000001', 'PYAET17ADG1371178438292');

-- --------------------------------------------------------

--
-- 表的結構 `itemInventory`
--

CREATE TABLE IF NOT EXISTS `itemInventory` (
  `itemInventoryID` int(11) NOT NULL AUTO_INCREMENT,
  `warehouseID` int(11) NOT NULL,
  `itemID` int(11) NOT NULL,
  `onHand` int(11) NOT NULL,
  `cDate` date NOT NULL,
  `uDate` date NOT NULL,
  `managerID` int(11) NOT NULL,
  `location` varchar(500) NOT NULL,
  PRIMARY KEY (`itemInventoryID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- 轉存資料表中的資料 `itemInventory`
--

INSERT INTO `itemInventory` (`itemInventoryID`, `warehouseID`, `itemID`, `onHand`, `cDate`, `uDate`, `managerID`, `location`) VALUES
(1, 2, 13, 14, '2013-06-11', '2013-06-17', 4, ''),
(3, 0, 14, 70, '2013-06-11', '0000-00-00', 4, ''),
(4, 0, 10, 10, '2013-06-12', '0000-00-00', 4, ''),
(5, 2, 1, 5, '2013-06-12', '0000-00-00', 4, '');

-- --------------------------------------------------------

--
-- 表的結構 `itemUsage`
--

CREATE TABLE IF NOT EXISTS `itemUsage` (
  `itemUsageID` int(11) NOT NULL AUTO_INCREMENT,
  `itemID` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `cDate` date NOT NULL,
  `uDate` date NOT NULL,
  `managerID` int(11) NOT NULL,
  `receivedDate` date NOT NULL,
  `purchaseRequestID` int(11) NOT NULL,
  `purchaseOrderID` int(11) NOT NULL,
  `securityCode` varchar(30) NOT NULL,
  `processes1` date NOT NULL,
  `processes2` date NOT NULL,
  `processes3` date NOT NULL,
  `processes4` date NOT NULL,
  `processes5` date NOT NULL,
  `processes6` date NOT NULL,
  `processes7` date NOT NULL,
  `processes8` date NOT NULL,
  `processes9` date NOT NULL,
  PRIMARY KEY (`itemUsageID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

--
-- 轉存資料表中的資料 `itemUsage`
--

INSERT INTO `itemUsage` (`itemUsageID`, `itemID`, `qty`, `cDate`, `uDate`, `managerID`, `receivedDate`, `purchaseRequestID`, `purchaseOrderID`, `securityCode`, `processes1`, `processes2`, `processes3`, `processes4`, `processes5`, `processes6`, `processes7`, `processes8`, `processes9`) VALUES
(29, 10, 3, '2013-05-22', '2013-05-28', 1, '0000-00-00', 2, 0, 'IKZLEG578W', '2013-05-28', '2013-05-28', '2013-05-28', '2013-05-27', '2013-05-28', '2013-05-28', '2013-05-28', '2013-05-28', '2013-05-28'),
(30, 14, 5, '2013-05-22', '2013-05-28', 1, '0000-00-00', 2, 0, 'IKZLEG578W', '2013-05-27', '2013-05-27', '2013-05-27', '2013-05-27', '2013-05-27', '2013-05-27', '2013-05-27', '2013-05-27', '2013-05-27'),
(31, 13, 2, '2013-05-22', '2013-05-30', 1, '2013-05-28', 3, 0, 'G9OTWURHCA', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '2013-05-27', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(32, 10, 3, '2013-05-22', '2013-05-30', 1, '2013-05-28', 3, 0, 'G9OTWURHCA', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(33, 1, 6, '2013-05-22', '2013-05-30', 1, '2013-05-28', 3, 0, 'G9OTWURHCA', '0000-00-00', '2013-05-27', '0000-00-00', '0000-00-00', '2013-05-27', '0000-00-00', '0000-00-00', '2013-05-27', '0000-00-00'),
(34, 10, 6, '2013-05-22', '2013-05-30', 1, '0000-00-00', 4, 0, 'A3A75NX1SY', '0000-00-00', '0000-00-00', '0000-00-00', '2013-05-16', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(35, 1, 20, '2013-05-22', '2013-05-30', 1, '0000-00-00', 4, 0, 'A3A75NX1SY', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(36, 14, 70, '2013-05-22', '2013-05-30', 1, '0000-00-00', 4, 0, 'A3A75NX1SY', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(38, 1, 1, '2013-05-22', '2013-05-22', 1, '0000-00-00', 1, 0, 'ALFFRBC3YE', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(39, 14, 5, '2013-05-22', '2013-05-22', 1, '0000-00-00', 1, 0, 'ALFFRBC3YE', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(40, 10, 3, '2013-05-27', '2013-05-27', 1, '0000-00-00', 40, 0, 'FGF1X6XG9F', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(41, 10, 4, '2013-05-28', '2013-05-28', 1, '0000-00-00', 41, 0, '95IDFKOPU4', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(44, 13, 88, '2013-05-28', '2013-05-28', 1, '0000-00-00', 44, 0, '6P3FKOP5GZ1369728079890', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(45, 5, 9, '2013-05-28', '2013-05-28', 1, '0000-00-00', 45, 0, 'XVYV2GLOCL1369737095408', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- 表的結構 `materialRequest`
--

CREATE TABLE IF NOT EXISTS `materialRequest` (
  `materialRequestID` int(11) NOT NULL AUTO_INCREMENT,
  `materialRequestNo` varchar(20) NOT NULL COMMENT '請購單編號',
  `status` int(11) NOT NULL COMMENT '處理階段',
  `cDate` datetime NOT NULL COMMENT '建立日期',
  `uDate` datetime NOT NULL COMMENT '更新日期',
  `eDate` date NOT NULL COMMENT '預計到貨日',
  `submitDate` date NOT NULL COMMENT '提交日期',
  `projectID` int(11) NOT NULL COMMENT '專案id',
  `planID` int(11) NOT NULL COMMENT '圖紙id',
  `remark` varchar(100) NOT NULL COMMENT '備註',
  `managerID` int(11) NOT NULL COMMENT '建立者',
  `securityCode` varchar(100) NOT NULL,
  `checked` int(11) NOT NULL,
  `approve` int(11) NOT NULL,
  `receivedDate` date NOT NULL,
  PRIMARY KEY (`materialRequestID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 轉存資料表中的資料 `materialRequest`
--

INSERT INTO `materialRequest` (`materialRequestID`, `materialRequestNo`, `status`, `cDate`, `uDate`, `eDate`, `submitDate`, `projectID`, `planID`, `remark`, `managerID`, `securityCode`, `checked`, `approve`, `receivedDate`) VALUES
(3, 'MR000002', 0, '2013-06-13 02:52:10', '2013-06-17 03:56:02', '2013-06-29', '2013-06-17', 5, 5, '', 1, 'B6PNMEM2VM1371106280912', 1, 0, '0000-00-00');

-- --------------------------------------------------------

--
-- 表的結構 `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `menuID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `parentID` int(11) NOT NULL,
  `link` varchar(100) NOT NULL,
  `enable` int(11) NOT NULL,
  `ord` int(11) NOT NULL,
  `cDate` datetime NOT NULL,
  `uDate` datetime NOT NULL,
  PRIMARY KEY (`menuID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- 轉存資料表中的資料 `menu`
--

INSERT INTO `menu` (`menuID`, `name`, `parentID`, `link`, `enable`, `ord`, `cDate`, `uDate`) VALUES
(1, 'menuType Setting', 1, 'menuType', 1, 1, '2013-04-25 05:06:07', '2013-04-25 05:12:37'),
(2, 'menuSetting', 1, 'menuSetting', 1, 2, '2013-04-25 05:12:26', '0000-00-00 00:00:00'),
(3, 'InforMation Registry', 44, 'pruInfoRegistry', 1, 1, '2013-04-25 05:33:49', '2013-04-26 04:32:20'),
(4, 'Purchase Request', 44, 'purchaseRequest', 1, 2, '2013-04-25 05:34:20', '2013-05-02 03:53:16'),
(5, 'Purchase Order', 44, 'purchaseOrder', 1, 3, '2013-04-25 05:34:31', '2013-05-03 09:38:38'),
(6, 'Report Center', 44, 'purchaseReport', 1, 4, '2013-04-25 05:34:42', '2013-07-24 05:30:52'),
(7, 'IT Data C ontrol', 46, '', 1, 2, '2013-04-25 05:58:51', '2013-07-01 03:34:51'),
(8, 'Task Management', 46, 'taskMan', 1, 3, '2013-04-25 05:59:01', '2013-07-02 10:02:18'),
(9, 'Recruitment Process', 34, 'recruProcess', 1, 2, '2013-04-25 05:59:17', '2013-06-19 10:39:53'),
(10, 'Employee List', 34, 'employee', 1, 3, '2013-04-25 05:59:30', '2013-06-19 10:40:18'),
(11, 'Attendance Record', 34, 'attRecord', 1, 4, '2013-04-25 05:59:40', '2013-06-19 10:40:04'),
(12, 'Information Registry', 45, 'invInfoRegistry', 1, 1, '2013-04-25 06:34:20', '2013-05-07 09:30:37'),
(13, 'Material Request & Return', 45, 'materialRR', 1, 2, '2013-04-25 06:34:35', '2013-05-07 09:30:56'),
(14, 'Tools & Equipment Management', 45, 'teManager', 1, 3, '2013-04-25 06:34:51', '2013-05-09 04:04:24'),
(15, 'Report Center', 45, 'inventoryReport', 1, 4, '2013-04-25 06:34:59', '2013-07-24 05:55:42'),
(16, 'Project List', 19, 'proj', 1, 1, '2013-05-13 11:03:38', '0000-00-00 00:00:00'),
(17, 'Drawing Management', 47, 'drawManagement', 1, 1, '2013-05-15 04:33:09', '0000-00-00 00:00:00'),
(18, 'Human Resource Management', 34, 'humanMain', 1, 1, '2013-06-19 10:39:43', '0000-00-00 00:00:00'),
(19, 'Group Permission Setting', 1, 'setGroupPermission', 1, 3, '2013-06-24 10:35:52', '2013-06-24 10:36:51'),
(20, 'Admin Management', 46, 'adminManagement', 1, 1, '2013-07-01 03:34:39', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- 表的結構 `menuType`
--

CREATE TABLE IF NOT EXISTS `menuType` (
  `menuTypeID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `lang` varchar(50) NOT NULL,
  `enable` int(11) NOT NULL,
  `cDate` date NOT NULL,
  `uDate` date NOT NULL,
  `ord` int(11) NOT NULL,
  `linkID` int(11) NOT NULL COMMENT '非英文表單的連結',
  PRIMARY KEY (`menuTypeID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=52 ;

--
-- 轉存資料表中的資料 `menuType`
--

INSERT INTO `menuType` (`menuTypeID`, `name`, `lang`, `enable`, `cDate`, `uDate`, `ord`, `linkID`) VALUES
(1, 'System Config', 'en_US', 0, '0000-00-00', '2013-06-25', 1, 0),
(15, '系統控制', 'zh_TW', 1, '2013-04-12', '2013-04-16', 1, 1),
(19, 'Project List', 'en_US', 1, '2013-04-22', '2013-04-25', 7, 0),
(20, '專案管理', 'zh_TW', 1, '2013-04-22', '2013-04-24', 0, 19),
(34, 'Human Resource Management', 'en_US', 1, '2013-04-22', '2013-04-25', 3, 0),
(42, '人資系統', 'zh_TW', 1, '2013-04-24', '0000-00-00', 0, 34),
(44, 'Purchase Management', 'en_US', 1, '2013-04-25', '0000-00-00', 4, 0),
(45, 'Inventory Management', 'en_US', 1, '2013-04-25', '0000-00-00', 5, 0),
(46, 'Admin Management', 'en_US', 1, '2013-04-25', '0000-00-00', 2, 0),
(47, 'Drawing Management', 'en_US', 1, '2013-04-25', '0000-00-00', 6, 0),
(48, '網站控制', 'zh_TW', 1, '2013-04-25', '0000-00-00', 0, 46),
(49, '採購系統', 'zh_TW', 1, '2013-04-25', '0000-00-00', 0, 44),
(50, '倉儲管理', 'zh_TW', 1, '2013-04-25', '0000-00-00', 0, 45),
(51, '圖紙管理', 'zh_TW', 1, '2013-04-25', '0000-00-00', 0, 47);

-- --------------------------------------------------------

--
-- 表的結構 `modifyLog`
--

CREATE TABLE IF NOT EXISTS `modifyLog` (
  `modLogID` int(11) NOT NULL AUTO_INCREMENT,
  `tableName` varchar(100) NOT NULL,
  `ManagerID` varchar(100) NOT NULL,
  `uDate` datetime NOT NULL,
  `modify` varchar(10) NOT NULL,
  `ipAddress` varchar(100) NOT NULL,
  PRIMARY KEY (`modLogID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1240 ;

--
-- 轉存資料表中的資料 `modifyLog`
--

INSERT INTO `modifyLog` (`modLogID`, `tableName`, `ManagerID`, `uDate`, `modify`, `ipAddress`) VALUES
(1, 'menuType', 'ad', '2013-04-11 12:00:43', 'edit', '127.0.0.1'),
(2, 'menuType', 'ad', '2013-04-11 12:01:07', 'add', '127.0.0.1'),
(3, 'menuType', 'ad', '2013-04-25 02:38:56', 'del', '127.0.0.1'),
(4, 'menuType', 'ad', '2013-04-25 02:38:56', 'del', '127.0.0.1'),
(5, 'menuType', 'ad', '2013-04-25 02:40:30', 'add', '127.0.0.1'),
(6, 'menuType', 'ad', '2013-04-25 02:40:43', 'add', '127.0.0.1'),
(7, 'menuType', 'ad', '2013-04-25 02:41:06', 'del', '127.0.0.1'),
(8, 'menuType', 'ad', '2013-04-25 02:41:06', 'del', '127.0.0.1'),
(9, 'menuType', 'ad', '2013-04-25 02:42:29', 'edit', '127.0.0.1'),
(10, 'menuType', 'ad', '2013-04-25 02:42:59', 'add', '127.0.0.1'),
(11, 'menuType', 'ad', '2013-04-25 02:43:10', 'edit', '127.0.0.1'),
(12, 'menuType', 'ad', '2013-04-25 02:43:19', 'add', '127.0.0.1'),
(13, 'menuType', 'ad', '2013-04-25 02:43:30', 'del', '127.0.0.1'),
(14, 'menuType', 'ad', '2013-04-25 02:43:30', 'del', '127.0.0.1'),
(15, 'menuType', 'ad', '2013-04-25 02:43:59', 'add', '127.0.0.1'),
(16, 'menuType', 'ad', '2013-04-25 02:44:08', 'add', '127.0.0.1'),
(17, 'menuType', 'ad', '2013-04-25 02:44:20', 'del', '127.0.0.1'),
(18, 'menuType', 'ad', '2013-04-25 02:44:20', 'del', '127.0.0.1'),
(19, 'menu', 'ad', '2013-04-25 05:06:07', 'add', '127.0.0.1'),
(20, 'menu', 'ad', '2013-04-25 05:10:55', 'edit', '127.0.0.1'),
(21, 'menu', 'ad', '2013-04-25 05:12:26', 'add', '127.0.0.1'),
(22, 'menu', 'ad', '2013-04-25 05:12:37', 'edit', '127.0.0.1'),
(23, 'menu', 'ad', '2013-04-25 05:33:49', 'add', '127.0.0.1'),
(24, 'menu', 'ad', '2013-04-25 05:33:58', 'edit', '127.0.0.1'),
(25, 'menu', 'ad', '2013-04-25 05:34:20', 'add', '127.0.0.1'),
(26, 'menu', 'ad', '2013-04-25 05:34:31', 'add', '127.0.0.1'),
(27, 'menu', 'ad', '2013-04-25 05:34:42', 'add', '127.0.0.1'),
(28, 'menu', 'ad', '2013-04-25 05:34:52', 'edit', '127.0.0.1'),
(29, 'menu', 'ad', '2013-04-25 05:35:01', 'edit', '127.0.0.1'),
(30, 'menu', 'ad', '2013-04-25 05:35:27', 'edit', '127.0.0.1'),
(31, 'menu', 'ad', '2013-04-25 05:36:25', 'edit', '127.0.0.1'),
(32, 'menu', 'ad', '2013-04-25 05:36:33', 'edit', '127.0.0.1'),
(33, 'menu', 'ad', '2013-04-25 05:36:39', 'edit', '127.0.0.1'),
(34, 'menu', 'ad', '2013-04-25 05:58:51', 'add', '127.0.0.1'),
(35, 'menu', 'ad', '2013-04-25 05:59:01', 'add', '127.0.0.1'),
(36, 'menu', 'ad', '2013-04-25 05:59:17', 'add', '127.0.0.1'),
(37, 'menu', 'ad', '2013-04-25 05:59:30', 'add', '127.0.0.1'),
(38, 'menu', 'ad', '2013-04-25 05:59:40', 'add', '127.0.0.1'),
(39, 'menu', 'ad', '2013-04-25 06:34:20', 'add', '127.0.0.1'),
(40, 'menu', 'ad', '2013-04-25 06:34:35', 'add', '127.0.0.1'),
(41, 'menu', 'ad', '2013-04-25 06:34:51', 'add', '127.0.0.1'),
(42, 'menu', 'ad', '2013-04-25 06:34:59', 'add', '127.0.0.1'),
(43, 'menu', 'ad', '2013-04-25 06:35:31', 'edit', '127.0.0.1'),
(44, 'menu', 'ad', '2013-04-25 06:35:39', 'edit', '127.0.0.1'),
(45, 'menu', 'ad', '2013-04-25 06:35:49', 'edit', '127.0.0.1'),
(46, 'menu', 'ad', '2013-04-26 09:54:51', 'edit', '127.0.0.1'),
(47, 'nameLang', 'ad', '2013-04-26 11:54:43', 'add', '127.0.0.1'),
(48, 'nameLang', 'ad', '2013-04-26 11:57:23', 'add', '127.0.0.1'),
(49, 'menu', 'ad', '2013-04-26 04:32:20', 'edit', '127.0.0.1'),
(50, 'item', 'ad', '2013-04-29 06:29:29', 'add', '127.0.0.1'),
(51, 'item', 'ad', '2013-04-29 06:34:45', 'add', '127.0.0.1'),
(52, 'item', 'ad', '2013-04-29 06:35:49', 'add', '127.0.0.1'),
(53, 'item', 'ad', '2013-04-29 06:36:27', 'add', '127.0.0.1'),
(54, 'item', 'ad', '2013-04-30 12:35:50', 'del', '127.0.0.1'),
(55, 'item', 'ad', '2013-04-30 12:35:54', 'del', '127.0.0.1'),
(56, 'item', 'ad', '2013-04-30 12:35:57', 'del', '127.0.0.1'),
(57, 'item', 'ad', '2013-04-30 01:59:41', 'edit', '127.0.0.1'),
(58, 'item', 'ad', '2013-04-30 01:59:54', 'edit', '127.0.0.1'),
(59, 'item', 'ad', '2013-04-30 02:00:37', 'edit', '127.0.0.1'),
(60, 'item', 'ad', '2013-04-30 02:00:44', 'edit', '127.0.0.1'),
(61, 'item', 'ad', '2013-04-30 02:02:27', 'edit', '127.0.0.1'),
(62, 'item', 'ad', '2013-04-30 02:12:21', 'edit', '127.0.0.1'),
(63, 'item', 'ad', '2013-04-30 02:12:31', 'edit', '127.0.0.1'),
(64, 'item', 'ad', '2013-04-30 02:13:10', 'edit', '127.0.0.1'),
(65, 'item', 'ad', '2013-04-30 03:33:56', 'edit', '127.0.0.1'),
(66, 'item', 'ad', '2013-04-30 03:34:29', 'add', '127.0.0.1'),
(67, 'item', 'ad', '2013-04-30 03:41:30', 'edit', '127.0.0.1'),
(68, 'item', 'ad', '2013-04-30 03:41:34', 'edit', '127.0.0.1'),
(69, 'item', 'ad', '2013-04-30 03:41:38', 'edit', '127.0.0.1'),
(70, 'item', 'ad', '2013-04-30 03:41:43', 'edit', '127.0.0.1'),
(71, 'item', 'ad', '2013-04-30 03:43:01', 'edit', '127.0.0.1'),
(72, 'item', 'ad', '2013-04-30 03:55:41', 'edit', '127.0.0.1'),
(73, 'item', 'ad', '2013-04-30 03:55:48', 'edit', '127.0.0.1'),
(74, 'item', 'ad', '2013-04-30 04:00:45', 'edit', '127.0.0.1'),
(75, 'item', 'ad', '2013-04-30 04:03:26', 'edit', '127.0.0.1'),
(76, 'item', 'ad', '2013-04-30 04:04:24', 'edit', '127.0.0.1'),
(77, 'item', 'ad', '2013-04-30 04:04:28', 'edit', '127.0.0.1'),
(78, 'item', 'ad', '2013-04-30 04:04:50', 'edit', '127.0.0.1'),
(79, 'item', 'ad', '2013-04-30 04:05:27', 'edit', '127.0.0.1'),
(80, 'item', 'ad', '2013-04-30 04:08:12', 'edit', '127.0.0.1'),
(81, 'item', 'ad', '2013-04-30 04:08:39', 'edit', '127.0.0.1'),
(82, 'item', 'ad', '2013-04-30 04:10:56', 'edit', '127.0.0.1'),
(83, 'item', 'ad', '2013-04-30 04:12:13', 'edit', '127.0.0.1'),
(84, 'item', 'ad', '2013-04-30 04:14:11', 'edit', '127.0.0.1'),
(85, 'item', 'ad', '2013-04-30 04:17:45', 'edit', '127.0.0.1'),
(86, 'item', 'ad', '2013-04-30 04:18:40', 'edit', '127.0.0.1'),
(87, 'item', 'ad', '2013-04-30 04:21:29', 'add', '127.0.0.1'),
(88, 'item', 'ad', '2013-04-30 04:21:51', 'del', '127.0.0.1'),
(89, 'item', 'ad', '2013-04-30 04:22:16', 'add', '127.0.0.1'),
(90, 'item', 'ad', '2013-04-30 04:30:56', 'add', '127.0.0.1'),
(91, 'item', 'ad', '2013-04-30 04:31:15', 'del', '127.0.0.1'),
(92, 'item', 'ad', '2013-04-30 04:52:58', 'del', '127.0.0.1'),
(93, 'item', 'ad', '2013-04-30 05:05:26', 'edit', '127.0.0.1'),
(94, 'item', 'ad', '2013-04-30 05:05:31', 'edit', '127.0.0.1'),
(95, 'item', 'ad', '2013-04-30 05:10:56', 'edit', '127.0.0.1'),
(96, 'item', 'ad', '2013-04-30 05:11:23', 'edit', '127.0.0.1'),
(97, 'menuType', 'ad', '2013-04-30 05:33:39', 'edit', '127.0.0.1'),
(98, 'item', 'ad', '2013-04-30 06:03:30', 'add', '127.0.0.1'),
(99, 'item', 'ad', '2013-04-30 06:04:25', 'add', '127.0.0.1'),
(100, 'item', 'ad', '2013-04-30 06:05:38', 'add', '127.0.0.1'),
(101, 'item', 'ad', '2013-04-30 06:08:23', 'del', '127.0.0.1'),
(102, 'item', 'ad', '2013-04-30 06:08:29', 'del', '127.0.0.1'),
(103, 'item', 'ad', '2013-04-30 06:19:09', 'add', '127.0.0.1'),
(104, 'item', 'ad', '2013-04-30 06:22:27', 'del', '127.0.0.1'),
(105, 'item', 'ad', '2013-04-30 06:30:56', '', '127.0.0.1'),
(106, 'item', 'ad', '2013-04-30 06:31:14', '', '127.0.0.1'),
(107, 'item', 'ad', '2013-04-30 06:33:33', 'add', '127.0.0.1'),
(108, 'item', 'ad', '2013-05-01 10:01:27', 'edit', '127.0.0.1'),
(109, 'item', 'ad', '2013-05-01 10:01:44', 'edit', '127.0.0.1'),
(110, 'item', 'ad', '2013-05-01 10:01:54', 'edit', '127.0.0.1'),
(111, 'item', 'ad', '2013-05-01 10:02:04', 'edit', '127.0.0.1'),
(112, 'item', 'ad', '2013-05-01 11:09:58', 'add', '127.0.0.1'),
(113, 'item', 'ad', '2013-05-01 05:12:16', 'add', '127.0.0.1'),
(114, 'item', 'ad', '2013-05-01 05:12:45', 'add', '127.0.0.1'),
(115, 'item', 'ad', '2013-05-01 05:17:27', 'add', '127.0.0.1'),
(116, 'item', 'ad', '2013-05-01 05:19:43', 'add', '127.0.0.1'),
(117, 'supplier', 'ad', '2013-05-01 05:24:48', 'add', '127.0.0.1'),
(118, 'supplier', 'ad', '2013-05-01 05:28:29', 'add', '127.0.0.1'),
(119, 'supplier', 'ad', '2013-05-02 09:22:18', 'add', '127.0.0.1'),
(120, 'item', 'ad', '2013-05-02 09:23:05', 'add', '127.0.0.1'),
(121, 'item', 'ad', '2013-05-02 09:23:20', 'edit', '127.0.0.1'),
(122, 'supplier', 'ad', '2013-05-02 09:46:47', 'edit', '127.0.0.1'),
(123, 'supplier', 'ad', '2013-05-02 09:51:09', 'edit', '127.0.0.1'),
(124, 'supplier', 'ad', '2013-05-02 09:54:07', 'edit', '127.0.0.1'),
(125, 'supplier', 'ad', '2013-05-02 11:47:35', 'edit', '127.0.0.1'),
(126, 'supplier', 'ad', '2013-05-02 11:47:44', 'edit', '127.0.0.1'),
(127, 'supplier', 'ad', '2013-05-02 11:54:44', 'edit', '127.0.0.1'),
(128, 'supplier', 'ad', '2013-05-02 11:54:51', 'edit', '127.0.0.1'),
(129, 'menu', 'ad', '2013-05-02 03:49:01', 'edit', '127.0.0.1'),
(130, 'menu', 'ad', '2013-05-02 03:53:16', 'edit', '127.0.0.1'),
(131, 'menu', 'ad', '2013-05-03 09:38:38', 'edit', '127.0.0.1'),
(132, 'purchaseRequest', 'ad', '2013-05-03 02:18:09', '', '127.0.0.1'),
(133, 'purchaseRequest', 'ad', '2013-05-03 02:20:29', '', '127.0.0.1'),
(134, 'purchaseRequest', 'ad', '2013-05-03 02:21:12', '', '127.0.0.1'),
(135, 'purchaseRequest', 'ad', '2013-05-03 02:23:21', '', '127.0.0.1'),
(136, 'purchaseRequest', 'ad', '2013-05-03 02:23:35', '', '127.0.0.1'),
(137, 'purchaseRequest', 'ad', '2013-05-03 02:24:31', 'add', '127.0.0.1'),
(138, 'purchaseRequest', 'ad', '2013-05-03 02:29:33', 'add', '127.0.0.1'),
(139, 'purchaseRequest', 'ad', '2013-05-03 02:41:32', 'add', '127.0.0.1'),
(140, 'purchaseRequest', 'ad', '2013-05-03 02:42:18', 'add', '127.0.0.1'),
(141, 'purchaseRequest', 'ad', '2013-05-03 02:43:01', 'add', '127.0.0.1'),
(142, 'purchaseRequest', 'ad', '2013-05-03 02:59:18', 'add', '127.0.0.1'),
(143, 'purchaseRequest', 'ad', '2013-05-03 04:26:02', 'edit', '127.0.0.1'),
(144, 'purchaseRequest', 'ad', '2013-05-03 04:27:02', 'edit', '127.0.0.1'),
(145, 'purchaseRequest', 'ad', '2013-05-03 04:30:14', 'edit', '127.0.0.1'),
(146, 'purchaseRequest', 'ad', '2013-05-03 04:32:50', 'add', '127.0.0.1'),
(147, 'purchaseRequest', 'ad', '2013-05-03 04:33:48', 'edit', '127.0.0.1'),
(148, 'purchaseRequest', 'ad', '2013-05-03 04:40:05', 'edit', '127.0.0.1'),
(149, 'purchaseRequest', 'ad', '2013-05-03 04:41:19', 'edit', '127.0.0.1'),
(150, 'purchaseRequest', 'ad', '2013-05-03 04:41:34', 'edit', '127.0.0.1'),
(151, 'purchaseRequest', 'ad', '2013-05-03 04:42:43', 'edit', '127.0.0.1'),
(152, 'purchaseRequest', 'ad', '2013-05-03 04:43:12', 'edit', '127.0.0.1'),
(153, 'purchaseRequest', 'ad', '2013-05-03 04:43:25', 'edit', '127.0.0.1'),
(154, 'purchaseRequest', 'ad', '2013-05-03 04:43:52', 'edit', '127.0.0.1'),
(155, 'purchaseRequest', 'ad', '2013-05-03 04:44:37', 'edit', '127.0.0.1'),
(156, 'purchaseRequest', 'ad', '2013-05-03 04:45:06', 'edit', '127.0.0.1'),
(157, 'purchaseRequest', 'ad', '2013-05-03 04:45:20', 'edit', '127.0.0.1'),
(158, 'purchaseRequest', 'ad', '2013-05-03 04:47:45', 'edit', '127.0.0.1'),
(159, 'purchaseRequest', 'ad', '2013-05-03 04:47:53', 'edit', '127.0.0.1'),
(160, 'purchaseRequest', 'ad', '2013-05-03 04:48:02', 'edit', '127.0.0.1'),
(161, 'purchaseRequest', 'ad', '2013-05-03 04:49:10', 'edit', '127.0.0.1'),
(162, 'purchaseRequest', 'ad', '2013-05-03 04:49:26', 'edit', '127.0.0.1'),
(163, 'item', 'ad', '2013-05-03 07:02:15', 'add', '127.0.0.1'),
(164, 'item', 'ad', '2013-05-03 07:02:17', 'add', '127.0.0.1'),
(165, 'item', 'ad', '2013-05-03 07:02:20', 'add', '127.0.0.1'),
(166, 'item', 'ad', '2013-05-03 07:02:45', 'add', '127.0.0.1'),
(167, 'purchaseOrder', 'ad', '2013-05-03 07:03:51', 'add', '127.0.0.1'),
(168, 'purchaseOrder', 'ad', '2013-05-03 07:13:53', 'add', '127.0.0.1'),
(169, 'purchaseOrder', 'ad', '2013-05-03 07:23:32', 'edit', '127.0.0.1'),
(170, 'purchaseOrder', 'ad', '2013-05-03 07:25:08', 'edit', '127.0.0.1'),
(171, 'purchaseOrder', 'ad', '2013-05-03 07:26:32', 'edit', '127.0.0.1'),
(172, 'purchaseOrder', 'ad', '2013-05-03 07:26:47', 'edit', '127.0.0.1'),
(173, 'purchaseOrder', 'ad', '2013-05-03 07:26:53', 'edit', '127.0.0.1'),
(174, 'purchaseOrder', 'ad', '2013-05-03 07:27:03', 'edit', '127.0.0.1'),
(175, 'purchaseOrder', 'ad', '2013-05-03 07:29:40', 'edit', '127.0.0.1'),
(176, 'purchaseOrder', 'ad', '2013-05-03 07:35:53', 'edit', '127.0.0.1'),
(177, 'purchaseOrder', 'ad', '2013-05-03 07:37:41', 'edit', '127.0.0.1'),
(178, 'purchaseOrder', 'ad', '2013-05-03 07:39:31', 'edit', '127.0.0.1'),
(179, 'purchaseOrder', 'ad', '2013-05-03 07:40:23', 'edit', '127.0.0.1'),
(180, 'purchaseOrder', 'ad', '2013-05-03 07:40:42', 'edit', '127.0.0.1'),
(181, 'purchaseOrder', 'ad', '2013-05-03 07:41:57', 'edit', '127.0.0.1'),
(182, 'purchaseOrder', 'ad', '2013-05-03 07:42:07', 'edit', '127.0.0.1'),
(183, 'menu', 'ad', '2013-05-07 09:30:37', 'edit', '127.0.0.1'),
(184, 'menu', 'ad', '2013-05-07 09:30:56', 'edit', '127.0.0.1'),
(185, 'menu', 'ad', '2013-05-07 09:31:10', 'edit', '127.0.0.1'),
(186, 'menu', 'ad', '2013-05-09 04:04:24', 'edit', '127.0.0.1'),
(187, 'menu', 'ad', '2013-05-13 11:03:38', 'add', '127.0.0.1'),
(188, 'project', '0', '2013-05-14 02:01:40', 'add', '127.0.0.1'),
(189, 'project', 'ad', '2013-05-14 03:32:56', '', '127.0.0.1'),
(190, 'project', 'ad', '2013-05-14 03:33:33', '', '127.0.0.1'),
(191, 'project', 'ad', '2013-05-14 03:34:53', '', '127.0.0.1'),
(192, 'project', 'ad', '2013-05-14 03:43:27', 'edit', '127.0.0.1'),
(193, 'project', 'ad', '2013-05-14 03:43:35', 'edit', '127.0.0.1'),
(194, 'project', 'ad', '2013-05-14 03:43:53', 'edit', '127.0.0.1'),
(195, 'project', 'ad', '2013-05-14 03:43:57', 'edit', '127.0.0.1'),
(196, 'project', 'ad', '2013-05-14 03:44:01', 'edit', '127.0.0.1'),
(197, 'project', 'ad', '2013-05-14 03:44:08', 'edit', '127.0.0.1'),
(198, 'project', 'ad', '2013-05-14 03:47:24', 'edit', '127.0.0.1'),
(199, 'project', 'ad', '2013-05-14 05:34:38', 'edit', '127.0.0.1'),
(200, 'project', 'ad', '2013-05-14 05:47:38', 'edit', '127.0.0.1'),
(201, 'project', 'ad', '2013-05-14 05:48:44', 'edit', '127.0.0.1'),
(202, 'project', 'ad', '2013-05-14 06:12:46', 'edit', '127.0.0.1'),
(203, 'project', 'ad', '2013-05-14 06:12:56', 'edit', '127.0.0.1'),
(204, 'project', 'ad', '2013-05-14 06:13:05', 'edit', '127.0.0.1'),
(205, 'project', 'ad', '2013-05-14 06:13:10', 'edit', '127.0.0.1'),
(206, 'project', 'ad', '2013-05-15 01:36:23', 'edit', '127.0.0.1'),
(207, 'purchaseOrder', 'ad', '2013-05-15 01:51:43', 'edit', '127.0.0.1'),
(208, 'purchaseOrder', 'ad', '2013-05-15 01:52:01', 'edit', '127.0.0.1'),
(209, 'purchaseOrder', 'ad', '2013-05-15 01:52:12', 'edit', '127.0.0.1'),
(210, 'menu', 'ad', '2013-05-15 04:33:09', 'add', '127.0.0.1'),
(211, 'drawing', 'ad', '2013-05-17 11:35:20', 'add', '127.0.0.1'),
(212, 'drawing', 'ad', '2013-05-17 11:35:25', '', '127.0.0.1'),
(213, 'drawing', 'ad', '2013-05-17 11:35:26', '', '127.0.0.1'),
(214, 'drawing', 'ad', '2013-05-17 11:35:26', '', '127.0.0.1'),
(215, 'drawing', 'ad', '2013-05-17 11:35:26', '', '127.0.0.1'),
(216, 'drawing', 'ad', '2013-05-17 11:35:31', '', '127.0.0.1'),
(217, 'drawing', 'ad', '2013-05-17 11:35:32', '', '127.0.0.1'),
(218, 'drawing', 'ad', '2013-05-17 11:35:32', '', '127.0.0.1'),
(219, 'drawing', 'ad', '2013-05-17 11:35:32', '', '127.0.0.1'),
(220, 'drawing', 'ad', '2013-05-17 11:36:20', 'add', '127.0.0.1'),
(221, 'drawing', 'ad', '2013-05-17 11:36:28', '', '127.0.0.1'),
(222, 'drawing', 'ad', '2013-05-17 11:36:31', '', '127.0.0.1'),
(223, 'drawing', 'ad', '2013-05-17 11:36:32', '', '127.0.0.1'),
(224, 'drawing', 'ad', '2013-05-17 11:37:40', 'add', '127.0.0.1'),
(225, 'drawing', 'ad', '2013-05-17 11:40:42', 'add', '127.0.0.1'),
(226, 'drawing', 'ad', '2013-05-17 11:41:59', '', '127.0.0.1'),
(227, 'drawing', 'ad', '2013-05-17 02:20:30', 'add', '127.0.0.1'),
(228, 'drawing', 'ad', '2013-05-17 02:23:22', 'add', '127.0.0.1'),
(229, 'drawing', 'ad', '2013-05-17 02:23:49', 'add', '127.0.0.1'),
(230, 'drawing', 'ad', '2013-05-17 02:38:48', 'add', '127.0.0.1'),
(231, 'drawing', 'ad', '2013-05-17 03:40:31', 'edit', '127.0.0.1'),
(232, 'item', 'ad', '2013-05-20 11:03:58', 'edit', '127.0.0.1'),
(233, 'item', 'ad', '2013-05-20 11:04:24', 'edit', '127.0.0.1'),
(234, 'item', 'ad', '2013-05-20 11:12:22', 'edit', '127.0.0.1'),
(235, 'item', 'ad', '2013-05-20 11:13:39', 'edit', '127.0.0.1'),
(236, 'priceHistory', 'ad', '2013-05-20 04:38:02', 'add', '127.0.0.1'),
(237, 'item', 'ad', '2013-05-20 04:38:02', 'edit', '127.0.0.1'),
(238, 'priceHistory', 'ad', '2013-05-20 05:13:44', 'add', '127.0.0.1'),
(239, 'item', 'ad', '2013-05-20 05:13:44', 'edit', '127.0.0.1'),
(240, 'priceHistory', 'ad', '2013-05-20 05:14:45', 'add', '127.0.0.1'),
(241, 'item', 'ad', '2013-05-20 05:14:45', 'edit', '127.0.0.1'),
(242, 'priceHistory', 'ad', '2013-05-20 05:35:10', 'add', '127.0.0.1'),
(243, 'item', 'ad', '2013-05-20 05:35:10', 'edit', '127.0.0.1'),
(244, 'priceHistory', 'ad', '2013-05-20 05:45:28', 'edit', '127.0.0.1'),
(245, 'priceHistory', 'ad', '2013-05-20 05:51:44', 'edit', '127.0.0.1'),
(246, 'priceHistory', 'ad', '2013-05-20 05:53:12', 'edit', '127.0.0.1'),
(247, 'priceHistory', 'ad', '2013-05-20 06:13:53', 'edit', '127.0.0.1'),
(248, 'priceHistory', 'ad', '2013-05-20 06:14:03', 'add', '127.0.0.1'),
(249, 'item', 'ad', '2013-05-20 06:14:03', 'edit', '127.0.0.1'),
(250, 'priceHistory', 'ad', '2013-05-20 06:14:15', 'add', '127.0.0.1'),
(251, 'item', 'ad', '2013-05-20 06:14:15', 'edit', '127.0.0.1'),
(252, 'supplier', 'ad', '2013-05-21 10:27:32', 'edit', '127.0.0.1'),
(253, 'supplier', 'ad', '2013-05-21 10:27:36', 'edit', '127.0.0.1'),
(254, 'supplier', 'ad', '2013-05-21 10:33:11', 'edit', '127.0.0.1'),
(255, 'supplier', 'ad', '2013-05-21 11:38:19', 'edit', '127.0.0.1'),
(256, 'supplier', 'ad', '2013-05-21 11:51:00', 'add', '127.0.0.1'),
(257, 'item', 'ad', '2013-05-21 03:00:03', 'edit', '127.0.0.1'),
(258, 'supplier', 'ad', '2013-05-21 04:36:30', 'edit', '127.0.0.1'),
(259, 'supplier', 'ad', '2013-05-21 04:43:08', 'edit', '127.0.0.1'),
(260, 'purchaseDetail', 'ad', '2013-05-22 03:48:41', 'add', '127.0.0.1'),
(261, 'purchaseDetail', 'ad', '2013-05-22 04:00:20', 'del', '127.0.0.1'),
(262, 'purchaseDetail', 'ad', '2013-05-22 04:00:20', 'del', '127.0.0.1'),
(263, 'purchaseDetail', 'ad', '2013-05-22 04:00:21', 'del', '127.0.0.1'),
(264, 'purchaseDetail', 'ad', '2013-05-22 04:00:21', 'del', '127.0.0.1'),
(265, 'purchaseDetail', 'ad', '2013-05-22 04:00:21', 'del', '127.0.0.1'),
(266, 'purchaseDetail', 'ad', '2013-05-22 04:01:16', 'del', '127.0.0.1'),
(267, 'purchaseDetail', 'ad', '2013-05-22 04:01:36', 'add', '127.0.0.1'),
(268, 'purchaseDetail', 'ad', '2013-05-22 04:01:37', 'del', '127.0.0.1'),
(269, 'purchaseDetail', 'ad', '2013-05-22 04:01:41', 'add', '127.0.0.1'),
(270, 'purchaseDetail', 'ad', '2013-05-22 04:02:08', 'del', '127.0.0.1'),
(271, 'purchaseDetail', 'ad', '2013-05-22 04:02:08', 'add', '127.0.0.1'),
(272, 'purchaseDetail', 'ad', '2013-05-22 04:03:12', 'del', '127.0.0.1'),
(273, 'purchaseDetail', 'ad', '2013-05-22 04:03:12', 'add', '127.0.0.1'),
(274, 'purchaseDetail', 'ad', '2013-05-22 04:03:29', 'add', '127.0.0.1'),
(275, 'purchaseDetail', 'ad', '2013-05-22 04:22:49', 'del', '127.0.0.1'),
(276, 'purchaseDetail', 'ad', '2013-05-22 04:22:49', 'del', '127.0.0.1'),
(277, 'purchaseDetail', 'ad', '2013-05-22 04:23:03', 'add', '127.0.0.1'),
(278, 'purchaseDetail', 'ad', '2013-05-22 04:23:08', 'add', '127.0.0.1'),
(279, 'purchaseDetail', 'ad', '2013-05-22 04:23:19', 'del', '127.0.0.1'),
(280, 'purchaseDetail', 'ad', '2013-05-22 04:23:19', 'del', '127.0.0.1'),
(281, 'purchaseDetail', 'ad', '2013-05-22 04:42:33', 'add', '127.0.0.1'),
(282, 'purchaseDetail', 'ad', '2013-05-22 04:43:17', 'add', '127.0.0.1'),
(283, 'purchaseDetail', 'ad', '2013-05-22 04:43:56', 'add', '127.0.0.1'),
(284, 'purchaseDetail', 'ad', '2013-05-22 04:44:40', 'del', '127.0.0.1'),
(285, 'purchaseDetail', 'ad', '2013-05-22 04:44:40', 'del', '127.0.0.1'),
(286, 'purchaseDetail', 'ad', '2013-05-22 04:44:40', 'del', '127.0.0.1'),
(287, 'purchaseDetail', 'ad', '2013-05-22 04:45:01', 'add', '127.0.0.1'),
(288, 'purchaseDetail', 'ad', '2013-05-22 04:46:03', 'add', '127.0.0.1'),
(289, 'purchaseDetail', 'ad', '2013-05-22 04:46:29', 'add', '127.0.0.1'),
(290, 'purchaseDetail', 'ad', '2013-05-22 04:47:46', 'add', '127.0.0.1'),
(291, 'purchaseDetail', 'ad', '2013-05-22 04:48:11', 'add', '127.0.0.1'),
(292, 'purchaseDetail', 'ad', '2013-05-22 04:48:24', 'add', '127.0.0.1'),
(293, 'purchaseDetail', 'ad', '2013-05-22 04:54:51', 'add', '127.0.0.1'),
(294, 'purchaseDetail', 'ad', '2013-05-22 04:55:40', 'add', '127.0.0.1'),
(295, 'purchaseDetail', 'ad', '2013-05-22 04:57:12', 'add', '127.0.0.1'),
(296, 'purchaseDetail', 'ad', '2013-05-22 05:13:17', 'del', '127.0.0.1'),
(297, 'purchaseDetail', 'ad', '2013-05-22 05:13:17', 'del', '127.0.0.1'),
(298, 'purchaseDetail', 'ad', '2013-05-22 05:13:17', 'del', '127.0.0.1'),
(299, 'purchaseDetail', 'ad', '2013-05-22 05:13:17', 'del', '127.0.0.1'),
(300, 'purchaseDetail', 'ad', '2013-05-22 05:13:17', 'del', '127.0.0.1'),
(301, 'purchaseDetail', 'ad', '2013-05-22 05:13:17', 'del', '127.0.0.1'),
(302, 'purchaseDetail', 'ad', '2013-05-22 05:13:17', 'del', '127.0.0.1'),
(303, 'purchaseDetail', 'ad', '2013-05-22 05:13:17', 'del', '127.0.0.1'),
(304, 'purchaseDetail', 'ad', '2013-05-22 05:13:17', 'del', '127.0.0.1'),
(305, 'purchaseDetail', 'ad', '2013-05-22 05:14:36', 'add', '127.0.0.1'),
(306, 'purchaseDetail', 'ad', '2013-05-22 05:14:41', 'add', '127.0.0.1'),
(307, 'purchaseDetail', 'ad', '2013-05-22 05:20:08', 'del', '127.0.0.1'),
(308, 'purchaseDetail', 'ad', '2013-05-22 05:20:08', 'del', '127.0.0.1'),
(309, 'purchaseRequest', 'ad', '2013-05-22 05:20:46', 'add', '127.0.0.1'),
(310, 'purchaseDetail', 'ad', '2013-05-22 05:21:12', 'add', '127.0.0.1'),
(311, 'purchaseDetail', 'ad', '2013-05-22 05:21:18', 'add', '127.0.0.1'),
(312, 'purchaseDetail', 'ad', '2013-05-22 05:21:24', 'add', '127.0.0.1'),
(313, 'purchaseRequest', 'ad', '2013-05-22 05:22:05', 'add', '127.0.0.1'),
(314, 'purchaseDetail', '0', '2013-05-22 05:28:24', 'del', '127.0.0.1'),
(315, 'purchaseDetail', '0', '2013-05-22 05:28:24', 'del', '127.0.0.1'),
(316, 'purchaseDetail', '0', '2013-05-22 05:28:24', 'del', '127.0.0.1'),
(317, 'purchaseRequest', '0', '2013-05-22 05:28:33', 'add', '127.0.0.1'),
(318, 'purchaseRequest', '0', '2013-05-22 05:29:07', 'add', '127.0.0.1'),
(319, 'purchaseRequest', '0', '2013-05-22 05:29:43', 'add', '127.0.0.1'),
(320, 'purchaseRequest', '0', '2013-05-22 05:31:12', 'add', '127.0.0.1'),
(321, 'purchaseRequest', '0', '2013-05-22 05:34:31', 'add', '127.0.0.1'),
(322, 'purchaseRequest', '0', '2013-05-22 05:34:54', 'add', '127.0.0.1'),
(323, 'purchaseRequest', '0', '2013-05-22 05:35:51', 'add', '127.0.0.1'),
(324, 'purchaseRequest', '0', '2013-05-22 05:36:32', 'add', '127.0.0.1'),
(325, 'purchaseRequest', '0', '2013-05-22 05:36:58', 'add', '127.0.0.1'),
(326, 'purchaseDetail', 'ad', '2013-05-22 05:48:07', 'add', '127.0.0.1'),
(327, 'purchaseDetail', 'ad', '2013-05-22 05:48:12', 'add', '127.0.0.1'),
(328, 'purchaseDetail', 'ad', '2013-05-22 05:48:17', 'add', '127.0.0.1'),
(329, 'purchaseRequest', 'ad', '2013-05-22 05:48:29', 'add', '127.0.0.1'),
(330, 'purchaseDetail', 'ad', '2013-05-22 05:49:28', 'del', '127.0.0.1'),
(331, 'purchaseDetail', 'ad', '2013-05-22 05:49:28', 'del', '127.0.0.1'),
(332, 'purchaseDetail', 'ad', '2013-05-22 05:49:28', 'del', '127.0.0.1'),
(333, 'purchaseDetail', 'ad', '2013-05-22 05:49:45', 'add', '127.0.0.1'),
(334, 'purchaseDetail', 'ad', '2013-05-22 05:49:45', 'edit', '127.0.0.1'),
(335, 'purchaseDetail', 'ad', '2013-05-22 05:49:57', 'add', '127.0.0.1'),
(336, 'purchaseDetail', 'ad', '2013-05-22 05:49:57', 'edit', '127.0.0.1'),
(337, 'purchaseDetail', 'ad', '2013-05-22 05:49:57', 'edit', '127.0.0.1'),
(338, 'purchaseRequest', 'ad', '2013-05-22 05:50:07', 'add', '127.0.0.1'),
(339, 'purchaseDetail', 'ad', '2013-05-22 05:50:07', 'edit', '127.0.0.1'),
(340, 'purchaseDetail', 'ad', '2013-05-22 05:50:07', 'edit', '127.0.0.1'),
(341, 'purchaseDetail', 'ad', '2013-05-22 05:59:40', 'add', '127.0.0.1'),
(342, 'purchaseDetail', 'ad', '2013-05-22 05:59:40', 'edit', '127.0.0.1'),
(343, 'purchaseDetail', 'ad', '2013-05-22 05:59:45', 'add', '127.0.0.1'),
(344, 'purchaseDetail', 'ad', '2013-05-22 05:59:45', 'edit', '127.0.0.1'),
(345, 'purchaseDetail', 'ad', '2013-05-22 05:59:45', 'edit', '127.0.0.1'),
(346, 'purchaseDetail', 'ad', '2013-05-22 05:59:49', 'add', '127.0.0.1'),
(347, 'purchaseDetail', 'ad', '2013-05-22 05:59:49', 'edit', '127.0.0.1'),
(348, 'purchaseDetail', 'ad', '2013-05-22 05:59:49', 'edit', '127.0.0.1'),
(349, 'purchaseDetail', 'ad', '2013-05-22 05:59:49', 'edit', '127.0.0.1'),
(350, 'purchaseRequest', 'ad', '2013-05-22 06:00:12', 'add', '127.0.0.1'),
(351, 'purchaseDetail', 'ad', '2013-05-22 06:00:12', 'edit', '127.0.0.1'),
(352, 'purchaseDetail', 'ad', '2013-05-22 06:00:12', 'edit', '127.0.0.1'),
(353, 'purchaseDetail', 'ad', '2013-05-22 06:00:12', 'edit', '127.0.0.1'),
(354, 'purchaseDetail', 'ad', '2013-05-22 06:02:13', 'add', '127.0.0.1'),
(355, 'purchaseDetail', 'ad', '2013-05-22 06:02:13', 'edit', '127.0.0.1'),
(356, 'purchaseDetail', 'ad', '2013-05-22 06:02:18', 'add', '127.0.0.1'),
(357, 'purchaseDetail', 'ad', '2013-05-22 06:02:18', 'edit', '127.0.0.1'),
(358, 'purchaseDetail', 'ad', '2013-05-22 06:02:18', 'edit', '127.0.0.1'),
(359, 'purchaseDetail', 'ad', '2013-05-22 06:02:23', 'add', '127.0.0.1'),
(360, 'purchaseDetail', 'ad', '2013-05-22 06:02:23', 'edit', '127.0.0.1'),
(361, 'purchaseDetail', 'ad', '2013-05-22 06:02:23', 'edit', '127.0.0.1'),
(362, 'purchaseDetail', 'ad', '2013-05-22 06:02:23', 'edit', '127.0.0.1'),
(363, 'purchaseRequest', 'ad', '2013-05-22 06:02:29', 'add', '127.0.0.1'),
(364, 'purchaseDetail', 'ad', '2013-05-22 06:02:29', 'edit', '127.0.0.1'),
(365, 'purchaseDetail', 'ad', '2013-05-22 06:02:29', 'edit', '127.0.0.1'),
(366, 'purchaseDetail', 'ad', '2013-05-22 06:02:29', 'edit', '127.0.0.1'),
(367, 'purchaseDetail', 'ad', '2013-05-22 06:13:44', 'add', '127.0.0.1'),
(368, 'purchaseDetail', 'ad', '2013-05-22 06:13:44', 'edit', '127.0.0.1'),
(369, 'purchaseDetail', 'ad', '2013-05-22 06:13:48', 'add', '127.0.0.1'),
(370, 'purchaseDetail', 'ad', '2013-05-22 06:13:48', 'edit', '127.0.0.1'),
(371, 'purchaseDetail', 'ad', '2013-05-22 06:13:48', 'edit', '127.0.0.1'),
(372, 'purchaseDetail', 'ad', '2013-05-22 06:13:53', 'add', '127.0.0.1'),
(373, 'purchaseDetail', 'ad', '2013-05-22 06:13:53', 'edit', '127.0.0.1'),
(374, 'purchaseDetail', 'ad', '2013-05-22 06:13:53', 'edit', '127.0.0.1'),
(375, 'purchaseDetail', 'ad', '2013-05-22 06:13:53', 'edit', '127.0.0.1'),
(376, 'purchaseRequest', 'ad', '2013-05-22 06:13:57', 'edit', '127.0.0.1'),
(377, 'purchaseDetail', 'ad', '2013-05-22 06:13:57', 'edit', '127.0.0.1'),
(378, 'purchaseDetail', 'ad', '2013-05-22 06:13:57', 'edit', '127.0.0.1'),
(379, 'purchaseDetail', 'ad', '2013-05-22 06:13:57', 'edit', '127.0.0.1'),
(380, 'purchaseRequest', 'ad', '2013-05-22 06:14:41', 'del', '127.0.0.1'),
(381, 'purchaseDetail', 'ad', '2013-05-22 06:15:20', 'del', '127.0.0.1'),
(382, 'purchaseRequest', 'ad', '2013-05-22 06:21:53', 'edit', '127.0.0.1'),
(383, 'purchaseDetail', 'ad', '2013-05-22 06:21:53', 'edit', '127.0.0.1'),
(384, 'purchaseDetail', 'ad', '2013-05-22 06:21:53', 'edit', '127.0.0.1'),
(385, 'purchaseRequest', 'ad', '2013-05-23 11:26:18', 'edit', '127.0.0.1'),
(386, 'purchaseRequest', 'ad', '2013-05-23 11:27:12', 'edit', '127.0.0.1'),
(387, 'purchaseRequest', 'ad', '2013-05-23 11:27:49', 'edit', '127.0.0.1'),
(388, 'purchaseRequest', 'ad', '2013-05-23 11:29:26', 'edit', '127.0.0.1'),
(389, 'purchaseRequest', 'ad', '2013-05-23 11:30:41', 'edit', '127.0.0.1'),
(390, 'purchaseRequest', 'ad', '2013-05-23 11:32:07', 'edit', '127.0.0.1'),
(391, 'purchaseRequest', 'ad', '2013-05-23 11:32:15', 'edit', '127.0.0.1'),
(392, 'purchaseRequest', 'ad', '2013-05-23 11:34:38', 'edit', '127.0.0.1'),
(393, 'purchaseRequest', 'ad', '2013-05-23 11:34:47', 'edit', '127.0.0.1'),
(394, 'item', 'ad', '2013-05-27 11:13:08', 'edit', '127.0.0.1'),
(395, 'supplier', 'ad', '2013-05-27 11:13:15', 'edit', '127.0.0.1'),
(396, 'item', 'ad', '2013-05-27 11:13:39', 'edit', '127.0.0.1'),
(397, 'item', 'ad', '2013-05-27 11:13:43', 'edit', '127.0.0.1'),
(398, 'item', 'ad', '2013-05-27 11:13:51', 'edit', '127.0.0.1'),
(399, 'purchaseDetail', 'ad', '2013-05-27 03:20:36', 'add', '127.0.0.1'),
(400, 'purchaseDetail', 'ad', '2013-05-27 03:20:36', 'edit', '127.0.0.1'),
(401, 'purchaseDetail', 'ad', '2013-05-27 05:26:44', 'edit', '127.0.0.1'),
(402, 'purchaseDetail', 'ad', '2013-05-27 05:30:08', 'edit', '127.0.0.1'),
(403, 'purchaseDetail', 'ad', '2013-05-27 05:30:20', 'edit', '127.0.0.1'),
(404, 'purchaseDetail', 'ad', '2013-05-27 05:31:25', 'edit', '127.0.0.1'),
(405, 'purchaseDetail', 'ad', '2013-05-27 05:31:38', 'edit', '127.0.0.1'),
(406, 'purchaseDetail', 'ad', '2013-05-27 05:32:18', 'edit', '127.0.0.1'),
(407, 'purchaseDetail', 'ad', '2013-05-27 05:32:26', 'edit', '127.0.0.1'),
(408, 'purchaseDetail', 'ad', '2013-05-27 05:32:27', 'edit', '127.0.0.1'),
(409, 'purchaseDetail', 'ad', '2013-05-27 05:32:29', 'edit', '127.0.0.1'),
(410, 'purchaseDetail', 'ad', '2013-05-27 05:32:30', 'edit', '127.0.0.1'),
(411, 'purchaseDetail', 'ad', '2013-05-27 05:32:31', 'edit', '127.0.0.1'),
(412, 'purchaseDetail', 'ad', '2013-05-27 05:32:32', 'edit', '127.0.0.1'),
(413, 'purchaseDetail', 'ad', '2013-05-27 05:32:53', 'edit', '127.0.0.1'),
(414, 'purchaseDetail', 'ad', '2013-05-27 05:32:55', 'edit', '127.0.0.1'),
(415, 'purchaseDetail', 'ad', '2013-05-27 05:32:56', 'edit', '127.0.0.1'),
(416, 'purchaseDetail', 'ad', '2013-05-27 05:37:10', 'edit', '127.0.0.1'),
(417, 'purchaseDetail', 'ad', '2013-05-28 09:56:33', 'edit', '127.0.0.1'),
(418, 'purchaseDetail', 'ad', '2013-05-28 09:56:35', 'edit', '127.0.0.1'),
(419, 'purchaseDetail', 'ad', '2013-05-28 09:56:36', 'edit', '127.0.0.1'),
(420, 'purchaseDetail', 'ad', '2013-05-28 09:56:37', 'edit', '127.0.0.1'),
(421, 'purchaseDetail', 'ad', '2013-05-28 09:56:38', 'edit', '127.0.0.1'),
(422, 'purchaseDetail', 'ad', '2013-05-28 09:56:39', 'edit', '127.0.0.1'),
(423, 'purchaseDetail', 'ad', '2013-05-28 09:56:40', 'edit', '127.0.0.1'),
(424, 'purchaseDetail', 'ad', '2013-05-28 09:56:41', 'edit', '127.0.0.1'),
(425, 'purchaseRequest', 'ad', '2013-05-28 09:56:50', 'edit', '127.0.0.1'),
(426, 'purchaseDetail', 'ad', '2013-05-28 09:56:50', 'edit', '127.0.0.1'),
(427, 'purchaseDetail', 'ad', '2013-05-28 09:56:50', 'edit', '127.0.0.1'),
(428, 'purchaseDetail', 'ad', '2013-05-28 04:00:28', 'add', '127.0.0.1'),
(429, 'purchaseDetail', 'ad', '2013-05-28 04:00:28', 'edit', '127.0.0.1'),
(430, 'purchaseDetail', 'ad', '2013-05-28 04:01:33', 'add', '127.0.0.1'),
(431, 'purchaseDetail', 'ad', '2013-05-28 04:01:40', 'add', '127.0.0.1'),
(432, 'purchaseDetail', 'ad', '2013-05-28 04:02:57', 'add', '127.0.0.1'),
(433, 'purchaseDetail', 'ad', '2013-05-28 04:02:57', 'edit', '127.0.0.1'),
(434, 'purchaseDetail', 'ad', '2013-05-28 04:08:00', 'edit', '127.0.0.1'),
(435, 'purchaseDetail', 'ad', '2013-05-28 04:08:02', 'edit', '127.0.0.1'),
(436, 'purchaseDetail', 'ad', '2013-05-28 04:08:19', 'edit', '127.0.0.1'),
(437, 'purchaseDetail', 'ad', '2013-05-28 04:09:49', 'edit', '127.0.0.1'),
(438, 'purchaseDetail', 'ad', '2013-05-28 04:10:20', 'edit', '127.0.0.1'),
(439, 'purchaseDetail', 'ad', '2013-05-28 04:11:59', 'edit', '127.0.0.1'),
(440, 'purchaseDetail', 'ad', '2013-05-28 04:13:32', 'edit', '127.0.0.1'),
(441, 'purchaseDetail', 'ad', '2013-05-28 04:13:34', 'edit', '127.0.0.1'),
(442, 'purchaseDetail', 'ad', '2013-05-28 04:13:36', 'edit', '127.0.0.1'),
(443, 'purchaseDetail', 'ad', '2013-05-28 04:16:13', 'edit', '127.0.0.1'),
(444, 'purchaseDetail', 'ad', '2013-05-28 04:16:47', 'edit', '127.0.0.1'),
(445, 'purchaseDetail', 'ad', '2013-05-28 04:16:53', 'edit', '127.0.0.1'),
(446, 'purchaseDetail', 'ad', '2013-05-28 04:16:54', 'edit', '127.0.0.1'),
(447, 'purchaseDetail', 'ad', '2013-05-28 06:31:35', 'del', '127.0.0.1'),
(448, 'purchaseDetail', 'ad', '2013-05-28 06:31:35', 'del', '127.0.0.1'),
(449, 'purchaseDetail', 'ad', '2013-05-28 06:31:41', 'add', '127.0.0.1'),
(450, 'purchaseDetail', 'ad', '2013-05-28 06:31:41', 'edit', '127.0.0.1'),
(451, 'drawing', 'ad', '2013-05-30 11:12:35', 'edit', '127.0.0.1'),
(452, 'drawing', 'ad', '2013-05-30 11:12:41', 'edit', '127.0.0.1'),
(453, 'drawing', 'ad', '2013-05-30 11:12:47', 'edit', '127.0.0.1'),
(454, 'purchaseRequest', 'ad', '2013-05-30 11:20:47', 'edit', '127.0.0.1'),
(455, 'purchaseDetail', 'ad', '2013-05-30 11:20:47', 'edit', '127.0.0.1'),
(456, 'purchaseDetail', 'ad', '2013-05-30 11:20:47', 'edit', '127.0.0.1'),
(457, 'purchaseDetail', 'ad', '2013-05-30 11:20:47', 'edit', '127.0.0.1'),
(458, 'purchaseRequest', 'ad', '2013-05-30 11:20:57', 'edit', '127.0.0.1'),
(459, 'purchaseDetail', 'ad', '2013-05-30 11:20:57', 'edit', '127.0.0.1'),
(460, 'purchaseDetail', 'ad', '2013-05-30 11:20:58', 'edit', '127.0.0.1'),
(461, 'purchaseDetail', 'ad', '2013-05-30 11:20:58', 'edit', '127.0.0.1'),
(462, 'warehouse', 'ad', '2013-06-03 09:58:55', 'add', '127.0.0.1'),
(463, 'warehouse', 'ad', '2013-06-03 09:59:48', 'add', '127.0.0.1'),
(464, 'warehouse', 'ad', '2013-06-03 10:00:40', 'add', '127.0.0.1'),
(465, 'warehouse', 'ad', '2013-06-03 10:02:59', 'add', '127.0.0.1'),
(466, 'warehouse', 'ad', '2013-06-03 10:03:20', 'add', '127.0.0.1'),
(467, 'warehouse', 'ad', '2013-06-03 10:04:42', 'add', '127.0.0.1'),
(468, 'warehouse', 'ad', '2013-06-03 10:06:27', 'add', '127.0.0.1'),
(469, 'warehouse', 'ad', '2013-06-03 10:10:38', 'add', '127.0.0.1'),
(470, 'warehouse', 'ad', '2013-06-03 02:06:43', 'edit', '127.0.0.1'),
(471, 'warehouse', 'ad', '2013-06-03 02:07:00', 'edit', '127.0.0.1'),
(472, 'warehouse', 'ad', '2013-06-03 02:07:25', 'edit', '127.0.0.1'),
(473, 'warehouse', 'ad', '2013-06-03 02:08:07', 'edit', '127.0.0.1'),
(474, 'warehouse', 'ad', '2013-06-03 02:08:22', 'edit', '127.0.0.1'),
(475, 'supplier', 'ad', '2013-06-03 02:09:57', 'edit', '127.0.0.1'),
(476, 'warehouse', 'ad', '2013-06-03 02:19:44', 'edit', '127.0.0.1'),
(477, 'menuType', 'ad', '2013-06-06 11:39:05', 'edit', '127.0.0.1'),
(478, 'purchaseOrder', 'maple', '2013-06-07 04:54:46', 'add', '127.0.0.1'),
(479, 'purchaseOrder', 'maple', '2013-06-07 05:04:53', 'add', '127.0.0.1'),
(480, 'purchaseOrder', 'maple', '2013-06-07 05:06:16', 'add', '127.0.0.1'),
(481, 'purchaseOrder', 'maple', '2013-06-07 05:52:10', 'add', '127.0.0.1'),
(482, 'purchaseOrder', 'maple', '2013-06-07 05:56:35', 'add', '127.0.0.1'),
(483, 'purchaseOrder', 'maple', '2013-06-07 05:59:02', 'add', '127.0.0.1'),
(484, 'purchaseOrder', 'maple', '2013-06-07 06:05:50', 'add', '127.0.0.1'),
(485, 'purchaseOrder', 'maple', '2013-06-07 06:08:10', 'add', '127.0.0.1'),
(486, 'purchaseOrder', 'maple', '2013-06-07 06:10:26', 'add', '127.0.0.1'),
(487, 'purchaseOrder', 'maple', '2013-06-07 06:12:27', 'add', '127.0.0.1'),
(488, 'purchaseOrder', 'maple', '2013-06-07 06:14:28', 'add', '127.0.0.1'),
(489, 'purchaseOrder', 'maple', '2013-06-07 06:14:28', 'edit', '127.0.0.1'),
(490, 'purchaseOrder', 'maple', '2013-06-07 06:14:28', 'edit', '127.0.0.1'),
(491, 'purchaseOrder', 'maple', '2013-06-07 06:16:20', 'add', '127.0.0.1'),
(492, 'purchaseOrder', 'maple', '2013-06-07 06:16:20', 'edit', '127.0.0.1'),
(493, 'purchaseOrder', 'maple', '2013-06-07 06:17:33', 'add', '127.0.0.1'),
(494, 'purchaseOrder', 'maple', '2013-06-07 06:17:33', 'edit', '127.0.0.1'),
(495, 'purchaseOrder', 'maple', '2013-06-07 06:17:33', 'edit', '127.0.0.1'),
(496, 'purchaseOrder', 'maple', '2013-06-07 06:19:47', 'add', '127.0.0.1'),
(497, 'purchaseOrder', 'maple', '2013-06-07 06:19:47', 'edit', '127.0.0.1'),
(498, 'purchaseOrder', 'maple', '2013-06-07 06:24:07', 'add', '127.0.0.1'),
(499, 'purchaseDetail', 'maple', '2013-06-07 06:24:07', 'edit', '127.0.0.1'),
(500, 'purchaseDetail', 'maple', '2013-06-07 06:24:08', 'edit', '127.0.0.1'),
(501, 'purchaseOrder', 'maple', '2013-06-08 03:53:38', 'edit', '127.0.0.1'),
(502, 'purchaseDetail', 'maple', '2013-06-08 03:53:38', 'edit', '127.0.0.1'),
(503, 'purchaseDetail', 'maple', '2013-06-08 03:53:38', 'edit', '127.0.0.1'),
(504, 'purchaseOrder', 'maple', '2013-06-08 03:54:59', 'edit', '127.0.0.1'),
(505, 'purchaseDetail', 'maple', '2013-06-08 03:55:00', 'edit', '127.0.0.1'),
(506, 'purchaseDetail', 'maple', '2013-06-08 03:55:00', 'edit', '127.0.0.1'),
(507, 'purchaseOrder', 'maple', '2013-06-08 03:56:08', 'edit', '127.0.0.1'),
(508, 'purchaseDetail', 'maple', '2013-06-08 03:56:08', 'edit', '127.0.0.1'),
(509, 'purchaseDetail', 'maple', '2013-06-08 03:56:08', 'edit', '127.0.0.1'),
(510, 'purchaseOrder', 'maple', '2013-06-08 03:57:04', 'add', '127.0.0.1'),
(511, 'purchaseDetail', 'maple', '2013-06-08 03:57:04', 'edit', '127.0.0.1'),
(512, 'purchaseOrder', 'maple', '2013-06-08 03:57:25', 'edit', '127.0.0.1'),
(513, 'purchaseDetail', 'maple', '2013-06-08 03:57:26', 'edit', '127.0.0.1'),
(514, 'purchaseDetail', 'maple', '2013-06-08 03:57:26', 'edit', '127.0.0.1'),
(515, 'purchaseOrder', 'maple', '2013-06-08 03:57:38', 'edit', '127.0.0.1'),
(516, 'purchaseDetail', 'maple', '2013-06-08 03:57:38', 'edit', '127.0.0.1'),
(517, 'purchaseDetail', 'maple', '2013-06-08 03:57:38', 'edit', '127.0.0.1'),
(518, 'purchaseOrder', 'maple', '2013-06-08 03:59:41', 'edit', '127.0.0.1'),
(519, 'purchaseDetail', 'maple', '2013-06-08 03:59:42', 'edit', '127.0.0.1'),
(520, 'purchaseDetail', 'maple', '2013-06-08 03:59:42', 'edit', '127.0.0.1'),
(521, 'purchaseOrder', 'maple', '2013-06-08 04:00:20', 'edit', '127.0.0.1'),
(522, 'purchaseDetail', 'maple', '2013-06-08 04:00:21', 'edit', '127.0.0.1'),
(523, 'purchaseDetail', 'maple', '2013-06-08 04:00:21', 'edit', '127.0.0.1'),
(524, 'purchaseOrder', 'maple', '2013-06-08 04:00:49', 'edit', '127.0.0.1'),
(525, 'purchaseDetail', 'maple', '2013-06-08 04:00:50', 'edit', '127.0.0.1'),
(526, 'purchaseOrder', 'maple', '2013-06-08 04:02:09', 'edit', '127.0.0.1'),
(527, 'purchaseDetail', 'maple', '2013-06-08 04:02:09', 'edit', '127.0.0.1'),
(528, 'purchaseDetail', 'maple', '2013-06-08 04:02:09', 'edit', '127.0.0.1'),
(529, 'purchaseOrder', 'maple', '2013-06-08 04:03:20', 'edit', '127.0.0.1'),
(530, 'purchaseDetail', 'maple', '2013-06-08 04:03:21', 'edit', '127.0.0.1'),
(531, 'purchaseDetail', 'maple', '2013-06-08 04:03:21', 'edit', '127.0.0.1'),
(532, 'purchaseOrder', 'maple', '2013-06-08 04:18:03', 'edit', '127.0.0.1'),
(533, 'purchaseDetail', 'maple', '2013-06-08 04:18:03', 'edit', '127.0.0.1'),
(534, 'purchaseDetail', 'maple', '2013-06-08 04:18:03', 'edit', '127.0.0.1'),
(535, 'purchaseOrder', 'maple', '2013-06-08 04:53:22', 'edit', '127.0.0.1'),
(536, 'purchaseOrder', 'maple', '2013-06-08 05:07:33', 'edit', '127.0.0.1'),
(537, 'purchaseOrder', 'maple', '2013-06-08 05:07:36', 'edit', '127.0.0.1'),
(538, 'purchaseOrder', 'maple', '2013-06-08 05:07:36', 'edit', '127.0.0.1'),
(539, 'purchaseOrder', 'maple', '2013-06-08 05:07:42', 'edit', '127.0.0.1'),
(540, 'purchaseDetail', 'maple', '2013-06-08 05:07:42', 'edit', '127.0.0.1'),
(541, 'purchaseDetail', 'maple', '2013-06-08 05:07:42', 'edit', '127.0.0.1'),
(542, 'purchaseOrder', 'maple', '2013-06-08 05:07:48', 'edit', '127.0.0.1'),
(543, 'purchaseDetail', 'maple', '2013-06-08 05:07:48', 'edit', '127.0.0.1'),
(544, 'purchaseDetail', 'maple', '2013-06-08 05:07:48', 'edit', '127.0.0.1'),
(545, 'warehouse', 'maple', '2013-06-10 11:42:18', 'add', '127.0.0.1'),
(546, 'purchaseOrder', 'maple', '2013-06-10 03:08:36', 'edit', '127.0.0.1'),
(547, 'purchaseDetail', 'maple', '2013-06-10 03:08:36', 'edit', '127.0.0.1'),
(548, 'purchaseDetail', 'maple', '2013-06-10 03:08:36', 'edit', '127.0.0.1'),
(549, 'purchaseOrder', 'maple', '2013-06-10 03:10:36', 'edit', '127.0.0.1'),
(550, 'purchaseDetail', 'maple', '2013-06-10 03:10:36', 'edit', '127.0.0.1'),
(551, 'purchaseDetail', 'maple', '2013-06-10 03:10:36', 'edit', '127.0.0.1'),
(552, 'purchaseOrder', 'maple', '2013-06-10 03:11:01', 'edit', '127.0.0.1'),
(553, 'purchaseOrder', 'maple', '2013-06-10 03:11:04', 'edit', '127.0.0.1'),
(554, 'purchaseOrder', 'maple', '2013-06-10 03:11:09', 'edit', '127.0.0.1'),
(555, 'purchaseOrder', 'maple', '2013-06-10 03:11:09', 'edit', '127.0.0.1'),
(556, 'purchaseOrder', 'maple', '2013-06-10 03:11:09', 'edit', '127.0.0.1'),
(557, 'purchaseOrder', 'maple', '2013-06-10 03:11:10', 'edit', '127.0.0.1'),
(558, 'purchaseOrder', 'maple', '2013-06-10 03:12:23', 'edit', '127.0.0.1'),
(559, 'purchaseDetail', 'maple', '2013-06-10 03:12:23', 'edit', '127.0.0.1'),
(560, 'purchaseDetail', 'maple', '2013-06-10 03:12:23', 'edit', '127.0.0.1'),
(561, 'purchaseOrder', 'maple', '2013-06-10 03:13:16', 'edit', '127.0.0.1'),
(562, 'purchaseDetail', 'maple', '2013-06-10 03:13:16', 'edit', '127.0.0.1'),
(563, 'purchaseDetail', 'maple', '2013-06-10 03:13:16', 'edit', '127.0.0.1'),
(564, 'purchaseOrder', 'maple', '2013-06-10 03:13:23', 'edit', '127.0.0.1'),
(565, 'purchaseDetail', 'maple', '2013-06-10 03:13:23', 'edit', '127.0.0.1'),
(566, 'purchaseDetail', 'maple', '2013-06-10 03:13:23', 'edit', '127.0.0.1'),
(567, 'purchaseOrder', 'maple', '2013-06-10 03:16:07', 'edit', '127.0.0.1'),
(568, 'purchaseDetail', 'maple', '2013-06-10 03:16:07', 'edit', '127.0.0.1'),
(569, 'purchaseOrder', 'maple', '2013-06-10 03:16:23', 'edit', '127.0.0.1'),
(570, 'purchaseDetail', 'maple', '2013-06-10 03:16:23', 'edit', '127.0.0.1'),
(571, 'purchaseDetail', 'maple', '2013-06-10 03:16:23', 'edit', '127.0.0.1'),
(572, 'purchaseOrder', 'maple', '2013-06-10 03:17:16', 'edit', '127.0.0.1'),
(573, 'purchaseDetail', 'maple', '2013-06-10 03:17:17', 'edit', '127.0.0.1'),
(574, 'purchaseDetail', 'maple', '2013-06-10 03:17:17', 'edit', '127.0.0.1'),
(575, 'purchaseOrder', 'maple', '2013-06-10 03:17:26', 'edit', '127.0.0.1'),
(576, 'purchaseDetail', 'maple', '2013-06-10 03:17:26', 'edit', '127.0.0.1'),
(577, 'purchaseOrder', 'maple', '2013-06-10 03:18:02', 'add', '127.0.0.1'),
(578, 'purchaseDetail', 'maple', '2013-06-10 03:18:02', 'edit', '127.0.0.1'),
(579, 'purchaseOrder', 'maple', '2013-06-10 03:18:16', 'edit', '127.0.0.1'),
(580, 'purchaseOrder', 'maple', '2013-06-10 03:20:21', 'add', '127.0.0.1'),
(581, 'purchaseDetail', 'maple', '2013-06-10 03:20:22', 'edit', '127.0.0.1'),
(582, 'purchaseDetail', 'maple', '2013-06-10 03:20:22', 'edit', '127.0.0.1'),
(583, 'purchaseOrder', 'maple', '2013-06-10 03:20:37', 'edit', '127.0.0.1'),
(584, 'purchaseDetail', 'maple', '2013-06-10 03:20:37', 'edit', '127.0.0.1'),
(585, 'purchaseOrder', 'maple', '2013-06-10 03:21:21', 'edit', '127.0.0.1'),
(586, 'purchaseDetail', 'maple', '2013-06-10 03:21:21', 'edit', '127.0.0.1'),
(587, 'purchaseOrder', 'maple', '2013-06-10 03:21:26', 'edit', '127.0.0.1'),
(588, 'purchaseDetail', 'maple', '2013-06-10 03:21:26', 'edit', '127.0.0.1'),
(589, 'purchaseOrder', 'maple', '2013-06-10 03:21:36', 'edit', '127.0.0.1'),
(590, 'purchaseDetail', 'maple', '2013-06-10 03:21:37', 'edit', '127.0.0.1'),
(591, 'purchaseDetail', 'maple', '2013-06-10 03:21:37', 'edit', '127.0.0.1'),
(592, 'purchaseOrder', 'maple', '2013-06-10 03:21:49', 'edit', '127.0.0.1'),
(593, 'purchaseOrder', 'maple', '2013-06-10 03:23:21', 'del', '127.0.0.1'),
(594, 'purchaseOrder', 'maple', '2013-06-10 04:02:25', 'edit', '127.0.0.1'),
(595, 'purchaseDetail', 'maple', '2013-06-10 04:02:25', 'edit', '127.0.0.1'),
(596, 'purchaseOrder', 'maple', '2013-06-10 04:07:15', 'edit', '127.0.0.1'),
(597, 'purchaseDetail', 'maple', '2013-06-10 04:07:16', 'edit', '127.0.0.1'),
(598, 'purchaseDetail', 'maple', '2013-06-10 04:07:16', 'edit', '127.0.0.1'),
(599, 'purchaseOrder', 'maple', '2013-06-10 04:07:23', 'edit', '127.0.0.1'),
(600, 'purchaseDetail', 'maple', '2013-06-10 04:07:23', 'edit', '127.0.0.1'),
(601, 'purchaseOrder', 'maple', '2013-06-10 04:08:44', 'edit', '127.0.0.1'),
(602, 'purchaseDetail', 'maple', '2013-06-10 04:08:45', 'edit', '127.0.0.1'),
(603, 'purchaseOrder', 'maple', '2013-06-10 04:16:10', 'add', '127.0.0.1'),
(604, 'purchaseDetail', 'maple', '2013-06-10 04:16:11', 'edit', '127.0.0.1'),
(605, 'purchaseDetail', 'maple', '2013-06-10 04:16:11', 'edit', '127.0.0.1'),
(606, 'purchaseDetail', 'maple', '2013-06-11 10:49:00', 'edit', '127.0.0.1'),
(607, 'item', 'maple', '2013-06-11 11:05:46', 'del', '127.0.0.1'),
(608, 'supplier', 'maple', '2013-06-11 02:46:21', 'add', '127.0.0.1'),
(609, 'supplier', 'maple', '2013-06-11 02:46:26', 'del', '127.0.0.1'),
(610, 'purchaseDetail', 'maple', '2013-06-11 11:03:43', 'edit', '127.0.0.1'),
(611, 'purchaseDetail', 'maple', '2013-06-11 11:04:01', 'edit', '127.0.0.1'),
(612, 'purchaseDetail', 'maple', '2013-06-11 11:04:15', 'edit', '127.0.0.1'),
(613, 'purchaseDetail', 'maple', '2013-06-11 11:06:14', 'edit', '127.0.0.1'),
(614, 'purchaseDetail', 'maple', '2013-06-11 11:06:45', 'edit', '127.0.0.1'),
(615, 'purchaseDetail', 'maple', '2013-06-11 11:08:12', 'edit', '127.0.0.1'),
(616, 'purchaseDetail', 'maple', '2013-06-11 11:08:49', 'edit', '127.0.0.1'),
(617, 'itemInventory', 'maple', '2013-06-11 11:08:49', 'add', '127.0.0.1'),
(618, 'purchaseDetail', 'maple', '2013-06-11 11:12:29', 'edit', '127.0.0.1'),
(619, 'itemInventory', 'maple', '2013-06-11 11:12:29', 'add', '127.0.0.1'),
(620, 'purchaseDetail', 'maple', '2013-06-11 11:14:34', 'edit', '127.0.0.1'),
(621, 'itemInventory', 'maple', '2013-06-11 11:14:35', 'edit', '127.0.0.1'),
(622, 'purchaseDetail', 'maple', '2013-06-11 11:16:18', 'add', '127.0.0.1'),
(623, 'purchaseDetail', 'maple', '2013-06-11 11:16:18', 'edit', '127.0.0.1'),
(624, 'purchaseRequest', 'maple', '2013-06-11 11:16:37', 'add', '127.0.0.1'),
(625, 'purchaseDetail', 'maple', '2013-06-11 11:16:37', 'edit', '127.0.0.1'),
(626, 'purchaseDetail', 'maple', '2013-06-11 11:18:15', 'add', '127.0.0.1'),
(627, 'purchaseDetail', 'maple', '2013-06-11 11:18:15', 'edit', '127.0.0.1'),
(628, 'purchaseRequest', 'maple', '2013-06-11 11:18:18', 'edit', '127.0.0.1'),
(629, 'purchaseDetail', 'maple', '2013-06-11 11:18:18', 'edit', '127.0.0.1'),
(630, 'purchaseDetail', 'maple', '2013-06-11 11:18:35', 'edit', '127.0.0.1'),
(631, 'itemInventory', 'maple', '2013-06-11 11:18:35', 'add', '127.0.0.1'),
(632, 'purchaseDetail', 'maple', '2013-06-11 11:21:56', 'edit', '127.0.0.1'),
(633, 'itemInventory', 'maple', '2013-06-11 11:21:56', 'edit', '127.0.0.1'),
(634, 'purchaseDetail', 'maple', '2013-06-11 11:35:58', 'edit', '127.0.0.1'),
(635, 'purchaseDetail', 'maple', '2013-06-11 11:36:08', 'edit', '127.0.0.1'),
(636, 'purchaseDetail', 'maple', '2013-06-11 11:36:35', 'edit', '127.0.0.1'),
(637, 'purchaseDetail', 'maple', '2013-06-11 11:36:57', 'edit', '127.0.0.1'),
(638, 'purchaseDetail', 'maple', '2013-06-11 11:38:03', 'edit', '127.0.0.1'),
(639, 'itemInventory', 'maple', '2013-06-11 11:38:03', 'add', '127.0.0.1'),
(640, 'purchaseDetail', 'maple', '2013-06-11 11:43:02', 'del', '127.0.0.1'),
(641, 'purchaseDetail', 'maple', '2013-06-12 08:57:18', 'add', '127.0.0.1'),
(642, 'purchaseDetail', 'maple', '2013-06-12 08:57:18', 'edit', '127.0.0.1'),
(643, 'purchaseRequest', 'maple', '2013-06-12 09:02:03', 'edit', '127.0.0.1'),
(644, 'purchaseDetail', 'maple', '2013-06-12 09:02:03', 'edit', '127.0.0.1'),
(645, 'purchaseDetail', 'maple', '2013-06-12 09:02:03', 'edit', '127.0.0.1'),
(646, 'purchaseDetail', 'maple', '2013-06-12 09:02:03', 'edit', '127.0.0.1'),
(647, 'purchaseRequest', 'maple', '2013-06-12 09:03:25', 'add', '127.0.0.1'),
(648, 'purchaseRequest', 'maple', '2013-06-12 09:10:46', 'edit', '127.0.0.1'),
(649, 'purchaseDetail', 'maple', '2013-06-12 09:10:46', 'edit', '127.0.0.1'),
(650, 'purchaseDetail', 'maple', '2013-06-12 09:10:46', 'edit', '127.0.0.1'),
(651, 'purchaseDetail', 'maple', '2013-06-12 09:10:46', 'edit', '127.0.0.1'),
(652, 'purchaseRequest', 'maple', '2013-06-12 09:10:57', 'edit', '127.0.0.1'),
(653, 'purchaseDetail', 'maple', '2013-06-12 09:10:57', 'edit', '127.0.0.1'),
(654, 'purchaseRequest', 'maple', '2013-06-12 09:11:10', 'edit', '127.0.0.1'),
(655, 'purchaseDetail', 'maple', '2013-06-12 09:11:10', 'edit', '127.0.0.1'),
(656, 'purchaseDetail', 'maple', '2013-06-12 09:11:10', 'edit', '127.0.0.1'),
(657, 'purchaseDetail', 'maple', '2013-06-12 09:11:10', 'edit', '127.0.0.1'),
(658, 'purchaseRequest', 'maple', '2013-06-12 09:11:21', 'edit', '127.0.0.1'),
(659, 'purchaseDetail', 'maple', '2013-06-12 09:11:21', 'edit', '127.0.0.1'),
(660, 'purchaseRequest', 'maple', '2013-06-12 09:11:33', 'edit', '127.0.0.1'),
(661, 'purchaseRequest', 'maple', '2013-06-12 09:13:22', 'del', '127.0.0.1'),
(662, 'purchaseDetail', 'maple', '2013-06-12 11:02:25', 'add', '127.0.0.1'),
(663, 'purchaseDetail', 'maple', '2013-06-12 11:02:25', 'edit', '127.0.0.1'),
(664, 'purchaseRequest', 'maple', '2013-06-12 11:02:30', 'add', '127.0.0.1'),
(665, 'purchaseDetail', 'maple', '2013-06-12 11:02:30', 'edit', '127.0.0.1'),
(666, 'purchaseRequest', 'maple', '2013-06-12 11:03:34', 'edit', '127.0.0.1'),
(667, 'purchaseDetail', 'maple', '2013-06-12 11:03:34', 'edit', '127.0.0.1'),
(668, 'item', 'maple', '2013-06-12 11:30:41', 'edit', '127.0.0.1'),
(669, 'purchaseDetail', 'maple', '2013-06-12 11:33:21', 'add', '127.0.0.1'),
(670, 'purchaseDetail', 'maple', '2013-06-12 11:33:21', 'edit', '127.0.0.1'),
(671, 'purchaseDetail', 'maple', '2013-06-12 11:33:21', 'edit', '127.0.0.1'),
(672, 'purchaseRequest', 'maple', '2013-06-12 11:33:25', 'edit', '127.0.0.1'),
(673, 'purchaseDetail', 'maple', '2013-06-12 11:33:25', 'edit', '127.0.0.1'),
(674, 'purchaseDetail', 'maple', '2013-06-12 11:33:25', 'edit', '127.0.0.1'),
(675, 'purchaseDetail', 'maple', '2013-06-12 11:33:28', 'edit', '127.0.0.1'),
(676, 'itemInventory', 'maple', '2013-06-12 11:33:28', 'add', '127.0.0.1'),
(677, 'purchaseRequest', 'maple', '2013-06-12 11:33:31', 'edit', '127.0.0.1'),
(678, 'purchaseDetail', 'maple', '2013-06-12 11:33:31', 'edit', '127.0.0.1'),
(679, 'purchaseDetail', 'maple', '2013-06-12 11:33:31', 'edit', '127.0.0.1'),
(680, 'purchaseDetail', 'maple', '2013-06-12 11:35:26', 'add', '127.0.0.1'),
(681, 'purchaseDetail', 'maple', '2013-06-12 11:35:26', 'edit', '127.0.0.1'),
(682, 'purchaseDetail', 'maple', '2013-06-12 11:35:26', 'edit', '127.0.0.1'),
(683, 'purchaseDetail', 'maple', '2013-06-12 11:35:26', 'edit', '127.0.0.1'),
(684, 'purchaseRequest', 'maple', '2013-06-12 11:35:28', 'edit', '127.0.0.1'),
(685, 'purchaseDetail', 'maple', '2013-06-12 11:35:29', 'edit', '127.0.0.1'),
(686, 'purchaseDetail', 'maple', '2013-06-12 11:35:29', 'edit', '127.0.0.1'),
(687, 'purchaseDetail', 'maple', '2013-06-12 11:35:29', 'edit', '127.0.0.1'),
(688, 'purchaseDetail', 'maple', '2013-06-12 11:35:33', 'edit', '127.0.0.1'),
(689, 'itemInventory', 'maple', '2013-06-12 11:35:33', 'add', '127.0.0.1'),
(690, 'purchaseRequest', 'maple', '2013-06-12 11:35:35', 'edit', '127.0.0.1'),
(691, 'purchaseDetail', 'maple', '2013-06-12 11:35:35', 'edit', '127.0.0.1'),
(692, 'purchaseDetail', 'maple', '2013-06-12 11:35:35', 'edit', '127.0.0.1'),
(693, 'purchaseDetail', 'maple', '2013-06-12 11:35:35', 'edit', '127.0.0.1'),
(694, 'purchaseDetail', 'maple', '2013-06-12 11:36:47', 'del', '127.0.0.1'),
(695, 'purchaseRequest', 'maple', '2013-06-12 11:37:28', 'del', '127.0.0.1'),
(696, 'purchaseDetail', 'maple', '2013-06-12 11:40:35', 'add', '127.0.0.1'),
(697, 'purchaseDetail', 'maple', '2013-06-12 11:40:35', 'edit', '127.0.0.1'),
(698, 'purchaseDetail', 'maple', '2013-06-12 11:40:35', 'edit', '127.0.0.1'),
(699, 'purchaseDetail', 'maple', '2013-06-12 11:40:35', 'edit', '127.0.0.1'),
(700, 'purchaseRequest', 'maple', '2013-06-12 11:40:36', 'edit', '127.0.0.1'),
(701, 'purchaseDetail', 'maple', '2013-06-12 11:40:36', 'edit', '127.0.0.1'),
(702, 'purchaseDetail', 'maple', '2013-06-12 11:40:36', 'edit', '127.0.0.1'),
(703, 'purchaseDetail', 'maple', '2013-06-12 11:40:36', 'edit', '127.0.0.1'),
(704, 'purchaseOrder', 'maple', '2013-06-12 11:41:23', 'edit', '127.0.0.1'),
(705, 'purchaseOrder', 'maple', '2013-06-12 11:49:46', 'add', '127.0.0.1'),
(706, 'purchaseDetail', 'maple', '2013-06-12 11:49:46', 'edit', '127.0.0.1');
INSERT INTO `modifyLog` (`modLogID`, `tableName`, `ManagerID`, `uDate`, `modify`, `ipAddress`) VALUES
(707, 'purchaseDetail', 'maple', '2013-06-12 11:49:46', 'edit', '127.0.0.1'),
(708, 'menuType', 'maple', '2013-06-12 05:00:26', 'edit', '127.0.0.1'),
(709, 'warehouse', 'ad', '2013-06-12 07:25:58', '', '127.0.0.1'),
(710, 'warehouse', 'ad', '2013-06-12 07:27:00', '', '127.0.0.1'),
(711, 'warehouse', 'ad', '2013-06-12 07:29:47', '', '127.0.0.1'),
(712, 'warehouse', 'ad', '2013-06-12 07:39:21', 'add', '127.0.0.1'),
(713, 'item', 'ad', '2013-06-12 07:43:31', '', '127.0.0.1'),
(714, 'item', 'ad', '2013-06-12 07:43:58', '', '127.0.0.1'),
(715, 'item', 'ad', '2013-06-12 07:52:15', 'add', '127.0.0.1'),
(716, 'item', 'ad', '2013-06-12 08:23:38', 'add', '127.0.0.1'),
(717, 'warehouse', 'ad', '2013-06-12 08:24:32', 'edit', '127.0.0.1'),
(718, 'item', 'ad', '2013-06-12 08:25:19', 'add', '127.0.0.1'),
(719, 'item', 'ad', '2013-06-12 08:27:04', 'add', '127.0.0.1'),
(720, 'item', 'ad', '2013-06-12 08:28:31', 'add', '127.0.0.1'),
(721, 'item', 'ad', '2013-06-12 08:28:39', 'add', '127.0.0.1'),
(722, 'item', 'ad', '2013-06-12 08:29:34', 'add', '127.0.0.1'),
(723, 'item', 'ad', '2013-06-12 09:00:20', 'edit', '127.0.0.1'),
(724, 'item', 'ad', '2013-06-12 09:02:20', 'edit', '127.0.0.1'),
(725, 'item', 'ad', '2013-06-12 09:03:02', 'edit', '127.0.0.1'),
(726, 'item', 'ad', '2013-06-12 09:05:19', 'edit', '127.0.0.1'),
(727, 'item', 'ad', '2013-06-12 09:06:39', 'edit', '127.0.0.1'),
(728, 'item', 'ad', '2013-06-12 09:09:01', 'edit', '127.0.0.1'),
(729, 'item', 'ad', '2013-06-12 09:09:38', 'edit', '127.0.0.1'),
(730, 'item', 'ad', '2013-06-12 09:09:38', 'edit', '127.0.0.1'),
(731, 'item', 'ad', '2013-06-12 09:14:08', 'edit', '127.0.0.1'),
(732, 'item', 'ad', '2013-06-12 09:15:05', 'edit', '127.0.0.1'),
(733, 'item', 'ad', '2013-06-12 09:16:37', 'add', '127.0.0.1'),
(734, 'item', 'ad', '2013-06-12 09:18:43', 'edit', '127.0.0.1'),
(735, 'item', 'ad', '2013-06-12 09:21:09', 'edit', '127.0.0.1'),
(736, 'warehouse', 'ad', '2013-06-12 09:26:49', 'del', '127.0.0.1'),
(737, 'materialRequest', 'maple', '2013-06-12 10:29:38', 'edit', '127.0.0.1'),
(738, 'materialRequest', 'maple', '2013-06-12 10:33:47', 'edit', '127.0.0.1'),
(739, 'purchaseOrder', 'maple', '2013-06-12 10:43:50', 'add', '127.0.0.1'),
(740, 'materialRequest', 'maple', '2013-06-12 10:45:56', 'add', '127.0.0.1'),
(741, 'materialRequest', 'maple', '2013-06-12 10:47:13', 'add', '127.0.0.1'),
(742, 'materialRequest', 'maple', '2013-06-12 10:47:57', 'add', '127.0.0.1'),
(743, 'materialRequest', 'maple', '2013-06-13 12:10:29', '', '127.0.0.1'),
(744, 'materialRequest', 'maple', '2013-06-13 12:15:06', 'edit', '127.0.0.1'),
(745, 'materialRequest', 'maple', '2013-06-13 12:15:17', 'edit', '127.0.0.1'),
(746, 'materialRequest', 'maple', '2013-06-13 12:16:07', 'edit', '127.0.0.1'),
(747, 'purchaseDetail', 'maple', '2013-06-13 12:31:20', 'add', '127.0.0.1'),
(748, 'purchaseDetail', 'maple', '2013-06-13 12:31:29', 'add', '127.0.0.1'),
(749, 'purchaseDetail', 'maple', '2013-06-13 12:34:43', 'add', '127.0.0.1'),
(750, 'purchaseDetail', 'maple', '2013-06-13 12:40:52', 'add', '127.0.0.1'),
(751, 'purchaseDetail', 'maple', '2013-06-13 12:41:00', 'add', '127.0.0.1'),
(752, 'requestDetail', 'maple', '2013-06-13 12:43:38', 'add', '127.0.0.1'),
(753, 'materialRequest', 'maple', '2013-06-13 12:45:49', 'add', '127.0.0.1'),
(754, 'requestDetail', 'maple', '2013-06-13 12:51:18', 'add', '127.0.0.1'),
(755, 'materialRequest', 'maple', '2013-06-13 12:55:29', 'add', '127.0.0.1'),
(756, 'purchaseDetail', 'maple', '2013-06-13 12:55:29', 'edit', '127.0.0.1'),
(757, 'materialRequest', 'maple', '2013-06-13 12:57:29', 'edit', '127.0.0.1'),
(758, 'requestDetail', 'maple', '2013-06-13 01:00:14', 'add', '127.0.0.1'),
(759, 'purchaseDetail', 'maple', '2013-06-13 01:00:14', 'edit', '127.0.0.1'),
(760, 'materialRequest', 'maple', '2013-06-13 01:00:23', 'edit', '127.0.0.1'),
(761, 'purchaseDetail', 'maple', '2013-06-13 01:00:23', 'edit', '127.0.0.1'),
(762, 'materialRequest', 'maple', '2013-06-13 01:13:26', 'edit', '127.0.0.1'),
(763, 'materialRequest', 'maple', '2013-06-13 01:14:34', 'edit', '127.0.0.1'),
(764, 'purchaseDetail', 'maple', '2013-06-13 01:14:34', 'edit', '127.0.0.1'),
(765, 'materialRequest', 'maple', '2013-06-13 01:14:53', 'edit', '127.0.0.1'),
(766, 'purchaseDetail', 'maple', '2013-06-13 01:14:53', 'edit', '127.0.0.1'),
(767, 'materialRequest', 'maple', '2013-06-13 01:23:35', 'edit', '127.0.0.1'),
(768, 'purchaseDetail', 'maple', '2013-06-13 01:23:35', 'edit', '127.0.0.1'),
(769, 'materialRequest', 'maple', '2013-06-13 01:23:45', 'edit', '127.0.0.1'),
(770, 'purchaseDetail', 'maple', '2013-06-13 01:23:45', 'edit', '127.0.0.1'),
(771, 'materialRequest', 'maple', '2013-06-13 01:23:56', 'edit', '127.0.0.1'),
(772, 'purchaseDetail', 'maple', '2013-06-13 01:23:56', 'edit', '127.0.0.1'),
(773, 'requestDetail', 'ad', '2013-06-13 10:03:21', 'add', '127.0.0.1'),
(774, 'purchaseDetail', 'ad', '2013-06-13 10:03:21', 'edit', '127.0.0.1'),
(775, 'purchaseDetail', 'ad', '2013-06-13 10:03:21', 'edit', '127.0.0.1'),
(776, 'requestDetail', 'ad', '2013-06-13 10:35:26', 'add', '127.0.0.1'),
(777, 'purchaseDetail', 'ad', '2013-06-13 10:35:26', 'edit', '127.0.0.1'),
(778, 'requestDetail', 'ad', '2013-06-13 10:35:33', 'add', '127.0.0.1'),
(779, 'purchaseDetail', 'ad', '2013-06-13 10:35:33', 'edit', '127.0.0.1'),
(780, 'purchaseDetail', 'ad', '2013-06-13 10:35:33', 'edit', '127.0.0.1'),
(781, 'requestDetail', 'ad', '2013-06-13 10:35:38', 'add', '127.0.0.1'),
(782, 'purchaseDetail', 'ad', '2013-06-13 10:35:38', 'edit', '127.0.0.1'),
(783, 'purchaseDetail', 'ad', '2013-06-13 10:35:38', 'edit', '127.0.0.1'),
(784, 'purchaseDetail', 'ad', '2013-06-13 10:35:38', 'edit', '127.0.0.1'),
(785, 'materialRequest', 'ad', '2013-06-13 10:36:27', 'add', '127.0.0.1'),
(786, 'purchaseDetail', 'ad', '2013-06-13 10:36:28', 'edit', '127.0.0.1'),
(787, 'purchaseDetail', 'ad', '2013-06-13 10:36:28', 'edit', '127.0.0.1'),
(788, 'purchaseDetail', 'ad', '2013-06-13 10:36:28', 'edit', '127.0.0.1'),
(789, 'purchaseDetail', 'ad', '2013-06-13 10:38:52', 'edit', '127.0.0.1'),
(790, 'purchaseDetail', 'ad', '2013-06-13 10:38:52', 'edit', '127.0.0.1'),
(791, 'purchaseDetail', 'ad', '2013-06-13 10:38:52', 'edit', '127.0.0.1'),
(792, 'purchaseDetail', 'ad', '2013-06-13 10:39:09', 'edit', '127.0.0.1'),
(793, 'purchaseDetail', 'ad', '2013-06-13 10:39:09', 'edit', '127.0.0.1'),
(794, 'purchaseDetail', 'ad', '2013-06-13 10:39:09', 'edit', '127.0.0.1'),
(795, 'purchaseDetail', 'ad', '2013-06-13 10:41:13', 'edit', '127.0.0.1'),
(796, 'purchaseDetail', 'ad', '2013-06-13 10:41:13', 'edit', '127.0.0.1'),
(797, 'purchaseDetail', 'ad', '2013-06-13 10:41:13', 'edit', '127.0.0.1'),
(798, 'requestDetail', 'ad', '2013-06-13 10:42:16', 'edit', '127.0.0.1'),
(799, 'requestDetail', 'ad', '2013-06-13 10:42:16', 'edit', '127.0.0.1'),
(800, 'requestDetail', 'ad', '2013-06-13 10:42:16', 'edit', '127.0.0.1'),
(801, 'requestDetail', 'ad', '2013-06-13 11:03:44', 'edit', '127.0.0.1'),
(802, 'materialRequest', 'ad', '2013-06-13 11:48:56', 'del', '127.0.0.1'),
(803, 'requestDetail', 'ad', '2013-06-13 11:49:33', 'add', '127.0.0.1'),
(804, 'requestDetail', 'ad', '2013-06-13 11:49:33', 'edit', '127.0.0.1'),
(805, 'requestDetail', 'ad', '2013-06-13 11:49:38', 'add', '127.0.0.1'),
(806, 'requestDetail', 'ad', '2013-06-13 11:49:38', 'edit', '127.0.0.1'),
(807, 'requestDetail', 'ad', '2013-06-13 11:49:38', 'edit', '127.0.0.1'),
(808, 'materialRequest', 'ad', '2013-06-13 11:49:44', 'add', '127.0.0.1'),
(809, 'requestDetail', 'ad', '2013-06-13 11:49:44', 'edit', '127.0.0.1'),
(810, 'requestDetail', 'ad', '2013-06-13 11:49:44', 'edit', '127.0.0.1'),
(811, 'materialRequest', 'ad', '2013-06-13 11:49:58', 'edit', '127.0.0.1'),
(812, 'requestDetail', 'ad', '2013-06-13 11:49:58', 'edit', '127.0.0.1'),
(813, 'requestDetail', 'ad', '2013-06-13 11:49:58', 'edit', '127.0.0.1'),
(814, 'materialRequest', 'ad', '2013-06-13 11:50:52', 'edit', '127.0.0.1'),
(815, 'materialRequest', 'ad', '2013-06-13 11:50:54', 'edit', '127.0.0.1'),
(816, 'requestDetail', 'ad', '2013-06-13 11:50:54', 'edit', '127.0.0.1'),
(817, 'requestDetail', 'ad', '2013-06-13 11:50:54', 'edit', '127.0.0.1'),
(818, 'requestDetail', 'ad', '2013-06-13 02:51:39', 'add', '127.0.0.1'),
(819, 'requestDetail', 'ad', '2013-06-13 02:51:39', 'edit', '127.0.0.1'),
(820, 'requestDetail', 'ad', '2013-06-13 02:51:46', 'add', '127.0.0.1'),
(821, 'requestDetail', 'ad', '2013-06-13 02:51:47', 'edit', '127.0.0.1'),
(822, 'requestDetail', 'ad', '2013-06-13 02:51:47', 'edit', '127.0.0.1'),
(823, 'materialRequest', 'ad', '2013-06-13 02:52:10', 'add', '127.0.0.1'),
(824, 'requestDetail', 'ad', '2013-06-13 02:52:10', 'edit', '127.0.0.1'),
(825, 'requestDetail', 'ad', '2013-06-13 02:52:10', 'edit', '127.0.0.1'),
(826, 'goodReturn', 'ad', '2013-06-13 03:04:37', 'add', '127.0.0.1'),
(827, 'goodReturn', 'ad', '2013-06-13 07:14:47', 'edit', '127.0.0.1'),
(828, 'returnDetail', 'ad', '2013-06-13 07:56:26', 'add', '127.0.0.1'),
(829, 'returnDetail', 'ad', '2013-06-13 07:59:34', 'add', '127.0.0.1'),
(830, 'returnDetail', 'ad', '2013-06-13 08:01:50', 'add', '127.0.0.1'),
(831, 'goodReturn', 'ad', '2013-06-13 08:05:53', 'edit', '127.0.0.1'),
(832, 'returnDetail', 'ad', '2013-06-13 08:06:39', 'add', '127.0.0.1'),
(833, 'returnDetail', 'ad', '2013-06-13 08:06:39', 'edit', '127.0.0.1'),
(834, 'returnDetail', 'ad', '2013-06-13 08:06:39', 'edit', '127.0.0.1'),
(835, 'goodReturn', 'ad', '2013-06-13 08:06:55', 'edit', '127.0.0.1'),
(836, 'returnDetail', 'ad', '2013-06-13 08:07:54', 'add', '127.0.0.1'),
(837, 'returnDetail', 'ad', '2013-06-13 08:07:54', 'edit', '127.0.0.1'),
(838, 'returnDetail', 'ad', '2013-06-13 08:07:54', 'edit', '127.0.0.1'),
(839, 'returnDetail', 'ad', '2013-06-13 08:07:54', 'edit', '127.0.0.1'),
(840, 'goodReturn', 'ad', '2013-06-13 08:07:58', 'edit', '127.0.0.1'),
(841, 'returnDetail', 'ad', '2013-06-13 08:09:25', 'add', '127.0.0.1'),
(842, 'returnDetail', 'ad', '2013-06-13 08:09:35', 'add', '127.0.0.1'),
(843, 'goodReturn', 'ad', '2013-06-13 08:09:41', 'edit', '127.0.0.1'),
(844, 'returnDetail', 'ad', '2013-06-13 08:09:41', 'edit', '127.0.0.1'),
(845, 'returnDetail', 'ad', '2013-06-13 08:09:41', 'edit', '127.0.0.1'),
(846, 'returnDetail', 'ad', '2013-06-13 08:11:02', 'add', '127.0.0.1'),
(847, 'returnDetail', 'ad', '2013-06-13 08:11:11', 'add', '127.0.0.1'),
(848, 'goodReturn', 'ad', '2013-06-13 08:11:12', 'edit', '127.0.0.1'),
(849, 'returnDetail', 'ad', '2013-06-13 08:11:12', 'edit', '127.0.0.1'),
(850, 'returnDetail', 'ad', '2013-06-13 08:11:12', 'edit', '127.0.0.1'),
(851, 'materialRequest', 'ad', '2013-06-13 08:16:44', 'del', '127.0.0.1'),
(852, 'returnDetail', 'ad', '2013-06-13 08:17:20', 'add', '127.0.0.1'),
(853, 'returnDetail', 'ad', '2013-06-13 08:17:30', 'add', '127.0.0.1'),
(854, 'goodReturn', 'ad', '2013-06-13 08:17:43', 'add', '127.0.0.1'),
(855, 'returnDetail', 'ad', '2013-06-13 08:17:43', 'edit', '127.0.0.1'),
(856, 'returnDetail', 'ad', '2013-06-13 08:17:43', 'edit', '127.0.0.1'),
(857, 'materialRequest', 'ad', '2013-06-13 08:18:05', 'del', '127.0.0.1'),
(858, 'materialRequest', 'ad', '2013-06-13 08:19:15', 'del', '127.0.0.1'),
(859, 'goodReturn', 'ad', '2013-06-13 08:19:53', 'del', '127.0.0.1'),
(860, 'requestDetail', 'ad', '2013-06-13 08:42:46', 'edit', '127.0.0.1'),
(861, 'returnDetail', 'ad', '2013-06-13 08:43:06', 'edit', '127.0.0.1'),
(862, 'returnDetail', 'ad', '2013-06-13 08:44:20', 'edit', '127.0.0.1'),
(863, 'requestDetail', 'ad', '2013-06-13 08:44:31', 'edit', '127.0.0.1'),
(864, 'requestDetail', 'ad', '2013-06-13 08:44:32', 'edit', '127.0.0.1'),
(865, 'itemHandle', 'ad', '2013-06-14 12:06:01', 'add', '127.0.0.1'),
(866, 'itemHandle', 'ad', '2013-06-14 12:07:18', 'add', '127.0.0.1'),
(867, 'itemHandle', 'ad', '2013-06-14 12:12:02', 'add', '127.0.0.1'),
(868, 'itemHandle', 'ad', '2013-06-14 12:13:52', 'add', '127.0.0.1'),
(869, 'itemHandle', 'ad', '2013-06-14 12:14:17', 'add', '127.0.0.1'),
(870, 'itemHandle', 'ad', '2013-06-14 12:18:24', 'add', '127.0.0.1'),
(871, 'itemHandle', 'ad', '2013-06-14 01:08:01', 'add', '127.0.0.1'),
(872, 'itemHandle', 'ad', '2013-06-14 01:08:19', 'add', '127.0.0.1'),
(873, 'itemHandle', 'ad', '2013-06-14 01:08:40', 'add', '127.0.0.1'),
(874, 'itemHandle', 'ad', '2013-06-14 01:13:10', '', '127.0.0.1'),
(875, 'itemHandle', 'ad', '2013-06-14 01:13:23', '', '127.0.0.1'),
(876, 'itemHandle', 'ad', '2013-06-14 01:16:14', 'edit', '127.0.0.1'),
(877, 'itemHandle', 'ad', '2013-06-14 01:38:11', 'edit', '127.0.0.1'),
(878, 'itemHandle', 'ad', '2013-06-14 01:38:40', 'edit', '127.0.0.1'),
(879, 'itemHandle', 'ad', '2013-06-14 01:38:50', 'edit', '127.0.0.1'),
(880, 'itemHandle', 'ad', '2013-06-14 01:41:16', 'edit', '127.0.0.1'),
(881, 'itemHandle', 'ad', '2013-06-14 01:41:29', 'edit', '127.0.0.1'),
(882, 'itemHandle', 'ad', '2013-06-14 01:41:32', 'edit', '127.0.0.1'),
(883, 'itemHandle', 'ad', '2013-06-14 01:41:39', 'edit', '127.0.0.1'),
(884, 'handleDetail', 'ad', '2013-06-14 03:51:05', 'add', '127.0.0.1'),
(885, 'handleDetail', 'ad', '2013-06-14 03:52:55', 'add', '127.0.0.1'),
(886, 'handleDetail', 'ad', '2013-06-14 03:58:45', 'add', '127.0.0.1'),
(887, 'itemHandle', 'ad', '2013-06-14 03:58:52', 'add', '127.0.0.1'),
(888, 'handleDetail', 'ad', '2013-06-14 04:16:04', 'add', '127.0.0.1'),
(889, 'handleDetail', 'ad', '2013-06-14 04:18:05', 'add', '127.0.0.1'),
(890, 'handleDetail', 'ad', '2013-06-14 04:19:30', 'add', '127.0.0.1'),
(891, 'handleDetail', 'ad', '2013-06-14 04:20:16', 'add', '127.0.0.1'),
(892, 'handleDetail', 'ad', '2013-06-14 04:21:15', 'add', '127.0.0.1'),
(893, 'handleDetail', 'ad', '2013-06-14 04:22:48', 'add', '127.0.0.1'),
(894, 'itemHandle', 'ad', '2013-06-14 04:26:47', 'edit', '127.0.0.1'),
(895, 'handleDetail', 'ad', '2013-06-14 04:27:04', 'add', '127.0.0.1'),
(896, 'itemHandle', 'ad', '2013-06-14 04:27:12', 'edit', '127.0.0.1'),
(897, 'itemHandle', 'ad', '2013-06-14 04:30:23', 'edit', '127.0.0.1'),
(898, 'itemHandle', 'ad', '2013-06-14 04:31:38', 'edit', '127.0.0.1'),
(899, 'requestDetail', 'ad', '2013-06-14 04:31:39', 'edit', '127.0.0.1'),
(900, 'requestDetail', 'ad', '2013-06-14 04:31:39', 'edit', '127.0.0.1'),
(901, 'itemHandle', 'ad', '2013-06-14 04:32:28', 'edit', '127.0.0.1'),
(902, 'requestDetail', 'ad', '2013-06-14 04:32:28', 'edit', '127.0.0.1'),
(903, 'requestDetail', 'ad', '2013-06-14 04:32:28', 'edit', '127.0.0.1'),
(904, 'itemHandle', 'ad', '2013-06-14 04:32:53', 'edit', '127.0.0.1'),
(905, 'requestDetail', 'ad', '2013-06-14 04:32:53', 'edit', '127.0.0.1'),
(906, 'requestDetail', 'ad', '2013-06-14 04:32:53', 'edit', '127.0.0.1'),
(907, 'itemHandle', 'ad', '2013-06-14 04:33:36', 'edit', '127.0.0.1'),
(908, 'requestDetail', 'ad', '2013-06-14 04:33:36', 'edit', '127.0.0.1'),
(909, 'requestDetail', 'ad', '2013-06-14 04:33:37', 'edit', '127.0.0.1'),
(910, 'itemHandle', 'ad', '2013-06-14 04:34:14', 'edit', '127.0.0.1'),
(911, 'requestDetail', 'ad', '2013-06-14 04:34:14', 'edit', '127.0.0.1'),
(912, 'requestDetail', 'ad', '2013-06-14 04:34:14', 'edit', '127.0.0.1'),
(913, 'itemHandle', 'ad', '2013-06-14 04:35:20', 'edit', '127.0.0.1'),
(914, 'handleDetail', 'ad', '2013-06-14 04:35:20', 'edit', '127.0.0.1'),
(915, 'handleDetail', 'ad', '2013-06-14 04:35:20', 'edit', '127.0.0.1'),
(916, 'handleDetail', 'ad', '2013-06-14 04:38:51', 'add', '127.0.0.1'),
(917, 'handleDetail', 'ad', '2013-06-14 04:38:51', 'edit', '127.0.0.1'),
(918, 'handleDetail', 'ad', '2013-06-14 04:38:51', 'edit', '127.0.0.1'),
(919, 'handleDetail', 'ad', '2013-06-14 04:38:51', 'edit', '127.0.0.1'),
(920, 'handleDetail', 'ad', '2013-06-14 04:39:56', 'add', '127.0.0.1'),
(921, 'handleDetail', 'ad', '2013-06-14 04:39:56', 'edit', '127.0.0.1'),
(922, 'handleDetail', 'ad', '2013-06-14 04:39:56', 'edit', '127.0.0.1'),
(923, 'handleDetail', 'ad', '2013-06-14 04:39:56', 'edit', '127.0.0.1'),
(924, 'handleDetail', 'ad', '2013-06-14 04:39:56', 'edit', '127.0.0.1'),
(925, 'handleDetail', 'ad', '2013-06-14 04:40:50', 'add', '127.0.0.1'),
(926, 'handleDetail', 'ad', '2013-06-14 04:40:50', 'edit', '127.0.0.1'),
(927, 'handleDetail', 'ad', '2013-06-14 04:40:50', 'edit', '127.0.0.1'),
(928, 'handleDetail', 'ad', '2013-06-14 04:40:50', 'edit', '127.0.0.1'),
(929, 'handleDetail', 'ad', '2013-06-14 04:40:50', 'edit', '127.0.0.1'),
(930, 'handleDetail', 'ad', '2013-06-14 04:40:50', 'edit', '127.0.0.1'),
(931, 'handleDetail', 'ad', '2013-06-14 04:41:32', 'add', '127.0.0.1'),
(932, 'handleDetail', 'ad', '2013-06-14 04:41:32', 'edit', '127.0.0.1'),
(933, 'handleDetail', 'ad', '2013-06-14 04:41:33', 'edit', '127.0.0.1'),
(934, 'handleDetail', 'ad', '2013-06-14 04:41:33', 'edit', '127.0.0.1'),
(935, 'handleDetail', 'ad', '2013-06-14 04:41:33', 'edit', '127.0.0.1'),
(936, 'handleDetail', 'ad', '2013-06-14 04:41:33', 'edit', '127.0.0.1'),
(937, 'handleDetail', 'ad', '2013-06-14 04:41:33', 'edit', '127.0.0.1'),
(938, 'handleDetail', 'ad', '2013-06-14 04:42:18', 'add', '127.0.0.1'),
(939, 'handleDetail', 'ad', '2013-06-14 04:42:18', 'edit', '127.0.0.1'),
(940, 'handleDetail', 'ad', '2013-06-14 04:42:18', 'edit', '127.0.0.1'),
(941, 'handleDetail', 'ad', '2013-06-14 04:42:18', 'edit', '127.0.0.1'),
(942, 'handleDetail', 'ad', '2013-06-14 04:42:18', 'edit', '127.0.0.1'),
(943, 'handleDetail', 'ad', '2013-06-14 04:42:18', 'edit', '127.0.0.1'),
(944, 'handleDetail', 'ad', '2013-06-14 04:42:18', 'edit', '127.0.0.1'),
(945, 'handleDetail', 'ad', '2013-06-14 04:42:18', 'edit', '127.0.0.1'),
(946, 'handleDetail', 'ad', '2013-06-14 04:45:20', 'add', '127.0.0.1'),
(947, 'handleDetail', 'ad', '2013-06-14 04:45:20', 'edit', '127.0.0.1'),
(948, 'handleDetail', 'ad', '2013-06-14 04:46:58', 'add', '127.0.0.1'),
(949, 'handleDetail', 'ad', '2013-06-14 04:46:58', 'edit', '127.0.0.1'),
(950, 'itemHandle', 'ad', '2013-06-14 04:47:02', 'add', '127.0.0.1'),
(951, 'handleDetail', 'ad', '2013-06-14 04:47:02', 'edit', '127.0.0.1'),
(952, 'handleDetail', 'ad', '2013-06-14 04:54:19', 'add', '127.0.0.1'),
(953, 'handleDetail', 'ad', '2013-06-14 04:54:19', 'edit', '127.0.0.1'),
(954, 'itemHandle', 'ad', '2013-06-14 04:54:22', 'add', '127.0.0.1'),
(955, 'handleDetail', 'ad', '2013-06-14 04:54:22', 'edit', '127.0.0.1'),
(956, 'handleDetail', 'ad', '2013-06-14 04:56:03', 'add', '127.0.0.1'),
(957, 'handleDetail', 'ad', '2013-06-14 04:56:03', 'edit', '127.0.0.1'),
(958, 'handleDetail', 'ad', '2013-06-14 04:56:03', 'edit', '127.0.0.1'),
(959, 'handleDetail', 'ad', '2013-06-14 05:00:32', 'add', '127.0.0.1'),
(960, 'handleDetail', 'ad', '2013-06-14 05:00:32', 'edit', '127.0.0.1'),
(961, 'handleDetail', 'ad', '2013-06-14 05:00:32', 'edit', '127.0.0.1'),
(962, 'handleDetail', 'ad', '2013-06-14 05:00:32', 'edit', '127.0.0.1'),
(963, 'handleDetail', 'ad', '2013-06-14 05:06:17', 'add', '127.0.0.1'),
(964, 'handleDetail', 'ad', '2013-06-14 05:06:17', 'edit', '127.0.0.1'),
(965, 'handleDetail', 'ad', '2013-06-14 05:06:17', 'edit', '127.0.0.1'),
(966, 'handleDetail', 'ad', '2013-06-14 05:06:58', 'add', '127.0.0.1'),
(967, 'handleDetail', 'ad', '2013-06-14 05:06:59', 'edit', '127.0.0.1'),
(968, 'handleDetail', 'ad', '2013-06-14 05:06:59', 'edit', '127.0.0.1'),
(969, 'handleDetail', 'ad', '2013-06-14 05:06:59', 'edit', '127.0.0.1'),
(970, 'handleDetail', 'ad', '2013-06-14 05:06:59', 'edit', '127.0.0.1'),
(971, 'handleDetail', 'ad', '2013-06-14 05:07:36', 'add', '127.0.0.1'),
(972, 'handleDetail', 'ad', '2013-06-14 05:07:36', 'edit', '127.0.0.1'),
(973, 'handleDetail', 'ad', '2013-06-14 05:07:36', 'edit', '127.0.0.1'),
(974, 'handleDetail', 'ad', '2013-06-14 05:08:13', 'add', '127.0.0.1'),
(975, 'handleDetail', 'ad', '2013-06-14 05:08:13', 'edit', '127.0.0.1'),
(976, 'handleDetail', 'ad', '2013-06-14 05:08:13', 'edit', '127.0.0.1'),
(977, 'handleDetail', 'ad', '2013-06-14 05:08:13', 'edit', '127.0.0.1'),
(978, 'itemHandle', 'ad', '2013-06-14 05:08:29', 'edit', '127.0.0.1'),
(979, 'itemHandle', 'ad', '2013-06-14 05:08:31', 'edit', '127.0.0.1'),
(980, 'handleDetail', 'ad', '2013-06-14 05:08:31', 'edit', '127.0.0.1'),
(981, 'handleDetail', 'ad', '2013-06-14 05:08:31', 'edit', '127.0.0.1'),
(982, 'handleDetail', 'ad', '2013-06-14 05:23:06', 'add', '127.0.0.1'),
(983, 'handleDetail', 'ad', '2013-06-14 05:23:06', 'edit', '127.0.0.1'),
(984, 'handleDetail', 'ad', '2013-06-14 05:23:06', 'edit', '127.0.0.1'),
(985, 'handleDetail', 'ad', '2013-06-14 05:23:06', 'edit', '127.0.0.1'),
(986, 'handleDetail', 'ad', '2013-06-14 05:24:35', 'add', '127.0.0.1'),
(987, 'handleDetail', 'ad', '2013-06-14 05:24:35', 'edit', '127.0.0.1'),
(988, 'handleDetail', 'ad', '2013-06-14 05:24:35', 'edit', '127.0.0.1'),
(989, 'handleDetail', 'ad', '2013-06-14 05:24:35', 'edit', '127.0.0.1'),
(990, 'handleDetail', 'ad', '2013-06-14 05:24:35', 'edit', '127.0.0.1'),
(991, 'handleDetail', 'ad', '2013-06-14 05:45:12', 'edit', '127.0.0.1'),
(992, 'handleDetail', 'ad', '2013-06-14 05:45:22', 'edit', '127.0.0.1'),
(993, 'handleDetail', 'ad', '2013-06-14 05:51:12', 'edit', '127.0.0.1'),
(994, 'handleDetail', 'ad', '2013-06-14 05:51:24', 'edit', '127.0.0.1'),
(995, 'handleDetail', 'ad', '2013-06-14 05:51:26', 'edit', '127.0.0.1'),
(996, 'returnDetail', 'ad', '2013-06-17 03:40:31', 'edit', '127.0.0.1'),
(997, 'itemInventory', 'ad', '2013-06-17 03:40:31', 'edit', '127.0.0.1'),
(998, 'returnDetail', 'ad', '2013-06-17 03:43:00', 'edit', '127.0.0.1'),
(999, 'returnDetail', 'ad', '2013-06-17 03:43:34', 'edit', '127.0.0.1'),
(1000, 'returnDetail', 'ad', '2013-06-17 03:45:21', 'edit', '127.0.0.1'),
(1001, 'itemInventory', 'ad', '2013-06-17 03:45:21', 'edit', '127.0.0.1'),
(1002, 'returnDetail', 'ad', '2013-06-17 03:46:00', 'edit', '127.0.0.1'),
(1003, 'itemInventory', 'ad', '2013-06-17 03:46:00', 'edit', '127.0.0.1'),
(1004, 'returnDetail', 'ad', '2013-06-17 03:47:03', 'edit', '127.0.0.1'),
(1005, 'itemInventory', 'ad', '2013-06-17 03:47:03', 'edit', '127.0.0.1'),
(1006, 'returnDetail', 'ad', '2013-06-17 03:48:08', 'edit', '127.0.0.1'),
(1007, 'itemInventory', 'ad', '2013-06-17 03:48:08', 'edit', '127.0.0.1'),
(1008, 'returnDetail', 'ad', '2013-06-17 03:48:13', 'edit', '127.0.0.1'),
(1009, 'itemInventory', 'ad', '2013-06-17 03:48:13', 'edit', '127.0.0.1'),
(1010, 'returnDetail', 'ad', '2013-06-17 03:48:19', 'edit', '127.0.0.1'),
(1011, 'itemInventory', 'ad', '2013-06-17 03:48:19', 'edit', '127.0.0.1'),
(1012, 'returnDetail', 'ad', '2013-06-17 03:49:48', 'edit', '127.0.0.1'),
(1013, 'itemInventory', 'ad', '2013-06-17 03:49:48', 'edit', '127.0.0.1'),
(1014, 'returnDetail', 'ad', '2013-06-17 03:50:15', 'edit', '127.0.0.1'),
(1015, 'itemInventory', 'ad', '2013-06-17 03:50:15', 'edit', '127.0.0.1'),
(1016, 'returnDetail', 'ad', '2013-06-17 03:53:13', 'edit', '127.0.0.1'),
(1017, 'itemInventory', 'ad', '2013-06-17 03:53:13', 'edit', '127.0.0.1'),
(1018, 'returnDetail', 'ad', '2013-06-17 03:53:15', 'edit', '127.0.0.1'),
(1019, 'itemInventory', 'ad', '2013-06-17 03:53:15', 'edit', '127.0.0.1'),
(1020, 'returnDetail', 'ad', '2013-06-17 03:54:26', 'edit', '127.0.0.1'),
(1021, 'itemInventory', 'ad', '2013-06-17 03:54:26', 'edit', '127.0.0.1'),
(1022, 'materialRequest', 'ad', '2013-06-17 03:56:01', 'edit', '127.0.0.1'),
(1023, 'materialRequest', 'ad', '2013-06-17 03:56:02', 'edit', '127.0.0.1'),
(1024, 'requestDetail', 'ad', '2013-06-17 03:56:02', 'edit', '127.0.0.1'),
(1025, 'requestDetail', 'ad', '2013-06-17 03:56:02', 'edit', '127.0.0.1'),
(1026, 'requestDetail', 'ad', '2013-06-17 04:18:18', 'add', '127.0.0.1'),
(1027, 'requestDetail', 'ad', '2013-06-17 04:21:59', 'add', '127.0.0.1'),
(1028, 'requestDetail', 'ad', '2013-06-17 04:27:17', 'del', '127.0.0.1'),
(1029, 'requestDetail', 'ad', '2013-06-17 04:27:21', 'del', '127.0.0.1'),
(1030, 'purchaseRequest', 'ad', '2013-06-17 05:01:57', 'del', '127.0.0.1'),
(1031, 'purchaseDetail', 'ad', '2013-06-17 05:21:19', 'edit', '127.0.0.1'),
(1032, 'purchaseDetail', 'ad', '2013-06-17 05:21:28', 'edit', '127.0.0.1'),
(1033, 'purchaseDetail', 'ad', '2013-06-17 05:21:28', 'edit', '127.0.0.1'),
(1034, 'purchaseDetail', 'ad', '2013-06-17 05:23:58', 'edit', '127.0.0.1'),
(1035, 'purchaseDetail', 'ad', '2013-06-17 05:24:00', 'edit', '127.0.0.1'),
(1036, 'menu', 'ad', '2013-06-19 10:37:59', 'edit', '127.0.0.1'),
(1037, 'menu', 'ad', '2013-06-19 10:38:07', 'edit', '127.0.0.1'),
(1038, 'menu', 'ad', '2013-06-19 10:38:15', 'edit', '127.0.0.1'),
(1039, 'menu', 'ad', '2013-06-19 10:39:43', 'add', '127.0.0.1'),
(1040, 'menu', 'ad', '2013-06-19 10:39:53', 'edit', '127.0.0.1'),
(1041, 'menu', 'ad', '2013-06-19 10:40:04', 'edit', '127.0.0.1'),
(1042, 'menu', 'ad', '2013-06-19 10:40:18', 'edit', '127.0.0.1'),
(1043, 'recruitment', 'ad', '2013-06-21 03:28:53', 'add', '127.0.0.1'),
(1044, 'recruitment', 'ad', '2013-06-21 03:28:53', 'add', '127.0.0.1'),
(1045, 'employee', 'ad', '2013-06-21 04:09:22', 'add', '127.0.0.1'),
(1046, 'recruitment', 'ad', '2013-06-21 04:09:22', 'add', '127.0.0.1'),
(1047, 'employee', 'ad', '2013-06-21 04:15:08', 'add', '127.0.0.1'),
(1048, 'recruitment', 'ad', '2013-06-21 04:15:08', 'add', '127.0.0.1'),
(1049, 'employee', 'ad', '2013-06-21 05:22:08', 'edit', '127.0.0.1'),
(1050, 'recruitment', 'ad', '2013-06-21 05:22:08', 'edit', '127.0.0.1'),
(1051, 'employee', 'ad', '2013-06-21 05:23:08', 'edit', '127.0.0.1'),
(1052, 'recruitment', 'ad', '2013-06-21 05:23:09', 'edit', '127.0.0.1'),
(1053, 'employee', 'ad', '2013-06-21 05:23:55', 'edit', '127.0.0.1'),
(1054, 'recruitment', 'ad', '2013-06-21 05:23:55', 'edit', '127.0.0.1'),
(1055, 'employee', 'ad', '2013-06-21 05:25:21', 'edit', '127.0.0.1'),
(1056, 'recruitment', 'ad', '2013-06-21 05:25:21', 'edit', '127.0.0.1'),
(1057, 'employee', 'ad', '2013-06-21 05:26:15', 'edit', '127.0.0.1'),
(1058, 'recruitment', 'ad', '2013-06-21 05:26:15', 'edit', '127.0.0.1'),
(1059, 'employee', 'ad', '2013-06-21 05:26:41', 'edit', '127.0.0.1'),
(1060, 'recruitment', 'ad', '2013-06-21 05:26:42', 'edit', '127.0.0.1'),
(1061, 'employee', 'ad', '2013-06-21 05:32:25', 'edit', '127.0.0.1'),
(1062, 'recruitment', 'ad', '2013-06-21 05:32:26', 'edit', '127.0.0.1'),
(1063, 'employee', 'ad', '2013-06-21 05:32:59', 'edit', '127.0.0.1'),
(1064, 'recruitment', 'ad', '2013-06-21 05:32:59', 'edit', '127.0.0.1'),
(1065, 'employee', 'ad', '2013-06-21 05:35:09', 'edit', '127.0.0.1'),
(1066, 'recruitment', 'ad', '2013-06-21 05:35:09', 'edit', '127.0.0.1'),
(1067, 'employee', 'ad', '2013-06-21 05:37:32', 'edit', '127.0.0.1'),
(1068, 'recruitment', 'ad', '2013-06-21 05:37:32', 'edit', '127.0.0.1'),
(1069, 'employee', 'ad', '2013-06-21 05:38:29', 'edit', '127.0.0.1'),
(1070, 'recruitment', 'ad', '2013-06-21 05:38:30', 'edit', '127.0.0.1'),
(1071, 'employee', 'ad', '2013-06-21 05:39:54', 'edit', '127.0.0.1'),
(1072, 'recruitment', 'ad', '2013-06-21 05:39:54', 'edit', '127.0.0.1'),
(1073, 'employee', 'ad', '2013-06-21 05:41:22', 'edit', '127.0.0.1'),
(1074, 'recruitment', 'ad', '2013-06-21 05:41:22', 'edit', '127.0.0.1'),
(1075, 'employee', 'ad', '2013-06-21 05:43:03', 'edit', '127.0.0.1'),
(1076, 'recruitment', 'ad', '2013-06-21 05:43:03', 'edit', '127.0.0.1'),
(1077, 'employee', 'ad', '2013-06-21 05:43:46', 'edit', '127.0.0.1'),
(1078, 'recruitment', 'ad', '2013-06-21 05:43:46', 'edit', '127.0.0.1'),
(1079, 'employee', 'ad', '2013-06-21 05:44:47', 'edit', '127.0.0.1'),
(1080, 'recruitment', 'ad', '2013-06-21 05:44:47', 'edit', '127.0.0.1'),
(1081, 'employee', 'ad', '2013-06-21 05:57:47', 'edit', '127.0.0.1'),
(1082, 'recruitment', 'ad', '2013-06-21 05:57:47', 'edit', '127.0.0.1'),
(1083, 'employee', 'ad', '2013-06-21 06:04:08', 'edit', '127.0.0.1'),
(1084, 'recruitment', 'ad', '2013-06-21 06:04:08', 'edit', '127.0.0.1'),
(1085, 'employee', 'ad', '2013-06-21 06:21:53', 'edit', '127.0.0.1'),
(1086, 'recruitment', 'ad', '2013-06-21 06:21:53', 'edit', '127.0.0.1'),
(1087, 'employee', 'ad', '2013-06-21 06:31:47', 'edit', '127.0.0.1'),
(1088, 'recruitment', 'ad', '2013-06-21 06:31:47', 'edit', '127.0.0.1'),
(1089, 'employee', 'ad', '2013-06-23 01:08:24', 'edit', '127.0.0.1'),
(1090, 'employee', 'ad', '2013-06-23 01:09:52', 'edit', '127.0.0.1'),
(1091, 'employee', 'ad', '2013-06-23 01:11:37', 'edit', '127.0.0.1'),
(1092, 'employee', 'ad', '2013-06-23 01:11:49', 'edit', '127.0.0.1'),
(1093, 'employee', 'ad', '2013-06-23 01:21:19', 'edit', '127.0.0.1'),
(1094, 'recruitment', 'ad', '2013-06-23 01:21:19', 'edit', '127.0.0.1'),
(1095, 'employee', 'ad', '2013-06-23 01:23:23', 'edit', '127.0.0.1'),
(1096, 'recruitment', 'ad', '2013-06-23 01:23:23', 'edit', '127.0.0.1'),
(1097, 'employee', 'ad', '2013-06-23 01:25:12', 'edit', '127.0.0.1'),
(1098, 'recruitment', 'ad', '2013-06-23 01:25:12', 'edit', '127.0.0.1'),
(1099, 'employee', 'ad', '2013-06-23 01:26:51', 'edit', '127.0.0.1'),
(1100, 'recruitment', 'ad', '2013-06-23 01:26:51', 'edit', '127.0.0.1'),
(1101, 'employee', 'ad', '2013-06-23 01:29:39', 'edit', '127.0.0.1'),
(1102, 'recruitment', 'ad', '2013-06-23 01:29:39', 'edit', '127.0.0.1'),
(1103, 'employee', 'ad', '2013-06-23 01:31:52', 'edit', '127.0.0.1'),
(1104, 'recruitment', 'ad', '2013-06-23 01:31:52', 'edit', '127.0.0.1'),
(1105, 'employee', 'ad', '2013-06-23 01:33:12', 'edit', '127.0.0.1'),
(1106, 'recruitment', 'ad', '2013-06-23 01:33:12', 'edit', '127.0.0.1'),
(1107, 'employee', 'ad', '2013-06-23 01:34:34', 'edit', '127.0.0.1'),
(1108, 'recruitment', 'ad', '2013-06-23 01:34:34', 'edit', '127.0.0.1'),
(1109, 'menuType', 'ad', '2013-06-24 10:36:34', 'edit', '127.0.0.1'),
(1110, 'menu', 'ad', '2013-06-24 10:36:51', 'edit', '127.0.0.1'),
(1111, 'groupPermission', 'ad', '2013-06-24 01:49:58', 'edit', '127.0.0.1'),
(1112, 'groupPermission', 'ad', '2013-06-24 01:52:24', 'edit', '127.0.0.1'),
(1113, 'groupPermission', 'ad', '2013-06-24 01:52:50', 'edit', '127.0.0.1'),
(1114, 'groupPermission', 'ad', '2013-06-24 01:53:04', 'edit', '127.0.0.1'),
(1115, 'groupPermission', 'ad', '2013-06-24 01:53:32', 'edit', '127.0.0.1'),
(1116, 'employee', 'ad', '2013-06-24 02:04:47', 'del', '127.0.0.1'),
(1117, 'employee', 'ad', '2013-06-24 02:20:11', 'edit', '127.0.0.1'),
(1118, 'employee', 'ad', '2013-06-24 02:20:36', 'edit', '127.0.0.1'),
(1119, 'menuType', 'ad', '2013-06-24 02:30:33', 'edit', '127.0.0.1'),
(1120, 'employee', 'ad', '2013-06-24 05:07:59', 'edit', '127.0.0.1'),
(1121, 'employee', 'ad', '2013-06-25 09:38:21', 'edit', '127.0.0.1'),
(1122, 'employee', 'ad', '2013-06-25 09:38:48', 'edit', '127.0.0.1'),
(1123, 'employee', 'ad', '2013-06-25 09:40:14', 'edit', '127.0.0.1'),
(1124, 'employee', 'ad', '2013-06-25 09:49:49', 'edit', '127.0.0.1'),
(1125, 'menuType', 'ad', '2013-06-25 09:58:57', 'edit', '127.0.0.1'),
(1126, 'groupPermission', 'ad', '2013-06-25 09:59:22', 'edit', '127.0.0.1'),
(1127, 'groupPermission', 'ad', '2013-06-25 10:08:05', 'edit', '127.0.0.1'),
(1128, 'groupPermission', 'ad', '2013-06-25 10:08:20', 'edit', '127.0.0.1'),
(1129, 'groupPermission', 'ad', '2013-06-25 10:09:37', 'edit', '127.0.0.1'),
(1130, 'groupPermission', 'ad', '2013-06-25 10:51:57', 'edit', '127.0.0.1'),
(1131, 'groupPermission', 'ad', '2013-06-25 10:56:51', 'edit', '127.0.0.1'),
(1132, 'employee', 'ad', '2013-06-25 10:58:57', 'edit', '127.0.0.1'),
(1133, 'groupPermission', 'ad', '2013-06-25 11:18:35', 'edit', '127.0.0.1'),
(1134, 'groupPermission', 'ad', '2013-06-25 11:26:00', 'edit', '127.0.0.1'),
(1135, 'groupPermission', 'ad', '2013-06-25 11:31:00', 'edit', '127.0.0.1'),
(1136, 'groupPermission', 'ad', '2013-06-25 11:31:13', 'edit', '127.0.0.1'),
(1137, 'groupPermission', 'ad', '2013-06-25 02:20:21', 'edit', '127.0.0.1'),
(1138, 'groupPermission', 'ad', '2013-06-25 02:20:45', 'edit', '127.0.0.1'),
(1139, 'groupPermission', 'ad', '2013-06-25 02:21:00', 'edit', '127.0.0.1'),
(1140, 'employee', 'ad', '2013-06-25 02:46:53', 'edit', '127.0.0.1'),
(1141, 'groupPermission', 'ad', '2013-06-25 03:15:39', 'edit', '127.0.0.1'),
(1142, 'groupPermission', 'ad', '2013-06-25 04:41:56', 'edit', '127.0.0.1'),
(1143, 'groupPermission', 'ad', '2013-06-25 04:42:07', 'edit', '127.0.0.1'),
(1144, 'employee', 'ad', '2013-06-25 04:42:55', 'edit', '127.0.0.1'),
(1145, 'menuType', 'ad', '2013-06-25 05:29:55', 'edit', '127.0.0.1'),
(1146, 'purchaseOrder', 'ad', '2013-06-26 10:05:28', 'edit', '127.0.0.1'),
(1147, 'purchaseDetail', 'ad', '2013-06-26 10:05:29', 'edit', '127.0.0.1'),
(1148, 'purchaseDetail', 'ad', '2013-06-26 10:49:39', 'edit', '127.0.0.1'),
(1149, 'purchaseDetail', 'ad', '2013-06-26 10:50:54', 'edit', '127.0.0.1'),
(1150, 'purchaseDetail', 'ad', '2013-06-26 10:51:57', 'edit', '127.0.0.1'),
(1151, 'purchaseDetail', 'ad', '2013-06-26 10:54:19', 'edit', '127.0.0.1'),
(1152, 'purchaseDetail', 'ad', '2013-06-26 10:55:14', 'edit', '127.0.0.1'),
(1153, 'purchaseDetail', 'ad', '2013-06-26 10:55:26', 'edit', '127.0.0.1'),
(1154, 'purchaseDetail', 'ad', '2013-06-26 10:55:26', 'edit', '127.0.0.1'),
(1155, 'purchaseDetail', 'ad', '2013-06-26 10:55:26', 'edit', '127.0.0.1'),
(1156, 'purchaseDetail', 'ad', '2013-06-26 10:55:27', 'edit', '127.0.0.1'),
(1157, 'purchaseDetail', 'ad', '2013-06-26 10:55:27', 'edit', '127.0.0.1'),
(1158, 'purchaseDetail', 'ad', '2013-06-26 10:55:27', 'edit', '127.0.0.1'),
(1159, 'purchaseDetail', 'ad', '2013-06-26 10:55:28', 'edit', '127.0.0.1'),
(1160, 'purchaseDetail', 'ad', '2013-06-26 10:55:29', 'edit', '127.0.0.1'),
(1161, 'purchaseDetail', 'ad', '2013-06-26 10:56:30', 'edit', '127.0.0.1'),
(1162, 'purchaseDetail', 'ad', '2013-06-26 10:59:12', 'edit', '127.0.0.1'),
(1163, 'purchaseDetail', 'ad', '2013-06-26 11:01:32', 'edit', '127.0.0.1'),
(1164, 'purchaseDetail', 'ad', '2013-06-26 11:23:38', 'edit', '127.0.0.1'),
(1165, 'purchaseDetail', 'ad', '2013-06-26 11:24:44', 'edit', '127.0.0.1'),
(1166, 'purchaseDetail', 'ad', '2013-06-26 02:50:43', 'edit', '127.0.0.1'),
(1167, 'purchaseDetail', 'ad', '2013-06-26 03:58:47', 'edit', '127.0.0.1'),
(1168, 'supplier', 'ad', '2013-06-26 05:24:59', 'del', '127.0.0.1'),
(1169, 'item', 'ad', '2013-06-26 05:39:32', 'edit', '127.0.0.1'),
(1170, 'supplier', 'ad', '2013-06-26 05:41:37', 'edit', '127.0.0.1'),
(1171, 'menu', 'ad', '2013-07-01 03:34:51', 'edit', '127.0.0.1'),
(1172, 'menu', 'ad', '2013-07-01 03:34:57', 'edit', '127.0.0.1'),
(1173, 'news', 'ad', '2013-07-01 05:55:21', 'add', '127.0.0.1'),
(1174, 'news', 'ad', '2013-07-01 06:08:30', 'add', '127.0.0.1'),
(1175, 'news', 'ad', '2013-07-01 06:24:02', 'edit', '127.0.0.1'),
(1176, 'news', 'ad', '2013-07-01 06:24:21', 'edit', '127.0.0.1'),
(1177, 'news', 'ad', '2013-07-01 06:24:31', 'edit', '127.0.0.1'),
(1178, 'menu', 'ad', '2013-07-02 10:02:18', 'edit', '127.0.0.1'),
(1179, 'task', 'ad', '2013-07-02 10:21:40', 'edit', '127.0.0.1'),
(1180, 'task', 'ad', '2013-07-02 10:21:49', 'edit', '127.0.0.1'),
(1181, 'systemConfig', 'ad', '2013-07-05 12:33:24', 'edit', '127.0.0.1'),
(1182, 'systemConfig', 'ad', '2013-07-05 02:05:13', 'del', '127.0.0.1'),
(1183, 'systemConfig', 'ad', '2013-07-05 02:05:13', 'del', '127.0.0.1'),
(1184, 'systemConfig', 'ad', '2013-07-05 02:05:13', 'del', '127.0.0.1'),
(1185, 'systemConfig', 'ad', '2013-07-05 02:05:49', 'del', '127.0.0.1'),
(1186, 'systemConfig', 'ad', '2013-07-05 02:08:30', 'del', '127.0.0.1'),
(1187, 'systemConfig', 'ad', '2013-07-05 02:10:10', 'del', '127.0.0.1'),
(1188, 'systemConfig', 'ad', '2013-07-05 02:12:03', 'del', '127.0.0.1'),
(1189, 'employeeAttendance', 'ad', '2013-07-11 02:46:25', 'edit', '127.0.0.1'),
(1190, 'employeeAttendance', 'ad', '2013-07-11 02:48:00', 'edit', '127.0.0.1'),
(1191, 'employeeAttendance', 'ad', '2013-07-19 11:09:21', 'edit', '127.0.0.1'),
(1192, 'menu', 'ad', '2013-07-24 05:30:52', 'edit', '127.0.0.1'),
(1193, 'menu', 'ad', '2013-07-24 05:55:42', 'edit', '127.0.0.1'),
(1194, 'purchaseDetail', 'ad', '2013-07-31 01:24:42', 'edit', '127.0.0.1'),
(1195, 'purchaseDetail', 'ad', '2013-07-31 01:24:53', 'edit', '127.0.0.1'),
(1196, 'purchaseDetail', 'ad', '2013-07-31 01:24:53', 'edit', '127.0.0.1'),
(1197, 'purchaseDetail', 'ad', '2013-07-31 01:24:58', 'edit', '127.0.0.1'),
(1198, 'purchaseDetail', 'ad', '2013-07-31 01:24:58', 'edit', '127.0.0.1'),
(1199, 'purchaseDetail', 'ad', '2013-07-31 01:24:58', 'edit', '127.0.0.1'),
(1200, 'purchaseDetail', 'ad', '2013-07-31 01:25:03', 'edit', '127.0.0.1'),
(1201, 'purchaseDetail', 'ad', '2013-07-31 01:25:03', 'edit', '127.0.0.1'),
(1202, 'purchaseDetail', 'ad', '2013-07-31 01:25:03', 'edit', '127.0.0.1'),
(1203, 'purchaseDetail', 'ad', '2013-07-31 01:25:03', 'edit', '127.0.0.1'),
(1204, 'purchaseDetail', 'ad', '2013-07-31 01:25:12', 'edit', '127.0.0.1'),
(1205, 'purchaseDetail', 'ad', '2013-07-31 01:25:12', 'edit', '127.0.0.1'),
(1206, 'purchaseDetail', 'ad', '2013-07-31 01:25:12', 'edit', '127.0.0.1'),
(1207, 'purchaseDetail', 'ad', '2013-07-31 01:25:12', 'edit', '127.0.0.1'),
(1208, 'employee', 'ad', '2013-07-31 02:17:58', 'edit', '127.0.0.1'),
(1209, 'recruitment', 'ad', '2013-07-31 02:17:58', 'edit', '127.0.0.1'),
(1210, 'employee', 'ad', '2013-07-31 02:18:45', 'edit', '127.0.0.1'),
(1211, 'recruitment', 'ad', '2013-07-31 02:18:46', 'edit', '127.0.0.1'),
(1212, 'employee', 'ad', '2013-07-31 02:19:09', 'edit', '127.0.0.1'),
(1213, 'recruitment', 'ad', '2013-07-31 02:19:10', 'edit', '127.0.0.1'),
(1214, 'employee', 'ad', '2013-07-31 02:19:27', 'edit', '127.0.0.1'),
(1215, 'recruitment', 'ad', '2013-07-31 02:19:27', 'edit', '127.0.0.1'),
(1216, 'employee', 'ad', '2013-07-31 02:19:46', 'edit', '127.0.0.1'),
(1217, 'recruitment', 'ad', '2013-07-31 02:19:47', 'edit', '127.0.0.1'),
(1218, 'employee', 'ad', '2013-07-31 02:20:16', 'edit', '127.0.0.1'),
(1219, 'recruitment', 'ad', '2013-07-31 02:20:16', 'edit', '127.0.0.1'),
(1220, 'employee', 'ad', '2013-07-31 02:46:08', 'edit', '127.0.0.1'),
(1221, 'recruitment', 'ad', '2013-07-31 02:46:08', 'edit', '127.0.0.1'),
(1222, 'employee', 'ad', '2013-07-31 03:04:47', 'edit', '127.0.0.1'),
(1223, 'recruitment', 'ad', '2013-07-31 03:04:47', 'edit', '127.0.0.1'),
(1224, 'employee', 'ad', '2013-07-31 03:06:30', 'edit', '127.0.0.1'),
(1225, 'recruitment', 'ad', '2013-07-31 03:06:30', 'edit', '127.0.0.1'),
(1226, 'employee', 'ad', '2013-07-31 03:07:13', 'edit', '127.0.0.1'),
(1227, 'recruitment', 'ad', '2013-07-31 03:07:13', 'edit', '127.0.0.1'),
(1228, 'employee', 'ad', '2013-07-31 03:09:20', 'edit', '127.0.0.1'),
(1229, 'recruitment', 'ad', '2013-07-31 03:09:20', 'edit', '127.0.0.1'),
(1230, 'employee', 'ad', '2013-07-31 03:10:28', 'edit', '127.0.0.1'),
(1231, 'recruitment', 'ad', '2013-07-31 03:10:28', 'edit', '127.0.0.1'),
(1232, 'employee', 'ad', '2013-07-31 03:10:33', 'edit', '127.0.0.1'),
(1233, 'recruitment', 'ad', '2013-07-31 03:10:33', 'edit', '127.0.0.1'),
(1234, 'employee', 'ad', '2013-07-31 03:10:39', 'edit', '127.0.0.1'),
(1235, 'recruitment', 'ad', '2013-07-31 03:10:39', 'edit', '127.0.0.1'),
(1236, 'employee', 'ad', '2013-07-31 03:11:33', 'edit', '127.0.0.1'),
(1237, 'employee', 'ad', '2013-07-31 03:11:38', 'edit', '127.0.0.1'),
(1238, 'employee', 'ad', '2013-07-31 03:11:48', 'edit', '127.0.0.1'),
(1239, 'employee', 'ad', '2013-07-31 03:12:09', 'edit', '127.0.0.1');

-- --------------------------------------------------------

--
-- 表的結構 `nameLang`
--

CREATE TABLE IF NOT EXISTS `nameLang` (
  `nameLangID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `lang` varchar(10) NOT NULL,
  `linkID` int(11) NOT NULL,
  `cDate` datetime NOT NULL,
  `uDate` datetime NOT NULL,
  `menuID` int(11) NOT NULL,
  PRIMARY KEY (`nameLangID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 轉存資料表中的資料 `nameLang`
--

INSERT INTO `nameLang` (`nameLangID`, `name`, `lang`, `linkID`, `cDate`, `uDate`, `menuID`) VALUES
(1, '選單類別設定', 'zh_TW', 1, '2013-04-26 11:54:43', '0000-00-00 00:00:00', 2),
(2, '選單設定', 'zh_TW', 2, '2013-04-26 11:57:23', '0000-00-00 00:00:00', 2);

-- --------------------------------------------------------

--
-- 表的結構 `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `newsID` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `title` varchar(50) NOT NULL,
  `file` varchar(100) NOT NULL,
  `issuedDate` date NOT NULL,
  `version` int(11) NOT NULL,
  `revision` int(11) NOT NULL,
  `cDate` date NOT NULL,
  `uDate` date NOT NULL,
  `managerID` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`newsID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 轉存資料表中的資料 `news`
--

INSERT INTO `news` (`newsID`, `code`, `title`, `file`, `issuedDate`, `version`, `revision`, `cDate`, `uDate`, `managerID`, `type`) VALUES
(1, ' memo000001', ' the memo 01', 'e56c2bb12438c345c99568f127819c17.jpg', '2013-07-31', 0, 0, '2013-07-01', '0000-00-00', 1, 1),
(2, ' procedures01', 'proceduresTitle', 'cec6006fd92df226e1d0a7002e026dca.doc', '2013-07-31', 1, 1, '2013-07-01', '2013-07-01', 1, 2);

-- --------------------------------------------------------

--
-- 表的結構 `priceHistory`
--

CREATE TABLE IF NOT EXISTS `priceHistory` (
  `priceHistoryID` int(11) NOT NULL AUTO_INCREMENT,
  `cDate` date NOT NULL,
  `previousPrice` double NOT NULL,
  `priceDifference` double NOT NULL,
  `remark` varchar(500) NOT NULL,
  `link` int(11) NOT NULL,
  `uDate` date NOT NULL,
  PRIMARY KEY (`priceHistoryID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 轉存資料表中的資料 `priceHistory`
--

INSERT INTO `priceHistory` (`priceHistoryID`, `cDate`, `previousPrice`, `priceDifference`, `remark`, `link`, `uDate`) VALUES
(1, '2013-05-20', 1.3, 0.01, 'happy', 1, '2013-05-20'),
(2, '2013-05-20', 1.31, 0.01, 'done', 1, '2013-05-20'),
(3, '2013-05-20', 1.6, 0.02, '', 5, '0000-00-00'),
(4, '2013-05-20', 0.68, -0.02, '', 14, '0000-00-00');

-- --------------------------------------------------------

--
-- 表的結構 `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `projectID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `clientName` varchar(100) NOT NULL,
  `projectNo` varchar(50) NOT NULL,
  `inquiryNo` varchar(50) NOT NULL COMMENT '交涉編號',
  `negotiating` varchar(200) NOT NULL COMMENT '窗口',
  `status` int(11) NOT NULL COMMENT '階段(In-Progress,Under Negotiating,Completed)',
  `uDate` date NOT NULL,
  `managerID` int(11) NOT NULL,
  `scope` text NOT NULL COMMENT '工作清單',
  `location` int(11) NOT NULL COMMENT '案件所在地',
  `clientRequirement` text NOT NULL COMMENT '客戶需求',
  `warrantyPeriod` varchar(100) NOT NULL COMMENT '保固期',
  `siteManager` int(11) NOT NULL COMMENT '現地負責人',
  `perContactStart` date NOT NULL COMMENT '和約開始日',
  `actualStart` date NOT NULL COMMENT '正確開始日',
  `perContactCompletion` date NOT NULL COMMENT '合約結束日',
  `actualCompletion` date NOT NULL COMMENT '正確結束日',
  `cDate` date NOT NULL,
  `negotiatingStatus` int(11) NOT NULL COMMENT '交涉階段',
  PRIMARY KEY (`projectID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 轉存資料表中的資料 `project`
--

INSERT INTO `project` (`projectID`, `name`, `clientName`, `projectNo`, `inquiryNo`, `negotiating`, `status`, `uDate`, `managerID`, `scope`, `location`, `clientRequirement`, `warrantyPeriod`, `siteManager`, `perContactStart`, `actualStart`, `perContactCompletion`, `actualCompletion`, `cDate`, `negotiatingStatus`) VALUES
(1, 'testProj1', 'maple', 'proj000001', '0', '0', 2, '2013-05-14', 1, '5678', 0, '0', '3 month', 1, '2013-05-15', '2013-05-31', '2013-05-15', '2013-05-31', '0000-00-00', 0),
(2, 'testProj2', 'monica', 'proj000002', '0', '0', 2, '2013-05-14', 1, '5678', 0, '0', '0', 1, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 0),
(3, 'testProj3', 'ben', 'proj000003', '0', '0', 1, '2013-05-14', 1, '0', 0, '0', '0', 2, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 0),
(4, 'testProj4', 'Rasario', 'proj000004', '0', '0', 0, '2013-05-14', 1, '0', 0, '0', '0', 2, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 0),
(5, 'testProj5', 'danny', 'proj000005', '0', '0', 1, '2013-05-14', 1, '0', 0, '0', '0', 2, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 0),
(6, 'new Project', 'unimedia', 'proj0001', 'nego00001', 'danny', 0, '2013-05-15', 1, '', 0, '', '', 1, '2013-05-31', '0000-00-00', '2013-06-30', '0000-00-00', '2013-05-14', 1);

-- --------------------------------------------------------

--
-- 表的結構 `purchaseDetail`
--

CREATE TABLE IF NOT EXISTS `purchaseDetail` (
  `purchaseDetailID` int(11) NOT NULL AUTO_INCREMENT,
  `itemID` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `cDate` date NOT NULL,
  `uDate` date NOT NULL,
  `managerID` int(11) NOT NULL,
  `receivedDate` date NOT NULL,
  `purchaseRequestID` int(11) NOT NULL,
  `purchaseOrderID` int(11) NOT NULL,
  `securityCode` varchar(100) NOT NULL,
  `processes1` date NOT NULL,
  `processes2` date NOT NULL,
  `processes3` date NOT NULL,
  `processes4` date NOT NULL,
  `processes5` date NOT NULL,
  `processes6` date NOT NULL,
  `processes7` date NOT NULL,
  `processes8` date NOT NULL,
  `processes9` date NOT NULL,
  `porRceivedDate` date NOT NULL,
  `inventoryPost` int(11) NOT NULL,
  `processes10` date NOT NULL,
  `processes11` date NOT NULL,
  `processes12` date NOT NULL,
  `processes13` date NOT NULL,
  `invoceNo` varchar(20) NOT NULL,
  PRIMARY KEY (`purchaseDetailID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=57 ;

--
-- 轉存資料表中的資料 `purchaseDetail`
--

INSERT INTO `purchaseDetail` (`purchaseDetailID`, `itemID`, `qty`, `cDate`, `uDate`, `managerID`, `receivedDate`, `purchaseRequestID`, `purchaseOrderID`, `securityCode`, `processes1`, `processes2`, `processes3`, `processes4`, `processes5`, `processes6`, `processes7`, `processes8`, `processes9`, `porRceivedDate`, `inventoryPost`, `processes10`, `processes11`, `processes12`, `processes13`, `invoceNo`) VALUES
(29, 10, 3, '2013-05-22', '2013-05-28', 1, '0000-00-00', 2, 0, 'IKZLEG578W', '2013-05-28', '2013-05-28', '2013-05-28', '2013-05-27', '2013-05-28', '2013-05-28', '2013-05-28', '2013-05-28', '2013-05-28', '0000-00-00', 0, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', ''),
(30, 14, 5, '2013-05-22', '2013-05-28', 1, '0000-00-00', 2, 0, 'IKZLEG578W', '2013-05-27', '2013-05-27', '2013-05-27', '2013-05-27', '2013-05-27', '2013-05-27', '2013-05-27', '2013-05-27', '2013-05-27', '0000-00-00', 0, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', ''),
(31, 13, 2, '2013-05-22', '2013-06-26', 1, '2013-05-28', 3, 0, 'G9OTWURHCA', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '2013-05-27', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 1, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '223445566'),
(32, 10, 3, '2013-05-22', '2013-06-26', 1, '2013-05-28', 3, 4, 'G9OTWURHCA', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '474849'),
(33, 1, 6, '2013-05-22', '2013-06-12', 1, '2013-05-28', 3, 4, 'G9OTWURHCA', '0000-00-00', '2013-05-27', '0000-00-00', '0000-00-00', '2013-05-27', '0000-00-00', '0000-00-00', '2013-05-27', '0000-00-00', '0000-00-00', 0, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', ''),
(34, 10, 6, '2013-05-22', '2013-06-12', 1, '2013-06-11', 4, 5, 'A3A75NX1SY', '0000-00-00', '0000-00-00', '0000-00-00', '2013-05-16', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 1, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', ''),
(36, 14, 70, '2013-05-22', '2013-06-26', 1, '2013-06-11', 4, 2, 'A3A75NX1SY', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 1, '0000-00-00', '2013-06-17', '2013-06-17', '2013-06-17', '5678'),
(38, 1, 1, '2013-05-22', '2013-05-22', 1, '0000-00-00', 1, 0, 'ALFFRBC3YE', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', ''),
(39, 14, 5, '2013-05-22', '2013-05-22', 1, '0000-00-00', 1, 0, 'ALFFRBC3YE', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', ''),
(40, 10, 3, '2013-05-27', '2013-05-27', 1, '0000-00-00', 40, 0, 'FGF1X6XG9F', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', ''),
(41, 10, 4, '2013-05-28', '2013-05-28', 1, '0000-00-00', 41, 0, '95IDFKOPU4', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', ''),
(44, 13, 88, '2013-05-28', '2013-05-28', 1, '0000-00-00', 44, 0, '6P3FKOP5GZ1369728079890', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', ''),
(45, 5, 9, '2013-05-28', '2013-05-28', 1, '0000-00-00', 45, 0, 'XVYV2GLOCL1369737095408', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', ''),
(47, 13, 10, '2013-06-11', '2013-06-12', 4, '0000-00-00', 5, 0, 'S8ZEMYDEH8', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 1, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', ''),
(48, 10, 20, '2013-06-12', '2013-06-12', 4, '0000-00-00', 48, 0, '1LI76KNWJK1371020227827', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', ''),
(49, 13, 20, '2013-06-12', '2013-06-12', 4, '0000-00-00', 7, 0, 'CRPUNLLVAJ1371027706884', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', ''),
(50, 10, 10, '2013-06-12', '2013-06-12', 4, '2013-06-12', 7, 6, 'CRPUNLLVAJ1371027706884', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 1, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', ''),
(51, 1, 5, '2013-06-12', '2013-06-12', 4, '2013-06-12', 7, 6, 'CRPUNLLVAJ1371027706884', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 1, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', ''),
(52, 1, 20, '2013-06-12', '2013-06-12', 4, '0000-00-00', 4, 0, 'A3A75NX1SY', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', ''),
(53, 10, 10, '2013-07-31', '2013-07-31', 1, '0000-00-00', 5, 0, 'WAK8HHJPP51375248263677', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', ''),
(54, 1, 3, '2013-07-31', '2013-07-31', 1, '0000-00-00', 5, 0, 'WAK8HHJPP51375248263677', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', ''),
(55, 14, 8, '2013-07-31', '2013-07-31', 1, '0000-00-00', 5, 0, 'WAK8HHJPP51375248263677', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', ''),
(56, 15, 1, '2013-07-31', '2013-07-31', 1, '0000-00-00', 5, 0, 'WAK8HHJPP51375248263677', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '');

-- --------------------------------------------------------

--
-- 表的結構 `purchaseList`
--

CREATE TABLE IF NOT EXISTS `purchaseList` (
  `purchaseListID` int(11) NOT NULL AUTO_INCREMENT,
  `poID` int(11) NOT NULL COMMENT '採購單id',
  `prID` int(11) NOT NULL COMMENT '請購單id',
  `itemID` int(11) NOT NULL COMMENT '項目id',
  `qty` int(11) NOT NULL COMMENT '數量',
  `inventory` int(11) NOT NULL COMMENT '列入倉儲與否',
  `receivedDate` datetime NOT NULL COMMENT '接收日',
  `cDate` datetime NOT NULL COMMENT '建立日',
  `uDate` datetime NOT NULL COMMENT '更新日',
  PRIMARY KEY (`purchaseListID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的結構 `purchaseOrder`
--

CREATE TABLE IF NOT EXISTS `purchaseOrder` (
  `purchaseOrderID` int(11) NOT NULL AUTO_INCREMENT,
  `purchaseOrderNo` varchar(20) NOT NULL COMMENT '採購單編號',
  `cDate` datetime NOT NULL COMMENT '建立日',
  `uDate` datetime NOT NULL COMMENT '修改日',
  `submitDate` date NOT NULL COMMENT '送出日',
  `status` int(11) NOT NULL COMMENT '處理階段',
  `purchaseRequestID` int(11) NOT NULL COMMENT '請購單id',
  `supplierID` int(11) NOT NULL COMMENT '供應商id',
  `payDate` datetime NOT NULL COMMENT '付款日',
  `purchase` int(11) NOT NULL COMMENT '採購者',
  `check` int(11) NOT NULL COMMENT '確認者',
  `approved` int(11) NOT NULL COMMENT '審核者',
  `managerID` int(11) NOT NULL COMMENT '填表人',
  `totalAmt` int(11) NOT NULL COMMENT '總價',
  `type` int(11) NOT NULL COMMENT '類別(國內、海外)',
  `projectID` int(11) NOT NULL COMMENT '專案id',
  `remark` varchar(200) NOT NULL COMMENT '備註',
  `payNote` varchar(200) NOT NULL COMMENT '付款備註',
  `securityCode` varchar(30) NOT NULL,
  `eDate` date NOT NULL,
  PRIMARY KEY (`purchaseOrderID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 轉存資料表中的資料 `purchaseOrder`
--

INSERT INTO `purchaseOrder` (`purchaseOrderID`, `purchaseOrderNo`, `cDate`, `uDate`, `submitDate`, `status`, `purchaseRequestID`, `supplierID`, `payDate`, `purchase`, `check`, `approved`, `managerID`, `totalAmt`, `type`, `projectID`, `remark`, `payNote`, `securityCode`, `eDate`) VALUES
(2, 'PO000002', '2013-06-08 03:57:04', '2013-06-26 10:05:28', '2013-06-12', 0, 4, 4, '0000-00-00 00:00:00', 0, 1, 0, 1, 0, 0, 5, 'aabbc', '', 'A3A75NX1SY', '2013-06-29'),
(3, 'PO000001', '2013-06-10 03:18:02', '2013-06-10 03:21:21', '2013-06-10', 1, 4, 4, '0000-00-00 00:00:00', 1, 1, 2, 4, 0, 0, 1, '5678', '', 'A3A75NX1SY', '2013-06-29'),
(4, 'PO000003', '2013-06-10 03:20:21', '2013-06-10 04:07:15', '2013-06-10', 1, 3, 2, '0000-00-00 00:00:00', 1, 1, 0, 4, 0, 0, 5, '5566', '', 'G9OTWURHCA', '2013-06-29'),
(5, 'overPO000001', '2013-06-10 04:16:10', '0000-00-00 00:00:00', '0000-00-00', 0, 4, 2, '0000-00-00 00:00:00', 1, 1, 0, 4, 0, 1, 1, '11', '', 'A3A75NX1SY', '2013-06-29'),
(6, 'PO000004', '2013-06-12 11:49:46', '0000-00-00 00:00:00', '0000-00-00', 0, 7, 2, '0000-00-00 00:00:00', 0, 0, 0, 4, 0, 0, 5, '', '', 'CRPUNLLVAJ1371027706884', '2013-06-29');

-- --------------------------------------------------------

--
-- 表的結構 `purchaseProcess`
--

CREATE TABLE IF NOT EXISTS `purchaseProcess` (
  `poProcessID` int(11) NOT NULL AUTO_INCREMENT,
  `stage` int(11) NOT NULL COMMENT '處理階段',
  `poID` int(11) NOT NULL COMMENT '採購單編號',
  `cDate` int(11) NOT NULL COMMENT '建立日',
  `uDate` int(11) NOT NULL COMMENT '修改日',
  `eDate` int(11) NOT NULL COMMENT '執行時間',
  PRIMARY KEY (`poProcessID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的結構 `purchaseRequest`
--

CREATE TABLE IF NOT EXISTS `purchaseRequest` (
  `purchaseRequestID` int(11) NOT NULL AUTO_INCREMENT,
  `purchaseRequestNo` varchar(20) NOT NULL COMMENT '請購單編號',
  `status` int(11) NOT NULL COMMENT '處理階段',
  `cDate` datetime NOT NULL COMMENT '建立日期',
  `uDate` datetime NOT NULL COMMENT '更新日期',
  `eDate` date NOT NULL COMMENT '預計到貨日',
  `submitDate` date NOT NULL COMMENT '提交日期',
  `projectID` int(11) NOT NULL COMMENT '專案id',
  `planID` int(11) NOT NULL COMMENT '圖紙id',
  `remark` varchar(100) NOT NULL COMMENT '備註',
  `managerID` int(11) NOT NULL COMMENT '建立者',
  `securityCode` varchar(100) NOT NULL,
  PRIMARY KEY (`purchaseRequestID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 轉存資料表中的資料 `purchaseRequest`
--

INSERT INTO `purchaseRequest` (`purchaseRequestID`, `purchaseRequestNo`, `status`, `cDate`, `uDate`, `eDate`, `submitDate`, `projectID`, `planID`, `remark`, `managerID`, `securityCode`) VALUES
(1, 'PR000001', 1, '2013-05-22 05:48:29', '2013-05-22 06:21:53', '0000-00-00', '0000-00-00', 5, 0, 'as soon as possiable', 1, 'ALFFRBC3YE'),
(2, 'PR00002', 1, '2013-05-22 05:50:07', '2013-05-28 09:56:50', '0000-00-00', '2013-05-23', 4, 4, 'whatever', 1, 'IKZLEG578W'),
(3, 'PR000003', 0, '2013-05-22 06:00:12', '2013-06-12 09:10:46', '0000-00-00', '2013-05-23', 3, 0, '', 4, 'G9OTWURHCA'),
(4, 'PR000004', 0, '2013-05-22 06:02:29', '2013-06-12 11:40:36', '0000-00-00', '2013-05-23', 5, 8, '', 4, 'A3A75NX1SY'),
(5, 'PR000006', 0, '2013-07-31 01:25:12', '0000-00-00 00:00:00', '2013-08-10', '0000-00-00', 3, 0, '', 1, 'WAK8HHJPP51375248263677');

-- --------------------------------------------------------

--
-- 表的結構 `recruitment`
--

CREATE TABLE IF NOT EXISTS `recruitment` (
  `recruitmentID` int(11) NOT NULL AUTO_INCREMENT,
  `requestDate` date NOT NULL,
  `approvalDate` date NOT NULL,
  `receiveDate` date NOT NULL,
  `employeeID` int(11) NOT NULL,
  `expectSalary` int(11) NOT NULL,
  `offerSalary` int(11) NOT NULL,
  `toRequestDate` date NOT NULL,
  `requesterID` int(11) NOT NULL,
  `interviewDate` date NOT NULL,
  `other` varchar(200) NOT NULL,
  `confirmDate` date NOT NULL,
  `interview1st` date NOT NULL,
  `time1st` varchar(50) NOT NULL,
  `interviewer1st` int(11) NOT NULL,
  `interview2nd` date NOT NULL,
  `time2nd` varchar(50) NOT NULL,
  `interviewer2nd` int(11) NOT NULL,
  `applicationMode` varchar(200) NOT NULL,
  `pass` int(11) NOT NULL,
  `resultConfirm` int(11) NOT NULL,
  `cDate` date NOT NULL,
  `uDate` date NOT NULL,
  `managerID` int(11) NOT NULL,
  `cvReceiveDate` date NOT NULL,
  PRIMARY KEY (`recruitmentID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 轉存資料表中的資料 `recruitment`
--

INSERT INTO `recruitment` (`recruitmentID`, `requestDate`, `approvalDate`, `receiveDate`, `employeeID`, `expectSalary`, `offerSalary`, `toRequestDate`, `requesterID`, `interviewDate`, `other`, `confirmDate`, `interview1st`, `time1st`, `interviewer1st`, `interview2nd`, `time2nd`, `interviewer2nd`, `applicationMode`, `pass`, `resultConfirm`, `cDate`, `uDate`, `managerID`, `cvReceiveDate`) VALUES
(1, '2013-06-21', '2013-06-22', '0000-00-00', 8, 40000, 45000, '0000-00-00', 1, '2013-06-22', '1234', '0000-00-00', '2013-06-23', '3hr', 1, '2013-06-26', '1hr', 2, 'internet', 1, 2, '2013-06-21', '2013-06-23', 1, '2013-06-23'),
(5, '2013-07-31', '0000-00-00', '0000-00-00', 12, 0, 0, '0000-00-00', 1, '2013-08-10', '', '0000-00-00', '0000-00-00', ' ', 0, '0000-00-00', ' ', 0, ' ', 1, 1, '2013-07-31', '2013-07-31', 1, '0000-00-00'),
(6, '2013-07-31', '0000-00-00', '0000-00-00', 13, 0, 0, '0000-00-00', 0, '2013-08-10', '', '0000-00-00', '0000-00-00', ' ', 0, '0000-00-00', ' ', 0, ' ', 0, 0, '2013-07-31', '2013-07-31', 1, '0000-00-00');

-- --------------------------------------------------------

--
-- 表的結構 `requestDetail`
--

CREATE TABLE IF NOT EXISTS `requestDetail` (
  `requestDetailID` int(11) NOT NULL AUTO_INCREMENT,
  `itemID` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `cDate` date NOT NULL,
  `uDate` date NOT NULL,
  `managerID` int(11) NOT NULL,
  `receivedDate` date NOT NULL,
  `materialRequestID` int(11) NOT NULL,
  `securityCode` varchar(100) NOT NULL,
  `inventoryPost` int(11) NOT NULL,
  PRIMARY KEY (`requestDetailID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 轉存資料表中的資料 `requestDetail`
--

INSERT INTO `requestDetail` (`requestDetailID`, `itemID`, `qty`, `cDate`, `uDate`, `managerID`, `receivedDate`, `materialRequestID`, `securityCode`, `inventoryPost`) VALUES
(1, 13, 6, '2013-06-13', '2013-06-14', 1, '2013-06-13', 1, 'Z971HNLYG81371090910037', 1),
(2, 1, 5, '2013-06-13', '2013-06-14', 1, '0000-00-00', 1, 'Z971HNLYG81371090910037', 0),
(3, 14, 10, '2013-06-13', '2013-06-13', 1, '2013-06-13', 1, 'Z971HNLYG81371090910037', 0),
(4, 1, 5, '2013-06-13', '2013-06-13', 1, '0000-00-00', 2, 'GBMO4F08791371095342217', 0),
(5, 13, 3, '2013-06-13', '2013-06-13', 1, '0000-00-00', 2, 'GBMO4F08791371095342217', 0),
(6, 1, 5, '2013-06-13', '2013-06-17', 1, '2013-06-13', 3, 'B6PNMEM2VM1371106280912', 1),
(7, 13, 10, '2013-06-13', '2013-06-17', 1, '2013-06-13', 3, 'B6PNMEM2VM1371106280912', 0);

-- --------------------------------------------------------

--
-- 表的結構 `returnDetail`
--

CREATE TABLE IF NOT EXISTS `returnDetail` (
  `returnDetailID` int(11) NOT NULL AUTO_INCREMENT,
  `itemID` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `cDate` date NOT NULL,
  `uDate` date NOT NULL,
  `managerID` int(11) NOT NULL,
  `receivedDate` date NOT NULL,
  `goodReturnID` int(11) NOT NULL,
  `securityCode` varchar(100) NOT NULL,
  `inventoryPost` int(11) NOT NULL,
  `remark` varchar(100) NOT NULL,
  PRIMARY KEY (`returnDetailID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 轉存資料表中的資料 `returnDetail`
--

INSERT INTO `returnDetail` (`returnDetailID`, `itemID`, `qty`, `cDate`, `uDate`, `managerID`, `receivedDate`, `goodReturnID`, `securityCode`, `inventoryPost`, `remark`) VALUES
(1, 1, 1, '2013-06-13', '2013-06-13', 1, '0000-00-00', 1, '8SYDG279UY1371106794463', 0, '1321'),
(2, 13, 10, '2013-06-13', '2013-06-13', 1, '0000-00-00', 1, '8SYDG279UY1371106794463', 0, '666'),
(3, 13, 1, '2013-06-13', '2013-06-17', 1, '2013-06-13', 2, 'ZF684AGI371371147406283', 1, '123'),
(4, 1, 5, '2013-06-13', '2013-06-17', 1, '2013-06-13', 2, 'ZF684AGI371371147406283', 1, '66');

-- --------------------------------------------------------

--
-- 表的結構 `supplier`
--

CREATE TABLE IF NOT EXISTS `supplier` (
  `supplierID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '供應商名稱',
  `location` int(11) NOT NULL COMMENT '位置',
  `payment` varchar(100) NOT NULL COMMENT '付款方式',
  `supPic` varchar(100) NOT NULL COMMENT '圖片',
  `nameFirst` varchar(50) NOT NULL COMMENT '名',
  `nameLast` varchar(50) NOT NULL COMMENT '姓',
  `bussType` varchar(50) NOT NULL COMMENT '產業類別',
  `bussPhone` varchar(50) NOT NULL COMMENT '公司電話',
  `webpage` varchar(100) NOT NULL COMMENT '公司網站',
  `gender` int(11) NOT NULL COMMENT '性別',
  `position` varchar(50) NOT NULL COMMENT '級職',
  `fax` varchar(50) NOT NULL COMMENT '傳真',
  `email` varchar(50) NOT NULL COMMENT '住址(街、號)',
  `postalFirst` varchar(100) NOT NULL COMMENT '住址(國、洲、城)',
  `postalLast` varchar(100) NOT NULL COMMENT '建立人',
  `managerID` int(11) NOT NULL COMMENT '核準人',
  `approved` int(11) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `cDate` datetime NOT NULL,
  `uDate` datetime NOT NULL,
  `code` varchar(50) NOT NULL COMMENT '供應商編號',
  `status` int(11) NOT NULL COMMENT '連繫狀態',
  `supplierNo` varchar(100) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `supEvaluation1` int(11) NOT NULL,
  `supEvaluation2` int(11) NOT NULL,
  `supEvaluation3` int(11) NOT NULL,
  `supEvaluation4` int(11) NOT NULL,
  `supEvaluation5` int(11) NOT NULL,
  `supEvaluation6` int(11) NOT NULL,
  `supEvaluation7` int(11) NOT NULL,
  `supEvaluation8` int(11) NOT NULL,
  `totalScore` int(11) NOT NULL,
  `supPrepareID` int(11) NOT NULL,
  PRIMARY KEY (`supplierID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 轉存資料表中的資料 `supplier`
--

INSERT INTO `supplier` (`supplierID`, `name`, `location`, `payment`, `supPic`, `nameFirst`, `nameLast`, `bussType`, `bussPhone`, `webpage`, `gender`, `position`, `fax`, `email`, `postalFirst`, `postalLast`, `managerID`, `approved`, `mobile`, `cDate`, `uDate`, `code`, `status`, `supplierNo`, `photo`, `supEvaluation1`, `supEvaluation2`, `supEvaluation3`, `supEvaluation4`, `supEvaluation5`, `supEvaluation6`, `supEvaluation7`, `supEvaluation8`, `totalScore`, `supPrepareID`) VALUES
(2, 'unimedia', 1, 'cash', '', 'monica', 'monica', 'media', '4910789', 'unimedia.com.tw', 1, 'manager', '', '', 'Pingzhen City', 'Taiwan', 1, 0, '', '2013-05-01 05:28:29', '2013-06-26 05:41:37', '', 0, 'web000001', '', 2, 4, 3, 1, 5, 1, 1, 4, 21, 8),
(4, 'Fusion Media', 1, 'cash', '', 'Fusion', 'Media', 'media', '', '', 0, 'manager', '', '', '', '', 1, 0, '', '2013-05-21 11:51:00', '2013-06-03 02:09:57', '', 0, 'web000002', '42d3b17482975f33eac87d43d6318b84.jpg', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的結構 `systemConfig`
--

CREATE TABLE IF NOT EXISTS `systemConfig` (
  `systemConfigID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `file` varchar(100) NOT NULL,
  `menuID` int(11) NOT NULL,
  `cDate` date NOT NULL,
  `uDate` date NOT NULL,
  `managerID` int(11) NOT NULL,
  PRIMARY KEY (`systemConfigID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 轉存資料表中的資料 `systemConfig`
--

INSERT INTO `systemConfig` (`systemConfigID`, `title`, `file`, `menuID`, `cDate`, `uDate`, `managerID`) VALUES
(8, 'Organizational Chart', '53cc0d96bb6d8d78db0c257660a50442.jpg', 18, '2013-07-05', '0000-00-00', 1);

-- --------------------------------------------------------

--
-- 表的結構 `task`
--

CREATE TABLE IF NOT EXISTS `task` (
  `taskID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `cDate` date NOT NULL,
  `uDate` date NOT NULL,
  `startDate` date NOT NULL,
  `expectedCompletion` date NOT NULL,
  `actualCompletion` date NOT NULL,
  `assignedTo` int(11) NOT NULL,
  `assignedBy` int(11) NOT NULL,
  `petrolAllowance` int(11) NOT NULL,
  `managerID` int(11) NOT NULL,
  `remark` varchar(500) NOT NULL,
  PRIMARY KEY (`taskID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 轉存資料表中的資料 `task`
--

INSERT INTO `task` (`taskID`, `title`, `cDate`, `uDate`, `startDate`, `expectedCompletion`, `actualCompletion`, `assignedTo`, `assignedBy`, `petrolAllowance`, `managerID`, `remark`) VALUES
(1, ' finish the web system', '2013-07-02', '2013-07-02', '2013-04-01', '2013-06-30', '2013-07-31', 8, 1, 1, 1, 'it''s un easy thing');

-- --------------------------------------------------------

--
-- 表的結構 `warehouse`
--

CREATE TABLE IF NOT EXISTS `warehouse` (
  `warehouseID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  `projectID` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `warehouseManagerID` int(11) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `cDate` date NOT NULL,
  `uDate` date NOT NULL,
  `managerID` int(11) NOT NULL,
  `managerImg` varchar(100) NOT NULL,
  `approve` int(11) NOT NULL,
  PRIMARY KEY (`warehouseID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 轉存資料表中的資料 `warehouse`
--

INSERT INTO `warehouse` (`warehouseID`, `name`, `projectID`, `status`, `warehouseManagerID`, `phone`, `mail`, `address`, `cDate`, `uDate`, `managerID`, `managerImg`, `approve`) VALUES
(1, 'ben''s warehouse', 3, 1, 2, '0919111222', 'abc@def.ghi', 'holiday', '2013-06-03', '2013-06-03', 1, '2bf995b15866a769b27a968c6e601ad8.jpg', 1),
(2, 'Unisun', 5, 1, 1, '', '', '', '2013-06-10', '0000-00-00', 4, '45442c7b6526500221719d12034ca157.jpg', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
