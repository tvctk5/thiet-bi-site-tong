
<?php 

header('Content-Type: text/html; charset=utf-8');

session_start();

//tiến hành kiểm tra là người dùng đã đăng nhập hay chưa
//nếu chưa, chuyển hướng người dùng ra lại trang đăng nhập
if (!isset($_SESSION['username'])) {
	 header('Location: login.php');
}

//include connection file 
include_once("connection.php");
$db = new dbObj();
    $connString =  $db->getConnstring();
    // where uh.userId in (select Id from user where username = '" . $_SESSION['username'] . "') 
    $sqlhost = "SELECT h.*, u.code FROM host h join user_host uh on uh.hostId = h.id join user u on u.Id=uh.userId where uh.userId in (select Id from user where username = '" . $_SESSION['username'] . "') order by h.name";
    $qhost = mysqli_query($connString, $sqlhost) or die("error to fetch tot hosts data");
    //$dataHost[] = null;

    while( $row = mysqli_fetch_assoc($qhost) ) { 
        $dataHost[] = $row;
    }

?>

<!DOCTYPE html>
<html lang="en"> 
  <head>
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

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

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
        echo " <a href='admin/user.php' target='_blank' class='link'>Quản lý tài khoản</a>  || ";
        echo "<a href='admin/host.php' target='_blank' class='link'>Quản lý trạm</a> || ";
        echo "<a href='export.php' target='_blank' class='link'>Nhật ký</a>";
      }
      ?>
      </div>
      </div>

    </nav>
    <!-- Conainer -->
    <div class="container">
	 <div class="row">
     
     <div class="row">
     <b>>> Danh sách các trạm</b>
     </div>
        <div class="land-1"> 
        <?php

        foreach ($dataHost as $key => $value) {
            //if($key == 0){
            //    echo "<option value='" . $value["id"] . "' selected>" . $value["name"] . "</option>";
            //} else{
                echo "<a href='" . $value["url"] . "?code=" . $value["code"] . "&hostid=" . $value["id"] . "' target='_blank' class=''><div class='col-lg-3 col-md-4 col-sm-6 col-xs-6 user-tram'>";
                echo "<div>" . $value["name"] . "</div>";
                echo "</div></a>";
            //}
        }
        ?>
          <div class="clearfix"></div>  
        </div>
      </div>
    </div>
  </body>
</html>

<?php 
	CloseDatabase($conn);
?>
