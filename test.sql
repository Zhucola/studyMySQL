DROP DATABASE IF EXISTS `study`;
CREATE DATABASE `study`;
USE `study`;
CREATE TABLE `user`(
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`name` VARCHAR(32) NOT NULL UNIQUE KEY,
	`age` TINYINT UNSIGNED NOT NULL DEFAULT "66",
	`create_time` timestamp
)engine=innodb;

CREATE TABLE `test`(
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`uid` INT UNSIGNED NOT NULL,
	`height` INT UNSIGNED NOT NULL DEFAULT "123",
	`create_time` timestamp
)engine=innodb;

DROP PROCEDURE IF EXISTS `test_insert`;
DELIMITER &&
CREATE PROCEDURE test_insert() 
BEGIN 
DECLARE i INT DEFAULT 1;
WHILE i<=100
DO 
	INSERT INTO `user`(name,age) VALUES(left(sha1(i),7),i); 
	INSERT INTO `test`(uid,height) VALUES(i,floor(rand()*100)); 
SET i=i+1; 
END WHILE; 
commit; 
END &&

DELIMITER ;
call test_insert();

#INSERT INTO `user`(name,age) VALUES("asd",1); 
#INSERT INTO `user`(name,age) VALUES("xxx",2); 
#INSERT INTO `user`(name,age) VALUES("ii",3); 
#INSERT INTO `user`(name,age) VALUES("qq",4); 
#INSERT INTO `user`(name,age) VALUES("kk",5); 