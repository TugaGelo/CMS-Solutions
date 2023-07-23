-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 22, 2023 at 10:40 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pupconcessionaire`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_client` (IN `p_client_id` VARCHAR(10), IN `p_name` VARCHAR(30), IN `p_company` VARCHAR(45), IN `p_address` VARCHAR(45), IN `p_contact_number` VARCHAR(15), IN `p_email` VARCHAR(25), IN `p_status` TINYINT)   BEGIN
    INSERT INTO client (
        client_id,
        name,
        company,
        address,
        contact_no,
        email,
        status
    ) VALUES (
        p_client_id,
        p_name,
        p_company,
        p_address,
        p_contact_number,
        p_email,
        p_status
    );
    INSERT INTO client_requirements (client_id)
    VALUES(p_client_id);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_concession_space` (IN `p_space_id` VARCHAR(10), IN `p_status` TINYINT(10), IN `p_date_rented` DATE, IN `p_representative` VARCHAR(45), IN `p_merch_type` VARCHAR(20))   BEGIN
    INSERT INTO `concession_space`(`space_id`, `status`, `date_rented`, `representative`, `merch_type`) 
    VALUES (p_space_id, p_status, p_date_rented, p_representative,  p_merch_type);

    IF ROW_COUNT() > 0 THEN
        INSERT INTO `space_features`(`space_id`) 
        VALUES (p_space_id);

        SELECT 'New Space successfully added!' AS message;
    ELSE
        SELECT 'Something went wrong!' AS message;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_menu` (IN `p_client_id` VARCHAR(255), IN `p_name` VARCHAR(25), IN `p_price` INT(10), IN `p_quantity` INT(10), IN `p_img` VARCHAR(25))   BEGIN
    INSERT INTO inventory (
        client_id,
        name,
        price,
        quantity,
        img
    ) VALUES (
        p_client_id,
        p_name,
        p_price,
        p_quantity,
        p_img
    );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_merch_type` (IN `p_merch_id` INT, IN `p_merch_type` VARCHAR(50))   BEGIN
    INSERT INTO merch_type(merch_id, merch_type)
    VALUES(p_merch_id, p_merch_type);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_space_features` (IN `p_space_id` VARCHAR(10), IN `p_dimension_l` DOUBLE, IN `p_dimension_w` DOUBLE, IN `p_dimension_h` DOUBLE, IN `p_capacity` INT, IN `p_lights` INT, IN `p_sinks` INT, IN `p_windows` INT, IN `p_sockets` INT)   BEGIN
    INSERT INTO `space_features`(`space_id`, `dimension_length`, `dimension_width`, `dimension_height`,
`capacity`, `lights`, `sinks`, `windows`, `sockets`)

    VALUES (p_space_id, p_dimension_l, p_dimension_w, p_dimension_h,  p_capacity, p_lights, p_sinks, p_windows, p_sockets);

    IF ROW_COUNT() > 0 THEN
        INSERT INTO `concession_space`(`space_id`) 
        VALUES (p_space_id);

        SELECT 'New Space successfully added!' AS message;
    ELSE
        SELECT 'Something went wrong!' AS message;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_student` (IN `p_stud_id` INT, IN `p_fullname` VARCHAR(255), IN `p_age` INT, IN `p_year` VARCHAR(255), IN `p_section` VARCHAR(255), IN `p_address` VARCHAR(255))   BEGIN
    INSERT INTO student (
        stud_id,
        fullname,
        age,
        year,
        section,
        address
    ) VALUES (
        p_stud_id,
        p_fullname,
        p_age,
        p_year,
        p_section,
        p_address
    );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_student_acct` (IN `p_fullname` VARCHAR(255), IN `p_username` VARCHAR(255), IN `p_password` VARCHAR(255))   BEGIN
        INSERT INTO student_login (fullname, username,  password) VALUES (p_fullname, p_username,  p_password);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_user` (IN `p_fullname` VARCHAR(50), IN `p_username` VARCHAR(10), IN `p_email` VARCHAR(50), IN `p_password` VARCHAR(255), IN `p_role` SET('admin','client'))   BEGIN
    IF p_role = 'client' THEN
        INSERT INTO client_login (fullname, username, email, password, role) VALUES (p_fullname, p_username, p_email, p_password, p_role);
    ELSEIF p_role = 'admin' THEN
        INSERT INTO admin_login (fullname, username, email, password, role) VALUES (p_fullname, p_username, p_email, p_password, p_role);
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_assigned_space` (IN `p_client_id` INT)   BEGIN
    DELETE FROM assigned_space WHERE client_id = p_client_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_client` (IN `id` INT)   BEGIN
    DELETE FROM client WHERE id = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_client_requirements` (IN `p_client_id` INT)   BEGIN
    DELETE FROM client_requirements WHERE client_id = p_client_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_merch_type` (IN `did` INT)   BEGIN
    DELETE FROM merch_type WHERE merch_id = did;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_space_features` (IN `conspace_id` INT)   BEGIN
    DELETE FROM `space_features` WHERE `space_id` = conspace_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_assigned_space` (IN `client_id` VARCHAR(10), IN `space_id` VARCHAR(10))   BEGIN
    INSERT INTO `assigned_space`(`client_id`, `space_id`) 
    VALUES (client_id, space_id);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_space_bill` (IN `p_bill_id` VARCHAR(50), IN `p_client_id` VARCHAR(10), IN `p_space_id` VARCHAR(10), IN `p_rent_bill` DOUBLE, IN `p_misc_bill` DOUBLE, IN `p_penalty` DOUBLE, IN `p_security_dep` DOUBLE)   BEGIN
    INSERT INTO space_bill (bill_id, client_id, space_id, rent_bill, misc_bill, penalty, security_dep, space_bill)
    VALUES (p_bill_id, p_client_id, p_space_id, p_rent_bill, p_misc_bill, p_penalty, p_security_dep, (p_rent_bill + p_misc_bill + p_penalty + p_security_dep));

    INSERT INTO electric_bill (bill_id, client_id, space_id)
    VALUES (p_bill_id, p_client_id, p_space_id);

    INSERT INTO water_bill (bill_id, client_id, space_id)
    VALUES (p_bill_id, p_client_id, p_space_id);

    INSERT INTO total_bill (bill_id, client_id, space_id, s_bill)
    VALUES (p_bill_id, p_client_id, p_space_id, (p_rent_bill + p_misc_bill + p_penalty + p_security_dep));
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_user` (IN `p_fullname` VARCHAR(50), IN `p_username` VARCHAR(10), IN `p_email` VARCHAR(50), IN `p_password` VARCHAR(255), IN `p_role` SET('admin','client'))   BEGIN
    IF p_role = 'client' THEN
        INSERT INTO client_login (fullname, username, email, password, role) VALUES (p_fullname, p_username, p_email, p_password, p_role);
    ELSEIF p_role = 'admin' THEN
        INSERT INTO admin_login (fullname, username, email, password, role) VALUES (p_fullname, p_username, p_email, p_password, p_role);
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateAdminLogin` (IN `in_fullname` VARCHAR(50), IN `in_email` VARCHAR(50), IN `in_username` VARCHAR(10))   BEGIN
  UPDATE admin_login SET fullname = in_fullname, email = in_email WHERE username = in_username;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateAdminPassword` (IN `in_new_password` VARCHAR(255), IN `in_id` INT)   BEGIN
  UPDATE admin_login SET password = in_new_password WHERE id = in_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateClientPassword` (IN `in_new_password` VARCHAR(255), IN `in_id` INT)   BEGIN
  UPDATE client_login SET password = in_new_password WHERE id = in_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_assigned_space` (IN `space_id` VARCHAR(10), IN `eid` INT)   BEGIN
    UPDATE assigned_space SET space_id = space_id WHERE client_id = eid;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_client` (IN `p_client_id` VARCHAR(10), IN `p_name` VARCHAR(30), IN `p_company` VARCHAR(45), IN `p_address` VARCHAR(45), IN `p_contact_number` VARCHAR(15), IN `p_email` VARCHAR(25), IN `p_status` TINYINT)   BEGIN
    UPDATE client
    SET name = p_name, company = p_company, address = p_address, contact_no = p_contact_number, email = p_email, status = p_status
    WHERE client_id = p_client_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_electric_bill` (IN `eid` VARCHAR(50), IN `prev_reading` DOUBLE, IN `reading` DOUBLE, IN `rate` DOUBLE)   BEGIN
  UPDATE electric_bill SET
	`prev_reading` = prev_reading,
    `reading` = reading,
    `rate` = rate,
    `electric_bill` = (rate * reading)
  WHERE bill_id = eid;
  
  IF ROW_COUNT() > 0 THEN
    UPDATE total_bill SET
      `e_bill` = (rate * reading)
    WHERE bill_id = eid;

    SELECT 'Update successfully!' AS message;
  ELSE
    SELECT 'Something went wrong!' AS message;
  END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_merch_type` (IN `eid` INT, IN `merch_type` VARCHAR(50))   BEGIN
    UPDATE `merch_type` SET `merch_type`= merch_type WHERE merch_id=eid;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_space_bill` (IN `eid` VARCHAR(10), IN `rent_bill` DOUBLE, IN `misc_bill` DOUBLE, IN `penalty` DOUBLE, IN `security_dep` DOUBLE)   BEGIN
    UPDATE space_bill SET rent_bill = rent_bill, misc_bill = misc_bill, penalty = penalty, security_dep = security_dep, space_bill = rent_bill + misc_bill + penalty + security_dep WHERE bill_id = eid;
    UPDATE total_bill SET space_bill = rent_bill + misc_bill + penalty + security_dep WHERE bill_id = eid;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_space_features` (IN `sf_id` VARCHAR(10), IN `dimension_length` DOUBLE, IN `dimension_width` DOUBLE, IN `dimension_height` DOUBLE, IN `capacity` INT, IN `lights` INT, IN `sinks` INT, IN `windows` INT, IN `sockets` INT)   BEGIN
    UPDATE `space_features`
    SET `dimension_length` = dimension_length,
        `dimension_width` = dimension_width,
        `dimension_height` = dimension_height,
        `capacity` = capacity,
        `lights` = lights,
        `sinks` = sinks,
        `windows` = windows,
        `sockets` = sockets
    WHERE space_id = sf_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_total_bill` (IN `eid` VARCHAR(10), IN `due_date` DATE)   BEGIN
  UPDATE total_bill SET due_date = due_date WHERE bill_id = eid;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_water_bill` (IN `eid` VARCHAR(50), IN `prev_reading` DOUBLE, IN `reading` DOUBLE, IN `rate` DOUBLE)   BEGIN
    UPDATE water_bill SET 
		`prev_reading` = prev_reading,
        `reading` = reading,
        `rate` = rate,
        `water_bill` = (rate * reading)
    WHERE bill_id = `eid`;

    IF ROW_COUNT() > 0 THEN
        UPDATE total_bill SET 
            `w_bill` = (rate * reading)
        WHERE bill_id = eid;
    SELECT 'Update successfully!' AS message;
  ELSE
    SELECT 'Something went wrong!' AS message;
  END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin_login`
--

CREATE TABLE `admin_login` (
  `id` int(11) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` set('admin') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_login`
--

INSERT INTO `admin_login` (`id`, `fullname`, `email`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'lalisa Manobal', 'lalisa@gmail.com', 'lalisa', '$2y$10$S0ZgDckS2evaGOTxp72r0eI/arXfVNQGcaz4GmFAe6e69Py.SrRH2', 'admin', '2023-02-20 14:45:03');

-- --------------------------------------------------------

--
-- Table structure for table `archive`
--

CREATE TABLE `archive` (
  `client_id` varchar(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `company` varchar(45) NOT NULL,
  `address` varchar(45) NOT NULL,
  `contact_no` varchar(15) NOT NULL,
  `email` varchar(25) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `archive_space`
--

CREATE TABLE `archive_space` (
  `space_id` varchar(10) NOT NULL,
  `dimension_length` double NOT NULL,
  `dimension_width` double NOT NULL,
  `dimension_height` double NOT NULL,
  `capacity` int(11) NOT NULL,
  `lights` int(11) NOT NULL,
  `sinks` int(11) NOT NULL,
  `windows` int(11) NOT NULL,
  `sockets` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `assigned_space`
--

CREATE TABLE `assigned_space` (
  `client_id` varchar(10) NOT NULL,
  `space_id` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assigned_space`
