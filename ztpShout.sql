CREATE DATABASE `ztpShout`;
GRANT ALL PRIVILEGES ON `ztpShout`.* TO 'ztpShout'@'localhost' IDENTIFIED BY 'changeMe';
USE `ztpShout`;
CREATE TABLE `ztpShout` (
	`time` INT NOT NULL,
	`user` TEXT NOT NULL,
	`text` TEXT NOT NULL
);