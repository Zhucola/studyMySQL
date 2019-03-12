<?php
include("./mysqli_connect.php");
$name1 = $mysqli->real_escape_string(randStr(5));
$name2 = $mysqli->real_escape_string(randStr(5));
//$name2 = $mysqli->real_escape_string("asd\sdad");  // asd\\sdad
$sql = "INSERT INTO `user`(name,age) VALUE('{$name1}',123),('{$name2}',99)";
$res = $mysqli->query($sql);
if(false === $res){
	var_dump($mysqli->error);
	var_dump($mysqli->errno);
	die;
}
//如果一个sql插入多条数据，则返回的是第一个自增id
//注意在有auto_increment_increment 和auto_increment_offset 的情况
var_dump("insert_id:".$mysqli->insert_id);
//如果一个sql插入多条数据，则返回的是总影响行数
var_dump("affected_rows:".$mysqli->affected_rows);