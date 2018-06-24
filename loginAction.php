<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>exp2_1</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body><?php
$email = htmlspecialchars($_POST['email']);
$password = $_POST['password'];

$connect = mysqli_connect('10.18.33.86','H_Z09415124','sujie1997','h_z09415124') or die('Unale to connect');
mysqli_query($connect,"set names utf8");
if (!$connect)
{
  die('Could not connect: ' . mysqli_error());
}
//妫�娴嬬敤鎴峰悕鍙婂瘑鐮佹槸鍚︽纭�
$sql="select * from user where email='$email' and password='$password'";
$check_query = mysqli_query($connect,$sql);
if($result = mysqli_fetch_array($check_query)){
    //鐧诲綍鎴愬姛id
    session_start();
    $_SESSION['email'] = $result['email'];
    $_SESSION['name'] = $result['name'];
   $_SESSION['id'] = $result['id'];
    $_SESSION['permission']=$result['permission'];
    header("location:index.php");
    exit;
} else {
	echo "<script>alert('登录失败');history.go('-1');location.reload();</script>";
    header("location:login.php");
}
?>
</body>
</html>
