-- Import this file in phpMyAdmin to create the database and both tables.
CREATE DATABASE IF NOT EXISTS `db_wazfuli`
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `db_wazfuli`;

-- TASK 1: User accounts. This schema is provided for the exercise.
CREATE TABLE IF NOT EXISTS `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(50) NOT NULL,
    `email` varchar(100) NOT NULL,
    `password` varchar(255) NOT NULL,
    `role` enum('analyst', 'manager', 'director') NOT NULL DEFAULT 'analyst',
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `username` (`username`),
    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- TASK 2 AND 3: Each file belongs to one user through user_id.
CREATE TABLE IF NOT EXISTS `files` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `original_name` varchar(255) NOT NULL,
    `stored_name` varchar(255) NOT NULL,
    `file_size` int(11) NOT NULL,
    `file_type` varchar(50) NOT NULL,
    `uploaded_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Complete registration first. Save password hashes, not plain-text passwords.
-- For the role exercise, register your main admin account through the website.
-- In phpMyAdmin, edit that account and change its role to director.
-- New accounts from the registration form must always have the analyst role.
