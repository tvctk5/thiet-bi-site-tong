
<?php
	//include connection file 
	include_once("../connection.php");
	
	$db = new dbObj();
	$connString =  $db->getConnstring();

	$params = $_REQUEST;
	
	$action = isset($params['action']) != '' ? $params['action'] : '';
	$empCls = new User($connString);

	switch($action) {
	 case 'add':
		$empCls->insertUser($params);
	 break;
	 case 'edit':
		$empCls->updateUser($params);
	 break;
	 case 'editpass':
		$empCls->updatePassUser($params);
	 break;
	 case 'delete':
		$empCls->deleteUser($params);
	 break;
	 default:
	 $empCls->getUsers($params);
	 return;
	}
	
	class User {
	protected $conn;
	protected $data = array();
	function __construct($connString) {
		$this->conn = $connString;
	}
	
	public function getUsers($params) {
		
		$this->data = $this->getRecords($params);
		
		echo json_encode($this->data);
	}
	function insertUser($params) {
		$data = array();
		$code = $params["code"];
		$status = 0;

		if(isset($params["status"]) && $params["status"] == "on"){
			$status = 1;
		}
		$sql = "INSERT INTO `user` (username,password,phone, status,name,code) VALUES('" . $params["username"]. "', '" . $params["password"] . "', '" . $params["phone"] . "'," . $status . ",'" . $params["name"]. "','" . $code . "');  ";
		
		echo $result = mysqli_query($this->conn, $sql) or die("error to insert host data");
		
	}
	
	
	function getRecords($params) {
		$rp = isset($params['rowCount']) ? $params['rowCount'] : 10;
		
		if (isset($params['current'])) { $purl  = $params['current']; } else { $purl=1; };  
        $start_from = ($purl-1) * $rp;
		
		$sql = $sqlRec = $sqlTot = $where = '';
		
		if( !empty($params['searchPhrase']) ) {
			$where .=" WHERE ";
			$where .=" ( name LIKE '".$params['searchPhrase']."%' ";
			$where .=" OR phone LIKE '".$params['searchPhrase']."%' ";
			$where .=" OR username LIKE '".$params['searchPhrase']."%' )";
	   }
	   if( !empty($params['sort']) ) {  
			$where .=" ORDER By ".key($params['sort']) .' '.current($params['sort'])." ";
		}
	   // getting total number records without any search
		$sql = "SELECT * FROM `user` ";
		$sqlTot .= $sql;
		$sqlRec .= $sql;
		
		//concatenate search sql if value exist
		if(isset($where) && $where != '') {

			$sqlTot .= $where;
			$sqlRec .= $where;
		}
		if ($rp!=-1)
		$sqlRec .= " LIMIT ". $start_from .",".$rp;
		
		
		$qtot = mysqli_query($this->conn, $sqlTot) or die("error to fetch tot hosts data");
		$queryRecords = mysqli_query($this->conn, $sqlRec) or die("error to fetch hosts data");
		
		while( $row = mysqli_fetch_assoc($queryRecords) ) { 
			$data[] = $row;
		}

		$json_data = array(
			"current"            => intval($params['current']), 
			"rowCount"            => 10, 			
			"total"    => intval($qtot->num_rows),
			"rows"            => $data   // total data array
			);
		
		return $json_data;
	}
	function updateUser($params) {
		$data = array();
		$status = 0;

		if(isset($params["edit_status"]) && $params["edit_status"] == "on"){
			$status = 1;
		}

		//print_R($_POST);die;
		$sql = "Update `user` set name = '" . $params["edit_name"] . "', phone='" . $params["edit_phone"]."', status=" . $status . " WHERE id='".$_POST["edit_id"]."'";
		
		echo $result = mysqli_query($this->conn, $sql) or die("error to update host data");
	}
	function updatePassUser($params) {
		$data = array();
		
		//print_R($_POST);die;
		$sql = "Update `user` set password = '" . $params["editpass_password"] . "' WHERE id='".$_POST["editpass_id"]."'";
		
		echo $result = mysqli_query($this->conn, $sql) or die("error to update host data");
	}
	
	function deleteUser($params) {
		$data = array();
		$conn = $this->conn;
		//print_R($_POST);die;
		$sql = "delete from `user` WHERE id='".$params["id"]."'";

		if ($conn->query($sql) === TRUE) {
			echo "Record deleted successfully";
			
			// Delete data related
			$sql_user_host = "delete from `user_host` WHERE userId=".$params["id"];

			if ($conn->query($sql_user_host) === TRUE) {
				echo "Record deleted successfully";
			} else {
				echo "Error deleting record: " . $conn->error;
			}
		} else {
			echo "Error deleting record: " . $conn->error;
		}
		
		//echo $result = mysqli_query($this->conn, $sql) or die("error to delete host data");
	}
}
?>
	