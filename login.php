<?php
  require_once('connect.php');
  header("Content-type:text/html;charset=utf-8");
  $error_msg = "";

  if (!isset($_GET['user_id'])) {
    if (isset($_POST['submit'])) {
      if (isset($_POST['is_check'])) {

      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

      $userphone = mysqli_real_escape_string($dbc, trim($_POST['userphone']));
      $password = mysqli_real_escape_string($dbc, trim($_POST['password']));

      if (!empty($userphone) && !empty($password)) {
        $query = "SELECT user_id, userphone FROM user WHERE userphone = '$userphone' AND password = SHA('$password')";
        $data = mysqli_query($dbc, $query);

        if (mysqli_num_rows($data) == 1) {
          $row = mysqli_fetch_array($data);
          setcookie('user_id', $row['user_id'], time() + (60 * 60 * 24));    // expires in 1 day
          $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/menu.html';
          header('Location: ' . $home_url);
        }
        else {
		  echo "<script>alert('请输入正确的用户名和密码!');window.history.go(-1);</script>";
        }
      }
      else {
		echo "<script>alert('请输入用户名和密码!');window.history.go(-1);</script>";
      }
    }
    else{
      echo "<script>alert('请同意用户协议!');window.history.go(-1);</script>";
    }
  }
}
?>