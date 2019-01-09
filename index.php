
<?php 

header('Content-Type: text/html; charset=utf-8');

session_start();

//tiến hành kiểm tra là người dùng đã đăng nhập hay chưa
//nếu chưa, chuyển hướng người dùng ra lại trang đăng nhập
if (!isset($_SESSION['username']) || !isset($_SESSION['userid'])) {
	 header('Location: login.php');
}

//include connection file 
include_once("connection.php");
include_once("sql/sql-function.php");
$db = new dbObj();
    $connString =  $db->getConnstring();
    // where uh.userId in (select Id from user where username = '" . $_SESSION['username'] . "') 
    $sqlhost = "SELECT h.*, u.code, uh.allow_sound, uh.userId FROM host h join user_host uh on uh.hostId = h.id join user u on u.Id=uh.userId where uh.userId=" . $_SESSION['userid'] . " and h.status=1 order by h.name";
    $qhost = mysqli_query($connString, $sqlhost) or die("error to fetch tot hosts data");
    $dataHost = [];
    // echo count($dataHost);
    while( $row = mysqli_fetch_assoc($qhost) ) { 
        $dataHost[] = $row;
    }
    // echo count($dataHost);
    if($_SESSION['isAdmin'] == 0 && (is_null($dataHost) || count($dataHost)<=0)){
      //  || empty($dataHost) 
      echo "<h3>Tài khoản chưa được phân quyền trên trạm nào! Liên hệ quản trị viên</h3> <a href='logout.php'>Đăng xuất</a> || <a href='login.php'>Đăng nhập tài khoản khác</a>";
      return;
    }

    // Lấy các thuộc tính của trạm

    $sqlhostDetail = "SELECT dh.hostId, dh.deviceId, dh.state, dh.value as isSound, d.on_text, d.off_text FROM device_host dh join device d on dh.deviceId = d.id where dh.hostId in (SELECT h.id FROM host h join user_host uh on uh.hostId = h.id join user u on u.Id=uh.userId where uh.userId =" . $_SESSION['userid'] . " and h.status=1) order by dh.hostId";
    $qhostDetail = mysqli_query($connString, $sqlhostDetail) or die("error to fetch tot hosts data");
    //$dataHost[] = null;

    while( $row = mysqli_fetch_assoc($qhostDetail) ) { 
        $dataHostDetail[] = $row;
    }

    function GetHostDetail($dataHostDetail, $hostId, $deviceId) {
      foreach ($dataHostDetail as $val){ 
          if($val["hostId"] == $hostId && $val["deviceId"] == $deviceId){
            //echo $val;
            return $val;
          }
      }
    }

    function GetHostDetailToText($dataHostDetail, $hostId, $deviceId) {
      $val = GetHostDetail($dataHostDetail, $hostId, $deviceId);
      // echo "<script>alert('". $val["state"] ."');</script>";
      if($val["state"] == 1){
        echo "<td class='device-warning'>" . $val["on_text"] . "</td>";
      } else {
        echo "<td>" . $val["off_text"] . "</td>";
      }
    }
    function GetHostDetailToText_ConnectionState($row) {
      if($row["connection_status"] == 0){
        echo "<td class='connection_status_lost device-warning'>Mất kết nối</td>";
      } else {
        echo "<td class='connection_status_connected'>Đã kết nối</td>";
      }
    }

    function GetHostDetailToText_Sound($dataHostDetail, $hostId, $userId, $row) {
      $mute = 0;
      $classSound = "app-sound-off";
      if($row["allow_sound"] == 0){
        $mute = 1;
      }
      if(GetHostDetail($dataHostDetail, $hostId, 1)["state"] == 1 || 
        GetHostDetail($dataHostDetail, $hostId, 2)["state"] == 1 ||  
        GetHostDetail($dataHostDetail, $hostId, 3)["state"] == 1 ||  
        GetHostDetail($dataHostDetail, $hostId, 4)["state"] == 1 ||  
        GetHostDetail($dataHostDetail, $hostId, 5)["state"] == 1 ||  
        GetHostDetail($dataHostDetail, $hostId, 6)["state"] == 1 ||  
        GetHostDetail($dataHostDetail, $hostId, 7)["state"] == 1 ||  
        GetHostDetail($dataHostDetail, $hostId, 8)["state"] == 1 || 
        $row["connection_status"] == 0){
        $classSound = "app-sound-on";
        echo "<td class='text-center app-sound sound_on " . $classSound . "' hostid='". $hostId ."' userid='". $userId ."' mute='" . $mute . "'></td>";
      } 
      else {
      //  echo "<td class='app-sound sound_off " . $classSound . "' hostid='". $hostId ."' userid='". $userId ."' mute='" . $mute . "'>Tắt</td>";
       echo "<td></td>";
      }
    }
