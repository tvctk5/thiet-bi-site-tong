
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
	 case 'get-list-device-by-hostid':
		$empCls->getDeviceStatus($params);
	 break;
	 case 'setting-quota-by-hostid':
		$empCls->quotaInfo($params);
	 break;
	 case 'edit_device':
		$empCls->updateDeviceHost($params);
	 break;
	 case 'setting_quota':
		$empCls->updateDeviceQuota($params);
	 break;
	 case 'sync_update_quota':
		$empCls->sync_update_quota();
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
	public function getDeviceStatus($params) {
		
		$this->data = $this->getDeviceByHostId($params);
		
		echo json_encode($this->data);
	}
	public function quotaInfo($params) {
		
		$this->data = $this->getQuotaInfoByHostId($params);
		
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
		$result_device = $conn->query($sql) or die($conn->error);
		$num_rows_device = $result_device->num_rows;
		$data_device = [];
		while( $row = mysqli_fetch_assoc($result_device) ) { 
			$data_device[] = $row;
		}

		// ---------------------------------------------
		// Get calendar to set quota
		$sql_calendar = "SELECT *  FROM calendar";
		$result_calendar = $conn->query($sql_calendar) or die($conn->error);
		$num_rows_calendar = $result_calendar->num_rows;
		$data_calendar = [];
		while( $row = mysqli_fetch_assoc($result_calendar) ) { 
			$data_calendar[] = $row;
		}
		// ---------------------------------------------

		if ($num_rows_device > 0) {
			// build query
			$values = "";
			//while($row = $result->fetch_assoc()) {
			foreach ($data_device as $row){
				// Insert device - host
				$values = "(". $hostid .",". $row["id"] .",0,". $row["amplitude"] .",'". $row["value"] ."', 1)";

				$sql = "INSERT INTO `device_host` (hostId, deviceId, state,amplitude,value, status) VALUES " . $values . ";  ";
				echo $result_device_host = mysqli_query($this->conn, $sql) or die("error to insert device_host data:". $conn->error);
				// $device_host_id = mysqli_insert_id($this->conn);

				// Device for input type
				if($row["typeId"] == 0){
					// Insert quota for each device on the host
					if ($num_rows_calendar > 0) {
						// build query
						$values = "";
						// while($row_calendar = $result_calendar->fetch_assoc()) {
						foreach ($data_calendar as $row_calendar){
							if($values != ""){
								$values .= ",";
							}
			
							// Insert device - host
							$values .= "(". $row["id"] .",". $hostid .",". $row_calendar["id"] .",". $row["quota"] .",'". $row["operator"] ."')";
						}
			
						$sql = "INSERT INTO `device_host_quota` (deviceId, hostId, calendarId, quota, operator) VALUES " . $values . ";  ";
						echo $result_device_host_quota = mysqli_query($this->conn, $sql) or die("error to insert device_host_quota data: query: (". $sql . "); error: ". $conn->error);
					}
					// End: Insert quota for each device on the host
				}
			}

			/*
			// build query
			$values = "";
			while($row = $result->fetch_assoc()) {
				if($values != ""){
					$values .= ",";
				}

				// Insert device - host
				$values .= "(". $hostid .",". $row["id"] .",0,". $row["amplitude"] .",'". $row["value"] ."', 1)";
			}

			$sql = "INSERT INTO `device_host` (hostId, deviceId, state,amplitude,value, status) VALUES " . $values . ";  ";
			echo $result = mysqli_query($this->conn, $sql) or die("error to insert host data");
			 */
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
			$sql_device_quota = "delete from `device_host_quota` WHERE hostId=".$params["id"];

			if ($conn->query($sql_user_host) === TRUE) {
				echo "Record deleted successfully";
				if ($conn->query($sql_device_host) === TRUE) {
					echo "Record deleted successfully";
					if ($conn->query($sql_device_quota) === TRUE) {
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
			

		} else {
			echo "Error deleting record: " . $conn->error;
		}

		// echo $result = mysqli_query($this->conn, $sql) or die("error to delete host data");
	}

	function getDeviceByHostId($params) {		
	   // getting total number records without any search
		$sql = "SELECT dh.id as device_hostid, d.name, dh.status, d.type FROM `device_host` dh join device d on d.id = dh.deviceId and dh.hostId=" . $params["id"] . " order by d.id";
		
		$queryRecords = mysqli_query($this->conn, $sql) or die("error to fetch hosts data");
		$data = [];
		while( $row = mysqli_fetch_assoc($queryRecords) ) { 
			$data[] = $row;
		}

		return $data;
	}

	function getQuotaInfoByHostId($params) {		
		// getting total number records without any search
		 $sql = "SELECT dhq.id, dhq.deviceId, dhq.hostId, dhq.calendarId, dhq.quota, dhq.operator, d.name, d.unit, c.name as calendar_name FROM `device_host_quota` dhq 
		 join device d on d.id = dhq.deviceId and dhq.hostId=" . $params["id"] . " left join calendar c on c.id=dhq.calendarId order by d.id, dhq.id";
		 
		 $queryRecords = mysqli_query($this->conn, $sql) or die("error to fetch hosts data");
		 $data = [];
		 while( $row = mysqli_fetch_assoc($queryRecords) ) { 
			 $data[] = $row;
		 }
 
		 return $data;
	}

	function updateDeviceHost($params) {
		$data = array();
		//print_R($_POST);die;
		$query ='';
		$lstId = '';

		if(isset($params["lstId"])){
			$lstId = $params["lstId"];
		}

		if($lstId == ''){
			echo 'List ids to update not found';
			return;
		}

		$Ids = explode(",", $lstId);

		foreach ($Ids as $id){
			$status = 0;

			if(isset($params["chk_" . $id]) && $params["chk_" . $id] == "on"){
				$status = 1;
			}

			$sql = "Update `device_host` set status = $status WHERE id=". $id . ";";
			$result = mysqli_query($this->conn, $sql) or die("FAILED: " . $sql);
		}

		echo 'Update device host: Successfully';
	}

	function updateDeviceQuota($params) {
		$data = array();
		//print_R($_POST);die;
		$query ='';
		$lstId = '';

		if(isset($params["lstId"])){
			$lstId = $params["lstId"];
		}

		if($lstId == ''){
			echo 'List ids to update not found';
			return;
		}

		$Ids = explode(",", $lstId);

		foreach ($Ids as $id){
			$value = "1";
			if(isset($params["device_quota_" . $id])){
				$value = $params["device_quota_" . $id];
				$value = str_replace(",", ".", $value);
			}

			$sql = "Update `device_host_quota` set quota = $value WHERE id=". $id . ";";
			$result = mysqli_query($this->conn, $sql) or die("FAILED: " . $sql);
		}

		echo 'Update device host: Successfully';
	}

	function sync_update_quota() {
		$conn = $this->conn;
		$data = array();

		// Get host
		$sql = "SELECT *  FROM host";
		$result_host = $conn->query($sql) or die($conn->error);
		$num_rows_host = $result_host->num_rows;
		$data_host = [];
		while( $row = mysqli_fetch_assoc($result_host) ) { 
			$data_host[] = $row;
		}
		
		// Get device
		$sql = "SELECT *  FROM device where typeId=0";
		$result_device = $conn->query($sql) or die($conn->error);
		$num_rows_device = $result_device->num_rows;
		$data_device = [];
		while( $row = mysqli_fetch_assoc($result_device) ) { 
			$data_device[] = $row;
		}

		// ---------------------------------------------
		// Get calendar to set quota
		$sql_calendar = "SELECT *  FROM calendar";
		$result_calendar = $conn->query($sql_calendar) or die($conn->error);
		$num_rows_calendar = $result_calendar->num_rows;
		$data_calendar = [];
		while( $row = mysqli_fetch_assoc($result_calendar) ) { 
			$data_calendar[] = $row;
		}
		// ---------------------------------------------

		if ($num_rows_host > 0) {
			//while($row_host = $result_host->fetch_assoc()) {
			foreach ($data_host as $row_host){
				$hostid = $row_host["id"];

				if ($num_rows_device > 0) {
					// build query
					$values = "";
					// while($row = $result_device->fetch_assoc()) {
					foreach ($data_device as $row){
						// Insert quota for each device on the host
						if ($num_rows_calendar > 0) {
							// build query
							$values = "";
							// while($row_calendar = $result_calendar->fetch_assoc()) {
							foreach ($data_calendar as $row_calendar){
								if($values != ""){
									$values .= ",";
								}
				
								// Insert device - host
								$values .= "(". $row["id"] .",". $hostid .",". $row_calendar["id"] .",". $row["quota"] .",'". $row["operator"] ."')";
							}
				
							$sql = "INSERT INTO `device_host_quota` (deviceId, hostId, calendarId, quota, operator) VALUES " . $values . ";  ";
							echo $result_device_host_quota = mysqli_query($this->conn, $sql) or die("error to insert device_host_quota data: query: (". $sql . "); error: ". $conn->error);
						}
						// End: Insert quota for each device on the host
					}
				}
			}
		}	


	}
}
?>
	