--

INSERT INTO `assigned_space` (`client_id`, `space_id`) VALUES
('roses', 'SPACE1');

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `client_id` varchar(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `company` varchar(45) NOT NULL,
  `address` varchar(45) NOT NULL,
  `contact_no` varchar(15) NOT NULL,
  `email` varchar(25) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`client_id`, `name`, `company`, `address`, `contact_no`, `email`, `status`) VALUES
('jane', 'Jane Doe', 'Jane Doe Corps', 'Polo Brewery Plant 1400 Valenzuela, Philippin', '09971051234', 'janedoe@gmail.ccom', 1),
('john', 'John Doe', 'john doe corps', 'somewhere', '12312312311', 'johndoe@gmail.com', 0),
('roses', 'rose park', 'accenture', 'bgc', '0913231232', 'roses@gmail.com', 0);

--
-- Triggers `client`
--
DELIMITER $$
CREATE TRIGGER `archive_client` AFTER DELETE ON `client` FOR EACH ROW INSERT INTO archive
VALUES(old.client_id, old.name, old.company, old.address, old.contact_no, old.email, 0, now())
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `client_login`
--

CREATE TABLE `client_login` (
  `id` int(11) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` set('client') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `client_login`
--

INSERT INTO `client_login` (`id`, `fullname`, `email`, `username`, `password`, `role`, `created_at`) VALUES
(4, 'rose park', 'roses@gmail.com', 'roses', '$2y$10$s2i6e5ym9HZWKLWbTptzgOUJY97Jalxo54jZAPe28wEfiPwPUKAc2', 'client', '2023-02-23 11:49:23'),
(7, 'John Doe', 'johndoe@gmail.com', 'john', '$2y$10$6.MNmSaaAcwwzV4XErZpCea3qx/ELJFOMjHuyV7yKc22b0NoBJQSe', 'client', '2023-07-22 05:43:34');

-- --------------------------------------------------------

--
-- Table structure for table `client_requirements`
--

CREATE TABLE `client_requirements` (
  `id` int(11) NOT NULL,
  `client_id` varchar(10) NOT NULL,
  `health_clr` varchar(15) DEFAULT NULL COMMENT '1 = available\\r\\n0 = not available',
  `mayors_prm` varchar(15) DEFAULT NULL COMMENT '1 = available\\r\\n0 = not available',
  `bir` varchar(15) DEFAULT NULL COMMENT '1 = available\\r\\n0 = not available',
  `sss` varchar(15) DEFAULT NULL COMMENT '1 = available\\r\\n0 = not available',
  `philhealth` varchar(15) DEFAULT NULL COMMENT '1 = available\\r\\n0 = not available',
  `pag_ibig` varchar(15) DEFAULT NULL COMMENT '1 = available\\r\\n0 = not available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `client_requirements`
--

INSERT INTO `client_requirements` (`id`, `client_id`, `health_clr`, `mayors_prm`, `bir`, `sss`, `philhealth`, `pag_ibig`) VALUES
(2, 'roses', 'Denied', 'Approved', 'Pending', 'Pending', 'Pending', 'Pending'),
(4, 'john', NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'jane', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `concession_space`
--

CREATE TABLE `concession_space` (
  `space_id` varchar(10) NOT NULL,
  `status` tinyint(10) NOT NULL,
  `date_rented` date NOT NULL,
  `merch_type` varchar(20) NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `concession_space`
--

INSERT INTO `concession_space` (`space_id`, `status`, `date_rented`, `merch_type`, `price`) VALUES
('SPACE1', 0, '2023-02-23', '1', 2000),
('SPACE1', 0, '2023-02-23', '1', 2000),
('SPACE2', 0, '0000-00-00', '', 0),
('SPACE3', 0, '0000-00-00', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `electric_bill`
--

CREATE TABLE `electric_bill` (
  `bill_id` varchar(50) NOT NULL,
  `client_id` varchar(10) DEFAULT NULL,
  `space_id` varchar(10) DEFAULT NULL,
  `prev_reading` double NOT NULL,
  `reading` double NOT NULL,
  `rate` double NOT NULL,
  `electric_bill` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `electric_bill`
--

INSERT INTO `electric_bill` (`bill_id`, `client_id`, `space_id`, `prev_reading`, `reading`, `rate`, `electric_bill`) VALUES
('bl001', 'roses', 'SPACE1', 0, 15, 10, 150),
('bl001', 'roses', 'SPACE1', 0, 15, 10, 150),
('bl002', 'jane', 'SPACE3', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `inventory_id` int(5) NOT NULL,
  `client_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `quantity` int(5) NOT NULL,
  `img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`inventory_id`, `client_id`, `name`, `price`, `quantity`, `img`) VALUES
(13, 'roses', 'Hotdog', 25, 30, 'upload/HotDog.jpg'),
(14, 'roses', 'Fries', 20, 50, 'upload/fries.jpg'),
(15, 'roses', 'Burger', 25, 50, 'upload/burger.jpg'),
(16, 'john', 'Fruit Shake', 20, 50, 'upload/shake.jpg'),
(17, 'john', 'Tea', 20, 50, 'upload/tea.jpg'),
(18, 'john', 'Coffee', 20, 50, 'upload/coffee.jpg'),
(19, 'roses', 'Sandwich', 25, 50, 'upload/sandwich.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `merch_type`
--

CREATE TABLE `merch_type` (
  `merch_id` int(11) NOT NULL,
  `merch_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `merch_type`
--

INSERT INTO `merch_type` (`merch_id`, `merch_type`) VALUES
(1, 'foods'),
(2, 'souvenir'),
(3, 'drinks');

-- --------------------------------------------------------

--
-- Table structure for table `space_bill`
--

CREATE TABLE `space_bill` (
  `bill_id` varchar(50) NOT NULL,
  `client_id` varchar(10) NOT NULL,
  `space_id` varchar(10) NOT NULL,
  `rent_bill` double NOT NULL,
  `misc_bill` double NOT NULL,
  `penalty` double NOT NULL,
  `security_dep` double NOT NULL,
  `space_bill` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `space_bill`
--

INSERT INTO `space_bill` (`bill_id`, `client_id`, `space_id`, `rent_bill`, `misc_bill`, `penalty`, `security_dep`, `space_bill`) VALUES
('bl001', 'roses', 'SPACE1', 5000, 50, 260, 10000, 15310),
('bl002', 'jane', 'SPACE3', 5000, 5000, 500, 5000, 15500);

-- --------------------------------------------------------

--
-- Table structure for table `space_features`
--

CREATE TABLE `space_features` (
  `space_id` varchar(10) NOT NULL,
  `dimension_length` double NOT NULL,
  `dimension_width` double NOT NULL,
  `dimension_height` double NOT NULL,
  `capacity` int(11) NOT NULL,
  `lights` int(11) NOT NULL,
  `sinks` int(11) NOT NULL,
  `windows` int(11) NOT NULL,
  `sockets` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `space_features`
--

INSERT INTO `space_features` (`space_id`, `dimension_length`, `dimension_width`, `dimension_height`, `capacity`, `lights`, `sinks`, `windows`, `sockets`) VALUES
('SPACE1', 11, 10, 10, 5, 2, 2, 2, 3),
('SPACE2', 10, 10, 10, 20, 10, 1, 5, 5),
('SPACE3', 10, 10, 10, 10, 10, 1, 10, 10);

--
-- Triggers `space_features`
--
DELIMITER $$
CREATE TRIGGER `archive_sf` AFTER DELETE ON `space_features` FOR EACH ROW INSERT INTO archive_space
VALUES(old.space_id, old.dimension_length, old.dimension_width, old.dimension_height, old.capacity, old.lights, old.sinks, old.windows, old.sockets)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `stud_id` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `year` varchar(255) NOT NULL,
  `section` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`stud_id`, `fullname`, `age`, `year`, `section`, `address`) VALUES
('2020-12345-AB-0', 'Jane Doe', 21, '3', 'BSIT', 'Polo Brewery Plant 1400 Valenzuela, Philippines');

-- --------------------------------------------------------

--
-- Table structure for table `student_login`
--

CREATE TABLE `student_login` (
  `stud_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_login`
--

INSERT INTO `student_login` (`stud_id`, `username`, `password`, `fullname`) VALUES
(1, 'johndoe', '$2y$10$zh84nKClKNsbNyMQP0SLVulTkOnKbUGYWYbB47q/7otiOziXyS8OG', 'John Doe'),
(2, 'janedoe', '$2y$10$e7QBHzXx22KES5dn6pJ1UuH4aWdT2x2UykzbVbcrCtsnn4trcPNuK', 'Jane Doe');

-- --------------------------------------------------------

--
-- Table structure for table `total_bill`
--

CREATE TABLE `total_bill` (
  `bill_id` varchar(50) NOT NULL,
  `e_bill` double NOT NULL,
  `w_bill` double NOT NULL,
  `s_bill` double NOT NULL,
  `due_date` varchar(50) NOT NULL,
  `total_bill` double NOT NULL,
  `client_id` varchar(10) NOT NULL,
  `space_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `total_bill`
--

INSERT INTO `total_bill` (`bill_id`, `e_bill`, `w_bill`, `s_bill`, `due_date`, `total_bill`, `client_id`, `space_id`) VALUES
('bl001', 150, 225, 15310, '2023-02-28', 15685, 'roses', 'SPACE1'),
('bl002', 0, 0, 15500, '', 0, 'jane', 'SPACE3');

-- --------------------------------------------------------

--
-- Table structure for table `water_bill`
--

CREATE TABLE `water_bill` (
  `bill_id` varchar(50) NOT NULL,
  `client_id` varchar(10) DEFAULT NULL,
  `space_id` varchar(10) DEFAULT NULL,
  `prev_reading` double NOT NULL,
  `reading` double NOT NULL,
  `rate` double NOT NULL,
  `water_bill` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `water_bill`
--

INSERT INTO `water_bill` (`bill_id`, `client_id`, `space_id`, `prev_reading`, `reading`, `rate`, `water_bill`) VALUES
('bl001', 'roses', 'SPACE1', 0, 5, 45, 225),
('bl002', 'jane', 'SPACE3', 0, 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_login`
--
ALTER TABLE `admin_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assigned_space`
--
ALTER TABLE `assigned_space`
  ADD KEY `aspace_id` (`client_id`),
  ADD KEY `asfeatures` (`space_id`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `client_login`
--
ALTER TABLE `client_login`
  ADD PRIMARY KEY (`id`),
  ADD KEY `login_username` (`username`);

--
-- Indexes for table `client_requirements`
--
ALTER TABLE `client_requirements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clientid_reqs` (`client_id`);

--
-- Indexes for table `concession_space`
--
ALTER TABLE `concession_space`
  ADD KEY `csfeature` (`space_id`);

--
-- Indexes for table `electric_bill`
--
ALTER TABLE `electric_bill`
  ADD KEY `eclient` (`client_id`),
  ADD KEY `espace` (`space_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`inventory_id`);

--
-- Indexes for table `merch_type`
--
ALTER TABLE `merch_type`
  ADD PRIMARY KEY (`merch_id`);

--
-- Indexes for table `space_bill`
--
ALTER TABLE `space_bill`
  ADD KEY `sclient` (`client_id`),
  ADD KEY `sspace` (`space_id`);

--
-- Indexes for table `space_features`
--
ALTER TABLE `space_features`
  ADD PRIMARY KEY (`space_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`stud_id`);

--
-- Indexes for table `student_login`
--
ALTER TABLE `student_login`
  ADD PRIMARY KEY (`stud_id`);

--
-- Indexes for table `total_bill`
--
ALTER TABLE `total_bill`
  ADD KEY `tconspace` (`space_id`),
  ADD KEY `tclientid` (`client_id`);

--
-- Indexes for table `water_bill`
--
ALTER TABLE `water_bill`
  ADD KEY `wclient` (`client_id`),
  ADD KEY `wspace` (`space_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_login`
--
ALTER TABLE `admin_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `client_login`
--
ALTER TABLE `client_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `client_requirements`
--
ALTER TABLE `client_requirements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `inventory_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `merch_type`
--
ALTER TABLE `merch_type`
  MODIFY `merch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `student_login`
--
ALTER TABLE `student_login`
  MODIFY `stud_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assigned_space`
--
ALTER TABLE `assigned_space`
  ADD CONSTRAINT `asfeatures` FOREIGN KEY (`space_id`) REFERENCES `concession_space` (`space_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `aspace_id` FOREIGN KEY (`client_id`) REFERENCES `client` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `client_login`
--
ALTER TABLE `client_login`
  ADD CONSTRAINT `login_username` FOREIGN KEY (`username`) REFERENCES `client` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `concession_space`
--
ALTER TABLE `concession_space`
  ADD CONSTRAINT `csfeature` FOREIGN KEY (`space_id`) REFERENCES `space_features` (`space_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
