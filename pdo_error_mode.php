<?php
include("./pdo_connect.php");
//异常模式，会自动捕获异常
function test_exception_mode($pdo){
	$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	try {
		$sql = "SELECT * FROM `user`";  //表不存在
		$result = $pdo->query($sql);
	} catch (PDOException $e) {
		var_dump($e);
		var_dump($pdo->errorinfo()); //[0=>"42S02",1=>1146,2=>"Table 'study.usaer' doesn't exist"]，如果正确是[0=>"42S02，如果正确是00000",1=>null,2=>null]
		var_dump($pdo->errorCode()); //42S02，如果正确是00000
	}
}
//silent模式，不会被try捕获，不会报错
function test_silent_mode($pdo){
	$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_SILENT);
	try {
		$sql = "SELECT * FROM `usaer`";  //表不存在
		$result = $pdo->query($sql);
		var_dump($result);  //false
		var_dump($pdo->errorinfo()); //[0=>"42S02",1=>1146,2=>"Table 'study.usaer' doesn't exist"]
	} catch (PDOException $e) {
		var_dump($e);
	}
}
//warning模式，不会被try捕获，报warning
function test_warning_mode($pdo){
	$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
	try {
		$sql = "SELECT * FROM `usaer`";  //表不存在
		$result = $pdo->query($sql);
		var_dump($result);  //false
		var_dump($pdo->errorinfo()); //[0=>"42S02",1=>1146,2=>"Table 'study.usaer' doesn't exist"]
	} catch (PDOException $e) {
		var_dump($e);
	}
}
test_warning_mode($pdo);
test_silent_mode($pdo);
test_exception_mode($pdo);