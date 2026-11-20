CREATE DATABASE IF NOT EXISTS `tp_mvc25` DEFAULT CHARACTER SET utf8mb4;
USE `tp_mvc25`;

DROP TABLE IF EXISTS `courses`;
DROP TABLE IF EXISTS `lecturers`;
DROP TABLE IF EXISTS `departments`;

CREATE TABLE `departments` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `faculty` VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE `lecturers` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `nidn` VARCHAR(20) NOT NULL,
  `phone` VARCHAR(20) NOT NULL,
  `join_date` DATE NOT NULL,
  `department_id` INT NULL,
  CONSTRAINT `fk_lecturer_department` FOREIGN KEY (`department_id`)
    REFERENCES `departments`(`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `courses` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `code` VARCHAR(20) NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `credits` TINYINT NOT NULL DEFAULT 3,
  `lecturer_id` INT NULL,
  CONSTRAINT `fk_course_lecturer` FOREIGN KEY (`lecturer_id`)
    REFERENCES `lecturers`(`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

INSERT INTO `departments` (`name`, `faculty`) VALUES
('Ilmu Komputer', 'FPMIPA'),
('Pendidikan Matematika', 'FPMIPA'),
('Teknik Elektro', 'FPTK');

INSERT INTO `lecturers` (`name`, `nidn`, `phone`, `join_date`, `department_id`) VALUES
('Budi Santoso', '0012345601', '081234567801', '2015-08-17', 1),
('Siti Aminah', '0012345602', '081234567802', '2018-02-01', 1),
('Andi Wijaya', '0012345603', '081234567803', '2020-09-10', 2);

INSERT INTO `courses` (`code`, `name`, `credits`, `lecturer_id`) VALUES
('IK101', 'Desain dan Pemrograman Berbasis Objek', 3, 1),
('IK102', 'Basis Data', 3, 2),
('MT201', 'Kalkulus', 4, 3);
