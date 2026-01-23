-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 23, 2026 at 09:58 AM
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
-- Database: `be_connect_ed`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignment`
--

CREATE TABLE `assignment` (
  `assignment_id` int(11) NOT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `task_title` varchar(255) DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `chat_id` int(11) NOT NULL,
  `is_group` tinyint(1) DEFAULT NULL,
  `chat_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_member`
--

CREATE TABLE `chat_member` (
  `chat_member_id` int(11) NOT NULL,
  `chat_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_message`
--

CREATE TABLE `chat_message` (
  `message_id` int(11) NOT NULL,
  `chat_id` int(11) DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `message_content` text DEFAULT NULL,
  `sent_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `class_id` int(11) NOT NULL,
  `class_name` varchar(255) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`class_id`, `class_name`, `course_id`) VALUES
(1, '4.2 DD Digital Designs', 1),
(2, '5.1 BA Conservation and maintenance', 4),
(3, '4.2b DD Digital Design', 1),
(4, '6.1 CC Conservation', 2);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(255) DEFAULT NULL,
  `course_code` varchar(100) DEFAULT NULL,
  `institute_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL,
  `MQF_Level` int(50) DEFAULT NULL,
  `credits` int(50) NOT NULL,
  `duration` varchar(50) NOT NULL,
  `course_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `course_name`, `course_code`, `institute_id`, `is_active`, `MQF_Level`, `credits`, `duration`, `course_description`) VALUES
(1, 'Advanced Diploma in Digital Design', 'CA4-W05-24', 1, 1, 5, 120, '3 years', 'The course introduces common fundamental principles, skills and software related to contemporary fields of design. Minor streams in game art, graphic design and interactive media will allow learners to specialise in their field of interest and master the required skills in preparation for more independent study at undergraduate level. Exploratory exercises, real life work and the possibility of competitions all form part of the process for an effective learning experience. Taught by experienced visual and technical designers from '),
(2, 'Bachelor in Conservation (Honours)', ' CA6-A12-23', NULL, 1, 5, 0, '', 'This full-time undergraduate course in conservation-restoration studies provides the learner with the opportunity to obtain the fundamental knowledge, skills and competences in conservation-restoration in a particular area of studies on offer. After an initial common year, learners then have the possibility to focus on a specific area. During the three years, which include practice-led formation and internships, the learner appreciates the complex nature of conservation-restoration as an interdisciplinary endeavour in which the conservation-restoration graduate collaborates with other members of a multidisciplinary team under the supervision of a warranted conservator restorer, for the benefit of the heritage. Through the final-year dissertation project of choice the learner has the opportunity to delve into further detail within the area of focus.'),
(3, 'Advanced Diploma in Art and Design', 'ADAD567', 1, 1, 4, 120, '2 years', 'The programme provides guided vocational learning in art and design as well as relevant key competences. It equips learners with the foundations required to undertake further studies in various specialist areas at undergraduate level. During the course, learners build a portfolio of student work that hones in their skills and gradually orients their focus in the direction they intend to follow in their career. The programme has an element of work-based learning through which students experience some contact with industry. Special attention is also given to visual and written communication in preparation for self-promotion and entrepreneurship after their studies.'),
(4, 'Mental health', 'mth123', 2, 1, 6, 120, '3 years', 'A mental health course description outlines learning objectives like recognizing signs of distress, providing initial support, understanding conditions (anxiety, depression, etc.), and applying self-care, often using a practical, skills-based approach such as Mental Health First Aid (MHFA) to equip individuals to help others or themselves, bridging knowledge gaps and reducing stigma in workplaces, schools, or communities. These courses aim to build confidence and provide actionable strategies, moving beyond just theory to real-world application for holistic well-being. '),
(5, 'Bachelor of Arts (Honours) in Spatial Design', 'CA6-O08-24', 1, 1, 6, 120, '3 years', 'This degree aims to provide learners with the essential communication skills to visually interpret industry-related spatial design projects of both internal and external spaces. Learners will develop critical analysis and independent thinking to project management competences to transform three-dimensional volumes into innovative spatial experiences. They will explore constructional materials and technology to develop their projects, with attention to sustainability and the environment, considering also light effects in the design brief. Learners will also learn how to generate technical drawings and artistic visuals using CAD software to communicate concepts and details in a realistic manner, as well as develop model-making skills.'),
(6, 'Bachelor of Arts (Honours) in Journalism', 'CA6-O09-23', 1, 1, 6, 120, '3 years', 'The journalism sphere offers exciting new career opportunities for individuals who are keen to learn and to offer a much needed service to society. Journalism is a vocation that can take learners to unimaginable places and lead them to meet extraordinary and diverse people. Learners will be expected to effectively analyse and report the events that shape our lives and the world around us. They will be guided to design, develop and produce news content using the latest audio-visual technologies and recording devices. Moreover, learners will explore how to present their journalistic works to the public in a variety of formats such as print, radio, television and online. Throughout this programme, learners will work on real-life case scenarios, applying theoretical knowledge to practical journalism and related projects, working both in teams as well as autonomously.');

