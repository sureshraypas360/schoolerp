-- School ERP — Full Database Setup (schema + demo data)
-- phpMyAdmin দিয়ে ইমপোর্ট করুন। এতে migrate/artisan লাগবে না।
-- Demo login (সবার পাসওয়ার্ড: password):
--   admin@school.test / teacher@school.test / student@school.test / staff@school.test

SET FOREIGN_KEY_CHECKS=0;
SET NAMES utf8mb4;

-- =====================================================
-- users
-- =====================================================
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','teacher','student','staff') NOT NULL DEFAULT 'student',
  `phone` varchar(255) DEFAULT NULL,
  `address` text,
  `avatar` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- schools
-- =====================================================
CREATE TABLE `schools` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text,
  `logo` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- school_classes
-- =====================================================
CREATE TABLE `school_classes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `school_classes_school_id_foreign` (`school_id`),
  CONSTRAINT `school_classes_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- sections
-- =====================================================
CREATE TABLE `sections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `class_id` bigint unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sections_class_id_foreign` (`class_id`),
  CONSTRAINT `sections_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `school_classes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- subjects
-- =====================================================
CREATE TABLE `subjects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint unsigned NOT NULL,
  `class_id` bigint unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subjects_school_id_foreign` (`school_id`),
  KEY `subjects_class_id_foreign` (`class_id`),
  CONSTRAINT `subjects_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  CONSTRAINT `subjects_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `school_classes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- teachers
-- =====================================================
CREATE TABLE `teachers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `school_id` bigint unsigned NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `teachers_employee_id_unique` (`employee_id`),
  KEY `teachers_user_id_foreign` (`user_id`),
  KEY `teachers_school_id_foreign` (`school_id`),
  CONSTRAINT `teachers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `teachers_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- students
