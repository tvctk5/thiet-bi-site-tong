<?php
session_start();
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="js/bootrap3.3/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="js/login/login.css">
    <script type="text/javascript" src="js/bootrap3.3/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootrap3.3/jquery-1.11.1.min.js"></script>
	<title>Trang đăng nhập</title>
	<meta charset="utf-8">
</head>
<body>
<?php
	//Gọi file connection.php ở bài trước
	require_once("sql/connection.php");
	// Kiểm tra nếu người dùng đã ân nút đăng nhập thì mới xử lý
	if (isset($_POST["btn_submit"])) {
		// lấy thông tin người dùng
		$username = $_POST["username"];
		$password = $_POST["password"];
		//làm sạch thông tin, xóa bỏ các tag html, ký tự đặc biệt 
		//mà người dùng cố tình thêm vào để tấn công theo phương thức sql injection
		$username = strip_tags($username);
		$username = addslashes($username);
		$password = strip_tags($password);
        $password = addslashes($password);
        #echo "User" . $username;
        #echo "Pass" . $password;

		if ($username == "" || $password =="") {
			echo "<div style='color:red;background-color: lavenderblush;padding: 10px;'>Username hoặc password bạn không được để trống!</div>";
		}else{
            $sql = "select * from user where username = '$username' and password = '$password' ";
            #echo $sql; 
			$query = mysqli_query($conn,$sql);
            $num_rows = mysqli_num_rows($query);
            //if ($result->num_rows > 0) {
            
			if ($num_rows==0) {
				echo "<div style='color:red;background-color: lavenderblush;padding: 10px;'>Tên đăng nhập hoặc mật khẩu không đúng !</div>";
			}else{
				//tiến hành lưu tên đăng nhập vào session để tiện xử lý sau này
				$_SESSION['username'] = $username;
                // Thực thi hành động sau khi lưu thông tin vào session
                // ở đây mình tiến hành chuyển hướng trang web tới một trang gọi là index.php
                header('Location: index.php');
			}
		}
	}
?>
<!--
    you can substitue the span of reauth email for a input with the email and
    include the remember me checkbox
    -->
    <div class="container">
        <div class="card card-container">
            <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
            <img id="profile-img" class="profile-img-card" src="/js/bootrap3.3/avatar_2x.png" />
            <p id="profile-name" class="profile-name-card"></p>
            <form class="form-signin" method="POST" action="login.php" >
                <input type="text" id="username" name="username" class="form-control" placeholder="Username" required autofocus>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
              
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" name="btn_submit" id="btn_submit">Đăng nhập</button>
            </form><!-- /form -->
        </div><!-- /card-container -->
    </div><!-- /container -->
</body>
</html>