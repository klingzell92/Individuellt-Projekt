--
-- Creating a User table and inserting example users.
-- Create a database and a user having access to this database,
-- this must be done by hand, se commented rows on how to do it.
--



--
-- Create a database for test
--
-- DROP DATABASE anaxdb;
-- CREATE DATABASE IF NOT EXISTS anaxdb;
USE phkl16;



--
-- Create a database user for the test database
--
-- GRANT ALL ON anaxdb.* TO anax@localhost IDENTIFIED BY 'anax';



-- Ensure UTF8 on the database connection
SET NAMES utf8;



--
-- Table User
--
DROP TABLE IF EXISTS Quiz;
CREATE TABLE Quiz (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `acronym` VARCHAR(80) NOT NULL,
    `course` VARCHAR(80) NOT NULL,
    `test` VARCHAR(80) NOT NULL,
    `result` INTEGER NOT NULL,
    `time` VARCHAR(4) NOT NULL,
    `times_test_done` INTEGER NOT NULL,
    `questions` TEXT NOT NULL,
    `answers` TEXT NOT NULL,
    `created` DATETIME,
    `updated` DATETIME,
    `deleted` DATETIME,
    `active` DATETIME 
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

SELECT * FROM Quiz;