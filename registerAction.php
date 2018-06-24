<?php
$email = htmlspecialchars($_POST['email']);
$password = $_POST['password'];
$passwordConfirm=$_POST['passwordConfirm'];
$name=$_POST['name'];
$gender=$_POST['gender'];
if($email==""||$password==""||$passwordConfirm==""||$name==""){
  echo "<script>alert('注册信息不能有空缺项，请重新填写。');history.go('-1');location.reload();</script>";
}
switch ($gender) {
  case "male":
    // code...
    $gender="男";
    break;
    case "female":
    $gender="女";
  default:
    // code...
    echo "<script>alert('请选择性别');history.go('-1');location.reload();</script>";
    break;
}

if($password!=$passwordConfirm){
  echo "<script>alert('两次输入密码不匹配。');history.go('-1');location.reload();</script>";
}

$connect = mysqli_connect('10.18.33.86','H_Z09415124','sujie1997','h_z09415124') or die('Unale to connect');
mysqli_query($connect,"set names utf8");
if (!$connect)
{
  die('Could not connect: ' . mysqli_error());
}
//检测用户名及密码是否正确
$sql="select * from user where email='$email'";
$check_query = mysqli_query($connect,$sql);
$result=mysqli_query($connect,$sql);
while($row = mysqli_fetch_array($result))
{
  if($row['id']){
    echo "<script>alert('该邮箱已被注册！');history.go('-1');location.reload();</script>";
  }
}
$sql="INSERT INTO user(email,password,name,gender) value('$email','$password','$name','$gender')";
echo $sql;
$result=mysqli_query($connect,$sql);
   if(!$result){
      die("Could not enter data:".mysql_error());
   }mysqli_close($connect);
   echo "Entered data successfully!";
echo "<script>alert('注册成功！');window.location.href=\"login.php\"; </script>";

?>
