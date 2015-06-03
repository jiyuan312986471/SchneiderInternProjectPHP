<?php

class bdd {

	private $hostname;
	private $userdb;
	private $passdb;
	private $database;
	private $connect;
	
	public function __construct($host,$user,$pass,$data) {
		$this->hostname = $host;
		$this->userdb   = $user;
		$this->passdb   = $pass;
		$this->database = $data;
		$this->Condb();
	}
	
	public function getConn() {
		return $this->connect;
	}
	
	private function Condb() {
		$connectionInfo = array("UID" => $this->userdb, "PWD" => $this->passdb, "Database" => $this->database);
		$this->connect = sqlsrv_connect( $this->hostname, $connectionInfo);
		if(!$this->connect) {
			echo "Errrrooor<br/>";	
			die( print_r( sqlsrv_errors(), true));
			echo "<br/>";
		}
		else {
			return $this->connect;
		}
	}
	
	public function __destruct() {
		sqlsrv_close($this->connect);	
	}
	
}

?>