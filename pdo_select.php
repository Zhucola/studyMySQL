<?php
include("./pdo_connect.php");
$sql = "SELECT * FROM `user`";
//pdo好像没有类似mysqli的data_seek，官方给的解决方案复现不了
$result = $pdo->query($sql);
try {
	while($r = $result->fetch(PDO::FETCH_ASSOC)){
		//var_dump($r);
	}
} catch (PDOException $e) {
	var_dump($e);
}
var_dump($pdo->quote("'"));
$result = $pdo->query($sql);
var_dump($result->rowCount());  //一共有多少列
$r = $result->fetchAll(PDO::FETCH_ASSOC);  //全部查出结果
/*
 |-----------------------------------------------
 |列相关信息
 |-----------------------------------------------
*/
var_dump($result->columnCount());  //一共有多少列