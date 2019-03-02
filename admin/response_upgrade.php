
<?php
	//include connection file 
	include '../sql/sql-function.php';

	$connString = ConnectDatabse();

	$params = $_REQUEST;
	
	$action = isset($params['action']) != '' ? $params['action'] : '';
	$empCls = new User($connString);

	switch($action) {
	 case 'add':
		$empCls->insertUser($params);
	 break;
	 case 'active':
		$empCls->activeVersion($params);
	 break;
	 case 'inactive':
		$empCls->inactiveVersion($params);
	 break;
	 case 'editpass':
		$empCls->updatePassUser($params);
	 break;
	 case 'delete':
		$empCls->deleteUser($params);
	 break;
	 case 'createUpgradeVersion':
		$empCls->createUpgradeVersion($params);
	 break;
	 default:
	 $empCls->getVersion($params);
	 return;
	}

	// Close connection
	CloseDatabase($connString);
	
	function CheckFileType($imageFileType)
	{
		// Allow certain file formats
		if($imageFileType != "zip" ) {
			echo "Sorry, only Zip files is allowed.";
			return false;
		}

		return true;
	}

	function uploadFile($target_dir, $params)
	{
		// $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$target_file = $target_dir. date("Y-m-d-H-i-s_") . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		// create a folder
		if (!file_exists($target_dir)) {
			mkdir($target_dir);
		}

		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
			$check = CheckFileType($imageFileType);
			if($check) {
				echo "File is valid - " . $imageFileType . ".";
				$uploadOk = 1;
			} else {
				echo "File is not a Zip file.";
				$uploadOk = 0;
			}
		}
		// Check if file already exists
		if (file_exists($target_file)) {
			echo "Sorry, file already exists.";
			$uploadOk = 0;
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 50000000) {
			echo "Sorry, your file is too large.";
			$uploadOk = 0;
		}



		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
			} else {
				$err = error_get_last();
				echo "Sorry, there was an error uploading your file. Error: " . $err;
			}
		}
	}

	
	class User {
	protected $conn;
	protected $data = array();
	function __construct($connString) {
		$this->conn = $connString;
	}
	
	public function getVersion($params) {
		
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
			$where .=" ( version LIKE '".$params['searchPhrase']."%' )";
	   }
	   if( !empty($params['sort']) ) {  
			$where .=" ORDER By ".key($params['sort']) .' '.current($params['sort'])." ";
		}
		else {
			$where .=" ORDER By id desc";
		}
	   // getting total number records without any search
		$sql = "SELECT *, (select count(h.id) from host h where h.versionId=uv.id) as count_host FROM `upgrade_version` uv ";
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

	function activeVersion($params) {
		$data = array();
		$id = $params["id"];

		//print_R($_POST);die;
		$sql = "Update `upgrade_version` set active=1 WHERE id=$id";
		$result = mysqli_query($this->conn, $sql) or die("error to update version data: set to 1");
		
		$sql = "Update `upgrade_version` set active=0 WHERE active=1 and id<>$id";
		echo $result = mysqli_query($this->conn, $sql) or die("error to update version data: set to 0 all");
	}

	function inactiveVersion($params) {
		$data = array();
		$id = $params["id"];

		//print_R($_POST);die;
		$sql = "Update `upgrade_version` set active=0 WHERE id=$id";
		
		echo $result = mysqli_query($this->conn, $sql) or die("error to update version data");
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
		$sql = "delete from `upgrade_version` WHERE id='".$params["id"]."'";

		if ($conn->query($sql) === TRUE) {
			echo "Record deleted successfully";
		} else {
			echo "Error deleting record: " . $conn->error;
		}
		
		//echo $result = mysqli_query($this->conn, $sql) or die("error to delete host data");
	}

	
	function createUpgradeVersion($params){
		
		$target_dir = "files/";
		uploadFile($target_dir, $params);
	}
	
}
?>
	