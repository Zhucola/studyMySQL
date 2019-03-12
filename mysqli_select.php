<?php
include("./mysqli_connect.php");
$sql = "SELECT * FROM `user`";
$result = $mysqli->query($sql);   //返回的$result是一个object
/*
 |-----------------------------------------------
 |select数据相关信息
 |-----------------------------------------------
*/
var_dump($result->fetch_assoc());  //关联数组，将偏移量+1
$result->data_seek(0); //重置偏移量为0，就是再继续从0位置开始
var_dump($result->fetch_assoc());
var_dump($result->fetch_array());  //关联+索引
var_dump($result->fetch_row());  //索引
var_dump($result->fetch_object("stdClass"));  //返回对象，默认参数就是stdClass
$result->free();  //将query返回的结果集释放，此后不能再使用$result
/*
 |-----------------------------------------------
 |列相关信息
 |-----------------------------------------------
*/
//field_seek(0)列的偏移量从0开始，如列有select id,age,name，则fetch_field包含id,age,name
//field_seek(1)列的偏移量从1开始，如列有select id,age,name，则fetch_field包含age,name
//偏移量不会自动重置为0，下次调用fetch_field会从上一次的fetch_field的偏移量开始
$sql = "SELECT * FROM `user`";
$result = $mysqli->query($sql);
$field_names = array();
$result->field_seek(0);  
while ($field = $result->fetch_field())
{
	$field_names[] = $field->name;
}
var_dump($field_names);  //打印所有列表
//------------------------------------------------
$result->field_seek(0);
$retval = array();
$field_data = $result->fetch_fields();
for ($i = 0, $c = count($field_data); $i < $c; $i++)
{
	$retval[$i]			= new stdClass();
	$retval[$i]->name		= $field_data[$i]->name;
	$retval[$i]->type		= get_field_type($field_data[$i]->type);
	$retval[$i]->max_length		= $field_data[$i]->max_length;
	$retval[$i]->primary_key	= (int) ($field_data[$i]->flags & MYSQLI_PRI_KEY_FLAG);
	$retval[$i]->default		= $field_data[$i]->def;
}
function get_field_type($type)
{
	static $map;
	isset($map) OR $map = array(
		MYSQLI_TYPE_DECIMAL     => 'decimal',
		MYSQLI_TYPE_BIT         => 'bit',
		MYSQLI_TYPE_TINY        => 'tinyint',
		MYSQLI_TYPE_SHORT       => 'smallint',
		MYSQLI_TYPE_INT24       => 'mediumint',
		MYSQLI_TYPE_LONG        => 'int',
		MYSQLI_TYPE_LONGLONG    => 'bigint',
		MYSQLI_TYPE_FLOAT       => 'float',
		MYSQLI_TYPE_DOUBLE      => 'double',
		MYSQLI_TYPE_TIMESTAMP   => 'timestamp',
		MYSQLI_TYPE_DATE        => 'date',
		MYSQLI_TYPE_TIME        => 'time',
		MYSQLI_TYPE_DATETIME    => 'datetime',
		MYSQLI_TYPE_YEAR        => 'year',
		MYSQLI_TYPE_NEWDATE     => 'date',
		MYSQLI_TYPE_INTERVAL    => 'interval',
		MYSQLI_TYPE_ENUM        => 'enum',
		MYSQLI_TYPE_SET         => 'set',
		MYSQLI_TYPE_TINY_BLOB   => 'tinyblob',
		MYSQLI_TYPE_MEDIUM_BLOB => 'mediumblob',
		MYSQLI_TYPE_BLOB        => 'blob',
		MYSQLI_TYPE_LONG_BLOB   => 'longblob',
		MYSQLI_TYPE_STRING      => 'char',
		MYSQLI_TYPE_VAR_STRING  => 'varchar',
		MYSQLI_TYPE_GEOMETRY    => 'geometry'
	);
	return isset($map[$type]) ? $map[$type] : $type;
}
var_dump($retval); //打印更加详细的列信息