?>

<!DOCTYPE html>
<html lang="en"> 
  <head>
    <meta refreshpage="true" content="5">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Điều khiển tổng</title>
    
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="css/google-font-css.css?family=Open+Sans">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome/css/font-awesome.min.css">
    <!-- Bootst192rap -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" type="text/css" href="css/common.css">
    
    <!-- JS -->
    <script type="text/javascript" src="js/jquery/jquery.js"></script>
    <script type="text/javascript" src="js/jquery/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/ion.sound-3.0.7/ion.sound.min.js"></script>
    <script type="text/javascript" src="js/reloadPage.js"></script>
    <script type="text/javascript" src="js/sound.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
    table {
      font-family: arial, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    td, th {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 8px;
    }

    tr:nth-child(even) {
      background-color: #dddddd;
    }
    </style>
  </head>
  <body class="lazy-man">
    <!-- Fixed navbar -->
    <div class="container"></div>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class='user-info'>
          <?php
          echo 'Xin chào <b style="color:yellow;">' . $_SESSION['username'] . '</b>'
          ?>
          <div><a href='logout.php' style='color: white !important;'>Logout</a> -  <a href='changepassword.php'  style='color: white !important;'>Change password</a></div>
        </div>
        <div class="navbar-header">
        
        <center>
        <b style='color: cyan !important;'> Quản lý tổng</b>  
	      </div>
      <div class="div-link">
      <?php
      if($_SESSION['user']["isAdmin"] == 1){
        echo " <a href='admin/user.php' target='_self' class='link'>Quản lý tài khoản</a>  || ";
        echo "<a href='admin/host.php' target='_self' class='link'>Quản lý trạm</a> || ";
      }
      
      echo "<a href='export.php' target='_self' class='link'>Nhật ký</a>";
      ?>
      </div>
      </div>

    </nav>
    <!-- Conainer -->
    <div class="container">
	 <div class="row">
     
     <div class="row">
     <!-- <b>>> Danh sách các trạm</b> -->
     </div>
        <div class="land-1"> 
        
<table id="tbl-host">
  <tr>
    <th>STT</th>
    <th>Tên trạm</th>
    <th>Điện lưới</th>
    <th>Điện máy nổ</th>
    <th>Điện tổng đài</th>
    <th>Nhiệt độ cao</th>
    <th>Nhiên liệu</th>
    <th>CB cháy</th>
    <th>CB cửa</th>
    <th>CB cáp</th>
    <th>Đường truyền</th>
    <th>Âm thanh</th>
    <th>Chi tiết</th>
  </tr>
 
        <?php
        $stt = 1;
        foreach ($dataHost as $key => $value) {
          
          echo "<tr>";
          echo "<td>" . $stt . "</td>";
          echo "<td><a href='" . $value["url"] . "?code=" . $value["code"] . "&hostid=" . $value["id"] . "' target='_blank' class=''>" . $value["name"] . "</a></td>";
          GetHostDetailToText($dataHostDetail, $value["id"], 1);
          GetHostDetailToText($dataHostDetail, $value["id"], 2);
          GetHostDetailToText($dataHostDetail, $value["id"], 3);
          GetHostDetailToText($dataHostDetail, $value["id"], 4);
          GetHostDetailToText($dataHostDetail, $value["id"], 5);
          GetHostDetailToText($dataHostDetail, $value["id"], 6);
          GetHostDetailToText($dataHostDetail, $value["id"], 7);
          GetHostDetailToText($dataHostDetail, $value["id"], 8);
          GetHostDetailToText_ConnectionState($value);
          GetHostDetailToText_Sound($dataHostDetail, $value["id"], $value["userId"], $value);
          echo "<td><a href='" . $value["url"] . "?code=" . $value["code"] . "&hostid=" . $value["id"] . "' target='_blank' class=''>Chi tiết</a></td>";

            //if($key == 0){
            //    echo "<option value='" . $value["id"] . "' selected>" . $value["name"] . "</option>";
            //} else{
                // echo "<a href='" . $value["url"] . "?code=" . $value["code"] . "&hostid=" . $value["id"] . "' target='_blank' class=''><div class='col-lg-3 col-md-4 col-sm-6 col-xs-6 user-tram'>";
                // echo "<div>" . $value["name"] . "</div>";
                // echo "</div></a>";
            //}
            echo "</tr>";
            $stt = $stt + 1;
        }
        ?>
        
</table>
          <div class="clearfix"></div>  
        </div>
      </div>
    </div>
  </body>
</html>

<?php 
	CloseDatabase($connString);
?>
