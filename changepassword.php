<?php
session_start();
//nếu chưa, chuyển hướng người dùng ra lại trang đăng nhập
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
}

?>
<html>
<head>
	<title>Trang đăng nhập</title>
	<meta charset="utf-8">
</head>
<body>
<?php
	//Gọi file connection.php ở bài trước
	require_once("sql/sql-function.php");
	// Kiểm tra nếu người dùng đã ân nút đăng nhập thì mới xử lý
	if (isset($_POST["btn_submit"])) {
		$conn = ConnectDatabse();

		// lấy thông tin người dùng
		$username = $_SESSION['username'];
        $password = $_POST["password"];
        $passwordnew1 = $_POST["passwordnew1"];
        $passwordnew2 = $_POST["passwordnew2"];
		//làm sạch thông tin, xóa bỏ các tag html, ký tự đặc biệt 
		//mà người dùng cố tình thêm vào để tấn công theo phương thức sql injection
		$passwordnew1 = strip_tags($passwordnew1);
        $passwordnew1 = addslashes($passwordnew1);
        $passwordnew2 = strip_tags($passwordnew2);
		$passwordnew2 = addslashes($passwordnew2);
		$password = strip_tags($password);
        $password = addslashes($password);
        #echo "User" . $username;
        #echo "Pass" . $password;

		if ($passwordnew1 == "" || $passwordnew2 == "" || $password =="") {
			echo "<div style='color:red;background-color: lavenderblush;padding: 10px;'>Password cũ và password mới bạn không được để trống!</div>";
        } else {
            if($passwordnew1 != $passwordnew2){
                echo "<div style='color:red;background-color: lavenderblush;padding: 10px;'>Password mới không trùng nhau</div>";
            }
            else{
                $sql = "select * from user where username = '$username' and password = '$password' ";
                #echo $sql; 
                $query = mysqli_query($conn,$sql);
                $num_rows = mysqli_num_rows($query);
                
                if ($num_rows==0) {
                    echo "<div style='color:red;background-color: lavenderblush;padding: 10px;'>Mật khẩu cũ không đúng !</div>";
                }else{
                    $sql = "update user set password='$passwordnew1' where username = '$username'";
					$query = mysqli_query($conn,$sql);
					// Close connection
					CloseDatabase($conn);

                    // Thực thi hành động sau khi lưu thông tin vào session
                    // ở đây mình tiến hành chuyển hướng trang web tới một trang gọi là index.php
                    header('Location: index.php');
                }
            }
		}
		
		// Close connection
		CloseDatabase($conn);
	}
?>
<form method="POST" action="changepassword.php">
	<fieldset>
	    <legend>Đổi mật khẩu</legend>
	    	<table>
	    		<tr>
	    			<td>Password cũ</td>
	    			<td><input type="password" name="password" size="30"></td>
	    		</tr>
	    		<tr>
	    			<td>Password mới</td>
	    			<td><input type="password" name="passwordnew1" size="30"></td>
	    		</tr>
	    		<tr>
	    			<td>Nhập lại Password mới</td>
	    			<td><input type="password" name="passwordnew2" size="30"></td>
	    		</tr>
	    		<tr>
	    			<td colspan="2" align="center"> <input name="btn_submit" type="submit" value="Đổi mật khẩu"></td>
	    		</tr>
	    	</table>
  </fieldset>
  </form>
</body>
</html>