
<?php
	//include connection file 
	include_once("../connection.php");
	
	$db = new dbObj();
	$connString =  $db->getConnstring();

	$params = $_REQUEST;
	
	$action = isset($params['action']) != '' ? $params['action'] : '';
	$empCls = new HostDetail($connString);

	switch($action) {
	 case 'add':
		$empCls->insertHostDetail($params);
	 break;
	 case 'edit':
		$empCls->updateHostDetail($params);
	 break;
	 case 'delete':
		$empCls->deleteHostDetail($params);
	 break;
	 default:
	 $empCls->getHostDetails($params);
	 return;
	}
	
	class HostDetail {
	protected $conn;
	protected $data = array();
	function __construct($connString) {
		$this->conn = $connString;
	}
	
	public function getHostDetails($params) {
		
		$this->data = $this->getRecords($params);
		
		echo json_encode($this->data);
	}
	function insertHostDetail($params) {
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
		$sql = "INSERT INTO `user_host` (userId,hostId,view, control, sendsms) VALUES(" . $params["userId"]. ", " . $params["hostId"] . ", " . $view . "," . $control . ", ". $sms .");  ";
		
		echo $result = mysqli_query($this->conn, $sql) or die("error to insert host data");
	}
	
	
	function getRecords($params) {
		$rp = isset($params['rowCount']) ? $params['rowCount'] : 10;
		
		if (isset($params['current'])) { $purl  = $params['current']; } else { $purl=1; };  
        $start_from = ($purl-1) * $rp;
		
		$sql = $sqlRec = $sqlTot = $where = '';
		$where .=" WHERE 1=1 ";

		if( !empty($params['searchPhrase']) ) {   
			$where .=" AND ";
			$where .=" ( u.name LIKE '".$params['searchPhrase']."%' ";
			$where .=" OR u.username LIKE '".$params['searchPhrase']."%' )";
	   }
	   if( !empty($params['sort']) ) {  
			$where .=" ORDER By ".key($params['sort']) .' '.current($params['sort'])." ";
		}
	   // getting total number records without any search
		$sql = "SELECT u.name,u.username,uh.view,uh.control,uh.userId,uh.hostId, uh.sendsms, u.isAdmin FROM user u join user_host uh on u.Id = uh.userId and uh.hostId=". $params["hostId"];
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
	function updateHostDetail($params) {
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
		$sql = "Update `user_host` set view = " . $view . ", control=" . $control ." , sendsms = " . $sms . " WHERE userId=" . $_POST["edit_userid"] . " AND hostId=".$_POST["edit_hostid"];
		
		echo $result = mysqli_query($this->conn, $sql) or die("error to update host data");
	}
	
	function deleteHostDetail($params) {
		$data = array();
		//print_R($_POST);die;
		$sql = "delete from `user_host` WHERE userId=" . $_POST["userid"] . " AND hostId=".$_POST["hostid"];
		
		echo $result = mysqli_query($this->conn, $sql) or die("error to delete host data");
	}
}
?>
	