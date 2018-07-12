<!-- 	Nguyen Hai Duong, September 2016 
 			GNU LESSER GENERAL PUBLIC LICENSE Version 2.1, February 1999
-->

<?php 

session_start();

include 'function/print-HTML.php';
include 'sql/sql-function.php';

//tiến hành kiểm tra là người dùng đã đăng nhập hay chưa
//nếu chưa, chuyển hướng người dùng ra lại trang đăng nhập
if (!isset($_SESSION['username'])) {
	 header('Location: login.php');
}

// Kiểm tra nếu người dùng đã ân nút đăng nhập thì mới xử lý
$start_date_search = '';
$end_date_search = '';

if (isset($_POST["btn_submit"])) {
    $start_date_search = (isset($_POST['start_date_search']) && $_POST['start_date_search'] != '') ? $_POST['start_date_search']: '';
    $end_date_search = (isset($_POST['end_date_search']) && $_POST['end_date_search'] != '') ? $_POST['end_date_search']: '';
    $page_size = (isset($_POST['page_size']) && $_POST['page_size'] != '') ? $_POST['page_size'] : '';

    header('Location: export.php?page=1&start_date='. $start_date_search . '&end_date='. $end_date_search. '&page_size='. $page_size);
    
    //echo '<script type="text/javascript">alert('. $start_date_search. ');</script>';
    //echo '<script type="text/javascript">alert('. $end_date_search. ');</script>';
    return;
}

$conn = ConnectDatabse();


$start_date = (isset($_GET['start_date']) && $_GET['start_date'] != '') ? $_GET['start_date'] : '';
$end_date = (isset($_GET['end_date']) && $_GET['end_date'] != '') ? $_GET['end_date'] : '';

$start_date_search = $start_date;
$end_date_search = $end_date;

if ($start_date != ''){
    $start_date = $start_date  . ' 00:00:00';
}

if ($end_date != ''){
    $end_date = $end_date  . ' 23:59:59' ;
}

$date_condition = '';
if($start_date != '' && $end_date != ''){
    $date_condition = " AND h.startdate between '" . $start_date . "' and '" . $end_date . "' ";
} else {
    if($start_date != ''){
        $date_condition = " AND h.startdate >= '" . $start_date . "'";
    }
    if($end_date != ''){
        $date_condition = " AND h.startdate <= '" . $end_date . "'";
    }
}

// BƯỚC 2: TÌM TỔNG SỐ RECORDS
$result = mysqli_query($conn, 'select count(h.id) as total FROM history h WHERE 1=1 ' . $date_condition);
$row = mysqli_fetch_assoc($result);
$total_records = $row['total'];

// BƯỚC 3: TÌM LIMIT VÀ CURRENT_PAGE
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$page_size_search = (isset($_GET['page_size']) && $_GET['page_size'] != '') ? $_GET['page_size'] : '20';
$limit = $total_records;
if($page_size_search != '0'){
    $limit = (int)$page_size_search;
}
// BƯỚC 4: TÍNH TOÁN TOTAL_PAGE VÀ START
// tổng số trang
$total_page = ceil($total_records / $limit);

// Giới hạn current_page trong khoảng 1 đến total_page
if ($current_page > $total_page){
    $current_page = $total_page;
}
else if ($current_page < 1){
    $current_page = 1;
}

// Tìm Start
$start = ($current_page - 1) * $limit;

// BƯỚC 5: TRUY VẤN LẤY DANH SÁCH TIN TỨC
// Có limit và start rồi thì truy vấn CSDL lấy danh sách tin tức
$result = mysqli_query($conn, "SELECT h.id, h.startdate, h.enddate, h.value, h.value as state, d.name, d.id as deviceid, d.objid FROM history h left join device d on h.deviceid = d.id  WHERE 1=1 " . $date_condition . "ORDER BY h.id DESC, h.startdate DESC LIMIT $start, $limit");

?>

