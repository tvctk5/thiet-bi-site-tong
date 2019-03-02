
<?php
	//include connection file 
	include '../sql/sql-function.php';

	$connString = ConnectDatabse();

	$params = $_REQUEST;
	
	$action = isset($params['action']) != '' ? $params['action'] : '';
	$empCls = new UserPermission($connString);

	switch($action) {
	 case 'add':
		$empCls->insertUserPermission($params);
	 break;
	 case 'edit':
		$empCls->updateUserPermission($params);
	 break;
	 case 'delete':
		$empCls->deleteUserPermission($params);
	 break;
	 default:
	 $empCls->getUserPermissions($params);
	 return;
	}
	
	// Close connection
	CloseDatabase($connString);

	class UserPermission {
	protected $conn;
	protected $data = array();
	function __construct($connString) {
		$this->conn = $connString;
	}
	
	public function getUserPermissions($params) {
		
		$this->data = $this->getRecords($params);
		
		echo json_encode($this->data);
	}
	function insertUserPermission($params) {
		$data = array();
		$view = 0;
		$control = 0;
		$sms = 0;
		
		if(isset($params["view"]) && $params["view"] == "on"){
			$view = 1;
		}

		if(isset($params["control"]) && $params["control"] == "on"){
			$control = 1;
		}
		
		if(isset($params["sendsms"]) && $params["sendsms"] == "on"){
			$sms = 1;
		}		

		//print_R($_POST);die;
		$sql = "INSERT INTO `user_host` (userId,hostId,view, control,sendsms) VALUES(" . $params["userId"]. ", " . $params["hostId"] . ", " . $view . "," . $control . ", " . $sms . ");  ";
		
		echo $result = mysqli_query($this->conn, $sql) or die("error to insert host data");
	}
	
	
	function getRecords($params) {
		$rp = isset($params['rowCount']) ? $params['rowCount'] : 10;
		
		if (isset($params['current'])) { $purl  = $params['current']; } else { $purl=1; };  
        $start_from = ($purl-1) * $rp;
		
		$sql = $sqlRec = $sqlTot = $where = '';
		$where .=" WHERE uh.userId=" . $params["userId"];

		if( !empty($params['searchPhrase']) ) {   
			$where .=" AND ";
			$where .=" ( h.name LIKE '".$params['searchPhrase']."%' ";
			$where .=" OR url LIKE '".$params['searchPhrase']."%' )";
	   }
	   if( !empty($params['sort']) ) {  
			$where .=" ORDER By ".key($params['sort']) .' '.current($params['sort'])." ";
		}
	   // getting total number records without any search
		$sql = "SELECT uh.*, h.name, h.url, h.id, uh.sendsms FROM `user_host` uh join host h on h.id = uh.hostId ";
		$sqlTot .= $sql;
		$sqlRec .= $sql;
		
		//concatenate search sql if value exist
		if(isset($where) && $where != '') {

			$sqlTot .= $where;
			$sqlRec .= $where;
		}
		if ($rp!=-1)
		$sqlRec .= " LIMIT ". $start_from .",".$rp;
		
		// die($sqlTot);
		$qtot = mysqli_query($this->conn, $sqlTot) or die("error to fetch tot hosts data");
		$queryRecords = mysqli_query($this->conn, $sqlRec) or die("error to fetch hosts data");
		$data = [];
		
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
	function updateUserPermission($params) {
		$data = array();
		$view = 0;
		$control = 0;
		$sms = 0;

		if(isset($params["edit_view"]) && $params["edit_view"] == "on"){
			$view = 1;
		}

		if(isset($params["edit_control"]) && $params["edit_control"] == "on"){
			$control = 1;
		}
		
		if(isset($params["edit_sendsms"]) && $params["edit_sendsms"] == "on"){
			$sms = 1;
		}

		//print_R($_POST);die;
		$sql = "Update `user_host` set view = " . $view . ", control=" . $control .", sendsms= " . $sms . " WHERE userId=" . $_POST["edit_userid"] . " AND hostId=".$_POST["edit_hostid"];
		
		echo $result = mysqli_query($this->conn, $sql) or die("error to update host data");
	}

	function updatePassUserPermission($params) {
		$data = array();
		
		//print_R($_POST);die;
		$sql = "Update `user` set password = '" . $params["editpass_password"] . "' WHERE id='".$_POST["editpass_id"]."'";
		
		echo $result = mysqli_query($this->conn, $sql) or die("error to update host data");
	}
	
	function deleteUserPermission($params) {
		$data = array();
		//print_R($_POST);die;
		$sql = "delete from `user_host` WHERE userId=" . $_POST["userid"] . " AND hostId=".$_POST["hostid"];
		
		echo $result = mysqli_query($this->conn, $sql) or die("error to delete host data");
	}
}
?>
	