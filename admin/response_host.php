
<?php
	//include connection file 
	include_once("../connection.php");
	
	$db = new dbObj();
	$connString =  $db->getConnstring();

	$params = $_REQUEST;
	
	$action = isset($params['action']) != '' ? $params['action'] : '';
	$empCls = new Host($connString);

	switch($action) {
	 case 'add':
		$empCls->insertHost($params);
	 break;
	 case 'edit':
		$empCls->updateHost($params);
	 break;
	 case 'delete':
		$empCls->deleteHost($params);
	 break;
	 default:
	 $empCls->getHosts($params);
	 return;
	}
	
	class Host {
	protected $conn;
	protected $data = array();
	function __construct($connString) {
		$this->conn = $connString;
	}
	
	public function getHosts($params) {
		
		$this->data = $this->getRecords($params);
		
		echo json_encode($this->data);
	}
	function insertHost($params) {
		$conn = $this->conn;
		$data = array();
		$status = 0;
		$allow_send_sms = 0;
		$allow_sound = 1;

		if(isset($params["status"]) && $params["status"] == "on"){
			$status = 1;
		}

		if(isset($params["allow_send_sms"]) && $params["allow_send_sms"] == "on"){
			$allow_send_sms = 1;
		}

		$sql = "INSERT INTO `host` (name, phone, url, status, allow_send_sms) VALUES('" . $params["name"] . "', '" . $params["phone"] . "','" . $params["url"] . "'," . $status .", ". $allow_send_sms .");  ";
		
		echo $result = mysqli_query($this->conn, $sql) or die("error to insert host data");
		// insert device
		$hostid = mysqli_insert_id($this->conn);

		// Get device
		$sql = "SELECT *  FROM device";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
			// build query
			$values = "";
			while($row = $result->fetch_assoc()) {
				if($values != ""){
					$values .= ",";
				}

				// Insert device - host
				$values .= "(". $hostid .",". $row["id"] .",0,". $row["amplitude"] .",'". $row["value"] ."')";
			}

			$sql = "INSERT INTO `device_host` (hostId, deviceId, state,amplitude,value) VALUES " . $values . ";  ";
			echo $result = mysqli_query($this->conn, $sql) or die("error to insert host data");
		}

		// Admin user: Auto insert user-host full quyền
		$sql = "SELECT *  FROM user WHERE isAdmin=1";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
			// build query
			$values = "";
			$view = 1;
			$control = 1;
			$sendsms = 1;
			$allow_sound = 1;

			while($row = $result->fetch_assoc()) {
				if($values != ""){
					$values .= ",";
				}

				// Insert device - host
				$values .= "(". $row["Id"] .",". $hostid .",". $view ."," . $control. ",". $sendsms .",". $allow_sound .")";
			}

			$sql = "INSERT INTO `user_host` (userId, hostId, view, control, sendsms, allow_sound) VALUES " . $values . ";  ";
			echo $result = mysqli_query($this->conn, $sql) or die("error to insert host data");
		}
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

			$where .=" OR url LIKE '".$params['searchPhrase']."%' )";
	   }
	   if( !empty($params['sort']) ) {  
			$where .=" ORDER By ".key($params['sort']) .' '.current($params['sort'])." ";
		}
	   // getting total number records without any search
		$sql = "SELECT * FROM `host` ";
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
	function updateHost($params) {
		$data = array();
		//print_R($_POST);die;
		
		$status = 0;
		$allow_send_sms =0;

		if(isset($params["edit_status"]) && $params["edit_status"] == "on"){
			$status = 1;
		}

		if(isset($params["edit_allow_send_sms"]) && $params["edit_allow_send_sms"] == "on"){
			$allow_send_sms = 1;
		}

		$sql = "Update `host` set name = '" . $params["edit_name"] . "', phone='" . $params["edit_phone"]."', url='" . $params["edit_url"] . "', status = $status, allow_send_sms=$allow_send_sms WHERE id='". $_POST["edit_id"] ."'";
		echo $result = mysqli_query($this->conn, $sql) or die($sql);
	}
	
	function deleteHost($params) {
		$data = array();
		$conn = $this->conn;
		//print_R($_POST);die;
		$sql = "delete from `host` WHERE id='".$params["id"]."'";
		
		if ($conn->query($sql) === TRUE) {
			echo "Record deleted successfully";
			
			// Delete data related
			$sql_user_host = "delete from `user_host` WHERE hostId=".$params["id"];
			$sql_device_host = "delete from `device_host` WHERE hostId=".$params["id"];

			if ($conn->query($sql_user_host) === TRUE) {
				echo "Record deleted successfully";
				if ($conn->query($sql_device_host) === TRUE) {
					echo "Record deleted successfully";
				} else {
					echo "Error deleting record: " . $conn->error;
				}
			} else {
				echo "Error deleting record: " . $conn->error;
			}
			

		} else {
			echo "Error deleting record: " . $conn->error;
		}

		// echo $result = mysqli_query($this->conn, $sql) or die("error to delete host data");
	}
}
?>
	