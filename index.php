<!-- 	Nguyen Hai Duong, September 2016 
 			GNU LESSER GENERAL PUBLIC LICENSE Version 2.1, February 1999
-->

<?php 

header('Content-Type: text/html; charset=utf-8');

session_start();

include 'function/print-HTML.php';
include 'sql/sql-function.php';

//tiến hành kiểm tra là người dùng đã đăng nhập hay chưa
//nếu chưa, chuyển hướng người dùng ra lại trang đăng nhập
if (!isset($_SESSION['username'])) {
	 header('Location: login.php');
}

$conn = ConnectDatabse();

?>

<!DOCTYPE html>
<html lang="en"> 
  <head>
    <meta charset="utf-8">
    <meta refreshpage="true" content="5">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Tran Van Tu</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome/css/font-awesome.min.css">
    <!-- Bootst192rap -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    
    <!-- JS -->
    <script type="text/javascript" src="js/ion.sound-3.0.7/ion.sound.min.js"></script>
    <script type="text/javascript" src="js/jquery/jquery.js"></script>
    <script type="text/javascript" src="js/jquery/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/jquery.ui.touch-punch.min.js"></script>
    <script type="text/javascript" src="js/jquery.tabletoCSV.js"></script>
    <script type="text/javascript" src="js/jquery.bpopup.min.js"></script>
    <script type="text/javascript" src="js/query.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>
  <body class="lazy-man">
   <!-- Element to pop up -->
   <div id="element_to_pop_up"><img src='loading.gif'/></div>
   <div id="element_to_pop_up_content" class="content" style="height: auto; width: auto;"></div>
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
        
<center><b style='color: cyan !important;'> Điều khiển thiết bị</b>  


	</div>
      </div>
    </nav>
    <!-- Conainer -->
    <div class="container">

<!--Hien thi dau vao  =============================================-->
<label for="name"></label>
<?php
function show(){
echo'<script type="text/javascript"> //alert("qwrwqrtwq");
function bam(){
// alert("bam");
// <?php bamphp(); ?>
}
</script>';
}
show();
/*
$path = '/var/www/lazy/file/vao1.txt';
$fp = @fopen($path, "r");

// Kiểm tra file mở thành công không
if (!$fp) {
    echo 'Mở file không thành công';
}
else{
 // Lặp qua từng dòng để đọc
    while(!feof($fp))
    {
        echo fgets($fp);
    }
}*/
?>   
<!--========================================================-->

	 <div class="row">
     <div class="row">
     <b>>> Thiết bị vào</b>
     </div>
     <?php

        PrintObjectVao($conn);

    ?>
     </div>


	 <div class="row">
     
     <div class="row">
     <b>>> Thiết bị ra</b>
     </div>
        <div class="land-1">


<?php

	PrintObjectDatabase($conn);

?>

<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
<hr/>
<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12' style='padding:10px;text-align:right; margin: 5px; background-color: #c9d9e0;'><!--button id="export" data-export="export">Export (Top 20)</button--> (<a href='export.php' target='_blank'>Export - All</a>)</div>
<hr/>
<table class='tbllistitem' id="export_table"> 
    <tr>
        <th>
            Id
        </th>
        <!--th class='hidden'>
            Device Id
        </th -->
        <th>
            Name
        </th>
        <th>
            Status
        </th>
        <th>
            Start Date
        </th>
        <th>
            Finish Date
        </th>
    </tr>
<?php

PrintList($conn, 20);

?>

</table>
</div>


<!--
//<?php
//	PrintObjectSend();

//?>
-->



          <div class="clearfix"></div>  
        </div>
      </div>
    </div>
	  <div class="log-box alert alert-danger" role="alert">
			<strong>Woop !</strong>
			<p class="log-text">test demo alert log</p>
		</div>
  </body>
</html>

<?php 
	CloseDatabase($conn);
?>
