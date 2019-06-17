<?php
$hostname = "192.168.124.10";
$username = "root";
$pwd = "";
$database = "test";
$port = 3306;
$compress = TRUE;
$persistent = FALSE;
$connect_timeout = 1;
$charset = "utf8";
//fetch_style
$fetch_style = PDO::FETCH_BOTH;  //默认，返回一个索引为结果集列名和以0开始的列号的数组
$fetch_style = PDO::FETCH_ASSOC;  //返回一个索引为结果集列名的数组
$fetch_style = PDO::FETCH_CLASS;  //返回一个请求类的新实例
$fetch_style = PDO::FETCH_CLASS | PDO::FETCH_CLASSTYPE;  //返回一个请求类的新实例
$fetch_style = PDO::FETCH_BOUND;  //返回 TRUE ，并分配结果集中的列值给 PDOStatement::bindColumn() 方法绑定的 PHP 变量
$fetch_style = PDO::FETCH_NUM;  //返回一个索引为以0开始的结果集列号的数组
$fetch_style = PDO::FETCH_OBJ;  //返回一个属性名对应结果集列名的匿名对象
//error_mode
$error_mode = PDO::ERRMODE_SILENT;
$error_mode = PDO::ERRMODE_WARNING;
$error_mode = PDO::ERRMODE_EXCEPTION;
//compress
$client_flags = ($compress === TRUE) ? MYSQLI_CLIENT_COMPRESS : 0;
$dsn = "mysql:host={$hostname};port={$port};dbname={$database};charset={$charset}";
$options = [
	PDO::MYSQL_ATTR_COMPRESS => $compress ? true:false,
	PDO::ATTR_PERSISTENT => $persistent ? true:false,
	PDO::ATTR_TIMEOUT => $connect_timeout,
	PDO::ATTR_ERRMODE=>$error_mode,//无论如何设置，new PDO时候出错都会抛出异常
	PDO::ATTR_DEFAULT_FETCH_MODE=>$fetch_style,
];
try{
	$pdo = new PDO($dsn, $username, $pwd, $options);
	$pdo->exec("SET NAMES " . $pdo->quote($charset));
	$pdo->setAttribute(PDO::ATTR_AUTOCOMMIT,1);
	//echo $pdo->getAttribute(PDO::ATTR_CLIENT_VERSION);  //mysqlnd 5.0.12-dev - 20150407 - $Id: b396954eeb2d1d9ed7902b8bae237b287f21ad9e $
	//echo $pdo->getAttribute(PDO::ATTR_SERVER_VERSION); //5.6.35-log
	//echo $pdo->getAttribute(PDO::ATTR_DRIVER_NAME); //mysql  驱动类型
}catch (PDOException $e){
	var_dump($e);
}
function randStr($len){
	$res = "";
	$str = "abcdefghijklmnopqrstuvwxyz";
	$str_len = strlen($str);
	for($i=0;$i<$len;$i++){
		$res.=$str[mt_rand(0,$str_len-1)];
	}
	return $res;
}
