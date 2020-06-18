<?php
  header("Content-type:text/html;charset=utf-8");
  require_once('connect.php');
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if (isset($_POST['submit'])) {
    if (isset($_POST['is_check'])) {
    $name = mysqli_real_escape_string($dbc, trim($_POST['name']));
    $password = mysqli_real_escape_string($dbc, trim($_POST['password']));
    $userphone = mysqli_real_escape_string($dbc, trim($_POST['userphone']));
    $code = mysqli_real_escape_string($dbc, trim($_POST['code']));
    if (!empty($name) && !empty($password) && !empty($userphone)&& !empty($code)) {
      $query = "SELECT * FROM user WHERE userphone = '$userphone'";
      $data = mysqli_query($dbc, $query);
      if (mysqli_num_rows($data) == 0) {
        $query = "INSERT INTO user (name, password, userphone) VALUES ('$name', SHA('$password'),'$userphone')";
        mysqli_query($dbc, $query);
        echo '<script language="JavaScript">;alert("注册成功！");location.href="login.html";</script>;';
        mysqli_close($dbc);
        exit();
      }
      else {   
        echo '<script language="JavaScript">;alert("该用户已注册，请登录!");location.href="login.html";</script>;';
        $name = "";
      }
    }
    else { 
        echo "<script>alert('请正确填写全部信息')</script>";        
    }
  }
  else{
    echo "<script>alert('请同意用户协议!');window.history.go(-1);</script>";
  }
}
  mysqli_close($dbc);
?>