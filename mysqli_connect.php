<?php
$hostname = "192.168.0.12";
$username = "root";
$pwd = "";
$database = "study";
$port = 3306;
$compress = TRUE;
$persistent = FALSE;
$connect_timeout = 3;
$charset = "utf8";
$client_flags = ($compress === TRUE) ? MYSQLI_CLIENT_COMPRESS : 0;
$mysqli = mysqli_init();
$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, $connect_timeout);
$mysqli->options(MYSQLI_INIT_COMMAND, 'SET SESSION sql_mode = CONCAT(@@sql_mode, ",", "STRICT_ALL_TABLES")');
$hostname = ($persistent === TRUE) ? 'p:'.$hostname : $hostname;
$mysqli->real_connect($hostname, $username, $pwd, $database, $port, null, $client_flags);
$mysqli->set_charset($charset);

function randStr($len){
	$res = "";
	$str = "abcdefghijklmnopqrstuvwxyz";
	$str_len = strlen($str);
	for($i=0;$i<$len;$i++){
		$res.=$str[mt_rand(0,$str_len-1)];
	}
	return $res;
}
