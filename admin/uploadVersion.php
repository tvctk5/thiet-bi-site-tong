<?php
	//include connection file 
	include_once("../connection.php");
	
	$db = new dbObj();
    $connString =  $db->getConnstring();
    $conn = $connString;
    
    function CheckFileType($imageFileType)
    {
        // Allow certain file formats
        if($imageFileType != "zip" ) {
            return false;
        }

        return true;
    }

    $target_dir = "files/";
    
    $GLOBALS['log'] = '';
    $GLOBALS['fileName'] = '';

    //$GLOBALS['log'] .= "FILES: " . json_encode($_FILES);
    //$GLOBALS['log'] .= "; POST: " . json_encode($_POST);
    function Upload($target_dir) {
        // $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        
        $GLOBALS['fileName'] = date("Y-m-d-H-i-s_") . basename($_FILES["fileToUpload"]["name"]);
        $target_file = $target_dir. $GLOBALS['fileName'];
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // create a folder
        if (!file_exists($target_dir)) {
            mkdir($target_dir);
        }

        // Check if image file is a actual image or fake image
        // $check = CheckFileType($imageFileType);
        // if($check) {
        //     $log .= "File is valid - " . $imageFileType . ".";
        //     $uploadOk = 1;
        // } else {
        //     $log .= "File is not a Zip file.";
        //    return false;
        // }

        // Check if file already exists
        if (file_exists($target_file)) {
            $GLOBALS['log'] .= "; Sorry, file already exists.";
            return false;
        }
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 50000000) {
            $GLOBALS['log'] .= "; Sorry, your file is too large.";
            return false;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $GLOBALS['log'] .= "; Sorry, your file was not uploaded.";
            return false;
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $GLOBALS['log'] .= "; The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                return true;
            } else {
                $err = error_get_last();
                $GLOBALS['log'] .= "; Sorry, there was an error uploading your file. Error: " . $err;
                return false;
            }
        }

    }

    if(Upload($target_dir)){
        $params = $_POST;
        // echo '{"status": true, "logs": "' . $GLOBALS['log'] . '"}';
        // Tạo dữ liệu trong DB
        $action = isset($params['action']) != '' ? $params['action'] : '';
        $version = isset($params['Version']) != '' ? $params['Version'] : '';
        $active = 0;
        if($action == "createUpgradeVersion"){
            if(isset($params["active"]) && $params["active"] == "on"){
                $active = 1;

                $sql = "UPDATE `upgrade_version` set active=0 WHERE active=1;";
            
                $result = mysqli_query($conn, $sql) or die("error to UPDATE version data");

                $GLOBALS['log'] .= "; Update all active=0";
            }
            $sql = "INSERT INTO `upgrade_version` (version,uri_file,active) VALUES('" . $version . "', '" . $GLOBALS["fileName"] . "', $active);  ";
            
            $result = mysqli_query($conn, $sql) or die("error to insert version data");

            $GLOBALS['log'] .= "; Insert new version data";

        }

        $post_data = json_encode(array('status' => true, 'logs' => $GLOBALS['log'], 'files' => $_FILES, 'post' => $_POST));
        echo $post_data;
    } else {
        // echo '{"status": false, "logs": "' . $GLOBALS['log'] . '"}';
        $post_data = json_encode(array('status' => false, 'logs' => $GLOBALS['log'], 'files' => $_FILES, 'post' => $_POST));
        echo $post_data;
    };

?>