<!DOCTYPE html>
<html lang="en"> 
  <head>
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="10000">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>History export</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome/css/font-awesome.min.css">
    <!-- Bootst192rap -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    
    <!-- JS -->
    <script type="text/javascript" src="js/jquery/jquery.js"></script>
    <script type="text/javascript" src="js/jquery.tabletoCSV.js"></script>
    <script type="text/javascript" src="js/query.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>
  <body class="lazy-man" style="padding-top:0px !important">
<!--========================================================-->

<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
<!--========================================================-->
<h2>LỊCH SỬ</h2>
<!--========================================================-->  
<hr/>
<form method="POST" action="export.php">
<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12' style='padding:10px;text-align:right; margin: 5px; background-color: #c9d9e0;'>
Từ ngày: 
<?php
echo '<input type="text" id="start_date_search" name="start_date_search" placeholder="yyyy-mm-dd" value="'. $start_date_search .'" />'
?>
Đến ngày: 
<?php
echo '<input type="text" id="end_date_search" name="end_date_search" placeholder="yyyy-mm-dd" value="'. $end_date_search .'" />'
?>
 Bản ghi: <select name="page_size" id="page_size">
 <?php
  echo '<option value="20" ' . ($page_size_search == '20'? 'selected' : '') .'>20</option>';
  echo '<option value="50" ' . ($page_size_search == '50'? 'selected' : '') .'>50</option>';
  echo '<option value="200" ' . ($page_size_search == '200'? 'selected' : '') .'>200</option>';
  echo '<option value="0" ' . ($page_size_search == '0'? 'selected' : '') .'>All</option>';
  ?>
</select> 
<button id="btn_submit" name="btn_submit" type="submit">Tìm kiếm</button> 
<button id="export" data-export="export">Export</button>
</div>
</form>
<hr/>
<table class='tbllistitem' id="export_table"> 
    <tr>
        <th>
            Id
        </th>
        <!--th>
            Device Id
        </th-->
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
// BƯỚC 6: HIỂN THỊ DANH SÁCH TIN TỨC
while ($row = mysqli_fetch_assoc($result)){
    PrintLine($row["id"], $row["type"], $row["name"], $row["state"], $row["flavor"], $row["amplitude"], $row["icon"], $row["deviceid"], $row["objid"], $row["value"], $row["startdate"], $row["enddate"]);
}
?>
<tr>
    <td colspan='10'>
        <div class="pagination">
        <?php 
            // PHẦN HIỂN THỊ PHÂN TRANG
            // BƯỚC 7: HIỂN THỊ PHÂN TRANG

            // nếu current_page > 1 và total_page > 1 mới hiển thị nút prev
            if ($current_page > 1 && $total_page > 1){
                echo '<a href="index.php?page='.($current_page-1).'&start_date='. $start_date_search .'&end_date='. $end_date_search .'&page_size='. $page_size_search .'">Prev</a> | ';
            }

            // Lặp khoảng giữa
            $overload = false;
            $flag = false;

            for ($i = 1; $i <= $total_page; $i++){
                if($total_page > 15){
                    $overload = true;
                }
                
                if($overload && $i != 1 && $i != 2 && $current_page != $i && $i != ($total_page -1) && $i != $total_page){
                    echo '...';
                    continue;
                }

                // Nếu là trang hiện tại thì hiển thị thẻ span
                // ngược lại hiển thị thẻ a
                if ($i == $current_page){
                    echo '<span>'.$i.'</span> | ';
                }
                else{
                    echo '<a href="?page='.$i.'&start_date='. $start_date_search .'&end_date='. $end_date_search .'&page_size='. $page_size_search .'">'.$i.'</a> | ';
                }
            }

            // nếu current_page < $total_page và total_page > 1 mới hiển thị nút prev
            if ($current_page < $total_page && $total_page > 1){
                echo '<a href="?page='.($current_page+1).'&start_date='. $start_date_search .'&end_date='. $end_date_search .'&page_size='. $page_size_search .'">Next</a> ';
            }
        ?>
        </div>
    </td>
</tr>
</table>

</div>

  </body>
</html>

<?php 
	CloseDatabase($conn);
?>
