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

$connect = mysqli_connect('localhost','root','','press') or die('Unale to connect');
if (!$connect)
{
  die('Could not connect: ' . mysql_error());
}
$sql="UPDATE comments set state=0 where id=$id";

$result=mysqli_query($connect,$sql);
echo $sql;
   if(!$result){
     echo mysql_error();
      die("Could not enter data:".mysql_error());
   }mysqli_close($connect);
   echo "Entered data successfully!";
echo "<script>alert('审批成功');history.go('-1');location.reload();</script>";

 ?>