-- --------------------------------------------------------

--
-- Table structure for table `course_units`
--

CREATE TABLE `course_units` (
  `course_unit_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_units`
--

INSERT INTO `course_units` (`course_unit_id`, `course_id`, `unit_id`, `created_at`) VALUES
(24, 2, 1, '2026-01-15 18:49:05'),
(25, 2, 3, '2026-01-15 18:49:05'),
(26, 1, 2, '2026-01-16 12:02:55'),
(27, 1, 1, '2026-01-16 12:02:55'),
(28, 1, 3, '2026-01-16 12:02:55'),
(29, 1, 4, '2026-01-16 12:02:55'),
(30, 1, 5, '2026-01-16 12:02:55'),
(33, 4, 1, '2026-01-20 11:49:29'),
(34, 4, 3, '2026-01-20 11:49:29'),
(35, 4, 2, '2026-01-20 11:49:29'),
(36, 4, 4, '2026-01-20 11:49:29');

-- --------------------------------------------------------

--
-- Table structure for table `enrolment`
--

CREATE TABLE `enrolment` (
  `enrolment_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrolment`
--

INSERT INTO `enrolment` (`enrolment_id`, `student_id`, `course_id`, `class_id`) VALUES
(20, 42, 1, 4),
(22, 52, 1, 4),
(25, 53, 4, 4),
(27, 46, 4, 1),
(32, 42, 4, 2),
(33, 53, 4, 2),
(39, 41, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `start_datetime` datetime DEFAULT NULL,
  `end_datetime` datetime DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

CREATE TABLE `file` (
  `file_id` int(11) NOT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `file_path` varchar(800) DEFAULT NULL,
  `uploaded_at` datetime DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grade`
--

CREATE TABLE `grade` (
  `grade_id` int(11) NOT NULL,
  `submission_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `mark` int(11) DEFAULT NULL,
  `grade` varchar(10) DEFAULT NULL,
  `comments` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `institute`
--

CREATE TABLE `institute` (
  `institute_id` int(11) NOT NULL,
  `institute_name` varchar(255) DEFAULT NULL,
  `institute_domain` varchar(255) DEFAULT NULL,
  `institute_address` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `institute`
--

INSERT INTO `institute` (`institute_id`, `institute_name`, `institute_domain`, `institute_address`) VALUES
(1, 'MCAST Institute for the Creative Arts', NULL, NULL),
(2, 'MCAST Institute of Applied Sciences', NULL, NULL),
(3, 'University of Malta', NULL, NULL),
(4, 'St Benedict College', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `institute_admin`
--

CREATE TABLE `institute_admin` (
  `institute_admin_id` int(11) NOT NULL,
  `institute_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notification_id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parent_student`
--

CREATE TABLE `parent_student` (
  `parent_student_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reset_password`
--

CREATE TABLE `reset_password` (
  `reset_password_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reset_password`
--

INSERT INTO `reset_password` (`reset_password_id`, `user_id`, `reset_token`, `expires_at`) VALUES
(1, 40, 'bafaa0d91d0f0d7f088ecddb5c47853f7c359322e063f8222394a78447dd5d28', '2025-12-15 19:15:34'),
(2, 41, 'a36b617ae197c1176bd8923721c9be0d302eebb482ab0367c101941617d1ef45', '2025-12-15 19:39:04'),
(3, 42, '32756d142a5797d905044fef238fdcfd50620a2ee3b325efe6c068dc2937fb74', '2025-12-15 20:45:18'),
(4, 44, 'e3428f8b112ee6e782f0564a9584e9f967c4698011905a209216c5bb7f249280', '2025-12-16 10:40:00'),
(5, 45, 'dc255a1669dbc80e5a1fa242dc1de5c4fd458bc3bba723444edbc0f35f962752', '2025-12-16 11:03:35'),
(6, 46, 'd2ed4444dc298b8e527e8f62e051de7989d3f49b551cf67303e453d49ff3f447', '2025-12-16 11:07:34'),
(7, 47, '0f285f68c9a41a3974e68e0f32bd5566ba849498dc688d2cc253c43fe18ef55f', '2025-12-16 11:10:23'),
(9, 49, '1f1e36e71e333474bc2a39b20b06458af6df87c3ad379be8455a325ebfe705d7', '2025-12-16 11:33:43'),
(10, 50, '409b121c91ceecefd28f5bd8ce0ea2f98c36c2230611817efe7e5d901983ec11', '2025-12-16 12:55:33'),
(11, 51, '400f5024b3de0432008a8386d840ee98cd27faf0e08813fa1313f74dc239b727', '2026-01-12 16:40:00'),
(12, 52, '7c973c6eb6ea6c8ebcc026dbb586e9a6ad13eca73709de1d5de36c09c606f89e', '2026-01-14 15:31:55'),
(13, 53, '74056e61f3eb86a1244f980086a3977fa9fbd7e9f77ca338b730d9a7f24d76bc', '2026-01-15 20:52:07'),
(14, 54, 'e939edc827f70c00cb18912e3670a9743eafed78499d9dac1583ba7789a1f9d8', '2026-01-18 18:26:54'),
(15, 55, '11cf98e2c1df88a51171decc268f86a8c0c172f2dfc85c677e91d2307ebf4e41', '2026-01-22 15:25:51'),
(16, 56, '47f426bb9b8e7c79421c42e50e91ce89846bec894c2fec55006da7ab1c3bc0da', '2026-01-22 15:28:21'),
(17, 58, '127af9da5c7a0f09e7c18e1defaa6c2f51f7bb5c6c09769089850d25fbd20da7', '2026-01-22 16:13:25'),
(18, 59, 'b8653e868b8fc76bd33930b48dc8281757b323cd0323386cd0a8c3fa7aeb4514', '2026-01-22 16:14:56');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role_name`) VALUES
(1, 'Teacher'),
(2, 'Student'),
(3, 'Parent'),
(4, 'Administrator'),
(5, 'Independent_teacher');

-- --------------------------------------------------------

--
-- Table structure for table `settings_theme`
--

CREATE TABLE `settings_theme` (
  `settings_theme_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `dark_mode` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `submission`
--

CREATE TABLE `submission` (
  `submission_id` int(11) NOT NULL,
  `assignment_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `file_path` varchar(800) DEFAULT NULL,
  `submitted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teacher_profile`
--

CREATE TABLE `teacher_profile` (
  `teacher_id` int(11) NOT NULL,
  `is_independent` tinyint(1) DEFAULT NULL,
  `qualification` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `unit_id` int(11) NOT NULL,
  `unit_name` varchar(255) DEFAULT NULL,
  `unit_code` varchar(100) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `ects_credits` int(11) DEFAULT NULL,
  `unit_description` text NOT NULL,
  `is_active` int(11) NOT NULL,
  `unit_duration` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`unit_id`, `unit_name`, `unit_code`, `course_id`, `ects_credits`, `unit_description`, `is_active`, `unit_duration`) VALUES
(1, 'Contextual Studies in Graphic Design', 'CAGDN-406-1701', NULL, 9, 'This unit aims to build the necessary skills and knowledge required by learners to\r\ninvestigate and comprehend Graphic Design practice and the social, historical and\r\ncultural events, theories and debates, with contextual reference and relevance to\r\ncontemporary developments. Learners will use the knowledge and understanding of\r\nhistorical and contemporary Graphic Design gained in this unit to further inform and\r\ndevelop their practice within their specialist field of study and in the wider context of\r\nprofessional practice.\r\nWhile exploring the historical context of key events, significant figures movements in\r\nthe evolution of graphic design, the learner can relate to own design practice, and bring\r\nforward such learning to a contemporary social and cultural context.\r\nGraphic Design reflects, translates and communicates social, political and cultural\r\nissues – ecology, environment, politics, war, health, education and welfare – visually.\r\nIn understanding this, the learner is encouraged to interpret, develop and nurture own\r\nideas and communicate observations in contemporary language, which informs and\r\ndefines own specialist area of interest in design learning towards integration within the\r\ncreative industry.', 1, '150 hours'),
(2, 'Exploring Digital Media', 'CAART-406-1625', NULL, 6, 'This is a practical skill based unit where students will demonstrate an understanding of\r\ndigital media applications in a creative context. Learners will demonstrate the ability\r\nto use required tools and techniques for digital imaging. Learners should show proficient\r\nuses of graphic design software and demonstrate this through a portfolio of work.\r\nIn completing the unit, students will have gained knowledge and understanding of the\r\nuses of digital media within their creative field and in a contemporary context. They\r\nwill also develop the ability and understanding to allow them to use design software to\r\na proficient level. This will include being able to save and file work effectively as well\r\nas being able to use other design tools for image editing and manipulation.', 1, '150 hours'),
(3, 'Interactive Media Fundamentals', 'CAMED-406-1607', NULL, 6, 'With the ever-increasing demand for social connectivity, interactive media products\r\nhave become commonplace as a communication tool between the businesses and the\r\nindividual. The increase in popularity within this field has shifted the designer’s role\r\ninto bringing fitness for purpose and usability to the forefront of interactive product\r\ndevelopment. For this reason, practitioners must have a fundamental understanding of\r\nthe design principles required to produce effective interactive media products.\r\nThis unit provides a practical basis for learners to study the role and use of interactive\r\nmedia products within the industry, and should stipulate a basis for future career\r\nopportunities in interactive product creation.\r\nThroughout the development of this unit, learners should gain a basic working\r\nknowledge of interactive media as a communication tool, with special reference to the\r\nrole of proper design processes in the creation of interactive media products. They\r\nshould be further guided through the assessment of user needs using research and firsthand enquiry, ultimately synthesizing the necessary elements into a functional\r\nprototype or application. The importance of design should be consolidated and\r\nrepresented in the learners’ practical work, and consider the properties of the intended\r\ninteractive systems and hardware.', 1, '150 hours'),
(4, 'Photographic Media, Techniques and Technology', 'CAFOT-406-1601', NULL, 6, 'The aim of this unit is to develop knowledge, understanding and skills across the range\r\nof processes involved in different photographic media, techniques and technology\r\nwhich contribute to the creative photographic process. At the end of the unit, learners\r\nwill be able to use this knowledge in the creation of their own photographic images.\r\nThrough experimentation and learning over a long period of time, a range of skills and\r\ntechniques have been developed which professional photographers employ and adapt\r\nto their own uses. In many cases, a photographer’s choice of materials and techniques\r\ncan create a unique “look” which can become identified with a particular\r\nphotographer. In the past such identities have made some photographers\r\ninternationally famous. Some processes involve working with potentially harmful\r\nequipment which have health and safety implications. Therefore, learners must be\r\nmade aware of these implications so that they can work safely without exposing\r\nthemselves and others to harm. Digital technologies have largely replaced the use of\r\nfilm in photography. Digital photography is now almost exclusively the medium of\r\nchoice for professional photographers. Progression through the unit allows learners to\r\ncritically assess their working practices. Learners will acquire the ability to understand\r\nthe uses and implications of different aspects of these techniques and technologies.\r\nLearners will also be able to creatively review the visual impact of their work and\r\nreflect on the effect that the use of different techniques and technologies has had on\r\ntheir work. Learners will also be able to review their work in the light of relevant health\r\nand safety practices. As the learners progress through the unit, their personal\r\nexperience and learning will offer a better understanding of photographic media,\r\ntechniques and technologies and be able to formulate their preferences and style in\r\ntheir own photographic work.', 1, '150 hours'),
(5, 'Visual Communication', 'CAART-406-1622', NULL, 6, 'This unit introduces a number of design methods and techniques. And aims further, for\r\nstudents to develop skills in communicating ideas visually and succeed an ability of a\r\ndesign practitioner to effectively communicate a message. Different contexts require\r\ndifferent means of communication, varying from artistic impressions to commercial\r\npersuasion. This unit will therefore introduce learners to a variety of visual\r\ncommunication tools and techniques, to prepare them for more specialized subjects.\r\nStudents will learn to appropriately apply traditional and digital techniques, whilst\r\nencouraged to experiment and develop own ways and styles to convey information.\r\nWith practice, participants will also gain the ability to create skillful visual compositions\r\nand manipulate formal elements to achieve effective results that meet the purpose.\r\nThrough research and investigation, participants will also learn to determine a target\r\naudience & understand clients. By identifying their needs and requirements students\r\nwill learn to appropriately address design issues, as well as develop and adapt the ideas\r\nto meet those needs and requirements.', 1, '150 hours');

-- --------------------------------------------------------

--
-- Table structure for table `unit_teacher`
--

CREATE TABLE `unit_teacher` (
  `unit_teacher_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unit_teacher`
--

INSERT INTO `unit_teacher` (`unit_teacher_id`, `unit_id`, `class_id`, `teacher_id`) VALUES
(50, 1, 1, 40),
(44, 1, 1, 48),
(26, 1, 2, 44),
(17, 1, 2, 51),
(32, 1, 4, 44),
(45, 2, 1, 44),
(27, 2, 2, 44),
(22, 2, 3, 48),
(33, 2, 4, 44),
(48, 3, 1, 51),
(28, 3, 2, 44),
(34, 3, 4, 44),
(46, 4, 1, 47),
(29, 4, 2, 44),
(35, 4, 4, 44),
(49, 5, 1, 51),
(30, 5, 2, 44),
(36, 5, 4, 44);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `profile_photo` varchar(255) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `institute_id` int(11) DEFAULT NULL,
  `must_change_password` tinyint(1) DEFAULT 1,
  `is_independent` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password_hash`, `first_name`, `last_name`, `date_of_birth`, `is_active`, `created_at`, `profile_photo`, `role_id`, `institute_id`, `must_change_password`, `is_independent`) VALUES
(40, 'kparascandalo@gmail.com', NULL, 'Charmaine', 'Parascandalo Hili', '2025-12-03', 1, '2025-12-15 18:15:34', NULL, 1, 1, 0, 0),
(41, 'kimberly.parascandalo.e22247@mcast.edu.mt', '$2y$10$hNWIM.VGnNqKzxZBDkA/IOWKwnM9w8V7SjbNPySwfAUpnWEKlVilO', 'Kimberly', 'Parascandalo', '2003-05-09', 1, '2025-12-15 18:39:04', NULL, 2, 1, 0, 0),
(42, 'kevinpara@gmail.com', '$2y$10$zYT1qPlQjoulOPs5XPJHbONB11Q2D2Omgrt3JVdlE/jDPn6D.WGYO', 'Kevin Ray', 'Parascandalo', '2019-05-14', 1, '2025-12-15 19:45:18', NULL, 2, 2, 0, 0),
(44, 'maryborg@gmail.com', '$2y$10$Njw2d9RXi4bfLDLwXFa1mOKW.1C.KE7BPMIsyU4LVYWbT.igFFpOe', 'Mary', 'Borg', '2025-12-01', 1, '2025-12-16 09:40:00', NULL, 1, 1, 0, 0),
(45, 'katehili@gmail.com', '$2y$10$Fwz4WfGBGG7Fay8Y/ki/JuUBUcE.k28ktB7CJMPsa1SGUFUO8XjVq', 'Kate', 'Hili', '2025-12-01', 1, '2025-12-16 10:03:35', NULL, 2, 1, 1, 0),
(46, 'mayborg@gmail.com', '$2y$10$Qf4A9LdXTL.GkRYUvOeDyO3LXUrrma0DUHzE1AKRNwuwQrb3n7uMO', 'May', 'Borg', '2025-11-30', 1, '2025-12-16 10:07:34', NULL, 2, 1, 1, 0),
(47, 'royborg@gmail.com', '$2y$10$co3Kvpzopb0MFVGbaYgmteaQoyQEoe4lf6./aKHGx.fhLaKMfq8gG', 'Roy', 'Borg', '2025-12-01', 1, '2025-12-16 10:10:23', NULL, 1, 3, 1, 0),
(48, 'raycassar@gmail.com', '$2y$10$VESVxZ5Gst9JIJywoIkLb.KUf6NeUdXjcs3J5fX..TYoMKwloLdJu', 'Ray', 'Cassar', '2025-12-03', 1, '2025-12-16 10:18:31', NULL, 1, 1, 0, 0),
(49, 'kimdelia@gmail.com', '$2y$10$oNdbXSGjzTQkLjUb2Tv/L.lUM5vXqlOZpgQRrPGZmKOAevs537l8O', 'Kim', 'Delia', '2025-12-03', 1, '2025-12-16 10:33:43', NULL, 2, 1, 0, 0),
(50, 'katiakurmi@gmail.com', '$2y$10$mS1SYCBBLM2ANW0BfOwRCOFWOBZQhuoMEgbnwTLEytFBokRuVubBK', 'Katia', 'Curmi', '2025-12-04', 1, '2025-12-16 11:55:33', NULL, 4, 1, 0, 0),
(51, 'ian@gmail.com', '$2y$10$JqlvZAbYQYRMBGNdfhA6Vu2ixULRO5YkLxrptoLXyZpMvFhrmiFOC', 'Ian', 'Vella', '2025-02-25', 1, '2026-01-12 15:40:00', '51-69654400b05aa9.96099892.png', 1, 1, 0, 0),
(52, 'pam@gmail.com', '$2y$10$v3o5ozmH.BxbdZxxBnzJeeoJmSku4yKP1t019FKxAG3r6nBTMlzz2', 'Pam', 'Callus', '2018-01-15', 1, '2026-01-14 14:31:55', '52-69679e253fd2b0.96273244.png', 2, 1, 0, 0),
(53, 'kevinp@gmail.com', '$2y$10$KMuaEX.frEb/339ICg2TjuJTVoqX8S5wUkodCZRVwHoNgAOruC/XS', 'kevin', 'p', '1970-08-18', 1, '2026-01-15 19:52:07', NULL, 2, 2, 0, 0),
(54, 'ahiliangels@gmail.com', '$2y$10$Xl3IW4.SEzURtbMAelyBUecHMiOAfc9OGHobEpRZeesM9hSItQnAy', 'Lawrence', 'Hili', '1951-09-24', 1, '2026-01-18 17:26:54', '54-696d0ada5e8422.83668195.png', 4, 1, 0, 0),
(55, 'kurt@gmail.com', '$2y$10$0AjGRqvABaRUZ22HNDgx5Ofr/ep.K8EQDWaZTU9Kg8HgmknWRxBfa', 'Kurt', 'Camilleri', '1890-03-23', 1, '2026-01-22 14:25:51', NULL, 2, 1, 1, 0),
(56, 'charles@gmail.com', '$2y$10$EROXuv2jx5gHEmGpQ4qUVeW2MRHnB4DJVheLLsXlSbPxvJjbKW/4O', 'Charles', 'Vella', '1990-02-03', 1, '2026-01-22 14:28:21', NULL, 1, 1, 1, 0),
(58, 'peter@gmail.com', '$2y$10$NP04E7lkp.TyzAQFCNqTe.XG8TmMWPwNAIoYUAWWk8UYG/TnNCI1m', 'Peter', 'Portelli', '2000-07-09', 1, '2026-01-22 15:13:25', NULL, 1, NULL, 0, 1),
(59, 'tim@gmail.com', '$2y$10$PtdffiKU8AaWzHv8PKD1L.plNpWM9O0tW2qIbPj6TjJmvveSPtPwa', 'Tim', 'Vella', '2001-03-06', 1, '2026-01-22 15:14:56', NULL, 2, NULL, 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignment`
--
ALTER TABLE `assignment`
  ADD PRIMARY KEY (`assignment_id`),
  ADD KEY `FK_assignment_unit` (`unit_id`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`chat_id`);

--
-- Indexes for table `chat_member`
--
ALTER TABLE `chat_member`
  ADD PRIMARY KEY (`chat_member_id`),
  ADD KEY `FK_chatMember_chat` (`chat_id`),
  ADD KEY `FK_chatMember_user` (`user_id`);

--
-- Indexes for table `chat_message`
--
ALTER TABLE `chat_message`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `FK_chatMessage_chat2` (`chat_id`),
  ADD KEY `FK_chatMessage_sender` (`sender_id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`class_id`),
  ADD KEY `FK_classes_course` (`course_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`),
  ADD UNIQUE KEY `course_code` (`course_code`),
  ADD KEY `FK_course_institute` (`institute_id`);

--
-- Indexes for table `course_units`
--
ALTER TABLE `course_units`
  ADD PRIMARY KEY (`course_unit_id`),
  ADD UNIQUE KEY `uq_course_unit` (`course_id`,`unit_id`),
  ADD UNIQUE KEY `uniq_course_unit` (`course_id`,`unit_id`),
  ADD KEY `fk_course_units_unit` (`unit_id`);

--
-- Indexes for table `enrolment`
--
ALTER TABLE `enrolment`
  ADD PRIMARY KEY (`enrolment_id`),
  ADD KEY `FK_enrolment_student` (`student_id`),
  ADD KEY `FK_enrolment_course` (`course_id`),
  ADD KEY `fk_enrolment_class` (`class_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `FK_events_user` (`user_id`),
  ADD KEY `FK_events_course` (`course_id`),
  ADD KEY `FK_events_unit` (`unit_id`);

--
-- Indexes for table `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`file_id`),
  ADD KEY `FK_file_uploadBy` (`uploaded_by`),
  ADD KEY `FK_file_unit` (`unit_id`);

--
-- Indexes for table `grade`
--
ALTER TABLE `grade`
  ADD PRIMARY KEY (`grade_id`),
  ADD KEY `FK_grade_submission` (`submission_id`),
  ADD KEY `FK_grade_teacher` (`teacher_id`);

--
-- Indexes for table `institute`
--
ALTER TABLE `institute`
  ADD PRIMARY KEY (`institute_id`);

--
-- Indexes for table `institute_admin`
--
ALTER TABLE `institute_admin`
  ADD PRIMARY KEY (`institute_admin_id`),
  ADD KEY `FK_institute_institute_admin` (`institute_id`),
  ADD KEY `FK_admin_institue_admin` (`admin_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `FK_notification_sender` (`sender_id`),
  ADD KEY `FK_notification_receiver` (`receiver_id`);

--
-- Indexes for table `parent_student`
--
ALTER TABLE `parent_student`
  ADD PRIMARY KEY (`parent_student_id`),
  ADD UNIQUE KEY `uq_parent_student` (`parent_id`,`student_id`),
  ADD KEY `FK_parentStudent_child` (`student_id`);

--
-- Indexes for table `reset_password`
--
ALTER TABLE `reset_password`
  ADD PRIMARY KEY (`reset_password_id`),
  ADD KEY `FK_resetPassword_user` (`user_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `settings_theme`
--
ALTER TABLE `settings_theme`
  ADD PRIMARY KEY (`settings_theme_id`),
  ADD KEY `FK_settingsTheme_user` (`user_id`);

--
-- Indexes for table `submission`
--
ALTER TABLE `submission`
  ADD PRIMARY KEY (`submission_id`),
  ADD KEY `FK_submission_assignment` (`assignment_id`),
  ADD KEY `FK_submission_student` (`student_id`);

--
-- Indexes for table `teacher_profile`
--
ALTER TABLE `teacher_profile`
  ADD PRIMARY KEY (`teacher_id`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`unit_id`),
  ADD UNIQUE KEY `unit_code` (`unit_code`),
  ADD KEY `FK_unit_course` (`course_id`);

--
-- Indexes for table `unit_teacher`
--
ALTER TABLE `unit_teacher`
  ADD PRIMARY KEY (`unit_teacher_id`),
  ADD UNIQUE KEY `uniq_unit_class_teacher` (`unit_id`,`class_id`,`teacher_id`),
  ADD KEY `FK_unitTeacher_unit` (`unit_id`),
  ADD KEY `FK_unitTeacher_class` (`class_id`),
  ADD KEY `FK_unitTeacher_teacher` (`teacher_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `FK_users_institute` (`institute_id`),
  ADD KEY `fk_users_role` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignment`
--
ALTER TABLE `assignment`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chat_member`
--
ALTER TABLE `chat_member`
  MODIFY `chat_member_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chat_message`
--
ALTER TABLE `chat_message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `course_units`
--
ALTER TABLE `course_units`
  MODIFY `course_unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `enrolment`
--
ALTER TABLE `enrolment`
  MODIFY `enrolment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `file`
--
ALTER TABLE `file`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grade`
--
ALTER TABLE `grade`
  MODIFY `grade_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `institute`
--
ALTER TABLE `institute`
  MODIFY `institute_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `institute_admin`
--
ALTER TABLE `institute_admin`
  MODIFY `institute_admin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `parent_student`
--
ALTER TABLE `parent_student`
  MODIFY `parent_student_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reset_password`
--
ALTER TABLE `reset_password`
  MODIFY `reset_password_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `settings_theme`
--
ALTER TABLE `settings_theme`
  MODIFY `settings_theme_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `submission`
--
ALTER TABLE `submission`
  MODIFY `submission_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teacher_profile`
--
ALTER TABLE `teacher_profile`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `unit_teacher`
--
ALTER TABLE `unit_teacher`
  MODIFY `unit_teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignment`
--
ALTER TABLE `assignment`
  ADD CONSTRAINT `FK_assignment_unit` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`unit_id`) ON UPDATE CASCADE;

--
-- Constraints for table `chat_member`
--
ALTER TABLE `chat_member`
  ADD CONSTRAINT `FK_chatMember_chat` FOREIGN KEY (`chat_id`) REFERENCES `chat` (`chat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_chatMember_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `chat_message`
--
ALTER TABLE `chat_message`
  ADD CONSTRAINT `FK_chatMessage_chat` FOREIGN KEY (`chat_id`) REFERENCES `chat` (`chat_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_chatMessage_sender` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `FK_classes_course` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`);

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `FK_course_institute` FOREIGN KEY (`institute_id`) REFERENCES `institute` (`institute_id`) ON UPDATE CASCADE;

--
-- Constraints for table `course_units`
--
ALTER TABLE `course_units`
  ADD CONSTRAINT `fk_course_units_course` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_course_units_unit` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`unit_id`) ON DELETE CASCADE;

--
-- Constraints for table `enrolment`
--
ALTER TABLE `enrolment`
  ADD CONSTRAINT `FK_enrolment_course` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_enrolment_student` FOREIGN KEY (`student_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_enrolment_class` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `FK_events_course` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_events_unit` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`unit_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_events_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `file`
--
ALTER TABLE `file`
  ADD CONSTRAINT `FK_file_unit` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`unit_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_file_uploadBy` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `grade`
--
ALTER TABLE `grade`
  ADD CONSTRAINT `FK_grade_submission` FOREIGN KEY (`submission_id`) REFERENCES `submission` (`submission_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_grade_teacher` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `institute_admin`
--
ALTER TABLE `institute_admin`
  ADD CONSTRAINT `FK_admin_institue_admin` FOREIGN KEY (`admin_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_institute_institute_admin` FOREIGN KEY (`institute_id`) REFERENCES `institute` (`institute_id`) ON UPDATE CASCADE;

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `FK_notification_receiver` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_notification_sender` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `parent_student`
--
ALTER TABLE `parent_student`
  ADD CONSTRAINT `FK_parentStudent_child` FOREIGN KEY (`student_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_parentStudent_parent` FOREIGN KEY (`parent_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_parentStudent_users` FOREIGN KEY (`parent_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `reset_password`
--
ALTER TABLE `reset_password`
  ADD CONSTRAINT `FK_resetPassword_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `settings_theme`
--
ALTER TABLE `settings_theme`
  ADD CONSTRAINT `FK_settingsTheme_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `submission`
--
ALTER TABLE `submission`
  ADD CONSTRAINT `FK_submission_assignment` FOREIGN KEY (`assignment_id`) REFERENCES `assignment` (`assignment_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_submission_student` FOREIGN KEY (`student_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `teacher_profile`
--
ALTER TABLE `teacher_profile`
  ADD CONSTRAINT `FK_teacherprofile_user` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `unit`
--
ALTER TABLE `unit`
  ADD CONSTRAINT `FK_unit_course` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `unit_teacher`
--
ALTER TABLE `unit_teacher`
  ADD CONSTRAINT `FK_unitTeacher_class` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_unitTeacher_unit` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`unit_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_unitTeacher_user` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_users_institute` FOREIGN KEY (`institute_id`) REFERENCES `institute` (`institute_id`),
  ADD CONSTRAINT `fk_users_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
