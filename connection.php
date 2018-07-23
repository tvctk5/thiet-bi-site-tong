<?php
Class dbObj{
	/* Database connection start */
	var $servername = "127.0.0.1";
	var $username = "phpmyadmin";
	var $password = "123**abc";
	var $dbname = "trantu";
	var $conn;
	function getConnstring() {
		$con = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname) or die("Connection failed: " . mysqli_connect_error());

		/* check connection */
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		} else {
			$this->conn = $con;
		}
		return $this->conn;
	}
}

?>