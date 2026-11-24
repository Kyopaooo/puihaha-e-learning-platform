-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2026 at 08:03 PM
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
-- Database: `puihaha_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('e-learning-platform-cache-902ba3cda1883801594b6e1b452790cc53948fda', 'i:1;', 1795545808),
('e-learning-platform-cache-902ba3cda1883801594b6e1b452790cc53948fda:timer', 'i:1795545808;', 1795545808),
('e-learning-platform-cache-puihaha_weather_1', 'a:9:{s:8:\"latitude\";d:14.586995;s:9:\"longitude\";d:121.002785;s:17:\"generationtime_ms\";d:0.11157989501953125;s:18:\"utc_offset_seconds\";i:28800;s:8:\"timezone\";s:11:\"Asia/Manila\";s:21:\"timezone_abbreviation\";s:5:\"GMT+8\";s:9:\"elevation\";d:11;s:13:\"current_units\";a:6:{s:4:\"time\";s:7:\"iso8601\";s:8:\"interval\";s:7:\"seconds\";s:14:\"temperature_2m\";s:3:\"°C\";s:20:\"relative_humidity_2m\";s:1:\"%\";s:12:\"weather_code\";s:8:\"wmo code\";s:14:\"wind_speed_10m\";s:4:\"km/h\";}s:7:\"current\";a:6:{s:4:\"time\";s:16:\"2026-11-25T02:45\";s:8:\"interval\";i:900;s:14:\"temperature_2m\";d:28.2;s:20:\"relative_humidity_2m\";i:74;s:12:\"weather_code\";i:3;s:14:\"wind_speed_10m\";d:1;}}', 1795546954);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `instructor_id` bigint(20) UNSIGNED NOT NULL,
  `course_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `required_membership_level_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `slug`, `description`, `thumbnail`, `instructor_id`, `course_category_id`, `required_membership_level_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Introduction to Web Development', 'introduction-to-web-development-j4vfy', 'Learn the fundamentals of web development, including HTML, CSS, JavaScript, and the basics of building responsive websites.', NULL, 1, 1, NULL, 'published', '2026-11-24 06:45:15', '2026-11-24 06:45:15'),
(2, 'Introduction to Python Programming', 'introduction-to-python-programming-9bftk', 'Learn Python fundamentals, variables, data types, conditional statements, and loops.', NULL, 2, 1, NULL, 'published', '2026-11-24 07:01:03', '2026-11-24 07:01:03'),
(3, 'Database Management Fundamentals', 'database-management-fundamentals-lbqev', 'Learn the fundamentals of database management, including database concepts, relational database structures, SQL commands, and basic data manipulation. Understand how databases organize, store, retrieve, and manage information efficiently.', NULL, 1, 1, NULL, 'published', '2026-11-24 10:55:04', '2026-11-24 10:55:04');

-- --------------------------------------------------------

--
-- Table structure for table `course_categories`
--

CREATE TABLE `course_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_categories`
--

INSERT INTO `course_categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Technology', NULL, '2026-11-24 04:18:56', '2026-11-24 04:18:56'),
(2, 'Business', NULL, '2026-11-24 04:18:56', '2026-11-24 04:18:56'),
(3, 'Personal Development', NULL, '2026-11-24 04:18:56', '2026-11-24 04:18:56'),
(4, 'Creative Skills', NULL, '2026-11-24 04:18:56', '2026-11-24 04:18:56');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('active','completed','cancelled') NOT NULL DEFAULT 'active',
  `enrolled_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `student_id`, `course_id`, `status`, `enrolled_at`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'completed', '2026-11-24 06:51:05', '2026-11-24 06:51:05', '2026-11-24 06:55:20'),
(2, 4, 2, 'completed', '2026-11-24 07:41:37', '2026-11-24 07:41:37', '2026-11-24 09:04:35'),
(3, 4, 1, 'completed', '2026-11-24 07:41:47', '2026-11-24 07:41:47', '2026-11-24 09:05:00'),
(4, 6, 1, 'active', '2026-11-24 09:46:37', '2026-11-24 09:46:37', '2026-11-24 09:46:37'),
(5, 7, 2, 'completed', '2026-11-24 10:42:55', '2026-11-24 10:42:55', '2026-11-24 10:43:06'),
(6, 7, 1, 'active', '2026-11-24 10:50:51', '2026-11-24 10:50:51', '2026-11-24 10:50:51');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `learning_centers`
--

