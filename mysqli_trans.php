<?php
include("./mysqli_connect.php");
//-----------------以下代码不会自动回滚-------------------------------
//关闭自动提交
$mysqli->autocommit(FALSE);
version_compare(PHP_VERSION, "5.5", '>=') ? $mysqli->begin_transaction() : $mysqli->query('START TRANSACTION');

$name1 = $mysqli->real_escape_string(randStr(5));
$name2 = $mysqli->real_escape_string(randStr(5));
$name3 = $mysqli->real_escape_string(randStr(5));
$sql1 = "INSERT INTO `user`(name,age) VALUE('{$name1}',1)";
$res2 = $mysqli->query($sql1);
$sql2 = "INSERT INTO `user`(name,age) VALUE('{$name1}',2)";  //异常sql
$res2 = $mysqli->query($sql2);
$sql3 = "INSERT INTO `user`(name,age) VALUE('{$name3}',3)";
$res3 = $mysqli->query($sql3);
$sql4 = "INSERT INTO `user`(name,age) VALUE('{$name4}',4)";
$res5 = $mysqli->query($sql4);
$mysqli->commit();   //提交后会成功插入3条，$sql2不会成功插入
//开启自动提交
$mysqli->autocommit(true);
//------------------------------------------------------------------