-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2020 at 03:45 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `attendance`
--

-- --------------------------------------------------------

--
-- Table structure for table `18-cse-a`
--

CREATE TABLE `18-cse-a` (
  `date` varchar(10) NOT NULL,
  `code` varchar(10) NOT NULL,
  `18CSR001` varchar(2) DEFAULT NULL,
  `18CSR002` varchar(2) DEFAULT NULL,
  `18CSR003` varchar(2) DEFAULT NULL,
  `18CSR004` varchar(2) DEFAULT NULL,
  `18CSR005` varchar(2) DEFAULT NULL,
  `18CSR006` varchar(2) DEFAULT NULL,
  `18CSR007` varchar(2) DEFAULT NULL,
  `18CSR008` varchar(2) DEFAULT NULL,
  `18CSR009` varchar(2) DEFAULT NULL,
  `18CSR0010` varchar(2) DEFAULT NULL,
  `18CSR011` varchar(2) DEFAULT NULL,
  `18CSR012` varchar(2) DEFAULT NULL,
  `18CSR013` varchar(2) DEFAULT NULL,
  `18CSR014` varchar(2) DEFAULT NULL,
  `18CSR015` varchar(2) DEFAULT NULL,
  `18CSR016` varchar(2) DEFAULT NULL,
  `18CSR017` varchar(2) DEFAULT NULL,
  `18CSR018` varchar(2) DEFAULT NULL,
  `18CSR019` varchar(2) DEFAULT NULL,
  `18CSR020` varchar(2) DEFAULT NULL,
  `18CSR021` varchar(2) DEFAULT NULL,
  `18CSR022` varchar(2) DEFAULT NULL,
  `18CSR023` varchar(2) DEFAULT NULL,
  `18CSR024` varchar(2) DEFAULT NULL,
  `18CSR025` varchar(2) DEFAULT NULL,
  `18CSR026` varchar(2) DEFAULT NULL,
  `18CSR027` varchar(2) DEFAULT NULL,
  `18CSR028` varchar(2) DEFAULT NULL,
  `18CSR029` varchar(2) DEFAULT NULL,
  `18CSR030` varchar(2) DEFAULT NULL,
  `18CSR031` varchar(2) DEFAULT NULL,
  `18CSR032` varchar(2) DEFAULT NULL,
  `18CSR033` varchar(2) DEFAULT NULL,
  `18CSR034` varchar(2) DEFAULT NULL,
  `18CSR035` varchar(2) DEFAULT NULL,
  `18CSR036` varchar(2) DEFAULT NULL,
  `18CSR037` varchar(2) DEFAULT NULL,
  `18CSR038` varchar(2) DEFAULT NULL,
  `18CSR039` varchar(2) DEFAULT NULL,
  `18CSR040` varchar(2) DEFAULT NULL,
  `18CSR041` varchar(2) DEFAULT NULL,
  `18CSR042` varchar(2) DEFAULT NULL,
  `18CSR043` varchar(2) DEFAULT NULL,
  `18CSR044` varchar(2) DEFAULT NULL,
  `18CSR045` varchar(2) DEFAULT NULL,
  `18CSR046` varchar(2) DEFAULT NULL,
  `18CSR047` varchar(2) DEFAULT NULL,
  `18CSR048` varchar(2) DEFAULT NULL,
  `18CSR049` varchar(2) DEFAULT NULL,
  `18CSR050` varchar(2) DEFAULT NULL,
  `18CSR051` varchar(2) DEFAULT NULL,
  `18CSR052` varchar(2) DEFAULT NULL,
  `18CSR053` varchar(2) DEFAULT NULL,
  `18CSR054` varchar(2) DEFAULT NULL,
  `18CSR055` varchar(2) DEFAULT NULL,
  `18CSR056` varchar(2) DEFAULT NULL,
  `18CSR057` varchar(2) DEFAULT NULL,
  `18CSR058` varchar(2) DEFAULT NULL,
  `18CSR059` varchar(2) DEFAULT NULL,
  `18CSR060` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `18-cse-a`
--

INSERT INTO `18-cse-a` (`date`, `code`, `18CSR001`, `18CSR002`, `18CSR003`, `18CSR004`, `18CSR005`, `18CSR006`, `18CSR007`, `18CSR008`, `18CSR009`, `18CSR0010`, `18CSR011`, `18CSR012`, `18CSR013`, `18CSR014`, `18CSR015`, `18CSR016`, `18CSR017`, `18CSR018`, `18CSR019`, `18CSR020`, `18CSR021`, `18CSR022`, `18CSR023`, `18CSR024`, `18CSR025`, `18CSR026`, `18CSR027`, `18CSR028`, `18CSR029`, `18CSR030`, `18CSR031`, `18CSR032`, `18CSR033`, `18CSR034`, `18CSR035`, `18CSR036`, `18CSR037`, `18CSR038`, `18CSR039`, `18CSR040`, `18CSR041`, `18CSR042`, `18CSR043`, `18CSR044`, `18CSR045`, `18CSR046`, `18CSR047`, `18CSR048`, `18CSR049`, `18CSR050`, `18CSR051`, `18CSR052`, `18CSR053`, `18CSR054`, `18CSR055`, `18CSR056`, `18CSR057`, `18CSR058`, `18CSR059`, `18CSR060`) VALUES
('2020-07-06', '18CST38', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P');

-- --------------------------------------------------------

--
-- Table structure for table `course_list`
--

CREATE TABLE `course_list` (
  `code` varchar(8) NOT NULL,
  `name` varchar(40) NOT NULL,
  `dept` varchar(40) NOT NULL,
  `batch` year(4) NOT NULL,
  `staff1` varchar(8) DEFAULT NULL,
  `sec1` varchar(1) DEFAULT NULL,
  `staff2` varchar(8) DEFAULT NULL,
  `sec2` varchar(1) DEFAULT NULL,
  `staff3` varchar(8) DEFAULT NULL,
  `sec3` varchar(1) DEFAULT NULL,
  `staff4` varchar(8) DEFAULT NULL,
  `sec4` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `course_list`
--

INSERT INTO `course_list` (`code`, `name`, `dept`, `batch`, `staff1`, `sec1`, `staff2`, `sec2`, `staff3`, `sec3`, `staff4`, `sec4`) VALUES
('18CST38', 'Computer Organization', 'CSE', 2018, 'CSE006SF', 'A', 'CSE019SF', 'B', 'CSE009SF', 'C', 'CSE015SF', 'D');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staffid` varchar(8) NOT NULL,
  `name` varchar(30) NOT NULL,
  `userid` varchar(30) NOT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `mail` varchar(45) NOT NULL,
  `dept` varchar(5) NOT NULL,
  `batch` varchar(4) DEFAULT NULL,
  `sec` varchar(2) DEFAULT NULL,
  `designation` varchar(25) DEFAULT NULL,
  `status` varchar(12) NOT NULL DEFAULT 'Not Changed'
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staffid`, `name`, `userid`, `pass`, `mail`, `dept`, `batch`, `sec`, `designation`, `status`) VALUES
('CSE001SF', 'Dr.N.Shanthi', 'shanthi', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'shanthi.cse@kongu.edu', 'CSE', NULL, NULL, 'HOD', 'Not Changed'),
('CSE002SF', 'Dr.R.R.Rajalaxmi', 'rrr', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'rrr.cse@kongu.edu', 'CSE', NULL, NULL, NULL, 'Not Changed'),
('CSE003SF', 'Dr.K.Kousalya', 'kouse', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'kouse.cse@kongu.edu', 'CSE', NULL, NULL, NULL, 'Not Changed'),
('CSE004SF', 'Dr.S.Malliga', 'mallisenthil', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'mallisenthil.cse@kongu.edu', 'CSE', '2018', NULL, 'Year in Charge', 'Not Changed'),
('CSE005SF', 'Dr.R.C.Suganthe', 'suganthe_rc', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'suganthe_rc.cse@kongu.edu', 'CSE', NULL, NULL, NULL, 'Not Changed'),
('CSE006SF', 'Dr.P.Natesan', 'natesanp', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'natesanp.cse@kongu.edu', 'CSE', NULL, NULL, NULL, 'Not Changed'),
('CSE007SF', 'Dr.C.S.Kanimozhi Selvi', 'kanimozhi', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'kanimozhi.cse@kongu.edu', 'CSE', '2019', NULL, 'Year in Charge', 'Not Changed'),
('CSE008SF', 'Dr.E.Gothai', 'egothai', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'egothai.cse@kongu.edu', 'CSE', NULL, NULL, NULL, 'Not Changed'),
('CSE009SF', 'Dr.P.Jayanthi', 'jayanthime', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'jayanthime.cse@kongu.edu', 'CSE', NULL, NULL, NULL, 'Not Changed'),
('CSE010SF', 'Dr.S.Shanthi', 'shanthis', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'shanthis.cse@kongu.edu', 'CSE', NULL, NULL, NULL, 'Not Changed'),
('CSE011SF', 'Mr.N.P.Saravanan', 'npsaravanan', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'npsaravanan.cse@kongu.edu', 'CSE', NULL, NULL, NULL, 'Not Changed'),
('CSE012SF', 'Dr.K.Nirmala Devi', 'k_nirmal', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'k_nirmal.cse@kongu.edu', 'CSE', NULL, NULL, NULL, 'Not Changed'),
('CSE013SF', 'Ms.PCD.Kalaivaani', 'kalairupa', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'kalairupa.cse@kongu.edu', 'CSE', NULL, NULL, NULL, 'Not Changed'),
('CSE014SF', 'Dr.R.S.Latha', 'latha', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'latha.cse@kongu.edu', 'CSE', '2018', 'A', 'Advisor', 'Not Changed'),
('CSE015SF', 'Dr.N.Krishnamoorthy', 'nmoorthy', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'nmoorthy.cse@kongu.edu', 'CSE', NULL, NULL, NULL, 'Not Changed'),
('CSE016SF', 'Dr.K.Sangeetha', 'sangeetha_k', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'sangeetha_k.cse@kongu.edu', 'CSE', '2018', 'B', 'Advisor', 'Not Changed'),
('CSE017SF', 'Dr.S.V.Kogilavani', 'kogilavani', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'kogilavani.cse@kongu.edu', 'CSE', NULL, NULL, NULL, 'Not Changed'),
('CSE018SF', 'Dr.P.Vishnu Raja', 'pvishnu', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'pvishnu.cse@kongu.edu', 'CSE', NULL, NULL, NULL, 'Not Changed'),
('CSE019SF', 'Dr.P.Keerthika', 'keerthika', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'keerthika.cse@kongu.edu', 'CSE', NULL, NULL, NULL, 'Not Changed'),
('CSE01TSF', 'Test Staff', 'test', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'test.cse@kongu.edu', 'CSE', '2000', 'T', 'Advisor', 'Not Changed'),
('CSE020SF', 'Dr.S.K.Nivetha', 'nivetha', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'nivetha.cse@kongu.edu', 'CSE', NULL, NULL, NULL, 'Not Changed'),
('CSE021SF', 'Dr.R.S.Mohana', 'mohanapragash', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'mohanapragash.cse@kongu.edu', 'CSE', NULL, NULL, NULL, 'Not Changed'),
('CSE022SF', 'Ms.M.Geetha', 'geetha', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'geetha.cse@kongu.edu', 'CSE', NULL, NULL, NULL, 'Not Changed'),
('CSE023SF', 'Dr.R.Manjula Devi', 'manjuladevi', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'manjuladevi.cse@kongu.edu', 'CSE', NULL, NULL, NULL, 'Not Changed'),
('CSE024SF', 'Mr.T.Kumaravel', 'tkumar', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'tkumar.cse@kongu.edu', 'CSE', '2018', 'C', 'Advisor', 'Not Changed'),
('CSE025SF', 'Ms.S.Ramya', 'sramya', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'sramya.cse@kongu.edu', 'CSE', '2019', 'B', 'Advisor', 'Not Changed'),
('CSE026SF', 'Mr.K.Devendran', 'skdeva', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'skdeva.cse@kongu.edu', 'CSE', '2018', 'D', 'Advisor', 'Not Changed'),
('CSE027SF', 'Ms.N.Sasipriyaa', 'sasipriya', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'sasipriya.cse@kongu.edu', 'CSE', '2018', 'A', 'Advisor', 'Not Changed'),
('CSE028SF', 'Mr.B.Bizu', 'bizu', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'bizu.cse@kongu.edu', 'CSE', NULL, NULL, NULL, 'Not Changed'),
('CSE029SF', 'Mr.R.Sureshkumar', 'sureshkec', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'sureshkec.eie@kongu.edu', 'CSE', NULL, NULL, NULL, 'Not Changed'),
('CSE030SF', 'Ms.D.Deepa', 'deepa', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'deepa.cse@kongu.edu', 'CSE', NULL, NULL, NULL, 'Not Changed'),
('CSE031SF', 'Mr.S.Selvaraj', 'selvarajs', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'selvarajs.cse@kongu.edu', 'CSE', NULL, NULL, NULL, 'Not Changed'),
('CSE032SF', 'Ms.M.Sangeetha', 'sangeetham', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'sangeetham.cse@kongu.edu', 'CSE', '2018', 'D', 'Advisor', 'Not Changed'),
('CSE033SF', 'Ms.O.R.Deepa', 'ord', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'ord.cse@kongu.edu', 'CSE', NULL, NULL, NULL, 'Not Changed'),
('CSE034SF', 'Mr.P.S.Prakash', 'psprakash', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'psprakash.cse@kongu.edu', 'CSE', '2019', 'B', 'Advisor', 'Not Changed'),
('CSE035SF', 'Ms.K.S.Kalaivani', 'kalaivani', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'kalaivani.cse@kongu.edu', 'CSE', '2018', 'B', 'Advisor', 'Not Changed'),
('CSE036SF', 'Mr.S.Santhoshkumar', 'sanvins', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'sanvins.cse@kongu.edu', 'CSE', '2019', 'D', 'Advisor', 'Not Changed'),
('CSE037SF', 'Ms.C.Sagana', 'sagana', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'sagana.c.cse@kongu.edu', 'CSE', NULL, NULL, NULL, 'Not Changed'),
('CSE038SF', 'Mr.B.Krishnakumar', 'krishnakumar', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'krishnakumar.cse@kongu.edu', 'CSE', NULL, NULL, NULL, 'Not Changed'),
('CSE039SF', 'Ms.S.Mohana Saranya', 'mohanasaranya', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'mohanasaranya.cse@kongu.edu', 'CSE', '2019', 'A', 'Advisor', 'Not Changed'),
('CSE040SF', 'Ms.S.Mohanapriya', 'mohanapriyas', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'mohanapriyas.cse@kongu.edu', 'CSE', '2019', 'C', 'Advisor', 'Not Changed'),
('CSE041SF', 'Ms.P.S.Nandhini', 'nandhini', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'nandhini.cse@kongu.edu', 'CSE', '2019', 'A', 'Advisor', 'Not Changed'),
('CSE042SF', 'Ms.K.Tamil Selvi', 'tamilselvik', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'tamilselvik.cse@kongu.edu', 'CSE', NULL, NULL, NULL, 'Not Changed'),
('CSE043SF', 'Ms.M.K.Dharani', 'dharani', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'dharani.cse@kongu.edu', 'CSE', '2019', 'D', 'Advisor', 'Not Changed'),
('CSE044SF', 'Ms.Vani Rajasekar', 'vanikecit', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'vanikecit.cse@kongu.edu', 'CSE', '2018', 'C', 'Advisor', 'Not Changed'),
('CSE045SF', 'Ms.K.Venu', 'venu', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'venu.cse@kongu.edu', 'CSE', NULL, NULL, NULL, 'Not Changed'),
('CSE046SF', 'Dr.K.Dinesh', 'dinesh', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'dinesh.cse@kongu.edu', 'CSE', '2019', 'C', 'Advisor', 'Not Changed');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `18-cse-a`
--
ALTER TABLE `18-cse-a`
  ADD PRIMARY KEY (`date`,`code`),
  ADD KEY `code` (`code`);

--
-- Indexes for table `course_list`
--
ALTER TABLE `course_list`
  ADD PRIMARY KEY (`code`,`batch`),
  ADD KEY `Staff1 Id Constraint` (`staff1`),
  ADD KEY `Staff2 Id Constraint` (`staff2`),
  ADD KEY `Staff3 ID Constraint` (`staff3`),
  ADD KEY `Staff4 ID Constraint` (`staff4`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staffid`) USING BTREE,
  ADD UNIQUE KEY `mail` (`mail`),
  ADD UNIQUE KEY `staffid` (`userid`) USING BTREE;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `18-cse-a`
--
ALTER TABLE `18-cse-a`
  ADD CONSTRAINT `18-cse-a_ibfk_1` FOREIGN KEY (`code`) REFERENCES `course_list` (`code`);

--
-- Constraints for table `course_list`
--
ALTER TABLE `course_list`
  ADD CONSTRAINT `Staff1 Id Constraint` FOREIGN KEY (`staff1`) REFERENCES `staff` (`staffid`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `Staff2 Id Constraint` FOREIGN KEY (`staff2`) REFERENCES `staff` (`staffid`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `Staff3 ID Constraint` FOREIGN KEY (`staff3`) REFERENCES `staff` (`staffid`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `Staff4 ID Constraint` FOREIGN KEY (`staff4`) REFERENCES `staff` (`staffid`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
