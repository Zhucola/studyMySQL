<?php
include("./mysqli_connect.php");
/*
 |-------------------------------------------------
 |最基本的事务处理
 |-------------------------------------------------
 |缺点:
 |1.如果rollback，打印$mysqli->error无法获取具体错误信息
 |2.有一个query出错，还会继续执行其他query，显然其他query是多余的
*/
$mysqli->autocommit(FALSE);
version_compare(PHP_VERSION, "5.5", '>=') ? $mysqli->begin_transaction() : $mysqli->query('START TRANSACTION');
$name1 = $mysqli->real_escape_string(randStr(5));
$name2 = $mysqli->real_escape_string(randStr(5));
$name3 = $mysqli->real_escape_string(randStr(5));
$name4 = $mysqli->real_escape_string(randStr(5));
$sql1 = "INSERT INTO `user`(name,age) VALUE('{$name1}',1)";
$res1 = $mysqli->query($sql1);
$sql2 = "INSERT INTO `user`(name,age) VALUE('{$name1}',2)";  //异常sql
$res2 = $mysqli->query($sql2);
$sql3 = "INSERT INTO `user`(name,age) VALUE('{$name3}',3)";
$res3 = $mysqli->query($sql3);
$sql4 = "DELETE FROM `user` WHERE `uid` = 123"; //异常sql
$res4 = $mysqli->query($sql4);
if($res1 && $res2 && $res3 && $res4){
	$mysqli->commit();	
}else{
	$mysqli->rollback();	
}
$mysqli->autocommit(TRUE);