<?php
$email = htmlspecialchars($_POST['email']);
$password = $_POST['password'];

$connect = mysqli_connect('localhost','root','','press') or die('Unale to connect');
mysqli_query($connect,"set names utf8");
if (!$connect)
{
  die('Could not connect: ' . mysqli_error());
}
//检测用户名及密码是否正确
$sql="select * from user where email='$email' and password='$password'";
$check_query = mysqli_query($connect,$sql);
if($result = mysqli_fetch_array($check_query)){
    //登录成功
    session_start();
    $_SESSION['email'] = $result['email'];
    $_SESSION['name'] = $result['name'];
    $_SESSION['id'] = $result['id'];
    echo $_SESSION['name'],' 欢迎你！进入 <a href="index.php">用户中心</a><br />';
    echo '点击此处 <a href="login.php?action=logout">注销</a> 登录！<br />';
    exit;
} else {
    exit('登录失败！点击此处 <a href="javascript:history.back(-1);">返回</a> 重试');
}
?>
