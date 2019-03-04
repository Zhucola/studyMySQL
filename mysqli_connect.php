<?php
$compress = true;
$client_flags = ($compress === TRUE) ? MYSQLI_CLIENT_COMPRESS : 0;
$mysqli = mysqli_init();
$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 1);
$mysqli->options(MYSQLI_INIT_COMMAND, 'SET SESSION sql_mode = CONCAT(@@sql_mode, ",", "STRICT_ALL_TABLES")');
$mysqli->real_connect("192.168.0.12", "root", "", "study", 3306, null, $client_flags);
$mysqli->set_charset("utf8");

function randStr($len)
{
	$res = "";
	$str = "abcdefghijklmnopqrstuvwxyz";
	$str_len = strlen($str);
	for($i=0;$i<$len;$i++)
	{
		$res.=$str[mt_rand(0,$str_len-1)];
	}
	return $res;
}
