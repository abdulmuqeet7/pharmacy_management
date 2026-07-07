-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 07, 2026 at 10:52 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pharmacy_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `CUSTOMER`
--

CREATE TABLE `CUSTOMER` (
  `CID` int(11) NOT NULL,
  `C_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `CUSTOMER`
--

INSERT INTO `CUSTOMER` (`CID`, `C_name`) VALUES
(1, 'Rahul Sharma'),
(2, 'Priya Singh'),
(6, 'Sunita Patel'),
(10, 'kushp'),
(13, 'King Gupta'),
(14, 'krish'),
(16, 'lab1'),
(19, 'ertsr'),
(20, 'labTA1'),
(21, 'labta2');

-- --------------------------------------------------------

--
-- Table structure for table `DELIVERY_AGENT`
--

CREATE TABLE `DELIVERY_AGENT` (
  `AGENT_ID` int(11) NOT NULL,
  `agent_name` varchar(50) DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `vehicle_no` varchar(20) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `DELIVERY_AGENT`
--

INSERT INTO `DELIVERY_AGENT` (`AGENT_ID`, `agent_name`, `salary`, `vehicle_no`, `status`) VALUES
(5, 'Rohan Desai', 18000.00, 'MH12AB1234', 'active'),
(9, 'Mahesh Gupta', 20000.00, 'DL10CD9988', 'active'),
(18, 'KrishnaWhistle', 1000.00, '24BCS005', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `LAB_REPORT`
--

CREATE TABLE `LAB_REPORT` (
  `report_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `pathologist_id` int(11) DEFAULT NULL,
  `report_date` date DEFAULT NULL,
  `result` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `LAB_REPORT`
--

INSERT INTO `LAB_REPORT` (`report_id`, `customer_id`, `test_id`, `pathologist_id`, `report_date`, `result`) VALUES
(1, 10, 1, 4, '2025-11-30', 'Fail'),
(2, 10, 2, NULL, '2025-11-30', 'Pending'),
(3, 10, 2, NULL, '2025-11-30', 'Pending'),
(4, 10, 2, 4, '2025-11-30', 'Fail'),
(5, 10, 2, 4, '2025-11-30', 'Fail'),
(6, 10, 2, 4, '2025-11-30', 'Fail'),
(7, 10, 2, 4, '2025-11-30', 'Pass'),
(8, 10, 1, 4, '2025-11-30', 'Pass'),
(9, 6, 1, NULL, NULL, NULL),
(10, 6, 2, NULL, NULL, NULL),
(11, 6, 2, NULL, NULL, NULL),
(12, 6, 2, NULL, NULL, NULL),
(13, 6, 2, NULL, NULL, NULL),
(14, 6, 2, 8, NULL, NULL),
(15, 1, 2, 8, NULL, NULL),
(16, 1, 3, 8, NULL, NULL),
(17, 1, 6, 8, '2025-11-30', 'Pass'),
(18, 1, 4, 4, '2025-11-30', 'Pass'),
(19, 13, 3, 4, '2025-12-01', 'Pass'),
(20, 13, 1, NULL, '2025-12-01', 'Pending'),
(21, 1, 9, 8, '2025-12-01', 'Fail'),
(22, 1, 6, 8, '2025-12-01', 'Pending'),
(23, 1, 2, 8, '2025-12-01', 'Pass'),
(24, 1, 1, NULL, '2025-12-16', 'Pending'),
(25, 2, 3, NULL, '2026-07-07', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `LAB_TEST`
--

CREATE TABLE `LAB_TEST` (
  `test_id` int(11) NOT NULL,
  `test_name` varchar(100) NOT NULL,
  `test_type` varchar(50) DEFAULT NULL,
  `test_cost` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `LAB_TEST`
--

INSERT INTO `LAB_TEST` (`test_id`, `test_name`, `test_type`, `test_cost`, `description`) VALUES
(1, 'Complete Blood Count (CBC)', 'Blood Test', 350.00, 'A CBC measures red cells, white cells, platelets, hemoglobin, and detects infections or anemia.'),
(2, 'Thyroid Profile (T3, T4, TSH)', 'Hormone Test', 650.00, 'Evaluates thyroid gland function and detects hyperthyroidism or hypothyroidism.'),
(3, 'Liver Function Test (LFT)', 'Blood Test', 500.00, 'Checks enzymes, bilirubin, protein levels to identify liver diseases.'),
(4, 'Kidney Function Test (KFT)', 'Blood Test', 600.00, 'Analyzes urea, creatinine, electrolytes to assess kidney performance.'),
(5, 'Fasting Blood Sugar (FBS)', 'Diabetes', 120.00, 'Measures blood glucose levels after fasting to detect diabetes.'),
(6, 'HbA1c Test', 'Diabetes', 450.00, 'Shows 3-month average glucose level; essential for diabetic monitoring.'),
(7, 'Vitamin D Test', 'Vitamin Test', 750.00, 'Measures Vitamin D levels to detect deficiencies causing bone disorders.'),
(8, 'Lipid Profile', 'Cholesterol Test', 700.00, 'Measures HDL, LDL, triglycerides to evaluate heart disease risk.'),
(9, 'Urine Routine Test', 'Urine Test', 150.00, 'Checks infection, sugar, protein levels through microscopic urine examination.'),
(10, 'COVID-19 RT-PCR', 'Virus Detection', 1200.00, 'Highly accurate test to detect active COVID-19 infection.');

-- --------------------------------------------------------

--
-- Table structure for table `MEDICINE`
--

CREATE TABLE `MEDICINE` (
  `med_id` int(11) NOT NULL,
  `med_name` varchar(50) DEFAULT NULL,
  `dosage` varchar(30) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `MEDICINE`
--

INSERT INTO `MEDICINE` (`med_id`, `med_name`, `dosage`, `qty`, `category`, `image_url`, `description`, `expiry_date`, `price`) VALUES
(1, 'dolo', '12', 1, 'headac', 'dolo.jpg', 'nice', '2007-02-01', 23.00),
(101, 'Paracetamol', '500mg', 184, 'Painkiller', 'paracetamol.jpg', 'Used for fever and mild pain relief', '2025-12-31', 20.00),
(102, 'Amoxicillin', '250mg', 207, 'Antibiotic', 'amoxicillin.jpg', 'Broad-spectrum antibiotic', '2026-05-20', 45.00),
(103, 'Cetirizine', '10mg', 274, 'Allergy', 'cetirizine.jpg', 'Used for cold, cough, and allergies', '2026-03-10', 15.00),
(104, 'Ibuprofen', '400mg', 175, 'Painkiller', 'ibuprofen.jpg', 'Anti-inflammatory and pain relief', '2025-11-15', 30.00),
(105, 'Metformin', '500mg', 249, 'Diabetes', 'metformin.jpg', 'Used to control blood sugar levels', '2027-01-01', 55.00),
(106, 'Vitamin C', '1000mg', 408, 'Supplement', 'vitaminC.jpg', 'Boosts immunity', '2026-08-08', 10.00),
(107, 'Polo', '20', 200, 'Cold', 'polo.jpg', 'tablet,for children', '2025-12-26', 200.00),
(108, 'Polo12', 'add', 124, 'headace', 'https://static2.medplusmart.com/products/POLO0001_L.jpg', 'efsasaf', '2025-12-18', 100.00);

-- --------------------------------------------------------

--
-- Table structure for table `PATHOLOGIST`
--

CREATE TABLE `PATHOLOGIST` (
  `PATH_ID` int(11) NOT NULL,
  `qualification` varchar(30) DEFAULT NULL,
  `lab_name` varchar(100) DEFAULT NULL,
  `pathologist_name` varchar(100) DEFAULT NULL,
  `licence` varchar(50) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `PATHOLOGIST`
--

INSERT INTO `PATHOLOGIST` (`PATH_ID`, `qualification`, `lab_name`, `pathologist_name`, `licence`, `start_date`, `status`) VALUES
(4, 'MSc Pathology', 'Metro Diagnostic', 'Dr. Meera Nair', 'LIC-9988', '2019-09-12', 'active'),
(8, 'BSc Microbiology', 'Apollo Diagnostic Center', 'Dr. Kavita Rao', 'LIC-7788', '2020-03-20', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `PHARMACIST`
--

CREATE TABLE `PHARMACIST` (
  `PHID` int(11) NOT NULL,
  `licence` varchar(50) DEFAULT NULL,
  `qualifications` varchar(100) DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `PHARMACIST`
--

INSERT INTO `PHARMACIST` (`PHID`, `licence`, `qualifications`, `salary`, `start_date`, `status`) VALUES
(3, 'PH-1122', 'B.Pharm', 35000.00, '2021-04-10', 'active'),
(7, 'PH-2211', 'D.Pharm', 30000.00, '2022-01-12', 'inactive'),
(17, '100', 'NA', 2000.00, '2025-12-05', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `REPORT_ASSIGNMENT`
--

CREATE TABLE `REPORT_ASSIGNMENT` (
  `assign_id` int(11) NOT NULL,
  `report_id` int(11) NOT NULL,
  `pharmacist_id` int(11) DEFAULT NULL,
  `pathologist_id` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `assigned_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `REPORT_ASSIGNMENT`
--

INSERT INTO `REPORT_ASSIGNMENT` (`assign_id`, `report_id`, `pharmacist_id`, `pathologist_id`, `status`, `assigned_date`) VALUES
(1, 1, 3, 4, 'pending', '2025-11-30 16:23:34'),
(2, 14, NULL, 8, 'pending', '2025-11-30 16:48:15'),
(3, 15, NULL, 8, 'pending', '2025-11-30 17:01:07'),
(4, 16, NULL, 8, 'pending', '2025-11-30 17:05:15');

-- --------------------------------------------------------

--
-- Table structure for table `SALES`
--

CREATE TABLE `SALES` (
  `sale_id` int(11) NOT NULL,
  `sale_date` date NOT NULL,
  `payment_method` varchar(20) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `med_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `SALES`
--

INSERT INTO `SALES` (`sale_id`, `sale_date`, `payment_method`, `total_amount`, `customer_id`, `med_id`) VALUES
(1, '2025-11-30', 'COD', 30.00, 10, 104),
(2, '2025-11-30', 'COD', 40.00, 10, 101),
(3, '2025-11-30', 'COD', 20.00, 10, 101),
(4, '2025-11-30', 'COD', 90.00, 2, 104),
(5, '2025-11-30', 'COD', 20.00, 1, 101),
(6, '2025-11-30', 'COD', 20.00, 1, 101),
(7, '2025-11-30', 'COD', 20.00, 1, 101),
(8, '2025-11-30', 'COD', 15.00, 1, 103),
(9, '2025-11-30', 'COD', 15.00, 1, 103),
(10, '2025-11-30', 'COD', 30.00, 1, 104),
(11, '2025-11-30', 'COD', 55.00, 1, 105),
(12, '2025-11-30', 'COD', 345.00, 1, 103),
(13, '2025-12-01', 'COD', 45.00, 10, 102),
(14, '2025-12-01', 'COD', 200.00, 14, 106),
(15, '2025-12-01', 'COD', 100.00, 1, 106),
(16, '2025-12-01', 'COD', 200.00, 1, 101),
(17, '2025-12-01', 'COD', 120.00, 16, 106),
(18, '2025-12-01', 'COD', 540.00, 20, 102),
(19, '2025-12-01', 'COD', 200.00, 21, 106),
(20, '2025-12-01', 'COD', 300.00, 21, 106),
(21, '2025-12-16', 'COD', 437.00, 1, 1),
(22, '2026-07-07', 'COD', 400.00, 2, 101);

-- --------------------------------------------------------

--
-- Table structure for table `SHIPMENT`
--

CREATE TABLE `SHIPMENT` (
  `shipment_id` int(11) NOT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `pharmacist_id` int(11) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `expected_date` date DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `shipment_address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `SHIPMENT`
--

INSERT INTO `SHIPMENT` (`shipment_id`, `sale_id`, `pharmacist_id`, `agent_id`, `expected_date`, `status`, `shipment_address`) VALUES
(3, 9, 3, 9, '2025-12-06', 'Delivered', 'Delhi'),
(4, 10, 3, 5, '2025-12-06', 'Delivered', 'Delhi'),
(5, 11, 3, 9, '2025-12-06', 'Delivered', 'Delhi'),
(6, 12, NULL, NULL, '2025-12-06', 'Pending Assignment', 'Delhi'),
(7, 13, NULL, NULL, '2025-12-06', 'Pending Assignment', 'jabalpur'),
(8, 14, 3, 5, '2025-12-06', 'Delivered', 'Sagar'),
(9, 15, 3, 9, '2025-12-06', 'Delivered', 'Delhi'),
(10, 16, NULL, NULL, '2025-12-06', 'Pending Assignment', 'Delhi'),
(11, 17, 17, 9, '2025-12-06', 'Assigned', 'jabalpur'),
(12, 18, NULL, NULL, '2025-12-06', 'Pending Assignment', 'Jabalpur'),
(13, 19, NULL, NULL, '2025-12-06', 'Pending Assignment', 'ghar'),
(14, 20, 3, 9, '2025-12-06', 'Delivered', 'ghar'),
(15, 21, NULL, NULL, '2025-12-21', 'Pending Assignment', 'Delhi'),
(16, 22, NULL, NULL, '2026-07-12', 'Pending Assignment', 'Mumbai');

--
-- Triggers `SHIPMENT`
--
DELIMITER $$
CREATE TRIGGER `trg_set_expected_date` BEFORE INSERT ON `SHIPMENT` FOR EACH ROW BEGIN
    IF NEW.expected_date IS NULL THEN
        SET NEW.expected_date = CURDATE() + INTERVAL 5 DAY;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `SUPPLIER`
--

CREATE TABLE `SUPPLIER` (
  `supplier_id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `contact_no` varchar(15) DEFAULT NULL,
  `license_no` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `SUPPLIER`
--

INSERT INTO `SUPPLIER` (`supplier_id`, `name`, `address`, `city`, `contact_no`, `license_no`) VALUES
(301, 'HealthMed Distributors', 'Sector 22', 'Delhi', '9988771122', 'LIC-SUP-1122'),
(302, 'LifeCare Pharma', 'Andheri West', 'Mumbai', '8877665522', 'LIC-SUP-2233'),
(303, 'Wellness Wholesale', 'T Nagar', 'Chennai', '7766554411', 'LIC-SUP-3344'),
(304, 'King Pharm', 'Wali Road', 'Kurnool', '8912345670', 'LIC-SUP-6767');

-- --------------------------------------------------------

--
-- Table structure for table `SUPPLY`
--

CREATE TABLE `SUPPLY` (
  `supply_id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `med_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `supply_date` date DEFAULT NULL,
  `pharmacist_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `SUPPLY`
--

INSERT INTO `SUPPLY` (`supply_id`, `supplier_id`, `med_id`, `quantity`, `supply_date`, `pharmacist_id`) VALUES
(1, 302, 0, 20, '2025-11-30', 3),
(401, 301, 101, 100, '2024-01-05', 3),
(402, 302, 103, 150, '2024-01-08', 3),
(403, 303, 105, 200, '2024-01-10', 7),
(404, 301, 106, 300, '2024-01-15', 3),
(405, 302, 102, 120, '2024-01-18', 7),
(406, 301, 107, 200, '2025-12-01', 3),
(408, 301, 102, 20, '2025-12-01', 3),
(409, 301, 102, 20, '2025-12-01', 3),
(410, 301, 102, 30, '2025-12-01', 3),
(411, 304, 108, 124, '2025-12-01', 3);

-- --------------------------------------------------------

--
-- Table structure for table `USERS`
--

CREATE TABLE `USERS` (
  `UID` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `USERS`
--

INSERT INTO `USERS` (`UID`, `name`, `gender`, `phone`, `email`, `password`, `role`, `address`, `status`) VALUES
(1, 'Rahul Sharma', 'Male', '9160110804', 'rahul@gmail.com', '134', 'customer', 'Delhi', 'active'),
(2, 'Priya Singh', 'Female', '9848952007', 'priya@gmail.com', '1234', 'customer', 'Mumbai', 'active'),
(3, 'Amit Verma', 'Male', '9866238063', 'amit@gmail.com', '1234', 'pharmacist', 'Chennai', 'active'),
(4, 'Dr. Meera Nair', 'Female', '7848952007', 'meera@gmail.com', '1234', 'pathologist', 'Hyderabad', 'active'),
(5, 'Rohan Desai', 'Male', '9822345623', 'rohan@gmail.com', '1234', 'delivery_agent', 'Pune', 'active'),
(6, 'Sunita Patel', 'Female', '9999999999', 'sunita@gmail.com', '1234', 'customer', 'Bangalore', 'active'),
(7, 'Akash Kumar', 'Male', '8344323627', 'akash@gmail.com', '1234', 'pharmacist', 'Delhi', 'inactive'),
(8, 'Dr. Kavita Rao', 'Female', '8823499234', 'kavita@gmail.com', '1234', 'pathologist', 'Mumbai', 'active'),
(9, 'Mahesh Gupta', 'Male', '7848294001', 'mahesh@gmail.com', '1234', 'delivery_agent', 'Chennai', 'active'),
(10, 'kushp', 'Male', '9824500112', 'kushp@gmail.com', 'kush123', 'customer', 'jabalpur', 'active'),
(11, 'Admin', 'Other', '8097380645', 'admin@medhelp.com', 'admin123', 'admin', 'Head Office', 'active'),
(13, 'King Gupta', 'Male', '8882389043', 'king@gmail.com', '1234', 'customer', 'Varansi', 'active'),
(14, 'krish', 'Male', '8153212346', 'krish@gmail.com', '1234', 'customer', 'Sagar', 'active'),
(16, 'lab1', 'Male', '9855238063', 'lab1@gmail.com', '1234', 'customer', 'jabalpur', 'active'),
(17, 'krishnarai', 'Male', '9705042620', 'krishrai@gmail.com', '1234', 'pharmacist', 'sagar', 'active'),
(18, 'KrishnaWhistle', 'Male', '7842726082', 'krishna2@gmail.com', '1234', 'delivery_agent', 'Town', 'active'),
(19, 'ertsr', 'Male', '7788912345', 'adr@gmail.com', 'sdfgdf', 'customer', 'erwtegesgdsgds', 'active'),
(20, 'labTA1', 'Male', '9150110804', 'labta1@gmail.com', '1234', 'customer', 'Jabalpur', 'active'),
(21, 'labta2', 'Male', '9160110804', 'labta2@gmail.com', '1234', 'customer', 'ghar', 'active');

--
-- Triggers `USERS`
--
DELIMITER $$
CREATE TRIGGER `validate_phone_before_insert` BEFORE INSERT ON `USERS` FOR EACH ROW BEGIN
    IF NEW.phone NOT REGEXP '^[0-9]{10}$' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Phone number must be exactly 10 digits.';
    END IF;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `CUSTOMER`
--
ALTER TABLE `CUSTOMER`
  ADD PRIMARY KEY (`CID`);

--
-- Indexes for table `DELIVERY_AGENT`
--
ALTER TABLE `DELIVERY_AGENT`
  ADD PRIMARY KEY (`AGENT_ID`);

--
-- Indexes for table `LAB_REPORT`
--
ALTER TABLE `LAB_REPORT`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `test_id` (`test_id`),
  ADD KEY `pathologist_id` (`pathologist_id`);

--
-- Indexes for table `LAB_TEST`
--
ALTER TABLE `LAB_TEST`
  ADD PRIMARY KEY (`test_id`);

--
-- Indexes for table `MEDICINE`
--
ALTER TABLE `MEDICINE`
  ADD PRIMARY KEY (`med_id`);

--
-- Indexes for table `PATHOLOGIST`
--
ALTER TABLE `PATHOLOGIST`
  ADD PRIMARY KEY (`PATH_ID`);

--
-- Indexes for table `PHARMACIST`
--
ALTER TABLE `PHARMACIST`
  ADD PRIMARY KEY (`PHID`);

--
-- Indexes for table `REPORT_ASSIGNMENT`
--
ALTER TABLE `REPORT_ASSIGNMENT`
  ADD PRIMARY KEY (`assign_id`),
  ADD KEY `report_id` (`report_id`),
  ADD KEY `pharmacist_id` (`pharmacist_id`),
  ADD KEY `pathologist_id` (`pathologist_id`);

--
-- Indexes for table `SALES`
--
ALTER TABLE `SALES`
  ADD PRIMARY KEY (`sale_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `med_id` (`med_id`);

--
-- Indexes for table `SHIPMENT`
--
ALTER TABLE `SHIPMENT`
  ADD PRIMARY KEY (`shipment_id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `pharmacist_id` (`pharmacist_id`),
  ADD KEY `agent_id` (`agent_id`);

--
-- Indexes for table `SUPPLIER`
--
ALTER TABLE `SUPPLIER`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `SUPPLY`
--
ALTER TABLE `SUPPLY`
  ADD PRIMARY KEY (`supply_id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `med_id` (`med_id`),
  ADD KEY `pharmacist_id` (`pharmacist_id`);

--
-- Indexes for table `USERS`
--
ALTER TABLE `USERS`
  ADD PRIMARY KEY (`UID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `LAB_REPORT`
--
ALTER TABLE `LAB_REPORT`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `LAB_TEST`
--
ALTER TABLE `LAB_TEST`
  MODIFY `test_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `MEDICINE`
--
ALTER TABLE `MEDICINE`
  MODIFY `med_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `REPORT_ASSIGNMENT`
--
ALTER TABLE `REPORT_ASSIGNMENT`
  MODIFY `assign_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `SALES`
--
ALTER TABLE `SALES`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `SHIPMENT`
--
ALTER TABLE `SHIPMENT`
  MODIFY `shipment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `SUPPLIER`
--
ALTER TABLE `SUPPLIER`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=305;

--
-- AUTO_INCREMENT for table `SUPPLY`
--
ALTER TABLE `SUPPLY`
  MODIFY `supply_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=412;

--
-- AUTO_INCREMENT for table `USERS`
--
ALTER TABLE `USERS`
  MODIFY `UID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `CUSTOMER`
--
ALTER TABLE `CUSTOMER`
  ADD CONSTRAINT `fk_customer_user` FOREIGN KEY (`CID`) REFERENCES `USERS` (`UID`);

--
-- Constraints for table `DELIVERY_AGENT`
--
ALTER TABLE `DELIVERY_AGENT`
  ADD CONSTRAINT `delivery_agent_fk_user` FOREIGN KEY (`AGENT_ID`) REFERENCES `USERS` (`UID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LAB_REPORT`
--
ALTER TABLE `LAB_REPORT`
  ADD CONSTRAINT `LAB_REPORT_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `CUSTOMER` (`CID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `LAB_REPORT_ibfk_2` FOREIGN KEY (`test_id`) REFERENCES `LAB_TEST` (`test_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `LAB_REPORT_ibfk_3` FOREIGN KEY (`pathologist_id`) REFERENCES `PATHOLOGIST` (`PATH_ID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `PATHOLOGIST`
--
ALTER TABLE `PATHOLOGIST`
  ADD CONSTRAINT `fk_pathologist_user` FOREIGN KEY (`PATH_ID`) REFERENCES `USERS` (`UID`) ON DELETE CASCADE;

--
-- Constraints for table `PHARMACIST`
--
ALTER TABLE `PHARMACIST`
  ADD CONSTRAINT `pharmacist_fk_user` FOREIGN KEY (`PHID`) REFERENCES `USERS` (`UID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `REPORT_ASSIGNMENT`
--
ALTER TABLE `REPORT_ASSIGNMENT`
  ADD CONSTRAINT `REPORT_ASSIGNMENT_ibfk_1` FOREIGN KEY (`report_id`) REFERENCES `LAB_REPORT` (`report_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `REPORT_ASSIGNMENT_ibfk_2` FOREIGN KEY (`pharmacist_id`) REFERENCES `PHARMACIST` (`PHID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `REPORT_ASSIGNMENT_ibfk_3` FOREIGN KEY (`pathologist_id`) REFERENCES `PATHOLOGIST` (`PATH_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `SALES`
--
ALTER TABLE `SALES`
  ADD CONSTRAINT `SALES_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `USERS` (`UID`),
  ADD CONSTRAINT `SALES_ibfk_2` FOREIGN KEY (`med_id`) REFERENCES `MEDICINE` (`med_id`);

--
-- Constraints for table `SHIPMENT`
--
ALTER TABLE `SHIPMENT`
  ADD CONSTRAINT `SHIPMENT_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `SALES` (`sale_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `SHIPMENT_ibfk_2` FOREIGN KEY (`pharmacist_id`) REFERENCES `PHARMACIST` (`PHID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `SHIPMENT_ibfk_3` FOREIGN KEY (`agent_id`) REFERENCES `DELIVERY_AGENT` (`AGENT_ID`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
