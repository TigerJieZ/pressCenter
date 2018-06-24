<?php

$url= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
//1 用parse_url解析URL,此处是$str
$arr = parse_url($url);


//2 将URL中的参数取出来放到数组里
$arr_query = convertUrlQuery($arr['query']);
/**
  * Returns the url query as associative array
  * @param     string     query
  * @return     array     params
  */
function convertUrlQuery($query)
{
    $queryParts = explode('&', $query);
    $params = array();
    foreach ($queryParts as $param)
    {
        $item = explode('=', $param);
        $params[$item[0]] = $item[1];
    }
    return $params;
}

function getUrlQuery($array_query)
{
    $tmp = array();
    foreach($array_query as $k=>$param)
    {
        $tmp[] = $k.'='.$param;
    }
    $params = implode('&',$tmp);
    return $params;
}
$id=$arr_query['id'];

$connect = mysqli_connect('10.18.33.86','H_Z09415124','sujie1997','h_z09415124') or die('Unale to connect');
mysqli_query($connect,"set names utf8");
if (!$connect)
{
  die('Could not connect: ' . mysqli_error($connect));
}
$comment=$_POST['comment'];
$date=date("Y-m-d h:i:s",time());
$sql="INSERT INTO comments(context,newsID,date) value('$comment','$id','$date')";
$result=mysqli_query($connect,$sql);
echo $sql;
   if(!$result){
     echo mysql_error();
      die("Could not enter data:".mysqli_error($connect));
   }
   echo "Entered data successfully!";
   $sql="SELECT id from comments where date='$date'";
   echo $sql;
   $result = mysqli_query($connect,$sql);
   while($row = mysqli_fetch_array($result))
   {
     $commentID=$row['id'];
     echo $commentID;
   }

session_start();
$userID=$_SESSION['id'];
$sql="INSERT INTO comments_user value('$commentID','$userID')";
echo $sql;
$result=mysqli_query($connect,$sql);
   if(!$result){
      die("Could not enter data:".mysqli_error($connect));
   }mysqli_close($connect);
   echo "Entered data successfully!";

echo "<script>alert('评论成功');history.go('-1');location.reload();</script>";


 ?>
