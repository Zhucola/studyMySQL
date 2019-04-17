<?php
include("./pdo_connect.php");
$sql = "SELECT * FROM `a` WHERE id = :id";
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,true);   //开启在本地模拟prepare
$pdoStatement = $pdo->prepare($sql);
$data = 1;
$pdoStatement->bindValue(":id", $data, paramType($data));
$pdoStatement->execute();
var_dump($pdoStatement->fetchAll(PDO::FETCH_ASSOC));

$pdoStatement = $pdo->prepare($sql);
$pdoStatement->bindParam(":id", $data, paramType($data));
$data = 2;
$pdoStatement->execute();
var_dump($pdoStatement->fetchAll(PDO::FETCH_ASSOC));

$name = mt_rand(0,10);
$pdoStatement = $pdo->prepare("UPDATE a SET name= '{$name}' WHERE id=:id");
$pdoStatement->bindParam(":id", $id,1);
$id = 1;
$pdoStatement->execute();
var_dump($pdoStatement->rowCount());

function paramType($data){
	$typeMap = [
	    // php type => PDO type
	    'boolean' => \PDO::PARAM_BOOL,
	    'integer' => \PDO::PARAM_INT,
	    'string' => \PDO::PARAM_STR,
	    'resource' => \PDO::PARAM_LOB,
	    'NULL' => \PDO::PARAM_NULL,
	];
	$type = gettype($data);
	return isset($typeMap[$type]) ? $typeMap[$type] : \PDO::PARAM_STR;
}