CREATE TABLE `learning_centers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `learning_centers`
--

INSERT INTO `learning_centers` (`id`, `name`, `address`, `latitude`, `longitude`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Puihaha Main Learning Center', 'Manila, Philippines', 14.6041670, 120.9886110, 1, '2026-11-24 04:18:56', '2026-11-24 04:18:56');

-- --------------------------------------------------------

--
-- Table structure for table `learning_materials`
--

CREATE TABLE `learning_materials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lesson_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `learning_materials`
--

INSERT INTO `learning_materials` (`id`, `lesson_id`, `title`, `file_path`, `original_name`, `created_at`, `updated_at`) VALUES
(1, 4, 'Python Programming', 'learning-materials/iKrRyYISueWXpNBSQ4diWoJzmO8R9bFt4raEYoX3.pdf', 'Python Programming.pdf', '2026-11-24 09:02:29', '2026-11-24 09:02:29'),
(2, 1, 'Basic HTML', 'learning-materials/q1gXintgQrKu8e7KxaJD6TH2g6eif1Dr1xuIL00v.pdf', 'html_tutorial.pdf', '2026-11-24 10:50:23', '2026-11-24 10:50:23');

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `course_id`, `title`, `content`, `video_url`, `sort_order`, `is_published`, `created_at`, `updated_at`) VALUES
(1, 1, 'Introduction to HTML', '1. What is HTML?\r\n\r\nHTML stands for HyperText Markup Language. It is the standard markup language used to create and structure content on web pages.\r\n\r\nHTML tells web browsers how to organize and display different elements, such as headings, paragraphs, images, links, and lists.\r\n\r\nHTML is not a programming language because it does not perform logical operations or calculations. Instead, it uses tags to describe the structure and meaning of webpage content.\r\n\r\n2. How HTML Works\r\n\r\nHTML uses elements and tags to organize webpage content. A web browser reads an HTML document and displays its contents as a webpage.\r\n\r\nFor example:\r\n\r\n<h1>Welcome to My Website</h1>\r\n<p>This is my first webpage.</p>\r\n\r\nThe browser displays a large heading followed by a paragraph.\r\n\r\n3. Basic HTML Document\r\n\r\nEvery standard HTML document follows a basic structure.\r\n\r\n<!DOCTYPE html>\r\n<html>\r\n<head>\r\n    <title>My First Webpage</title>\r\n</head>\r\n<body>\r\n    <h1>Hello, World!</h1>\r\n    <p>Welcome to my first webpage.</p>\r\n</body>\r\n</html>\r\n\r\nExplanation of the structure:\r\n\r\n<!DOCTYPE html> – Declares that the document uses HTML5.\r\n\r\n<html> – Contains the entire HTML document.\r\n\r\n<head> – Contains information about the webpage.\r\n\r\n<title> – Sets the title displayed in the browser tab.\r\n\r\n<body> – Contains the visible webpage content.\r\n\r\n<h1> – Creates a main heading.\r\n\r\n<p> – Creates a paragraph.\r\n\r\n4. Tools Used in HTML Development\r\n\r\nTo create an HTML webpage, you need:\r\n\r\nA text editor such as Visual Studio Code.\r\n\r\nA web browser such as Google Chrome or Microsoft Edge.\r\n\r\nA file saved with the .html extension.\r\n\r\n5. Key Takeaways\r\n\r\nHTML stands for HyperText Markup Language.\r\n\r\nHTML provides the structure of a webpage.\r\n\r\nHTML uses tags and elements to organize content.\r\n\r\nBrowsers interpret HTML documents and display them as webpages.', 'https://youtu.be/qz0aGYrrlhU?si=WNgWomUCTzIOCBOi', 1, 1, '2026-11-24 06:47:32', '2026-11-24 10:49:13'),
(2, 1, 'HTML Elements and Structure', '1. Understanding HTML Elements\r\n\r\nHTML elements are the building blocks of a webpage. They define different types of content and tell the browser how each part should be displayed or interpreted.\r\n\r\nMost HTML elements consist of:\r\n\r\nOpening tag\r\n\r\nContent\r\n\r\nClosing tag\r\n\r\nExample:\r\n\r\n<p>This is a paragraph.</p>\r\n\r\nIn this example:\r\n\r\n<p> is the opening tag.\r\n\r\nThis is a paragraph. is the content.\r\n\r\n</p> is the closing tag.\r\n\r\nSome elements, such as <img> and <br>, do not require closing tags.\r\n\r\n2. Common HTML Elements\r\n\r\nA. Heading Elements\r\n\r\nHTML provides six heading levels, from <h1> to <h6>.\r\n\r\n<h1>Main Heading</h1>\r\n<h2>Subheading</h2>\r\n<h3>Smaller Heading</h3>\r\n\r\n<h1> represents the highest-level heading, while <h6> represents the lowest-level heading.\r\n\r\nB. Paragraph Element\r\n\r\nThe <p> element is used to display blocks of text.\r\n\r\n<p>HTML is used to structure webpage content.</p>\r\n\r\nC. Link Element\r\n\r\nThe <a> element creates hyperlinks that connect webpages or other resources.\r\n\r\n<a href=\"https://www.example.com\">Visit Example</a>\r\n\r\nThe href attribute specifies the destination of the link.\r\n\r\nD. Image Element\r\n\r\nThe <img> element displays an image on a webpage.\r\n\r\n<img src=\"picture.jpg\" alt=\"A sample picture\">\r\n\r\nsrc specifies the image location.\r\n\r\nalt provides alternative text describing the image.\r\n\r\nE. List Elements\r\n\r\nHTML supports two commonly used types of lists.\r\n\r\nUnordered list:\r\n\r\n<ul>\r\n    <li>HTML</li>\r\n    <li>CSS</li>\r\n    <li>JavaScript</li>\r\n</ul>\r\n\r\nOrdered list:\r\n\r\n<ol>\r\n    <li>Open your text editor.</li>\r\n    <li>Create an HTML file.</li>\r\n    <li>Open it in a browser.</li>\r\n</ol>\r\n\r\nThe <ul> element creates a bulleted list, while <ol> creates a numbered list. The <li> element defines each list item.\r\n\r\n3. HTML Containers\r\n\r\nHTML provides elements that group related content.\r\n\r\nExamples include:\r\n\r\n<div> – A generic block-level container.\r\n\r\n<span> – A generic inline container.\r\n\r\nExample:\r\n\r\n<div>\r\n    <h2>About Me</h2>\r\n    <p>I am learning web development.</p>\r\n</div>\r\n\r\nContainers help organize webpage content and make styling easier when combined with CSS.\r\n\r\n4. Combining HTML Elements\r\n\r\nDifferent HTML elements can be combined to create a complete webpage.\r\n\r\nExample:\r\n\r\n<!DOCTYPE html>\r\n<html>\r\n<head>\r\n    <title>My Profile</title>\r\n</head>\r\n<body>\r\n\r\n    <h1>My Personal Profile</h1>\r\n\r\n    <p>Hello! My name is Alex.</p>\r\n\r\n    <h2>My Hobbies</h2>\r\n\r\n    <ul>\r\n        <li>Reading</li>\r\n        <li>Programming</li>\r\n        <li>Playing games</li>\r\n    </ul>\r\n\r\n    <a href=\"https://www.example.com\">\r\n        Visit this website\r\n    </a>\r\n\r\n</body>\r\n</html>\r\n\r\nThis example demonstrates how headings, paragraphs, lists, and hyperlinks work together to organize webpage content.\r\n\r\n5. Key Takeaways\r\n\r\nHTML elements define the different parts of a webpage.\r\n\r\nHeading elements organize content by importance.\r\n\r\nParagraphs display blocks of text.\r\n\r\nLinks connect users to other resources.\r\n\r\nImages add visual content.\r\n\r\nLists organize information.\r\n\r\nContainers group related elements.', NULL, 2, 1, '2026-11-24 06:49:35', '2026-11-24 10:52:00'),
(4, 2, 'Introduction to Python', 'Python is a popular, high-level programming language known for its simple syntax and readability. It is widely used in web development, data analysis, artificial intelligence, automation, and software development.\r\n\r\nWhy Learn Python?\r\n- Easy to understand and beginner-friendly.\r\n- Used in various fields of technology.\r\n- Has a large collection of libraries and frameworks.\r\n- Supports object-oriented and procedural programming.\r\n\r\nYour First Python Program\r\n\r\nA traditional first program in Python is:\r\n\r\nprint(\"Hello, World!\")\r\n\r\nThe print() function displays text or other values on the screen.\r\n\r\nBasic Python Concepts:\r\n1. Variables – Used to store information.\r\n2. Data Types – Examples include strings, integers, floats, and booleans.\r\n3. Operators – Used to perform calculations and comparisons.\r\n4. Functions – Reusable blocks of code that perform specific tasks.\r\n\r\nBy the end of this lesson, students should understand what Python is, why it is useful, and how to write a simple Python statement.', 'https://youtu.be/kqtD5dpn9C8?si=xxiuxteuRQZYgzg1', 1, 1, '2026-11-24 09:00:21', '2026-11-24 09:00:21'),
(5, 3, 'Introduction to Database Management', '# Introduction to Database Management\r\n\r\n## 1. What is a Database?\r\n\r\nA database is an organized collection of information that can be stored, accessed, managed, and updated electronically.\r\n\r\nDatabases are commonly used in schools, businesses, hospitals, banks, and online applications to maintain important information.\r\n\r\nExamples include:\r\n- Student information systems\r\n- Online shopping platforms\r\n- Banking applications\r\n- Library management systems\r\n- Membership management systems\r\n\r\n## 2. What is Database Management?\r\n\r\nDatabase management refers to the process of organizing, storing, retrieving, updating, and maintaining data.\r\n\r\nA Database Management System (DBMS) is software that allows users to interact with databases.\r\n\r\nPopular examples include:\r\n- MySQL\r\n- PostgreSQL\r\n- Microsoft SQL Server\r\n- Oracle Database\r\n- SQLite\r\n\r\n## 3. Why Are Databases Important?\r\n\r\nDatabases provide several advantages:\r\n\r\n**Data Organization:** Information is stored in a structured format.\r\n\r\n**Data Retrieval:** Users can quickly search and retrieve specific information.\r\n\r\n**Data Security:** Access permissions help protect sensitive information.\r\n\r\n**Data Consistency:** Proper database design helps prevent unnecessary duplication and inconsistent information.\r\n\r\n**Data Management:** Users can insert, update, and delete records efficiently.\r\n\r\n## 4. Basic Database Components\r\n\r\nA relational database commonly contains the following components:\r\n\r\n- Tables – Store related information.\r\n- Rows – Represent individual records.\r\n- Columns – Represent specific attributes.\r\n- Primary Keys – Uniquely identify each record.\r\n- Foreign Keys – Connect related tables.\r\n\r\nExample: A student table.\r\n\r\n| student_id | name | course |\r\n|---|---|---|\r\n| 1 | Alex | BSIT |\r\n| 2 | Jamie | BSCS |\r\n| 3 | Taylor | BSIT |\r\n\r\nIn this example, `student_id` uniquely identifies each student.\r\n\r\n## 5. Key Takeaways\r\n\r\n- A database stores organized information.\r\n- A DBMS provides tools for managing databases.\r\n- Databases are used in many real-world applications.\r\n- Tables contain rows and columns.\r\n- Keys help identify and connect records.\r\n\r\n## 6. Practice Activity\r\n\r\nIdentify three applications that use databases.\r\n\r\nFor each application, describe:\r\n1. What information it stores.\r\n2. Why that information needs to be organized.\r\n3. How users might retrieve or update the information.\r\n\r\n**Challenge:** Design a simple student table containing at least five sample student records.', NULL, 0, 1, '2026-11-24 10:55:43', '2026-11-24 10:55:43'),
(6, 3, 'Understanding Relational Databases', '1. What is a Relational Database?\r\n\r\nA relational database organizes information into tables consisting of rows and columns.\r\n\r\nTables can be connected through relationships, allowing related information to be stored in separate tables.\r\n\r\nFor example, a school database might contain:\r\n\r\nStudents table\r\n\r\nCourses table\r\n\r\nEnrollments table\r\n\r\n2. Understanding Tables\r\n\r\nA table stores information about a particular subject.\r\n\r\nExample: Students table\r\n\r\nstudent_id\r\n\r\nstudent_name\r\n\r\nemail\r\n\r\n1\r\n\r\nAlex\r\n\r\nalex@example.com\r\n\r\n2\r\n\r\nJamie\r\n\r\njamie@example.com\r\n\r\nEach row represents one student, while each column represents an attribute.\r\n\r\n3. Understanding Primary Keys\r\n\r\nA primary key is a column or combination of columns that uniquely identifies each record in a table.\r\n\r\nExample:\r\n\r\nCREATE TABLE students (\r\n    student_id INT PRIMARY KEY,\r\n    student_name VARCHAR(100),\r\n    email VARCHAR(150)\r\n);\r\n\r\nThe student_id column uniquely identifies every student.\r\n\r\n4. Understanding Foreign Keys\r\n\r\nA foreign key connects one table to another by referencing its primary key.\r\n\r\nExample:\r\n\r\nCREATE TABLE enrollments (\r\n    enrollment_id INT PRIMARY KEY,\r\n    student_id INT,\r\n    course_name VARCHAR(100),\r\n    FOREIGN KEY (student_id)\r\n        REFERENCES students(student_id)\r\n);\r\n\r\nThis allows enrollment records to reference existing students.\r\n\r\n5. Benefits of Relational Databases\r\n\r\nOrganized data storage.\r\n\r\nReduced unnecessary duplication.\r\n\r\nBetter data consistency.\r\n\r\nEasier retrieval of related information.\r\n\r\nImproved data integrity.\r\n\r\n6. Practice Activity\r\n\r\nCreate a simple relational database design containing:\r\n\r\nA Students table.\r\n\r\nA Courses table.\r\n\r\nAn Enrollments table.\r\n\r\nIdentify the primary key and foreign key for each table.', NULL, 2, 1, '2026-11-24 10:56:18', '2026-11-24 10:56:18');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `member_code` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `joined_at` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `membership_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `membership_level_id` bigint(20) UNSIGNED DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `expires_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `member_code`, `first_name`, `last_name`, `email`, `phone`, `address`, `category`, `level`, `status`, `joined_at`, `created_at`, `updated_at`, `user_id`, `membership_category_id`, `membership_level_id`, `latitude`, `longitude`, `expires_at`) VALUES
(1, 'PUH-261124-OE4EG', 'ALYXA RAE', 'LEONCIO', 'alyxarae.leoncio@gmail.com', '09157450666', '123 Main Street, Downtown', 'Student', 'Basic', 'Active', '2026-11-24', '2026-11-24 05:41:20', '2026-11-24 09:08:21', NULL, 1, 1, NULL, NULL, '2029-11-24'),
(2, 'PUH-261124-KATDD', 'Gab', 'Alpasan', 'Gab@gmail.com', '(096) 636-14244', '123 Main Street, Downtown', 'Student', 'Platinum', 'Active', '2026-11-24', '2026-11-24 06:01:15', '2026-11-24 06:33:17', NULL, 1, 4, NULL, NULL, NULL),
(3, 'PUH-261124-OLQ9T', 'Kyo', 'Pao', 'alyxaraenleoncio@gmail.com', NULL, NULL, 'Student', 'Basic', 'Active', '2026-11-24', '2026-11-24 09:39:10', '2026-11-24 09:45:31', 6, 1, 1, NULL, NULL, '2026-12-24'),
(4, 'PUH-261124-NZCDV', 'Map', 'Test', 'admin@puihaha.test', '555-0101', '123 Main Street, Downtown', 'Student', 'Basic', 'Active', '2026-11-24', '2026-11-24 10:18:43', '2026-11-24 10:18:43', NULL, 1, 1, 14.5986904, 120.9838057, NULL),
(5, 'PUH-261124-AUMWE', 'Gabriel', 'Alpasan', 'gabbyalpasan@gmail.com', NULL, NULL, 'Student', 'Silver', 'Active', '2026-11-24', '2026-11-24 10:41:13', '2026-11-24 10:43:51', 7, 1, 2, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `membership_categories`
--

CREATE TABLE `membership_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `membership_categories`
--

INSERT INTO `membership_categories` (`id`, `name`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Student', NULL, 1, '2026-11-24 04:18:56', '2026-11-24 06:13:05'),
(2, 'Regular', NULL, 1, '2026-11-24 04:18:56', '2026-11-24 06:12:40'),
(3, 'Senior Citizen', NULL, 1, '2026-11-24 04:18:56', '2026-11-24 04:18:56'),
(4, 'Corporate', NULL, 1, '2026-11-24 04:18:56', '2026-11-24 04:18:56');

-- --------------------------------------------------------

--
-- Table structure for table `membership_levels`
--

CREATE TABLE `membership_levels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `validity_months` smallint(5) UNSIGNED NOT NULL DEFAULT 12,
  `benefits` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `membership_levels`
--

INSERT INTO `membership_levels` (`id`, `name`, `fee`, `validity_months`, `benefits`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Basic', 0.00, 1, 'Access to introductory learning resources', NULL, 1, '2026-11-24 04:18:56', '2026-11-24 06:25:48'),
(2, 'Silver', 499.00, 12, 'Access to standard courses', NULL, 1, '2026-11-24 04:18:56', '2026-11-24 04:18:56'),
(3, 'Gold', 999.00, 12, 'Access to premium courses and resources', NULL, 1, '2026-11-24 04:18:56', '2026-11-24 04:18:56'),
(4, 'Platinum', 1499.00, 12, 'Full access to all learning resources', NULL, 1, '2026-11-24 04:18:56', '2026-11-24 04:18:56');

-- --------------------------------------------------------

--
-- Table structure for table `membership_transactions`
--

CREATE TABLE `membership_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference_number` varchar(255) NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `membership_level_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('application','renewal') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('Pending','Paid','Approved','Expired','Cancelled') NOT NULL DEFAULT 'Pending',
  `transaction_date` date NOT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `membership_transactions`
--

INSERT INTO `membership_transactions` (`id`, `reference_number`, `member_id`, `membership_level_id`, `type`, `amount`, `amount_paid`, `status`, `transaction_date`, `approved_at`, `created_at`, `updated_at`) VALUES
(1, 'PUH-TX-20261124-KWXD5K', 1, 3, 'renewal', 999.00, 999.00, 'Approved', '2026-11-24', '2026-11-24 06:28:42', '2026-11-24 06:28:00', '2026-11-24 06:28:42'),
(2, 'PUH-TX-20261124-DFXDXQ', 2, 4, 'application', 1499.00, 0.00, 'Cancelled', '2026-11-24', NULL, '2026-11-24 06:33:32', '2026-11-24 06:34:37'),
(3, 'PUH-TX-20261124-ADS5QE', 2, 4, 'application', 1499.00, 500.00, 'Pending', '2026-11-24', NULL, '2026-11-24 06:34:55', '2026-11-24 06:35:11'),
(4, 'PUH-TX-20261124-OVKWFP', 1, 3, 'application', 999.00, 0.00, 'Cancelled', '2026-11-24', NULL, '2026-11-24 06:37:47', '2026-11-24 06:38:50'),
(5, 'PUH-TX-20261124-MIFEKN', 1, 2, 'renewal', 499.00, 499.00, 'Approved', '2026-11-24', '2026-11-24 06:39:42', '2026-11-24 06:39:05', '2026-11-24 06:39:42'),
(6, 'PUH-TX-20261124-642XQB', 1, 3, 'renewal', 999.00, 999.00, 'Approved', '2026-11-24', '2026-11-24 06:43:34', '2026-11-24 06:41:21', '2026-11-24 06:43:34'),
(7, 'PUH-TX-20261124-OBKJUT', 3, 1, 'application', 0.00, 0.00, 'Approved', '2026-11-24', '2026-11-24 09:45:31', '2026-11-24 09:45:24', '2026-11-24 09:45:31');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_10_21_023454_create_tasks_table', 1),
(5, '2026_10_28_000000_create_members_table', 1),
(6, '2026_11_24_000001_add_role_and_status_to_users_table', 1),
(7, '2026_11_24_000002_create_membership_categories_table', 1),
(8, '2026_11_24_000003_create_membership_levels_table', 1),
(9, '2026_11_24_000004_extend_members_table', 1),
(10, '2026_11_24_000005_create_membership_transactions_table', 1),
(11, '2026_11_24_000006_create_payments_table', 1),
(12, '2026_11_24_000007_create_learning_tables', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payment_reference` varchar(255) NOT NULL,
  `membership_transaction_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` enum('Cash','Bank Transfer','E-Wallet') NOT NULL,
  `payment_date` date NOT NULL,
  `notes` text DEFAULT NULL,
  `recorded_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `payment_reference`, `membership_transaction_id`, `amount`, `payment_method`, `payment_date`, `notes`, `recorded_by`, `created_at`, `updated_at`) VALUES
(1, 'PUH-PAY-20261124-UGJVVG', 1, 999.00, 'Cash', '2026-11-24', NULL, 1, '2026-11-24 06:28:36', '2026-11-24 06:28:36'),
(2, 'PUH-PAY-20261124-FC7VWQ', 3, 500.00, 'Cash', '2026-11-24', NULL, 1, '2026-11-24 06:35:11', '2026-11-24 06:35:11'),
(3, 'PUH-PAY-20261124-EPEZAL', 5, 499.00, 'Cash', '2026-11-24', NULL, 1, '2026-11-24 06:39:32', '2026-11-24 06:39:32'),
(4, 'PUH-PAY-20261124-BZDRR8', 6, 999.00, 'Cash', '2026-11-24', NULL, 1, '2026-11-24 06:43:23', '2026-11-24 06:43:23');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('qxdCxblV9BmSRIsLEiBynhfJ4BqMNO5ScHfjpPGL', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36 OPR/139.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUXFubHpuRk9rdDhCSHl5Y3hxc3B1T0IzQ09wRTc5WG11clFrNGNxViI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fX0=', 1795536815);

-- --------------------------------------------------------

--
-- Table structure for table `student_progress`
--

CREATE TABLE `student_progress` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `enrollment_id` bigint(20) UNSIGNED NOT NULL,
  `lesson_id` bigint(20) UNSIGNED NOT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_progress`
--

INSERT INTO `student_progress` (`id`, `enrollment_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '2026-11-24 06:55:50', '2026-11-24 06:55:20', '2026-11-24 06:55:50'),
(2, 2, 4, '2026-11-24 09:04:35', '2026-11-24 09:04:35', '2026-11-24 09:04:35'),
(3, 3, 2, '2026-11-24 09:05:00', '2026-11-24 09:05:00', '2026-11-24 09:05:00'),
(4, 4, 1, '2026-11-24 09:46:46', '2026-11-24 09:46:46', '2026-11-24 09:46:46'),
(5, 5, 4, '2026-11-24 10:43:06', '2026-11-24 10:43:06', '2026-11-24 10:43:06');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'student',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Puihaha Administrator', 'admin@puihaha.test', '2026-11-24 08:07:26', '$2y$12$V/DmTyVU72E1k8grP8xqXOXgQiMn37ultM4sr6atbhuk49C91ePFK', 'admin', 1, NULL, '2026-11-24 04:18:55', '2026-11-24 08:07:26'),
(2, 'Demo Instructor', 'instructor@puihaha.test', '2026-11-24 08:07:26', '$2y$12$6.QwzHOm89qT49otpcGVtuhq31ks5P/3B8jxwUA5n6wDvVjAfL9l2', 'instructor', 1, NULL, '2026-11-24 04:18:56', '2026-11-24 08:07:26'),
(3, 'Demo Student', 'student@puihaha.test', '2026-11-24 08:07:26', '$2y$12$WPmo.4Yt0U9ofcIT51a0cuPhGmEl77ISIgXByiFftmOGL4CFq9o/O', 'student', 1, NULL, '2026-11-24 04:18:56', '2026-11-24 08:07:26'),
(4, 'Alyxa Raen Leoncio', 'alyxarae.leoncio@gmail.com', '2026-11-24 07:41:18', '$2y$12$XC.5DDxHjM/U8YIDeSFny.VwMicUtEbXpCwTMt80VfnpUAmcLaQjK', 'student', 1, NULL, '2026-11-24 07:24:23', '2026-11-24 07:41:18'),
(6, 'Kyo Pao', 'alyxaraenleoncio@gmail.com', '2026-11-24 09:39:59', '$2y$12$qXz.qThADMO4QEbWu2gl3.3H.W4JC6HBHs8h34ccJIIq8tGZ/XER6', 'student', 1, NULL, '2026-11-24 09:39:10', '2026-11-24 09:39:59'),
(7, 'Gabriel Alpasan', 'gabbyalpasan@gmail.com', '2026-11-24 10:42:28', '$2y$12$x40TrW36jfuw7icPKfTr2.73rfERoofqUSYYEjwTD5nMp6BlaJCmq', 'student', 1, NULL, '2026-11-24 10:41:13', '2026-11-24 10:42:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `courses_slug_unique` (`slug`),
  ADD KEY `courses_instructor_id_foreign` (`instructor_id`),
  ADD KEY `courses_course_category_id_foreign` (`course_category_id`),
  ADD KEY `courses_required_membership_level_id_foreign` (`required_membership_level_id`);

--
-- Indexes for table `course_categories`
--
ALTER TABLE `course_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_categories_name_unique` (`name`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `enrollments_student_id_course_id_unique` (`student_id`,`course_id`),
  ADD KEY `enrollments_course_id_foreign` (`course_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learning_centers`
--
ALTER TABLE `learning_centers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learning_materials`
--
ALTER TABLE `learning_materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `learning_materials_lesson_id_foreign` (`lesson_id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lessons_course_id_foreign` (`course_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `members_member_code_unique` (`member_code`),
  ADD UNIQUE KEY `members_user_id_unique` (`user_id`),
  ADD KEY `members_membership_category_id_foreign` (`membership_category_id`),
  ADD KEY `members_membership_level_id_foreign` (`membership_level_id`);

--
-- Indexes for table `membership_categories`
--
ALTER TABLE `membership_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `membership_categories_name_unique` (`name`);

--
-- Indexes for table `membership_levels`
--
ALTER TABLE `membership_levels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `membership_levels_name_unique` (`name`);

--
-- Indexes for table `membership_transactions`
--
ALTER TABLE `membership_transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `membership_transactions_reference_number_unique` (`reference_number`),
  ADD KEY `membership_transactions_member_id_foreign` (`member_id`),
  ADD KEY `membership_transactions_membership_level_id_foreign` (`membership_level_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payments_payment_reference_unique` (`payment_reference`),
  ADD KEY `payments_membership_transaction_id_foreign` (`membership_transaction_id`),
  ADD KEY `payments_recorded_by_foreign` (`recorded_by`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `student_progress`
--
ALTER TABLE `student_progress`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_progress_enrollment_id_lesson_id_unique` (`enrollment_id`,`lesson_id`),
  ADD KEY `student_progress_lesson_id_foreign` (`lesson_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `course_categories`
--
ALTER TABLE `course_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `learning_centers`
--
ALTER TABLE `learning_centers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `learning_materials`
--
ALTER TABLE `learning_materials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `membership_categories`
--
ALTER TABLE `membership_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `membership_levels`
--
ALTER TABLE `membership_levels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `membership_transactions`
--
ALTER TABLE `membership_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `student_progress`
--
ALTER TABLE `student_progress`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_course_category_id_foreign` FOREIGN KEY (`course_category_id`) REFERENCES `course_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `courses_instructor_id_foreign` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `courses_required_membership_level_id_foreign` FOREIGN KEY (`required_membership_level_id`) REFERENCES `membership_levels` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `learning_materials`
--
ALTER TABLE `learning_materials`
  ADD CONSTRAINT `learning_materials_lesson_id_foreign` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lessons_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `members_membership_category_id_foreign` FOREIGN KEY (`membership_category_id`) REFERENCES `membership_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `members_membership_level_id_foreign` FOREIGN KEY (`membership_level_id`) REFERENCES `membership_levels` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `members_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `membership_transactions`
--
ALTER TABLE `membership_transactions`
  ADD CONSTRAINT `membership_transactions_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `membership_transactions_membership_level_id_foreign` FOREIGN KEY (`membership_level_id`) REFERENCES `membership_levels` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_membership_transaction_id_foreign` FOREIGN KEY (`membership_transaction_id`) REFERENCES `membership_transactions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_recorded_by_foreign` FOREIGN KEY (`recorded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `student_progress`
--
ALTER TABLE `student_progress`
  ADD CONSTRAINT `student_progress_enrollment_id_foreign` FOREIGN KEY (`enrollment_id`) REFERENCES `enrollments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_progress_lesson_id_foreign` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
