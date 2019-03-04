DROP DATABASE IF EXISTS `study`;
CREATE DATABASE `study`;
USE `study`;
CREATE TABLE `user`(
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`name` VARCHAR(32) NOT NULL UNIQUE KEY,
	`age` TINYINT UNSIGNED NOT NULL DEFAULT "66",
	`create_time` timestamp
)engine=innodb;

DROP PROCEDURE IF EXISTS `test_insert`;
DELIMITER &&
CREATE PROCEDURE test_insert() 
BEGIN 
DECLARE i INT DEFAULT 1;
WHILE i<=30
DO 
	INSERT INTO `user`(name,age) VALUES(left(sha1(i),7),i); 
SET i=i+1; 
END WHILE; 
commit; 
END &&

DELIMITER ;
call test_insert();