-- =====================================================
CREATE TABLE `students` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `school_id` bigint unsigned NOT NULL,
  `class_id` bigint unsigned NOT NULL,
  `section_id` bigint unsigned NOT NULL,
  `admission_no` varchar(255) NOT NULL,
  `roll_no` varchar(255) DEFAULT NULL,
  `guardian_name` varchar(255) DEFAULT NULL,
  `guardian_phone` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `admission_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `students_admission_no_unique` (`admission_no`),
  KEY `students_user_id_foreign` (`user_id`),
  KEY `students_school_id_foreign` (`school_id`),
  KEY `students_class_id_foreign` (`class_id`),
  KEY `students_section_id_foreign` (`section_id`),
  CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `students_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  CONSTRAINT `students_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `school_classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `students_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- staff
-- =====================================================
CREATE TABLE `staff` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `school_id` bigint unsigned NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `staff_employee_id_unique` (`employee_id`),
  KEY `staff_user_id_foreign` (`user_id`),
  KEY `staff_school_id_foreign` (`school_id`),
  CONSTRAINT `staff_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `staff_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- teacher_subject
-- =====================================================
CREATE TABLE `teacher_subject` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `teacher_id` bigint unsigned NOT NULL,
  `subject_id` bigint unsigned NOT NULL,
  `section_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `teacher_subject_teacher_id_foreign` (`teacher_id`),
  KEY `teacher_subject_subject_id_foreign` (`subject_id`),
  KEY `teacher_subject_section_id_foreign` (`section_id`),
  CONSTRAINT `teacher_subject_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `teacher_subject_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `teacher_subject_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- attendances
-- =====================================================
CREATE TABLE `attendances` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint unsigned NOT NULL,
  `section_id` bigint unsigned NOT NULL,
  `date` date NOT NULL,
  `status` enum('present','absent','late','leave') NOT NULL DEFAULT 'present',
  `marked_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `attendances_student_id_date_unique` (`student_id`,`date`),
  KEY `attendances_section_id_foreign` (`section_id`),
  KEY `attendances_marked_by_foreign` (`marked_by`),
  CONSTRAINT `attendances_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attendances_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attendances_marked_by_foreign` FOREIGN KEY (`marked_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- fee_types
-- =====================================================
CREATE TABLE `fee_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fee_types_school_id_foreign` (`school_id`),
  CONSTRAINT `fee_types_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- fee_invoices
-- =====================================================
CREATE TABLE `fee_invoices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint unsigned NOT NULL,
  `fee_type_id` bigint unsigned NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `paid_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `due_date` date DEFAULT NULL,
  `status` enum('unpaid','partial','paid') NOT NULL DEFAULT 'unpaid',
  `paid_at` timestamp NULL DEFAULT NULL,
  `collected_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fee_invoices_student_id_foreign` (`student_id`),
  KEY `fee_invoices_fee_type_id_foreign` (`fee_type_id`),
  KEY `fee_invoices_collected_by_foreign` (`collected_by`),
  CONSTRAINT `fee_invoices_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fee_invoices_fee_type_id_foreign` FOREIGN KEY (`fee_type_id`) REFERENCES `fee_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fee_invoices_collected_by_foreign` FOREIGN KEY (`collected_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- exams
-- =====================================================
CREATE TABLE `exams` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint unsigned NOT NULL,
  `class_id` bigint unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exams_school_id_foreign` (`school_id`),
  KEY `exams_class_id_foreign` (`class_id`),
  CONSTRAINT `exams_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exams_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `school_classes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- exam_subjects
-- =====================================================
CREATE TABLE `exam_subjects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `exam_id` bigint unsigned NOT NULL,
  `subject_id` bigint unsigned NOT NULL,
  `full_marks` int NOT NULL DEFAULT '100',
  `pass_marks` int NOT NULL DEFAULT '33',
  `exam_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exam_subjects_exam_id_foreign` (`exam_id`),
  KEY `exam_subjects_subject_id_foreign` (`subject_id`),
  CONSTRAINT `exam_subjects_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exam_subjects_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- exam_results
-- =====================================================
CREATE TABLE `exam_results` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `exam_subject_id` bigint unsigned NOT NULL,
  `student_id` bigint unsigned NOT NULL,
  `marks_obtained` decimal(6,2) DEFAULT NULL,
  `grade` varchar(255) DEFAULT NULL,
  `remarks` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `exam_results_exam_subject_id_student_id_unique` (`exam_subject_id`,`student_id`),
  KEY `exam_results_student_id_foreign` (`student_id`),
  CONSTRAINT `exam_results_exam_subject_id_foreign` FOREIGN KEY (`exam_subject_id`) REFERENCES `exam_subjects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exam_results_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- notices
-- =====================================================
CREATE TABLE `notices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `published_by` bigint unsigned NOT NULL,
  `publish_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notices_school_id_foreign` (`school_id`),
  KEY `notices_published_by_foreign` (`published_by`),
  CONSTRAINT `notices_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  CONSTRAINT `notices_published_by_foreign` FOREIGN KEY (`published_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- books
-- =====================================================
CREATE TABLE `books` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) DEFAULT NULL,
  `isbn` varchar(255) DEFAULT NULL,
  `total_copies` int NOT NULL DEFAULT '1',
  `available_copies` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `books_school_id_foreign` (`school_id`),
  CONSTRAINT `books_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- book_issues
-- =====================================================
CREATE TABLE `book_issues` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `book_id` bigint unsigned NOT NULL,
  `student_id` bigint unsigned NOT NULL,
  `issue_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `status` enum('issued','returned') NOT NULL DEFAULT 'issued',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `book_issues_book_id_foreign` (`book_id`),
  KEY `book_issues_student_id_foreign` (`student_id`),
  CONSTRAINT `book_issues_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  CONSTRAINT `book_issues_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- hostel_rooms
-- =====================================================
CREATE TABLE `hostel_rooms` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint unsigned NOT NULL,
  `room_no` varchar(255) NOT NULL,
  `capacity` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hostel_rooms_school_id_foreign` (`school_id`),
  CONSTRAINT `hostel_rooms_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- hostel_allocations
-- =====================================================
CREATE TABLE `hostel_allocations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `hostel_room_id` bigint unsigned NOT NULL,
  `student_id` bigint unsigned NOT NULL,
  `allocated_date` date NOT NULL,
  `vacated_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hostel_allocations_hostel_room_id_foreign` (`hostel_room_id`),
  KEY `hostel_allocations_student_id_foreign` (`student_id`),
  CONSTRAINT `hostel_allocations_hostel_room_id_foreign` FOREIGN KEY (`hostel_room_id`) REFERENCES `hostel_rooms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `hostel_allocations_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- transport_routes
-- =====================================================
CREATE TABLE `transport_routes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint unsigned NOT NULL,
  `route_name` varchar(255) NOT NULL,
  `vehicle_no` varchar(255) DEFAULT NULL,
  `driver_name` varchar(255) DEFAULT NULL,
  `driver_phone` varchar(255) DEFAULT NULL,
  `fare` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transport_routes_school_id_foreign` (`school_id`),
  CONSTRAINT `transport_routes_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- student_transport
-- =====================================================
CREATE TABLE `student_transport` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `transport_route_id` bigint unsigned NOT NULL,
  `student_id` bigint unsigned NOT NULL,
  `assigned_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `student_transport_transport_route_id_foreign` (`transport_route_id`),
  KEY `student_transport_student_id_foreign` (`student_id`),
  CONSTRAINT `student_transport_transport_route_id_foreign` FOREIGN KEY (`transport_route_id`) REFERENCES `transport_routes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `student_transport_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- homeworks
-- =====================================================
CREATE TABLE `homeworks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `subject_id` bigint unsigned NOT NULL,
  `section_id` bigint unsigned NOT NULL,
  `teacher_id` bigint unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `given_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `homeworks_subject_id_foreign` (`subject_id`),
  KEY `homeworks_section_id_foreign` (`section_id`),
  KEY `homeworks_teacher_id_foreign` (`teacher_id`),
  CONSTRAINT `homeworks_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `homeworks_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  CONSTRAINT `homeworks_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- migrations table (so Laravel/artisan doesn't complain if used later)
-- =====================================================
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2024_01_01_000001_create_users_table', 1),
('2024_01_01_000002_create_academic_structure_tables', 1),
('2024_01_01_000003_create_people_tables', 1),
('2024_01_01_000004_create_attendances_table', 1),
('2024_01_01_000005_create_fees_tables', 1),
('2024_01_01_000006_create_exams_tables', 1),
('2024_01_01_000007_create_notices_table', 1),
('2024_01_01_000008_create_library_tables', 1),
('2024_01_01_000009_create_hostel_tables', 1),
('2024_01_01_000010_create_transport_tables', 1),
('2024_01_01_000011_create_homeworks_table', 1);

-- =====================================================
-- DEMO DATA
-- সবার পাসওয়ার্ড: password
-- =====================================================

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `phone`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@school.test', '$2y$10$Ex8hgqXR176DZH8zjQWuIeK64awu80GXA756.izyD/KwkVu5cSMA2', 'admin', NULL, 'active', NOW(), NOW()),
(2, 'Karim Rahman', 'teacher@school.test', '$2y$10$Ex8hgqXR176DZH8zjQWuIeK64awu80GXA756.izyD/KwkVu5cSMA2', 'teacher', NULL, 'active', NOW(), NOW()),
(3, 'Rafi Islam', 'student@school.test', '$2y$10$Ex8hgqXR176DZH8zjQWuIeK64awu80GXA756.izyD/KwkVu5cSMA2', 'student', NULL, 'active', NOW(), NOW()),
(4, 'Nasrin Akter', 'staff@school.test', '$2y$10$Ex8hgqXR176DZH8zjQWuIeK64awu80GXA756.izyD/KwkVu5cSMA2', 'staff', NULL, 'active', NOW(), NOW());

INSERT INTO `schools` (`id`, `name`, `email`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 'Green View High School', 'info@greenview.test', '01700000000', 'Dhaka, Bangladesh', NOW(), NOW());

INSERT INTO `school_classes` (`id`, `school_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Class 6', NOW(), NOW());

INSERT INTO `sections` (`id`, `class_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'A', NOW(), NOW());

INSERT INTO `subjects` (`id`, `school_id`, `class_id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Mathematics', 'MATH-06', NOW(), NOW()),
(2, 1, 1, 'English', 'ENG-06', NOW(), NOW());

INSERT INTO `teachers` (`id`, `user_id`, `school_id`, `employee_id`, `qualification`, `joining_date`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'EMP-001', 'M.Sc', DATE_SUB(CURDATE(), INTERVAL 2 YEAR), NOW(), NOW());

INSERT INTO `students` (`id`, `user_id`, `school_id`, `class_id`, `section_id`, `admission_no`, `roll_no`, `guardian_name`, `guardian_phone`, `admission_date`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 1, 1, 'ADM-0001', '1', 'Abdul Islam', '01800000000', DATE_SUB(CURDATE(), INTERVAL 6 MONTH), NOW(), NOW());

INSERT INTO `staff` (`id`, `user_id`, `school_id`, `employee_id`, `designation`, `joining_date`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 'STF-001', 'Accountant', DATE_SUB(CURDATE(), INTERVAL 1 YEAR), NOW(), NOW());

INSERT INTO `teacher_subject` (`teacher_id`, `subject_id`, `section_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NOW(), NOW());

INSERT INTO `fee_types` (`id`, `school_id`, `name`, `amount`, `created_at`, `updated_at`) VALUES
(1, 1, 'Tuition Fee (Monthly)', 1500.00, NOW(), NOW());

SET FOREIGN_KEY_CHECKS=1;
