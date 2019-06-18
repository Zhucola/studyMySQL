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

<?php
$pdo = new PDO("mysql:host=192.168.124.10;dbname=test;port=3306","root","",[PDO::ATTR_TIMEOUT => 10,]);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "select * from a";
$pdoStatement = $pdo->prepare($sql);
$pdoStatement->execute();
var_dump($pdoStatement->fetchAll(PDO::FETCH_ASSOC));
var_dump($pdoStatement->fetchAll(PDO::FETCH_ASSOC));  //输出为空
var_dump($pdoStatement->fetch(PDO::FETCH_ASSOC));
var_dump($pdoStatement->fetch(PDO::FETCH_COLUMN));


$pdo = new PDO("mysql:host=192.168.124.10;dbname=test;port=3306","root","",[PDO::ATTR_TIMEOUT => 10,]);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "select * from a";
$pdoStatement = $pdo->prepare($sql);
$pdoStatement->execute();
var_dump($pdoStatement->fetchAll(PDO::FETCH_ASSOC));
$pdoStatement->execute();  //想要用一个pdo句柄再次执行必须execute
var_dump($pdoStatement->fetchAll(PDO::FETCH_ASSOC));
$pdoStatement->execute();
var_dump($pdoStatement->fetch(PDO::FETCH_ASSOC));
$pdoStatement->execute();
var_dump($pdoStatement->fetch(PDO::FETCH_COLUMN));
