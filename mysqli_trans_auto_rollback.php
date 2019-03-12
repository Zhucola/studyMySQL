<?php
//自动事务回滚
class mysqliTransAutoRollback{
	public $conn_id;
	public $host;
	public $username;
	public $pwd;
	public $database;
	public $port = 3306;
	public $trans_status = TRUE;
	public $trans_start = FALSE;
	public $trans_debug = FALSE;
	public $errors = [];

	public function connect(){
		$this->conn_id = mysqli_init();
		$this->conn_id->options(MYSQLI_OPT_CONNECT_TIMEOUT, 3);
		$this->conn_id->options(MYSQLI_INIT_COMMAND, 'SET SESSION sql_mode = CONCAT(@@sql_mode, ",", "STRICT_ALL_TABLES")');
		$this->conn_id->real_connect($this->host, $this->username, $this->pwd, $this->database, $this->port, null, 0);
		$this->conn_id->set_charset("utf8");
	}

	public function query($sql){
		$query = $this->conn_id->query($sql);
		if(FALSE === $query){
			//error和errno是上一个mysql操作的错误信息，如果执行了query错误，然后直接commit,则error和errno是commit的错误信息
			$this->error();
			if(TRUE === $this->trans_start){
				$this->trans_status = FALSE;
				//自动回滚
				if(TRUE === $this->trans_debug){
					$this->trans_complete();
					$this->displayTransError();
				}
			}
		}
	}

	public function trans_start(){
		$this->conn_id->autocommit(FALSE);
		version_compare(PHP_VERSION, "5.5", '>=') ? $this->conn_id->begin_transaction() : $this->conn_id->query('START TRANSACTION');
		$this->trans_start = TRUE;
	}

	public function trans_rollback(){
		if (TRUE !== $this->trans_start){
			return FALSE;
		}
		if ($this->conn_id->rollback()){
			$this->conn_id->autocommit(TRUE);
			return TRUE;
		}
		return FALSE;
	}

	public function trans_complete(){
		//事务未开启
		if ($this->trans_start === FALSE){
			return FALSE;
		}
		//事务有异常query
		if ($this->trans_status === FALSE){
			$this->trans_rollback();
			return FALSE;
		}
		if ($this->conn_id->commit()){
			$this->conn_id->autocommit(TRUE);
			return TRUE;
		}
		return FALSE;
	}

	public function displayTransError(){
		var_dump($this->errors);
		die;
	}

	public function error(){
		$this->errors[] = [
			"code"=>$this->conn_id->errno,
			"msg"=>$this->conn_id->error
		];
	}

	public function close(){
		$this->conn_id->close();
	}
}

//-----------------自动回滚--------------------------
$db1 = new mysqliTransAutoRollback();
$db1->host = "192.168.124.10";
$db1->username = "root";
$db1->pwd = "";
$db1->database = "study";
$db1->trans_debug = TRUE;
$db1->connect();
$db1->trans_start();
$db1->query("INSERT INTO `user`(name,age) VALUE('asd',132)");
$db1->query("INSERT INTO `user`(name,age) VALUE('as2',22)");
$db1->query("INSERT INTO `user`(name,age) VALUE('as3',33)");
$db1->trans_complete();
$db1->close();

//-----------------不自动回滚--------------------------
$db2 = new mysqliTransAutoRollback();
$db2->host = "192.168.124.10";
$db2->username = "root";
$db2->pwd = "";
$db2->database = "study";
$db2->trans_debug = FALSE;
$db2->connect();
$db2->trans_start();
$db2->query("INSERT INTO `user`(name,age) VALUE('asd',132)");
$db2->query("INSERT INTO `user`(name,age) VALUE('as2',22)");
$db2->query("INSERT INTO `user`(name,age) VALUE('as3',33)");
$db2->trans_complete();
if(FALSE === $db2->trans_status)
{
	var_dump($db2->error());
}